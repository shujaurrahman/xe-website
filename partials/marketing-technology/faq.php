<?php /* DRAFT COPY — review before launch */
/* FAQ: hub-level questions first, then the most-asked questions from the capabilities, quoted from their data. */
$mth_fq = [
    ['Where should we start?', 'Usually with the data and consent foundations plus one journey that pays for itself, often cart recovery, onboarding or win-back. It forces the event and consent work that every later module needs, and it shows measurable lift within a quarter.'],
    $CAPS['ai-driven-marketing-automation']['faq'][0],
    $CAPS['ai-driven-marketing-automation']['faq'][1],
    $CAPS['ai-driven-marketing-automation']['faq'][2],
    ['How do you handle the DPDP Act and GDPR?', 'Consent is stored per purpose and channel with the notice version, the action and the time, enforced when a message is sent and withdrawable as easily as it was given. We build to both laws and document the design for your legal team; we do not give legal advice, and your counsel decides the lawful basis for each purpose.'],
    $CAPS['ai-campaign-optimization']['faq'][1],
    ['Can you work with our existing agency?', 'Yes. We often build the stack, the data and the measurement while your agency runs media and creative. Roles, access and approval rights are agreed in writing at the start so nothing falls between teams.'],
];
?>
<section class="band band--alt mth-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="mth-faq__grid">
      <div class="bdh-head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">What teams ask</span> before they start.</h2>
        <p class="lead">Anything else, ask us directly. A short call is usually quicker than a long email.</p>
      </div>
      <div class="mth-faq__list">
        <?php foreach ($mth_fq as $mth_fq_i => $mth_f): ?>
        <details class="mth-faq__q"<?= $mth_fq_i === 0 ? ' open' : '' ?>>
          <summary><span class="bdh-idx"><?= sprintf('%02d', $mth_fq_i + 1) ?></span><span class="mth-faq__t"><?= e($mth_f[0]) ?></span><span class="mth-faq__pm" aria-hidden="true"></span></summary>
          <p class="p"><?= e($mth_f[1]) ?></p>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
