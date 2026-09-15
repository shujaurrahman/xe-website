/* Brand Identity · onward — hovering or focusing a spine reads its one-liner under the shelf. */
(function () {
  'use strict';
  var root = document.querySelector('.cbi-ow'); if (!root) return;
  var out = root.querySelector('.cbi-ow__readt'); if (!out) return;
  var base = out.textContent;
  Array.prototype.forEach.call(root.querySelectorAll('.cbi-ow__spine[data-line]'), function (a) {
    function on() { out.textContent = a.getAttribute('data-line'); }
    function off() { out.textContent = base; }
    a.addEventListener('mouseenter', on); a.addEventListener('focus', on);
    a.addEventListener('mouseleave', off); a.addEventListener('blur', off);
  });
})();
