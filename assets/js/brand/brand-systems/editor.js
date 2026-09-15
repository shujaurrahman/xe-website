/* Brand Systems · signature — live token editor: controls → components, export, impact report. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var app = document.querySelector('[data-cbs-ed]'); if (!app) return;
  var $ = function (s) { return app.querySelector(s); };
  var $$ = function (s) { return BDH.$$(s, app); };
  var stage = $('[data-cbs-ed-stage]');
  var radius = $('[data-cbs-ed-radius]');
  var base = { hue: 'deep', r: 10, ratio: '1.25', u: '8' };
  var hues = {};
  $$('input[name="cbs-ed-hue"]').forEach(function (i) { hues[i.value] = { hex: i.getAttribute('data-hex'), css: i.getAttribute('data-css'), name: i.parentNode.querySelector('.cbs-ed__hn').firstChild.textContent }; });

  /* illustrative usage counts across the system — PLACEHOLDER: confirm before launch */
  var USE = { Button: 14, Link: 22, Input: 8, Card: 11, 'Email header': 6, 'Social tile': 9, 'Slide title': 4 };
  var HITS = {
    hue: ['Button', 'Link', 'Email header', 'Social tile', 'Slide title'],
    r: ['Button', 'Input', 'Card', 'Social tile'],
    ratio: ['Card', 'Email header', 'Social tile', 'Slide title'],
    u: ['Input', 'Card', 'Email header', 'Button']
  };
  var CELL = { Button: 'btn', Input: 'in', Card: 'card', 'Email header': 'mail', 'Social tile': 'social', 'Slide title': 'slide', Link: 'card' };
  var TOK = { hue: 'color.primary', r: 'radius.md', ratio: 'type.ratio', u: 'space.unit' };

  function val(name) { var c = app.querySelector('input[name="' + name + '"]:checked'); return c ? c.value : ''; }
  function state() { return { hue: val('cbs-ed-hue'), r: +radius.value, ratio: val('cbs-ed-ratio'), u: val('cbs-ed-dens') }; }
  function esc(s) { return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;'); }

  function lum(hex) {
    var n = parseInt(hex.slice(1), 16), c = [n >> 16, (n >> 8) & 255, n & 255].map(function (v) { v /= 255; return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4); });
    return 0.2126 * c[0] + 0.7152 * c[1] + 0.0722 * c[2];
  }
  function ratioOf(a, b) { var x = lum(a), y = lum(b); return (Math.max(x, y) + 0.05) / (Math.min(x, y) + 0.05); }

  function sizes(s) { var q = +s.ratio, b = 13; return { h3: b * q, h2: b * q * q, h1: b * q * q * q }; }

  var prev = null;
  function render(fromUser) {
    var s = state(), h = hues[s.hue], z = sizes(s);
    stage.style.setProperty('--x-p', h.css);
    stage.style.setProperty('--x-r', s.r + 'px');
    stage.style.setProperty('--x-u', s.u + 'px');
    stage.style.setProperty('--x-h1', z.h1.toFixed(1) + 'px');
    stage.style.setProperty('--x-h2', z.h2.toFixed(1) + 'px');
    stage.style.setProperty('--x-h3', z.h3.toFixed(1) + 'px');
    $('[data-cbs-ed-out="radius"]').textContent = s.r + 'px';

    /* which tokens differ from the release, and which just changed */
    var changed = Object.keys(base).filter(function (k) { return String(s[k]) !== String(base[k]); });
    var just = prev ? Object.keys(base).filter(function (k) { return String(s[k]) !== String(prev[k]); }) : [];
    prev = s;
    just.forEach(function (k) {
      HITS[k].forEach(function (c) {
        var cell = stage.querySelector('.cbs-ed__cell--' + CELL[c]); if (!cell) return;
        cell.classList.remove('is-hit'); void cell.offsetWidth; cell.classList.add('is-hit');
        clearTimeout(cell._t); cell._t = setTimeout(function () { cell.classList.remove('is-hit'); }, 1400);
      });
    });

    code(s, h, z, changed);
    impact(changed);
    contrast(h, z);
    $('[data-cbs-ed-merge]').textContent = changed.length ? changed.length + ' token' + (changed.length === 1 ? '' : 's') + ' · awaiting system owner' : 'nothing to merge';
    $('[data-cbs-ed-diff]').textContent = changed.length + (changed.length === 1 ? ' change' : ' changes') + ' vs v2.4.0';
  }

  function code(s, h, z, ch) {
    var m = function (k, v) { return ch.indexOf(k) > -1 ? '<mark>' + esc(v) + '</mark>' : '<span class="v">' + esc(v) + '</span>'; };
    var on = '#FFFFFF';
    $('[data-cbs-ed-code="css"]').innerHTML =
      '<span class="c">/* your-brand · tokens.css */</span>\n<span class="k">:root</span> {\n' +
      '  <span class="k">--color-primary</span>: ' + m('hue', h.hex) + ';\n' +
      '  <span class="k">--color-on-primary</span>: <span class="v">' + on + '</span>;\n' +
      '  <span class="k">--radius-md</span>: ' + m('r', s.r + 'px') + ';\n' +
      '  <span class="k">--type-ratio</span>: ' + m('ratio', s.ratio) + ';\n' +
      '  <span class="k">--type-h1</span>: ' + m('ratio', z.h1.toFixed(1) + 'px') + ';\n' +
      '  <span class="k">--space-unit</span>: ' + m('u', s.u + 'px') + ';\n}';
    $('[data-cbs-ed-code="json"]').innerHTML =
      '{\n  <span class="k">"color"</span>: { <span class="k">"primary"</span>: "' + m('hue', h.hex) + '", <span class="k">"on-primary"</span>: "<span class="v">' + on + '</span>" },\n' +
      '  <span class="k">"radius"</span>: { <span class="k">"md"</span>: ' + m('r', s.r) + ' },\n' +
      '  <span class="k">"type"</span>: { <span class="k">"ratio"</span>: ' + m('ratio', s.ratio) + ', <span class="k">"base"</span>: <span class="v">13</span> },\n' +
      '  <span class="k">"space"</span>: { <span class="k">"unit"</span>: ' + m('u', s.u) + ' }\n}';
    $('[data-cbs-ed-code="dt"]').innerHTML =
      '<span class="c">// W3C design-token format · imports as design-tool variables</span>\n{\n' +
      '  <span class="k">"color.primary"</span>: { <span class="k">"$type"</span>: "color", <span class="k">"$value"</span>: "' + m('hue', h.hex) + '" },\n' +
      '  <span class="k">"radius.md"</span>: { <span class="k">"$type"</span>: "dimension", <span class="k">"$value"</span>: "' + m('r', s.r + 'px') + '" },\n' +
      '  <span class="k">"type.ratio"</span>: { <span class="k">"$type"</span>: "number", <span class="k">"$value"</span>: ' + m('ratio', s.ratio) + ' },\n' +
      '  <span class="k">"space.unit"</span>: { <span class="k">"$type"</span>: "dimension", <span class="k">"$value"</span>: "' + m('u', s.u + 'px') + '" }\n}';
  }

  function impact(ch) {
    var list = $('[data-cbs-ed-impact]');
    if (!ch.length) { list.innerHTML = '<li class="is-none">No changes against release v2.4.0. Edit a token to see what it touches.</li>'; return; }
    var rows = {};
    ch.forEach(function (k) { HITS[k].forEach(function (c) { (rows[c] = rows[c] || []).push(TOK[k]); }); });
    var names = Object.keys(rows).sort(function (a, b) { return rows[b].length - rows[a].length || USE[b] - USE[a]; });
    var total = names.reduce(function (t, c) { return t + USE[c]; }, 0);
    list.innerHTML = names.map(function (c) {
      return '<li><b>' + esc(c) + '</b><span class="cbs-ed__use">' + USE[c] + ' uses</span><span class="cbs-ed__via">' + rows[c].map(esc).join(' · ') + '</span></li>';
    }).join('') + '<li class="is-sum"><b>' + names.length + ' components</b><span class="cbs-ed__use">' + total + ' uses</span><span class="cbs-ed__via">Illustrative counts</span></li>';
  }

  function contrast(h, z) {
    var large = z.h2 * 1.1 >= 24;
    var checks = [
      ['Button label', '#FFFFFF', h.hex, 4.5, 'on primary'],
      ['Link text', h.hex, '#FFFFFF', 4.5, 'on paper'],
      ['Social headline', '#FFFFFF', h.hex, large ? 3 : 4.5, large ? 'large text' : 'body size']
    ];
    var fail = 0;
    var html = checks.map(function (c) {
      var r = ratioOf(c[1], c[2]), ok = r >= c[3]; if (!ok) fail++;
      return '<li class="' + (ok ? 'is-ok' : 'is-fail') + '"><span class="cbs-ed__pair" style="--a:' + c[1] + ';--b:' + c[2] + '"><i></i></span><b>' + c[0] + '</b><span class="cbs-ed__req">' + c[4] + ' · needs ' + c[3] + ':1</span><span class="cbs-ed__ratio">' + r.toFixed(2) + ':1</span><em>' + (ok ? 'Pass' : 'Fails AA') + '</em></li>';
    }).join('');
    if (fail && h.hex !== '#006CD0') html += '<li class="is-tip">Suggestion: move label text to <code>color.primary.strong</code> (#006CD0, ' + ratioOf('#FFFFFF', '#006CD0').toFixed(2) + ':1) or route to the system owner for an exception.</li>';
    $('[data-cbs-ed-contrast]').innerHTML = html;
  }

  /* controls */
  $$('input').forEach(function (i) { i.addEventListener(i.type === 'range' ? 'input' : 'change', function () { render(true); }); });
  var tabs = BDH.tabs(app.querySelector('.cbs-ed__code'), { tabs: $$('[role="tab"]'), panes: $$('[role="tabpanel"]') });

  function set(name, v) { var i = app.querySelector('input[name="' + name + '"][value="' + v + '"]'); if (i) i.checked = true; }
  function reset() { set('cbs-ed-hue', base.hue); radius.value = base.r; set('cbs-ed-ratio', base.ratio); set('cbs-ed-dens', base.u); render(true); }
  $('[data-cbs-ed-reset]').addEventListener('click', reset);

  /* copy the visible export */
  var copied = $('[data-cbs-ed-copied]');
  $('[data-cbs-ed-copy]').addEventListener('click', function () {
    var pane = $$('[role="tabpanel"]').filter(function (p) { return !p.hidden; })[0];
    var text = pane ? pane.textContent : '';
    function done(ok) { copied.textContent = ok ? 'Copied to clipboard' : 'Select the code and copy it manually'; clearTimeout(copied._t); copied._t = setTimeout(function () { copied.textContent = ''; }, 2400); }
    function fallback() {
      var ta = document.createElement('textarea'); ta.value = text; ta.setAttribute('readonly', ''); ta.style.position = 'fixed'; ta.style.opacity = '0';
      document.body.appendChild(ta); ta.select(); var ok = false; try { ok = document.execCommand('copy'); } catch (e) { ok = false; }
      document.body.removeChild(ta); done(ok);
    }
    if (navigator.clipboard && window.isSecureContext) navigator.clipboard.writeText(text).then(function () { done(true); }, fallback); else fallback();
  });

  render(false);

  /* autoplay — scripted edits until the visitor touches the editor */
  var auto = $('[data-cbs-ed-auto]');
  if (BDH.reduced) { auto.hidden = true; return; }
  function mark(sel) { $$('.cbs-ed__f').forEach(function (f) { f.classList.remove('is-auto'); }); var el = app.querySelector(sel); if (el) el.closest('.cbs-ed__f').classList.add('is-auto'); }
  function slide(to) { var from = +radius.value, st = from < to ? 2 : -2, t = setInterval(function () { if (+radius.value === to) { clearInterval(t); return; } radius.value = +radius.value + st; render(false); }, 70); }
  var play = BDH.seq(app, [
    [1600, function () { mark('[name="cbs-ed-hue"]'); set('cbs-ed-hue', 'blue'); render(false); }],
    [2200, function () { mark('[data-cbs-ed-radius]'); slide(20); }],
    [2400, function () { mark('[name="cbs-ed-ratio"]'); set('cbs-ed-ratio', '1.333'); render(false); }],
    [2200, function () { tabs.show(1, false); }],
    [2200, function () { mark('[name="cbs-ed-dens"]'); set('cbs-ed-dens', '6'); render(false); }],
    [2400, function () { mark('[name="cbs-ed-hue"]'); set('cbs-ed-hue', 'ink'); render(false); }],
    [2400, function () { tabs.show(2, false); mark('[data-cbs-ed-radius]'); slide(2); }],
    [2600, function () { mark('[name="cbs-ed-ratio"]'); set('cbs-ed-ratio', '1.2'); render(false); }],
    [2800, function () { mark(null); reset(); tabs.show(0, false); }]
  ], {
    onStop: function () { mark(null); auto.textContent = 'Your controls · autoplay stopped'; auto.classList.add('is-off'); }
  });
})();
