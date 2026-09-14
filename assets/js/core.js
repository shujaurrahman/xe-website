/* ==========================================================================
   XTERRA EDZE — core behaviour
   Shared helpers live on window.XE. Section scripts are appended below this
   file and must only use XE.* helpers or their own scoped code.
   ========================================================================== */
(function () {
  'use strict';

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  var XE = {
    reduced: reduced,
    $: function (s, r) { return (r || document).querySelector(s); },
    $$: function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); },
    on: function (el, ev, fn, o) { if (el) el.addEventListener(ev, fn, o); },
    clamp: function (v, a, b) { return Math.max(a, Math.min(b, v)); },
    /* run fn when el first enters the viewport */
    inView: function (el, fn, opts) {
      if (!('IntersectionObserver' in window)) { fn(); return; }
      var io = new IntersectionObserver(function (es) {
        es.forEach(function (e) { if (e.isIntersecting) { io.unobserve(e.target); fn(e.target); } });
      }, opts || { rootMargin: '0px 0px -12% 0px', threshold: 0.12 });
      io.observe(el);
    },
    /* an interval that only ticks while el is on screen and the tab is visible */
    liveTimer: function (el, ms, fn) {
      var id = null, on = false;
      function start() { if (id === null && on && !document.hidden) id = setInterval(fn, ms); }
      function stop() { if (id !== null) { clearInterval(id); id = null; } }
      if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (es) {
          on = es[0].isIntersecting; on ? start() : stop();
        }, { threshold: 0.15 }).observe(el);
      } else { on = true; start(); }
      document.addEventListener('visibilitychange', function () { document.hidden ? stop() : start(); });
      return { stop: stop, start: start, reset: function () { stop(); start(); } };
    }
  };
  window.XE = XE;

  /* ---------- scroll reveal ---------------------------------------------- */
  function reveal() {
    var items = XE.$$('[data-rv],[data-rv-s]');
    if (!items.length) return;
    if (reduced || !('IntersectionObserver' in window)) {
      items.forEach(function (el) { el.classList.add('is-in'); }); return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        var el = e.target;
        io.unobserve(el);
        var delay = parseInt(el.getAttribute('data-rv-d') || '0', 10);
        setTimeout(function () {
          el.classList.add('is-in');
          if (el.hasAttribute('data-rv-s')) {
            var step = parseInt(el.getAttribute('data-rv-step') || '70', 10);
            Array.prototype.forEach.call(el.children, function (c, i) {
              c.style.transitionDelay = (i * step) + 'ms';
            });
          }
        }, delay);
      });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.12 });
    items.forEach(function (el) { io.observe(el); });
  }

  /* ---------- live clock -------------------------------------------------- */
  function clocks() {
    var els = XE.$$('[data-clock]');
    if (!els.length) return;
    function tick() {
      els.forEach(function (el) {
        var tz = el.getAttribute('data-clock') || 'Asia/Kolkata';
        var t;
        try {
          t = new Intl.DateTimeFormat('en-GB', {
            timeZone: tz, hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
          }).format(new Date());
        } catch (e) { t = ''; }
        if (el.textContent !== t) el.textContent = t;
      });
    }
    tick();
    setInterval(tick, 1000);
  }

  /* ---------- marquee: clone children once for a seamless -50% loop ------- */
  function marquees() {
    XE.$$('[data-mq]').forEach(function (track) {
      if (track.getAttribute('data-mq-done')) return;
      var kids = Array.prototype.slice.call(track.children);
      kids.forEach(function (k) {
        var c = k.cloneNode(true);
        c.setAttribute('aria-hidden', 'true');
        c.querySelectorAll('a,button,input').forEach(function (f) { f.setAttribute('tabindex', '-1'); });
        track.appendChild(c);
      });
      track.setAttribute('data-mq-done', '1');
      if (reduced) track.style.animation = 'none';
    });
  }

  /* ---------- accordion ---------------------------------------------------- */
  /* [data-acc] wrapper; each row: button[data-acc-b] + div[data-acc-p]        */
  function accordions() {
    XE.$$('[data-acc]').forEach(function (acc) {
      var single = acc.getAttribute('data-acc') !== 'multi';
      var btns = XE.$$('[data-acc-b]', acc);
      btns.forEach(function (btn) {
        var panel = btn.parentElement.querySelector('[data-acc-p]');
        if (!panel) return;
        if (btn.getAttribute('aria-expanded') === 'true') panel.style.height = 'auto';
        XE.on(btn, 'click', function () {
          var open = btn.getAttribute('aria-expanded') === 'true';
          if (single) {
            btns.forEach(function (b) {
              if (b === btn) return;
              var p = b.parentElement.querySelector('[data-acc-p]');
              b.setAttribute('aria-expanded', 'false');
              if (p) { p.style.height = p.scrollHeight + 'px'; p.offsetHeight; p.style.height = '0px'; }
            });
          }
          btn.setAttribute('aria-expanded', String(!open));
          if (open) {
            panel.style.height = panel.scrollHeight + 'px'; panel.offsetHeight; panel.style.height = '0px';
          } else {
            panel.style.height = panel.scrollHeight + 'px';
            var done = function () { panel.style.height = 'auto'; panel.removeEventListener('transitionend', done); };
            panel.addEventListener('transitionend', done);
          }
        });
      });
    });
  }

  /* ---------- word rotator ------------------------------------------------ */
  function rotators() {
    XE.$$('[data-rotate]').forEach(function (el) {
      var words = (el.getAttribute('data-rotate') || '').split('|').filter(Boolean);
      if (words.length < 2) return;
      var i = 0, span = document.createElement('span');
      span.className = 'rot__w';
      span.textContent = words[0];
      el.textContent = '';
      el.appendChild(span);
      el.style.setProperty('--rot-ch', String(Math.max.apply(null, words.map(function (w) { return w.length; }))));
      if (reduced) return;
      XE.liveTimer(el, 2400, function () {
        i = (i + 1) % words.length;
        span.classList.add('is-out');
        setTimeout(function () {
          span.textContent = words[i];
          span.classList.remove('is-out');
          span.classList.add('is-in-w');
          setTimeout(function () { span.classList.remove('is-in-w'); }, 420);
        }, 260);
      });
    });
  }

  /* ---------- typed placeholder ------------------------------------------ */
  function typed() {
    XE.$$('[data-typed]').forEach(function (el) {
      var lines = (el.getAttribute('data-typed') || '').split('|').filter(Boolean);
      if (!lines.length) return;
      if (reduced) { el.setAttribute('placeholder', lines[0]); return; }
      var li = 0, ci = 0, dir = 1, hold = 0, stop = false;
      XE.on(el, 'focus', function () { stop = true; el.setAttribute('placeholder', ''); });
      (function step() {
        if (stop) return;
        var line = lines[li];
        if (hold > 0) { hold--; }
        else {
          ci += dir;
          if (ci > line.length) { ci = line.length; dir = -1; hold = 42; }
          else if (ci < 0) { ci = 0; dir = 1; li = (li + 1) % lines.length; hold = 5; }
        }
        el.setAttribute('placeholder', line.slice(0, ci));
        setTimeout(step, hold > 0 ? 38 : (dir > 0 ? 42 + Math.random() * 42 : 26));
      })();
    });
  }

  /* ---------- navigation -------------------------------------------------- */
  function nav() {
    var bar = XE.$('.nav');
    if (!bar) return;
    var scrim = XE.$('.nav-scrim');
    var trigger = XE.$('[data-mega-t]');
    var mega = XE.$('#mega');
    var sheet = XE.$('.sheet');
    var burger = XE.$('.nav__burger');

    /* condense on scroll */
    var stuck = false;
    function onScroll() {
      var s = window.scrollY > 120;
      if (s !== stuck) { stuck = s; bar.classList.toggle('is-stuck', s); }
    }
    onScroll();
    XE.on(window, 'scroll', onScroll, { passive: true });

    /* mega menu */
    if (trigger && mega) {
      var openT = null, closeT = null;
      function open() {
        clearTimeout(closeT);
        mega.classList.add('is-open');
        trigger.setAttribute('aria-expanded', 'true');
        if (scrim) scrim.classList.add('is-on');
      }
      function close() {
        mega.classList.remove('is-open');
        trigger.setAttribute('aria-expanded', 'false');
        if (scrim) scrim.classList.remove('is-on');
      }
      function later(fn, ms) { return setTimeout(fn, ms); }
      XE.on(trigger, 'click', function (e) {
        e.preventDefault();
        mega.classList.contains('is-open') ? close() : open();
      });
      XE.on(trigger, 'mouseenter', function () { clearTimeout(closeT); openT = later(open, 90); });
      XE.on(trigger, 'mouseleave', function () { clearTimeout(openT); closeT = later(close, 220); });
      XE.on(mega, 'mouseenter', function () { clearTimeout(closeT); });
      XE.on(mega, 'mouseleave', function () { closeT = later(close, 220); });
      XE.on(scrim, 'click', close);
      XE.on(document, 'keydown', function (e) { if (e.key === 'Escape') close(); });
      XE.on(mega, 'click', function (e) { if (e.target.closest('a')) close(); });

      /* rail ⇄ pane */
      var tabs = XE.$$('.mega__tab', mega);
      var panes = XE.$$('.mega__pane', mega);
      function show(i) {
        tabs.forEach(function (t, n) { t.classList.toggle('is-on', n === i); t.setAttribute('aria-selected', String(n === i)); });
        panes.forEach(function (p, n) { p.classList.toggle('is-on', n === i); });
      }
      tabs.forEach(function (t, i) {
        XE.on(t, 'mouseenter', function () { show(i); });
        XE.on(t, 'focus', function () { show(i); });
        XE.on(t, 'click', function (e) {
          if (t.dataset.href) { return; }
          e.preventDefault(); show(i);
        });
        XE.on(t, 'keydown', function (e) {
          var n = e.key === 'ArrowDown' ? i + 1 : e.key === 'ArrowUp' ? i - 1 : -1;
          if (n < 0 || n >= tabs.length) return;
          e.preventDefault(); tabs[n].focus(); show(n);
        });
      });
    }

    /* mobile sheet */
    if (burger && sheet) {
      var close2 = XE.$('[data-sheet-x]', sheet);
      function toggleSheet(on) {
        sheet.classList.toggle('is-open', on);
        burger.setAttribute('aria-expanded', String(on));
        document.documentElement.style.overflow = on ? 'hidden' : '';
      }
      XE.on(burger, 'click', function () { toggleSheet(!sheet.classList.contains('is-open')); });
      XE.on(close2, 'click', function () { toggleSheet(false); });
      XE.on(sheet, 'click', function (e) { if (e.target.closest('a')) toggleSheet(false); });
      XE.on(document, 'keydown', function (e) { if (e.key === 'Escape') toggleSheet(false); });
      XE.$$('.sheet__btn[data-sheet-b]', sheet).forEach(function (b) {
        XE.on(b, 'click', function () {
          var p = b.parentElement.querySelector('.sheet__panel');
          var on = b.getAttribute('aria-expanded') === 'true';
          b.setAttribute('aria-expanded', String(!on));
          if (p) p.classList.toggle('is-open', !on);
        });
      });
    }
  }

  /* ---------- first-visit mark -------------------------------------------- */
  function pre() {
    var el = XE.$('#pre');
    if (!el) return;
    var seen = false;
    try { seen = sessionStorage.getItem('xe-seen') === '1'; } catch (e) {}
    function done() {
      el.classList.add('is-done');
      document.documentElement.classList.remove('pre-on');
      try { sessionStorage.setItem('xe-seen', '1'); } catch (e) {}
      setTimeout(function () { if (el.parentNode) el.parentNode.removeChild(el); }, 700);
    }
    if (seen || reduced) { done(); return; }
    document.documentElement.classList.add('pre-on');
    var v = XE.$('video', el), fired = false;
    function once() { if (!fired) { fired = true; done(); } }
    if (v) {
      XE.on(v, 'ended', function () { setTimeout(once, 220); });
      XE.on(v, 'error', once);
      var pr = v.play();
      if (pr && pr.catch) pr.catch(once);
    }
    setTimeout(once, 3400);
    XE.on(el, 'click', once);
  }

  /* ---------- numbers that count up when they arrive ---------------------- */
  function counters() {
    var els = XE.$$('[data-count]');
    if (!els.length) return;
    els.forEach(function (el) {
      var raw = el.getAttribute('data-count');
      var target = parseFloat(raw.replace(/[^0-9.]/g, ''));
      var suffix = raw.replace(/[0-9.,]/g, '');
      if (isNaN(target)) return;
      if (reduced) { el.textContent = raw; return; }
      el.textContent = '0' + suffix;
      XE.inView(el, function () {
        var t0 = null, dur = 1100;
        (function tick(ts) {
          if (t0 === null) t0 = ts;
          var p = Math.min(1, (ts - t0) / dur);
          var e = 1 - Math.pow(1 - p, 3);
          el.textContent = Math.round(target * e).toLocaleString('en-GB') + suffix;
          if (p < 1) requestAnimationFrame(tick);
        })(performance.now());
      }, { threshold: 0.4 });
    });
  }

  /* ---------- year stamp --------------------------------------------------- */
  function year() {
    XE.$$('[data-year]').forEach(function (el) { el.textContent = String(new Date().getFullYear()); });
  }

  function boot() {
    pre(); reveal(); clocks(); counters(); marquees(); accordions(); rotators(); typed(); nav(); year();
    document.documentElement.classList.add('is-ready');
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
  else boot();
})();
