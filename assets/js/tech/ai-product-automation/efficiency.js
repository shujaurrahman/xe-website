/* AI Product & Automation · efficiency — the cost lab. Design radiogroup (arrow keys, aria-checked) and a
   volume slider drive the segmented bars (--o / --w on each segment), the per-stage values, tokens, p95, the
   monthly totals and the delta against design A. Figures tween on change; reduced motion sets them at once.
   All numbers are illustrative and defined here to match the PHP markup. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tap-eff'); if (!root) return;
  var R = BDH.reduced;
  var D = {
    a: { cost: [25, 0, 975, 0], energy: [30, 0, 970, 0], tokens: 5200, p95: '3.4 s', faith: '0.90', seg0: 'Retrieval', how: 'Every question goes to the largest model with five unranked chunks of context. The large model mostly compensates for the noisier context, landing just on the 0.90 gate, at about eleven times the cost of design C.' },
    b: { cost: [40, 30, 57, 0], energy: [45, 60, 115, 0], tokens: 1420, p95: '1.9 s', faith: '0.93', seg0: 'Retrieval & rerank', how: 'A small model classifies the question and answers the routine seventy percent. The rest goes to a larger model with three reranked chunks instead of five.' },
    c: { cost: [28, 20, 36, 6], energy: [30, 40, 75, 5], tokens: 940, p95: '1.2 s', faith: '0.93', seg0: 'Retrieval & rerank', how: 'As B, plus a semantic cache that serves the thirty-five percent of questions asked before, and prompt caching for the static system prompt and tool schemas. ₹90 per 1,000 answers is ₹0.09 each, inside the ₹0.12 release budget.' }
  };
  var SCALE = { cost: 1000, energy: 1000 };
  var VOLS = [20000, 50000, 100000, 200000, 500000, 1000000];
  var radios = BDH.$$('[data-eff-design]', root);
  var vol = root.querySelector('[data-eff-vol]');
  var volOut = root.querySelector('[data-eff-volout]');
  var how = root.querySelector('[data-eff-how]');
  var live = root.querySelector('[data-eff-live]');
  var cur = root.getAttribute('data-design') || 'c';
  var raf = {};

  function inr(n) { return '₹' + Math.round(n).toLocaleString('en-IN'); }
  function num(n) { return Math.round(n).toLocaleString('en-IN'); }
  function sum(a) { return a.reduce(function (s, x) { return s + x; }, 0); }
  function tween(el, to, fmt) {
    if (!el) return;
    if (R) { el.textContent = fmt(to); return; }
    var key = el.getAttribute('data-eff-key') || (el.getAttribute('data-eff-key') === null ? String(Math.random()) : '');
    if (!el.getAttribute('data-eff-key')) el.setAttribute('data-eff-key', key);
    if (raf[key]) cancelAnimationFrame(raf[key]);
    var from = parseFloat((el.textContent || '0').replace(/[^\d.]/g, '')) || 0, t0 = null, dur = 700;
    raf[key] = requestAnimationFrame(function tick(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / dur), k = 1 - Math.pow(1 - p, 3);
      el.textContent = fmt(from + (to - from) * k);
      if (p < 1) raf[key] = requestAnimationFrame(tick); else { el.textContent = fmt(to); raf[key] = null; }
    });
  }

  function paint(announce) {
    var d = D[cur], v = VOLS[parseInt(vol ? vol.value : 3, 10)] || 200000;
    root.setAttribute('data-design', cur);
    radios.forEach(function (r) {
      var on = r.getAttribute('data-eff-design') === cur;
      r.setAttribute('aria-checked', String(on)); r.setAttribute('tabindex', on ? '0' : '-1');
    });
    ['cost', 'energy'].forEach(function (kind) {
      var o = 0, isCost = kind === 'cost';
      d[kind].forEach(function (x, i) {
        var seg = root.querySelector('[data-eff-seg="' + kind + '-' + i + '"]');
        if (seg) { seg.style.setProperty('--o', (o / SCALE[kind]).toFixed(4)); seg.style.setProperty('--w', (x / SCALE[kind]).toFixed(4)); }
        o += x;
        tween(root.querySelector('[data-eff-val="' + kind + '-' + i + '"]'), x, isCost ? inr : function (n) { return num(n) + ' Wh'; });
      });
      tween(root.querySelector('[data-eff-total="' + kind + '"]'), sum(d[kind]), isCost ? inr : function (n) { return num(n) + ' Wh'; });
    });
    tween(root.querySelector('[data-eff-tokens]'), d.tokens, num);
    var p95 = root.querySelector('[data-eff-p95]'); if (p95) p95.textContent = d.p95;
    var faith = root.querySelector('[data-eff-faith]'); if (faith) faith.textContent = d.faith;
    BDH.$$('[data-eff-segname]', root).forEach(function (el) { el.textContent = d.seg0; });
    tween(root.querySelector('[data-eff-month]'), sum(d.cost) * v / 1000, inr);
    tween(root.querySelector('[data-eff-kwh]'), sum(d.energy) * v / 1000 / 1000, function (n) { return num(n) + ' kWh'; });
    var delta = root.querySelector('[data-eff-delta]');
    if (delta) delta.textContent = '−' + Math.round((1 - sum(d.cost) / sum(D.a.cost)) * 100) + '% cost · −' + Math.round((1 - sum(d.energy) / sum(D.a.energy)) * 100) + '% energy';
    if (how) how.textContent = d.how;
    if (volOut) volOut.textContent = num(v);
    if (vol) vol.setAttribute('aria-valuetext', num(v) + ' answers per month');
    if (announce && live) live.textContent = 'Design ' + cur.toUpperCase() + ': ' + inr(sum(d.cost)) + ' and ' + num(sum(d.energy)) + ' watt-hours per 1,000 answers, ' + num(d.tokens) + ' tokens per answer, golden-set faithfulness ' + d.faith + '. At ' + num(v) + ' answers a month: ' + inr(sum(d.cost) * v / 1000) + '.';
  }

  radios.forEach(function (r, i) {
    r.addEventListener('click', function () { cur = r.getAttribute('data-eff-design'); paint(true); });
    r.addEventListener('keydown', function (e) {
      var j = -1;
      if (e.key === 'ArrowRight' || e.key === 'ArrowDown') j = (i + 1) % radios.length;
      else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') j = (i - 1 + radios.length) % radios.length;
      else if (e.key === 'Home') j = 0; else if (e.key === 'End') j = radios.length - 1;
      if (j < 0) return;
      e.preventDefault(); radios[j].focus(); cur = radios[j].getAttribute('data-eff-design'); paint(true);
    });
  });
  /* phone swipe row: focusable (and named) only while it actually scrolls sideways, so keyboards can reach it */
  function swipeFocus(el, label) {
    if (!el) return;
    function sync() {
      var on = el.scrollWidth > el.clientWidth + 2, list = el.tagName === 'UL' || el.tagName === 'OL';
      if (on) { el.setAttribute('tabindex', '0'); el.setAttribute('aria-label', label); if (!list) el.setAttribute('role', 'region'); }
      else { el.removeAttribute('tabindex'); if (!list) { el.removeAttribute('role'); el.removeAttribute('aria-label'); } }
    }
    sync();
    window.addEventListener('resize', sync, { passive: true });
  }
  var tech = document.querySelector('.tap-eff__tech');
  swipeFocus(tech, 'Efficiency techniques, scroll sideways for more');
  if (vol) vol.addEventListener('input', function () { paint(true); });
  paint(false);
})();
