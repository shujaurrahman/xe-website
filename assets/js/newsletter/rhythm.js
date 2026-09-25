/* Dispatch · rhythm — the scenario switch on the year rail.

   The first scenario is fully rendered by the partial, so with this file absent the section is a
   finished, readable statement of the target year. Here the three buttons become a real group:
   aria-pressed, arrow keys and Home / End, a polite live region, and the rail and the three figures
   recomputed from the sample issue's own measured word count (the data-words attribute the partial
   printed) rather than from anything hard-coded here. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-nlt-rhythm]');
  if (!root) return;

  var btns  = BDH.$$('[data-rhy]', root);
  var slots = BDH.$$('.nlt-rhy__slot', root);
  var nIss  = root.querySelector('[data-rhy-issues]');
  var nWord = root.querySelector('[data-rhy-words]');
  var nMin  = root.querySelector('[data-rhy-mins]');
  var say   = root.querySelector('[data-rhy-say]');
  var live  = root.querySelector('[data-rhy-live]');
  var words = parseInt(root.getAttribute('data-words') || '0', 10);
  if (!btns.length || !slots.length || !nIss || !nWord || !nMin || !say || !words) return;

  /* the sentence under each scenario is in the partial, not here: read it off the DOM once */
  var says = {};
  btns.forEach(function (b) { says[b.getAttribute('data-rhy')] = b.getAttribute('data-say') || ''; });

  function group(n) { return String(n).replace(/\B(?=(\d{3})+(?!\d))/g, ','); }

  var cur = 0;

  function apply(i, focus) {
    i = (i % btns.length + btns.length) % btns.length;
    cur = i;
    var b = btns[i];
    var issues = parseInt(b.getAttribute('data-issues') || '0', 10);

    btns.forEach(function (x, n) {
      x.setAttribute('aria-pressed', n === i ? 'true' : 'false');
      x.tabIndex = n === i ? 0 : -1;
    });
    slots.forEach(function (s, n) {
      var on = n < issues;
      s.classList.toggle('is-on', on);
      var label = s.querySelector('.nlt-rhy__ss');
      if (label) label.textContent = on ? 'Issue' : 'Skipped';
    });

    var mins = Math.round(issues * words / 210);
    nIss.textContent  = String(issues);
    nWord.textContent = group(issues * words);
    nMin.textContent  = String(mins);
    if (says[b.getAttribute('data-rhy')]) say.textContent = says[b.getAttribute('data-rhy')];
    if (live) live.textContent = b.textContent.trim() + ': ' + issues + ' issues a year, about ' + mins + ' minutes of reading.';
    if (focus) b.focus();
  }

  btns.forEach(function (b, n) {
    b.tabIndex = n === 0 ? 0 : -1;
    b.addEventListener('click', function () { apply(n); });
    b.addEventListener('keydown', function (e) {
      var k = e.key, j = -1;
      if (k === 'ArrowRight' || k === 'ArrowDown') j = n + 1;
      else if (k === 'ArrowLeft' || k === 'ArrowUp') j = n - 1;
      else if (k === 'Home') j = 0;
      else if (k === 'End') j = btns.length - 1;
      else return;
      e.preventDefault();
      apply(j, true);
    });
  });
})();
