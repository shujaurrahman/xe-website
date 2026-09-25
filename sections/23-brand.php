<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * 23-brand — what we make for a brand.
 *
 * The home page's route into Brand Design. 08-disciplines already names the six
 * capabilities inside a tab panel, but every one of its links goes to #book, so the
 * page never actually reaches the six capability pages that exist. This section is
 * that route: each capability as a row carrying what it hands over, linked to its
 * own page.
 *
 * Content comes from data/brand-design.php (long form) and data/site.php (the
 * approved names), so this can never drift from the discipline pages.
 *
 * Locals are prefixed s23_ — index.php loops with $s and the chrome uses
 * $c $d $i $k $item $url $current $disc $col $l, so none of those may be touched.
 *
 * $SITE is imported explicitly: xe_section() includes this file from inside a
 * function, so the page's variables are not in scope here — only globals are.
 */
global $SITE;

$s23_caps = require __DIR__ . '/../data/brand-design.php';
$s23_disc = null;
foreach ($SITE['disciplines'] as $s23_row) { if ($s23_row['slug'] === 'brand-design') $s23_disc = $s23_row; }
unset($s23_row);
?>
<section class="band band--alt band--rules bdh s23" id="brand" aria-labelledby="s23-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row s23__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span><?= e($s23_disc['n']) ?> · <?= e($s23_disc['name']) ?></p>
        <h2 class="h2" id="s23-t"><span class="g">A brand is a system.</span> This is what we build into it.</h2>
      </div>
      <div>
        <p class="lead"><?= e($s23_disc['intro']) ?></p>
        <a class="tl" href="<?= xe_url('services/brand-design.php') ?>">All of Brand Design <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <ol class="s23__list" data-rv-s data-rv-step="60">
      <?php foreach ($s23_caps as $s23_slug => $s23_cap): ?>
        <li class="s23__row">
          <a class="s23__link" href="<?= xe_url('services/brand-design/' . $s23_slug . '.php') ?>">
            <span class="s23__n" aria-hidden="true"><?= e($s23_cap['n']) ?></span>

            <span class="s23__body">
              <span class="s23__kicker"><?= e($s23_cap['kicker']) ?></span>
              <h3 class="h3 s23__name"><?= e($s23_cap['name']) ?></h3>
              <span class="s23__lead"><?= e($s23_cap['lead']) ?></span>
            </span>

            <span class="s23__gets">
              <span class="s23__getsk">Hands over</span>
              <span class="s23__chips">
                <?php foreach (array_slice($s23_cap['deliver'], 0, 3) as $s23_item): ?>
                  <span class="s23__chip"><?= e($s23_item[0]) ?></span>
                <?php endforeach; ?>
                <?php if (count($s23_cap['deliver']) > 3): ?>
                  <span class="s23__more">+<?= count($s23_cap['deliver']) - 3 ?> more</span>
                <?php endif; ?>
              </span>
            </span>

            <span class="s23__go" aria-hidden="true">›</span>
          </a>
        </li>
      <?php endforeach; ?>
    </ol>

  </div>
</section>
