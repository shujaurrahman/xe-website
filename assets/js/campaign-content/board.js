/* Campaign board: stage tabs (ARIA via BDH.tabs), a planning-mode switch, and an autoplay tour that runs
   only while the board is on screen and stops for good on the first interaction. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.cch-bd');
  if (!root) return;
  var AUTO = 5200;
  var panes = BDH.$$('.cch-bd__pane', root);
  var seg = root.querySelector('.cch-bd__seg');
  var modes = BDH.$$('[data-cch-mode]', root);

  root.classList.add('is-js');
  if (seg) seg.hidden = false;

  function setMode(m) {
    root.setAttribute('data-mode', m);
    modes.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-cch-mode') === m ? 'true' : 'false'); });
  }
  modes.forEach(function (b) {
    b.addEventListener('click', function () { setMode(b.getAttribute('data-cch-mode')); });
  });

  var tabs = BDH.tabs(root, {
    tabs: '.cch-bd__tab',
    panes: '.cch-bd__pane',
    orientation: window.matchMedia('(max-width:1023px)').matches ? 'horizontal' : 'vertical',
    onChange: function (i) {
      var p = panes[i];
      if (!p || BDH.reduced) return;
      p.classList.remove('is-enter'); void p.offsetWidth; p.classList.add('is-enter');
      var t = root.querySelectorAll('.cch-bd__tab')[i];
      var rail = root.querySelector('.cch-bd__rail');
      if (t && rail && rail.scrollWidth > rail.clientWidth) rail.scrollTo({ left: t.offsetLeft - 10, behavior: 'smooth' });
    }
  });
  tabs.show(0);

  if (BDH.reduced) return;
  root.style.setProperty('--cch-auto', AUTO + 'ms');
  root.classList.add('is-auto');
  BDH.live(root, 0.35);
  var tour = BDH.loop(root, AUTO, function () {
    var n = tabs.index() + 1;
    if (n >= panes.length) { n = 0; setMode(root.getAttribute('data-mode') === 'burst' ? 'ao' : 'burst'); }
    tabs.show(n);
  });
  BDH.onInteract(root, function () { tour.stop(); root.classList.remove('is-auto'); });
})();
