<?php /* DRAFT COPY — review before launch */
/* Craft — the bar a piece of work has to clear before it can be called delivered, and before it can appear
   on this page. Four checks with the actual thresholds, then the frameworks we build to as code-built
   badges (xt_badge). Framed as frameworks, never as certifications Xterra Edze holds. */
$wkc_checks = [
    ['accessibility', 'Accessible', 'WCAG 2.2 level AA',
     'Keyboard-only paths, visible focus, contrast and reduced-motion behaviour are tested, not assumed. Automated checks run in the pipeline; the keyboard pass is done by a person.',
     ['Keyboard path on every flow', 'Focus visible everywhere', 'Motion respects the OS setting']],
    ['gauge', 'Fast on the phone people actually own', 'Core Web Vitals in the good range',
     'Measured on field data at the 75th percentile, not in a lab: LCP at or under 2.5 s, INP at or under 200 ms, CLS at or under 0.1. The budget sits in continuous integration, so a regression fails the build.',
     ['LCP ≤ 2.5 s', 'INP ≤ 200 ms', 'CLS ≤ 0.1']],
    ['check', 'Consistent with the system', 'One set of rules, everywhere',
     'Type, colour, spacing, tone and motion come from the brand system rather than from the file that happened to be open. Components are reviewed against it before release.',
     ['Tokens, not hand-picked values', 'Components reviewed against the system', 'One source for claims language']],
    ['clipboard-check', 'Reviewed by a person', 'A named approver on every release',
     'Agents draft, test and scan. A named person approves the merge, the release and anything that makes a claim. The approval is recorded with the release.',
     ['Named approver per release', 'Claims checked against substantiation', 'Approval recorded in the log']],
];
$wkc_frameworks = ['wcag22', 'cwv', 'dora-metrics', 'sci'];
?>
<section class="band band--alt wk-craft" id="craft" aria-labelledby="craft-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The bar</p>
        <h2 class="h2" id="craft-t"><span class="g">Delivered means</span> it cleared four checks.</h2>
      </div>
      <div>
        <p class="lead">"Done" is not a feeling. Each of these has a threshold, a way of measuring it and a
          person who signs it. Work that has not cleared all four is not finished, and does not appear in
          the archive.</p>
      </div>
    </div>

    <ul class="wk-craft__grid" data-rv-s data-rv-step="70">
      <?php foreach ($wkc_checks as $wkc_i => $wkc_c): ?>
        <li class="bdh-card wk-craft__card">
          <p class="wk-craft__top">
            <span class="wk-craft__ico" aria-hidden="true"><?= xt_icon($wkc_c[0], ['size' => 22]) ?></span>
            <span class="bdh-idx"><?= str_pad((string) ($wkc_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          </p>
          <h3 class="bdh-t"><?= e($wkc_c[1]) ?></h3>
          <p class="wk-craft__thr"><?= e($wkc_c[2]) ?></p>
          <p class="bdh-d"><?= e($wkc_c[3]) ?></p>
          <ul class="wk-craft__pts">
            <?php foreach ($wkc_c[4] as $wkc_p): ?>
              <li><span class="wk-tick" aria-hidden="true">✓</span><?= e($wkc_p) ?></li>
            <?php endforeach; ?>
          </ul>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="wk-craft__std" data-rv data-rv-d="90">
      <div class="wk-craft__stdh">
        <p class="wk-k">Frameworks we build to</p>
        <p class="wk-note">Published specifications we hold the work against. They are not certifications
          Xterra Edze holds, and these badges are drawn in code, not reproduced seals.
          <!-- PLACEHOLDER: confirm which certifications, if any, Xterra Edze holds before launch --></p>
      </div>
      <ul class="wk-craft__badges">
        <?php foreach ($wkc_frameworks as $wkc_k): ?>
          <?= xt_badge($wkc_k, ['tag' => 'li', 'detail' => true]) ?>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
