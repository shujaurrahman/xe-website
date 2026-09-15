<?php /* DRAFT COPY — review before launch */
/* 03 The research ledger — the six $CAP offer items as ledger rows: the question each one answers,
   the method, and what comes out. A documentary photo beside the ledger changes with the hovered or
   focused row (ledger.js); without JS the first photo shows. */
$cgs_lg_rows = [ // question, method, photo file, photo alt — keyed to $CAP['offer'] order (DRAFT COPY)
    ['Are we fighting for the part of the market that is actually growing?', 'Desk research, category data, share-of-search and analyst reads, mapped segment by segment.', 'l-map.jpg', 'A researcher marks up printed maps and notes spread across a table'],
    ['If sales could call only three kinds of customer next quarter, which three?', 'Your sales and CRM data, won and lost interviews, then a weighted score for every segment.', 'l-customer.jpg', 'Two people in conversation across a table during a customer interview'],
    ['Where could the brand stand that no competitor can quickly follow?', 'Competitor audit, message and offer mapping, store and channel walks, review mining.', 'l-field.jpg', 'A researcher takes notes while walking a retail street'],
    ['What single argument will leadership fund, and what would prove it wrong?', 'Synthesis workshop with leadership; every claim traced back to evidence in the pack.', 'l-thesis.jpg', 'A hand writes a short memo on paper beside a laptop'],
    ['Who does what on Monday, and what waits until the first move has worked?', 'Moves scored on return and readiness, then sequenced with owners, measures and dates.', 'l-moves.jpg', 'A team arranges paper notes into columns on a wall'],
    ['Which number, two months in, tells us to keep going or to stop?', 'A north-star metric broken into drivers and leading indicators, with baselines and sources.', 'l-measure.jpg', 'Printed charts and a notebook reviewed on a desk'],
];
?>
<section class="band band--alt cgs-ledger" id="ledger" aria-labelledby="ledger-t">
  <div class="wrap">
    <div class="cgs-head" data-rv>
      <div class="cgs-head__t">
        <p class="cgs-eye"><b>03</b><i></i>What the work covers</p>
        <h2 class="h2" id="ledger-t"><?= $CAP['offer_title'] ?></h2>
      </div>
      <div class="cgs-head__l">
        <p class="lead"><?= e($CAP['offer_lead']) ?></p>
      </div>
    </div>

    <div class="cgs-lg" data-cgs-ledger>
      <div class="cgs-lg__table" role="table" aria-label="The six parts of a growth strategy: question, method and output">
        <div class="cgs-lg__cols" role="row">
          <span role="columnheader">No.</span><span role="columnheader">The question</span><span role="columnheader">How we answer it</span><span role="columnheader">Output</span>
        </div>
        <?php foreach ($CAP['offer'] as $cgs_li => $cgs_o): $cgs_r = $cgs_lg_rows[$cgs_li]; ?>
          <div class="cgs-lg__row<?= $cgs_li === 0 ? ' is-on' : '' ?>" role="row" tabindex="0" data-cgs-row="<?= $cgs_li ?>" aria-describedby="ledger-m<?= $cgs_li ?>">
            <span class="cgs-lg__n" role="cell"><?= sprintf('%02d', $cgs_li + 1) ?></span>
            <div class="cgs-lg__q" role="cell">
              <h3 class="cgs-lg__h"><?= e($cgs_o[0]) ?></h3>
              <p class="cgs-lg__ask"><?= e($cgs_r[0]) ?></p>
            </div>
            <div class="cgs-lg__m" role="cell" id="ledger-m<?= $cgs_li ?>">
              <p><?= e($cgs_r[1]) ?></p>
              <p class="cgs-lg__d"><?= e($cgs_o[1]) ?></p>
            </div>
            <span class="cgs-lg__o" role="cell"><span class="cgs-lg__tag"><?= e($cgs_o[2]) ?></span></span>
          </div>
        <?php endforeach; ?>
      </div>

      <aside class="cgs-lg__side" aria-hidden="true">
        <div class="cgs-lg__frame">
          <!-- PLACEHOLDER: reference photography (Unsplash) — replace with own field research imagery before launch -->
          <?php foreach ($cgs_lg_rows as $cgs_li => $cgs_r): ?>
            <figure class="cgs-photo cgs-lg__ph<?= $cgs_li === 0 ? ' is-on' : '' ?>" data-cgs-ph="<?= $cgs_li ?>">
              <img src="<?= xe_url('assets/imgs/brand/growth-strategy/' . $cgs_r[2]) ?>" alt="" width="800" height="1000" loading="lazy" decoding="async">
            </figure>
          <?php endforeach; ?>
        </div>
        <div class="cgs-lg__cap">
          <span class="cgs-lg__cn"><b data-cgs-phn>01</b> / <?= sprintf('%02d', count($CAP['offer'])) ?></span>
          <span class="cgs-lg__ct" data-cgs-pht><?= e($CAP['offer'][0][0]) ?></span>
        </div>
      </aside>
    </div>
  </div>
</section>
