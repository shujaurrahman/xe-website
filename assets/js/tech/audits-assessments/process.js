/* Audits & Assessments · process — replays the schedule drawing once, when the chart first enters.
   The HTML and CSS already render the finished chart: .is-run only re-runs the week rules, the bars
   and the gate markers from their start state. Nothing happens under reduced motion. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-taa-process]');
  if (!root || BDH.reduced) return;

  BDH.inView(root, function () { root.classList.add('is-run'); }, { threshold: 0.2 });
})();
