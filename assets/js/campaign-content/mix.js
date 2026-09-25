/* Hub · mix — the budget scenarios are an ARIA tablist; BDH.tabs gives them click, arrow-key,
   Home and End behaviour and switches the panes. The first pane is on in the markup, so with
   JavaScript off the "same budget" scenario is shown complete. No autoplay here: a reader
   comparing three budget scenarios should not have them change under them. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.cch-mx__card--split');
  if (!root) return;
  BDH.tabs(root, { tabs: '.cch-mx__seg [role="tab"]', panes: '.cch-mx__pane', orientation: 'horizontal' });
})();
