<?php /* DRAFT COPY — review before launch */
/* 08 · Page weight is the budget you set. Not a before/after switch: a ceiling the reader drags. Six rungs, from no
   ceiling at all down to 0.50 MB, and at each one the treemap re-tiles, every resource changes technique, the
   true-scale square shrinks and the transfer and emissions follow. The point is that the ceiling is a decision with
   consequences in both directions: the top rungs cost nothing but build work, the bottom ones cost features.
   The shipped HTML is the 1.00 MB rung fully drawn — the line we normally write — and the ladder beneath the panel
   prints every rung's weight and emissions, so the whole model is readable with JavaScript off.
   Every figure is modelled, not measured: Sustainable Web Design methodology at a global-average grid intensity. */

/* the six rungs of the ladder: label, ceiling in KB (0 = no ceiling), what the ceiling costs, what the build refuses */
$twa_cb_rungs = [
    ['No ceiling', 0,
     'Nothing is refused. The page weighs whatever was last added to it, and it grows every quarter.',
     'Nothing. Every request that compiles, ships.'],
    ['2.00 MB', 2048,
     'The obvious waste goes: oversized images, one undivided bundle, tags that load before first paint. No feature is lost.',
     'A 1.2 MB PNG hero. An un-split vendor bundle.'],
    ['1.50 MB', 1536,
     'Still no feature lost. The work moves into the build: modern formats, split routes and a smaller font surface.',
     'A second font family. A tag with no named owner.'],
    ['1.00 MB', 1024,
     'The line we normally write. Every feature is intact and the page is 78% lighter than where it started.',
     'Any image over 200 KB. Any route bundle over 250 KB.'],
    ['0.75 MB', 768,
     'Now it costs product decisions: the gallery opens on interaction and analytics moves to the server.',
     'A carousel that hydrates. Any third-party script in the browser.'],
    ['0.50 MB', 512,
     'A hard ceiling for a 2G tail. This route drops its client framework and its browser analytics — right where the slowest quarter of traffic is that slow, wrong where it is not.',
     'A client-side router. A web font for body text.'],
];
$twa_cb_default = 3;   // the rung the HTML ships drawn: 1.00 MB

/* key, label, short code, KB at each rung, the technique that gets there at each rung */
$twa_cb_rows = [
    ['img', 'Images', 'IMG', [2180, 1080, 800, 402, 300, 210], [
        'Full-size JPEGs at one width, every one loaded eagerly',
        'WebP at three widths, with srcset and sizes',
        'AVIF at three widths; everything below the fold is lazy',
        'AVIF with sizes tuned per breakpoint; the hero preloaded, the rest lazy',
        'One hero image; the gallery loads when a shopper opens it',
        'Hero only — the gallery becomes a link to its own page',
    ]],
    ['js', 'JavaScript', 'JS', [1120, 500, 370, 214, 170, 130], [
        'One bundle, hydrated on every route',
        'Route-level code-splitting, so a page loads its own code',
        'Island hydration; the date and internationalisation surface trimmed',
        'Streamed server rendering; only the cart and the gallery hydrate',
        'The gallery becomes CSS scroll-snap; only the cart hydrates',
        'No client framework on this route — progressive enhancement only',
    ]],
    ['third', 'Third-party', '3P', [480, 230, 156, 148, 60, 0], [
        'A tag manager loading eleven tags before first paint',
        'Every tag deferred until after load',
        'Four tags removed; the rest load on interaction',
        'Analytics and consent only, both self-hosted',
        'Analytics moves to the server; nothing measures from the browser',
        'No third-party request on this route at all',
    ]],
    ['font', 'Fonts', 'FONT', [260, 118, 92, 62, 44, 24], [
        'Four static weights across two families, served from someone else',
        'Two families, self-hosted as woff2',
        'One variable font plus a single display weight',
        'One subset variable font, woff2, with font-display: swap',
        'Subset to the Latin characters the site actually renders',
        'Headings keep the variable font; body text uses the system stack',
    ]],
    ['css', 'CSS', 'CSS', [92, 70, 62, 54, 44, 34], [
        'The whole design system, on every page',
        'Unused rules removed at build',
        'Route-level stylesheets rather than one global sheet',
        'Critical CSS inlined; the rest loaded asynchronously',
        'Component styles shipped only where the component renders',
        'Tokens and layout only; decorative rules dropped',
    ]],
    ['doc', 'Document', 'HTML', [66, 48, 44, 42, 36, 30], [
        'A client-rendered shell plus the whole data blob inline',
        'Server-rendered, with the data blob trimmed',
        'Streamed server rendering',
        'Streamed, with no render-blocking inline data',
        'Above-the-fold markup only; the rest streams in',
        'Minimal markup; the listing paginates on the server',
    ]],
];

$twa_cb_tot   = fn (int $twa_r): int => array_sum(array_map(fn ($twa_row) => $twa_row[3][$twa_r], $twa_cb_rows));
$twa_cb_mb    = fn (int $twa_kb): string => number_format($twa_kb / 1024, 2) . ' MB';
$twa_cb_base  = $twa_cb_tot(0);                     // 4198 KB
$twa_cb_now   = $twa_cb_tot($twa_cb_default);       //  922 KB
$twa_cb_least = $twa_cb_tot(count($twa_cb_rungs) - 1);
$twa_cb_cut   = (int) round((1 - $twa_cb_now / $twa_cb_base) * 100);

/* slice-and-dice treemap: row 1 = images + JavaScript, row 2 = everything else. carbon.js re-tiles with the same
   arithmetic, so the drawn map and the table can never disagree. A resource at 0 KB drops out of the map. */
$twa_cb_map = function (int $twa_r) use ($twa_cb_rows): array {
    $twa_kb  = fn ($twa_row) => $twa_row[3][$twa_r];
    $twa_top = array_values(array_filter(array_slice($twa_cb_rows, 0, 2), fn ($twa_row) => $twa_kb($twa_row) > 0));
    $twa_bot = array_values(array_filter(array_slice($twa_cb_rows, 2), fn ($twa_row) => $twa_kb($twa_row) > 0));
    $twa_st  = array_sum(array_map($twa_kb, $twa_top));
    $twa_sb  = array_sum(array_map($twa_kb, $twa_bot));
    $twa_all = $twa_st + $twa_sb;
    return [
        ['h' => round($twa_st / $twa_all * 100, 2), 'cells' => array_map(fn ($twa_row) => [$twa_row, round($twa_kb($twa_row) / $twa_st * 100, 2)], $twa_top)],
        ['h' => round($twa_sb / $twa_all * 100, 2), 'cells' => array_map(fn ($twa_row) => [$twa_row, round($twa_kb($twa_row) / $twa_sb * 100, 2)], $twa_bot)],
    ];
};
$twa_cb_scale = fn (int $twa_kb): float => round(sqrt($twa_kb / $twa_cb_base) * 100, 1);   // linear side of the true-scale square

/* per 100,000 page views. Transfer = weight × views, in decimal gigabytes (1 GB = 1,000,000 KB). Emissions apply
   0.494 kWh per GB transferred at a global-average grid intensity of 442 gCO2e per kWh — about 218 gCO2e, or
   0.21835 kg, per GB. §03's simulator uses exactly the same two numbers. Modelled, not measured. */
$twa_cb_gb  = fn (int $twa_kb): float => $twa_kb * 100000 / 1e6;
$twa_cb_kg  = fn (float $twa_g): float => $twa_g * 0.21835;
$twa_cb_g1  = fn (int $twa_kb): float => $twa_kb / 1e6 * 218.35;   // grams per single view

/* every readout the panel can show, for every rung, so the label strings live in one place */
$twa_cb_read = [
    ['Transfer per 100k views', 'gb',  fn (int $twa_kb) => number_format($twa_cb_gb($twa_kb)) . ' GB'],
    ['Estimated CO₂e per 100k views', 'kg', fn (int $twa_kb) => number_format($twa_cb_kg($twa_cb_gb($twa_kb))) . ' kg'],
    ['Estimated CO₂e per view', 'g',   fn (int $twa_kb) => number_format($twa_cb_g1($twa_kb), 2) . ' g'],
    ['Page weight', 'mb', fn (int $twa_kb) => $twa_cb_mb($twa_kb)],
];
$twa_cb_val = function (int $twa_r, int $twa_i) use ($twa_cb_read, $twa_cb_tot): string {
    return ($twa_cb_read[$twa_i][2])($twa_cb_tot($twa_r));
};
/* the whole ladder as one payload: carbon.js reads it off the rung buttons, so PHP stays the only author of numbers */
$twa_cb_rung_data = function (int $twa_r) use ($twa_cb_tot, $twa_cb_mb, $twa_cb_gb, $twa_cb_kg, $twa_cb_g1, $twa_cb_scale, $twa_cb_base, $twa_cb_rungs): array {
    $twa_t = $twa_cb_tot($twa_r);
    return [
        'kb' => $twa_t,
        'mb' => $twa_cb_mb($twa_t),
        'gb' => number_format($twa_cb_gb($twa_t)) . ' GB',
        'kg' => number_format($twa_cb_kg($twa_cb_gb($twa_t))) . ' kg',
        'g'  => number_format($twa_cb_g1($twa_t), 2) . ' g',
        's'  => $twa_cb_scale($twa_t),
        'cut' => (int) round((1 - $twa_t / $twa_cb_base) * 100),
        /* "No ceiling" is a rung, not a size, so it gets its own phrasing in the readout and for a screen reader */
        'state' => $twa_r === 0 ? 'No ceiling set' : 'Ceiling ' . $twa_cb_rungs[$twa_r][0],
        'cutl' => $twa_r === 0 ? 'the baseline' : '−' . (int) round((1 - $twa_t / $twa_cb_base) * 100) . '% on no ceiling',
        'vt' => $twa_r === 0
            ? 'No ceiling set — the page weighs ' . $twa_cb_mb($twa_t)
            : 'Ceiling ' . $twa_cb_rungs[$twa_r][0] . ' — the page weighs ' . $twa_cb_mb($twa_t),
    ];
};

$twa_cb_practice = [
    ['vision',  'Serve the smallest image that still looks right', 'AVIF or WebP, responsive srcset and sizes, explicit width and height so nothing shifts, lazy loading below the fold. Images are usually more than half the weight; they are where the saving is.'],
    ['code',    'Ship the JavaScript the page needs, and no more', 'Server rendering with streaming, route-level code-splitting and island hydration. A budget in CI fails the build when a bundle grows past its ceiling.'],
    ['doc',     'One subset variable font, or none', 'Self-hosted woff2 subset to the characters the site uses, with font-display so text is readable before the font lands. System fonts where the brand allows it.'],
    ['filter',  'Audit third parties on a schedule', 'Every tag has an owner and a review date. Anything without a measurable job is removed; the rest load after interaction, not before first paint.'],
    ['edge',    'Cache long, revalidate cheaply', 'Immutable hashed assets with long max-age, stale-while-revalidate at the edge, and a CDN close to the people using the site. Bytes not sent are the cheapest bytes.'],
    ['leaf',    'Respect the device, not just the network', 'No autoplay video on mobile, dark mode honoured on OLED screens, and motion reduced when the visitor asks for it. Less work on the device is less energy drawn from the battery.'],
];
?>
<section class="band band--alt twa-carbon" id="carbon" aria-labelledby="carbon-t">
  <div class="wrap">
    <div class="twa-head" data-rv>
      <p class="twa-head__run"><b>08 · Page weight</b><span>One product page · six ceilings · modelled</span></p>
      <div class="twa-head__t">
        <h2 class="h2" id="carbon-t"><span class="g">A page weighs what you decide</span> it is allowed to weigh.</h2>
      </div>
      <div class="twa-head__l">
        <p class="lead">Weight is the one lever that moves speed, hosting cost and emissions together, and it only holds if a number holds it. Set the ceiling below and watch what the build has to do to meet it — and, at the bottom of the ladder, what it has to refuse.</p>
        <span class="twa-ill">Illustrative model</span>
      </div>
    </div>

    <div class="twa-cb" data-rv>
      <p class="bdh-sr">A model of one product page under six page-weight ceilings. With no ceiling it weighs 4.10 megabytes: images 2,180 kilobytes, JavaScript 1,120, third-party scripts 480, fonts 260, CSS 92 and the document 66. Under a 2.00 megabyte ceiling it weighs 2.00; under 1.50 it weighs 1.49; under 1.00 megabytes it weighs 0.90, which is the line we normally write and loses no feature; under 0.75 it weighs 0.64 and the gallery moves to load on interaction; under 0.50 it weighs 0.42 and the route drops its client framework and every third-party script. Across one hundred thousand views the 4.10 megabyte page transfers 420 gigabytes and emits an estimated 92 kilograms of carbon dioxide equivalent, against 92 gigabytes and 20 kilograms at 0.90 megabytes — about 0.92 grams per view against 0.20. The figures are modelled with the Sustainable Web Design methodology, not measured. The ladder table below prints every rung.</p>

      <div class="twa-cb__panel">
        <div class="twa-cb__bar">
          <div class="twa-cb__ctl">
            <label class="twa-cb__cl" for="carbon-ceiling">Page-weight ceiling</label>
            <input class="twa-cb__range" type="range" id="carbon-ceiling" min="0" max="<?= count($twa_cb_rungs) - 1 ?>" step="1"
                   value="<?= $twa_cb_default ?>" list="carbon-rungs" data-cb-range
                   aria-describedby="carbon-ceiling-d" aria-valuetext="<?= e($twa_cb_rung_data($twa_cb_default)['vt']) ?>">
            <datalist id="carbon-rungs">
              <?php foreach ($twa_cb_rungs as $twa_ri => $twa_rg): ?><option value="<?= $twa_ri ?>" label="<?= e($twa_rg[0]) ?>"></option><?php endforeach; ?>
            </datalist>
            <p class="twa-cb__cs" aria-hidden="true"><?php foreach ($twa_cb_rungs as $twa_ri => $twa_rg): ?><span<?= $twa_ri === $twa_cb_default ? ' class="is-on"' : '' ?> data-cb-tick="<?= $twa_ri ?>"><?= e($twa_rg[0]) ?></span><?php endforeach; ?></p>
          </div>
          <p class="twa-cb__tot" aria-live="polite"><span data-cb-state><?= e($twa_cb_rung_data($twa_cb_default)['state']) ?></span><b data-cb-tot><?= e($twa_cb_mb($twa_cb_now)) ?></b><em data-cb-cut><?= e($twa_cb_rung_data($twa_cb_default)['cutl']) ?></em></p>
        </div>

        <p class="twa-cb__say" id="carbon-ceiling-d"><b data-cb-cost><?= e($twa_cb_rungs[$twa_cb_default][2]) ?></b><span><em>The build refuses:</em> <span data-cb-refuse><?= e($twa_cb_rungs[$twa_cb_default][3]) ?></span></span></p>

        <div class="twa-cb__body">
          <div class="twa-cb__map" data-cb-map aria-hidden="true">
            <?php foreach ($twa_cb_map($twa_cb_default) as $twa_ri => $twa_row): ?>
              <div class="twa-cb__row" data-cb-row="<?= $twa_ri ?>" style="--h:<?= $twa_row['h'] ?>%">
                <?php foreach ($twa_row['cells'] as $twa_ci => $twa_cell): [$twa_r, $twa_w] = $twa_cell; ?>
                  <div class="twa-cb__cell twa-cb__cell--<?= e($twa_r[0]) ?>" data-cb-cell="<?= e($twa_r[0]) ?>" style="--w:<?= $twa_w ?>%;--i:<?= $twa_ri * 2 + $twa_ci ?>">
                    <span class="twa-cb__cn"><?= e($twa_r[1]) ?></span>
                    <span class="twa-cb__cc"><?= e($twa_r[2]) ?></span>
                    <span class="twa-cb__ck"><?= number_format($twa_r[3][$twa_cb_default]) ?> KB</span>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endforeach; ?>
          </div>

          <aside class="twa-cb__scale">
            <p class="twa-cb__sk">Drawn to scale against no ceiling</p>
            <div class="twa-cb__squares" aria-hidden="true">
              <span class="twa-cb__sq twa-cb__sq--b"><i><?= e($twa_cb_mb($twa_cb_base)) ?></i></span>
              <span class="twa-cb__sq twa-cb__sq--a" style="--s:<?= $twa_cb_scale($twa_cb_now) ?>%" data-cb-sq><i data-cb-sqt><?= e($twa_cb_mb($twa_cb_now)) ?></i></span>
            </div>
            <p class="twa-cb__sd">Both squares are the same page. The smaller one is the area the ceiling leaves, so a <span data-cb-cut2><?= $twa_cb_cut ?></span>% cut in bytes shows as a square just over <span data-cb-half><?= (int) round($twa_cb_scale($twa_cb_now)) ?></span>% of the width.</p>
          </aside>
        </div>

        <table class="twa-cb__tbl">
          <caption class="bdh-sr">What each resource type weighs with no ceiling and at the selected ceiling, and the technique that gets it there</caption>
          <thead>
            <tr><th scope="col">Resource</th><th scope="col">No ceiling</th><th scope="col"><span data-cb-col><?= e($twa_cb_rungs[$twa_cb_default][0]) ?></span></th><th scope="col">What it takes</th></tr>
          </thead>
          <tbody>
            <?php foreach ($twa_cb_rows as $twa_r): ?>
              <tr data-cb-res="<?= e($twa_r[0]) ?>" data-kb="<?= e(implode(',', $twa_r[3])) ?>" data-notes="<?= e(json_encode($twa_r[4], JSON_UNESCAPED_UNICODE)) ?>">
                <th scope="row"><span class="twa-cb__sw twa-cb__cell--<?= e($twa_r[0]) ?>" aria-hidden="true"></span><?= e($twa_r[1]) ?></th>
                <td class="twa-mono"><?= number_format($twa_r[3][0]) ?> KB</td>
                <td class="twa-mono"><b data-cb-kb><?= number_format($twa_r[3][$twa_cb_default]) ?> KB</b></td>
                <td data-cb-note><?= e($twa_r[4][$twa_cb_default]) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr><th scope="row">Total</th><td class="twa-mono"><?= e($twa_cb_mb($twa_cb_base)) ?></td><td class="twa-mono"><b data-cb-tot2><?= e($twa_cb_mb($twa_cb_now)) ?></b></td><td>Every view, for as long as the page lives</td></tr>
          </tfoot>
        </table>
      </div>

      <div class="twa-cb__side">
        <dl class="twa-cb__read">
          <?php foreach ($twa_cb_read as $twa_i => $twa_rd): ?>
            <div>
              <dt><?= e($twa_rd[0]) ?></dt>
              <dd><span class="twa-cb__was"><?= e($twa_cb_val(0, $twa_i)) ?></span><span class="twa-cb__arr" aria-hidden="true">&rarr;</span><b data-cb-read="<?= e($twa_rd[1]) ?>"><?= e($twa_cb_val($twa_cb_default, $twa_i)) ?></b></dd>
            </div>
          <?php endforeach; ?>
        </dl>
        <div class="twa-cb__note">
          <p class="twa-cb__nk"><?= xt_icon('leaf', ['size' => 18]) ?>How the estimate is made</p>
          <p class="twa-cb__nd">Transfer is page weight multiplied by views, in decimal gigabytes. Emissions follow the Sustainable Web Design methodology with two stated inputs: <b>0.494 kWh per gigabyte transferred</b> and <b>442 gCO₂e per kilowatt-hour</b>, a global-average grid — about 218 gCO₂e per gigabyte. The simulator in §03 uses the same two numbers, so the two sections agree. The result is a direction of travel rather than a measurement: a page served from a low-carbon region to a cached visitor emits far less than this, and a cold load on an old device emits more. We report the model and its inputs with every estimate, and we track the metric we can actually control — bytes.</p>
          <p class="twa-cb__nf"><b>SCI = ((E &times; I) + M) per R</b><span>Energy multiplied by grid intensity, plus embodied carbon, divided by the unit of work. The Green Software Foundation&rsquo;s Software Carbon Intensity specification, ISO/IEC 21031:2024.</span></p>
          <ul class="xt-badges" role="list">
            <?= xt_badge('sci', ['tag' => 'li', 'detail' => true]) ?>
            <?= xt_badge('cwv', ['tag' => 'li', 'detail' => true]) ?>
          </ul>
          <p class="twa-cb__nx">We align delivery with these frameworks; W3C Web Sustainability Guidelines inform the practice list.</p>
        </div>
      </div>

      <!-- the ladder: every rung printed, so the model is complete without JavaScript, and the data carbon.js reads -->
      <div class="twa-cb__ladder">
        <p class="twa-cb__lk">The whole ladder · six ceilings, one page</p>
        <ol class="twa-cb__rungs" role="list">
          <?php foreach ($twa_cb_rungs as $twa_ri => $twa_rg): $twa_d = $twa_cb_rung_data($twa_ri); ?>
            <li class="twa-cb__rung<?= $twa_ri === $twa_cb_default ? ' is-on' : '' ?>" data-cb-rung="<?= $twa_ri ?>"
                data-mb="<?= e($twa_d['mb']) ?>" data-gb="<?= e($twa_d['gb']) ?>" data-kg="<?= e($twa_d['kg']) ?>"
                data-g="<?= e($twa_d['g']) ?>" data-s="<?= $twa_d['s'] ?>" data-cut="<?= $twa_d['cut'] ?>"
                data-label="<?= e($twa_rg[0]) ?>" data-state="<?= e($twa_d['state']) ?>" data-cutl="<?= e($twa_d['cutl']) ?>" data-vt="<?= e($twa_d['vt']) ?>" data-cost="<?= e($twa_rg[2]) ?>" data-refuse="<?= e($twa_rg[3]) ?>">
              <span class="twa-cb__rl"><?= e($twa_rg[0]) ?></span>
              <span class="twa-cb__rw"><?= e($twa_d['mb']) ?></span>
              <span class="twa-cb__rg"><?= e($twa_d['g']) ?> per view</span>
              <span class="twa-cb__rc"><?= e($twa_rg[3]) ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <ul class="twa-cb__pr" role="list" data-bdh-stagger>
        <?php foreach ($twa_cb_practice as $twa_p): ?>
          <li class="twa-cb__p">
            <span class="twa-cb__pi"><?= xt_icon($twa_p[0], ['size' => 20]) ?></span>
            <h3 class="twa-cb__pt"><?= e($twa_p[1]) ?></h3>
            <p class="twa-cb__pd"><?= e($twa_p[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>

      <p class="twa-cb__budget"><?= xt_icon('gauge', ['size' => 18]) ?><span><b>The ceiling is only real if the build enforces it.</b> Image, script and font limits live in the repository and run on every pull request — §06 shows the gate that reads them. A change that pushes the page past its ceiling fails the build, so the weight cannot drift back over a year of small additions.</span></p>
    </div>
  </div>
</section>
