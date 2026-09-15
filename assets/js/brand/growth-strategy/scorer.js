/* Growth Strategy · 04 SIGNATURE — next-best-customer scorer. Sliders re-weight five criteria; rows
   re-sort with FLIP; the agent note explains the biggest move; sign-off resets when weights change.
   Autoplays presets (tweening the sliders) until the first interaction inside the demo. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-cgs-scorer]'); if (!root) return;
  var segs = JSON.parse(root.getAttribute('data-segs'));
  var presets = JSON.parse(root.getAttribute('data-presets'));
  var crit = JSON.parse(root.getAttribute('data-crit'));
  var list = root.querySelector('[data-cgs-list]');
  var ranges = BDH.$$('[data-cgs-w]', root), outs = BDH.$$('[data-cgs-wv]', root);
  var pbtns = BDH.$$('[data-cgs-preset]', root);
  var note = root.querySelector('[data-cgs-note]'), live = root.querySelector('[data-cgs-live]');
  var auto = root.querySelector('[data-cgs-auto]');
  var sign = root.querySelector('[data-cgs-sign]'), state = root.querySelector('[data-cgs-state]'), sbtn = root.querySelector('[data-cgs-signbtn]');
  var rows = {}; BDH.$$('[data-cgs-seg]', list).forEach(function (r) { rows[r.getAttribute('data-cgs-seg')] = r; });

  var w = ranges.map(function (r) { return +r.value; });
  var order = BDH.$$('[data-cgs-seg]', list).map(function (r) { return r.getAttribute('data-cgs-seg'); });
  var byUser = false, liveT = 0;

  function scoreOf(s) { var t = 0, sw = 0; for (var i = 0; i < 5; i++) { t += s[i] * w[i]; sw += w[i]; } return sw ? Math.round(t / sw * 10) : 0; }

  function render(userMove) {
    var scored = segs.map(function (s) { return { k: s[0], v: scoreOf(s[1]), s: s[1] }; });
    scored.sort(function (a, b) { return b.v - a.v || a.k.localeCompare(b.k); });
    var prev = order.slice(), first = {};
    Object.keys(rows).forEach(function (k) { first[k] = rows[k].getBoundingClientRect().top; });
    scored.forEach(function (x, i) {
      var r = rows[x.k];
      list.appendChild(r);
      r.classList.toggle('is-short', i < 3);
      r.querySelector('[data-cgs-pos]').textContent = i + 1;
      r.querySelector('[data-cgs-val]').textContent = x.v;
      r.querySelector('[data-cgs-fill]').style.setProperty('--s', x.v / 100);
      var d = prev.indexOf(x.k) - i, m = r.querySelector('[data-cgs-move]');
      m.textContent = d > 0 ? '▲' + d : d < 0 ? '▼' + (-d) : '';
      m.classList.toggle('is-up', d > 0);
    });
    order = scored.map(function (x) { return x.k; });
    if (!BDH.reduced) Object.keys(rows).forEach(function (k) {   // FLIP
      var r = rows[k], dy = first[k] - r.getBoundingClientRect().top;
      if (!dy) return;
      r.style.transition = 'none'; r.style.transform = 'translateY(' + dy + 'px)';
      r.getBoundingClientRect();
      r.style.transition = 'transform .7s cubic-bezier(.22,1,.36,1)'; r.style.transform = '';
    });
    explain(prev, scored);
    carry(scored[0]);
    if (userMove) {
      clearTimeout(liveT);
      liveT = setTimeout(function () { live.textContent = 'Ranking: ' + scored.map(function (x, i) { return (i + 1) + ' Segment ' + x.k + ' ' + x.v; }).join(', ') + '.'; }, 500);
      if (sign.classList.contains('is-signed')) { sign.classList.remove('is-signed'); state.textContent = 'Weights changed · shortlist needs sign-off again'; sbtn.disabled = false; }
    }
  }

  var why = root.querySelector('[data-cgs-why]');
  function carry(top) {   // share of the leader's score contributed by each criterion
    if (!why) return;
    var parts = top.s.map(function (v, i) { return v * w[i]; });
    var sum = parts.reduce(function (a, b) { return a + b; }, 0) || 1;
    var pct = parts.map(function (v) { return Math.round(v / sum * 100); });
    var max = Math.max.apply(null, pct) || 1;
    why.querySelector('[data-cgs-lead]').textContent = 'Segment ' + top.k;
    BDH.$$('.cgs-sc__parts li', why).forEach(function (li, i) {
      li.classList.toggle('is-top', pct[i] === max);
      li.querySelector('b').style.setProperty('--p', (pct[i] / max).toFixed(3));
      li.querySelector('em').textContent = pct[i] + '%';
    });
  }

  function explain(prev, scored) {
    var top = scored[0], big = 0, mover = null;
    scored.forEach(function (x, i) { var d = prev.indexOf(x.k) - i; if (Math.abs(d) > Math.abs(big)) { big = d; mover = x; } });
    var hi = 0; for (var i = 1; i < 5; i++) if (w[i] > w[hi]) hi = i;
    var flat = Math.max.apply(null, w) === Math.min.apply(null, w);
    var txt;
    if (flat) txt = 'With equal weights, Segment ' + top.k + ' leads on breadth: no single criterion carries it.';
    else if (mover && big) {
      txt = 'Segment ' + mover.k + (big > 0 ? ' rose ' : ' fell ') + Math.abs(big) + (Math.abs(big) > 1 ? ' places' : ' place') + ': ' + crit[hi].toLowerCase() +
        ' now weighs ' + w[hi] + ' of 10 and ' + mover.k + ' scores ' + mover.s[hi] + ' on it. Segment ' + top.k + ' leads at ' + top.v + '.';
    } else txt = 'No change in order. Segment ' + top.k + ' still leads at ' + top.v + '; ' + crit[hi].toLowerCase() + ' carries the most weight.';
    var low = scored.slice(0, 3).filter(function (x) { return x.k === 'F' || x.k === 'E'; })[0];
    if (low) txt += ' Flag: Segment ' + low.k + ' rests on few interviews, so a strategist should check it.';
    if (note.textContent !== txt) { note.textContent = txt; note.classList.remove('is-fresh'); void note.offsetWidth; note.classList.add('is-fresh'); }
  }

  function setW(i, v, userMove) {
    w[i] = v; ranges[i].value = v; ranges[i].style.setProperty('--v', v / 10); outs[i].textContent = v;
    render(userMove);
  }
  function mark(p) { pbtns.forEach(function (b, n) { b.setAttribute('aria-pressed', n === p ? 'true' : 'false'); }); }

  var tween = null;
  function toPreset(p, userMove) {
    mark(p);
    var target = presets[p];
    if (userMove || BDH.reduced) { target.forEach(function (v, i) { w[i] = v; ranges[i].value = v; ranges[i].style.setProperty('--v', v / 10); outs[i].textContent = v; }); render(userMove); return; }
    var steps = 0; clearInterval(tween);
    tween = setInterval(function () {   // step each slider one notch at a time so the race visibly re-sorts
      var moved = false;
      for (var i = 0; i < 5; i++) if (w[i] !== target[i]) { setW(i, w[i] + (target[i] > w[i] ? 1 : -1), false); moved = true; break; }
      if (!moved || ++steps > 40) clearInterval(tween);
    }, 260);
  }

  ranges.forEach(function (r, i) { r.addEventListener('input', function () { mark(-1); setW(i, +r.value, true); }); });
  pbtns.forEach(function (b, n) { b.addEventListener('click', function () { toPreset(n, true); }); });
  sbtn.addEventListener('click', function () {
    sign.classList.add('is-signed'); sbtn.disabled = true;
    state.textContent = 'Signed off by strategist · shortlist ' + order.slice(0, 3).join(', ') + ' goes to the thesis';
  });

  if (BDH.reduced) { auto.classList.add('is-off'); auto.lastChild.textContent = 'Your controls'; return; }
  var p = 0, player = BDH.seq(root, [[3200, function () { p = (p + 1) % presets.length; toPreset(p, false); }]], {
    loop: true, stopOnInteract: true,
    onStop: function () { byUser = true; clearInterval(tween); auto.classList.add('is-off'); auto.lastChild.textContent = 'Your controls'; }
  });
  BDH.live(root, 0.2);
})();
