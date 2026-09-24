<?php /* DRAFT COPY — review before launch */
/* The signature board: one piece of work travelling the intelligence layer. Without JS the chosen
   scenario (?run=) renders finished — every lane filled, the full log. JS replays it lane by lane and
   pauses at the human gate for the visitor to approve or send back. */
$apr_lanes = ['signal' => ['radar', 'Signal'], 'agent' => ['agent', 'Agent'], 'eval' => ['eval', 'Evals'],
              'guard' => ['shield', 'Guardrails'], 'gate' => ['approve', 'Human gate'], 'ship' => ['rocket', 'Ship + learn']];
$apr_sc = [
  'campaign' => ['name' => 'Localise a campaign', 'lanes' => [
      'signal' => ['Launch brief approved', 'Spring range · 4 markets · 38 assets', 'brief v4 · locked'],
      'agent'  => ['Localisation agent', 'Adapts copy and layouts to approved parts per market', '152 drafts · 6 min'],
      'eval'   => ['Brand + language evals', 'Tone, terminology, type scale, contrast 4.5:1', '149 / 152 pass'],
      'guard'  => ['Claims guardrail', 'Holds superlatives with no source on file', '3 held · reason logged'],
      'gate'   => ['Market lead approves', 'Reviews held items and a 10% sample', 'Approver · market lead'],
      'ship'   => ['Published + watched', 'Drift monitor checks live placements weekly', 'outcome → next brief']],
    'log' => [['09:02', 'brief.lock · v4 · by brand lead'], ['09:03', 'agent.localise · start · 4 markets'], ['09:09', 'agent.localise · 152 drafts'], ['09:10', 'eval.brand · 149 pass · 3 fail → redraft'], ['09:12', 'guard.claims · 3 held · "best-selling" unsourced'], ['09:40', 'gate.market · approved 149 · 3 rewritten by hand'], ['09:41', 'ship.publish · 152 assets · monitor on']]],
  'code' => ['name' => 'Ship a checkout change', 'lanes' => [
      'signal' => ['Drop-off spike at payment', 'Analytics alert · step 3 · mobile', 'alert · p75 INP 310 ms'],
      'agent'  => ['Coding agent', 'Proposes a fix in a branch with tests', 'PR · 4 files · 2 tests'],
      'eval'   => ['Test + performance evals', 'Unit, e2e, Lighthouse, INP budget ≤ 200 ms', 'INP 160 ms · all green'],
      'guard'  => ['Security guardrail', 'Dependency scan, secrets scan, OWASP checks', '0 critical · 0 secrets'],
      'gate'   => ['Tech lead reviews', 'Human code review, then a staged rollout', 'Approver · tech lead'],
      'ship'   => ['Rolled out at 10% → 100%', 'Automatic rollback if error rate rises', 'drop-off watched 14 days']],
    'log' => [['14:20', 'signal.alert · checkout step 3 · INP 310 ms'], ['14:22', 'agent.code · branch fix/pay-input'], ['14:31', 'eval.tests · 212 pass · INP 160 ms'], ['14:32', 'guard.security · scan clean'], ['15:05', 'gate.review · approved · 1 comment resolved'], ['15:06', 'ship.rollout · 10% canary'], ['16:10', 'ship.rollout · 100% · rollback armed']]],
  'support' => ['name' => 'Answer a policy question', 'lanes' => [
      'signal' => ['Customer asks about returns', 'Chat · web · after-sales', 'intent · returns · 0.94'],
      'agent'  => ['Knowledge assistant', 'Retrieves from approved policy pages only', '3 sources · cited'],
      'eval'   => ['Grounding eval', 'Every sentence must trace to a cited source', 'grounded 1.00'],
      'guard'  => ['Prompt-injection guardrail', 'OWASP LLM01 filter on input and retrieved text', 'clean · no PII sent'],
      'gate'   => ['Escalation rule', 'Refunds over the limit go to a person', 'Approver · support lead'],
      'ship'   => ['Answered + sampled', 'A weekly human review of sampled answers', 'CSAT fed to evals']],
    'log' => [['11:14', 'signal.chat · intent returns'], ['11:14', 'agent.rag · 3 passages · policy v12'], ['11:14', 'eval.grounding · 1.00 · pass'], ['11:14', 'guard.llm01 · input clean'], ['11:15', 'gate.rule · under limit · auto-send allowed'], ['11:15', 'ship.answer · sent with sources'], ['Fri', 'review.sample · 40 answers · 1 corrected']]],
];
$apr_run = is_string($_GET['run'] ?? null) && isset($apr_sc[$_GET['run']]) ? $_GET['run'] : 'campaign';
$apr_cur = $apr_sc[$apr_run];
?>
<section class="band band--ink apr-board" id="board" aria-labelledby="board-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--c" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>The intelligence layer, working</p>
      <h2 class="h2" id="board-t"><span class="g">One piece of work,</span> six lanes, one person who says yes.</h2>
      <p class="lead">Pick a job and watch it move. The board stops at the human gate: approve it, or send it back and see what the agent does with your note.</p>
    </div>
    <div class="apr-bd" data-apr-board data-run="<?= e($apr_run) ?>">
      <div class="apr-bd__top">
        <nav class="apr-bd__sc" aria-label="Choose a job">
          <?php foreach ($apr_sc as $apr_k => $apr_s): ?>
          <a class="apr-bd__pick" href="<?= e(xe_url('approach.php') . '?run=' . $apr_k . '#board') ?>" data-run="<?= e($apr_k) ?>"<?= $apr_k === $apr_run ? ' aria-current="true"' : '' ?>><?= e($apr_s['name']) ?></a>
          <?php endforeach; ?>
        </nav>
        <div class="apr-bd__ctl" hidden data-apr-ctl>
          <button type="button" class="apr-bd__btn" data-apr-play>Replay</button>
          <span class="apr-bd__status" role="status" aria-live="polite" data-apr-status>Finished · approved</span>
        </div>
      </div>
      <div class="apr-bd__body">
        <ol class="apr-bd__lanes">
          <?php $apr_n = 0; foreach ($apr_lanes as $apr_k => $apr_l): $apr_v = $apr_cur['lanes'][$apr_k]; $apr_n++; ?>
          <li class="apr-ln apr-ln--<?= $apr_k ?> is-done" data-lane="<?= $apr_k ?>">
            <p class="apr-ln__k"><span class="apr-ln__n">0<?= $apr_n ?></span><?= xt_icon($apr_l[0]) ?><?= e($apr_l[1]) ?></p>
            <h3 class="apr-ln__t" data-f="0"><?= e($apr_v[0]) ?></h3>
            <p class="apr-ln__d" data-f="1"><?= e($apr_v[1]) ?></p>
            <p class="apr-ln__ro" data-f="2"><?= e($apr_v[2]) ?></p>
            <?php if ($apr_k === 'gate'): ?>
            <p class="apr-ln__ask" hidden data-apr-ask>
              <button type="button" class="apr-bd__btn apr-bd__btn--y" data-apr-yes>Approve</button>
              <button type="button" class="apr-bd__btn" data-apr-no>Send back</button>
            </p>
            <?php endif; ?>
          </li>
          <?php endforeach; ?>
        </ol>
        <div class="apr-bd__log">
          <p class="apr-bd__lh"><?= xt_icon('log') ?> Audit log <span>append-only</span></p>
          <ol class="apr-bd__entries" data-apr-log aria-label="Audit log entries" tabindex="0">
            <?php foreach ($apr_cur['log'] as $apr_e): ?><li><time><?= e($apr_e[0]) ?></time><span><?= e($apr_e[1]) ?></span></li><?php endforeach; ?>
          </ol>
        </div>
      </div>
    </div>
    <script type="application/json" id="apr-board-data"><?= json_encode($apr_sc, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
    <p class="apr-board__foot">Sample runs for a fictional “Your company”. Timings are illustrative, not measured results.</p>
  </div>
</section>
