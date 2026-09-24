/* 24 — Technology & Intelligence: "the system diagram".
   The HTML is the finished, readable state: every capability is a node linking to its detail, and the
   framework rows are plain content. Here:
   · .is-js at once, so the details share one reserved cell (no shift) and the hint shows;
   · choosing a node (click, Enter, focus, or hover on hover-capable devices) opens its detail in place;
   · framework rows become toggle buttons that light the capabilities built to each, in the diagram
     and in a readout of fixed height directly above the rows (so nothing moves under the pointer);
   · one faint pulse per stratum while on screen (BDH.live); nothing moves under reduced motion.
   hub.js (window.BDH) loads after sections.js, so init waits for DOMContentLoaded. */
(function () {
  'use strict';
  var root = document.querySelector('.s24');
  if (!root) return;
  root.classList.add('is-js');

  function $$(sel, el) { return Array.prototype.slice.call((el || root).querySelectorAll(sel)); }

  function init() {
    var BDH = window.BDH;
    var sys = root.querySelector('[data-s24]');
    var dets = root.querySelector('.s24__dets');
    if (!sys || !dets) return;
    var R = BDH ? !!BDH.reduced : window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (BDH) BDH.live(sys, 0.15);

    var nodes = $$('[data-s24-node]');
    var active = null;   // the framework key currently pressed
    var current = null;

    function markBadges() {
      $$('.s24__stds > .xt-badge').forEach(function (b) {
        b.classList.toggle('is-hit', !!active && b.classList.contains('s24__std-' + active));
      });
    }

    function select(slug) {
      if (!slug || slug === current) return;
      current = slug;
      nodes.forEach(function (n) {
        var on = n.getAttribute('data-s24-node') === slug;
        n.classList.toggle('is-on', on);
        if (on) n.setAttribute('aria-current', 'true'); else n.removeAttribute('aria-current');
      });
      $$('.s24__det').forEach(function (d) { d.classList.toggle('is-on', d.id === 's24-d-' + slug); });
    }

    var canHover = window.matchMedia('(hover: hover) and (pointer: fine)');
    var hoverT = null;
    nodes.forEach(function (n) {
      var slug = n.getAttribute('data-s24-node');
      n.addEventListener('click', function (e) {
        e.preventDefault();
        select(slug);
        /* on narrow screens the detail sits below the diagram: bring it into view if it is off screen */
        var r = dets.getBoundingClientRect();
        if (r.top > window.innerHeight - 120) dets.scrollIntoView({ behavior: R ? 'auto' : 'smooth', block: 'nearest' });
      });
      n.addEventListener('focus', function () { select(slug); });
      n.addEventListener('pointerenter', function () {
        if (!canHover.matches) return;
        clearTimeout(hoverT);
        hoverT = setTimeout(function () { select(slug); }, 90);
      });
      n.addEventListener('pointerleave', function () { clearTimeout(hoverT); });
    });

    var first = nodes.filter(function (n) { return n.classList.contains('is-on'); })[0] || nodes[0];
    var fromHash = location.hash.indexOf('#s24-d-') === 0 ? location.hash.slice(7) : null;
    select(fromHash && root.querySelector('#s24-d-' + fromHash) ? fromHash : first.getAttribute('data-s24-node'));

    /* ---------- frameworks index: rows become toggle buttons --------------- */
    var read = root.querySelector('[data-s24-read]');
    var rows = $$('.s24__fr');
    var fbs = [];
    rows.forEach(function (li) {
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 's24__fb';
      b.setAttribute('aria-pressed', 'false');
      while (li.firstChild) b.appendChild(li.firstChild);
      li.appendChild(b);
      li.classList.add('is-up');
      b.s24key = li.getAttribute('data-s24-std');
      b.s24code = li.getAttribute('data-code');
      fbs.push(b);
    });

    function hitsFor(key) {
      return nodes.filter(function (n) { return (' ' + n.getAttribute('data-std') + ' ').indexOf(' ' + key + ' ') > -1; });
    }
    var caps = $$('[data-s24-cap]');
    var capList = root.querySelector('.s24__fwc');
    function paintRead(key) {
      if (!read) return;
      read.textContent = '';
      if (!key) { read.textContent = 'Choose a framework to light the capabilities built to it.'; return; }
      var b = fbs.filter(function (f) { return f.s24key === key; })[0];
      var hits = hitsFor(key);
      var code = document.createElement('b');
      code.textContent = b ? b.s24code : key;
      read.appendChild(code);
      read.appendChild(document.createTextNode(' — ' + hits.length + ' of ' + nodes.length + ' capabilities are built to it'));
      var names = document.createElement('span');
      names.className = 'sr';
      names.textContent = ': ' + hits.map(function (n) { return n.querySelector('.s24__nn').textContent; }).join(', ');
      read.appendChild(names);
      read.appendChild(document.createTextNode('.'));
    }
    /* reserve the tallest sentence, so pressing a framework never moves the rows under the pointer */
    function reserve() {
      if (!read) return;
      read.style.minHeight = '';
      var max = 0;
      [null].concat(fbs.map(function (f) { return f.s24key; })).forEach(function (k) {
        paintRead(k); max = Math.max(max, read.offsetHeight);
      });
      read.style.minHeight = max + 'px';
      paintRead(active);
    }

    function apply(key) {
      active = key;
      fbs.forEach(function (b) { b.setAttribute('aria-pressed', b.s24key === key ? 'true' : 'false'); });
      var hits = key ? hitsFor(key) : [];
      nodes.forEach(function (n) { n.classList.toggle('is-hit', hits.indexOf(n) > -1); });
      sys.classList.toggle('is-filter', !!key);
      if (capList) capList.classList.toggle('is-filter', !!key);
      var hitSlugs = hits.map(function (n) { return n.getAttribute('data-s24-node'); });
      caps.forEach(function (c) { c.classList.toggle('is-hit', hitSlugs.indexOf(c.getAttribute('data-s24-cap')) > -1); });
      markBadges();
      paintRead(key);
    }
    fbs.forEach(function (b) {
      b.addEventListener('click', function () { apply(active === b.s24key ? null : b.s24key); });
    });
    reserve();
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(reserve);
    window.addEventListener('load', reserve);
    var rt = null;
    window.addEventListener('resize', function () { clearTimeout(rt); rt = setTimeout(reserve, 150); });

    /* show all frameworks (the list is cut to eight up to 1180px) */
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
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
