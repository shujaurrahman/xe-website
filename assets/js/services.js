/* ==========================================================================
   Services & packages — behaviour for partials/services/catalogue.php.
   Standalone: needs only the catalogue markup. Uses window.XE (core.js) for
   the reduced-motion flag and inView when present; never needs BDH.

   What it adds to the plain-HTML catalogue (which already works as a POST form):
   • ARIA tabs over the categories: arrows, Home/End, a sliding ink marker,
     one pane at a time, cards rising in turn on each switch.
   • The brief: "Add to brief" checkboxes feed a tray that shows the count,
     the names (removable), the package picker and "Continue to contact".
     The brief lives in sessionStorage ('xe-brief') for the visit, so services
     picked on one page are still there on the next. Continue sends every id.
   • Every "Choose <package>" button carries the services already in the brief.
   Everything is announced through a polite live region.
   ========================================================================== */
(function () {
  'use strict';

  var roots = document.querySelectorAll('[data-svc]');
  if (!roots.length) return;

  var XE = window.XE || null;
  var reduced = XE ? !!XE.reduced : window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var KEY = 'xe-brief';
  var X_ICON = '<svg class="svc-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M6.5 6.5l11 11M17.5 6.5l-11 11"/></svg>';

  function $$(sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); }
  function pad(n) { return (n < 10 ? '0' : '') + n; }

  function load() {
    try {
      var s = JSON.parse(sessionStorage.getItem(KEY) || 'null');
      if (s && Array.isArray(s.items)) return { items: s.items.filter(function (i) { return i && typeof i.id === 'string'; }), package: s.package || '', packageName: s.packageName || '' };
    } catch (e) {}
    return { items: [], package: '', packageName: '' };
  }
  function save(s) { try { sessionStorage.setItem(KEY, JSON.stringify(s)); } catch (e) {} }

  function inView(el, fn) {
    if (reduced) { fn(); return; }
    if (XE && XE.inView) { XE.inView(el, fn); return; }
    if (!('IntersectionObserver' in window)) { fn(); return; }
    var io = new IntersectionObserver(function (es) {
      if (es.some(function (e) { return e.isIntersecting; })) { io.disconnect(); fn(); }
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.1 });
    io.observe(el);
  }

  /* The brief can hold services added on earlier pages, which the form on this page does not know
     about, so the selection is posted from a form built here rather than left to the native submit.
     Posting also keeps a long brief out of the URL. The contact page reads 'intent=select'. */
  function postSelection(base, ids, pkg, from) {
    var f = document.createElement('form');
    f.method = 'post';
    f.action = base;
    f.hidden = true;
    function add(name, value) {
      var i = document.createElement('input');
      i.type = 'hidden'; i.name = name; i.value = value;
      f.appendChild(i);
    }
    add('intent', 'select');
    ids.forEach(function (id) { add('service[]', id); });
    if (pkg) add('package', pkg);
    if (from) add('from', from);
    document.body.appendChild(f);
    f.submit();
  }

  function replay(el, cls) {
    if (!el || reduced) return;
    el.classList.remove(cls);
    void el.offsetWidth;
    el.classList.add(cls);
  }

  Array.prototype.forEach.call(roots, init);

  function init(root) {
    var from     = root.getAttribute('data-svc-from') || '';
    var pageName = root.getAttribute('data-svc-name') || '';
    var base     = root.getAttribute('data-svc-contact') || 'contact';
    var form     = root.querySelector('[data-svc-form]');
    var tablist  = root.querySelector('[data-svc-tabs]');
    var tabs     = $$('[data-svc-tab]', root);
    var panes    = $$('[data-svc-pane]', root);
    var ink      = root.querySelector('.svc-tabs__ink');
    var boxes    = $$('[data-svc-add]', root);
    var tray     = root.querySelector('[data-svc-tray]');
    var countEl  = root.querySelector('[data-svc-count]');
    var tn       = root.querySelector('[data-svc-tn]');
    var list     = root.querySelector('[data-svc-list]');
    var pkg      = root.querySelector('[data-svc-pkg]');
    var clearBtn = root.querySelector('[data-svc-clear]');
    var more     = root.querySelector('[data-svc-more]');
    var live     = root.querySelector('[data-svc-live]');
    var pkLinks  = $$('[data-svc-pklink]', root);
    var pkCards  = $$('[data-svc-pkcard]', root);
    var pkRow    = root.querySelector('[data-svc-in]');

    root.classList.add('svc--js');

    /* ---------------- tabs ---------------- */
    var current = 0;
    var mqH = window.matchMedia('(max-width: 1179px)');

    tabs.forEach(function (t, i) {
      var p = panes[i];
      if (!p) return;
      p.setAttribute('role', 'tabpanel');
      p.setAttribute('aria-labelledby', t.id);
      p.setAttribute('tabindex', '0');
      if (t.getAttribute('aria-selected') === 'true') current = i;
    });

    function placeInk(instant) {
      if (!ink || !tabs[current]) return;
      var t = tabs[current];
      if (instant) ink.style.transition = 'none';
      ink.style.width = t.offsetWidth + 'px';
      ink.style.height = t.offsetHeight + 'px';
      ink.style.transform = 'translate(' + t.offsetLeft + 'px,' + t.offsetTop + 'px)';
      if (instant) { void ink.offsetWidth; ink.style.transition = ''; }
      tablist.classList.add('has-ink');
    }

    function keepTabVisible(t) {
      if (!mqH.matches || !tablist) return;
      var l = t.offsetLeft, r = l + t.offsetWidth, sl = tablist.scrollLeft, w = tablist.clientWidth;
      if (l < sl + 8) tablist.scrollTo({ left: Math.max(0, l - 24), behavior: reduced ? 'auto' : 'smooth' });
      else if (r > sl + w - 8) tablist.scrollTo({ left: r - w + 24, behavior: reduced ? 'auto' : 'smooth' });
    }

    function select(i, opts) {
      opts = opts || {};
      if (i < 0 || i >= tabs.length) return;
      current = i;
      tabs.forEach(function (t, n) {
        var on = n === i;
        t.setAttribute('aria-selected', on ? 'true' : 'false');
        t.setAttribute('tabindex', on ? '0' : '-1');
        if (panes[n]) panes[n].hidden = !on;
      });
      placeInk(!!opts.instant);
      keepTabVisible(tabs[i]);
      if (opts.focus) tabs[i].focus();
      if (opts.animate) replay(panes[i], 'is-enter');
    }

    tabs.forEach(function (t, i) {
      t.addEventListener('click', function () { if (i !== current) select(i, { animate: true }); });
    });
    if (tablist) {
      tablist.addEventListener('keydown', function (e) {
        var n = null;
        if (e.key === 'ArrowRight' || e.key === 'ArrowDown') n = (current + 1) % tabs.length;
        else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') n = (current - 1 + tabs.length) % tabs.length;
        else if (e.key === 'Home') n = 0;
        else if (e.key === 'End') n = tabs.length - 1;
        if (n === null) return;
        e.preventDefault();
        select(n, { focus: true, animate: true });
      });
    }
    function edges() {
      if (!tablist) return;
      var sl = tablist.scrollLeft, over = tablist.scrollWidth - tablist.clientWidth;
      tablist.classList.toggle('is-fl', mqH.matches && sl > 4);
      tablist.classList.toggle('is-fr', mqH.matches && sl < over - 4);
    }
    if (tablist) tablist.addEventListener('scroll', edges, { passive: true });

    function orient() {
      if (tablist) tablist.setAttribute('aria-orientation', mqH.matches ? 'horizontal' : 'vertical');
      placeInk(true);
      edges();
    }
    if (mqH.addEventListener) mqH.addEventListener('change', orient); else if (mqH.addListener) mqH.addListener(orient);
    var rt = null;
    window.addEventListener('resize', function () { clearTimeout(rt); rt = setTimeout(function () { placeInk(true); edges(); }, 120); });

    /* a link to a card or a category opens its tab */
    function fromHash() {
      var h = location.hash.slice(1);
      if (!h) return false;
      var el = document.getElementById(h);
      if (!el || !root.contains(el)) return false;
      var p = el.closest('[data-svc-pane]');
      var i = panes.indexOf(p);
      if (i >= 0) { select(i, { instant: true }); return true; }
      return false;
    }
    select(current, { instant: true });
    orient();
    fromHash();

    /* the tray only casts its shadow while it floats over the cards */
    var end = root.querySelector('[data-svc-end]');
    if (end && tray && 'IntersectionObserver' in window) {
      new IntersectionObserver(function (es) {
        var e = es[es.length - 1];
        tray.classList.toggle('is-float', !e.isIntersecting && e.boundingClientRect.top > 0);
      }, { rootMargin: '0px 0px -12px 0px' }).observe(end);
    }
    window.addEventListener('hashchange', fromHash);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { placeInk(true); });

    inView(root.querySelector('.svc-panes') || root, function () { replay(panes[current], 'is-enter'); });
    if (pkRow) inView(pkRow, function () { pkRow.classList.add('is-in'); });

    /* ---------------- the brief ---------------- */
    var state = load();
    var byId = {};
    boxes.forEach(function (b) { byId[b.value] = b; });

    function has(id) { return state.items.some(function (it) { return it.id === id; }); }
    function metaOf(b) {
      var card = b.closest('[data-svc-card]');
      return { id: b.value, name: card ? card.getAttribute('data-name') : b.value, page: pageName, pageKey: from };
    }

    /* the page may come back with boxes already ticked (back/forward cache, form restore) */
    boxes.forEach(function (b) {
      if (has(b.value)) b.checked = true;
      else if (b.checked) state.items.push(metaOf(b));
    });
    if (pkg) {
      if (state.package) {
        var found = $$('option', pkg).some(function (o) { return o.value === state.package; });
        if (!found) {   // chosen on another page where this package is offered: keep it
          var o = document.createElement('option');
          o.value = state.package;
          o.textContent = state.packageName || state.package;
          pkg.appendChild(o);
        }
        pkg.value = state.package;
      } else if (pkg.value) {
        state.package = pkg.value;
      }
    }

    var first = true, lastN = -1;
    function say(msg) { if (live && msg) { live.textContent = ''; setTimeout(function () { live.textContent = msg; }, 40); } }
    function word(n) { return n === 1 ? '1 service' : n + ' services'; }

    function render(msg) {
      var n = state.items.length;
      var ids = state.items.map(function (it) { return it.id; });

      root.classList.toggle('has-brief', n > 0);
      if (countEl) {
        countEl.textContent = pad(n);
        if (!first && n !== lastN) replay(countEl, 'is-bump');
      }
      if (tn) tn.textContent = n ? word(n) : '';
      if (clearBtn) clearBtn.hidden = n === 0;
      if (more) more.hidden = n === 0;
      if (!n && tray) { tray.classList.remove('is-open'); if (more) more.setAttribute('aria-expanded', 'false'); }

      if (list) {
        list.innerHTML = '';
        state.items.forEach(function (it) {
          var li = document.createElement('li');
          li.className = 'svc-chip';
          var s = document.createElement('span');
          s.className = 'svc-chip__n';
          s.textContent = it.name;
          li.appendChild(s);
          if (it.pageKey && it.pageKey !== from && it.page) {
            var p = document.createElement('span');
            p.className = 'svc-chip__p';
            p.textContent = it.page;
            li.appendChild(p);
            li.title = it.name + ' · ' + it.page;
          }
          var x = document.createElement('button');
          x.type = 'button';
          x.className = 'svc-chip__x';
          x.setAttribute('data-svc-rm', it.id);
          x.setAttribute('aria-label', 'Remove ' + it.name + ' from your brief');
          x.innerHTML = X_ICON;
          li.appendChild(x);
          list.appendChild(li);
        });
        list.hidden = n === 0;
      }

      boxes.forEach(function (b) {
        var card = b.closest('[data-svc-card]');
        if (card) card.classList.toggle('is-picked', b.checked);
      });
      tabs.forEach(function (t, i) {
        var badge = t.querySelector('[data-svc-tabpick]');
        if (!badge || !panes[i]) return;
        var k = $$('[data-svc-add]', panes[i]).filter(function (b) { return b.checked; }).length;
        var was = badge.textContent;
        badge.textContent = k ? String(k) : '';
        badge.hidden = !k;
        var sr = t.querySelector('[data-svc-tabsr]');
        if (sr) sr.textContent = k ? ', ' + k + ' in your brief' : '';
        if (k && was !== String(k) && !first) replay(badge, 'is-bump');
      });

      var chosen = pkg ? pkg.value : state.package;
      pkCards.forEach(function (c) {
        var on = c.getAttribute('data-svc-pkcard') === chosen;
        c.classList.toggle('is-chosen', on);
        var tag = c.querySelector('[data-svc-pksel]');
        if (tag) tag.hidden = !on;
      });
      /* the package cards are submit buttons now, so there is no href to keep in step: the brief
         and the chosen package are gathered when the form is submitted */

      if (!first) say(msg);
      first = false;
      lastN = n;
    }

    function persist() { save(state); }

    boxes.forEach(function (b) {
      b.addEventListener('change', function () {
        var m = metaOf(b);
        if (b.checked) { if (!has(b.value)) state.items.push(m); }
        else state.items = state.items.filter(function (it) { return it.id !== b.value; });
        persist();
        var n = state.items.length;
        render(m.name + (b.checked ? ' added to' : ' removed from') + ' your brief. ' + word(n) + ' in total.');
      });
    });

    if (list) {
      list.addEventListener('click', function (e) {
        var x = e.target.closest('[data-svc-rm]');
        if (!x) return;
        var id = x.getAttribute('data-svc-rm');
        var item = state.items.filter(function (it) { return it.id === id; })[0];
        var idx = state.items.indexOf(item);
        state.items = state.items.filter(function (it) { return it.id !== id; });
        if (byId[id]) byId[id].checked = false;
        persist();
        render((item ? item.name : 'Service') + ' removed from your brief. ' + word(state.items.length) + ' in total.');
        var next = list.querySelectorAll('[data-svc-rm]')[Math.min(idx, state.items.length - 1)];
        var go = root.querySelector('[data-svc-go]');
        if (next) next.focus(); else if (go) go.focus();
      });
    }

    if (clearBtn) {
      clearBtn.addEventListener('click', function () {
        state.items = [];
        boxes.forEach(function (b) { b.checked = false; });
        persist();
        render('Brief cleared.');
        var go = root.querySelector('[data-svc-go]');
        if (go) go.focus();
      });
    }

    if (pkg) {
      pkg.addEventListener('change', function () {
        state.package = pkg.value;
        state.packageName = pkg.value ? pkg.options[pkg.selectedIndex].textContent : '';
        persist();
        render(pkg.value ? 'Package set to ' + state.packageName + '.' : 'Package cleared.');
      });
    }

    pkLinks.forEach(function (a) {
      a.addEventListener('click', function () {
        var k = a.getAttribute('data-svc-pklink');
        var opt = pkg ? $$('option', pkg).filter(function (o) { return o.value === k; })[0] : null;
        state.package = k;
        state.packageName = opt ? opt.textContent : k;
        persist();
      });
    });

    if (more && tray) {
      more.addEventListener('click', function () {
        var open = !tray.classList.contains('is-open');
        tray.classList.toggle('is-open', open);
        more.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    }

    /* Continue: every service in the brief (this page and earlier ones), the package and this page */
    if (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        /* which control was used decides what travels: "Enquire" sends that one service on its own,
           a package card sends the brief with that package, anything else sends the brief as it is */
        var hit = e.submitter || null;
        var ids, chosen = pkg ? pkg.value : '';
        if (hit && hit.name === 'only') {
          ids = [hit.value];
          chosen = '';
        } else {
          ids = state.items.map(function (it) { return it.id; });
          if (hit && hit.name === 'pick_package') chosen = hit.value;
        }
        postSelection(base, ids, chosen, from);
      });
    }

    render('');
  }
})();
