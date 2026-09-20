/* Tech Workforce · hero — the mosaic assembles and the role chips take their seats.
   Photos fade up in a stagger, then each photo's role chip is marked "sent" while the matching
   seat appears in the sprint strip, and the strip reports "Squad ready · 6 roles".
   The HTML is already the finished state; this only runs when motion is allowed. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.ttw-hero__in[data-ttw-arm]');
  if (!root || BDH.reduced) return;

  var photos = BDH.$$('.ttw-hero__ph', root);
  var chips  = BDH.$$('[data-ttw-fly]', root);
  var seats  = BDH.$$('[data-ttw-seat]', root);
  var ready  = BDH.$('.ttw-hero__ready', root);
  if (!photos.length || !seats.length) return;

  root.classList.add('is-armed');

  var steps = [];
  photos.forEach(function (ph, i) {
    steps.push([i === 0 ? 120 : 90, function () { ph.classList.add('is-on'); }]);
  });
  steps.push([420, function () {}]);
  seats.forEach(function (seat, i) {
    steps.push([i === 0 ? 0 : 170, function () {
      var chip = chips[i];
      if (chip) {
        chip.classList.add('is-sent');
        setTimeout(function () { chip.classList.remove('is-sent'); }, 520);
      }
      seat.classList.add('is-on');
    }]);
  });
  steps.push([320, function () { if (ready) ready.classList.add('is-on'); }]);

  BDH.seq(root, steps);
})();
