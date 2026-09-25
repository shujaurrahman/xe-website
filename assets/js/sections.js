/* ===== 01-hero ===== */
/* 01 — the floating work drifts with the pointer; everything fades in once. */
(function () {
  'use strict';
  var sec = document.querySelector('.s01');
  if (!sec || !window.XE) return;

  /* reveal + start the ambient loops */
  requestAnimationFrame(function () { sec.classList.add('is-in'); });
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

/* ===== 02-showcase ===== */
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
    if (pinned) return;
    var forward = i === 0;
    toggle.classList.add(forward ? 'is-travel' : 'is-back');
    t1 = setTimeout(function () {
      if (pinned) return;
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
  if (!XE.reduced) {
    sec.classList.add('is-live');
    XE.inView(sec, function () { t2 = setTimeout(travel, 2200); });
  }
})();

/* ===== 03-industries ===== */
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
    tabs.forEach(function (t, k) {
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

/* ===== 05-flow ===== */
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

/* ===== 06-equip ===== */
/* 06 — the rail loops for ever; the arrows nudge it and hovering holds it. */
(function () {
  'use strict';
  var sec = document.querySelector('.s06');
  if (!sec || !window.XE) return;
  var track = XE.$('[data-s06-track]', sec);
  if (!track) return;

  /* core's marquee has already cloned the cards for a seamless -50% loop */
  var paused = false, nudge = 0;
  function hold(on) {
    paused = on;
    track.style.animationPlayState = on ? 'paused' : 'running';
    track.classList.toggle('is-held', on);
  }
  /* the loop only holds while the pointer is on a card — not the whole section */
  XE.$$('.s06__card', track).forEach(function (card) {
    XE.on(card, 'mouseenter', function () { hold(true); });
    XE.on(card, 'mouseleave', function () { hold(false); });
    XE.on(card, 'focusin', function () { hold(true); });
    XE.on(card, 'focusout', function () { hold(false); });
  });

  function step(dir) {
    nudge += dir * 344;                       /* one card + gap */
    track.style.transform = 'translate3d(' + (-nudge % (track.scrollWidth / 2)) + 'px,0,0)';
    hold(true);
    clearTimeout(step.t);
    step.t = setTimeout(function () { track.style.transform = ''; hold(false); nudge = 0; }, 2600);
  }
  XE.on(XE.$('[data-s06-prev]', sec), 'click', function () { step(-1); });
  XE.on(XE.$('[data-s06-next]', sec), 'click', function () { step(1); });
})();

/* ===== 07-ai-design ===== */
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

/* ===== 08-disciplines ===== */
/* 08 — the discipline list drifts for ever. Whichever pill is crossing the
   centre line is the active one, and it drives the panel on the right. */
(function () {
  'use strict';
  var sec = document.querySelector('.s08');
  if (!sec || !window.XE) return;

  var panel = XE.$('.s08__panel', sec);
  var scroller = XE.$('.s08__scroller', sec);
  var track = XE.$('[data-s08-track]', sec);
  var pills = XE.$$('.s08__pill', track);
  var panes = XE.$$('.s08__pane', sec);
  var n = pills.length;
  if (!n) return;

  var desktop = window.matchMedia('(min-width:901px)');
  var cur = -1, pinned = false, raf = null;

  /* a second copy so the -50% loop is seamless */
  pills.forEach(function (p) {
    var c = p.cloneNode(true);
    c.setAttribute('aria-hidden', 'true');
    c.setAttribute('tabindex', '-1');
    c.removeAttribute('id');
    c.removeAttribute('role');
    track.appendChild(c);
  });
  var all = XE.$$('.s08__pill', track);

  function paint(k) {
    if (k === cur) return;
    cur = k;
    all.forEach(function (p, x) { p.classList.toggle('is-on', (x % n) === k); });
    pills.forEach(function (p, x) {
      p.setAttribute('aria-selected', String(x === k));
      p.setAttribute('tabindex', x === k ? '0' : '-1');
    });
    panes.forEach(function (p, x) { p.classList.toggle('is-on', x === k); });
  }

  /* read the pill nearest the centre of the column */
  function watch() {
    raf = null;
    if (!desktop.matches || pinned) return;
    var r = scroller.getBoundingClientRect();
    if (r.bottom < 0 || r.top > window.innerHeight) { schedule(); return; }
    var mid = r.top + r.height / 2;
    var best = 0, bestD = Infinity;
    all.forEach(function (p, x) {
      var b = p.getBoundingClientRect();
      var d = Math.abs(b.top + b.height / 2 - mid);
      if (d < bestD) { bestD = d; best = x % n; }
    });
    paint(best);
    schedule();
  }
  function schedule() { if (raf === null) raf = requestAnimationFrame(watch); }

  function pin(k) {
    pinned = true;
    track.classList.remove('is-drift');
    track.style.transform = 'none';
    paint(k);
  }

  all.forEach(function (p, x) { XE.on(p, 'click', function () { pin(x % n); }); });
  pills.forEach(function (p, k) {
    XE.on(p, 'keydown', function (e) {
      var d = e.key === 'ArrowDown' ? 1 : e.key === 'ArrowUp' ? -1 : 0;
      if (!d) return;
      e.preventDefault();
      var t = ((k + d) % n + n) % n;
      pin(t); pills[t].focus();
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
    pin(k);
    if (scroll) sec.scrollIntoView({ behavior: XE.reduced ? 'auto' : 'smooth', block: 'start' });
    return true;
  }
  XE.on(window, 'hashchange', function () { fromHash(true); });

  paint(0);
  if (!fromHash(false) && !XE.reduced && desktop.matches) {
    track.style.setProperty('--s08-dur', (n * 4.4) + 's');
    track.classList.add('is-drift');
    schedule();
  }
})();

/* ===== 10-production ===== */
/* 10 — the marquee videos only load and play while the section is on screen. */
(function () {
  'use strict';
  var sec = document.querySelector('.s10');
  if (!sec || !window.XE) return;
  if (XE.reduced || !('IntersectionObserver' in window)) return;

  new IntersectionObserver(function (es) {
    var on = es[0].isIntersecting;
    XE.$$('[data-s10-v]', sec).forEach(function (v) {
      if (on) {
        if (v.preload !== 'auto') { v.preload = 'auto'; v.load(); }
        var pr = v.play();
        if (pr && pr.catch) pr.catch(function () {});
      } else { v.pause(); }
    });
  }, { threshold: 0.05 }).observe(sec);
})();

/* ===== 12-process ===== */
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
    panel.classList.add('is-live');
    timer = XE.liveTimer(panel, 6000, function () { if (!pinned) show(i + 1); });
    XE.on(panel, 'mouseenter', function () { if (timer) timer.stop(); });
    XE.on(panel, 'mouseleave', function () { if (!pinned && timer) timer.start(); });
  }
})();

/* ===== 13-operation ===== */
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

/* ===== 17-delivered ===== */
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

/* ===== 20-booking ===== */
/* 20 — booking. Writes the reader's own time zone into the discovery-call panel.

   This used to drive a mock calendar (invented availability, a mailto "booking" that
   reserved nothing). The real scheduler now lives at /book, so the only thing left
   here is the time zone label. With JavaScript off it reads "Your local time". */
(function () {
  'use strict';
  var root = document.querySelector('[data-s20]');
  if (!root) return;
  var el = root.querySelector('[data-s20-tz]');
  if (!el) return;
  try {
    var tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    if (tz) el.textContent = tz.replace(/_/g, ' ');
  } catch (e) {}
})();

/* ===== 22-final-cta ===== */
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
