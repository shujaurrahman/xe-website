/* Custom Software & Data Platforms · symptoms — the copy-paste loop on the spreadsheet mock: a range is
   copied from the CRM export, pasted into Billing (one lookup fails), then matched by email in Support.
   Runs only while on screen. Reduced motion: the Billing tab with the failed lookup stays, as in the HTML. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  var sheet = document.querySelector('.tcs-symptoms .tcs-sheet'); if (!sheet) return;
  var st = sheet.querySelector('[data-sheet-status]');
  function set(tab, copy, flash, text) {
    sheet.setAttribute('data-tab', String(tab));
    sheet.classList.toggle('is-copy', !!copy);
    sheet.classList.toggle('is-flash', !!flash);
    if (st && text) st.textContent = text;
  }
  BDH.live(sheet, 0.3);
  BDH.seq(sheet, [
    [600,  function () { set(0, false, false, 'Select B2:B4 in CRM export'); }],
    [900,  function () { set(0, true, false, 'Copied 3 cells · ⌘C'); }],
    [1500, function () { set(1, true, false, 'Switch to Billing · paste into C2'); }],
    [700,  function () { set(1, false, true, "=VLOOKUP(A4, 'CRM export'!A:B, 2, FALSE) → #N/A in 1 of 3 rows"); }],
    [2600, function () { set(2, true, false, 'Switch to Support · paste again'); }],
    [700,  function () { set(2, false, false, 'Matched by email in 2 of 3 rows · 1 left for a person'); }],
    [2600, function () { set(1, false, false, "=VLOOKUP(A4, 'CRM export'!A:B, 2, FALSE) → #N/A in 1 of 3 rows"); }],
    [1800, function () {}]
  ], { loop: true, stopOnInteract: false });
})();
