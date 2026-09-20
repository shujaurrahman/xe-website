/* Hub · composer — the Platform Composer. A radiogroup of goals (arrow keys move and select, Home/End jump)
   switches the plan pane, lights the involved capabilities on the topology, numbers them in build order and
   redraws the build path; a packet then runs the path in order, pulsing each node as it passes. Autoplays
   through the goals until the first interaction. Reduced motion: instant switching, no path animation. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tih-cmp');
  if (!root) return;

  var radios = BDH.$$('.tih-cmp__goal', root);
  var panes = BDH.$$('.tih-cmp__pane', root);
  var nodes = BDH.$$('.tih-cmp__node', root);
  var path = BDH.$('.tih-cmp__path', root);
  var pk = BDH.$('.tih-cmp__pk', root);
  var live = BDH.$('.tih-cmp__live', root);
  var count = BDH.$('.tih-cmp__mc b', root);
  var stxt = BDH.$('.tih-cmp__stxt', root);
  var route = BDH.$('.tih-cmp__rtxt', root);
  var tl = BDH.$('.tih-cmp__tl', root);
  var tn = BDH.$('.tih-cmp__tn', root);
  var logTimers = [];
  if (!radios.length || !panes.length || !path) return;

  var cur = 0, readyT = null, hitT = [];
  var byN = {};
  nodes.forEach(function (nd) { byN[nd.getAttribute('data-n')] = nd; });

  function paint(i) {
    radios.forEach(function (r, n) {
      r.setAttribute('aria-checked', n === i ? 'true' : 'false');
      r.tabIndex = n === i ? 0 : -1;
    });
  }

  function select(i, focus) {
    i = (i % radios.length + radios.length) % radios.length;
    paint(i);
    if (focus) radios[i].focus();
    if (i === cur) return;
    cur = i;
    root.setAttribute('data-goal', String(i));
    var pane = panes[i];
    panes.forEach(function (p, n) { p.classList.toggle('is-on', n === i); });
    var order = pane.getAttribute('data-order').split(',');
    nodes.forEach(function (nd) {
      var k = order.indexOf(nd.getAttribute('data-n'));
      nd.classList.toggle('is-on', k > -1);
      nd.classList.toggle('is-dim', k === -1);
      nd.classList.remove('is-hit');
      var ord = nd.querySelector('.tih-cmp__ord');
      if (ord) ord.textContent = k > -1 ? String(k + 1) : '';
    });
    var d = pane.getAttribute('data-path');
    path.setAttribute('d', d);
    if (pk) pk.setAttribute('d', d);
    if (count) count.textContent = String(order.length);
    if (route) route.textContent = order.join(' \u2192 ');
    if (live) live.textContent = 'Plan: ' + pane.getAttribute('data-summary');
    writeLog(pane, i);
    if (!BDH.reduced) compose();
  }

  /* the compile log: each line is typed in turn (reduced motion: written at once) */
  function writeLog(pane, i) {
    if (!tl) return;
    var lines = [];
    try { lines = JSON.parse(pane.getAttribute('data-log') || '[]'); } catch (err) { lines = []; }
    logTimers.forEach(function (t) { if (t && t.stop) t.stop(); else clearTimeout(t); });
    logTimers = [];
    if (tn) tn.textContent = 'plan ' + (i + 1) + ' / ' + panes.length;
    tl.innerHTML = '';
    var spans = lines.map(function (ln) {
      var li = document.createElement('li'), b = document.createElement('b'), sp = document.createElement('span');
      b.textContent = ln[0]; li.appendChild(b); li.appendChild(sp);
      if (!BDH.reduced) li.style.visibility = 'hidden';
      tl.appendChild(li);
      return sp;
    });
    if (BDH.reduced) { spans.forEach(function (sp, n) { sp.textContent = lines[n][1]; }); return; }
    var n = 0;
    (function next() {
      if (n >= spans.length) return;
      var sp = spans[n], li = sp.parentNode, text = lines[n][1];
      li.style.visibility = '';
      li.classList.add('is-typing');
      var t = BDH.type(sp, text, { speed: 9, done: function () {
        li.classList.remove('is-typing');
        n++;
        logTimers.push(setTimeout(next, 90));
      } });
      logTimers.push(t);
    })();
  }

  function compose() {
    root.classList.add('is-busy');
    if (stxt) stxt.textContent = 'Composing plan';
    if (path.animate) path.animate([{ strokeDashoffset: 1 }, { strokeDashoffset: 0 }], { duration: 1100, easing: 'cubic-bezier(.22,1,.36,1)' });
    clearTimeout(readyT);
    readyT = setTimeout(function () {
      root.classList.remove('is-busy');
      if (stxt) stxt.textContent = 'Plan ready';
      run();
    }, 1150);
  }

  /* the packet follows the build order; each node pulses when the packet reaches it */
  var DUR = 2800;
  function run() {
    if (BDH.reduced || !pk || !pk.animate || !root.classList.contains('is-live')) return;
    var pane = panes[cur];
    var order = pane.getAttribute('data-order').split(',');
    /* where each node sits on the routed path, as a fraction of its length (written by the partial) */
    var stops = (pane.getAttribute('data-stops') || '').split(',').map(Number);
    if (stops.length !== order.length) {
      stops = order.map(function (n, j) { return order.length > 1 ? j / (order.length - 1) : 0; });
    }
    hitT.forEach(clearTimeout); hitT = [];
    pk.animate([
      { strokeDashoffset: 0, opacity: 0 },
      { opacity: 1, offset: 0.04 },
      { opacity: 1, offset: 0.96 },
      { strokeDashoffset: -0.999, opacity: 0 }
    ], { duration: DUR, easing: 'linear' });
    order.forEach(function (n, j) {
      var nd = byN[n];
      if (!nd) return;
      hitT.push(setTimeout(function () {
        nd.classList.add('is-hit');
        hitT.push(setTimeout(function () { nd.classList.remove('is-hit'); }, 520));
      }, Math.max(0, stops[j]) * DUR));
    });
  }
  BDH.loop(root, 4200, run);

  /* ---- radiogroup: click, arrows, Home / End ---- */
  radios.forEach(function (r, n) {
    r.addEventListener('click', function () { select(n); });
    r.addEventListener('keydown', function (e) {
      var k = e.key, j = -1;
      if (k === 'ArrowRight' || k === 'ArrowDown') j = n + 1;
      else if (k === 'ArrowLeft' || k === 'ArrowUp') j = n - 1;
      else if (k === 'Home') j = 0;
      else if (k === 'End') j = radios.length - 1;
      else if (k === ' ' || k === 'Enter') { e.preventDefault(); select(n); return; }
      if (j === -1) return;
      e.preventDefault();
      select(j, true);
    });
  });

  /* ---- autoplay through the goals until the reader interacts ---- */
  if (BDH.reduced) return;
  var steps = [];
  for (var s = 1; s <= radios.length; s++) {
    (function (g) { steps.push([7200, function () { select(g % radios.length); }]); })(s);
  }
  BDH.seq(root, steps, { loop: true, stopOnInteract: true });
})();
