/* ==========================================================================
   XTERRA EDZE — Brand Design, shared behaviour
   Loaded on the hub and the six capability pages, after core.js and
   sections.js. Page scripts in assets/js/brand/*.js run after this file and
   may use window.BD. Loops only run while on screen and while the tab is
   visible; under prefers-reduced-motion every component shows its finished
   state and only the controls themselves respond.
   ========================================================================== */
(function () {
  'use strict';
  if (!window.XE) return;
  var XE = window.XE;

  function pad(n) { return (n < 10 ? '0' : '') + n; }

  /* calls fn(true|false) as el comes and goes from view, or the tab hides */
  function watch(el, fn, threshold) {
    var inView = false;
    function emit() { fn(inView && !document.hidden); }
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (es) { inView = es[0].isIntersecting; emit(); },
        { threshold: threshold == null ? 0.15 : threshold }).observe(el);
    } else { inView = true; emit(); }
    document.addEventListener('visibilitychange', emit);
  }

  var BD = {
    watch: watch,
    /* toggles .is-live on el while it is on screen and the tab is visible */
    live: function (el, threshold) {
      if (!el || XE.reduced) return;
      watch(el, function (on) { el.classList.toggle('is-live', on); }, threshold);
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
    XE.$$('[data-bd-live], .bd-hero, .bd-touch').forEach(function (el) { BD.live(el, 0.1); });
  }

  /* ---------- the capability navigator ----------------------------------- */
  /* keeps the current item in view, marks itself stuck under the nav, tracks
     reading progress, and in anchor mode lights the section on screen      */
  function rail() {
    XE.$$('[data-bd-railbar]').forEach(function (bar) {
      var sc = XE.$('[data-bd-rail]', bar);
      var items = XE.$$('.bd-rail__i', bar);
      function center(el, smooth) {
        if (!sc || !el) return;
        var x = Math.max(0, el.offsetLeft - (sc.clientWidth - el.offsetWidth) / 2);
        if (smooth && !XE.reduced && sc.scrollTo) sc.scrollTo({ left: x, behavior: 'smooth' });
        else sc.scrollLeft = x;
      }
      center(XE.$('.bd-rail__i.is-here', bar), false);

      var ticking = false;
      function measure() {
        ticking = false;
        var top = parseFloat(window.getComputedStyle(bar).top) || 0;
        bar.classList.toggle('is-stuck', bar.getBoundingClientRect().top <= top + 1);
        var max = document.documentElement.scrollHeight - window.innerHeight;
        var p = max > 0 ? Math.min(1, Math.max(0, window.scrollY / max)) : 0;
        bar.style.setProperty('--prog', p.toFixed(4));
      }
      function queue() { if (!ticking) { ticking = true; window.requestAnimationFrame(measure); } }
      measure();
      XE.on(window, 'scroll', queue, { passive: true });
      XE.on(window, 'resize', queue);

      if (!bar.hasAttribute('data-bd-spy') || !('IntersectionObserver' in window)) return;
      var map = [];
      items.forEach(function (a) {
        var id = (a.getAttribute('href') || '').split('#')[1];
        var t = id ? document.getElementById(id) : null;
        if (t) map.push([t, a]);
      });
      if (!map.length) return;
      var io = new IntersectionObserver(function (es) {
        es.forEach(function (e) {
          if (!e.isIntersecting) return;
          map.forEach(function (m) {
            var on = m[0] === e.target;
            m[1].classList.toggle('is-here', on);
            if (on) { m[1].setAttribute('aria-current', 'true'); center(m[1], true); }
            else m[1].removeAttribute('aria-current');
          });
        });
      }, { rootMargin: '-35% 0px -60% 0px', threshold: 0 });
      map.forEach(function (m) { io.observe(m[0]); });
    });
  }

  /* ---------- how it runs: the plan advances phase by phase --------------- */
  function process() {
    XE.$$('[data-bd-proc]').forEach(function (panel) {
      var steps = XE.$$('.bd-proc__step', panel), segs = XE.$$('.bd-proc__seg', panel);
      var n = steps.length;
      if (!n) return;
      var numEl = XE.$('[data-bd-proc-n]', panel), nameEl = XE.$('[data-bd-proc-name]', panel);
      var ms = parseInt(panel.getAttribute('data-bd-auto') || '5500', 10);
      var i = 0, timer = null, visible = false, hover = false;
      panel.style.setProperty('--dwell', (ms / 1000) + 's');

      function show(k, run) {
        i = ((k % n) + n) % n;
        steps.forEach(function (s, j) { s.classList.toggle('is-on', j === i); s.classList.toggle('is-done', j < i); });
        segs.forEach(function (s, j) { s.classList.toggle('is-on', j === i); s.classList.toggle('is-done', j < i); });
        if (segs[i]) {
          panel.style.setProperty('--a', segs[i].getAttribute('data-a') || '0');
          panel.style.setProperty('--b', segs[i].getAttribute('data-b') || '1');
        }
        if (numEl) numEl.textContent = pad(i + 1);
        if (nameEl) nameEl.textContent = steps[i].getAttribute('data-name') || '';
        panel.classList.remove('is-running');
        if (run) { void panel.offsetWidth; panel.classList.add('is-running'); }
      }
      function stop() { if (timer) { clearInterval(timer); timer = null; } panel.classList.remove('is-running'); }
      function start() {
        if (timer || XE.reduced || hover || !visible) return;
        show(i, true);
        timer = setInterval(function () { show(i + 1, true); }, ms);
      }

      show(0, false);
      steps.forEach(function (s, j) {
        XE.on(s, 'mouseenter', function () { hover = true; stop(); show(j, false); });
      });
      XE.on(panel, 'mouseleave', function () { hover = false; start(); });
      if (XE.reduced) return;
      watch(panel, function (on) { visible = on; if (on) start(); else stop(); }, 0.25);
    });
  }

  /* ---------- what we offer: one part lit at a time ---------------------- */
  function offer() {
    XE.$$('[data-bd-offer]').forEach(function (list) {
      var items = XE.$$('.bd-offer__i', list);
      var sec = list.closest('.bd-offer');
      var segs = sec ? XE.$$('[data-bd-segs] i', sec) : [];
      if (!items.length) return;
      var k = -1, hover = false;
      function light(j) {
        k = j;
        items.forEach(function (it, x) { it.classList.toggle('is-lit', x === j); });
        segs.forEach(function (s, x) { s.classList.toggle('is-on', x === j); s.classList.toggle('is-done', x < j); });
      }
      items.forEach(function (it, j) { XE.on(it, 'mouseenter', function () { hover = true; light(j); }); });
      XE.on(list, 'mouseleave', function () { hover = false; });
      if (XE.reduced) { segs.forEach(function (s) { s.classList.add('is-done'); }); return; }
      XE.liveTimer(list, 2800, function () { if (!hover) light((k + 1) % items.length); });
    });
  }

  /* ---------- the handover pack transfers, row by row --------------------- */
  function pack() {
    if (XE.reduced) return;
    XE.$$('[data-bd-pack]').forEach(function (p) {
      var rows = XE.$$('.bd-pack__row', p), n = rows.length;
      var cnt = XE.$('[data-bd-pack-n]', p), st = XE.$('[data-bd-pack-state]', p);
      var step = 240, lead = 300;
      if (!n) return;
      p.classList.add('is-wait');
      if (cnt) cnt.textContent = '0';
      if (st) st.textContent = 'Transferring';
      XE.inView(p, function () {
        p.classList.remove('is-wait');
        p.classList.add('is-go');
        rows.forEach(function (r, i) {
          setTimeout(function () { if (cnt) cnt.textContent = String(i + 1); }, lead + (i + 1) * step);
        });
        setTimeout(function () { if (st) st.textContent = 'Transferred'; p.classList.add('is-done'); }, lead + n * step + 250);
      }, { threshold: 0.3 });
    });
  }

  /* ---------- hero depth: the stage layers drift with the pointer --------- */
  function depth() {
    if (XE.reduced || !window.matchMedia('(pointer: fine)').matches) return;
    XE.$$('[data-bd-tilt]').forEach(function (stage) {
      var host = stage.closest('.bd-phero') || stage, raf = 0, x = 0, y = 0;
      function paint() { raf = 0; stage.style.setProperty('--px', x.toFixed(3)); stage.style.setProperty('--py', y.toFixed(3)); }
      XE.on(host, 'pointermove', function (e) {
        if (e.buttons) return;
        var r = host.getBoundingClientRect();
        x = ((e.clientX - r.left) / r.width - 0.5) * 2;
        y = ((e.clientY - r.top) / r.height - 0.5) * 2;
        if (!raf) raf = window.requestAnimationFrame(paint);
      });
      XE.on(host, 'pointerleave', function () { x = 0; y = 0; if (!raf) raf = window.requestAnimationFrame(paint); });
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

  function boot() { lives(); rail(); process(); offer(); pack(); depth(); tabs(); cycles(); }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
  else boot();
})();
