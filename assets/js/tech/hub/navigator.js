/* Hub · navigator dock — visible (and focusable) from the moment the in-page index has scrolled away until
   the end of #standards, which covers the run of sections that name capabilities by number (platform, the
   composer, the stack wall and the standards panel) — the stretch where "which capability was that?" is the
   live question. Below 1024 px there is no room for it. Glyph motion is CSS only. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var dock = document.querySelector('.tih-dock');
  var index = document.getElementById('navigator');
  var end = document.getElementById('standards');
  if (!dock || !index || !end) return;

  var on = null, queued = false;
  function sync() {
    queued = false;
    var vh = window.innerHeight || document.documentElement.clientHeight;
    var want = window.innerWidth >= 1024 &&
      index.getBoundingClientRect().bottom < 0 &&
      end.getBoundingClientRect().bottom > vh * 0.5;
    if (want === on) return;
    on = want;
    dock.classList.toggle('is-on', want);
    if (want) dock.removeAttribute('inert'); else dock.setAttribute('inert', '');
  }
  function req() { if (!queued) { queued = true; requestAnimationFrame(sync); } }
  window.addEventListener('scroll', req, { passive: true });
  window.addEventListener('resize', req, { passive: true });
  sync();
})();
