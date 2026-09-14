/* 05 — the diagram only animates while it is on screen, and never under
   reduced motion. Everything else is CSS. */
(function () {
  'use strict';
  var d = document.querySelector('[data-s05]');
  if (!d || !window.XE || XE.reduced) return;
  if (!('IntersectionObserver' in window)) { d.classList.add('is-live'); return; }
  new IntersectionObserver(function (es) {
    d.classList.toggle('is-live', es[0].isIntersecting && !document.hidden);
  }, { threshold: 0.12 }).observe(d);
  document.addEventListener('visibilitychange', function () {
    if (document.hidden) d.classList.remove('is-live');
  });
})();
