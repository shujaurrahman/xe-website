<?php /* DRAFT COPY — review before launch */
/* 04 SIGNATURE — the Failure Drill. A 10-minute window of peak traffic for the example platform (40 requests/s
   at peak — the same platform the FinOps console bills at about 35 million requests a month — SLO 99.9% monthly
   availability) with a scrubber and Play. Three injections (kill a GPU node, provider returns
   429, region outage) and a "Resilience patterns" switch. Each combination is modelled here in PHP at 5 s steps:
   successful requests/s, p95 latency, client-visible error rate, error budget remaining, the 1 h and 5 m burn
   rates and the fast-burn page (14.4×), plus a timestamped incident log. chaos.js plots the series up to the
   playhead, greys failed components on the mini-map and writes the log. HTML = the finished drill for
   "Kill a GPU node" with patterns on. Every figure is illustrative. */

$tic_dr_T      = range(0, 600, 10);   // 10 s steps: 61 points, which is finer than the 600-unit charts can show
$tic_dr_hit    = 120;
$tic_dr_budget = 43.2;            // minutes of full downtime allowed in a 30-day month at 99.9%
$tic_dr_start  = 62.0;            // % of this month's budget left when the drill starts
$tic_dr_ramp   = fn (float $t, float $a, float $b): float => max(0.0, min(1.0, ($t - $a) / ($b - $a)));
$tic_dr_dec    = fn (float $t, float $a, float $tau): float => $t < $a ? 1.0 : exp(-($t - $a) / $tau);

$tic_dr_base = function (float $t): array {
    return [
        40 + 2.7 * sin($t / 95) + 1.0 * sin($t * .37) * cos($t * .11),
        860 + 40 * sin($t / 70) + 22 * sin($t * .29) * cos($t * .17),
        .05 + .03 * abs(sin($t / 41)),
    ];
};

/* one point: [success rps, p95 ms, error %] for scenario $s, patterns on/off */
$tic_dr_point = function (string $s, bool $on, float $t) use ($tic_dr_base, $tic_dr_ramp, $tic_dr_dec, $tic_dr_hit): array {
    [$rps, $p95, $err] = $tic_dr_base($t);
    $n = sin($t * .53) * cos($t * .21);
    if ($t >= $tic_dr_hit) {
        if ($s === 'node') {
            if (!$on) {
                if ($t < 480)      { $err = 20 + $n * 1.5; $p95 = 2300 + 260 * $tic_dr_ramp($t, 120, 200) + $n * 90; }
                elseif ($t < 495)  { $err = 20 * (1 - $tic_dr_ramp($t, 480, 495)); $p95 = $p95 + 1600 * $tic_dr_dec($t, 480, 25); }
                else               { $p95 = $p95 + 1600 * $tic_dr_dec($t, 480, 25); }
            } else {
                if ($t < 130) $err = 4;
                $add = $t < 135 ? 460 * $tic_dr_ramp($t, 120, 135) : ($t < 210 ? 460 + $n * 30 : 460 * $tic_dr_dec($t, 210, 20));
                $p95 += $add;
                if ($t < 210) $rps *= .985;
            }
        } elseif ($s === 'provider') {
            if (!$on) {
                if ($t < 480)      { $err = 50 * $tic_dr_ramp($t, 120, 126) + $n * 2; $p95 = 1000 + 2850 * $tic_dr_ramp($t, 120, 140) + $n * 140; }
                elseif ($t < 490)  { $err = 50 * (1 - $tic_dr_ramp($t, 480, 490)); $p95 = $p95 + 2900 * $tic_dr_dec($t, 480, 30); }
                else               { $p95 = $p95 + 2900 * $tic_dr_dec($t, 480, 30); }
            } else {
                if ($t < 125)      $err = 6;
                elseif ($t < 130)  $err = 1.2;
                $add = $t < 140 ? 380 * $tic_dr_ramp($t, 120, 140) : ($t < 200 ? 380 + $n * 25 : 90 + 290 * $tic_dr_dec($t, 200, 25));
                if ($t >= 480) $add = 90 * $tic_dr_dec($t, 480, 40);
                $p95 += $add;
            }
        } else {   // region
            if (!$on) {
                if ($t < 540)      { $err = 100; $p95 = 4000; }
                else               { $err = 100 * $tic_dr_dec($t, 540, 6); $p95 = $p95 + 150 + 950 * $tic_dr_dec($t, 540, 40); }
            } else {
                /* Health checks fail within a few seconds and the global load balancer drains Mumbai, so the
                   full outage is short enough that the 1 h burn rate never reaches the 14.4× paging threshold. */
                if ($t < 138)      { $err = 100; $p95 = 4000; }
                elseif ($t < 165)  { $err = 100 * (1 - $tic_dr_ramp($t, 138, 165)); $p95 = 1750; }
                else               { $p95 = $p95 + 150 + 700 * $tic_dr_dec($t, 165, 60); }
            }
        }
    }
    $err = max(0.0, min(100.0, $err));
    return [$rps * (1 - $err / 100), min(4000.0, $p95), $err];
};

$tic_dr_scn = [   // key => [button label, short name]
    'node'     => ['Kill a GPU node', 'GPU node lost'],
    'provider' => ['Provider returns 429 rate limits', 'Provider 429s'],
    'region'   => ['Region outage', 'Region outage'],
];
$tic_dr_clock = fn (int $t): string => sprintf('14:%02d:%02d', intdiv($t, 60), $t % 60);
$tic_dr_mmss  = fn (int $t): string => sprintf('%02d:%02d', intdiv($t, 60), $t % 60);

$tic_dr_data = ['t' => $tic_dr_T, 'hit' => $tic_dr_hit, 'budget0' => $tic_dr_start, 'runs' => []];
foreach ($tic_dr_scn as $tic_dr_k => $tic_dr_label) {
    foreach (['on' => true, 'off' => false] as $tic_dr_mk => $tic_dr_on) {
        $tic_dr_rn = ['rps' => [], 'p95' => [], 'err' => [], 'bud' => [], 'burn' => []];
        $tic_dr_left = $tic_dr_start; $tic_dr_errs = []; $tic_dr_alert = null;
        foreach ($tic_dr_T as $tic_dr_i => $tic_dr_t) {
            [$tic_dr_r, $tic_dr_p, $tic_dr_er] = $tic_dr_point($tic_dr_k, $tic_dr_on, (float) $tic_dr_t);
            $tic_dr_errs[] = $tic_dr_er;
            $tic_dr_left  -= ($tic_dr_er / 100) * (10 / 60) / $tic_dr_budget * 100;
            $tic_dr_long   = (.05 * (3600 - $tic_dr_t) + array_sum($tic_dr_errs) * 10) / 3600;           // 1 h window, baseline before the drill
            $tic_dr_short  = array_sum(array_slice($tic_dr_errs, -30)) * 10 / max(10, min(300, $tic_dr_t + 10)); // 5 m window
            $tic_dr_burn   = $tic_dr_long / .1;
            if ($tic_dr_alert === null && $tic_dr_burn >= 14.4 && $tic_dr_short / .1 >= 14.4) $tic_dr_alert = $tic_dr_t;
            $tic_dr_rn['rps'][]  = (int) round($tic_dr_r);
            $tic_dr_rn['p95'][]  = (int) round($tic_dr_p);
            $tic_dr_rn['err'][]  = round($tic_dr_er, 2);
            $tic_dr_rn['bud'][]  = round($tic_dr_left, 3);
            $tic_dr_rn['burn'][] = round($tic_dr_burn, 1);
        }
        $tic_dr_rn['alert'] = $tic_dr_alert;
        $tic_dr_rn['used']  = round($tic_dr_start - $tic_dr_left, 2);
        $tic_dr_data['runs'][$tic_dr_k . '-' . $tic_dr_mk] = $tic_dr_rn;
    }
}
$tic_dr_used = fn (string $k): string => number_format($tic_dr_data['runs'][$k]['used'], $tic_dr_data['runs'][$k]['used'] < .1 ? 2 : 1) . '%';
$tic_dr_at   = fn (string $k): int => (int) ($tic_dr_data['runs'][$k]['alert'] ?? 0);

/* incident logs: [t, level (info|warn|crit|ok), text] */
$tic_dr_logs = [
    'node-on' => [
        [0,   'info', 'Drill started · 40 req/s at peak · p95 860 ms'],
        [120, 'crit', 'gpu-node-3 stops responding (injected)'],
        [129, 'warn', 'Health check fails 3 × 3 s → node ejected from the pool'],
        [130, 'info', 'In-flight requests retried once on healthy nodes'],
        [140, 'warn', 'Queue depth 180 · backpressure on · p95 1.3 s'],
        [150, 'info', 'Autoscaler: +1 replica from the warm pool'],
        [210, 'ok',   'Replica ready · weights loaded from local cache'],
        [240, 'ok',   'Recovered without a page · budget used ' . $tic_dr_used('node-on')],
    ],
    'node-off' => [
        [0,   'info', 'Drill started · 40 req/s at peak · p95 860 ms'],
        [120, 'crit', 'gpu-node-3 stops responding (injected)'],
        [125, 'warn', 'No health check · 1 in 4 pool requests still sent to gpu-node-3'],
        [150, 'warn', 'Error rate 20% · p95 2.5 s · users see timeouts'],
        [$tic_dr_at('node-off'), 'crit', 'Page: burn rate over 14.4× on 1 h and 5 m windows'],
        [480, 'warn', 'On-call drains gpu-node-3 by hand'],
        [510, 'ok',   'Recovered · budget used ' . $tic_dr_used('node-off')],
    ],
    'provider-on' => [
        [0,   'info', 'Drill started · 40 req/s at peak · p95 860 ms'],
        [120, 'crit', 'Provider A returns 429 Too Many Requests (injected)'],
        [124, 'warn', 'Router: 429s over threshold → circuit breaker opens for provider A'],
        [125, 'info', 'Traffic shifted to provider B and self-hosted · retries capped at 10%, jittered'],
        [130, 'info', 'Semantic cache answers 18% of repeat questions'],
        [160, 'info', 'Autoscaler: +2 replicas on the self-hosted pool'],
        [200, 'ok',   'p95 back under 1 s on fallback routes'],
        [480, 'info', 'Half-open probe to provider A succeeds · traffic returns in 10% steps'],
        [540, 'ok',   'Recovered without a page · budget used ' . $tic_dr_used('provider-on')],
    ],
    'provider-off' => [
        [0,   'info', 'Drill started · 40 req/s at peak · p95 860 ms'],
        [120, 'crit', 'Provider A returns 429 Too Many Requests (injected)'],
        [125, 'warn', 'Clients retry at once, 3 times · calls to provider A ×2.4'],
        [140, 'warn', 'Error rate 50% · retries keep provider A throttled'],
        [$tic_dr_at('provider-off'), 'crit', 'Page: burn rate over 14.4× on 1 h and 5 m windows'],
        [300, 'warn', 'No fallback route configured · waiting on the provider'],
        [480, 'info', 'Provider A stops rate limiting'],
        [500, 'ok',   'Recovered · budget used ' . $tic_dr_used('provider-off')],
    ],
    'region-on' => [
        [0,   'info', 'Drill started · 40 req/s at peak · p95 860 ms'],
        [120, 'crit', 'Primary region (Mumbai) unreachable (injected)'],
        [126, 'warn', 'Global load balancer health checks fail · failover starts'],
        [138, 'info', 'Traffic moving to the Hyderabad warm standby · pool scaling 4 → 8'],
        [150, 'info', 'Synthetic probe alert · on-call notified, no action needed'],
        [165, 'ok',   'Serving from Hyderabad · p95 1.75 s while caches warm'],
        [300, 'ok',   'p95 1.1 s · stable on standby'],
        [360, 'ok',   'Budget used ' . $tic_dr_used('region-on') . ' · post-incident review booked'],
    ],
    'region-off' => [
        [0,   'info', 'Drill started · 40 req/s at peak · p95 860 ms'],
        [120, 'crit', 'Primary region (Mumbai) unreachable (injected)'],
        [125, 'warn', 'Every request failing · no automated failover'],
        [$tic_dr_at('region-off'), 'crit', 'Page: burn rate over 14.4× · incident declared'],
        [300, 'warn', 'Runbook: promote standby database, scale standby cluster by hand'],
        [480, 'info', 'DNS switched to Hyderabad · waiting out a 60 s TTL'],
        [545, 'ok',   'Recovered · budget used ' . $tic_dr_used('region-off')],
    ],
];
foreach ($tic_dr_logs as $tic_dr_k => $tic_dr_l) { usort($tic_dr_l, fn ($a, $b) => $a[0] <=> $b[0]); $tic_dr_data['runs'][$tic_dr_k]['log'] = $tic_dr_l; }

/* chart geometry: [key, title, unit, min, max, threshold|null, threshold label] */
$tic_dr_charts = [
    ['rps', 'Successful requests', 'req/s', 0, 60, null, ''],
    ['p95', 'p95 latency', 'ms', 0, 4000, 1500, 'SLO 1.5 s'],
    ['err', 'Error rate', '%', 0, 100, null, ''],
    ['bud', 'Error budget left', '% of month', 40, 65, null, ''],
];
$tic_dr_data['charts'] = array_map(fn ($c) => ['key' => $c[0], 'min' => $c[3], 'max' => $c[4]], $tic_dr_charts);
$tic_dr_path = function (array $vals, float $min, float $max): string {
    $d = '';
    foreach ($vals as $i => $v) { $d .= ($i ? 'L' : 'M') . ($i * 10) . ',' . round(120 - (max($min, min($max, $v)) - $min) / ($max - $min) * 120, 1); }
    return $d;
};
$tic_dr_fmt = function (string $key, float $v): string {
    if ($key === 'rps') return number_format($v) . '';
    if ($key === 'p95') return $v >= 4000 ? '≥ 4 s' : ($v >= 1000 ? number_format($v / 1000, 2) . ' s' : number_format($v) . ' ms');
    if ($key === 'err') return ($v < 1 ? number_format($v, 2) : number_format($v, 1)) . '%';
    return number_format($v, 1) . '%';
};
$tic_dr_def = 'node-on';
$tic_dr_run = $tic_dr_data['runs'][$tic_dr_def];
$tic_dr_peak = fn (array $run, string $k): float => (float) max(array_slice($run[$k], intdiv($tic_dr_hit, 10)));
?>
<section class="band band--ink tic-chaos" id="chaos" aria-labelledby="chaos-t">
  <div class="wrap">
    <div class="tic-head tic-head--wide" data-rv>
      <p class="tic-ch"><b>04</b><span>Failure drill</span><i aria-hidden="true"></i><em>chaos engineering, before your customers do it for you</em></p>
      <div class="tic-head__t">
        <h2 class="h2" id="chaos-t"><span class="g">We break it on purpose,</span> so it holds when it matters.</h2>
      </div>
      <div class="tic-head__l">
        <p class="lead">Pick a failure and inject it into a ten-minute window of production-like traffic. Run it with the resilience patterns off, then on, and watch latency, errors and the error budget.</p>
      </div>
    </div>

    <div class="tic-dr" data-rv data-scn="node" data-mode="on">
      <script type="application/json" class="tic-dr__data"><?= json_encode($tic_dr_data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
      <p class="bdh-sr">Interactive failure drill. Choose one of three injected failures, turn the resilience patterns on or off, then press Play or move the timeline slider. Four charts show successful requests per second, p95 latency, error rate and the error budget left for the month; the architecture map shows which component failed and where traffic goes; the incident log lists what happened and when. All values are illustrative.</p>

      <div class="tic-dr__bar">
        <div class="tic-dr__inject" role="group" aria-label="Inject a failure">
          <span class="tic-k tic-dr__lab">Inject</span>
          <?php $tic_dr_n = 0; foreach ($tic_dr_scn as $tic_dr_k => $tic_dr_s): $tic_dr_n++; ?>
            <button type="button" class="tic-btn tic-dr__scn" data-dr-scn="<?= e($tic_dr_k) ?>" aria-pressed="<?= $tic_dr_k === 'node' ? 'true' : 'false' ?>"><span class="tic-btn__k">0<?= $tic_dr_n ?></span><?= e($tic_dr_s[0]) ?></button>
          <?php endforeach; ?>
        </div>
        <button type="button" class="bdh-switch tic-dr__sw" aria-pressed="true" data-dr-mode><span class="bdh-switch__track" aria-hidden="true"></span>Resilience patterns <b class="tic-dr__swv" aria-hidden="true">on</b></button>
      </div>

      <div class="tic-dr__time">
        <button type="button" class="tic-btn tic-dr__play" data-dr-play aria-label="Play the drill"><span class="tic-dr__pi" aria-hidden="true"></span><span data-dr-playt>Replay</span></button>
        <div class="tic-dr__scrub">
          <input type="range" class="tic-dr__range" min="0" max="600" step="10" value="600" aria-label="Drill timeline" aria-valuetext="10:00 of 10:00" data-dr-range style="--p:1">
          <span class="tic-dr__hitmark" style="--x:<?= $tic_dr_hit / 600 ?>" aria-hidden="true">inject</span>
          <span class="tic-dr__ticks" aria-hidden="true"><?php for ($tic_dr_m = 0; $tic_dr_m <= 10; $tic_dr_m += 2): ?><i style="--x:<?= $tic_dr_m / 10 ?>"><?= $tic_dr_m ?>m</i><?php endfor; ?></span>
        </div>
        <p class="tic-dr__clock"><b data-dr-clock>10:00</b><span>/ 10:00</span></p>
      </div>

      <div class="tic-dr__main">
        <div class="tic-dr__charts">
          <?php foreach ($tic_dr_charts as $tic_dr_ci => $tic_dr_c):
              $tic_dr_last = $tic_dr_run[$tic_dr_c[0]][count($tic_dr_T) - 1]; ?>
            <div class="tic-dr__chart" data-dr-chart="<?= e($tic_dr_c[0]) ?>">
              <div class="tic-dr__ch">
                <p class="tic-k"><?= e($tic_dr_c[1]) ?> <span><?= e($tic_dr_c[2]) ?></span></p>
                <p class="tic-dr__val tic-v" data-dr-val><?= e($tic_dr_fmt($tic_dr_c[0], (float) $tic_dr_last)) ?></p>
              </div>
              <div class="tic-dr__plot">
                <svg viewBox="0 0 600 120" preserveAspectRatio="none" class="tic-dr__svg" aria-hidden="true" focusable="false">
                  <defs><clipPath id="tic-dr-clip-<?= $tic_dr_ci ?>"><rect class="tic-dr__clip" x="0" y="-10" width="600" height="140"/></clipPath></defs>
                  <line class="tic-dr__gl" x1="0" y1="60" x2="600" y2="60"/>
                  <line class="tic-dr__inj" x1="<?= $tic_dr_hit ?>" y1="0" x2="<?= $tic_dr_hit ?>" y2="120"/>
                  <?php if ($tic_dr_c[5] !== null): $tic_dr_ty = round(120 - ($tic_dr_c[5] - $tic_dr_c[3]) / ($tic_dr_c[4] - $tic_dr_c[3]) * 120, 1); ?>
                    <line class="tic-dr__th" x1="0" y1="<?= $tic_dr_ty ?>" x2="600" y2="<?= $tic_dr_ty ?>"/>
                  <?php endif; ?>
                  <path class="tic-dr__ghost" d="<?= $tic_dr_path($tic_dr_data['runs']['node-off'][$tic_dr_c[0]], $tic_dr_c[3], $tic_dr_c[4]) ?>"/>
                  <path class="tic-dr__future" d="<?= $tic_dr_path($tic_dr_run[$tic_dr_c[0]], $tic_dr_c[3], $tic_dr_c[4]) ?>"/>
                  <path class="tic-dr__line" d="<?= $tic_dr_path($tic_dr_run[$tic_dr_c[0]], $tic_dr_c[3], $tic_dr_c[4]) ?>" clip-path="url(#tic-dr-clip-<?= $tic_dr_ci ?>)"/>
                  <line class="tic-dr__ph" x1="600" y1="0" x2="600" y2="120"/>
                </svg>
                <?php if ($tic_dr_c[5] !== null): ?><span class="tic-dr__thl" style="--y:<?= round(1 - ($tic_dr_c[5] - $tic_dr_c[3]) / ($tic_dr_c[4] - $tic_dr_c[3]), 3) ?>"><?= e($tic_dr_c[6]) ?></span><?php endif; ?>
                <span class="tic-dr__ax tic-dr__ax--t"><?= e($tic_dr_fmt($tic_dr_c[0], (float) $tic_dr_c[4])) ?></span>
                <span class="tic-dr__ax tic-dr__ax--b"><?= e($tic_dr_fmt($tic_dr_c[0], (float) $tic_dr_c[3])) ?></span>
              </div>
            </div>
          <?php endforeach; ?>
          <p class="tic-dr__legend" aria-hidden="true"><span class="is-line">This run · patterns <b data-dr-lg="cur">on</b></span><span class="is-ghost">Same failure · patterns <b data-dr-lg="alt">off</b></span><span class="is-inj">Injection at 02:00</span></p>
        </div>

        <div class="tic-dr__side">
          <div class="tic-dr__map">
            <p class="tic-k tic-dr__mk"><span>Architecture</span><span data-dr-maps>gpu-node-3 ejected · replica added</span></p>
            <svg class="tic-dr__msvg is-n3-down is-n3-ejected is-w0-up" viewBox="0 0 360 300" aria-hidden="true" focusable="false" data-dr-map>
              <rect class="tic-dr__frame tic-dr__frame--p" x="104" y="44" width="248" height="190" rx="12"/>
              <text class="tic-dr__fl tic-dr__fl--p" x="118" y="62" data-dr-region>Mumbai · primary</text>
              <rect class="tic-dr__frame tic-dr__frame--s" x="104" y="248" width="248" height="46" rx="10"/>
              <text class="tic-dr__fl tic-dr__keep" x="118" y="266">Hyderabad · warm standby</text>

              <path class="tic-dr__lk tic-dr__lk--in" d="M228,24 L228,72"/>
              <path class="tic-dr__lk tic-dr__lk--gr" d="M228,98 L228,116"/>
              <path class="tic-dr__lk tic-dr__lk--a" d="M178,129 C140,129 120,106 94,106"/>
              <path class="tic-dr__lk tic-dr__lk--b" d="M178,135 C140,135 120,160 94,160"/>
              <path class="tic-dr__lk tic-dr__lk--pool" d="M228,142 L228,176"/>
              <path class="tic-dr__lk tic-dr__lk--sb" d="M270,14 C352,14 352,150 352,200 L352,271"/>

              <rect class="tic-dr__node tic-dr__node--c" x="188" y="4" width="80" height="22" rx="11"/><text class="tic-dr__nt tic-dr__keep" x="228" y="19" text-anchor="middle">clients</text>
              <rect class="tic-dr__node" x="178" y="72" width="100" height="26" rx="8"/><text class="tic-dr__nt" x="228" y="89" text-anchor="middle">gateway</text>
              <rect class="tic-dr__node tic-dr__node--r" x="178" y="116" width="100" height="26" rx="8"/><text class="tic-dr__nt tic-dr__nt--r" x="228" y="133" text-anchor="middle">router</text>
              <rect class="tic-dr__chip tic-dr__chip--q" x="120" y="146" width="48" height="18" rx="9"/><text class="tic-dr__ct" x="144" y="158" text-anchor="middle">queue</text>
              <rect class="tic-dr__chip tic-dr__chip--c" x="288" y="119" width="52" height="20" rx="10"/><text class="tic-dr__ct" x="314" y="132" text-anchor="middle">cache</text>

              <g class="tic-dr__prov tic-dr__prov--a"><rect class="tic-dr__node" x="8" y="93" width="86" height="26" rx="8"/><text class="tic-dr__nt" x="51" y="110" text-anchor="middle">provider A</text><text class="tic-dr__x" x="51" y="136" text-anchor="middle">429</text></g>
              <g class="tic-dr__prov tic-dr__prov--b"><rect class="tic-dr__node" x="8" y="147" width="86" height="26" rx="8"/><text class="tic-dr__nt" x="51" y="164" text-anchor="middle">provider B</text></g>

              <text class="tic-dr__fl" x="118" y="175">GPU pool</text>
              <?php foreach ([['n0', 180], ['n1', 201], ['n2', 222], ['n3', 243], ['n4', 264], ['n5', 285], ['w0', 306], ['w1', 327]] as $tic_dr_gi => $tic_dr_g): ?>
                <g class="tic-dr__gpu tic-dr__gpu--<?= $tic_dr_g[0] ?>"><rect x="<?= $tic_dr_g[1] - 8.5 ?>" y="180" width="17" height="30" rx="3.5"/><text class="tic-dr__gn" x="<?= $tic_dr_g[1] ?>" y="199" text-anchor="middle"><?= $tic_dr_g[0][0] === 'w' ? 'w' : substr($tic_dr_g[0], 1) ?></text></g>
              <?php endforeach; ?>
              <text class="tic-dr__fl" x="171" y="226">6 serving · 2 warm</text>
              <?php foreach ([150, 178, 206, 234] as $tic_dr_x): ?><rect class="tic-dr__sbn" x="<?= $tic_dr_x + 60 ?>" y="275" width="22" height="12" rx="3"/><?php endforeach; ?>
            </svg>
          </div>

          <div class="tic-dr__log">
            <p class="tic-k tic-dr__mk"><span>Incident log</span><span data-dr-logs><?= count($tic_dr_run['log']) ?> events</span></p>
            <ol class="tic-dr__lines" data-dr-log aria-live="polite">
              <?php foreach ($tic_dr_run['log'] as $tic_dr_l): ?>
                <li class="is-<?= e($tic_dr_l[1]) ?>"><time><?= e($tic_dr_clock((int) $tic_dr_l[0])) ?></time><span><?= e($tic_dr_l[2]) ?></span></li>
              <?php endforeach; ?>
            </ol>
          </div>
        </div>
      </div>

      <dl class="tic-dr__sum">
        <div><dt>Peak client-visible errors</dt><dd data-dr-sum="err"><?= e($tic_dr_fmt('err', $tic_dr_peak($tic_dr_run, 'err'))) ?></dd></div>
        <div><dt>Peak p95 latency</dt><dd data-dr-sum="p95"><?= e($tic_dr_fmt('p95', $tic_dr_peak($tic_dr_run, 'p95'))) ?></dd></div>
        <div><dt>Error budget used</dt><dd data-dr-sum="used"><?= e($tic_dr_used($tic_dr_def)) ?> of the month</dd></div>
        <div><dt>Fast-burn page</dt><dd data-dr-sum="page"><?= $tic_dr_run['alert'] === null ? 'Not triggered' : 'Fired at ' . e($tic_dr_mmss((int) $tic_dr_run['alert'])) ?></dd></div>
      </dl>
      <p class="bdh-sr" aria-live="polite" data-dr-status></p>
    </div>

    <ul class="tic-dr__notes" data-rv-s data-rv-step="90">
      <li>
        <p class="tic-k">The objective</p>
        <h3 class="bdh-t">99.9% monthly availability</h3>
        <p class="bdh-d">Leaves 0.1% of requests to fail: the equivalent of 43.2 minutes of full downtime in a 30-day month. That allowance is the error budget, and spending it is a decision, not an accident.</p>
      </li>
      <li>
        <p class="tic-k">The page</p>
        <h3 class="bdh-t">Burn-rate alerts, not noise</h3>
        <p class="bdh-d">On-call is paged when the budget burns at 14.4× the sustainable rate over both 1 hour and 5 minutes, which spends 2% of the month in an hour. Slower burns (6× over 6 hours) page too; gentle ones open a ticket.</p>
      </li>
      <li>
        <p class="tic-k">The patterns</p>
        <h3 class="bdh-t">What “on” switches on</h3>
        <ul class="bdh-bullets"><li>Health checks that eject failed nodes</li><li>A router with circuit breakers and fallback providers</li><li>A request queue with backpressure and capped, jittered retries</li><li>A semantic cache and an autoscaler with a warm pool</li><li>Automated failover to a warm standby region</li></ul>
      </li>
    </ul>
  </div>
</section>
