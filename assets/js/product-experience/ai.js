/* Hub · ai — the five assistant states as a segmented ARIA tablist (click, arrow keys, Home and End),
   driven by BDH.tabs. The panels are plain divs, so with JavaScript off all five states are shown in
   turn, each with its own heading and requirements; BDH.tabs hides the inactive ones at init. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.pxh-ai__demo');
  if (!root) return;

  BDH.tabs(root, {
    tabs: '.pxh-ai__seg [role="tab"]',
    panes: '.pxh-ai__pane',
    orientation: 'horizontal'
  });
})();
