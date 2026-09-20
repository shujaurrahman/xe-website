/* Audits & Assessments · types — the ARIA tablist, plus the checklist tick on every pane change.
   Without JS every pane is present and the first one is shown; the tick state is purely decorative. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-taa-types]');
  if (!root) return;

  var panes = BDH.$$('.taa-ty__pane', root);

  function tick(i) {
    panes.forEach(function (p, n) { p.classList.toggle('is-tick', n === i); });
  }

  BDH.tabs(root, {
    tabs: '[data-taa-tabs] [role="tab"]',
    panes: panes,
    orientation: 'vertical',
    onChange: function (i) { tick(i); }
  });

  BDH.inView(root, function () { tick(0); }, { threshold: 0.15 });
})();
