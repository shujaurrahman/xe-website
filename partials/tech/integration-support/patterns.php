<?php /* DRAFT COPY — review before launch */
/* Patterns — four integration patterns as working diagrams on ink. Tabs: request–response, event-driven,
   change data capture, iPaaS workflow. Each pane: an animated diagram with a real control (simulate a
   timeout, fail a consumer and replay its dead-letter queue, change a row, run a workflow with a failing
   step), a live log, when to use it, how failures are handled and the technologies it runs on.
   patterns.js moves packets only while the band is on screen. HTML = readable final state. */
$tis_pt_node = function (string $id, float $x, float $y, float $w, float $h, string $t, string $sub, string $cls = ''): string {
    return '<g class="tis-pt__n' . ($cls ? ' ' . $cls : '') . '" data-n="' . e($id) . '">'
         . '<rect x="' . $x . '" y="' . $y . '" width="' . $w . '" height="' . $h . '" rx="10"/>'
         . '<text class="tis-pt__nt" x="' . ($x + 14) . '" y="' . ($y + $h / 2 - 3) . '">' . e($t) . '</text>'
         . '<text class="tis-pt__ns" x="' . ($x + 14) . '" y="' . ($y + $h / 2 + 13) . '" data-sub>' . e($sub) . '</text></g>';
};
$tis_pt_edge = function (string $id, string $d, string $cls = ''): string {
    return '<path class="tis-pt__e' . ($cls ? ' ' . $cls : '') . '" data-e="' . e($id) . '" d="' . e($d) . '"/>';
};
$tis_pt_word = fn (string $n): string => '<li class="tis-pt__w"><span class="tis-word">' . e($n) . '</span></li>';
$tis_pt_tabs = [   // [id, name, meta]
    ['rr',   'Request–response', 'Synchronous · milliseconds'],
    ['ev',   'Event-driven',     'Publish · subscribe'],
    ['cdc',  'Change data capture', 'Database log → stream'],
    ['ipaas','iPaaS workflow',   'Managed connectors'],
];
?>
<section class="band band--ink tis-patterns" id="patterns" aria-labelledby="patterns-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tis-kick"><b>$ pattern choose --per-flow</b> <span>four patterns · one monitoring stack</span></p>
        <h2 class="h2" id="patterns-t"><span class="g">The right pattern</span> for each connection.</h2>
      </div>
      <div>
        <p class="lead">Not every flow should be an event, and not every sync needs a platform. We choose per connection, on latency, volume, data ownership and what must happen when the other side is down.</p>
      </div>
    </div>

    <div class="tis-pt" data-rv>
      <div class="bdh-tabs tis-pt__tabs" role="tablist" aria-label="Integration patterns">
        <?php foreach ($tis_pt_tabs as $tis_pt_i => $tis_pt_t): ?>
          <button type="button" role="tab" id="patterns-tab-<?= $tis_pt_t[0] ?>" aria-controls="patterns-p-<?= $tis_pt_t[0] ?>" aria-selected="<?= $tis_pt_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $tis_pt_i === 0 ? '0' : '-1' ?>">
            <span class="tis-pt__ti"><?= sprintf('%02d', $tis_pt_i + 1) ?></span><span class="tis-pt__tn"><?= e($tis_pt_t[1]) ?></span><span class="tis-pt__tm"><?= e($tis_pt_t[2]) ?></span>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="bdh-panes tis-pt__panes">

        <!-- 01 request–response -->
        <div class="bdh-pane tis-pt__pane is-on" id="patterns-p-rr" role="tabpanel" aria-labelledby="patterns-tab-rr" data-pane="rr">
          <div class="tis-pt__stage">
            <div class="tis-panel tis-pt__panel">
              <div class="tis-panel__bar"><span><b>GET /v1/stock/MUG-340-BLU</b> · checkout waits for the answer</span><button type="button" class="tis-btn" data-pt-act="timeout">Simulate ERP timeout</button></div>
              <div class="tis-pt__scroll bdh-scroll-x" tabindex="0" aria-label="Request–response diagram, scroll sideways">
                <svg class="tis-pt__svg" viewBox="0 0 720 300" aria-hidden="true" focusable="false">
                  <text class="tis-pt__ann" x="10" y="22">p95 latency budget · 300 ms</text>
                  <text class="tis-pt__ann is-r" x="710" y="22" text-anchor="end" data-rr-ms>measured 212 ms</text>
                  <rect class="tis-pt__bud" x="10" y="32" width="700" height="8" rx="4"/>
                  <rect class="tis-pt__bud tis-pt__bud--g" x="10" y="32" width="28" height="8" rx="2"/>
                  <rect class="tis-pt__bud tis-pt__bud--a" x="40" y="32" width="60" height="8" rx="2"/>
                  <rect class="tis-pt__bud tis-pt__bud--e" x="102" y="32" width="402" height="8" rx="2"/>
                  <text class="tis-pt__ann" x="10" y="58">gateway 12 ms</text><text class="tis-pt__ann" x="126" y="58">stock API 26 ms</text><text class="tis-pt__ann" x="262" y="58">ERP 174 ms</text>
                  <?= $tis_pt_edge('c-g', 'M130 142 H170') ?><?= $tis_pt_edge('g-c', 'M170 162 H130', 'is-back') ?>
                  <?= $tis_pt_edge('g-s', 'M320 142 H360') ?><?= $tis_pt_edge('s-g', 'M360 162 H320', 'is-back') ?>
                  <?= $tis_pt_edge('s-e', 'M530 142 H570') ?><?= $tis_pt_edge('e-s', 'M570 162 H530', 'is-back') ?>
                  <?= $tis_pt_edge('s-k', 'M437 184 V232', 'is-dash') ?><?= $tis_pt_edge('k-s', 'M453 232 V184', 'is-dash is-back') ?>
                  <?= $tis_pt_node('client', 10, 120, 120, 64, 'Checkout', 'client app') ?>
                  <?= $tis_pt_node('gw', 170, 120, 150, 64, 'API gateway', 'OAuth · rate limit') ?>
                  <?= $tis_pt_node('svc', 360, 120, 170, 64, 'Stock API', 'REST · timeout 800 ms') ?>
                  <?= $tis_pt_node('erp', 570, 120, 140, 64, 'ERP', 'system of record') ?>
                  <?= $tis_pt_node('cache', 360, 232, 170, 56, 'Stock cache', 'fallback · TTL 60 s', 'is-quiet') ?>
                  <text class="tis-pt__ann" x="420" y="106" data-breaker>circuit breaker · closed</text>
                </svg>
              </div>
              <ol class="tis-pt__log" data-pt-log aria-live="polite">
                <li><b>200</b> GET /v1/stock/MUG-340-BLU · 212 ms</li>
                <li><b>504</b> ERP timeout after 800 ms · retry 1 in 180 ms (backoff + jitter)</li>
                <li><b>200</b> retry 1 succeeded · 246 ms · total 1.23 s</li>
              </ol>
            </div>
          </div>
          <div class="tis-pt__side">
            <h3 class="tis-pt__h">Request–response</h3>
            <p class="tis-pt__lead">A caller sends a request and waits for the answer, over REST or GraphQL through a gateway that handles authentication, quotas and rate limits.</p>
            <p class="tis-pt__k">Use it when</p>
            <ul class="bdh-bullets"><li>A person is waiting: stock at checkout, a price, an account lookup.</li><li>The other system must confirm before the next step runs.</li><li>Volumes sit comfortably inside the provider’s rate limits.</li></ul>
            <p class="tis-pt__k">When it fails</p>
            <ul class="bdh-bullets"><li>Every call has a timeout shorter than the caller’s own deadline.</li><li>Retries use exponential backoff with jitter, and only for idempotent requests or with an idempotency key.</li><li>A circuit breaker opens after repeated failures and serves a cached answer; 429s honour Retry-After.</li></ul>
            <ul class="tis-pt__runs" role="list" aria-label="Runs on">
              <li><?= xt_logo('kong', ['size' => 18, 'label' => true]) ?></li><li><?= xt_logo('graphql', ['size' => 18, 'label' => true]) ?></li><li><?= xt_logo('openapiinitiative', ['size' => 18, 'label' => true]) ?></li><li><?= xt_logo('postman', ['size' => 18, 'label' => true]) ?></li>
            </ul>
          </div>
        </div>

        <!-- 02 event-driven -->
        <div class="bdh-pane tis-pt__pane" id="patterns-p-ev" role="tabpanel" aria-labelledby="patterns-tab-ev" data-pane="ev">
          <div class="tis-pt__stage">
            <div class="tis-panel tis-pt__panel">
              <div class="tis-panel__bar"><span><b>orders.v1</b> · one event, three consumers</span>
                <span class="tis-pt__ctl"><button type="button" class="tis-btn" data-pt-act="fail" aria-pressed="false">Fail CRM consumer</button><button type="button" class="tis-btn" data-pt-act="replay" disabled>Replay DLQ <span data-pt-dlqn>0</span></button></span></div>
              <div class="tis-pt__scroll bdh-scroll-x" tabindex="0" aria-label="Event-driven diagram, scroll sideways">
                <svg class="tis-pt__svg" viewBox="0 0 720 360" aria-hidden="true" focusable="false">
                  <?= $tis_pt_edge('p-o', 'M130 180 H160') ?><?= $tis_pt_edge('o-t', 'M260 180 H300') ?>
                  <?= $tis_pt_edge('p-r', 'M70 150 V48 H300', 'is-dash') ?>
                  <?= $tis_pt_edge('t-erp', 'M460 158 C500 158 500 68 540 68') ?>
                  <?= $tis_pt_edge('t-crm', 'M460 180 H540') ?>
                  <?= $tis_pt_edge('t-wh', 'M460 202 C500 202 500 290 540 290') ?>
                  <?= $tis_pt_edge('crm-dlq', 'M580 206 C580 250 520 316 460 316', 'is-dash') ?>
                  <?= $tis_pt_edge('dlq-t', 'M380 292 V252', 'is-dash is-back') ?>
                  <?= $tis_pt_node('prod', 10, 150, 120, 60, 'Storefront', 'producer') ?>
                  <?= $tis_pt_node('outbox', 160, 150, 100, 60, 'Outbox', 'same txn') ?>
                  <g class="tis-pt__n tis-pt__topic" data-n="topic"><rect x="300" y="108" width="160" height="144" rx="10"/>
                    <text class="tis-pt__nt" x="314" y="132">orders.v1</text><text class="tis-pt__ns" x="314" y="148">Kafka · 3 partitions</text>
                    <?php foreach ([0, 1, 2] as $tis_pt_p): $tis_pt_y = 170 + $tis_pt_p * 26; ?>
                      <line class="tis-pt__lane" x1="314" y1="<?= $tis_pt_y ?>" x2="446" y2="<?= $tis_pt_y ?>"/><text class="tis-pt__pl" x="314" y="<?= $tis_pt_y - 5 ?>">p<?= $tis_pt_p ?></text>
                      <?php for ($tis_pt_k = 0; $tis_pt_k < 5 - $tis_pt_p; $tis_pt_k++): ?><rect class="tis-pt__msg" x="<?= 340 + $tis_pt_k * 20 ?>" y="<?= $tis_pt_y - 8 ?>" width="14" height="6" rx="2"/><?php endfor; ?>
                    <?php endforeach; ?>
                  </g>
                  <?= $tis_pt_node('reg', 300, 24, 160, 48, 'Schema registry', 'v4 · BACKWARD mode', 'is-quiet') ?>
                  <?= $tis_pt_node('erp', 540, 40, 170, 56, 'ERP sync', 'lag 0 · ok') ?>
                  <?= $tis_pt_node('crm', 540, 152, 170, 56, 'CRM sync', 'lag 0 · ok') ?>
                  <?= $tis_pt_node('wh', 540, 262, 170, 56, 'Warehouse', 'lag 0 · ok') ?>
                  <?= $tis_pt_node('dlq', 300, 292, 160, 50, 'orders.v1.dlq', 'depth 0', 'is-quiet') ?>
                </svg>
              </div>
              <ol class="tis-pt__log" data-pt-log aria-live="polite">
                <li><b>pub</b> order.created ord_8F2K41 · written with the order, relayed from the outbox</li>
                <li><b>dlq</b> CRM sync failed 5 attempts · 12 events parked with errors</li>
                <li><b>replay</b> 12 events replayed after fix · 0 duplicates (idempotent consumer)</li>
              </ol>
            </div>
          </div>
          <div class="tis-pt__side">
            <h3 class="tis-pt__h">Event-driven</h3>
            <p class="tis-pt__lead">The storefront publishes what happened; every system that cares subscribes. Producers never wait for, or even know about, their consumers.</p>
            <p class="tis-pt__k">Use it when</p>
            <ul class="bdh-bullets"><li>Several systems react to the same business event.</li><li>Bursts must be absorbed without losing an order.</li><li>A slow or failing consumer must not stop the others.</li></ul>
            <p class="tis-pt__k">When it fails</p>
            <ul class="bdh-bullets"><li>Transactional outbox: the event is written in the same database transaction as the order, then relayed.</li><li>At-least-once delivery into idempotent consumers, so a redelivery changes nothing.</li><li>A schema registry rejects incompatible changes; poison messages move to a dead-letter queue and replay once fixed.</li></ul>
            <ul class="tis-pt__runs" role="list" aria-label="Runs on">
              <li><?= xt_logo('apachekafka', ['size' => 18, 'label' => true]) ?></li><li><?= xt_logo('rabbitmq', ['size' => 18, 'label' => true]) ?></li><?= $tis_pt_word('Amazon EventBridge') ?><?= $tis_pt_word('Azure Service Bus') ?>
            </ul>
          </div>
        </div>

        <!-- 03 change data capture -->
        <div class="bdh-pane tis-pt__pane" id="patterns-p-cdc" role="tabpanel" aria-labelledby="patterns-tab-cdc" data-pane="cdc">
          <div class="tis-pt__stage">
            <div class="tis-panel tis-pt__panel">
              <div class="tis-panel__bar"><span><b>orders-db</b> · polling off, log-based capture on</span><button type="button" class="tis-btn" data-pt-act="row">Update a customer row</button></div>
              <div class="tis-pt__scroll bdh-scroll-x" tabindex="0" aria-label="Change data capture diagram, scroll sideways">
                <svg class="tis-pt__svg" viewBox="0 0 720 340" aria-hidden="true" focusable="false">
                  <?= $tis_pt_edge('db-con', 'M190 170 H236') ?><?= $tis_pt_edge('con-t', 'M376 170 H420') ?>
                  <?= $tis_pt_edge('t-wh', 'M540 158 C565 158 565 70 590 70') ?>
                  <?= $tis_pt_edge('t-se', 'M540 170 H590') ?>
                  <?= $tis_pt_edge('t-ca', 'M540 182 C565 182 565 270 590 270') ?>
                  <g class="tis-pt__n tis-pt__db" data-n="db"><rect x="10" y="70" width="180" height="200" rx="10"/>
                    <text class="tis-pt__nt" x="24" y="96">PostgreSQL</text><text class="tis-pt__ns" x="24" y="112">orders-db · write-ahead log</text>
                    <g class="tis-pt__wal" data-pt-wal>
                      <text x="24" y="146">0/16B3700 c orders</text><text x="24" y="168">0/16B3720 u customers</text><text x="24" y="190">0/16B3748 u stock</text><text x="24" y="212">0/16B3790 d carts</text><text class="is-now" x="24" y="234">0/16B37C8 u customers</text>
                    </g>
                  </g>
                  <?= $tis_pt_node('con', 236, 140, 140, 60, 'Debezium', 'reads the WAL') ?>
                  <?= $tis_pt_node('topic', 420, 140, 120, 60, 'cdc.public.*', 'Kafka topics') ?>
                  <?= $tis_pt_node('wh', 590, 42, 120, 56, 'Warehouse', 'Snowflake') ?>
                  <?= $tis_pt_node('se', 590, 142, 120, 56, 'Search', 'Elasticsearch') ?>
                  <?= $tis_pt_node('ca', 590, 242, 120, 56, 'Cache', 'invalidate key') ?>
                  <text class="tis-pt__ann" x="236" y="118">snapshot, then stream from the last LSN</text>
                </svg>
              </div>
              <ol class="tis-pt__log" data-pt-log aria-live="polite">
                <li><b>u</b> customers id=42 · tier silver → gold · LSN 0/16B37C8</li>
                <li><b>sink</b> warehouse 1.4 s · search 0.6 s · cache key customer:42 dropped</li>
                <li><b>load</b> source queries added by capture: 0</li>
              </ol>
            </div>
          </div>
          <div class="tis-pt__side">
            <h3 class="tis-pt__h">Change data capture</h3>
            <p class="tis-pt__lead">Every committed change is read from the database’s own log and streamed on, so downstream systems stay current in seconds without anyone querying the source.</p>
            <p class="tis-pt__k">Use it when</p>
            <ul class="bdh-bullets"><li>A legacy or vendor database has no usable API or events.</li><li>Analytics and search must be fresh in seconds, not overnight.</li><li>Polling queries are already loading the production database.</li></ul>
            <p class="tis-pt__k">When it fails</p>
            <ul class="bdh-bullets"><li>Reads the log (PostgreSQL WAL, MySQL binlog), so the source sees no extra query load.</li><li>An initial snapshot, then streaming from a recorded log position; restarts resume without gaps.</li><li>Replication slot size is monitored, so a stalled connector alerts before disk fills.</li></ul>
            <ul class="tis-pt__runs" role="list" aria-label="Runs on">
              <?= $tis_pt_word('Debezium') ?><li><?= xt_logo('apachekafka', ['size' => 18, 'label' => true]) ?></li><li><?= xt_logo('postgresql', ['size' => 18, 'label' => true]) ?></li><li><?= xt_logo('snowflake', ['size' => 18, 'label' => true]) ?></li><li><?= xt_logo('elasticsearch', ['size' => 18, 'label' => true]) ?></li>
            </ul>
          </div>
        </div>

        <!-- 04 iPaaS workflow -->
        <div class="bdh-pane tis-pt__pane" id="patterns-p-ipaas" role="tabpanel" aria-labelledby="patterns-tab-ipaas" data-pane="ipaas">
          <div class="tis-pt__stage">
            <div class="tis-panel tis-pt__panel">
              <div class="tis-panel__bar"><span><b>Support request intake</b> · workflow v12</span>
                <span class="tis-pt__ctl"><button type="button" class="tis-btn" data-pt-act="503" aria-pressed="false">Helpdesk returns 503</button><button type="button" class="tis-btn tis-btn--blue" data-pt-act="run">Run workflow</button></span></div>
              <div class="tis-pt__scroll bdh-scroll-x" tabindex="0" aria-label="Workflow diagram, scroll sideways">
                <svg class="tis-pt__svg tis-pt__svg--flow" viewBox="0 0 720 340" aria-hidden="true" focusable="false">
                  <?= $tis_pt_edge('a-b', 'M150 170 H190') ?><?= $tis_pt_edge('b-c', 'M330 170 H370') ?>
                  <?= $tis_pt_edge('c-d', 'M490 158 C515 158 515 72 540 72') ?>
                  <?= $tis_pt_edge('d-e', 'M620 100 V142') ?>
                  <?= $tis_pt_edge('c-f', 'M490 182 C515 182 515 270 540 270') ?>
                  <?= $tis_pt_edge('d-x', 'M540 62 C470 62 420 66 340 66', 'is-dash') ?>
                  <?= $tis_pt_node('a', 10, 138, 140, 64, 'Webhook', 'form submitted') ?>
                  <?= $tis_pt_node('b', 190, 138, 140, 64, 'Find contact', 'CRM') ?>
                  <?= $tis_pt_node('c', 370, 138, 120, 64, 'Existing?', 'branch on match') ?>
                  <?= $tis_pt_node('d', 540, 44, 170, 56, 'Create ticket', 'helpdesk') ?>
                  <?= $tis_pt_node('e', 540, 142, 170, 56, 'Notify team', 'chat channel') ?>
                  <?= $tis_pt_node('f', 540, 242, 170, 56, 'Create lead', 'CRM') ?>
                  <?= $tis_pt_node('x', 190, 40, 150, 52, 'Error workflow', 'alert the owner', 'is-quiet') ?>
                  <g class="tis-pt__tag"><rect x="500" y="106" width="30" height="16" rx="8"/><text x="515" y="117.5" text-anchor="middle">yes</text></g>
                  <g class="tis-pt__tag"><rect x="502" y="218" width="26" height="16" rx="8"/><text x="515" y="229.5" text-anchor="middle">no</text></g>
                </svg>
              </div>
              <ol class="tis-pt__log" data-pt-log aria-live="polite">
                <li><b>#4811</b> 5 steps · 1.8 s · succeeded</li>
                <li><b>#4812</b> create ticket 503 · retried in 30 s · succeeded</li>
                <li><b>#4813</b> new contact · lead created · 1.1 s</li>
              </ol>
            </div>
          </div>
          <div class="tis-pt__side">
            <h3 class="tis-pt__h">iPaaS workflow</h3>
            <p class="tis-pt__lead">Managed connectors and a visual workflow for the flows that change often and do not need custom code, run under the same monitoring and change control as everything else.</p>
            <p class="tis-pt__k">Use it when</p>
            <ul class="bdh-bullets"><li>Standard connectors cover the systems involved.</li><li>Volumes are moderate and operations teams want to adjust flows.</li><li>Time to the first working flow matters more than cost per run at scale.</li></ul>
            <p class="tis-pt__k">When it fails</p>
            <ul class="bdh-bullets"><li>Step retries with limits, then an error workflow alerts a named owner with the failed run.</li><li>Flows exported to version control and promoted between environments.</li><li>Run history, alerts and dashboards alongside the custom integrations.</li></ul>
            <ul class="tis-pt__runs" role="list" aria-label="Runs on">
              <li><?= xt_logo('n8n', ['size' => 18, 'label' => true]) ?></li><li><?= xt_logo('zapier', ['size' => 18, 'label' => true]) ?></li><li><?= xt_logo('make', ['size' => 18, 'label' => true]) ?></li><li><?= xt_logo('mulesoft', ['size' => 18, 'label' => true]) ?></li><?= $tis_pt_word('Boomi') ?>
            </ul>
          </div>
        </div>
      </div>
      <p class="tis-pt__note">Technologies we work with, chosen per flow. No partner status is implied.</p>
    </div>
  </div>
</section>
