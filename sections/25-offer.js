/* 25 — Offer: the brief builder.
   The HTML is a complete POST form without this file: each discipline is a native <details>, the
   comparison table is open, and every control is real. This adds:
   · ≥769px: the six <details> become one tablist (summaries hidden, the chosen one open, the tallest
     discipline's height reserved so switching never jumps). ≤768px: an exclusive accordion, closed.
   · the right set of package radios (table ≥769px, cards ≤768px); the other set is disabled so it
     neither submits nor takes focus, and the choice carries across when the width changes.
   · pick counts, the brief bar (sticky once something is picked), and a "Likely fit" read from the
     ticked services' typical lengths, offered as a button in the bar.
   window.BDH loads after the bundled sections.js, so init waits for DOMContentLoaded. */
(function () {
  'use strict';

  function init() {
    var root = document.querySelector('[data-s25]');
    if (!root || !window.XE) return;
    var XE = window.XE;
    var R = !!XE.reduced;
    var $ = function (s) { return XE.$(s, root); };
    var $$ = function (s) { return XE.$$(s, root); };
    var form = $('[data-s25-form]');
    if (!form) return;

    var tablist = $('[data-s25-tabs]');
    var tabs = $$('[data-s25-tab]');
    var discs = $$('[data-s25-disc]');
    var svcs = $$('[data-s25-svc]');
    var radios = $$('[data-s25-pkg]');
    var cmpd = $('[data-s25-cmpd]');
    var cmp = $('[data-s25-cmp]');
    var fits = $$('[data-s25-fit]');
    var fitNote = $('[data-s25-fitnote]');
    var send = $('[data-s25-send]');
    var countEl = $('[data-s25-count]');
    var pkEl = $('[data-s25-pkname]');
    var namesEl = $('[data-s25-names]');
    var fitBtn = $('[data-s25-fitbtn]');
    var fitName = $('[data-s25-fitname]');
    var clearBtn = $('[data-s25-clear]');
    var live = $('[data-s25-live]');
    var mq = window.matchMedia('(min-width: 769px)');
    var wide = null;
    var cur = Math.max(0, discs.findIndex(function (d) { return d.open; }));

    root.classList.add('is-js');

    /* ---------------- disciplines: tabs (wide) or accordion (narrow) ---------------- */
    function openOnly(i) {
      discs.forEach(function (d, n) { if (n !== i && d.open) d.open = false; });
      if (!discs[i].open) discs[i].open = true;
    }
    function selectTab(i, focus) {
      cur = i;
      tabs.forEach(function (t, n) {
        var on = n === i;
        t.setAttribute('aria-selected', on ? 'true' : 'false');
        t.setAttribute('tabindex', on ? '0' : '-1');
      });
      if (wide) openOnly(i);
      if (focus && tabs[i]) tabs[i].focus();
    }
    tabs.forEach(function (t, n) {
      XE.on(t, 'click', function () { selectTab(n, false); });
      XE.on(t, 'keydown', function (e) {
        var k = e.key, j = -1;
        if (k === 'ArrowRight' || k === 'ArrowDown') j = n + 1;
        else if (k === 'ArrowLeft' || k === 'ArrowUp') j = n - 1;
        else if (k === 'Home') j = 0;
        else if (k === 'End') j = tabs.length - 1;
        if (j === -1) return;
        e.preventDefault();
        selectTab((j + tabs.length) % tabs.length, true);
      });
    });
    /* in accordion mode, keep the tab selection in step with whichever discipline was opened */
    discs.forEach(function (d, n) {
      XE.on(d, 'toggle', function () { if (!wide && d.open) { cur = n; selectTab(n, false); } });
    });

    /* reserve the tallest discipline's height so tab switches never move the page */
    function reserve() {
      if (!wide) { root.style.removeProperty('--s25-h'); return; }
      var keep = cur, max = 0;
      root.style.setProperty('--s25-h', '0px');
      discs.forEach(function (d, n) {
        openOnly(n);
        max = Math.max(max, d.getBoundingClientRect().height);
      });
      openOnly(keep);
      root.style.setProperty('--s25-h', Math.ceil(max) + 'px');
    }

    function mode() {
      var w = mq.matches;
      if (w === wide) return;
      var first = wide === null;
      wide = w;
      root.classList.toggle('is-tabs', w);
      if (tablist) tablist.hidden = !w;
      discs.forEach(function (d, n) {
        var body = d.querySelector('.s25-disc__b');
        if (!body) return;
        if (w) {
          body.setAttribute('role', 'tabpanel');
          body.setAttribute('aria-labelledby', tabs[n].id);
          body.setAttribute('tabindex', '0');
        } else {
          body.removeAttribute('role'); body.removeAttribute('aria-labelledby'); body.removeAttribute('tabindex');
        }
      });
      if (w) selectTab(cur, false);
      else if (first) discs.forEach(function (d) { d.open = false; });   // phones start folded: six clear rows

      /* package radios: exactly one visible set is live */
      var chosen = radios.filter(function (r) { return r.checked; })[0];
      var val = chosen ? chosen.value : '';
      var set = w ? 'table' : 'cards';
      radios.forEach(function (r) {
        var s = r.getAttribute('data-s25-set');
        if (s) r.disabled = s !== set;
      });
      radios.forEach(function (r) {
        if (!r.disabled && r.value === val) r.checked = true;
      });
      if (cmpd) cmpd.open = w;   // phones: the full table folds under "Compare all six in detail"
      reserve();
      edge();
      sync(false);
    }

    /* ---------------- the table's right-edge fade: only while there is more to scroll ---------------- */
    function edge() {
      if (!cmp) return;
      cmp.classList.toggle('is-end', cmp.scrollLeft + cmp.clientWidth >= cmp.scrollWidth - 2);
    }
    XE.on(cmp, 'scroll', edge, { passive: true });

    /* ---------------- likely fit ----------------
       Squad when a team offer is ticked; Enterprise only for 4+ disciplines with a service over
       12 weeks; Retainer for ongoing work; then by size (longest and summed typical weeks), not by
       count: small → Sprint, up to 12 weeks → Project, longer → Milestone. */
    function weeks(t) {
      var hi = 0, m, re = /(\d+)(?:\s*[–-]\s*(\d+))?\s*weeks?/gi;
      while ((m = re.exec(t))) hi = Math.max(hi, parseInt(m[2] || m[1], 10));
      return hi;
    }
    function isRun(t) { return /ongoing|monthly|then|start in|cycles/i.test(t); }
    function suggest(picked) {
      if (!picked.length) return '';
      var ds = {}, nd = 0, hi = 0, sum = 0, run = false, team = false;
      picked.forEach(function (el) {
        var t = el.getAttribute('data-time') || '', d = el.getAttribute('data-d'), w = weeks(t);
        if (!ds[d]) { ds[d] = 1; nd++; }
        if (isRun(t)) run = true;
        hi = Math.max(hi, w); sum += w;
        if (/squad|engineers-by-role/.test(el.value)) team = true;
      });
      if (team) return 'squad';
      if (nd >= 4 && hi > 12) return 'enterprise';
      if (run) return 'retainer';
      if (hi <= 3 && sum <= 6) return 'sprint';
      if (hi <= 12) return 'project';
      return 'milestone';
    }

    function live1() { return radios.filter(function (r) { return !r.disabled; }); }
    function nameOf(key) {
      var r = radios.filter(function (x) { return x.value === key; })[0];
      return r ? r.getAttribute('data-name') : '';
    }

    var lastMsg = '', fitKey = '';
    function sync(announce) {
      var picked = svcs.filter(function (el) { return el.checked; });
      var pk = live1().filter(function (r) { return r.checked; })[0];
      var pkKey = pk ? pk.value : '';
      var pkName = pkKey ? pk.getAttribute('data-name') : 'Not sure yet';

      /* per-discipline counts, on tabs and summaries */
      $$('[data-s25-pick]').forEach(function (b) {
        var d = b.getAttribute('data-s25-pick');
        var n = picked.filter(function (el) { return el.getAttribute('data-d') === d; }).length;
        b.hidden = !n;
        b.querySelector('[data-s25-pickn]').textContent = n ? String(n) : '';
        b.querySelector('[data-s25-picksr]').textContent = n ? ', ' + n + ' ticked' : '';
      });

      if (cmp) { if (pkKey) cmp.setAttribute('data-pkg', pkKey); else cmp.removeAttribute('data-pkg'); }

      fitKey = suggest(picked);
      fits.forEach(function (f) { f.hidden = f.closest('[data-col]').getAttribute('data-col') !== fitKey; });
      if (fitNote) fitNote.hidden = !fitKey;
      fitBtn.hidden = !fitKey || fitKey === pkKey;
      fitName.textContent = fitKey ? nameOf(fitKey) : '';

      var nd = {};
      picked.forEach(function (el) { nd[el.getAttribute('data-d')] = 1; });
      var ndc = Object.keys(nd).length;
      countEl.textContent = picked.length
        ? (picked.length < 10 ? '0' : '') + picked.length + (picked.length === 1 ? ' service' : ' services') + (ndc > 1 ? ' · ' + ndc + ' disciplines' : '')
        : 'None ticked yet';
      pkEl.textContent = pkName;
      var names = picked.map(function (el) { return el.getAttribute('data-name'); });
      namesEl.hidden = !names.length;
      namesEl.textContent = names.length > 2 ? names.slice(0, 2).join(', ') + ' and ' + (names.length - 2) + ' more' : names.join(', ');
      clearBtn.hidden = !picked.length && !pkKey;
      root.classList.toggle('has-picks', !!(picked.length || pkKey));

      if (announce) {
        var msg = (picked.length ? picked.length + (picked.length === 1 ? ' service' : ' services') + ' in your brief' : 'No services in your brief')
          + '. Contract: ' + pkName + '.' + (fitKey && fitKey !== pkKey ? ' Likely fit: ' + nameOf(fitKey) + '.' : '');
        if (msg !== lastMsg) { live.textContent = msg; lastMsg = msg; }
      }
    }

    function bump() {
      if (!send || R) return;
      send.classList.remove('is-bump'); void send.offsetWidth; send.classList.add('is-bump');
    }

    svcs.forEach(function (el) { XE.on(el, 'change', function () { sync(true); bump(); }); });
    radios.forEach(function (el) { XE.on(el, 'change', function () { sync(true); }); });

    /* Bring el into view by the least movement: clear of the fixed nav above and the sticky bar
       below, and — for a table column — inside the table's own scroller, past the sticky row heads. */
    function reveal(el) {
      if (!el) return;
      var beh = R ? 'auto' : 'smooth';
      if (cmp && cmp.contains(el)) {
        var head = cmp.querySelector('.s25-tbl__h0');
        var cr = cmp.getBoundingClientRect(), er = el.getBoundingClientRect();
        var left = cr.left + (head ? head.offsetWidth : 0);
        var dx = er.left < left ? er.left - left : (er.right > cr.right ? er.right - cr.right : 0);
        if (dx) cmp.scrollBy({ left: dx, behavior: beh });
      }
      var r = el.getBoundingClientRect();
      var top = 96;                                                       // the floating nav
      var bottom = window.innerHeight - (send ? send.offsetHeight + 24 : 24);
      var dy = r.top < top ? r.top - top : (r.bottom > bottom ? Math.min(r.bottom - bottom, r.top - top) : 0);
      if (dy) window.scrollBy({ top: dy, behavior: beh });
    }

    /* "Likely fit" in the bar: choose it and reveal its column or card. Focus moves to Continue,
       since the button itself hides once its suggestion is chosen. */
    XE.on(fitBtn, 'click', function () {
      if (!fitKey) return;
      var r = live1().filter(function (x) { return x.value === fitKey; })[0];
      if (!r) return;
      r.checked = true;
      reveal(wide ? r.closest('th') : r.closest('.s25-card'));
      sync(true);
      edge();
      fitBtn.hidden = true;
      var go = form.querySelector('.s25-send__btn');
      if (go) go.focus({ preventScroll: true });
    });

    XE.on(clearBtn, 'click', function () {
      svcs.forEach(function (el) { el.checked = false; });
      radios.forEach(function (el) { el.checked = el.value === ''; });
      sync(true);
      var t = wide ? tabs[cur] : discs[cur] && discs[cur].querySelector('summary');
      if (t) t.focus({ preventScroll: true });
    });

    /* back from the contact page: the browser may restore ticked boxes */
    window.addEventListener('pageshow', function () { sync(false); });
    var rt = null;
    window.addEventListener('resize', function () {
      clearTimeout(rt);
      rt = setTimeout(function () { mode(); reserve(); edge(); }, 150);
    });
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { reserve(); edge(); });

    mode();
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
