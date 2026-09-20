/* Consolidate — the before/after toggle. Figures roll between the two estates rather than
   swapping, so the size of the change is visible. The HTML already carries the "after" state,
   so with no JS the panel reads as the consolidated estate. Under reduced motion the numbers
   still change on toggle; they just do not animate. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-tis-co]');
  if (!root) return;

  var btns = BDH.$$('[data-tis-state]', root);
  var nums = BDH.$$('.tis-co__num', root);
  var cap  = BDH.$('[data-co-caption]', root);
  if (!btns.length || !nums.length) return;

  var COPY = {
    before: 'Before: 41 scheduled jobs polling nine vendor APIs, most of them finding nothing changed.',
    after:  'After: connectors consolidated onto one event bus, polling replaced where the vendor supports it.'
  };

  /* keep thousands separators and decimals exactly as authored */
  function parse(t) { return parseFloat(String(t).replace(/,/g, '')); }
  function format(v, sample) {
    var dec = (sample.split('.')[1] || '').length;
    var s   = v.toFixed(dec);
    if (sample.indexOf(',') > -1) {
      var p = s.split('.');
      p[0] = p[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      s = p.join('.');
    }
    return s;
  }

  var frames = [];
  function roll(el, to) {
    var from = parse(el.textContent);
    var end  = parse(to);
    if (isNaN(from) || isNaN(end)) { el.textContent = to; return; }
    if (BDH.reduced || from === end) { el.textContent = to; return; }
    var t0 = 0, dur = 520;
    function step(now) {
      if (!t0) t0 = now;
      var p = Math.min(1, (now - t0) / dur);
      var e = 1 - Math.pow(1 - p, 3);
      el.textContent = p === 1 ? to : format(from + (end - from) * e, to);
      if (p < 1) frames.push(requestAnimationFrame(step));
    }
    frames.push(requestAnimationFrame(step));
  }

  function show(state) {
    frames.forEach(cancelAnimationFrame);
    frames = [];
    btns.forEach(function (b) {
      b.setAttribute('aria-pressed', b.getAttribute('data-tis-state') === state ? 'true' : 'false');
    });
    root.setAttribute('data-state', state);
    nums.forEach(function (n) { roll(n, n.getAttribute('data-co-' + state) || n.textContent); });
    if (cap) cap.textContent = COPY[state] || '';
  }

  btns.forEach(function (b) {
    b.addEventListener('click', function () { show(b.getAttribute('data-tis-state')); });
  });

  root.setAttribute('data-state', 'after');
})();
