<?php /* DRAFT COPY — review before launch */
/* Rhythm — a week on a programme, drawn as the calendar you would actually receive. The grid is a diagram;
   every ceremony below it is a full row in a ledger with who attends, how long it takes and what comes out.
   Each block in the grid is a link to its ledger row, so it works without JavaScript; rhythm.js turns the
   pair into a linked highlight. Times are India Standard Time and are typical, not promised.
   Ceremony row: [key, day index or 'daily', start, end, name, who, length, what comes out, what you decide,
   short label for the calendar block] */
// PLACEHOLDER: confirm the standing calendar, attendees and turnaround times before launch
$rt_days  = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
$rt_from  = 9.5;
$rt_to    = 18.0;
$rt_slots = (int) round(($rt_to - $rt_from) * 4);              // 15-minute rows
$rt_row   = fn (float $rt_t): int => (int) round(($rt_t - $rt_from) * 4) + 1;
$rt_hm    = function (float $rt_t): string {
    $rt_h = (int) floor($rt_t); $rt_m = (int) round(($rt_t - $rt_h) * 60);
    return sprintf('%02d:%02d', $rt_h, $rt_m);
};
$rt_ev = [
  ['standup', 'daily', 9.75, 10.0,  'Stand-up',                   'Our squad. Your team is welcome, never expected.',            '15 min',
     'A written summary in your channel: what moved, what is stuck, what an agent flagged overnight.',
     'Nothing. It exists so the rest of the day does not need interrupting.', 'Stand-up'],
  ['triage',  0, 11.0, 11.75, 'Backlog triage',             'Your product owner · our tech lead and product lead.',        '45 min',
     'One ranked backlog for the week, visible to both sides.',
     'The order of the work. Agents pre-rank by value and effort overnight; your product owner sets the final order.', 'Backlog triage'],
  ['design',  1, 15.0, 16.0,  'Design and content review',  'Your brand lead · our product and content designers.',        '60 min',
     'Decisions on the frames and the words that are ready, written into the decision log.',
     'What ships as designed, what gets another pass, and what wording you can stand behind.', 'Design review'],
  ['quality', 2, 16.0, 16.75, 'Quality and risk review',    'Our tech lead, QA and security engineers · your IT reviewer, monthly.', '45 min',
     'Eval scores, guardrail holds, performance budgets and the open risk list, each with an owner.',
     'What is red, who owns it, and by when. Nothing leaves this meeting unowned.', 'Quality review'],
  ['demo',    3, 15.5, 16.5,  'Demo',                       'Anyone on your side who wants to come.',                       '60 min',
     'Working software on a preview environment you can open yourself, and the recording afterwards.',
     'Whether what you asked for is what you got — while it is still cheap to change.', 'Demo'],
  ['review',  4, 15.0, 15.75, 'Weekly review',              'Your sponsor or product owner · our programme lead.',          '45 min',
     'What shipped, what did not and why, the decisions taken, and next week agreed.',
     'Next week’s goal, and anything that needs to escalate.', 'Weekly review'],
  ['note',    4, 17.0, 17.5,  'Week note posted',           'No meeting. Written and posted.',                              'Async',
     'A one-page note: progress against the sprint goal, decisions, risks, spend to date and what needs you next week.',
     'Nothing on the spot. It is the thing you forward to people who were not in the room.', 'Week note'],
];
$rt_focus = ['Build time', 10.25, 13.0, 'Protected build time: no standing meetings before 13:00.'];
$rt_night = [
  ['Eval suite', 'The golden set runs against every AI route that changed that day.'],
  ['Security scans', 'Dependency, container, secret and prompt-injection suites on the branch.'],
  ['Batch and drift', 'Overnight jobs, plus a check for eval drift after any model or data change.'],
  ['Morning summary', 'Results are on the board before stand-up. A person reads them first.'],
];
$rt_cad = [
  ['calendar', 'Monthly',   'A service report you can forward without editing: service levels, eval scores, spend against budget, carbon per unit, and the risk register as it now stands.'],
  ['target',   'Quarterly', 'An outcome review against the measures agreed in Define — the same numbers, not new ones — then a roadmap reset and a written retrospective.'],
  ['alert',    'On demand', 'A written incident review after any severity 1 or 2, within five working days, whether or not you asked for one.'],
];
$rt_never = [
  ['A decision without a reason', 'Every decision in the log carries why, who decided, and what it replaced.'],
  ['A status deck', 'Demos are working software. The written week note replaces the deck entirely.'],
  ['Chasing an answer', 'A blocking question gets an answer or an owner the same working day.'],
  ['A surprise invoice', 'Spend to date is in the week note, before the invoice arrives.'],
];
?>
<section class="band apr-rt" id="rhythm" aria-labelledby="rhythm-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>A week on a programme</p>
        <h2 class="h2" id="rhythm-t"><span class="g">Two and a half hours</span> of your week. The rest is written down.</h2>
      </div>
      <div>
        <p class="lead">This is the standing calendar, not an ideal one. Your product owner has three meetings; everyone else attends what is useful to them. Everything else arrives in writing, on a schedule you can plan around.</p>
        <p class="apr-rt__tz"><span class="bdh-ill">Typical</span> Times shown in India Standard Time (UTC+5:30) and agreed per programme.</p>
      </div>
    </div>

    <div class="apr-rt__grid" data-apr-rhythm>
      <div class="apr-rt__calwrap">
        <p class="apr-k apr-rt__ck" id="apr-rt-cap">The standing week · 09:30 – 18:00 IST</p>
        <p class="bdh-sr">A calendar of a typical week. A fifteen-minute stand-up runs at 09:45 every day and the morning to 13:00 is protected build time with no standing meetings. Backlog triage is Monday at 11:00 for 45 minutes; design and content review Tuesday at 15:00 for an hour; quality and risk review Wednesday at 16:00 for 45 minutes; the demo Thursday at 15:30 for an hour; the weekly review Friday at 15:00 for 45 minutes; and the written week note is posted Friday at 17:00. A marker at 13:30 shows where the overlap window with Europe and the Gulf opens. Each is described in full in the ledger that follows.</p>
        <div class="bdh-scroll-x mask-x apr-nomask apr-rt__scroll" tabindex="0" role="region" aria-labelledby="apr-rt-cap">
          <div class="apr-rt__cal" style="--rt-rows:<?= $rt_slots ?>">
            <span class="apr-rt__corner" aria-hidden="true">IST</span>
            <?php foreach ($rt_days as $rt_di => $rt_d): ?>
              <span class="apr-rt__day" aria-hidden="true" style="grid-column:<?= $rt_di + 2 ?>"><?= e($rt_d) ?></span>
            <?php endforeach; ?>
            <?php for ($rt_h = (int) ceil($rt_from); $rt_h < (int) $rt_to; $rt_h++): ?>
              <span class="apr-rt__hr" aria-hidden="true" style="grid-row:<?= $rt_row((float) $rt_h) ?> / span 4"><?= sprintf('%02d:00', $rt_h) ?></span>
              <span class="apr-rt__line" aria-hidden="true" style="grid-row:<?= $rt_row((float) $rt_h) ?>"></span>
            <?php endfor; ?>
            <?php foreach ($rt_days as $rt_di => $rt_d): ?>
              <span class="apr-rt__focus" aria-hidden="true" style="grid-column:<?= $rt_di + 2 ?>;grid-row:<?= $rt_row($rt_focus[1]) ?> / span <?= (int) round(($rt_focus[2] - $rt_focus[1]) * 4) ?>"><?= $rt_di === 0 ? e($rt_focus[0]) : '' ?></span>
            <?php endforeach; ?>
            <span class="apr-rt__mark" aria-hidden="true" style="grid-row:<?= $rt_row(13.5) ?>"><b>13:30</b>The overlap window opens</span>
            <?php foreach ($rt_ev as $rt_e): ?>
              <?php foreach ($rt_e[1] === 'daily' ? array_keys($rt_days) : [$rt_e[1]] as $rt_di): ?>
              <a class="apr-rt__ev is-<?= e($rt_e[0]) ?><?= $rt_e[6] === 'Async' ? ' is-async' : '' ?>" href="#apr-rt-<?= e($rt_e[0]) ?>" data-apr-ev="<?= e($rt_e[0]) ?>"
                 style="grid-column:<?= $rt_di + 2 ?>;grid-row:<?= $rt_row($rt_e[2]) ?> / span <?= max(2, (int) round(($rt_e[3] - $rt_e[2]) * 4)) ?>">
                <b><?= e($rt_e[9]) ?></b><span><?= e($rt_hm($rt_e[2])) ?>–<?= e($rt_hm($rt_e[3])) ?></span>
              </a>
              <?php endforeach; ?>
            <?php endforeach; ?>
          </div>
        </div>
        <p class="apr-rt__legend"><span class="apr-rt__lg is-focus"><i aria-hidden="true"></i><?= e($rt_focus[3]) ?></span></p>

        <div class="apr-rt__night">
          <p class="apr-k"><?= xt_icon('clock', ['size' => 14]) ?> Overnight · 22:00 – 06:00 IST, while nobody is watching</p>
          <ul class="apr-rt__nl">
            <?php foreach ($rt_night as $rt_n): ?><li><b><?= e($rt_n[0]) ?></b><span><?= e($rt_n[1]) ?></span></li><?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="apr-rt__side">
        <!-- PLACEHOLDER: reference photograph (Unsplash, credited in assets/imgs/approach/CREDITS.md) — replace with Xterra Edze's own photography before launch -->
        <figure class="bdh-img bdh-img--r43 apr-rt__fig" data-rv>
          <img src="<?= xe_url('assets/imgs/approach/rhythm-review.jpg') ?>" alt="Colleagues reviewing printed documents together at a table" width="1200" height="675" loading="lazy" decoding="async">
          <span class="bdh-cap-chip apr-rt__chip"><b>Wednesday · quality and risk</b>Anything red leaves the room with an owner and a date</span>
        </figure>
        <ul class="apr-rt__never">
          <?php foreach ($rt_never as $rt_v): ?>
          <li><span class="apr-rt__nx" aria-hidden="true">—</span><div><b><?= e($rt_v[0]) ?></b><span><?= e($rt_v[1]) ?></span></div></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="apr-rt__ledger">
      <p class="apr-k apr-rt__lk" id="apr-rt-ledger">Every standing item, in full</p>
      <div class="bdh-scroll-x mask-x apr-nomask" tabindex="0" role="region" aria-labelledby="apr-rt-ledger">
        <table class="apr-rt__tbl">
          <thead><tr><th scope="col">Item</th><th scope="col">When</th><th scope="col">Who is in it</th><th scope="col">What comes out</th><th scope="col">What you decide</th></tr></thead>
          <tbody>
            <?php foreach ($rt_ev as $rt_e): ?>
            <tr id="apr-rt-<?= e($rt_e[0]) ?>" data-apr-row="<?= e($rt_e[0]) ?>">
              <th scope="row"><b><?= e($rt_e[4]) ?></b><span><?= e($rt_e[6]) ?></span></th>
              <td class="apr-rt__when"><?= $rt_e[1] === 'daily' ? 'Every day' : e($rt_days[$rt_e[1]]) ?> · <?= e($rt_hm($rt_e[2])) ?></td>
              <td><?= e($rt_e[5]) ?></td>
              <td><?= e($rt_e[7]) ?></td>
              <td><?= e($rt_e[8]) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <ul class="apr-rt__cad" data-rv-s data-rv-step="70">
      <?php foreach ($rt_cad as $rt_c): ?>
      <li><span class="apr-rt__ci" aria-hidden="true"><?= xt_icon($rt_c[0], ['size' => 18]) ?></span><h3 class="bdh-t bdh-t--s"><?= e($rt_c[1]) ?></h3><p class="bdh-d"><?= e($rt_c[2]) ?></p></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
