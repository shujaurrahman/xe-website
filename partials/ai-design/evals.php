<?php /* DRAFT COPY — review before launch */
/* Evals — the scorecard. Three things this discipline scores (an image model, a voice and copy model,
   an assistant's answers), each with its own criteria, its own release threshold and the version it is
   being compared against.
 *
 * The scorecard (.aih-score + .aih-meter) is the second half of the data-viz idiom, and the capability
 * subpages reuse it for their own criteria. Tabs are ARIA tabs driven by BDH.tabs; the first pane is on
 * in the shipped HTML, and the <noscript> rule below stacks all three so nothing is unreachable.
 *
 * PLACEHOLDER: every score is an illustration of how a release decision is argued, not a client result.
 */
$ev_sets = [
    [
        'n'     => '01',
        'name'  => 'Image model',
        'sub'   => 'Brand fidelity · adapter v6 → v7',
        'th'    => 0.85,
        'prev'  => 'v6',
        'cand'  => 'v7',
        'rows'  => [
            ['Palette accuracy',      'Colour distance from the brand palette, sampled per image', 0.88, 0.94],
            ['Mark use & clear space','The logo located, measured against the clear-space rule',   0.79, 0.90],
            ['Typography',            'Approved faces, weights and tracking, read from the output',0.74, 0.88],
            ['Composition & crop',    'Against the grid, the safe areas and the crop rules',       0.83, 0.89],
            ['Product accuracy',      'Proportion, material and label legibility on real products',0.54, 0.91],
            ['Tone & register',       'A human panel, calibrated against the automated score',     0.86, 0.92],
        ],
        'verdict' => ['Released', 'v7 was released. Nothing regressed, and product accuracy moved from the one criterion that blocked v6 to a clear pass. v6 stayed servable for a week afterwards.'],
    ],
    [
        'n'     => '02',
        'name'  => 'Voice & copy model',
        'sub'   => 'Voice fidelity · prompt set v4 → v5',
        'th'    => 0.90,
        'prev'  => 'v4',
        'cand'  => 'v5',
        'rows'  => [
            ['Lexicon',        'Approved terms present, banned terms absent, per variant',      0.91, 0.97],
            ['Register & rhythm','Sentence length, person and tense against the voice rules',   0.86, 0.93],
            ['Claim discipline','No unsubstantiated claim, no comparative without a source',    0.94, 0.96],
            ['Reading level',  'Against the target reading level for each market',              0.88, 0.92],
            ['Locale fit',     'A native-speaker panel score, per market',                      0.84, 0.91],
        ],
        'verdict' => ['Released', 'Locale fit was the blocker. Two markets needed a glossary of their own before the set cleared, which is a data fix rather than a prompt fix.'],
    ],
    [
        'n'     => '03',
        'name'  => 'Assistant answers',
        'sub'   => 'Answer quality · prompt set v11 → v14',
        'th'    => 0.85,
        'prev'  => 'v11',
        'cand'  => 'v14',
        'rows'  => [
            ['Faithfulness',        'Every claim traceable to a retrieved passage',                0.82, 0.94],
            ['Citation presence',   'A source the reader can open, on every answer that makes one',0.71, 1.00],
            ['Refusal correctness', 'Declines what it should, and only what it should',            0.88, 0.93],
            ['Task completion',     'The fixed task set, completed without help',                  0.69, 0.86],
            ['Correction effort',   'Edits per accepted answer, inverted to a score',              0.74, 0.88],
            ['Brand voice',         'The same voice rules, applied to a generated answer',         0.90, 0.92],
        ],
        'verdict' => ['Released', 'Task completion cleared last, and it cleared after a retrieval change rather than a prompt change. That is the usual answer: the words were rarely the problem.'],
    ],
];
$ev_rules = [
    ['A held-out set',            'Kept back from training, never tuned on, and versioned with the brand.'],
    ['Counter-examples included', 'The set says what the brand must not produce as well as what it should.'],
    ['Calibrated to people',      'The automated scorer is checked against a human panel each quarter. Where they disagree, the panel is right and the scorer is retuned.'],
    ['No quiet regression',       'No criterion may fall by more than 0.03, even when the average rises.'],
    ['Scored before release',     'Every version, with the report and the weights handed over, not summarised.'],
    ['A way back',                'The previous version stays servable until the new one has run for a week.'],
];
?>
<noscript><style>
  .aih-ev__tabs{display:none}
  .aih-ev__panes{display:block}
  .aih-ev__pane{opacity:1;visibility:visible;transform:none}
  .aih-ev__pane+.aih-ev__pane{margin-top:34px;padding-top:30px;border-top:1px solid var(--line)}
</style></noscript>
<section class="band band--alt aih-ev" id="evals" aria-labelledby="evals-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Evaluation</p>
        <h2 class="h2" id="evals-t"><span class="g">Four good samples</span> are not a release decision.</h2>
      </div>
      <div>
        <p class="lead">Before anything is released, it is scored against a fixed set written with your brand team: criterion by criterion, against the version it replaces, against a threshold agreed in advance. A release that cannot be argued from the scorecard does not happen.</p>
        <p class="aih-note">Three different things get scored here, so there are three different scorecards.</p>
      </div>
    </div>

    <div class="bdh-grid aih-ev__grid">
      <div class="bdh-c8 aih-ev__main" data-rv data-rv-d="40">
        <div class="bdh-tabs aih-ev__tabs" role="tablist" aria-label="What is being scored">
          <?php foreach ($ev_sets as $ev_i => $ev_s): ?>
            <button class="aih-ev__tab" type="button" role="tab" id="ev-t<?= $ev_i ?>" aria-controls="ev-p<?= $ev_i ?>"
                    aria-selected="<?= $ev_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $ev_i === 0 ? '0' : '-1' ?>">
              <b><?= e($ev_s['n']) ?></b><span><?= e($ev_s['name']) ?></span>
            </button>
          <?php endforeach; ?>
        </div>

        <div class="bdh-panes aih-ev__panes">
          <?php foreach ($ev_sets as $ev_i => $ev_s): ?>
            <div class="bdh-pane aih-ev__pane<?= $ev_i === 0 ? ' is-on' : '' ?>" id="ev-p<?= $ev_i ?>" role="tabpanel" aria-labelledby="ev-t<?= $ev_i ?>" tabindex="0">
              <div class="aih-panel aih-panel--flat aih-ev__card">
                <div class="aih-panel__bar">
                  <span class="aih-panel__title"><?= e($ev_s['name']) ?> <i>/</i> <?= e($ev_s['sub']) ?></span>
                  <span class="aih-panel__ill aih-panel__sp">Illustrative</span>
                </div>
                <div class="aih-panel__body">
                  <div class="aih-ev__legend">
                    <span><i class="aih-ev__lk aih-ev__lk--cand" aria-hidden="true"></i><?= e($ev_s['cand']) ?> · candidate</span>
                    <span><i class="aih-ev__lk aih-ev__lk--prev" aria-hidden="true"></i><?= e($ev_s['prev']) ?> · in service, marked below</span>
                    <span><i class="aih-ev__lk aih-ev__lk--th" aria-hidden="true"></i><?= e(number_format($ev_s['th'], 2)) ?> · threshold, marked above</span>
                  </div>

                  <div class="aih-score aih-ev__score">
                    <?php foreach ($ev_s['rows'] as $ev_ri => $ev_r):
                        $ev_d = $ev_r[3] - $ev_r[2]; ?>
                      <div class="aih-score__r">
                        <p class="aih-score__n"><?= e($ev_r[0]) ?><small><?= e($ev_r[1]) ?></small></p>
                        <span class="aih-meter" aria-hidden="true">
                          <i class="bdh-grow<?= $ev_r[3] < $ev_s['th'] ? ' is-under' : '' ?>" style="--v:<?= $ev_r[3] ?>;--i:<?= $ev_ri ?>"></i>
                          <em style="--p:<?= $ev_r[2] ?>"></em>
                          <span style="--t:<?= $ev_s['th'] ?>"></span>
                        </span>
                        <p class="aih-score__v"><?= e(number_format($ev_r[3], 2)) ?><small><?= $ev_d >= 0 ? '+' : '−' ?><?= e(number_format(abs($ev_d), 2)) ?></small></p>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <p class="aih-ev__verdict"><span class="aih-k aih-k--ink"><?= e($ev_s['verdict'][0]) ?></span><?= e($ev_s['verdict'][1]) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="bdh-c4 aih-ev__side" data-rv data-rv-d="80">
        <h3 class="aih-ev__sh">The release rule</h3>
        <dl class="aih-ev__rules">
          <?php foreach ($ev_rules as $ev_ru): ?>
            <div><dt><?= e($ev_ru[0]) ?></dt><dd><?= e($ev_ru[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
        <a class="tl" href="#brand-ai-tools">Where the scoring set is built <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>
  </div>
</section>
