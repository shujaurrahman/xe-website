/* Hub · hero — the session runs. The trace draws itself in (CSS, .bdh-draw on .is-in), then a marker
   travels it in the order the participant moved, the moderator's notes are typed one at a time, and the
   readouts drift by a point or two. Everything runs only while the panel is on screen and the tab is
   visible. Reduced motion: the markup's finished state is left exactly as it is. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.pxh-hero');
  var panel = root && root.querySelector('.pxh-hero__panel');
  if (!panel || BDH.reduced) return;

  /* ---- the marker travelling the traced session ---- */
  var mark = BDH.$('.pxh-hero__mark', panel);
  if (mark && mark.animate) {
    var running = false;
    function run() {
      if (running || !panel.classList.contains('is-live')) return;
      running = true;
      var a = mark.animate([
        { strokeDashoffset: 0, opacity: 0 },
        { opacity: 1, offset: 0.05 },
        { opacity: 1, offset: 0.95 },
        { strokeDashoffset: -0.996, opacity: 0 }
      ], { duration: 5200, easing: 'linear' });
      a.onfinish = function () { running = false; };
      a.oncancel = function () { running = false; };
    }
    BDH.inView(panel, function () { setTimeout(run, 1900); }, { threshold: 0.2 });
    BDH.loop(panel, 6400, run);
  }

  /* ---- the session tape: one note at a time, typed ---- */
  var tape = BDH.$('.pxh-hero__tape', panel);
  if (tape) {
    var notes = [];
    try { notes = JSON.parse(tape.getAttribute('data-tape') || '[]'); } catch (err) { notes = []; }
    var who = BDH.$('.pxh-hero__tw', tape);
    var at = BDH.$('.pxh-hero__tt', tape);
    var txt = BDH.$('.pxh-hero__txt', tape);
    var n = 0, typer = null;
    if (notes.length > 1 && txt) {
      BDH.loop(tape, 3400, function () {
        n = (n + 1) % notes.length;
        var note = notes[n];
        if (typer) typer.finish();
        if (who) who.textContent = note[0];
        if (at) at.textContent = note[1];
        typer = BDH.type(txt, note[2], { speed: 16 });
      });
    }
  }

  /* ---- readouts: task success and time on task drift a little; SUS and the round do not.
     86 %, 41 s and 78 are stated again in #measures, so the drift stays inside ±1 of each. ---- */
  var out = {};
  BDH.$$('.pxh-hero__read b', panel).forEach(function (b) { out[b.getAttribute('data-k')] = b; });
  function set(key, text) {
    var b = out[key];
    if (!b || b.textContent === text) return;
    b.classList.add('is-tick');
    setTimeout(function () { b.textContent = text; b.classList.remove('is-tick'); }, 170);
  }
  var task = 86, time = 41, tick = 0;
  BDH.loop(panel, 2600, function () {
    tick++;
    if (tick % 2 === 0) {
      task = task === 86 ? 85 : 86;
      set('task', String(task));
    } else {
      time = time === 41 ? 42 : 41;
      set('time', String(time));
    }
  });
})();
