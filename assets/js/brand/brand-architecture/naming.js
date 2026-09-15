/* 6 · Naming — the new-brand test. Yes/No walks the spine; an exit answer lights the branch to its
   outcome, four passes reach Sub-brand. Runs sample answers until the first interaction. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var app = document.querySelector('[data-cba-name]');
  var raw = document.getElementById('naming-data');
  if (!app || !raw) return;
  var D; try { D = JSON.parse(raw.textContent); } catch (e) { return; }
  var rows = BDH.$$('.cba-name__row', app);
  var $ = function (k) { return app.querySelector('[data-n="' + k + '"]'); };
  var yes = app.querySelector('[data-ans="yes"]'), no = app.querySelector('[data-ans="no"]');
  var step = 0;

  function paint() {
    rows.forEach(function (r, i) { r.classList.toggle('is-now', i === step && !app.classList.contains('is-done')); });
  }

  function ask(i) {
    var q = D.q[i];
    $('num').textContent = i + 1;
    $('q').textContent = q[0];
    $('help').textContent = q[1];
    $('state').textContent = 'Awaiting answer';
  }

  function finish(key, row) {
    var o = D.out[key];
    app.classList.add('is-done');
    var hit = row.querySelector('[data-out]');
    if (hit) hit.classList.add('is-hit');
    if (key === 'sub') row.classList.add('is-end-hit');
    $('state').textContent = 'Test complete';
    $('rname').textContent = o[0]; $('rform').textContent = o[1]; $('rrule').textContent = o[2];
    $('result').hidden = false;
    paint();
  }

  function answer(a) {
    if (app.classList.contains('is-done')) return;
    var q = D.q[step], row = rows[step];
    if (a === q[2]) { row.classList.add('is-exit'); finish(q[3], row); return; }
    row.classList.add('is-pass');
    step++;
    if (step >= D.q.length) { finish('sub', rows[rows.length - 1]); return; }
    ask(step); paint();
  }

  function reset() {
    step = 0;
    app.classList.remove('is-done');
    rows.forEach(function (r) { r.classList.remove('is-pass', 'is-exit', 'is-now', 'is-end-hit'); });
    BDH.$$('.is-hit', app).forEach(function (h) { h.classList.remove('is-hit'); });
    $('result').hidden = true;
    ask(0); paint();
  }

  yes.addEventListener('click', function () { answer('yes'); });
  no.addEventListener('click', function () { answer('no'); });
  $('reset').addEventListener('click', function () {
    reset();
    (yes.offsetParent ? yes : $('reset')).focus();
  });
  reset();
  if (BDH.reduced) return;

  /* sample runs: sub-brand, new brand, descriptor */
  var runs = [['yes', 'yes', 'yes', 'yes'], ['yes', 'no'], ['yes', 'yes', 'no']], steps = [];
  runs.forEach(function (run) {
    steps.push([1200, reset]);
    run.forEach(function (a) { steps.push([1500, function () { answer(a); }]); });
    steps.push([3600, function () {}]);
  });
  BDH.seq(app, steps, { loop: true, stopOnInteract: true, onStop: function () {} });
  BDH.onInteract(app, function (e) {
    /* the first touch hands over a clean test unless it was an answer button */
    if (!e || !e.target || !e.target.closest || !e.target.closest('[data-ans],[data-n="reset"]')) reset();
  });
})();
