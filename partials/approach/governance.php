<?php /* DRAFT COPY — review before launch */
/* Governance — who owns what, what you can always see, and how to escalate. The weekly calendar that used
   to live here is now its own section (#rhythm); this one is about accountability: a responsibility table
   with a named role on each side, the four artefacts you always have access to, a sample decision log, and
   the escalation ladder with the time we aim to answer on. */
// PLACEHOLDER: confirm role names and escalation response targets before launch
$gv_own = [
  ['The order of the work',            'Product owner',            'Product lead',                'Weekly, at backlog triage'],
  ['The problem and the budget',       'Executive sponsor',        'Programme lead',              'At each gate'],
  ['Whether it ships',                 'IT or security reviewer',  'Tech lead',                   'Per release'],
  ['What it is allowed to claim',      'Brand or legal reviewer',  'Content designer',            'Per asset, before publication'],
  ['Personal data and consent',        'Data protection owner',    'Security engineer',           'At design, and on any change of purpose'],
  ['The service once it is live',      'Operations owner',         'Service owner',               'Monthly, against service levels'],
  ['Guardrails and eval thresholds',   'Named approver',           'QA and eval engineer',        'On change — both signatures, old value kept'],
];
$gv_access = [
  ['clipboard-check', 'The shared backlog',  'One list, ranked by your product owner, visible to everyone on both sides. There is no second, private list.'],
  ['doc',             'The decision log',    'What was decided, why, by whom, and what it replaced. Written the same working day.'],
  ['dashboard',       'The quality board',   'Eval scores, Web Vitals, open risks, spend against budget and carbon per unit — live, not a screenshot.'],
  ['log',             'The audit log export', 'Every agent action, on request, in a format your auditors can read without us in the room.'],
];
$gv_log = [
  ['D-041', 'Launch three markets first, the fourth later', 'Legal review time in market four', 'Sponsor', 'Approved'],
  ['D-042', 'Raise the tone eval threshold to 0.85', 'Two drafts passed that read off-brand', 'Brand lead', 'Approved'],
  ['D-043', 'Keep human review on all refund answers', 'Low volume, high consequence', 'Support lead', 'Approved'],
  ['D-044', 'Move search to a hosted vector index', 'Cost against latency, decision needs a number', 'Tech lead', 'Open'],
];
$gv_esc = [
  ['01', 'The squad',            'Anything about the work itself: a decision that feels wrong, a stuck ticket, a quality concern.',
   'Raise it in the channel or in any standing meeting. It is answered or given an owner the same working day.'],
  ['02', 'The programme lead',   'Pace, priorities, the make-up of the team, or a decision the squad cannot settle.',
   'A call within one working day, and a written outcome in the decision log.'],
  ['03', 'Your sponsor and our director', 'Commercial disagreement, a service-level breach, or anything you would rather not raise with the team.',
   'A meeting within two working days, with a written position from us before it, not after.'],
];
?>
<section class="band apr-gv" id="governance" aria-labelledby="governance-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Who owns what</p>
        <h2 class="h2" id="governance-t"><span class="g">One backlog, one log,</span> and a name against everything.</h2>
      </div>
      <div>
        <p class="lead">Accountability is written down before the work starts: a named role on your side and a named role on ours for every decision that matters. You see the same board we work from, the same scores, and every decision with its reason.</p>
      </div>
    </div>

    <div class="apr-gv__own">
      <p class="apr-k" id="apr-gv-own">Responsibility · one name on each side</p>
      <div class="bdh-scroll-x mask-x apr-nomask" tabindex="0" role="region" aria-labelledby="apr-gv-own">
        <table class="apr-gv__otbl">
          <thead><tr><th scope="col">Decision</th><th scope="col">Owner · your side</th><th scope="col">Owner · our side</th><th scope="col">Reviewed</th></tr></thead>
          <tbody>
            <?php foreach ($gv_own as $gv_o): ?>
            <tr>
              <th scope="row"><?= e($gv_o[0]) ?></th>
              <td><span class="apr-gv__you"><?= e($gv_o[1]) ?></span></td>
              <td><span class="apr-gv__us"><?= e($gv_o[2]) ?></span></td>
              <td class="apr-gv__cad"><?= e($gv_o[3]) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="apr-gv__split">
      <div class="apr-gv__side">
        <h3 class="apr-gv__h">What you always have access to</h3>
        <ul class="apr-gv__l">
          <?php foreach ($gv_access as $gv_a): ?>
          <li><?= xt_icon($gv_a[0]) ?><span><b><?= e($gv_a[1]) ?>.</b> <?= e($gv_a[2]) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="apr-gv__tbl">
        <p class="apr-gv__cap" id="apr-dlog-cap">Decision log · Your company · sample</p>
        <div class="bdh-scroll-x mask-x apr-nomask" tabindex="0" role="region" aria-labelledby="apr-dlog-cap">
          <table class="apr-dlog">
            <thead><tr><th scope="col">ID</th><th scope="col">Decision</th><th scope="col">Because</th><th scope="col">Owner</th><th scope="col">State</th></tr></thead>
            <tbody>
              <?php foreach ($gv_log as $gv_r): ?>
              <tr><th scope="row"><?= e($gv_r[0]) ?></th><td><?= e($gv_r[1]) ?></td><td><?= e($gv_r[2]) ?></td><td><?= e($gv_r[3]) ?></td><td><span class="apr-st<?= $gv_r[4] === 'Open' ? ' apr-st--open' : '' ?>"><?= e($gv_r[4]) ?></span></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="apr-gv__foot">A sample log for a fictional “Your company”. Entries are written the same working day and never edited — a reversal is a new entry that names the one it replaces.</p>
      </div>
    </div>

    <div class="apr-gv__esc">
      <div class="apr-gv__eh">
        <p class="apr-k">Escalation</p>
        <h3 class="apr-gv__h">Three steps, and none of them are a surprise</h3>
        <p class="apr-gv__ed">You are told these on day one, with the names filled in. Using step three is not a failure; sitting on a problem is.</p>
      </div>
      <!-- PLACEHOLDER: confirm escalation response targets before launch -->
      <ol class="apr-gv__el">
        <?php foreach ($gv_esc as $gv_e): ?>
        <li>
          <span class="apr-gv__en"><?= e($gv_e[0]) ?></span>
          <h4 class="apr-gv__et"><?= e($gv_e[1]) ?></h4>
          <p class="apr-gv__ew"><?= e($gv_e[2]) ?></p>
          <p class="apr-gv__er"><span class="apr-k">What happens</span><?= e($gv_e[3]) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
