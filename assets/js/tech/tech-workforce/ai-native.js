/* Tech Workforce · ai-native — the mock holds its finished state first and animates second.
   On entry nothing moves for five seconds: the suggestion is accepted and the checks are green,
   which is what the section is about. Only then does the assistant "re-suggest" — the line dims,
   is typed once on the first pass and simply dims on later passes, the checks relight in one fast
   sweep, and the finished state returns. Roughly three quarters of every cycle is the finished
   state, and the line is never left empty for more than the typing itself.
   Loops only while the section is on screen. Under reduced motion, or with this script absent, the
   HTML already shows the finished state and nothing here runs. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-ttw-ai]');
  if (!root || BDH.reduced) return;

  var ghost  = BDH.$('[data-ttw-ghost]', root);
  var code   = BDH.$('[data-ttw-ghost-t]', root);
  var state  = BDH.$('[data-ttw-state]', root);
  var checks = BDH.$$('[data-ttw-check]', root);
  if (!ghost || !code || !checks.length) return;

  var full = code.textContent;
  var typer = null;

  function led(li, on) {
    var l = li.querySelector('.ttw-led');
    if (l) l.classList.toggle('ttw-led--off', !on);
  }

  var steps = [
    /* Five seconds of the finished state before anything moves — including on arrival. */
    [5200, function (ctx) {
      ghost.classList.remove('is-done');
      if (state) state.textContent = 'Assistant suggesting…';
      checks.forEach(function (li) { led(li, false); });
      /* Typed on the first pass only; after that the line keeps its text and simply dims. */
      if (ctx.cycle === 0) {
        code.textContent = '';
        typer = BDH.type(code, full, { speed: 15 });
      }
    }],
    [900, function () {
      if (typer) { typer.finish(); typer = null; }
      ghost.classList.add('is-done');
      if (state) state.textContent = 'Suggestion accepted';
    }]
  ];

  /* The checks relight in one fast pass; the human review stays dark, because it is blocking. */
  checks.forEach(function (li, i) {
    var last = i === checks.length - 1;
    steps.push([i === 0 ? 320 : 150, function () { if (!last) led(li, true); }]);
  });


  BDH.seq(root, steps, { loop: true });
})();
