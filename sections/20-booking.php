<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* 20 — booking. A request form, not a live calendar: nothing is reserved.

   Server-rendered first. PHP draws the month (six Monday-first weeks, so the grid rolls into the
   next month and late-month visitors still see about ten bookable working days), the open times
   for a chosen day and the request form, so the whole flow works without JavaScript:
     ?s20m=YYYY-MM          another month      (the month arrows are links)
     ?s20d=YYYY-MM-DD       a chosen day        (bookable days are links)
     ?s20d=…&s20t=<mins>    a chosen time       (times are links) → the form, slot written into the message
   20-booking.js takes over the same markup: buttons instead of links, a roving-focus ARIA grid,
   the visitor's own time zone, the 12h/24h toggle, and the slot added to the message on submit.

   The form POSTs the contact page's own send fields (name, email, company, message, from, t) to
   xe_url('contact.php'), so the request becomes a normal lead: validated there, emailed, and
   answered with the contact page's success state ("We have your brief", with a reference) or its
   honest failure state (a mailto: holding the same brief). No mailto: here any more.
   `t` is the contact form's signed render time. partials/contact/handler.php defines ct_token()
   but cannot be included here (it handles the request on include), so the same signature is
   mirrored below; if the two ever drift, contact simply shows this brief pre-filled with
   "This form expired. Check your answers and send it again." — nothing is lost.

   HOOK 1 AVAILABLE(date) and HOOK 2 SLOTS(date) live here and in 20-booking.js: keep them in step,
   and wire both to the real calendar (Cal.com / Google) before launch. */

$s20_tz    = new DateTimeZone('Asia/Kolkata');          // the studios' time; JS re-renders in the visitor's own
$s20_today = new DateTimeImmutable('today', $s20_tz);
$s20_open  = function (DateTimeImmutable $d) use ($s20_today): bool {   /* HOOK 1 — weekdays, 2 to 84 days out */
    if ((int) $d->format('N') >= 6) return false;
    $s20_diff = (int) $s20_today->diff($d)->format('%r%a');
    return $s20_diff >= 2 && $s20_diff <= 84;
};
$s20_slots = [];                                          /* HOOK 2 — 09:00–17:30, half-hourly, no 13:00 hour */
for ($s20_m = 9 * 60; $s20_m <= 17 * 60 + 30; $s20_m += 30) {
    if ($s20_m >= 13 * 60 && $s20_m < 14 * 60) continue;
    $s20_slots[] = $s20_m;
}
$s20_time = fn (int $m): string => ((intdiv($m, 60) % 12) ?: 12) . ':' . sprintf('%02d', $m % 60) . ($m < 720 ? 'am' : 'pm');
$s20_dayname = fn (DateTimeImmutable $d): string => $d->format('l j F');
$s20_ymd = fn (DateTimeImmutable $d): string => $d->format('Y-m-d');

/* the six-week grid that starts on the Monday on or before the 1st */
$s20_grid = function (DateTimeImmutable $first): array {
    $s20_start = $first->modify('-' . ((int) $first->format('N') - 1) . ' days');
    $s20_out = [];
    for ($s20_i = 0; $s20_i < 42; $s20_i++) $s20_out[] = $s20_start->modify("+$s20_i days");
    return $s20_out;
};
$s20_first_now = $s20_today->modify('first day of this month');
$s20_last_ok   = $s20_today->modify('+84 days')->modify('first day of this month');

/* ---- what the query asks for (all optional, all validated) ---- */
$s20_sel = null; $s20_pick = null; $s20_view = null;
$s20_q = fn (string $k): string => is_string($_GET[$k] ?? null) ? $_GET[$k] : '';
if (preg_match('~^\d{4}-\d{2}-\d{2}$~', $s20_q('s20d'))) {
    $s20_try = DateTimeImmutable::createFromFormat('!Y-m-d', $s20_q('s20d'), $s20_tz);
    if ($s20_try && $s20_try->format('Y-m-d') === $s20_q('s20d') && $s20_open($s20_try)) {
        $s20_sel  = $s20_try;
        $s20_view = $s20_try->modify('first day of this month');
        if (ctype_digit($s20_q('s20t')) && in_array((int) $s20_q('s20t'), $s20_slots, true)) $s20_pick = (int) $s20_q('s20t');
    }
}
if (!$s20_view && preg_match('~^\d{4}-\d{2}$~', $s20_q('s20m'))) {
    $s20_try = DateTimeImmutable::createFromFormat('!Y-m-d', $s20_q('s20m') . '-01', $s20_tz);
    if ($s20_try && $s20_try >= $s20_first_now && $s20_try <= $s20_last_ok) $s20_view = $s20_try;
}
if (!$s20_view) {
    /* late in a month, open on the next one rather than a grid of greyed-out days */
    $s20_view = $s20_first_now;
    if (count(array_filter($s20_grid($s20_view), $s20_open)) < 8) $s20_view = $s20_view->modify('+1 month');
}
$s20_days   = $s20_grid($s20_view);
$s20_prev   = $s20_view > $s20_first_now ? $s20_view->modify('-1 month') : null;
$s20_next   = $s20_view < $s20_last_ok ? $s20_view->modify('+1 month') : null;
$s20_href   = fn (array $q): string => e('?' . http_build_query($q) . '#book');

/* the contact form's signed render time (see the note above) */
$s20_token = function_exists('ct_token') ? ct_token() : (function (): string {
    $s20_key = hash('sha256', realpath(__DIR__ . '/../partials/contact/handler.php') . '|' . php_uname('n') . '|xe-contact');
    $s20_t = (string) time();
    return $s20_t . '.' . substr(hash_hmac('sha256', $s20_t, $s20_key), 0, 20);
})();

/* without JS the slot rides at the top of the message; with JS it is added on submit instead */
$s20_when = $s20_sel && $s20_pick !== null ? $s20_dayname($s20_sel) . ' at ' . $s20_time($s20_pick) : '';
$s20_msg  = $s20_when !== '' ? 'Requested discovery call: ' . $s20_when . " (my local time)\n\n" : '';
?>
<section class="band band--alt band--rules s20" id="book" aria-labelledby="s20-t">
  <div class="wrap">
    <div class="s20__head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Book a call</p>
      <h2 class="h2" id="s20-t"><span class="g">Thirty minutes,</span> and a straight answer.</h2>
    </div>

    <div class="s20__box" data-s20
         data-s20-view="<?= e($s20_view->format('Y-m')) ?>"
         data-s20-sel="<?= $s20_sel ? e($s20_ymd($s20_sel)) : '' ?>"
         data-s20-pick="<?= $s20_pick !== null ? $s20_pick : '' ?>"
         data-rv data-rv-d="70">

      <!-- who -->
      <div class="s20__who">
        <span class="s20__mark" aria-hidden="true">
          <?= xe_svg('xe-mark') ?>
        </span>
        <p class="s20__org">Xterra Edze</p>
        <h3 class="h3 s20__title">Discovery call</h3>
        <p class="s20__blurb">Tell us what you're building and we'll tell you straight whether we're
          the right team for it. No deck, no discovery theatre.</p>
        <ul class="s20__meta">
          <li>
            <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><circle cx="8" cy="8" r="6.2" stroke="currentColor" stroke-width="1.3"/><path d="M8 4.6V8l2.4 1.4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
            30 min
          </li>
          <li>
            <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><rect x="1.6" y="3.6" width="9" height="8.8" rx="1.6" stroke="currentColor" stroke-width="1.3"/><path d="m10.6 7.4 3.8-2.2v5.6l-3.8-2.2z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/></svg>
            Google Meet
          </li>
          <li>
            <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><circle cx="8" cy="8" r="6.2" stroke="currentColor" stroke-width="1.3"/><path d="M1.9 8h12.2M8 1.8c1.7 1.8 2.6 4 2.6 6.2S9.7 12.4 8 14.2C6.3 12.4 5.4 10.2 5.4 8S6.3 3.6 8 1.8Z" stroke="currentColor" stroke-width="1.3"/></svg>
            <span data-s20-tz>Your local time</span>
          </li>
        </ul>
        <!-- PLACEHOLDER: confirm the one-working-day response time before launch -->
        <p class="s20__note">We reply to every brief within one working day.</p>
      </div>

      <!-- when -->
      <div class="s20__cal">
        <div class="s20__calhead">
          <p class="s20__month" id="s20-month" aria-live="polite" data-s20-month><?= e($s20_view->format('F Y')) ?></p>
          <div class="s20__navs">
            <a class="s20__nav" data-s20-prevm aria-label="Previous month"<?= $s20_prev ? ' href="' . $s20_href(['s20m' => $s20_prev->format('Y-m')]) . '" rel="nofollow"' : ' aria-disabled="true"' ?>>
              <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 3 5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <a class="s20__nav" data-s20-nextm aria-label="Next month"<?= $s20_next ? ' href="' . $s20_href(['s20m' => $s20_next->format('Y-m')]) . '" rel="nofollow"' : ' aria-disabled="true"' ?>>
              <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
          </div>
        </div>
        <table class="s20__grid" aria-labelledby="s20-month" data-s20-grid>
          <thead>
            <tr><th scope="col" abbr="Monday">Mon</th><th scope="col" abbr="Tuesday">Tue</th><th scope="col" abbr="Wednesday">Wed</th><th scope="col" abbr="Thursday">Thu</th><th scope="col" abbr="Friday">Fri</th><th scope="col" abbr="Saturday">Sat</th><th scope="col" abbr="Sunday">Sun</th></tr>
          </thead>
          <tbody data-s20-days>
            <?php foreach (array_chunk($s20_days, 7) as $s20_week): ?>
              <tr<?= array_filter($s20_week, $s20_open) ? '' : ' class="is-quiet"' ?>>
                <?php foreach ($s20_week as $s20_d):
                  $s20_cls = 's20__d'
                    . ($s20_d->format('m') !== $s20_view->format('m') ? ' is-out' . ($s20_d < $s20_view ? ' is-before' : '') : '')
                    . ($s20_d == $s20_today ? ' is-today' : '')
                    . ($s20_sel && $s20_d == $s20_sel ? ' is-sel' : '');
                  $s20_lab = $s20_dayname($s20_d) . ($s20_d == $s20_today ? ', today' : ''); ?>
                  <td><?php if ($s20_open($s20_d)): ?><a class="<?= $s20_cls ?>" href="<?= $s20_href(['s20d' => $s20_ymd($s20_d)]) ?>" rel="nofollow" aria-label="<?= e($s20_lab . ' — choose this day') ?>"<?= $s20_sel && $s20_d == $s20_sel ? ' aria-current="true"' : '' ?>><?= $s20_d->format('j') ?></a><?php else: ?><span class="<?= $s20_cls ?> is-off"><?= $s20_d->format('j') ?></span><?php endif; ?></td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- slots / confirm -->
      <div class="s20__slots">
        <div class="s20__slotshead">
          <p class="s20__day" data-s20-daylabel><?= $s20_sel ? e($s20_dayname($s20_sel)) : 'Pick a day' ?></p>
          <div class="s20__fmt" role="radiogroup" aria-label="Time format" data-s20-fmtg hidden>
            <button class="s20__fmtb is-on" type="button" role="radio" aria-checked="true" data-s20-fmt="12">12h</button>
            <button class="s20__fmtb" type="button" role="radio" aria-checked="false" tabindex="-1" data-s20-fmt="24">24h</button>
          </div>
        </div>

        <div class="s20__times" data-s20-times<?= $s20_pick !== null ? ' hidden' : '' ?>>
          <?php if (!$s20_sel): ?>
            <p class="s20__empty">Choose a day to see open times.</p>
          <?php else: ?>
            <ul class="s20__tlist" aria-label="Open times, <?= e($s20_dayname($s20_sel)) ?>">
              <?php foreach ($s20_slots as $s20_m): ?>
                <li><a class="s20__time" href="<?= $s20_href(['s20d' => $s20_ymd($s20_sel), 's20t' => $s20_m]) ?>" rel="nofollow"><?= $s20_time($s20_m) ?></a></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>

        <form class="s20__form" action="<?= e(xe_url('contact.php')) ?>" method="post" data-s20-form<?= $s20_pick === null ? ' hidden' : '' ?>>
          <input type="hidden" name="from" value="home">
          <input type="hidden" name="t" value="<?= e($s20_token) ?>">
          <p class="s20__picked" data-s20-picked><?= $s20_when !== '' ? e($s20_dayname($s20_sel)) . '&nbsp;· ' . e($s20_time($s20_pick)) : '' ?></p>
          <label class="s20__field">
            <span>Name</span>
            <input type="text" name="name" autocomplete="name" maxlength="120" data-book-first required>
          </label>
          <label class="s20__field">
            <span>Work email</span>
            <input type="email" name="email" autocomplete="email" maxlength="190" required>
          </label>
          <label class="s20__field">
            <span>Company</span>
            <input type="text" name="company" autocomplete="organization" maxlength="160">
          </label>
          <label class="s20__field">
            <span>What are you building?</span>
            <textarea id="book-brief" name="message" rows="3" maxlength="3800" required data-s20-brief><?= e($s20_msg) ?></textarea>
          </label>
          <p class="s20__err" data-s20-err role="alert" hidden></p>
          <div class="s20__actions">
            <a class="s20__back" href="<?= $s20_sel ? $s20_href(['s20d' => $s20_ymd($s20_sel)]) : '#book' ?>" rel="nofollow" data-s20-back>Back</a>
            <button class="btn btn--ink" type="submit">Request this time <span class="i" aria-hidden="true">›</span></button>
          </div>
          <p class="s20__donen">Nothing is reserved yet — we'll confirm by email within one working day.</p>
        </form>

        <p class="sr" aria-live="polite" data-s20-live></p>
      </div>

    </div>
  </div>
</section>
