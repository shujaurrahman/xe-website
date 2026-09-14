/* 07 — ai design bento: two live details only. The render rule runs while the
   studio card is on screen, and the routed model chip moves on a slow tick.
   The cards themselves are static — no hover lift, no parallax. */
(function () {
  'use strict';
  var sec = document.querySelector('.s07');
  if (!sec || !window.XE) return;

  /* the progress rule is a CSS animation parked at play-state:paused */
  var studio = XE.$('.s07-studio', sec);
  if (studio && !XE.reduced) {
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (es) {
        studio.classList.toggle('is-live', es[0].isIntersecting);
      }, { threshold: 0.2 }).observe(studio);
    } else {
      studio.classList.add('is-live');
    }
  }

  /* one model routed at a time; the elbow line under it goes blue with it */
  var app = XE.$('.s07-app', sec);
  var cols = XE.$$('.s07-app__col', sec);
  if (app && cols.length > 1 && !XE.reduced) {
    var i = 0;
    XE.liveTimer(app, 2600, function () {
      cols[i].classList.remove('is-on');
      i = (i + 1) % cols.length;
      cols[i].classList.add('is-on');
    });
  }

  /* the brand library walks its collections, and the asset rows restack */
  var lib = XE.$('.s07-lib', sec);
  if (lib && !XE.reduced) {
    var cs = XE.$$('.s07-lib__c', lib);
    var rows = XE.$$('.s07-lib__a', lib);
    var k = 0;
    XE.liveTimer(lib, 2400, function () {
      cs[k].classList.remove('is-on');
      k = (k + 1) % cs.length;
      cs[k].classList.add('is-on');
      rows.forEach(function (r, n) {
        r.classList.remove('is-fresh');
        void r.offsetWidth;
        r.style.animationDelay = (n * 70) + 'ms';
        r.classList.add('is-fresh');
      });
    });
  }

  /* the roadmap advances a phase at a time */
  var road = XE.$('.s07-road', sec);
  if (road && !XE.reduced) {
    var steps = XE.$$('.s07-road__step', road);
    var r = 0;
    XE.liveTimer(road, 2800, function () {
      steps[r].classList.remove('is-now');
      r = (r + 1) % steps.length;
      steps[r].classList.add('is-now');
      steps.forEach(function (s2, n) { s2.classList.toggle('is-done', n < r); });
    });
  }
})();
