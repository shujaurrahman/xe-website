/* ==========================================================================
   Contact — behaviour for contact.php. The page works without it (a plain POST
   form with server-side validation, <details> blocks a reader can open, and a
   server-rendered preview); this adds:

   • the depth chooser: opening and closing the optional blocks as the choice
     changes, and never closing one that holds an answer or an error
   • a live "Your brief": selected services and the engagement model, removable
   • a completeness meter over the same questions the email carries
   • #inbox rebuilt as you type — read from the data-pv labels in the form, which
     are exactly the labels ct_blocks() puts in the email, so the two cannot drift
   • search across every service, with discipline groups opening on a match
   • the capability pages' services loaded on demand (?ct_more=1)
   • the chosen file's real name and size on the upload control
   • the six discipline tabs in #needs, and the jump from one to the brief
   • a character counter, focus on the error or failure message, a light client
     check before sending, and no double submits
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

  /* ======================================================================
     The brief, as the email will carry it. One walk of the form, reading the
     data-pv labels — the same labels ct_blocks() writes into the email.
     ====================================================================== */
  function fieldValue(el) {
    var kind = el.getAttribute('data-pv-kind');
    if (kind === 'services') {
      return checked().map(function (b) {
        var parts = mt(b).split(' · ');
        var disc = parts[0] || '';
        var page = parts[1] === 'Overview' ? 'Overview' : (parts[1] || '');
        return nm(b) + (disc ? '  [' + disc + (page ? ' › ' + page : '') + ']' : '');
      }).join('\n');
    }
    if (kind === 'package') {
      var r = pkgRadio();
      if (!r || !r.value) return '';
      return r.getAttribute('data-name') + ' · ' + (r.getAttribute('data-meta') || '').split(' · ')[0];
    }
    if (kind === 'check') return el.checked ? (el.getAttribute('data-pv-yes') || 'Yes') : '';
    if (el.tagName === 'SELECT') {
      if (!el.value) return '';
      var o = el.options[el.selectedIndex];
      return o ? o.text.trim() : '';
    }
    return (el.value || '').trim();
  }

  function collect() {
    var out = [];
    $$('[data-pv-block]', form).forEach(function (blk) {
      var rows = [];
      $$('[data-pv],[data-pv-join]', blk).forEach(function (el) {
        var join = el.getAttribute('data-pv-join');
        var v = fieldValue(el);
        if (join) {
          if (!v) return;
          for (var i = 0; i < rows.length; i++) {
            if (rows[i].label === join) { rows[i].value = rows[i].value ? rows[i].value + ' — ' + v : v; return; }
          }
          return;
        }
        var label = el.getAttribute('data-pv');
        if (el.getAttribute('data-pv-kind') === 'services') label = 'Services (' + checked().length + ')';
        rows.push({ label: label, value: v, long: el.hasAttribute('data-pv-long') || el.getAttribute('data-pv-kind') === 'services' });
      });
      out.push({ title: blk.getAttribute('data-pv-block'), rows: rows });
    });
    return out;
  }

  var pvBody = $('[data-ct-pvbody]');
  var pvLive = $('[data-ct-pvlive]');
  if (pvLive) pvLive.hidden = false;
  var fileIn  = $('[data-ct-file]');
  var fileTxt = $('[data-ct-filename]');
  var fileTxt0 = fileTxt ? fileTxt.textContent : '';

  function pad2(n) { return n < 10 ? '0' + n : '' + n; }
  function fileSize(b) {
    if (b >= 1048576) { var m = b / 1048576; return (m < 10 ? m.toFixed(1).replace(/\.0$/, '') : Math.round(m)) + ' MB'; }
    return Math.max(1, Math.round(b / 1024)) + ' KB';
  }

  function renderPreview(blocks) {
    if (!pvBody) return;
    var frag = document.createDocumentFragment();

    var dep = form.querySelector('input[name="depth"]:checked');
    var depName = 'Send a brief';
    if (dep) { var dn = dep.parentNode.querySelector('.ct-depth__n'); if (dn) depName = dn.textContent.trim(); }
    var top = document.createElement('p');
    top.className = 'ct-pv__top';
    [(dep && dep.value === 'rfq' ? 'New RFQ' : 'New brief') + ' from the ' + (pvBody.getAttribute('data-site') || '') + ' website',
     null, 'Depth:     ' + depName].forEach(function (t, i) {
      var s = document.createElement('span');
      if (i === 1) { s.appendChild(document.createTextNode('Reference: ')); var it = document.createElement('i'); it.textContent = 'assigned when you send'; s.appendChild(it); }
      else { s.textContent = t; }
      top.appendChild(s);
    });
    frag.appendChild(top);

    var n = 0;
    blocks.forEach(function (b) {
      n++;
      frag.appendChild(blockEl(pad2(n), b.title, b.rows));
    });

    var f = fileIn && fileIn.files && fileIn.files[0];
    frag.appendChild(blockEl(pad2(n + 1), 'ATTACHMENT', [{
      label: 'Document',
      value: f ? f.name + ' · ' + fileSize(f.size) : '',
      empty: 'none attached'
    }]));

    var sc = pvBody.parentNode, y = sc ? sc.scrollTop : 0;
    pvBody.textContent = '';
    pvBody.appendChild(frag);
    if (sc) sc.scrollTop = y;
  }

  function blockEl(num, title, rows) {
    var wrap = document.createElement('div'); wrap.className = 'ct-pv__blk';
    var h = document.createElement('p'); h.className = 'ct-pv__bt';
    var b = document.createElement('span'); b.className = 'ct-pv__bn'; b.textContent = num;
    h.appendChild(b); h.appendChild(document.createTextNode('— ' + title.toUpperCase()));
    wrap.appendChild(h);
    var dl = document.createElement('dl'); dl.className = 'ct-pv__rows';
    rows.forEach(function (r) {
      var row = document.createElement('div');
      row.className = 'ct-pv__r' + (r.value ? '' : ' is-empty');
      var dt = document.createElement('dt'); dt.textContent = r.label;
      var dd = document.createElement('dd');
      if (r.long) dd.className = 'ct-pv__v--long';
      dd.textContent = r.value || r.empty || 'not answered';
      row.appendChild(dt); row.appendChild(dd); dl.appendChild(row);
    });
    wrap.appendChild(dl);
    return wrap;
  }

  /* ---- the completeness meter, over the same questions ---- */
  var mFill = $('[data-ct-mfill]');
  var mCount = $('[data-ct-mcount]');
  var mNote = $('[data-ct-mnote]');
  function renderMeter(blocks) {
    if (!mFill && !mCount) return;
    var on = 0, all = 0;
    blocks.forEach(function (b) { b.rows.forEach(function (r) { all++; if (r.value) on++; }); });
    if (mCount) mCount.textContent = on + ' of ' + all;
    if (mFill) mFill.style.width = (all ? Math.round(on / all * 100) : 0) + '%';
    if (mNote) {
      mNote.textContent = on < 3
        ? 'Two answers are enough to send. Every extra one takes a question out of the first call.'
        : (on < 10
          ? 'Enough to reply to. Add budget and timing and we can propose a shape as well.'
          : (on < 18
            ? 'Enough to propose a scope against. The rest saves a round of email.'
            : 'This is a brief we can price without asking you anything first.'));
    }
  }

  function renderBrief(persist) {
    var on = checked();
    if (list) {
      list.textContent = '';
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

    var blocks = collect();
    renderPreview(blocks);
    renderMeter(blocks);

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

  /* ---- the depth chooser opens and closes the optional blocks ---- */
  var folds = {
    detail: $('[data-ct-fold="detail"]'),
    money:  $('[data-ct-fold="money"]'),
    prac:   $('[data-ct-fold="prac"]')
  };
  var DEPTH_OPEN = {
    hello: { detail: false, money: false, prac: false },
    brief: { detail: false, money: true,  prac: false },
    rfq:   { detail: true,  money: true,  prac: true }
  };
  /* a block that already carries an answer or an error is never closed under the reader */
  function foldHasContent(d) {
    if (!d) return false;
    if ($('.ct-err', d)) return true;
    return $$('input, select, textarea', d).some(function (el) {
      if (el.type === 'checkbox' || el.type === 'radio') return el.checked && el.value !== '';
      return (el.value || '').trim() !== '';
    });
  }
  function applyDepth() {
    var r = form.querySelector('input[name="depth"]:checked');
    var want = DEPTH_OPEN[r ? r.value : 'brief'] || DEPTH_OPEN.brief;
    Object.keys(folds).forEach(function (k) {
      var d = folds[k];
      if (!d) return;
      d.open = want[k] || foldHasContent(d);
    });
    $$('[data-ct-depth]', form).forEach(function (i) {
      i.closest('.ct-depth').classList.toggle('is-on', i.checked);
    });
  }
  $$('[data-ct-depth]', form).forEach(function (i) {
    i.addEventListener('change', function () { applyDepth(); renderBrief(false); });
  });

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
    else if (e.target.name !== 'depth') renderBrief(false);
    if (e.target.name === 'service[]') {
      var fs = $('#ct-service');
      if (fs && fs.classList.contains('is-bad') && checked().length) clearErr('service');
    }
  });
  var raf = 0;
  form.addEventListener('input', function (e) {
    if (!e.target.hasAttribute || !(e.target.hasAttribute('data-pv') || e.target.hasAttribute('data-pv-join'))) return;
    if (raf) return;
    raf = (window.requestAnimationFrame || setTimeout)(function () { raf = 0; renderBrief(false); }, 16);
  });

  /* ---- the chosen document, named and sized on the control ---- */
  if (fileIn && fileTxt) {
    fileIn.addEventListener('change', function () {
      var f = fileIn.files && fileIn.files[0];
      fileTxt.textContent = f ? f.name + ' · ' + fileSize(f.size) : fileTxt0;
      renderBrief(false);
    });
  }

  /* ---- copy the brief as plain text ---- */
  var copyBtn = $('[data-ct-copy]');
  if (copyBtn && navigator.clipboard && navigator.clipboard.writeText) {
    copyBtn.hidden = false;
    copyBtn.addEventListener('click', function () {
      var lines = [];
      collect().forEach(function (b) {
        lines.push('', '— ' + b.title.toUpperCase());
        b.rows.forEach(function (r) {
          if (!r.value) return;
          if (r.long && r.value.indexOf('\n') !== -1) { lines.push(r.label + ':'); r.value.split('\n').forEach(function (l) { lines.push('  ' + l); }); }
          else lines.push(r.label + ': ' + r.value);
        });
      });
      navigator.clipboard.writeText(lines.join('\n').replace(/^\n/, '') + '\n').then(function () {
        var was = copyBtn.textContent;
        copyBtn.textContent = 'Copied';
        setTimeout(function () { copyBtn.textContent = was; }, 1800);
      }, function () { copyBtn.textContent = 'Select and copy'; });
    });
  }

  /* ---- services the catalogue brief still holds ---- */
  (function offerBack() {
    var s = load();
    if (!s || !side || !s.items.length) return;
    if (s.items.some(function (it) { return !byId[it.id]; }) && lazies.length) { hydrate().then(offerBack); return; }
    var missing = s.items.filter(function (it) { return byId[it.id] && !byId[it.id].checked; });
    if (!missing.length) return;
    var box = document.createElement('div');
    box.className = 'ct-note ct-back-add';
    var p = document.createElement('p');
    p.textContent = (missing.length === 1 ? 'One more service' : missing.length + ' more services') + ' from your brief: ' +
      missing.map(function (it) { return it.name; }).join(', ') + '.';
    var btn = document.createElement('button');
    btn.type = 'button'; btn.className = 'tl';
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

  /* ---- "Start a <discipline> brief" from #needs ---- */
  $$('[data-ct-jump]').forEach(function (a) {
    a.addEventListener('click', function () {
      var slug = a.getAttribute('data-ct-jump');
      var target = null;
      discs.forEach(function (d) { if (d.getAttribute('data-slug') === slug) target = d; });
      if (target) discs.forEach(function (d) { d.open = d === target; });
    });
  });

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
    if (el && key !== 'service') {
      el.setAttribute('aria-invalid', 'true');
      var d = el.getAttribute('aria-describedby') || '';
      if (d.split(/\s+/).indexOf(id) === -1) el.setAttribute('aria-describedby', (d ? d + ' ' : '') + id);
    }
  }
  function clearErr(key) {
    var p = document.getElementById('ct-e-' + key);
    if (p) p.parentNode.removeChild(p);
    if (key === 'service') { var fs = $('#ct-service'); if (fs) fs.classList.remove('is-bad'); return; }
    var el = fieldOf(key);
    if (el) {
      el.removeAttribute('aria-invalid');
      var d = (el.getAttribute('aria-describedby') || '').split(/\s+/).filter(function (x) { return x && x !== 'ct-e-' + key; }).join(' ');
      if (d) el.setAttribute('aria-describedby', d); else el.removeAttribute('aria-describedby');
      var f = el.closest('.ct-field'); if (f) f.classList.remove('is-bad');
    }
  }
  ['name', 'email', 'phone', 'website', 'message'].forEach(function (k) {
    var el = fieldOf(k);
    if (el) el.addEventListener('input', function () { if (el.getAttribute('aria-invalid') === 'true') clearErr(k); });
  });
  if (msg) msg.addEventListener('input', function () { if (msg.value.trim().length >= 10) clearErr('service'); });

  var sending = false;
  form.addEventListener('submit', function (e) {
    if (sending) { e.preventDefault(); return; }
    var bad = [];
    var name = fieldOf('name'), email = fieldOf('email'), phone = fieldOf('phone'), site = fieldOf('website');
    var depth = form.querySelector('input[name="depth"]:checked');
    if (name.value.trim().length < 2) { setErr('name', name, 'Enter your name.'); bad.push(name); } else clearErr('name');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) { setErr('email', email, 'Enter an email address we can reply to, like name@company.com.'); bad.push(email); } else clearErr('email');
    if (phone && phone.value.trim() && !/^[0-9+().\s-]{6,40}$/.test(phone.value.trim())) { setErr('phone', phone, 'Use digits, spaces and + ( ) - only.'); bad.push(phone); } else clearErr('phone');
    if (site && site.value.trim() && !/^(https?:\/\/)?[^\s./]+(\.[^\s./]+)+(\/\S*)?$/i.test(site.value.trim())) { setErr('website', site, 'That does not look like a web address. Something like yourcompany.com.'); bad.push(site); } else clearErr('website');
    if (!checked().length && (!msg || msg.value.trim().length < 10)) { setErr('service', null, 'Choose at least one service, or tell us what you need in the message.'); bad.push($('#ct-q') && !$('#ct-q').closest('[hidden]') ? $('#ct-q') : msg); } else clearErr('service');
    if (depth && depth.value === 'rfq' && msg && msg.value.trim().length < 60) {
      setErr('message', msg, 'A full RFQ needs the problem in your own words — at least a couple of sentences. Switch to “Send a brief” if you would rather keep it short.');
      bad.push(msg);
    } else if (msg) clearErr('message');
    if (bad.length) { e.preventDefault(); bad[0].focus(); return; }
    sending = true;
    var btn = $('[data-ct-send]');
    if (btn) { btn.setAttribute('aria-busy', 'true'); btn.firstChild.nodeValue = 'Sending… '; }
  });

  applyDepth();
  renderBrief();
})();

/* ==========================================================================
   #needs — the six discipline tabs. Every pane carries its own heading, so the
   <noscript> rule in the partial simply stacks them when this never runs.
   ========================================================================== */
(function () {
  'use strict';
  if (!window.BDH) return;
  var root = document.querySelector('.ct-needs');
  if (!root) return;
  var tabs = root.querySelector('[data-ct-ndtabs]');
  var panes = root.querySelector('[data-ct-ndpanes]');
  if (!tabs || !panes) return;
  var api = BDH.tabs(root, {
    tabs: '[data-ct-ndtabs] [role="tab"]',
    panes: '[data-ct-ndpanes] .bdh-pane',
    initial: 0
  });
  if (!api) return;
})();
