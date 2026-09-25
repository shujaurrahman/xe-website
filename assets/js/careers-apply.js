/* Careers · apply — enhancement only. The form is a plain multipart POST with server-side
   validation in partials/careers/apply-handler.php and works completely without this file. Here:
   • focus on the error or failure message so a keyboard user lands on it
   • a live character count on the note, and the 60-character minimum shown as it is met
   • the chosen CV's name and size read back, checked against the same limit the server uses
   • the "read the full listing" link following the role select
   • the same light pre-send checks the server repeats, and no double submits */
(function () {
  'use strict';

  var form = document.querySelector('[data-apl-form]');
  var focusEl = document.querySelector('[data-apl-focus]');
  if (focusEl) { try { focusEl.focus(); } catch (e) {} }
  if (!form) return;

  var $ = function (s, r) { return (r || form).querySelector(s); };

  function size(b) {
    if (b >= 1048576) {
      var mb = b / 1048576;
      return (mb < 10 ? mb.toFixed(1).replace(/\.0$/, '') : Math.round(mb)) + ' MB';
    }
    return Math.max(1, Math.round(b / 1024)) + ' KB';
  }

  /* ---- errors ---- */
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
    var el = fieldOf(key === 'cv' ? 'cv' : key);
    if (!el) return;
    el.removeAttribute('aria-invalid');
    var d = (el.getAttribute('aria-describedby') || '').split(/\s+/).filter(function (x) { return x !== 'apl-e-' + key; });
    if (d.length) el.setAttribute('aria-describedby', d.join(' ')); else el.removeAttribute('aria-describedby');
    var wrap = el.closest('.apl-field');
    if (wrap) wrap.classList.remove('is-bad');
  }
  ['name', 'email', 'phone', 'location', 'portfolio', 'notice'].forEach(function (k) {
    var el = fieldOf(k);
    if (!el) return;
    var ev = el.tagName === 'SELECT' ? 'change' : 'input';
    el.addEventListener(ev, function () { if (el.getAttribute('aria-invalid') === 'true') clearErr(k); });
  });

  /* ---- the note counter ---- */
  var why = $('[data-apl-why]');
  var count = $('[data-apl-count]');
  if (why && count) {
    var max = parseInt(why.getAttribute('maxlength') || '2000', 10);
    var upd = function () {
      var n = why.value.trim().length;
      if (n === 0) { count.textContent = 'Up to ' + max.toLocaleString('en-GB') + ' characters. Sixty is the minimum.'; count.removeAttribute('data-s'); return; }
      if (n < 60) { count.textContent = (60 - n) + ' more characters needed'; count.setAttribute('data-s', 'low'); return; }
      count.removeAttribute('data-s');
      count.textContent = (max - why.value.length).toLocaleString('en-GB') + ' characters left';
      if (why.getAttribute('aria-invalid') === 'true') clearErr('why');
    };
    why.addEventListener('input', upd);
    upd();
  }

  /* ---- the CV field ---- */
  var cv = $('[data-apl-cv]');
  var cvName = $('[data-apl-cvname]');
  var cvWrap = cv ? cv.closest('.apl-field') : null;
  var OK = ['pdf', 'doc', 'docx'];
  if (cv && cvName && cvWrap) {
    var rest = cvName.textContent;
    cv.addEventListener('change', function () {
      clearErr('cv');
      var f = cv.files && cv.files[0];
      if (!f) { cvWrap.classList.remove('is-on'); cvName.textContent = rest; return; }
      var maxB = parseInt(cv.getAttribute('data-max') || '0', 10);
      var ext = (f.name.split('.').pop() || '').toLowerCase();
      if (OK.indexOf(ext) === -1) {
        cvWrap.classList.remove('is-on');
        cvName.textContent = rest;
        cv.value = '';
        setErr('cv', cv, 'PDF, DOC or DOCX only. A PDF travels best.');
        return;
      }
      if (maxB > 0 && f.size > maxB) {
        cvWrap.classList.remove('is-on');
        cvName.textContent = rest;
        cv.value = '';
        setErr('cv', cv, 'That file is ' + size(f.size) + '. The limit is ' + size(maxB) + '. Send a smaller PDF, or leave it out and give us the link above.');
        return;
      }
      cvWrap.classList.add('is-on');
      cvName.textContent = f.name + ' · ' + size(f.size) + ' · will be attached';
    });
  }

  /* ---- the role select keeps its listing link in step ---- */
  var role = $('[data-apl-role]');
  var hint = $('[data-apl-rolehint]');
  var link = $('[data-apl-rolelink]');
  var base = form.getAttribute('data-careers') || '';
  if (role && hint && link) {
    role.addEventListener('change', function () {
      var v = role.value;
      hint.hidden = !v;
      if (v) link.setAttribute('href', base + '?role=' + encodeURIComponent(v) + '#role-' + v);
      if (role.getAttribute('aria-invalid') === 'true') clearErr('role');
    });
  }

  /* ---- before sending ---- */
  var sending = false;
  form.addEventListener('submit', function (e) {
    if (sending) { e.preventDefault(); return; }
    var bad = [];
    var name = fieldOf('name'), email = fieldOf('email'), phone = fieldOf('phone');
    var loc = fieldOf('location'), port = fieldOf('portfolio'), note = fieldOf('notice');

    if (name.value.trim().length < 2) { setErr('name', name, 'Enter your name.'); bad.push(name); } else clearErr('name');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) { setErr('email', email, 'Enter an email address we can reply to, like name@example.com.'); bad.push(email); } else clearErr('email');
    if (!/^[0-9+().\s-]{6,40}$/.test(phone.value.trim())) { setErr('phone', phone, 'Enter a phone number, including the country code.'); bad.push(phone); } else clearErr('phone');
    if (loc.value.trim().length < 2) { setErr('location', loc, 'Tell us which city you are in.'); bad.push(loc); } else clearErr('location');
    if (!/^(https?:\/\/)?[^\s.]+\.[^\s]{2,}$/.test(port.value.trim())) { setErr('portfolio', port, 'Add one link to your work, like yourname.com or linkedin.com/in/yourname.'); bad.push(port); } else clearErr('portfolio');
    if (!note.value) { setErr('notice', note, 'Choose how soon you could start.'); bad.push(note); } else clearErr('notice');
    if (why && why.value.trim().length < 60) { setErr('why', why, 'A few sentences, please — at least 60 characters.'); bad.push(why); } else if (why) clearErr('why');

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
