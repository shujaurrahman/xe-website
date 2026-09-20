/* AI Strategy & Agents · hero — the mission board at work. While the board is on screen, working
   cards tick through their steps and spend; finished cards move to Needs approval (L3) or Done
   (L1, L2, L4); an approval clears after a few beats; Done recycles into Queued with the next
   mission. Moves use FLIP transforms. The board keeps a fixed size: every list has
   two slots; on wide screens Queued holds one card (its second slot sits under the headline card),
   and a recycled card leaves the flow before it fades.
   Reduced motion: the finished board, untouched. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var board = document.querySelector('[data-tas-board]'); if (!board) return;
  if (BDH.reduced) return;

  var lists = {}, heads = {};
  BDH.$$('.tas-board__col', board).forEach(function (col) {
    var k = col.getAttribute('data-col');
    lists[k] = col.querySelector('.tas-board__list');
    heads[k] = col.querySelector('[data-count]');
  });
  var tickEl = board.querySelector('[data-board-tick]'), tickBox = board.querySelector('.tas-board__tick'), timeEl = board.querySelector('.tas-board__time');
  var runEl = board.querySelector('[data-board-run]'), runL = board.querySelector('[data-board-runl]');
  var wide = window.matchMedia ? window.matchMedia('(min-width: 1024px)') : { matches: true };
  var small = window.matchMedia ? window.matchMedia('(max-width: 760px)') : { matches: false };
  /* two slots per list (one queued card on wide screens, under the headline card's edge); phones one */
  function limit(col) { return small.matches ? 1 : { queued: wide.matches ? 1 : 2, working: 2, approval: 2, done: 2 }[col]; }
  var STEPS = ['plan', 'retrieve', 'read', 'calculate', 'draft', 'check', 'write'];
  var STATE = { queued: 'Next in line', working: 'Running', approval: 'Needs approval', done: 'Closed' };

  /* DRAFT COPY: the mission pool — [mission, owner role, agent, level, cap, steps] */
  var POOL = [
    ['Chase overdue invoices',     'Credit control', 'credit-agent',      3, 0.20, 6],
    ['Answer HR policy questions', 'People team',    'hr-copilot',        1, 0.05, 4],
    ['Update supplier risk file',  'Procurement',    'supplier-agent',    2, 0.30, 6],
    ['Draft renewal quotes',       'Sales ops',      'renewals-agent',    3, 0.40, 7],
    ['Reconcile vendor invoices',  'Finance lead',   'ap-reconciler',     4, 0.30, 7],
    ['Triage inbound RFPs',        'Bid manager',    'rfp-triage',        2, 0.25, 6],
    ['Resolve billing dispute',    'Service lead',   'billing-agent',     3, 0.10, 7]
  ];
  var poolAt = 0, nextId = 215, clock = 10 * 3600 + 42 * 60 + 7, waitBeats = 0;

  function read(li) {
    var ro = li.querySelector('.tas-mc__ro').textContent;
    return {
      li: li, sp: li.querySelector('[data-spend]'), st: li.querySelector('[data-step]'),
      cap: parseFloat((ro.match(/\/\s*\$([\d.]+)/) || [0, '0'])[1]),
      steps: parseInt((li.querySelector('.tas-mc__step').textContent.match(/\/(\d+)/) || [0, '6'])[1], 10),
      level: parseInt(li.querySelector('.tas-lvl').getAttribute('data-l'), 10),
      id: li.getAttribute('data-id'), role: li.querySelector('.tas-mc__role').textContent
    };
  }
  function cardsIn(col) { return BDH.$$('.tas-mc', lists[col]).filter(function (li) { return !li.classList.contains('is-out'); }); }
  function room(col) { return cardsIn(col).length < limit(col); }
  function counts() {
    Object.keys(lists).forEach(function (k) { if (heads[k]) heads[k].textContent = String(cardsIn(k).length); });
    var n = cardsIn('working').length;
    if (runEl) runEl.textContent = String(n);
    if (runL) runL.textContent = n === 1 ? 'agent' : 'agents';
  }
  function stamp() {
    clock += 7 + Math.floor(Math.random() * 30);
    var h = Math.floor(clock / 3600) % 24, m = Math.floor(clock / 60) % 60, s = clock % 60;
    return (h < 10 ? '0' : '') + h + ':' + (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
  }
  function say(t) {
    if (!tickEl) return;
    if (timeEl) timeEl.textContent = stamp();
    tickEl.textContent = t;
    if (tickBox) { tickBox.classList.remove('is-new'); void tickBox.offsetWidth; tickBox.classList.add('is-new'); }
  }
  function bump(b, v) { b.textContent = v; b.classList.remove('is-tick'); void b.offsetWidth; b.classList.add('is-tick'); }
  function state(li, st, step) {
    li.setAttribute('data-st', st);
    var sl = li.querySelector('.tas-mc__sl'), ss = li.querySelector('.tas-mc__ss');
    if (sl) sl.textContent = STATE[st];
    if (ss) ss.textContent = st === 'working' ? ' · ' + STEPS[Math.min(step || 0, STEPS.length - 1)] : st === 'done' ? ' · logged' : '';
  }

  /* FLIP: measure every card, run the DOM change, animate each from where it was */
  function flip(change) {
    var all = BDH.$$('.tas-mc', board), first = new Map();
    all.forEach(function (li) { first.set(li, li.getBoundingClientRect()); });
    change();
    BDH.$$('.tas-mc', board).forEach(function (li) {
      var a = first.get(li); if (!a) return;
      var b = li.getBoundingClientRect(), dx = a.left - b.left, dy = a.top - b.top;
      if (Math.abs(dx) < 1 && Math.abs(dy) < 1) return;
      li.style.transition = 'none';
      li.style.transform = 'translate(' + dx + 'px,' + dy + 'px)';
      if (Math.abs(dx) > 20) li.classList.add('is-moving');
      void li.offsetWidth;
      li.style.transition = 'transform .85s cubic-bezier(.22,1,.36,1)';
      li.style.transform = '';
      setTimeout(function () { li.classList.remove('is-moving'); li.style.transition = ''; }, 900);
    });
    counts();
  }
  function moveTo(li, col) { flip(function () { lists[col].appendChild(li); }); }

  function card(m, id) {
    var li = document.createElement('li');
    li.className = 'tas-mc is-in-new';
    li.setAttribute('data-id', id);
    li.innerHTML = '<span class="tas-mc__top"><span class="tas-mc__agent"></span><span class="tas-mc__id"></span><span class="tas-lvl" data-l="' + m[3] + '"><span class="tas-lvl__p" aria-hidden="true"><i></i><i></i><i></i><i></i></span><span class="tas-lvl__n">L' + m[3] + '</span></span></span>' +
      '<span class="tas-mc__t"></span><span class="tas-mc__who"><span class="tas-mc__idw"></span><span class="tas-mc__role"></span></span>' +
      '<span class="tas-mc__ro"><span>$<b data-spend>0.00</b> / $' + m[4].toFixed(2) + '</span><span class="tas-mc__step">step <b data-step>0</b>/' + m[5] + '</span></span>' +
      '<span class="tas-mc__bar"><i style="--p:0"></i></span>' +
      '<span class="tas-mc__st"><i class="tas-mc__sd" aria-hidden="true"></i><span class="tas-mc__sl"></span><span class="tas-mc__ss"></span></span>';
    li.querySelector('.tas-mc__id').textContent = id;
    li.querySelector('.tas-mc__idw').textContent = id;
    li.querySelector('.tas-mc__t').textContent = m[0];
    li.querySelector('.tas-mc__agent').textContent = m[2];
    li.querySelector('.tas-mc__role').textContent = m[1];
    state(li, 'queued');
    return li;
  }

  /* the oldest Done card fades out of the flow only when a finished card needs its slot (it never
     waits for room elsewhere, so the board cannot jam); a new mission joins the queue whenever the
     queue has room, so the board stays full */
  var busy = false;
  function retire() {
    var done = cardsIn('done'); if (!done.length) return false;
    var old = done[0];
    flip(function () { old.style.top = old.offsetTop + 'px'; old.classList.add('is-out'); });
    setTimeout(function () { old.remove(); }, 460);
    return true;
  }
  function enqueue() {
    if (busy || !room('queued')) return false;
    busy = true;
    /* the next mission from the pool that is not already on the board */
    var onBoard = BDH.$$('.tas-mc:not(.is-out) .tas-mc__t', board).map(function (t) { return t.textContent; });
    var m = POOL[poolAt++ % POOL.length];
    for (var k = 0; k < POOL.length && onBoard.some(function (t) { return t.indexOf(m[0]) === 0; }); k++) m = POOL[poolAt++ % POOL.length];
    var id = 'M-' + (nextId++);
    setTimeout(function () {
      busy = false;
      var li = card(m, id);
      flip(function () { lists.queued.appendChild(li); });
      setTimeout(function () { li.classList.remove('is-in-new'); }, 700);
      say(id + ' · queued · ' + m[0] + ' · owner ' + m[1]);
    }, 460);
    return true;
  }

  function tick() {
    /* 1. every working card advances one step */
    cardsIn('working').forEach(function (li) {
      var c = read(li), s = parseInt(c.st.textContent, 10);
      if (s < c.steps) {
        s++; bump(c.st, s);
        var spend = Math.min(c.cap * 0.92, parseFloat(c.sp.textContent) + c.cap * (0.06 + Math.random() * 0.08));
        bump(c.sp, spend.toFixed(2));
        li.querySelector('.tas-mc__bar i').style.setProperty('--p', (spend / c.cap).toFixed(3));
        state(li, 'working', s);
      }
    });

    /* 2. at most one card leaves Working or Needs approval per beat (approval first) */
    var appr = cardsIn('approval'), moved = false;
    if (appr.length && ++waitBeats >= 4) {
      if (!room('done')) retire();   /* the oldest Done card leaves the flow at once, freeing its slot */
      var a = read(appr[0]); waitBeats = 0;
      state(appr[0], 'done');
      say(a.id + ' · approved by ' + a.role + ' · write executed · audit row added');
      moveTo(appr[0], 'done');
      moved = true;
    }
    var finished = moved ? [] : cardsIn('working').filter(function (li) { var c = read(li); return parseInt(c.st.textContent, 10) >= c.steps; });
    if (finished.length) {
      var f = read(finished[0]);
      if (f.level === 3) {
        /* L3 never closes without a person: wait for a free approval slot */
        if (room('approval')) {
          state(finished[0], 'approval');
          say(f.id + ' · write step needs approval · sent to ' + f.role);
          moveTo(finished[0], 'approval');
        }
      } else {
        if (!room('done')) retire();
        state(finished[0], 'done');
        say(f.id + (f.level === 4 ? ' · executed within limits · ' : f.level === 1 ? ' · suggestion delivered · ' : ' · draft ready for ' + f.role + ' · ') + 'logged');
        moveTo(finished[0], 'done');
      }
    }
    /* 3. one queued card starts per beat, and the queue refills behind it */
    if (room('working') && cardsIn('queued').length) {
      var q = cardsIn('queued')[0], qc = read(q);
      state(q, 'working', 0);
      if (!moved && !finished.length) say(qc.id + ' · agent started · plan → retrieve → act');
      moveTo(q, 'working');
    }
    if (room('queued')) enqueue();
  }

  /* send extra cards out when the viewport changes band (wide: one queued; phones: one per column) */
  function fit() {
    ['queued', 'working', 'approval', 'done'].forEach(function (col) {
      var c = cardsIn(col);
      while (c.length > limit(col)) { var x = c.pop(); flip(function () { x.remove(); }); }
    });
  }
  if (wide.addEventListener) wide.addEventListener('change', fit);
  if (small.addEventListener) small.addEventListener('change', fit);
  fit();

  BDH.live(board, 0.2);
  BDH.loop(board, 1500, tick);
})();
