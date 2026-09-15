/* 2 · Portfolio audit — node buttons fill the role card (click, focus, arrow keys). */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cba-audit]');
  var raw = document.getElementById('audit-data');
  if (!root || !raw) return;
  var data; try { data = JSON.parse(raw.textContent); } catch (e) { return; }
  var btns = BDH.$$('.cba-audit__node', root);
  var card = root.querySelector('.cba-audit__card');
  var f = function (k) { return card.querySelector('[data-f="' + k + '"]'); };
  var cur = 0;

  function show(i) {
    if (i === cur || !data[i]) return;
    cur = i;
    var d = data[i];
    btns.forEach(function (b, n) { b.classList.toggle('is-on', n === i); b.setAttribute('aria-pressed', n === i ? 'true' : 'false'); });
    f('name').textContent = d[0]; f('role').textContent = d[1];
    f('aw').textContent = d[2]; f('cl').textContent = d[3];
    f('sh').textContent = d[4] + '%'; f('co').textContent = d[5];
    f('find').textContent = d[6]; f('read').textContent = d[7];
    if (!BDH.reduced) { card.classList.remove('is-swap'); void card.offsetWidth; card.classList.add('is-swap'); }
  }

  btns.forEach(function (b, n) {
    b.addEventListener('click', function () { show(n); });
    b.addEventListener('focus', function () { show(n); });
    b.addEventListener('keydown', function (e) {
      var k = e.key, to = -1;
      if (k === 'ArrowRight' || k === 'ArrowDown') to = (n + 1) % btns.length;
      if (k === 'ArrowLeft' || k === 'ArrowUp') to = (n - 1 + btns.length) % btns.length;
      if (k === 'Home') to = 0;
      if (k === 'End') to = btns.length - 1;
      if (to > -1) { e.preventDefault(); btns[to].focus(); }
    });
  });
})();
