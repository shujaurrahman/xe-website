/* AI Product & Automation · inspector — SIGNATURE demo.
   Question tabs (ARIA tablist, vertical, arrow keys) switch prebuilt panes. Each switch replays the run:
   chunks slide in ranked, the reranker reorders them (FLIP via CSS --d), the answer streams word by word with
   citation markers, eval bars fill. Autoplay cycles questions while on screen until the first interaction.
   Stage headers are disclosures synced across both columns and all questions so rows stay aligned.
   "No retrieval" swaps column A for the bare model answer. Under 700 px an A | B switch shows one column at a
   time and a sticky strip compares both columns' scores. Results are announced politely on user action.
   Reduced motion: no playback, the finished HTML stays as is; every control still works. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tap-ins'); if (!root) return;
  var R = BDH.reduced;
  var panes = BDH.$$('.tap-ins__pane', root);
  var live = root.querySelector('[data-ins-live]');
  var sw = root.querySelector('[data-ins-bare]');
  var timers = [];

  function later(ms, fn) { timers.push(setTimeout(fn, ms)); }
  function reset() {
    timers.forEach(clearTimeout); timers = [];
    panes.forEach(function (p) { p.classList.remove('is-play', 's-ret', 's-rr', 's-ans', 's-ev'); });
  }
  function words(p) {
    var n = 0;
    BDH.$$('.tap-ins__ans', p).forEach(function (a) {
      if (a.offsetParent === null) return;
      n = Math.max(n, a.querySelectorAll('.w').length);
    });
    return n;
  }
  function play(p) {
    if (R || !p) return;
    reset();
    /* jump to the start state with transitions off, so nothing animates backwards first */
    p.classList.add('no-tr', 'is-play');
    void p.offsetWidth;
    p.classList.remove('no-tr');
    var w = words(p) * 24;
    later(60, function () { p.classList.add('s-ret'); });
    later(1000, function () { p.classList.add('s-rr'); });
    later(1900, function () { p.classList.add('s-ans'); });
    later(2100 + w, function () { p.classList.add('s-ev'); });
    later(3400 + w, function () { p.classList.remove('is-play', 's-ret', 's-rr', 's-ans', 's-ev'); });
  }
  function say(t) { if (live) live.textContent = t; }
  function summary(i) { return panes[i] ? panes[i].getAttribute('data-ins-sum') : ''; }

  /* disclosures: one stage number toggles that row everywhere */
  var btns = BDH.$$('[data-ins-stage]', root);
  btns.forEach(function (b) {
    b.addEventListener('click', function () {
      var n = b.getAttribute('data-ins-stage');
      var open = b.getAttribute('aria-expanded') !== 'true';
      btns.forEach(function (x) {
        if (x.getAttribute('data-ins-stage') !== n) return;
        x.setAttribute('aria-expanded', String(open));
        var region = document.getElementById(x.getAttribute('aria-controls'));
        if (region) region.hidden = !open;
      });
    });
  });

  /* question tabs */
  var tabs = BDH.tabs(root, {
    tabs: '.tap-ins__qs [role="tab"]',
    orientation: 'vertical',
    auto: R ? 0 : 12500,
    interactRoot: root,
    onChange: function (i, prev, byUser) {
      play(panes[i]);
      if (byUser) say(summary(i));
    }
  });

  /* narrow screens: A | B pipeline switch (one column at a time; the sticky strip compares both) */
  var abs = BDH.$$('[data-ins-ab]', root);
  var alabel = root.querySelector('[data-ins-alabel]');
  abs.forEach(function (b) {
    b.addEventListener('click', function () {
      var bSide = b.getAttribute('data-ins-ab') === '1';
      abs.forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
      root.classList.toggle('is-b', bSide);
      say(bSide ? 'Showing column B, tuned RAG.' : 'Showing column A, ' + (root.classList.contains('is-bare') ? 'the model answering alone.' : 'baseline RAG.'));
    });
  });

  /* no-retrieval switch */
  if (sw) {
    sw.addEventListener('click', function () {
      var on = sw.getAttribute('aria-pressed') !== 'true';
      sw.setAttribute('aria-pressed', String(on));
      root.classList.toggle('is-bare', on);
      if (alabel) alabel.textContent = on ? 'Model only' : 'Baseline';
      var i = tabs.index();
      say(on ? 'Retrieval off. Column A now shows the model answering alone, flagged as ungrounded, with no sources to cite.' : 'Retrieval on. Column A shows the baseline RAG pipeline again. ' + summary(i));
      play(panes[i]);
    });
  }

  if (R) return;
  BDH.inView(root, function () { play(panes[Math.max(0, tabs.index())]); }, { threshold: 0.3 });
})();
