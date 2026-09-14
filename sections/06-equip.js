/* 06 — the rail loops for ever; the arrows nudge it and hovering holds it. */
(function () {
  'use strict';
  var sec = document.querySelector('.s06');
  if (!sec || !window.XE) return;
  var track = XE.$('[data-s06-track]', sec);
  if (!track) return;

  /* core's marquee has already cloned the cards for a seamless -50% loop */
  var paused = false, nudge = 0;
  function hold(on) {
    paused = on;
    track.style.animationPlayState = on ? 'paused' : 'running';
    track.classList.toggle('is-held', on);
  }
  /* the loop only holds while the pointer is on a card — not the whole section */
  XE.$$('.s06__card', track).forEach(function (card) {
    XE.on(card, 'mouseenter', function () { hold(true); });
    XE.on(card, 'mouseleave', function () { hold(false); });
    XE.on(card, 'focusin', function () { hold(true); });
    XE.on(card, 'focusout', function () { hold(false); });
  });

  function step(dir) {
    nudge += dir * 344;                       /* one card + gap */
    track.style.transform = 'translate3d(' + (-nudge % (track.scrollWidth / 2)) + 'px,0,0)';
    hold(true);
    clearTimeout(step.t);
    step.t = setTimeout(function () { track.style.transform = ''; hold(false); nudge = 0; }, 2600);
  }
  XE.on(XE.$('[data-s06-prev]', sec), 'click', function () { step(-1); });
  XE.on(XE.$('[data-s06-next]', sec), 'click', function () { step(1); });
})();
