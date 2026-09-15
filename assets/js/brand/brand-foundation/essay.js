/* §1 essay — note calls toggle their sidenote. Desktop: every note title shows in the gutter and
   the text slides in. Phones: the note opens inline under its paragraph. Escape closes. */
(function () {
  'use strict';
  var root = document.querySelector('.cbf-essay'); if (!root) return;
  var refs = [].slice.call(root.querySelectorAll('.cbf-essay__ref'));
  function set(btn, on) {
    var note = document.getElementById(btn.getAttribute('aria-controls'));
    btn.setAttribute('aria-expanded', String(on));
    if (note) note.classList.toggle('is-open', on);
  }
  refs.forEach(function (btn) {
    var body = document.getElementById(btn.getAttribute('aria-controls'));
    if (body) {   // wrap the note text so the 0fr → 1fr row transition has a single child
      var nt = body.querySelector('.cbf-essay__nt');
      if (nt && !nt.firstElementChild) { var s = document.createElement('span'); s.textContent = nt.textContent; nt.textContent = ''; nt.appendChild(s); }
    }
    btn.addEventListener('click', function () {
      var on = btn.getAttribute('aria-expanded') !== 'true';
      if (window.matchMedia('(max-width:720px)').matches) refs.forEach(function (b) { if (b !== btn) set(b, false); });
      set(btn, on);
    });
    btn.addEventListener('keydown', function (e) { if (e.key === 'Escape') set(btn, false); });
  });
  /* on wide screens open note 1 once the essay is read into, so the gutter shows how it works */
  if (window.BDH && window.matchMedia('(min-width:721px)').matches && refs[0]) {
    BDH.inView(root.querySelector('.cbf-essay__row'), function () { set(refs[0], true); });
  }
})();
