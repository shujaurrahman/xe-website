<?php /* DRAFT COPY — review before launch */
/* Outcomes — what changes and exactly how it is measured. Each metric uses the .aih-bars idiom: baseline vs the
   typical target range. PLACEHOLDER: every figure here is an illustrative target, not an achieved result —
   confirm before launch. */
$aih_out = [
    ['Task success',          'Share of tasks real users complete on the fixed prompt set, including the cases where the model is wrong.', 'Moderated sessions, before and after', 0.58, 0.85, '58%', '85%+'],
    ['Brand pass at first go','Share of generated assets that clear the brand floor with no manual edit.',                                    'Scorer + raters on every output',     0.40, 0.80, '40%', '80%+'],
    ['Brief to approved',     'Median time from a brief entering the studio to a signed approval.',                                          'Timestamps in the audit log',         1.00, 0.30, '10 days', '3 days'],
    ['Cost per approved asset','Model spend plus review time for each asset that ships.',                                                    'Model invoices + logged review time', 1.00, 0.45, 'Index 100', 'Index 45'],
    ['Adoption at 90 days',   'People using the new workflow every week, three months after the pilot ends.',                                'Weekly active users ÷ licensed seats', 0.20, 0.70, '20%', '70%+'],
    ['Correction effort',     'Edits a person makes before accepting an AI answer or asset.',                                                 'Edit events per accepted output',     1.00, 0.40, '5 edits', '2 edits'],
];
?>
<section class="band band--ink aih-outcomes" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl"><span class="dot"></span>Outcomes, measured</p>
        <h2 class="h2" id="outcomes-t"><span class="g">If it cannot be measured,</span> it is not in the plan.</h2>
      </div>
      <div><p class="lead">Six measures agreed at the start, baselined in the first weeks and reported from the audit log rather than from impressions. Targets below are typical ranges, set per engagement.</p></div>
    </div>
    <div class="aih-oc">
      <?php foreach ($aih_out as $aih_i => $aih_o): ?>
        <article class="aih-oc__i">
          <p class="aih-oc__n"><?= str_pad((string) ($aih_i + 1), 2, '0', STR_PAD_LEFT) ?></p>
          <h3 class="aih-oc__t"><?= e($aih_o[0]) ?></h3>
          <p class="aih-oc__d"><?= e($aih_o[1]) ?></p>
          <!-- PLACEHOLDER: confirm illustrative baseline and target before launch -->
          <ul class="aih-bars" data-aih-bars aria-label="<?= e($aih_o[0]) ?>: typical baseline <?= e($aih_o[5]) ?>, typical target <?= e($aih_o[6]) ?>">
            <li class="aih-bar" style="--i:0"><span class="aih-bar__l">Baseline</span><span class="aih-bar__track" aria-hidden="true"><span class="aih-bar__fill" style="--v:<?= e((string) $aih_o[3]) ?>"></span></span><span class="aih-bar__v"><?= e($aih_o[5]) ?></span></li>
            <li class="aih-bar aih-bar--pass" style="--i:1"><span class="aih-bar__l">Target</span><span class="aih-bar__track" aria-hidden="true"><span class="aih-bar__fill" style="--v:<?= e((string) $aih_o[4]) ?>"></span></span><span class="aih-bar__v"><?= e($aih_o[6]) ?></span></li>
          </ul>
          <p class="aih-oc__m"><span>Measured by</span> <?= e($aih_o[2]) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
