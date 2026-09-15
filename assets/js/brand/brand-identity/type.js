/* Brand Identity · type — recalculates the ladder from base × ratio^step. Cycles the three ratios
   while untouched (on screen only); the first press takes over. Reduced motion: no cycling. */
(function () {
  'use strict';
  var root = document.querySelector('.cbi-type'); if (!root) return;
  var btns = Array.prototype.slice.call(root.querySelectorAll('.cbi-type__ratio'));
  var rows = Array.prototype.slice.call(root.querySelectorAll('.cbi-type__row'));
  var BASE = 16, cur = 1;

  function set(i) {
    cur = i;
    var r = parseFloat(btns[i].getAttribute('data-r'));
    btns.forEach(function (b, k) { b.setAttribute('aria-pressed', String(k === i)); });
    rows.forEach(function (row) {
      var px = BASE * Math.pow(r, parseInt(row.getAttribute('data-step'), 10));
      row.style.setProperty('--px', px.toFixed(2));
      var p = row.querySelector('.cbi-type__px'), rem = row.querySelector('.cbi-type__rem');
      if (p) p.textContent = px.toFixed(1) + ' px';
      if (rem) rem.textContent = (px / BASE).toFixed(3) + ' rem ·' + rem.textContent.split('·').slice(1).join('·');
      row.classList.add('is-flash');
      setTimeout(function () { row.classList.remove('is-flash'); }, 180);
    });
  }
  btns.forEach(function (b, k) { b.addEventListener('click', function () { set(k); }); });

  if (!window.BDH || BDH.reduced) return;
  var run = BDH.loop(root.querySelector('.cbi-type__ladder'), 2800, function () { set((cur + 1) % btns.length); });
  BDH.onInteract(root, function () { run.stop(); });
})();
