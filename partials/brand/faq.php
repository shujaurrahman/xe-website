<?php
/**
 * Questions people ask: the heading and a contact card on the left (sticky),
 * the accordion on the right. core.js drives [data-acc]; each button sits in
 * an h3 and finds its panel through aria-controls.
 *
 *   $faq     required  ['title' => html, 'items' => [[question, answer], …]]
 *   $faqId   optional  id prefix (default 'faq') — keeps ids unique when a page has two
 *   $faqLbl  optional  eyebrow (default 'Questions')
 *   $faqAsk  optional  [title, text, button label, href] for the side card, or false to hide it
 */
$faqId = $faqId ?? 'faq';
$fqLbl = $faqLbl ?? 'Questions';
$fqAsk = isset($faqAsk) ? $faqAsk : ['Anything else?', 'Ask the team that would do the work. We answer straight.', 'Ask us directly', 'contact.php'];
?>
<section class="band bd-faq" id="<?= e($faqId) ?>" aria-labelledby="<?= e($faqId) ?>-t">
  <div class="wrap bd-faq__grid">
    <div class="bd-faq__side" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span><?= e($fqLbl) ?></p>
      <h2 class="h2 bd-faq__h" id="<?= e($faqId) ?>-t"><?= $faq['title'] ?></h2>
      <p class="bd-faq__count"><b class="num"><?= str_pad((string) count($faq['items']), 2, '0', STR_PAD_LEFT) ?></b> answered here</p>
      <?php if ($fqAsk): ?>
        <div class="bd-faq__ask">
          <p class="bd-faq__askt"><?= e($fqAsk[0]) ?></p>
          <p class="bd-faq__askd"><?= e($fqAsk[1]) ?></p>
          <a class="btn btn--out bd-faq__btn2" href="<?= e(xe_url($fqAsk[3])) ?>"><?= e($fqAsk[2]) ?> <span class="i" aria-hidden="true">›</span></a>
        </div>
      <?php endif; ?>
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
