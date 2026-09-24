<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature: a workflow builder run. One onboarding journey in three states — built, test-run on three profiles, live —
   with each node's count and status, and the run log filling as it goes. */
$mtd_nodes = [
    ['Trigger',  'workflow', 'Trial started',                 'event · server-side',              ['Ready', '3 in', '1,240 in'],        ['hold', 'ok', 'ok']],
    ['Wait',     'clock',    '1 day, local time',             'quiet hours 21:00–09:00',          ['Set', '3 waiting', '1,188 passed'], ['hold', 'hold', 'ok']],
    ['Branch',   'filter',   'Key feature used?',             'yes → goal · no → continue',       ['Set', '1 yes · 2 no', '412 yes · 776 no'], ['hold', 'ok', 'ok']],
    ['Check',    'shield',   'Consent & frequency',           'purpose · channel · cap 3/week',   ['Set', '1 suppressed', '38 suppressed'], ['hold', 'stop', 'stop']],
    ['Send',     'chat',     'Email or WhatsApp template',    'next best channel · rule fallback',['Draft', '1 sent', '738 sent'],     ['hold', 'ok', 'ok']],
    ['Approve',  'approve',  'Template approved',             'Your team · v3',                   ['Waiting', 'Approved', 'Approved'],  ['wait', 'ok', 'ok']],
];
?>
<?= mtd_sig_open('Journey builder · Onboarding v3', 'Your platform', [
    ['Build', 'Build: six nodes are set up and the message template is waiting for approval.'],
    ['Test run', 'Test run: three test profiles pass through; one is suppressed for frequency, one exits at the goal, one is sent a message.'],
    ['Live', 'Live: the journey is running with a 10 percent holdout, and every node shows its count, including people suppressed by consent or frequency rules.'],
], 'Journey state') ?>
  <ol class="mtd-wf">
    <?php foreach ($mtd_nodes as $mtd_i => $mtd_n): ?>
    <li class="mtd-wf__n" data-on="<?= $mtd_i === 3 ? '2' : '' ?>">
      <span class="mtd-wf__ic"><?= xt_icon($mtd_n[1]) ?></span>
      <span class="mtd-wf__tx"><span class="mtd-wf__k"><?= e($mtd_n[0]) ?></span><span class="mtd-wf__t"><?= e($mtd_n[2]) ?></span><span class="mtd-wf__d"><?= e($mtd_n[3]) ?></span></span>
      <span class="mth-chip mth-chip--<?= e(end($mtd_n[5])) ?>" data-c1="<?= e($mtd_n[5][0]) ?>" data-c2="<?= e($mtd_n[5][1]) ?>" data-c3="<?= e($mtd_n[5][2]) ?>"<?= mtd_t($mtd_n[4]) ?></span>
    </li>
    <?php endforeach; ?>
  </ol>
  <div class="mtd-wf__foot">
    <p class="mtd-wf__goal"><?= xt_icon('target') ?><span>Goal · activated within 14 days</span><span class="mth-chip mth-chip--ok" data-c1="hold" data-c2="hold" data-c3="ok"<?= mtd_t(['Holdout 10%', 'Holdout 10%', '+ lift vs holdout']) ?></span></p>
    <ul class="mth-ledger mtd-wf__log" data-in="2">
      <li><span class="mth-ledger__tm">09:02</span><span class="mth-ledger__id">P-0417</span><span class="mth-ledger__tx"><b>check</b> · frequency cap reached · suppressed</span></li>
      <li><span class="mth-ledger__tm">09:02</span><span class="mth-ledger__id">P-0418</span><span class="mth-ledger__tx"><b>send</b> · WhatsApp · opt-in on record</span></li>
    </ul>
  </div>
<?= mtd_sig_close('Illustrative journey and counts. The send step always has a rule-based fallback.') ?>
