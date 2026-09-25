<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Customer Relationship Strategy only: the five practices as ONE section — a practice switcher (ARIA tablist via
   cap.js; without JS the rail is hidden and every practice is shown in order). Each practice pairs its offer line
   (data) and detail (topics.php) with a small working artefact (heads.php 'prac'). The sixth offer, customer value
   measurement, closes the section as the thread through all five. */
$mtd_parts = $MTD_X['parts'];
$mtd_prac  = $MTD_H['prac'] ?? [];
$mtd_m     = $CAP['offer'][5];
?>
<section class="band band--alt mtd-prac-s" id="offer" aria-labelledby="offer-t">
  <div class="wrap">
    <div class="mtd-offer__head">
      <div class="bdh-head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>One capability · five practices</p>
        <h2 class="h2" id="offer-t"><?= $CAP['offer_title'] ?></h2>
        <p class="lead"><?= e($CAP['offer_lead']) ?></p>
      </div>
      <!-- PLACEHOLDER: reference photograph (Unsplash, credited in assets/imgs/marketing-technology/CREDITS.md) — replace with own photography before launch -->
      <figure class="bdh-img bdh-img--r43 mtd-offer__img" data-rv><img src="<?= e($BASE . 'assets/imgs/marketing-technology/' . $MTD_KEY . '.jpg') ?>" alt="<?= e($MTD_H['img'] ?? '') ?>" width="1200" height="800" loading="lazy" decoding="async"></figure>
    </div>

    <div class="mtd-prac" data-mtd-prac>
      <div class="mtd-prac__rail" role="tablist" aria-label="The five practices" aria-orientation="vertical">
        <?php foreach ($mtd_parts as $mtd_i => $mtd_p): $mtd_o = $CAP['offer'][$mtd_i]; ?>
        <button type="button" class="mtd-prac__tab" role="tab" id="mtd-pc-t<?= $mtd_i ?>" aria-controls="<?= e($mtd_p[0]) ?>" aria-selected="<?= $mtd_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $mtd_i === 0 ? '0' : '-1' ?>">
          <span class="bdh-idx"><?= sprintf('%02d', $mtd_i + 1) ?></span><?= xt_icon($mtd_o[3]) ?>
          <span class="mtd-prac__tt"><span class="mtd-prac__tn"><?= e($mtd_o[0]) ?></span><span class="bdh-ro"><?= e($mtd_o[2]) ?></span></span>
        </button>
        <?php endforeach; ?>
      </div>
      <div class="mtd-prac__panes">
        <?php foreach ($mtd_parts as $mtd_i => $mtd_p): $mtd_o = $CAP['offer'][$mtd_i]; $mtd_k = $mtd_prac[$mtd_i] ?? null; ?>
        <div class="mtd-prac__pane mth-mod" id="<?= e($mtd_p[0]) ?>" role="tabpanel" aria-labelledby="mtd-pc-t<?= $mtd_i ?>">
          <div class="mth-mod__bar"><span class="bdh-idx">Practice <?= sprintf('%02d', $mtd_i + 1) ?> of <?= count($mtd_parts) ?></span><span class="bdh-ro"><?= e($mtd_p[1]) ?></span><span class="mth-chip mth-chip--ok mtd-prac__out"><?= e($mtd_o[2]) ?></span></div>
          <div class="mtd-prac__body">
            <div class="mtd-prac__tx">
              <h3 class="h3"><?= strip_tags($mtd_p[2], '<span>') ?></h3>
              <p class="p"><?= e($mtd_o[1]) ?></p>
              <ul class="mtd-part__list"><?php foreach ($mtd_p[3] as $mtd_b): ?><li><?= xt_icon('check') ?><span><?= e($mtd_b) ?></span></li><?php endforeach; ?></ul>
              <p class="mtd-prac__prod"><span class="bdh-ro">Produces</span> <?= e($mtd_p[4]) ?></p>
            </div>
            <?php if ($mtd_k): ?>
            <figure class="mtd-prac__mock">
              <figcaption class="bdh-ro"><?= e($mtd_k[0]) ?> <span class="mtd-x__ill">Illustrative</span></figcaption>
              <?= mtd_matrix($mtd_k[1], $mtd_k[2], $mtd_k[0] . ' (illustrative)', 'mtd-x__t--sm') ?>
            </figure>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="mtd-prac__thread" id="measurement" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>The thread through all five</p>
      <h3 class="h3"><span class="g">One customer record,</span> one set of measures.</h3>
      <p class="p"><?= e($mtd_m[1]) ?></p>
      <p class="mtd-part__tags"><span class="mth-chip mth-chip--ok"><?= e($mtd_m[2]) ?></span><span class="mth-chip">Holdout on every programme</span></p>
    </div>
  </div>
</section>
