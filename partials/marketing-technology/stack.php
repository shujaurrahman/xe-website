<?php /* DRAFT COPY — review before launch */
/* The platforms this discipline builds on, grouped by the layer they serve. Every slug is used by at least one
   capability in data/marketing-technology.php. */
$mth_st_groups = [
    ['Engagement & CRM',             'Where customers are known and reached.',                      ['hubspot', 'salesforce', 'zoho', 'intercom', 'twilio', 'whatsapp', 'slack', 'microsoftteams']],
    ['Data & measurement',           'Events, the warehouse and the models that read it.',           ['googletagmanager', 'googleanalytics', 'google', 'googlebigquery', 'snowflake', 'dbt', 'airbyte', 'posthog', 'mixpanel', 'looker', 'powerbi', 'postgresql']],
    ['Content, commerce & design',   'What is said, sold and shown, from one source.',               ['contentful', 'sanity', 'strapi', 'wordpress', 'webflow', 'algolia', 'shopify', 'stripe', 'razorpay', 'cloudflare', 'vercel', 'figma', 'miro']],
    ['AI & orchestration',           'Models, pipelines and the workflows that call them.',          ['openai', 'anthropic', 'googlegemini', 'replicate', 'huggingface', 'modal', 'python', 'scikitlearn', 'n8n', 'make', 'zapier', 'temporal']],
];
$mth_st_n = array_sum(array_map(fn ($mth_g) => count($mth_g[2]), $mth_st_groups));
?>
<section class="band mth-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The stack</p>
        <h2 class="h2" id="stack-t"><span class="g">Your platforms, used properly.</span> Replaced only when they cannot do the job.</h2>
      </div>
      <div><p class="lead">We work across <?= $mth_st_n ?> technologies and choose on fit, total cost and what your team can run. Named here as technologies we work with, not as partnerships.</p></div>
    </div>
    <div class="mth-stack__grid">
      <?php foreach ($mth_st_groups as $mth_st_i => $mth_st): ?>
      <div class="mth-stack__g">
        <div class="mth-stack__h">
          <span class="bdh-idx"><?= sprintf('%02d', $mth_st_i + 1) ?></span>
          <h3 class="bdh-t"><?= e($mth_st[0]) ?></h3>
          <span class="mth-stack__c bdh-ro"><?= count($mth_st[2]) ?></span>
        </div>
        <p class="bdh-d"><?= e($mth_st[1]) ?></p>
        <?= xt_stack($mth_st[2], ['variant' => 'chips', 'label' => $mth_st[0]]) ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
