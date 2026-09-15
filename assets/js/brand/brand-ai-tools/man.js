/* 12 Man page FAQ — one section open at a time; closed panels are inert to assistive tech and focus. */
(function () {
  'use strict';
  var root = document.querySelector('.cat-man'); if (!root) return;
  var items = Array.prototype.slice.call(root.querySelectorAll('.cat-man__item'));

  function paint() {
    items.forEach(function (it) {
      var open = it.classList.contains('is-open');
      it.querySelector('.cat-man__btn').setAttribute('aria-expanded', open ? 'true' : 'false');
      var p = it.querySelector('.cat-man__panel');
      if (open) { p.removeAttribute('inert'); p.removeAttribute('aria-hidden'); }
      else { p.setAttribute('inert', ''); p.setAttribute('aria-hidden', 'true'); }
    });
  }

  items.forEach(function (it) {
    it.querySelector('.cat-man__btn').addEventListener('click', function () {
      var was = it.classList.contains('is-open');
      items.forEach(function (x) { x.classList.remove('is-open'); });
      if (!was) it.classList.add('is-open');
      paint();
    });
  });
  paint();
})();
