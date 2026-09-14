/* 22 — the orbit dots only travel while the band is on screen and the tab is
   visible. Everything else in the section is CSS. */
(function () {
  'use strict';
  var sec = document.querySelector('.s22');
  if (!sec || !window.XE || XE.reduced) return;
  if (!('IntersectionObserver' in window)) { sec.classList.add('is-live'); return; }
  new IntersectionObserver(function (es) {
    sec.classList.toggle('is-live', es[0].isIntersecting && !document.hidden);
  }, { threshold: 0 }).observe(sec);
  document.addEventListener('visibilitychange', function () {
    if (document.hidden) sec.classList.remove('is-live');
  });
})();
