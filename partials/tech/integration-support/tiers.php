<?php /* DRAFT COPY — review before launch */
/* Tiers — support levels, written down. The severity model first (what P1 actually means), then one
   comparison table of three plans. Selecting a plan highlights its column; the table is complete and
   readable with no JS and with no plan selected. Every figure here is a commercial commitment and is
   marked PLACEHOLDER until the support agreement is signed off. */
$tis_ti_sev = [   // [code, name, definition, example]
    ['P1', 'Critical',
     'A production integration is down, or it is moving wrong data. No workaround exists and the business stops.',
     'Orders stop reaching the ERP. Payments captured but not recorded.'],
    ['P2', 'High',
     'A flow is degraded, delayed or partially failing. A manual workaround exists, and someone is doing it by hand.',
     'The nightly stock sync fails for one warehouse. Support tickets sync late.'],
    ['P3', 'Medium',
     'A contained fault with limited impact: single records, one connector, or a non-blocking error in the log.',
     'One customer record will not map. A retry storm fills the log with noise.'],
    ['P4', 'Low',
     'A question, a small change, or a planned enhancement. Scheduled into the monthly allowance.',
     'Add a field to an existing mapping. Change an alert threshold.'],
];
$tis_ti_plans = [   // [key, name, line]
    ['essential', 'Essential', 'Business hours, monitored, patched.'],
    ['business',  'Business',  'Extended hours with paging on P1.'],
    ['critical',  'Critical',  'Round the clock, engineer on call.'],
];
$tis_ti_rows = [   // [group, commitment, note, [essential, business, critical]]
    ['Response',  'P1 · first response', 'Acknowledged by a named engineer, not an auto-reply.',
     ['4 business hours', '1 hour', '30 minutes']],
    ['Response',  'P1 · restore or workaround', 'Service restored, or a workaround agreed in writing.',
     ['Next business day', '8 business hours', '4 hours']],
    ['Response',  'P2 · first response', 'Triaged, owner assigned, impact confirmed.',
     ['1 business day', '4 business hours', '1 hour']],
    ['Response',  'P2 · restore target', 'Flow returned to normal throughput.',
     ['3 business days', '2 business days', '8 hours']],
    ['Response',  'P3 · first response', 'Logged, reproduced, queued against the backlog.',
     ['2 business days', '1 business day', '1 business day']],
    ['Response',  'P4 · first response', 'Answered or scheduled into the monthly allowance.',
     ['5 business days', '3 business days', '2 business days']],
    ['Coverage',  'Coverage window', 'When the response clock is running.',
     ['Mon–Fri · 09:00–18:00 IST', 'Mon–Sat · 08:00–22:00 IST', '24×7, every day']],
    ['Coverage',  'Out-of-hours paging', 'Which severities wake someone up.',
     ['Not included', 'P1 only', 'P1 and P2']],
    ['Coverage',  'Named incident lead', 'One person owns communication during a P1.',
     ['—', 'Yes', 'Yes']],
    ['Included',  'Engineering hours each month', 'Enhancements, upgrades and small features, prioritised with you.',
     ['8 hours', '24 hours', '60 hours']],
    ['Included',  'Monitoring, patching & dependency upgrades', 'Alerting, security patches and library upgrades on the integrations we run.',
     ['Yes', 'Yes', 'Yes']],
    ['Included',  'Service review', 'SLO report, incident review, and the improvement backlog.',
     ['Monthly report', 'Monthly call', 'Monthly call + quarterly roadmap']],
];
$tis_ti_groups = [];
foreach ($tis_ti_rows as $tis_ti_r) { $tis_ti_groups[$tis_ti_r[0]] = true; }
?>
<section class="band band--alt tis-ti" id="tiers" aria-labelledby="tiers-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tis-kick"><b>$ sla show --plans</b> <span>3 plans · P1–P4</span></p>
        <h2 class="h2" id="tiers-t"><span class="g">Support levels,</span> written down.</h2>
      </div>
      <div>
        <p class="lead">Every number below is a commitment, so it belongs in the agreement rather than in a conversation. Severity is defined by business impact, not by how loudly it is reported.</p>
      </div>
    </div>

    <div class="tis-ti__sev" data-rv>
      <h3 class="tis-ti__sh">What each severity means</h3>
      <ol class="tis-ti__sevs" role="list">
        <?php foreach ($tis_ti_sev as $tis_ti_i => $tis_ti_s): ?>
          <li class="tis-ti__sv" style="--i:<?= (int) $tis_ti_i ?>">
            <p class="tis-ti__svc"><span class="tis-ti__svp"><?= e($tis_ti_s[0]) ?></span><span class="tis-ti__svn"><?= e($tis_ti_s[1]) ?></span></p>
            <p class="tis-ti__svd"><?= e($tis_ti_s[2]) ?></p>
            <p class="tis-ti__sve"><?= e($tis_ti_s[3]) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="tis-ti__tbl" data-rv data-tis-tiers>

      <div class="tis-ti__ctl">
        <p class="tis-ti__ctlk" id="tiers-plan-k">Highlight a plan</p>
        <div class="bdh-seg" role="group" aria-labelledby="tiers-plan-k">
          <?php foreach ($tis_ti_plans as $tis_ti_p): ?>
            <button type="button" aria-pressed="false" data-tis-plan="<?= e($tis_ti_p[0]) ?>"><?= e($tis_ti_p[1]) ?></button>
          <?php endforeach; ?>
        </div>
        <span class="bdh-ill">Indicative targets</span>
      </div>

      <!-- PLACEHOLDER: confirm every response and restore target, the coverage windows, the monthly engineering hours and the plan names below with the owner before launch -->
      <div class="bdh-scroll-x tis-ti__wrap" tabindex="0" role="region" aria-labelledby="tiers-t">
        <table class="tis-ti__t">
          <caption class="bdh-sr">Support plans compared: response and restore targets by severity, coverage windows, and what each plan includes each month. Targets are indicative until the support agreement is signed.</caption>
          <thead>
            <tr>
              <th scope="col" class="tis-ti__th0">Commitment</th>
              <?php foreach ($tis_ti_plans as $tis_ti_p): ?>
                <th scope="col" class="tis-ti__thp" data-col="<?= e($tis_ti_p[0]) ?>">
                  <span class="tis-ti__pn"><?= e($tis_ti_p[1]) ?></span>
                  <span class="tis-ti__pl"><?= e($tis_ti_p[2]) ?></span>
                </th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <?php foreach (array_keys($tis_ti_groups) as $tis_ti_g): ?>
            <tbody>
              <tr class="tis-ti__gr">
                <th scope="colgroup" colspan="4" class="tis-ti__gh"><?= e($tis_ti_g) ?></th>
              </tr>
              <?php foreach ($tis_ti_rows as $tis_ti_r): if ($tis_ti_r[0] !== $tis_ti_g) continue; ?>
                <tr>
                  <th scope="row" class="tis-ti__rh">
                    <span class="tis-ti__rn"><?= e($tis_ti_r[1]) ?></span>
                    <span class="tis-ti__rd"><?= e($tis_ti_r[2]) ?></span>
                  </th>
                  <?php foreach ($tis_ti_plans as $tis_ti_pi => $tis_ti_p): $tis_ti_v = $tis_ti_r[3][$tis_ti_pi]; ?>
                    <td data-col="<?= e($tis_ti_p[0]) ?>"><?php if ($tis_ti_v === 'Yes'): ?>
                      <span class="tis-ti__v tis-ti__v--yes"><span class="tis-ti__mk" aria-hidden="true"><?= xt_icon('check', ['size' => 13, 'mono' => true]) ?></span>Included</span>
                    <?php elseif ($tis_ti_v === '—'): ?>
                      <span class="tis-ti__v tis-ti__v--no"><span class="tis-ti__mk tis-ti__mk--no" aria-hidden="true"></span>Not included</span>
                    <?php else: ?>
                      <span class="tis-ti__v"><?= e($tis_ti_v) ?></span>
                    <?php endif; ?></td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          <?php endforeach; ?>
        </table>
      </div>
    </div>

    <div class="tis-ti__foot" data-rv>
      <div class="tis-ti__note">
        <h3 class="bdh-t">What the plan does not change</h3>
        <ul class="bdh-bullets" role="list">
          <li>Severity is set by impact on your business, and you can escalate a call we get wrong.</li>
          <li>Every P1 gets a blameless post-incident review with actions tracked to closure, on all three plans.</li>
          <li>Unused engineering hours are discussed at the monthly review rather than quietly lost. <!-- PLACEHOLDER: confirm whether unused hours roll over, and for how long, before launch --></li>
          <li>You can move between plans at a service review, and support can be cancelled with notice. <!-- PLACEHOLDER: confirm the notice period for changing or cancelling a support plan before launch --></li>
        </ul>
      </div>
      <div class="tis-ti__std">
        <p class="tis-ti__stdk">Service management practice</p>
        <p class="tis-ti__stdl">Severity levels, incident, problem and change management follow <span class="tis-word">ITIL 4</span> terminology, so the language matches what your IT function already uses. Delivery is measured with <span class="tis-word">DORA</span> metrics.</p>
        <ul class="xt-badges" role="list">
          <?php foreach (['iso22301', 'iso9001', 'dora-metrics'] as $tis_ti_b): ?><?= xt_badge($tis_ti_b, ['tag' => 'li']) ?><?php endforeach; ?>
        </ul>
        <p class="tis-ti__stdn">Frameworks we align support delivery with.</p>
      </div>
    </div>

  </div>
</section>
