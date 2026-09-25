<?php /* DRAFT COPY — review before launch */
/* FAQ — native <details> (works without JS), hub FAQ styles, questions from data/ai-design.php['faq']. */
?>
<section class="band aid-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap aih-faq__grid">
    <div class="aih-faq__rail">
      <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
      <h2 class="h2" id="faq-t"><span class="g">Asked plainly,</span> answered plainly.</h2>
      <p class="p">What buyers ask before <?= e($CAP['name']) ?> work. Anything else, ask the team directly.</p>
      <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, $AID_SVC)) ?>">Ask the team <span class="i" aria-hidden="true"></span></a>
    </div>
    <div class="aih-faq__list">
      <?php foreach ($CAP['faq'] as $aid_i => $aid_q): ?>
        <details class="aih-faq__i"<?= $aid_i === 0 ? ' open' : '' ?>>
          <summary><span><?= e($aid_q[0]) ?></span><span class="aih-faq__pm" aria-hidden="true"></span></summary>
          <p><?= e($aid_q[1]) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
