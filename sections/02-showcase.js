/* 02 — Brief ⇄ Delivered. It runs itself: the rule fills across, then the pane
   turns over. Clicking a pill takes control. */
(function () {
  'use strict';
  var sec = document.querySelector('.s02');
  if (!sec || !window.XE) return;

  var toggle = XE.$('.s02__toggle', sec);
  var tabs = XE.$$('.s02__pill', sec);
  var panes = XE.$$('.s02__pane', sec);
  var stage = XE.$('.s02__panes', sec);
  if (tabs.length < 2 || panes.length < 2) return;

  var i = 0, pinned = false, t1 = null, t2 = null;

  function paint(n) {
    i = n % tabs.length;
    tabs.forEach(function (t, k) {
      var on = k === i;
      t.setAttribute('aria-selected', String(on));
      t.setAttribute('tabindex', on ? '0' : '-1');
    });
    panes.forEach(function (p, k) {
      var on = k === i;
      p.classList.toggle('is-on', on);
      if (on) p.removeAttribute('aria-hidden'); else p.setAttribute('aria-hidden', 'true');
    });
    if (stage) stage.setAttribute('data-dir', i === 0 ? 'back' : 'fwd');
    toggle.classList.toggle('is-far', i === 1);
  }

  function clear() { clearTimeout(t1); clearTimeout(t2); toggle.classList.remove('is-travel', 'is-back'); }

  /* one leg of the loop: fill the rule, then turn the pane over */
  function travel() {
    if (pinned) return;
    var forward = i === 0;
    toggle.classList.add(forward ? 'is-travel' : 'is-back');
    t1 = setTimeout(function () {
      if (pinned) return;
      toggle.classList.remove('is-travel', 'is-back');
      paint(forward ? 1 : 0);
      t2 = setTimeout(travel, 4200);
    }, 1500);
  }

  function take(k) {
    pinned = true;
    clear();
    paint(k);
  }

  tabs.forEach(function (t, k) {
    XE.on(t, 'click', function () { take(k); });
    XE.on(t, 'keydown', function (e) {
      var d = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0;
      if (!d) return;
      e.preventDefault();
      var n = (k + d + tabs.length) % tabs.length;
      take(n); tabs[n].focus();
    });
  });

  paint(0);
  if (!XE.reduced) {
    sec.classList.add('is-live');
    XE.inView(sec, function () { t2 = setTimeout(travel, 2200); });
  }
})();
