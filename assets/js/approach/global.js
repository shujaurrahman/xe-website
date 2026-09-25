/* Global — marks the column closest to the reader's own time zone. Everything it does is additive: the
   full six-column ledger is already in the HTML, and nothing is hidden if this never runs. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-apr-global]');
  if (!root) return;
  var note = root.querySelector('[data-apr-you]');
  var heads = BDH.$$('.apr-gb__zh', root);
  if (!heads.length) return;

  function offsetOf(zone) {
    try {
      var d = new Date();
      var s = new Intl.DateTimeFormat('en-GB', { timeZone: zone, timeZoneName: 'longOffset' }).format(d);
      var m = /GMT([+-])(\d{1,2})(?::(\d{2}))?/.exec(s);
      if (!m) return null;
      var v = parseInt(m[2], 10) * 60 + (m[3] ? parseInt(m[3], 10) : 0);
      return m[1] === '-' ? -v : v;
    } catch (e) { return null; }
  }

  var mine = -new Date().getTimezoneOffset();
  var best = null, bestGap = Infinity;
  heads.forEach(function (h) {
    var o = offsetOf(h.getAttribute('data-apr-z'));
    if (o === null) return;
    var gap = Math.abs(o - mine);
    if (gap < bestGap) { bestGap = gap; best = h; }
  });
  if (!best || bestGap > 90) return;

  var zone = best.getAttribute('data-apr-z');
  BDH.$$('[data-apr-z="' + zone + '"]', root).forEach(function (el) { el.classList.add('is-you'); });
  if (note) {
    var city = best.querySelector('b');
    note.textContent = 'Nearest your device: ' + (city ? city.textContent : zone) + ', marked below.';
    note.hidden = false;
  }
})();
