/* Sector dossiers — open the dossier a #sector link points at (hero map, explorer, other pages), then scroll to it.
   Native <details> keeps every dossier readable without JS. */
(function () { 'use strict';
  var root = document.querySelector('.ind-dos'); if (!root) return;
  function openHash(scroll) {
    var id = decodeURIComponent(location.hash.slice(1)); if (!id) return;
    var d = document.getElementById(id);
    if (!d || d.tagName !== 'DETAILS' || !root.contains(d)) return;
    d.open = true;
    if (scroll) d.scrollIntoView({ block: 'start', behavior: (window.BDH && BDH.reduced) ? 'auto' : 'smooth' });
  }
  window.addEventListener('hashchange', function () { openHash(true); });
  document.addEventListener('click', function (e) {
    var a = e.target.closest && e.target.closest('a[href^="#"]'); if (!a) return;
    if (a.getAttribute('href').slice(1) === decodeURIComponent(location.hash.slice(1))) { e.preventDefault(); openHash(true); }
  });
  openHash(true);
})();
