/* Dispatch · hero — two enhancements, both optional.
   1. The staggered entrance. The HTML ships finished; this file adds .is-anim, which is the only rule
      that hides anything, then .is-in to play it. Skipped entirely under reduced motion.
   2. The subject line cycles through the sample subjects while the card is on screen, typed in.
      The first subject is already in the HTML, so with this file absent the card is complete. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.nlt-hero');
  if (!root) return;

  /* ---- entrance ---- */
  if (!BDH.reduced) {
    root.classList.add('is-anim');
    /* next frame, so the hidden start is painted before the transition to the finished state */
    requestAnimationFrame(function () {
      requestAnimationFrame(function () { root.classList.add('is-in'); });
    });
  }

  /* ---- the subject line ---- */
  var target = root.querySelector('[data-hero-subject]');
  var card = root.querySelector('.nlt-hero__card');
  if (!target || !card || BDH.reduced) return;

  var subjects = [];
  document.querySelectorAll('.nlt-arc__t').forEach(function (el) {
    var t = (el.textContent || '').trim();
    if (t) subjects.push(t);
  });
  var first = (target.textContent || '').trim();
  if (subjects.indexOf(first) === -1) subjects.unshift(first);
  if (subjects.length < 2) return;

  var i = subjects.indexOf(first);
  if (i < 0) i = 0;
  var typing = null;

  BDH.loop(card, 5200, function () {
    i = (i + 1) % subjects.length;
    if (typing && typing.stop) typing.stop();
    target.textContent = '';
    typing = BDH.type(target, subjects[i], { speed: 22 });
  });
})();
