<?php /* DRAFT COPY — review before launch */
/* Offer — six things this capability does (.aih-card--flat, icon + tag), from data/ai-design.php['offer']. */
?>
<section class="band band--alt aid-offer" id="offer" aria-labelledby="offer-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What it covers</p>
        <h2 class="h2" id="offer-t"><?= $CAP['offer_title'] ?></h2>
      </div>
      <div><p class="lead"><?= e($CAP['offer_lead']) ?></p></div>
    </div>
    <ol class="aid-offer__grid" role="list">
      <?php foreach ($CAP['offer'] as $aid_i => $aid_o): ?>
        <li class="aih-card aih-card--flat aid-offer__i">
          <div class="aih-card__body">
            <div class="aid-offer__top">
              <span class="aid-offer__ic"><?= xt_icon($aid_o[3]) ?></span>
              <span class="aih-card__idx"><?= str_pad((string) ($aid_i + 1), 2, '0', STR_PAD_LEFT) ?> / 06</span>
            </div>
            <h3 class="aih-card__t"><?= e($aid_o[0]) ?></h3>
            <p class="aih-card__d"><?= e($aid_o[1]) ?></p>
            <p class="aid-offer__tag"><?= e($aid_o[2]) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
