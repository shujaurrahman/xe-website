/* ==========================================================================
   XTERRA EDZE — Brand Design, shared behaviour
   Loaded on the hub and the six capability pages, after core.js and
   sections.js. Page scripts in assets/js/brand/*.js run after this file and
   may use window.BD. Nothing here runs under prefers-reduced-motion except
   the controls themselves, which always work.
   ========================================================================== */
(function () {
  'use strict';
  if (!window.XE) return;
  var XE = window.XE;

  var BD = {
    /* toggles .is-live on el while it is on screen and the tab is visible */
    live: function (el, threshold) {
      if (!el || XE.reduced) return;
      if (!('IntersectionObserver' in window)) { el.classList.add('is-live'); return; }
      var on = false;
      new IntersectionObserver(function (es) {
        on = es[0].isIntersecting;
        el.classList.toggle('is-live', on && !document.hidden);
      }, { threshold: threshold == null ? 0.15 : threshold }).observe(el);
      document.addEventListener('visibilitychange', function () {
        el.classList.toggle('is-live', on && !document.hidden);
      });
    },
    /* a set of tabs that advance themselves until someone picks one */
    stepper: function (root, opts) {
      var tabs = opts.tabs, panes = opts.panes || [], ms = opts.ms || 6000;
      var i = 0, pinned = false, timer = null;
      function show(n, focus) {
        i = ((n % tabs.length) + tabs.length) % tabs.length;
        tabs.forEach(function (t, k) {
          var on = k === i;
          t.classList.toggle('is-on', on);
          t.classList.toggle('is-done', k < i);
          t.classList.remove('is-running');
          t.setAttribute('aria-selected', String(on));
          t.setAttribute('tabindex', on ? '0' : '-1');
        });
        panes.forEach(function (p, k) { p.classList.toggle('is-on', k === i); });
        if (opts.onShow) opts.onShow(i);
        if (!pinned && !XE.reduced) { void tabs[i].offsetWidth; tabs[i].classList.add('is-running'); }
        if (focus) tabs[i].focus();
      }
      function pin() { pinned = true; if (timer) timer.stop(); tabs.forEach(function (t) { t.classList.remove('is-running'); }); }
      tabs.forEach(function (t, k) {
        XE.on(t, 'click', function () { pin(); show(k); });
        XE.on(t, 'keydown', function (e) {
          var d = (e.key === 'ArrowDown' || e.key === 'ArrowRight') ? 1 : (e.key === 'ArrowUp' || e.key === 'ArrowLeft') ? -1 : 0;
          if (!d) return;
          e.preventDefault(); pin(); show(i + d, true);
        });
      });
      show(0);
      if (!XE.reduced) {
        timer = XE.liveTimer(root, ms, function () { if (!pinned) show(i + 1); });
        XE.on(root, 'mouseenter', function () { if (timer && !pinned) timer.stop(); });
        XE.on(root, 'mouseleave', function () { if (timer && !pinned) { timer.start(); show(i); } });
      }
      return { show: show, pin: pin };
    }
  };
  window.BD = BD;

  /* ---------- live regions ----------------------------------------------- */
  function lives() {
    XE.$$('[data-bd-live], .bd-hero, .bd-phero, .bd-touch').forEach(function (el) { BD.live(el, 0.1); });
  }

  /* ---------- the capability rail keeps the current page in view ---------- */
  function rail() {
    var sc = XE.$('[data-bd-rail]');
    if (!sc) return;
    var here = XE.$('.bd-rail__i.is-here', sc);
    if (here) sc.scrollLeft = Math.max(0, here.offsetLeft - sc.clientWidth / 2 + here.clientWidth / 2);
  }

  /* ---------- how it runs: the phase stepper ------------------------------ */
  function process() {
    XE.$$('[data-bd-proc]').forEach(function (panel) {
      var tabs = XE.$$('.bd-proc__step', panel);
      var n = tabs.length;
      BD.stepper(panel, {
        tabs: tabs, ms: 5500,
        onShow: function (i) { panel.style.setProperty('--p', n > 1 ? String(i / (n - 1)) : '1'); }
      });
    });
  }

  /* ---------- generic tabs ------------------------------------------------ */
  function tabs() {
    XE.$$('[data-bd-tabs]').forEach(function (root) {
      var ms = parseInt(root.getAttribute('data-bd-auto') || '6500', 10);
      root.style.setProperty('--dwell', (ms / 1000) + 's');
      BD.stepper(root, { tabs: XE.$$('[data-bd-tab]', root), panes: XE.$$('[data-bd-pane]', root), ms: ms });
    });
  }

  /* ---------- a list that lights one item at a time ----------------------- */
  function cycles() {
    if (XE.reduced) return;
    XE.$$('[data-bd-cycle]').forEach(function (root) {
      var items = XE.$$('[data-bd-cycle-i]', root);
      if (items.length < 2) return;
      var k = Math.max(0, items.findIndex(function (x) { return x.classList.contains('is-on'); }));
      XE.liveTimer(root, parseInt(root.getAttribute('data-bd-cycle') || '2400', 10), function () {
        items[k].classList.remove('is-on');
        k = (k + 1) % items.length;
        items[k].classList.add('is-on');
      });
    });
  }

  function boot() { lives(); rail(); process(); tabs(); cycles(); }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
  else boot();
})();
