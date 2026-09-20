<?php /* DRAFT COPY — review before launch */
/* Evals — the harness dashboard. Five gate metrics with the last eight runs as sparklines, success by
   scenario against its gate (must-escalate and must-refuse cases carry a 100% gate), a per-step model
   comparison, and the regression timeline. The regression is an agent failure, not a score dip: a
   prompt change lets the agent call its write tool before the policy check (a trajectory check
   catches it), the CI gate blocks the merge, the fix moves the rule into the tool router, and the
   re-run passes. evals.js grows the bars, draws the sparklines and lights the timeline run by run
   (all four rows stay on screen). Every figure is illustrative. HTML = the finished dashboard. */
$tas_ev_agent = 'renewals-agent';
$tas_ev_set   = 'golden set v10';
$tas_ev_kpis  = [   // [key, label, value, target, spark values · last 8 runs]
    ['success', 'Task success',        '94.2%',  'gate ≥ 92%',         [88, 90, 91, 93, 92, 91, 94, 94.2]],
    ['tool',    'Tool-call accuracy',  '98.1%',  'gate ≥ 97%',         [95, 96, 97, 97, 98, 96, 98, 98.1]],
    ['policy',  'Policy violations',   '0',      'must be 0',          [0, 0, 0, 0, 0, 6, 0, 0]],
    ['cost',    'Cost per task',       '$0.021', 'manual $4.80',       [0.034, 0.031, 0.029, 0.026, 0.024, 0.024, 0.022, 0.021]],
    ['p95',     'p95 time per task',   '6.8 s',  'gate ≤ 10 s',        [9.4, 9.1, 8.6, 8.2, 7.9, 7.7, 7.0, 6.8]],
];
$tas_ev_scen = [   // [scenario, cases, success %, gate %, rule tag]
    ['Standard renewal',                          64, 98,  95,  ''],
    ['Seats changed mid-term',                    38, 96,  92,  ''],
    ['Discount over the limit',                   25, 100, 100, 'must escalate'],
    ['Usage data missing',                        25, 88,  85,  ''],
    ['Prompt injection in the account notes',     30, 100, 100, 'must refuse · LLM01'],
    ['Ambiguous contract term',                   36, 84,  80,  'must ask'],
];
$tas_ev_cases = array_sum(array_column($tas_ev_scen, 1));
$tas_ev_models = ['router-small', 'reasoner-large', 'open-weight 70B'];
$tas_ev_mnote  = ['hosted · fast', 'hosted · strongest', 'self-hosted · in-region'];
$tas_ev_rows = [   // [metric, [A, B, C], best index]
    ['Task success',       ['86.1%', '94.6%', '91.7%'], 1],
    ['Tool-call accuracy', ['97.4%', '98.3%', '97.9%'], 1],
    ['Cost per task',      ['$0.006', '$0.058', '$0.031'], 0],
    ['p95 time per task',  ['3.9 s', '7.4 s', '8.1 s'], 0],
    ['Policy violations',  ['0', '0', '0'], -1],
];
$tas_ev_verdict = ['Routes, classifies, extracts', 'Drafts and reasons', 'Fallback where data must stay in-region'];
/* right-sizing: the same golden set with every step on the large model, then routed per step with
   retrieved context cached. Energy is an illustrative estimate; SCI method from the Green Software
   Foundation (ISO/IEC 21031:2024). */
$tas_ev_rz = [   // [configuration, cost per task, success, est. Wh per task, bar 0–1]
    ['Every step on reasoner-large',         '$0.058', '94.6%', '2.4 Wh', 1],
    ['Routed per step · context cached',     '$0.021', '94.2%', '0.9 Wh', 0.36],
];
$tas_ev_runs = [   // [state, run id, prompt, summary, gate text, trajectory diff or null]
    ['ok',   'run 0412', 'renewals v13',   '214 / 214 gates passed · every trajectory in the allowed tool order', 'merge allowed', null],
    ['fail', 'run 0418', 'renewals v14',   'Trajectory check failed: crm.update_quote called before policy.check in 6 of 25 “discount over the limit” cases, so the agent wrote instead of escalating', 'merge blocked',
        [['draft', 'policy.check', 'crm.update_quote'], ['draft', 'crm.update_quote', 'policy.check']]],
    ['fix',  'fix',      'renewals v14.1', 'Write tools now unlock only after policy.check passes, enforced in the tool router rather than the prompt · 4 trajectory cases added (218)', 'awaiting re-run', null],
    ['ok',   'run 0419', 'renewals v14.1', '218 / 218 gates passed · 0 out-of-order tool calls · released after sign-off by the Sales ops lead', 'merge allowed', null],
];
$tas_ev_how = [
    ['users',  'Golden sets with your experts',  'Cases drawn from real tickets and labelled by the people who do the work. The set grows every sprint with the edge cases production finds.'],
    ['eval',   'LLM-as-judge, calibrated',        'A judge model scores every case; its agreement with human labels (Cohen’s κ, target ≥ 0.8) is checked each release.'],
    ['bug',    'Adversarial cases',               'Prompt injection, over-limit actions, missing data. Must-refuse and must-escalate cases carry a 100% gate.'],
    ['pipeline','Eval gate in CI',                'Every prompt, tool, model or retrieval change runs the suite, tool-order checks included, before merge. A failed gate blocks it.'],
];
$tas_ev_spark = function (array $v): string {
    $min = min($v); $max = max($v); $span = ($max - $min) ?: 1;
    $pts = [];
    foreach ($v as $i => $x) { $pts[] = round($i * (100 / (count($v) - 1)), 1) . ',' . round(28 - ($x - $min) / $span * 24, 1); }
    return implode(' ', $pts);
};
?>
<section class="band band--alt tas-evals" id="evals" aria-labelledby="evals-t">
  <div class="wrap">
    <div class="tas-head" data-rv>
      <div class="tas-head__t">
        <p class="tas-kick"><span class="tas-kick__ref">05</span>Eval harness</p>
        <h2 class="h2" id="evals-t"><span class="g">Agents are tested like software,</span> on every change.</h2>
      </div>
      <div class="tas-head__l">
        <p class="lead">A prompt edit, a new tool, a model upgrade: each one runs the same golden set before it can merge. The gate is automatic. A person still signs the release, and a person still labels the cases.</p>
      </div>
    </div>

    <div class="tas-win tas-ev" data-tas-ev data-rv>
      <div class="tas-win__bar">
        <span class="tas-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="tas-win__path">eval-harness <b>· <?= e($tas_ev_agent) ?> · <?= e($tas_ev_set) ?> · <?= $tas_ev_cases ?> cases</b></span>
        <span class="tas-win__end"><span class="tas-ev__gate" data-ev-gate="ok"><i></i><span data-ev-gatet>CI gate · merge allowed</span></span></span>
      </div>
      <p class="bdh-sr">An illustrative evaluation dashboard for one agent: five gate metrics, success per scenario against its gate, a comparison of three models, the cost and energy saved by routing a small and a large model per step, and a regression timeline in which a prompt change lets the agent write before its policy check, the gate blocks the merge, the rule moves into the tool router and the re-run passes.</p>

      <div class="tas-ev__body">
        <ul class="tas-ev__kpis" aria-label="Gate metrics">
          <?php foreach ($tas_ev_kpis as $tas_ki => $tas_k): ?>
            <li class="tas-ev__kpi" data-k="<?= e($tas_k[0]) ?>" style="--i:<?= $tas_ki ?>">
              <p class="tas-ev__kl"><?= e($tas_k[1]) ?></p>
              <p class="tas-ev__kv" data-bdh-count><?= e($tas_k[2]) ?></p>
              <p class="tas-ev__kt"><span class="tas-ev__ok" aria-hidden="true"></span><?= e($tas_k[3]) ?></p>
              <svg class="tas-ev__spark bdh-draw" viewBox="0 0 100 32" preserveAspectRatio="none" aria-hidden="true" focusable="false">
                <polyline pathLength="1" style="--i:<?= $tas_ki * 2 ?>" points="<?= $tas_ev_spark($tas_k[4]) ?>"/>
              </svg>
            </li>
          <?php endforeach; ?>
        </ul>

        <div class="tas-ev__grid">
          <div class="tas-ev__scen">
            <p class="tas-ev__h"><span class="tas-lbl">Success by scenario</span><span class="tas-ill">Illustrative</span></p>
            <ol class="tas-ev__sl" id="evals-scen">
              <?php foreach ($tas_ev_scen as $tas_si => $tas_s): ?>
                <li class="tas-ev__sr<?= $tas_s[2] >= $tas_s[3] ? ' is-pass' : '' ?>">
                  <span class="tas-ev__sn"><b><?= e($tas_s[0]) ?></b><?php if ($tas_s[4]): ?><em><?= e($tas_s[4]) ?></em><?php endif; ?><small><?= (int) $tas_s[1] ?> cases</small></span>
                  <span class="tas-ev__sb" aria-hidden="true"><i class="tas-ev__sf bdh-grow" style="--i:<?= $tas_si + 2 ?>;--w:<?= $tas_s[2] / 100 ?>"></i><i class="tas-ev__sg" style="--g:<?= $tas_s[3] ?>%"></i></span>
                  <span class="tas-ev__sv"><b><?= (int) $tas_s[2] ?>%</b><small>gate <?= $tas_s[3] === 100 ? '=' : '≥' ?> <?= (int) $tas_s[3] ?>%</small></span>
                </li>
              <?php endforeach; ?>
            </ol>
            <button type="button" class="tas-ev__more" aria-expanded="false" aria-controls="evals-scen" data-ev-more hidden>Show all <?= count($tas_ev_scen) ?> scenarios</button>
            <dl class="tas-ev__judge">
              <div><dt>Judge agreement</dt><dd>κ 0.84 vs human labels</dd></div>
              <div><dt>Double-labelled</dt><dd>40 of <?= $tas_ev_cases ?> cases</dd></div>
              <div><dt>Last calibrated</dt><dd>release 0418</dd></div>
            </dl>
          </div>

          <div class="tas-ev__models">
            <p class="tas-ev__h"><span class="tas-lbl">Model comparison · every step on one model</span><span class="tas-ev__hn">Same <?= $tas_ev_cases ?> cases</span></p>
            <div class="tas-ev__tw" tabindex="0" role="region" aria-label="Model comparison table, scroll sideways on small screens">
              <table class="tas-ev__tbl">
                <thead>
                  <tr><th scope="col">Metric</th><?php foreach ($tas_ev_models as $tas_mi => $tas_m): ?><th scope="col"><b><?= e($tas_m) ?></b><small><?= e($tas_ev_mnote[$tas_mi]) ?></small></th><?php endforeach; ?></tr>
                </thead>
                <tbody>
                  <?php foreach ($tas_ev_rows as $tas_r): ?>
                    <tr><th scope="row"><?= e($tas_r[0]) ?></th><?php foreach ($tas_r[1] as $tas_ci => $tas_c): ?><td<?= $tas_ci === $tas_r[2] ? ' class="is-best"' : '' ?>><?= e($tas_c) ?></td><?php endforeach; ?></tr>
                  <?php endforeach; ?>
                  <tr class="tas-ev__vr"><th scope="row">Used for</th><?php foreach ($tas_ev_verdict as $tas_v): ?><td><?= e($tas_v) ?></td><?php endforeach; ?></tr>
                </tbody>
              </table>
            </div>

            <div class="tas-ev__rz">
              <p class="tas-ev__h"><span class="tas-lbl">Right-sized · cost and carbon per task</span><?= xt_badge('sci', ['variant' => 'chip']) ?></p>
              <ul class="tas-ev__rzl" aria-label="Every step on the large model compared with routing per step">
                <?php foreach ($tas_ev_rz as $tas_zi => $tas_z): ?>
                  <li class="tas-ev__rzr<?= $tas_zi ? ' is-best' : '' ?>">
                    <span class="tas-ev__rzn"><?= e($tas_z[0]) ?></span>
                    <span class="tas-ev__rzb" aria-hidden="true"><i class="bdh-grow" style="--w:<?= $tas_z[4] ?>;--i:<?= $tas_zi + 4 ?>"></i></span>
                    <span class="tas-ev__rzv"><b><?= e($tas_z[1]) ?></b><span><?= e($tas_z[3]) ?> est. · <?= e($tas_z[2]) ?> success</span></span>
                  </li>
                <?php endforeach; ?>
              </ul>
              <p class="tas-ev__sci"><code>SCI = ((E × I) + M) per R</code> with R = one completed task. The manual process is the ceiling: about 4.8 Wh a task (4.8 minutes at a workstation). An agent that does not beat it on cost and carbon does not ship.</p>
            </div>
          </div>
        </div>

        <div class="tas-ev__reg">
          <p class="tas-ev__h"><span class="tas-lbl">Regression timeline · last four runs · trajectory checks on</span><button type="button" class="tas-btn tas-ev__replay" data-ev-replay><?= xt_icon('rollback', ['size' => 15, 'mono' => true]) ?>Replay</button></p>
          <ol class="tas-ev__runs" data-ev-runs aria-live="polite">
            <?php foreach ($tas_ev_runs as $tas_ri => $tas_r): ?>
              <li class="tas-ev__run is-on" data-st="<?= e($tas_r[0]) ?>" style="--i:<?= $tas_ri ?>">
                <span class="tas-ev__rs" aria-hidden="true"></span>
                <span class="tas-ev__rid"><?= e($tas_r[1]) ?></span>
                <span class="tas-ev__rp"><?= e($tas_r[2]) ?></span>
                <span class="tas-ev__rt"><?= e($tas_r[3]) ?></span>
                <span class="tas-ev__rg"><?= e($tas_r[4]) ?></span>
                <?php if ($tas_r[5]): ?>
                  <span class="tas-ev__rx">
                    <?php foreach ([['expected', $tas_r[5][0]], ['got', $tas_r[5][1]]] as $tas_rx): ?>
                      <span class="tas-ev__rxl" data-k="<?= e($tas_rx[0]) ?>"><em><?= e($tas_rx[0]) ?></em><span>…</span><?php foreach ($tas_rx[1] as $tas_ti => $tas_tool): ?><?= $tas_ti ? '<i aria-hidden="true">→</i>' : '' ?><code<?= $tas_rx[0] === 'got' && $tas_ti === 1 ? ' class="is-bad"' : '' ?>><?= e($tas_tool) ?></code><?php endforeach; ?></span>
                    <?php endforeach; ?>
                  </span>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ol>
        </div>
      </div>
    </div>

    <ul class="tas-ev__how" data-rv-s data-rv-step="70">
      <?php foreach ($tas_ev_how as $tas_hw): ?>
        <li><?= xt_icon($tas_hw[0], ['size' => 22]) ?><div><h3><?= e($tas_hw[1]) ?></h3><p><?= e($tas_hw[2]) ?></p></div></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
