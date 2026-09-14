/* Hub · why now — lights the statement word by word as it scrolls through the viewport.
   No pinning, no scroll-jacking; under reduced motion the words stay at their final colours. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  var root = document.querySelector('.bdh-why-now');
  var head = root && root.querySelector('.bdh-why__h');
  if (!head) return;
  var words = BDH.$$('.bdh-why__w', head);
  if (!words.length) return;

  root.classList.add('is-lit-js');
  var shown = -1;
  BDH.progress(head, function (p) {
    var t = Math.max(0, Math.min(1, (p - 0.1) / 0.38));
    var n = Math.round(t * words.length);
    if (n === shown) return;
    shown = n;
    words.forEach(function (w, i) { w.classList.toggle('is-lit', i < n); });
  });
})();
