/* Legal suite (prefix lgl). Everything here is enhancement: the shipped HTML is complete without it.
   · contents rail: highlights the section in view; collapses on phones
   · print button · privacy data-map filter · commercial contract selector (ARIA tabs)
   · accessibility barrier report (builds a mailto) · copy-to-clipboard */
(function () {
  'use strict';
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };
  var phone = window.matchMedia('(max-width:1023px)');

  /* ---- contents rail ---- */
  var toc = $('[data-lgl-toc]');
  if (toc) {
    if (phone.matches) toc.open = false;
    $('.lgl-toc__s', toc).addEventListener('click', function (e) { if (!phone.matches) e.preventDefault(); });
    phone.addEventListener && phone.addEventListener('change', function () { if (!phone.matches) toc.open = true; });
    var links = $$('.lgl-toc__l a', toc);
    links.forEach(function (a) { a.addEventListener('click', function () { if (phone.matches) toc.open = false; }); });
    var secs = links.map(function (a) { return document.getElementById(a.getAttribute('href').slice(1)); }).filter(Boolean);
    if ('IntersectionObserver' in window && secs.length) {
      var vis = {};
      var io = new IntersectionObserver(function (es) {
        es.forEach(function (en) { vis[en.target.id] = en.isIntersecting; });
        var cur = null;
        for (var i = 0; i < secs.length; i++) { if (vis[secs[i].id]) cur = secs[i].id; }
        if (!cur) return;
        links.forEach(function (a) {
          var on = a.getAttribute('href') === '#' + cur;
          a.classList.toggle('is-on', on);
          if (on) a.setAttribute('aria-current', 'location'); else a.removeAttribute('aria-current');
        });
      }, { rootMargin: '-20% 0px -55% 0px' });
      secs.forEach(function (s) { io.observe(s); });
    }
  }
  var pr = $('[data-lgl-print]');
  if (pr && window.print) { pr.hidden = false; pr.addEventListener('click', function () { window.print(); }); }

  /* ---- privacy: data-map filter ---- */
  var map = $('[data-lgl-map]');
  if (map) {
    var chips = $$('[data-lgl-f]', map), rows = $$('tbody tr', map), live = $('.lgl-map__live', map);
    $('.lgl-map__f', map).hidden = false;
    chips.forEach(function (c) {
      c.addEventListener('click', function () {
        var f = c.getAttribute('data-lgl-f'), n = 0;
        chips.forEach(function (x) { x.setAttribute('aria-pressed', x === c ? 'true' : 'false'); });
        rows.forEach(function (r) {
          var ok = f === 'all' || (' ' + r.getAttribute('data-src') + ' ').indexOf(' ' + f + ' ') > -1;
          r.classList.toggle('is-out', !ok); if (ok) n++;
        });
        if (live) live.textContent = (f === 'all' ? 'Showing every item' : 'Showing ' + n + ' item' + (n === 1 ? '' : 's') + ' for ' + c.firstChild.textContent.trim()) + '.';
      });
    });
  }

  /* ---- commercial: contract selector ---- */
  var pk = $('[data-lgl-pk]');
  if (pk) {
    var tabs = $$('[role="tab"]', pk), panes = $$('.lgl-pk__pane', pk);
    function show(i, focus) {
      tabs.forEach(function (t, j) { var on = i === j; t.setAttribute('aria-selected', on ? 'true' : 'false'); t.tabIndex = on ? 0 : -1; if (on && focus) t.focus(); });
      panes.forEach(function (p, j) { p.classList.toggle('is-on', i === j); p.setAttribute('role', 'tabpanel'); p.tabIndex = 0; });
    }
    pk.classList.add('is-anim');
    tabs.forEach(function (t, i) {
      t.addEventListener('click', function () { show(i); });
      t.addEventListener('keydown', function (e) {
        var k = e.key, n = tabs.length, j = null;
        if (k === 'ArrowRight' || k === 'ArrowDown') j = (i + 1) % n;
        else if (k === 'ArrowLeft' || k === 'ArrowUp') j = (i - 1 + n) % n;
        else if (k === 'Home') j = 0; else if (k === 'End') j = n - 1;
        if (j !== null) { e.preventDefault(); show(j, true); }
      });
    });
    show(0);
  }

  /* ---- accessibility: barrier report composer ---- */
  var rep = $('[data-lgl-rep]');
  if (rep) {
    var go = $('[data-lgl-rep-go]', rep), base = go.getAttribute('href').split('?')[0];
    var subj = 'Accessibility barrier report';
    function build() {
      var v = function (n) { var el = rep.elements[n]; return el ? el.value.trim() : ''; };
      var body = 'Page or address: ' + (v('page') || '(not given)') + '\n' +
        'What happened: ' + (v('what') || '(not given)') + '\n' +
        'Assistive technology / browser: ' + (v('at') || '(not given)') + '\n' +
        'Best way to reply: ' + (v('reply') || 'email') + '\n';
      go.setAttribute('href', base + '?subject=' + encodeURIComponent(subj) + '&body=' + encodeURIComponent(body));
    }
    rep.addEventListener('input', build); rep.addEventListener('change', build);
    rep.addEventListener('submit', function (e) { e.preventDefault(); build(); window.location.href = go.getAttribute('href'); });
    build();
  }

  /* ---- copy buttons ---- */
  $$('[data-lgl-copy]').forEach(function (b) {
    if (!navigator.clipboard) return;
    b.hidden = false;
    b.addEventListener('click', function () {
      var src = document.getElementById(b.getAttribute('data-lgl-copy'));
      navigator.clipboard.writeText(src.textContent.trim()).then(function () {
        var t = b.textContent; b.textContent = 'Copied'; setTimeout(function () { b.textContent = t; }, 1600);
      });
    });
  });
})();
