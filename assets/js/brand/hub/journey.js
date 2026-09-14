/* Hub · programme map — stage tabs with autoplay (stops on first interaction), a playhead that
   moves to the chosen stage's first week, and previous / next buttons. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.bdh-journey');
  if (!root) return;
  var rows = BDH.$$('.bdh-jr__row', root);
  if (!rows.length) return;
  var play = BDH.$('.bdh-jr__play', root);
  var count = BDH.$('.bdh-jr__count b', root);
  var weeks = 20;

  function pad(n) { return (n < 10 ? '0' : '') + n; }
  function place(i) {
    if (!play) return;
    var track = rows[i].querySelector('.bdh-jr__track');
    if (!track) return;
    var s = parseFloat(rows[i].style.getPropertyValue('--s')) || 1;
    var w = track.getBoundingClientRect().width;
    play.style.setProperty('--x', ((s - 1) / weeks * w).toFixed(1) + 'px');
  }

  var api = BDH.tabs(root, {
    tabs: '.bdh-jr__row',
    auto: 6000,
    orientation: 'vertical',
    onChange: function (i) { place(i); if (count) count.textContent = pad(i + 1); }
  });

  BDH.$$('.bdh-jr__btn', root).forEach(function (b) {
    b.addEventListener('click', function () {
      api.stop();
      api.show(api.index() + parseInt(b.getAttribute('data-dir'), 10), true);
    });
  });

  place(api.index());
  window.addEventListener('resize', function () { place(api.index()); }, { passive: true });
})();
