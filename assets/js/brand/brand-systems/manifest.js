/* Brand Systems · 03 manifest — install print-out, dependency arcs, select to trace. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var box = document.querySelector('[data-cbs-mf]'); if (!box) return;
  var rows = BDH.$$('[data-cbs-mf-row]', box);
  var svg = box.querySelector('[data-cbs-mf-arcs]');
  var NS = 'http://www.w3.org/2000/svg';
  var deps = rows.map(function (r) { var d = r.getAttribute('data-deps'); return d ? d.split(',').map(Number) : []; });
  var paths = [];   // {from, to, el}

  function draw() {
    if (!svg || getComputedStyle(svg).display === 'none') return;
    var wrap = svg.parentNode, top = wrap.getBoundingClientRect().top;
    var gut = parseFloat(getComputedStyle(box).getPropertyValue('--cbs-mf-gut')) || 110;
    var x = gut - 26;
    var ys = rows.map(function (r) { var n = r.querySelector('[data-cbs-mf-node]'); var b = n.getBoundingClientRect(); return b.top - top + b.height / 2; });
    svg.setAttribute('viewBox', '0 0 ' + gut + ' ' + wrap.offsetHeight);
    var sel = paths.filter(function (p) { return p.el.classList.contains('is-on'); }).map(function (p) { return p.from + '-' + p.to; });
    while (svg.firstChild) svg.removeChild(svg.firstChild);
    paths = [];
    deps.forEach(function (list, i) {
      list.forEach(function (j) {
        var reach = Math.min(x - 6, 14 + (i - j) * 15);
        var p = document.createElementNS(NS, 'path');
        p.setAttribute('d', 'M' + x + ' ' + ys[i] + ' C ' + (x - reach) + ' ' + ys[i] + ' ' + (x - reach) + ' ' + ys[j] + ' ' + x + ' ' + ys[j]);
        if (sel.indexOf(i + '-' + j) > -1) p.classList.add('is-on');
        svg.appendChild(p);
        paths.push({ from: i, to: j, el: p });
      });
    });
  }

  function select(i) {
    rows.forEach(function (r, n) {
      r.classList.toggle('is-sel', n === i);
      r.classList.toggle('is-dep', i > -1 && deps[i].indexOf(n) > -1);
      r.querySelector('.cbs-mf__pick').setAttribute('aria-pressed', String(n === i));
    });
    box.classList.toggle('has-sel', i > -1);
    paths.forEach(function (p) { p.el.classList.toggle('is-on', p.from === i); });
  }

  var cur = -1;
  rows.forEach(function (r, n) {
    var b = r.querySelector('.cbs-mf__pick');
    b.addEventListener('click', function () { cur = cur === n ? -1 : n; select(cur); });
  });

  draw();
  if ('ResizeObserver' in window) new ResizeObserver(function () { draw(); }).observe(svg.parentNode);
  else window.addEventListener('resize', draw);
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(draw);

  if (BDH.reduced) { rows.forEach(function (r) { r.classList.add('is-in'); }); box.classList.add('is-drawn'); return; }

  /* on entry: print the install, draw the arcs, then trace packages until the visitor picks one */
  BDH.live(box, 0.1);
  BDH.inView(box, function () {
    rows.forEach(function (r, n) { setTimeout(function () { r.classList.add('is-in'); }, 250 + n * 260); });
    setTimeout(function () { box.classList.add('is-drawn'); }, 400);
    var order = [5, 2, 4, 3, 1];
    var k = 0;
    var auto = BDH.loop(box, 2600, function () { cur = order[k % order.length]; k++; select(cur); });
    BDH.onInteract(box, function () { auto.stop(); });
  });
})();
