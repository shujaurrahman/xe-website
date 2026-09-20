/* AI Infrastructure & Cloud · serving — runs the four micro-machines while on screen:
   01 a continuous-batching scheduler (lanes decode at their own pace; a finished lane admits the next queued
      request at once), 02 the prefix-cache replay (CSS loop under .is-live), 03 quantisation (bit layout and memory budget cycle
      FP16 → FP8 → INT4 until the reader picks a precision; the eval gate line follows), 04 speculative decoding
      (draft, verify, accept, append). Reduced motion: the finished states stay; the precision buttons still work. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var grid = document.querySelector('.tic-sv');
  if (!grid) return;
  var R = BDH.reduced;
  BDH.live(grid, 0.2);

  /* ---- 01 continuous batching ---- */
  var cb = grid.querySelector('.tic-sv__cb');
  if (cb && !R) {
    var lanes = BDH.$$('[data-cb-lanes] > li', cb), queue = cb.querySelector('[data-cb-queue]');
    var nEl = cb.querySelector('[data-cb-n]'), tpsEl = cb.querySelector('[data-cb-tps]'), waitEl = cb.querySelector('[data-cb-wait]');
    var next = 1051, state = lanes.map(function (li) {
      return { li: li, tok: parseInt(li.getAttribute('data-tok'), 10) || 600, p: parseFloat(li.getAttribute('data-p')) || 0, rate: 1 };
    });
    /* 75 tokens a second per stream is the decode rate section 02 states; the readouts are the sum of the
       lanes, so the first live tick continues the value PHP shipped instead of jumping away from it. */
    var TICK = 120, TPS = 75;
    function admit(s) {
      var pill = queue.firstElementChild;
      if (!pill) return;
      pill.classList.add('is-go');
      var id = pill.textContent;
      setTimeout(function () { if (pill.parentNode) pill.parentNode.removeChild(pill); var li = document.createElement('li'); li.textContent = 'r-' + (next++); queue.appendChild(li); }, 320);
      s.tok = 300 + Math.round(Math.random() * 600); s.p = 0; s.rate = 0.9 + Math.random() * 0.2;
      s.li.querySelector('.tic-sv__lid').textContent = id;
      s.li.classList.add('is-fresh');
      setTimeout(function () { s.li.classList.remove('is-fresh'); }, 1400);
    }
    BDH.loop(cb, TICK, function () {
      var tps = 0, slowest = 0;
      state.forEach(function (s) {
        s.p = Math.min(1, s.p + (TPS * s.rate * TICK / 1000) / s.tok);
        var bar = s.li.querySelector('.tic-sv__bar i'), n = s.li.querySelector('b');
        if (bar) bar.style.setProperty('--p', s.p.toFixed(3));
        if (n) n.textContent = Math.round(s.p * s.tok) + '/' + s.tok;
        if (s.p >= 1) admit(s);
        tps += TPS * s.rate;
        slowest = Math.max(slowest, (1 - s.p) * s.tok / (TPS * s.rate));
      });
      if (nEl) nEl.textContent = lanes.length + '/' + lanes.length;
      if (tpsEl) tpsEl.textContent = Math.round(tps).toLocaleString('en-US') + ' tok/s';
      if (waitEl) waitEl.textContent = (slowest + 0.4).toFixed(1) + ' s';
    });
  }

  /* ---- 03 quantisation: bit layout, memory budget, figures and gate follow the chosen precision ---- */
  var q = grid.querySelector('.tic-sv__q');
  if (q) {
    var card = q.closest('.tic-sv__card');
    var btns = BDH.$$('[data-q-set]', q), states = BDH.$$('[data-q-state]', q), gates = BDH.$$('[data-q-gate]', card);
    var fmts = BDH.$$('[data-q-fmt]', q), bits = BDH.$$('.tic-sv__qbits i', q), mem = q.querySelector('.tic-sv__qmem');
    var bitsEl = q.querySelector('[data-q-bits]'), st = q.querySelector('[data-q-status]');
    var SPEC = {   // [sign, exponent, mantissa | integer value bits], weights GB on a 24 GB card
      fp16: { f: [1, 5, 10], w: 16 },
      fp8:  { f: [1, 4, 3],  w: 8 },
      int4: { f: [0, 0, 4],  w: 4.5 }
    };
    var SAY = {
      fp16: 'FP16 selected: 16 bits per weight, 16 gigabytes of weights on a 24 gigabyte GPU, room for about 12 concurrent 4,000-token sequences, baseline decode speed, golden-set score 0.94, ships.',
      fp8: 'FP8 selected: 8 bits per weight, 8 gigabytes of weights on a 24 gigabyte GPU, room for about 28 concurrent 4,000-token sequences, 1.6 times decode speed, golden-set score 0.93, inside tolerance, ships.',
      int4: 'INT4 selected: 4 bits per weight plus a scale per group of 128, about 4.5 gigabytes of weights, room for about 35 concurrent 4,000-token sequences, 2.1 times decode speed, golden-set score 0.90, below tolerance, held for review.'
    };
    var order = ['fp16', 'fp8', 'int4'], qi = 1, qTouched = false;
    function paintBits(k) {
      var f = SPEC[k].f, n = 0;
      bits.forEach(function (b, i) {
        var c = 'is-x';
        if (k === 'int4') { if (i < f[2]) c = 'is-v'; }
        else if (i < f[0]) c = 'is-s';
        else if (i < f[0] + f[1]) c = 'is-e';
        else if (i < f[0] + f[1] + f[2]) c = 'is-m';
        if (c !== 'is-x') n++;
        b.className = c;
      });
      if (bitsEl) bitsEl.textContent = k === 'int4' ? '4 + scale' : String(n);
      if (mem) mem.style.setProperty('--w', (SPEC[k].w / 24).toFixed(4));
    }
    function setQ(k) {
      q.setAttribute('data-q', k);
      btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-q-set') === k ? 'true' : 'false'); });
      states.forEach(function (s) { s.hidden = s.getAttribute('data-q-state') !== k; });
      gates.forEach(function (g) { g.hidden = g.getAttribute('data-q-gate') !== k; });
      fmts.forEach(function (f) { f.hidden = f.getAttribute('data-q-fmt') !== k; });
      paintBits(k);
      if (st) st.textContent = SAY[k] || '';
      qi = order.indexOf(k);
    }
    btns.forEach(function (b) { b.addEventListener('click', function () { qTouched = true; setQ(b.getAttribute('data-q-set')); }); });
    if (!R) {
      var qLoop = BDH.loop(q, 2800, function () { if (qTouched) { qLoop.stop(); return; } setQ(order[(qi + 1) % order.length]); });
      BDH.onInteract(q, function () { qTouched = true; });
    }
  }

  /* ---- 04 speculative decoding ---- */
  var sp = grid.querySelector('.tic-sv__sp');
  if (sp && !R) {
    var rounds = null;
    try { rounds = JSON.parse(sp.getAttribute('data-sp')); } catch (e) { rounds = null; }
    var draft = sp.querySelector('[data-sp-draft]'), out = sp.querySelector('[data-sp-out]'), acc = sp.querySelector('[data-sp-acc]');
    var rate = sp.querySelector('[data-sp-rate]'), stepEl = sp.querySelector('[data-sp-step]');
    var passes = BDH.$$('[data-sp-passes] > li', sp);
    function markPasses(n) { passes.forEach(function (li, i) { li.classList.toggle('is-done', i < n); }); }
    if (rounds && draft && out) {
      /* The HTML ships the finished sentence and the figures that go with it. A replay resets all of them
         together, so the output box and the counters beside it never describe different things. */
      var SHIPPED = {
        out: out.textContent,
        acc: acc ? acc.textContent : '', rate: rate ? rate.textContent : '', step: stepEl ? stepEl.textContent : '',
        draft: draft.innerHTML, passes: passes.map(function (li) { return li.className; })
      };
      function restore() {
        out.textContent = SHIPPED.out;
        if (acc) acc.textContent = SHIPPED.acc;
        if (rate) rate.textContent = SHIPPED.rate;
        if (stepEl) stepEl.textContent = SHIPPED.step;
        draft.innerHTML = SHIPPED.draft;
        passes.forEach(function (li, i) { li.className = SHIPPED.passes[i]; });
      }
      var text = '', accepted = 0, drafted = 0, proposed = 0, steps = 0, ri = 0;
      function join(a, b) { return (b === ',' || b === '.' || a === '') ? a + b : a + ' ' + b; }
      function showRound(r) {
        draft.innerHTML = '';
        r[0].forEach(function (tk, i) { var li = document.createElement('li'); li.textContent = tk; li.className = 'is-pend'; li.style.setProperty('--i', i); draft.appendChild(li); });
      }
      var seqSteps = [
        [400, function () { var r = rounds[ri]; showRound(r); BDH.$$('li', draft).forEach(function (li, i) { setTimeout(function () { li.className = 'is-draft'; }, i * 130); }); }],
        [1100, function () { var r = rounds[ri]; BDH.$$('li', draft).forEach(function (li, i) { li.className = i < r[1] ? 'is-ok' : 'is-no'; }); if (acc) acc.textContent = 'accepted ' + r[1] + ' of ' + r[0].length + ' + 1 own'; }],
        [900, function () {
          var r = rounds[ri];
          for (var i = 0; i < r[1]; i++) text = join(text, r[0][i]);
          text = join(text, r[2]);
          accepted += r[1] + 1; drafted += r[1]; proposed += r[0].length; steps++;
          out.textContent = text;
          if (rate) rate.textContent = Math.round(drafted / proposed * 100) + '%';
          if (stepEl) stepEl.textContent = (accepted / steps).toFixed(1);
          BDH.$$('li', draft).forEach(function (li) { li.className += ' is-gone'; });
          ri++;
          markPasses(ri);
        }],
        [700, function () { if (ri >= rounds.length) { ri = 0; text = ''; accepted = 0; drafted = 0; proposed = 0; steps = 0; restore(); } }]
      ];
      BDH.inView(sp, function () {
        text = ''; accepted = 0; drafted = 0; proposed = 0; steps = 0; ri = 0; restore();
        BDH.seq(sp, seqSteps, { loop: true, stopOnInteract: false });
      }, { threshold: 0.4 });
    }
  }
})();
