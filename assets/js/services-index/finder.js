/* What we do — capability finder. The server already filters by q/d/need; this does the same in
   place as you type or tap, and keeps the URL in step so a filtered view can be shared. */
(function () {
  'use strict';
  var root = document.querySelector('[data-svx-finder]'); if (!root) return;
  var form = root.querySelector('[data-svx-form]'), q = root.querySelector('[data-svx-q]');
  var rows = [].slice.call(root.querySelectorAll('[data-svx-row]'));
  var grps = [].slice.call(root.querySelectorAll('[data-svx-grp]'));
  var shown = root.querySelector('[data-svx-shown]'), none = root.querySelector('[data-svx-none]');
  root.querySelector('.svx-f').classList.add('is-js');

  function val(name) { var el = form.querySelector('input[name="' + name + '"]:checked'); return el ? el.value : ''; }
  function run(push) {
    var s = q.value.trim().toLowerCase(), d = val('d'), n = val('need'), count = 0;
    rows.forEach(function (r) {
      var ok = (!d || r.getAttribute('data-d') === d)
        && (!n || (' ' + r.getAttribute('data-need') + ' ').indexOf(' ' + n + ' ') > -1)
        && (!s || r.getAttribute('data-s').indexOf(s) > -1);
      r.hidden = !ok; if (ok) count++;
    });
    grps.forEach(function (g) { g.hidden = !g.querySelector('[data-svx-row]:not([hidden])'); });
    shown.textContent = count; none.hidden = count > 0;
    var dsc = root.querySelector('[data-svx-describe]');   /* carry the chosen discipline into the brief */
    if (dsc) { var u = dsc.getAttribute('href').split('?')[0]; dsc.setAttribute('href', d ? u + '?from=' + encodeURIComponent(d) : u); }
    if (push && window.history && history.replaceState) {
      var p = []; if (s) p.push('q=' + encodeURIComponent(q.value.trim())); if (d) p.push('d=' + d); if (n) p.push('need=' + n);
      history.replaceState(null, '', (p.length ? '?' + p.join('&') : location.pathname) + '#finder');
    }
  }
  var t; q.addEventListener('input', function () { clearTimeout(t); t = setTimeout(function () { run(true); }, 120); });
  form.addEventListener('change', function () { run(true); });
  form.addEventListener('submit', function (e) { e.preventDefault(); run(true); });
  root.querySelector('[data-svx-reset]').addEventListener('click', function (e) {
    e.preventDefault(); q.value = '';
    [].forEach.call(form.querySelectorAll('input[type=radio][value=""]'), function (r) { r.checked = true; });
    run(true); q.focus();
  });
})();
