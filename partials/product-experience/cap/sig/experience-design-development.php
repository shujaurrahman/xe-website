<?php /* DRAFT COPY — review before launch */
/* Signature — Experience Design & Development: a prototype test round. Four tasks × six participants, each cell
   completed unaided (ok), with help (help) or not completed (fail), for round 1 (a) and round 2 after the fixes (b).
   Task success counts only unaided completions and is computed here from the cells. Ships round 2. */
$pxd_opts = [
    ['a', 'Round 1', 'Round 1: 11 of 24 tasks completed unaided. “Switch” read as cancel on the plan screen; 4 of 6 needed help or gave up.'],
    ['b', 'Round 2', 'Round 2, after three fixes: 21 of 24 completed unaided. The relabelled “Switch to Scale” passed for 5 of 6.'],
];
$pxd_def = 1;
$pxd_sr  = 'An illustrative usability test grid: four tasks attempted by six participants across two rounds, with task success rising after the prototype was changed.';
$pxd_tr = [   // task => [round a cells, round b cells]
    'Find current plan'  => ['ok ok help ok fail ok',     'ok ok ok ok ok ok'],
    'Change plan'        => ['help fail fail ok help ok',  'ok ok help ok ok ok'],
    'Invite a teammate'  => ['ok help ok fail ok help',   'ok ok ok ok ok help'],
    'Read last invoice'  => ['fail ok help fail ok fail', 'ok ok ok help ok ok'],
];
$pxd_lbl = ['ok' => 'Unaided', 'help' => 'With help', 'fail' => 'Not completed'];
?>
<div class="pxd-tr">
  <div class="pxd-tr__head"><span>Task</span><span class="pxd-tr__ps"><?php for ($pxd_p = 1; $pxd_p <= 6; $pxd_p++): ?><i>P<?= $pxd_p ?></i><?php endfor; ?></span><span>Success</span></div>
  <?php foreach ($pxd_tr as $pxd_task => $pxd_rs):
      $pxd_a = explode(' ', $pxd_rs[0]); $pxd_b = explode(' ', $pxd_rs[1]);
      $pxd_pa = (int) round(100 * count(array_keys($pxd_a, 'ok')) / 6); $pxd_pb = (int) round(100 * count(array_keys($pxd_b, 'ok')) / 6); ?>
  <div class="pxd-tr__row">
    <span class="pxd-tr__k"><?= e($pxd_task) ?></span>
    <span class="pxd-tr__ps"><?php foreach ($pxd_a as $pxd_j => $pxd_c): ?><i class="pxd-tr__c" data-a="<?= $pxd_c ?>" data-b="<?= $pxd_b[$pxd_j] ?>"></i><?php endforeach; ?></span>
    <span class="pxd-tr__v" style="--pa:<?= $pxd_pa ?>%;--pb:<?= $pxd_pb ?>%"><span class="pxd-tr__bar"><i></i></span><b><span data-on="a"><?= $pxd_pa ?>%</span><span data-on="b"><?= $pxd_pb ?>%</span></b></span>
  </div>
  <?php endforeach; ?>
  <div class="pxd-tr__foot">
    <span class="pxd-tr__key"><?php foreach ($pxd_lbl as $pxd_k => $pxd_t): ?><span><i class="pxd-tr__c" data-a="<?= $pxd_k ?>" data-b="<?= $pxd_k ?>"></i><?= e($pxd_t) ?></span><?php endforeach; ?></span>
    <span class="pxd-tr__sum"><span data-on="a">11 / 24 unaided</span><span data-on="b">21 / 24 unaided · target 85%</span></span>
  </div>
</div>
