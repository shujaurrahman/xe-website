/* Websites & Apps · simulator — SIGNATURE. Real controls: device and network are aria-pressed button groups, the six
   optimisations are aria-pressed switches. Every change recomputes the pre-authored model below (identical to the PHP
   in partials/tech/websites-apps/simulator.php), repaints the filmstrip frame by frame, turns the gauge needles,
   updates weight and carbon, logs what changed and announces the result politely. Autoplay: from the baseline, the
   optimisations switch on one by one; it stops for good on the first interaction inside the app.
   Reduced motion: no autoplay and no tweening; the controls still work. */
(function () {
  'use strict';
  var root = document.querySelector('.twa-sim'); if (!root) return;
  var CFG; try { CFG = JSON.parse(root.getAttribute('data-sim')); } catch (e) { return; }
  var R = !window.BDH || BDH.reduced;
  var app = root.querySelector('.twa-sim__app');
  var $ = function (s) { return root.querySelector(s); };
  var $$ = function (s) { return Array.prototype.slice.call(root.querySelectorAll(s)); };

  /* MODEL — keep identical to $twa_sim_model in the partial */
  function model(dev, net, o) {
    var C = [4, 2, 1][dev], M = [1.9, 0.55, 0.12][net], Rt = [150, 60, 10][net], mob = dev < 2;
    var kb = { img: o[0] ? (mob ? 430 : 780) : 2200, js: o[3] ? 250 : 1100, tp: o[5] ? 0 : 300, font: o[1] ? 70 : 320, css: 120, html: 60 };
    var hero = o[0] ? (mob ? 64 : 140) : 380;
    var ttfb = 3 * Rt + (o[4] ? 50 : 560) + (o[2] ? 90 : 0);
    var style = 180 * C;
    var block = kb.html * M + 0.8 * kb.css * M + (o[1] ? 0 : 0.5 * kb.font * M);
    var shell, fcp, lcp;
    if (o[2]) {
      shell = fcp = ttfb + block + style * 0.5;
      lcp = ttfb + block + hero * M + style + 0.35 * kb.js * C;
    } else {
      shell = ttfb + block + style * 0.5;
      fcp = shell + 0.6 * kb.js * M + 0.31 * kb.js * C;
      lcp = fcp + hero * M + style * 0.5;
    }
    if (!o[5]) lcp += 35 * C;
    lcp = Math.max(lcp, fcp + 60);
    var inp = C * (30 + (o[3] ? 15 : 55) + (o[5] ? 0 : 20) - (o[2] ? 5 : 0));
    var cls = ((o[0] ? 0.01 : 0.14) + (o[1] ? 0.01 : 0.06) + (o[5] ? 0 : 0.05) + (o[2] ? 0.01 : 0.02)) * (mob ? 1 : 0.7);
    var w = kb.img + kb.js + kb.tp + kb.font + kb.css + kb.html;
    /* fcp and lcpRaw are rounded to the same 100 ms the readouts print, so the filmstrip marker and the figure
       beneath it can never disagree by a rounding step. */
    return { ttfb: Math.round(ttfb), shell: Math.round(shell), fcp: Math.round(fcp / 100) * 100, lcpRaw: Math.round(lcp / 100) * 100,
      lcp: Math.round(lcp / 100) / 10, inp: Math.round(inp / 10) * 10, cls: Math.round(cls * 100) / 100, kb: kb, w: w, co2: Math.round(w / 1e6 * 218.35 * 100) / 100 };
  }
  function frames(m, o) {
    var out = [], prev = -1, fm = false, lm = false;
    for (var k = 1; k <= 10; k++) {
      var t = 600 * k;
      var s = t < m.shell ? 0 : t < m.fcp ? 1 : t < m.lcpRaw ? 2 : (!o[5] && t >= m.lcpRaw + 500) ? 4 : 3;
      var mk = [];
      if (!fm && t >= m.fcp) { mk.push('FCP'); fm = true; }
      if (!lm && t >= m.lcpRaw) { mk.push('LCP'); lm = true; }
      out.push({ s: s, mk: mk.join(' · '), shift: (s >= 3 && prev < 3 && !o[0]) || (s === 4 && prev < 4) });
      prev = s;
    }
    return out;
  }
  if (typeof module === 'object' && module.exports) { module.exports = { model: model, frames: frames }; return; }

  var TH = { lcp: [2.5, 4, 8], inp: [200, 500, 1000], cls: [0.1, 0.25, 0.5] };
  function rate(k, v) { var t = TH[k]; return v <= t[0] ? ['good', 'Good'] : v <= t[1] ? ['ni', 'Needs improvement'] : ['poor', 'Poor']; }
  function frac(k, v) {
    var b = TH[k];
    if (v <= b[0]) return 0.4 * v / b[0];
    if (v <= b[1]) return 0.4 + 0.25 * (v - b[0]) / (b[1] - b[0]);
    return Math.min(1, 0.65 + 0.35 * (v - b[1]) / (b[2] - b[1]));
  }
  /* field distribution — keep identical to $twa_sim_dist in the partial */
  function phi(z) {
    var x = Math.abs(z) / Math.SQRT2, t = 1 / (1 + 0.3275911 * x);
    var erf = 1 - (((((1.061405429 * t - 1.453152027) * t) + 1.421413741) * t - 0.284496736) * t + 0.254829592) * t * Math.exp(-x * x);
    return z >= 0 ? 0.5 * (1 + erf) : 0.5 * (1 - erf);
  }
  function dist(k, v) {
    var sg = { lcp: 0.45, inp: 0.6, cls: 0.8 }[k], t = TH[k];
    var md = Math.log(Math.max(v, 0.001)) - 0.6745 * sg;
    var g = Math.round(100 * phi((Math.log(t[0]) - md) / sg)), p = Math.round(100 * (1 - phi((Math.log(t[1]) - md) / sg)));
    return [g, Math.max(0, 100 - g - p), p];
  }
  function fS(ms) { return (ms / 1000).toFixed(1) + ' s'; }
  function fMB(kb) { return (kb / 1000).toFixed(2) + ' MB'; }
  function fKB(kb) { return kb.toLocaleString('en-GB') + ' KB'; }
  var FMT = { lcp: function (v) { return v.toFixed(1) + ' s'; }, inp: function (v) { return Math.round(v) + ' ms'; }, cls: function (v) { return v.toFixed(2); } };

  var st = { dev: CFG.state.dev, net: CFG.state.net, o: CFG.state.o.slice() };
  var devB = $$('[data-dev]').filter(function (b) { return b.tagName === 'BUTTON'; });
  var netB = $$('[data-net]'), sws = $$('[data-opt]');
  var film = $('.twa-sim__film'), frs = $$('.twa-sim__fr');
  var gauges = $$('.twa-g').map(function (g) {
    return { k: g.getAttribute('data-g'), needle: g.querySelector('.twa-g__needle'), v: g.querySelector('[data-g-v]'), r: g.querySelector('[data-g-r]') };
  });
  var segs = $$('.twa-sim__wbar i'), kbEls = $$('[data-sim-kb]');
  var wEl = $('[data-sim-w]'), ttfbEl = $('[data-sim-ttfb]'), fcpEl = $('[data-sim-fcp]'), co2El = $('[data-sim-co2]');
  var countEl = $('[data-sim-count]'), stateEl = $('[data-sim-state]'), logEl = $('[data-sim-log]'), liveEl = $('[data-sim-live]');
  var dists = $$('.twa-sim__dist li').map(function (li) {
    return { k: li.getAttribute('data-d'), bars: li.querySelectorAll('.twa-sim__db i'), vals: li.querySelectorAll('[data-dv]') };
  });
  var verdict = $('[data-sim-verdict]'), vr = $('[data-sim-vr]');
  var ORDER = ['img', 'js', 'tp', 'font', 'css', 'html'];
  var cur = model(st.dev, st.net, st.o), tweens = {}, liveT = 0;

  function tween(key, el, from, to, fmt) {
    if (tweens[key]) cancelAnimationFrame(tweens[key]);
    if (R || from === to) { el.textContent = fmt(to); return; }
    var t0 = null;
    tweens[key] = requestAnimationFrame(function step(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / 700), e = 1 - Math.pow(1 - p, 3);
      el.textContent = fmt(from + (to - from) * e);
      if (p < 1) tweens[key] = requestAnimationFrame(step);
    });
  }

  function paintControls() {
    devB.forEach(function (b) { b.setAttribute('aria-pressed', String(+b.getAttribute('data-dev') === st.dev)); });
    netB.forEach(function (b) { b.setAttribute('aria-pressed', String(+b.getAttribute('data-net') === st.net)); });
    sws.forEach(function (b) { b.setAttribute('aria-pressed', String(!!st.o[+b.getAttribute('data-opt')])); });
    var n = st.o.reduce(function (a, b) { return a + b; }, 0);
    countEl.textContent = n + ' of 6 on';
  }

  function render(prev) {
    var m = model(st.dev, st.net, st.o), fr = frames(m, st.o);
    paintControls();
    film.setAttribute('data-dev', String(st.dev));
    film.setAttribute('data-res', st.o[0] ? '1' : '0');
    film.setAttribute('data-tp', st.o[5] ? '0' : '1');
    frs.forEach(function (li, i) {
      var f = fr[i], box = li.querySelector('.twa-fr'), mk = li.querySelector('.twa-sim__fm');
      var changed = box.getAttribute('data-s') !== String(f.s) || li.classList.contains('is-shift') !== f.shift || mk.textContent !== f.mk || !!prev;
      box.setAttribute('data-s', String(f.s));
      li.classList.toggle('is-shift', f.shift);
      mk.textContent = f.mk;
      if (changed && !R) {
        box.classList.add('is-swap');
        setTimeout(function () { box.classList.remove('is-swap'); }, 40 + i * 55);
      }
    });
    gauges.forEach(function (g) {
      var v = m[g.k], r = rate(g.k, v);
      g.needle.style.transform = 'rotate(' + (180 * frac(g.k, v)).toFixed(2) + 'deg)';
      tween(g.k, g.v, prev ? prev[g.k] : v, v, FMT[g.k]);
      g.r.className = 'twa-rt twa-rt--' + r[0];
      g.r.textContent = r[1];
    });
    var left = 0;
    ORDER.forEach(function (k, i) {
      var w = m.kb[k] / 4100;
      segs[i].style.transform = 'translateX(' + (left * 100).toFixed(2) + '%) scaleX(' + w.toFixed(4) + ')';
      left += w;
    });
    kbEls.forEach(function (el) { el.textContent = fKB(m.kb[el.getAttribute('data-sim-kb')]); });
    dists.forEach(function (d) {
      var p = dist(d.k, m[d.k]);
      d.bars[0].style.transform = 'scaleX(' + (p[0] / 100) + ')';
      d.bars[1].style.transform = 'translateX(' + p[0] + '%) scaleX(' + (p[1] / 100) + ')';
      d.bars[2].style.transform = 'translateX(' + (p[0] + p[1]) + '%) scaleX(' + (p[2] / 100) + ')';
      d.vals[0].textContent = p[0] + '%'; d.vals[1].textContent = p[1] + '%'; d.vals[2].textContent = p[2] + '%';
    });
    var pass = m.lcp <= 2.5 && m.inp <= 200 && m.cls <= 0.1;
    if (verdict) { verdict.classList.toggle('is-pass', pass); vr.className = 'twa-rt twa-rt--' + (pass ? 'good' : 'poor'); vr.textContent = pass ? 'Passed' : 'Failed'; }
    tween('w', wEl, prev ? prev.w : m.w, m.w, function (v) { return fMB(v); });
    tween('ttfb', ttfbEl, prev ? prev.ttfb : m.ttfb, m.ttfb, function (v) { return Math.round(v) + ' ms'; });
    tween('fcp', fcpEl, prev ? prev.fcp : m.fcp, m.fcp, function (v) { return fS(v); });
    tween('co2', co2El, prev ? prev.co2 : m.co2, m.co2, function (v) { return v.toFixed(2) + ' g'; });
    clearTimeout(liveT);
    liveT = setTimeout(function () {
      liveEl.textContent = CFG.dev[st.dev] + ' on ' + CFG.net[st.net] + ' with ' + countEl.textContent + ': LCP ' + m.lcp.toFixed(1) + ' seconds, ' + rate('lcp', m.lcp)[1]
        + '; INP ' + m.inp + ' milliseconds, ' + rate('inp', m.inp)[1] + '; CLS ' + m.cls.toFixed(2) + ', ' + rate('cls', m.cls)[1] + '; page weight ' + fMB(m.w) + '. Core Web Vitals assessment ' + (m.lcp <= 2.5 && m.inp <= 200 && m.cls <= 0.1 ? 'passed' : 'failed') + '.';
    }, 600);
    cur = m;
    return m;
  }

  function diff(a, b) {
    var d = [];
    if (a.lcp !== b.lcp) d.push('LCP ' + a.lcp.toFixed(1) + ' → ' + b.lcp.toFixed(1) + ' s');
    if (a.inp !== b.inp) d.push('INP ' + a.inp + ' → ' + b.inp + ' ms');
    if (a.cls !== b.cls) d.push('CLS ' + a.cls.toFixed(2) + ' → ' + b.cls.toFixed(2));
    if (a.w !== b.w) d.push((a.w / 1000).toFixed(2) + ' → ' + (b.w / 1000).toFixed(2) + ' MB');
    return d.length ? d.join(' · ') : 'No change at this setting';
  }
  function log(sign, title, detail) {
    var li = document.createElement('li');
    var b = document.createElement('b'), s = document.createElement('span'), em = document.createElement('em');
    b.setAttribute('aria-hidden', 'true'); b.textContent = sign; s.textContent = title; em.textContent = detail;
    li.appendChild(b); li.appendChild(s); li.appendChild(em);
    if (!R) li.className = 'is-new';
    logEl.insertBefore(li, logEl.firstChild);
    while (logEl.children.length > 8) logEl.removeChild(logEl.lastChild);
  }

  function setOpt(i, on) {
    if (!!st.o[i] === on) return;
    var prev = cur; st.o[i] = on ? 1 : 0;
    var m = render(prev);
    log(on ? '+' : '−', CFG.opt[i] + (on ? ' on' : ' off'), diff(prev, m));
  }
  function setDev(i) { if (st.dev === i) return; var prev = cur; st.dev = i; var m = render(prev); log('·', 'Device · ' + CFG.dev[i], diff(prev, m)); }
  function setNet(i) { if (st.net === i) return; var prev = cur; st.net = i; var m = render(prev); log('·', 'Network · ' + CFG.net[i], diff(prev, m)); }
  function baseline(msg) {
    var prev = cur; st.o = [0, 0, 0, 0, 0, 0];
    var m = render(prev);
    log('·', msg + ' · ' + CFG.dev[st.dev] + ' · ' + CFG.net[st.net], 'LCP ' + m.lcp.toFixed(1) + ' s · INP ' + m.inp + ' ms · CLS ' + m.cls.toFixed(2) + ' · ' + fMB(m.w));
  }

  devB.forEach(function (b) { b.addEventListener('click', function () { setDev(+b.getAttribute('data-dev')); }); });
  netB.forEach(function (b) { b.addEventListener('click', function () { setNet(+b.getAttribute('data-net')); }); });
  sws.forEach(function (b) { b.addEventListener('click', function () { var i = +b.getAttribute('data-opt'); setOpt(i, !st.o[i]); }); });
  $('[data-sim-all]').addEventListener('click', function () {
    var prev = cur; st.o = [1, 1, 1, 1, 1, 1];
    var m = render(prev); log('+', 'All optimisations on', diff(prev, m));
  });
  $('[data-sim-none]').addEventListener('click', function () { baseline('Reset to baseline'); });

  render(null);
  if (R || !window.BDH) return;

  var steps = [[1500, function () {
    st.dev = 0; st.net = 0;
    while (logEl.firstChild) logEl.removeChild(logEl.firstChild);
    stateEl.textContent = 'Autoplay · baseline';
    baseline('Baseline');
  }]];
  CFG.opt.forEach(function (name, i) {
    steps.push([2600, function () { stateEl.textContent = 'Autoplay · ' + (i + 1) + ' of 6'; setOpt(i, true); }]);
  });
  steps.push([5200, function () { stateEl.textContent = 'Autoplay · restarting'; }]);

  BDH.inView(app, function () {
    BDH.seq(app, steps, {
      loop: true, stopOnInteract: true, interactRoot: app,
      onStop: function () { stateEl.textContent = 'Your settings'; }
    });
  }, { threshold: 0.3 });
})();
