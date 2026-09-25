/* Hub · method — a marker walks the four gates in order while the row is on screen, so the rail reads
   as a sequence rather than four separate columns. The rails themselves are filled by CSS on .is-in and
   stay filled, which is the finished state the markup ships with. Reduced motion: no walk. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var row = document.querySelector('.pxh-method__gates');
  if (!row || BDH.reduced) return;

  var gates = BDH.$$('.pxh-method__gate', row);
  if (gates.length < 2) return;

  var at = -1;
  function step() {
    if (at > -1 && gates[at]) gates[at].classList.remove('is-at');
    at = (at + 1) % gates.length;
    gates[at].classList.add('is-at');
  }
  BDH.inView(row, function () { setTimeout(step, 900); }, { threshold: 0.25 });
  BDH.loop(row, 2200, step);
})();
