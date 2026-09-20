<?php /* DRAFT COPY — review before launch */
/* 04.6 Stack — the pipeline stage by stage. Five columns (Ingest & parse · Embed & index · Retrieve & rank ·
   Generate & guard · Evaluate & observe), each with its job, the reason it exists, the technologies we reach
   for first and a mono readout. Technologies with a licence-clean mark are listed first as logo rows; tools
   with no mark follow as one mono "Also" row, so the two treatments never alternate. Generate & guard adds
   the voice pipeline (speech-to-text and text-to-speech engines). A packet travels the rail above the
   columns while the section is on screen, lighting each stage in turn. The "Self-hosted only" switch dims
   hosted-API tools and swaps the readouts to the in-your-VPC configuration. Under 700 px a stage picker shows
   one stage at a time. Logos are technologies we work with; no partnership is implied. */
$taps_stages = [   // [n, key, name, short, icon, why, logos: [[slug, host, ?label]], also: [[name, host]], readout api, readout self, voice: [[name, host]]]
    ['01', 'ingest', 'Ingest & parse', 'Ingest', 'doc',
        'Documents, tickets, tables and scans become clean text with metadata: source, version, owner and who may read it. Bad parsing is the most common reason a RAG answer is wrong.',
        [['python', 'both'], ['apacheairflow', 'both'], ['airbyte', 'both'], ['apachekafka', 'both'], ['postgresql', 'both']],
        [['Unstructured', 'self']],
        '1,284 docs · 18,402 chunks · 300–500 tokens', '1,284 docs · parsed in your cluster', []],
    ['02', 'embed', 'Embed & index', 'Embed', 'vector',
        'Each chunk is embedded and stored beside a keyword index and its permissions, so retrieval can mix meaning and exact terms and never return what a user could not open.',
        [['postgresql', 'both', 'PostgreSQL + pgvector'], ['qdrant', 'both'], ['elasticsearch', 'both'], ['milvus', 'both'], ['huggingface', 'both']],
        [['Weaviate', 'both'], ['Pinecone', 'api']],
        '1,024-d · HNSW · nightly re-index', '1,024-d · open embedding model · your VPC', []],
    ['03', 'retrieve', 'Retrieve & rank', 'Retrieve', 'search',
        'Hybrid BM25 plus vector search fetches twenty candidates; a cross-encoder reranks them and keeps the three that matter. Less context, better answers, lower cost.',
        [['langchain', 'both'], ['elasticsearch', 'both'], ['redis', 'both']],
        [['LlamaIndex', 'both'], ['Cohere Rerank', 'api']],
        'hybrid · top 20 → rerank 3 · 41 ms', 'hybrid · open reranker · top 20 → 3', []],
    ['04', 'generate', 'Generate & guard', 'Generate', 'sparkle',
        'A router picks the model per request: small for classification, larger for drafting and reasoning. Guardrails check inputs for injection and outputs for schema, citations and personal data.',
        [['anthropic', 'api'], ['googlegemini', 'api'], ['mistralai', 'both'], ['meta', 'self', 'Meta Llama'], ['deepseek', 'both'], ['vllm', 'self'], ['langgraph', 'both']],
        [['OpenAI', 'api'], ['Guardrails', 'self']],
        'routed · hosted APIs · p95 1.8 s · streamed', 'routed · vLLM on your GPUs · p95 2.4 s',
        [['Whisper (open weights)', 'both'], ['Deepgram', 'api'], ['ElevenLabs', 'api'], ['Azure AI Speech', 'api']]],
    ['05', 'evaluate', 'Evaluate & observe', 'Evaluate', 'eval',
        'Every release runs the golden set in CI; every production answer is traced with its model version, retrieved chunks, cost and latency, and a daily sample is scored.',
        [['mlflow', 'both'], ['opentelemetry', 'both'], ['grafana', 'both'], ['prometheus', 'both'], ['githubactions', 'both']],
        [['Ragas', 'self'], ['Langfuse', 'both']],
        '24 gates in CI · daily sample of 200', '24 gates in CI · traces stay in your VPC', []],
];
$taps_host = ['api' => 'hosted API', 'self' => 'self-hosted', 'both' => 'either'];
$taps_notes = [
    ['git-branch', 'Model-agnostic by design', 'The parser, embedder, retriever, model and judge sit behind thin adapters we own. Swapping one is a configuration change followed by an eval run, not a rebuild. New models ship monthly; your feature can take them the same week.'],
    ['lock',       'Open weights when data must stay', 'For regulated data or residency rules, Llama, Mistral or DeepSeek weights are served with vLLM on GPUs in your VPC or an India-region data centre. Nothing leaves your network, and the eval bar is the same.'],
    ['cost',       'Chosen on the numbers', 'Each candidate stack is scored on your golden set for quality, p95 latency and cost per answer before it is chosen. The table is yours to keep, and it is re-run when a new option appears.'],
];
?>
<section class="band tap-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="tap-head" data-rv>
      <div>
        <p class="tap-eb"><span class="tap-eb__box" aria-hidden="true"></span><span class="tap-eb__n">04.6</span><span>The stack</span><span class="tap-eb__p">/stack</span></p>
        <h2 class="h2" id="stack-t"><span class="g">The stack, stage by stage.</span> Swap any part without rebuilding the rest.</h2>
      </div>
      <div>
        <p class="lead">Five stages, each with a job, a reason and the technologies we reach for first. Nothing here is a lock-in: the interfaces between stages are ours, so a model, an index or a parser can be replaced when a better one ships.</p>
      </div>
    </div>

    <div class="tap-stk tap-diagram" data-rv>
      <div class="tap-win__bar tap-stk__bar">
        <span class="tap-win__path"><b>pipeline</b> · knowledge-assistant · v24 · <span data-stk-mode>hosted + self-hosted</span></span>
        <span class="tap-win__end">
          <button type="button" class="bdh-switch tap-stk__sw" data-stk-self aria-pressed="false"><span class="bdh-switch__track" aria-hidden="true"></span>Self-hosted only</button>
        </span>
      </div>

      <div class="tap-stk__rail" aria-hidden="true">
        <?php foreach ($taps_stages as $taps_i => $taps_s): ?><span class="tap-stk__node" style="--i:<?= $taps_i ?>"><i></i></span><?php endforeach; ?>
        <span class="tap-stk__pk" style="--s:0"><i></i></span>
      </div>

      <div class="tap-stk__pick" role="group" aria-label="Stage shown">
        <?php foreach ($taps_stages as $taps_i => $taps_s): ?>
          <button type="button" data-stk-pick="<?= $taps_i ?>" aria-controls="stk-<?= e($taps_s[1]) ?>" aria-pressed="<?= $taps_i === 0 ? 'true' : 'false' ?>"><b><?= e($taps_s[0]) ?></b><?= e($taps_s[3]) ?></button>
        <?php endforeach; ?>
      </div>

      <ol class="tap-stk__cols" role="list">
        <?php foreach ($taps_stages as $taps_i => $taps_s): ?>
          <li class="tap-stk__col<?= $taps_i === 0 ? ' is-sel' : '' ?>" id="stk-<?= e($taps_s[1]) ?>" data-stage="<?= e($taps_s[1]) ?>" style="--i:<?= $taps_i ?>">
            <header class="tap-stk__ch">
              <span class="tap-stk__n"><?= e($taps_s[0]) ?></span>
              <span class="tap-stk__ico"><?= xt_icon($taps_s[4], ['size' => 20]) ?></span>
            </header>
            <h3 class="tap-stk__t"><?= e($taps_s[2]) ?></h3>
            <p class="tap-stk__why"><?= e($taps_s[5]) ?></p>
            <p class="tap-stk__k">We work with</p>
            <ul class="tap-stk__tools" role="list" aria-label="<?= e($taps_s[2]) ?> technologies">
              <?php foreach ($taps_s[6] as $taps_j => $taps_tool): ?>
                <li data-host="<?= e($taps_tool[1]) ?>" style="--j:<?= $taps_j ?>">
                  <span class="xt-lg"><?= xt_logo($taps_tool[0], ['size' => 18, 'hidden' => true]) ?><span class="xt-lg__n"><?= e($taps_tool[2] ?? (xt_tech($taps_tool[0])['name'] ?? $taps_tool[0])) ?></span></span>
                  <i class="tap-stk__host"><?= e($taps_host[$taps_tool[1]]) ?></i>
                </li>
              <?php endforeach; ?>
            </ul>
            <?php if ($taps_s[7]): ?>
              <p class="tap-stk__also"><span class="tap-stk__alk">Also</span><?php foreach ($taps_s[7] as $taps_w): ?><span class="tap-stk__wd" data-host="<?= e($taps_w[1]) ?>"><?= e($taps_w[0]) ?></span><?php endforeach; ?></p>
            <?php endif; ?>
            <?php if ($taps_s[10]): ?>
              <p class="tap-stk__k tap-stk__k--voice"><?= xt_icon('voice', ['size' => 14, 'mono' => true]) ?>Voice in and out</p>
              <p class="tap-stk__also tap-stk__voice"><?php foreach ($taps_s[10] as $taps_w): ?><span class="tap-stk__wd" data-host="<?= e($taps_w[1]) ?>"><?= e($taps_w[0]) ?></span><?php endforeach; ?></p>
            <?php endif; ?>
            <p class="tap-stk__ro"><span data-stk-api><?= e($taps_s[8]) ?></span><span data-stk-selfro hidden><?= e($taps_s[9]) ?></span></p>
          </li>
        <?php endforeach; ?>
      </ol>
      <p class="bdh-sr" aria-live="polite" data-stk-live></p>
    </div>

    <div class="tap-stk__notes" data-rv-s>
      <?php foreach ($taps_notes as $taps_n): ?>
        <article class="tap-stk__note">
          <p class="tap-stk__nk"><?= xt_icon($taps_n[0], ['size' => 20]) ?></p>
          <h3 class="tap-stk__nt"><?= e($taps_n[1]) ?></h3>
          <p class="tap-stk__nd"><?= e($taps_n[2]) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
