/* Audits & Assessments · readiness — the radar draws itself once, the gap rows rise and the
   profiling bars fill. The HTML already holds the finished radar, the scores and the profiling
   numbers: this only gates the entrance so the shapes are seen forming. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var top = document.querySelector('[data-taa-rd]');
  if (top) {
    top.classList.add('is-anim');
    BDH.inView(top, function () { top.classList.add('is-in'); }, { threshold: 0.25 });
  }

  var prof = document.querySelector('[data-taa-rd-prof]');
  if (prof) {
    prof.classList.add('is-anim');
    BDH.inView(prof, function () { prof.classList.add('is-prof'); }, { threshold: 0.3 });
  }
})();
