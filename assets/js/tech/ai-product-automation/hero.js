/* AI Product & Automation · hero — replays an invoice extraction on the photograph: scan, layout boxes
   draw one by one with confidence counting up and the JSON field typing in, validation flags the one
   field below 0.90 (a quantity corrected by hand), an AP clerk approves, the invoice posts to the ERP. Loops only while on screen; Pause stops on the
   finished state, Play restarts. Reduced motion: the finished state from the HTML, no loop. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tap-hero'); if (!root) return;
  if (BDH.reduced) return;

  var fig = root.querySelector('.tap-hero__fig');
  var boxes = BDH.$$('.tap-hbox', root);
  var lines = BDH.$$('[data-hl]', root);
  var steps = BDH.$$('.tap-hero__steps li', root);
  var routeBox = root.querySelector('.tap-hjson__route');
  var route = root.querySelector('[data-route]');
  var btn = root.querySelector('[data-hero-pause]');
  var THRESH = 0.9;
  var FINAL_ROUTE = route ? route.textContent : '';
  var finals = lines.map(function (l) {
    return { v: l.querySelector('[data-v]').textContent, c: l.querySelector('[data-c]').textContent };
  });
  var typers = [], raf = [], run = null;

  function stage(n) {   // n = steps completed; the ticker names the current step (the last one once all are done)
    steps.forEach(function (li, i) {
      li.classList.toggle('is-done', i < n);
      li.classList.toggle('is-on', i === Math.min(n, steps.length - 1));
    });
  }
  function say(state, text) { routeBox.setAttribute('data-route-state', state); route.textContent = text; }
  function halt() {
    typers.forEach(function (t) { t.stop(); }); typers = [];
    raf.forEach(cancelAnimationFrame); raf = [];
  }

  function countTo(el, target) {
    var t0 = null, dur = 650, to = parseFloat(target);
    var id = requestAnimationFrame(function tick(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / dur), k = 1 - Math.pow(1 - p, 3);
      el.textContent = (to * k).toFixed(2);
      if (p < 1) raf.push(requestAnimationFrame(tick)); else el.textContent = target;
    });
    raf.push(id);
  }

  function blank() {
    halt();
    fig.classList.remove('is-scan');
    boxes.forEach(function (b) { b.classList.remove('is-on'); });
    lines.forEach(function (l) {
      l.classList.remove('is-on', 'is-new', 'is-flag');
      l.querySelector('[data-v]').textContent = '';
      l.querySelector('[data-c]').textContent = '0.00';
    });
    stage(0);
    say('run', 'Invoice received · ap inbox · 1 page');
  }

  function field(k) {
    var b = boxes[k], l = lines[k];
    lines.forEach(function (x) { x.classList.remove('is-new'); });
    b.classList.add('is-on');
    l.classList.add('is-on', 'is-new');
    typers.push(BDH.type(l.querySelector('[data-v]'), finals[k].v, { speed: 26 }));
    countTo(l.querySelector('[data-c]'), finals[k].c);
    say('run', 'Extracting · field ' + (k + 1) + ' of ' + boxes.length);
  }

  function finished() {
    halt();
    fig.classList.remove('is-scan');
    boxes.forEach(function (b) { b.classList.add('is-on'); });
    lines.forEach(function (l, i) {
      l.classList.add('is-on'); l.classList.remove('is-new');
      l.querySelector('[data-v]').textContent = finals[i].v;
      l.querySelector('[data-c]').textContent = finals[i].c;
      l.classList.toggle('is-flag', parseFloat(finals[i].c) < THRESH);
    });
    stage(steps.length);
    say('post', FINAL_ROUTE);
  }

  var low = lines.map(function (l, i) { return parseFloat(finals[i].c) < THRESH ? l.querySelector('.k').textContent.replace(/"/g, '') + ' ' + finals[i].c : null; })
    .filter(Boolean)[0] || '';
  var timeline = [
    [900,  function () { blank(); }],
    [700,  function () { stage(0); say('run', 'Invoice received · ap inbox · 1 page · 300 dpi'); }],
    [800,  function () { stage(1); say('run', 'Deskew and layout analysis'); fig.classList.remove('is-scan'); void fig.offsetWidth; fig.classList.add('is-scan'); }],
    [1400, function () { stage(2); field(0); }]
  ];
  boxes.slice(1).forEach(function (b, k) { timeline.push([850, function () { field(k + 1); }]); });
  timeline.push(
    [1100, function () {
      stage(3);
      lines.forEach(function (l, i) { l.classList.remove('is-new'); l.classList.toggle('is-flag', parseFloat(finals[i].c) < THRESH); });
      say('run', 'Validating · GSTIN ok · 1 field below 0.90');
    }],
    [1300, function () { stage(4); say('wait', 'Waiting for AP clerk · ' + low); }],
    [2400, function () { stage(5); say('post', FINAL_ROUTE); }],
    [900,  function () { stage(steps.length); }],
    [4200, function () {}]
  );

  function start() {
    if (run) run.stop();
    blank();
    run = BDH.seq(fig, timeline, { loop: true, stopOnInteract: false });
    if (btn) { btn.textContent = 'Pause'; btn.setAttribute('aria-pressed', 'false'); btn.setAttribute('aria-label', 'Pause the extraction demo'); }
  }
  function stop() {
    if (run) { run.stop(); run = null; }
    finished();
    if (btn) { btn.textContent = 'Play'; btn.setAttribute('aria-pressed', 'true'); btn.setAttribute('aria-label', 'Play the extraction demo'); }
  }

  if (btn) {
    btn.hidden = false;
    btn.addEventListener('click', function () { if (run) stop(); else start(); });
  }
  start();
})();
