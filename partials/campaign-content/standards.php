<?php /* DRAFT COPY — review before launch */ ?>
<?php
$cch_std = [   // [badge key, where it bites in campaign work]
    ['wcag22',      'Captions on every video cut-down, alt text on every image, 4.5 : 1 text contrast in every format, and landing pages that work with a keyboard.'],
    ['cwv',         'Campaign landing pages built to good Core Web Vitals — LCP ≤ 2.5 s, INP ≤ 200 ms, CLS ≤ 0.1 — so paid traffic is not lost to a slow page.'],
    ['gdpr',        'Consent before tracking, lawful basis for every audience list, and creator and entrant data handled under a written agreement.'],
    ['dpdp',        'The same discipline for Indian audiences: notice, consent and purpose limits on customer data used for targeting and CRM.'],
    ['eu-ai-act',   'Article 50 transparency: AI-generated or manipulated images, audio and video are labelled where the Act applies.'],
    ['nist-ai-rmf', 'The generative tools in the pipeline are governed — mapped, measured and managed — with the checks and logs to show it.'],
];
?>
<section class="band band--alt cch-std" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Frameworks we build to</p>
        <h2 class="h2" id="standards-t"><span class="g">Creative freedom,</span> inside the rules that govern advertising.</h2></div>
      <div><p class="lead">These are the standards our campaign work is designed and checked against. They are frameworks we build to, not certifications we hold.</p></div>
    </div>
    <ul class="cch-std__g">
      <?php foreach ($cch_std as $cch_s): $cch_meta = xt_standard($cch_s[0]); ?>
      <li class="cch-std__i" data-rv>
        <?= xt_badge($cch_s[0], ['variant' => 'chip']) ?>
        <h3 class="cch-std__t"><?= e($cch_meta['name'] ?? $cch_s[0]) ?></h3>
        <p class="sm"><?= e($cch_s[1]) ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
    <div class="cch-std__codes" data-rv>
      <p class="bdh-ro">Advertising codes we write to</p>
      <ul>
        <li><strong>ASCI Code</strong> and its guidelines for influencer advertising (India)</li>
        <li><strong>CAP Code</strong> for non-broadcast advertising (UK)</li>
        <li><strong>FTC Endorsement Guides</strong> for creator and review content (US)</li>
        <li>Each platform's own branded-content and paid-partnership rules</li>
      </ul>
    </div>
  </div>
</section>
