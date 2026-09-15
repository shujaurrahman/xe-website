/* Brand Systems · 10 deliverables — verify the bundle: each row's hash is re-checked in turn. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var card = document.querySelector('[data-cbs-bn]'); if (!card) return;
  var rows = BDH.$$('[data-cbs-bn-row]', card);
  var btn = card.querySelector('[data-cbs-bn-verify]');
  var status = card.querySelector('[data-cbs-bn-status]');
  var done = status.textContent, ids = [];

  function clear() { ids.forEach(clearTimeout); ids = []; }
  function verify() {
    clear();
    if (BDH.reduced) { status.textContent = done; return; }
    btn.disabled = true;
    rows.forEach(function (r) { r.classList.remove('is-checking'); r.classList.add('is-pending'); });
    status.textContent = 'Verifying 0 of ' + rows.length + '…';
    rows.forEach(function (r, i) {
      ids.push(setTimeout(function () { r.classList.remove('is-pending'); r.classList.add('is-checking'); }, 250 + i * 380));
      ids.push(setTimeout(function () {
        r.classList.remove('is-checking');
        status.textContent = i === rows.length - 1 ? done : 'Verifying ' + (i + 1) + ' of ' + rows.length + '…';
        if (i === rows.length - 1) btn.disabled = false;
      }, 250 + i * 380 + 520));
    });
  }
  btn.addEventListener('click', verify);
  if (!BDH.reduced) BDH.inView(card, verify, { threshold: 0.35 });
})();
