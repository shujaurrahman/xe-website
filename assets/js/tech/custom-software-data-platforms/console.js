/* Custom Software & Data Platforms · console — pins each note to its region of the app mock and frames the
   pressed note's region with an inspector box. While on screen it tours all six decisions: the region filter
   re-sorts the list by SLA (FLIP), J/X select three cases, the status saves optimistically, the checker
   approves, the audit chain verifies, SSO pulses. Any press on a note ends the tour and restores the finished
   state. The pressed note is tied to its region by a leader line: it drops from the window's bottom edge, under
   the framed region, to the top of the note, and draws in (stroke-dashoffset) each time the note changes.
   The count reads "N of M visible to your role": row-level security already limits the table (1,982 of 6,410
   rows), then the tour applies the status and priority filters (214 of those 1,982).
   Reduced motion: no tour; notes still frame their regions and draw their leaders at once. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tcs-console'); if (!root) return;
  var con = root.querySelector('.tcs-con');
  var stage = root.querySelector('.tcs-con__stage');
  var app = root.querySelector('.tcs-app');
  if (!con || !stage || !app) return;
  var R = BDH.reduced;
  var notes = BDH.$$('[data-note]', root);
  var pins = BDH.$$('.tcs-con__pin', root);
  var fill = root.querySelector('.tcs-con__fill');
  var cors = BDH.$$('.tcs-con__cor', root);
  var rowsBox = app.querySelector('.tcs-app__rows');
  var bulk = app.querySelector('.tcs-app__bulk');
  var selN = app.querySelector('[data-con-sel]');
  var countEl = app.querySelector('[data-con-count]');
  var statusEl = app.querySelector('[data-con-status]');
  var saveEl = app.querySelector('[data-con-save]');
  var appr = app.querySelector('.tcs-app__appr');
  var okBtn = app.querySelector('.tcs-app__ok');
  var chain = app.querySelector('.tcs-app__chain');
  var chainT = app.querySelector('[data-con-chain]');
  var sso = app.querySelector('.tcs-app__sso');
  var audit = BDH.$$('.tcs-app__aul li', app);
  var actAppr = app.querySelector('[data-con-act-appr]');
  var pageEl = app.querySelector('[data-con-page]');
  var totalEl = app.querySelector('[data-con-total]');
  var filters = BDH.$$('[data-con-filter]', app);
  var lead = con.querySelector('[data-con-lead]'), tick = con.querySelector('[data-con-tick]');
  var cur = 0;

  function rect(n) {
    var el = app.querySelector('[data-region="' + n + '"]');
    if (!el || !el.offsetParent) return null;
    var r = el.getBoundingClientRect(), s = stage.getBoundingClientRect();
    return { x: r.left - s.left, y: r.top - s.top, w: r.width, h: r.height, l: el.getAttribute('data-pin-at') === 'l' };
  }
  function place() {
    pins.forEach(function (p) {
      var b = rect(p.getAttribute('data-pin'));
      p.style.visibility = b ? '' : 'hidden';
      if (b) p.style.transform = 'translate(' + Math.round(b.l ? b.x - 34 : b.x + b.w - 14) + 'px,' + Math.round(b.l ? b.y + b.h / 2 - 12 : b.y - 12) + 'px)';
    });
    frame(cur);
    con.classList.add('is-pinned');
  }
  /* leader: window bottom edge under the region → down half the gap → across → down into the note */
  function leader(i, b) {
    if (!lead || !notes[i] || !b || getComputedStyle(lead.parentNode).display === 'none') { con.classList.remove('is-lead'); return; }
    var c = con.getBoundingClientRect(), a = app.getBoundingClientRect(), s = stage.getBoundingClientRect(), nr = notes[i].getBoundingClientRect();
    var ax0 = a.left - c.left, ax1 = a.right - c.left;
    var x0 = Math.max(ax0 + 24, Math.min(ax1 - 24, (s.left - c.left) + b.x + b.w / 2));
    var y0 = a.bottom - c.top;
    var nx = Math.max(nr.left - c.left + 28, Math.min(nr.right - c.left - 28, x0));
    var ny = nr.top - c.top;
    if (ny <= y0 + 8) { con.classList.remove('is-lead'); return; }
    var ym = Math.round(y0 + (ny - y0) / 2);
    var d = 'M' + x0.toFixed(1) + ' ' + y0.toFixed(1) + ' V' + ym;
    if (Math.abs(nx - x0) > 1) d += ' H' + nx.toFixed(1);
    d += ' V' + ny.toFixed(1);
    lead.setAttribute('d', d);
    tick.setAttribute('cx', x0.toFixed(1)); tick.setAttribute('cy', y0.toFixed(1));
    if (lead.getAttribute('data-for') !== String(i)) {   // a new note: draw the line in again
      lead.setAttribute('data-for', String(i));
      con.classList.remove('is-lead'); void lead.getBoundingClientRect();
    }
    con.classList.add('is-lead');
  }
  function frame(i) {
    var n = notes[i] ? notes[i].getAttribute('data-note') : null;
    var b = n ? rect(n) : null;
    leader(i, b);
    if (!b) { con.classList.remove('is-focus'); return; }
    var pad = 6, x = b.x - pad, y = b.y - pad, w = b.w + pad * 2, h = b.h + pad * 2;
    fill.style.transform = 'translate(' + x + 'px,' + y + 'px) scale(' + (w / 100) + ',' + (h / 100) + ')';
    var pos = [[x, y], [x + w - 14, y], [x, y + h - 14], [x + w - 14, y + h - 14]];
    cors.forEach(function (c, k) { c.style.transform = 'translate(' + pos[k][0] + 'px,' + pos[k][1] + 'px)'; });
    con.classList.add('is-focus');
  }
  function focus(i) {
    cur = i;
    notes.forEach(function (b, k) { b.setAttribute('aria-pressed', k === i ? 'true' : 'false'); });
    pins.forEach(function (p, k) { p.classList.toggle('is-on', k === i); });
    frame(i);
  }

  /* ---- state painters ---- */
  function rows() { return BDH.$$('.tcs-app__row', rowsBox); }
  function sort(bySla, animate) {
    var rs = rows(), first = {};
    rs.forEach(function (r) { first[r.getAttribute('data-id')] = r.getBoundingClientRect().top; });
    rs.sort(function (a, b) { return bySla ? a.getAttribute('data-sla') - b.getAttribute('data-sla') : a.getAttribute('data-o') - b.getAttribute('data-o'); })
      .forEach(function (r) { rowsBox.appendChild(r); });
    if (!animate || R) return;
    rs.forEach(function (r) {
      var d = first[r.getAttribute('data-id')] - r.getBoundingClientRect().top;
      if (!d) return;
      r.style.transition = 'none';
      r.style.transform = 'translateY(' + d + 'px)';
      r.getBoundingClientRect();
      r.style.transition = 'transform .65s cubic-bezier(.22,1,.36,1), background .32s';
      r.style.transform = '';
    });
  }
  function select(n, curIdx) {
    var sorted = rows();
    sorted.forEach(function (r, k) {
      r.classList.toggle('is-sel', k < n);
      r.classList.toggle('is-cur', k === curIdx);
    });
    if (selN) selN.textContent = String(n);
    if (bulk) bulk.classList.toggle('is-on', n > 0);
  }
  /* open → (saving) pending → approved: the status, the approval block and the activity timeline always agree */
  function status(s) {
    if (!statusEl || !saveEl) return;
    statusEl.textContent = s === 'open' ? 'Open' : (s === 'approved' ? 'Approved' : 'Pending');
    saveEl.textContent = s === 'saving' ? 'Saving…' : 'Saved';
    saveEl.classList.toggle('is-saving', s === 'saving');
  }
  function approval(done) {
    if (appr) appr.classList.toggle('is-done', done);
    if (actAppr) actAppr.classList.toggle('is-off', !done);
  }
  function page(sorted) { if (pageEl) pageEl.textContent = sorted ? '1–7 of 214 · sorted by SLA left' : '1–7 of 1,982 · newest first'; }
  /* row-level security is always on; the status and priority filters apply in the tour's first step */
  function filtered(on) {
    filters.forEach(function (f) { f.classList.toggle('is-off', !on); });
    if (countEl) countEl.textContent = on ? '214' : '1,982';
    if (totalEl) totalEl.textContent = on ? '1,982' : '6,410';
  }
  function logTo(k) {   // k = how many entries are written (1..3); newest is index 0
    audit.forEach(function (li, i) { li.classList.toggle('is-off', i < audit.length - k); });
  }
  function flash(li) { if (!li) return; li.classList.add('is-new'); setTimeout(function () { li.classList.remove('is-new'); }, 1400); }

  function finished() {
    sort(true, false); select(3, 1); status('approved'); approval(true); logTo(3); page(true); filtered(true);
    if (chainT) chainT.textContent = 'Chain verified · 3 of 3';
    if (chain) chain.classList.remove('is-run');
  }
  function start() {
    sort(false, false); select(0, -1); status('open'); approval(false); logTo(1); page(false); filtered(false);
    if (chainT) chainT.textContent = 'Chain verified · 1 of 1';
  }

  /* ---- wiring ---- */
  notes.forEach(function (b, k) { b.addEventListener('click', function () { focus(k); }); });
  var q = false;
  function later() { if (q) return; q = true; requestAnimationFrame(function () { q = false; place(); }); }
  if ('ResizeObserver' in window) new ResizeObserver(later).observe(stage); else window.addEventListener('resize', later);
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(later);
  BDH.inView(con, function () { place(); focus(0); }, { threshold: 0.05 });
  if (R) return;

  var tourRoot = root.querySelector('.tcs-con__notes');
  var steps = [
    [900,  function () { start(); focus(0); }],
    [1100, function () { filtered(true); sort(true, true); page(true); setTimeout(later, 700); }],
    [2300, function () { focus(1); select(0, 0); }],
    [650,  function () { select(1, 0); }],
    [550,  function () { select(1, 1); }],
    [450,  function () { select(2, 1); }],
    [550,  function () { select(3, 2); }],
    [500,  function () { select(3, 1); }],
    [1900, function () { focus(2); status('saving'); }],
    [900,  function () { status('pending'); logTo(2); flash(audit[1]); }],
    [2200, function () { focus(3); if (okBtn) okBtn.classList.add('is-press'); }],
    [350,  function () { if (okBtn) okBtn.classList.remove('is-press'); approval(true); status('approved'); logTo(3); flash(audit[0]); }],
    [2200, function () { focus(4); if (chain) chain.classList.add('is-run'); if (chainT) chainT.textContent = 'Verifying chain…'; }],
    [260,  function () { audit[2].classList.add('is-scan'); }],
    [260,  function () { audit[2].classList.remove('is-scan'); audit[1].classList.add('is-scan'); }],
    [260,  function () { audit[1].classList.remove('is-scan'); audit[0].classList.add('is-scan'); }],
    [300,  function () { audit[0].classList.remove('is-scan'); if (chain) chain.classList.remove('is-run'); if (chainT) chainT.textContent = 'Chain verified · 3 of 3'; }],
    [2000, function () { focus(5); if (sso) sso.classList.add('is-pulse'); }],
    [2600, function () { if (sso) sso.classList.remove('is-pulse'); }],
    [600,  function () {}]
  ];
  BDH.inView(con, function () {
    BDH.seq(con, steps, {
      loop: true, stopOnInteract: true, interactRoot: tourRoot,
      onStop: function () { audit.forEach(function (li) { li.classList.remove('is-scan', 'is-new'); }); if (sso) sso.classList.remove('is-pulse'); finished(); later(); }
    });
  }, { threshold: 0.25 });
})();
