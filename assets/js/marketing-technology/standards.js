/* Hub · standards — the badge wall is a set of pressed-state buttons over stacked panes. Selecting a badge
   shows that framework's pane. With JavaScript off the wall is a complete set of badges and the panel
   explains the first one, so nothing is hidden behind a control that never arrives. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.mth-std');
  if (!root) return;

  var btns = BDH.$$('.mth-std__b', root);
  var panes = BDH.$$('.mth-std__pane', root);
  if (!btns.length || !panes.length) return;

  function show(key) {
    root.setAttribute('data-std', key);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-std') === key ? 'true' : 'false'); });
    panes.forEach(function (p) { p.classList.toggle('is-on', p.getAttribute('data-std') === key); });
  }

  btns.forEach(function (b) {
    b.addEventListener('click', function () { show(b.getAttribute('data-std')); });
  });
})();
