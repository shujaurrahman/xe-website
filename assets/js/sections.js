/* ===== 00-story ===== */
try {
/* 00 — chapter rail. sections.js loads before hub.js, so wait for DOMContentLoaded before using BDH. */
document.addEventListener('DOMContentLoaded', function () {
  'use strict';
  var rail = document.querySelector('[data-hx-rail]');
  if (!rail || !window.BDH) return;
  var links = [].slice.call(rail.querySelectorAll('[data-hx-ch]'));
  var segs = [].slice.call(rail.querySelectorAll('[data-hx-seg]'));
  var owner = new Map(), secs = [];
  links.forEach(function (a, n) {
    (a.getAttribute('data-hx-ids') || '').split(' ').forEach(function (id) {
      var el = id && document.getElementById(id);
      if (el) { owner.set(el, n); secs.push(el); }
    });
  });
  if (!secs.length) return;
  rail.hidden = false;
  var hero = document.getElementById('hero');
  function set(n, onHero) {
    links.forEach(function (a, i) {
      a.classList.toggle('is-on', i === n);
      a.classList.toggle('is-past', i < n);
      if (i === n) a.setAttribute('aria-current', 'step'); else a.removeAttribute('aria-current');
    });
    segs.forEach(function (s, i) { s.classList.toggle('is-on', i === n); s.classList.toggle('is-past', i < n); });
    rail.classList.toggle('is-hero', !!onHero);
  }
  set(0, true);
  window.BDH.spy(secs, function (el) {
    set(owner.get(el) || 0, el === hero);
  });
});
} catch (e) { console.error('[00-story]', e); }

/* ===== 01-hero ===== */
try {
/* 01 — the floating work drifts with the pointer; everything fades in once. */
(function () {
  'use strict';
  var sec = document.querySelector('.s01');
  if (!sec || !window.XE) return;

  /* reveal + start the ambient loops */
  if (!XE.reduced) sec.classList.add('is-anim');   /* floats start hidden only when JS runs */
  requestAnimationFrame(function () { requestAnimationFrame(function () { sec.classList.add('is-in'); }); });
  if (!XE.reduced) {
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (es) {
        sec.classList.toggle('is-live', es[0].isIntersecting && !document.hidden);
      }, { threshold: 0 }).observe(sec);
    } else { sec.classList.add('is-live'); }
  }

  /* light one word of the stack at a time */
  var wrap = XE.$('[data-s01-words]', sec);
  if (wrap && !XE.reduced) {
    var words = XE.$$('span', wrap), wi = 0;
    XE.liveTimer(sec, 1500, function () {
      words[wi].classList.remove('is-on');
      wi = (wi + 1) % words.length;
      words[wi].classList.add('is-on');
    });
  }

  var floats = XE.$$('.s01__f', sec);
  if (!floats.length || XE.reduced) return;
  if (!window.matchMedia('(pointer:fine)').matches) return;

  var tx = 0, ty = 0, cx = 0, cy = 0, raf = null;
  XE.on(window, 'mousemove', function (e) {
    if (sec.getBoundingClientRect().bottom < 0) return;
    tx = (e.clientX / window.innerWidth - .5) * 2;
    ty = (e.clientY / window.innerHeight - .5) * 2;
    if (!raf) raf = requestAnimationFrame(loop);
  }, { passive: true });

  function loop() {
    cx += (tx - cx) * .055;
    cy += (ty - cy) * .055;
    floats.forEach(function (f, i) {
      var d = 9 + (i % 4) * 6;
      f.style.setProperty('--px', (cx * d).toFixed(2) + 'px');
      f.style.setProperty('--py', (cy * d).toFixed(2) + 'px');
    });
    raf = (Math.abs(tx - cx) > .002 || Math.abs(ty - cy) > .002) ? requestAnimationFrame(loop) : null;
  }
})();
} catch (e) { console.error('[01-hero]', e); }

/* ===== 02-showcase ===== */
try {
/* 02 — Brief ⇄ Delivered. It runs itself: the rule fills across, then the pane
   turns over. Clicking a pill takes control. */
(function () {
  'use strict';
  var sec = document.querySelector('.s02');
  if (!sec || !window.XE) return;

  var toggle = XE.$('.s02__toggle', sec);
  var tabs = XE.$$('.s02__pill', sec);
  var panes = XE.$$('.s02__pane', sec);
  var stage = XE.$('.s02__panes', sec);
  if (tabs.length < 2 || panes.length < 2) return;

  var i = 0, pinned = false, t1 = null, t2 = null;

  function paint(n) {
    i = n % tabs.length;
    tabs.forEach(function (t, k) {
      var on = k === i;
      t.setAttribute('aria-selected', String(on));
      t.setAttribute('tabindex', on ? '0' : '-1');
    });
    panes.forEach(function (p, k) {
      var on = k === i;
      p.classList.toggle('is-on', on);
      if (on) p.removeAttribute('aria-hidden'); else p.setAttribute('aria-hidden', 'true');
    });
    if (stage) stage.setAttribute('data-dir', i === 0 ? 'back' : 'fwd');
    toggle.classList.toggle('is-far', i === 1);
  }

  function clear() { clearTimeout(t1); clearTimeout(t2); toggle.classList.remove('is-travel', 'is-back'); }

  /* one leg of the loop: fill the rule, then turn the pane over */
  function travel() {
    if (pinned || !live) return;
    var forward = i === 0;
    toggle.classList.add(forward ? 'is-travel' : 'is-back');
    t1 = setTimeout(function () {
      if (pinned || !live) return;
      toggle.classList.remove('is-travel', 'is-back');
      paint(forward ? 1 : 0);
      t2 = setTimeout(travel, 4200);
    }, 1500);
  }

  function take(k) {
    pinned = true;
    clear();
    paint(k);
  }

  tabs.forEach(function (t, k) {
    XE.on(t, 'click', function () { take(k); });
    XE.on(t, 'keydown', function (e) {
      var d = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0;
      if (!d) return;
      e.preventDefault();
      var n = (k + d + tabs.length) % tabs.length;
      take(n); tabs[n].focus();
    });
  });

  paint(0);

  /* the loop (and the wash behind it) only runs while the section is on screen */
  if (!XE.reduced) {
    var live = false;
    function setLive(on) {
      on = on && !document.hidden;
      if (on === live) return;
      live = on;
      sec.classList.toggle('is-live', on);
      if (on) { if (!pinned) t2 = setTimeout(travel, 2200); }
      else clear();
    }
    if ('IntersectionObserver' in window) {
      var seen = false;
      new IntersectionObserver(function (es) {
        seen = es[0].isIntersecting; setLive(seen);
      }, { threshold: 0.15 }).observe(sec);
      XE.on(document, 'visibilitychange', function () { setLive(seen); });
    } else { setLive(true); }
  }
})();
} catch (e) { console.error('[02-showcase]', e); }

/* ===== 03-industries ===== */
try {
/* 03 — hovering or focusing a card opens it and swaps the word in the heading. */
(function () {
  'use strict';
  var sec = document.querySelector('.s03');
  if (!sec || !window.XE) return;

  var cards = XE.$$('[data-s03-card]', sec);
  var word = XE.$('[data-s03-word]', sec);
  var tabs = XE.$$('.s03__hit', sec);
  var fine = window.matchMedia('(pointer:fine)').matches;
  var wide = window.matchMedia('(min-width:861px)');
  var pinned = false, cur = 0, timer = null;
  var rail = XE.$('[data-s03-rail]', sec);
  sec.classList.add('is-anim');   /* closed cards hide their line only once JS runs */

  /* wide: an accordion tablist. Narrow: a plain scroll rail where every card is a
     reachable button and every line is visible, so the tab roles come off. */
  function mode() {
    var tabsOn = wide.matches;
    if (tabsOn) {
      rail.setAttribute('role', 'tablist'); rail.removeAttribute('aria-roledescription');
      rail.removeAttribute('tabindex');
      rail.setAttribute('aria-label', 'Industries we work in');
    } else {
      /* a sideways scroller: focusable so arrow keys scroll it, named as one */
      rail.setAttribute('role', 'region');
      rail.setAttribute('tabindex', '0');
      rail.setAttribute('aria-label', 'Industries we work in, scroll sideways');
    }
    tabs.forEach(function (t, k) {
      var body = cards[k].querySelector('.s03__body');
      if (tabsOn) {
        t.setAttribute('role', 'tab');
        t.setAttribute('aria-selected', String(k === cur));
        t.setAttribute('aria-controls', body.id);
        t.setAttribute('tabindex', k === cur ? '0' : '-1');
        body.setAttribute('role', 'tabpanel');
      } else {
        t.removeAttribute('role'); t.removeAttribute('aria-selected'); t.removeAttribute('aria-controls');
        t.setAttribute('tabindex', '0');
        body.removeAttribute('role');
      }
    });
  }
  mode();
  if (wide.addEventListener) wide.addEventListener('change', mode);

  /* hold the widest word so the heading never reflows */
  var longest = cards.reduce(function (a, c) {
    var w = c.getAttribute('data-word') || '';
    return w.length > a.length ? w : a;
  }, '');
  XE.$('.s03__swap', sec).style.minWidth = (longest.length * 0.62) + 'em';

  function open(i) {
    if (i === cur) return;
    cur = i;
    cards.forEach(function (c, k) { c.classList.toggle('is-on', k === i); });
    if (wide.matches) tabs.forEach(function (t, k) {
      t.setAttribute('aria-selected', String(k === i));
      t.setAttribute('tabindex', k === i ? '0' : '-1');
    });
    var next = cards[i].getAttribute('data-word') || '';
    if (XE.reduced) { word.innerHTML = next; return; }
    word.classList.add('is-out');
    setTimeout(function () {
      word.innerHTML = next;
      word.classList.remove('is-out');
    }, 240);
  }

  cards.forEach(function (c, i) {
    var hit = XE.$('.s03__hit', c);
    if (fine && wide.matches) XE.on(c, 'mouseenter', function () { if (!pinned) open(i); });
    XE.on(hit, 'focus', function () { open(i); });
    XE.on(hit, 'click', function () { pinned = true; if (timer) timer.stop(); open(i); });
    XE.on(hit, 'keydown', function (e) {
      if (!wide.matches) return;
      var d = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0;
      if (!d) return;
      e.preventDefault();
      var t = (i + d + cards.length) % cards.length;
      pinned = true; if (timer) timer.stop();
      open(t); tabs[t].focus();
    });
  });

  if (!XE.reduced && wide.matches) {
    timer = XE.liveTimer(sec, 4200, function () {
      if (!pinned) open((cur + 1) % cards.length);
    });
    XE.on(sec, 'mouseenter', function () { if (timer) timer.stop(); });
    XE.on(sec, 'mouseleave', function () { if (!pinned && timer) timer.start(); });
  }
})();
} catch (e) { console.error('[03-industries]', e); }

/* ===== 05-flow ===== */
try {
/* 05 — the diagram only animates while it is on screen, and never under
   reduced motion. Everything else is CSS. */
(function () {
  'use strict';
  var d = document.querySelector('[data-s05]');
  if (!d || !window.XE || XE.reduced) return;
  if (!('IntersectionObserver' in window)) { d.classList.add('is-live'); return; }
  new IntersectionObserver(function (es) {
    d.classList.toggle('is-live', es[0].isIntersecting && !document.hidden);
  }, { threshold: 0.12 }).observe(d);
  document.addEventListener('visibilitychange', function () {
    if (document.hidden) d.classList.remove('is-live');
  });
})();
} catch (e) { console.error('[05-flow]', e); }

/* ===== 06-equip ===== */
try {
/* 06 — capability rail. The rail is a native scroll-snap row; this script only
   drives it. Arrows and ←/→ on the focused rail move one card; Home/End jump.
   Auto-advance runs only while the rail is on screen, pauses while the pointer or
   focus is on it, and stops for good after any manual move or the pause button.
   Nothing auto-advances or loops under reduced motion. */
(function () {
  'use strict';
  var sec = document.querySelector('.s06');
  if (!sec || !window.XE) return;
  var rail = XE.$('[data-s06-rail]', sec);
  var track = XE.$('[data-s06-track]', sec);
  var nav = XE.$('[data-s06-nav]', sec);
  if (!rail || !track || !nav) return;
  var slides = XE.$$('.s06__slide', track);
  var n = slides.length;
  var play = XE.$('[data-s06-play]', sec);
  var count = XE.$('[data-s06-count]', sec);
  nav.hidden = false;

  function pad(v) { return (v < 10 ? '0' : '') + v; }
  function padL() { return parseFloat(getComputedStyle(track).paddingLeft) || 0; }
  function maxX() { return rail.scrollWidth - rail.clientWidth; }

  /* first card whose start is at (or past) the scroll edge, and last fully visible card */
  function range() {
    var x = rail.scrollLeft + padL(), w = rail.clientWidth - 2 * padL();
    var first = 0, best = Infinity, last = 0;
    slides.forEach(function (s, k) {
      var d = Math.abs(s.offsetLeft - x);
      if (d < best) { best = d; first = k; }
      if (s.offsetLeft + s.offsetWidth <= x + w + 4) last = k;
    });
    if (rail.scrollLeft >= maxX() - 2) last = n - 1;
    return [first, Math.max(first, last)];
  }
  function paint() {
    var r = range();
    count.textContent = (r[0] === r[1] ? pad(r[0] + 1) : pad(r[0] + 1) + '–' + pad(r[1] + 1)) + ' / ' + pad(n);
  }
  var ticking = false;
  XE.on(rail, 'scroll', function () {
    if (ticking) return; ticking = true;
    requestAnimationFrame(function () { ticking = false; paint(); });
  }, { passive: true });

  function go(k) {
    k = Math.max(0, Math.min(n - 1, k));
    rail.scrollTo({ left: Math.min(maxX(), slides[k].offsetLeft - padL()), behavior: XE.reduced ? 'auto' : 'smooth' });
  }
  function step(d) {
    var r = range(), atEnd = rail.scrollLeft >= maxX() - 2;
    if (d > 0) go(atEnd ? 0 : r[0] + 1);
    else go(r[0] === 0 && rail.scrollLeft < 2 ? n - 1 : r[0] - 1);
  }

  /* ---- auto-advance ---- */
  var auto = !XE.reduced, onScreen = false, held = false, timer = null;
  function sync() {
    var run = auto && onScreen && !held && !document.hidden;
    if (run && timer === null) timer = setInterval(function () { step(1); }, 4200);
    if (!run && timer !== null) { clearInterval(timer); timer = null; }
    sec.classList.toggle('is-live', onScreen && !XE.reduced && !document.hidden);
    sec.classList.toggle('is-held', held);
  }
  function stopAuto() {
    if (!auto) return;
    auto = false; sync();
    if (play) { play.classList.add('is-paused'); play.setAttribute('aria-pressed', 'true'); }
  }
  function startAuto() {
    auto = true; sync();
    if (play) { play.classList.remove('is-paused'); play.setAttribute('aria-pressed', 'false'); }
  }

  if (XE.reduced && play) { play.hidden = true; auto = false; }
  if (play) XE.on(play, 'click', function () { auto ? stopAuto() : startAuto(); });
  XE.on(XE.$('[data-s06-prev]', sec), 'click', function () { stopAuto(); step(-1); });
  XE.on(XE.$('[data-s06-next]', sec), 'click', function () { stopAuto(); step(1); });

  XE.on(rail, 'keydown', function (e) {
    var k = e.key;
    if (k === 'ArrowRight') step(1);
    else if (k === 'ArrowLeft') step(-1);
    else if (k === 'Home') go(0);
    else if (k === 'End') go(n - 1);
    else return;
    e.preventDefault(); stopAuto();
  });
  /* a swipe, drag or sideways wheel is a manual move too */
  XE.on(rail, 'pointerdown', stopAuto);
  XE.on(rail, 'wheel', function (e) { if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) stopAuto(); }, { passive: true });

  /* hovering or focusing the rail or its controls holds everything in place */
  [rail, nav].forEach(function (el) {
    XE.on(el, 'mouseenter', function () { held = true; sync(); });
    XE.on(el, 'mouseleave', function () { held = false; sync(); });
    XE.on(el, 'focusin', function () { held = true; sync(); });
    XE.on(el, 'focusout', function (e) { if (!el.contains(e.relatedTarget)) { held = false; sync(); } });
  });

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (es) { onScreen = es[es.length - 1].isIntersecting; sync(); },
      { threshold: 0.3 }).observe(rail);
  } else { onScreen = true; }
  document.addEventListener('visibilitychange', sync);
  XE.on(window, 'resize', paint);
  paint(); sync();
})();
} catch (e) { console.error('[06-equip]', e); }

/* ===== 07-ai-design ===== */
try {
/* 07 — ai design bento: two live details only. The render rule runs while the
   studio card is on screen, and the routed model chip moves on a slow tick.
   The cards themselves are static — no hover lift, no parallax. */
(function () {
  'use strict';
  var sec = document.querySelector('.s07');
  if (!sec || !window.XE) return;

  /* the progress rule is a CSS animation parked at play-state:paused */
  var studio = XE.$('.s07-studio', sec);
  if (studio && !XE.reduced) {
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (es) {
        studio.classList.toggle('is-live', es[0].isIntersecting);
      }, { threshold: 0.2 }).observe(studio);
    } else {
      studio.classList.add('is-live');
    }
  }

  /* one model routed at a time; the elbow line under it goes blue with it */
  var app = XE.$('.s07-app', sec);
  var cols = XE.$$('.s07-app__col', sec);
  if (app && cols.length > 1 && !XE.reduced) {
    var i = 0;
    XE.liveTimer(app, 2600, function () {
      cols[i].classList.remove('is-on');
      i = (i + 1) % cols.length;
      cols[i].classList.add('is-on');
    });
  }

  /* the brand library walks its collections, and the asset rows restack */
  var lib = XE.$('.s07-lib', sec);
  if (lib && !XE.reduced) {
    var cs = XE.$$('.s07-lib__c', lib);
    var rows = XE.$$('.s07-lib__a', lib);
    var k = 0;
    XE.liveTimer(lib, 2400, function () {
      cs[k].classList.remove('is-on');
      k = (k + 1) % cs.length;
      cs[k].classList.add('is-on');
      rows.forEach(function (r, n) {
        r.classList.remove('is-fresh');
        void r.offsetWidth;
        r.style.animationDelay = (n * 70) + 'ms';
        r.classList.add('is-fresh');
      });
    });
  }

  /* the roadmap advances a phase at a time */
  var road = XE.$('.s07-road', sec);
  if (road && !XE.reduced) {
    var steps = XE.$$('.s07-road__step', road);
    var r = 0;
    XE.liveTimer(road, 2800, function () {
      steps[r].classList.remove('is-now');
      r = (r + 1) % steps.length;
      steps[r].classList.add('is-now');
      steps.forEach(function (s2, n) { s2.classList.toggle('is-done', n < r); });
    });
  }
})();
} catch (e) { console.error('[07-ai-design]', e); }

/* ===== 08-disciplines ===== */
try {
/* 08 — six disciplines. A static ARIA tablist. While the panel is on screen the
   active tab's rail fills (CSS) and, when it ends, hands on to the next tab. Any
   pointer, key or focus inside the panel — or a #d-<slug> deep link — stops that
   for good. Nothing auto-advances under reduced motion. */
(function () {
  'use strict';
  var sec = document.querySelector('.s08');
  if (!sec || !window.XE) return;

  var panel = XE.$('[data-s08-panel]', sec);
  var scroller = XE.$('[data-s08-scroller]', sec);
  var list = XE.$('[data-s08-track]', sec);
  var tabs = XE.$$('.s08__pill', list);
  var panes = XE.$$('.s08__pane', sec);
  var n = tabs.length;
  if (!n) return;

  var cur = 0, auto = false;
  var narrow = window.matchMedia('(max-width:900px)');

  function orient() {
    list.setAttribute('aria-orientation', narrow.matches ? 'horizontal' : 'vertical');
    /* the phone/tablet strip scrolls sideways: make the region itself reachable by keyboard */
    if (narrow.matches && scroller.scrollWidth > scroller.clientWidth + 1) scroller.setAttribute('tabindex', '0');
    else scroller.removeAttribute('tabindex');
  }
  orient();
  var ot = null;
  XE.on(window, 'resize', function () { clearTimeout(ot); ot = setTimeout(orient, 150); });
  if (narrow.addEventListener) narrow.addEventListener('change', function () { orient(); stop(); });

  /* keep the active pill in view inside the horizontal strip (phones) without moving the page */
  function reveal(k) {
    if (!narrow.matches) return;
    var t = tabs[k], l = t.offsetLeft - 16, r = t.offsetLeft + t.offsetWidth + 16;
    if (l < scroller.scrollLeft) scroller.scrollTo({ left: l, behavior: XE.reduced ? 'auto' : 'smooth' });
    else if (r > scroller.scrollLeft + scroller.clientWidth) scroller.scrollTo({ left: r - scroller.clientWidth, behavior: XE.reduced ? 'auto' : 'smooth' });
  }

  function show(k) {
    k = ((k % n) + n) % n;
    cur = k;
    tabs.forEach(function (t, x) {
      var on = x === k;
      t.classList.toggle('is-on', on);
      t.setAttribute('aria-selected', on ? 'true' : 'false');
      t.setAttribute('tabindex', on ? '0' : '-1');
    });
    panes.forEach(function (p, x) { p.classList.toggle('is-on', x === k); });
    reveal(k);
  }

  function stop() {
    if (!auto) return;
    auto = false;
    sec.classList.remove('is-auto');
    ['pointerdown', 'keydown', 'focusin'].forEach(function (ev) { panel.removeEventListener(ev, stop); });
  }

  tabs.forEach(function (t, k) {
    XE.on(t, 'click', function (e) { e.preventDefault(); stop(); show(k); });
    XE.on(t, 'keydown', function (e) {
      var key = e.key, j = -1;
      if (key === 'ArrowDown' || key === 'ArrowRight') j = k + 1;
      else if (key === 'ArrowUp' || key === 'ArrowLeft') j = k - 1;
      else if (key === 'Home') j = 0;
      else if (key === 'End') j = n - 1;
      else if (key === ' ' || key === 'Spacebar') { e.preventDefault(); stop(); show(k); return; }
      if (j === -1) return;
      e.preventDefault(); stop();
      j = ((j % n) + n) % n;
      show(j); tabs[j].focus();
    });
  });

  /* deep links from the nav mega-menu: #d-<slug> */
  var slugs = ['brand-design', 'technology-intelligence', 'campaign-content',
               'ai-design', 'product-experience', 'marketing-technology'];
  function fromHash(scroll) {
    var h = (location.hash || '').replace('#', '');
    if (h.indexOf('d-') !== 0) return false;
    var k = slugs.indexOf(h.slice(2));
    if (k < 0) return false;
    stop(); show(k);
    if (scroll) sec.scrollIntoView({ behavior: XE.reduced ? 'auto' : 'smooth', block: 'start' });
    return true;
  }
  XE.on(window, 'hashchange', function () { fromHash(true); });

  show(0);
  /* phones: panes change height, so never switch one under the reader */
  if (fromHash(false) || XE.reduced || narrow.matches) return;

  /* auto hand-on: the rail animation ending is the clock, so it pauses with the
     section off screen, the tab hidden, or the pointer resting on the panel */
  auto = true;
  sec.classList.add('is-auto');
  ['pointerdown', 'keydown', 'focusin'].forEach(function (ev) { panel.addEventListener(ev, stop); });
  XE.on(list, 'animationend', function (e) {
    if (auto && e.animationName === 's08-rail') show(cur + 1);
  });
  function live(on) { sec.classList.toggle('is-live', on && !document.hidden); }
  if ('IntersectionObserver' in window) {
    var vis = false;
    new IntersectionObserver(function (es) { vis = es[es.length - 1].isIntersecting; live(vis); },
      { threshold: 0.35 }).observe(panel);
    document.addEventListener('visibilitychange', function () { live(vis); });
  } else { live(true); }
})();
} catch (e) { console.error('[08-disciplines]', e); }

/* ===== 10-production ===== */
try {
/* 10 — the production strips. Without JS (and under reduced motion) they are static
   rows you can swipe. Otherwise this clones each strip once, adds .is-anim, and the
   drift plus the videos run only while the section is on screen and not paused.
   Videos keep preload="none" and their poster until then. */
(function () {
  'use strict';
  var sec = document.querySelector('.s10');
  if (!sec || !window.XE || XE.reduced) return;

  var rows = XE.$$('[data-s10-row]', sec);
  var btn = XE.$('[data-s10-pause]', sec);
  var SPEED = 26;                                   /* px per second */

  rows.forEach(function (row) {
    var track = XE.$('[data-s10-track]', row);
    XE.$$('.s10__c', track).forEach(function (c) {
      var k = c.cloneNode(true);
      k.setAttribute('aria-hidden', 'true');
      XE.$$('img', k).forEach(function (im) { im.loading = 'eager'; });   /* same files: served from cache */
      track.appendChild(k);
    });
  });
  sec.classList.add('is-anim');

  /* one set's width, measured after .is-anim drops the static padding */
  function measure() {
    rows.forEach(function (row) {
      var track = XE.$('[data-s10-track]', row);
      var half = track.scrollWidth / 2;
      track.style.setProperty('--s10-x', half + 'px');
      track.style.setProperty('--s10-dur', Math.round(half / SPEED) + 's');
    });
  }
  measure();
  var rt = null;
  XE.on(window, 'resize', function () { clearTimeout(rt); rt = setTimeout(measure, 150); });
  XE.$$('img', sec).forEach(function (im) { if (!im.complete) XE.on(im, 'load', measure, { once: true }); });

  var vids = XE.$$('[data-s10-v]', sec);
  var onScreen = false, paused = false;
  function sync() {
    var run = onScreen && !paused && !document.hidden;
    sec.classList.toggle('is-live', onScreen && !document.hidden);
    sec.classList.toggle('is-paused', paused);
    vids.forEach(function (v) {
      if (run) {
        if (v.preload !== 'auto') { v.preload = 'auto'; v.load(); }
        var pr = v.play();
        if (pr && pr.catch) pr.catch(function () {});
      } else if (!v.paused) { v.pause(); }
    });
  }

  if (btn) {
    btn.hidden = false;
    XE.on(btn, 'click', function () {
      paused = !paused;
      btn.setAttribute('aria-pressed', paused ? 'true' : 'false');
      sync();
    });
  }
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (es) { onScreen = es[es.length - 1].isIntersecting; sync(); },
      { threshold: 0.05 }).observe(sec);
  } else { onScreen = true; }
  document.addEventListener('visibilitychange', sync);
  sync();
})();
} catch (e) { console.error('[10-production]', e); }

/* ===== 12-process ===== */
try {
/* 12 — the three steps advance on a 6s dwell; clicking one pins it. */
(function () {
  'use strict';
  var panel = document.querySelector('[data-s12]');
  if (!panel || !window.XE) return;

  var steps = XE.$$('.s12__step', panel);
  var scenes = XE.$$('.s12__scene', panel);
  var i = 0, pinned = false, timer = null;

  function show(n) {
    i = ((n % steps.length) + steps.length) % steps.length;
    steps.forEach(function (s, k) {
      var on = k === i;
      s.classList.toggle('is-on', on);
      s.classList.remove('is-running');
      s.setAttribute('aria-selected', String(on));
      s.setAttribute('tabindex', on ? '0' : '-1');
    });
    scenes.forEach(function (s, k) { s.classList.toggle('is-on', k === i); });
    if (!pinned && !XE.reduced) {
      /* restart the dwell bar */
      void steps[i].offsetWidth;
      steps[i].classList.add('is-running');
    }
  }

  steps.forEach(function (s, k) {
    XE.on(s, 'click', function () { pinned = true; if (timer) timer.stop(); show(k); });
    XE.on(s, 'keydown', function (e) {
      var d = e.key === 'ArrowDown' || e.key === 'ArrowRight' ? 1
            : e.key === 'ArrowUp' || e.key === 'ArrowLeft' ? -1 : 0;
      if (!d) return;
      e.preventDefault();
      pinned = true; if (timer) timer.stop();
      show(k + d); steps[i].focus();
    });
  });

  show(0);
  if (!XE.reduced) {
    /* the ping only loops while the panel is on screen */
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (es) {
        panel.classList.toggle('is-live', es[0].isIntersecting);
      }, { threshold: 0 }).observe(panel);
    } else { panel.classList.add('is-live'); }
    timer = XE.liveTimer(panel, 6000, function () { if (!pinned) show(i + 1); });
    XE.on(panel, 'mouseenter', function () { if (timer) timer.stop(); });
    XE.on(panel, 'mouseleave', function () { if (!pinned && timer) timer.start(); });
  }
})();
} catch (e) { console.error('[12-process]', e); }

/* ===== 13-operation ===== */
try {
/* 13 — the two photographs drift a few pixels apart as the section passes. */
(function () {
  'use strict';
  var el = document.querySelector('[data-s13-collage]');
  if (!el || !window.XE || XE.reduced) return;
  if (!window.matchMedia('(pointer:fine)').matches) return;
  if (!window.matchMedia('(min-width:901px)').matches) return;

  var on = false, ticking = false;
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (es) { on = es[0].isIntersecting; if (on) tick(); },
      { threshold: 0 }).observe(el);
  } else { on = true; }

  function tick() {
    ticking = false;
    if (!on) return;
    var r = el.getBoundingClientRect();
    var p = (r.top + r.height / 2 - window.innerHeight / 2) / window.innerHeight; /* -1 … 1 */
    p = XE.clamp(p, -1, 1);
    el.style.setProperty('--p1', (p * 18).toFixed(1) + 'px');
    el.style.setProperty('--p2', (p * -18).toFixed(1) + 'px');
  }
  XE.on(window, 'scroll', function () {
    if (!ticking && on) { ticking = true; requestAnimationFrame(tick); }
  }, { passive: true });
  tick();
})();
} catch (e) { console.error('[13-operation]', e); }

/* ===== 15-testimonials ===== */
try {
/* 15 — the index in the sticky column. Each entry is a plain #s15-bN link (without JS it jumps to
   the row, whose panel the noscript rule already shows open); here it opens that row through the
   accordion's own button and keeps aria-current on the entry whose row is open. */
(function () {
  'use strict';
  var root = document.querySelector('.s15');
  if (!root || !window.XE) return;
  var links = XE.$$('[data-s15-go]', root);
  if (!links.length) return;
  var btns = links.map(function (a) { return document.getElementById('s15-b' + a.getAttribute('data-s15-go')); });

  function sync() {
    links.forEach(function (a, i) {
      if (btns[i] && btns[i].getAttribute('aria-expanded') === 'true') a.setAttribute('aria-current', 'true');
      else a.removeAttribute('aria-current');
    });
  }
  links.forEach(function (a, i) {
    XE.on(a, 'click', function (e) {
      var b = btns[i];
      if (!b) return;
      e.preventDefault();
      if (b.getAttribute('aria-expanded') !== 'true') b.click();
      b.focus({ preventScroll: true });
      var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
      b.scrollIntoView({ block: 'nearest', behavior: reduce ? 'auto' : 'smooth' });
    });
  });
  if ('MutationObserver' in window) {
    var mo = new MutationObserver(sync);
    btns.forEach(function (b) { if (b) mo.observe(b, { attributes: true, attributeFilter: ['aria-expanded'] }); });
  }
  sync();
})();
} catch (e) { console.error('[15-testimonials]', e); }

/* ===== 17-delivered ===== */
try {
/* 17 — case slider: arrows, keyboard, swipe, and a slow auto-advance. */
(function () {
  'use strict';
  var root = document.querySelector('[data-s17]');
  if (!root || !window.XE) return;

  var slides = XE.$$('[data-s17-slide]', root);
  var counter = XE.$('[data-s17-i]', root);
  var i = 0, stopped = false, timer = null;

  function show(n) {
    i = ((n % slides.length) + slides.length) % slides.length;
    slides.forEach(function (s, k) { s.classList.toggle('is-on', k === i); });
    if (counter) counter.textContent = ('0' + (i + 1)).slice(-2);
  }
  function halt() { stopped = true; if (timer) timer.stop(); }

  XE.on(XE.$('[data-s17-prev]', root), 'click', function () { halt(); show(i - 1); });
  XE.on(XE.$('[data-s17-next]', root), 'click', function () { halt(); show(i + 1); });
  XE.on(root, 'keydown', function (e) {
    if (e.key === 'ArrowRight') { halt(); show(i + 1); }
    if (e.key === 'ArrowLeft') { halt(); show(i - 1); }
  });

  /* swipe */
  var x0 = null;
  var vp = XE.$('.s17__viewport', root);
  XE.on(vp, 'pointerdown', function (e) { x0 = e.clientX; }, { passive: true });
  XE.on(vp, 'pointerup', function (e) {
    if (x0 === null) return;
    var dx = e.clientX - x0;
    x0 = null;
    if (Math.abs(dx) < 40) return;
    halt(); show(i + (dx < 0 ? 1 : -1));
  });

  show(0);
  if (!XE.reduced) {
    timer = XE.liveTimer(root, 7000, function () { if (!stopped) show(i + 1); });
  }
})();
} catch (e) { console.error('[17-delivered]', e); }

/* ===== 20-booking ===== */
try {
/* 20 — booking widget. Enhances the server-rendered calendar in 20-booking.php (which works
   on its own without JavaScript: days, month arrows and times are plain links there).
   Here: the grid re-renders in the visitor's own time zone as an ARIA grid with one roving tab
   stop (arrows, Home/End, PageUp/PageDown between six-week windows); the "next open days" shortcuts
   and the times become buttons, with a 12h/24h toggle; the
   form still POSTs to the contact page, with the chosen slot written at the top of the message.
   HOOK 1: AVAILABLE(date)   which days can be offered  — keep in step with 20-booking.php
   HOOK 2: SLOTS(date)       which times can be offered — keep in step with 20-booking.php
   Nothing here reserves anything; the UI never says a booking is confirmed. */
(function () {
  'use strict';
  var root = document.querySelector('[data-s20]');
  if (!root || !window.XE) return;

  var monthEl = XE.$('[data-s20-month]', root);
  var gridEl = XE.$('[data-s20-grid]', root);
  var daysEl = XE.$('[data-s20-days]', root);
  var timesEl = XE.$('[data-s20-times]', root);
  var dayLabel = XE.$('[data-s20-daylabel]', root);
  var form = XE.$('[data-s20-form]', root);
  var brief = XE.$('[data-s20-brief]', root);
  var errEl = XE.$('[data-s20-err]', root);
  var live = XE.$('[data-s20-live]', root);
  var prevM = XE.$('[data-s20-prevm]', root);
  var nextM = XE.$('[data-s20-nextm]', root);
  var backEl = XE.$('[data-s20-back]', root);
  var fmtG = XE.$('[data-s20-fmtg]', root);
  var endEl = XE.$('[data-s20-end]', root);

  var today = new Date(); today.setHours(0, 0, 0, 0);
  var selected = null, picked = null, h24 = false, focusDate = null;
  var tzName = '';

  /* with JS the times are the visitor's own; the no-JS label names the studios' zone instead */
  try { tzName = (Intl.DateTimeFormat().resolvedOptions().timeZone || '').replace(/_/g, ' '); } catch (e) {}
  XE.$('[data-s20-tz]', root).textContent = 'Your local time' + (tzName ? ' (' + tzName + ')' : '');

  /* HOOK 1 — weekdays, from two days out, inside the next twelve weeks */
  function AVAILABLE(d) {
    var day = d.getDay();
    if (day === 0 || day === 6) return false;
    var diff = Math.round((d - today) / 86400000);
    return diff >= 2 && diff <= 84;
  }
  /* HOOK 2 — 09:00–17:30, half-hourly, no 13:00 hour */
  function SLOTS() {
    var out = [];
    for (var m = 9 * 60; m <= 17 * 60 + 30; m += 30) {
      if (m >= 13 * 60 && m < 14 * 60) continue;
      out.push(m);
    }
    return out;
  }

  function addDays(d, n) { return new Date(d.getFullYear(), d.getMonth(), d.getDate() + n); }
  function ymd(d) { return d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2); }
  function parseYmd(s) {
    var m = /^(\d{4})-(\d{2})(?:-(\d{2}))?$/.exec(s || '');
    return m ? new Date(+m[1], +m[2] - 1, m[3] ? +m[3] : 1) : null;
  }
  /* the rolling six-week windows, as in 20-booking.php: window 0 starts on this week's Monday, each
     later one six weeks on; the last stops after the week holding the last bookable day */
  var mon0 = addDays(today, -((today.getDay() + 6) % 7));
  var lastDay = addDays(today, 84);
  while (!AVAILABLE(lastDay)) lastDay = addDays(lastDay, -1);
  function dayDiff(a, b) { return Math.round((b - a) / 86400000); }
  var wMax = Math.floor(dayDiff(mon0, lastDay) / 42);
  function wStart(k) { return addDays(mon0, 42 * k); }
  function wIdx(d) { return Math.max(0, Math.min(wMax, Math.floor(dayDiff(mon0, d) / 42))); }
  function gridDays(k) {
    var s = wStart(k), out = [];
    for (var i = 0; i < 42; i++) {
      var d = addDays(s, i);
      if (k === wMax && i % 7 === 0 && d > lastDay) break;
      out.push(d);
    }
    return out;
  }
  function openCount(k) { return gridDays(k).filter(AVAILABLE).length; }

  /* three-letter months, as PHP's 'M' writes them ("Sep", not en-GB's "Sept") */
  var MON = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  function fmtShort(d) { return MON[d.getMonth()]; }
  function fmtDM(d) { return d.getDate() + ' ' + fmtShort(d); }
  function fmtRange(days) {
    var a = days[0], b = days[days.length - 1];
    return fmtDM(a) + (a.getFullYear() === b.getFullYear() ? '' : ' ' + a.getFullYear()) + ' – ' + fmtDM(b) + ' ' + b.getFullYear();
  }
  function fmtDay(d) { return d.toLocaleDateString('en-GB', { weekday: 'long', day: 'numeric', month: 'long' }); }
  function fmtTime(mins) {
    var h = Math.floor(mins / 60), m = mins % 60;
    if (h24) return ('0' + h).slice(-2) + ':' + ('0' + m).slice(-2);
    return (h % 12 || 12) + ':' + ('0' + m).slice(-2) + (h < 12 ? 'am' : 'pm');
  }
  function sameDay(a, b) { return !!a && !!b && +a === +b; }

  /* ---- starting state: honour what the server rendered (a shared ?s20d= / ?s20w= link) ---- */
  var srvSel = parseYmd(root.getAttribute('data-s20-sel'));
  if (srvSel && AVAILABLE(srvSel)) selected = srvSel;
  var view = 0;   /* the window index */
  if (selected) view = wIdx(selected);
  else {
    var srvView = parseYmd(root.getAttribute('data-s20-view'));
    if (srvView) view = wIdx(srvView);
  }
  var srvPick = root.getAttribute('data-s20-pick');
  if (selected && srvPick !== '' && SLOTS(selected).indexOf(+srvPick) > -1) {
    picked = { date: new Date(selected), mins: +srvPick };
  }

  /* the no-JS slot line is written into the textarea; JS adds it on submit instead */
  if (/^Requested discovery call: /.test(brief.value)) brief.value = brief.value.replace(/^Requested discovery call: [^\n]*\n*/, '');

  /* the links become controls */
  gridEl.setAttribute('role', 'grid');
  fmtG.hidden = false;

  function setNav(a, target) {
    if (target) {
      a.setAttribute('href', '?s20w=' + target.k + '#book');
      a.removeAttribute('aria-disabled');
    } else {
      a.removeAttribute('href');
      a.setAttribute('aria-disabled', 'true');
    }
    a.setAttribute('role', 'button');
    a.tabIndex = target ? 0 : -1;
  }

  function renderMonth(focusIt) {
    var days = gridDays(view);
    monthEl.textContent = fmtRange(days);
    if (endEl) endEl.hidden = days.length === 42;   /* the last window is short: say why */
    setNav(prevM, view > 0 ? { k: view - 1 } : null);
    setNav(nextM, view < wMax ? { k: view + 1 } : null);

    /* the single tab stop: the focused day, else the selected one, else today/first open day in view */
    var inView = function (d) { return d && days.some(function (x) { return sameDay(x, d) && AVAILABLE(x); }); };
    var stop = inView(focusDate) ? focusDate : inView(selected) ? selected : (days.filter(AVAILABLE)[0] || null);
    focusDate = stop;

    daysEl.innerHTML = '';
    var tr;
    days.forEach(function (d, i) {
      if (i % 7 === 0) {
        tr = document.createElement('tr');
        /* a week with nothing bookable is drawn short */
        if (!days.slice(i, i + 7).some(AVAILABLE)) tr.className = 'is-quiet';
        daysEl.appendChild(tr);
      }
      var td = document.createElement('td');
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 's20__d';
      if (d.getDate() === 1) {
        /* the 1st carries its month, so the rolling grid shows where months turn */
        var mo = document.createElement('span');
        mo.className = 's20__mo'; mo.setAttribute('aria-hidden', 'true'); mo.textContent = fmtShort(d);
        b.appendChild(mo);
      }
      b.appendChild(document.createTextNode(String(d.getDate())));
      b.setAttribute('data-iso', ymd(d));
      var lab = fmtDay(d) + (sameDay(d, today) ? ', today' : '');
      if (sameDay(d, today)) b.classList.add('is-today');
      if (!AVAILABLE(d)) {
        b.disabled = true;
        b.classList.add('is-off');
        b.setAttribute('aria-label', lab + ', unavailable');
      } else {
        b.setAttribute('aria-label', lab);
      }
      var isSel = sameDay(d, selected);
      td.setAttribute('aria-selected', String(isSel));
      if (isSel) b.classList.add('is-sel');
      b.tabIndex = sameDay(d, stop) ? 0 : -1;
      td.appendChild(b);
      tr.appendChild(td);
    });
    if (focusIt && stop) {
      var fb = XE.$('[data-iso="' + ymd(stop) + '"]', daysEl);
      if (fb) fb.focus();
    }
  }

  function renderTimes() {
    form.hidden = true; timesEl.hidden = false; errEl.hidden = true;
    timesEl.innerHTML = '';
    if (!selected) {
      dayLabel.textContent = 'Pick a day';
      var p = document.createElement('p');
      p.className = 's20__empty';
      p.textContent = 'Choose a day to see open times.';
      timesEl.appendChild(p);
      /* the next few open days as shortcuts, so the column is never an empty panel */
      var sl = document.createElement('p');
      sl.className = 's20__soonl'; sl.id = 's20-soon'; sl.textContent = 'Next open days';
      timesEl.appendChild(sl);
      var su = document.createElement('ul');
      su.className = 's20__soon'; su.setAttribute('aria-labelledby', 's20-soon');
      for (var d = new Date(today), n = 0; n < 4 && d <= lastDay; d = addDays(d, 1)) {
        if (!AVAILABLE(d)) continue;
        n++;
        var li = document.createElement('li');
        var qb = document.createElement('button');
        qb.type = 'button'; qb.className = 's20__qd';
        qb.setAttribute('data-iso', ymd(d));
        qb.setAttribute('aria-label', fmtDay(d) + ' — choose this day');
        var wd = document.createElement('span');
        wd.textContent = d.toLocaleDateString('en-GB', { weekday: 'short' });
        qb.appendChild(wd);
        qb.appendChild(document.createTextNode(' ' + fmtDM(d)));
        li.appendChild(qb); su.appendChild(li);
      }
      timesEl.appendChild(su);
      return;
    }
    dayLabel.textContent = fmtDay(selected);
    var ul = document.createElement('ul');
    ul.className = 's20__tlist';
    ul.setAttribute('aria-label', 'Open times, ' + fmtDay(selected));
    SLOTS(selected).forEach(function (mins) {
      var li = document.createElement('li');
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 's20__time';
      b.textContent = fmtTime(mins);
      b.setAttribute('data-mins', String(mins));
      li.appendChild(b);
      ul.appendChild(li);
    });
    timesEl.appendChild(ul);
  }

  function showForm(focusIt) {
    timesEl.hidden = true; form.hidden = false;
    dayLabel.textContent = fmtDay(picked.date);
    /* no-break before the dot, so a wrap never starts a line with it */
    XE.$('[data-s20-picked]', root).textContent = fmtDay(picked.date) + ' · ' + fmtTime(picked.mins);
    if (focusIt) {
      var first = XE.$('[data-book-first]', form);
      if (first) first.focus({ preventScroll: true });
    }
  }

  function choose(d) {
    selected = d; focusDate = d; picked = null; view = wIdx(d);
    renderMonth(true); renderTimes();
    live.textContent = fmtDay(selected) + ' selected. ' + SLOTS(selected).length + ' open times.';
  }

  XE.on(daysEl, 'click', function (e) {
    var b = e.target.closest('.s20__d');
    if (!b || b.disabled) return;
    choose(parseYmd(b.getAttribute('data-iso')));
  });

  XE.on(daysEl, 'keydown', function (e) {
    var b = e.target.closest('.s20__d');
    if (!b) return;
    var cur = parseYmd(b.getAttribute('data-iso'));
    var col = (cur.getDay() + 6) % 7;
    var step = { ArrowRight: 1, ArrowLeft: -1, ArrowDown: 7, ArrowUp: -7 }[e.key];
    var target = null;
    if (step) {
      /* move by the step, skipping unavailable days, stopping at the bookable range */
      var t = addDays(cur, step), guard = 0;
      while (!AVAILABLE(t) && guard++ < 90) t = addDays(t, step > 0 ? 1 : -1);
      target = AVAILABLE(t) ? t : null;
    } else if (e.key === 'Home' || e.key === 'End') {
      var row = addDays(cur, e.key === 'Home' ? -col : 6 - col), dir = e.key === 'Home' ? 1 : -1;
      for (var k = 0; k < 7 && !AVAILABLE(row); k++) row = addDays(row, dir);
      target = AVAILABLE(row) ? row : null;
    } else if (e.key === 'PageDown' || e.key === 'PageUp') {
      var nv = view + (e.key === 'PageDown' ? 1 : -1);
      if (nv < 0 || nv > wMax) { e.preventDefault(); return; }
      view = nv; focusDate = null;
      e.preventDefault();
      renderMonth(true);
      return;
    } else return;
    e.preventDefault();
    if (!target) return;
    focusDate = target;
    var inGrid = gridDays(view).some(function (x) { return sameDay(x, target); });
    if (!inGrid) view = wIdx(target);
    renderMonth(true);
  });

  XE.on(timesEl, 'click', function (e) {
    var q = e.target.closest('.s20__qd');
    if (q) { e.preventDefault(); choose(parseYmd(q.getAttribute('data-iso'))); return; }
    var b = e.target.closest('.s20__time');
    if (!b) return;
    e.preventDefault();
    picked = { date: new Date(selected), mins: +b.getAttribute('data-mins') };
    showForm(true);
    live.textContent = 'Time selected: ' + fmtTime(picked.mins) + '. Complete the form to send your request.';
  });

  /* 12h / 24h: a radio group — arrows move and select, one tab stop */
  var fmtBtns = XE.$$('[data-s20-fmt]', root);
  function setFmt(b, focusIt) {
    h24 = b.getAttribute('data-s20-fmt') === '24';
    fmtBtns.forEach(function (o) {
      var on = o === b;
      o.classList.toggle('is-on', on);
      o.setAttribute('aria-checked', String(on));
      o.tabIndex = on ? 0 : -1;
    });
    if (focusIt) b.focus();
    if (!form.hidden && picked) showForm(false); else renderTimes();
  }
  fmtBtns.forEach(function (b, i) {
    XE.on(b, 'click', function () { setFmt(b, false); });
    XE.on(b, 'keydown', function (e) {
      if (['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].indexOf(e.key) < 0) return;
      e.preventDefault();
      setFmt(fmtBtns[(i + 1) % fmtBtns.length], true);
    });
  });

  function monthNav(a, dir) {
    XE.on(a, 'click', function (e) {
      e.preventDefault();
      if (a.getAttribute('aria-disabled') === 'true') return;
      view = Math.max(0, Math.min(wMax, view + dir));
      focusDate = null;
      renderMonth(false);
      live.textContent = monthEl.textContent + ', ' + openCount(view) + ' days open.';
    });
    XE.on(a, 'keydown', function (e) {
      if (e.key === ' ') { e.preventDefault(); a.click(); }
    });
  }
  monthNav(prevM, -1);
  monthNav(nextM, 1);

  XE.on(backEl, 'click', function (e) {
    e.preventDefault();
    picked = null;
    renderTimes();
    var first = XE.$('.s20__time', timesEl);
    if (first) first.focus({ preventScroll: true });
  });

  XE.on(form, 'submit', function (e) {
    var f = new FormData(form);
    var name = (f.get('name') || '').toString().trim();
    var email = (f.get('email') || '').toString().trim();
    var text = brief.value.trim();

    var problems = [];
    if (name.length < 2) problems.push('your name');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email)) problems.push('a valid work email');
    if (!text) problems.push('a line about what you are building');
    if (problems.length || !picked) {
      e.preventDefault();
      errEl.hidden = false;
      errEl.textContent = picked ? 'Please add ' + problems.join(', ') + '.' : 'Choose a day and a time first.';
      return;
    }
    errEl.hidden = true;

    /* the slot goes at the top of the contact form's own message field */
    var when = fmtDay(picked.date) + ' at ' + fmtTime(picked.mins) + (tzName ? ' (' + tzName + ')' : ' (my local time)');
    var hid = XE.$('[data-s20-msg]', form);
    if (!hid) {
      hid = document.createElement('input');
      hid.type = 'hidden'; hid.name = 'message'; hid.setAttribute('data-s20-msg', '');
      form.appendChild(hid);
    }
    hid.value = 'Requested discovery call: ' + when + '\n\n' + text;
    brief.removeAttribute('name');   /* one message field reaches the contact page */
    live.textContent = 'Sending your request to the contact page. Nothing is reserved yet.';
  });

  /* coming back from the contact page (back/forward cache): restore the textarea's name */
  window.addEventListener('pageshow', function () {
    brief.setAttribute('name', 'message');
    var hid = XE.$('[data-s20-msg]', form);
    if (hid) hid.parentNode.removeChild(hid);
  });

  renderMonth(false);
  if (picked) showForm(false); else renderTimes();
})();
} catch (e) { console.error('[20-booking]', e); }

/* ===== 22-final-cta ===== */
try {
/* 22 — the orbit dots only travel while the band is on screen and the tab is
   visible. Everything else in the section is CSS. */
(function () {
  'use strict';
  var sec = document.querySelector('.s22');
  if (!sec || !window.XE || XE.reduced) return;
  if (!('IntersectionObserver' in window)) { sec.classList.add('is-live'); return; }
  new IntersectionObserver(function (es) {
    sec.classList.toggle('is-live', es[0].isIntersecting && !document.hidden);
  }, { threshold: 0 }).observe(sec);
  document.addEventListener('visibilitychange', function () {
    if (document.hidden) sec.classList.remove('is-live');
  });
})();
} catch (e) { console.error('[22-final-cta]', e); }

/* ===== 23-brand ===== */
try {
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
} catch (e) { console.error('[23-brand]', e); }

/* ===== 24-technology ===== */
try {
/* 24 — Technology & Intelligence: "the system diagram".
   The HTML is the finished, readable state: every capability is a node linking to its detail, and the
   framework rows are plain content. Here:
   · .is-js at once, so the details share one reserved cell (no shift) and the hint shows;
   · choosing a node (click, Enter, focus, or hover on hover-capable devices) opens its detail in place;
   · framework rows become toggle buttons that light the capabilities built to each, in the diagram
     and in a readout of fixed height directly above the rows (so nothing moves under the pointer);
   · one faint pulse per stratum while on screen (BDH.live); nothing moves under reduced motion.
   hub.js (window.BDH) loads after sections.js, so init waits for DOMContentLoaded. */
(function () {
  'use strict';
  var root = document.querySelector('.s24');
  if (!root) return;
  root.classList.add('is-js');

  function $$(sel, el) { return Array.prototype.slice.call((el || root).querySelectorAll(sel)); }

  function init() {
    var BDH = window.BDH;
    var sys = root.querySelector('[data-s24]');
    var dets = root.querySelector('.s24__dets');
    if (!sys || !dets) return;
    var R = BDH ? !!BDH.reduced : window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (BDH) BDH.live(sys, 0.15);

    var nodes = $$('[data-s24-node]');
    var active = null;   // the framework key currently pressed
    var current = null;

    function markBadges() {
      $$('.s24__stds > .xt-badge').forEach(function (b) {
        b.classList.toggle('is-hit', !!active && b.classList.contains('s24__std-' + active));
      });
    }

    function select(slug) {
      if (!slug || slug === current) return;
      current = slug;
      nodes.forEach(function (n) {
        var on = n.getAttribute('data-s24-node') === slug;
        n.classList.toggle('is-on', on);
        if (on) n.setAttribute('aria-current', 'true'); else n.removeAttribute('aria-current');
      });
      $$('.s24__det').forEach(function (d) { d.classList.toggle('is-on', d.id === 's24-d-' + slug); });
    }

    var canHover = window.matchMedia('(hover: hover) and (pointer: fine)');
    var hoverT = null;
    nodes.forEach(function (n) {
      var slug = n.getAttribute('data-s24-node');
      n.addEventListener('click', function (e) {
        e.preventDefault();
        select(slug);
        /* on narrow screens the detail sits below the diagram: bring it into view if it is off screen */
        var r = dets.getBoundingClientRect();
        if (r.top > window.innerHeight - 120) dets.scrollIntoView({ behavior: R ? 'auto' : 'smooth', block: 'nearest' });
      });
      n.addEventListener('focus', function () { select(slug); });
      n.addEventListener('pointerenter', function () {
        if (!canHover.matches) return;
        clearTimeout(hoverT);
        hoverT = setTimeout(function () { select(slug); }, 90);
      });
      n.addEventListener('pointerleave', function () { clearTimeout(hoverT); });
    });

    var first = nodes.filter(function (n) { return n.classList.contains('is-on'); })[0] || nodes[0];
    var fromHash = location.hash.indexOf('#s24-d-') === 0 ? location.hash.slice(7) : null;
    select(fromHash && root.querySelector('#s24-d-' + fromHash) ? fromHash : first.getAttribute('data-s24-node'));

    /* ---------- frameworks index: rows become toggle buttons --------------- */
    var read = root.querySelector('[data-s24-read]');
    var rows = $$('.s24__fr');
    var fbs = [];
    rows.forEach(function (li) {
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 's24__fb';
      b.setAttribute('aria-pressed', 'false');
      while (li.firstChild) b.appendChild(li.firstChild);
      li.appendChild(b);
      li.classList.add('is-up');
      b.s24key = li.getAttribute('data-s24-std');
      b.s24code = li.getAttribute('data-code');
      fbs.push(b);
    });

    function hitsFor(key) {
      return nodes.filter(function (n) { return (' ' + n.getAttribute('data-std') + ' ').indexOf(' ' + key + ' ') > -1; });
    }
    var caps = $$('[data-s24-cap]');
    var capList = root.querySelector('.s24__fwc');
    function paintRead(key) {
      if (!read) return;
      read.textContent = '';
      if (!key) { read.textContent = 'Choose a framework to light the capabilities built to it.'; return; }
      var b = fbs.filter(function (f) { return f.s24key === key; })[0];
      var hits = hitsFor(key);
      var code = document.createElement('b');
      code.textContent = b ? b.s24code : key;
      read.appendChild(code);
      read.appendChild(document.createTextNode(' — ' + hits.length + ' of ' + nodes.length + ' capabilities are built to it'));
      var names = document.createElement('span');
      names.className = 'sr';
      names.textContent = ': ' + hits.map(function (n) { return n.querySelector('.s24__nn').textContent; }).join(', ');
      read.appendChild(names);
      read.appendChild(document.createTextNode('.'));
    }
    /* reserve the tallest sentence, so pressing a framework never moves the rows under the pointer */
    function reserve() {
      if (!read) return;
      read.style.minHeight = '';
      var max = 0;
      [null].concat(fbs.map(function (f) { return f.s24key; })).forEach(function (k) {
        paintRead(k); max = Math.max(max, read.offsetHeight);
      });
      read.style.minHeight = max + 'px';
      paintRead(active);
    }

    function apply(key) {
      active = key;
      fbs.forEach(function (b) { b.setAttribute('aria-pressed', b.s24key === key ? 'true' : 'false'); });
      var hits = key ? hitsFor(key) : [];
      nodes.forEach(function (n) { n.classList.toggle('is-hit', hits.indexOf(n) > -1); });
      sys.classList.toggle('is-filter', !!key);
      if (capList) capList.classList.toggle('is-filter', !!key);
      var hitSlugs = hits.map(function (n) { return n.getAttribute('data-s24-node'); });
      caps.forEach(function (c) { c.classList.toggle('is-hit', hitSlugs.indexOf(c.getAttribute('data-s24-cap')) > -1); });
      markBadges();
      paintRead(key);
    }
    fbs.forEach(function (b) {
      b.addEventListener('click', function () { apply(active === b.s24key ? null : b.s24key); });
    });
    reserve();
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(reserve);
    window.addEventListener('load', reserve);
    var rt = null;
    window.addEventListener('resize', function () { clearTimeout(rt); rt = setTimeout(reserve, 150); });

    /* show all frameworks (the list is cut to eight up to 1180px) */
    var all = root.querySelector('.s24__all');
    var fwl = root.querySelector('.s24__fwl');
    if (all && fwl) {
      all.hidden = false;
      var label = all.textContent;
      all.addEventListener('click', function () {
        var open = !fwl.classList.contains('is-open');
        fwl.classList.toggle('is-open', open);
        all.setAttribute('aria-expanded', open ? 'true' : 'false');
        all.textContent = open ? 'Show fewer frameworks' : label;
      });
    }
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
} catch (e) { console.error('[24-technology]', e); }

/* ===== 25-offer ===== */
try {
/* 25 — Offer: the brief builder.
   The HTML is a complete POST form without this file: each discipline is a native <details>, the
   comparison table is open, and every control is real. This adds:
   · ≥769px: the six <details> become one tablist (summaries hidden, the chosen one open, the tallest
     discipline's height reserved so switching never jumps). ≤768px: an exclusive accordion, closed.
   · the right set of package radios (table ≥769px, cards ≤768px); the other set is disabled so it
     neither submits nor takes focus, and the choice carries across when the width changes.
   · pick counts, the brief bar (sticky once something is picked), and a "Likely fit" read from the
     ticked services' typical lengths, offered as a button in the bar.
   window.BDH loads after the bundled sections.js, so init waits for DOMContentLoaded. */
(function () {
  'use strict';

  function init() {
    var root = document.querySelector('[data-s25]');
    if (!root || !window.XE) return;
    var XE = window.XE;
    var R = !!XE.reduced;
    var $ = function (s) { return XE.$(s, root); };
    var $$ = function (s) { return XE.$$(s, root); };
    var form = $('[data-s25-form]');
    if (!form) return;

    var tablist = $('[data-s25-tabs]');
    var tabs = $$('[data-s25-tab]');
    var discs = $$('[data-s25-disc]');
    var svcs = $$('[data-s25-svc]');
    var radios = $$('[data-s25-pkg]');
    var cmpd = $('[data-s25-cmpd]');
    var cmp = $('[data-s25-cmp]');
    var fits = $$('[data-s25-fit]');
    var fitNote = $('[data-s25-fitnote]');
    var send = $('[data-s25-send]');
    var countEl = $('[data-s25-count]');
    var pkEl = $('[data-s25-pkname]');
    var namesEl = $('[data-s25-names]');
    var fitBtn = $('[data-s25-fitbtn]');
    var fitName = $('[data-s25-fitname]');
    var clearBtn = $('[data-s25-clear]');
    var live = $('[data-s25-live]');
    var mq = window.matchMedia('(min-width: 769px)');
    var wide = null;
    var cur = Math.max(0, discs.findIndex(function (d) { return d.open; }));

    root.classList.add('is-js');

    /* ---------------- disciplines: tabs (wide) or accordion (narrow) ---------------- */
    function openOnly(i) {
      discs.forEach(function (d, n) { if (n !== i && d.open) d.open = false; });
      if (!discs[i].open) discs[i].open = true;
    }
    function selectTab(i, focus) {
      cur = i;
      tabs.forEach(function (t, n) {
        var on = n === i;
        t.setAttribute('aria-selected', on ? 'true' : 'false');
        t.setAttribute('tabindex', on ? '0' : '-1');
      });
      if (wide) openOnly(i);
      if (focus && tabs[i]) tabs[i].focus();
    }
    tabs.forEach(function (t, n) {
      XE.on(t, 'click', function () { selectTab(n, false); });
      XE.on(t, 'keydown', function (e) {
        var k = e.key, j = -1;
        if (k === 'ArrowRight' || k === 'ArrowDown') j = n + 1;
        else if (k === 'ArrowLeft' || k === 'ArrowUp') j = n - 1;
        else if (k === 'Home') j = 0;
        else if (k === 'End') j = tabs.length - 1;
        if (j === -1) return;
        e.preventDefault();
        selectTab((j + tabs.length) % tabs.length, true);
      });
    });
    /* in accordion mode, keep the tab selection in step with whichever discipline was opened */
    discs.forEach(function (d, n) {
      XE.on(d, 'toggle', function () { if (!wide && d.open) { cur = n; selectTab(n, false); } });
    });

    /* reserve the tallest discipline's height so tab switches never move the page */
    function reserve() {
      if (!wide) { root.style.removeProperty('--s25-h'); return; }
      var keep = cur, max = 0;
      root.style.setProperty('--s25-h', '0px');
      discs.forEach(function (d, n) {
        openOnly(n);
        max = Math.max(max, d.getBoundingClientRect().height);
      });
      openOnly(keep);
      root.style.setProperty('--s25-h', Math.ceil(max) + 'px');
    }

    function mode() {
      var w = mq.matches;
      if (w === wide) return;
      var first = wide === null;
      wide = w;
      root.classList.toggle('is-tabs', w);
      if (tablist) tablist.hidden = !w;
      discs.forEach(function (d, n) {
        var body = d.querySelector('.s25-disc__b');
        if (!body) return;
        if (w) {
          body.setAttribute('role', 'tabpanel');
          body.setAttribute('aria-labelledby', tabs[n].id);
          body.setAttribute('tabindex', '0');
        } else {
          body.removeAttribute('role'); body.removeAttribute('aria-labelledby'); body.removeAttribute('tabindex');
        }
      });
      if (w) selectTab(cur, false);
      else if (first) discs.forEach(function (d) { d.open = false; });   // phones start folded: six clear rows

      /* package radios: exactly one visible set is live */
      var chosen = radios.filter(function (r) { return r.checked; })[0];
      var val = chosen ? chosen.value : '';
      var set = w ? 'table' : 'cards';
      radios.forEach(function (r) {
        var s = r.getAttribute('data-s25-set');
        if (s) r.disabled = s !== set;
      });
      radios.forEach(function (r) {
        if (!r.disabled && r.value === val) r.checked = true;
      });
      if (cmpd) cmpd.open = w;   // phones: the full table folds under "Compare all six in detail"
      reserve();
      edge();
      sync(false);
    }

    /* ---------------- the table's right-edge fade: only while there is more to scroll ---------------- */
    function edge() {
      if (!cmp) return;
      cmp.classList.toggle('is-end', cmp.scrollLeft + cmp.clientWidth >= cmp.scrollWidth - 2);
    }
    XE.on(cmp, 'scroll', edge, { passive: true });

    /* ---------------- likely fit ----------------
       Squad when a team offer is ticked; Enterprise only for 4+ disciplines with a service over
       12 weeks; Retainer for ongoing work; then by size (longest and summed typical weeks), not by
       count: small → Sprint, up to 12 weeks → Project, longer → Milestone. */
    function weeks(t) {
      var hi = 0, m, re = /(\d+)(?:\s*[–-]\s*(\d+))?\s*weeks?/gi;
      while ((m = re.exec(t))) hi = Math.max(hi, parseInt(m[2] || m[1], 10));
      return hi;
    }
    function isRun(t) { return /ongoing|monthly|then|start in|cycles/i.test(t); }
    function suggest(picked) {
      if (!picked.length) return '';
      var ds = {}, nd = 0, hi = 0, sum = 0, run = false, team = false;
      picked.forEach(function (el) {
        var t = el.getAttribute('data-time') || '', d = el.getAttribute('data-d'), w = weeks(t);
        if (!ds[d]) { ds[d] = 1; nd++; }
        if (isRun(t)) run = true;
        hi = Math.max(hi, w); sum += w;
        if (/squad|engineers-by-role/.test(el.value)) team = true;
      });
      if (team) return 'squad';
      if (nd >= 4 && hi > 12) return 'enterprise';
      if (run) return 'retainer';
      if (hi <= 3 && sum <= 6) return 'sprint';
      if (hi <= 12) return 'project';
      return 'milestone';
    }

    function live1() { return radios.filter(function (r) { return !r.disabled; }); }
    function nameOf(key) {
      var r = radios.filter(function (x) { return x.value === key; })[0];
      return r ? r.getAttribute('data-name') : '';
    }

    var lastMsg = '', fitKey = '';
    function sync(announce) {
      var picked = svcs.filter(function (el) { return el.checked; });
      var pk = live1().filter(function (r) { return r.checked; })[0];
      var pkKey = pk ? pk.value : '';
      var pkName = pkKey ? pk.getAttribute('data-name') : 'Not sure yet';

      /* per-discipline counts, on tabs and summaries */
      $$('[data-s25-pick]').forEach(function (b) {
        var d = b.getAttribute('data-s25-pick');
        var n = picked.filter(function (el) { return el.getAttribute('data-d') === d; }).length;
        b.hidden = !n;
        b.querySelector('[data-s25-pickn]').textContent = n ? String(n) : '';
        b.querySelector('[data-s25-picksr]').textContent = n ? ', ' + n + ' ticked' : '';
      });

      if (cmp) { if (pkKey) cmp.setAttribute('data-pkg', pkKey); else cmp.removeAttribute('data-pkg'); }

      fitKey = suggest(picked);
      fits.forEach(function (f) { f.hidden = f.closest('[data-col]').getAttribute('data-col') !== fitKey; });
      if (fitNote) fitNote.hidden = !fitKey;
      fitBtn.hidden = !fitKey || fitKey === pkKey;
      fitName.textContent = fitKey ? nameOf(fitKey) : '';

      var nd = {};
      picked.forEach(function (el) { nd[el.getAttribute('data-d')] = 1; });
      var ndc = Object.keys(nd).length;
      countEl.textContent = picked.length
        ? (picked.length < 10 ? '0' : '') + picked.length + (picked.length === 1 ? ' service' : ' services') + (ndc > 1 ? ' · ' + ndc + ' disciplines' : '')
        : 'None ticked yet';
      pkEl.textContent = pkName;
      var names = picked.map(function (el) { return el.getAttribute('data-name'); });
      namesEl.hidden = !names.length;
      namesEl.textContent = names.length > 2 ? names.slice(0, 2).join(', ') + ' and ' + (names.length - 2) + ' more' : names.join(', ');
      clearBtn.hidden = !picked.length && !pkKey;
      root.classList.toggle('has-picks', !!(picked.length || pkKey));

      if (announce) {
        var msg = (picked.length ? picked.length + (picked.length === 1 ? ' service' : ' services') + ' in your brief' : 'No services in your brief')
          + '. Contract: ' + pkName + '.' + (fitKey && fitKey !== pkKey ? ' Likely fit: ' + nameOf(fitKey) + '.' : '');
        if (msg !== lastMsg) { live.textContent = msg; lastMsg = msg; }
      }
    }

    function bump() {
      if (!send || R) return;
      send.classList.remove('is-bump'); void send.offsetWidth; send.classList.add('is-bump');
    }

    svcs.forEach(function (el) { XE.on(el, 'change', function () { sync(true); bump(); }); });
    radios.forEach(function (el) { XE.on(el, 'change', function () { sync(true); }); });

    /* Bring el into view by the least movement: clear of the fixed nav above and the sticky bar
       below, and — for a table column — inside the table's own scroller, past the sticky row heads. */
    function reveal(el) {
      if (!el) return;
      var beh = R ? 'auto' : 'smooth';
      if (cmp && cmp.contains(el)) {
        var head = cmp.querySelector('.s25-tbl__h0');
        var cr = cmp.getBoundingClientRect(), er = el.getBoundingClientRect();
        var left = cr.left + (head ? head.offsetWidth : 0);
        var dx = er.left < left ? er.left - left : (er.right > cr.right ? er.right - cr.right : 0);
        if (dx) cmp.scrollBy({ left: dx, behavior: beh });
      }
      var r = el.getBoundingClientRect();
      var top = 96;                                                       // the floating nav
      var bottom = window.innerHeight - (send ? send.offsetHeight + 24 : 24);
      var dy = r.top < top ? r.top - top : (r.bottom > bottom ? Math.min(r.bottom - bottom, r.top - top) : 0);
      if (dy) window.scrollBy({ top: dy, behavior: beh });
    }

    /* "Likely fit" in the bar: choose it and reveal its column or card. Focus moves to Continue,
       since the button itself hides once its suggestion is chosen. */
    XE.on(fitBtn, 'click', function () {
      if (!fitKey) return;
      var r = live1().filter(function (x) { return x.value === fitKey; })[0];
      if (!r) return;
      r.checked = true;
      reveal(wide ? r.closest('th') : r.closest('.s25-card'));
      sync(true);
      edge();
      fitBtn.hidden = true;
      var go = form.querySelector('.s25-send__btn');
      if (go) go.focus({ preventScroll: true });
    });

    XE.on(clearBtn, 'click', function () {
      svcs.forEach(function (el) { el.checked = false; });
      radios.forEach(function (el) { el.checked = el.value === ''; });
      sync(true);
      var t = wide ? tabs[cur] : discs[cur] && discs[cur].querySelector('summary');
      if (t) t.focus({ preventScroll: true });
    });

    /* back from the contact page: the browser may restore ticked boxes */
    window.addEventListener('pageshow', function () { sync(false); });
    var rt = null;
    window.addEventListener('resize', function () {
      clearTimeout(rt);
      rt = setTimeout(function () { mode(); reserve(); edge(); }, 150);
    });
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { reserve(); edge(); });

    mode();
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
} catch (e) { console.error('[25-offer]', e); }
