/* Custom Software & Data Platforms · carbon — Before / After policies. The HTML is the "after" state.
   On first entry (motion allowed) the window shows "before" for a beat, then plays to "after": storage blocks
   slide down the temperature scale (or are deleted by retention) and the compute bars shrink, staggered.
   The two buttons switch at any time; the first press cancels the intro. Reduced motion: no intro, the
   buttons swap the state at once (CSS drops the transitions). */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tcs-carbon'); if (!root) return;
  var win = root.querySelector('.tcs-cb__win'); if (!win) return;
  var btns = BDH.$$('[data-cb-set]', win);
  var ro = win.querySelector('[data-cb-ro]');
  var nowLbl = win.querySelector('[data-cb-now]');   // legend label for the solid bars follows the state
  var R = BDH.reduced, intro = null, swapT = null;

  function set(state, animate) {
    win.setAttribute('data-state', state);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', String(b.getAttribute('data-cb-set') === state)); });
    if (ro) ro.textContent = (state === 'after' ? 'After policies' : 'Before policies') + ' · 28-day view';
    if (nowLbl) nowLbl.textContent = state === 'after' ? 'After policies' : 'Before policies';
    if (animate && !R) {
      win.classList.remove('is-swap'); void win.offsetWidth; win.classList.add('is-swap');
      clearTimeout(swapT); swapT = setTimeout(function () { win.classList.remove('is-swap'); }, 700);
    }
  }

  btns.forEach(function (b) {
    b.addEventListener('click', function () {
      if (intro) { clearTimeout(intro); intro = null; }
      set(b.getAttribute('data-cb-set'), true);
    });
  });

  if (R) return;

  /* intro: before → after, once, when the window is well in view */
  set('before', false);
  BDH.inView(win, function () {
    intro = setTimeout(function () { intro = null; set('after', true); }, 1100);
  }, { threshold: 0.35 });
})();
