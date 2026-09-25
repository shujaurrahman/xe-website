/* Measures: journey tabs over the treated-vs-holdout chart; the journey line draws in once on first view. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-mth-meas]');
  if (!root) return;
  var list = root.querySelector('[role="tablist"]');
  list.hidden = false;
  root.classList.add('is-tabs');
  var panes = root.querySelectorAll('.mth-meas__pane');
  function redraw() {
    if (BDH.reduced) return;
    root.classList.remove('is-in'); void root.offsetWidth;
    requestAnimationFrame(function () { root.classList.add('is-in'); });
  }
  BDH.tabs(root, { panes: '.mth-meas__pane', onChange: function () { redraw(); } });
  if (BDH.reduced) return;
  root.classList.add('is-anim');
  BDH.inView(root, function () { root.classList.add('is-in'); });
})();
