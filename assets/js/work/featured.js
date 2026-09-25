/* Work featured — the rollout board ticks through its 36 checks once when it scrolls into view.
   The HTML is the finished board; JS only hides it at init (.is-anim) to play the sequence. */
(function () { 'use strict'; if (!window.BDH) return;
  var board = document.querySelector('[data-wrk-board]'); if (!board || BDH.reduced) return;
  var rows = Array.prototype.slice.call(board.querySelectorAll('tbody tr'));
  var done = board.querySelector('[data-wrk-done]');
  var log = board.querySelector('.wrk-board__log');
  board.classList.add('is-anim');
  if (done) done.textContent = '0';
  BDH.live(board.parentNode, 0.2, function () {});
  BDH.inView(board, function () {
    var n = 0, steps = [];
    rows.forEach(function (r) {
      Array.prototype.forEach.call(r.querySelectorAll('.wrk-ck'), function (c) { steps.push([c, r]); });
    });
    var i = 0;
    (function next() {
      if (i >= steps.length) { log.classList.add('is-on'); return; }
      var c = steps[i][0], r = steps[i][1]; i++;
      c.classList.add('is-on');
      if (!c.classList.contains('wrk-ck--flag')) n++;
      if (done) done.textContent = String(n);
      if (!r.querySelector('.wrk-ck:not(.is-on)')) r.classList.add('is-done');
      setTimeout(next, 55);
    })();
  });
})();
