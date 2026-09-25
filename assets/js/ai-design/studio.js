/* Studio showcase — a small state machine: idle → routing → generating → checking → review → (sent back → review) → published. */
(function () {
  'use strict';
  var root = document.querySelector('.aih-studio');
  if (!root) return;
  var dataEl = document.getElementById('aih-st-data');
  if (!dataEl) return;
  var REQ;
  try { REQ = JSON.parse(dataEl.textContent); } catch (e) { return; }
  var reduced = !!(window.BDH && window.BDH.reduced) ||
    (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
  var st = root.querySelector('.aih-st');
  var floor = parseFloat(st.getAttribute('data-floor')) || 0.85;
  var $ = function (s, r) { return (r || root).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || root).querySelectorAll(s)); };
  var LANES = ['text', 'image', 'voice', 'video'];
  var NAMES = { text: 'Text', image: 'Image', voice: 'Voice', video: 'Video' };
  var CHECKS = { brand: 'brand', rights: 'rights', safety: 'safety' };
  var presetBtns = $$('[data-st-preset]');
  var runBtn = $('[data-st-run]'), sendBtn = $('[data-st-send]'), okBtn = $('[data-st-approve]');
  var logEl = $('[data-st-log]'), sumEl = $('[data-st-sum]'), ridEl = $('[data-st-rid]'), briefEl = $('[data-st-brief]');
  var cur = 0, timers = [], t0 = 0, flagged = [], busy = false, published = false;

  $$('[data-st-js]').forEach(function (el) { el.hidden = false; });

  function laneEl(k) { return $('.aih-ln[data-lane="' + k + '"]'); }
  function f(el, name) { return el.querySelector('[data-f="' + name + '"]'); }
  function clear() { timers.forEach(clearTimeout); timers = []; }
  function at(ms, fn) { if (reduced) { fn(); return; } timers.push(setTimeout(fn, ms)); }
  function stamp() {
    var s = reduced ? 0 : (Date.now() - t0) / 1000;
    var m = Math.floor(s / 60), r = (s % 60).toFixed(1);
    return (m < 10 ? '0' : '') + m + ':' + (r < 10 ? '0' : '') + r;
  }
  function log(text, key) {
    var li = document.createElement('li');
    li.className = 'is-new' + (key ? ' is-key' : '');
    var t = document.createElement('time'); t.textContent = stamp();
    var s = document.createElement('span'); s.textContent = text;
    li.appendChild(t); li.appendChild(s);
    logEl.appendChild(li);
    logEl.scrollTop = logEl.scrollHeight;
  }
  function setLane(k, state, ln) {
    var el = laneEl(k);
    el.setAttribute('data-st', state);
    var label = { idle: 'Queued', route: 'Routed', run: 'Running', pass: 'Passed', flag: 'Flagged', skip: 'Skipped', fixed: 'Passed' }[state];
    f(el, 'st').textContent = label;
    if (state === 'fixed') el.setAttribute('data-st', 'pass');
    if (!ln) return;
    f(el, 'm').textContent = ln.skip || (state === 'idle' ? 'Waiting for the router' : ln.m);
    f(el, 'why').textContent = (state === 'idle' || ln.skip) ? '' : ln.why;
    f(el, 'out').textContent = (state === 'pass' || state === 'flag' || state === 'fixed') ? (ln.out || '') : '';
    var fill = el.querySelector('.aih-ln__fill');
    var showV = state === 'pass' || state === 'flag' || state === 'fixed';
    fill.style.setProperty('--v', showV ? String(ln.v) : '0');
    f(el, 'v').textContent = showV ? ln.v.toFixed(2) : '—';
    var fl = f(el, 'flag');
    fl.textContent = state === 'flag' ? ln.flag.note : (state === 'fixed' ? 'Resolved: ' + ln.flag.fix : '');
    el.querySelectorAll('.aih-ln__chk li').forEach(function (c) {
      var ck = c.getAttribute('data-c'), s = 'off';
      if (ln.skip) s = 'off';
      else if (state === 'run') s = 'run';
      else if (state === 'flag') s = (ln.flag && ln.flag.c === ck) ? 'flag' : 'pass';
      else if (state === 'pass' || state === 'fixed') s = 'pass';
      c.setAttribute('data-s', s);
    });
  }
  function setPressed(i) {
    presetBtns.forEach(function (b, j) { b.setAttribute('aria-pressed', j === i ? 'true' : 'false'); });
  }
  function controls() {
    sendBtn.disabled = busy || published || flagged.length === 0;
    okBtn.disabled = busy || published || flagged.length > 0;
    runBtn.disabled = busy;
    okBtn.textContent = published ? 'Published' : 'Approve and publish';
  }
  function summary() {
    var r = REQ[cur];
    if (published) { sumEl.textContent = 'Approved and published. Every output carries its record: model, scores, checks and approver.'; return; }
    if (busy) { sumEl.textContent = 'Running. Review opens when every lane has cleared its guardrails and the eval floor.'; return; }
    if (flagged.length) {
      var k = flagged[0];
      sumEl.textContent = flagged.length + ' lane flagged. ' + NAMES[k] + ': ' + r.lanes[k].flag.note;
    } else {
      sumEl.textContent = 'Every lane passed. Ready for your approval.';
    }
  }

  function run(i) {
    clear();
    cur = i; published = false; busy = true; flagged = []; t0 = Date.now();
    var r = REQ[i];
    setPressed(i);
    ridEl.textContent = r.id;
    briefEl.textContent = r.brief;
    logEl.innerHTML = '';
    LANES.forEach(function (k) { setLane(k, r.lanes[k].skip ? 'skip' : 'idle', r.lanes[k]); });
    controls(); summary();
    log('Request ' + r.id + ' received', true);
    at(400, function () {
      var used = LANES.filter(function (k) { return !r.lanes[k].skip; });
      log('Brief parsed · ' + used.length + ' lanes needed');
    });
    var d = 900;
    LANES.forEach(function (k) {
      var ln = r.lanes[k];
      if (ln.skip) return;
      at(d, function () { setLane(k, 'route', ln); log(NAMES[k] + ' → ' + ln.m); });
      d += 350;
    });
    LANES.forEach(function (k, n) {
      var ln = r.lanes[k];
      if (ln.skip) return;
      at(d + 200, function () { setLane(k, 'run', ln); });
      at(d + 1500 + n * 450, function () {
        if (ln.v < floor) { setLane(k, 'flag', ln); return; }
        if (ln.flag) { setLane(k, 'flag', ln); flagged.push(k); log(NAMES[k] + ' flagged · ' + ln.flag.c + ' check', true); }
        else { setLane(k, 'pass', ln); log(NAMES[k] + ' passed · eval ' + ln.v.toFixed(2)); }
      });
    });
    at(d + 1500 + 4 * 450 + 300, function () {
      busy = false;
      log('Waiting for a named approver', true);
      controls(); summary();
      (flagged.length ? sendBtn : okBtn).focus({ preventScroll: true });
    });
  }

  function sendBack() {
    if (!flagged.length || busy) return;
    var k = flagged[0], ln = REQ[cur].lanes[k];
    busy = true; controls();
    log('Approver sent ' + NAMES[k] + ' back · ' + ln.flag.c, true);
    setLane(k, 'run', ln); summary();
    at(1400, function () {
      flagged.shift();
      setLane(k, 'fixed', ln);
      log(NAMES[k] + ' regenerated · all checks passed');
      busy = false; controls(); summary();
      if (!flagged.length) okBtn.focus({ preventScroll: true });
    });
  }

  function approve() {
    if (flagged.length || busy || published) return;
    published = true;
    log('Approved by creative director · signed record stored', true);
    log('Published · content credentials attached to every file');
    controls(); summary();
  }

  /* initial: mirror the shipped HTML (request 1, one flag, awaiting review) */
  flagged = ['voice'];
  controls();

  presetBtns.forEach(function (b) {
    b.addEventListener('click', function () { run(parseInt(b.getAttribute('data-st-preset'), 10)); });
  });
  runBtn.addEventListener('click', function () { run(cur); });
  sendBtn.addEventListener('click', sendBack);
  okBtn.addEventListener('click', approve);
})();
