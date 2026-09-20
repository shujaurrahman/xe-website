/* Custom Software & Data Platforms · stack — the seven plates are an ARIA tablist (BDH.tabs): click or arrow keys
   select a layer, the pane beside it swaps. While on screen and untouched, the selection walks the layers from
   the top, one every 8 s; the first interaction, or the pointer entering the diagram, stops it for good.
   When the diagram first comes into view the stack explodes once (.is-x on the cake for about three seconds)
   and presses back together, so the exploded view is shown even to a reader who never hovers it.
   Reduced motion: no auto-rotation and no demonstration; CSS shows the exploded view, static. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tcs-stack'); if (!root) return;
  var cake = root.querySelector('.tcs-cake'); if (!cake) return;
  var sk = root.querySelector('.tcs-sk');
  var api = BDH.tabs(root, { tabs: '.tcs-sk__plate', panes: '.tcs-sk__pane', orientation: 'vertical' });
  if (BDH.reduced) return;
  var stopped = false;
  BDH.onInteract(sk, function () { stopped = true; });
  sk.addEventListener('pointerenter', function () { stopped = true; }, { once: true });
  BDH.inView(sk, function () {
    if (!window.matchMedia || window.matchMedia('(min-width:601px)').matches) {
      setTimeout(function () { cake.classList.add('is-x'); }, 450);
      setTimeout(function () { cake.classList.remove('is-x'); }, 3600);
    }
    if (stopped) return;
    api.show(0, false);
    var i = 0;
    var timer = BDH.loop(sk, 8000, function () {
      if (stopped) { timer.stop(); return; }
      i = (i + 1) % 7;
      api.show(i, false);
    });
    BDH.onInteract(sk, function () { timer.stop(); });
    sk.addEventListener('pointerenter', function () { stopped = true; timer.stop(); }, { once: true });
  }, { threshold: 0.35 });
})();
