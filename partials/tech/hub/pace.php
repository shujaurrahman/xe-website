<?php /* DRAFT COPY — review before launch */
/* Pace — the field moves weekly, so the platform is built to move with it. Three linked views:
   1. Model changelog: twelve months of generic model releases (never attributed to a provider) plotted over
      the eval score on "your" golden set and the cost per 1,000 requests. Each release is a button: the side
      card shows how it was re-evaluated and the gateway change it led to, or why it was not adopted.
      pace.js scrubs the line with scroll.
   2. Release train: twelve Thursdays; a release ships only when its evals pass (one held back, marked).
   3. Idea to agent: five milestones from framing to production with guardrails; a cursor advances stage by
      stage while on screen.
   HTML = the finished state. Every figure is illustrative; timings are typical ranges. */
// PLACEHOLDER: confirm typical timeframes before launch
$pc_x = fn (float $pc_m): float => round(40 + $pc_m * (920 / 11), 1);            // month index 0–11 → x in a 1000-wide chart
$pc_y = fn (float $pc_s): float => round(250 - ($pc_s - 0.76) / 0.2 * 200, 1);      // eval score 0.76–0.96 → y 250–50
$pc_months = ['M−11', 'M−10', 'M−9', 'M−8', 'M−7', 'M−6', 'M−5', 'M−4', 'M−3', 'M−2', 'M−1', 'Now'];
$pc_events = [
    // [month index, release, re-eval days, adopted?, decision, candidate score, candidate p95, candidate cost, config line or null]
    [0.6,  'Frontier model',                2, false, 'Not adopted: no gain on your cases at two and a half times the cost', '0.81', '3.4 s', '$6.10', null],
    [1.5,  'Open-weights model',            3, true,  'Adopted for overnight batch summaries, self-hosted in region', '0.80', '2.2 s', '$0.90', 'batch.summarise → open-weights/medium · in-region GPU'],
    [2.7,  'Price cut on a mid-size model', 1, true,  'Adopted as the default route for support answers',           '0.83', '1.8 s', '$1.85', 'support.answer → provider-c/medium-2026-01'],
    [4.2,  'Context window to 1M tokens',   2, false, 'Not adopted: retrieval already covers the long documents',   '0.83', '4.9 s', '$3.20', null],
    [5.4,  'Faster small model',            2, true,  'Adopted as the first-pass route; escalates on low confidence', '0.85', '0.9 s', '$1.30', 'support.answer.first_pass → provider-e/small-2026-04'],
    [7.1,  'Frontier model',                3, true,  'Adopted for the complex tier only, about 8% of traffic',     '0.90', '2.6 s', '$1.42', 'support.answer.complex → provider-b/large-2026-06'],
    [8.3,  'Open-weights reasoning model',  4, false, 'Not adopted yet: licence terms under legal review',           '0.89', '3.1 s', '$1.10', null],
    [9.6,  'Price cut on the complex route', 1, true, 'Adopted: same model, cost cap cut about 40%, 0.012 → 0.007',  '0.91', '2.4 s', '$1.05', 'support.answer.complex · cost_cap 0.012 → 0.007'],
    [10.6, 'Small model update',            2, true,  'Adopted for first pass after a two-day canary',               '0.93', '0.8 s', '$1.02', 'support.answer.first_pass → provider-e/small-2026-08'],
];
$pc_sel = 5;   // the release shown in the side card in the markup
$pc_steps = [[0, 0.81], [2.8, 0.83], [5.5, 0.85], [7.2, 0.90], [9.7, 0.91], [10.7, 0.93], [11, 0.93]];
$pc_line = '';
foreach ($pc_steps as $pc_k => $pc_p) {
    if ($pc_k === 0) { $pc_line = 'M' . $pc_x($pc_p[0]) . ' ' . $pc_y($pc_p[1]); continue; }
    $pc_line .= ' H' . $pc_x($pc_p[0]) . ' V' . $pc_y($pc_p[1]);
}
$pc_area = $pc_line . ' V250 H' . $pc_x(0) . ' Z';
$pc_cost = [2.40, 2.40, 2.10, 1.85, 1.85, 1.85, 1.30, 1.30, 1.42, 1.42, 1.05, 1.02];
$pc_cost_max = 2.6;
$pc_providers = ['openai', 'anthropic', 'googlegemini', 'meta', 'mistralai', 'huggingface'];

$pc_train = [
    // [week, changes shipped, held?]
    ['W1', 14, false], ['W2', 11, false], ['W3', 17, false], ['W4', 9, false], ['W5', 15, false], ['W6', 12, false],
    ['W7', 0, true],   ['W8', 23, false], ['W9', 13, false], ['W10', 16, false], ['W11', 10, false], ['W12', 18, false],
];
$pc_train_max = 24;

$pc_ms = [
    // [when, name, what exists, gate]
    ['Day 0',  'Problem framed',            'One task, one owner, one measure, and the baseline of how it is done today.', 'Owner signs the measure'],
    ['Day 2',  'Prototype on real data',    'A working agent on masked copies of your data, traced end to end.',         'The team who does the work reviews outputs'],
    ['Day 5',  'Eval baseline',             'A golden set from real cases, scored for quality, cost and latency.',        'Go or stop, decided on the numbers'],
    ['Week 3', 'Pilot with users',          'Named users, human approval on every action, guardrails and spend limits live.', 'Security and legal sign the guardrail policy'],
    ['Week 6', 'Production with guardrails', 'Rolled out behind the gateway with monitoring, runbooks and an audit log.',  'Sponsor signs the release'],
];
?>
<section class="band tih-pace" id="pace" aria-labelledby="pace-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The pace of AI</p>
        <h2 class="h2" id="pace-t"><span class="g">The field moves weekly.</span> So do we.</h2>
      </div>
      <div>
        <p class="lead">We treat the model as a replaceable part behind a gateway and an eval suite. When a better or cheaper model ships, we re-run your evals within days and adopt it as a configuration change, not a rebuild.</p>
      </div>
    </div>

    <!-- 1 · model changelog -->
    <div class="tih-pc" data-sel="<?= $pc_sel ?>" data-rv data-rv-d="60">
      <div class="tih-pc__top">
        <div>
          <p class="tih-k">Model changelog · last 12 months</p>
          <h3 class="tih-pc__h">Nine releases, each re-evaluated on your cases</h3>
        </div>
        <dl class="tih-pc__ro">
          <div><dt>Eval score</dt><dd><b>0.81 → 0.93</b></dd></div>
          <div><dt>Cost per 1k requests</dt><dd><b>$2.40 → $1.02</b></dd></div>
          <div><dt>Adopted</dt><dd><b>6 of 9</b></dd></div>
          <div><dt>Median time to decision</dt><dd><b>2 days</b></dd></div>
        </dl>
      </div>

      <div class="tih-pc__body">
        <div class="tih-pc__chart">
          <p class="bdh-sr">A chart of the last twelve months. Nine model releases are marked along the top. The eval score on the golden set rises in steps from 0.81 to 0.93 as six of them are adopted, while the cost per thousand requests falls from 2.40 to 1.02 dollars. Each release can be chosen to see how it was evaluated and what changed.</p>
          <div class="tih-pc__plot">
            <svg class="tih-pc__svg" viewBox="0 0 1000 280" preserveAspectRatio="none" aria-hidden="true" focusable="false">
              <defs><clipPath id="pace-clip"><rect class="tih-pc__clip" x="0" y="0" width="1000" height="280"/></clipPath></defs>
              <?php foreach ([0.80, 0.85, 0.90, 0.95] as $pc_g): ?>
                <line class="tih-pc__grid" x1="40" x2="960" y1="<?= $pc_y($pc_g) ?>" y2="<?= $pc_y($pc_g) ?>"/>
              <?php endforeach; ?>
              <line class="tih-pc__base" x1="40" x2="960" y1="250" y2="250"/>
              <?php foreach ($pc_events as $pc_ei => $pc_e): ?>
                <line class="tih-pc__ev<?= $pc_e[3] ? ' is-yes' : '' ?>" data-ev="<?= $pc_ei ?>" x1="<?= $pc_x($pc_e[0]) ?>" x2="<?= $pc_x($pc_e[0]) ?>" y1="30" y2="250"/>
              <?php endforeach; ?>
              <g clip-path="url(#pace-clip)">
                <path class="tih-pc__area" d="<?= $pc_area ?>"/>
                <path class="tih-pc__line" d="<?= $pc_line ?>"/>
              </g>
              <line class="tih-pc__head" x1="960" x2="960" y1="30" y2="250"/>
            </svg>
            <?php foreach ([0.80, 0.85, 0.90, 0.95] as $pc_g): ?>
              <span class="tih-pc__yl" style="--y:<?= round($pc_y($pc_g) / 280 * 100, 2) ?>"><?= number_format($pc_g, 2) ?></span>
            <?php endforeach; ?>
            <div class="tih-pc__marks" role="group" aria-label="Model releases in the last twelve months">
              <?php foreach ($pc_events as $pc_ei => $pc_e): ?>
                <button type="button" class="tih-pc__mk<?= $pc_e[3] ? ' is-yes' : '' ?>" style="--x:<?= round($pc_x($pc_e[0]) / 10, 2) ?>" data-ev="<?= $pc_ei ?>"
                        aria-pressed="<?= $pc_ei === $pc_sel ? 'true' : 'false' ?>" aria-controls="pace-card"
                        aria-label="<?= e($pc_months[(int) floor($pc_e[0])] . ': ' . $pc_e[1] . '. Re-evaluated in ' . $pc_e[2] . ' days. ' . $pc_e[4] . '.') ?>"><?= $pc_ei + 1 ?></button>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="tih-pc__cost" aria-hidden="true">
            <span class="tih-pc__bars"><?php foreach ($pc_cost as $pc_ci => $pc_c): ?><i style="--x:<?= round($pc_x($pc_ci) / 10, 2) ?>;--h:<?= round($pc_c / $pc_cost_max, 3) ?>;--i:<?= $pc_ci ?>"><b>$<?= number_format($pc_c, 2) ?></b></i><?php endforeach; ?></span>
          </div>
          <p class="tih-pc__months" aria-hidden="true"><?php foreach ($pc_months as $pc_mi2 => $pc_m): ?><span style="--x:<?= round($pc_x($pc_mi2) / 10, 2) ?>"><?= e($pc_m) ?></span><?php endforeach; ?></p>
          <p class="tih-pc__legend" aria-hidden="true"><span><i class="is-line"></i>Eval score · golden set</span><span><i class="is-bar"></i>Cost per 1k requests</span><span><i class="is-yes"></i>Adopted</span><span><i class="is-no"></i>Evaluated, not adopted</span><span class="bdh-ill">Illustrative</span></p>
        </div>

        <aside class="tih-pc__card" id="pace-card" aria-live="polite">
          <?php foreach ($pc_events as $pc_ei => $pc_e): ?>
            <div class="tih-pc__cp<?= $pc_ei === $pc_sel ? ' is-on' : '' ?>" data-cp="<?= $pc_ei ?>">
              <p class="tih-k">Release <?= str_pad((string) ($pc_ei + 1), 2, '0', STR_PAD_LEFT) ?> · <?= e($pc_months[(int) floor($pc_e[0])]) ?></p>
              <h4 class="tih-pc__ct"><?= e($pc_e[1]) ?></h4>
              <p class="tih-pc__cr">Re-evaluated in <b><?= $pc_e[2] ?> <?= $pc_e[2] === 1 ? 'day' : 'days' ?></b> on golden-set · 148 cases</p>
              <table class="tih-pc__tb">
                <thead><tr><th scope="col"><span class="bdh-sr">Measure</span></th><th scope="col">Candidate</th></tr></thead>
                <tbody>
                  <tr><th scope="row">Eval score</th><td><?= e($pc_e[5]) ?></td></tr>
                  <tr><th scope="row">p95 latency</th><td><?= e($pc_e[6]) ?></td></tr>
                  <tr><th scope="row">Cost per 1k</th><td><?= e($pc_e[7]) ?></td></tr>
                </tbody>
              </table>
              <p class="tih-pc__dec<?= $pc_e[3] ? ' is-yes' : '' ?>"><b aria-hidden="true"><?= $pc_e[3] ? '✓' : '–' ?></b><?= e($pc_e[4]) ?></p>
              <?php if ($pc_e[8]): ?>
                <p class="tih-pc__cfg"><span class="tih-pc__cfk">gateway.routes</span><code><?= e($pc_e[8]) ?></code></p>
              <?php else: ?>
                <p class="tih-pc__cfg is-none"><span class="tih-pc__cfk">gateway.routes</span><code>no change · current route kept</code></p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
          <div class="tih-pc__prov">
            <p class="tih-k">Providers behind the gateway</p>
            <?= xt_stack($pc_providers, ['variant' => 'logos', 'size' => 18, 'label' => 'Model providers we evaluate']) ?>
          </div>
        </aside>
      </div>
    </div>

    <div class="tih-pace__row">
      <!-- 2 · release train -->
      <div class="tih-pc__train" data-bdh-in>
        <p class="tih-k">Release train · 12 weeks <span class="bdh-ill">Illustrative</span></p>
        <h3 class="tih-pc__h">Every Thursday, whatever passed the gates ships</h3>
        <p class="bdh-sr">Twelve weekly releases. Eleven shipped, with between 9 and 23 changes each. Week 7 was held because a refund-intent eval dropped from 0.92 to 0.86; the fix shipped in week 8.</p>
        <ol class="tih-pc__weeks" aria-hidden="true">
          <?php foreach ($pc_train as $pc_ti => $pc_t): ?>
            <li class="<?= $pc_t[2] ? 'is-held' : 'is-ship' ?>" style="--i:<?= $pc_ti ?>;--h:<?= round($pc_t[1] / $pc_train_max, 3) ?>">
              <span class="tih-pc__wb"><i></i></span>
              <span class="tih-pc__wd"></span>
              <span class="tih-pc__wl"><?= e($pc_t[0]) ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
        <ul class="tih-pc__gates" aria-label="Gates every release train must pass">
          <?php foreach ([['Tests', 'unit · contract · e2e'], ['Evals', 'golden set on every AI route'], ['Scans', 'SAST · deps · secrets'], ['Canary', '5% → 100% on SLOs']] as $pc_gi => $pc_g): ?>
            <li style="--i:<?= $pc_gi ?>"><b aria-hidden="true">✓</b><span><?= e($pc_g[0]) ?></span><small><?= e($pc_g[1]) ?></small></li>
          <?php endforeach; ?>
        </ul>
        <p class="tih-pc__held"><span class="bdh-flag" aria-hidden="true">!</span><span><b>W7 held.</b> The refund-intent eval dropped from 0.92 to 0.86. Nothing shipped; the fix went out with W8.</span></p>
        <p class="tih-pc__sum"><span><b>11 of 12</b> trains shipped</span><span><b>1</b> held by evals</span><span><b>0</b> rollbacks</span></p>
      </div>

      <!-- 3 · idea to agent -->
      <!-- PLACEHOLDER: confirm typical idea-to-production timeframes before launch -->
      <div class="tih-pc__i2a" data-bdh-live>
        <p class="tih-k">Idea to agent · typical <span class="bdh-ill">Typical ranges</span></p>
        <h3 class="tih-pc__h">From a framed problem to production in about six weeks</h3>
        <div class="tih-pc__clock" aria-hidden="true"><span>T+</span><b class="tih-pc__t"><?= e($pc_ms[count($pc_ms) - 1][0]) ?></b></div>
        <ol class="tih-pc__ms">
          <?php foreach ($pc_ms as $pc_mi => $pc_mm): ?>
            <li class="is-done" data-m="<?= $pc_mi ?>">
              <span class="tih-pc__mw"><?= e($pc_mm[0]) ?></span>
              <span class="tih-pc__mn"><?= e($pc_mm[1]) ?></span>
              <span class="tih-pc__md"><?= e($pc_mm[2]) ?></span>
              <span class="tih-pc__mg"><?= e($pc_mm[3]) ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>
  </div>
</section>
