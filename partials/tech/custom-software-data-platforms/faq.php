<?php /* DRAFT COPY — review before launch */
/* 14 FAQ — custom software and data, asked directly. A sticky side column (heading, lead, and a short
   "bring these to the first call" card) beside an accordion (core [data-acc]). Each question carries a mono key,
   the way a field in the schema would; the key sits above the h3 (never inside it), and the button's hit area
   runs under it, so a press on the key still opens the answer. Answers from $CAP['faq'] are extended with page-specific questions.
   The first row is open in the HTML. */
$tcs_fq = [   // [key, question, answer, placeholder note or '']
    ['build_or_buy', 'Should we build or buy?',
        'Buy where the process is standard and a product fits; build where the process is your advantage or the integrations make packaged software brittle. We decide module by module and write down why, so the reasoning survives the meeting. Most platforms end up a mix: bought for the commodity parts, built for the parts that make you different.', ''],
    ['extend_existing', 'Can you extend Salesforce, HubSpot or SAP instead of replacing them?',
        'Yes, and it is often the right answer. We keep the system of record and build around it: custom apps on its APIs, two-way data sync, workflows that cross it and the systems it does not cover. We replace a product only when extending it costs more than the fit is worth.', ''],
    ['data_residency', 'Where does our data live?',
        'In your cloud account, in the region you choose, in databases you own. We work inside your accounts with least-privilege access you can revoke at any time; nothing is copied to ours. The region follows your obligations and preferences, for example keeping personal data in India or in the EU, and any cross-border transfer is documented against the DPDP Act 2023 and GDPR.', ''],
    ['zero_downtime', 'How do you migrate without downtime?',
        'Module by module behind a routing facade. Data is migrated in rehearsed dry runs, both sides run in parallel with nightly reconciliation on counts, checksums and sampled fields, and traffic moves by percentage. Each module can be rolled back with a flag change until the old one is retired.', ''],
    ['cdp_or_warehouse', 'Do we need a CDP, a warehouse, or both?',
        'The warehouse or lakehouse is the foundation: it holds the governed data. A CDP adds identity resolution, consent and activation on top. Packaged CDPs suit standard marketing use; a composable CDP on your own warehouse suits teams that need control of identity, consent and cost. Many teams start with the warehouse and add activation once profiles are trusted.', ''],
    ['ai_agents', 'Where do AI agents fit into the platform?',
        'In the housekeeping, with a person signing off: classifying columns, drafting data contracts, documentation and tests, comparing migration samples and answering lineage questions. Agents never approve their own work, merge code or change access, and every action they take is logged with its inputs.', ''],
    ['maintenance', 'Who maintains the platform after launch?',
        'Your team, with the documentation site, runbooks and a handover period in which they lead and we support. Or our engineers keep running it under Integration & Support, with the same repositories and the same on-call runbooks.', ''],
    ['first_release', 'How soon is something in production?',
        'A thin slice, one real flow with single sign-on and real data, typically reaches production within the first two months. A first release of the core modules usually lands in 12 to 24 weeks, depending on how many systems it replaces.', 'confirm the typical thin-slice and first-release timeframes'],
];
?>
<section class="band tcs-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="tcs-fq">
      <div class="tcs-fq__side">
        <div class="tcs-fq__sticky">
          <div class="bdh-head tcs-fq__head" data-rv>
            <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>Questions · <?= count($tcs_fq) ?> answered</p>
            <h2 class="h2" id="faq-t"><span class="g">Custom software and data,</span> asked directly.</h2>
            <p class="lead">The questions buyers and their engineering teams ask before they commit. If yours is not here, it is a good one to bring to the first call.</p>
          </div>
          <div class="tcs-fq__bring" data-rv>
            <p class="tcs-fq__bk">Bring to the first call</p>
            <ul class="tcs-fq__bl">
              <li><?= xt_icon('workflow', ['size' => 16]) ?>The process that hurts most, as people actually run it</li>
              <li><?= xt_icon('dashboard', ['size' => 16]) ?>A screenshot of the spreadsheet it lives in today</li>
              <li><?= xt_icon('plug', ['size' => 16]) ?>The systems it touches, and who owns each one</li>
            </ul>
            <a class="btn btn--ink tcs-fq__cta" href="<?= xe_url('contact.php') ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
          </div>
        </div>
      </div>

      <div class="tcs-fq__list" data-acc>
        <?php foreach ($tcs_fq as $tcs_fq_i => $tcs_fq_q): $tcs_fq_open = $tcs_fq_i === 0; ?>
          <div class="tcs-fq__row">
            <p class="tcs-fq__k" aria-hidden="true">faq.<b><?= e($tcs_fq_q[0]) ?></b></p>
            <h3 class="tcs-fq__q">
              <button type="button" data-acc-b aria-expanded="<?= $tcs_fq_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $tcs_fq_i ?>" id="faq-b<?= $tcs_fq_i ?>">
                <span class="tcs-fq__qt"><?= e($tcs_fq_q[1]) ?></span>
                <i class="tcs-fq__pm" aria-hidden="true"></i>
              </button>
            </h3>
            <div class="tcs-fq__a" id="faq-a<?= $tcs_fq_i ?>" role="region" aria-labelledby="faq-b<?= $tcs_fq_i ?>" data-acc-p<?= $tcs_fq_open ? ' style="height:auto"' : '' ?>>
              <?php if ($tcs_fq_q[3] !== ''): ?><!-- PLACEHOLDER: <?= e($tcs_fq_q[3]) ?> before launch --><?php endif; ?>
              <p><?= e($tcs_fq_q[2]) ?><?php if ($tcs_fq_q[0] === 'maintenance'): ?> <a class="tcs-fq__link" href="<?= xe_url('services/technology-intelligence/integration-support.php') ?>">See Integration &amp; Support</a><?php endif; ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
