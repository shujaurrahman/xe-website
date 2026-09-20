/* ==========================================================================
   Websites & Apps · 07 release — walks a playhead along the release lane.
   The HTML is the finished state and stays that way: every stop is done, every
   panel is lit. What moves is the playhead — it steps from 09:10 to Thursday,
   updating the clock, the "what happened" line and which panel is highlighted,
   so nothing ever disappears from the page. The stops are buttons that jump to
   a moment; the loop stops for good on the first interaction.
   The before/after diff slider is wired in every case, reduced motion included.
   Needs assets/js/brand/hub.js (window.BDH).
   ========================================================================== */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.twa-release .twa-rl');
  if (!root) return;

  /* ---------- visual diff slider (always on) ------------------------------ */
  var diff  = root.querySelector('[data-rl-diff]');
  var range = root.querySelector('.twa-rl__range');
  if (diff && range) {
    var setP = function () {
      var v = Math.max(0, Math.min(100, Number(range.value) || 0));
      diff.style.setProperty('--p', v + '%');
      range.setAttribute('aria-valuetext',
        v <= 2 ? 'Before only' : v >= 98 ? 'After only' : v + ' per cent after, ' + (100 - v) + ' per cent before');
    };
    range.addEventListener('input', setP);
    setP();
  }

  /* ---------- the lane ---------------------------------------------------- */
  var stops  = BDH.$$('.twa-rl__stop', root);
  var btns   = BDH.$$('[data-rl-stop]', root);
  var clock  = root.querySelector('[data-rl-clock]');
  var nowT   = root.querySelector('[data-rl-now-t]');
  var nowD   = root.querySelector('[data-rl-now]');
  var panels = BDH.$$('[data-rl-panel]', root);
  var last   = stops.length - 1;
  if (last < 1) return;

  var detail = stops.map(function (li) {
    var sr = li.querySelector('.bdh-sr');
    return sr ? sr.textContent.replace(/^[.\s]+/, '').replace(/\.\s*$/, '') : '';
  });
  var times = stops.map(function (li) {
    var t = li.querySelector('.twa-rl__time');
    return t ? t.textContent.trim() : '';
  });
  var names = stops.map(function (li) {
    var n = li.querySelector('.twa-rl__name');
    return n ? n.textContent.trim() : '';
  });

  function show(i) {
    i = Math.max(0, Math.min(last, i));
    stops.forEach(function (li, k) { li.classList.toggle('is-now', k === i); });
    btns.forEach(function (b, k) {
      if (k === i) { b.setAttribute('aria-current', 'step'); } else { b.removeAttribute('aria-current'); }
    });
    if (clock) clock.textContent = times[i] + (i === last ? ' · released' : '');
    if (nowT) nowT.textContent = times[i];
    if (nowD) nowD.textContent = detail[i] + '.';
    panels.forEach(function (p) {
      p.classList.toggle('is-hot', Number(p.getAttribute('data-from')) === i);
    });
  }

  var run = null;
  btns.forEach(function (b, k) {
    b.setAttribute('title', times[k] + ' · ' + names[k]);
    b.addEventListener('click', function () { if (run) run.stop(); show(k); });
  });

  if (BDH.reduced) return;

  var steps = [];
  for (var s = 0; s <= last; s++) {
    steps.push([s === 0 ? 700 : 1100, (function (n) { return function () { show(n); }; })(s)]);
  }
  steps.push([2800, function () { show(last); }]);

  run = BDH.seq(root, steps, {
    loop: true,
    stopOnInteract: true,
    interactRoot: root,
    onStop: function () { show(last); }
  });
})();
