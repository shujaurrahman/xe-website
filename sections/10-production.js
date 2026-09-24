/* 10 — the production strips. Without JS (and under reduced motion) they are static
   rows you can swipe. Otherwise this clones each strip once, adds .is-anim, and the
   drift plus the videos run only while the section is on screen and not paused.
   Videos keep preload="none" and their poster until then. */
(function () {
  'use strict';
  var sec = document.querySelector('.s10');
  if (!sec || !window.XE || XE.reduced) return;

  var rows = XE.$$('[data-s10-row]', sec);
  var btn = XE.$('[data-s10-pause]', sec);
  var SPEED = 26;                                   /* px per second */

  rows.forEach(function (row) {
    var track = XE.$('[data-s10-track]', row);
    XE.$$('.s10__c', track).forEach(function (c) {
      var k = c.cloneNode(true);
      k.setAttribute('aria-hidden', 'true');
      XE.$$('img', k).forEach(function (im) { im.loading = 'eager'; });   /* same files: served from cache */
      track.appendChild(k);
    });
  });
  sec.classList.add('is-anim');

  /* one set's width, measured after .is-anim drops the static padding */
  function measure() {
    rows.forEach(function (row) {
      var track = XE.$('[data-s10-track]', row);
      var half = track.scrollWidth / 2;
      track.style.setProperty('--s10-x', half + 'px');
      track.style.setProperty('--s10-dur', Math.round(half / SPEED) + 's');
    });
  }
  measure();
  var rt = null;
  XE.on(window, 'resize', function () { clearTimeout(rt); rt = setTimeout(measure, 150); });
  XE.$$('img', sec).forEach(function (im) { if (!im.complete) XE.on(im, 'load', measure, { once: true }); });

  var vids = XE.$$('[data-s10-v]', sec);
  var onScreen = false, paused = false;
  function sync() {
    var run = onScreen && !paused && !document.hidden;
    sec.classList.toggle('is-live', onScreen && !document.hidden);
    sec.classList.toggle('is-paused', paused);
    vids.forEach(function (v) {
      if (run) {
        if (v.preload !== 'auto') { v.preload = 'auto'; v.load(); }
        var pr = v.play();
        if (pr && pr.catch) pr.catch(function () {});
      } else if (!v.paused) { v.pause(); }
    });
  }

  if (btn) {
    btn.hidden = false;
    XE.on(btn, 'click', function () {
      paused = !paused;
      btn.setAttribute('aria-pressed', paused ? 'true' : 'false');
      sync();
    });
  }
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (es) { onScreen = es[es.length - 1].isIntersecting; sync(); },
      { threshold: 0.05 }).observe(sec);
  } else { onScreen = true; }
  document.addEventListener('visibilitychange', sync);
  sync();
})();
