/* Search & AI Visibility — 05 · Content.
   Links each annotated block in the mocked page to its note, using BDH.spy: whichever block is
   crossing the middle of the viewport marks itself and its note .is-on. Pure emphasis — every note
   and every block is fully readable without this file, and under reduced motion the first pair is
   marked and nothing moves afterwards. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-tsv-anatomy]');
  if (!root) return;

  var blks  = BDH.$$('.tsv-blk', root);
  var notes = BDH.$$('.tsv-note-i', root);
  if (!blks.length || !notes.length) return;

  function mark(key) {
    blks.forEach(function (b) { b.classList.toggle('is-on', b.getAttribute('data-blk') === key); });
    notes.forEach(function (n) { n.classList.toggle('is-on', n.getAttribute('data-note') === key); });
  }

  mark(blks[0].getAttribute('data-blk'));
  if (BDH.reduced) return;

  BDH.spy(blks, function (el) { mark(el.getAttribute('data-blk')); });

  /* hovering or focusing a note also jumps the pairing, so the link is obvious on a big screen */
  notes.forEach(function (n) {
    n.addEventListener('mouseenter', function () { mark(n.getAttribute('data-note')); });
  });
})();
