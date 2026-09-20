<?php /* DRAFT COPY — review before launch */
/* 09 Carbon — store less, scan less, pay less. A FinOps window for "Your company" with a Before / After
   policies switch (real buttons). Left: storage by temperature, eight datasets as blocks in four lanes (hot,
   warm, cold, archive); after the policies they slide down the temperature scale or are deleted by retention.
   Right: warehouse compute per workload, bars that shrink to the after value with the practice that did it.
   A KPI strip totals both, including SCI per 1,000 queries. Below: the five practices and the SCI formula.
   carbon.js plays before → after once on entry and drives the switch. The HTML is the "after" state.
   Every figure is illustrative. */
$tcs_cb_tiers = [   // [name, medium, indicative list price per TB-month]
    ['Hot',     'SSD · warehouse', '≈ $23'],
    ['Warm',    'infrequent access',       '≈ $12.5'],
    ['Cold',    'instant retrieval',       '≈ $4'],
    ['Archive', 'hours to restore',        '≈ $1'],
];
$tcs_cb_sets = [   // [dataset, why, TB, lane before, lane after (-1 = deleted), note after]
    ['gold marts',                'queried every few minutes',  '0.3',  0, 0,  'stays hot'],
    ['silver.orders · 90 days',   'live reporting window',      '0.6',  0, 0,  'stays hot'],
    ['silver.orders · 90 d–2 y',  'read at month end',          '2.4',  0, 1,  'to warm at 90 days'],
    ['bronze.events_raw · > 30 d','replayable, rarely read',    '9.8',  0, 2,  'to cold at 30 days'],
    ['feature backfills',         'rebuilt from silver',        '2.2',  0, 2,  'to cold'],
    ['ledger snapshots',          'legal hold · 7 years',       '3.6',  1, 3,  'to archive · hold kept'],
    ['clickstream · > 13 months', 'past retention period',      '14.2', 0, -1, 'deleted by policy'],
    ['staging copies',            '0 reads in 180 days',        '5.1',  0, -1, 'deleted · owner confirmed'],
];
$tcs_cb_tb = [   // per lane: [before, after] in TB
    ['34.6', '0.9'], ['3.6', '2.4'], ['0', '12.0'], ['0', '3.6'],
];
$tcs_cb_work = [   // [workload, practice, credits before, credits after, icon]
    ['Revenue models · dbt',     'Full refresh → incremental models',        48, 9,  'sync'],
    ['BI dashboards',            'Partition pruning + clustering on date',  36, 11, 'filter'],
    ['Customer 360 refresh',     'Hourly rebuild → CDC merge',              30, 7,  'pipeline'],
    ['Ad-hoc exploration',       'Auto-suspend after 60 s, was 60 min',     22, 8,  'clock'],
    ['Reverse ETL syncs',        'Full sync → changed rows only',           14, 3,  'workflow'],
];
$tcs_cb_max = 48;
$tcs_cb_hours = [.1, .05, .6, .1, .05, .05, .2, .5, .8, .9, .85, .8, .7, .8, .85, .8, .7, .6, .4, .2, .1, .05, .05, .05];   // share of each hour the warehouse ran, after the policies (sum 10.3 h)
$tcs_cb_kpis = [   // [label, before, after, delta]
    ['Scanned per day',          '41.8 TB',  '6.2 TB',  '−85%'],
    ['Warehouse credits / day',  '150',      '38',      '−75%'],
    ['Storage bill / month',     '$841',     '$102',    '−88%'],
    ['SCI per 1,000 queries',    '182 g',    '47 g',    'CO₂e'],
];
$tcs_cb_practices = [   // [icon, title, text, code]
    ['sync',     'Incremental models',             'Models process only new and changed rows instead of rebuilding a whole table on every run.',                                  "materialized='incremental'"],
    ['filter',   'Partition pruning and clustering','Tables are partitioned by date and clustered on the columns people filter by, so a dashboard reads days, not years.',         'PARTITION BY DATE(placed_at)'],
    ['clock',    'Auto-suspend warehouses',         'Compute suspends after a minute idle and resumes on the next query. Idle warehouses are one of the most common sources of waste.',         'AUTO_SUSPEND = 60'],
    ['calendar', 'Retention by policy',             'Every dataset carries a retention period in its contract. Tiering and deletion run on schedule, and legal holds are respected.', 'retention: 13 months'],
    ['eye',      'Delete what nobody reads',        'Access logs show the tables no one has queried in six months. Their owners confirm, then they go.',                             '0 reads · 180 days'],
];
?>
<section class="band tcs-carbon" id="carbon" aria-labelledby="carbon-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>Sustainability · cost and carbon</p>
        <h2 class="h2" id="carbon-t"><span class="g">Store less, scan less,</span> pay less.</h2>
      </div>
      <div>
        <p class="lead">The cheapest query is the one that never scans a byte it does not need. The practices that cut the warehouse bill also cut the energy behind it, so we report cost and carbon side by side, per workload.</p>
      </div>
    </div>

    <div class="tcs-cb" data-rv>
      <div class="bdh-ui tcs-cb__win" data-state="after">
        <div class="bdh-ui__bar tcs-cb__bar">
          <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="tcs-cb__path">finops <i>/</i> your-company <i>/</i> <b>warehouse</b></span>
          <span class="tcs-cb__ro" aria-hidden="true" data-cb-ro>After policies · 28-day view</span>
          <div class="bdh-seg tcs-cb__seg" role="group" aria-label="Show the platform">
            <button type="button" aria-pressed="false" data-cb-set="before">Before policies</button>
            <button type="button" aria-pressed="true" data-cb-set="after">After policies</button>
          </div>
        </div>

        <div class="tcs-cb__body" aria-hidden="true">
          <div class="tcs-cb__pane tcs-cb__store">
            <p class="tcs-cb__h"><span>Storage by temperature</span><em><span class="is-b">38.2 TB stored</span><span class="is-a">18.9 TB stored · 19.3 TB deleted</span></em></p>
            <div class="tcs-cb__lanes">
              <span class="tcs-cb__lk">Dataset</span>
              <span class="tcs-cb__lhs">
                <?php foreach ($tcs_cb_tiers as $tcs_cb_i => $tcs_cb_t): ?>
                  <span class="tcs-cb__lh" data-lane="<?= $tcs_cb_i ?>"><i class="tcs-cb__temp"></i><b><?= e($tcs_cb_t[0]) ?></b><small><?= e($tcs_cb_t[1]) ?></small><small><?= e($tcs_cb_t[2]) ?> / TB-mo</small></span>
                <?php endforeach; ?>
              </span>

              <?php foreach ($tcs_cb_sets as $tcs_cb_i => $tcs_cb_s): ?>
                <span class="tcs-cb__ds"><b><?= e($tcs_cb_s[0]) ?></b><small><span class="is-b"><?= e($tcs_cb_s[1]) ?></span><span class="is-a"><?= e($tcs_cb_s[1]) ?> · <em><?= e($tcs_cb_s[5]) ?></em></span></small></span>
                <span class="tcs-cb__track" style="--i:<?= $tcs_cb_i ?>">
                  <i class="tcs-cb__g"></i><i class="tcs-cb__g"></i><i class="tcs-cb__g"></i><i class="tcs-cb__g"></i>
                  <span class="tcs-cb__blk<?= $tcs_cb_s[4] < 0 ? ' is-del' : '' ?>" data-from="<?= $tcs_cb_s[3] ?>" data-to="<?= $tcs_cb_s[4] < 0 ? 'x' : $tcs_cb_s[4] ?>" style="--f:<?= $tcs_cb_s[3] ?>;--t:<?= max(0, $tcs_cb_s[4] < 0 ? $tcs_cb_s[3] : $tcs_cb_s[4]) ?>">
                    <b><?= e($tcs_cb_s[2]) ?> TB</b>
                  </span>
                </span>
              <?php endforeach; ?>

              <span class="tcs-cb__ds tcs-cb__ds--tot"><b>Per tier</b></span>
              <span class="tcs-cb__tots">
                <?php foreach ($tcs_cb_tb as $tcs_cb_i => $tcs_cb_v): ?>
                  <span><b class="is-b"><?= e($tcs_cb_v[0]) ?> TB</b><b class="is-a"><?= e($tcs_cb_v[1]) ?> TB</b></span>
                <?php endforeach; ?>
              </span>
            </div>
          </div>

          <div class="tcs-cb__pane tcs-cb__comp">
            <p class="tcs-cb__h"><span>Compute per workload</span><em>credits / day</em></p>
            <ul class="tcs-cb__wl">
              <?php foreach ($tcs_cb_work as $tcs_cb_i => $tcs_cb_w): ?>
                <li class="tcs-cb__w" style="--i:<?= $tcs_cb_i ?>;--b:<?= round($tcs_cb_w[2] / $tcs_cb_max, 4) ?>;--a:<?= round($tcs_cb_w[3] / $tcs_cb_max, 4) ?>">
                  <span class="tcs-cb__wi"><?= xt_icon($tcs_cb_w[4], ['size' => 15, 'mono' => true]) ?></span>
                  <span class="tcs-cb__wn"><b><?= e($tcs_cb_w[0]) ?></b><small><?= e($tcs_cb_w[1]) ?></small></span>
                  <span class="tcs-cb__wf"><b class="is-b"><?= $tcs_cb_w[2] ?></b><b class="is-a"><?= $tcs_cb_w[3] ?></b><small class="is-a">−<?= round((1 - $tcs_cb_w[3] / $tcs_cb_w[2]) * 100) ?>%</small></span>
                  <span class="tcs-cb__bar2"><i class="tcs-cb__was"></i><i class="tcs-cb__now"></i></span>
                </li>
              <?php endforeach; ?>
            </ul>
            <p class="tcs-cb__axis"><span>0</span><span>12</span><span>24</span><span>36</span><span>48</span></p>
            <p class="tcs-cb__legend"><span><i class="tcs-cb__lg tcs-cb__lg--now"></i><span data-cb-now>After policies</span></span><span><i class="tcs-cb__lg tcs-cb__lg--was"></i>Baseline, before policies</span></p>

            <div class="tcs-cb__up">
              <p class="tcs-cb__h"><span>Warehouse uptime · 24 h</span><em><span class="is-b">24.0 h · never idle long enough</span><span class="is-a">10.3 h · suspends after 60 s</span></em></p>
              <div class="tcs-cb__hrs">
                <?php foreach ($tcs_cb_hours as $tcs_cb_i => $tcs_cb_h): ?><i style="--u:<?= $tcs_cb_h ?>;--i:<?= $tcs_cb_i ?>"></i><?php endforeach; ?>
              </div>
              <p class="tcs-cb__hax"><span>00:00</span><span>06:00</span><span>12:00</span><span>18:00</span><span>24:00</span></p>
            </div>
          </div>
        </div>

        <dl class="tcs-cb__kpis">
          <?php foreach ($tcs_cb_kpis as $tcs_cb_k): ?>
            <div>
              <dt><?= e($tcs_cb_k[0]) ?></dt>
              <dd><b class="is-b"><?= e($tcs_cb_k[1]) ?></b><b class="is-a"><?= e($tcs_cb_k[2]) ?></b><span class="is-a tcs-cb__dl"><?= e($tcs_cb_k[3]) ?></span></dd>
            </div>
          <?php endforeach; ?>
          <div class="tcs-cb__ill"><span class="bdh-ill">Illustrative</span></div>
        </dl>
        <p class="bdh-sr" data-cb-sr>Illustrative figures for “Your company”, before and after the policies; the buttons switch the window between the two states. Storage: 38.2 TB before, of which 34.6 TB sat in the hot tier; after tiering and retention, 0.9 TB hot, 2.4 TB warm, 12 TB cold and 3.6 TB archive, with 19.3 TB deleted. Compute: 150 warehouse credits a day before and 38 after, from incremental models, partition pruning and clustering, change data capture merges, auto-suspend and changed-rows-only syncs. Data scanned falls from 41.8 TB to 6.2 TB a day, the storage bill from about $841 to $102 a month, and software carbon intensity from 182 to 47 grams CO₂e per 1,000 queries. The warehouse now runs about 10 of 24 hours a day instead of all 24.</p>
      </div>

      <div class="tcs-cb__below">
        <ol class="tcs-cb__pr" data-rv-s>
          <?php foreach ($tcs_cb_practices as $tcs_cb_i => $tcs_cb_p): ?>
            <li class="tcs-cb__p">
              <span class="tcs-cb__pi"><?= xt_icon($tcs_cb_p[0], ['size' => 20]) ?></span>
              <h3 class="tcs-cb__pt"><?= e($tcs_cb_p[1]) ?></h3>
              <p class="tcs-cb__pd"><?= e($tcs_cb_p[2]) ?></p>
              <code class="tcs-cb__pc"><?= e($tcs_cb_p[3]) ?></code>
            </li>
          <?php endforeach; ?>
        </ol>

        <aside class="tcs-cb__sci" aria-labelledby="carbon-sci-t">
          <p class="tcs-cb__sk" id="carbon-sci-t">How we measure it</p>
          <?= xt_badge('sci', ['tag' => 'div']) ?>
          <p class="tcs-cb__f" aria-label="SCI equals open bracket E times I plus M close bracket per R"><span>SCI</span> = ((<b>E</b> × <b>I</b>) + <b>M</b>) per <b>R</b></p>
          <dl class="tcs-cb__fd">
            <div><dt>E</dt><dd>Energy the workload used, in kWh, from warehouse metering</dd></div>
            <div><dt>I</dt><dd>Carbon intensity of the grid in your cloud region, gCO₂e per kWh</dd></div>
            <div><dt>M</dt><dd>The embodied emissions share of the hardware it ran on</dd></div>
            <div><dt>R</dt><dd>The functional unit: here, per 1,000 queries</dd></div>
          </dl>
          <p class="tcs-cb__sn">A rate, not a total, so it still means something as usage grows. Reported with the bill at every monthly review.</p>
        </aside>
      </div>
    </div>
  </div>
</section>
