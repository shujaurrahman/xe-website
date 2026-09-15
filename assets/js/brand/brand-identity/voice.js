/* Brand Identity · voice — SIGNATURE demo. Reads the pre-authored variant matrix from data-voice;
   "redrafts" word by word, runs four voice checks, and enables Approve only when nothing is flagged.
   Autoplays (context + dials move on their own) until the first interaction inside the desk; approval is
   never automated. Keyboard: tabs are buttons, dials are native range inputs. Reduced motion: instant. */
(function () {
  'use strict';
  var desk = document.querySelector('.cbi-voice__desk'); if (!desk) return;
  var D; try { D = JSON.parse(desk.getAttribute('data-voice')); } catch (e) { return; }
  var R = !!(window.BDH && BDH.reduced);
  var $ = function (s) { return desk.querySelector(s); };
  var tabs = Array.prototype.slice.call(desk.querySelectorAll('.cbi-voice__tab'));
  var rf = $('#voice-formality'), rl = $('#voice-length');
  var of = $('#voice-formality-o'), ol = $('#voice-length-o');
  var proof = $('.cbi-voice__proof'), line = $('.cbi-voice__line'), setEl = $('.cbi-voice__set');
  var status = $('.cbi-voice__status'), words = $('.cbi-voice__words');
  var checks = Array.prototype.slice.call(desk.querySelectorAll('.cbi-voice__checks li'));
  var approve = $('.cbi-voice__approve'), hint = $('.cbi-voice__hint'), log = $('.cbi-voice__logl');
  var NEVER = ['inconvenience', 'unfortunately', 'kindly', 'utilise', 'valued'];
  var BLAME = /^(invalid|fault|failed)$/i;
  var LIMIT = [18, 32, 56];
  var NAMES = ['Length', 'Lexicon', 'Blame', 'Punctuation'];
  var ctx = 'support', f = 1, l = 1, timers = [], approved = {}, logged = 0;

  function ctxLabel(k) { for (var i = 0; i < D.ctx.length; i++) if (D.ctx[i][0] === k) return D.ctx[i][1]; return k; }
  function clear() { timers.forEach(clearTimeout); timers = []; }
  function later(fn, ms) { timers.push(setTimeout(fn, ms)); }
  function bare(w) { return w.toLowerCase().replace(/[^a-z’']/g, ''); }

  function assess(text) {
    var toks = text.split(/\s+/), flags = [false, false, false, false], marks = {};
    if (toks.length > LIMIT[l]) flags[0] = true;
    toks.forEach(function (t, i) {
      if (NEVER.indexOf(bare(t)) > -1) { flags[1] = true; marks[i] = 1; }
      if (BLAME.test(bare(t))) { flags[2] = true; marks[i] = 1; }
      if ((t.match(/!/g) || []).length > 1) { flags[3] = true; marks[i] = 1; }
    });
    return { toks: toks, flags: flags, marks: marks };
  }

  function setCheck(li, st) {
    li.className = st;
    li.querySelector('em').textContent = st === 'is-ok' ? 'Pass' : st === 'is-flag' ? 'Flag' : '…';
  }

  function render(animate) {
    clear();
    var text = D.m[ctx][f][l], a = assess(text), key = ctx + f + l;
    var n = a.flags.filter(Boolean).length;
    of.textContent = D.f[f]; ol.textContent = D.l[l];
    rf.value = f; rl.value = l;
    rf.setAttribute('aria-valuetext', D.f[f]); rl.setAttribute('aria-valuetext', D.l[l]);
    tabs.forEach(function (t) { t.setAttribute('aria-pressed', String(t.getAttribute('data-ctx') === ctx)); });
    setEl.textContent = ctxLabel(ctx) + ' · ' + D.f[f] + ' · ' + D.l[l];
    words.textContent = a.toks.length + ' words · limit ' + LIMIT[l];
    line.setAttribute('data-len', String(l));

    line.textContent = '';
    a.toks.forEach(function (t, i) {
      var s = document.createElement('span');
      s.className = 'w' + (a.marks[i] ? ' is-flag' : '');
      s.style.setProperty('--i', i);
      s.textContent = t + (i < a.toks.length - 1 ? ' ' : '');
      line.appendChild(s);
    });

    function done() {
      proof.classList.remove('is-busy');
      checks.forEach(function (li, i) { setCheck(li, a.flags[i] ? 'is-flag' : 'is-ok'); });
      status.lastChild.textContent = n ? n + (n > 1 ? ' flags' : ' flag') + ' raised' : 'Draft ready';
      var isApproved = !!approved[key];
      approve.disabled = n > 0 || isApproved;
      approve.textContent = isApproved ? 'Approved' : 'Approve line';
      var which = NAMES.filter(function (x, i) { return a.flags[i]; }).join(' and ').toLowerCase();
      hint.textContent = isApproved ? 'Already approved and logged.' : n ? 'The agent flagged ' + which + '. Change the settings, or send it back for a rewrite.' : 'All four checks pass. Your call.';
    }

    if (!animate) { line.classList.remove('is-drafting'); done(); return; }
    proof.classList.add('is-busy');
    status.lastChild.textContent = 'Agent redrafting';
    approve.disabled = true;
    hint.textContent = 'Checking against the voice rules…';
    checks.forEach(function (li) { setCheck(li, 'is-wait'); });
    line.classList.add('is-drafting');
    void line.offsetWidth;
    line.classList.remove('is-drafting');
    var t0 = a.toks.length * 26 + 350;
    checks.forEach(function (li, i) { later(function () { setCheck(li, a.flags[i] ? 'is-flag' : 'is-ok'); }, t0 + i * 240); });
    later(done, t0 + checks.length * 240 + 80);
  }

  tabs.forEach(function (t) { t.addEventListener('click', function () { ctx = t.getAttribute('data-ctx'); render(!R); }); });
  rf.addEventListener('input', function () { f = +rf.value; render(!R); });
  rl.addEventListener('input', function () { l = +rl.value; render(!R); });

  approve.addEventListener('click', function () {
    var key = ctx + f + l; if (approved[key] || approve.disabled) return;
    approved[key] = true; logged++;
    var empty = log.querySelector('.cbi-voice__empty'); if (empty) empty.remove();
    var li = document.createElement('li');
    var b = document.createElement('b'); b.textContent = ('0' + logged).slice(-2);
    var q = document.createElement('q'); q.textContent = D.m[ctx][f][l];
    var sm = document.createElement('small'); sm.textContent = ctxLabel(ctx) + ' · ' + D.f[f] + ' · ' + D.l[l] + ' · approved by you';
    li.appendChild(b); li.appendChild(q); li.appendChild(sm);
    log.insertBefore(li, log.firstChild);
    while (log.children.length > 4) log.removeChild(log.lastChild);
    approve.disabled = true; approve.textContent = 'Approved';
    hint.textContent = 'Approved and logged. The agent never adds lines here.';
  });

  render(false);
  if (!window.BDH || R) return;
  var steps = [
    [2400, function () { l = 2; render(true); }],
    [3400, function () { f = 2; render(true); }],
    [3400, function () { ctx = 'error'; f = 0; l = 0; render(true); }],
    [3400, function () { f = 1; render(true); }],
    [3400, function () { ctx = 'launch'; f = 2; l = 2; render(true); }],
    [3400, function () { l = 1; render(true); }],
    [3400, function () { ctx = 'price'; f = 0; render(true); }],
    [3400, function () { ctx = 'support'; f = 1; l = 1; render(true); }],
  ];
  BDH.seq(desk, steps, { loop: true, onStop: function () { clear(); render(false); } });
})();
