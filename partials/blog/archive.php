<?php /* DRAFT COPY — review before launch */
/* The archive — everything, in one dense, scannable table, grouped by year. It is the one place on the
   page with no photography: a reader who knows what they are looking for should be able to find it in
   a single screen. Wide on a phone, so it scrolls sideways inside a labelled, focusable region. */
$arc_years = [];
foreach ($POSTS as $arc_p) $arc_years[date('Y', strtotime($arc_p['iso']))][] = $arc_p;
?>
<section class="band band--alt blg-arc" id="archive" aria-labelledby="archive-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Archive · <?= count($POSTS) ?></p>
        <h2 class="h2" id="archive-t"><span class="g">Everything published,</span> in one list.</h2>
      </div>
      <div><p class="lead">No covers, no excerpts. Date, type, title, the disciplines it belongs to and how long it takes to read.</p></div>
    </div>

    <?php foreach ($arc_years as $arc_year => $arc_rows): ?>
      <div class="blg-arc__yr">
        <p class="blg-arc__yn"><?= e($arc_year) ?><span><?= count($arc_rows) ?> <?= count($arc_rows) === 1 ? 'post' : 'posts' ?></span></p>

        <div class="bdh-scroll-x mask-x blg-arc__scroll" tabindex="0" role="group" aria-label="Posts published in <?= e($arc_year) ?> — scroll sideways to read every column">
          <table class="blg-arc__t">
            <caption class="bdh-sr">Everything published in <?= e($arc_year) ?>, newest first.</caption>
            <thead>
              <tr>
                <th scope="col">Date</th><th scope="col">Type</th><th scope="col">Title</th>
                <th scope="col">Disciplines</th><th scope="col">Sector</th><th scope="col">Read</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($arc_rows as $arc_p): ?>
                <tr>
                  <td class="blg-arc__d"><time datetime="<?= e($arc_p['iso']) ?>"><?= e(date('j M', strtotime($arc_p['iso']))) ?></time></td>
                  <td><span class="blg-arc__ty blg-arc__ty--<?= e($arc_p['type']) ?>"><?= e($arc_p['type_row']['short']) ?></span></td>
                  <th scope="row" class="blg-arc__ti">
                    <?php if ($arc_p['live']): ?>
                      <a class="blg-arc__a" href="<?= e($arc_p['url']) ?>"><?= e($arc_p['title']) ?><span class="blg-arc__i" aria-hidden="true">›</span></a>
                    <?php else: ?>
                      <?= e($arc_p['title']) ?><span class="bdh-ill blg-arc__pending">Page pending</span>
                    <?php endif; ?>
                  </th>
                  <td class="blg-arc__ds"><?php
                    $arc_names = [];
                    foreach ($arc_p['disciplines'] as $arc_s) if (isset($DISCS[$arc_s])) $arc_names[] = $DISCS[$arc_s]['short'];
                    echo e(implode(' · ', $arc_names));
                  ?></td>
                  <td><?= e($BLG['industries'][$arc_p['industry'] ?? ''] ?? '—') ?></td>
                  <td class="blg-arc__m"><?= (int) $arc_p['minutes'] ?> min</td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
