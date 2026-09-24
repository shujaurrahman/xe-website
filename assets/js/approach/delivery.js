/* Delivery — the stage rail follows the reader; on phones the active chip scrolls into view. */
(function () { 'use strict'; if (!window.BDH) return;
  var root = document.querySelector('.apr-dl'); if (!root) return;
  var links = root.querySelectorAll('[data-apr-stage]'), rail = root.querySelector('.apr-dl__rail');
  function set(id) {
    links.forEach(function (a) {
      var on = a.getAttribute('data-apr-stage') === id;
      a.classList.toggle('is-on', on);
      if (on) { a.setAttribute('aria-current', 'step');
        if (rail && rail.scrollWidth > rail.clientWidth) rail.scrollTo({ left: a.offsetLeft - 16, behavior: BDH.reduced ? 'auto' : 'smooth' });
      } else a.removeAttribute('aria-current');
    });
  }
  BDH.spy(root.querySelectorAll('.apr-stg'), function (el) { set(el.id.replace('stage-', '')); });
})();
