/* AI Strategy & Agents · pace — the stopwatch steps through the five milestones while on screen
   (ring, face, rail and pane move together; the ring is to scale: 56 ticks, one per day); the model-swap card flips when production is reached.
   Buttons and the rail take over on first touch. Reduced motion: the finished state, controls work. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var pc = document.querySelector('[data-tas-pc]'); if (!pc) return;
  var ms = BDH.$$('.tas-pc__m', pc), panes = BDH.$$('.tas-pc__pane', pc), ring = pc.querySelector('.tas-pc__ring');
  var unit = pc.querySelector('[data-pc-unit]'), num = pc.querySelector('[data-pc-num]'), name = pc.querySelector('[data-pc-name]');
  var swap = pc.querySelector('[data-pc-swap]'), auto = pc.querySelector('[data-pc-auto]');
  var N = ms.length, cur = +pc.getAttribute('data-at') || 0, run = null, manual = false;

  function txt(el, t) {
    if (!el || el.textContent === t) return;
    el.textContent = t;
    if (BDH.reduced) return;
    el.classList.remove('is-swap'); void el.offsetWidth; el.classList.add('is-swap');
  }
  function show(i) {
    cur = ((i % N) + N) % N;
    pc.setAttribute('data-at', String(cur));
    var day = +ms[cur].getAttribute('data-day') || 0, last = +ms[N - 1].getAttribute('data-day') || 1;
    if (ring) ring.style.setProperty('--p', Math.max(0.012, day / last).toFixed(3));   /* the ring is drawn to scale in days */
    ms.forEach(function (b, k) { b.setAttribute('aria-pressed', k === cur ? 'true' : 'false'); b.classList.toggle('is-past', k < cur); });
    panes.forEach(function (p, k) { p.classList.toggle('is-on', k === cur); });
    var lbl = ms[cur].querySelector('.tas-pc__ml').textContent.trim().split(' ');
    txt(unit, lbl[0]); txt(num, lbl.slice(1).join(' ')); txt(name, ms[cur].querySelector('.tas-pc__mn').textContent);
    if (swap) swap.classList.toggle('is-flipped', cur === N - 1);
  }
  function takeOver() {
    if (manual) return;
    manual = true;
    if (run) run.stop();
    if (auto) { auto.querySelector('span').textContent = 'Your controls'; auto.querySelector('.tas-led').classList.add('tas-led--off'); }
  }
  ms.forEach(function (b, k) {
    b.addEventListener('click', function () { takeOver(); show(k); });
    b.addEventListener('keydown', function (e) {
      var d = e.key === 'ArrowRight' || e.key === 'ArrowDown' ? 1 : e.key === 'ArrowLeft' || e.key === 'ArrowUp' ? -1 : 0;
      if (!d) return; e.preventDefault(); takeOver(); show(cur + d); ms[cur].focus();
    });
  });
  BDH.$$('[data-pc-go]', pc).forEach(function (b) { b.addEventListener('click', function () { takeOver(); show(cur + (+b.getAttribute('data-pc-go'))); }); });

  if (BDH.reduced) { show(cur); if (auto) auto.hidden = true; return; }
  show(cur);
  BDH.live(pc, 0.1);
  BDH.inView(pc, function () {
    if (manual) return;
    show(0);
    run = BDH.loop(pc, 2800, function () { show(cur + 1); });
  }, { threshold: 0.05, rootMargin: '0px 0px -20% 0px' });
})();
