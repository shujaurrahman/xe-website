/* Search & AI Visibility — 10 · Process.
   Two jobs, both optional: BDH.tabs wires the stage rail to the detail panes (and mirrors the
   chosen stage onto the calendar so the other workstreams step back), and a single sweep fills
   the 90-day strip from week one to week thirteen the first time it is on screen.
   The markup is already the finished state: the first stage is selected server-side and every
   scheduled cell renders filled. This file only holds cells back so they can arrive in order,
   and it hands the whole strip over the moment anyone touches the section. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-tsv-proc]');
  if (!root) return;

  var cal    = root.querySelector('[data-tsv-cal]');
  var stages = [].map.call(root.querySelectorAll('.tsv-proc__stage'), function (b) {
    return b.getAttribute('data-stage') || 'all';
  });

  /* ---- stage rail ------------------------------------------------------- */
  BDH.tabs(root, {
    tabs: '.tsv-proc__stage',
    panes: '.tsv-proc__pane',
    orientation: 'vertical',
    onChange: function (i) {
      if (cal) cal.setAttribute('data-stage', stages[i] || 'all');
    }
  });

  if (cal) cal.setAttribute('data-stage', stages[0] || 'all');

  /* ---- the week-by-week fill -------------------------------------------- */
  if (!cal) return;

  var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduced) return;

  var cells  = [].slice.call(cal.querySelectorAll('.tsv-cal__c.is-on, .tsv-cal__c.is-beat'));
  var read   = cal.querySelector('[data-tsv-week]');
  var weeks  = 13;
  var done   = false;
  var timer  = null;
  var week   = 0;

  if (!cells.length) return;

  function label(n) {
    return 'W' + (n < 10 ? '0' + n : String(n));
  }

  function paint() {
    cells.forEach(function (c) {
      var w = parseInt(c.getAttribute('data-w'), 10) || 0;
      c.classList.toggle('is-hold', w > week);
    });
    if (read) read.textContent = label(Math.max(week, 1));
  }

  function finish() {
    if (done) return;
    done = true;
    if (timer) { timer.stop(); timer = null; }
    week = weeks;
    cells.forEach(function (c) { c.classList.remove('is-hold'); });
    if (read) read.textContent = label(weeks);
  }

  /* hold everything back, then release a week at a time while the strip is on screen */
  paint();
  timer = BDH.loop(cal, 230, function () {
    week += 1;
    paint();
    if (week >= weeks) finish();
  });

  BDH.onInteract(root, finish);
})();
