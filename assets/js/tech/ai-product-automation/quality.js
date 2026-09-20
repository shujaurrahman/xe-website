/* AI Product & Automation · quality — replays the release: gates run one by one and pass; the red-team gate
   blocks on one indirect prompt injection that succeeded through a retrieved document, the fix appears, the
   re-run (with that attack added) passes; human sign-off waits, then approves; the release goes to canary.
   The replay starts straight in the running state, with transitions off for the reset frame, so no gate
   ever shows a check beside "queued". Loops while on screen until the visitor touches the window; "Run the
   gates" replays once. Gate rows select the detail pane on the right (aria-pressed). Reduced motion: the
   finished run from the HTML; selection still works; Run steps instantly to the finished state. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tap-qg'); if (!root) return;
  var R = BDH.reduced;
  var win = root.querySelector('.tap-qg__run');
  var gates = BDH.$$('.tap-qg__gate', root);
  var sels = BDH.$$('[data-qg-sel]', root);
  var panes = BDH.$$('.tap-qg__pane', root);
  var status = root.querySelector('[data-qg-status]');
  var btn = root.querySelector('[data-qg-run]');
  var fix = root.querySelector('[data-qg-fix]');
  var time = root.querySelector('[data-qg-time]');
  var live = root.querySelector('[data-qg-live]');
  var finals = gates.map(function (g) { return g.querySelector('[data-qg-final]').textContent; });
  var FINAL_TIME = time ? time.textContent : '';
  var run = null;

  function select(i) {
    sels.forEach(function (b, k) { b.setAttribute('aria-pressed', String(k === i)); });
    panes.forEach(function (p, k) { p.classList.toggle('is-on', k === i); });
  }
  sels.forEach(function (b, k) { b.addEventListener('click', function () { select(k); }); });

  /* phone swipe row: focusable (and named) only while it actually scrolls sideways, so keyboards can reach it */
  function swipeFocus(el, label) {
    if (!el) return;
    function sync() {
      var on = el.scrollWidth > el.clientWidth + 2, list = el.tagName === 'UL' || el.tagName === 'OL';
      if (on) { el.setAttribute('tabindex', '0'); el.setAttribute('aria-label', label); if (!list) el.setAttribute('role', 'region'); }
      else { el.removeAttribute('tabindex'); if (!list) { el.removeAttribute('role'); el.removeAttribute('aria-label'); } }
    }
    sync();
    window.addEventListener('resize', sync, { passive: true });
  }
  swipeFocus(document.querySelector('.tap-qg__badges'), 'Frameworks we build to, scroll sideways for more');


  function state(i, st, text) {
    var g = gates[i]; if (!g) return;
    g.className = 'tap-qg__gate is-' + st;
    if (text != null) g.querySelector('[data-qg-final]').textContent = text;
  }
  function stat(text, led) { status.innerHTML = '<span class="tap-led' + (led ? ' ' + led : '') + '"></span>'; status.appendChild(document.createTextNode(text)); }
  function say(t) { if (live) live.textContent = t; }

  function finished() {
    gates.forEach(function (g, i) { state(i, 'pass', finals[i]); });
    if (fix) fix.hidden = true;
    if (time) time.textContent = FINAL_TIME;
    stat('Released · canary 5% → 100%');
  }
  function blank() {
    root.classList.add('no-tr');
    gates.forEach(function (g, i) { state(i, 'idle', 'queued'); });
    void root.offsetWidth;
    root.classList.remove('no-tr');
    if (fix) fix.hidden = true;
    if (time) time.textContent = '0 m 00 s';
    stat('Running gates', 'tap-led--pulse');
  }
  var t = 0;
  function clock(add) { t += add; if (time) time.textContent = Math.floor(t / 60) + ' m ' + (t % 60 < 10 ? '0' : '') + (t % 60) + ' s'; }

  var timeline = [
    [0,    function () { blank(); t = 0; state(0, 'run', 'running · 400 questions'); clock(48); }],
    [1500, function () { state(0, 'pass', finals[0]); clock(190); }],
    [450,  function () { state(1, 'run', 'replaying 1,200'); clock(30); }],
    [1100, function () { state(1, 'pass', finals[1]); clock(64); }],
    [400,  function () { state(2, 'run', '180 attacks'); clock(20); }],
    [1500, function () { state(2, 'block', 'blocked · 1 indirect injection via a retrieved doc'); stat('Blocked at gate 03', 'tap-led--off'); clock(52); say('Gate 3 blocked: one indirect prompt injection succeeded through a retrieved document.'); }],
    [1300, function () { if (fix) fix.hidden = false; clock(140); }],
    [1400, function () { state(2, 'run', 're-running · 181 attacks'); stat('Re-running gate 03', 'tap-led--pulse'); clock(60); }],
    [1400, function () { state(2, 'pass', finals[2]); clock(54); say('Gate 3 passed after the fix: 0 of 181 attacks succeeded.'); }],
    [400,  function () { state(3, 'run', 'scanning traces'); clock(10); }],
    [900,  function () { state(3, 'pass', finals[3]); clock(18); }],
    [400,  function () { state(4, 'run', 'computing p95'); clock(8); }],
    [900,  function () { state(4, 'pass', finals[4]); clock(6); }],
    [400,  function () { state(5, 'run', 'axe · keyboard'); clock(9); }],
    [900,  function () { state(5, 'pass', finals[5]); clock(11); }],
    [400,  function () { state(6, 'run', 'verifying manifest'); clock(4); }],
    [800,  function () { state(6, 'pass', finals[6]); clock(3); }],
    [400,  function () { state(7, 'wait', 'waiting for product owner'); stat('Waiting for sign-off', 'tap-led--wait'); clock(0); }],
    [2200, function () { state(7, 'pass', finals[7]); stat('Released · canary 5% → 100%'); if (time) time.textContent = FINAL_TIME; say('Approved. Released to a 5% canary, widening to 100% over 24 hours.'); }],
    [4200, function () {}]
  ];

  function start(loop) {
    if (run) run.stop();
    run = BDH.seq(win, timeline, { loop: loop, stopOnInteract: loop, interactRoot: win, onStop: function () { run = null; finished(); } });
  }
  if (btn) btn.addEventListener('click', function () {
    if (R) { finished(); say('Gates run. All eight passed; released to canary.'); return; }
    start(false);
  });

  if (R) return;
  /* autoplay only if nobody has touched the window before it came into view */
  var touched = false;
  BDH.onInteract(win, function () { touched = true; });
  BDH.inView(win, function () { if (!touched) start(true); }, { threshold: 0.3 });
})();
