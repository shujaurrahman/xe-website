/* Integration & Support · patterns — tabs, packets and controls for the four pattern diagrams.
   Packets travel the SVG edges only while the band is on screen and the pane is the active tab.
   Each pane has an idle loop (a normal request, an event fan-out, a captured change, a workflow run)
   and real controls: simulate an ERP timeout, fail the CRM consumer and replay its dead-letter queue,
   update a row, run the workflow with a failing step. The HTML is the readable final state.
   Reduced motion: no packets or tab rotation; controls still update the diagram and the log at once. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tis-patterns'); if (!root) return;
  var ui = root.querySelector('.tis-pt'); if (!ui) return;
  var R = BDH.reduced, NS = 'http://www.w3.org/2000/svg';
  var panes = BDH.$$('.tis-pt__pane', ui);
  var byKey = {};
  panes.forEach(function (p) { byKey[p.getAttribute('data-pane')] = p; });
  var active = panes[0] ? panes[0].getAttribute('data-pane') : null;
  var live = false, gen = 0, busy = false, idleTimer = null, packets = [];

  /* ---------- primitives ---------- */
  function q(pane, sel) { return pane.querySelector(sel); }
  function node(pane, id) { return q(pane, '[data-n="' + id + '"]'); }
  function edge(pane, id) { return q(pane, '[data-e="' + id + '"]'); }
  function state(pane, id, cls) {
    var n = node(pane, id); if (!n) return;
    n.classList.remove('is-hot', 'is-down', 'is-warm');
    if (cls) n.classList.add(cls);
  }
  function sub(pane, id, text) { var n = node(pane, id), s = n && n.querySelector('[data-sub]'); if (s) s.textContent = text; }
  function log(pane, head, text, err) {
    var ol = q(pane, '[data-pt-log]'); if (!ol) return;
    var li = document.createElement('li');
    if (err) li.className = 'is-err';
    var b = document.createElement('b'); b.textContent = head; li.appendChild(b);
    li.appendChild(document.createTextNode(text));
    if (!R) li.classList.add('is-new');
    ol.appendChild(li);
    while (ol.children.length > 4) ol.removeChild(ol.firstElementChild);
  }
  /* a packet along an edge; done() when it arrives. Reduced motion: arrives at once. */
  function pk(pane, edgeId, o, done) {
    o = o || {};
    var p = edge(pane, edgeId);
    if (!p || R || !p.getTotalLength) { if (done) done(); return; }
    var svg = p.ownerSVGElement, len = p.getTotalLength();
    var c = document.createElementNS(NS, 'circle');
    c.setAttribute('r', '5'); c.setAttribute('class', 'tis-pt__pk' + (o.cls ? ' ' + o.cls : ''));
    svg.appendChild(c); packets.push(c);
    p.classList.add('is-hot');
    var g = gen, t0 = null, dur = o.dur || Math.max(380, len * 3.2);
    function step(ts) {
      if (g !== gen) return;
      if (t0 === null) t0 = ts;
      var k = Math.min(1, (ts - t0) / dur), e = k < 0.5 ? 2 * k * k : 1 - Math.pow(-2 * k + 2, 2) / 2;
      var pt = p.getPointAtLength(len * (o.rev ? 1 - e : e));
      c.setAttribute('cx', pt.x.toFixed(1)); c.setAttribute('cy', pt.y.toFixed(1));
      if (k < 1) { requestAnimationFrame(step); return; }
      c.remove(); p.classList.remove('is-hot');
      packets = packets.filter(function (x) { return x !== c; });
      if (done) done();
    }
    requestAnimationFrame(step);
  }
  function wait(ms) { return function (next) { if (R) { next(); return; } var g = gen; setTimeout(function () { if (g === gen) next(); }, ms); }; }
  function go(pane, id, o) { return function (next) { pk(pane, id, o, next); }; }
  function all(fns) { return function (next) { var n = fns.length; if (!n) { next(); return; } fns.forEach(function (f) { f(function () { if (--n === 0) next(); }); }); }; }
  function act(fn) { return function (next) { fn(); next(); }; }
  /* run steps in order; a cancelled run (gen changed) never calls done */
  function run(steps, done) {
    var g = ++gen, i = 0;
    function next() {
      if (g !== gen) return;
      if (i >= steps.length) { if (done) done(); return; }
      steps[i++](next);
    }
    next();
  }
  function cancel() {
    gen++;
    packets.forEach(function (c) { c.remove(); });
    packets = [];
    BDH.$$('.tis-pt__e.is-hot', ui).forEach(function (e) { e.classList.remove('is-hot'); });
    if (idleTimer) { clearTimeout(idleTimer); idleTimer = null; }
    busy = false;
  }
  function rnd(a, b) { return a + Math.floor(Math.random() * (b - a + 1)); }

  /* ---------- 01 request–response ---------- */
  var rr = byKey.rr, rrFails = 0;
  function rrMeasured(txt, over) {
    var m = q(rr, '[data-rr-ms]'), e = q(rr, '.tis-pt__bud--e');
    if (m) m.textContent = 'measured ' + txt + (over ? ' · over budget, served by retry' : '');
    if (e) e.classList.toggle('is-over', !!over);
  }
  function rrIdle(done) {
    var ms = rnd(180, 260);
    run([
      act(function () { state(rr, 'client', 'hot'); }),
      go(rr, 'c-g'), go(rr, 'g-s'), act(function () { state(rr, 'svc', 'hot'); }), go(rr, 's-e'),
      act(function () { state(rr, 'erp', 'hot'); }), wait(240),
      go(rr, 'e-s', { rev: true }), act(function () { state(rr, 'erp'); }), go(rr, 's-g', { rev: true }), act(function () { state(rr, 'svc'); }), go(rr, 'g-c', { rev: true }),
      act(function () { state(rr, 'client'); rrMeasured(ms + ' ms', false); log(rr, '200', 'GET /v1/stock/MUG-340-BLU · ' + ms + ' ms'); }),
    ], done);
  }
  function rrTimeout() {
    cancel(); busy = true;
    var br = q(rr, '[data-breaker]');
    run([
      act(function () { state(rr, 'client', 'hot'); }),
      go(rr, 'c-g'), go(rr, 'g-s'), act(function () { state(rr, 'svc', 'hot'); }), go(rr, 's-e'),
      act(function () { state(rr, 'erp', 'down'); sub(rr, 'erp', 'no response'); }), wait(800),
      act(function () {
        rrFails++;
        log(rr, '504', 'ERP timeout after 800 ms · retry 1 in ' + rnd(140, 220) + ' ms (backoff + jitter)', true);
        if (br) { br.textContent = 'circuit breaker · closed · ' + rrFails + ' of 5 failures'; br.classList.add('is-on'); }
      }),
      wait(420),
      go(rr, 's-e'), act(function () { state(rr, 'erp', 'hot'); sub(rr, 'erp', 'system of record'); }), wait(240),
      go(rr, 'e-s', { rev: true }), act(function () { state(rr, 'erp'); }), go(rr, 's-g', { rev: true }), act(function () { state(rr, 'svc'); }), go(rr, 'g-c', { rev: true }),
      act(function () { state(rr, 'client'); rrMeasured('1.2 s', true); log(rr, '200', 'retry 1 succeeded · ' + rnd(220, 290) + ' ms · total 1.2 s'); }),
      wait(3200),
      act(function () { if (br) { br.textContent = 'circuit breaker · closed'; br.classList.remove('is-on'); } rrFails = 0; rrMeasured('212 ms', false); }),
    ], function () { busy = false; kick(); });
  }

  /* ---------- 02 event-driven ---------- */
  var ev = byKey.ev, evFail = false, dlq = 0;
  var failBtn = q(ev, '[data-pt-act="fail"]'), replayBtn = q(ev, '[data-pt-act="replay"]'), dlqN = q(ev, '[data-pt-dlqn]');
  function evPaint() {
    sub(ev, 'dlq', 'depth ' + dlq);
    if (dlqN) dlqN.textContent = dlq;
    if (replayBtn) replayBtn.disabled = dlq === 0;
    state(ev, 'crm', evFail ? 'down' : '');
    sub(ev, 'crm', evFail ? 'lag ' + (dlq * 3) + ' · failing' : 'lag 0 · ok');
    if (failBtn) failBtn.setAttribute('aria-pressed', String(evFail));
  }
  function evIdle(done) {
    var id = 'ord_' + Math.random().toString(36).slice(2, 8).toUpperCase();
    run([
      act(function () { state(ev, 'prod', 'hot'); }),
      go(ev, 'p-o'), act(function () { state(ev, 'outbox', 'hot'); state(ev, 'prod'); }), go(ev, 'o-t'),
      act(function () { state(ev, 'outbox'); state(ev, 'topic', 'hot'); log(ev, 'pub', 'order.created ' + id + ' · written with the order, relayed from the outbox'); }),
      wait(160),
      all([
        function (n) { pk(ev, 't-erp', {}, function () { state(ev, 'erp', 'hot'); setTimeout(function () { state(ev, 'erp'); }, R ? 0 : 500); n(); }); },
        function (n) { pk(ev, 't-wh', {}, function () { state(ev, 'wh', 'hot'); setTimeout(function () { state(ev, 'wh'); }, R ? 0 : 500); n(); }); },
        function (n) {
          pk(ev, 't-crm', { cls: evFail ? 'is-err' : '' }, function () {
            if (!evFail) { state(ev, 'crm', 'hot'); setTimeout(function () { state(ev, 'crm'); }, R ? 0 : 500); n(); return; }
            pk(ev, 'crm-dlq', { cls: 'is-err' }, function () {
              dlq++; evPaint();
              if (dlq === 1 || dlq % 4 === 0) log(ev, 'dlq', 'CRM sync failed 5 attempts · ' + dlq + (dlq === 1 ? ' event' : ' events') + ' parked with errors', true);
              n();
            });
          });
        },
      ]),
      act(function () { state(ev, 'topic'); }),
    ], done);
  }
  function evReplay() {
    if (!dlq) return;
    cancel(); busy = true;
    evFail = false; evPaint();
    var n = dlq, steps = [act(function () { state(ev, 'dlq', 'hot'); log(ev, 'fix', 'CRM connector redeployed · consumer healthy · replaying ' + n + (n === 1 ? ' event' : ' events')); })];
    for (var i = 0; i < Math.min(n, 4); i++) {
      steps.push(all([go(ev, 'dlq-t', { rev: true, cls: 'is-dlq' })]));
      steps.push(go(ev, 't-crm'));
      steps.push(act(function () { dlq = Math.max(0, dlq - Math.ceil(n / Math.min(n, 4))); evPaint(); state(ev, 'crm', 'hot'); }));
      steps.push(wait(120));
    }
    steps.push(act(function () { dlq = 0; evPaint(); state(ev, 'dlq'); state(ev, 'crm'); log(ev, 'replay', n + (n === 1 ? ' event' : ' events') + ' replayed after fix · 0 duplicates (idempotent consumer)'); }));
    run(steps, function () { busy = false; kick(); });
  }

  /* ---------- 03 change data capture ---------- */
  var cdc = byKey.cdc, lsn = 0x16B37C8, custId = 42;
  function walPush(pane, text) {
    var g = q(pane, '[data-pt-wal]'); if (!g) return;
    var ts = BDH.$$('text', g);
    for (var i = 0; i < ts.length - 1; i++) { ts[i].textContent = ts[i + 1].textContent; ts[i].classList.remove('is-now'); }
    var last = ts[ts.length - 1]; last.textContent = text; last.classList.add('is-now');
  }
  function cdcFlow(done, kind) {
    run([
      act(function () { state(cdc, 'db', 'hot'); }),
      go(cdc, 'db-con'), act(function () { state(cdc, 'db'); state(cdc, 'con', 'hot'); }), go(cdc, 'con-t'),
      act(function () { state(cdc, 'con'); state(cdc, 'topic', 'hot'); }),
      all([
        function (n) { pk(cdc, 't-wh', {}, function () { state(cdc, 'wh', 'hot'); setTimeout(function () { state(cdc, 'wh'); }, R ? 0 : 500); n(); }); },
        function (n) { pk(cdc, 't-se', {}, function () { state(cdc, 'se', 'hot'); setTimeout(function () { state(cdc, 'se'); }, R ? 0 : 500); n(); }); },
        function (n) { pk(cdc, 't-ca', {}, function () { state(cdc, 'ca', 'hot'); setTimeout(function () { state(cdc, 'ca'); }, R ? 0 : 500); n(); }); },
      ]),
      act(function () { state(cdc, 'topic'); if (kind) log(cdc, 'sink', 'warehouse ' + (rnd(9, 18) / 10).toFixed(1) + ' s · search 0.' + rnd(4, 9) + ' s · cache key ' + kind + ' dropped'); }),
    ], done);
  }
  function cdcIdle(done) {
    var ops = [['c', 'orders'], ['u', 'stock'], ['u', 'orders'], ['d', 'carts'], ['c', 'customers']];
    var op = ops[rnd(0, ops.length - 1)];
    lsn += rnd(0x20, 0x60);
    walPush(cdc, '0/' + lsn.toString(16).toUpperCase() + ' ' + op[0] + ' ' + op[1]);
    cdcFlow(done, null);
  }
  function cdcRow() {
    cancel(); busy = true;
    lsn += rnd(0x20, 0x60); custId = rnd(11, 98);
    var tiers = [['silver', 'gold'], ['bronze', 'silver'], ['gold', 'platinum']], t = tiers[rnd(0, 2)];
    walPush(cdc, '0/' + lsn.toString(16).toUpperCase() + ' u customers');
    log(cdc, 'u', 'customers id=' + custId + ' · tier ' + t[0] + ' → ' + t[1] + ' · LSN 0/' + lsn.toString(16).toUpperCase());
    cdcFlow(function () { log(cdc, 'load', 'source queries added by capture: 0'); busy = false; kick(); }, 'customer:' + custId);
  }

  /* ---------- 04 iPaaS workflow ---------- */
  var ip = byKey.ipaas, ip503 = false, runNo = 4813;
  var btn503 = q(ip, '[data-pt-act="503"]');
  function ipFlow(done, forced) {
    var yes = forced ? true : Math.random() < 0.6;
    runNo++;
    var t0 = Date.now(), steps = [
      act(function () { state(ip, 'a', 'hot'); }),
      go(ip, 'a-b'), act(function () { state(ip, 'a'); state(ip, 'b', 'hot'); }), wait(180),
      go(ip, 'b-c'), act(function () { state(ip, 'b'); state(ip, 'c', 'hot'); }), wait(120),
    ];
    if (yes) {
      steps.push(go(ip, 'c-d'));
      steps.push(act(function () { state(ip, 'c'); state(ip, 'd', ip503 ? 'down' : 'hot'); if (ip503) sub(ip, 'd', '503 · retry in 30 s'); }));
      if (ip503) {
        steps.push(go(ip, 'd-x', { cls: 'is-err' }));
        steps.push(act(function () { state(ip, 'x', 'warm'); log(ip, '#' + runNo, 'create ticket 503 · error workflow alerted the owner · retry scheduled', true); }));
        steps.push(wait(900));
        steps.push(act(function () { state(ip, 'x'); state(ip, 'd', 'hot'); sub(ip, 'd', 'helpdesk'); ip503 = false; if (btn503) btn503.setAttribute('aria-pressed', 'false'); }));
      }
      steps.push(wait(160));
      steps.push(go(ip, 'd-e'));
      steps.push(act(function () { state(ip, 'd'); state(ip, 'e', 'hot'); }));
      steps.push(wait(300));
      steps.push(act(function () { state(ip, 'e'); log(ip, '#' + runNo, (R ? 5 : 5) + ' steps · ' + Math.max(1.1, (Date.now() - t0) / 1000).toFixed(1) + ' s · succeeded'); }));
    } else {
      steps.push(go(ip, 'c-f'));
      steps.push(act(function () { state(ip, 'c'); state(ip, 'f', 'hot'); }));
      steps.push(wait(300));
      steps.push(act(function () { state(ip, 'f'); log(ip, '#' + runNo, 'new contact · lead created · ' + Math.max(0.9, (Date.now() - t0) / 1000).toFixed(1) + ' s'); }));
    }
    run(steps, done);
  }
  function ipIdle(done) { ipFlow(done, false); }
  function ipRun() { cancel(); busy = true; ipFlow(function () { busy = false; kick(); }, true); }

  /* ---------- idle scheduler ---------- */
  var idle = { rr: rrIdle, ev: evIdle, cdc: cdcIdle, ipaas: ipIdle };
  function kick() {
    if (R || !live || busy || !active || !idle[active]) return;
    busy = true;
    idle[active](function () {
      busy = false;
      idleTimer = setTimeout(function () { idleTimer = null; kick(); }, active === 'ev' ? 1400 : 2200);
    });
  }

  /* ---------- wiring ---------- */
  BDH.tabs(ui, {
    auto: 12000, interactRoot: ui,
    onChange: function (i) { cancel(); active = panes[i].getAttribute('data-pane'); kick(); }
  });
  ui.addEventListener('click', function (e) {
    var b = e.target.closest('[data-pt-act]'); if (!b) return;
    switch (b.getAttribute('data-pt-act')) {
      case 'timeout': rrTimeout(); break;
      case 'fail': evFail = !evFail; evPaint(); if (evFail) { cancel(); kick(); } break;
      case 'replay': evReplay(); break;
      case 'row': cdcRow(); break;
      case '503': ip503 = !ip503; b.setAttribute('aria-pressed', String(ip503)); sub(ip, 'd', ip503 ? 'helpdesk · will fail' : 'helpdesk'); break;
      case 'run': ipRun(); break;
    }
  });
  evPaint();
  if (R) return;
  BDH.live(ui, 0.2, function (on) { live = on; if (on) kick(); else cancel(); });
})();
