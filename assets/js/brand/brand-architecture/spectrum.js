/* 4 · SIGNATURE — model spectrum. Positions nodes for the chosen model (transform-only moves),
   redraws connectors with a clip-path wipe, updates the agent's recommendation and trade-offs, and
   records a human decision. Autoplays scenario → slider walk until the first interaction. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var app = document.querySelector('[data-cba-spec]');
  var raw = document.getElementById('spectrum-data');
  if (!app || !raw) return;
  var D; try { D = JSON.parse(raw.textContent); } catch (e) { return; }

  /* x%, y% per model for: mb a b c pc e nw */
  var L = [
    { mb: [50, 18], a: [18, 48], b: [39, 48], c: [61, 48], e: [82, 48], pc: [61, 78], nw: [28, 78] },
    { mb: [50, 17], a: [16, 50], b: [38, 50], c: [62, 50], e: [84, 50], pc: [62, 80], nw: [27, 80] },
    { mb: [50, 15], a: [14, 56], b: [36, 44], c: [60, 56], e: [84, 44], pc: [60, 84], nw: [25, 84] },
    { mb: [50, 13], a: [12, 60], b: [32, 70], c: [52, 60], e: [72, 70], pc: [52, 88], nw: [90, 60] }
  ];
  var BUS = 13;   /* every parent → child line shares one bus, 13% below the parent */
  var REL = [
    { mb: 'On everything', x: 'Descriptor', nw: 'Descriptor' },
    { mb: 'Leads', x: 'Sub-brand', nw: 'Sub-brand' },
    { mb: 'Endorser', x: 'Endorsed', nw: 'Endorsed' },
    { mb: 'Corporate · unseen', x: 'Standalone', nw: 'Standalone' }
  ];
  var LINKS = [['mb', 'a'], ['mb', 'b'], ['mb', 'c'], ['mb', 'e'], ['c', 'pc'], ['mb', 'nw']];
  var nodes = {}; BDH.$$('[data-node]', app).forEach(function (n) { nodes[n.getAttribute('data-node')] = n; });
  var $ = function (k) { return app.querySelector('[data-s="' + k + '"]'); };
  var range = app.querySelector('.cba-spec__range');
  var ticks = BDH.$$('.cba-spec__ticks li', app);
  var scenBtns = BDH.$$('[data-scen]', app).filter(function (b) { return b.tagName === 'BUTTON'; });
  var g = $('lines'), record = $('record'), decideBtn = $('decide');
  var model = +app.getAttribute('data-model'), scen = 0, drawT = 0, decN = 13;
  var NS = 'http://www.w3.org/2000/svg';

  function lines() {
    var lay = L[model], out = '';
    LINKS.forEach(function (lk) {
      var a = lay[lk[0]], b = lay[lk[1]];
      var fromMb = lk[0] === 'mb';
      var ay = a[1] + (fromMb ? 0 : 8), my = fromMb ? a[1] + BUS : (ay + b[1]) / 2;
      var cls = lk[1] === 'nw' ? 'is-new ' : '';
      if (model === 2 && lk[0] === 'mb') cls += 'is-dash';
      if (model === 3 && lk[0] === 'mb') cls += 'is-faint';
      out += '<path class="' + cls + '" d="M' + a[0] + ' ' + ay + 'V' + my + 'H' + b[0] + 'V' + b[1] + '"/>';
    });
    var tmp = document.createElementNS(NS, 'g');
    tmp.innerHTML = out;
    while (g.firstChild) g.removeChild(g.firstChild);
    while (tmp.firstChild) g.appendChild(tmp.firstChild);
  }

  function place() {
    var lay = L[model], rel = REL[model];
    Object.keys(nodes).forEach(function (k) {
      var p = lay[k]; if (!p) return;
      nodes[k].style.setProperty('--x', p[0] + '%');
      nodes[k].style.setProperty('--y', p[1] + '%');
      var sm = nodes[k].querySelector('small');
      if (sm) sm.textContent = rel[k] || rel.x;
    });
    if (BDH.reduced) { lines(); return; }
    app.classList.add('is-redraw');
    clearTimeout(drawT);
    drawT = setTimeout(function () { lines(); app.classList.remove('is-redraw'); }, 650);
  }

  function meters() {
    var s = D.scen[scen][5][model];
    BDH.$$('[data-meter]', app).forEach(function (m, i) {
      m.setAttribute('style', '--v:' + s[i]);
      var b = app.querySelector('[data-mval="' + i + '"]'); if (b) b.textContent = s[i] + '/5';
    });
  }

  function setModel(m) {
    model = Math.max(0, Math.min(3, m));
    app.setAttribute('data-model', model);
    range.value = model;
    range.setAttribute('aria-valuetext', D.models[model]);
    ticks.forEach(function (t, i) { t.classList.toggle('is-on', i === model); });
    $('model').textContent = D.models[model]; $('at').textContent = D.models[model]; $('def').textContent = D.defs[model];
    place(); meters(); resetRecord();
  }

  function setScen(i) {
    scen = i; var s = D.scen[i];
    app.setAttribute('data-scen', i);
    scenBtns.forEach(function (b, n) { b.setAttribute('aria-pressed', n === i ? 'true' : 'false'); });
    $('newname').textContent = s[2]; $('rec').textContent = D.models[s[3]]; $('why').textContent = s[4];
    meters(); resetRecord();
  }

  function resetRecord() {
    record.classList.remove('is-set');
    record.textContent = 'Agents propose and score. The portfolio board decides and signs the decision record.';
    decideBtn.disabled = false;
  }

  function decide() {
    var rec = D.scen[scen][3], followed = rec === model;
    decN++;
    record.classList.add('is-set');
    record.innerHTML = '<b>DR-0' + decN + '</b> · ' + D.scen[scen][1] + ' → <b>' + D.models[model] + '</b>. ' +
      (followed ? 'Agent recommendation followed.' : 'Agent recommended ' + D.models[rec] + '; the board chose otherwise and records why.') +
      ' Decided by the portfolio board.';
    decideBtn.disabled = true;
  }

  range.addEventListener('input', function () { setModel(+range.value); });
  scenBtns.forEach(function (b, n) { b.addEventListener('click', function () { setScen(n); }); });
  decideBtn.addEventListener('click', decide);

  lines(); setModel(model); setScen(0);
  BDH.live(app, 0.2);
  if (BDH.reduced) return;

  /* autoplay: for each scenario, walk the slider from 0 to the recommendation, then record */
  var steps = [];
  D.scen.forEach(function (s, i) {
    steps.push([1400, function () { setScen(i); setModel(0); }]);
    for (var m = 1; m <= s[3]; m++) (function (mm) { steps.push([1600, function () { setModel(mm); }]); })(m);
    steps.push([1800, decide]);
    steps.push([2600, function () {}]);
  });
  BDH.seq(app, steps, { loop: true, stopOnInteract: true });
})();
