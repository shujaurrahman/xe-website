/* Rhythm — links the calendar blocks to the ledger rows. Each block is already an anchor to its row, so
   the section works without JavaScript; this adds the two-way highlight and keeps the page still when the
   row is already on screen. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-apr-rhythm]');
  var sect = document.querySelector('.apr-rt');
  if (!root || !sect) return;
  var evs  = BDH.$$('[data-apr-ev]', root);
  var rows = BDH.$$('[data-apr-row]', sect);
  if (!evs.length || !rows.length) return;

  var byKey = {};
  rows.forEach(function (r) { byKey[r.getAttribute('data-apr-row')] = r; });

  function hi(key, on) {
    evs.forEach(function (e) { if (e.getAttribute('data-apr-ev') === key) e.classList.toggle('is-hi', on); });
    if (byKey[key]) byKey[key].classList.toggle('is-hi', on);
  }
  function inView(el) {
    var r = el.getBoundingClientRect();
    return r.top >= 64 && r.bottom <= (window.innerHeight || 0) - 16;
  }

  evs.forEach(function (el) {
    var key = el.getAttribute('data-apr-ev');
    ['mouseenter', 'focus'].forEach(function (t) { el.addEventListener(t, function () { hi(key, true); }); });
    ['mouseleave', 'blur'].forEach(function (t) { el.addEventListener(t, function () { hi(key, false); }); });
    el.addEventListener('click', function (ev) {
      var row = byKey[key];
      if (!row) return;
      ev.preventDefault();
      hi(key, true);
      if (!inView(row)) row.scrollIntoView({ block: 'center', behavior: BDH.reduced ? 'auto' : 'smooth' });
      window.setTimeout(function () { hi(key, false); }, 2400);
    });
  });

  rows.forEach(function (row) {
    var key = row.getAttribute('data-apr-row');
    ['mouseenter', 'focusin'].forEach(function (t) { row.addEventListener(t, function () { hi(key, true); }); });
    ['mouseleave', 'focusout'].forEach(function (t) { row.addEventListener(t, function () { hi(key, false); }); });
  });
})();
