/* Industries · console — the Sector Console.
   Two controls: a roving-tabindex radiogroup of six sectors, and one ARIA tablist of starting points
   inside each sector pane. Everything it shows is already in the HTML; this script only switches which
   pane is on, keeps the live region in step, animates the brief sheet assembling, and autoplays the
   sectors until the reader takes over. Under reduced motion the controls still work — only the
   animation and the autoplay are dropped. With JavaScript off the section's <noscript> rule stacks
   every pane, so nothing here is needed to read it. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var app = BDH.$('.ind-con__app');
  if (!app) return;

  var radios = BDH.$$('.ind-con__sector', app);
  var panes  = BDH.$$('.ind-con__panes > .bdh-pane', app);
  var live   = BDH.$('.ind-con__live', app);
  var stxt   = BDH.$('.ind-con__stxt', app);
  if (!radios.length || radios.length !== panes.length) return;

  var cur = Math.max(0, radios.findIndex(function (r) { return r.getAttribute('aria-checked') === 'true'; }));
  var entries = [];          /* one BDH.tabs controller per sector pane */
  var autoplay = null;
  var statusId = null;

  /* ---- the brief sheet: replay the assemble animation for the visible sheet ---- */
  function writeSheet(pane) {
    if (BDH.reduced) return;
    var sheet = pane.querySelector('.bdh-pane.is-on [data-sheet]') || pane.querySelector('[data-sheet]');
    if (!sheet) return;
    sheet.classList.remove('is-writing');
    void sheet.offsetWidth;                       /* restart the CSS animation */
    sheet.classList.add('is-writing');
  }

  function status(text, revert) {
    if (!stxt) return;
    stxt.textContent = text;
    if (statusId) clearTimeout(statusId);
    if (revert) statusId = setTimeout(function () { stxt.textContent = revert; }, 900);
  }

  function announce(i) {
    if (!live) return;
    var pane = panes[i];
    var name = pane.querySelector('.ind-con__sh h3');
    var tab  = pane.querySelector('.ind-con__tabs [role="tab"][aria-selected="true"]');
    var t    = tab ? tab.querySelector('.ind-con__tt') : null;
    var w    = tab ? tab.querySelector('.ind-con__tw') : null;
    live.textContent = 'Brief: ' + (name ? name.textContent : '') +
      (t ? ' · ' + t.textContent : '') + (w ? ' · ' + w.textContent + ' typical.' : '');
  }

  function show(i, byUser) {
    i = ((i % radios.length) + radios.length) % radios.length;
    cur = i;
    radios.forEach(function (r, n) {
      var on = n === i;
      r.setAttribute('aria-checked', on ? 'true' : 'false');
      r.setAttribute('tabindex', on ? '0' : '-1');
    });
    panes.forEach(function (p, n) { p.classList.toggle('is-on', n === i); });
    if (byUser) status('Assembling…', 'Brief ready');
    writeSheet(panes[i]);
    announce(i);
  }

  radios.forEach(function (r, n) {
    r.addEventListener('click', function () { stopAuto(); show(n, true); });
    r.addEventListener('keydown', function (e) {
      var k = e.key, j = null;
      if (k === 'ArrowRight' || k === 'ArrowDown') j = n + 1;
      else if (k === 'ArrowLeft' || k === 'ArrowUp') j = n - 1;
      else if (k === 'Home') j = 0;
      else if (k === 'End') j = radios.length - 1;
      else if (k === ' ' || k === 'Enter') { e.preventDefault(); stopAuto(); show(n, true); return; }
      if (j === null) return;
      e.preventDefault();
      stopAuto();
      j = ((j % radios.length) + radios.length) % radios.length;
      radios[j].focus();
      show(j, true);
    });
  });

  /* ---- starting points: one ARIA tablist per sector pane ---- */
  panes.forEach(function (pane, n) {
    entries.push(BDH.tabs(pane, {
      tabs: '.ind-con__tabs [role="tab"]',
      panes: '.ind-con__epanes > .bdh-pane',
      onChange: function (i, prev, byUser) {
        if (!byUser) return;
        stopAuto();
        status('Assembling…', 'Brief ready');
        writeSheet(pane);
        if (n === cur) announce(n);
      }
    }));
  });

  function stopAuto() { if (autoplay) { autoplay.stop(); autoplay = null; } }

  /* ---- autoplay: walk the sectors until the reader touches anything ---- */
  if (!BDH.reduced) {
    autoplay = BDH.loop(app, 7000, function () { show(cur + 1, false); });
    BDH.onInteract(app, stopAuto);
  }

  writeSheet(panes[cur]);
})();
