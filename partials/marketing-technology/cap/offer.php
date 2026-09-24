<?php /* DRAFT COPY — review before launch */ ?>
<?php /* Offer: the six parts as the hub's module cards (.mth-mod--flat): header strip, title, body, footer tag. */ ?>
<section class="band band--alt mtd-offer" id="offer" aria-labelledby="offer-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>What we build · <?= count($CAP['offer']) ?> parts</p>
        <h2 class="h2" id="offer-t"><?= $CAP['offer_title'] ?></h2></div>
      <div><p class="lead"><?= e($CAP['offer_lead']) ?></p></div>
    </div>
    <ol class="mtd-offer__g">
      <?php foreach ($CAP['offer'] as $mtd_i => $mtd_o): ?>
      <li class="mth-mod mth-mod--flat mtd-offer__c" data-rv>
        <div class="mth-mod__bar"><span class="bdh-idx"><?= sprintf('%02d', $mtd_i + 1) ?></span><?= xt_icon($mtd_o[3] ?? 'dot') ?><span class="mtd-offer__k"><?= e($CAP['short']) ?></span></div>
        <div class="mth-mod__body">
          <h3 class="bdh-t bdh-t--l"><?= e($mtd_o[0]) ?></h3>
          <p class="bdh-d"><?= e($mtd_o[1]) ?></p>
        </div>
        <div class="mth-mod__foot"><span class="bdh-ro mtd-offer__tag"><?= e($mtd_o[2]) ?></span></div>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
