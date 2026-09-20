/* Audits & Assessments · sample — the report-page stack.
   Without this file the five pages simply read down the page in order, which is the finished,
   readable state. This turns them into a fan: the current page in front, the next two offset
   behind it, the ones already read slid off to the left. Only transform and opacity move. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var rig = document.querySelector('[data-taa-sam]');
  if (!rig) return;

  var pages = BDH.$$('[data-taa-sam-pages] > .taa-sam__pg', rig);
  var dots  = BDH.$$('[data-taa-sam-go]', rig);
  var prev  = rig.querySelector('[data-taa-sam-prev]');
  var next  = rig.querySelector('[data-taa-sam-next]');
  var live  = rig.querySelector('[data-taa-sam-live]');
  if (pages.length < 2) return;

  var cur = 0;

  function set(i, announce) {
    cur = (i + pages.length) % pages.length;

    pages.forEach(function (pg, n) {
      var k = n - cur;
      pg.classList.remove('is-cur', 'is-ahead', 'is-far', 'is-back');
      if (k === 0) {
        pg.classList.add('is-cur');
        pg.style.removeProperty('--k');
        pg.removeAttribute('aria-hidden');
      } else if (k < 0) {
        pg.classList.add('is-back');
        pg.style.removeProperty('--k');
        pg.setAttribute('aria-hidden', 'true');
      } else {
        pg.classList.add(k <= 2 ? 'is-ahead' : 'is-far');
        pg.style.setProperty('--k', k);
        pg.setAttribute('aria-hidden', 'true');
      }
    });

    dots.forEach(function (d, n) {
      if (n === cur) { d.setAttribute('aria-current', 'true'); }
      else { d.removeAttribute('aria-current'); }
    });

    if (announce && live) {
      var label = dots[cur] ? dots[cur].textContent.replace(/\s+/g, ' ').trim() : String(cur + 1);
      live.textContent = 'Page ' + (cur + 1) + ' of ' + pages.length + ' — ' + label;
    }
  }

  rig.classList.add('is-live');
  set(0, false);

  if (prev) prev.addEventListener('click', function () { set(cur - 1, true); });
  if (next) next.addEventListener('click', function () { set(cur + 1, true); });
  dots.forEach(function (d, n) {
    d.addEventListener('click', function () { set(n, true); });
  });

  rig.addEventListener('keydown', function (ev) {
    if (ev.key === 'ArrowRight') { set(cur + 1, true); ev.preventDefault(); }
    else if (ev.key === 'ArrowLeft') { set(cur - 1, true); ev.preventDefault(); }
  });
})();
