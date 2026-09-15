/* §0 hero — replays the redraft: strike the old words, type the new ones, accept, next version.
   The HTML is the ratified state; under reduced motion nothing runs. Loops while on screen. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var doc = document.querySelector('[data-cbf-hero]');
  if (!doc || BDH.reduced) return;
  var data; try { data = JSON.parse(doc.getAttribute('data-cbf-hero')); } catch (e) { return; }
  var slots = BDH.$$('.cbf-doc__slot', doc), revs = data.revs, S = data.slots;
  var note = doc.querySelector('.cbf-doc__note');
  var q = function (k) { return doc.querySelector('[data-k="' + k + '"]'); };
  var steps = BDH.$$('.cbf-doc__steps i', doc);
  var typers = [];

  function esc(s) { var d = document.createElement('span'); d.textContent = s; return d.innerHTML; }
  function plain(r) {   // accept all changes: plain text of draft r
    slots.forEach(function (el, i) { var t = S[i][r]; el.innerHTML = t ? '<span class="cbf-doc__txt">' + esc(t) + '</span>' : ''; el.hidden = !t; });
  }
  function meta(r) {
    q('ver').textContent = revs[r][0];
    q('status').querySelector('span').textContent = revs[r][1];
    q('last').textContent = revs[r][2];
    steps.forEach(function (s, i) { s.className = i < r ? 'is-done' : (i === r ? 'is-on' : ''); });
  }
  function say(r) {
    note.classList.add('is-out');
    setTimeout(function () { q('who').textContent = revs[r][3]; q('note').textContent = revs[r][4]; note.classList.remove('is-out'); }, 350);
  }
  function strike(r) {   // mark the words that change between r-1 and r
    slots.forEach(function (el, i) {
      var a = S[i][r - 1], b = S[i][r]; if (a === b) return;
      el.hidden = false;
      el.innerHTML = (a ? '<del class="cbf-doc__del is-pre">' + esc(a) + '</del> ' : '') + '<ins class="cbf-doc__ins"></ins>';
    });
    doc.offsetWidth;
    BDH.$$('.cbf-doc__del.is-pre', doc).forEach(function (d) { d.classList.remove('is-pre'); });
  }
  function write(r) {
    slots.forEach(function (el, i) {
      var ins = el.querySelector('.cbf-doc__ins'); if (!ins) return;
      ins.classList.add('is-typing');
      typers.push(BDH.type(ins, S[i][r], { speed: 34, done: function () { ins.classList.remove('is-typing'); } }));
    });
  }
  function finishAll() { typers.forEach(function (t) { t.finish(); }); typers = []; }

  var timeline = [[1200, function () { doc.classList.add('is-play'); plain(0); meta(0); say(0); }]];
  for (var r = 1; r < revs.length; r++) {
    (function (r) {
      timeline.push([2600, function () { say(r); strike(r); }]);
      timeline.push([1100, function () { write(r); meta(r); }]);
      if (r < revs.length - 1) timeline.push([3000, function () { finishAll(); plain(r); }]);
    })(r);
  }
  timeline.push([6200, function () { finishAll(); plain(0); meta(0); say(0); }]);

  BDH.seq(doc, timeline, {
    loop: true,
    onStop: function () {   // first touch: settle on the ratified redline the HTML started with
      finishAll();
      var last = revs.length - 1; meta(last);
      q('who').textContent = revs[last][3]; q('note').textContent = revs[last][4]; note.classList.remove('is-out');
      slots.forEach(function (el, i) {
        var a = S[i][last - 1], b = S[i][last]; el.hidden = !b;
        el.innerHTML = a === b ? (b ? '<span class="cbf-doc__txt">' + esc(b) + '</span>' : '') : ((a ? '<del class="cbf-doc__del">' + esc(a) + '</del> ' : '') + '<ins class="cbf-doc__ins">' + esc(b) + '</ins>');
      });
    }
  });
})();
