/* Brand Identity · motion — cubic-bezier easing solved in JS drives the graph dot, the onion-skin
   frames, the travelling mark and the readout. Autoplay: each curve plays (3× slower), holds, moves on;
   paused off screen; stops for good on the first interaction in the lab. Reduced motion: no autoplay,
   Play jumps to the end. The sonic sketch only sounds on click (Web Audio, quiet). */
(function () {
  'use strict';
  var lab = document.querySelector('.cbi-mo__lab'); if (!lab) return;
  var C; try { C = JSON.parse(lab.getAttribute('data-curves')); } catch (e) { return; }
  var R = !window.BDH || BDH.reduced;
  var q = function (s) { return lab.querySelector(s); }, qa = function (s) { return Array.prototype.slice.call(lab.querySelectorAll(s)); };
  var btns = qa('.cbi-mo__cb'), paths = qa('.cbi-mo__curve'), ghosts = qa('.cbi-mo__ghost'), rulers = qa('.cbi-mo__ruler span');
  var track = q('.cbi-mo__track'), dot = q('.cbi-mo__dot'), gx = q('.cbi-mo__gx'), gy = q('.cbi-mo__gy');
  var scrub = q('.cbi-mo__scrub'), ro = q('.cbi-mo__ro'), bz = q('.cbi-mo__bz'), use = q('.cbi-mo__usev'), play = q('.cbi-mo__play');
  var k = 0, t = 1, raf = 0, auto = !R, on = true, phase = null;

  function bez(s, a, b) { return 3 * a * s * (1 - s) * (1 - s) + 3 * b * s * s * (1 - s) + s * s * s; }
  function ease(x) {
    var c = C[k].b, lo = 0, hi = 1;
    for (var i = 0; i < 24; i++) { var m = (lo + hi) / 2; if (bez(m, c[0], c[2]) < x) lo = m; else hi = m; }
    return bez((lo + hi) / 2, c[1], c[3]);
  }
  function fmt(n) { return String(+n.toFixed(2)); }

  function render() {
    var p = ease(t), x = 20 + 200 * t, y = 200 - 150 * p;
    track.style.setProperty('--p', p.toFixed(4));
    dot.setAttribute('cx', x); dot.setAttribute('cy', y);
    gx.setAttribute('x1', x); gx.setAttribute('x2', x); gx.setAttribute('y2', y);
    gy.setAttribute('x2', x); gy.setAttribute('y1', y); gy.setAttribute('y2', y);
    scrub.value = Math.round(t * 1000);
    ro.textContent = Math.round(t * C[k].ms) + ' ms · ' + Math.round(p * 100) + '%';
  }
  function setCurve(i) {
    k = i; var c = C[k];
    btns.forEach(function (b, j) { b.setAttribute('aria-pressed', String(j === k)); });
    paths.forEach(function (p, j) { p.classList.toggle('is-on', j === k); });
    ghosts.forEach(function (g, j) { g.style.setProperty('--g', ease(j / 8).toFixed(4)); });
    rulers.forEach(function (r, j) { r.textContent = Math.round(c.ms * j / 4) + ' ms'; });
    bz.textContent = 'cubic-bezier(' + c.b.map(fmt).join(', ') + ')';
    use.textContent = c.use;
    render();
  }

  function stopAnim() { cancelAnimationFrame(raf); raf = 0; phase = null; play.textContent = 'Play'; }
  function animate(done) {
    cancelAnimationFrame(raf);
    var dur = C[k].ms * 3, start = null, from = 0;
    play.textContent = 'Stop';
    phase = function (now) {
      if (start === null) start = now - from * dur;
      t = Math.min(1, (now - start) / dur); render();
      if (t < 1) { raf = requestAnimationFrame(phase); return; }
      raf = 0; phase = null; play.textContent = 'Play'; if (done) done();
    };
    t = 0; render(); raf = requestAnimationFrame(phase);
  }

  var holdT = 0;
  function cycle() {
    if (!auto || !on) return;
    animate(function () { holdT = setTimeout(function () { if (!auto || !on) return; setCurve((k + 1) % C.length); cycle(); }, 1400); });
  }
  function takeOver() { if (!auto) return; auto = false; clearTimeout(holdT); stopAnim(); render(); }

  btns.forEach(function (b, i) { b.addEventListener('click', function () { takeOver(); stopAnim(); setCurve(i); t = 1; render(); }); });
  scrub.addEventListener('input', function () { takeOver(); stopAnim(); t = scrub.value / 1000; render(); });
  play.addEventListener('click', function () {
    takeOver();
    if (raf) { stopAnim(); return; }
    if (R) { t = 1; render(); return; }
    animate();
  });
  setCurve(0);

  if (!R) {
    BDH.onInteract(lab, takeOver);
    BDH.watch(lab, function (vis) {
      on = vis;
      if (!auto) return;
      if (vis) { if (!raf) cycle(); } else { clearTimeout(holdT); stopAnim(); }
    }, { threshold: 0.25 });
  }

  /* ---- sonic sketch ---- */
  var wave = document.querySelector('.cbi-mo__wave'), listen = document.querySelector('.cbi-mo__listen');
  if (!wave || !listen) return;
  var bars = Array.prototype.slice.call(wave.querySelectorAll('.cbi-mo__bars i')), head = wave.querySelector('.cbi-mo__head'), actx = null;
  function tone(ctx, f, at) {
    var o = ctx.createOscillator(), g = ctx.createGain();
    o.type = 'sine'; o.frequency.value = f;
    g.gain.setValueAtTime(0.0001, at); g.gain.exponentialRampToValueAtTime(0.07, at + 0.02); g.gain.exponentialRampToValueAtTime(0.0001, at + 0.9);
    o.connect(g); g.connect(ctx.destination); o.start(at); o.stop(at + 1);
  }
  listen.addEventListener('click', function () {
    try {
      var AC = window.AudioContext || window.webkitAudioContext;
      if (AC) { actx = actx || new AC(); var n = actx.currentTime + 0.05; tone(actx, 659.25, n); tone(actx, 987.77, n + 0.26); tone(actx, 1318.51, n + 0.52); }
    } catch (e) { /* visual only */ }
    if (R) { bars.forEach(function (b) { b.classList.add('is-lit'); }); return; }
    bars.forEach(function (b) { b.classList.remove('is-lit'); });
    wave.classList.add('is-playing');
    var w = wave.querySelector('.cbi-mo__bars').clientWidth, s0 = null;
    function step(now) {
      if (s0 === null) s0 = now;
      var x = Math.min(1, (now - s0) / 1200);
      head.style.transform = 'translateX(' + (x * w) + 'px)';
      var lit = Math.floor(x * bars.length);
      for (var i = 0; i < lit; i++) bars[i].classList.add('is-lit');
      if (x < 1) requestAnimationFrame(step); else setTimeout(function () { wave.classList.remove('is-playing'); }, 400);
    }
    requestAnimationFrame(step);
  });
})();
