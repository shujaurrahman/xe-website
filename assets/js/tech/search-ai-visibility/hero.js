/* Search & AI Visibility · hero — the search console.
   The markup already shows the finished state. On entry we arm the cascade, retype the query,
   reveal the results, draw the underline under the "yourcompany.com" citation, then cycle the
   three answer engines while the console is on screen.

   The engine switcher is a real tablist in the markup; BDH.tabs owns the roving tabindex, the
   arrow keys and aria-selected, and choosing an engine pauses the cycle. The Pause control is
   injected here rather than shipped, because with no JS — and under reduced motion — there is no
   cycle for it to pause, and a control that does nothing is worse than no control. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-tsv-console]');
  if (!root) return;

  var typed = root.querySelector('[data-typed-target]');
  var chips = BDH.$$('[data-tsv-chips] .tsv-ans__chip', root);
  var panes = BDH.$$('[data-tsv-panes] .tsv-ans__pane', root);
  var slot  = root.querySelector('[data-tsv-pause]');

  /* ---------- the tablist: wired whether or not the cycle runs ---------- */
  var api = null;
  if (chips.length && panes.length === chips.length) {
    api = BDH.tabs(root, {
      tabs: '.tsv-ans__chip',
      panes: '.tsv-ans__pane',
      orientation: 'horizontal',
      onChange: function (i, prev, byUser) {
        if (byUser && setPaused) setPaused(true);
        if (BDH.reduced) return;
        root.classList.remove('is-cited');
        setTimeout(function () { root.classList.add('is-cited'); }, 420);
      }
    });
  }

  if (BDH.reduced) { root.classList.add('is-cited'); return; }

  /* ---------- the entry cascade ---------- */
  var query = typed ? typed.textContent : '';
  root.classList.add('is-armed');
  BDH.$$('.tsv-res', root).forEach(function (el, i) { el.style.setProperty('--i', i); });

  var started = false;
  BDH.inView(root, function () {
    if (started) return;
    started = true;
    if (typed) { typed.textContent = ''; }
    root.classList.add('is-in');
    setTimeout(function () {
      if (typed) {
        BDH.type(typed, query, {
          speed: 26,
          done: function () { setTimeout(function () { root.classList.add('is-cited'); }, 520); }
        });
      } else {
        root.classList.add('is-cited');
      }
    }, 260);
  }, { threshold: 0.2 });

  /* ---------- the timed cycle and its Pause control ---------- */
  var setPaused = null;
  if (!api || !slot) return;

  var cycle = BDH.loop(root, 4200, function () { api.show(api.index() + 1, false); });

  var btn = document.createElement('button');
  btn.type = 'button';
  btn.className = 'tsv-ans__pausebtn';
  btn.setAttribute('aria-pressed', 'false');
  var label = document.createElement('span');
  label.className = 'tsv-ans__pausel';
  var icon = document.createElement('span');
  icon.className = 'tsv-ans__pausei';
  icon.setAttribute('aria-hidden', 'true');
  btn.appendChild(icon);
  btn.appendChild(label);
  slot.appendChild(btn);

  var paused = false;
  setPaused = function (on) {
    paused = !!on;
    if (paused) { cycle.pause(); } else { cycle.resume(); }
    btn.setAttribute('aria-pressed', paused ? 'true' : 'false');
    label.textContent = paused ? 'Play' : 'Pause';
    btn.setAttribute('aria-label', paused ? 'Play the engine cycle' : 'Pause the engine cycle');
  };
  setPaused(false);

  btn.addEventListener('click', function () { setPaused(!paused); });
})();
