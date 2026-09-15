<?php /* DRAFT COPY — review before launch */
/* 08 What you own — the ownership vault. Every artefact the tooling produces, with a switch for
   where it runs (your cloud / managed on your behalf) and a plain statement: ownership never moves.
   vault.js updates each row and the summary; Export writes a short manifest. No autoplay. */
// PLACEHOLDER: illustrative versions and sizes — confirm before launch
$cat_vault = [   // [key, ext, name, detail, size, default run]
    ['weights', '.safetensors', 'Image model weights',             'v4.2 · fine-tuned on training set v7',       '4.1 GB', 'yours'],
    ['prompts', '.json',        'Language adapter and prompt set', 'prompt set v3.1 · lexicon v3.1',             '38 MB',  'yours'],
    ['data',    '.parquet',     'Training set',                    'v7 · 2,418 references · rights records',     '19 GB',  'yours'],
    ['tests',   '.spec',        'Eval set and guardrail tests',    '11 guardrails · 640 eval cases',             '210 MB', 'yours'],
    ['logs',    '.log',         'Output log',                      'every output · who, what, when, model',      'streaming', 'managed'],
    ['rules',   '.rules',       'Brand check rules',               '311 rules · plugin and API',                 '2 MB',   'managed'],
];
$cat_run_txt = ['yours' => 'In your cloud account · your keys', 'managed' => 'Run for you · export or delete at any time'];
?>
<section class="band cat-room cat-vt" id="vault" aria-labelledby="vault-t">
  <span class="cat-room__grid" aria-hidden="true"></span>
  <div class="wrap">
    <div class="cat-head" data-rv>
      <div>
        <p class="cat-prompt"><b>$ brandctl vault ls</b> <span>ownership · <?= e($CAT['meta'][2]) ?></span></p>
        <h2 class="h2" id="vault-t"><span class="g">Weights, prompts, data and logs.</span> <?= e($CAT['outcomes'][2][0]) ?>.</h2>
      </div>
      <p class="lead"><?= e($CAT['faq'][1][0]) ?> <?= e($CAT['faq'][1][1]) ?></p>
    </div>

    <div class="cat-vt__ui">
      <div class="cat-vt__say" data-rv>
        <p class="cat-vt__big">Where a part runs is a practical choice. Who owns it is not.</p>
        <p class="cat-vt__small"><?= e($CAT['outcomes'][2][1]) ?> Choose for each part whether it lives in your cloud or is run for you. The answer to “whose is it?” stays the same either way.</p>
        <!-- PLACEHOLDER: reference photo (Unsplash) — replace before launch -->
        <figure class="cat-photo cat-vt__photo">
          <img src="<?= xe_url('assets/imgs/brand/brand-ai-tools/server-rack.jpg') ?>" alt="Rows of network cables and lit ports in a server rack" width="1200" height="800" loading="lazy" decoding="async">
          <figcaption><span>Your accounts · your keys</span></figcaption>
        </figure>
      </div>

      <div class="cat-vt__vault" data-rv>
        <div class="cat-vt__bar">
          <span class="cat-led"></span><span class="cat-vt__path">vault<i>/</i>your-brand</span>
          <span class="cat-vt__owner">owner <b>Your brand</b></span>
          <span class="cat-illus">Illustrative</span>
        </div>
        <ul class="cat-vt__rows">
          <?php foreach ($cat_vault as $cat_r): ?>
            <li class="cat-vt__row" data-run="<?= $cat_r[5] ?>">
              <span class="cat-vt__ext"><?= e($cat_r[1]) ?></span>
              <div class="cat-vt__main">
                <h3 class="cat-vt__name"><?= e($cat_r[2]) ?></h3>
                <p class="cat-vt__det"><?= e($cat_r[3]) ?> · <?= e($cat_r[4]) ?></p>
                <p class="cat-vt__state" data-vt-state><?= e($cat_run_txt[$cat_r[5]]) ?> <b>owned by you</b></p>
              </div>
              <fieldset class="cat-vt__sw">
                <legend class="bdh-sr">Where <?= e(strtolower($cat_r[2])) ?> runs</legend>
                <label><input type="radio" name="vt-<?= e($cat_r[0]) ?>" value="yours"<?= $cat_r[5] === 'yours' ? ' checked' : '' ?>><span>Your cloud</span></label>
                <label><input type="radio" name="vt-<?= e($cat_r[0]) ?>" value="managed"<?= $cat_r[5] === 'managed' ? ' checked' : '' ?>><span>Managed</span></label>
              </fieldset>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="cat-vt__foot">
          <p class="cat-vt__sum" data-vt-sum aria-live="polite">4 in your cloud · 2 managed for you · 6 of 6 owned by you</p>
          <button type="button" class="btn btn--white btn--sm cat-vt__exp" data-vt-export>Export everything <span class="i" aria-hidden="true">›</span></button>
        </div>
        <ol class="cat-vt__out" data-vt-out aria-live="polite" hidden></ol>
      </div>
    </div>
  </div>
</section>
