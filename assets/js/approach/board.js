/* Approach board — replays one job lane by lane, writes the audit log as it goes, and stops at the
   human gate for Approve / Send back. Without JS (or with reduced motion) the finished run is shown;
   the job links still work as ?run=<key>#board. */
(function () { 'use strict'; if (!window.BDH) return;
  var root = document.querySelector('[data-apr-board]'); if (!root) return;
  var dataEl = document.getElementById('apr-board-data'); if (!dataEl) return;
  var SC; try { SC = JSON.parse(dataEl.textContent); } catch (e) { return; }
  var ORDER = ['signal', 'agent', 'eval', 'guard', 'gate', 'ship'];
  var NOTE = { campaign: 'tighten the claims', code: 'cover the empty-card case', support: 'quote the returns window' };
  var LANE_OF = { signal: 0, brief: 0, agent: 1, eval: 2, guard: 3, gate: 4, ship: 5, review: 5 };
  var lanes = ORDER.map(function (k) { return root.querySelector('[data-lane="' + k + '"]'); });
  var log = root.querySelector('[data-apr-log]'), status = root.querySelector('[data-apr-status]');
  var ask = root.querySelector('[data-apr-ask]'), ctl = root.querySelector('[data-apr-ctl]');
  var picks = root.querySelectorAll('[data-run]');
  var run = root.getAttribute('data-run'), timers = [], waiting = false, touched = false, sentBack = 0;

  ctl.hidden = false;
  function later(ms, fn) { timers.push(setTimeout(fn, BDH.reduced ? 0 : ms)); }
  function clear() { timers.forEach(clearTimeout); timers = []; }
  function say(t) { status.textContent = t; }
  function fill(i) {
    var v = SC[run].lanes[ORDER[i]];
    lanes[i].querySelectorAll('[data-f]').forEach(function (el) { el.textContent = v[+el.getAttribute('data-f')]; });
  }
  function entry(time, text, cls) {
    var li = document.createElement('li'), t = document.createElement('time'), s = document.createElement('span');
    t.textContent = time; s.textContent = text; li.appendChild(t); li.appendChild(s);
    if (cls) li.className = cls;
    log.querySelectorAll('.is-new').forEach(function (x) { x.classList.remove('is-new'); });
    li.classList.add('is-new'); log.appendChild(li); log.scrollTop = log.scrollHeight;
  }
  function linesFor(i) { return SC[run].log.filter(function (e) { return LANE_OF[e[1].split('.')[0]] === i; }); }
  function mark(i, state) {
    lanes.forEach(function (l, n) { l.classList.remove('is-cur'); if (n > i) l.classList.remove('is-done'); });
    if (state === 'cur') lanes[i].classList.add('is-cur'); else lanes[i].classList.add('is-done');
  }
  function finished() {
    root.classList.remove('is-anim'); lanes.forEach(function (l) { l.classList.add('is-done'); l.classList.remove('is-cur'); });
    ask.hidden = true; waiting = false;
  }
  function renderStatic() {
    clear(); ORDER.forEach(function (k, i) { fill(i); }); log.textContent = '';
    SC[run].log.forEach(function (e) { entry(e[0], e[1]); });
    log.querySelectorAll('.is-new').forEach(function (x) { x.classList.remove('is-new'); });
    finished(); say('Finished · approved');
  }
  function step(i) {
    if (i >= ORDER.length) { finished(); say('Finished · approved · logged'); return; }
    fill(i); mark(i, 'cur'); say('Running · ' + lanes[i].querySelector('.apr-ln__k').textContent.replace(/^\d+/, '').trim());
    if (i === 4) { gate(); return; }
    later(700, function () { linesFor(i).forEach(function (e) { entry(e[0], e[1]); }); mark(i, 'done'); later(500, function () { step(i + 1); }); });
  }
  function gate() {
    waiting = true; ask.hidden = false; say('Waiting on a named approver');
    if (!touched) later(5200, function () { if (waiting) approve(true); });
  }
  function approve(auto) {
    if (!waiting) return; waiting = false; ask.hidden = true; clear();
    linesFor(4).forEach(function (e) { entry(e[0], e[1] + (auto ? '' : ' · by you')); });
    mark(4, 'done'); later(500, function () { step(5); });
  }
  function sendBack() {
    if (!waiting) return; waiting = false; ask.hidden = true; clear(); sentBack++;
    entry('now', 'gate · sent back · note: "' + (NOTE[run] || 'revise') + '"', 'is-warn');
    say('Sent back · the agent is redrafting');
    mark(1, 'cur');
    later(900, function () { entry('now', 'agent.redraft · note applied · v' + (sentBack + 1)); mark(1, 'done'); mark(2, 'cur');
      later(800, function () { entry('now', 'eval.rerun · pass'); mark(2, 'done'); mark(3, 'done'); mark(4, 'cur'); gate(); }); });
  }
  function play() {
    clear(); sentBack = 0; root.classList.add('is-anim'); log.textContent = ''; ask.hidden = true; waiting = false;
    lanes.forEach(function (l) { l.classList.remove('is-done', 'is-cur'); });
    later(300, function () { step(0); });
  }
  function choose(k) {
    if (!SC[k]) return; run = k; root.setAttribute('data-run', k);
    picks.forEach(function (p) { if (p.getAttribute('data-run') === k) p.setAttribute('aria-current', 'true'); else p.removeAttribute('aria-current'); });
    try { history.replaceState(null, '', '?run=' + k + '#board'); } catch (e) {}
    if (BDH.reduced) renderStatic(); else play();
  }
  root.querySelectorAll('.apr-bd__pick').forEach(function (a) {
    a.addEventListener('click', function (ev) { ev.preventDefault(); touched = true; choose(a.getAttribute('data-run')); });
  });
  root.querySelector('[data-apr-play]').addEventListener('click', function () { touched = true; if (BDH.reduced) renderStatic(); else play(); });
  root.querySelector('[data-apr-yes]').addEventListener('click', function () { touched = true; approve(false); });
  root.querySelector('[data-apr-no]').addEventListener('click', function () { touched = true; sendBack(); });
  if (BDH.reduced) return;
  BDH.inView(root, function () { if (!touched) play(); });
})();
