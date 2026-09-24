/* 25 — Offer: the brief builder.
   The HTML is a complete POST form without this file. This adds: the six discipline lists as an ARIA
   tablist (BDH.tabs), a pick count per discipline, the live summary bar, the chosen package's column,
   and a "Likely fit" mark read from the typical length of the ticked services.
   window.BDH loads after the bundled sections.js, so init waits for DOMContentLoaded. */
(function () {
  'use strict';

  function init() {
    var root = document.querySelector('[data-s25]');
    if (!root || !window.XE) return;
    var XE = window.XE, BDH = window.BDH;
    var form = XE.$('[data-s25-form]', root);
    var tablist = XE.$('[data-s25-tabs]', root);
    var tabs = XE.$$('[data-s25-tab]', root);
    var panes = XE.$$('[data-s25-pane]', root);
    var svcs = XE.$$('[data-s25-svc]', root);
    var pkgs = XE.$$('[data-s25-pkg]', root);
    var cmp = XE.$('[data-s25-cmp]', root);
    var fits = XE.$$('[data-s25-fit]', root);
    var fitNote = XE.$('[data-s25-fitnote]', root);
    var send = XE.$('[data-s25-send]', root);
    var countEl = XE.$('[data-s25-count]', root);
    var pkEl = XE.$('[data-s25-pkname]', root);
    var namesEl = XE.$('[data-s25-names]', root);
    var clearBtn = XE.$('[data-s25-clear]', root);
    var live = XE.$('[data-s25-live]', root);
    if (!form) return;
    root.classList.add('is-js');

    /* ---- tabs: only once JS is here; before that every list is shown in turn ---- */
    if (tablist && tabs.length && panes.length === tabs.length && BDH && BDH.tabs) {
      panes.forEach(function (p, i) {
        p.setAttribute('role', 'tabpanel');
        p.setAttribute('aria-labelledby', tabs[i].id);
        p.setAttribute('tabindex', '0');
      });
      tablist.hidden = false;
      BDH.tabs(tablist, { tabs: tabs, panes: panes, orientation: 'horizontal' });
    }

    function two(n) { return (n < 10 ? '0' : '') + n; }

    /* The package that most often fits: read from the services' typical lengths.
       Ongoing work → Retainer (or Squad for a team); three or more disciplines → Enterprise;
       short, small asks → Sprint; up to ~12 weeks → Project; anything longer → Milestone. */
    function weeks(t) {
      var hi = 0, m, re = /(\d+)(?:\s*[–-]\s*(\d+))?\s*weeks?/gi;
      while ((m = re.exec(t))) hi = Math.max(hi, parseInt(m[2] || m[1], 10));
      return hi;
    }
    function isRun(t) { return /ongoing|monthly|then|start in|cycles/i.test(t); }
    function suggest(picked) {
      if (!picked.length) return '';
      var ds = {}, nd = 0, hi = 0, run = false, team = false;
      picked.forEach(function (el) {
        var t = el.getAttribute('data-time') || '';
        if (!ds[el.getAttribute('data-d')]) { ds[el.getAttribute('data-d')] = 1; nd++; }
        if (isRun(t)) run = true; else hi = Math.max(hi, weeks(t));
        if (/squad|engineers-by-role/.test(el.value)) team = true;
      });
      if (team) return 'squad';
      if (nd >= 3) return 'enterprise';
      if (run) return 'retainer';
      if (hi && hi <= 3 && picked.length <= 2) return 'sprint';
      if (hi <= 12 && picked.length <= 3) return 'project';
      return 'milestone';
    }

    var lastMsg = '';
    function sync(announce) {
      var picked = svcs.filter(function (el) { return el.checked; });
      var pk = pkgs.filter(function (el) { return el.checked; })[0];
      var pkKey = pk ? pk.value : '';
      var pkName = pk && pk.value ? pk.getAttribute('data-name') : 'Not sure yet';

      /* per-discipline counts on the tabs */
      tabs.forEach(function (t) {
        var d = t.getAttribute('data-s25-tab');
        var n = picked.filter(function (el) { return el.getAttribute('data-d') === d; }).length;
        var b = XE.$('[data-s25-tabpick]', t);
        if (!b) return;
        b.hidden = !n;
        b.textContent = n ? String(n) : '';
        b.setAttribute('aria-label', n ? n + ' ticked' : '');
      });

      /* the chosen column */
      if (cmp) { if (pkKey) cmp.setAttribute('data-pkg', pkKey); else cmp.removeAttribute('data-pkg'); }

      /* likely fit */
      var fit = suggest(picked);
      fits.forEach(function (f) { f.hidden = f.closest('[data-col]').getAttribute('data-col') !== fit; });
      if (fitNote) fitNote.hidden = !fit;

      /* the bar */
      var nd = {};
      picked.forEach(function (el) { nd[el.getAttribute('data-d')] = 1; });
      var ndc = Object.keys(nd).length;
      countEl.textContent = picked.length
        ? two(picked.length) + (picked.length === 1 ? ' service' : ' services') + (ndc > 1 ? ' · ' + ndc + ' disciplines' : '')
        : 'Tick services above';
      pkEl.textContent = pkName;
      var names = picked.map(function (el) { return el.getAttribute('data-name'); });
      namesEl.hidden = !names.length;
      namesEl.textContent = names.length > 3 ? names.slice(0, 3).join(', ') + ' and ' + (names.length - 3) + ' more' : names.join(', ');
      clearBtn.hidden = !picked.length && !pkKey;

      if (announce) {
        var fitName = '';
        if (fit) { var fe = pkgs.filter(function (el) { return el.value === fit; })[0]; fitName = fe ? fe.getAttribute('data-name') : ''; }
        var msg = (picked.length ? picked.length + (picked.length === 1 ? ' service' : ' services') + ' in your brief' : 'No services in your brief')
          + '. Package: ' + pkName + '.' + (fitName && fit !== pkKey ? ' Likely fit: ' + fitName + '.' : '');
        if (msg !== lastMsg) { live.textContent = msg; lastMsg = msg; }
      }
    }

    function bump() {
      if (!send || (BDH && BDH.reduced) || XE.reduced) return;
      send.classList.remove('is-bump'); void send.offsetWidth; send.classList.add('is-bump');
    }

    svcs.forEach(function (el) { XE.on(el, 'change', function () { sync(true); bump(); }); });
    pkgs.forEach(function (el) { XE.on(el, 'change', function () { sync(true); }); });
    XE.on(clearBtn, 'click', function () {
      svcs.forEach(function (el) { el.checked = false; });
      pkgs.forEach(function (el) { el.checked = el.value === ''; });
      sync(true);
      var first = tabs.filter(function (t) { return t.getAttribute('aria-selected') === 'true'; })[0];
      if (first) first.focus();
    });
    /* back from the contact page: the browser may restore ticked boxes */
    window.addEventListener('pageshow', function () { sync(false); });
    sync(false);
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
