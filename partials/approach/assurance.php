<?php /* DRAFT COPY — review before launch */
/* Assurance — the four mechanisms that make the roster safe to run: evals, guardrails, approval gates
   and the audit log. Each is a card with what it is, where it runs, what it blocks and what it costs you
   to keep. Consistent with the Technology & Intelligence hub: the same gates, the same OWASP LLM01
   reference, the same "agents propose, people approve" rule, stated here for the whole company rather
   than for one platform. */
$apra_blocks = [
    ['eval', 'Evals', 'A golden set built from your real cases',
     'Every AI feature has a set of real cases with known-good answers, scored on faithfulness, answer relevance, citation accuracy, correct refusals, latency and cost. The set is written from your own tickets and calls, and it belongs to you.',
     [['Runs', 'On every change, in your pipeline'], ['Blocks', 'A merge that misses a gate'], ['Owner', 'Your QA and eval engineer']],
     'Models and prompts change under you. The same cases run on every change, so a regression stops at the merge instead of reaching a customer.'],

    ['shield', 'Guardrails', 'Checks around the model, not just prompts inside it',
     'Personal data is redacted before a model call. Prompt-injection cases from OWASP LLM01 sit in the test suite. Tools are called with scoped, short-lived tokens, never with standing credentials. Spend has a cap. Below a confidence threshold the request goes to a person rather than to a guess.',
     [['Runs', 'On every request, in the gateway'], ['Blocks', 'Leakage, injection, runaway spend'], ['Owner', 'Your security engineer']],
     'A guardrail written into a prompt is a suggestion. A guardrail in front of the model is a control.'],

    ['approve', 'Approval gates', 'A named person, recorded, every time',
     'Agents draft, test, scan and deploy. A named person approves every merge, every production change and anything stated as fact to a customer. Anything touching a person\'s money, health, employment or legal rights is reviewed by a person before it is acted on, not after.',
     [['Runs', 'At the merge and at the release'], ['Blocks', 'Any change with no approver'], ['Owner', 'Our delivery lead and your reviewer']],
     'This is what "AI runs the operation, people run the strategy" costs in practice: a person\'s name on every change.'],

    ['log', 'Audit log', 'Model, prompt, inputs, output, reviewer',
     'Every AI action is recorded with the model and prompt version that produced it, the inputs it saw, what it returned and who reviewed it. The log is kept with the pull request and the release, exportable to your own systems, and sampled in review.',
     [['Runs', 'Continuously'], ['Blocks', 'Nothing — it is the evidence'], ['Owner', 'Yours, in your systems']],
     'When someone asks in a year why the system said what it said, the answer is a record, not a recollection.'],
];
$apra_lines = [
    ['No client data in public model training', 'Enterprise endpoints with training on your data switched off, in your region where that matters.'],
    ['No secrets in a prompt',                  'Credentials stay in the vault. Agents call tools with scoped, short-lived tokens.'],
    ['No autonomous decision about a person',   'Money, health, employment and legal rights are reviewed by a person first.'],
    ['No silent model change',                  'A model or prompt version change is a recorded change, re-evaluated before it ships.'],
];
?>
<section class="band apr-assurance" id="assurance" aria-labelledby="assurance-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Assurance</p>
        <h2 class="h2" id="assurance-t"><span class="g">What makes it safe</span> to let agents work.</h2>
      </div>
      <div>
        <p class="lead">Four mechanisms, each with somewhere it runs, something it blocks and someone who
          owns it. None of them is a promise about our intentions. They are controls, and you can audit
          all four.</p>
      </div>
    </div>

    <ul class="apr-as__grid" data-rv-s data-rv-step="70">
      <?php foreach ($apra_blocks as $apra_i => $apra_b): ?>
        <li class="apr-as__card">
          <p class="apr-as__top">
            <span class="apr-ico" aria-hidden="true"><?= xt_icon($apra_b[0], ['size' => 20]) ?></span>
            <span class="bdh-idx"><?= str_pad((string) ($apra_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          </p>
          <h3 class="bdh-t bdh-t--l"><?= e($apra_b[1]) ?></h3>
          <p class="apr-as__sub"><?= e($apra_b[2]) ?></p>
          <p class="bdh-d apr-as__d"><?= e($apra_b[3]) ?></p>
          <dl class="apr-defs apr-as__defs">
            <?php foreach ($apra_b[4] as $apra_r): ?>
              <div><dt><?= e($apra_r[0]) ?></dt><dd><?= e($apra_r[1]) ?></dd></div>
            <?php endforeach; ?>
          </dl>
          <p class="apr-as__why"><span class="apr-k">Why it matters</span><span><?= e($apra_b[5]) ?></span></p>
        </li>
      <?php endforeach; ?>
    </ul>

    <ul class="apr-as__lines" data-rv-s data-rv-step="60">
      <?php foreach ($apra_lines as $apra_l): ?>
        <li>
          <h3 class="apr-as__ln"><span class="apr-as__x" aria-hidden="true">&times;</span><?= e($apra_l[0]) ?></h3>
          <p class="bdh-d"><?= e($apra_l[1]) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
