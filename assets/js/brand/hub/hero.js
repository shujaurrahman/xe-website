/* Hub · hero — the brand check ticks through its rules, the variant card regenerates per market,
   and the floating cards follow the pointer a little. The HTML is the finished state, so reduced
   motion simply leaves it as it is. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.bdh-hero');
  if (!root || BDH.reduced) return;

  /* ---- brand check: reset → rules pass one by one → hold → repeat ---- */
  var rows = BDH.$$('.bdh-hero__check li', root);
  var run = BDH.$('.bdh-hero__run', root);
  var foot = BDH.$('.bdh-hero__cf', root);
  var total = rows.length, step = 0;
  if (rows.length && run && foot) {
    BDH.loop(root, 720, function () {
      if (step === 0) {
        rows.forEach(function (r, i) { r.className = i === 0 ? 'is-run' : 'is-wait'; });
        run.textContent = 'Agent · running';
        foot.textContent = 'Checking ' + total + ' rules…';
      } else if (step <= total) {
        rows[step - 1].className = 'is-ok';
        if (rows[step]) rows[step].className = 'is-run';
        if (step === total) {
          run.textContent = 'Agent · live';
          foot.textContent = total + ' of ' + total + ' pass · approved by Brand reviewer';
        }
      }
      step = (step + 1) % (total + 5);
    });
  }

  /* ---- variant: regenerate for the next market ---- */
  var variant = BDH.$('.bdh-hero__variant', root);
  var market = BDH.$('.bdh-hero__vlbl b', root);
  var m = 3;
  if (variant && market) {
    BDH.loop(variant, 3200, function () {
      m = m % 3 + 1;
      market.textContent = '0' + m;
      variant.classList.remove('is-gen');
      void variant.offsetWidth;
      variant.classList.add('is-gen');
    });
  }

  /* ---- pointer parallax on the floating layers (desktop only, ≤ 8px) ---- */
  var vis = BDH.$('.bdh-hero__vis', root);
  var layers = [[BDH.$('.bdh-hero__check', root), 5], [variant, 8], [BDH.$('.bdh-hero__tokens', root), 3]];
  if (vis && window.matchMedia('(pointer: fine)').matches && 'translate' in document.documentElement.style) {
    var raf = 0, px = 0, py = 0;
    function paint() {
      raf = 0;
      layers.forEach(function (l) { if (l[0]) l[0].style.translate = (px * l[1]).toFixed(1) + 'px ' + (py * l[1]).toFixed(1) + 'px'; });
    }
    root.addEventListener('pointermove', function (e) {
      if (window.innerWidth < 1024) return;
      var r = vis.getBoundingClientRect();
      px = Math.max(-1, Math.min(1, (e.clientX - (r.left + r.width / 2)) / (r.width / 2)));
      py = Math.max(-1, Math.min(1, (e.clientY - (r.top + r.height / 2)) / (r.height / 2)));
      if (!raf) raf = requestAnimationFrame(paint);
    }, { passive: true });
    root.addEventListener('pointerleave', function () { px = 0; py = 0; if (!raf) raf = requestAnimationFrame(paint); });
  }
})();
