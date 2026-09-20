/* Hub · principles — each clause's "enforced as" block retypes itself line by line the first time the clause
   comes into view. A line is blanked only in the instant before it is typed, and the run starts early and
   fast, so the block is never a large empty frame with a caret in it. Reduced motion: nothing moves. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  var terms = BDH.$$('.tih-principles .tih-pr__term');
  if (!terms.length) return;

  terms.forEach(function (term) {
    var lines = BDH.$$('.tih-pr__pre code', term);
    if (!lines.length) return;
    var texts = lines.map(function (c) { return c.textContent; });
    BDH.inView(term, function () {
      var n = 0;
      (function next() {
        if (n >= lines.length) return;
        var c = lines[n], t = texts[n];
        c.textContent = '';
        c.classList.add('is-typing');
        BDH.type(c, t, { speed: 6, delay: n ? 40 : 120, done: function () {
          c.classList.remove('is-typing');
          n++;
          next();
        } });
      })();
    }, { threshold: 0.15 });
  });
})();
