<?php /* DRAFT COPY — review before launch */
/* 08 Carbon — carbon is a scheduling decision. A carbon-aware scheduler for one day: grid carbon intensity for two
   Indian regions, three workloads (inference pinned near users, a movable embedding refresh, a fixed backup), and
   the SCI readout for the refresh, SCI = ((E × I) + M) per R, with R = 1,000 documents embedded. The refresh moves
   by the slider, by dragging, by the region buttons or by "Find the lowest-carbon window". The intensity chart and
   the three workload lanes share one 0–24 h axis — both run the full panel width minus the same right-hand gutter
   the y labels sit in — so the shaded window and the job block line up hour for hour. HTML = the finished,
   optimised state (Chennai, 11:00); carbon.js replays the move from the 01:00 Mumbai default once on entry.
   Beside it: two photographs and the levers. Intensities, energy and embodied figures are illustrative. */
$tic_cb_regions = [   // key => [name, cloud region note, hourly gCO₂e/kWh 00–23]
    'mumbai'  => ['Mumbai',  'west India · primary',  [742, 738, 735, 733, 731, 733, 726, 712, 690, 668, 645, 628, 616, 611, 618, 634, 660, 694, 728, 752, 760, 756, 751, 746]],
    'chennai' => ['Chennai', 'south India · standby', [652, 646, 641, 637, 634, 630, 612, 580, 541, 506, 480, 466, 458, 461, 474, 497, 532, 578, 624, 662, 676, 672, 666, 659]],
];
$tic_cb_job = ['name' => 'Embedding refresh', 'hours' => 4, 'kwh' => 22.0, 'm' => 1.9, 'docs' => 400];   // kWh incl. PUE; M kgCO₂e embodied share; R in thousands of documents
$tic_cb_def = ['r' => 'mumbai', 's' => 1];     // the cron as shipped
$tic_cb_opt = ['r' => 'chennai', 's' => 11];   // the finished state
$tic_cb_avg = function (string $r, int $s) use ($tic_cb_regions, $tic_cb_job): float {
    return array_sum(array_slice($tic_cb_regions[$r][2], $s, $tic_cb_job['hours'])) / $tic_cb_job['hours'];
};
$tic_cb_calc = function (string $r, int $s) use ($tic_cb_avg, $tic_cb_job): array {
    $i = $tic_cb_avg($r, $s);
    $kg = $tic_cb_job['kwh'] * $i / 1000 + $tic_cb_job['m'];
    return ['i' => $i, 'kg' => $kg, 'sci' => $kg * 1000 / $tic_cb_job['docs']];
};
$tic_cb_a = $tic_cb_calc($tic_cb_opt['r'], $tic_cb_opt['s']);
$tic_cb_b = $tic_cb_calc($tic_cb_def['r'], $tic_cb_def['s']);
$tic_cb_delta = round((1 - $tic_cb_a['sci'] / $tic_cb_b['sci']) * 100);

$tic_cb_x = fn (float $h): float => round($h / 24 * 720, 1);
$tic_cb_y = fn (float $v): float => round(180 - ($v - 400) / 400 * 180, 1);
$tic_cb_path = function (array $vals) use ($tic_cb_x, $tic_cb_y): string {
    $d = '';
    foreach ($vals as $h => $v) { $d .= ($h ? 'L' : 'M') . $tic_cb_x($h + .5) . ',' . $tic_cb_y($v); }
    return $d;
};
$tic_cb_hh = fn (int $h): string => sprintf('%02d:00', $h % 24);
?>
<section class="band band--alt tic-carbon" id="carbon" aria-labelledby="carbon-t">
  <div class="wrap">
    <div class="tic-head" data-rv>
      <p class="tic-ch"><b>08</b><span>Sustainability</span><i aria-hidden="true"></i><em>software carbon intensity, per unit of work</em></p>
      <div class="tic-head__t">
        <h2 class="h2" id="carbon-t"><span class="g">Carbon is</span> a scheduling decision.</h2>
      </div>
      <div class="tic-head__l">
        <p class="lead">The same job on the same GPUs emits more or less depending on when and where it runs. Inference that people wait for stays close to them. Batch work moves to the hours and regions where the grid is cleaner, inside your residency rules.</p>
      </div>
    </div>

    <div class="tic-cb">
      <div class="tic-cb__panel" data-rv data-region="<?= e($tic_cb_opt['r']) ?>" style="--s:<?= $tic_cb_opt['s'] ?>">
        <script type="application/json" class="tic-cb__data"><?= json_encode(['regions' => array_map(fn ($r) => ['name' => $r[0], 'i' => $r[2]], $tic_cb_regions), 'job' => $tic_cb_job, 'def' => $tic_cb_def, 'opt' => $tic_cb_opt], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
        <div class="tic-cb__bar">
          <p class="tic-cb__title"><span class="tic-led tic-led--blink" aria-hidden="true"></span>scheduler · your-platform · tomorrow</p>
          <div class="bdh-seg tic-cb__seg" role="group" aria-label="Region for the embedding refresh">
            <?php foreach ($tic_cb_regions as $tic_cb_k => $tic_cb_r): ?>
              <button type="button" data-cb-region="<?= e($tic_cb_k) ?>" aria-pressed="<?= $tic_cb_k === $tic_cb_opt['r'] ? 'true' : 'false' ?>"><?= e($tic_cb_r[0]) ?></button>
            <?php endforeach; ?>
          </div>
        </div>

        <p class="bdh-sr">A chart of grid carbon intensity across one day for Mumbai and Chennai, both highest overnight and in the evening and lowest around midday, when solar output peaks; Chennai sits lower throughout. The embedding refresh is scheduled in the shaded four-hour window.</p>
        <div class="tic-cb__chart" aria-hidden="true">
          <p class="tic-cb__unit">gCO₂e / kWh</p>
          <div class="tic-cb__plot">
            <svg class="tic-cb__svg" viewBox="0 0 720 180" preserveAspectRatio="none">
              <defs><clipPath id="tic-cb-wipe" clipPathUnits="userSpaceOnUse"><rect class="tic-wipe" x="-4" y="-12" width="728" height="204"/></clipPath></defs>
              <?php foreach ([500, 600, 700] as $tic_cb_g): ?><line class="tic-cb__gl" x1="0" y1="<?= $tic_cb_y($tic_cb_g) ?>" x2="720" y2="<?= $tic_cb_y($tic_cb_g) ?>"/><?php endforeach; ?>
              <?php foreach ($tic_cb_regions as $tic_cb_k => $tic_cb_r): ?>
                <path class="tic-cb__line tic-cb__line--<?= e($tic_cb_k) ?>" d="<?= $tic_cb_path($tic_cb_r[2]) ?>" clip-path="url(#tic-cb-wipe)"/>
              <?php endforeach; ?>
            </svg>
            <span class="tic-cb__win"><i></i></span>
            <?php foreach ([500, 600, 700] as $tic_cb_g): ?><span class="tic-cb__yl" style="--y:<?= round($tic_cb_y($tic_cb_g) / 180, 3) ?>"><?= $tic_cb_g ?></span><?php endforeach; ?>
            <span class="tic-cb__tag tic-cb__tag--mumbai" style="--y:<?= round($tic_cb_y(760) / 180, 3) ?>">Mumbai</span>
            <span class="tic-cb__tag tic-cb__tag--chennai" style="--y:<?= round($tic_cb_y(676) / 180, 3) ?>">Chennai</span>
            <span class="tic-cb__sun" style="--x:<?= round(12.5 / 24, 3) ?>">solar peak</span>
          </div>
        </div>

        <div class="tic-cb__lanes">
          <div class="tic-cb__lane tic-cb__lane--fixed">
            <p class="tic-cb__ln"><?= xt_icon('latency', ['size' => 16]) ?><span>Inference<small>latency-sensitive · stays near users</small></span><b class="tic-cb__when tic-cb__when--f">all day</b></p>
            <div class="tic-cb__track" aria-hidden="true"><i class="tic-cb__inf"></i></div>
          </div>
          <div class="tic-cb__lane tic-cb__lane--job">
            <p class="tic-cb__ln"><?= xt_icon('vector', ['size' => 16]) ?><span><?= e($tic_cb_job['name']) ?><small><?= $tic_cb_job['hours'] ?> h · <?= number_format($tic_cb_job['kwh'], 0) ?> kWh · drag the block or use the slider</small></span><b class="tic-cb__when" data-cb-when><?= e($tic_cb_hh($tic_cb_opt['s']) . '–' . $tic_cb_hh($tic_cb_opt['s'] + $tic_cb_job['hours'])) ?></b></p>
            <div class="tic-cb__track tic-cb__track--drag" data-cb-drag aria-hidden="true"><i class="tic-cb__ghost" style="--g:<?= $tic_cb_def['s'] ?>"></i><b class="tic-cb__job"><i></i><i></i><i></i></b></div>
          </div>
          <div class="tic-cb__lane tic-cb__lane--fixed">
            <p class="tic-cb__ln"><?= xt_icon('database', ['size' => 16]) ?><span>Backup snapshot<small>fixed · keeps the RPO</small></span><b class="tic-cb__when tic-cb__when--f">02:00 · 14:00</b></p>
            <div class="tic-cb__track" aria-hidden="true"><i class="tic-cb__bk" style="--b:2"></i><i class="tic-cb__bk" style="--b:14"></i></div>
          </div>
          <p class="tic-cb__hours" aria-hidden="true"><?php foreach ([0, 6, 12, 18, 24] as $tic_cb_h): ?><span style="--x:<?= $tic_cb_h / 24 ?>"><?= sprintf('%02d', $tic_cb_h) ?></span><?php endforeach; ?></p>
        </div>

        <div class="tic-cb__ctl">
          <label class="tic-cb__rl" for="tic-cb-start">Start the refresh at <b data-cb-start><?= e($tic_cb_hh($tic_cb_opt['s'])) ?></b></label>
          <input type="range" id="tic-cb-start" class="tic-cb__range" min="0" max="20" step="1" value="<?= $tic_cb_opt['s'] ?>" data-cb-range aria-valuetext="<?= e($tic_cb_hh($tic_cb_opt['s'])) ?> to <?= e($tic_cb_hh($tic_cb_opt['s'] + 4)) ?>" style="--p:<?= round($tic_cb_opt['s'] / 20, 3) ?>">
          <div class="tic-cb__btns">
            <button type="button" class="tic-btn tic-btn--blue" data-cb-best><?= xt_icon('leaf', ['size' => 16, 'mono' => true]) ?>Find the lowest-carbon window</button>
            <button type="button" class="tic-btn" data-cb-default>Back to the 01:00 cron</button>
          </div>
        </div>

        <div class="tic-cb__out">
          <dl class="tic-cb__kpis">
            <div><dt>Grid intensity, I</dt><dd class="tic-v"><span data-cb-i><?= round($tic_cb_a['i']) ?></span><small>g/kWh</small></dd></div>
            <div><dt>Job emissions</dt><dd class="tic-v"><span data-cb-kg><?= number_format($tic_cb_a['kg'], 1) ?></span><small>kgCO₂e</small></dd></div>
            <div class="is-key"><dt>SCI per 1k documents</dt><dd class="tic-v"><span data-cb-sci><?= number_format($tic_cb_a['sci'], 1) ?></span><small>gCO₂e</small></dd><dd class="tic-cb__d" data-cb-delta>−<?= $tic_cb_delta ?>% vs the 01:00 Mumbai cron</dd></div>
          </dl>
          <p class="tic-cb__f"><span class="tic-cb__fk">SCI</span> = ((<b>E</b> × <b>I</b>) + <b>M</b>) per <b>R</b><span class="tic-cb__fv">E <?= number_format($tic_cb_job['kwh'], 0) ?> kWh · I <span data-cb-i2><?= round($tic_cb_a['i']) ?></span> g/kWh · M <?= $tic_cb_job['m'] ?> kg · R 1k documents</span></p>
          <p class="tic-note">Both regions are in India, so the documents never leave the country. Illustrative intensities; in production they come from a grid-data API and energy from GPU telemetry. <span class="bdh-ill">Illustrative</span></p>
        </div>
        <p class="bdh-sr" aria-live="polite" data-cb-status></p>
      </div>

      <aside class="tic-cb__side" aria-label="How carbon comes down">
        <div class="tic-cb__photos" data-rv>
          <figure class="bdh-img bdh-img--r43 tic-cb__ph"><img src="<?= xe_url('assets/imgs/tech/ai-infrastructure-cloud/tic-carbon-wind.jpg') ?>" alt="Wind turbines across farmland, seen from above through breaking cloud" width="1400" height="933" loading="lazy" decoding="async"></figure>
          <figure class="bdh-img bdh-img--r43 tic-cb__ph"><img src="<?= xe_url('assets/imgs/tech/ai-infrastructure-cloud/tic-carbon-hydro.jpg') ?>" alt="A dam spillway from directly above, with the reservoir on one side and the outflow on the other" width="1400" height="1050" loading="lazy" decoding="async"></figure>
        </div>
        <ul class="tic-cb__levers" data-rv-s data-rv-step="80">
          <li><b>Do less work per answer</b><span>Quantisation, batching and caching raise useful tokens per GPU-hour, so energy per request falls with cost.</span></li>
          <li><b>Switch off what nobody uses</b><span>Idle dev, preview and eval environments scale to zero overnight and at weekends.</span></li>
          <li><b>Measure it like latency</b><span>GPU energy from NVIDIA DCGM, grid intensity per region and hour, embodied emissions per server, reported per unit of work.</span></li>
        </ul>
        <div class="tic-cb__badge" data-rv>
          <p class="tic-k">Specification we measure with</p>
          <?= xt_badge('sci', ['variant' => 'hex']) ?>
        </div>
      </aside>
    </div>
  </div>
</section>
