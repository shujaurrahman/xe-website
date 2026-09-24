/* 23 — Brand Design, in depth. Turns the stacked capability panes into a tabbed viewer:
   selector shown, inactive panes [hidden] (only one in flow), ARIA tabs + arrow keys via
   BDH.tabs. While on screen, and until the visitor touches it, it steps through the six
   with a progress line on the current tab. Each pane's artefact builds in when shown.
   Reduced motion: tabs work, no auto-advance, no build-in, no loops.
   hub.js (window.BDH) loads after sections.js, so init waits for DOMContentLoaded. */
(function () {
  'use strict';

  function init() {
    var root = document.querySelector('.s23');
    var BDH = window.BDH;
    if (!root || !BDH) return;
    var app = root.querySelector('[data-s23]');
    var tabs = BDH.$$('.s23__tab', root);
    var panes = BDH.$$('.s23__pane', root);
    if (!app || !tabs.length || tabs.length !== panes.length) return;

    var R = BDH.reduced, DUR = 7000, TICK = 100, elapsed = 0, auto = false;

    /* deep link: #s23-<slug> opens that capability */
    var start = 0;
    panes.forEach(function (p, i) { if (location.hash && location.hash === '#' + p.id) start = i; });

    panes.forEach(function (p, i) {
      p.setAttribute('role', 'tabpanel');
      p.setAttribute('aria-labelledby', tabs[i].id);
      p.setAttribute('tabindex', '0');
      p.hidden = i !== start;
    });
    root.classList.add('is-ready');
    if (!R) root.classList.add('is-anim');

    var seen = false;
    function run(p) {
      if (R || !seen) return;
      p.classList.remove('is-run');
      void p.offsetWidth;                // restart the build-in
      p.classList.add('is-run');
    }
    function paint() {
      if (!auto) return;
      var cur = api ? api.index() : start;
      tabs.forEach(function (t, i) { t.style.setProperty('--p', i === cur ? String(Math.min(1, elapsed / DUR)) : '0'); });
    }

    var api = null;
    api = BDH.tabs(app, {
      tabs: tabs, panes: panes, initial: start,
      onChange: function (i) { elapsed = 0; paint(); run(panes[i]); }
    });

    BDH.inView(app, function () { seen = true; run(panes[api.index()]); });
    BDH.live(root, 0.15);

    if (R) return;                        // progress lines stay full (--p unset → 1)
    auto = true;
    root.classList.add('is-auto');
    paint();
    var timer = BDH.loop(app, TICK, function () {
      elapsed += TICK;
      if (elapsed >= DUR) api.show(api.index() + 1, false);
      else paint();
    });
    BDH.onInteract(app, function () {
      auto = false;
      timer.stop();
      root.classList.remove('is-auto');
      tabs.forEach(function (t) { t.style.removeProperty('--p'); });
    });
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
