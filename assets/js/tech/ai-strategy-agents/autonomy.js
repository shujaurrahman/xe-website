/* AI Strategy & Agents · 03 SIGNATURE — the autonomy dial. A run engine over pre-authored task data:
   the trace plays step by step (spinner → typed output → latency, tokens, cost), guards check spend
   and records before every step and again before the write, the policy check compares the agent's
   proposal and the write's record count with the limits, and the level decides the write step.
   Each run keeps its own task, owner and level: changing the task or the level mid-run cancels it
   (logged), so an approval can never be given for a different task than the one that asked.
   Autoplays a sequence of runs until the visitor touches the demo.
   Reduced motion: runs resolve at once, no typing, no autoplay. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var app = document.querySelector('[data-tas-au]'); if (!app) return;
  var cfg; try { cfg = JSON.parse(app.getAttribute('data-cfg')); } catch (e) { return; }
  var R = BDH.reduced;
  function $(s) { return app.querySelector(s); }
  function $$(s) { return BDH.$$(s, app); }

  var el = {
    cap: $('#tas-au-cap'), capO: $('#tas-au-cap-o'), rec: $('#tas-au-rec'), recO: $('#tas-au-rec-o'), lim: $('#tas-au-lim'), limO: $('#tas-au-lim-o'),
    limLabel: $('[data-au-limlabel]'), prop: $('[data-au-prop]'), propBox: $('.tas-au__prop'), limT: $('[data-au-limt]'), limSum: $('[data-au-limsum]'), lims: $('#tas-au-lims'),
    dial: $('.tas-au__dial'), lvName: $('[data-au-lvname]'), lvDesc: $('[data-au-lvdesc]'), lvTag: $('[data-au-lvtag]'),
    run: $('[data-au-run]'), reset: $('[data-au-reset]'), trace: $('[data-au-trace]'), status: $('[data-au-status]'),
    rid: $('[data-au-rid]'), agent: $('[data-au-agent]'), prompt: $('[data-au-prompt]'), taskLabel: $('[data-au-tasklabel]'),
    ms: $('[data-au-ms]'), tok: $('[data-au-tok]'), recs: $('[data-au-recs]'), spend: $('[data-au-spend]'),
    res: $('.tas-au__res'), log: $('[data-au-log]'), approve: $('[data-au-approve]'), reject: $('[data-au-reject]'), auto: $('[data-au-auto]')
  };
  var LVL = { 1: ['Suggest', 'Recommends only. No write tools.'], 2: ['Draft', 'Saves a draft. A person sends it.'], 3: ['Act with approval', 'Stops before the write for a person.'], 4: ['Act within limits', 'Writes inside limits, escalates outside.'] };
  var runId = 0, timers = [], pending = null, typers = [], current = null;
  var INR = 88;   /* illustrative rate for the ₹ hint beside the spend cap */
  var LOG_MAX = 4;

  /* ---------- helpers ---------- */
  function later(ms, fn) { var id = setTimeout(fn, R ? 0 : ms); timers.push(id); return id; }
  function clearRun() { timers.forEach(clearTimeout); timers = []; typers.forEach(function (t) { t.stop(); }); typers = []; }
  function money(v) { if (v > 0 && v < 0.00005) return '<$0.0001'; return '$' + (v < 0.01 ? v.toFixed(4) : v.toFixed(3)); }
  function tok(n) { return n >= 1000 ? (Math.round(n / 100) / 10).toString().replace(/\.0$/, '') + 'k' : String(n); }
  function task() { var r = app.querySelector('input[name="tas-au-task"]:checked'); return r ? r.value : 'renew'; }
  function level() { var r = app.querySelector('input[name="tas-au-level"]:checked'); return r ? +r.value : 3; }
  function T() { return cfg.tasks[task()]; }
  function fmtLim(t, v) { return t.limit.pre + v + t.limit.unit; }
  function now() { var d = new Date(); return [d.getHours(), d.getMinutes(), d.getSeconds()].map(function (x) { return (x < 10 ? '0' : '') + x; }).join(':'); }
  function lvTag(l, short) {
    return '<span class="tas-lvl" data-l="' + l + '"><span class="tas-lvl__p" aria-hidden="true"><i></i><i></i><i></i><i></i></span><span class="tas-lvl__n">L' + l + (short ? '' : ' · ' + LVL[l][0]) + '</span></span>';
  }
  function setText(sel, v) { BDH.$$('[data-f="' + sel + '"]', app).forEach(function (n) { if (n.tagName === 'TEXTAREA') n.value = v; else n.textContent = v; }); }
  function pane(name) { BDH.$$('.tas-au__pane', app).forEach(function (p) { p.classList.toggle('is-on', p.getAttribute('data-pane') === name); }); el.res.setAttribute('data-au-res', name); }
  function idleText(t) { BDH.$$('.tas-au__pane[data-pane="idle"] .tas-au__pt', app).forEach(function (p) { p.textContent = t; }); }
  function say(t) { el.status.textContent = t; }
  function cap0(w) { return w.charAt(0).toUpperCase() + w.slice(1); }
  function mk(tag, cls, text) { var n = document.createElement(tag); if (cls) n.className = cls; if (text != null) n.textContent = text; return n; }

  /* ---------- controls ---------- */
  function syncLevel() {
    var l = level();
    el.dial.setAttribute('style', '--a:' + l);
    el.lvName.textContent = LVL[l][0]; el.lvDesc.textContent = LVL[l][1];
  }
  function syncLimits() {
    var t = T();
    var inr = Math.round(+el.cap.value * INR);
    el.capO.textContent = '$' + (+el.cap.value).toFixed(2) + ' ';
    var sm = document.createElement('small'); sm.textContent = '≈ ₹' + inr; el.capO.appendChild(sm);
    el.cap.setAttribute('aria-valuetext', '$' + (+el.cap.value).toFixed(2) + ', about ' + inr + ' rupees');
    el.recO.textContent = el.rec.value; el.rec.setAttribute('aria-valuetext', el.rec.value + ' records');
    el.limO.textContent = fmtLim(t, el.lim.value); el.lim.setAttribute('aria-valuetext', el.limO.textContent);
    el.prop.textContent = fmtLim(t, t.limit.value);
    el.propBox.classList.toggle('is-over', t.limit.value > +el.lim.value);
    if (el.limSum) el.limSum.textContent = '$' + (+el.cap.value).toFixed(2) + ' · ' + el.rec.value + ' records · ' + fmtLim(t, el.lim.value);
  }
  function syncTask(keepLimit) {
    var t = T();
    el.limLabel.textContent = t.limit.label;
    el.lim.min = t.limit.min; el.lim.max = t.limit.max; el.lim.step = t.limit.step;
    if (!keepLimit) el.lim.value = t.limit.def;
    syncLimits();
  }
  /* the run header describes the run on screen, so it changes when a run starts, not when a control does */
  function head(t, l, rid) {
    el.rid.textContent = rid; el.agent.textContent = t.agent; el.prompt.textContent = t.prompt; el.taskLabel.textContent = t.label;
    el.lvTag.innerHTML = lvTag(l);
  }

  /* ---------- trace rows ---------- */
  function row(s) {
    var li = document.createElement('li');
    li.className = 'tas-tr'; li.setAttribute('data-k', s[0]); li.setAttribute('data-st', 'wait');
    li.innerHTML = '<span class="tas-tr__ic" aria-hidden="true"></span><div class="tas-tr__main"><p class="tas-tr__h"><b></b><code></code></p>' +
      '<p class="tas-tr__io"><span>in</span><span class="tas-tr__in"></span></p><p class="tas-tr__io tas-tr__io--out"><span>out</span><em>—</em></p></div>' +
      '<p class="tas-tr__nums"><span>—</span><span>—</span><span>—</span></p><span class="tas-tr__st" aria-hidden="true"></span>';
    li.querySelector('.tas-tr__ic').innerHTML = cfg.icons[s[0]] || '';
    li.querySelector('.tas-tr__h b').textContent = cfg.phase[s[0]];
    li.querySelector('.tas-tr__h code').textContent = s[1];
    var h = li.querySelector('.tas-tr__h');
    if (s[2] !== 'none') { var sc = mk('span', 'tas-tr__scope', s[2]); sc.setAttribute('data-scope', s[2]); h.appendChild(sc); }
    if (s[3]) h.appendChild(mk('span', 'tas-tr__model', s[3]));
    li.querySelector('.tas-tr__in').textContent = s[4];
    return li;
  }
  function stepCost(s) { var p = cfg.price[s[3]] || [0, 0]; return (s[7] * p[0] + s[8] * p[1]) / 1e6; }
  function finishRow(li, s, st, out, cost) {
    li.setAttribute('data-st', st);
    var em = li.querySelector('.tas-tr__io--out em');
    if (R) em.textContent = out; else { em.textContent = ''; typers.push(BDH.type(em, out, { speed: 9 })); }
    var n = li.querySelectorAll('.tas-tr__nums span');
    n[0].textContent = s[6] + ' ms';
    n[1].textContent = (s[7] || s[8]) ? tok(s[7]) + ' → ' + tok(s[8]) : '—';
    n[2].textContent = cost > 0 ? money(cost) : '—';
  }

  /* ---------- audit log: one entry per run, newest first, two lines ---------- */
  function logEntry(e) {
    var li = mk('li', 'tas-au__le' + (R ? '' : ' is-new'));
    var l1 = mk('p', 'tas-au__l1');
    l1.appendChild(mk('span', 'tas-au__lk', e.time));
    l1.appendChild(mk('b', 'tas-au__lr', e.rid));
    l1.appendChild(mk('span', 'tas-au__lk', 'L' + e.level));
    l1.appendChild(mk('span', 'tas-au__lt', e.task));
    var o = mk('span', 'tas-au__lo', e.outcome); o.setAttribute('data-o', e.kind); l1.appendChild(o);
    var l2 = mk('dl', 'tas-au__l2');
    [['Approver', e.approver], ['Models', e.models], ['Prompt', e.prompt], ['Tools', e.tools], ['Records', e.recs], ['Spend', e.spend]].forEach(function (p) {
      var d = mk('div'); d.appendChild(mk('dt', null, p[0])); d.appendChild(mk('dd', null, p[1])); l2.appendChild(d);
    });
    li.appendChild(l1); li.appendChild(l2);
    el.log.insertBefore(li, el.log.firstChild);
    while (el.log.children.length > LOG_MAX) el.log.removeChild(el.log.lastChild);
  }

  /* ---------- the run ---------- */
  function run(opts) {
    opts = opts || {};
    if (current && current.open) current.cancel('Superseded · a new run started', false);
    clearRun(); pending = null;
    var my = ++runId, t = T(), l = level(), cap = +el.cap.value, recCap = +el.rec.value, lim = +el.lim.value;
    var steps = t.steps.map(function (s) { return s.slice(); });
    var rid = 'run_' + Math.random().toString(16).slice(2, 8);
    var tot = { ms: 0, tin: 0, tout: 0, recs: 0, spend: 0 }, models = {}, tools = [];
    app.setAttribute('data-state', 'running');
    head(t, l, rid);
    el.run.disabled = true;
    pane('idle'); setText('owner', t.owner);
    idleText('Running · ' + t.agent + ' at L' + l + ' · ' + LVL[l][0]);
    el.trace.innerHTML = '';
    var rows = steps.map(function (s) { var r = row(s); el.trace.appendChild(r); return r; });
    function totals() {
      el.ms.textContent = (tot.ms / 1000).toFixed(1) + ' s'; el.tok.textContent = tok(tot.tin) + ' → ' + tok(tot.tout);
      el.recs.textContent = String(tot.recs); el.spend.textContent = money(tot.spend);
    }
    totals();
    say('Running · ' + t.label + ' · ' + t.agent + ' · L' + l + ' ' + LVL[l][0]);

    function audit(outcome, kind, approver) {
      logEntry({
        time: now(), rid: rid, level: l, task: t.label, outcome: outcome, kind: kind, approver: approver || '—',
        models: Object.keys(models).join(' · ') || '—', prompt: t.prompt, tools: tools.join(' · ') || '—',
        recs: String(tot.recs), spend: money(tot.spend)
      });
    }
    var me = current = {
      open: true,
      cancel: function (why, show) {
        if (!me.open) return;
        me.open = false; pending = null;
        clearRun(); runId++;
        rows.forEach(function (r) { var st = r.getAttribute('data-st'); if (st === 'wait' || st === 'run' || st === 'await') r.setAttribute('data-st', 'off'); });
        audit(why, 'halt', '—');
        app.setAttribute('data-state', 'idle'); el.run.disabled = false;
        if (show) {
          pane('idle'); idleText('Settings changed, so run ' + rid + ' was cancelled and logged. Press Run agent to start again.');
          say('Run cancelled · settings changed · press Run agent');
        }
      }
    };
    function end(state) { me.open = false; app.setAttribute('data-state', state); el.run.disabled = false; if (opts.done) opts.done(state); }
    function halt(i, why, detail) {
      var s = steps[i];
      finishRow(rows[i], s, 'halt', why, 0);
      var hn = rows[i].querySelectorAll('.tas-tr__nums span');   /* the guarded call was not made: show estimates only */
      hn[0].textContent = 'not run';
      hn[1].textContent = (s[7] || s[8]) ? 'est. ' + tok(s[7]) + ' → ' + tok(s[8]) : '—';
      hn[2].textContent = stepCost(s) > 0 ? 'est. ' + money(stepCost(s)) : '—';
      for (var k = i + 1; k < rows.length; k++) rows[k].setAttribute('data-st', 'off');
      setText('haltk', 'Run stopped · ' + detail);
      setText('haltt', why + '. Nothing was written.');
      setText('hstep', 'Step ' + (i + 1) + ' · ' + cfg.phase[s[0]] + ' · ' + s[1]);
      setText('hspend', money(tot.spend) + ' of $' + cap.toFixed(2));
      setText('haudit', rid + ' · append-only');
      pane('halt'); say('Halted at step ' + (i + 1) + ' · ' + detail + ' · handed to ' + t.owner);
      audit('Halted · ' + detail, 'halt', '—'); end('halt');
    }

    function step(i) {
      if (my !== runId) return;
      var s = steps[i], li = rows[i], dur = Math.max(420, Math.min(1300, s[6] * 0.35));
      li.setAttribute('data-st', 'run');
      if (!R) li.classList.add('is-new');

      if (s[0] === 'check') {
        later(dur, function () {
          if (my !== runId) return;
          /* the check covers the write that follows: at L3 and L4 its records count against the limit */
          var w = steps[i + 1], wr = l >= 3 ? w[9] : 0, after = tot.recs + wr;
          var over = t.limit.value > lim, recOver = after > recCap;
          var out = cap0(t.limit.what) + ' ' + fmtLim(t, t.limit.value) + (over ? ' > ' : ' ≤ ') + fmtLim(t, lim) +
            ' · records ' + (wr ? tot.recs + '+' + wr : tot.recs) + (recOver ? ' > ' : ' ≤ ') + recCap +
            ' · spend ' + money(tot.spend) + ' ≤ $' + cap.toFixed(2) + ' · cites ' + t.policy.replace(/^.* (§.*)$/, '$1');
          tot.ms += s[6]; totals();
          finishRow(li, s, (over && l >= 3) || recOver ? 'flag' : 'ok', out, 0);
          later(dur * 0.9 + 200, function () { write(i + 1, over); });
        });
        return;
      }

      later(dur, function () {
        if (my !== runId) return;
        var c = stepCost(s);
        /* guards run before the step's result is accepted */
        if (tot.spend + c > cap) { halt(i, 'Budget guard: the estimate for this step takes spend to ' + money(tot.spend + c) + ', over the $' + cap.toFixed(2) + ' cap, so the call was not made', 'spend cap'); return; }
        if (tot.recs + s[9] > recCap) { halt(i, 'Record guard: ' + (tot.recs + s[9]) + ' records would be touched, over the limit of ' + recCap, 'record limit'); return; }
        tot.ms += s[6]; tot.tin += s[7]; tot.tout += s[8]; tot.recs += s[9]; tot.spend += c;
        if (s[3]) models[s[3]] = 1;
        if (s[2] === 'read') tools.push(s[1] + ':r');
        totals();
        finishRow(li, s, 'ok', s[5], c);
        later(Math.min(900, s[5].length * 9 + 160), function () { step(i + 1); });
      });
    }

    function write(i, over) {
      if (my !== runId) return;
      var s = steps[i], li = rows[i], h = li.querySelector('.tas-tr__h');
      li.setAttribute('data-st', 'run'); if (!R) li.classList.add('is-new');
      setText('action', t.action + '?');
      setText('why', 'Evidence: ' + t.policy + ' · ' + steps[2][5] + ' · ' + (tot.recs + s[9]) + ' records affected');
      later(500, function () {
        if (my !== runId) return;
        /* the record guard runs again before any write, whatever the level allows */
        if (l >= 3 && tot.recs + s[9] > recCap) {
          halt(i, 'Record guard: the write would take the run to ' + (tot.recs + s[9]) + ' records, over the limit of ' + recCap, 'record limit');
          return;
        }
        if (l === 1) {
          var sc = h.querySelector('.tas-tr__scope'); if (sc) { sc.setAttribute('data-scope', 'denied'); sc.textContent = 'not granted'; }
          finishRow(li, s, 'skip', 'Write tool not on the L1 allow-list · suggestion returned instead', 0);
          setText('rec', t.rec); pane('suggest');
          say('Run complete · suggestion delivered to ' + t.owner + ' · nothing written');
          audit('Suggested · no action', 'ok', '—'); end('done');
        } else if (l === 2) {
          li.querySelector('.tas-tr__h code').textContent = t.draft_tool;
          var sc2 = h.querySelector('.tas-tr__scope'); if (sc2) { sc2.setAttribute('data-scope', 'draft'); sc2.textContent = 'draft'; }
          tools.push(t.draft_tool + ':d');
          finishRow(li, s, 'ok', 'Draft saved · waiting for ' + t.owner + ' to send', 0);
          setText('drafttool', t.draft_tool); setText('draft', t.draft); pane('draft');
          say('Run complete · draft saved for ' + t.owner + ' · editable below');
          audit('Draft saved · awaiting person', 'ok', '—'); end('done');
        } else if (l === 4 && !over) {
          tot.recs += s[9]; tot.ms += s[6]; tools.push(s[1] + ':w'); totals();
          finishRow(li, s, 'ok', 'Executed within limits · ' + fmtLim(t, t.limit.value) + ' ≤ ' + fmtLim(t, lim) + ' · ' + tot.recs + ' of ' + recCap + ' records', 0);
          setText('donek', 'Executed within limits'); setText('donet', t.action + '. Done without a person because every value sat inside the limits.');
          setText('rw', s[1] + ' · ' + s[4]); setText('rappr', 'None needed · ' + fmtLim(t, t.limit.value) + ' within ' + fmtLim(t, lim));
          setText('rwait', '0 s'); setText('raudit', rid + ' · append-only');
          pane('done'); say('Run complete · executed within limits · audit entry written');
          audit('Executed within limits', 'exec', 'None needed · within limits'); end('done');
        } else {
          var esc = l === 4, owner = t.owner;
          finishRow(li, s, 'await', esc ? 'Escalated · ' + fmtLim(t, t.limit.value) + ' exceeds the ' + fmtLim(t, lim) + ' limit' : 'Waiting for ' + owner + ' to approve', 0);
          setText('apprk', esc ? 'Escalated · over the limit' : 'Approval needed');
          pane('approve');
          var askedAt = Date.now();
          say((esc ? 'Escalated to ' : 'Waiting for approval from ') + owner + ' · ' + t.action);
          app.setAttribute('data-state', 'await');
          pending = {
            owner: owner,
            fn: function (ok, who) {
              if (my !== runId) return;
              pending = null;
              if (ok) {
                tot.recs += s[9]; tot.ms += s[6]; tools.push(s[1] + ':w'); totals();
                finishRow(li, s, 'ok', 'Approved by ' + who + ' · executed', 0);
                setText('donek', esc ? 'Executed after escalation' : 'Executed after approval');
                setText('donet', t.action + '. Approved by ' + who + '.');
                setText('rw', s[1] + ' · ' + s[4]); setText('rappr', who);
                setText('rwait', Math.max(1, Math.round((Date.now() - askedAt) / 1000)) + ' s'); setText('raudit', rid + ' · append-only');
                pane('done'); say('Run complete · approved by ' + who + ' · audit entry written');
                audit(esc ? 'Escalated · approved · executed' : 'Executed after approval', 'exec', who);
              } else {
                finishRow(li, s, 'halt', 'Rejected by ' + who + ' · nothing written · case added to the eval set', 0);
                setText('haltk', 'Rejected by a person'); setText('haltt', 'The action was declined. The run and the reason go into the eval set.');
                setText('hstep', 'Step ' + (i + 1) + ' · ' + cfg.phase[s[0]] + ' · ' + s[1]); setText('hspend', money(tot.spend) + ' of $' + cap.toFixed(2)); setText('haudit', rid + ' · append-only');
                pane('halt'); say('Run closed · rejected by ' + who);
                audit('Rejected · no action', 'halt', who);
              }
              end('done');
            }
          };
          el.run.disabled = false;
        }
      });
    }

    later(R ? 0 : 350, function () { step(0); });
  }

  /* ---------- wiring ---------- */
  function settingsChanged() { if (current && current.open) current.cancel('Cancelled · settings changed', true); }
  $$('input[name="tas-au-task"]').forEach(function (r) { r.addEventListener('change', function () { settingsChanged(); syncTask(false); }); });
  $$('input[name="tas-au-level"]').forEach(function (r) { r.addEventListener('change', function () { settingsChanged(); syncLevel(); }); });
  [el.cap, el.rec, el.lim].forEach(function (r) { r.addEventListener('input', syncLimits); });
  el.run.addEventListener('click', function () { run(); });
  el.reset.addEventListener('click', function () { el.cap.value = 0.25; el.rec.value = 25; el.lim.value = T().limit.def; syncLimits(); });
  el.approve.addEventListener('click', function () { if (pending) pending.fn(true, 'you, as ' + pending.owner); });
  el.reject.addEventListener('click', function () { if (pending) pending.fn(false, 'you, as ' + pending.owner); });

  /* phones: the limits fold behind a one-line summary (the button only shows below 760px) */
  if (el.limT && el.lims) {
    var small = window.matchMedia ? window.matchMedia('(max-width: 760px)') : { matches: false };
    var setLims = function (open) { el.lims.classList.toggle('is-shut', !open); el.limT.setAttribute('aria-expanded', open ? 'true' : 'false'); };
    setLims(!small.matches);
    el.limT.addEventListener('click', function () { setLims(el.limT.getAttribute('aria-expanded') !== 'true'); });
    if (small.addEventListener) small.addEventListener('change', function (e) { setLims(!e.matches); });
  }

  syncTask(true); syncLevel();
  function yours() { if (el.auto) { el.auto.querySelector('span').textContent = 'Your controls'; el.auto.querySelector('.tas-led').classList.add('tas-led--off'); } }
  if (R) { yours(); return; }

  /* ---------- autoplay until the demo is touched ---------- */
  function set(k, l, lim, rec) {
    var tr = app.querySelector('input[name="tas-au-task"][value="' + k + '"]'); if (tr) tr.checked = true;
    var lr = app.querySelector('input[name="tas-au-level"][value="' + l + '"]'); if (lr) lr.checked = true;
    syncTask(false); el.cap.value = 0.25; el.rec.value = rec || 25; if (lim != null) el.lim.value = lim; syncLimits(); syncLevel();
  }
  function autoApprove() {
    if (!pending) return;
    el.approve.classList.add('is-press');
    setTimeout(function () { el.approve.classList.remove('is-press'); if (pending) pending.fn(true, pending.owner); }, 380);
  }
  /* [task, level, approval limit, record limit]: approval, within limits, escalation, draft, a record-guard halt, suggestion, within limits */
  var demo = [
    ['renew', 3, null, null], ['dispute', 4, null, null], ['renew', 4, 5, null], ['board', 2, null, null],
    ['dispute', 4, null, 3], ['dispute', 1, null, null], ['board', 4, null, null]
  ];
  var seq = [];
  demo.forEach(function (d) {
    seq.push([1800, function () { set(d[0], d[1], d[2], d[3]); }]);
    seq.push([900, function () { run(); }]);
    seq.push([d[0] === 'board' ? 9800 : 7600, autoApprove]);
    seq.push([3400, function () {}]);
  });
  /* start as soon as the demo is properly in view, however tall it is on a phone: a low threshold
     plus a bottom margin, and the timeline pauses against the trace column (not the whole demo),
     so short screens still reach its visibility threshold */
  BDH.inView(app, function () {
    BDH.seq(app.querySelector('.tas-au__main') || app, seq, { loop: true, stopOnInteract: true, interactRoot: app, onStop: yours });
  }, { threshold: 0.05, rootMargin: '0px 0px -20% 0px' });
  BDH.live(app, 0.1);
})();
