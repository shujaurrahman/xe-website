<?php /* DRAFT COPY — review before launch */
/* AI-native — how we build, not just what we build. A delivery console on ink: one ticket runs through the
   eight stages of the pipeline (Spec → Code → Tests → Evals → Security → Review → Deploy → Observe). Agents
   draft, test, scan and deploy; the Review stage waits for a named engineer, because agents cannot merge.
   Tabs: Pipeline · PR diff · Eval report · Audit log. The markup is the finished state (the run approved and
   in production); ai-native.js replays it, pauses at Review until someone presses Approve (the demo presses it
   itself after two seconds), and hands the controls over on the first interaction.
   Every name, number and time here is illustrative. */
$ain_stages = [
    // [key, name, actor: agent | person | both, icon, what happens, artefact, clock, log line]
    ['spec',     'Spec',     'both',   'doc',       'An agent drafts acceptance criteria and edge cases from the ticket. The tech lead edits them and approves.', '6 criteria · 3 edge cases · approved', '14:02', 'spec.agent    drafted 6 acceptance criteria, 3 edge cases · approved by tech lead'],
    ['code',     'Code',     'both',   'code',      'An engineer builds the change with an AI pair in the IDE and opens a pull request with a written summary.', 'PR #1482 · +212 −38 · 7 files', '14:31', 'ide.pair      PR #1482 opened · +212 −38 · 31 of 38 suggested lines kept'],
    ['tests',    'Tests',    'agent',  'check',     'A test agent writes unit and contract tests for the change. The engineer keeps the ones that earn their place.', '+14 tests · coverage 81.2% → 84.6%', '16:40', 'test.agent    +14 tests (12 kept) · coverage 81.2% → 84.6% · all green'],
    ['evals',    'Evals',    'agent',  'eval',      'The golden set runs against the AI feature: faithfulness, refusals, latency and cost, compared with main.', '148 / 148 pass · faithfulness 0.94', '16:46', 'eval.runner   golden-set@v14 148/148 · faithfulness 0.94 · p95 1.9 s'],
    ['security', 'Security', 'agent',  'scan',      'SAST, dependency, container and secret scans run on the branch, with prompt-injection cases (OWASP LLM01) in the suite.', '0 critical · 0 high · 0 secrets', '16:50', 'sec.scan      sast 0 · deps 0 critical · image 0 high · secrets 0 · llm01 24/24 blocked'],
    ['review',   'Review',   'person', 'approve',   'A named engineer reads the diff, the eval report and the scan results, then approves or asks for changes. Agents cannot merge.', 'approved by the tech lead · 2 comments resolved', '17:12', 'review        approved by the tech lead · merge unlocked'],
    ['deploy',   'Deploy',   'agent',  'rocket',    'Canary to 5% of traffic, then 25% and 100% while error rate and latency hold. It rolls back on its own if they do not.', 'canary 5% → 25% → 100% · 0 rollbacks', '17:34', 'deploy.agent  canary 5% → 25% → 100% · error rate 0.08% · rollback armed'],
    ['observe',  'Observe',  'both',   'dashboard', 'Traces, SLO burn and eval drift are watched in production. The on-call engineer owns anything that moves.', 'SLO 99.96% · burn 0.4× · no drift', 'live',  'observe       SLO 99.96% · burn rate 0.4× · eval drift none · on-call: squad'],
];
$ain_actor = ['agent' => 'Agent', 'person' => 'Person', 'both' => 'Agent + person'];
$ain_last = count($ain_stages) - 1;
$ain_diff = [
    // [type: ctx | add | del | hunk, text]
    ['hunk', '@@ -41,9 +41,24 @@ def answer(question: str, customer: Customer) -> Answer:'],
    ['ctx',  '    context = retrieve(question, customer_id=customer.id, k=8)'],
    ['del',  '    return llm.complete(PROMPT.format(q=question, ctx=context))'],
    ['add',  '    if intent(question) == "refund_status":'],
    ['add',  '        order = tools.orders.lookup(customer.id, scope="read")'],
    ['add',  '        context.append(order.as_citation())'],
    ['add',  '    draft = gateway.complete('],
    ['add',  '        route="support.answer",        # small model first, escalates on low confidence'],
    ['add',  '        prompt=PROMPTS["answer@v14"], question=question, context=context,'],
    ['add',  '    )'],
    ['add',  '    checked = guardrails.check(draft, policy="support@v6")   # PII, claims, injection'],
    ['add',  '    if checked.confidence < 0.62:'],
    ['add',  '        return handoff.to_human(question, draft, reason="low_confidence")'],
    ['add',  '    return checked.answer'],
];
$ain_evals = [
    // [metric, value shown, bar 0–1, gate label, gate position 0–1, previous on main]
    ['Faithfulness',            '0.94',    .94, '≥ 0.90', .90, '0.93'],
    ['Answer relevance',        '0.91',    .91, '≥ 0.85', .85, '0.90'],
    ['Citation accuracy',       '0.97',    .97, '≥ 0.95', .95, '0.96'],
    ['Correct refusals',        '1.00',    1.0, '= 1.00', 1.0, '1.00'],
    ['Injection cases blocked', '24 / 24', 1.0, '= 24',   1.0, '22 / 22'],
    ['p95 latency',             '1.9 s',   .76, '< 2.5 s', 1.0, '2.1 s'],
    ['Cost per answer',         '$0.004',  .67, '≤ $0.006', 1.0, '$0.005'],
];
$ain_audit = [
    // [time, actor, kind agent|person, action, model · prompt, reviewer, result]
    ['14:02', 'spec.agent',   'agent',  'Drafted acceptance criteria',        'route:large · spec@v7', 'Tech lead',  'Approved'],
    ['14:31', 'ide.pair',     'agent',  'Suggested 38 lines in 3 files',      'route:code',            'Tech lead', '31 kept'],
    ['16:40', 'test.agent',   'agent',  'Generated 14 tests',                 'route:code · tests@v3', 'Tech lead', '12 kept'],
    ['16:46', 'eval.runner',  'agent',  'Ran golden set v14',                 'judge@v5',              '—',          'Pass'],
    ['17:12', 'Tech lead',    'person', 'Approved merge of PR #1482',         '—',                     '—',          'Merged'],
    ['17:34', 'deploy.agent', 'agent',  'Canary 5% → 100%',                   '—',                     'On-call',    'Live'],
];
$ain_rules = [
    ['approve', 'Agents propose, people approve',  'Agents draft, test and deploy. A named engineer approves every merge and every production change.'],
    ['log',     'Every AI action is logged',       'Model, prompt version, inputs, output and reviewer, kept with the pull request and the release.'],
    ['lock',    'No client data in public training', 'Enterprise model endpoints with training turned off, in your region where it matters.'],
    ['key',     'Secrets never enter a prompt',    'Credentials stay in the vault. Agents call tools with scoped, short-lived tokens.'],
];
$ain_dora = [
    ['Lead time for changes', 'Hours, not weeks', 'Ticket to production for the run above: 3 h 32 min'],
    ['Deployment frequency',  'Daily when needed', 'Small changes, canaried, reversible'],
    ['Change failure rate',   'Tracked per release', 'Every rollback reviewed in writing'],
    ['Recovery time',         'Tracked per incident', 'Runbooks and on-call from day one'],
];
$ain_tabs = [['Pipeline', '8 stages'], ['PR diff', '#1482'], ['Eval report', '148 / 148'], ['Audit log', count($ain_audit) . ' events']];
?>
<section class="band band--ink tih-ai-native" id="ai-native" aria-labelledby="ai-native-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--c" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>AI-native delivery</p>
      <h2 class="h2" id="ai-native-t"><span class="g">How we build,</span> not just what we build.</h2>
      <p class="lead">Agents write the first draft of the spec, the tests and the deployment. Evals and scans run on every change. A named engineer approves every merge, and every AI action lands in the audit log.</p>
    </div>

    <p class="bdh-sr">An interactive delivery console. One ticket, adding refund status to a support assistant, runs through eight stages: an agent drafts the spec and the tech lead approves it; an engineer codes with an AI pair and opens pull request 1482; a test agent adds 14 tests; the eval suite passes 148 of 148 cases with faithfulness 0.94; security scans find nothing critical; a named engineer reviews and approves the merge; an agent canaries the release from 5 to 100 percent; and production is observed against its SLO. Other tabs show the code diff, the eval report against its gates and the audit log.</p>

    <div class="bdh-ui bdh-ui--ink tih-ain" data-at="<?= $ain_last + 1 ?>" data-review="done" data-rv data-rv-d="80" data-bdh-live>
      <div class="bdh-ui__bar tih-ain__bar">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="tih-ain__title">delivery <i>/</i> your-platform <i>/</i> XE-1482 · Refund status in the support assistant</span>
        <span class="tih-ain__marks" aria-hidden="true"><?= xt_logo('github', ['size' => 14, 'hidden' => true]) ?><?= xt_logo('snyk', ['size' => 14, 'hidden' => true]) ?><?= xt_logo('opentelemetry', ['size' => 14, 'hidden' => true]) ?></span>
        <span class="tih-ain__status"><i class="bdh-pulse" aria-hidden="true"></i><span class="tih-ain__stxt">In production · 3 h 32 min</span></span>
      </div>

      <div class="tih-ain__head">
        <div class="bdh-tabs tih-ain__tabs" role="tablist" aria-label="Delivery console views">
          <?php foreach ($ain_tabs as $ain_ti => $ain_t): ?>
            <button type="button" role="tab" id="ai-native-t<?= $ain_ti ?>" aria-controls="ai-native-p<?= $ain_ti ?>" aria-selected="<?= $ain_ti === 0 ? 'true' : 'false' ?>" tabindex="<?= $ain_ti === 0 ? '0' : '-1' ?>"><?= e($ain_t[0]) ?><small><?= e($ain_t[1]) ?></small></button>
          <?php endforeach; ?>
        </div>
        <button type="button" class="tih-ain__rerun"><span aria-hidden="true">↻</span> Run the pipeline again</button>
      </div>

      <div class="bdh-panes tih-ain__panes">
        <!-- PIPELINE -->
        <div class="bdh-pane is-on tih-ain__pane" id="ai-native-p0" role="tabpanel" aria-labelledby="ai-native-t0">
          <div class="tih-ain__track">
            <span class="tih-ain__rail" aria-hidden="true"><i class="tih-ain__fill"></i></span>
            <ol class="tih-ain__stages" aria-label="Pipeline stages, choose one to inspect it">
              <?php foreach ($ain_stages as $ain_i => $ain_s): ?>
                <li class="tih-ain__st is-done" data-stage="<?= $ain_i ?>" data-actor="<?= e($ain_s[2]) ?>">
                  <button type="button" class="tih-ain__sb" aria-pressed="<?= $ain_s[0] === 'review' ? 'true' : 'false' ?>" aria-controls="ai-native-detail">
                    <span class="tih-ain__dot" aria-hidden="true"><?= xt_icon($ain_s[3], ['size' => 18, 'mono' => true]) ?></span>
                    <span class="tih-ain__sn"><b><?= str_pad((string) ($ain_i + 1), 2, '0', STR_PAD_LEFT) ?></b><?= e($ain_s[1]) ?></span>
                    <span class="tih-ain__sa"><?= e($ain_actor[$ain_s[2]]) ?></span>
                  </button>
                </li>
              <?php endforeach; ?>
            </ol>
          </div>

          <div class="tih-ain__grid">
            <div class="tih-ain__detail" id="ai-native-detail" aria-live="polite">
              <?php foreach ($ain_stages as $ain_i => $ain_s): ?>
                <div class="tih-ain__dp<?= $ain_s[0] === 'review' ? ' is-on' : '' ?>" data-dp="<?= $ain_i ?>">
                  <p class="tih-ain__dk"><span>Stage <?= str_pad((string) ($ain_i + 1), 2, '0', STR_PAD_LEFT) ?> of <?= count($ain_stages) ?></span><span class="tih-ain__dtag is-<?= e($ain_s[2]) ?>"><?= e($ain_actor[$ain_s[2]]) ?></span></p>
                  <h3 class="tih-ain__dt"><?= e($ain_s[1]) ?></h3>
                  <p class="tih-ain__dd"><?= e($ain_s[4]) ?></p>
                  <?php if ($ain_s[0] === 'review'): ?>
                    <div class="tih-ain__gate">
                      <p class="tih-ain__gw"><span class="bdh-flag" aria-hidden="true">!</span>Waiting for a named engineer. Agents cannot merge.</p>
                      <div class="tih-ain__ga">
                        <button type="button" class="btn btn--white btn--sm tih-ain__approve">Approve merge</button>
                        <button type="button" class="tih-ain__changes">Request changes</button>
                      </div>
                      <p class="tih-ain__gd"><b class="bdh-ok" aria-hidden="true">✓</b><span class="tih-ain__gdt">Approved by the tech lead · 17:12 · logged</span></p>
                    </div>
                  <?php else: ?>
                    <p class="tih-ain__art"><span class="tih-k">Output</span><span><?= e($ain_s[5]) ?></span></p>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="tih-ain__log" aria-hidden="true">
              <p class="tih-ain__lh"><span>run.log</span><span class="tih-ain__clock">XE-1482 · run 3</span></p>
              <ol class="tih-ain__lines">
                <?php foreach ($ain_stages as $ain_i => $ain_s): ?>
                  <li class="is-on" data-line="<?= $ain_i ?>"><span class="tih-ain__lt"><?= e($ain_s[6]) ?></span><span class="tih-ain__lx"><?= e($ain_s[7]) ?></span></li>
                <?php endforeach; ?>
              </ol>
            </div>
          </div>
        </div>

        <!-- PR DIFF -->
        <div class="bdh-pane tih-ain__pane tih-ain__diffp" id="ai-native-p1" role="tabpanel" aria-labelledby="ai-native-t1">
          <div class="tih-ain__pr">
            <p class="tih-ain__prh"><span class="tih-ain__prn">#1482</span><span class="tih-ain__prt">Answer refund status from the order system, hand off on low confidence</span></p>
            <p class="tih-ain__prm"><span>services/support/answer.py</span><span class="tih-ain__plus">+14</span><span class="tih-ain__minus">−1</span><span>Drafted with an AI pair · reviewed by the tech lead</span></p>
          </div>
          <pre class="tih-ain__diff" tabindex="0" aria-label="Code diff for pull request 1482"><?php foreach ($ain_diff as $ain_di => $ain_d): ?><span class="tih-ain__dl is-<?= e($ain_d[0]) ?>" style="--i:<?= $ain_di ?>"><span class="tih-ain__dg" aria-hidden="true"><?= $ain_d[0] === 'add' ? '+' : ($ain_d[0] === 'del' ? '−' : ' ') ?></span><?= e($ain_d[1]) ?></span>
<?php endforeach; ?></pre>
          <p class="tih-ain__note"><span class="tih-k">Review note</span>Tool call is read-scoped. Handoff threshold matches the value calibrated on the golden set. Approved.</p>
        </div>

        <!-- EVAL REPORT -->
        <div class="bdh-pane tih-ain__pane tih-ain__evp" id="ai-native-p2" role="tabpanel" aria-labelledby="ai-native-t2">
          <p class="tih-ain__evh"><span class="tih-k">golden-set@v14 · 148 cases · judge calibrated against expert labels</span><span class="tih-ain__pass">All gates pass</span></p>
          <table class="tih-ain__ev">
            <thead><tr><th scope="col">Metric</th><th scope="col">This branch</th><th scope="col"><span class="bdh-sr">Against the gate</span></th><th scope="col">Gate</th><th scope="col">Main</th></tr></thead>
            <tbody>
              <?php foreach ($ain_evals as $ain_ei => $ain_ev): ?>
                <tr style="--i:<?= $ain_ei ?>">
                  <th scope="row"><?= e($ain_ev[0]) ?></th>
                  <td class="tih-ain__evv"><?= e($ain_ev[1]) ?></td>
                  <td class="tih-ain__evb" aria-hidden="true"><span><i style="--w:<?= $ain_ev[2] ?>"></i><b style="--g:<?= $ain_ev[4] ?>"></b></span></td>
                  <td class="tih-ain__evg"><?= e($ain_ev[3]) ?></td>
                  <td class="tih-ain__evm"><?= e($ain_ev[5]) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <p class="tih-ain__note"><span class="tih-k">Why it matters</span>Models and prompts change. The same 148 cases run on every change, so a regression blocks the merge instead of reaching a customer.</p>
        </div>

        <!-- AUDIT LOG -->
        <div class="bdh-pane tih-ain__pane tih-ain__aup" id="ai-native-p3" role="tabpanel" aria-labelledby="ai-native-t3">
          <div class="tih-ain__tw" tabindex="0" role="region" aria-label="Audit log, scroll sideways on small screens">
            <table class="tih-ain__audit">
              <thead><tr><th scope="col">Time</th><th scope="col">Actor</th><th scope="col">Action</th><th scope="col">Model · prompt</th><th scope="col">Reviewer</th><th scope="col">Result</th></tr></thead>
              <tbody>
                <?php foreach ($ain_audit as $ain_a): ?>
                  <tr>
                    <td><?= e($ain_a[0]) ?></td>
                    <td><span class="tih-ain__who is-<?= e($ain_a[2]) ?>"><?= e($ain_a[1]) ?></span></td>
                    <td><?= e($ain_a[3]) ?></td>
                    <td class="tih-ain__mono"><?= e($ain_a[4]) ?></td>
                    <td><?= e($ain_a[5]) ?></td>
                    <td><span class="tih-ain__res"><?= e($ain_a[6]) ?></span></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <p class="tih-ain__note"><span class="tih-k">Retention</span>Kept with the pull request and the release, exportable to your SIEM, and sampled in the monthly audit.</p>
        </div>
      </div>
    </div>

    <div class="tih-ain__below">
      <ul class="tih-ain__rules" data-rv-s data-rv-step="80">
        <?php foreach ($ain_rules as $ain_r): ?>
          <li>
            <span class="tih-ain__ri" aria-hidden="true"><?= xt_icon($ain_r[0], ['size' => 20]) ?></span>
            <h3 class="bdh-t bdh-t--s"><?= e($ain_r[1]) ?></h3>
            <p class="bdh-d"><?= e($ain_r[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="tih-ain__dora" data-rv>
        <p class="tih-k">What we track on every programme · DORA metrics <span class="bdh-ill">Illustrative</span></p>
        <dl class="tih-ain__dl4">
          <?php foreach ($ain_dora as $ain_m): ?>
            <div><dt><?= e($ain_m[0]) ?></dt><dd><b><?= e($ain_m[1]) ?></b><span><?= e($ain_m[2]) ?></span></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>
  </div>
</section>
