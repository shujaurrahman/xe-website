/* AI Design capability pages — signature mock stepper.
   Shipped HTML is the finished state (every [data-s] visible, controls hidden). With JS: reveal the step buttons,
   dim items past the current step, and auto-play the steps while the mock is on screen. Any click or key on the
   controls stops the auto-play; the play/pause button restarts it. Reduced motion: finished state, no loop. */
(function () {
  'use strict';
  if (!window.BDH) return;
  document.querySelectorAll('[data-aid-sig]').forEach(function (root) {
    var ctl = root.querySelector('.aid-sig__ctl');
    var btns = [].slice.call(root.querySelectorAll('[data-aid-go]'));
    var play = root.querySelector('[data-aid-play]');
    var say = root.querySelector('[data-aid-say]');
    var items = [].slice.call(root.querySelectorAll('[data-s]'));
    var n = btns.length, at = n, timer = null, auto = !BDH.reduced, on = false;
    if (!ctl || !n) return;
    ctl.hidden = false;

    function show(k, announce) {
      at = k;
      root.classList.add('is-anim');
      items.forEach(function (el) { el.classList.toggle('is-off', +el.getAttribute('data-s') > k); });
      btns.forEach(function (b, i) { b.setAttribute('aria-pressed', i + 1 === k ? 'true' : 'false'); });
      if (announce && say) say.textContent = btns[k - 1].getAttribute('data-say');
    }
    function setPlay(v) {
      auto = v;
      play.setAttribute('aria-pressed', v ? 'true' : 'false');
      play.setAttribute('aria-label', v ? 'Pause the example' : 'Play the example');
      clearTimeout(timer);
      if (v && on) tick();
    }
    function tick() {
      clearTimeout(timer);
      if (!auto || !on) return;
      show(at >= n ? 1 : at + 1, false);
      timer = setTimeout(tick, at === n ? 3600 : 1700);
    }

    btns.forEach(function (b, i) {
      b.addEventListener('click', function () { setPlay(false); show(i + 1, true); });
    });
    ctl.addEventListener('keydown', function (e) {
      var i = btns.indexOf(document.activeElement);
      if (i < 0 || (e.key !== 'ArrowRight' && e.key !== 'ArrowLeft')) return;
      e.preventDefault();
      var j = (i + (e.key === 'ArrowRight' ? 1 : n - 1)) % n;
      btns[j].focus(); setPlay(false); show(j + 1, true);
    });
    play.addEventListener('click', function () { setPlay(!auto); });

    if (BDH.reduced) { setPlay(false); show(n, false); return; }
    show(n, false);
    BDH.watch(root, function (v) { on = v; if (v && auto) { at = 0; tick(); } else clearTimeout(timer); });
  });
})();
