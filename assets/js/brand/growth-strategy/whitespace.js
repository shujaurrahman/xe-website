/* Growth Strategy · 05 competitive whitespace — the axis select moves every brand dot to its position on
   the new pair, resizes the whitespace zone and rewrites the finding. Until touched, it cycles the lenses. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cgs-white]'); if (!root) return;
  var pairs = JSON.parse(root.getAttribute('data-pairs'));
  var sel = root.querySelector('[data-cgs-axes]');
  var dots = BDH.$$('[data-cgs-dot]', root);
  var zone = root.querySelector('[data-cgs-zone]');
  var find = root.querySelector('.cgs-ws__find');
  var t = root.querySelector('[data-cgs-wt]'), d = root.querySelector('[data-cgs-wd]');
  var ax = { x0: '[data-cgs-x0]', x1: '[data-cgs-x1]', y0: '[data-cgs-y0]', y1: '[data-cgs-y1]' };
  Object.keys(ax).forEach(function (k) { ax[k] = root.querySelector(ax[k]); });

  function apply(i) {
    var p = pairs[i]; if (!p) return;
    dots.forEach(function (el, n) {
      var xy = p.pos[n]; if (!xy) return;
      el.style.setProperty('--d', n);
      el.style.left = xy[0] + '%'; el.style.top = (100 - xy[1]) + '%';
    });
    zone.style.left = p.zone[0] + '%'; zone.style.top = (100 - p.zone[1] - p.zone[3]) + '%';
    zone.style.width = p.zone[2] + '%'; zone.style.height = p.zone[3] + '%';
    ax.x0.textContent = p.x[0]; ax.x1.textContent = p.x[1] + ' →';
    ax.y0.textContent = p.y[0]; ax.y1.textContent = '↑ ' + p.y[1];
    t.textContent = p.t; d.textContent = p.d;
    BDH.$$('[data-cgs-test]', root).forEach(function (el, n) { if (p.test && p.test[n]) el.textContent = p.test[n]; });
    find.classList.remove('is-swap'); void find.offsetWidth; find.classList.add('is-swap');
  }
  sel.addEventListener('change', function () { apply(+sel.value); });

  if (BDH.reduced) return;
  BDH.live(root, 0.25);
  BDH.seq(root, [[5200, function () { sel.value = String((+sel.value + 1) % pairs.length); apply(+sel.value); }]], { loop: true, stopOnInteract: true });
})();
