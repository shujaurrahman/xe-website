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

  function orient() { list.setAttribute('aria-orientation', narrow.matches ? 'horizontal' : 'vertical'); }
  orient();
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
