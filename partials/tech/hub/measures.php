<?php /* DRAFT COPY — review before launch */
/* Measures — we report in numbers engineering leaders already use. A monthly service report for "Your platform":
   six concerns (speed, reliability, AI quality, security, cost, carbon), each a card with its headline number, the
   target agreed before launch, a sparkline against that target and a written definition. A period switch
   (30 days · 90 days · 12 months) redraws every sparkline and its change; a definition opens on hover, focus or
   click. measures.js adds a new datapoint to one card every few seconds while the report is on screen.
   Below: the reporting cadence and the definitions behind the thresholds.
   PLACEHOLDER: every value is illustrative, not a client result. The numbers agree with the rest of the page
   (hero status bar, pace cost line, sustainability SCI). */

/* a deterministic, gently noisy path from $ms_a to $ms_b (the last point is exactly $ms_b) */
$ms_series = function (float $ms_a, float $ms_b, int $ms_n, float $ms_noise, float $ms_seed, bool $ms_int = false): array {
    $ms_out = [];
    for ($ms_i = 0; $ms_i < $ms_n; $ms_i++) {
        $ms_t = $ms_i / ($ms_n - 1);
        $ms_v = $ms_a + ($ms_b - $ms_a) * (1 - (1 - $ms_t) ** 2);
        if ($ms_i < $ms_n - 1) $ms_v += $ms_noise * (sin($ms_i * 1.9 + $ms_seed) * 0.6 + sin($ms_i * 0.7 + $ms_seed * 2) * 0.4) * (1 - $ms_t * 0.5);
        $ms_out[] = $ms_int ? max(0, (int) round($ms_v)) : round($ms_v, 4);
    }
    $ms_out[$ms_n - 1] = $ms_int ? (int) $ms_b : $ms_b;
    return $ms_out;
};
$ms_periods = ['30' => ['30 days', 30, '30 days ago'], '90' => ['90 days', 45, '90 days ago'], '365' => ['12 months', 52, '12 months ago']];
$ms_default = '365';

$ms_cards = [
    // key, concern, icon, metric, value, unit, target label, target, better, [start per period], end, [ymin, ymax], noise, integer?, [secondary label, value], definition, delta format [decimals, prefix, suffix]
    ['speed', 'Speed', 'gauge', 'p75 LCP · mobile, field data', '2.1', 's', 'Good ≤ 2.5 s', 2.5, 'down', ['30' => 2.3, '90' => 2.9, '365' => 3.8], 2.1, [1.6, 4.2], 0.09, false,
     ['p95 API latency', '212 ms'],
     'Largest Contentful Paint at the 75th percentile of real page loads on mobile. Core Web Vitals rate it good at 2.5 s or less, alongside INP ≤ 200 ms and CLS ≤ 0.1. p95 API latency: 95% of requests finish faster than this.',
     [1, '', ' s']],
    ['reliability', 'Reliability', 'uptime', 'SLO attainment · rolling 30 days', '99.97', '%', 'SLO ≥ 99.9%', 99.9, 'up', ['30' => 99.95, '90' => 99.91, '365' => 99.74], 99.97, [99.6, 100.0], 0.02, false,
     ['Error budget left', '71% · 12.5 of 43.2 min used'],
     'The share of requests served well over the window. A 99.9% monthly SLO allows 43.2 minutes of failure in 30 days: the error budget. When it runs out, releases pause and reliability work goes first.',
     [2, '', ' pts']],
    ['ai', 'AI quality', 'eval', 'Faithfulness · golden set', '0.94', '', 'Gate ≥ 0.90', 0.90, 'up', ['30' => 0.93, '90' => 0.91, '365' => 0.84], 0.94, [0.78, 1.0], 0.007, false,
     ['Eval pass rate', '148 / 148 cases'],
     'The share of claims in an answer that the retrieved sources support — faithfulness, also called groundedness — scored by a judge calibrated against expert labels. The same golden set of real cases runs on every change to a model, prompt or data source. One term, one number, one gate: the hero readout, the run log and the composer all report this figure.',
     [2, '', '']],
    ['security', 'Security', 'shield', 'Critical vulnerabilities open', '0', '', 'Target 0 past SLA', 0, 'down', ['30' => 1, '90' => 2, '365' => 6], 0, [0, 7], 0.6, true,
     ['MTTR · high severity', '3.2 days'],
     'Confirmed critical findings from scans, penetration tests and reports, counted until the fix is verified in production. MTTR is the mean time from a finding being confirmed to its fix going live.',
     [0, '', '']],
    ['cost', 'Cost', 'cost', 'Cost per 1,000 requests', '1.02', '$', 'Cap ≤ $1.20', 1.20, 'down', ['30' => 1.05, '90' => 1.42, '365' => 2.40], 1.02, [0.8, 2.6], 0.05, false,
     ['Spend vs monthly budget', '94%'],
     'Compute, model tokens, storage and egress divided by requests served, per 1,000. Reviewed with finance every month using the FinOps Framework, because unit cost says more than the total bill.',
     [2, '$', '']],
    ['carbon', 'Carbon', 'leaf', 'SCI per request', '0.18', 'gCO₂e', 'Target ≤ 0.25', 0.25, 'down', ['30' => 0.19, '90' => 0.26, '365' => 0.47], 0.18, [0.1, 0.5], 0.012, false,
     ['Batch jobs run carbon-aware', '86%'],
     'Software Carbon Intensity, ((E × I) + M) per R, from the Green Software Foundation (ISO/IEC 21031:2024), with R as one request. Offsets are excluded by design, so it only falls when the software uses less.',
     [2, '', ' g']],
];

$ms_w = 240; $ms_h = 64;
$ms_y = fn (float $ms_v, array $ms_r): float => round(($ms_h - 6) - ($ms_v - $ms_r[0]) / ($ms_r[1] - $ms_r[0]) * ($ms_h - 12), 2);
$ms_path = function (array $ms_vals, array $ms_r) use ($ms_w, $ms_y): string {
    $ms_n = count($ms_vals); $ms_d = '';
    foreach ($ms_vals as $ms_i => $ms_v) { $ms_d .= ($ms_i ? ' L' : 'M') . round($ms_i / ($ms_n - 1) * $ms_w, 2) . ' ' . $ms_y((float) $ms_v, $ms_r); }
    return $ms_d;
};
$ms_delta = function (float $ms_a, float $ms_b, array $ms_f, string $ms_per): string {
    $ms_dv = $ms_b - $ms_a;
    if (abs($ms_dv) < 0.00001) return '→ no change · ' . $ms_per;
    return ($ms_dv < 0 ? '▼ ' : '▲ ') . $ms_f[1] . number_format(abs($ms_dv), $ms_f[0]) . $ms_f[2] . ' · ' . $ms_per;
};
$ms_cadence = [
    ['calendar', 'Weekly', 'Operations review', 'SLO burn, incidents, eval drift and anything that paged someone. Fifteen minutes, with the on-call engineer.'],
    ['chart',    'Monthly', 'Service report', 'All six concerns against target, cost and carbon per unit, and what we will change next month.'],
    ['target',   'Quarterly', 'Business review', 'The measures agreed before launch, the roadmap, and DORA metrics for how the delivery itself is running.'],
];
$ms_defs = [
    ['Core Web Vitals · good', 'LCP ≤ 2.5 s · INP ≤ 200 ms · CLS ≤ 0.1, at p75 of field data'],
    ['Error budget', '99.9% over 30 days = 43.2 min of allowed failure'],
    ['Burn-rate alert', '14.4× over one hour spends 2% of the month’s budget: page on-call'],
    ['p95 / p99', 'The latency 95% or 99% of requests beat; averages hide the slow tail'],
];
?>
<section class="band band--ink tih-measures" id="measures" aria-labelledby="measures-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Measures</p>
        <h2 class="h2" id="measures-t"><span class="g">We report in numbers</span> engineering leaders already use.</h2>
      </div>
      <div>
        <p class="lead">Six concerns, one report every month. Each number has a written definition and a target agreed before launch, so a good month and a bad one read the same way to your CTO, your CFO and your auditor.</p>
      </div>
    </div>

    <div class="bdh-ui bdh-ui--ink tih-ms" data-period="<?= e($ms_default) ?>" data-rv data-rv-d="60" data-bdh-live>
      <!-- a report masthead, not a window title bar: this is a document your board would be sent -->
      <div class="tih-ms__mast">
        <div class="tih-ms__mt">
          <p class="tih-k tih-ms__mk">Service report · <?= e($SITE['company']['name']) ?></p>
          <p class="tih-ms__mh">Your platform</p>
          <p class="tih-ms__mm">Six concerns · targets agreed before launch · definitions printed beside every number <span class="bdh-ill tih-ms__ill">Illustrative</span></p>
        </div>
        <div class="bdh-seg tih-ms__seg" role="group" aria-label="Report period">
          <?php foreach ($ms_periods as $ms_pk => $ms_p): ?>
            <button type="button" data-period="<?= e($ms_pk) ?>" aria-pressed="<?= $ms_pk === $ms_default ? 'true' : 'false' ?>" aria-controls="measures-grid"><?= e($ms_p[0]) ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="tih-ms__grid" id="measures-grid">
        <?php foreach ($ms_cards as $ms_ci => $ms_c):
            $ms_all = [];
            foreach ($ms_periods as $ms_pk => $ms_p) { $ms_all[$ms_pk] = $ms_series($ms_c[9][$ms_pk], $ms_c[10], $ms_p[1], $ms_c[12], $ms_ci * 1.3 + (int) $ms_pk / 97, $ms_c[13]); }
            $ms_vals = $ms_all[$ms_default];
            $ms_ty = $ms_y((float) $ms_c[7], $ms_c[11]);
            $ms_ly = $ms_y((float) $ms_c[10], $ms_c[11]);
            $ms_d = $ms_path($ms_vals, $ms_c[11]); ?>
          <article class="tih-ms__card" data-k="<?= e($ms_c[0]) ?>" style="--i:<?= $ms_ci ?>"
                   data-series="<?= e(json_encode($ms_all)) ?>" data-range="<?= e(json_encode($ms_c[11])) ?>" data-fmt="<?= e(json_encode($ms_c[16])) ?>">
            <header class="tih-ms__ch">
              <span class="tih-ms__cn"><span class="tih-ms__ci" aria-hidden="true"><?= xt_icon($ms_c[2], ['size' => 16, 'mono' => true]) ?></span><b><?= str_pad((string) ($ms_ci + 1), 2, '0', STR_PAD_LEFT) ?></b><?= e($ms_c[1]) ?></span>
              <span class="tih-ms__st"><i aria-hidden="true"></i>On target</span>
              <button type="button" class="tih-ms__info" aria-expanded="false" aria-controls="measures-d<?= $ms_ci ?>" title="Definition"><span aria-hidden="true">i</span><span class="bdh-sr">Definition of <?= e($ms_c[3]) ?></span></button>
            </header>
            <h3 class="tih-ms__m" id="measures-m<?= $ms_ci ?>"><?= e($ms_c[3]) ?></h3>
            <p class="tih-ms__v" aria-describedby="measures-d<?= $ms_ci ?>">
              <?php if ($ms_c[5] === '$'): ?><span class="tih-ms__u tih-ms__u--pre">$</span><?php endif; ?><b><?= e($ms_c[4]) ?></b><?php if ($ms_c[5] !== '' && $ms_c[5] !== '$'): ?><span class="tih-ms__u"><?= e($ms_c[5]) ?></span><?php endif; ?>
              <span class="tih-ms__dl" data-delta><?= e($ms_delta((float) $ms_vals[0], (float) $ms_c[10], $ms_c[16], $ms_periods[$ms_default][0])) ?></span>
            </p>
            <div class="tih-ms__spark" aria-hidden="true">
              <svg viewBox="0 0 <?= $ms_w ?> <?= $ms_h ?>" preserveAspectRatio="none" focusable="false">
                <line class="tih-ms__tgt" x1="0" x2="<?= $ms_w ?>" y1="<?= $ms_ty ?>" y2="<?= $ms_ty ?>"/>
                <path class="tih-ms__area" d="<?= e($ms_d . ' L' . $ms_w . ' ' . $ms_h . ' L0 ' . $ms_h . ' Z') ?>"/>
                <path class="tih-ms__line" d="<?= e($ms_d) ?>" pathLength="1"/>
              </svg>
              <span class="tih-ms__dot" style="--y:<?= round($ms_ly / $ms_h * 100, 2) ?>"></span>
              <span class="tih-ms__tl" style="--y:<?= round($ms_ty / $ms_h * 100, 2) ?>"><?= e($ms_c[6]) ?></span>
            </div>
            <p class="tih-ms__ax" aria-hidden="true"><span data-from><?= e($ms_periods[$ms_default][2]) ?></span><span class="tih-ms__new" data-new></span><span>Now</span></p>
            <p class="tih-ms__sub"><span><?= e($ms_c[14][0]) ?></span><b><?= e($ms_c[14][1]) ?></b></p>
            <div class="tih-ms__def" id="measures-d<?= $ms_ci ?>">
              <p class="tih-k">Definition · <?= e($ms_c[1]) ?></p>
              <p><?= e($ms_c[15]) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="tih-ms__below">
      <ol class="tih-ms__cad" data-rv-s data-rv-step="80">
        <?php foreach ($ms_cadence as $ms_k): ?>
          <li>
            <span class="tih-ms__cadi" aria-hidden="true"><?= xt_icon($ms_k[0], ['size' => 20]) ?></span>
            <p class="tih-k"><?= e($ms_k[1]) ?></p>
            <h3 class="bdh-t bdh-t--s"><?= e($ms_k[2]) ?></h3>
            <p class="bdh-d"><?= e($ms_k[3]) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
      <dl class="tih-ms__defs" data-rv>
        <?php foreach ($ms_defs as $ms_df): ?>
          <div><dt><?= e($ms_df[0]) ?></dt><dd><?= e($ms_df[1]) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>
  </div>
</section>
