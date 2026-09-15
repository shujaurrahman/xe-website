<?php /* DRAFT COPY — review before launch */
/* 8 · Phased migration — four state lanes (Keep, Endorse, Merge, Retire) across six quarters.
   As the timeline plays, brand chips move between lanes (FLIP) and the quarter log explains what
   moved, the risk watched and the measure. HTML = Q1 (today). Illustrative throughout. */
/* PLACEHOLDER: illustrative migration sequence and timings — confirm before launch */
$cba_lanes = [
    'keep'    => ['Keep', 'Stays as it is'],
    'endorse' => ['Endorse', 'Gains the parent’s endorsement'],
    'merge'   => ['Merge', 'Folds into another brand or tier'],
    'retire'  => ['Retire', 'Withdrawn from customer view'],
];
$cba_brands = ['a' => 'Sub-brand A', 'b' => 'Sub-brand B', 'c' => 'Sub-brand C', 'd' => 'Sub-brand D', 'e' => 'Endorsed E', 'f' => 'Label F', 'g' => 'Range G'];
$cba_q = [
    // quarter, phase, state map, what moves, risk watched, measure, human gate (or '')
    ['Q1', 'Prepare', ['a' => 'keep', 'b' => 'keep', 'c' => 'keep', 'd' => 'keep', 'e' => 'keep', 'f' => 'keep', 'g' => 'keep'],
        'Today’s portfolio. Nothing moves until the model and the order are signed off.', 'Launching change before service teams are briefed.', 'Baseline: navigation, search share, brand recall.', 'Board signs the model and the migration order.'],
    ['Q2', 'Prepare', ['a' => 'keep', 'b' => 'keep', 'c' => 'keep', 'd' => 'keep', 'e' => 'endorse', 'f' => 'keep', 'g' => 'keep'],
        'Endorsed E takes the parent’s endorsement. Its own name and customers stay.', 'Acquired customers reading the change as a takeover.', 'Retention of Endorsed E customers.', ''],
    ['Q3', 'Move', ['a' => 'keep', 'b' => 'keep', 'c' => 'keep', 'd' => 'merge', 'e' => 'endorse', 'f' => 'retire', 'g' => 'merge'],
        'Range G folds into the Core · Plus · Pro tiers. Sub-brand D begins merging into Sub-brand A. Label F is announced for retirement.', 'Search traffic lost on retired and merged names.', 'Redirect coverage, search share on new names.', 'Market leads confirm readiness in each market.'],
    ['Q4', 'Move', ['a' => 'keep', 'b' => 'keep', 'c' => 'endorse', 'd' => 'merge', 'e' => 'endorse', 'f' => 'retire', 'g' => 'merge'],
        'Sub-brand C moves to endorsed so it can grow outside Market 03 with the parent behind it.', 'Too many visible changes in one season.', 'Customer confusion tickets per 1,000 orders.', ''],
    ['Q5', 'Settle', ['a' => 'keep', 'b' => 'keep', 'c' => 'endorse', 'd' => 'merge:done', 'e' => 'endorse', 'f' => 'retire:done', 'g' => 'merge:done'],
        'Merges complete. Label F is withdrawn; its products carry descriptors under the master brand.', 'Old packaging and signage still in circulation.', 'Share of touchpoints on the new structure.', ''],
    ['Q6', 'Settle', ['a' => 'keep', 'b' => 'keep', 'c' => 'endorse', 'd' => 'merge:done', 'e' => 'endorse', 'f' => 'retire:done', 'g' => 'merge:done'],
        'The new structure holds. Governance takes over: the next launch goes through the new-brand test.', 'Drift back to one-off names for launches.', 'Proposals passing the new-brand test.', 'Board reviews the measures and closes the migration.'],
];
$cba_q0 = $cba_q[0];
?>
<section class="band cba-mig cba-paper" id="migration" aria-labelledby="migration-t">
  <div class="wrap">
    <div class="cba-head" data-rv>
      <div class="cba-head__t">
        <p class="cba-eb"><b>A-107</b><i aria-hidden="true"></i>Migration plan · phased</p>
        <h2 class="h2" id="migration-t"><span class="g">Nothing breaks on the way.</span> Every brand moves in order.</h2>
      </div>
      <div class="cba-head__l">
        <p class="lead"><?= e($CBA_CAP['offer'][4][1]) ?> Play the six quarters to see which brand moves when, and what is watched while it does.</p>
      </div>
    </div>

    <div class="cba-mig__app" data-cba-mig data-q="0">
      <div class="cba-mig__bar">
        <div class="cba-mig__play">
          <button type="button" class="cba-ctl" data-m="prev" aria-label="Previous quarter">‹</button>
          <button type="button" class="cba-ctl cba-ctl--blue" data-m="play" aria-pressed="false">Play</button>
          <button type="button" class="cba-ctl" data-m="next" aria-label="Next quarter">›</button>
        </div>
        <ol class="cba-mig__quarters" aria-label="Quarter">
          <?php foreach ($cba_q as $cba_qi => $cba_qq): ?>
            <li><button type="button" class="cba-mig__qb<?= $cba_qi === 0 ? ' is-on' : '' ?>" data-qi="<?= $cba_qi ?>" aria-pressed="<?= $cba_qi === 0 ? 'true' : 'false' ?>"><b><?= e($cba_qq[0]) ?></b><small><?= e($cba_qq[1]) ?></small></button></li>
          <?php endforeach; ?>
        </ol>
        <span class="cba-illus">Illustrative</span>
      </div>
      <div class="cba-mig__track" aria-hidden="true"><i style="--p:<?= 1 / count($cba_q) ?>"></i></div>

      <div class="cba-mig__grid">
        <div class="cba-mig__board cba-sheet" aria-hidden="true">
          <?php foreach ($cba_lanes as $cba_lk => $cba_ln): ?>
            <div class="cba-mig__lane cba-mig__lane--<?= $cba_lk ?>" data-lane="<?= $cba_lk ?>">
              <p class="cba-mig__lh"><b><?= e($cba_ln[0]) ?></b><small><?= e($cba_ln[1]) ?></small></p>
              <div class="cba-mig__chips">
                <?php foreach ($cba_brands as $cba_bk => $cba_bn): if ($cba_q0[2][$cba_bk] !== $cba_lk) continue; ?>
                  <span class="cba-mig__chip" data-b="<?= $cba_bk ?>"><i></i><?= e($cba_bn) ?><small class="cba-mig__since"></small></span>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <aside class="cba-mig__log" aria-live="polite">
          <p class="cba-mono cba-mono--ink"><span data-m="qname"><?= e($cba_q0[0]) ?></span> · <span data-m="phase"><?= e($cba_q0[1]) ?></span></p>
          <p class="cba-mig__what" data-m="what"><?= e($cba_q0[3]) ?></p>
          <dl class="cba-mig__dl">
            <div><dt>Risk watched</dt><dd data-m="risk"><?= e($cba_q0[4]) ?></dd></div>
            <div><dt>Measure</dt><dd data-m="measure"><?= e($cba_q0[5]) ?></dd></div>
          </dl>
          <p class="cba-mig__gate" data-m="gatewrap"<?= $cba_q0[6] === '' ? ' hidden' : '' ?>><span class="cba-mono cba-mono--ink">People · gate</span><span data-m="gate"><?= e($cba_q0[6]) ?></span></p>
          <p class="cba-mig__agent"><span class="cba-mono cba-mono--blue">Agent</span> tracks every touchpoint still carrying an old name and flags gaps before each gate.</p>
        </aside>
      </div>
      <p class="bdh-sr">Migration timeline: step through six quarters; seven brands move between Keep, Endorse, Merge and Retire, with the risk and measure for each quarter.</p>
    </div>
    <script type="application/json" id="migration-data"><?= json_encode(['brands' => $cba_brands, 'q' => $cba_q], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
  </div>
</section>
