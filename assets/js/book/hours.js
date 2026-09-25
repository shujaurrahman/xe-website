/* Book · hours — restate the booking window in the reader's own time zone.
   The shipped sentence already says the window in UTC, which is true for everyone, so this is a
   pure enhancement: if anything here fails, the UTC sentence is simply left alone.

   The two UTC times come from the markup (computed in PHP from the one IST window), so this file
   holds no schedule of its own and cannot drift from the chart above it. India observes no daylight
   saving, which is why a fixed pair of UTC times is correct all year. */
(function () {
  'use strict';

  var el = document.querySelector('[data-bk-local]');
  if (!el) return;

  var open  = (el.getAttribute('data-bk-utc-open')  || '').split(':');
  var close = (el.getAttribute('data-bk-utc-close') || '').split(':');
  if (open.length !== 2 || close.length !== 2) return;

  try {
    var tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    if (!tz) return;

    var now = new Date();
    var fmt = new Intl.DateTimeFormat('en-GB', { hour: '2-digit', minute: '2-digit', hour12: false });

    /* today's date in UTC, at the window's UTC hours, then read back in the local zone */
    var at = function (hm) {
      return new Date(Date.UTC(
        now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(),
        parseInt(hm[0], 10), parseInt(hm[1], 10), 0
      ));
    };
    var a = at(open), b = at(close);
    var from = fmt.format(a), to = fmt.format(b);

    /* a window that starts on one local day and ends on the next is labelled, not hidden */
    var rolls = new Intl.DateTimeFormat('en-GB', { day: 'numeric' }).format(a)
             !== new Intl.DateTimeFormat('en-GB', { day: 'numeric' }).format(b);

    el.textContent = 'In your time zone (' + tz.replace(/_/g, ' ') + ') that window runs '
      + from + ' to ' + to + (rolls ? ' the next day' : '') + '. '
      + 'The scheduler applies the same conversion to every slot it offers you.';
  } catch (e) {
    /* leave the UTC sentence exactly as it shipped */
  }
})();
