<?php
/**
 * The Brand Design capability navigator. It sits just under the hero, then
 * sticks beneath the floating nav: the discipline on the left, the six
 * capabilities (number + name) in the middle, a call to action on the right,
 * and a hairline that tracks how far through the page you are.
 *
 *   $BD           required  all six capabilities (data/brand-design.php)
 *   $cap          optional  the current capability; unset or null on the hub
 *   $railAnchors  optional  sprintf pattern such as '#cap-%s' — items link to
 *                           sections on this page and light up as each one
 *                           scrolls into view (scroll-spy). Default: page links.
 *   $railCta      optional  [label, href], or false to hide. Default: Start a brief → contact.php
 */
$rlCur  = isset($cap) && is_array($cap) && isset($cap['slug']) ? $cap['slug'] : '';
$rlAnch = isset($railAnchors) && is_string($railAnchors) && $railAnchors !== '' ? $railAnchors : null;
$rlCta  = isset($railCta) ? $railCta : ['Start a brief', 'contact.php'];
?>
<nav class="bd-rail" aria-label="Brand Design capabilities" data-bd-railbar<?= $rlAnch ? ' data-bd-spy' : '' ?>>
  <div class="wrap bd-rail__in">
    <a class="bd-rail__hub<?= $rlCur === '' ? ' is-here' : '' ?>" href="<?= xe_url('services/brand-design.php') ?>"<?= $rlCur === '' && !$rlAnch ? ' aria-current="page"' : '' ?>>
      <span class="bd-rail__hubk">Discipline</span>
      <span class="bd-rail__hubt">Brand Design</span>
    </a>

    <div class="bd-rail__scroll" data-bd-rail>
      <ol class="bd-rail__list">
        <?php foreach ($BD as $c):
          $here = $c['slug'] === $rlCur;
          $href = $rlAnch ? sprintf($rlAnch, $c['slug']) : xe_url('services/brand-design/' . $c['slug'] . '.php'); ?>
          <li>
            <a class="bd-rail__i<?= $here ? ' is-here' : '' ?>" href="<?= e($href) ?>"<?= $here ? ' aria-current="page"' : '' ?>>
              <span class="bd-rail__n num" aria-hidden="true"><?= e($c['n']) ?></span><span class="bd-rail__t"><?= e($c['name']) ?></span><span class="bd-rail__s" aria-hidden="true"><?= e($c['short']) ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <?php if ($rlCta): ?>
      <a class="btn btn--ink btn--sm bd-rail__cta" href="<?= e(xe_url($rlCta[1])) ?>"><?= e($rlCta[0]) ?> <span class="i" aria-hidden="true">›</span></a>
    <?php endif; ?>
    <span class="bd-rail__prog" aria-hidden="true"><i></i></span>
  </div>
</nav>
