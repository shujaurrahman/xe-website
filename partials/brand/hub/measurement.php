<?php /* DRAFT COPY — review before launch */
/* Measurement — a four-tier ladder from consistency to value, and an illustrative brand-health
   dashboard. PLACEHOLDER: illustrative figures — not client results; confirm the measure set before launch. */
$ms_ladder = [
    ['Consistency', 'Is the system being used?',                  ['Brand check pass rate', 'Template adoption', 'Drift reports']],
    ['Efficiency',  'Is it faster and cheaper to be on brand?',    ['Time to market', 'Asset reuse', 'Cost per asset']],
    ['Perception',  'Do people notice and remember?',             ['Awareness', 'Distinctiveness', 'Consideration']],
    ['Value',       'What is it worth to the business?',          ['Pricing power', 'Retention', 'Brand contribution, modelled with finance']],
];
// [label, index, delta note, quarter sparkline, year sparkline]
$ms_kpis = [
    ['Brand check pass rate', 118, '▲ vs baseline',    'M0 30 L20 27 L40 25 L60 20 L80 17 L100 12 L120 8',  'M0 32 L20 30 L40 31 L60 24 L80 20 L100 14 L120 6'],
    ['Template adoption',     131, '▲ vs baseline',    'M0 31 L20 29 L40 22 L60 20 L80 14 L100 10 L120 5',  'M0 33 L20 32 L40 28 L60 25 L80 17 L100 11 L120 4'],
    ['Time to market',        84,  '▼ faster',         'M0 6 L20 9 L40 12 L60 16 L80 20 L100 23 L120 27',   'M0 4 L20 6 L40 11 L60 13 L80 19 L100 24 L120 29'],
    ['Distinctiveness',       107, '▲ vs baseline',    'M0 24 L20 25 L40 22 L60 21 L80 18 L100 17 L120 14', 'M0 27 L20 26 L40 25 L60 22 L80 20 L100 17 L120 13'],
];
$ms_heat_cols = ['Check pass', 'Template use', 'Distinctiveness'];
$ms_heat = [[.9, .8, .6], [.8, .9, .7], [.6, .7, .5], [.9, .6, .8], [.7, .5, .6], [.5, .6, .4]];
?>
<section class="band bdh-measurement" id="measurement" aria-labelledby="measurement-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Measurement</p>
        <h2 class="h2" id="measurement-t"><span class="g">Brand is an asset.</span> We track it like one.</h2>
      </div>
      <div><p class="lead">A small set of measures agreed before launch and tracked in one place, from whether the system is used to what it is worth. The dashboard below is illustrative.</p></div>
    </div>

    <div class="bdh-grid bdh-ms__grid">
      <ol class="bdh-c5 bdh-ms__ladder" data-rv>
        <?php foreach ($ms_ladder as $ms_i => $ms_t): ?>
          <li class="bdh-ms__tier" style="--i:<?= $ms_i ?>">
            <span class="bdh-ms__node" aria-hidden="true"></span>
            <span class="bdh-idx"><?= str_pad((string) ($ms_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="bdh-t"><?= e($ms_t[0]) ?></h3>
            <p class="bdh-d"><?= e($ms_t[1]) ?></p>
            <p class="bdh-tags"><?php foreach ($ms_t[2] as $ms_c): ?><span class="bdh-tag"><?= e($ms_c) ?></span><?php endforeach; ?></p>
          </li>
        <?php endforeach; ?>
      </ol>

      <div class="bdh-c7 bdh-s6 bdh-ms__dashcol">
        <div class="bdh-ui bdh-ms__dash" data-view="q" data-rv data-rv-d="120" data-bdh-live>
          <div class="bdh-ui__bar">
            <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
            <span class="bdh-ms__title"><i class="bdh-pulse" aria-hidden="true"></i>Brand health · Your brand</span>
            <span class="bdh-ms__ctl">
              <span class="bdh-seg" role="group" aria-label="Time range">
                <button type="button" aria-pressed="true" data-view="q">Quarter</button>
                <button type="button" aria-pressed="false" data-view="y">Year</button>
              </span>
              <span class="bdh-ill">Illustrative</span>
            </span>
          </div>

          <div class="bdh-ms__body">
            <ul class="bdh-ms__kpis">
              <?php foreach ($ms_kpis as $ms_i => $ms_k): ?>
                <li class="bdh-ms__kpi">
                  <p class="bdh-ms__kl"><?= e($ms_k[0]) ?></p>
                  <p class="bdh-ms__kv"><span class="bdh-ms__kx">Index</span> <b data-bdh-count><?= $ms_k[1] ?></b></p>
                  <p class="bdh-ms__kd<?= strpos($ms_k[2], 'faster') !== false ? ' is-down' : '' ?>"><?= e($ms_k[2]) ?></p>
                  <svg class="bdh-ms__spark" viewBox="0 0 120 36" preserveAspectRatio="none" aria-hidden="true" focusable="false" style="--i:<?= $ms_i ?>">
                    <path class="is-q" d="<?= $ms_k[3] ?>"/>
                    <path class="is-y" d="<?= $ms_k[4] ?>"/>
                  </svg>
                </li>
              <?php endforeach; ?>
            </ul>

            <div class="bdh-ms__heat">
              <p class="bdh-ms__hk">Consistency by market</p>
              <div class="bdh-ms__hscroll">
                <table class="bdh-ms__table">
                  <thead><tr><th scope="col"><span class="bdh-sr">Market</span></th><?php foreach ($ms_heat_cols as $ms_c): ?><th scope="col"><?= e($ms_c) ?></th><?php endforeach; ?></tr></thead>
                  <tbody>
                    <?php foreach ($ms_heat as $ms_i => $ms_row): ?>
                      <tr>
                        <th scope="row">Market <?= str_pad((string) ($ms_i + 1), 2, '0', STR_PAD_LEFT) ?></th>
                        <?php foreach ($ms_row as $ms_j => $ms_v): ?>
                          <td><span class="bdh-ms__dot" style="--s:<?= $ms_v ?>;--i:<?= $ms_i + $ms_j ?>"></span><span class="bdh-sr"><?= round($ms_v * 100) ?> of 100</span></td>
                        <?php endforeach; ?>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <p class="bdh-ms__note">Indexed against the pre-launch baseline (100). Figures are illustrative, not client results.</p>
      </div>
    </div>
  </div>
</section>
