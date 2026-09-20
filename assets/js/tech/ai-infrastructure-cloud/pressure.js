/* AI Infrastructure & Cloud · pressure — switches the request anatomy between "As shipped" and "Tuned":
   bar segments move and resize, table cells swap, the headline figures count to their new values.
   Alternates on its own while on screen until the reader touches the panel. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tic-pr__anat');
  if (!root) return;
  var R = BDH.reduced, data = null;
  try { data = JSON.parse(root.getAttribute('data-pr')); } catch (e) { return; }
  var btns = BDH.$$('[data-pr-mode]', root), status = BDH.$('[data-pr-status]', root);
  var cur = 'shipped', shown = { cost1k: data.shipped.cost1k, ttft: data.shipped.ttft, month: data.shipped.month };

  function money(v, dp) { return '$' + v.toLocaleString('en-US', { minimumFractionDigits: dp, maximumFractionDigits: dp }); }
  var FMT = {
    cost1k: function (v) { return money(v, 2); },
    ttft: function (v) { return v.toFixed(2) + ' s'; },
    month: function (v) { return money(Math.round(v), 0); }
  };

  function tween(key, to) {
    var el = BDH.$('[data-pr-kpi="' + key + '"]', root); if (!el) return;
    var from = shown[key]; shown[key] = to;
    if (R) { el.textContent = FMT[key](to); return; }
    var t0 = null;
    requestAnimationFrame(function f(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / 750), k = 1 - Math.pow(1 - p, 3);
      el.textContent = FMT[key](from + (to - from) * k);
      if (p < 1) requestAnimationFrame(f);
    });
  }

  function delta(key, text, good) {
    var el = BDH.$('[data-pr-delta="' + key + '"]', root); if (!el) return;
    el.textContent = text; el.classList.toggle('is-good', !!good);
  }

  function set(mode) {
    if (mode === cur) return;
    cur = mode;
    root.setAttribute('data-mode', mode);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-pr-mode') === mode ? 'true' : 'false'); });

    BDH.$$('.tic-pr__sg', root).forEach(function (s) {
      var g = (s.getAttribute('data-' + mode) || '0,0').split(',');
      s.style.setProperty('--x', g[0]); s.style.setProperty('--w', g[1]);
    });
    BDH.$$('.tic-pr__ft', root).forEach(function (s) { s.style.setProperty('--x', s.getAttribute('data-' + mode)); });
    BDH.$$('[data-pr-cell]', root).forEach(function (c) {
      var t = c.getAttribute('data-' + mode);
      if (t !== null && c.textContent !== t) {
        c.textContent = t;
        if (!R) { c.classList.remove('is-flash'); void c.offsetWidth; c.classList.add('is-flash'); }
      }
    });

    var m = data[mode], s = data.shipped;
    var tot = BDH.$$('[data-pr-total]', root);
    tot.forEach(function (el) {
      var k = el.getAttribute('data-pr-total');
      el.textContent = k === 'tok' ? m.tokT.toLocaleString('en-US') : k === 'cost' ? money(m.costT, 4) : m.timeT.toFixed(2) + ' s';
    });
    tween('cost1k', m.cost1k); tween('ttft', m.ttft); tween('month', m.month);
    if (mode === 'tuned') {
      delta('cost', '−' + Math.round((1 - m.cost1k / s.cost1k) * 100) + '% vs shipped', true);
      delta('ttft', '−' + Math.round((1 - m.ttft / s.ttft) * 100) + '% vs shipped', true);
      delta('month', '−' + money(s.month - m.month, 0) + ' a month', true);
    } else {
      delta('cost', 'baseline'); delta('ttft', 'baseline'); delta('month', 'baseline');
    }
    if (status) {
      status.textContent = (mode === 'tuned' ? 'Showing the tuned request: ' : 'Showing the request as shipped: ') +
        m.tokT.toLocaleString('en-US') + ' tokens, ' + money(m.cost1k, 2) + ' per thousand of this request, ' + m.ttft.toFixed(2) + ' seconds to first token.';
    }
  }

  btns.forEach(function (b) { b.addEventListener('click', function () { set(b.getAttribute('data-pr-mode')); }); });

  var cards = document.querySelector('.tic-pr__cards');
  if (cards) BDH.live(cards, 0.2);

  if (R) return;
  BDH.inView(root, function () {
    BDH.seq(root, [
      [4200, function () { set('tuned'); }],
      [4600, function () { set('shipped'); }]
    ], { loop: true, interactRoot: root });
  }, { threshold: 0.35 });
})();
