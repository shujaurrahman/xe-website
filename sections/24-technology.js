/* 24 — Technology & Intelligence: "the manifest".
   The HTML is the finished, readable state (all ten manifests, one after another). Here:
   · .is-js at once, so the rail shows and only the current manifest stays in flow;
   · the rail becomes an ARIA tablist (BDH.tabs) that advances by itself every 7 s while on screen,
     until the first interaction anywhere in the section;
   · the frameworks strip becomes a set of toggle buttons that mark the capabilities built to each.
   hub.js (window.BDH) loads after sections.js, so init waits for DOMContentLoaded. */
(function () {
  'use strict';
  var root = document.querySelector('.s24');
  if (!root) return;
  root.classList.add('is-js');

  function init() {
    var BDH = window.BDH;
    var x = root.querySelector('[data-s24]');
    var rail = root.querySelector('[data-s24-rail]');
    if (!x || !rail) return;
    if (!BDH) { root.classList.remove('is-js'); return; }   // no helpers: keep the complete static list

    var R = !!BDH.reduced;
    var MS = 7000;
    var tabs = Array.prototype.slice.call(rail.querySelectorAll('.s24__tab'));
    var panes = tabs.map(function (t) { return document.getElementById(t.getAttribute('aria-controls')); });

    /* ARIA: one vertical tablist; the layer groups are presentational (each tab names its layer) */
    rail.setAttribute('role', 'tablist');
    rail.setAttribute('aria-label', 'Technology capabilities');
    Array.prototype.forEach.call(rail.querySelectorAll('.s24__grp, .s24__tabs'), function (g) { g.setAttribute('role', 'none'); });
    tabs.forEach(function (t, n) {
      t.setAttribute('role', 'tab');
      t.setAttribute('aria-selected', n === 0 ? 'true' : 'false');
    });
    panes.forEach(function (p, n) {
      if (!p) return;
      p.setAttribute('role', 'tabpanel');
      p.setAttribute('aria-labelledby', tabs[n].id);
    });

    x.style.setProperty('--s24-t', MS + 'ms');
    BDH.live(x, 0.2);

    var active = null;   // the framework key currently pressed

    function markPane(p) {
      if (!p) return;
      Array.prototype.forEach.call(p.querySelectorAll('.s24__stds > .xt-badge'), function (b) {
        b.classList.toggle('is-hit', !!active && b.classList.contains('s24__std-' + active));
      });
    }

    var api = BDH.tabs(x, {
      tabs: tabs,
      panes: panes,
      auto: R ? 0 : MS,
      orientation: 'vertical',
      interactRoot: root,
      onChange: function (i) {
        var p = panes[i];
        markPane(p);
        if (R || !p) return;
        p.classList.remove('is-enter');
        void p.offsetWidth;                       // restart the entrance
        p.classList.add('is-enter');
      }
    });
    markPane(panes[api.index()]);

    /* the progress rule belongs to the automatic tour only */
    BDH.onInteract(root, function () { x.classList.add('is-manual'); });
    if (R) x.classList.add('is-manual');

    /* ---------- frameworks strip: toggle buttons ---------------------------- */
    var read = root.querySelector('[data-s24-read]');
    var idle = read ? read.textContent : '';
    var fbs = Array.prototype.slice.call(root.querySelectorAll('[data-s24-std]'));

    function names(key) {
      return tabs.filter(function (t) { return (' ' + t.getAttribute('data-std') + ' ').indexOf(' ' + key + ' ') > -1; });
    }
    function apply(key) {
      active = key;
      fbs.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-s24-std') === key ? 'true' : 'false'); });
      var hits = key ? names(key) : [];
      tabs.forEach(function (t) { t.classList.toggle('is-hit', hits.indexOf(t) > -1); });
      x.classList.toggle('is-filter', !!key);
      markPane(panes[api.index()]);
      if (!read) return;
      if (!key) { read.textContent = idle; return; }
      var b = fbs.filter(function (f) { return f.getAttribute('data-s24-std') === key; })[0];
      read.innerHTML = '';
      var code = document.createElement('b');
      code.textContent = b.getAttribute('data-code');
      read.appendChild(code);
      var list = hits.map(function (t) { return t.querySelector('.s24__tt').firstChild.textContent.trim(); });
      read.appendChild(document.createTextNode(': ' + hits.length + ' of ' + tabs.length + ' capabilities are built to it — ' + list.join(', ') + '.'));
      /* keep the open manifest relevant: jump to the first capability that uses it */
      if (hits.length && hits.indexOf(tabs[api.index()]) === -1) api.show(tabs.indexOf(hits[0]), true);
    }
    var all = root.querySelector('.s24__all');
    var fwl = root.querySelector('.s24__fwl');
    if (all && fwl) {
      all.hidden = false;
      var label = all.textContent;
      all.addEventListener('click', function () {
        var open = !fwl.classList.contains('is-open');
        fwl.classList.toggle('is-open', open);
        all.setAttribute('aria-expanded', open ? 'true' : 'false');
        all.textContent = open ? 'Show fewer frameworks' : label;
      });
    }

    fbs.forEach(function (b) {
      b.disabled = false;
      b.addEventListener('click', function () {
        var key = b.getAttribute('data-s24-std');
        apply(active === key ? null : key);
      });
    });
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
