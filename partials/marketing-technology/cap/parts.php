<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Customer Relationship Strategy only: its five practices are the sections of this one page, one band each,
   alternating image side. Each band quotes its offer line from data/marketing-technology.php and its detail from
   topics.php. The sixth offer (customer value measurement) closes the run as the thread that ties them together. */
$mtd_parts = $MTD_X['parts'];
?>
<section class="band band--alt mtd-parts-intro" id="offer" aria-labelledby="offer-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>One capability · five practices</p>
        <h2 class="h2" id="offer-t"><?= $CAP['offer_title'] ?></h2></div>
      <div><p class="lead"><?= e($CAP['offer_lead']) ?></p></div>
    </div>
    <ol class="mth-flow mtd-parts__loop" aria-label="The five practices, in the order a customer meets them">
      <?php foreach ($mtd_parts as $mtd_i => $mtd_p): $mtd_o = $CAP['offer'][$mtd_i]; ?>
      <li class="mth-node"><a class="mtd-parts__nl" href="#<?= e($mtd_p[0]) ?>">
        <span class="mth-node__k"><?= xt_icon($mtd_o[3]) ?><?= sprintf('%02d', $mtd_i + 1) ?></span>
        <span class="mth-node__t"><?= e($mtd_o[0]) ?></span>
        <span class="mth-node__d"><?= e($mtd_o[2]) ?></span>
      </a></li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
<?php foreach ($mtd_parts as $mtd_i => $mtd_p): $mtd_o = $CAP['offer'][$mtd_i]; ?>
<section class="band<?= $mtd_i % 2 ? ' band--alt' : '' ?> mtd-part mtd-part--<?= $mtd_i % 2 ? 'r' : 'l' ?>" id="<?= e($mtd_p[0]) ?>" aria-labelledby="<?= e($mtd_p[0]) ?>-t">
  <div class="wrap mtd-part__g">
    <div class="mtd-part__tx" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span><?= e($mtd_p[1]) ?></p>
      <h2 class="h2" id="<?= e($mtd_p[0]) ?>-t"><?= $mtd_p[2] ?></h2>
      <p class="lead"><?= e($mtd_o[1]) ?></p>
    </div>
    <div class="mth-mod mtd-part__card" data-rv>
      <div class="mth-mod__bar"><span class="bdh-idx"><?= sprintf('%02d', $mtd_i + 1) ?></span><?= xt_icon($mtd_o[3]) ?><span class="mth-chip mth-chip--ok"><?= e($mtd_o[2]) ?></span></div>
      <div class="mth-mod__body">
        <h3 class="bdh-t">What it covers</h3>
        <ul class="mtd-part__list"><?php foreach ($mtd_p[3] as $mtd_b): ?><li><?= xt_icon('check') ?><span><?= e($mtd_b) ?></span></li><?php endforeach; ?></ul>
      </div>
      <div class="mth-mod__foot"><span class="bdh-ro">Produces</span><span class="mtd-part__out"><?= e($mtd_p[4]) ?></span></div>
    </div>
  </div>
</section>
<?php endforeach; ?>
<?php $mtd_m = $CAP['offer'][5]; ?>
<section class="band band--ink mtd-part-thread" id="measurement" aria-labelledby="measurement-t">
  <div class="wrap mtd-part__g">
    <div class="mtd-part__tx" data-rv>
      <p class="lbl"><span class="dot"></span>The thread through all five</p>
      <h2 class="h2" id="measurement-t"><span class="g">One customer record,</span> one set of measures.</h2>
    </div>
    <div data-rv>
      <p class="lead"><?= e($mtd_m[1]) ?></p>
      <p class="mtd-part__tags"><span class="mth-chip mth-chip--ok"><?= e($mtd_m[2]) ?></span><span class="mth-chip">Holdout on every programme</span></p>
    </div>
  </div>
</section>
