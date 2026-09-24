/* Quality — the Web Vitals meters grow to their value once on screen. */
(function () { 'use strict'; if (!window.BDH) return;
  var root = document.querySelector('.apr-q'); if (!root || BDH.reduced) return;
  root.classList.add('is-anim');
  BDH.inView(root.querySelector('.apr-meter') || root, function () { root.classList.add('is-in'); });
})();
