/* AI Product & Automation · outcomes — the outcome tabs switch the trend chart and redraw its line (dash
   offset), area and points each time. While on screen and untouched the tabs step on their own every 10 s,
   pausing while the pointer is over the dashboard; the first interaction inside it stops that. KPI tiles
   count from their week-1 baseline ([data-oc-from]) to the value in the HTML, and each delta badge is
   derived from the current count, so no mid-count frame contradicts itself; sparklines draw via .bdh-draw (hub.js). Reduced motion: no counting,
   no redraw, no autoplay; the tabs still work. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tap-oc'); if (!root) return;
  var R = BDH.reduced;
  var panes = BDH.$$('.tap-oc__pane', root);

  function draw(i) {
    var p = panes[i];
    if (R || !p) return;
    p.classList.remove('is-drawn');
    p.classList.add('is-draw');
    void p.offsetWidth;
    requestAnimationFrame(function () {
      p.classList.add('is-drawn');
      p.classList.remove('is-draw');
    });
  }

  var tabs = BDH.tabs(root.querySelector('.tap-oc__trend'), {
    tabs: '.tap-oc__seg [role="tab"]',
    onChange: function (i) { draw(i); }
  });

  if (R) return;

  /* KPI tiles: baseline → current value, keeping prefix, suffix and decimals */
  function deltaText(kind, v, from) {
    var d = v - from, sign = d < 0 ? '\u2212' : '+';
    if (kind === 'pct') return sign + Math.round(Math.abs(d / from) * 100) + '%';
    if (kind === 'abs') return sign + Math.abs(d).toFixed(2);
    return sign + Math.round(Math.abs(d)) + ' pts';
  }
  BDH.$$('[data-oc-from]', root).forEach(function (el) {
    var badge = el.parentNode.querySelector('[data-oc-dt]'), kind = badge ? badge.getAttribute('data-oc-dt') : '', braw = badge ? badge.textContent : '';
    var raw = el.textContent, m = raw.match(/-?\d[\d,]*(\.\d+)?/);
    if (!m) return;
    var pre = raw.slice(0, m.index), post = raw.slice(m.index + m[0].length);
    var to = parseFloat(m[0].replace(/,/g, '')), from = parseFloat(el.getAttribute('data-oc-from'));
    var dec = m[1] ? m[1].length - 1 : 0;
    if (isNaN(from)) return;
    BDH.inView(el, function () {
      var t0 = null, dur = 1100;
      el.textContent = pre + from.toFixed(dec) + post;
      if (badge) badge.textContent = deltaText(kind, from, from);
      requestAnimationFrame(function tick(ts) {
        if (t0 === null) t0 = ts;
        var p = Math.min(1, (ts - t0) / dur), k = 1 - Math.pow(1 - p, 3);
        var v = from + (to - from) * k;
        el.textContent = p < 1 ? pre + v.toFixed(dec) + post : raw;
        if (badge) badge.textContent = p < 1 ? deltaText(kind, parseFloat(v.toFixed(dec)), from) : braw;
        if (p < 1) requestAnimationFrame(tick);
      });
    }, { threshold: 0.4 });
  });

  /* chart autoplay: every 10 s while on screen, paused under the pointer, stopped by any interaction */
  var auto = BDH.loop(root, 10000, function () { tabs.show(tabs.index() + 1, false); });
  root.addEventListener('pointerenter', function () { auto.pause(); });
  root.addEventListener('pointerleave', function () { auto.resume(); });
  BDH.onInteract(root, function () { auto.stop(); });

  var guards = root.querySelector('.tap-oc__guards');
  if (guards) BDH.stagger(guards);
  /* hold the first chart undrawn until the dashboard is seen */
  if (panes[0]) panes[0].classList.add('is-draw');
  BDH.inView(root, function () { draw(Math.max(0, tabs.index())); }, { threshold: 0.3 });
})();
