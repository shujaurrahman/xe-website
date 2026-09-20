/* AI Infrastructure & Cloud · chaos — the Failure Drill engine. Reads the series PHP modelled for every
   scenario × patterns combination, plots them up to the playhead on four linked charts, greys and reroutes
   the architecture mini-map, reveals the incident log line by line and keeps the summary honest.
   Play runs the ten-minute window in about ten seconds; the scrubber, the injection buttons and the
   patterns switch all work while paused. Autoplays "Kill a GPU node · patterns on" until the reader
   touches the console. Reduced motion: no autoplay, no playback loop; every control still renders
   the finished state at once. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tic-dr');
  if (!root) return;
  var data = null;
  try { data = JSON.parse(root.querySelector('.tic-dr__data').textContent); } catch (e) { return; }
  var R = BDH.reduced;
  var T = data.t, HIT = data.hit, END = T[T.length - 1], SPEED = 60;   // drill seconds per real second
  var scn = root.getAttribute('data-scn') || 'node';
  var mode = root.getAttribute('data-mode') || 'on';
  var t = END, playing = false, raf = null, last = 0, touched = false, visible = false, autoTimer = null;

  var $ = function (s) { return root.querySelector(s); };
  var range = $('[data-dr-range]'), scrub = range ? range.parentNode : null;
  var clock = $('[data-dr-clock]'), playBtn = $('[data-dr-play]'), playT = $('[data-dr-playt]');
  var mapSvg = $('[data-dr-map]'), mapLbl = $('[data-dr-maps]'), regionLbl = $('[data-dr-region]');
  var logList = $('[data-dr-log]'), logCount = $('[data-dr-logs]'), status = $('[data-dr-status]');
  var lgCur = $('[data-dr-lg="cur"]'), lgAlt = $('[data-dr-lg="alt"]');
  var sums = {};
  BDH.$$('[data-dr-sum]', root).forEach(function (el) { sums[el.getAttribute('data-dr-sum')] = el; });

  var charts = [];
  data.charts.forEach(function (c) {
    var el = root.querySelector('[data-dr-chart="' + c.key + '"]');
    if (!el) return;
    charts.push({
      key: c.key, min: c.min, max: c.max,
      val: el.querySelector('[data-dr-val]'),
      clip: el.querySelector('.tic-dr__clip'),
      ph: el.querySelector('.tic-dr__ph'),
      line: el.querySelector('.tic-dr__line'),
      ghost: el.querySelector('.tic-dr__ghost'),
      future: el.querySelector('.tic-dr__future')
    });
  });

  var NAMES = { node: 'Kill a GPU node', provider: 'Provider returns 429 rate limits', region: 'Region outage' };
  var MAP_STATES = ['is-n3-down', 'is-n3-ejected', 'is-w0-warming', 'is-w0-up', 'is-w1-up', 'is-a-429', 'is-a-jam', 'is-a-open', 'is-a-half', 'is-b-on', 'is-cache-hot', 'is-queue-hot', 'is-p-down', 'is-sb-up'];

  function key() { return scn + '-' + mode; }
  function alt() { return scn + '-' + (mode === 'on' ? 'off' : 'on'); }
  function run() { return data.runs[key()]; }
  function mmss(s) { s = Math.round(s); return (Math.floor(s / 60) < 10 ? '0' : '') + Math.floor(s / 60) + ':' + (s % 60 < 10 ? '0' : '') + (s % 60); }
  function clockAt(s) { return '14:' + mmss(s); }
  function fmt(k, v) {
    if (k === 'rps') return Math.round(v).toLocaleString('en-US');
    if (k === 'p95') return v >= 4000 ? '≥ 4 s' : (v >= 1000 ? (v / 1000).toFixed(2) + ' s' : Math.round(v) + ' ms');
    if (k === 'err') return (v < 1 ? v.toFixed(2) : v.toFixed(1)) + '%';
    return v.toFixed(1) + '%';
  }
  function path(vals, min, max) {
    var d = '';
    for (var i = 0; i < vals.length; i++) {
      var v = Math.max(min, Math.min(max, vals[i]));
      d += (i ? 'L' : 'M') + (i * 10) + ',' + (120 - (v - min) / (max - min) * 120).toFixed(1);
    }
    return d;
  }
  function used(r) { return r.used.toFixed(r.used < 0.1 ? 2 : 1) + '%'; }
  function peak(r, k) { return Math.max.apply(null, r[k].slice(Math.floor(HIT / 10))); }

  /* ---- map ---- */
  function mapClasses() {
    var c = [];
    if (t < HIT) return c;
    if (scn === 'node') {
      c.push('is-n3-down');
      if (mode === 'on') {
        if (t >= 129) c.push('is-n3-ejected');
        if (t >= 140) c.push('is-queue-hot');
        if (t >= 150) c.push('is-w0-warming');
        if (t >= 210) c.push('is-w0-up');
      } else if (t >= 480) { c.push('is-n3-ejected'); }
    } else if (scn === 'provider') {
      if (mode === 'on') {
        if (t < 480) { c.push('is-a-429'); if (t >= 124) c.push('is-a-open', 'is-b-on'); if (t >= 130) c.push('is-cache-hot'); }
        else { c.push('is-a-half', 'is-b-on', 'is-cache-hot'); }
        if (t >= 160) c.push('is-w0-up', 'is-w1-up');
      } else {
        if (t < 480) c.push('is-a-429', 'is-a-jam', 'is-queue-hot');
      }
    } else {
      c.push('is-p-down');
      if (mode === 'on' ? t >= 138 : t >= 540) c.push('is-sb-up');
    }
    return c;
  }
  function mapLabel() {
    if (t < HIT) return 'steady · 40 req/s across 6 serving GPUs';
    if (scn === 'node') {
      if (mode === 'on') return t >= 210 ? 'gpu-node-3 ejected · replica added' : t >= 150 ? 'gpu-node-3 ejected · warm replica joining' : t >= 129 ? 'gpu-node-3 ejected from the pool' : 'gpu-node-3 unresponsive';
      return t >= 480 ? 'gpu-node-3 drained by hand' : 'gpu-node-3 still in the pool · 1 in 4 requests fail';
    }
    if (scn === 'provider') {
      if (mode === 'on') return t >= 480 ? 'half-open probe · traffic returning to A' : t >= 160 ? 'breaker open · +2 replicas on the pool' : t >= 124 ? 'breaker open · provider B + self-hosted' : 'provider A returning 429';
      return t >= 480 ? 'provider A recovered · retries subside' : 'clients retrying · provider A throttled';
    }
    if (mode === 'on') return t >= 138 ? 'failover · Hyderabad standby serving' : 'Mumbai unreachable · failover starting';
    return t >= 540 ? 'DNS switched · Hyderabad serving' : 'Mumbai unreachable · nothing served';
  }
  function paintMap() {
    if (!mapSvg) return;
    var want = mapClasses();
    MAP_STATES.forEach(function (k) { mapSvg.classList.toggle(k, want.indexOf(k) !== -1); });
    if (mapLbl) mapLbl.textContent = mapLabel();
    if (regionLbl) regionLbl.textContent = (scn === 'region' && t >= HIT) ? 'Mumbai · unreachable' : 'Mumbai · primary';
  }

  /* ---- log ---- */
  var logItems = [];
  function buildLog() {
    if (!logList) return;
    logList.innerHTML = '';
    logItems = [];
    run().log.forEach(function (l) {
      var li = document.createElement('li'), tm = document.createElement('time'), sp = document.createElement('span');
      li.className = 'is-' + l[1];
      tm.textContent = clockAt(l[0]); sp.textContent = l[2];
      li.appendChild(tm); li.appendChild(sp);
      li.classList.add('is-fut');
      logList.appendChild(li);
      logItems.push({ at: l[0], el: li });
    });
  }
  function paintLog() {
    var n = 0;
    logItems.forEach(function (it) {
      var show = it.at <= t;
      if (show && it.el.classList.contains('is-fut') && playing && !R) { it.el.classList.remove('is-new'); void it.el.offsetWidth; it.el.classList.add('is-new'); }
      it.el.classList.toggle('is-fut', !show);
      if (show) n++;
    });
    if (logCount) logCount.textContent = n + ' of ' + logItems.length + ' events';
  }

  /* ---- series ---- */
  function applyRun() {
    var r = run(), a = data.runs[alt()];
    charts.forEach(function (c) {
      var d = path(r[c.key], c.min, c.max);
      if (c.line) c.line.setAttribute('d', d);
      if (c.future) c.future.setAttribute('d', d);
      if (c.ghost) c.ghost.setAttribute('d', path(a[c.key], c.min, c.max));
    });
    if (lgCur) lgCur.textContent = mode;
    if (lgAlt) lgAlt.textContent = mode === 'on' ? 'off' : 'on';
    if (sums.err) sums.err.textContent = fmt('err', peak(r, 'err'));
    if (sums.p95) sums.p95.textContent = fmt('p95', peak(r, 'p95'));
    if (sums.used) sums.used.textContent = used(r) + ' of the month';
    if (sums.page) sums.page.textContent = r.alert === null || r.alert === undefined ? 'Not triggered' : 'Fired at ' + mmss(r.alert);
    BDH.$$('[data-dr-scn]', root).forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-dr-scn') === scn ? 'true' : 'false'); });
    var sw = $('[data-dr-mode]');
    if (sw) { sw.setAttribute('aria-pressed', mode === 'on' ? 'true' : 'false'); var v = sw.querySelector('.tic-dr__swv'); if (v) v.textContent = mode; }
    root.setAttribute('data-scn', scn); root.setAttribute('data-mode', mode);
    buildLog();
    if (status) {
      status.textContent = NAMES[scn] + ' with resilience patterns ' + mode + ': peak client-visible errors ' + fmt('err', peak(r, 'err')) +
        ', peak p95 latency ' + fmt('p95', peak(r, 'p95')) + ', ' + used(r) + ' of the monthly error budget used, ' +
        (r.alert === null || r.alert === undefined ? 'no page fired.' : 'the fast-burn page fired at ' + mmss(r.alert) + '.');
    }
  }

  function render() {
    var idx = Math.round(t / 10), r = run();
    charts.forEach(function (c) {
      if (c.clip) c.clip.setAttribute('width', String(t));
      if (c.ph) { c.ph.setAttribute('x1', String(t)); c.ph.setAttribute('x2', String(t)); }
      if (c.val) c.val.textContent = fmt(c.key, r[c.key][idx]);
    });
    if (range) {
      range.value = String(Math.round(t / 10) * 10);
      range.setAttribute('aria-valuetext', mmss(t) + ' of ' + mmss(END));
      var p = (t / END).toFixed(4);
      range.style.setProperty('--p', p);
      if (scrub) scrub.style.setProperty('--p', p);
    }
    if (clock) clock.textContent = mmss(t);
    paintMap();
    paintLog();
  }

  /* ---- playback ---- */
  function setPlayUI() {
    root.classList.toggle('is-playing', playing);
    if (playT) playT.textContent = playing ? 'Pause' : (t >= END ? 'Replay' : 'Play');
    if (playBtn) playBtn.setAttribute('aria-label', playing ? 'Pause the drill' : (t >= END ? 'Replay the drill' : 'Play the drill'));
  }
  function step(ts) {
    if (!playing) return;
    var dt = Math.min(0.1, (ts - last) / 1000); last = ts;
    t = Math.min(END, t + dt * SPEED);
    render();
    if (t >= END) { playing = false; setPlayUI(); armAuto(); return; }
    raf = requestAnimationFrame(step);
  }
  function play() {
    if (R) { t = END; render(); setPlayUI(); return; }
    if (t >= END) t = 0;
    playing = true; last = performance.now(); setPlayUI();
    cancelAnimationFrame(raf); raf = requestAnimationFrame(step);
  }
  function pause() {
    playing = false; cancelAnimationFrame(raf); setPlayUI();
  }
  function armAuto() {
    clearTimeout(autoTimer);
    if (R || touched || !visible) return;
    autoTimer = setTimeout(function () { if (!touched && visible && !playing) play(); }, 2600);
  }

  /* ---- controls ---- */
  if (playBtn) playBtn.addEventListener('click', function () { playing ? pause() : play(); });
  if (range) {
    range.addEventListener('input', function () { if (playing) pause(); t = Math.max(0, Math.min(END, parseInt(range.value, 10) || 0)); render(); });
  }
  BDH.$$('[data-dr-scn]', root).forEach(function (b) {
    b.addEventListener('click', function () {
      var k = b.getAttribute('data-dr-scn');
      if (k === scn && !R) { t = 0; applyRun(); render(); play(); return; }
      scn = k; pause(); applyRun();
      if (R) { t = END; render(); } else { t = 0; render(); play(); }
    });
  });
  var sw = $('[data-dr-mode]');
  if (sw) sw.addEventListener('click', function () { mode = mode === 'on' ? 'off' : 'on'; applyRun(); render(); });

  BDH.onInteract(root, function () { touched = true; clearTimeout(autoTimer); });
  BDH.live(root, 0.2, function (on) {
    visible = on;
    if (!on && playing) pause();
    if (on && !touched && !playing && !R) armAuto();
  });

  applyRun();
  render();
  setPlayUI();
  if (!R) BDH.inView(root, function () { visible = true; if (!touched) armAuto(); }, { threshold: 0.35 });
})();
