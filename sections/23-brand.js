/* 23 — Brand Design, in depth. Upgrades the #s23-<slug> link row into ARIA tabs (BDH.tabs:
   arrows, Home/End), keeps one pane in flow ([hidden] on the rest), reserves the tallest pane's
   height so switching never moves the page, and builds an artefact in only when the visitor
   changes tab. No auto-advance. A #s23-<slug> hash (on load or hashchange) opens that tab and
   scrolls to the selector. Reduced motion: everything works, nothing animates.
   hub.js (window.BDH) loads after sections.js, so init waits for DOMContentLoaded. */
(function () {
  'use strict';

  function init() {
    var root = document.querySelector('.s23');
    var BDH = window.BDH;
    if (!root || !BDH) return;
    var app = root.querySelector('[data-s23]');
    var list = root.querySelector('.s23__tabs');
    var wrap = root.querySelector('.s23__panes');
    var tabs = BDH.$$('.s23__tab', root);
    var panes = BDH.$$('.s23__pane', root);
    if (!app || !list || !wrap || !tabs.length || tabs.length !== panes.length) return;
    var R = BDH.reduced;

    function fromHash() {
      var h = location.hash;
      for (var i = 0; i < panes.length; i++) { if (h === '#' + panes[i].id) return i; }
      return -1;
    }
    var start = Math.max(0, fromHash());

    /* links → tabs */
    list.setAttribute('role', 'tablist');
    tabs.forEach(function (t, i) {
      t.setAttribute('role', 'tab');
      t.setAttribute('aria-controls', panes[i].id);
      t.addEventListener('click', function (e) { e.preventDefault(); });
      t.addEventListener('keydown', function (e) { if (e.key === ' ') { e.preventDefault(); t.click(); } });
    });
    panes.forEach(function (p, i) {
      p.setAttribute('role', 'tabpanel');
      p.setAttribute('aria-labelledby', tabs[i].id);
      p.setAttribute('tabindex', '0');
      p.hidden = i !== start;
    });
    root.classList.add('is-ready');
    if (!R) root.classList.add('is-anim');
    panes[start].classList.add('is-run');          // the first view is the finished state

    function run(p) {
      if (R) { p.classList.add('is-run'); return; }
      p.classList.remove('is-run');
      void p.offsetWidth;                          // restart the build-in
      p.classList.add('is-run');
    }

    var api = BDH.tabs(app, {
      tabs: tabs, panes: panes, initial: start,
      onChange: function (i) { run(panes[i]); }
    });

    /* reserve the tallest pane, so a tab change never moves what follows */
    function reserve() {
      wrap.style.removeProperty('--s23-h');
      var max = 0;
      panes.forEach(function (p) {
        var was = p.hidden;
        p.hidden = false;
        max = Math.max(max, p.offsetHeight);
        p.hidden = was;
      });
      if (max) wrap.style.setProperty('--s23-h', max + 'px');
    }
    reserve();
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(reserve);
    window.addEventListener('load', reserve);
    var lastW = window.innerWidth, raf = 0;
    window.addEventListener('resize', function () {
      if (window.innerWidth === lastW) return;     // ignore mobile toolbar height changes
      lastW = window.innerWidth;
      cancelAnimationFrame(raf);
      raf = requestAnimationFrame(reserve);
    });

    /* deep links */
    function toSelector() {
      list.scrollIntoView({ block: 'start', behavior: R ? 'auto' : 'smooth' });
    }
    window.addEventListener('hashchange', function () {
      var i = fromHash();
      if (i < 0) return;
      if (i !== api.index()) api.show(i, true);
      toSelector();
    });
    if (fromHash() >= 0) window.addEventListener('load', function () { setTimeout(toSelector, 0); });
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
