<?php /* DRAFT COPY — review before launch */
/* 10 Deliverables — the artefact registry as a bay of hardware modules. Each $CAT['deliver'] row is
   a module: status strip (LED, state, version), name, what it does, its formats as ports, and a
   pull command. Pull copies the command and runs a short pull readout. Filters dim modules that
   do not match rather than removing them, so the bay keeps its shape. */
// PLACEHOLDER: illustrative versions, package names and sizes — confirm before launch
$cat_reg_meta = [   // aligned to $CAT['deliver'] order: [package, version, status, size, what it does]
    ['image-model',     '4.2.0', 'released',  '6.4 GB', 'Image model fine-tuned on your identity, so generation starts on brand.'],
    ['language-kit',    '3.1.0', 'released',  '380 MB', 'Adapter and prompt set that write in your voice and lexicon.'],
    ['brand-check',     '2.3.1', 'released',  '42 MB',  'Scores any asset against the rules and returns fixes with reasons.'],
    ['gen-pipeline',    '1.8.0', 'released',  '120 MB', 'Generates variants from approved sources in every format you ship.'],
    ['template-engine', '1.4.2', 'released',  '64 MB',  'Fills templates with content and keeps layout inside the rules.'],
    ['guardrails',      '1.1.0', 'released',  '8 MB',   'Tests and eval set every model version must pass before release.'],
    ['output-log',      'live',  'streaming', '—',      'Who made what, with which model, and who approved it.'],
];
$cat_kinds = ['all' => 'All', 'weights' => 'Weights', 'api' => 'API', 'tests' => 'Tests', 'dashboard' => 'Dashboard'];
$cat_kind_of = function (string $f): string {
    $k = [];
    foreach (['weights' => 'Weights', 'api' => 'API', 'tests' => 'Tests', 'dashboard' => 'Dashboard'] as $cat_kk => $cat_kw) { if (stripos($f, $cat_kw) !== false) $k[] = $cat_kk; }
    return implode(' ', $k);
};
$cat_reg_n = count($CAT['deliver']);
?>
<section class="band cat-paper cat-rg" id="registry" aria-labelledby="registry-t">
  <div class="wrap">
    <div class="cat-head" data-rv>
      <div>
        <p class="cat-prompt"><b>$ brandctl registry ls</b> <span>deliverables · <?= $cat_reg_n ?> artefacts</span></p>
        <h2 class="h2" id="registry-t"><span class="g">Every artefact versioned,</span> registered and handed over.</h2>
      </div>
      <p class="lead">What the programme builds lands in a registry you control, each with a format, a version and a named owner. Pull any of it without asking us.</p>
    </div>

    <div class="cat-rg__bay" data-rv>
      <div class="cat-rg__bar">
        <div class="cat-rg__chips" role="group" aria-label="Highlight artefacts by kind">
          <?php foreach ($cat_kinds as $cat_kk => $cat_kl): ?>
            <button type="button" class="cat-rg__chip" data-rg-f="<?= $cat_kk ?>" aria-pressed="<?= $cat_kk === 'all' ? 'true' : 'false' ?>"><?= e($cat_kl) ?></button>
          <?php endforeach; ?>
        </div>
        <p class="cat-rg__count" aria-live="polite"><b data-rg-n><?= $cat_reg_n ?></b> of <?= $cat_reg_n ?> match <span class="cat-illus">Illustrative versions</span></p>
      </div>

      <ul class="cat-rg__grid" role="list">
        <?php foreach ($CAT['deliver'] as $cat_di => $cat_d):
            $cat_rm = $cat_reg_meta[$cat_di] ?? ['artefact-' . $cat_di, '1.0.0', 'released', '—', ''];
            $cat_cmd = 'brandctl pull ' . $cat_rm[0] . '@' . $cat_rm[1];
            $cat_live = $cat_rm[2] === 'streaming'; ?>
          <li class="cat-rg__mod cat-rg__mod--<?= $cat_di < 2 ? 'lg' : ($cat_live ? 'wide' : 'sm') ?>" data-kind="<?= e($cat_kind_of($cat_d[1])) ?>">
            <div class="cat-rg__strip">
              <span class="cat-rg__u">U<?= sprintf('%02d', $cat_di + 1) ?></span>
              <span class="cat-rg__state"><span class="cat-led<?= $cat_live ? ' cat-led--pulse' : '' ?>" aria-hidden="true"></span><?= e($cat_rm[2]) ?></span>
              <span class="cat-rg__ver"><?= $cat_live ? 'live' : 'v' . e($cat_rm[1]) ?></span>
            </div>
            <div class="cat-rg__body">
              <h3 class="cat-rg__name"><?= e($cat_d[0]) ?></h3>
              <p class="cat-rg__what"><?= e($cat_rm[4]) ?></p>
              <p class="cat-rg__ports"><span class="bdh-sr">Formats:</span><?php foreach (explode(' · ', $cat_d[1]) as $cat_fmt): ?><span class="cat-rg__port"><?= e($cat_fmt) ?></span><?php endforeach; ?></p>
              <dl class="cat-rg__spec">
                <div><dt>Owner</dt><dd>Your brand</dd></div>
                <div><dt>Size</dt><dd><?= e($cat_rm[3]) ?></dd></div>
                <?php if ($cat_live): ?><div><dt>Events today</dt><dd data-rg-tick>18,204</dd></div><?php endif; ?>
              </dl>
            </div>
            <div class="cat-rg__foot">
              <code class="cat-rg__cmd"><?= e($cat_cmd) ?></code>
              <button type="button" class="cat-rg__pull" data-rg-copy="<?= e($cat_cmd) ?>" aria-label="Copy pull command for <?= e($cat_d[0]) ?>"><span data-rg-lbl>Pull</span></button>
              <span class="cat-rg__prog" aria-hidden="true"><i></i></span>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
