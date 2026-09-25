/* 01 — the floating work drifts with the pointer; everything fades in once. */
(function () {
  'use strict';
  var sec = document.querySelector('.s01');
  if (!sec || !window.XE) return;

  /* reveal + start the ambient loops */
  if (!XE.reduced) sec.classList.add('is-anim');   /* floats start hidden only when JS runs */
  requestAnimationFrame(function () { requestAnimationFrame(function () { sec.classList.add('is-in'); }); });
  if (!XE.reduced) {
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (es) {
        sec.classList.toggle('is-live', es[0].isIntersecting && !document.hidden);
      }, { threshold: 0 }).observe(sec);
    } else { sec.classList.add('is-live'); }
  }

  /* light one word of the stack at a time */
  var wrap = XE.$('[data-s01-words]', sec);
  if (wrap && !XE.reduced) {
    var words = XE.$$('span', wrap), wi = 0;
    XE.liveTimer(sec, 1500, function () {
      words[wi].classList.remove('is-on');
      wi = (wi + 1) % words.length;
      words[wi].classList.add('is-on');
    });
  }

  var floats = XE.$$('.s01__f', sec);
  if (!floats.length || XE.reduced) return;
  if (!window.matchMedia('(pointer:fine)').matches) return;

  var tx = 0, ty = 0, cx = 0, cy = 0, raf = null;
  XE.on(window, 'mousemove', function (e) {
    if (sec.getBoundingClientRect().bottom < 0) return;
    tx = (e.clientX / window.innerWidth - .5) * 2;
    ty = (e.clientY / window.innerHeight - .5) * 2;
    if (!raf) raf = requestAnimationFrame(loop);
  }, { passive: true });

  function loop() {
    cx += (tx - cx) * .055;
    cy += (ty - cy) * .055;
    floats.forEach(function (f, i) {
      var d = 9 + (i % 4) * 6;
      f.style.setProperty('--px', (cx * d).toFixed(2) + 'px');
      f.style.setProperty('--py', (cy * d).toFixed(2) + 'px');
    });
    raf = (Math.abs(tx - cx) > .002 || Math.abs(ty - cy) > .002) ? requestAnimationFrame(loop) : null;
  }
})();
