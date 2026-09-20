/* Audits & Assessments · outcomes — the baseline / re-test control.
   The HTML ships showing the re-test state, which is the finished readout. This wires the two
   buttons, and plays the move from baseline to re-test once when the panel first enters — unless
   someone has already touched the control, or motion is reduced. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-taa-outcomes]');
  if (!root) return;

  var btns = BDH.$$('[data-taa-oc-view]', root);
  if (!btns.length) return;
  var touched = false;

  function show(view) {
    root.setAttribute('data-view', view);
    btns.forEach(function (b) {
      b.setAttribute('aria-pressed', b.getAttribute('data-taa-oc-view') === view ? 'true' : 'false');
    });
  }

  btns.forEach(function (b) {
    b.addEventListener('click', function () {
      touched = true;
      show(b.getAttribute('data-taa-oc-view'));
    });
  });

  if (BDH.reduced) return;
  BDH.onInteract(root, function () { touched = true; });

  BDH.inView(root, function () {
    if (touched) return;
    show('baseline');
    window.setTimeout(function () { if (!touched) show('retest'); }, 700);
  }, { threshold: 0.3 });
})();
