/* ==========================================================================
   Websites & Apps · 12 faq — the disclosure accordion. Every answer is open in
   the HTML so the page reads in full without JS; here we leave the first open,
   collapse the rest, and toggle on click. Several may be open at once.
   ========================================================================== */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.twa-faq .twa-fq__list');
  if (!root) return;

  var qs = BDH.$$('[data-fq-q]', root);
  if (!qs.length) return;

  function set(btn, open) {
    var id = btn.getAttribute('aria-controls');
    var panel = id ? document.getElementById(id) : null;
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (panel) panel.hidden = !open;
  }

  qs.forEach(function (btn, i) {
    set(btn, i === 0);
    btn.addEventListener('click', function () {
      set(btn, btn.getAttribute('aria-expanded') !== 'true');
    });
  });
})();
