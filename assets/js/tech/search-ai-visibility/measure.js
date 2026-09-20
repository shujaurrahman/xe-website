/* Search & AI Visibility — 08 · Measure.
   The dashboard is complete in HTML: both lines are drawn, the bars are at full width, the latest
   week is marked and the readout already names it. This file only animates that state.
     1. .is-anim is added when motion is allowed, which arms the line draw and the bar growth;
        .is-live (BDH.live) then plays them once the window is on screen.
     2. A loop walks the last six weekly datapoints, appending one a second, and updates the
        readout beneath the chart. It runs only while the section is visible and stops for good on
        the first interaction, leaving the latest week marked.
     3. "Highlight sampled" is a real toggle button: it rings every sampled panel and dims the
        measured ones, so a reader can see how much of a visibility report is an estimate.
   Without JavaScript, or under prefers-reduced-motion, the section reads exactly the same. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-tsv-dash]');
  if (!root) return;

  /* ---- 3. the highlight-sampled toggle (works under reduced motion too) ---- */
  var hl = root.querySelector('[data-dash-hl]');
  if (hl) {
    hl.addEventListener('click', function () {
      var on = hl.getAttribute('aria-pressed') !== 'true';
      hl.setAttribute('aria-pressed', on ? 'true' : 'false');
      root.classList.toggle('is-hl', on);
    });
  }

  if (BDH.reduced) return;

  /* ---- 2. walk the last six weeks ---- */
  var pts = BDH.$$('.tsv-dash__pt', root);
  var ro  = {
    w: root.querySelector('[data-ro-w]'),
    c: root.querySelector('[data-ro-c]'),
    i: root.querySelector('[data-ro-i]'),
    d: root.querySelector('[data-ro-d]')
  };
  if (!pts.length || !ro.w) return;

  var last = pts.length - 1;
  var at   = last;

  function show(n) {
    var pt = pts[n];
    if (!pt) return;
    pts.forEach(function (p) { p.classList.toggle('is-at', p === pt); });
    ro.w.textContent = pt.getAttribute('data-w') || '';
    if (ro.c) ro.c.textContent = pt.getAttribute('data-c') || '';
    if (ro.i) ro.i.textContent = pt.getAttribute('data-i') || '';
    if (ro.d) ro.d.textContent = pt.getAttribute('data-d') || '';
  }

  var walk = null;
  var stopped = false;

  BDH.onInteract(root, function () {
    stopped = true;
    if (walk && walk.stop) walk.stop();
    show(last);
  });

  /* ---- 1. arm the entry motion, then hand over to the walk ---- */
  root.classList.add('is-anim');

  var armed = false;
  BDH.live(root, 0.15, function (on) {
    if (!on || armed) return;
    armed = true;
    window.setTimeout(function () {
      root.classList.remove('is-anim');   /* the intro has played; the CSS base state is the same */
      if (stopped) return;
      walk = BDH.loop(root, 1100, function () {
        at = at >= last ? 0 : at + 1;
        show(at);
      });
    }, 2100);
  });
})();
