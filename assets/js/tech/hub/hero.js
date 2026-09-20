/* Hub · hero — the control plane runs. Edges draw in layer by layer (CSS, .bdh-draw on .is-in), then
   packets travel along the edges in the order a request would, the node they arrive at pulses, and the
   status bar ticks. Everything loops only while the panel is on screen and the tab is visible.
   Reduced motion: the markup's finished diagram stays exactly as it is. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tih-hero');
  var panel = root && root.querySelector('.tih-hero__panel');
  if (!panel || BDH.reduced) return;

  var edges = BDH.$$('.tih-hero__edge', panel);
  var pks = BDH.$$('.tih-hero__pk', panel);
  var nodes = {};
  BDH.$$('.tih-hero__node', panel).forEach(function (n) { nodes[n.getAttribute('data-slug')] = n; });
  if (!pks.length || !pks[0].animate) return;

  /* a request's path through the platform: search → web → assistant → gateway → bus → data, then guardrails and audit */
  var ORDER = [0, 1, 3, 4, 5, 6, 7, 2, 8];
  var k = 0;

  function hit(slug) {
    var n = nodes[slug];
    if (!n) return;
    n.classList.remove('is-hit');
    void n.offsetWidth;
    n.classList.add('is-hit');
    setTimeout(function () { n.classList.remove('is-hit'); }, 900);
  }

  function fire(i) {
    var pk = pks[i], edge = edges[i];
    if (!pk) return;
    if (edge) edge.classList.add('is-hot');
    var a = pk.animate([
      { strokeDashoffset: 0, opacity: 0 },
      { opacity: 1, offset: 0.12 },
      { opacity: 1, offset: 0.88 },
      { strokeDashoffset: -0.999, opacity: 0 }
    ], { duration: 1500, easing: 'cubic-bezier(.65,0,.35,1)' });
    a.onfinish = function () {
      if (edge) edge.classList.remove('is-hot');
      hit(pk.getAttribute('data-to'));
    };
  }

  /* start once the edges have drawn in */
  var started = false;
  BDH.inView(panel, function () {
    setTimeout(function () {
      if (started) return;
      started = true;
      BDH.loop(panel, 620, function () { fire(ORDER[k % ORDER.length]); k++; });
    }, 1500);
  }, { threshold: 0.2 });

  /* ---- event feed: the control plane reports one event at a time, typed ---- */
  var feed = BDH.$('.tih-hero__feed', panel);
  if (feed) {
    var EV = [];
    try { EV = JSON.parse(feed.getAttribute('data-feed') || '[]'); } catch (err) { EV = []; }
    var fT = BDH.$('.tih-hero__ft', feed), fS = BDH.$('.tih-hero__fs', feed), fX = BDH.$('.tih-hero__fxt', feed);
    var fi = 0, typer = null;
    if (EV.length > 1 && fX) {
      BDH.loop(feed, 3000, function () {
        fi = (fi + 1) % EV.length;
        var ev = EV[fi];
        if (typer) typer.finish();
        if (fT) fT.textContent = ev[0];
        if (fS) fS.textContent = ev[1];
        typer = BDH.type(fX, ev[2], { speed: 18 });
      });
    }
  }

  /* ---- status bar: illustrative readouts drift, evals re-run after a deploy, the budget burns slowly ---- */
  var el = {};
  BDH.$$('.tih-hero__status b', panel).forEach(function (b) { el[b.getAttribute('data-k')] = b; });
  var p95 = 212, budget = 71, tick = 0, run = -1;
  function set(key, text) {
    var b = el[key];
    if (!b || b.textContent === text) return;
    b.classList.add('is-tick');
    setTimeout(function () { b.textContent = text; b.classList.remove('is-tick'); }, 180);
  }
  /* the drift stays within ±3 ms of 212 and ±0.005 of 0.18 — the platform trace, the shift overlay and the
     measures card all state those two figures, and a live readout must not contradict them */
  BDH.loop(panel, 1600, function () {
    tick++;
    p95 = Math.max(209, Math.min(215, p95 + Math.round((Math.random() - 0.5) * 5)));
    set('p95', String(p95));
    /* carbon per request does not move minute to minute, and 0.18 is stated in three other places: it holds */
    if (tick % 9 === 0) { budget = budget <= 66 ? 71 : budget - 1; set('budget', budget + '%'); }
    if (tick % 7 === 0) run = 0;
    if (run > -1) {
      run++;
      set('evals', run >= 4 ? '148/148' : (37 * run) + '/148');
      if (run >= 4) run = -1;
    }
  });
})();
