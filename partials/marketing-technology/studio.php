<?php /* DRAFT COPY — review before launch */
/* Studio — THE SIGNATURE SHOWCASE. The Journey Studio: choose one of five real lifecycle moments and the
   studio draws the journey we would build for it — the trigger, the gates that can stop it, the decision a
   model makes, the channels it can use, and the holdout that proves it worked — plus the rules behind it,
   how it is measured, who owns it and what to buy.
   It behaves like software: a real ARIA radiogroup (arrow keys move and select, Home and End jump, Space
   and Enter select), an aria-live summary, and a run log typed line by line. All five journeys are in the
   markup with the first one shown, so with JavaScript off the section is a finished, readable canvas.
   studio.js switches panes, redraws and runs a packet, and steps through the moments until the reader
   takes over. Under reduced motion nothing animates and nothing autoplays.
   Every timing, threshold and rule below is typical for a journey of this shape, not a promise.
   The canvas nodes are laid out on a 4 × 3 grid and every connector is routed by mth_edge(), so no line
   is ever drawn through a box. */

/* the canvas grid, in stage units (1000 × 340) */
$stu_cx = [125, 375, 625, 875];
$stu_cy = [58, 170, 282];
$stu_nw = 220;
$stu_nh = 64;
$stu_box = fn (int $stu_c, int $stu_r): array => mth_box($stu_cx[$stu_c], $stu_cy[$stu_r], $stu_nw, $stu_nh);
$stu_kinds = [
    'trigger' => ['TRG',  'Trigger'],
    'gate'    => ['GATE', 'Gate · can stop the journey'],
    'decide'  => ['AI',   'Model decision, with a rule fallback'],
    'channel' => ['CH',   'Channel'],
    'outcome' => ['OUT',  'Outcome'],
    'holdout' => ['CTRL', 'Holdout or control'],
];

$stu_moments = [
    [
        'slug' => 'cart-abandoned', 'title' => 'Cart abandoned', 'icon' => 'bolt',
        'why'  => 'Recover demand the brand already earned, without nagging the people who were always going to come back.',
        'meta' => [['Channels', 'WhatsApp · email'], ['Touches', '2 maximum'], ['Holdout', '10%']],
        'nodes' => [
            [0, 1, 'trigger', 'Cart abandoned',        '30 minutes idle · 3 items'],
            [1, 0, 'gate',    'Consent & suppression', 'email ok · opt-in ok · no 24 h order'],
            [1, 2, 'gate',    'Pressure rules',        'cap 3 / 7 days · quiet 21:00–08:00'],
            [2, 1, 'decide',  'Next best action',      'channel · offer · moment · p 0.74'],
            [3, 0, 'channel', 'WhatsApp',              'approved template · 24-hour window'],
            [3, 1, 'channel', 'Email',                 '+1 hour, then +24 hours'],
            [3, 2, 'holdout', 'Holdout · 10%',         'no contact · the control group'],
        ],
        'edges' => [[0, 1, 'h'], [0, 2, 'h'], [1, 3, 'h'], [2, 3, 'h'], [3, 4, 'h'], [3, 5, 'straight-h'], [3, 6, 'h']],
        'route' => [0, 1, 3, 4],
        'rules' => [
            ['Entry',        'A cart with items, idle for 30 minutes, from a person we may contact.'],
            ['Exit',         'Order placed, or both touches used.'],
            ['Suppression',  'Ordered in the last 24 hours · open service ticket · already in a recovery journey.'],
            ['Frequency',    'Counts against one cap across every commercial channel.'],
            ['Offer rule',   'Reminder first. Any incentive is capped by margin and never shown to the holdout.'],
            ['Owner',        'Your lifecycle marketing owner.'],
        ],
        'measure' => ['Incremental revenue per recovered cart against the holdout', 'Margin after any incentive given', 'Unsubscribe and complaint rate per send'],
        'caps'    => ['ai-driven-marketing-automation', 'content-communication-infrastructure'],
        'buy'     => ['lifecycle-journeys', 'messaging-channels'],
        'log' => [
            ['$',        'journey run --moment cart-abandoned --profile prf_8f21c'],
            ['trigger',  'evt.cart_abandoned · idle 30m · items 3'],
            ['gates',    'consent ok · suppression ok · frequency 0 / 3 · quiet hours ok'],
            ['decide',   'channel=whatsapp offer=reminder p=0.74 threshold=0.60'],
            ['produce',  'template=cart_reminder locale=en-IN brand+claims pass'],
            ['activate', 'queued 19:10 IST · template approved · consent re-checked at send'],
            ['measure',  'holdout B 10% · incremental revenue vs control'],
        ],
    ],
    [
        'slug' => 'first-30-days', 'title' => 'First 30 days', 'icon' => 'rocket',
        'why'  => 'Get a new customer to the one action that predicts a second purchase, and stop when they get there.',
        'meta' => [['Channels', 'Email · in-app · WhatsApp'], ['Window', '30 days'], ['Holdout', '10%']],
        'nodes' => [
            [0, 1, 'trigger', 'Account created',        'or first order placed'],
            [1, 0, 'gate',    'Consent & locale',       'email ok · language en-IN'],
            [1, 2, 'decide',  'Which step is missing',  'activation model · p 0.66'],
            [2, 0, 'channel', 'Day 1 · welcome',        'email · in-app card'],
            [2, 1, 'channel', 'Day 3 · the one action', 'WhatsApp or email, per person'],
            [2, 2, 'channel', 'Day 21 · review & ask',  'email · progressive profiling'],
            [3, 1, 'outcome', 'Activated',              'exit rule met · journey stops'],
            [3, 2, 'holdout', 'Holdout · 10%',          'no programme · the control group'],
        ],
        'edges' => [[0, 1, 'h'], [0, 2, 'h'], [1, 3, 'h'], [2, 4, 'h'], [2, 5, 'straight-h'], [3, 6, 'h'], [4, 6, 'straight-h'], [5, 7, 'h']],
        'route' => [0, 2, 4, 6],
        'rules' => [
            ['Entry',       'First account or first order, with a recorded consent state.'],
            ['Exit',        'The activation action is done, or day 30 passes.'],
            ['Suppression', 'Refund or dispute open · unsubscribed · already a repeat customer.'],
            ['Frequency',   'Four touches maximum in 30 days, fewer if the person is already active.'],
            ['Profiling',   'One question per message at most, and only where the answer changes what we send.'],
            ['Owner',       'Your lifecycle marketing owner, with your product team on the in-app steps.'],
        ],
        'measure' => ['Activation rate by weekly cohort against the holdout', 'Second-purchase rate within 90 days', 'Preference-centre completion instead of unsubscribes'],
        'caps'    => ['ai-driven-marketing-automation', 'customer-relationship-strategy'],
        'buy'     => ['lifecycle-journeys', 'customer-data-foundation'],
        'log' => [
            ['$',        'journey run --moment first-30-days --profile prf_44c1a'],
            ['trigger',  'evt.account_created · source=checkout · locale=en-IN'],
            ['gates',    'consent(email)=granted · locale resolved · suppression clear'],
            ['decide',   'missing_step=first_reorder · p=0.66 · fallback=rule path'],
            ['produce',  'template=welcome_d1 · in-app card · accessibility check pass'],
            ['activate', 'day 1 sent · day 3 scheduled · day 21 conditional'],
            ['measure',  'cohort 2026-W14 · activation vs holdout · second order 90d'],
        ],
    ],
    [
        'slug' => 'renewal-at-risk', 'title' => 'Renewal at risk', 'icon' => 'alert',
        'why'  => 'Reach the customers a model says are leaving, and fix the reason before offering anything.',
        'meta' => [['Channels', 'Owner call · email · benefit'], ['Cadence', 'Weekly scoring run'], ['Holdout', '10% matched']],
        'nodes' => [
            [0, 1, 'trigger', 'Churn risk ≥ 0.60',    'weekly scoring run · reasons shown'],
            [1, 0, 'gate',    'Open service issue?',  'yes → service owns it, not marketing'],
            [1, 2, 'gate',    'Value tier & margin',  'capped before it is offered'],
            [2, 1, 'decide',  'Save path',            'call · fix · benefit · leave alone'],
            [3, 0, 'channel', 'Owner call task',      'CRM task · contact within 24 hours'],
            [3, 1, 'channel', 'Loyalty benefit',      'recognition before discount'],
            [3, 2, 'holdout', 'Holdout · 10%',        'matched control · no intervention'],
        ],
        'edges' => [[0, 1, 'h'], [0, 2, 'h'], [1, 3, 'h'], [2, 3, 'h'], [3, 4, 'h'], [3, 5, 'straight-h'], [3, 6, 'h']],
        'route' => [0, 2, 3, 5],
        'rules' => [
            ['Entry',       'Churn risk over the threshold, with the features that drove the score attached.'],
            ['Exit',        'Renewed, saved, or explicitly left alone for a quarter.'],
            ['Suppression', 'Open complaint · in a service recovery flow · contacted in the last 14 days.'],
            ['Fairness',    'Protected and proxy attributes are excluded from the model and the reasons are shown per person.'],
            ['Cost rule',   'Every save carries its cost, so the programme can be judged on margin, not on saves.'],
            ['Owner',       'Your retention owner, with the account owner on every call task.'],
        ],
        'measure' => ['Retention against a matched holdout, by cohort', 'Cost per save and margin after the save', 'Share of at-risk accounts contacted within 24 hours'],
        'caps'    => ['customer-relationship-strategy', 'automated-dynamic-sales'],
        'buy'     => ['segmentation', 'lifecycle-programme'],
        'log' => [
            ['$',        'journey run --moment renewal-at-risk --segment tier_a'],
            ['trigger',  'score.churn_risk=0.68 · top features: usage drop, ticket reopened'],
            ['gates',    'service_issue=false · tier=A · save_cap applied'],
            ['decide',   'path=benefit · confidence 0.62 · call task if no response 72h'],
            ['produce',  'benefit=priority support · no discount · approved copy'],
            ['activate', 'owner task created · message queued · consent ok'],
            ['measure',  'matched holdout 10% · retention curve · cost per save'],
        ],
    ],
    [
        'slug' => 'win-back', 'title' => 'Win-back', 'icon' => 'rollback',
        'why'  => 'Reach lapsed customers who are likely to return, and stop paying to advertise to the rest.',
        'meta' => [['Channels', 'Email · WhatsApp · paid exclusion'], ['Touches', '2 maximum'], ['Holdout', '10%']],
        'nodes' => [
            [0, 1, 'trigger', '180 days, no order',   'and return propensity ≥ 0.40'],
            [1, 0, 'gate',    'Consent still valid',  'never unsubscribed · not expired'],
            [1, 2, 'gate',    'Deliverability',       'warmed segment · list hygiene first'],
            [2, 1, 'decide',  'Reactivation path',    'reason to return · offer if needed'],
            [3, 0, 'channel', 'Email, then WhatsApp', 'second touch only on no response'],
            [3, 1, 'channel', 'Paid exclusion',       'stop prospecting spend on them'],
            [3, 2, 'holdout', 'Holdout · 10%',        'no contact · the control group'],
        ],
        'edges' => [[0, 1, 'h'], [0, 2, 'h'], [1, 3, 'h'], [2, 3, 'h'], [3, 4, 'h'], [3, 5, 'straight-h'], [3, 6, 'h']],
        'route' => [0, 1, 3, 4],
        'rules' => [
            ['Entry',       'No order for 180 days, a valid consent record and a propensity over the threshold.'],
            ['Exit',        'Order placed, both touches used, or unsubscribed.'],
            ['Suppression', 'Complained · hard bounced · refund open · already in another win-back.'],
            ['Sender care', 'Lapsed audiences are sent in warmed batches, because a bad re-engagement send costs the whole list.'],
            ['Paid rule',   'The same audience is excluded from prospecting, so paid and owned do not bid against each other.'],
            ['Owner',       'Your lifecycle marketing owner, with performance media on the exclusions.'],
        ],
        'measure' => ['Incremental reactivations against the holdout', 'Complaint and bounce rate on lapsed batches', 'Prospecting spend saved by the exclusion list'],
        'caps'    => ['ai-driven-marketing-automation', 'ai-campaign-optimization'],
        'buy'     => ['lifecycle-journeys', 'incrementality'],
        'log' => [
            ['$',        'journey run --moment win-back --batch warm_01'],
            ['trigger',  'days_since_order=194 · propensity_return=0.46'],
            ['gates',    'consent valid · never unsubscribed · batch=warm_01'],
            ['decide',   'path=reason_to_return · offer=none · p=0.51'],
            ['produce',  'template=winback_a · locale=en-IN · claims pass'],
            ['activate', 'email queued · paid exclusion pushed · audience push consent-checked'],
            ['measure',  'holdout 10% · incremental reactivation · complaint rate < 0.10%'],
        ],
    ],
    [
        'slug' => 'qualified-enquiry', 'title' => 'Qualified enquiry', 'icon' => 'target',
        'why'  => 'Get a real enquiry to the right person in minutes, with the reasons for the score attached.',
        'meta' => [['Channels', 'Chat · WhatsApp · CRM · Slack'], ['Target', 'First response in minutes'], ['Control', 'Round-robin routing']],
        'nodes' => [
            [0, 1, 'trigger', 'Form or chat qualified', 'lawful basis recorded per market'],
            [1, 0, 'gate',    'Deduplicate',            'existing account → its owner'],
            [1, 2, 'decide',  'Fit & intent score',     'tier A / B / C · reasons per lead'],
            [2, 1, 'decide',  'Route',                  'territory · product · owner · cover'],
            [3, 0, 'channel', 'Alert the owner',        'Slack · CRM task · escalates'],
            [3, 1, 'channel', 'Assistant books it',     'calendar · full context handover'],
            [3, 2, 'outcome', 'Not ready → nurture',    'back to the lifecycle calendar'],
        ],
        'edges' => [[0, 1, 'h'], [0, 2, 'h'], [1, 3, 'h'], [2, 3, 'h'], [3, 4, 'h'], [3, 5, 'straight-h'], [3, 6, 'h']],
        'route' => [0, 2, 3, 5],
        'rules' => [
            ['Entry',       'A qualified form or conversation, with consent and lawful basis for the market.'],
            ['Exit',        'Meeting booked, routed and claimed, or moved to nurture.'],
            ['Suppression', 'Existing open opportunity · competitor · student or job enquiry.'],
            ['Explainability', 'Every score shows its main contributing factors in the CRM, so a seller can disagree with reason.'],
            ['Escalation',  'An unclaimed lead escalates rather than waiting in a queue.'],
            ['Owner',       'Your sales-operations owner, with marketing on the definition of qualified.'],
        ],
        'measure' => ['First-response time in minutes, not days', 'Conversion by score band against round-robin routing', 'Share of leads sales accepts'],
        'caps'    => ['ai-lead-generation', 'automated-dynamic-sales'],
        'buy'     => ['lead-scoring', 'conversational-qualification'],
        'log' => [
            ['$',        'journey run --moment qualified-enquiry --source chat'],
            ['trigger',  'chat.qualified · market=IN · lawful_basis=consent'],
            ['gates',    'dedupe: no existing account · suppression clear'],
            ['decide',   'fit=0.81 intent=0.74 tier=A · reasons attached'],
            ['route',    'territory=north product=platform owner=assigned'],
            ['activate', 'slack alert sent · CRM task created · meeting offered'],
            ['measure',  'first response 00:06:41 · control: round-robin'],
        ],
    ],
];

$stu_summary = function (array $stu_m): string {
    $stu_kinds_n = [];
    foreach ($stu_m['nodes'] as $stu_n) { $stu_kinds_n[$stu_n[2]] = ($stu_kinds_n[$stu_n[2]] ?? 0) + 1; }
    return $stu_m['title'] . ' · ' . count($stu_m['nodes']) . ' steps · ' . ($stu_kinds_n['gate'] ?? 0) . ' gates · '
         . ($stu_kinds_n['decide'] ?? 0) . ' model decisions · ' . count($stu_m['measure']) . ' measures';
};
/* a spoken-word walk through the canvas, for the screen-reader description beside the diagram */
$stu_read = function (array $stu_m) use ($stu_kinds): string {
    $stu_out = [];
    foreach ($stu_m['nodes'] as $stu_n) {
        $stu_out[] = $stu_kinds[$stu_n[2]][1] . ': ' . $stu_n[3] . ', ' . $stu_n[4];
    }
    return implode('. ', $stu_out) . '.';
};
$stu_buy = fn (array $stu_m): string => svc_contact_url(
    array_map(fn ($stu_k) => 'marketing-technology:' . $stu_k, $stu_m['buy']),
    null,
    'marketing-technology'
);
?>
<section class="band band--alt mth-studio" id="studio" aria-labelledby="studio-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Journey Studio</p>
        <h2 class="h2" id="studio-t"><span class="g">Pick a moment.</span> See the journey we would build.</h2>
      </div>
      <div>
        <p class="lead">These are five moments almost every brand has and few have built properly. Choose one and the studio lays out the trigger, the gates that can stop it, where a model decides, the channels it may use, the holdout that proves it worked, and what we would measure.</p>
      </div>
    </div>

    <div class="bdh-ui mth-stu" data-moment="0" data-rv data-rv-d="70" data-bdh-live>
      <div class="bdh-ui__bar mth-stu__top">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="mth-stu__title">Journey Studio · Your brand · draft</span>
        <span class="mth-stu__status"><i class="bdh-pulse" aria-hidden="true"></i><span class="mth-stu__stxt">Journey ready</span></span>
        <span class="bdh-ill">Typical rules</span>
      </div>

      <div class="mth-stu__moments" role="radiogroup" aria-label="Lifecycle moment">
        <?php foreach ($stu_moments as $stu_i => $stu_m): ?>
          <button class="mth-stu__moment" type="button" role="radio" aria-checked="<?= $stu_i === 0 ? 'true' : 'false' ?>"
                  tabindex="<?= $stu_i === 0 ? '0' : '-1' ?>" data-moment="<?= $stu_i ?>">
            <span class="mth-stu__mi" aria-hidden="true"><?= xt_icon($stu_m['icon'], ['size' => 20]) ?></span>
            <span class="mth-stu__mt"><?= e($stu_m['title']) ?></span>
            <span class="mth-stu__mm"><?= count($stu_m['nodes']) ?> steps · <?= e($stu_m['meta'][2][1]) ?></span>
          </button>
        <?php endforeach; ?>
      </div>
      <p class="mth-hint mth-stu__hint" aria-hidden="true"><span class="mth-kbd">←</span><span class="mth-kbd">→</span> change moment<span class="mth-stu__hsep">·</span><span class="mth-kbd">Home</span><span class="mth-kbd">End</span> first and last</p>

      <p class="bdh-sr mth-stu__live" aria-live="polite">Journey: <?= e($stu_summary($stu_moments[0])) ?></p>

      <div class="mth-stu__panes bdh-panes">
        <?php foreach ($stu_moments as $stu_i => $stu_m): ?>
          <div class="bdh-pane mth-stu__pane<?= $stu_i === 0 ? ' is-on' : '' ?>" data-pane="<?= $stu_i ?>"
               data-summary="<?= e($stu_summary($stu_m)) ?>" data-log="<?= e(json_encode($stu_m['log'], JSON_UNESCAPED_UNICODE)) ?>">

            <div class="mth-stu__ph">
              <div>
                <p class="mth-k mth-k--blue">Moment <?= $stu_i + 1 ?> of <?= count($stu_moments) ?> · typical build</p>
                <h3 class="mth-stu__pt"><?= e($stu_m['title']) ?></h3>
                <p class="mth-stu__pw"><?= e($stu_m['why']) ?></p>
              </div>
              <dl class="mth-stu__pm">
                <?php foreach ($stu_m['meta'] as $stu_mt): ?>
                  <div><dt><?= e($stu_mt[0]) ?></dt><dd><?= e($stu_mt[1]) ?></dd></div>
                <?php endforeach; ?>
              </dl>
            </div>

            <p class="bdh-sr">The journey canvas for <?= e($stu_m['title']) ?>, left to right. <?= e($stu_read($stu_m)) ?></p>
            <div class="mth-stu__canvas">
              <div class="bdh-scroll-x mth-stu__board" tabindex="0" role="group" aria-label="Journey canvas for <?= e($stu_m['title']) ?>, scroll sideways on a small screen">
              <div class="mth-stage mth-stu__stage" style="--ar:1000 / 340" aria-hidden="true">
                <svg viewBox="0 0 1000 340" focusable="false">
                  <?php foreach ($stu_m['edges'] as $stu_e):
                      $stu_a = $stu_box($stu_m['nodes'][$stu_e[0]][0], $stu_m['nodes'][$stu_e[0]][1]);
                      $stu_b = $stu_box($stu_m['nodes'][$stu_e[1]][0], $stu_m['nodes'][$stu_e[1]][1]);
                      $stu_soft = in_array($stu_m['nodes'][$stu_e[1]][2], ['holdout'], true); ?>
                    <path class="mth-edge<?= $stu_soft ? ' mth-edge--soft' : '' ?>" d="<?= e(mth_edge($stu_a, $stu_b, $stu_e[2], null, 7, 14)) ?>"/>
                  <?php endforeach; ?>
                  <?php /* the happy path, as one route, for the packet that runs it */
                  $stu_pts = [];
                  foreach ($stu_m['route'] as $stu_ri => $stu_rn) {
                      if ($stu_ri === 0) continue;
                      $stu_a = $stu_box($stu_m['nodes'][$stu_m['route'][$stu_ri - 1]][0], $stu_m['nodes'][$stu_m['route'][$stu_ri - 1]][1]);
                      $stu_b = $stu_box($stu_m['nodes'][$stu_rn][0], $stu_m['nodes'][$stu_rn][1]);
                      $stu_md = $stu_m['nodes'][$stu_m['route'][$stu_ri - 1]][1] === $stu_m['nodes'][$stu_rn][1] ? 'straight-h' : 'h';
                      $stu_pts[] = mth_edge($stu_a, $stu_b, $stu_md, null, 7, 14);
                  } ?>
                  <path class="mth-edge mth-edge--live mth-stu__path" d="<?= e(implode('', $stu_pts)) ?>" pathLength="1"/>
                  <path class="mth-pk mth-stu__pk" d="<?= e(implode('', $stu_pts)) ?>" pathLength="1"/>
                </svg>
                <?php foreach ($stu_m['nodes'] as $stu_ni => $stu_n): ?>
                  <span class="mth-node mth-stu__node mth-stu__node--<?= e($stu_n[2]) ?><?= $stu_n[2] === 'gate' || $stu_n[2] === 'holdout' ? ' mth-node--gate' : '' ?><?= in_array($stu_ni, $stu_m['route'], true) ? ' mth-node--on' : '' ?>"
                        data-node="<?= $stu_ni ?>" style="--x:<?= round($stu_cx[$stu_n[0]] / 10, 2) ?>;--y:<?= round($stu_cy[$stu_n[1]] / 3.4, 2) ?>;--w:22">
                    <span class="mth-node__t"><b><?= e($stu_kinds[$stu_n[2]][0]) ?></b><?= e($stu_n[3]) ?></span>
                    <span class="mth-node__s"><?= e($stu_n[4]) ?></span>
                  </span>
                <?php endforeach; ?>
              </div>
              </div>
              <p class="mth-stu__legend" aria-hidden="true">
                <?php foreach ($stu_kinds as $stu_kk => $stu_kv): ?>
                  <span class="mth-stu__lg mth-stu__lg--<?= e($stu_kk) ?>"><i></i><?= e($stu_kv[1]) ?></span>
                <?php endforeach; ?>
              </p>
            </div>

            <div class="mth-stu__cols">
              <div class="mth-stu__col">
                <p class="mth-k">The rules behind it</p>
                <dl class="mth-stu__rules">
                  <?php foreach ($stu_m['rules'] as $stu_r): ?>
                    <div><dt><?= e($stu_r[0]) ?></dt><dd><?= e($stu_r[1]) ?></dd></div>
                  <?php endforeach; ?>
                </dl>
              </div>
              <div class="mth-stu__col">
                <p class="mth-k">How we know it worked</p>
                <ol class="mth-stu__meas">
                  <?php foreach ($stu_m['measure'] as $stu_mi => $stu_ms): ?>
                    <li><span><?= str_pad((string) ($stu_mi + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($stu_ms) ?></li>
                  <?php endforeach; ?>
                </ol>
                <div class="mth-stu__run mth-on-ink">
                  <p class="mth-stu__runh"><span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span><span>journey.log</span><span class="mth-stu__runn">run <?= $stu_i + 1 ?> / <?= count($stu_moments) ?></span></p>
                  <ol class="mth-log mth-stu__log">
                    <?php foreach ($stu_m['log'] as $stu_ln): ?>
                      <li><b><?= e($stu_ln[0]) ?></b><span><?= e($stu_ln[1]) ?></span></li>
                    <?php endforeach; ?>
                  </ol>
                </div>
              </div>
            </div>

            <div class="mth-stu__foot">
              <span class="mth-stu__links">
                <span class="mth-k">Capabilities that build it</span>
                <?php foreach ($stu_m['caps'] as $stu_cs): $stu_c = $CAPS[$stu_cs]; ?>
                  <a class="mth-capl" href="<?= e(($MTH['cap_href'])($stu_cs)) ?>"><b><?= e($stu_c['n']) ?></b><?= e($stu_c['short']) ?><i aria-hidden="true">›</i></a>
                <?php endforeach; ?>
              </span>
              <a class="btn btn--ink btn--sm" href="<?= e($stu_buy($stu_m)) ?>">Scope this journey with us <span class="i" aria-hidden="true">›</span><span class="bdh-sr">: <?= e($stu_m['title']) ?></span></a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="mth-note mth-stu__note">Canvases show the shape of a journey we would build and the rules we would set, not a quote. Thresholds, caps and holdout sizes are agreed with your team and written down before anything is switched on.</p>
  </div>
</section>
