<?php /* DRAFT COPY — review before launch */
/* Plate 12 — Continue the book. The six Brand Design capabilities as spines on a shelf: this one pulled
   out, its two pairs ($CAP['pairs']) carrying a bookmark, the rest ready to open. A bookend leads back to
   the Brand Design hub. Names, one-liners and links come from data/site.php. */
$ow_pairs = $CAP['pairs'] ?? [];
?>
<section class="cbi-sec cbi-sec--tint cbi-ow" id="onward" aria-labelledby="onward-t">
  <div class="wrap">
    <div class="cbi-head" data-rv>
      <p class="cbi-head__folio"><span>Colophon · Continue the book</span><span><?= e($BRAND['name']) ?> · <?= count($BRAND['caps']) ?> volumes</span></p>
      <div class="cbi-head__t">
        <h2 class="h2" id="onward-t"><span class="g">Close this chapter.</span> Open the next one.</h2>
      </div>
      <p class="lead">Identity is one volume of six. The two marked with a bookmark are the ones it leans on most: the foundation it expresses, and the system that keeps it running.</p>
    </div>

    <div class="cbi-ow__shelf">
      <ol class="cbi-ow__spines">
        <?php foreach ($BRAND['caps'] as $ow_i => $ow_c):
            $ow_slug = $ow_c[2] ?? '';
            $ow_here = $ow_slug === 'brand-identity';
            $ow_pair = in_array($ow_slug, $ow_pairs, true);
            $ow_cls  = 'cbi-ow__spine' . ($ow_here ? ' is-here' : '') . ($ow_pair ? ' is-pair' : '');
            $ow_n    = $BD[$ow_slug]['n'] ?? sprintf('%02d', $ow_i + 1);
        ?>
        <li class="cbi-ow__item" style="--i:<?= $ow_i ?>">
          <?php if ($ow_here): ?>
          <span class="<?= $ow_cls ?>" aria-current="page">
          <?php else: ?>
          <a class="<?= $ow_cls ?>" href="<?= xe_cap_url($BRAND, $ow_c) ?>" data-line="<?= e($ow_c[1]) ?>">
          <?php endif; ?>
            <span class="cbi-ow__no"><?= e($ow_n) ?></span>
            <span class="cbi-ow__name"><?= e($ow_c[0]) ?></span>
            <span class="cbi-ow__line"><?= e($ow_c[1]) ?></span>
            <span class="cbi-ow__tag"><?= $ow_here ? 'You are here' : ($ow_pair ? 'Pairs with identity' : 'Open volume') ?></span>
            <?php if ($ow_pair): ?><span class="cbi-ow__ribbon" aria-hidden="true"></span><?php endif; ?>
          <?= $ow_here ? '</span>' : '</a>' ?>
        </li>
        <?php endforeach; ?>
        <li class="cbi-ow__item cbi-ow__item--end">
          <a class="cbi-ow__bookend" href="<?= xe_discipline_url($BRAND) ?>">
            <span class="cbi-ow__no">Index</span>
            <span class="cbi-ow__name">Back to <?= e($BRAND['name']) ?></span>
            <span class="cbi-ow__line">All six capabilities, how a programme runs, and how we work with enterprise teams.</span>
            <span class="cbi-ow__tag">The hub <span aria-hidden="true">›</span></span>
          </a>
        </li>
      </ol>
      <p class="cbi-ow__read" aria-hidden="true"><span class="cbi-lbl">On the spine</span><span class="cbi-ow__readt"><?= e($CAP_ROW[1] ?? $CAP['lead']) ?></span></p>
    </div>
  </div>
</section>
