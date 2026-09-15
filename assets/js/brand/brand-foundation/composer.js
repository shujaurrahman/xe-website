/* §4 SIGNATURE — positioning composer. Autoplays from a weak draft to a signed statement; the first
   touch hands control to the reader. Under reduced motion the checks still work, without animation. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var desk = document.querySelector('[data-cbf-cmp]'); if (!desk) return;
  var D; try { D = JSON.parse(desk.getAttribute('data-cbf-cmp')); } catch (e) { return; }
  var keys = Object.keys(D.slots), ck = Object.keys(D.checks), IDX = { d: 1, c: 2, o: 3 };
  var state = Object.assign({}, D.best), active = keys[0], signed = true, timers = [];
  var $ = function (s) { return desk.querySelector(s); };
  var slots = {}; BDH.$$('.cbf-cmp__slot', desk).forEach(function (b) { slots[b.getAttribute('data-slot')] = b; });
  var overlap = $('[data-cmp-overlap]'), opts = $('[data-cmp-opts]'), legend = $('[data-cmp-legend]'), run = $('[data-cmp-run]');
  var mini = $('[data-cmp-mini]'), sign = $('.cbf-cmp__sign'), goBtn = $('[data-cmp-sign]'), stamp = $('[data-cmp-stamp]'), auto = $('[data-cmp-auto]');

  function score() {
    var out = {};
    ck.forEach(function (c) {
      var sum = 0, weak = null, low = 99;
      keys.forEach(function (k) { var o = D.slots[k][1][state[k]]; sum += o[IDX[c]]; if (o[IDX[c]] < low && o[4]) { low = o[IDX[c]]; weak = k; } });
      var pass = sum >= D.pass;
      out[c] = { pass: pass, why: pass ? D.checks[c][2] : (weak ? D.slots[weak][0] + ': ' + D.slots[weak][1][state[weak]][4] : 'Strengthen the frame or the reason.') };
    });
    return out;
  }
  function later(ms, fn) { if (BDH.reduced) { fn(); return; } timers.push(setTimeout(fn, ms)); }
  function clear() { timers.forEach(clearTimeout); timers = []; }

  function paintSlots(changed) {
    keys.forEach(function (k) {
      var b = slots[k], o = D.slots[k][1][state[k]];
      b.querySelector('.cbf-cmp__val').textContent = o[0];
      b.classList.toggle('is-weak', !!o[4] && o[1] + o[2] + o[3] < 0);
      if (k === changed && !BDH.reduced) { b.classList.remove('is-swap'); b.offsetWidth; b.classList.add('is-swap'); }
    });
    var weak = keys.filter(function (k) { var o = D.slots[k][1][state[k]]; return o[4] && o[1] + o[2] + o[3] < 0; });
    overlap.innerHTML = '';
    if (!weak.length) { var n = document.createElement('span'); n.className = 'cbf-cmp__none'; n.textContent = 'None of these parts repeats the category statements scanned.'; overlap.appendChild(n); }
    weak.forEach(function (k) { var s = document.createElement('s'); s.textContent = D.slots[k][1][state[k]][0]; overlap.appendChild(s); });
  }
  function paintSign() {
    var res = score(), warns = ck.filter(function (c) { return !res[c].pass; }).length;
    sign.classList.toggle('is-signed', signed);
    goBtn.setAttribute('aria-pressed', String(signed));
    goBtn.setAttribute('aria-disabled', String(!signed && warns > 0));
    goBtn.textContent = signed ? 'Signed off' : (warns ? 'Resolve ' + warns + (warns > 1 ? ' warnings' : ' warning') + ' to sign' : 'Sign off');
    stamp.textContent = signed ? 'Signed · Executive team · v1.0' : 'Awaiting sign-off';
  }
  function check() {
    clear();
    var res = score();
    run.textContent = 'Checking…'; if (mini) mini.textContent = 'Agent · checking';
    ck.forEach(function (c, i) {
      var li = $('[data-check="' + c + '"]'), why = li.querySelector('[data-why]'), r = li.querySelector('[data-res]');
      if (!BDH.reduced) { li.className = 'cbf-cmp__check is-checking'; r.textContent = 'Checking'; }
      later(420 + i * 220, function () {
        li.className = 'cbf-cmp__check ' + (res[c].pass ? 'is-pass' : 'is-warn');
        r.textContent = res[c].pass ? 'Pass' : 'Warn';
        why.textContent = res[c].why;
        if (!BDH.reduced) { why.classList.remove('is-new'); why.offsetWidth; why.classList.add('is-new'); }
        if (i === ck.length - 1) { run.textContent = ck.filter(function (x) { return res[x].pass; }).length + ' of 3 pass'; if (mini) mini.textContent = 'Agent · ' + run.textContent; paintSign(); }
      });
    });
    paintSign();
  }
  function showSlot(k) {
    active = k;
    keys.forEach(function (x) { slots[x].setAttribute('aria-pressed', String(x === k)); });
    legend.textContent = D.slots[k][0];
    opts.innerHTML = '';
    D.slots[k][1].forEach(function (o, i) {
      var l = document.createElement('label'); l.className = 'cbf-cmp__opt';
      var inp = document.createElement('input'); inp.type = 'radio'; inp.name = 'composer-opt'; inp.value = i; inp.checked = i === state[k];
      var s = document.createElement('span'); s.textContent = o[0];
      inp.addEventListener('change', function () { choose(k, i); });
      l.appendChild(inp); l.appendChild(s); opts.appendChild(l);
    });
  }
  function choose(k, i) {
    state[k] = i; signed = false;
    var inp = opts.querySelector('input[value="' + i + '"]'); if (inp && active === k) inp.checked = true;
    paintSlots(k); check();
  }
  function setAll(v) { keys.forEach(function (k) { state[k] = typeof v === 'object' ? v[k] : v; }); signed = false; paintSlots(); showSlot(keys[0]); check(); }

  keys.forEach(function (k) { slots[k].addEventListener('click', function () { showSlot(k); var c = opts.querySelector('input:checked'); if (c) c.focus(); }); });
  goBtn.addEventListener('click', function () { if (goBtn.getAttribute('aria-disabled') === 'true' || signed) return; signed = true; paintSign(); });
  $('[data-cmp-redraft]').addEventListener('click', function () { signed = false; paintSign(); slots[active].focus(); });
  showSlot(keys[0]); paintSign();

  if (BDH.reduced) { auto.textContent = 'Your draft'; return; }
  setAll(D.weak);
  var steps = [];
  keys.forEach(function (k) {
    steps.push([1500, function () { showSlot(k); }]);
    steps.push([950, function () { choose(k, D.best[k]); }]);
  });
  steps.push([1900, function () { signed = true; paintSign(); }]);
  steps.push([5200, function () { setAll(D.weak); }]);
  BDH.seq(desk, steps, { loop: true, onStop: function () { auto.textContent = 'Your draft'; } });
})();
