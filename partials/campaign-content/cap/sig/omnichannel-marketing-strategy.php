<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature — reach and frequency plan by audience moment. Segments switch the plan. Illustrative. */
$ccd_seg = [['New to category', '54%', '4.2'], ['Comparing options', '61%', '5.8'], ['Existing customers', '72%', '3.1']];
$ccd_mo  = [   // [moment, channels, reach seg1, seg2, seg3, freq seg1, seg2, seg3]
    ['Scrolling',  'Short video · feed',   62, 38, 20, '2.4×', '1.6×', '1.1×'],
    ['Searching',  'Search · AI answers',  18, 70, 26, '1.2×', '3.4×', '1.3×'],
    ['Commuting',  'Audio · out of home',  44, 22, 12, '3.0×', '1.8×', '1.0×'],
    ['Evaluating', 'Site · reviews · PR',  14, 56, 30, '1.1×', '2.6×', '1.4×'],
    ['Using',      'CRM · app · community', 4,  12, 81, '1.0×', '1.2×', '4.6×'],
];
?>
<div class="ccd-sig bdh-ui ccd-om" data-ccd-sig data-state="1">
  <?= ccd_sig_head('Reach plan · 8 weeks', 'Your company', array_column($ccd_seg, 0), 'Choose an audience segment') ?>
  <div class="ccd-sig__body" aria-hidden="true">
    <ul class="ccd-om__g">
      <li class="ccd-om__h bdh-ro"><span>Moment</span><span>Reach</span><span>Freq.</span></li>
      <?php foreach ($ccd_mo as $ccd_m): ?>
      <li>
        <span class="ccd-om__m"><strong><?= e($ccd_m[0]) ?></strong><span class="bdh-ro"><?= e($ccd_m[1]) ?></span></span>
        <span class="ccd-om__r"><span class="ccd-bar ccd-bar--l"><i class="ccd-v" style="--v1:<?= $ccd_m[2] ?>%;--v2:<?= $ccd_m[3] ?>%;--v3:<?= $ccd_m[4] ?>%"></i></span>
          <span class="bdh-ro"><?php for ($ccd_j = 0; $ccd_j < 3; $ccd_j++): ?><span data-on="<?= $ccd_j + 1 ?>"><?= $ccd_m[2 + $ccd_j] ?>%</span><?php endfor; ?></span></span>
        <span class="ccd-om__f bdh-ro"><?php for ($ccd_j = 0; $ccd_j < 3; $ccd_j++): ?><span data-on="<?= $ccd_j + 1 ?>"><?= e($ccd_m[5 + $ccd_j]) ?></span><?php endfor; ?></span>
      </li>
      <?php endforeach; ?>
    </ul>
    <div class="ccd-om__k">
      <?php foreach ($ccd_seg as $ccd_j => $ccd_s): ?>
      <div class="cch-kpi" data-on="<?= $ccd_j + 1 ?>"><span class="cch-kpi__l">Effective reach 3+</span><span class="cch-kpi__v"><?= e(rtrim($ccd_s[1], '%')) ?><small>%</small></span><span class="cch-kpi__n">target audience</span></div>
      <div class="cch-kpi" data-on="<?= $ccd_j + 1 ?>"><span class="cch-kpi__l">Avg frequency</span><span class="cch-kpi__v"><?= e($ccd_s[2]) ?><small>×</small></span><span class="cch-kpi__n">cap 6 per week</span></div>
      <?php endforeach; ?>
    </div>
  </div>
  <p class="bdh-sr">An illustrative reach and frequency plan: five audience moments from scrolling to using, each with its channels, planned reach and frequency, and the plan shifts for new, comparing and existing customers.</p>
  <p class="ccd-sig__ro" aria-live="off"><?php foreach ($ccd_seg as $ccd_j => $ccd_s): ?><span data-on="<?= $ccd_j + 1 ?>"><?= e($ccd_s[0]) ?> · effective reach 3+ <?= e($ccd_s[1]) ?> · average frequency <?= e($ccd_s[2]) ?></span><?php endforeach; ?> <em>Illustrative</em></p>
</div>
