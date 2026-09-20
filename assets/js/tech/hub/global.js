/* Hub · global — the season switch (aria-pressed) shows the overlap for northern summer or winter, when daylight
   saving moves the UK, Europe and US East by an hour. The IST clocks and the "now" marker on the ribbon follow
   the real time in India, updated every half minute (a position change, not an animation, so it also runs
   under reduced motion). The bars grow in on entry (CSS). */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tih-gl');
  var section = document.querySelector('.tih-global');
  if (!root || !section) return;

  var btns = BDH.$$('.tih-gl__seg button', root);
  function season(k) {
    root.setAttribute('data-season', k);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-season') === k ? 'true' : 'false'); });
  }
  btns.forEach(function (b, i) {
    b.addEventListener('click', function () { season(b.getAttribute('data-season')); });
    b.addEventListener('keydown', function (e) {
      var j = e.key === 'ArrowRight' ? i + 1 : e.key === 'ArrowLeft' ? i - 1 : -99;
      if (j === -99) return;
      e.preventDefault();
      j = (j + btns.length) % btns.length;
      btns[j].focus(); season(btns[j].getAttribute('data-season'));
    });
  });

  var body = BDH.$('.tih-gl__body', root);
  var clocks = BDH.$$('[data-ist]', section);
  function tick() {
    var d = new Date(Date.now() + 5.5 * 3600 * 1000);          /* IST = UTC+5:30, no daylight saving */
    var h = d.getUTCHours(), m = d.getUTCMinutes();
    var t = (h < 10 ? '0' : '') + h + ':' + (m < 10 ? '0' : '') + m;
    clocks.forEach(function (c) { if (c.textContent !== t) c.textContent = t; });
    if (body) body.style.setProperty('--now', ((h + m / 60) / 24 * 100).toFixed(3));
  }
  tick();
  setInterval(function () { if (!document.hidden) tick(); }, 30000);
})();
