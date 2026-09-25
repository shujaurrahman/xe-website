<?php /* DRAFT COPY — review before launch */
/* The index — the working part of the page. A console of four radio groups (type, discipline, sector,
   topic) over a grid of every post.
   With JavaScript off this is an ordinary GET form: the server has already set [hidden] on the cards
   that do not match, the counts beside each option are server-rendered, and "Apply" reloads the page.
   With JavaScript on, index.js filters in place, recounts, updates the status line and rewrites the
   address — and hides the Apply button, which no longer has a job. */
$idx_opts = function (string $idx_key) use ($BLG, $DISCS): array {
    switch ($idx_key) {
        case 'type':       return array_map(fn ($idx_r) => $idx_r['name'], $BLG['types']);
        case 'discipline': return array_map(fn ($idx_r) => $idx_r['short'], $DISCS);
        case 'industry':   return $BLG['industries'];
        default:           return $BLG['tags'];
    }
};
$idx_groups = [
    'type'       => ['Type',       'All types'],
    'discipline' => ['Discipline', 'All disciplines'],
    'industry'   => ['Sector',     'Any sector'],
    'tag'        => ['Topic',      'Any topic'],
];
/* the count an option would show if it alone were changed — the same arithmetic index.js repeats */
$idx_count = function (string $idx_key, string $idx_val) use ($FILTER): int {
    return blog_count([$idx_key => $idx_val] + $FILTER);
};
$idx_total = count($POSTS);
$idx_any   = implode('', $FILTER) !== '';
?>
<section class="band band--alt blg-idx" id="index" aria-labelledby="index-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Everything published · <?= (int) $idx_total ?></p>
        <h2 class="h2" id="index-t"><span class="g">Filter by type, discipline,</span> sector or topic.</h2>
      </div>
      <div>
        <p class="lead">Four filters, applied together. They work without JavaScript — the address bar carries the state either way, so a filtered view can be sent to someone.</p>
      </div>
    </div>

    <form class="blg-flt" method="get" action="<?= e(blog_home()) ?>#index" data-blg-filter aria-labelledby="index-t">
      <div class="blg-flt__sets">
        <?php foreach ($idx_groups as $idx_key => $idx_meta): $idx_all = $idx_opts($idx_key); ?>
          <fieldset class="blg-flt__set" data-blg-group="<?= e($idx_key) ?>">
            <legend class="blg-k"><?= e($idx_meta[0]) ?></legend>
            <div class="blg-flt__opts">
              <label class="blg-opt<?= $FILTER[$idx_key] === '' ? ' is-on' : '' ?>">
                <input type="radio" name="<?= e($idx_key) ?>" value=""<?= $FILTER[$idx_key] === '' ? ' checked' : '' ?>>
                <span class="blg-opt__t"><?= e($idx_meta[1]) ?></span>
                <b class="blg-opt__n" data-blg-n><?= $idx_count($idx_key, '') ?></b>
              </label>
              <?php foreach ($idx_all as $idx_val => $idx_label): $idx_c = $idx_count($idx_key, (string) $idx_val); ?>
                <label class="blg-opt<?= $FILTER[$idx_key] === (string) $idx_val ? ' is-on' : '' ?><?= $idx_c === 0 ? ' is-empty' : '' ?>">
                  <input type="radio" name="<?= e($idx_key) ?>" value="<?= e((string) $idx_val) ?>"<?= $FILTER[$idx_key] === (string) $idx_val ? ' checked' : '' ?>>
                  <span class="blg-opt__t"><?= e($idx_label) ?></span>
                  <b class="blg-opt__n" data-blg-n><?= $idx_c ?></b>
                </label>
              <?php endforeach; ?>
            </div>
          </fieldset>
        <?php endforeach; ?>
      </div>

      <div class="blg-flt__bar">
        <p class="blg-flt__status" role="status" aria-live="polite" data-blg-status>
          Showing <b data-blg-shown><?= (int) $SHOWN ?></b> of <?= (int) $idx_total ?> posts<?= $idx_any ? ', filtered' : '' ?>.
        </p>
        <div class="blg-flt__acts">
          <a class="blg-flt__clear<?= $idx_any ? '' : ' is-off' ?>" href="<?= e(blog_home()) ?>#index" data-blg-clear>Clear filters</a>
          <button class="btn btn--out btn--sm blg-flt__go" type="submit" data-blg-apply>Apply <span class="i" aria-hidden="true">›</span></button>
        </div>
      </div>
    </form>

    <ol class="blg-grid" data-blg-grid>
      <?php foreach ($POSTS as $idx_slug => $idx_p):
        $idx_hit = blog_match($idx_p, $FILTER); ?>
        <li class="blg-grid__i" <?= $idx_hit ? '' : 'hidden' ?>
            data-type="<?= e($idx_p['type']) ?>"
            data-discipline="<?= e(implode(' ', $idx_p['disciplines'])) ?>"
            data-industry="<?= e($idx_p['industry'] ?? '') ?>"
            data-tag="<?= e(implode(' ', $idx_p['tags'])) ?>">
          <article class="blg-card blg-card--<?= e($idx_p['type']) ?>">
            <?php if ($idx_p['live']): ?><a class="blg-card__a bdh-zoom" href="<?= e($idx_p['url']) ?>"><?php else: ?><div class="blg-card__a is-pending"><?php endif; ?>
              <span class="bdh-img bdh-img--r169 blg-card__img">
                <img src="<?= xe_url('assets/imgs/blog/' . $idx_p['cover']['file']) ?>" alt="" width="<?= (int) $idx_p['cover']['w'] ?>" height="<?= (int) $idx_p['cover']['h'] ?>" loading="lazy" decoding="async"
                     <?= !empty($idx_p['cover']['pos']) ? 'style="object-position:' . e($idx_p['cover']['pos']) . '"' : '' ?>>
                <span class="blg-card__badge"><?= e($idx_p['type_row']['name']) ?></span>
              </span>

              <span class="blg-card__meta">
                <time datetime="<?= e($idx_p['iso']) ?>"><?= e(date('j M Y', strtotime($idx_p['iso']))) ?></time>
                <span><?= (int) $idx_p['minutes'] ?> min</span>
                <?php if (!empty($idx_p['industry'])): ?><span><?= e($BLG['industries'][$idx_p['industry']]) ?></span><?php endif; ?>
              </span>

              <h3 class="blg-card__t"><?= e($idx_p['title']) ?></h3>
              <p class="blg-card__d"><?= e($idx_p['dek']) ?></p>

              <span class="blg-card__foot">
                <span class="blg-card__tags">
                  <?php foreach (array_slice($idx_p['tags'], 0, 3) as $idx_tag): ?>
                    <span class="bdh-tag"><?= e($BLG['tags'][$idx_tag] ?? $idx_tag) ?></span>
                  <?php endforeach; ?>
                </span>
                <span class="blg-card__go"><?= $idx_p['live'] ? 'Read' : 'Page pending' ?><i aria-hidden="true">›</i></span>
              </span>
            <?php if ($idx_p['live']): ?></a><?php else: ?></div><?php endif; ?>
          </article>
        </li>
      <?php endforeach; ?>

      <li class="blg-grid__next">
        <div class="blg-next">
          <p class="blg-k">Next in the queue</p>
          <h3 class="blg-next__t">This slot is the next post.</h3>
          <p class="blg-next__d">The journal is written alongside the work, so it moves at the pace of the work. A post is added by appending one entry to <code class="blg-code">data/blog.php</code> and creating a three-line page file beside it.</p>
          <a class="tl" href="<?= xe_url('contact.php') ?>">Ask us to write about something <span class="i" aria-hidden="true">›</span></a>
        </div>
      </li>
    </ol>

    <p class="blg-idx__none" data-blg-empty <?= $SHOWN > 0 ? 'hidden' : '' ?>>
      Nothing matches that combination yet. <a class="blg-a" href="<?= e(blog_home()) ?>#index">Clear the filters</a> to see everything.
    </p>
  </div>
</section>
