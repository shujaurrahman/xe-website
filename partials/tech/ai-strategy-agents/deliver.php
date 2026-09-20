<?php /* DRAFT COPY — review before launch */
/* Deliver — "What you get" as a ring binder with four index tabs: Strategy · Agent · Governance ·
   Operate. Each tab opens a page: the files handed over (path, what it is, format) beside a mock of
   the one artefact people open first — the roadmap, the repository, the register, the runbook.
   Deliverable names follow $CAP['deliver']. deliver.js wires the ARIA tabs (arrow keys, Home/End)
   and turns the pages until the binder is touched. The HTML shows every page; tab 1 is open. */
$tas_dl = [
    [
        'key' => 'strategy', 'tab' => 'Strategy', 'icon' => 'compass',
        'lead' => 'Where AI fits, what comes first and what it is worth, agreed by the people who run the work.',
        'files' => [
            ['ai-strategy-one-page.pdf',       'One-page AI strategy',                       'Document'],
            ['use-case-portfolio.xlsx',        'AI opportunity map and use-case portfolio',  'Board · Sheet'],
            ['roadmap-business-cases.pptx',    'AI roadmap with business cases',             'Deck · Sheet'],
            ['operating-model.pdf',            'Operating model, roles and approval rights', 'Document'],
        ],
        'check' => ['Signed by the sponsor and the three owners', 'Source files in your document store, not ours', 'Portfolio scores editable, formula included'],
    ],
    [
        'key' => 'agent', 'tab' => 'Agent', 'icon' => 'code',
        'lead' => 'The agent itself, in your repository and your cloud account, with the tests that prove it works.',
        'files' => [
            ['agents/renewals-agent/',         'Agent or copilot in production',              'Source · your cloud'],
            ['mcp-servers/',                   'MCP servers for the CRM, billing and documents', 'Source'],
            ['evals/',                         'Evaluation suite, golden sets, red-team results', 'Tests · report'],
            ['infra/',                         'Deployment as code for your cloud account',   'Terraform'],
        ],
        'check' => ['Repository transferred to your organisation', 'CI, secrets and cloud account in your name', 'Prompts and model routes versioned in the repo'],
    ],
    [
        'key' => 'governance', 'tab' => 'Governance', 'icon' => 'shield',
        'lead' => 'The written answers legal, security and auditors ask for, kept in one register.',
        'files' => [
            ['guardrails/policy.yaml',         'Guardrail and approval policy',               'Policy · config'],
            ['ai-governance-framework.pdf',    'AI governance framework',                     'Document'],
            ['ai-inventory-risk-register.xlsx','AI inventory and risk register',              'Register'],
            ['model-cards/',                   'Model cards per model and version',           'Document'],
        ],
        'check' => ['Register owner named, review dates booked', 'Legal and security sign-off recorded', 'Every row linked to its evidence'],
    ],
    [
        'key' => 'operate', 'tab' => 'Operate', 'icon' => 'uptime',
        'lead' => 'Everything your team needs to run, review and change the agent without us in the room.',
        'files' => [
            ['dashboards/agent-actions',       'Agent action and audit log',                  'Dashboard'],
            ['runbooks/',                      'Runbooks: escalations, rollback, model swap', 'Document'],
            ['training/',                      'Training for owners, approvers and reviewers', 'Sessions · recordings'],
            ['reviews/q-review-template.pdf',  'Quarterly review pack',                       'Report'],
        ],
        'check' => ['On-call rota and escalation contacts agreed', 'Approvers trained and named in the policy', 'First quarterly review in the calendar'],
    ],
];
$tas_dl_road = [   // [use case, start quarter 1–4, length in quarters, state] · rows in portfolio rank order
    ['Vendor invoice matching',  1, 1.2, 'build'],
    ['Renewal quotes',           1, 1.3, 'build'],
    ['RFP triage',               2, 1.2, 'build'],
    ['Policy questions',         2, 1.4, 'next'],
    ['Billing disputes',         3, 1.6, 'next'],
    ['Parts demand forecast',    3.4, 1.6, 'prep'],
];
$tas_dl_tree = [   // [depth, name, note, kind]
    [0, 'your-company/ai-agents', '', 'root'],
    [1, 'agents/renewals-agent/', '', 'dir'],
    [2, 'graph.py', 'plan → act → observe', 'file'],
    [2, 'prompts/v14.1.md', 'versioned', 'file'],
    [2, 'tools.yaml', 'allow-list per level', 'file'],
    [1, 'mcp-servers/crm/', 'read · write:quotes', 'dir'],
    [1, 'evals/', '', 'dir'],
    [2, 'golden-set-v10.jsonl', '218 cases', 'file'],
    [2, 'redteam/', 'LLM01 · LLM06', 'dir'],
    [1, 'guardrails/policy.yaml', 'limits · approvals', 'file'],
    [1, 'infra/', 'terraform · your cloud', 'dir'],
];
$tas_dl_reg = [   // [system, owner, tier, level, next review]
    ['renewals-agent',   'Sales ops lead', 'Minimal', 3, '14 Dec'],
    ['ap-reconciler',    'Finance lead',   'Minimal', 4, '02 Jan'],
    ['support-copilot',  'Support lead',   'Limited', 1, '20 Nov'],
    ['credit-scoring',   'Credit manager', 'High',    0, 'Parked'],
];
$tas_dl_rb = [
    'Open the trace sample for the last hour and group escalations by reason.',
    'Compare with the last release on the eval dashboard: prompt, model, tool or data?',
    'If a release caused it, roll the route back: one command, logged.',
    'Tell the owner, record the incident and add the cases to the golden set.',
];
?>
<section class="band band--alt tas-deliver" id="deliver" aria-labelledby="deliver-t">
  <div class="wrap">
    <div class="tas-head" data-rv>
      <div class="tas-head__t">
        <p class="tas-kick"><span class="tas-kick__ref">10</span>What you get</p>
        <h2 class="h2" id="deliver-t"><span class="g">What you get,</span> filed where your teams will look for it.</h2>
      </div>
      <div class="tas-head__l">
        <p class="lead">The strategy, the agent itself, the governance around it and what it takes to run it, handed over into your repositories, your cloud account and your document store.</p>
        <!-- PLACEHOLDER: confirm hand-over and ownership terms before launch -->
      </div>
    </div>

    <div class="tas-dl" data-tas-dl data-rv>
      <div class="tas-dl__binder">
        <span class="tas-dl__rings" aria-hidden="true"><i></i><i></i><i></i></span>

        <div class="tas-dl__tabs" role="tablist" aria-label="Deliverables" aria-orientation="vertical">
          <?php foreach ($tas_dl as $tas_di => $tas_d): ?>
            <button type="button" role="tab" class="tas-dl__tab" id="deliver-t<?= $tas_di ?>" aria-controls="deliver-p<?= $tas_di ?>" aria-selected="<?= $tas_di === 0 ? 'true' : 'false' ?>" tabindex="<?= $tas_di === 0 ? '0' : '-1' ?>" style="--i:<?= $tas_di ?>">
              <span class="tas-dl__tn"><?= sprintf('%02d', $tas_di + 1) ?></span>
              <b><?= e($tas_d['tab']) ?></b>
              <small><?= count($tas_d['files']) ?> items</small>
            </button>
          <?php endforeach; ?>
        </div>

        <div class="bdh-panes tas-dl__panes">
          <?php foreach ($tas_dl as $tas_di => $tas_d): ?>
            <div class="bdh-pane tas-dl__pane<?= $tas_di === 0 ? ' is-on' : '' ?>" id="deliver-p<?= $tas_di ?>" role="tabpanel" aria-labelledby="deliver-t<?= $tas_di ?>" tabindex="0" data-k="<?= e($tas_d['key']) ?>">
              <p class="tas-dl__run"><span>Tab <?= $tas_di + 1 ?> of <?= count($tas_dl) ?></span><span>Your company · AI programme · handover</span></p>
              <div class="tas-dl__ph">
                <span class="tas-dl__pi"><?= xt_icon($tas_d['icon'], ['size' => 24]) ?></span>
                <div>
                  <h3 class="tas-dl__pt"><?= e($tas_d['tab']) ?></h3>
                  <p class="tas-dl__pl"><?= e($tas_d['lead']) ?></p>
                </div>
              </div>

              <div class="tas-dl__cols">
                <div class="tas-dl__left">
                  <ul class="tas-dl__files" aria-label="<?= e($tas_d['tab']) ?>: items handed over">
                    <?php foreach ($tas_d['files'] as $tas_fi => $tas_f): ?>
                      <li style="--i:<?= $tas_fi ?>">
                        <code class="tas-dl__path"><?= e($tas_f[0]) ?></code>
                        <span class="tas-dl__fn"><?= e($tas_f[1]) ?></span>
                        <span class="tas-dl__ff"><?php foreach (explode('·', $tas_f[2]) as $tas_fmt): ?><em><?= e(trim($tas_fmt)) ?></em><?php endforeach; ?></span>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                  <div class="tas-dl__chk">
                    <p class="tas-lbl">Handover checklist</p>
                    <ul>
                      <?php foreach ($tas_d['check'] as $tas_ck): ?><li><?= xt_icon('check', ['size' => 14]) ?><?= e($tas_ck) ?></li><?php endforeach; ?>
                    </ul>
                  </div>
                </div>

                <div class="tas-dl__mock" aria-hidden="true">
                  <?php if ($tas_d['key'] === 'strategy'): ?>
                    <p class="tas-dl__mk"><span>roadmap-business-cases.pptx · slide 4</span><span class="tas-ill">Illustrative</span></p>
                    <p class="tas-dl__mt">Roadmap by quarter</p>
                    <div class="tas-dl__road">
                      <span class="tas-dl__qg"><i></i><i></i><i></i><i></i></span>
                      <div class="tas-dl__rq"><span></span><span class="tas-dl__qs"><span>Q1</span><span>Q2</span><span>Q3</span><span>Q4</span></span></div>
                      <?php foreach ($tas_dl_road as $tas_ri => $tas_r): ?>
                        <div class="tas-dl__rr"><span class="tas-dl__rn"><?= e($tas_r[0]) ?></span><span class="tas-dl__rt"><i class="tas-dl__rb" data-s="<?= e($tas_r[3]) ?>" style="--x:<?= ($tas_r[1] - 1) / 4 ?>;--w:<?= $tas_r[2] / 4 ?>;--i:<?= $tas_ri ?>"></i></span></div>
                      <?php endforeach; ?>
                    </div>
                    <p class="tas-dl__rl"><span><i data-s="build"></i>Build first</span><span><i data-s="next"></i>Next</span><span><i data-s="prep"></i>Data work first</span></p>
                  <?php elseif ($tas_d['key'] === 'agent'): ?>
                    <p class="tas-dl__mk"><span>git · main · 218 checks passing</span><span class="tas-ill">Illustrative</span></p>
                    <ul class="tas-dl__tree">
                      <?php foreach ($tas_dl_tree as $tas_ti => $tas_t): ?>
                        <li data-kind="<?= e($tas_t[3]) ?>" style="--d:<?= (int) $tas_t[0] ?>;--i:<?= $tas_ti ?>"><span class="tas-dl__tnm"><?= e($tas_t[1]) ?></span><?php if ($tas_t[2] !== ''): ?><span class="tas-dl__tnote"><?= e($tas_t[2]) ?></span><?php endif; ?></li>
                      <?php endforeach; ?>
                    </ul>
                  <?php elseif ($tas_d['key'] === 'governance'): ?>
                    <p class="tas-dl__mk"><span>ai-inventory-risk-register.xlsx · Systems</span><span class="tas-ill">Illustrative</span></p>
                    <table class="tas-dl__reg">
                      <thead><tr><th scope="col">System</th><th scope="col">Owner</th><th scope="col">Tier</th><th scope="col">Level</th><th scope="col">Review</th></tr></thead>
                      <tbody>
                        <?php foreach ($tas_dl_reg as $tas_g): ?>
                          <tr data-tier="<?= e(strtolower($tas_g[2])) ?>"><td><?= e($tas_g[0]) ?></td><td><?= e($tas_g[1]) ?></td><td><span class="tas-dl__tier"><?= e($tas_g[2]) ?></span></td><td><?= $tas_g[3] ? tas_lvl($tas_g[3], ['short' => true]) : '<span class="tas-dl__na">—</span>' ?></td><td><?= e($tas_g[4]) ?></td></tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                    <p class="tas-dl__rfoot">Each row links to its risk assessment, model card and approval policy.</p>
                  <?php else: ?>
                    <p class="tas-dl__mk"><span>runbooks/rb-03-escalations.md</span><span class="tas-ill">Illustrative</span></p>
                    <p class="tas-dl__mt">RB-03 · Escalations above 8% for an hour</p>
                    <p class="tas-dl__rbm"><span>Severity 3</span><span>On call: platform team</span><span>Owner informed within 1 h</span></p>
                    <ol class="tas-dl__rbk">
                      <?php foreach ($tas_dl_rb as $tas_ri => $tas_r): ?><li style="--i:<?= $tas_ri ?>"><span><?= $tas_ri + 1 ?></span><?= e($tas_r) ?></li><?php endforeach; ?>
                    </ol>
                    <p class="tas-dl__cmd"><code>$ agentctl route rollback renewals --to previous --reason "RB-03"</code></p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <p class="bdh-sr">Each tab shows a mock of the first artefact in that part of the handover: a roadmap by quarter for strategy, the repository layout for the agent, the AI inventory and risk register for governance, and an escalation runbook for operations.</p>
    </div>
  </div>
</section>
