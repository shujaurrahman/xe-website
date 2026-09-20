/* Process — the phases as a tablist, with the service dot moving to the selected station and the
   completed part of the line filling behind it. BDH.tabs supplies the ARIA and arrow-key handling;
   this only tracks the index and wires the previous / next buttons. The first panel is visible in
   the HTML, so the section is readable with no JS. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-tis-pr]');
  if (!root) return;

  var tabs = BDH.$$('[role="tab"]', root);
  if (tabs.length < 2) return;

  var prev = BDH.$('[data-tis-prev]', root);
  var next = BDH.$('[data-tis-next]', root);
  var last = tabs.length - 1;

  root.style.setProperty('--tis-stns', String(tabs.length));

  function edges(i) {
    if (prev) prev.disabled = i === 0;
    if (next) next.disabled = i === last;
  }

  /* stations the line has already called at read as visited, so the blue segment has stations on it */
  function marks(i) {
    tabs.forEach(function (t, j) {
      t.classList.toggle('is-done', j < i);
      t.classList.toggle('is-here', j === i);
    });
  }

  var api = BDH.tabs(root, {
    tabs: '[role="tab"]',
    panes: '.tis-pr__pane',
    initial: 0,
    onChange: function (i) {
      root.style.setProperty('--tis-train', String(i));
      edges(i);
      marks(i);
    }
  });
  if (!api) return;

  edges(0);
  marks(0);

  if (prev) prev.addEventListener('click', function () {
    var i = api.index();
    if (i > 0) api.show(i - 1, true);
  });
  if (next) next.addEventListener('click', function () {
    var i = api.index();
    if (i < last) api.show(i + 1, true);
  });
})();
