<?php /* DRAFT COPY — review before launch */
/* Global — how a day works from New Delhi and Ludhiana when the people paying for the work are somewhere
   else. A day ledger rather than a clock: nine moments of an Indian working day, each stamped in six time
   zones, computed from today's date so daylight saving is right rather than assumed. global.js marks the
   column nearest the reader's own offset; without JavaScript every column is on the page already.
   Studio hours, the extended shift and on-call coverage are to be confirmed. */
// PLACEHOLDER: confirm studio hours, the extended shift, on-call coverage and same-day commitments before launch
$gb_zones = [
  ['ist',  'India',       'Asia/Kolkata'],
  ['lon',  'London',      'Europe/London'],
  ['fra',  'Frankfurt',   'Europe/Berlin'],
  ['dxb',  'Dubai',       'Asia/Dubai'],
  ['sin',  'Singapore',   'Asia/Singapore'],
  ['nyc',  'New York',    'America/New_York'],
];
$gb_today = new DateTime('today', new DateTimeZone('Asia/Kolkata'));
$gb_at = function (string $gb_hm, string $gb_tz) use ($gb_today): array {
    $gb_d = new DateTime($gb_today->format('Y-m-d') . ' ' . $gb_hm, new DateTimeZone('Asia/Kolkata'));
    $gb_l = (clone $gb_d)->setTimezone(new DateTimeZone($gb_tz));
    $gb_shift = (int) $gb_l->format('Yz') <=> (int) $gb_d->format('Yz');
    return [$gb_l->format('H:i'), $gb_shift];   // [local time, -1 previous day · 0 same day · +1 next day]
};
$gb_off = function (string $gb_tz) use ($gb_today): string {
    $gb_o = (new DateTimeZone($gb_tz))->getOffset(new DateTime('now', new DateTimeZone('UTC'))) / 3600;
    $gb_s = $gb_o < 0 ? '−' : '+';
    $gb_a = abs($gb_o);
    $gb_m = (int) round(($gb_a - floor($gb_a)) * 60);
    return 'UTC' . $gb_s . (int) floor($gb_a) . ($gb_m ? sprintf(':%02d', $gb_m) : '');
};
$gb_day = [
  // [IST time, moment, what happens, kind: agent | work | talk | write]
  ['07:00', 'Overnight results are read',  'The eval suite, the scans and the batch jobs finished hours ago. A person reads them before anyone is asked to.', 'agent'],
  ['09:45', 'Stand-up',                    'Fifteen minutes for the squad. A written summary lands in your channel within the hour, whether or not you attended.', 'write'],
  ['10:00', 'Build time opens',            'No standing meetings before 13:00. Questions are answered in writing, so nobody has to wait for a calendar slot.', 'work'],
  ['13:30', 'The Gulf and Europe come on', 'The first overlap window opens. Anything that needs a European voice is scheduled from here.', 'talk'],
  ['15:00', 'Calls, reviews and demos',    'Standing meetings sit in this window by design, so your calendar is not the constraint on our day.', 'talk'],
  ['18:00', 'US East comes on',            'The UK overlap still holds. This is the last window where three regions are awake at once.', 'talk'],
  ['19:00', 'Written handover posted',     'What moved, what is waiting on a decision from you, and what will run overnight. It is on your desk before your morning.', 'write'],
  ['20:30', 'Extended shift, by agreement','For a launch, a migration or a US-hours programme. Agreed in the statement of work, never assumed.', 'work'],
  ['22:00', 'Overnight runs and on-call',  'Agents run the evals, scans and batch work. A person is on the rota for anything live.', 'agent'],
];
$gb_kind = ['agent' => 'Agents', 'work' => 'Focus', 'talk' => 'Overlap', 'write' => 'Written'];
$gb_runs = [
  'New Delhi' => ['Client and programme leadership', 'Solution architecture and AI engineering', 'Security, audit and assessment work'],
  'Ludhiana'  => ['Platform, product and web engineering', 'Data, QA and eval engineering', 'Managed service, support and the on-call rota'],
];
$gb_studios = $SITE['company']['studios'] ?? [];
$gb_async = [
  ['doc',   'A decision request, not a meeting request', 'Options, the recommendation, what it costs, and the date after which we will take the recommendation as agreed.'],
  ['browser', 'A recorded demo you can watch at 07:00', 'Every demo is recorded and linked from the week note, with timestamps against each item.'],
  ['log',   'One channel, one thread per decision',      'No decision lives in a direct message. If it is not in the channel and the log, it did not happen.'],
  ['clock', 'A named window for your questions',         'One block in our day is held for your team, so a question is never queued behind our calendar.'],
];
$gb_same = [
  ['A blocking question', 'Answered, or given an owner and a time, before our day ends.'],
  ['A severity 1',        'Acknowledged within minutes, around the clock, on the rota.'],
  ['A decision you make', 'In the decision log the same working day it is taken.'],
];
?>
<section class="band apr-gb" id="global" aria-labelledby="global-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Your hours, our day</p>
        <h2 class="h2" id="global-t"><span class="g">Two studios in India.</span> A day written down as it ends.</h2>
      </div>
      <div>
        <p class="lead">We work from New Delhi and Ludhiana on India Standard Time. The part that matters is not the overlap window — it is what reaches you when there is no overlap: a written handover posted at the end of our day, on your desk before your morning starts.</p>
      </div>
    </div>

    <div class="apr-gb__day" data-apr-global>
      <div class="apr-gb__top">
        <p class="apr-k" id="apr-gb-cap">One working day, in six clocks</p>
        <p class="apr-gb__note">Computed for today, <?= e($gb_today->format('j F Y')) ?>, so daylight saving is right rather than assumed. <span class="apr-gb__you" hidden data-apr-you></span></p>
      </div>
      <div class="bdh-scroll-x mask-x apr-nomask apr-gb__scroll" tabindex="0" role="region" aria-labelledby="apr-gb-cap">
        <p class="bdh-sr" id="apr-gb-desc">An Indian working day in six time zones. Each row is a moment in the day with what happens; the columns give the local time in India, London, Frankfurt, Dubai, Singapore and New York. A plus one means the following day locally, a minus one the previous day.</p>
        <table class="apr-gb__tbl" aria-labelledby="apr-gb-cap" aria-describedby="apr-gb-desc">
          <thead>
            <tr>
              <th scope="col" class="apr-gb__mh">In our day</th>
              <?php foreach ($gb_zones as $gb_z): ?>
              <th scope="col" class="apr-gb__zh is-<?= e($gb_z[0]) ?>" data-apr-z="<?= e($gb_z[2]) ?>"><b><?= e($gb_z[1]) ?></b><span><?= e($gb_off($gb_z[2])) ?></span></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($gb_day as $gb_r): ?>
            <tr class="is-<?= e($gb_r[3]) ?>">
              <th scope="row">
                <span class="apr-gb__kind"><?= e($gb_kind[$gb_r[3]]) ?></span>
                <b><?= e($gb_r[1]) ?></b>
                <span class="apr-gb__what"><?= e($gb_r[2]) ?></span>
              </th>
              <?php foreach ($gb_zones as $gb_z): $gb_t = $gb_at($gb_r[0], $gb_z[2]); ?>
              <td class="apr-gb__t is-<?= e($gb_z[0]) ?>" data-apr-z="<?= e($gb_z[2]) ?>">
                <span class="apr-gb__hm"><?= e($gb_t[0]) ?></span>
                <?php if ($gb_t[1] !== 0): ?><span class="apr-gb__dy"><?= $gb_t[1] > 0 ? '+1' : '−1' ?><span class="sr"><?= $gb_t[1] > 0 ? ' the next day' : ' the previous day' ?></span></span><?php endif; ?>
              </td>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="apr-gb__grid">
      <div class="apr-gb__studios">
        <p class="apr-k">Where the work sits</p>
        <!-- PLACEHOLDER: confirm which teams sit in which studio, and the New Delhi address, before launch -->
        <ul class="apr-gb__sl">
          <?php foreach ($gb_studios as $gb_s): ?>
          <li>
            <h3 class="apr-gb__st"><?= e($gb_s['city']) ?></h3>
            <p class="apr-gb__ad"><?php foreach (array_merge($gb_s['units'] ?? [], $gb_s['lines'] ?? []) as $gb_li => $gb_l2): ?><?= $gb_li ? '<br>' : '' ?><?= e($gb_l2) ?><?php endforeach; ?></p>
            <ul class="apr-gb__rl"><?php foreach ($gb_runs[$gb_s['city']] ?? [] as $gb_x): ?><li><?= e($gb_x) ?></li><?php endforeach; ?></ul>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="apr-gb__async">
        <p class="apr-k">When there is no overlap</p>
        <h3 class="apr-gb__h">Four habits that make the gap useful instead of expensive</h3>
        <ul class="apr-gb__al">
          <?php foreach ($gb_async as $gb_a): ?>
          <li><span class="apr-gb__ai" aria-hidden="true"><?= xt_icon($gb_a[0], ['size' => 18]) ?></span><div><b><?= e($gb_a[1]) ?></b><span><?= e($gb_a[2]) ?></span></div></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm same-day commitments and on-call coverage before launch -->
    <ul class="apr-gb__same" data-rv-s data-rv-step="70">
      <?php foreach ($gb_same as $gb_m): ?>
      <li><p class="apr-k">Same working day</p><b><?= e($gb_m[0]) ?></b><span><?= e($gb_m[1]) ?></span></li>
      <?php endforeach; ?>
      <li class="apr-gb__lang"><p class="apr-k">Working language</p><b>English</b><span>Hindi and Punjabi in the studios. Delivery, documentation and every written artefact are in English.</span></li>
    </ul>
  </div>
</section>
