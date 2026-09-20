/* Support — replays the incident once the band is on screen: each timeline step lights in turn and
   the dead-letter queue readout climbs to its peak, then drains to zero at the replay. The HTML is
   already the resolved incident, so this only shows the order it happened in. Stops for good on the
   first interaction; nothing runs under reduced motion. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.tis-su');
  if (!root || BDH.reduced) return;

  var steps = BDH.$$('.tis-su__step', root);
  var now   = BDH.$('[data-q-now]', root);
  if (!steps.length) return;

  /* queue depth as the incident runs, aligned to the six timeline steps */
  var depth = [52, 52, 61, 63, 0, 0];
  var rest  = now ? now.textContent : '';
  var seq   = [];

  function clear() { steps.forEach(function (s) { s.classList.remove('is-now'); }); }

  steps.forEach(function (step, i) {
    seq.push([i === 0 ? 800 : 1000, function () {
      clear();
      step.classList.add('is-now');
      if (now) now.textContent = String(depth[i]);
    }]);
  });

  seq.push([1200, function () { clear(); if (now) now.textContent = rest; }]);

  BDH.seq(root, seq, { loop: false, stopOnInteract: true, interactRoot: root, onStop: function () {
    clear();
    if (now) now.textContent = rest;
  } });
})();
