/* Hub · studio — the Journey Studio. A real radiogroup of five lifecycle moments: click, arrow keys,
   Home and End, Space and Enter. Selecting a moment swaps the pane, redraws the happy path, runs a packet
   along it pulsing each node it reaches, and types the run log. It steps through the moments on a slow
   cycle until the first interaction, then stops for good.
   The markup already holds all five journeys with the first one shown, so nothing here is needed for the
   section to read. Under reduced motion there is no autoplay, no packet and the log is written at once. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.mth-stu');
  if (!root) return;

  var radios = BDH.$$('.mth-stu__moment', root);
  var panes = BDH.$$('.mth-stu__pane', root);
  var live = BDH.$('.mth-stu__live', root);
  var stxt = BDH.$('.mth-stu__stxt', root);
  if (!radios.length || radios.length !== panes.length) return;

  var cur = 0, readyT = null, hitT = [], logT = [];

  function paint(i) {
    radios.forEach(function (r, n) {
      r.setAttribute('aria-checked', n === i ? 'true' : 'false');
      r.tabIndex = n === i ? 0 : -1;
    });
  }

  /* the run log: one line at a time, each typed */
  function writeLog(pane, i) {
    var ol = pane.querySelector('.mth-stu__log');
    if (!ol) return;
    var lines = [];
    try { lines = JSON.parse(pane.getAttribute('data-log') || '[]'); } catch (err) { lines = []; }
    if (!lines.length) return;
    logT.forEach(function (t) { if (t && t.stop) t.stop(); else clearTimeout(t); });
    logT = [];
    ol.innerHTML = '';
    var spans = lines.map(function (ln) {
      var li = document.createElement('li');
      var b = document.createElement('b');
      var sp = document.createElement('span');
      b.textContent = ln[0];
      li.appendChild(b);
      li.appendChild(sp);
      if (!BDH.reduced) li.style.visibility = 'hidden';
      ol.appendChild(li);
      return sp;
    });
    if (BDH.reduced) {
      spans.forEach(function (sp, n) { sp.textContent = lines[n][1]; });
      return;
    }
    var n = 0;
    (function next() {
      if (n >= spans.length) return;
      var sp = spans[n], li = sp.parentNode;
      li.style.visibility = '';
      li.classList.add('is-typing');
      var t = BDH.type(sp, lines[n][1], { speed: 8, done: function () {
        li.classList.remove('is-typing');
        n++;
        logT.push(setTimeout(next, 80));
      } });
      logT.push(t);
    })();
  }

  /* the packet runs the happy path and each node on it lights as the packet arrives */
  var DUR = 2600;
  function run(i) {
    if (BDH.reduced || !root.classList.contains('is-live')) return;
    var pane = panes[i];
    var pk = pane.querySelector('.mth-stu__pk');
    var path = pane.querySelector('.mth-stu__path');
    var lit = BDH.$$('.mth-node--on', pane);
    if (!pk || !pk.animate) return;
    hitT.forEach(clearTimeout);
    hitT = [];
    if (path && path.animate) {
      path.animate([{ strokeDashoffset: 1 }, { strokeDashoffset: 0 }], { duration: 900, easing: 'cubic-bezier(.22,1,.36,1)' });
    }
    pk.animate([
      { strokeDashoffset: 0, opacity: 0 },
      { opacity: 1, offset: 0.05 },
      { opacity: 1, offset: 0.95 },
      { strokeDashoffset: -0.999, opacity: 0 }
    ], { duration: DUR, easing: 'linear' });
    lit.forEach(function (nd, j) {
      hitT.push(setTimeout(function () {
        nd.classList.add('is-hit');
        hitT.push(setTimeout(function () { nd.classList.remove('is-hit'); }, 540));
      }, lit.length > 1 ? (j / (lit.length - 1)) * (DUR - 400) : 0));
    });
  }

  function select(i, focus) {
    i = (i % radios.length + radios.length) % radios.length;
    paint(i);
    if (focus) radios[i].focus();
    if (i === cur) return;
    cur = i;
    root.setAttribute('data-moment', String(i));
    panes.forEach(function (p, n) { p.classList.toggle('is-on', n === i); });
    if (live) live.textContent = 'Journey: ' + panes[i].getAttribute('data-summary');
    writeLog(panes[i], i);
    if (BDH.reduced) return;
    root.classList.add('is-busy');
    if (stxt) stxt.textContent = 'Drawing journey';
    clearTimeout(readyT);
    readyT = setTimeout(function () {
      root.classList.remove('is-busy');
      if (stxt) stxt.textContent = 'Journey ready';
      run(cur);
    }, 950);
  }

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

  if (BDH.reduced) return;

  /* run the visible journey again every few seconds while the studio is on screen */
  BDH.loop(root, 5200, function () { run(cur); });
  BDH.watch(root, function (on) { if (on) run(cur); });

  var steps = [];
  for (var s = 1; s <= radios.length; s++) {
    (function (g) { steps.push([7600, function () { select(g % radios.length); }]); })(s);
  }
  BDH.seq(root, steps, { loop: true, stopOnInteract: true });
})();
