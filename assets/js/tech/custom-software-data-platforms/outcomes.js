/* Custom Software & Data Platforms · outcomes — the ladder is armed (unlit) and lights from the bottom rung up,
   once, when it enters the viewport. Reduced motion: the finished, fully lit ladder from the HTML. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  var oc = document.querySelector('.tcs-outcomes .tcs-oc'); if (!oc) return;
  var ladder = oc.querySelector('.tcs-oc__ladder'); if (!ladder) return;
  oc.classList.add('is-arm');
  BDH.inView(ladder, function () { oc.classList.add('is-in'); }, { threshold: 0.3 });
})();
