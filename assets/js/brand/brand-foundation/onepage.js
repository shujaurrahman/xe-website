/* §8 foundation on a page — hover, focus or press a block: the sheet zooms towards it (wide screens,
   motion allowed) and the margin card explains it. Tours the blocks until first touch (wide only).
   Phones (≤720px): the sheet stacks, so the explainer opens inline directly under the pressed block. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cbf-one]'); if (!root) return;
  var sheet = root.querySelector('[data-one-sheet]'), desk = root.querySelector('.cbf-one__desk');
  var note = root.querySelector('.cbf-one__note'), hint = root.querySelector('.cbf-one__hint');
  var blocks = BDH.$$('[data-one]', root), cards = BDH.$$('[data-one-card]', root);
  var wide = window.matchMedia('(min-width:721px)'), cur = blocks[0].getAttribute('data-one');

  function zoom(b) {
    if (!b || BDH.reduced || !wide.matches) { sheet.style.setProperty('--z', 1); sheet.classList.remove('is-zoom'); return; }
    var s = sheet.getBoundingClientRect(), r = b.getBoundingClientRect(), z = +getComputedStyle(sheet).getPropertyValue('--z') || 1;
    var ox = ((r.left + r.width / 2 - s.left) / z) / (s.width / z) * 100, oy = ((r.top + r.height / 2 - s.top) / z) / (s.height / z) * 100;
    sheet.style.setProperty('--ox', ox.toFixed(1) + '%'); sheet.style.setProperty('--oy', oy.toFixed(1) + '%');
    sheet.style.setProperty('--z', 1.32); sheet.classList.add('is-zoom');
  }
  function place() {   // put the visible card inline under its block on phones, back in the margin otherwise
    cards.forEach(function (c) {
      var k = c.getAttribute('data-one-card');
      if (!wide.matches && k === cur) { var b = root.querySelector('[data-one="' + k + '"]'); if (b.nextElementSibling !== c) b.insertAdjacentElement('afterend', c); c.classList.add('is-inline'); }
      else if (c.parentNode !== note) { note.insertBefore(c, hint); c.classList.remove('is-inline'); }
      else c.classList.remove('is-inline');
    });
  }
  function show(k, withZoom) {
    var b = root.querySelector('[data-one="' + k + '"]');
    blocks.forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
    if (k !== cur) cards.forEach(function (c) { c.hidden = c.getAttribute('data-one-card') !== k; });
    cur = k;
    place();
    zoom(withZoom ? b : null);
  }
  blocks.forEach(function (b) {
    var k = b.getAttribute('data-one');
    b.addEventListener('pointerenter', function (e) { if (e.pointerType === 'mouse') show(k, true); });
    b.addEventListener('focus', function () { if (wide.matches) show(k, true); });
    b.addEventListener('click', function () { show(k, !sheet.classList.contains('is-zoom') || cur !== k); });
    b.addEventListener('keydown', function (e) { if (e.key === 'Escape') zoom(null); });
  });
  desk.addEventListener('pointerleave', function () { zoom(null); });
  root.addEventListener('focusout', function (e) { if (!root.contains(e.relatedTarget)) zoom(null); });
  if (wide.addEventListener) wide.addEventListener('change', place);
  place();

  if (!wide.matches) return;   // phones: no tour, the reader taps through
  var steps = [];
  blocks.forEach(function (b, i) {
    steps.push([i === 0 ? 1200 : 2600, function () { show(b.getAttribute('data-one'), true); }]);
  });
  steps.push([2600, function () { zoom(null); }]);
  BDH.seq(root, steps, { loop: true, onStop: function () { zoom(null); } });
})();
