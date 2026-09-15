/* Growth Strategy · 06 growth thesis — as each memo block enters, its highlight sweeps and its margin
   notes write in, one after another. Reduced motion / no JS: the finished memo is already in the HTML. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cgs-thesis]'); if (!root) return;
  var blocks = BDH.$$('[data-cgs-block]', root);
  if (BDH.reduced) { blocks.forEach(function (b) { b.classList.add('is-in'); }); return; }

  blocks.forEach(function (b) {
    var notes = BDH.$$('[data-cgs-type]', b).map(function (el) {
      var txt = el.textContent; el.textContent = ''; el.setAttribute('aria-label', txt);
      return { el: el, txt: txt };
    });
    BDH.inView(b, function () {
      b.classList.add('is-in');
      var i = 0;
      (function next() {
        var n = notes[i++]; if (!n) return;
        n.el.classList.add('is-typing');
        BDH.type(n.el, n.txt, { speed: 22, delay: 700, done: function () { n.el.classList.remove('is-typing'); n.el.removeAttribute('aria-label'); next(); } });
      })();
    }, { threshold: 0.45 });
  });
})();
