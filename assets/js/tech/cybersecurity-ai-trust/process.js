/* Cybersecurity & AI Trust · process — the lap dial. BDH.tabs owns the four nodes and the panes;
   this only re-points the dial when the stage changes: --i moves the blue quadrant arc and the marker,
   and the centre readout and the legend are rewritten from the selected node's pane.

   The HTML ships with stage 01 selected, its arc drawn and its sheet open, so the section is complete
   without JavaScript. Nothing loops here, so there is nothing to suppress under reduced motion — CSS
   drops the arc and marker transitions and the row animation. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tsc-cy'); if (!root) return;

  var dial  = root.querySelector('[data-cy-dial]');
  var tabs  = BDH.$$('[role="tab"]', root);
  var panes = BDH.$$('.tsc-cy__pane', root);
  var legs  = BDH.$$('[data-cy-lg]', root);
  var idxEl = root.querySelector('[data-cy-idx]');
  var nameEl = root.querySelector('[data-cy-name]');
  var whenEl = root.querySelector('[data-cy-when]');
  if (tabs.length !== panes.length || !tabs.length) return;

  /* the stage name and its timing already sit in each pane; read them back rather than repeat them */
  var stages = panes.map(function (p) {
    var k = (p.querySelector('.tsc-cy__pk') || {}).textContent || '';
    return {
      name: ((p.querySelector('.tsc-cy__pt') || {}).textContent || '').trim(),
      when: (k.split('·')[1] || '').trim()
    };
  });

  function point(i) {
    if (dial) dial.style.setProperty('--i', String(i));
    if (idxEl) idxEl.textContent = i < 9 ? '0' + (i + 1) : String(i + 1);
    if (nameEl) nameEl.textContent = stages[i].name;
    if (whenEl) whenEl.textContent = stages[i].when;
    legs.forEach(function (l, k) { l.classList.toggle('is-on', k === i); });
  }

  BDH.tabs(root, { tabs: tabs, panes: panes, initial: 0, onChange: point });
  point(0);
})();
