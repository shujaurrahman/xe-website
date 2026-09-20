/* 09 Reliability — the SLO panel's indicator tabs.
   The HTML ships all three panes complete; this turns the button row into a real ARIA tablist
   and replays the burn-down draw for whichever indicator is shown. Under reduced motion the
   tabs still work, the line simply appears at full length. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-tic-rl]');
  if (!root) return;

  var bar = root.querySelector('[data-tic-rl-tabs]');
  var panes = BDH.$$('.tic-rl__pane', root);
  if (!bar || panes.length < 2) return;

  /* Replay the draw: drop the offset back to full, force a reflow, then let the transition run. */
  function redraw(pane) {
    if (BDH.reduced) return;
    var line = pane.querySelector('.tic-rl__line');
    if (!line) return;
    line.style.transition = 'none';
    line.style.strokeDashoffset = '1';
    void line.getBoundingClientRect();
    line.style.transition = '';
    line.style.strokeDashoffset = '';
  }

  var tabs = BDH.tabs(root, {
    tabs: '[data-tic-rl-tabs] > button',
    panes: panes,
    onChange: function (i) { redraw(panes[i]); }
  });

  if (!tabs) return;
})();
