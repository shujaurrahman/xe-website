<?php /* DRAFT COPY — review before launch */ ?>
<?php
$cch_faq = [
    ['Can we engage one capability, or do we need all eight?', 'Either. Most clients start with one — a launch campaign, a content engine, a performance programme — and add others once the first is working. The system is designed so each piece plugs into the rest.'],
    ['Do you work alongside our existing agencies?', 'Yes. We often own the idea and the campaign design system while media, PR or production partners execute parts of it. The kit of parts and the shared flighting plan are what keep several agencies on one idea.'],
    ['How do you use AI in creative work?', 'For the repetitive parts: drafting copy lengths, crops, language versions, alt text and metadata from an approved master, then checking each variant against the kit. A named person approves everything that ships, claims need evidence, and AI-generated content is labelled where the law, the platform or your policy requires.'],
    ['How do you prove a campaign worked?', 'We agree the measure before launch and design the test with it: a geo holdout or a brand lift study wherever the budget allows. We report what the campaign caused against what would have happened anyway, not the sum of every platform\'s claimed conversions.'],
    ['Do you produce content in other countries and languages?', 'Yes. Productions are planned through a network of local creators and crews, and language versions are transcreated by native speakers rather than translated line by line.'],
    ['Who owns the work?', 'You do. Source files, templates, footage and copy transfer to you on delivery, with usage rights for talent, music and stock recorded per asset in a rights register.'],
];
?>
<section class="band cch-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap cch-faq__g">
    <div class="bdh-head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
      <h2 class="h2" id="faq-t"><span class="g">Before you brief us,</span> the usual questions.</h2>
      <p class="lead">Anything else, ask us directly — the first conversation is about your goal, not our credentials.</p>
    </div>
    <div class="cch-faq__l">
      <?php foreach ($cch_faq as $cch_i => $cch_q): ?>
      <details class="cch-faq__i"<?= $cch_i ? '' : ' open' ?>>
        <summary><span class="bdh-idx"><?= sprintf('%02d', $cch_i + 1) ?></span><span class="cch-faq__q"><?= e($cch_q[0]) ?></span><span class="cch-faq__x" aria-hidden="true"></span></summary>
        <p class="p"><?= e($cch_q[1]) ?></p>
      </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<script type="application/ld+json"><?= json_encode(['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => array_map(fn ($cch_q) => ['@type' => 'Question', 'name' => $cch_q[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $cch_q[1]]], $cch_faq)], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
