/* Hub · loop — the ring is the tablist. BDH.tabs gives the four stage chips their ARIA behaviour
   (click, arrow keys, Home and End); this script also lights the arrow leaving the selected stage and
   steps the selection round the loop until the reader takes over. Reduced motion: no autoplay, no
   pulse, and the first pane stays shown. With JavaScript off the first pane is on and every arc is
   already drawn, so nothing is hidden. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.cch-loop');
  if (!root) return;
  var body = root.querySelector('.cch-loop__body');
  var chips = BDH.$$('.cch-loop__chip', root);
  var panes = BDH.$$('.cch-loop__pane', root);
  var arcs = BDH.$$('.cch-loop__arc', root);
  var heads = BDH.$$('.cch-loop__head', root);
  if (!chips.length || chips.length !== panes.length) return;

  function light(i) {
    var key = chips[i].getAttribute('data-stage');
    arcs.forEach(function (a) { a.classList.toggle('is-on', a.getAttribute('data-arc') === key); });
    heads.forEach(function (h) { h.classList.toggle('is-on', h.getAttribute('data-arc') === key); });
  }

  var api = BDH.tabs(root, {
    tabs: chips,
    panes: panes,
    orientation: 'horizontal',
    onChange: function (i) { light(i); }
  });
  light(api.index() < 0 ? 0 : api.index());

  /* step round the loop once the section is on screen, and stop for good on the first interaction */
  if (BDH.reduced || !body) return;
  var steps = [];
  for (var s = 1; s <= chips.length; s++) {
    (function (n) { steps.push([6400, function () { api.show(n % chips.length); }]); })(s);
  }
  BDH.seq(body, steps, { loop: true, stopOnInteract: true, interactRoot: root });
})();
