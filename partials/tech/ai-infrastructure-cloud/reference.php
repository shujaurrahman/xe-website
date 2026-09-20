<?php /* DRAFT COPY — review before launch */
/* 03 Reference — the reference architecture as a working diagram. Clients → API gateway → AI gateway/router →
   model serving (managed APIs and self-hosted open weights on Kubernetes GPU pools) → data and storage, with an
   evals-and-canary lane and three rails (observability, secrets, policy). Tiers assemble on entry; request
   packets travel in, streamed tokens travel back, and the router switches routes (provider A, self-hosted for a
   residency request, fallback when provider A returns 429). ≥ 900 px: the SVG; below: the same architecture as an
   ordered list (the list is also what screen readers get at every width). Below it: the managed-versus-self-hosted
   choice, the pace note and the technologies. */
$tic_ref_list = [   // [tier, name, what it does]
    ['01', 'Clients',                   'Web and mobile apps, internal tools, and agents or scheduled jobs call one internal AI API.'],
    ['02', 'API gateway',               'Authenticates every call (OIDC, JWT), enforces rate limits and quotas per tenant, and logs requests.'],
    ['03', 'AI gateway and router',     'Routes each request by cost, latency, quality and data class; opens a circuit breaker and falls back when a provider degrades; caches prompts and answers; enforces token budgets per team.'],
    ['04', 'Model serving',             'Managed model APIs from more than one provider, plus self-hosted open-weight models on vLLM in Kubernetes GPU node pools that autoscale on queue depth.'],
    ['05', 'Evals and canary',          'A candidate model takes shadow traffic, then a small canary share, and is promoted only when eval scores, p95 latency and cost hold.'],
    ['06', 'Data and storage',          'A vector database for retrieval, a feature store, and object storage for model weights, documents and logs.'],
    ['07', 'Rails across every tier',   'OpenTelemetry traces, metrics and logs; secrets in Vault or a cloud KMS with short-lived credentials; policy as code for IAM, network and data residency.'],
];
$tic_ref_choices = [   // [kicker, title, choose-when bullets, watch]
    ['Fastest to start', 'Managed model APIs', ['Volume is modest or spiky', 'You need frontier-model quality today', 'Nobody on the team runs GPUs'], 'Per-token cost at scale, provider rate limits, data-processing terms.'],
    ['Most control', 'Self-hosted open weights', ['Steady volume makes GPU-hours cheaper than tokens', 'Data must stay in your account or in India', 'You need tight latency or a fine-tuned model'], 'GPU capacity, on-call, model and driver upgrades.'],
    ['Our default', 'Both, behind one gateway', ['One API for every product team', 'Routes by cost, latency and data class', 'Fallback when a provider degrades'], 'Router configuration is code, reviewed and tested like any other.'],
];
$tic_ref_logos = ['kubernetes', 'nvidia', 'vllm', 'amazonwebservices', 'microsoftazure', 'googlecloud', 'cloudflare', 'terraform', 'opentelemetry', 'redis', 'qdrant'];
$tic_ref_ico = function (string $name, int $x, int $y, int $s = 18): string {
    return '<g transform="translate(' . $x . ',' . $y . ')">' . xt_icon($name, ['size' => $s]) . '</g>';
};
?>
<section class="band band--alt tic-reference" id="reference" aria-labelledby="reference-t">
  <div class="wrap">
    <div class="tic-head" data-rv>
      <p class="tic-ch"><b>03</b><span>Reference architecture</span><i aria-hidden="true"></i><em>clients → gateway → router → serving → data</em></p>
      <div class="tic-head__t">
        <h2 class="h2" id="reference-t"><span class="g">A reference architecture</span> that scales and fails safely.</h2>
      </div>
      <div class="tic-head__l">
        <p class="lead">Every model call goes through one gateway you own. That single seam is what makes AI observable, affordable and replaceable: routing, fallback, caching, budgets and evals live there, not scattered through product code.</p>
      </div>
    </div>

    <div class="tic-ref" data-rv>
      <div class="tic-ref__bar" aria-hidden="true">
        <span class="tic-k">your-platform · reference v3</span>
        <span class="tic-ref__legend"><i class="is-req"></i>request <i class="is-tok"></i>streamed tokens <i class="is-can"></i>shadow · canary</span>
        <span class="tic-ref__now"><span class="tic-led tic-led--blink"></span><span data-ref-label>route → provider A · general query</span></span>
      </div>

      <svg class="tic-ref__svg" viewBox="0 0 1200 660" data-route="a" aria-hidden="true" focusable="false">
        <defs>
          <path id="tic-ref-ra" d="M160,300 L660,300 C690,300 690,180 715,180"/>
          <path id="tic-ref-rs" d="M160,300 L660,300 C690,300 690,390 715,390"/>
        </defs>

        <!-- rails -->
        <g class="tic-ref__tier" style="--i:6">
          <rect class="tic-ref__rail" x="215" y="10" width="965" height="40" rx="10"/>
          <?= $tic_ref_ico('radar', 229, 21) ?>
          <text class="tk" x="256" y="35">Observability</text>
          <text class="tl" x="376" y="35">OpenTelemetry traces · metrics · logs → Prometheus · Grafana · burn-rate alerts</text>
          <?php foreach ([300, 550, 825, 1085] as $tic_ref_x): ?><line class="tic-ref__drop" x1="<?= $tic_ref_x ?>" y1="50" x2="<?= $tic_ref_x ?>" y2="<?= $tic_ref_x === 825 ? 110 : ($tic_ref_x === 1085 ? 150 : ($tic_ref_x === 550 ? 160 : 200)) ?>"/><?php endforeach; ?>
          <rect class="tic-ref__rail" x="215" y="612" width="470" height="40" rx="10"/>
          <?= $tic_ref_ico('key', 229, 623) ?>
          <text class="tk" x="256" y="637">Secrets</text>
          <text class="tl" x="330" y="637">Vault · cloud KMS · short-lived credentials</text>
          <rect class="tic-ref__rail" x="705" y="612" width="475" height="40" rx="10"/>
          <?= $tic_ref_ico('shield', 719, 623) ?>
          <text class="tk" x="746" y="637">Policy</text>
          <text class="tl" x="812" y="637">IAM · network policy · data residency as code</text>
        </g>

        <!-- connectors -->
        <g class="tic-ref__wires">
          <path class="tic-ref__w" d="M160,210 C190,210 188,300 215,300"/>
          <path class="tic-ref__w" d="M160,300 L215,300"/>
          <path class="tic-ref__w" d="M160,390 C190,390 188,300 215,300"/>
          <path class="tic-ref__w" d="M385,300 L440,300"/>
          <path class="tic-ref__w tic-ref__w--a" d="M660,300 C690,300 690,180 715,180"/>
          <path class="tic-ref__w tic-ref__w--s" d="M660,300 C690,300 690,390 715,390"/>
          <path class="tic-ref__w" d="M550,440 L550,530"/>
          <path class="tic-ref__w" d="M840,480 L840,530"/>
          <path class="tic-ref__w tic-ref__w--can" d="M935,180 C962,180 962,250 990,250"/>
          <path class="tic-ref__w tic-ref__w--can" d="M935,390 C962,390 962,350 990,350"/>
          <text class="tic-ref__wl" x="560" y="495">retrieve</text>
          <text class="tic-ref__wl" x="850" y="512">weights</text>
        </g>

        <!-- packets: below the boxes, so they vanish inside each tier -->
        <g class="tic-ref__pks tic-ref__pks--a">
          <?php foreach (['0s', '-0.9s', '-1.8s'] as $tic_ref_b): ?>
            <circle class="tic-ref__pk" r="4.5"><animateMotion dur="2.7s" begin="<?= $tic_ref_b ?>" repeatCount="indefinite" calcMode="linear"><mpath href="#tic-ref-ra"/></animateMotion></circle>
          <?php endforeach; ?>
          <?php foreach (['-0.45s', '-1.35s', '-2.25s'] as $tic_ref_b): ?>
            <rect class="tic-ref__tok" x="-5" y="-1.5" width="10" height="3" rx="1.5"><animateMotion dur="2.7s" begin="<?= $tic_ref_b ?>" repeatCount="indefinite" keyPoints="1;0" keyTimes="0;1" calcMode="linear" rotate="auto"><mpath href="#tic-ref-ra"/></animateMotion></rect>
          <?php endforeach; ?>
        </g>
        <g class="tic-ref__pks tic-ref__pks--s">
          <?php foreach (['0s', '-0.9s', '-1.8s'] as $tic_ref_b): ?>
            <circle class="tic-ref__pk" r="4.5"><animateMotion dur="2.7s" begin="<?= $tic_ref_b ?>" repeatCount="indefinite" calcMode="linear"><mpath href="#tic-ref-rs"/></animateMotion></circle>
          <?php endforeach; ?>
          <?php foreach (['-0.45s', '-1.35s', '-2.25s'] as $tic_ref_b): ?>
            <rect class="tic-ref__tok" x="-5" y="-1.5" width="10" height="3" rx="1.5"><animateMotion dur="2.7s" begin="<?= $tic_ref_b ?>" repeatCount="indefinite" keyPoints="1;0" keyTimes="0;1" calcMode="linear" rotate="auto"><mpath href="#tic-ref-rs"/></animateMotion></rect>
          <?php endforeach; ?>
        </g>

        <!-- 01 clients -->
        <g class="tic-ref__tier" style="--i:0">
          <text class="tk" x="20" y="150">01 · Clients</text>
          <?php foreach ([[180, 'Web & mobile', 'browser'], [270, 'Internal tools', 'dashboard'], [360, 'Agents & jobs', 'agent']] as $tic_ref_c): ?>
            <rect class="tic-ref__box" x="20" y="<?= $tic_ref_c[0] ?>" width="140" height="60" rx="12"/>
            <?= $tic_ref_ico($tic_ref_c[2], 34, $tic_ref_c[0] + 21) ?>
            <text class="tt tt--s" x="60" y="<?= $tic_ref_c[0] + 35 ?>"><?= e($tic_ref_c[1]) ?></text>
          <?php endforeach; ?>
        </g>

        <!-- 02 api gateway -->
        <g class="tic-ref__tier" style="--i:1">
          <text class="tk" x="215" y="190">02 · Edge</text>
          <rect class="tic-ref__box" x="215" y="200" width="170" height="200" rx="14"/>
          <?= $tic_ref_ico('lock', 233, 220, 20) ?>
          <text class="tt" x="233" y="266">API gateway</text>
          <text class="tl" x="233" y="296">Auth · OIDC / JWT</text>
          <text class="tl" x="233" y="318">Rate limits · quotas</text>
          <text class="tl" x="233" y="340">Tenant isolation</text>
          <text class="tl" x="233" y="362">Request logs</text>
        </g>

        <!-- 03 ai gateway / router -->
        <g class="tic-ref__tier" style="--i:2">
          <text class="tk" x="440" y="150">03 · AI gateway</text>
          <rect class="tic-ref__box tic-ref__box--key" x="440" y="160" width="220" height="280" rx="16"/>
          <?= $tic_ref_ico('network', 460, 180, 20) ?>
          <text class="tt" x="460" y="228">Router</text>
          <text class="tl" x="460" y="258">Route by cost · p95 · quality</text>
          <text class="tl" x="460" y="280">Fallback · circuit breakers</text>
          <text class="tl" x="460" y="302">Prompt + semantic cache</text>
          <text class="tl" x="460" y="324">Token budgets per team</text>
          <text class="tl" x="460" y="346">Data-class rules</text>
          <rect class="tic-ref__ro" x="456" y="372" width="188" height="50" rx="9"/>
          <text class="tic-ref__rok" x="470" y="392">ACTIVE ROUTE</text>
          <text class="tic-ref__rov" x="470" y="411" data-ref-route>provider A · 82% of calls</text>
        </g>

        <!-- 04 serving -->
        <g class="tic-ref__tier" style="--i:3">
          <text class="tk" x="715" y="100">04 · Serving</text>
          <rect class="tic-ref__box tic-ref__box--a" x="715" y="110" width="220" height="140" rx="14"/>
          <?= $tic_ref_ico('cloud', 733, 128, 20) ?>
          <text class="tt" x="733" y="174">Managed model APIs</text>
          <text class="tl" x="733" y="202">Provider A · Provider B</text>
          <text class="tl" x="733" y="224">Pay per token · no GPUs</text>
          <g class="tic-ref__429"><rect x="861" y="124" width="60" height="22" rx="11"/><text x="891" y="139" text-anchor="middle">429</text></g>

          <rect class="tic-ref__box tic-ref__box--s" x="715" y="300" width="220" height="180" rx="14"/>
          <?= $tic_ref_ico('gpu', 733, 318, 20) ?>
          <text class="tt" x="733" y="364">Self-hosted open weights</text>
          <text class="tl" x="733" y="392">vLLM on Kubernetes</text>
          <text class="tl" x="733" y="414">GPU node pools · autoscaled</text>
          <?php for ($tic_ref_g = 0; $tic_ref_g < 8; $tic_ref_g++): ?>
            <rect class="tic-ref__gpu<?= $tic_ref_g >= 6 ? ' is-warm' : '' ?>" x="<?= 733 + $tic_ref_g * 23 ?>" y="436" width="17" height="24" rx="3" style="--i:<?= $tic_ref_g ?>"/>
          <?php endfor; ?>
        </g>

        <!-- 05 evals + canary -->
        <g class="tic-ref__tier" style="--i:4">
          <text class="tk" x="990" y="140">05 · Evaluate</text>
          <rect class="tic-ref__box" x="990" y="150" width="190" height="300" rx="14"/>
          <?= $tic_ref_ico('eval', 1008, 168, 20) ?>
          <text class="tt" x="1008" y="214">Evals &amp; canary</text>
          <text class="tl" x="1008" y="244">candidate · model v2</text>
          <text class="tl" x="1008" y="276">traffic</text>
          <rect class="tic-ref__track" x="1008" y="286" width="154" height="6" rx="3"/>
          <rect class="tic-ref__fill" x="1008" y="286" width="154" height="6" rx="3"/>
          <text class="tl tl--r" x="1162" y="276" text-anchor="end" data-ref-canary>25%</text>
          <text class="tl" x="1008" y="324">eval score</text><text class="tv" x="1162" y="324" text-anchor="end">0.94 ≥ 0.92</text>
          <text class="tl" x="1008" y="350">p95 latency</text><text class="tv" x="1162" y="350" text-anchor="end">+40 ms</text>
          <text class="tl" x="1008" y="376">cost / 1k</text><text class="tv" x="1162" y="376" text-anchor="end">−31%</text>
          <rect class="tic-ref__gate" x="1008" y="396" width="154" height="36" rx="8"/>
          <text class="tic-ref__gatet" x="1085" y="419" text-anchor="middle">gate passed · promote</text>
        </g>

        <!-- 06 data -->
        <g class="tic-ref__tier" style="--i:5">
          <rect class="tic-ref__box" x="440" y="530" width="220" height="56" rx="12"/>
          <?= $tic_ref_ico('vector', 456, 549) ?>
          <text class="tt tt--s" x="484" y="555">Vector database</text>
          <text class="tl tl--s" x="484" y="573">Qdrant · pgvector</text>
          <rect class="tic-ref__box" x="715" y="530" width="220" height="56" rx="12"/>
          <?= $tic_ref_ico('database', 731, 549) ?>
          <text class="tt tt--s" x="759" y="555">Object storage</text>
          <text class="tl tl--s" x="759" y="573">weights · documents · logs</text>
          <rect class="tic-ref__box" x="990" y="530" width="190" height="56" rx="12"/>
          <?= $tic_ref_ico('layers', 1006, 549) ?>
          <text class="tt tt--s" x="1034" y="555">Feature store</text>
          <text class="tl tl--s" x="1034" y="573">online · offline</text>
          <text class="tk" x="215" y="563">06 · Data</text>
        </g>
      </svg>

      <ol class="tic-ref__list" aria-label="Reference architecture, tier by tier">
        <?php foreach ($tic_ref_list as $tic_ref_i => $tic_ref_t): ?>
          <li style="--i:<?= $tic_ref_i ?>"><span class="tic-ref__ln"><?= e($tic_ref_t[0]) ?></span><div><h3 class="tic-ref__lt"><?= e($tic_ref_t[1]) ?></h3><p><?= e($tic_ref_t[2]) ?></p></div></li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="tic-ref__choose">
      <ul class="tic-ref__cards" data-rv-s data-rv-step="90">
        <?php foreach ($tic_ref_choices as $tic_ref_i => $tic_ref_c): ?>
          <li class="tic-ref__card<?= $tic_ref_i === 2 ? ' is-default' : '' ?>">
            <p class="tic-k"><?= e($tic_ref_c[0]) ?></p>
            <h3 class="bdh-t bdh-t--l"><?= e($tic_ref_c[1]) ?></h3>
            <p class="tic-ref__when">Choose when</p>
            <ul class="bdh-bullets"><?php foreach ($tic_ref_c[2] as $tic_ref_b): ?><li><?= e($tic_ref_b) ?></li><?php endforeach; ?></ul>
            <p class="tic-ref__watch"><b><?= $tic_ref_i === 2 ? 'Governed as' : 'Watch' ?></b><?= e($tic_ref_c[3]) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="tic-ref__pace" data-rv>
        <div class="tic-ref__pt">
          <p class="tic-k"><?= xt_icon('rocket', ['size' => 18]) ?> AI-native pace</p>
          <h3 class="bdh-t bdh-t--l">Swap models in days, not quarters.</h3>
          <p class="bdh-d">Because every call goes through the gateway, a new or cheaper model is a configuration change. It takes shadow traffic, then a 5% canary, and is promoted only when evals, p95 latency and cost hold. Infrastructure changes ship weekly through reviewed Terraform and Helm pipelines.</p>
        </div>
        <ol class="tic-ref__steps" aria-label="Model promotion, typical timeline">
          <li><b>Day 1</b><span>Candidate added to router config · offline evals on the golden set</span></li>
          <li><b>Day 2</b><span>Shadow traffic · responses scored, never shown</span></li>
          <li><b>Day 3</b><span>5% canary · p95, cost and error budget watched</span></li>
          <li><b>Day 5</b><span>Promoted, or rolled back in one commit</span></li>
        </ol>
      </div>

      <div class="tic-ref__logos" data-rv>
        <p class="tic-k">Technologies we work with</p>
        <?= xt_stack(array_values(array_filter($tic_ref_logos, fn ($tic_ref_s) => isset($STACK[$tic_ref_s]))), ['variant' => 'logos', 'size' => 26, 'label' => 'Technologies we work with for AI infrastructure']) ?>
      </div>
    </div>
  </div>
</section>
