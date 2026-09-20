<?php /* DRAFT COPY — review before launch */
/* Process — the audit schedule. A four-week Gantt built from $CAP['process']['steps']: one lane per
   phase, an evidence lane that stays open the whole way, and three gates where the work stops until
   something is agreed. The chart is decorative (a .bdh-sr sentence carries it); the phase cards
   underneath hold the real content. process.js replays the bars drawing once on entry. */
$taa_pr_steps = $CAP['process']['steps'];
/* Per phase: [start week, end week, who runs it, what stops it moving on]. */
$taa_pr_lane = [
    [1, 1, 'Lead auditor · your sponsor',       'Read access working end to end'],
    [1, 3, 'Agents · two senior engineers',     'Every finding reproduced by hand'],
    [3, 4, 'Lead auditor · your finance lead',  'Cost inputs confirmed by you'],
    [4, 4, 'Lead auditor · discipline leads',   'Owners and dates against the top findings'],
];
$taa_pr_gates = [
    [1, 'Access confirmed',       'Scope signed, credentials tested, rules of engagement in place before anything is scanned.'],
    [3, 'Draft walkthrough',      'Findings are tested with your engineers before they are written up. False positives are removed here.'],
    [4, 'Readout workshop',       'Ninety minutes with leadership and delivery. The fix order leaves the room with owners and dates.'],
];
$taa_pr_need = [
    ['key',    'Read access',        'Repositories, cloud consoles, analytics, search and monitoring. Read-only is enough for everything except agreed security testing.'],
    ['users',  'Four to six hours',  'Short interviews with the people who build and run the systems, spread across week one and week two.'],
    ['shield', 'Rules of engagement','A signed scope and testing window before any active security testing. Nothing intrusive runs without it.'],
];
$taa_pr_rows = count($taa_pr_lane) + 2;   /* header + phases + evidence lane */
$taa_pr_sr   = [];
foreach ($taa_pr_steps as $taa_pri => $taa_prs) {
    $taa_pr_sr[] = $taa_prs[0] . ' runs in ' . $taa_prs[1];
}
?>
<section class="band band--alt taa-process" id="process" aria-labelledby="process-t">
  <div class="wrap">

    <header class="taa-head" data-rv>
      <div class="taa-head__t">
        <p class="taa-kick"><span class="taa-kick__ref">09</span><span>How the audit runs</span></p>
        <h2 class="h2" id="process-t"><?= $CAP['process']['title'] ?></h2>
      </div>
      <div class="taa-head__l">
        <p class="lead"><?= e($CAP['process']['lead']) ?></p>
        <!-- PLACEHOLDER: confirm typical audit length before launch -->
        <p class="taa-ro">Wk 01 → Wk 04 · <span class="taa-num">4</span> phases · <span class="taa-num">3</span> gates · readout in week four</p>
      </div>
    </header>

    <div class="taa-pr taa-win" data-taa-process>
      <div class="taa-win__bar">
        <span class="taa-win__t"><b>Audit schedule</b> · combined audit · four working weeks</span>
        <span class="taa-win__st"><i class="taa-led" aria-hidden="true"></i>Evidence log open from day one</span>
        <span class="taa-win__st">Gates · <?= count($taa_pr_gates) ?></span>
      </div>

      <div class="taa-pr__chart">
        <div class="taa-pr__grid" aria-hidden="true">
          <?php for ($taa_prw = 1; $taa_prw <= 4; $taa_prw++): ?>
            <i class="taa-pr__rule" style="grid-column:<?= $taa_prw + 1 ?>"></i>
          <?php endfor; ?>

          <span class="taa-pr__cnr taa-lbl" style="grid-row:1;grid-column:1">Phase</span>
          <?php for ($taa_prw = 1; $taa_prw <= 4; $taa_prw++): ?>
            <span class="taa-pr__w" style="grid-row:1;grid-column:<?= $taa_prw + 1 ?>;--i:<?= $taa_prw - 1 ?>">
              <b>Wk 0<?= $taa_prw ?></b><i>5 working days</i>
            </span>
          <?php endfor; ?>

          <?php foreach ($taa_pr_steps as $taa_pri => $taa_prs): ?>
            <span class="taa-pr__lbl" style="grid-row:<?= $taa_pri + 2 ?>;grid-column:1">
              <em><?= sprintf('%02d', $taa_pri + 1) ?></em><b><?= e($taa_prs[0]) ?></b>
            </span>
            <span class="taa-pr__bar" style="grid-row:<?= $taa_pri + 2 ?>;grid-column:<?= $taa_pr_lane[$taa_pri][0] + 1 ?> / <?= $taa_pr_lane[$taa_pri][1] + 2 ?>;--i:<?= $taa_pri ?>">
              <span class="taa-pr__bt"><?= e($taa_prs[0]) ?></span>
              <span class="taa-pr__bm"><?= e($taa_prs[1]) ?></span>
            </span>
          <?php endforeach; ?>

          <span class="taa-pr__lbl taa-pr__lbl--mut" style="grid-row:<?= count($taa_pr_steps) + 2 ?>;grid-column:1">
            <em>—</em><b>Evidence log</b>
          </span>
          <span class="taa-pr__bar taa-pr__bar--open" style="grid-row:<?= count($taa_pr_steps) + 2 ?>;grid-column:2 / 6;--i:<?= count($taa_pr_steps) ?>">
            <span class="taa-pr__bt">Open and shared with you throughout</span>
          </span>

          <span class="taa-pr__lbl taa-pr__lbl--mut" style="grid-row:<?= $taa_pr_rows + 1 ?>;grid-column:1"><em>▹</em><b>Gates</b></span>
          <?php foreach ($taa_pr_gates as $taa_prgi => $taa_prg): ?>
            <span class="taa-pr__gate" style="grid-row:<?= $taa_pr_rows + 1 ?>;grid-column:<?= $taa_prg[0] + 1 ?>;--i:<?= $taa_prgi ?>">
              <b><?= e($taa_prg[1]) ?></b><i class="taa-pr__gd"></i>
            </span>
          <?php endforeach; ?>
        </div>
      </div>

      <p class="bdh-sr">
        Schedule diagram: <?= e(implode('; ', $taa_pr_sr)) ?>. An evidence log stays open across all four weeks.
        Three gates sit on the timeline —
        <?php foreach ($taa_pr_gates as $taa_prg): ?><?= e($taa_prg[1]) ?> at the end of week <?= (int) $taa_prg[0] ?>. <?php endforeach; ?>
      </p>

      <ul class="taa-pr__gl" role="list">
        <?php foreach ($taa_pr_gates as $taa_prg): ?>
          <li>
            <span class="taa-pr__gk"><i class="taa-pr__gd" aria-hidden="true"></i>End of week <?= (int) $taa_prg[0] ?></span>
            <b><?= e($taa_prg[1]) ?></b>
            <span><?= e($taa_prg[2]) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <ol class="taa-pr__cards" role="list" data-rv-s data-rv-step="90">
      <?php foreach ($taa_pr_steps as $taa_pri => $taa_prs): ?>
        <li class="bdh-card taa-pr__card">
          <p class="taa-pr__ci"><span class="taa-id"><?= sprintf('%02d', $taa_pri + 1) ?></span><span class="taa-pill"><?= e($taa_prs[1]) ?></span></p>
          <h3 class="bdh-t"><?= e($taa_prs[0]) ?></h3>
          <p class="bdh-d"><?= e($taa_prs[2]) ?></p>
          <div class="taa-pr__cf">
            <p class="taa-lbl">Outputs</p>
            <ul class="taa-pr__out" role="list">
              <?php foreach ($taa_prs[3] as $taa_pro): ?><li class="taa-pill"><?= e($taa_pro) ?></li><?php endforeach; ?>
            </ul>
            <dl class="taa-pr__cm">
              <div><dt>Run by</dt><dd><?= e($taa_pr_lane[$taa_pri][2]) ?></dd></div>
              <div><dt>Does not move on until</dt><dd><?= e($taa_pr_lane[$taa_pri][3]) ?></dd></div>
            </dl>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="taa-pr__need" data-rv>
      <p class="taa-lbl taa-pr__nh">What we need from you</p>
      <ul role="list">
        <?php foreach ($taa_pr_need as $taa_prn): ?>
          <li>
            <?= xt_icon($taa_prn[0], ['size' => 20]) ?>
            <b><?= e($taa_prn[1]) ?></b>
            <span><?= e($taa_prn[2]) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

  </div>
</section>
