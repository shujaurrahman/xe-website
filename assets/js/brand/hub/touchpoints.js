/* Hub · touchpoints — "Show the system" switch, plus a one-time demo on the first tile. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.bdh-touchpoints');
  if (!root) return;
  var sw = BDH.$('.bdh-tp__switch', root);
  var first = BDH.$('.bdh-tp__tile', root);
  var touched = false;

  if (sw) sw.addEventListener('click', function () {
    touched = true;
    if (first) first.classList.remove('is-demo');
    var on = sw.getAttribute('aria-pressed') !== 'true';
    sw.setAttribute('aria-pressed', on ? 'true' : 'false');
    root.classList.toggle('is-sys', on);
  });

  if (first && !BDH.reduced) {
    BDH.inView(first, function () {
      setTimeout(function () {
        if (touched) return;
        first.classList.add('is-demo');
        setTimeout(function () { first.classList.remove('is-demo'); }, 2600);
      }, 700);
    }, { threshold: 0.5 });
  }
})();
