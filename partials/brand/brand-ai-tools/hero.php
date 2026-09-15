<?php /* DRAFT COPY — review before launch */
/* 01 Hero — the machine room, running. Left: breadcrumb, h1, lead, meta.
   Right: a pipeline status board — six stages with job counts, queues and a log stream.
   The HTML is a complete frame; hero.js ticks counts, moves queues and streams log lines. */
$cat_stages = [   // [stage, what runs, count, unit, state, who]
    ['Training set',    'Reference curated',      '2,418', 'refs',     'Locked · v7',         'agent'],
    ['Tuned model',     'Image model',            'v4.2',  'weights',  'Gate passed',         'agent'],
    ['Generation',      'Variants in flight',     '146',   'jobs',     'Running',             'agent'],
    ['Brand check',     'Colour · space · tone',  '139',   'checked',  '7 flagged',           'agent'],
    ['Human review',    'Brand lead signs off',   '12',    'waiting',  'People decide',       'person'],
    ['Publish',         'Formats × markets',      '54',    'live',     'Logged',              'agent'],
];
$cat_log = [   // [time, stage, line]
    ['09:41:02', 'gen',    'variant 0412-c · Product C · Market 03 · 4:5 · done 3.8s'],
    ['09:41:03', 'check',  'colour ΔE 1.2 ✓  clear space ✓  tone 0.91 ✓  rights ✓'],
    ['09:41:03', 'queue',  '0412-c → review · owner: Brand lead'],
    ['09:41:05', 'check',  '0412-f · clear space 62% of rule ✕ · auto-fix proposed'],
    ['09:41:06', 'review', '0409-a approved by Brand lead · note attached'],
    ['09:41:07', 'pub',    '0409-a → 6 formats × 9 markets · credentials signed'],
];
$cat_crumb_hub = xe_discipline_url($BRAND);
?>
<section class="cat-room cat-hero" id="top" aria-labelledby="hero-t" data-bdh-live>
  <span class="cat-room__grid" aria-hidden="true"></span>
  <div class="wrap cat-hero__in">
    <div class="cat-hero__text">
      <nav class="cat-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= xe_url('services/') ?>">Services</a></li>
          <li><a href="<?= $cat_crumb_hub ?>"><?= e($BRAND['name']) ?></a></li>
          <li aria-current="page"><?= e($CAT['name']) ?></li>
        </ol>
      </nav>
      <p class="cat-prompt"><b>~/brand-design</b> <span>capability <?= e($CAT['n']) ?> of <?= count($BRAND['caps']) ?> · <?= e($CAT['kicker']) ?></span></p>
      <h1 class="cat-hero__h" id="hero-t"><?= $CAT['title'] ?></h1>
      <p class="lead cat-hero__lead"><?= e($CAT['lead']) ?></p>
      <div class="cat-hero__act">
        <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>"><?= e($CAT['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--white btn--lg cat-hero__run" href="#playground">Watch a run <span class="i" aria-hidden="true">›</span></a>
      </div>
      <dl class="cat-hero__meta">
        <?php foreach ($CAT['meta'] as $cat_mi => $cat_mv): ?>
          <div><dt><?= e($CAT['meta_k'][$cat_mi] ?? '') ?></dt><dd><?= e($cat_mv) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>

    <div class="cat-board" aria-hidden="true">
      <!-- PLACEHOLDER: illustrative pipeline, counts and log lines — confirm before launch -->
      <div class="cat-board__bar">
        <span class="cat-led cat-led--pulse"></span>
        <span class="cat-board__path">pipeline<i>/</i>your-brand<i>/</i>prod</span>
        <span class="cat-board__run">run <b data-cat-run>0412</b></span>
        <span class="cat-illus">Illustrative</span>
      </div>

      <div class="cat-board__body">
        <!-- PLACEHOLDER: reference photography (Unsplash) — replace with own studio capture before launch -->
        <figure class="cat-board__feed">
          <img src="<?= xe_url('assets/imgs/brand/brand-ai-tools/studio-lighting.jpg') ?>" alt="" width="680" height="1000" fetchpriority="high" decoding="async">
          <figcaption><span class="cat-led cat-led--pulse"></span>studio 2 · rec</figcaption>
          <i class="cat-board__scan"></i>
        </figure>

        <ol class="cat-board__stages">
          <?php foreach ($cat_stages as $cat_si => $cat_st): ?>
            <li class="cat-board__st<?= $cat_st[5] === 'person' ? ' is-person' : '' ?>" style="--i:<?= $cat_si ?>">
              <span class="cat-board__n"><?= sprintf('%02d', $cat_si + 1) ?></span>
              <span class="cat-board__name"><b><?= e($cat_st[0]) ?></b><small><?= e($cat_st[1]) ?></small></span>
              <span class="cat-board__q"><i></i><i></i><i></i><i></i></span>
              <span class="cat-board__c"><b data-cat-count><?= e($cat_st[2]) ?></b><small><?= e($cat_st[3]) ?></small></span>
              <span class="cat-board__state"><span class="cat-led<?= $cat_st[5] === 'person' ? ' cat-led--wait' : '' ?>"></span><?= e($cat_st[4]) ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <ol class="cat-board__log" data-cat-log>
        <?php foreach ($cat_log as $cat_ln): ?>
          <li><time><?= e($cat_ln[0]) ?></time><b><?= e($cat_ln[1]) ?></b><span><?= e($cat_ln[2]) ?></span></li>
        <?php endforeach; ?>
      </ol>
    </div>
    <p class="bdh-sr">Illustration: a brand content pipeline in six stages — training set, tuned model, generation, automated brand check, human review by a brand lead, and publish — with job counts and a streaming run log.</p>
  </div>
</section>
