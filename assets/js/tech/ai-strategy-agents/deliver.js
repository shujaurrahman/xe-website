/* AI Strategy & Agents · deliver — the binder's index tabs as an ARIA tablist (arrows, Home, End;
   vertical on desktop, a row on small screens). On wide screens, where every page shares one
   height, the pages turn every six seconds while on screen until the binder is touched; below
   900px the binder takes the open page's height, so the pages only turn by hand. Each page's items
   settle in as it opens (CSS under .is-live). Reduced motion: no turning, no settle; tabs work. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var dl = document.querySelector('[data-tas-dl]'); if (!dl) return;
  var tl = dl.querySelector('[role="tablist"]');
  function orient() { if (tl) tl.setAttribute('aria-orientation', window.innerWidth > 900 ? 'vertical' : 'horizontal'); }
  orient();
  window.addEventListener('resize', orient, { passive: true });
  BDH.tabs(dl, { auto: window.innerWidth > 900 ? 6000 : 0, interactRoot: dl });
  BDH.live(dl, 0.1);
})();
