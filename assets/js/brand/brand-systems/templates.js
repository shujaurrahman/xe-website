/* Brand Systems · 06 templates — format tabs re-lay the same content (FLIP); live headline check. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var box = document.querySelector('[data-cbs-tp]'); if (!box) return;
  var frame = box.querySelector('[data-cbs-tp-frame]');
  var input = box.querySelector('[data-cbs-tp-input]');
  var head = box.querySelector('[data-cbs-tp-headline]');
  var count = box.querySelector('[data-cbs-tp-count]');
  var check = box.querySelector('[data-cbs-tp-check]');
  var tabs = BDH.$$('[role="tab"]', box);
  var els = BDH.$$('[data-cbs-tp-el]', frame);
  var fmt = 'email', limit = 60;
  var HIDE = { email: [], social: ['cbs-tp__eye', 'cbs-tp__body', 'cbs-tp__legal'], slide: ['cbs-tp__cta'], banner: ['cbs-tp__logo', 'cbs-tp__eye', 'cbs-tp__body', 'cbs-tp__legal'] };
  var NAME = { email: 'email', social: 'social tile', slide: 'slide', banner: 'banner' };

  function esc(s) { return s.replace(/&/g, '&amp;').replace(/</g, '&lt;'); }
  function shorten(t, n) {
    var w = t.split(/\s+/), out = '';
    for (var i = 0; i < w.length; i++) { var nx = out ? out + ' ' + w[i] : w[i]; if (nx.replace(/[,;:]$/, '').length > n) break; out = nx; }
    return out.replace(/[,;:\s]+$/, '');
  }

  function validate() {
    var t = input.value.trim(), len = t.length, over = len > limit;
    head.textContent = t || ' ';
    count.textContent = len + ' / ' + limit;
    box.classList.toggle('is-over', over);
    if (!len) { check.innerHTML = '<b>Template check</b>The headline is required in every format.'; return; }
    if (!over) { check.innerHTML = '<b>Template check · passes</b>Fits the ' + NAME[fmt] + ' at ' + len + ' of ' + limit + ' characters.'; return; }
    var s = shorten(t, limit);
    check.innerHTML = '<b>Agent · over by ' + (len - limit) + '</b>Suggested for the ' + NAME[fmt] + ': “' + esc(s) + '”. A person accepts or rewrites it.' +
      (s ? '<br><button type="button" data-cbs-tp-accept>Accept suggestion</button>' : '');
    var a = check.querySelector('[data-cbs-tp-accept]');
    if (a) a.addEventListener('click', function () { input.value = s; validate(); input.focus(); });
  }

  function relay(next) {
    var first = BDH.reduced ? null : els.map(function (e) { return e.getBoundingClientRect(); });
    var fr0 = BDH.reduced ? null : frame.getBoundingClientRect();
    frame.className = 'cbs-tp__frame is-' + next;
    els.forEach(function (e) {
      var off = HIDE[next].some(function (c) { return e.classList.contains(c); });
      e.classList.toggle('is-off', off);
    });
    if (!first) return;
    var fr1 = frame.getBoundingClientRect();
    frame.animate([{ transform: 'scale(' + (fr0.width / fr1.width) + ',' + (fr0.height / fr1.height) + ')', opacity: .6 }, { transform: 'none', opacity: 1 }], { duration: 520, easing: 'cubic-bezier(.22,1,.36,1)' });
    els.forEach(function (e, i) {
      if (e.classList.contains('is-off')) return;
      var a = first[i], b = e.getBoundingClientRect();
      if (!a.width || !b.width) { e.animate([{ opacity: 0 }, { opacity: 1 }], { duration: 400, delay: 160, fill: 'backwards' }); return; }
      var dx = (a.left - fr0.left) - (b.left - fr1.left), dy = (a.top - fr0.top) - (b.top - fr1.top);
      e.animate([{ transform: 'translate(' + dx + 'px,' + dy + 'px)' }, { transform: 'none' }], { duration: 620, easing: 'cubic-bezier(.22,1,.36,1)', delay: i * 18 });
    });
  }

  BDH.tabs(box.querySelector('.cbs-tp__right'), {
    tabs: tabs,
    panes: BDH.$$('[role="tabpanel"]', box),
    auto: BDH.reduced ? 0 : 3400,
    interactRoot: box,
    onChange: function (i) {
      var t = tabs[i]; fmt = t.getAttribute('data-format'); limit = +t.getAttribute('data-limit');
      relay(fmt); validate();
    }
  });
  input.addEventListener('input', validate);
  input.addEventListener('keydown', function (e) { if (e.key === 'Enter') e.preventDefault(); });   // a headline is one line
  relay('email'); validate();
})();
