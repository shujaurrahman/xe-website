<?php /* DRAFT COPY — review before launch */
/**
 * Technology & Intelligence — "Keep going": the onward aid between the ten capabilities.
 * The next capability as a large photo card (with the stack it runs on), the previous one beside it,
 * the page's position NN / 10 and a ten-step index that links every capability.
 *
 *   $TI   required  data/technology-intelligence.php (all ten capabilities, in order)
 *   $CAP  required  the current capability ($TI[<slug>])
 *
 * Styles: assets/css/tech/kit.css (.xt-next). No script needed; hover and focus motion are CSS only
 * and switch off under reduced motion. Locals are prefixed xtn_ so the chrome's variables are untouched.
 */
require_once __DIR__ . '/kit.php';

$xtn_keys = array_keys($TI);
$xtn_cnt  = count($xtn_keys);
$xtn_at   = array_search($CAP['slug'], $xtn_keys, true);
if ($xtn_at === false) { $xtn_at = 0; }
$xtn_next = $TI[$xtn_keys[($xtn_at + 1) % $xtn_cnt]];
$xtn_prev = $TI[$xtn_keys[($xtn_at - 1 + $xtn_cnt) % $xtn_cnt]];
$xtn_total = str_pad((string) $xtn_cnt, 2, '0', STR_PAD_LEFT);
$xtn_url  = function (array $c): string { return xe_url('services/technology-intelligence/' . $c['slug'] . '.php'); };
?>
<section class="xt-next" aria-labelledby="xt-next-t">
  <div class="wrap">
    <div class="xt-next__bar" data-rv>
      <div class="xt-next__where">
        <h2 class="lbl" id="xt-next-t"><span class="dot"></span>Keep going</h2>
        <span class="xt-next__path" aria-hidden="true">technology-intelligence <i>/</i> <?= e($CAP['n']) ?></span>
      </div>
      <p class="xt-next__pos"><span class="sr">Capability </span><b><?= e($CAP['n']) ?></b> <i aria-hidden="true">/</i><span class="sr"> of </span> <?= e($xtn_total) ?></p>
    </div>

    <nav class="xt-next__index" aria-label="Technology &amp; Intelligence capabilities" data-rv data-rv-d="40">
      <ol class="xt-next__steps">
        <?php foreach ($xtn_keys as $xtn_j => $xtn_k):
            $xtn_c = $TI[$xtn_k];
            $xtn_state = $xtn_j === $xtn_at ? 'is-here' : ($xtn_k === $xtn_next['slug'] ? 'is-next' : ($xtn_j < $xtn_at ? 'is-past' : '')); ?>
          <li class="xt-next__step <?= $xtn_state ?>">
            <a href="<?= $xtn_url($xtn_c) ?>"<?= $xtn_j === $xtn_at ? ' aria-current="page"' : '' ?>>
              <span class="xt-next__seg" aria-hidden="true"></span>
              <span class="xt-next__num"><?= e($xtn_c['n']) ?></span>
              <span class="xt-next__tip"><?= e($xtn_c['name']) ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ol>
    </nav>

    <div class="xt-next__in" data-rv data-rv-d="80">
      <a class="xt-next__prev" href="<?= $xtn_url($xtn_prev) ?>" aria-label="Previous capability, <?= e($xtn_prev['n']) ?>: <?= e($xtn_prev['name']) ?>">
        <span class="xt-next__ptop">
          <span class="xt-next__parrow" aria-hidden="true">‹</span>
          <span class="xt-next__pico" aria-hidden="true"><?= xt_icon($xtn_prev['icon'] ?? 'dot') ?></span>
        </span>
        <?php if (!empty($xtn_prev['offer'])): ?>
          <span class="xt-next__pspec" aria-hidden="true">
            <span class="xt-next__lbl">What it covers</span>
            <span class="xt-next__plist">
              <?php foreach (array_slice($xtn_prev['offer'], 0, 4) as $xtn_q => $xtn_o): ?>
                <span class="xt-next__prow"><b><?= str_pad((string) ($xtn_q + 1), 2, '0', STR_PAD_LEFT) ?></b><span><?= e($xtn_o[0]) ?></span><?php if (!empty($xtn_o[3])): ?><i><?= xt_icon($xtn_o[3], ['size' => 16]) ?></i><?php endif; ?></span>
              <?php endforeach; ?>
            </span>
          </span>
        <?php endif; ?>
        <span class="xt-next__lbl xt-next__lbl--prev">Previous · <?= e($xtn_prev['n']) ?></span>
        <span class="xt-next__pt"><?= e($xtn_prev['name']) ?></span>
        <span class="xt-next__pk"><?= e($xtn_prev['kicker']) ?></span>
        <?php if (!empty($xtn_prev['stack'])): ?>
          <span class="xt-next__pstack" aria-hidden="true"><?php foreach (array_slice($xtn_prev['stack'], 0, 5) as $xtn_s): ?><span class="xt-next__rlogo"><?= xt_logo($xtn_s, ['size' => 16, 'hidden' => true]) ?></span><?php endforeach; ?></span>
        <?php endif; ?>
      </a>

      <a class="xt-next__go" href="<?= $xtn_url($xtn_next) ?>" aria-label="Next capability, <?= e($xtn_next['n']) ?>: <?= e($xtn_next['name']) ?>">
        <span class="xt-next__txt">
          <span class="xt-next__lbl xt-next__lbl--next">Next · <?= e($xtn_next['n']) ?> · <?= e($xtn_next['kicker']) ?></span>
          <span class="xt-next__t"><?= e($xtn_next['name']) ?></span>
          <span class="xt-next__d"><?= e($xtn_next['lead']) ?></span>
          <?php if (!empty($xtn_next['stack'])): ?>
            <span class="xt-next__runs" aria-hidden="true">
              <span class="xt-next__rk">Stack</span>
              <span class="xt-next__rl"><?php foreach (array_slice($xtn_next['stack'], 0, 5) as $xtn_s): ?><span class="xt-next__rlogo" title="<?= e(xt_tech($xtn_s)['name'] ?? $xtn_s) ?>"><?= xt_logo($xtn_s, ['size' => 18, 'hidden' => true]) ?></span><?php endforeach; ?></span>
            </span>
          <?php endif; ?>
          <span class="xt-next__cta">Explore <?= e($xtn_next['short']) ?> <i aria-hidden="true">›</i></span>
        </span>
        <span class="xt-next__vis" aria-hidden="true">
          <?php if (!empty($xtn_next['img'])): ?>
            <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
            <img class="xt-next__img" src="<?= xe_url($xtn_next['img']['src']) ?>" width="<?= (int) $xtn_next['img']['w'] ?>" height="<?= (int) $xtn_next['img']['h'] ?>" alt="" loading="lazy" decoding="async" style="object-position:<?= e($xtn_next['img']['pos'] ?? '50% 50%') ?>">
          <?php endif; ?>
          <span class="xt-next__frame"><i></i><i></i><i></i><i></i></span>
          <span class="xt-next__scan"></span>
          <span class="xt-next__read"><span class="xt-next__ico"><?= xt_icon($xtn_next['icon'] ?? 'dot', ['size' => 16]) ?></span><?= e($xtn_next['n']) ?> / <?= e($xtn_total) ?> · <?= e($xtn_next['slug']) ?></span>
        </span>
        <span class="xt-next__arrow" aria-hidden="true"><i></i><b>›</b></span>
      </a>
    </div>
  </div>
</section>
