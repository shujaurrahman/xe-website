/* Work index — live filtering by discipline and sector.
   The form works without JavaScript (GET ?d=&i=, server-rendered). With JavaScript it filters in
   place, keeps the counts and the status line live, rewrites the URL, and opens a deep-linked case. */
(function () {
  'use strict';
  var form = document.querySelector('[data-wrk-filter]');
  if (!form) return;

  var cases  = Array.prototype.slice.call(document.querySelectorAll('.wrk-card:not(.wrk-card--slot)'));
  var status = form.querySelector('[data-wrk-status]');
  var empty  = document.querySelector('[data-wrk-empty]');
  var total  = cases.length;
  if (!status || !cases.length) return;
  form.classList.add('is-js');

  function val(name) {
    var el = form.querySelector('input[name="' + name + '"]:checked');
    return el ? el.value : '';
  }
  function match(c, d, i) {
    return (!d || (' ' + (c.getAttribute('data-d') || '') + ' ').indexOf(' ' + d + ' ') > -1) &&
           (!i || c.getAttribute('data-i') === i);
  }
  function count(d, i) {
    var n = 0;
    cases.forEach(function (c) { if (match(c, d, i)) n++; });
    return n;
  }

  function apply(push) {
    var d = val('d'), i = val('i'), shown = 0;
    cases.forEach(function (c) {
      var on = match(c, d, i);
      c.hidden = !on;
      if (on) shown++;
    });
    Array.prototype.forEach.call(form.querySelectorAll('.wrk-opt'), function (o) {
      var inp = o.querySelector('input');
      var box = o.querySelector('[data-n]');
      if (!inp || !box) return;
      var n = inp.name === 'd' ? count(inp.value, i) : count(d, inp.value);
      box.textContent = n;
      o.classList.toggle('is-zero', n === 0);
    });
    status.textContent = 'Showing ' + shown + ' of ' + total + ' programmes';
    if (empty) empty.hidden = shown > 0;
    if (push) {
      var q = [];
      if (d) q.push('d=' + encodeURIComponent(d));
      if (i) q.push('i=' + encodeURIComponent(i));
      try {
        history.replaceState(null, '', location.pathname + (q.length ? '?' + q.join('&') : '') + '#programmes');
      } catch (e) { /* file:// and privacy modes */ }
    }
  }

  form.addEventListener('change', function () { apply(true); });
  form.addEventListener('submit', function (e) { e.preventDefault(); apply(true); });

  function clear(focus) {
    var d = form.querySelector('input[name="d"][value=""]');
    var i = form.querySelector('input[name="i"][value=""]');
    if (d) d.checked = true;
    if (i) i.checked = true;
    apply(true);
    if (focus && d) d.focus();
  }
  Array.prototype.forEach.call(document.querySelectorAll('[data-wrk-reset]'), function (a) {
    a.addEventListener('click', function (e) { e.preventDefault(); clear(true); });
  });

  /* a link to #<slug> from elsewhere on the site must not land on a card the filter is hiding */
  function openHash() {
    var id = decodeURIComponent(location.hash.slice(1));
    if (!id) return;
    var el = document.getElementById(id);
    if (!el || !el.classList.contains('wrk-card')) return;
    if (el.hidden) {
      clear(false);
      try { history.replaceState(null, '', location.pathname + '#' + id); } catch (e) {}
    }
    var det = el.querySelector('details');
    if (det) det.open = true;
    el.scrollIntoView({ block: 'start' });
  }
  window.addEventListener('hashchange', openHash);

  apply(false);
  openHash();
})();
