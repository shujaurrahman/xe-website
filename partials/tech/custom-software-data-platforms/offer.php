<?php /* DRAFT COPY — review before launch */
/* Offer — what we build, as a bento of six systems. Each card: what it is, when to build rather than buy
   or extend, and a three-line spec in the form the architecture record uses. The largest tile carries the
   photograph. Hover lifts the card and lights the spec; nothing is hidden behind the hover. */
$tcs_of_cards = [   // [key, icon, title, description, build or buy, spec [[key, value]]]
    ['crm', 'workflow', 'Custom CRM',
        'Pipelines, accounts, cases and field work modelled on how your teams sell and serve, with the integrations they depend on.',
        'Extend Salesforce or HubSpot when most of the process fits out of the box. Build when the process itself is your advantage, or per-seat licences stop scaling with the team.',
        [['store', 'PostgreSQL · RLS'], ['flow', 'Temporal: renewals, onboarding'], ['sync', 'Email, calendar, ERP · two-way']]],
    ['cdp', 'users', 'Customer data platform',
        'Identity resolution, consented profiles and real-time segments that marketing, sales and service all read from.',
        'Buy a packaged CDP for standard marketing use. Build a composable CDP on your own warehouse when identity, consent and cost must stay under your control.',
        [['match', 'Deterministic, then scored'], ['consent', 'Checked per purpose'], ['activate', 'Reverse ETL: CRM, email, ads']]],
    ['tools', 'dashboard', 'Internal tools & back-office',
        'Admin consoles, partner portals and back-office tools that replace spreadsheets and email chains with audited work.',
        'Use a low-code builder for simple screens over one table. Build when a tool needs real permissions, bulk work, approvals and an audit trail.',
        [['auth', 'SSO · SAML 2.0 or OIDC'], ['work', 'Keyboard-first bulk actions'], ['audit', 'Append-only, hash-chained']]],
    ['flow', 'approve', 'Workflow & approvals engines',
        'Onboarding, refunds, credit and change approvals as durable workflows with SLAs, escalations and maker–checker rules.',
        'Configure your ERP’s workflow when the steps live inside one system. Build when a process crosses systems, waits for days or must never lose its place.',
        [['engine', 'Temporal · Camunda (BPMN)'], ['timers', 'Retries, timeouts, compensation'], ['rules', 'SLAs, escalations as code']]],
    ['data', 'database', 'Data platform & semantic layer',
        'Ingestion, a medallion lakehouse and one semantic layer, so every dashboard, model and agent reads the same governed numbers.',
        'Buy the plumbing: managed connectors and a cloud warehouse. Build the models, data contracts and metric definitions, because they encode how your business works.',
        [['ingest', 'CDC · Debezium and Kafka'], ['model', 'dbt, tested in CI'], ['metrics', 'Defined once, used everywhere']]],
    ['legacy', 'rollback', 'Legacy modernisation',
        'Monoliths and ageing line-of-business systems replaced module by module, with parallel runs and a way back at every step.',
        'Rehost when the system works and only the platform is ageing. Rebuild when the data model or the process no longer fits the business.',
        [['route', 'Strangler-fig facade'], ['sync', 'CDC sync, daily reconciliation'], ['undo', 'Rollback per module, by flag']]],
];
?>
<section class="band band--alt tcs-offer" id="offer" aria-labelledby="offer-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>What we build</p>
        <h2 class="h2" id="offer-t"><span class="g">Six systems,</span> one data model underneath them.</h2>
      </div>
      <div>
        <p class="lead"><?= e($CAP['offer_lead']) ?> Build, buy or extend is decided module by module and written down as a decision record, so the reasoning outlives the meeting.</p>
      </div>
    </div>

    <div class="tcs-of" data-rv-s>
      <?php foreach ($tcs_of_cards as $tcs_of_i => $tcs_of_c): ?>
        <article class="tcs-of__c tcs-of__c--<?= $tcs_of_c[0] ?>">
          <?php if ($tcs_of_i === 0): ?>
            <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
            <figure class="bdh-img tcs-of__img">
              <img src="<?= xe_url('assets/imgs/tech/custom-software-data-platforms/offer-engineers.jpg') ?>" alt="Two engineers talk through code on a monitor at a shared desk" width="1800" height="1200" loading="lazy" decoding="async" style="object-position:50% 40%">
            </figure>
          <?php endif; ?>
          <div class="tcs-of__in">
            <div class="tcs-of__top">
              <span class="tcs-of__ic"><?= xt_icon($tcs_of_c[1], ['size' => 22]) ?></span>
              <span class="tcs-of__n"><?= sprintf('%02d', $tcs_of_i + 1) ?></span>
            </div>
            <h3 class="tcs-of__t"><?= e($tcs_of_c[2]) ?></h3>
            <p class="tcs-of__d"><?= e($tcs_of_c[3]) ?></p>
            <div class="tcs-of__bb">
              <p class="tcs-of__k">Build or buy</p>
              <p class="tcs-of__bt"><?= e($tcs_of_c[4]) ?></p>
            </div>
            <dl class="tcs-of__spec">
              <?php foreach ($tcs_of_c[5] as $tcs_of_s): ?>
                <div><dt><?= e($tcs_of_s[0]) ?></dt><dd><?= e($tcs_of_s[1]) ?></dd></div>
              <?php endforeach; ?>
            </dl>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
