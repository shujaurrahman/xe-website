<?php
/**
 * The hero of a capability page: breadcrumb, position, headline, lead, two
 * actions and the engagement facts on the left; the page's own stage on the right.
 *
 *   $cap       required  the capability (data/brand-design.php)
 *   $BD        optional  all six — draws the position ticks (defaults to 6)
 *   $mockHtml  optional  the page's bespoke mock, rendered with ob_start()
 *   $pheroImg  optional  ['src','w','h','alt','pos'] — a photograph the mock floats over;
 *                        true uses the capability's own $cap['img']
 *   $pheroAlt  optional  [label, href] — the secondary action (default: What we offer → #offer)
 *
 * With neither a mock nor a photograph the stage shows the capability glyph.
 */
require_once __DIR__ . '/icons.php';
$phTotal = isset($BD) && is_array($BD) ? count($BD) : 6;
$phAt    = (int) $cap['n'];
$phMock  = isset($mockHtml) ? trim((string) $mockHtml) : '';
$phImg   = null;
if (isset($pheroImg)) { $phImg = $pheroImg === true ? ($cap['img'] ?? null) : (is_array($pheroImg) ? $pheroImg : null); }
$phAlt   = isset($pheroAlt) && is_array($pheroAlt) ? $pheroAlt : ['What we offer', '#offer'];
$phKeys  = $cap['meta_k'] ?? [];
$phMods  = ($phImg ? ' bd-phero--img' : '') . ($phMock === '' ? ' bd-phero--nomock' : '');
?>
<section class="bd-phero<?= $phMods ?>" aria-labelledby="phero-t" data-bd-live>
  <div class="bd-phero__bg" aria-hidden="true">
    <span class="aurora aurora--soft"><i></i><i></i><i></i><i></i></span>
    <span class="dither dither--wide bd-phero__dither"></span>
    <span class="bd-phero__grid"></span>
  </div>

  <div class="wrap bd-phero__in">
    <div class="bd-phero__text" data-rv-s data-rv-step="70">
      <nav class="bd-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= xe_url('services/') ?>">Services</a></li>
          <li><a href="<?= xe_url('services/brand-design.php') ?>">Brand Design</a></li>
          <li><span aria-current="page"><?= e($cap['name']) ?></span></li>
        </ol>
      </nav>

      <p class="lbl lbl--blue bd-phero__eyebrow">
        <span class="bd-phero__ticks" aria-hidden="true"><?php for ($t = 1; $t <= $phTotal; $t++): ?><i<?= $t === $phAt ? ' class="is-on"' : '' ?>></i><?php endfor; ?></span>
        <span class="bd-phero__pos"><span class="sr">Capability </span><span class="num"><?= e($cap['n']) ?></span><span class="bd-phero__of"> / <?= str_pad((string) $phTotal, 2, '0', STR_PAD_LEFT) ?></span></span>
        <span class="bd-phero__k"><?= e($cap['kicker']) ?></span>
      </p>

      <h1 class="bd-phero__h" id="phero-t"><?= $cap['title'] ?></h1>
      <p class="lead bd-phero__lead"><?= e($cap['lead']) ?></p>

      <div class="bd-phero__act">
        <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>"><?= e($cap['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="<?= e(xe_url($phAlt[1])) ?>"><?= e($phAlt[0]) ?> <span class="i" aria-hidden="true">›</span></a>
      </div>

      <!-- PLACEHOLDER: typical timeframe and format — confirm before launch -->
      <dl class="bd-phero__meta">
        <?php foreach ($cap['meta'] as $i => $m): ?>
          <div class="bd-phero__mi">
            <dt class="bd-phero__mk"><?= e($phKeys[$i] ?? ($i === 0 ? 'Typical length' : 'Detail')) ?></dt>
            <dd class="bd-phero__mv"><?= e($m) ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    </div>

    <div class="bd-phero__stage" data-rv data-rv-d="160" data-bd-tilt>
      <span class="bd-phero__frame" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
      <?php if ($phImg): ?>
        <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
        <figure class="bd-phero__photo" data-bd-depth="-1"><?= bd_img($phImg, '', true) ?></figure>
      <?php endif; ?>
      <?php if ($phMock !== ''): ?>
        <div class="bd-phero__float" data-bd-depth="1"><?= $phMock ?></div>
      <?php elseif (!$phImg): ?>
        <div class="bd-phero__plate" aria-hidden="true">
          <?= bd_glyph($cap['slug']) ?>
          <span class="bd-phero__plbl"><?= e($cap['n']) ?> · <?= e($cap['short']) ?></span>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
