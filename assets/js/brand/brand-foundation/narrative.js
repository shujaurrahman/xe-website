/* §6 narrative — BDH.tabs segmented control. On wide screens the stage is held at the tallest length
   (no layout shift while it cycles); on narrow screens height follows the text and nothing autoplays. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cbf-nar]'); if (!root) return;
  var seg = root.querySelector('.cbf-nar__seg'), stage = root.querySelector('.cbf-nar__stage');
  var panes = BDH.$$('.cbf-nar__pane', root);
  var out = { words: root.querySelector('[data-nar="words"]'), secs: root.querySelector('[data-nar="secs"]'), use: root.querySelector('[data-nar="use"]') };
  var wide = window.matchMedia('(min-width:1025px)');
  var shown = +out.words.textContent || 0, raf = null;

  function tallest() {
    stage.style.minHeight = '';
    if (!wide.matches) return;
    var cur = panes.map(function (p) { return p.hidden; }), h = 0;
    panes.forEach(function (p) { p.hidden = false; p.style.position = 'absolute'; p.style.visibility = 'hidden'; });
    panes.forEach(function (p) { p.style.position = ''; p.hidden = false; });
    panes.forEach(function (p, i) { panes.forEach(function (q, j) { q.hidden = j !== i; }); h = Math.max(h, stage.offsetHeight); });
    panes.forEach(function (p, i) { p.hidden = cur[i]; p.style.visibility = ''; });
    stage.style.minHeight = h + 'px';
  }
  function tick(to) {
    if (raf) cancelAnimationFrame(raf);
    if (BDH.reduced) { out.words.textContent = to; shown = to; return; }
    var from = shown, t0 = performance.now();
    (function step(t) {
      var k = Math.min(1, (t - t0) / 600), v = Math.round(from + (to - from) * (1 - Math.pow(1 - k, 3)));
      out.words.textContent = v; shown = v;
      if (k < 1) raf = requestAnimationFrame(step);
    })(t0);
  }
  function change(i, prev) {
    var p = panes[i], before = stage.offsetHeight;
    seg.style.setProperty('--i', i);
    tick(+p.getAttribute('data-words'));
    out.secs.textContent = p.getAttribute('data-secs') + 's';
    out.use.textContent = p.getAttribute('data-use');
    if (BDH.reduced) return;
    p.classList.remove('is-flow'); p.offsetWidth; p.classList.add('is-flow');
    if (!wide.matches && typeof prev === 'number') {   // narrow: animate the height change
      var after = stage.offsetHeight;
      stage.style.height = before + 'px'; stage.offsetHeight; stage.style.height = after + 'px';
      setTimeout(function () { stage.style.height = ''; }, 650);
    }
  }

  var api = BDH.tabs(root, { tabs: '.cbf-nar__tab', auto: wide.matches ? 4800 : 0, onChange: change });
  seg.style.setProperty('--i', api.index());
  tallest();
  window.addEventListener('resize', function () { clearTimeout(tallest.t); tallest.t = setTimeout(tallest, 200); });
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(tallest);
})();
