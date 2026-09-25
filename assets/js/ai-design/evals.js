/* Hub · evals — the three scorecards behind an ARIA tablist (BDH.tabs: click, arrow keys, Home / End).
   Panes are stacked in one grid cell, so the section height never jumps between them and a hidden pane
   cannot show through (brief §2, defect class 5). No autoplay: a scorecard is read, not watched.
   The meters grow from their .bdh-grow start state when the section is revealed; on a pane the reader
   switches to later, the growth is replayed once so the bars are never caught mid-transition. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.aih-ev');
  if (!root) return;

  var panes = BDH.$$('.aih-ev__pane', root);
  if (!panes.length) return;

  BDH.tabs(root, {
    tabs: '.aih-ev__tab',
    panes: '.aih-ev__pane',
    onChange: function (i) {
      if (BDH.reduced) return;
      var bars = BDH.$$('.aih-meter i', panes[i]);
      bars.forEach(function (b) { b.style.transitionDelay = '0ms'; });
    }
  });
})();
