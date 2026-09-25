<?php /* DRAFT COPY — review before launch */
/* Stack — the platforms this discipline actually works on, grouped by the job they do here rather than
   by vendor category. Every slug below exists in data/tech-stack.php; the generative media tools named
   in the approved copy that have no licence-clean mark in that manifest are set in type in their own
   block instead, and are never given an invented logo.
 *
 * Framing: technologies we work with. Never a partnership, a reseller tier or a certification.
 */
$sk_groups = [
    ['Model providers',                 'Chosen per task on your own evaluation set, and swapped when a better or cheaper one earns it.',
     ['googlegemini', 'openai', 'anthropic', 'mistralai', 'meta', 'deepseek', 'ollama', 'perplexity']],
    ['Generation & serving',            'Where a model actually runs: hosted, on demand, or inside your own cloud account.',
     ['replicate', 'modal', 'huggingface', 'cloudflare', 'vercel']],
    ['Tuning, inference & scoring',     'Adapters and fine-tunes, the scoring runs behind a release, and the inference that serves them.',
     ['pytorch', 'huggingface', 'mlflow', 'vllm', 'nvidia', 'onnx', 'python']],
    ['Agents, retrieval & orchestration','Plans, tool calls and the retrieval that lets an answer carry a source.',
     ['langgraph', 'langchain', 'llamaindex', 'pgvector', 'qdrant']],
    ['Design, build & test',            'Where the interface is designed, documented, built and checked, including the accessibility passes.',
     ['figma', 'storybook', 'react', 'nextdotjs', 'typescript', 'playwright', 'github']],
    ['Pipeline, content & delivery',    'Briefs in, assets out: automation, content systems and delivery into the places you publish.',
     ['n8n', 'contentful', 'sanity', 'shopify', 'hubspot']],
    ['Measurement & working together',  'What the experience does after launch, and how the work is run with your team.',
     ['posthog', 'mixpanel', 'opentelemetry', 'googleanalytics', 'miro', 'notion', 'slack', 'microsoftteams', 'jira']],
];
/* the marquee: one line of the marks people look for first */
$sk_row = ['googlegemini', 'openai', 'anthropic', 'mistralai', 'meta', 'huggingface', 'pytorch', 'replicate', 'modal',
           'nvidia', 'vllm', 'mlflow', 'langgraph', 'llamaindex', 'figma', 'storybook', 'nextdotjs', 'playwright'];
/* named in the approved copy, central to the work, and with no licence-clean mark in data/tech-stack.php */
$sk_named = ['Flux', 'Adobe Firefly', 'Midjourney', 'Runway', 'Veo', 'ElevenLabs', 'ComfyUI'];
?>
<section class="band band--alt aih-sk" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Platforms</p>
        <h2 class="h2" id="stack-t"><span class="g">Grouped by the job it does,</span> not by the vendor who sells it.</h2>
      </div>
      <div>
        <p class="lead">Nothing here is a partnership tier. These are the platforms this discipline works on, and the choice inside each group is made per task and re-tested when something better ships. Your weights, prompts, datasets and logs stay in your own accounts.</p>
        <p class="aih-note">Technologies we work with. Standards we build to are the next section.</p>
      </div>
    </div>

    <div class="aih-sk__row" data-rv data-rv-d="40">
      <?= xt_stack($sk_row, ['variant' => 'row', 'marquee' => true, 'speed' => 74, 'size' => 22, 'label' => 'Technologies we work with across AI Design']) ?>
    </div>

    <div class="aih-sk__groups">
      <?php foreach ($sk_groups as $sk_i => $sk_g): ?>
        <div class="aih-sk__g" data-rv data-rv-d="<?= 40 + $sk_i * 10 ?>">
          <div class="aih-sk__gh">
            <span class="bdh-idx"><?= str_pad((string) ($sk_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="aih-sk__gt"><?= e($sk_g[0]) ?></h3>
            <p class="aih-sk__gd"><?= e($sk_g[1]) ?></p>
          </div>
          <?= xt_stack($sk_g[2], ['variant' => 'chips', 'size' => 18, 'label' => $sk_g[0] . ' we work with']) ?>
        </div>
      <?php endforeach; ?>

      <div class="aih-sk__g aih-sk__g--named" data-rv data-rv-d="110">
        <div class="aih-sk__gh">
          <span class="bdh-idx">08</span>
          <h3 class="aih-sk__gt">Generative media tools</h3>
          <p class="aih-sk__gd">Central to this discipline, and set in type rather than in a mark: the site’s logo library only carries marks we can use under a clear licence. They are tools we work with, on the same footing as everything above.</p>
        </div>
        <div class="aih-marks">
          <?php foreach ($sk_named as $sk_n): ?><span class="aih-mark"><?= e($sk_n) ?></span><?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
