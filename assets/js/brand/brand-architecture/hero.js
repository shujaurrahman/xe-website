/* 1 · Hero — constellation: nodes drift loose, then settle into the hierarchy and lines draw in.
   Settled state is the HTML. Loops only while on screen; reduced motion keeps it settled. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var stage = document.querySelector('[data-cba-constellation]');
  if (!stage || BDH.reduced) return;
  var state = stage.querySelector('[data-cba-state]');
  var rev = stage.querySelector('[data-cba-rev]');
  var revs = ['A', 'B', 'C'], r = 0;

  function loose() {
    stage.classList.add('is-loose');
    if (state) state.textContent = 'Unstructured';
  }
  function settle() {
    stage.classList.remove('is-loose');
    if (state) state.textContent = 'Structured';
    r = (r + 1) % revs.length;
    if (rev) rev.textContent = revs[r];
  }

  loose();
  BDH.seq(stage, [
    [900, settle],
    [5200, loose],
    [1600, function () {}]
  ], { loop: true, stopOnInteract: false });
})();
