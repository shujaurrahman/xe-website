/* Industries explorer — a vertical tablist of sectors; each pane shows the discipline mix, rules and dossier link.
   Without JS the tablist stays hidden and every pane is listed in full. */
(function () { 'use strict';
  var root = document.querySelector('.ind-exp'); if (!root) return;
  var app = root.querySelector('.ind-exp__app');
  var list = root.querySelector('[data-ind-tabs]');
  var tabs = Array.prototype.slice.call(list.querySelectorAll('[role="tab"]'));
  var panes = tabs.map(function (t) { return document.getElementById(t.getAttribute('aria-controls')); });
  var reduced = window.BDH ? BDH.reduced : false;
  var cur = 0;
  panes.forEach(function (p) { p.setAttribute('aria-labelledby', ''); });
  tabs.forEach(function (t, i) { panes[i].setAttribute('aria-labelledby', t.id); panes[i].setAttribute('tabindex', '0'); });

  function show(i, focus) {
    cur = i;
    tabs.forEach(function (t, j) {
      var on = j === i;
      t.setAttribute('aria-selected', on ? 'true' : 'false');
      t.tabIndex = on ? 0 : -1;
      panes[j].hidden = !on;
    });
    if (focus) tabs[i].focus();
    if (!reduced) {
      var p = panes[i];
      p.classList.add('is-anim');
      requestAnimationFrame(function () { requestAnimationFrame(function () { p.classList.remove('is-anim'); }); });
    }
  }
  function vertical() { return window.matchMedia('(min-width:1024px)').matches; }
  tabs.forEach(function (t, i) {
    t.addEventListener('click', function () { show(i); });
    t.addEventListener('keydown', function (e) {
      var n = tabs.length, k = e.key, j = null;
      if (k === 'ArrowDown' || k === 'ArrowRight') j = (cur + 1) % n;
      else if (k === 'ArrowUp' || k === 'ArrowLeft') j = (cur - 1 + n) % n;
      else if (k === 'Home') j = 0; else if (k === 'End') j = n - 1;
      if (j === null) return;
      e.preventDefault(); show(j, true);
      if (!vertical()) tabs[j].scrollIntoView({ block: 'nearest', inline: 'nearest' });
    });
  });
  function orient() { list.setAttribute('aria-orientation', vertical() ? 'vertical' : 'horizontal'); }
  window.addEventListener('resize', orient); orient();
  list.hidden = false;
  app.classList.add('is-on');
  show(0);
})();
