/* 20 — booking widget.
   HOOK 1: AVAILABLE(date)    — which days can be offered
   HOOK 2: SLOTS(date)        — which times can be offered
   HOOK 3: send(payload)      — currently composes a mailto; swap for a real endpoint.
   Nothing here reserves anything; the UI never says a booking is confirmed. */
(function () {
  'use strict';
  var root = document.querySelector('[data-s20]');
  if (!root || !window.XE) return;

  var EMAIL = 'hello@xterraedze.com';
  var monthEl = XE.$('[data-s20-month]', root);
  var daysEl = XE.$('[data-s20-days]', root);
  var timesEl = XE.$('[data-s20-times]', root);
  var dayLabel = XE.$('[data-s20-daylabel]', root);
  var form = XE.$('[data-s20-form]', root);
  var doneEl = XE.$('[data-s20-done]', root);
  var errEl = XE.$('[data-s20-err]', root);
  var live = XE.$('[data-s20-live]', root);
  var prevM = XE.$('[data-s20-prevm]', root);
  var nextM = XE.$('[data-s20-nextm]', root);

  var today = new Date(); today.setHours(0, 0, 0, 0);
  var view = new Date(today.getFullYear(), today.getMonth(), 1);
  var selected = null, picked = null, h24 = false;

  try {
    var tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    if (tz) XE.$('[data-s20-tz]', root).textContent = tz.replace(/_/g, ' ');
  } catch (e) {}

  /* HOOK 1 — weekdays, from two days out, inside the next twelve weeks */
  function AVAILABLE(d) {
    var day = d.getDay();
    if (day === 0 || day === 6) return false;
    var diff = (d - today) / 86400000;
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

  function fmtMonth(d) {
    return d.toLocaleDateString('en-GB', { month: 'long', year: 'numeric' });
  }
  function fmtDay(d) {
    return d.toLocaleDateString('en-GB', { weekday: 'long', day: 'numeric', month: 'long' });
  }
  function fmtTime(mins) {
    var h = Math.floor(mins / 60), m = mins % 60;
    if (h24) return ('0' + h).slice(-2) + ':' + ('0' + m).slice(-2);
    var ap = h < 12 ? 'am' : 'pm', hh = h % 12 || 12;
    return hh + ':' + ('0' + m).slice(-2) + ap;
  }

  function renderMonth() {
    monthEl.textContent = fmtMonth(view);
    prevM.disabled = view.getFullYear() === today.getFullYear() && view.getMonth() === today.getMonth();
    daysEl.innerHTML = '';

    var first = new Date(view.getFullYear(), view.getMonth(), 1);
    var lead = (first.getDay() + 6) % 7;                    /* week starts Monday */
    var total = new Date(view.getFullYear(), view.getMonth() + 1, 0).getDate();

    for (var i = 0; i < lead; i++) {
      var pad = document.createElement('div');
      pad.className = 's20__cell';
      pad.setAttribute('role', 'gridcell');
      daysEl.appendChild(pad);
    }
    for (var n = 1; n <= total; n++) {
      var d = new Date(view.getFullYear(), view.getMonth(), n);
      var cell = document.createElement('div');
      cell.className = 's20__cell';
      cell.setAttribute('role', 'gridcell');
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 's20__d';
      b.textContent = String(n);
      /* local parts, never toISOString — that shifts the day across timezones */
      b.setAttribute('data-iso', d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate());
      if (+d === +today) b.classList.add('is-today');
      if (!AVAILABLE(d)) { b.disabled = true; b.setAttribute('aria-disabled', 'true'); }
      else b.setAttribute('aria-label', fmtDay(d) + ' — choose this day');
      if (selected && +d === +selected) { b.classList.add('is-sel'); b.setAttribute('aria-current', 'date'); }
      cell.appendChild(b);
      daysEl.appendChild(cell);
    }
  }

  function renderTimes() {
    form.hidden = true; doneEl.hidden = true; timesEl.hidden = false;
    timesEl.innerHTML = '';
    if (!selected) {
      dayLabel.textContent = 'Pick a day';
      var p = document.createElement('p');
      p.className = 's20__empty';
      p.textContent = 'Choose a day on the left to see open times.';
      timesEl.appendChild(p);
      return;
    }
    dayLabel.textContent = fmtDay(selected);
    SLOTS(selected).forEach(function (mins) {
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 's20__time';
      b.textContent = fmtTime(mins);
      b.setAttribute('data-mins', String(mins));
      timesEl.appendChild(b);
    });
  }

  XE.on(daysEl, 'click', function (e) {
    var b = e.target.closest('.s20__d');
    if (!b || b.disabled) return;
    var iso = b.getAttribute('data-iso').split('-');
    selected = new Date(+iso[0], +iso[1] - 1, +iso[2]);
    renderMonth(); renderTimes();
    live.textContent = fmtDay(selected) + ' selected.';
  });

  XE.on(daysEl, 'keydown', function (e) {
    var b = e.target.closest('.s20__d');
    if (!b) return;
    var map = { ArrowRight: 1, ArrowLeft: -1, ArrowDown: 7, ArrowUp: -7 };
    var d = map[e.key];
    if (!d) return;
    e.preventDefault();
    var all = XE.$$('.s20__d', daysEl);
    var idx = all.indexOf(b) + d;
    while (idx >= 0 && idx < all.length && all[idx].disabled) idx += d > 0 ? 1 : -1;
    if (all[idx]) all[idx].focus();
  });

  XE.on(timesEl, 'click', function (e) {
    var b = e.target.closest('.s20__time');
    if (!b) return;
    picked = { date: new Date(selected), mins: +b.getAttribute('data-mins'), label: b.textContent };
    timesEl.hidden = true; doneEl.hidden = true; form.hidden = false;
    XE.$('[data-s20-picked]', root).textContent = fmtDay(picked.date) + ' · ' + picked.label;
    live.textContent = 'Time selected: ' + picked.label + '. Complete the form to send your request.';
    var first = XE.$('[data-book-first]', form);
    if (first) first.focus({ preventScroll: true });
  });

  XE.$$('[data-s20-fmt]', root).forEach(function (b) {
    XE.on(b, 'click', function () {
      h24 = b.getAttribute('data-s20-fmt') === '24';
      XE.$$('[data-s20-fmt]', root).forEach(function (o) {
        var on = o === b;
        o.classList.toggle('is-on', on);
        o.setAttribute('aria-checked', String(on));
      });
      if (!form.hidden) return;
      renderTimes();
    });
  });

  XE.on(prevM, 'click', function () { view.setMonth(view.getMonth() - 1); renderMonth(); });
  XE.on(nextM, 'click', function () { view.setMonth(view.getMonth() + 1); renderMonth(); });
  XE.on(XE.$('[data-s20-back]', root), 'click', function () { renderTimes(); });

  XE.on(form, 'submit', function (e) {
    e.preventDefault();
    var f = new FormData(form);
    var name = (f.get('name') || '').toString().trim();
    var email = (f.get('email') || '').toString().trim();
    var company = (f.get('company') || '').toString().trim();
    var brief = (f.get('brief') || '').toString().trim();

    var problems = [];
    if (!name) problems.push('your name');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email)) problems.push('a valid work email');
    if (!brief) problems.push('a line about what you are building');
    if (problems.length) {
      errEl.hidden = false;
      errEl.textContent = 'Please add ' + problems.join(', ') + '.';
      live.textContent = errEl.textContent;
      return;
    }
    errEl.hidden = true;

    var when = fmtDay(picked.date) + ' at ' + picked.label;
    /* HOOK 3 — replace this mailto with a POST to your booking endpoint */
    var subject = 'Discovery call request — ' + when;
    var body = [
      'Requested slot: ' + when,
      'Name: ' + name,
      'Email: ' + email,
      'Company: ' + (company || '—'),
      '',
      'Brief:',
      brief
    ].join('\n');
    window.location.href = 'mailto:' + EMAIL +
      '?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);

    form.hidden = true; timesEl.hidden = true; doneEl.hidden = false;
    XE.$('[data-s20-donep]', root).textContent =
      'We have opened an email to ' + EMAIL + ' with your brief and ' + when + '.';
    live.textContent = 'Request prepared. Nothing is reserved yet.';
  });

  renderMonth();
  renderTimes();
})();
