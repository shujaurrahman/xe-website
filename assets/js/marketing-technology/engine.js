/* The always-on engine: replays the journey rules live. Rules mirror mth_engine_eval() in
   partials/marketing-technology/engine.php. Loops only while on screen and until the visitor takes control. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-mth-engine]');
  if (!root) return;
  var cfgEl = root.querySelector('.mth-eng__cfg');
  var cfg; try { cfg = JSON.parse(cfgEl.textContent); } catch (e) { return; }

  var CH = cfg.channels, NODES = cfg.nodes, J = cfg.journeys;
  var ORDER = ['email', 'wa', 'sms'];
  var STATE = { ok: 'Passed', hold: 'Held', stop: 'Exited', wait: 'Approval' };
  var nodesEl = root.querySelectorAll('.mth-node');
  var logEl = root.querySelector('[data-log]');
  var queueEl = root.querySelector('[data-queue]');
  var qEmpty = root.querySelector('[data-qempty]');
  var qN = root.querySelector('[data-qn]');
  var clockEl = root.querySelector('.mth-eng__clock');
  var runBtn = root.querySelector('[data-act="run"]');
  var jBtns = root.querySelectorAll('.mth-eng__jb');

  var jk = 'winback', people = [], clock = 9 * 3600 + 58 * 60, timer = null, running = false, touched = false, onScreen = false, rr = 0, idle = null;

  function pad(n) { return (n < 10 ? '0' : '') + n; }
  function hms(t) { return pad(Math.floor(t / 3600) % 24) + ':' + pad(Math.floor(t / 60) % 60) + ':' + pad(t % 60); }
  function fx(n) { return n.toFixed(2); }

  function action(p) {
    if (jk === 'cart') return p.ps ? 'reminder + 10% code' : (p.val === 'high' ? 'reminder + free delivery' : 'reminder');
    if (jk === 'onboard') return p.seg.indexOf('New') === 0 ? 'setup guide, variant v3 (AI draft)' : 'setup guide';
    return p.val === 'high' ? '15% return offer' : 'what’s-new digest';
  }
  function sensitive(p) {
    if (jk === 'cart') return !!p.ps;
    if (jk === 'onboard') return p.seg.indexOf('New') === 0;
    return p.val === 'high';
  }
  function evaluate(p) {
    var j = J[jk], out = [];
    out.push([0, 'ok', 'Entered on ' + j.trigger]);
    var has = ORDER.filter(function (k) { return p.c[k]; });
    // keep the PHP order (email, wa, sms) for the listing
    if (!has.length) { out.push([1, 'stop', 'No marketing consent on any channel · suppressed, nothing sent']); return out; }
    out.push([1, 'ok', 'Consent valid for marketing · ' + has.map(function (k) { return CH[k]; }).join(', ')]);
    if (p.ho) { out.push([2, 'stop', 'In the 10% holdout · no message, counted for lift']); return out; }
    var use = has.indexOf(p.pref) > -1 ? p.pref : has[0];
    var act = action(p);
    out.push(p.cf < 0.6
      ? [2, 'ok', 'Confidence ' + fx(p.cf) + ' below 0.60 · rule-based fallback: ' + act + ' by ' + CH[use]]
      : [2, 'ok', 'Next best action: ' + act + ' by ' + CH[use] + ' · confidence ' + fx(p.cf)]);
    if (p.n7 >= 3) { out.push([3, 'stop', 'Frequency cap reached · 3 in 7 days · deferred']); return out; }
    out.push((p.hr >= 21 || p.hr < 9)
      ? [3, 'hold', 'Quiet hours at ' + pad(p.hr) + ':00 local · queued until 09:00']
      : [3, 'ok', 'Within limits · ' + p.n7 + ' of 3 this week, outside quiet hours']);
    if (sensitive(p)) { out.push([4, 'wait', 'Waiting for a person · ' + j.rule]); return out; }
    out.push([4, 'ok', 'Nothing sensitive · template approved once, monitored']);
    out.push([5, 'ok', 'Sent by ' + CH[use] + ' · ' + j.tpl]);
    return out;
  }

  function fresh() {
    people = cfg.profiles.map(function (p) {
      var q = JSON.parse(JSON.stringify(p));
      return { p: q, steps: evaluate(q), cur: 0, row: root.querySelector('tr[data-p="' + q.id + '"]') };
    });
  }
  function reprofile(o) { o.steps = evaluate(o.p); o.cur = 0; }

  /* ---- rendering ---- */
  function log(id, node, state, text, quiet) {
    var li = document.createElement('li');
    li.innerHTML = '<span class="mth-ledger__tm"></span><span class="mth-ledger__id"></span><span class="mth-ledger__tx"><b></b> · <span></span></span>';
    li.children[0].textContent = hms(clock);
    li.children[1].textContent = id;
    li.querySelector('b').textContent = node;
    li.querySelector('.mth-ledger__tx span').textContent = text;
    if (!quiet && !BDH.reduced) li.className = 'is-new';
    logEl.insertBefore(li, logEl.firstChild);
    while (logEl.children.length > 60) logEl.removeChild(logEl.lastChild);
    clock += 7; if (clockEl) clockEl.textContent = hms(clock);
  }
  function statusOf(o) {
    if (!o.cur) return ['hold', 'Queued'];
    var s = o.steps[o.cur - 1];
    if (s[1] === 'ok' && s[0] === 5) return ['ok', 'Sent'];
    if (o.cur < o.steps.length) return ['hold', 'Running'];
    return [s[1], STATE[s[1]]];
  }
  function paint(hot) {
    var t = [0, 0, 0, 0, 0, 0].map(function () { return { ok: 0, hold: 0, stop: 0, wait: 0 }; });
    people.forEach(function (o) {
      for (var i = 0; i < o.cur; i++) t[o.steps[i][0]][o.steps[i][1]]++;
      var st = statusOf(o), cell = o.row.querySelector('[data-status]');
      cell.innerHTML = '<span class="mth-chip mth-chip--' + st[0] + '"></span>';
      cell.firstChild.textContent = st[1];
      o.row.classList.toggle('is-hot', o === hot);
      o.row.querySelectorAll('.mth-eng__cons').forEach(function (b) {
        var on = !!o.p.c[b.getAttribute('data-ch')];
        b.setAttribute('aria-pressed', on ? 'true' : 'false');
        b.firstChild.textContent = on ? 'On' : 'Off';
      });
    });
    nodesEl.forEach(function (n, i) {
      var x = t[i], bits = [];
      if (x.ok + x.hold) bits.push((x.ok + x.hold) + ' through');
      if (x.hold) bits.push(x.hold + ' held');
      if (x.stop) bits.push(x.stop + ' out');
      if (x.wait) bits.push(x.wait + ' waiting');
      n.querySelector('[data-tally]').textContent = bits.length ? bits.join(' · ') : '—';
      n.classList.toggle('is-hot', !!(hot && hot.cur && hot.steps[hot.cur - 1][0] === i));
    });
    paintQueue();
  }
  function paintQueue() {
    var waiting = people.filter(function (o) { return o.cur === o.steps.length && o.steps[o.cur - 1][1] === 'wait'; });
    queueEl.textContent = '';
    waiting.forEach(function (o) {
      var li = document.createElement('li'); li.className = 'mth-eng__qi';
      li.innerHTML = '<p><b></b> · <span></span></p><p class="mth-eng__qd"></p><div class="mth-eng__qa"><button type="button" data-ok>Approve</button><button type="button" data-no>Reject</button></div>';
      li.querySelector('b').textContent = o.p.id;
      li.querySelector('span').textContent = J[jk].rule;
      li.querySelector('.mth-eng__qd').textContent = o.steps[2] ? o.steps[2][2] : '';
      li.querySelector('[data-ok]').setAttribute('aria-label', 'Approve send to ' + o.p.id);
      li.querySelector('[data-no]').setAttribute('aria-label', 'Reject send to ' + o.p.id);
      li.querySelector('[data-ok]').addEventListener('click', function () { decide(o, true); });
      li.querySelector('[data-no]').addEventListener('click', function () { decide(o, false); });
      queueEl.appendChild(li);
    });
    qEmpty.hidden = waiting.length > 0;
    qN.textContent = waiting.length + ' waiting';
  }

  /* ---- behaviour ---- */
  function decide(o, ok) {
    take();
    var ch = (o.steps[2][2].match(/by (Email|WhatsApp|SMS)/) || [])[1] || 'Email';
    o.steps[o.cur - 1] = [4, 'ok', ok ? 'Approved by you · Marketing lead' : 'Rejected by you · nothing sent'];
    log(o.p.id, 'Approval', ok ? 'ok' : 'stop', o.steps[o.cur - 1][2]);
    if (ok) { o.steps.push([5, 'ok', 'Sent by ' + ch + ' · ' + J[jk].tpl]); o.cur++; log(o.p.id, NODES[5][0], "ok", o.steps[o.cur - 1][2]); }
    else { o.steps[o.cur - 1][1] = 'stop'; }
    paint(o);
    var first = queueEl.querySelector('button'); if (first) first.focus(); else if (runBtn) runBtn.focus();
  }
  function stepOnce() {
    var n = people.length;
    for (var k = 0; k < n; k++) {
      var o = people[(rr + k) % n];
      if (o.cur < o.steps.length) {
        var s = o.steps[o.cur]; o.cur++;
        rr = (rr + k + 1) % n;
        log(o.p.id, NODES[s[0]][0], s[1], s[2]);
        paint(o);
        return true;
      }
    }
    paint(null);
    return false;
  }
  function finishAll() { while (stepOnce()) { /* run to the end */ } }
  function stop() { running = false; clearInterval(timer); timer = null; runBtn.setAttribute('aria-pressed', 'false'); runBtn.textContent = 'Run'; }
  function start() {
    if (BDH.reduced) { finishAll(); return; }
    running = true; runBtn.setAttribute('aria-pressed', 'true'); runBtn.textContent = 'Pause';
    clearInterval(timer);
    timer = setInterval(function () {
      if (!onScreen) return;
      if (!stepOnce()) {
        stop();
        if (!touched) { clearTimeout(idle); idle = setTimeout(function () { if (!touched && onScreen) { reset(true); start(); } }, 5000); }
      }
    }, 850);
  }
  function reset(auto) {
    stop(); clearTimeout(idle); fresh(); rr = 0; logEl.textContent = '';
    nodesEl.forEach(function (n, i) {
      var r = n.querySelector('[data-rule]');
      if (i === 0) r.textContent = J[jk].trigger;
      if (i === 2) r.textContent = J[jk].decide;
      if (i === 4) r.textContent = J[jk].rule;
    });
    log('—', 'Journey', 'ok', J[jk].name + (auto ? ' · new run' : ' · run started'), true);
    paint(null);
  }
  function take() { touched = true; clearTimeout(idle); }

  root.querySelector('.mth-eng__ctl').hidden = false;
  root.querySelector('.mth-eng__js').hidden = false;
  root.classList.add('is-on');
  root.querySelectorAll('.mth-eng__cons').forEach(function (b) { b.disabled = false; });

  runBtn.addEventListener('click', function () { take(); if (running) stop(); else start(); });
  root.querySelector('[data-act="step"]').addEventListener('click', function () { take(); stop(); stepOnce(); });
  root.querySelector('[data-act="reset"]').addEventListener('click', function () { take(); reset(); if (BDH.reduced) finishAll(); });
  jBtns.forEach(function (b) {
    b.addEventListener('click', function () {
      take();
      jk = b.getAttribute('data-j');
      jBtns.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
      reset(); if (BDH.reduced) finishAll(); else start();
    });
  });
  root.addEventListener('click', function (ev) {
    var b = ev.target.closest('.mth-eng__cons'); if (!b) return;
    take();
    var id = b.closest('tr').getAttribute('data-p');
    var o = people.filter(function (x) { return x.p.id === id; })[0]; if (!o) return;
    var ch = b.getAttribute('data-ch'), on = !o.p.c[ch];
    o.p.c[ch] = on ? 1 : 0;
    log(id, 'Consent', on ? 'ok' : 'stop', (on ? 'Given' : 'Withdrawn') + ' · ' + CH[ch] + ' marketing · recorded with source and time, applied from the next step');
    reprofile(o);
    paint(o);
    if (BDH.reduced || !running) { while (o.cur < o.steps.length) { var s = o.steps[o.cur++]; log(id, NODES[s[0]][0], s[1], s[2]); } paint(o); }
  });

  fresh();
  BDH.live(root, 0.2, function (on) { onScreen = on; });
  if (BDH.reduced) { reset(); finishAll(); return; }
  reset();
  BDH.inView(root, function () { if (!touched) start(); });
})();
