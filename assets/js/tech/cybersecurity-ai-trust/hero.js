/* Cybersecurity & AI Trust · hero — the radar sweeps (CSS, under .is-live) and the findings feed
   works like a live console: a new finding pushes in at the top, its asset pings on the radar, then
   the newest open High or Critical finding flips to Contained. The HTML is the finished state;
   under reduced motion nothing moves. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.tsc-hero'); if (!root) return;
  var vis = root.querySelector('.tsc-hero__vis'); if (!vis) return;
  var list = root.querySelector('[data-feed]'); if (!list) return;

  BDH.live(vis, 0.15);
  if (BDH.reduced) return;

  var SEV = { crit: 'Critical', high: 'High', med: 'Medium' };
  var POOL = [   // [severity, finding, asset key, asset, zone]
    ['high', 'Admin panel reachable without MFA',        'admin',  'Admin panel',    'Perimeter'],
    ['crit', 'Public read on a storage bucket',          'bucket', 'Storage bucket', 'Data zone'],
    ['high', 'Retrieved page carried hidden instructions', 'agent', 'Support agent',  'AI zone'],
    ['med',  'Long-lived deploy key in CI',              'ci',     'CI pipeline',    'Application'],
    ['high', 'Vector search ignored the tenant filter',  'vector', 'Vector store',   'Data zone'],
    ['med',  'Password spraying against login',          'sso',    'Login & SSO',    'Perimeter'],
    ['high', 'API returns other users’ orders (BOLA)',   'api',    'Public API',     'Application'],
    ['crit', 'Agent tried a refund outside its scope',   'agent',  'Support agent',  'AI zone']
  ];
  var openEl = root.querySelector('[data-feed-open]'), contEl = root.querySelector('[data-feed-cont]');
  var lastEl = root.querySelector('[data-radar-last]');
  var n = 0, clock = 9 * 60 + 42;

  function hhmm(m) { var h = Math.floor(m / 60) % 24, mm = m % 60; return (h < 10 ? '0' : '') + h + ':' + (mm < 10 ? '0' : '') + mm; }
  function el(tag, cls, text) { var x = document.createElement(tag); if (cls) x.className = cls; if (text != null) x.textContent = text; return x; }
  function blip(key, contained) {
    var b = root.querySelector('.tsc-blip[data-asset="' + key + '"]'); if (!b) return;
    b.classList.toggle('is-contained', !!contained);
    if (!contained) { b.classList.remove('is-hit'); void b.offsetWidth; b.classList.add('is-hit'); }
  }
  function counts() {
    var rows = BDH.$$('.tsc-feed__row', list).slice(0, 5), c = 0;
    rows.forEach(function (r) { if (r.classList.contains('is-contained')) c++; });
    if (openEl) openEl.textContent = String(rows.length - c);
    if (contEl) contEl.textContent = String(c);
  }
  function row(f, t) {
    var li = el('li', 'tsc-feed__row is-new');
    li.setAttribute('data-asset', f[2]); li.setAttribute('data-sev', f[0]);
    var flip = el('span', 'tsc-flip');
    flip.appendChild(el('span', 'tsc-flip__f tsc-sev tsc-sev--' + f[0], SEV[f[0]]));
    flip.appendChild(el('span', 'tsc-flip__b tsc-sev tsc-sev--ok', 'Contained'));
    li.appendChild(flip);
    li.appendChild(el('time', 'tsc-feed__time', t));
    li.appendChild(el('span', 'tsc-feed__t', f[1]));
    var m = el('span', 'tsc-feed__m', f[3] + ' '); m.appendChild(el('i', null, '·')); m.appendChild(document.createTextNode(' ' + f[4]));
    li.appendChild(m);
    return li;
  }

  function push() {
    var f = POOL[n++ % POOL.length];
    clock += 3;
    var li = row(f, hhmm(clock));
    var h = list.firstElementChild ? list.firstElementChild.offsetHeight : 92;
    list.insertBefore(li, list.firstChild);
    /* FLIP: the older rows glide down instead of jumping */
    list.style.transition = 'none';
    list.style.transform = 'translateY(' + (-h) + 'px)';
    void list.offsetWidth;
    list.style.transition = 'transform .7s cubic-bezier(.22,1,.36,1)';
    list.style.transform = '';
    while (list.children.length > 6) list.removeChild(list.lastElementChild);
    blip(f[2], false);
    if (lastEl) lastEl.textContent = 'Last pass ' + hhmm(clock);
    counts();
  }

  function contain() {
    var rows = BDH.$$('.tsc-feed__row', list), pick = null;
    for (var i = 0; i < rows.length && !pick; i++) {
      var r = rows[i], s = r.getAttribute('data-sev');
      if (!r.classList.contains('is-contained') && (s === 'high' || s === 'crit')) pick = r;
    }
    if (!pick) return;
    pick.classList.add('is-contained');
    blip(pick.getAttribute('data-asset'), true);
    counts();
  }

  BDH.inView(vis, function () {
    BDH.seq(vis, [
      [2200, push],
      [1900, contain],
      [1700, function () {}]
    ], { loop: true, stopOnInteract: false });
  }, { threshold: 0.25 });
})();
