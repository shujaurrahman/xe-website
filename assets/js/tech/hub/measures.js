/* Hub · measures — the service report works like the real thing. The period switch (aria-pressed) redraws every
   sparkline from its series and rewrites the change over the period. The (i) button pins a card's definition
   open (hover and focus open it too, in CSS); Escape closes it. While the report is on screen, one card at a time
   receives a new datapoint: its line shifts left and the latest point pulses. Reduced motion: the switch and the
   definitions work instantly; no datapoints arrive on their own. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tih-ms');
  if (!root) return;

  var W = 240, H = 64;
  var btns = BDH.$$('.tih-ms__seg button', root);
  var LABEL = { '30': ['30 days', '30 days ago'], '90': ['90 days', '90 days ago'], '365': ['12 months', '12 months ago'] };
  var period = root.getAttribute('data-period') || '365';

  var cards = BDH.$$('.tih-ms__card', root).map(function (el) {
    var c = { el: el, series: {}, range: [0, 1], fmt: [0, '', ''] };
    try { c.series = JSON.parse(el.getAttribute('data-series')); c.range = JSON.parse(el.getAttribute('data-range')); c.fmt = JSON.parse(el.getAttribute('data-fmt')); } catch (err) { /* keep the markup */ }
    c.line = BDH.$('.tih-ms__line', el); c.area = BDH.$('.tih-ms__area', el); c.dot = BDH.$('.tih-ms__dot', el);
    c.delta = BDH.$('[data-delta]', el); c.from = BDH.$('[data-from]', el); c.fresh = BDH.$('[data-new]', el);
    c.info = BDH.$('.tih-ms__info', el);
    c.integer = c.fmt[0] === 0;
    return c;
  });
  if (!cards.length) return;

  function y(v, r) { return (H - 6) - (v - r[0]) / (r[1] - r[0]) * (H - 12); }
  function path(vals, r) {
    var n = vals.length, d = '';
    for (var i = 0; i < n; i++) d += (i ? ' L' : 'M') + (i / (n - 1) * W).toFixed(2) + ' ' + y(vals[i], r).toFixed(2);
    return d;
  }
  function fmtDelta(c, a, b, per) {
    var dv = b - a;
    if (Math.abs(dv) < 0.00001) return '→ no change · ' + per;
    var n = Math.abs(dv).toFixed(c.fmt[0]);
    return (dv < 0 ? '▼ ' : '▲ ') + c.fmt[1] + n + c.fmt[2] + ' · ' + per;
  }
  function restart(el) {
    if (!el || BDH.reduced) return;
    el.classList.remove('is-draw'); void el.getBoundingClientRect(); el.classList.add('is-draw');
  }
  function draw(c, vals, redraw) {
    var d = path(vals, c.range);
    if (c.line) c.line.setAttribute('d', d);
    if (c.area) c.area.setAttribute('d', d + ' L' + W + ' ' + H + ' L0 ' + H + ' Z');
    if (c.dot) c.dot.style.setProperty('--y', (y(vals[vals.length - 1], c.range) / H * 100).toFixed(2));
    if (redraw) { restart(c.line); restart(c.area); }
  }

  /* ---- period switch ---- */
  function show(p) {
    if (!LABEL[p]) return;
    period = p;
    root.setAttribute('data-period', p);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-period') === p ? 'true' : 'false'); });
    cards.forEach(function (c) {
      var vals = c.series[p];
      if (!vals || !vals.length) return;
      c.live = vals.slice();
      draw(c, c.live, true);
      if (c.delta) c.delta.textContent = fmtDelta(c, vals[0], vals[vals.length - 1], LABEL[p][0]);
      if (c.from) c.from.textContent = LABEL[p][1];
    });
  }
  btns.forEach(function (b, i) {
    b.addEventListener('click', function () { show(b.getAttribute('data-period')); });
    b.addEventListener('keydown', function (e) {
      var j = e.key === 'ArrowRight' ? i + 1 : e.key === 'ArrowLeft' ? i - 1 : -99;
      if (j === -99) return;
      e.preventDefault();
      j = (j + btns.length) % btns.length;
      btns[j].focus(); show(btns[j].getAttribute('data-period'));
    });
  });
  cards.forEach(function (c) { c.live = (c.series[period] || []).slice(); });

  /* ---- definitions: click pins, Escape closes ---- */
  cards.forEach(function (c) {
    if (!c.info) return;
    c.info.addEventListener('click', function () {
      var open = !c.el.classList.contains('is-def');
      cards.forEach(function (o) { o.el.classList.remove('is-def'); if (o.info) o.info.setAttribute('aria-expanded', 'false'); });
      c.el.classList.toggle('is-def', open);
      c.info.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  });
  root.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    cards.forEach(function (c) {
      if (!c.el.classList.contains('is-def')) return;
      c.el.classList.remove('is-def');
      if (c.info) { c.info.setAttribute('aria-expanded', 'false'); c.info.focus(); }
    });
  });

  /* ---- a new datapoint, one card at a time, while on screen ---- */
  if (BDH.reduced) return;
  var k = 0;
  function stamp() {
    var d = new Date(), h = d.getHours(), m = d.getMinutes();
    return (h < 10 ? '0' : '') + h + ':' + (m < 10 ? '0' : '') + m;
  }
  BDH.loop(root, 3000, function () {
    var c = cards[k % cards.length]; k++;
    if (!c.live || c.live.length < 3) return;
    var last = c.live[c.live.length - 1], span = c.range[1] - c.range[0];
    var next = last + (Math.random() - 0.5) * span * 0.04;
    next = Math.max(c.range[0], Math.min(c.range[1], next));
    if (c.integer) next = Math.round(last);
    c.live = c.live.slice(1).concat([next]);
    draw(c, c.live, false);
    if (c.dot) { c.dot.classList.remove('is-new'); void c.dot.offsetWidth; c.dot.classList.add('is-new'); }
    if (c.fresh) {
      c.fresh.textContent = '+ datapoint ' + stamp();
      c.fresh.classList.add('is-on');
      setTimeout(function () { c.fresh.classList.remove('is-on'); }, 1800);
    }
  });
})();
