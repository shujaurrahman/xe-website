/* §10 outcomes — arm each before/after pair, then strike the before line and write in the after line
   as the row enters. Without JS or under reduced motion the pair simply shows its final state. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  BDH.$$('[data-cbf-room]').forEach(function (row) {
    row.classList.add('is-arm');
    BDH.enter(row, { cls: 'is-in' });
  });
})();
