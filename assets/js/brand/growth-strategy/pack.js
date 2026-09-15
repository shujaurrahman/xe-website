/* Growth Strategy · 10 evidence pack — one document out at a time. Hover (fine pointers) or focus pulls a
   spine out; click toggles it for touch and keyboard. Arrow keys move between spines. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cgs-pack]'); if (!root) return;
  var docs = BDH.$$('.cgs-pk__doc', root);
  var btns = docs.map(function (d) { return d.querySelector('.cgs-pk__spine'); });
  var fine = window.matchMedia('(hover:hover) and (pointer:fine)').matches;

  function pull(i) {
    docs.forEach(function (d, n) {
      var on = n === i;
      d.classList.toggle('is-out', on);
      btns[n].setAttribute('aria-expanded', on ? 'true' : 'false');
    });
  }
  btns.forEach(function (b, i) {
    b.addEventListener('click', function () { pull(docs[i].classList.contains('is-out') && !fine ? -1 : i); });
    b.addEventListener('focus', function () { pull(i); });
    if (fine) docs[i].addEventListener('pointerenter', function () { pull(i); });
    b.addEventListener('keydown', function (e) {
      var to = e.key === 'ArrowDown' ? i + 1 : e.key === 'ArrowUp' ? i - 1 : null;
      if (to == null || to < 0 || to >= btns.length) return;
      e.preventDefault(); btns[to].focus();
    });
  });
})();
