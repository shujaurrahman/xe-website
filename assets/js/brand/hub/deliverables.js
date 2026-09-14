/* Hub · the handover kit — folder tabs, gently auto-advancing until the reader interacts. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.bdh-dl');
  if (!root) return;
  /* auto-advance only on wide layouts — on narrow screens the panes are not height-locked */
  BDH.tabs(root, { tabs: '.bdh-dl__tab', orientation: 'vertical', auto: window.innerWidth >= 1024 ? 4200 : 0 });
})();
