/* Brand Systems · 11 outcomes — step the heatmap through the year; outcomes highlight their pattern. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var grid = document.querySelector('[data-cbs-ad]'); if (!grid) return;
  var cells = BDH.$$('.cbs-ad__cell', grid);
  var months = BDH.$$('[data-cbs-ad-month]', grid);
  var outs = BDH.$$('[data-cbs-ad-focus]', grid);
  var avg = grid.querySelector('[data-cbs-ad-avg]');
  var cap = grid.querySelector('[data-cbs-ad-cap]');
  var LABEL = [1, 3, 6, 12];
  var raf = null;

  function show(mi) {
    months.forEach(function (b, i) { b.setAttribute('aria-pressed', String(i === mi)); });
    var sum = 0;
    var targets = cells.map(function (c) { var v = +c.getAttribute('data-m').split(',')[mi]; sum += v; return v; });
    var from = cells.map(function (c) { return parseFloat(c.style.getPropertyValue('--v')) || 0; });
    avg.textContent = 'Average ' + Math.round(sum / cells.length) + '%';
    cap.textContent = 'Share of assets built from system parts at month ' + LABEL[mi] + ', by team and channel. Illustrative.';
    function paint(p) {
      cells.forEach(function (c, i) {
        var v = Math.round(from[i] + (targets[i] - from[i]) * p);
        c.style.setProperty('--v', v);
        c.firstChild.textContent = v;
        c.classList.toggle('is-hi', v >= 55);
        c.classList.toggle('is-low', v < 25);
      });
    }
    if (raf) cancelAnimationFrame(raf);
    if (BDH.reduced) { paint(1); return; }
    var t0 = null;
    raf = requestAnimationFrame(function step(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / 700);
      paint(1 - Math.pow(1 - p, 3));
      if (p < 1) raf = requestAnimationFrame(step);
    });
  }

  function focus(btn) {
    var on = btn && btn.getAttribute('aria-pressed') !== 'true';
    outs.forEach(function (b) { b.setAttribute('aria-pressed', String(on && b === btn)); });
    if (on) { grid.setAttribute('data-focus', btn.getAttribute('data-cbs-ad-focus')); show(3); } else grid.removeAttribute('data-focus');
  }

  months.forEach(function (b, i) { b.addEventListener('click', function () { show(i); }); });
  outs.forEach(function (b) { b.addEventListener('click', function () { focus(b); }); });
  show(3);

  if (BDH.reduced) return;
  BDH.inView(grid, function () {
    var k = 0;
    show(0);
    var auto = BDH.loop(grid, 1800, function () { k = (k + 1) % 4; show(k); });
    BDH.onInteract(grid, function () { auto.stop(); });
  }, { threshold: 0.3 });
})();
