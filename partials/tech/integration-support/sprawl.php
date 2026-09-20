<?php /* DRAFT COPY — review before launch */
/* Sprawl — the problem, drawn as a switchboard nobody designed. Thirty tools in a 6 × 5 board with
   the manual copy-paste hand-offs between them; a toggle (and scroll, until touched) swaps the
   tangle for one line that calls at every system, and retires the spreadsheets that only existed
   to carry data by hand. Beside it: a photograph and three figures that change with the state.
   HTML = the connected state. sprawl.js starts in "Today" and switches on scroll. */
$tis_sp_tiles = [   // [label, icon, retired when connected]
    ['Storefront', 'browser', false], ['Payments', 'cost', false], ['ERP', 'database', false], ['CRM', 'users', false], ['Email', 'chat', false], ['Helpdesk', 'headset', false],
    ['Warehouse', 'layers', false], ['Orders.xlsx', 'doc', true], ['Accounting', 'chart', false], ['Marketing', 'target', false], ['Leads.csv', 'doc', true], ['Team chat', 'chat', false],
    ['Shipping', 'globe', false], ['Loyalty', 'flag', false], ['POS till', 'mobile', false], ['Stock sheet', 'doc', true], ['Payroll', 'users', false], ['HR', 'handshake', false],
    ['Forms', 'clipboard-check', false], ['Analytics', 'dashboard', false], ['Quotes.doc', 'doc', true], ['Contracts', 'lock', false], ['BI export', 'chart', true], ['Surveys', 'search', false],
    ['Calendar', 'calendar', false], ['Docs', 'doc', false], ['Returns', 'rollback', false], ['Suppliers', 'link', false], ['Pricing', 'cost', false], ['Survey app', 'search', true],
];
$tis_sp_copies = [[0, 7], [7, 2], [3, 10], [10, 9], [6, 15], [15, 0], [5, 3], [1, 8], [20, 2], [19, 22], [22, 4], [26, 1], [18, 3], [27, 2], [29, 9]];   // manual hand-offs [from, to]
$tis_sp_c = function (int $n): array { return [($n % 6) * 100 + 78, intdiv($n, 6) * 100 + 24]; };   // top-right corner of a card, where it is empty
$tis_sp_arc = function (int $a, int $b, int $i) use ($tis_sp_c): string {   // a hand-off arc that always bows upwards
    [$x1, $y1] = $tis_sp_c($a); [$x2, $y2] = $tis_sp_c($b);
    $dx = $x2 - $x1; $dy = $y2 - $y1; $len = max(1, sqrt($dx * $dx + $dy * $dy));
    $k = 0.22 + ($i % 3) * 0.05;
    $nx = -$dy / $len; $ny = $dx / $len;
    if ($ny > 0) { $nx = -$nx; $ny = -$ny; }
    $cx = ($x1 + $x2) / 2 + $nx * $len * $k; $cy = ($y1 + $y2) / 2 + $ny * $len * $k - 12;
    return sprintf('M %d %d Q %.1f %.1f %d %d', $x1, $y1, $cx, $cy, $x2, $y2);
};
$tis_sp_figs = [   // [today, connected, unit, label]
    ['46', '4', 'h', 'Re-keying per week across a 12-person operations team'],
    ['7.1', '0.2', '%', 'Customer records that disagree between CRM and ERP'],
    ['9', '0', '', 'Nightly CSV jobs that failed last quarter without an alert'],
];
$tis_sp_retired = count(array_filter($tis_sp_tiles, fn ($tis_sp_t) => $tis_sp_t[2]));
?>
<section class="band band--alt tis-sprawl" id="sprawl" aria-labelledby="sprawl-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tis-kick"><b>$ estate audit --hand-offs</b> <span>30 tools · <?= count($tis_sp_copies) ?> manual hand-offs</span></p>
        <h2 class="h2" id="sprawl-t"><span class="g">Thirty tools,</span> and people copying between them.</h2>
      </div>
      <div>
        <p class="lead">Most estates grow one sensible tool at a time. Together they leave people re-keying orders into the ERP, reconciling two customer lists by hand and trusting nightly CSV exports that fail without telling anyone.</p>
        <div class="bdh-seg tis-sprawl__seg" role="group" aria-label="Show the estate">
          <button type="button" data-sp-state="today" aria-pressed="false">Today · copy and paste</button>
          <button type="button" data-sp-state="connected" aria-pressed="true">Connected · one layer</button>
        </div>
      </div>
    </div>

    <div class="tis-sprawl__grid" data-sp="connected">
      <div class="tis-sprawl__boardwrap" data-rv>
        <div class="tis-sprawl__bar" aria-hidden="true">
          <span class="tis-sprawl__mode"><i class="tis-led" aria-hidden="true"></i><b data-sp-mode>One integration layer</b></span>
          <span class="tis-sprawl__count" data-sp-count><?= 30 - $tis_sp_retired ?> systems on one line · <?= $tis_sp_retired ?> retired</span>
        </div>
        <div class="tis-sprawl__board" aria-hidden="true">
          <svg class="tis-sprawl__svg" viewBox="0 0 600 500" preserveAspectRatio="none" focusable="false">
            <defs><marker id="sprawl-arrow" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="7" markerHeight="7" orient="auto-start-reverse"><path d="M 1 1 L 9 5 L 1 9" class="tis-sprawl__head"/></marker></defs>
            <g class="tis-sprawl__copies">
              <?php foreach ($tis_sp_copies as $tis_sp_i => $tis_sp_p): [$tis_sp_x1, $tis_sp_y1] = $tis_sp_c($tis_sp_p[0]); ?>
                <path d="<?= $tis_sp_arc($tis_sp_p[0], $tis_sp_p[1], $tis_sp_i) ?>" style="--d:<?= ($tis_sp_i * 37) % 11 ?>" marker-end="url(#sprawl-arrow)"/>
                <circle cx="<?= $tis_sp_x1 ?>" cy="<?= $tis_sp_y1 ?>" r="3" style="--d:<?= ($tis_sp_i * 37) % 11 ?>"/>
              <?php endforeach; ?>
            </g>
            <path class="tis-sprawl__bus" pathLength="1"
              d="M 50 87 H 550 C 592 87 592 187 550 187 H 50 C 8 187 8 287 50 287 H 550 C 592 287 592 387 550 387 H 50 C 8 387 8 487 50 487 H 550"/>
          </svg>
          <ol class="tis-sprawl__tiles">
            <?php foreach ($tis_sp_tiles as $tis_sp_i => $tis_sp_t): ?>
              <li class="tis-sprawl__tile<?= $tis_sp_t[2] ? ' is-ret' : '' ?>" style="--i:<?= $tis_sp_i ?>">
                <span class="tis-sprawl__card"><?= xt_icon($tis_sp_t[1], ['size' => 18, 'mono' => true]) ?><span class="tis-sprawl__lbl"><?= e($tis_sp_t[0]) ?></span><?php if ($tis_sp_t[2]): ?><em class="tis-sprawl__tag">retired</em><?php endif; ?></span>
                <i class="tis-sprawl__stop"></i>
              </li>
            <?php endforeach; ?>
          </ol>
        </div>
        <p class="tis-sprawl__legend" aria-hidden="true"><span class="tis-sprawl__lg tis-sprawl__lg--copy">Manual copy and paste</span><span class="tis-sprawl__lg tis-sprawl__lg--bus">Integration line</span><span class="tis-sprawl__lg tis-sprawl__lg--ret">Spreadsheet or duplicate tool, retired once connected</span></p>
        <p class="bdh-sr">A board of thirty business tools. Today, fifteen manual copy-and-paste hand-offs cross between them, through spreadsheets such as Orders.xlsx, Leads.csv and a stock sheet. Connected, one integration line calls at every system and the six spreadsheets and duplicate tools are retired.</p>
      </div>

      <div class="tis-sprawl__side">
        <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
        <figure class="bdh-img bdh-img--r43 tis-sprawl__img" data-rv>
          <img src="<?= xe_url('assets/imgs/tech/integration-support/sprawl-desk.jpg') ?>" alt="A desk at night: a monitor showing code, a tablet with a handwritten to-do list, sticky notes and a calculator" width="1800" height="1051" loading="lazy" decoding="async" style="object-position:55% 50%">
          <figcaption class="tis-sprawl__cap"><span class="bdh-cap-chip"><b>One order, by hand</b>4 systems · 11 fields · about 6 minutes</span></figcaption>
        </figure>

        <dl class="tis-sprawl__figs" data-rv data-rv-d="80">
          <?php foreach ($tis_sp_figs as $tis_sp_f): ?>
            <div class="tis-sprawl__fig">
              <dt><?= e($tis_sp_f[3]) ?></dt>
              <dd><span class="tis-sprawl__v"><b data-a="<?= e($tis_sp_f[0]) ?>" data-b="<?= e($tis_sp_f[1]) ?>"><?= e($tis_sp_f[1]) ?></b><?php if ($tis_sp_f[2] !== ''): ?><i><?= e($tis_sp_f[2]) ?></i><?php endif; ?></span><s class="tis-sprawl__was"><span class="bdh-sr">down from </span><?= e($tis_sp_f[0] . ($tis_sp_f[2] === '%' ? '%' : ($tis_sp_f[2] ? ' ' . $tis_sp_f[2] : ''))) ?></s></dd>
            </div>
          <?php endforeach; ?>
        </dl>
        <p class="tis-sprawl__note"><span class="tis-ill">Illustrative</span> Figures for a typical mid-size retailer. The integration map in week two measures yours.</p>
      </div>
    </div>
  </div>
</section>
