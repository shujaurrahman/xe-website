<?php /* DRAFT COPY — review before launch */
/* 11 · Outcomes ($CAP['outcomes']) over an adoption heatmap: teams × channels, the share of assets
   built from system parts, stepped through the first year. Each outcome highlights its pattern.
   All values illustrative. PLACEHOLDER: confirm before launch */
$cbs_ad_cols = ['App', 'Web', 'Email', 'Social', 'Slides', 'Print'];
$cbs_ad_rows = [   // [team, lag 0–2, month-12 values per channel]
    ['Product',        0, [96, 92, 70, 40, 62, 20]],
    ['Marketing',      1, [60, 90, 94, 88, 80, 72]],
    ['Communications', 1, [30, 76, 86, 82, 90, 66]],
    ['Market 01',      1, [58, 84, 88, 90, 74, 70]],
    ['Market 02',      2, [44, 72, 80, 84, 66, 62]],
    ['Market 03',      2, [40, 70, 78, 86, 60, 58]],
    ['Agency A',       2, [18, 66, 74, 80, 52, 44]],
];
$cbs_ad_months = [1, 3, 6, 12];
$cbs_ad_curve = [[.22, .55, .8, 1], [.08, .35, .68, 1], [.02, .18, .52, 1]];   // share of month-12 value, by lag
$cbs_ad_focus = ['queue', 'markets', 'all'];   // which cells each outcome highlights (see adoption.css)
?>
<section class="band cbs-ad" id="outcomes" aria-labelledby="cbs-ad-t">
  <div class="wrap">
    <header class="cbs-head cbs-head--split" data-rv>
      <p class="cbs-head__path"><b>11</b><i>/</i>outcomes<i>/</i>adoption</p>
      <h2 class="cbs-head__h" id="cbs-ad-t"><span class="g">Measured by use,</span> not by launch.</h2>
      <p class="lead cbs-head__lead">A system works when teams build with it. We track the share of assets made from system parts, team by team and channel by channel, and we read the gaps as the next piece of work.</p>
    </header>

    <div class="cbs-ad__grid" data-cbs-ad>
      <div class="cbs-ad__map">
        <div class="cbs-ad__top">
          <p class="cbs-ad__t">Assets built from system parts <span class="cbs-note">Illustrative</span></p>
          <div class="cbs-ad__months" role="group" aria-label="Month after launch">
            <?php foreach ($cbs_ad_months as $cbs_mi => $cbs_m): ?>
              <button type="button" class="cbs-ad__m" aria-pressed="<?= $cbs_mi === 3 ? 'true' : 'false' ?>" data-cbs-ad-month="<?= $cbs_mi ?>">Month <?= $cbs_m ?></button>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="bdh-scroll-x cbs-ad__scroll" tabindex="0" role="region" aria-label="Adoption heatmap, teams by channel">
          <table class="cbs-ad__table">
            <caption class="bdh-sr" data-cbs-ad-cap>Share of assets built from system parts at month 12, by team and channel. Illustrative.</caption>
            <thead><tr><th scope="col"><span class="bdh-sr">Team</span></th><?php foreach ($cbs_ad_cols as $cbs_c): ?><th scope="col"><?= e($cbs_c) ?></th><?php endforeach; ?></tr></thead>
            <tbody>
              <?php foreach ($cbs_ad_rows as $cbs_ri => $cbs_r): ?>
                <tr class="<?= strpos($cbs_r[0], 'Market ') === 0 ? 'is-market' : '' ?>">
                  <th scope="row"><?= e($cbs_r[0]) ?></th>
                  <?php foreach ($cbs_r[2] as $cbs_ci => $cbs_v):
                    $cbs_vals = array_map(fn ($cbs_k) => (int) round($cbs_v * $cbs_k), $cbs_ad_curve[$cbs_r[1]]); ?>
                    <td class="cbs-ad__cell<?= in_array($cbs_ad_cols[$cbs_ci], ['Email', 'Social', 'Slides']) ? ' is-queue' : '' ?>" data-m="<?= e(implode(',', $cbs_vals)) ?>" style="--v:<?= $cbs_vals[3] ?>"><span><?= $cbs_vals[3] ?></span></td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="cbs-ad__key" aria-hidden="true"><span>0%</span><i style="--v:0"></i><i style="--v:25"></i><i style="--v:50"></i><i style="--v:75"></i><i style="--v:100"></i><span>100%</span><b>Under 25%</b><em data-cbs-ad-avg>Average 71%</em></p>
      </div>

      <!-- PLACEHOLDER: reference photo (Unsplash) — confirm before launch -->
      <figure class="cbs-photo cbs-ad__photo">
        <img src="<?= xe_url('assets/imgs/brand/brand-systems/adoption-team.jpg') ?>" alt="A team gathered around a laptop in an open office, talking through what is on screen" width="1200" height="675" loading="lazy" decoding="async">
        <figcaption><span>Adoption review · Market 03</span></figcaption>
      </figure>

      <ol class="cbs-ad__outs">
        <?php foreach ($CAP['outcomes'] as $cbs_oi => $cbs_o): ?>
          <li>
            <button type="button" class="cbs-ad__out" aria-pressed="false" data-cbs-ad-focus="<?= e($cbs_ad_focus[$cbs_oi] ?? 'all') ?>">
              <span class="cbs-ad__on"><?= sprintf('%02d', $cbs_oi + 1) ?></span>
              <span class="cbs-ad__oh"><?= e($cbs_o[0]) ?></span>
              <span class="cbs-ad__od"><?= e($cbs_o[1]) ?></span>
              <span class="cbs-ad__ol">Show on the map</span>
            </button>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
