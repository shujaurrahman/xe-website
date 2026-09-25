<?php /* DRAFT COPY — review before launch */ ?>
<section class="band band--alt cch-faq ccd-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap cch-faq__g">
    <div class="bdh-head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
      <h2 class="h2" id="faq-t"><span class="g">Asked about <?= e(strtolower($CAP['short'])) ?>,</span> answered plainly.</h2>
      <p class="lead">Anything else, ask us directly. The first conversation is about your goal, not our credentials.</p>
    </div>
    <div class="cch-faq__l">
      <?php foreach ($CAP['faq'] as $ccd_i => $ccd_q): ?>
      <details class="cch-faq__i"<?= $ccd_i ? '' : ' open' ?>>
        <summary><span class="bdh-idx"><?= sprintf('%02d', $ccd_i + 1) ?></span><span class="cch-faq__q"><?= e($ccd_q[0]) ?></span><span class="cch-faq__x" aria-hidden="true"></span></summary>
        <p class="p"><?= e($ccd_q[1]) ?></p>
      </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<script type="application/ld+json"><?= json_encode(['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => array_map(fn ($ccd_q) => ['@type' => 'Question', 'name' => $ccd_q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $ccd_q[1]]], $CAP['faq'])], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
