/* Campaign & Content capability pages — drives every signature mock ([data-ccd-sig]).
   Buttons [data-ccd-set] set the root's data-state; CSS shows [data-on] / highlights [data-hl] for that state.
   The shipped HTML is already a finished state. While on screen the mock steps through its states until the
   visitor interacts; reduced motion never auto-steps. Arrow keys, Home and End move between the buttons. */
(function () {
  'use strict';
  var roots = document.querySelectorAll('[data-ccd-sig]');
  var reduced = window.BDH ? window.BDH.reduced : (window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches);
  Array.prototype.forEach.call(roots, function (root) {
    var btns = root.querySelectorAll('[data-ccd-set]');
    var n = btns.length, user = false, lp = null;
    if (!n) return;
    var ro = root.querySelector('.ccd-sig__ro');
    function set(v) {
      root.setAttribute('data-state', String(v));
      Array.prototype.forEach.call(btns, function (b) {
        b.setAttribute('aria-pressed', b.getAttribute('data-ccd-set') === String(v) ? 'true' : 'false');
      });
    }
    function take() {
      if (user) return;
      user = true;
      if (ro) ro.setAttribute('aria-live', 'polite');
      if (lp) lp.stop();
    }
    Array.prototype.forEach.call(btns, function (b, i) {
      b.addEventListener('click', function () { take(); set(b.getAttribute('data-ccd-set')); });
      b.addEventListener('keydown', function (e) {
        var j = -1, k = e.key;
        if (k === 'ArrowRight' || k === 'ArrowDown') j = (i + 1) % n;
        else if (k === 'ArrowLeft' || k === 'ArrowUp') j = (i - 1 + n) % n;
        else if (k === 'Home') j = 0;
        else if (k === 'End') j = n - 1;
        if (j < 0) return;
        e.preventDefault();
        take();
        btns[j].focus();
        set(btns[j].getAttribute('data-ccd-set'));
      });
    });
    root.addEventListener('focusin', take);
    root.addEventListener('pointerdown', take);
    if (reduced || !window.BDH || !window.BDH.loop) return;
    lp = window.BDH.loop(root, 4200, function () {
      if (user) return;
      var cur = parseInt(root.getAttribute('data-state'), 10) || 1;
      set(cur % n + 1);
    });
  });
})();
