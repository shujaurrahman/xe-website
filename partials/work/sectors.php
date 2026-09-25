<?php /* DRAFT COPY — review before launch */
/* Sectors — every sector the archive can hold, with the count it currently holds and the one constraint
   that shapes work in it. Sectors with no record say so; an empty cell is more useful than a filled one
   nobody can check. The eight keys come from data/work.php, so this list follows that file.
   The constraint lines are consistent with the Industries section of the Technology & Intelligence hub. */
$wks_line = [
    'consumer-health'    => ['Claims have to be substantiated before they ship, in every market separately.', 'shield'],
    'financial-services' => ['Every decision needs an audit trail, and money moves in milliseconds.', 'log'],
    'retail-commerce'    => ['Sale days, mid-range phones and answer engines decide the revenue.', 'gauge'],
    'b2b-technology'     => ['The buying committee reads the documentation before it talks to sales.', 'doc'],
    'hospitality'        => ['The brand is judged on the day of stay, not on the campaign.', 'pin'],
    'telecom-media'      => ['Volume is the constraint: thousands of assets, every week, on brand.', 'layers'],
    'manufacturing'      => ['Plants run on control systems that cannot stop for an upgrade.', 'chip'],
    'public-education'   => ['Accessibility and children\'s data are requirements, not preferences.', 'accessibility'],
];
$wks_sorted = $WK['industries'];
?>
<section class="band band--ink wk-sectors" id="sectors" aria-labelledby="sectors-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Where the work happens</p>
        <h2 class="h2" id="sectors-t"><span class="g">Eight sectors.</span> Eight different constraints.</h2>
      </div>
      <div>
        <p class="lead">The craft is the same everywhere. What changes is what the sector will not let you
          do. Each tile carries the constraint that shapes the work, and how many records the archive
          currently holds for it.</p>
        <p class="wk-note">A sector with no record is shown empty on purpose. It is a sector we can work in,
          not a claim that we already have.</p>
      </div>
    </div>

    <ul class="wk-sectors__grid" data-rv-s data-rv-step="60">
      <?php foreach ($wks_sorted as $wks_key => $wks_label):
              $wks_n = $WK['count_i'][$wks_key] ?? 0;
              $wks_m = $wks_line[$wks_key] ?? ['', 'dot']; ?>
        <li class="wk-sectors__cell<?= $wks_n > 0 ? ' is-on' : '' ?>">
          <p class="wk-sectors__top">
            <span class="wk-sectors__ico" aria-hidden="true"><?= xt_icon($wks_m[1], ['size' => 20]) ?></span>
            <?php if ($wks_n > 0): ?>
              <a class="wk-sectors__n" href="<?= xe_url('work.php') ?>?i%5B%5D=<?= e($wks_key) ?>#index">
                <b class="num"><?= $wks_n ?></b><span><?= $wks_n === 1 ? 'record' : 'records' ?></span>
              </a>
            <?php else: ?>
              <span class="wk-sectors__n is-empty"><b class="num">0</b><span>records</span></span>
            <?php endif; ?>
          </p>
          <h3 class="bdh-t bdh-t--s"><?= e($wks_label) ?></h3>
          <p class="bdh-d"><?= e($wks_m[0]) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="wk-sectors__foot" data-rv data-rv-d="80">
      <p class="wk-sectors__say">Sector attribution is not a fallback. For regulated and pre-launch work it
        is the only attribution there will ever be, and it still tells you what you need: the constraint, the
        scope, the disciplines and what changed.</p>
      <a class="btn btn--white" href="<?= xe_url('industries.php') ?>">Industries we serve <span class="i" aria-hidden="true">›</span></a>
    </div>
  </div>
</section>
