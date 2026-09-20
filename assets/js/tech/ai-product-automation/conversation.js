/* AI Product & Automation · conversation — replays the chat from turn 3 (turns 1–2 and their tool call are
   already on the desk when the section comes into view, so neither panel starts empty): typing indicators
   of about 600 ms, a message every second or so, the agent desk moving with it — intent and confidence per
   turn, the trace dipping under 0.60, tool calls, redaction, the handover banner, the person's reply. The
   whole run takes about 7 s, holds, then loops while on screen until the first interaction inside the demo;
   Replay runs it once more. Chat / Voice call is an ARIA tablist and swaps the desk to that channel's own
   state; the voice pane streams its transcript line by line (timestamps, a barge-in, OTP verification).
   Reduced motion: the finished states from the HTML, no loops. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tap-cv'); if (!root) return;
  var R = BDH.reduced;
  var main = root.querySelector('.tap-cv__main');
  var steps = BDH.$$('[data-s]', root);
  var msgs = BDH.$$('.tap-cv__msg', root);
  var intentEl = root.querySelector('[data-cv-intent]');
  var confEl = root.querySelector('[data-cv-conf]');
  var confW = root.querySelector('[data-cv-confw]');
  var replay = root.querySelector('[data-cv-replay]');
  var desks = BDH.$$('[data-desk]', root);
  var dkch = root.querySelector('[data-cv-dkch]');
  var path = root.querySelector('[data-cv-path]');
  var voicePane = root.querySelector('.tap-cv__voice');
  var voiceLines = BDH.$$('.tap-cv__trl', root);
  var vsteps = BDH.$$('[data-vs]', root.querySelector('[data-desk="1"]') || root).concat(voiceLines);
  var clock = root.querySelector('[data-cv-clock]');
  var CLOCK = clock ? clock.textContent : '';
  var MAX = 7, START = 2, run = null, vrun = null, typers = [], tab = 0;

  function show(n, typingNext) {
    steps.forEach(function (el) { el.classList.toggle('is-hid', parseInt(el.getAttribute('data-s'), 10) > n); });
    msgs.forEach(function (m) { m.classList.remove('is-typing'); });
    if (typingNext) {
      var next = msgs.filter(function (m) { return parseInt(m.getAttribute('data-s'), 10) === n + 1; })[0];
      if (next) { next.classList.remove('is-hid'); next.classList.add('is-typing'); }
    }
    var intent = '—', conf = null;
    msgs.forEach(function (m) {
      if (parseInt(m.getAttribute('data-s'), 10) <= n && m.getAttribute('data-intent')) { intent = m.getAttribute('data-intent'); conf = m.getAttribute('data-conf'); }
    });
    intentEl.textContent = intent;
    confEl.textContent = conf || '—';
    confW.style.setProperty('--v', conf || 0);
    confW.classList.toggle('is-low', !conf || parseFloat(conf) < 0.6);
    root.setAttribute('data-cv-at', String(n));
    if (vk && tab === 0) vk.textContent = conf || '—';
  }

  /* about 7 s from turn 3 to the person's reply */
  var timeline = [
    [0,    function () { show(START); }],
    [450,  function () { show(START, true); }],
    [600,  function () { show(3); }],
    [500,  function () { show(3, true); }],
    [600,  function () { show(4); }],
    [900,  function () { show(4, true); }],
    [600,  function () { show(5); }],
    [900,  function () { show(5, true); }],
    [650,  function () { show(6); }],
    [1100, function () { show(6, true); }],
    [700,  function () { show(7); }],
    [5600, function () {}]
  ];

  function finished() { show(MAX); }
  function start(loop) {
    if (run) run.stop();
    show(START);
    run = BDH.seq(root, timeline, {
      loop: loop, stopOnInteract: loop, interactRoot: main,
      onStop: function () { run = null; finished(); }
    });
  }

  /* ---- voice call: its own transcript stream and desk state ---- */
  function vshow(n, streamIdx) {
    vsteps.forEach(function (el) {
      var k = el.hasAttribute('data-v') ? parseInt(el.getAttribute('data-v'), 10) : null;
      var hid = k !== null ? k > n : parseInt(el.getAttribute('data-vs'), 10) > (n < 0 ? 0 : parseInt(voiceLines[n].getAttribute('data-vs'), 10));
      el.classList.toggle('is-hid', hid);
    });
    voiceLines.forEach(function (l, i) { l.classList.toggle('is-stream', i === streamIdx); });
    if (clock) clock.textContent = n < 0 ? '00:00' : voiceLines[n].getAttribute('data-t').slice(0, 5);
  }
  function vstop() {
    if (vrun) { vrun.stop(); vrun = null; }
    typers.forEach(function (t) { t.finish(); }); typers = [];
  }
  function vfinished() {
    vstop();
    vsteps.forEach(function (el) { el.classList.remove('is-hid', 'is-stream'); });
    if (clock) clock.textContent = CLOCK;
  }
  function vstart() {
    vstop();
    var vt = [[0, function () { vshow(-1); }]];
    voiceLines.forEach(function (l, i) {
      var tx = l.querySelector('.tap-cv__trx'), full = tx.textContent, ev = l.classList.contains('is-ev');
      vt.push([i === 0 ? 500 : (ev ? 350 : 700), function () {
        vshow(i, ev ? -1 : i);
        if (ev) return;
        tx.textContent = '';
        typers.push(BDH.type(tx, full, { speed: 22, done: function () { l.classList.remove('is-stream'); } }));
      }]);
    });
    vt.push([4800, function () {}]);
    vrun = BDH.seq(voicePane, vt, { loop: true, stopOnInteract: true, interactRoot: main, onStop: function () { vrun = null; vfinished(); } });
  }

  function channel(i) {
    tab = i;
    if (vk) vk.textContent = i === 1 ? '0.94' : (confEl.textContent || '0.41');
    desks.forEach(function (d, n) { d.classList.toggle('is-on', n === i); });
    if (dkch) dkch.textContent = i === 1 ? 'voice' : 'chat';
    if (path) path.textContent = i === 1 ? 'call 2208' : 'conversation 7731';
  }

  /* phone: Conversation | Agent desk switch (aria-pressed); the badge shows the desk's live confidence */
  var views = BDH.$$('[data-cv-view]', root), vk = root.querySelector('[data-cv-vk]');
  if (views.length) {
    root.classList.add('has-view');
    views.forEach(function (b) {
      b.addEventListener('click', function () {
        views.forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
        root.classList.toggle('is-desk', b.getAttribute('data-cv-view') === '1');
      });
    });
  }

  BDH.tabs(root.querySelector('.tap-cv__mode'), {
    tabs: '[role="tab"]',
    onChange: function (i) {
      channel(i);
      if (i === 1) {
        if (run) { run.stop(); }
        finished();
        if (R) vfinished(); else vstart();
      } else {
        vfinished();
      }
    }
  });
  BDH.live(voicePane, 0.2);

  if (replay) replay.addEventListener('click', function () {
    if (R) { finished(); vfinished(); return; }
    if (tab === 1) vstart(); else start(false);
  });

  if (R) return;
  /* autoplay only if nobody has touched the demo before it came into view */
  var touched = false;
  BDH.onInteract(main, function () { touched = true; });
  BDH.inView(root, function () { if (!touched && tab === 0) start(true); }, { threshold: 0.2 });
})();
