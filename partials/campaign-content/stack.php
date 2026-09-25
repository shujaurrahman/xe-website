<?php /* DRAFT COPY — review before launch */ ?>
<?php
$cch_groups = [   // [title, what it is for, slugs]
    ['Plan & measure', 'Audiences, search demand, attribution and incrementality.', ['googleanalytics', 'googletagmanager', 'googlebigquery', 'looker', 'semrush', 'ahrefs', 'googlesearchconsole', 'mixpanel', 'posthog']],
    ['Design & produce', 'The kit of parts, templates and the production board.', ['figma', 'storybook', 'miro', 'notion', 'jira']],
    ['Publish & run', 'Content platforms, CRM and the channels campaigns land in.', ['wordpress', 'contentful', 'sanity', 'webflow', 'hubspot', 'salesforce', 'shopify', 'google', 'whatsapp']],
    ['AI & automation', 'Variant drafting, checks and the workflows around them.', ['openai', 'anthropic', 'googlegemini', 'perplexity', 'replicate', 'n8n', 'zapier']],
];
?>
<section class="band cch-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Platforms we work in</p>
        <h2 class="h2" id="stack-t"><span class="g">Your stack, not ours.</span> We plan, make and measure in the tools you already run.</h2></div>
      <div><p class="lead">Technologies we work with day to day, grouped by the job they do in a campaign. Named as tools we use, not as partnerships.</p></div>
    </div>
    <div class="cch-stack__g">
      <?php foreach ($cch_groups as $cch_i => $cch_g): ?>
      <div class="cch-stack__c" data-rv>
        <p class="bdh-idx"><?= sprintf('%02d', $cch_i + 1) ?></p>
        <h3 class="h3 cch-stack__t"><?= e($cch_g[0]) ?></h3>
        <p class="sm cch-stack__d"><?= e($cch_g[1]) ?></p>
        <?= xt_stack(array_values(array_filter($cch_g[2], fn ($cch_s) => isset($STACK[$cch_s]))), ['variant' => 'chips', 'label' => $cch_g[0] . ' technologies']) ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
