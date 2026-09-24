<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature: in-flight reallocation with guardrails. Four ad sets over a week: budget shares move toward what is
   returning, inside a daily shift limit and a spend floor; the one move above the limit waits for a person. */
$mtd_ads = [
    ['Search · brand',       [25, 23, 19], ['CPA 410', 'CPA 405', 'CPA 398'], ['hold', 'ok', 'ok'],   ['Even', '−8%', '−17%']],
    ['Search · category',    [25, 30, 36], ['CPA 520', 'CPA 470', 'CPA 455'], ['hold', 'ok', 'wait'], ['Even', '+20% · max', '+26% asked']],
    ['Social · prospecting', [25, 27, 29], ['CPA 610', 'CPA 560', 'CPA 540'], ['hold', 'ok', 'ok'],   ['Even', '+8%', '+7%']],
    ['Social · retargeting', [25, 20, 16], ['CPA 700', 'CPA 760', 'CPA 820'], ['hold', 'stop', 'stop'], ['Even', '−20% · max', '−20% · max']],
];
?>
<?= mtd_sig_open('Budget allocator · Campaign Q3', 'Your ad accounts', [
    ['Day 1', 'Day 1: budget split evenly across four ad sets while conversions accumulate.'],
    ['Day 4', 'Day 4: budget moves toward search category and prospecting; retargeting is cut by the daily maximum of 20 percent.'],
    ['Day 7', 'Day 7: retargeting sits at its spend floor, retargeting is cut by the maximum again, and search category asked for 26 percent more, above the limit, so it moved 20 percent and the rest waits for a person to approve.'],
], 'Day of the flight') ?>
  <div class="mtd-al">
    <div class="mtd-al__rules">
      <span class="mth-chip">Max shift ±20% / day</span><span class="mth-chip">Floor 10% per ad set</span><span class="mth-chip">Brand safety on</span>
    </div>
    <ul class="mtd-al__rows">
      <?php foreach ($mtd_ads as $mtd_a): ?>
      <li>
        <span class="mtd-al__n"><?= e($mtd_a[0]) ?></span>
        <span class="mtd-al__bar" data-v1="<?= $mtd_a[1][0] ?>" data-v2="<?= $mtd_a[1][1] ?>" data-v3="<?= $mtd_a[1][2] ?>" style="--v:<?= end($mtd_a[1]) ?>"><i></i><b class="mtd-al__floor"></b></span>
        <span class="mtd-al__pc"<?= mtd_t(array_map(fn ($mtd_z) => $mtd_z . '%', $mtd_a[1])) ?></span>
        <span class="mtd-al__cpa"<?= mtd_t($mtd_a[2]) ?></span>
        <span class="mth-chip mth-chip--<?= e(end($mtd_a[3])) ?>" data-c1="<?= e($mtd_a[3][0]) ?>" data-c2="<?= e($mtd_a[3][1]) ?>" data-c3="<?= e($mtd_a[3][2]) ?>"<?= mtd_t($mtd_a[4]) ?></span>
      </li>
      <?php endforeach; ?>
    </ul>
    <p class="mtd-al__q" data-in="3"><?= xt_icon('approve') ?><span>Search · category asked for +26%, above the 20% daily limit. It moved +20%; the rest waits for Your team.</span></p>
  </div>
<?= mtd_sig_close('Illustrative figures in any currency. The dashed tick on each bar is the spend floor.') ?>
