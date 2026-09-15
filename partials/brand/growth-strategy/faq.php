<?php /* DRAFT COPY — review before launch */
/* 12 FAQ — "Questions from the boardroom". A wide documentary frame of an empty decision room over a
   numbered question list; one answer open at a time (core [data-acc]). Questions and answers from $CAP. */
?>
<section class="band cgs-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="cgs-head" data-rv>
      <div class="cgs-head__t">
        <p class="cgs-eye"><b>12</b><i></i>Questions from the boardroom</p>
        <h2 class="h2" id="faq-t"><span class="g">What leadership asks</span> before signing a growth brief.</h2>
      </div>
      <div class="cgs-head__l">
        <p class="lead">Straight answers to the questions that come up in the first meeting.</p>
        <a class="tl" href="<?= xe_url('contact.php') ?>">Ask your own <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <figure class="cgs-faq__room" data-rv>
      <!-- PLACEHOLDER: reference photography (Unsplash) — replace with own imagery before launch -->
      <img src="<?= xe_url('assets/imgs/brand/growth-strategy/boardroom.jpg') ?>" alt="An empty boardroom with a long table and chairs facing floor-to-ceiling windows" width="1400" height="933" loading="lazy" decoding="async">
      <figcaption><span><?= count($CAP['faq']) ?> questions</span><span>Asked most often in the first meeting</span></figcaption>
    </figure>

    <div class="cgs-faq__list" data-acc>
      <?php foreach ($CAP['faq'] as $cgs_fi => $cgs_fq): $cgs_open = $cgs_fi === 0; ?>
        <div class="cgs-faq__item">
          <h3 class="cgs-faq__q">
            <button type="button" class="cgs-faq__btn" data-acc-b aria-expanded="<?= $cgs_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $cgs_fi ?>" id="faq-q<?= $cgs_fi ?>">
              <span class="cgs-faq__n">Q.<?= sprintf('%02d', $cgs_fi + 1) ?></span>
              <span class="cgs-faq__t"><?= e($cgs_fq[0]) ?></span>
              <span class="cgs-faq__ic" aria-hidden="true"><i></i><i></i></span>
            </button>
          </h3>
          <div class="cgs-faq__a" id="faq-a<?= $cgs_fi ?>" data-acc-p role="region" aria-labelledby="faq-q<?= $cgs_fi ?>">
            <div class="cgs-faq__in">
              <p class="cgs-faq__k">Answer</p>
              <p class="cgs-faq__p"><?= e($cgs_fq[1]) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
