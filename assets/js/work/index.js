/* Work index — live filtering by discipline and industry. The form works without JS (GET ?d=&i=);
   with JS it filters in place, updates counts, the status line and the URL, and opens deep-linked cases. */
(function () { 'use strict';
  var form = document.querySelector('[data-wrk-filter]'); if (!form) return;
  var cases = Array.prototype.slice.call(document.querySelectorAll('.wrk-case'));
  var status = form.querySelector('[data-wrk-status]');
  var empty = document.querySelector('[data-wrk-empty]');
  var total = cases.length;
  form.classList.add('is-js');

  function val(name) { var el = form.querySelector('input[name="' + name + '"]:checked'); return el ? el.value : ''; }
  function match(c, d, i) {
    return (!d || (' ' + c.getAttribute('data-d') + ' ').indexOf(' ' + d + ' ') > -1) && (!i || c.getAttribute('data-i') === i);
  }
  function count(d, i) { var n = 0; cases.forEach(function (c) { if (match(c, d, i)) n++; }); return n; }

  function apply(push) {
    var d = val('d'), i = val('i'), shown = 0;
    cases.forEach(function (c) { var on = match(c, d, i); c.hidden = !on; if (on) shown++; });
    Array.prototype.forEach.call(form.querySelectorAll('.wrk-opt'), function (o) {
      var inp = o.querySelector('input'), n = inp.name === 'd' ? count(inp.value, i) : count(d, inp.value);
      o.querySelector('[data-n]').textContent = n;
      o.classList.toggle('is-zero', n === 0);
    });
    status.textContent = 'Showing ' + shown + ' of ' + total + ' programmes';
    empty.hidden = shown > 0;
    if (push) {
      var q = [];
      if (d) q.push('d=' + encodeURIComponent(d));
      if (i) q.push('i=' + encodeURIComponent(i));
      try { history.replaceState(null, '', location.pathname + (q.length ? '?' + q.join('&') : '') + '#index'); } catch (e) {}
    }
  }
  form.addEventListener('change', function () { apply(true); });
  form.addEventListener('submit', function (e) { e.preventDefault(); apply(true); });
  Array.prototype.forEach.call(document.querySelectorAll('[data-wrk-reset]'), function (a) {
    a.addEventListener('click', function (e) {
      e.preventDefault();
      form.querySelector('input[name="d"][value=""]').checked = true;
      form.querySelector('input[name="i"][value=""]').checked = true;
      apply(true);
      form.querySelector('input[name="d"][value=""]').focus();
    });
  });

  function openHash() {
    var id = decodeURIComponent(location.hash.slice(1));
    if (!id) return;
    var el = document.getElementById(id);
    if (!el || !el.classList.contains('wrk-case')) return;
    if (el.hidden) {
      form.querySelector('input[name="d"][value=""]').checked = true;
      form.querySelector('input[name="i"][value=""]').checked = true;
      apply(true);
      try { history.replaceState(null, '', location.pathname + '#' + id); } catch (e) {}
    }
    var det = el.querySelector('details'); if (det) det.open = true;
    el.scrollIntoView({ block: 'start' });
  }
  window.addEventListener('hashchange', openHash);
  apply(false);
  openHash();
})();
