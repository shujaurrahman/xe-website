/* Bars grow in once on screen. The finished widths are in the HTML; this only adds the start state. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  document.querySelectorAll('[data-aih-bars]').forEach(function (el) {
    el.classList.add('is-anim');
    BDH.inView(el, function () { el.classList.add('is-in'); });
  });
})();
