/* 15 — the index in the sticky column. Each entry is a plain #s15-bN link (without JS it jumps to
   the row, whose panel the noscript rule already shows open); here it opens that row through the
   accordion's own button and keeps aria-current on the entry whose row is open. */
(function () {
  'use strict';
  var root = document.querySelector('.s15');
  if (!root || !window.XE) return;
  var links = XE.$$('[data-s15-go]', root);
  if (!links.length) return;
  var btns = links.map(function (a) { return document.getElementById('s15-b' + a.getAttribute('data-s15-go')); });

  function sync() {
    links.forEach(function (a, i) {
      if (btns[i] && btns[i].getAttribute('aria-expanded') === 'true') a.setAttribute('aria-current', 'true');
      else a.removeAttribute('aria-current');
    });
  }
  links.forEach(function (a, i) {
    XE.on(a, 'click', function (e) {
      var b = btns[i];
      if (!b) return;
      e.preventDefault();
      if (b.getAttribute('aria-expanded') !== 'true') b.click();
      b.focus({ preventScroll: true });
      var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
      b.scrollIntoView({ block: 'nearest', behavior: reduce ? 'auto' : 'smooth' });
    });
  });
  if ('MutationObserver' in window) {
    var mo = new MutationObserver(sync);
    btns.forEach(function (b) { if (b) mo.observe(b, { attributes: true, attributeFilter: ['aria-expanded'] }); });
  }
  sync();
})();
