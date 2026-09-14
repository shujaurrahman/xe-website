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
