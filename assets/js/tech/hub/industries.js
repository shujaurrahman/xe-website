/* Hub · industries — the sector list is an ARIA tablist (BDH.tabs: arrows, Home/End). It advances on its own
   every 7 s while the section is on screen, with a progress line under the selected sector, until the reader
   touches it. Each switch replays the pane's arrival (CSS on .is-on). On narrow screens the list scrolls
   sideways, so the chosen tab is kept in view. Reduced motion: tabs work, nothing advances on its own. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tih-ind');
  if (!root) return;
  var list = BDH.$('.tih-ind__list', root);
  var tabs = BDH.$$('.tih-ind__tab', root);
  var pos = BDH.$('.tih-ind__pos', root);
  if (!tabs.length) return;

  var MS = 7000;
  root.style.setProperty('--ind-ms', MS + 'ms');
  var mq = window.matchMedia('(max-width:1023px)');

  function orient() { if (list) list.setAttribute('aria-orientation', mq.matches ? 'horizontal' : 'vertical'); }
  orient();
  if (mq.addEventListener) mq.addEventListener('change', orient);

  function keepInView(i) {
    if (!mq.matches || !list) return;
    var t = tabs[i], l = list.getBoundingClientRect(), r = t.getBoundingClientRect();
    if (r.left < l.left || r.right > l.right) list.scrollTo({ left: list.scrollLeft + (r.left - l.left) - 16, behavior: BDH.reduced ? 'auto' : 'smooth' });
  }

  var api = BDH.tabs(root, {
    tabs: '.tih-ind__tab',
    auto: BDH.reduced ? 0 : MS,
    interactRoot: root,
    onChange: function (i) {
      if (pos) pos.textContent = (i < 9 ? '0' : '') + (i + 1);
      keepInView(i);
    }
  });

  if (!BDH.reduced) {
    root.classList.add('is-auto');
    BDH.onInteract(root, function () { root.classList.remove('is-auto'); api.stop(); });
  }
})();
