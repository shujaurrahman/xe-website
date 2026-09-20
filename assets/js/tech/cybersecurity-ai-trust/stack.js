/* Cybersecurity & AI Trust · stack — the coverage board. Every tool card is a toggle: pressed means
   "you already run this". The two estate presets set the whole board at once, and the shelf meters,
   the coverage rail, the running readout and the "where we would start" list recompute from whatever
   is on. Preset flags come from the JSON block PHP renders beside the board.

   PHP already ships the board counted for the Microsoft-centred estate, so nothing here is needed for
   the section to read correctly; this only keeps the numbers true as the visitor changes it. Under
   reduced motion the toggles still work — the transitions are what CSS turns off, not the mechanism. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('[data-sh]'); if (!root) return;

  var src = document.getElementById('stack-presets');
  var presets = {};
  if (src) { try { presets = JSON.parse(src.textContent) || {}; } catch (e) { presets = {}; } }

  var rows    = BDH.$$('[data-sh-row]', root);
  var preBtns = BDH.$$('[data-sh-pre]', root);
  var onEl    = root.querySelector('[data-sh-on]');
  var gapEl   = root.querySelector('[data-sh-gap]');
  var railEl  = root.querySelector('[data-sh-rail]');
  var gapsEl  = root.querySelector('[data-sh-gaps]');
  if (!rows.length) return;

  var shelves = rows.map(function (row) {
    return {
      key:  row.getAttribute('data-sh-row'),
      row:  row,
      name: (row.querySelector('.tsc-sh__t') || {}).textContent || '',
      togs: BDH.$$('[data-sh-t]', row),
      nEl:  row.querySelector('[data-sh-n]'),
      bar:  row.querySelector('[data-sh-bar]')
    };
  });

  function pad(n) { return n < 10 ? '0' + n : String(n); }
  function isOn(b) { return b.getAttribute('aria-pressed') === 'true'; }

  /* The state line is "<i></i>In place": rewrite only its text node so the dot survives. */
  function setTog(b, on) {
    b.setAttribute('aria-pressed', on ? 'true' : 'false');
    var s = b.querySelector('.tsc-sh__state');
    if (!s) return;
    var label = s.lastChild;
    if (label && label.nodeType === 3) label.nodeValue = on ? 'In place' : 'Not covered';
    else s.appendChild(document.createTextNode(on ? 'In place' : 'Not covered'));
  }

  /* Does the board still match a named estate? If not, no preset stays pressed. */
  function matched() {
    for (var k = 0; k < preBtns.length; k++) {
      var key = preBtns[k].getAttribute('data-sh-pre'), ok = true;
      for (var s = 0; s < shelves.length && ok; s++) {
        var flags = presets[shelves[s].key] || [];
        for (var t = 0; t < shelves[s].togs.length; t++) {
          var want = key === 'none' ? false : !!(flags[t] && flags[t][key]);
          if (isOn(shelves[s].togs[t]) !== want) { ok = false; break; }
        }
      }
      if (ok) return key;
    }
    return null;
  }

  function recount() {
    var total = 0, on = 0, thin = [];

    shelves.forEach(function (s) {
      var n = 0;
      s.togs.forEach(function (b) { if (isOn(b)) n++; });
      total += s.togs.length;
      on += n;
      if (s.nEl) s.nEl.textContent = String(n);
      if (s.bar) s.bar.style.setProperty('--w', Math.round(n / Math.max(1, s.togs.length) * 100) + '%');
      s.row.setAttribute('data-sh-empty', n === 0 ? '1' : '0');
      thin.push({ name: s.name, n: n, tot: s.togs.length, r: n / Math.max(1, s.togs.length) });
    });

    if (onEl) onEl.textContent = String(on);
    if (gapEl) gapEl.textContent = String(total - on);
    if (railEl) railEl.style.setProperty('--w', (total ? Math.round(on / total * 100) : 0) + '%');

    /* thinnest cover first; a bigger shelf breaks a tie, because it costs more to leave open */
    thin.sort(function (a, b) { return a.r - b.r || b.tot - a.tot; });
    if (gapsEl) {
      gapsEl.innerHTML = '';
      thin.slice(0, 3).forEach(function (s, i) {
        var li = document.createElement('li');
        var k = document.createElement('span'); k.className = 'tsc-kbd'; k.textContent = pad(i + 1);
        var b = document.createElement('b'); b.textContent = s.name;
        var c = document.createElement('span'); c.textContent = s.n + ' of ' + s.tot + ' in place';
        li.appendChild(k); li.appendChild(b); li.appendChild(c);
        gapsEl.appendChild(li);
      });
    }

    var m = matched();
    preBtns.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-sh-pre') === m ? 'true' : 'false'); });
  }

  preBtns.forEach(function (b) {
    b.addEventListener('click', function () {
      var key = b.getAttribute('data-sh-pre');
      shelves.forEach(function (s) {
        var flags = presets[s.key] || [];
        s.togs.forEach(function (t, i) {
          setTog(t, key === 'none' ? false : !!(flags[i] && flags[i][key]));
        });
      });
      recount();
    });
  });

  shelves.forEach(function (s) {
    s.togs.forEach(function (b) {
      b.addEventListener('click', function () { setTog(b, !isOn(b)); recount(); });
    });
  });

  recount();
})();
