/* Industries · lens — the "read as" control. It only exists once JavaScript is here: the markup ships it
   hidden, so with JS off there is no dead button and the matrix reads as a matrix. Pressing a category
   brings its column forward and steps the others back; "All six" returns to the shipped state. Arrow keys
   move along the control. Nothing animates on a loop, so there is no reduced-motion branch. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var table = document.querySelector('[data-ind-lens]');
  var seg = document.querySelector('[data-ind-lens-seg]');
  if (!table || !seg) return;

  var btns = BDH.$$('button', seg);
  if (btns.length < 2) return;
  seg.removeAttribute('hidden');

  var cells = BDH.$$('th[data-cat], td[data-cat]', table);

  function read(cat) {
    table.classList.toggle('is-reading', !!cat);
    cells.forEach(function (cell) {
      cell.classList.toggle('is-read', !!cat && cell.getAttribute('data-cat') === cat);
    });
    btns.forEach(function (b) {
      b.setAttribute('aria-pressed', String((b.getAttribute('data-cat') || '') === cat));
    });
  }

  btns.forEach(function (b, i) {
    b.addEventListener('click', function () { read(b.getAttribute('data-cat') || ''); });
    b.addEventListener('keydown', function (e) {
      var j = e.key === 'ArrowRight' ? i + 1 : e.key === 'ArrowLeft' ? i - 1 : -99;
      if (j === -99) return;
      e.preventDefault();
      j = (j + btns.length) % btns.length;
      btns[j].focus();
      read(btns[j].getAttribute('data-cat') || '');
    });
  });
})();
