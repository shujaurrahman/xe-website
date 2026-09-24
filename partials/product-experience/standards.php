<?php /* DRAFT COPY — review before launch */
/* Standards — frameworks we build to (never a certification claim), each with what it means in the work and
   where it is checked. Security frameworks appear only where AI features bring them in. */
$pxh_stn = [
    'Every product' => [
        ['wcag22', 'The default bar is Level AA: 4.5 : 1 text contrast, focus never hidden behind sticky UI (2.4.11), targets at least 24 × 24 px (2.5.8), and a single-pointer alternative to every drag (2.5.7).', 'Component tests in CI · manual screen-reader pass'],
        ['cwv', 'Budgets set during design, measured at the 75th percentile: LCP ≤ 2.5 s, INP ≤ 200 ms, CLS ≤ 0.1.', 'Lighthouse CI · field data'],
        ['gdpr', 'Consent, purpose and retention for every research recording and every analytics event we propose.', 'Consent log · retention schedule'],
        ['dpdp', 'India’s Digital Personal Data Protection Act, 2023: notice, consent and data-principal rights designed into the flows.', 'Consent and notice patterns'],
        ['iso9001', 'Quality-management principles applied to delivery: documented stages, gate reviews and logged corrective actions.', 'Gate reviews · decision records'],
    ],
    'When AI is in the product' => [
        ['eu-ai-act', 'People are told when they are interacting with AI, and the risk tier is decided while the feature is still a sketch.', 'Disclosure patterns · risk note'],
        ['nist-ai-rmf', 'Govern, map, measure and manage, mapped onto discovery, evaluation and post-launch monitoring.', 'Evaluation set · monitoring plan'],
        ['iso42001', 'The design records an AI management system asks for: intended use, oversight and change history.', 'Design documentation'],
        ['owasp-llm', 'Prompt injection (LLM01) and excessive agency (LLM06) handled in the interface: untrusted content labelled, consequential actions confirmed by a person.', 'Red-team cases in the eval set'],
    ],
];
?>
<section class="band band--alt pxh-standards" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Frameworks we build to</p>
        <h2 class="h2" id="standards-t"><span class="g">A standard is a test.</span> We say where each one runs.</h2></div>
      <div><p class="lead">These are the frameworks our design and front-end work is built to. They are not certifications we hold; each one is a set of checks with a place in the process where it is run and recorded.</p></div>
    </div>
    <?php foreach ($pxh_stn as $pxh_g => $pxh_rows): ?>
    <div class="pxh-standards__grp">
      <h3 class="pxh-mono pxh-standards__h"><?= e($pxh_g) ?></h3>
      <ul class="pxh-standards__list">
        <?php foreach ($pxh_rows as $pxh_r): ?>
        <li class="pxh-standards__r" data-rv>
          <div class="pxh-standards__b"><?= xt_badge($pxh_r[0]) ?></div>
          <p class="pxh-standards__d"><?= e($pxh_r[1]) ?></p>
          <p class="pxh-standards__w"><span class="pxh-mono">Checked in</span><?= e($pxh_r[2]) ?></p>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endforeach; ?>
  </div>
</section>
