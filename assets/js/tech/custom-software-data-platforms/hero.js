/* Custom Software & Data Platforms · hero — routes the ERD relations (orthogonal, rounded corners) from the
   layout, draws them in dependency order, types the record form, then runs an order through the model
   (Contact → Account → Order → order_lines → Product) while the canvas is on screen. The Pause button stops the run.
   Positions come from offsetLeft/offsetTop, which ignore the cards' reveal transform, so the crow's feet sit on
   the card edges even while the cards are still settling; the order_lines junction chip is placed under Order
   and Product before the routes are drawn. Reduced motion: relations routed and shown at once; no travelling
   record; the HTML values stay. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tcs-hero'); if (!root) return;
  var erd = root.querySelector('.tcs-erd');
  var cv = root.querySelector('.tcs-erd__canvas');
  var svg = root.querySelector('.tcs-erd__svg');
  if (!erd || !cv || !svg) return;

  var rels = BDH.$$('.tcs-erd__rel', svg);
  var lead = svg.querySelector('.tcs-erd__lead');
  var dot = root.querySelector('.tcs-erd__dot');
  var status = root.querySelector('[data-erd-status]');
  var pauseBtn = root.querySelector('[data-erd-pause]');
  var ordersEl = root.querySelector('[data-rec-orders]');
  var lastEl = root.querySelector('[data-rec-last]');
  var stateEl = root.querySelector('[data-rec-state]');
  var R = BDH.reduced;

  var jn = root.querySelector('[data-jn="lines"]');
  function ent(k) {
    if (k === 'rec') return root.querySelector('.tcs-rec');
    if (k === 'lines') return jn;
    return root.querySelector('.tcs-ent[data-ent="' + k + '"]');
  }
  /* layout box relative to the canvas, without transforms (walks the offsetParent chain up to the canvas) */
  function box(el) {
    var l = 0, t = 0, n = el;
    while (n && n !== cv) {
      l += n.offsetLeft; t += n.offsetTop;
      n = n.offsetParent;
      if (n && n !== cv) { l += n.clientLeft; t += n.clientTop; }
    }
    if (n !== cv) {   // not inside the canvas's positioning chain: fall back to the rendered box
      var r = el.getBoundingClientRect(), c = cv.getBoundingClientRect();
      return { l: r.left - c.left, t: r.top - c.top, r: r.right - c.left, b: r.bottom - c.top, w: r.width, h: r.height };
    }
    var w = el.offsetWidth, h = el.offsetHeight;
    return { l: l, t: t, r: l + w, b: t + h, w: w, h: h };
  }
  /* the join table sits centred between Order and Product, just below the lower of the two */
  function placeJunction() {
    var O = ent('order'), P = ent('product');
    if (!jn || !O || !P) return;
    var o = box(O), p = box(P);
    var x = ((o.l + o.w / 2) + (p.l + p.w / 2)) / 2 - jn.offsetWidth / 2;
    var y = Math.max(o.b, p.b) + 30 - jn.offsetHeight / 2;
    jn.style.left = Math.round(x) + 'px';
    jn.style.top = Math.round(y) + 'px';
  }
  function pt(b, side, a, hy) {
    hy = Math.min(hy, b.h / 2);   // side attachments sit on the header line, or mid-height on a short chip
    if (side === 'l') return [b.l, b.t + hy];
    if (side === 'r') return [b.r, b.t + hy];
    if (side === 't') return [b.l + b.w * a, b.t];
    return [b.l + b.w * a, b.b];
  }
  function r1(v) { return Math.round(v * 10) / 10; }
  function rounded(pts, rad) {
    var out = [pts[0]];
    for (var i = 1; i < pts.length; i++) {
      var p = pts[i], q = out[out.length - 1];
      if (Math.abs(p[0] - q[0]) > 0.5 || Math.abs(p[1] - q[1]) > 0.5) out.push(p);
    }
    pts = out;
    var d = 'M' + r1(pts[0][0]) + ' ' + r1(pts[0][1]);
    for (var j = 1; j < pts.length - 1; j++) {
      var a = pts[j - 1], b = pts[j], c = pts[j + 1];
      var d1 = Math.hypot(b[0] - a[0], b[1] - a[1]), d2 = Math.hypot(c[0] - b[0], c[1] - b[1]);
      var rr = Math.min(rad, d1 / 2, d2 / 2);
      var p1 = [b[0] + (a[0] - b[0]) / d1 * rr, b[1] + (a[1] - b[1]) / d1 * rr];
      var p2 = [b[0] + (c[0] - b[0]) / d2 * rr, b[1] + (c[1] - b[1]) / d2 * rr];
      d += ' L' + r1(p1[0]) + ' ' + r1(p1[1]) + ' Q' + r1(b[0]) + ' ' + r1(b[1]) + ' ' + r1(p2[0]) + ' ' + r1(p2[1]);
    }
    var z = pts[pts.length - 1];
    return d + ' L' + r1(z[0]) + ' ' + r1(z[1]);
  }
  function route(p, s1, q, s2, gap) {
    var H1 = s1 === 'l' || s1 === 'r', H2 = s2 === 'l' || s2 === 'r', pts;
    if (H1 && H2) {
      if (Math.abs(p[1] - q[1]) < 1.5) pts = [p, [q[0], p[1]]];
      else { var mx = (p[0] + q[0]) / 2; pts = [p, [mx, p[1]], [mx, q[1]], q]; }
    } else if (!H1 && !H2) {
      if (Math.abs(p[0] - q[0]) < 1.5) pts = [p, [p[0], q[1]]];
      else {
        var my = s2 === 't' ? q[1] - gap / 2 : q[1] + gap / 2;
        if (s1 === 'b' && s2 === 'b') my = Math.max(p[1], q[1]) + gap / 2;       // bottom to bottom: run under both
        else if (s1 === 't' && s2 === 't') my = Math.min(p[1], q[1]) - gap / 2;
        pts = [p, [p[0], my], [q[0], my], q];
      }
    } else if (H1) pts = [p, [q[0], p[1]], q];
    else pts = [p, [p[0], q[1]], q];
    return rounded(pts, 10);
  }

  function layout() {
    if (getComputedStyle(svg).display === 'none') { erd.classList.remove('is-routed'); return false; }
    svg.setAttribute('viewBox', '0 0 ' + cv.clientWidth + ' ' + cv.clientHeight);
    var ents = root.querySelector('.tcs-erd__ents');
    placeJunction();
    var gap = parseFloat(getComputedStyle(ents).rowGap) || 46;
    rels.forEach(function (p) {
      var A = ent(p.getAttribute('data-from')), B = ent(p.getAttribute('data-to'));
      if (!A || !B) return;
      var a = box(A), b = box(B);
      var s1 = p.getAttribute('data-fs'), s2 = p.getAttribute('data-ts');
      p.setAttribute('d', route(pt(a, s1, +p.getAttribute('data-fa'), 20), s1, pt(b, s2, +p.getAttribute('data-ta'), 20), s2, gap));
      var lbl = svg.querySelector('[data-label-for="' + p.getAttribute('data-from') + '-' + p.getAttribute('data-to') + '"]');
      if (lbl) {
        var L = p.getTotalLength(), m = p.getPointAtLength(L / 2);
        lbl.setAttribute('x', r1(m.x)); lbl.setAttribute('y', r1(m.y - 8));
      }
    });
    if (lead) {
      var A2 = ent('account'), B2 = ent('rec');
      if (A2 && B2) {
        var a2 = box(A2), b2 = box(B2);
        if (getComputedStyle(lead).display !== 'none' && b2.l > a2.r + 8) lead.setAttribute('d', route([a2.r, a2.t + 20], 'r', [b2.l, b2.t + 23], 'l', 0));
        else lead.setAttribute('d', '');
      }
    }
    erd.classList.add('is-routed');
    return true;
  }

  function relFor(a, b) {
    for (var i = 0; i < rels.length; i++) if (rels[i].getAttribute('data-from') === a && rels[i].getAttribute('data-to') === b) return rels[i];
    return null;
  }

  function boot() {
    layout();
    requestAnimationFrame(function () { erd.classList.add('is-drawn'); });
    if ('ResizeObserver' in window) {
      var q = false, ro = new ResizeObserver(function () { if (q) return; q = true; requestAnimationFrame(function () { q = false; layout(); }); });
      ro.observe(cv);
      var ents = root.querySelector('.tcs-erd__ents'); if (ents) ro.observe(ents);
      var rec = ent('rec'); if (rec) ro.observe(rec);
    } else window.addEventListener('resize', layout);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(layout);
    /* belt and braces: route once more after the last card has settled (reveal: 9 × 110 ms + 150 ms + 600 ms) */
    if (!R) setTimeout(layout, 9 * 110 + 150 + 700);
  }

  if (R) { erd.classList.add('is-in'); boot(); return; }

  /* start routing as soon as the reveal is under way */
  BDH.inView(erd, function () { boot(); typeRecord(); }, { threshold: 0.05 });

  function typeRecord() {
    var fields = BDH.$$('[data-rec-type]', root), t = 2350;
    fields.forEach(function (f) {
      var text = f.textContent;
      f.textContent = '';
      BDH.type(f, text, { delay: t, speed: 26 });
      t += text.length * 26 + 140;
    });
  }

  /* ---- the travelling order ------------------------------------------------ */
  var tween = null;
  function flow(path, ms, done) {
    if (!path || !dot || !path.getAttribute('d')) { if (done) done(); return; }
    var L = path.getTotalLength(), t0 = null;
    path.classList.add('is-hot');
    dot.classList.add('is-on');
    if (tween) cancelAnimationFrame(tween);
    function step(ts) {
      if (t0 === null) t0 = ts;
      var k = Math.min(1, (ts - t0) / ms), e = k < .5 ? 2 * k * k : 1 - Math.pow(-2 * k + 2, 2) / 2;
      var p = path.getPointAtLength(L * e);
      dot.style.transform = 'translate(' + p.x.toFixed(1) + 'px,' + p.y.toFixed(1) + 'px)';
      if (k < 1) tween = requestAnimationFrame(step);
      else { tween = null; if (done) done(); }
    }
    tween = requestAnimationFrame(step);
  }
  function hot(k, field, on) {
    var row = root.querySelector('.tcs-ent[data-ent="' + k + '"] [data-field="' + field + '"]');
    if (row) row.classList.toggle('is-hot', on);
  }
  function say(t) { if (status) status.textContent = t; }
  function clearHot() {
    BDH.$$('.is-hot', root).forEach(function (el) { el.classList.remove('is-hot'); });
    if (dot) dot.classList.remove('is-on');
  }

  var orders = parseInt(ordersEl ? ordersEl.textContent : '12', 10) || 12, ord = 48213;
  /* on narrow screens the relations are hidden (and the Pause button with them), so the order run stays still */
  function routed(fn) { return function () { if (erd.classList.contains('is-routed')) fn(); }; }
  var steps = [
    [3600, function () { say('Contact places an order'); hot('contact', 'account_id', true); flow(relFor('contact', 'account'), 900); }],
    [1150, function () { say('Order written against the account'); hot('account', 'id', true); flow(relFor('account', 'order'), 1000); }],
    [1200, function () {
      say('Order lines resolve products'); hot('order', 'total', true);
      flow(relFor('order', 'lines'), 520, function () { if (jn) jn.classList.add('is-hot'); flow(relFor('lines', 'product'), 620); });
      if (stateEl) { stateEl.textContent = 'Saving'; stateEl.className = 'tcs-st tcs-st--wait'; }
    }],
    [1000, function () {
      hot('product', 'price', true);
      orders = orders >= 15 ? 13 : orders + 1; ord++;
      if (ordersEl) ordersEl.textContent = String(orders);
      if (lastEl) { lastEl.textContent = 'ORD-' + ord + ' · just now'; lastEl.classList.add('is-new'); }
      if (stateEl) { stateEl.textContent = 'Synced'; stateEl.className = 'tcs-st tcs-st--ok'; }
      say('Record updated in 180 ms');
    }],
    [2600, function () { clearHot(); if (lastEl) lastEl.classList.remove('is-new'); say('Order flowing through the model'); }]
  ].map(function (s) { return [s[0], routed(s[1])]; });
  var run = BDH.seq(erd, steps, { loop: true, stopOnInteract: false });

  if (pauseBtn) {
    pauseBtn.hidden = false;
    pauseBtn.addEventListener('click', function () {
      var paused = pauseBtn.getAttribute('aria-pressed') === 'true';
      if (paused) { run = BDH.seq(erd, steps, { loop: true, stopOnInteract: false }); pauseBtn.setAttribute('aria-pressed', 'false'); pauseBtn.textContent = 'Pause motion'; say('Order flowing through the model'); }
      else { run.stop(); if (tween) cancelAnimationFrame(tween); clearHot(); pauseBtn.setAttribute('aria-pressed', 'true'); pauseBtn.textContent = 'Play motion'; say('Paused'); }
    });
  }
})();
