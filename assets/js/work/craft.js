/* Work · craft — the strip scrolls natively (and with the keyboard) on its own. This only reveals the
   two arrow buttons, which are hidden in the markup so they never appear without JavaScript to run
   them, and keeps their disabled state honest at the ends of the rail. */
(function () {
  'use strict';
  var rail = document.querySelector('[data-wrk-rail]');
  var prev = document.querySelector('[data-wrk-prev]');
  var next = document.querySelector('[data-wrk-next]');
  if (!rail || !prev || !next) return;

  var item = rail.querySelector('.wrk-craft__i');
  function step() {
    var w = item ? item.getBoundingClientRect().width : 240;
    return Math.max(160, w + 16);
  }
  function scrollBy(dir) {
    rail.scrollBy({ left: dir * step(), behavior: window.BDH && BDH.reduced ? 'auto' : 'smooth' });
  }
  function sync() {
    var max = rail.scrollWidth - rail.clientWidth - 2;
    prev.disabled = rail.scrollLeft <= 2;
    next.disabled = rail.scrollLeft >= max;
  }

  prev.hidden = false;
  next.hidden = false;
  prev.addEventListener('click', function () { scrollBy(-1); });
  next.addEventListener('click', function () { scrollBy(1); });
  rail.addEventListener('scroll', sync, { passive: true });
  window.addEventListener('resize', sync);
  sync();
})();
