<?php /* DRAFT COPY — review before launch */
/* Programme index — the page's centre. Substantial photographic cards, filtered by discipline and by
   sector. The filter is a plain GET form: with JavaScript off the Apply button reloads the page and
   the server renders the matching set; with JavaScript on, index.js filters in place, keeps the
   counts and the status line live and rewrites the URL. Only programmes whose case page exists are
   linked — the rest carry their notes inline, so nothing on the site points at a page that is not
   there. The last tile is the slot the next real programme drops into. */
require_once __DIR__ . '/thumbs.php';

$wrk_total = count($wrk_cases);
$wrk_shown = 0;
foreach ($wrk_cases as $wrk_c) if ($wrk_match($wrk_c, $wrk_fd, $wrk_fi)) $wrk_shown++;
$wrk_qs = fn (string $wrk_d, string $wrk_i): string
    => xe_url('work.php') . (($wrk_d || $wrk_i) ? '?' . http_build_query(array_filter(['d' => $wrk_d, 'i' => $wrk_i])) : '') . '#programmes';
?>
<section class="band band--alt wrk-idx" id="programmes" aria-labelledby="programmes-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Programme index · <?= $wrk_total ?></p>
        <h2 class="h2" id="programmes-t"><span class="g">Filter by discipline</span> or by sector.</h2>
      </div>
      <div>
        <p class="lead">Every programme on this page, in the order it was added. Each one leads with a plate from the work, then the brief, the disciplines involved and how long it typically runs. Durations are typical ranges, not commitments.</p>
      </div>
    </div>

    <form class="wrk-filter" action="<?= xe_url('work.php') ?>#programmes" method="get" data-wrk-filter aria-labelledby="programmes-t">
      <fieldset class="wrk-filter__set">
        <legend class="bdh-ro">Discipline</legend>
        <div class="wrk-filter__opts">
          <label class="wrk-opt"><input type="radio" name="d" value=""<?= $wrk_fd === '' ? ' checked' : '' ?>><span>All disciplines <b class="wrk-opt__n" data-n><?= wrk_count_d($wrk_cases, '', $wrk_fi) ?></b></span></label>
          <?php foreach ($wrk_disc as $wrk_slug => $wrk_d): ?>
          <label class="wrk-opt"><input type="radio" name="d" value="<?= e($wrk_slug) ?>"<?= $wrk_fd === $wrk_slug ? ' checked' : '' ?>><span><?= e($wrk_d['short'] ?? $wrk_d['name']) ?> <b class="wrk-opt__n" data-n><?= wrk_count_d($wrk_cases, $wrk_slug, $wrk_fi) ?></b></span></label>
          <?php endforeach; ?>
        </div>
      </fieldset>

      <fieldset class="wrk-filter__set">
        <legend class="bdh-ro">Sector</legend>
        <div class="wrk-filter__opts">
          <label class="wrk-opt"><input type="radio" name="i" value=""<?= $wrk_fi === '' ? ' checked' : '' ?>><span>All sectors <b class="wrk-opt__n" data-n><?= wrk_count_i($wrk_cases, '', $wrk_fd) ?></b></span></label>
          <?php foreach ($WRK['industries'] as $wrk_k => $wrk_name): ?>
          <label class="wrk-opt"><input type="radio" name="i" value="<?= e($wrk_k) ?>"<?= $wrk_fi === $wrk_k ? ' checked' : '' ?>><span><?= e($wrk_name) ?> <b class="wrk-opt__n" data-n><?= wrk_count_i($wrk_cases, $wrk_k, $wrk_fd) ?></b></span></label>
          <?php endforeach; ?>
        </div>
      </fieldset>

      <div class="wrk-filter__foot">
        <p class="wrk-filter__status" role="status" aria-live="polite" data-wrk-status>Showing <?= $wrk_shown ?> of <?= $wrk_total ?> programmes</p>
        <button class="btn btn--ink wrk-filter__go" type="submit">Apply filters</button>
        <a class="tl wrk-filter__reset" href="<?= $wrk_qs('', '') ?>" data-wrk-reset>Clear filters</a>
      </div>
    </form>

    <p class="wrk-empty" data-wrk-empty<?= $wrk_shown ? ' hidden' : '' ?>>No programme on this page matches that combination yet. <a class="tl" href="<?= $wrk_qs('', '') ?>" data-wrk-reset>Clear the filters</a>, or <a class="tl" href="<?= xe_url('contact.php') ?>">ask us about it directly</a> — the shelf is deeper than the page.</p>

    <ol class="wrk-grid">
      <?php foreach ($wrk_cases as $wrk_n => $wrk_c):
          $wrk_on   = $wrk_match($wrk_c, $wrk_fd, $wrk_fi);
          $wrk_url  = $wrk_has($wrk_c['slug']) ? xe_url('work/' . $wrk_c['slug'] . '.php') : '';
          $wrk_lbl  = wrk_thumb_label($wrk_c['slug']);
      ?>
      <li class="wrk-card<?= $wrk_url ? ' bdh-zoom' : '' ?>" id="<?= e($wrk_c['slug']) ?>" data-d="<?= e(implode(' ', array_column($wrk_c['did'], 0))) ?>" data-i="<?= e($wrk_c['industry']) ?>"<?= $wrk_on ? '' : ' hidden' ?>>
        <article aria-labelledby="<?= e($wrk_c['slug']) ?>-t">
          <!-- PLACEHOLDER: reference plate (assets/imgs/work/CREDITS.md) — replace with this programme's own photograph -->
          <?= wrk_img($wrk_c['img'], ['ratio' => 'r43', 'class' => 'wrk-card__img',
              'inner' => '<span class="wrk-card__sector bdh-ro">' . e($WRK['industries'][$wrk_c['industry']]) . '</span>'
                       . ($wrk_lbl ? '<span class="wrk-card__art bdh-ro"><i class="bdh-pulse"></i>' . e($wrk_lbl) . '</span>' : '')
                       . '<span class="wrk-frame wrk-frame--s" aria-hidden="true"><i></i><i></i><i></i><i></i></span>']) ?>

          <div class="wrk-card__body">
            <p class="wrk-card__top">
              <span class="wrk-card__n bdh-ro"><?= wrk_n($wrk_n + 1) ?></span>
              <span class="wrk-card__dur bdh-ro"><?= xt_icon('clock', ['size' => 14]) ?><span class="sr">Typical duration: </span><?= e($wrk_c['duration']) ?></span>
            </p>

            <h3 class="wrk-card__t" id="<?= e($wrk_c['slug']) ?>-t">
              <?php if ($wrk_url): ?><a href="<?= $wrk_url ?>"><?= e($wrk_c['title']) ?><span class="wrk-card__hit"></span></a><?php else: ?><?= e($wrk_c['title']) ?><?php endif; ?>
            </h3>
            <p class="wrk-card__brief"><?= e($wrk_c['brief']) ?></p>

            <ul class="wrk-card__chips" aria-label="Disciplines involved">
              <?php foreach ($wrk_c['did'] as $wrk_x): $wrk_d = $wrk_disc[$wrk_x[0]] ?? null; if (!$wrk_d) continue; ?>
              <li><span class="bdh-tag"><?= e($wrk_d['short'] ?? $wrk_d['name']) ?></span></li>
              <?php endforeach; ?>
            </ul>

            <p class="wrk-card__sys"><span class="bdh-ro wrk-card__syl">The system</span><?= e($wrk_c['system']) ?></p>

            <?php if ($wrk_url): ?>
              <p class="wrk-card__go"><span class="tl">Read the case<span class="i" aria-hidden="true">›</span></span></p>
            <?php else: ?>
              <details class="wrk-card__more">
                <summary><span>Programme notes</span><span class="wrk-card__plus" aria-hidden="true"></span></summary>
                <div class="wrk-card__notes">
                  <div><h4 class="bdh-ro">Deliverables</h4><ul class="bdh-bullets"><?php foreach ($wrk_c['deliverables'] as $wrk_x): ?><li><?= e($wrk_x) ?></li><?php endforeach; ?></ul></div>
                  <div><h4 class="bdh-ro">Measured by</h4><ul class="bdh-bullets"><?php foreach ($wrk_c['measure'] as $wrk_x): ?><li><?= e($wrk_x) ?></li><?php endforeach; ?></ul></div>
                  <!-- PLACEHOLDER: results pending client approval — confirm before launch -->
                  <p class="wrk-pending bdh-ro"><?= xt_icon('lock', ['size' => 14]) ?>Results · available under NDA, pending client approval</p>
                </div>
              </details>
            <?php endif; ?>
          </div>
        </article>
      </li>
      <?php endforeach; ?>

      <!-- The slot the next real programme drops into. Adding one: append an entry to data/work.php
           and copy work/<slug>.php from any existing case page. Nothing else needs editing. -->
      <li class="wrk-card wrk-card--slot">
        <article aria-labelledby="wrk-slot-t">
          <div class="wrk-slot__plate" aria-hidden="true">
            <span class="wrk-slot__grid"></span>
            <span class="wrk-slot__mark"><?= xt_icon('target', ['size' => 28]) ?></span>
            <span class="wrk-slot__ro bdh-ro">your programme · plate</span>
          </div>
          <div class="wrk-card__body">
            <p class="wrk-card__top"><span class="wrk-card__n bdh-ro"><?= wrk_n($wrk_total + 1) ?></span><span class="bdh-ill">Next</span></p>
            <h3 class="wrk-card__t" id="wrk-slot-t">Your programme goes here</h3>
            <p class="wrk-card__brief">Tell us the brief in one line. We will reply with how we would approach it, which disciplines it needs, and what the first eight weeks would produce.</p>
            <p class="wrk-card__go"><a class="btn btn--ink" href="<?= xe_url('contact.php') ?>">Share a brief <span class="i" aria-hidden="true">›</span></a></p>
          </div>
        </article>
      </li>
    </ol>

    <!-- PLACEHOLDER: confirm the real portfolio count and the sectors it covers before launch -->
    <p class="wrk-idx__note"><?= $wrk_total ?> programme<?= $wrk_total === 1 ? '' : 's' ?> <?= $wrk_total === 1 ? 'is' : 'are' ?> published here. The set we can discuss is larger; a walk-through under NDA covers the ones that are not on a public page.</p>
  </div>
</section>
<?= wrk_invalid($WRK) ?>
