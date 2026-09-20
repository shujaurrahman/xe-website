/* Tech Workforce · skills — filter the depth matrix by area.
   Without JS every technology is shown, which is the honest default; this only narrows the list
   and keeps the column rule between the two columns on the visible rows. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-ttw-skl]');
  if (!root) return;

  var rows = BDH.$$('.ttw-skl__row', root);
  var list = BDH.$('.ttw-skl__rows', root);
  var btns = BDH.$$('.ttw-skl__f', document.querySelector('.ttw-skl'));
  if (!rows.length || !btns.length || !list) return;

  list.classList.add('is-js');
  /* The buttons ship disabled so a no-JS visitor is not offered a filter that cannot run. */
  btns.forEach(function (b) { b.disabled = false; });

  function apply(area) {
    var seen = 0;
    rows.forEach(function (r) {
      var on = area === 'all' || r.getAttribute('data-area') === area;
      r.classList.toggle('is-off', !on);
      r.classList.toggle('is-r', on && seen % 2 === 0);
      if (on) seen++;
    });
    btns.forEach(function (b) {
      b.setAttribute('aria-pressed', b.getAttribute('data-ttw-area') === area ? 'true' : 'false');
    });
  }

  btns.forEach(function (b) {
    b.addEventListener('click', function () { apply(b.getAttribute('data-ttw-area')); });
  });

  apply('all');
})();
