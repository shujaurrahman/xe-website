<?php /* DRAFT COPY — review before launch */
/* End matter — who wrote it, how it was checked, where to go next. The share block repeats here
   because the rail is off-screen by the time anyone has finished reading, and on phones it never
   existed. Prev/next move through the journal in publication order, newest first. */
$end_desk = $POST['desk_row'];
$end_disc = isset($DISCS[$end_desk['discipline'] ?? '']) ? $DISCS[$end_desk['discipline']] : null;
?>
<section class="band band--alt blg-end" id="about-this" aria-labelledby="about-this-t">
  <div class="wrap">
    <div class="blg-end__grid">

      <div class="blg-end__desk">
        <p class="lbl lbl--blue"><span class="dot"></span>Who wrote this</p>
        <h2 class="h2 blg-end__h" id="about-this-t"><span class="g">Written by the people</span> who do the work.</h2>
        <div class="blg-end__card">
          <span class="blg-end__mark" aria-hidden="true"><?= e($end_desk['mark'] ?? 'XE') ?></span>
          <div>
            <h3 class="bdh-t"><?= e($end_desk['name'] ?? $SITE['company']['name']) ?></h3>
            <p class="bdh-d"><?= e($end_desk['line'] ?? '') ?></p>
            <?php if ($end_disc): ?>
              <a class="tl blg-end__go" href="<?= xe_discipline_url($end_disc) ?>">See what the practice does <span class="i" aria-hidden="true">›</span></a>
            <?php endif; ?>
          </div>
        </div>
        <!-- PLACEHOLDER: replace the desk byline with the named author and their role before launch. -->
        <p class="blg-end__note">Posts are attributed to the practice that produced them until the named-author byline is switched on.</p>

        <ul class="blg-end__std">
          <li><b>Checked before publishing.</b> Technical claims are reviewed by someone who did not write the post.</li>
          <li><b>Corrections are visible.</b> A substantive change adds an updated date and a note saying what moved.</li>
          <li><b>No client is named without written permission,</b> and no number is published without it either.</li>
        </ul>
      </div>

      <div class="blg-end__share">
        <?php $blg_share_variant = 'end'; include __DIR__ . '/share.php'; ?>

        <?php if (!empty($POST['tags'])): ?>
          <div class="blg-end__tags">
            <p class="blg-k">Filed under</p>
            <ul class="bdh-tags">
              <?php foreach ($POST['tags'] as $end_tag): ?>
                <li><a class="bdh-tag" href="<?= e(blog_home(['tag' => $end_tag]) . '#index') ?>"><?= e($BLG['tags'][$end_tag] ?? $end_tag) ?></a></li>
              <?php endforeach; ?>
              <?php foreach ($POST['disciplines'] as $end_ds): if (!isset($DISCS[$end_ds])) continue; ?>
                <li><a class="bdh-tag" href="<?= e(blog_home(['discipline' => $end_ds]) . '#index') ?>"><?= e($DISCS[$end_ds]['short']) ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php if ($REL): ?>
<section class="band blg-rel" id="related" aria-labelledby="related-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Keep reading</p>
        <h2 class="h2" id="related-t"><span class="g">Closest to this,</span> by topic and discipline.</h2>
      </div>
      <div><a class="btn btn--out" href="<?= e(blog_home()) ?>">All of the journal <span class="i" aria-hidden="true">›</span></a></div>
    </div>

    <ul class="blg-rel__l" data-rv-s data-rv-step="70">
      <?php foreach ($REL as $end_p): ?>
        <li class="blg-rel__i">
          <?php if ($end_p['live']): ?><a class="blg-rel__a bdh-zoom" href="<?= e($end_p['url']) ?>"><?php else: ?><span class="blg-rel__a is-pending"><?php endif; ?>
            <span class="bdh-img bdh-img--r169 blg-rel__img">
              <img src="<?= xe_url('assets/imgs/blog/' . $end_p['cover']['file']) ?>" alt="" width="<?= (int) $end_p['cover']['w'] ?>" height="<?= (int) $end_p['cover']['h'] ?>" loading="lazy" decoding="async"
                   <?= !empty($end_p['cover']['pos']) ? 'style="object-position:' . e($end_p['cover']['pos']) . '"' : '' ?>>
            </span>
            <span class="blg-rel__meta"><span class="blg-rel__type"><?= e($end_p['type_row']['name']) ?></span><span><?= (int) $end_p['minutes'] ?> min</span></span>
            <span class="bdh-t blg-rel__t"><?= e($end_p['title']) ?></span>
            <span class="bdh-d blg-rel__d"><?= e($end_p['dek']) ?></span>
            <span class="blg-rel__go"><?= $end_p['live'] ? 'Read' : 'Page pending' ?><i aria-hidden="true">›</i></span>
          <?php if ($end_p['live']): ?></a><?php else: ?></span><?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>

    <?php if ($NEIGH['prev'] || $NEIGH['next']): ?>
      <nav class="blg-pn" aria-label="More posts">
        <?php if ($NEIGH['prev'] && $NEIGH['prev']['live']): ?>
          <a class="blg-pn__a blg-pn__a--prev" href="<?= e($NEIGH['prev']['url']) ?>">
            <span class="blg-k">Newer</span><span class="blg-pn__t"><?= e($NEIGH['prev']['title']) ?></span>
          </a>
        <?php else: ?><span class="blg-pn__a is-off"><span class="blg-k">Newer</span><span class="blg-pn__t">This is the most recent post.</span></span><?php endif; ?>
        <?php if ($NEIGH['next'] && $NEIGH['next']['live']): ?>
          <a class="blg-pn__a blg-pn__a--next" href="<?= e($NEIGH['next']['url']) ?>">
            <span class="blg-k">Older</span><span class="blg-pn__t"><?= e($NEIGH['next']['title']) ?></span>
          </a>
        <?php else: ?><span class="blg-pn__a is-off"><span class="blg-k">Older</span><span class="blg-pn__t">This is the earliest post.</span></span><?php endif; ?>
      </nav>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
