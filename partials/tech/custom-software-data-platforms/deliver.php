<?php /* DRAFT COPY — review before launch */
/* 12 Deliver — what you get, shown as the documentation site we hand over. A docs sidebar (a real vertical
   tablist) lists the eight deliverables; the preview pane renders each one as it actually looks: the domain
   model, the OpenAPI 3.1 reference, the data dictionary, lineage, a runbook, the access matrix, the repository
   and the Terraform plan. Everything lives in your repositories and cloud accounts. deliver.js wires the tabs
   (arrow keys, Home/End) and walks the list while on screen until the first interaction. */
$tcs_dl_items = [   // [key, icon, title, format, path in your repositories]
    ['model',  'cube',       'Domain model',          'ERD · glossary',            'docs/domain/model.md'],
    ['api',    'api',        'API reference',         'OpenAPI 3.1',               'api/openapi.yaml'],
    ['dict',   'database',   'Data dictionary',       'Every column, owned',       'docs/data/dictionary'],
    ['models', 'pipeline',   'Data models & tests',   'dbt · SQL · contracts',     'data/models/'],
    ['run',    'doc',        'Runbooks',              'Alert → action',            'docs/runbooks/'],
    ['access', 'key',        'Access matrix',         'RBAC + row-level rules',    'docs/security/access.md'],
    ['src',    'code',       'Source code',           'Your repositories',         'github.com/your-company'],
    ['iac',    'layers',     'Infrastructure as code','Terraform · CI/CD',         'infra/terraform/'],
];
$tcs_dl_dict = [   // [column, type, description, class, owner]
    ['order_id',    'uuid',          'Primary key, generated at checkout',          '—',             'orders'],
    ['account_id',  'uuid',          'Buying account; FK accounts.id',              '—',             'orders'],
    ['total',       'decimal(12,2)', 'Order value incl. tax, in account currency',  'Business',      'finance'],
    ['placed_at',   'timestamptz',   'When the customer confirmed, UTC',            '—',             'orders'],
    ['ship_email',  'text',          'Delivery notification address',               'PII.contact',   'orders'],
];
$tcs_dl_access = [   // [permission, [ops_agent, team_lead, finance, admin]] — 2 = own region only
    ['View cases',            [2, 1, 1, 1]],
    ['Bulk assign',           [0, 1, 0, 1]],
    ['Request refund',        [2, 1, 0, 0]],
    ['Approve refund > 50k',  [0, 0, 1, 0]],
    ['Export customer data',  [0, 0, 0, 1]],
    ['Edit price book',       [0, 0, 1, 0]],
];
$tcs_dl_roles = ['ops_agent', 'team_lead', 'finance', 'admin'];
?>
<section class="band band--alt tcs-deliver" id="deliver" aria-labelledby="deliver-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>Handover · documentation site</p>
        <h2 class="h2" id="deliver-t"><span class="g">What you get,</span> in your repositories from day one.</h2>
      </div>
      <div>
        <p class="lead">Nothing is handed over at the end, because nothing lives anywhere else. The code, the model, the contracts and the runbooks are written into your repositories and cloud accounts as we go, and published as one documentation site your team can search.</p>
      </div>
    </div>

    <div class="tcs-dl" data-rv>
      <div class="bdh-ui tcs-dl__win">
        <div class="bdh-ui__bar tcs-dl__bar">
          <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="tcs-dl__url">docs.your-company.internal <i>/</i> <b data-dl-path><?= e($tcs_dl_items[0][4]) ?></b></span>
          <span class="tcs-dl__search" aria-hidden="true"><?= xt_icon('search', ['size' => 13, 'mono' => true]) ?>Search docs<kbd>⌘K</kbd></span>
        </div>
        <div class="tcs-dl__body">
          <nav class="tcs-dl__nav" aria-labelledby="deliver-nav-t">
            <p class="tcs-dl__nk" id="deliver-nav-t">Your platform · docs</p>
            <div class="tcs-dl__tabs" role="tablist" aria-orientation="vertical" aria-labelledby="deliver-nav-t">
              <?php foreach ($tcs_dl_items as $tcs_dl_i => $tcs_dl_it): ?>
                <button type="button" class="tcs-dl__tab" role="tab" id="deliver-tab-<?= $tcs_dl_it[0] ?>" aria-controls="deliver-pane-<?= $tcs_dl_it[0] ?>" aria-selected="<?= $tcs_dl_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $tcs_dl_i === 0 ? '0' : '-1' ?>" data-path="<?= e($tcs_dl_it[4]) ?>">
                  <span class="tcs-dl__ti"><?= xt_icon($tcs_dl_it[1], ['size' => 16, 'mono' => true]) ?></span>
                  <span class="tcs-dl__tt"><b><?= e($tcs_dl_it[2]) ?></b><small><?= e($tcs_dl_it[3]) ?></small></span>
                </button>
              <?php endforeach; ?>
            </div>
            <p class="tcs-dl__own"><?= xt_icon('lock', ['size' => 13, 'mono' => true]) ?>Hosted in your cloud · SSO</p>
          </nav>

          <div class="tcs-dl__panes bdh-panes">
            <!-- 1 · domain model -->
            <div class="bdh-pane tcs-dl__pane is-on" role="tabpanel" id="deliver-pane-model" aria-labelledby="deliver-tab-model" tabindex="0">
              <div class="tcs-dl__ph"><h3 class="tcs-dl__pt">Domain model</h3><span class="tcs-st tcs-st--ok">v12 · migrated</span></div>
              <p class="tcs-dl__pd">The entities, relations and business terms your platform is built on, versioned with the schema so the diagram can never drift from the database.</p>
              <div class="tcs-dl__erd" aria-hidden="true">
                <?php foreach ([['Account', 'accounts', [['PK', 'id'], ['', 'name'], ['', 'tier']]], ['Order', 'orders', [['PK', 'id'], ['FK', 'account_id'], ['', 'total']]], ['Order line', 'order_lines', [['FK', 'order_id'], ['FK', 'sku'], ['', 'qty']]]] as $tcs_dl_e): ?>
                  <div class="tcs-ent tcs-dl__ent"><div class="tcs-ent__h"><b class="tcs-ent__t"><?= e($tcs_dl_e[0]) ?></b><span class="tcs-ent__tb"><?= e($tcs_dl_e[1]) ?></span></div>
                    <ul class="tcs-ent__f"><?php foreach ($tcs_dl_e[2] as $tcs_dl_f): ?><li><?php if ($tcs_dl_f[0] !== ''): ?><i class="tcs-k<?= $tcs_dl_f[0] === 'FK' ? ' tcs-k--fk' : '' ?>"><?= $tcs_dl_f[0] ?></i><?php else: ?><i></i><?php endif; ?><span><?= e($tcs_dl_f[1]) ?></span><em></em></li><?php endforeach; ?></ul>
                  </div>
                <?php endforeach; ?>
              </div>
              <dl class="tcs-dl__gl">
                <div><dt>Account</dt><dd>A legal entity that buys from you. Not a login: people are Contacts.</dd></div>
                <div><dt>Order</dt><dd>A confirmed purchase. Quotes are not orders until accepted.</dd></div>
              </dl>
              <div class="tcs-dl__chg">
                <p class="tcs-dl__ck">Model history</p>
                <ol>
                  <li><code>v12</code><span>orders.channel added as an enum: web, app, store</span><em>migration 0042 · 2 reviews</em></li>
                  <li><code>v11</code><span>consents split by purpose, one row per purpose</span><em>migration 0039 · 2 reviews</em></li>
                  <li><code>v10</code><span>cases may refer to one order (0..1)</span><em>migration 0035 · 1 review</em></li>
                </ol>
              </div>
            </div>

            <!-- 2 · API reference -->
            <div class="bdh-pane tcs-dl__pane" role="tabpanel" id="deliver-pane-api" aria-labelledby="deliver-tab-api" tabindex="0">
              <div class="tcs-dl__ph"><h3 class="tcs-dl__pt">API reference</h3><span class="tcs-st tcs-st--ok">OpenAPI 3.1 · linted</span></div>
              <p class="tcs-dl__pd">Generated from the spec the services are tested against, with typed clients for the web app and your integrations.</p>
              <ul class="tcs-dl__eps" aria-label="Endpoints">
                <li><b class="is-get">GET</b><code>/v1/accounts/{id}</code><span>Read an account</span></li>
                <li><b class="is-post">POST</b><code>/v1/orders</code><span>Place an order · idempotency key</span></li>
                <li><b class="is-patch">PATCH</b><code>/v1/cases/{id}</code><span>Update a case · If-Match</span></li>
                <li><b class="is-get">GET</b><code>/v1/customers/{id}/profile</code><span>Golden profile · consent-aware</span></li>
              </ul>
<pre class="tcs-dl__code" aria-label="Excerpt of the OpenAPI specification"><code><span class="k">/v1/orders:</span>
  <span class="k">post:</span>
    operationId: placeOrder
    security: [{ oidc: [orders.write] }]
    parameters: [{ $ref: '#/components/parameters/IdempotencyKey' }]
    responses:
      <span class="s">'201'</span>: { $ref: '#/components/responses/Order' }
      <span class="s">'409'</span>: { description: Request with this key in progress }
      <span class="s">'422'</span>: { description: Same key, different body }</code></pre>
            </div>

            <!-- 3 · data dictionary -->
            <div class="bdh-pane tcs-dl__pane" role="tabpanel" id="deliver-pane-dict" aria-labelledby="deliver-tab-dict" tabindex="0">
              <div class="tcs-dl__ph"><h3 class="tcs-dl__pt">Data dictionary <span class="tcs-dl__pts">silver.orders</span></h3><span class="tcs-st tcs-st--ok">5 of 5 described</span></div>
              <p class="tcs-dl__pd">Every column with its type, meaning, classification and owner. Descriptions are drafted by agents from the schema and approved by the owner.</p>
              <div class="tcs-dl__tw">
                <table class="tcs-dl__tbl">
                  <thead><tr><th scope="col">Column</th><th scope="col">Type</th><th scope="col">Description</th><th scope="col">Class</th><th scope="col">Owner</th></tr></thead>
                  <tbody>
                    <?php foreach ($tcs_dl_dict as $tcs_dl_r): ?>
                      <tr><th scope="row"><?= e($tcs_dl_r[0]) ?></th><td><?= e($tcs_dl_r[1]) ?></td><td><?= e($tcs_dl_r[2]) ?></td><td><?= $tcs_dl_r[3] === '—' ? '—' : '<span class="tcs-dl__cls">' . e($tcs_dl_r[3]) . '</span>' ?></td><td><?= e($tcs_dl_r[4]) ?></td></tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- 4 · data models -->
            <div class="bdh-pane tcs-dl__pane" role="tabpanel" id="deliver-pane-models" aria-labelledby="deliver-tab-models" tabindex="0">
              <div class="tcs-dl__ph"><h3 class="tcs-dl__pt">Data models &amp; tests</h3><span class="tcs-st tcs-st--ok">CI · 412 tests passing</span></div>
              <p class="tcs-dl__pd">Every transformation is SQL in version control, tested on each pull request and documented from its own schema. Gold models carry an enforced contract, so a breaking change fails the build instead of a dashboard.</p>
              <div class="tcs-dl__tw">
                <table class="tcs-dl__tbl tcs-dl__mdl">
                  <thead><tr><th scope="col">Model</th><th scope="col">Materialised</th><th scope="col">Tests</th><th scope="col">Contract</th><th scope="col">Owner</th></tr></thead>
                  <tbody>
                    <tr><th scope="row">gold.fct_revenue</th><td>incremental</td><td>18</td><td><span class="tcs-dl__cls">enforced · v3</span></td><td>finance</td></tr>
                    <tr><th scope="row">gold.dim_customer</th><td>incremental</td><td>22</td><td><span class="tcs-dl__cls">enforced · v4</span></td><td>growth</td></tr>
                    <tr><th scope="row">silver.orders</th><td>incremental</td><td>14</td><td><span class="tcs-dl__cls">enforced · v3</span></td><td>orders</td></tr>
                    <tr><th scope="row">silver.refunds</th><td>table</td><td>9</td><td>—</td><td>finance</td></tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- 5 · runbooks -->
            <div class="bdh-pane tcs-dl__pane" role="tabpanel" id="deliver-pane-run" aria-labelledby="deliver-tab-run" tabindex="0">
              <div class="tcs-dl__ph"><h3 class="tcs-dl__pt">Runbook <span class="tcs-dl__pts">orders CDC lag</span></h3><span class="tcs-st">Reviewed 12 days ago</span></div>
              <p class="tcs-dl__pd">One page per alert: what it means, how bad it is, and the exact steps, written for the person on call at night.</p>
              <div class="tcs-dl__rb">
                <p class="tcs-dl__rt"><b>Alert</b><code>cdc_lag_seconds{table="orders"} &gt; 300 for 10m</code></p>
                <p class="tcs-dl__rt"><b>Impact</b><span>Dashboards and the CRM show orders late. Nothing is lost; Kafka retains 7 days.</span></p>
                <ol class="tcs-dl__steps">
                  <li>Check connector status in the Kafka Connect dashboard.</li>
                  <li>If the task failed, restart it through the Kafka Connect REST API: <code>curl -X POST "$CONNECT_URL/connectors/orders-cdc/restart?includeTasks=true&amp;onlyFailed=true"</code></li>
                  <li>If the replication slot is growing, page the database owner.</li>
                  <li>Confirm lag falls below 60 s, then resolve with a note.</li>
                </ol>
              </div>
            </div>

            <!-- 6 · access matrix -->
            <div class="bdh-pane tcs-dl__pane" role="tabpanel" id="deliver-pane-access" aria-labelledby="deliver-tab-access" tabindex="0">
              <div class="tcs-dl__ph"><h3 class="tcs-dl__pt">Access matrix</h3><span class="tcs-st tcs-st--ok">Mapped to controls</span></div>
              <p class="tcs-dl__pd">Who can do what, enforced in the application and in the database, and reviewed each quarter against your identity provider’s groups.</p>
              <div class="tcs-dl__tw">
                <table class="tcs-dl__tbl tcs-dl__acc">
                  <thead><tr><th scope="col">Permission</th><?php foreach ($tcs_dl_roles as $tcs_dl_ro): ?><th scope="col"><?= e($tcs_dl_ro) ?></th><?php endforeach; ?></tr></thead>
                  <tbody>
                    <?php foreach ($tcs_dl_access as $tcs_dl_a): ?>
                      <tr><th scope="row"><?= e($tcs_dl_a[0]) ?></th><?php foreach ($tcs_dl_a[1] as $tcs_dl_v): ?><td><?= $tcs_dl_v === 1 ? '<span class="tcs-dl__y" aria-hidden="true">✓</span><span class="bdh-sr">Allowed</span>' : ($tcs_dl_v === 2 ? '<span class="tcs-dl__r">own region</span>' : '<span class="tcs-dl__n" aria-hidden="true">–</span><span class="bdh-sr">Not allowed</span>') ?></td><?php endforeach; ?></tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- 7 · source code -->
            <div class="bdh-pane tcs-dl__pane" role="tabpanel" id="deliver-pane-src" aria-labelledby="deliver-tab-src" tabindex="0">
              <div class="tcs-dl__ph"><h3 class="tcs-dl__pt">Source code</h3><span class="tcs-st tcs-st--ok">main · checks passing</span></div>
              <p class="tcs-dl__pd">In your organisation’s repositories from the first commit, with branch protection, required reviews and a changelog. No code sits in ours.</p>
              <div class="tcs-dl__repo">
                <ul class="tcs-dl__tree" aria-label="Repository layout">
                  <li><b>apps/</b><span>web · admin</span></li>
                  <li><b>services/</b><span>accounts · orders · cases</span></li>
                  <li><b>workflows/</b><span>Temporal definitions</span></li>
                  <li><b>data/</b><span>dbt models · contracts</span></li>
                  <li><b>infra/</b><span>Terraform · Helm</span></li>
                  <li><b>docs/</b><span>this site</span></li>
                </ul>
                <ol class="tcs-dl__commits" aria-label="Recent commits">
                  <li><code>a41f2c9</code><span>orders: idempotent place order</span><em>2 reviews</em></li>
                  <li><code>9f07e11</code><span>cases: bulk assign preview</span><em>2 reviews</em></li>
                  <li><code>71be3d0</code><span>data: contract v3 for silver.orders</span><em>1 review</em></li>
                </ol>
              </div>
            </div>

            <!-- 8 · infrastructure as code -->
            <div class="bdh-pane tcs-dl__pane" role="tabpanel" id="deliver-pane-iac" aria-labelledby="deliver-tab-iac" tabindex="0">
              <div class="tcs-dl__ph"><h3 class="tcs-dl__pt">Infrastructure as code</h3><span class="tcs-st tcs-st--ok">No drift</span></div>
              <p class="tcs-dl__pd">The same Terraform builds staging and production in your cloud account. Every change is planned in CI, reviewed and applied by the pipeline, never by hand.</p>
<pre class="tcs-dl__code tcs-dl__term" aria-label="Terraform plan output"><code><span class="c">$ terraform plan -out=release-42</span>
  <span class="s">~</span> module.orders.aws_ecs_service.api
      desired_count: 3 → 4
  <span class="s">~</span> module.data.snowflake_warehouse.bi
      auto_suspend:  3600 → 60
<span class="k">Plan:</span> 0 to add, 2 to change, 0 to destroy.</code></pre>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
