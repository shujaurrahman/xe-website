/* AI Infrastructure & Cloud · deliver — the handover repository as a real tree view.
   The HTML ships every directory expanded and the first file open, so the section reads with scripting
   off. This adds the ARIA tree behaviour on top: roving tabindex, Up/Down through the visible items,
   Right to open a directory or step into it, Left to close it or step out, Home/End, Enter or Space to
   show a file. Nothing here hides content the reader has not asked to hide. */
(function () {
  'use strict';
  if (!window.XE) return;
  var root = document.querySelector('[data-dv-browser]');
  if (!root) return;

  var tree = root.querySelector('[data-dv-tree]');
  var panes = XE.$$('[data-dv-pane]', root);
  var pathEl = root.querySelector('[data-dv-path]');
  var langEl = root.querySelector('[data-dv-lang]');
  var status = root.querySelector('[data-dv-status]');
  if (!tree || !panes.length) return;

  var dirs = XE.$$('.tic-dv__dir', tree);
  var files = XE.$$('.tic-dv__file', tree);
  if (!dirs.length || !files.length) return;

  /* The panes carry the path and the language chip, so the header can follow the selection. */
  var meta = {};
  panes.forEach(function (p) {
    var fp = p.querySelector('.tic-dv__fp');
    meta[p.getAttribute('data-dv-pane')] = fp ? fp.textContent.trim() : '';
  });
  var langs = {};
  files.forEach(function (f) {
    var l = f.querySelector('.tic-dv__lang');
    langs[f.getAttribute('data-dv-file')] = l ? l.textContent.trim() : '';
  });

  function kidsOf(dir) { return dir.parentNode.querySelector('.tic-dv__kids'); }
  function isOpen(dir) { return dir.getAttribute('aria-expanded') === 'true'; }

  /* every treeitem the reader can currently reach, in visual order */
  function visible() {
    var out = [];
    dirs.forEach(function (d) {
      out.push(d);
      if (!isOpen(d)) return;
      XE.$$('.tic-dv__file', d.parentNode).forEach(function (f) { out.push(f); });
    });
    return out;
  }

  function focusItem(el) {
    if (!el) return;
    visible().concat(files, dirs).forEach(function (i) { i.setAttribute('tabindex', '-1'); });
    el.setAttribute('tabindex', '0');
    el.focus();
  }

  function setOpen(dir, open) {
    dir.setAttribute('aria-expanded', open ? 'true' : 'false');
    var k = kidsOf(dir);
    if (k) k.hidden = !open;
  }

  function select(key, announce) {
    files.forEach(function (f) {
      var on = f.getAttribute('data-dv-file') === key;
      f.classList.toggle('is-on', on);
      f.setAttribute('aria-selected', on ? 'true' : 'false');
    });
    panes.forEach(function (p) {
      var on = p.getAttribute('data-dv-pane') === key;
      if (on && p.hidden) { p.hidden = false; p.style.animation = 'none'; void p.offsetWidth; p.style.animation = ''; }
      else if (!on) p.hidden = true;
    });
    if (pathEl) pathEl.textContent = meta[key] || '';
    if (langEl) langEl.textContent = langs[key] || '';
    if (announce && status) status.textContent = 'Showing ' + (meta[key] || key) + '.';
  }

  dirs.forEach(function (d) {
    d.addEventListener('click', function () { setOpen(d, !isOpen(d)); focusItem(d); });
  });
  files.forEach(function (f) {
    f.addEventListener('click', function () { select(f.getAttribute('data-dv-file'), true); focusItem(f); });
  });

  tree.addEventListener('keydown', function (e) {
    var el = e.target.closest('[role="treeitem"]');
    if (!el) return;
    var list = visible(), i = list.indexOf(el);
    var dir = el.classList.contains('tic-dv__dir');
    var k = e.key;

    if (k === 'ArrowDown') { focusItem(list[Math.min(list.length - 1, i + 1)]); }
    else if (k === 'ArrowUp') { focusItem(list[Math.max(0, i - 1)]); }
    else if (k === 'Home') { focusItem(list[0]); }
    else if (k === 'End') { focusItem(list[list.length - 1]); }
    else if (k === 'ArrowRight') {
      if (!dir) return;
      if (!isOpen(el)) { setOpen(el, true); }
      else { var kids = XE.$$('.tic-dv__file', el.parentNode); if (kids.length) focusItem(kids[0]); }
    } else if (k === 'ArrowLeft') {
      if (dir && isOpen(el)) { setOpen(el, false); }
      else if (!dir) {
        var pid = el.getAttribute('data-dv-parent');
        for (var n = 0; n < dirs.length; n++) { if (dirs[n].getAttribute('data-dv-dir') === pid) { focusItem(dirs[n]); break; } }
      } else return;
    } else if (k === 'Enter' || k === ' ' || k === 'Spacebar') {
      if (dir) setOpen(el, !isOpen(el));
      else select(el.getAttribute('data-dv-file'), true);
    } else { return; }
    e.preventDefault();
  });
})();
