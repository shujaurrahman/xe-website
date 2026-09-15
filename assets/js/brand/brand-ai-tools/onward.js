/* 13 Onward listing — hovering or focusing a row types its cd command into the prompt line. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var ui = document.querySelector('.cat-ls__ui'); if (!ui) return;
  var cmd = ui.querySelector('[data-ls-cmd]'), line = ui.querySelector('.cat-ls__cmd');
  if (!cmd) return;
  var typer = null, last = cmd.textContent;

  BDH.live(line, 0.2, function () {});
  BDH.$$('[data-cd]', ui).forEach(function (a) {
    function show() {
      var t = 'cd ' + a.getAttribute('data-cd');
      if (t === last) return; last = t;
      if (typer) typer.stop();
      cmd.textContent = '';
      typer = BDH.type(cmd, t, { speed: 22 });
    }
    a.addEventListener('mouseenter', show);
    a.addEventListener('focus', show);
  });
})();
