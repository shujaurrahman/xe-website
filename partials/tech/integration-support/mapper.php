<?php /* DRAFT COPY — review before launch */
/* SIGNATURE — The Field Mapper. A storefront order.created event (left) has to become an ERP sales
   order (right). Select a source field, then the target it feeds (click, Enter or Space; Escape
   cancels), and pick a transform. The preview is validated against the target schema on every
   change, including one deliberate trap: an amount sent in minor units (paise) without ÷ 100 is
   flagged as a 100× mismatch. Auto-map asks an agent for proposals with confidence scores that
   you accept or reject one by one. Send test event posts to a sandbox with an idempotency key.
   HTML = the finished flow (all mapped, valid, 201 Created). mapper.js plays that build once, a
   few seconds after the section is on screen, and then rests on the finished flow again; it never
   loops and never restarts. All data is fictional. */
$tis_mp_src = [   // [key, path, type, sample shown]
    ['s_id',      'id',                     'string',  'ord_8F2K41'],
    ['s_created', 'created_at',             'date-time', '2026-09-14T21:47:03+05:30'],
    ['s_email',   'customer.email',         'string',  'asha.rao@example.com'],
    ['s_first',   'customer.first_name',    'string',  'Asha'],
    ['s_last',    'customer.last_name',     'string',  'Rao'],
    ['s_total',   'total_amount',           'integer', '249900'],
    ['s_cur',     'currency',               'string',  'INR'],
    ['s_status',  'financial_status',       'string',  'paid'],
    ['s_sku',     'line_items[0].sku',      'string',  'MUG-340-BLU'],
    ['s_qty',     'line_items[0].quantity', 'integer', '2'],
    ['s_price',   'line_items[0].price',    'integer', '124950'],
    ['s_city',    'shipping_address.city',  'string',  'Pune'],
];
$tis_mp_tgt = [   // [key, name, type shown, required, ok message]
    ['t_ref',    'external_ref',        'string',                 true,  'string'],
    ['t_date',   'order_date',          'date-time · UTC',        true,  'date-time · UTC'],
    ['t_cust',   'customer_id',         'string · ^C-\d{6}$',     true,  'matches ^C-\d{6}$'],
    ['t_name',   'customer_name',       'string · ≤ 80',          false, 'string · ≤ 80'],
    ['t_amount', 'amount',              'number · major units',   true,  'matches order lines · 2 × 1,249.50'],
    ['t_cur',    'currency_code',       'ISO 4217',               true,  'ISO 4217'],
    ['t_status', 'order_status',        'OPEN · INVOICED · CANCELLED', true, 'enum'],
    ['t_item',   'lines[].item_code',   'string',                 true,  'string'],
    ['t_qty',    'lines[].quantity',    'integer ≥ 1',            true,  'integer ≥ 1'],
    ['t_city',   'ship_to.city',        'string',                 false, 'string'],
];
$tis_mp_xf = [   // [key, label, chip]
    ['direct', 'Direct',                    ''],
    ['concat', 'Concat first + last name',  'concat'],
    ['lookup', 'Lookup customer ID',        'lookup'],
    ['minor',  'Minor units ÷ 100',         '÷ 100'],
    ['iso',    'Date to ISO 8601 UTC',      'ISO 8601'],
    ['enum',   'Map status enum',           'enum'],
];
$tis_mp_maps = [   // the finished flow: [source, target, transform]
    ['s_id', 't_ref', 'direct'], ['s_created', 't_date', 'iso'], ['s_email', 't_cust', 'lookup'], ['s_first', 't_name', 'concat'],
    ['s_total', 't_amount', 'minor'], ['s_cur', 't_cur', 'direct'], ['s_status', 't_status', 'enum'], ['s_sku', 't_item', 'direct'],
    ['s_qty', 't_qty', 'direct'], ['s_city', 't_city', 'direct'],
];
$tis_mp_path = array_column($tis_mp_src, 1, 0);
$tis_mp_name = array_column($tis_mp_tgt, 1, 0);
$tis_mp_to   = [];
foreach ($tis_mp_maps as $tis_mp_m) { $tis_mp_to[$tis_mp_m[0]][] = $tis_mp_name[$tis_mp_m[1]]; }
$tis_mp_json = [   // finished preview lines: [html, target key or '']
    ['{', ''],
    ['  <span class="k">"external_ref"</span>: <span class="s">"ord_8F2K41"</span>,', 't_ref'],
    ['  <span class="k">"order_date"</span>: <span class="s">"2026-09-14T16:17:03Z"</span>,', 't_date'],
    ['  <span class="k">"customer_id"</span>: <span class="s">"C-104233"</span>,', 't_cust'],
    ['  <span class="k">"customer_name"</span>: <span class="s">"Asha Rao"</span>,', 't_name'],
    ['  <span class="k">"amount"</span>: <span class="n">2499.00</span>,', 't_amount'],
    ['  <span class="k">"currency_code"</span>: <span class="s">"INR"</span>,', 't_cur'],
    ['  <span class="k">"order_status"</span>: <span class="s">"INVOICED"</span>,', 't_status'],
    ['  <span class="k">"lines"</span>: [ {', ''],
    ['    <span class="k">"item_code"</span>: <span class="s">"MUG-340-BLU"</span>,', 't_item'],
    ['    <span class="k">"quantity"</span>: <span class="n">2</span>', 't_qty'],
    ['  } ],', ''],
    ['  <span class="k">"ship_to"</span>: { <span class="k">"city"</span>: <span class="s">"Pune"</span> }', 't_city'],
    ['}', ''],
];
?>
<section class="band tis-mapper" id="mapper" aria-labelledby="mapper-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tis-kick"><b>$ flow edit order-to-erp</b> <span>agent-assisted · schema-validated</span></p>
        <h2 class="h2" id="mapper-t"><span class="g">Connect the fields.</span> Catch the mistake before it ships.</h2>
      </div>
      <div>
        <p class="lead">A storefront order has to become an ERP sales order. Pick a source field, then the field it feeds, and choose a transform. Every change is validated against the ERP’s schema, so a wrong unit or format fails here, not at month-end.</p>
        <p class="tis-mapper__try"><?= xt_icon('lightbulb', ['size' => 18]) ?><span>Try it: set the transform on <code>total_amount</code> &rarr; <code>amount</code> to Direct, and watch the validation fail.</span></p>
      </div>
    </div>

    <div class="tis-mp" data-rv data-mp-stage="done">
      <p class="bdh-sr">Interactive field mapper. Source fields from a storefront order event are listed first, then target fields of an ERP sales order. Select a source field and then a target field to connect them, choose a transform for each mapping, and review the validation results and the test delivery below. Auto-map proposes mappings with confidence scores for you to accept or reject. All data is fictional.</p>

      <div class="tis-mp__bar">
        <div class="tis-mp__flow">
          <span class="tis-mp__file"><?= xt_icon('workflow', ['size' => 18]) ?><b>order-to-erp</b><span>flow v3 · draft</span></span>
          <span class="tis-mp__state" data-mp-state><i class="tis-led" aria-hidden="true"></i><span data-mp-state-t>Valid · 10 mapped · 0 errors</span></span>
        </div>
        <div class="tis-mp__acts">
          <button type="button" class="tis-btn" data-mp-auto><?= xt_icon('agent', ['size' => 16]) ?>Auto-map</button>
          <button type="button" class="tis-btn tis-btn--ghost" data-mp-clear>Clear</button>
          <button type="button" class="tis-btn tis-btn--blue" data-mp-send><?= xt_icon('rocket', ['size' => 16, 'mono' => true]) ?>Send test event</button>
        </div>
      </div>

      <p class="tis-mp__hint" data-mp-hint aria-live="polite">Flow complete. Select any source field to change a mapping.</p>

      <div class="tis-mp__grid">
        <div class="tis-mp__col tis-mp__col--src">
          <p class="tis-mp__ch"><span>Source</span><b>Storefront · <code>order.created</code></b><em>webhook payload</em></p>
          <ul class="tis-mp__list" aria-label="Source fields">
            <?php foreach ($tis_mp_src as $tis_mp_f): $tis_mp_on = !empty($tis_mp_to[$tis_mp_f[0]]); ?>
              <li><button type="button" class="tis-mp__f tis-mp__f--src<?= $tis_mp_on ? ' is-mapped' : '' ?>" data-f="<?= e($tis_mp_f[0]) ?>" aria-pressed="false">
                <span class="tis-mp__path"><?= e($tis_mp_f[1]) ?></span>
                <span class="tis-mp__type"><?= e($tis_mp_f[2]) ?></span>
                <span class="tis-mp__val"><?= e($tis_mp_f[3]) ?></span>
                <span class="tis-mp__to" data-mp-to><?= $tis_mp_on ? '→ ' . e(implode(', ', $tis_mp_to[$tis_mp_f[0]])) : '' ?></span>
              </button></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="tis-mp__canvas" aria-hidden="true">
          <svg class="tis-mp__svg" focusable="false"></svg>
          <div class="tis-mp__chips"></div>
        </div>

        <div class="tis-mp__col tis-mp__col--tgt">
          <p class="tis-mp__ch"><span>Target</span><b>ERP · <code>POST /v2/sales-orders</code></b><em>JSON Schema 2020-12</em></p>
          <ul class="tis-mp__list" aria-label="Target fields">
            <?php foreach ($tis_mp_tgt as $tis_mp_f): ?>
              <li><button type="button" class="tis-mp__f tis-mp__f--tgt is-mapped" data-f="<?= e($tis_mp_f[0]) ?>" aria-pressed="false">
                <span class="tis-mp__path"><?= e($tis_mp_f[1]) ?></span>
                <span class="tis-mp__type"><?= e($tis_mp_f[2]) ?></span>
                <span class="tis-mp__req"><?= $tis_mp_f[3] ? 'required' : 'optional' ?></span>
              </button></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="tis-mp__maps">
        <p class="tis-mp__mh"><span>Mappings</span><b data-mp-count><?= count($tis_mp_maps) ?> of <?= count($tis_mp_tgt) ?> targets</b></p>
        <ol class="tis-mp__rows" data-mp-rows>
          <?php foreach ($tis_mp_maps as $tis_mp_m): ?>
            <li class="tis-mp__m" data-t="<?= e($tis_mp_m[1]) ?>">
              <code class="tis-mp__ms"><?= e($tis_mp_path[$tis_mp_m[0]]) ?></code>
              <span class="tis-mp__ar" aria-hidden="true">→</span>
              <span class="tis-mp__sel"><label class="bdh-sr" for="mp-xf-<?= e($tis_mp_m[1]) ?>">Transform for <?= e($tis_mp_name[$tis_mp_m[1]]) ?></label>
                <select id="mp-xf-<?= e($tis_mp_m[1]) ?>" data-mp-xf>
                  <?php foreach ($tis_mp_xf as $tis_mp_x): ?><option value="<?= e($tis_mp_x[0]) ?>"<?= $tis_mp_x[0] === $tis_mp_m[2] ? ' selected' : '' ?>><?= e($tis_mp_x[1]) ?></option><?php endforeach; ?>
                </select></span>
              <span class="tis-mp__ar tis-mp__ar2" aria-hidden="true">→</span>
              <code class="tis-mp__mt"><?= e($tis_mp_name[$tis_mp_m[1]]) ?></code>
              <span class="tis-mp__who">you</span>
              <button type="button" class="tis-mp__x" data-mp-remove aria-label="Remove mapping <?= e($tis_mp_path[$tis_mp_m[0]]) ?> to <?= e($tis_mp_name[$tis_mp_m[1]]) ?>">×</button>
            </li>
          <?php endforeach; ?>
        </ol>
        <p class="tis-mp__agent" data-mp-agent hidden><?= xt_icon('agent', ['size' => 16]) ?><span>Mapping agent proposed <b data-mp-pn>0</b> mappings from field names, sample values and the ERP schema. Nothing is applied until you accept it.</span><button type="button" class="tis-btn" data-mp-acceptall>Accept all</button></p>
      </div>

      <div class="tis-mp__out">
        <div class="tis-mp__pane tis-mp__pane--json">
          <p class="tis-mp__ph"><span>Preview</span><b>sales_order.json</b></p>
          <ol class="tis-mp__json tis-code" data-mp-json>
            <?php foreach ($tis_mp_json as $tis_mp_l): ?><li<?= $tis_mp_l[1] ? ' data-t="' . e($tis_mp_l[1]) . '"' : '' ?>><?= $tis_mp_l[0] ?></li><?php endforeach; ?>
          </ol>
        </div>

        <div class="tis-mp__pane tis-mp__pane--val">
          <p class="tis-mp__ph"><span>Validation</span><b data-mp-vsum>8 / 8 required · 0 errors</b></p>
          <ul class="tis-mp__checks" data-mp-checks aria-live="polite">
            <?php foreach ($tis_mp_tgt as $tis_mp_f): ?>
              <li class="is-ok" data-t="<?= e($tis_mp_f[0]) ?>"><i aria-hidden="true"></i><code><?= e($tis_mp_f[1]) ?></code><span><?= e($tis_mp_f[4]) ?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="tis-mp__pane tis-mp__pane--send">
          <p class="tis-mp__ph"><span>Test delivery</span><b>sandbox</b></p>
          <pre class="tis-code tis-mp__http"><span class="k">POST</span> /v2/sales-orders
<span class="c">Idempotency-Key:</span> <span class="s" data-mp-key>order.created:ord_8F2K41:r1</span>
<span class="c">Authorization:</span> Bearer •••• <span class="c">(scope sales_orders:write)</span></pre>
          <div class="tis-mp__res" data-mp-res data-code="201" aria-live="polite">
            <p class="tis-mp__code"><b data-mp-code>201 Created</b><span data-mp-ms>184 ms</span></p>
            <pre class="tis-code" data-mp-body>{ <span class="k">"id"</span>: <span class="s">"SO-2026-004187"</span>, <span class="k">"status"</span>: <span class="s">"INVOICED"</span> }</pre>
            <p class="tis-mp__rn" data-mp-note>Created once. Sending the same event again replays this result instead of creating a second order.</p>
          </div>
        </div>
      </div>
    </div>

    <p class="tis-mapper__cap" data-rv><span class="tis-ill">Fictional data</span> Every delivery carries an idempotency key, so retries with exponential backoff and jitter can never create a second order. Events that still fail after the retry budget are parked in a dead-letter queue with their validation errors attached, ready to replay once fixed.</p>
  </div>
</section>
