<?php /* DRAFT COPY — review before launch */
/* Hero — "The Switchboard". Behind the whole hero, a low-contrast transit map of a typical estate:
   stations are systems, lines are flows (ink = orders, blue = customers, grey = data), and event
   dots run along them. In front: the brief on a paper panel (left) and an on-call status card
   (right) with 90-day uptime per integration. hero.js runs the event dots while on screen and
   fills the uptime bars once. The HTML is the finished, readable state. */
$tis_h_lines = [   // [key, class, path d, label, label x, label y] — 45° transit geometry in a 1440 × 1220 field.
    // The interchange sits at 884,1080: in the gutter between the brief and the status card at 1440 wide,
    // so the lines stay visible around the foreground instead of hiding behind it.
    ['orders',   'ink',  'M -40 1080 H 884 V 330 L 964 250 H 1480', 'Orders line',   96,  1062],
    ['customer', 'blue', 'M 884 1080 H 1480',                         'Customer line', 1236, 1112],
    ['data',     'grey', 'M -40 1170 H 794 L 884 1080',               'Data line',     96,  1152],
];
$tis_h_stations = [   // [label, x, y, mark: ['logo', slug] | ['icon', name], label side l|r|t|b|br, hub?]
    ['Storefront',        236,  1080, ['logo', 'shopify'],   'b',  false],
    ['Payments',          486,  1080, ['logo', 'razorpay'],  'b',  false],
    ['Integration layer', 884,  1080, ['icon', 'plug'],      'l',  true],
    ['ERP',               1076, 250,  ['logo', 'sap'],       'b',  false],
    ['Warehouse',         1250, 250,  ['icon', 'layers'],    'b',  false],
    ['CRM',               1030, 1080, ['logo', 'hubspot'],   't',  false],
    ['Support desk',      1170, 1080, ['logo', 'zendesk'],   't',  false],
    ['Email',             1314, 1080, ['icon', 'chat'],      't',  false],
    ['Data warehouse',    262,  1170, ['logo', 'snowflake'], 'b',  false],
    ['Analytics',         512,  1170, ['icon', 'chart'],     'b',  false],
];
$tis_h_status = [   // [integration, uptime %, degraded day indexes (0 = 90 days ago)]
    ['Storefront → ERP orders',   '99.98', [61]],
    ['Payments webhooks',         '100.00', []],
    ['CRM ⇄ Support desk',        '99.95', [23, 24]],
    ['Warehouse stock sync',      '99.99', [48]],
    ['CDC → Data warehouse',      '99.97', [77]],
];
?>
<section class="band tis-hero" id="top" aria-labelledby="hero-t">
  <div class="tis-hero__map" aria-hidden="true">
    <svg class="tis-map" viewBox="0 0 1440 1220" preserveAspectRatio="xMidYMax slice" focusable="false">
      <?php /* the 60px grid as one path rather than 23 <line> elements */
        $tis_h_grid = '';
        for ($tis_h_g = 60; $tis_h_g < 1440; $tis_h_g += 60) { $tis_h_grid .= 'M' . $tis_h_g . ' 0V1220'; } ?>
      <path class="tis-map__grid" d="<?= $tis_h_grid ?>"/>
      <g class="tis-map__lines">
        <?php foreach ($tis_h_lines as $tis_h_l): ?>
          <path class="tis-map__ln tis-map__ln--<?= e($tis_h_l[1]) ?>" data-line="<?= e($tis_h_l[0]) ?>" d="<?= e($tis_h_l[2]) ?>"/>
          <text class="tis-map__lname" x="<?= (int) $tis_h_l[4] ?>" y="<?= (int) $tis_h_l[5] ?>"><?= e($tis_h_l[3]) ?></text>
        <?php endforeach; ?>
      </g>
      <g class="tis-map__dots"></g>
      <g class="tis-map__stations">
        <?php foreach ($tis_h_stations as $tis_h_s):
            [$tis_h_n, $tis_h_x, $tis_h_y, $tis_h_m, $tis_h_side, $tis_h_hub] = $tis_h_s;
            $tis_h_mark = $tis_h_m[0] === 'logo' ? xt_logo($tis_h_m[1], ['size' => 14, 'hidden' => true]) : xt_icon($tis_h_m[1], ['size' => 14, 'mono' => true]);
            $tis_h_w = 26 + (int) round(mb_strlen($tis_h_n) * 7.6);   // label chip width at 12px mono
            switch ($tis_h_side) {
                case 'l': $tis_h_lx = -$tis_h_w - 30; $tis_h_ly = -40; break;
                case 't': $tis_h_lx = -$tis_h_w / 2;  $tis_h_ly = -46; break;
                case 'b': $tis_h_lx = -$tis_h_w / 2;  $tis_h_ly = 20;  break;
                case 'br': $tis_h_lx = 26;            $tis_h_ly = 14;  break;
                default:  $tis_h_lx = 22;             $tis_h_ly = -12;
            } ?>
          <g class="tis-map__stn<?= $tis_h_hub ? ' is-hub' : '' ?>" data-x="<?= $tis_h_x ?>" data-y="<?= $tis_h_y ?>" transform="translate(<?= $tis_h_x ?> <?= $tis_h_y ?>)">
            <circle class="tis-map__ring" r="<?= $tis_h_hub ? 22 : 15 ?>"/>
            <circle class="tis-map__dot" r="<?= $tis_h_hub ? 12 : 8 ?>"/>
            <?php if ($tis_h_hub): ?><circle class="tis-map__core" r="4"/><?php endif; ?>
            <g class="tis-map__lbl" transform="translate(<?= $tis_h_lx ?> <?= $tis_h_ly ?>)">
              <rect width="<?= $tis_h_w ?>" height="24" rx="6"/>
              <g transform="translate(7 5)" class="tis-map__mk"><?= $tis_h_mark ?></g>
              <text x="26" y="16"><?= e($tis_h_n) ?></text>
            </g>
          </g>
        <?php endforeach; ?>
      </g>
    </svg>
  </div>

  <div class="wrap tis-hero__in">
    <div class="tis-hero__panel">
      <nav class="tis-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= xe_url('services/') ?>">Services</a></li>
          <li><a href="<?= xe_url('services/technology-intelligence.php') ?>"><?= e($TECH['name']) ?></a></li>
          <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
        </ol>
      </nav>

      <p class="tis-hero__eb"><span class="tis-stn tis-stn--blue" aria-hidden="true"></span>Capability <?= e($CAP['n']) ?> of <?= count($TI) ?> · One system, supported</p>
      <h1 class="tis-hero__h" id="hero-t"><span class="g">Your tools, connected into one system,</span> and engineers on call after launch.</h1>
      <p class="lead tis-hero__lead"><?= e($CAP['lead']) ?></p>

      <div class="tis-hero__act">
        <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>">Map my integrations <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#mapper">Try the field mapper <span class="i" aria-hidden="true">›</span></a>
      </div>

      <!-- PLACEHOLDER: confirm typical phase length and support terms before launch -->
      <dl class="tis-hero__meta">
        <?php foreach ($CAP['meta'] as $tis_h_i => $tis_h_m): ?>
          <div><dt><?= e($CAP['meta_k'][$tis_h_i] ?? '') ?></dt><dd><?= e($tis_h_m) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>

    <aside class="tis-status" aria-labelledby="hero-status-t">
      <div class="tis-status__top">
        <p class="tis-status__k"><span class="tis-led tis-led--pulse" aria-hidden="true"></span><span>Status · Your platform</span></p>
        <span class="tis-ill">Illustrative</span>
      </div>
      <p class="tis-status__h" id="hero-status-t">All integrations operational</p>
      <p class="tis-status__sub"><span data-hero-ago>Checked 12 s ago</span> · 90-day uptime</p>

      <ul class="tis-status__rows">
        <?php foreach ($tis_h_status as $tis_h_i => $tis_h_r): ?>
          <li class="tis-status__row">
            <p class="tis-status__name"><span><?= e($tis_h_r[0]) ?></span><b><?= e($tis_h_r[1]) ?>%</b></p>
            <?php /* 90 days as two paths rather than 90 <rect>s: same picture, 88 fewer nodes per row. */
              $tis_h_ok = $tis_h_deg = '';
              for ($tis_h_d = 0; $tis_h_d < 90; $tis_h_d++) {
                  $tis_h_seg = 'M' . ($tis_h_d * 4.4) . ' 0h3v18h-3z';
                  if (in_array($tis_h_d, $tis_h_r[2], true)) { $tis_h_deg .= $tis_h_seg; } else { $tis_h_ok .= $tis_h_seg; }
              } ?>
            <svg class="tis-status__bars" viewBox="0 0 396 18" preserveAspectRatio="none" aria-hidden="true" focusable="false" style="--i:<?= $tis_h_i ?>">
              <path class="is-ok" d="<?= $tis_h_ok ?>"/><?php if ($tis_h_deg !== ''): ?><path class="is-deg" d="<?= $tis_h_deg ?>"/><?php endif; ?>
            </svg>
          </li>
        <?php endforeach; ?>
      </ul>
      <p class="tis-status__axis" aria-hidden="true"><span>90 days ago</span><span>Today</span></p>

      <dl class="tis-status__kpis">
        <div><dt>Events · 24 h</dt><dd data-hero-events>1,284,392</dd></div>
        <div><dt>p95 latency</dt><dd>410 ms</dd></div>
        <div><dt>DLQ depth</dt><dd>0</dd></div>
      </dl>

      <p class="tis-status__inc"><?= xt_icon('check', ['size' => 16]) ?><span><b>Last incident · 12 Aug</b> ERP sync delayed by an expired token. Acknowledged in 4 min, recovered in 38 min, no orders lost.</span></p>
    </aside>
  </div>
  <p class="bdh-sr">Behind the heading, a transit-style map of a typical system estate: a storefront, payments, ERP, warehouse, CRM, support desk, email, analytics and a data warehouse, joined through one integration layer by an orders line, a customer line and a data line, with events moving along each line.</p>
</section>
