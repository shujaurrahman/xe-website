/* Process stepper: every phase is visible in the shipped HTML; with JS the rail becomes an ARIA tablist and
   phases before the current one are marked done. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-mth-steps]');
  if (!root) return;
  var tabs = root.querySelectorAll('.mth-steps__tab');
  root.classList.add('is-tabs');
  function done(i) { tabs.forEach(function (t, n) { t.classList.toggle('is-done', n < i); }); }
  BDH.tabs(root, {
    panes: '.mth-steps__pane',
    onChange: function (i) { done(i); }
  });
  done(0);
})();
