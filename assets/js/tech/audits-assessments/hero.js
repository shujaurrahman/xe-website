/* Audits & Assessments · hero — the register behaves like the register.
   Two jobs. One: a single scan sweep down the rows on first entry (.is-in fills the summary bars,
   .is-scan runs the line and pops the severity chips). Two: the four numeric column headers are
   upgraded into sort controls, so a reader can ask the extract the question the page is about —
   what is worst, what costs most, what is cheapest, what comes first. The headers ship as plain
   text and the rows ship in fix order, so without JS nothing is dead and nothing is missing. */
(function () {
  'use strict';
  if (!window.BDH) return;
  var reg = document.querySelector('[data-taa-reg]');
  if (!reg) return;

  var scroll = reg.querySelector('.taa-reg__scroll');

  /* arms the zero state of the summary bars — without JS the CSS leaves them filled */
  reg.classList.add('is-anim');

  BDH.inView(reg, function () {
    reg.classList.add('is-in');
    if (BDH.reduced) return;
    if (scroll) {
      var body = scroll.querySelector('tbody');
      var h = (body ? body.getBoundingClientRect().height : scroll.getBoundingClientRect().height) + 40;
      scroll.style.setProperty('--h', Math.round(h) + 'px');
    }
    reg.classList.add('is-scan');
  }, { threshold: 0.2 });

  /* ---------- sortable columns ------------------------------------------- */
  var table = reg.querySelector('.taa-reg__tbl');
  var tbody = table && table.querySelector('tbody');
  var rank  = reg.querySelector('[data-taa-rank]');
  if (!table || !tbody) return;

  /* header index → row attribute, readout wording and the direction a first click should give */
  var COLS = {
    3: { key: 'sev',   label: 'severity',     dir: -1 },
    4: { key: 'cost',  label: 'monthly cost', dir: -1 },
    5: { key: 'eff',   label: 'effort',       dir:  1 },
    6: { key: 'order', label: 'fix order',    dir:  1 }
  };

  var heads = BDH.$$('thead th', table);
  var rows  = BDH.$$('tbody tr', tbody);
  var cur   = 'order', curDir = 1;

  function num(tr, key) { return parseFloat(tr.getAttribute('data-' + key)) || 0; }

  function apply(key, dir, label) {
    var sorted = rows.slice().sort(function (a, b) {
      var d = (num(a, key) - num(b, key)) * dir;
      /* a stable, readable tie-break: the fix order the audit published */
      return d !== 0 ? d : num(a, 'order') - num(b, 'order');
    });
    var frag = document.createDocumentFragment();
    sorted.forEach(function (tr) { frag.appendChild(tr); });
    tbody.appendChild(frag);
    cur = key; curDir = dir;
    if (rank) rank.textContent = label + (dir === 1 ? ', lowest first' : ', highest first');
    heads.forEach(function (th, i) {
      var c = COLS[i];
      if (!c) return;
      th.setAttribute('aria-sort', c.key === key ? (dir === 1 ? 'ascending' : 'descending') : 'none');
      var btn = th.querySelector('.taa-reg__sort');
      if (btn) btn.setAttribute('data-dir', c.key === key ? (dir === 1 ? 'up' : 'down') : 'none');
    });
  }

  heads.forEach(function (th, i) {
    var c = COLS[i];
    if (!c) return;
    var text = th.textContent.trim();
    var btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'taa-reg__sort';
    btn.setAttribute('data-dir', 'none');
    btn.innerHTML = '<span></span><i class="taa-reg__sorti" aria-hidden="true"></i>'
                  + '<span class="bdh-sr"> — sort the extract by this column</span>';
    btn.firstChild.textContent = text;
    th.textContent = '';
    th.appendChild(btn);
    th.classList.add('taa-reg__th');
    th.setAttribute('aria-sort', c.key === cur ? 'ascending' : 'none');
    btn.addEventListener('click', function () {
      apply(c.key, c.key === cur ? -curDir : c.dir, c.label);
    });
  });

  var first = heads[6] && heads[6].querySelector('.taa-reg__sort');
  if (first) first.setAttribute('data-dir', 'up');
})();
