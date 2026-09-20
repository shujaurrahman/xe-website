/* Tech Workforce · arm — the page's motion contract in one place.
   Every section whose CSS hides something before it enters marks its root [data-ttw-arm]. The
   hide rules are all written behind .is-armed, and only this script adds that class, and only
   when window.BDH is present and motion is allowed. With JavaScript off, or under
   prefers-reduced-motion, no root is armed, nothing is hidden, and the shipped HTML — which is
   already the finished state — is what the visitor reads.
   Loaded from services/technology-intelligence/tech-workforce.php right after hub.js. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;

  var roots = document.querySelectorAll('.ttw [data-ttw-arm]');
  for (var i = 0; i < roots.length; i++) roots[i].classList.add('is-armed');
})();
