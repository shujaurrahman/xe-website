/* Search & AI Visibility — 03 · Technical.
   Two behaviours:
   1. The robots.txt switchboard. Real buttons with aria-pressed; toggling one rewrites the rules
      block and the explanation pane. This is a control, so it works under reduced motion too.
   2. The crawler token walking the pipeline and sampling rows in the crawl log. Decoration only:
      it runs under BDH.loop, which never starts when prefers-reduced-motion is set and pauses
      whenever the section is off screen or the tab is hidden. The HTML already shows the finished
      state, so nothing is hidden when this file does not run. */
(function () {
  'use strict';
  if (!window.BDH) return;

  /* ---------- 1. the bot switchboard ------------------------------------- */
  var bots = document.querySelector('[data-tsv-bots]');
  if (bots) {
    var code = bots.querySelector('[data-bots-code]');
    var ek   = bots.querySelector('[data-bots-ek]');
    var et   = bots.querySelector('[data-bots-et]');
    var en   = bots.querySelector('[data-bots-en]');
    var sws  = BDH.$$('.tsv-bot__sw', bots);

    function rules() {
      if (!code) return;
      var out = [];
      sws.forEach(function (sw) {
        var on = sw.getAttribute('aria-pressed') === 'true';
        out.push('User-agent: ' + name(sw));
        out.push(on ? 'Allow: /' : 'Disallow: /');
        out.push('');
      });
      out.push('Sitemap: https://yourcompany.com/sitemap.xml');
      var c = code.querySelector('code') || code;
      c.textContent = out.join('\n');
    }

    function name(sw) {
      var b = sw.closest('.tsv-bot').querySelector('.tsv-bot__n b');
      return b ? b.textContent.trim() : '';
    }

    function explain(sw) {
      var on = sw.getAttribute('aria-pressed') === 'true';
      if (ek) ek.textContent = name(sw) + ' · ' + (on ? 'allowed' : 'disallowed');
      if (et) et.textContent = sw.getAttribute(on ? 'data-allow' : 'data-deny') || '';
      if (en) en.textContent = sw.getAttribute(on ? 'data-deny' : 'data-allow') || '';
    }

    sws.forEach(function (sw) {
      sw.addEventListener('click', function () {
        var on = sw.getAttribute('aria-pressed') === 'true';
        sw.setAttribute('aria-pressed', on ? 'false' : 'true');

        var st = sw.querySelector('.tsv-bot__st');
        if (st) st.textContent = on ? 'Disallow' : 'Allow';
        var sr = sw.querySelector('.bdh-sr');
        if (sr) sr.textContent = name(sw) + ' · ' + (on ? 'disallowed' : 'allowed');

        var row = sw.closest('.tsv-bot');
        BDH.$$('.tsv-bot', bots).forEach(function (r) { r.classList.toggle('is-touched', r === row); });

        rules();
        explain(sw);
      });

      sw.addEventListener('focus', function () { explain(sw); });
    });
  }

  /* ---------- 2. the crawler walking the pipeline ------------------------ */
  var pipe = document.querySelector('[data-tsv-pipe]');
  if (!pipe || BDH.reduced) return;

  var stages = BDH.$$('.tsv-stage', pipe);
  var rows   = BDH.$$('.tsv-log__row', pipe);
  if (!stages.length) return;

  var list = pipe.querySelector('.tsv-pipe__stages');
  var at   = 0;

  function step() {
    var s = stages[at];

    stages.forEach(function (el, i) {
      el.classList.toggle('is-at', i === at);
      el.classList.toggle('is-done', i < at);
    });

    /* move the token to this stage's node, measured from the list box */
    if (list && s) {
      var node = s.querySelector('.tsv-stage__line');
      if (node) {
        var x = node.getBoundingClientRect().left - list.getBoundingClientRect().left;
        list.style.setProperty('--tsv-crawl', Math.round(x) + 'px');
      }
    }

    /* light the two log rows this pass "sampled" */
    if (rows.length) {
      rows.forEach(function (r) { r.classList.remove('is-hit'); });
      var a = (at * 2) % rows.length;
      if (rows[a]) rows[a].classList.add('is-hit');
      if (rows[a + 1]) rows[a + 1].classList.add('is-hit');
    }

    at = (at + 1) % stages.length;
  }

  step();
  BDH.live(pipe, 0.2, function (on) { if (!on && list) list.style.removeProperty('--tsv-crawl'); });
  BDH.loop(pipe, 1900, step);
})();
