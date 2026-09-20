/* Cybersecurity & AI Trust · owasp — one scan pass on entry (the pips fill row by row and the coverage count
   climbs 0 → 10), then the "Open now" readout follows whichever risk is expanded. core.js owns the accordion.
   The HTML is the finished state; under reduced motion nothing is replayed. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tsc-owasp'); if (!root) return;
  var list = root.querySelector('.tsc-ow__list'), side = root.querySelector('.tsc-ow__side');
  var rows = BDH.$$('.tsc-ow__row', root), countEl = root.querySelector('[data-ow-count]'), selEl = root.querySelector('[data-ow-sel]');

  /* core.js flips aria-expanded on the same click, so read the accordion back on the next frame
     rather than trusting the value this handler sees. Nothing open reads as a dash. */
  function syncSel() {
    if (!selEl) return;
    var open = root.querySelector('[data-acc-b][aria-expanded="true"]');
    selEl.textContent = open ? (open.getAttribute('data-ow-label') || '—') : '—';
  }
  BDH.$$('[data-acc-b]', root).forEach(function (b) {
    b.addEventListener('click', function () { requestAnimationFrame(syncSel); });
  });
  syncSel();

  if (side) BDH.enter(side);
  if (BDH.reduced || !list) return;

  BDH.inView(list, function () {
    var total = rows.length, n = 0;
    list.classList.add('is-scan');
    rows.forEach(function (r) { r.classList.remove('is-ok'); });
    if (countEl) countEl.textContent = '0';
    var steps = rows.map(function (r) {
      return [180, function () { r.classList.add('is-ok'); n++; if (countEl) countEl.textContent = String(n); }];
    });
    steps.unshift([350, function () {}]);
    steps.push([300, function () { list.classList.remove('is-scan'); if (countEl) countEl.textContent = String(total); }]);
    BDH.seq(list, steps, { loop: false, stopOnInteract: false });
  }, { threshold: 0.2 });
})();
