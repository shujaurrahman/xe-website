<?php /* DRAFT COPY — review before launch */
/* Process — assess, prove, scale, as a stage-gate track. Three phases (3 weeks · 5 weeks · ongoing);
   each ends at a gate with written exit criteria and the people who sign it. Same calendar as the
   pace section: the two-day workshop, the prototype and the eval baseline all sit inside Assess, so
   G1 at week 3 decides on numbers; the pilot (L2, week 5) and production (L3, week 8) sit in Prove.
   process.js runs the track phase by phase on entry and ticks each gate's criteria as it arrives.
   The HTML is the finished state: every gate passed. Timings are typical ranges. */
$tas_pr = [
    [
        'key' => 'assess', 'name' => 'Assess', 'wk' => 'Wk 1–3', 'len' => '3 weeks', 'span' => 3,
        'lead' => 'Interviews, a two-day workshop in week one, then a prototype on your data and an eval baseline, so the first use case reaches G1 with numbers.',
        'out' => ['Scored use-case portfolio', 'One-page AI strategy and roadmap', 'Business cases for the first three', 'Prototype and eval baseline'],
        'lvl' => 1, 'lvl_note' => 'A prototype suggests, in a sandbox on masked data',
        'gate' => ['G1', 'Go to prove', [
            'A named owner, a measured baseline and an eval baseline for the first use case',
            'Data access agreed at read scope, sandbox ready',
            'Risk tier set and the autonomy ceiling written down',
            'Budget approved, with a cost-per-task ceiling',
        ], 'Sponsor · owner · legal', 'Passed'],
    ],
    [
        'key' => 'prove', 'name' => 'Prove', 'wk' => 'Wk 4–8', 'len' => '5 weeks', 'span' => 5,
        'lead' => 'One agent, tested on a golden set from your experts, piloted with ten users at L2 from week 5 and released at L3 in week 8, with approval on every write.',
        'out' => ['Working agent and its MCP servers', 'Eval suite, golden set, red-team results', 'Guardrail and approval policy'],
        'lvl' => 3, 'lvl_note' => 'Acts on your systems once a named person approves',
        'gate' => ['G2', 'Go to production', [
            'Eval gate passed on the golden set, adversarial cases included',
            'Zero policy violations across every run',
            'Cost per task below the ceiling, p95 time within target',
            'Guardrail policy signed by legal and security',
            'Runbooks and on-call handed over',
        ], 'Sponsor signs · owner runs', 'Passed'],
    ],
    [
        'key' => 'scale', 'name' => 'Scale', 'wk' => 'Wk 9 onward', 'len' => 'Ongoing', 'span' => 4,
        'lead' => 'The next agents from the portfolio, a governance rhythm that keeps the register live, and autonomy raised one task at a time, on evidence.',
        'out' => ['Next agents from the roadmap', 'AI inventory and risk register kept live', 'Quarterly review against the measures'],
        'lvl' => 4, 'lvl_note' => 'For named tasks, inside limits, after G3',
        'gate' => ['G3', 'Raise autonomy', [
            '90 days at L3 with approvers changing under 2% of actions',
            'Escalations answered within the agreed time',
            'No incident traced to the agent',
            'One task moves up one level, with new limits',
        ], 'Owner · risk · security', 'Every 90 days'],
    ],
];
$tas_pr_n = 0;
?>
<section class="band tas-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="tas-head" data-rv>
      <div class="tas-head__t">
        <p class="tas-kick"><span class="tas-kick__ref">09</span>How an engagement runs</p>
        <h2 class="h2" id="process-t"><span class="g">Assess, prove, scale.</span> Every phase ends at a gate.</h2>
      </div>
      <div class="tas-head__l">
        <p class="lead">Nothing moves to the next phase on enthusiasm. It moves when the numbers clear criteria agreed in the first week, and the named people sign.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm typical timeframes (Assess wk 1–3, Prove wk 4–8, autonomy review every 90 days) before launch -->
    <ol class="tas-pr" data-tas-pr data-rv aria-label="Engagement phases and their gates">
      <?php foreach ($tas_pr as $tas_pi => $tas_p): ?>
        <li class="tas-pr__ph" data-ph="<?= e($tas_p['key']) ?>" style="--i:<?= $tas_pi ?>;--span:<?= (int) $tas_p['span'] ?>">
          <div class="tas-pr__track" aria-hidden="true">
            <span class="tas-pr__wk"><?= e($tas_p['wk']) ?></span>
            <span class="tas-pr__line"><i class="tas-pr__fill"></i></span>
            <span class="tas-pr__gm"><?= $tas_p['key'] === 'scale' ? xt_icon('sync', ['size' => 14, 'mono' => true]) : '' ?><b><?= e($tas_p['gate'][0]) ?></b></span>
          </div>

          <div class="tas-pr__card">
            <p class="tas-pr__k"><span class="tas-pr__n"><?= sprintf('%02d', $tas_pi + 1) ?></span><span><?= e($tas_p['len']) ?></span></p>
            <h3 class="tas-pr__t"><?= e($tas_p['name']) ?></h3>
            <p class="tas-pr__d"><?= e($tas_p['lead']) ?></p>

            <p class="tas-lbl tas-pr__sl">Leaves with</p>
            <ul class="tas-pr__out">
              <?php foreach ($tas_p['out'] as $tas_x): ?><li><?= e($tas_x) ?></li><?php endforeach; ?>
            </ul>

            <p class="tas-pr__lv"><span class="tas-lbl">Autonomy reached</span><?= tas_lvl($tas_p['lvl']) ?><small><?= e($tas_p['lvl_note']) ?></small></p>
          </div>

          <div class="tas-pr__gate<?= $tas_p['key'] === 'scale' ? ' tas-pr__gate--loop' : '' ?>" data-gate>
            <p class="tas-pr__gh">
              <span class="tas-pr__gid"><?= e($tas_p['gate'][0]) ?></span>
              <b><?= e($tas_p['gate'][1]) ?></b>
              <span class="tas-pr__gs" data-gs><?= e($tas_p['gate'][4]) ?></span>
            </p>
            <ul class="tas-pr__crit" aria-label="<?= e($tas_p['gate'][0] . ' ' . $tas_p['gate'][1]) ?>: exit criteria">
              <?php foreach ($tas_p['gate'][2] as $tas_c): $tas_pr_n++; ?>
                <li style="--k:<?= $tas_pr_n ?>"><span class="tas-pr__cb" aria-hidden="true"></span><?= e($tas_c) ?></li>
              <?php endforeach; ?>
            </ul>
            <p class="tas-pr__who"><span class="tas-lbl">Signed by</span><?= e($tas_p['gate'][3]) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
