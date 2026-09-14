/* Hub · navigator dock — visible (and focusable) only while the reader is inside #capabilities and
   the in-page index is out of view; marks the capability being read and shows progress. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var dock = document.querySelector('.bdh-dock');
  var caps = document.getElementById('capabilities');
  var index = document.getElementById('navigator');
  if (!dock || !caps || !('IntersectionObserver' in window)) return;

  var links = BDH.$$('.bdh-dock__a', dock);
  var bar = BDH.$('.bdh-dock__bar i', dock);
  var inCaps = false, indexOn = false;

  function sync() {
    var on = inCaps && !indexOn && window.innerWidth >= 1024;
    dock.classList.toggle('is-on', on);
    if (on) dock.removeAttribute('inert'); else dock.setAttribute('inert', '');
  }
  new IntersectionObserver(function (es) { inCaps = es[es.length - 1].isIntersecting; sync(); }, { rootMargin: '-35% 0px -35% 0px' }).observe(caps);
  if (index) new IntersectionObserver(function (es) { indexOn = es[es.length - 1].isIntersecting; sync(); }).observe(index);
  window.addEventListener('resize', sync, { passive: true });

  BDH.spy('#capabilities [data-cap]', function (el) {
    var slug = el.getAttribute('data-cap');
    links.forEach(function (a) {
      if (a.getAttribute('data-dock') === slug) a.setAttribute('aria-current', 'true');
      else a.removeAttribute('aria-current');
    });
  });
  if (bar) BDH.progress(caps, function (p) { bar.style.transform = 'scaleX(' + p.toFixed(3) + ')'; });
})();
