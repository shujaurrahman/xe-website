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
