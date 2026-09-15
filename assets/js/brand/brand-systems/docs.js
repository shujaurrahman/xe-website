/* Brand Systems · 08 docs — sidebar opens pages; search filters the index live; autoplay searches until touched. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var site = document.querySelector('[data-cbs-dc]'); if (!site) return;
  var q = site.querySelector('[data-cbs-dc-q]');
  var out = site.querySelector('[data-cbs-dc-out]');
  var count = site.querySelector('[data-cbs-dc-count]');
  var none = site.querySelector('[data-cbs-dc-none]');
  var ver = site.querySelector('[data-cbs-dc-ver]');
  var btns = BDH.$$('[data-cbs-dc-page]', site);
  var groups = BDH.$$('[data-cbs-dc-grp]', site);
  var titles = {}; btns.forEach(function (b) { titles[b.getAttribute('data-cbs-dc-page')] = b.textContent; });

  var EX = {
    btn: '<span class="cbs-dc__x-btn">Book a demo</span><span class="cbs-dc__x-btn is-2">Compare plans</span>',
    input: '<span class="cbs-dc__x-in">Work email<i>name@company.com</i></span>',
    sw: '<span class="cbs-dc__x-sw"><i style="background:var(--blue)"></i><i style="background:var(--blue-d)"></i><i style="background:var(--ink)"></i><i style="background:var(--paper-3)"></i></span>',
    type: '<span class="cbs-dc__x-type"><span style="font-size:40px">Aa</span><span style="font-size:32px">Aa</span><span style="font-size:25px">Aa</span><span style="font-size:20px">Aa</span><span style="font-size:16px">Aa</span></span>',
    sp: '<span class="cbs-dc__x-sp"><i style="height:8px"></i><i style="height:16px"></i><i style="height:24px"></i><i style="height:32px"></i><i style="height:48px"></i><i style="height:64px"></i></span>',
    card: '<span class="cbs-dc__x-card"><i></i><b>Product C, explained</b></span>',
    flow: function (on) { return '<span class="cbs-dc__x-flow">' + ['Propose', 'Agent checks', 'Review', 'Owner', 'Release'].map(function (s, i) { return '<span' + (i === on ? ' class="is-on"' : '') + '>' + s + '</span>'; }).join('') + '</span>'; }
  };
  var PAGES = {
    install: ['Get started', 'Tokens ship as a package for code and a library for design tools. Both read the same source.', EX.flow(0).replace('Propose', 'tokens.json').replace('Agent checks', 'CSS').replace('Review', 'JSON').replace('Owner', 'Design tool').replace('Release', 'Native'), 'npm install @yourbrand/tokens\n<b>import</b> "@yourbrand/tokens/css";', ['Pin a minor version and update on release.', 'Copy token values into local files.']],
    principles: ['Get started', 'Start from the page for what you are making. Every page shows the component, the code and the rule, and names its owner.', EX.flow(2).replace(/Propose|Agent checks|Review|Owner|Release/g, function (m) { return { Propose: 'Find', 'Agent checks': 'Read', Review: 'Use', Owner: 'Ask', Release: 'Improve' }[m]; }), '<b>// every page</b>\ndesign · code · rules · owner', ['Link to the page, not a screenshot.', 'Keep your own copy of the guidelines.']],
    colour: ['Foundations', 'Blue leads and paper carries. Text on primary uses color.primary.strong to pass 4.5:1.', EX.sw, '<b>color</b>: var(--color-primary);\n<b>background</b>: var(--color-paper);', ['Check contrast for every text pairing.', 'Introduce a colour outside the token set.']],
    type: ['Foundations', 'A major-third scale from a 16 px base. Headings in the display face, reading in the text face.', EX.type, '<b>font-size</b>: var(--type-h2);  <b>/* 25px */</b>', ['Step down the scale for hierarchy.', 'Set headings by eye between steps.']],
    space: ['Foundations', 'An 8 px unit with three densities. Components read density from context.', EX.sp, '<b>padding</b>: calc(var(--space-unit) * 2);', ['Use multiples of the unit.', 'Nudge by single pixels.']],
    button: ['Components', 'The main action on a surface. One primary per view; secondary and text buttons for everything else.', EX.btn, '&lt;<b>Button</b> variant="primary"&gt;Book a demo&lt;/<b>Button</b>&gt;', ['Use one primary button per view.', 'Set label text below 4.5:1 contrast.']],
    input: ['Components', 'A labelled field with hint and error states. The label is always visible.', EX.input, '&lt;<b>Input</b> label="Work email" type="email" /&gt;', ['Write the error as the fix.', 'Use placeholder text as the label.']],
    card: ['Components', 'Four canonical cards: product, article, stat and quote. Radius and elevation come from tokens.', EX.card, '&lt;<b>Card</b> kind="article" media={img} /&gt;', ['Pick the kind that matches the content.', 'Add a fifth card for one campaign.']],
    email: ['Templates', 'One header, three slots: wordmark, preheader and view-online link. The CMS fills them.', EX.btn.replace('Compare plans', 'View online').replace('Book a demo', 'Your March update'), '{{&gt; <b>email-header</b> preheader=campaign.preheader }}', ['Keep the preheader under 90 characters.', 'Replace the wordmark with a campaign logo.']],
    social: ['Templates', 'Square, portrait and story. The headline sits on the image inside the safe area.', EX.card.replace('Product C, explained', 'Built for Segment A'), '<b>template</b>: social/square  <b>safe</b>: 72px', ['Keep the logo in the top left.', 'Put body copy on the tile.']],
    contribute: ['Governance', 'Anyone can propose a change. The agent runs checks; maintainers review; the system owner decides.', EX.flow(1), '<b>git</b> checkout -b proposal/primary-bright', ['Explain the problem before the fix.', 'Ship a local override instead.']],
    releases: ['Governance', 'Semantic versions. Deprecations stay for one major release with a migration note.', EX.flow(4), '<b>@yourbrand/system</b>@2.4.0  → 2.5.0-rc.1', ['Read the notes before a major update.', 'Skip a major without migrating.']]
  };

  function open(id, focus) {
    var p = PAGES[id]; if (!p) return;
    btns.forEach(function (b) { if (b.getAttribute('data-cbs-dc-page') === id) b.setAttribute('aria-current', 'page'); else b.removeAttribute('aria-current'); });
    out.innerHTML = '<p class="cbs-dc__crumb">' + p[0] + ' / ' + titles[id] + '</p><h3 class="cbs-dc__h">' + titles[id] + '</h3><p class="cbs-dc__lede">' + p[1] + '</p>' +
      '<div class="cbs-dc__split"><div class="cbs-dc__ex" aria-hidden="true">' + p[2] + '</div><pre class="cbs-dc__code"><code>' + p[3] + '</code></pre></div>' +
      '<ul class="cbs-dc__rules"><li class="is-do"><b>Do</b>' + p[4][0] + '</li><li class="is-dont"><b>Don’t</b>' + p[4][1] + '</li></ul>' +
      '<p class="cbs-dc__meta"><span>Owner · ' + (p[0] === 'Governance' ? 'System owner' : 'Design systems lead') + '</span><span>Updated in ' + ver.value + '</span></p>';
    out.classList.remove('is-swap'); void out.offsetWidth; if (!BDH.reduced) out.classList.add('is-swap');
    if (focus) out.focus({ preventScroll: true });
  }

  function mark(text, term) {
    var i = text.toLowerCase().indexOf(term);
    if (!term || i < 0) return text.replace(/</g, '&lt;');
    return text.slice(0, i) + '<mark>' + text.slice(i, i + term.length) + '</mark>' + text.slice(i + term.length);
  }
  function filter() {
    var term = q.value.trim().toLowerCase(), n = 0, first = null;
    btns.forEach(function (b) {
      var t = titles[b.getAttribute('data-cbs-dc-page')];
      var hit = !term || (t + ' ' + b.getAttribute('data-kw')).toLowerCase().indexOf(term) > -1;
      b.parentNode.hidden = !hit; b.innerHTML = mark(t, term);
      if (hit) { n++; if (!first) first = b; }
    });
    groups.forEach(function (g) { g.hidden = !BDH.$$('[data-cbs-dc-li]', g).some(function (li) { return !li.hidden; }); });
    none.hidden = n > 0;
    count.textContent = term ? n + (n === 1 ? ' page matches' : ' pages match') + ' “' + q.value.trim() + '”' : btns.length + ' pages';
    return first;
  }

  btns.forEach(function (b) { b.addEventListener('click', function () { open(b.getAttribute('data-cbs-dc-page'), true); }); });
  q.addEventListener('input', filter);
  q.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') { e.preventDefault(); var f = filter(); if (f) open(f.getAttribute('data-cbs-dc-page'), false); }
    if (e.key === 'Escape') { q.value = ''; filter(); }
  });
  ver.addEventListener('change', function () { var c = site.querySelector('[aria-current="page"]'); if (c) open(c.getAttribute('data-cbs-dc-page'), false); });
  document.addEventListener('keydown', function (e) {
    if (e.key !== '/' || /input|textarea|select/i.test((e.target.tagName || ''))) return;
    var r = site.getBoundingClientRect(); if (r.bottom < 0 || r.top > innerHeight) return;
    e.preventDefault(); q.focus();
  });

  if (BDH.reduced) return;
  var typer = null;
  function typeInto(word, then) { if (typer) typer.stop(); q.value = ''; filter(); var i = 0; typer = BDH.loop(site, 110, function () { i++; q.value = word.slice(0, i); filter(); if (i >= word.length) { typer.stop(); if (then) then(); } }); }
  BDH.seq(site, [
    [1400, function () { typeInto('contrast', function () { open('colour', false); }); }],
    [3600, function () { typeInto('release', function () { open('releases', false); }); }],
    [3600, function () { typeInto('card', function () { open('card', false); }); }],
    [3600, function () { if (typer) typer.stop(); q.value = ''; filter(); open('button', false); }]
  ], { interactRoot: site, onStop: function () { if (typer) typer.stop(); } });
})();
