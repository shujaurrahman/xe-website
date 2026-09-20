/* AI Strategy & Agents · workshop — the one-page strategy is written on entry: each section starts as
   blank lines and fills in turn (the current number rings), then the four sign-offs tick. The whole
   sequence takes about 2.5 s and starts as soon as the page's top edge is on screen.
   Parallax on the large photograph is handled by hub.js ([data-bdh-parallax]).
   Reduced motion: the finished page, untouched. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var doc = document.querySelector('[data-ws-doc]'); if (!doc || BDH.reduced) return;
  var secs = BDH.$$('.tas-ws__sec', doc), signs = BDH.$$('.tas-ws__sign li', doc);
  doc.classList.add('is-armed');

  BDH.inView(doc, function () {
    var t = 120;
    secs.forEach(function (s, i) {
      setTimeout(function () {
        if (i > 0) secs[i - 1].classList.remove('is-cur');
        s.classList.add('is-on', 'is-cur');
      }, t);
      t += 280;
    });
    setTimeout(function () { var last = secs[secs.length - 1]; if (last) last.classList.remove('is-cur'); }, t);
    signs.forEach(function (li) { t += 150; setTimeout(function () { li.classList.add('is-on'); }, t); });
  }, { threshold: 0.01, rootMargin: '0px 0px -6% 0px' });
})();
