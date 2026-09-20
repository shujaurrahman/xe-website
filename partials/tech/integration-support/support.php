<?php /* DRAFT COPY — review before launch */
/* Support — after launch, someone answers. One real-shaped incident on ink: the ERP sync stops,
   the dead-letter queue fills, an alert fires at 03:11 IST, a triage agent groups the errors and
   links the runbook, the on-call engineer decides, the fix ships, the queue is replayed and the
   review is written. Two clocks make the hand-off concrete. support.js steps the timeline and
   drains the queue graph while the band is on screen; the HTML is the resolved incident, read
   top to bottom. All values are illustrative. */
$tis_su_tl = [   // [time IST, actor: sys|agent|human, title, detail, readout]
    ['03:11', 'sys',   'Alert: dead-letter queue depth &gt; 50',
     'The ERP consumer has been failing for four minutes. Depth crosses the threshold and pages the on-call engineer rather than waiting for the morning.',
     'orders.erp.dlq · depth 52 · rising'],
    ['03:12', 'agent', 'Triage agent groups the failures',
     'The agent reads the traces as they arrive. Every failure in the queue carries the same error, so it matches the pattern to a known runbook and drafts the first status note. It does not deploy anything.',
     'HTTP 400 · "material_code not found" · 52 of 52 · runbook RB-014'],
    ['03:14', 'human', 'On-call engineer acknowledges',
     'The engineer confirms the diagnosis: a new product was created in the storefront with no ERP material code. The agent’s draft is corrected and sent.',
     'MTTA 3 min · status page updated'],
    ['03:38', 'human', 'Fix deployed',
     'Unmapped codes now route to a holding queue with a clear reason instead of failing the batch, and a daily check flags products missing a material code. The queue stopped growing at 63 once the storefront batch finished.',
     'PR #1182 · deployed · behind a flag · queue steady at 63'],
    ['03:52', 'sys',   'Dead-letter queue replayed',
     'The 63 held messages are replayed in order. Idempotency keys mean the ones that had partially succeeded do not create duplicate orders.',
     '63 replayed · 0 duplicates · depth 0'],
    ['—',     'human', 'Post-incident review',
     'Written within two working days, blameless, with actions owned and dated. The catalogue-hygiene check came out of this one.',
     'PIR-2026-014 · 3 actions · 3 closed'],
];
$tis_su_tiles = [   // [figure, unit, label, note]
    ['3',  'min', 'Time to acknowledge', 'Alert to a named engineer responding'],
    ['41', 'min', 'Time to restore',     'Alert to the queue back at zero'],
    ['0',  '',    'Duplicate orders',    'Idempotency keys on every replay'],
    ['63', '',    'Messages held, not lost', 'Dead-letter queue, replayed in order'],
];
$tis_su_clocks = [['03:52', 'IST', 'On-call engineer, Pune'], ['23:22', 'BST', 'Your team, asleep']];
/* Dead-letter queue depth, 03:07 → 03:52 in twelve ~4-minute buckets. Bucket 1 is 03:11, the
   moment the depth crosses the alert threshold of 50; the queue peaks at 63 by 03:19 and drains
   only once the fix ships at 03:38. Every readout on the timeline reads off this series. */
$tis_su_q = [18, 52, 61, 63, 63, 63, 63, 63, 44, 21, 6, 0];
$tis_su_max = max($tis_su_q);
$tis_su_stack = ['opentelemetry', 'grafana', 'prometheus', 'sentry', 'pagerduty', 'apachekafka', 'slack'];
?>
<section class="band band--ink tis-support" id="support" aria-labelledby="support-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tis-kick"><b>$ oncall page --sev 2</b> <span>03:11 IST · a Tuesday</span></p>
        <h2 class="h2" id="support-t"><span class="g">After launch,</span> someone answers.</h2>
      </div>
      <div>
        <p class="lead">Support is an operating practice, not a promise in a proposal. Alerts are tied to the thing customers feel, an agent does the reading, and a named engineer makes every decision that changes production.</p>
        <p class="tis-ill">Illustrative incident · fictional systems</p>
      </div>
    </div>

    <div class="tis-su" data-rv>

      <!-- the incident -->
      <div class="tis-su__main">
        <div class="tis-su__head">
          <div>
            <p class="bdh-ro tis-su__id">INC-2026-0143 · severity 2</p>
            <h3 class="bdh-t bdh-t--l">ERP order sync failing</h3>
          </div>
          <p class="tis-su__state"><span class="tis-led tis-led--pulse" aria-hidden="true"></span>Resolved · 41 minutes</p>
        </div>

        <ol class="tis-su__tl">
          <?php foreach ($tis_su_tl as $tis_su_i => $tis_su_s): ?>
            <li class="tis-su__step is-<?= e($tis_su_s[1]) ?>" style="--i:<?= $tis_su_i ?>">
              <span class="tis-su__t bdh-ro" aria-hidden="true"><?= e($tis_su_s[0]) ?></span>
              <span class="tis-su__node" aria-hidden="true"><?= xt_icon($tis_su_s[1] === 'agent' ? 'agent' : ($tis_su_s[1] === 'human' ? 'approve' : 'alert'), ['size' => 14, 'mono' => true]) ?></span>
              <div class="tis-su__sb">
                <h4 class="bdh-t bdh-t--s"><?= $tis_su_s[2] ?>
                  <span class="tis-su__who"><?= $tis_su_s[1] === 'agent' ? 'Agent' : ($tis_su_s[1] === 'human' ? 'Engineer' : 'System') ?></span>
                </h4>
                <p class="bdh-d"><?= e($tis_su_s[3]) ?></p>
                <p class="bdh-ro tis-su__ro"><?= e($tis_su_s[4]) ?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>

        <p class="tis-su__rule">
          <?= xt_icon('log', ['size' => 16]) ?>
          <span>The agent drafts, groups and links. The engineer decides. Every action on this timeline — including the agent’s — is written to an audit log with its inputs, so the review reads the same account everybody else does.</span>
        </p>
      </div>

      <!-- the aside: queue, clocks, photo -->
      <div class="tis-su__side">

        <div class="tis-su__q">
          <div class="tis-su__qh">
            <p class="bdh-ro">orders.erp.dlq · depth</p>
            <p class="bdh-ro tis-su__qn"><span data-q-now>0</span> now · peak <?= $tis_su_max ?></p>
          </div>
          <div class="tis-su__qg" aria-hidden="true">
            <?php foreach ($tis_su_q as $tis_su_j => $tis_su_v): ?>
              <span class="tis-su__qb<?= $tis_su_v === 0 ? ' is-zero' : '' ?>" style="--h:<?= $tis_su_max ? round($tis_su_v / $tis_su_max * 100) : 0 ?>%;--i:<?= $tis_su_j ?>"></span>
            <?php endforeach; ?>
          </div>
          <p class="tis-su__qx bdh-ro"><span>03:07</span><span>replay</span><span>03:52</span></p>
        </div>

        <ul class="tis-su__tiles" role="list" data-bdh-stagger>
          <?php foreach ($tis_su_tiles as $tis_su_t): ?>
            <li class="tis-su__tile">
              <p class="tis-su__fig"><?= e($tis_su_t[0]) ?><?= $tis_su_t[1] ? '<span>' . e($tis_su_t[1]) . '</span>' : '' ?></p>
              <h4 class="tis-su__tl2"><?= e($tis_su_t[2]) ?></h4>
              <p class="bdh-d"><?= e($tis_su_t[3]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>

        <div class="tis-su__clocks">
          <?php foreach ($tis_su_clocks as $tis_su_c): ?>
            <div class="tis-su__clock">
              <p class="tis-su__ct"><?= e($tis_su_c[0]) ?><span><?= e($tis_su_c[1]) ?></span></p>
              <p class="tis-su__cl"><?= e($tis_su_c[2]) ?></p>
            </div>
          <?php endforeach; ?>
        </div>

        <figure class="bdh-img bdh-img--r169 tis-su__img">
          <img src="<?= e(xe_url('assets/imgs/tech/integration-support/support-night.jpg')) ?>" width="1600" height="900" loading="lazy" decoding="async"
               alt="An engineer working at a laptop in a dark office, screen light on their face">
        </figure>

        <!-- PLACEHOLDER: confirm support hours, on-call coverage and the response targets quoted here before launch -->
        <p class="tis-su__note">On-call coverage, the hours it runs and the severity definitions behind these figures are set per support agreement. The clocks above show why the hand-off is written down rather than assumed.</p>

      </div>
    </div>

    <div class="tis-su__stack">
      <p class="tis-su__stackk">The monitoring and on-call stack we run integrations on</p>
      <?= xt_stack($tis_su_stack, ['variant' => 'chips', 'label' => 'Monitoring and on-call technologies we work with']) ?>
    </div>

    <p class="bdh-sr">The timeline is an illustrative incident: a dead-letter queue alert at 03:11 when the depth crosses fifty, an AI triage agent grouping the identical errors against a runbook, an on-call engineer acknowledging in three minutes, a fix deployed, the queue replayed with no duplicates, and a post-incident review with three closed actions. The chart beside it shows the queue depth crossing fifty at 03:11, peaking at 63, and returning to zero after the replay.</p>
  </div>
</section>
