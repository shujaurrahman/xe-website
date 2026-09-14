/* Hub · measurement — Quarter / Year toggle for the illustrative dashboard (swaps the sparklines). */
(function () {
  'use strict';
  if (!window.BDH) return;
  var dash = document.querySelector('.bdh-ms__dash');
  if (!dash) return;
  var btns = BDH.$$('.bdh-seg button', dash);
  btns.forEach(function (b) {
    b.addEventListener('click', function () {
      var v = b.getAttribute('data-view');
      dash.setAttribute('data-view', v);
      btns.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
    });
  });
})();
