/* Industries · lens — one ARIA tablist over the five jobs. BDH.tabs does the roving tabindex, the
   arrow keys and the pane switching. Nothing is generated here: with JavaScript off the section's
   <noscript> rule stacks all five panes and every table is already complete. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var app = BDH.$('.ind-lns__app');
  if (!app) return;
  BDH.tabs(app, {
    tabs: '.ind-lns__tabs [role="tab"]',
    panes: '.ind-lns__panes > .bdh-pane'
  });
})();
