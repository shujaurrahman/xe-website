/* Careers · apply — enhancement only.
   The form is a plain multipart POST with server-side validation in
   partials/careers/apply-handler.php and works completely without this file: every field is in the
   shipped HTML, the rail is seven ordinary in-page links, and nothing is hidden by a class only
   this script can add. What it adds:
     • focus on the error or failure message so a keyboard user lands on it
     • live character counts on the two questions, with the 60-character minimum shown as it is met
     • the chosen CV read back by name and size, checked against the same limit the server uses
     • the progress rail: which of the seven parts you are in, and which ones you have answered
     • the "read the full listing" link following the role select
     • the same checks the server repeats, run before the round trip, and no double submits */
(function () {
  'use strict';

  var form = document.querySelector('[data-apl-form]');
  var focusEl = document.querySelector('[data-apl-focus]');
  if (focusEl) { try { focusEl.focus(); } catch (e) {} }
  if (!form) return;

  var $ = function (s, r) { return (r || form).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || form).querySelectorAll(s)); };

  function size(b) {
    if (b >= 1048576) {
      var mb = b / 1048576;
      return (mb < 10 ? mb.toFixed(1).replace(/\.0$/, '') : Math.round(mb)) + ' MB';
    }
    return Math.max(1, Math.round(b / 1024)) + ' KB';
  }
  function val(name) { var el = fieldOf(name); return el ? el.value.trim() : ''; }

  /* ---- errors ---------------------------------------------------------- */
  function fieldOf(name) { return form.querySelector('[name="' + name + '"]'); }
  function setErr(key, el, text) {
    var id = 'apl-e-' + key;
    var p = document.getElementById(id);
    if (!p) {
      p = document.createElement('p');
      p.className = 'apl-err';
      p.id = id;
      var wrap = el.closest('.apl-field');
      if (!wrap) return;
      wrap.appendChild(p);
      wrap.classList.add('is-bad');
    }
    p.textContent = text;
    el.setAttribute('aria-invalid', 'true');
    var d = (el.getAttribute('aria-describedby') || '').split(/\s+/).filter(Boolean);
    if (d.indexOf(id) === -1) d.push(id);
    el.setAttribute('aria-describedby', d.join(' '));
  }
  function clearErr(key) {
    var p = document.getElementById('apl-e-' + key);
    if (p && p.parentNode) p.parentNode.removeChild(p);
    var el = fieldOf(key);
    if (!el) return;
    el.removeAttribute('aria-invalid');
    var d = (el.getAttribute('aria-describedby') || '').split(/\s+/).filter(function (x) { return x !== 'apl-e-' + key; });
    if (d.length) el.setAttribute('aria-describedby', d.join(' ')); else el.removeAttribute('aria-describedby');
    var wrap = el.closest('.apl-field');
    if (wrap) wrap.classList.remove('is-bad');
  }
  ['name', 'email', 'phone', 'location', 'auth', 'role', 'role2', 'portfolio', 'linkedin', 'profile',
   'years', 'notice', 'start', 'comp', 'title_now', 'company_now'].forEach(function (k) {
    var el = fieldOf(k);
    if (!el) return;
    el.addEventListener(el.tagName === 'SELECT' ? 'change' : 'input', function () {
      if (el.getAttribute('aria-invalid') === 'true') clearErr(k);
    });
  });

  /* ---- the two question counters --------------------------------------- */
  $$('[data-apl-why]').forEach(function (ta) {
    var wrap = ta.closest('.apl-field');
    var count = wrap ? wrap.querySelector('[data-apl-count]') : null;
    if (!count) return;
    var key = ta.name;
    var max = parseInt(ta.getAttribute('maxlength') || '2000', 10);
    var min = parseInt(ta.getAttribute('data-min') || '60', 10);
    var rest = count.textContent;
    function upd() {
      var n = ta.value.trim().length;
      if (n === 0) { count.textContent = rest; count.removeAttribute('data-s'); return; }
      if (n < min) { count.textContent = (min - n) + ' more characters needed'; count.setAttribute('data-s', 'low'); return; }
      count.removeAttribute('data-s');
      count.textContent = (max - ta.value.length).toLocaleString('en-GB') + ' characters left';
      if (ta.getAttribute('aria-invalid') === 'true') clearErr(key);
    }
    ta.addEventListener('input', function () { upd(); mark(); });
    upd();
  });

  /* ---- the CV field ----------------------------------------------------- */
  var cv = $('[data-apl-cv]');
  var cvName = $('[data-apl-cvname]');
  var cvWrap = cv ? cv.closest('.apl-field') : null;
  var OK = ['pdf', 'doc', 'docx'];
  if (cv && cvName && cvWrap) {
    var cvRest = cvName.textContent;
    cv.addEventListener('change', function () {
      clearErr('cv');
      var f = cv.files && cv.files[0];
      function reject(msg) {
        cvWrap.classList.remove('is-on');
        cvName.textContent = cvRest;
        cv.value = '';
        setErr('cv', cv, msg);
        mark();
      }
      if (!f) { cvWrap.classList.remove('is-on'); cvName.textContent = cvRest; mark(); return; }
      var maxB = parseInt(cv.getAttribute('data-max') || '0', 10);
      var ext = (f.name.split('.').pop() || '').toLowerCase();
      if (OK.indexOf(ext) === -1) return reject('PDF, DOC or DOCX only. A PDF travels best.');
      if (f.size === 0) return reject('That file is empty. Check it opens on your side and attach it again.');
      if (maxB > 0 && f.size > maxB) {
        return reject('That file is ' + size(f.size) + '. The limit is ' + size(maxB) + '. Export a smaller PDF and attach it again.');
      }
      cvWrap.classList.add('is-on');
      cvName.textContent = f.name + ' · ' + size(f.size) + ' · will be attached';
      mark();
    });
  }

  /* ---- the role select keeps its listing link in step -------------------- */
  var role = $('[data-apl-role]');
  var hint = $('[data-apl-rolehint]');
  var link = $('[data-apl-rolelink]');
  var base = form.getAttribute('data-careers') || '';
  if (role && hint && link) {
    role.addEventListener('change', function () {
      var v = role.value;
      hint.hidden = !v;
      if (v) link.setAttribute('href', base + '?role=' + encodeURIComponent(v) + '#role-' + v);
    });
  }

  /* ---- the progress rail ------------------------------------------------ */
  /* A part counts as answered when the fields it actually requires are filled. Parts 02 and 07 ask
     for nothing, so they are marked once you have changed something inside them — which is the
     honest thing to say about a part whose right answer may well be "leave it alone". */
  var parts = $$('[data-apl-part]');
  var rail = document.querySelector('[data-apl-rail]');
  var links = {};
  if (rail) {
    $$('[data-apl-jump]', rail).forEach(function (a) { links[a.getAttribute('data-apl-jump')] = a; });
  }
  var touched = {};
  parts.forEach(function (set) {
    var id = set.getAttribute('data-apl-part');
    set.addEventListener('change', function () { touched[id] = true; mark(); });
  });

  function anyLink() { return !!(val('portfolio') || val('linkedin') || val('profile')); }
  function longEnough(name) {
    var el = fieldOf(name);
    if (!el) return false;
    return el.value.trim().length >= parseInt(el.getAttribute('data-min') || '60', 10);
  }
  function done(id) {
    switch (id) {
      case 's1': return !!(val('name') && val('email') && val('phone') && val('location') && val('auth'));
      case 's2': return !!touched.s2 || !!val('role');
      case 's3': return anyLink();
      case 's4': return !!(cv && cv.files && cv.files.length);
      case 's5': return !!(val('years') && val('notice'));
      case 's6': return longEnough('why') && longEnough('proud');
      case 's7': return !!touched.s7;
      default:   return false;
    }
  }
  function mark() {
    Object.keys(links).forEach(function (id) {
      links[id].classList.toggle('is-done', done(id));
    });
  }
  $$('input, select, textarea').forEach(function (el) {
    el.addEventListener('input', mark);
    el.addEventListener('change', mark);
  });
  mark();

  if (window.BDH && parts.length && rail) {
    BDH.spy(parts, function (set) {
      var id = set.getAttribute('data-apl-part');
      Object.keys(links).forEach(function (k) {
        var on = k === id;
        links[k].classList.toggle('is-on', on);
        if (on) links[k].setAttribute('aria-current', 'true');
        else links[k].removeAttribute('aria-current');
      });
    }, '-30% 0px -55% 0px');
  }

  /* ---- before sending ---------------------------------------------------- */
  var sending = false;
  form.addEventListener('submit', function (e) {
    if (sending) { e.preventDefault(); return; }
    var bad = [];
    function check(name, ok, msg) {
      var el = fieldOf(name);
      if (!el) return;
      if (ok) { clearErr(name); return; }
      setErr(name, el, msg);
      bad.push(el);
    }

    check('name', val('name').length >= 2, 'Enter your name.');
    check('email', /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val('email')), 'Enter an email address we can reply to, like name@example.com.');
    check('phone', /^[0-9+().\s-]{6,40}$/.test(val('phone')), 'Enter a phone number, including the country code.');
    check('location', val('location').length >= 2, 'Tell us which city you are in.');
    check('auth', !!val('auth'), 'Choose the line that describes your right to work in India.');

    if (val('role2') && val('role2') === val('role')) {
      check('role2', false, 'Your second choice is the same as your first. Pick a different one, or leave it empty.');
    } else if (val('role2') && !val('role')) {
      check('role2', false, 'Choose a first role above before adding a second choice.');
    } else {
      clearErr('role2');
    }

    var web = /^(https?:\/\/)?[^\s.]+\.[^\s]{2,}$/;
    ['portfolio', 'linkedin', 'profile'].forEach(function (k) {
      if (!val(k)) { clearErr(k); return; }
      check(k, web.test(val(k)), 'That does not look like a web address. Something like yourname.com.');
    });
    if (!anyLink()) {
      check('portfolio', false, 'Add at least one link — a portfolio, your LinkedIn, or a repository or profile.');
    }

    check('cv', !!(cv && cv.files && cv.files.length), 'Attach your CV as a PDF, DOC or DOCX. It is the one file we ask for.');
    check('years', !!val('years'), 'Choose how long you have been doing this work.');
    check('notice', !!val('notice'), 'Choose how soon you could start.');
    check('why', longEnough('why'), 'A few sentences, please — at least 60 characters.');
    check('proud', longEnough('proud'), 'Tell us about one piece of work and what your own part in it was — at least 60 characters.');

    if (bad.length) {
      e.preventDefault();
      try { bad[0].focus(); } catch (err) {}
      return;
    }
    sending = true;
    var btn = $('[data-apl-send]');
    if (btn) { btn.setAttribute('aria-busy', 'true'); if (btn.firstChild) btn.firstChild.nodeValue = 'Sending… '; }
  });
})();
