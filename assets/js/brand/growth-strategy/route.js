/* Growth Strategy · 07 field route — the route line draws and the stops arrive in order once the route
   enters view. Without JS or with reduced motion, everything is shown at once (see route.css). */
(function () {
  'use strict';
  if (!window.BDH) return;
  var sec = document.querySelector('.cgs-route'); if (!sec) return;
  var track = sec.querySelector('[data-cgs-route]');
  sec.classList.add('cgs-js');
  BDH.enter(track, { cls: 'is-in' });
  BDH.inView(track, function () { sec.classList.add('is-in'); }, { threshold: 0.2 });
})();
