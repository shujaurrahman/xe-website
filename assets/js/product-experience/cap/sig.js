/* Product & Experience Design capability pages — the signature mock's state switcher.
   The shipped HTML is a finished state (data-state on the figure, its caption filled in), so without JS the mock is
   complete and the controls stay hidden. With JS: the controls appear as toggle buttons (aria-pressed; arrow keys,
   Home and End move between them), the caption is a polite live region, and while on screen the mock steps through
   its states until the visitor interacts. Reduced motion: controls only, no auto-advance. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var fig = document.querySelector('[data-pxd-sig]'); if (!fig) return;
  var ctl = fig.querySelector('.pxd-sig__ctl'); if (!ctl) return;
  var btns = [].slice.call(ctl.querySelectorAll('.pxd-sig__opt')); if (!btns.length) return;
  var live = fig.querySelector('.pxd-sig__live'), key = fig.querySelector('.pxd-sig__k');
  var cur = 0, auto = null;
  btns.forEach(function (b, i) { if (b.getAttribute('aria-pressed') === 'true') cur = i; });

  function set(i, announce) {
    cur = (i + btns.length) % btns.length;
    var b = btns[cur];
    fig.setAttribute('data-state', b.getAttribute('data-v'));
    btns.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
    if (key) key.textContent = b.getAttribute('data-k');
    if (live) {
      live.setAttribute('aria-live', announce ? 'polite' : 'off');
      live.textContent = b.getAttribute('data-say');
    }
  }
  function stop() { if (auto) { auto.stop(); auto = null; } }

  btns.forEach(function (b, i) {
    b.addEventListener('click', function () { stop(); set(i, true); });
    b.addEventListener('keydown', function (e) {
      var k = e.key, to = null;
      if (k === 'ArrowRight' || k === 'ArrowDown') to = cur + 1;
      else if (k === 'ArrowLeft' || k === 'ArrowUp') to = cur - 1;
      else if (k === 'Home') to = 0;
      else if (k === 'End') to = btns.length - 1;
      if (to === null) return;
      e.preventDefault(); stop(); set(to, true); btns[cur].focus();
    });
  });
  ctl.hidden = false;

  if (BDH.reduced) return;
  auto = BDH.loop(fig, 5200, function () { set(cur + 1, false); });
  BDH.onInteract(fig, stop);
})();
