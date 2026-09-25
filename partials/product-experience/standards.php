<?php /* DRAFT COPY — review before launch */
/* Standards — only the frameworks this discipline genuinely works to, as code-built badges (xt_badge;
   never official seals). Accessibility and Core Web Vitals belong here; security certifications do not,
   and the note at the foot says so rather than leaving it implied. The WCAG 2.2 criteria and the Core
   Web Vitals thresholds are named exactly as the specifications state them. */
$std_groups = [
    ['Quality &amp; accessibility', 'Every engagement, whatever it is.', ['wcag22', 'cwv', 'iso9001']],
    ['AI governance', 'AI product work, where a model is in the journey.', ['eu-ai-act', 'nist-ai-rmf', 'iso42001', 'owasp-llm']],
    ['Privacy', 'Research data, participants, and the product’s own data.', ['gdpr', 'dpdp']],
];
/* the manual pass, criterion by criterion. 'new' marks the ones added in WCAG 2.2. */
$std_wcag = [
    ['1.3.1', 'Info and Relationships',              'A',  false],
    ['1.4.3', 'Contrast (Minimum)',                  'AA', false],
    ['1.4.10', 'Reflow',                             'AA', false],
    ['1.4.11', 'Non-text Contrast',                  'AA', false],
    ['1.4.12', 'Text Spacing',                       'AA', false],
    ['2.1.1', 'Keyboard',                            'A',  false],
    ['2.4.3', 'Focus Order',                         'A',  false],
    ['2.4.7', 'Focus Visible',                       'AA', false],
    ['2.4.11', 'Focus Not Obscured (Minimum)',       'AA', true],
    ['2.5.7', 'Dragging Movements',                  'AA', true],
    ['2.5.8', 'Target Size (Minimum)',               'AA', true],
    ['3.2.6', 'Consistent Help',                     'A',  true],
    ['3.3.7', 'Redundant Entry',                     'A',  true],
    ['3.3.8', 'Accessible Authentication (Minimum)', 'AA', true],
    ['4.1.2', 'Name, Role, Value',                   'A',  false],
];
$std_cwv = [
    ['LCP', 'Largest Contentful Paint', '2.5', 's',  'How long the largest thing on the screen takes to appear.'],
    ['INP', 'Interaction to Next Paint', '200', 'ms', 'How long the page takes to respond to a tap or a key press.'],
    ['CLS', 'Cumulative Layout Shift',  '0.1', '',   'How much the layout moves under the reader after it has loaded.'],
];
?>
<section class="band pxh-standards" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Standards</p>
        <h2 class="h2" id="standards-t"><span class="g">Frameworks</span> this discipline works to.</h2>
      </div>
      <div>
        <p class="lead">These are the ones the work actually touches: accessibility and performance on every engagement, AI governance where a model is in the journey, and privacy because research means holding people’s data. Every badge here is drawn in code by us; none is an official seal.</p>
      </div>
    </div>

    <div class="pxh-std__groups">
      <?php foreach ($std_groups as $std_gi => $std_g): ?>
        <div class="pxh-std__group" data-rv data-rv-d="<?= $std_gi * 60 ?>">
          <div class="pxh-std__gh">
            <p class="pxh-k"><b><?= str_pad((string) ($std_gi + 1), 2, '0', STR_PAD_LEFT) ?></b> <?= $std_g[0] ?></p>
            <p class="pxh-std__gd"><?= $std_g[1] ?></p>
          </div>
          <ul class="xt-badges pxh-std__wall" role="list" aria-label="<?= e(strip_tags($std_g[0])) ?>">
            <?php foreach ($std_g[2] as $std_k) { echo xt_badge($std_k, ['detail' => true, 'apply' => true, 'tag' => 'li']); } ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="pxh-std__detail">
      <div class="pxh-std__wcag" data-rv>
        <p class="pxh-k">The manual pass · WCAG 2.2 AA</p>
        <p class="pxh-std__dt">Automated checks find perhaps a third of it. These are the criteria a person checks by hand, on every key journey.</p>
        <ul class="pxh-std__crit" role="list">
          <?php foreach ($std_wcag as $std_c): ?>
            <li>
              <span class="pxh-std__cn"><?= e($std_c[0]) ?></span>
              <span class="pxh-std__ct"><?= e($std_c[1]) ?></span>
              <span class="pxh-std__cl"><?= e($std_c[2]) ?></span>
              <?php if ($std_c[3]): ?><span class="pxh-std__cnew">New in 2.2</span><?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="pxh-note">Target Size (Minimum) asks for at least 24 × 24 CSS pixels, or enough spacing to meet its exception. Focus Not Obscured (Minimum) means a focused control is never entirely hidden behind a sticky header or a toolbar. WCAG 2.2 removed 4.1.1 Parsing, so nothing is reported against it. The enhanced versions — 2.4.12 and 3.3.9 — are level AAA and outside an AA commitment; we flag them when they are cheap to meet anyway.</p>
      </div>

      <div class="pxh-std__side" data-rv data-rv-d="80">
        <div class="pxh-std__cwv">
          <p class="pxh-k">Core Web Vitals · good at p75</p>
          <p class="pxh-std__cwt">Three thresholds, measured on real page loads rather than on our laptops.</p>
          <dl class="pxh-std__cwl">
            <?php foreach ($std_cwv as $std_m): ?>
              <div>
                <dt><span class="pxh-std__ma"><?= e($std_m[0]) ?></span><?= e($std_m[1]) ?></dt>
                <dd class="pxh-std__mv">&#8804; <b><?= e($std_m[2]) ?></b><?= $std_m[3] !== '' ? ' ' . e($std_m[3]) : '' ?></dd>
                <dd class="pxh-std__md"><?= e($std_m[4]) ?></dd>
              </div>
            <?php endforeach; ?>
          </dl>
          <p class="pxh-note">Good means all three at or under those values at the 75th percentile of page loads, read separately for mobile and desktop. INP replaced First Input Delay as a Core Web Vital in March 2024. Budgets are enforced in CI so a regression fails the merge rather than the quarter.</p>
        </div>

        <!-- PLACEHOLDER: confirm any certification Xterra Edze itself holds before launch -->
        <div class="pxh-std__honest">
          <p class="pxh-k">What these badges do not say</p>
          <p><b>Alignment describes how we work.</b> It is not a claim that Xterra Edze holds a certification. ISO 9001 is an organisation-level management system whose practices we follow in delivery, and WCAG 2.2 AA conformance is a statement your organisation publishes about a product, not a certificate anyone issues.</p>
          <p>Security attestations are deliberately absent. Penetration testing, ISO/IEC 27001 and SOC 2 belong to the discipline that engineers the systems, and are claimed there rather than here.</p>
          <a class="tl" href="<?= xe_url('services/technology-intelligence.php') ?>">Security and platform standards <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>
  </div>
</section>
