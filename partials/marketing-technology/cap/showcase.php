<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Second showcase, after the process: the working artefact this capability produces (journey audit, template
   coverage, holdout read-out, variant queue, score explanation, offer guardrails). Rendered from heads.php 'x' as
   real HTML, complete without JS. */
$mtd_xx = $MTD_H['x'] ?? null;
if (!$mtd_xx) return;
?>
<section class="band mtd-x" id="working" aria-labelledby="working-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span><?= e($mtd_xx['lbl']) ?> · what you will see</p>
        <h2 class="h2" id="working-t"><span class="g"><?= e($mtd_xx['h'][0]) ?></span> <?= e($mtd_xx['h'][1]) ?></h2></div>
      <div><p class="lead"><?= e($mtd_xx['lead']) ?></p></div>
    </div>
    <figure class="mth-mod mtd-x__win" data-rv>
      <div class="mth-mod__bar"><span class="mtd-sig__dots" aria-hidden="true"><i></i><i></i><i></i></span><span class="bdh-ro"><?= e($mtd_xx['win']) ?></span><span class="mth-chip mtd-x__ill">Illustrative</span></div>
      <?php if ($mtd_xx['kind'] === 'matrix'): ?>
      <div class="mtd-x__scroll bdh-scroll-x mask-x" tabindex="0" role="region" aria-label="<?= e($mtd_xx['aria']) ?>">
        <?= mtd_matrix($mtd_xx['cols'], $mtd_xx['rows'], $mtd_xx['win']) ?>
      </div>
      <?php else: ?>
      <div class="mtd-x__board">
        <?php foreach ($mtd_xx['cols'] as $mtd_c): ?>
        <div class="mtd-x__col mtd-x__col--<?= e($mtd_c[1]) ?>">
          <h3 class="mtd-x__ch"><?= e($mtd_c[0]) ?> <span class="bdh-ro"><?= count($mtd_c[2]) ?></span></h3>
          <ul>
            <?php foreach ($mtd_c[2] as $mtd_k): ?>
            <li class="mtd-x__card"><p class="mtd-x__ct"><?= e($mtd_k[0]) ?></p><p class="mtd-x__cm"><?= e($mtd_k[1]) ?></p><p class="mtd-x__cf"><?= e($mtd_k[2]) ?></p></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
      <figcaption class="mth-mod__foot mtd-x__foot"><?php if (!empty($mtd_xx['tag'])): ?><span class="mth-chip mth-chip--ok"><?= e($mtd_xx['tag']) ?></span><?php endif; ?><span class="mtd-x__note"><?= e($mtd_xx['note']) ?></span></figcaption>
    </figure>
  </div>
</section>
