<?php /* DRAFT COPY — review before launch */
/* 07 FinOps — unit economics, not surprise invoices. A FinOps console for "your-platform", month to date:
   a KPI strip; unit cost switchable by feature, team and model route (real buttons); the month's spend with a
   forecast cone against the budget; GPU hours used against reserved capacity, with on-demand bursts and spot
   batch; and an anomaly the FinOps agent found, with the fix it proposes waiting for a person to approve or
   hold, and every step written to the audit log. HTML = the finished state ("By feature", fix awaiting
   approval); finops.js switches views, draws the forecast and runs the approval. Every figure is illustrative. */
$tic_fo_views = [   // key => [tab, metric, unit prefix, unit suffix, scale max, rows [name, value, target, note, trend]]
    'feature' => ['By feature', 'Cost per 1k requests against the cost model', '$', '', 3.2, [
        ['Support assistant',   1.42, 1.60, '412k requests', '−12%'],
        ['Document search',     0.38, 0.50, '1.1M requests', '−4%'],
        ['Sales email drafts',  2.94, 2.20, '58k requests',  '+31%'],
        ['Invoice extraction',  0.71, 0.90, '96k documents', '−9%'],
        ['Internal copilot',    1.18, 1.20, '203k requests', '+2%'],
    ]],
    'team' => ['By team', 'Spend this month against each team’s budget (showback)', '$', 'k', 24, [
        ['Customer support', 12.4, 19.0, '5 features',  '−6%'],
        ['Sales',            6.8,  5.5,  '2 features',  '+24%'],
        ['Finance',          3.1,  4.5,  '1 feature',   '−11%'],
        ['Product',          2.2,  3.0,  '3 features',  '+4%'],
        ['Platform (shared)', 1.8, 2.5,  'gateway, evals', '−2%'],
    ]],
    'model' => ['By model route', 'Cost per 1k requests on each model route', '$', '', 5.6, [
        ['Frontier model · provider A', 4.80, 5.00, '9% of calls',  '+3%'],
        ['Small model · provider B',    0.21, 0.30, '38% of calls', '−8%'],
        ['Self-hosted 8B · FP8',        0.34, 0.45, '41% of calls', '−19%'],
        ['Embeddings',                  0.02, 0.03, '12% of calls', '0%'],
        ['Semantic cache hits',         0.004, 0.01, '31% of answers', '—'],
    ]],
];
$tic_fo_fmt = function (string $pre, string $suf, float $v): string {
    if ($v < .01) return $pre . number_format($v, 3) . $suf;
    return $pre . number_format($v, $suf === 'k' ? 1 : 2) . $suf;
};

/* spend: cumulative $k by day 1–19, then forecast to day 30 with a widening band */
$tic_fo_days = [1.2, 2.5, 3.9, 5.1, 6.2, 7.2, 8.6, 10.0, 11.5, 12.8, 14.0, 15.1, 16.3, 17.8, 19.3, 20.8, 22.0, 24.6, 26.3];
$tic_fo_fc_mid = 41.8; $tic_fo_fc_lo = 38.9; $tic_fo_fc_hi = 44.6; $tic_fo_budget = 45.0;
$tic_fo_sx = fn (float $d): float => round(($d - 1) / 29 * 300, 1);
$tic_fo_sy = fn (float $v): float => round(140 - $v / 50 * 140, 1);
$tic_fo_act = '';
foreach ($tic_fo_days as $tic_fo_i => $tic_fo_v) { $tic_fo_act .= ($tic_fo_i ? 'L' : 'M') . $tic_fo_sx($tic_fo_i + 1) . ',' . $tic_fo_sy($tic_fo_v); }
$tic_fo_last = [$tic_fo_sx(19), $tic_fo_sy(26.3)];
$tic_fo_cone = 'M' . $tic_fo_last[0] . ',' . $tic_fo_last[1] . 'L300,' . $tic_fo_sy($tic_fo_fc_hi) . 'L300,' . $tic_fo_sy($tic_fo_fc_lo) . 'Z';
$tic_fo_mid  = 'M' . $tic_fo_last[0] . ',' . $tic_fo_last[1] . 'L300,' . $tic_fo_sy($tic_fo_fc_mid);

/* GPUs in use, 2-hour buckets over 7 days: serving (diurnal) + batch on spot at night; 8 GPUs reserved.
   Shaped so the ordinary weekday peak stays under the reservation and only the four named afternoon bursts
   cross it — the legend below counts exactly those four. */
$tic_fo_res = 8; $tic_fo_n = 84;
$tic_fo_burst = [7, 20, 32, 44];   // Mon 14:00, Tue 16:00, Wed 16:00, Thu 16:00
$tic_fo_use = []; $tic_fo_spot = [];
for ($tic_fo_i = 0; $tic_fo_i < $tic_fo_n; $tic_fo_i++) {
    $tic_fo_h = ($tic_fo_i % 12) * 2;
    $tic_fo_day = intdiv($tic_fo_i, 12);
    $tic_fo_base = 4.56 + 2.72 * max(0, sin(($tic_fo_h - 7) / 16 * M_PI)) + ($tic_fo_day >= 5 ? -1.4 : 0) + .35 * sin($tic_fo_i * 1.7);
    if (in_array($tic_fo_i, $tic_fo_burst, true)) $tic_fo_base += 2.4;      // afternoon bursts onto on-demand
    $tic_fo_use[]  = round(max(2.2, $tic_fo_base), 2);
    $tic_fo_spot[] = ($tic_fo_h <= 4) ? 4 : 0;                              // nightly batch on spot GPUs
}
$tic_fo_spot_h = count(array_filter($tic_fo_spot)) * 2 * 4;                 // buckets × 2 h × 4 GPUs = GPU-hours
$tic_fo_peaks  = count(array_filter($tic_fo_use, fn ($tic_fo_v) => $tic_fo_v > $tic_fo_res));
$tic_fo_gx = fn (int $i): float => round($i / ($tic_fo_n - 1) * 600, 1);
$tic_fo_gy = fn (float $g): float => round(150 - $g / 14 * 150, 1);
$tic_fo_area = 'M0,150'; $tic_fo_line = '';
foreach ($tic_fo_use as $tic_fo_i => $tic_fo_g) {
    $tic_fo_area .= 'L' . $tic_fo_gx($tic_fo_i) . ',' . $tic_fo_gy($tic_fo_g);
    $tic_fo_line .= ($tic_fo_i ? 'L' : 'M') . $tic_fo_gx($tic_fo_i) . ',' . $tic_fo_gy($tic_fo_g);
}
$tic_fo_area .= 'L600,150Z';
$tic_fo_avg = array_sum($tic_fo_use) / $tic_fo_n;
$tic_fo_util = (int) round($tic_fo_avg / $tic_fo_res * 100);

$tic_fo_log = [   // [time, actor, text, state: base | approve | hold]
    ['02:31', 'finops-agent', 'Anomaly: embedding spend 3.1× forecast (z = 4.2)', 'base'],
    ['02:33', 'finops-agent', 'Cause: 3 full re-runs after an object-store timeout', 'base'],
    ['02:34', 'finops-agent', 'Fix proposed · awaiting human approval', 'base'],
    ['09:12', 'you',          'Approved · PR #482 opened · change CHG-1182 logged', 'approve'],
    ['09:12', 'you',          'Held for review · assigned to platform on-call', 'hold'],
];
$tic_fo_cur = $tic_fo_views['feature'];
?>
<section class="band tic-finops" id="finops" aria-labelledby="finops-t">
  <div class="wrap">
    <div class="tic-head" data-rv>
      <p class="tic-ch"><b>07</b><span>FinOps</span><i aria-hidden="true"></i><em>cost per unit · showback · forecast · anomalies</em></p>
      <div class="tic-head__t">
        <h2 class="h2" id="finops-t"><span class="g">Unit economics,</span> not surprise invoices.</h2>
      </div>
      <div class="tic-head__l">
        <p class="lead">Every model call carries a cost tag for its feature, team and route, so spend is read per request rather than per invoice. An agent watches the numbers daily; a person approves anything it wants to change.</p>
      </div>
    </div>

    <div class="tic-fo" data-rv data-view="feature">
      <script type="application/json" class="tic-fo__data"><?= json_encode(array_map(fn ($v) => ['metric' => $v[1], 'pre' => $v[2], 'suf' => $v[3], 'max' => $v[4], 'rows' => $v[5]], $tic_fo_views), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
      <div class="tic-fo__bar">
        <p class="tic-fo__title"><span class="tic-led tic-led--blink" aria-hidden="true"></span>finops · your-platform · September · month to date</p>
        <span class="bdh-ill">Illustrative</span>
      </div>

      <dl class="tic-fo__kpis">
        <div><dt>Spend to date</dt><dd class="tic-v" data-bdh-count>$26.3k</dd><dd class="tic-fo__sub">day 19 of 30</dd></div>
        <div><dt>Forecast</dt><dd class="tic-v" data-bdh-count>$41.8k</dd><dd class="tic-fo__sub">± $2.9k at 80%</dd></div>
        <div><dt>Budget</dt><dd class="tic-v">$45.0k</dd><dd class="tic-fo__sub is-good">7% headroom</dd></div>
        <div><dt>Cost per 1k requests</dt><dd class="tic-v" data-bdh-count>$1.21</dd><dd class="tic-fo__sub is-good">−14% vs August</dd></div>
        <div><dt>Unallocated</dt><dd class="tic-v" data-bdh-count>3%</dd><dd class="tic-fo__sub">of spend without a tag</dd></div>
      </dl>

      <div class="tic-fo__grid">
        <!-- unit cost -->
        <div class="tic-fo__card tic-fo__unit">
          <div class="tic-fo__ch">
            <h3 class="tic-fo__h">Unit cost</h3>
            <div class="bdh-seg tic-fo__seg" role="group" aria-label="Group unit cost">
              <?php foreach ($tic_fo_views as $tic_fo_k => $tic_fo_v): ?>
                <button type="button" data-fo-view="<?= e($tic_fo_k) ?>" aria-pressed="<?= $tic_fo_k === 'feature' ? 'true' : 'false' ?>"><?= e($tic_fo_v[0]) ?></button>
              <?php endforeach; ?>
            </div>
          </div>
          <p class="tic-fo__metric" data-fo-metric><?= e($tic_fo_cur[1]) ?></p>
          <table class="tic-fo__table">
            <caption class="bdh-sr" data-fo-caption><?= e($tic_fo_cur[1]) ?>, with target and change against last month</caption>
            <thead><tr><th scope="col">Name</th><th scope="col"><span class="bdh-sr">Against target</span></th><th scope="col">Actual</th><th scope="col">Target</th><th scope="col">Trend</th></tr></thead>
            <tbody data-fo-rows>
              <?php foreach ($tic_fo_cur[5] as $tic_fo_i => $tic_fo_r): $tic_fo_over = $tic_fo_r[1] > $tic_fo_r[2]; ?>
                <tr class="<?= $tic_fo_over ? 'is-over' : '' ?>" style="--i:<?= $tic_fo_i ?>">
                  <th scope="row"><span class="tic-fo__nm"><?= e($tic_fo_r[0]) ?></span><small><?= e($tic_fo_r[3]) ?></small></th>
                  <td class="tic-fo__bc" aria-hidden="true"><span class="tic-fo__b"><i class="bdh-grow" style="--w:<?= round($tic_fo_r[1] / $tic_fo_cur[4], 4) ?>;--i:<?= $tic_fo_i ?>"></i><b style="--t:<?= round($tic_fo_r[2] / $tic_fo_cur[4], 4) ?>"></b></span></td>
                  <td class="tic-fo__num"><?= e($tic_fo_fmt($tic_fo_cur[2], $tic_fo_cur[3], $tic_fo_r[1])) ?></td>
                  <td class="tic-fo__num tic-fo__tg"><?= e($tic_fo_fmt($tic_fo_cur[2], $tic_fo_cur[3], $tic_fo_r[2])) ?></td>
                  <td class="tic-fo__tr"><?= e($tic_fo_r[4]) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <p class="tic-fo__legend" aria-hidden="true"><span class="is-a">actual</span><span class="is-t">target</span><span class="is-o">over target</span></p>
          <p class="bdh-sr" aria-live="polite" data-fo-status></p>
        </div>

        <!-- forecast -->
        <div class="tic-fo__card tic-fo__fc">
          <div class="tic-fo__ch">
            <h3 class="tic-fo__h">Spend forecast</h3>
            <p class="tic-fo__ro">$k · cumulative</p>
          </div>
          <p class="bdh-sr">Month-to-date spend of 26.3 thousand dollars on day 19, forecast to reach 41.8 thousand dollars by day 30, with an 80 percent range of 38.9 to 44.6 thousand, under a budget of 45 thousand.</p>
          <div class="tic-fo__plot" aria-hidden="true">
            <svg class="tic-fo__svg" viewBox="0 0 300 140" preserveAspectRatio="none">
              <?php foreach ([10, 20, 30, 40] as $tic_fo_g): ?><line class="tic-fo__gl" x1="0" y1="<?= $tic_fo_sy($tic_fo_g) ?>" x2="300" y2="<?= $tic_fo_sy($tic_fo_g) ?>"/><?php endforeach; ?>
              <line class="tic-fo__bud" x1="0" y1="<?= $tic_fo_sy($tic_fo_budget) ?>" x2="300" y2="<?= $tic_fo_sy($tic_fo_budget) ?>"/>
              <line class="tic-fo__today" x1="<?= $tic_fo_last[0] ?>" y1="0" x2="<?= $tic_fo_last[0] ?>" y2="140"/>
              <defs><clipPath id="tic-fo-wipe" clipPathUnits="userSpaceOnUse"><rect class="tic-wipe" x="-4" y="-10" width="308" height="160"/></clipPath></defs>
              <path class="tic-fo__cone" d="<?= $tic_fo_cone ?>"/>
              <path class="tic-fo__mid" d="<?= $tic_fo_mid ?>"/>
              <path class="tic-fo__actual" d="<?= $tic_fo_act ?>" clip-path="url(#tic-fo-wipe)"/>
            </svg>
            <span class="tic-fo__lab tic-fo__lab--bud" style="--y:<?= round($tic_fo_sy($tic_fo_budget) / 140, 3) ?>">budget 45.0</span>
            <span class="tic-fo__lab tic-fo__lab--fc" style="--y:<?= round($tic_fo_sy($tic_fo_fc_mid) / 140, 3) ?>">forecast 41.8</span>
            <span class="tic-fo__lab tic-fo__lab--now" style="--x:<?= round($tic_fo_last[0] / 300, 3) ?>">today · 26.3</span>
          </div>
          <p class="tic-fo__axis" aria-hidden="true"><span>1 Sep</span><span>15</span><span>30 Sep</span></p>
        </div>

        <!-- GPU hours -->
        <div class="tic-fo__card tic-fo__gpu">
          <div class="tic-fo__ch">
            <h3 class="tic-fo__h">GPUs in use against reserved capacity</h3>
            <p class="tic-fo__ro">last 7 days · 2 h buckets</p>
          </div>
          <p class="bdh-sr">Over seven days, serving used an average of <?= number_format($tic_fo_avg, 1) ?> of 8 reserved GPUs, about <?= $tic_fo_util ?> percent. <?= $tic_fo_peaks ?> afternoon peaks rose above the reservation onto on-demand GPUs, and nightly batch jobs ran on 4 spot GPUs for <?= $tic_fo_spot_h ?> GPU-hours.</p>
          <div class="tic-fo__gplot" aria-hidden="true">
            <svg class="tic-fo__gsvg" viewBox="0 0 600 150" preserveAspectRatio="none">
              <defs><clipPath id="tic-fo-over"><rect x="0" y="0" width="600" height="<?= $tic_fo_gy($tic_fo_res) ?>"/></clipPath></defs>
              <?php for ($tic_fo_d = 1; $tic_fo_d < 7; $tic_fo_d++): ?><line class="tic-fo__gl" x1="<?= round($tic_fo_d * 12 / ($tic_fo_n - 1) * 600, 1) ?>" y1="0" x2="<?= round($tic_fo_d * 12 / ($tic_fo_n - 1) * 600, 1) ?>" y2="150"/><?php endfor; ?>
              <?php foreach ($tic_fo_spot as $tic_fo_i => $tic_fo_s): if (!$tic_fo_s) continue; $tic_fo_x = $tic_fo_gx($tic_fo_i); ?>
                <rect class="tic-fo__spot" rx="1.5" x="<?= max(0, $tic_fo_x - 3.4) ?>" y="<?= $tic_fo_gy($tic_fo_s + $tic_fo_use[$tic_fo_i]) ?>" width="6.8" height="<?= round($tic_fo_s / 14 * 150, 1) ?>"/>
              <?php endforeach; ?>
              <path class="tic-fo__use" d="<?= $tic_fo_area ?>"/>
              <path class="tic-fo__burst" d="<?= $tic_fo_area ?>" clip-path="url(#tic-fo-over)"/>
              <path class="tic-fo__uline" d="<?= $tic_fo_line ?>"/>
              <line class="tic-fo__res" x1="0" y1="<?= $tic_fo_gy($tic_fo_res) ?>" x2="600" y2="<?= $tic_fo_gy($tic_fo_res) ?>"/>
            </svg>
            <span class="tic-fo__lab tic-fo__lab--res" style="--y:<?= round($tic_fo_gy($tic_fo_res) / 150, 3) ?>">reserved · 8 GPUs</span>
          </div>
          <p class="tic-fo__axis tic-fo__axis--7" aria-hidden="true"><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span></p>
          <ul class="tic-fo__gk">
            <li class="is-use"><b><?= number_format($tic_fo_avg, 1) ?> avg</b>serving on reserved · <?= $tic_fo_util ?>% of the reservation</li>
            <li class="is-burst"><b><?= $tic_fo_peaks ?> peaks</b>burst to on-demand</li>
            <li class="is-spot"><b><?= number_format($tic_fo_spot_h) ?> GPU-h</b>batch on spot, about 65% cheaper</li>
          </ul>
        </div>

        <!-- anomaly + approval -->
        <div class="tic-fo__card tic-fo__an" data-fo-an data-state="base">
          <div class="tic-fo__anh">
            <p class="tic-fo__flag"><?= xt_icon('alert', ['size' => 16]) ?> Anomaly · yesterday 01:00–03:10</p>
            <p class="tic-fo__imp"><b>+$1,240</b> vs forecast</p>
          </div>
          <h3 class="tic-fo__h tic-fo__anT">Embedding job re-ran 3×</h3>
          <p class="tic-fo__why"><code>embed-docs-nightly</code> timed out listing the object store and retried the whole job instead of the failed batch, three times over.</p>
          <div class="tic-fo__fix">
            <p class="tic-fo__fixk"><?= xt_icon('agent', ['size' => 15]) ?> Proposed by finops-agent · confidence 0.92</p>
            <pre class="tic-fo__diff" aria-label="Proposed change to jobs/embed-docs.yaml"><span class="is-f">jobs/embed-docs.yaml</span>
<span class="is-d">-  retries: 3</span>
<span class="is-a">+  retries: 1</span>
<span class="is-a">+  retryScope: batch</span>
<span class="is-a">+  idempotencyKey: "{{ .source.version }}"</span></pre>
          </div>
          <div class="tic-fo__act">
            <button type="button" class="tic-btn tic-btn--blue" data-fo-do="approve"><?= xt_icon('approve', ['size' => 16, 'mono' => true]) ?>Approve and open PR</button>
            <button type="button" class="tic-btn" data-fo-do="hold">Hold for review</button>
            <button type="button" class="tic-fo__reset" data-fo-do="reset" hidden>Reset demo</button>
          </div>
          <p class="tic-fo__state" data-fo-state aria-live="polite"><span class="bdh-pulse" aria-hidden="true"></span><span data-fo-state-t>Awaiting your approval · the agent cannot merge</span></p>
          <ol class="tic-fo__log" aria-label="Audit log">
            <?php foreach ($tic_fo_log as $tic_fo_l): ?>
              <li class="is-<?= e($tic_fo_l[3]) ?>"<?= $tic_fo_l[3] === 'base' ? '' : ' hidden' ?>><time><?= e($tic_fo_l[0]) ?></time><b><?= e($tic_fo_l[1]) ?></b><span><?= e($tic_fo_l[2]) ?></span></li>
            <?php endforeach; ?>
          </ol>
        </div>
      </div>
    </div>

    <div class="tic-fo__notes">
      <ul class="tic-fo__practice" data-rv-s data-rv-step="90">
        <li>
          <span class="tic-fo__pi"><?= xt_icon('users', ['size' => 20]) ?></span>
          <h3 class="bdh-t">Showback per team</h3>
          <p class="bdh-d">Tags set at the gateway attribute every token and GPU-hour to a feature and a team. Each team sees its own line, weekly, before finance sees the total.</p>
        </li>
        <li>
          <span class="tic-fo__pi"><?= xt_icon('layers', ['size' => 20]) ?></span>
          <h3 class="bdh-t">Commit, burst, spot</h3>
          <p class="bdh-d">Steady serving runs on reserved or committed capacity; peaks burst to on-demand; batch, evals and re-embedding run on spot with checkpoints, so an interruption costs minutes.</p>
        </li>
        <li>
          <span class="tic-fo__pi"><?= xt_icon('bolt', ['size' => 20]) ?></span>
          <h3 class="bdh-t">Scale to zero</h3>
          <p class="bdh-d">Development, preview and eval environments scale to zero outside working hours. The first request after idle waits for a warm start, which is fine for a test cluster and never for production.</p>
        </li>
      </ul>
      <div class="tic-fo__std" data-rv>
        <p class="tic-k">Practices we align delivery with</p>
        <ul class="tic-fo__stdl" role="list">
          <li class="tic-fo__std-i"><span class="tic-fo__std-c">FinOps Framework</span><span class="tic-fo__std-n">FinOps Foundation · inform, optimise, operate</span></li>
          <li class="tic-fo__std-i"><span class="tic-fo__std-c">FOCUS</span><span class="tic-fo__std-n">FinOps Open Cost and Usage Specification · one billing schema across clouds</span></li>
        </ul>
      </div>
    </div>
  </div>
</section>
