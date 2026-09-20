<?php /* DRAFT COPY — review before launch */
/* Console — anatomy of an internal tool. A desktop app mock (sidebar and saved views, filtered case list with
   bulk actions, record detail with an approval and activity, audit log) with six numbered design decisions.
   The notes are real buttons: pressing one frames its region in the mock and draws a leader line from the window
   edge under that region to the note. console.js tours the six decisions
   (filter and re-sort, keyboard bulk selection, an optimistic save, maker–checker approval, the hash-chained
   log, SSO) until a note is pressed. The HTML is the finished tour. */
$tcs_con_notes = [   // [region, title, text, tag]
    [1, 'Role-based access, enforced in the data', 'Roles decide which screens and actions exist. PostgreSQL row-level security decides which rows come back, so the same rule protects the API, exports and reports.', "USING (region = current_setting('app.region'))"],
    [2, 'Keyboard-first bulk work', 'J and K move, X selects, E assigns. People clear a queue without the mouse, and every bulk action previews what will change before it runs.', 'J · K · X · E'],
    [3, 'Optimistic updates', 'Changes show at once and reconcile with the server in the background. If someone else changed the record first, it rolls back and says why.', 'ETag · If-Match · 412'],
    [4, 'Maker–checker approvals', 'Refunds, credit limits and price overrides above a threshold need a second person, who can never be the one who asked.', 'Four eyes · above 50,000'],
    [5, 'An audit log nobody can edit', 'Every change is written append-only with who, what, before and after, and chained by hash so a missing entry is detectable.', 'Append-only · SHA-256 chain'],
    [6, 'Single sign-on and provisioning', 'People sign in through your identity provider. Accounts appear and disappear as people join and leave, with no local passwords.', 'SAML 2.0 · OIDC · SCIM 2.0'],
];
$tcs_con_rows = [   // [id, subject, priority, SLA minutes left, initial order, selected in the finished state]
    ['CASE-20940', 'Delivery slot missed twice',     'P1', 22,  1, true],
    ['CASE-20931', 'Refund for damaged delivery',    'P1', 38,  3, true],
    ['CASE-20944', 'Duplicate charge on card',       'P1', 51,  0, true],
    ['CASE-20928', 'Invoice address wrong on order', 'P2', 72,  4, false],
    ['CASE-20917', 'Partner portal sign-in fails',   'P2', 125, 5, false],
    ['CASE-20902', 'Warranty claim with photos',     'P2', 220, 6, false],
    ['CASE-20936', 'Change of billing contact',      'P2', 250, 2, false],
];
$tcs_con_sla = fn (int $m): string => $m >= 60 ? intdiv($m, 60) . 'h ' . str_pad((string) ($m % 60), 2, '0', STR_PAD_LEFT) . 'm' : $m . 'm';
$tcs_con_audit = [   // [time, event, change, actor, hash]
    ['10:44:02', 'approval.granted', 'refund CASE-20931',  'finance_lead',  'a41f…9d'],
    ['10:42:07', 'case.status',      'open → pending',     'ops_agent_14',  '9f2c…31'],
    ['10:40:51', 'refund.requested', 'amount 62,400',      'ops_agent_14',  '71be…c0'],
];
?>
<section class="band tcs-console" id="console" aria-labelledby="console-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>Internal tools · anatomy</p>
        <h2 class="h2" id="console-t"><span class="g">Internal tools your teams choose to open.</span> Designed around the work, not the table.</h2>
      </div>
      <div>
        <p class="lead">The screens are the part people see. The decisions underneath are what make a tool trusted: who can see which rows, how fast a queue clears, what needs a second pair of eyes, and what is written down forever.</p>
      </div>
    </div>

    <div class="tcs-con" data-rv>
      <div class="tcs-con__stage">
        <div class="bdh-ui tcs-app" aria-hidden="true">
          <div class="bdh-ui__bar tcs-app__bar">
            <span class="bdh-ui__dots"><i></i><i></i><i></i></span>
            <span class="tcs-app__url">ops.your-company.internal <i>/</i> cases</span>
            <span class="tcs-app__sso" data-region="6" data-pin-at="l"><?= xt_icon('key', ['size' => 14]) ?>SSO · OIDC · MFA</span>
            <span class="tcs-app__me">OA</span>
          </div>
          <div class="tcs-app__body">
            <aside class="tcs-app__side">
              <p class="tcs-app__ws"><span class="tcs-app__wsl">Y</span>Operations</p>
              <ul class="tcs-app__nav">
                <li><?= xt_icon('log', ['size' => 16, 'mono' => true]) ?>Inbox<b>12</b></li>
                <li class="is-on"><?= xt_icon('headset', ['size' => 16, 'mono' => true]) ?>Cases<b>214</b></li>
                <li><?= xt_icon('database', ['size' => 16, 'mono' => true]) ?>Accounts</li>
                <li><?= xt_icon('doc', ['size' => 16, 'mono' => true]) ?>Orders</li>
                <li><?= xt_icon('approve', ['size' => 16, 'mono' => true]) ?>Approvals<b class="is-blue">3</b></li>
                <li><?= xt_icon('chart', ['size' => 16, 'mono' => true]) ?>Reports</li>
              </ul>
              <p class="tcs-app__k">Saved views</p>
              <ul class="tcs-app__views">
                <li class="is-on">My open P1s</li><li>Refunds over 50,000</li><li>SLA at risk today</li>
              </ul>
              <p class="tcs-app__role">Role <b>ops_agent</b><span>Region West</span></p>
            </aside>

            <div class="tcs-app__list">
              <div class="tcs-app__tools">
                <span class="tcs-app__search"><?= xt_icon('search', ['size' => 14, 'mono' => true]) ?>Search cases<kbd>/</kbd></span>
                <span class="tcs-app__chip" data-con-filter>Status: Open</span>
                <span class="tcs-app__chip" data-con-filter>Priority: P1–P2</span>
                <span class="tcs-app__chip tcs-app__chip--rls" data-region="1"><?= xt_icon('lock', ['size' => 13, 'mono' => true]) ?>Region: West</span>
                <span class="tcs-app__count"><b data-con-count>214</b> of <span data-con-total>1,982</span> visible to your role</span>
              </div>
              <div class="tcs-app__bulk is-on" data-region="2">
                <span class="tcs-app__bn"><b data-con-sel>3</b> selected</span>
                <span class="tcs-app__ba">Assign<kbd>E</kbd></span><span class="tcs-app__ba">Change status<kbd>S</kbd></span><span class="tcs-app__ba">Escalate</span>
                <span class="tcs-app__keys"><kbd>J</kbd><kbd>K</kbd> move · <kbd>X</kbd> select</span>
              </div>
              <div class="tcs-app__thead"><span></span><span>Case</span><span>Subject</span><span>Priority</span><span>SLA left</span></div>
              <div class="tcs-app__rows">
                <?php foreach ($tcs_con_rows as $tcs_con_r): ?>
                  <div class="tcs-app__row<?= $tcs_con_r[5] ? ' is-sel' : '' ?><?= $tcs_con_r[0] === 'CASE-20931' ? ' is-cur' : '' ?>" data-id="<?= $tcs_con_r[0] ?>" data-sla="<?= $tcs_con_r[3] ?>" data-o="<?= $tcs_con_r[4] ?>">
                    <span class="tcs-app__cb"></span>
                    <span class="tcs-app__id"><?= e($tcs_con_r[0]) ?></span>
                    <span class="tcs-app__sub"><?= e($tcs_con_r[1]) ?></span>
                    <span class="tcs-app__pri tcs-app__pri--<?= strtolower($tcs_con_r[2]) ?>"><?= e($tcs_con_r[2]) ?></span>
                    <span class="tcs-app__sla<?= $tcs_con_r[3] < 45 ? ' is-risk' : '' ?>"><?= e($tcs_con_sla($tcs_con_r[3])) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
              <p class="tcs-app__page"><span data-con-page>1–7 of 214 · sorted by SLA left</span><span><kbd>⌘</kbd><kbd>↓</kbd> next page</span></p>
            </div>

            <div class="tcs-app__detail">
              <div class="tcs-app__dh">
                <span class="tcs-app__did">CASE-20931</span>
                <span class="tcs-app__status" data-region="3" data-pin-at="l"><span data-con-status>Approved</span><i data-con-save>Saved</i></span>
              </div>
              <p class="tcs-app__dt">Refund for damaged delivery</p>
              <dl class="tcs-app__fields">
                <div><dt>Account</dt><dd>Your company</dd></div>
                <div><dt>Order</dt><dd>ORD-48213</dd></div>
                <div><dt>Refund</dt><dd>62,400</dd></div>
                <div><dt>Owner</dt><dd>ops_agent_14</dd></div>
              </dl>
              <div class="tcs-app__appr is-done" data-region="4">
                <p class="tcs-app__ah"><?= xt_icon('approve', ['size' => 16]) ?>Second approval required<span>above 50,000</span></p>
                <p class="tcs-app__am"><span>Maker</span><b>ops_agent_14</b><span>Checker</span><b>finance_lead</b></p>
                <div class="tcs-app__abtn"><span class="tcs-app__ok">Approve</span><span class="tcs-app__no">Return</span><span class="tcs-app__adone">Approved by finance_lead · 10:44</span></div>
              </div>
              <ol class="tcs-app__act">
                <li><time>10:31</time>Case opened by the customer in the portal</li>
                <li><time>10:34</time>Order ORD-48213 linked automatically</li>
                <li><time>10:40</time>Refund requested by ops_agent_14</li>
                <li><time>10:42</time>Approval requested from finance_lead</li>
                <li data-con-act-appr><time>10:44</time>Refund approved by finance_lead</li>
              </ol>
            </div>
          </div>

          <div class="tcs-app__audit" data-region="5">
            <p class="tcs-app__auh"><span>Audit log</span><span class="tcs-app__chain"><?= xt_icon('lock', ['size' => 12, 'mono' => true]) ?><span data-con-chain>Chain verified · 3 of 3</span></span></p>
            <ol class="tcs-app__aul">
              <?php foreach ($tcs_con_audit as $tcs_con_i => $tcs_con_a): ?>
                <li data-au="<?= $tcs_con_i ?>"><time><?= $tcs_con_a[0] ?></time><b><?= e($tcs_con_a[1]) ?></b><span><?= e($tcs_con_a[2]) ?></span><span><?= e($tcs_con_a[3]) ?></span><code>#<?= e($tcs_con_a[4]) ?></code></li>
              <?php endforeach; ?>
            </ol>
          </div>
        </div>

        <span class="tcs-con__fill" aria-hidden="true"></span>
        <span class="tcs-con__cor" aria-hidden="true"></span><span class="tcs-con__cor" aria-hidden="true"></span><span class="tcs-con__cor" aria-hidden="true"></span><span class="tcs-con__cor" aria-hidden="true"></span>
        <?php foreach ($tcs_con_notes as $tcs_con_n): ?>
          <span class="tcs-con__pin" data-pin="<?= $tcs_con_n[0] ?>" aria-hidden="true"><?= $tcs_con_n[0] ?></span>
        <?php endforeach; ?>
      </div>
      <svg class="tcs-con__lead" aria-hidden="true" focusable="false"><path pathLength="1" data-con-lead/><circle r="3.5" data-con-tick/></svg>
      <p class="bdh-sr">An illustrative internal case-management tool for “Your company”. A sidebar with saved views; a case list filtered to open P1 and P2 cases in the West region, which is all the signed-in role can see, with three cases selected for a bulk action; the detail of a refund case whose refund above 50,000 was approved by a second person, with its activity timeline; and an append-only, hash-chained audit log. Six numbered notes below explain the design decisions.</p>

      <ol class="tcs-con__notes" aria-label="Design decisions in the tool">
        <?php foreach ($tcs_con_notes as $tcs_con_i => $tcs_con_n): ?>
          <li>
            <button type="button" class="tcs-con__note" data-note="<?= $tcs_con_n[0] ?>" aria-pressed="<?= $tcs_con_i === 0 ? 'true' : 'false' ?>">
              <span class="tcs-con__nn"><?= sprintf('%02d', $tcs_con_n[0]) ?></span>
              <span class="tcs-con__nt"><?= e($tcs_con_n[1]) ?></span>
              <span class="tcs-con__nd"><?= e($tcs_con_n[2]) ?></span>
              <code class="tcs-con__ng"><?= e($tcs_con_n[3]) ?></code>
            </button>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
