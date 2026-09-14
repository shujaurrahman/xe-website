/* 17 — case slider: arrows, keyboard, swipe, and a slow auto-advance. */
(function () {
  'use strict';
  var root = document.querySelector('[data-s17]');
  if (!root || !window.XE) return;

  var slides = XE.$$('[data-s17-slide]', root);
  var counter = XE.$('[data-s17-i]', root);
  var i = 0, stopped = false, timer = null;

  function show(n) {
    i = ((n % slides.length) + slides.length) % slides.length;
    slides.forEach(function (s, k) { s.classList.toggle('is-on', k === i); });
    if (counter) counter.textContent = ('0' + (i + 1)).slice(-2);
  }
  function halt() { stopped = true; if (timer) timer.stop(); }

  XE.on(XE.$('[data-s17-prev]', root), 'click', function () { halt(); show(i - 1); });
  XE.on(XE.$('[data-s17-next]', root), 'click', function () { halt(); show(i + 1); });
  XE.on(root, 'keydown', function (e) {
    if (e.key === 'ArrowRight') { halt(); show(i + 1); }
    if (e.key === 'ArrowLeft') { halt(); show(i - 1); }
  });

  /* swipe */
  var x0 = null;
  var vp = XE.$('.s17__viewport', root);
  XE.on(vp, 'pointerdown', function (e) { x0 = e.clientX; }, { passive: true });
  XE.on(vp, 'pointerup', function (e) {
    if (x0 === null) return;
    var dx = e.clientX - x0;
    x0 = null;
    if (Math.abs(dx) < 40) return;
    halt(); show(i + (dx < 0 ? 1 : -1));
  });

  show(0);
  if (!XE.reduced) {
    timer = XE.liveTimer(root, 7000, function () { if (!stopped) show(i + 1); });
  }
})();
