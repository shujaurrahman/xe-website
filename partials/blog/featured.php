<?php /* DRAFT COPY — review before launch */
/* The lead item. One post, given the room a cover deserves, with its own contents list printed
   beside it so a reader can judge the piece before opening it. The entry marked 'featured' in
   data/blog.php wins; with none marked, the newest post takes the slot. */
$ftr = null;
foreach ($POSTS as $ftr_p) { if (!empty($ftr_p['featured'])) { $ftr = $ftr_p; break; } }
if ($ftr === null) $ftr = reset($POSTS);
$ftr_desk = $ftr['desk_row'];
?>
<section class="band band--alt blg-lead" id="lead" aria-labelledby="lead-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Lead story</p>
        <h2 class="h2" id="lead-t"><span class="g">Start here</span> if you only read one.</h2>
      </div>
      <div><p class="lead">Chosen by the desk, not by traffic. It changes when something better is published.</p></div>
    </div>

    <article class="blg-lead__a" data-rv>
      <div class="blg-lead__fig bdh-zoom">
        <?php if ($ftr['live']): ?><a href="<?= e($ftr['url']) ?>" tabindex="-1" aria-hidden="true"><?php endif; ?>
          <span class="bdh-img bdh-img--r43 blg-lead__img" data-bdh-parallax="0.05">
            <img src="<?= xe_url('assets/imgs/blog/' . $ftr['cover']['file']) ?>" alt="<?= e($ftr['cover']['alt']) ?>"
                 width="<?= (int) $ftr['cover']['w'] ?>" height="<?= (int) $ftr['cover']['h'] ?>" loading="lazy" decoding="async"
                 <?= !empty($ftr['cover']['pos']) ? 'style="object-position:' . e($ftr['cover']['pos']) . '"' : '' ?>>
          </span>
        <?php if ($ftr['live']): ?></a><?php endif; ?>
        <span class="bdh-cap-chip blg-lead__chip"><b><?= e($ftr['type_row']['name']) ?></b><?= (int) $ftr['minutes'] ?> min read · <?= e($ftr['human']) ?></span>
      </div>

      <div class="blg-lead__text">
        <p class="blg-lead__kick">
          <?php foreach ($ftr['disciplines'] as $ftr_s): if (!isset($DISCS[$ftr_s])) continue; ?>
            <span><?= e($DISCS[$ftr_s]['name']) ?></span>
          <?php endforeach; ?>
        </p>

        <h3 class="blg-lead__h">
          <?php if ($ftr['live']): ?><a href="<?= e($ftr['url']) ?>"><?= e($ftr['title']) ?></a><?php else: ?><?= e($ftr['title']) ?><?php endif; ?>
        </h3>
        <p class="blg-lead__dek"><?= blog_inline($ftr['dek']) ?></p>

        <?php if (!empty($ftr['toc'])): ?>
          <div class="blg-lead__toc">
            <p class="blg-k">What is in it</p>
            <ol>
              <?php foreach (array_slice($ftr['toc'], 0, 6) as $ftr_n => $ftr_row): ?>
                <li><span aria-hidden="true"><?= e(str_pad((string) ($ftr_n + 1), 2, '0', STR_PAD_LEFT)) ?></span><?= e($ftr_row[1]) ?></li>
              <?php endforeach; ?>
              <?php if (count($ftr['toc']) > 6): ?>
                <li class="is-more"><span aria-hidden="true">+</span><?= count($ftr['toc']) - 6 ?> more</li>
              <?php endif; ?>
            </ol>
          </div>
        <?php endif; ?>

        <div class="blg-lead__foot">
          <p class="blg-lead__by"><span class="blg-lead__mark" aria-hidden="true"><?= e($ftr_desk['mark'] ?? 'XE') ?></span><?= e($ftr_desk['name'] ?? $SITE['company']['name']) ?></p>
          <?php if ($ftr['live']): ?>
            <a class="btn btn--ink" href="<?= e($ftr['url']) ?>">Read the <?= e(strtolower($ftr['type_row']['name'])) ?> <span class="i" aria-hidden="true">›</span></a>
          <?php else: ?>
            <span class="bdh-ill">Page pending</span>
          <?php endif; ?>
        </div>
      </div>
    </article>
  </div>
</section>
