/* Brand Identity · outcomes — margin notes and their phrases highlight each other on hover; while
   untouched and on screen, the annotations are walked in turn. FAQ: each index entry opens and closes on
   its own (several may be open). Reduced motion: no walk; the FAQ still works. */
(function () {
  'use strict';
  var root = document.querySelector('.cbi-oc'); if (!root) return;
  var phs = Array.prototype.slice.call(root.querySelectorAll('.cbi-oc__ph'));
  var notes = Array.prototype.slice.call(root.querySelectorAll('.cbi-oc__note'));
  var run = null, cur = -1;

  function hi(n) {
    phs.forEach(function (p) { p.classList.toggle('is-hi', p.getAttribute('data-n') === String(n)); });
    notes.forEach(function (p) { p.classList.toggle('is-hi', p.getAttribute('data-n') === String(n)); });
  }
  function take() { if (run) { run.stop(); run = null; } }
  phs.concat(notes).forEach(function (el) {
    el.addEventListener('mouseenter', function () { take(); hi(el.getAttribute('data-n')); });
    el.addEventListener('mouseleave', function () { hi(-1); });
  });

  Array.prototype.forEach.call(root.querySelectorAll('.cbi-faq__btn'), function (b) {
    var p = document.getElementById(b.getAttribute('aria-controls'));
    if (!p) return;
    b.addEventListener('click', function () {
      var open = b.getAttribute('aria-expanded') === 'true';
      b.setAttribute('aria-expanded', String(!open));
      p.hidden = open;
    });
  });

  if (!window.BDH || BDH.reduced) { hi(-1); return; }
  var spread = root.querySelector('.cbi-oc__spread');
  run = BDH.loop(spread, 2400, function () { cur = (cur + 1) % (notes.length + 1); hi(cur === notes.length ? -1 : cur); });
  BDH.onInteract(spread, take);
})();
