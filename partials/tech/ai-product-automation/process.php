<?php /* DRAFT COPY — review before launch */
/* 04.9 Process — the delivery plan as a live Gantt ($CAP['process']). Fourteen week columns; the four phases
   as bars placed on their weeks (each bar is a tab that opens its detail below); an exit gate at the end of
   each phase; the golden set growing week by week; and eval-gated releases, weekly once the build starts.
   A playhead sweeps the plan while it is on screen (process.js); the HTML is the finished plan.
   Timeframes are typical, not promised. */
$tapp = $CAP['process'];
$tapp_weeks = 14;
$tapp_span = [[1, 2], [2, 5], [5, 12], [12, 14]];   // week ranges, matching $tapp['steps'][n][1]
$tapp_extra = [   // per phase: [exit gate, what you see each week, where AI speeds it up]
    ['Golden set v1 signed off: 40 to 60 real questions or documents, each with the expected answer and its source, written with your domain experts.',
     'Two working sessions with the people who own the answers. The data inventory and access plan by the end of week 2.',
     'Agents cluster past tickets and search logs into candidate questions, so experts review a draft rather than write from nothing.'],
    ['The chosen design beats the baseline on the golden set, inside the latency and cost budget agreed for launch.',
     'A working prototype on your own documents by week 3. The model comparison table updated every Friday.',
     'Three or four retrieval and model designs are scored overnight on the golden set, so the choice is made on numbers in days, not months.'],
    ['All eight release gates green in CI. A pilot group of named users has used it for real work for two weeks.',
     'A demo every Friday on staging, with that week’s eval scores beside it. Nothing is shown that has not passed the gates.',
     'Coding agents draft tests, adapters and UI states; every change is reviewed by an engineer and re-scored before merge.'],
    ['Online groundedness and handover rate hold for four weeks. Runbook, dashboards and ownership handed to your team.',
     'Weekly releases behind the eval gate. A monthly quality and cost review with the feature owner.',
     'A daily sample of production answers is scored automatically; only the flagged ones reach a person for review.'],
];
$tapp_gates = ['G1', 'G2', 'G3', 'G4'];
$tapp_golden = [0, 40, 60, 90, 120, 150, 170, 190, 210, 230, 240, 260, 320, 400];   // questions in the golden set at the end of each week
$tapp_rel = [   // week => [kind: int (internal, eval-gated) | prod | block, label]
    4  => ['int', 'proto v3'],   5 => ['int', 'v4'],  6 => ['int', 'v5'],   7 => ['int', 'v6'],  8 => ['int', 'v7'],
    9  => ['block', 'v8 · blocked'], 10 => ['int', 'v8.1'], 11 => ['int', 'v9 · pilot'],
    12 => ['prod', 'v10 · canary'], 13 => ['prod', 'v11'], 14 => ['prod', 'v12'],
];
$tapp_gmax = 400;
?>
<section class="band band--alt tap-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="tap-head" data-rv>
      <div>
        <p class="tap-eb"><span class="tap-eb__box" aria-hidden="true"></span><span class="tap-eb__n">04.9</span><span>Process</span><span class="tap-eb__p">/process</span></p>
        <h2 class="h2" id="process-t"><span class="g">From prototype</span> to feature in production.</h2>
      </div>
      <div>
        <!-- PLACEHOLDER: confirm "prototype in the first sprint" and weekly release cadence before launch -->
        <p class="lead"><?= e($tapp['lead']) ?> A working prototype on your documents in the first sprint; after launch, prompt, model and retrieval changes ship weekly, each one scored before it reaches a user.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm typical timeframes (Wk 01–14) before launch -->
    <div class="tap-plan tap-sheet" data-rv>
      <div class="tap-win__bar tap-plan__bar">
        <span class="tap-win__path"><b>delivery plan</b> · one AI feature · <?= $tapp_weeks ?> weeks · 4 exit gates</span>
        <span class="tap-win__end"><span class="tap-plan__now" aria-hidden="true">week <b data-plan-wk><?= $tapp_weeks ?></b> of <?= $tapp_weeks ?></span><span class="tap-ill">Typical plan</span></span>
      </div>

      <div class="tap-plan__chart" style="--wk:<?= $tapp_weeks ?>" data-plan>
        <span class="tap-plan__grid" aria-hidden="true"><?= str_repeat('<i></i>', $tapp_weeks) ?></span>
        <span class="tap-plan__head" aria-hidden="true" style="--p:<?= $tapp_weeks ?>"><i></i></span>

        <div class="tap-plan__row tap-plan__row--ruler" aria-hidden="true">
          <span class="tap-plan__k">Week</span>
          <span class="tap-plan__track">
            <?php for ($tapp_w = 1; $tapp_w <= $tapp_weeks; $tapp_w++): ?><span class="tap-plan__wk" style="--c:<?= $tapp_w ?>"><?= sprintf('%02d', $tapp_w) ?></span><?php endfor; ?>
          </span>
        </div>

        <div class="tap-plan__phases" role="tablist" aria-label="Delivery phases" aria-orientation="vertical">
          <?php foreach ($tapp['steps'] as $tapp_i => $tapp_s):
              [$tapp_a, $tapp_b] = $tapp_span[$tapp_i]; ?>
            <div class="tap-plan__row tap-plan__row--ph" data-ph="<?= $tapp_i ?>" data-a="<?= $tapp_a ?>" data-b="<?= $tapp_b ?>" style="--a:<?= $tapp_a ?>;--n:<?= $tapp_b - $tapp_a + 1 ?>">
              <span class="tap-plan__k" aria-hidden="true"><b><?= sprintf('%02d', $tapp_i + 1) ?></b><?= e($tapp_s[0]) ?><small><?= e($tapp_s[1]) ?></small></span>
              <span class="tap-plan__track">
                <button type="button" role="tab" class="tap-plan__bar-b" id="plan-t<?= $tapp_i ?>" aria-controls="plan-p<?= $tapp_i ?>" aria-selected="<?= $tapp_i === 1 ? 'true' : 'false' ?>" tabindex="<?= $tapp_i === 1 ? '0' : '-1' ?>">
                  <span class="tap-plan__fill" aria-hidden="true"></span>
                  <span class="tap-plan__bl"><span class="bdh-sr"><?= e($tapp_s[0]) ?>, </span><?= e($tapp_s[1]) ?></span>
                  <span class="tap-plan__bl tap-plan__bl--on" aria-hidden="true"><?= e($tapp_s[1]) ?></span>
                </button>
                <span class="tap-plan__gate" aria-hidden="true" style="--c:<?= $tapp_b ?>"><i></i><b><?= $tapp_gates[$tapp_i] ?></b></span>
              </span>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="tap-plan__row tap-plan__row--gold" aria-hidden="true">
          <span class="tap-plan__k">Golden set<small>questions</small></span>
          <span class="tap-plan__track">
            <?php foreach ($tapp_golden as $tapp_w => $tapp_g): ?>
              <span class="tap-plan__col" style="--c:<?= $tapp_w + 1 ?>;--h:<?= round($tapp_g / $tapp_gmax, 3) ?>"><i></i><?php if (in_array($tapp_w + 1, [2, 5, 12, 14], true)): ?><b><?= $tapp_g ?></b><?php endif; ?></span>
            <?php endforeach; ?>
          </span>
        </div>

        <div class="tap-plan__row tap-plan__row--rel" aria-hidden="true">
          <span class="tap-plan__k">Releases<small>eval-gated</small></span>
          <span class="tap-plan__track">
            <?php foreach ($tapp_rel as $tapp_w => $tapp_r): ?>
              <span class="tap-plan__rel tap-plan__rel--<?= $tapp_r[0] ?>" style="--c:<?= $tapp_w ?>" title="<?= e($tapp_r[1]) ?>"><i></i></span>
            <?php endforeach; ?>
          </span>
        </div>

        <ul class="tap-plan__legend" aria-hidden="true">
          <li><i class="tap-plan__lg tap-plan__lg--int"></i>Internal build, passed the gates</li>
          <li><i class="tap-plan__lg tap-plan__lg--block"></i>Blocked by a gate, fixed next day</li>
          <li><i class="tap-plan__lg tap-plan__lg--prod"></i>Production release</li>
          <li><i class="tap-plan__lg tap-plan__lg--gate"></i>Exit gate</li>
        </ul>
      </div>
      <p class="bdh-sr">A typical fourteen-week plan. Frame runs weeks 1 to 2, Prototype weeks 2 to 5, Build weeks 5 to 12 and Operate weeks 12 to 14, each ending at an exit gate. The golden set grows from 40 questions in week 2 to 400 by week 14. From week 4 every build is scored against it; one release in week 9 is blocked and fixed the next day, and weekly production releases start in week 12.</p>

      <div class="bdh-panes tap-plan__panes">
        <?php foreach ($tapp['steps'] as $tapp_i => $tapp_s): $tapp_x = $tapp_extra[$tapp_i]; ?>
          <div class="bdh-pane tap-plan__pane<?= $tapp_i === 1 ? ' is-on' : '' ?>" id="plan-p<?= $tapp_i ?>" role="tabpanel" aria-labelledby="plan-t<?= $tapp_i ?>">
            <div class="tap-plan__pmain">
              <p class="tap-plan__pk"><span>Phase <?= sprintf('%02d', $tapp_i + 1) ?> of <?= count($tapp['steps']) ?></span><span><?= e($tapp_s[1]) ?></span></p>
              <h3 class="tap-plan__pt"><?= e($tapp_s[0]) ?></h3>
              <p class="tap-plan__pd"><?= e($tapp_s[2]) ?></p>
              <ul class="tap-plan__outs" role="list" aria-label="Outputs">
                <?php foreach ($tapp_s[3] as $tapp_o): ?><li><?= xt_icon('doc', ['size' => 14, 'mono' => true]) ?><?= e($tapp_o) ?></li><?php endforeach; ?>
              </ul>
            </div>
            <dl class="tap-plan__facts">
              <div class="tap-plan__gatef"><dt><span class="tap-plan__gi" aria-hidden="true"></span>Exit gate <?= $tapp_gates[$tapp_i] ?></dt><dd><?= e($tapp_x[0]) ?></dd></div>
              <div><dt><?= xt_icon('calendar', ['size' => 16]) ?>Every week you see</dt><dd><?= e($tapp_x[1]) ?></dd></div>
              <div><dt><?= xt_icon('agent', ['size' => 16]) ?>Where AI speeds it up</dt><dd><?= e($tapp_x[2]) ?></dd></div>
            </dl>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
