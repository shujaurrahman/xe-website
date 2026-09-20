/* AI Strategy & Agents · evals — on entry the scenario bars grow and the sparklines draw (CSS via
   .is-in), the metrics count up (BDH.count) and the regression timeline plays in about 2.5 s. All
   four runs stay on screen: they dim, then light in turn — the passing run, the trajectory failure
   that blocks the merge (the header gate flips to blocked), the fix, the passing re-run (allowed).
   Replay runs it again. On phones the scenario list shows three rows behind "Show all".
   Reduced motion: the finished dashboard, no play; the disclosure still works. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var ev = document.querySelector('[data-tas-ev]'); if (!ev) return;
  var runs = BDH.$$('.tas-ev__run', ev), gate = ev.querySelector('[data-ev-gate]'), gateT = ev.querySelector('[data-ev-gatet]');
  var replay = ev.querySelector('[data-ev-replay]');
  var timers = [], played = false;

  /* scenario disclosure (the button only shows on phones) */
  var more = ev.querySelector('[data-ev-more]'), scen = ev.querySelector('.tas-ev__scen');
  if (more && scen) {
    var label = more.textContent;
    scen.classList.add('is-js'); more.hidden = false;
    more.addEventListener('click', function () {
      var open = !scen.classList.contains('is-open');
      scen.classList.toggle('is-open', open);
      more.setAttribute('aria-expanded', open ? 'true' : 'false');
      more.textContent = open ? 'Show fewer' : label;
    });
  }

  function later(ms, fn) { timers.push(setTimeout(fn, ms)); }
  function clear() { timers.forEach(clearTimeout); timers = []; }
  function setGate(st) {
    if (!gate) return;
    gate.setAttribute('data-ev-gate', st);
    if (gateT) gateT.textContent = st === 'blocked' ? 'CI gate · merge blocked' : 'CI gate · merge allowed';
  }
  function play() {
    clear();
    ev.classList.add('is-armed');
    runs.forEach(function (r) { r.classList.remove('is-on', 'is-flash'); });
    setGate('ok');
    var t = 150;
    runs.forEach(function (r, i) {
      var st = r.getAttribute('data-st');
      later(t, function () {
        r.classList.add('is-on');
        if (st === 'fail') { r.classList.add('is-flash'); setGate('blocked'); }
        if (st === 'ok' && i > 0) setGate('ok');
      });
      t += st === 'fail' ? 1050 : st === 'fix' ? 650 : 450;
    });
    later(t + 900, function () { runs.forEach(function (r) { r.classList.remove('is-flash'); }); });
  }

  if (BDH.reduced) {
    if (replay) replay.hidden = true;
    ev.classList.add('is-in');
    return;
  }
  if (replay) replay.addEventListener('click', play);
  BDH.inView(ev.querySelector('.tas-ev__reg') || ev, function () {
    ev.classList.add('is-in');
    if (!played) { played = true; later(250, play); }
  }, { threshold: 0.15 });
  BDH.enter(ev, { io: { threshold: 0.05 } });
})();
