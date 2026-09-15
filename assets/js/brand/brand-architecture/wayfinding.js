/* 7 · Wayfinding — Before/After toggle redraws the route; a walker follows it while on screen.
   Alternates the plans until the first interaction. Reduced motion: static route, walker at the goal. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var app = document.querySelector('[data-cba-way]');
  var raw = document.getElementById('wayfinding-data');
  if (!app || !raw) return;
  var D; try { D = JSON.parse(raw.textContent); } catch (e) { return; }
  var btns = BDH.$$('[data-way]', app);
  var walker = app.querySelector('.cba-way__walker');
  var routes = { before: app.querySelector('.cba-way__layer--before .cba-way__route'), after: app.querySelector('.cba-way__layer--after .cba-way__route') };
  var state = 'before', raf = 0, t0 = 0, on = false;

  function put(p) { walker.setAttribute('cx', p.x.toFixed(1)); walker.setAttribute('cy', p.y.toFixed(1)); }
  function endOf(path) { return path.getPointAtLength(path.getTotalLength()); }

  function walk(ts) {
    var path = routes[state];
    if (!t0) t0 = ts;
    var len = path.getTotalLength();
    var dur = state === 'before' ? 5200 : 2600;
    var k = ((ts - t0 - 400) % (dur + 1600)) / dur;   /* walk, then rest at the goal */
    put(path.getPointAtLength(Math.max(0, Math.min(1, k)) * len));
    raf = on ? requestAnimationFrame(walk) : 0;
  }
  function run(v) {
    on = v;
    if (v && !raf) { t0 = 0; raf = requestAnimationFrame(walk); }
    if (!v && raf) { cancelAnimationFrame(raf); raf = 0; }
  }

  function show(s) {
    state = s;
    app.setAttribute('data-state', s);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-way') === s ? 'true' : 'false'); });
    D[s].stats.forEach(function (st, i) { var dd = app.querySelector('[data-w="s' + i + '"]'); if (dd) dd.textContent = st[1]; });
    var note = app.querySelector('[data-w="note"]'); if (note) note.textContent = D[s].note;
    t0 = 0;
    if (BDH.reduced) put(endOf(routes[s]));
  }

  btns.forEach(function (b) { b.addEventListener('click', function () { stop(); show(b.getAttribute('data-way')); }); });
  show('before');
  if (BDH.reduced) return;

  BDH.watch(app, run, { threshold: 0.2 });
  var timer = BDH.loop(app, 8200, function () { show(state === 'before' ? 'after' : 'before'); });
  function stop() { if (timer) { timer.stop(); timer = null; } }
  BDH.onInteract(app, stop);
})();
