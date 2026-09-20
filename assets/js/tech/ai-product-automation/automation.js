/* AI Product & Automation · automation — runs accounts-payable workflows on the node graph.
   Run type A (over the limit): classify → extract → validate times out, retries with backoff and passes →
   branch yes → the approval gate WAITS for a person (Approve / Reject are real buttons). If nobody decides
   within 9 s the run is parked as "waiting for approval" and a straight-through run B starts instead;
   approval is never automated. Timers count only while the section is on screen; Pause stops them.
   Reduced motion: no autoplay and no travelling token; "Start a run" (the pause button) steps instantly and
   the gate still waits for a click. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var sec = document.querySelector('.tap-automation'); if (!sec) return;
  var R = BDH.reduced;
  var $ = function (s) { return sec.querySelector(s); };
  var nodes = {}, edges = {};
  BDH.$$('[data-node]', sec).forEach(function (n) { nodes[n.getAttribute('data-node')] = n; });
  BDH.$$('[data-edge]', sec).forEach(function (p) { edges[p.getAttribute('data-edge')] = p; });
  var tokg = $('.tap-auto__tokg');
  var logEl = $('[data-auto-log]'), runEl = $('[data-auto-run]'), statusEl = $('[data-auto-status]');
  var gate = $('[data-auto-gate]'), gtext = $('[data-auto-gtext]'), approveBtn = $('[data-auto-approve]'), rejectBtn = $('[data-auto-reject]');
  var toggle = $('[data-auto-toggle]'), tbody = $('[data-auto-runs]'), live = $('[data-auto-live]');

  /* ---- a clock that only runs while the section is visible and not paused ---- */
  var jobs = [], vis = false, paused = false, clock = null, last = 0;
  function tick() {
    var now = Date.now(), dt = now - last; last = now;
    jobs.slice().forEach(function (j) {
      j.t -= dt;
      if (j.t <= 0) { jobs.splice(jobs.indexOf(j), 1); j.fn(); }
    });
  }
  function sync() {
    var on = (vis || R) && !paused;
    if (on && !clock) { last = Date.now(); clock = setInterval(tick, 40); }
    if (!on && clock) { clearInterval(clock); clock = null; }
  }
  function after(ms, fn) { jobs.push({ t: R ? 0 : ms, fn: fn }); sync(); }
  function clearJobs() { jobs = []; }
  BDH.watch(sec, function (on) { vis = on; sync(); }, { threshold: 0.12 });
  BDH.live(sec, 0.12);

  /* ---- on narrow screens the graph scrolls sideways: keep the active node in view,
     unless the visitor scrolled it themselves in the last 8 seconds ---- */
  var scroller = $('.tap-auto__scroll'), svgEl = $('.tap-auto__svg'), userScroll = 0;
  if (scroller) ['pointerdown', 'touchstart', 'wheel'].forEach(function (ev) {
    scroller.addEventListener(ev, function () { userScroll = Date.now(); }, { passive: true });
  });
  function follow(k) {
    var n = nodes[k];
    if (!n || !scroller || !svgEl || !vis) return;
    if (scroller.scrollWidth <= scroller.clientWidth + 4 || Date.now() - userScroll < 8000) return;
    var m = /translate\(([\d.]+)/.exec(n.getAttribute('transform') || '');
    if (!m) return;
    var sr = svgEl.getBoundingClientRect(), cr = scroller.getBoundingClientRect();
    var cx = sr.left - cr.left + scroller.scrollLeft + (parseFloat(m[1]) + 90) * (sr.width / 1200);
    scroller.scrollTo({ left: Math.max(0, cx - scroller.clientWidth / 2), behavior: R ? 'auto' : 'smooth' });
  }

  /* ---- visuals ---- */
  function node(k, st, sub) {
    var n = nodes[k]; if (!n) return;
    n.setAttribute('class', 'tap-auto__n is-' + st);
    if (sub != null) n.querySelector('[data-sub]').textContent = sub;
    if (st === 'active' || st === 'wait') follow(k);
  }
  function lit(k, on) { var e = edges[k]; if (e) e.classList.toggle('is-lit', on); }
  var moving = null;
  function move(k, dur) {
    var p = edges[k]; if (!p || !tokg) return;
    lit(k, true);
    if (R) return;
    if (moving) cancelAnimationFrame(moving);
    var len = p.getTotalLength(), t0 = null;
    tokg.classList.add('is-on');
    moving = requestAnimationFrame(function step(ts) {
      if (t0 === null) t0 = ts;
      var q = Math.min(1, (ts - t0) / dur), k2 = q < 0.5 ? 2 * q * q : 1 - Math.pow(-2 * q + 2, 2) / 2;
      var pt = p.getPointAtLength(len * k2);
      tokg.setAttribute('transform', 'translate(' + pt.x.toFixed(1) + ' ' + pt.y.toFixed(1) + ')');
      if (q < 1) moving = requestAnimationFrame(step); else { moving = null; tokg.classList.remove('is-on'); }
    });
  }
  var clockStr = (function () { var s = 9 * 3600 + 52 * 60; return function (add) { s += add || 0; var h = Math.floor(s / 3600), m = Math.floor(s / 60) % 60, sec2 = s % 60; return pad(h) + ':' + pad(m) + ':' + pad(sec2) + '.' + String(100 + Math.floor(Math.random() * 899)); }; })();
  function pad(n) { return n < 10 ? '0' + n : String(n); }
  function log(stage, text, err) {
    var li = document.createElement('li');
    li.innerHTML = '<time></time><b></b><span></span>';
    li.children[0].textContent = clockStr(1); li.children[1].textContent = stage; li.children[2].textContent = text;
    if (err) li.classList.add('is-err');
    if (!R) li.classList.add('is-new');
    logEl.appendChild(li);
    while (logEl.children.length > 11) logEl.removeChild(logEl.firstElementChild);
  }
  function status(text, led) { statusEl.innerHTML = '<span class="tap-led' + (led ? ' ' + led : '') + '"></span>'; statusEl.appendChild(document.createTextNode(text)); }
  function row(cells, kind) {
    var tr = document.createElement('tr');
    tr.className = 'is-' + kind + (R ? '' : ' is-new');
    tr.innerHTML = '<th scope="row"><code></code><span></span></th><td></td><td></td><td></td><td></td><td><span class="tap-auto__st"><i></i></span></td>';
    tr.querySelector('code').textContent = cells[0];
    tr.querySelector('th span').textContent = cells[1];
    var tds = tr.querySelectorAll('td');
    for (var i = 0; i < 4; i++) tds[i].textContent = cells[i + 2];
    tds[4].querySelector('.tap-auto__st').appendChild(document.createTextNode(cells[6]));
    tbody.insertBefore(tr, tbody.firstChild);
    while (tbody.children.length > 5) tbody.removeChild(tbody.lastElementChild);
  }
  function setGate(waiting, text) {
    gate.classList.toggle('is-wait', waiting);
    gtext.textContent = text;
    approveBtn.disabled = !waiting; rejectBtn.disabled = !waiting;
  }

  /* ---- runs ---- */
  var seqNo = 2291, inv = 88412, cur = null, gateTimer = null, started = false;
  function fresh(amount) {
    seqNo++; inv += 3 + Math.floor(Math.random() * 5);
    cur = { id: 'r-' + seqNo, file: 'inv-' + inv + '.pdf', amount: amount, t: 0, retries: 0 };
    Object.keys(nodes).forEach(function (k) { node(k, 'idle'); });
    Object.keys(edges).forEach(function (k) { lit(k, false); edges[k].classList.remove('is-off'); });
    sec.classList.remove('is-retry');
    runEl.textContent = cur.id;
    /* keep the previous run's last six lines, dimmed, above a divider for the new run */
    BDH.$$('.tap-auto__div, .is-prev', logEl).forEach(function (li) { logEl.removeChild(li); });
    var keep = BDH.$$('li', logEl).slice(-6);
    logEl.innerHTML = '';
    keep.forEach(function (li) { li.classList.remove('is-new', 'is-err'); li.classList.add('is-prev'); logEl.appendChild(li); });
    var dv = document.createElement('li');
    dv.className = 'tap-auto__div'; dv.textContent = cur.id + ' started';
    logEl.appendChild(dv);
    setGate(false, 'Approval gate · idle');
    status(cur.id + ' · running', 'tap-led--pulse');
  }
  function chain(steps, done) {
    var i = 0;
    (function next() {
      if (i >= steps.length) { if (done) done(); return; }
      var s = steps[i++];
      after(s[0], function () { s[1](); cur.t += s[0]; next(); });
    })();
  }
  function head(amountStr, over) {
    return [
      [300,  function () { node('trigger', 'active', 'ap@your-company · 1 PDF'); log('trigger', 'email received · ' + cur.file); }],
      [800,  function () { node('trigger', 'done'); move('e1', 550); }],
      [600,  function () { node('classify', 'active', 'reading…'); }],
      [700,  function () { node('classify', 'done', 'invoice · 0.98'); log('classify', 'invoice · 0.98 · small model'); move('e2', 550); }],
      [600,  function () { node('extract', 'active', 'reading fields…'); }],
      [900,  function () { node('extract', 'done', '12 fields · min 0.95'); log('extract', '12 fields · min confidence 0.95'); move('e3', 550); }],
      [600,  function () { node('validate', 'active', 'ERP lookup…'); }]
    ].concat(over ? [
      [900,  function () { node('validate', 'fail', 'timeout · retry in 2 s'); sec.classList.add('is-retry'); cur.retries = 1; log('validate', 'ERP lookup timed out · retry 1 in 2 s', true); }],
      [2000, function () { node('validate', 'active', 'retry 1 · ERP lookup…'); }],
      [800,  function () { sec.classList.remove('is-retry'); node('validate', 'done', 'PO matched · 3-way ok'); log('validate', 'PO matched · 3-way match ok'); move('e4', 550); }]
    ] : [
      [800,  function () { node('validate', 'done', 'PO matched · 3-way ok'); log('validate', 'PO matched · 3-way match ok'); move('e4', 550); }]
    ]).concat([
      [600,  function () { node('branch', 'active', amountStr + (over ? ' · yes' : ' · no')); log('branch', amountStr + (over ? ' over ₹2,00,000 · approval required' : ' under ₹2,00,000 · straight-through')); }]
    ]);
  }
  function tail(approvedBy) {
    return [
      [0,   function () { move(approvedBy ? 'e6' : 'e9', approvedBy ? 450 : 750); }],
      [approvedBy ? 500 : 800, function () { node('post', 'active', 'posting…'); }],
      [700, function () { node('post', 'done', 'doc 51000' + (seqNo % 90 + 10) + ' · idempotent'); log('post', 'ERP document posted · key ' + cur.file.replace('.pdf', '')); move('e7', 450); }],
      [500, function () { node('notify', 'active', 'sending…'); }],
      [500, function () { node('notify', 'done', '#ap-approvals · sent'); log('notify', '#ap-approvals · message sent'); move('e8', 450); }],
      [500, function () { node('audit', 'active', 'closing…'); }],
      [500, function () {
        node('audit', 'done', cur.id + ' · ' + (approvedBy ? 14 : 11) + ' events');
        log('audit', 'run ' + cur.id + ' closed');
        var secs = Math.round(cur.t / 1000) + (approvedBy ? 180 : 30);
        row([cur.id, cur.file, cur.amount, approvedBy ? 'Approval' : 'Straight-through', secs >= 60 ? Math.floor(secs / 60) + ' m ' + pad(secs % 60) + ' s' : secs + ' s', String(cur.retries), approvedBy ? 'Posted · approved' : 'Posted'], 'ok');
        status(cur.id + ' · completed');
      }]
    ];
  }

  function runStraight() {
    var amt = ['₹48,200', '₹96,450', '₹1,24,900', '₹61,300'][seqNo % 4];
    fresh(amt);
    chain(head(amt, false).concat([
      [700, function () { node('branch', 'done'); node('approval', 'skip', 'not needed'); edges.e5.classList.add('is-off'); }]
    ]).concat(tail(null)), function () { after(3800, runApproval); });
  }

  function runApproval() {
    var amt = ['₹3,40,000', '₹2,86,500', '₹4,12,000'][seqNo % 3];
    fresh(amt);
    chain(head(amt, true).concat([
      [700, function () { node('branch', 'done'); edges.e9.classList.add('is-off'); move('e5', 600); }],
      [650, function () {
        node('approval', 'wait', 'waiting · Finance lead');
        log('approval', 'waiting for Finance lead');
        setGate(true, 'Approve ' + cur.amount + ' for ' + cur.file + '?');
        status(cur.id + ' · waiting for approval', 'tap-led--wait');
        if (live) live.textContent = 'Run ' + cur.id + ' is waiting for approval of ' + cur.amount + '. Approve or reject it.';
        gateTimer = { t: R ? 1e12 : 9000, fn: park };
        jobs.push(gateTimer); sync();
      }]
    ]));
  }
  function decide(ok) {
    if (!gate.classList.contains('is-wait')) return;
    if (gateTimer) { var i = jobs.indexOf(gateTimer); if (i > -1) jobs.splice(i, 1); gateTimer = null; }
    if (ok) {
      node('approval', 'done', 'approved by you');
      log('approval', 'approved by Finance lead (you)');
      setGate(false, 'Approval gate · ' + cur.amount + ' · approved by you');
      if (live) live.textContent = 'Approved. Run ' + cur.id + ' is posting to the ERP.';
      chain(tail('you'), function () { after(4200, runStraight); });
    } else {
      node('approval', 'fail', 'rejected · returned');
      log('approval', 'rejected · returned to AP clerk with reason', true);
      setGate(false, 'Approval gate · ' + cur.amount + ' · rejected by you');
      chain([
        [600, function () { move('e8', 1); node('audit', 'done', cur.id + ' · rejected'); log('audit', 'run ' + cur.id + ' closed · nothing posted'); }],
        [300, function () { row([cur.id, cur.file, cur.amount, 'Approval', '—', String(cur.retries), 'Rejected · returned'], 'rej'); status(cur.id + ' · rejected'); if (live) live.textContent = 'Rejected. Nothing was posted.'; }]
      ], function () { after(4200, runStraight); });
    }
  }
  function park() {
    gateTimer = null;
    log('approval', 'no decision yet · reminder sent · SLA 4 h');
    row([cur.id, cur.file, cur.amount, 'Approval', '—', String(cur.retries), 'Waiting for approval'], 'wait');
    setGate(false, 'Approval gate · ' + cur.id + ' parked · reminder sent');
    status(cur.id + ' · parked', 'tap-led--wait');
    after(2600, runStraight);
  }

  approveBtn.addEventListener('click', function () { decide(true); });
  rejectBtn.addEventListener('click', function () { decide(false); });

  function begin() { if (started) return; started = true; runApproval(); }
  if (toggle) {
    toggle.hidden = false;
    if (R) toggle.textContent = 'Start a run';
    toggle.addEventListener('click', function () {
      if (!started) { begin(); if (R) toggle.hidden = true; return; }
      paused = !paused; sync();
      toggle.textContent = paused ? 'Resume runs' : 'Pause runs';
      toggle.setAttribute('aria-pressed', String(paused));
    });
  }
  if (R) return;
  BDH.inView(sec.querySelector('.tap-auto'), begin, { threshold: 0.3 });
})();
