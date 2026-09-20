<?php /* DRAFT COPY — review before launch */
/* Hero — three columns. The brief; the attack-surface radar (four zones around your platform, assets
   plotted as blips, a sweep that brightens each blip as it passes); the findings feed (severity chips,
   one flips to Contained). Below 640px the dial keeps its blips but the label chips come off it — they
   collide at that size — and the same seven assets read as a two-column key under the dial.
   The HTML is the finished state; hero.js rotates findings in while on screen. */
$tsch_c = 280;   // radar centre in a 560 × 560 viewBox
$tsch_pt = function (float $deg, float $r) use ($tsch_c): array {
    $a = deg2rad($deg);
    return [round($tsch_c + $r * sin($a), 1), round($tsch_c - $r * cos($a), 1)];
};
$tsch_zones = [   // [label, outer radius, css modifier]
    ['Perimeter',   250, 'per'],
    ['Application', 190, 'app'],
    ['Data',        132, 'data'],
    ['AI & agents',  78, 'ai'],
];
$tsch_blips = [   // [key, label, angle° clockwise from 12 o'clock, radius, severity, label side, contained]
    ['admin',  'Admin panel',     36, 222, 'high', 'r', false],
    ['sso',    'Login & SSO',    298, 218, 'med',  'r', false],
    ['api',    'Public API',     112, 162, 'high', 'r', false],
    ['ci',     'CI pipeline',    232, 160, 'med',  'r', false],
    ['bucket', 'Storage bucket', 158, 104, 'crit', 'r', true],
    ['vector', 'Vector store',   262, 104, 'high', 'l', false],
    ['agent',  'Support agent',   62,  56, 'crit', 'r', true],
];
$tsch_sev = ['crit' => 'Critical', 'high' => 'High', 'med' => 'Medium', 'low' => 'Low'];
/* Which zone a plotted radius falls in — used by the narrow-screen key, where the labels come off the dial. */
$tsch_zone = function (float $r) use ($tsch_zones): string {
    for ($i = count($tsch_zones) - 1; $i >= 0; $i--) { if ($r <= $tsch_zones[$i][1]) return $tsch_zones[$i][0]; }
    return $tsch_zones[0][0];
};
$tsch_feed = [   // [severity, finding, asset key, asset, zone, time, contained]
    ['crit', 'Agent tried a refund outside its scope',  'agent',  'Support agent',  'AI zone',     '09:42', true],
    ['high', 'API returns other users’ orders (BOLA)',  'api',    'Public API',     'Application', '09:39', false],
    ['crit', 'Public read on a storage bucket',         'bucket', 'Storage bucket', 'Data zone',   '09:31', true],
    ['med',  'Long-lived deploy key in CI',             'ci',     'CI pipeline',    'Application', '09:24', false],
    ['high', 'Vector search ignored the tenant filter', 'vector', 'Vector store',   'Data zone',   '09:12', false],
];
$tsch_open = count(array_filter($tsch_feed, fn ($tsch_f) => !$tsch_f[6]));
$tsch_badges = ['iso27001', 'soc2', 'owasp-llm', 'iso42001', 'dpdp', 'cert-in'];

/* sweep wedges trailing the leading edge (0°), drawn once in PHP */
$tsch_w = [[0, -10, 'a'], [-10, -24, 'b'], [-24, -46, 'c']];
?>
<section class="band tsc-hero" id="hero" aria-labelledby="hero-t">
  <span class="tsc-hero__bg dots" aria-hidden="true"></span>

  <div class="wrap">
    <div class="tsc-hero__top">
      <nav class="tsc-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= xe_url('services/') ?>">Services</a></li>
          <li><a href="<?= xe_url('services/technology-intelligence.php') ?>"><?= e($TECH['name'] ?? 'Technology & Intelligence') ?></a></li>
          <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
        </ol>
      </nav>
      <p class="tsc-hero__stamp" aria-hidden="true"><span class="tsc-led tsc-led--ping"></span>Threat model <i>·</i> reviewed every release</p>
    </div>

    <div class="tsc-hero__in">
      <div class="tsc-hero__text">
        <p class="tsc-ref"><b>Capability <?= e($CAP['n']) ?> of <?= count($TI) ?></b><span>Secure, governed, compliant</span></p>
        <h1 class="tsc-hero__h" id="hero-t"><span class="g">Secure the product, the data and the AI,</span> and prove it to auditors.</h1>
        <p class="lead tsc-hero__lead"><?= e($CAP['lead']) ?></p>
        <div class="tsc-hero__act">
          <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>">Request a security review <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--out btn--lg" href="#range">Attack the demo assistant <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>

      <div class="tsc-hero__vis">
        <p class="bdh-sr">Illustrative attack-surface radar. Four zones surround your platform: perimeter, application, data, and AI and agents. Seven assets are plotted as findings, including an admin panel, a public API, a storage bucket, a vector store and a support agent. Beside it, a findings feed lists detections by severity, critical, high or medium, and marks two of them contained.</p>

        <figure class="tsc-radar" aria-hidden="true">
          <svg class="tsc-radar__svg" viewBox="0 0 560 560" fill="none">
            <circle class="tsc-radar__bezel" cx="280" cy="280" r="272"/>
            <g class="tsc-radar__ticks">
              <?php for ($tsch_d = 0; $tsch_d < 360; $tsch_d += 5):
                  $tsch_long = $tsch_d % 30 === 0;
                  [$tsch_x1, $tsch_y1] = $tsch_pt($tsch_d, $tsch_long ? 258 : 264);
                  [$tsch_x2, $tsch_y2] = $tsch_pt($tsch_d, 272); ?>
                <line<?= $tsch_long ? ' class="is-long"' : '' ?> x1="<?= $tsch_x1 ?>" y1="<?= $tsch_y1 ?>" x2="<?= $tsch_x2 ?>" y2="<?= $tsch_y2 ?>"/>
              <?php endfor; ?>
            </g>
            <?php foreach ($tsch_zones as $tsch_z): ?>
              <circle class="tsc-radar__z tsc-radar__z--<?= $tsch_z[2] ?>" cx="280" cy="280" r="<?= $tsch_z[1] ?>"/>
            <?php endforeach; ?>
            <g class="tsc-radar__cross">
              <line x1="18" y1="280" x2="542" y2="280"/><line x1="280" y1="18" x2="280" y2="542"/>
              <line class="is-diag" x1="95" y1="95" x2="465" y2="465"/><line class="is-diag" x1="465" y1="95" x2="95" y2="465"/>
            </g>
            <g class="tsc-radar__sweep">
              <?php foreach ($tsch_w as $tsch_ww):
                  [$tsch_ax, $tsch_ay] = $tsch_pt($tsch_ww[0], 250);
                  [$tsch_bx, $tsch_by] = $tsch_pt($tsch_ww[1], 250); ?>
                <path class="tsc-radar__wedge tsc-radar__wedge--<?= $tsch_ww[2] ?>" d="M280 280L<?= $tsch_ax ?> <?= $tsch_ay ?>A250 250 0 0 0 <?= $tsch_bx ?> <?= $tsch_by ?>Z"/>
              <?php endforeach; ?>
              <line class="tsc-radar__edge" x1="280" y1="280" x2="280" y2="30"/>
            </g>
            <circle class="tsc-radar__core" cx="280" cy="280" r="34"/>
            <path class="tsc-radar__shield" d="M280 262l13 5v9c0 8.5-5.6 14.4-13 17-7.4-2.6-13-8.5-13-17v-9z"/>
            <path class="tsc-radar__shtick" d="M274.5 279.5l4 4 7-8"/>
          </svg>

          <?php foreach ($tsch_zones as $tsch_z): ?>
            <span class="tsc-radar__zl" style="top:<?= round(($tsch_c - $tsch_z[1] + 13) / 5.6, 2) ?>%"><?= e($tsch_z[0]) ?></span>
          <?php endforeach; ?>
          <span class="tsc-radar__zl tsc-radar__zl--core" style="top:<?= round(($tsch_c + 56) / 5.6, 2) ?>%">Your platform</span>

          <?php foreach ($tsch_blips as $tsch_b): [$tsch_x, $tsch_y] = $tsch_pt($tsch_b[2], $tsch_b[3]); ?>
            <span class="tsc-blip tsc-blip--<?= $tsch_b[4] ?><?= $tsch_b[5] === 'l' ? ' tsc-blip--l' : '' ?><?= $tsch_b[6] ? ' is-contained' : '' ?>" data-asset="<?= e($tsch_b[0]) ?>" style="left:<?= round($tsch_x / 5.6, 2) ?>%;top:<?= round($tsch_y / 5.6, 2) ?>%;--a:<?= $tsch_b[2] ?>"><i></i><b><?= e($tsch_b[1]) ?></b></span>
          <?php endforeach; ?>

          <figcaption class="tsc-radar__read"><span>Sweep</span><span><?= count($tsch_blips) ?> assets</span><span>4 zones</span><span data-radar-last>Last pass 09:42</span></figcaption>
        </figure>

        <!-- Narrow screens: the dial keeps the blips but the label chips come off it and read here instead. -->
        <ul class="tsc-radar__key" role="list" aria-hidden="true">
          <?php foreach ($tsch_blips as $tsch_b): ?>
            <li class="tsc-key tsc-key--<?= $tsch_b[4] ?><?= $tsch_b[6] ? ' is-contained' : '' ?>"><i></i><b><?= e($tsch_b[1]) ?></b><span><?= e($tsch_zone((float) $tsch_b[3])) ?><?= $tsch_b[6] ? ' · contained' : '' ?></span></li>
          <?php endforeach; ?>
        </ul>

        <div class="tsc-feed" aria-hidden="true">
          <div class="tsc-feed__bar">
            <span class="tsc-led tsc-led--ping"></span><span class="tsc-feed__name">Findings</span>
            <span class="tsc-feed__live">Live</span>
          </div>
          <div class="tsc-feed__sum">
            <p><b data-feed-open><?= $tsch_open ?></b><span>Open</span></p>
            <p><b data-feed-cont><?= count($tsch_feed) - $tsch_open ?></b><span>Contained</span></p>
            <p><b>4 min</b><span>MTTD</span></p>
          </div>
          <div class="tsc-feed__win">
            <ol class="tsc-feed__list" data-feed>
              <?php foreach ($tsch_feed as $tsch_f): ?>
                <li class="tsc-feed__row<?= $tsch_f[6] ? ' is-contained' : '' ?>" data-asset="<?= e($tsch_f[2]) ?>" data-sev="<?= $tsch_f[0] ?>">
                  <span class="tsc-flip"><span class="tsc-flip__f tsc-sev tsc-sev--<?= $tsch_f[0] ?>"><?= e($tsch_sev[$tsch_f[0]]) ?></span><span class="tsc-flip__b tsc-sev tsc-sev--ok">Contained</span></span>
                  <time class="tsc-feed__time"><?= e($tsch_f[5]) ?></time>
                  <span class="tsc-feed__t"><?= e($tsch_f[1]) ?></span>
                  <span class="tsc-feed__m"><?= e($tsch_f[3]) ?> <i>·</i> <?= e($tsch_f[4]) ?></span>
                </li>
              <?php endforeach; ?>
            </ol>
          </div>
          <p class="tsc-feed__foot"><span class="tsc-ill">Illustrative</span><span>Triage by AI · confirmed by an analyst</span></p>
        </div>
      </div>
    </div>

    <div class="tsc-hero__base">
      <!-- PLACEHOLDER: confirm typical start timeframe before launch -->
      <dl class="tsc-hero__meta">
        <?php foreach ($CAP['meta'] as $tsch_i => $tsch_m): ?>
          <div><dt><?= e($CAP['meta_k'][$tsch_i] ?? '') ?></dt><dd><?= e($tsch_m) ?></dd></div>
        <?php endforeach; ?>
      </dl>
      <div class="tsc-hero__fw">
        <p class="tsc-hero__fwk">Frameworks we align delivery with</p>
        <ul class="tsc-hero__badges" role="list">
          <?php foreach ($tsch_badges as $tsch_k): ?><?= xt_badge($tsch_k, ['variant' => 'chip', 'tag' => 'li']) ?><?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>
