/* AI Product & Automation · deliver — the handover pull request. The file diffs are native <details>, so
   they open and close by mouse, touch and keyboard with no script; opening one replays its added lines
   (.is-anim restarts the CSS cascade). When the PR comes into view the CI checks run once, top to bottom,
   and end in the passed state the HTML already holds. There is no auto-rotation: nothing changes under a
   reader's eyes. Under 700 px every diff starts closed. Reduced motion: no cascade, no check replay. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tap-pr'); if (!root) return;
  /* phones: every diff starts closed, so the PR reads as a checklist of deliverables; a tap opens one */
  if (window.matchMedia && window.matchMedia('(max-width: 700px)').matches) {
    BDH.$$('[data-pr-file][open]', root).forEach(function (d) { d.open = false; });
  }
  if (BDH.reduced) return;

  BDH.$$('[data-pr-file]', root).forEach(function (d) {
    d.addEventListener('toggle', function () {
      if (!d.open) return;
      var code = d.querySelector('.tap-pr__code');
      if (!code) return;
      code.classList.remove('is-anim'); void code.offsetWidth; code.classList.add('is-anim');
    });
  });

  var checks = BDH.$$('[data-pr-checks] li', root);
  var sum = root.querySelector('[data-pr-sum]');
  var FINAL = sum ? sum.textContent : '';
  var first = root.querySelector('[data-pr-file][open] .tap-pr__code');

  BDH.inView(root, function () {
    if (first) { first.classList.remove('is-anim'); void first.offsetWidth; first.classList.add('is-anim'); }
    if (!checks.length) return;
    checks.forEach(function (li) { li.className = 'is-idle'; });
    if (sum) sum.textContent = 'running';
    var steps = [];
    checks.forEach(function (li, i) {
      steps.push([i === 0 ? 150 : 250, function () { li.className = 'is-run'; }]);
      steps.push([520, function () { li.className = 'is-pass'; if (sum) sum.textContent = (i + 1) + ' of ' + checks.length + ' passed'; }]);
    });
    steps.push([0, function () { if (sum) sum.textContent = FINAL; }]);
    BDH.seq(root, steps, { loop: false, stopOnInteract: true, onStop: function () {
      checks.forEach(function (li) { li.className = 'is-pass'; });
      if (sum) sum.textContent = FINAL;
    } });
  }, { threshold: 0.25 });
})();
