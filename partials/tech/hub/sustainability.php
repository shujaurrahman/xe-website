<?php /* DRAFT COPY — review before launch */
/* Sustainability — efficient by design, measured per request. An SCI report window for one route
   ("support.answer"): the Green Software Foundation formula SCI = ((E × I) + M) per R with R = one request,
   a region picker that trades grid intensity against latency and data residency, and five practice switches.
   A waterfall shows how each practice takes carbon out of the baseline; the SCI figure recomputes (and counts)
   on every change. Beside it: a photograph and the three rules we report by. Below: the five practices.
   HTML = the finished state (India West, every practice on). Every number is illustrative. */
$sus_base = ['e' => 0.55, 'm' => 0.075];   // Wh per request (incl. PUE) and embodied gCO₂e per request, before any practice
$sus_regions = [
    // key => [label, place, gCO₂e per kWh, p50 RTT from Delhi users, residency]
    'in-west'  => ['India West',  'Mumbai',    710, '28 ms',  'In India'],
    'in-north' => ['India North', 'Delhi',     690, '8 ms',   'In India'],
    'sg'       => ['Singapore',   'Singapore', 470, '68 ms',  'Outside India'],
    'eu-c'     => ['EU Central',  'Frankfurt', 350, '120 ms', 'Outside India'],
    'eu-n'     => ['EU North',    'Stockholm', 40,  '140 ms', 'Outside India'],
];
$sus_region = 'in-west';
$sus_practices = [
    // [key, name, what we do, typical lever (illustrative), icon, factor on E, factor on I, factor on M]
    ['size',  'Right-size the models',     'Small model first, routed up only when confidence is low. Most questions never reach the large model.', 'Energy per request down 30–60% on routed traffic', 'chip',    0.55, 1,    1],
    ['cache', 'Cache and batch',           'A semantic cache answers repeat questions; offline jobs run in batches instead of one call at a time.',   'Model calls down 20–40%',                           'layers',  0.75, 1,    1],
    ['aware', 'Carbon-aware scheduling',   'Embeddings, reports and fine-tuning move to hours or regions with a cleaner grid, using live intensity signals.', 'Batch emissions down 10–30%',            'clock',   1,    0.92, 1],
    ['light', 'Lighter pages',             'Image, font and JavaScript budgets enforced in CI, so every visit moves less data to the phone.',         'Page weight down 30–50%',                           'gauge',   0.95, 1,    1],
    ['idle',  'Retire idle infrastructure', 'Scale to zero overnight, right-size clusters and delete orphaned resources in a monthly sweep.',          'Idle spend and embodied share down',                'leaf',    0.9,  1,    0.7],
];
/* the same arithmetic sustainability.js runs: apply each practice in order and record what it removed */
$sus_calc = function (string $sus_r, array $sus_on) use ($sus_base, $sus_regions, $sus_practices): array {
    $sus_e = $sus_base['e']; $sus_i = $sus_regions[$sus_r][2]; $sus_m = $sus_base['m'];
    $sus_sci = fn ($e, $i, $m) => ($e / 1000) * $i + $m;
    $sus_start = $sus_sci($sus_e, $sus_i, $sus_m);
    $sus_steps = [];
    foreach ($sus_practices as $sus_p) {
        $sus_before = $sus_sci($sus_e, $sus_i, $sus_m);
        if (in_array($sus_p[0], $sus_on, true)) { $sus_e *= $sus_p[5]; $sus_i *= $sus_p[6]; $sus_m *= $sus_p[7]; }
        $sus_steps[$sus_p[0]] = $sus_before - $sus_sci($sus_e, $sus_i, $sus_m);
    }
    return ['start' => $sus_start, 'steps' => $sus_steps, 'sci' => $sus_sci($sus_e, $sus_i, $sus_m), 'e' => $sus_e, 'i' => $sus_i, 'm' => $sus_m];
};
$sus_all = array_column($sus_practices, 0);
$sus_now = $sus_calc($sus_region, $sus_all);
$sus_max = max(array_map(fn ($sus_k) => $sus_calc($sus_k, [])['start'], array_keys($sus_regions)));   // scale: the dirtiest baseline
$sus_pct = fn (float $sus_v): string => round($sus_v / $sus_max * 100, 3) . '%';
$sus_rat = fn (float $sus_v): string => (string) round($sus_v / $sus_max, 4);
$sus_g = fn (float $sus_v): string => number_format($sus_v, 2);
$sus_cut = 1 - $sus_now['sci'] / $sus_now['start'];
$sus_rules = [
    ['We report per functional unit', 'SCI per request, per active user or per 1,000 tokens, with the boundary written down.'],
    ['Offsets are not reductions', 'Certificates and offsets never enter the figure. The SCI specification excludes them by design.'],
    ['Region is a three-way choice', 'Latency, data residency under the DPDP Act and grid intensity, decided together and recorded.'],
];
?>
<section class="band tih-sustainability" id="sustainability" aria-labelledby="sustainability-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Sustainability in tech</p>
        <h2 class="h2" id="sustainability-t"><span class="g">Efficient by design,</span> measured per request.</h2>
      </div>
      <div>
        <p class="lead">AI multiplies the energy behind every click. We measure carbon the way we measure latency, per request, with the Green Software Foundation's Software Carbon Intensity (SCI, ISO/IEC 21031), and design it down with the same levers that cut cost.</p>
      </div>
    </div>

    <div class="tih-sus">
      <div class="tih-sus__side">
        <!-- PLACEHOLDER: reference photograph (Unsplash) — replace with commissioned/own imagery before launch -->
        <figure class="bdh-img bdh-img--r45 tih-sus__img" data-rv>
          <img src="<?= xe_url('assets/imgs/tech/hub/sustainability-wind.jpg') ?>" alt="Wind turbines on the horizon at dusk" width="1400" height="875" loading="lazy" decoding="async">
          <span class="bdh-cap-chip tih-sus__chip"><b>Reported, not offset</b>Carbon is designed out, then measured</span>
        </figure>
        <ol class="tih-sus__rules" data-rv-s data-rv-step="80">
          <?php foreach ($sus_rules as $sus_ri => $sus_r): ?>
            <li><span class="bdh-idx"><?= str_pad((string) ($sus_ri + 1), 2, '0', STR_PAD_LEFT) ?></span><h3 class="bdh-t bdh-t--s"><?= e($sus_r[0]) ?></h3><p class="bdh-d"><?= e($sus_r[1]) ?></p></li>
          <?php endforeach; ?>
        </ol>
      </div>

      <div class="bdh-ui tih-sus__ui" data-region="<?= e($sus_region) ?>" data-e0="<?= $sus_base['e'] ?>" data-m0="<?= $sus_base['m'] ?>" data-rv data-rv-d="80">
        <div class="bdh-ui__bar">
          <span class="tih-sus__title">sci-report <i>/</i> your-platform <i>/</i> support.answer</span>
          <span class="bdh-ill tih-sus__ill">Illustrative</span>
        </div>

        <div class="tih-sus__body">
          <div class="tih-sus__formula" role="img" aria-label="SCI equals E times I plus M, per R">
            <span class="tih-sus__eq"><b>SCI</b> = ((<b class="is-e">E</b> × <b class="is-i">I</b>) + <b class="is-m">M</b>) per <b class="is-r">R</b></span>
            <dl class="tih-sus__terms">
              <div><dt><b>E</b> Energy</dt><dd><span data-sus="e"><?= number_format($sus_now['e'], 2) ?></span> Wh per request, including data-centre overhead</dd></div>
              <div><dt><b>I</b> Grid intensity</dt><dd><span data-sus="i"><?= number_format($sus_now['i'], 0) ?></span> gCO₂e per kWh where it runs</dd></div>
              <div><dt><b>M</b> Embodied</dt><dd><span data-sus="m"><?= number_format($sus_now['m'], 3) ?></span> g, the hardware's share of its own manufacture</dd></div>
              <div><dt><b>R</b> Functional unit</dt><dd>One answered request</dd></div>
            </dl>
          </div>

          <div class="tih-sus__ctl">
            <div class="tih-sus__grp">
              <p class="tih-k" id="sustainability-rk">Region · grid intensity and round trip from Delhi users</p>
              <div class="tih-sus__regions" role="radiogroup" aria-labelledby="sustainability-rk">
                <?php foreach ($sus_regions as $sus_k => $sus_rg): $sus_on = $sus_k === $sus_region; ?>
                  <button type="button" role="radio" class="tih-sus__rg" data-r="<?= e($sus_k) ?>" data-i="<?= $sus_rg[2] ?>" aria-checked="<?= $sus_on ? 'true' : 'false' ?>" tabindex="<?= $sus_on ? '0' : '-1' ?>">
                    <span class="tih-sus__rn"><?= e($sus_rg[0]) ?></span>
                    <span class="tih-sus__rp"><?= e($sus_rg[1]) ?></span>
                    <span class="tih-sus__rbar" aria-hidden="true"><i style="--w:<?= round($sus_rg[2] / 760, 3) ?>"></i></span>
                    <span class="tih-sus__rv"><b><?= $sus_rg[2] ?></b> g/kWh</span>
                    <span class="tih-sus__rx">RTT <?= e($sus_rg[3]) ?> · <?= e($sus_rg[4]) ?></span>
                  </button>
                <?php endforeach; ?>
              </div>
              <p class="tih-note tih-sus__rnote">India West is the default because it carries the widest service coverage of the Indian regions, which usually decides it. India North is cleaner and closer to Delhi users, so it wins wherever its services cover the workload. The choice is made per engagement; both keep data in India.</p>
            </div>

            <div class="tih-sus__grp">
              <p class="tih-k">Practices</p>
              <ul class="tih-sus__sw">
                <?php foreach ($sus_practices as $sus_p): ?>
                  <li><button class="bdh-switch" type="button" aria-pressed="true" data-p="<?= e($sus_p[0]) ?>" data-f="<?= $sus_p[5] ?>,<?= $sus_p[6] ?>,<?= $sus_p[7] ?>"><span class="bdh-switch__track" aria-hidden="true"></span><?= e($sus_p[1]) ?></button></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>

          <div class="tih-sus__fall">
            <p class="tih-k tih-sus__fk"><span>Where the carbon went · gCO₂e per request</span></p>
            <ol class="tih-sus__wf" aria-hidden="true">
              <li class="is-base"><span class="tih-sus__wl">Baseline</span><span class="tih-sus__wt"><i data-w="base" style="--l:0%;--w:<?= $sus_rat($sus_now['start']) ?>"></i></span><span class="tih-sus__wv" data-v="base"><?= $sus_g($sus_now['start']) ?></span></li>
              <?php $sus_run = $sus_now['start']; foreach ($sus_practices as $sus_p): $sus_d = $sus_now['steps'][$sus_p[0]]; $sus_run -= $sus_d; ?>
                <li data-row="<?= e($sus_p[0]) ?>"><span class="tih-sus__wl"><?= e($sus_p[1]) ?></span><span class="tih-sus__wt"><i data-w="<?= e($sus_p[0]) ?>" style="--l:<?= $sus_pct($sus_run) ?>;--w:<?= $sus_rat($sus_d) ?>"></i></span><span class="tih-sus__wv" data-v="<?= e($sus_p[0]) ?>">−<?= $sus_g($sus_d) ?></span></li>
              <?php endforeach; ?>
              <li class="is-now"><span class="tih-sus__wl">SCI now</span><span class="tih-sus__wt"><i data-w="now" style="--l:0%;--w:<?= $sus_rat($sus_now['sci']) ?>"></i></span><span class="tih-sus__wv" data-v="now"><?= $sus_g($sus_now['sci']) ?></span></li>
            </ol>
            <div class="tih-sus__res" aria-live="polite">
              <p class="tih-sus__big"><b class="tih-sus__sci"><?= $sus_g($sus_now['sci']) ?></b><span>gCO₂e per request</span></p>
              <p class="tih-sus__cut"><span class="tih-sus__cutv"><?= round($sus_cut * 100) ?>% below baseline</span> · <span class="tih-sus__k1"><?= number_format($sus_now['sci'] * 1000) ?> g per 1,000 requests</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <ul class="tih-sus__prac" data-rv-s data-rv-step="70">
      <?php foreach ($sus_practices as $sus_pi => $sus_p): ?>
        <li>
          <span class="tih-sus__pi" aria-hidden="true"><?= xt_icon($sus_p[4], ['size' => 20]) ?></span>
          <h3 class="bdh-t bdh-t--s"><?= e($sus_p[1]) ?></h3>
          <p class="bdh-d"><?= e($sus_p[2]) ?></p>
          <p class="tih-sus__lever"><?= e($sus_p[3]) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
    <p class="tih-note tih-sus__note">Typical effects are ranges from published practice, not results for any one client. Grid intensities are illustrative annual averages; live figures come from your cloud provider and grid data at the time of measurement.</p>
  </div>
</section>
