/* Brand Systems · 05 inventory — toggle audit ↔ consolidated; tiles fly into their canonical slot. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var board = document.querySelector('[data-cbs-inv]'); if (!board) return;
  var btns = BDH.$$('[data-cbs-inv-set]', board);
  var nums = BDH.$$('[data-cbs-inv-total],[data-cbs-inv-retired]', board);
  var sr = board.querySelector('[data-cbs-inv-sr]');
  var cols = BDH.$$('.cbs-inv__col', board);
  var merged = false, raf = null;

  /* offset from each tile's centre to its column's canonical slot */
  function aim() {
    cols.forEach(function (col) {
      var c = col.querySelector('[data-cbs-inv-canon]').getBoundingClientRect();
      var cx = c.left + c.width / 2, cy = c.top + c.height / 2;
      BDH.$$('[data-cbs-inv-tile]', col).forEach(function (t) {
        var was = t.style.transform; t.style.transition = 'none'; t.style.transform = 'none';
        var r = t.getBoundingClientRect();
        t.style.transform = was; void t.offsetWidth; t.style.transition = '';
        t.style.setProperty('--dx', Math.round(cx - (r.left + r.width / 2)) + 'px');
        t.style.setProperty('--dy', Math.round(cy - (r.top + r.height / 2)) + 'px');
      });
    });
  }

  function tween(on) {
    if (raf) cancelAnimationFrame(raf);
    var from = nums.map(function (n) { return parseInt(n.textContent, 10) || 0; });
    var to = nums.map(function (n) { return +n.getAttribute(on ? 'data-b' : 'data-a'); });
    if (BDH.reduced) { nums.forEach(function (n, i) { n.textContent = to[i]; }); return; }
    var t0 = null;
    raf = requestAnimationFrame(function step(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / 900), e = 1 - Math.pow(1 - p, 3);
      nums.forEach(function (n, i) { n.textContent = Math.round(from[i] + (to[i] - from[i]) * e); });
      if (p < 1) raf = requestAnimationFrame(step);
    });
  }

  function set(on) {
    merged = on;
    if (on) aim();
    board.classList.toggle('is-merged', on);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', String((b.getAttribute('data-cbs-inv-set') === '1') === on)); });
    tween(on);
    var tot = nums[0];
    sr.textContent = on
      ? 'After consolidation: ' + tot.getAttribute('data-b') + ' canonical components remain; ' + nums[1].getAttribute('data-b') + ' variants retired.'
      : 'Showing the audit: ' + tot.getAttribute('data-a') + ' component variants found.';
  }

  btns.forEach(function (b) { b.addEventListener('click', function () { set(b.getAttribute('data-cbs-inv-set') === '1'); }); });
  window.addEventListener('resize', function () { if (merged) aim(); });

  if (BDH.reduced) { set(true); return; }
  BDH.inView(board, function () {
    setTimeout(function () { set(true); }, 900);
    var auto = BDH.loop(board, 4200, function () { set(!merged); });
    BDH.onInteract(board, function () { auto.stop(); });
  });
})();
