/* Hub · run — the run inspector.
 *
 *   • an ARIA tablist of briefs (BDH.tabs: click, arrow keys, Home / End), panes stacked in one grid cell
 *   • a step-through over the selected run's gate chain: previous, next, replay, with a polite status
 *
 * The shipped HTML is the finished state: every gate already carries its verdict. This script adds
 * .is-run to the component, which is the only thing that lets a gate be dimmed as "queued", so with
 * JavaScript off nothing is hidden. Under reduced motion the pointer starts at the last gate (the
 * finished state) and nothing advances on its own; the buttons still work for manual inspection.
 */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.aih-run');
  if (!root) return;

  var ui = BDH.$('.aih-run__ui', root);
  var tablist = BDH.$('.aih-run__briefs', root);
  var panes = BDH.$$('.aih-run__pane', root);
  var step = BDH.$('.aih-run__step', root);
  var status = BDH.$('[data-run-status]', root);
  if (!ui || !tablist || !panes.length) return;

  var cur = 0, at = 0, ticker = null, manual = false;

  function gates(i) { return BDH.$$('.aih-gate', panes[i]); }

  function verdict(el) {
    var s = el.getAttribute('data-state');
    if (s === 'pass') return 'passed';
    if (s === 'fail') return 'failed and stopped the run';
    if (s === 'human') return 'waiting for a named person';
    return 'not reached';
  }

  function paint() {
    var gs = gates(cur);
    gs.forEach(function (g, n) {
      g.classList.toggle('is-wait', n > at);
      g.classList.toggle('is-at', n === at);
    });
    if (!status) return;
    var g = gs[at];
    if (!g) { status.textContent = ''; return; }
    var name = BDH.$('.aih-gate__t', g);
    status.textContent = 'Gate ' + (at + 1) + ' of ' + gs.length + ' · ' +
      (name ? name.textContent : '') + ' · ' + verdict(g);
  }

  function go(n, byUser) {
    var gs = gates(cur);
    if (!gs.length) return;
    at = Math.max(0, Math.min(gs.length - 1, n));
    if (byUser) { manual = true; if (ticker) { ticker.stop(); ticker = null; } }
    paint();
  }

  function autoplay() {
    if (BDH.reduced || manual) return;
    if (ticker) ticker.stop();
    ticker = BDH.loop(ui, 1400, function () {
      var gs = gates(cur);
      if (at >= gs.length - 1) { ticker.pause(); return; }
      at++;
      paint();
    });
  }

  /* ---- the brief tablist ---- */
  BDH.tabs(root, {
    tabs: '.aih-run__b',
    panes: '.aih-run__pane',
    onChange: function (i) {
      /* clear the previous pane so a hidden run never keeps a dimmed gate */
      gates(cur).forEach(function (g) { g.classList.remove('is-wait', 'is-at'); });
      cur = i;
      at = BDH.reduced || manual ? gates(cur).length - 1 : 0;
      paint();
      if (!manual) autoplay();
    }
  });

  /* ---- the step-through ---- */
  root.classList.add('is-run');
  if (step) step.hidden = false;
  var prev = BDH.$('[data-run-prev]', root);
  var next = BDH.$('[data-run-next]', root);
  var again = BDH.$('[data-run-replay]', root);
  if (prev) prev.addEventListener('click', function () { go(at - 1, true); });
  if (next) next.addEventListener('click', function () { go(at + 1, true); });
  if (again) again.addEventListener('click', function () {
    manual = false;
    at = 0;
    paint();
    if (BDH.reduced) { go(gates(cur).length - 1, true); manual = false; return; }
    autoplay();
    if (ticker) ticker.resume();
  });

  at = BDH.reduced ? gates(0).length - 1 : 0;
  paint();
  autoplay();
})();
