/* Brand Identity · hero — the mark assembles on its construction grid, then colourways and type
   pairings cycle. The markup is the final state. Any swatch / pairing press takes over for good;
   the Pause/Play button stops or restarts the run. Reduced motion: static, buttons still work. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.cbi-hero'); if (!root) return;
  var sheet = root.querySelector('.cbi-sheet'); if (!sheet) return;
  var sws = BDH.$$('.cbi-hero__sw', root);
  var tpb = root.querySelector('[data-tp-next]');
  var play = root.querySelector('.cbi-hero__play');
  var step = sheet.querySelector('.cbi-sheet__step');
  var CW = sws.length || 4, TP = 3;
  var run = null;

  function label(t) { if (step) step.textContent = t; }
  function cw(i) {
    sheet.setAttribute('data-cw', i);
    sws.forEach(function (b, k) { b.setAttribute('aria-pressed', String(k === i)); });
    label('Colourway 0' + (i + 1));
  }
  function tp(i) { sheet.setAttribute('data-tp', i); label('Pairing 0' + (i + 1)); }
  function cls(g, p, s) {
    sheet.classList.toggle('is-grid', g); sheet.classList.toggle('is-parts', p); sheet.classList.toggle('is-set', s);
  }
  function assembled() { cls(true, true, true); }

  function stop() {
    if (run) { run.stop(); run = null; }
    assembled();
    if (play) play.textContent = 'Play';
  }

  sws.forEach(function (b, k) { b.addEventListener('click', function () { stop(); cw(k); }); });
  if (tpb) tpb.addEventListener('click', function () {
    stop(); tp((parseInt(sheet.getAttribute('data-tp'), 10) + 1) % TP);
  });

  if (BDH.reduced) return;

  var steps = [
    [450,  function () { cls(true, false, false); label('Construction grid'); }],
    [1000, function () { cls(true, true, false); label('Geometry'); }],
    [1300, function () { assembled(); label('Assembled'); }],
    [2400, function () { cw(1); }],
    [2300, function () { tp(1); }],
    [2300, function () { cw(2); }],
    [2300, function () { tp(2); }],
    [2300, function () { cw(3); }],
    [2300, function () { tp(0); cw(0); }],
    [2800, function () { cls(true, false, false); label('Disassemble'); }],
    [900,  function () { cls(false, false, false); label('Blank sheet'); }],
  ];

  function start() {
    if (run) run.stop();
    cw(0); tp(0); cls(false, false, false); label('Blank sheet');
    run = BDH.seq(sheet, steps, { loop: true, stopOnInteract: false });
    if (play) play.textContent = 'Pause';
  }

  if (play) {
    play.hidden = false;
    play.addEventListener('click', function () { if (run) stop(); else start(); });
  }
  start();
})();
