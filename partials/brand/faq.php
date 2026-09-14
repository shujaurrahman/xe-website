<?php
/**
 * Questions people ask. Expects $faq = ['title' => html, 'items' => [[q, a], …]]
 * and $faqId, a short prefix that keeps ids unique when a page has more than one.
 */
$faqId = $faqId ?? 'faq';
?>
<section class="band bd-faq" id="<?= e($faqId) ?>" aria-labelledby="<?= e($faqId) ?>-t">
  <div class="wrap bd-faq__grid">
    <div class="bd-faq__side" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
      <h2 class="h2 bd-faq__h" id="<?= e($faqId) ?>-t"><?= $faq['title'] ?></h2>
      <p class="bd-faq__count"><b class="num"><?= str_pad((string) count($faq['items']), 2, '0', STR_PAD_LEFT) ?></b> answered here</p>
      <div class="bd-faq__ask">
        <span class="bd-faq__mark" aria-hidden="true"><?= xe_svg('xe-mark') ?></span>
        <p class="bd-faq__askt">Anything else?</p>
        <p class="bd-faq__askd">Ask the team that would do the work. We answer straight.</p>
        <a class="btn btn--out bd-faq__btn2" href="<?= xe_url('contact.php') ?>">Ask us directly <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="bd-faq__list" data-acc data-rv data-rv-d="80">
      <?php foreach ($faq['items'] as $i => $q): ?>
        <div class="bd-faq__row">
          <h3 class="bd-faq__hq">
            <button class="bd-faq__btn" type="button" data-acc-b aria-expanded="false" aria-controls="<?= e($faqId) ?>-a<?= $i ?>" id="<?= e($faqId) ?>-q<?= $i ?>">
              <span class="bd-faq__n num" aria-hidden="true"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="bd-faq__q"><?= e($q[0]) ?></span>
              <span class="bd-faq__plus" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="bd-faq__panel" id="<?= e($faqId) ?>-a<?= $i ?>" role="region" aria-labelledby="<?= e($faqId) ?>-q<?= $i ?>" data-acc-p>
            <p class="bd-faq__a"><?= e($q[1]) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
