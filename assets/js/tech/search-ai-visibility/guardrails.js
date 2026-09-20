/* Search & AI Visibility — 09 · Guardrails.
   The gate list is complete in HTML: every tick and every cross is already drawn, and each row
   carries its own --i. This file only adds .is-anim when motion is allowed, which arms the
   undrawn state, and hands the panel to BDH.live so the marks draw in sequence while it is on
   screen. Without JavaScript, or under prefers-reduced-motion, the checks are simply there. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;

  var gate = document.querySelector('[data-tsv-rules]');
  if (!gate) return;

  gate.classList.add('is-anim');
  BDH.live(gate, 0.2);
})();
