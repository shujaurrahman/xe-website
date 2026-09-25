<?php /* DRAFT COPY — review before launch */
/* The reading layout. A rail on the left carries the contents, the position readout and the share
   block and sticks while the body scrolls; post.js highlights the section in view and keeps the
   readout honest. Below 1024px the rail collapses to a <details> above the text, which is open by
   default under no-JavaScript because nothing can close it. The body column is a single measure of
   about 68 characters; wide figures and pull quotes are the only things allowed out of it. */
$art_toc = $POST['toc'];
?>
<section class="band band--flush-t blg-read" id="read" aria-labelledby="read-t">
  <h2 class="bdh-sr" id="read-t"><?= e($POST['title']) ?> — the article</h2>
  <div class="wrap blg-read__in">

    <aside class="blg-rail" aria-label="Article tools">
      <div class="blg-rail__stick">
        <?php if ($art_toc): ?>
          <nav class="blg-toc" aria-labelledby="toc-t" data-blg-toc>
            <p class="blg-k" id="toc-t">Contents</p>
            <p class="blg-toc__pos" aria-hidden="true"><b data-blg-toc-at>01</b> / <?= e(str_pad((string) count($art_toc), 2, '0', STR_PAD_LEFT)) ?></p>
            <ol class="blg-toc__l">
              <?php foreach ($art_toc as $art_n => $art_row): ?>
                <li><a href="#<?= e($art_row[0]) ?>" data-blg-toc-a="<?= e($art_row[0]) ?>"><span aria-hidden="true"><?= e(str_pad((string) ($art_n + 1), 2, '0', STR_PAD_LEFT)) ?></span><?= e($art_row[1]) ?></a></li>
              <?php endforeach; ?>
            </ol>
          </nav>
        <?php endif; ?>

        <?php $blg_share_variant = 'rail'; include __DIR__ . '/share.php'; ?>
      </div>
    </aside>

    <div class="blg-body">
      <?php if ($art_toc): ?>
        <details class="blg-toc__m" open>
          <summary><span class="blg-k">In this article</span><span class="blg-toc__mn"><?= count($art_toc) ?> sections · <?= (int) $POST['minutes'] ?> min</span></summary>
          <ol class="blg-toc__ml">
            <?php foreach ($art_toc as $art_n => $art_row): ?>
              <li><a href="#<?= e($art_row[0]) ?>"><span aria-hidden="true"><?= e(str_pad((string) ($art_n + 1), 2, '0', STR_PAD_LEFT)) ?></span><?= e($art_row[1]) ?></a></li>
            <?php endforeach; ?>
          </ol>
        </details>
      <?php endif; ?>

      <?php blog_blocks($POST['body'], ['id_prefix' => 'sec', 'start' => 0]); ?>
    </div>
  </div>
</section>
