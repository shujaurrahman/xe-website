<?php /* DRAFT COPY — review before launch */
/**
 * Book · hours — the working window, drawn once and then converted honestly.
 *
 * Every row is computed at render time from ONE source (the IST window in $BK), through PHP's
 * DateTimeZone, so the offsets are right for the date the page is served rather than hard-coded and
 * wrong for half the year. A window that crosses midnight in a far-west zone is drawn as two bars
 * and labelled, instead of being silently clipped. India observes no daylight saving, so the UTC
 * window printed under the chart is stable all year, and assets/js/book/hours.js uses exactly those
 * two UTC times to restate the window in the reader's own zone.
 *
 * Requires $SITE and $BK (book.php). Locals are prefixed hr_.
 */
$hr_tz    = new DateTimeZone($BK['window']['tz']);
$hr_open  = new DateTimeImmutable('today ' . $BK['window']['open'], $hr_tz);
$hr_close = new DateTimeImmutable('today ' . $BK['window']['close'], $hr_tz);

$hr_cities = [
    ['Asia/Kolkata',     'New Delhi · Ludhiana', true],
    ['Asia/Dubai',       'Dubai',                false],
    ['Europe/London',     'London',              false],
    ['Europe/Berlin',     'Berlin',              false],
    ['America/New_York',  'New York',            false],
    ['Asia/Singapore',    'Singapore',           false],
];

$hr_min = function (DateTimeImmutable $hr_d): int {
    return ((int) $hr_d->format('G')) * 60 + (int) $hr_d->format('i');
};
$hr_hm = function (int $hr_m): string {
    return sprintf('%02d:%02d', intdiv($hr_m, 60) % 24, $hr_m % 60);
};
$hr_off = function (DateTimeImmutable $hr_d): string {
    $hr_s = $hr_d->getOffset();
    return 'UTC' . ($hr_s < 0 ? "\u{2212}" : '+') . sprintf('%02d:%02d', intdiv(abs($hr_s), 3600), intdiv(abs($hr_s) % 3600, 60));
};

$hr_rows = [];
foreach ($hr_cities as $hr_c) {
    $hr_z = new DateTimeZone($hr_c[0]);
    $hr_a = $hr_open->setTimezone($hr_z);
    $hr_b = $hr_close->setTimezone($hr_z);
    $hr_s = $hr_min($hr_a);
    $hr_e = $hr_min($hr_b);
    $hr_abbr = $hr_a->format('T');
    $hr_rows[] = [
        'city'  => $hr_c[1],
        'home'  => $hr_c[2],
        'off'   => $hr_off($hr_a),
        'abbr'  => preg_match('/^[A-Z]{2,5}$/', $hr_abbr) ? $hr_abbr : '',
        'from'  => $hr_hm($hr_s),
        'to'    => $hr_hm($hr_e),
        /* one bar normally; two when the window runs past midnight in that zone */
        'bars'  => $hr_e > $hr_s ? [[$hr_s, $hr_e]] : [[$hr_s, 1440], [0, $hr_e]],
        'wraps' => $hr_e <= $hr_s,
    ];
}
$hr_marks = [0, 6, 12, 18, 24];
?>
<section class="band band--alt bk-hr" id="hours" aria-labelledby="hours-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Time zones</p>
        <h2 class="h2" id="hours-t"><span class="g">We keep Indian hours.</span> The calendar does the arithmetic.</h2>
      </div>
      <div>
        <p class="lead">The scheduler shows every slot in your own time zone, so there is nothing to
          convert. This is the window those slots come out of, for anyone who wants to check the
          overlap before they book.</p>
      </div>
    </div>

    <div class="bdh-grid bk-hr__cols">

      <div class="bdh-c7 bk-hr__chart" data-rv data-rv-d="50">
        <div class="bk-hr__head">
          <span class="bk-k">Booking window</span>
          <span class="bk-k bk-hr__win"><?= e($BK['window']['open']) ?>–<?= e($BK['window']['close']) ?> <?= e($BK['window']['tz_label']) ?> · <?= e($BK['window']['days']) ?></span>
        </div>

        <div class="bk-hr__plot" data-bdh-in>
          <div class="bk-hr__scale" aria-hidden="true">
            <span></span>
            <span class="bk-hr__marks">
              <?php foreach ($hr_marks as $hr_m): ?>
                <span class="bk-hr__mark" style="--at:<?= (int) $hr_m ?>"><?= e(sprintf('%02d', $hr_m)) ?></span>
              <?php endforeach; ?>
            </span>
            <span></span>
          </div>

          <p class="bdh-sr">A twenty-four hour track for each city, with our booking window marked on it.
            Every window is also written out in figures at the end of its row.</p>
          <ul class="bk-hr__rows" role="list" aria-label="Our booking window shown in six cities">
            <?php foreach ($hr_rows as $hr_r): ?>
              <li class="bk-hr__row<?= $hr_r['home'] ? ' is-home' : '' ?>">
                <p class="bk-hr__city">
                  <span class="bk-hr__cn"><?= e($hr_r['city']) ?></span>
                  <span class="bk-hr__co"><?= e($hr_r['off']) ?><?= $hr_r['abbr'] ? ' · ' . e($hr_r['abbr']) : '' ?></span>
                </p>
                <div class="bk-hr__track">
                  <span class="bk-hr__lines" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
                  <?php foreach ($hr_r['bars'] as $hr_i => $hr_b): ?>
                    <span class="bk-hr__bar bdh-grow" style="--s:<?= (int) $hr_b[0] ?>;--e:<?= (int) $hr_b[1] ?>;--i:<?= (int) $hr_i ?>" aria-hidden="true"></span>
                  <?php endforeach; ?>
                </div>
                <p class="bk-hr__span">
                  <?= e($hr_r['from']) ?>–<?= e($hr_r['to']) ?><?php if ($hr_r['wraps']): ?><span class="bk-hr__next"> +1d</span><?php endif; ?>
                </p>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <p class="bk-hr__local" data-bk-local
           data-bk-utc-open="<?= e($BK['window']['utc_open']) ?>" data-bk-utc-close="<?= e($BK['window']['utc_close']) ?>">
          In UTC the window runs <?= e($BK['window']['utc_open']) ?> to <?= e($BK['window']['utc_close']) ?>,
          <?= e($BK['window']['days']) ?>.
        </p>
      </div>

      <div class="bdh-c4 bdh-s9 bk-hr__side" data-rv data-rv-d="90">
        <!-- PLACEHOLDER: confirm both studio addresses and which of them host visitors before launch -->
        <p class="bk-k bk-hr__k">Where we are</p>
        <ul class="bk-hr__studios" role="list">
          <?php foreach ($SITE['company']['studios'] as $hr_st): ?>
            <li class="bk-hr__studio">
              <h3 class="bdh-t bdh-t--s"><?= e($hr_st['city']) ?></h3>
              <?php if (!empty($hr_st['units'])): ?>
                <p class="bk-hr__units"><?= e(implode(' · ', $hr_st['units'])) ?></p>
              <?php endif; ?>
              <address class="bk-hr__addr"><?= e(implode(', ', $hr_st['lines'])) ?></address>
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="bk-note">
          <b>Video by default</b>
          A discovery call is a video call, wherever you are. In person at either studio is possible
          by arrangement — say so in the booking notes and we will confirm it by email.
        </p>
        <!-- PLACEHOLDER: confirm whether calls are offered outside the window before launch -->
        <p class="bk-note">
          <b>Outside the window</b>
          If none of the overlap works — and for most of the Americas very little of it will — say so
          when you book or email us, and we will look at a time outside it.
        </p>
      </div>

    </div>
  </div>
</section>
