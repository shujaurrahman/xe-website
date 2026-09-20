/* Websites & Apps · hero — the device rig assembles once on entry. The page-load stream (skeleton → hero image →
   text) plays ONCE, a few seconds in, the phone a beat behind the desktop; after that the rig stays in its finished
   state for good and the loop only cross-fades the two products. The shipped HTML is that finished state, so the
   rig is complete on arrival, complete after the stream, and complete with JavaScript off.
   Reduced motion: nothing runs at all. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  var rig = document.querySelector('.twa-hero__rig'); if (!rig) return;
  var pages = BDH.$$('.twa-pp', rig);
  if (!pages.length) return;

  rig.classList.add('is-pre');
  BDH.inView(rig, function () {
    requestAnimationFrame(function () { rig.classList.remove('is-pre'); });
  }, { threshold: 0.12 });

  var v = 0, played = false, pending = [];
  function each(fn) {
    pages.forEach(function (p) {
      var lag = parseInt(p.getAttribute('data-lag'), 10) || 0;
      pending.push(setTimeout(function () { fn(p); }, lag));
    });
  }
  function product() { each(function (p) { p.setAttribute('data-v', String(v)); }); }
  function state(s) { each(function (p) { p.setAttribute('data-st', s); }); }

  BDH.seq(rig, [
    [5200, function () { v = 1 - v; product(); if (!played) state('skel'); }],
    [640,  function () { if (!played) state('img'); }],
    [560,  function () { if (!played) { state('done'); played = true; } }]
  ], {
    loop: true,
    stopOnInteract: false,
    onStop: function () { pending.forEach(clearTimeout); }
  });
})();
