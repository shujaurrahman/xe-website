/* §3 tension map — a pole regroups the excerpts that lean its way (FLIP), dims the rest and lights
   their dots on both rails. Cycles through the poles until first touch. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.cbf-ten'); if (!root) return;
  var list = root.querySelector('.cbf-ten__list');
  var qs = BDH.$$('.cbf-ten__q', list), div = list.querySelector('.cbf-ten__div');
  var poles = BDH.$$('.cbf-ten__pole', root), all = root.querySelector('.cbf-ten__all');
  var dots = BDH.$$('.cbf-ten__dot', root), status = root.querySelector('[data-ten-status]');
  var order = qs.slice();

  function leans(q, axis, side) { var v = +q.getAttribute('data-' + axis); return side === 'a' ? v < 40 : v > 60; }

  function flip(fn) {
    var els = qs.concat(div), first = els.map(function (el) { return el.hidden ? null : el.getBoundingClientRect().top; });
    fn();
    if (BDH.reduced) return;
    els.forEach(function (el, i) {
      if (el.hidden || first[i] === null) return;
      var dy = first[i] - el.getBoundingClientRect().top; if (!dy) return;
      el.style.transition = 'none'; el.style.transform = 'translateY(' + dy + 'px)';
      el.offsetHeight;
      el.style.transition = 'transform .7s cubic-bezier(.22,1,.36,1), opacity .45s'; el.style.transform = '';
    });
  }

  function show(pole) {
    poles.forEach(function (p) { p.setAttribute('aria-pressed', String(p === pole)); });
    all.setAttribute('aria-pressed', String(!pole));
    var axis = pole && pole.getAttribute('data-axis'), side = pole && pole.getAttribute('data-side');
    var hit = pole ? order.filter(function (q) { return leans(q, axis, side); }) : order;
    var miss = pole ? order.filter(function (q) { return hit.indexOf(q) < 0; }) : [];
    flip(function () {
      hit.concat(miss.length ? [div] : [], miss).forEach(function (el) { list.appendChild(el); });
      div.hidden = !miss.length;
      qs.forEach(function (q) { q.classList.toggle('is-dim', miss.indexOf(q) > -1); });
    });
    dots.forEach(function (d) {
      var q = list.querySelector('.cbf-ten__q[data-q="' + d.getAttribute('data-q') + '"]'), on = hit.indexOf(q) > -1;
      d.classList.toggle('is-on', !!pole && on); d.classList.toggle('is-off', !!pole && !on);
    });
    status.textContent = pole ? 'Leaning ' + pole.textContent.trim().toLowerCase() + ' · ' + hit.length + ' of ' + qs.length + ' excerpts' : 'All ' + qs.length + ' excerpts';
  }

  poles.forEach(function (p) { p.addEventListener('click', function () { show(p.getAttribute('aria-pressed') === 'true' ? null : p); }); });
  all.addEventListener('click', function () { show(null); });
  qs.forEach(function (q) {
    var hot = function (on) { BDH.$$('.cbf-ten__dot[data-q="' + q.getAttribute('data-q') + '"]', root).forEach(function (d) { d.classList.toggle('is-hot', on); }); };
    q.addEventListener('pointerenter', function () { hot(true); });
    q.addEventListener('pointerleave', function () { hot(false); });
  });

  if (!window.matchMedia('(min-width:1025px)').matches) return;   // narrow: the list is read in place, no tour
  var tour = poles.concat([null]);
  BDH.seq(root.querySelector('.cbf-ten__grid'), tour.map(function (p, i) { return [i === 0 ? 1600 : 3400, function () { show(p); }]; }).concat([[3400, function () {}]]), { loop: true, onStop: function () {} });
})();
