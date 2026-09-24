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
