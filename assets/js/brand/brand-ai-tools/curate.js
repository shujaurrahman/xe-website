/* 03 Training set curator — approve / reject (buttons or A / R / U on a focused tile),
   live recount. Autoplays a reviewer working through the batch until first interaction. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.cat-cur'); if (!root) return;
  var ui = root.querySelector('.cat-cur__ui');
  var tiles = BDH.$$('.cat-cur__tile', root);
  var BASE = 2413; // PLACEHOLDER: illustrative set size before this batch — confirm before launch

  function recount() {
    var a = 0, r = 0, p = 0, cats = {}, why = {};
    tiles.forEach(function (t) {
      var s = t.getAttribute('data-state'), c = t.getAttribute('data-cat');
      cats[c] = cats[c] || [0, 0]; cats[c][1]++;
      if (s === 'approved') { a++; cats[c][0]++; }
      else if (s === 'rejected') { r++; var w = t.getAttribute('data-reason') || 'Off palette'; why[w] = (why[w] || 0) + 1; }
      else p++;
    });
    var q = function (k) { return root.querySelector('[data-cur-n="' + k + '"]'); };
    q('approved').textContent = a; q('rejected').textContent = r;
    q('set').textContent = (BASE + a).toLocaleString('en-GB');
    root.querySelector('[data-cur-left]').textContent = p;
    BDH.$$('[data-cur-cat]', root).forEach(function (li) {
      var v = cats[li.getAttribute('data-cur-cat')] || [0, 0];
      li.querySelector('b').style.setProperty('--v', v[1] ? v[0] / v[1] : 0);
      li.querySelector('em').textContent = v[0] + '/' + v[1];
    });
    BDH.$$('[data-cur-why]', root).forEach(function (li) {
      var n = why[li.getAttribute('data-cur-why')] || 0;
      li.querySelector('em').textContent = n; li.classList.toggle('is-hit', n > 0);
    });
  }

  function set(t, state, anim) {
    if (state === 'rejected' && t.getAttribute('data-verdict') === 'approve' && !t.getAttribute('data-reason')) t.setAttribute('data-reason', 'Off palette');
    t.setAttribute('data-state', state);
    BDH.$$('.cat-cur__btn', t).forEach(function (b) {
      var mine = b.getAttribute('data-act') === 'approve' ? 'approved' : 'rejected';
      b.setAttribute('aria-pressed', mine === state ? 'true' : 'false');
    });
    if (anim && !BDH.reduced) { t.classList.remove('is-stamp'); void t.offsetWidth; t.classList.add('is-stamp'); }
    recount();
  }

  tiles.forEach(function (t) {
    BDH.$$('.cat-cur__btn', t).forEach(function (b) {
      b.addEventListener('click', function () {
        var want = b.getAttribute('data-act') === 'approve' ? 'approved' : 'rejected';
        set(t, t.getAttribute('data-state') === want ? 'pending' : want, true);
      });
    });
    t.addEventListener('keydown', function (e) {
      if (e.altKey || e.ctrlKey || e.metaKey) return;
      var k = e.key.toLowerCase();
      if (k === 'a') set(t, 'approved', true);
      else if (k === 'r') set(t, 'rejected', true);
      else if (k === 'u') set(t, 'pending', true);
      else return;
      e.preventDefault();
    });
  });

  recount();
  if (BDH.reduced) return;

  function focusOn(i) { tiles.forEach(function (t, j) { t.classList.toggle('is-focus', j === i); }); }
  var steps = [[500, function () { tiles.forEach(function (t) { set(t, 'pending'); }); focusOn(-1); }]];
  tiles.forEach(function (t, i) {
    steps.push([850, function () { focusOn(i); }]);
    steps.push([650, function () { set(t, t.getAttribute('data-verdict') === 'approve' ? 'approved' : 'rejected', true); }]);
  });
  steps.push([400, function () { focusOn(-1); }]);
  steps.push([3200, function () {}]);

  BDH.inView(ui, function () {
    BDH.seq(ui, steps, { loop: true, stopOnInteract: true, interactRoot: ui, onStop: function () { focusOn(-1); } });
  });
})();
