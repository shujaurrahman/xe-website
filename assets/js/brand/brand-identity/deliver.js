/* Brand Identity · deliver — pressing (or hovering/focusing) a contents line opens that chapter on the
   right page. Leafs through the chapters every 2.6s while untouched and on screen. Reduced: static. */
(function () {
  'use strict';
  var root = document.querySelector('.cbi-dl'); if (!root) return;
  var chs = Array.prototype.slice.call(root.querySelectorAll('.cbi-dl__ch'));
  var opens = Array.prototype.slice.call(root.querySelectorAll('.cbi-dl__open'));
  var cur = 0, run = null;
  function show(i) {
    cur = i;
    chs.forEach(function (c, k) { c.setAttribute('aria-pressed', String(k === i)); });
    opens.forEach(function (o, k) { o.classList.toggle('is-on', k === i); });
  }
  function take() { if (run) { run.stop(); run = null; } }
  chs.forEach(function (c, k) {
    c.addEventListener('click', function () { take(); show(k); });
    c.addEventListener('mouseenter', function () { take(); show(k); });
    c.addEventListener('focus', function () { take(); show(k); });
  });
  if (!window.BDH || BDH.reduced) return;
  var book = root.querySelector('.cbi-dl__book');
  run = BDH.loop(book, 2600, function () { show((cur + 1) % chs.length); });
  BDH.onInteract(book, take);
})();
