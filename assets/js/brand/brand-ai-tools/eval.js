/* 06 Evaluation — pick a model version; every small multiple, readout and verdict follows.
   Cycles through versions while on screen until the first interaction. Arrow keys move between versions. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var ui = document.querySelector('.cat-ev__ui'); if (!ui) return;
  var btns = BDH.$$('.cat-ev__ver', ui);
  var cur = parseInt(ui.getAttribute('data-ev-sel'), 10) || 0;

  function sel(i, focus) {
    i = ((i % btns.length) + btns.length) % btns.length; cur = i;
    ui.setAttribute('data-ev-sel', i);
    btns.forEach(function (b, n) { b.setAttribute('aria-pressed', n === i ? 'true' : 'false'); });
    BDH.$$('[data-ev-vd]', ui).forEach(function (d) { d.hidden = d.getAttribute('data-ev-vd') !== String(i); });
    BDH.$$('[data-ev-r]', ui).forEach(function (r) { r.hidden = r.getAttribute('data-ev-r') !== String(i); });
    if (focus) btns[i].focus();
  }

  btns.forEach(function (b, n) {
    b.addEventListener('click', function () { sel(n); });
    b.addEventListener('keydown', function (e) {
      var k = e.key, j = -1;
      if (k === 'ArrowRight' || k === 'ArrowDown') j = n + 1;
      else if (k === 'ArrowLeft' || k === 'ArrowUp') j = n - 1;
      else if (k === 'Home') j = 0;
      else if (k === 'End') j = btns.length - 1;
      if (j < 0) return;
      e.preventDefault(); sel(j, true);
    });
  });

  BDH.enter(ui);
  if (BDH.reduced || !window.matchMedia('(min-width: 1101px)').matches) return;   // stacked: verdict height varies, no autoplay
  var timer = BDH.loop(ui, 3400, function () { sel(cur + 1); });
  BDH.onInteract(ui, function () { timer.stop(); });
})();
