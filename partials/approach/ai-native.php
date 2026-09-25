<?php /* DRAFT COPY — review before launch */
/* AI-native — the agent roster, on ink. This is the concrete answer to "AI runs the operation": every
   agent we run in delivery, what it is allowed to touch, and the one line it may never cross. It is
   deliberately a different component from the delivery console on the Technology & Intelligence hub
   (partials/tech/hub/ai-native.php), which shows one ticket moving through the pipeline. This is the
   roster behind that pipeline, and the two do not contradict: agents draft, test, scan and deploy; a
   named engineer approves every merge and every production change.
   Every agent name is a role, not a product. */
$aprn_agents = [
    ['research', 'radar',    'Reads', 'Documents, tickets, call notes, analytics and the public web. Returns themes with a source against every line.',
     'Cite a source it has not opened, or present a summary without the material behind it.', 'Frame · Shape'],
    ['spec',     'doc',      'Drafts the spec', 'Acceptance criteria and edge cases from the brief, written so a tester could use them.',
     'Approve its own criteria. A lead edits and signs them.', 'Shape · Build'],
    ['pair',     'code',     'Pairs on the code', 'Suggestions in the editor and a written summary on every pull request.',
     'Merge anything. Ever, for any reason.', 'Build'],
    ['test',     'check',    'Writes the tests', 'Unit and contract tests for each change, plus the cases a person would forget.',
     'Delete or skip a failing test to make a build green.', 'Build'],
    ['eval',     'eval',     'Scores the AI', 'The golden set on every change: faithfulness, refusals, latency and cost against the gate.',
     'Change a gate, or pass a run that missed one.', 'Build · Prove'],
    ['scan',     'scan',     'Scans for risk', 'Static analysis, dependencies, containers, secrets, and prompt-injection cases from OWASP LLM01.',
     'Waive a finding. Only a security engineer can accept a risk.', 'Build · Prove'],
    ['deploy',   'rocket',   'Ships and reverses', 'Canary releases, threshold-triggered rollback, and the release record.',
     'Deploy without a recorded human approval on the change.', 'Launch'],
    ['watch',    'dashboard','Watches production', 'Alert triage, incident timelines, eval drift and cost anomalies.',
     'Close an incident, or decide it was not one.', 'Run'],
];
$aprn_human = [
    ['Which problem, and what it is judged on', 'Frame'],
    ['Which route, and what it rules out',      'Shape'],
    ['Every merge into your codebase',          'Build'],
    ['Every claim made to a customer',          'Build · Launch'],
    ['Go-live, and the decision to roll back',  'Prove · Launch'],
    ['When an incident is over',                'Run'],
];
$aprn_log = [
    ['14:02', 'research', 'Returned 9 themes from 62 tickets',   'Strategy lead', 'Accepted, 2 rejected'],
    ['14:48', 'spec',     'Drafted 6 criteria, 3 edge cases',    'Tech lead',     'Edited, then approved'],
    ['16:40', 'test',     'Added 14 tests',                      'Engineer',      '12 kept'],
    ['16:46', 'eval',     'Golden set: 148 of 148 passed',       '—',             'Gate met'],
    ['17:12', 'Tech lead','Approved merge',                      '—',             'Merged'],
    ['17:34', 'deploy',   'Canary 5% to 100%',                   'On-call',       'Live'],
];
?>
<section class="band band--ink apr-ai-native" id="ai-native" aria-labelledby="ai-native-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The roster</p>
        <h2 class="h2" id="ai-native-t"><span class="g">Eight agents.</span> Eight lines they cannot cross.</h2>
      </div>
      <div>
        <p class="lead">These are the agents that run in delivery, what each one is allowed to touch, and
          the specific thing it may never do. The limits are enforced in the pipeline and in the tools'
          own permissions, not in a policy document.</p>
        <a class="tl" href="<?= xe_url('services/technology-intelligence.php') ?>#ai-native">See a ticket run through the pipeline <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="apr-ain__wrap" data-rv data-rv-d="60">
      <div class="bdh-scroll-x apr-ain__scroll" tabindex="0" role="region" aria-label="The agent roster, scroll sideways on small screens">
        <table class="apr-ain__t">
          <caption class="bdh-sr">Every agent we run in delivery: what it does, what it returns, the one thing it may never do, and the stages it runs in.</caption>
          <thead>
            <tr>
              <th scope="col"><span class="apr-k">Agent</span></th>
              <th scope="col"><span class="apr-k">What it returns</span></th>
              <th scope="col"><span class="apr-k">What it may never do</span></th>
              <th scope="col"><span class="apr-k">Stages</span></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($aprn_agents as $aprn_a): ?>
              <tr>
                <th scope="row">
                  <span class="apr-ain__who">
                    <span class="apr-ain__ico" aria-hidden="true"><?= xt_icon($aprn_a[1], ['size' => 18]) ?></span>
                    <span><b><?= e($aprn_a[0]) ?>.agent</b><i><?= e($aprn_a[2]) ?></i></span>
                  </span>
                </th>
                <td><?= e($aprn_a[3]) ?></td>
                <td><span class="apr-never"><?= e($aprn_a[4]) ?></span></td>
                <td class="apr-ain__st"><?= e($aprn_a[5]) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="apr-ain__below">
      <div class="apr-ain__human" data-rv data-rv-d="80">
        <p class="apr-k">What a person decides, always</p>
        <ul class="apr-ain__hl">
          <?php foreach ($aprn_human as $aprn_h): ?>
            <li><span class="apr-tick" aria-hidden="true">✓</span><span><?= e($aprn_h[0]) ?></span><small><?= e($aprn_h[1]) ?></small></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="apr-ain__log" data-rv data-rv-d="120">
        <p class="apr-ain__lh"><span class="apr-k">One day in the audit log</span><span class="bdh-ill">Illustrative</span></p>
        <ol class="apr-ain__lines">
          <?php foreach ($aprn_log as $aprn_l): ?>
            <li>
              <span class="apr-ain__lt"><?= e($aprn_l[0]) ?></span>
              <span class="apr-ain__la"><?= e($aprn_l[1]) ?></span>
              <span class="apr-ain__lx"><?= e($aprn_l[2]) ?></span>
              <span class="apr-ain__lr"><?= e($aprn_l[3]) ?></span>
              <span class="apr-ain__lo"><?= e($aprn_l[4]) ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
        <p class="apr-note">Every line carries the model, the prompt version, the inputs, the output and
          the reviewer. It is kept with the pull request and the release, and it is yours.</p>
      </div>
    </div>
  </div>
</section>
