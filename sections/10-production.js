/* 10 — the marquee videos only load and play while the section is on screen. */
(function () {
  'use strict';
  var sec = document.querySelector('.s10');
  if (!sec || !window.XE) return;
  if (XE.reduced || !('IntersectionObserver' in window)) return;

  new IntersectionObserver(function (es) {
    var on = es[0].isIntersecting;
    XE.$$('[data-s10-v]', sec).forEach(function (v) {
      if (on) {
        if (v.preload !== 'auto') { v.preload = 'auto'; v.load(); }
        var pr = v.play();
        if (pr && pr.catch) pr.catch(function () {});
      } else { v.pause(); }
    });
  }, { threshold: 0.05 }).observe(sec);
})();
