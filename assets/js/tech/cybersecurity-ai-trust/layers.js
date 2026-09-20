/* Cybersecurity & AI Trust · layers — the legend tabs and the rings are one control. A tab or a ring
   click selects a layer: its ring scales up, the others dim, its control sheet shows. Tabs step through
   the layers on their own until the first interaction; probes travel inward only while on screen. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var ui = document.querySelector('.tsc-layers__ui'); if (!ui) return;
  var diag = ui.querySelector('.tsc-layers__diag');
  var rings = BDH.$$('.tsc-ring', ui);

  function paint(i) {
    rings.forEach(function (r) { r.classList.toggle('is-on', parseInt(r.getAttribute('data-l'), 10) === i); });
    if (diag) diag.setAttribute('data-on', String(i));
  }

  var tabs = BDH.tabs(ui, {
    tabs: '.tsc-layers__tab',
    auto: BDH.reduced ? 0 : 5200,
    interactRoot: ui,
    onChange: function (i) { paint(i); }
  });
  paint(tabs.index());

  rings.forEach(function (r) {
    r.addEventListener('click', function () { tabs.stop(); tabs.show(parseInt(r.getAttribute('data-l'), 10), true); });
  });

  if (diag) BDH.live(diag, 0.2);
})();
