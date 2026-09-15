/* Brand Identity · construct — five-step stepper. Autoplays (3.6s a step, on screen only) until the
   first interaction inside the lab; then buttons, Previous/Next and arrow keys drive it.
   Reduced motion: no autoplay, controls still work. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.cbi-cx'); if (!root) return;
  var board = root.querySelector('.cbi-cx__board');
  var steps = BDH.$$('.cbi-cx__step', root);
  var panes = BDH.$$('.cbi-cx__pane', root);
  var bars = BDH.$$('.cbi-cx__track i', root);
  var count = root.querySelector('.cbi-cx__count b');
  var prev = root.querySelector('[data-go="-1"]');
  var next = root.querySelector('[data-go="1"]');
  var N = steps.length, cur = 0;

  function show(i) {
    cur = Math.max(0, Math.min(N - 1, i));
    board.setAttribute('data-step', cur);
    steps.forEach(function (b, k) { b.setAttribute('aria-pressed', String(k === cur)); });
    panes.forEach(function (p, k) { p.classList.toggle('is-on', k === cur); });
    bars.forEach(function (b, k) { b.classList.toggle('is-on', k <= cur); });
    if (count) count.textContent = ('0' + (cur + 1)).slice(-2);
    if (prev) prev.disabled = cur === 0;
    if (next) next.disabled = cur === N - 1;
  }

  steps.forEach(function (b, k) {
    b.addEventListener('click', function () { show(k); });
    b.addEventListener('keydown', function (ev) {
      var d = (ev.key === 'ArrowDown' || ev.key === 'ArrowRight') ? 1 : (ev.key === 'ArrowUp' || ev.key === 'ArrowLeft') ? -1 : 0;
      if (!d) return;
      ev.preventDefault(); show(k + d); steps[cur].focus();
    });
  });
  if (prev) prev.addEventListener('click', function () { show(cur - 1); });
  if (next) next.addEventListener('click', function () { show(cur + 1); });
  show(0);

  if (BDH.reduced) return;
  var grid = root.querySelector('.cbi-cx__grid');
  var run = BDH.loop(grid, 3600, function () { show((cur + 1) % N); });
  BDH.onInteract(grid, function () { run.stop(); });
})();
