/* 20 — booking widget. Enhances the server-rendered calendar in 20-booking.php (which works
   on its own without JavaScript: days, month arrows and times are plain links there).
   Here: the grid re-renders in the visitor's own time zone as an ARIA grid with one roving tab
   stop (arrows, Home/End, PageUp/PageDown between six-week windows); the "next open days" shortcuts
   and the times become buttons, with a 12h/24h toggle; the
   form still POSTs to the contact page, with the chosen slot written at the top of the message.
   HOOK 1: AVAILABLE(date)   which days can be offered  — keep in step with 20-booking.php
   HOOK 2: SLOTS(date)       which times can be offered — keep in step with 20-booking.php
   Nothing here reserves anything; the UI never says a booking is confirmed. */
(function () {
  'use strict';
  var root = document.querySelector('[data-s20]');
  if (!root || !window.XE) return;

  var monthEl = XE.$('[data-s20-month]', root);
  var gridEl = XE.$('[data-s20-grid]', root);
  var daysEl = XE.$('[data-s20-days]', root);
  var timesEl = XE.$('[data-s20-times]', root);
  var dayLabel = XE.$('[data-s20-daylabel]', root);
  var form = XE.$('[data-s20-form]', root);
  var brief = XE.$('[data-s20-brief]', root);
  var errEl = XE.$('[data-s20-err]', root);
  var live = XE.$('[data-s20-live]', root);
  var prevM = XE.$('[data-s20-prevm]', root);
  var nextM = XE.$('[data-s20-nextm]', root);
  var backEl = XE.$('[data-s20-back]', root);
  var fmtG = XE.$('[data-s20-fmtg]', root);
  var endEl = XE.$('[data-s20-end]', root);

  var today = new Date(); today.setHours(0, 0, 0, 0);
  var selected = null, picked = null, h24 = false, focusDate = null;
  var tzName = '';

  /* with JS the times are the visitor's own; the no-JS label names the studios' zone instead */
  try { tzName = (Intl.DateTimeFormat().resolvedOptions().timeZone || '').replace(/_/g, ' '); } catch (e) {}
  XE.$('[data-s20-tz]', root).textContent = 'Your local time' + (tzName ? ' (' + tzName + ')' : '');

  /* HOOK 1 — weekdays, from two days out, inside the next twelve weeks */
  function AVAILABLE(d) {
    var day = d.getDay();
    if (day === 0 || day === 6) return false;
    var diff = Math.round((d - today) / 86400000);
    return diff >= 2 && diff <= 84;
  }
  /* HOOK 2 — 09:00–17:30, half-hourly, no 13:00 hour */
  function SLOTS() {
    var out = [];
    for (var m = 9 * 60; m <= 17 * 60 + 30; m += 30) {
      if (m >= 13 * 60 && m < 14 * 60) continue;
      out.push(m);
    }
    return out;
  }

  function addDays(d, n) { return new Date(d.getFullYear(), d.getMonth(), d.getDate() + n); }
  function ymd(d) { return d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2); }
  function parseYmd(s) {
    var m = /^(\d{4})-(\d{2})(?:-(\d{2}))?$/.exec(s || '');
    return m ? new Date(+m[1], +m[2] - 1, m[3] ? +m[3] : 1) : null;
  }
  /* the rolling six-week windows, as in 20-booking.php: window 0 starts on this week's Monday, each
     later one six weeks on; the last stops after the week holding the last bookable day */
  var mon0 = addDays(today, -((today.getDay() + 6) % 7));
  var lastDay = addDays(today, 84);
  while (!AVAILABLE(lastDay)) lastDay = addDays(lastDay, -1);
  function dayDiff(a, b) { return Math.round((b - a) / 86400000); }
  var wMax = Math.floor(dayDiff(mon0, lastDay) / 42);
  function wStart(k) { return addDays(mon0, 42 * k); }
  function wIdx(d) { return Math.max(0, Math.min(wMax, Math.floor(dayDiff(mon0, d) / 42))); }
  function gridDays(k) {
    var s = wStart(k), out = [];
    for (var i = 0; i < 42; i++) {
      var d = addDays(s, i);
      if (k === wMax && i % 7 === 0 && d > lastDay) break;
      out.push(d);
    }
    return out;
  }
  function openCount(k) { return gridDays(k).filter(AVAILABLE).length; }

  /* three-letter months, as PHP's 'M' writes them ("Sep", not en-GB's "Sept") */
  var MON = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  function fmtShort(d) { return MON[d.getMonth()]; }
  function fmtDM(d) { return d.getDate() + ' ' + fmtShort(d); }
  function fmtRange(days) {
    var a = days[0], b = days[days.length - 1];
    return fmtDM(a) + (a.getFullYear() === b.getFullYear() ? '' : ' ' + a.getFullYear()) + ' – ' + fmtDM(b) + ' ' + b.getFullYear();
  }
  function fmtDay(d) { return d.toLocaleDateString('en-GB', { weekday: 'long', day: 'numeric', month: 'long' }); }
  function fmtTime(mins) {
    var h = Math.floor(mins / 60), m = mins % 60;
    if (h24) return ('0' + h).slice(-2) + ':' + ('0' + m).slice(-2);
    return (h % 12 || 12) + ':' + ('0' + m).slice(-2) + (h < 12 ? 'am' : 'pm');
  }
  function sameDay(a, b) { return !!a && !!b && +a === +b; }

  /* ---- starting state: honour what the server rendered (a shared ?s20d= / ?s20w= link) ---- */
  var srvSel = parseYmd(root.getAttribute('data-s20-sel'));
  if (srvSel && AVAILABLE(srvSel)) selected = srvSel;
  var view = 0;   /* the window index */
  if (selected) view = wIdx(selected);
  else {
    var srvView = parseYmd(root.getAttribute('data-s20-view'));
    if (srvView) view = wIdx(srvView);
  }
  var srvPick = root.getAttribute('data-s20-pick');
  if (selected && srvPick !== '' && SLOTS(selected).indexOf(+srvPick) > -1) {
    picked = { date: new Date(selected), mins: +srvPick };
  }

  /* the no-JS slot line is written into the textarea; JS adds it on submit instead */
  if (/^Requested discovery call: /.test(brief.value)) brief.value = brief.value.replace(/^Requested discovery call: [^\n]*\n*/, '');

  /* the links become controls */
  gridEl.setAttribute('role', 'grid');
  fmtG.hidden = false;

  function setNav(a, target) {
    if (target) {
      a.setAttribute('href', '?s20w=' + target.k + '#book');
      a.removeAttribute('aria-disabled');
    } else {
      a.removeAttribute('href');
      a.setAttribute('aria-disabled', 'true');
    }
    a.setAttribute('role', 'button');
    a.tabIndex = target ? 0 : -1;
  }

  function renderMonth(focusIt) {
    var days = gridDays(view);
    monthEl.textContent = fmtRange(days);
    if (endEl) endEl.hidden = days.length === 42;   /* the last window is short: say why */
    setNav(prevM, view > 0 ? { k: view - 1 } : null);
    setNav(nextM, view < wMax ? { k: view + 1 } : null);

    /* the single tab stop: the focused day, else the selected one, else today/first open day in view */
    var inView = function (d) { return d && days.some(function (x) { return sameDay(x, d) && AVAILABLE(x); }); };
    var stop = inView(focusDate) ? focusDate : inView(selected) ? selected : (days.filter(AVAILABLE)[0] || null);
    focusDate = stop;

    daysEl.innerHTML = '';
    var tr;
    days.forEach(function (d, i) {
      if (i % 7 === 0) {
        tr = document.createElement('tr');
        /* a week with nothing bookable is drawn short */
        if (!days.slice(i, i + 7).some(AVAILABLE)) tr.className = 'is-quiet';
        daysEl.appendChild(tr);
      }
      var td = document.createElement('td');
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 's20__d';
      if (d.getDate() === 1) {
        /* the 1st carries its month, so the rolling grid shows where months turn */
        var mo = document.createElement('span');
        mo.className = 's20__mo'; mo.setAttribute('aria-hidden', 'true'); mo.textContent = fmtShort(d);
        b.appendChild(mo);
      }
      b.appendChild(document.createTextNode(String(d.getDate())));
      b.setAttribute('data-iso', ymd(d));
      var lab = fmtDay(d) + (sameDay(d, today) ? ', today' : '');
      if (sameDay(d, today)) b.classList.add('is-today');
      if (!AVAILABLE(d)) {
        b.disabled = true;
        b.classList.add('is-off');
        b.setAttribute('aria-label', lab + ', unavailable');
      } else {
        b.setAttribute('aria-label', lab);
      }
      var isSel = sameDay(d, selected);
      td.setAttribute('aria-selected', String(isSel));
      if (isSel) b.classList.add('is-sel');
      b.tabIndex = sameDay(d, stop) ? 0 : -1;
      td.appendChild(b);
      tr.appendChild(td);
    });
    if (focusIt && stop) {
      var fb = XE.$('[data-iso="' + ymd(stop) + '"]', daysEl);
      if (fb) fb.focus();
    }
  }

  function renderTimes() {
    form.hidden = true; timesEl.hidden = false; errEl.hidden = true;
    timesEl.innerHTML = '';
    if (!selected) {
      dayLabel.textContent = 'Pick a day';
      var p = document.createElement('p');
      p.className = 's20__empty';
      p.textContent = 'Choose a day to see open times.';
      timesEl.appendChild(p);
      /* the next few open days as shortcuts, so the column is never an empty panel */
      var sl = document.createElement('p');
      sl.className = 's20__soonl'; sl.id = 's20-soon'; sl.textContent = 'Next open days';
      timesEl.appendChild(sl);
      var su = document.createElement('ul');
      su.className = 's20__soon'; su.setAttribute('aria-labelledby', 's20-soon');
      for (var d = new Date(today), n = 0; n < 4 && d <= lastDay; d = addDays(d, 1)) {
        if (!AVAILABLE(d)) continue;
        n++;
        var li = document.createElement('li');
        var qb = document.createElement('button');
        qb.type = 'button'; qb.className = 's20__qd';
        qb.setAttribute('data-iso', ymd(d));
        qb.setAttribute('aria-label', fmtDay(d) + ' — choose this day');
        var wd = document.createElement('span');
        wd.textContent = d.toLocaleDateString('en-GB', { weekday: 'short' });
        qb.appendChild(wd);
        qb.appendChild(document.createTextNode(' ' + fmtDM(d)));
        li.appendChild(qb); su.appendChild(li);
      }
      timesEl.appendChild(su);
      return;
    }
    dayLabel.textContent = fmtDay(selected);
    var ul = document.createElement('ul');
    ul.className = 's20__tlist';
    ul.setAttribute('aria-label', 'Open times, ' + fmtDay(selected));
    SLOTS(selected).forEach(function (mins) {
      var li = document.createElement('li');
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 's20__time';
      b.textContent = fmtTime(mins);
      b.setAttribute('data-mins', String(mins));
      li.appendChild(b);
      ul.appendChild(li);
    });
    timesEl.appendChild(ul);
  }

  function showForm(focusIt) {
    timesEl.hidden = true; form.hidden = false;
    dayLabel.textContent = fmtDay(picked.date);
    /* no-break before the dot, so a wrap never starts a line with it */
    XE.$('[data-s20-picked]', root).textContent = fmtDay(picked.date) + ' · ' + fmtTime(picked.mins);
    if (focusIt) {
      var first = XE.$('[data-book-first]', form);
      if (first) first.focus({ preventScroll: true });
    }
  }

  function choose(d) {
    selected = d; focusDate = d; picked = null; view = wIdx(d);
    renderMonth(true); renderTimes();
    live.textContent = fmtDay(selected) + ' selected. ' + SLOTS(selected).length + ' open times.';
  }

  XE.on(daysEl, 'click', function (e) {
    var b = e.target.closest('.s20__d');
    if (!b || b.disabled) return;
    choose(parseYmd(b.getAttribute('data-iso')));
  });

  XE.on(daysEl, 'keydown', function (e) {
    var b = e.target.closest('.s20__d');
    if (!b) return;
    var cur = parseYmd(b.getAttribute('data-iso'));
    var col = (cur.getDay() + 6) % 7;
    var step = { ArrowRight: 1, ArrowLeft: -1, ArrowDown: 7, ArrowUp: -7 }[e.key];
    var target = null;
    if (step) {
      /* move by the step, skipping unavailable days, stopping at the bookable range */
      var t = addDays(cur, step), guard = 0;
      while (!AVAILABLE(t) && guard++ < 90) t = addDays(t, step > 0 ? 1 : -1);
      target = AVAILABLE(t) ? t : null;
    } else if (e.key === 'Home' || e.key === 'End') {
      var row = addDays(cur, e.key === 'Home' ? -col : 6 - col), dir = e.key === 'Home' ? 1 : -1;
      for (var k = 0; k < 7 && !AVAILABLE(row); k++) row = addDays(row, dir);
      target = AVAILABLE(row) ? row : null;
    } else if (e.key === 'PageDown' || e.key === 'PageUp') {
      var nv = view + (e.key === 'PageDown' ? 1 : -1);
      if (nv < 0 || nv > wMax) { e.preventDefault(); return; }
      view = nv; focusDate = null;
      e.preventDefault();
      renderMonth(true);
      return;
    } else return;
    e.preventDefault();
    if (!target) return;
    focusDate = target;
    var inGrid = gridDays(view).some(function (x) { return sameDay(x, target); });
    if (!inGrid) view = wIdx(target);
    renderMonth(true);
  });

  XE.on(timesEl, 'click', function (e) {
    var q = e.target.closest('.s20__qd');
    if (q) { e.preventDefault(); choose(parseYmd(q.getAttribute('data-iso'))); return; }
    var b = e.target.closest('.s20__time');
    if (!b) return;
    e.preventDefault();
    picked = { date: new Date(selected), mins: +b.getAttribute('data-mins') };
    showForm(true);
    live.textContent = 'Time selected: ' + fmtTime(picked.mins) + '. Complete the form to send your request.';
  });

  /* 12h / 24h: a radio group — arrows move and select, one tab stop */
  var fmtBtns = XE.$$('[data-s20-fmt]', root);
  function setFmt(b, focusIt) {
    h24 = b.getAttribute('data-s20-fmt') === '24';
    fmtBtns.forEach(function (o) {
      var on = o === b;
      o.classList.toggle('is-on', on);
      o.setAttribute('aria-checked', String(on));
      o.tabIndex = on ? 0 : -1;
    });
    if (focusIt) b.focus();
    if (!form.hidden && picked) showForm(false); else renderTimes();
  }
  fmtBtns.forEach(function (b, i) {
    XE.on(b, 'click', function () { setFmt(b, false); });
    XE.on(b, 'keydown', function (e) {
      if (['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].indexOf(e.key) < 0) return;
      e.preventDefault();
      setFmt(fmtBtns[(i + 1) % fmtBtns.length], true);
    });
  });

  function monthNav(a, dir) {
    XE.on(a, 'click', function (e) {
      e.preventDefault();
      if (a.getAttribute('aria-disabled') === 'true') return;
      view = Math.max(0, Math.min(wMax, view + dir));
      focusDate = null;
      renderMonth(false);
      live.textContent = monthEl.textContent + ', ' + openCount(view) + ' days open.';
    });
    XE.on(a, 'keydown', function (e) {
      if (e.key === ' ') { e.preventDefault(); a.click(); }
    });
  }
  monthNav(prevM, -1);
  monthNav(nextM, 1);

  XE.on(backEl, 'click', function (e) {
    e.preventDefault();
    picked = null;
    renderTimes();
    var first = XE.$('.s20__time', timesEl);
    if (first) first.focus({ preventScroll: true });
  });

  XE.on(form, 'submit', function (e) {
    var f = new FormData(form);
    var name = (f.get('name') || '').toString().trim();
    var email = (f.get('email') || '').toString().trim();
    var text = brief.value.trim();

    var problems = [];
    if (name.length < 2) problems.push('your name');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email)) problems.push('a valid work email');
    if (!text) problems.push('a line about what you are building');
    if (problems.length || !picked) {
      e.preventDefault();
      errEl.hidden = false;
      errEl.textContent = picked ? 'Please add ' + problems.join(', ') + '.' : 'Choose a day and a time first.';
      return;
    }
    errEl.hidden = true;

    /* the slot goes at the top of the contact form's own message field */
    var when = fmtDay(picked.date) + ' at ' + fmtTime(picked.mins) + (tzName ? ' (' + tzName + ')' : ' (my local time)');
    var hid = XE.$('[data-s20-msg]', form);
    if (!hid) {
      hid = document.createElement('input');
      hid.type = 'hidden'; hid.name = 'message'; hid.setAttribute('data-s20-msg', '');
      form.appendChild(hid);
    }
    hid.value = 'Requested discovery call: ' + when + '\n\n' + text;
    brief.removeAttribute('name');   /* one message field reaches the contact page */
    live.textContent = 'Sending your request to the contact page. Nothing is reserved yet.';
  });

  /* coming back from the contact page (back/forward cache): restore the textarea's name */
  window.addEventListener('pageshow', function () {
    brief.setAttribute('name', 'message');
    var hid = XE.$('[data-s20-msg]', form);
    if (hid) hid.parentNode.removeChild(hid);
  });

  renderMonth(false);
  if (picked) showForm(false); else renderTimes();
})();
