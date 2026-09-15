/* 05 Guardrails test runner — run the suite, a failure expands to its diff, apply the fix, re-run.
   Autoplays until the first interaction with the runner. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var run = document.querySelector('.cat-gr__run'); if (!run) return;
  var R = BDH.reduced;
  var tests = BDH.$$('.cat-gr__t', run);
  var sum = run.querySelector('[data-gr-sum]'), prog = run.querySelector('[data-gr-prog]');
  var row = run.querySelector('button.cat-gr__row'), diff = run.querySelector('.cat-gr__diff');
  var fixBtn = run.querySelector('[data-gr-fix]'), runBtn = run.querySelector('[data-gr-run]');
  var timers = [], fixed = true;

  function later(ms, fn) { timers.push(setTimeout(fn, R ? 0 : ms)); }
  function state(li, s) { li.classList.remove('is-pend', 'is-run', 'is-pass', 'is-fail'); li.classList.add(s); }
  function expand(on) { if (!row) return; row.setAttribute('aria-expanded', on ? 'true' : 'false'); diff.hidden = !on; }
  function report(done, total) {
    var pass = 0, fail = 0;
    tests.forEach(function (t) { if (t.classList.contains('is-pass')) pass++; if (t.classList.contains('is-fail')) fail++; });
    var fx = fixed && tests.some(function (t) { return t.classList.contains('is-fixed') && t.classList.contains('is-pass'); }) ? 1 : 0;
    sum.innerHTML = '<b>' + pass + '</b> passed' + (fx ? ' (1 after a fix)' : '') + ' · ' + fail + ' failing' + (done < total ? ' · running ' + done + '/' + total : '');
    prog.style.setProperty('--p', total ? done / total : 1);
  }

  function runSuite() {
    timers.forEach(clearTimeout); timers = [];
    fixed = false; expand(false);
    if (fixBtn) fixBtn.disabled = false;
    tests.forEach(function (t) { state(t, 'is-pend'); t.classList.remove('is-fixed'); });
    report(0, tests.length);
    tests.forEach(function (t, i) {
      later(i * 230 + 150, function () { state(t, 'is-run'); });
      later(i * 230 + 360, function () {
        state(t, t.getAttribute('data-gr-fail') === '1' ? 'is-fail' : 'is-pass');
        report(i + 1, tests.length);
        if (t.getAttribute('data-gr-fail') === '1') expand(true);
      });
    });
  }

  function applyFix() {
    var t = run.querySelector('[data-gr-fail="1"]'); if (!t || !t.classList.contains('is-fail')) return;
    if (fixBtn) fixBtn.disabled = true;
    state(t, 'is-run');
    later(700, function () {
      fixed = true; state(t, 'is-pass'); t.classList.add('is-fixed');
      if (!R) { t.classList.remove('is-land'); void t.offsetWidth; t.classList.add('is-land'); }
      report(tests.length, tests.length);
    });
  }

  if (row) row.addEventListener('click', function () { expand(row.getAttribute('aria-expanded') !== 'true'); });
  if (fixBtn) fixBtn.addEventListener('click', applyFix);
  if (runBtn) runBtn.addEventListener('click', runSuite);
  if (fixBtn) fixBtn.disabled = true;
  report(tests.length, tests.length);
  if (R || !window.matchMedia('(min-width: 981px)').matches) return;   // the diff changes height; autoplay only on wide layouts

  BDH.inView(run, function () {
    BDH.seq(run, [
      [700, runSuite],
      [tests.length * 230 + 1600, applyFix],
      [2600, function () { expand(false); }],
      [3600, function () {}]
    ], { loop: true, stopOnInteract: true, interactRoot: run });
  }, { threshold: 0.3 });
})();
