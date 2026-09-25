<?php /* DRAFT COPY — review before launch */
/* FAQ — the questions buyers actually ask about category experience, answered straight. A sticky side
   with the two ways forward, an accordion on the right using the shared core accordion ([data-acc]).
   The <noscript> rule below leaves every answer open, so the section is complete with JavaScript off.
   No section script is needed. */
$ind_faq = $IND['faq'];
?>
<noscript><style>.ind-faq__p{height:auto;overflow:visible}.ind-faq__plus{display:none}</style></noscript>
<section class="band band--alt ind-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap bdh-grid ind-faq__grid">
    <div class="bdh-c4 ind-faq__side">
      <div class="bdh-sticky ind-faq__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">Category experience,</span> asked directly.</h2>
        <p class="ind-faq__more">The fastest way to test whether we know your category is to ask us something only someone who has worked in it could answer.</p>
        <div class="ind-faq__act">
          <a class="btn btn--ink" href="<?= xe_url('contact.php') ?>">Ask us a category question <span class="i" aria-hidden="true">›</span></a>
          <a class="tl" href="#lens">See the five questions <span class="i" aria-hidden="true">›</span></a>
        </div>
        <dl class="ind-faq__facts">
          <div><dt>Briefs on this page</dt><dd><?= count($IND_SET) ?> categories</dd></div>
          <div><dt>Disciplines applied</dt><dd><?= count($SITE['disciplines']) ?>, in every brief</dd></div>
          <div><dt>Instruments covered</dt><dd><?= count($IND['rules']) ?>, with what each changes</dd></div>
        </dl>
      </div>
    </div>

    <div class="bdh-c7 bdh-s6 ind-faq__list" data-acc data-rv data-rv-d="80">
      <?php foreach ($ind_faq as $ind_qi => $ind_q):
          $ind_n = str_pad((string) ($ind_qi + 1), 2, '0', STR_PAD_LEFT);
          $ind_open = $ind_qi === 0; ?>
        <div class="ind-faq__row">
          <h3 class="ind-faq__hq">
            <button class="ind-faq__q" type="button" data-acc-b aria-expanded="<?= $ind_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $ind_qi ?>" id="faq-q<?= $ind_qi ?>">
              <span class="ind-faq__n" aria-hidden="true">Q<?= $ind_n ?></span>
              <span class="ind-faq__t"><?= e($ind_q[0]) ?></span>
              <span class="ind-faq__plus" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="ind-faq__p<?= $ind_open ? ' is-open' : '' ?>" id="faq-a<?= $ind_qi ?>" role="region" aria-labelledby="faq-q<?= $ind_qi ?>" data-acc-p>
            <div class="ind-faq__a"><p><?= e($ind_q[1]) ?></p></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
