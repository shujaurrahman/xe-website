/* Brand Systems · 09 process — run the pipeline: stages and jobs go queued → running → passed. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var run = document.querySelector('[data-cbs-pr]'); if (!run) return;
  var stages = BDH.$$('[data-cbs-pr-stage]', run);
  var state = run.querySelector('[data-cbs-pr-state]');
  var log = run.querySelector('[data-cbs-pr-log]');
  var again = run.querySelector('[data-cbs-pr-again]');
  var finalLog = log.innerHTML, finalState = state.textContent;
  var timer = null;

  function setCls(el, s) { el.classList.remove('is-queued', 'is-running', 'is-passed'); el.classList.add('is-' + s); }
  function stageTo(st, s) {
    setCls(st, s);
    st.querySelector('[data-cbs-pr-pill]').textContent = s;
    if (s !== 'running') BDH.$$('[data-cbs-pr-job]', st).forEach(function (j) { setCls(j, s); j.querySelector('em').textContent = s === 'passed' ? 'passed' : 'queued'; });
  }
  function line(text) {
    var li = document.createElement('li'); li.className = 'is-new';
    li.innerHTML = '<b>' + (text.charAt(0) === '✓' ? '✓' : '›') + '</b>' + text.slice(2);
    log.appendChild(li);
    while (log.children.length > 4) log.removeChild(log.firstChild);
  }

  /* build a flat timeline from the DOM so it always matches the data */
  function steps() {
    var out = [];
    stages.forEach(function (st, si) {
      var name = st.querySelector('.cbs-pr__h').textContent.toLowerCase();
      var jobs = BDH.$$('[data-cbs-pr-job]', st);
      out.push([500, function () { stageTo(st, 'running'); state.textContent = 'Stage ' + (si + 1) + ' of ' + stages.length + ' running · ' + st.querySelector('.cbs-pr__wk').textContent; line('› ' + name + ' · started'); }]);
      jobs.forEach(function (j, ji) {
        out.push([350, function () { setCls(j, 'running'); j.querySelector('em').textContent = 'running'; }]);
        out.push([700, function () {
          setCls(j, 'passed'); j.querySelector('em').textContent = ji === jobs.length - 1 ? 'reviewed' : 'passed';
          line('✓ ' + name + ' · ' + j.querySelector('span').textContent.toLowerCase() + (ji === jobs.length - 1 ? ' reviewed by a person' : ' passed'));
        }]);
      });
      out.push([450, function () { stageTo(st, 'passed'); }]);
    });
    out.push([400, function () { run.classList.remove('is-running'); state.textContent = finalState; line('✓ run · v1.0 tagged by the system owner'); again.disabled = false; }]);
    return out;
  }

  function start() {
    if (timer) timer.stop();
    run.classList.add('is-running');
    again.disabled = true;
    stages.forEach(function (st) { stageTo(st, 'queued'); });
    log.innerHTML = '';
    state.textContent = 'Queued · waiting for kick-off';
    timer = BDH.seq(run, steps(), { loop: false, stopOnInteract: false });
  }
  function finish() {
    if (timer) timer.stop();
    run.classList.remove('is-running');
    stages.forEach(function (st) { stageTo(st, 'passed'); BDH.$$('[data-cbs-pr-job]', st).forEach(function (j, i, a) { j.querySelector('em').textContent = i === a.length - 1 ? 'reviewed' : 'passed'; }); });
    log.innerHTML = finalLog; state.textContent = finalState; again.disabled = false;
  }

  if (BDH.reduced) { again.addEventListener('click', finish); return; }
  again.addEventListener('click', start);
  BDH.inView(run, start, { threshold: 0.25 });
})();
