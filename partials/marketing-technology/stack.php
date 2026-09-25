<?php /* DRAFT COPY — review before launch */
/* Stack — the marketing technology we work with, arranged in the eleven layers a marketing stack actually
   has rather than by vendor category. Each layer is a row: its key on the left, its marks on the right.
   The rows are one single-select listbox (each layer a role="group"); choosing a mark shows what we use it
   for and which capabilities on this page lean on it. A layer filter isolates one layer.
   Presented as technologies we work with — never as a partnership, reseller or certification tier. Every
   slug below exists in data/tech-stack.php; nothing is drawn, traced or invented. */
$stk_layers = [
    ['collect',   'Collection & consent signals', ['googletagmanager', 'googleanalytics', 'google']],
    ['warehouse', 'Customer data & warehouse',    ['snowflake', 'googlebigquery', 'dbt', 'airbyte', 'postgresql']],
    ['crm',       'CRM & marketing automation',   ['hubspot', 'salesforce', 'zoho']],
    ['messaging', 'Messaging & conversation',     ['twilio', 'whatsapp', 'intercom', 'slack', 'microsoftteams']],
    ['content',   'Content & assets',             ['contentful', 'sanity', 'strapi', 'wordpress', 'webflow', 'algolia']],
    ['commerce',  'Commerce & payments',          ['shopify', 'stripe', 'razorpay']],
    ['analytics', 'Product & marketing analytics',['mixpanel', 'posthog', 'looker', 'powerbi']],
    ['models',    'Models & generation',          ['openai', 'anthropic', 'googlegemini', 'replicate', 'huggingface', 'modal']],
    ['modelling', 'Modelling & orchestration',    ['python', 'scikitlearn', 'n8n', 'make', 'zapier', 'temporal']],
    ['delivery',  'Delivery & edge',              ['cloudflare', 'vercel']],
    ['design',    'Mapping & design',             ['figma', 'miro']],
];
/* what we use each one for, in this discipline */
$stk_use = [
    'googletagmanager' => 'Consent-aware tag management, server-side',
    'googleanalytics'  => 'Traffic, conversion and journey reporting',
    'google'           => 'Google Ads, Merchant Center and platform APIs',
    'snowflake'        => 'The warehouse the customer record lives in',
    'googlebigquery'   => 'Warehouse and modelling on Google Cloud',
    'dbt'              => 'Tested, versioned transformations and segment definitions',
    'airbyte'          => 'Connectors that bring source systems into the warehouse',
    'postgresql'       => 'Operational store for profiles, consent and preferences',
    'hubspot'          => 'CRM, marketing automation and lifecycle journeys',
    'salesforce'       => 'CRM, marketing automation and loyalty data',
    'zoho'             => 'CRM and marketing operations for mid-market teams',
    'twilio'           => 'SMS, voice and verification at volume',
    'whatsapp'         => 'WhatsApp Business templates and the service window',
    'intercom'         => 'On-site conversation and handover to a person',
    'slack'            => 'Lead alerts, approvals and agent notifications',
    'microsoftteams'   => 'Approvals and alerts inside Microsoft 365',
    'contentful'       => 'Structured content that many channels read from',
    'sanity'           => 'Structured content with live preview for editors',
    'strapi'           => 'Self-hosted content model where data must stay in place',
    'wordpress'        => 'Content sites and editorial teams already trained on it',
    'webflow'          => 'Campaign and landing pages the team edits itself',
    'algolia'          => 'Site and product search, and on-site personalisation',
    'shopify'          => 'Commerce events, catalogue and feed-driven creative',
    'stripe'           => 'Subscriptions, payment links and quote-to-cash',
    'razorpay'         => 'Payments and UPI for India',
    'mixpanel'         => 'Funnel and product analytics behind lifecycle stages',
    'posthog'          => 'Product analytics, feature flags and session replay',
    'looker'           => 'Governed metrics, retention and lifetime value dashboards',
    'powerbi'          => 'Reporting inside Microsoft estates',
    'openai'           => 'Drafting, classification and conversational qualification',
    'anthropic'        => 'Long-context drafting, agents and approval workflows',
    'googlegemini'     => 'Multimodal generation and Google Cloud integration',
    'replicate'        => 'Hosted image and video models for variant production',
    'huggingface'      => 'Open models and datasets for tuning and evaluation',
    'modal'            => 'Serverless GPUs for bursty batch generation',
    'python'           => 'Scoring, propensity, churn and mix models',
    'scikitlearn'      => 'Classical models: scoring, clustering, forecasting',
    'n8n'              => 'Self-hosted automation with AI steps and approvals',
    'make'             => 'Visual automations with branching logic',
    'zapier'           => 'Quick automations between marketing tools',
    'temporal'         => 'Durable journeys that survive a failure mid-flight',
    'cloudflare'       => 'Edge delivery, DNS and sender authentication records',
    'vercel'           => 'Hosting for campaign and landing page front ends',
    'figma'            => 'Templates, tokens and the component library',
    'miro'             => 'Journey mapping and workshop boards',
];
/* which capabilities lean on each technology, from data/marketing-technology.php */
$stk_used = [];
foreach ($CAPS as $stk_cs => $stk_c) { foreach ($stk_c['stack'] as $stk_t) { $stk_used[$stk_t][] = $stk_cs; } }
$stk_total = 0;
foreach ($stk_layers as $stk_l) { $stk_total += count($stk_l[2]); }
$stk_first = 'hubspot';
$stk_all = xt_stack_data();
$stk_cats = xt_categories();
/* the mark beside a printed name: the library's SVG, or a mono monogram (never a drawn substitute) */
$stk_mark = function (string $stk_s, int $stk_px) use ($stk_all): string {
    if (!empty($stk_all[$stk_s]['file'])) return xt_logo($stk_s, ['size' => $stk_px, 'hidden' => true]);
    $stk_w = preg_split('/[\s.\-]+/', trim($stk_all[$stk_s]['name'] ?? $stk_s), -1, PREG_SPLIT_NO_EMPTY);
    $stk_m = count($stk_w) > 1 ? mb_substr($stk_w[0], 0, 1) . mb_substr($stk_w[1], 0, 1) : mb_substr($stk_w[0] ?? $stk_s, 0, 2);
    return '<span class="mth-stk__mono" aria-hidden="true">' . e($stk_m) . '</span>';
};
$stk_layer_of = [];
foreach ($stk_layers as $stk_l) { foreach ($stk_l[2] as $stk_s) { $stk_layer_of[$stk_s] = $stk_l[1]; } }
?>
<section class="band band--alt mth-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The stack</p>
        <h2 class="h2" id="stack-t"><span class="g">The stack that acts on the record,</span> layer by layer.</h2>
      </div>
      <div>
        <p class="lead"><?= $stk_total ?> technologies across <?= count($stk_layers) ?> layers, from the tag that captures consent to the dashboard that reports lifetime value. We work in the platforms you already pay for and recommend a move only when a hard limit cannot be worked around.</p>
        <p class="mth-note"><b>Technologies we work with.</b> No partner, reseller or certification tier is implied by any mark on this page.</p>
      </div>
    </div>

    <div class="mth-stk" data-layer="all" data-rv data-rv-d="60">
      <div class="mth-stk__filter">
        <p class="mth-k mth-stk__fk">Layer</p>
        <div class="mth-stk__cats" role="group" aria-label="Filter the stack by layer">
          <button type="button" class="mth-stk__cat" data-layer="all" aria-pressed="true">All layers <b><?= $stk_total ?></b></button>
          <?php foreach ($stk_layers as $stk_l): ?>
            <button type="button" class="mth-stk__cat" data-layer="<?= e($stk_l[0]) ?>" aria-pressed="false"><?= e($stk_l[1]) ?> <b><?= count($stk_l[2]) ?></b></button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="mth-stk__body">
        <div class="mth-stk__main">
          <p class="bdh-sr">Use the arrow keys to move between technologies. The selected technology is described in the panel after the list.</p>
          <div class="mth-stk__rows" role="listbox" aria-label="Marketing technologies we work with">
            <?php foreach ($stk_layers as $stk_li => $stk_l): ?>
              <div class="mth-stk__row" role="group" data-layer="<?= e($stk_l[0]) ?>" aria-label="<?= e($stk_l[1]) ?>, <?= count($stk_l[2]) ?> technologies">
                <p class="mth-stk__lk" aria-hidden="true"><b><?= str_pad((string) ($stk_li + 1), 2, '0', STR_PAD_LEFT) ?></b><span><?= e($stk_l[1]) ?></span><i><?= count($stk_l[2]) ?></i></p>
                <div class="mth-stk__set" role="none">
                  <?php foreach ($stk_l[2] as $stk_s): $stk_on = $stk_s === $stk_first; ?>
                    <span class="mth-stk__cell" role="option" tabindex="<?= $stk_on ? '0' : '-1' ?>" aria-selected="<?= $stk_on ? 'true' : 'false' ?>"
                          data-tech="<?= e($stk_s) ?>" data-name="<?= e($stk_all[$stk_s]['name'] ?? $stk_s) ?>"
                          data-layerl="<?= e($stk_l[1]) ?>" data-use="<?= e($stk_use[$stk_s] ?? $stk_l[1]) ?>"
                          data-caps="<?= e(implode(',', $stk_used[$stk_s] ?? [])) ?>">
                      <span class="mth-stk__mk"><?= $stk_mark($stk_s, 20) ?></span>
                      <span class="mth-stk__n"><?= e($stk_all[$stk_s]['name'] ?? $stk_s) ?></span>
                    </span>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <p class="mth-note mth-stk__gap"><b>What is not shown.</b> Customer data platforms, consent management platforms, reverse ETL and activation tools, enterprise email platforms and loyalty platforms are all part of this work. Our mark library has no licence-clean logo for them yet, so they are named in a brief rather than drawn here.</p>
        </div>

        <aside class="mth-stk__side">
          <div class="mth-stk__detail bdh-sticky" aria-live="polite">
            <p class="mth-k mth-stk__dk">Selected</p>
            <div class="mth-stk__dtop">
              <span class="mth-stk__dmark" data-d="mark"><?= $stk_mark($stk_first, 32) ?></span>
              <div>
                <h3 class="mth-stk__dn" data-d="name"><?= e($stk_all[$stk_first]['name']) ?></h3>
                <p class="mth-stk__dc" data-d="layer"><?= e($stk_layer_of[$stk_first]) ?></p>
              </div>
            </div>
            <p class="mth-k">What we use it for</p>
            <p class="mth-stk__du" data-d="use"><?= e($stk_use[$stk_first]) ?></p>
            <p class="mth-k">Capabilities that lean on it</p>
            <p class="mth-stk__dl" data-d="caps">
              <?php foreach ($CAPS as $stk_cs => $stk_c): ?>
                <a class="mth-capl" href="<?= e(($MTH['cap_href'])($stk_cs)) ?>" data-cap="<?= e($stk_cs) ?>"<?= in_array($stk_cs, $stk_used[$stk_first] ?? [], true) ? '' : ' hidden' ?>><b><?= e($stk_c['n']) ?></b><?= e($stk_c['short']) ?><i aria-hidden="true">›</i></a>
              <?php endforeach; ?>
              <span class="mth-stk__none" data-d="none" hidden>Used across engagements as needed; no capability leads with it.</span>
            </p>
            <p class="mth-stk__hint">Choose any mark. Marks belong to their owners and show technologies we work with.</p>
          </div>
        </aside>
      </div>
    </div>
  </div>
</section>
