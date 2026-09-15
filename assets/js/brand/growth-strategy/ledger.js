/* Growth Strategy · 03 research ledger — the hovered or focused row takes the blue rule and swaps the
   documentary photo beside the ledger. Rows are focusable; arrow keys move between them. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cgs-ledger]'); if (!root) return;
  var rows = BDH.$$('[data-cgs-row]', root);
  var phs = BDH.$$('[data-cgs-ph]', root);
  var num = root.querySelector('[data-cgs-phn]'), ttl = root.querySelector('[data-cgs-pht]');
  var cur = 0;
  function show(i) {
    if (i === cur || i < 0 || i >= rows.length) return;
    cur = i;
    rows.forEach(function (r, n) { r.classList.toggle('is-on', n === i); });
    phs.forEach(function (p, n) { p.classList.toggle('is-on', n === i); });
    if (num) num.textContent = (i < 9 ? '0' : '') + (i + 1);
    if (ttl) { var h = rows[i].querySelector('h3'); ttl.textContent = h ? h.textContent : ''; }
  }
  rows.forEach(function (r, n) {
    r.addEventListener('pointerenter', function () { show(n); });
    r.addEventListener('focus', function () { show(n); });
    r.addEventListener('keydown', function (e) {
      var k = e.key, to = -1;
      if (k === 'ArrowDown') to = Math.min(rows.length - 1, n + 1);
      else if (k === 'ArrowUp') to = Math.max(0, n - 1);
      else if (k === 'Home') to = 0;
      else if (k === 'End') to = rows.length - 1;
      if (to > -1) { e.preventDefault(); rows[to].focus(); }
    });
  });
})();
