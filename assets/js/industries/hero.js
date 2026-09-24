/* Industries hero — the constraint map fills in column by column when it enters the viewport. */
(function () { 'use strict'; if (!window.BDH) return;
  var map = document.querySelector('.ind-hero [data-ind-map]'); if (!map) return;
  if (BDH.reduced) return;
  var rows = map.querySelectorAll('tbody tr');
  for (var r = 0; r < rows.length; r++) rows[r].style.setProperty('--ri', r);
  map.classList.add('is-anim');
  BDH.inView(map, function () { requestAnimationFrame(function () { map.classList.add('is-in'); }); });
})();
