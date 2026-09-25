/* Industries · matrix — the meters fill in once, column by column, on entry. The shipped HTML already
   shows every meter at its value; the starting class is added here, so the grid is complete without
   JavaScript and under reduced motion. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var wrap = BDH.$('.ind-mtx__wrap');
  if (!wrap || BDH.reduced) return;
  wrap.classList.add('is-anim');
  BDH.enter(wrap, { cls: 'is-in' });
})();
