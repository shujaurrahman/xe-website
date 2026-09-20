/* Audits & Assessments · cost — the monthly waterfall.
   The HTML is already the finished chart: every bar sits at its cumulative offset and the first
   pane is open. This adds .is-in (bars drop in sequence, connectors fade up) and wires the
   tablist, so hovering or focusing a bar opens its formula. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-taa-cost]');
  if (!root) return;

  var panes = BDH.$$('.taa-cost__pane', root);
  var tabs  = BDH.$$('[data-taa-cost-tabs] [role="tab"]', root);
  if (!tabs.length) return;

  BDH.tabs(root, {
    tabs: '[data-taa-cost-tabs] [role="tab"]',
    panes: panes,
    orientation: 'horizontal'
  });

  // the chart reads as a chart: pointing at a bar, or arrowing onto it, opens its calculation
  tabs.forEach(function (tab) {
    function open() {
      if (tab.getAttribute('aria-selected') !== 'true') tab.click();
    }
    tab.addEventListener('mouseenter', open);
    tab.addEventListener('focus', open);
  });

  var wf = root.querySelector('.taa-cost__wf') || root;
  wf.classList.add('is-anim');
  BDH.inView(root, function () { root.classList.add('is-in'); }, { threshold: 0.2 });
})();
