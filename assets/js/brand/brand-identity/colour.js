/* Brand Identity · colour — live WCAG 2.2 contrast for the chosen text/background pair.
   Until the visitor touches the lab, it walks a few instructive pairings (passes and fails).
   Reduced motion: no walk, the checker works as normal. */
(function () {
  'use strict';
  var root = document.querySelector('.cbi-col'); if (!root) return;
  var view = root.querySelector('.cbi-col__view');
  var pair = root.querySelector('.cbi-col__pair');
  var ratioEl = root.querySelector('.cbi-col__ratio b');
  var rules = Array.prototype.slice.call(root.querySelectorAll('.cbi-col__rules li'));
  var swap = root.querySelector('.cbi-col__swap');
  var lab = root.querySelector('.cbi-col__lab');

  function lum(hex) {
    var c = [1, 3, 5].map(function (i) {
      var v = parseInt(hex.substr(i, 2), 16) / 255;
      return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
    });
    return 0.2126 * c[0] + 0.7152 * c[1] + 0.0722 * c[2];
  }
  function ratio(a, b) {
    var l1 = lum(a), l2 = lum(b);
    return (Math.max(l1, l2) + 0.05) / (Math.min(l1, l2) + 0.05);
  }
  function picked(k) { return root.querySelector('input[name="colour-' + k + '"]:checked'); }
  function pick(k, v) {
    var el = root.querySelector('input[name="colour-' + k + '"][value="' + v + '"]');
    if (el) el.checked = true;
  }

  function update() {
    var fg = picked('fg'), bg = picked('bg'); if (!fg || !bg) return;
    var r = ratio(fg.getAttribute('data-hex'), bg.getAttribute('data-hex'));
    var shown = Math.floor(r * 100) / 100;   // never round a fail up into a pass
    view.style.setProperty('--fg', fg.getAttribute('data-hex'));
    view.style.setProperty('--bg', bg.getAttribute('data-hex'));
    pair.textContent = fg.getAttribute('data-name') + ' on ' + bg.getAttribute('data-name');
    ratioEl.textContent = shown.toFixed(2);
    rules.forEach(function (li) {
      var ok = shown >= parseFloat(li.getAttribute('data-min'));
      li.className = ok ? 'is-ok' : 'is-no';
      li.querySelector('b').textContent = ok ? 'Pass' : 'Fail';
    });
  }

  root.addEventListener('change', function (ev) { if (ev.target.classList.contains('cbi-col__in')) update(); });
  if (swap) swap.addEventListener('click', function () {
    var f = picked('fg').value, b = picked('bg').value;
    pick('fg', b); pick('bg', f); update();
  });
  update();

  if (!window.BDH) return;
  BDH.enter(root.querySelector('.cbi-col__bar'));
  if (BDH.reduced) return;
  var demo = [['paper', 'blue'], ['muted', 'paper'], ['line', 'paper'], ['paper', 'ink'], ['blue', 'ink-2'], ['ink', 'paper']];
  var k = 0;
  var run = BDH.loop(lab, 2600, function () { pick('fg', demo[k][0]); pick('bg', demo[k][1]); update(); k = (k + 1) % demo.length; });
  BDH.onInteract(lab, function () { run.stop(); });
})();
