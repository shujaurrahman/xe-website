<?php /* DRAFT COPY — review before launch */
/* Signature — a pilot portfolio scored on value (y) and feasibility (x), the shortlist picked from the top-right,
   and an adoption roadmap in three horizons. Items carry data-s (step 1–4). Scores are illustrative. */
$aid_pilots = [
    // [id, name, value 0–1, feasibility 0–1, picked?]
    ['P1', 'Service assistant',      0.82, 0.72, true],
    ['P2', 'Product copy studio',    0.68, 0.88, true],
    ['P3', 'Contract review',        0.80, 0.38, false],
    ['P4', 'Demand forecast notes',  0.34, 0.60, false],
    ['P5', 'Brand image model',      0.62, 0.66, true],
    ['P6', 'Voice sales coach',      0.46, 0.22, false],
];
$aid_sig = [
    'head'  => 'portfolio <b>/</b> your-company <b>/</b> quarterly review',
    'sr'    => 'Illustration: an AI pilot portfolio. Six candidate pilots are plotted by business value against feasibility. Three in the high-value, high-feasibility quadrant are picked: a product copy studio, a service assistant and a brand image model. An adoption roadmap sequences them over 0 to 90 days, 3 to 6 months and 6 to 12 months, with contract review held until its data is ready.',
    'steps' => [
        ['Score',    'Step 1 of 4: six candidate pilots are scored on value and feasibility.'],
        ['Threshold','Step 2 of 4: the high-value, high-feasibility quadrant is marked.'],
        ['Pick',     'Step 3 of 4: three pilots are picked from that quadrant.'],
        ['Roadmap',  'Step 4 of 4: the picked pilots are sequenced into an adoption roadmap.'],
    ],
];
ob_start(); ?>
<div class="aid-port">
  <div class="aid-plot">
    <span class="aid-plot__y">Value</span><span class="aid-plot__x">Feasibility</span>
    <div class="aid-plot__area">
      <span class="aid-plot__q" data-s="2"><em>Pilot now</em></span>
      <?php foreach ($aid_pilots as $aid_p): ?>
        <span class="aid-dot<?= $aid_p[4] ? ' is-pick' : '' ?>" data-s="1" style="--x:<?= $aid_p[3] ?>;--y:<?= $aid_p[2] ?>"><i<?= $aid_p[4] ? ' data-s="3"' : '' ?>></i><b><?= e($aid_p[0]) ?></b></span>
      <?php endforeach; ?>
    </div>
  </div>
  <ol class="aid-legend" data-s="1">
    <?php foreach ($aid_pilots as $aid_p): ?>
      <li class="<?= $aid_p[4] ? 'is-pick' : '' ?>"><b><?= e($aid_p[0]) ?></b><span><?= e($aid_p[1]) ?></span><em><?= number_format($aid_p[2], 2) ?> · <?= number_format($aid_p[3], 2) ?></em></li>
    <?php endforeach; ?>
  </ol>
</div>
<ol class="aid-road" data-s="4">
  <li><span class="aid-k"><span>0–90 days</span></span><b>P2 Product copy studio</b><small>Eval set ready · low risk</small></li>
  <li><span class="aid-k"><span>3–6 months</span></span><b>P1 Service assistant</b><small>Approval rules first</small></li>
  <li><span class="aid-k"><span>6–12 months</span></span><b>P5 Brand image model</b><small>P3 after data clean-up</small></li>
</ol>
<?php $aid_sig['body'] = ob_get_clean();
