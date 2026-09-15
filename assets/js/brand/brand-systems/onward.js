/* Brand Systems · 13 onward — draw dependency edges between nodes; values flow along them; hover traces a node. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var g = document.querySelector('[data-cbs-ow]'); if (!g) return;
  var svg = g.querySelector('[data-cbs-ow-svg]');
  var NS = 'http://www.w3.org/2000/svg';
  var edges = []; try { edges = JSON.parse(g.getAttribute('data-edges') || '[]'); } catch (e) { edges = []; }
  var nodes = {};
  BDH.$$('[data-cbs-ow-node]', g).forEach(function (n) { nodes[n.getAttribute('data-cbs-ow-node')] = n; });
  var paths = [];

  function draw() {
    if (getComputedStyle(svg).display === 'none') return;
    var box = g.getBoundingClientRect();
    svg.setAttribute('viewBox', '0 0 ' + Math.round(box.width) + ' ' + Math.round(box.height));
    while (svg.firstChild) svg.removeChild(svg.firstChild);
    paths = [];
    edges.forEach(function (e, i) {
      var a = nodes[e[0]], b = nodes[e[1]]; if (!a || !b) return;
      var ra = a.getBoundingClientRect(), rb = b.getBoundingClientRect();
      var x1 = ra.right - box.left, y1 = ra.top + ra.height / 2 - box.top;
      var x2 = rb.left - box.left, y2 = rb.top + rb.height / 2 - box.top;
      var mx = (x1 + x2) / 2;
      var d = 'M' + x1 + ' ' + y1 + ' C ' + mx + ' ' + y1 + ' ' + mx + ' ' + y2 + ' ' + x2 + ' ' + y2;
      [false, true].forEach(function (flow) {
        var p = document.createElementNS(NS, 'path');
        p.setAttribute('d', d);
        if (flow) { p.setAttribute('pathLength', '100'); p.setAttribute('class', 'is-flow'); p.style.setProperty('--d', (i * 0.35).toFixed(2)); }
        svg.appendChild(p);
        if (!flow) paths.push({ from: e[0], to: e[1], el: p });
      });
    });
  }

  function hot(slug) {
    g.classList.toggle('has-hot', !!slug);
    paths.forEach(function (p) { p.el.classList.toggle('is-hot', !!slug && (p.from === slug || p.to === slug)); });
    Object.keys(nodes).forEach(function (k) {
      var linked = !!slug && k !== slug && paths.some(function (p) { return (p.from === slug && p.to === k) || (p.to === slug && p.from === k); });
      nodes[k].classList.toggle('is-hot', linked);
    });
  }
  Object.keys(nodes).forEach(function (k) {
    var n = nodes[k];
    n.addEventListener('mouseenter', function () { hot(k); });
    n.addEventListener('mouseleave', function () { hot(null); });
    n.addEventListener('focus', function () { hot(k); });
    n.addEventListener('blur', function () { hot(null); });
  });

  draw();
  if ('ResizeObserver' in window) new ResizeObserver(draw).observe(g); else window.addEventListener('resize', draw);
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(draw);
  if (BDH.reduced) { g.classList.add('is-drawn'); return; }
  BDH.live(g, 0.2);
  BDH.inView(g, function () { g.classList.add('is-drawn'); }, { threshold: 0.3 });
})();
