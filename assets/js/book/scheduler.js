/* ==========================================================================
   Book · scheduler — mounts Cal.com's official element embed for the owner's real scheduling link.
   Cal.com's embed script is the ONLY third-party code this page loads.

   The contract with the shipped HTML:
     • The section ships showing a plain, working link to the scheduler. This file only ever
       replaces a working link with a working embed, never with an empty box.
     • .is-embed is added BEFORE Cal is asked to mount, so the container is laid out and measurable.
     • The wait is BOUNDED by WAIT ms, and the CSS bar is given exactly that duration so it cannot
       outlive it. When the wait runs out the fallback comes back with a line explaining why.
     • A late linkReady still rescues the page: 'ok' wins over 'blocked', never the other way round.

   Failure is detected three ways, because a blocked embed can fail at any of them:
     1. the injected <script> errors      (proxy / blocker / offline)
     2. Cal reports action:'linkFailed'   (the event type or link is wrong)
     3. nothing happens within WAIT ms    (silently dropped request, very slow network)
   ========================================================================== */
(function () {
  'use strict';

  var root = document.querySelector('[data-bk-sch]');
  if (!root) return;

  var CAL_LINK   = root.getAttribute('data-bk-cal') || '';
  var CAL_ORIGIN = root.getAttribute('data-bk-origin') || 'https://cal.com';
  var EMBED_JS   = 'https://app.cal.com/embed/embed.js';
  var NS         = 'xebook';
  var WAIT       = 9000;

  var mount = root.querySelector('[data-bk-mount]');
  var wait  = root.querySelector('[data-bk-wait]');
  var warn  = root.querySelector('[data-bk-warn]');
  var live  = root.querySelector('[data-bk-live]');
  var tzEl  = root.closest('section') ? root.closest('section').querySelector('[data-bk-tz]') : null;

  if (!mount || !mount.id || !CAL_LINK) return;   /* nothing to mount into: leave the link alone */

  var state = '';
  var timer = null;

  function say(msg) { if (live) live.textContent = msg; }

  /* 'ok' is final. 'blocked' is provisional, so an embed that arrives late still wins. */
  function settle(ok) {
    var next = ok ? 'ok' : 'blocked';
    if (state === 'ok' || state === next) return;
    state = next;
    if (timer) { clearTimeout(timer); timer = null; }
    if (wait) wait.hidden = true;

    if (ok) {
      root.classList.remove('is-blocked');
      root.classList.add('is-embed', 'is-ready');
      if (warn) warn.hidden = true;
      say('The calendar has loaded. Choose a date, then a time.');
    } else {
      root.classList.remove('is-embed', 'is-ready');
      root.classList.add('is-blocked');
      if (warn) warn.hidden = false;
      say('The embedded calendar could not load. A direct link to the scheduler is shown instead.');
    }
  }

  /* 1. a script that never arrives. Capture phase: script errors do not bubble. */
  window.addEventListener('error', function (ev) {
    var t = ev.target;
    if (t && t.tagName === 'SCRIPT' && /(^|\/\/|\.)cal\.com\//.test(String(t.src || ''))) settle(false);
  }, true);

  /* Show the embedding state first, so Cal measures a laid-out container, and pin the wait bar's
     duration to this script's timeout. */
  root.classList.add('is-embed');
  if (wait) wait.hidden = false;
  root.style.setProperty('--bk-wait', (WAIT / 1000) + 's');
  timer = setTimeout(function () { settle(false); }, WAIT);

  /* ---- Cal.com's official embed stub -------------------------------------------------------
     Behaviourally the published snippet: it defines window.Cal as a queue, injects embed.js once,
     and embed.js drains the queue when it loads. One deviation, marked: the script element is
     created first so an error listener can be attached to it before the request starts. */
  (function (C, A, L) {
    var p = function (a, ar) { a.q.push(ar); };
    var d = C.document;
    C.Cal = C.Cal || function () {
      var cal = C.Cal, ar = arguments;
      if (!cal.loaded) {
        cal.ns = {};
        cal.q = cal.q || [];
        var s = d.createElement('script');
        s.addEventListener('error', function () { settle(false); });   /* deviation from the snippet */
        s.src = A;
        d.head.appendChild(s);
        cal.loaded = true;
      }
      if (ar[0] === L) {
        var api = function () { p(api, arguments); };
        var namespace = ar[1];
        api.q = api.q || [];
        if (typeof namespace === 'string') {
          cal.ns[namespace] = cal.ns[namespace] || api;
          p(cal.ns[namespace], ar);
          p(cal, ['initNamespace', namespace]);
        } else {
          p(cal, ar);
        }
        return;
      }
      p(cal, ar);
    };
  })(window, EMBED_JS, 'init');

  try {
    window.Cal('init', NS, { origin: CAL_ORIGIN });
    var cal = window.Cal.ns[NS];

    cal('inline', {
      elementOrSelector: '#' + mount.id,
      calLink: CAL_LINK,
      config: { layout: 'month_view' }
    });

    /* The site is light-only (<meta name="color-scheme" content="light">), and the brand colour is
       read straight off the :root token so the embed can never drift from core.css. */
    var ui = { layout: 'month_view', theme: 'light', hideEventTypeDetails: false };
    var brand = getComputedStyle(document.documentElement).getPropertyValue('--blue').trim();
    if (/^#(?:[0-9a-f]{3}|[0-9a-f]{6})$/i.test(brand)) ui.cssVarsPerTheme = { light: { 'cal-brand': brand } };
    cal('ui', ui);

    cal('on', { action: 'linkReady', callback: function () { settle(true); } });
    cal('on', { action: 'linkFailed', callback: function () { settle(false); } });
  } catch (e) {
    settle(false);
  }

  /* The rail says times are shown in the reader's own zone; this is the zone the embed will use. */
  if (tzEl) {
    try {
      var tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
      if (tz) tzEl.textContent = 'Your browser reports ' + tz.replace(/_/g, ' ') + '.';
    } catch (e2) { /* leave the shipped sentence in place */ }
  }
})();
