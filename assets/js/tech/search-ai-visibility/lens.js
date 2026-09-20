/* Search & AI Visibility · lens — the Share-of-Answer panel.
   The table already carries every cell's state, so this script only adds behaviour:
   · "Sample the panel" blanks the grid and refills it column by column behind a scan line
   · clicking or pressing Enter on a cell renders the drawer for that prompt and engine
   · "Show after fixes" re-reads every cell from data-s2 and re-runs the share bars — and is
     fully reversible: the shipped before-state lives in data-s1 and is never written to. Only
     data-now, which the CSS keys off, is ever rewritten.
   · on entry it samples once and opens one cell, and stops the moment anyone touches it
   Under reduced motion nothing loops: the grid is already complete and the drawer still works. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-tsv-lens]');
  if (!root) return;

  var $  = BDH.$, $$ = BDH.$$;
  var cells   = $$('.tsv-cell', root);
  var rows    = $$('tbody tr[data-row]', root);
  var scroll  = $('.tsv-lens__scroll', root);
  var drawer  = $('[data-lens-drawer]', root);
  var sampleB = $('[data-lens-sample]', root);
  var afterB  = $('[data-lens-after]', root);
  var shares  = $$('.tsv-share__row', root);
  var closeB  = $('[data-drawer-close]', root);
  if (!cells.length || !drawer) return;

  var STATE = {
    cited:   ['Cited', 'named with a link'],
    mention: ['Mentioned', 'named without a link'],
    absent:  ['Absent', 'not named at all']
  };
  var after = false, selected = null, auto = true, scanning = false;

  /* the only markup this script writes is the source list, built from our own data attributes;
     escaped anyway so the drawer can never be a hole */
  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, function (ch) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch];
    });
  }
  /* data-s1 is the shipped before-state and data-s2 the after-fixes state; neither is ever
     written to. data-now is the presentation attribute the CSS reads, so the switch is reversible. */
  function stateOf(cell) { return cell.getAttribute(after ? 'data-s2' : 'data-s1'); }
  function nowOf(cell)   { return cell.getAttribute('data-now'); }

  /* ---------- paint ---------- */
  function paint(cell) {
    var s = stateOf(cell);
    cell.setAttribute('data-now', s);
    var t = $('.tsv-cell__t', cell);
    if (t) t.textContent = STATE[s] ? STATE[s][0] : s;
    var row = cell.closest('tr');
    cell.setAttribute('aria-label', cell.getAttribute('data-en') + ' · ' + (STATE[s] ? STATE[s][0] : s) + ' · ' + (row ? row.getAttribute('data-q') : ''));
  }

  function repaintAll() { cells.forEach(paint); }

  /* ---------- share bars ---------- */
  function shareOut() {
    shares.forEach(function (row) {
      var v = parseInt(row.getAttribute(after ? 'data-after' : 'data-before'), 10) || 0;
      var bar = $('.tsv-share__bar i', row), num = $('[data-share-v]', row);
      if (bar) bar.style.setProperty('--p', (v / 100).toFixed(3));
      if (num) num.textContent = v;
    });
  }

  /* ---------- drawer ---------- */
  function open(cell, byUser) {
    var row = cell.closest('tr');
    if (!row) return;
    var s     = nowOf(cell);
    var srcs  = (row.getAttribute('data-src') || '').split('|').filter(Boolean);
    var you   = srcs.indexOf('yourcompany.com');
    var eng   = cell.getAttribute('data-en');
    var engd  = cell.getAttribute('data-ed');

    cells.forEach(function (c) { c.classList.toggle('is-sel', c === cell); });
    selected = cell;

    var k = $('[data-drawer-eng]', drawer);
    if (k) k.textContent = eng + ' · ' + engd;
    var q = $('[data-drawer-q]', drawer);
    if (q) q.textContent = row.getAttribute('data-q');
    var a = $('[data-drawer-a]', drawer);
    if (a) a.textContent = row.getAttribute('data-a');

    /* sources: when cited, the placeholder company replaces the weakest third-party source */
    var list = $('[data-drawer-src]', drawer);
    if (list) {
      var shown = srcs.slice(0, 3);
      if (s === 'cited' && you < 0) { shown[shown.length - 1] = 'yourcompany.com'; }
      if (s !== 'cited' && you >= 0) { shown[you] = 'forum-c.example'; }
      list.innerHTML = shown.map(function (h, i) {
        var mine = h === 'yourcompany.com';
        return '<li><span class="tsv-src' + (mine ? ' is-you' : '') + '">'
             + '<i class="tsv-src__n" aria-hidden="true">' + (i + 1) + '</i>'
             + '<i class="tsv-src__f" aria-hidden="true"></i>'
             + '<span class="tsv-src__h">' + esc(h) + '</span></span></li>';
      }).join('');
    }

    var vt = $('.tsv-drawer__vt', drawer);
    if (vt) {
      if (s === 'cited') {
        vt.textContent = 'Your company is cited with a link, so the answer sends the reader to your page. Hold it: re-sample weekly and watch for the page being replaced by a fresher source.';
      } else if (s === 'mention') {
        vt.textContent = 'Your company is named but not linked. ' + row.getAttribute('data-why');
      } else {
        vt.textContent = 'Your company does not appear in this answer. ' + row.getAttribute('data-why');
      }
    }
    var ft = $('[data-drawer-fix]', drawer);
    if (ft) ft.textContent = row.getAttribute('data-fix');

    if (closeB) closeB.hidden = false;

    if (!BDH.reduced) {
      drawer.classList.remove('is-new');
      void drawer.offsetWidth;
      drawer.classList.add('is-new');
    }
    if (byUser && window.matchMedia('(max-width:1180px)').matches) {
      drawer.scrollIntoView({ block: 'nearest', behavior: BDH.reduced ? 'auto' : 'smooth' });
    }
  }

  function close() {
    cells.forEach(function (c) { c.classList.remove('is-sel'); });
    selected = null;
    if (closeB) closeB.hidden = true;
    var k = $('[data-drawer-eng]', drawer); if (k) k.textContent = 'The panel';
    var q = $('[data-drawer-q]', drawer);   if (q) q.textContent = 'Pick any cell to read the answer behind it';
    var a = $('[data-drawer-a]', drawer);
    if (a) a.textContent = 'Each cell holds one engine’s answer to one prompt. The drawer shows that answer, the sources it cited, whether your company appears in it, and the single change most likely to move the cell.';
    var list = $('[data-drawer-src]', drawer);
    if (list) list.innerHTML = '<li class="tsv-drawer__empty">Sources appear here once a cell is open.</li>';
    var vt = $('.tsv-drawer__vt', drawer);  if (vt) vt.textContent = 'Sample the panel, then open a cell.';
    var ft = $('[data-drawer-fix]', drawer); if (ft) ft.textContent = 'Every cell in this panel has one. The order we do them in is the audit.';
  }

  /* ---------- scan sample ---------- */
  function sample(done) {
    if (scanning) return;
    if (BDH.reduced) { repaintAll(); shareOut(); if (done) done(); return; }
    scanning = true;
    if (sampleB) sampleB.setAttribute('aria-disabled', 'true');
    cells.forEach(function (c) { c.classList.add('is-blank'); });

    var line = $('.tsv-scan', scroll);
    if (!line && scroll) {
      line = document.createElement('span');
      line.className = 'tsv-scan';
      line.setAttribute('aria-hidden', 'true');
      scroll.style.position = 'relative';
      scroll.appendChild(line);
    }

    var cols = 4, i = 0;
    function step() {
      if (line && scroll) {
        var head = scroll.querySelectorAll('thead th')[i + 1];
        if (head) {
          line.style.left = (head.offsetLeft + head.offsetWidth / 2) + 'px';
          line.classList.add('is-on');
        }
      }
      cells.forEach(function (c) {
        if (parseInt(c.getAttribute('data-e'), 10) === i) { paint(c); c.classList.remove('is-blank'); }
      });
      i++;
      if (i < cols) { setTimeout(step, 240); }
      else {
        setTimeout(function () {
          if (line) line.classList.remove('is-on');
          scanning = false;
          if (sampleB) sampleB.removeAttribute('aria-disabled');
          shareOut();
          if (done) done();
        }, 320);
      }
    }
    setTimeout(step, 120);
  }

  /* ---------- wiring ---------- */
  cells.forEach(function (c) {
    c.addEventListener('click', function () { auto = false; open(c, true); });
  });
  if (closeB) closeB.addEventListener('click', function () { auto = false; close(); });
  if (sampleB) sampleB.addEventListener('click', function () { auto = false; sample(); });
  if (afterB) {
    afterB.addEventListener('click', function () {
      auto = false;
      after = !after;
      afterB.setAttribute('aria-pressed', after ? 'true' : 'false');
      sample(function () { if (selected) open(selected, false); });
    });
  }

  BDH.onInteract(root, function () { auto = false; });
  shareOut();

  BDH.inView(root, function () {
    if (!auto || BDH.reduced) return;
    setTimeout(function () {
      if (!auto) return;
      sample(function () {
        if (!auto) return;
        var pick = cells.filter(function (c) { return nowOf(c) === 'absent' && c.getAttribute('data-e') === '2'; })[0] || cells[0];
        if (pick) open(pick, false);
      });
    }, 500);
  }, { threshold: 0.18 });
})();
