/* Hub · deliverables — the capability filter. Pressed-state buttons; "All capabilities" is the default and
   the printed state, so with JavaScript off every block is visible. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.mth-del');
  if (!root) return;

  var btns = BDH.$$('.mth-del__f', root);
  var blocks = BDH.$$('.mth-del__block', root);
  if (!btns.length || !blocks.length) return;

  btns.forEach(function (b) {
    b.addEventListener('click', function () {
      var key = b.getAttribute('data-cap');
      btns.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
      root.setAttribute('data-cap', key);
      blocks.forEach(function (bl) {
        bl.classList.toggle('is-on', key === 'all' || bl.getAttribute('data-cap') === key);
      });
    });
  });
})();
