<?php /* DRAFT COPY — review before launch */
/* Models — the AI-native angle made concrete: models are chosen on an evaluation set, guardrails are code,
   approval is named, every output is logged. Uses the .aih-bars data-viz idiom (widths in HTML; models.js
   only animates them in when on screen). Scores are illustrative, labelled as such. */
$aih_bake = [
    ['Brand-tuned Flux model', 0.93],
    ['Adobe Firefly custom model', 0.87],
    ['SDXL with a brand LoRA', 0.84],
    ['Base model, prompt only', 0.61],
];
$aih_bake_floor = 0.85;
$aih_practice = [
    ['eval',   'An evaluation set before a model', 'Held-out prompts and scoring rules are written from the brand system first. Every candidate model is scored on them, and so is every update.'],
    ['shield', 'Guardrails as code',               'Brand, rights, claims and personal-data checks run on every output, mapped to OWASP LLM01 prompt injection and the other LLM Top 10 risks.'],
    ['approve','A named person approves',          'Review is a role in the pipeline, not a habit. The approver sees what was flagged and why, and cannot skip it.'],
    ['log',    'An audit record per output',       'Model, version, prompt, inputs, scores, checks and approver are stored with each asset and exported with content credentials.'],
];
?>
<section class="band band--alt aih-models" id="ai-native" aria-labelledby="ai-native-t">
  <div class="wrap aih-models__grid">
    <div class="aih-models__copy">
      <p class="lbl lbl--blue"><span class="dot"></span>AI-native, concretely</p>
      <h2 class="h2" id="ai-native-t"><span class="g">No favourite model.</span> The evaluation set picks.</h2>
      <p class="lead">Reputation changes every month. A scored comparison on your own material does not, so that is what decides which model does which job.</p>
      <ul class="aih-prac">
        <?php foreach ($aih_practice as $aih_p): ?>
          <li><span class="aih-prac__ic"><?= xt_icon($aih_p[0]) ?></span><div><h3 class="aih-prac__t"><?= e($aih_p[1]) ?></h3><p class="aih-prac__d"><?= e($aih_p[2]) ?></p></div></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <figure class="aih-bake">
      <figcaption class="aih-bake__h">
        <span class="aih-bake__k">Image lane · model comparison</span>
        <span class="aih-bake__t">Brand fidelity on 200 held-out prompts</span>
      </figcaption>
      <div class="aih-bake__chart">
        <ul class="aih-bars" data-aih-bars aria-label="Brand fidelity score by model, floor 0.85">
          <?php foreach ($aih_bake as $aih_i => $aih_b): ?>
            <li class="aih-bar<?= $aih_b[1] >= $aih_bake_floor ? ' aih-bar--pass' : '' ?>" style="--i:<?= $aih_i ?>">
              <span class="aih-bar__l"><?= e($aih_b[0]) ?></span>
              <span class="aih-bar__track" aria-hidden="true"><span class="aih-bar__fill" style="--v:<?= e((string) $aih_b[1]) ?>"></span><span class="aih-bar__thr" style="--t:<?= e((string) $aih_bake_floor) ?>"></span></span>
              <span class="aih-bar__v"><?= e(number_format($aih_b[1], 2)) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="aih-bake__legend"><span><i class="p"></i>Clears the floor</span><span><i class="f"></i>Below the floor</span><span><i class="t"></i>Floor 0.85</span></div>
      <dl class="aih-rec aih-bake__rec">
        <dt>Scored by</dt><dd>Automatic scorer + 3 trained raters</dd>
        <dt>Re-run</dt><dd>On every model or dataset change</dd>
        <dt>Decision</dt><dd><span class="ok">Brand-tuned model</span> · others kept as fallback</dd>
      </dl>
      <p class="aih-bake__note">Illustrative scores. Your comparison runs on your own brand material.</p>
    </figure>
  </div>
</section>
