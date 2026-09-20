<?php /* DRAFT COPY — review before launch */
/* Deliver — the handover manifest. The six deliverables from $CAP['deliver'], rendered as a file
   listing: index, icon, artefact, the file it arrives as, who it is written for and what it is used
   for. Under it, the three things that are not files, and the terms of the handover.
   Motion is the core stagger ([data-rv-s]); no JS of its own. */
$taa_dl_ext = [   /* per deliverable, in $CAP['deliver'] order: [icon, file name, written for, what it is used for] */
    ['doc',             'executive-summary.pdf', 'Board, sponsor',        'The findings that change a decision, each with its cost, its effort and the call it needs from you.'],
    ['clipboard-check', 'findings-detail.pdf',   'Engineering leads',     'Every finding with reproduction steps, the evidence behind it, the rating rationale and a named owner.'],
    ['dashboard',       'scorecard.xlsx',        'Sponsor, audit lead',   'Six dimensions scored one to five, each score tied to the framework it is read against and the descriptor that earned it.'],
    ['layers',          'remediation-backlog.csv','Delivery teams',       'Import-ready rows for Jira or Linear: title, severity, effort in days, dependencies and an acceptance test per item.'],
    ['cost',            'impact-model.xlsx',     'Finance, sponsor',      'Open formulas with your own traffic, conversion, rate and cloud figures. Change an input and every number moves with it.'],
    ['calendar',        '30-60-90-plan.pdf',     'Sponsor, delivery',     'The fix order sequenced against real capacity, with owners, dependencies and the date of the re-test.'],
];
$taa_dl_also = [
    ['headset', 'Readout workshop',  'Session · 90 min', 'Leadership and engineering in one room. The findings are walked through, challenged and turned into an agreed order before anyone leaves.'],
    ['log',     'Evidence appendix', 'Archive · raw',    'Scan output, log extracts, query results, screenshots and interview notes, indexed by finding ID so any rating can be checked.'],
    ['scan',    'Re-test',           'Report · delta',   'An optional re-run against the same checks after the fixes land, reported as a difference from the baseline.'],
];
$taa_dl_terms = [
    ['Formats you own',   'Sheets, CSV and PDF. No portal, no viewer licence and no expiry on the files.'],
    ['Evidence retained', 'Raw evidence is held for the period agreed in the engagement, then destroyed on request.'],
    ['Re-usable baseline','The register is written so a later audit can be run against it and compared line for line.'],
];
?>
<section class="band taa-deliver" id="deliver" aria-labelledby="deliver-t">
  <div class="wrap">

    <header class="taa-head taa-head--wide" data-rv>
      <div class="taa-head__t">
        <p class="taa-kick"><span class="taa-kick__ref">10</span><span>The handover</span></p>
        <h2 class="h2" id="deliver-t"><span class="g">What you get,</span> and who each piece is written for.</h2>
      </div>
      <div class="taa-head__l">
        <p class="lead">One handover, six artefacts and three sessions. Each one is addressed to a specific reader, because a board paper and a remediation backlog are not the same document.</p>
      </div>
    </header>

    <div class="taa-dl taa-win">
      <div class="taa-win__bar">
        <span class="taa-win__t"><b>Handover</b> · audits/your-company/<?= date('Y') ?>-Q<?= (int) ceil((int) date('n') / 3) ?>/</span>
        <span class="taa-win__st"><i class="taa-led" aria-hidden="true"></i><?= count($CAP['deliver']) ?> files</span>
        <span class="taa-win__st">Shared folder · your ownership</span>
      </div>

      <ol class="taa-dl__list" role="list" data-rv-s data-rv-step="80">
        <?php foreach ($CAP['deliver'] as $taa_dli => $taa_dld): ?>
          <?php $taa_dlx = $taa_dl_ext[$taa_dli]; ?>
          <li class="taa-dl__row">
            <span class="taa-dl__ix taa-id"><?= sprintf('%02d', $taa_dli + 1) ?></span>
            <span class="taa-dl__ic"><?= xt_icon($taa_dlx[0], ['size' => 20]) ?></span>
            <div class="taa-dl__m">
              <h3 class="bdh-t taa-dl__n"><?= e($taa_dld[0]) ?></h3>
              <span class="taa-dl__f"><?= sprintf('%02d', $taa_dli + 1) ?>_<?= e($taa_dlx[1]) ?></span>
            </div>
            <p class="taa-dl__d"><?= e($taa_dlx[3]) ?></p>
            <div class="taa-dl__meta">
              <span class="taa-pill"><?= e($taa_dld[1]) ?></span>
              <span class="taa-dl__for"><span class="bdh-sr">Written for: </span><?= e($taa_dlx[2]) ?></span>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>

      <p class="taa-dl__foot">
        <span class="taa-est">Sample paths</span>
        <span>File names are illustrative. The register also exports as CSV with the columns your tracker expects, so the backlog can be imported rather than retyped.</span>
      </p>
    </div>

    <div class="taa-dl__also">
      <p class="taa-lbl taa-dl__ah">Also in the handover</p>
      <ul role="list" data-rv-s data-rv-step="90">
        <?php foreach ($taa_dl_also as $taa_dla): ?>
          <li class="bdh-card taa-dl__card">
            <span class="taa-dl__ci"><?= xt_icon($taa_dla[0], ['size' => 20]) ?><span class="taa-pill"><?= e($taa_dla[2]) ?></span></span>
            <h3 class="bdh-t"><?= e($taa_dla[1]) ?></h3>
            <p class="bdh-d"><?= e($taa_dla[3]) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
      <!-- PLACEHOLDER: confirm whether the re-test is included or scoped separately before launch -->
      <p class="taa-cap">The re-test is scoped separately so that the audit stays independent of the work that follows it.</p>
    </div>

    <dl class="taa-dl__terms" data-rv>
      <?php foreach ($taa_dl_terms as $taa_dlt): ?>
        <div><dt><?= e($taa_dlt[0]) ?></dt><dd><?= e($taa_dlt[1]) ?></dd></div>
      <?php endforeach; ?>
    </dl>

  </div>
</section>
