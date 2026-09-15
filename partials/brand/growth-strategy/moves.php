<?php /* DRAFT COPY — review before launch */
/* 08 Now / next / later — a move board. Three horizon columns of move cards, each with an owner, a
   measure and a date. Filter chips by owner re-flow the cards (moves.js, FLIP).
   <!-- PLACEHOLDER: illustrative moves, owners and dates, confirm before launch --> */
$cgs_mv_owners = ['Marketing', 'Product', 'Sales'];
$cgs_mv_cols = [ // key, label, horizon
    ['now', 'Now', 'Next 90 days'], ['next', 'Next', 'Months 4–6'], ['later', 'Later', 'Months 7–12'],
];
$cgs_mv_cards = [ // column, owner, move, measure, date
    ['now', 'Marketing', 'Launch the specialist offer to Segment C', 'Qualified leads from C', 'Q1 · wk 06'],
    ['now', 'Sales', 'Brief the team on the new shortlist and scripts', 'Meetings booked in C', 'Q1 · wk 03'],
    ['now', 'Product', 'Cut onboarding from weeks to days', 'Days to first value', 'Q1 · wk 10'],
    ['next', 'Marketing', 'Publish proof from the first C customers', 'Share of search in C', 'Q2 · wk 04'],
    ['next', 'Sales', 'Open Segment D with a partner-led pilot', 'Pilot win rate', 'Q2 · wk 08'],
    ['next', 'Product', 'Package a mid-price tier for specialists', 'Tier adoption', 'Q2 · wk 12'],
    ['later', 'Marketing', 'Enter Market 03 with the proven C playbook', 'New-market pipeline', 'Q3 · wk 06'],
    ['later', 'Product', 'Add the reporting feature D buyers asked for', 'Retention in D', 'Q4 · wk 02'],
    ['later', 'Sales', 'Review Segment A once C and D are won', 'Go / no-go decision', 'Q4 · wk 10'],
];
?>
<section class="band band--alt cgs-moves" id="moves" aria-labelledby="moves-t">
  <!-- PLACEHOLDER: illustrative moves, owners and dates, confirm before launch -->
  <div class="wrap">
    <div class="cgs-head" data-rv>
      <div class="cgs-head__t">
        <p class="cgs-eye"><b>08</b><i></i><?= e($CAP['offer'][4][0]) ?></p>
        <h2 class="h2" id="moves-t"><span class="g">Strategy leaves the deck</span> as moves with names on them.</h2>
      </div>
      <div class="cgs-head__l">
        <p class="lead"><?= e($CAP['offer'][4][1]) ?></p>
      </div>
    </div>

    <div class="cgs-mv" data-cgs-moves>
      <div class="cgs-mv__bar">
        <div class="cgs-mv__chips" role="group" aria-label="Filter moves by owner">
          <button type="button" class="cgs-mv__chip" data-cgs-owner="all" aria-pressed="true">All owners <span><?= count($cgs_mv_cards) ?></span></button>
          <?php foreach ($cgs_mv_owners as $cgs_ow): $cgs_n = count(array_filter($cgs_mv_cards, fn ($c) => $c[1] === $cgs_ow)); ?>
            <button type="button" class="cgs-mv__chip" data-cgs-owner="<?= e($cgs_ow) ?>" aria-pressed="false"><?= e($cgs_ow) ?> <span><?= $cgs_n ?></span></button>
          <?php endforeach; ?>
        </div>
        <p class="cgs-mv__status" aria-live="polite" data-cgs-mvstatus>Showing all <?= count($cgs_mv_cards) ?> moves</p>
        <span class="cgs-illus">Illustrative</span>
      </div>

      <div class="cgs-mv__board">
        <?php foreach ($cgs_mv_cols as $cgs_ci => $cgs_col): $cgs_in = array_values(array_filter($cgs_mv_cards, fn ($c) => $c[0] === $cgs_col[0])); ?>
          <section class="cgs-mv__col" aria-labelledby="moves-c-<?= $cgs_col[0] ?>">
            <header class="cgs-mv__ch">
              <h3 class="cgs-mv__ct" id="moves-c-<?= $cgs_col[0] ?>"><?= e($cgs_col[1]) ?></h3>
              <span class="cgs-mv__hz"><?= e($cgs_col[2]) ?></span>
              <span class="cgs-mv__count"><b data-cgs-count><?= count($cgs_in) ?></b> <i data-cgs-unit><?= count($cgs_in) === 1 ? 'move' : 'moves' ?></i></span>
            </header>
            <ul class="cgs-mv__list">
              <?php foreach ($cgs_in as $cgs_cd): ?>
                <li class="cgs-mv__card" data-owner="<?= e($cgs_cd[1]) ?>">
                  <p class="cgs-mv__own"><i class="is-<?= strtolower($cgs_cd[1]) ?>"></i><?= e($cgs_cd[1]) ?></p>
                  <p class="cgs-mv__move"><?= e($cgs_cd[2]) ?></p>
                  <dl class="cgs-mv__meta">
                    <div><dt>Measure</dt><dd><?= e($cgs_cd[3]) ?></dd></div>
                    <div><dt>Date</dt><dd><?= e($cgs_cd[4]) ?></dd></div>
                  </dl>
                </li>
              <?php endforeach; ?>
            </ul>
          </section>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
