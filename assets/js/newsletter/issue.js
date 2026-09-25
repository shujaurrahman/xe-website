/* Dispatch · issue — folds the sample issue into a reader.

   The HTML ships as the whole issue in reading order, with the contents rail's tablist hidden because
   without this file the tabs would control nothing. Here the tablist is revealed, the blocks become
   panes and the pair is wired up as a real tab set:

     roving tabindex · ArrowLeft/Right/Up/Down · Home / End · aria-selected · aria-controls
     panes take role="tabpanel" and are labelled by their tab, and are made programmatically
     reachable (tabindex="0") because a panel can hold links
     a polite live region names the block and its length as the reader moves

   Nothing here loops, autoplays or steals focus: it is a document, and it behaves like one. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.getElementById('issue-app');
  if (!root) return;

  var tabsBox = root.querySelector('[data-iss-tabs]');
  var body    = root.querySelector('[data-iss-body]');
  var live    = root.querySelector('[data-iss-live]');
  var now     = root.querySelector('[data-iss-now]');
  var tabs    = BDH.$$('[data-iss-tab]', root);
  var panes   = BDH.$$('[data-iss-pane]', root);
  if (!tabsBox || !body || !tabs.length || tabs.length !== panes.length) return;

  /* pane key -> pane, so the order of the two lists never has to match */
  var byKey = {};
  panes.forEach(function (p) { byKey[p.getAttribute('data-iss-pane')] = p; });
  for (var n = 0; n < tabs.length; n++) {
    if (!byKey[tabs[n].getAttribute('data-iss-tab')]) return;   /* markup out of step: leave the document alone */
  }

  panes.forEach(function (p) {
    var key = p.getAttribute('data-iss-pane');
    p.setAttribute('role', 'tabpanel');
    p.setAttribute('tabindex', '0');
    p.setAttribute('aria-labelledby', 'issue-t-' + key);
  });

  tabsBox.hidden = false;
  /* .is-init suppresses the transition for one frame, so folding six open blocks into one pane on
     load happens instantly instead of fading five of them out in front of the reader */
  root.classList.add('is-app', 'is-init');
  if (now) now.hidden = false;
  requestAnimationFrame(function () {
    requestAnimationFrame(function () { root.classList.remove('is-init'); });
  });

  var cur = 0;

  function show(i, focus) {
    i = (i % tabs.length + tabs.length) % tabs.length;
    cur = i;
    tabs.forEach(function (t, n) {
      var on = n === i;
      t.setAttribute('aria-selected', on ? 'true' : 'false');
      t.tabIndex = on ? 0 : -1;
      var pane = byKey[t.getAttribute('data-iss-tab')];
      pane.classList.toggle('is-on', on);
      if (on) {
        if (now) now.textContent = 'Block ' + (t.querySelector('.nlt-iss__tn') || { textContent: '' }).textContent + ' of ' + tabs.length;
        if (live) live.textContent = (t.querySelector('.nlt-iss__tfull') || t).textContent
          + ' — ' + (t.querySelector('.nlt-iss__tw') || { textContent: '' }).textContent.replace(' w', ' words');
      }
    });
    if (focus) tabs[i].focus();
  }

  tabs.forEach(function (t, n) {
    t.addEventListener('click', function () { show(n); });
    t.addEventListener('keydown', function (e) {
      var k = e.key, j = -1;
      if (k === 'ArrowRight' || k === 'ArrowDown') j = n + 1;
      else if (k === 'ArrowLeft' || k === 'ArrowUp') j = n - 1;
      else if (k === 'Home') j = 0;
      else if (k === 'End') j = tabs.length - 1;
      else return;
      e.preventDefault();
      show(j, true);
    });
  });

  /* a link inside a hidden pane must never be reachable by Tab */
  show(0);
})();
