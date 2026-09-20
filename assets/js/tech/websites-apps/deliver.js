/* ==========================================================================
   Websites & Apps · 10 deliver — the repository tree's disclosure buttons.
   Every folder is open in the HTML so the section reads in full without JS;
   here we collapse all but the first two, then let people open and close them.
   ========================================================================== */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.twa-deliver .twa-dl__repo');
  if (!root) return;

  var folds = BDH.$$('[data-dl-fold]', root);
  if (!folds.length) return;

  function set(btn, open) {
    var id = btn.getAttribute('aria-controls');
    var list = id ? document.getElementById(id) : null;
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (list) list.hidden = !open;
  }

  folds.forEach(function (btn, i) {
    set(btn, i < 2);
    btn.addEventListener('click', function () {
      set(btn, btn.getAttribute('aria-expanded') !== 'true');
    });
  });
})();
