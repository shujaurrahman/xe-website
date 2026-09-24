/* Stepper progress: the rail fills and each step lights as the list scrolls through the viewport. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  document.querySelectorAll('[data-aih-steps]').forEach(function (list) {
    var steps = list.querySelectorAll('.aih-step');
    list.classList.add('is-anim');
    BDH.progress(list, function (p) {
      var v = Math.max(0, Math.min(1, p * 1.6 - 0.2));
      list.style.setProperty('--p', v.toFixed(3));
      var on = Math.round(v * (steps.length - 1));
      steps.forEach(function (s, i) { s.classList.toggle('is-on', i <= on && v > 0); });
    });
  });
})();
