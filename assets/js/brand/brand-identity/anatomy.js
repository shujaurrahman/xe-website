/* Brand Identity · anatomy — the stack explodes on entry, then walks the seven layers until the
   visitor hovers, focuses or presses one. Collapse/explode toggle. Reduced motion: exploded, static. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.cbi-anat'); if (!root) return;
  var plates = BDH.$$('.cbi-plate', root);
  var items = BDH.$$('.cbi-anat__item', root);
  var toggle = root.querySelector('.cbi-anat__toggle');
  var pinned = -1, walker = null;

  function hi(i) {
    plates.forEach(function (p, k) { p.classList.toggle('is-hi', k === i); p.classList.toggle('is-above', i > 0 && k < i); });
    items.forEach(function (b, k) { b.classList.toggle('is-hi', k === i); });
  }
  function take() { if (walker) { walker.stop(); walker = null; } }

  items.forEach(function (b, k) {
    b.addEventListener('mouseenter', function () { take(); hi(k); });
    b.addEventListener('focus', function () { take(); hi(k); });
    b.addEventListener('mouseleave', function () { hi(pinned); });
    b.addEventListener('blur', function () { hi(pinned); });
    b.addEventListener('click', function () {
      take();
      pinned = pinned === k ? -1 : k;
      items.forEach(function (x, j) { x.setAttribute('aria-pressed', String(j === pinned)); });
      hi(pinned === -1 ? k : pinned);
    });
  });

  if (toggle) toggle.addEventListener('click', function () {
    var flat = root.classList.toggle('is-flat');
    toggle.setAttribute('aria-pressed', String(flat));
    toggle.textContent = flat ? 'Explode the stack' : 'Collapse the stack';
  });

  BDH.enter(root);
  BDH.inView(root, function () { setTimeout(function () { root.classList.add('is-ready'); }, 1700); });
  if (BDH.reduced) return;

  var step = -1;
  BDH.inView(root.querySelector('.cbi-anat__grid'), function () {
    setTimeout(function () {
      if (pinned !== -1) return;
      walker = BDH.loop(root.querySelector('.cbi-anat__grid'), 1900, function () {
        step = (step + 1) % plates.length; hi(step);
      });
      BDH.onInteract(root.querySelector('.cbi-anat__grid'), take);
    }, 1400);
  });
})();
