<?php /* DRAFT COPY — review before launch */
/* Outcomes and how each is measured, beside the data-viz idiom: a treated-vs-holdout curve per journey.
   Figures are illustrative, not client results. */
$mth_ms_rows = [
    ['Incremental revenue', 'Revenue per customer, journey group minus holdout group', 'A 10% holdout on every journey · monthly'],
    ['Retention',           'Active or repeat-purchase rate at 90 days, against holdout', 'Cohort report · monthly'],
    ['Contact quality',     'Unsubscribes and complaints per 1,000 sends; Gmail spam rate kept under 0.3%', 'Platform and postmaster data · weekly'],
    ['Budget efficiency',   'Incremental cost per acquisition, not platform-reported', 'Geo experiments and mix model · quarterly'],
    ['Speed',               'Days from approved brief to a live journey', 'Delivery log · per release'],
];
$mth_ms_sets = [
    'onboard' => ['Onboarding', 'Customers still active', '%', [100, 88, 80, 75, 71, 68, 66, 64, 63, 62, 61, 60, 59], [100, 84, 74, 67, 62, 58, 55, 53, 51, 50, 49, 48, 47], 40, 100],
    'winback' => ['Win-back',   'Lapsed customers reactivated', '%', [0, 2, 4, 6, 7.5, 9, 10, 11, 11.8, 12.4, 13, 13.4, 13.8], [0, 1, 1.8, 2.6, 3.2, 3.8, 4.3, 4.7, 5, 5.3, 5.6, 5.8, 6], 0, 16],
];
$mth_ms_pt = function (array $mth_v, float $mth_lo, float $mth_hi): array {
    $mth_o = [];
    foreach ($mth_v as $mth_i => $mth_y) $mth_o[] = [round(40 + $mth_i * (540 / 12), 1), round(20 + (1 - ($mth_y - $mth_lo) / ($mth_hi - $mth_lo)) * 200, 1)];
    return $mth_o;
};
$mth_ms_str = fn (array $mth_p): string => implode(' ', array_map(fn ($mth_q) => $mth_q[0] . ',' . $mth_q[1], $mth_p));
?>
<section class="band band--alt mth-meas" id="measures" aria-labelledby="measures-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Outcomes, measured</p>
        <h2 class="h2" id="measures-t"><span class="g">If it cannot be measured against a holdout,</span> it is not claimed.</h2>
      </div>
      <div><p class="lead">Five measures, agreed before launch and reported in one place. Lift is always the difference between people who received the journey and people who did not.</p></div>
    </div>

    <div class="mth-meas__wrap">
      <dl class="mth-meas__list">
        <?php foreach ($mth_ms_rows as $mth_ms_i => $mth_ms): ?>
        <div class="mth-meas__row">
          <dt><span class="bdh-idx"><?= sprintf('%02d', $mth_ms_i + 1) ?></span><?= e($mth_ms[0]) ?></dt>
          <dd><p><?= e($mth_ms[1]) ?></p><p class="mth-meas__how"><?= e($mth_ms[2]) ?></p></dd>
        </div>
        <?php endforeach; ?>
      </dl>

      <div class="mth-meas__card" data-mth-meas>
        <div class="mth-meas__tabs" role="tablist" aria-label="Journey" hidden>
          <?php $mth_ms_n = 0; foreach ($mth_ms_sets as $mth_ms_k => $mth_ms_s): ?>
          <button type="button" role="tab" id="mth-ms-t-<?= $mth_ms_k ?>" aria-controls="mth-ms-p-<?= $mth_ms_k ?>" aria-selected="<?= $mth_ms_n === 0 ? 'true' : 'false' ?>" tabindex="<?= $mth_ms_n === 0 ? '0' : '-1' ?>"><?= e($mth_ms_s[0]) ?></button>
          <?php $mth_ms_n++; endforeach; ?>
        </div>
        <?php $mth_ms_n = 0; foreach ($mth_ms_sets as $mth_ms_k => $mth_ms_s):
          $mth_ms_a = $mth_ms_pt($mth_ms_s[3], $mth_ms_s[5], $mth_ms_s[6]);
          $mth_ms_b = $mth_ms_pt($mth_ms_s[4], $mth_ms_s[5], $mth_ms_s[6]);
          $mth_ms_lift = end($mth_ms_s[3]) - end($mth_ms_s[4]); ?>
        <figure class="mth-viz mth-meas__pane<?= $mth_ms_n === 0 ? ' is-on' : '' ?>" id="mth-ms-p-<?= $mth_ms_k ?>" role="tabpanel" aria-labelledby="mth-ms-t-<?= $mth_ms_k ?>">
          <div class="mth-viz__head">
            <span class="mth-meas__ttl"><?= e($mth_ms_s[0]) ?> · <?= e($mth_ms_s[1]) ?></span>
            <span class="mth-viz__key">Journey</span><span class="mth-viz__key mth-viz__key--b">Holdout</span>
            <span class="mth-viz__ill">Illustrative</span>
          </div>
          <p class="mth-meas__big"><span class="bdh-ro">+<?= rtrim(rtrim(number_format($mth_ms_lift, 1), '0'), '.') ?> pts</span> lift at week 12</p>
          <svg viewBox="0 0 600 250" aria-hidden="true" focusable="false">
            <?php for ($mth_ms_g = 0; $mth_ms_g <= 4; $mth_ms_g++): $mth_ms_y = 20 + $mth_ms_g * 50; ?>
            <line class="mth-viz__grid" x1="40" x2="580" y1="<?= $mth_ms_y ?>" y2="<?= $mth_ms_y ?>"/>
            <text class="mth-meas__yl" x="0" y="<?= $mth_ms_y + 4 ?>"><?= rtrim(rtrim(number_format($mth_ms_s[6] - ($mth_ms_s[6] - $mth_ms_s[5]) * $mth_ms_g / 4, 1), '0'), '.') ?><?= $mth_ms_s[2] ?></text>
            <?php endfor; ?>
            <polygon class="mth-viz__gap" points="<?= $mth_ms_str($mth_ms_a) ?> <?= $mth_ms_str(array_reverse($mth_ms_b)) ?>"/>
            <polyline class="mth-viz__b" points="<?= $mth_ms_str($mth_ms_b) ?>"/>
            <polyline class="mth-viz__a mth-meas__line" points="<?= $mth_ms_str($mth_ms_a) ?>"/>
            <circle class="mth-viz__dot" cx="<?= end($mth_ms_a)[0] ?>" cy="<?= end($mth_ms_a)[1] ?>" r="4.5"/>
          </svg>
          <div class="mth-viz__axis" aria-hidden="true"><span>Wk 0</span><span>Wk 4</span><span>Wk 8</span><span>Wk 12</span></div>
          <figcaption class="mth-viz__note"><?= e($mth_ms_s[0]) ?>: <?= e(strtolower($mth_ms_s[1])) ?>, journey group <?= end($mth_ms_s[3]) ?>% against holdout <?= end($mth_ms_s[4]) ?>% at week 12. Illustrative figures, not client results.</figcaption>
        </figure>
        <?php $mth_ms_n++; endforeach; ?>
      </div>
    </div>
  </div>
</section>
