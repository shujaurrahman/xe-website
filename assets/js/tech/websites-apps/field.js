/* Websites & Apps · field — both series draw as the chart scrolls through the viewport and each event pin drops
   when its line reaches that day. The day scrubber (native range input) moves the cursor and reads both values with
   their rating; the legend buttons show or hide a series. Reduced motion: fully drawn, controls still work. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.twa-fd'); if (!root) return;
  var D; try { D = JSON.parse(root.getAttribute('data-fd')); } catch (e) { return; }

  var X0 = 56, XW = 640, Y0 = 272, YH = 248;
  var svg = root.querySelector('.twa-fd__svg');
  var lines = BDH.$$('.twa-fd__ln', root);
  var pins = BDH.$$('.twa-fd__pin, .twa-fd__ok', root);
  var evs = BDH.$$('.twa-fd__ev', root);
  var cur = root.querySelector('.twa-fd__cur');
  var dot = { u: root.querySelector('.twa-fd__cu'), b: root.querySelector('.twa-fd__cb') };
  var range = root.querySelector('#field-day'), out = root.querySelector('#field-day-o');
  var val = { u: root.querySelector('[data-fd-v="u"]'), b: root.querySelector('[data-fd-v="b"]') };
  var rat = { u: root.querySelector('[data-fd-r="u"]'), b: root.querySelector('[data-fd-r="b"]') };
  var live = root.querySelector('[data-fd-live]');
  var keys = BDH.$$('.twa-fd__key', root);
  var user = false, liveT = 0;

  function x(d) { return X0 + d / 90 * XW; }
  function y(v) { return Y0 - v / 6 * YH; }
  function rate(v) { return v <= 2.5 ? ['good', 'Good'] : v <= 4 ? ['ni', 'Needs improvement'] : ['poor', 'Poor']; }

  function read(d) {
    cur.setAttribute('transform', 'translate(' + x(d).toFixed(1) + ' 0)');
    var at = -1;
    D.ev.forEach(function (e, i) { if (e[0] <= d) at = i; });
    ['u', 'b'].forEach(function (s) {
      var v = D[s][d], r = rate(v);
      dot[s].setAttribute('cy', y(v).toFixed(1));
      val[s].textContent = v.toFixed(1) + ' s';
      rat[s].className = 'twa-rt twa-rt--' + r[0];
      rat[s].textContent = r[1];
    });
    evs.forEach(function (li, i) { li.classList.toggle('is-at', i === at); });
    BDH.$$('.twa-fd__pin', root).forEach(function (p) { p.classList.toggle('is-at', D.ev[at] && +p.getAttribute('data-day') === D.ev[at][0]); });
    out.textContent = d === 0 ? 'Launch' : 'Day ' + d;
    range.setAttribute('aria-valuetext', out.textContent);
    clearTimeout(liveT);
    liveT = setTimeout(function () {
      live.textContent = out.textContent + ': unmanaged ' + D.u[d].toFixed(1) + ' seconds, ' + rate(D.u[d])[1] + '; budgeted ' + D.b[d].toFixed(1) + ' seconds, ' + rate(D.b[d])[1] + '.' + (at > -1 ? ' Latest event: ' + D.ev[at][1] + '.' : '');
    }, 400);
  }

  function draw(k) {
    lines.forEach(function (l) { l.style.strokeDashoffset = String(1 - k); });
    pins.forEach(function (p) { p.classList.toggle('is-on', k * 90 >= +p.getAttribute('data-day') + 1); });
    root.classList.toggle('is-drawn', k >= 1);
  }

  keys.forEach(function (b) {
    b.addEventListener('click', function () {
      var on = b.getAttribute('aria-pressed') !== 'true';
      b.setAttribute('aria-pressed', String(on));
      root.classList.toggle('is-hide-' + b.getAttribute('data-series'), !on);
    });
  });
  range.addEventListener('input', function () {
    if (!user) { user = true; draw(1); }
    read(parseInt(range.value, 10) || 0);
  });

  read(90);
  root.classList.add('is-drawn');
  if (BDH.reduced) return;

  draw(0);
  BDH.progress(svg, function (p) {
    if (user) return;
    draw(Math.max(0, Math.min(1, (p - 0.16) / 0.36)));
  });
})();
