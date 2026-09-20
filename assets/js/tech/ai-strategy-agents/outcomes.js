/* AI Strategy & Agents · outcomes — the review switch: Agent A (stays at L3) or Agent B (goes back to
   L2). Switching re-scales each value bar, rewrites the value and status, and swaps the decision.
   On entry the bars grow and the statuses tick in order (CSS under .is-armed.is-in).
   Reduced motion: the finished review; the switch still works, without motion. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var oc = document.querySelector('[data-tas-oc]'); if (!oc) return;
  var data; try { data = JSON.parse(oc.getAttribute('data-oc') || '{}'); } catch (e) { return; }
  var btns = BDH.$$('[data-oc-agent]', oc), rows = BDH.$$('.tas-oc__row', oc);
  var WORD = { pass: 'Pass', watch: 'Watch', hold: 'Hold' };
  var LV = { 1: 'Suggest', 2: 'Draft', 3: 'Act with approval', 4: 'Act within limits' };
  var R = BDH.reduced;

  function f(k) { return oc.querySelector('[data-oc="' + k + '"]'); }
  function swap(el) { if (!el || R) return; el.classList.remove('is-swap'); void el.offsetWidth; el.classList.add('is-swap'); }
  function set(k, v) { var el = f(k); if (el && el.textContent !== v) { el.textContent = v; swap(el); } }

  function show(key) {
    var a = data[key]; if (!a) return;
    oc.setAttribute('data-agent', key);
    oc.classList.add('is-done');
    btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-oc-agent') === key ? 'true' : 'false'); });
    set('id', a.id); set('task', a.task); set('owner', a.owner); set('dec', a.dec); set('next', a.next);
    var lv = f('dlvl'), tag = lv ? lv.querySelector('.tas-lvl') : null;
    if (tag) {
      tag.setAttribute('data-l', a.dlvl);
      tag.querySelector('.tas-lvl__n').textContent = 'L' + a.dlvl + ' · ' + LV[a.dlvl];
      swap(lv);
    }
    rows.forEach(function (r) {
      var d = a.rows[r.getAttribute('data-row')]; if (!d) return;
      var changed = r.getAttribute('data-s') !== d.s;
      r.setAttribute('data-s', d.s);
      var bar = r.querySelector('.tas-oc__val'); if (bar) bar.style.setProperty('--p', (d.p / 100).toFixed(4));
      var v = r.querySelector('[data-oc-v]'); if (v && v.textContent !== d.t) { v.textContent = d.t; swap(v); }
      var pill = r.querySelector('[data-oc-s] span'); if (pill) pill.textContent = WORD[d.s];
      if (changed) swap(r);
    });
  }
  btns.forEach(function (b) { b.addEventListener('click', function () { show(b.getAttribute('data-oc-agent')); }); });

  if (R) return;
  oc.classList.add('is-armed');
  BDH.enter(oc, { delay: 150, io: { threshold: 0.05, rootMargin: '0px 0px -20% 0px' } });
})();
