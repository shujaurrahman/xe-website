/* Audits & Assessments · method — the finding walks the evidence chain.
   The HTML ships the finished state: every stage done, every evidence row present. This restarts the
   chain at stage one and steps through it while the section is on screen, moving the TA-03 marker
   along the rail and revealing the evidence each stage produces. Under reduced motion nothing runs
   and the complete record stays on screen. */
(function () {
  'use strict';
  if (!window.BDH) return;

  var root = document.querySelector('[data-taa-method]');
  if (!root) return;

  var chain = root.querySelector('.taa-me__chain');
  var rail = root.querySelector('.taa-me__rail');
  var rider = root.querySelector('[data-taa-rider]');
  var stages = BDH.$$('.taa-me__st', root);
  var rowsEv = BDH.$$('.taa-me__evr', root);
  var stageOut = root.querySelector('[data-taa-stage]');
  if (!stages.length) return;

  var last = stages.length - 1;

  /* The marker centres over the stage dot, which sits at the left edge of each column. */
  function place(n) {
    if (!rider || !chain || !stages[n] || window.innerWidth <= 1100) return;
    var x = stages[n].offsetLeft + 15 - (rider.offsetWidth / 2);
    rider.style.transform = 'translateX(' + Math.max(0, Math.round(x)) + 'px)';
  }

  function show(n) {
    stages.forEach(function (st, i) {
      st.classList.toggle('is-done', i <= n);
      st.classList.toggle('is-on', i === n);
    });
    rowsEv.forEach(function (row) {
      var st = parseInt(row.getAttribute('data-st'), 10);
      row.classList.toggle('is-on', st <= n);
      row.classList.toggle('is-new', st === n);
    });
    if (rail) rail.style.setProperty('--f', last > 0 ? (n / last).toFixed(3) : '1');
    if (stageOut) {
      var head = stages[n].querySelector('.taa-me__sth');
      if (head) stageOut.textContent = head.textContent;
    }
    root.setAttribute('data-step', String(n));
    place(n);
  }

  var at = last;
  window.addEventListener('resize', function () { place(at); });

  if (BDH.reduced) { place(last); return; }

  /* One pass, then it rests on the completed record. Restarting would show the record taking itself
     apart every ten seconds, which reads as a fault rather than a demonstration. */
  BDH.inView(root, function () {
    root.classList.add('is-anim');
    at = 0;
    show(0);
    var walk = BDH.loop(root, 1600, function () {
      if (at >= last) {
        walk.stop();
        show(last);
        rowsEv.forEach(function (row) { row.classList.remove('is-new'); });
        root.classList.remove('is-anim');
        return;
      }
      at += 1;
      show(at);
    });
  }, { threshold: 0.25 });

  place(last);
})();
