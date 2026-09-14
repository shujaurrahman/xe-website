<?php /** The footer and the closing scripts. Include last on every page. */ ?>
<footer class="foot">
  <div class="foot__bg" aria-hidden="true">
    <span class="aurora aurora--strong"><i></i><i></i><i></i><i></i></span>
    <span class="dither dither--tl"></span>
    <span class="dither dither--tr"></span>
  </div>

  <div class="wrap foot__wrap">
    <div class="foot__card" data-rv>
      <div class="foot__top">
        <div class="foot__brand">
          <span class="foot__logo" aria-label="<?= e($SITE['company']['name']) ?>"><?= xe_svg('xe-lockup') ?></span>
          <p class="foot__tag"><?= e($SITE['company']['tagline']) ?></p>
          <a class="btn btn--ink foot__cta" href="<?= xe_url($SITE['cta']['href']) ?>">
            <?= e($SITE['cta']['label']) ?> <span class="i" aria-hidden="true">›</span>
          </a>
          <p class="foot__mail"><a href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a></p>
        </div>

        <nav class="foot__cols" aria-label="Footer">
          <div class="foot__col">
            <h3>What we do</h3>
            <?php foreach ($SITE['disciplines'] as $d): ?>
              <a href="<?= xe_discipline_url($d) ?>"><?= e($d['name']) ?></a>
            <?php endforeach; ?>
          </div>
          <?php foreach ($SITE['footer'] as $col): ?>
            <div class="foot__col">
              <h3><?= e($col['title']) ?></h3>
              <?php foreach ($col['links'] as $l): ?>
                <a href="<?= xe_url($l[1]) ?>"><?= e($l[0]) ?></a>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
        </nav>
      </div>

      <!-- PLACEHOLDER: confirm both studio addresses before launch. -->
      <div class="foot__studios">
        <?php foreach ($SITE['company']['studios'] as $s): ?>
          <address class="foot__studio">
            <span class="foot__slbl">Studio</span>
            <span class="foot__scity"><?= e($s['city']) ?></span>
            <span class="foot__saddr"><?= implode('<br>', array_map('e', $s['lines'])) ?></span>
            <span class="foot__stime"><span class="tab-nums" data-clock="<?= e($s['tz']) ?>">--:--:--</span> IST</span>
          </address>
        <?php endforeach; ?>
        <div class="foot__studio foot__studio--say">
          <span class="foot__slbl">New business</span>
          <span class="foot__scity">Every brief answered</span>
          <span class="foot__saddr"><a href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a></span>
          <span class="foot__stime">Within one working day</span>
        </div>
      </div>

      <div class="foot__line" aria-hidden="true"></div>

      <div class="foot__bar">
        <span>© <span data-year><?= date('Y') ?></span> <?= e($SITE['company']['name']) ?>. All rights reserved.</span>
        <span class="foot__links">
          <a href="#">LinkedIn</a><a href="#">Instagram</a>
          <a href="<?= xe_url('careers.php') ?>">Careers</a>
          <a href="#">Privacy</a><a href="#">Terms</a>
        </span>
      </div>
    </div>
  </div>

  <span class="foot__mark" aria-hidden="true"><?= xe_svg('xe-lockup') ?></span>
</footer>

<script src="<?= xe_url('assets/js/core.js') ?>"></script>
<script src="<?= xe_url('assets/js/sections.js') ?>"></script>
<?php foreach ($page['js'] ?? [] as $js): ?>
<script src="<?= xe_url($js) ?>"></script>
<?php endforeach; ?>
</body>
</html>
