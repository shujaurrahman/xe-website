/* Hub · standards — the badge wall is a set of toggle buttons (aria-pressed, one on at a time). Choosing a
   framework swaps the panel, lights the capability pages that apply it and grows the connector spine from the
   badge down to the last lit page. The crosswalk's audit log tails new lines while it is on screen, and each
   new line ticks the next framework clause it satisfies. Reduced motion: selection works instantly, no tail. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tih-std');
  if (!root) return;

  var btns = BDH.$$('.tih-std__b', root);
  var panes = BDH.$$('.tih-std__pane', root);
  var caps = BDH.$$('.tih-std__cap', root);
  var spine = BDH.$('.tih-std__spine', root);
  var tree = BDH.$('.tih-std__tree', root);
  var panel = BDH.$('.tih-std__panel', root);
  var posEl = BDH.$('[data-std-pos]', root);
  var nEl = BDH.$('[data-std-n]', root);
  var dataEl = BDH.$('.tih-std__data', root);
  var MAP = {};
  try { MAP = JSON.parse(dataEl ? dataEl.textContent : '{}'); } catch (err) { MAP = {}; }
  var keys = btns.map(function (b) { return b.getAttribute('data-std'); });
  if (!btns.length) return;

  /* the spine runs from its dot down to the middle of the last lit page */
  function growSpine() {
    if (!spine || !tree) return;
    if (window.getComputedStyle(spine).display === 'none') return;
    var lit = caps.filter(function (c) { return c.classList.contains('is-on'); });
    if (!lit.length) { spine.style.setProperty('--spine', '0px'); return; }
    var t = tree.getBoundingClientRect(), r = lit[lit.length - 1].getBoundingClientRect();
    spine.style.setProperty('--spine', Math.max(0, r.top - t.top + r.height / 2 + 6).toFixed(1) + 'px');
  }

  function select(k, byUser) {
    if (keys.indexOf(k) < 0) return;
    root.setAttribute('data-std', k);
    btns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-std') === k ? 'true' : 'false'); });
    panes.forEach(function (p) { p.classList.toggle('is-on', p.getAttribute('data-pane') === k); });
    var list = MAP[k] || [], o = 0;
    caps.forEach(function (c) {
      var on = list.indexOf(c.getAttribute('data-cap')) > -1;
      c.classList.toggle('is-on', on);
      c.style.setProperty('--o', String(on ? o++ : 0));
    });
    if (posEl) posEl.textContent = String(keys.indexOf(k) + 1);
    if (nEl) nEl.textContent = String(list.length);
    growSpine();
    /* stacked layout: the panel sits above the wall, so bring it into view after a choice far below it */
    if (byUser && panel && window.innerWidth < 1024) {
      var r = panel.getBoundingClientRect();
      if (r.bottom < 80 || r.top > (window.innerHeight || 800)) panel.scrollIntoView({ block: 'start', behavior: BDH.reduced ? 'auto' : 'smooth' });
    }
  }

  btns.forEach(function (b, n) {
    b.addEventListener('click', function () { select(keys[n], true); });
    /* arrows move through the wall in reading order (the buttons stay in the tab order too) */
    b.addEventListener('keydown', function (e) {
      var j = e.key === 'ArrowRight' || e.key === 'ArrowDown' ? n + 1 : e.key === 'ArrowLeft' || e.key === 'ArrowUp' ? n - 1 : -99;
      if (j === -99) return;
      e.preventDefault();
      j = (j + btns.length) % btns.length;
      btns[j].focus();
      select(keys[j], true);
    });
  });
  select(root.getAttribute('data-std') || keys[0], false);
  var rq = false;
  window.addEventListener('resize', function () {
    if (rq) return; rq = true;
    requestAnimationFrame(function () { rq = false; growSpine(); });
  }, { passive: true });
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(growSpine);

  /* ---- crosswalk: the audit log tails while on screen ---- */
  var term = document.querySelector('.tih-std__term');
  var lines = term && term.querySelector('.tih-std__lines');
  var rows = BDH.$$('.tih-std__map li', document.querySelector('.tih-std__cross') || document);
  if (!lines || BDH.reduced) return;

  var FEED = [
    [['actor', 'agent.support'], ['action', 'tool.call'], ['tool', 'refund.check'], ['model', 'route:small'], ['prompt', 'v14'], ['result', 'allow']],
    [['actor', 'svc.bus'], ['action', 'publish'], ['resource', 'order.updated'], ['auth', 'mtls'], ['result', 'allow'], ['trace', 'c41d07']],
    [['actor', 'user.1187'], ['action', 'read'], ['resource', 'cdp.profile/2290'], ['auth', 'sso'], ['result', 'deny'], ['reason', 'scope']],
    [['actor', 'agent.support'], ['action', 'handoff'], ['resource', 'ticket/88412'], ['score', '0.58'], ['result', 'allow'], ['trace', 'e9a211']],
    [['actor', 'eng.oncall'], ['action', 'secret.rotate'], ['resource', 'vault/payments'], ['auth', 'sso+mfa'], ['result', 'allow'], ['trace', '0b77f3']],
    [['actor', 'svc.gateway'], ['action', 'model.route'], ['model', 'route:large'], ['reason', 'complex'], ['result', 'allow'], ['trace', '5d90ac']]
  ];
  var MAX = BDH.$$('li', lines).length || 4;
  var fi = 0, hi = 0, clock = 10 * 3600 + 42 * 60 + 9;
  function pad(n, w) { n = String(n); while (n.length < (w || 2)) n = '0' + n; return n; }
  function stamp() {
    clock += 1 + Math.floor(Math.random() * 2);
    return pad(Math.floor(clock / 3600) % 24) + ':' + pad(Math.floor(clock / 60) % 60) + ':' + pad(clock % 60) + '.' + pad(Math.floor(Math.random() * 1000), 3) + 'Z';
  }
  function field(kv) {
    var s = document.createElement('span');
    s.className = 'tih-std__f' + (kv[1] === 'deny' ? ' is-deny' : kv[1] === 'allow' ? ' is-allow' : '');
    var i = document.createElement('i');
    i.textContent = kv[0] + '=';
    s.appendChild(i);
    s.appendChild(document.createTextNode(kv[1]));
    return s;
  }
  BDH.loop(term, 2600, function () {
    var li = document.createElement('li');
    li.className = 'is-new';
    var ts = document.createElement('span');
    ts.className = 'tih-std__ts';
    ts.textContent = stamp();
    li.appendChild(ts);
    FEED[fi % FEED.length].forEach(function (kv) { li.appendChild(field(kv)); });
    fi++;
    lines.appendChild(li);
    while (lines.children.length > MAX) lines.removeChild(lines.firstElementChild);
    if (rows.length) {
      rows.forEach(function (r) { r.classList.remove('is-hit'); });
      rows[hi % rows.length].classList.add('is-hit');
      hi++;
    }
  });
})();
