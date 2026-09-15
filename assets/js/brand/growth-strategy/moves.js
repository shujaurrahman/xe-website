/* Growth Strategy · 08 move board — owner chips filter the cards; remaining cards re-flow with FLIP,
   column counts and the live status update. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cgs-moves]'); if (!root) return;
  var chips = BDH.$$('[data-cgs-owner]', root);
  var cards = BDH.$$('.cgs-mv__card', root);
  var cols = BDH.$$('.cgs-mv__col', root);
  var status = root.querySelector('[data-cgs-mvstatus]');
  var timer = 0;

  function apply(owner) {
    chips.forEach(function (c) { c.setAttribute('aria-pressed', c.getAttribute('data-cgs-owner') === owner ? 'true' : 'false'); });
    var first = cards.map(function (c) { return c.getBoundingClientRect(); });
    var keep = function (c) { return owner === 'all' || c.getAttribute('data-owner') === owner; };
    clearTimeout(timer);
    if (BDH.reduced) { finish(); return; }
    cards.forEach(function (c) { if (!keep(c) && !c.classList.contains('is-out')) c.classList.add('is-leaving'); });
    timer = setTimeout(finish, 260);

    function finish() {
      var before = cards.map(function (c) { return c.getBoundingClientRect(); });
      cards.forEach(function (c) {
        var k = keep(c), wasOut = c.classList.contains('is-out');
        c.classList.remove('is-leaving');
        c.classList.toggle('is-out', !k);
        if (k && wasOut && !BDH.reduced) { c.style.opacity = '0'; c.style.transform = 'translateY(10px)'; }
      });
      cards.forEach(function (c, i) {
        if (BDH.reduced || c.classList.contains('is-out')) return;
        var now = c.getBoundingClientRect(), b = before[i];
        if (c.style.opacity === '0') {
          requestAnimationFrame(function () { c.style.opacity = ''; c.style.transform = ''; });
          return;
        }
        var dy = b.top - now.top;
        if (!dy || !b.height) return;
        c.style.transition = 'none'; c.style.transform = 'translateY(' + dy + 'px)';
        c.getBoundingClientRect();
        c.style.transition = ''; c.style.transform = '';
      });
      var total = 0;
      cols.forEach(function (col) {
        var n = BDH.$$('.cgs-mv__card:not(.is-out)', col).length; total += n;
        col.querySelector('[data-cgs-count]').textContent = n;
        col.querySelector('[data-cgs-unit]').textContent = n === 1 ? 'move' : 'moves';
      });
      status.textContent = owner === 'all' ? 'Showing all ' + total + ' moves' : 'Showing ' + total + ' moves owned by ' + owner;
    }
    void first;
  }
  chips.forEach(function (c) { c.addEventListener('click', function () { apply(c.getAttribute('data-cgs-owner')); }); });
})();
