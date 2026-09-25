<?php /* DRAFT COPY — review before launch */ ?>
<?php /* Process: the hub's stepper (.mth-steps). Every stage is shown until cap.js adds .is-tabs, so the page is complete without JS. */
$mtd_steps = $CAP['process']['steps']; ?>
<section class="band band--alt mtd-proc" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>How it runs · <?= count($mtd_steps) ?> stages</p>
        <h2 class="h2" id="process-t"><?= $CAP['process']['title'] ?></h2></div>
      <div><!-- PLACEHOLDER: confirm typical timeline before launch --><p class="lead"><?= e($CAP['process']['lead']) ?> Timings are typical, not promised.</p></div>
    </div>
    <div class="mth-steps" data-mtd-steps>
      <div class="mth-steps__rail" role="tablist" aria-label="<?= e($CAP['short']) ?> stages">
        <?php foreach ($mtd_steps as $mtd_i => $mtd_s): ?>
        <button type="button" class="mth-steps__tab" role="tab" id="mtd-pr-t<?= $mtd_i ?>" aria-controls="mtd-pr-p<?= $mtd_i ?>" aria-selected="<?= $mtd_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $mtd_i === 0 ? '0' : '-1' ?>">
          <span class="mth-steps__n"><?= sprintf('%02d', $mtd_i + 1) ?></span>
          <span class="mth-steps__txt"><span class="mth-steps__l"><?= e($mtd_s[0]) ?></span><span class="mth-steps__w"><?= e($mtd_s[1]) ?></span></span>
        </button>
        <?php endforeach; ?>
      </div>
      <?php foreach ($mtd_steps as $mtd_i => $mtd_s): ?>
      <div class="mth-steps__pane mtd-proc__pane<?= $mtd_i === 0 ? ' is-on' : '' ?>" id="mtd-pr-p<?= $mtd_i ?>" role="tabpanel" aria-labelledby="mtd-pr-t<?= $mtd_i ?>">
        <div class="mtd-proc__a">
          <p class="mtd-proc__ph"><span class="bdh-idx">Stage <?= sprintf('%02d', $mtd_i + 1) ?> of <?= count($mtd_steps) ?></span><span><?= e($mtd_s[1]) ?></span></p>
          <h3 class="h3"><?= e($mtd_s[0]) ?></h3>
          <p class="p"><?= e($mtd_s[2]) ?></p>
        </div>
        <div class="mtd-proc__b">
          <p class="mtd-proc__k">Produces</p>
          <ul class="mtd-proc__out"><?php foreach ($mtd_s[3] as $mtd_o): ?><li><?= xt_icon('check') ?><?= e($mtd_o) ?></li><?php endforeach; ?></ul>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
