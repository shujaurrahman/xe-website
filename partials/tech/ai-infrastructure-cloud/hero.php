<?php /* DRAFT COPY — review before launch */
/* Hero — the engine room at a glance. Ink band: breadcrumb and eyebrow, the headline left, the brief right,
   then a bento of five live telemetry tiles for a generic "your-platform-prod" cluster: GPU utilisation heatmap
   (six serving nodes and two warm spares over 60 s), p50/p95/p99 latency against the SLO, output token throughput,
   cost per 1k requests against budget, and regions with carbon intensity. The platform fiction is held across the
   page: eight reserved GPUs, six of them serving, ~68% utilisation, $1.21 blended per 1,000 requests.
   PHP renders a complete still frame from a seeded generator;
   hero.js keeps it moving only while it is on screen. Every value is illustrative. */
$tic_hero_seed = 50705;
$tic_hero_rnd  = function () use (&$tic_hero_seed): float {
    $tic_hero_seed = ($tic_hero_seed * 1103515245 + 12345) % 2147483648;
    return $tic_hero_seed / 2147483648;
};
$tic_hero_clamp = fn (float $v, float $a, float $b): float => max($a, min($b, $v));

/* GPU heatmap: [label, base load]; the last node is the warm pool, loaded but idle */
$tic_hero_nodes = [['gpu-0', .76], ['gpu-1', .70], ['gpu-2', .63], ['gpu-3', .81], ['gpu-4', .55], ['gpu-5', .69], ['warm-0', .05], ['warm-1', .05]];
$tic_hero_heat  = [];
$tic_hero_sum   = 0; $tic_hero_cnt = 0;
foreach ($tic_hero_nodes as $tic_hero_n => $tic_hero_node) {
    $tic_hero_row = [];
    for ($tic_hero_c = 0; $tic_hero_c < 60; $tic_hero_c++) {
        $tic_hero_v = $tic_hero_node[1] < .1
            ? $tic_hero_clamp(.04 + $tic_hero_rnd() * .05, .02, .12)
            : $tic_hero_clamp($tic_hero_node[1] + .11 * sin(($tic_hero_c + $tic_hero_n * 7) / 6) + ($tic_hero_rnd() - .5) * .34, .08, 1);
        $tic_hero_row[] = round($tic_hero_v, 2);
        if ($tic_hero_node[1] >= .1) { $tic_hero_sum += $tic_hero_v; $tic_hero_cnt++; }
    }
    $tic_hero_heat[] = $tic_hero_row;
}
$tic_hero_util = (int) round($tic_hero_sum / max(1, $tic_hero_cnt) * 100);

/* latency, seconds: 62 points (x = 0…610, the last one sits just past the right edge for the scroll) */
$tic_hero_lat = ['p50' => [], 'p95' => [], 'p99' => []];
for ($tic_hero_i = 0; $tic_hero_i < 62; $tic_hero_i++) {
    $tic_hero_bump = exp(-pow(($tic_hero_i - 41) / 3.2, 2));
    $tic_hero_w    = sin($tic_hero_i / 5.5) * .03 + ($tic_hero_rnd() - .5) * .04;
    $tic_hero_lat['p50'][] = round(.42 + $tic_hero_w * .6 + $tic_hero_bump * .08, 3);
    $tic_hero_lat['p95'][] = round(.92 + $tic_hero_w * 1.4 + ($tic_hero_rnd() - .5) * .06 + $tic_hero_bump * .34, 3);
    $tic_hero_lat['p99'][] = round(1.28 + $tic_hero_w * 2 + ($tic_hero_rnd() - .5) * .12 + $tic_hero_bump * .46, 3);
}
$tic_hero_path = function (array $pts): string {   // 0–2 s mapped onto a 200-unit-high chart
    $d = '';
    foreach ($pts as $i => $v) { $d .= ($i ? 'L' : 'M') . ($i * 10) . ',' . round(200 - max(0, min(2, $v)) * 100, 1); }
    return $d;
};
$tic_hero_ms = fn (float $s): string => $s < 1 ? round($s * 1000) . ' ms' : number_format($s, 2) . ' s';

/* throughput */
$tic_hero_tps = 18.4; $tic_hero_tps_max = 24;

/* cost per 1k requests, 24 hourly steps; chart spans $0.80–$1.80 over 120 units.
   $1.21 blended is the platform figure the FinOps console reports; the hero shows the same number moving. */
$tic_hero_cost = [];
for ($tic_hero_i = 0; $tic_hero_i < 24; $tic_hero_i++) { $tic_hero_cost[] = round(1.21 + .08 * sin($tic_hero_i / 3.1) + ($tic_hero_rnd() - .5) * .07, 2); }
$tic_hero_cost[23] = 1.21;
$tic_hero_budget = 1.45;
$tic_hero_cy = fn (float $v): float => round(120 - ($v - .8) / 1.0 * 120, 1);
$tic_hero_step = '';
foreach ($tic_hero_cost as $tic_hero_i => $tic_hero_v) {
    $tic_hero_x = round($tic_hero_i * 300 / 24, 1); $tic_hero_x2 = round(($tic_hero_i + 1) * 300 / 24, 1);
    $tic_hero_step .= ($tic_hero_i ? 'L' . $tic_hero_x . ',' . $tic_hero_cy($tic_hero_v) : 'M0,' . $tic_hero_cy($tic_hero_v)) . 'L' . $tic_hero_x2 . ',' . $tic_hero_cy($tic_hero_v);
}

/* regions: [city, role, traffic %, grid carbon gCO₂e/kWh, intensity level 1–5] */
$tic_hero_regions = [
    ['Mumbai',    'Primary',                    62, 710, 5],
    ['Hyderabad', 'Warm standby',               23, 690, 5],
    ['Stockholm', 'Batch only · non-personal data', 15, 40,  1],
];
?>
<section class="band band--ink tic-hero" id="top" aria-labelledby="hero-t">
  <span class="tic-hero__dots dots-ink" aria-hidden="true"></span>

  <div class="wrap tic-hero__in">
    <div class="tic-hero__top">
      <nav class="tic-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= xe_url('services/') ?>">Services</a></li>
          <li><a href="<?= xe_url('services/technology-intelligence.php') ?>"><?= e($TECH['name']) ?></a></li>
          <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
        </ol>
      </nav>
      <p class="tic-hero__eb"><span class="tic-led" aria-hidden="true"></span>Capability <?= e($CAP['n']) ?> of <?= count($TI) ?> · Fast, reliable, affordable at scale</p>
    </div>

    <div class="tic-hero__intro">
      <h1 class="tic-hero__h" id="hero-t"><span class="g">AI that answers in milliseconds,</span> stays up, and costs what you planned.</h1>
      <div class="tic-hero__brief">
        <p class="lead tic-hero__lead"><?= e($CAP['lead']) ?></p>
        <div class="tic-hero__act">
          <a class="btn btn--ink" href="<?= xe_url('contact.php') ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
          <a class="btn tic-hero__ghost" href="#chaos">Run the failure drill <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>

    <p class="bdh-sr">A live telemetry dashboard for an example cluster called your-platform-prod across three regions, with illustrative values: GPU utilisation across six serving nodes averaging <?= $tic_hero_util ?> percent with two idle warm-pool nodes, p95 latency of about <?= e($tic_hero_ms($tic_hero_lat['p95'][60])) ?> against a 1.5 second objective, output throughput of <?= $tic_hero_tps ?> thousand tokens per second, a blended cost of $1.21 per thousand requests against a $1.45 budget, and three regions with their share of traffic and grid carbon intensity.</p>

    <div class="tic-bento" aria-hidden="true">
      <!-- GPU heatmap -->
      <div class="tic-tile tic-tile--heat">
        <div class="tic-tile__head">
          <p class="tic-k"><span class="tic-led tic-led--blink" style="--i:0"></span> GPU utilisation</p>
          <p class="tic-tile__sub">6 serving + 2 warm · last 60 s</p>
        </div>
        <p class="tic-v tic-tile__big"><span data-hero-util><?= $tic_hero_util ?></span><small>% avg, serving pool</small></p>
        <div class="tic-heat">
          <?php foreach ($tic_hero_nodes as $tic_hero_n => $tic_hero_node): ?>
            <span class="tic-heat__n<?= $tic_hero_node[1] < .1 ? ' is-warm' : '' ?>"><?= e($tic_hero_node[0]) ?></span>
            <span class="tic-heat__row" data-base="<?= $tic_hero_node[1] ?>"><?php foreach ($tic_hero_heat[$tic_hero_n] as $tic_hero_v): ?><i style="--v:<?= $tic_hero_v ?>"></i><?php endforeach; ?></span>
          <?php endforeach; ?>
        </div>
        <p class="tic-tile__legend"><span>−60 s</span><span class="tic-heat__scale"><i style="--v:.1"></i><i style="--v:.35"></i><i style="--v:.6"></i><i style="--v:.85"></i><i style="--v:1"></i></span><span>now</span></p>
      </div>

      <!-- latency percentiles -->
      <div class="tic-tile tic-tile--lat">
        <div class="tic-tile__head">
          <p class="tic-k"><span class="tic-led tic-led--blink" style="--i:1"></span> End-to-end latency</p>
          <p class="tic-tile__sub">last 15 min · 15 s buckets</p>
        </div>
        <div class="tic-lat">
          <ul class="tic-lat__legend">
            <li class="is-p50"><i></i>p50 <b data-hero-lat="p50"><?= e($tic_hero_ms($tic_hero_lat['p50'][60])) ?></b></li>
            <li class="is-p95"><i></i>p95 <b data-hero-lat="p95"><?= e($tic_hero_ms($tic_hero_lat['p95'][60])) ?></b></li>
            <li class="is-p99"><i></i>p99 <b data-hero-lat="p99"><?= e($tic_hero_ms($tic_hero_lat['p99'][60])) ?></b></li>
            <li class="is-slo"><i></i>p95 objective <b>1.50 s</b></li>
          </ul>
          <div class="tic-lat__plot">
            <svg class="tic-lat__svg" viewBox="0 0 600 200" preserveAspectRatio="none" data-hero-series="<?= e(json_encode($tic_hero_lat)) ?>">
              <line class="tic-lat__gl" x1="0" y1="100" x2="600" y2="100"/><line class="tic-lat__gl" x1="0" y1="150" x2="600" y2="150"/>
              <line class="tic-lat__slo" x1="0" y1="50" x2="600" y2="50"/>
              <g class="tic-lat__lines">
                <path class="tic-lat__p99" d="<?= $tic_hero_path($tic_hero_lat['p99']) ?>"/>
                <path class="tic-lat__p50" d="<?= $tic_hero_path($tic_hero_lat['p50']) ?>"/>
                <path class="tic-lat__p95" d="<?= $tic_hero_path($tic_hero_lat['p95']) ?>"/>
              </g>
            </svg>
            <span class="tic-lat__y" style="--y:0">2.0 s</span><span class="tic-lat__y" style="--y:.25">1.5</span><span class="tic-lat__y" style="--y:.5">1.0</span><span class="tic-lat__y" style="--y:.75">0.5</span>
          </div>
        </div>
      </div>

      <!-- throughput gauge -->
      <div class="tic-tile tic-tile--tps">
        <div class="tic-tile__head">
          <p class="tic-k"><span class="tic-led tic-led--blink" style="--i:2"></span> Throughput</p>
        </div>
        <div class="tic-gauge">
          <svg class="tic-gauge__svg" viewBox="0 0 200 112">
            <path class="tic-gauge__track" d="M16,100 A84,84 0 0 1 184,100" pathLength="100"/>
            <path class="tic-gauge__val" d="M16,100 A84,84 0 0 1 184,100" pathLength="100" style="stroke-dashoffset:<?= round(100 - $tic_hero_tps / $tic_hero_tps_max * 100, 1) ?>" data-hero-gauge/>
            <?php for ($tic_hero_t = 0; $tic_hero_t <= 4; $tic_hero_t++): $tic_hero_a = M_PI - $tic_hero_t * M_PI / 4; ?>
              <line class="tic-gauge__tick" x1="<?= round(100 + 70 * cos($tic_hero_a), 1) ?>" y1="<?= round(100 - 70 * sin($tic_hero_a), 1) ?>" x2="<?= round(100 + 62 * cos($tic_hero_a), 1) ?>" y2="<?= round(100 - 62 * sin($tic_hero_a), 1) ?>"/>
            <?php endfor; ?>
          </svg>
          <p class="tic-gauge__v"><span class="tic-v" data-hero-tps><?= number_format($tic_hero_tps, 1) ?>k</span><span class="tic-gauge__u">output tokens / s</span></p>
        </div>
        <dl class="tic-tile__kv">
          <div><dt>TTFT p50</dt><dd data-hero-ttft>280 ms</dd></div>
          <div><dt>Batch</dt><dd data-hero-batch>42 seqs</dd></div>
        </dl>
      </div>

      <!-- cost per 1k requests -->
      <div class="tic-tile tic-tile--cost">
        <div class="tic-tile__head">
          <p class="tic-k"><span class="tic-led tic-led--blink" style="--i:3"></span> Cost per 1k requests</p>
          <p class="tic-tile__sub">24 h</p>
        </div>
        <p class="tic-v tic-tile__big">$<span data-hero-cost>1.21</span><small>budget $<?= number_format($tic_hero_budget, 2) ?></small></p>
        <div class="tic-cost">
          <svg class="tic-cost__svg" viewBox="0 0 300 120" preserveAspectRatio="none" data-hero-costs="<?= e(json_encode($tic_hero_cost)) ?>">
            <line class="tic-cost__budget" x1="0" y1="<?= $tic_hero_cy($tic_hero_budget) ?>" x2="300" y2="<?= $tic_hero_cy($tic_hero_budget) ?>"/>
            <path class="tic-cost__line" d="<?= $tic_hero_step ?>"/>
          </svg>
          <span class="tic-cost__bl" style="--y:<?= round($tic_hero_cy($tic_hero_budget) / 120, 3) ?>">budget</span>
        </div>
        <p class="tic-tile__foot"><span>Cache hit <b data-hero-cache>31%</b></span><span>Small-model share <b>44%</b></span></p>
      </div>

      <!-- regions + carbon -->
      <div class="tic-tile tic-tile--reg">
        <figure class="bdh-img tic-reg__img"><img src="<?= xe_url('assets/imgs/tech/ai-infrastructure-cloud/tic-hero-cables.jpg') ?>" alt="" width="1600" height="1066" loading="eager" decoding="async"></figure>
        <div class="tic-reg">
          <div class="tic-tile__head">
            <p class="tic-k"><span class="tic-led tic-led--blink" style="--i:4"></span> Regions</p>
            <p class="tic-tile__sub">gCO₂e / kWh</p>
          </div>
          <ul class="tic-reg__list">
            <?php foreach ($tic_hero_regions as $tic_hero_r): ?>
              <li>
                <span class="tic-reg__city"><?= e($tic_hero_r[0]) ?><small><?= e($tic_hero_r[1]) ?></small></span>
                <span class="tic-reg__share"><i style="--w:<?= $tic_hero_r[2] / 100 ?>"></i><b data-hero-share><?= $tic_hero_r[2] ?>%</b></span>
                <span class="tic-reg__co2" title="Grid carbon intensity"><span class="tic-reg__dots"><?php for ($tic_hero_d = 1; $tic_hero_d <= 5; $tic_hero_d++): ?><i class="<?= $tic_hero_d <= $tic_hero_r[4] ? 'is-on' : '' ?>"></i><?php endfor; ?></span><b><?= $tic_hero_r[3] ?></b></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <p class="tic-bento__foot">
        <span class="tic-bento__cl"><i class="bdh-pulse"></i>cluster · your-platform-prod · 3 regions</span>
        <span>OpenTelemetry · 15 s scrape</span>
        <span class="bdh-ill">Illustrative values</span>
      </p>
    </div>

    <!-- PLACEHOLDER: confirm the typical phase length (meta 1) before launch -->
    <dl class="tic-hero__meta">
      <?php foreach ($CAP['meta'] as $tic_hero_i => $tic_hero_m): ?>
        <div><dt><?= e($CAP['meta_k'][$tic_hero_i] ?? '') ?></dt><dd><?= e($tic_hero_m) ?></dd></div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>
