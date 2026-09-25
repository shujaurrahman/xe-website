/* 20 — booking. Writes the reader's own time zone into the discovery-call panel.

   This used to drive a mock calendar (invented availability, a mailto "booking" that
   reserved nothing). The real scheduler now lives at /book, so the only thing left
   here is the time zone label. With JavaScript off it reads "Your local time". */
(function () {
  'use strict';
  var root = document.querySelector('[data-s20]');
  if (!root) return;
  var el = root.querySelector('[data-s20-tz]');
  if (!el) return;
  try {
    var tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    if (tz) el.textContent = tz.replace(/_/g, ' ');
  } catch (e) {}
})();
