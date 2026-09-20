/* Hub · delivery — phase tabs (BDH.tabs: arrows, Home/End) swap the pane and light the lane bars that belong
   to the phase. Lane bars grow in on entry (.bdh-grow under [data-bdh-in]). Until the reader takes over, a
   playhead walks the board: it crosses each phase, selects it, and each gate it reaches lights up.
   Reduced motion: the tabs work; no playhead. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tih-dlv');
  if (!root) return;
  var board = BDH.$('.tih-dlv__board', root);
  var tabs = BDH.$$('.tih-dlv__ph', root);
  var bars = BDH.$$('.tih-dlv__bar', root);
  var gates = BDH.$$('.tih-dlv__gate', root);
  var play = BDH.$('.tih-dlv__play', root);
  if (!tabs.length) return;

  function light(i) {
    bars.forEach(function (b) {
      var f = +b.getAttribute('data-from'), t = +b.getAttribute('data-to');
      b.classList.toggle('is-sel', f <= i && i <= t);
    });
  }
  /* on a narrow screen the board scrolls sideways: bring the chosen phase into view with its pane */
  var scroller = BDH.$('.tih-dlv__scroll', root);
  function reveal(i) {
    if (!scroller || scroller.scrollWidth <= scroller.clientWidth + 4) return;
    var t = tabs[i]; if (!t) return;
    var r = t.getBoundingClientRect(), b = scroller.getBoundingClientRect();
    if (r.left < b.left + 8 || r.right > b.right - 8) {
      scroller.scrollTo({ left: scroller.scrollLeft + (r.left - b.left) - 28, behavior: BDH.reduced ? 'auto' : 'smooth' });
    }
  }
  var api = BDH.tabs(root, { tabs: '.tih-dlv__ph', onChange: function (i) { light(i); reveal(i); } });
  reveal(api && typeof api.index === 'function' ? api.index() : 0);

  if (BDH.reduced || !board || !play) return;

  /* the playhead runs from the gate row down through the lanes */
  var gateRow = BDH.$('.tih-dlv__gates', root);
  function placeTop() { if (gateRow) play.style.top = (gateRow.offsetTop + 10) + 'px'; }
  placeTop();
  window.addEventListener('resize', placeTop, { passive: true });

  /* x positions on the board: the start of phase 0, the boundary after each phase, a point inside Run */
  function edge(i) {
    var b = board.getBoundingClientRect(), r = tabs[i].getBoundingClientRect();
    return r.right - b.left + 3;
  }
  function startX() { var b = board.getBoundingClientRect(); return tabs[0].getBoundingClientRect().left - b.left; }
  function runX() { var b = board.getBoundingClientRect(), r = tabs[tabs.length - 1].getBoundingClientRect(); return r.left - b.left + r.width * 0.5; }
  function move(x, ms) {
    play.style.transition = ms ? 'transform ' + ms + 'ms cubic-bezier(.45,0,.55,1), opacity .4s' : 'opacity .4s';
    play.style.transform = 'translateX(' + x.toFixed(1) + 'px)';
  }
  function hit(g) { gates.forEach(function (x, n) { x.classList.toggle('is-hit', n <= g && g > -1); }); }

  var steps = [
    [700,  function () { hit(-1); move(startX(), 0); root.classList.add('is-playing'); api.show(0); }],
    [200,  function () { move(edge(0), 1400); }],
    [1400, function () { api.show(1); }],
    [150,  function () { move(edge(1), 1400); }],
    [1400, function () { hit(0); api.show(2); }],
    [900,  function () { move(edge(2), 3400); }],
    [3400, function () { hit(1); api.show(3); }],
    [900,  function () { move(edge(3), 1400); }],
    [1400, function () { hit(2); api.show(4); }],
    [900,  function () { move(runX(), 1000); }],
    [1000, function () { hit(3); }],
    [3000, function () { root.classList.remove('is-playing'); }]
  ];
  BDH.seq(root, steps, {
    loop: true,
    onStop: function () { root.classList.remove('is-playing'); hit(-1); }
  });
})();
