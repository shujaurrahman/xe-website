/* Custom Software & Data Platforms · process — the timeline spine fills with the scroll and each stage lights
   (node, week chip) once the fill passes its node; a stage's card settles in as it is reached. The HTML is the
   finished timeline (spine full, every stage lit). Reduced motion: nothing changes. */
(function () {
  'use strict';
  if (!window.BDH || BDH.reduced) return;
  var root = document.querySelector('.tcs-process'); if (!root) return;
  var pr = root.querySelector('.tcs-pr');
  var tlw = root.querySelector('.tcs-pr__tlw');
  var spine = root.querySelector('.tcs-pr__spine');
  var sts = BDH.$$('.tcs-pr__st', root);
  if (!pr || !tlw || !spine || !sts.length) return;

  pr.classList.add('is-js');
  function tick() {
    var vh = window.innerHeight || document.documentElement.clientHeight;
    var s = spine.getBoundingClientRect();
    var line = vh * 0.62;                                  // the reading line
    var p = Math.max(0, Math.min(1, (line - s.top) / Math.max(1, s.height)));
    tlw.style.setProperty('--tcs-pr-p', p.toFixed(4));
    sts.forEach(function (st) {
      var n = st.querySelector('.tcs-pr__node');
      var r = n.getBoundingClientRect();
      var on = r.top + r.height / 2 <= line;
      st.classList.toggle('is-on', on);
      if (on) st.classList.add('is-seen');
    });
  }
  tlw.style.setProperty('--tcs-pr-p', '0');
  sts.forEach(function (st) { st.classList.remove('is-on', 'is-seen'); });
  BDH.progress(tlw, tick);
})();
