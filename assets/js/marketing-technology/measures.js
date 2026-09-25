/* Hub · measures — the period switch. All three series for every card are already in the markup as data,
   so switching period swaps a path and a delta line; nothing is fetched and the default period is the
   printed state. The end dot moves with the line. BDH.count animates each headline figure up to the value
   the HTML already contains, once, on entry (it is a no-op under reduced motion). */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.mth-mea');
  if (!root) return;

  var seg = BDH.$('.mth-mea__seg', root);
  var cards = BDH.$$('.mth-mea__card', root);
  if (!seg || !cards.length) return;

  var data = cards.map(function (c) {
    try { return JSON.parse(c.getAttribute('data-paths') || '{}'); } catch (err) { return {}; }
  });

  /* the y of the last point of a path, so the end dot lands on the line */
  function lastY(d) {
    var m = String(d).trim().split(/[ML]/).filter(Boolean);
    if (!m.length) return null;
    var pair = m[m.length - 1].trim().split(/\s+/);
    return pair.length > 1 ? parseFloat(pair[1]) : null;
  }

  function show(period) {
    root.setAttribute('data-period', period);
    cards.forEach(function (card, i) {
      var p = data[i] && data[i][period];
      if (!p) return;
      var line = card.querySelector('[data-line]');
      var dot = card.querySelector('[data-dot]');
      var delta = card.querySelector('[data-delta]');
      if (line) line.setAttribute('d', p.d);
      if (dot) {
        var y = lastY(p.d);
        if (y !== null) dot.setAttribute('cy', String(y));
      }
      if (delta) delta.textContent = p.dl;
    });
  }

  BDH.tabs(seg, {
    tabs: '[role="tab"]',
    panes: [],
    orientation: 'horizontal',
    onChange: function (i) {
      var btn = BDH.$$('[role="tab"]', seg)[i];
      if (btn) show(btn.getAttribute('data-period'));
    }
  });
})();
