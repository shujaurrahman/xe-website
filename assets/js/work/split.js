/* Work · before / after — the comparison already works from the radio group and pure CSS. This adds
   the drag handle on top of it: pointer and touch dragging, plus arrow keys and Home/End once the
   handle has focus. Under reduced motion the handle still works; nothing animates on its own. */
(function () {
  'use strict';
  var root = document.querySelector('[data-wrk-split]');
  if (!root) return;

  var stage = root.querySelector('.wrk-split__stage');
  var grab  = root.querySelector('[data-wrk-grab]');
  var radios = Array.prototype.slice.call(root.querySelectorAll('.wrk-split__r'));
  if (!stage || !grab || radios.length !== 3) return;

  var pos = 50;
  /* below 600px the tiles are one column and the divider runs horizontally (see split.css) */
  var vert = function () { return window.matchMedia && window.matchMedia('(max-width:600px)').matches; };

  function set(p, live) {
    pos = Math.max(0, Math.min(100, p));
    stage.style.setProperty('--split', pos + '%');
    grab.setAttribute('aria-valuenow', String(Math.round(pos)));
    grab.setAttribute('aria-valuetext', Math.round(pos) + ' per cent before the system, ' + (100 - Math.round(pos)) + ' per cent after');
    if (!live) syncRadio();
  }
  /* keep the radio group honest, so the control and the handle never disagree */
  function syncRadio() {
    var want = pos > 75 ? 0 : (pos < 25 ? 2 : 1);
    if (!radios[want].checked) { radios[want].checked = true; }
  }

  grab.hidden = false;
  grab.setAttribute('role', 'slider');
  grab.setAttribute('aria-valuemin', '0');
  grab.setAttribute('aria-valuemax', '100');
  grab.setAttribute('tabindex', '0');
  function axis() { grab.setAttribute('aria-orientation', vert() ? 'vertical' : 'horizontal'); }
  axis();
  window.addEventListener('resize', axis);
  set(50, true);

  radios.forEach(function (r) {
    r.addEventListener('change', function () {
      if (!r.checked) return;
      var v = parseFloat(r.value);
      if (!isNaN(v)) { pos = v; stage.style.setProperty('--split', v + '%'); grab.setAttribute('aria-valuenow', String(v)); }
    });
  });

  function fromEvent(e) {
    var r = stage.getBoundingClientRect();
    if (vert()) return r.height ? ((e.clientY - r.top) / r.height) * 100 : null;
    return r.width ? ((e.clientX - r.left) / r.width) * 100 : null;
  }

  function down(e) {
    if (e.button !== undefined && e.button !== 0) return;
    root.classList.add('is-drag');
    if (grab.setPointerCapture && e.pointerId !== undefined) {
      try { grab.setPointerCapture(e.pointerId); } catch (err) {}
    }
    e.preventDefault();
    grab.focus();
  }
  function move(e) {
    if (!root.classList.contains('is-drag')) return;
    var p = fromEvent(e);
    if (p !== null) set(p, true);
    e.preventDefault();
  }
  function up() {
    if (!root.classList.contains('is-drag')) return;
    root.classList.remove('is-drag');
    syncRadio();
  }

  grab.addEventListener('pointerdown', down);
  grab.addEventListener('pointermove', move);
  grab.addEventListener('pointerup', up);
  grab.addEventListener('pointercancel', up);
  window.addEventListener('pointerup', up);

  grab.addEventListener('keydown', function (e) {
    var step = e.shiftKey ? 10 : 4, p = null;
    if (e.key === 'ArrowLeft' || e.key === 'ArrowDown') p = pos - step;
    else if (e.key === 'ArrowRight' || e.key === 'ArrowUp') p = pos + step;
    else if (e.key === 'Home') p = 0;
    else if (e.key === 'End') p = 100;
    if (p === null) return;
    e.preventDefault();
    set(p, false);
  });

  /* a click anywhere on the stage jumps the divider there */
  stage.addEventListener('click', function (e) {
    if (e.target === grab || grab.contains(e.target)) return;
    var p = fromEvent(e);
    if (p !== null) set(p, false);
  });
})();
