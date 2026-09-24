<?php /* DRAFT COPY — review before launch */
/* Signature — a generation pipeline: one brief, each asset routed to the model that won its evaluation, scored
   against the brand floor, and held for a person. Items carry data-s (step 1–4). Scores are illustrative. */
$aid_rows = [
    // [asset, format, model, why chosen, score, state, ok?]
    ['Hero still',      '4:5 · 4 markets', 'Flux + brand LoRA',      'won eval 0.91 vs 0.84', '0.93', 'Approved',  true],
    ['Product cut-outs','×12 · PNG',       'Adobe Firefly',          'licensed training data','0.88', 'Approved',  true],
    ['Launch film',     '15 s · 9:16',     'Veo',                    'motion 0.87 vs 0.79',   '0.86', 'In review', true],
    ['Voice-over',      'EN · HI',         'ElevenLabs',             'consented voice only',  '0.90', 'Approved',  true],
    ['Product copy',    '×4 languages',    'Gemini',                 'tone 0.92 vs 0.88',     '0.81', 'Returned',  false],
];
$aid_sig = [
    'head'  => 'studio <b>/</b> your-brand <b>/</b> brief B-118',
    'sr'    => 'Illustration: a content studio pipeline. One brief for a monsoon range launch in four markets is split into five assets. Each is routed to a different model with the reason it won its evaluation: a brand-tuned Flux model for the hero still, Adobe Firefly for product cut-outs, Veo for the film, ElevenLabs with a consented voice for the voice-over and Gemini for product copy. Each output is scored against a brand floor of 0.85; four pass and the product copy, at 0.81, is returned for another pass before a person approves.',
    'steps' => [
        ['Brief',    'Step 1 of 4: one brief enters the studio.'],
        ['Route',    'Step 2 of 4: each asset is routed to the model that won its evaluation.'],
        ['Score',    'Step 3 of 4: every output is scored against the brand floor of 0.85.'],
        ['Review',   'Step 4 of 4: passing assets wait for a person; the product copy is returned.'],
    ],
];
ob_start(); ?>
<div class="aid-brief" data-s="1">
  <p class="aid-k"><span>Brief</span><span>Due in 5 days</span></p>
  <p class="aid-brief__t">“Monsoon range launch. Four markets, English and Hindi.”</p>
  <ul class="aid-chips"><li>4 markets</li><li>2 languages</li><li>5 asset types</li></ul>
</div>
<div class="aid-route">
  <p class="aid-route__h"><span>Asset</span><span>Model · why</span><span>Brand</span><span>State</span></p>
  <ol>
    <?php foreach ($aid_rows as $aid_rw): ?>
      <li class="aid-route__r<?= $aid_rw[6] ? '' : ' is-flag' ?>">
        <span class="aid-route__a"><b><?= e($aid_rw[0]) ?></b><small><?= e($aid_rw[1]) ?></small></span>
        <span class="aid-route__m" data-s="2"><b><?= e($aid_rw[2]) ?></b><small><?= e($aid_rw[3]) ?></small></span>
        <span class="aid-route__s" data-s="3"><span class="aid-meter" style="--v:<?= e($aid_rw[4]) ?>"><i></i><em></em></span><b><?= e($aid_rw[4]) ?></b></span>
        <span class="aid-route__st" data-s="4"><?= e($aid_rw[5]) ?></span>
      </li>
    <?php endforeach; ?>
  </ol>
  <p class="aid-route__f" data-s="4"><span>Floor 0.85 · marked on each meter</span><span>4 of 5 passed · 1 returned</span></p>
</div>
<?php $aid_sig['body'] = ob_get_clean();
