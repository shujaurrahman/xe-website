/* Integration & Support · sprawl — toggles the board between "today" (copy hand-offs) and "connected"
   (one line, spreadsheets retired). With motion allowed it starts in "today" and switches once the
   board passes the middle of the viewport; any press on the toggle hands control to the visitor.
   Figures roll between the two values. Reduced motion: markup state (connected), toggle still works. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var sec = document.querySelector('.tis-sprawl'); if (!sec) return;
  var grid = sec.querySelector('.tis-sprawl__grid');
  var btns = BDH.$$('[data-sp-state]', sec);
  var mode = sec.querySelector('[data-sp-mode]'), count = sec.querySelector('[data-sp-count]');
  var figs = BDH.$$('.tis-sprawl__fig b', sec);
  var retired = BDH.$$('.tis-sprawl__tile.is-ret', sec).length;
  var copies = BDH.$$('.tis-sprawl__copies path', sec).length;
  var state = 'connected', user = false;

  function parse(s) { var m = String(s).match(/-?\d+(\.\d+)?/); return m ? { n: parseFloat(m[0]), d: m[1] ? m[1].length - 1 : 0, pre: s.slice(0, m.index), post: s.slice(m.index + m[0].length) } : null; }
  function roll(el, to) {
    var a = parse(el.textContent), b = parse(to);
    if (BDH.reduced || !a || !b) { el.textContent = to; return; }
    var t0 = null, dur = 700;
    requestAnimationFrame(function step(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / dur), k = 1 - Math.pow(1 - p, 3);
      el.textContent = p < 1 ? b.pre + (a.n + (b.n - a.n) * k).toFixed(b.d) + b.post : to;
      if (p < 1) requestAnimationFrame(step);
    });
  }

  function set(s) {
    if (s === state) return;
    state = s;
    grid.setAttribute('data-sp', s);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', String(b.getAttribute('data-sp-state') === s)); });
    var on = s === 'connected';
    if (mode) mode.textContent = on ? 'One integration layer' : 'Copy and paste';
    if (count) count.textContent = on ? (30 - retired) + ' systems on one line · ' + retired + ' retired' : '30 tools · ' + copies + ' manual hand-offs';
    figs.forEach(function (f) { roll(f, f.getAttribute(on ? 'data-b' : 'data-a')); });
  }

  btns.forEach(function (b) {
    b.addEventListener('click', function () { user = true; set(b.getAttribute('data-sp-state')); });
  });

  if (BDH.reduced) return;
  BDH.live(grid, 0.1);
  set('today');
  BDH.progress(sec.querySelector('.tis-sprawl__board'), function (p) {
    if (user) return;
    set(p > 0.52 ? 'connected' : 'today');
  });
})();
