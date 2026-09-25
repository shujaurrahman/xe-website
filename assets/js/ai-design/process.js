/* Hub · process — walks the .is-on marker along the five stages while the rail is on screen, so the
   dots read as a sequence rather than a row of bullets. Stage 01 ships with .is-on, so with JavaScript
   off (or under reduced motion) the rail is simply a finished timeline. Stops for good on the first
   interaction anywhere in the section. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.aih-pc');
  if (!root) return;
  if (BDH.reduced) return;

  var steps = BDH.$$('.aih-pc__step', root);
  if (steps.length < 2) return;

  var at = 0;
  BDH.seq(root, steps.map(function () {
    return [1500, function () {
      steps[at].classList.remove('is-on');
      at = (at + 1) % steps.length;
      steps[at].classList.add('is-on');
    }];
  }), { loop: true, stopOnInteract: true });
})();
