/* Hub · stack — the layer filter and the single-select listbox of marks. Choosing a mark fills the detail
   rail: what we use it for, and which capabilities on this page lean on it. Arrow keys move through the
   marks, Home and End jump, and the roving tabindex keeps one tab stop for the whole list.
   With JavaScript off every layer is printed and the rail describes the first mark, so nothing is hidden. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.mth-stk');
  if (!root) return;

  var cells = BDH.$$('.mth-stk__cell', root);
  var cats = BDH.$$('.mth-stk__cat', root);
  var rows = BDH.$$('.mth-stk__row', root);
  var detail = BDH.$('.mth-stk__detail', root);
  if (!cells.length || !detail) return;

  var dMark = BDH.$('[data-d="mark"]', detail);
  var dName = BDH.$('[data-d="name"]', detail);
  var dLayer = BDH.$('[data-d="layer"]', detail);
  var dUse = BDH.$('[data-d="use"]', detail);
  var dNone = BDH.$('[data-d="none"]', detail);
  var capLinks = BDH.$$('.mth-stk__dl .mth-capl', detail);

  function select(cell, focus) {
    if (!cell) return;
    cells.forEach(function (c) {
      var on = c === cell;
      c.setAttribute('aria-selected', on ? 'true' : 'false');
      c.tabIndex = on ? 0 : -1;
    });
    if (focus) cell.focus();
    var mark = cell.querySelector('.mth-stk__mk');
    if (dMark && mark) dMark.innerHTML = mark.innerHTML;
    if (dName) dName.textContent = cell.getAttribute('data-name') || '';
    if (dLayer) dLayer.textContent = cell.getAttribute('data-layerl') || '';
    if (dUse) dUse.textContent = cell.getAttribute('data-use') || '';
    var caps = (cell.getAttribute('data-caps') || '').split(',').filter(Boolean);
    capLinks.forEach(function (a) {
      a.hidden = caps.indexOf(a.getAttribute('data-cap')) === -1;
    });
    if (dNone) dNone.hidden = caps.length > 0;
  }

  /* visible cells only, so the arrow keys follow what is on screen after a filter */
  function shown() {
    return cells.filter(function (c) { return c.offsetParent !== null; });
  }

  cells.forEach(function (cell) {
    cell.addEventListener('click', function () { select(cell); });
    cell.addEventListener('keydown', function (e) {
      var list = shown(), n = list.indexOf(cell), j = -1;
      if (e.key === 'ArrowRight' || e.key === 'ArrowDown') j = n + 1;
      else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') j = n - 1;
      else if (e.key === 'Home') j = 0;
      else if (e.key === 'End') j = list.length - 1;
      else if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); select(cell); return; }
      if (j === -1 || !list.length) return;
      e.preventDefault();
      j = (j % list.length + list.length) % list.length;
      select(list[j], true);
    });
  });

  cats.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var key = btn.getAttribute('data-layer');
      cats.forEach(function (b) { b.setAttribute('aria-pressed', b === btn ? 'true' : 'false'); });
      root.setAttribute('data-layer', key);
      rows.forEach(function (r) { r.classList.toggle('is-on', key === 'all' || r.getAttribute('data-layer') === key); });
      /* keep the selection inside what is now visible */
      var list = shown();
      if (list.length && list.indexOf(root.querySelector('.mth-stk__cell[aria-selected="true"]')) === -1) select(list[0]);
    });
  });
})();
