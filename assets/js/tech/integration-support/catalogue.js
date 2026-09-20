/* Integration & Support · catalogue — live search + category filter over the connector tiles, and the
   connector sheet for the selected system. Visible tiles reflow with a FLIP transition (transform only),
   newly shown tiles fade in, the count is announced through aria-live, and the sheet swaps its content
   from the JSON the partial embeds. The wire packet runs only while the sheet is on screen (.is-live).
   Reduced motion: no transitions or packets; filtering and the sheet work the same. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var ui = document.querySelector('.tis-ca'); if (!ui) return;
  var R = BDH.reduced;
  var input = ui.querySelector('[data-ca-q]'), clear = ui.querySelector('[data-ca-clear]');
  var count = ui.querySelector('[data-ca-count]'), empty = ui.querySelector('[data-ca-empty]'), term = ui.querySelector('[data-ca-term]');
  var cats = BDH.$$('[data-ca-cat]', ui).filter(function (b) { return b.tagName === 'BUTTON'; });
  var items = BDH.$$('.tis-ca__item', ui), total = items.length;
  var tiles = BDH.$$('[data-ca-open]', ui);
  var sheet = ui.querySelector('[data-ca-sheet]');
  var dataEl = ui.querySelector('[data-ca-data]'), marksEl = ui.querySelector('[data-ca-marks]');
  var DATA = [];
  try { DATA = JSON.parse(dataEl ? dataEl.textContent : '[]'); } catch (e) { DATA = []; }
  var cat = 'all', q = '', timer = null, swapTimer = null;

  function norm(s) { return String(s || '').toLowerCase().replace(/\s+/g, ' ').trim(); }
  function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }

  /* ---------- filtering ---------- */
  function apply() {
    var first = {};
    if (!R) items.forEach(function (c) { if (!c.classList.contains('is-hide')) first[c.getAttribute('data-ca-k')] = c.getBoundingClientRect(); });
    var n = 0;
    items.forEach(function (c) {
      var show = (cat === 'all' || c.getAttribute('data-ca-cat') === cat) && (!q || c.getAttribute('data-ca-q').indexOf(q) > -1);
      c.classList.toggle('is-hide', !show);
      if (show) n++;
    });
    count.innerHTML = '<b>' + n + '</b> of ' + total + ' connectors' + (q ? ' for “' + esc(q) + '”' : '');
    if (empty) { empty.hidden = n > 0; if (term) term.textContent = '“' + q + '”'; }
    if (clear) clear.hidden = !q;
    if (R) return;
    items.forEach(function (c) {
      if (c.classList.contains('is-hide')) { c.classList.remove('is-new'); return; }
      var k = c.getAttribute('data-ca-k'), f = first[k], t = c.querySelector('.tis-ca__tile');
      if (!f) { c.classList.remove('is-new'); void c.offsetWidth; c.classList.add('is-new'); return; }
      var l = c.getBoundingClientRect(), dx = f.left - l.left, dy = f.top - l.top;
      if (Math.abs(dx) < 1 && Math.abs(dy) < 1) return;
      t.style.transition = 'none';
      t.style.transform = 'translate(' + dx.toFixed(1) + 'px,' + dy.toFixed(1) + 'px)';
      requestAnimationFrame(function () { t.style.transition = ''; t.style.transform = ''; });
    });
  }

  /* ---------- the sheet ---------- */
  function chips(el, arr) {
    if (!el) return;
    el.textContent = '';
    (arr || []).forEach(function (s) { var li = document.createElement('li'); li.textContent = s; el.appendChild(li); });
  }
  function open(k, byUser) {
    var d = DATA[k]; if (!d || !sheet) return;
    tiles.forEach(function (t) { t.setAttribute('aria-pressed', String(t.getAttribute('data-ca-open') === String(k))); });
    var mark = marksEl && marksEl.content ? marksEl.content.querySelector('[data-k="' + k + '"]') : null;
    var big = sheet.querySelector('[data-ca-mark]');
    if (big && mark) big.innerHTML = mark.innerHTML;
    var set = function (sel, v) { var el = sheet.querySelector(sel); if (el) el.textContent = v; };
    set('[data-ca-c]', d.c + ' · connector sheet');
    set('[data-ca-name]', d.n); set('[data-ca-name2]', d.n);
    set('[data-ca-trig]', d.t); set('[data-ca-trig2]', d.t);
    set('[data-ca-dir]', d.dl); set('[data-ca-fresh]', d.f); set('[data-ca-watch]', d.w);
    chips(sheet.querySelector('[data-ca-objs]'), d.o);
    chips(sheet.querySelector('[data-ca-how]'), d.h);
    var wire = sheet.querySelector('[data-ca-dirc]');
    if (wire) { wire.setAttribute('data-ca-dirc', d.d); wireWidth(); }
    if (!R) {
      sheet.classList.remove('is-swap'); void sheet.offsetWidth; sheet.classList.add('is-swap');
      clearTimeout(swapTimer); swapTimer = setTimeout(function () { sheet.classList.remove('is-swap'); }, 450);
    }
    if (byUser && window.innerWidth < 1024) {
      var r = sheet.getBoundingClientRect();
      if (r.top > window.innerHeight * 0.85 || r.bottom < 0) sheet.scrollIntoView({ behavior: R ? 'auto' : 'smooth', block: 'start' });
    }
  }
  function wireWidth() {
    var w = sheet && sheet.querySelector('.tis-ca__wire i');
    if (w) w.style.setProperty('--w', w.offsetWidth + 'px');
  }

  /* ---------- wiring ---------- */
  cats.forEach(function (b) {
    b.addEventListener('click', function () {
      cat = b.getAttribute('data-ca-cat');
      cats.forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
      apply();
    });
  });
  if (input) {
    input.addEventListener('input', function () {
      clearTimeout(timer);
      timer = setTimeout(function () { q = norm(input.value); apply(); }, 120);
    });
    input.addEventListener('keydown', function (e) { if (e.key === 'Escape' && input.value) { input.value = ''; q = ''; apply(); } });
  }
  if (clear) clear.addEventListener('click', function () { input.value = ''; q = ''; apply(); input.focus(); });
  tiles.forEach(function (t) { t.addEventListener('click', function () { open(parseInt(t.getAttribute('data-ca-open'), 10), true); }); });
  items.forEach(function (c) { c.addEventListener('animationend', function () { c.classList.remove('is-new'); }); });

  wireWidth();
  window.addEventListener('resize', wireWidth);
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(wireWidth);
  if (sheet && !R) BDH.live(sheet, 0.3);
})();
