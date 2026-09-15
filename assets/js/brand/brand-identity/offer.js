/* Brand Identity · offer — while nobody is touching the grid, one specimen at a time flexes from
   light to heavy. Stops for good on the first hover, tap, key or focus inside. Reduced: nothing. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  var grid = document.querySelector('.cbi-offer__grid'); if (!grid) return;
  var cards = BDH.$$('.cbi-spec', grid); if (!cards.length) return;
  var k = -1;
  var run = BDH.loop(grid, 1700, function () {
    k = (k + 1) % cards.length;
    cards.forEach(function (c, j) { c.classList.toggle('is-flex', j === k); });
  });
  function off() {
    run.stop();
    cards.forEach(function (c) { c.classList.remove('is-flex'); });
    grid.removeEventListener('mouseover', off);
  }
  grid.addEventListener('mouseover', off);
  BDH.onInteract(grid, off);
})();
