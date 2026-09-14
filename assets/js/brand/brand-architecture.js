/* Brand Design · brand-architecture — page interactions. Runs after core.js and brand.js; use window.XE and window.BD.
   1. hero portfolio map: three models, autoplay until someone picks one
   2. migration: Today ⇄ Structured, autoplay until someone picks one
   3. comparison table: scroll cue on narrow screens
   4. field photos: pointer parallax on the photo and its composites together */
(function () {
  'use strict';
  if (!window.XE) return;
  var XE = window.XE;

  /* ---------- a loop that only runs while its root is on screen ----------- */
  function loop(root, ms, tick, onResume) {
    var id = null, seen = false, held = false;
    function start() {
      if (id !== null || !seen || held || document.hidden) return;
      if (onResume) onResume();
      id = setInterval(tick, ms);
    }
    function stop() { if (id !== null) { clearInterval(id); id = null; } }
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (es) { seen = es[0].isIntersecting; seen ? start() : stop(); }, { threshold: 0.25 }).observe(root);
    } else { seen = true; start(); }
    document.addEventListener('visibilitychange', function () { document.hidden ? stop() : start(); });
    return {
      hold: function () { held = true; stop(); },
      release: function () { held = false; start(); },
      kill: function () { held = true; stop(); }
    };
  }

  /* ---------- a set of aria-pressed buttons that drive one attribute ------ */
  function switcher(root, o) {
    var btns = o.btns, keys = btns.map(function (b) { return b.getAttribute(o.key); });
    var i = Math.max(0, keys.indexOf(root.getAttribute(o.attr)));
    var pinned = false, timer = null;

    function dwell() {
      btns.forEach(function (b) { b.classList.remove('is-running'); });
      if (pinned || XE.reduced) return;
      void btns[i].offsetWidth;
      btns[i].classList.add('is-running');
    }
    function set(n, user) {
      i = ((n % keys.length) + keys.length) % keys.length;
      root.setAttribute(o.attr, keys[i]);
      btns.forEach(function (b, k) { b.setAttribute('aria-pressed', String(k === i)); });
      dwell();
      if (o.onSet) o.onSet(i, keys[i], !!user);
    }
    function pin() {
      pinned = true;
      root.classList.add('is-pinned');
      if (timer) timer.kill();
      dwell();
    }
    btns.forEach(function (b, k) {
      XE.on(b, 'click', function () { pin(); set(k, true); });
      XE.on(b, 'keydown', function (e) {
        var d = (e.key === 'ArrowRight' || e.key === 'ArrowDown') ? 1 : (e.key === 'ArrowLeft' || e.key === 'ArrowUp') ? -1 : 0;
        if (!d) return;
        e.preventDefault(); pin(); set(i + d, true); btns[i].focus();
      });
    });
    set(i, false);
    if (!XE.reduced) {
      timer = loop(root, o.ms, function () { if (!pinned) set(i + 1, false); }, dwell);
      XE.on(root, 'mouseenter', function () { if (!pinned) { timer.hold(); btns.forEach(function (b) { b.classList.remove('is-running'); }); } });
      XE.on(root, 'mouseleave', function () { if (!pinned) timer.release(); });
      XE.on(root, 'focusin', function () { if (!pinned) { timer.hold(); btns.forEach(function (b) { b.classList.remove('is-running'); }); } });
      XE.on(root, 'focusout', function (e) { if (!pinned && !root.contains(e.relatedTarget)) timer.release(); });
    }
    return { set: set, pin: pin };
  }

  function say(root, text) {
    var el = XE.$('[data-ba-say]', root);
    if (!el) return;
    el.textContent = '';
    setTimeout(function () { el.textContent = text; }, 40);
  }

  /* ---------- 1 · hero portfolio map -------------------------------------- */
  function arch() {
    var root = XE.$('[data-bd-arch]');
    if (!root) return;
    var idx = XE.$('[data-ba-idx]', root);
    var first = true;
    switcher(root, {
      btns: XE.$$('[data-bd-model]', root), key: 'data-bd-model', attr: 'data-model', ms: 4500,
      onSet: function (i, key, user) {
        if (idx) idx.textContent = '0' + (i + 1);
        if (!XE.reduced && !first) {
          root.classList.remove('is-draw');
          void root.offsetWidth;
          root.classList.add('is-draw');
        }
        first = false;
        if (user) {
          var lg = XE.$('.ba-arch__legend[data-for="' + key + '"]', root);
          if (lg) say(root, lg.textContent.replace(/\s+/g, ' ').trim());
        }
      }
    });
  }

  /* ---------- 2 · migration ----------------------------------------------- */
  function migrate() {
    var root = XE.$('[data-bd-ba]');
    if (!root) return;
    switcher(root, {
      btns: XE.$$('[data-bd-ba-btn]', root), key: 'data-bd-ba-btn', attr: 'data-state', ms: 4000,
      onSet: function (i, key, user) {
        if (!user) return;
        var s = XE.$('.ba-migrate__status [data-for="' + key + '"]', root);
        if (s) say(root, (key === 'after' ? 'Structured: ' : 'Today: ') + s.textContent.replace(/\s*·\s*/g, ', ').replace(/\s+/g, ' ').trim());
      }
    });
  }

  /* ---------- 3 · comparison scroll cue ----------------------------------- */
  function compare() {
    var sc = XE.$('[data-ba-scroll]');
    if (!sc) return;
    var frame = sc.parentElement, raf = 0;
    function update() {
      raf = 0;
      var max = sc.scrollWidth - sc.clientWidth;
      frame.classList.toggle('is-scrollable', max > 2);
      frame.classList.toggle('is-end', sc.scrollLeft >= max - 2);
      frame.classList.toggle('is-moved', sc.scrollLeft > 2);
    }
    function queue() { if (!raf) raf = requestAnimationFrame(update); }
    XE.on(sc, 'scroll', queue, { passive: true });
    XE.on(window, 'resize', queue);
    update();
  }

  /* ---------- 4 · photo parallax ------------------------------------------ */
  function parallax() {
    if (XE.reduced || !window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
    XE.$$('[data-ba-par]').forEach(function (ph) {
      var raf = 0, x = 0, y = 0;
      function paint() { raf = 0; ph.style.setProperty('--tx', x.toFixed(2) + 'px'); ph.style.setProperty('--ty', y.toFixed(2) + 'px'); }
      XE.on(ph, 'pointermove', function (e) {
        var r = ph.getBoundingClientRect();
        x = ((e.clientX - r.left) / r.width - 0.5) * -14;
        y = ((e.clientY - r.top) / r.height - 0.5) * -14;
        ph.classList.add('is-par');
        if (!raf) raf = requestAnimationFrame(paint);
      });
      XE.on(ph, 'pointerleave', function () {
        x = 0; y = 0; ph.classList.remove('is-par');
        if (!raf) raf = requestAnimationFrame(paint);
      });
    });
  }

  function boot() { arch(); migrate(); compare(); parallax(); }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
  else boot();
})();
