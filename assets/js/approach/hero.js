/* Approach hero + the page-level helper.
   1. The console's log lines arrive one at a time when the panel is first seen. Finished state without
      JavaScript, and nothing happens at all under reduced motion.
   2. Edge fades on the page's sideways-scrolling regions. `.mask-x` fades both edges unconditionally,
      which clips readable text in a table that is not actually scrolling, so every scroller on this page
      ships with `.apr-nomask` (mask off) and this removes it only where the content really overflows.
      hero.js is the first section script the shell loads, so it stands in as the page-level script. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var scrollers = BDH.$$('.apr .bdh-scroll-x.apr-nomask');
  if (scrollers.length) {
    var sync = function () {
      scrollers.forEach(function (el) {
        el.classList.toggle('apr-nomask', el.scrollWidth - el.clientWidth < 3);
      });
    };
    sync();
    window.addEventListener('resize', sync);
    if (window.ResizeObserver) {
      var ro = new ResizeObserver(sync);
      scrollers.forEach(function (el) { ro.observe(el); });
    }
  }

  var cp = document.querySelector('.apr-cp');
  if (!cp || BDH.reduced) return;
  var lines = BDH.$$('.apr-cp__log li', cp);
  cp.classList.add('is-anim');
  BDH.inView(cp, function () {
    lines.forEach(function (li, n) { window.setTimeout(function () { li.classList.add('is-in'); }, 300 + n * 420); });
  });
})();
