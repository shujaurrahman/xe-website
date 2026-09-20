/* Custom Software & Data Platforms · lakehouse — routes the pipes between the stage cards from the live layout,
   draws them on entry, then runs batches (particles) through the platform while the board is on screen.
   A batch lights each card it reaches; at Silver the contract stamp pops; every sixth batch (or one injected
   with the button) fails the contract and diverts to Quarantine; the meter counts. Pause stops the run.
   Below 860 px the stages stack on one vertical spine (CSS packets run down it) and each batch lights the cards
   it passes in order instead, so the bad-batch button still sends one to quarantine there.
   Reduced motion: pipes routed and shown at once, no particles, the HTML values stay; "Inject a bad batch" holds
   a batch in quarantine at once. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tcs-lakehouse'); if (!root) return;
  var lh = root.querySelector('.tcs-lh');
  var flow = root.querySelector('.tcs-lh__flow');
  var svg = root.querySelector('.tcs-lh__svg');
  if (!lh || !flow || !svg) return;
  var R = BDH.reduced;
  var pipes = {};
  BDH.$$('.tcs-lh__pipe', svg).forEach(function (p) { pipes[p.getAttribute('data-pipe')] = p; });

  function node(k) { return flow.querySelector('[data-node="' + k + '"]'); }
  function box(el) {
    var r = el.getBoundingClientRect(), c = flow.getBoundingClientRect();
    return { l: r.left - c.left, t: r.top - c.top, r: r.right - c.left, b: r.bottom - c.top, w: r.width, h: r.height };
  }
  function pt(b, side, a) {
    if (side === 'l') return [b.l, b.t + b.h * a];
    if (side === 'r') return [b.r, b.t + b.h * a];
    if (side === 't') return [b.l + b.w * a, b.t];
    return [b.l + b.w * a, b.b];
  }
  function r1(v) { return Math.round(v * 10) / 10; }
  function curve(p, s1, q, s2) {
    if ((s1 === 't' || s1 === 'b') && (s2 === 'l' || s2 === 'r')) {   // a branch: leaves downwards, arrives sideways
      return 'M' + r1(p[0]) + ' ' + r1(p[1]) + ' C' + r1(p[0]) + ' ' + r1(q[1]) + ' ' + r1(p[0]) + ' ' + r1(q[1]) + ' ' + r1(q[0]) + ' ' + r1(q[1]);
    }
    if (s1 === 'r' || s1 === 'l') {
      var mx = (p[0] + q[0]) / 2;
      return 'M' + r1(p[0]) + ' ' + r1(p[1]) + ' C' + r1(mx) + ' ' + r1(p[1]) + ' ' + r1(mx) + ' ' + r1(q[1]) + ' ' + r1(q[0]) + ' ' + r1(q[1]);
    }
    var my = (p[1] + q[1]) / 2;
    return 'M' + r1(p[0]) + ' ' + r1(p[1]) + ' C' + r1(p[0]) + ' ' + r1(my) + ' ' + r1(q[0]) + ' ' + r1(my) + ' ' + r1(q[0]) + ' ' + r1(q[1]);
  }
  function layout() {
    if (getComputedStyle(svg).display === 'none') { lh.classList.remove('is-routed'); return false; }
    var c = flow.getBoundingClientRect();
    svg.setAttribute('viewBox', '0 0 ' + r1(c.width) + ' ' + r1(c.height));
    Object.keys(pipes).forEach(function (k) {
      var p = pipes[k], A = node(p.getAttribute('data-from')), B = node(p.getAttribute('data-to'));
      if (!A || !B) return;
      p.setAttribute('d', curve(pt(box(A), p.getAttribute('data-fs'), +p.getAttribute('data-fa')), p.getAttribute('data-fs'), pt(box(B), p.getAttribute('data-ts'), +p.getAttribute('data-ta')), p.getAttribute('data-ts')));
    });
    lh.classList.add('is-routed');
    return true;
  }
  function boot() {
    layout();
    if ('ResizeObserver' in window) {
      var q = false;
      new ResizeObserver(function () { if (q) return; q = true; requestAnimationFrame(function () { q = false; layout(); }); }).observe(flow);
    } else window.addEventListener('resize', layout);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(layout);
  }
  if (R) boot(); else BDH.inView(lh, boot, { threshold: 0.05 });

  /* ---- batches ------------------------------------------------------------ */
  var rowsEl = root.querySelector('[data-lh-rows]'), okEl = root.querySelector('[data-lh-ok]'), qEl = root.querySelector('[data-lh-q]');
  var status = root.querySelector('[data-lh-status]'), stamp = root.querySelector('[data-lh-stamp]'), qnote = root.querySelector('[data-lh-qnote]');
  var badBtn = root.querySelector('[data-lh-bad]'), pauseBtn = root.querySelector('[data-lh-pause]');
  var rows = 18406212, ok = 1284, quar = 1, n = 0, badNext = false, paused = false, live = false;
  var routes = [
    ['apps-cdc', 'cdc-bronze', 'bronze-silver', 'silver-gold', 'gold-m1', 'm1-bi'],
    ['saas-batch', 'batch-bronze', 'bronze-silver', 'silver-gold', 'gold-m2', 'm2-crm'],
    ['pos-ev', 'ev-bronze', 'bronze-silver', 'silver-gold', 'gold-m3', 'm3-bi'],
    ['files-batch', 'batch-bronze', 'bronze-silver', 'silver-gold', 'gold-m2', 'm2-ai'],
    ['apps-cdc', 'cdc-bronze', 'bronze-silver', 'silver-gold', 'gold-m1', 'm1-fin']
  ];
  var badRoute = ['files-batch', 'batch-bronze', 'bronze-quar'];   // fails the contract on the way into Silver
  var badNotes = [
    'orders_raw · 02:15 batch · total arrived as string, expected decimal(12,2) · owner paged',
    'customers_raw · 02:30 batch · 412 rows with null account_id · held · owner paged',
    'inventory_raw · 02:45 batch · placed_at in the future · held · owner paged'
  ];
  var pool = [];
  function particle(bad) {
    var el = pool.filter(function (p) { return !p.busy; })[0];
    if (!el) { if (pool.length >= 10) return null; var i = document.createElement('i'); i.className = 'tcs-lh__pk'; flow.appendChild(i); el = { el: i, busy: false }; pool.push(el); }
    el.busy = true; el.el.classList.toggle('is-bad', !!bad); el.el.classList.add('is-on');
    return el;
  }
  function fmt(v) { return v.toLocaleString('en-GB'); }
  function hit(k, ms) { var e = node(k); if (!e) return; e.classList.add('is-hit'); setTimeout(function () { e.classList.remove('is-hit'); }, ms || 700); }
  function arrive(k, bad) {
    if (k === 'silver') {
      ok++; okEl.textContent = fmt(ok); okEl.classList.add('is-new'); setTimeout(function () { okEl.classList.remove('is-new'); }, 600);
      if (stamp) { stamp.classList.remove('is-pop'); void stamp.offsetWidth; stamp.classList.add('is-pop'); }
    }
    if (k === 'quar') {
      var s = node('silver');   // the contract Silver enforces is the one the batch failed
      if (s) { s.classList.add('is-bad'); setTimeout(function () { s.classList.remove('is-bad'); }, 1200); }
      quar++; qEl.textContent = fmt(quar); qEl.classList.add('is-new'); setTimeout(function () { qEl.classList.remove('is-new'); }, 900);
      if (qnote) qnote.textContent = badNotes[quar % badNotes.length];
      if (status) status.textContent = '1 batch held in quarantine · owner paged';
      setTimeout(function () { if (status) status.textContent = '14 of 14 freshness SLOs met'; }, 2600);
      hit('quar', 1400);
    }
    if (k === 'bi' || k === 'crm' || k === 'ai' || k === 'fin') { rows += 1200 + Math.round(Math.random() * 900); rowsEl.textContent = fmt(rows); }
  }
  function run(route, bad) {
    var p = particle(bad); if (!p) return;
    var i = 0;
    function leg() {
      if (!live || paused) { p.el.classList.remove('is-on'); p.busy = false; return; }
      var path = pipes[route[i]]; if (!path || !path.getAttribute('d')) { p.el.classList.remove('is-on'); p.busy = false; return; }
      var L = path.getTotalLength(), ms = Math.max(420, Math.min(1300, L * 3.2)), t0 = null;
      path.classList.add(bad ? 'is-bad' : 'is-hot');
      var to = route[i].split('-')[1];
      function step(ts) {
        if (t0 === null) t0 = ts;
        var k = Math.min(1, (ts - t0) / ms), e = k < .5 ? 2 * k * k : 1 - Math.pow(-2 * k + 2, 2) / 2;
        var q = path.getPointAtLength(L * e);
        p.el.style.transform = 'translate(' + q.x.toFixed(1) + 'px,' + q.y.toFixed(1) + 'px)';
        if (k < 1) { requestAnimationFrame(step); return; }
        path.classList.remove('is-hot', 'is-bad');
        hit(to, to === 'silver' ? 1000 : 700);
        arrive(to, bad);
        i++;
        if (i < route.length) leg(); else { p.el.classList.remove('is-on'); p.busy = false; }
      }
      requestAnimationFrame(step);
    }
    leg();
  }
  /* narrow layout: no pipes to follow, so the batch lights each card on its route in turn */
  function runNarrow(route, bad) {
    var keys = [route[0].split('-')[0]].concat(route.map(function (r) { return r.split('-')[1]; }));
    keys.forEach(function (k, j) {
      setTimeout(function () {
        if (!live || paused) return;
        hit(k, k === 'silver' ? 1000 : 650);
        if (j) arrive(k, bad);
      }, j * 520);
    });
  }
  function tick() {
    if (paused) return;
    var narrow = getComputedStyle(svg).display === 'none';
    n++;
    var bad = badNext || n % 6 === 0; badNext = false;
    var route = bad ? badRoute : routes[n % routes.length];
    if (!narrow) run(route, bad);
    else if (bad || n % 2 === 0) runNarrow(route, bad);
  }
  /* reduced motion: no batches run, but "Inject a bad batch" still works: the batch is held at once, with no
     travelling particle, and the meter, the quarantine note and the status line update */
  if (R) {
    if (badBtn) { badBtn.hidden = false; badBtn.addEventListener('click', function () { hit('batch', 700); arrive('quar', true); }); }
    return;
  }
  /* watch the board, not the whole section block: on phones .tcs-lh is several screens tall and a ratio
     threshold on it would never be reached */
  var board = root.querySelector('.tcs-lh__board') || lh;
  BDH.live(board, 0, function (on) { live = on; });   // any part on screen: a press on "Inject a bad batch" always runs
  BDH.loop(board, 950, tick);

  function setPaused(v) {
    paused = v;
    lh.classList.toggle('is-paused', v);
    if (pauseBtn) { pauseBtn.setAttribute('aria-pressed', String(v)); pauseBtn.textContent = v ? 'Resume' : 'Pause'; }
  }
  if (badBtn) { badBtn.hidden = false; badBtn.addEventListener('click', function () { badNext = true; if (paused) setPaused(false); tick(); }); }
  if (pauseBtn) {
    pauseBtn.hidden = false;
    pauseBtn.addEventListener('click', function () { setPaused(!paused); });
  }
})();
