<?php /* DRAFT COPY — review before launch */
/* 06 Stack — the stack as a rack cross-section. An ink rack holds eight units, top (security) to bottom
   (accelerators). Each unit is a vertical tab: choosing one slides it out of the rack like a server tray and opens
   its tray on the right: what the layer does, the technologies we work with there, the decisions made at that
   layer and a live readout. Below: a hardware photograph and the India regions used for data residency.
   HTML = U04 Serving open; stack.js wires BDH.tabs (vertical, arrow keys) and a slow auto-cycle until touched.
   Readouts are illustrative. Logos are "technologies we work with", never a partner tier. */
$tic_rk_units = [   // [u, key, name, logos (library slugs), extra chips (no library mark), readout, what it does, decisions]
    ['08', 'sec', 'Security & policy', ['vault', 'trivy', 'falco', 'snyk'], ['OPA Gatekeeper', 'Kyverno'], '0 critical CVEs',
     'Secrets never live in code or images: Vault or the cloud KMS issues short-lived credentials to each workload. Images are scanned in CI, runtime behaviour is watched, and admission policies refuse a pod that runs as root or pulls an unsigned image.',
     ['Workload identity instead of static keys', 'Signed images only in production namespaces', 'Model weights, prompts and logs treated as sensitive data']],
    ['07', 'obs', 'Observability & FinOps', ['opentelemetry', 'prometheus', 'grafana', 'datadog', 'pagerduty'], ['OpenCost'], '14 SLO alerts',
     'One OpenTelemetry pipeline carries traces, metrics and logs from the gateway down to the GPU. Token counts, cache hits and cost tags ride on every span, so a slow or expensive request traces back to the feature, team and model behind it.',
     ['GenAI semantic conventions on every model call', 'Burn-rate alerts instead of threshold noise', 'Spend allocated per team and feature, daily']],
    ['06', 'gw', 'Gateway & routing', ['kong', 'cloudflare', 'redis'], ['LiteLLM', 'Envoy AI Gateway'], '31% cache hits',
     'The seam every model call passes through: authentication, quotas, routing by cost and data class, fallback between providers, prompt and semantic caching, and token budgets per team. Its configuration is code, versioned with the platform.',
     ['Which data classes may leave the country', 'Fallback order and timeouts per route', 'Cache lifetimes and similarity thresholds']],
    ['05', 'data', 'Data & vectors', ['qdrant', 'postgresql', 'milvus', 'apachekafka'], ['pgvector'], '12.4M vectors',
     'Retrieval quality is an infrastructure problem too: vector indexes sized for recall inside the latency budget, embeddings versioned with the model that made them, and change streams that keep the index minutes behind the source, not weeks.',
     ['Index parameters tuned against recall@10', 'Re-embed only what changed', 'Tenant isolation inside the index']],
    ['04', 'srv', 'Model serving', ['vllm', 'nvidia', 'huggingface', 'ray'], ['SGLang', 'Triton'], '3 models live',
     'Open-weight models run on vLLM or TensorRT-LLM behind an OpenAI-compatible API, so the router treats self-hosted and managed models the same way. Replicas scale on queue depth and time to first token, not on CPU.',
     ['Model, precision and context length per route', 'Prefix caching and batch limits', 'Autoscaling on vllm:num_requests_waiting']],
    ['03', 'orch', 'Orchestration & IaC', ['kubernetes', 'helm', 'terraform', 'argo', 'docker'], ['Karpenter', 'KEDA'], '6 node pools',
     'Kubernetes with dedicated GPU node pools, tainted so only inference pods land there. Terraform builds the cloud, Helm packages the workloads and Argo CD keeps every cluster equal to Git. Nothing in production is changed by hand.',
     ['GPU pools with a warm spare node', 'Scale to zero for dev and preview environments', 'Every change through a reviewed pull request']],
    ['02', 'cloud', 'Cloud & regions', ['amazonwebservices', 'microsoftazure', 'googlecloud', 'cloudflare'], [], '3 regions · 2 in India',
     'We build on the cloud you already buy, in the regions your data allows. A landing zone sets identity, networking, logging and guardrails once, so every new workload inherits them. Edge caching and a web application firewall sit in front.',
     ['Primary and standby regions', 'Commitments against on-demand and spot', 'Private networking to model providers where offered']],
    ['01', 'gpu', 'Accelerators', ['nvidia'], ['L4 · 24 GB', 'L40S · 48 GB', 'H100 · 80 GB', 'H200 · 141 GB', 'AWS Inferentia2', 'Google Cloud TPU'], '8 × L40S · 68%',
     'The smallest accelerator that holds the model and its KV cache at your target concurrency. An 8B model at FP8 serves well on an L4 or L40S; 70B-class models and long contexts need H100- or H200-class memory. Cloud-native silicon is benchmarked on your traffic before any commitment.',
     ['GPU class per model and context length', 'Reserved baseline, on-demand peaks, spot for batch', 'A 60–80% utilisation band on serving pools']],
];
$tic_rk_open = 4;   // index of U04 · Model serving
$tic_rk_regions = [   // [cloud slug, cloud, region name, location, region code]
    ['amazonwebservices', 'AWS', 'Asia Pacific (Mumbai)', 'Maharashtra', 'ap-south-1'],
    ['amazonwebservices', 'AWS', 'Asia Pacific (Hyderabad)', 'Telangana', 'ap-south-2'],
    ['microsoftazure', 'Microsoft Azure', 'Central India', 'Pune', 'centralindia'],
    ['microsoftazure', 'Microsoft Azure', 'South India', 'Chennai', 'southindia'],
    ['googlecloud', 'Google Cloud', 'Mumbai', 'Maharashtra', 'asia-south1'],
    ['googlecloud', 'Google Cloud', 'Delhi', 'Delhi NCR', 'asia-south2'],
];
$tic_rk_logos = fn (array $tic_rk_s): array => array_values(array_filter($tic_rk_s, fn ($tic_rk_x) => isset($STACK[$tic_rk_x])));
$tic_rk_has   = fn (string $tic_rk_s): bool => !empty($STACK[$tic_rk_s]['file']);   // a drawn mark exists (wordmark-only entries print their name instead)
$tic_rk_mark  = fn (string $tic_rk_s, int $tic_rk_z = 16): string => !empty($STACK[$tic_rk_s]['file']) ? xt_logo($tic_rk_s, ['size' => $tic_rk_z, 'hidden' => true]) : '<i class="tic-chip__dot" aria-hidden="true"></i>';

/* Each mark in this section appears up to three times — on the rack unit, on the tray chip and in the
   sprite-backed lists. Define every path once in a <defs> sprite and <use> it, which keeps the section's
   inline SVG under a tenth of what repeating the geometry costs. */
$tic_rk_sprite = [];
foreach ($tic_rk_units as $tic_rk_u) {
    foreach ($tic_rk_logos($tic_rk_u[3]) as $tic_rk_s) {
        if (!$tic_rk_has($tic_rk_s) || isset($tic_rk_sprite[$tic_rk_s])) continue;
        $tic_rk_b = xt__svg_body((string) $STACK[$tic_rk_s]['file']);
        if ($tic_rk_b) $tic_rk_sprite[$tic_rk_s] = $tic_rk_b;
    }
}
$tic_rk_use = function (string $tic_rk_s, int $tic_rk_z = 16) use (&$tic_rk_sprite, $tic_rk_mark): string {
    if (!isset($tic_rk_sprite[$tic_rk_s])) return $tic_rk_mark($tic_rk_s, $tic_rk_z);
    return '<svg class="xt-logo" width="' . $tic_rk_z . '" height="' . $tic_rk_z . '" fill="currentColor" aria-hidden="true" focusable="false" data-tech="'
         . e($tic_rk_s) . '"><use href="#tic-rk-' . e($tic_rk_s) . '"/></svg>';
};
?>
<section class="band band--alt tic-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="tic-head" data-rv>
      <p class="tic-ch"><b>06</b><span>The stack</span><i aria-hidden="true"></i><em>eight units, silicon at the bottom, policy at the top</em></p>
      <div class="tic-head__t">
        <h2 class="h2" id="stack-t"><span class="g">The stack,</span> as a rack cross-section.</h2>
      </div>
      <div class="tic-head__l">
        <p class="lead">Eight layers, each with a job, an owner and a short list of tools we trust. Slide any unit out to see what sits in it, and the decisions we make with you at that layer.</p>
      </div>
    </div>

    <svg class="tic-rk__sprite" aria-hidden="true" focusable="false" width="0" height="0"><defs>
      <?php foreach ($tic_rk_sprite as $tic_rk_s => $tic_rk_b): ?><symbol id="tic-rk-<?= e($tic_rk_s) ?>" viewBox="<?= e($tic_rk_b['vb']) ?>"><?= $tic_rk_b['body'] ?></symbol><?php endforeach; ?>
    </defs></svg>

    <div class="tic-rk" data-rv>
      <div class="tic-rk__rack">
        <p class="tic-rk__top" aria-hidden="true"><span><span class="tic-led tic-led--blink"></span>rack a · your-platform-prod</span><span>8 / 8 units healthy</span></p>
        <div class="tic-rk__units" role="tablist" aria-orientation="vertical" aria-label="Stack layers, from security at the top to accelerators at the bottom">
          <?php foreach ($tic_rk_units as $tic_rk_i => $tic_rk_u): $tic_rk_on = $tic_rk_i === $tic_rk_open; ?>
            <button type="button" role="tab" class="tic-rk__unit<?= $tic_rk_on ? ' is-on' : '' ?>" id="stack-u<?= e($tic_rk_u[0]) ?>" aria-controls="stack-p<?= e($tic_rk_u[0]) ?>" aria-selected="<?= $tic_rk_on ? 'true' : 'false' ?>" tabindex="<?= $tic_rk_on ? '0' : '-1' ?>" style="--i:<?= $tic_rk_i ?>">
              <span class="tic-rk__u" aria-hidden="true">U<?= e($tic_rk_u[0]) ?></span>
              <span class="tic-rk__leds" aria-hidden="true"><i class="tic-led tic-led--blink" style="--i:<?= $tic_rk_i ?>"></i><i class="tic-led tic-led--blink" style="--i:<?= $tic_rk_i + 3 ?>"></i></span>
              <span class="tic-rk__name"><?= e($tic_rk_u[2]) ?></span>
              <span class="tic-rk__marks" aria-hidden="true"><?php foreach (array_slice(array_values(array_filter($tic_rk_logos($tic_rk_u[3]), $tic_rk_has)), 0, 4) as $tic_rk_s): ?><?= $tic_rk_use($tic_rk_s, 16) ?><?php endforeach; ?></span>
              <span class="tic-rk__ro" aria-hidden="true"><?= e($tic_rk_u[5]) ?></span>
            </button>
          <?php endforeach; ?>
        </div>
        <p class="tic-rk__base" aria-hidden="true"><span>power · 2 × pdu</span><span>fabric · 400G</span><span class="bdh-ill">Illustrative</span></p>
      </div>

      <div class="tic-rk__trays bdh-panes">
        <?php foreach ($tic_rk_units as $tic_rk_i => $tic_rk_u): $tic_rk_on = $tic_rk_i === $tic_rk_open; ?>
          <div class="tic-rk__tray bdh-pane<?= $tic_rk_on ? ' is-on' : '' ?>" role="tabpanel" id="stack-p<?= e($tic_rk_u[0]) ?>" aria-labelledby="stack-u<?= e($tic_rk_u[0]) ?>" tabindex="0">
            <p class="tic-rk__slot"><span class="tic-led" aria-hidden="true"></span>U<?= e($tic_rk_u[0]) ?> · tray open<span class="tic-rk__slotro"><?= e($tic_rk_u[5]) ?></span></p>
            <h3 class="bdh-t bdh-t--l"><?= e($tic_rk_u[2]) ?></h3>
            <p class="tic-rk__why"><?= e($tic_rk_u[6]) ?></p>
            <p class="tic-k tic-rk__kk">Technologies we work with here</p>
            <ul class="tic-rk__chips" role="list">
              <?php foreach ($tic_rk_logos($tic_rk_u[3]) as $tic_rk_s): ?><li class="tic-chip"><?= $tic_rk_use($tic_rk_s) ?><?= e($STACK[$tic_rk_s]['name']) ?></li><?php endforeach; ?>
              <?php foreach ($tic_rk_u[4] as $tic_rk_x): ?><li class="tic-chip"><i class="tic-chip__dot" aria-hidden="true"></i><?= e($tic_rk_x) ?></li><?php endforeach; ?>
            </ul>
            <p class="tic-k tic-rk__kk">Decided with you at this layer</p>
            <ul class="bdh-bullets"><?php foreach ($tic_rk_u[7] as $tic_rk_x): ?><li><?= e($tic_rk_x) ?></li><?php endforeach; ?></ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="tic-rk__foot">
      <figure class="tic-rk__photo" data-rv>
        <div class="bdh-img bdh-img--r43"><img src="<?= xe_url('assets/imgs/tech/ai-infrastructure-cloud/tic-stack-switch.jpg') ?>" alt="A data-centre switch with direct-attach cables plugged into its high-speed ports" width="1600" height="836" loading="lazy" decoding="async"></div>
        <figcaption class="bdh-cap-chip"><b>U01 · the fabric</b>GPU nodes exchange data over high-bandwidth links; slow networking starves fast accelerators.</figcaption>
      </figure>

      <div class="tic-rk__res" data-rv data-rv-d="80">
        <p class="tic-k"><?= xt_icon('pin', ['size' => 16]) ?> Data residency</p>
        <h3 class="bdh-t bdh-t--l">India regions we deploy to</h3>
        <p class="bdh-d">Residency is written as policy at the gateway: a request tagged as personal data cannot be routed to a model or region outside India. Batch jobs on non-personal data may move to cleaner or cheaper regions.</p>
        <div class="tic-rk__tw">
          <table class="tic-rk__table">
            <caption class="bdh-sr">Cloud regions in India used for data residency</caption>
            <thead><tr><th scope="col">Cloud</th><th scope="col">Region</th><th scope="col">Location</th><th scope="col">Code</th></tr></thead>
            <tbody>
              <?php foreach ($tic_rk_regions as $tic_rk_r): ?>
                <tr><th scope="row"><span class="tic-rk__cl"><?= e($tic_rk_r[1]) ?></span></th><td><?= e($tic_rk_r[2]) ?></td><td><?= e($tic_rk_r[3]) ?></td><td><code><?= e($tic_rk_r[4]) ?></code></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="tic-note">GPU types and capacity differ by region and change often; we confirm availability before a design is committed.</p>
      </div>
    </div>
  </div>
</section>
