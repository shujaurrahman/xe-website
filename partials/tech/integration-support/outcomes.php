<?php /* DRAFT COPY — review before launch */
/* Outcomes — the monthly service report, as a page section. Each row is one measure with its exact
   definition, where it is read from, a typical starting point and the target we work towards. The
   numbers are illustrative and every target is agreed per estate, so the commercial ones carry a
   PLACEHOLDER. Motion: the arrow draws and the bar fills once on entry (CSS, under .is-in from
   [data-rv]). Figures are never animated — a target read mid-count would be a wrong number. No JS. */

/* [icon, measure, definition, source, from-label, from-value, to-label, to-value, direction,
   position]. "position" is the last field: how far a typical estate has travelled from its starting
   point towards the target by the third monthly review, as a percentage. It is printed beside the
   bar it draws, so the bar never means something the reader cannot see stated. */
$tis_oc_rows = [
    ['uptime',   'Sync success rate',            'Events accepted by the target system as a share of all events published, measured at the consumer after retries.', 'Consumer acknowledgements · OpenTelemetry',              'Typical at handover', '96.4%',   'Target',          '99.9%',  'up',   96],
    ['latency',  'Data freshness (p95)',         'Time from a change happening in the source system to it being usable in the target, 95th percentile over the month.', 'Event timestamps compared at both ends',                'Nightly batch',       '6 h',     'Target',          '5 min',  'down', 74],
    ['queue',    'Events in the dead-letter queue', 'Failed events still parked after the retry budget, counted at the end of each day. Anything older than 24 hours is an escalation.', 'Queue depth, alerting on the daily close', 'Before monitoring',   '180',     'Target',          '0',      'down', 88],
    ['sync',     'Manual touches removed',       'Re-keyed records and copy-paste steps per week that an integration now performs instead of a person.', 'Counted with your team in the integration inventory',    'At the start',        '0',       'After phase two', '400',    'up',   62],
    ['alert',    'MTTA · time to acknowledge',   'Mean time from an alert firing to a named engineer acknowledging it, priority one only.', 'On-call tooling · incident log',                         'Unmonitored estate',  '42 min',  'Target',          '15 min', 'down', 55],
    ['wrench',   'MTTR · time to restore',       'Mean time from an alert firing to service being restored for users, priority one only. Root cause may be fixed later.', 'Incident log · DORA metrics',                            'Unmonitored estate',  '7 h',     'Target',          '2 h',    'down', 70],
    ['leaf',     'Redundant SaaS licences retired', 'Subscriptions that existed only to move data between two other systems, cancelled once the flows run on infrastructure you already operate. The scheduled polling jobs they replaced are counted separately in the estate report.', 'Your licence register · scheduler inventory',            'At the start',        '0',       'Year one',        '8',      'up',   45],
];

$tis_oc_arrow = [
    'up'   => 'M6 18L18 6M18 6h-7M18 6v7',
    'down' => 'M6 6l12 12M18 18h-7M18 18V11',
];
?>
<section class="band band--ink tis-oc" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tis-kick"><b>$ report service --period 30d</b> <span>same seven measures, every month</span></p>
        <h2 class="h2" id="outcomes-t"><span class="g">Measures we report</span> monthly, in writing.</h2>
      </div>
      <div>
        <p class="lead">An integration estate is only healthy if someone is counting. These are the measures that appear in the monthly service review, each with the definition we use and where the number is read from, so the report cannot quietly change shape.</p>
      </div>
    </div>

    <ol class="tis-oc__list" role="list" data-rv data-bdh-stagger>
      <?php foreach ($tis_oc_rows as $tis_oc_i => $tis_oc_r): ?>
        <li class="tis-oc__row" style="--i:<?= (int) $tis_oc_i ?>">

          <div class="tis-oc__lead">
            <p class="bdh-idx"><?= e(sprintf('%02d', $tis_oc_i + 1)) ?></p>
            <span class="tis-oc__ico" aria-hidden="true"><?= xt_icon($tis_oc_r[0], ['size' => 20]) ?></span>
          </div>

          <div class="tis-oc__body">
            <h3 class="bdh-t tis-oc__t"><?= e($tis_oc_r[1]) ?></h3>
            <p class="bdh-d tis-oc__def"><?= e($tis_oc_r[2]) ?></p>
            <p class="tis-oc__src"><span class="tis-oc__srck">Read from</span> <?= e($tis_oc_r[3]) ?></p>
          </div>

          <div class="tis-oc__move" data-dir="<?= e($tis_oc_r[8]) ?>">
            <div class="tis-oc__cell">
              <p class="tis-oc__k"><?= e($tis_oc_r[4]) ?></p>
              <p class="tis-oc__v tis-oc__v--from"><?= e($tis_oc_r[5]) ?></p>
            </div>
            <span class="tis-oc__arr" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                <path d="<?= e($tis_oc_arrow[$tis_oc_r[8]]) ?>" pathLength="100" class="tis-oc__arrp"/>
              </svg>
            </span>
            <div class="tis-oc__cell tis-oc__cell--to">
              <p class="tis-oc__k"><?= e($tis_oc_r[6]) ?></p>
              <!-- PLACEHOLDER: confirm the target for this measure with the support agreement before launch -->
              <p class="tis-oc__v tis-oc__v--to"><?= e($tis_oc_r[7]) ?></p>
            </div>
            <p class="tis-oc__prog">
              <span class="tis-oc__bar" aria-hidden="true"><i style="--w:<?= (int) $tis_oc_r[9] ?>%"></i></span>
              <span class="tis-oc__progt"><b><?= (int) $tis_oc_r[9] ?>%</b> of the way to target by review three</span>
            </p>
          </div>

        </li>
      <?php endforeach; ?>
    </ol>

    <div class="tis-oc__foot" data-rv>
      <div class="tis-oc__note">
        <span class="tis-ill">Illustrative</span>
        <!-- PLACEHOLDER: confirm reported baselines, target ranges and the month-three progress figures before launch -->
        <p>Starting points are typical of an estate that arrives without monitoring; they are here to show the shape of the change, not a promise about yours. The progress figure beside each bar is where a typical estate sits by the third monthly review. Targets are set per integration during onboarding, written into the support agreement, and reviewed if the traffic profile changes.</p>
      </div>
      <ul class="tis-oc__meta" role="list">
        <li><span class="tis-led" aria-hidden="true"></span><span><b>Monthly service review</b> Thirty minutes with your team: the seven measures, every incident, and what we propose to change next.</span></li>
        <li><span class="tis-led tis-led--warn" aria-hidden="true"></span><span><b>Missed target</b> A missed target is written up in the same report, with the cause and the fix, before the next month starts.</span></li>
        <li><span class="tis-led tis-led--off" aria-hidden="true"></span><span><b>Your copy of the data</b> Dashboards sit in your observability stack, so you can read the same numbers on any day of the month.</span></li>
      </ul>
    </div>

    <p class="bdh-sr">Seven measures are reported each month: sync success rate, targeted at 99.9 per cent; data freshness at the 95th percentile, from a nightly batch to five minutes; dead-letter queue depth to zero; manual touches removed, around four hundred a week after the second phase; time to acknowledge a priority-one alert, targeted at fifteen minutes; time to restore, targeted at two hours; and redundant SaaS licences retired in the first year. Each row also states how far a typical estate has travelled towards its target by the third monthly review. All figures are illustrative.</p>

  </div>
</section>
