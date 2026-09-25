/* Hub · ai-native — the agent run as a transport control. Previous, play and next step through seven
   steps; each step header is also a button that opens its own step. The collapsed layout only exists once
   JavaScript is running: .is-run is added here, so with JavaScript off all seven steps are open and the
   whole run is readable. Autoplay never starts under reduced motion and stops on the first interaction. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.mth-ai__run');
  if (!root) return;

  var steps = BDH.$$('.mth-ai__step', root);
  var heads = BDH.$$('.mth-ai__sb', root);
  var pos = BDH.$('[data-pos]', root);
  var prev = BDH.$('[data-act="prev"]', root);
  var next = BDH.$('[data-act="next"]', root);
  var play = BDH.$('[data-act="play"]', root);
  var playT = BDH.$('.mth-ai__cbt', root);
  if (steps.length < 2) return;

  root.classList.add('is-run');
  var cur = 0, timer = null;

  function show(i, focus) {
    i = (i % steps.length + steps.length) % steps.length;
    cur = i;
    steps.forEach(function (s, n) { s.classList.toggle('is-on', n === i); });
    heads.forEach(function (h, n) { h.setAttribute('aria-expanded', n === i ? 'true' : 'false'); });
    if (pos) pos.textContent = String(i + 1);
    if (focus) heads[i].focus();
  }

  function stop() {
    if (timer) { timer.stop(); timer = null; }
    if (play) play.setAttribute('aria-pressed', 'false');
    if (playT) playT.textContent = 'Play the run';
  }

  function start() {
    if (BDH.reduced || timer) return;
    if (play) play.setAttribute('aria-pressed', 'true');
    if (playT) playT.textContent = 'Pause the run';
    timer = BDH.loop(root, 2400, function () {
      if (cur === steps.length - 1) { show(0); return; }
      show(cur + 1);
    });
  }

  heads.forEach(function (h, n) {
    h.addEventListener('click', function () { stop(); show(n); });
  });
  if (prev) prev.addEventListener('click', function () { stop(); show(cur - 1); });
  if (next) next.addEventListener('click', function () { stop(); show(cur + 1); });
  if (play) {
    play.addEventListener('click', function () {
      if (timer) stop(); else start();
    });
  }
  show(0);

  /* play once, on its own, the first time the run comes on screen — then leave it to the reader */
  if (BDH.reduced) return;
  BDH.inView(root, function () {
    setTimeout(start, 600);
    BDH.onInteract(root, stop);
  }, { threshold: 0.25 });
})();
