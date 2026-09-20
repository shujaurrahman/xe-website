/* Cybersecurity & AI Trust · privacy — the erasure console. The markup already shows every system
   confirmed, which is the state that matters. This replays the propagation: the request clears the
   list, then each system confirms in turn while the header state, the button and the counter follow:
   Closed → Verifying identity → Propagating → Closed. The backup row confirms but is not counted as an
   erasure, because it is queued against the next rotation and the readout has to agree with the row.
   Runs once on entry and again whenever someone presses the button. Nothing replays under reduced motion. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-pv]'); if (!root) return;

  var rows  = BDH.$$('.tsc-pv__row', root);
  /* the queued backup row confirms like the rest, but it is not an erasure, so it is counted apart */
  var erase = rows.filter(function (r) { return !r.classList.contains('is-queued'); });
  var btn   = root.querySelector('[data-pv-run]');
  var done  = root.querySelector('[data-pv-done]');
  var state = root.querySelector('[data-pv-state]');
  var live  = root.querySelector('[data-pv-live]');
  var flow  = document.querySelector('.tsc-pv__flow');
  var run   = null;

  if (flow) BDH.enter(flow);

  function finish() {
    rows.forEach(function (r) { r.classList.add('is-done'); r.classList.remove('is-now'); });
    if (done) done.textContent = String(erase.length);
    if (state) state.textContent = 'Closed · receipt issued';
  }

  /* under reduced motion the finished state is already on the page, so there is nothing to replay */
  if (BDH.reduced && btn) { btn.hidden = true; return; }
  if (!btn || !rows.length) return;

  function play() {
    if (run) run.stop();
    rows.forEach(function (r) { r.classList.remove('is-done', 'is-now'); });
    if (done) done.textContent = '0';
    if (state) state.textContent = 'Verifying identity';
    btn.disabled = true;
    btn.textContent = 'Running\u2026';

    var n = 0;
    var steps = [[700, function () { if (state) state.textContent = 'Propagating'; }]];
    rows.forEach(function (r, i) {
      steps.push([i === 0 ? 420 : 340, function () {
        rows.forEach(function (o) { o.classList.remove('is-now'); });
        r.classList.add('is-done', 'is-now');
        if (!r.classList.contains('is-queued')) n++;
        if (done) done.textContent = String(n);
      }]);
    });
    steps.push([520, function () {
      finish();
      btn.disabled = false;
      btn.textContent = btn.getAttribute('data-pv-label') || 'Run the request again';
      if (live) live.textContent = 'Erasure request DSR-2418 completed: ' + erase.length + ' systems erased and ' +
        (rows.length - erase.length) + ' queued against the next backup rotation. A receipt was issued.';
    }]);

    run = BDH.seq(root, steps, { loop: false, stopOnInteract: false });
  }

  btn.addEventListener('click', play);
  BDH.inView(root, play, { threshold: 0.3 });
})();
