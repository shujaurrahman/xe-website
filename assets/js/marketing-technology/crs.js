/* Hub · crs — the wheel's five rim nodes and its hub are an ARIA tablist (BDH.tabs: click, arrow keys,
   Home and End). Nothing animates: the section's point is structure, not motion. The markup already has
   part one selected with its pane on, so with JavaScript off it is a finished diagram and one explanation. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.mth-crs__body');
  if (!root) return;

  var nodes = BDH.$$('.mth-crs__node', root);
  var panes = BDH.$$('.mth-crs__pane', root);
  if (!nodes.length || nodes.length !== panes.length) return;

  BDH.tabs(root, {
    tabs: '.mth-crs__node',
    panes: '.mth-crs__pane',
    orientation: 'horizontal',
    onChange: function (i) {
      nodes.forEach(function (n, j) { n.classList.toggle('mth-node--on', j === i); });
    }
  });
})();
