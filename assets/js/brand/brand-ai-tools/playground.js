/* 04 SIGNATURE — Generation playground. brief → generate → brand check → review → publish.
   Autoplays full runs until the first interaction inside the demo, then the visitor drives. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var ui = document.querySelector('.cat-pg__ui'); if (!ui) return;
  var R = BDH.reduced;
  var $ = function (s) { return ui.querySelector(s); }, $$ = function (s) { return BDH.$$(s, ui); };
  var STAGES = ['brief', 'gen', 'check', 'review', 'publish', 'done'];
  var LINES = { Calm: 'Quietly made.', Warm: 'Made to be kept.', Bold: 'Made to last.' }; // DRAFT COPY
  var vars = $$('.cat-pg__var'), cells = $$('.cat-pg__matrix i'), okBtns = $$('[data-pg-approve]');
  var genBtn = $('[data-pg-gen]'), status = $('[data-pg-status]'), count = $('[data-pg-count]'), trace = $('[data-pg-trace]');
  var timers = [], busy = false;

  function later(ms, fn) { timers.push(setTimeout(fn, R ? 0 : ms)); }
  function clearTimers() { timers.forEach(clearTimeout); timers = []; }
  function val(name) { var r = ui.querySelector('input[name="pg-' + name + '"]:checked'); return r ? r.value : ''; }
  function say(t) { status.textContent = t; }
  function log(tag, text) {
    if (!trace) return;
    var li = document.createElement('li');
    li.innerHTML = '<b></b><span></span>';
    li.children[0].textContent = tag; li.children[1].textContent = text;
    if (!R) li.className = 'is-new';
    trace.appendChild(li);
    while (trace.children.length > 7) trace.removeChild(trace.firstElementChild);
  }

  function setStage(s) {
    ui.setAttribute('data-pg-stage', s);
    var n = STAGES.indexOf(s);
    $$('.cat-pg__rail li').forEach(function (li, i) {
      li.classList.toggle('is-on', i === n);
      li.classList.toggle('is-done', i < n || s === 'done');
    });
    okBtns.forEach(function (b) { b.disabled = s !== 'review'; });
  }

  function compose() {
    var p = val('product'), m = val('market'), f = val('format'), mood = val('mood');
    var wh = f.split(':');
    $('[data-pg-prompt]').textContent = p + ' · still life · ' + m + ' · ' + f + ' · ' + mood.toLowerCase() + ' — locked: palette v7, lockup, clear space, type, voice';
    var box = $('.cat-pg__vars');
    box.style.setProperty('--ar', wh[0] + '/' + wh[1]);
    box.style.setProperty('--arn', (parseFloat(wh[0]) / parseFloat(wh[1])).toFixed(4));
    $$('[data-pg-line]').forEach(function (el) { el.textContent = LINES[mood] || ''; });
  }

  function clearResults() {
    vars.forEach(function (v) { v.classList.remove('is-scored', 'is-picked'); });
    $$('.cat-pg__checks li').forEach(function (li) { li.classList.remove('is-scored'); });
    okBtns.forEach(function (b) { b.setAttribute('aria-pressed', 'false'); b.textContent = 'Approve'; });
    cells.forEach(function (c) { c.classList.remove('is-on', 'is-pop'); });
    count.textContent = '0 of ' + cells.length + ' live';
  }

  function run() {
    if (busy) return;
    busy = true; clearTimers(); clearResults(); compose();
    genBtn.disabled = true;
    setStage('gen');
    say('Generating 4 variants · ' + val('product') + ' · ' + val('market') + ' · ' + val('format'));
    log('brief', val('product') + ' · ' + val('market') + ' · ' + val('format') + ' · ' + val('mood').toLowerCase() + ' · identity locked');
    log('gen', '4 variants · tuned model v4.2 · seed locked');
    later(1700, function () {
      setStage('check'); say('Brand check · colour, clear space, tone, rights');
      var t = 0;
      vars.forEach(function (v) {
        BDH.$$('.cat-pg__checks li', v).forEach(function (li) { t += 170; later(t, function () { li.classList.add('is-scored'); }); });
        later(t + 60, function () {
          v.classList.add('is-scored');
          var id = v.getAttribute('data-var'), note = v.querySelector('.cat-pg__verdict').textContent;
          log('check', id + ' · ' + note + (v.classList.contains('is-fail') ? ' · returned' : ''));
        });
      });
      later(t + 500, function () {
        setStage('review'); busy = false; genBtn.disabled = false;
        say('2 passed · C failed clear space · D blocked on rights · waiting for Brand lead');
        log('queue', 'A, B → review · owner: Brand lead');
      });
    });
  }

  function approve(id) {
    if (ui.getAttribute('data-pg-stage') !== 'review') return;
    busy = true; genBtn.disabled = true;
    okBtns.forEach(function (b) {
      var on = b.getAttribute('data-pg-approve') === id;
      b.setAttribute('aria-pressed', on ? 'true' : 'false'); b.textContent = on ? 'Approved' : 'Approve';
    });
    vars.forEach(function (v) { v.classList.toggle('is-picked', v.getAttribute('data-var') === id); });
    setStage('publish'); say('Variant ' + id + ' approved by Brand lead · publishing');
    log('review', id + ' approved by Brand lead');
    okBtns.forEach(function (b) { b.disabled = true; });
    var order = cells.map(function (c, i) { return [parseInt(c.style.getPropertyValue('--d'), 10) || 0, i]; }).sort(function (a, b) { return a[0] - b[0] || a[1] - b[1]; });
    order.forEach(function (o, n) {
      later(n * 24, function () {
        var c = cells[o[1]]; c.classList.add('is-on');
        if (!R) c.classList.add('is-pop');
        count.textContent = (n + 1) + ' of ' + cells.length + ' live';
      });
    });
    later(order.length * 24 + 300, function () {
      setStage('done'); busy = false; genBtn.disabled = false;
      say('Variant ' + id + ' approved by Brand lead · published to 6 formats × 9 markets · credentials signed');
      log('pub', cells.length + ' assets · 6 formats × 9 markets · credentials signed');
    });
  }

  genBtn.addEventListener('click', run);
  okBtns.forEach(function (b) { b.addEventListener('click', function () { approve(b.getAttribute('data-pg-approve')); }); });
  $('[data-pg-reset]').addEventListener('click', function () {
    clearTimers(); busy = false; genBtn.disabled = false; clearResults(); setStage('brief'); say('Brief ready · press Generate');
  });
  $$('.cat-pg__brief input').forEach(function (inp) {
    inp.addEventListener('change', function () {
      compose();
      if (!busy) { clearResults(); setStage('brief'); say('Brief updated · press Generate'); }
    });
  });

  /* initial frame: the finished run in the HTML */
  compose();
  okBtns.forEach(function (b) { if (b.getAttribute('aria-pressed') === 'true') b.textContent = 'Approved'; });
  setStage('done');
  if (R) return;

  function pick(name, i) {
    var rs = $$('input[name="pg-' + name + '"]'); if (!rs.length) return;
    rs[i % rs.length].checked = true; compose();
  }
  var steps = [
    [1400, function () { clearTimers(); busy = false; clearResults(); setStage('brief'); say('Brief ready · press Generate'); }],
    [650, function (c) { pick('product', c.cycle + 1); }],
    [550, function (c) { pick('market', c.cycle + 1); }],
    [550, function (c) { if (window.matchMedia('(min-width: 1101px)').matches) pick('format', c.cycle); }],   // stacked layouts: keep tile heights stable
    [550, function (c) { pick('mood', c.cycle); }],
    [800, run],
    [5200, function (c) { approve(c.cycle % 2 ? 'A' : 'B'); }],
    [4200, function () {}]
  ];
  BDH.inView(ui, function () {
    BDH.seq(ui, steps, { loop: true, stopOnInteract: true, interactRoot: ui });
  }, { threshold: 0.25 });
})();
