/* Signal → shipped: stepper, prev/next, play/pause and ← → keys drive one canvas and the assumption tracker. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.pxh-sig'); if (!root) return;
  var dataEl = root.querySelector('.pxh-sig__data'); if (!dataEl) return;
  var S; try { S = JSON.parse(dataEl.textContent); } catch (e) { return; }
  var steps = [].slice.call(root.querySelectorAll('.pxh-sig__step'));
  var rows = [].slice.call(root.querySelectorAll('.pxh-as__r'));
  var play = root.querySelector('[data-act="play"]');
  var cur = S.length - 1, timer = null, playing = false;

  function bind(k, v) { [].forEach.call(root.querySelectorAll('[data-bind="' + k + '"]'), function (el) { el.textContent = v; }); }
  function show(i) {
    i = (i + S.length) % S.length;
    var st = S[i]; cur = i;
    root.setAttribute('data-stage', i);
    steps.forEach(function (b, j) { if (j === i) b.setAttribute('aria-current', 'step'); else b.removeAttribute('aria-current'); });
    bind('name', st.name); bind('num', '0' + (i + 1)); bind('method', st.method); bind('title', st.title);
    bind('did', st.did); bind('strip', st.strip); bind('risk', st.risk + '%');
    var rv = root.querySelector('[data-bind-v="risk"]'); if (rv) rv.style.setProperty('--v', st.risk + '%');
    rows.forEach(function (r, j) {
      var a = st.asm[j], pill = r.querySelector('.pxh-st'), bar = r.querySelector('.pxh-bar i'), ev = r.querySelector('.pxh-as__e');
      if (pill.getAttribute('data-st') !== a[0]) { r.classList.remove('is-flash'); void r.offsetWidth; if (!BDH.reduced) r.classList.add('is-flash'); }
      pill.setAttribute('data-st', a[0]); pill.textContent = a[0];
      bar.style.setProperty('--v', a[1] + '%'); ev.textContent = a[2];
    });
  }
  function stop() { playing = false; clearInterval(timer); timer = null; play.setAttribute('aria-pressed', 'false'); play.setAttribute('aria-label', 'Play through the stages'); }
  function start() {
    if (BDH.reduced) return;
    playing = true; play.setAttribute('aria-pressed', 'true'); play.setAttribute('aria-label', 'Pause');
    clearInterval(timer);
    timer = setInterval(function () { if (cur === S.length - 1) { stop(); return; } show(cur + 1); }, 4200);
  }
  steps.forEach(function (b, j) { b.addEventListener('click', function () { stop(); show(j); }); });
  root.querySelector('[data-act="prev"]').addEventListener('click', function () { stop(); show(cur - 1); });
  root.querySelector('[data-act="next"]').addEventListener('click', function () { stop(); show(cur + 1); });
  play.addEventListener('click', function () { if (playing) { stop(); } else { if (cur === S.length - 1) show(0); start(); } });
  root.addEventListener('keydown', function (e) {
    if (!e.target.closest('.pxh-sig__nav')) return;
    if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
      e.preventDefault(); stop(); show(cur + (e.key === 'ArrowRight' ? 1 : -1));
      if (e.target.classList.contains('pxh-sig__step')) steps[cur].focus();
    }
  });
  if (BDH.reduced) { play.hidden = true; return; }
  /* first time on screen: rewind to the first signal and play once through; loops stop off screen */
  var started = false;
  BDH.live(root, 0.35, function (on) {
    root.classList.toggle('is-live', on);
    if (on && !started) { started = true; show(0); start(); }
    else if (!on && playing) { stop(); }
  });
})();
