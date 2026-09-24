<?php /* DRAFT COPY — review before launch */ ?>
<?php
$ind_base = [
    ['lock', 'Personal data', 'Consent notices in plain language, purpose limitation, data-principal rights and breach response — designed into forms, CRMs and analytics.', 'DPDP Act 2023 and Rules; GDPR for EU residents.', ['dpdp', 'gdpr']],
    ['accessibility', 'Accessibility', 'WCAG 2.2 AA as the floor: visible focus that is never obscured, targets of at least 24 × 24 CSS px, accessible authentication, no drag-only controls.', 'WCAG 2.2 AA; EU Accessibility Act from June 2025.', ['wcag22']],
    ['gauge', 'Performance', 'Pages budgeted to the Core Web Vitals “good” thresholds at the 75th percentile of real visits.', 'LCP ≤ 2.5 s · INP ≤ 200 ms · CLS ≤ 0.1.', ['cwv']],
    ['agent', 'AI governance', 'Every AI feature ships with an eval set, guardrails, a human approval step where it matters, and an audit log of what it produced.', 'OWASP LLM Top 10 (LLM01 prompt injection); ISO/IEC 42001; NIST AI RMF.', ['owasp-llm', 'iso42001', 'nist-ai-rmf']],
    ['shield', 'Security', 'Threat-modelled builds, least-privilege access, dependency and secret scanning, and incident runbooks.', 'OWASP ASVS; ISO/IEC 27001 controls; CERT-In 6-hour incident reporting.', ['owasp-asvs', 'iso27001', 'cert-in']],
];
?>
<section class="band band--ink ind-x" id="cross-industry" aria-labelledby="cross-industry-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Across every sector</p>
        <h2 class="h2" id="cross-industry-t"><span class="g">The baseline travels.</span> Five standards every programme meets.</h2></div>
      <div><p class="lead">Sector rules change. These do not. They are built into every brief, every build and every review, whichever category you compete in.</p></div>
    </div>
    <ol class="ind-x__list">
      <?php foreach ($ind_base as $ind_n => $ind_b): ?>
      <li class="ind-x__row">
        <span class="ind-x__n bdh-ro"><?= sprintf('%02d', $ind_n + 1) ?></span>
        <span class="ind-x__ico"><?= xt_icon($ind_b[0]) ?></span>
        <h3 class="ind-x__t"><?= e($ind_b[1]) ?></h3>
        <p class="ind-x__d"><?= e($ind_b[2]) ?></p>
        <p class="ind-x__spec bdh-ro"><?= e($ind_b[3]) ?></p>
        <div class="ind-x__b"><?php foreach ($ind_b[4] as $ind_k) echo xt_badge($ind_k, ['variant' => 'chip']); ?></div>
      </li>
      <?php endforeach; ?>
    </ol>
    <p class="ind-x__note sm">Frameworks we build to — not a claim of certification. Where a programme needs formal certification, we prepare the evidence your auditor will ask for.</p>
  </div>
</section>
