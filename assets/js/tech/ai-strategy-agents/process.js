/* AI Strategy & Agents · process — on entry the track runs phase by phase: the phase line fills, its
   gate checks each exit criterion in turn, the status flips to passed and the marker turns ink, then
   the next phase starts. About 2.5 s for all three gates, starting as soon as the track's top edge
   is on screen. The Scale gate pulses while on screen, as a review that recurs.
   Reduced motion: the finished track, every gate passed, no motion. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var pr = document.querySelector('[data-tas-pr]'); if (!pr || BDH.reduced) return;
  var phases = BDH.$$('.tas-pr__ph', pr);
  var gates = phases.map(function (p) {
    var g = p.querySelector('[data-gate]'), gs = g ? g.querySelector('[data-gs]') : null;
    return { el: g, gs: gs, done: gs ? gs.textContent : '', crit: g ? BDH.$$('.tas-pr__crit li', g) : [] };
  });

  pr.classList.add('is-armed');
  gates.forEach(function (g) { if (g.gs) g.gs.textContent = 'Pending'; });

  var t = 0;
  function at(ms, fn) { t += ms; setTimeout(fn, t); }
  function play() {
    phases.forEach(function (p, i) {
      var g = gates[i];
      at(i === 0 ? 60 : 120, function () { p.classList.add('is-run'); });
      at(300, function () { if (g.el) g.el.classList.add('is-check'); if (g.gs) g.gs.textContent = 'Checking'; });
      g.crit.forEach(function (li) { at(80, function () { li.classList.add('is-ok'); }); });
      at(150, function () {
        if (g.el) { g.el.classList.remove('is-check'); g.el.classList.add('is-pass'); }
        if (g.gs) g.gs.textContent = g.done;
        p.classList.add('is-pass');
      });
    });
  }

  BDH.inView(pr, play, { threshold: 0.01, rootMargin: '0px 0px -6% 0px' });
  BDH.live(pr, 0.1);
})();
