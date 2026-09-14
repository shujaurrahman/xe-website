/* Hub · industries — one panel open at a time: click / Enter / Space, arrow keys between panels,
   and hover-intent opening on desktop pointers. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.bdh-ind__rail');
  if (!root) return;
  var panels = BDH.$$('.bdh-ind__panel', root);
  var btns = panels.map(function (p) { return p.querySelector('.bdh-ind__btn'); });
  var wide = window.matchMedia('(min-width: 861px) and (pointer: fine)');

  function open(i) {
    panels.forEach(function (p, n) {
      var on = n === i;
      p.classList.toggle('is-open', on);
      btns[n].setAttribute('aria-expanded', on ? 'true' : 'false');
    });
  }

  btns.forEach(function (b, i) {
    b.addEventListener('click', function () {
      var isOpen = panels[i].classList.contains('is-open');
      if (isOpen && !wide.matches) { panels[i].classList.remove('is-open'); b.setAttribute('aria-expanded', 'false'); return; }
      open(i);
    });
    b.addEventListener('keydown', function (e) {
      var k = e.key, j = -1;
      if (k === 'ArrowRight' || k === 'ArrowDown') j = i + 1;
      else if (k === 'ArrowLeft' || k === 'ArrowUp') j = i - 1;
      else if (k === 'Home') j = 0;
      else if (k === 'End') j = btns.length - 1;
      if (j === -1) return;
      e.preventDefault();
      j = (j + btns.length) % btns.length;
      btns[j].focus();
    });
    var t = null;
    panels[i].addEventListener('mouseenter', function () {
      if (!wide.matches) return;
      t = setTimeout(function () { open(i); }, 140);
    });
    panels[i].addEventListener('mouseleave', function () { clearTimeout(t); });
  });
})();
