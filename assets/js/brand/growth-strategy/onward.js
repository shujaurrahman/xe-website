/* Growth Strategy · 13 onward — the dashed route reveals left to right and the waypoints arrive in order
   when the strip enters view. Without JS or with reduced motion, all is shown. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cgs-onward]'); if (!root) return;
  if (BDH.reduced) return;
  root.classList.add('cgs-js');
  BDH.enter(root, { cls: 'is-in' });
})();
