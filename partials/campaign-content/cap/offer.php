<?php /* DRAFT COPY — review before launch */ ?>
<section class="band band--alt ccd-offer" id="offer" aria-labelledby="offer-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>What we do · <?= count($CAP['offer']) ?> parts</p>
        <h2 class="h2" id="offer-t"><?= $CAP['offer_title'] ?></h2></div>
      <div><p class="lead"><?= e($CAP['offer_lead']) ?></p></div>
    </div>
    <ol class="ccd-offer__g" data-bdh-stagger>
      <?php foreach ($CAP['offer'] as $ccd_i => $ccd_o): ?>
      <li class="cch-card" data-rv>
        <div class="cch-card__top"><span class="bdh-idx"><?= sprintf('%02d', $ccd_i + 1) ?></span><span class="cch-card__ico" aria-hidden="true"><?= xt_icon($ccd_o[3] ?? 'dot') ?></span></div>
        <h3 class="cch-card__t"><?= e($ccd_o[0]) ?></h3>
        <p class="cch-card__d"><?= e($ccd_o[1]) ?></p>
        <div class="cch-card__f"><span class="bdh-ro"><?= e($ccd_o[2]) ?></span></div>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
