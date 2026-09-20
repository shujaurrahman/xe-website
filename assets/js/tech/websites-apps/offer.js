/* Websites & Apps · offer — each card's surface plays once as it enters: the CMS title types and publishes, the
   portal row ships, both phones sync, the basket increments, the offline queue drains, the design sheet assembles.
   Reduced motion: nothing runs; the finished state is in the HTML. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  BDH.$$('.twa-of__card').forEach(function (card) {
    var mock = card.querySelector('.twa-of__mock'); if (!mock) return;
    BDH.inView(mock, function () {
      mock.classList.add('is-play');
      var t = mock.querySelector('[data-om-type]');
      if (t) BDH.type(t, t.textContent, { speed: 42, delay: 250 });
    }, { threshold: 0.55 });
  });
})();
