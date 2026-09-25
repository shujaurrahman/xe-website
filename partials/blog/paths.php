<?php /* DRAFT COPY — review before launch */
/* Reading paths — a curated order rather than a chronology. Each path is a short run of posts with a
   connector between them and the time the whole run takes, so a reader can commit to it knowingly.
   Posts whose page file does not exist yet appear in the run without a link, never as a dead end. */
$pth_paths = [];
foreach ($BLG['paths'] as $pth_key => $pth_row) {
    $pth_items = [];
    $pth_min   = 0;
    foreach ($pth_row['order'] as $pth_slug) {
        $pth_p = blog_post($pth_slug);
        if (!$pth_p) continue;
        $pth_items[] = $pth_p;
        $pth_min += $pth_p['minutes'];
    }
    if ($pth_items) $pth_paths[$pth_key] = $pth_row + ['items' => $pth_items, 'minutes' => $pth_min];
}
?>
<section class="band blg-paths" id="paths" aria-labelledby="paths-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Reading paths</p>
        <h2 class="h2" id="paths-t"><span class="g">Three routes through,</span> in the order that makes sense.</h2>
      </div>
      <div><p class="lead">Publication date is a filing system, not an argument. These are short runs put in the order a reader would want them, each ending somewhere useful.</p></div>
    </div>

    <ol class="blg-paths__l" data-rv-s data-rv-step="80">
      <?php $pth_n = 1; foreach ($pth_paths as $pth_key => $pth_row): ?>
        <li class="blg-paths__i">
          <article class="blg-path">
            <header class="blg-path__top">
              <span class="blg-path__n" aria-hidden="true"><?= e(str_pad((string) $pth_n, 2, '0', STR_PAD_LEFT)) ?></span>
              <h3 class="blg-path__t"><?= e($pth_row['name']) ?></h3>
              <p class="blg-path__len"><?= count($pth_row['items']) ?> <?= count($pth_row['items']) === 1 ? 'post' : 'posts' ?> · <?= (int) $pth_row['minutes'] ?> min</p>
            </header>
            <p class="blg-path__d"><?= e($pth_row['line']) ?></p>

            <ol class="blg-path__steps">
              <?php foreach ($pth_row['items'] as $pth_i => $pth_p): ?>
                <li class="blg-path__step">
                  <span class="blg-path__dot" aria-hidden="true"></span>
                  <?php if ($pth_p['live']): ?><a class="blg-path__a" href="<?= e($pth_p['url']) ?>"><?php else: ?><span class="blg-path__a is-pending"><?php endif; ?>
                    <span class="blg-path__st"><?= e($pth_p['title']) ?></span>
                    <span class="blg-path__sm"><?= e($pth_p['type_row']['short']) ?> · <?= (int) $pth_p['minutes'] ?> min<?= $pth_p['live'] ? '' : ' · page pending' ?></span>
                  <?php if ($pth_p['live']): ?></a><?php else: ?></span><?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ol>
          </article>
        </li>
      <?php $pth_n++; endforeach; ?>
    </ol>
  </div>
</section>
