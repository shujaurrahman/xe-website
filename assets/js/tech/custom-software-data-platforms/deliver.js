/* Custom Software & Data Platforms · deliver — the docs sidebar is a vertical ARIA tablist (BDH.tabs: click,
   arrow keys, Home/End); the preview pane swaps and the address bar shows where that document lives in your
   repositories. While on screen and untouched it walks the eight documents, one every 8 s; the first interaction,
   or the pointer entering the window, stops it for good so nobody loses a pane mid-sentence.
   Reduced motion: no auto-advance. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tcs-deliver'); if (!root) return;
  var win = root.querySelector('.tcs-dl__win'); if (!win) return;
  var path = root.querySelector('[data-dl-path]');
  var tabs = BDH.$$('.tcs-dl__tab', root);
  var api = BDH.tabs(win, {
    tabs: '.tcs-dl__tab',
    panes: '.tcs-dl__pane',
    orientation: 'vertical',
    auto: 8000,
    interactRoot: win,
    onChange: function (i) {
      if (path && tabs[i]) path.textContent = tabs[i].getAttribute('data-path') || '';
      /* keep the selected tab visible in the horizontal strip on narrow screens, without moving the page */
      var strip = root.querySelector('.tcs-dl__tabs');
      if (strip && strip.scrollWidth > strip.clientWidth && tabs[i]) {
        var t = tabs[i];
        var l = t.offsetLeft, r = l + t.offsetWidth;   // the strip is position:relative
        if (l < strip.scrollLeft || r > strip.scrollLeft + strip.clientWidth) strip.scrollTo({ left: Math.max(0, l - 12), behavior: BDH.reduced ? 'auto' : 'smooth' });
      }
    }
  });
  win.addEventListener('pointerenter', function () { api.stop(); }, { once: true });
})();
