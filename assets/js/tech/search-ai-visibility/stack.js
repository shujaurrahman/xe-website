/* Search & AI Visibility — 07 · Toolbelt.
   Wires the six job tabs with BDH.tabs, which owns the roving tabindex, the arrow-key handling and
   the aria-selected state. The markup already carries the full ARIA wiring and the first pane is
   selected server-side, so the section is complete without this file. No autoplay: a reader
   changes the job, the page does not change it for them. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-tsv-belt]');
  if (!root) return;

  BDH.tabs(root, {
    tabs:  '.tsv-belt__tab',
    panes: '.tsv-belt__pane',
    orientation: 'horizontal'
  });
})();
