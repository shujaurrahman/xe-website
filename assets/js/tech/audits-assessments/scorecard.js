/* Audits & Assessments · scorecard — the radar morph.
   The filled polygon tweens between today's scores and the target; the dashed target outline stays
   put. Both descriptors are in the DOM either way, so the toggle only shifts emphasis. On first
   reveal the shape grows from the centre. Reduced motion: no tween, the shape is already correct. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-taa-score]');
  if (!root) return;

  var svg = root.querySelector('[data-taa-radar]');
  var poly = root.querySelector('[data-taa-poly]');
  var btns = BDH.$$('[data-taa-view] [role="radio"]', root);
  if (!svg || !poly || !btns.length) return;

  function parse(name) {
    return (svg.getAttribute('data-' + name) || '').trim().split(/\s+/).map(function (pair) {
      var xy = pair.split(',');
      return [parseFloat(xy[0]), parseFloat(xy[1])];
    });
  }
  var sets = { now: parse('now'), target: parse('target') };
  if (!sets.now.length || sets.now.length !== sets.target.length) return;

  var box = (svg.getAttribute('viewBox') || '0 0 300 300').split(/\s+/).map(parseFloat);
  var cx = box[0] + box[2] / 2, cy = box[1] + box[3] / 2;
  var seed = sets.now.map(function () { return [cx, cy]; });

  var view = 'now';
  var frame = null;

  function write(points) {
    poly.setAttribute('points', points.map(function (pt) {
      return (Math.round(pt[0] * 10) / 10) + ',' + (Math.round(pt[1] * 10) / 10);
    }).join(' '));
  }

  function tween(start, end, dur) {
    if (BDH.reduced) { write(end); return; }
    if (frame) cancelAnimationFrame(frame);
    var t0 = 0;
    function step(ts) {
      if (!t0) t0 = ts;
      var p = Math.min(1, (ts - t0) / dur);
      var e = 1 - Math.pow(1 - p, 3);
      write(start.map(function (pt, n) {
        return [pt[0] + (end[n][0] - pt[0]) * e, pt[1] + (end[n][1] - pt[1]) * e];
      }));
      if (p < 1) frame = requestAnimationFrame(step);
    }
    frame = requestAnimationFrame(step);
  }

  function pick(n) {
    btns.forEach(function (b, i) {
      b.setAttribute('aria-checked', i === n ? 'true' : 'false');
      b.setAttribute('tabindex', i === n ? '0' : '-1');
    });
    var to = btns[n].getAttribute('data-view') === 'target' ? 'target' : 'now';
    if (to !== view) { tween(sets[view], sets[to], 620); view = to; }
    BDH.$$('.taa-sc__d', root).forEach(function (el) {
      el.classList.toggle('is-on', el.getAttribute('data-view') === to);
    });
  }

  btns.forEach(function (btn, n) {
    btn.addEventListener('click', function () { pick(n); });
    btn.addEventListener('keydown', function (ev) {
      var at = n;
      if (ev.key === 'ArrowRight' || ev.key === 'ArrowDown') at = (n + 1) % btns.length;
      else if (ev.key === 'ArrowLeft' || ev.key === 'ArrowUp') at = (n - 1 + btns.length) % btns.length;
      else return;
      ev.preventDefault();
      pick(at);
      btns[at].focus();
    });
  });

  BDH.inView(root, function () {
    if (BDH.reduced) return;
    tween(seed, sets.now, 820);
  }, { threshold: 0.3 });
})();
