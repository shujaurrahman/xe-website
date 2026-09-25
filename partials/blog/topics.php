<?php /* DRAFT COPY — review before launch */
/* The map — what the journal actually covers, counted rather than claimed. Topics on the left with a
   bar apiece and the disciplines each one crosses; sectors on the right. Every row is a link into the
   index with that filter already applied, so the map is navigation as well as a picture of coverage.
   Rows with nothing in them are shown, dimmed: a gap in coverage is information too. */
$tpc_max = 1;
$tpc_rows = [];
foreach ($BLG['tags'] as $tpc_key => $tpc_name) {
    $tpc_n = blog_count(['tag' => $tpc_key]);
    $tpc_d = [];
    foreach ($POSTS as $tpc_p) {
        if (!in_array($tpc_key, $tpc_p['tags'], true)) continue;
        foreach ($tpc_p['disciplines'] as $tpc_s) if (isset($DISCS[$tpc_s])) $tpc_d[$tpc_s] = $DISCS[$tpc_s]['short'];
    }
    $tpc_rows[$tpc_key] = ['name' => $tpc_name, 'n' => $tpc_n, 'd' => $tpc_d];
    $tpc_max = max($tpc_max, $tpc_n);
}
uasort($tpc_rows, fn (array $tpc_a, array $tpc_b): int => $tpc_b['n'] <=> $tpc_a['n']);

$tpc_secs = [];
foreach ($BLG['industries'] as $tpc_key => $tpc_name) $tpc_secs[$tpc_key] = ['name' => $tpc_name, 'n' => blog_count(['industry' => $tpc_key])];
uasort($tpc_secs, fn (array $tpc_a, array $tpc_b): int => $tpc_b['n'] <=> $tpc_a['n']);
?>
<section class="band blg-map" id="topics" aria-labelledby="topics-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The map</p>
        <h2 class="h2" id="topics-t"><span class="g">What the journal covers,</span> counted rather than claimed.</h2>
      </div>
      <div><p class="lead">Every count below is the live number of posts, not an ambition. Empty rows are left in: a topic with nothing under it says more than a topic quietly removed.</p></div>
    </div>

    <div class="blg-map__grid">
      <div class="blg-map__col" data-bdh-in>
        <p class="blg-k blg-map__ck">Topics · <?= count($tpc_rows) ?></p>
        <ul class="blg-map__l">
          <?php foreach ($tpc_rows as $tpc_key => $tpc_row): ?>
            <li class="blg-map__r<?= $tpc_row['n'] === 0 ? ' is-empty' : '' ?>">
              <?php if ($tpc_row['n'] > 0): ?><a href="<?= e(blog_home(['tag' => $tpc_key]) . '#index') ?>"><?php else: ?><span><?php endif; ?>
                <span class="blg-map__name"><?= e($tpc_row['name']) ?></span>
                <span class="blg-map__bar" aria-hidden="true"><i class="bdh-grow" style="--w:<?= round($tpc_row['n'] / $tpc_max * 100) ?>%;--i:<?= (int) $tpc_row['n'] ?>"></i></span>
                <span class="blg-map__n"><?= (int) $tpc_row['n'] ?></span>
                <span class="blg-map__d"><?= $tpc_row['d'] ? e(implode(' · ', $tpc_row['d'])) : 'nothing published yet' ?></span>
              <?php if ($tpc_row['n'] > 0): ?></a><?php else: ?></span><?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="blg-map__col blg-map__col--sec">
        <p class="blg-k blg-map__ck">Sectors · <?= count($tpc_secs) ?></p>
        <ul class="blg-map__sl">
          <?php foreach ($tpc_secs as $tpc_key => $tpc_row): ?>
            <li class="blg-map__sr<?= $tpc_row['n'] === 0 ? ' is-empty' : '' ?>">
              <?php if ($tpc_row['n'] > 0): ?><a href="<?= e(blog_home(['industry' => $tpc_key]) . '#index') ?>"><?php else: ?><span><?php endif; ?>
                <b><?= (int) $tpc_row['n'] ?></b><?= e($tpc_row['name']) ?>
              <?php if ($tpc_row['n'] > 0): ?></a><?php else: ?></span><?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>

        <p class="blg-k blg-map__ck">Disciplines</p>
        <ul class="blg-map__sl">
          <?php foreach ($DISCS as $tpc_slug => $tpc_d): $tpc_n = blog_count(['discipline' => $tpc_slug]); ?>
            <li class="blg-map__sr<?= $tpc_n === 0 ? ' is-empty' : '' ?>">
              <?php if ($tpc_n > 0): ?><a href="<?= e(blog_home(['discipline' => $tpc_slug]) . '#index') ?>"><?php else: ?><span><?php endif; ?>
                <b><?= (int) $tpc_n ?></b><?= e($tpc_d['name']) ?>
              <?php if ($tpc_n > 0): ?></a><?php else: ?></span><?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>
