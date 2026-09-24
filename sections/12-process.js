/* 12 — the three steps advance on a 6s dwell; clicking one pins it. */
(function () {
  'use strict';
  var panel = document.querySelector('[data-s12]');
  if (!panel || !window.XE) return;

  var steps = XE.$$('.s12__step', panel);
  var scenes = XE.$$('.s12__scene', panel);
  var i = 0, pinned = false, timer = null;

  function show(n) {
    i = ((n % steps.length) + steps.length) % steps.length;
    steps.forEach(function (s, k) {
      var on = k === i;
      s.classList.toggle('is-on', on);
      s.classList.remove('is-running');
      s.setAttribute('aria-selected', String(on));
      s.setAttribute('tabindex', on ? '0' : '-1');
    });
    scenes.forEach(function (s, k) { s.classList.toggle('is-on', k === i); });
    if (!pinned && !XE.reduced) {
      /* restart the dwell bar */
      void steps[i].offsetWidth;
      steps[i].classList.add('is-running');
    }
  }

  steps.forEach(function (s, k) {
    XE.on(s, 'click', function () { pinned = true; if (timer) timer.stop(); show(k); });
    XE.on(s, 'keydown', function (e) {
      var d = e.key === 'ArrowDown' || e.key === 'ArrowRight' ? 1
            : e.key === 'ArrowUp' || e.key === 'ArrowLeft' ? -1 : 0;
      if (!d) return;
      e.preventDefault();
      pinned = true; if (timer) timer.stop();
      show(k + d); steps[i].focus();
    });
  });

  show(0);
  if (!XE.reduced) {
    /* the ping only loops while the panel is on screen */
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (es) {
        panel.classList.toggle('is-live', es[0].isIntersecting);
      }, { threshold: 0 }).observe(panel);
    } else { panel.classList.add('is-live'); }
    timer = XE.liveTimer(panel, 6000, function () { if (!pinned) show(i + 1); });
    XE.on(panel, 'mouseenter', function () { if (timer) timer.stop(); });
    XE.on(panel, 'mouseleave', function () { if (!pinned && timer) timer.start(); });
  }
})();
