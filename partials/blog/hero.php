<?php /* DRAFT COPY — review before launch */
/* Journal masthead. Text left; right, an "issue plate" — the newest entries set as a typographic
   index over a photographic plate, the way a contents page reads. Everything is in the HTML at its
   finished value; hero.js only rules the index line under the pointer and ticks the clock line. */
$hro_latest = array_slice($POSTS, 0, 4, true);
$hro_types  = ['article' => 0, 'case-study' => 0];
$hro_discs  = [];
$hro_words  = 0;
foreach ($POSTS as $hro_p) {
    $hro_types[$hro_p['type']] = ($hro_types[$hro_p['type']] ?? 0) + 1;
    $hro_words += $hro_p['words'];
    foreach ($hro_p['disciplines'] as $hro_s) $hro_discs[$hro_s] = true;
}
?>
<section class="blg-hero" id="top" aria-labelledby="hero-t">
  <span class="blg-hero__bg dots" aria-hidden="true"></span>

  <div class="wrap blg-hero__in">
    <div class="blg-hero__text">
      <p class="lbl lbl--blue blg-hero__up" style="--i:0"><span class="dot"></span>The Journal</p>
      <h1 class="blg-hero__h blg-hero__up" id="hero-t" style="--i:1"><span class="g">Notes on the work,</span> written by the people doing it.</h1>
      <p class="lead blg-hero__lead blg-hero__up" style="--i:2">Two kinds of writing, one standard. Articles set out how we build and why, with the working shown. Case studies follow a single programme from the problem to what the client kept. Nothing here is a press release.</p>

      <div class="blg-hero__act blg-hero__up" style="--i:3">
        <a class="btn btn--ink" href="#index">Browse the journal <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out" href="#paths">Start with a reading path <span class="i" aria-hidden="true">›</span></a>
      </div>

      <dl class="blg-hero__proof blg-hero__up" style="--i:4">
        <div><dt>Posts</dt><dd><?= count($POSTS) ?></dd></div>
        <div><dt>Articles</dt><dd><?= (int) $hro_types['article'] ?></dd></div>
        <div><dt>Case studies</dt><dd><?= (int) $hro_types['case-study'] ?></dd></div>
        <div><dt>Disciplines</dt><dd><?= count($hro_discs) ?></dd></div>
      </dl>
    </div>

    <div class="blg-hero__vis">
      <!-- PLACEHOLDER: reference photograph (Unsplash) — replace with commissioned or own imagery before launch -->
      <figure class="bdh-img bdh-img--r43 blg-hero__photo" aria-hidden="true">
        <img src="<?= xe_url('assets/imgs/blog/journal-desk.jpg') ?>" alt="" width="1600" height="1066" decoding="async">
      </figure>

      <div class="blg-hero__plate" data-bdh-in>
        <div class="blg-hero__bar">
          <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="blg-hero__title">journal / index</span>
          <span class="blg-hero__count"><?= count($POSTS) ?> entries</span>
        </div>

        <ol class="blg-hero__idx" data-blg-hero-idx>
          <?php $hro_n = count($POSTS); foreach ($hro_latest as $hro_slug => $hro_p): ?>
            <li class="blg-hero__row" style="--i:<?= (int) ($hro_n - 1) ?>">
              <?php if ($hro_p['live']): ?><a href="<?= e($hro_p['url']) ?>"><?php else: ?><span class="is-pending"><?php endif; ?>
                <span class="blg-hero__rn" aria-hidden="true"><?= e(str_pad((string) $hro_n, 2, '0', STR_PAD_LEFT)) ?></span>
                <span class="blg-hero__rt"><?= e($hro_p['title']) ?></span>
                <span class="blg-hero__rk"><?= e($hro_p['type_row']['short']) ?></span>
                <span class="blg-hero__rd"><?= e(date('M Y', strtotime($hro_p['iso']))) ?></span>
              <?php if ($hro_p['live']): ?></a><?php else: ?></span><?php endif; ?>
            </li>
          <?php $hro_n--; endforeach; ?>
        </ol>

        <p class="blg-hero__foot">
          <span class="bdh-pulse" aria-hidden="true"></span>
          <span>Published in-house · reviewed before it goes out · corrections carry a date</span>
        </p>
      </div>
    </div>
  </div>
</section>
