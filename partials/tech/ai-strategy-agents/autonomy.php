<?php /* DRAFT COPY — review before launch */
/* 03 SIGNATURE — the Autonomy Dial. Pick a task, set the autonomy level (L1–L4), set limits (spend per
   run, records touched, the task's own approval limit) and press Run. A trace plays: plan → retrieve
   policy → read a system → calculate → draft → policy check → write. The level decides the write
   step: L1 returns a suggestion, L2 saves an editable draft, L3 stops for a person to approve, L4 acts
   only inside the limits and escalates outside them. Budget and record guards halt a run at any level.
   autonomy.js autoplays runs until the demo is touched. No live model: outcomes are pre-authored,
   tokens, latency and prices are illustrative. HTML = the finished run (renewal at L3, approved). */
$tas_au_price = [   // $ per million tokens [in, out] — illustrative
    'router-small'   => [0.15, 0.60],
    'reasoner-large' => [3.00, 15.00],
    'embed'          => [0.02, 0.00],
];
$tas_au_icons = ['plan' => 'compass', 'retrieve' => 'doc', 'tool' => 'database', 'calc' => 'chart', 'draft' => 'prompt', 'check' => 'shield', 'write' => 'sync'];
$tas_au_phase = ['plan' => 'Plan', 'retrieve' => 'Retrieve policy', 'tool' => 'Read system', 'calc' => 'Calculate', 'draft' => 'Draft', 'check' => 'Policy check', 'write' => 'Write action'];
/* steps: [phase, tool, scope, model, input, output, latency ms, tokens in, tokens out, records] */
$tas_au_tasks = [
    'renew' => [
        'label' => 'Renew a customer contract', 'short' => 'Contract renewal', 'sub' => 'Account 20-418 · renewal due in 30 days', 'owner' => 'Sales ops lead', 'agent' => 'renewals-agent', 'prompt' => 'renewals v14.1',
        'limit' => ['label' => 'Max discount without approval', 'pre' => '', 'unit' => '%', 'min' => 0, 'max' => 20, 'step' => 1, 'def' => 10, 'value' => 8, 'what' => 'discount'],
        'policy' => 'Pricing policy v4 §3.2',
        'draft_tool' => 'crm.save_draft',
        'action' => 'Send quote Q-7731 to the customer',
        'steps' => [
            ['plan',     'planner',          'none',  'router-small',   'Goal: renew account 20-418 before 14 Oct',   '4 sub-tasks · tools kb, crm, calc', 640, 1200, 180, 0],
            ['retrieve', 'kb.search',        'read',  'embed',          '“renewal discount policy”',                   'Pricing policy v4 §3.2 · discounts up to the approval limit', 410, 40, 0, 0],
            ['tool',     'crm.get_account',  'read',  '',               'account_id = 20-418',                         'ARR $48,000 · 3 seats added · usage +18%', 280, 0, 0, 2],
            ['calc',     'calc.renewal',     'none',  '',               'ARR, seats, 24-month term',                   'Price $51,840 · discount 8%', 35, 0, 0, 0],
            ['draft',    'llm.draft',        'none',  'reasoner-large', 'Quote and cover email in the account’s tone', 'Quote Q-7731 · email of 146 words', 2100, 3400, 620, 0],
            ['check',    'policy.check',     'none',  '',               'discount, records, spend vs limits',          '', 90, 0, 0, 0],
            ['write',    'crm.update_quote', 'write', '',               'Q-7731 → status “sent”',                      '', 320, 0, 0, 1],
        ],
        'rec'   => 'Renew account 20-418 for 24 months at $51,840 with an 8% discount. Sources: pricing policy v4 §3.2 and CRM usage.',
        'draft' => "Subject: Your renewal, ready to sign\n\nHello,\n\nYour subscription renews on 14 October. With the three seats added this year, we propose a 24-month renewal at $51,840, including an 8% multi-year discount.\n\nQuote Q-7731 is attached. Reply with any changes, or sign in the portal.\n\nSales operations, Your company",
    ],
    'dispute' => [
        'label' => 'Resolve a billing dispute', 'short' => 'Billing dispute', 'sub' => 'Ticket 4471 · customer reports a double charge', 'owner' => 'Service lead', 'agent' => 'billing-agent', 'prompt' => 'billing v15.1',
        'limit' => ['label' => 'Max credit without approval', 'pre' => '$', 'unit' => '', 'min' => 0, 'max' => 1000, 'step' => 50, 'def' => 300, 'value' => 240, 'what' => 'credit'],
        'policy' => 'Credit policy v2 §1.4',
        'draft_tool' => 'billing.save_draft',
        'action' => 'Issue credit note CN-2291 for $240.00',
        'steps' => [
            ['plan',     'planner',              'none',  'router-small',   'Goal: resolve ticket 4471 (double charge)', '5 sub-tasks · tools kb, billing, calc', 590, 1100, 160, 0],
            ['retrieve', 'kb.search',            'read',  'embed',          '“duplicate charge credit policy”',          'Credit policy v2 §1.4 · credits up to the approval limit', 380, 40, 0, 0],
            ['tool',     'billing.get_invoices', 'read',  '',               'customer C-8812 · last 3 invoices',         'INV-5530 charged twice on 2 Sep · $240.00', 340, 0, 0, 3],
            ['calc',     'calc.credit',          'none',  '',               'duplicate line, tax included',             'Credit $240.00 · no fee', 30, 0, 0, 0],
            ['draft',    'llm.draft',            'none',  'router-small',   'Customer reply and credit note',            'Reply of 112 words · credit note CN-2291', 950, 2600, 410, 0],
            ['check',    'policy.check',         'none',  '',               'credit, records, spend vs limits',          '', 80, 0, 0, 0],
            ['write',    'billing.issue_credit', 'write', '',               'CN-2291 → issue $240.00',                   '', 410, 0, 0, 1],
        ],
        'rec'   => 'Issue a $240.00 credit on INV-5530: the charge appears twice on 2 September. Sources: credit policy v2 §1.4 and billing history.',
        'draft' => "Subject: Your invoice INV-5530\n\nHello,\n\nYou were charged twice for invoice INV-5530 on 2 September. We have raised credit note CN-2291 for $240.00, which will show on your next statement.\n\nThere is nothing you need to do. Reply here if anything looks wrong.\n\nBilling team, Your company",
    ],
    'board' => [
        'label' => 'Prepare a board pack', 'short' => 'Board pack', 'sub' => 'Q3 pack · board meets 30 Sep', 'owner' => 'CFO office', 'agent' => 'boardpack-agent', 'prompt' => 'boardpack v6',
        'limit' => ['label' => 'Max recipients without approval', 'pre' => '', 'unit' => ' people', 'min' => 0, 'max' => 20, 'step' => 1, 'def' => 10, 'value' => 7, 'what' => 'recipients'],
        'policy' => 'Board governance note §2',
        'draft_tool' => 'docs.save_draft',
        'action' => 'Share the Q3 pack with 7 board members',
        'steps' => [
            ['plan',     'planner',          'none',  'router-small',   'Goal: Q3 board pack for 30 Sep',        '6 sections · tools warehouse, docs, calc', 720, 1400, 220, 0],
            ['retrieve', 'kb.search',        'read',  'embed',          '“board pack template, distribution”',   'Template v3 · Board governance note §2 · board members only', 450, 60, 0, 1],
            ['tool',     'warehouse.query',  'read',  '',               'Q3 revenue, margin, cash, pipeline',    '14 tables · 20 records read', 1250, 0, 0, 20],
            ['calc',     'calc.variance',    'none',  '',               'Q3 vs budget and Q2',                   'Revenue +4.2% vs budget · margin −0.6 pts', 60, 0, 0, 0],
            ['draft',    'llm.draft',        'none',  'reasoner-large', 'Narrative for six sections, with charts', '6 sections · 2,300 words · 9 charts', 6400, 58000, 2900, 0],
            ['check',    'policy.check',     'none',  '',               'recipients, records, spend vs limits',  '', 85, 0, 0, 0],
            ['write',    'docs.share',       'write', '',               'Board folder · 7 members',              '', 290, 0, 0, 1],
        ],
        'rec'   => 'Build the Q3 pack from template v3 in six sections and share it with the seven board members only. Sources: board governance note §2 and the warehouse.',
        'draft' => "Q3 board pack · draft 1\n\n1. Summary: revenue 4.2% ahead of budget; gross margin 0.6 points below, driven by hosting costs.\n2. Cash: operating cash flow positive for the third quarter running.\n3. Pipeline: three enterprise renewals due in Q4.\n4. Risks: supplier concentration in logistics.\n5. Decision requested: approve the full-year reforecast.\n6. Appendix: nine charts, each linked to its warehouse source.",
    ],
];
$tas_au_levels = [
    [1, 'Suggest',           'Recommends only. No write tools.'],
    [2, 'Draft',             'Saves a draft. A person sends it.'],
    [3, 'Act with approval', 'Stops before the write for a person.'],
    [4, 'Act within limits', 'Writes inside limits, escalates outside.'],
];
$tas_au_guards = [
    ['wrench',  'Tool allow-list',          'Only the tools each level grants.'],
    ['key',     'Read and write scopes',    'Broad reads. Narrow, short-lived writes.'],
    ['gauge',   'Spend and record limits',  'Checked before every step and every write.'],
    ['doc',     'Policy check, cited',      'Each write checked against the policy it quotes.'],
    ['approve', 'Human approval',           'Consequential actions wait for a named person.'],
    ['log',     'Full audit log',           'Model, prompt, tools, spend and approver.'],
];
$tas_au_money = function (float $v): string {
    if ($v > 0 && $v < 0.00005) return '<$0.0001';   // an embedding call costs fractions of a hundredth of a cent
    return $v < 0.01 ? '$' . number_format($v, 4) : '$' . number_format($v, 3);
};
$tas_au_tok = function (int $n): string { return $n >= 1000 ? rtrim(rtrim(number_format($n / 1000, 1), '0'), '.') . 'k' : (string) $n; };
/* the finished run shipped in the HTML */
$tas_au_t = $tas_au_tasks['renew'];
$tas_au_rows = []; $tas_au_spend = 0.0; $tas_au_ms = 0; $tas_au_tin = 0; $tas_au_tout = 0; $tas_au_recs = 0;
foreach ($tas_au_t['steps'] as $tas_s) {
    $tas_pr = $tas_au_price[$tas_s[3]] ?? [0, 0];
    $tas_c = ($tas_s[7] * $tas_pr[0] + $tas_s[8] * $tas_pr[1]) / 1e6;
    $tas_au_spend += $tas_c; $tas_au_ms += $tas_s[6]; $tas_au_tin += $tas_s[7]; $tas_au_tout += $tas_s[8]; $tas_au_recs += $tas_s[9];
    $tas_au_rows[] = $tas_s + [10 => $tas_c];
}
/* the policy check counts the records the write will touch: 2 read + 1 written, against the limit of 25 */
$tas_au_rows[5][5] = 'Discount 8% ≤ 10% · records 2+1 ≤ 25 · spend ' . $tas_au_money($tas_au_spend) . ' ≤ $0.25 · cites §3.2';
$tas_au_rows[6][5] = 'Approved by Sales ops lead · Q-7731 sent';
$tas_au_cfg = [
    'price' => $tas_au_price, 'phase' => $tas_au_phase,
    'icons' => array_map(fn ($tas_i) => xt_icon($tas_i, ['size' => 18]), $tas_au_icons),
    'tasks' => $tas_au_tasks,
    'levels' => array_map(fn ($tas_l) => $tas_l[1], array_column($tas_au_levels, null, 0)),
];
?>
<section class="band band--ink tas-autonomy" id="autonomy" aria-labelledby="autonomy-t">
  <div class="wrap">
    <div class="tas-head" data-rv>
      <div class="tas-head__t">
        <p class="tas-kick"><span class="tas-kick__ref">03</span>Try it · the autonomy dial</p>
        <h2 class="h2" id="autonomy-t"><span class="g">You choose how much the agent may do.</span> Every step is traced.</h2>
      </div>
      <div class="tas-head__l">
        <p class="lead">Pick a task, set the level and the limits, then run the agent. The plan is the same every time; the level decides what happens at the write. Set a limit below the agent’s proposal and it escalates instead of acting.</p>
      </div>
    </div>

    <div class="tas-win tas-win--ink tas-au" data-tas-au data-rv data-state="done" data-cfg='<?= e(json_encode($tas_au_cfg, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?>'>
      <div class="tas-win__bar">
        <span class="tas-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="tas-win__path">agent-runner <b>· Your company · sandbox</b></span>
        <span class="tas-win__end tas-au__auto" data-au-auto><i class="tas-led tas-led--pulse"></i><span>Live demo · touch any control to take over</span></span>
      </div>
      <p class="bdh-sr">Interactive agent run: choose a task, an autonomy level and limits, then press Run. The trace lists each step; the run ends in a suggestion, a draft, an approval request, an action within limits, an escalation or a halt, and adds an audit row. Outcomes are pre-written; no live model is called.</p>

      <div class="tas-au__body">
        <form class="tas-au__ctl" onsubmit="return false" aria-label="Agent run settings">
          <fieldset class="tas-au__f">
            <legend class="tas-lbl">1 · Task</legend>
            <div class="tas-au__tasks">
              <?php $tas_ti = 0; foreach ($tas_au_tasks as $tas_tk => $tas_tt): ?>
                <label class="tas-au__task">
                  <input type="radio" name="tas-au-task" value="<?= e($tas_tk) ?>"<?= $tas_ti++ === 0 ? ' checked' : '' ?>>
                  <span class="tas-au__tbox"><b><span class="tas-au__tl"><?= e($tas_tt['label']) ?></span><span class="tas-au__ts"><?= e($tas_tt['short']) ?></span></b><small><?= e($tas_tt['sub']) ?></small><em><?= e($tas_tt['agent']) ?> · owner <?= e($tas_tt['owner']) ?></em></span>
                </label>
              <?php endforeach; ?>
            </div>
          </fieldset>

          <fieldset class="tas-au__f">
            <legend class="tas-lbl">2 · Autonomy level</legend>
            <div class="tas-au__dial" aria-hidden="true" style="--a:3">
              <svg viewBox="0 0 220 124" focusable="false">
                <path class="tas-au__arc" d="M20 112a90 90 0 0 1 180 0"/>
                <path class="tas-au__arcon" pathLength="100" d="M20 112a90 90 0 0 1 180 0"/>
                <?php foreach ([180, 120, 60, 0] as $tas_di => $tas_deg):
                    $tas_rx = 110 + cos(deg2rad($tas_deg)) * 90; $tas_ry = 112 - sin(deg2rad($tas_deg)) * 90;
                    $tas_lx = 110 + cos(deg2rad($tas_deg)) * 108; $tas_ly = 112 - sin(deg2rad($tas_deg)) * 108; ?>
                  <circle class="tas-au__stop" data-s="<?= $tas_di + 1 ?>" cx="<?= round($tas_rx, 1) ?>" cy="<?= round($tas_ry, 1) ?>" r="5"/>
                  <text class="tas-au__sl" x="<?= round($tas_lx, 1) ?>" y="<?= round($tas_ly + 4, 1) ?>" text-anchor="<?= $tas_di === 0 ? 'end' : ($tas_di === 3 ? 'start' : 'middle') ?>">L<?= $tas_di + 1 ?></text>
                <?php endforeach; ?>
                <g class="tas-au__needle"><line x1="110" y1="112" x2="110" y2="42"/><circle cx="110" cy="112" r="7"/></g>
              </svg>
              <p class="tas-au__dv"><b data-au-lvname>Act with approval</b><small data-au-lvdesc>Stops before the write for a person.</small></p>
            </div>
            <div class="tas-au__levels">
              <?php foreach ($tas_au_levels as $tas_lv): ?>
                <label class="tas-au__lv">
                  <input type="radio" name="tas-au-level" value="<?= $tas_lv[0] ?>" data-desc="<?= e($tas_lv[2]) ?>"<?= $tas_lv[0] === 3 ? ' checked' : '' ?>>
                  <span><?= tas_lvl($tas_lv[0], ['short' => true]) ?><b><?= e($tas_lv[1]) ?></b></span>
                </label>
              <?php endforeach; ?>
            </div>
          </fieldset>

          <fieldset class="tas-au__f tas-au__f--lim">
            <legend class="tas-lbl">3 · Limits</legend>
            <button type="button" class="tas-au__limt" aria-expanded="true" aria-controls="tas-au-lims" data-au-limt><span data-au-limsum>$0.25 · 25 records · 10%</span><span class="tas-au__limte" aria-hidden="true">Edit</span></button>
            <div class="tas-au__lims" id="tas-au-lims">
            <div class="tas-au__rg">
              <label for="tas-au-cap">Max spend per run <output id="tas-au-cap-o" for="tas-au-cap">$0.25 <small>≈ ₹22</small></output></label>
              <input type="range" id="tas-au-cap" min="0.01" max="0.50" step="0.01" value="0.25" aria-valuetext="$0.25, about 22 rupees">
            </div>
            <div class="tas-au__rg">
              <label for="tas-au-rec">Max records touched <output id="tas-au-rec-o" for="tas-au-rec">25</output></label>
              <input type="range" id="tas-au-rec" min="1" max="50" step="1" value="25" aria-valuetext="25 records">
            </div>
            <div class="tas-au__rg">
              <label for="tas-au-lim"><span data-au-limlabel><?= e($tas_au_t['limit']['label']) ?></span> <output id="tas-au-lim-o" for="tas-au-lim">10%</output></label>
              <input type="range" id="tas-au-lim" min="0" max="20" step="1" value="10" aria-valuetext="10%">
              <small class="tas-au__prop">Agent will propose <b data-au-prop>8%</b></small>
            </div>
            </div>
          </fieldset>

          <div class="tas-au__go">
            <button type="button" class="tas-btn tas-btn--blue tas-au__run" data-au-run><?= xt_icon('bolt', ['size' => 16, 'mono' => true]) ?>Run agent</button>
            <button type="button" class="tas-btn" data-au-reset>Reset limits</button>
          </div>
        </form>

        <div class="tas-au__main">
          <div class="tas-au__head">
            <div class="tas-au__who">
              <p class="tas-au__rid"><span data-au-rid>run_7f3a21</span> · <span data-au-agent>renewals-agent</span> · prompt <span data-au-prompt>renewals v14.1</span></p>
              <p class="tas-au__task" data-au-tasklabel>Renew a customer contract</p>
            </div>
            <span data-au-lvtag><?= tas_lvl(3) ?></span>
            <dl class="tas-au__tot">
              <div><dt>Latency</dt><dd data-au-ms><?= number_format($tas_au_ms / 1000, 1) ?> s</dd></div>
              <div><dt>Tokens</dt><dd data-au-tok><?= $tas_au_tok($tas_au_tin) ?> → <?= $tas_au_tok($tas_au_tout) ?></dd></div>
              <div><dt>Records</dt><dd data-au-recs><?= $tas_au_recs ?></dd></div>
              <div><dt>Spend</dt><dd data-au-spend><?= $tas_au_money($tas_au_spend) ?></dd></div>
            </dl>
          </div>
          <p class="tas-au__status" role="status" aria-live="polite" data-au-status>Run complete · approved by Sales ops lead · quote sent · audit entry written</p>

          <ol class="tas-au__trace" data-au-trace aria-label="Run trace">
            <?php foreach ($tas_au_rows as $tas_ri => $tas_r): ?>
              <li class="tas-tr" data-k="<?= e($tas_r[0]) ?>" data-st="ok">
                <span class="tas-tr__ic" aria-hidden="true"><?= xt_icon($tas_au_icons[$tas_r[0]], ['size' => 18]) ?></span>
                <div class="tas-tr__main">
                  <p class="tas-tr__h"><b><?= e($tas_au_phase[$tas_r[0]]) ?></b><code><?= e($tas_r[1]) ?></code><?php if ($tas_r[2] !== 'none'): ?><span class="tas-tr__scope" data-scope="<?= e($tas_r[2]) ?>"><?= e($tas_r[2]) ?></span><?php endif; ?><?php if ($tas_r[3]): ?><span class="tas-tr__model"><?= e($tas_r[3]) ?></span><?php endif; ?></p>
                  <p class="tas-tr__io"><span>in</span><?= e($tas_r[4]) ?></p>
                  <p class="tas-tr__io tas-tr__io--out"><span>out</span><em><?= e($tas_r[5]) ?></em></p>
                </div>
                <p class="tas-tr__nums"><span><?= (int) $tas_r[6] ?> ms</span><span><?= ($tas_r[7] || $tas_r[8]) ? e($tas_au_tok($tas_r[7]) . ' → ' . $tas_au_tok($tas_r[8])) : '—' ?></span><span><?= $tas_r[10] > 0 ? e($tas_au_money($tas_r[10])) : '—' ?></span></p>
                <span class="tas-tr__st" aria-hidden="true"></span>
              </li>
            <?php endforeach; ?>
          </ol>

          <div class="tas-au__res" data-au-res="done">
            <div class="tas-au__pane" data-pane="idle">
              <p class="tas-au__pk">Ready</p>
              <p class="tas-au__pt">Press Run agent to start. Change a limit first to see a guard step in.</p>
            </div>
            <div class="tas-au__pane" data-pane="suggest">
              <p class="tas-au__pk"><?= xt_icon('lightbulb', ['size' => 16]) ?>Suggestion · no write tools at L1</p>
              <p class="tas-au__pt" data-f="rec"><?= e($tas_au_t['rec']) ?></p>
              <p class="tas-au__pn">Sent to <span data-f="owner"><?= e($tas_au_t['owner']) ?></span>. A person does the work.</p>
            </div>
            <div class="tas-au__pane" data-pane="draft">
              <p class="tas-au__pk"><?= xt_icon('doc', ['size' => 16]) ?>Draft saved · <span data-f="drafttool"><?= e($tas_au_t['draft_tool']) ?></span></p>
              <label class="bdh-sr" for="tas-au-draft">Editable draft</label>
              <textarea id="tas-au-draft" class="tas-au__draft" rows="6" data-f="draft"><?= e($tas_au_t['draft']) ?></textarea>
              <p class="tas-au__pn">Editable. Nothing leaves until <span data-f="owner"><?= e($tas_au_t['owner']) ?></span> sends it.</p>
            </div>
            <div class="tas-au__pane" data-pane="approve">
              <p class="tas-au__pk"><i class="tas-led tas-led--pulse"></i><span data-f="apprk">Approval needed</span> · <span data-f="owner"><?= e($tas_au_t['owner']) ?></span></p>
              <p class="tas-au__pt" data-f="action"><?= e($tas_au_t['action']) ?>?</p>
              <p class="tas-au__pn" data-f="why">Evidence: pricing policy v4 §3.2 · CRM usage +18% · 3 records affected</p>
              <div class="tas-au__pbtn">
                <button type="button" class="tas-btn tas-btn--blue" data-au-approve>Approve and run</button>
                <button type="button" class="tas-btn" data-au-reject>Reject</button>
              </div>
            </div>
            <div class="tas-au__pane is-on" data-pane="done">
              <p class="tas-au__pk"><span class="tas-au__okdot" aria-hidden="true"></span><span data-f="donek">Executed after approval</span></p>
              <p class="tas-au__pt" data-f="donet">Quote Q-7731 sent. Approved by Sales ops lead.</p>
              <dl class="tas-au__rc">
                <div><dt>Write</dt><dd data-f="rw">crm.update_quote · Q-7731 → status “sent”</dd></div>
                <div><dt>Approver</dt><dd data-f="rappr">Sales ops lead</dd></div>
                <div><dt>Waited for a person</dt><dd data-f="rwait">14 s</dd></div>
                <div><dt>Audit row</dt><dd data-f="raudit">run_7f3a21 · append-only</dd></div>
              </dl>
            </div>
            <div class="tas-au__pane" data-pane="halt">
              <p class="tas-au__pk"><span class="tas-au__xdot" aria-hidden="true"></span><span data-f="haltk">Run stopped by a guard</span></p>
              <p class="tas-au__pt" data-f="haltt">The run passed its limit and stopped before acting.</p>
              <p class="tas-au__pn">Handed to <span data-f="owner"><?= e($tas_au_t['owner']) ?></span> with the trace so far.</p>
              <dl class="tas-au__rc">
                <div><dt>Stopped at</dt><dd data-f="hstep">—</dd></div>
                <div><dt>Written</dt><dd>Nothing</dd></div>
                <div><dt>Spend so far</dt><dd data-f="hspend">—</dd></div>
                <div><dt>Audit row</dt><dd data-f="haudit">—</dd></div>
              </dl>
            </div>
          </div>

          <div class="tas-au__audit">
            <p class="tas-lbl">Audit log · append-only · newest first</p>
            <ol class="tas-au__log" data-au-log aria-label="Audit log, newest first">
              <li class="tas-au__le">
                <p class="tas-au__l1"><span class="tas-au__lk">10:42:07</span><b class="tas-au__lr">run_7f3a21</b><span class="tas-au__lk">L3</span><span class="tas-au__lt">Renew a customer contract</span><span class="tas-au__lo" data-o="exec">Executed after approval</span></p>
                <dl class="tas-au__l2">
                  <div><dt>Approver</dt><dd>Sales ops lead</dd></div>
                  <div><dt>Models</dt><dd>router-small · embed · reasoner-large</dd></div>
                  <div><dt>Prompt</dt><dd>renewals v14.1</dd></div>
                  <div><dt>Tools</dt><dd>kb.search:r · crm.get_account:r · crm.update_quote:w</dd></div>
                  <div><dt>Records</dt><dd><?= $tas_au_recs ?></dd></div>
                  <div><dt>Spend</dt><dd><?= e($tas_au_money($tas_au_spend)) ?></dd></div>
                </dl>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="tas-au__guards">
      <ul class="tas-au__gl" data-rv-s data-rv-step="60">
        <?php foreach ($tas_au_guards as $tas_g): ?>
          <li><?= xt_icon($tas_g[0], ['size' => 22]) ?><h3><?= e($tas_g[1]) ?></h3><p><?= e($tas_g[2]) ?></p></li>
        <?php endforeach; ?>
      </ul>
      <div class="tas-au__owasp xt-on-ink" data-rv>
        <?= xt_badge('owasp-llm', ['variant' => 'chip']) ?>
        <p><b>LLM06 · Excessive Agency.</b> The OWASP mitigations made concrete: minimal tools, minimal permissions, human approval for high-impact actions and every call mediated. Prompt injection (LLM01) is tested against the same run in the eval suite.</p>
      </div>
    </div>
  </div>
</section>
