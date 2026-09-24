/* Outcomes: dumbbells draw from baseline to result once, when first on screen. Finished state without JS. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  var db = document.querySelector('.pxh-outcomes .pxh-db'); if (!db) return;
  db.classList.add('is-anim');
  BDH.inView(db, function () { requestAnimationFrame(function () { db.classList.add('is-in'); }); });
})();
