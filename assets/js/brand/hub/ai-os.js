/* Hub · AI brand OS — plays the Check demo (scan → checks resolve → flag → fix → approve → log)
   through three sample assets until the reader interacts, then hands over the controls.
   Generate and Guidelines type their inputs the first time they are opened. Reduced motion:
   the markup's finished state stays as it is, and the controls still work instantly. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.bdh-ai-os');
  if (!root) return;
  var os = BDH.$('.bdh-os', root);
  var stage = BDH.$('.bdh-os__stage', root);
  if (!os || !stage) return;

  var FLAG = [3, 1, 5];
  var ASSET_NAMES = ['Market 03 · social', 'Partner · web banner', 'Retail · window poster'];
  var ACTIONS = ['Contrast fixed by agent', 'Clearspace fixed by agent', 'Claim rewritten from library'];
  var checks = BDH.$$('.bdh-os__checks li', root);
  var assetBtns = BDH.$$('.bdh-os__asset', root);
  var score = BDH.$('.bdh-os__score', root);
  var applyBtn = BDH.$('.bdh-os__apply', root);
  var sendBtn = BDH.$('.bdh-os__send', root);
  var doneText = BDH.$('.bdh-os__donet', root);
  var logBody = BDH.$('.bdh-os__log tbody', root);
  var total = checks.length;
  var cur = 0, timers = [], clock = 10 * 60 + 43;

  function later(fn, ms) { timers.push(setTimeout(fn, ms)); }
  function clear() { timers.forEach(clearTimeout); timers = []; }
  function pad(n) { return (n < 10 ? '0' : '') + n; }

  /* ---- state painters (no timing inside) ---- */
  function select(i) {
    cur = i;
    stage.setAttribute('data-asset', String(i));
    assetBtns.forEach(function (b, n) { b.setAttribute('aria-pressed', n === i ? 'true' : 'false'); });
  }
  function startScan(i) {
    select(i);
    stage.setAttribute('data-state', 'scan');
    checks.forEach(function (c, k) { c.className = k === 0 ? 'is-run' : 'is-wait'; });
    if (score) score.textContent = 'Checking…';
  }
  function resolve(k) {
    checks[k].className = k === FLAG[cur] ? 'is-flag' : 'is-ok';
    if (checks[k + 1]) checks[k + 1].className = 'is-run';
  }
  function flag() {
    checks.forEach(function (c, k) { c.className = k === FLAG[cur] ? 'is-flag' : 'is-ok'; });
    stage.setAttribute('data-state', 'flag');
    if (score) score.textContent = (total - 1) + ' / ' + total + ' pass';
  }
  function log(action, decision, status) {
    if (!logBody) return;
    clock++;
    var tr = document.createElement('tr');
    tr.className = 'is-new';
    [pad(Math.floor(clock / 60)) + ':' + pad(clock % 60), ASSET_NAMES[cur], action, decision].forEach(function (t) {
      var td = document.createElement('td'); td.textContent = t; tr.appendChild(td);
    });
    var td = document.createElement('td'), st = document.createElement('span');
    st.className = 'bdh-os__st'; st.textContent = status; td.appendChild(st); tr.appendChild(td);
    logBody.insertBefore(tr, logBody.firstChild);
    while (logBody.children.length > 7) logBody.removeChild(logBody.lastChild);
  }
  function apply(decision) {
    checks.forEach(function (c) { c.className = 'is-ok'; });
    stage.setAttribute('data-state', 'fixed');
    if (score) score.textContent = total + ' / ' + total + ' pass';
    if (doneText) doneText.textContent = decision + ' · logged';
    if (applyBtn) applyBtn.classList.remove('is-press');
    log(ACTIONS[cur], decision, decision.indexOf('reviewer') > -1 && decision.indexOf('Sent') === 0 ? 'In review' : 'Shipped');
  }

  /* ---- manual run (after the reader takes over) ---- */
  function runManual(i) {
    clear();
    startScan(i);
    if (BDH.reduced) { flag(); return; }
    checks.forEach(function (c, k) { later(function () { resolve(k); if (k === total - 1) flag(); }, 1300 + k * 220); });
  }
  assetBtns.forEach(function (b) {
    b.addEventListener('click', function () { runManual(parseInt(b.getAttribute('data-asset'), 10)); });
  });
  if (applyBtn) applyBtn.addEventListener('click', function () { clear(); apply('Approved by Brand reviewer'); });
  if (sendBtn) sendBtn.addEventListener('click', function () { clear(); apply('Sent to Brand reviewer'); });

  /* ---- tabs; Generate and Guidelines type their input the first time they open ---- */
  var played = {};
  function typeIn(pane) {
    var el = BDH.$('.bdh-os__typed', pane);
    if (!el || BDH.reduced) return;
    pane.classList.remove('is-run'); void pane.offsetWidth; pane.classList.add('is-run');
    BDH.type(el, el.getAttribute('data-text'), { speed: 26, delay: 250 });
  }
  BDH.tabs(os, {
    tabs: '.bdh-os__tabs [role="tab"]',
    orientation: 'vertical',
    onChange: function (i) {
      var pane = document.getElementById('ai-os-p' + i);
      if (pane && (i === 1 || i === 2) && !played[i]) { played[i] = true; typeIn(pane); }
    }
  });

  /* ---- autoplay: three assets, scan → resolve → flag → press → approve → hold ---- */
  if (BDH.reduced) return;
  var steps = [];
  [0, 1, 2].forEach(function (i) {
    steps.push([900, function () { startScan(i); }]);
    for (var k = 0; k < total; k++) {
      (function (k) { steps.push([k === 0 ? 1400 : 340, function () { resolve(k); }]); })(k);
    }
    steps.push([200, flag]);
    steps.push([1900, function () { if (applyBtn) applyBtn.classList.add('is-press'); }]);
    steps.push([380, function () { apply('Approved by Brand reviewer'); }]);
    steps.push([2600, function () {}]);
  });
  BDH.seq(os, steps, { loop: true, interactRoot: os, onStop: function () { if (applyBtn) applyBtn.classList.remove('is-press'); } });
})();
