<?php /* DRAFT COPY — review before launch */
/* Stack — the platforms this discipline actually works in, grouped by the job they do rather than by
   vendor. The list is exactly the union of the eight capabilities' 'stack' arrays in
   data/campaign-content.php, so the page and the capability cards can never disagree, and the count
   in the head is computed from it. Marks are rendered by xt_stack (partials/tech/kit.php).
   Presented as technologies we work with — never as a partnership, reseller or certification tier. */
$sk_groups = [
    ['Research and visibility', ['semrush', 'ahrefs', 'googlesearchconsole', 'google', 'schemaorg', 'perplexity'],
     'Search demand, competitor coverage and citation behaviour read in one place, so rankings and AI answers sit in one report against one baseline.'],
    ['Content and CMS', ['wordpress', 'contentful', 'sanity', 'webflow', 'storybook'],
     'Headless where content has many surfaces, the familiar editor where it has one. Components and tokens kept in step with the campaign system.'],
    ['Design and production', ['figma', 'miro', 'replicate', 'huggingface'],
     'Figma is the source of truth for tokens, master templates and sized artwork. Generative tools sit inside the production pipeline, never at the end of it.'],
    ['Models and automation', ['openai', 'anthropic', 'googlegemini', 'n8n', 'zapier', 'make'],
     'Model-agnostic: chosen per task and switched when the evidence changes. Automation runs the repetitive steps, with a person on every approval.'],
    ['Measurement and data', ['googleanalytics', 'googletagmanager', 'googlebigquery', 'looker', 'powerbi', 'posthog', 'mixpanel', 'dbt', 'snowflake'],
     'One definition of every metric, in a warehouse you own, with consent carried from the banner to the conversion API.'],
    ['CRM, commerce and conversation', ['hubspot', 'salesforce', 'shopify', 'whatsapp'],
     'We integrate the systems your teams already run rather than replacing them, so campaign data lands where sales and service can see it.'],
    ['Ways of working', ['notion', 'jira', 'linear', 'github', 'slack', 'cloudflare'],
     'Your tools, your rituals, your approvals, with one decision log for the programme so nothing important lives only in a thread.'],
];
$sk_all = [];
foreach ($sk_groups as $sk_g) { foreach ($sk_g[1] as $sk_s) { $sk_all[] = $sk_s; } }
/* which capability cards lean on each platform — printed as a count, so the section stays honest */
$sk_used = [];
foreach ($CAPS as $sk_cs => $sk_c) { foreach ($sk_c['stack'] as $sk_t) { $sk_used[$sk_t][] = $sk_cs; } }
?>
<section class="band cch-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Platforms</p>
        <h2 class="h2" id="stack-t"><span class="g"><?= count($sk_all) ?> platforms,</span> grouped by the job they do.</h2>
      </div>
      <div>
        <!-- PLACEHOLDER: confirm this platform list reflects current team experience before launch -->
        <p class="lead">The tools this discipline works in every week, across seven jobs: finding demand, publishing, producing, generating, measuring, joining up and running the work. Most engagements use your instance of these, not ours.</p>
        <p class="cch-note"><b>Technologies we work with.</b> No partner, reseller or certification tier is implied by any mark on this page.</p>
      </div>
    </div>

    <div class="cch-sk__marquee" data-rv data-rv-d="40">
      <?= xt_stack($sk_all, ['variant' => 'row', 'marquee' => true, 'size' => 22, 'speed' => 80, 'label' => 'Platforms we work in', 'class' => 'cch-sk__mq mask-x']) ?>
    </div>

    <div class="cch-sk__groups" data-rv data-rv-d="80">
      <?php foreach ($sk_groups as $sk_gi => $sk_g): ?>
        <div class="cch-sk__group">
          <div class="cch-sk__gh">
            <p class="cch-sk__gn"><span><?= str_pad((string) ($sk_gi + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($sk_g[0]) ?><em><?= count($sk_g[1]) ?></em></p>
            <p class="cch-sk__gd"><?= e($sk_g[2]) ?></p>
          </div>
          <?= xt_stack($sk_g[1], ['variant' => 'chips', 'size' => 18, 'label' => $sk_g[0], 'class' => 'cch-sk__chips']) ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
