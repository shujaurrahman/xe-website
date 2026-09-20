/* AI Product & Automation · process — the delivery plan plays out week by week. A playhead sweeps weeks
   0 → 14 while the window is on screen: each phase bar fills as it runs, its exit gate lights when passed,
   golden-set columns grow and release dots land in their week, and the running phase's detail opens. The
   plan holds on the finished state, then replays. The first interaction inside the window stops playback for
   good and leaves the finished plan; the phase bars are an ARIA tablist (arrow keys, Home, End).
   Reduced motion: no playback; the finished plan from the HTML, tabs still work. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tap-plan'); if (!root) return;
  var WK = 14, PER = 620, HOLD = 3200;
  var head = root.querySelector('.tap-plan__head');
  var wkEl = root.querySelector('[data-plan-wk]');
  var rows = BDH.$$('.tap-plan__row--ph', root).map(function (r) {
    return { el: r, a: parseInt(r.getAttribute('data-a'), 10), b: parseInt(r.getAttribute('data-b'), 10), bar: r.querySelector('.tap-plan__bar-b') };
  });
  var cols = BDH.$$('.tap-plan__col', root).map(function (c, i) { return { el: c, w: i + 1 }; });
  var rels = BDH.$$('.tap-plan__rel', root).map(function (r) { return { el: r, w: parseInt(r.style.getPropertyValue('--c'), 10) || 0 }; });
  var byUser = false;

  var tabs = BDH.tabs(root, {
    tabs: '.tap-plan__bar-b',
    orientation: 'vertical',
    onChange: function (i, prev, user) { if (user) byUser = true; }
  });

  function paint(p) {
    if (head) head.style.setProperty('--p', p.toFixed(3));
    if (wkEl) wkEl.textContent = String(Math.max(1, Math.min(WK, Math.ceil(p))));
    var running = -1;
    rows.forEach(function (r, i) {
      var start = r.a - 1, len = r.b - start;
      var f = Math.max(0, Math.min(1, (p - start) / len));
      r.bar.style.setProperty('--f', f.toFixed(3));
      r.el.classList.toggle('is-todo', p <= start);
      r.el.classList.toggle('is-run', p > start && p < r.b);
      if (p > start && p < r.b) running = i;
    });
    cols.forEach(function (c) { c.el.classList.toggle('is-off', p < c.w - 0.35); });
    rels.forEach(function (r) { r.el.classList.toggle('is-off', p < r.w - 0.5); });
    return running;
  }
  function finished() {
    root.classList.remove('is-play');
    paint(WK);
    rows.forEach(function (r) { r.bar.style.removeProperty('--f'); });
  }

  if (BDH.reduced) return;

  var vis = false, dead = false, raf = null, t = 0, last = 0, shown = -1;
  function frame(ts) {
    raf = null;
    if (dead || !vis) return;
    if (last) t += Math.min(64, ts - last);
    last = ts;
    var cycle = WK * PER + HOLD;
    if (t >= cycle) t = 0;
    var p = Math.min(WK, t / PER);
    var run = paint(p);
    if (!byUser && run > -1 && run !== shown) { shown = run; tabs.show(run, false); }
    raf = requestAnimationFrame(frame);
  }
  function sync() {
    if (dead) return;
    if (vis && raf === null) { last = 0; raf = requestAnimationFrame(frame); }
    if (!vis && raf !== null) { cancelAnimationFrame(raf); raf = null; }
  }
  function stop() {
    if (dead) return;
    dead = true;
    if (raf !== null) cancelAnimationFrame(raf);
    raf = null;
    finished();
  }

  BDH.inView(root, function () {
    if (dead) return;
    root.classList.add('is-play');
    paint(0);
    BDH.watch(root, function (on) { vis = on; sync(); }, { threshold: 0.2 });
  }, { threshold: 0.3 });
  BDH.onInteract(root, stop);
})();
