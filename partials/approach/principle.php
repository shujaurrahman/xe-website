<?php /* DRAFT COPY — review before launch */
$apr_rows = [
  ['agent', 'Agents', 'Do the repeatable work: research synthesis, drafts, variants, code changes, checks, monitoring.', 'agent.localise · 4 markets · 38 assets', 'Built and run by us'],
  ['eval', 'Evals', 'Score every output against a written standard before a person sees it. Failing work never reaches a gate.', 'eval.tone · 0.92 ≥ 0.85 · pass', 'Thresholds set with you'],
  ['shield', 'Guardrails', 'Hard limits an agent cannot cross: unsupported claims, personal data, off-brand language, prompt injection.', 'guard.pii · 2 fields redacted', 'Rules owned by you'],
  ['approve', 'Approval gates', 'A named person approves each step that ships, spends or speaks for you. The agent waits.', 'gate.legal · approved · A. Rao', 'Your approvers'],
  ['log', 'Audit logs', 'Every prompt, model, output, score and decision is written down with who, what and when.', 'log · 1,284 entries · exportable', 'Readable by you, always'],
];
?>
<section class="band band--alt apr-pr" id="principle" aria-labelledby="principle-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>The operating principle</p>
        <h2 class="h2" id="principle-t"><span class="g">Five controls</span> between an agent and your brand.</h2></div>
      <div><p class="lead">Speed comes from agents. Trust comes from the controls around them. This is the whole mechanism, and none of it is optional on our work.</p></div>
    </div>
    <div class="apr-pr__table" role="table" aria-label="The five controls">
      <div class="apr-pr__row apr-pr__row--h" role="row">
        <span role="columnheader">Control</span><span role="columnheader">What it does</span><span role="columnheader">In the log</span><span role="columnheader">Who owns it</span>
      </div>
      <?php foreach ($apr_rows as $apr_n => $apr_r): ?>
      <div class="apr-pr__row" role="row">
        <span class="apr-pr__name" role="rowheader"><span class="bdh-idx">0<?= $apr_n + 1 ?></span><?= xt_icon($apr_r[0]) ?><b><?= e($apr_r[1]) ?></b></span>
        <span class="apr-pr__d" role="cell"><?= e($apr_r[2]) ?></span>
        <span class="apr-pr__ro" role="cell"><code><?= e($apr_r[3]) ?></code></span>
        <span class="apr-pr__own" role="cell"><?= e($apr_r[4]) ?></span>
      </div>
      <?php endforeach; ?>
    </div>
    <p class="apr-note">People stay on the decisions that carry judgement: what to make, for whom, what it may claim, and whether it ships.</p>
  </div>
</section>
