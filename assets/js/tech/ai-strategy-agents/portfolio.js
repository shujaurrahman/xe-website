/* AI Strategy & Agents · portfolio — filter chips (by function), the risk-tier switch, selection
   synced between bubbles and the ranked list, and the entry motion (bubbles drift in, then the
   three "build first" paths draw). Overlapping bubbles are nudged apart (a few pixels, never more
   than 28) so every rank stays readable on narrow plots; the chip row fades at its right edge
   while it can still scroll. Reduced motion: no entry motion; controls and layout still work. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var pf = document.querySelector('[data-tas-pf]'); if (!pf) return;
  var data = []; try { data = JSON.parse(pf.getAttribute('data-pf') || '[]'); } catch (e) { return; }
  var chips = BDH.$$('[data-pf-fn]', pf), risk = pf.querySelector('[data-pf-risk]'), legend = pf.querySelector('[data-pf-legend]');
  var bubbles = BDH.$$('.tas-pf__b', pf), rows = BDH.$$('.tas-pf__row', pf), detail = pf.querySelector('.tas-pf__detail');
  var LV = { 1: 'Suggest', 2: 'Draft', 3: 'Act with approval', 4: 'Act within limits' };
  var sel = 0;

  function d(k) { return detail.querySelector('[data-d="' + k + '"]'); }
  function select(i, fromUser) {
    var r = data[i]; if (!r) return;
    sel = i;
    bubbles.forEach(function (b) { b.classList.toggle('is-sel', +b.getAttribute('data-i') === i); });
    rows.forEach(function (b) { b.setAttribute('aria-pressed', +b.getAttribute('data-i') === i ? 'true' : 'false'); });
    d('rank').textContent = (i < 9 ? '0' : '') + (i + 1);
    d('s').textContent = r.s.toFixed(1);
    d('n').textContent = r.n; d('fn').textContent = r.fn; d('own').textContent = r.own; d('ttv').textContent = r.ttv;
    d('vn').textContent = r.vn; d('fnote').textContent = r.fnote; d('rn').textContent = r.rn; d('tier').textContent = r.tier; d('dec').textContent = r.dec;
    d('vbar').style.setProperty('--p', (r.v / 10).toFixed(2));
    d('fbar').style.setProperty('--p', (r.f / 10).toFixed(2));
    var lv = d('lvl').querySelector('.tas-lvl');
    if (lv) { lv.setAttribute('data-l', r.lvl); lv.querySelector('.tas-lvl__n').textContent = 'L' + r.lvl + ' · ' + LV[r.lvl]; }
    if (d('ceil')) d('ceil').textContent = r.ceil;
    if (fromUser && !BDH.reduced) { detail.classList.remove('is-swap'); void detail.offsetWidth; detail.classList.add('is-swap'); }
  }

  function filter(fn) {
    pf.setAttribute('data-fn', fn);
    chips.forEach(function (c) { c.setAttribute('aria-pressed', c.getAttribute('data-pf-fn') === fn ? 'true' : 'false'); });
    bubbles.forEach(function (b) { b.classList.toggle('is-dim', fn !== 'all' && b.getAttribute('data-fn') !== fn); });
    var first = -1;
    rows.forEach(function (b) {
      var li = b.parentNode, show = fn === 'all' || li.getAttribute('data-fn') === fn;
      li.hidden = !show;
      if (show && first === -1) first = +b.getAttribute('data-i');
    });
    var selRow = rows[sel];
    if (selRow && selRow.parentNode.hidden && first > -1) select(first, true);
  }

  chips.forEach(function (c) { c.addEventListener('click', function () { filter(c.getAttribute('data-pf-fn')); }); });
  if (risk) risk.addEventListener('click', function () {
    var on = risk.getAttribute('aria-pressed') !== 'true';
    risk.setAttribute('aria-pressed', on ? 'true' : 'false');
    pf.setAttribute('data-risk', on ? 'on' : 'off');
    if (legend) legend.hidden = !on;
  });
  bubbles.forEach(function (b) { b.addEventListener('click', function () { select(+b.getAttribute('data-i'), true); }); });
  rows.forEach(function (b) {
    b.addEventListener('click', function () { select(+b.getAttribute('data-i'), true); });
    b.addEventListener('keydown', function (e) {
      if (e.key !== 'ArrowDown' && e.key !== 'ArrowUp') return;
      var vis = rows.filter(function (r) { return !r.parentNode.hidden; }), k = vis.indexOf(b);
      var n = vis[k + (e.key === 'ArrowDown' ? 1 : -1)];
      if (n) { e.preventDefault(); n.focus(); select(+n.getAttribute('data-i'), true); }
    });
  });

  /* collision nudge: relax overlapping bubbles apart inside the plot (CSS translate, composes
     with the entry transform) */
  var plot = pf.querySelector('.tas-pf__plot');
  function relax() {
    if (!plot) return;
    var W = plot.clientWidth, H = plot.clientHeight; if (!W || !H) return;
    var n = bubbles.map(function (b) {
      var cs = b.style, x = parseFloat(cs.getPropertyValue('--x')) / 100 * W, y = (100 - parseFloat(cs.getPropertyValue('--y'))) / 100 * H;
      return { b: b, x: x, y: y, r: b.offsetWidth / 2, dx: 0, dy: 0 };
    });
    for (var it = 0; it < 80; it++) {
      var moved = false;
      for (var i = 0; i < n.length; i++) for (var j = i + 1; j < n.length; j++) {
        var a = n[i], c = n[j];
        var vx = (a.x + a.dx) - (c.x + c.dx), vy = (a.y + a.dy) - (c.y + c.dy), dist = Math.sqrt(vx * vx + vy * vy), min = a.r + c.r + 3;
        if (dist >= min) continue;
        if (dist < 0.01) { vx = 1; vy = -1; dist = 1.41; }
        var push = (min - dist) / 2, ux = vx / dist, uy = vy / dist;
        a.dx += ux * push; a.dy += uy * push; c.dx -= ux * push; c.dy -= uy * push; moved = true;
      }
      n.forEach(function (o) {
        o.dx = Math.max(-28, Math.min(28, o.dx)); o.dy = Math.max(-28, Math.min(28, o.dy));
        o.dx = Math.max(o.r - o.x, Math.min(W - o.r - o.x, o.dx)); o.dy = Math.max(o.r - o.y, Math.min(H - o.r - o.y, o.dy));
      });
      if (!moved) break;
    }
    n.forEach(function (o) { o.b.style.translate = (Math.abs(o.dx) > 0.5 || Math.abs(o.dy) > 0.5) ? o.dx.toFixed(1) + 'px ' + o.dy.toFixed(1) + 'px' : ''; });
    /* the "build first" paths start from where the top three bubbles now sit */
    BDH.$$('.tas-pf__paths path', pf).forEach(function (path, k) {
      var o = n[k]; if (!o) return;
      var px = +((o.x + o.dx) / W * 100).toFixed(2), py = +((o.y + o.dy) / H * 100).toFixed(2);
      path.setAttribute('d', 'M' + px + ' ' + py + ' C ' + px + ' ' + (py - 10).toFixed(2) + ', 86 ' + (12 + k * 1.5) + ', 90 5');
    });
  }
  var rq = null;
  function later() { if (rq) cancelAnimationFrame(rq); rq = requestAnimationFrame(function () { rq = null; relax(); }); }
  relax();
  window.addEventListener('resize', later, { passive: true });

  /* chip row: fade the right edge only while there is more to scroll */
  var chipRow = pf.querySelector('.tas-pf__chips');
  function edge() { if (chipRow) chipRow.classList.toggle('is-end', chipRow.scrollLeft + chipRow.clientWidth >= chipRow.scrollWidth - 2); }
  if (chipRow) { chipRow.addEventListener('scroll', edge, { passive: true }); window.addEventListener('resize', edge, { passive: true }); edge(); }

  /* phones: the ranked list shows the top five behind "Show all" (the button only shows there) */
  var more = pf.querySelector('[data-pf-more]'), side = pf.querySelector('.tas-pf__side');
  if (more && side) {
    var moreLabel = more.textContent;
    side.classList.add('is-js'); more.hidden = false;
    more.addEventListener('click', function () {
      var open = !side.classList.contains('is-open');
      side.classList.toggle('is-open', open);
      more.setAttribute('aria-expanded', open ? 'true' : 'false');
      more.textContent = open ? 'Show the top five' : moreLabel;
    });
  }

  if (BDH.reduced) return;
  pf.classList.add('is-armed');
  BDH.enter(pf, { delay: 150, io: { threshold: 0.05, rootMargin: '0px 0px -20% 0px' } });
})();
