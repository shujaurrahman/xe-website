<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature — coverage and message pull-through tracker. Rows = pieces of coverage; columns = the three key messages. Illustrative. */
$ccd_msg = [['A', 'Billing that scales with usage', '4 of 6', '67%'], ['B', 'Migration without a revenue dip', '3 of 6', '50%'], ['C', 'Built for finance teams', '5 of 6', '83%']];
$ccd_cov = [   // [outlet type, tier, pulled A, B, C, tone]
    ['National business daily', 'T1', 1, 0, 1, 'Positive'],
    ['Fintech trade title',     'T1', 1, 1, 1, 'Positive'],
    ['Industry podcast',        'T2', 0, 1, 1, 'Neutral'],
    ['Analyst note',            'T1', 1, 0, 1, 'Positive'],
    ['Regional business paper', 'T2', 0, 0, 0, 'Neutral'],
    ['AI answer engine',        'AI', 1, 1, 1, 'Cited'],
];
?>
<div class="ccd-sig bdh-ui ccd-pr" data-ccd-sig data-state="1">
  <?= ccd_sig_head('Coverage tracker · launch wk 4', 'Your company', array_map(fn ($ccd_m) => 'Message ' . $ccd_m[0], $ccd_msg), 'Choose a key message to trace') ?>
  <div class="ccd-sig__body" aria-hidden="true">
    <?php foreach ($ccd_msg as $ccd_i => $ccd_m): ?><p class="ccd-pr__msg" data-on="<?= $ccd_i + 1 ?>"><span class="bdh-ro">Message <?= e($ccd_m[0]) ?></span> “<?= e($ccd_m[1]) ?>”</p><?php endforeach; ?>
    <table class="ccd-pr__t">
      <thead><tr><th scope="col">Coverage</th><th scope="col">Tier</th><?php foreach ($ccd_msg as $ccd_i => $ccd_m): ?><th scope="col" data-hl="<?= $ccd_i + 1 ?>"><?= e($ccd_m[0]) ?></th><?php endforeach; ?><th scope="col">Tone</th></tr></thead>
      <tbody>
        <?php foreach ($ccd_cov as $ccd_r): ?>
        <tr><th scope="row"><?= e($ccd_r[0]) ?></th><td class="bdh-ro"><?= e($ccd_r[1]) ?></td>
          <?php for ($ccd_j = 0; $ccd_j < 3; $ccd_j++): ?><td data-hl="<?= $ccd_j + 1 ?>"><span class="ccd-pr__d<?= $ccd_r[2 + $ccd_j] ? ' is-y' : '' ?>"></span></td><?php endfor; ?>
          <td class="bdh-ro"><?= e($ccd_r[5]) ?></td></tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="ccd-pr__k">
      <div class="cch-kpi"><span class="cch-kpi__l">Share of voice</span><span class="cch-kpi__v">18<small>%</small></span><span class="cch-kpi__n">baseline 11%</span></div>
      <?php foreach ($ccd_msg as $ccd_i => $ccd_m): ?>
      <div class="cch-kpi" data-on="<?= $ccd_i + 1 ?>"><span class="cch-kpi__l">Pull-through · <?= e($ccd_m[0]) ?></span><span class="cch-kpi__v"><?= e(rtrim($ccd_m[3], '%')) ?><small>%</small></span><span class="cch-kpi__n"><?= e($ccd_m[2]) ?> pieces</span></div>
      <?php endforeach; ?>
    </div>
  </div>
  <p class="bdh-sr">An illustrative coverage tracker: six pieces of coverage, including an AI answer engine citation, scored for which of three key messages each one repeated, with share of voice against a baseline.</p>
  <p class="ccd-sig__ro" aria-live="off"><?php foreach ($ccd_msg as $ccd_i => $ccd_m): ?><span data-on="<?= $ccd_i + 1 ?>">Message <?= e($ccd_m[0]) ?> pulled through in <?= e($ccd_m[2]) ?> pieces (<?= e($ccd_m[3]) ?>)</span><?php endforeach; ?> <em>Illustrative</em></p>
</div>
