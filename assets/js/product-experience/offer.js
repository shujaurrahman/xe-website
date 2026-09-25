/* Hub · offer — one tab per capability, driven by BDH.tabs (click, arrow keys, Home and End). The
   panels are plain divs, so with JavaScript off all five are shown in turn under their own headings;
   BDH.tabs hides the inactive ones at init. Links elsewhere on the page carrying data-offer="<n>"
   (the capability index rows) open the matching tab after the browser jumps to this section. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.pxh-offer__in');
  if (!root) return;

  var api = BDH.tabs(root, {
    tabs: '.pxh-offer__tab',
    panes: '.pxh-offer__pane',
    orientation: 'horizontal'
  });

  BDH.$$('[data-offer]').forEach(function (a) {
    a.addEventListener('click', function () {
      var n = parseInt(a.getAttribute('data-offer'), 10);
      if (!isNaN(n)) api.show(n, true);
    });
  });
})();
