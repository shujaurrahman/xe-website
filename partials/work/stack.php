<?php /* DRAFT COPY — review before launch */
/* Stack — what the programmes in the index were built with, and the frameworks delivery was built
   to. Technologies are shown as technologies we work with, never as a partnership tier; standards
   are frameworks the work was built to, never certifications held. The standards row is collected
   from data/work.php, so it lists only what the programmes above actually name. */
$STACK = require __DIR__ . '/../../data/tech-stack.php';

$wrk_std = [];
foreach ($wrk_cases as $wrk_c) foreach (($wrk_c['standards'] ?? []) as $wrk_s) $wrk_std[$wrk_s] = ($wrk_std[$wrk_s] ?? 0) + 1;
arsort($wrk_std);

$wrk_lanes = [
    ['Experience', 'What a customer touches', ['figma', 'react', 'nextdotjs', 'tailwindcss', 'flutter', 'storybook', 'webflow']],
    ['Platform',   'What the business runs on', ['typescript', 'python', 'postgresql', 'apachekafka', 'redis', 'docker', 'kubernetes', 'terraform']],
    ['Intelligence', 'What makes it think',    ['openai', 'anthropic', 'huggingface', 'langgraph', 'pgvector', 'mlflow', 'pytorch']],
    ['Go-to-market', 'What reaches a customer', ['salesforce', 'hubspot', 'contentful', 'shopify', 'posthog', 'googleanalytics', 'twilio']],
    ['Trust & run',  'What keeps it honest',    ['opentelemetry', 'grafana', 'sentry', 'playwright', 'vault', 'snyk', 'pagerduty']],
];
?>
<section class="band band--alt wrk-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What it was built with</p>
        <h2 class="h2" id="stack-t"><span class="g">Your stack,</span> not ours.</h2>
      </div>
      <div>
        <p class="lead">Every programme above was built inside the client’s own accounts, with tools they could keep. These are the technologies we work with across the five lanes a programme usually touches — not a partner list, and not a fixed menu.</p>
      </div>
    </div>

    <div class="wrk-stack__lanes" data-bdh-stagger data-bdh-in>
      <?php foreach ($wrk_lanes as $wrk_i => $wrk_l): ?>
      <div class="wrk-lane bdh-up">
        <p class="wrk-lane__h"><span class="bdh-idx"><?= wrk_n($wrk_i + 1) ?></span><b><?= e($wrk_l[0]) ?></b><span class="wrk-lane__d"><?= e($wrk_l[1]) ?></span></p>
        <?= xt_stack($wrk_l[2], ['variant' => 'chips', 'size' => 16, 'label' => $wrk_l[0] . ' — technologies we work with', 'class' => 'wrk-lane__s']) ?>
      </div>
      <?php endforeach; ?>
    </div>

    <?php if ($wrk_std): ?>
    <div class="wrk-stack__std" data-rv data-rv-d="80">
      <div class="wrk-stack__stdh">
        <p class="bdh-ro">Frameworks the work was built to</p>
        <p class="wrk-stack__stdn">Collected from the <?= count($wrk_cases) ?> programmes on this page — each one names the frameworks its delivery was built and audited against. None of them is a certification Xterra Edze holds.</p>
      </div>
      <ul class="wrk-stack__badges" role="list" aria-label="Frameworks named by the programmes on this page">
        <?php foreach ($wrk_std as $wrk_k => $wrk_n2) { echo xt_badge($wrk_k, ['variant' => 'chip', 'tag' => 'li']); } ?>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</section>
