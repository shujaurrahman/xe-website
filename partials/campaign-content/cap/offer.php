<?php /* DRAFT COPY — review before launch */ ?>
<section class="band band--alt ccd-offer" id="offer" aria-labelledby="offer-t">
  <div class="wrap">
    <?php $ccd_im = ccd_img($CCD_KEY); ?>
    <div class="ccd-offer__top<?= $ccd_im ? ' ccd-offer__top--img' : '' ?>">
      <div class="bdh-head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>What we do · <?= count($CAP['offer']) ?> parts</p>
        <h2 class="h2" id="offer-t"><?= $CAP['offer_title'] ?></h2>
        <p class="lead"><?= e($CAP['offer_lead']) ?></p>
      </div>
      <?php if ($ccd_im): ?>
      <figure class="bdh-img bdh-img--r169 ccd-offer__img" data-rv><img src="<?= e(xe_url('assets/imgs/campaign-content/' . $ccd_im[0])) ?>" alt="<?= e($ccd_im[3]) ?>" width="<?= (int) $ccd_im[1] ?>" height="<?= (int) $ccd_im[2] ?>" loading="lazy" decoding="async" style="object-position:<?= e($ccd_im[4]) ?>"></figure>
      <?php endif; ?>
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
