/* AI Product & Automation · stack — a packet travels the rail while the window is on screen, lighting each
   stage column in turn (loops until the first interaction, then every stage shows as done). The
   "Self-hosted only" switch dims hosted-API tools, swaps each stage readout and is announced politely.
   Under 700 px a stage picker (aria-pressed buttons) shows one stage at a time.
   Reduced motion: no packet, no loop; the switch still works. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tap-stk'); if (!root) return;
  var R = BDH.reduced;
  var cols = BDH.$$('.tap-stk__col', root);
  var nodes = BDH.$$('.tap-stk__node', root);
  var pk = root.querySelector('.tap-stk__pk');
  var sw = root.querySelector('[data-stk-self]');
  var mode = root.querySelector('[data-stk-mode]');
  var live = root.querySelector('[data-stk-live]');
  var cur = -1, run = null;

  function paint(i) {
    cols.forEach(function (c, k) { c.classList.toggle('is-on', k === i); c.classList.toggle('is-done', i > -1 && k < i); });
    nodes.forEach(function (n, k) { n.classList.toggle('is-on', k === i); n.classList.toggle('is-done', i > -1 && k < i); });
    if (pk) pk.style.setProperty('--s', String(Math.max(0, i)));
  }
  function all() {
    cols.forEach(function (c) { c.classList.remove('is-on'); c.classList.add('is-done'); });
    nodes.forEach(function (n) { n.classList.remove('is-on'); n.classList.add('is-done'); });
    if (pk) pk.style.opacity = '0';
  }

  if (sw) {
    sw.addEventListener('click', function () {
      var on = sw.getAttribute('aria-pressed') !== 'true';
      sw.setAttribute('aria-pressed', String(on));
      root.classList.toggle('is-self', on);
      BDH.$$('[data-stk-api]', root).forEach(function (el) { el.hidden = on; });
      BDH.$$('[data-stk-selfro]', root).forEach(function (el) { el.hidden = !on; });
      if (mode) mode.textContent = on ? 'self-hosted only' : 'hosted + self-hosted';
      if (live) live.textContent = on
        ? 'Self-hosted only. Hosted API tools are dimmed; open-weight models run with vLLM on your GPUs and every stage stays inside your network.'
        : 'Hosted and self-hosted options shown together.';
    });
  }

  /* phone: stage picker (aria-pressed buttons); CSS shows only .is-sel once .has-pick is set */
  var picks = BDH.$$('[data-stk-pick]', root);
  if (picks.length) {
    root.classList.add('has-pick');
    picks.forEach(function (b) {
      b.addEventListener('click', function () {
        var k = parseInt(b.getAttribute('data-stk-pick'), 10);
        picks.forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
        cols.forEach(function (c, n) { c.classList.toggle('is-sel', n === k); });
      });
    });
  }

  if (R) return;
  var touched = false;
  BDH.live(root, 0.2);
  BDH.inView(root, function () {
    if (touched) return;
    run = BDH.loop(root, 1500, function () { cur = (cur + 1) % cols.length; paint(cur); });
    paint(0); cur = 0;
  }, { threshold: 0.25 });
  BDH.onInteract(root, function () { touched = true; if (run) run.stop(); all(); });
})();
