<?php /* DRAFT COPY — review before launch */
/* Stack — the tools this discipline actually works in, grouped by the job they do, rendered with
   xt_stack() from partials/tech/kit.php. Technologies we work with, never partnerships. Every slug is
   one of the capabilities' own 'stack' lists in data/product-experience.php. */
/* [group name, xt_icon name, technology slugs, the capabilities it serves]
   The group mark is an icon rather than one of the logos: a logo would read as a preferred vendor,
   and several of these tools have no licence-clean mark, so the kit falls back to a wordmark that
   does not sit on a heading line. */
$stk_groups = [
    ['Design &amp; prototyping',            'layers',   ['figma', 'miro', 'storybook'],                                         ['design-consulting-solutioning', 'experience-design-development']],
    ['Front end',                        'code',     ['react', 'nextdotjs', 'typescript', 'tailwindcss'],                    ['experience-design-development']],
    ['Research &amp; product analytics',     'chart',    ['posthog', 'mixpanel', 'googleanalytics', 'looker'],                   ['product-strategy-vision', 'experience-design-development']],
    ['Quality, access &amp; performance',    'check',    ['playwright', 'cypress', 'jest', 'lighthouse', 'pagespeedinsights'],   ['experience-design-development', 'system-design']],
    ['AI in the product',                'sparkle',  ['anthropic', 'openai', 'googlegemini', 'langgraph', 'llamaindex', 'pgvector', 'python'], ['ai-product-strategy-development']],
    ['Systems &amp; platform exports',       'cube',     ['github', 'githubactions', 'swift', 'kotlin', 'supabase'],             ['system-design']],
    ['Evidence from your own systems',   'database', ['hubspot', 'salesforce', 'semrush'],                                    ['product-strategy-vision']],
    ['Ways of working',                  'workflow', ['notion', 'confluence', 'jira', 'linear'],                              ['design-consulting-solutioning']],
];
$stk_all = [];
foreach ($stk_groups as $stk_g) { $stk_all = array_merge($stk_all, $stk_g[2]); }
$stk_all = array_values(array_unique($stk_all));
$stk_name = fn (string $stk_s): array => [$CAPS[$stk_s]['n'], $CAPS[$stk_s]['short']];
?>
<section class="band band--ink pxh-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The stack</p>
        <h2 class="h2" id="stack-t"><span class="g">Yours where you have one.</span> Ours where you do not.</h2>
      </div>
      <div>
        <p class="lead">These are the tools the work runs in, grouped by the job they do. They are technologies we work with, not partnerships, and the list is not a requirement: where you already have something that does the job, we use yours and hand the work back in it.</p>
        <p class="pxh-stack__count"><span class="pxh-k">In this list</span><b><?= count($stk_all) ?></b> tools · <b><?= count($stk_groups) ?></b> jobs</p>
      </div>
    </div>

    <div class="pxh-stack__grid">
      <?php foreach ($stk_groups as $stk_i => $stk_g): ?>
        <div class="pxh-stack__group" data-rv data-rv-d="<?= ($stk_i % 4) * 40 ?>">
          <div class="pxh-stack__gh">
            <span class="pxh-stack__gm" aria-hidden="true"><?= xt_icon($stk_g[1], ['size' => 20]) ?></span>
            <p class="pxh-stack__gt"><?= $stk_g[0] ?></p>
            <p class="pxh-stack__gc">
              <?php foreach ($stk_g[3] as $stk_c): [$stk_n, $stk_sh] = $stk_name($stk_c); ?>
                <a class="pxh-capl" href="#<?= e($stk_c) ?>"><b><?= e($stk_n) ?></b><span><?= e($stk_sh) ?></span><i aria-hidden="true">›</i></a>
              <?php endforeach; ?>
            </p>
          </div>
          <?= xt_stack($stk_g[2], ['variant' => 'tiles', 'label' => strip_tags($stk_g[0]) . ' tools', 'class' => 'pxh-stack__tiles']) ?>
        </div>
      <?php endforeach; ?>
    </div>

    <p class="pxh-note pxh-stack__note">Design files, tokens, component packages, research repositories and front-end code are created in your accounts and your repositories, so nothing important lives only with us. Where a tool has to be ours for the duration of a project, the handover plan says which one and what happens to the data in it.</p>
  </div>
</section>
