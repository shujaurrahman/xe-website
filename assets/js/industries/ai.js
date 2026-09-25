/* Industries · ai — the console's tablist. BDH.tabs does the ARIA, the keyboard and the pane switching;
   auto-advance walks the six categories until the first interaction, and never runs under reduced motion
   or while the console is off screen. The first pane ships with .is-on, so with JavaScript off the
   console already shows a complete run and this file only adds the switching. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-ind-ai]');
  if (!root) return;

  /* the log's line-by-line entrance is opt-in: the class arrives only when the console is on screen,
     so the shipped HTML stays the finished state and the animation is never mid-flight off screen */
  BDH.enter(root, { cls: 'is-anim' });

  BDH.tabs(root, {
    tabs: '.ind-ai__seg [role="tab"]',
    panes: '.ind-ai__pane',
    auto: 7000,
    orientation: 'horizontal',
    interactRoot: root
  });
})();
