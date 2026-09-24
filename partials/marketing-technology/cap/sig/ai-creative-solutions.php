<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature: a dynamic creative matrix. Three headlines × three formats generated inside the template, run through
   brand and claims checks, then approved by a person — two variants held with the reason shown. */
$mtd_h   = ['H1 · Set up in minutes', 'H2 · Built for teams', 'H3 · Cut costs by half'];
$mtd_f   = ['1:1', '4:5', '9:16'];
$mtd_flag = ['1-2' => ['Contrast', 'Fixed · AA'], '2-0' => ['Claim', 'Held · claim'], '2-1' => ['Claim', 'Held · claim'], '2-2' => ['Claim', 'Held · claim']];
?>
<?= mtd_sig_open('Creative matrix · Spring launch', 'Your brand templates', [
    ['Generate', 'Generate: nine variants drafted, three headlines across three formats, inside the brand template.'],
    ['Check', 'Check: automated brand and claims checks flag one contrast failure and a savings claim with no approved evidence on all three H3 variants.'],
    ['Approve', 'Approve: the contrast issue is fixed and six variants are approved by the creative lead; the three H3 variants are held until the claim is substantiated.'],
], 'Matrix step') ?>
  <div class="mtd-mx">
    <div class="mtd-mx__hd"><span></span><?php foreach ($mtd_f as $mtd_x): ?><span class="bdh-ro"><?= e($mtd_x) ?></span><?php endforeach; ?></div>
    <?php foreach ($mtd_h as $mtd_r => $mtd_hl): ?>
    <div class="mtd-mx__row">
      <span class="mtd-mx__h"><?= e($mtd_hl) ?></span>
      <?php foreach ($mtd_f as $mtd_c => $mtd_x): $mtd_k = "$mtd_r-$mtd_c"; $mtd_fl = $mtd_flag[$mtd_k] ?? null;
        $mtd_held = $mtd_fl && $mtd_r === 2; ?>
      <span class="mtd-mx__cell mtd-mx__cell--<?= $mtd_c ?>" data-on="<?= $mtd_fl ? '2' : '' ?>">
        <span class="mtd-mx__art" aria-hidden="true"><i></i><b></b><em></em></span>
        <span class="mtd-mx__id bdh-ro">V<?= $mtd_r * 3 + $mtd_c + 1 ?></span>
        <span class="mth-chip mth-chip--<?= $mtd_held ? 'stop' : 'ok' ?>" data-c1="hold" data-c2="<?= $mtd_fl ? 'wait' : 'ok' ?>" data-c3="<?= $mtd_held ? 'stop' : 'ok' ?>"<?= mtd_t(['Draft', $mtd_fl ? $mtd_fl[0] : 'Pass', $mtd_fl ? $mtd_fl[1] : 'Approved']) ?></span>
      </span>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
    <p class="mtd-mx__sum"><span class="mth-chip mth-chip--ok" data-c1="hold" data-c2="hold" data-c3="ok"<?= mtd_t(['9 drafted', '4 flagged', '6 approved']) ?></span><span class="bdh-ro" data-in="3">Approved by creative lead · Your team</span></p>
  </div>
<?= mtd_sig_close('Illustrative. No variant is published until a person has approved it.') ?>
