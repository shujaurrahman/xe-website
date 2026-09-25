/* Hub · hero — types the event feed one line at a time and pulses the source row that line belongs to,
   only while the panel is on screen. The HTML already holds the finished panel with the first line
   written, so nothing here is needed for the page to read: .is-anim is added at init so the text block
   can animate from hidden, and under reduced motion it is never added. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('.mth-hero');
  if (!root) return;

  /* entrance — add the hidden start state only once JS is running (defect class 1) */
  if (!BDH.reduced) {
    root.classList.add('is-anim');
    BDH.enter(root);
  }

  var feed = BDH.$('.mth-hero__feed', root);
  if (!feed || BDH.reduced) return;

  var lines = [];
  try { lines = JSON.parse(feed.getAttribute('data-feed') || '[]'); } catch (err) { lines = []; }
  if (lines.length < 2) return;

  var elT = BDH.$('.mth-hero__ft', feed);
  var elS = BDH.$('.mth-hero__fs', feed);
  var elX = BDH.$('.mth-hero__fxt', feed);
  var srcs = BDH.$$('.mth-hero__src', root);
  if (!elT || !elS || !elX) return;

  /* which source row a feed stage lights up */
  var hit = { collect: 3, resolve: 0, decide: 1, consent: 1, produce: 2, activate: 3, measure: 0, approve: 2 };
  var i = 0, typer = null;

  function show(n) {
    var ln = lines[n];
    elT.textContent = ln[0];
    elS.textContent = ln[1];
    if (typer) typer.stop();
    typer = BDH.type(elX, ln[2], { speed: 12 });
    var k = hit[ln[1]];
    srcs.forEach(function (el, m) { el.classList.toggle('is-hit', m === k); });
  }

  BDH.loop(feed, 2600, function () {
    i = (i + 1) % lines.length;
    show(i);
  });
})();
