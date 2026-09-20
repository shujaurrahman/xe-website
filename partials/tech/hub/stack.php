<?php /* DRAFT COPY — review before launch */
/* Stack — the complete technology library (data/tech-stack.php) as one wall, read by layer: each of the
   eighteen layers is a row with its label in the left gutter and its marks beside it. The whole wall is a
   single-select listbox (each layer a role="group"): choosing a mark shows what we use it for and which
   capability pages lean on it (from each capability's 'stack' list), in a rail that sticks beside the wall.
   At rest the wall is clamped to about a screen behind "Show all 174 technologies" (stack.js adds .is-clamp,
   so with JavaScript off the whole library is printed); a layer filter isolates one layer as cards.
   Presented as technologies we work with — never as partnerships. */
$stk_cats  = xt_categories();
$stk_all   = xt_stack_data();
$stk_first = 'kubernetes';

/* one selection principle per category */
$stk_principle = [
    'languages'     => 'Boring where it should be. TypeScript, Python and Go cover most of what we ship; the rest only when your platform already speaks it.',
    'frontend'      => 'Server-rendered by default, hydrated where interaction needs it, and measured against Core Web Vitals in the field, not the lab.',
    'mobile'        => 'Cross-platform first when one team ships both stores; native where the camera, sensors or performance budget require it.',
    'backend'       => 'Typed APIs with contracts, background jobs that survive restarts, and a queue between any two things that can fail.',
    'data'          => 'One customer record, one event stream, one warehouse, with lineage from source to dashboard.',
    'ai-ml'         => 'Open frameworks, reproducible training, a model registry, and inference servers we can run inside your cloud account.',
    'llm'           => 'Model-agnostic. We pick per task on eval results and switch when the evidence changes.',
    'ai-tooling'    => 'Retrieval, orchestration and evals kept as separate parts, so each can be replaced without touching the others.',
    'cloud'         => 'Your account, your region. Portable infrastructure on any of the big three, with the edge for latency.',
    'devops'        => 'Everything as code: infrastructure, pipelines and policies. Reviewed, versioned and reproducible.',
    'observability' => 'Traces, metrics and logs on open standards, with SLOs that say when to stop shipping and fix.',
    'quality'       => 'Tests on every merge, load tests before every launch, and gates that block rather than warn.',
    'security'      => 'Identity first, secrets vaulted, dependencies and images scanned on every build.',
    'integration'   => 'Events over point-to-point. APIs with contracts, messaging where people already are, low-code where it fits.',
    'business'      => 'We integrate the systems your teams already run rather than replacing them for the sake of it.',
    'search'        => 'Measured from search console to analytics, so ranking, citations and revenue sit in one report.',
    'content'       => 'Headless where content has many surfaces; the familiar editor where it has one.',
    'collaboration' => 'Design, tickets and docs in the tools your team already uses, with one decision log for the programme.',
];
$stk_principle_all = 'One library, eighteen layers. Every choice is made per engagement on evidence, written into an architecture decision record, and kept reversible.';

/* what we use each technology for (one short line each) */
$stk_use = [
    'typescript' => 'Typed front ends and Node services', 'javascript' => 'The browser and everything that runs in it', 'python' => 'AI, data pipelines and fast back ends',
    'go' => 'High-throughput services and CLIs', 'rust' => 'Performance-critical components and WebAssembly', 'kotlin' => 'Android apps and JVM services',
    'swift' => 'iOS and iPadOS apps', 'php' => 'Content sites and mature web platforms', 'openjdk' => 'Enterprise back ends on the JVM',
    'dotnet' => 'Enterprise back ends on Windows and Linux', 'nodedotjs' => 'API servers, workers and tooling',
    'react' => 'Interactive product interfaces', 'nextdotjs' => 'Server-rendered React sites and apps', 'vuedotjs' => 'Progressive interfaces on existing sites',
    'angular' => 'Large internal applications with strict structure', 'svelte' => 'Lightweight embedded widgets and dashboards', 'astro' => 'Content-heavy sites with minimal JavaScript',
    'tailwindcss' => 'Token-driven styling at speed', 'threedotjs' => '3D views and product configurators in the browser', 'webassembly' => 'Near-native compute in the browser',
    'flutter' => 'One codebase for iOS and Android', 'reactnative' => 'Mobile apps that share logic with React web', 'expo' => 'Faster React Native builds, updates and releases',
    'ios' => 'Native Apple platform features', 'android' => 'Native Android platform features', 'jetpackcompose' => 'Modern native Android interfaces',
    'nestjs' => 'Structured TypeScript APIs', 'fastapi' => 'Python APIs that serve models and data', 'django' => 'Admin-heavy platforms with a mature ORM',
    'laravel' => 'PHP platforms with a rich ecosystem', 'springboot' => 'JVM services in enterprise environments', 'graphql' => 'One typed API over many back ends',
    'openapiinitiative' => 'API contracts that generate clients and tests', 'redis' => 'Caching, rate limits and queues', 'rabbitmq' => 'Reliable work queues between services',
    'temporal' => 'Durable workflows that survive failures', 'supabase' => 'Postgres, auth and storage for fast starts', 'firebase' => 'Mobile back ends, push and analytics',
    'postgresql' => 'The default system of record', 'mongodb' => 'Document stores for flexible schemas', 'snowflake' => 'Cloud warehouse for analytics at scale',
    'databricks' => 'Lakehouse for data engineering and ML', 'apachespark' => 'Distributed batch and stream processing', 'apachekafka' => 'The event backbone between systems',
    'apacheairflow' => 'Scheduled data pipelines with lineage', 'dbt' => 'Tested, versioned transformations in the warehouse', 'clickhouse' => 'Sub-second analytics on event data',
    'elasticsearch' => 'Full-text search and log analytics', 'googlebigquery' => 'Serverless warehouse on Google Cloud', 'duckdb' => 'Fast local analytics inside pipelines',
    'airbyte' => 'Connectors that move data into the warehouse', 'looker' => 'Governed metrics and dashboards', 'powerbi' => 'Reporting inside Microsoft estates',
    'pytorch' => 'Training and fine-tuning models', 'tensorflow' => 'Production ML in Google-centred stacks', 'huggingface' => 'Open models, datasets and tokenisers',
    'scikitlearn' => 'Classical ML: forecasting, scoring, clustering', 'nvidia' => 'GPU compute for training and inference', 'mlflow' => 'Experiment tracking and model registry',
    'vllm' => 'High-throughput serving for open models', 'ray' => 'Distributed training and batch inference', 'onnx' => 'Portable models across runtimes', 'jupyter' => 'Exploration and reproducible analysis',
    'openai' => 'Frontier models behind the gateway', 'anthropic' => 'Frontier models for long-context and agent work', 'googlegemini' => 'Multimodal models and Google Cloud integration',
    'mistralai' => 'Efficient open-weight and hosted models', 'meta' => 'Open-weight Llama models run in your cloud', 'deepseek' => 'Open-weight reasoning models, self-hosted',
    'ollama' => 'Local models for development and offline use', 'perplexity' => 'Search-grounded answers and citation tracking',
    'langchain' => 'Chains, tools and integrations for LLM apps', 'langgraph' => 'Stateful agents with checkpoints and approvals', 'llamaindex' => 'Document ingestion and retrieval pipelines',
    'pinecone' => 'Managed vector search at scale', 'weaviate' => 'Hybrid vector and keyword search', 'qdrant' => 'Self-hosted vector search with filtering',
    'milvus' => 'Vector search for very large collections', 'pgvector' => 'Vectors inside Postgres, no new database', 'replicate' => 'Hosted open models by API',
    'modal' => 'Serverless GPUs for batch and bursty inference', 'githubcopilot' => 'AI pair programming in the IDE', 'cursor' => 'AI-native code editing with review',
    'amazonwebservices' => 'Primary cloud for most regulated workloads', 'microsoftazure' => 'Cloud for Microsoft-centred estates', 'googlecloud' => 'Cloud for data- and AI-heavy platforms',
    'cloudflare' => 'Edge, DNS, WAF and bot management', 'vercel' => 'Hosting for Next.js front ends', 'netlify' => 'Hosting for static and Jamstack sites',
    'digitalocean' => 'Simple cloud for smaller workloads', 'fastly' => 'Edge caching and compute', 'akamai' => 'Global delivery and edge security',
    'docker' => 'Reproducible builds and local environments', 'kubernetes' => 'Orchestration for services and model serving', 'helm' => 'Packaged Kubernetes deployments',
    'terraform' => 'Infrastructure as code across clouds', 'pulumi' => 'Infrastructure as code in TypeScript or Python', 'ansible' => 'Configuration for hosts and appliances',
    'argo' => 'GitOps delivery and workflow pipelines', 'githubactions' => 'CI pipelines with evals and scans', 'github' => 'Source, reviews and the audit trail',
    'gitlab' => 'Source and CI in self-hosted estates', 'jenkins' => 'CI in established enterprise pipelines', 'istio' => 'Service mesh for mTLS and traffic policy',
    'opentelemetry' => 'Traces, metrics and logs on an open standard', 'prometheus' => 'Metrics and alerting for services', 'grafana' => 'SLO dashboards for engineering and leadership',
    'datadog' => 'Managed observability across cloud estates', 'sentry' => 'Error tracking in front ends and apps', 'newrelic' => 'APM in established enterprise stacks',
    'elastic' => 'Log analytics and security events', 'pagerduty' => 'On-call rotation and incident response',
    'playwright' => 'End-to-end tests in real browsers', 'cypress' => 'Component and end-to-end tests', 'selenium' => 'Cross-browser tests in legacy suites',
    'jest' => 'Unit tests for JavaScript and TypeScript', 'k6' => 'Load tests before every launch', 'postman' => 'API contract tests and collections', 'sonarqubecloud' => 'Code quality and security gates in CI',
    'okta' => 'Enterprise SSO and identity', 'auth0' => 'Customer identity and access', 'openid' => 'Standard sign-in across systems', 'jsonwebtokens' => 'Signed tokens between services',
    'vault' => 'Secrets management and dynamic credentials', 'snyk' => 'Dependency and container vulnerability scanning', 'trivy' => 'Image, IaC and SBOM scanning in CI',
    'falco' => 'Runtime threat detection on Kubernetes', 'owasp' => 'ASVS, Top 10 and LLM Top 10 as the test bar', 'burpsuite' => 'Manual penetration testing', '1password' => 'Shared secrets for teams, never in chat',
    'zapier' => 'Quick automations between SaaS tools', 'make' => 'Visual automations with branching logic', 'n8n' => 'Self-hosted workflow automation with AI steps',
    'mulesoft' => 'Enterprise integration platform', 'kong' => 'API gateway, auth and rate limiting', 'twilio' => 'SMS, voice and verification',
    'whatsapp' => 'Customer conversations on WhatsApp Business', 'slack' => 'Alerts, approvals and copilots where teams work', 'microsoftteams' => 'Approvals and bots inside Microsoft 365',
    'salesforce' => 'CRM integrations and custom objects', 'hubspot' => 'CRM and marketing automation', 'zoho' => 'CRM and operations suites for the mid-market',
    'sap' => 'ERP integration for orders, stock and finance', 'shopify' => 'Commerce storefronts and headless builds', 'woocommerce' => 'Commerce on WordPress',
    'stripe' => 'Payments, billing and subscriptions', 'razorpay' => 'Payments and UPI for India', 'paypal' => 'Global checkout and payouts',
    'intercom' => 'Customer messaging and support inbox', 'zendesk' => 'Support desk integration and AI handoff',
    'google' => 'Search, Ads and Maps platform APIs', 'googlesearchconsole' => 'Index coverage and query data', 'googleanalytics' => 'Traffic, conversion and attribution',
    'googletagmanager' => 'Consent-aware tag management', 'pagespeedinsights' => 'Field and lab Core Web Vitals', 'lighthouse' => 'Performance and accessibility audits in CI',
    'semrush' => 'Keyword and competitor research', 'ahrefs' => 'Backlinks and content gaps', 'algolia' => 'Site and product search',
    'posthog' => 'Product analytics, flags and session replay', 'mixpanel' => 'Product analytics and funnels', 'schemaorg' => 'Structured data machines can cite',
    'wordpress' => 'Content sites and editorial teams', 'contentful' => 'Headless content across many surfaces', 'sanity' => 'Structured content with live preview',
    'strapi' => 'Self-hosted headless CMS', 'webflow' => 'Marketing sites teams edit themselves',
    'figma' => 'Design source of truth and tokens', 'storybook' => 'Component library and visual tests', 'jira' => 'Delivery tracking in enterprise teams',
    'confluence' => 'Runbooks and decision records', 'linear' => 'Fast issue tracking for product squads', 'notion' => 'Docs and lightweight planning', 'miro' => 'Architecture and workshop whiteboards',
];

/* which capability pages lean on each technology (from data/technology-intelligence.php) */
$stk_used = [];
foreach ($TI as $stk_cs => $stk_c) { foreach ($stk_c['stack'] as $stk_t) { $stk_used[$stk_t][] = $stk_cs; } }
$stk_counts = [];
foreach ($stk_all as $stk_t) { $stk_counts[$stk_t['category']] = ($stk_counts[$stk_t['category']] ?? 0) + 1; }
$stk_total = count($stk_all);
$stk_ft = $stk_all[$stk_first];
$stk_url = fn (string $stk_s): string => xe_url('services/technology-intelligence/' . $stk_s . '.php');
/* the mark beside a printed name: the SVG where the library has one, otherwise a mono monogram tile (never a drawn logo) */
$stk_mark = function (string $stk_s, int $stk_px) use ($stk_all): string {
    if (!empty($stk_all[$stk_s]['file'])) return xt_logo($stk_s, ['size' => $stk_px, 'hidden' => true]);
    $stk_w = preg_split('/[\s.\-]+/', trim($stk_all[$stk_s]['name'] ?? $stk_s), -1, PREG_SPLIT_NO_EMPTY);
    $stk_m = count($stk_w) > 1 ? mb_substr($stk_w[0], 0, 1) . mb_substr($stk_w[1], 0, 1) : mb_substr($stk_w[0] ?? $stk_s, 0, 2);
    return '<span class="tih-stk__mono" aria-hidden="true">' . e($stk_m) . '</span>';
};
?>
<section class="band band--alt tih-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Tech stack</p>
        <h2 class="h2" id="stack-t"><span class="g">The technology we work with,</span> by layer.</h2>
      </div>
      <div>
        <!-- PLACEHOLDER: confirm the technology list and the "what we use it for" lines reflect current team experience before launch -->
        <p class="lead"><?= $stk_total ?> technologies across <?= count($stk_cats) ?> layers, from languages to collaboration tools. Model-agnostic and cloud-agnostic: each choice is made per task on evidence and changed when the evidence changes.</p>
        <p class="tih-note"><b>Technologies we work with.</b> No partner, reseller or certification tier is implied by any mark on this page.</p>
      </div>
    </div>

    <div class="tih-stk" data-cat="all" data-rv data-rv-d="80">
      <div class="tih-stk__filter">
        <p class="tih-k tih-stk__fk">Layer</p>
        <div class="tih-stk__cats" role="group" aria-label="Filter technologies by layer">
          <button type="button" class="tih-stk__cat" data-cat="all" aria-pressed="true">All <b><?= $stk_total ?></b></button>
          <?php foreach ($stk_cats as $stk_ck => $stk_cl): ?>
            <button type="button" class="tih-stk__cat" data-cat="<?= e($stk_ck) ?>" data-pr="<?= e($stk_principle[$stk_ck] ?? '') ?>" aria-pressed="false"><?= e($stk_cl) ?> <b><?= $stk_counts[$stk_ck] ?? 0 ?></b></button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="tih-stk__body">
        <div class="tih-stk__main">
          <div class="tih-stk__ro">
            <p class="tih-stk__count"><b data-n="<?= $stk_total ?>"><?= $stk_total ?></b> <span data-lbl>technologies · <?= count($stk_cats) ?> layers</span></p>
            <p class="tih-stk__pr" data-principle aria-live="polite"><?= e($stk_principle_all) ?></p>
          </div>
          <p class="bdh-sr">Use the arrow keys to move between technologies; the selected technology is described in the panel beside the wall.</p>
          <div class="tih-stk__grid" id="stack-wall" role="listbox" aria-label="Technologies we work with">
            <?php $stk_ci = 0; foreach ($stk_cats as $stk_ck => $stk_cl): $stk_ci++;
                $stk_rows = array_filter($stk_all, fn ($stk_r) => $stk_r['category'] === $stk_ck);
                if (!$stk_rows) continue; ?>
              <div class="tih-stk__lay" role="group" data-cat="<?= e($stk_ck) ?>" aria-label="<?= e($stk_cl) ?>, <?= count($stk_rows) ?> technologies">
                <p class="tih-stk__layk" aria-hidden="true"><b><?= str_pad((string) $stk_ci, 2, '0', STR_PAD_LEFT) ?></b><span><?= e($stk_cl) ?></span><i><?= count($stk_rows) ?></i></p>
                <div class="tih-stk__set" role="none">
                  <?php foreach ($stk_rows as $stk_slug => $stk_t): $stk_on = $stk_slug === $stk_first; ?>
                    <span class="tih-stk__cell" role="option" tabindex="<?= $stk_on ? '0' : '-1' ?>" aria-selected="<?= $stk_on ? 'true' : 'false' ?>"
                          data-tech="<?= e($stk_slug) ?>" data-cat="<?= e($stk_t['category']) ?>" data-name="<?= e($stk_t['name']) ?>" data-catl="<?= e($stk_cl) ?>"
                          data-caps="<?= e(implode(',', $stk_used[$stk_slug] ?? [])) ?>">
                      <span class="tih-stk__mark"><?= $stk_mark($stk_slug, 22) ?></span>
                      <span class="tih-stk__n"><?= e($stk_t['name']) ?></span>
                      <span class="tih-stk__u"><?= e($stk_use[$stk_slug] ?? $stk_cl) ?></span>
                    </span>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <button type="button" class="tih-stk__more" aria-expanded="false" aria-controls="stack-wall">Show all <?= $stk_total ?> technologies <span aria-hidden="true">↓</span></button>
        </div>

        <aside class="tih-stk__side">
          <div class="tih-stk__detail bdh-sticky" aria-live="polite">
            <p class="tih-k tih-stk__dk">Selected <span class="tih-stk__dpos"><b data-pos>1</b> / <span data-of><?= $stk_total ?></span></span></p>
            <div class="tih-stk__dtop">
              <span class="tih-stk__dmark" data-d="mark"><?= $stk_mark($stk_first, 34) ?></span>
              <div>
                <h3 class="tih-stk__dn" data-d="name"><?= e($stk_ft['name']) ?></h3>
                <p class="tih-stk__dc" data-d="cat"><?= e($stk_cats[$stk_ft['category']]) ?></p>
              </div>
            </div>
            <p class="tih-k">What we use it for</p>
            <p class="tih-stk__du" data-d="use"><?= e($stk_use[$stk_first]) ?></p>
            <p class="tih-k">Capability pages that lean on it</p>
            <p class="tih-stk__dl" data-d="caps">
              <?php foreach ($TI as $stk_cs => $stk_c): ?>
                <a class="tih-capl" href="<?= $stk_url($stk_cs) ?>" data-cap="<?= e($stk_cs) ?>"<?= in_array($stk_cs, $stk_used[$stk_first] ?? [], true) ? '' : ' hidden' ?>><b><?= e($stk_c['n']) ?></b><?= e($stk_c['short']) ?><i aria-hidden="true">›</i></a>
              <?php endforeach; ?>
              <span class="tih-stk__none" data-d="none" hidden>Used across engagements as needed; no capability page leads with it.</span>
            </p>
            <p class="tih-stk__hint">Choose any mark on the wall. Marks belong to their owners and show technologies we work with.</p>
          </div>
        </aside>
      </div>
    </div>
  </div>
</section>
