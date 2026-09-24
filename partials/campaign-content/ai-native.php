<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* AI in the production loop, shown as a flow (.cch-flow) and an audit log. */
$cch_flow = [   // [icon, name, who, detail]
    ['doc',            'Brief',            'Person',   'Idea, kit rules, claims and audience'],
    ['agent',          'Draft variants',   'Agent',    'Copy lengths, crops and languages'],
    ['eval',           'Brand check',      'Eval',     'Type, lockup, contrast, tone'],
    ['shield',         'Claims & disclosure', 'Guardrail', 'Substantiation, #ad, AI label'],
    ['approve',        'Approval',         'Person',   'A named editor signs off'],
    ['log',            'Publish & log',    'System',   'Every asset traceable'],
];
$cch_log = [
    ['09:02:14', 'agent',  'variants.generate', 'kv-v3 → 48 drafts · en, hi, ar'],
    ['09:02:51', 'eval',   'brand.check',       '46 pass · 2 fail (headline overflow 9:16)'],
    ['09:03:05', 'guard',  'claims.check',      '“saves ten minutes” → evidence ref #C-12 attached'],
    ['09:03:06', 'guard',  'disclosure.check',  'creator cut-downs → “#ad” + paid-partnership label'],
    ['09:41:30', 'human',  'approve',           'Editor approved 44 · rejected 2 · note left'],
    ['09:41:31', 'system', 'publish.queue',     '44 assets → ad platforms · audit id a7f3…'],
];
?>
<section class="band band--alt cch-ai" id="ai-native" aria-labelledby="ai-native-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>AI-native production</p>
        <h2 class="h2" id="ai-native-t"><span class="g">Agents draft the variants.</span> People approve every one that ships.</h2></div>
      <div><p class="lead">Generative tools make the forty-eighth version cheap. We use them for the repetitive work — lengths, crops, languages, metadata — inside a pipeline with automated checks, a guardrail for claims and disclosure, and a human sign-off that is logged.</p></div>
    </div>

    <ol class="cch-flow" data-bdh-stagger data-bdh-in>
      <?php foreach ($cch_flow as $cch_i => $cch_f): ?>
      <li class="cch-flow__n bdh-up<?= $cch_f[2] === 'Person' ? ' is-human' : '' ?>">
        <span class="cch-flow__ico"><?= xt_icon($cch_f[0]) ?></span>
        <span class="cch-flow__who bdh-ro"><?= e($cch_f[2]) ?></span>
        <span class="cch-flow__t"><?= e($cch_f[1]) ?></span>
        <span class="cch-flow__d"><?= e($cch_f[3]) ?></span>
      </li>
      <?php endforeach; ?>
    </ol>

    <div class="cch-ai__g">
      <div class="cch-ai__log bdh-ui bdh-ui--ink" aria-hidden="true">
        <div class="cch-ai__lh bdh-ro"><span><i class="cch-dot"></i>Production log · Your brand · launch</span><span>Illustrative</span></div>
        <ol>
          <?php foreach ($cch_log as $cch_r): ?>
          <li class="cch-ai__lr is-<?= $cch_r[1] ?>"><span class="cch-ai__ts"><?= e($cch_r[0]) ?></span><span class="cch-ai__ev"><?= e($cch_r[2]) ?></span><span class="cch-ai__msg"><?= e($cch_r[3]) ?></span></li>
          <?php endforeach; ?>
        </ol>
      </div>
      <p class="bdh-sr">Illustrative production log: an agent drafts 48 variants from the master key visual; a brand check passes 46 and fails 2; guardrails attach evidence to a product claim and add advertising disclosure to creator cut-downs; an editor approves 44 and rejects 2; 44 assets are queued to publish with an audit id.</p>
      <div class="cch-ai__rules">
        <div class="cch-card cch-card--flat">
          <h3 class="cch-card__t">What AI does here</h3>
          <ul class="cch-card__l"><li>Drafts copy lengths, crops and language versions from an approved master</li><li>Checks every variant against the kit before a person sees it</li><li>Writes alt text, captions and metadata for review</li><li>Summarises comments, search and social listening for the brief</li></ul>
        </div>
        <div class="cch-card cch-card--flat">
          <h3 class="cch-card__t">What it never does</h3>
          <ul class="cch-card__l"><li>Publish without a named person's approval</li><li>Invent a claim, a quote, a statistic or a customer</li><li>Generate a real person's likeness or voice without written consent</li><li>Hide that content is AI-generated where law, platform or your policy requires a label</li></ul>
        </div>
      </div>
    </div>
  </div>
</section>
