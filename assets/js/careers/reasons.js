/* Careers · why here — turns the four reason panels into a tablist.
   Enhancement only. The shipped HTML has every panel in flow with its own h3; the <noscript> rule
   in partials/careers/reasons.php hides the tab strip when this file never runs, so the section is
   complete and readable without JavaScript. Here we add the panel ARIA (there is no tablist to
   belong to until now), mark the box so the between-panel rules switch off, and hand the keyboard
   and selection behaviour to BDH.tabs. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-car-rsn]');
  if (!root) return;

  var tabs = BDH.$$('[role="tab"]', root);
  var panes = BDH.$$('.car-rsn__pane', root);
  if (!tabs.length || tabs.length !== panes.length) return;

  panes.forEach(function (pane, i) {
    pane.setAttribute('role', 'tabpanel');
    pane.setAttribute('tabindex', '0');
    if (tabs[i].id) pane.setAttribute('aria-labelledby', tabs[i].id);
  });

  root.classList.add('is-tabs');
  BDH.tabs(root, { tabs: tabs, panes: panes, orientation: 'horizontal' });
})();
