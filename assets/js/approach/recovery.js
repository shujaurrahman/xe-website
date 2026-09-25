/* Recovery — the worked incident timeline. The markup ships the finished timeline; this removes the
   finished class at init and walks it once when the section is first seen. Under reduced motion it does
   nothing at all, so the finished state stays on the page. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  var root = document.querySelector('[data-apr-run]');
  if (!root) return;
  var items = BDH.$$('.apr-rc__tl > li', root);
  if (!items.length) return;

  root.classList.add('is-anim');
  items.forEach(function (li) { li.classList.remove('is-done'); });
  BDH.inView(root, function () {
    items.forEach(function (li, i) {
      window.setTimeout(function () { li.classList.add('is-done'); }, 180 + i * 260);
    });
  });
})();
