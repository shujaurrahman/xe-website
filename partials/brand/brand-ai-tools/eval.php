<?php /* DRAFT COPY — review before launch */
/* 06 Evaluation — model versions compared as small multiples against a release gate.
   Six metrics × four versions, drawn as inline SVG (dots + slope, gate line, area under the gate).
   Pick a version to read every multiple at once; eval.js cycles versions until touched. */
// PLACEHOLDER: illustrative evaluation figures — confirm before launch
$cat_versions = ['v3.0', 'v4.0', 'v4.1', 'v4.2'];
$cat_vnote = ['Base model, prompts only', 'First brand tune', 'Re-tuned on pilot output', 'Re-tuned with lexicon v3.1'];
$cat_metrics = [   // [metric, what it measures, gate, values per version]
    ['Brand fidelity',    'Eval set rated against the identity',     .90, [.71, .86, .91, .93]],
    ['Palette accuracy',  'Outputs within ΔE 2.0 of palette v7',     .95, [.78, .93, .97, .98]],
    ['Clear space held',  'Lockups placed inside the rule',          .98, [.62, .95, .99, .99]],
    ['Tone score',        'Copy scored against the voice',           .80, [.66, .82, .77, .86]],
    ['Review approval',   'Share approved at first human review',    .70, [.41, .63, .74, .79]],
    ['Rights blocked',    'Unclear references stopped before render', 1.0, [.90, 1.0, 1.0, 1.0]],
];
$cat_x = [22, 88, 154, 218];
$cat_y = fn ($v) => round(104 - ($v - .5) / .5 * 90, 1);   // domain 0.50–1.00 → y 104–14
$cat_gates = [];   // per version: gates passed
foreach ($cat_versions as $cat_vi => $cat_v) {
    $cat_gates[$cat_vi] = 0;
    foreach ($cat_metrics as $cat_m) { if ($cat_m[3][$cat_vi] >= $cat_m[2]) $cat_gates[$cat_vi]++; }
}
$cat_sel = 3;
?>
<section class="band cat-room cat-ev" id="eval" aria-labelledby="eval-t">
  <span class="cat-room__grid" aria-hidden="true"></span>
  <div class="wrap">
    <div class="cat-head" data-rv>
      <div>
        <p class="cat-prompt"><b>$ brandctl eval --gate release</b> <span>every version against the same eval set</span></p>
        <h2 class="h2" id="eval-t"><span class="g">A version ships when it clears the gate</span> and a person signs it off.</h2>
      </div>
      <p class="lead">Each tuned model is scored on a fixed evaluation set built from your brand. The gate is automatic; the release is not. A version that passes on numbers can still be held on judgement.</p>
    </div>

    <div class="cat-ev__ui" data-rv data-ev-sel="<?= $cat_sel ?>">
      <div class="cat-ev__pick">
        <p class="cat-ev__cap" id="ev-pick">Compare version</p>
        <div class="cat-ev__vers" role="group" aria-labelledby="ev-pick">
          <?php foreach ($cat_versions as $cat_vi => $cat_v): ?>
            <button type="button" class="cat-ev__ver" data-ev-v="<?= $cat_vi ?>" aria-pressed="<?= $cat_vi === $cat_sel ? 'true' : 'false' ?>">
              <b><?= e($cat_v) ?></b><span><?= e($cat_vnote[$cat_vi]) ?></span><em><?= $cat_gates[$cat_vi] ?>/<?= count($cat_metrics) ?> gates</em>
            </button>
          <?php endforeach; ?>
        </div>
        <div class="cat-ev__verdict" aria-live="polite">
          <?php foreach ($cat_versions as $cat_vi => $cat_v):
              $cat_fail = array_values(array_filter($cat_metrics, fn ($cat_m) => $cat_m[3][$cat_vi] < $cat_m[2]));
              $cat_ok = !$cat_fail; ?>
            <div class="cat-ev__vd<?= $cat_ok ? ' is-ok' : '' ?>" data-ev-vd="<?= $cat_vi ?>"<?= $cat_vi === $cat_sel ? '' : ' hidden' ?>>
              <p class="cat-ev__vs"><span class="cat-led<?= $cat_ok ? '' : ' cat-led--wait' ?>"></span><?= $cat_ok ? 'Gate passed' : 'Held at the gate' ?></p>
              <p class="cat-ev__vt"><?php if ($cat_ok): ?><?= e($cat_v) ?> cleared all <?= count($cat_metrics) ?> gates. Released after sign-off by the Brand lead.<?php else: ?><?= e($cat_v) ?> missed <?= count($cat_fail) ?>: <?= e(implode(', ', array_map(fn ($cat_m) => strtolower($cat_m[0]), $cat_fail))) ?>. Not released.<?php endif; ?></p>
            </div>
          <?php endforeach; ?>
        </div>
        <p class="cat-ev__foot"><span class="cat-illus">Illustrative</span> Domain 0.50–1.00 · gate marked</p>
      </div>

      <ul class="cat-ev__grid">
        <?php foreach ($cat_metrics as $cat_mi => $cat_m):
            $cat_gy = $cat_y($cat_m[2]);
            $cat_pts = implode(' ', array_map(fn ($cat_i) => $cat_x[$cat_i] . ',' . $cat_y($cat_m[3][$cat_i]), array_keys($cat_x))); ?>
          <li class="cat-ev__m" style="--i:<?= $cat_mi ?>">
            <div class="cat-ev__mh">
              <h3 class="cat-ev__h"><?= e($cat_m[0]) ?></h3>
              <p class="cat-ev__read"><?php foreach ($cat_m[3] as $cat_vi => $cat_val): ?><span data-ev-r="<?= $cat_vi ?>" class="<?= $cat_val >= $cat_m[2] ? 'is-ok' : 'is-no' ?>"<?= $cat_vi === $cat_sel ? '' : ' hidden' ?>><?= number_format($cat_val, 2) ?></span><?php endforeach; ?></p>
            </div>
            <p class="cat-ev__md"><?= e($cat_m[1]) ?> · gate <?= number_format($cat_m[2], 2) ?></p>
            <svg class="cat-ev__svg" viewBox="0 0 240 118" role="img" aria-label="<?= e($cat_m[0] . ': ' . implode(', ', array_map(fn ($cat_i) => $cat_versions[$cat_i] . ' ' . number_format($cat_m[3][$cat_i], 2), array_keys($cat_versions))) . '. Gate ' . number_format($cat_m[2], 2)) ?>">
              <rect class="cat-ev__below" x="0" y="<?= $cat_gy ?>" width="240" height="<?= 108 - $cat_gy ?>"/>
              <line class="cat-ev__axis" x1="0" y1="108" x2="240" y2="108"/>
              <line class="cat-ev__gate" x1="0" y1="<?= $cat_gy ?>" x2="240" y2="<?= $cat_gy ?>"/>
              <text class="cat-ev__gt" x="2" y="<?= $cat_gy - 5 ?>" text-anchor="start">gate <?= number_format($cat_m[2], 2) ?></text>
              <g class="cat-ev__plot">
                <polyline class="cat-ev__line" points="<?= $cat_pts ?>"/>
                <?php foreach ($cat_x as $cat_i => $cat_px): $cat_val = $cat_m[3][$cat_i]; ?>
                  <line class="cat-ev__col" data-ev-c="<?= $cat_i ?>" x1="<?= $cat_px ?>" y1="10" x2="<?= $cat_px ?>" y2="108"/>
                  <circle class="cat-ev__dot <?= $cat_val >= $cat_m[2] ? 'is-ok' : 'is-no' ?>" data-ev-d="<?= $cat_i ?>" cx="<?= $cat_px ?>" cy="<?= $cat_y($cat_val) ?>" r="4.5"/>
                <?php endforeach; ?>
              </g>
            </svg>
            <p class="cat-ev__xs" aria-hidden="true"><?php foreach ($cat_versions as $cat_v): ?><span><?= e($cat_v) ?></span><?php endforeach; ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
