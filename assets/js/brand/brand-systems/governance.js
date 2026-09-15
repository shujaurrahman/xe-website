/* Brand Systems · 07 governance — filter release notes, choose what to watch, RC steps tick through review. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var log = document.querySelector('[data-cbs-gv]'); if (!log) return;
  var items = BDH.$$('[data-cbs-gv-item]', log);
  var chips = BDH.$$('[data-cbs-gv-filter]', log);
  var status = log.querySelector('[data-cbs-gv-status]');
  var empty = log.querySelector('[data-cbs-gv-empty]');
  var RANK = { patch: 1, minor: 2, major: 3 };
  var LABEL = { major: 'major releases only', minor: 'minor and major releases', patch: 'every release' };
  var filter = 'all';

  function level() { var c = log.querySelector('input[name="cbs-gv-level"]:checked'); return c ? c.value : 'minor'; }

  function apply() {
    var lv = level(), shown = 0, watched = 0;
    items.forEach(function (it) {
      var notes = BDH.$$('.cbs-gv__notes li', it), any = false;
      notes.forEach(function (n) { var ok = filter === 'all' || n.getAttribute('data-type') === filter; n.hidden = !ok; if (ok) any = true; });
      it.hidden = !any;
      var w = RANK[it.getAttribute('data-level')] >= RANK[lv];
      it.classList.toggle('is-watched', w);
      if (any) { shown++; if (w) watched++; }
    });
    empty.hidden = shown > 0;
    status.textContent = 'Watching ' + LABEL[lv] + ' · ' + watched + ' of ' + shown + ' shown would notify you.';
  }

  chips.forEach(function (c) {
    c.addEventListener('click', function () {
      filter = c.getAttribute('data-cbs-gv-filter');
      chips.forEach(function (x) { x.setAttribute('aria-pressed', String(x === c)); });
      apply();
    });
  });
  BDH.$$('input[name="cbs-gv-level"]', log).forEach(function (r) { r.addEventListener('change', apply); });
  apply();

  /* the release candidate moves through review once, on entry */
  var steps = BDH.$$('[data-cbs-gv-steps] li', log);
  var date = log.querySelector('[data-cbs-gv-rc]');
  var ver = log.querySelector('.is-rc .cbs-gv__ver');
  if (!steps.length) return;
  function to(n) {
    steps.forEach(function (s, i) { s.classList.toggle('is-done', i < n); s.classList.toggle('is-now', i === n); });
  }
  if (BDH.reduced) return;   // HTML shows the in-review state, which reads completely
  BDH.live(log, 0.2);
  BDH.inView(log, function () {
    to(1);
    BDH.seq(log, [
      [900, function () { to(2); }],
      [1600, function () { to(3); if (date) date.textContent = 'Approved by maintainer · waiting for system owner'; }],
      [1800, function () { to(4); if (date) date.textContent = 'Approved by system owner'; }],
      [1400, function () { to(5); if (date) date.textContent = 'Released · Illustrative'; if (ver) ver.textContent = 'v2.5.0'; }]
    ], { loop: false, stopOnInteract: false });
  }, { threshold: 0.3 });
})();
