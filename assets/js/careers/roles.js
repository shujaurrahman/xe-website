/* Careers · roles — progressive enhancement over a form that already works.

   Without this file the filter is a normal GET form: the server reads ?d=, ?l= and ?t=, prints only
   the matching roles and the "showing N of M" line, and each role is a native <details> that opens
   on click. With it, the three selects filter in place, the submit button is removed, the counts and
   the empty state update live, and the URL is rewritten so a filtered view can still be shared.
   /careers#role-<slug> opens that role. Reduced motion: everything works, nothing animates. */
(function () {
  'use strict';

  var root = document.querySelector('[data-car-roles]');
  if (!root) return;
  var form = root.querySelector('[data-car-flt]');
  var list = root.querySelector('[data-car-list]');
  if (!form || !list) return;

  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };
  var reduced = !!(window.BDH && window.BDH.reduced);

  var sels   = $$('[data-car-f]', form);
  var go     = form.querySelector('[data-car-go]');
  var clear  = form.querySelector('[data-car-clear]');
  var countE = form.querySelector('[data-car-count]');
  var none   = list.querySelector('[data-car-none]');
  var groups = $$('[data-car-group]', list);
  var roles  = $$('[data-car-role]', list);
  if (!roles.length) return;

  /* the form still submits if anything below throws, so only remove the button once we are running */
  if (go) go.hidden = true;

  function values() {
    var v = {};
    sels.forEach(function (s) { v[s.getAttribute('data-car-f')] = s.value; });
    return v;
  }

  function matches(el, v) {
    if (v.d && el.getAttribute('data-d') !== v.d) return false;
    if (v.t && el.getAttribute('data-t') !== v.t) return false;
    if (v.l && (' ' + (el.getAttribute('data-l') || '') + ' ').indexOf(' ' + v.l + ' ') === -1) return false;
    return true;
  }

  function apply(v, animate) {
    var shown = 0, appeared = [];
    roles.forEach(function (el) {
      var hit = matches(el, v);
      if (hit && el.hidden) appeared.push(el);
      el.hidden = !hit;
      if (hit) shown++;
    });

    groups.forEach(function (g) {
      var on = $$('[data-car-role]', g).filter(function (el) { return !el.hidden; });
      g.hidden = on.length === 0;
      var c = g.querySelector('[data-car-gcount]');
      if (c) c.textContent = String(on.length);
    });

    /* the index column renumbers so it always reads 01, 02, 03 down the visible list */
    var n = 0;
    roles.forEach(function (el) {
      if (el.hidden) return;
      n++;
      var i = el.querySelector('.car-role__i');
      if (i) i.textContent = (n < 10 ? '0' : '') + n;
    });

    if (none) none.hidden = shown > 0;
    if (countE) {
      var total = roles.length, word = total === 1 ? 'role' : 'roles';
      countE.textContent = (v.d || v.l || v.t)
        ? 'Showing ' + shown + ' of ' + total + ' ' + word + '.'
        : 'Showing all ' + total + ' ' + word + '.';
    }
    if (clear) clear.hidden = !(v.d || v.l || v.t);

    if (animate && !reduced) {
      appeared.forEach(function (el, i) {
        if (!el.animate) return;
        el.animate([{ opacity: 0, transform: 'translateY(6px)' }, { opacity: 1, transform: 'none' }],
          { duration: 300, delay: Math.min(i, 8) * 30, easing: 'cubic-bezier(.22,1,.36,1)', fill: 'backwards' });
      });
    }
    return shown;
  }

  function sync(v) {
    if (!window.history || !history.replaceState) return;
    var q = [];
    ['d', 'l', 't'].forEach(function (k) { if (v[k]) q.push(k + '=' + encodeURIComponent(v[k])); });
    var url = location.pathname + (q.length ? '?' + q.join('&') : '') + '#roles';
    try { history.replaceState(null, '', url); } catch (e) {}
  }

  sels.forEach(function (s) {
    s.addEventListener('change', function () {
      var v = values();
      apply(v, true);
      sync(v);
    });
  });

  form.addEventListener('submit', function (e) {
    /* the selects have already filtered; submitting would only reload the same view */
    e.preventDefault();
    var v = values();
    apply(v, true);
    sync(v);
  });

  if (clear) {
    clear.addEventListener('click', function (e) {
      e.preventDefault();
      sels.forEach(function (s) { s.value = ''; });
      var v = values();
      apply(v, true);
      sync(v);
      if (sels[0]) sels[0].focus();
    });
  }

  /* #role-<slug> opens that role, on load and on a later hash change */
  function openFromHash() {
    var id = (location.hash || '').replace(/^#/, '');
    if (!id) return;
    var el = document.getElementById(id);
    if (!el || !el.hasAttribute('data-car-role')) return;
    el.hidden = false;
    el.open = true;
    var g = el.closest('[data-car-group]');
    if (g) g.hidden = false;
  }
  window.addEventListener('hashchange', openFromHash);

  /* sync once at start: the server has already filtered, this just wires the counters up.
     The deep link runs after it, so #role-<slug> wins over a filter that would hide it. */
  apply(values(), false);
  openFromHash();
})();
