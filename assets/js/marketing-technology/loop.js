/* Hub · loop — the six ring nodes are an ARIA tablist (BDH.tabs gives click, arrow keys, Home and End).
   Selecting a stage swaps the pane, updates the one-line trace under the ring, and pulses the node the
   packet is passing. The markup already has stage one selected and its pane on, so with JavaScript off
   the section reads as a finished diagram with one stage explained. Nothing loops under reduced motion. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.mth-loo');
  if (!root) return;

  var nodes = BDH.$$('.mth-loo__node', root);
  var panes = BDH.$$('.mth-loo__pane', root);
  var trace = BDH.$('.mth-loo__tx', root);
  if (!nodes.length || nodes.length !== panes.length) return;

  var api = BDH.tabs(root, {
    tabs: '.mth-loo__node',
    panes: '.mth-loo__pane',
    orientation: 'horizontal',
    onChange: function (i) {
      var key = panes[i].getAttribute('data-stage');
      root.setAttribute('data-stage', key);
      if (trace) {
        var txt = panes[i].getAttribute('data-trace') || '';
        if (BDH.reduced) trace.textContent = txt;
        else BDH.type(trace, txt, { speed: 9 });
      }
      nodes.forEach(function (n, j) { n.classList.toggle('mth-node--on', j === i); });
    }
  });

  if (BDH.reduced) return;

  /* the packet takes nine seconds for a lap (see loop.css): pulse each node as it goes past */
  var LAP = 9000;
  var pulses = [];
  function lap() {
    if (!root.classList.contains('is-live')) return;
    pulses.forEach(clearTimeout);
    pulses = [];
    nodes.forEach(function (n, j) {
      pulses.push(setTimeout(function () {
        n.classList.add('is-hit');
        pulses.push(setTimeout(function () { n.classList.remove('is-hit'); }, 620));
      }, (j / nodes.length) * LAP));
    });
  }
  BDH.loop(root, LAP, lap);
  BDH.watch(root, function (on) { if (on) lap(); });

  /* walk the loop slowly until the reader takes over */
  var steps = [];
  for (var s = 1; s <= nodes.length; s++) {
    (function (g) { steps.push([6000, function () { api.show(g % nodes.length, false); }]); })(s);
  }
  BDH.seq(root, steps, { loop: true, stopOnInteract: true });
})();
