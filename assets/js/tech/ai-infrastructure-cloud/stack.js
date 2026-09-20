/* AI Infrastructure & Cloud · stack — the rack's units are a vertical ARIA tablist (arrow keys, Home/End);
   choosing a unit slides it out and opens its tray. On wide screens the rack walks up from U04 slowly
   until the reader touches it; LEDs blink only while the rack is on screen. Reduced motion: no cycling. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tic-rk');
  if (!root) return;
  var rack = root.querySelector('.tic-rk__rack');
  if (rack) BDH.live(rack, 0.2);
  var wide = window.matchMedia('(min-width: 1024px)').matches;
  BDH.tabs(root, {
    tabs: '.tic-rk__unit',
    orientation: 'vertical',
    auto: wide ? 5600 : 0,
    interactRoot: root
  });
})();
