/* Hub · hero — walks a highlight down the run strip and types the run log. The shipped HTML is already
   the finished state, so this script only adds motion: .is-anim (the entrance start state) is added here
   rather than declared in CSS, so with JavaScript off the text is simply visible. Reduced motion: no
   walk, no typing, the strip stays as it shipped. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.aih-hero');
  if (!root) return;

  /* entrance (safe under reduced motion: BDH.enter resolves at once) */
  if (!BDH.reduced) root.classList.add('is-anim');
  BDH.enter(root);

  if (BDH.reduced) return;

  var steps = BDH.$$('.aih-hero__s', root);
  var feed = BDH.$('.aih-hero__feed', root);
  var fs = BDH.$('.aih-hero__fs', root);
  var fx = BDH.$('.aih-hero__fxt', root);

  /* ---- the highlight walks the five stages ---- */
  if (steps.length) {
    var at = -1;
    BDH.loop(root, 1500, function () {
      if (at >= 0 && steps[at]) steps[at].classList.remove('is-at');
      at = (at + 1) % steps.length;
      steps[at].classList.add('is-at');
    });
  }

  /* ---- the run log types one line at a time ---- */
  if (!feed || !fs || !fx) return;
  var lines = [];
  try { lines = JSON.parse(feed.getAttribute('data-feed') || '[]'); } catch (err) { lines = []; }
  if (lines.length < 2) return;

  var i = 0, typing = null;
  var timer = BDH.loop(feed, 3600, function () {
    i = (i + 1) % lines.length;
    if (typing && typing.stop) typing.stop();
    fs.textContent = lines[i][0];
    fx.textContent = '';
    typing = BDH.type(fx, lines[i][1], { speed: 11 });
  });
  if (!timer.running) { /* off screen: the first line shipped in the HTML stays put */ }
})();
