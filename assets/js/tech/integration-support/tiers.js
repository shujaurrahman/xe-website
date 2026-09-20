/* Tiers — selecting a plan highlights its column in the comparison table. Pressing the
   selected plan again clears the highlight, so the table returns to reading equally.
   The table is complete without this: no plan is selected in the HTML. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-tis-tiers]');
  if (!root) return;

  var btns = BDH.$$('[data-tis-plan]', root);
  if (!btns.length) return;

  function select(plan) {
    btns.forEach(function (b) {
      var on = b.getAttribute('data-tis-plan') === plan;
      b.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
    if (plan) root.setAttribute('data-plan', plan);
    else root.removeAttribute('data-plan');
  }

  btns.forEach(function (b) {
    b.addEventListener('click', function () {
      var plan = b.getAttribute('data-tis-plan');
      select(b.getAttribute('aria-pressed') === 'true' ? null : plan);
    });
  });
})();
