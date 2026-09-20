/* Cybersecurity & AI Trust · range — SIGNATURE red-team range. Works like the real tool: choose an
   attack, switch layers, Launch. The payload token walks the request path; the first effective layer
   that is on stops it (the gate flashes, the token shatters), otherwise it reaches the customer and an
   incident opens. While the token travels, the result panel reads Running and names the layer being
   probed. Result, OWASP / ATLAS mapping, log and the coverage matrix all update.
   Autoplay runs a scripted tour (all on, then layers off) until the first interaction inside the UI.
   Reduced motion: no autoplay and no travel; Launch shows the result at once. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var ui = document.querySelector('.tsc-range__ui'); if (!ui) return;
  var dataEl = document.getElementById('range-data'); if (!dataEl) return;
  var D; try { D = JSON.parse(dataEl.textContent); } catch (err) { return; }
  var R = BDH.reduced;
  var $ = function (s) { return ui.querySelector(s); };
  var radios = BDH.$$('input[name="range-attack"]', ui);
  var gates = BDH.$$('.tsc-gate', ui);
  var sws = BDH.$$('.tsc-gate__sw', ui);
  var stages = BDH.$$('[data-stage]', ui);
  var path = $('.tsc-range__path'), token = $('.tsc-range__token');
  var launch = $('[data-launch]'), mode = $('[data-mode]');
  var model = $('.tsc-stage--model'), out = $('.tsc-stage--out');
  var GATE_STAGE = [1, 2, 4, 5, 6], OUT_STAGE = 7, MODEL_STAGE = 3;
  var on = [true, true, true, true, true];
  var cur = Math.max(0, radios.findIndex(function (r) { return r.checked; }));
  var timers = [], running = false, clock = 9 * 3600 + 41 * 60 + 2, sec = 214;

  function later(ms, fn) { timers.push(setTimeout(fn, R ? 0 : ms)); }
  function clearRun() { timers.forEach(clearTimeout); timers = []; running = false; if (launch) launch.disabled = false; }
  function A() { return D.attacks[cur]; }
  function first(a) { for (var i = 0; i < 5; i++) { if (a.stops[i] && on[i]) return i; } return -1; }
  function txt(sel, t) { var n = $(sel); if (n) n.textContent = t; }
  function pad(n) { return (n < 10 ? '0' : '') + n; }
  function now() { clock += 37; return pad(Math.floor(clock / 3600) % 24) + ':' + pad(Math.floor(clock / 60) % 60) + ':' + pad(clock % 60); }
  function lname(i) { return D.layers[i][0]; }

  function refs(sel, list, idFirst) {
    var dd = $(sel); if (!dd) return;
    dd.textContent = '';
    list.forEach(function (x) {
      var s = document.createElement('span'); s.className = 'tsc-range__ref';
      var k = document.createElement('span'); k.className = 'tsc-kbd'; k.textContent = idFirst ? x[0] : x[1];
      s.appendChild(k); s.appendChild(document.createTextNode(idFirst ? x[1] : x[0]));
      dd.appendChild(s);
    });
  }

  function gateState(g, st, text) {
    g.classList.remove('is-pass', 'is-block', 'is-wait', 'is-skip', 'is-flash');
    g.classList.add('is-' + st);
    var r = g.querySelector('[data-res]'); if (r) r.textContent = text;
  }
  function passText(a, i) {
    if (i === 0) return 'Allowed · score ' + a.score;
    if (i === 1) return a.vector.indexOf('Retrieved') === 0 ? 'Allowed' : 'No retrieved content';
    if (i === 2 || i === 3) return a.tool ? 'Allowed' : 'No tool call';
    return a.tool ? 'Reply looks clean · the harm is in the tool call' : 'Allowed';
  }

  function paintMatrix() {
    var blocked = 0;
    BDH.$$('.tsc-mx [data-col]', ui).forEach(function (c) { c.classList.toggle('is-off', !on[parseInt(c.getAttribute('data-col'), 10)]); });
    BDH.$$('.tsc-mx tbody tr', ui).forEach(function (tr) {
      var i = parseInt(tr.getAttribute('data-row'), 10), s = first(D.attacks[i]);
      if (s !== -1) blocked++;
      tr.classList.toggle('is-cur', i === cur);
      tr.classList.toggle('is-exposed', s === -1);
      var n = tr.querySelector('[data-now]'); if (n) n.textContent = s === -1 ? 'Exposed' : 'Blocked at L' + (s + 1);
    });
    txt('[data-total]', blocked + ' / ' + D.attacks.length + ' blocked');
  }

  /* the armed state: attack loaded, layers set, nothing sent yet */
  function arm() {
    var a = A();
    txt('[data-vector]', a.vector);
    txt('[data-payload]', a.payload);
    gates.forEach(function (g, i) { g.classList.toggle('is-off', !on[i]); gateState(g, 'wait', on[i] ? 'Armed' : 'Layer off'); });
    stages.forEach(function (s) { s.classList.remove('is-now', 'is-done'); });
    if (model) { model.classList.remove('is-hit'); txt('[data-model]', 'Waiting'); }
    if (out) { out.classList.remove('is-harm'); }
    txt('[data-out]', 'Press Launch attack to send the payload.');
    var inc = $('[data-incident]'); if (inc) inc.hidden = true;
    ui.setAttribute('data-state', 'ready');
    var chip = $('[data-chip]'); if (chip) { chip.className = 'tsc-sev tsc-sev--low'; chip.textContent = 'Ready'; }
    txt('[data-verdict]', a.id + ' · ' + a.name);
    txt('[data-why]', on.filter(Boolean).length + ' of 5 layers on. Launch to see where it stops.');
    refs('[data-owasp]', a.owasp, true);
    refs('[data-atlas]', a.atlas, false);
    if (token) token.classList.remove('is-show', 'is-shatter');
    paintMatrix();
  }

  function place(s, instant) {
    if (!token || !path) return;
    var el = stages[s]; if (!el) return;
    var y = el.offsetTop + el.offsetHeight / 2;
    if (instant) { token.style.transition = 'none'; }
    token.style.transform = 'translate(-50%,' + y.toFixed(1) + 'px)';
    if (instant) { void token.offsetWidth; token.style.transition = ''; }
  }

  function log(kind, text) {
    var ol = $('[data-log]'); if (!ol) return;
    var li = document.createElement('li'); li.className = 'is-' + kind + (R ? '' : ' is-new');
    var t = document.createElement('time'); t.textContent = now();
    var b = document.createElement('b'); b.textContent = kind === 'blocked' ? 'BLOCKED' : 'INCIDENT';
    var s = document.createElement('span'); s.textContent = text;
    li.appendChild(t); li.appendChild(b); li.appendChild(s); ol.appendChild(li);
    while (ol.children.length > 7) ol.removeChild(ol.firstElementChild);
  }

  function finish(a, stop) {
    var ids = a.owasp.map(function (o) { return o[0]; }).join(' '), atlas = a.atlas[0][1];
    var chip = $('[data-chip]');
    if (stop === -1) {
      sec++;
      ui.setAttribute('data-state', 'incident');
      if (chip) { chip.className = 'tsc-sev tsc-sev--crit'; chip.textContent = 'Incident'; }
      txt('[data-verdict]', 'Reached the customer');
      var offs = a.stops.map(function (v, i) { return v && !on[i] ? 'L' + (i + 1) : null; }).filter(Boolean);
      txt('[data-why]', offs.length ? 'The layers that stop this attack are off: ' + offs.join(', ') + '. SEC-' + sec + ' opened.' : 'No active layer stops this attack. SEC-' + sec + ' opened.');
      log('incident', a.id + ' ' + a.name.toLowerCase() + ' · no layer stopped it · ' + ids + ' · ' + atlas + ' · SEC-' + sec);
    } else {
      ui.setAttribute('data-state', 'blocked');
      if (chip) { chip.className = 'tsc-sev tsc-sev--ok'; chip.textContent = 'Blocked'; }
      txt('[data-verdict]', 'at L' + (stop + 1) + ' · ' + lname(stop));
      txt('[data-why]', a.block[stop]);
      log('blocked', a.id + ' ' + a.name.toLowerCase() + ' · stopped at L' + (stop + 1) + ' ' + lname(stop).toLowerCase() + ' · ' + ids + ' · ' + atlas);
    }
    paintMatrix();
    running = false; if (launch) launch.disabled = false;
  }

  function reach(s, a, stop) {
    stages.forEach(function (x, k) { x.classList.toggle('is-now', k === s); x.classList.toggle('is-done', k < s); });
    var gi = GATE_STAGE.indexOf(s);
    if (gi > -1) {
      var g = gates[gi];
      if (gi === stop) {
        gateState(g, 'block', a.block[gi]);
        if (!R) { void g.offsetWidth; g.classList.add('is-flash'); }
        if (token) token.classList.add('is-shatter');
      } else if (!on[gi]) {
        gateState(g, 'wait', 'Layer off · passed through');
      } else {
        var skip = (gi === 2 || gi === 3) && !a.tool;
        gateState(g, skip ? 'skip' : 'pass', passText(a, gi));
      }
    } else if (s === MODEL_STAGE) {
      if (model) model.classList.add('is-hit');
      txt('[data-model]', a.tool ? 'Complied · calls issue_refund' : 'Complied · followed the payload');
    } else if (s === OUT_STAGE) {
      if (stop === -1) {
        if (out) out.classList.add('is-harm');
        txt('[data-out]', a.harm);
        var inc = $('[data-incident]'); if (inc) inc.hidden = false;
      }
    }
  }

  /* the panel has to read as "the attack is executing", not as "nothing happened yet" */
  function inflight(s, a, stop) {
    var gi = GATE_STAGE.indexOf(s);
    if (gi > -1) {
      txt('[data-why]', on[gi]
        ? 'Probing layer ' + (gi + 1) + ' of ' + GATE_STAGE.length + ' \u00B7 ' + lname(gi) + '\u2026'
        : 'Layer ' + (gi + 1) + ' is off \u00B7 passing through\u2026');
    } else if (s === MODEL_STAGE) {
      txt('[data-why]', 'The model has the payload\u2026');
    } else if (s === OUT_STAGE) {
      txt('[data-why]', stop === -1 ? 'Returning to the customer\u2026' : 'Returning the safe reply\u2026');
    }
  }

  function run() {
    if (running) return;
    clearRun(); arm();
    running = true; if (launch) launch.disabled = true;
    var a = A(), stop = first(a);
    var end = stop === -1 ? OUT_STAGE : GATE_STAGE[stop];
    ui.setAttribute('data-state', 'running');
    var rchip = $('[data-chip]');
    if (rchip) { rchip.className = 'tsc-sev tsc-sev--med'; rchip.textContent = 'Running'; }
    txt('[data-why]', 'Payload sent \u00B7 walking the request path\u2026');
    txt('[data-out]', '…');
    if (stop !== -1 && stop < 2 && model) txt('[data-model]', 'Not reached');
    if (token && !R) { token.classList.remove('is-shatter'); place(0, true); token.classList.add('is-show'); }
    var t = 0, STEP = 460;
    reach(0, a, stop);
    for (var s = 1; s <= end; s++) {
      (function (s) {
        t += STEP;
        later(t, function () { place(s); reach(s, a, stop); inflight(s, a, stop); });
      })(s);
    }
    later(t + 520, function () {
      if (stop !== -1) {
        txt('[data-out]', a.safe);
        for (var k = end + 1; k < stages.length; k++) {
          var gi = GATE_STAGE.indexOf(k);
          if (gi > -1) gateState(gates[gi], 'wait', on[gi] ? 'Not reached' : 'Layer off');
          if (k === MODEL_STAGE) txt('[data-model]', 'Not reached');
        }
      }
      finish(a, stop);
    });
    later(t + 1500, function () { if (token && !running) token.classList.remove('is-show'); });
  }

  /* ---- controls ---- */
  function select(i) {
    cur = i;
    radios.forEach(function (r, k) { r.checked = k === i; });
    clearRun(); arm();
  }
  function setLayer(i, v) {
    on[i] = v;
    if (sws[i]) sws[i].setAttribute('aria-pressed', v ? 'true' : 'false');
    clearRun(); arm();
  }
  radios.forEach(function (r, i) { r.addEventListener('change', function () { if (r.checked) select(i); }); });
  sws.forEach(function (b, i) { b.addEventListener('click', function () { setLayer(i, !on[i]); }); });
  BDH.$$('[data-pick]', ui).forEach(function (b) { b.addEventListener('click', function () { select(parseInt(b.getAttribute('data-pick'), 10)); }); });
  BDH.$$('[data-preset]', ui).forEach(function (b) {
    b.addEventListener('click', function () {
      var v = b.getAttribute('data-preset') === 'on';
      for (var i = 0; i < 5; i++) { on[i] = v; if (sws[i]) sws[i].setAttribute('aria-pressed', v ? 'true' : 'false'); }
      clearRun(); arm();
    });
  });
  if (launch) launch.addEventListener('click', run);
  window.addEventListener('resize', function () { if (!running && token) token.classList.remove('is-show'); }, { passive: true });

  paintMatrix();
  function manual() { if (mode) { mode.textContent = 'Manual'; mode.classList.add('is-manual'); } }
  if (R) { manual(); return; }

  /* ---- autoplay tour, until the first touch ---- */
  var tour = [
    [1600, function () { select(1); }],
    [700, run],
    [4600, function () { select(2); }],
    [700, run],
    [4600, function () { setLayer(4, false); }],
    [900, run],
    [5600, function () { setLayer(4, true); select(4); }],
    [700, run],
    [4600, function () { setLayer(2, false); }],
    [900, run],
    [4600, function () { setLayer(3, false); }],
    [900, run],
    [5600, function () { for (var i = 0; i < 5; i++) setLayer(i, true); select(0); }],
    [700, run],
    [4200, function () {}]
  ];
  BDH.inView(ui, function () {
    BDH.seq(ui, tour, { loop: true, stopOnInteract: true, interactRoot: ui, onStop: manual });
  }, { threshold: 0.3 });
})();
