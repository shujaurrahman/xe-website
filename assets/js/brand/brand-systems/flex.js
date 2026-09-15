/* Brand Systems · 04 flex rules — drag a marker, load a brief; each row reports in/out of range. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var box = document.querySelector('[data-cbs-fx]'); if (!box) return;
  var rows = BDH.$$('[data-cbs-fx-row]', box);
  var presets = BDH.$$('[data-cbs-fx-preset]', box);
  var verdict = box.querySelector('[data-cbs-fx-verdict]');

  function paint(row) {
    var inp = row.querySelector('input'), v = +inp.value;
    var lo = +row.getAttribute('data-floor'), hi = +row.getAttribute('data-ceil');
    var ok = v >= lo && v <= hi;
    row.style.setProperty('--v', v);
    row.classList.toggle('is-in', ok);
    row.classList.toggle('is-out', !ok);
    row.querySelector('[data-cbs-fx-val]').textContent = v;
    var st = row.querySelector('[data-cbs-fx-status]');
    var why = ok ? 'Inside the band (' + lo + '–' + hi + '). Ships without review.'
      : (v < lo ? row.getAttribute('data-low') : row.getAttribute('data-high')) + ' Goes to the system owner.';
    st.querySelector('.cbs-fx__badge').textContent = ok ? 'In range' : (v < lo ? 'Below floor' : 'Above ceiling');
    st.querySelector('.cbs-fx__why').textContent = why;
    inp.setAttribute('aria-valuetext', v + ', ' + (ok ? 'in range' : (v < lo ? 'below the floor of ' + lo : 'above the ceiling of ' + hi)));
    return ok;
  }
  function all() {
    var n = rows.filter(paint).length, out = rows.length - n;
    verdict.classList.toggle('is-out', out > 0);
    verdict.querySelector('b').textContent = n + ' of ' + rows.length + ' in range';
    verdict.querySelector('span').textContent = out ? out + (out === 1 ? ' element needs' : ' elements need') + ' sign-off from the system owner' : 'Ships without review';
  }

  rows.forEach(function (row) {
    var inp = row.querySelector('input');
    inp.addEventListener('input', function () { row.classList.add('is-drag'); presets.forEach(function (b) { b.setAttribute('aria-pressed', 'false'); }); all(); });
    inp.addEventListener('change', function () { row.classList.remove('is-drag'); });
    inp.addEventListener('pointerup', function () { row.classList.remove('is-drag'); });
  });
  function load(btn) {
    var vals = btn.getAttribute('data-cbs-fx-preset').split(',');
    presets.forEach(function (b) { b.setAttribute('aria-pressed', String(b === btn)); });
    rows.forEach(function (row, i) { row.classList.remove('is-drag'); row.querySelector('input').value = vals[i]; });
    all();
  }
  presets.forEach(function (b) { b.addEventListener('click', function () { load(b); }); });

  all();
  if (BDH.reduced) return;
  var k = 0;
  var auto = BDH.loop(box, 3200, function () { load(presets[k % presets.length]); k++; });
  BDH.onInteract(box, function () { auto.stop(); });
})();
