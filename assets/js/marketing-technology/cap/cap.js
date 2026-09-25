/* Marketing Technology capability pages (prefix mtd).
   1. Stepper: every stage is shown in the shipped HTML; here the rail becomes an ARIA tablist (.is-tabs).
   2. Signature mocks: the shipped HTML is the finished (last) state. Buttons switch data-state and swap the
      data-t* text, data-c* chip variants and data-v* bar values. While on screen, and until someone touches it,
      the mock replays its states in order; with reduced motion it stays on the finished state. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var steps = document.querySelector('[data-mtd-steps]');
  if (steps) {
    var tabs = steps.querySelectorAll('.mth-steps__tab');
    steps.classList.add('is-tabs');
    var done = function (i) { tabs.forEach(function (t, n) { t.classList.toggle('is-done', n < i); }); };
    BDH.tabs(steps, { panes: '.mth-steps__pane', onChange: function (i) { done(i); } });
    done(0);
  }

  /* Customer Relationship Strategy practice switcher: every practice is shown in the shipped HTML; here the rail
     becomes a vertical ARIA tablist (.is-tabs) and only the chosen practice stays in flow. */
  var prac = document.querySelector('[data-mtd-prac]');
  if (prac) {
    prac.classList.add('is-tabs');
    BDH.tabs(prac, { panes: '.mtd-prac__pane', orientation: 'vertical' });
  }

  document.querySelectorAll('[data-mtd-sig]').forEach(function (sig) {
    var btns = sig.querySelectorAll('[data-mtd-set]');
    var n = btns.length;
    if (!n) return;
    var cur = n;

    function set(s) {
      cur = s;
      sig.setAttribute('data-state', String(s));
      btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-mtd-set') === String(s) ? 'true' : 'false'); });
      sig.querySelectorAll('[data-t' + s + ']').forEach(function (el) { el.textContent = el.getAttribute('data-t' + s); });
      sig.querySelectorAll('[data-c' + s + ']').forEach(function (el) {
        el.className = el.className.replace(/\bmth-chip--\w+/g, '').trim() + ' mth-chip--' + el.getAttribute('data-c' + s);
      });
      sig.querySelectorAll('[data-v' + s + ']').forEach(function (el) { el.style.setProperty('--v', el.getAttribute('data-v' + s)); });
    }

    var player = null;
    function stop() { if (player) { player.stop(); player = null; } }

    btns.forEach(function (b, i) {
      b.addEventListener('click', function () { stop(); set(+b.getAttribute('data-mtd-set')); });
      b.addEventListener('keydown', function (e) {
        var k = e.key, j = -1;
        if (k === 'ArrowRight' || k === 'ArrowDown') j = (i + 1) % n;
        else if (k === 'ArrowLeft' || k === 'ArrowUp') j = (i - 1 + n) % n;
        else if (k === 'Home') j = 0;
        else if (k === 'End') j = n - 1;
        if (j < 0) return;
        e.preventDefault(); stop(); btns[j].focus(); set(j + 1);
      });
    });

    if (BDH.reduced) return;
    /* replay from the first state while visible; stop for good on any interaction */
    set(1);
    player = BDH.loop(sig, 2600, function () { set(cur >= n ? 1 : cur + 1); });
    sig.addEventListener('pointerdown', stop, { once: true });
    sig.addEventListener('focusin', stop, { once: true });
  });
})();
