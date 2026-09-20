/* Hub · sustainability — the SCI report recomputes on every change: region (radiogroup; arrows move and
   select) sets the grid intensity I, and each practice switch (aria-pressed) scales E, I or M. The waterfall
   re-lays each practice's reduction, the terms update, and the SCI figure counts to its new value.
   The arithmetic mirrors the PHP that rendered the finished state. Reduced motion: instant updates. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var ui = document.querySelector('.tih-sus__ui');
  if (!ui) return;

  var E0 = parseFloat(ui.getAttribute('data-e0')) || 0.55;
  var M0 = parseFloat(ui.getAttribute('data-m0')) || 0.075;
  var regions = BDH.$$('.tih-sus__rg', ui);
  var sws = BDH.$$('.tih-sus__sw .bdh-switch', ui);
  var rows = {};
  BDH.$$('.tih-sus__wf li', ui).forEach(function (li) { rows[li.getAttribute('data-row') || (li.classList.contains('is-base') ? 'base' : 'now')] = li; });
  var sciEl = BDH.$('.tih-sus__sci', ui);
  var cutEl = BDH.$('.tih-sus__cutv', ui);
  var k1El = BDH.$('.tih-sus__k1', ui);
  var term = { e: BDH.$('[data-sus="e"]', ui), i: BDH.$('[data-sus="i"]', ui), m: BDH.$('[data-sus="m"]', ui) };
  if (!regions.length || !sws.length) return;

  var MAX = Math.max.apply(null, regions.map(function (r) { return E0 / 1000 * (+r.getAttribute('data-i')) + M0; }));
  var intro = false;
  var shown = sciEl ? parseFloat(sciEl.textContent) : 0, anim = 0;

  function sci(e, i, m) { return e / 1000 * i + m; }
  function f2(v) { return v.toFixed(2); }

  function bar(li, from, width) {
    var i = li && li.querySelector('i');
    if (!i) return;
    i.style.setProperty('--l', (from / MAX * 100).toFixed(3) + '%');
    i.style.setProperty('--w', Math.max(0, width / MAX).toFixed(4));
  }

  function countTo(v) {
    if (!sciEl) return;
    cancelAnimationFrame(anim);
    if (BDH.reduced) { sciEl.textContent = f2(v); shown = v; return; }
    var from = shown, t0 = null;
    anim = requestAnimationFrame(function step(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / 600), k = 1 - Math.pow(1 - p, 3);
      shown = from + (v - from) * k;
      sciEl.textContent = f2(shown);
      if (p < 1) anim = requestAnimationFrame(step);
    });
  }

  function update() {
    var r = regions.filter(function (b) { return b.getAttribute('aria-checked') === 'true'; })[0] || regions[0];
    var e = E0, i = +r.getAttribute('data-i'), m = M0;
    var start = sci(e, i, m), run = start;
    bar(rows.base, 0, start);
    if (rows.base) rows.base.querySelector('.tih-sus__wv').textContent = f2(start);
    sws.forEach(function (s) {
      var key = s.getAttribute('data-p'), on = s.getAttribute('aria-pressed') === 'true';
      var fx = s.getAttribute('data-f').split(',').map(Number);
      var before = sci(e, i, m);
      if (on) { e *= fx[0]; i *= fx[1]; m *= fx[2]; }
      var d = before - sci(e, i, m);
      run -= d;
      var li = rows[key];
      if (li) {
        bar(li, run, d);
        li.classList.toggle('is-off', !on);
        li.querySelector('.tih-sus__wv').textContent = on ? '−' + f2(d) : 'off';
      }
    });
    var now = sci(e, i, m);
    bar(rows.now, 0, now);
    if (rows.now) rows.now.querySelector('.tih-sus__wv').textContent = f2(now);
    if (term.e) term.e.textContent = e.toFixed(2);
    if (term.i) term.i.textContent = Math.round(i).toString();
    if (term.m) term.m.textContent = m.toFixed(3);
    /* during the build-in the headline figure and the two summary lines hold their finished values: the
       panel animates the waterfall without ever asserting 0% below baseline */
    if (!intro) {
      if (cutEl) cutEl.textContent = Math.round((1 - now / start) * 100) + '% below baseline';
      if (k1El) k1El.textContent = Math.round(now * 1000).toLocaleString('en-GB') + ' g per 1,000 requests';
    }
    ui.setAttribute('data-region', r.getAttribute('data-r'));
    if (!intro) countTo(now);
  }

  function pick(n, focus) {
    regions.forEach(function (b, j) { b.setAttribute('aria-checked', j === n ? 'true' : 'false'); b.tabIndex = j === n ? 0 : -1; });
    if (focus) regions[n].focus();
    update();
  }
  regions.forEach(function (b, n) {
    b.addEventListener('click', function () { pick(n); });
    b.addEventListener('keydown', function (e) {
      var k = e.key, j = -1;
      if (k === 'ArrowDown' || k === 'ArrowRight') j = (n + 1) % regions.length;
      else if (k === 'ArrowUp' || k === 'ArrowLeft') j = (n - 1 + regions.length) % regions.length;
      else if (k === 'Home') j = 0;
      else if (k === 'End') j = regions.length - 1;
      if (j < 0) return;
      e.preventDefault(); pick(j, true);
    });
  });
  sws.forEach(function (s) {
    s.addEventListener('click', function () {
      s.setAttribute('aria-pressed', s.getAttribute('aria-pressed') === 'true' ? 'false' : 'true');
      update();
    });
  });

  /* on first entry, play the reductions in: start from the baseline and switch the practices on one by one.
     It runs for about 1.4 s, and only the waterfall moves — see update(). */
  if (BDH.reduced) return;
  var touched = false;
  BDH.onInteract(ui, function () { touched = true; intro = false; });
  BDH.inView(ui, function () {
    if (touched) return;
    intro = true;
    sws.forEach(function (s) { s.setAttribute('aria-pressed', 'false'); });
    update();
    sws.forEach(function (s, n) {
      setTimeout(function () {
        if (touched) return;
        s.setAttribute('aria-pressed', 'true');
        if (n === sws.length - 1) intro = false;
        update();
      }, 150 + n * 250);
    });
  }, { threshold: 0.35 });
})();
