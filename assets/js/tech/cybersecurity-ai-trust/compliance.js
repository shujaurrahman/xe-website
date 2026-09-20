/* Cybersecurity & AI Trust · compliance — the control crosswalk. Choosing a framework column marks its
   cells and swaps the detail panel beside the matrix. The HTML already shows the finished matrix with the
   first framework selected, so nothing here is required to read it. One quiet pass steps across the first
   few columns on entry and stops the moment anyone touches the table. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cw]'); if (!root) return;

  var btns   = BDH.$$('[data-cw-b]', root);
  var panels = BDH.$$('[data-cw-panel]', root);
  var matrix = root.querySelector('.tsc-cw__matrix');
  var cells  = BDH.$$('.tsc-cw__c', root);
  if (!btns.length) return;

  function select(key) {
    if (!key || root.getAttribute('data-sel') === key) return;
    root.setAttribute('data-sel', key);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', String(b.getAttribute('data-cw-b') === key)); });
    panels.forEach(function (p) { p.hidden = p.getAttribute('data-cw-panel') !== key; });
    cells.forEach(function (c) { c.classList.toggle('is-sel', c.getAttribute('data-f') === key); });
  }

  /* mark the initial column so the first paint matches the pressed header */
  var start = root.getAttribute('data-sel');
  cells.forEach(function (c) { c.classList.toggle('is-sel', c.getAttribute('data-f') === start); });

  btns.forEach(function (b) {
    b.addEventListener('click', function () { select(b.getAttribute('data-cw-b')); });
    b.addEventListener('keydown', function (e) {
      var i = btns.indexOf(b), n = null;
      if (e.key === 'ArrowRight') n = btns[i + 1];
      else if (e.key === 'ArrowLeft') n = btns[i - 1];
      else if (e.key === 'Home') n = btns[0];
      else if (e.key === 'End') n = btns[btns.length - 1];
      if (!n) return;
      e.preventDefault();
      n.focus();
      select(n.getAttribute('data-cw-b'));
    });
  });

  if (matrix) BDH.enter(matrix);
  if (BDH.reduced || !matrix) return;

  /* one demonstration pass: security → privacy → AI, then back to where it started */
  BDH.inView(matrix, function () {
    var order = ['soc2', 'gdpr', 'iso42001', start].filter(Boolean);
    var steps = order.map(function (k, i) {
      return [i === 0 ? 1400 : 1100, function () { select(k); }];
    });
    BDH.seq(matrix, steps, { loop: false, stopOnInteract: true, interactRoot: root });
  }, { threshold: 0.25 });
})();
