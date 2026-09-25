<?php /* DRAFT COPY — review before launch */
/* The generation run — this page's signature interactive, and the component the four capability subpages
   reuse for their own briefs.
 *
 * Choose one of four briefs and the panel shows how that piece of work is actually produced: the route
 * (which model or tool takes which step, and why), the gates it has to clear, and the record the run
 * leaves behind. One brief deliberately FAILS a gate, because a gate that always passes is decoration.
 *
 * Controls: a vertical ARIA tablist for the briefs (arrow keys, Home / End via BDH.tabs) and a
 * step-through for the gate chain (previous / next / replay) with a polite live status. The step-through
 * is shipped hidden and revealed by run.js, because without JavaScript it would have nothing to drive.
 * Without JavaScript the tablist is hidden and all four runs stack, each under its own title.
 *
 * PLACEHOLDER: every figure below is illustrative, not a client result. Confirm or replace before launch.
 */
/* the glyph inside a gate's dot: a tick for a pass, a cross for a fail, the gate number otherwise */
$run_glyph = function (string $run_state, int $run_i): string {
    $run_p = ['stroke' => ' fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"'];
    if ($run_state === 'pass') {
        return '<svg viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M2.6 6.3 4.9 8.6 9.4 3.5"' . $run_p['stroke'] . '/></svg>';
    }
    if ($run_state === 'fail') {
        return '<svg viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M3.4 3.4l5.2 5.2M8.6 3.4 3.4 8.6"' . $run_p['stroke'] . '/></svg>';
    }
    return str_pad((string) ($run_i + 1), 2, '0', STR_PAD_LEFT);
};

$run_briefs = [
    [
        'n'     => '01',
        'name'  => 'Launch film, six markets',
        'cap'   => 'ai-content-studio',
        'scope' => '6 markets · 4 aspect ratios · 24 deliverables',
        'lead'  => 'One approved idea, directed once, produced into every cut the channels ask for.',
        'route' => [
            ['plan',     'slug', 'anthropic',    'Shot list and script from the approved brief.',                 'one call · reviewed by the director'],
            ['stills',   'mark', 'Flux',         'Key frames generated on the brand-tuned adapter.',              'tuned on your own assets'],
            ['motion',   'mark', 'Runway · Veo', 'Fourteen shots, four seconds each, then cut and graded.',       'model chosen per shot'],
            ['voice',    'mark', 'ElevenLabs',   'Six languages from one consented voice.',                       'written consent on file'],
            ['assemble', 'slug', 'n8n',          'Formats, crops, naming and delivery run by the pipeline.',      'no manual exports'],
        ],
        'gates' => [
            ['Rights & consent',  'pass',  '24 of 24 inputs licensed or consented'],
            ['Brand fidelity',    'pass',  '0.91 against a 0.85 release threshold'],
            ['Guardrails',        'pass',  'no third-party marks, no named likeness'],
            ['Provenance',        'pass',  'C2PA credentials written, label per market'],
            ['Human approval',    'human', 'a named reviewer signed all 24 assets'],
        ],
        'record' => [
            ['Brief',        'film/launch-q3 · direction v3'],
            ['Route',        '5 steps · 3 tools · 1 language model'],
            ['Inputs',       '24 asset ids, each with a licence or consent record'],
            ['Settings',     'prompt and parameter hash stored per asset'],
            ['Approver',     'named reviewer · timestamped'],
            ['Disclosure',   'synthetic media label, per market rules'],
        ],
        'stat' => [['Deliverables', '24', 'assets'], ['Brand fidelity', '0.91', 'scored'], ['Rights record', '100%', 'complete'], ['Approvals', '1', 'named']],
    ],
    [
        'n'     => '02',
        'name'  => 'Packshot set, 240 products',
        'cap'   => 'brand-ai-tools',
        'scope' => '240 products · 5 scenes each · one tuned model',
        'lead'  => 'The run that did not ship. A gate that never fails is decoration, so here is one failing.',
        'route' => [
            ['dataset', 'slug', 'huggingface', '1,840 controlled captures, labelled and rights-checked.', 'held-out set kept back for scoring'],
            ['tune',    'slug', 'pytorch',     'Three adapter candidates on an open-weight base.',        'compared, not guessed'],
            ['score',   'slug', 'mlflow',      'Palette, material, label legibility and proportion.',     'run on every version'],
            ['serve',   'slug', 'modal',       'Endpoint plus a plugin inside the design tool.',           'cost and rate capped'],
        ],
        'gates' => [
            ['Rights & consent', 'pass', '1,840 of 1,840 captures owned by you'],
            ['Brand fidelity',   'fail', '0.71 against 0.85 · label legibility 0.54'],
            ['Guardrails',       'held', 'not run — the release stopped at gate 02'],
            ['Provenance',       'held', 'not run'],
            ['Human approval',   'held', 'never reached'],
        ],
        'back'   => 'Adapter v6 was held back. Two hundred more controlled captures were added for the labels that scored worst, and v7 re-scored 0.91 on the same held-out set and was released. v6 stayed available until v7 had run for a week.',
        'record' => [
            ['Version',   'adapter v6 · blocked · adapter v7 · released'],
            ['Dataset',   '1,840 items · 184 held out · 60 counter-examples'],
            ['Scores',    'per criterion, per version, against the same set'],
            ['Decision',  'recorded with the reason and the owner'],
            ['Rollback',  'v6 kept servable for one week after v7 shipped'],
        ],
        'stat' => [['Products', '240', 'SKUs'], ['v6 fidelity', '0.71', 'blocked'], ['v7 fidelity', '0.91', 'released'], ['Releases stopped', '1', 'by a gate']],
    ],
    [
        'n'     => '03',
        'name'  => 'Support assistant answer',
        'cap'   => 'ai-application-design',
        'scope' => 'one customer question · four steps · a person one tap away',
        'lead'  => 'A single answer, and everything the interface has to show for a person to judge it.',
        'route' => [
            ['classify', 'slug', 'mistralai',  'Intent and risk read on a small, cheap model.',                  'most questions never need a large one'],
            ['retrieve', 'slug', 'llamaindex', 'Your own documents, with the passage kept for the citation.',     'eight passages, ranked'],
            ['answer',   'slug', 'anthropic',  'A grounded answer, cited, in the brand voice.',                   'streamed as it arrives'],
            ['act',      'slug', 'langgraph',  'Any action taken only after the customer approves the step.',      'and reversible afterwards'],
            ['escalate', 'mark', 'Your team',  'A route to a person offered on every answer.',                     'never buried'],
        ],
        'gates' => [
            ['Prompt injection', 'pass',  'OWASP LLM01 suite run before release'],
            ['Grounding',        'pass',  'every claim traced to a retrieved passage'],
            ['Tone & refusal',   'pass',  'voice rules 0.93 · refusal wording reviewed'],
            ['Excessive agency', 'pass',  'OWASP LLM06 · no action without approval'],
            ['Human route',      'human', 'escalation offered on every answer'],
        ],
        'record' => [
            ['Session',   'conversation id · prompt version · model version'],
            ['Sources',   'the passage ids the answer was built from'],
            ['Cost',      'tokens and cost per answer, by route'],
            ['Latency',   'time to first token and time to complete'],
            ['Outcome',   'resolved, corrected, abandoned or escalated'],
        ],
        'stat' => [['p95 latency', '1.4', 'seconds'], ['Cited answers', '100%', 'with a source'], ['Small-model share', '78%', 'of questions'], ['Escalation', '1', 'tap away']],
    ],
    [
        'n'     => '04',
        'name'  => 'Launch copy, nine locales',
        'cap'   => 'brand-ai-tools',
        'scope' => '9 locales · 6 channels · one voice model',
        'lead'  => 'Volume in language, with the claims held constant and a native speaker in every market.',
        'route' => [
            ['draft',    'slug', 'openai',        'First drafts from the brand voice model, lexicon loaded.', 'your words, not a default register'],
            ['localise', 'slug', 'googlegemini',  'Nine locales, with the claims held constant.',             'transcreated, not translated'],
            ['check',    'slug', 'python',        'Voice rules, banned words and reading level, scored.',      'automated, on every variant'],
            ['review',   'mark', 'Native speaker','A person in each market before anything releases.',         'required, not optional'],
        ],
        'gates' => [
            ['Lexicon',           'pass',  'zero banned terms · 3 automatic rewrites'],
            ['Voice score',       'pass',  '0.93 against a 0.90 threshold'],
            ['Claim check',       'pass',  '4 claims referred to counsel · 4 cleared'],
            ['Market lines',      'pass',  'per-market legal lines inserted'],
            ['Human approval',    'human', 'a native speaker signed each locale'],
        ],
        'record' => [
            ['Source',     'one approved master, versioned'],
            ['Variants',   '54 pieces · locale, channel and length'],
            ['Scores',     'voice score and reading level per variant'],
            ['Referrals',  'claims sent to counsel, with the answer attached'],
            ['Approver',   'named reviewer per locale · timestamped'],
        ],
        'stat' => [['Locales', '9', 'markets'], ['Voice score', '0.93', 'vs 0.90'], ['Claims cleared', '4/4', 'by counsel'], ['Approvals', '9', 'named']],
    ],
];
?>
<noscript><style>
  /* without JavaScript the tablist cannot switch panes, so drop it and stack all four runs */
  .aih-run__briefs,.aih-run__step{display:none}
  .aih-run__panes{display:block}
  .aih-run__pane{opacity:1;visibility:visible;transform:none}
  .aih-run__pane+.aih-run__pane{margin-top:34px;padding-top:30px;border-top:1px solid var(--on-ink-line)}
  .aih-run__grid{grid-template-columns:minmax(0,1fr)}
</style></noscript>
<section class="band band--ink aih-run" id="run" aria-labelledby="run-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The generation run</p>
        <h2 class="h2" id="run-t"><span class="g">Pick a brief.</span> See what has to be true before it ships.</h2>
      </div>
      <div>
        <p class="lead">Generating is the cheap part. This is the rest of it: a route chosen per step, a set of gates the work has to clear, and a record it leaves behind. Brief 02 fails a gate, because a gate that always passes is decoration.</p>
        <p class="aih-note">Four illustrative runs, one per capability. Figures are examples, not results.</p>
      </div>
    </div>

    <div class="aih-panel aih-run__ui" data-rv data-rv-d="60" data-bdh-live>
      <div class="aih-panel__bar">
        <span class="aih-panel__dots"><i></i><i></i><i></i></span>
        <span class="aih-panel__title">run inspector <i>/</i> your brand</span>
        <span class="aih-panel__ill aih-panel__sp">Illustrative</span>
        <span class="aih-panel__live"><i class="bdh-pulse"></i>4 runs</span>
      </div>

      <div class="aih-panel__body aih-run__grid">
        <div class="aih-run__side">
          <p class="aih-k" id="run-briefs-l">Briefs</p>
          <div class="bdh-tabs aih-run__briefs" role="tablist" aria-labelledby="run-briefs-l">
            <?php foreach ($run_briefs as $run_i => $run_b): ?>
              <button class="aih-run__b" type="button" role="tab" id="run-t<?= $run_i ?>"
                      aria-controls="run-p<?= $run_i ?>" aria-selected="<?= $run_i === 0 ? 'true' : 'false' ?>"
                      tabindex="<?= $run_i === 0 ? '0' : '-1' ?>">
                <b><?= e($run_b['n']) ?></b>
                <span><?= e($run_b['name']) ?></span>
              </button>
            <?php endforeach; ?>
          </div>
          <p class="aih-note aih-run__sn">Every run is the same five gates in a different shape. The capability decides what each gate measures.</p>
        </div>

        <div class="bdh-panes aih-run__panes">
          <?php foreach ($run_briefs as $run_i => $run_b): ?>
            <div class="bdh-pane aih-run__pane<?= $run_i === 0 ? ' is-on' : '' ?>" id="run-p<?= $run_i ?>" role="tabpanel"
                 aria-labelledby="run-t<?= $run_i ?>" tabindex="0">
              <header class="aih-run__ph">
                <p class="aih-run__pt"><b><?= e($run_b['n']) ?></b><?= e($run_b['name']) ?></p>
                <p class="aih-run__ps aih-ro"><?= e($run_b['scope']) ?></p>
                <p class="aih-run__pl"><?= e($run_b['lead']) ?></p>
                <a class="aih-caplink" href="#<?= e($run_b['cap']) ?>"><b><?= e($CAPS[$run_b['cap']]['n']) ?></b><span><?= e($CAPS[$run_b['cap']]['name']) ?></span><i aria-hidden="true">›</i></a>
              </header>

              <div class="aih-run__block">
                <p class="aih-k">Route · chosen per step, on evidence</p>
                <ul class="aih-run__route">
                  <?php foreach ($run_b['route'] as $run_r): ?>
                    <li>
                      <span class="aih-run__rk"><?= e($run_r[0]) ?></span>
                      <span class="aih-run__rm">
                        <?php if ($run_r[1] === 'slug'): ?>
                          <?= xt_logo($run_r[2], ['size' => 17, 'label' => true]) ?>
                        <?php else: ?>
                          <span class="aih-mark"><?= e($run_r[2]) ?></span>
                        <?php endif; ?>
                      </span>
                      <span class="aih-run__rd"><?= e($run_r[3]) ?></span>
                      <span class="aih-run__rw"><?= e($run_r[4]) ?></span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>

              <div class="aih-run__block aih-run__gb">
                <p class="aih-k">Gates · all five recorded</p>
                <ol class="aih-gates aih-run__gates">
                  <?php foreach ($run_b['gates'] as $run_gi => $run_g): ?>
                    <li class="aih-gate" data-state="<?= e($run_g[1]) ?>">
                      <span class="aih-gate__dot"><?= $run_glyph($run_g[1], $run_gi) ?></span>
                      <span class="aih-gate__t"><?= e($run_g[0]) ?></span>
                      <span class="aih-gate__s"><?= $run_g[1] === 'human' ? 'Person' : ($run_g[1] === 'held' ? 'Held' : ucfirst($run_g[1])) ?></span>
                      <span class="aih-gate__v"><?= e($run_g[2]) ?></span>
                    </li>
                  <?php endforeach; ?>
                </ol>
                <?php if (!empty($run_b['back'])): ?>
                  <p class="aih-run__back"><span class="aih-k aih-k--ink">Returned</span><?= e($run_b['back']) ?></p>
                <?php endif; ?>
              </div>

              <div class="aih-run__block">
                <p class="aih-k">Record · written whether the run ships or not</p>
                <dl class="aih-run__rec">
                  <?php foreach ($run_b['record'] as $run_rc): ?>
                    <div><dt><?= e($run_rc[0]) ?></dt><dd><?= e($run_rc[1]) ?></dd></div>
                  <?php endforeach; ?>
                </dl>
              </div>

              <dl class="aih-panel__foot aih-run__foot">
                <?php foreach ($run_b['stat'] as $run_st): ?>
                  <div><dt><?= e($run_st[0]) ?></dt><dd><b><?= e($run_st[1]) ?></b> <?= e($run_st[2]) ?></dd></div>
                <?php endforeach; ?>
              </dl>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="aih-run__step" hidden>
        <p class="aih-k">Step through the gates</p>
        <div class="aih-run__sc">
          <button class="aih-run__sb" type="button" data-run-prev>
            <span aria-hidden="true">‹</span> Previous gate
          </button>
          <button class="aih-run__sb" type="button" data-run-next>
            Next gate <span aria-hidden="true">›</span>
          </button>
          <button class="aih-run__sb aih-run__sb--r" type="button" data-run-replay>Replay run</button>
        </div>
        <p class="aih-run__st aih-ro" role="status" aria-live="polite" data-run-status></p>
      </div>
    </div>
  </div>
</section>
