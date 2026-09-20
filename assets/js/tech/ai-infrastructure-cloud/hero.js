/* AI Infrastructure & Cloud · hero — keeps the telemetry bento moving while it is on screen:
   heatmap columns shift left each second, latency lines scroll, the throughput gauge breathes,
   cost per 1k requests steps, region traffic shares drift. Reduced motion: the PHP still frame stays. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  var bento = document.querySelector('.tic-bento');
  if (!bento) return;
  var $ = function (s) { return bento.querySelector(s); }, $$ = function (s) { return BDH.$$(s, bento); };
  function clamp(v, a, b) { return Math.max(a, Math.min(b, v)); }
  function jitter(n) { return (Math.random() - 0.5) * n; }

  BDH.live(bento, 0.1);

  /* ---- heatmap ---- */
  var rows = $$('.tic-heat__row'), utilEl = $('[data-hero-util]'), tick = 0;
  function heat() {
    var sum = 0, cnt = 0;
    rows.forEach(function (row, n) {
      var base = parseFloat(row.getAttribute('data-base')) || 0;
      var last = row.lastElementChild, prev = parseFloat(last.style.getPropertyValue('--v')) || base;
      var v = base < 0.1 ? clamp(0.04 + Math.random() * 0.05, 0.02, 0.12)
                         : clamp(prev * 0.55 + (base + 0.11 * Math.sin((tick + n * 7) / 6)) * 0.45 + jitter(0.34), 0.08, 1);
      var cell = row.firstElementChild;
      cell.style.setProperty('--v', v.toFixed(2));
      row.appendChild(cell);
      if (base >= 0.1) {
        BDH.$$('i', row).forEach(function (c) { sum += parseFloat(c.style.getPropertyValue('--v')) || 0; cnt++; });
      }
    });
    if (utilEl && cnt) utilEl.textContent = Math.round(sum / cnt * 100);
  }

  /* ---- latency: redraw one step further on, then glide one step left over the tick ---- */
  var svg = $('[data-hero-series]'), lines = svg ? BDH.$('.tic-lat__lines', svg) : null, series = null;
  try { series = JSON.parse(svg.getAttribute('data-hero-series')); } catch (e) { series = null; }
  var paths = { p50: $('.tic-lat__p50'), p95: $('.tic-lat__p95'), p99: $('.tic-lat__p99') };
  var labels = { p50: $('[data-hero-lat="p50"]'), p95: $('[data-hero-lat="p95"]'), p99: $('[data-hero-lat="p99"]') };
  var bump = 0;
  function fmt(s) { return s < 1 ? Math.round(s * 1000) + ' ms' : s.toFixed(2) + ' s'; }
  function d(pts) {
    var out = '';
    for (var i = 0; i < pts.length; i++) out += (i ? 'L' : 'M') + (i * 10) + ',' + (200 - clamp(pts[i], 0, 2) * 100).toFixed(1);
    return out;
  }
  function lat() {
    if (!series || !lines) return;
    if (bump <= 0 && Math.random() < 0.05) bump = 9;              // an occasional short latency bump
    var b = bump > 0 ? Math.sin((9 - bump) / 9 * Math.PI) : 0; bump--;
    var w = Math.sin(tick / 5.5) * 0.03 + jitter(0.04);
    var nv = { p50: 0.42 + w * 0.6 + b * 0.08, p95: 0.92 + w * 1.4 + jitter(0.06) + b * 0.34, p99: 1.28 + w * 2 + jitter(0.12) + b * 0.46 };
    ['p50', 'p95', 'p99'].forEach(function (k) {
      series[k].shift(); series[k].push(nv[k]);
      if (paths[k]) paths[k].setAttribute('d', d(series[k]));
      if (labels[k]) labels[k].textContent = fmt(series[k][60]);
    });
    lines.style.transition = 'none';
    lines.style.transform = 'translateX(0)';
    void lines.getBoundingClientRect();
    lines.style.transition = 'transform 1s linear';
    lines.style.transform = 'translateX(-10px)';
  }

  /* ---- throughput gauge ---- */
  var gauge = $('[data-hero-gauge]'), tpsEl = $('[data-hero-tps]'), ttft = $('[data-hero-ttft]'), batch = $('[data-hero-batch]');
  var tps = 18.4;
  function gaugeTick() {
    tps = clamp(tps + jitter(1.8), 15.6, 21.8);
    if (gauge) gauge.style.strokeDashoffset = (100 - tps / 24 * 100).toFixed(1);
    if (tpsEl) tpsEl.textContent = tps.toFixed(1) + 'k';
    if (ttft) ttft.textContent = Math.round(250 + (tps - 15.6) * 9 + jitter(20)) + ' ms';
    if (batch) batch.textContent = Math.round(tps * 2.3 + jitter(4)) + ' seqs';
  }

  /* ---- cost per 1k: a new hourly step ---- */
  var costSvg = $('[data-hero-costs]'), costLine = $('.tic-cost__line'), costEl = $('[data-hero-cost]'), cacheEl = $('[data-hero-cache]');
  var costs = null;
  try { costs = JSON.parse(costSvg.getAttribute('data-hero-costs')); } catch (e) { costs = null; }
  function cy(v) { return (120 - (v - 0.8) / 1.0 * 120).toFixed(1); }
  function costTick() {
    if (!costs || !costLine) return;
    var last = costs[costs.length - 1];
    costs.shift(); costs.push(Math.round(clamp(last + jitter(0.09), 1.09, 1.37) * 100) / 100);
    var out = '';
    costs.forEach(function (v, i) {
      var x = (i * 300 / 24).toFixed(1), x2 = ((i + 1) * 300 / 24).toFixed(1);
      out += (i ? 'L' + x + ',' + cy(v) : 'M0,' + cy(v)) + 'L' + x2 + ',' + cy(v);
    });
    costLine.setAttribute('d', out);
    if (costEl) costEl.textContent = costs[costs.length - 1].toFixed(2);
    if (cacheEl) cacheEl.textContent = Math.round(clamp(31 + jitter(6), 26, 36)) + '%';
  }

  /* ---- region shares drift, always summing to 100 ---- */
  var shares = $$('.tic-reg__share'), base = [62, 23, 15];
  function regionTick() {
    var a = Math.round(clamp(base[0] + jitter(6), 56, 68)), c = Math.round(clamp(base[2] + jitter(4), 12, 18)), b = 100 - a - c;
    [a, b, c].forEach(function (v, i) {
      if (!shares[i]) return;
      var bar = shares[i].querySelector('i'), lab = shares[i].querySelector('b');
      if (bar) bar.style.setProperty('--w', (v / 100).toFixed(2));
      if (lab) lab.textContent = v + '%';
    });
  }

  BDH.loop(bento, 1000, function () {
    tick++;
    heat(); lat();
    if (tick % 2 === 0) gaugeTick();
    if (tick % 3 === 0) costTick();
    if (tick % 4 === 0) regionTick();
  });
})();
