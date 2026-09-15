/* 5 · Lockup builder — radiogroup (arrow keys, roving tabindex) swaps relationship, lockup text,
   annotations and rules. Cycles gently until the first interaction; reduced motion stays still. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var app = document.querySelector('[data-cba-lock]');
  var raw = document.getElementById('lockup-data');
  if (!app || !raw) return;
  var D; try { D = JSON.parse(raw.textContent); } catch (e) { return; }
  var opts = BDH.$$('[role="radio"]', app);
  var TEXT = {
    end: ['Sub-brand A', 'by Your brand'],
    co: ['Your brand', 'Brand B'],
    desc: ['Your brand', 'Product C'],
    solo: ['Brand N', '']
  };
  var cur = 0;
  function all(k) { return BDH.$$('[data-l="' + k + '"]', app); }
  function set(k, v) { all(k).forEach(function (n) { n.textContent = v; }); }

  function show(i, focus) {
    cur = (i + opts.length) % opts.length;
    var r = D[cur], key = r[0];
    app.setAttribute('data-rel', key);
    opts.forEach(function (o, n) {
      o.setAttribute('aria-checked', n === cur ? 'true' : 'false');
      o.tabIndex = n === cur ? 0 : -1;
    });
    if (focus) opts[cur].focus();
    set('a', TEXT[key][0]); set('b', TEXT[key][1]);
    set('name', r[1]); set('name2', r[1]);
    set('ratio', r[2]); set('ratio2', r[2]); set('clear', r[3]); set('min', r[4]); set('never', r[6]);
    var list = app.querySelector('[data-l="rules"]');
    list.textContent = '';
    r[5].forEach(function (t) { var li = document.createElement('li'); li.textContent = t; list.appendChild(li); });
    if (!BDH.reduced) { app.classList.remove('is-swap'); void app.offsetWidth; app.classList.add('is-swap'); }
  }

  opts.forEach(function (o, n) {
    o.addEventListener('click', function () { stop(); show(n); });
    o.addEventListener('keydown', function (e) {
      var k = e.key;
      if (k === 'ArrowRight' || k === 'ArrowDown') { e.preventDefault(); stop(); show(cur + 1, true); }
      else if (k === 'ArrowLeft' || k === 'ArrowUp') { e.preventDefault(); stop(); show(cur - 1, true); }
      else if (k === 'Home') { e.preventDefault(); stop(); show(0, true); }
      else if (k === 'End') { e.preventDefault(); stop(); show(opts.length - 1, true); }
    });
  });

  var timer = BDH.loop(app, 3600, function () { show(cur + 1); });
  function stop() { if (timer) { timer.stop(); timer = null; } }
  BDH.onInteract(app, stop);
})();
