/* 13 — the two photographs drift a few pixels apart as the section passes. */
(function () {
  'use strict';
  var el = document.querySelector('[data-s13-collage]');
  if (!el || !window.XE || XE.reduced) return;
  if (!window.matchMedia('(pointer:fine)').matches) return;
  if (!window.matchMedia('(min-width:901px)').matches) return;

  var on = false, ticking = false;
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (es) { on = es[0].isIntersecting; if (on) tick(); },
      { threshold: 0 }).observe(el);
  } else { on = true; }

  function tick() {
    ticking = false;
    if (!on) return;
    var r = el.getBoundingClientRect();
    var p = (r.top + r.height / 2 - window.innerHeight / 2) / window.innerHeight; /* -1 … 1 */
    p = XE.clamp(p, -1, 1);
    el.style.setProperty('--p1', (p * 18).toFixed(1) + 'px');
    el.style.setProperty('--p2', (p * -18).toFixed(1) + 'px');
  }
  XE.on(window, 'scroll', function () {
    if (!ticking && on) { ticking = true; requestAnimationFrame(tick); }
  }, { passive: true });
  tick();
})();
