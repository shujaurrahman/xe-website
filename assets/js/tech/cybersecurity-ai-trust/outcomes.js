/* Cybersecurity & AI Trust · outcomes — the heatmap switch. Each cell already carries both states
   (data-b baseline, data-a day-90 target), so the page reads correctly with no JS at all. This swaps
   --n and the printed count, updates the total, and runs one demonstration switch on entry that stops
   the moment anyone uses the control. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-oc]'); if (!root) return;

  var btns  = BDH.$$('[data-oc-b]', root);
  var cells = BDH.$$('.tsc-oc__c', root);
  var total = root.querySelector('[data-oc-total]');
  var when  = root.querySelector('[data-oc-when]');
  var map   = root.querySelector('.tsc-oc__map');
  if (!btns.length || !cells.length) return;

  var LABEL = { b: 'baseline, week 0', a: 'day 90 target' };

  function show(state) {
    if (root.getAttribute('data-state') === state) return;
    root.setAttribute('data-state', state);
    var sum = 0;
    cells.forEach(function (c) {
      var v = parseInt(c.getAttribute(state === 'a' ? 'data-a' : 'data-b') || '0', 10);
      sum += v;
      c.style.setProperty('--n', String(v));
      c.classList.toggle('is-zero', v === 0);
      var out = c.querySelector('[data-oc-v]');
      if (out) out.textContent = String(v);
    });
    if (total) total.textContent = String(sum);
    if (when) when.textContent = LABEL[state] || '';
    btns.forEach(function (b) { b.setAttribute('aria-pressed', String(b.getAttribute('data-oc-b') === state)); });
  }

  btns.forEach(function (b) {
    b.addEventListener('click', function () { show(b.getAttribute('data-oc-b')); });
  });

  if (map) BDH.enter(map);
  if (BDH.reduced || !map) return;

  BDH.inView(map, function () {
    BDH.seq(map, [
      [2200, function () { show('a'); }],
      [2600, function () { show('b'); }]
    ], { loop: false, stopOnInteract: true, interactRoot: root });
  }, { threshold: 0.3 });
})();
