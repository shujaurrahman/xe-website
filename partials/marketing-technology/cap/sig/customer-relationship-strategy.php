<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature: a lifecycle model. Five stages, each with its retention readout and the programme that owns it; choosing
   a segment re-reads the model and highlights the stage that segment most needs. */
$mtd_stg = [
    ['Onboard',  'compass',  'Welcome series',    [92, 97, 88]],
    ['Adopt',    'bolt',     'Adoption nudges',   [64, 90, 58]],
    ['Grow',     'trend-up', 'Loyalty tiers',     [38, 72, 30]],
    ['Renew',    'sync',     'Renewal programme', [55, 88, 41]],
    ['Win back', 'handshake','Win-back offers',   [18, 26, 22]],
];
$mtd_hot = ['2', '4', '2 5'];   // stage index (1-based) each segment most needs
?>
<?= mtd_sig_open('Lifecycle model · all customers', 'Your customer data', [
    ['New', 'New customers: strong onboarding, but adoption drops to 64; the adoption programme is the priority.'],
    ['Loyal', 'Loyal customers: high through every stage; the renewal programme protects the most value.'],
    ['At risk', 'At-risk customers: adoption falls to 58 and win-back holds 22; adoption and win-back programmes are the priority.'],
], 'Customer segment') ?>
  <ol class="mtd-lc">
    <?php foreach ($mtd_stg as $mtd_i => $mtd_s):
      $mtd_on = implode(' ', array_keys(array_filter($mtd_hot, fn ($mtd_h) => in_array((string) ($mtd_i + 1), explode(' ', $mtd_h), true))));
      $mtd_on = implode(' ', array_map(fn ($mtd_z) => $mtd_z + 1, array_filter(explode(' ', $mtd_on), 'strlen'))); ?>
    <li class="mtd-lc__s" data-on="<?= e($mtd_on) ?>">
      <span class="mtd-lc__k"><?= xt_icon($mtd_s[1]) ?><span class="bdh-ro"><?= sprintf('%02d', $mtd_i + 1) ?></span></span>
      <span class="mtd-lc__n"><?= e($mtd_s[0]) ?></span>
      <span class="mtd-lc__bar" data-v1="<?= $mtd_s[3][0] ?>" data-v2="<?= $mtd_s[3][1] ?>" data-v3="<?= $mtd_s[3][2] ?>" style="--v:<?= end($mtd_s[3]) ?>"><i></i></span>
      <span class="mtd-lc__v"<?= mtd_t(array_map(fn ($mtd_z) => $mtd_z . '% active', $mtd_s[3])) ?></span>
      <span class="mtd-lc__p"><?= e($mtd_s[2]) ?></span>
    </li>
    <?php endforeach; ?>
  </ol>
  <p class="mtd-lc__foot"><span class="bdh-ro">Priority</span><span class="mth-chip mth-chip--wait"<?= mtd_t(['Adoption nudges', 'Renewal programme', 'Adoption + win-back']) ?></span><span class="mth-chip">Holdout on every programme</span></p>
<?= mtd_sig_close('Illustrative figures: share of each segment still active at each stage.') ?>
