/* AI Infrastructure & Cloud · carbon — the carbon-aware scheduler. The embedding refresh moves by slider,
   by dragging its block, by the region buttons or by "Find the lowest-carbon window"; the SCI readout
   (SCI = ((E × I) + M) per R) recomputes and counts to its new value. On entry the panel replays the move
   from the 01:00 Mumbai cron to the optimised window once. Reduced motion: values change at once, no replay. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var panel = document.querySelector('.tic-cb__panel');
  if (!panel) return;
  var R = BDH.reduced, D = null;
  try { D = JSON.parse(panel.querySelector('.tic-cb__data').textContent); } catch (e) { return; }
  var $ = function (s) { return panel.querySelector(s); }, $$ = function (s) { return BDH.$$(s, panel); };

  var regBtns = $$('[data-cb-region]'), range = $('[data-cb-range]'), track = $('[data-cb-drag]'), job = track ? track.querySelector('.tic-cb__job') : null;
  var els = { when: $('[data-cb-when]'), start: $('[data-cb-start]'), i: $('[data-cb-i]'), i2: $('[data-cb-i2]'), kg: $('[data-cb-kg]'), sci: $('[data-cb-sci]'), delta: $('[data-cb-delta]'), status: $('[data-cb-status]') };
  var H = D.job.hours, MAX = 24 - H;
  var state = { r: D.opt.r, s: D.opt.s };
  var shown = null, touched = false;

  function hh(h) { h = h % 24; return (h < 10 ? '0' : '') + h + ':00'; }
  function calc(r, s) {
    var arr = D.regions[r].i, sum = 0;
    for (var k = 0; k < H; k++) sum += arr[s + k];
    var i = sum / H, kg = D.job.kwh * i / 1000 + D.job.m;
    return { i: i, kg: kg, sci: kg * 1000 / D.job.docs };
  }
  var base = calc(D.def.r, D.def.s);

  function tween(el, to, fmt) {
    if (!el) return;
    var from = parseFloat(el.getAttribute('data-v'));
    if (isNaN(from)) from = to;
    el.setAttribute('data-v', to);
    if (R || from === to) { el.textContent = fmt(to); return; }
    var t0 = null;
    requestAnimationFrame(function f(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / 700), k = 1 - Math.pow(1 - p, 3);
      el.textContent = fmt(from + (to - from) * k);
      if (p < 1) requestAnimationFrame(f);
    });
  }
  var f0 = function (v) { return String(Math.round(v)); }, f1 = function (v) { return v.toFixed(1); };

  function render(announce) {
    var r = state.r, s = state.s, c = calc(r, s), name = D.regions[r].name;
    panel.setAttribute('data-region', r);
    panel.style.setProperty('--s', String(s));
    panel.classList.toggle('is-default', r === D.def.r && s === D.def.s);
    regBtns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-cb-region') === r ? 'true' : 'false'); });
    if (range) {
      range.value = String(s);
      range.style.setProperty('--p', (s / MAX).toFixed(3));
      range.setAttribute('aria-valuetext', hh(s) + ' to ' + hh(s + H) + ', ' + name);
    }
    if (els.when) els.when.textContent = hh(s) + '–' + hh(s + H);
    if (els.start) els.start.textContent = hh(s);
    tween(els.i, c.i, f0); tween(els.i2, c.i, f0); tween(els.kg, c.kg, f1); tween(els.sci, c.sci, f1);
    if (els.delta) {
      var d = Math.round((1 - c.sci / base.sci) * 100);
      var same = r === D.def.r && s === D.def.s;
      els.delta.textContent = same ? 'the cron as shipped · 01:00 Mumbai' : (d >= 0 ? '−' + d : '+' + Math.abs(d)) + '% vs the 01:00 Mumbai cron';
      els.delta.classList.toggle('is-worse', !same && d < 0);
    }
    if (announce && els.status) {
      els.status.textContent = 'Embedding refresh scheduled in ' + name + ' from ' + hh(s) + ' to ' + hh(s + H) + '. Grid intensity ' + Math.round(c.i) + ' grams per kilowatt-hour; ' + c.kg.toFixed(1) + ' kilograms of CO2e; SCI ' + c.sci.toFixed(1) + ' grams per thousand documents.';
    }
  }

  function set(r, s, announce) {
    state.r = r || state.r;
    state.s = Math.max(0, Math.min(MAX, Math.round(s)));
    render(announce);
  }
  function best() {
    var b = null;
    Object.keys(D.regions).forEach(function (r) {
      for (var s = 0; s <= MAX; s++) { var c = calc(r, s); if (!b || c.sci < b.sci) b = { r: r, s: s, sci: c.sci }; }
    });
    return b;
  }

  /* ---- controls ---- */
  regBtns.forEach(function (b) { b.addEventListener('click', function () { touched = true; set(b.getAttribute('data-cb-region'), state.s, true); }); });
  if (range) range.addEventListener('input', function () { touched = true; set(null, parseInt(range.value, 10) || 0, true); });
  var bestBtn = $('[data-cb-best]'), defBtn = $('[data-cb-default]');
  if (bestBtn) bestBtn.addEventListener('click', function () { touched = true; var b = best(); set(b.r, b.s, true); });
  if (defBtn) defBtn.addEventListener('click', function () { touched = true; set(D.def.r, D.def.s, true); });

  /* ---- drag the block along its lane ---- */
  if (track && job && window.PointerEvent) {
    var drag = null;
    function hourAt(x) {
      var rect = track.getBoundingClientRect();
      return Math.max(0, Math.min(MAX, Math.round((x - rect.left) / rect.width * 24 - drag.off)));
    }
    job.addEventListener('pointerdown', function (e) {
      touched = true;
      var rect = track.getBoundingClientRect(), jr = job.getBoundingClientRect();
      drag = { id: e.pointerId, off: (e.clientX - jr.left) / rect.width * 24 };
      track.classList.add('is-drag');
      try { job.setPointerCapture(e.pointerId); } catch (x) { /* ignore */ }
      e.preventDefault();
    });
    job.addEventListener('pointermove', function (e) {
      if (!drag || e.pointerId !== drag.id) return;
      var h = hourAt(e.clientX);
      if (h !== state.s) set(null, h, false);
    });
    function up(e) {
      if (!drag || e.pointerId !== drag.id) return;
      drag = null; track.classList.remove('is-drag');
      render(true);
    }
    job.addEventListener('pointerup', up); job.addEventListener('pointercancel', up);
  }

  /* ---- entry: the still frame is the optimised state; replay the move once ---- */
  var lines = panel.querySelector('.tic-cb__chart');
  if (lines) BDH.enter(lines);
  render(false);
  if (R) return;
  BDH.live(panel, 0.2);
  BDH.inView(panel, function () {
    if (touched) return;
    var to = { r: state.r, s: state.s };
    set(D.def.r, D.def.s, false);
    setTimeout(function () { if (!touched) set(to.r, to.s, false); }, 1400);
  }, { threshold: 0.4 });
})();
