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
} catch (e) { console.error('[08-disciplines]', e); }

/* ===== 10-production ===== */
try {
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
    panel.classList.add('is-live');
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
/* 20 — booking widget.
   HOOK 1: AVAILABLE(date)    — which days can be offered
   HOOK 2: SLOTS(date)        — which times can be offered
   HOOK 3: send(payload)      — currently composes a mailto; swap for a real endpoint.
   Nothing here reserves anything; the UI never says a booking is confirmed. */
(function () {
  'use strict';
  var root = document.querySelector('[data-s20]');
  if (!root || !window.XE) return;

  var EMAIL = 'connect@xterraedze.com';
  var monthEl = XE.$('[data-s20-month]', root);
  var daysEl = XE.$('[data-s20-days]', root);
  var timesEl = XE.$('[data-s20-times]', root);
  var dayLabel = XE.$('[data-s20-daylabel]', root);
  var form = XE.$('[data-s20-form]', root);
  var doneEl = XE.$('[data-s20-done]', root);
  var errEl = XE.$('[data-s20-err]', root);
  var live = XE.$('[data-s20-live]', root);
  var prevM = XE.$('[data-s20-prevm]', root);
  var nextM = XE.$('[data-s20-nextm]', root);

  var today = new Date(); today.setHours(0, 0, 0, 0);
  var view = new Date(today.getFullYear(), today.getMonth(), 1);
  var selected = null, picked = null, h24 = false;

  try {
    var tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    if (tz) XE.$('[data-s20-tz]', root).textContent = tz.replace(/_/g, ' ');
  } catch (e) {}

  /* HOOK 1 — weekdays, from two days out, inside the next twelve weeks */
  function AVAILABLE(d) {
    var day = d.getDay();
    if (day === 0 || day === 6) return false;
    var diff = (d - today) / 86400000;
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

  function fmtMonth(d) {
    return d.toLocaleDateString('en-GB', { month: 'long', year: 'numeric' });
  }
  function fmtDay(d) {
    return d.toLocaleDateString('en-GB', { weekday: 'long', day: 'numeric', month: 'long' });
  }
  function fmtTime(mins) {
    var h = Math.floor(mins / 60), m = mins % 60;
    if (h24) return ('0' + h).slice(-2) + ':' + ('0' + m).slice(-2);
    var ap = h < 12 ? 'am' : 'pm', hh = h % 12 || 12;
    return hh + ':' + ('0' + m).slice(-2) + ap;
  }

  function renderMonth() {
    monthEl.textContent = fmtMonth(view);
    prevM.disabled = view.getFullYear() === today.getFullYear() && view.getMonth() === today.getMonth();
    daysEl.innerHTML = '';

    var first = new Date(view.getFullYear(), view.getMonth(), 1);
    var lead = (first.getDay() + 6) % 7;                    /* week starts Monday */
    var total = new Date(view.getFullYear(), view.getMonth() + 1, 0).getDate();

    for (var i = 0; i < lead; i++) {
      var pad = document.createElement('div');
      pad.className = 's20__cell';
      pad.setAttribute('role', 'gridcell');
      daysEl.appendChild(pad);
    }
    for (var n = 1; n <= total; n++) {
      var d = new Date(view.getFullYear(), view.getMonth(), n);
      var cell = document.createElement('div');
      cell.className = 's20__cell';
      cell.setAttribute('role', 'gridcell');
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 's20__d';
      b.textContent = String(n);
      /* local parts, never toISOString — that shifts the day across timezones */
      b.setAttribute('data-iso', d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate());
      if (+d === +today) b.classList.add('is-today');
      if (!AVAILABLE(d)) { b.disabled = true; b.setAttribute('aria-disabled', 'true'); }
      else b.setAttribute('aria-label', fmtDay(d) + ' — choose this day');
      if (selected && +d === +selected) { b.classList.add('is-sel'); b.setAttribute('aria-current', 'date'); }
      cell.appendChild(b);
      daysEl.appendChild(cell);
    }
  }

  function renderTimes() {
    form.hidden = true; doneEl.hidden = true; timesEl.hidden = false;
    timesEl.innerHTML = '';
    if (!selected) {
      dayLabel.textContent = 'Pick a day';
      var p = document.createElement('p');
      p.className = 's20__empty';
      p.textContent = 'Choose a day on the left to see open times.';
      timesEl.appendChild(p);
      return;
    }
    dayLabel.textContent = fmtDay(selected);
    SLOTS(selected).forEach(function (mins) {
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 's20__time';
      b.textContent = fmtTime(mins);
      b.setAttribute('data-mins', String(mins));
      timesEl.appendChild(b);
    });
  }

  XE.on(daysEl, 'click', function (e) {
    var b = e.target.closest('.s20__d');
    if (!b || b.disabled) return;
    var iso = b.getAttribute('data-iso').split('-');
    selected = new Date(+iso[0], +iso[1] - 1, +iso[2]);
    renderMonth(); renderTimes();
    live.textContent = fmtDay(selected) + ' selected.';
  });

  XE.on(daysEl, 'keydown', function (e) {
    var b = e.target.closest('.s20__d');
    if (!b) return;
    var map = { ArrowRight: 1, ArrowLeft: -1, ArrowDown: 7, ArrowUp: -7 };
    var d = map[e.key];
    if (!d) return;
    e.preventDefault();
    var all = XE.$$('.s20__d', daysEl);
    var idx = all.indexOf(b) + d;
    while (idx >= 0 && idx < all.length && all[idx].disabled) idx += d > 0 ? 1 : -1;
    if (all[idx]) all[idx].focus();
  });

  XE.on(timesEl, 'click', function (e) {
    var b = e.target.closest('.s20__time');
    if (!b) return;
    picked = { date: new Date(selected), mins: +b.getAttribute('data-mins'), label: b.textContent };
    timesEl.hidden = true; doneEl.hidden = true; form.hidden = false;
    /* no-break before the dot, so a wrap never starts a line with it */
    XE.$('[data-s20-picked]', root).textContent = fmtDay(picked.date) + '\u00a0· ' + picked.label;
    live.textContent = 'Time selected: ' + picked.label + '. Complete the form to send your request.';
    var first = XE.$('[data-book-first]', form);
    if (first) first.focus({ preventScroll: true });
  });

  XE.$$('[data-s20-fmt]', root).forEach(function (b) {
    XE.on(b, 'click', function () {
      h24 = b.getAttribute('data-s20-fmt') === '24';
      XE.$$('[data-s20-fmt]', root).forEach(function (o) {
        var on = o === b;
        o.classList.toggle('is-on', on);
        o.setAttribute('aria-checked', String(on));
      });
      if (!form.hidden) return;
      renderTimes();
    });
  });

  XE.on(prevM, 'click', function () { view.setMonth(view.getMonth() - 1); renderMonth(); });
  XE.on(nextM, 'click', function () { view.setMonth(view.getMonth() + 1); renderMonth(); });
  XE.on(XE.$('[data-s20-back]', root), 'click', function () { renderTimes(); });

  XE.on(form, 'submit', function (e) {
    e.preventDefault();
    var f = new FormData(form);
    var name = (f.get('name') || '').toString().trim();
    var email = (f.get('email') || '').toString().trim();
    var company = (f.get('company') || '').toString().trim();
    var brief = (f.get('brief') || '').toString().trim();

    var problems = [];
    if (!name) problems.push('your name');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email)) problems.push('a valid work email');
    if (!brief) problems.push('a line about what you are building');
    if (problems.length) {
      errEl.hidden = false;
      errEl.textContent = 'Please add ' + problems.join(', ') + '.';
      live.textContent = errEl.textContent;
      return;
    }
    errEl.hidden = true;

    var when = fmtDay(picked.date) + ' at ' + picked.label;
    /* HOOK 3 — replace this mailto with a POST to your booking endpoint */
    var subject = 'Discovery call request — ' + when;
    var body = [
      'Requested slot: ' + when,
      'Name: ' + name,
      'Email: ' + email,
      'Company: ' + (company || '—'),
      '',
      'Brief:',
      brief
    ].join('\n');
    window.location.href = 'mailto:' + EMAIL +
      '?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);

    form.hidden = true; timesEl.hidden = true; doneEl.hidden = false;
    XE.$('[data-s20-donep]', root).textContent =
      'We have opened an email to ' + EMAIL + ' with your brief and ' + when + '.';
    live.textContent = 'Request prepared. Nothing is reserved yet.';
  });

  renderMonth();
  renderTimes();
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
   The HTML is a complete POST form without this file. This adds: the six discipline lists as an ARIA
   tablist (BDH.tabs), a pick count per discipline, the live summary bar, the chosen package's column,
   and a "Likely fit" mark read from the typical length of the ticked services.
   window.BDH loads after the bundled sections.js, so init waits for DOMContentLoaded. */
(function () {
  'use strict';

  function init() {
    var root = document.querySelector('[data-s25]');
    if (!root || !window.XE) return;
    var XE = window.XE, BDH = window.BDH;
    var form = XE.$('[data-s25-form]', root);
    var tablist = XE.$('[data-s25-tabs]', root);
    var tabs = XE.$$('[data-s25-tab]', root);
    var panes = XE.$$('[data-s25-pane]', root);
    var svcs = XE.$$('[data-s25-svc]', root);
    var pkgs = XE.$$('[data-s25-pkg]', root);
    var cmp = XE.$('[data-s25-cmp]', root);
    var fits = XE.$$('[data-s25-fit]', root);
    var fitNote = XE.$('[data-s25-fitnote]', root);
    var send = XE.$('[data-s25-send]', root);
    var countEl = XE.$('[data-s25-count]', root);
    var pkEl = XE.$('[data-s25-pkname]', root);
    var namesEl = XE.$('[data-s25-names]', root);
    var clearBtn = XE.$('[data-s25-clear]', root);
    var live = XE.$('[data-s25-live]', root);
    if (!form) return;
    root.classList.add('is-js');

    /* ---- tabs: only once JS is here; before that every list is shown in turn ---- */
    if (tablist && tabs.length && panes.length === tabs.length && BDH && BDH.tabs) {
      panes.forEach(function (p, i) {
        p.setAttribute('role', 'tabpanel');
        p.setAttribute('aria-labelledby', tabs[i].id);
        p.setAttribute('tabindex', '0');
      });
      tablist.hidden = false;
      BDH.tabs(tablist, { tabs: tabs, panes: panes, orientation: 'horizontal' });
    }

    function two(n) { return (n < 10 ? '0' : '') + n; }

    /* The package that most often fits: read from the services' typical lengths.
       Ongoing work → Retainer (or Squad for a team); three or more disciplines → Enterprise;
       short, small asks → Sprint; up to ~12 weeks → Project; anything longer → Milestone. */
    function weeks(t) {
      var hi = 0, m, re = /(\d+)(?:\s*[–-]\s*(\d+))?\s*weeks?/gi;
      while ((m = re.exec(t))) hi = Math.max(hi, parseInt(m[2] || m[1], 10));
      return hi;
    }
    function isRun(t) { return /ongoing|monthly|then|start in|cycles/i.test(t); }
    function suggest(picked) {
      if (!picked.length) return '';
      var ds = {}, nd = 0, hi = 0, run = false, team = false;
      picked.forEach(function (el) {
        var t = el.getAttribute('data-time') || '';
        if (!ds[el.getAttribute('data-d')]) { ds[el.getAttribute('data-d')] = 1; nd++; }
        if (isRun(t)) run = true; else hi = Math.max(hi, weeks(t));
        if (/squad|engineers-by-role/.test(el.value)) team = true;
      });
      if (team) return 'squad';
      if (nd >= 3) return 'enterprise';
      if (run) return 'retainer';
      if (hi && hi <= 3 && picked.length <= 2) return 'sprint';
      if (hi <= 12 && picked.length <= 3) return 'project';
      return 'milestone';
    }

    var lastMsg = '';
    function sync(announce) {
      var picked = svcs.filter(function (el) { return el.checked; });
      var pk = pkgs.filter(function (el) { return el.checked; })[0];
      var pkKey = pk ? pk.value : '';
      var pkName = pk && pk.value ? pk.getAttribute('data-name') : 'Not sure yet';

      /* per-discipline counts on the tabs */
      tabs.forEach(function (t) {
        var d = t.getAttribute('data-s25-tab');
        var n = picked.filter(function (el) { return el.getAttribute('data-d') === d; }).length;
        var b = XE.$('[data-s25-tabpick]', t);
        if (!b) return;
        b.hidden = !n;
        b.textContent = n ? String(n) : '';
        b.setAttribute('aria-label', n ? n + ' ticked' : '');
      });

      /* the chosen column */
      if (cmp) { if (pkKey) cmp.setAttribute('data-pkg', pkKey); else cmp.removeAttribute('data-pkg'); }

      /* likely fit */
      var fit = suggest(picked);
      fits.forEach(function (f) { f.hidden = f.closest('[data-col]').getAttribute('data-col') !== fit; });
      if (fitNote) fitNote.hidden = !fit;

      /* the bar */
      var nd = {};
      picked.forEach(function (el) { nd[el.getAttribute('data-d')] = 1; });
      var ndc = Object.keys(nd).length;
      countEl.textContent = picked.length
        ? two(picked.length) + (picked.length === 1 ? ' service' : ' services') + (ndc > 1 ? ' · ' + ndc + ' disciplines' : '')
        : 'Tick services above';
      pkEl.textContent = pkName;
      var names = picked.map(function (el) { return el.getAttribute('data-name'); });
      namesEl.hidden = !names.length;
      namesEl.textContent = names.length > 3 ? names.slice(0, 3).join(', ') + ' and ' + (names.length - 3) + ' more' : names.join(', ');
      clearBtn.hidden = !picked.length && !pkKey;

      if (announce) {
        var fitName = '';
        if (fit) { var fe = pkgs.filter(function (el) { return el.value === fit; })[0]; fitName = fe ? fe.getAttribute('data-name') : ''; }
        var msg = (picked.length ? picked.length + (picked.length === 1 ? ' service' : ' services') + ' in your brief' : 'No services in your brief')
          + '. Package: ' + pkName + '.' + (fitName && fit !== pkKey ? ' Likely fit: ' + fitName + '.' : '');
        if (msg !== lastMsg) { live.textContent = msg; lastMsg = msg; }
      }
    }

    function bump() {
      if (!send || (BDH && BDH.reduced) || XE.reduced) return;
      send.classList.remove('is-bump'); void send.offsetWidth; send.classList.add('is-bump');
    }

    svcs.forEach(function (el) { XE.on(el, 'change', function () { sync(true); bump(); }); });
    pkgs.forEach(function (el) { XE.on(el, 'change', function () { sync(true); }); });
    XE.on(clearBtn, 'click', function () {
      svcs.forEach(function (el) { el.checked = false; });
      pkgs.forEach(function (el) { el.checked = el.value === ''; });
      sync(true);
      var first = tabs.filter(function (t) { return t.getAttribute('aria-selected') === 'true'; })[0];
      if (first) first.focus();
    });
    /* back from the contact page: the browser may restore ticked boxes */
    window.addEventListener('pageshow', function () { sync(false); });
    sync(false);
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
} catch (e) { console.error('[25-offer]', e); }
