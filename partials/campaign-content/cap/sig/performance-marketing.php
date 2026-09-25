<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature — media plan with pacing and an incrementality test (geo holdout). Weeks switch the read. Illustrative. */
$ccd_ch = [   // [channel, share, pacing wk2, wk4, wk6]
    ['Paid search',  '34%', 22, 51, 78],
    ['Paid social',  '28%', 30, 58, 84],
    ['Online video', '18%', 12, 40, 70],
    ['Retail media', '12%', 18, 44, 66],
    ['Test reserve', '8%',  0,  0,  0],
];
$ccd_wk = [['Week 2', 17, 'Reading · too early to call'], ['Week 4', 50, '+7.8% · 90% CI 1.2–14.0'], ['Week 6', 83, '+9.4% · 90% CI 4.1–14.2']];
?>
<div class="ccd-sig bdh-ui ccd-pm" data-ccd-sig data-state="3">
  <?= ccd_sig_head('Media plan · 6-week flight', 'Your company', array_column($ccd_wk, 0), 'Choose a week of the flight', 3) ?>
  <div class="ccd-sig__body" aria-hidden="true">
    <ul class="ccd-pm__plan">
      <li class="ccd-pm__h bdh-ro"><span>Channel</span><span>Budget</span><span>Spend vs plan</span></li>
      <?php foreach ($ccd_ch as $ccd_c): ?>
      <li><span><?= e($ccd_c[0]) ?></span><span class="bdh-ro"><?= e($ccd_c[1]) ?></span>
        <span class="ccd-pm__pace"><span class="ccd-bar"><i class="ccd-v" style="--v1:<?= $ccd_c[2] ?>%;--v2:<?= $ccd_c[3] ?>%;--v3:<?= $ccd_c[4] ?>%"></i></span>
        <span class="bdh-ro"><?php foreach ([2, 3, 4] as $ccd_j => $ccd_x): ?><span data-on="<?= $ccd_j + 1 ?>"><?= $ccd_c[0] === 'Test reserve' ? 'held' : $ccd_c[$ccd_x] . '%' ?></span><?php endforeach; ?></span></span></li>
      <?php endforeach; ?>
    </ul>
    <figure class="cch-viz ccd-pm__viz">
      <figcaption class="bdh-ro"><span><i class="cch-viz__k"></i>Test regions</span><span><i class="cch-viz__k cch-viz__k--h"></i>Holdout</span><span>Conversions / day</span></figcaption>
      <svg viewBox="0 0 400 120" role="presentation">
        <line class="cch-viz__grid" x1="0" y1="30" x2="400" y2="30"/><line class="cch-viz__grid" x1="0" y1="70" x2="400" y2="70"/><line class="cch-viz__grid" x1="0" y1="110" x2="400" y2="110"/>
        <path class="cch-viz__lift" d="M67 76 L133 66 L200 58 L267 50 L333 44 L400 40 L400 72 L333 74 L267 75 L200 77 L133 77 L67 78 Z"/>
        <path class="cch-viz__h" d="M0 80 L67 78 L133 77 L200 77 L267 75 L333 74 L400 72"/>
        <path class="cch-viz__t" d="M0 80 L67 76 L133 66 L200 58 L267 50 L333 44 L400 40"/>
        <?php foreach ($ccd_wk as $ccd_j => $ccd_w): $ccd_x = $ccd_w[1] * 4; ?><line data-on="<?= $ccd_j + 1 ?>" class="ccd-pm__now" x1="<?= $ccd_x ?>" y1="6" x2="<?= $ccd_x ?>" y2="116"/><?php endforeach; ?>
      </svg>
      <div class="cch-viz__x bdh-ro"><span>W1</span><span>W2</span><span>W3</span><span>W4</span><span>W5</span><span>W6</span></div>
    </figure>
  </div>
  <p class="bdh-sr">An illustrative media plan: five channels with budget share and spend pacing against plan, beside a geo holdout test where test regions pull ahead of holdout regions to show incremental conversions.</p>
  <p class="ccd-sig__ro" aria-live="off"><?php foreach ($ccd_wk as $ccd_j => $ccd_w): ?><span data-on="<?= $ccd_j + 1 ?>"><?= e($ccd_w[0]) ?> · geo holdout, 12 test / 12 control regions · incremental conversions <?= e($ccd_w[2]) ?></span><?php endforeach; ?> <em>Illustrative</em></p>
</div>
