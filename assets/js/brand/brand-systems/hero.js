/* Brand Systems · hero — a token edit propagates token → component → template → channel. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cbs-pipe]'); if (!root) return;
  if (BDH.reduced) return;   // resting HTML is the complete, in-sync state

  var cols = BDH.$$('[data-cbs-pipe-col]', root);
  var links = BDH.$$('[data-cbs-pipe-link]', root);
  var status = root.querySelector('[data-cbs-pipe-status]');
  var ver = document.querySelector('[data-cbs-hero-ver]');
  var rows = {};
  BDH.$$('[data-cbs-tok]', root).forEach(function (li) { rows[li.getAttribute('data-cbs-tok')] = li; });

  var edits = [
    { k: 'p', v: '#19191D', css: ['--cbs-p', 'var(--ink)'] },
    { k: 'r', v: '20px',    css: ['--cbs-r', '20px'] },
    { k: 'p', v: '#006CD0', css: ['--cbs-p', 'var(--blue-d)'] },
    { k: 'r', v: '3px',     css: ['--cbs-r', '3px'] },
    { k: 'p', v: '#0082FB', css: ['--cbs-p', 'var(--blue)'] },
    { k: 'r', v: '10px',    css: ['--cbs-r', '10px'] }
  ];
  var n = 0, patch = 0, timers = [];
  function later(ms, fn) { timers.push(setTimeout(fn, ms)); }
  function hash() { return '#' + Math.floor(Math.random() * 0xffffff).toString(16).padStart(6, '0'); }

  function stage(i, css) {
    var c = cols[i]; if (!c) return;
    c.classList.add('is-busy', 'is-hit');
    c.style.setProperty(css[0], css[1]);
    var h = c.querySelector('[data-cbs-pipe-hash]');
    later(420, function () { c.classList.remove('is-busy'); if (h) h.textContent = hash(); });
    later(900, function () { c.classList.remove('is-hit'); });
  }
  function go(i) {
    var l = links[i]; if (!l) return;
    l.classList.remove('is-go'); void l.offsetWidth; l.classList.add('is-go');
  }

  function tick() {
    var ed = edits[n % edits.length]; n++;
    var row = rows[ed.k];
    var name = row ? row.querySelector('code').textContent : 'token';
    if (row) { row.classList.add('is-edit'); row.querySelector('[data-cbs-tok-v]').textContent = ed.v; }
    if (status) status.textContent = name + ' → ' + ed.v + ' · propagating';
    stage(0, ed.css);
    later(300, function () { go(0); });
    later(850, function () { stage(1, ed.css); go(1); });
    later(1550, function () { stage(2, ed.css); go(2); });
    later(2250, function () { stage(3, ed.css); });
    later(2700, function () {
      patch++;
      var v = 'v2.4.' + patch;
      if (ver) { ver.textContent = v; ver.classList.remove('is-tick'); void ver.offsetWidth; ver.classList.add('is-tick'); }
      if (status) status.textContent = 'release ' + v + ' · 4 of 4 stages in sync';
      if (row) row.classList.remove('is-edit');
    });
  }

  BDH.loop(root, 4600, tick);
})();
