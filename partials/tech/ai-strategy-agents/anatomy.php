<?php /* DRAFT COPY — review before launch */
/* Anatomy — what a production agent is made of, as the stack showcase. A central agent loop
   (plan → act → observe) with eight slots around it, each holding the technologies we work with for
   that part. anatomy.js turns the loop and lights the slots used in each phase while on screen.
   The HTML is the finished diagram. Logos are technologies we work with, never partnerships.
   Every technology renders as the same chip (a mark box and the name), so a slot never mixes two
   styles: entries the shared logo library has no licence-clean mark for (file null in
   data/tech-stack.php) and tools outside the library get a neutral box, never a drawn logo.
   Shared change requested: marks for OpenAI, LlamaIndex, pgvector, Langfuse, Model Context Protocol,
   Open Policy Agent, Presidio, NeMo Guardrails, Llama Guard, promptfoo and Ragas. */
$tas_an_slots = [   // [key, title, phase, icon, why, technologies: logo-library slugs, or '=Name' for a tool outside the library]
    'left' => [
        ['models', 'Models',               'plan',    'brain',    'Chosen per step: a small model to route, a larger one only where reasoning pays. Hosted APIs, or open-weight models served in your region.', ['anthropic', 'googlegemini', 'meta', 'mistralai', 'openai', 'vllm', 'huggingface']],
        ['orch',   'Orchestration',        'plan',    'workflow', 'The agent as a graph with checkpoints, retries and runs that resume after a failure.',     ['langgraph', 'langchain', 'temporal', 'python']],
        ['memory', 'Memory & knowledge',   'plan',    'database', 'Session state in Redis; knowledge in a vector index that keeps a link to every source.',   ['postgresql', 'pgvector', 'qdrant', 'redis', 'llamaindex']],
        ['id',     'Identity & permissions','act',    'key',      'Each agent has its own identity, with short-lived, least-privilege credentials.',          ['okta', 'auth0', 'vault', 'openid']],
    ],
    'right' => [
        ['tools',  'Tools & APIs',         'act',     'plug',     'MCP servers wrap your systems once, so any agent can use them with scoped permissions.',   ['=Model Context Protocol', 'fastapi', 'openapiinitiative', 'hubspot', 'salesforce']],
        ['guard',  'Guardrails',           'act',     'shield',   'Policy as code on every tool call, PII redaction, and input and output checks enforced outside the model.', ['=Open Policy Agent', '=Microsoft Presidio', '=NeMo Guardrails', '=Llama Guard']],
        ['evals',  'Evals',                'observe', 'eval',     'Golden sets, tool-order checks and calibrated LLM-as-judge scoring on every change, gated in CI.', ['=promptfoo', '=Ragas', 'mlflow', 'githubactions']],
        ['obs',    'Observability',        'observe', 'uptime',   'Every step traced: latency, tokens, cost and tool inputs, in the tools your SREs use.',   ['opentelemetry', '=Langfuse', 'grafana', 'datadog']],
    ],
];
$tas_an_phases = [   // [key, label, what the phase does, live readout shown in the loop]
    ['plan',    'Plan',    'Decide the next step and the tool for it', 'router-small picks the next tool from the six on its allow-list'],
    ['act',     'Act',     'Call one tool, with a scoped identity',      'crm.get_account via an MCP server · read scope · agent identity'],
    ['observe', 'Observe', 'Check the result, trace it, loop or stop',   'result checked · span written · cost added · next step decided'],
];
$tas_an_facts = [
    ['sync',  'Model-agnostic by design', 'A model swap is a change to one route, re-run through the eval suite before it ships.'],
    ['lock',  'Your data stays yours',    'Enterprise API terms or self-hosted open-weight models. Nothing trains on your data.'],
    ['globe', 'Region where required',     'Inference and storage pinned to the region your policy, GDPR or the DPDP Act requires.'],
];
$tas_an_slot = function (array $s, string $side) {
    ob_start(); ?>
      <li class="tas-an__slot tas-an__slot--<?= $side ?>" data-phase="<?= e($s[2]) ?>">
        <div class="tas-an__st">
          <span class="tas-an__si"><?= xt_icon($s[3], ['size' => 20]) ?></span>
          <h3><?= e($s[1]) ?></h3>
          <span class="tas-an__sp"><?= e($s[2]) ?></span>
        </div>
        <p class="tas-an__sw"><?= e($s[4]) ?></p>
        <ul class="tas-an__tech" role="list" aria-label="<?= e($s[1]) ?>: technologies we work with">
          <?php foreach ($s[5] as $tas_slug):
              $tas_t = $tas_slug[0] === '=' ? null : xt_tech($tas_slug);
              $tas_nm = $tas_t['name'] ?? ltrim($tas_slug, '='); ?>
            <li class="tas-an__chip"><span class="tas-an__gl<?= empty($tas_t['file']) ? ' is-none' : '' ?>" aria-hidden="true"><?= !empty($tas_t['file']) ? xt_logo($tas_slug, ['hidden' => true, 'size' => 14]) : '' ?></span><span class="tas-an__cn"><?= e($tas_nm) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </li>
    <?php return ob_get_clean();
};
?>
<section class="band tas-anatomy" id="anatomy" aria-labelledby="anatomy-t">
  <div class="wrap">
    <div class="tas-head" data-rv>
      <div class="tas-head__t">
        <p class="tas-kick"><span class="tas-kick__ref">04</span>Agent anatomy · the stack</p>
        <h2 class="h2" id="anatomy-t"><span class="g">What a production agent</span> is actually made of.</h2>
      </div>
      <div class="tas-head__l">
        <p class="lead">A demo is a prompt and a model. A production agent is a loop with eight parts around it, each one replaceable, tested and watched. These are the technologies we work with for each part, chosen per client.</p>
      </div>
    </div>

    <div class="tas-an" data-tas-an data-phase="act" data-rv>
      <ul class="tas-an__col tas-an__col--l" role="list">
        <?php foreach ($tas_an_slots['left'] as $tas_s) { echo $tas_an_slot($tas_s, 'l'); } ?>
      </ul>

      <div class="tas-an__core">
        <p class="tas-an__trace" aria-hidden="true"><span class="tas-an__tk"><i class="tas-led tas-led--pulse"></i>trace · run_7f3a21</span><span class="tas-an__ro" data-an-ro><?= e($tas_an_phases[1][3]) ?></span></p>
        <div class="tas-an__loop" aria-hidden="true">
          <svg viewBox="-40 -12 400 344" focusable="false">
            <circle class="tas-an__ring" cx="160" cy="160" r="128"/>
            <circle class="tas-an__ring tas-an__ring--in" cx="160" cy="160" r="96"/>
            <!-- three arcs, 110° each with 10° gaps; plan from top, then act, then observe -->
            <path class="tas-an__arc" data-p="plan"    d="M 173.4 32.7 A 128 128 0 0 1 270.9 224"/>
            <path class="tas-an__arc" data-p="act"     d="M 259.2 240.4 A 128 128 0 0 1 60.8 240.4"/>
            <path class="tas-an__arc" data-p="observe" d="M 49.1 224 A 128 128 0 0 1 146.6 32.7"/>
            <path class="tas-an__head" data-p="plan"    d="M 262.6 219.2 L 270.9 224 L 272.6 214.5"/>
            <path class="tas-an__head" data-p="act"     d="M 70.2 243.9 L 60.8 240.4 L 64.6 231.3"/>
            <path class="tas-an__head" data-p="observe" d="M 137.4 29.6 L 146.6 32.7 L 139.3 39.5"/>
            <g class="tas-an__orbit"><circle cx="160" cy="32" r="6"/></g>
            <text class="tas-an__pl" x="290" y="86">PLAN</text>
            <text class="tas-an__pl" x="160" y="318" text-anchor="middle">ACT</text>
            <text class="tas-an__pl" x="30" y="86" text-anchor="end">OBSERVE</text>
          </svg>
          <div class="tas-an__mid">
            <span class="tas-an__agent"><?= xt_icon('network', ['size' => 26]) ?></span>
            <b>Agent loop</b>
            <span class="tas-an__ph" data-an-ph>Act</span>
          </div>
        </div>
        <p class="bdh-sr">A diagram of an agent loop: plan, act, observe, repeated until the task is done. Around it sit eight parts: models, orchestration, memory and knowledge, and identity and permissions on one side; tools and APIs, guardrails, evals and observability on the other. Each part lists the technologies used for it.</p>
        <div class="tas-an__legend" role="group" aria-label="Loop phase">
          <?php foreach ($tas_an_phases as $tas_p): ?>
            <button type="button" class="tas-an__lg" data-p="<?= e($tas_p[0]) ?>" data-ro="<?= e($tas_p[3]) ?>" aria-pressed="<?= $tas_p[0] === 'act' ? 'true' : 'false' ?>"><b><?= e($tas_p[1]) ?></b><span><?= e($tas_p[2]) ?></span></button>
          <?php endforeach; ?>
        </div>
      </div>

      <ul class="tas-an__col tas-an__col--r" role="list">
        <?php foreach ($tas_an_slots['right'] as $tas_s) { echo $tas_an_slot($tas_s, 'r'); } ?>
      </ul>
    </div>

    <ul class="tas-an__facts" data-rv-s data-rv-step="80">
      <?php foreach ($tas_an_facts as $tas_f): ?>
        <li><?= xt_icon($tas_f[0], ['size' => 22]) ?><div><h3><?= e($tas_f[1]) ?></h3><p><?= e($tas_f[2]) ?></p></div></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
