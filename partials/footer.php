<?php
/** The footer and the closing scripts. Include last on every page. */
$foot_href = function ($h) { return preg_match('~^(#|mailto:|tel:|https?://)~', $h) ? $h : xe_url($h); };
?>
<footer class="foot">
  <div class="wrap">
    <div class="foot__top">
      <div class="foot__brand">
        <a class="foot__logo" href="<?= xe_url('index.php') ?>" aria-label="<?= e($SITE['company']['name']) ?> — home"><?= xe_svg('xe-lockup') ?></a>
        <p class="foot__tag"><?= e($SITE['company']['tagline']) ?></p>
        <a class="foot__mail" href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a>
        <a class="tl foot__cta" href="<?= xe_url($SITE['cta']['href']) ?>"><?= e($SITE['cta']['label']) ?> <span class="i" aria-hidden="true">›</span></a>
      </div>

      <nav class="foot__nav" aria-label="Footer">
        <div class="foot__col">
          <h2 class="foot__h">What we do</h2>
          <ul>
            <?php foreach ($SITE['disciplines'] as $d): ?>
              <li><a href="<?= xe_discipline_url($d) ?>"><?= e($d['name']) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php foreach ($SITE['footer'] as $col): ?>
          <div class="foot__col">
            <h2 class="foot__h"><?= e($col['title']) ?></h2>
            <ul>
              <?php foreach ($col['links'] as $l): ?>
                <li><a href="<?= $foot_href($l[1]) ?>"><?= e($l[0]) ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </nav>

      <div class="foot__col foot__offices">
        <h2 class="foot__h">Offices</h2>
        <!-- PLACEHOLDER: confirm the New Delhi address before launch (see data/site.php). -->
        <ul class="foot__olist">
          <?php foreach ($SITE['company']['studios'] as $s): ?>
            <li class="foot__office">
              <span class="foot__ocity"><?= e($s['city']) ?></span>
              <?php if (!empty($s['units'])): ?>
                <span class="foot__ounits"><?= e(implode(' · ', $s['units'])) ?></span>
              <?php endif; ?>
              <a class="foot__oaddr" href="https://www.google.com/maps/search/?api=1&amp;query=<?= rawurlencode(implode(', ', $s['lines'])) ?>" target="_blank" rel="noopener"><?= implode('<br>', array_map('e', $s['lines'])) ?><span class="sr"> — open in Google Maps (new tab)</span></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="foot__bar">
      <p class="foot__copy">© <span data-year><?= date('Y') ?></span> <?= e($SITE['company']['name']) ?>. All rights reserved.
        <!-- PLACEHOLDER: confirm the legal entity name and the trademark registration number/class before launch; use ™ instead of ® until registration is confirmed -->
        <span class="foot__tm">Xterra Edze® is a registered trademark of [Legal entity name] Private Limited.</span></p>

      <ul class="foot__legal" aria-label="Legal">
        <?php foreach ($SITE['legal'] as $l): ?>
          <li><a href="<?= $foot_href($l[1]) ?>"><?= e($l[0]) ?></a></li>
        <?php endforeach; ?>
      </ul>

      <div class="foot__end">
        <?php foreach ($SITE['social'] as $l): ?>
          <a class="foot__icon" href="<?= $foot_href($l[1]) ?>" aria-label="<?= e($SITE['company']['name']) ?> on <?= e($l[0]) ?>">
            <?php if ($l[0] === 'LinkedIn'): ?>
              <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.42v1.56h.05c.47-.9 1.63-1.85 3.37-1.85 3.6 0 4.26 2.37 4.26 5.46v6.28ZM5.34 7.43a2.06 2.06 0 1 1 0-4.13 2.06 2.06 0 0 1 0 4.13ZM7.12 20.45H3.56V9h3.56v11.45Z"/></svg>
            <?php else: ?>
              <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3.2" y="3.2" width="17.6" height="17.6" rx="5"/><circle cx="12" cy="12" r="4.1"/><circle cx="17.4" cy="6.6" r="1.05" fill="currentColor" stroke="none"/></svg>
            <?php endif; ?>
          </a>
        <?php endforeach; ?>
        <a class="foot__icon foot__up" href="#" aria-label="Back to top">
          <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5.5 11.5 12 5l6.5 6.5"/></svg>
        </a>
      </div>
    </div>
  </div>
</footer>

<script src="<?= xe_asset('assets/js/core.js') ?>"></script>
<script src="<?= xe_asset('assets/js/sections.js') ?>"></script>
<?php foreach ($page['js'] ?? [] as $js): ?>
<script src="<?= xe_asset($js) ?>"></script>
<?php endforeach; ?>
</body>
</html>
