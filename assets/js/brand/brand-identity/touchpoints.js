/* Brand Identity · touchpoints — each slide draws its identity overlay in when it scrolls into view;
   mouse drag scrolls the rail (touch and trackpad scroll natively), Previous/Next step one slide,
   counter + progress follow the scroll position. Reduced motion: overlays shown, smooth scroll off. */
(function () {
  'use strict';
  var root = document.querySelector('.cbi-tp'); if (!root) return;
  var sc = root.querySelector('.cbi-tp__scroller');
  var slides = Array.prototype.slice.call(root.querySelectorAll('.cbi-tp__slide'));
  var count = root.querySelector('.cbi-tp__count b');
  var prog = root.querySelector('.cbi-tp__progress');
  var R = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (!sc || !slides.length) return;

  if (R || !('IntersectionObserver' in window)) {
    slides.forEach(function (s) { s.classList.add('is-in'); });
  } else {
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); } });
    }, { threshold: 0.55 });
    slides.forEach(function (s) { io.observe(s); });
  }

  function step() { return slides.length > 1 ? slides[1].offsetLeft - slides[0].offsetLeft : sc.clientWidth; }
  function index() { return Math.max(0, Math.min(slides.length - 1, Math.round(sc.scrollLeft / step()))); }
  function sync() {
    var max = sc.scrollWidth - sc.clientWidth, i = index();
    if (count) count.textContent = ('0' + (max > 0 && sc.scrollLeft >= max - 4 ? slides.length : i + 1)).slice(-2);
    if (prog) prog.style.setProperty('--pp', max > 0 ? Math.max(1 / slides.length, sc.scrollLeft / max).toFixed(3) : 1);
  }
  var tick = 0;
  sc.addEventListener('scroll', function () { if (!tick) tick = requestAnimationFrame(function () { tick = 0; sync(); }); }, { passive: true });
  window.addEventListener('resize', sync);
  sync();

  Array.prototype.forEach.call(root.querySelectorAll('[data-tp]'), function (b) {
    b.addEventListener('click', function () {
      var d = parseInt(b.getAttribute('data-tp'), 10);
      sc.scrollTo({ left: (index() + d) * step(), behavior: R ? 'auto' : 'smooth' });
    });
  });

  /* mouse drag */
  var down = false, x0 = 0, s0 = 0, moved = false;
  sc.addEventListener('pointerdown', function (e) {
    if (e.pointerType !== 'mouse' || e.button !== 0) return;
    down = true; moved = false; x0 = e.clientX; s0 = sc.scrollLeft;
  });
  window.addEventListener('pointermove', function (e) {
    if (!down) return;
    var dx = e.clientX - x0;
    if (!moved && Math.abs(dx) > 4) { moved = true; sc.classList.add('is-drag'); }
    if (moved) sc.scrollLeft = s0 - dx;
  });
  window.addEventListener('pointerup', function () {
    if (!down) return; down = false;
    if (!moved) return;
    var target = index() * step();
    sc.classList.remove('is-drag');
    sc.scrollTo({ left: target, behavior: R ? 'auto' : 'smooth' });
  });
})();
