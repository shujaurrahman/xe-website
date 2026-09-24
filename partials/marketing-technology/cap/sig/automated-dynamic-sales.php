<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature: a sequence adapting to signals. A planned five-touch sequence; a buyer signal arrives on day 3; the
   sequence re-plans: the call moves forward, the next email's content changes, a touch is skipped. */
$mtd_seq = [
    [['Day 0', 'Day 0', 'Day 0'], 'doc',   ['Email · introduction', 'Email · introduction', 'Email · introduction'], ['Sent', 'Sent', 'Sent'], ['ok', 'ok', 'ok']],
    [['Day 2', 'Day 2', 'Day 2'], 'users', ['LinkedIn · connect', 'LinkedIn · connect', 'LinkedIn · connect'], ['Sent', 'Sent', 'Sent'], ['ok', 'ok', 'ok']],
    [['Day 5', 'Day 5', 'Day 3'], 'headset', ['Call · discovery', 'Call · discovery', 'Call · pricing questions, within 2 h'], ['Planned', 'Planned', 'Moved up'], ['hold', 'hold', 'wait']],
    [['Day 7', 'Day 7', 'Day 4'], 'doc',   ['Email · product overview', 'Email · product overview', 'Email · pricing FAQ, rep-edited draft'], ['Planned', 'Planned', 'Swapped'], ['hold', 'hold', 'wait']],
    [['Day 9', 'Day 9', 'Day 9'], 'chat',  ['Email · case for change', 'Email · case for change', 'Skipped · not needed'], ['Planned', 'Planned', 'Skipped'], ['hold', 'hold', 'stop']],
];
?>
<?= mtd_sig_open('Sequence · Account A-311', 'Your CRM', [
    ['Planned', 'Planned: a five-touch sequence over nine days.'],
    ['Signal', 'Signal: on day 3 the buyer views the pricing page twice and opens the introduction email again.'],
    ['Adapted', 'Adapted: the discovery call moves to day 3 and focuses on pricing, the next email becomes a pricing FAQ drafted for the rep to edit, and the day 9 email is skipped.'],
], 'Sequence state') ?>
  <div class="mtd-sq">
    <p class="mtd-sq__sig" data-in="2" data-on="2"><?= xt_icon('radar') ?><span><b>Day 3 · signal</b> Pricing page viewed 2× · intro email reopened</span></p>
    <ol class="mtd-sq__l">
      <?php foreach ($mtd_seq as $mtd_q): ?>
      <li data-on="<?= end($mtd_q[3]) !== 'Sent' ? '3' : '' ?>">
        <span class="mtd-sq__day bdh-ro"<?= mtd_t($mtd_q[0]) ?></span>
        <span class="mtd-sq__ic"><?= xt_icon($mtd_q[1]) ?></span>
        <span class="mtd-sq__t"<?= mtd_t($mtd_q[2]) ?></span>
        <span class="mth-chip mth-chip--<?= e(end($mtd_q[4])) ?>" data-c1="<?= e($mtd_q[4][0]) ?>" data-c2="<?= e($mtd_q[4][1]) ?>" data-c3="<?= e($mtd_q[4][2]) ?>"<?= mtd_t($mtd_q[3]) ?></span>
      </li>
      <?php endforeach; ?>
    </ol>
    <p class="mtd-sq__rep" data-in="3"><?= xt_icon('approve') ?><span>Drafts wait for the rep. Nothing is sent in their name without a review.</span></p>
  </div>
<?= mtd_sig_close('Illustrative account and sequence. Stage changes are written back to the CRM with the signal that caused them.') ?>
