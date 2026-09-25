<?php /* DRAFT COPY — review before launch */
/* Stack — the platforms each category tends to run on, from the shared kit (xt_stack, data/tech-stack.php).
   One marquee row of the whole picture, which scrolls only while on screen via [data-bdh-live], then the
   six categories with the technologies that come up most. The systems of record that cannot be replaced
   are listed in each brief above; this section is the part we choose. Static apart from the marquee. */
$ind_marquee = [
    'typescript', 'nextdotjs', 'react', 'python', 'postgresql', 'apachekafka', 'snowflake', 'clickhouse',
    'kubernetes', 'amazonwebservices', 'googlecloud', 'cloudflare', 'shopify', 'razorpay', 'stripe',
    'salesforce', 'hubspot', 'zoho', 'algolia', 'contentful', 'sanity', 'twilio', 'whatsapp',
    'anthropic', 'openai', 'pgvector', 'langgraph', 'posthog', 'googletagmanager', 'grafana',
    'opentelemetry', 'k6',
];
?>
<section class="band ind-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="ind-head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The systems</p>
        <h2 class="h2" id="stack-t"><span class="g">What each category</span> tends to run on.</h2>
      </div>
      <div>
        <p class="lead">Technologies we work with, grouped by where they actually come up. The systems of record named in each brief are the fixed points; this is the part that is a choice, and we make it on your team’s skills, your hosting constraints and what the category has to survive.</p>
        <p class="ind-note">Technologies we work with. Nothing here states or implies a partnership tier, a reseller status or a certification.</p>
      </div>
    </div>
  </div>

  <div class="ind-stack__marq" data-rv data-rv-d="40">
    <?= xt_stack($ind_marquee, ['variant' => 'row', 'marquee' => true, 'speed' => 78, 'label' => 'Technologies we work with across the six categories']) ?>
  </div>

  <div class="wrap">
    <div class="ind-stack__grid" data-rv-s data-rv-step="60">
      <?php foreach ($IND_SET as $ind_c): ?>
        <article class="ind-stack__cat">
          <header class="ind-stack__ch">
            <span class="ind-num"><?= e($ind_c['n']) ?></span>
            <h3 class="bdh-t"><?= e($ind_c['name']) ?></h3>
            <a class="ind-stack__jump" href="#<?= e($ind_c['slug']) ?>">Brief <i aria-hidden="true">›</i></a>
          </header>
          <?= xt_stack($ind_c['stack'], ['variant' => 'chips', 'size' => 16, 'label' => 'Technologies we work with in ' . $ind_c['name'], 'class' => 'ind-stack__chips']) ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
