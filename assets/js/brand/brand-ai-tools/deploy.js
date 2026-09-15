/* 09 Deploy log — each entry resolves as it scrolls in: queued → running (lines stream) → succeeded.
   Entries play independently (no serial queue), so a fast scroll never leaves empty log boxes behind;
   the timeline rail fills as entries succeed. Reduced motion / no JS: the HTML final state stands. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  var log = document.querySelector('.cat-dp__log'); if (!log) return;
  var es = BDH.$$('.cat-dp__e', log), done = 0;
  es.forEach(function (e) { e.classList.remove('is-done'); e.classList.add('is-queue'); });
  log.classList.add('is-live');
  log.style.setProperty('--dp', 0);

  function play(e) {
    e.classList.remove('is-queue'); e.classList.add('is-run');
    var lines = BDH.$$('.cat-dp__lines li', e);
    lines.forEach(function (li, i) { setTimeout(function () { li.classList.add('is-shown'); }, 250 + i * 260); });
    setTimeout(function () {
      e.classList.remove('is-run'); e.classList.add('is-done');
      done++; log.style.setProperty('--dp', done / es.length);
    }, 250 + lines.length * 260 + 450);
  }
  es.forEach(function (e) { BDH.inView(e, function () { play(e); }, { threshold: 0.3 }); });
})();
