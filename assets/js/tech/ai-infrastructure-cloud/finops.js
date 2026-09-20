/* AI Infrastructure & Cloud · finops — the console's two controls.
   1. Unit cost: "By feature / By team / By model route" rewrites the five rows in place, so bars and target
      ticks glide to their new values; the metric line, caption and a polite status follow.
   2. The anomaly: "Approve and open PR" or "Hold for review" writes the matching audit-log line and state;
      "Reset demo" puts the proposal back. The agent never acts on its own.
   The forecast draw and the card's slide-in are CSS on .is-in; the LED blinks only while on screen. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tic-fo');
  if (!root) return;
  var R = BDH.reduced, data = null;
  try { data = JSON.parse(root.querySelector('.tic-fo__data').textContent); } catch (e) { data = null; }
  BDH.live(root, 0.15);

  /* ---- unit cost views ---- */
  var btns = BDH.$$('[data-fo-view]', root), table = root.querySelector('.tic-fo__table');
  var rows = BDH.$$('[data-fo-rows] > tr', root), metric = root.querySelector('[data-fo-metric]');
  var caption = root.querySelector('[data-fo-caption]'), status = root.querySelector('[data-fo-status]');
  var cur = root.getAttribute('data-view') || 'feature';

  function fmt(v, pre, suf) {
    if (v < 0.01) return pre + v.toFixed(3) + suf;
    return pre + v.toFixed(suf === 'k' ? 1 : 2) + suf;
  }
  function paint(key) {
    var v = data[key];
    rows.forEach(function (tr, i) {
      var r = v.rows[i]; if (!r) return;
      var over = r[1] > r[2];
      tr.classList.toggle('is-over', over);
      tr.querySelector('.tic-fo__nm').textContent = r[0];
      tr.querySelector('small').textContent = r[3];
      var bar = tr.querySelector('.tic-fo__b i'), tick = tr.querySelector('.tic-fo__b b');
      if (bar) bar.style.setProperty('--w', (r[1] / v.max).toFixed(4));
      if (tick) tick.style.setProperty('--t', (r[2] / v.max).toFixed(4));
      var nums = tr.querySelectorAll('.tic-fo__num');
      if (nums[0]) nums[0].textContent = fmt(r[1], v.pre, v.suf);
      if (nums[1]) nums[1].textContent = fmt(r[2], v.pre, v.suf);
      var tr2 = tr.querySelector('.tic-fo__tr'); if (tr2) tr2.textContent = r[4];
    });
    if (metric) metric.textContent = v.metric;
    if (caption) caption.textContent = v.metric + ', with target and change against last month';
    var over = v.rows.filter(function (r) { return r[1] > r[2]; }).map(function (r) { return r[0]; });
    if (status) status.textContent = v.metric + '. ' + (over.length ? 'Over target: ' + over.join(', ') + '.' : 'Every row is inside its target.');
  }
  function setView(key) {
    if (!data || !data[key] || key === cur) return;
    cur = key;
    root.setAttribute('data-view', key);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-fo-view') === key ? 'true' : 'false'); });
    if (R || !table) { paint(key); return; }
    table.classList.add('is-swap');
    setTimeout(function () { paint(key); table.classList.remove('is-swap'); }, 220);
  }
  btns.forEach(function (b) { b.addEventListener('click', function () { setView(b.getAttribute('data-fo-view')); }); });

  /* ---- approval ---- */
  var an = root.querySelector('[data-fo-an]');
  if (an) {
    var stateT = an.querySelector('[data-fo-state-t]');
    var acts = BDH.$$('[data-fo-do]', an);
    var lines = { approve: an.querySelector('.tic-fo__log .is-approve'), hold: an.querySelector('.tic-fo__log .is-hold') };
    var TEXT = {
      base: 'Awaiting your approval · the agent cannot merge',
      approve: 'Approved · PR #482 opened · merges after one more review',
      hold: 'Held · assigned to platform on-call with the agent’s notes'
    };
    function now() { var d = new Date(); return (d.getHours() < 10 ? '0' : '') + d.getHours() + ':' + (d.getMinutes() < 10 ? '0' : '') + d.getMinutes(); }
    function setState(s) {
      an.setAttribute('data-state', s);
      ['approve', 'hold'].forEach(function (k) {
        var li = lines[k]; if (!li) return;
        var on = k === s;
        if (on) {
          var t = li.querySelector('time'); if (t) t.textContent = now();
          if (!R) { li.classList.remove('is-new'); void li.offsetWidth; li.classList.add('is-new'); }
        }
        li.hidden = !on;
      });
      acts.forEach(function (b) {
        var k = b.getAttribute('data-fo-do');
        if (k === 'reset') b.hidden = s === 'base';
        else b.disabled = s !== 'base';
      });
      if (stateT) stateT.textContent = TEXT[s];
      if (s === 'base') { var first = an.querySelector('[data-fo-do="approve"]'); if (first && document.activeElement && document.activeElement.hidden) first.focus(); }
    }
    acts.forEach(function (b) {
      b.addEventListener('click', function () {
        var k = b.getAttribute('data-fo-do');
        if (k === 'reset') { setState('base'); var a = an.querySelector('[data-fo-do="approve"]'); if (a) a.focus(); return; }
        setState(k);
        var reset = an.querySelector('[data-fo-do="reset"]'); if (reset) reset.focus();
      });
    });
  }
})();
