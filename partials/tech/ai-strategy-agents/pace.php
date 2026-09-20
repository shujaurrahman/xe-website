<?php /* DRAFT COPY — review before launch */
/* Pace — the stopwatch. Five milestones on the same calendar as the process section (Assess weeks
   1–3 ends at gate G1; Prove weeks 4–8 ends at gate G2) and the workshop section (two days in week
   1): the workshop, a prototype on your data, the eval baseline and G1, the pilot, production at
   "Act with approval". A ring timer drawn to scale in days advances per milestone and a pane says
   what exists at each one; beside it, a model-swap card that flips from "evaluating" to "rolled out".
   pace.js steps through while on screen until touched. Durations are typical ranges.
   HTML = the finished state (week 8). */
// PLACEHOLDER: confirm typical timeframes before launch
$tas_pc_ms = [   // [time label, unit, name, what exists now, readout, who decides, day on the ring]
    ['Week', '1', 'Two-day workshop',       ['The long list scored and the first three chosen, each with a named owner', 'Baseline measured on the manual process', 'Sandbox with masked copies of your data'], 'workshop · 12 scored · 3 chosen · baseline 4.8 min per task · sandbox ready', 'Owner and sponsor agree the measure', 5],
    ['Week', '2', 'Prototype on your data', ['One system wired through an MCP server, read scope only', '40 golden cases taken from real tickets', 'First runs at L1 Suggest, traced end to end'],                     'prototype · 1 tool · 40 cases · L1 Suggest',                       'The team who does the work reviews the first outputs', 12],
    ['Week', '3', 'Eval baseline',          ['120 cases labelled by your experts; judge calibrated (κ 0.82)', 'Cost per task and p95 time measured against the manual baseline', 'Gate G1, go to prove: decided on the numbers'], 'evals · 120 cases · κ 0.82 · $0.03 per task · p95 8.6 s · G1 passed', 'Sponsor, owner and legal sign G1 on evidence, not on the demo', 21],
    ['Week', '5', 'Pilot with ten users',   ['Shadow mode first, then L2 Draft for ten named users', 'Guardrails, spend limits and the approval flow live', 'Weekly review of escalations feeds the golden set (214 cases by week 7)'], 'pilot · 10 users · L2 Draft · 214 cases · 0 violations', 'Legal and security sign the guardrail policy', 35],
    ['Week', '8', 'Production at L3',       ['Act with approval for the whole team, after gate G2', 'Audit log, monitoring and runbooks handed over', 'Decision record: the criteria for moving to L4 later'], 'production · L3 · G2 passed · audit log · runbooks · review in 90 days', 'Sponsor signs the release; the owner runs it', 56],
];
$tas_pc_swap = [   // the model-swap card, three steps
    ['New model behind the same route',                 'No code change: the route points at the new model in the sandbox.', '0 h'],
    ['Eval suite re-run: 218 cases',                    'Two regressions on “ambiguous contract term”, fixed with one prompt line and re-run.', 'day 1'],
    ['Rolled out at L3 with sign-off',                  'Audit log records the model version; the old route stays warm for a rollback.', 'day 2'],
];
$tas_pc_why = [
    ['cube',   'Sandbox on day one',         'Masked copies of your data in an isolated environment, so nothing waits on a production connection.', ''],
    ['layers', 'A reference platform to start from', 'We start from a reference set of MCP servers, eval harness, guardrails, audit log and tracing, and configure it for you rather than building each piece from scratch.', 'confirm Xterra Edze has a reusable agent platform (MCP servers, eval harness, guardrails, audit log, tracing) before launch'],
    ['eval',   'Evals decide, not meetings', 'Every gate is a number the harness produces, so a go or no-go is a look at a dashboard with the owner.', ''],
];
$tas_pc_last = count($tas_pc_ms) - 1;
?>
<section class="band tas-pace" id="pace" aria-labelledby="pace-t">
  <div class="wrap">
    <div class="tas-head" data-rv>
      <div class="tas-head__t">
        <p class="tas-kick"><span class="tas-kick__ref">07</span>Pace · AI-native delivery</p>
        <h2 class="h2" id="pace-t"><span class="g">From idea to a working agent</span> in weeks, not quarters.</h2>
      </div>
      <div class="tas-head__l">
        <!-- PLACEHOLDER: confirm Xterra Edze has a reusable agent platform (MCP servers, eval harness, guardrails, audit log, tracing) before launch -->
        <p class="lead">We start from a reference platform and let the evals do the deciding, so the calendar is set by how fast your people can label cases and approve steps. These are typical ranges, agreed in the framing workshop.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm typical timeframes (week 1 to week 8, model swap in two days) before launch -->
    <div class="tas-pc" data-tas-pc data-at="<?= $tas_pc_last ?>" data-rv>
      <div class="tas-pc__watch">
        <div class="tas-pc__ring" aria-hidden="true" style="--p:1">
          <svg viewBox="0 0 160 160" focusable="false">
            <circle class="tas-pc__track" cx="80" cy="80" r="70"/>
            <circle class="tas-pc__prog" cx="80" cy="80" r="70" pathLength="1"/>
            <?php for ($tas_t = 0; $tas_t < 56; $tas_t++): $tas_a = deg2rad($tas_t * (360 / 56) - 90); ?>
              <line class="tas-pc__tick<?= $tas_t % 7 === 0 ? ' is-wk' : '' ?>" x1="<?= round(80 + cos($tas_a) * 60, 1) ?>" y1="<?= round(80 + sin($tas_a) * 60, 1) ?>" x2="<?= round(80 + cos($tas_a) * ($tas_t % 7 === 0 ? 54 : 57), 1) ?>" y2="<?= round(80 + sin($tas_a) * ($tas_t % 7 === 0 ? 54 : 57), 1) ?>"/>
            <?php endfor; ?>
          </svg>
          <div class="tas-pc__face">
            <span class="tas-pc__unit" data-pc-unit><?= e($tas_pc_ms[$tas_pc_last][0]) ?></span>
            <span class="tas-pc__num" data-pc-num><?= e($tas_pc_ms[$tas_pc_last][1]) ?></span>
            <span class="tas-pc__name" data-pc-name><?= e($tas_pc_ms[$tas_pc_last][2]) ?></span>
          </div>
        </div>
        <p class="bdh-sr">A stopwatch drawn to scale over eight weeks, with five milestones: week 1 two-day workshop, week 2 prototype on your data, week 3 eval baseline and the go-to-prove gate, week 5 pilot with ten users, week 8 production at act-with-approval after the production gate. The milestone buttons that follow describe each one.</p>
        <div class="tas-pc__nav">
          <button type="button" class="tas-btn" data-pc-go="-1" aria-label="Previous milestone">‹</button>
          <span class="tas-pc__auto" data-pc-auto><i class="tas-led tas-led--pulse"></i><span>Stepping through</span></span>
          <button type="button" class="tas-btn" data-pc-go="1" aria-label="Next milestone">›</button>
        </div>
        <span class="tas-ill">Typical range</span>
      </div>

      <div class="tas-pc__main">
        <div class="tas-pc__rail" role="group" aria-label="Milestones">
          <?php foreach ($tas_pc_ms as $tas_mi => $tas_m): ?>
            <button type="button" class="tas-pc__m" data-i="<?= $tas_mi ?>" data-day="<?= (int) $tas_m[6] ?>" aria-pressed="<?= $tas_mi === $tas_pc_last ? 'true' : 'false' ?>" aria-controls="pace-p<?= $tas_mi ?>">
              <span class="tas-pc__dot" aria-hidden="true"></span>
              <span class="tas-pc__ml"><?= e($tas_m[0]) ?> <?= e($tas_m[1]) ?></span>
              <span class="tas-pc__mn"><?= e($tas_m[2]) ?></span>
            </button>
          <?php endforeach; ?>
        </div>
        <div class="bdh-panes tas-pc__panes">
          <?php foreach ($tas_pc_ms as $tas_mi => $tas_m): ?>
            <div class="bdh-pane tas-pc__pane<?= $tas_mi === $tas_pc_last ? ' is-on' : '' ?>" id="pace-p<?= $tas_mi ?>">
              <p class="tas-lbl">What exists on <?= strtolower(e($tas_m[0])) ?> <?= e($tas_m[1]) ?></p>
              <ul class="tas-pc__list">
                <?php foreach ($tas_m[3] as $tas_x): ?><li><?= e($tas_x) ?></li><?php endforeach; ?>
              </ul>
              <p class="tas-pc__ro"><span class="tas-led"></span><?= e($tas_m[4]) ?></p>
              <p class="tas-pc__who"><b>Who decides</b><?= e($tas_m[5]) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="tas-pc__swap" data-pc-swap>
        <div class="tas-pc__card">
          <div class="tas-pc__side tas-pc__side--f">
            <p class="tas-pc__sk"><span class="tas-led tas-led--pulse"></span>Model swap · evaluating</p>
            <p class="tas-pc__st">reasoner-large v2 behind the same route</p>
            <ol class="tas-pc__steps">
              <?php foreach ($tas_pc_swap as $tas_si => $tas_s): ?>
                <li><span class="tas-pc__sn"><?= $tas_si + 1 ?></span><span><b><?= e($tas_s[0]) ?></b><small><?= e($tas_s[1]) ?></small></span><em><?= e($tas_s[2]) ?></em></li>
              <?php endforeach; ?>
            </ol>
            <span class="tas-pc__bar" aria-hidden="true"><i></i></span>
          </div>
          <div class="tas-pc__side tas-pc__side--b">
            <p class="tas-pc__sk"><span class="tas-pc__okdot" aria-hidden="true"></span>Model swap · rolled out</p>
            <p class="tas-pc__st">Re-evaluated and live in two days</p>
            <dl class="tas-pc__res">
              <div><dt>Cases re-run</dt><dd>218 / 218</dd></div>
              <div><dt>Regressions</dt><dd>2 found · 2 fixed</dd></div>
              <div><dt>Policy violations</dt><dd>0</dd></div>
              <div><dt>Cost per task</dt><dd>$0.021 → $0.017</dd></div>
            </dl>
            <p class="tas-pc__sf">Model version recorded in the audit log · old route kept warm for rollback</p>
          </div>
        </div>
      </div>
    </div>

    <ul class="tas-pc__why" data-rv-s data-rv-step="80">
      <?php foreach ($tas_pc_why as $tas_w): ?>
        <?php if ($tas_w[3] !== ''): ?><!-- PLACEHOLDER: <?= e($tas_w[3]) ?> --><?php endif; ?>
        <li><?= xt_icon($tas_w[0], ['size' => 22]) ?><div><h3><?= e($tas_w[1]) ?></h3><p><?= e($tas_w[2]) ?></p></div></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
