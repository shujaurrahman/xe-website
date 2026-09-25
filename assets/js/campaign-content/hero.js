/* Hub · hero — the always-on board. A day marker sweeps across the week, lighting the cells in the
   column it reaches; the event feed types one line at a time; the readouts tick so the panel reads as
   something running rather than a picture. Everything here is an enhancement: the shipped HTML already
   shows the finished board, so under reduced motion (or with JavaScript off) nothing is missing. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.cch-hero');
  if (!root) return;
  var panel = root.querySelector('.cch-hero__panel');
  var board = root.querySelector('.cch-hero__board');

  /* entrance: add the starting class only now, so the no-JS page keeps the finished state */
  if (!BDH.reduced) { root.classList.add('is-anim'); BDH.enter(root); }
  else { root.classList.add('is-in'); }

  if (BDH.reduced || !panel || !board) return;

  var mark = board.querySelector('.cch-hero__mark');
  var days = 7;
  var col = 2;
  var hits = [];

  function sweep() {
    col = (col + 1) % days;
    if (mark) mark.style.setProperty('--col', String(col));
    hits.forEach(clearTimeout);
    hits = [];
    var cells = board.querySelectorAll('.cch-hero__cell.is-on[data-col="' + col + '"]');
    Array.prototype.forEach.call(cells, function (cell, n) {
      hits.push(setTimeout(function () {
        cell.classList.add('is-hit');
        hits.push(setTimeout(function () { cell.classList.remove('is-hit'); }, 900));
      }, n * 70));
    });
  }
  BDH.loop(panel, 1900, sweep);

  /* ---- event feed ---------------------------------------------------------- */
  var feedEl = root.querySelector('.cch-hero__feed');
  var lines = [];
  if (feedEl) { try { lines = JSON.parse(feedEl.getAttribute('data-feed') || '[]'); } catch (err) { lines = []; } }
  if (feedEl && lines.length > 1) {
    var ft = feedEl.querySelector('.cch-hero__ft');
    var fs = feedEl.querySelector('.cch-hero__fs');
    var fx = feedEl.querySelector('.cch-hero__fxt');
    var n = 0, typing = null;
    BDH.loop(panel, 3400, function () {
      n = (n + 1) % lines.length;
      if (ft) ft.textContent = lines[n][0];
      if (fs) fs.textContent = lines[n][1];
      if (fx) { if (typing) typing.stop(); typing = BDH.type(fx, lines[n][2], { speed: 12 }); }
    });
    BDH.live(panel, 0.2);
  }

  /* ---- readouts: the same values, re-stated, so the panel looks alive ------ */
  var reads = {
    sov:   ['18', '19', '18', '17'],
    saves: ['2,140', '2,186', '2,204', '2,171'],
    cited: ['3 / 4', '3 / 4', '4 / 4', '3 / 4'],
    cpc:   ['−18', '−19', '−17', '−18']
  };
  var outs = Array.prototype.slice.call(panel.querySelectorAll('.cch-hero__reads b'));
  if (outs.length) {
    var tick = 0;
    BDH.loop(panel, 4200, function () {
      tick++;
      panel.classList.add('is-tick');
      setTimeout(function () {
        outs.forEach(function (b) {
          var set = reads[b.getAttribute('data-k')];
          if (set) b.textContent = set[tick % set.length];
        });
        panel.classList.remove('is-tick');
      }, 260);
    });
  }
})();
