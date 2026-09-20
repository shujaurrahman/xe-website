<?php /* DRAFT COPY — review before launch */
/* 03 · SIGNATURE — the Field-Data Speed Simulator. Choose a device class and a network, then switch on six
   optimisations. A pre-authored model (identical in simulator.js) recomputes TTFB, FCP, LCP, INP, CLS, page weight
   and estimated emissions; the 10-frame filmstrip re-renders when the page paints, three gauges score it against the
   Core Web Vitals bands, and "What changed" logs what each change bought. Autoplays optimisations one by one until
   touched. The HTML is the finished state: low-end Android, Slow 4G, all six on. All numbers are illustrative. */
$twa_sim_dev = [['Low-end Android', '4× CPU'], ['Mid-range phone', '2× CPU'], ['Desktop', 'Laptop CPU']];
$twa_sim_net = [['Slow 4G', '150 ms RTT'], ['4G', '60 ms RTT'], ['Fibre', '10 ms RTT']];
$twa_sim_opt = [   // [name, what it does]
    ['Responsive AVIF images + srcset', 'Hero 380 → 64 KB on phones · width and height reserved'],
    ['Font subsetting + font-display', 'Fonts 320 → 70 KB · text paints in a matched fallback'],
    ['Server rendering + streaming', 'HTML arrives ready to paint · no client render wait'],
    ['Code-splitting & island hydration', 'JavaScript 1,100 → 250 KB · only interactive parts hydrate'],
    ['Edge caching (CDN)', 'Cached HTML served near the user · server wait −510 ms'],
    ['Defer third-party scripts', 'Tags and widgets load after consent or first interaction'],
];

/* MODEL — keep identical to model() in assets/js/tech/websites-apps/simulator.js.
   dev 0 low-end · 1 mid · 2 desktop; net 0 slow 4G · 1 4G · 2 fibre; $o = six 0/1 switches in the order above. */
$twa_sim_model = function (int $dev, int $net, array $o): array {
    $C = [4, 2, 1][$dev]; $M = [1.9, 0.55, 0.12][$net]; $R = [150, 60, 10][$net]; $mob = $dev < 2;
    $kb = ['img' => $o[0] ? ($mob ? 430 : 780) : 2200, 'js' => $o[3] ? 250 : 1100, 'tp' => $o[5] ? 0 : 300, 'font' => $o[1] ? 70 : 320, 'css' => 120, 'html' => 60];
    $hero  = $o[0] ? ($mob ? 64 : 140) : 380;
    $ttfb  = 3 * $R + ($o[4] ? 50 : 560) + ($o[2] ? 90 : 0);
    $style = 180 * $C;
    $block = $kb['html'] * $M + 0.8 * $kb['css'] * $M + ($o[1] ? 0 : 0.5 * $kb['font'] * $M);
    if ($o[2]) {
        $shell = $fcp = $ttfb + $block + $style * 0.5;
        $lcp = $ttfb + $block + $hero * $M + $style + 0.35 * $kb['js'] * $C;
    } else {
        $shell = $ttfb + $block + $style * 0.5;
        $fcp = $shell + 0.6 * $kb['js'] * $M + 0.31 * $kb['js'] * $C;
        $lcp = $fcp + $hero * $M + $style * 0.5;
    }
    if (!$o[5]) $lcp += 35 * $C;
    $lcp = max($lcp, $fcp + 60);
    $inp = $C * (30 + ($o[3] ? 15 : 55) + ($o[5] ? 0 : 20) - ($o[2] ? 5 : 0));
    $cls = (($o[0] ? 0.01 : 0.14) + ($o[1] ? 0.01 : 0.06) + ($o[5] ? 0 : 0.05) + ($o[2] ? 0.01 : 0.02)) * ($mob ? 1 : 0.7);
    $w = array_sum($kb);
    /* fcp and lcpRaw are rounded to the same 100 ms the readouts print, so the filmstrip marker and the figure
       beneath it can never disagree by a rounding step. */
    return ['ttfb' => (int) round($ttfb), 'shell' => (int) round($shell), 'fcp' => (int) round($fcp / 100) * 100, 'lcpRaw' => (int) round($lcp / 100) * 100,
            'lcp' => round($lcp / 100) / 10, 'inp' => (int) (round($inp / 10) * 10), 'cls' => round($cls, 2), 'kb' => $kb, 'w' => $w, 'co2' => round($w / 1e6 * 218.35, 2)];
};
$twa_sim_frames = function (array $m, array $o): array {
    $out = []; $prev = -1; $fm = false; $lm = false;
    for ($k = 1; $k <= 10; $k++) {
        $t = 600 * $k;
        $s = $t < $m['shell'] ? 0 : ($t < $m['fcp'] ? 1 : ($t < $m['lcpRaw'] ? 2 : ((!$o[5] && $t >= $m['lcpRaw'] + 500) ? 4 : 3)));
        $mk = [];
        if (!$fm && $t >= $m['fcp'])    { $mk[] = 'FCP'; $fm = true; }
        if (!$lm && $t >= $m['lcpRaw']) { $mk[] = 'LCP'; $lm = true; }
        $shift = ($s >= 3 && $prev < 3 && !$o[0]) || ($s === 4 && $prev < 4);
        $out[] = ['s' => $s, 'mk' => implode(' · ', $mk), 'shift' => $shift];
        $prev = $s;
    }
    return $out;
};
$twa_sim_rate = function (string $k, float $v): array {
    $t = ['lcp' => [2.5, 4], 'inp' => [200, 500], 'cls' => [0.1, 0.25]][$k];
    return $v <= $t[0] ? ['good', 'Good'] : ($v <= $t[1] ? ['ni', 'Needs improvement'] : ['poor', 'Poor']);
};
$twa_sim_frac = function (string $k, float $v): float {   // piecewise so each band gets a fixed share of the dial
    $b = ['lcp' => [2.5, 4, 8], 'inp' => [200, 500, 1000], 'cls' => [0.1, 0.25, 0.5]][$k];
    if ($v <= $b[0]) return 0.4 * $v / $b[0];
    if ($v <= $b[1]) return 0.4 + 0.25 * ($v - $b[0]) / ($b[1] - $b[0]);
    return min(1, 0.65 + 0.35 * ($v - $b[1]) / ($b[2] - $b[1]));
};
$twa_sim_arc = function (float $a, float $b): string {
    $p = fn (float $f): string => round(80 - 64 * cos(M_PI * $f), 2) . ' ' . round(86 - 64 * sin(M_PI * $f), 2);
    return 'M' . $p($a) . ' A64 64 0 0 1 ' . $p($b);
};
/* Field distribution (modelled): page loads assumed log-normal around the p75 value, spread sigma per metric.
   Share of loads under each threshold = Phi((ln t - ln median) / sigma). Keep identical to dist() in simulator.js. */
$twa_sim_phi = function (float $z): float {
    $x = abs($z) / M_SQRT2; $t = 1 / (1 + 0.3275911 * $x);
    $erf = 1 - (((((1.061405429 * $t - 1.453152027) * $t) + 1.421413741) * $t - 0.284496736) * $t + 0.254829592) * $t * exp(-$x * $x);
    return $z >= 0 ? 0.5 * (1 + $erf) : 0.5 * (1 - $erf);
};
$twa_sim_dist = function (string $k, float $v) use ($twa_sim_phi): array {
    $sg = ['lcp' => 0.45, 'inp' => 0.6, 'cls' => 0.8][$k];
    $t  = ['lcp' => [2.5, 4], 'inp' => [200, 500], 'cls' => [0.1, 0.25]][$k];
    $md = log(max($v, 0.001)) - 0.6745 * $sg;
    $g  = (int) round(100 * $twa_sim_phi((log($t[0]) - $md) / $sg));
    $p  = (int) round(100 * (1 - $twa_sim_phi((log($t[1]) - $md) / $sg)));
    return [$g, max(0, 100 - $g - $p), $p];
};
$twa_sim_s  = fn (int $ms): string => number_format($ms / 1000, 1) . ' s';
$twa_sim_mb = fn (int $kb): string => number_format($kb / 1000, 2) . ' MB';

$twa_sim_on   = [1, 1, 1, 1, 1, 1];
$twa_sim_m    = $twa_sim_model(0, 0, $twa_sim_on);
$twa_sim_fr   = $twa_sim_frames($twa_sim_m, $twa_sim_on);
$twa_sim_base = $twa_sim_model(0, 0, [0, 0, 0, 0, 0, 0]);

/* the initial log: the same optimisations applied one by one from the baseline */
$twa_sim_log = [];
$twa_sim_o = [0, 0, 0, 0, 0, 0];
$twa_sim_pm = $twa_sim_base;
foreach ($twa_sim_opt as $twa_si => $twa_sopt) {
    $twa_sim_o[$twa_si] = 1;
    $twa_sim_nm = $twa_sim_model(0, 0, $twa_sim_o);
    $twa_sim_d = [];
    if ($twa_sim_nm['lcp'] != $twa_sim_pm['lcp']) $twa_sim_d[] = 'LCP ' . number_format($twa_sim_pm['lcp'], 1) . ' → ' . number_format($twa_sim_nm['lcp'], 1) . ' s';
    if ($twa_sim_nm['inp'] != $twa_sim_pm['inp']) $twa_sim_d[] = 'INP ' . $twa_sim_pm['inp'] . ' → ' . $twa_sim_nm['inp'] . ' ms';
    if ($twa_sim_nm['cls'] != $twa_sim_pm['cls']) $twa_sim_d[] = 'CLS ' . number_format($twa_sim_pm['cls'], 2) . ' → ' . number_format($twa_sim_nm['cls'], 2);
    if ($twa_sim_nm['w'] != $twa_sim_pm['w'])     $twa_sim_d[] = number_format($twa_sim_pm['w'] / 1000, 2) . ' → ' . number_format($twa_sim_nm['w'] / 1000, 2) . ' MB';
    if (!$twa_sim_d) $twa_sim_d[] = 'No change at this setting';
    array_unshift($twa_sim_log, ['+', $twa_sopt[0] . ' on', implode(' · ', $twa_sim_d)]);
    $twa_sim_pm = $twa_sim_nm;
}
$twa_sim_log[] = ['·', 'Baseline · Low-end Android · Slow 4G', 'LCP ' . number_format($twa_sim_base['lcp'], 1) . ' s · INP ' . $twa_sim_base['inp'] . ' ms · CLS ' . number_format($twa_sim_base['cls'], 2) . ' · ' . $twa_sim_mb($twa_sim_base['w'])];

$twa_sim_g = [   // key, label, full name, unit formatter, tick labels at the band edges
    ['lcp', 'LCP', 'Largest Contentful Paint', number_format($twa_sim_m['lcp'], 1) . ' s', ['2.5 s', '4 s']],
    ['inp', 'INP', 'Interaction to Next Paint', $twa_sim_m['inp'] . ' ms', ['200', '500']],
    ['cls', 'CLS', 'Cumulative Layout Shift', number_format($twa_sim_m['cls'], 2), ['0.1', '0.25']],
];
$twa_sim_wk = [['img', 'Images'], ['js', 'JavaScript'], ['tp', 'Third-party'], ['font', 'Fonts'], ['css', 'CSS'], ['html', 'HTML']];
$twa_sim_cfg = [
    'dev' => array_column($twa_sim_dev, 0), 'net' => array_column($twa_sim_net, 0), 'opt' => array_column($twa_sim_opt, 0),
    'state' => ['dev' => 0, 'net' => 0, 'o' => $twa_sim_on],
];
?>
<section class="band band--ink twa-simulator" id="simulator" aria-labelledby="simulator-t">
  <div class="wrap">
    <div class="twa-head" data-rv>
      <p class="twa-head__run"><b>03 · Field test</b><span>Interactive · illustrative model</span></p>
      <div class="twa-head__t">
        <h2 class="h2" id="simulator-t"><span class="g">Turn the optimisations on.</span> Watch the page arrive sooner.</h2>
      </div>
      <div class="twa-head__l">
        <p class="lead">Pick a device and a network, then switch on the work that goes into every build. The filmstrip shows when the page paints, the gauges score it against the Core Web Vitals thresholds, and the log records what each change bought.</p>
      </div>
    </div>

    <div class="twa-sim" data-sim='<?= e(json_encode($twa_sim_cfg, JSON_UNESCAPED_UNICODE)) ?>'>
      <div class="twa-sim__app xt-on-ink" data-rv>
        <div class="twa-sim__bar">
          <span class="twa-sim__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="twa-sim__path">field-test · Your platform · /shop/stoneware</span>
          <span class="twa-sim__state"><span class="bdh-pulse" aria-hidden="true"></span><span data-sim-state>Your settings</span></span>
          <span class="twa-ill">Illustrative model</span>
        </div>

        <div class="twa-sim__grid">
          <div class="twa-sim__ctl">
            <div class="twa-sim__fs">
              <p class="twa-sim__lbl" id="sim-dev-l">Device class</p>
              <div class="twa-sim__seg" role="group" aria-labelledby="sim-dev-l">
                <?php foreach ($twa_sim_dev as $twa_si => $twa_sd): ?>
                  <button type="button" data-dev="<?= $twa_si ?>" aria-pressed="<?= $twa_si === 0 ? 'true' : 'false' ?>"><b><?= e($twa_sd[0]) ?></b><small><?= e($twa_sd[1]) ?></small></button>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="twa-sim__fs">
              <p class="twa-sim__lbl" id="sim-net-l">Network</p>
              <div class="twa-sim__seg" role="group" aria-labelledby="sim-net-l">
                <?php foreach ($twa_sim_net as $twa_si => $twa_sn): ?>
                  <button type="button" data-net="<?= $twa_si ?>" aria-pressed="<?= $twa_si === 0 ? 'true' : 'false' ?>"><b><?= e($twa_sn[0]) ?></b><small><?= e($twa_sn[1]) ?></small></button>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="twa-sim__fs">
              <p class="twa-sim__lbl" id="sim-opt-l"><span>Optimisations</span><span data-sim-count>6 of 6 on</span></p>
              <div class="twa-sim__opts" role="group" aria-labelledby="sim-opt-l">
                <?php foreach ($twa_sim_opt as $twa_si => $twa_so): ?>
                  <button type="button" class="bdh-switch twa-sim__sw" data-opt="<?= $twa_si ?>" aria-pressed="true">
                    <span class="bdh-switch__track" aria-hidden="true"></span>
                    <span class="twa-sim__swt"><b><?= e($twa_so[0]) ?></b><small><?= e($twa_so[1]) ?></small></span>
                  </button>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="twa-sim__btns">
              <button type="button" class="twa-btn" data-sim-all>All on</button>
              <button type="button" class="twa-btn" data-sim-none>Reset to baseline</button>
            </div>
          </div>

          <div class="twa-sim__out">
            <div class="twa-sim__fh">
              <p class="twa-sim__lbl">Filmstrip · one frame every 0.6 s</p>
              <p class="twa-sim__key" aria-hidden="true"><span><i class="k-mk"></i>Paint milestone</span><span><i class="k-sh"></i>Layout shift</span></p>
            </div>
            <ol class="twa-sim__film" data-dev="0" data-res="1" data-tp="0" aria-hidden="true">
              <?php foreach ($twa_sim_fr as $twa_fi => $twa_f): ?>
                <li class="twa-sim__fr<?= $twa_f['shift'] ? ' is-shift' : '' ?>">
                  <span class="twa-fr" data-s="<?= $twa_f['s'] ?>">
                    <span class="twa-fr__load"></span>
                    <span class="twa-fr__ban"><i></i><i></i></span>
                    <span class="twa-fr__nav"><i></i><b></b><em></em></span>
                    <span class="twa-fr__pic"><img src="<?= xe_url('assets/imgs/tech/websites-apps/product-vase.jpg') ?>" width="1400" height="933" alt="" loading="lazy" decoding="async"></span>
                    <span class="twa-fr__txt"><i></i><i></i><i></i><i></i></span>
                  </span>
                  <span class="twa-sim__ft"><?= number_format(0.6 * ($twa_fi + 1), 1) ?> s</span>
                  <span class="twa-sim__fm"><?= e($twa_f['mk']) ?></span>
                </li>
              <?php endforeach; ?>
            </ol>

            <div class="twa-sim__gauges">
              <?php foreach ($twa_sim_g as $twa_gg):
                  $twa_gv = (float) $twa_sim_m[$twa_gg[0]];
                  $twa_gr = $twa_sim_rate($twa_gg[0], $twa_gv); ?>
                <div class="twa-g" data-g="<?= $twa_gg[0] ?>">
                  <p class="twa-g__hd"><b><?= $twa_gg[1] ?></b><span><?= e($twa_gg[2]) ?></span></p>
                  <svg class="twa-g__svg" viewBox="0 0 160 96" aria-hidden="true" focusable="false">
                    <path class="twa-g__band twa-g__band--good" d="<?= $twa_sim_arc(0.005, 0.395) ?>"/>
                    <path class="twa-g__band twa-g__band--ni" d="<?= $twa_sim_arc(0.405, 0.645) ?>"/>
                    <path class="twa-g__band twa-g__band--poor" d="<?= $twa_sim_arc(0.655, 0.995) ?>"/>
                    <text class="twa-g__tk" x="<?= round(80 - 80 * cos(M_PI * 0.4), 1) ?>" y="<?= round(86 - 80 * sin(M_PI * 0.4), 1) ?>" text-anchor="end"><?= e($twa_gg[4][0]) ?></text>
                    <text class="twa-g__tk" x="<?= round(80 - 80 * cos(M_PI * 0.65), 1) ?>" y="<?= round(86 - 80 * sin(M_PI * 0.65), 1) ?>" text-anchor="start"><?= e($twa_gg[4][1]) ?></text>
                    <g class="twa-g__needle" style="transform:rotate(<?= round(180 * $twa_sim_frac($twa_gg[0], $twa_gv), 2) ?>deg)"><line x1="80" y1="86" x2="30" y2="86"/></g>
                    <circle class="twa-g__hub" cx="80" cy="86" r="5"/>
                  </svg>
                  <p class="twa-g__v"><b data-g-v><?= e($twa_gg[3]) ?></b><span class="twa-rt twa-rt--<?= $twa_gr[0] ?>" data-g-r><?= $twa_gr[1] ?></span></p>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="twa-sim__stats">
              <div class="twa-sim__weight">
                <p class="twa-sim__sk"><span>Page weight</span><b data-sim-w><?= $twa_sim_mb($twa_sim_m['w']) ?></b></p>
                <span class="twa-sim__wbar" aria-hidden="true">
                  <?php $twa_sim_left = 0; foreach ($twa_sim_wk as $twa_wk):
                      $twa_ww = $twa_sim_m['kb'][$twa_wk[0]] / 4100; ?>
                    <i class="w-<?= $twa_wk[0] ?>" style="transform:translateX(<?= round($twa_sim_left * 100, 2) ?>%) scaleX(<?= round($twa_ww, 4) ?>)"></i>
                  <?php $twa_sim_left += $twa_ww; endforeach; ?>
                </span>
                <ul class="twa-sim__wl">
                  <?php foreach ($twa_sim_wk as $twa_wk): ?><li><i class="w-<?= $twa_wk[0] ?>" aria-hidden="true"></i><?= e($twa_wk[1]) ?> <b data-sim-kb="<?= $twa_wk[0] ?>"><?= number_format($twa_sim_m['kb'][$twa_wk[0]]) ?> KB</b></li><?php endforeach; ?>
                </ul>
              </div>
              <p class="twa-sim__st"><span>Server wait (TTFB)</span><b data-sim-ttfb><?= $twa_sim_m['ttfb'] ?> ms</b></p>
              <p class="twa-sim__st"><span>First Contentful Paint</span><b data-sim-fcp><?= $twa_sim_s($twa_sim_m['fcp']) ?></b></p>
              <p class="twa-sim__st"><span>Est. gCO2e per view</span><b data-sim-co2><?= number_format($twa_sim_m['co2'], 2) ?> g</b></p>
            </div>

            <?php $twa_sim_pass = $twa_sim_m['lcp'] <= 2.5 && $twa_sim_m['inp'] <= 200 && $twa_sim_m['cls'] <= 0.1; ?>
            <div class="twa-sim__cwv">
              <div class="twa-sim__ch">
                <p class="twa-sim__lbl"><span>Core Web Vitals assessment · field distribution</span></p>
                <p class="twa-sim__verdict<?= $twa_sim_pass ? ' is-pass' : '' ?>" data-sim-verdict><span class="twa-rt twa-rt--<?= $twa_sim_pass ? 'good' : 'poor' ?>" data-sim-vr><?= $twa_sim_pass ? 'Passed' : 'Failed' ?></span><small>all three at p75 must be good</small></p>
              </div>
              <ul class="twa-sim__dist">
                <?php foreach ($twa_sim_g as $twa_gg): $twa_dd = $twa_sim_dist($twa_gg[0], (float) $twa_sim_m[$twa_gg[0]]); ?>
                  <li data-d="<?= $twa_gg[0] ?>">
                    <b><?= $twa_gg[1] ?></b>
                    <span class="twa-sim__db" aria-hidden="true">
                      <i class="d-g" style="transform:scaleX(<?= $twa_dd[0] / 100 ?>)"></i><i class="d-n" style="transform:translateX(<?= $twa_dd[0] ?>%) scaleX(<?= $twa_dd[1] / 100 ?>)"></i><i class="d-p" style="transform:translateX(<?= $twa_dd[0] + $twa_dd[1] ?>%) scaleX(<?= $twa_dd[2] / 100 ?>)"></i>
                      <em class="twa-sim__p75"></em>
                    </span>
                    <span class="twa-sim__dv"><span data-dv="g"><?= $twa_dd[0] ?>%</span><span data-dv="n"><?= $twa_dd[1] ?>%</span><span data-dv="p"><?= $twa_dd[2] ?>%</span></span>
                  </li>
                <?php endforeach; ?>
              </ul>
              <p class="twa-sim__dk" aria-hidden="true"><span><i class="d-g"></i>Good</span><span><i class="d-n"></i>Needs improvement</span><span><i class="d-p"></i>Poor</span><span><i class="d-l"></i>75th percentile</span></p>
            </div>
            <p class="bdh-sr" aria-live="polite" data-sim-live></p>
          </div>
        </div>

        <div class="twa-sim__log">
          <p class="twa-sim__lbl"><span>What changed</span><span>newest first</span></p>
          <ol class="twa-sim__logl" data-sim-log>
            <?php foreach ($twa_sim_log as $twa_sl): ?>
              <li><b aria-hidden="true"><?= e($twa_sl[0]) ?></b><span><?= e($twa_sl[1]) ?></span><em><?= e($twa_sl[2]) ?></em></li>
            <?php endforeach; ?>
          </ol>
        </div>
      </div>

      <p class="twa-sim__note">An illustrative model, not a measurement of any site. Thresholds are Google’s Core Web Vitals, judged at p75: good is LCP ≤ 2.5 s, INP ≤ 200 ms and CLS ≤ 0.1; poor is above 4 s, 500 ms and 0.25. A page passes the assessment when all three are good at the 75th percentile; the distributions assume page loads spread log-normally around that value. Emissions follow the Sustainable Web Design methodology, for a first view with no caching: 0.494 kWh per gigabyte transferred at a global-average grid intensity of 442 gCO2e per kilowatt-hour, which is about 218 gCO2e per decimal gigabyte (1 GB = 1,000,000 KB). §08 uses the same two numbers.</p>
    </div>
  </div>
</section>
