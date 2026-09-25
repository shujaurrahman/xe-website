/* ==========================================================================
   THE DISPATCH SIGN-UP — progressive enhancement for partials/newsletter/signup.php.

   The form is a real HTML form and works with this file absent or blocked: it posts to /newsletter,
   which validates server-side and re-renders or redirects. Everything here is an improvement on top:

     • inline validation — the address is checked when the field is left and again as it is corrected,
       so the reader is not sent to another page to be told about a typo;
     • no page jump — submitting posts in the background (js=1) and the answer is written into the
       component's own aria-live region, which the server also writes into on a plain post, so the two
       paths produce the same thing in the same place;
     • one busy state on the button while the request is in flight.

   Anything unexpected — no fetch, a non-JSON answer, a network failure — falls back to submitting the
   form for real, so a reader never ends up worse off than with this file missing.

   It attaches to every [data-nls] on the page independently, so two or three sign-ups on one page do
   not share state. No dependency on window.XE or window.BDH: the component must work on any page.
   ========================================================================== */
(function () {
  'use strict';

  var forms = document.querySelectorAll('[data-nls]');
  if (!forms.length) return;

  /* Deliberately permissive, and only ever used to help before the post: the server decides. It
     rejects the mistakes people actually make — no @, no dot in the domain, a trailing dot, spaces. */
  var RE = /^[^\s@,;:<>"'\\]+@[^\s@.,;:<>"'\\]+(\.[^\s@.,;:<>"'\\]+)+$/;

  Array.prototype.forEach.call(forms, function (root) {
    var form = root.querySelector('form');
    if (!form) return;
    var field = form.querySelector('input[type="email"]');
    var err   = root.querySelector('.nls__err');
    var live  = root.querySelector('[data-nls-live]');
    var flag  = form.querySelector('[data-nls-js]');
    var go    = form.querySelector('button[type="submit"]');
    if (!field || !err || !live || !go) return;

    var goText = go.firstChild;
    var goWas  = goText && goText.nodeType === 3 ? goText.nodeValue : null;
    var touched = false, busy = false;

    function showErr(msg) {
      err.textContent = msg;
      err.hidden = !msg;
      if (msg) {
        field.setAttribute('aria-invalid', 'true');
        field.setAttribute('aria-describedby', err.id + ' ' + err.id.replace(/-err$/, '-note'));
      } else {
        field.removeAttribute('aria-invalid');
        field.setAttribute('aria-describedby', err.id.replace(/-err$/, '-note'));
      }
    }

    function check() {
      var v = field.value.trim();
      if (v === '') { showErr('Enter the address you would like the issue sent to.'); return false; }
      if (!RE.test(v)) { showErr('That does not look like an address we could send to. Something like name@company.com.'); return false; }
      showErr('');
      return true;
    }

    field.addEventListener('blur', function () { touched = true; check(); });
    field.addEventListener('input', function () { if (touched) check(); });

    function setBusy(on) {
      busy = on;
      root.classList.toggle('is-busy', on);
      go.setAttribute('aria-busy', on ? 'true' : 'false');
      if (goWas !== null) goText.nodeValue = on ? 'Sending ' : goWas;
    }

    /* Build the answer as elements rather than markup, so nothing the server returns is ever parsed
       as HTML in the page. */
    function answer(kind, title, body, extra) {
      var box = document.createElement('div');
      box.className = 'nls__res nls__res--' + kind;
      var h = document.createElement('p');
      h.className = 'nls__rt';
      var mark = document.createElement('span');
      mark.className = 'nls__ri';
      mark.setAttribute('aria-hidden', 'true');
      mark.textContent = kind === 'ok' ? '\u2713' : '!';
      h.appendChild(mark);
      h.appendChild(document.createTextNode(title));
      box.appendChild(h);
      body.forEach(function (t) {
        var p = document.createElement('p');
        p.className = 'nls__rp';
        p.textContent = t;
        box.appendChild(p);
      });
      if (extra) box.appendChild(extra);
      live.textContent = '';
      live.appendChild(box);
    }

    function mailtoRow(url, ref) {
      var row = document.createElement('p');
      row.className = 'nls__ract';
      var a = document.createElement('a');
      a.className = 'btn btn--out nls__mailto';
      a.href = url;
      a.textContent = 'Email it to us';
      var chev = document.createElement('span');
      chev.className = 'i';
      chev.setAttribute('aria-hidden', 'true');
      chev.textContent = '\u203A';
      a.appendChild(chev);
      row.appendChild(a);
      if (ref) {
        var s = document.createElement('span');
        s.className = 'nls__rref';
        s.textContent = 'Reference ' + ref;
        row.appendChild(s);
      }
      return row;
    }

    form.addEventListener('submit', function (ev) {
      if (busy) { ev.preventDefault(); return; }
      touched = true;
      if (!check()) { ev.preventDefault(); field.focus(); return; }
      if (!window.fetch || !window.FormData) return;           /* let the browser post it */

      ev.preventDefault();
      if (flag) flag.value = '1';
      setBusy(true);

      var data = new FormData(form);
      fetch(form.action, {
        method: 'POST',
        body: data,
        credentials: 'same-origin',
        headers: { 'Accept': 'application/json' }
      }).then(function (r) {
        var type = r.headers.get('content-type') || '';
        if (type.indexOf('application/json') === -1) throw new Error('not json');
        return r.json();
      }).then(function (j) {
        setBusy(false);
        if (flag) flag.value = '0';
        if (j && j.t) { var tf = form.querySelector('input[name="t"]'); if (tf) tf.value = j.t; }

        if (j && j.state === 'sent') {
          showErr('');
          form.hidden = true;
          root.classList.add('is-done');
          answer('ok', 'Your address is with us.', [
            'You are not subscribed yet, and we are not pretending otherwise: nothing was stored. A person adds you to the list by hand until the email service is connected, and when it is, you will get a confirmation link to click.'
              + (j.ref ? ' Your reference is ' + j.ref + '.' : ''),
            'Nothing else happens. No sales email, no sequence, no sharing.'
          ]);
          return;
        }
        if (j && j.state === 'failed') {
          answer('bad', 'Your address did not reach our inbox.', [
            'The site could not send the message just now, so nothing was lost on your side — it simply did not arrive. Your address is still in the form below. Send it to us directly instead, or try again.'
          ], j.mailto ? mailtoRow(j.mailto, j.ref) : null);
          return;
        }
        var e = (j && j.errors) || {};
        if (e.email) { showErr(e.email); field.focus(); }
        if (e.form) {
          answer('bad', 'That did not go through.', [e.form]);
        } else if (!e.email) {
          answer('bad', 'That did not go through.', ['Something went wrong at our end. Try once more, or write to us directly.']);
        } else {
          live.textContent = '';
        }
      }).catch(function () {
        /* the background post is the enhancement; hand the form back to the browser */
        setBusy(false);
        if (flag) flag.value = '0';
        form.submit();
      });
    });
  });
})();
