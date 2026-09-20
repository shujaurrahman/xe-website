<?php /* DRAFT COPY — review before launch */
/* 06 Lakehouse — the data platform as a running pipeline: Sources → Ingest → Lakehouse (Bronze, Silver, Gold)
   → Semantic layer → Consumers. The data contract is checked on the way from Bronze into Silver; a batch that
   fails it branches off that edge into Quarantine (drawn beside the Bronze → Silver pipe), so it never reaches
   Silver. Sources are ordered so no ingest wire crosses another. Under the board: freshness SLOs per table and
   the contract itself (column-level lineage belongs to the governance section). lakehouse.js routes the pipes
   from the live layout and runs batches through them while the board is on screen ("Inject a bad batch" sends
   one to quarantine). The HTML is the settled state. */
$tcs_lh_stages = [   // key => [label, sub, items [[key, name, detail, icon]]]
    'src'  => ['Sources', 'systems of record', [
        ['apps',  'Product apps',  'PostgreSQL · MongoDB',       'database'],
        ['saas',  'SaaS',          'CRM · support · billing',    'cloud'],
        ['files', 'Files',         'SFTP · CSV · ERP extracts',  'doc'],
        ['pos',   'Store POS',     'events from 40 stores',      'pin'],
    ]],
    'ing'  => ['Ingest', 'stream and batch', [
        ['cdc',   'Change data capture', 'Debezium → Kafka · under 1 s',   'sync'],
        ['batch', 'Batch connectors',    'Airbyte · every 15 min',         'pipeline'],
        ['ev',    'Event streams',       'Kafka topics · schema registry', 'queue'],
    ]],
    'lake' => ['Lakehouse', 'medallion · Iceberg', [
        ['bronze', 'Bronze', 'raw · append-only · as received',        'layers'],
        ['quar',   'Quarantine', 'failed the contract · held for the owner', 'alert'],
        ['silver', 'Silver', 'contract-checked · deduplicated · typed', 'check'],
        ['gold',   'Gold',   'dimensional · tested · documented',      'chart'],
    ]],
    'sem'  => ['Semantic layer', 'every metric defined once', [
        ['m1', 'net_revenue',      'gold.fct_revenue · owner: finance',    'target'],
        ['m2', 'active_customers', 'gold.dim_customer · owner: growth',    'users'],
        ['m3', 'order_cycle_time', 'gold.fct_orders · owner: operations',  'clock'],
    ]],
    'out'  => ['Consumers', 'one number everywhere', [
        ['bi',  'BI dashboards', 'Power BI · Looker',            'dashboard'],
        ['crm', 'Reverse ETL',   'segments back into the CRM',   'workflow'],
        ['ai',  'AI and RAG',    'agents read governed tables',  'agent'],
        ['fin', 'Finance close', 'reconciled to the ledger',     'clipboard-check'],
    ]],
];
/* pipes: [from item, from side, attach fraction, to item, to side, attach fraction] */
$tcs_lh_pipes = [
    ['apps', 'r', .5, 'cdc', 'l', .5],   ['saas', 'r', .5, 'batch', 'l', .4], ['pos', 'r', .5, 'ev', 'l', .5],   ['files', 'r', .5, 'batch', 'l', .6],
    ['cdc', 'r', .5, 'bronze', 'l', .35], ['batch', 'r', .5, 'bronze', 'l', .5], ['ev', 'r', .5, 'bronze', 'l', .65],
    ['bronze', 'b', .09, 'silver', 't', .09], ['bronze', 'b', .09, 'quar', 'l', .5], ['silver', 'b', .3, 'gold', 't', .3],
    ['gold', 'r', .5, 'm1', 'l', .5], ['gold', 'r', .5, 'm2', 'l', .5], ['gold', 'r', .5, 'm3', 'l', .5],
    ['m1', 'r', .5, 'bi', 'l', .4], ['m1', 'r', .5, 'fin', 'l', .5], ['m2', 'r', .5, 'crm', 'l', .5], ['m2', 'r', .5, 'ai', 'l', .5], ['m3', 'r', .5, 'bi', 'l', .6],
];
$tcs_lh_slos = [   // [table, slo, now, state]
    ['silver.orders',     '≤ 15 min', '6 min',       'met'],
    ['silver.customers',  '≤ 60 min', '22 min',      'met'],
    ['silver.inventory',  '≤ 5 min',  '3 min',       'met'],
    ['gold.fct_revenue',  '≤ 24 h',   '4 h 10 min',  'met'],
    ['gold.dim_product',  '≤ 24 h',   '21 h 40 min', 'risk'],
];
/* marks first, then the name-only chips together at the end (Debezium and Apache Iceberg are not in the logo
   library; dbt and Power BI have no licence-clean mark), so the row reads evenly */
$tcs_lh_logos = ['apachekafka', 'airbyte', 'snowflake', 'databricks', 'googlebigquery', 'apacheairflow', 'apachespark', 'duckdb', 'looker', 'postgresql', 'Debezium', 'Apache Iceberg', 'dbt', 'powerbi'];
?>
<section class="band tcs-lakehouse" id="lakehouse" aria-labelledby="lakehouse-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>Data platform · medallion lakehouse</p>
        <h2 class="h2" id="lakehouse-t"><span class="g">From raw events</span> to numbers finance trusts.</h2>
      </div>
      <div>
        <p class="lead">Every table has an owner, a schema contract and a freshness target. A batch that breaks the contract is held for its owner, never silently loaded. Every number on a dashboard traces back to the column it came from.</p>
      </div>
    </div>

    <div class="tcs-lh" data-rv>
      <div class="bdh-ui tcs-lh__board">
        <div class="bdh-ui__bar tcs-lh__bar">
          <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="tcs-lh__path">data-platform <i>/</i> your-company <i>/</i> <b>prod</b></span>
          <span class="tcs-lh__slo" aria-hidden="true"><i class="bdh-pulse"></i><span data-lh-status>14 of 14 freshness SLOs met</span></span>
          <div class="tcs-lh__ctl">
            <button type="button" class="tcs-btn" data-lh-bad hidden><?= xt_icon('alert', ['size' => 14, 'mono' => true]) ?>Inject a bad batch</button>
            <button type="button" class="tcs-btn" data-lh-pause aria-pressed="false" hidden>Pause</button>
          </div>
        </div>

        <div class="tcs-lh__flow" aria-hidden="true">
          <svg class="tcs-lh__svg" focusable="false">
            <defs><marker id="tcs-lh-arrow" class="tcs-lh__arrow" viewBox="0 0 8 8" refX="7.5" refY="4" markerWidth="8" markerHeight="8" markerUnits="userSpaceOnUse" orient="auto"><path d="M1.5 1.2 7 4l-5.5 2.8"/></marker></defs>
            <?php foreach ($tcs_lh_pipes as $tcs_lh_p): ?>
              <path class="tcs-lh__pipe" pathLength="1" marker-end="url(#tcs-lh-arrow)" data-pipe="<?= $tcs_lh_p[0] ?>-<?= $tcs_lh_p[3] ?>" data-from="<?= $tcs_lh_p[0] ?>" data-fs="<?= $tcs_lh_p[1] ?>" data-fa="<?= $tcs_lh_p[2] ?>" data-to="<?= $tcs_lh_p[3] ?>" data-ts="<?= $tcs_lh_p[4] ?>" data-ta="<?= $tcs_lh_p[5] ?>"/>
            <?php endforeach; ?>
          </svg>
          <span class="tcs-lh__spine"><i></i><i></i><i></i><i></i></span>
          <?php foreach ($tcs_lh_stages as $tcs_lh_k => $tcs_lh_s): ?>
            <div class="tcs-lh__stage tcs-lh__stage--<?= $tcs_lh_k ?>">
              <p class="tcs-lh__sh"><b><?= e($tcs_lh_s[0]) ?></b><span><?= e($tcs_lh_s[1]) ?></span></p>
              <div class="tcs-lh__items">
                <?php foreach ($tcs_lh_s[2] as $tcs_lh_it): ?>
                  <div class="tcs-lh__it tcs-lh__it--<?= $tcs_lh_it[0] ?>" data-node="<?= $tcs_lh_it[0] ?>">
                    <span class="tcs-lh__ii"><?= xt_icon($tcs_lh_it[3], ['size' => 15, 'mono' => true]) ?></span>
                    <span class="tcs-lh__in"><?= e($tcs_lh_it[1]) ?></span>
                    <span class="tcs-lh__id" data-detail><?= e($tcs_lh_it[2]) ?></span>
                    <?php if ($tcs_lh_it[0] === 'silver'): ?>
                      <span class="tcs-lh__stamp" data-lh-stamp><?= xt_icon('check', ['size' => 12, 'mono' => true]) ?>contract v3</span>
                    <?php elseif ($tcs_lh_it[0] === 'quar'): ?>
                      <span class="tcs-lh__qn" data-lh-qnote>orders_raw · 02:15 batch · total arrived as string, expected decimal(12,2) · owner paged</span>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <dl class="tcs-lh__meter">
          <div><dt>Rows today</dt><dd data-lh-rows>18,406,212</dd></div>
          <div><dt>Contract checks passed</dt><dd data-lh-ok>1,284</dd></div>
          <div><dt>Batches quarantined</dt><dd data-lh-q>1</dd></div>
          <div><dt>Freshness p95</dt><dd>6 min</dd></div>
          <div><dt>Lineage coverage</dt><dd>100% of gold</dd></div>
          <div class="tcs-lh__ill"><span class="bdh-ill">Illustrative</span></div>
        </dl>
      </div>
      <p class="bdh-sr">An illustrative data platform for “Your company”. Sources (product apps, SaaS, store POS and files) feed ingest (change data capture, batch connectors, event streams) into a medallion lakehouse: Bronze raw tables; a data contract checked on the way into Silver, with batches that fail it held in a quarantine instead; Silver typed and deduplicated tables; and Gold dimensional tables. A semantic layer defines net revenue, active customers and order cycle time once, and BI dashboards, reverse ETL to the CRM, AI agents and the finance close all read from it.</p>

      <div class="tcs-lh__panels">
        <div class="tcs-lh__panel">
          <p class="tcs-lh__ph"><?= xt_icon('clock', ['size' => 16]) ?>Freshness SLOs <em>per table, monitored</em></p>
          <table class="tcs-lh__tbl">
            <thead><tr><th scope="col">Table</th><th scope="col">SLO</th><th scope="col">Now</th><th scope="col">State</th></tr></thead>
            <tbody>
              <?php foreach ($tcs_lh_slos as $tcs_lh_r): ?>
                <tr><th scope="row"><?= e($tcs_lh_r[0]) ?></th><td><?= e($tcs_lh_r[1]) ?></td><td><?= e($tcs_lh_r[2]) ?></td><td><span class="tcs-st <?= $tcs_lh_r[3] === 'met' ? 'tcs-st--ok' : 'tcs-st--wait' ?>"><?= $tcs_lh_r[3] === 'met' ? 'Met' : 'At risk' ?></span></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <p class="tcs-lh__pn">Breaches page the table owner, not a shared inbox.</p>
        </div>

        <div class="tcs-lh__panel">
          <p class="tcs-lh__ph"><?= xt_icon('doc', ['size' => 16]) ?>Data contract <em>checked on every batch</em></p>
<pre class="tcs-lh__code"><code><span class="c"># contracts/silver/orders.yaml</span>
<span class="k">dataset:</span> silver.orders
<span class="k">owner:</span>   order-platform@your-company
<span class="k">schema:</span>  <span class="c"># all fields required</span>
  order_id:   { type: uuid, unique: true }
  account_id: { type: uuid, ref: accounts }
  total:      { type: decimal(12,2), min: 0 }
  placed_at:  { type: timestamptz }
<span class="k">sla:</span>
  freshness:    15m
  completeness: 99.9%
<span class="k">on_violation:</span> quarantine + page owner</code></pre>
        </div>
      </div>

      <div class="tcs-lh__stack">
        <p class="tcs-lh__sk">Technologies we work with on data platforms</p>
        <?= xt_stack($tcs_lh_logos, ['variant' => 'chips', 'size' => 16, 'label' => 'Data platform technologies we work with']) ?>
        <p class="tcs-lh__sk2">Debezium streams database changes into Kafka; Apache Iceberg keeps the lakehouse tables in an open format any engine can read. Chosen per platform, on what your team can run.</p>
      </div>
    </div>
  </div>
</section>
