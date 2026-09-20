/* Tech Workforce · deliver — read one engagement model down the manifest.
   Hovering or focusing any cell in a model column lights that whole column, head included, so
   "what does a pod include?" is answered by eye rather than by counting ticks across nine rows.
   Nothing is hidden and nothing moves: with JS off the table is already complete, and the count in
   each column head is rendered by PHP. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var tbl = document.querySelector('[data-ttw-dlv]');
  if (!tbl) return;

  var cells = BDH.$$('[data-ttw-col]', tbl);
  if (!cells.length) return;
  var cur = null;

  function paint(col) {
    if (col === cur) return;
    cur = col;
    cells.forEach(function (c) {
      c.classList.toggle('is-hl', col !== null && c.getAttribute('data-ttw-col') === col);
    });
  }

  function from(ev) {
    var t = ev.target && ev.target.closest ? ev.target.closest('[data-ttw-col]') : null;
    paint(t ? t.getAttribute('data-ttw-col') : null);
  }

  tbl.addEventListener('pointermove', from);
  tbl.addEventListener('pointerleave', function () { paint(null); });
  tbl.addEventListener('focusin', from);
  tbl.addEventListener('focusout', function () { paint(null); });
})();
