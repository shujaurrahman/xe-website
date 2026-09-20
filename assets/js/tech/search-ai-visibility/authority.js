/* Search & AI Visibility — 06 · Authority.
   Drives the twelve-month citation-network scrubber and the source-family filter. Both controls
   are real inputs in the markup; this file only reflects their state into the graph, the ledger and
   the three readouts. The page ships at month 12 with every family showing — the complete network —
   so with no JS the section still shows the finished picture.
   Under reduced motion both controls work exactly the same; only the autoplay is skipped. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-tsv-net]');
  if (!root) return;

  var range = root.querySelector('[data-net-range]');
  if (!range) return;

  var edges = BDH.$$('.tsv-net__e', root);
  var nodes = BDH.$$('.tsv-net__n', root);
  var leds  = BDH.$$('.tsv-net__led', root);
  var famBs = BDH.$$('[data-fam-b]', root);
  var outM  = root.querySelector('[data-net-month]');
  var outS  = root.querySelector('[data-net-src]');
  var outSh = root.querySelector('[data-net-share]');
  var outMe = root.querySelector('[data-net-men]');

  var months = [];
  try { months = JSON.parse(root.getAttribute('data-net-months') || '[]'); } catch (e) { months = []; }

  var max = parseInt(range.getAttribute('max') || '12', 10);

  function render(m) {
    edges.forEach(function (el) {
      var born = parseInt(el.getAttribute('data-m') || '0', 10);
      var full = parseInt(el.getAttribute('data-w') || '1', 10);
      var on   = m >= born;
      el.classList.toggle('is-on', on);
      /* the link thickens over the three months after it lands */
      var grown = on ? Math.min(full, 1 + Math.floor((m - born) / 2)) : 1;
      el.style.setProperty('--w', String(grown));
    });

    nodes.forEach(function (el) {
      el.classList.toggle('is-on', m >= parseInt(el.getAttribute('data-m') || '0', 10));
    });

    leds.forEach(function (el) {
      el.classList.toggle('is-on', m >= parseInt(el.getAttribute('data-m') || '0', 10));
    });

    var row = months[m];
    if (outM)  outM.textContent  = row ? row[0] : (m < 10 ? '0' + m : String(m));
    if (outS)  outS.textContent  = row ? String(row[1]) : '';
    if (outSh) outSh.textContent = row ? String(row[2]) : '';
    if (outMe) outMe.textContent = row ? String(row[3]) : '';
  }

  range.addEventListener('input', function () { render(parseInt(range.value, 10) || 0); });

  /* on a narrow screen the graph scrolls sideways; start it on the centre node rather than on the
     empty left margin. Purely an enhancement — with no JS it simply starts at the left edge. */
  var scroller = root.querySelector('.tsv-net__scroll');
  if (scroller) {
    var centreIt = function () {
      var over = scroller.scrollWidth - scroller.clientWidth;
      if (over > 8) { scroller.scrollLeft = Math.round(over / 2); }
    };
    centreIt();
    window.addEventListener('resize', centreIt);
  }

  /* ---------- the family filter: a legend row isolates its own family ---------- */
  var focused = '';
  function focus(fam) {
    focused = focused === fam ? '' : fam;
    if (focused) { root.setAttribute('data-focus', focused); }
    else { root.removeAttribute('data-focus'); }
    famBs.forEach(function (b) {
      b.setAttribute('aria-pressed', b.getAttribute('data-fam-b') === focused ? 'true' : 'false');
    });
  }
  famBs.forEach(function (b) {
    b.addEventListener('click', function () { focus(b.getAttribute('data-fam-b') || ''); });
  });

  if (BDH.reduced) return;

  /* autoplay once, from month 00, while the section is on screen — stopped by any interaction */
  var played = false;
  var timer  = null;

  function stop() {
    if (timer) { timer.stop(); timer = null; }
    range.value = String(max);
    render(max);
  }

  BDH.onInteract(root, stop);

  BDH.watch(root, function (on) {
    if (!on || played) return;
    played = true;
    var m = 0;
    range.value = '0';
    render(0);
    timer = BDH.loop(root, 320, function () {
      m += 1;
      if (m > max) { stop(); return; }
      range.value = String(m);
      render(m);
    });
  }, { threshold: 0.35 });
})();
