<?php
/** The floating pill navigation, its mega menu and the mobile sheet. */
$current = $page['key'] ?? '';
$disc    = $SITE['disciplines'];
?>
<header class="nav" id="nav">
  <div class="nav__in">
    <a class="nav__logo" href="<?= xe_url('index.php') ?>" aria-label="<?= e($SITE['company']['name']) ?> — home"><?= xe_svg('xe-lockup') ?></a>

    <nav class="nav__links" aria-label="Primary">
      <?php foreach ($SITE['nav'] as $item): ?>
        <?php if (!empty($item['mega'])): ?>
          <button class="nav__link<?= $current === $item['key'] ? ' is-here' : '' ?>" type="button"
                  data-mega-t aria-expanded="false" aria-controls="mega">
            <?= e($item['label']) ?> <span class="caret" aria-hidden="true">▾</span>
          </button>
        <?php else: ?>
          <a class="nav__link<?= $current === $item['key'] ? ' is-here' : '' ?>"
             href="<?= xe_url($item['href']) ?>"<?= $current === $item['key'] ? ' aria-current="page"' : '' ?>>
            <?= e($item['label']) ?>
          </a>
        <?php endif; ?>
      <?php endforeach; ?>
    </nav>

    <div class="nav__right">
      <span class="nav__clock" aria-hidden="true">New Delhi <span class="t" data-clock="Asia/Kolkata">--:--:--</span></span>
      <a class="btn btn--ink btn--sm nav__cta" href="<?= xe_url($SITE['cta']['href']) ?>">
        <?= e($SITE['cta']['label']) ?> <span class="i" aria-hidden="true">›</span>
      </a>
      <button class="nav__burger" type="button" aria-expanded="false" aria-controls="sheet" aria-label="Open menu">
        <svg width="18" height="12" viewBox="0 0 18 12" fill="none" aria-hidden="true"><path d="M0 1h18M0 6h18M0 11h18" stroke="currentColor" stroke-width="1.4"/></svg>
      </button>
    </div>

    <div class="mega" id="mega">
      <div class="mega__grid">
        <!-- each discipline opens its overview page; hover or focus previews its capabilities -->
        <nav class="mega__rail" aria-label="Disciplines">
          <?php foreach ($disc as $i => $d): ?>
            <a class="mega__tab<?= $i === 0 ? ' is-on' : '' ?>" href="<?= xe_discipline_url($d) ?>"
               id="mt-<?= e($d['slug']) ?>" aria-describedby="mp-<?= e($d['slug']) ?>-intro">
              <span class="n"><?= e($d['n']) ?></span><?= e($d['name']) ?>
              <span class="i" aria-hidden="true">›</span>
            </a>
          <?php endforeach; ?>
        </nav>

        <div class="mega__panes">
          <?php foreach ($disc as $i => $d): $url = xe_discipline_url($d); ?>
            <div class="mega__pane<?= $i === 0 ? ' is-on' : '' ?>" id="mp-<?= e($d['slug']) ?>">
              <p class="mega__intro"><?= e($d['intro']) ?></p>
              <div class="mega__caps">
                <?php foreach ($d['caps'] as $k => $c):
                        if (!empty($d['group']) && $k === ($d['group_at'] ?? -1)): ?>
                          <p class="mega__group"><?= e($d['group']) ?></p>
                <?php   endif; ?>
                  <a class="mega__cap" href="<?= xe_cap_url($d, $c) ?>"><?= e($c[0]) ?></a>
                <?php endforeach; ?>
              </div>
              <a class="mega__more tl" href="<?= $url ?>">All of <?= e($d['short']) ?> <span class="i" aria-hidden="true">›</span></a>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="mega__foot">
          <span>Six disciplines. One team. One system.</span>
          <a class="tl" href="<?= xe_url('approach.php') ?>">See how we work <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>
  </div>
</header>
<div class="nav-scrim" aria-hidden="true"></div>

<div class="sheet" id="sheet">
  <div class="sheet__top">
    <span class="nav__logo" aria-hidden="true"><?= xe_svg('xe-lockup') ?></span>
    <button class="nav__burger" type="button" data-sheet-x aria-label="Close menu">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M1 1l14 14M15 1L1 15" stroke="currentColor" stroke-width="1.4"/></svg>
    </button>
  </div>
  <div class="sheet__body">
    <p class="lbl" style="padding:18px 0 6px">What we do</p>
    <?php foreach ($disc as $d): ?>
      <div class="sheet__row">
        <button class="sheet__btn" type="button" data-sheet-b aria-expanded="false">
          <?= e($d['name']) ?><span class="n"><?= e($d['n']) ?></span><span aria-hidden="true">+</span>
        </button>
        <div class="sheet__panel">
          <a href="<?= xe_discipline_url($d) ?>">Overview — all of <?= e($d['short']) ?> ›</a>
          <?php foreach ($d['caps'] as $c): ?>
            <a href="<?= xe_cap_url($d, $c) ?>"><?= e($c[0]) ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>

    <?php foreach ($SITE['nav'] as $item): if (!empty($item['mega'])) continue; ?>
      <div class="sheet__row">
        <a class="sheet__btn" href="<?= xe_url($item['href']) ?>"><?= e($item['label']) ?><span aria-hidden="true">›</span></a>
      </div>
    <?php endforeach; ?>

    <div class="sheet__foot">
      <a class="btn btn--ink btn--lg" href="<?= xe_url($SITE['cta']['href']) ?>"><?= e($SITE['cta']['label']) ?> <span class="i" aria-hidden="true">›</span></a>
      <a class="btn btn--out btn--lg" href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a>
    </div>
  </div>
</div>
