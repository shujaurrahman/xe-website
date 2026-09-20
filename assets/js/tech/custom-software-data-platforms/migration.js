/* Custom Software & Data Platforms · migration — the strangler-fig board. One number drives everything: the
   programme step (0–10, four weeks each). Module m sits at stage clamp(step − m, 0, 5): legacy → shadow →
   10% → 50% → 100% (legacy read-only) → retired. The range input, Previous / Next and Play set the step; the
   dials, pipes, KPI strip and cutover log follow. Until the first interaction the step follows the scroll
   position, so modules flip across as the board passes through the viewport. Packets run only while the board
   is on screen. Reduced motion: no scroll link, no packets, no play loop; the controls still work, instantly. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tcs-migration'); if (!root) return;
  var win = root.querySelector('.tcs-mg__win'); if (!win) return;
  var data;
  try { data = JSON.parse(win.getAttribute('data-mg') || '{}'); } catch (e) { return; }
  if (!data.mods || !data.stages || !data.log) return;

  var R = BDH.reduced;
  var MAX = data.log.length - 1;
  var rows = BDH.$$('.tcs-mg__row', win);
  var range = win.querySelector('[data-mg-range]');
  var rw = win.querySelector('.tcs-mg__rw');
  var ticks = BDH.$$('.tcs-mg__ticks i', win);
  var wk = win.querySelector('[data-mg-wk]');
  var logEl = win.querySelector('[data-mg-log]');
  var kpis = BDH.$$('[data-mg-k]', win);
  var status = win.querySelector('[data-mg-status]');
  var playBtn = win.querySelector('[data-mg-play]');
  var playL = win.querySelector('[data-mg-play-l]');
  var goBtns = BDH.$$('[data-mg-go]', win);
  var step = parseInt(win.getAttribute('data-step'), 10) || 0;
  var stages = rows.map(function (r, m) { return stageOf(m, step); });
  var linked = !R, prog = null, player = null;

  function stageOf(m, s) { return Math.max(0, Math.min(5, s - m)); }
  function pad(n) { return (n < 10 ? '0' : '') + n; }

  function kpi(s) {
    var live = 0, share = 0, diffs = 0;
    data.mods.forEach(function (x, m) {
      var k = stageOf(m, s);
      if (k >= 4) live++;
      share += data.stages[k].p;
      if (k === 1) diffs += 3;
    });
    return [live + ' of ' + data.mods.length, Math.round(share / data.mods.length) + '%', String(diffs), s >= 4 ? '1' : '0', '0 min'];
  }

  function renderLog(s, forward) {
    if (!logEl) return;
    while (logEl.firstChild) logEl.removeChild(logEl.firstChild);
    for (var i = s; i >= Math.max(0, s - 2); i--) {
      var li = document.createElement('li');
      if (i === s) { li.className = 'is-new'; if (forward && !R) li.classList.add('is-enter'); }
      var t = document.createElement('time'); t.textContent = 'wk ' + pad(i * 4);
      var sp = document.createElement('span'); sp.textContent = data.log[i];
      li.appendChild(t); li.appendChild(sp); logEl.appendChild(li);
    }
  }

  function render(s, announce) {
    s = Math.max(0, Math.min(MAX, s));
    if (s === step && !announce) return;
    var forward = s > step;
    step = s;
    win.setAttribute('data-step', String(s));
    rows.forEach(function (row, m) {
      var k = stageOf(m, s), st = data.stages[k], mod = data.mods[m];
      if (k !== stages[m]) {
        row.className = 'tcs-mg__row is-' + st.k;
        if (!R) { row.classList.add('is-flip'); setTimeout(function () { row.classList.remove('is-flip'); }, 650); }
        stages[m] = k;
      }
      row.style.setProperty('--p', String(st.p / 100));
      var set = function (sel, txt) { var el = row.querySelector(sel); if (el) el.textContent = txt; };
      set('[data-mg-old]', st.old);
      set('[data-mg-new]', st.new);
      set('[data-mg-dial]', st.dial);
      set('[data-mg-rc]', st.rc.replace('%s', mod.n));
      set('[data-mg-sr]', mod.old + ': ' + (st.k === 'shadow' ? 'shadow run, no live traffic moved' : st.p + '% of live traffic on ' + mod.new) + '. Legacy ' + st.old + '.');
    });
    kpi(s).forEach(function (v, i) { if (kpis[i]) kpis[i].textContent = v; });
    if (wk) wk.textContent = 'Week ' + s * 4 + ' of ' + MAX * 4;
    if (range) { range.value = String(s); range.setAttribute('aria-valuetext', 'Week ' + s * 4 + ' of ' + MAX * 4); }
    if (rw) rw.style.setProperty('--v', String(s / MAX));
    ticks.forEach(function (t, i) { t.classList.toggle('is-past', i <= s); });
    edges(s);
    renderLog(s, forward);
    if (announce && status) status.textContent = 'Week ' + s * 4 + '. ' + data.log[s] + '.';
  }

  /* ends of the programme: aria-disabled, so a focused button keeps focus */
  function edges(s) {
    goBtns.forEach(function (b) {
      var d = parseInt(b.getAttribute('data-mg-go'), 10);
      b.setAttribute('aria-disabled', String(d < 0 ? s === 0 : s === MAX));
    });
  }

  /* ---- controls ---- */
  function unlink() {
    linked = false;
    if (prog) { prog.off(); prog = null; }
  }
  function stopPlay() {
    if (player) { player.stop(); player = null; }
    if (playBtn) playBtn.setAttribute('aria-pressed', 'false');
    if (playL) playL.textContent = step === MAX ? 'Replay programme' : 'Play programme';
  }
  function startPlay() {
    if (R) { render(MAX, true); stopPlay(); return; }
    if (step === MAX) render(0, true);
    playBtn.setAttribute('aria-pressed', 'true');
    if (playL) playL.textContent = 'Pause';
    player = BDH.loop(win, 1300, function () {
      if (step >= MAX) { stopPlay(); return; }
      render(step + 1, true);
      if (step >= MAX) stopPlay();
    });
  }

  if (range) {
    range.addEventListener('input', function () { unlink(); stopPlay(); render(parseInt(range.value, 10) || 0, true); });
  }
  goBtns.forEach(function (b) {
    b.addEventListener('click', function () {
      if (b.getAttribute('aria-disabled') === 'true') return;
      unlink(); stopPlay();
      render(step + (parseInt(b.getAttribute('data-mg-go'), 10) || 0), true);
    });
  });
  if (playBtn) {
    playBtn.addEventListener('click', function () {
      unlink();
      if (player) stopPlay(); else startPlay();
    });
  }
  BDH.onInteract(win, unlink);

  render(step, false);
  edges(step);
  if (R) return;

  /* packets only while on screen */
  BDH.live(win, 0.2);

  /* scroll link until the first interaction: the board walks from week 0 to week 40 as it crosses the viewport */
  prog = BDH.progress(win, function (p) {
    if (!linked) return;
    var t = (p - 0.18) / (0.62 - 0.18);
    render(Math.round(Math.max(0, Math.min(1, t)) * MAX), false);
  });
})();
