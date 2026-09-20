/* Tech Workforce · composer — the Squad Composer.
   Mission presets, role steppers and a time-zone picker drive the composition bar, the sprint
   figures, the skill-coverage checklist and the indicative rate-card model.

   The server-rendered HTML is the finished state for mission 01 and lists all five time zones, with
   every control shipped disabled — so with JS off the section reads correctly and offers nothing it
   cannot do. This script is what makes the controls real: it enables them, collapses the zone list
   to the selected one, and takes over the readouts.

   The two pickers are radio groups, not piles of toggles: arrow keys, Home and End move between the
   options with a roving tabindex, and Enter or Space picks one. A stepper that disables itself hands
   its focus to its sibling first, so keyboard focus is never dropped into the document.
   One unprompted demonstration runs on entry; it is silent to assistive technology, because nobody
   asked for it, and it stops the moment the visitor touches anything. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-ttw-cmp]');
  var host = document.querySelector('.ttw-cmp');
  if (!root || !host) return;

  var raw = host.querySelector('[data-ttw-cmp-data]');
  var D;
  try { D = JSON.parse(raw ? raw.textContent : '{}'); } catch (e) { return; }
  if (!D || !D.roles || !D.missions) return;

  var MAX = 8;
  var state = { mission: 'mvp', counts: {}, zone: 'uk' };
  var quiet = false;                     // true while the demonstration drives the panel

  var els = {
    roles:  BDH.$$('[data-ttw-role]', root),
    bar:    BDH.$('[data-ttw-bar]', root),
    key:    BDH.$('[data-ttw-key]', root),
    head:   BDH.$('[data-ttw-headline]', root),
    pts:    BDH.$('[data-ttw-pts]', root),
    hours:  BDH.$('[data-ttw-hours]', root),
    units:  BDH.$('[data-ttw-units]', root),
    cover:  BDH.$('[data-ttw-cover]', root),
    covN:   BDH.$('[data-ttw-cov]', root),
    mnote:  BDH.$('[data-ttw-mnote]', root),
    ovh:    BDH.$('[data-ttw-ovh]', root),
    live:   host.querySelector('[data-ttw-live]'),
    zones:  BDH.$$('[data-ttw-zone]', root),
    mbtns:  BDH.$$('[data-ttw-mission]', root),
    zbtns:  BDH.$$('[data-ttw-zbtn]', root),
    steps:  BDH.$$('[data-ttw-step]', root)
  };

  function el(tag, cls) { var n = document.createElement(tag); if (cls) n.className = cls; return n; }

  function loadMission(key) {
    var m = D.missions[key];
    if (!m) return;
    state.mission = key;
    state.counts = {};
    D.roles.forEach(function (r) { state.counts[r.k] = m.squad[r.k] || 0; });
  }

  /* ---------- outputs ---------- */
  function render() {
    var m = D.missions[state.mission] || { cover: [], name: '' };
    var head = 0, pts = 0, units = 0;

    els.roles.forEach(function (li) {
      var k = li.getAttribute('data-ttw-role');
      var n = state.counts[k] || 0;
      var v = li.querySelector('[data-ttw-val]');
      if (v) v.textContent = String(n);
      li.classList.toggle('is-on', n > 0);
      var dec = li.querySelector('[data-ttw-step="-1"]');
      var inc = li.querySelector('[data-ttw-step="1"]');
      /* Hand focus to the sibling before a focused button disables itself. */
      if (dec && n <= 0 && document.activeElement === dec && inc) inc.focus();
      if (inc && n >= MAX && document.activeElement === inc && dec) dec.focus();
      if (dec) dec.disabled = n <= 0;
      if (inc) inc.disabled = n >= MAX;
    });

    D.roles.forEach(function (r) {
      var n = state.counts[r.k] || 0;
      head += n; pts += n * r.pts; units += n * r.u;
    });

    if (els.bar) {
      els.bar.textContent = '';
      D.roles.forEach(function (r) {
        var n = state.counts[r.k] || 0;
        if (!n) return;
        var seg = el('i');
        seg.setAttribute('data-r', r.k);
        seg.style.setProperty('--n', String(n));
        var b = el('b'); b.textContent = String(n);
        seg.appendChild(b);
        els.bar.appendChild(seg);
      });
    }

    if (els.key) {
      els.key.textContent = '';
      D.roles.forEach(function (r) {
        var n = state.counts[r.k] || 0;
        if (!n) return;
        var li = el('li');
        var chip = el('span', 'ttw-chip');
        chip.appendChild(el('span', 'ttw-chip__d'));
        chip.appendChild(document.createTextNode(r.n));
        var s = el('span', 'ttw-chip__s'); s.textContent = '× ' + n;
        chip.appendChild(s);
        li.appendChild(chip);
        els.key.appendChild(li);
      });
    }

    if (els.head)  els.head.textContent = head + (head === 1 ? ' person' : ' people');
    if (els.pts)   els.pts.textContent = String(pts);
    if (els.hours) els.hours.textContent = String(head * 65);
    if (els.units) els.units.textContent = units.toFixed(2);

    var met = 0;
    if (els.cover) {
      els.cover.textContent = '';
      (m.cover || []).forEach(function (c) {
        var have = state.counts[c[1]] || 0;
        var ok = have >= c[2];
        if (ok) met++;
        var li = el('li', ok ? 'is-met' : 'is-gap');
        var tick = el('span', 'ttw-tick' + (ok ? '' : ' ttw-tick--gap'));
        tick.setAttribute('aria-hidden', 'true');
        tick.innerHTML = ok
          ? '<svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 6.4 4.6 9 10 3"/></svg>'
          : '<svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2.5v4.2M6 9.4v.1"/></svg>';
        var t = el('span', 'ttw-cmp__ct');
        t.appendChild(document.createTextNode(c[0]));
        var q = el('span', 'ttw-cmp__cq');
        q.textContent = ok ? 'Covered' : (have ? 'Short by ' + (c[2] - have) : 'Gap');
        t.appendChild(q);
        li.appendChild(tick); li.appendChild(t);
        els.cover.appendChild(li);
      });
      if (els.covN) els.covN.textContent = met + ' of ' + (m.cover || []).length + ' met';
    }

    if (els.live && !quiet) {
      els.live.textContent = m.name + ': ' + head + ' people, ' + pts + ' story points a sprint, '
        + met + ' of ' + (m.cover || []).length + ' skill areas covered.';
    }
  }

  function setZone(key) {
    state.zone = key;
    els.zones.forEach(function (z) {
      var on = z.getAttribute('data-ttw-zone') === key;
      z.hidden = !on;
      if (on && els.ovh) els.ovh.textContent = (z.getAttribute('data-ttw-ov') || '') + ' shared';
    });
  }

  function setMission(key) {
    loadMission(key);
    if (els.mnote && D.missions[key] && D.missions[key].note) els.mnote.textContent = D.missions[key].note;
    render();
  }

  /* ---------- radio groups: roving tabindex, arrow keys, Home and End ---------- */
  function radiogroup(group, attr, pick) {
    if (!group) return { select: function () {} };
    var btns = BDH.$$('[role="radio"]', group);
    if (!btns.length) return { select: function () {} };

    function paint(key) {
      btns.forEach(function (b) {
        var on = b.getAttribute(attr) === key;
        b.setAttribute('aria-checked', on ? 'true' : 'false');
        b.tabIndex = on ? 0 : -1;
      });
    }
    function select(key, byUser) {
      paint(key);
      pick(key, byUser);
    }
    btns.forEach(function (b) {
      b.disabled = false;
      b.addEventListener('click', function () { select(b.getAttribute(attr), true); });
    });
    group.addEventListener('keydown', function (ev) {
      var i = btns.indexOf(document.activeElement);
      if (i < 0) return;
      var j = -1;
      if (ev.key === 'ArrowRight' || ev.key === 'ArrowDown') j = (i + 1) % btns.length;
      else if (ev.key === 'ArrowLeft' || ev.key === 'ArrowUp') j = (i - 1 + btns.length) % btns.length;
      else if (ev.key === 'Home') j = 0;
      else if (ev.key === 'End') j = btns.length - 1;
      if (j < 0) return;
      ev.preventDefault();
      btns[j].focus();
      select(btns[j].getAttribute(attr), true);
    });
    return { select: select };
  }

  var missions = radiogroup(root.querySelector('.ttw-cmp__miss'), 'data-ttw-mission', setMission);
  var zonesRg  = radiogroup(root.querySelector('.ttw-cmp__zb'), 'data-ttw-zbtn', setZone);

  /* ---------- steppers ---------- */
  els.steps.forEach(function (b) { b.disabled = false; });
  root.addEventListener('click', function (ev) {
    var btn = ev.target.closest ? ev.target.closest('[data-ttw-step]') : null;
    if (!btn || !root.contains(btn)) return;
    var li = btn.closest('[data-ttw-role]');
    if (!li) return;
    var k = li.getAttribute('data-ttw-role');
    var d = parseInt(btn.getAttribute('data-ttw-step'), 10) || 0;
    var n = (state.counts[k] || 0) + d;
    state.counts[k] = Math.max(0, Math.min(MAX, n));
    render();
  });

  /* ---------- first paint ---------- */
  root.classList.add('is-js');
  loadMission('mvp');
  render();
  zonesRg.select('uk');

  /* One unprompted demonstration: the AI mission and the US East window, then it stops. It is
     silent — the live region is only for changes the visitor made. */
  if (!BDH.reduced) {
    BDH.seq(root, [
      [3200, function () { quiet = true; missions.select('aiteam'); quiet = false; }],
      [1400, function () { zonesRg.select('us'); }]
    ], { stopOnInteract: true, interactRoot: root });
  }
})();
