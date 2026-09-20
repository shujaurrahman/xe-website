/* Hub · shift — lights the statement word by word as it scrolls through the viewport (no pinning).
   Figures with data-bdh-count count up once (hub.js). Reduced motion: words keep their final colours. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  var root = document.querySelector('.tih-shift');
  var head = root && root.querySelector('.tih-shift__h');
  if (!head) return;
  var words = BDH.$$('.tih-shift__w', head);
  if (!words.length) return;
  root.classList.add('is-lit-js');
  var shown = -1;
  BDH.progress(head, function (p) {
    var t = Math.max(0, Math.min(1, (p - 0.12) / 0.36));
    var n = Math.round(t * words.length);
    if (n === shown) return;
    shown = n;
    words.forEach(function (w, i) { w.classList.toggle('is-lit', i < n); });
  });
})();
