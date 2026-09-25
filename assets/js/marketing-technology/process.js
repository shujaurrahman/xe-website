/* Hub · process — two small jobs. The capability tablist (BDH.tabs: click, arrow keys, Home and End)
   switches which capability's four phases are shown. And as the reader passes each phase of the spine,
   that phase's dot lights, so the rail reads as progress rather than decoration. Phase one is already lit
   in the markup, so nothing depends on this running. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var caps = document.querySelector('.mth-pro__caps');
  if (caps) {
    BDH.tabs(caps, { tabs: '.mth-pro__tab', panes: '.mth-pro__pane', orientation: 'horizontal' });
  }

  var phases = BDH.$$('.mth-pro__ph');
  if (!phases.length || BDH.reduced) return;
  BDH.spy(phases, function (el) {
    var i = phases.indexOf(el);
    phases.forEach(function (p, n) { p.classList.toggle('is-on', n <= i); });
  }, '-40% 0px -45% 0px');
})();
