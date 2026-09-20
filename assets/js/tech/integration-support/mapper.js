/* Integration & Support · mapper — SIGNATURE field mapper that works like the real tool.
   Select a source field then a target (or the other way round); Escape cancels. Each mapping has a
   transform select. On every change the flow is evaluated against the target schema: required
   fields, types, formats, enum, pattern and the order-lines cross-check that catches an amount sent
   in minor units (100× mismatch). Auto-map loads agent proposals with confidence scores to accept
   or reject. Send test event delivers to a sandbox with an idempotency key (201, then 200 replay).
   Autoplay builds the flow once, trips the currency trap and fixes it, then stops on the finished
   flow; the visitor can take over at any point.
   Reduced motion: no autoplay, no draw or shake animation; everything else works. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var ui = document.querySelector('.tis-mp'); if (!ui) return;
  var R = BDH.reduced;
  var $ = function (s) { return ui.querySelector(s); };

  var SRC = {
    s_id: ['id', 'string', 'ord_8F2K41'], s_created: ['created_at', 'date-time', '2026-09-14T21:47:03+05:30'],
    s_email: ['customer.email', 'string', 'asha.rao@example.com'], s_first: ['customer.first_name', 'string', 'Asha'],
    s_last: ['customer.last_name', 'string', 'Rao'], s_total: ['total_amount', 'integer', 249900],
    s_cur: ['currency', 'string', 'INR'], s_status: ['financial_status', 'string', 'paid'],
    s_sku: ['line_items[0].sku', 'string', 'MUG-340-BLU'], s_qty: ['line_items[0].quantity', 'integer', 2],
    s_price: ['line_items[0].price', 'integer', 124950], s_city: ['shipping_address.city', 'string', 'Pune']
  };
  /* [name, json type, required, ok message] */
  var TGT = {
    t_ref: ['external_ref', 'string', true, 'string'], t_date: ['order_date', 'string', true, 'date-time · UTC'],
    t_cust: ['customer_id', 'string', true, 'matches ^C-\\d{6}$'], t_name: ['customer_name', 'string', false, 'string · ≤ 80'],
    t_amount: ['amount', 'number', true, 'matches order lines · 2 × 1,249.50'], t_cur: ['currency_code', 'string', true, 'ISO 4217'],
    t_status: ['order_status', 'string', true, 'enum'], t_item: ['lines[].item_code', 'string', true, 'string'],
    t_qty: ['lines[].quantity', 'integer', true, 'integer ≥ 1'], t_city: ['ship_to.city', 'string', false, 'string']
  };
  var ORDER = Object.keys(TGT);
  var REQ = ORDER.filter(function (t) { return TGT[t][2]; }).length;
  var XF = { direct: ['Direct', ''], concat: ['Concat first + last name', 'concat'], lookup: ['Lookup customer ID', 'lookup'],
    minor: ['Minor units ÷ 100', '÷ 100'], iso: ['Date to ISO 8601 UTC', 'ISO 8601'], enum: ['Map status enum', 'enum'] };
  var FINAL = [['s_id', 't_ref', 'direct'], ['s_created', 't_date', 'iso'], ['s_email', 't_cust', 'lookup'], ['s_first', 't_name', 'concat'],
    ['s_total', 't_amount', 'minor'], ['s_cur', 't_cur', 'direct'], ['s_status', 't_status', 'enum'], ['s_sku', 't_item', 'direct'],
    ['s_qty', 't_qty', 'direct'], ['s_city', 't_city', 'direct']];
  /* what the mapping agent proposes: note total_amount → amount as Direct, the trap */
  var PROPOSE = [['s_id', 't_ref', 'direct', 0.97], ['s_created', 't_date', 'iso', 0.93], ['s_email', 't_cust', 'lookup', 0.84],
    ['s_first', 't_name', 'concat', 0.88], ['s_total', 't_amount', 'direct', 0.71], ['s_cur', 't_cur', 'direct', 0.99],
    ['s_status', 't_status', 'enum', 0.86], ['s_sku', 't_item', 'direct', 0.95], ['s_qty', 't_qty', 'direct', 0.96],
    ['s_city', 't_city', 'direct', 0.64]];
  var LINES_TOTAL = 2499;   // 2 × 1,249.50 INR, from line_items[0]

  var maps = {}, props = {}, sel = null, sent = 1, rev = 1, sig = '', prevErr = {}, timers = [];
  FINAL.forEach(function (m) { maps[m[1]] = { s: m[0], xf: m[2], who: 'you' }; });
  sig = signature();

  var srcBtns = {}, tgtBtns = {};
  BDH.$$('.tis-mp__f--src', ui).forEach(function (b) { srcBtns[b.getAttribute('data-f')] = b; });
  BDH.$$('.tis-mp__f--tgt', ui).forEach(function (b) { tgtBtns[b.getAttribute('data-f')] = b; });
  var rows = $('[data-mp-rows]'), json = $('[data-mp-json]'), checks = $('[data-mp-checks]');
  var hint = $('[data-mp-hint]'), stateEl = $('[data-mp-state]'), stateT = $('[data-mp-state-t]');
  var canvas = $('.tis-mp__canvas'), svg = $('.tis-mp__svg'), chips = $('.tis-mp__chips');
  var res = $('[data-mp-res]'), sendBtn = $('[data-mp-send]'), autoBtn = $('[data-mp-auto]');
  var agentBar = $('[data-mp-agent]');
  var NS = 'http://www.w3.org/2000/svg';

  function later(ms, fn) { timers.push(setTimeout(fn, R ? 0 : ms)); }
  function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
  function say(html) { if (hint) hint.innerHTML = html; }
  function path(s) { return SRC[s][0]; }
  function name(t) { return TGT[t][0]; }
  function signature() { return ORDER.map(function (t) { return maps[t] ? maps[t].s + ':' + maps[t].xf : '-'; }).join('|'); }

  /* ---------- evaluation ---------- */
  function apply(m) {
    var v = SRC[m.s][2];
    switch (m.xf) {
      case 'concat': return (m.s === 's_first' || m.s === 's_last') ? { v: 'Asha Rao' } : { err: 'concat · expects customer.first_name' };
      case 'lookup': return m.s === 's_email' ? { v: 'C-104233' } : { err: 'lookup · needs customer.email' };
      case 'minor': return typeof v === 'number' ? { v: v / 100 } : { err: 'minor units ÷ 100 · needs a number' };
      case 'iso':
        if (typeof v === 'string' && /^\d{4}-\d\d-\d\dT\d\d:\d\d:\d\d/.test(v)) return { v: new Date(v).toISOString().replace('.000Z', 'Z') };
        return { err: 'ISO 8601 · source is not a date-time' };
      case 'enum': return m.s === 's_status' ? { v: 'INVOICED' } : { err: 'enum map · no rule for “' + v + '”' };
      default: return { v: v };
    }
  }
  function typeOk(v, type) {
    if (type === 'string') return typeof v === 'string';
    if (type === 'number') return typeof v === 'number';
    return typeof v === 'number' && Math.floor(v) === v;
  }
  function evaluate() {
    var out = {}, errs = 0, warns = 0, req = 0, mapped = 0;
    ORDER.forEach(function (t) {
      var T = TGT[t], m = maps[t], r = { lvl: 'ok', msg: T[3], v: null, has: false };
      if (!m) {
        r = T[2] ? { lvl: 'err', msg: 'required · not mapped', miss: true } : { lvl: 'off', msg: 'optional · not mapped', miss: true };
      } else {
        mapped++; if (T[2]) req++;
        var a = apply(m);
        if (a.err) { r = { lvl: 'err', msg: a.err }; }
        else {
          var v = a.v; r.v = v; r.has = true;
          if (!typeOk(v, T[1])) { r.lvl = 'err'; r.msg = 'type · expected ' + T[1] + ', got ' + (typeof v === 'number' ? (Math.floor(v) === v ? 'integer' : 'number') : typeof v); }
          else if (t === 't_date') {
            if (!/^\d{4}-\d\d-\d\dT\d\d:\d\d:\d\d(\.\d+)?(Z|[+-]\d\d:\d\d)$/.test(v)) { r.lvl = 'err'; r.msg = 'format · not a date-time'; }
            else if (!/Z$/.test(v)) { r.lvl = 'err'; r.msg = 'format · ERP expects UTC (…Z), got ' + v.slice(-6) + ' offset'; }
          }
          else if (t === 't_cust' && !/^C-\d{6}$/.test(v)) { r.lvl = 'err'; r.msg = 'pattern · “' + v + '” does not match ^C-\\d{6}$'; }
          else if (t === 't_name') {
            if (v.length > 80) { r.lvl = 'err'; r.msg = 'maxLength · over 80 characters'; }
            else if (m.s === 's_first' && m.xf === 'direct') { r.lvl = 'warn'; r.msg = 'last name dropped · use Concat'; }
          }
          else if (t === 't_amount') {
            if (Math.abs(v / LINES_TOTAL - 100) < 0.01) { r.lvl = 'err'; r.msg = '100× mismatch · ' + v + ' vs order lines 2,499.00 INR. total_amount is in minor units (paise): apply ÷ 100'; }
            else if (Math.abs(v - LINES_TOTAL) > 0.005) { r.lvl = 'err'; r.msg = 'cross-check · ' + v + ' does not match order lines 2,499.00'; }
          }
          else if (t === 't_cur' && !/^[A-Z]{3}$/.test(v)) { r.lvl = 'err'; r.msg = 'ISO 4217 · expected three capital letters'; }
          else if (t === 't_status' && ['OPEN', 'INVOICED', 'CANCELLED'].indexOf(v) < 0) { r.lvl = 'err'; r.msg = 'enum · “' + v + '” is not OPEN, INVOICED or CANCELLED'; }
          else if (t === 't_qty' && v < 1) { r.lvl = 'err'; r.msg = 'minimum · quantity must be ≥ 1'; }
        }
      }
      if (r.lvl === 'err') errs++;
      if (r.lvl === 'warn') warns++;
      out[t] = r;
    });
    return { by: out, errs: errs, warns: warns, req: req, mapped: mapped };
  }

  /* ---------- rendering ---------- */
  function val(t, r) {
    if (!r.has) return '<span class="c">null</span>';
    if (typeof r.v === 'number') return '<span class="n">' + (t === 't_amount' && maps[t].xf === 'minor' ? r.v.toFixed(2) : r.v) + '</span>';
    return '<span class="s">"' + esc(r.v) + '"</span>';
  }
  function jsonLines(ev) {
    var k = function (s) { return '<span class="k">"' + s + '"</span>'; };
    var L = function (t, ind, key, comma) { return [ind + k(key) + ': ' + val(t, ev.by[t]) + (comma ? ',' : ''), t]; };
    return [
      ['{', ''], L('t_ref', '  ', 'external_ref', 1), L('t_date', '  ', 'order_date', 1), L('t_cust', '  ', 'customer_id', 1),
      L('t_name', '  ', 'customer_name', 1), L('t_amount', '  ', 'amount', 1), L('t_cur', '  ', 'currency_code', 1),
      L('t_status', '  ', 'order_status', 1), ['  ' + k('lines') + ': [ {', ''], L('t_item', '    ', 'item_code', 1),
      L('t_qty', '    ', 'quantity', 0), ['  } ],', ''],
      ['  ' + k('ship_to') + ': { ' + k('city') + ': ' + val('t_city', ev.by.t_city) + ' }', 't_city'], ['}', '']
    ];
  }

  function rowHtml(t, fresh, err) {
    var m = maps[t], p = props[t], lbl = esc(name(t));
    if (m) {
      var opts = Object.keys(XF).map(function (x) { return '<option value="' + x + '"' + (x === m.xf ? ' selected' : '') + '>' + XF[x][0] + '</option>'; }).join('');
      return '<li class="tis-mp__m' + (err ? ' is-err' : '') + (fresh && !R ? ' is-new' : '') + '" data-t="' + t + '">' +
        '<code class="tis-mp__ms">' + esc(path(m.s)) + '</code><span class="tis-mp__ar" aria-hidden="true">→</span>' +
        '<span class="tis-mp__sel"><label class="bdh-sr" for="mp-xf-' + t + '">Transform for ' + lbl + '</label><select id="mp-xf-' + t + '" data-mp-xf>' + opts + '</select></span>' +
        '<span class="tis-mp__ar tis-mp__ar2" aria-hidden="true">→</span><code class="tis-mp__mt">' + lbl + '</code>' +
        '<span class="tis-mp__who' + (m.who === 'agent' ? ' is-agent' : '') + '">' + (m.who === 'agent' ? 'agent · ' + m.conf.toFixed(2) : 'you') + '</span>' +
        '<button type="button" class="tis-mp__x" data-mp-remove aria-label="Remove mapping ' + esc(path(m.s)) + ' to ' + lbl + '">×</button></li>';
    }
    var c = p.conf.toFixed(2), what = esc(path(p.s)) + ' to ' + lbl + ', ' + XF[p.xf][0] + ', confidence ' + c;
    return '<li class="tis-mp__m is-prop' + (fresh && !R ? ' is-new' : '') + '" data-t="' + t + '">' +
      '<code class="tis-mp__ms">' + esc(path(p.s)) + '</code><span class="tis-mp__ar" aria-hidden="true">→</span>' +
      '<span class="tis-mp__xf">' + XF[p.xf][0] + '</span><span class="tis-mp__ar tis-mp__ar2" aria-hidden="true">→</span>' +
      '<code class="tis-mp__mt">' + lbl + '</code>' +
      '<span class="tis-mp__conf' + (p.conf < 0.8 ? ' is-low' : '') + '" style="--c:' + c + '"><i aria-hidden="true"></i>' + c + '</span>' +
      '<span class="tis-mp__pa"><button type="button" class="tis-mp__ok" data-mp-accept aria-label="Accept ' + what + '">Accept</button>' +
      '<button type="button" class="tis-mp__no" data-mp-reject aria-label="Reject ' + what + '">Reject</button></span></li>';
  }

  function render(o) {
    o = o || {};
    var ev = evaluate();
    var s2 = signature();
    if (s2 !== sig) { sig = s2; rev++; sent = 0; }

    /* fields */
    Object.keys(srcBtns).forEach(function (s) {
      var to = ORDER.filter(function (t) { return maps[t] && maps[t].s === s; }).map(name);
      var b = srcBtns[s];
      b.classList.toggle('is-mapped', to.length > 0);
      b.setAttribute('aria-pressed', String(!!sel && sel.side === 's' && sel.key === s));
      var tag = b.querySelector('[data-mp-to]'); if (tag) tag.textContent = to.length ? '→ ' + to.join(', ') : '';
    });
    ORDER.forEach(function (t) {
      var b = tgtBtns[t]; if (!b) return;
      b.classList.toggle('is-mapped', !!maps[t]);
      b.classList.toggle('is-err', !!maps[t] && ev.by[t].lvl === 'err');
      b.classList.toggle('is-prop', !maps[t] && !!props[t]);
      b.setAttribute('aria-pressed', String(!!sel && sel.side === 't' && sel.key === t));
    });
    ui.classList.toggle('is-picking', !!sel && sel.side === 's');
    ui.classList.toggle('is-picking-t', !!sel && sel.side === 't');

    /* rows, keeping focus */
    var ae = document.activeElement, keep = null;
    if (ae && rows.contains(ae)) {
      var li = ae.closest('li');
      keep = { t: li && li.getAttribute('data-t'), what: ae.hasAttribute('data-mp-xf') ? 'xf' : ae.hasAttribute('data-mp-remove') ? 'rm' : 'pa' };
    }
    var html = ORDER.filter(function (t) { return maps[t] || props[t]; }).map(function (t) { return rowHtml(t, t === o.fresh || (o.freshAll && props[t]), ev.by[t].lvl === 'err' && !!maps[t]); }).join('');
    rows.innerHTML = html || '<li class="tis-mp__empty">No mappings yet. Select a source field and then a target, or press Auto-map.</li>';
    if (keep) {
      var row = keep.t && rows.querySelector('li[data-t="' + keep.t + '"]'), f = null;
      if (row) f = row.querySelector(keep.what === 'rm' ? '[data-mp-remove]' : '[data-mp-xf]') || row.querySelector('button,select');
      if (!f) f = rows.querySelector('select,button') || autoBtn;
      if (f) f.focus();
    }
    var pn = Object.keys(props).length;
    $('[data-mp-count]').textContent = ev.mapped + ' of ' + ORDER.length + ' targets' + (pn ? ' · ' + pn + ' proposed' : '');
    if (agentBar) { agentBar.hidden = !pn; var pnEl = agentBar.querySelector('[data-mp-pn]'); if (pnEl) pnEl.textContent = pn; }

    /* preview */
    json.innerHTML = jsonLines(ev).map(function (l) {
      var r = l[1] ? ev.by[l[1]] : null, cls = r ? (r.lvl === 'err' ? 'is-err' : r.lvl === 'warn' ? 'is-warn' : '') + (r.miss ? ' is-miss' : '') : '';
      if (r && l[1] === o.flash && !R) cls += ' is-flash';
      return '<li' + (l[1] ? ' data-t="' + l[1] + '"' : '') + (cls.trim() ? ' class="' + cls.trim() + '"' : '') + '>' + l[0] + '</li>';
    }).join('');

    /* validation */
    checks.innerHTML = ORDER.map(function (t) {
      var r = ev.by[t];
      return '<li class="is-' + r.lvl + '" data-t="' + t + '"><i aria-hidden="true"></i><code>' + esc(name(t)) + '</code><span><span class="bdh-sr">' + (r.lvl === 'ok' ? 'passes: ' : r.lvl === 'err' ? 'error: ' : r.lvl === 'warn' ? 'warning: ' : '') + '</span>' + esc(r.msg) + '</span></li>';
    }).join('');
    $('[data-mp-vsum]').textContent = ev.req + ' / ' + REQ + ' required · ' + ev.errs + (ev.errs === 1 ? ' error' : ' errors') + (ev.warns ? ' · ' + ev.warns + ' warning' + (ev.warns > 1 ? 's' : '') : '');

    /* state chip */
    stateEl.classList.toggle('is-bad', ev.errs > 0 && ev.req === REQ);
    stateEl.classList.toggle('is-mid', ev.req < REQ);
    stateT.textContent = ev.req < REQ ? 'Incomplete · ' + ev.req + ' of ' + REQ + ' required' + (ev.errs - (REQ - ev.req) > 0 ? ' · ' + (ev.errs - (REQ - ev.req)) + ' errors' : '')
      : ev.errs ? ev.errs + (ev.errs === 1 ? ' error' : ' errors') + ' · fix before sending'
      : 'Valid · ' + ev.mapped + ' mapped · ' + ev.errs + ' errors';

    /* delivery */
    delivery(ev, o.sending);

    /* shake newly failing targets */
    var nowErr = {};
    ORDER.forEach(function (t) {
      if (ev.by[t].lvl !== 'err' || !maps[t]) return;
      nowErr[t] = 1;
      if (!prevErr[t] && !R && o.shake !== false) {
        [tgtBtns[t], checks.querySelector('li[data-t="' + t + '"]'), json.querySelector('li[data-t="' + t + '"]')].forEach(shake);
      }
    });
    prevErr = nowErr;
    draw(o.fresh, o.freshAll);
    return ev;
  }

  function shake(el) {
    if (!el) return;
    el.classList.remove('is-shake'); void el.offsetWidth; el.classList.add('is-shake');
    setTimeout(function () { el.classList.remove('is-shake'); }, 600);
  }

  function delivery(ev, sending) {
    var key = 'order.created:ord_8F2K41:r' + rev;
    $('[data-mp-key]').textContent = key;
    var code = $('[data-mp-code]'), ms = $('[data-mp-ms]'), body = $('[data-mp-body]'), note = $('[data-mp-note]');
    var firstErr = null;
    ORDER.some(function (t) { if (ev.by[t].lvl === 'err') { firstErr = t; return true; } return false; });
    if (sending) {
      res.setAttribute('data-code', 'sending'); code.textContent = 'Sending…'; ms.textContent = '';
      body.textContent = 'POST /v2/sales-orders · awaiting response'; note.textContent = 'Signed request with the idempotency key above.';
    } else if (firstErr) {
      res.setAttribute('data-code', 'blocked'); code.textContent = 'Not sent · ' + ev.errs + (ev.errs === 1 ? ' error' : ' errors'); ms.textContent = '';
      body.innerHTML = '{ <span class="k">"error"</span>: <span class="s">"schema"</span>, <span class="k">"pointer"</span>: <span class="s">"/' + esc(name(firstErr).replace('[]', '/0').replace(/\./g, '/')) + '"</span> }';
      note.textContent = 'Delivery is blocked until the flow validates. In production this event would wait in the dead-letter queue with the errors attached.';
    } else if (!sent) {
      res.setAttribute('data-code', 'ready'); code.textContent = 'Ready'; ms.textContent = '';
      body.textContent = 'Press Send test event to post this payload to the sandbox.';
      note.textContent = 'The sandbox receives the payload exactly as previewed.';
    } else if (sent === 1) {
      res.setAttribute('data-code', '201'); code.textContent = '201 Created'; ms.textContent = '184 ms';
      body.innerHTML = '{ <span class="k">"id"</span>: <span class="s">"SO-2026-004187"</span>, <span class="k">"status"</span>: <span class="s">"INVOICED"</span> }';
      note.textContent = 'Created once. Sending the same event again replays this result instead of creating a second order.';
    } else {
      res.setAttribute('data-code', '200'); code.textContent = '200 OK · replayed'; ms.textContent = '41 ms';
      body.innerHTML = '{ <span class="k">"id"</span>: <span class="s">"SO-2026-004187"</span>, <span class="k">"idempotent_replay"</span>: <span class="n">true</span> }';
      note.textContent = 'Same idempotency key, so the ERP returned the original order. Retries are safe; no duplicate was created.';
    }
  }

  /* ---------- connection lines ---------- */
  var paths = {};
  function draw(fresh, freshAll) {
    if (!canvas || !canvas.offsetWidth) { if (svg) svg.textContent = ''; if (chips) chips.textContent = ''; paths = {}; return; }
    var cr = canvas.getBoundingClientRect(), W = cr.width, H = cr.height, ev = evaluate();
    svg.setAttribute('viewBox', '0 0 ' + W.toFixed(1) + ' ' + H.toFixed(1));
    chips.textContent = '';
    var seen = {};
    ORDER.forEach(function (t) {
      var m = maps[t] || props[t]; if (!m) return;
      var isProp = !maps[t], sb = srcBtns[m.s].getBoundingClientRect(), tb = tgtBtns[t].getBoundingClientRect();
      var x1 = sb.right - cr.left + 6, x2 = tb.left - cr.left - 6, y1 = sb.top + sb.height / 2 - cr.top, y2 = tb.top + tb.height / 2 - cr.top;
      var dx = (x2 - x1) * 0.55, d = 'M' + x1.toFixed(1) + ' ' + y1.toFixed(1) + ' C' + (x1 + dx).toFixed(1) + ' ' + y1.toFixed(1) + ' ' + (x2 - dx).toFixed(1) + ' ' + y2.toFixed(1) + ' ' + x2.toFixed(1) + ' ' + y2.toFixed(1);
      var key = t + (isProp ? ':p' : ':m'), p = paths[key];
      var lvl = isProp ? 'prop' : ev.by[t].lvl;
      if (!p) {
        p = document.createElementNS(NS, 'path'); svg.appendChild(p); paths[key] = p;
        if (!R && !isProp && (fresh === t || freshAll)) {
          p.setAttribute('pathLength', '1'); p.classList.add('is-new');
          p.addEventListener('animationend', function h() { p.removeAttribute('pathLength'); p.classList.remove('is-new'); p.removeEventListener('animationend', h); });
        }
      }
      p.setAttribute('d', d);
      p.classList.toggle('is-err', lvl === 'err');
      p.classList.toggle('is-warn', lvl === 'warn');
      p.classList.toggle('is-prop', isProp);
      seen[key] = 1;
      var txt = isProp ? 'agent ' + m.conf.toFixed(2) : lvl === 'err' ? '! ' + (XF[m.xf][1] || 'direct') : XF[m.xf][1];
      if (txt) {
        var c = document.createElement('span');
        c.className = 'tis-mp__chip' + (isProp ? ' is-prop' : lvl === 'err' ? ' is-err' : '');
        c.style.top = ((y1 + y2) / 2).toFixed(1) + 'px';
        c.textContent = txt;
        chips.appendChild(c);
      }
    });
    Object.keys(paths).forEach(function (k) { if (!seen[k]) { paths[k].remove(); delete paths[k]; } });
  }

  /* ---------- actions ---------- */
  function select(side, key) {
    if (sel && sel.side === side && sel.key === key) { sel = null; say('Selection cleared.'); render(); return; }
    if (sel && sel.side !== side) { if (side === 't') connect(sel.key, key); else connect(key, sel.key); return; }
    sel = { side: side, key: key };
    if (side === 's') say('Selected <b>' + esc(path(key)) + '</b> (' + SRC[key][1] + ' · ' + esc(SRC[key][2]) + '). Now choose the target field it feeds.');
    else say('Selected target <b>' + esc(name(key)) + '</b>. Now choose the source field that feeds it.');
    render();
  }
  function connect(s, t) {
    maps[t] = { s: s, xf: maps[t] && maps[t].s === s ? maps[t].xf : 'direct', who: 'you' };
    delete props[t]; sel = null;
    var ev = render({ fresh: t, flash: t });
    var r = ev.by[t];
    say('Connected <b>' + esc(path(s)) + ' → ' + esc(name(t)) + '</b> · ' + XF[maps[t].xf][0] + '. ' + (r.lvl === 'err' ? 'Validation: ' + esc(r.msg) + '.' : r.lvl === 'warn' ? 'Warning: ' + esc(r.msg) + '.' : 'Valid.'));
  }
  function setXf(t, x) {
    if (!maps[t]) return;
    maps[t].xf = x;
    var sl = rows.querySelector('#mp-xf-' + t); if (sl) sl.value = x;
    var ev = render({ flash: t }), r = ev.by[t];
    say('Transform for <b>' + esc(name(t)) + '</b> set to ' + XF[x][0] + '. ' + (r.lvl === 'err' ? 'Validation: ' + esc(r.msg) + '.' : r.lvl === 'warn' ? 'Warning: ' + esc(r.msg) + '.' : 'Valid.'));
  }
  function autoMap() {
    var n = 0;
    PROPOSE.forEach(function (p) { if (!maps[p[1]]) { props[p[1]] = { s: p[0], xf: p[2], conf: p[3] }; n++; } });
    render({ freshAll: true, shake: false });
    say(n ? 'Mapping agent proposed <b>' + n + '</b> mappings with confidence scores. Review each one: accept, reject, or accept all.' : 'Every target is already mapped. Clear a mapping to get a proposal for it.');
  }
  function accept(t) {
    var p = props[t]; if (!p) return;
    maps[t] = { s: p.s, xf: p.xf, who: 'agent', conf: p.conf }; delete props[t];
    var ev = render({ fresh: t, flash: t }), r = ev.by[t];
    say('Accepted <b>' + esc(path(p.s)) + ' → ' + esc(name(t)) + '</b> (' + XF[p.xf][0] + ', ' + p.conf.toFixed(2) + '). ' + (r.lvl === 'err' ? 'Validation: ' + esc(r.msg) + '.' : 'Valid.'));
  }
  function acceptAll() {
    var ks = Object.keys(props); if (!ks.length) return;
    ks.forEach(function (t) { var p = props[t]; maps[t] = { s: p.s, xf: p.xf, who: 'agent', conf: p.conf }; });
    props = {};
    var ev = render({ freshAll: true });
    say('Accepted ' + ks.length + ' proposals. ' + (ev.errs ? '<b>' + ev.errs + (ev.errs === 1 ? ' error' : ' errors') + '</b> found: the agent drafts, the schema checks, you decide.' : 'The flow validates.'));
  }
  function clearAll() {
    maps = {}; props = {}; sel = null;
    render({ shake: false });
    say('Mappings cleared. Select a source field, or press Auto-map.');
  }
  function send() {
    var ev = evaluate();
    if (ev.errs) { render(); shake(res); say('Not sent: fix <b>' + ev.errs + (ev.errs === 1 ? ' error' : ' errors') + '</b> first. Nothing reaches the ERP until the payload validates.'); return; }
    sendBtn.setAttribute('aria-busy', 'true');
    render({ sending: true });
    later(650, function () {
      sendBtn.removeAttribute('aria-busy');
      sent = sent + 1;
      render();
      say(sent === 1 ? 'Delivered: <b>201 Created</b>. The ERP created sales order SO-2026-004187.' : 'Sent again: <b>200 OK</b>, replayed from the idempotency key. No duplicate order.');
    });
  }

  /* ---------- wiring ---------- */
  Object.keys(srcBtns).forEach(function (s) { srcBtns[s].addEventListener('click', function () { select('s', s); }); });
  Object.keys(tgtBtns).forEach(function (t) { tgtBtns[t].addEventListener('click', function () { select('t', t); }); });
  rows.addEventListener('change', function (e) {
    if (!e.target.hasAttribute('data-mp-xf')) return;
    setXf(e.target.closest('li').getAttribute('data-t'), e.target.value);
  });
  rows.addEventListener('click', function (e) {
    var b = e.target.closest('button'); if (!b) return;
    var t = b.closest('li').getAttribute('data-t');
    if (b.hasAttribute('data-mp-remove')) { var m = maps[t]; delete maps[t]; render({ shake: false }); say('Removed <b>' + esc(path(m.s)) + ' → ' + esc(name(t)) + '</b>.'); }
    else if (b.hasAttribute('data-mp-accept')) accept(t);
    else if (b.hasAttribute('data-mp-reject')) { var p = props[t]; delete props[t]; render({ shake: false }); say('Rejected the proposal for <b>' + esc(name(t)) + '</b> (' + esc(path(p.s)) + ').'); }
  });
  autoBtn.addEventListener('click', autoMap);
  $('[data-mp-clear]').addEventListener('click', clearAll);
  $('[data-mp-acceptall]').addEventListener('click', acceptAll);
  sendBtn.addEventListener('click', send);
  ui.addEventListener('keydown', function (e) { if (e.key === 'Escape' && sel) { sel = null; render({ shake: false }); say('Selection cleared.'); } });

  var rq = null;
  function redraw() { if (rq) return; rq = requestAnimationFrame(function () { rq = null; draw(); }); }
  if ('ResizeObserver' in window) new ResizeObserver(redraw).observe(ui);
  window.addEventListener('resize', redraw);
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(redraw);

  render({ shake: false });
  if (R) return;

  /* ---------- autoplay: one pass, then it rests on the finished flow ----------
     The shipped HTML is the complete, valid mapping. The demo waits long enough for that to be
     read, builds the flow once, and stops — it never returns the mapper to an empty state, and it
     does not restart when the section is scrolled back into view. */
  function press(b) { if (!b) return; b.classList.add('is-press'); setTimeout(function () { b.classList.remove('is-press'); }, 260); }
  var steps = [
    [2800, function () { timers.forEach(clearTimeout); timers = []; sendBtn.removeAttribute('aria-busy'); clearAll(); say('Autoplay: building the flow once. Touch the mapper to take over.'); }],
    [900, function () { select('s', 's_id'); }],
    [800, function () { select('t', 't_ref'); }],
    [1000, function () { select('s', 's_created'); }],
    [800, function () { select('t', 't_date'); }],
    [1900, function () { setXf('t_date', 'iso'); }],
    [1500, function () { press(autoBtn); autoMap(); }],
    [2200, function () { acceptAll(); }],
    [2600, function () { setXf('t_amount', 'minor'); }],
    [1600, function () { press(sendBtn); send(); }],
    [1200, function () {}]
  ];
  BDH.inView(ui, function () {
    BDH.seq(ui, steps, { loop: false, stopOnInteract: true, interactRoot: ui, onStop: function () { say('You have control. Select a source field, change a transform, or press Send test event.'); } });
  }, { threshold: 0.3 });
})();
