<?php /* DRAFT COPY — review before launch */
/* 07 Stack — the stack as the layers of the platform, drawn as an exploded slab diagram. Seven plates (Experience,
   Services, Workflow, Data stores, Analytics, Identity, Platform) are tabs; each plate is a slab (front, top and
   side faces) showing its default technology and how many others we work with there. The pane beside them holds
   the layer's why, our default, when we reach for something else, and every technology we work with there.
   At rest the slabs sit pressed together as one platform; hovering or focusing the diagram explodes them apart
   (transform only), and stack.js plays that once when the diagram first enters the screen. stack.js wires the tabs
   (arrow keys, slow auto-rotate until the first interaction or hover). Each logo is rendered once per layer, in
   the pane; the plate carries only its default mark. Logos are presented as technologies we work with, never
   as partnerships. */
$tcs_sk_layers = [   // [key, name, role, why, default, else, logo slugs (first = the plate's default mark), text-only technologies, plate default label]
    ['xp', 'Experience',  'Web, mobile and admin screens',
        'One design system, server-rendered where speed matters, and admin screens generated from the schema then refined by hand. A tool people open all day has to feel fast on a five-year-old laptop.',
        'React with Next.js and TypeScript', 'Flutter or native when the field app must work offline',
        ['react', 'nextdotjs', 'typescript', 'storybook', 'tailwindcss', 'flutter'], '', 'React · Next.js'],
    ['sv', 'Services',    'Domain services and APIs',
        'Service boundaries follow the domain model, not the org chart. The language is the one your team can hire for and run at three in the morning; we do not add a second runtime to save a week.',
        'Node.js with NestJS, or Python with FastAPI', 'Go for high-throughput services; Java with Spring or .NET where your platform team already runs them',
        ['nodedotjs', 'nestjs', 'fastapi', 'python', 'go', 'springboot', 'dotnet', 'graphql', 'openapiinitiative', 'apachekafka', 'rabbitmq'], 'Kafka and RabbitMQ carry async messages between services', 'Node.js · FastAPI'],
    ['wf', 'Workflow',    'Long-running processes',
        'Onboarding, approvals and renewals run for days and cross systems. A durable workflow engine keeps their place through deploys and outages, with retries, timeouts and compensation written once.',
        'Temporal', 'Camunda when the business wants to own the BPMN diagrams; a queue and a state table for simple jobs',
        ['temporal', 'Camunda'], '', 'Temporal'],
    ['ds', 'Data stores', 'Systems of record',
        'PostgreSQL by default: row-level security, JSONB, logical replication and decades of operational knowledge. A second store only when the access pattern demands it, and it is written down why.',
        'PostgreSQL', 'Redis for caches and rate limits; Elasticsearch or OpenSearch for search; MongoDB for document-shaped data with a real reason',
        ['postgresql', 'redis', 'elasticsearch', 'OpenSearch', 'mongodb', 'supabase'], '', 'PostgreSQL'],
    ['an', 'Analytics',   'Warehouse, models and metrics',
        'Models are tested in CI and documented from their own schema. Metrics are defined once in a semantic layer, and warehouses suspend when nobody is querying them.',
        'dbt on your cloud warehouse', 'Databricks or Spark when data science shares the platform; DuckDB for local runs and CI',
        ['dbt', 'snowflake', 'databricks', 'googlebigquery', 'apacheairflow', 'airbyte', 'apachespark', 'duckdb', 'looker', 'powerbi'], 'Apache Iceberg tables', 'dbt · your warehouse'],
    ['id', 'Identity',    'Who can do what',
        'Your identity provider is the source of truth. Single sign-on over SAML or OIDC, SCIM provisioning, short-lived tokens, and secrets in a vault rather than a config file.',
        'Your identity provider through OIDC', 'Keycloak or Auth0 when there is no enterprise identity provider yet, or for customer-facing portals',
        ['openid', 'okta', 'auth0', 'jsonwebtokens', 'vault'], 'Keycloak · Microsoft Entra ID', 'OIDC · SAML 2.0'],
    ['pf', 'Platform',    'Where it runs',
        'Everything as code, in your cloud account. Deploys are boring by design: reviewed, reversible and observed. The same Terraform builds staging and production, so surprises happen in staging.',
        'Kubernetes or a managed container service, Terraform, GitHub Actions', 'Serverless for spiky, event-driven pieces; a single VM for a tool with twenty users',
        ['kubernetes', 'terraform', 'docker', 'helm', 'argo', 'githubactions', 'amazonwebservices', 'microsoftazure', 'googlecloud', 'opentelemetry', 'grafana'], '', 'Kubernetes · Terraform'],
];
$tcs_sk_adr = [   // one architecture decision record per layer: [id, decision]
    'xp' => ['ADR-004', 'Server-render customer screens; admin screens generated from the schema'],
    'sv' => ['ADR-002', 'One service language per team; a second runtime needs a measured reason'],
    'wf' => ['ADR-007', 'Any process that outlives a request runs as a durable workflow'],
    'ds' => ['ADR-001', 'PostgreSQL is the system of record; a second store needs its own ADR'],
    'an' => ['ADR-009', 'Metrics are defined once in the semantic layer; dashboards may not redefine them'],
    'id' => ['ADR-003', 'Authorisation checked in the service, then enforced again by row-level security'],
    'pf' => ['ADR-005', 'No manual changes to production; every change is planned and applied in CI'],
];
/* Each layer's technologies render once, in its pane. The plate reuses the pane's mark for its default technology
   through <use>, so no logo is drawn twice; a name-only technology (dbt) falls back to its wordmark. */
$tcs_sk_pane = [];
$tcs_sk_mark = [];
foreach ($tcs_sk_layers as $tcs_sk_l) {
    $tcs_sk_d = $tcs_sk_l[6][0];
    $tcs_sk_n = 0;
    $tcs_sk_pane[$tcs_sk_l[0]] = preg_replace(
        '~<svg class="xt-logo"([^>]*?)data-tech="' . preg_quote($tcs_sk_d, '~') . '"~',
        '<svg id="tcs-sk-lg-' . $tcs_sk_d . '" class="xt-logo"$1data-tech="' . $tcs_sk_d . '"',
        xt_stack($tcs_sk_l[6], ['variant' => 'chips', 'size' => 16, 'label' => $tcs_sk_l[1] . ' technologies we work with']),
        1, $tcs_sk_n
    );
    $tcs_sk_mark[$tcs_sk_l[0]] = $tcs_sk_n
        ? '<svg class="tcs-sk__use" width="22" height="22" aria-hidden="true" focusable="false"><use href="#tcs-sk-lg-' . $tcs_sk_d . '" width="22" height="22"/></svg>'
        : xt_logo($tcs_sk_d, ['size' => 22, 'hidden' => true]);
}
unset($tcs_sk_l, $tcs_sk_d, $tcs_sk_n);
$tcs_sk_rules = [
    ['Boring where possible', 'Proven technology carries the platform. The interesting choices are spent where they pay: the domain model, the data contracts, the workflows.'],
    ['One store per access pattern', 'Each store is there for a measured reason. Fewer moving parts means fewer things to patch, back up and explain to an auditor.'],
    ['Everything as code', 'Infrastructure, pipelines, permissions and documentation live in repositories your team owns, reviewed like any other change.'],
];
?>
<section class="band band--alt tcs-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>The stack · as layers of the platform</p>
        <h2 class="h2" id="stack-t"><span class="g">Seven layers,</span> each chosen for a reason we can write down.</h2>
      </div>
      <div>
        <p class="lead">Every platform we build has the same shape. What changes is which technology fills each layer, and that is decided per project on what your team can run, not on what is fashionable.</p>
      </div>
    </div>

    <div class="tcs-sk" data-rv>
      <div class="tcs-sk__cake">
        <p class="tcs-sk__ck" id="stack-layers-l">Layers <em>top to bottom · select one</em></p>
        <div class="tcs-cake" role="tablist" aria-orientation="vertical" aria-labelledby="stack-layers-l" data-cake>
          <?php foreach ($tcs_sk_layers as $tcs_sk_i => $tcs_sk_l): ?>
            <button type="button" class="tcs-sk__plate" role="tab" id="stack-tab-<?= $tcs_sk_l[0] ?>" aria-controls="stack-pane-<?= $tcs_sk_l[0] ?>" aria-selected="<?= $tcs_sk_i === 3 ? 'true' : 'false' ?>" tabindex="<?= $tcs_sk_i === 3 ? '0' : '-1' ?>" style="--i:<?= $tcs_sk_i ?>">
              <span class="tcs-sk__n"><?= sprintf('%02d', $tcs_sk_i + 1) ?></span>
              <span class="tcs-sk__nm"><?= e($tcs_sk_l[1]) ?></span>
              <span class="tcs-sk__role"><?= e($tcs_sk_l[2]) ?></span>
              <span class="tcs-sk__def" aria-hidden="true">
                <span class="tcs-sk__dm"><?= $tcs_sk_mark[$tcs_sk_l[0]] ?></span>
                <span class="tcs-sk__dn"><?= e($tcs_sk_l[8]) ?></span>
                <span class="tcs-sk__dc"><?= count($tcs_sk_l[6]) ?> technologies</span>
              </span>
            </button>
          <?php endforeach; ?>
        </div>
        <p class="tcs-sk__cn"><?= xt_icon('layers', ['size' => 14, 'mono' => true]) ?>One platform, seven layers · hover or tab in to explode the stack</p>
      </div>

      <div class="tcs-sk__panes">
        <?php foreach ($tcs_sk_layers as $tcs_sk_i => $tcs_sk_l): ?>
          <div class="bdh-pane tcs-sk__pane<?= $tcs_sk_i === 3 ? ' is-on' : '' ?>" role="tabpanel" id="stack-pane-<?= $tcs_sk_l[0] ?>" aria-labelledby="stack-tab-<?= $tcs_sk_l[0] ?>" tabindex="0">
            <p class="tcs-sk__pe">Layer <?= sprintf('%02d', $tcs_sk_i + 1) ?> · <?= e($tcs_sk_l[2]) ?></p>
            <h3 class="tcs-sk__pt"><?= e($tcs_sk_l[1]) ?></h3>
            <p class="tcs-sk__why"><?= e($tcs_sk_l[3]) ?></p>
            <dl class="tcs-sk__dl">
              <div><dt>Our default</dt><dd><?= e($tcs_sk_l[4]) ?></dd></div>
              <div><dt>Something else when</dt><dd><?= e($tcs_sk_l[5]) ?></dd></div>
            </dl>
            <p class="tcs-sk__lk">Technologies we work with here</p>
            <?= $tcs_sk_pane[$tcs_sk_l[0]] ?>
            <?php if ($tcs_sk_l[7] !== ''): ?><p class="tcs-sk__also"><?= in_array($tcs_sk_l[0], ['an', 'id'], true) ? 'Also ' : '' ?><?= e($tcs_sk_l[7]) ?></p><?php endif; ?>
            <p class="tcs-sk__adr"><span class="tcs-sk__adrid"><?= xt_icon('doc', ['size' => 14, 'mono' => true]) ?><?= e($tcs_sk_adr[$tcs_sk_l[0]][0]) ?></span><span class="tcs-sk__adrt"><?= e($tcs_sk_adr[$tcs_sk_l[0]][1]) ?></span><span class="tcs-st tcs-st--ok">Accepted</span></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <ul class="tcs-sk__rules" data-rv-s>
      <?php foreach ($tcs_sk_rules as $tcs_sk_r): ?>
        <li><h3 class="tcs-sk__rt"><?= e($tcs_sk_r[0]) ?></h3><p><?= e($tcs_sk_r[1]) ?></p></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
