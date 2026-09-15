/* 01 Hero — pipeline board: counts tick, stages light up, log lines stream. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.cat-hero'); if (!root) return;
  var board = root.querySelector('.cat-board'); if (!board || BDH.reduced) return;

  var stages = BDH.$$('.cat-board__st', board);
  var counts = stages.map(function (s) { return s.querySelector('[data-cat-count]'); });
  var log = board.querySelector('[data-cat-log]');
  var runEl = board.querySelector('[data-cat-run]');
  var STAGE = { curate: 0, tune: 1, gen: 2, check: 3, queue: 4, review: 4, pub: 5 };
  var POOL = [ // PLACEHOLDER: illustrative log lines — confirm before launch
    ['gen', 'variant {r}-d · Product C · Market 07 · 9:16 · done 4.1s'],
    ['check', '{r}-d · colour ΔE 0.9 ✓  clear space ✓  tone 0.88 ✓  rights ✓'],
    ['queue', '{r}-d → review · owner: Brand lead'],
    ['curate', 'ref 2,4{n} added · studio 2 · rights: owned'],
    ['gen', 'variant {r}-e · Product C · Market 01 · 1:1 · done 3.2s'],
    ['check', '{r}-e · tone 0.64 below 0.80 ✕ · copy returned to assistant'],
    ['review', '{r}-b approved by Brand lead · crop adjusted'],
    ['pub', '{r}-b → 6 formats × 9 markets · credentials signed'],
    ['tune', 'eval v4.2 · brand fidelity 0.93 ≥ gate 0.90 · hold'],
    ['review', '{r}-f rejected by Market lead · wrong season'],
    ['gen', 'variant {r}-g · Product C · Market 05 · 4:5 · done 3.6s'],
    ['check', '{r}-g · logo clear space ✓  palette ✓  legal line ✓']
  ];
  var t = 9 * 3600 + 41 * 60 + 7, k = 0, run = 412, refs = 2418;

  function pad(n) { return (n < 10 ? '0' : '') + n; }
  function clock() { return pad(Math.floor(t / 3600)) + ':' + pad(Math.floor(t / 60) % 60) + ':' + pad(t % 60); }
  function num(el) { return parseInt(el.textContent.replace(/[^0-9]/g, ''), 10) || 0; }
  function setNum(el, v) { el.textContent = v.toLocaleString('en-GB'); }
  function light(i) { stages.forEach(function (s, j) { s.classList.toggle('is-on', j === i); }); }

  function tick() {
    t += 1 + Math.floor(Math.random() * 3);
    var p = POOL[k % POOL.length]; k++;
    if (k % POOL.length === 0) { run++; if (runEl) runEl.textContent = pad(0) + run; }
    var li = document.createElement('li');
    li.className = 'is-new';
    li.innerHTML = '<time></time><b></b><span></span>';
    li.children[0].textContent = clock();
    li.children[1].textContent = p[0];
    li.children[2].textContent = p[1].replace(/\{r\}/g, '0' + run).replace('{n}', pad(refs % 100));
    log.appendChild(li);
    while (log.children.length > 8) log.removeChild(log.firstElementChild);
    var s = STAGE[p[0]];
    light(s);
    if (p[0] === 'curate') { refs++; setNum(counts[0], refs); }
    if (p[0] === 'gen') setNum(counts[2], Math.max(120, num(counts[2]) + (Math.random() < .5 ? 3 : -2)));
    if (p[0] === 'check') setNum(counts[3], num(counts[3]) + 1);
    if (p[0] === 'queue') setNum(counts[4], num(counts[4]) + 1);
    if (p[0] === 'review') setNum(counts[4], Math.max(4, num(counts[4]) - 1));
    if (p[0] === 'pub') setNum(counts[5], num(counts[5]) + 6);
  }

  light(2);
  BDH.loop(board, 1500, tick);
})();
