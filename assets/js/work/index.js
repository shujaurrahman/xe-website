/* Work · Index — makes the showcase filter instant.
   The form already works without this file: work.php reads ?d[]= and ?i[]= and marks non-matching cells
   with the hidden attribute, and a <noscript> submit button applies the choice. Here we do the same thing
   on change, in the browser: toggle hidden on each cell, rewrite the count, show or hide the clear link,
   and keep the address bar in step so the view stays shareable. No motion, so nothing to disable under
   reduced motion. */
(function () {
  'use strict';

  var form = document.querySelector('[data-wk-filter]');
  var grid = document.querySelector('[data-wk-grid]');
  if (!form || !grid) return;

  var cells = Array.prototype.slice.call(grid.querySelectorAll('.wk-index__cell:not(.wk-index__cell--add)'));
  var countEl = form.querySelector('[data-wk-count]');
  var clearEl = form.querySelector('[data-wk-clear]');
  var emptyEl = document.querySelector('[data-wk-empty]');
  var total = cells.length;

  function picked(name) {
    return Array.prototype.slice.call(form.querySelectorAll('input[name="' + name + '"]:checked'))
      .map(function (i) { return i.value; });
  }

  function tokens(el, attr) {
    return (el.getAttribute(attr) || '').split(/\s+/).filter(Boolean);
  }

  function apply(push) {
    var ds = picked('d[]');
    var is = picked('i[]');
    var shown = 0;

    cells.forEach(function (cell) {
      var cd = tokens(cell, 'data-d');
      var ci = tokens(cell, 'data-i');
      var okD = !ds.length || ds.some(function (d) { return cd.indexOf(d) > -1; });
      var okI = !is.length || is.some(function (i) { return ci.indexOf(i) > -1; });
      var on = okD && okI;
      if (on) shown++;
      if (on) cell.removeAttribute('hidden');
      else cell.setAttribute('hidden', '');
    });

    if (countEl) {
      countEl.innerHTML = 'Showing <b class="num">' + shown + '</b> of ' + total + ' records';
    }
    if (clearEl) {
      if (ds.length || is.length) clearEl.removeAttribute('hidden');
      else clearEl.setAttribute('hidden', '');
    }
    if (emptyEl) {
      if (shown === 0) emptyEl.removeAttribute('hidden');
      else emptyEl.setAttribute('hidden', '');
    }

    if (push && window.history && window.history.replaceState) {
      var qs = [];
      ds.forEach(function (d) { qs.push('d%5B%5D=' + encodeURIComponent(d)); });
      is.forEach(function (i) { qs.push('i%5B%5D=' + encodeURIComponent(i)); });
      var url = window.location.pathname + (qs.length ? '?' + qs.join('&') : '') + '#index';
      try { window.history.replaceState(null, '', url); } catch (e) { /* file:// and the like */ }
    }
  }

  form.addEventListener('change', function (e) {
    if (e.target && e.target.type === 'checkbox') apply(true);
  });

  /* The clear link is a real href to the unfiltered page; with JS on, clear in place instead. */
  if (clearEl) {
    clearEl.addEventListener('click', function (e) {
      e.preventDefault();
      Array.prototype.slice.call(form.querySelectorAll('input[type="checkbox"]')).forEach(function (i) { i.checked = false; });
      apply(true);
      var first = form.querySelector('input[type="checkbox"]:not([disabled])');
      if (first) first.focus();
    });
  }
  if (emptyEl) {
    var reset = emptyEl.querySelector('a');
    if (reset) {
      reset.addEventListener('click', function (e) {
        e.preventDefault();
        if (clearEl) clearEl.click();
        else apply(true);
      });
    }
  }

  apply(false);
})();
