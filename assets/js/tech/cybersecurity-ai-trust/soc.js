/* Cybersecurity & AI Trust · soc — the six incident stages are tabs (BDH.tabs). Selecting one moves the track,
   marks earlier stages done, sets the CERT-In clock (elapsed of the six-hour window) and, on Triage, types the
   assistant's summary. The console steps through the incident on its own while on screen until touched.
   HTML = the finished incident; reduced motion keeps it there. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tsc-soc__console'); if (!root) return;
  var stages = BDH.$$('.tsc-soc__stage', root), line = root.querySelector('[data-soc-line]');
  var ring = root.querySelector('[data-soc-ring]'), ringBox = root.querySelector('.tsc-soc__ring');
  var elapsed = root.querySelector('[data-soc-elapsed]'), left = root.querySelector('[data-soc-left]');
  var filed = root.querySelector('.tsc-soc__cf'), state = root.querySelector('[data-soc-state]');
  var typeEl = root.querySelector('[data-soc-type]'), ai = root.querySelector('.tsc-soc__ai');
  var summary = typeEl ? typeEl.textContent : '', typer = null;
  var WINDOW = 360;

  function hm(min) { var h = Math.floor(min / 60), m = min % 60; return h + ':' + (m < 10 ? '0' : '') + m; }

  function paint(i) {
    var s = stages[i]; if (!s) return;
    var min = parseInt(s.getAttribute('data-min'), 10), pct = parseFloat(s.getAttribute('data-pct')) || 0;
    stages.forEach(function (t, k) { t.classList.toggle('is-done', k <= i); });
    if (line) line.style.setProperty('--p', String(stages.length > 1 ? i / (stages.length - 1) : 1));
    if (ring) ring.style.setProperty('--p', String(min < 0 ? 100 : Math.max(pct, min === 0 ? 0.6 : pct)));
    if (ringBox) ringBox.classList.toggle('is-closed', min < 0);
    if (elapsed) elapsed.textContent = min < 0 ? 'Filed' : hm(min) + ' h';
    if (left) left.textContent = min < 0 ? 'window closed' : hm(WINDOW - min) + ' h left';
    if (filed) filed.classList.toggle('is-on', i >= 3);
    if (state) {
      var open = i < 5;
      state.textContent = i < 2 ? 'Open' : (i < 5 ? 'Contained' : 'Closed');
      state.classList.toggle('is-open', i < 2);
      state.classList.toggle('tsc-sev--ok', !open || i >= 2);
      state.classList.toggle('tsc-sev--low', false);
    }
    if (typer) { typer.finish(); typer = null; }
    if (ai) ai.classList.remove('is-typing');
    if (i === 1 && typeEl && !BDH.reduced) {
      ai.classList.add('is-typing');
      typer = BDH.type(typeEl, summary, { speed: 9, delay: 250, done: function () { if (ai) ai.classList.remove('is-typing'); } });
    }
  }

  var tabs = BDH.tabs(root, {
    tabs: '.tsc-soc__stage',
    auto: BDH.reduced ? 0 : 3600,
    interactRoot: root,
    onChange: function (i) { paint(i); }
  });
  paint(tabs.index());

  if (!BDH.reduced) {
    /* start the replay from the alert once the console is on screen; the tab timer then steps it forward */
    var started = false;
    BDH.inView(root, function () { if (!started) { started = true; tabs.show(0, false); } }, { threshold: 0.35 });
    BDH.live(root, 0.2);
  }
})();
