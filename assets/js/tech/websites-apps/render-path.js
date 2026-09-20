/* Websites & Apps · render-path — the six hops are an ARIA tablist (BDH.tabs). While the panel autoplays, the request
   packet moves hop to hop, each hop lights up and its budget bar fills; at the last hop the response packet travels
   back from Rendering to the Device and the walk restarts. Selecting a hop also highlights its spans in the trace.
   Stops for good on the first interaction. Reduced motion: static packet, filled bars, tabs still work. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.twa-rp'); if (!root) return;
  var R = BDH.reduced;
  var lane = root.querySelector('.twa-rp__lane');
  var hops = BDH.$$('.twa-rp__hop', root);
  var req = root.querySelector('.twa-rp__packet--req'), res = root.querySelector('.twa-rp__packet--res');
  var track = root.querySelector('.twa-rp__track i');
  var rows = BDH.$$('.twa-rp__row', root);
  var N = hops.length, backT = 0;
  if (!N || !lane) return;

  function cx(i) {
    var a = hops[i].getBoundingClientRect(), b = lane.getBoundingClientRect();
    return a.left - b.left + a.width / 2;
  }
  function packetTo(el, i, jump) {
    if (!el) return;
    if (jump) el.classList.add('is-jump');
    el.style.setProperty('--x', cx(i).toFixed(1) + 'px');
    if (jump) { void el.offsetWidth; el.classList.remove('is-jump'); }
  }
  function heat(i) {
    /* is-done is the finished state the HTML ships — only ever added, never taken away. The walk shows itself
       with is-hot and the filling track, so every budget bar stays filled from the first paint. */
    hops.forEach(function (h, k) {
      h.classList.toggle('is-hot', k === i);
      h.classList.add('is-done');
    });
    var key = hops[i].getAttribute('data-hop');
    rows.forEach(function (r) { r.classList.toggle('is-hl', r.getAttribute('data-hop') === key); });
    if (track) track.style.setProperty('--k', String(i / (N - 1)));
  }

  var api = BDH.tabs(root, {
    auto: R ? 0 : 2600,
    interactRoot: lane,
    onChange: function (i, prev, byUser) {
      heat(i);
      clearTimeout(backT);
      if (!byUser && !R && prev === N - 1 && i === 0) {
        /* the response goes back: Rendering → Device, then the next request starts */
        packetTo(res, 2, true);
        root.classList.add('is-back');
        requestAnimationFrame(function () { packetTo(res, 0, false); });
        packetTo(req, 0, true);
        backT = setTimeout(function () { root.classList.remove('is-back'); }, 950);
      } else {
        root.classList.remove('is-back');
        packetTo(req, i, false);
      }
    }
  });

  packetTo(req, api.index(), true);
  packetTo(res, api.index(), true);
  heat(api.index());
  root.classList.add('is-ready');
  window.addEventListener('resize', function () {
    packetTo(req, api.index(), true);
    if (!root.classList.contains('is-back')) packetTo(res, api.index(), true);
  }, { passive: true });
})();
