/* Hub · platform — layer toggles (aria-pressed) isolate a layer and swap the "builds this layer" pane; the
   trace runner moves a packet through the components of one request, lights each step and ticks the
   latency label. The runner pauses off screen. Reduced motion: toggles still work, no packet. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tih-pf');
  if (!root) return;
  var arch = BDH.$('.tih-pf__arch', root);

  /* ---- layer isolation ---- */
  var btns = BDH.$$('.tih-pf__seg button', root);
  var panes = BDH.$$('.tih-pf__builds .bdh-pane', root);
  function show(key) {
    root.setAttribute('data-layer', key);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-layer') === key ? 'true' : 'false'); });
    panes.forEach(function (p) { p.classList.toggle('is-on', p.getAttribute('data-pane') === key); });
  }
  btns.forEach(function (b, i) {
    b.addEventListener('click', function () { show(b.getAttribute('data-layer')); });
    b.addEventListener('keydown', function (e) {
      var j = e.key === 'ArrowRight' ? i + 1 : e.key === 'ArrowLeft' ? i - 1 : -99;
      if (j === -99) return;
      e.preventDefault();
      j = (j + btns.length) % btns.length;
      btns[j].focus(); show(btns[j].getAttribute('data-layer'));
    });
  });

  if (BDH.reduced || !arch) return;

  /* ---- trace runner ---- */
  var pk = BDH.$('.tih-pf__pk', arch);
  var label = BDH.$('.tih-pf__label', arch);
  var ro = label && label.querySelector('b');
  var steps = BDH.$$('.tih-pf__step', root);
  var boxes = {};
  BDH.$$('[data-hop]', arch).forEach(function (b) { boxes[b.getAttribute('data-hop')] = b; });
  if (!pk || !pk.animate || !steps.length) return;

  var plan = [];
  steps.forEach(function (s, si) {
    s.getAttribute('data-hops').split(' ').forEach(function (h) { if (boxes[h]) plan.push({ step: si, hop: h, ro: s.getAttribute('data-ro') }); });
  });

  var at = 0, vis = false, waiting = true, cur = null, timer = null, anim = null;
  function centre(el) {
    var a = arch.getBoundingClientRect(), r = el.getBoundingClientRect();
    return { x: r.left - a.left + r.width / 2, y: r.top - a.top + r.height / 2 };
  }
  function place(p) { var t = 'translate(' + p.x.toFixed(1) + 'px,' + p.y.toFixed(1) + 'px)'; pk.style.transform = t; if (label) label.style.transform = t; }
  function light(si) { steps.forEach(function (s, n) { s.classList.toggle('is-on', n === si); }); }
  function clearHits() { Object.keys(boxes).forEach(function (k) { boxes[k].classList.remove('is-hit'); }); }

  function next() {
    timer = null;
    if (!vis) { waiting = true; return; }
    if (at >= plan.length) {
      root.classList.remove('is-tracing'); light(-1); clearHits(); cur = null; at = 0;
      timer = setTimeout(next, 1800);
      return;
    }
    var hop = plan[at], el = boxes[hop.hop], to = centre(el);
    root.classList.add('is-tracing');
    light(hop.step);
    if (ro) ro.textContent = hop.ro;
    if (!cur) { place(to); arrive(); return; }
    var from = cur;
    anim = pk.animate([
      { transform: 'translate(' + from.x + 'px,' + from.y + 'px)' },
      { transform: 'translate(' + to.x + 'px,' + to.y + 'px)' }
    ], { duration: 620, easing: 'cubic-bezier(.65,0,.35,1)' });
    if (label) label.animate([
      { transform: 'translate(' + from.x + 'px,' + from.y + 'px)' },
      { transform: 'translate(' + to.x + 'px,' + to.y + 'px)' }
    ], { duration: 620, easing: 'cubic-bezier(.65,0,.35,1)' });
    place(to);
    anim.onfinish = arrive;
    function arrive() {
      clearHits(); el.classList.add('is-hit'); cur = to; at++;
      timer = setTimeout(next, plan[at] && plan[at].step !== hop.step ? 1100 : 380);
    }
  }
  BDH.watch(arch, function (on) {
    vis = on;
    if (on && waiting) { waiting = false; cur = null; if (!timer) timer = setTimeout(next, 900); }
  }, { threshold: 0.3 });
  window.addEventListener('resize', function () { cur = null; }, { passive: true });
})();
