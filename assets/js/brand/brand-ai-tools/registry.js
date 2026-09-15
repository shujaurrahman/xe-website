/* 10 Artefact registry bay — highlight modules by kind; Pull copies the command and runs a short
   pull readout; the output-log module ticks its event count while on screen. */
(function () {
  'use strict';
  var root = document.querySelector('.cat-rg'); if (!root) return;
  var R = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var chips = Array.prototype.slice.call(root.querySelectorAll('[data-rg-f]'));
  var mods = Array.prototype.slice.call(root.querySelectorAll('.cat-rg__mod'));
  var n = root.querySelector('[data-rg-n]');

  chips.forEach(function (c) {
    c.addEventListener('click', function () {
      var f = c.getAttribute('data-rg-f'), shown = 0;
      chips.forEach(function (x) { x.setAttribute('aria-pressed', x === c ? 'true' : 'false'); });
      mods.forEach(function (m) {
        var on = f === 'all' || (' ' + m.getAttribute('data-kind') + ' ').indexOf(' ' + f + ' ') > -1;
        m.classList.toggle('is-dim', !on);
        if (on) shown++;
      });
      n.textContent = shown;
    });
  });

  Array.prototype.forEach.call(root.querySelectorAll('[data-rg-copy]'), function (b) {
    var mod = b.closest('.cat-rg__mod'), lbl = b.querySelector('[data-rg-lbl]'), busy = false;
    b.addEventListener('click', function () {
      if (busy) return; busy = true;
      var txt = b.getAttribute('data-rg-copy');
      try { if (navigator.clipboard && navigator.clipboard.writeText) navigator.clipboard.writeText(txt).catch(function () {}); } catch (e) {}
      var finish = function () {
        lbl.textContent = 'Copied'; b.classList.add('is-done');
        setTimeout(function () { lbl.textContent = 'Pull'; b.classList.remove('is-done'); mod.classList.remove('is-pulling'); busy = false; }, 1800);
      };
      if (R) { finish(); return; }
      lbl.textContent = 'Pulling'; mod.classList.remove('is-pulling'); void mod.offsetWidth; mod.classList.add('is-pulling');
      setTimeout(finish, 1150);
    });
  });

  var tick = root.querySelector('[data-rg-tick]');
  if (tick && !R && window.BDH && BDH.loop) {
    var count = parseInt(tick.textContent.replace(/\D/g, ''), 10) || 0, f = 0;
    BDH.loop(tick, 30, function () {
      if (++f % 12) return;
      count += 1 + Math.floor(Math.random() * 4);
      tick.textContent = count.toLocaleString('en-GB');
    });
  }
})();
