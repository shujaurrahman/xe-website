<?php /* DRAFT COPY — review before launch */
/* 04.5 Automation — an accounts-payable workflow as a live node graph on ink. A token runs from the inbox
   through classify, extract and validate (which times out once and retries with backoff), branches on the
   amount, waits for a person to approve anything over the limit, then posts to the ERP, notifies the team and
   closes an audit record. The run console, the approval gate (real buttons) and the run history sit below.
   HTML = the finished approved run. automation.js runs new ones. Every run, amount and figure is illustrative. */
$tapa_nodes = [   // key => [row x, y, kind, title, status line, icon]
    'trigger'  => [20,  40,  'Trigger',  'Email with PDF',     'ap@your-company · 1 PDF',     'doc'],
    'classify' => [260, 40,  'Classify', 'LLM · document type', 'invoice · 0.98',             'sparkle'],
    'extract'  => [500, 40,  'Extract',  'Vision · 12 fields', 'min confidence 0.95',         'vision'],
    'validate' => [740, 40,  'Validate', 'Rules + ERP lookup', 'PO matched · 3-way ok',       'check'],
    'branch'   => [980, 40,  'Branch',   'Over ₹2,00,000?',    '₹3,40,000 · yes',             'git-branch'],
    'approval' => [980, 330, 'Approval', 'Finance lead',       'approved · 3 m 02 s',         'approve'],
    'post'     => [740, 330, 'Post',     'ERP document',       '5100042 · idempotent',        'database'],
    'notify'   => [500, 330, 'Notify',   'Team channel',       '#ap-approvals · sent',        'chat'],
    'audit'    => [260, 330, 'Audit',    'Run record',         'r-2291 · 14 events',          'log'],
    'dlq'      => [20,  330, 'Dead letter', 'After 3 retries', 'empty',                       'queue'],
];
$tapa_edges = [   // key => [path, label, label x, label y, extra class]
    'e1' => ['M200 86H260', '', 0, 0, ''],
    'e2' => ['M440 86H500', '', 0, 0, ''],
    'e3' => ['M680 86H740', '', 0, 0, ''],
    'e4' => ['M920 86H980', '', 0, 0, ''],
    'e5' => ['M1100 132V330', 'yes · over limit', 1112, 236, ''],
    'e6' => ['M980 376H920', '', 0, 0, ''],
    'e7' => ['M740 376H680', '', 0, 0, ''],
    'e8' => ['M500 376H440', '', 0, 0, ''],
    'e9' => ['M1010 132C1010 236 830 226 830 330', 'no', 948, 222, 'is-skip'],
    'e10' => ['M790 132C790 250 110 230 110 330', 'after 3 failed retries', 380, 236, 'is-dash'],
];
$tapa_log = [   // [time, stage, text]
    ['09:41:02.114', 'trigger',  'email received · ap@your-company · inv-88412.pdf'],
    ['09:41:02.380', 'classify', 'invoice · 0.98 · small model'],
    ['09:41:04.912', 'extract',  '12 fields · min confidence 0.95'],
    ['09:41:05.203', 'validate', 'ERP lookup timed out · retry 1 in 2 s'],
    ['09:41:07.418', 'validate', 'PO 4500123 matched · 3-way match ok'],
    ['09:41:07.431', 'branch',   '₹3,40,000 over ₹2,00,000 · approval required'],
    ['09:44:09.870', 'approval', 'approved by Finance lead'],
    ['09:44:10.212', 'post',     'ERP document 5100042 · key inv-88412'],
    ['09:44:10.604', 'notify',   '#ap-approvals · message sent'],
    ['09:44:10.611', 'audit',    'run r-2291 closed · 14 events'],
];
$tapa_runs = [   // [run, file, amount, path, duration, retries, status, kind]
    ['r-2291', 'inv-88412.pdf', '₹3,40,000', 'Approval', '3 m 08 s', '1', 'Posted · approved', 'ok'],
    ['r-2290', 'inv-88409.pdf', '₹48,200',   'Straight-through', '38 s', '0', 'Posted', 'ok'],
    ['r-2289', 'inv-88401.pdf', '₹1,12,000', 'Straight-through', '41 s', '0', 'Posted', 'ok'],
    ['r-2288', 'inv-88397.pdf', '₹2,75,000', 'Approval', '—', '0', 'Waiting for approval', 'wait'],
    ['r-2287', 'inv-88390.pdf', '—',         'Dead letter', '2 m 05 s', '3', 'ERP unavailable · replayed', 'fail'],
];
?>
<section class="band band--ink tap-automation" id="automation" aria-labelledby="automation-t">
  <div class="wrap">
    <div class="tap-head" data-rv>
      <div>
        <p class="tap-eb"><span class="tap-eb__box" aria-hidden="true"></span><span class="tap-eb__n">04.5</span><span>Workflow automation</span><span class="tap-eb__p">/automation</span></p>
        <h2 class="h2" id="automation-t"><span class="g">Automation that runs end to end,</span> with people at the gates.</h2>
      </div>
      <div>
        <p class="lead">An invoice arrives by email and leaves as a posted ERP document. Every step is idempotent and retried with backoff, failures land in a dead-letter queue instead of disappearing, and anything over the limit waits for a person. Try approving one.</p>
      </div>
    </div>

    <div class="tap-auto" data-rv>
      <div class="tap-win tap-auto__canvas">
        <div class="tap-win__bar">
          <span class="tap-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="tap-win__path"><b>accounts-payable</b> · workflow v14 · durable execution</span>
          <span class="tap-win__end">
            <span class="tap-auto__status" data-auto-status><span class="tap-led"></span>r-2291 · completed</span>
            <button type="button" class="tap-btn tap-auto__pause" data-auto-toggle aria-pressed="false" hidden>Pause runs</button>
            <span class="tap-ill">Illustrative</span>
          </span>
        </div>
        <div class="bdh-scroll-x tap-auto__scroll" tabindex="0" role="region" aria-label="Workflow diagram, scroll sideways on small screens">
          <svg class="tap-auto__svg" viewBox="0 0 1200 450" role="img" aria-labelledby="auto-svg-t">
            <title id="auto-svg-t">Accounts payable workflow: email trigger, classify, extract, validate with retries, branch on amount, human approval over ₹2,00,000, post to ERP, notify the team, audit record, and a dead-letter queue after three failed retries.</title>
            <g class="tap-auto__edges">
              <?php foreach ($tapa_edges as $tapa_k => $tapa_e): ?>
                <path class="tap-auto__e <?= $tapa_e[4] ?>" data-edge="<?= $tapa_k ?>" d="<?= $tapa_e[0] ?>"/>
                <?php if ($tapa_e[1]): ?><text class="tap-auto__el" x="<?= $tapa_e[2] ?>" y="<?= $tapa_e[3] ?>"><?= e($tapa_e[1]) ?></text><?php endif; ?>
              <?php endforeach; ?>
              <path class="tap-auto__retry" d="M800 40C800 6 860 6 860 40"/>
              <path class="tap-auto__retryh" d="M853 33l7 7 4-9"/>
              <text class="tap-auto__el" x="872" y="20">retry · backoff 2 s, 4 s, 8 s</text>
            </g>
            <?php foreach ($tapa_nodes as $tapa_k => $tapa_n): ?>
              <g class="tap-auto__n is-done<?= $tapa_k === 'dlq' ? ' is-quiet' : '' ?>" data-node="<?= $tapa_k ?>" transform="translate(<?= $tapa_n[0] ?> <?= $tapa_n[1] ?>)">
                <rect class="tap-auto__box" width="180" height="92" rx="14"/>
                <text class="tap-auto__kind" x="16" y="26"><?= e(strtoupper($tapa_n[2])) ?></text>
                <text class="tap-auto__title" x="16" y="52"><?= e($tapa_n[3]) ?></text>
                <text class="tap-auto__sub" x="16" y="75" data-sub><?= e($tapa_n[4]) ?></text>
                <g transform="translate(144 12)"><?= xt_icon($tapa_n[5], ['size' => 20, 'mono' => true]) ?></g>
                <circle class="tap-auto__dot" cx="168" cy="80" r="4"/>
              </g>
            <?php endforeach; ?>
            <g class="tap-auto__tokg" aria-hidden="true"><circle class="tap-auto__halo" r="12" cx="0" cy="0"/><circle class="tap-auto__tok" r="6" cx="0" cy="0"/></g>
          </svg>
        </div>
        <p class="tap-auto__hint" aria-hidden="true"><span>Swipe sideways to follow the run</span><i>›</i></p>
      </div>

      <div class="tap-auto__below">
        <div class="tap-win tap-auto__console">
          <div class="tap-win__bar"><span class="tap-win__path"><b>run console</b> · <span data-auto-run>r-2291</span></span></div>
          <ol class="tap-auto__log" data-auto-log aria-label="Run events">
            <?php foreach ($tapa_log as $tapa_l): ?>
              <li><time><?= e($tapa_l[0]) ?></time><b><?= e($tapa_l[1]) ?></b><span><?= e($tapa_l[2]) ?></span></li>
            <?php endforeach; ?>
          </ol>
          <div class="tap-auto__gate" data-auto-gate>
            <p class="tap-auto__gt"><span class="tap-auto__gi"><?= xt_icon('approve', ['size' => 18, 'mono' => true]) ?></span><span data-auto-gtext>Approval gate · ₹3,40,000 · approved by Finance lead</span></p>
            <div class="tap-auto__gb">
              <button type="button" class="tap-btn tap-btn--blue" data-auto-approve disabled>Approve</button>
              <button type="button" class="tap-btn" data-auto-reject disabled>Reject</button>
            </div>
          </div>
          <p class="bdh-sr" aria-live="polite" data-auto-live></p>
        </div>

        <div class="tap-auto__hist">
          <ul class="tap-auto__kpis" role="list">
            <li><b>78%</b><span>Straight-through this week</span></li>
            <li><b>41 s</b><span>Median cycle, no approval</span></li>
            <li><b>6 · 1</b><span>Retries · dead-lettered</span></li>
          </ul>
          <div class="bdh-scroll-x tap-auto__tw" tabindex="0" role="region" aria-label="Run history, scroll sideways on small screens">
            <table class="tap-auto__table">
              <caption class="bdh-sr">Recent workflow runs with amount, path, duration, retries and status (illustrative)</caption>
              <thead><tr><th scope="col">Run</th><th scope="col">Amount</th><th scope="col">Path</th><th scope="col">Duration</th><th scope="col">Retries</th><th scope="col">Status</th></tr></thead>
              <tbody data-auto-runs>
                <?php foreach ($tapa_runs as $tapa_r): ?>
                  <tr class="is-<?= $tapa_r[7] ?>"><th scope="row"><code><?= e($tapa_r[0]) ?></code><span><?= e($tapa_r[1]) ?></span></th><td><?= e($tapa_r[2]) ?></td><td><?= e($tapa_r[3]) ?></td><td><?= e($tapa_r[4]) ?></td><td><?= e($tapa_r[5]) ?></td><td><span class="tap-auto__st"><i></i><?= e($tapa_r[6]) ?></span></td></tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="tap-auto__built">
      <ul class="tap-auto__rules" role="list" data-rv-s>
        <li><h3 class="tap-auto__rt">Idempotent steps</h3><span>Every write carries an idempotency key, so a retry never posts twice.</span></li>
        <li><h3 class="tap-auto__rt">Retries with backoff</h3><span>Exponential backoff with jitter for timeouts and rate limits: 2 s, 4 s, 8 s, then the dead-letter queue. Permanent errors fail fast.</span></li>
        <li><h3 class="tap-auto__rt">Dead-letter queue</h3><span>Runs that exhaust retries park with their payload and error, ready to replay after a fix.</span></li>
        <li><h3 class="tap-auto__rt">Audit per run</h3><span>Who approved what, which model version decided, and every input and output, kept per run.</span></li>
      </ul>
      <div class="tap-auto__tools" data-rv>
        <p class="tap-auto__tk">Runs on tools such as</p>
        <?= xt_stack(['n8n', 'temporal', 'sap', 'python', 'zapier'], ['variant' => 'chips', 'label' => 'Workflow technologies we work with', 'size' => 16]) ?>
        <p class="tap-auto__also"><span>Also</span><span class="tap-auto__wd">Power Automate</span><span class="tap-auto__wd">Slack</span><span class="tap-auto__wd">Microsoft Teams</span><span class="tap-auto__wd">Gmail</span></p>
      </div>
    </div>
  </div>
</section>
