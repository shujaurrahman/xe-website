<?php /* DRAFT COPY — review before launch */
/* The desks. Bylines here are practices rather than named people until the owner confirms who is
   publishing under their own name, so this section says so plainly instead of implying a newsroom. */
$dsk_rows = [];
foreach ($BLG['desks'] as $dsk_key => $dsk_row) {
    $dsk_n = 0;
    $dsk_last = null;
    foreach ($POSTS as $dsk_p) {
        if ($dsk_p['desk'] !== $dsk_key) continue;
        $dsk_n++;
        if ($dsk_last === null) $dsk_last = $dsk_p;
    }
    $dsk_rows[$dsk_key] = $dsk_row + ['n' => $dsk_n, 'last' => $dsk_last];
}
?>
<section class="band band--alt blg-desks" id="desks" aria-labelledby="desks-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The desks</p>
        <h2 class="h2" id="desks-t"><span class="g">Written by the practice</span> that did the work.</h2>
      </div>
      <div><p class="lead">Nothing in the journal is commissioned from outside or generated and posted unread. A post is drafted by the people who did the work, edited for clarity, and checked by someone who did not write it.</p></div>
    </div>

    <ul class="blg-desks__l" data-rv-s data-rv-step="80">
      <?php foreach ($dsk_rows as $dsk_key => $dsk_row): $dsk_d = $DISCS[$dsk_row['discipline']] ?? null; ?>
        <li class="blg-desks__i">
          <article class="bdh-card bdh-card--lift blg-desk">
            <header class="blg-desk__top">
              <span class="blg-desk__mark" aria-hidden="true"><?= e($dsk_row['mark']) ?></span>
              <span class="blg-desk__n"><?= (int) $dsk_row['n'] ?> <?= $dsk_row['n'] === 1 ? 'post' : 'posts' ?></span>
            </header>
            <h3 class="bdh-t blg-desk__t"><?= e($dsk_row['name']) ?></h3>
            <p class="bdh-d blg-desk__d"><?= e($dsk_row['line']) ?></p>

            <?php if ($dsk_row['last']): ?>
              <p class="blg-desk__last">
                <span class="blg-k">Most recent</span>
                <?php if ($dsk_row['last']['live']): ?>
                  <a class="blg-a" href="<?= e($dsk_row['last']['url']) ?>"><?= e($dsk_row['last']['title']) ?></a>
                <?php else: ?><?= e($dsk_row['last']['title']) ?><?php endif; ?>
              </p>
            <?php else: ?>
              <p class="blg-desk__last"><span class="blg-k">Most recent</span>Nothing published yet.</p>
            <?php endif; ?>

            <?php if ($dsk_d): ?>
              <a class="tl blg-desk__go" href="<?= xe_discipline_url($dsk_d) ?>">What this practice does <span class="i" aria-hidden="true">›</span></a>
            <?php endif; ?>
          </article>
        </li>
      <?php endforeach; ?>
    </ul>

    <!-- PLACEHOLDER: confirm named-author bylines, roles and photographs before launch. -->
    <p class="blg-desks__note">Bylines are practices, not people. Named authors go on the posts once the owner has confirmed who publishes under their own name.</p>
  </div>
</section>
