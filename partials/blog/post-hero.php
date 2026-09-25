<?php /* DRAFT COPY — review before launch */
/* Post masthead. Two layouts from one set of parts: an article leads with the headline and a wide
   plate; a case study leads with a case-file record — sector, shape, duration, stage — set as a
   dossier beside the plate. The reading-progress rail is decorative and only becomes visible once
   post.js marks it, so with JavaScript off nothing empty is on screen. */
$pst_disc = [];
foreach ($POST['disciplines'] as $pst_slug) {
    if (isset($DISCS[$pst_slug])) $pst_disc[$pst_slug] = $DISCS[$pst_slug];
}
$pst_desk   = $POST['desk_row'];
$pst_series = isset($BLG['paths'][$POST['series'] ?? '']) ? $BLG['paths'][$POST['series']] : null;
$pst_ind    = $BLG['industries'][$POST['industry'] ?? ''] ?? '';
$pst_cover  = $POST['cover'];
?>
<div class="blg-prog" aria-hidden="true"><i class="blg-prog__bar"></i></div>

<section class="blg-mast<?= $IS_CASE ? ' blg-mast--case' : '' ?>" aria-labelledby="post-t">
  <span class="blg-mast__bg dots" aria-hidden="true"></span>
  <div class="wrap blg-mast__in">

    <nav class="blg-crumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="<?= xe_url('index.php') ?>">Home</a></li>
        <li><a href="<?= e(blog_home()) ?>">Journal</a></li>
        <li aria-current="page"><?= e($POST['type_row']['name']) ?></li>
      </ol>
    </nav>

    <div class="blg-mast__grid">
      <div class="blg-mast__text">
        <p class="lbl lbl--blue blg-mast__kick">
          <span class="dot"></span><?= e($POST['type_row']['name']) ?>
          <?php foreach ($pst_disc as $pst_row): ?><span class="blg-mast__sep" aria-hidden="true">·</span><?= e($pst_row['short']) ?><?php endforeach; ?>
        </p>

        <h1 class="blg-mast__h" id="post-t"><?= e($POST['title']) ?></h1>
        <p class="blg-mast__dek"><?= blog_inline($POST['dek']) ?></p>

        <?php if (!empty($POST['placeholder'])): ?>
          <!-- PLACEHOLDER: seed post — replace with a real, approved post before launch. -->
          <p class="blg-mast__ph"><b>Placeholder</b><?= e($POST['placeholder']) ?></p>
        <?php endif; ?>

        <div class="blg-byline">
          <span class="blg-byline__mark" aria-hidden="true"><?= e($pst_desk['mark'] ?? 'XE') ?></span>
          <div class="blg-byline__who">
            <p class="blg-byline__name"><?= e($pst_desk['name'] ?? 'Xterra Edze') ?></p>
            <p class="blg-byline__meta">
              <time datetime="<?= e($POST['iso']) ?>"><?= e($POST['human']) ?></time>
              <?php if (!empty($POST['updated'])): ?><span>Updated <time datetime="<?= e($POST['updated']) ?>"><?= e(date('j F Y', strtotime($POST['updated']))) ?></time></span><?php endif; ?>
              <span><?= (int) $POST['minutes'] ?> min read</span>
              <span><?= number_format((int) $POST['words']) ?> words</span>
            </p>
          </div>
        </div>

        <?php if (!$IS_CASE): ?>
          <ul class="blg-mast__tags bdh-tags" aria-label="Topics">
            <?php foreach ($POST['tags'] as $pst_tag): ?>
              <li><a class="bdh-tag blg-mast__tag" href="<?= e(blog_home(['tag' => $pst_tag]) . '#index') ?>"><?= e($BLG['tags'][$pst_tag] ?? $pst_tag) ?></a></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>

      <?php if ($IS_CASE): $pst_c = $POST['case']; ?>
        <div class="blg-file">
          <div class="blg-file__bar">
            <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
            <span class="blg-file__title">case file / <?= e($POST['slug']) ?></span>
            <span class="blg-file__ill">Illustration</span>
          </div>
          <dl class="blg-file__rec">
            <div><dt>Sector</dt><dd><?= e($pst_c['sector']) ?></dd></div>
            <div><dt>Shape</dt><dd><?= e($pst_c['shape']) ?></dd></div>
            <div><dt>Duration</dt><dd><?= e($pst_c['duration']) ?></dd></div>
            <div><dt>Stage</dt><dd><?= e($pst_c['stage']) ?></dd></div>
            <div><dt>Client</dt><dd>Not named — attributed to the sector only</dd></div>
          </dl>
          <div class="blg-file__disc">
            <p class="blg-k">Disciplines</p>
            <ul>
              <?php foreach ($pst_disc as $pst_slug => $pst_row): ?>
                <li><a class="tih-capl" href="<?= xe_discipline_url($pst_row) ?>"><b><?= e($pst_row['n']) ?></b><?= e($pst_row['name']) ?><i aria-hidden="true">›</i></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <figure class="blg-mast__fig">
      <span class="bdh-img bdh-img--r219 blg-mast__img">
        <img src="<?= xe_url('assets/imgs/blog/' . $pst_cover['file']) ?>" alt="<?= e($pst_cover['alt']) ?>"
             width="<?= (int) $pst_cover['w'] ?>" height="<?= (int) $pst_cover['h'] ?>" fetchpriority="high" decoding="async"
             <?= !empty($pst_cover['pos']) ? 'style="object-position:' . e($pst_cover['pos']) . '"' : '' ?>>
      </span>
      <figcaption class="blg-mast__cr">
        <span>Photograph · <?= e($pst_cover['credit']) ?> · Unsplash</span>
        <span>Reference imagery — not a photograph of this work</span>
      </figcaption>
    </figure>

    <?php if ($pst_series || $pst_ind): ?>
      <p class="blg-mast__path">
        <?php if ($pst_series): ?>
          <span class="blg-k">Reading path</span>
          <a class="tl" href="<?= e(blog_home() . '#paths') ?>"><?= e($pst_series['name']) ?> <span class="i" aria-hidden="true">›</span></a>
        <?php endif; ?>
        <?php if ($pst_ind): ?>
          <span class="blg-k">Sector</span>
          <a class="tl" href="<?= e(blog_home(['industry' => $POST['industry']]) . '#index') ?>"><?= e($pst_ind) ?> <span class="i" aria-hidden="true">›</span></a>
        <?php endif; ?>
      </p>
    <?php endif; ?>
  </div>
</section>
