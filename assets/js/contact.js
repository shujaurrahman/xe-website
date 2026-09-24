/* ==========================================================================
   Contact — behaviour for contact.php. The page works without it (a plain POST
   form with server-side validation); this adds:
   • a live "Your brief": selected services and the package, each removable
   • search across every service, with discipline groups opening on a match
   • the services still in the catalogue brief (sessionStorage 'xe-brief')
     offered back when the visitor arrived through a single "Enquire" link
   • a character counter, focus on the error or failure message, a light
     client check before sending, and no double submits
   • after a successful send, the catalogue brief is cleared
   ========================================================================== */
(function () {
  'use strict';

  var KEY = 'xe-brief';
  function $(s, r) { return (r || document).querySelector(s); }
  function $$(s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); }
  function load() { try { var s = JSON.parse(sessionStorage.getItem(KEY) || 'null'); return s && Array.isArray(s.items) ? s : null; } catch (e) { return null; } }
  function save(s) { try { sessionStorage.setItem(KEY, JSON.stringify(s)); } catch (e) {} }

  /* sent: the brief has gone, start clean next time */
  if ($('[data-ct-sent]')) { try { sessionStorage.removeItem(KEY); } catch (e) {} return; }

  var form = $('[data-ct-form]');
  if (!form) return;

  var focusEl = $('[data-ct-focus]');
  if (focusEl) { focusEl.focus(); }

  var X = '<svg class="svc-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M6.5 6.5l11 11M17.5 6.5l-11 11"/></svg>';
  var boxes  = [];
  var radios = $$('input[name="package"]', form);
  var list   = $('[data-ct-blist]');
  var empty  = $('[data-ct-bempty]');
  var bcount = $('[data-ct-bcount]');
  var bpk    = $('[data-ct-bpk]');
  var byId   = {};
  function index() { boxes = $$('input[name="service[]"]', form); byId = {}; boxes.forEach(function (b) { byId[b.value] = b; }); }
  index();
  /* a service's name and its "discipline · page · category" line: on the input, or shared by its list */
  function nm(b) { var n = b.getAttribute('data-name'); if (n !== null) return n; var t = b.parentNode.querySelector('.ct-chip__n'); return t ? t.textContent : b.value; }
  function mt(b) { var m = b.getAttribute('data-meta'); if (m !== null) return m; var u = b.closest('[data-meta]'); return u ? u.getAttribute('data-meta') : ''; }

  /* ---- the capability pages' services load on demand (the page ships only each discipline's own) ---- */
  var lazies = $$('[data-ct-lazy]', form);
  var more = null;
  function hydrate() {
    if (!lazies.length) return Promise.resolve();
    if (more) return more;
    lazies.forEach(function (u) { var n = u.parentNode.querySelector('[data-ct-lazyn]'); if (n) n.textContent = 'Loading services…'; });
    more = fetch(location.pathname + '?ct_more=1', { headers: { Accept: 'application/json' } })
      .then(function (r) { if (!r.ok) throw new Error(r.status); return r.json(); })
      .then(function (data) {
        lazies.forEach(function (u) {
          var rows = data[u.getAttribute('data-ct-lazy')] || [];
                    rows.forEach(function (x) {
            var li = document.createElement('li'); li.setAttribute('data-ct-item', ''); li.setAttribute('data-s', x[3]);
            var lb = document.createElement('label'); lb.className = 'ct-chip';
            var inp = document.createElement('input'); inp.type = 'checkbox'; inp.name = 'service[]'; inp.value = x[0]; inp.setAttribute('data-meta', x[2]);
            var bx = document.createElement('span'); bx.className = 'ct-chip__box'; bx.setAttribute('aria-hidden', 'true');
            var nn = document.createElement('span'); nn.className = 'ct-chip__n'; nn.textContent = x[1];
            lb.appendChild(inp); lb.appendChild(bx); lb.appendChild(nn); li.appendChild(lb); u.appendChild(li);
          });
          var n = u.parentNode.querySelector('[data-ct-lazyn]'); if (n) n.parentNode.removeChild(n);
          u.removeAttribute('data-ct-lazy');
        });
        lazies = [];
        index();
      })
      .catch(function () {
        more = null;
        lazies.forEach(function (u) { var n = u.parentNode.querySelector('[data-ct-lazyn]'); if (n) n.textContent = 'These services did not load. Name what you need in your message instead.'; });
      });
    return more;
  }
  $$('[data-ct-more]', form).forEach(function (d) { d.addEventListener('toggle', function () { if (d.open) hydrate(); }); });

  function checked() { return boxes.filter(function (b) { return b.checked; }); }
  function pkgRadio() { return radios.filter(function (r) { return r.checked; })[0] || null; }

  function renderBrief(persist) {
    var on = checked();
    if (list) {
      list.innerHTML = '';
      on.forEach(function (b) {
        var li = document.createElement('li'); li.className = 'ct-bi';
        var n = document.createElement('span'); n.className = 'ct-bi__n'; n.textContent = nm(b); li.appendChild(n);
        var m = document.createElement('span'); m.className = 'ct-bi__m'; m.textContent = mt(b); li.appendChild(m);
        var x = document.createElement('button'); x.type = 'button'; x.className = 'ct-bi__x'; x.setAttribute('data-ct-rm', b.value);
        x.setAttribute('aria-label', 'Remove ' + nm(b) + ' from your brief'); x.innerHTML = X; li.appendChild(x);
        list.appendChild(li);
      });
    }
    if (empty) empty.hidden = on.length > 0;
    if (bcount) bcount.textContent = on.length === 1 ? '1 service' : on.length + ' services';

    var r = pkgRadio();
    if (bpk) {
      var has = r && r.value;
      bpk.hidden = !has;
      if (has) {
        $('[data-ct-bpkn]', bpk).textContent = r.getAttribute('data-name');
        $('[data-ct-bpkm]', bpk).textContent = r.getAttribute('data-meta');
      }
    }

    $$('[data-ct-disc], [data-ct-more]', form).forEach(function (d) {
      var k = $$('input[name="service[]"]', d).filter(function (b) { return b.checked; }).length;
      var c = $('[data-ct-dcount], [data-ct-mcount]', d);
      if (c) c.textContent = k ? k + ' selected' : '';
    });

    /* keep the catalogue brief in step with what will be sent (only once the visitor edits it) */
    if (!persist) return;
    var s = load() || { items: [], package: '', packageName: '' };
    s.items = on.map(function (b) {
      var parts = mt(b).split(' · ');
      return { id: b.value, name: nm(b), page: parts[1] === 'Overview' ? parts[0] : (parts[1] || ''), pageKey: b.value.split(':')[0] };
    });
    s.package = r ? r.value : '';
    s.packageName = r && r.value ? r.getAttribute('data-name') + ' · ' + (r.getAttribute('data-meta') || '').split(' · ')[0] : '';
    save(s);
  }

  /* the aside's remove controls are links without JS; here they just untick */
  var side = $('[data-ct-brief]');
  if (side) {
    side.addEventListener('click', function (e) {
      var rm = e.target.closest('[data-ct-rm]');
      var rp = e.target.closest('[data-ct-rmpk]');
      if (rm) {
        e.preventDefault();
        var b = byId[rm.getAttribute('data-ct-rm')];
        if (b) { b.checked = false; renderBrief(true); }
        var next = $('[data-ct-rm]', side);
        (next || $('#ct-service .ct-disc__s') || form).focus();
      } else if (rp) {
        e.preventDefault();
        var none = radios.filter(function (r) { return r.value === ''; })[0];
        if (none) { none.checked = true; renderBrief(true); none.focus(); }
      }
    });
  }
  form.addEventListener('change', function (e) {
    if (e.target.name === 'service[]' || e.target.name === 'package') renderBrief(true);
    if (e.target.name === 'service[]') {
      var fs = $('#ct-service');
      if (fs && fs.classList.contains('is-bad') && checked().length) clearErr('service');
    }
  });

  /* ---- services the catalogue brief still holds ---- */
  (function offerBack() {
    var s = load();
    if (!s || !side || !s.items.length) return;
    if (s.items.some(function (it) { return !byId[it.id]; }) && lazies.length) { hydrate().then(offerBack); return; }
    var missing = s.items.filter(function (it) { return byId[it.id] && !byId[it.id].checked; });
    if (!missing.length) return;
    var box = document.createElement('div');
    box.className = 'ct-note ct-back';
    var p = document.createElement('p');
    p.textContent = (missing.length === 1 ? 'One more service' : missing.length + ' more services') + ' from your brief: ' +
      missing.map(function (it) { return it.name; }).join(', ') + '.';
    var btn = document.createElement('button');
    btn.type = 'button'; btn.className = 'tl ct-back__go';
    btn.innerHTML = 'Add ' + (missing.length === 1 ? 'it' : 'them') + ' <span class="i" aria-hidden="true">›</span>';
    btn.addEventListener('click', function () {
      missing.forEach(function (it) { byId[it.id].checked = true; var d = byId[it.id].closest('details'); while (d) { d.open = true; d = d.parentElement.closest('details'); } });
      box.parentNode.removeChild(box);
      renderBrief(true);
      var h = $('#ct-brief-t'); if (h) { h.setAttribute('tabindex', '-1'); h.focus(); }
    });
    box.appendChild(p); box.appendChild(btn);
    var head = $('.ct-brief__head', side);
    head.parentNode.insertBefore(box, head.nextSibling);
  })();

  /* ---- search across every service ---- */
  var find = $('[data-ct-find]');
  var q = $('[data-ct-q]');
  var qn = $('[data-ct-qn]');
  var none = $('[data-ct-none]');
  var discs = $$('[data-ct-disc]', form);
  var mores = $$('[data-ct-more]', form);
  var saved = null;
  if (find && q) {
    find.hidden = false;
    var t = null;
    q.addEventListener('input', function () { clearTimeout(t); t = setTimeout(function () { hydrate().then(filter); }, 90); });
    q.addEventListener('keydown', function (e) { if (e.key === 'Escape' && q.value) { q.value = ''; filter(); } });
  }
  function filter() {
    var terms = q.value.toLowerCase().trim().split(/\s+/).filter(Boolean);
    var items = $$('[data-ct-item]', form);
    if (!terms.length) {
      items.forEach(function (i) { i.hidden = false; });
      $$('[data-ct-block]', form).forEach(function (b) { b.hidden = false; });
      discs.concat(mores).forEach(function (d) { d.hidden = false; });
      $$('[data-ct-caps]', form).forEach(function (c) { c.hidden = false; });
      if (saved) { discs.concat(mores).forEach(function (d, i) { d.open = saved[i]; }); saved = null; }
      if (qn) qn.textContent = '';
      if (none) none.hidden = true;
      return;
    }
    if (!saved) saved = discs.concat(mores).map(function (d) { return d.open; });
    var n = 0;
    items.forEach(function (i) {
      var s = i.getAttribute('data-s') || '';
      var hit = terms.every(function (w) { return s.indexOf(w) !== -1; });
      i.hidden = !hit; if (hit) n++;
    });
    $$('[data-ct-block]', form).forEach(function (b) { b.hidden = !$$('[data-ct-item]', b).some(function (i) { return !i.hidden; }); });
    mores.forEach(function (m) { var hit = $$('[data-ct-block]', m).some(function (b) { return !b.hidden; }); m.hidden = !hit; if (hit) m.open = true; });
    $$('[data-ct-caps]', form).forEach(function (c) { c.hidden = !$$('[data-ct-more]', c).some(function (m) { return !m.hidden; }); });
    discs.forEach(function (d) { var hit = $$('[data-ct-item]', d).some(function (i) { return !i.hidden; }); d.hidden = !hit; if (hit) d.open = true; });
    if (qn) qn.textContent = n === 1 ? '1 service matches' : n + ' services match';
    if (none) none.hidden = n > 0;
  }

  /* ---- message counter ---- */
  var msg = $('[data-ct-msg]');
  var cnt = $('[data-ct-count]');
  if (msg && cnt) {
    var max = parseInt(msg.getAttribute('maxlength') || '4000', 10);
    var upd = function () {
      var left = max - msg.value.length;
      cnt.textContent = msg.value.length ? left.toLocaleString('en-GB') + ' characters left' : 'Up to ' + max.toLocaleString('en-GB') + ' characters.';
    };
    msg.addEventListener('input', upd); upd();
  }

  /* ---- a light check before sending (the server checks again) ---- */
  function fieldOf(name) { return form.querySelector('[name="' + name + '"]'); }
  function setErr(key, el, text) {
    var id = 'ct-e-' + key;
    var p = document.getElementById(id);
    if (!p) {
      p = document.createElement('p'); p.className = 'ct-err'; p.id = id;
      if (key === 'service') { var fs = $('#ct-service'); fs.classList.add('is-bad'); fs.insertBefore(p, $('.ct-set__d', fs).nextSibling); }
      else { el.parentNode.appendChild(p); el.closest('.ct-field').classList.add('is-bad'); }
    }
    p.textContent = text;
    if (el && key !== 'service') { el.setAttribute('aria-invalid', 'true'); el.setAttribute('aria-describedby', id); }
  }
  function clearErr(key) {
    var p = document.getElementById('ct-e-' + key);
    if (p) p.parentNode.removeChild(p);
    if (key === 'service') { var fs = $('#ct-service'); if (fs) fs.classList.remove('is-bad'); return; }
    var el = fieldOf(key);
    if (el) { el.removeAttribute('aria-invalid'); el.removeAttribute('aria-describedby'); var f = el.closest('.ct-field'); if (f) f.classList.remove('is-bad'); }
  }
  ['name', 'email', 'phone'].forEach(function (k) {
    var el = fieldOf(k);
    if (el) el.addEventListener('input', function () { if (el.getAttribute('aria-invalid') === 'true') clearErr(k); });
  });
  if (msg) msg.addEventListener('input', function () { if (msg.value.trim().length >= 10) clearErr('service'); });

  var sending = false;
  form.addEventListener('submit', function (e) {
    if (sending) { e.preventDefault(); return; }
    var bad = [];
    var name = fieldOf('name'), email = fieldOf('email'), phone = fieldOf('phone');
    if (name.value.trim().length < 2) { setErr('name', name, 'Enter your name.'); bad.push(name); } else clearErr('name');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) { setErr('email', email, 'Enter an email address we can reply to, like name@company.com.'); bad.push(email); } else clearErr('email');
    if (phone.value.trim() && !/^[0-9+().\s-]{6,40}$/.test(phone.value.trim())) { setErr('phone', phone, 'Use digits, spaces and + ( ) - only.'); bad.push(phone); } else clearErr('phone');
    if (!checked().length && (!msg || msg.value.trim().length < 10)) { setErr('service', null, 'Choose at least one service, or tell us what you need in the message.'); bad.push($('#ct-q') && !$('#ct-q').closest('[hidden]') ? $('#ct-q') : msg); } else clearErr('service');
    if (bad.length) { e.preventDefault(); bad[0].focus(); return; }
    sending = true;
    var btn = $('[data-ct-send]');
    if (btn) { btn.setAttribute('aria-busy', 'true'); btn.firstChild.nodeValue = 'Sending… '; }
  });

  renderBrief();
})();
