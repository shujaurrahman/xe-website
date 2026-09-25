<?php /* DRAFT COPY — review before launch */
/* Measures — THE DATA-VIZ IDIOM. Six measures, each with the number, the target agreed before launch, a
   sparkline against that target, a secondary figure and a written definition. A period switch redraws
   every sparkline; all three series are already in the markup, so the switch swaps a path rather than
   fetching anything and the default period reads correctly with JavaScript off.
   PLACEHOLDER: every value here is an illustrative example report for "Your brand", not a client result.
   The figures are internally consistent with the rest of the page (a 10% holdout, a complaint rate under
   0.10%, consent enforced at send). */
$mea_periods = ['30' => ['30 days', 26, 'vs 30 days ago'], '90' => ['90 days', 34, 'vs 90 days ago'], '365' => ['12 months', 40, 'vs 12 months ago']];
$mea_default = '365';

/* a deterministic, gently noisy series from $a to $b; the last point is exactly $b */
$mea_series = function (float $mea_a, float $mea_b, int $mea_n, float $mea_noise, float $mea_seed, int $mea_dp = 2): array {
    $mea_out = [];
    for ($mea_i = 0; $mea_i < $mea_n; $mea_i++) {
        $mea_t = $mea_i / ($mea_n - 1);
        $mea_v = $mea_a + ($mea_b - $mea_a) * (1 - (1 - $mea_t) ** 2);
        if ($mea_i < $mea_n - 1) {
            $mea_v += $mea_noise * (sin($mea_i * 1.7 + $mea_seed) * 0.62 + sin($mea_i * 0.63 + $mea_seed * 2.1) * 0.38) * (1 - $mea_t * 0.45);
        }
        $mea_out[] = round($mea_v, $mea_dp);
    }
    $mea_out[$mea_n - 1] = $mea_b;
    return $mea_out;
};
$mea_w = 240; $mea_h = 56;
$mea_y = fn (float $mea_v, array $mea_r): float => round(($mea_h - 5) - ($mea_v - $mea_r[0]) / ($mea_r[1] - $mea_r[0]) * ($mea_h - 10), 2);
$mea_path = function (array $mea_vals, array $mea_r) use ($mea_w, $mea_y): string {
    $mea_n = count($mea_vals); $mea_d = '';
    foreach ($mea_vals as $mea_i => $mea_v) {
        $mea_d .= ($mea_i ? ' L' : 'M') . round($mea_i / ($mea_n - 1) * $mea_w, 2) . ' ' . $mea_y((float) $mea_v, $mea_r);
    }
    return $mea_d;
};
$mea_delta = function (float $mea_a, float $mea_b, int $mea_dp, string $mea_suf, string $mea_per): string {
    $mea_dv = $mea_b - $mea_a;
    if (abs($mea_dv) < 0.0001) return '→ no change · ' . $mea_per;
    return ($mea_dv < 0 ? '▼ ' : '▲ ') . number_format(abs($mea_dv), $mea_dp) . $mea_suf . ' · ' . $mea_per;
};

$mea_cards = [
    // key, concern, icon, metric, value, unit, target label, target, better, starts per period, end, range, noise, decimals, secondary, definition
    ['incremental', 'Incremental revenue', 'trend-up', 'Uplift against the holdout', '11.4', '%', 'Target ≥ 8%', 8.0, 'up',
     ['30' => 10.6, '90' => 8.9, '365' => 4.1], 11.4, [2.0, 14.0], 0.5, 1,
     ['Holdout size', '10% of every audience'],
     'Revenue from the treated group minus revenue from a matched holdout over the same window, divided by the holdout. Measured per programme rather than per channel, because channels claim each other’s work.'],
    ['retention', 'Retention', 'users', '90-day repeat rate · weekly cohorts', '38.2', '%', 'Target ≥ 35%', 35.0, 'up',
     ['30' => 37.4, '90' => 36.1, '365' => 31.8], 38.2, [29.0, 41.0], 0.5, 1,
     ['Cohorts reported', 'Weekly, never a monthly average'],
     'The share of a weekly cohort that buys again within 90 days of their first order. Cohorts, not a monthly average, because an average hides the week the change actually happened.'],
    ['ltv', 'Lifetime value', 'chart', 'Predicted 12-month value · indexed', '118', '', 'Target ≥ 110', 110.0, 'up',
     ['30' => 116, '90' => 112, '365' => 100], 118, [96.0, 124.0], 1.4, 0,
     ['Model error', 'Reported against realised value'],
     'Modelled 12-month value per customer, indexed to the pre-programme baseline at 100. The model is refitted monthly and its error against realised value is published with it, so the figure can be doubted honestly.'],
    ['quality', 'Contact quality', 'shield', 'Unsubscribe rate per send', '0.18', '%', 'Target ≤ 0.25%', 0.25, 'down',
     ['30' => 0.19, '90' => 0.23, '365' => 0.34], 0.18, [0.12, 0.40], 0.015, 2,
     ['Spam complaint rate', '0.04% · we build to stay under 0.10%'],
     'Unsubscribes divided by messages delivered, per send. Reported with the spam complaint rate, which Gmail and Yahoo require to stay below 0.30% and which we build to keep under 0.10%.'],
    ['delivery', 'Deliverability', 'plug', 'Inbox placement · seed panel', '96.4', '%', 'Target ≥ 95%', 95.0, 'up',
     ['30' => 96.1, '90' => 94.8, '365' => 89.2], 96.4, [86.0, 99.0], 0.6, 1,
     ['Authentication', 'SPF, DKIM, DMARC at p=quarantine'],
     'The share of seed-panel messages that reach the inbox rather than spam or a bulk folder. Mailbox providers decide placement, so this measures it and nobody promises it.'],
    ['speed', 'Speed to lead', 'bolt', 'First response · median minutes', '6', 'min', 'Target ≤ 15 min', 15.0, 'down',
     ['30' => 7, '90' => 11, '365' => 34], 6, [3.0, 38.0], 1.6, 0,
     ['Unclaimed after an hour', 'Escalated, never queued'],
     'Median minutes from a qualified enquiry arriving to a first human response, measured against the target your sales team sets. An unclaimed lead escalates rather than waiting in a queue.'],
];

$mea_proof = [
    ['eval',     'A holdout on every always-on programme', 'Ten per cent of the audience receives nothing, so the programme is always measured against the world without it.'],
    ['target',   'Experiments that calibrate the models',  'Geo splits and holdout tests measure what advertising caused, and the mix model is fitted to agree with them.'],
    ['chart',    'One baseline, agreed before we start',   'Retention, lifetime value and contact quality are recorded before the first change, so the comparison is honest.'],
    ['clipboard-check', 'Definitions written down',        'Every number on this page has one definition, in one document, that marketing and finance both signed.'],
];
$mea_cadence = [
    ['Weekly',    'Operations review', 'Pacing, anomalies, journey performance and anything that needs a decision. Thirty minutes.'],
    ['Monthly',   'Programme report',  'All six measures against target, what changed, and what we will change next month.'],
    ['Quarterly', 'Business review',   'Cohort retention, lifetime value, programme cost and the backlog for the next quarter.'],
];
?>
<section class="band band--ink mth-measures" id="measures" aria-labelledby="measures-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Outcomes &amp; measurement</p>
        <h2 class="h2" id="measures-t"><span class="g">Six numbers,</span> and how each one is worked out.</h2>
      </div>
      <div>
        <p class="lead">Marketing technology is easy to report well and hard to report honestly. Each measure below has a written definition, a target agreed before launch and a holdout or a baseline behind it, so a good month and a bad one read the same way to your CMO, your CFO and your auditor.</p>
      </div>
    </div>

    <div class="bdh-ui bdh-ui--ink mth-mea" data-period="<?= e($mea_default) ?>" data-rv data-rv-d="60">
      <div class="bdh-ui__bar mth-mea__top">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="mth-mea__title">programme report · Your brand</span>
        <div class="bdh-seg mth-mea__seg" role="tablist" aria-label="Reporting period">
          <?php foreach ($mea_periods as $mea_pk => $mea_p): $mea_on = $mea_pk === $mea_default; ?>
            <button type="button" role="tab" aria-selected="<?= $mea_on ? 'true' : 'false' ?>" tabindex="<?= $mea_on ? '0' : '-1' ?>" data-period="<?= e($mea_pk) ?>"><?= e($mea_p[0]) ?></button>
          <?php endforeach; ?>
        </div>
        <span class="bdh-ill">Illustrative</span>
      </div>

      <div class="mth-mea__grid">
        <?php foreach ($mea_cards as $mea_ci => $mea_c):
            [$mea_key, $mea_con, $mea_ico, $mea_met, $mea_val, $mea_unit, $mea_tl, $mea_tv, $mea_better, $mea_starts, $mea_end, $mea_range, $mea_noise, $mea_dp, $mea_sec, $mea_def] = $mea_c;
            $mea_paths = [];
            foreach ($mea_periods as $mea_pk => $mea_p) {
                $mea_vals = $mea_series((float) $mea_starts[$mea_pk], (float) $mea_end, $mea_p[1], $mea_noise, $mea_ci * 1.3 + 0.7, $mea_dp);
                $mea_paths[$mea_pk] = [
                    'd'  => $mea_path($mea_vals, $mea_range),
                    'dl' => $mea_delta((float) $mea_starts[$mea_pk], (float) $mea_end, $mea_dp, $mea_unit === 'min' ? ' min' : ($mea_unit ? $mea_unit : ''), $mea_p[2]),
                ];
            }
            $mea_ty = $mea_y($mea_tv, $mea_range);
            $mea_ey = $mea_y((float) $mea_end, $mea_range); ?>
          <article class="mth-mea__card" data-key="<?= e($mea_key) ?>"
                   data-paths="<?= e(json_encode($mea_paths, JSON_UNESCAPED_UNICODE)) ?>">
            <div class="mth-mea__ch">
              <span class="mth-mea__cico" aria-hidden="true"><?= xt_icon($mea_ico, ['size' => 18]) ?></span>
              <h3 class="mth-mea__cn"><?= e($mea_con) ?></h3>
            </div>
            <p class="mth-mea__met"><?= e($mea_met) ?></p>
            <p class="mth-mea__val"><b data-bdh-count><?= e($mea_val) ?></b><?= $mea_unit ? '<span>' . e($mea_unit) . '</span>' : '' ?></p>
            <p class="mth-mea__tgt"><span class="mth-flag mth-flag--on"><?= e($mea_tl) ?></span><span class="mth-mea__dl" data-delta><?= e($mea_paths[$mea_default]['dl']) ?></span></p>

            <svg class="mth-spark mth-mea__spark" viewBox="0 0 <?= $mea_w ?> <?= $mea_h ?>" preserveAspectRatio="none" aria-hidden="true" focusable="false">
              <line class="mth-spark__target" x1="0" y1="<?= $mea_ty ?>" x2="<?= $mea_w ?>" y2="<?= $mea_ty ?>"/>
              <path class="mth-spark__line" data-line d="<?= e($mea_paths[$mea_default]['d']) ?>"/>
              <circle class="mth-spark__dot" data-dot cx="<?= $mea_w ?>" cy="<?= $mea_ey ?>" r="3"/>
            </svg>
            <p class="mth-mea__leg" aria-hidden="true"><span><i class="mth-mea__li"></i>Measured</span><span><i class="mth-mea__lt"></i><?= e($mea_tl) ?></span></p>

            <dl class="mth-mea__sec">
              <div><dt><?= e($mea_sec[0]) ?></dt><dd><?= e($mea_sec[1]) ?></dd></div>
            </dl>
            <p class="mth-mea__def"><span class="mth-k">How it is worked out</span><?= e($mea_def) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="mth-mea__below">
      <div class="mth-mea__proof" data-rv data-rv-d="40">
        <h3 class="mth-mea__h3">Why any of it can be believed</h3>
        <ul class="mth-mea__pl">
          <?php foreach ($mea_proof as $mea_pr): ?>
            <li>
              <span class="mth-mea__pico" aria-hidden="true"><?= xt_icon($mea_pr[0], ['size' => 20]) ?></span>
              <b><?= e($mea_pr[1]) ?></b>
              <span><?= e($mea_pr[2]) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="mth-mea__cad" data-rv data-rv-d="70">
        <h3 class="mth-mea__h3">The reporting rhythm</h3>
        <dl class="mth-mea__cl">
          <?php foreach ($mea_cadence as $mea_cd): ?>
            <div>
              <dt><?= e($mea_cd[0]) ?></dt>
              <dd><b><?= e($mea_cd[1]) ?></b><?= e($mea_cd[2]) ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>
        <p class="mth-note">Programmes that cannot show an incremental effect are changed or stopped. That is easier to say before a programme launches than after, which is why the holdout and the baseline are set in phase 00.</p>
      </div>
    </div>
  </div>
</section>
