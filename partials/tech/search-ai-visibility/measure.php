<?php /* DRAFT COPY — review before launch */
/* Measure (alt) — 08 · one dashboard for rankings and citations.
   A single window holds what the programme actually reports: the Search Console trend, four
   headline figures, share of answer by engine, and the feed table that says where every number
   came from and how often it refreshes.
   The point of the section is the discipline, not the chart: measured figures come from your own
   properties, sampled figures come from repeated prompt runs, and the two never share a column.
   The "Highlight sampled" control ringes every sampled panel at once so a reader can see how much
   of a visibility report is an estimate. All figures are illustrative.
   The chart geometry is computed from the same arrays that print the numbers, so the line and the
   readout cannot drift apart. */

/* [week ending, clicks, impressions] — 26 weeks, illustrative */
$tsv_ms_weeks = [
    ['22 Mar', 1840,  96200], ['29 Mar', 1790,  94800], ['05 Apr', 1920,  99500],
    ['12 Apr', 2015, 103100], ['19 Apr', 1980, 101400], ['26 Apr', 2140, 108600],
    ['03 May', 2260, 113200], ['10 May', 2190, 110900], ['17 May', 2380, 118400],
    ['24 May', 2470, 122700], ['31 May', 2410, 120300], ['07 Jun', 2620, 128900],
    ['14 Jun', 2755, 134500], ['21 Jun', 2690, 131800], ['28 Jun', 2880, 140200],
    ['05 Jul', 3020, 146900], ['12 Jul', 3150, 152300], ['19 Jul', 3090, 149100],
    ['26 Jul', 3310, 158600], ['02 Aug', 3440, 164200], ['09 Aug', 3620, 172800],
    ['16 Aug', 3580, 170100], ['23 Aug', 3860, 182400], ['30 Aug', 4070, 192600],
    ['06 Sep', 4290, 203500], ['13 Sep', 4610, 214300],
];

$tsv_ms_max_c = 4800;      // click axis ceiling: ticks 0 / 1,200 / 2,400 / 3,600 / 4,800
$tsv_ms_max_i = 240000;    // impression axis ceiling: ticks 0 / 60k / 120k / 180k / 240k

$tsv_ms_x = static function (int $tsv_msi): float { return round(4 + $tsv_msi * (712 / 25), 1); };
$tsv_ms_y = static function (float $tsv_msv, float $tsv_msm): float { return round(200 - ($tsv_msv / $tsv_msm) * 192, 1); };

$tsv_ms_dc = '';   // clicks line
$tsv_ms_di = '';   // impressions line
foreach ($tsv_ms_weeks as $tsv_msi => $tsv_msw) {
    $tsv_ms_dc .= ($tsv_msi ? ' L' : 'M') . $tsv_ms_x($tsv_msi) . ' ' . $tsv_ms_y($tsv_msw[1], $tsv_ms_max_c);
    $tsv_ms_di .= ($tsv_msi ? ' L' : 'M') . $tsv_ms_x($tsv_msi) . ' ' . $tsv_ms_y($tsv_msw[2], $tsv_ms_max_i);
}
$tsv_ms_da = $tsv_ms_di . ' L' . $tsv_ms_x(25) . ' 200 L' . $tsv_ms_x(0) . ' 200 Z';   // impressions area

$tsv_ms_last  = $tsv_ms_weeks[25];
$tsv_ms_first = $tsv_ms_weeks[0];
$tsv_ms_lift  = (int) round((($tsv_ms_last[1] / $tsv_ms_first[1]) - 1) * 100);

/* the six most recent points get a marker the loop can walk */
$tsv_ms_pts = [];
foreach ($tsv_ms_weeks as $tsv_msi => $tsv_msw) {
    if ($tsv_msi < 20) { continue; }
    $tsv_ms_prev = $tsv_ms_weeks[$tsv_msi - 1][1];
    $tsv_ms_pts[] = [
        'x' => $tsv_ms_x($tsv_msi),
        'y' => $tsv_ms_y($tsv_msw[1], $tsv_ms_max_c),
        'w' => $tsv_msw[0],
        'c' => number_format($tsv_msw[1]),
        'i' => number_format($tsv_msw[2]),
        'd' => sprintf('%+.1f%%', (($tsv_msw[1] / $tsv_ms_prev) - 1) * 100),
    ];
}

$tsv_ms_ticks_c = ['4,800', '3,600', '2,400', '1,200', '0'];
$tsv_ms_ticks_i = ['240k', '180k', '120k', '60k', '0'];
$tsv_ms_months  = ['Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'];

/* [figure, label, note, kind m|s] */
$tsv_ms_kpis = [
    ['62%', 'Non-brand share of clicks', 'Brand queries excluded by pattern, so the figure reflects demand you did not already own.', 'm'],
    ['31%', 'Citation rate across engines', 'Answers that named you with a working link, over 960 sampled answers.', 's'],
    ['148', 'Organic-assisted conversions', 'Conversions whose path contained an organic session before the closing interaction.', 'm'],
    ['92%', 'URLs in the CWV good band', 'Field data at the 75th percentile over a rolling 28 days: LCP ≤ 2.5 s, INP ≤ 200 ms, CLS ≤ 0.1.', 'm'],
];

/* [engine, cited %, mentioned without link %] — 12 prompts × 20 runs each, the same panel and
   the same rate the lens states in section 02 */
$tsv_ms_eng = [
    ['Perplexity',          41, 9],
    ['Google AI Overview',  34, 12],
    ['ChatGPT search',      29, 16],
    ['Gemini app',          22, 18],
];

/* [source, what it gives, refresh, kind, kind label] */
$tsv_ms_feed = [
    ['Search Console bulk export', 'Clicks, impressions and position by query, page, country and device', 'Daily', 'm', 'Measured'],
    ['Analytics property',         'Sessions, engaged sessions, conversions and assisted paths',          'Daily', 'm', 'Measured'],
    ['Field performance data',     'LCP, INP and CLS at p75 for real visits, by template',                'Monthly', 'm', 'Measured'],
    ['Prompt panel harness',       'Cited, mentioned without a link, or absent — per prompt, per engine', 'Weekly', 's', 'Sampled'],
    ['Rank tracker',               'Position for tracked queries, with feature presence',                 'Weekly', 's', 'Estimated'],
    ['Crawl and server logs',      'Indexable URLs, status codes and what the real crawlers fetched',     'Monthly', 'm', 'Measured'],
];
?>
<section class="band band--alt tsv-meas" id="measure" aria-labelledby="measure-t">
  <div class="wrap">

    <header class="tsv-head" data-rv>
      <div class="tsv-head__t">
        <p class="tsv-kick"><span class="tsv-kick__ref">08 · Measurement</span><span>Rankings · citations · outcomes</span></p>
        <h2 class="h2" id="measure-t"><span class="g">One dashboard</span> for rankings and citations.</h2>
      </div>
      <div class="tsv-head__l">
        <p class="lead">Two reports, one story: what search sent you, and what the answer engines said about you. They belong on the same page, with every figure labelled by how it was produced.</p>
      </div>
    </header>

    <div class="tsv-dash tsv-win" data-tsv-dash data-rv>

      <p class="tsv-win__bar">
        <span class="tsv-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="tsv-win__path"><b>Visibility dashboard</b> · yourcompany.com · 26 weeks to 13 Sep</span>
        <span class="tsv-win__end">
          <button class="tsv-btn tsv-dash__hl" type="button" aria-pressed="false" data-dash-hl>
            <span class="tsv-dash__sw" aria-hidden="true"></span>Highlight sampled
          </button>
          <span class="tsv-ill">Illustrative</span>
        </span>
      </p>

      <div class="tsv-dash__grid">

        <article class="tsv-dash__card tsv-dash__card--chart" data-kind="m" aria-labelledby="measure-chart-t">
          <div class="tsv-dash__hd">
            <h3 class="tsv-dash__t" id="measure-chart-t">Organic clicks and impressions</h3>
            <p class="tsv-prov tsv-prov--m">Measured · Search Console</p>
          </div>

          <div class="tsv-dash__plot">
            <ul class="tsv-dash__ax tsv-dash__ax--l" role="list" aria-hidden="true">
              <?php foreach ($tsv_ms_ticks_c as $tsv_mst): ?><li><?= e($tsv_mst) ?></li><?php endforeach; ?>
            </ul>

            <svg class="tsv-dash__svg" viewBox="0 0 720 208" fill="none" aria-hidden="true" focusable="false">
              <g class="tsv-dash__grid-l">
                <line x1="4" y1="8" x2="716" y2="8"></line>
                <line x1="4" y1="56" x2="716" y2="56"></line>
                <line x1="4" y1="104" x2="716" y2="104"></line>
                <line x1="4" y1="152" x2="716" y2="152"></line>
                <line x1="4" y1="200" x2="716" y2="200" class="tsv-dash__base"></line>
              </g>
              <path class="tsv-dash__area" d="<?= e($tsv_ms_da) ?>"></path>
              <path class="tsv-dash__line tsv-dash__line--i" d="<?= e($tsv_ms_di) ?>" pathLength="1"></path>
              <path class="tsv-dash__line tsv-dash__line--c" d="<?= e($tsv_ms_dc) ?>" pathLength="1"></path>
              <g class="tsv-dash__pts">
                <?php foreach ($tsv_ms_pts as $tsv_mpi => $tsv_mp): ?>
                  <circle class="tsv-dash__pt<?= $tsv_mpi === count($tsv_ms_pts) - 1 ? ' is-at' : '' ?>"
                          cx="<?= e((string) $tsv_mp['x']) ?>" cy="<?= e((string) $tsv_mp['y']) ?>" r="4"
                          data-w="<?= e($tsv_mp['w']) ?>" data-c="<?= e($tsv_mp['c']) ?>"
                          data-i="<?= e($tsv_mp['i']) ?>" data-d="<?= e($tsv_mp['d']) ?>"></circle>
                <?php endforeach; ?>
              </g>
            </svg>

            <ul class="tsv-dash__ax tsv-dash__ax--r" role="list" aria-hidden="true">
              <?php foreach ($tsv_ms_ticks_i as $tsv_mst): ?><li><?= e($tsv_mst) ?></li><?php endforeach; ?>
            </ul>
          </div>

          <ul class="tsv-dash__mo" role="list" aria-hidden="true">
            <?php foreach ($tsv_ms_months as $tsv_msm): ?><li><?= e($tsv_msm) ?></li><?php endforeach; ?>
          </ul>

          <div class="tsv-dash__foot">
            <ul class="tsv-dash__key" role="list" aria-hidden="true">
              <li class="tsv-dash__k tsv-dash__k--c">Clicks</li>
              <li class="tsv-dash__k tsv-dash__k--i">Impressions</li>
            </ul>
            <p class="tsv-ro tsv-dash__ro" aria-hidden="true">
              Week ending <b data-ro-w><?= e($tsv_ms_last[0]) ?></b> ·
              <b data-ro-c><?= e(number_format($tsv_ms_last[1])) ?></b> clicks ·
              <b data-ro-i><?= e(number_format($tsv_ms_last[2])) ?></b> impressions ·
              <span data-ro-d><?= e($tsv_ms_pts[count($tsv_ms_pts) - 1]['d']) ?></span> on the week
            </p>
          </div>

          <p class="bdh-sr">An illustrative 26-week chart for the placeholder company. Weekly organic clicks rise from <?= e(number_format($tsv_ms_first[1])) ?> in the week ending <?= e($tsv_ms_first[0]) ?> to <?= e(number_format($tsv_ms_last[1])) ?> in the week ending <?= e($tsv_ms_last[0]) ?>, about <?= e((string) $tsv_ms_lift) ?> per cent higher, with impressions rising from <?= e(number_format($tsv_ms_first[2])) ?> to <?= e(number_format($tsv_ms_last[2])) ?> over the same period. Both lines dip slightly in three separate weeks rather than climbing evenly.</p>
        </article>

        <ul class="tsv-dash__kpis" role="list">
          <?php foreach ($tsv_ms_kpis as $tsv_mki => $tsv_mk): ?>
            <li class="tsv-dash__card tsv-dash__kpi" data-kind="<?= e($tsv_mk[3]) ?>">
              <span class="tsv-dash__fig" data-bdh-count><?= e($tsv_mk[0]) ?></span>
              <h3 class="tsv-dash__kt"><?= e($tsv_mk[1]) ?></h3>
              <p class="tsv-dash__kn"><?= e($tsv_mk[2]) ?></p>
              <p class="tsv-prov<?= $tsv_mk[3] === 'm' ? ' tsv-prov--m' : '' ?>"><?= $tsv_mk[3] === 'm' ? 'Measured' : 'Sampled' ?></p>
            </li>
          <?php endforeach; ?>
        </ul>

        <article class="tsv-dash__card tsv-dash__card--eng" data-kind="s" aria-labelledby="measure-eng-t">
          <div class="tsv-dash__hd">
            <h3 class="tsv-dash__t" id="measure-eng-t">Share of answer by engine</h3>
            <p class="tsv-prov">Sampled · 12 prompts × 20 runs</p>
          </div>

          <ul class="tsv-eng" role="list">
            <?php foreach ($tsv_ms_eng as $tsv_mei => $tsv_me): ?>
              <?php
                $tsv_me_tot = $tsv_me[1] + $tsv_me[2];
                $tsv_me_cut = $tsv_me_tot > 0 ? round($tsv_me[1] / $tsv_me_tot * 100, 1) : 0;
              ?>
              <li class="tsv-eng__r" style="--i:<?= $tsv_mei ?>">
                <span class="tsv-eng__n"><?= e($tsv_me[0]) ?></span>
                <span class="tsv-eng__bar" aria-hidden="true">
                  <span class="tsv-eng__fill" style="--w:<?= $tsv_me_tot ?>%">
                    <i class="tsv-eng__c" style="--c:<?= $tsv_me_cut ?>%"></i>
                  </span>
                </span>
                <span class="tsv-eng__v"><b><?= $tsv_me[1] ?>%</b> cited<span> · <?= $tsv_me[2] ?>% mentioned</span></span>
              </li>
            <?php endforeach; ?>
          </ul>

          <ul class="tsv-eng__key" role="list" aria-hidden="true">
            <li class="tsv-eng__ky tsv-eng__ky--c">Cited with a link</li>
            <li class="tsv-eng__ky tsv-eng__ky--m">Mentioned, no link</li>
            <li class="tsv-eng__ky tsv-eng__ky--a">Absent</li>
          </ul>

          <p class="bdh-sr">Illustrative share of answer for four answer surfaces, each from 120 sampled answers. Perplexity cited the placeholder company in 41 per cent of answers and mentioned it without a link in a further 9 per cent; Google AI Overview 34 and 12 per cent; ChatGPT search 29 and 16 per cent; the Gemini app 22 and 18 per cent. The remainder of each bar is absence.</p>
        </article>

        <article class="tsv-dash__card tsv-dash__card--feed" aria-labelledby="measure-feed-t">
          <div class="tsv-dash__hd">
            <h3 class="tsv-dash__t" id="measure-feed-t">What feeds it</h3>
            <p class="tsv-ro">Six sources, one warehouse, one model</p>
          </div>

          <div class="tsv-feed__w">
            <table class="tsv-feed">
              <caption class="bdh-sr">The six sources behind the dashboard, what each one provides, how often it refreshes, and whether its figures are measured on your own properties, sampled from repeated runs, or estimated by a third-party model.</caption>
              <thead>
                <tr>
                  <th scope="col">Source</th>
                  <th scope="col">What it gives</th>
                  <th scope="col">Refresh</th>
                  <th scope="col">Kind</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($tsv_ms_feed as $tsv_mf): ?>
                  <tr data-kind="<?= e($tsv_mf[3]) ?>">
                    <th scope="row"><?= e($tsv_mf[0]) ?></th>
                    <td><?= e($tsv_mf[1]) ?></td>
                    <td class="tsv-feed__r"><?= e($tsv_mf[2]) ?></td>
                    <td><span class="tsv-prov<?= $tsv_mf[3] === 'm' ? ' tsv-prov--m' : '' ?>"><?= e($tsv_mf[4]) ?></span></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </article>

      </div>
    </div>

    <div class="tsv-meas__end" data-rv>
      <p class="tsv-note">
        <?= xt_icon('gauge', ['size' => 18]) ?>
        <span><b>How we read it.</b> Clicks and impressions are counts from your own property. Share of answer is a rate from repeated runs, reported with the prompt set, the run count and the date, because the same prompt can be answered differently an hour later. A rank tracker is a model of a personalised result page. We report all three, never average them together, and never present a sampled rate as traffic.</span>
      </p>
      <p class="tsv-note">
        <?= xt_icon('calendar', ['size' => 18]) ?>
        <span><b>The reporting rhythm.</b> The panel is re-sampled weekly because answer engines change on that timescale, fixes ship in weekly batches, and the written read-out goes out monthly against the baseline set in week one. <!-- PLACEHOLDER: confirm reporting cadence and baseline week with delivery before launch --> Every monthly report names what moved, what did not, and what we would stop doing.</span>
      </p>
    </div>

  </div>
</section>
