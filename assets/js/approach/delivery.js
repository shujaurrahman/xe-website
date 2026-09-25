/* Delivery — folds the readable six-stage list into a stepper.
   The HTML ships every stage in full, with the rail as ordinary jump links, so the section is complete
   without JavaScript. At init this script upgrades the rail to an ARIA tablist, the stages to panes, and
   hands the keyboard handling to BDH.tabs (arrows, Home, End). A #apr-stage-<key> in the address bar
   selects that stage instead of the first. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-apr-dl]');
  if (!root) return;
  var rail  = root.querySelector('.apr-dl__rail');
  var list  = root.querySelector('.apr-dl__stages');
  var scrl  = root.querySelector('.apr-dl__railwrap');
  var tabs  = BDH.$$('.apr-dl__tab', root);
  var panes = BDH.$$('.apr-stg', root);
  var items = BDH.$$('.apr-dl__ri', root);
  if (!rail || !list || !tabs.length || tabs.length !== panes.length) return;

  var sel = parseInt(root.getAttribute('data-sel') || '0', 10);
  if (!(sel >= 0 && sel < tabs.length)) sel = 0;
  var hash = (window.location.hash || '').slice(1);
  if (hash) {
    panes.forEach(function (p, i) { if (p.id === hash) sel = i; });
  }

  rail.setAttribute('role', 'tablist');
  rail.setAttribute('aria-orientation', 'horizontal');
  list.setAttribute('role', 'presentation');
  list.classList.add('bdh-panes');
  root.classList.add('is-step');

  tabs.forEach(function (t, i) {
    t.setAttribute('role', 'tab');
    t.setAttribute('aria-controls', panes[i].id);
    t.setAttribute('aria-selected', 'false');
    t.setAttribute('tabindex', '-1');
    t.addEventListener('click', function (ev) { ev.preventDefault(); });
  });
  panes.forEach(function (p, i) {
    p.setAttribute('role', 'tabpanel');
    p.setAttribute('aria-labelledby', tabs[i].id);
    p.classList.add('bdh-pane');
    p.classList.remove('is-on');
  });

  function mark(i) {
    root.style.setProperty('--dl-at', String(i));
    items.forEach(function (li, n) {
      li.classList.toggle('is-on', n === i);
      li.classList.toggle('is-past', n < i);
    });
  }
  function reveal(i) {
    if (!scrl || scrl.scrollWidth <= scrl.clientWidth) return;
    var t = tabs[i];
    var want = t.offsetLeft - (scrl.clientWidth - t.offsetWidth) / 2;
    scrl.scrollTo({ left: Math.max(0, want), behavior: BDH.reduced ? 'auto' : 'smooth' });
  }

  var api = BDH.tabs(root, {
    tabs: '.apr-dl__tab',
    panes: '.apr-stg',
    initial: sel,
    orientation: 'horizontal',
    onChange: function (i, prev, byUser) { mark(i); if (byUser) reveal(i); }
  });
  mark(sel);
  if (hash) reveal(sel);

  /* anchors elsewhere on the page (the contents list, the contracts section) still address a stage */
  window.addEventListener('hashchange', function () {
    var h = (window.location.hash || '').slice(1);
    panes.forEach(function (p, i) { if (p.id === h) { api.show(i, true); reveal(i); } });
  });
})();
