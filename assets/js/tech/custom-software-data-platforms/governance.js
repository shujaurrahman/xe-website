/* Custom Software & Data Platforms · governance — the data catalogue engine. State is the classification of
   each column (none · proposed · approved · policy · rejected), the steward queue (waiting · done · rejected),
   which lineage row is lit and whether the deletion request has run. The steward buttons and "Run classifier"
   work at once. While the window is on screen and untouched it tours: the classifier sweeps the columns and
   proposes tags, the steward approves two, the lineage answers two questions, the deletion request runs across
   four systems with receipts. Any press stops the tour and restores the finished state from the HTML.
   Reduced motion: no tour, no sweep timing; every control applies its result immediately. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tcs-governance'); if (!root) return;
  var win = root.querySelector('.tcs-gv__win'); if (!win) return;
  var R = BDH.reduced;
  var $ = function (s) { return root.querySelector(s); }, $$ = function (s) { return BDH.$$(s, root); };
  var cols = $$('.tcs-gv__c'), queue = $$('.tcs-gv__qi'), lins = $$('.tcs-gv__lr'), sys = $$('.tcs-gv__sys li');
  var agentEl = $('[data-gv-agent]'), taggedEl = $('[data-gv-tagged]'), qnEl = $('[data-gv-qn]'), status = $('[data-gv-status]');
  var linNote = $('[data-gv-linnote]'), askQ = $('[data-gv-q]'), askA = $('[data-gv-a]'), evEl = $('[data-gv-ev]'), runBtn = $('[data-gv-run]');
  var COL_OF = { email: 'email', pan: 'pan_last4', phone: 'phone_e164', dob: 'date_of_birth' };
  var LIN_OF = { email: 'email', pan_last4: 'pan', lifetime_value: 'ltv' };
  var ASK = {
    email: ['Where does the email in Active customers come from, and is it masked?', 'dim_customer.email_hash ← silver.customers.email ← bronze.contacts_raw.email ← crm.contacts.email. SHA-256 hashed in gold, masked in non-prod since 02:14. Owner: growth. 1 consumer, 4 sources cited.'],
    pan:   ['Which reports can see card data, and who owns them?', 'pan_last4 reaches one report: Chargeback report (finance). Restricted to the finance role since 02:14. Source: payments.card.last4 via bronze.payments_raw. Full card numbers stay with the payment provider, which keeps this platform out of cardholder-data scope.'],
    ltv:   ['If we change how refunds are counted, what breaks?', 'silver.orders.total feeds gold.dim_customer.ltv, 3 segments (reverse ETL to the CRM) and 2 dashboards. Contract silver.orders v3 is pinned by 4 consumers; a change needs v4 and their sign-off.']
  };
  var RECEIPTS = ['a91c…', '4e07…', 'c2f8…', '77d1…'];
  var touring = false, typer = null, dsrTimers = [];

  /* ---------------------------------------------------------------- painters */
  function setCol(li, state) {
    var tag = li.querySelector('[data-gv-tag]'), conf = li.querySelector('[data-gv-conf]');
    var t = li.getAttribute('data-tag') || '', c = parseFloat(li.getAttribute('data-conf')) || 0;
    if (!t) state = 'none';
    li.className = 'tcs-gv__c is-' + state;
    li.setAttribute('data-state', state);
    if (tag) tag.textContent = state === 'none' ? '—' : t;
    if (conf) conf.textContent = state === 'none' || !c ? '' : c.toFixed(2);
  }
  function colByName(name) { for (var i = 0; i < cols.length; i++) if (cols[i].getAttribute('data-col') === name) return cols[i]; return null; }
  function plural(n, one, many) { return n + ' ' + (n === 1 ? one : many); }
  function counts() {
    var c = { tagged: 0, proposals: 0, policy: 0, waiting: 0 };
    cols.forEach(function (li) {
      var s = li.getAttribute('data-state');
      if (s === 'approved' || s === 'policy' || s === 'proposed') c.tagged++;
      if (s === 'proposed') c.proposals++;
      if (s === 'policy') c.policy++;
    });
    queue.forEach(function (q) { if (q.classList.contains('is-waiting')) c.waiting++; });
    if (taggedEl) taggedEl.textContent = c.tagged + ' of ' + cols.length + ' classified';
    if (qnEl) qnEl.textContent = c.waiting ? c.waiting + ' waiting' : 'empty';
    if (agentEl) agentEl.textContent = 'classifier v4 · ' + plural(c.proposals, 'proposal', 'proposals') + ' · ' + c.policy + ' approved by policy';
    return c;
  }
  function say(t) { if (status) status.textContent = t; }
  function setQueue(q, state, text) {
    q.classList.remove('is-waiting', 'is-done', 'is-rejected');
    q.classList.add('is-' + state);
    var d = q.querySelector('[data-gv-qd]'); if (d) d.textContent = text || '';
  }
  function decide(key, decision, time, byPerson) {
    var q = null; queue.forEach(function (x) { if (x.getAttribute('data-q') === key) q = x; });
    if (!q) return;
    var kind = q.getAttribute('data-kind'), col = COL_OF[key] ? colByName(COL_OF[key]) : null, tag = col ? col.getAttribute('data-tag') : '';
    var ok = decision === 'approve';
    setQueue(q, ok ? 'done' : 'rejected', (ok ? (kind === 'tag' ? 'Approved' : 'Accepted') : (kind === 'tag' ? 'Rejected' : 'Sent back')) + ' · data_steward · ' + time);
    if (col) setCol(col, ok ? 'approved' : 'rejected');
    if (kind === 'tag') say((ok ? 'Steward approved ' : 'Steward rejected ') + COL_OF[key] + ' → ' + tag + (ok ? (key === 'pan' ? ' · restricted to finance role' : ' · masked in non-prod') : ' · proposal discarded') + ' · logged ' + time + ':' + (byPerson ? '31' : '07'));
    else say((ok ? 'Steward accepted ' : 'Steward sent back ') + q.querySelector('.tcs-gv__qt').textContent + ' · logged ' + time + ':' + (byPerson ? '31' : '07'));
    counts();
  }
  function showLin(key, animate) {
    lins.forEach(function (r) { r.classList.toggle('is-on', r.getAttribute('data-lin') === key); });
    var name = { email: 'email', pan: 'pan_last4', ltv: 'lifetime_value' }[key] || key;
    if (linNote) linNote.textContent = name + ' · source to use';
    var qa = ASK[key]; if (!qa || !askQ || !askA) return;
    if (typer) { typer.stop(); typer = null; }
    if (!animate || R) { askQ.textContent = qa[0]; askA.textContent = qa[1]; return; }
    askA.textContent = '';
    typer = BDH.type(askQ, qa[0], { speed: 18, done: function () { typer = BDH.type(askA, qa[1], { speed: 6, delay: 260 }); } });
  }
  function dsrPaint(doneUpTo, running) {
    sys.forEach(function (li, i) {
      li.classList.toggle('is-done', i < doneUpTo);
      li.classList.toggle('is-run', i === running);
      var r = li.querySelector('[data-gv-sr]'); if (r) r.textContent = i < doneUpTo ? 'receipt · ' + RECEIPTS[i] : (i === running ? 'deleting…' : 'queued');
    });
    if (evEl) evEl.textContent = doneUpTo >= sys.length ? 'Evidence bundle e7c1…3a sealed · 4 of 4 systems · 38 s' : (doneUpTo ? doneUpTo + ' of 4 receipts · bundle open' : 'Waiting to run · DSR-1042 verified against the consent record');
  }
  function clearDsr() { dsrTimers.forEach(clearTimeout); dsrTimers = []; }
  function runDSR() {
    clearDsr();
    if (R) { dsrPaint(sys.length, -1); return; }
    dsrPaint(0, 0);
    sys.forEach(function (_, i) {
      dsrTimers.push(setTimeout(function () { dsrPaint(i + 1, i + 1 < sys.length ? i + 1 : -1); if (i + 1 === sys.length) say('Deletion DSR-1042 complete · 4 receipts sealed into evidence bundle e7c1…3a · 38 s'); }, 700 * (i + 1)));
    });
  }

  /* ---------------------------------------------------------------- states */
  function finished() {
    cols.forEach(function (li) {
      var n = li.getAttribute('data-col');
      setCol(li, n === 'email' || n === 'pan_last4' ? 'approved' : (n === 'lifetime_value' || n === 'consent_marketing' ? 'policy' : (li.getAttribute('data-tag') ? 'proposed' : 'none')));
      li.classList.remove('is-scan', 'is-hot');
    });
    queue.forEach(function (q) { var k = q.getAttribute('data-q'); setQueue(q, k === 'email' || k === 'pan' ? 'done' : 'waiting', k === 'email' || k === 'pan' ? 'Approved · data_steward · 02:14' : ''); });
    clearDsr(); dsrPaint(sys.length, -1);
    showLin('email', false);
    counts();
    say('Steward approved pan_last4 → Payment.truncated · restricted to finance role · logged 02:14:07');
  }
  function start() {
    cols.forEach(function (li) { setCol(li, 'none'); li.classList.remove('is-scan', 'is-hot'); });
    queue.forEach(function (q) { setQueue(q, 'waiting', ''); });
    clearDsr(); dsrPaint(0, -1);
    showLin('email', false);
    counts();
    if (agentEl) agentEl.textContent = 'classifier v4 · scanning silver.customers';
    say('Classifier v4 reading names, types, sources and 1,000 sampled values per column…');
  }
  function sweepStep(i) {
    cols.forEach(function (li, k) { li.classList.toggle('is-scan', k === i); });
    var li = cols[i]; if (!li) return;
    var n = li.getAttribute('data-col');
    setCol(li, n === 'lifetime_value' || n === 'consent_marketing' ? 'policy' : (li.getAttribute('data-tag') ? 'proposed' : 'none'));
    li.classList.toggle('is-scan', true);
    counts();
  }
  /* a proposal only goes (back) to the queue while its column is still just proposed: decisions already made stand */
  function sweepDone() {
    cols.forEach(function (li) { li.classList.remove('is-scan'); });
    queue.forEach(function (q) {
      if (q.getAttribute('data-kind') !== 'tag' || q.classList.contains('is-done') || q.classList.contains('is-rejected')) return;
      var col = colByName(COL_OF[q.getAttribute('data-q')] || '');
      if (col && col.getAttribute('data-state') === 'proposed') setQueue(q, 'waiting', '');
    });
    var c = counts();
    say('Scan complete · ' + (c.proposals ? plural(c.proposals, 'proposal', 'proposals') + ' waiting for a steward' : 'no new proposals') + ' · ' + plural(c.policy, 'tag', 'tags') + ' approved by policy · nothing applied silently');
  }

  /* ---------------------------------------------------------------- controls */
  $$('[data-gv-decide]').forEach(function (b) {
    b.addEventListener('click', function () {
      var d = new Date(), hh = ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2);
      if (!R) { b.classList.add('is-press'); setTimeout(function () { b.classList.remove('is-press'); }, 220); }
      decide(b.getAttribute('data-for'), b.getAttribute('data-gv-decide'), hh, true);
    });
  });
  if (runBtn) runBtn.addEventListener('click', function () {
    runBtn.disabled = true;
    cols.forEach(function (li) { if (li.getAttribute('data-state') !== 'approved' && li.getAttribute('data-state') !== 'rejected') setCol(li, 'none'); });
    queue.forEach(function (q) { if (q.getAttribute('data-kind') === 'tag' && !q.classList.contains('is-done') && !q.classList.contains('is-rejected')) setQueue(q, 'waiting', ''); });
    counts();
    say('Classifier v4 re-reading silver.customers…');
    if (R) {
      cols.forEach(function (li) { if (li.getAttribute('data-state') === 'none') sweepStep(cols.indexOf(li)); });
      sweepDone(); runBtn.disabled = false; return;
    }
    var i = 0;
    (function tick() {
      if (i < cols.length) { if (cols[i].getAttribute('data-state') !== 'approved' && cols[i].getAttribute('data-state') !== 'rejected') sweepStep(i); else cols.forEach(function (li, k) { li.classList.toggle('is-scan', k === i); }); i++; setTimeout(tick, 240); }
      else { sweepDone(); runBtn.disabled = false; }
    })();
  });
  cols.forEach(function (li) {
    var k = LIN_OF[li.getAttribute('data-col')]; if (!k) return;
    li.setAttribute('title', 'Lineage of ' + li.getAttribute('data-col'));
    li.addEventListener('pointerenter', function () { if (!touring) showLin(k, false); });
  });

  finished();
  if (R) return;

  /* ---------------------------------------------------------------- tour */
  var steps = [[900, function () { touring = true; start(); }]];
  cols.forEach(function (_, i) { steps.push([i === 0 ? 700 : 300, function () { sweepStep(i); }]); });
  steps.push([500, sweepDone]);
  steps.push([1700, function () { cols.forEach(function (li) { li.classList.toggle('is-hot', li.getAttribute('data-col') === 'email'); }); decide('email', 'approve', '02:14'); }]);
  steps.push([1500, function () { cols.forEach(function (li) { li.classList.toggle('is-hot', li.getAttribute('data-col') === 'pan_last4'); }); decide('pan', 'approve', '02:14'); }]);
  steps.push([1600, function () { cols.forEach(function (li) { li.classList.remove('is-hot'); }); showLin('pan', true); say('Lineage answered from the models themselves · pan_last4 · 5 hops · 1 consumer'); }]);
  steps.push([4200, function () { showLin('ltv', true); say('Lineage answered · lifetime_value · 4 consumers pinned to contract v3'); }]);
  steps.push([4400, function () { say('Deletion request DSR-1042 running · subject 9b2e…41 · 4 systems in order'); runDSR(); }]);
  steps.push([4200, function () { showLin('email', true); }]);
  steps.push([3200, function () {}]);
  BDH.inView(win, function () {
    BDH.seq(win, steps, { loop: true, stopOnInteract: true, interactRoot: win, onStop: function () { touring = false; if (typer) { typer.stop(); typer = null; } finished(); } });
  }, { threshold: 0.1 });   // low: on phones the catalogue window is several screens tall
})();
