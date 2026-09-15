/* Brand Identity · process — the print run. Sheets up to the current phase lie on the pile; later ones
   wait off the pile. Markup is the finished state (all four down). On entry it restarts from the sketch
   and lays a sheet every 3.2s until the visitor touches the stepper. Reduced motion: static, controls work. */
(function () {
  'use strict';
  var root = document.querySelector('.cbi-pr'); if (!root) return;
  var qa = function (s) { return Array.prototype.slice.call(root.querySelectorAll(s)); };
  var sheets = qa('.cbi-pr__sheet'), steps = qa('.cbi-pr__step'), panes = qa('.cbi-pr__pane');
  var prev = root.querySelector('[data-go="-1"]'), next = root.querySelector('[data-go="1"]');
  var N = steps.length, cur = N - 1;

  function show(i) {
    cur = Math.max(0, Math.min(N - 1, i));
    sheets.forEach(function (s, k) {
      s.classList.toggle('is-up', k > cur);
      s.classList.toggle('is-top', k === cur);
    });
    steps.forEach(function (b, k) { b.setAttribute('aria-pressed', String(k === cur)); b.classList.toggle('is-done', k < cur); });
    panes.forEach(function (p, k) { p.classList.toggle('is-on', k === cur); });
    if (prev) prev.disabled = cur === 0;
    if (next) next.disabled = cur === N - 1;
  }
  steps.forEach(function (b, k) {
    b.addEventListener('click', function () { show(k); });
    b.addEventListener('keydown', function (ev) {
      var d = ev.key === 'ArrowRight' || ev.key === 'ArrowDown' ? 1 : ev.key === 'ArrowLeft' || ev.key === 'ArrowUp' ? -1 : 0;
      if (!d) return; ev.preventDefault(); show(k + d); steps[cur].focus();
    });
  });
  if (prev) prev.addEventListener('click', function () { show(cur - 1); });
  if (next) next.addEventListener('click', function () { show(cur + 1); });
  show(cur);

  if (!window.BDH || BDH.reduced) return;
  var grid = root.querySelector('.cbi-pr__grid'), run = null;
  BDH.inView(grid, function () {
    if (run === false) return;
    show(0);
    run = BDH.loop(grid, 3200, function () { show(cur === N - 1 ? 0 : cur + 1); });
  }, { threshold: 0.3 });
  BDH.onInteract(grid, function () { if (run) run.stop(); run = false; });
})();
