<?php /* DRAFT COPY — review before launch */
/* 13 Outcomes — measures we agree before we build. A metric ladder of four rungs, climbed from the bottom:
   adoption, then cycle time, then data quality, then cost. Each rung names the measures, how and where they are
   measured, the baseline week and an example target. Targets are agreed per engagement and never promised as
   results. Beside the ladder, the three things teams notice first ($CAP['outcomes']). outcomes.js lights the
   rungs upward once, on entry. The HTML is the finished, fully lit ladder. */
$tcs_oc_rungs = [   // [n, name, question, measures [[measure, unit]], measured from, example target]
    ['01', 'Adoption', 'Do people choose to use it?',
        [['Weekly active users ÷ people the tool is for', '%'], ['Work done beside the tool: exports and side sheets', 'per week']],
        'SSO sign-ins · product analytics events', '≥ 80% weekly active, eight weeks after launch'],
    ['02', 'Cycle time', 'Does the work move faster?',
        [['Quote to cash, median and p90', 'days'], ['Case resolution, median and p90', 'hours']],
        'Workflow engine timestamps, start to finish', '−30% median quote to cash in two quarters'],
    ['03', 'Data quality', 'Do the numbers agree?',
        [['Identity match rate', '%'], ['Freshness SLO attainment', '% of hours'], ['Contract failures caught before load', 'count']],
        'Data contracts · dbt tests · observability', '≥ 99% freshness attainment on gold tables'],
    ['04', 'Cost', 'Is it cheaper to run?',
        [['Licences and tools retired', 'count'], ['Warehouse credits per 1,000 queries', 'credits'], ['Hours of manual reconciliation', 'per week']],
        'Invoices · warehouse metering · time sampling', 'Three tools retired · −40% warehouse credits'],
];
?>
<section class="band tcs-outcomes" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>Outcomes · agreed up front</p>
        <h2 class="h2" id="outcomes-t"><span class="g">Measures we agree</span> before we build.</h2>
      </div>
      <div>
        <p class="lead">Four rungs, climbed in order. A platform nobody opens cannot speed anything up, and a fast process on numbers nobody trusts saves nothing. Baselines are measured in the first weeks; targets are set with you, and reported against every month.</p>
      </div>
    </div>

    <div class="tcs-oc">
      <ol class="tcs-oc__ladder" aria-label="Metric ladder, from the first rung up">
        <?php foreach ($tcs_oc_rungs as $tcs_oc_i => $tcs_oc_r): ?>
          <li class="tcs-oc__rung" style="--i:<?= $tcs_oc_i ?>">
            <span class="tcs-oc__node" aria-hidden="true"><?= e($tcs_oc_r[0]) ?></span>
            <div class="tcs-oc__card">
              <div class="tcs-oc__top">
                <h3 class="tcs-oc__t"><?= e($tcs_oc_r[1]) ?></h3>
                <p class="tcs-oc__q"><?= e($tcs_oc_r[2]) ?></p>
              </div>
              <ul class="tcs-oc__ms">
                <?php foreach ($tcs_oc_r[3] as $tcs_oc_m): ?>
                  <li><span><?= e($tcs_oc_m[0]) ?></span><em><?= e($tcs_oc_m[1]) ?></em></li>
                <?php endforeach; ?>
              </ul>
              <dl class="tcs-oc__meta">
                <div><dt>Measured from</dt><dd><?= e($tcs_oc_r[4]) ?></dd></div>
                <div><dt>Baseline</dt><dd>Weeks 1–2, before anything ships</dd></div>
                <div class="tcs-oc__tg"><dt>Example target</dt><dd><?= e($tcs_oc_r[5]) ?></dd></div>
              </dl>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>

      <aside class="tcs-oc__side" aria-labelledby="outcomes-side-t" data-rv>
        <p class="tcs-oc__sk" id="outcomes-side-t">What teams notice first</p>
        <ul class="tcs-oc__notice">
          <?php foreach ($CAP['outcomes'] as $tcs_oc_o): ?>
            <li><h3 class="tcs-oc__nt"><?= e($tcs_oc_o[0]) ?></h3><p><?= e($tcs_oc_o[1]) ?></p></li>
          <?php endforeach; ?>
        </ul>
        <p class="tcs-oc__fine"><span class="bdh-ill">Example targets</span>Targets are agreed per engagement against your own baseline. They are commitments to measure and report, not promised results.</p>
      </aside>
    </div>
  </div>
</section>
