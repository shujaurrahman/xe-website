/* Approach hero — the console's log lines arrive one by one when first seen. Finished state without JS / reduced motion. */
(function () { 'use strict'; if (!window.BDH) return;
  var cp = document.querySelector('.apr-cp'); if (!cp || BDH.reduced) return;
  var lines = cp.querySelectorAll('.apr-cp__log li');
  cp.classList.add('is-anim');
  BDH.inView(cp, function () {
    lines.forEach(function (li, n) { setTimeout(function () { li.classList.add('is-in'); }, 300 + n * 420); });
  });
})();
