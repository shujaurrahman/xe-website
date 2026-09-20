/* Hub · stack — the wall is a single-select listbox, one role="group" per layer (roving tabindex; arrows,
   Home, End, type-ahead by first letter). Layer filters hide the other layers and the remaining marks reflow
   with a FLIP animation (transform only). Selecting a mark fills the rail beside the wall from the option's
   data attributes. The wall starts clamped to about a screen behind "Show all …" — added here, so the shipped
   HTML holds the whole library. A featured tour walks the rail until the reader interacts.
   Reduced motion: filters, the clamp and selection still work, without the reflow, tour or ping. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tih-stk');
  if (!root) return;

  var cats = BDH.$$('.tih-stk__cat', root);
  var grid = BDH.$('.tih-stk__grid', root);
  var lays = BDH.$$('.tih-stk__lay', root);
  var cells = BDH.$$('.tih-stk__cell', root);
  var countEl = BDH.$('.tih-stk__count b', root);
  var lblEl = BDH.$('.tih-stk__count [data-lbl]', root);
  var prEl = BDH.$('.tih-stk__pr', root);
  var d = {
    mark: BDH.$('[data-d="mark"]', root), name: BDH.$('[data-d="name"]', root), cat: BDH.$('[data-d="cat"]', root),
    use: BDH.$('[data-d="use"]', root), none: BDH.$('[data-d="none"]', root), pos: BDH.$('[data-pos]', root), of: BDH.$('[data-of]', root)
  };
  var capLinks = BDH.$$('[data-d="caps"] .tih-capl', root);
  if (!grid || !cells.length) return;

  /* per-layer principle lines: the "all" line is printed in the markup; the rest ride on the filter buttons */
  var PRINCIPLES = {};
  var ALL_TEXT = prEl ? prEl.textContent : '';
  cats.forEach(function (b) { PRINCIPLES[b.getAttribute('data-cat')] = b.getAttribute('data-pr') || ''; });

  var cur = cells.findIndex(function (c) { return c.getAttribute('aria-selected') === 'true'; });
  if (cur < 0) cur = 0;
  var total = cells.length;
  var ease = 'cubic-bezier(.22,1,.36,1)';

  function visible() { return cells.filter(function (c) { return !c.hidden; }); }

  /* ---- selection → detail ---- */
  function select(i, focus) {
    var c = cells[i];
    if (!c || c.hidden) return;
    cells.forEach(function (x, n) {
      var on = n === i;
      x.setAttribute('aria-selected', on ? 'true' : 'false');
      x.tabIndex = on ? 0 : -1;
    });
    cur = i;
    if (focus) c.focus({ preventScroll: true });
    var svg = c.querySelector('.tih-stk__mark > *');
    if (d.mark && svg) {
      var big = svg.cloneNode(true);
      if (big.tagName && big.tagName.toLowerCase() === 'svg') { big.setAttribute('width', '34'); big.setAttribute('height', '34'); }
      d.mark.innerHTML = ''; d.mark.appendChild(big);
    }
    if (d.name) d.name.textContent = c.getAttribute('data-name') || '';
    if (d.cat) d.cat.textContent = c.getAttribute('data-catl') || '';
    var u = c.querySelector('.tih-stk__u');
    if (d.use) d.use.textContent = u ? u.textContent : '';
    var caps = (c.getAttribute('data-caps') || '').split(',').filter(Boolean);
    capLinks.forEach(function (a) { a.hidden = caps.indexOf(a.getAttribute('data-cap')) === -1; });
    if (d.none) d.none.hidden = caps.length > 0;
    var vis = visible();
    if (d.pos) d.pos.textContent = String(vis.indexOf(c) + 1);
    if (d.of) d.of.textContent = String(vis.length);
  }

  cells.forEach(function (c, i) {
    c.addEventListener('click', function () { select(i, true); });
  });

  /* keyboard: arrows move through the visible options, Up/Down by visual row */
  grid.addEventListener('keydown', function (e) {
    var vis = visible(), k = e.key, at = vis.indexOf(cells[cur]);
    if (at < 0) at = 0;
    var j = -1;
    if (k === 'ArrowRight') j = Math.min(vis.length - 1, at + 1);
    else if (k === 'ArrowLeft') j = Math.max(0, at - 1);
    else if (k === 'Home') j = 0;
    else if (k === 'End') j = vis.length - 1;
    else if (k === 'ArrowDown' || k === 'ArrowUp') {
      var r = vis[at].getBoundingClientRect(), best = -1, bestD = Infinity;
      vis.forEach(function (c, n) {
        var q = c.getBoundingClientRect();
        var dy = q.top - r.top;
        if ((k === 'ArrowDown' && dy <= 2) || (k === 'ArrowUp' && dy >= -2)) return;
        var dist = Math.abs(dy) * 4 + Math.abs(q.left - r.left);
        if (dist < bestD) { bestD = dist; best = n; }
      });
      j = best;
    } else if (k.length === 1 && /\S/.test(k)) {
      var ch = k.toLowerCase();
      for (var n = 1; n <= vis.length; n++) {
        var c2 = vis[(at + n) % vis.length];
        if ((c2.getAttribute('data-name') || '').toLowerCase().charAt(0) === ch) { j = (at + n) % vis.length; break; }
      }
    }
    if (j < 0) return;
    e.preventDefault();
    select(cells.indexOf(vis[j]), true);
  });

  /* ---- count tick ---- */
  function tickTo(n) {
    if (!countEl) return;
    var from = parseInt(countEl.textContent, 10) || 0;
    if (BDH.reduced || from === n) { countEl.textContent = String(n); return; }
    countEl.classList.add('is-tick');
    var t0 = null;
    requestAnimationFrame(function step(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / 450), k = 1 - Math.pow(1 - p, 3);
      countEl.textContent = String(Math.round(from + (n - from) * k));
      if (p < 1) requestAnimationFrame(step); else countEl.classList.remove('is-tick');
    });
  }

  /* ---- filter with FLIP ---- */
  function filter(cat, byUser) {
    var first = {};
    if (!BDH.reduced) cells.forEach(function (c) { if (!c.hidden) first[c.getAttribute('data-tech')] = c.getBoundingClientRect(); });
    root.setAttribute('data-cat', cat);
    root.classList.toggle('is-cat', cat !== 'all');
    cats.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-cat') === cat ? 'true' : 'false'); });
    cells.forEach(function (c) { c.hidden = cat !== 'all' && c.getAttribute('data-cat') !== cat; });
    lays.forEach(function (l) { l.hidden = cat !== 'all' && l.getAttribute('data-cat') !== cat; });
    var vis = visible();
    tickTo(vis.length);
    var btn = cats.filter(function (b) { return b.getAttribute('data-cat') === cat; })[0];
    if (lblEl) lblEl.textContent = cat === 'all' ? 'technologies · ' + (cats.length - 1) + ' layers' : 'in ' + (btn ? btn.childNodes[0].textContent.trim() : cat);
    if (prEl) prEl.textContent = cat === 'all' ? ALL_TEXT : (PRINCIPLES[cat] || ALL_TEXT);
    if (cells[cur].hidden) select(cells.indexOf(vis[0]), byUser); else select(cur, false);
    if (BDH.reduced) return;
    vis.forEach(function (c, n) {
      if (!c.animate) return;
      var l = c.getBoundingClientRect(), f = first[c.getAttribute('data-tech')];
      if (!f) {
        c.animate([{ opacity: 0, transform: 'scale(.9)' }, { opacity: 1, transform: 'none' }], { duration: 380, delay: Math.min(n, 24) * 14, easing: ease, fill: 'backwards' });
        return;
      }
      var dx = f.left - l.left, dy = f.top - l.top, sx = l.width ? f.width / l.width : 1, sy = l.height ? f.height / l.height : 1;
      if (Math.abs(dx) < .5 && Math.abs(dy) < .5 && Math.abs(sx - 1) < .01 && Math.abs(sy - 1) < .01) return;
      c.animate([
        { transform: 'translate(' + dx.toFixed(1) + 'px,' + dy.toFixed(1) + 'px) scale(' + sx.toFixed(3) + ',' + sy.toFixed(3) + ')', transformOrigin: '0 0' },
        { transform: 'none', transformOrigin: '0 0' }
      ], { duration: 560, easing: ease });
    });
  }
  cats.forEach(function (b) {
    b.addEventListener('click', function () { filter(b.getAttribute('data-cat'), true); });
  });

  /* ---- the wall starts clamped to about a screen, behind "Show all" ---- */
  var more = BDH.$('.tih-stk__more', root);
  function clamped() { return root.classList.contains('is-clamp') && !root.classList.contains('is-cat'); }
  function expand() {
    if (!root.classList.contains('is-clamp')) return;
    root.classList.remove('is-clamp');
    if (more) more.setAttribute('aria-expanded', 'true');
  }
  if (more) {
    root.classList.add('is-clamp');
    more.addEventListener('click', function () {
      expand();
      var c = cells[cur];
      if (c && !c.hidden) c.focus({ preventScroll: true });
    });
    /* keyboard users moving past the fold open the wall too */
    grid.addEventListener('focusin', function (e) {
      if (!clamped()) return;
      var r = e.target.getBoundingClientRect(), g = grid.getBoundingClientRect();
      if (r.bottom > g.bottom - 4) expand();
    });
  }

  /* ---- featured tour until the reader takes over: only marks the reader can actually see ---- */
  if (BDH.reduced) return;
  var FEATURED = ['kubernetes', 'postgresql', 'anthropic', 'opentelemetry', 'apachekafka', 'nextdotjs', 'terraform', 'qdrant', 'okta', 'snowflake', 'langgraph', 'cloudflare'];
  function reachable(c) {
    if (!c || c.hidden) return false;
    if (!clamped()) return true;
    var g = grid.getBoundingClientRect(), r = c.getBoundingClientRect();
    return r.bottom <= g.bottom - 2;
  }
  var steps = [], k = 0;
  FEATURED.forEach(function () {
    steps.push([3400, function () {
      for (var n = 1; n <= FEATURED.length; n++) {
        var j = (k + n) % FEATURED.length;
        var i = cells.findIndex(function (c) { return c.getAttribute('data-tech') === FEATURED[j]; });
        if (i > -1 && reachable(cells[i])) {
          k = j;
          select(i, false);
          var c2 = cells[i];
          c2.classList.remove('is-tour'); void c2.offsetWidth; c2.classList.add('is-tour');
          return;
        }
      }
    }]);
  });
  BDH.seq(root, steps, { loop: true, stopOnInteract: true });
  BDH.onInteract(root, function () { cells.forEach(function (c) { c.classList.remove('is-tour'); }); });
})();
