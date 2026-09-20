/* Hub · pace — (1) the changelog: release markers are toggle buttons (one pressed; arrows move) that swap the
   side card; scrolling scrubs a playhead across the twelve months, drawing the eval line and revealing
   releases, and until the reader picks one the card follows the latest adopted release the playhead has
   passed. (2) the release train pops in on entry (CSS). (3) idea to agent: a cursor steps through the five
   milestones while on screen and the T+ clock follows it.
   Reduced motion: complete chart, all milestones done; selection still works. */
(function () {
  'use strict';
  if (!window.BDH) return;

  /* ---------- 1 · changelog ---------- */
  var pc = document.querySelector('.tih-pc');
  if (pc) {
    var mks = BDH.$$('.tih-pc__mk', pc);
    var cps = BDH.$$('.tih-pc__cp', pc);
    var evs = BDH.$$('.tih-pc__ev', pc);
    var bars = BDH.$$('.tih-pc__bars i', pc);
    var clip = BDH.$('.tih-pc__clip', pc);
    var head = BDH.$('.tih-pc__head', pc);
    var plot = BDH.$('.tih-pc__plot', pc);
    var XS = mks.map(function (m) { return parseFloat(m.style.getPropertyValue('--x')) * 10; });   // back to chart units
    var BX = bars.map(function (b) { return parseFloat(b.style.getPropertyValue('--x')) * 10; });
    var sel = parseInt(pc.getAttribute('data-sel'), 10) || 0, chosen = false;

    function select(i, focus) {
      if (i < 0 || i >= mks.length) return;
      sel = i;
      mks.forEach(function (m, n) { m.setAttribute('aria-pressed', n === i ? 'true' : 'false'); m.tabIndex = n === i ? 0 : -1; });
      cps.forEach(function (c, n) { c.classList.toggle('is-on', n === i); });
      evs.forEach(function (l, n) { l.classList.toggle('is-sel', n === i); });
      if (focus) mks[i].focus();
    }
    mks.forEach(function (m, i) {
      m.addEventListener('click', function () { chosen = true; select(i); });
      m.addEventListener('keydown', function (e) {
        var j = e.key === 'ArrowRight' ? i + 1 : e.key === 'ArrowLeft' ? i - 1 : e.key === 'Home' ? 0 : e.key === 'End' ? mks.length - 1 : -1;
        if (j < 0 || j >= mks.length) return;
        e.preventDefault(); chosen = true; select(j, true);
      });
    });
    select(sel);

    if (!BDH.reduced && clip && head && plot) {
      var X0 = 40, X1 = 960, last = -1;
      BDH.progress(plot, function (p) {
        var t = Math.max(0, Math.min(1, (p - 0.08) / 0.34));
        var x = X0 + t * (X1 - X0);
        if (Math.abs(x - last) < 0.5) return;
        last = x;
        clip.setAttribute('transform', 'translate(' + X0 + ' 0) scale(' + (Math.max(0.0001, (x - X0) / (1000 - X0))).toFixed(4) + ' 1) translate(' + (-X0) + ' 0)');
        head.setAttribute('x1', x.toFixed(1)); head.setAttribute('x2', x.toFixed(1));
        pc.classList.toggle('is-scrub', t < 1);
        var latest = -1;
        mks.forEach(function (m, n) {
          var ahead = XS[n] > x + 1;
          m.classList.toggle('is-ahead', ahead);
          /* a marker the scroll has not reached yet is invisible, so it is not operable either */
          if (m.tagName === 'BUTTON' || m.hasAttribute('tabindex')) m.tabIndex = ahead ? -1 : 0;
          m.setAttribute('aria-hidden', ahead ? 'true' : 'false');
          m.style.pointerEvents = ahead ? 'none' : '';
          evs[n] && (evs[n].style.opacity = ahead ? '0' : '');
          if (!ahead && m.classList.contains('is-yes')) latest = n;
        });
        bars.forEach(function (b, n) { b.style.transform = BX[n] > x + 1 ? 'scaleY(0)' : ''; });
        if (!chosen && latest > -1 && latest !== sel) select(latest);
      });
    }
  }

  /* ---------- 3 · idea to agent ---------- */
  var i2a = document.querySelector('.tih-pc__i2a');
  if (i2a && !BDH.reduced) {
    var ms = BDH.$$('.tih-pc__ms li', i2a);
    var tEl = BDH.$('.tih-pc__t', i2a);
    var WHEN = ms.map(function (m) { var w = m.querySelector('.tih-pc__mw'); return w ? w.textContent : ''; });
    var k = -1, HOLD = 3;
    function paint(at) {
      ms.forEach(function (m, n) {
        m.classList.toggle('is-done', n < at || (at >= ms.length - 1 && n <= at));
        m.classList.toggle('is-here', n === at && at < ms.length - 1);
      });
      if (tEl) tEl.textContent = WHEN[Math.max(0, Math.min(at, ms.length - 1))];
    }
    BDH.inView(i2a, function () {
      paint(0); k = 0;
      BDH.loop(i2a, 1500, function () {
        k++;
        if (k >= ms.length + HOLD) k = 0;
        paint(Math.min(k, ms.length - 1));
      });
    }, { threshold: 0.3 });
  }
})();
