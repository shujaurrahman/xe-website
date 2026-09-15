/* §5 decision rules — vertical case tabs (BDH.tabs, arrow keys); each shown ruling replays its
   stamps and traces. Rotates through the cases while on screen until first touch. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cbf-rules]'); if (!root) return;
  var panes = BDH.$$('.cbf-rules__pane', root);
  function run(p) {
    if (BDH.reduced || !p) return;
    p.classList.remove('is-run'); p.offsetWidth; p.classList.add('is-run');
  }
  BDH.tabs(root, {
    tabs: '.cbf-rules__case',
    orientation: 'vertical',
    auto: window.matchMedia('(min-width:1025px)').matches ? 7000 : 0,   // stacked on narrow screens: no rotation
    onChange: function (i) { run(panes[i]); }
  });
  BDH.enter(root, { cls: 'is-in' });
  BDH.inView(root, function () { run(panes.filter(function (p) { return !p.hidden; })[0]); });
})();
