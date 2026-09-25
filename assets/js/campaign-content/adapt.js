/* Hub · adapt — the adaptation engine. A radiogroup of placements (arrow keys move and select, Home
   and End jump, Space and Enter confirm) switches the canvas frame and the pre-flight table, then
   replays the eight checks one row at a time so the panel behaves like the tool it represents. The
   "Show the rules" switch overlays the safe area and clearspace. Autoplays through the placements
   until the first interaction. Reduced motion: instant switching, no replay, no autoplay. With
   JavaScript off the first placement is shown with its rules overlaid and every check resolved. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.cch-ad');
  if (!root) return;
  var radios = BDH.$$('.cch-ad__place', root);
  var frames = BDH.$$('.cch-ad__frame', root);
  var tables = BDH.$$('.cch-ad__tbl', root);
  var stage = BDH.$('.cch-ad__stage', root);
  var live = BDH.$('.cch-ad__live', root);
  var stxt = BDH.$('.cch-ad__stxt', root);
  var spec = BDH.$('[data-ad="spec"]', root);
  var note = BDH.$('[data-ad="note"]', root);
  var sum = BDH.$('[data-ad="sum"]', root);
  var sw = BDH.$('.cch-ad__rules', root);
  if (!radios.length || radios.length !== frames.length || radios.length !== tables.length) return;

  var cur = 0, rowT = [], readyT = null;

  function clearRows() {
    rowT.forEach(clearTimeout); rowT = [];
    clearTimeout(readyT);
  }

  function replay(table) {
    if (BDH.reduced) return;
    var rows = BDH.$$('.cch-ad__row', table);
    clearRows();
    root.classList.add('is-busy');
    if (stxt) stxt.textContent = 'Running pre-flight';
    rows.forEach(function (r) { r.classList.remove('is-shown'); });
    rows.forEach(function (r, n) {
      rowT.push(setTimeout(function () { r.classList.add('is-shown'); }, 90 + n * 85));
    });
    readyT = setTimeout(function () {
      root.classList.remove('is-busy');
      if (stxt) stxt.textContent = 'Pre-flight complete';
    }, 120 + rows.length * 85);
  }

  function paint(i) {
    radios.forEach(function (r, n) {
      r.setAttribute('aria-checked', n === i ? 'true' : 'false');
      r.tabIndex = n === i ? 0 : -1;
    });
  }

  function select(i, focus) {
    i = (i % radios.length + radios.length) % radios.length;
    paint(i);
    if (focus) radios[i].focus();
    if (i === cur) return;
    cur = i;
    root.setAttribute('data-place', String(i));
    frames.forEach(function (f, n) { f.classList.toggle('is-on', n === i); });
    tables.forEach(function (t, n) { t.classList.toggle('is-on', n === i); });
    var t = tables[i];
    if (spec) spec.textContent = t.getAttribute('data-spec') || '';
    if (note) note.textContent = t.getAttribute('data-note') || '';
    if (sum) sum.textContent = t.getAttribute('data-sum') || '';
    if (live) live.textContent = (t.getAttribute('data-name') || '') + ', ' + (t.getAttribute('data-spec') || '') + '. ' + (t.getAttribute('data-sum') || '') + '.';
    replay(t);
  }

  radios.forEach(function (r, n) {
    r.addEventListener('click', function () { select(n); });
    r.addEventListener('keydown', function (e) {
      var k = e.key, j = -1;
      if (k === 'ArrowRight' || k === 'ArrowDown') j = n + 1;
      else if (k === 'ArrowLeft' || k === 'ArrowUp') j = n - 1;
      else if (k === 'Home') j = 0;
      else if (k === 'End') j = radios.length - 1;
      else if (k === ' ' || k === 'Enter') { e.preventDefault(); select(n); return; }
      if (j === -1) return;
      e.preventDefault();
      select(j, true);
    });
  });

  /* ---- the rules overlay ---- */
  if (sw && stage) {
    sw.addEventListener('click', function () {
      var on = sw.getAttribute('aria-pressed') !== 'true';
      sw.setAttribute('aria-pressed', on ? 'true' : 'false');
      stage.classList.toggle('is-rules', on);
    });
  }

  /* ---- autoplay through the placements until the reader takes over ---- */
  if (BDH.reduced) return;
  var steps = [];
  for (var s = 1; s <= radios.length; s++) {
    (function (g) { steps.push([4200, function () { select(g % radios.length); }]); })(s);
  }
  BDH.seq(root, steps, { loop: true, stopOnInteract: true, onStop: function () { clearRows(); root.classList.remove('is-busy'); if (stxt) stxt.textContent = 'Pre-flight complete'; } });
})();
