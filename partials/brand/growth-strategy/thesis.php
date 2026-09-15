<?php /* DRAFT COPY — review before launch */
/* 06 The growth thesis — a one-page memo on paper. Phrases carry highlight marks that sweep in; margin
   annotations from the evidence agent and the strategist write in (BDH.type) as the memo scrolls into view.
   The HTML holds the finished memo. <!-- PLACEHOLDER: illustrative memo content, confirm before launch --> */
$cgs_th_blocks = [ // heading, paragraph HTML (a <mark data-n> links to a note), notes [who, side, text]
    ['Where growth comes from',
     'Most new revenue over the next two years comes from <mark data-n="0">Segment C, digital-first entrants</mark>, who are growing fastest and have no brand they trust yet. Segment D follows, where our fit is strongest.',
     [['Agent · evidence', 'l', 'Supported by 9 of 14 interviews and category growth data. Confidence: high.']]],
    ['In what order',
     'Win C first with a specialist offer at a mid price. Use that proof to <mark data-n="1">enter D within two quarters</mark>. Hold A; do not chase it on price.',
     [['Strategist', 'r', 'Sequenced on readiness, not size. Sales can sell this in Q1.']]],
    ['What has to be true',
     'Buyers in C must value expertise over breadth, and we must be able to <mark data-n="2">onboard in days, not weeks</mark>. If either fails the test in the first move, we stop and re-rank.',
     [['Agent · evidence', 'l', 'Onboarding time is unproven. Flagged as the riskiest assumption.'], ['Strategist', 'r', 'Agreed — make it the first measure.']]],
    ['What we will not do',
     'We will not launch in all six segments, and we will not <mark data-n="3">compete with Brand C on premium price</mark>.',
     [['Leadership', 'r', 'Signed. Review at the end of the first move.']]],
];
?>
<section class="band cgs-thesis" id="thesis" aria-labelledby="thesis-t">
  <!-- PLACEHOLDER: illustrative memo content and margin notes, confirm before launch -->
  <div class="wrap">
    <div class="cgs-head" data-rv>
      <div class="cgs-head__t">
        <p class="cgs-eye"><b>06</b><i></i><?= e($CAP['offer'][3][0]) ?> · <?= e($CAP['offer'][3][2]) ?></p>
        <h2 class="h2" id="thesis-t"><span class="g">The whole strategy</span> on one page a board can argue with.</h2>
      </div>
      <div class="cgs-head__l">
        <p class="lead"><?= e($CAP['offer'][3][1]) ?> Every line is traced to evidence, and the margin shows who checked it.</p>
      </div>
    </div>

    <div class="cgs-th" data-cgs-thesis>
      <article class="cgs-memo" aria-label="Example growth thesis memo">
        <header class="cgs-memo__head">
          <p class="cgs-memo__k"><span>Memo</span><span>Your brand · growth thesis</span></p>
          <dl class="cgs-memo__meta">
            <div><dt>To</dt><dd>Leadership team</dd></div>
            <div><dt>From</dt><dd>Growth strategy lead</dd></div>
            <div><dt>Status</dt><dd>Draft 3 · for sign-off</dd></div>
          </dl>
          <p class="cgs-memo__title">Win the fast-growing specialists first, then widen.</p>
        </header>

        <?php foreach ($cgs_th_blocks as $cgs_bi => $cgs_bl): ?>
          <div class="cgs-memo__block" data-cgs-block>
            <div class="cgs-memo__body">
              <h3 class="cgs-memo__h"><span><?= sprintf('%02d', $cgs_bi + 1) ?></span><?= e($cgs_bl[0]) ?></h3>
              <p class="cgs-memo__p"><?= $cgs_bl[1] ?></p>
            </div>
            <?php foreach ($cgs_bl[2] as $cgs_nt): ?>
              <aside class="cgs-memo__note cgs-memo__note--<?= $cgs_nt[1] ?><?= $cgs_nt[0] === 'Strategist' || $cgs_nt[0] === 'Leadership' ? ' is-person' : '' ?>">
                <b><?= e($cgs_nt[0]) ?></b>
                <span class="cgs-memo__nt" data-cgs-type><?= e($cgs_nt[1] === 'l' ? $cgs_nt[2] : $cgs_nt[2]) ?></span>
              </aside>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>

        <footer class="cgs-memo__foot">
          <span>1 / 1</span><span>Evidence pack refs 01–06</span><span class="cgs-illus">Illustrative</span>
        </footer>
      </article>
    </div>
  </div>
</section>
