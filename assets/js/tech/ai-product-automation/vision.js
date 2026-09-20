/* AI Product & Automation · vision — scene tabs (ARIA tablist) and the before/after slider. The range input
   sets --x on its figure; its valuetext says how much of the frame shows detections. When the slider first
   comes into view, and on each scene change, the overlay sweeps in from the right and the boxes pop in one by
   one. Each scene keeps its own sweep, and the sweep stops the moment the visitor touches that slider.
   Reduced motion: no sweep; the slider still works. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tap-vis'); if (!root) return;
  var R = BDH.reduced;
  var figs = BDH.$$('.tap-vis__fig', root);
  var anims = figs.map(function () { return null; });
  var seen = false;

  function set(fig, v) {
    v = Math.max(0, Math.min(100, v));
    fig.style.setProperty('--x', v + '%');
    var input = fig.querySelector('.tap-vis__range');
    if (input && String(input.value) !== String(Math.round(v))) input.value = Math.round(v);
    if (input) input.setAttribute('aria-valuetext', 'Detections shown on ' + (100 - Math.round(v)) + '% of the frame');
  }
  function cancel(i) { if (anims[i]) { cancelAnimationFrame(anims[i]); anims[i] = null; } }

  function sweep(i) {
    var fig = figs[i];
    if (R || !fig) return;
    cancel(i);
    var input = fig.querySelector('.tap-vis__range');
    var to = parseFloat(input.getAttribute('value')) || 22;
    fig.classList.add('is-scan');
    set(fig, 100);
    var t0 = null, dur = 1500;
    setTimeout(function () { fig.classList.remove('is-scan'); }, 380);
    anims[i] = requestAnimationFrame(function step(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / dur), k = p < 0.5 ? 4 * p * p * p : 1 - Math.pow(-2 * p + 2, 3) / 2;
      set(fig, 100 + (to - 100) * k);
      anims[i] = p < 1 ? requestAnimationFrame(step) : null;
    });
  }

  figs.forEach(function (fig, i) {
    var input = fig.querySelector('.tap-vis__range');
    if (!input) return;
    input.addEventListener('input', function () { cancel(i); fig.classList.remove('is-scan'); set(fig, parseFloat(input.value)); });
    input.addEventListener('pointerdown', function () { cancel(i); });
    input.addEventListener('keydown', function () { cancel(i); fig.classList.remove('is-scan'); });
  });

  var tabs = BDH.tabs(root, {
    tabs: '.tap-vis__top [role="tab"]',
    onChange: function (i) { seen = true; sweep(i); }
  });

  if (R) return;
  BDH.inView(root.querySelector('.bdh-panes'), function () {
    if (seen) return;
    seen = true;
    sweep(Math.max(0, tabs.index()));
  }, { threshold: 0.45 });
})();
