/* Integration & Support · hero — event dots travel the transit lines while the hero is on screen;
   stations pulse as a dot arrives; the uptime bars fill once; the event counter ticks.
   Reduced motion: no dots, no ticking; the markup already shows the complete state. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tis-hero'); if (!root) return;
  var card = root.querySelector('.tis-status');
  BDH.enter(card);
  if (BDH.reduced) return;

  var svg = root.querySelector('.tis-map');
  var layer = root.querySelector('.tis-map__dots');
  var NS = 'http://www.w3.org/2000/svg';
  BDH.live(root, 0.05);

  /* dots per line: [line key, dot class, count, speed (units per second), direction] */
  var PLAN = { orders: ['is-ink', 3, 96, 1], customer: ['is-blue', 2, 80, -1], data: ['is-grey', 2, 64, 1] };
  var stations = BDH.$$('.tis-map__stn', root).map(function (g) {
    return { el: g, x: parseFloat(g.getAttribute('data-x')), y: parseFloat(g.getAttribute('data-y')) };
  });

  var runs = [];
  BDH.$$('.tis-map__ln', root).forEach(function (p) {
    var plan = PLAN[p.getAttribute('data-line')]; if (!plan || !p.getTotalLength) return;
    var len = p.getTotalLength();
    /* where each station sits along this line */
    var stops = [];
    stations.forEach(function (s) {
      var best = Infinity, at = 0;
      for (var l = 0; l <= len; l += 4) {
        var pt = p.getPointAtLength(l), d = Math.abs(pt.x - s.x) + Math.abs(pt.y - s.y);
        if (d < best) { best = d; at = l; }
      }
      if (best < 6) stops.push({ at: at, el: s.el });
    });
    for (var n = 0; n < plan[1]; n++) {
      var c = document.createElementNS(NS, 'circle');
      c.setAttribute('r', '6'); c.setAttribute('class', plan[0]);
      layer.appendChild(c);
      runs.push({ path: p, len: len, el: c, s: (len / plan[1]) * n, v: plan[2] * plan[3], stops: stops });
    }
  });

  function hit(el) {
    el.classList.remove('is-hit');
    void el.getBoundingClientRect();
    el.classList.add('is-hit');
  }

  var on = false, last = 0;
  function tick(ts) {
    if (!on) return;
    var dt = last ? Math.min(0.05, (ts - last) / 1000) : 0; last = ts;
    runs.forEach(function (r) {
      var prev = r.s;
      r.s += r.v * dt;
      if (r.s > r.len) r.s -= r.len;
      if (r.s < 0) r.s += r.len;
      r.stops.forEach(function (st) {
        var crossed = r.v > 0 ? (prev < st.at && r.s >= st.at) : (prev > st.at && r.s <= st.at);
        if (crossed) hit(st.el);
      });
      var pt = r.path.getPointAtLength(r.s);
      r.el.setAttribute('transform', 'translate(' + pt.x.toFixed(1) + ' ' + pt.y.toFixed(1) + ')');
    });
    requestAnimationFrame(tick);
  }
  BDH.watch(svg, function (v) { on = v; last = 0; if (v) requestAnimationFrame(tick); }, { threshold: 0.02 });

  /* status card: events counter and "checked N s ago" */
  var ev = root.querySelector('[data-hero-events]'), ago = root.querySelector('[data-hero-ago]');
  var total = ev ? parseInt(ev.textContent.replace(/,/g, ''), 10) : 0, secs = 12;
  BDH.loop(card, 1000, function () {
    total += 9 + Math.floor(Math.random() * 28);
    if (ev) ev.textContent = total.toLocaleString('en-GB');
    secs = secs >= 29 ? 1 : secs + 1;
    if (ago) ago.textContent = 'Checked ' + secs + ' s ago';
  });
})();
