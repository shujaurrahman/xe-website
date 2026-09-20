<?php /* DRAFT COPY — review before launch */
/* Catalogue — the systems we connect, as a connector directory that works like the real thing.
   Search and a category filter narrow a compact grid of connectors (FLIP reflow and an announced
   count in catalogue.js). Selecting one opens its connector sheet: what typically syncs, how
   (API, webhooks, CDC, iPaaS), direction, trigger, freshness and the one thing that catches teams
   out with that system. Marks come from the shared logo library; systems without a licence-clean
   mark show their category icon, never a drawn logo. Technologies we work with; no partner status
   is implied. HTML = every connector listed, Shopify's sheet open. */
$tis_ca_cats = [   // key => [label, fallback icon for systems without a library mark]
    'crm' => ['CRM', 'users'], 'erp' => ['ERP & finance', 'database'], 'commerce' => ['Commerce', 'browser'],
    'payments' => ['Payments', 'cost'], 'support' => ['Support', 'headset'], 'marketing' => ['Marketing', 'target'],
    'data' => ['Data', 'layers'], 'collab' => ['Collaboration', 'chat'], 'identity' => ['Identity', 'key'],
];
/* [name, library slug or null, category, [objects], [methods], direction two|in|out, trigger, freshness, watch out for] */
$tis_ca_list = [
    ['Salesforce', 'salesforce', 'crm', ['Accounts', 'Contacts', 'Opportunities', 'Orders'], ['Change Data Capture', 'Bulk API 2.0', 'REST'], 'two', 'Change events', 'Seconds',
        'Every org has a rolling 24-hour API allocation. Large loads go through Bulk API 2.0, and change events are kept for 72 hours, so a stalled consumer can catch up without a full resync.'],
    ['HubSpot', 'hubspot', 'crm', ['Contacts', 'Companies', 'Deals', 'Consent'], ['Webhooks', 'CRM API v3', 'Batch endpoints'], 'two', 'Webhooks', 'Seconds',
        'Apps have burst limits per 10-second window. Batch endpoints write up to 100 records per call, which keeps a large sync inside them.'],
    ['Zoho CRM', 'zoho', 'crm', ['Leads', 'Accounts', 'Deals', 'Invoices'], ['REST', 'Notifications', 'Bulk API'], 'two', 'Notifications', 'Seconds',
        'API calls draw on a credit pool that resets every 24 hours and depends on edition and licences, so bulk reads use the Bulk API rather than paging.'],
    ['Microsoft Dynamics 365', null, 'crm', ['Accounts', 'Contacts', 'Cases', 'Orders'], ['Dataverse Web API', 'OData v4', 'Webhooks'], 'two', 'Webhooks', 'Seconds',
        'Service protection limits answer bursts with 429 and a Retry-After header. The connector waits as told instead of retrying blind.'],
    ['SAP S/4HANA', 'sap', 'erp', ['Sales orders', 'Materials', 'Stock', 'Invoices'], ['OData APIs', 'IDoc', 'BAPI'], 'two', 'Events or batch', 'Minutes',
        'Released APIs or middleware only, never direct table writes. That keeps upgrades safe and the core clean.'],
    ['Oracle NetSuite', null, 'erp', ['Customers', 'Items', 'Sales orders', 'Invoices'], ['SuiteTalk REST', 'SuiteQL', 'RESTlets'], 'two', 'Scheduled + events', 'Minutes',
        'Accounts have concurrency limits, so writes are queued and batched rather than fired in parallel.'],
    ['Tally', null, 'erp', ['Ledgers', 'Vouchers', 'Stock items'], ['XML over HTTP', 'ODBC', 'Batch'], 'two', 'Scheduled batch', '15 min to nightly',
        'Tally usually runs on a machine on site. A small agent there posts vouchers in batches and reports back exactly which were accepted.'],
    ['Odoo', null, 'erp', ['Sales orders', 'Products', 'Stock moves', 'Invoices'], ['JSON-RPC', 'XML-RPC', 'Webhooks'], 'two', 'Automation webhooks', 'Seconds',
        'Custom modules change the data model, so the mapping reads the fields that exist at build time instead of assuming the defaults.'],
    ['Shopify', 'shopify', 'commerce', ['Orders', 'Products', 'Inventory', 'Customers'], ['Webhooks', 'GraphQL Admin API'], 'two', 'Webhooks', 'Seconds',
        'Webhooks can arrive more than once or out of order. Each one is verified by its HMAC signature and de-duplicated by ID, and a reconciliation sweep catches any that never arrived.'],
    ['WooCommerce', 'woocommerce', 'commerce', ['Orders', 'Products', 'Stock'], ['REST', 'Webhooks'], 'two', 'Webhooks', 'Seconds',
        'WooCommerce disables a webhook after five consecutive failed deliveries, so the receiver answers fast and a health check alerts if one goes quiet.'],
    ['Adobe Commerce (Magento)', null, 'commerce', ['Orders', 'Catalogue', 'Customers', 'Stock'], ['REST', 'GraphQL', 'Async bulk API'], 'two', 'Events and queues', 'Seconds to minutes',
        'Large catalogue updates use the asynchronous bulk API, which queues them through RabbitMQ instead of blocking the storefront.'],
    ['Stripe', 'stripe', 'payments', ['Payments', 'Refunds', 'Payouts', 'Disputes'], ['Webhooks', 'REST'], 'two', 'Webhooks', 'Seconds',
        'Every write carries an Idempotency-Key and every webhook is checked against its Stripe-Signature. Events can arrive out of order, so state is read from the object, not the arrival sequence.'],
    ['Razorpay', 'razorpay', 'payments', ['Payments', 'Orders', 'Refunds', 'Settlements'], ['Webhooks', 'REST'], 'two', 'Webhooks', 'Seconds · settlements daily',
        'Webhooks are verified with the X-Razorpay-Signature header, and settlements are reconciled against the ledger every day, UPI included.'],
    ['PayPal', 'paypal', 'payments', ['Orders', 'Captures', 'Refunds', 'Disputes'], ['Webhooks', 'Orders v2 API'], 'two', 'Webhooks', 'Seconds',
        'Disputes can open weeks after a sale, so they attach to the original order rather than creating a new record.'],
    ['Zendesk', 'zendesk', 'support', ['Tickets', 'Users', 'Organisations'], ['REST', 'Webhooks', 'Incremental exports'], 'two', 'Webhooks + triggers', 'Seconds',
        'Rate limits are per minute and vary by plan. Bulk reads use the incremental export endpoints instead of paging through every ticket.'],
    ['Freshdesk', null, 'support', ['Tickets', 'Contacts', 'Companies'], ['REST', 'Webhooks'], 'two', 'Automation webhooks', 'Seconds',
        'Responses report the calls left in the current minute, so the connector paces itself before it is throttled.'],
    ['Intercom', 'intercom', 'support', ['Conversations', 'Contacts', 'Companies', 'Events'], ['Webhooks', 'REST'], 'two', 'Webhooks', 'Seconds',
        'Custom attributes are the join key between product events and conversations, so they are named and typed in the contract, not created ad hoc.'],
    ['Mailchimp', null, 'marketing', ['Audiences', 'Tags', 'Consent', 'Campaign events'], ['Marketing API', 'Batch operations', 'Webhooks'], 'two', 'Webhooks + batch', 'Minutes',
        'Unsubscribes and cleaned addresses flow back to the CRM, so no other system can email someone who opted out.'],
    ['Braze', null, 'marketing', ['Users', 'Events', 'Purchases'], ['REST', 'Currents'], 'two', 'Streaming', 'Seconds to minutes',
        'Currents streams engagement events out to the warehouse; user updates are batched per request to stay inside rate limits.'],
    ['Google Analytics 4', 'googleanalytics', 'marketing', ['Purchases', 'Refunds'], ['Measurement Protocol'], 'out', 'Server events', 'Seconds',
        'Server-side purchases carry the same transaction_id as the browser tag, so GA4 counts each purchase once and reports match the ledger.'],
    ['Snowflake', 'snowflake', 'data', ['Orders', 'Customers', 'Events', 'Stock'], ['Snowpipe Streaming', 'Kafka connector', 'CDC'], 'in', 'Streaming', 'Seconds to a minute',
        'Rows land in raw tables first and are modelled afterwards, so a change upstream never corrupts what is already loaded.'],
    ['Google BigQuery', 'googlebigquery', 'data', ['Events', 'Orders', 'Customers'], ['Storage Write API', 'Streaming'], 'in', 'Streaming', 'Seconds',
        'The Storage Write API supports exactly-once writes with stream offsets, so a retried batch never double-counts revenue.'],
    ['PostgreSQL', 'postgresql', 'data', ['Any table'], ['Logical replication', 'Debezium'], 'out', 'Change data capture', 'Seconds',
        'Replication slots are monitored. An idle slot keeps WAL on disk, so lag alerts long before storage fills.'],
    ['Airbyte', 'airbyte', 'data', ['Source-dependent'], ['ELT connectors'], 'in', 'Scheduled', 'Minutes to hourly',
        'Used where a maintained connector already exists; custom code where it does not, or where volume makes a managed sync the expensive option.'],
    ['Slack', null, 'collab', ['Alerts', 'Approvals', 'Incident channels'], ['Web API', 'Events API', 'Webhooks'], 'two', 'Events', 'Seconds',
        'Approvals use interactive messages with the approver’s identity recorded, so a click in a channel is an audited decision.'],
    ['Microsoft Teams', null, 'collab', ['Alerts', 'Approvals', 'Channel messages'], ['Workflows', 'Graph API'], 'two', 'Events', 'Seconds',
        'New alerts are built on Workflows and the Graph API rather than the retiring Office 365 connectors.'],
    ['Jira', 'jira', 'collab', ['Issues', 'Incidents', 'Comments'], ['REST', 'Webhooks'], 'two', 'Webhooks', 'Seconds',
        'Incidents and improvement items link both ways, so the support backlog and the engineering board never drift apart.'],
    ['WhatsApp Business', 'whatsapp', 'collab', ['Order updates', 'Delivery notices', 'One-time codes'], ['Cloud API', 'Templates', 'Webhooks'], 'two', 'Events', 'Seconds',
        'Outside the 24-hour customer service window, only pre-approved message templates can be sent, so every notification is designed as one.'],
    ['Okta', 'okta', 'identity', ['Users', 'Groups', 'App assignments'], ['SCIM 2.0', 'OIDC', 'Event hooks'], 'out', 'Provisioning events', 'Seconds',
        'Joiners, movers and leavers provision through SCIM, so access to every integration console ends the day someone leaves.'],
    ['Auth0', 'auth0', 'identity', ['Customer identities', 'Roles'], ['OIDC', 'OAuth 2.0', 'Actions'], 'two', 'Events', 'Seconds',
        'Machine-to-machine calls use the client credentials grant with scopes per integration, never a shared admin key.'],
    ['Microsoft Entra ID', null, 'identity', ['Users', 'Groups'], ['SCIM provisioning', 'Microsoft Graph'], 'out', 'Provisioning cycles', 'About 40 min',
        'Provisioning runs in cycles of roughly 40 minutes, so urgent removals are pushed on demand rather than left to the next cycle.'],
];
$tis_ca_dir = ['two' => ['Two-way', '⇄'], 'in' => ['Into it', '→'], 'out' => ['Out of it', '←']];
$tis_ca_counts = array_count_values(array_column($tis_ca_list, 2));
$tis_ca_open = 8;   // Shopify: the storefront from the mapper above
$tis_ca_mark = function (array $c, int $size) use ($tis_ca_cats): string {
    return $c[1] && xt_tech($c[1]) && xt_tech($c[1])['file']
        ? xt_logo($c[1], ['size' => $size, 'hidden' => true])
        : '<span class="tis-ca__ico">' . xt_icon($tis_ca_cats[$c[2]][1], ['size' => (int) round($size * .8), 'mono' => true]) . '</span>';
};
$tis_ca_o = $tis_ca_list[$tis_ca_open];
?>
<section class="band band--alt tis-catalogue" id="catalogue" aria-labelledby="catalogue-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tis-kick"><b>$ connectors search</b> <span><?= count($tis_ca_list) ?> systems · <?= count($tis_ca_cats) ?> categories</span></p>
        <h2 class="h2" id="catalogue-t"><span class="g">Systems we connect,</span> searchable.</h2>
      </div>
      <div>
        <p class="lead">Search the systems your estate already runs on, then open one to see what typically moves, how, and the detail that catches teams out. Not listed does not mean not possible: we build against any documented API, and against databases without one.</p>
      </div>
    </div>

    <div class="tis-ca" data-rv>
      <div class="tis-ca__bar">
        <div class="tis-ca__search">
          <label class="bdh-sr" for="catalogue-q">Search connectors</label>
          <?= xt_icon('search', ['size' => 18, 'mono' => true]) ?>
          <input id="catalogue-q" type="search" placeholder="Search a system, a category or what it syncs" autocomplete="off" spellcheck="false" data-ca-q aria-describedby="catalogue-count">
          <button type="button" class="tis-ca__clear" data-ca-clear hidden aria-label="Clear search">×</button>
        </div>
        <p class="tis-ca__count" id="catalogue-count" role="status" aria-live="polite" data-ca-count><b><?= count($tis_ca_list) ?></b> of <?= count($tis_ca_list) ?> connectors</p>
      </div>

      <div class="tis-ca__cats" role="group" aria-label="Filter by category">
        <button type="button" class="tis-ca__cat" data-ca-cat="all" aria-pressed="true">All <span><?= count($tis_ca_list) ?></span></button>
        <?php foreach ($tis_ca_cats as $tis_ca_k => $tis_ca_c): ?>
          <button type="button" class="tis-ca__cat" data-ca-cat="<?= e($tis_ca_k) ?>" aria-pressed="false"><?= e($tis_ca_c[0]) ?> <span><?= (int) ($tis_ca_counts[$tis_ca_k] ?? 0) ?></span></button>
        <?php endforeach; ?>
      </div>

      <div class="tis-ca__body">
        <div class="tis-ca__list">
          <ul class="tis-ca__grid" data-ca-grid aria-label="Connectors">
            <?php foreach ($tis_ca_list as $tis_ca_i => $tis_ca_c):
                $tis_ca_q = mb_strtolower($tis_ca_c[0] . ' ' . $tis_ca_cats[$tis_ca_c[2]][0] . ' ' . implode(' ', $tis_ca_c[3]) . ' ' . implode(' ', $tis_ca_c[4]) . ' ' . $tis_ca_c[6]); ?>
              <li class="tis-ca__item" data-ca-k="<?= $tis_ca_i ?>" data-ca-cat="<?= e($tis_ca_c[2]) ?>" data-ca-q="<?= e($tis_ca_q) ?>">
                <button type="button" class="tis-ca__tile" data-ca-open="<?= $tis_ca_i ?>" aria-pressed="<?= $tis_ca_i === $tis_ca_open ? 'true' : 'false' ?>" aria-controls="catalogue-sheet">
                  <span class="tis-ca__mark"><?= $tis_ca_mark($tis_ca_c, 22) ?></span>
                  <span class="tis-ca__tt"><span class="tis-ca__n"><?= e($tis_ca_c[0]) ?></span><span class="tis-ca__m"><?= e($tis_ca_c[4][0]) ?> · <?= e($tis_ca_dir[$tis_ca_c[5]][0]) ?></span></span>
                </button>
              </li>
            <?php endforeach; ?>
          </ul>
          <p class="tis-ca__empty" data-ca-empty hidden><?= xt_icon('plug', ['size' => 20]) ?><span>No connector matches <b data-ca-term></b>. That does not mean no: we build against any documented API, and against databases without one through change data capture. <a href="<?= xe_url('contact.php') ?>">Ask about your system</a>.</span></p>
        </div>

        <article class="tis-ca__sheet" id="catalogue-sheet" aria-live="polite" aria-labelledby="catalogue-sheet-t" data-ca-sheet>
          <div class="tis-ca__sh">
            <span class="tis-ca__big" data-ca-mark><?= $tis_ca_mark($tis_ca_o, 30) ?></span>
            <div>
              <p class="tis-ca__cat2" data-ca-c><?= e($tis_ca_cats[$tis_ca_o[2]][0]) ?> · connector sheet</p>
              <h3 class="tis-ca__st" id="catalogue-sheet-t" data-ca-name><?= e($tis_ca_o[0]) ?></h3>
            </div>
          </div>

          <div class="tis-ca__flow" aria-hidden="true">
            <span class="tis-ca__node">Your platform</span>
            <span class="tis-ca__wire" data-ca-dirc="<?= e($tis_ca_o[5]) ?>"><i></i><b data-ca-trig><?= e($tis_ca_o[6]) ?></b></span>
            <span class="tis-ca__node tis-ca__node--sys" data-ca-name2><?= e($tis_ca_o[0]) ?></span>
          </div>

          <dl class="tis-ca__facts">
            <div><dt>Direction</dt><dd data-ca-dir><?= e($tis_ca_dir[$tis_ca_o[5]][0]) ?></dd></div>
            <div><dt>Trigger</dt><dd data-ca-trig2><?= e($tis_ca_o[6]) ?></dd></div>
            <div><dt>Freshness</dt><dd data-ca-fresh><?= e($tis_ca_o[7]) ?></dd></div>
          </dl>

          <p class="tis-ca__k">What typically syncs</p>
          <ul class="tis-ca__chips" data-ca-objs><?php foreach ($tis_ca_o[3] as $tis_ca_x): ?><li><?= e($tis_ca_x) ?></li><?php endforeach; ?></ul>
          <p class="tis-ca__k">How</p>
          <ul class="tis-ca__chips tis-ca__chips--how" data-ca-how><?php foreach ($tis_ca_o[4] as $tis_ca_x): ?><li><?= e($tis_ca_x) ?></li><?php endforeach; ?></ul>

          <div class="tis-ca__watch">
            <p class="tis-ca__k"><?= xt_icon('alert', ['size' => 16]) ?>Watch out for</p>
            <p data-ca-watch><?= e($tis_ca_o[8]) ?></p>
          </div>
        </article>
      </div>

      <script type="application/json" data-ca-data><?= json_encode(array_map(fn ($tis_ca_c) => [
          'n' => $tis_ca_c[0], 'c' => $tis_ca_cats[$tis_ca_c[2]][0], 'o' => $tis_ca_c[3], 'h' => $tis_ca_c[4],
          'd' => $tis_ca_c[5], 'dl' => $tis_ca_dir[$tis_ca_c[5]][0], 't' => $tis_ca_c[6], 'f' => $tis_ca_c[7], 'w' => $tis_ca_c[8],
      ], $tis_ca_list), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
      <template data-ca-marks><?php foreach ($tis_ca_list as $tis_ca_i => $tis_ca_c): ?><span data-k="<?= $tis_ca_i ?>"><?= $tis_ca_mark($tis_ca_c, 30) ?></span><?php endforeach; ?></template>
    </div>

    <p class="tis-ca__note" data-rv>Technologies we work with, shown with their own marks where the licence allows and a category icon where it does not. No partnership, certification or reseller status is implied. Vendor limits change; each connector is checked against current documentation when it is built.</p>
  </div>
</section>
