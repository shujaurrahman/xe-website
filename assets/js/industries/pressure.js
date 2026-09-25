/* Industries · pressure — the landing grid fills its meters once, left to right, on entry.
   The shipped HTML already shows every meter at its value; this only adds the starting class,
   so with JavaScript off (or under reduced motion) the grid is complete from the first paint. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var grid = BDH.$('.ind-prs__grid');
  if (!grid || BDH.reduced) return;
  grid.classList.add('is-anim');
  BDH.enter(grid, { cls: 'is-in' });
})();
