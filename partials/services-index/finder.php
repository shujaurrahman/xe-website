<?php /* DRAFT COPY — review before launch */
/* The capability finder. A GET form (q, d, need) filtered on the server, so it works with JavaScript
   off; finder.js filters the same rows in place and keeps the URL in step. */
$svx_match = function (array $svx_r) use ($svx_q, $svx_fd, $svx_fn): bool {
    if ($svx_fd !== '' && $svx_r['d']['slug'] !== $svx_fd) return false;
    if ($svx_fn !== '' && !in_array($svx_fn, $svx_r['needs'], true)) return false;
    if ($svx_q !== '' && mb_stripos($svx_r['name'] . ' ' . $svx_r['desc'] . ' ' . $svx_r['d']['name'], $svx_q) === false) return false;
    return true;
};
$svx_shown = count(array_filter($svx_rows, $svx_match));
$svx_link  = function (string $svx_key, string $svx_val) use ($svx_q, $svx_fd, $svx_fn): string {
    $svx_p = array_filter(['q' => $svx_q, 'd' => $svx_fd, 'need' => $svx_fn]);
    if ($svx_val === '') unset($svx_p[$svx_key]); else $svx_p[$svx_key] = $svx_val;
    return ($svx_p ? '?' . http_build_query($svx_p) : './') . '#finder';
};
?>
<section class="band band--alt svx-finder" id="finder" aria-labelledby="finder-t" data-svx-finder>
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div><p class="lbl lbl--blue"><span class="dot"></span>Capability finder</p>
        <h2 class="h2" id="finder-t"><span class="g">Start from the problem.</span> We will point you at the team.</h2></div>
      <div><p class="lead">Search all <?= $svx_total ?> capabilities, or narrow them by discipline and by what you need to happen next. Every result opens the page that covers it.</p></div>
    </div>

    <div class="svx-f">
      <form class="svx-f__ctl" action="./#finder" method="get" role="search" aria-label="Filter capabilities" data-svx-form>
        <div class="svx-f__q">
          <label class="svx-f__k" for="svx-q">Search</label>
          <span class="svx-f__qw">
            <?= xt_icon('search') ?>
            <input class="svx-f__in" id="svx-q" name="q" type="search" value="<?= e($svx_q) ?>" placeholder="e.g. agents, packaging, SEO" autocomplete="off" data-svx-q>
          </span>
        </div>

        <fieldset class="svx-f__set">
          <legend class="svx-f__k">What you need</legend>
          <div class="svx-f__chips">
            <label class="svx-chip"><input type="radio" name="need" value=""<?= $svx_fn === '' ? ' checked' : '' ?>><span>Anything</span></label>
            <?php foreach ($SVX_NEEDS as $svx_k => $svx_nd): ?>
              <label class="svx-chip"><input type="radio" name="need" value="<?= e($svx_k) ?>"<?= $svx_fn === $svx_k ? ' checked' : '' ?>><span><?= e($svx_nd[0]) ?></span></label>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <fieldset class="svx-f__set">
          <legend class="svx-f__k">Discipline</legend>
          <div class="svx-f__chips svx-f__chips--d">
            <label class="svx-chip"><input type="radio" name="d" value=""<?= $svx_fd === '' ? ' checked' : '' ?>><span>All six</span></label>
            <?php foreach ($SITE['disciplines'] as $svx_d): ?>
              <label class="svx-chip"><input type="radio" name="d" value="<?= e($svx_d['slug']) ?>"<?= $svx_fd === $svx_d['slug'] ? ' checked' : '' ?>><span><b><?= e($svx_d['n']) ?></b> <?= e($svx_d['short']) ?></span></label>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <div class="svx-f__act">
          <button class="btn btn--ink" type="submit" data-svx-apply>Show results <span class="i" aria-hidden="true">›</span></button>
          <a class="tl" href="./#finder" data-svx-reset>Clear filters</a>
        </div>
      </form>

      <div class="svx-f__out">
        <p class="svx-f__n" aria-live="polite" data-svx-n><b data-svx-shown><?= $svx_shown ?></b> of <?= $svx_total ?> capabilities</p>
        <?php foreach ($SITE['disciplines'] as $svx_d):
          $svx_in = array_filter($svx_rows, fn ($svx_r) => $svx_r['d']['slug'] === $svx_d['slug']);
          $svx_on = count(array_filter($svx_in, $svx_match)); ?>
          <div class="svx-grp" data-svx-grp<?= $svx_on ? '' : ' hidden' ?>>
            <h3 class="svx-grp__h"><span><?= e($svx_d['n']) ?></span><a href="<?= e(xe_discipline_url($svx_d)) ?>"><?= e($svx_d['name']) ?></a></h3>
            <ul class="svx-res">
              <?php foreach ($svx_in as $svx_r): ?>
                <li data-svx-row data-d="<?= e($svx_d['slug']) ?>" data-need="<?= e(implode(' ', $svx_r['needs'])) ?>" data-s="<?= e(mb_strtolower($svx_r['name'] . ' ' . $svx_r['desc'] . ' ' . $svx_d['name'])) ?>"<?= $svx_match($svx_r) ? '' : ' hidden' ?>>
                  <a class="svx-res__a" href="<?= e($svx_r['url']) ?>">
                    <span class="svx-res__t"><?= e($svx_r['name']) ?></span>
                    <span class="svx-res__d"><?= e($svx_r['desc']) ?></span>
                    <span class="svx-res__m">
                      <?php foreach ($svx_r['needs'] as $svx_k): ?><span class="bdh-tag"><?= e($SVX_NEEDS[$svx_k][0]) ?></span><?php endforeach; ?>
                      <span class="svx-res__p"><?= $svx_r['own'] ? 'Capability page' : 'Covered on the ' . e($svx_d['short']) . ' page' ?></span>
                    </span>
                    <span class="svx-res__go" aria-hidden="true">›</span>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
        <div class="svx-none" data-svx-none<?= $svx_shown ? ' hidden' : '' ?>>
          <p class="svx-none__t">Nothing matches that yet.</p>
          <p class="p">Describe the problem instead and we will route it to the right lead.</p>
          <a class="btn btn--out btn--sm" href="<?= e(xe_url('contact.php')) ?>">Describe it to us <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>
  </div>
</section>
