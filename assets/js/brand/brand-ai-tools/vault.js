/* 08 Ownership vault — switch where each part runs; ownership line never changes. Export writes a manifest. */
(function () {
  'use strict';
  var root = document.querySelector('.cat-vt'); if (!root) return;
  var R = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var rows = Array.prototype.slice.call(root.querySelectorAll('.cat-vt__row'));
  var sum = root.querySelector('[data-vt-sum]'), out = root.querySelector('[data-vt-out]'), exp = root.querySelector('[data-vt-export]');
  var TXT = { yours: 'In your cloud account · your keys', managed: 'Run for you · export or delete at any time' };

  function summary() {
    var y = rows.filter(function (r) { return r.getAttribute('data-run') === 'yours'; }).length;
    sum.textContent = y + ' in your cloud · ' + (rows.length - y) + ' managed for you · ' + rows.length + ' of ' + rows.length + ' owned by you';
  }

  rows.forEach(function (r) {
    Array.prototype.forEach.call(r.querySelectorAll('input'), function (inp) {
      inp.addEventListener('change', function () {
        r.setAttribute('data-run', inp.value);
        var st = r.querySelector('[data-vt-state]');
        st.innerHTML = '';
        st.appendChild(document.createTextNode(TXT[inp.value] + ' '));
        var b = document.createElement('b'); b.textContent = 'owned by you'; st.appendChild(b);
        if (!R) { r.classList.remove('is-flip'); void r.offsetWidth; r.classList.add('is-flip'); }
        summary();
      });
    });
  });

  exp.addEventListener('click', function () {
    exp.disabled = true;
    out.hidden = false; out.innerHTML = '';
    var lines = ['$ brandctl export --all --to your-account'];
    rows.forEach(function (r) {
      lines.push(r.querySelector('.cat-vt__ext').textContent + '  ' + r.querySelector('.cat-vt__name').textContent + '  ✓ checksum verified');
    });
    lines.push('export complete · ' + rows.length + ' parts · 0 copies retained by us'); // PLACEHOLDER: illustrative export — confirm before launch
    lines.forEach(function (t, i) {
      setTimeout(function () {
        var li = document.createElement('li'); li.textContent = t;
        if (!R) li.className = 'is-new';
        out.appendChild(li);
        if (i === lines.length - 1) exp.disabled = false;
      }, R ? 0 : i * 260);
    });
  });
})();
