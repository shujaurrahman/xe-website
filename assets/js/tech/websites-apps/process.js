/* ==========================================================================
   Websites & Apps · 09 process — the five-stop stepper. BDH.tabs handles the
   ARIA tablist and arrow keys; this adds the filling rail, the "past" state on
   earlier stops, the prev / next buttons and the live count. With JS off, every
   pane is in the DOM and the first one is shown.
   ========================================================================== */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.twa-process .twa-ps');
  if (!root) return;

  var tabs = BDH.$$('[data-ps-tab]', root);
  if (tabs.length < 2) return;

  var fill  = root.querySelector('[data-ps-fill]');
  var prev  = root.querySelector('[data-ps-prev]');
  var next  = root.querySelector('[data-ps-next]');
  var nowEl = root.querySelector('[data-ps-now]');
  var nmEl  = root.querySelector('[data-ps-name]');
  var last  = tabs.length - 1;

  var names = tabs.map(function (t) {
    var n = t.querySelector('.twa-ps__nm');
    return n ? n.textContent.trim() : '';
  });

  function paint(i, moved) {
    tabs.forEach(function (t, k) { t.classList.toggle('is-past', k < i); });
    if (fill) fill.style.transform = 'scaleX(' + (i / last) + ')';
    if (nowEl) nowEl.textContent = (i + 1 < 10 ? '0' : '') + (i + 1);
    if (nmEl) nmEl.textContent = names[i];
    if (prev) prev.disabled = i === 0;
    if (next) next.disabled = i === last;
    if (moved && tabs[i] && tabs[i].scrollIntoView && window.matchMedia('(max-width: 1023px)').matches) {
      tabs[i].scrollIntoView({ block: 'nearest', inline: 'nearest' });
    }
  }

  var api = BDH.tabs(root, {
    tabs: '[data-ps-tab]',
    panes: '.twa-ps__pane',
    onChange: function (i) { paint(i, true); }
  });
  if (!api) return;
  paint(api.index(), false);

  if (prev) prev.addEventListener('click', function () { api.show(Math.max(0, api.index() - 1), true); });
  if (next) next.addEventListener('click', function () { api.show(Math.min(last, api.index() + 1), true); });
})();
