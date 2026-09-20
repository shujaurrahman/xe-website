/* AI Product & Automation · families — each capability strip plays once as its card enters the viewport
   (staggered), then clears so hover and keyboard focus can replay it. On phones the cards are a swipe row;
   the four-segment pager under it follows the scroll position. Reduced motion: no strips play; the pager
   still follows the scroll. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var list = document.querySelector('.tap-fam'); if (!list) return;
  var cards = BDH.$$('.tap-fam__card', list);
  var segs = BDH.$$('.tap-fam__hint b');

  if (segs.length) {
    var raf = 0;
    list.addEventListener('scroll', function () {
      if (raf) return;
      raf = requestAnimationFrame(function () {
        raf = 0;
        var w = cards[0] ? cards[0].getBoundingClientRect().width : 1;
        var i = Math.max(0, Math.min(segs.length - 1, Math.round(list.scrollLeft / Math.max(1, w))));
        segs.forEach(function (s, n) { s.classList.toggle('is-on', n === i); });
      });
    }, { passive: true });
  }

  if (BDH.reduced) return;
  cards.forEach(function (card, i) {
    BDH.inView(card, function () {
      setTimeout(function () {
        card.classList.add('is-play');
        setTimeout(function () { card.classList.remove('is-play'); }, 2000);
      }, 350 + i * 220);
    }, { threshold: 0.45 });
  });
})();
