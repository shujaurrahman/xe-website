/* Growth Strategy · 09 KPI tree — draws elbow wires between nodes (redrawn on resize), and a click on any
   node opens its definition in the reader and lights the path back to the north star. Arrow keys move
   between nodes. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cgs-kpi]'); if (!root) return;
  var tree = JSON.parse(root.getAttribute('data-tree'));
  var box = root.querySelector('.cgs-kp__tree'), g = root.querySelector('[data-cgs-wires]');
  var nodes = BDH.$$('[data-cgs-node]', root);
  var read = root.querySelector('.cgs-kp__read');
  var f = { k: '[data-cgs-rk]', t: '[data-cgs-rt]', d: '[data-cgs-rd]', 2: '[data-cgs-r2]', 3: '[data-cgs-r3]', 4: '[data-cgs-r4]', 5: '[data-cgs-r5]' };
  Object.keys(f).forEach(function (k) { f[k] = read.querySelector(f[k]); });
  var NS = 'http://www.w3.org/2000/svg', cur = 's';
  var byId = {}; nodes.forEach(function (n) { byId[n.getAttribute('data-cgs-node')] = n; });

  function data(id) {
    if (id === 's') return ['North star', tree.star];
    var m = id.match(/^d(\d)(?:l(\d))?$/); var dv = tree.drivers[+m[1]];
    return m[2] == null ? ['Driver', dv] : ['Leading indicator', dv[6][+m[2]]];
  }
  function parents(id) { var m = id.match(/^d(\d)l\d$/); return m ? ['s', 'd' + m[1], id] : id === 's' ? ['s'] : ['s', id]; }

  function wires() {
    while (g.firstChild) g.removeChild(g.firstChild);
    if (window.matchMedia('(max-width:760px)').matches) return;
    var o = box.getBoundingClientRect(), path = parents(cur);
    function r(el) { var b = el.getBoundingClientRect(); return { x: b.left - o.left, y: b.top - o.top, w: b.width, h: b.height }; }
    function add(d, on) { var p = document.createElementNS(NS, 'path'); p.setAttribute('d', d); if (on) p.setAttribute('class', 'is-on'); g.appendChild(p); }
    var s = r(byId.s), sx = s.x + s.w / 2, sy = s.y + s.h;
    tree.drivers.forEach(function (dv, i) {
      var dEl = byId['d' + i], d = r(dEl), dx = d.x + d.w / 2, my = sy + (d.y - sy) / 2;
      add('M' + sx + ' ' + sy + 'V' + my + 'H' + dx + 'V' + d.y, path.indexOf('d' + i) > -1);
      dv[6].forEach(function (lf, j) {
        var l = r(byId['d' + i + 'l' + j]), x = d.x + 9;
        add('M' + x + ' ' + (d.y + d.h) + 'V' + (l.y + l.h / 2) + 'H' + l.x, path.indexOf('d' + i + 'l' + j) > -1);
      });
    });
  }

  function show(id, focus) {
    cur = id;
    var dt = data(id), n = dt[1];
    nodes.forEach(function (el) {
      var k = el.getAttribute('data-cgs-node');
      el.setAttribute('aria-pressed', k === id ? 'true' : 'false');
      el.classList.toggle('is-path', parents(id).indexOf(k) > -1 && k !== id);
    });
    f.k.textContent = dt[0]; f.t.textContent = n[0]; f.d.textContent = n[1];
    f[2].textContent = n[2]; f[3].textContent = n[3]; f[4].textContent = n[4]; f[5].textContent = n[5];
    read.classList.remove('is-swap'); void read.offsetWidth; read.classList.add('is-swap');
    wires();
    if (focus) byId[id].focus();
  }

  nodes.forEach(function (el, i) {
    el.addEventListener('click', function () { show(el.getAttribute('data-cgs-node')); });
    el.addEventListener('keydown', function (e) {
      var to = e.key === 'ArrowRight' || e.key === 'ArrowDown' ? i + 1 : e.key === 'ArrowLeft' || e.key === 'ArrowUp' ? i - 1 : null;
      if (to == null) return;
      e.preventDefault(); nodes[(to + nodes.length) % nodes.length].focus();
    });
  });
  var rt = 0;
  window.addEventListener('resize', function () { clearTimeout(rt); rt = setTimeout(wires, 120); });
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(wires);
  BDH.inView(box, wires);
  wires();
})();
