/* Brand Systems · 12 FAQ — topic chips and search filter the question list; matches are marked. */
(function () {
  'use strict';
  var box = document.querySelector('[data-cbs-fq]'); if (!box) return;
  var q = box.querySelector('[data-cbs-fq-q]');
  var chips = Array.prototype.slice.call(box.querySelectorAll('[data-cbs-fq-cat]'));
  var rows = Array.prototype.slice.call(box.querySelectorAll('[data-cbs-fq-row]'));
  var count = box.querySelector('[data-cbs-fq-count]');
  var none = box.querySelector('[data-cbs-fq-none]');
  var cat = 'All';
  var src = rows.map(function (r) { return { q: r.querySelector('.cbs-fq__qt').textContent, a: r.querySelector('.cbs-fq__a p').textContent }; });

  function esc(s) { return s.replace(/&/g, '&amp;').replace(/</g, '&lt;'); }
  function mark(text, term) {
    if (!term) return esc(text);
    var i = text.toLowerCase().indexOf(term);
    return i < 0 ? esc(text) : esc(text.slice(0, i)) + '<mark>' + esc(text.slice(i, i + term.length)) + '</mark>' + esc(text.slice(i + term.length));
  }

  function apply() {
    var term = q.value.trim().toLowerCase(), n = 0;
    rows.forEach(function (r, i) {
      var inCat = cat === 'All' || r.getAttribute('data-cat') === cat;
      var hit = !term || (src[i].q + ' ' + src[i].a).toLowerCase().indexOf(term) > -1;
      r.hidden = !(inCat && hit);
      r.querySelector('.cbs-fq__qt').innerHTML = mark(src[i].q, term);
      r.querySelector('.cbs-fq__a p').innerHTML = mark(src[i].a, term);
      if (!r.hidden) n++;
    });
    none.hidden = n > 0;
    count.textContent = n + (n === 1 ? ' question' : ' questions') + (term ? ' match “' + q.value.trim() + '”' : '') + (cat !== 'All' ? ' in ' + cat : '');
  }

  chips.forEach(function (c) {
    c.addEventListener('click', function () {
      cat = c.getAttribute('data-cbs-fq-cat');
      chips.forEach(function (x) { x.setAttribute('aria-pressed', String(x === c)); });
      apply();
    });
  });
  q.addEventListener('input', apply);
  q.addEventListener('keydown', function (e) { if (e.key === 'Escape') { q.value = ''; apply(); } });
})();
