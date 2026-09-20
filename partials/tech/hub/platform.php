<?php /* DRAFT COPY — review before launch */
/* Platform — ten capabilities, one architecture. Three stacked layers (Experience, Intelligence, Platform &
   data) with Trust & operations as a rail that touches every layer. Layer toggles isolate a layer and list the
   capability pages that build it. One request is traced through the system: platform.js moves a packet from
   component to component and lights the matching step. The HTML is the complete, readable state. */
$pf_url = fn (string $pf_slug): string => xe_url('services/technology-intelligence/' . $pf_slug . '.php');
$pf_rows = [
    // layer key => components: [id, name, sub, caps, logos, icon fallback]
    'experience' => [
        ['web',     'Website & web app',     'edge-rendered',            ['01'],       ['nextdotjs', 'react'], ''],
        ['mobile',  'Mobile app',            'iOS · Android',            ['01'],       ['flutter', 'swift'], ''],
        ['chat',    'Support chat',          'streams the answer',       ['01', '04'], [], 'chat'],
        ['answers', 'Search & AI answers',   'ranked · cited',           ['08'],       ['google', 'perplexity'], ''],
    ],
    'intelligence' => [
        ['agent',   'Support agent',         'tools · human handoff',    ['03', '04'], ['langgraph'], ''],
        ['rag',     'Retrieval (RAG)',       'hybrid search · rerank',   ['04'],       ['qdrant'], ''],
        ['auto',    'Workflow automation',   'refunds · tickets',        ['04'],       ['n8n', 'temporal'], ''],
        ['evals',   'Evals',                 'golden set on every change', ['04'],     [], 'eval'],
    ],
    'platform' => [
        ['apps',    'Custom apps & CRM',     'typed APIs',               ['02'],       ['postgresql'], ''],
        ['cdp',     'Customer data',         'profiles · consent',       ['02'],       ['snowflake'], ''],
        ['bus',     'Integration bus',       'events · APIs',            ['07'],       ['apachekafka', 'kong'], ''],
        ['gw',      'AI gateway',            'route · cache · cost caps', ['05'],      ['anthropic', 'googlegemini', 'mistralai'], ''],
        ['compute', 'GPU & serverless',      'autoscaled',               ['05'],       ['kubernetes', 'nvidia'], ''],
    ],
];
$pf_rail = [
    ['guard', 'Security & guardrails', 'OWASP LLM · SSO · secrets', ['06'],       ['okta', 'vault'], ''],
    ['obs',   'Observability',         'traces · SLOs',             ['05', '07'], ['opentelemetry', 'grafana'], ''],
    ['audit', 'Audits',                'monthly trace samples',     ['09'],       [], 'clipboard-check'],
    ['squad', 'On-call squad',         'runbooks · rotation',       ['10'],       ['pagerduty'], ''],
];
$pf_links = [
    'experience'   => 'HTTPS · server-sent events',
    'intelligence' => 'tool calls · model API · gRPC',
];
$pf_trace = [
    // [step text, hops (component ids), readout]
    ['A customer asks the support assistant on the website.',                         ['web', 'chat', 'agent'], '0 ms'],
    ['The AI gateway routes the question to a small model first.',                    ['gw'], '38 ms'],
    ['Retrieval reads the customer profile from the CDP through the integration bus.', ['rag', 'bus', 'cdp'], '96 ms'],
    ['Guardrails check the draft answer before it leaves.',                           ['guard'], '131 ms'],
    ['The answer streams back and the trace lands in observability.',                 ['agent', 'chat', 'web', 'obs'], '212 ms'],
    ['Audits sample traces like this one every month.',                               ['audit'], 'sampled'],
    ['The squad on call owns it when anything drifts.',                               ['squad'], 'owned'],
];
$pf_comp = function (array $pf_c, int $pf_i): string {
    $pf_marks = '';
    foreach ($pf_c[4] as $pf_l) { $pf_marks .= xt_logo($pf_l, ['size' => 15, 'hidden' => true]); }
    if ($pf_marks === '' && $pf_c[5] !== '') { $pf_marks = xt_icon($pf_c[5], ['size' => 16, 'mono' => true]); }
    return '<li class="tih-pf__box bdh-up" data-hop="' . e($pf_c[0]) . '" style="--i:' . $pf_i . '">'
         . '<span class="tih-pf__bt"><span class="tih-pf__bn">' . e($pf_c[1]) . '</span><span class="tih-pf__bc">' . e(implode('·', $pf_c[3])) . '</span></span>'
         . '<span class="tih-pf__bs">' . e($pf_c[2]) . '</span>'
         . '<span class="tih-pf__bl" aria-hidden="true">' . $pf_marks . '</span></li>';
};
$pf_names = ['all' => 'All layers'] + array_map(fn ($pf_l) => $pf_l['name'], $TIH['layers']);
?>
<section class="band band--ink tih-platform" id="platform" aria-labelledby="platform-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The platform</p>
        <h2 class="h2" id="platform-t"><span class="g">One architecture.</span> Four layers that hold it.</h2>
      </div>
      <div>
        <p class="lead">Every capability builds a layer of the same system. Pick a layer to see who builds it, or follow one customer question through all four.</p>
      </div>
    </div>

    <div class="tih-pf" data-layer="all">
      <div class="tih-pf__bar" data-rv>
        <div class="bdh-seg tih-pf__seg" role="group" aria-label="Show a layer">
          <?php foreach ($pf_names as $pf_k => $pf_n): ?>
            <button type="button" data-layer="<?= e($pf_k) ?>" aria-pressed="<?= $pf_k === 'all' ? 'true' : 'false' ?>" aria-controls="platform-builds"><?= e($pf_n) ?></button>
          <?php endforeach; ?>
        </div>
        <span class="tih-pf__tr" aria-hidden="true"><i class="bdh-pulse"></i>trace 7f3a9c · support.answer</span>
      </div>

      <p class="bdh-sr">An architecture diagram in four layers. Experience: website and web app, mobile app, support chat, search and AI answers. Intelligence: support agent, retrieval, workflow automation, evals. Platform and data: custom apps and CRM, customer data, integration bus, AI gateway, GPU and serverless compute. Trust and operations runs alongside every layer: security and guardrails, observability, audits and the on-call squad. The steps below trace one request through it.</p>

      <div class="tih-pf__arch dots-ink" aria-hidden="true" data-bdh-in>
        <div class="tih-pf__main">
          <?php $pf_li = 0; $pf_total = count($pf_rows); foreach ($pf_rows as $pf_lk => $pf_comps): $pf_layer = $TIH['layers'][$pf_lk]; ?>
            <div class="tih-pf__layer" data-layer="<?= e($pf_lk) ?>" style="--i:<?= $pf_total - $pf_li ?>">
              <p class="tih-pf__lh"><b><?= e($pf_layer['code']) ?></b><span><?= e($pf_layer['name']) ?></span><small><?= e(implode(' · ', array_map(fn ($pf_s) => $TI[$pf_s]['n'], $pf_layer['caps']))) ?></small></p>
              <ul class="tih-pf__boxes tih-pf__boxes--<?= count($pf_comps) ?>">
                <?php foreach ($pf_comps as $pf_ci => $pf_c) { echo $pf_comp($pf_c, ($pf_total - $pf_li) * 2 + $pf_ci); } ?>
              </ul>
            </div>
            <?php if (isset($pf_links[$pf_lk])): ?>
              <div class="tih-pf__link"><i></i><span><?= e($pf_links[$pf_lk]) ?></span><i></i></div>
            <?php endif; ?>
          <?php $pf_li++; endforeach; ?>
        </div>

        <div class="tih-pf__rail tih-pf__layer" data-layer="trust" style="--i:0">
          <p class="tih-pf__lh"><b><?= e($TIH['layers']['trust']['code']) ?></b><span><?= e($TIH['layers']['trust']['name']) ?></span><small><?= e(implode(' · ', array_map(fn ($pf_s) => $TI[$pf_s]['n'], $TIH['layers']['trust']['caps']))) ?></small></p>
          <ul class="tih-pf__boxes tih-pf__boxes--rail">
            <?php foreach ($pf_rail as $pf_ci => $pf_c) { echo $pf_comp($pf_c, 1 + $pf_ci); } ?>
          </ul>
          <span class="tih-pf__touch"><i></i><i></i><i></i></span>
        </div>

        <span class="tih-pf__pk"><i></i></span>
        <span class="tih-pf__label">7f3a9c · <b>0 ms</b></span>
      </div>

      <div class="tih-pf__below">
        <div class="tih-pf__builds" id="platform-builds" aria-live="polite">
          <div class="bdh-panes">
            <div class="bdh-pane is-on" data-pane="all">
              <p class="tih-k">Builds the whole platform</p>
              <h3 class="bdh-t bdh-t--l tih-pf__bh">Ten capability pages, four layers</h3>
              <div class="tih-pf__groups">
                <?php foreach ($TIH['layers'] as $pf_lk => $pf_l): ?>
                  <div class="tih-pf__group">
                    <p class="tih-pf__gl"><?= e($pf_l['code']) ?> · <?= e($pf_l['name']) ?></p>
                    <p class="tih-pf__chips"><?php foreach ($pf_l['caps'] as $pf_s): ?><a class="tih-capl" href="<?= $pf_url($pf_s) ?>"><b><?= e($TI[$pf_s]['n']) ?></b><?= e($TI[$pf_s]['short']) ?><i aria-hidden="true">›</i></a><?php endforeach; ?></p>
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="tih-pf__core">
                <div><p class="tih-pf__gl">Platform core we default to</p><?= xt_stack(['kubernetes', 'terraform', 'postgresql', 'apachekafka', 'opentelemetry'], ['size' => 16, 'label' => 'Platform core technologies']) ?></div>
                <div><p class="tih-pf__gl">Model layer · behind the gateway, swappable</p><?= xt_stack(['openai', 'anthropic', 'googlegemini', 'meta', 'mistralai'], ['size' => 16, 'label' => 'Model providers behind the AI gateway']) ?></div>
              </div>
            </div>
            <?php foreach ($TIH['layers'] as $pf_lk => $pf_l): ?>
              <div class="bdh-pane" data-pane="<?= e($pf_lk) ?>">
                <p class="tih-k"><?= e($pf_l['code']) ?> · built by <?= count($pf_l['caps']) ?> capabilities</p>
                <h3 class="bdh-t bdh-t--l tih-pf__bh"><?= e($pf_l['name']) ?></h3>
                <p class="bdh-d tih-pf__bd"><?= e($pf_l['line']) ?></p>
                <ul class="tih-pf__caps">
                  <?php foreach ($pf_l['caps'] as $pf_s): $pf_cap = $TI[$pf_s]; ?>
                    <li>
                      <a class="tih-pf__cap" href="<?= $pf_url($pf_s) ?>">
                        <span class="tih-pf__cn"><?= e($pf_cap['n']) ?></span>
                        <span class="tih-pf__ci" aria-hidden="true"><?= xt_icon($pf_cap['icon'], ['size' => 20]) ?></span>
                        <span class="tih-pf__ct"><?= e($pf_cap['name']) ?></span>
                        <span class="tih-pf__ck"><?= e($pf_cap['kicker']) ?></span>
                        <i aria-hidden="true">›</i>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="tih-pf__steps">
          <p class="tih-k">One request, traced <span class="bdh-ill">Illustrative</span></p>
          <ol class="tih-pf__ol">
            <?php foreach ($pf_trace as $pf_ti => $pf_t): ?>
              <li class="tih-pf__step" data-step="<?= $pf_ti ?>" data-hops="<?= e(implode(' ', $pf_t[1])) ?>" data-ro="<?= e($pf_t[2]) ?>">
                <span class="tih-pf__sn"><?= str_pad((string) ($pf_ti + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <span class="tih-pf__st"><?= e($pf_t[0]) ?></span>
                <span class="tih-pf__sr"><?= e($pf_t[2]) ?></span>
              </li>
            <?php endforeach; ?>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>
