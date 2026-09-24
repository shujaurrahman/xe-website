/* Careers roles — live filtering over the server-rendered list (the GET form keeps working without JS),
   URL kept in step, #role-<id> deep links opened and scrolled to, copy-link buttons. */
(function () { 'use strict';
  var root = document.querySelector('.car-roles'); if (!root) return;
  var form = root.querySelector('[data-car-filter]'), roles = [].slice.call(root.querySelectorAll('.car-role'));
  var count = root.querySelector('[data-car-count]'), empty = root.querySelector('[data-car-empty]');
  var q = form.querySelector('[name=q]'), sel = { dept: form.querySelector('[name=dept]'), loc: form.querySelector('[name=loc]'), type: form.querySelector('[name=type]') };
  document.querySelector('.car').classList.add('is-live-filter');
  function apply(push) {
    var words = q.value.toLowerCase().split(/\s+/).filter(Boolean), n = 0;
    roles.forEach(function (r) {
      var ok = words.every(function (w) { return r.getAttribute('data-text').indexOf(w) > -1; });
      Object.keys(sel).forEach(function (k) { if (sel[k].value && r.getAttribute('data-' + k) !== sel[k].value) ok = false; });
      r.hidden = !ok; if (ok) n++;
    });
    count.textContent = n + ' of ' + roles.length + ' roles';
    empty.hidden = n > 0;
    if (push) {
      var p = new URLSearchParams();
      if (q.value.trim()) p.set('q', q.value.trim());
      Object.keys(sel).forEach(function (k) { if (sel[k].value) p.set(k, sel[k].value); });
      var s = p.toString();
      try { history.replaceState(null, '', location.pathname + (s ? '?' + s : '') + '#roles'); } catch (e) {}
    }
  }
  var tid; q.addEventListener('input', function () { clearTimeout(tid); tid = setTimeout(function () { apply(true); }, 120); });
  Object.keys(sel).forEach(function (k) { sel[k].addEventListener('change', function () { apply(true); }); });
  form.addEventListener('submit', function (e) { e.preventDefault(); apply(true); });
  root.querySelectorAll('[data-car-clear]').forEach(function (a) {
    a.addEventListener('click', function (e) { e.preventDefault(); form.reset(); q.value = ''; Object.keys(sel).forEach(function (k) { sel[k].value = ''; }); apply(true); q.focus(); });
  });
  /* hero team links filter in place */
  document.querySelectorAll('.car-board__list a').forEach(function (a) {
    a.addEventListener('click', function () {
      var d = new URL(a.href, location.href).searchParams.get('dept'); if (!d) return;
      q.value = ''; sel.loc.value = ''; sel.type.value = ''; sel.dept.value = d; apply(true);
    });
  });
  function openHash() {
    var m = /^#role-([a-z0-9-]+)$/.exec(location.hash); if (!m) return;
    var r = document.getElementById('role-' + m[1]); if (!r) return;
    if (r.hidden) { form.reset(); q.value = ''; Object.keys(sel).forEach(function (k) { sel[k].value = ''; }); apply(false); }
    r.open = true; r.scrollIntoView({ block: 'start' });
  }
  window.addEventListener('hashchange', openHash); openHash();
  /* keep #role-<id> in the address bar as roles open, so the URL is shareable */
  roles.forEach(function (r) {
    r.addEventListener('toggle', function () { if (r.open) try { history.replaceState(null, '', location.pathname + location.search.replace(/([?&])role=[^&]*/, '$1').replace(/[?&]$/, '') + '#' + r.id); } catch (e) {} });
    var link = r.querySelector('[data-car-link]');
    if (link && navigator.clipboard) {
      var b = document.createElement('button'); b.type = 'button'; b.className = 'car-copy'; b.textContent = 'Copy link';
      b.setAttribute('aria-label', 'Copy link to ' + r.querySelector('.car-role__t').textContent);
      b.addEventListener('click', function () {
        navigator.clipboard.writeText(new URL('#' + r.id, location.origin + location.pathname).href).then(function () { b.textContent = 'Link copied'; setTimeout(function () { b.textContent = 'Copy link'; }, 2000); }, function () {});
      });
      link.parentNode.appendChild(b);
    }
  });
})();
