<?php /* DRAFT COPY — review before launch */
/* Skills — a depth matrix used as the stack showcase. Each row is a technology with its mark;
   the three cells are the depths we staff at (working, senior, lead/architect) shaded by current
   availability. Filter chips narrow the matrix by area. Availability shading is illustrative. */
$ttw_sk_areas = [
    'frontend' => 'Web &amp; frontend',
    'mobile'   => 'Mobile',
    'backend'  => 'Backend &amp; languages',
    'data'     => 'Data &amp; streaming',
    'ai'       => 'AI &amp; ML',
    'cloud'    => 'Cloud &amp; DevOps',
    'quality'  => 'Quality &amp; delivery',
];
/* slug, area, [working, senior, lead] where 3 = deep bench, 2 = available, 1 = limited, 0 = by request */
$ttw_sk = [
    ['react',              'frontend', [3, 3, 2]],
    ['nextdotjs',          'frontend', [3, 3, 2]],
    ['angular',            'frontend', [3, 2, 1]],
    ['tailwindcss',        'frontend', [3, 3, 2]],
    ['flutter',            'mobile',   [3, 2, 2]],
    ['reactnative',        'mobile',   [3, 2, 1]],
    ['swift',              'mobile',   [2, 2, 1]],
    ['kotlin',             'mobile',   [2, 2, 1]],
    ['nodedotjs',          'backend',  [3, 3, 3]],
    ['python',             'backend',  [3, 3, 3]],
    ['go',                 'backend',  [2, 2, 2]],
    ['springboot',         'backend',  [2, 2, 1]],
    ['dotnet',             'backend',  [2, 1, 1]],
    ['laravel',            'backend',  [3, 2, 1]],
    ['postgresql',         'data',     [3, 3, 2]],
    ['mongodb',            'data',     [3, 2, 2]],
    ['apachekafka',        'data',     [2, 2, 1]],
    ['snowflake',          'data',     [2, 1, 1]],
    ['databricks',         'data',     [2, 1, 1]],
    ['pytorch',            'ai',       [2, 2, 1]],
    ['anthropic',          'ai',       [3, 2, 2]],
    ['openai',             'ai',       [3, 2, 2]],
    ['langgraph',          'ai',       [2, 2, 1]],
    ['amazonwebservices',  'cloud',    [3, 3, 2]],
    ['microsoftazure',     'cloud',    [2, 2, 1]],
    ['googlecloud',        'cloud',    [2, 2, 1]],
    ['kubernetes',         'cloud',    [2, 2, 2]],
    ['terraform',          'cloud',    [2, 2, 1]],
    ['playwright',         'quality',  [3, 2, 2]],
    ['cypress',            'quality',  [3, 2, 1]],
    ['github',             'quality',  [3, 3, 2]],
    ['figma',              'quality',  [2, 2, 1]],
];
$ttw_sk_depth = ['Working', 'Senior', 'Lead / architect'];
$ttw_sk_avail = [0 => 'By request', 1 => 'Limited', 2 => 'Available', 3 => 'Deep bench'];
?>
<section class="band band--alt ttw-skl" id="skills" aria-labelledby="skills-t">
  <div class="wrap">

    <header class="ttw-head ttw-head--wide" data-rv>
      <div class="ttw-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>Skills matrix</p>
        <h2 class="h2" id="skills-t"><span class="g">Skills across the stack,</span> by depth.</h2>
      </div>
      <div class="ttw-head__l">
        <p class="lead">We staff at three depths. Working means the engineer is productive in your codebase from week one; senior means they set the patterns others follow; lead means they can own the architecture and the review bar. These are technologies we work with, not partnerships.</p>
      </div>
    </header>

    <div class="ttw-skl__bar">
      <!-- The filters ship disabled and skills.js enables them: with JS off every technology is
           listed, which is the honest default, and nothing invites a click that does nothing. -->
      <div class="ttw-skl__filters" role="group" aria-label="Filter the matrix by area">
        <button type="button" class="ttw-btn ttw-skl__f" data-ttw-area="all" aria-pressed="true" disabled>All areas <span class="ttw-skl__fn"><?= count($ttw_sk) ?></span></button>
        <?php foreach ($ttw_sk_areas as $ttw_sk_k => $ttw_sk_n):
            $ttw_sk_c = count(array_filter($ttw_sk, fn ($r) => $r[1] === $ttw_sk_k)); ?>
          <button type="button" class="ttw-btn ttw-skl__f" data-ttw-area="<?= e($ttw_sk_k) ?>" aria-pressed="false" disabled><?= $ttw_sk_n ?> <span class="ttw-skl__fn"><?= (int) $ttw_sk_c ?></span></button>
        <?php endforeach; ?>
      </div>
      <p class="ttw-skl__legend">
        <span class="ttw-ill">Illustrative availability</span>
        <?php foreach ([3, 2, 1] as $ttw_sk_l): ?>
          <span class="ttw-skl__lg"><i class="ttw-skl__sw" data-l="<?= $ttw_sk_l ?>" aria-hidden="true"></i><?= e($ttw_sk_avail[$ttw_sk_l]) ?></span>
        <?php endforeach; ?>
      </p>
    </div>

    <div class="ttw-skl__matrix" data-bdh-in data-ttw-arm data-ttw-skl>
      <p class="ttw-skl__cols" aria-hidden="true">
        <?php for ($ttw_sk_g = 0; $ttw_sk_g < 2; $ttw_sk_g++): ?>
          <span class="ttw-skl__cg<?= $ttw_sk_g ? ' ttw-skl__cg--2' : '' ?>">
            <span class="ttw-skl__cn">Technology</span>
            <?php foreach ($ttw_sk_depth as $ttw_sk_d): ?><span class="ttw-skl__cd"><?= e($ttw_sk_d) ?></span><?php endforeach; ?>
          </span>
        <?php endfor; ?>
      </p>
      <ul class="ttw-skl__rows" role="list">
        <?php foreach ($ttw_sk as $ttw_sk_r):
            $ttw_sk_t = xt_tech($ttw_sk_r[0]);
            if (!$ttw_sk_t) continue;
            /* Only draw a mark where a licence-clean SVG exists. Without one xt_logo() falls back to a
               wordmark, which would print the technology name twice beside the label below. */
            $ttw_sk_mk = !empty($ttw_sk_t['file'])
                ? xt_logo($ttw_sk_r[0], ['size' => 20, 'hidden' => true])
                : '<span class="ttw-skl__dot" aria-hidden="true"></span>'; ?>
          <li class="ttw-skl__row" data-area="<?= e($ttw_sk_r[1]) ?>">
            <span class="ttw-skl__t"><?= $ttw_sk_mk ?><span class="ttw-skl__tn"><?= e($ttw_sk_t['name']) ?></span></span>
            <?php foreach ($ttw_sk_r[2] as $ttw_sk_i => $ttw_sk_l): ?>
              <span class="ttw-skl__c" data-l="<?= (int) $ttw_sk_l ?>" style="--c:<?= (int) $ttw_sk_i ?>">
                <span class="bdh-sr"><?= e($ttw_sk_depth[$ttw_sk_i]) ?>: <?= e($ttw_sk_avail[$ttw_sk_l]) ?></span>
                <i aria-hidden="true"></i>
              </span>
            <?php endforeach; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <p class="ttw-skl__note">Shading shows how readily we can staff that depth today and is reviewed monthly. <!-- PLACEHOLDER: confirm bench availability before launch --> Ask for a named engineer profile in any cell and we will send the scorecard. <a class="tl" href="<?= xe_url('contact.php') ?>?from=tech-workforce">Ask for profiles <span class="i" aria-hidden="true">›</span></a></p>

  </div>
</section>
