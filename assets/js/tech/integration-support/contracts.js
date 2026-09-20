/* Contracts — runs the contract-check pipeline once the band is on screen: each job lights in turn
   (red on the breaking change, amber on the version bump, green once published) and the two changed
   diff lines flash as the breaking-change job reports. The HTML already holds the finished state,
   so this only replays how it got there. Stops for good on the first interaction. Nothing runs
   under reduced motion. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.tis-ct');
  if (!root || BDH.reduced) return;

  var jobs = BDH.$$('.tis-ct__job', root);
  var diff = BDH.$$('.tis-ct__l--del, .tis-ct__l--add', root);
  var vt   = BDH.$('[data-verdict-t]', root);
  if (!jobs.length || !vt) return;

  /* the panel ships blocked on v1, which is what the two findings below it say; the run ends on
     the resolution the pipeline reaches */
  var final = vt.getAttribute('data-verdict-end') || vt.textContent;
  var steps = [];

  function clear() { jobs.forEach(function (j) { j.classList.remove('is-now'); }); }

  jobs.forEach(function (job, i) {
    steps.push([i === 0 ? 700 : 900, function () {
      clear();
      job.classList.add('is-now');
      if (job.dataset.job === 'break') {
        diff.forEach(function (l, n) {
          setTimeout(function () { l.classList.add('is-lit'); }, n * 160);
          setTimeout(function () { l.classList.remove('is-lit'); }, 900 + n * 160);
        });
      }
      var state = job.classList.contains('is-fail') ? 'Breaking change found'
                : job.classList.contains('is-warn') ? 'Needs a version bump'
                : 'Checks passing';
      vt.textContent = state;
    }]);
  });

  steps.push([1100, function () { clear(); vt.textContent = final; }]);

  BDH.seq(root, steps, { loop: false, stopOnInteract: true, interactRoot: root, onStop: function () {
    clear();
    diff.forEach(function (l) { l.classList.remove('is-lit'); });
    vt.textContent = final;
  } });
})();
