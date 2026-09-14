/* Hub · global scale — wave control for the rollout matrix (autoplays until interaction) and the
   acquisition before/after (shows "before" briefly on first view, then settles on "after"). */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.bdh-global');
  if (!root) return;

  /* ---- rollout waves ---- */
  var matrix = BDH.$('.bdh-gl__matrix', root);
  if (matrix) {
    var waveBtns = BDH.$$('.bdh-gl__waves button', matrix);
    var dots = BDH.$$('tbody .bdh-gl__dot', matrix);
    var names = { plan: 'Planned', loc: 'Localising', live: 'Live' };
    var view = 3;
    var showWave = function (w) {
      view = w;
      matrix.setAttribute('data-view', String(w));
      waveBtns.forEach(function (b) { b.setAttribute('aria-pressed', parseInt(b.getAttribute('data-wave'), 10) === w ? 'true' : 'false'); });
      dots.forEach(function (d) {
        var live = parseInt(d.getAttribute('data-live'), 10);
        var s = w >= live ? 'live' : (w === live - 1 ? 'loc' : 'plan');
        d.className = 'bdh-gl__dot is-' + s;
        var sr = d.querySelector('.bdh-sr'); if (sr) sr.textContent = names[s];
      });
    };
    waveBtns.forEach(function (b) {
      b.addEventListener('click', function () { if (timer) timer.stop(); showWave(parseInt(b.getAttribute('data-wave'), 10)); });
    });
    var timer = null;
    if (!BDH.reduced) {
      BDH.inView(matrix, function () {
        showWave(1);
        timer = BDH.loop(matrix, 3200, function () { showWave(view % 3 + 1); });
        BDH.onInteract(matrix, function () { if (timer) timer.stop(); });
      }, { threshold: 0.35 });
    }
  }

  /* ---- acquisition before / after ---- */
  var acq = BDH.$('.bdh-gl__acq', root);
  if (acq) {
    var setBtns = BDH.$$('.bdh-seg button', acq);
    var set = function (s) {
      acq.setAttribute('data-state', s);
      setBtns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-set') === s ? 'true' : 'false'); });
    };
    var used = false;
    setBtns.forEach(function (b) { b.addEventListener('click', function () { used = true; set(b.getAttribute('data-set')); }); });
    if (!BDH.reduced) {
      set('before');
      BDH.inView(acq, function () { setTimeout(function () { if (!used) set('after'); }, 1500); }, { threshold: 0.5 });
    }
  }
})();
