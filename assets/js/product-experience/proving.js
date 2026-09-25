/* Hub · proving — the Proving Ground. A listbox of bets (roving tabindex: Up/Down move and select,
   Home/End jump, Enter and Space confirm the focused option, clicking selects it) switches the proof
   plan pane. Selecting a bet "runs" the proof: the four rungs light in order, the state pill reports it,
   and the screen-reader summary is updated. Reduced motion: switching is instant and nothing runs.
   With JavaScript off the first plan is the one on show, which is the pattern every tab set here uses. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.pxh-prov');
  if (!root) return;

  var opts = BDH.$$('.pxh-prov__opt', root);
  var panes = BDH.$$('.pxh-prov__pane', root);
  var live = BDH.$('.pxh-prov__live', root);
  var stxt = BDH.$('.pxh-prov__stxt', root);
  if (!opts.length || opts.length !== panes.length) return;

  var cur = 0, runTimers = [], readyT = null;

  function clearRun() {
    runTimers.forEach(clearTimeout);
    runTimers = [];
    BDH.$$('.pxh-prov__rung.is-run', root).forEach(function (r) { r.classList.remove('is-run'); });
  }

  /* the rungs light in order, so the plan reads as a climb rather than a table */
  function run() {
    clearRun();
    if (BDH.reduced || !root.classList.contains('is-live')) return;
    var rungs = BDH.$$('.pxh-prov__rung', panes[cur]);
    if (!rungs.length) return;
    root.classList.add('is-busy');
    if (stxt) stxt.textContent = 'Running the proof';
    rungs.forEach(function (rung, n) {
      runTimers.push(setTimeout(function () {
        rungs.forEach(function (r) { r.classList.remove('is-run'); });
        rung.classList.add('is-run');
      }, 260 + n * 620));
    });
    clearTimeout(readyT);
    readyT = setTimeout(function () {
      clearRun();
      root.classList.remove('is-busy');
      if (stxt) stxt.textContent = 'Proof plan ready';
    }, 260 + rungs.length * 620 + 700);
  }

  function paint(i) {
    opts.forEach(function (o, n) {
      o.setAttribute('aria-selected', n === i ? 'true' : 'false');
      o.tabIndex = n === i ? 0 : -1;
    });
    panes.forEach(function (p, n) { p.classList.toggle('is-on', n === i); });
  }

  function select(i, focus) {
    i = (i % opts.length + opts.length) % opts.length;
    if (focus) opts[i].focus();
    if (i === cur) { paint(i); return; }
    cur = i;
    root.setAttribute('data-bet', String(i));
    paint(i);
    if (live) live.textContent = 'Proof plan: ' + panes[i].getAttribute('data-summary');
    run();
  }

  opts.forEach(function (o, n) {
    o.addEventListener('click', function () { select(n); });
    o.addEventListener('keydown', function (e) {
      var k = e.key, j = -1;
      if (k === 'ArrowDown' || k === 'ArrowRight') j = n + 1;
      else if (k === 'ArrowUp' || k === 'ArrowLeft') j = n - 1;
      else if (k === 'Home') j = 0;
      else if (k === 'End') j = opts.length - 1;
      else if (k === ' ' || k === 'Enter') { e.preventDefault(); select(n); return; }
      if (j === -1) return;
      e.preventDefault();
      select(j, true);
    });
  });
  paint(0);

  /* run once when the panel first comes into view; nothing loops on its own */
  BDH.inView(root, function () { setTimeout(run, 700); }, { threshold: 0.2 });
})();
