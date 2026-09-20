/* AI Strategy & Agents · reality — the funnel narrows stage by stage on entry and the drop-off
   reasons slide in. Hovering or focusing a reason card lights its drop-off in the funnel.
   Reduced motion: the finished chart; the highlight still works. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var sec = document.querySelector('.tas-reality'); if (!sec) return;
  var chart = sec.querySelector('[data-tas-funnel]');
  var cards = BDH.$$('.tas-re__card', sec);

  function hi(r) { if (!chart) return; if (r == null) chart.removeAttribute('data-hi'); else chart.setAttribute('data-hi', r); }
  cards.forEach(function (c) {
    var r = c.getAttribute('data-r');
    c.addEventListener('mouseenter', function () { hi(r); });
    c.addEventListener('mouseleave', function () { hi(null); });
    c.addEventListener('focusin', function () { hi(r); });
    c.addEventListener('focusout', function () { hi(null); });
  });

  if (!chart || BDH.reduced) return;
  chart.classList.add('is-armed');
  BDH.enter(chart, { delay: 250, io: { threshold: 0.05, rootMargin: '0px 0px -20% 0px' } });
})();
