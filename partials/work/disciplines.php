<?php /* DRAFT COPY — review before launch */
/* Disciplines — what each of the six contributes to a piece of work, with the number of records it appears
   in and a link to its own page. The counts come from data/work.php; the names, order and links come from
   data/site.php, so this list can never disagree with the navigation. Each count links back to the
   showcase pre-filtered to that discipline, which is the same GET filter the form above writes. */
$wkd_does = [
    'brand-design'            => ['What the brand stands for and how it behaves, as rules a market team can follow.', 'Positioning · identity · brand system · governance'],
    'technology-intelligence' => ['The platform underneath: software, data, AI systems and the security to keep them dependable.', 'Architecture · build · evals · run'],
    'campaign-content'        => ['The work that goes out: campaign ideas and the production system that ships them everywhere.', 'Campaign design · content systems · production'],
    'ai-design'              => ['Where AI belongs in the experience, designed rather than bolted on.', 'AI product design · content studio · brand tooling'],
    'product-experience'      => ['The product itself: what it does, in what order, and how it feels to use.', 'Product strategy · experience design · design systems'],
    'marketing-technology'    => ['The plumbing that makes it repeatable: data, journeys, automation and reporting.', 'Data model · journeys · automation · reporting'],
];
?>
<section class="band wk-disciplines" id="disciplines" aria-labelledby="disciplines-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Who does it</p>
        <h2 class="h2" id="disciplines-t"><span class="g">One team,</span> six disciplines deep.</h2>
      </div>
      <div>
        <p class="lead">Most records carry three disciplines, because most problems do. The count beside each
          one is how many records in the archive it appears in — choose it to filter the showcase.</p>
      </div>
    </div>

    <ol class="wk-disciplines__list" data-rv-s data-rv-step="60">
      <?php foreach ($WK['disc'] as $wkd_slug => $wkd_row):
              $wkd_n = $WK['count_d'][$wkd_slug] ?? 0;
              $wkd_m = $wkd_does[$wkd_slug] ?? ['', '']; ?>
        <li class="wk-disciplines__row">
          <span class="bdh-idx wk-disciplines__i"><?= e($wkd_row['n']) ?></span>
          <div class="wk-disciplines__main">
            <h3 class="bdh-t wk-disciplines__t">
              <a href="<?= e($wkd_row['url']) ?>"><?= e($wkd_row['name']) ?><i aria-hidden="true">›</i></a>
            </h3>
            <p class="bdh-d wk-disciplines__d"><?= e($wkd_m[0]) ?></p>
            <p class="wk-k wk-disciplines__parts"><?= e($wkd_m[1]) ?></p>
          </div>
          <p class="wk-disciplines__count">
            <?php if ($wkd_n > 0): ?>
              <a class="wk-disciplines__chip" href="<?= xe_url('work.php') ?>?d%5B%5D=<?= e($wkd_slug) ?>#index">
                <b class="num"><?= $wkd_n ?></b><span><?= $wkd_n === 1 ? 'record' : 'records' ?></span>
              </a>
            <?php else: ?>
              <span class="wk-disciplines__chip is-empty"><b class="num">0</b><span>records</span></span>
            <?php endif; ?>
          </p>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="wk-note wk-disciplines__foot">Counts are of placeholder records while the real case studies are
      in clearance, so read them as the shape of the archive rather than a tally of delivered work.
      <a class="wk-index__lk" href="<?= xe_url('services/') ?>">All six disciplines in full</a>.</p>
  </div>
</section>
