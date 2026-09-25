<?php /* DRAFT COPY — review before launch */
/* Recovery — what happens when the bars in the section above are not met. Two halves: before release, a
   failed gate stops the change and an override is a written act with a name on it; after release, a
   severity ladder, a worked incident timeline and the review that follows. The timeline ships finished;
   recovery.js only replays it while it is on screen. Every target is a target, not a promise, and every
   figure in the worked example is illustrative. */
// PLACEHOLDER: confirm severity definitions, response targets and service credits with counsel before launch
$rc_before = [
  ['eval',   'An eval falls below its threshold', 'The merge is blocked. guard.release opens a ticket with the failing cases attached and the branch stays where it is.'],
  ['gauge',  'A performance budget is breached',  'The build fails on the budget, not on someone noticing. The regression is named in the pull request.'],
  ['scan',   'A scan finds a critical issue',     'The release stops. Critical and high findings are fixed before merge; the rest are ticketed with a due date.'],
  ['approve','A reviewer asks for changes',       'Nothing merges. Agents cannot override a human decision, and there is no path around it in the pipeline.'],
];
$rc_sev = [
  // [level, definition, who is woken, response target, update cadence, what stops]
  ['Sev 1', 'Service down, data at risk, or a safety or privacy incident.',
   'On-call engineer paged at once · service owner · your operations owner',
   'Acknowledged within minutes, around the clock', 'Written update every 30 minutes until mitigated',
   'All feature work. The squad is on the incident.'],
  ['Sev 2', 'A major function degraded with no workaround, or a security finding under active exploit.',
   'On-call engineer paged · tech lead',
   'Acknowledged within the hour, around the clock', 'Written update every two hours',
   'The sprint goal is renegotiated the same day.'],
  ['Sev 3', 'Degraded, with a workaround people can use.',
   'Raised to the squad in hours',
   'Acknowledged the next working day', 'In the daily stand-up summary',
   'Nothing. It is ranked into the current sprint.'],
  ['Sev 4', 'Cosmetic, or an annoyance with no material impact.',
   'Logged to the backlog',
   'Triaged at the next backlog triage', 'In the Friday week note',
   'Nothing. It takes its place in the order you set.'],
];
$rc_run = [
  // [offset, actor kind, actor, what happened]
  ['T+0',      'agent',  'watch.live',   'Error rate on the checkout API crosses the alert threshold. Detected by monitoring, not by a customer.'],
  ['T+1 min',  'agent',  'watch.live',   'On-call engineer paged. Incident opened automatically with the traces and the release attached.'],
  ['T+4 min',  'agent',  'watch.live',   'Rolled back to the previous known-good release, inside its standing permission. Every step logged.'],
  ['T+12 min', 'person', 'On-call',      'Service confirmed healthy against the dashboards. First written update posted to your channel.'],
  ['T+2 h',    'person', 'Tech lead',    'Contributing cause found: an unbounded retry in a downstream call under a cold cache.'],
  ['T+1 day',  'person', 'Squad',        'Fix shipped behind the usual gates, with a regression test and an eval case added for it.'],
  ['T+5 days', 'person', 'Service owner','Written review sent: timeline, contributing causes, actions with owners and dates.'],
];
$rc_review = [
  ['A timeline, minute by minute', 'What happened and when, taken from the logs rather than from memory.'],
  ['Contributing causes, plural',  'Systems fail for several reasons at once. We look for all of them, and we do not name a person as one.'],
  ['Actions with owners and dates', 'Tracked on the same backlog as the feature work, so they are visible and can be chased.'],
  ['A change to the system',       'A new test, an eval case, a guardrail, an alert or a runbook line — so the same failure cannot be silent twice.'],
];
$rc_cost = [
  ['Rework on our own defect',   'Not billed. Fixing what we got wrong is not a change request.'],
  ['Service credits',            'Where a service level is agreed, credits are written into the contract with the measurement that triggers them.'],
  ['What we need from you',      'A named contact reachable out of hours, and access we can actually use during an incident.'],
];
?>
<section class="band band--ink apr-rc" id="recovery" aria-labelledby="recovery-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>When it fails</p>
        <h2 class="h2" id="recovery-t"><span class="g">Everything fails eventually.</span> What matters is what happens next.</h2>
      </div>
      <div>
        <p class="lead">Before release, a failed gate stops the change and an override is a written act with a name on it. After release, there is a severity ladder, a rota that is actually staffed, and a review you receive whether or not you asked for one.</p>
      </div>
    </div>

    <div class="apr-rc__before">
      <p class="apr-k apr-rc__k">Before release · four ways a change is stopped</p>
      <ul class="apr-rc__bl">
        <?php foreach ($rc_before as $rc_b): ?>
        <li><span class="apr-rc__bi" aria-hidden="true"><?= xt_icon($rc_b[0], ['size' => 18]) ?></span><h3 class="bdh-t bdh-t--s"><?= e($rc_b[1]) ?></h3><p class="bdh-d"><?= e($rc_b[2]) ?></p></li>
        <?php endforeach; ?>
      </ul>
      <p class="apr-rc__ov"><span class="bdh-flag" aria-hidden="true">!</span><span><b>Overrides exist, and they are expensive on purpose.</b> A blocked gate can be overridden only by a named person, in writing, with the reason and the expiry recorded against the release. The override appears in your monthly report.</span></p>
    </div>

    <div class="apr-rc__sev">
      <p class="apr-k apr-rc__k" id="apr-rc-sev">After release · the severity ladder <span class="bdh-ill">Targets, not promises</span></p>
      <!-- PLACEHOLDER: confirm severity definitions and response targets before launch -->
      <div class="bdh-scroll-x mask-x apr-nomask" tabindex="0" role="region" aria-labelledby="apr-rc-sev">
        <table class="apr-rc__tbl">
          <thead><tr><th scope="col">Level</th><th scope="col">What it means</th><th scope="col">Who is woken</th><th scope="col">Response target</th><th scope="col">You hear from us</th><th scope="col">What stops</th></tr></thead>
          <tbody>
            <?php foreach ($rc_sev as $rc_i => $rc_s): ?>
            <tr class="<?= $rc_i < 2 ? 'is-hot' : '' ?>">
              <th scope="row"><span class="apr-rc__lv"><?= e($rc_s[0]) ?></span></th>
              <td><?= e($rc_s[1]) ?></td>
              <td><?= e($rc_s[2]) ?></td>
              <td><?= e($rc_s[3]) ?></td>
              <td><?= e($rc_s[4]) ?></td>
              <td><?= e($rc_s[5]) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="apr-rc__run" data-apr-run data-bdh-live>
      <div class="apr-rc__rh">
        <p class="apr-k">A worked incident, end to end <span class="bdh-ill">Illustrative</span></p>
        <h3 class="apr-rc__rt">Detected by a machine at midnight. Explained by a person by lunchtime.</h3>
      </div>
      <p class="bdh-sr">A sample incident timeline. At time zero the live watcher detects the checkout error rate crossing its threshold; within a minute it pages the on-call engineer and opens the incident with traces attached; at four minutes it rolls back to the previous known-good release; at twelve minutes the on-call engineer confirms the service is healthy and posts the first written update; at two hours the tech lead finds the contributing cause, an unbounded retry under a cold cache; the fix ships the next day behind the usual gates with a regression test and an eval case; and a written review with actions, owners and dates is sent within five working days.</p>
      <ol class="apr-rc__tl">
        <?php foreach ($rc_run as $rc_i => $rc_r): ?>
        <li class="is-done" style="--i:<?= $rc_i ?>" data-rc="<?= $rc_i ?>">
          <span class="apr-rc__node" aria-hidden="true"><i></i></span>
          <p class="apr-rc__t"><?= e($rc_r[0]) ?></p>
          <p class="apr-rc__who is-<?= e($rc_r[1]) ?>"><?= xt_icon($rc_r[1] === 'agent' ? 'agent' : 'users', ['size' => 13]) ?><?= e($rc_r[2]) ?></p>
          <p class="apr-rc__d"><?= e($rc_r[3]) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="apr-rc__after">
      <div class="apr-rc__rev">
        <p class="apr-k">The review, five working days later</p>
        <h3 class="apr-rc__rt">Blameless, written, and sent to you</h3>
        <ul class="apr-rc__rl">
          <?php foreach ($rc_review as $rc_v): ?>
          <li><b><?= e($rc_v[0]) ?></b><span><?= e($rc_v[1]) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="apr-rc__cost">
        <p class="apr-k">Who pays for what</p>
        <dl class="apr-rc__cl">
          <?php foreach ($rc_cost as $rc_c): ?>
          <div><dt><?= e($rc_c[0]) ?></dt><dd><?= e($rc_c[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
        <p class="apr-rc__leg">Service levels, credits and remedies are set in the signed agreement. <a href="<?= e(xe_url('legal/commercial-policy.php')) ?>">Commercial Policy</a> and <a href="<?= e(xe_url('legal/security.php')) ?>">Security</a> carry the standard positions.</p>
      </div>
    </div>
  </div>
</section>
