/* Custom Software & Data Platforms · stitcher — the Profile Stitcher engine.
   State = { n: events applied (0–8), prob: probabilistic matching on, withdrawn: marketing consent withdrawn,
   wN: the event after which the withdrawal happened (stamped two minutes after that event, so the timeline and
   the log always run forwards), decision: the data steward's call on the low-confidence match (null | 'merge' | 'keep') }.
   compute(state) derives everything shown: graph clusters and positions, profile traits, segments,
   destinations, the steward queue and the resolution log; render() paints it (nodes glide with a rAF tween).
   Autoplays a full day (then a consent withdrawal) while on screen until the first interaction inside the
   demo; after that the visitor drives. Reduced motion: no autoplay and no tweening; controls work at once. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tcs-sx'); if (!root) return;
  var R = BDH.reduced;
  var D; try { D = JSON.parse(root.getAttribute('data-sx')); } catch (e) { return; }
  var $ = function (s) { return root.querySelector(s); }, $$ = function (s) { return BDH.$$(s, root); };
  var svg = $('.tcs-sg');
  var HUB_A = [262, 222], HUB_B = [470, 330];
  var POS_B = { ph: [512, 262], ly: [500, 398] };        // cluster P-0002 before the merge
  var POS_ORPHAN = { ck2: [64, 330], ck3: [176, 396] };
  var LAST_KEY = { 1: 'ck1', 2: 'ck1', 3: 'dv', 4: 'ly', 5: 'em', 6: 'ck2', 7: 'em', 8: 'ck3' };
  var CH_OF = { 1: 'Web', 2: 'Web', 3: 'App', 4: 'Store', 5: 'Support', 6: 'Web', 7: 'Email', 8: 'Web' };

  var st = { n: 8, prob: true, withdrawn: false, wN: 8, decision: null };
  function addMin(t, m) { var p = t.split(':'), v = (+p[0]) * 60 + (+p[1]) + m; return ('0' + Math.floor(v / 60) % 24).slice(-2) + ':' + ('0' + v % 60).slice(-2); }

  /* ---------------------------------------------------------------- compute */
  function compute(s) {
    var n = s.n, A = [], B = [], orphans = [], probLinks = {}, queue = null;
    if (n >= 1) A.push('ck1');
    if (n >= 2) A.push('em');
    if (n >= 3) A.push('dv');
    if (n === 4) B.push('ph', 'ly');
    if (n >= 5) A.push('ph', 'ly');
    if (n >= 6) { if (s.prob) { A.push('ck2'); probLinks.ck2 = '0.91'; } else orphans.push('ck2'); }
    if (n >= 8) {
      if (s.prob && s.decision === 'merge') { A.push('ck3'); probLinks.ck3 = '0.72 · steward'; }
      else { orphans.push('ck3'); if (s.prob && !s.decision) queue = 'ck3'; }
    }
    var inA = function (k) { return A.indexOf(k) > -1; };
    var seen = '—';
    for (var i = n; i >= 1; i--) { if (inA(LAST_KEY[i])) { seen = D.events[i - 1].t + ' · ' + CH_OF[i]; break; } }

    var seg = { known: n >= 3, store: n >= 5, 'case': n >= 5, intent: n >= 6 && s.prob, engaged: n >= 7 };
    var W = s.withdrawn && n >= 2;
    var wAt = addMin(D.events[Math.max(2, Math.min(n, s.wN)) - 1].t, 2);   // withdrawal time, after the event it followed
    /* the purpose check each destination runs before a sync: service syncs rest on the contract, marketing on consent */
    var mGate = W ? ['block', 'Consent withdrawn · ' + wAt] : (n >= 2 ? ['ok', 'Consent granted · 09:14'] : ['idle', 'No consent captured yet']);
    var gate = { sf: n >= 3 ? ['ok', 'Lawful basis: contract'] : ['idle', 'Lawful basis: contract'], hs: mGate, ga: mGate, mt: mGate };
    var dest = {
      sf: n >= 3 ? ['ok', (n >= 5 ? 'Contact + open case · ' + (n >= 5 ? '16:22' : '') : 'Contact · 11:40') + (W ? ' · marketing flag off' : '')] : ['idle', 'Waiting for a known contact'],
      hs: W ? ['block', 'Blocked · marketing consent withdrawn ' + wAt + ' · logged'] : (n >= 3 ? ['ok', n >= 7 ? 'List: Email engaged · 21:03' : 'List: Known contacts · 11:40'] : ['idle', 'Waiting for a known contact']),
      ga: W ? ['block', 'Blocked · marketing consent withdrawn ' + wAt + ' · logged'] : (seg.intent ? ['ok', 'Audience: High intent · 19:48'] : ['idle', 'Not in any audience']),
      mt: W ? ['block', 'Blocked · marketing consent withdrawn ' + wAt + ' · logged'] : (seg.store ? ['ok', 'Exclude: recent store buyers'] : ['idle', 'Not in any audience'])
    };

    var log = [];
    function L(t, txt) { log.push([t, txt]); }
    if (n >= 1) L('09:12:04', 'profile.created P-0001 · anonymous · ck_7f3a');
    if (n >= 2) L('09:14:37', 'identity.linked email → P-0001 · same cookie');
    if (n >= 3) L('11:40:12', 'identity.linked dv_19c2 → P-0001 · verified login');
    if (n >= 4) L('13:05:51', 'profile.created P-0002 · loyalty + phone');
    if (n >= 5) L('16:22:09', 'profile.merged P-0002 → P-0001 · email + phone');
    if (n >= 6) L('19:48:26', s.prob ? 'identity.linked ck_d201 → P-0001 · 0.91 · probabilistic' : 'event.unresolved ck_d201 · no deterministic key');
    if (n >= 7) L('21:03:40', 'event.attached campaign_click → P-0001');
    if (W) {
      L(wAt + ':02', 'consent.withdrawn purpose=marketing · P-0001');
      L(wAt + ':03', 'activation.blocked hubspot, google_ads, meta · GDPR Art. 7(3) · DPDP s.6(4)');
    }
    if (n >= 8) L('22:17:03', s.prob ? 'merge.queued ck_e913 → P-0001 · 0.72 < 0.85' : 'event.unresolved ck_e913 · no deterministic key');
    if (n >= 8 && s.prob && s.decision) L('22:31:10', s.decision === 'merge' ? 'steward.approved ck_e913 → P-0001 · data_steward' : 'steward.rejected ck_e913 · kept separate · data_steward');
    log.sort(function (a, b) { return a[0] < b[0] ? 1 : -1; });

    var status;
    if (n === 0) status = 'Ready · 8 events queued · press Next event';
    else {
      var ev = D.events[n - 1], what = {
        1: 'new anonymous profile P-0001 on cookie ck_7f3a',
        2: 'hashed email linked to P-0001 through the same cookie (deterministic)',
        3: 'device dv_19c2 linked on a verified login (deterministic)',
        4: 'no shared key with P-0001 · new profile P-0002 from loyalty ID and phone',
        5: 'P-0002 merged into P-0001 on hashed email + phone (deterministic)',
        6: s.prob ? 'ck_d201 scored 0.91 on device and network signals · linked (probabilistic)' : 'ck_d201 has no deterministic key · left unresolved',
        7: 'click attached to P-0001 by hashed email',
        8: s.prob ? (s.decision === 'merge' ? 'ck_e913 merged by the data steward' : s.decision === 'keep' ? 'ck_e913 kept separate by the data steward' : 'ck_e913 scored 0.72, below 0.85 · queued for data steward review') : 'ck_e913 has no deterministic key · left unresolved'
      }[n];
      status = 'Event ' + n + ' of 8 · ' + ev.ch + ' ' + ev.ev + ' · ' + what;
    }
    if (W) status += ' · marketing consent withdrawn at ' + wAt + ': 3 destinations blocked';

    return {
      A: A, B: B, orphans: orphans, probLinks: probLinks, queue: queue,
      profile: {
        state: n === 0 ? 'No profile yet' : (n === 1 ? 'Anonymous' : 'Known'),
        pid: n === 0 ? '—' : 'P-0001',
        ids: n === 0 ? 'waiting for the first event' : A.length + (A.length === 1 ? ' identifier linked' : ' identifiers linked'),
        email: n < 2 ? '—' : (n === 2 ? '9b2e…41 · from signup form' : '9b2e…41 · verified at login'),
        phone: n >= 5 ? '+91 ••••• 4471' : '—',
        loyalty: n >= 5 ? 'L-20931 · Silver' : '—',
        ltv: n >= 5 ? '4,850' : (n === 0 ? '—' : '0'),
        seen: seen,
        consent: n < 2 ? '—' : (W ? 'Withdrawn · ' + wAt + ' · preference centre' : 'Granted · 09:14 · signup form'),
        ch: { Web: n >= 1, App: n >= 3, Store: n >= 5, Support: n >= 5, Email: n >= 7 }
      },
      seg: seg, dest: dest, gate: gate, log: log.slice(0, 5), status: status,
      note: n === 0 ? 'No events yet' : (A.length + B.length + orphans.length) + ' identifiers · ' + (B.length ? '2 profiles' : '1 profile') + (queue ? ' · 1 in review' : (orphans.length ? ' · ' + orphans.length + ' unresolved' : ''))
    };
  }

  /* ---------------------------------------------------------------- graph tween */
  var nodes = {}, cur = {}, target = {}, tween = null;
  Object.keys(D.nodes).forEach(function (k) {
    nodes[k] = { g: svg.querySelector('[data-n="' + k + '"]'), e: svg.querySelector('[data-e="' + k + '"]'), l: svg.querySelector('[data-el="' + k + '"]') };
    cur[k] = [D.nodes[k].x, D.nodes[k].y, HUB_A[0], HUB_A[1]];
  });
  var hubB = svg.querySelector('[data-h="B"]'), hubA = svg.querySelector('[data-h="A"]');
  var hubBcur = HUB_B.slice();

  /* edge labels sit halfway along the link; on phones the graph text is larger, so they move closer to their node */
  var narrowMq = window.matchMedia ? window.matchMedia('(max-width:600px)') : null;
  function paintGraph() {
    var narrow = narrowMq && narrowMq.matches;
    Object.keys(nodes).forEach(function (k) {
      var c = cur[k], o = nodes[k];
      var t = narrow && k !== 'ck3' ? 0.3 : 0.5;   // the long review label stays mid-link, clear of the ly node
      o.g.setAttribute('transform', 'translate(' + c[0].toFixed(1) + ' ' + c[1].toFixed(1) + ')');
      o.e.setAttribute('x1', c[0].toFixed(1)); o.e.setAttribute('y1', c[1].toFixed(1));
      o.e.setAttribute('x2', c[2].toFixed(1)); o.e.setAttribute('y2', c[3].toFixed(1));
      if (o.l) { o.l.setAttribute('x', (c[0] + (c[2] - c[0]) * t).toFixed(1)); o.l.setAttribute('y', (c[1] + (c[3] - c[1]) * t + 4).toFixed(1)); }
    });
    hubB.setAttribute('transform', 'translate(' + hubBcur[0].toFixed(1) + ' ' + hubBcur[1].toFixed(1) + ')');
  }
  function graphTo(c, animate) {
    var hubBto = c.B.length ? HUB_B : (st.n >= 5 ? HUB_A : HUB_B);
    Object.keys(nodes).forEach(function (k) {
      var o = nodes[k], inA = c.A.indexOf(k) > -1, inB = c.B.indexOf(k) > -1, orph = c.orphans.indexOf(k) > -1;
      var p = inB ? POS_B[k] : (orph ? POS_ORPHAN[k] : [D.nodes[k].x, D.nodes[k].y]);
      var hub = inB ? HUB_B : HUB_A;
      var wasGone = o.g.classList.contains('is-gone');
      target[k] = [p[0], p[1], hub[0], hub[1]];
      var visible = inA || inB || orph;
      o.g.classList.toggle('is-gone', !visible);
      o.g.classList.toggle('is-orphan', orph);
      o.g.classList.toggle('is-review', c.queue === k);
      var showEdge = inA || inB || c.queue === k;
      o.e.classList.toggle('is-off', !showEdge);
      o.e.classList.toggle('is-prob', !!c.probLinks[k] || c.queue === k);
      o.e.classList.toggle('is-review', c.queue === k);
      if (o.l) {
        o.l.classList.toggle('is-off', !(c.probLinks[k] || c.queue === k));
        o.l.textContent = c.queue === k ? '0.72 · review' : (c.probLinks[k] || '');
        o.l.classList.toggle('is-review', c.queue === k);
      }
      if (visible && wasGone) {
        if (!animate) cur[k] = target[k].slice();
        else { cur[k] = [p[0], p[1], p[0], p[1]]; o.g.classList.remove('is-new'); o.g.getBoundingClientRect(); o.g.classList.add('is-new'); }
      }
    });
    hubB.classList.toggle('is-gone', !c.B.length);
    hubA.classList.toggle('is-gone', st.n === 0);
    svg.classList.toggle('is-empty', st.n === 0);

    if (!animate || R) {
      Object.keys(nodes).forEach(function (k) { cur[k] = target[k].slice(); });
      hubBcur = hubBto.slice(); paintGraph(); return;
    }
    var from = {}, hb0 = hubBcur.slice(), t0 = null, ms = 720;
    Object.keys(nodes).forEach(function (k) { from[k] = cur[k].slice(); });
    if (tween) cancelAnimationFrame(tween);
    function step(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / ms), e = 1 - Math.pow(1 - p, 3);
      Object.keys(nodes).forEach(function (k) { for (var j = 0; j < 4; j++) cur[k][j] = from[k][j] + (target[k][j] - from[k][j]) * e; });
      hubBcur = [hb0[0] + (hubBto[0] - hb0[0]) * e, hb0[1] + (hubBto[1] - hb0[1]) * e];
      paintGraph();
      if (p < 1) tween = requestAnimationFrame(step); else tween = null;
    }
    tween = requestAnimationFrame(step);
  }

  /* ---------------------------------------------------------------- render */
  var prevN = st.n;
  function text(sel, v, flash) {
    var el = $(sel); if (!el) return;
    if (el.textContent !== v) {
      el.textContent = v;
      if (flash && !R && v !== '—' && v !== '0') { el.classList.remove('is-new'); el.getBoundingClientRect(); el.classList.add('is-new'); setTimeout(function () { el.classList.remove('is-new'); }, 1200); }
    }
    el.classList.toggle('is-empty', v === '—' || v === '0');   // placeholders and a zero value stay muted, never blue
  }
  function render(animate) {
    var c = compute(st);
    root.setAttribute('data-step', String(st.n));
    $('[data-sx-n]').textContent = String(st.n);
    $$('.tcs-sx__ev').forEach(function (li, i) {
      var k = i + 1;
      li.classList.toggle('is-done', k <= st.n);
      li.classList.toggle('is-cur', k === st.n);
      var b = li.querySelector('button');
      if (k === st.n) b.setAttribute('aria-current', 'step'); else b.removeAttribute('aria-current');
    });
    graphTo(c, animate);
    if (animate && !R && st.n === 5 && prevN === 4) { hubA.classList.remove('is-merge'); hubA.getBoundingClientRect(); hubA.classList.add('is-merge'); }
    $('[data-sx-graphnote]').textContent = c.note;

    var P = c.profile;
    text('[data-sx-pstate]', P.state);
    text('[data-sx-pid]', P.pid);
    text('[data-sx-ids]', P.ids);
    var pc = $('.tcs-sx__pc'); if (pc) pc.classList.toggle('is-none', st.n === 0);   // no profile yet: the card goes quiet
    ['email', 'phone', 'loyalty', 'ltv', 'seen', 'consent'].forEach(function (k) { text('[data-sx-t="' + k + '"]', P[k], animate); });
    $$('[data-sx-ch]').forEach(function (li) { li.classList.toggle('is-on', !!P.ch[li.getAttribute('data-sx-ch')]); });

    var inCount = 0;
    $$('[data-sx-seg]').forEach(function (li) {
      var on = !!c.seg[li.getAttribute('data-sx-seg')]; if (on) inCount++;
      li.classList.toggle('is-in', on);
      li.querySelector('[data-sx-segs]').textContent = on ? 'In' : 'Out';
    });
    $('[data-sx-segn]').textContent = inCount + ' of 5';

    $$('[data-sx-d]').forEach(function (li) {
      var d = c.dest[li.getAttribute('data-sx-d')];
      li.classList.toggle('is-ok', d[0] === 'ok'); li.classList.toggle('is-block', d[0] === 'block'); li.classList.toggle('is-idle', d[0] === 'idle');
      var chip = li.querySelector('[data-sx-ds]');
      chip.className = 'tcs-st ' + (d[0] === 'ok' ? 'tcs-st--ok' : d[0] === 'block' ? 'tcs-st--block' : 'tcs-st--wait');
      chip.textContent = d[0] === 'ok' ? 'Synced' : d[0] === 'block' ? 'Blocked' : 'Idle';
      li.querySelector('[data-sx-dd]').textContent = d[1];
      var g = c.gate[li.getAttribute('data-sx-d')], gEl = li.querySelector('[data-sx-dg]');
      if (g && gEl) { gEl.setAttribute('data-state', g[0]); gEl.querySelector('[data-sx-dgt]').textContent = g[1]; }
    });

    var q = $('[data-sx-q]');
    q.classList.toggle('has-item', !!c.queue);
    $('[data-sx-qn]').textContent = c.queue ? '1 waiting' : 'empty';

    var logEl = $('[data-sx-log]'), old = {};
    BDH.$$('li', logEl).forEach(function (li) { old[li.textContent] = true; });
    logEl.innerHTML = '';
    c.log.forEach(function (row) {
      var li = document.createElement('li'), t = document.createElement('time'), sp = document.createElement('span');
      t.textContent = row[0]; sp.textContent = row[1]; li.appendChild(t); li.appendChild(sp);
      if (animate && !R && !old[row[0] + row[1]]) li.className = 'is-new';
      logEl.appendChild(li);
    });
    if (!c.log.length) { var li0 = document.createElement('li'); li0.innerHTML = '<time>—</time><span>No events processed</span>'; logEl.appendChild(li0); }

    $('[data-sx-status]').textContent = c.status;
    $('[data-sx-next]').setAttribute('aria-disabled', String(st.n >= 8));   // aria-disabled, not disabled: keyboard focus stays on the button at 8 of 8
    $$('[data-sx-prob]').forEach(function (b) { b.setAttribute('aria-checked', String((b.getAttribute('data-sx-prob') === '1') === st.prob)); });
    $('[data-sx-consent]').setAttribute('aria-pressed', String(st.withdrawn));
    rovingTabs();
    prevN = st.n;
  }

  /* ---------------------------------------------------------------- controls */
  var playTimer = null;
  function stopPlay() { if (playTimer) { clearInterval(playTimer); playTimer = null; } $('[data-sx-play]').textContent = 'Play all'; }
  function go(n) {
    st.n = Math.max(0, Math.min(8, n));
    if (st.n < 8) st.decision = null;
    if (st.withdrawn && st.n < st.wN) st.wN = Math.max(2, st.n);   // stepping back before the withdrawal moves it to "now"
    render(true);
  }

  $('[data-sx-next]').addEventListener('click', function () { if (st.n >= 8) return; stopPlay(); go(st.n + 1); });
  $('[data-sx-reset]').addEventListener('click', function () { stopPlay(); st.decision = null; st.withdrawn = false; go(0); });
  $('[data-sx-play]').addEventListener('click', function () {
    if (playTimer) { stopPlay(); return; }
    if (st.n >= 8) { st.decision = null; go(0); }
    if (R) { go(8); return; }
    this.textContent = 'Pause';
    playTimer = setInterval(function () { if (st.n >= 8) { stopPlay(); return; } go(st.n + 1); }, 1400);
  });
  $$('[data-sx-goto]').forEach(function (b) { b.addEventListener('click', function () { stopPlay(); go(parseInt(b.getAttribute('data-sx-goto'), 10)); }); });
  $$('[data-sx-prob]').forEach(function (b) {
    b.addEventListener('click', function () { st.prob = b.getAttribute('data-sx-prob') === '1'; st.decision = null; render(true); });
    b.addEventListener('keydown', function (e) {
      if (['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].indexOf(e.key) < 0) return;
      e.preventDefault(); st.prob = !st.prob; st.decision = null; render(true);
      var other = $('[data-sx-prob="' + (st.prob ? '1' : '0') + '"]'); if (other) other.focus();
    });
  });
  function rovingTabs() { $$('[data-sx-prob]').forEach(function (b) { b.tabIndex = b.getAttribute('aria-checked') === 'true' ? 0 : -1; }); }
  $('[data-sx-consent]').addEventListener('click', function () { st.withdrawn = !st.withdrawn; if (st.withdrawn) st.wN = Math.max(2, st.n); render(true); });
  $$('[data-sx-decide]').forEach(function (b) { b.addEventListener('click', function () { st.decision = b.getAttribute('data-sx-decide'); render(true); }); });
  root.addEventListener('click', rovingTabs);

  render(false); rovingTabs();
  if (narrowMq) { var onMq = function () { paintGraph(); }; if (narrowMq.addEventListener) narrowMq.addEventListener('change', onMq); else if (narrowMq.addListener) narrowMq.addListener(onMq); }
  if (R) return;

  /* ---------------------------------------------------------------- autoplay */
  var steps = [[1200, function () { st.withdrawn = false; st.decision = null; st.prob = true; go(0); rovingTabs(); }]];
  for (var i = 1; i <= 8; i++) steps.push([i === 1 ? 900 : 2300, (function (k) { return function () { go(k); }; })(i)]);
  steps.push([3200, function () { st.withdrawn = true; st.wN = 8; render(true); }]);
  steps.push([4200, function () { st.decision = 'merge'; st.withdrawn = false; render(true); }]);
  steps.push([3600, function () {}]);
  BDH.inView(root, function () {
    BDH.seq(root.querySelector('.tcs-sx__win'), steps, {
      loop: true, stopOnInteract: true, interactRoot: root,
      onStop: function () { rovingTabs(); }
    });
  }, { threshold: 0.08 });   // low: on phones the demo is several screens tall
})();
