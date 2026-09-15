/* 8 · Migration — quarter scrubber. Chips move between state lanes with FLIP (First, Last, Invert,
   Play: transform only). Play steps through quarters while on screen; autoplays until the first
   interaction. Reduced motion: chips jump, no autoplay. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var app = document.querySelector('[data-cba-mig]');
  var raw = document.getElementById('migration-data');
  if (!app || !raw) return;
  var D; try { D = JSON.parse(raw.textContent); } catch (e) { return; }
  var N = D.q.length, cur = 0, timer = null;
  var qbs = BDH.$$('.cba-mig__qb', app);
  var chips = {}; BDH.$$('[data-b]', app).forEach(function (c) { chips[c.getAttribute('data-b')] = c; });
  var lanes = {}; BDH.$$('[data-lane]', app).forEach(function (l) { lanes[l.getAttribute('data-lane')] = l.querySelector('.cba-mig__chips'); });
  var order = Object.keys(D.brands);
  var log = app.querySelector('.cba-mig__log');
  var playBtn = app.querySelector('[data-m="play"]');
  var bar = app.querySelector('.cba-mig__track i');
  var $ = function (k) { return app.querySelector('[data-m="' + k + '"]'); };

  /* a state is "lane" or "lane:done" (the move is complete) */
  function laneOf(s) { return s.split(':')[0]; }

  /* stamp each chip with the quarter it entered its lane (or completed), and label empty lanes */
  function mark() {
    order.forEach(function (k) {
      var now = D.q[cur][2][k], lane = laneOf(now), done = now.indexOf(':done') > 0, j = cur;
      while (j > 0 && (done ? D.q[j - 1][2][k] === now : laneOf(D.q[j - 1][2][k]) === lane)) j--;
      chips[k].classList.toggle('is-done', done);
      var sm = chips[k].querySelector('.cba-mig__since');
      if (sm) sm.textContent = j === 0 ? '' : D.q[j][0] + (done ? ' · done' : '');
    });
    Object.keys(lanes).forEach(function (l) { lanes[l].classList.toggle('is-empty', !lanes[l].querySelector('.cba-mig__chip')); });
  }

  function flip(map) {
    var first = {}, moved = [];
    order.forEach(function (k) { first[k] = chips[k].getBoundingClientRect(); });
    order.forEach(function (k) {
      var lane = lanes[laneOf(map[k])];
      if (chips[k].parentNode !== lane) moved.push(k);
      lane.appendChild(chips[k]);   /* appended in brand order, so each lane stays sorted */
    });
    mark();
    if (BDH.reduced) return;
    order.forEach(function (k) {
      var last = chips[k].getBoundingClientRect();
      var dx = first[k].left - last.left, dy = first[k].top - last.top;
      if (!dx && !dy) return;
      var c = chips[k];
      c.style.transition = 'none';
      c.style.transform = 'translate(' + dx + 'px,' + dy + 'px)';
      void c.offsetWidth;
      c.style.transition = 'transform .8s cubic-bezier(.22,1,.36,1)';
      c.style.transform = '';
    });
    moved.forEach(function (k) {
      chips[k].classList.add('is-moved');
      setTimeout(function () { chips[k].classList.remove('is-moved'); }, 1400);
    });
  }

  function show(i) {
    cur = (i + N) % N;
    var q = D.q[cur];
    app.setAttribute('data-q', cur);
    qbs.forEach(function (b, n) { b.classList.toggle('is-on', n === cur); b.setAttribute('aria-pressed', n === cur ? 'true' : 'false'); });
    bar.style.setProperty('--p', (cur + 1) / N);
    flip(q[2]);
    $('qname').textContent = q[0]; $('phase').textContent = q[1];
    $('what').textContent = q[3]; $('risk').textContent = q[4]; $('measure').textContent = q[5];
    $('gate').textContent = q[6]; $('gatewrap').hidden = !q[6];
    if (!BDH.reduced) { log.classList.remove('is-swap'); void log.offsetWidth; log.classList.add('is-swap'); }
  }

  function setPlaying(on) {
    if (on && !BDH.reduced) {
      if (!timer) timer = BDH.loop(app, 3200, function () { show(cur + 1); });
    } else if (timer) { timer.stop(); timer = null; }
    playBtn.setAttribute('aria-pressed', timer ? 'true' : 'false');
    playBtn.textContent = timer ? 'Pause' : 'Play';
  }

  qbs.forEach(function (b, n) { b.addEventListener('click', function () { setPlaying(false); show(n); }); });
  $('prev').addEventListener('click', function () { setPlaying(false); show(cur - 1); });
  $('next').addEventListener('click', function () { setPlaying(false); show(cur + 1); });
  playBtn.addEventListener('click', function () { setPlaying(!timer); });
  mark();
  if (BDH.reduced) { show(N - 1); return; }   /* reduced motion: the finished structure, controls still step */

  /* autoplay until someone touches the timeline; Play hands it back on request */
  setPlaying(true);
  BDH.onInteract(app, function (e) {
    if (e && e.target && e.target.closest && e.target.closest('[data-m="play"]')) return;
    setPlaying(false);
  });
})();
