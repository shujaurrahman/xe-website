/* 02 brandctl --help — vertical tablist; the selected command types its example run.
   Rotates through commands until the first interaction (wide screens only). */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.cat-help'); if (!root) return;
  var ui = root.querySelector('.cat-help__ui'); if (!ui) return;
  var panes = BDH.$$('.cat-help__pane', root);
  var typer = null;

  panes.forEach(function (p) {
    BDH.$$('.cat-help__run li', p).forEach(function (li, n) { li.style.setProperty('--i', n); li.setAttribute('data-t', li.textContent); });
  });

  function play(i) {
    if (BDH.reduced) return;
    var p = panes[i]; if (!p) return;
    if (typer) { typer.finish(); typer = null; }
    panes.forEach(function (x) { x.classList.remove('is-play'); });
    void p.offsetWidth;
    p.classList.add('is-play');
    var first = p.querySelector('.cat-help__run li');
    if (first) typer = BDH.type(first, first.getAttribute('data-t'), { speed: 18 });
  }

  var wide = window.matchMedia('(min-width: 861px)').matches;
  var tabs = BDH.tabs(ui, {
    tabs: '.cat-help__cmd', auto: wide ? 6500 : 0, orientation: 'vertical', interactRoot: ui,
    onChange: function (i) { play(i); }
  });
  BDH.inView(ui, function () { play(tabs.index()); });
})();
