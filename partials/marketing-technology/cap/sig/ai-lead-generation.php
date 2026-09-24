<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature: lead scoring with reasons and routing. Three inbound leads: signals captured, a fit + intent score with
   the reasons that produced it, then routed to an account executive, an SDR or nurture. */
$mtd_leads = [
    ['Lead L-2041', 'Head of Operations · 450 staff', 86, [['Fit', 'ICP industry · target size', '+34'], ['Intent', 'Pricing viewed 3× this week', '+28'], ['Engage', 'Demo form, work email', '+24']], 'Account executive', 'ok'],
    ['Lead L-2042', 'Marketing Manager · 60 staff',   54, [['Fit', 'Adjacent industry', '+18'], ['Intent', 'Two guides downloaded', '+20'], ['Engage', 'Newsletter reader', '+16']], 'SDR · qualify', 'wait'],
    ['Lead L-2043', 'Student · free email',           12, [['Fit', 'Outside ICP', '+2'], ['Intent', 'One blog visit', '+6'], ['Engage', 'No reply history', '+4']], 'Nurture', 'hold'],
];
?>
<?= mtd_sig_open('Lead scoring · inbound queue', 'Your CRM', [
    ['Signals', 'Signals: three inbound leads with their captured signals, not yet scored.'],
    ['Score', 'Score: each lead gets a fit and intent score out of 100 with the reasons that produced it: 86, 54 and 12.'],
    ['Route', 'Route: the 86 goes to an account executive, the 54 to an SDR to qualify, and the 12 to a nurture programme.'],
], 'Scoring step') ?>
  <ul class="mtd-ld">
    <?php foreach ($mtd_leads as $mtd_l): ?>
    <li class="mtd-ld__i">
      <div class="mtd-ld__top">
        <span class="mtd-ld__who"><b><?= e($mtd_l[0]) ?></b><span><?= e($mtd_l[1]) ?></span></span>
        <span class="mtd-ld__sc" data-in="2"><span class="mtd-ld__num"><?= (int) $mtd_l[2] ?></span><span class="mtd-ld__bar" data-v1="0" data-v2="<?= (int) $mtd_l[2] ?>" data-v3="<?= (int) $mtd_l[2] ?>" style="--v:<?= (int) $mtd_l[2] ?>"><i></i></span></span>
      </div>
      <ul class="mtd-ld__why">
        <?php foreach ($mtd_l[3] as $mtd_w): ?><li><span class="bdh-ro"><?= e($mtd_w[0]) ?></span><span><?= e($mtd_w[1]) ?></span><b data-in="2"><?= e($mtd_w[2]) ?></b></li><?php endforeach; ?>
      </ul>
      <p class="mtd-ld__rt" data-in="3"><?= xt_icon('target') ?><span>Route →</span><span class="mth-chip mth-chip--<?= e($mtd_l[5]) ?>"><?= e($mtd_l[4]) ?></span></p>
    </li>
    <?php endforeach; ?>
  </ul>
<?= mtd_sig_close('Illustrative leads. Every score shows its reasons, and sales can reject a routed lead with one click.') ?>
