/* ==========================================================================
   Brand Design hub — shared motion helpers (window.BDH). Runs after core.js;
   section scripts (assets/js/brand/hub/<id>.js) load after this file.

   Section script pattern:
     (function () {
       'use strict';
       if (!window.BDH) return;
       var root = document.querySelector('.bdh-journey'); if (!root) return;
       if (BDH.reduced) { renderFinalState(); return; }   // complete static state, no loops
       ...
     })();

   API (every helper is safe with a missing element and under reduced motion)
   BDH.reduced                        true when prefers-reduced-motion: reduce
   BDH.$(sel, root) / BDH.$$(sel, root)
   BDH.inView(el, fn, ioOpts)         once, when el first enters (alias of XE.inView)
   BDH.enter(el, {cls:'is-in', delay}) add .is-in once on entry (reduced: at once). Auto: [data-bdh-in]
   BDH.watch(el, fn(on), ioOpts)      fn(true|false) whenever "on screen AND tab visible" changes → {off}
   BDH.live(el, threshold, fn(on))    toggles .is-live while on screen + tab visible; no-op when reduced. Auto: [data-bdh-live]
   BDH.loop(el, ms, fn)               interval that ticks only while el is on screen + tab visible (like XE.liveTimer)
                                      but can be stopped for good → {stop, pause, resume, running}; never runs when reduced
   BDH.onInteract(root, fn)           once, on the first pointerdown / keydown / focusin inside root → {off}
   BDH.tabs(root, opts)               ARIA tablist: opts {tabs, panes, auto:ms, orientation, initial, onChange(i, prev, byUser), interactRoot}
                                      → {show(i, byUser), stop(), index()}. Panes with .bdh-pane toggle .is-on; others toggle [hidden].
   BDH.seq(root, steps, opts)         timeline runner. steps [[delayMs, fn(ctx)], …]; opts {loop:true, stopOnInteract:true,
                                      interactRoot, onLoop(), onStop()} → {stop(), pause(), resume(), running}.
                                      Pauses off-screen / tab hidden and resumes mid-step. Never runs when reduced.
   BDH.type(el, text, {speed:28, delay:0, done}) types into el.textContent → {stop(), finish()}; reduced: writes at once
   BDH.count(el)                      animates 0 → the number already in el's text (keeps prefix/suffix, decimals, commas),
                                      once on entry, 900ms easeOutCubic. HTML keeps the final value. Auto: [data-bdh-count]
   BDH.progress(el, fn(p))            rAF-throttled scroll/resize; p = 0 when el's top meets the viewport bottom,
                                      1 when its bottom meets the viewport top; active only near the viewport → {off}
   BDH.spy(els, fn(el), rootMargin)   fn(el) as each target crosses the middle band ('-45% 0px -50% 0px') → {off}
   BDH.parallax(root)                 [data-bdh-parallax="0.06"]: translates the first element child up to ±24px
                                      (CSS translate property, so it composes with hover-zoom transforms).
                                      Off under reduced motion and below 768px. Auto on load.
   BDH.stagger(root, sel)             sets --i on each match (default: direct children) for CSS delay calc. Auto: [data-bdh-stagger]
   ========================================================================== */
(function () {
  'use strict';
  if (!window.XE) return;

  var XE = window.XE;
  var R = !!XE.reduced;
  var IO = 'IntersectionObserver' in window;
  var noop = function () {};

  function node(x) { return typeof x === 'string' ? document.querySelector(x) : x; }
  function list(x, root) {
    if (!x) return [];
    if (typeof x === 'string') return XE.$$(x, root);
    if (x.nodeType === 1) return [x];
    return Array.prototype.slice.call(x);
  }
  function clamp(v, a, b) { return Math.max(a, Math.min(b, v)); }

  /* on screen AND tab visible → fn(true); otherwise fn(false). Fires on every change. */
  function watch(el, fn, opts) {
    el = node(el);
    if (!el) return { off: noop };
    var inter = !IO, state = null, io = null;
    function emit() {
      var on = inter && !document.hidden;
      if (on !== state) { state = on; fn(on); }
    }
    if (IO) {
      io = new IntersectionObserver(function (es) { inter = es[es.length - 1].isIntersecting; emit(); }, opts || { threshold: 0.15 });
      io.observe(el);
    } else { emit(); }
    document.addEventListener('visibilitychange', emit);
    return { off: function () { if (io) io.disconnect(); document.removeEventListener('visibilitychange', emit); } };
  }

  function enter(el, o) {
    el = node(el); o = o || {};
    if (!el) return;
    var cls = o.cls || 'is-in';
    if (R || !IO) { el.classList.add(cls); return; }
    XE.inView(el, function () {
      if (o.delay) setTimeout(function () { el.classList.add(cls); }, o.delay);
      else el.classList.add(cls);
    }, o.io);
  }

  function live(el, threshold, fn) {
    el = node(el);
    if (!el || R) return { off: noop };
    return watch(el, function (on) { el.classList.toggle('is-live', on); if (fn) fn(on); }, { threshold: threshold == null ? 0.15 : threshold });
  }

  function loop(el, ms, fn) {
    el = node(el);
    var id = null, vis = false, paused = false, dead = false;
    var ctl = { running: false, stop: noop, pause: noop, resume: noop };
    if (!el || R) return ctl;
    function sync() {
      var want = vis && !paused && !dead;
      if (want && id === null) id = setInterval(fn, ms);
      if (!want && id !== null) { clearInterval(id); id = null; }
      ctl.running = id !== null;
    }
    var w = watch(el, function (on) { vis = on; sync(); });
    ctl.pause = function () { paused = true; sync(); };
    ctl.resume = function () { paused = false; sync(); };
    ctl.stop = function () { dead = true; sync(); w.off(); };
    return ctl;
  }

  function onInteract(root, fn) {
    root = node(root);
    if (!root) return { off: noop };
    var evs = ['pointerdown', 'keydown', 'focusin'], done = false;
    function h(e) { if (done) return; done = true; off(); fn(e); }
    function off() { evs.forEach(function (ev) { root.removeEventListener(ev, h, true); }); }
    evs.forEach(function (ev) { root.addEventListener(ev, h, true); });
    return { off: off };
  }

  /* ---------- tabs ---------------------------------------------------------- */
  function tabs(root, o) {
    root = node(root); o = o || {};
    var api = { show: noop, stop: noop, index: function () { return -1; } };
    if (!root) return api;
    var ts = list(o.tabs || '[role="tab"]', root);
    var ps = o.panes ? list(o.panes, root) : ts.map(function (t) {
      var id = t.getAttribute('aria-controls'); return id ? document.getElementById(id) : null;
    });
    if (!ts.length) return api;
    var cur = typeof o.initial === 'number' ? o.initial : Math.max(0, ts.findIndex(function (t) { return t.getAttribute('aria-selected') === 'true'; }));
    var timer = null;

    function paint(i) {
      ts.forEach(function (t, n) {
        var on = n === i;
        t.setAttribute('aria-selected', on ? 'true' : 'false');
        t.setAttribute('tabindex', on ? '0' : '-1');
        t.classList.toggle('is-on', on);
      });
      ps.forEach(function (p, n) {
        if (!p) return;
        var on = n === i;
        if (p.classList.contains('bdh-pane')) p.classList.toggle('is-on', on);
        else p.hidden = !on;
      });
    }
    function show(i, byUser) {
      i = ((i % ts.length) + ts.length) % ts.length;
      var prev = cur; cur = i; paint(i);
      if (o.onChange && i !== prev) o.onChange(i, prev, !!byUser);
    }
    function stop() { if (timer) { timer.stop(); timer = null; } }

    var tl = root.querySelector('[role="tablist"]') || (root.getAttribute('role') === 'tablist' ? root : null);
    if (tl && o.orientation) tl.setAttribute('aria-orientation', o.orientation);

    ts.forEach(function (t, n) {
      XE.on(t, 'click', function () { stop(); show(n, true); });
      XE.on(t, 'keydown', function (e) {
        var k = e.key, j = null;   /* null = not our key; -1 is a real target (ArrowLeft on the first tab wraps) */
        if (k === 'ArrowRight' || k === 'ArrowDown') j = n + 1;
        else if (k === 'ArrowLeft' || k === 'ArrowUp') j = n - 1;
        else if (k === 'Home') j = 0;
        else if (k === 'End') j = ts.length - 1;
        if (j === null) return;
        e.preventDefault(); stop();
        j = ((j % ts.length) + ts.length) % ts.length;
        ts[j].focus(); show(j, true);
      });
    });
    paint(cur);

    if (o.auto && !R) {
      timer = loop(root, o.auto, function () { show(cur + 1, false); });
      onInteract(o.interactRoot || root, stop);
    }
    api.show = show; api.stop = stop; api.index = function () { return cur; };
    return api;
  }

  /* ---------- timeline runner ---------------------------------------------- */
  function seq(root, steps, o) {
    root = node(root); o = o || {};
    var ctl = { running: false, stop: noop, pause: noop, resume: noop };
    if (!root || R || !steps || !steps.length) return ctl;
    var loopIt = o.loop !== false;
    var idx = 0, remain = steps[0][0], t0 = 0, id = null, vis = false, paused = false, dead = false, w;
    var ctx = { root: root, step: 0, cycle: 0 };

    function arm() {
      t0 = Date.now();
      id = setTimeout(fire, Math.max(0, remain));
      ctl.running = true;
    }
    function disarm() {
      if (id === null) return;
      clearTimeout(id); id = null;
      remain = Math.max(0, remain - (Date.now() - t0));
      ctl.running = false;
    }
    function fire() {
      id = null; ctl.running = false;
      ctx.step = idx;
      try { steps[idx][1](ctx); } catch (err) { if (window.console) console.error(err); }
      idx++;
      if (idx >= steps.length) {
        if (!loopIt) { finish(); return; }
        idx = 0; ctx.cycle++;
        if (o.onLoop) o.onLoop(ctx);
      }
      remain = steps[idx][0];
      sync();
    }
    function sync() {
      var want = vis && !paused && !dead;
      if (want && id === null) arm();
      else if (!want && id !== null) disarm();
    }
    function finish() {
      if (dead) return;
      dead = true; disarm(); if (w) w.off();
      if (o.onStop) o.onStop(ctx);
    }
    w = watch(root, function (on) { vis = on; sync(); });
    if (o.stopOnInteract !== false) onInteract(o.interactRoot || root, finish);
    ctl.stop = finish;
    ctl.pause = function () { paused = true; sync(); };
    ctl.resume = function () { paused = false; sync(); };
    return ctl;
  }

  /* ---------- typing -------------------------------------------------------- */
  function type(el, text, o) {
    el = node(el); o = o || {};
    var ctl = { stop: noop, finish: noop };
    if (!el) return ctl;
    text = String(text == null ? '' : text);
    var i = 0, id = null, over = false;
    function done() { if (over) return; over = true; if (id) clearTimeout(id); el.textContent = text; if (o.done) o.done(); }
    if (R) { done(); return ctl; }
    function step() {
      if (over) return;
      i++; el.textContent = text.slice(0, i);
      if (i >= text.length) { over = true; if (o.done) o.done(); return; }
      id = setTimeout(step, o.speed || 28);
    }
    el.textContent = '';
    id = setTimeout(step, o.delay || 0);
    ctl.stop = function () { over = true; if (id) clearTimeout(id); };
    ctl.finish = done;
    return ctl;
  }

  /* ---------- count-up from the value already in the HTML ------------------ */
  function count(el) {
    el = node(el);
    if (!el || R || !IO || el.getAttribute('data-bdh-counted')) return;
    var raw = el.textContent;
    var m = raw.match(/-?\d[\d,]*(\.\d+)?/);
    if (!m) return;
    el.setAttribute('data-bdh-counted', '1');
    var pre = raw.slice(0, m.index), post = raw.slice(m.index + m[0].length);
    var target = parseFloat(m[0].replace(/,/g, ''));
    var dec = m[1] ? m[1].length - 1 : 0, commas = m[0].indexOf(',') > -1;
    function fmt(v) {
      var s = v.toFixed(dec);
      if (commas) s = Number(s).toLocaleString('en-GB', { minimumFractionDigits: dec, maximumFractionDigits: dec });
      return pre + s + post;
    }
    XE.inView(el, function () {
      var t0 = null, dur = 900;
      el.textContent = fmt(0);
      requestAnimationFrame(function tick(ts) {
        if (t0 === null) t0 = ts;
        var p = Math.min(1, (ts - t0) / dur), k = 1 - Math.pow(1 - p, 3);
        el.textContent = p < 1 ? fmt(target * k) : raw;
        if (p < 1) requestAnimationFrame(tick);
      });
    }, { threshold: 0.4 });
  }

  /* ---------- scroll progress ---------------------------------------------- */
  function progress(el, fn) {
    el = node(el);
    if (!el) return { off: noop };
    var near = !IO, queued = false, io = null;
    function measure() {
      queued = false;
      var r = el.getBoundingClientRect(), vh = window.innerHeight || document.documentElement.clientHeight;
      fn(clamp((vh - r.top) / (vh + r.height), 0, 1));
    }
    function req() { if (near && !queued) { queued = true; requestAnimationFrame(measure); } }
    if (IO) {
      io = new IntersectionObserver(function (es) { near = es[es.length - 1].isIntersecting; if (near) req(); }, { rootMargin: '25% 0px 25% 0px' });
      io.observe(el);
    }
    window.addEventListener('scroll', req, { passive: true });
    window.addEventListener('resize', req, { passive: true });
    queued = true; requestAnimationFrame(measure);
    return { off: function () { if (io) io.disconnect(); window.removeEventListener('scroll', req); window.removeEventListener('resize', req); } };
  }

  /* ---------- scroll spy ---------------------------------------------------- */
  function spy(els, fn, rootMargin) {
    var targets = list(els);
    if (!targets.length || !IO) return { off: noop };
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (e) { if (e.isIntersecting) fn(e.target); });
    }, { rootMargin: rootMargin || '-45% 0px -50% 0px' });
    targets.forEach(function (t) { io.observe(t); });
    return { off: function () { io.disconnect(); } };
  }

  /* ---------- parallax ------------------------------------------------------ */
  var hasTranslate = 'translate' in document.documentElement.style;
  function parallax(root) {
    XE.$$('[data-bdh-parallax]', root).forEach(function (wrap) {
      if (wrap.getAttribute('data-bdh-px')) return;
      wrap.setAttribute('data-bdh-px', '1');
      var child = wrap.firstElementChild;
      if (!child || R) return;
      var f = parseFloat(wrap.getAttribute('data-bdh-parallax')) || 0.06;
      function set(y) {
        if (hasTranslate) child.style.translate = y ? '0 ' + y.toFixed(1) + 'px' : '';
        else child.style.transform = y ? 'translate3d(0,' + y.toFixed(1) + 'px,0)' : '';
      }
      progress(wrap, function (p) {
        if (window.innerWidth < 768) { set(0); return; }
        set(clamp((0.5 - p) * f * 800, -24, 24));
      });
    });
  }

  function stagger(root, sel) {
    root = node(root);
    if (!root) return;
    (sel ? XE.$$(sel, root) : Array.prototype.slice.call(root.children)).forEach(function (c, i) { c.style.setProperty('--i', String(i)); });
  }

  window.BDH = {
    reduced: R,
    $: XE.$, $$: XE.$$,
    inView: XE.inView,
    enter: enter, watch: watch, live: live, loop: loop, onInteract: onInteract,
    tabs: tabs, seq: seq, type: type, count: count,
    progress: progress, spy: spy, parallax: parallax, stagger: stagger
  };

  function boot() {
    XE.$$('[data-bdh-stagger]').forEach(function (el) { stagger(el, el.getAttribute('data-bdh-stagger') || null); });
    XE.$$('[data-bdh-in]').forEach(function (el) { enter(el); });
    XE.$$('[data-bdh-live]').forEach(function (el) { live(el); });
    XE.$$('[data-bdh-count]').forEach(count);
    parallax();
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
  else boot();
})();
