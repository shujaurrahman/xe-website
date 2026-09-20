/* AI Strategy & Agents · governance — the framework buttons filter the crosswalk (chips that answer
   the chosen framework stay lit and their matching clause tag turns blue; the readout counts them).
   On phones a switch shows one function at a time, each with its first two artefacts behind a
   "Show all" disclosure, and a
   chosen framework shows only the artefacts that answer it. On entry the artefact chips drop into
   their columns in sequence; after that (.is-settled) the filter applies without the stagger.
   Reduced motion: no drop; filter and disclosure still work. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var gv = document.querySelector('[data-tas-gv]'); if (!gv) return;
  var btns = BDH.$$('[data-gv-fw]', gv), chips = BDH.$$('.tas-gv__chip', gv), ro = gv.querySelector('[data-gv-ro]');
  var NAMES = {};
  btns.forEach(function (b) {
    var n = b.querySelector('.tas-gv__fwn, .tas-gv__word, .xt-badge__name, .xt-badge__code');
    NAMES[b.getAttribute('data-gv-fw')] = n ? n.textContent.trim() : b.getAttribute('data-gv-fw');
  });
  var total = chips.length;
  var cols = BDH.$$('.tas-gv__col', gv);
  gv.classList.add('is-js');
  cols.forEach(function (col) {
    var more = col.querySelector('[data-gv-more]'); if (!more) return;
    more.hidden = false;
    var label = more.textContent;
    more.addEventListener('click', function () {
      var open = !col.classList.contains('is-open');
      col.classList.toggle('is-open', open);
      more.setAttribute('aria-expanded', open ? 'true' : 'false');
      more.textContent = open ? 'Show fewer' : label;
    });
  });

  /* phones: one function at a time (the switch only shows below 560px) */
  var fnsw = gv.querySelector('[data-gv-fnsw]');
  if (fnsw) {
    var fbtns = BDH.$$('[data-gv-col]', fnsw);
    fnsw.hidden = false;
    gv.setAttribute('data-colon', fbtns.length ? fbtns[0].getAttribute('data-gv-col') : 'govern');
    fbtns.forEach(function (b) {
      b.addEventListener('click', function () {
        gv.setAttribute('data-colon', b.getAttribute('data-gv-col'));
        fbtns.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
      });
    });
  }

  function filter(fw) {
    gv.classList.add('is-settled');
    gv.setAttribute('data-fw', fw);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-gv-fw') === fw ? 'true' : 'false'); });
    var hits = 0;
    chips.forEach(function (c) {
      var keys = (c.getAttribute('data-fw') || '').split(' ');
      var hit = fw !== 'all' && keys.indexOf(fw) > -1;
      c.classList.toggle('is-hit', hit);
      if (hit) hits++;
      BDH.$$('.tas-gv__tags span', c).forEach(function (t) { t.classList.toggle('is-hit', hit && t.getAttribute('data-fw') === fw); });
    });
    cols.forEach(function (col) { col.classList.toggle('is-empty', fw !== 'all' && !col.querySelector('.tas-gv__chip.is-hit')); });
    if (!ro) return;
    ro.innerHTML = '';
    var b = document.createElement('b');
    if (fw === 'all') {
      b.textContent = String(total);
      ro.appendChild(b); ro.appendChild(document.createTextNode(' artefacts across the four functions of NIST AI RMF 1.0 · frameworks we build to, not badges we hold'));
    } else {
      b.textContent = hits + ' of ' + total;
      ro.appendChild(b); ro.appendChild(document.createTextNode(' artefacts answer an obligation or control in ' + (NAMES[fw] || fw) + ' · the blue tag names the clause'));
    }
  }
  btns.forEach(function (b) { b.addEventListener('click', function () { filter(b.getAttribute('data-gv-fw')); }); });

  if (BDH.reduced) return;
  gv.classList.add('is-armed');
  BDH.enter(gv, { delay: 200, io: { threshold: 0.05, rootMargin: '0px 0px -20% 0px' } });
  /* the entrance stagger only applies while the chips drop in; then filtering responds at once */
  BDH.inView(gv, function () { setTimeout(function () { gv.classList.add('is-settled'); }, 200 + chips.length * 45 + 700); }, { threshold: 0.05, rootMargin: '0px 0px -20% 0px' });
})();
