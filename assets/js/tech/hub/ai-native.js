/* Hub · AI-native — the delivery console. One ticket runs Spec → Code → Tests → Evals → Security, then waits
   at Review until a person approves (the demo presses Approve itself after two seconds), then canaries and goes
   live. The log writes a line as each stage completes and the detail pane follows the running stage.
   After the first interaction the demo stops and the controls are real: inspect any stage, re-run the
   pipeline, approve or request changes. The PR diff and eval report animate the first time they open.
   Reduced motion: the markup's finished run stays; the controls still work, instantly. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tih-ain');
  if (!root) return;

  var sts = BDH.$$('.tih-ain__st', root);
  var sbs = BDH.$$('.tih-ain__sb', root);
  var dps = BDH.$$('.tih-ain__dp', root);
  var lines = BDH.$$('.tih-ain__lines li', root);
  var fill = BDH.$('.tih-ain__fill', root);
  var stxt = BDH.$('.tih-ain__stxt', root);
  var approve = BDH.$('.tih-ain__approve', root);
  var changes = BDH.$('.tih-ain__changes', root);
  var gdt = BDH.$('.tih-ain__gdt', root);
  var rerun = BDH.$('.tih-ain__rerun', root);
  var clock = BDH.$('.tih-ain__clock', root);
  if (!sts.length) return;

  var N = sts.length, REVIEW = 5, DEPLOY = 6;
  var NAMES = sts.map(function (s) { var n = s.querySelector('.tih-ain__sn'); return n ? n.lastChild.textContent.trim() : ''; });
  var depOut = dps[DEPLOY] && dps[DEPLOY].querySelector('.tih-ain__art span:last-child');
  var DEP_TEXT = depOut ? depOut.textContent : '';
  var DONE_TEXT = stxt ? stxt.textContent : '';
  var at = N, state = 'done', pinned = -1, timers = [], run = 3;

  function later(fn, ms) { if (BDH.reduced) { fn(); return; } timers.push(setTimeout(fn, ms)); }
  function clear() { timers.forEach(clearTimeout); timers = []; }
  function status(t) { if (stxt) stxt.textContent = t; }

  function show(i) {
    dps.forEach(function (d, n) { d.classList.toggle('is-on', n === i); });
    sbs.forEach(function (b, n) { b.setAttribute('aria-pressed', n === i ? 'true' : 'false'); });
  }

  function paint() {
    sts.forEach(function (s, j) {
      s.classList.toggle('is-done', j < at);
      s.classList.toggle('is-run', j === at && state === 'run');
      s.classList.toggle('is-wait', j === at && state === 'wait');
    });
    if (fill) fill.style.setProperty('--p', String(at >= N ? 1 : at / (N - 1)));
    lines.forEach(function (l, j) { l.classList.toggle('is-on', j < at); });
    root.setAttribute('data-review', at < REVIEW ? 'pending' : (at === REVIEW ? 'wait' : 'done'));
    if (state === 'done') status(DONE_TEXT);
    else if (state === 'wait') status('Waiting for review');
    else status('Running · ' + NAMES[at]);
    if (pinned < 0) show(Math.min(at, N - 1));
  }

  function flash(j) {
    var l = lines[j];
    if (!l || BDH.reduced) return;
    l.classList.add('is-new');
    setTimeout(function () { l.classList.remove('is-new'); }, 900);
  }

  function complete(j) {
    at = j + 1;
    state = at >= N ? 'done' : (at === REVIEW ? 'wait' : 'run');
    if (j === DEPLOY && depOut) depOut.textContent = DEP_TEXT;
    paint(); flash(j);
  }

  function reset() {
    at = 0; state = 'run';
    if (approve) approve.classList.remove('is-press');
    if (depOut) depOut.textContent = DEP_TEXT;
    run++;
    if (clock) clock.textContent = 'XE-1482 · run ' + run;
    paint();
  }

  function canary(pct) {
    status('Canary · ' + pct + '% of traffic');
    if (depOut) depOut.textContent = 'canary ' + pct + '% · watching error rate and p95';
  }

  /* ---- manual chains ---- */
  function toReview(from) {
    for (var j = from; j < REVIEW; j++) {
      (function (j, n) { later(function () { complete(j); }, 900 * n); })(j, j - from + 1);
    }
  }
  function toLive() {
    later(function () { canary(25); }, 900);
    later(function () { canary(100); }, 1800);
    later(function () { complete(DEPLOY); }, 2500);
    later(function () { complete(DEPLOY + 1); }, 3900);
  }
  function doApprove(byUser) {
    if (at !== REVIEW || state !== 'wait') return;
    clear();
    if (approve) approve.classList.remove('is-press');
    if (gdt) gdt.textContent = byUser ? 'Approved by you, as reviewer · logged' : 'Approved by the tech lead · 17:12 · logged';
    complete(REVIEW);
    canary(5);
    if (byUser) toLive();
  }

  if (approve) approve.addEventListener('click', function () { doApprove(true); });
  if (changes) changes.addEventListener('click', function () {
    if (at !== REVIEW || state !== 'wait') return;
    clear();
    at = 1; state = 'run'; pinned = -1;
    paint();
    status('Changes requested · back to Code');
    toReview(1);
  });
  if (rerun) rerun.addEventListener('click', function () {
    clear(); pinned = -1;
    reset();
    toReview(0);
  });

  /* ---- inspect a stage: click, or arrows between stages ---- */
  sbs.forEach(function (b, i) {
    b.addEventListener('click', function () { pinned = i; show(i); });
    b.addEventListener('keydown', function (e) {
      var j = e.key === 'ArrowRight' ? i + 1 : e.key === 'ArrowLeft' ? i - 1 : e.key === 'Home' ? 0 : e.key === 'End' ? N - 1 : -1;
      if (j < 0 || j >= N) return;
      e.preventDefault();
      sbs[j].focus(); pinned = j; show(j);
    });
  });

  /* ---- tabs: the diff and the eval report play the first time they open ---- */
  var played = {};
  BDH.tabs(root, {
    tabs: '.tih-ain__tabs [role="tab"]',
    onChange: function (i) {
      var pane = document.getElementById('ai-native-p' + i);
      if (!pane || played[i] || BDH.reduced || (i !== 1 && i !== 2)) return;
      played[i] = true;
      pane.classList.remove('is-run'); void pane.offsetWidth; pane.classList.add('is-run');
    }
  });

  /* ---- autoplay until the reader takes over ---- */
  if (BDH.reduced) return;
  var DUR = [1500, 1700, 1200, 1300, 1200];
  var steps = [[800, function () { pinned = -1; reset(); }]];
  DUR.forEach(function (ms, j) { steps.push([ms, function () { complete(j); }]); });
  steps.push([2000, function () { if (approve) approve.classList.add('is-press'); }]);
  steps.push([350, function () { doApprove(false); }]);
  steps.push([900, function () { canary(25); }]);
  steps.push([900, function () { canary(100); }]);
  steps.push([700, function () { complete(DEPLOY); }]);
  steps.push([1500, function () { complete(DEPLOY + 1); }]);
  steps.push([4500, function () {}]);

  BDH.seq(root, steps, {
    loop: true,
    onStop: function () {
      if (approve) approve.classList.remove('is-press');
      /* hand over cleanly: a stage that was running finishes on its own; Review waits for the reader */
      if (state !== 'run') return;
      if (at < REVIEW) toReview(at);
      else if (at === DEPLOY) { canary(100); later(function () { complete(DEPLOY); }, 700); later(function () { complete(DEPLOY + 1); }, 2100); }
      else if (at > DEPLOY) later(function () { complete(at); }, 900);
    }
  });
})();
