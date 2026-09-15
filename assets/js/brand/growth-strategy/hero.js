/* Growth Strategy · hero — the opportunity terrain breathes and a survey cursor drifts, reading the
   index under it. Same marching-squares maths as partials/brand/growth-strategy/hero.php. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cgs-terrain]'); if (!root) return;
  if (BDH.reduced) return; // the HTML already holds the complete map

  var peaks = JSON.parse(root.getAttribute('data-peaks') || '[]');
  var levels = JSON.parse(root.getAttribute('data-levels') || '[]');
  var paths = root.querySelectorAll('.cgs-terrain__iso path');
  var peakEls = root.querySelectorAll('.cgs-peak');
  var cur = root.querySelector('.cgs-cursor');
  var rx = root.querySelector('[data-cgs-x]'), ry = root.querySelector('[data-cgs-y]'), rz = root.querySelector('[data-cgs-z]');
  var W = +root.getAttribute('data-w') || 1200, H = +root.getAttribute('data-h') || 800, ST = +root.getAttribute('data-st') || 12;
  var COLS = Math.floor(W / ST), ROWS = Math.floor(H / ST);
  var T = { 1: [[3, 2]], 2: [[2, 1]], 3: [[3, 1]], 4: [[0, 1]], 5: [[3, 0], [2, 1]], 6: [[0, 2]], 7: [[3, 0]],
    8: [[3, 0]], 9: [[0, 2]], 10: [[3, 2], [0, 1]], 11: [[0, 1]], 12: [[3, 1]], 13: [[2, 1]], 14: [[3, 2]] };

  function field(x, y, t) {
    var z = 0.05 * Math.sin(x / 53 + t * 0.4) * Math.cos(y / 41);
    for (var n = 0; n < peaks.length; n++) {
      var p = peaks[n], h = p[3] * (1 + 0.035 * Math.sin(t * 0.9 + n * 1.7));
      var dx = x - p[1], dy = y - p[2];
      z += h * Math.exp(-(dx * dx + dy * dy) / (2 * p[4] * p[4]));
    }
    return z;
  }
  function r1(v) { return Math.round(v * 10) / 10; }

  function draw(t) {
    var v = [], i, j;
    for (j = 0; j <= ROWS; j++) { v[j] = []; for (i = 0; i <= COLS; i++) v[j][i] = field(i * ST, j * ST, t); }
    for (var L = 0; L < levels.length && L < paths.length; L++) {
      var lv = levels[L], d = [];
      for (j = 0; j < ROWS; j++) for (i = 0; i < COLS; i++) {
        var a = v[j][i], b = v[j][i + 1], c = v[j + 1][i + 1], e = v[j + 1][i];
        var k = (a > lv ? 8 : 0) | (b > lv ? 4 : 0) | (c > lv ? 2 : 0) | (e > lv ? 1 : 0);
        var segs = T[k]; if (!segs) continue;
        var x0 = i * ST, y0 = j * ST;
        for (var s = 0; s < segs.length; s++) {
          var P = pt(segs[s][0]), Q = pt(segs[s][1]);
          d.push('M' + r1(P[0]) + ' ' + r1(P[1]) + 'L' + r1(Q[0]) + ' ' + r1(Q[1]));
        }
      }
      paths[L].setAttribute('d', d.join(''));
    }
    function pt(ed) {
      if (ed === 0) return [x0 + ST * (lv - a) / (b - a), y0];
      if (ed === 1) return [x0 + ST, y0 + ST * (lv - b) / (c - b)];
      if (ed === 2) return [x0 + ST * (lv - e) / (c - e), y0 + ST];
      return [x0, y0 + ST * (lv - a) / (e - a)];
    }
  }

  var t = 0, tick = 0;
  BDH.loop(root, 60, function () {
    t += 0.06; tick++;
    if (tick % 3 === 0) draw(t);
    // survey cursor: a slow Lissajous walk across the sheet
    var x = 880 + 260 * Math.sin(t * 0.23), y = 420 + 280 * Math.sin(t * 0.37 + 1.1);
    cur.setAttribute('transform', 'translate(' + r1(x) + ' ' + r1(y) + ')');
    rx.textContent = String(Math.round(x)).padStart(3, '0');
    ry.textContent = String(Math.round(y)).padStart(3, '0');
    rz.textContent = field(x, y, t).toFixed(2);
    for (var n = 0; n < peakEls.length; n++) {
      var p = peaks[n], near = Math.abs(x - p[1]) < 90 && Math.abs(y - p[2]) < 90;
      peakEls[n].classList.toggle('is-near', near);
    }
  });
})();
