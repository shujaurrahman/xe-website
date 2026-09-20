/* Websites & Apps · gates — the merge queue is reader-driven, not a replay. The three pull requests are an ARIA
   tablist (BDH.tabs) over their budget ledgers. On the held change, one labelled button commits the agent's fix:
   the over-budget gate drops to the value PHP put in data-fix-*, its meter falls back inside the ceiling, and the
   queue releases. Pressing again puts the queue back, so the reader can drive it both ways.
   Every number the panel can show is authored in gates.php and read off the markup here, so the shipped HTML and
   the script can never disagree. Reduced motion: the swap still works, without the transitions. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.twa-gq'); if (!root) return;

  var list = root.querySelector('.twa-gq__list');
  if (!list) return;
  BDH.tabs(root, { tabs: '[data-gq-pr]', panes: '.twa-gq__pane' });

  var apply = root.querySelector('[data-gq-apply]');
  var pane  = apply && apply.closest('.twa-gq__pane');
  var pr    = list.querySelector('.twa-gq__pr[data-st="held"]');
  if (!apply || !pane || !pr) return;

  var lane = root.querySelector('[data-gq-lane]');
  var why  = pane.querySelector('[data-fix-why]');
  var ps   = pr.querySelector('.twa-gq__ps');

  var gates = BDH.$$('.twa-gq__g[data-fix-val]', pane).map(function (g) {
    var val = g.querySelector('[data-gq-val]');
    var res = g.querySelector('[data-gq-res]');
    var mtr = g.querySelector('[data-gq-meter]');
    return {
      el: g, val: val, res: res, mtr: mtr,
      off: { ok: g.getAttribute('data-ok'), val: val ? val.textContent : '', res: res ? res.textContent : '',
             pct: mtr ? mtr.style.getPropertyValue('--p') : '' },
      on:  { ok: g.getAttribute('data-fix-ok'), val: g.getAttribute('data-fix-val'), res: g.getAttribute('data-fix-res'),
             pct: g.getAttribute('data-fix-pct') + '%' }
    };
  });

  var text = {
    why:   [why ? why.textContent : '', why ? why.getAttribute('data-fix-why') : ''],
    ps:    [ps ? ps.textContent : '', pr.getAttribute('data-fix-state') || (ps ? ps.textContent : '')],
    lane:  [lane ? lane.textContent : '', 'running · nothing held'],
    label: [apply.textContent, 'Undo the fix and hold the queue']
  };
  if (lane) lane.setAttribute('aria-live', 'polite');

  var on = false;
  function paint() {
    var k = on ? 'on' : 'off', n = on ? 1 : 0;
    gates.forEach(function (g) {
      var s = g[k];
      g.el.setAttribute('data-ok', s.ok);
      if (g.val) g.val.textContent = s.val;
      if (g.res) g.res.textContent = s.res;
      if (g.mtr && s.pct) g.mtr.style.setProperty('--p', s.pct);
    });
    if (why) why.textContent = text.why[n];
    if (ps) ps.textContent = text.ps[n];
    if (lane) lane.textContent = text.lane[n];
    list.classList.toggle('is-released', on);
    apply.textContent = text.label[n];
  }

  apply.addEventListener('click', function () { on = !on; paint(); });
})();
