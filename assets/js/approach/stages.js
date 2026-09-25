/* Approach · Stages — upgrades the stage list into a stepper.
   The HTML ships as a complete <ol> of six stages plus two rails: a <nav> of in-page links (what a
   reader without JavaScript uses) and a hidden tablist carrying the right ARIA. Here we swap them and
   hand the tablist to BDH.tabs, which gives arrow-key, Home and End navigation and toggles [hidden] on
   each pane. If anything in this file fails, the page is left exactly as it shipped: every stage on the
   page, in order, with working jump links. There is no loop and no auto-advance, so reduced motion
   needs no special case — the pane cross-fade is declared in CSS and removed there under reduce. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-apr-stepper]');
  if (!root) return;

  var jump = root.querySelector('[data-apr-jump]');
  var rail = root.querySelector('[data-apr-tabs]');
  var list = root.querySelector('[data-apr-list]');
  if (!rail || !list) return;

  var tabs = BDH.$$('[role="tab"]', rail);
  var panes = BDH.$$('[data-apr-pane]', list);
  if (!tabs.length || tabs.length !== panes.length) return;

  /* The panes are <li> children of an <ol>. Once they carry role="tabpanel" they are no longer
     listitems, so the list itself stops claiming to be a list. */
  list.setAttribute('role', 'presentation');
  panes.forEach(function (p, i) {
    p.setAttribute('role', 'tabpanel');
    p.setAttribute('aria-labelledby', tabs[i].id);
    p.setAttribute('tabindex', '0');
  });

  rail.removeAttribute('hidden');
  if (jump) jump.setAttribute('hidden', '');
  root.classList.add('is-stepper');

  var api = BDH.tabs(root, { tabs: tabs, panes: panes, orientation: 'horizontal' });

  /* A gate chip inside a stage links to the gates section; a link to #stage-<key> from anywhere else
     on the page should select that stage rather than scroll to a hidden panel. */
  function showByHash(hash) {
    if (!hash || hash.indexOf('#stage-') !== 0) return false;
    var el = document.getElementById(hash.slice(1));
    var i = panes.indexOf(el);
    if (i < 0) return false;
    api.show(i, true);
    return true;
  }

  document.addEventListener('click', function (e) {
    var a = e.target && e.target.closest ? e.target.closest('a[href*="#stage-"]') : null;
    if (!a) return;
    var hash = a.getAttribute('href');
    hash = hash.slice(hash.indexOf('#'));
    if (showByHash(hash)) {
      /* keep the deep link shareable, then bring the stepper into view rather than the panel */
      try { window.history.replaceState(null, '', hash); } catch (err) { /* ignore */ }
      e.preventDefault();
      root.scrollIntoView({ block: 'start', behavior: BDH.reduced ? 'auto' : 'smooth' });
    }
  });

  showByHash(window.location.hash);
  window.addEventListener('hashchange', function () { showByHash(window.location.hash); });
})();
