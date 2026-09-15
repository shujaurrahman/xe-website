/* 07 Provenance inspector — select an event to read who / what / when; the asset shows what that
   event touched. Steps through the record while on screen until the first interaction. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var ui = document.querySelector('.cat-pv__ui'); if (!ui) return;
  var evs = BDH.$$('.cat-pv__ev', ui), ds = BDH.$$('[data-pv-d]', ui);
  var cur = Math.max(0, evs.findIndex(function (b) { return b.getAttribute('aria-pressed') === 'true'; }));

  function sel(i, focus) {
    i = ((i % evs.length) + evs.length) % evs.length; cur = i;
    evs.forEach(function (b, n) { b.setAttribute('aria-pressed', n === i ? 'true' : 'false'); });
    ds.forEach(function (d, n) { d.hidden = n !== i; if (n === i) ui.setAttribute('data-pv-hl', d.getAttribute('data-hl')); });
    if (focus) evs[i].focus();
  }

  evs.forEach(function (b, n) {
    b.addEventListener('click', function () { sel(n); });
    b.addEventListener('keydown', function (e) {
      var k = e.key, j = -1;
      if (k === 'ArrowDown' || k === 'ArrowRight') j = n + 1;
      else if (k === 'ArrowUp' || k === 'ArrowLeft') j = n - 1;
      else if (k === 'Home') j = 0;
      else if (k === 'End') j = evs.length - 1;
      if (j < 0) return;
      e.preventDefault(); sel(j, true);
    });
  });

  if (BDH.reduced || !window.matchMedia('(min-width: 1101px)').matches) return;   // detail height varies; autoplay only side by side
  var started = false, timer = null;
  BDH.inView(ui, function () {
    if (started) return; started = true;
    sel(0);
    timer = BDH.loop(ui, 2600, function () { sel(cur + 1); });
  }, { threshold: 0.3 });
  BDH.onInteract(ui, function () { if (timer) timer.stop(); started = true; });
})();
