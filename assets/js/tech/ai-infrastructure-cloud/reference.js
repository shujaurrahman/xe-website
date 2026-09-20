/* AI Infrastructure & Cloud · reference — runs the diagram only while it is on screen: SMIL packets
   (request in, streamed tokens out) pause off screen; the router cycles its active route (provider A,
   self-hosted for restricted data, fallback when provider A returns 429) and the canary share steps.
   Reduced motion: packets are hidden, the diagram stays on the provider A route. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tic-ref');
  if (!root) return;
  var svg = root.querySelector('.tic-ref__svg');
  if (!svg) return;

  function smil(on) {
    try { if (on) svg.unpauseAnimations(); else svg.pauseAnimations(); } catch (e) { /* no SMIL */ }
  }
  smil(false);
  if (BDH.reduced) return;

  var label = root.querySelector('[data-ref-label]');
  var ro = svg.querySelector('[data-ref-route]');
  var can = svg.querySelector('[data-ref-canary]');
  var fill = svg.querySelector('.tic-ref__fill');
  var ROUTES = [
    ['a',  'route → provider A · general query',                   'provider A · 82% of calls'],
    ['s',  'route → self-hosted · restricted data stays in India',  'self-hosted · residency'],
    ['fb', 'provider A returns 429 → breaker open → self-hosted',   'fallback · breaker open']
  ];
  var CANARY = [5, 25, 50, 100];
  var r = 0, c = 1;

  BDH.live(root, 0.15, smil);
  BDH.loop(root, 3400, function () {
    r = (r + 1) % ROUTES.length;
    svg.setAttribute('data-route', ROUTES[r][0]);
    if (label) label.textContent = ROUTES[r][1];
    if (ro) ro.textContent = ROUTES[r][2];
    if (r === 0) {
      c = (c + 1) % CANARY.length;
      if (can) can.textContent = CANARY[c] + '%';
      if (fill) fill.style.setProperty('--c', String(CANARY[c] / 100));
    }
  });
})();
