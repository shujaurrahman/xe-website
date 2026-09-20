/* ==========================================================================
   Websites & Apps · 08 carbon — the page-weight ceiling is a native range
   input, so it works with a pointer, a keyboard and a screen reader without
   any help from here. Moving it re-tiles the treemap, rewrites the resource
   table, resizes the true-scale square and swaps every readout.
   Not one number is written in this file: PHP prints all six rungs into the
   ladder list and the per-resource kilobytes into the table, and this reads
   them back, so the drawn panel and the printed ladder cannot disagree. The
   treemap arithmetic mirrors $twa_cb_map in carbon.php line for line.
   With JS off the 1.00 MB rung stays fully drawn and the ladder prints the
   rest, so the section is complete either way.
   ========================================================================== */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.twa-carbon .twa-cb');
  if (!root) return;
  var range = root.querySelector('[data-cb-range]');
  var rungs = BDH.$$('[data-cb-rung]', root);
  var rows  = BDH.$$('[data-cb-res]', root);
  if (!range || !rungs.length || !rows.length) return;

  /* per-resource kilobytes and technique notes, straight off the table PHP printed */
  var res = rows.map(function (tr) {
    var notes = [];
    try { notes = JSON.parse(tr.getAttribute('data-notes') || '[]'); } catch (e) { notes = []; }
    return {
      key: tr.getAttribute('data-cb-res'),
      kb: (tr.getAttribute('data-kb') || '').split(',').map(Number),
      notes: notes,
      kbEl: tr.querySelector('[data-cb-kb]'),
      nEl: tr.querySelector('[data-cb-note]')
    };
  });

  var map   = root.querySelector('[data-cb-map]');
  var mRows = map ? BDH.$$('[data-cb-row]', map) : [];
  var cells = {};
  if (map) BDH.$$('[data-cb-cell]', map).forEach(function (c) { cells[c.getAttribute('data-cb-cell')] = c; });

  var out = {
    state:  root.querySelector('[data-cb-state]'),
    tot:    root.querySelector('[data-cb-tot]'),
    tot2:   root.querySelector('[data-cb-tot2]'),
    cut:    root.querySelector('[data-cb-cut]'),
    cut2:   root.querySelector('[data-cb-cut2]'),
    half:   root.querySelector('[data-cb-half]'),
    cost:   root.querySelector('[data-cb-cost]'),
    refuse: root.querySelector('[data-cb-refuse]'),
    col:    root.querySelector('[data-cb-col]'),
    sq:     root.querySelector('[data-cb-sq]'),
    sqt:    root.querySelector('[data-cb-sqt]'),
    read:   {}
  };
  BDH.$$('[data-cb-read]', root).forEach(function (b) { out.read[b.getAttribute('data-cb-read')] = b; });
  var ticks = BDH.$$('[data-cb-tick]', root);

  function txt(el, v) { if (el && v != null) el.textContent = v; }

  /* the same slice-and-dice as $twa_cb_map: row 1 is images + JavaScript, row 2 is everything else,
     a resource at 0 KB drops out, row height is its share of the total and cell width its share of the row */
  function tile(r) {
    if (!map) return;
    var groups = [res.slice(0, 2), res.slice(2)];
    var sums = groups.map(function (g) {
      return g.reduce(function (n, x) { return n + x.kb[r]; }, 0);
    });
    var all = sums[0] + sums[1];
    if (!all) return;
    groups.forEach(function (g, gi) {
      if (mRows[gi]) mRows[gi].style.setProperty('--h', (sums[gi] / all * 100).toFixed(2) + '%');
      g.forEach(function (x) {
        var c = cells[x.key];
        if (!c) return;
        var on = x.kb[r] > 0;
        c.hidden = !on;
        if (on) c.style.setProperty('--w', (x.kb[r] / sums[gi] * 100).toFixed(2) + '%');
        var k = c.querySelector('.twa-cb__ck');
        if (k) k.textContent = x.kb[r].toLocaleString('en-GB') + ' KB';
      });
    });
  }

  function show(r) {
    var d = rungs[r];
    if (!d) return;
    var g = function (n) { return d.getAttribute('data-' + n); };

    rungs.forEach(function (li, i) { li.classList.toggle('is-on', i === r); });
    ticks.forEach(function (t, i) { t.classList.toggle('is-on', i === r); });

    txt(out.state, g('state'));
    txt(out.tot, g('mb'));
    txt(out.tot2, g('mb'));
    txt(out.cut, g('cutl'));
    txt(out.cut2, g('cut'));
    txt(out.half, String(Math.round(parseFloat(g('s')))));
    txt(out.cost, g('cost'));
    txt(out.refuse, g('refuse'));
    txt(out.col, g('label'));
    txt(out.sqt, g('mb'));
    if (out.sq) out.sq.style.setProperty('--s', g('s') + '%');
    txt(out.read.gb, g('gb'));
    txt(out.read.kg, g('kg'));
    txt(out.read.g, g('g'));
    txt(out.read.mb, g('mb'));

    res.forEach(function (x) {
      txt(x.kbEl, x.kb[r].toLocaleString('en-GB') + ' KB');
      txt(x.nEl, x.notes[r]);
    });
    tile(r);
    range.setAttribute('aria-valuetext', g('vt'));
  }

  range.addEventListener('input', function () { show(parseInt(range.value, 10) || 0); });
})();
