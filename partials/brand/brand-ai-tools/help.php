<?php /* DRAFT COPY — review before launch */
/* 02 The six tools — rendered as `brandctl --help`. Left: the command list (a vertical
   tablist, arrow keys). Right: the selected command's manual and a short example run.
   Titles, descriptions and tags come from $CAT['offer']; commands, flags and runs are draft. */
$cat_cmds = [   // offer index => [command, flags, people decide, example run lines [kind, text]]
    ['tune',     '--image --language --from ./brand-system', 'Which references the model may learn from, and whether a version ships.', [
        ['in', 'brandctl tune --image --from ./brand-system/v7'],
        ['out', 'reading 2,418 references · 311 rules · 64 examples'],
        ['out', 'fine-tuning image model · epoch 12/12'],
        ['ok', 'eval brand fidelity 0.93 ≥ gate 0.90 · awaiting sign-off'],
    ]],
    ['check',    '<asset> --rules palette,clearspace,type,tone --fix', 'Whether a flagged fix is accepted, or the asset goes back.', [
        ['in', 'brandctl check ./out/0412-f.png --fix'],
        ['ok', 'palette ΔE 1.1 · type scale · contrast AA'],
        ['err', 'logo clear space 62% of rule · 1 issue'],
        ['out', 'fix proposed: scale lockup 0.84 · recheck ✓'],
    ]],
    ['generate', '--source approved/0409 --markets all --formats 6', 'The source that is approved before a single variant is made.', [
        ['in', 'brandctl generate --source approved/0409 --markets 9'],
        ['out', 'queued 54 variants · 6 formats × 9 markets'],
        ['out', 'brand check on every output · 3 flagged'],
        ['ok', '51 to review queue · 3 returned with fixes'],
    ]],
    ['write',    '--voice your-brand --lexicon --never-say', 'Tone calls the assistant cannot make: humour, risk, apology.', [
        ['in', 'brandctl write --voice your-brand "launch line, Market 03"'],
        ['out', 'lexicon: 180 preferred · 42 never-say terms loaded'],
        ['err', 'draft 2 uses "revolutionary" · never-say · dropped'],
        ['ok', '3 drafts · tone 0.86–0.91 · sent to copy lead'],
    ]],
    ['render',   '--template retail-offer --data markets.csv', 'Which templates exist, and what content is allowed in each slot.', [
        ['in', 'brandctl render --template retail-offer --data q3.csv'],
        ['out', '9 markets × 4 sizes · locked slots: logo, legal line'],
        ['out', 'price fields localised · type fits checked'],
        ['ok', '36 assets rendered · 0 overflow · logged'],
    ]],
    ['govern',   '--policy high-stakes-review --log', 'What counts as high stakes, and who holds the final say.', [
        ['in', 'brandctl govern --policy high-stakes-review'],
        ['out', 'rule: regulated claims, people, pricing → human review'],
        ['out', 'every output logged · who, what, when, which model'],
        ['ok', 'policy active · 2 reviewers per high-stakes asset'],
    ]],
];
?>
<section class="band cat-paper cat-help" id="help" aria-labelledby="help-t">
  <div class="wrap">
    <div class="cat-head" data-rv>
      <div>
        <p class="cat-prompt"><b>$ brandctl --help</b> <span>six tools · one brand model</span></p>
        <h2 class="h2" id="help-t"><?= $CAT['offer_title'] ?></h2>
      </div>
      <p class="lead"><?= e($CAT['offer_lead']) ?></p>
    </div>

    <div class="cat-help__ui" data-rv>
      <div class="cat-help__list">
        <p class="cat-help__usage"><span>USAGE</span> brandctl &lt;command&gt; [flags]</p>
        <p class="cat-help__cap" id="help-cmds">COMMANDS</p>
        <div role="tablist" aria-labelledby="help-cmds" aria-orientation="vertical">
          <?php foreach ($CAT['offer'] as $cat_oi => $cat_o): $cat_c = $cat_cmds[$cat_oi]; ?>
            <button class="cat-help__cmd<?= $cat_oi === 0 ? ' is-on' : '' ?>" type="button" role="tab" id="help-tab-<?= $cat_oi ?>" aria-controls="help-pane-<?= $cat_oi ?>" aria-selected="<?= $cat_oi === 0 ? 'true' : 'false' ?>" tabindex="<?= $cat_oi === 0 ? '0' : '-1' ?>">
              <span class="cat-help__name"><?= e($cat_c[0]) ?></span>
              <span class="cat-help__title"><?= e($cat_o[0]) ?></span>
              <span class="cat-help__tag"><?= e($cat_o[2]) ?></span>
            </button>
          <?php endforeach; ?>
        </div>
        <p class="cat-help__keys"><span class="cat-kbd">↑</span><span class="cat-kbd">↓</span> select a command</p>
      </div>

      <div class="cat-help__panes">
        <?php foreach ($CAT['offer'] as $cat_oi => $cat_o): $cat_c = $cat_cmds[$cat_oi]; ?>
          <div class="cat-help__pane" id="help-pane-<?= $cat_oi ?>" role="tabpanel" aria-labelledby="help-tab-<?= $cat_oi ?>"<?= $cat_oi === 0 ? '' : ' hidden' ?>>
            <p class="cat-help__syn"><span>brandctl</span> <b><?= e($cat_c[0]) ?></b> <i><?= e($cat_c[1]) ?></i></p>
            <h3 class="cat-help__h"><?= e($cat_o[0]) ?></h3>
            <p class="cat-help__desc"><?= e($cat_o[1]) ?></p>
            <p class="cat-help__people"><span>People decide</span><?= e($cat_c[2]) ?></p>
            <ol class="cat-help__run" aria-label="Example run">
              <?php foreach ($cat_c[3] as $cat_ln): ?>
                <li class="is-<?= $cat_ln[0] ?>"><?= e($cat_ln[1]) ?></li>
              <?php endforeach; ?>
            </ol>
          </div>
        <?php endforeach; ?>
        <p class="cat-help__foot"><span class="cat-illus">Illustrative run</span> <!-- PLACEHOLDER: illustrative command names, flags and output — confirm before launch --></p>
      </div>
    </div>
  </div>
</section>
