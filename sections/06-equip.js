/* 06 — capability rail. The rail is a native scroll-snap row; this script only
   drives it. Arrows and ←/→ on the focused rail move one card; Home/End jump.
   Auto-advance runs only while the rail is on screen, pauses while the pointer or
   focus is on it, and stops for good after any manual move or the pause button.
   Nothing auto-advances or loops under reduced motion. */
(function () {
  'use strict';
  var sec = document.querySelector('.s06');
  if (!sec || !window.XE) return;
  var rail = XE.$('[data-s06-rail]', sec);
  var track = XE.$('[data-s06-track]', sec);
  var nav = XE.$('[data-s06-nav]', sec);
  if (!rail || !track || !nav) return;
  var slides = XE.$$('.s06__slide', track);
  var n = slides.length;
  var play = XE.$('[data-s06-play]', sec);
  var count = XE.$('[data-s06-count]', sec);
  nav.hidden = false;

  function pad(v) { return (v < 10 ? '0' : '') + v; }
  function padL() { return parseFloat(getComputedStyle(track).paddingLeft) || 0; }
  function maxX() { return rail.scrollWidth - rail.clientWidth; }

  /* first card whose start is at (or past) the scroll edge, and last fully visible card */
  function range() {
    var x = rail.scrollLeft + padL(), w = rail.clientWidth - 2 * padL();
    var first = 0, best = Infinity, last = 0;
    slides.forEach(function (s, k) {
      var d = Math.abs(s.offsetLeft - x);
      if (d < best) { best = d; first = k; }
      if (s.offsetLeft + s.offsetWidth <= x + w + 4) last = k;
    });
    if (rail.scrollLeft >= maxX() - 2) last = n - 1;
    return [first, Math.max(first, last)];
  }
  function paint() {
    var r = range();
    count.textContent = (r[0] === r[1] ? pad(r[0] + 1) : pad(r[0] + 1) + '–' + pad(r[1] + 1)) + ' / ' + pad(n);
  }
  var ticking = false;
  XE.on(rail, 'scroll', function () {
    if (ticking) return; ticking = true;
    requestAnimationFrame(function () { ticking = false; paint(); });
  }, { passive: true });

  function go(k) {
    k = Math.max(0, Math.min(n - 1, k));
    rail.scrollTo({ left: Math.min(maxX(), slides[k].offsetLeft - padL()), behavior: XE.reduced ? 'auto' : 'smooth' });
  }
  function step(d) {
    var r = range(), atEnd = rail.scrollLeft >= maxX() - 2;
    if (d > 0) go(atEnd ? 0 : r[0] + 1);
    else go(r[0] === 0 && rail.scrollLeft < 2 ? n - 1 : r[0] - 1);
  }

  /* ---- auto-advance ---- */
  var auto = !XE.reduced, onScreen = false, held = false, timer = null;
  function sync() {
    var run = auto && onScreen && !held && !document.hidden;
    if (run && timer === null) timer = setInterval(function () { step(1); }, 4200);
    if (!run && timer !== null) { clearInterval(timer); timer = null; }
    sec.classList.toggle('is-live', onScreen && !XE.reduced && !document.hidden);
    sec.classList.toggle('is-held', held);
  }
  function stopAuto() {
    if (!auto) return;
    auto = false; sync();
    if (play) { play.classList.add('is-paused'); play.setAttribute('aria-pressed', 'true'); }
  }
  function startAuto() {
    auto = true; sync();
    if (play) { play.classList.remove('is-paused'); play.setAttribute('aria-pressed', 'false'); }
  }

  if (XE.reduced && play) { play.hidden = true; auto = false; }
  if (play) XE.on(play, 'click', function () { auto ? stopAuto() : startAuto(); });
  XE.on(XE.$('[data-s06-prev]', sec), 'click', function () { stopAuto(); step(-1); });
  XE.on(XE.$('[data-s06-next]', sec), 'click', function () { stopAuto(); step(1); });

  XE.on(rail, 'keydown', function (e) {
    var k = e.key;
    if (k === 'ArrowRight') step(1);
    else if (k === 'ArrowLeft') step(-1);
    else if (k === 'Home') go(0);
    else if (k === 'End') go(n - 1);
    else return;
    e.preventDefault(); stopAuto();
  });
  /* a swipe, drag or sideways wheel is a manual move too */
  XE.on(rail, 'pointerdown', stopAuto);
  XE.on(rail, 'wheel', function (e) { if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) stopAuto(); }, { passive: true });

  /* hovering or focusing the rail or its controls holds everything in place */
  [rail, nav].forEach(function (el) {
    XE.on(el, 'mouseenter', function () { held = true; sync(); });
    XE.on(el, 'mouseleave', function () { held = false; sync(); });
    XE.on(el, 'focusin', function () { held = true; sync(); });
    XE.on(el, 'focusout', function (e) { if (!el.contains(e.relatedTarget)) { held = false; sync(); } });
  });

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (es) { onScreen = es[es.length - 1].isIntersecting; sync(); },
      { threshold: 0.3 }).observe(rail);
  } else { onScreen = true; }
  document.addEventListener('visibilitychange', sync);
  XE.on(window, 'resize', paint);
  paint(); sync();
})();
