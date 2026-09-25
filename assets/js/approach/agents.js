/* Agent register — reveals the matrix filter and narrows the matrix to the actions that run alone or the
   ones that stop for a person. The filter is [hidden] in the markup, so without JavaScript the complete
   matrix is what the page shows. Filtering only dims cells; no row or column is ever removed. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-apr-agents]');
  if (!root) return;
  var wrap = root.querySelector('[data-apr-filter]');
  var btns = BDH.$$('[data-apr-f]', root);
  if (!wrap || !btns.length) return;

  wrap.hidden = false;
  function apply(mode) {
    root.setAttribute('data-filter', mode);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-apr-f') === mode ? 'true' : 'false'); });
  }
  btns.forEach(function (b) {
    b.addEventListener('click', function () { apply(b.getAttribute('data-apr-f')); });
  });
  apply('all');
})();
