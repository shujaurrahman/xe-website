/* AI Strategy & Agents · anatomy — the loop turns while on screen: the orbit dot circles once every
   nine seconds and the phase (plan → act → observe) advances every three, lighting its arc and the
   slots that belong to it. The legend buttons pick a phase by hand and stop the cycle.
   Reduced motion: the finished diagram at "act"; the legend still works. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-tas-an]'); if (!root) return;
  var phEl = root.querySelector('[data-an-ph]'), roEl = root.querySelector('[data-an-ro]'), pdEl = root.querySelector('[data-an-pd]');
  var btns = BDH.$$('.tas-an__lg', root), orbit = root.querySelector('.tas-an__orbit');
  var PH = btns.map(function (b) { return { k: b.getAttribute('data-p'), n: b.querySelector('b').textContent, r: b.getAttribute('data-ro') || b.querySelector('span').textContent, d: b.querySelector('span').textContent }; });
  var DEG = { plan: 63, act: 183, observe: 303 };
  var at = Math.max(0, PH.findIndex(function (p) { return p.k === root.getAttribute('data-phase'); }));
  var timer = null, manual = false;

  function swap(el, t) {
    if (!el) return;
    el.textContent = t;
    if (BDH.reduced) return;
    el.classList.remove('is-swap'); void el.offsetWidth; el.classList.add('is-swap');
  }
  function set(i) {
    at = ((i % PH.length) + PH.length) % PH.length;
    var p = PH[at];
    root.setAttribute('data-phase', p.k);
    if (orbit) orbit.style.setProperty('--deg', (DEG[p.k] || 0) + 'deg');
    btns.forEach(function (b, n) { b.setAttribute('aria-pressed', n === at ? 'true' : 'false'); });
    swap(phEl, p.n); swap(roEl, p.r); swap(pdEl, p.d);
  }
  function stopAuto() { if (timer) { clearInterval(timer); timer = null; } }

  btns.forEach(function (b, n) {
    b.addEventListener('click', function () { manual = true; root.classList.add('is-manual'); stopAuto(); set(n); });
    b.addEventListener('keydown', function (e) {
      var d = e.key === 'ArrowRight' || e.key === 'ArrowDown' ? 1 : e.key === 'ArrowLeft' || e.key === 'ArrowUp' ? -1 : 0;
      if (!d) return;
      e.preventDefault(); manual = true; root.classList.add('is-manual'); stopAuto(); set(at + d); btns[at].focus();
    });
  });

  if (BDH.reduced) { set(at); return; }

  /* the orbit animation restarts from the top whenever .is-live is added, so the phase restarts too */
  BDH.live(root, 0.08, function (on) {
    stopAuto();
    if (!on || manual) return;
    set(0);
    timer = setInterval(function () { set(at + 1); }, 3000);
  });
})();
