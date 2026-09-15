/* Growth Strategy · 02 where growth hides — each text step sets the treemap state as it crosses
   the middle of the viewport. Reduced motion: states still follow the reader, without transitions. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cgs-hides]'); if (!root) return;
  var fig = root.querySelector('.cgs-hd__fig');
  var steps = BDH.$$('[data-cgs-step]', root);
  function set(el) {
    var s = el.getAttribute('data-cgs-step');
    fig.setAttribute('data-state', s);
    steps.forEach(function (x) { x.classList.toggle('is-on', x === el); });
  }
  var narrow = window.matchMedia('(max-width:1023px)').matches;
  BDH.spy(steps, set, narrow ? '-55% 0px -40% 0px' : '-45% 0px -50% 0px');
})();
