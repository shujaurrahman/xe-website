/* 9 · Process — rooms as an ARIA tablist (BDH.tabs: arrows, Home/End). Rooms light in sequence
   while on screen until the first interaction; the active room carries .is-on. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var app = document.querySelector('[data-cba-proc]');
  if (!app) return;
  var rooms = BDH.$$('.cba-proc__room', app);
  var panes = BDH.$$('.cba-proc__pane', app);
  if (!rooms.length) return;

  function mark(i) { rooms.forEach(function (r, n) { r.classList.toggle('is-on', n === i); }); }

  var api = BDH.tabs(app, {
    tabs: rooms,
    panes: panes,
    auto: BDH.reduced ? 0 : 4200,
    orientation: 'horizontal',
    initial: 0,
    interactRoot: app,
    onChange: function (i) { mark(i); }
  });
  mark(api.index() < 0 ? 0 : api.index());
})();
