<?php /* DRAFT COPY — review before launch */
/* Stack — the technologies this discipline works with, by layer (xt_stack chips). Tools without a mark in
   data/tech-stack.php are listed as words. Technologies we work with; no partnership is implied. */
$aih_layers = [
    ['brain',    'Models',                'Chosen per task on the evaluation set.',              ['openai', 'anthropic', 'googlegemini', 'mistralai', 'meta', 'huggingface'], []],
    ['sparkle',  'Generation & tuning',   'Image, film and voice, and the models we tune.',       ['pytorch', 'replicate', 'modal', 'vllm', 'onnx', 'nvidia', 'mlflow'], ['Flux', 'Adobe Firefly', 'ComfyUI', 'Runway', 'Veo', 'ElevenLabs']],
    ['workflow', 'Build & orchestration', 'Agents, pipelines and the product around the model.',  ['langgraph', 'llamaindex', 'python', 'typescript', 'react', 'nextdotjs', 'playwright', 'vercel', 'cloudflare', 'n8n'], []],
    ['layers',   'Design & content ops',  'Where the work is designed, stored and measured.',     ['figma', 'storybook', 'contentful', 'sanity', 'notion', 'miro', 'posthog', 'github'], []],
];
?>
<section class="band aih-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Platform stack</p>
        <h2 class="h2" id="stack-t"><span class="g">Model-agnostic</span> by design, not by slogan.</h2>
      </div>
      <div><p class="lead">The technologies we work with, by layer. Changing a model is a configuration decision, because the prompts, evaluation sets and guardrails around it stay yours.</p></div>
    </div>
    <div class="aih-lyr">
      <?php foreach ($aih_layers as $aih_i => $aih_ly): ?>
        <div class="aih-lyr__i">
          <div class="aih-lyr__h">
            <span class="aih-lyr__ic"><?= xt_icon($aih_ly[0]) ?></span>
            <div><p class="aih-lyr__n">L<?= $aih_i + 1 ?></p><h3 class="aih-lyr__t"><?= e($aih_ly[1]) ?></h3></div>
          </div>
          <p class="aih-lyr__d"><?= e($aih_ly[2]) ?></p>
          <?= xt_stack($aih_ly[3], ['variant' => 'chips', 'label' => $aih_ly[1] . ' technologies']) ?>
          <?php if ($aih_ly[4]): ?>
            <ul class="aih-lyr__w" aria-label="Also in this layer">
              <?php foreach ($aih_ly[4] as $aih_w): ?><li><?= e($aih_w) ?></li><?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
