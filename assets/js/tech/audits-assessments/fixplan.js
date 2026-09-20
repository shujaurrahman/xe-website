/* Audits & Assessments · fixplan — the fix-order planner.
   The plan that ships in the HTML was computed in PHP; this file runs the identical calculation in
   the browser so the controls are live. Greedy ranking by score density with dependency closure,
   pinned items forced in first, lanes split at a third of capacity. Cards move between lanes with a
   FLIP transform, the curve redraws, the readouts count. Reduced motion: every change lands at once.
   Without JS the section is already a finished, readable plan. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-taa-fix]');
  if (!root) return;

  var rows = {}, ids = [];
  try {
    JSON.parse(root.getAttribute('data-rows') || '[]').forEach(function (r) { rows[r.id] = r; ids.push(r.id); });
  } catch (err) { return; }
  if (!ids.length) return;

  var TOTAL_D = parseInt(root.getAttribute('data-total-days'), 10) || 1;
  var TOTAL_V = parseInt(root.getAttribute('data-total-value'), 10) || 1;
  var VW = parseInt(root.getAttribute('data-vw'), 10) || 680;
  var VH = parseInt(root.getAttribute('data-vh'), 10) || 188;
  var PAD = parseInt(root.getAttribute('data-pad'), 10) || 10;
  var LANES = { now: 'Now', next: 'Next', later: 'Later' };

  var maxRisk = 0, maxVal = 0, totalRisk = 0;
  ids.forEach(function (id) {
    maxRisk = Math.max(maxRisk, rows[id].risk);
    maxVal = Math.max(maxVal, rows[id].val);
    totalRisk += rows[id].risk;
  });

  var slider = root.querySelector('[data-taa-cap]');
  var capNum = root.querySelector('[data-taa-capnum]');
  var capRef = root.querySelector('[data-taa-capref]');
  var objBtns = BDH.$$('[data-taa-obj] [role="radio"]', root);
  var tbody = root.querySelector('[data-taa-tbody]');
  var solidEl = root.querySelector('[data-taa-solid]');
  var dashEl = root.querySelector('[data-taa-dash]');
  var markEl = root.querySelector('[data-taa-mark]');
  var say = root.querySelector('[data-taa-say]');

  var OBJ_NAME = { risk: 'reduce risk first', revenue: 'recover revenue first', balanced: 'balanced' };
  var checked = objBtns.filter(function (b) { return b.getAttribute('aria-checked') === 'true'; })[0];
  var state = {
    cap: slider ? parseInt(slider.value, 10) || 30 : 30,
    obj: checked ? checked.getAttribute('data-obj') : 'balanced',
    pins: []
  };

  /* ---------- the calculation (mirrors taa_fp_rank / taa_fp_plan) ---------- */
  function score(row, obj) {
    var riskN = maxRisk ? row.risk / maxRisk : 0;
    var valN = maxVal ? row.val / maxVal : 0;
    if (obj === 'risk') return riskN;
    if (obj === 'revenue') return valN;
    return 0.5 * riskN + 0.5 * valN;
  }

  function closure(id, taken, seen) {
    seen = seen || {};
    if (taken[id] || seen[id]) return [];
    seen[id] = true;
    var out = [];
    (rows[id].deps || []).forEach(function (dep) {
      if (!rows[dep]) return;
      closure(dep, taken, seen).forEach(function (add) { if (out.indexOf(add) < 0) out.push(add); });
    });
    out.push(id);
    return out;
  }

  function rank(obj) {
    var taken = {}, order = [];
    while (order.length < ids.length) {
      var best = null, bestD = -1, bestSet = [];
      ids.forEach(function (id) {
        if (taken[id]) return;
        var set = closure(id, taken), sum = 0, eff = 0;
        set.forEach(function (sid) { sum += score(rows[sid], obj); eff += rows[sid].eff; });
        var dens = eff ? sum / eff : 0;
        if (dens > bestD + 1e-9) { bestD = dens; best = id; bestSet = set; }
      });
      if (!best) break;
      bestSet.forEach(function (sid) { taken[sid] = true; order.push(sid); });
    }
    return order;
  }

  function plan(order, cap, pins) {
    var taken = {}, chosen = [], used = 0;
    order.forEach(function (id) {
      if (pins.indexOf(id) < 0 || taken[id]) return;
      closure(id, taken).forEach(function (sid) { taken[sid] = true; chosen.push(sid); used += rows[sid].eff; });
    });
    order.forEach(function (id) {
      if (taken[id]) return;
      var set = closure(id, taken), eff = 0;
      set.forEach(function (sid) { eff += rows[sid].eff; });
      if (used + eff > cap) return;
      set.forEach(function (sid) { taken[sid] = true; chosen.push(sid); used += rows[sid].eff; });
    });
    var nowCap = Math.max(1, Math.ceil(cap / 3));
    var lane = {}, cum = 0, val = 0, fixed = 0;
    chosen.forEach(function (id, n) {
      cum += rows[id].eff;
      lane[id] = (cum <= nowCap || n === 0) ? 'now' : 'next';
      if (pins.indexOf(id) >= 0) lane[id] = 'now';
      val += rows[id].val;
      fixed += rows[id].risk;
    });
    var rest = [];
    order.forEach(function (id) { if (!taken[id]) { lane[id] = 'later'; rest.push(id); } });
    return {
      lane: lane, order: chosen, rest: rest, days: used, value: val,
      residual: totalRisk ? Math.round(100 * (totalRisk - fixed) / totalRisk) : 0
    };
  }

  /* ---------- drawing ------------------------------------------------------ */
  function pt(days, val) {
    var xx = PAD + (days / TOTAL_D) * (VW - 2 * PAD);
    var yy = (VH - PAD) - (val / TOTAL_V) * (VH - 2 * PAD);
    return Math.round(xx * 10) / 10 + ' ' + Math.round(yy * 10) / 10;
  }
  function path(list, d0, v0) {
    var out = ['M ' + pt(d0, v0)], dd = d0, vv = v0;
    list.forEach(function (id) { dd += rows[id].eff; vv += rows[id].val; out.push('L ' + pt(dd, vv)); });
    return { d: out.join(' '), days: dd, val: vv };
  }

  function setNum(el, n, money) {
    if (!el) return;
    el.textContent = money ? n.toLocaleString('en-US') : String(n);
  }

  function flip(cards, mutate) {
    if (BDH.reduced) { mutate(); return; }
    var first = cards.map(function (c) { return c.getBoundingClientRect(); });
    mutate();
    cards.forEach(function (c, n) {
      var a = first[n], b = c.getBoundingClientRect();
      var dx = a.left - b.left, dy = a.top - b.top;
      if (Math.abs(dx) < 1 && Math.abs(dy) < 1) return;
      c.classList.add('is-move');
      c.style.transition = 'none';
      c.style.transform = 'translate(' + dx + 'px,' + dy + 'px)';
      requestAnimationFrame(function () {
        c.style.transition = 'transform .5s cubic-bezier(.22,1,.36,1)';
        c.style.transform = '';
      });
      window.setTimeout(function () { c.style.transition = ''; c.classList.remove('is-move'); }, 580);
    });
  }

  var drawn = false;
  function render() {
    var order = rank(state.obj);
    var p = plan(order, state.cap, state.pins);

    /* lanes */
    var cards = BDH.$$('.taa-fx__card', root);
    flip(cards, function () {
      Object.keys(LANES).forEach(function (key) {
        var list = root.querySelector('[data-taa-lanelist="' + key + '"]');
        if (!list) return;
        order.forEach(function (id) {
          if ((p.lane[id] || 'later') !== key) return;
          var card = cards.filter(function (c) { return c.getAttribute('data-id') === id; })[0];
          if (card) list.appendChild(card);
        });
      });
    });
    cards.forEach(function (c) { c.classList.toggle('is-pinned', state.pins.indexOf(c.getAttribute('data-id')) >= 0); });
    Object.keys(LANES).forEach(function (key) {
      var n = ids.filter(function (id) { return (p.lane[id] || 'later') === key; }).length;
      var el = root.querySelector('[data-taa-lanecount="' + key + '"]');
      if (el) el.textContent = String(n);
    });

    /* table */
    if (tbody) {
      BDH.$$('tr', tbody).forEach(function (tr) {
        var id = tr.getAttribute('data-id'), lane = p.lane[id] || 'later';
        tr.setAttribute('data-lane', lane);
        var cell = tr.querySelector('[data-taa-lanecell]');
        if (cell) cell.textContent = LANES[lane];
      });
    }

    /* readouts */
    setNum(root.querySelector('[data-taa-days]'), p.days);
    setNum(root.querySelector('[data-taa-count]'), p.order.length);
    setNum(root.querySelector('[data-taa-value]'), p.value, true);
    setNum(root.querySelector('[data-taa-residual]'), p.residual);
    if (capRef) capRef.textContent = String(state.cap);
    var bars = [
      ['[data-taa-daysbar]', Math.min(1, p.days / Math.max(1, state.cap))],
      ['[data-taa-countbar]', p.order.length / ids.length],
      ['[data-taa-valuebar]', p.value / TOTAL_V],
      ['[data-taa-residualbar]', p.residual / 100]
    ];
    bars.forEach(function (pair) {
      var el = root.querySelector(pair[0]);
      if (el) el.style.setProperty('--p', pair[1].toFixed(3));
    });
    if (!BDH.reduced) {
      root.classList.add('is-bump');
      window.setTimeout(function () { root.classList.remove('is-bump'); }, 360);
    }

    /* curve */
    var solid = path(p.order, 0, 0);
    var dash = path(p.rest, solid.days, solid.val);
    if (solidEl) solidEl.setAttribute('d', solid.d);
    if (dashEl) dashEl.setAttribute('d', dash.d);
    if (markEl) {
      var xx = PAD + (Math.min(state.cap, TOTAL_D) / TOTAL_D) * (VW - 2 * PAD);
      markEl.setAttribute('x1', xx.toFixed(1));
      markEl.setAttribute('x2', xx.toFixed(1));
    }
    if (!drawn && solidEl && solidEl.getTotalLength && !BDH.reduced) {
      drawn = true;
      root.style.setProperty('--len', Math.ceil(solidEl.getTotalLength()) + 'px');
      root.classList.add('is-draw');
      window.setTimeout(function () { root.classList.remove('is-draw'); }, 1300);
    }

    if (say) {
      say.textContent = 'Plan at ' + state.cap + ' days, ' + (OBJ_NAME[state.obj] || state.obj) + ': ' + p.order.length +
        ' findings selected, ' + p.days + ' days committed, ' + p.residual + '% of rated risk left unfixed.';
    }
  }

  /* ---------- controls ----------------------------------------------------- */
  function setCap(v) {
    state.cap = v;
    if (slider && parseInt(slider.value, 10) !== v) slider.value = String(v);
    if (capNum) capNum.textContent = String(v);
    render();
  }

  if (slider) slider.addEventListener('input', function () { setCap(parseInt(slider.value, 10) || 10); });

  objBtns.forEach(function (btn, n) {
    btn.addEventListener('click', function () { pick(n); });
    btn.addEventListener('keydown', function (ev) {
      var k = ev.key, at = n;
      if (k === 'ArrowRight' || k === 'ArrowDown') at = (n + 1) % objBtns.length;
      else if (k === 'ArrowLeft' || k === 'ArrowUp') at = (n - 1 + objBtns.length) % objBtns.length;
      else if (k === 'Home') at = 0;
      else if (k === 'End') at = objBtns.length - 1;
      else return;
      ev.preventDefault();
      pick(at);
      objBtns[at].focus();
    });
  });
  function pick(n) {
    objBtns.forEach(function (b, i) {
      b.setAttribute('aria-checked', i === n ? 'true' : 'false');
      b.setAttribute('tabindex', i === n ? '0' : '-1');
    });
    state.obj = objBtns[n].getAttribute('data-obj');
    render();
  }

  BDH.$$('[data-taa-pin]', root).forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id = btn.getAttribute('data-taa-pin');
      var at = state.pins.indexOf(id);
      if (at >= 0) state.pins.splice(at, 1); else state.pins.push(id);
      btn.setAttribute('aria-pressed', at >= 0 ? 'false' : 'true');
      render();
    });
  });

  /* ---------- sorting ------------------------------------------------------ */
  var laneRank = { now: 0, next: 1, later: 2 };
  BDH.$$('[data-sort]', root).forEach(function (btn) {
    btn.addEventListener('click', function () {
      var key = btn.getAttribute('data-sort');
      var th = btn.closest('th');
      var dir = th.getAttribute('aria-sort') === 'ascending' ? 'descending' : 'ascending';
      BDH.$$('th[aria-sort]', root).forEach(function (h) { h.setAttribute('aria-sort', 'none'); });
      th.setAttribute('aria-sort', dir);
      var list = BDH.$$('tr', tbody);
      list.sort(function (a, b) {
        var ia = a.getAttribute('data-id'), ib = b.getAttribute('data-id'), va, vb;
        if (key === 'id') { va = ia; vb = ib; }
        else if (key === 'lane') { va = laneRank[a.getAttribute('data-lane')]; vb = laneRank[b.getAttribute('data-lane')]; }
        else { va = rows[ia][key]; vb = rows[ib][key]; }
        if (va === vb) return ia < ib ? -1 : 1;
        var out = va < vb ? -1 : 1;
        return dir === 'ascending' ? out : -out;
      });
      list.forEach(function (tr) { tbody.appendChild(tr); });
    });
  });

  /* ---------- reveal and one autoplay pass --------------------------------- */
  var touched = false;
  BDH.onInteract(root, function () { touched = true; root.classList.remove('is-auto'); });

  BDH.inView(root, function () {
    render();
    if (BDH.reduced || touched || !slider) return;
    root.classList.add('is-auto');
    setCap(20);
    var to = 50, step = 5;
    var timer = window.setInterval(function () {
      if (touched || state.cap >= to) { window.clearInterval(timer); root.classList.remove('is-auto'); return; }
      setCap(Math.min(to, state.cap + step));
    }, 260);
  }, { threshold: 0.18 });
})();
