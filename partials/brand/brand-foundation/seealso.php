<?php /* DRAFT COPY — review before launch */
/* §12 Onward — "See also", set as a bibliography: the parent document (Brand Design), the two $BD pairs
   as cited references, then the remaining capabilities as further reading. Names and one-liners come from
   $BRAND['caps']; kickers and numbers from $BD. */
$cbf_see_why = [   // slug => why this foundation cites it
    'brand-identity'  => 'Identity starts from the positioning signed here, so the visual and verbal codes carry a decision rather than a mood.',
    'growth-strategy' => 'Strategy says where to play. The foundation says who the brand is when it gets there.',
];
$cbf_see_pairs = [];
$cbf_see_more  = [];
foreach ($BRAND['caps'] as $cbf_row) {
    if (($cbf_row[2] ?? '') === $CAP['slug']) continue;
    if (in_array($cbf_row[2], $CAP['pairs'], true)) $cbf_see_pairs[array_search($cbf_row[2], $CAP['pairs'], true)] = $cbf_row;
    else $cbf_see_more[] = $cbf_row;
}
ksort($cbf_see_pairs);
$cbf_see_n = 0;
$cbf_see_entry = function (array $cbf_row, bool $cbf_pair) use ($BRAND, $BD, $cbf_see_why, &$cbf_see_n): void {
    $cbf_see_n++;
    $cbf_d = $BD[$cbf_row[2]] ?? null; ?>
    <li class="cbf-see__item<?= $cbf_pair ? ' is-pair' : '' ?>">
      <span class="cbf-see__num" aria-hidden="true">[<?= $cbf_see_n ?>]</span>
      <div class="cbf-see__ref">
        <p class="cbf-see__cite">
          <a class="cbf-see__a" href="<?= xe_cap_url($BRAND, $cbf_row) ?>"><?= e($cbf_row[0]) ?></a><span class="cbf-see__meta"> <span class="cbf-see__no"><?= e($BRAND['n']) ?>.<?= e($cbf_d['n'] ?? '') ?></span> <em><?= e($cbf_d['kicker'] ?? '') ?></em>. <?= e($BRAND['name']) ?>.</span>
        </p>
        <p class="cbf-see__line"><?= e($cbf_row[1]) ?></p>
        <?php if ($cbf_pair && isset($cbf_see_why[$cbf_row[2]])): ?><p class="cbf-see__why"><span class="cbf-see__tag">Cited · pairs with this foundation</span><?= e($cbf_see_why[$cbf_row[2]]) ?></p><?php endif; ?>
        <p class="cbf-see__url" aria-hidden="true">/services/<?= e($BRAND['slug']) ?>/<?= e($cbf_row[2]) ?></p>
      </div>
    </li>
<?php };
?>
<section class="band band--alt cbf-see" id="see-also" aria-labelledby="see-t">
  <div class="wrap">
    <header class="cbf-head" data-rv>
      <p class="cbf-head__sec"><b>§ 12</b>References</p>
      <div class="cbf-head__body">
        <h2 class="h2" id="see-t"><span class="g">See also.</span> Where the foundation goes next.</h2>
      </div>
    </header>

    <div class="cbf-see__grid">
      <div class="cbf-see__parent" data-rv>
        <p class="cbf-mono">Parent document</p>
        <a class="cbf-see__back" href="<?= xe_discipline_url($BRAND) ?>">
          <span class="cbf-see__bn"><?= e($BRAND['n']) ?> · Discipline</span>
          <span class="cbf-see__bt"><?= e($BRAND['name']) ?></span>
          <span class="cbf-see__bl"><?= e($BRAND['intro']) ?></span>
          <span class="cbf-see__bgo">Back to <?= e($BRAND['name']) ?> <i aria-hidden="true">›</i></span>
        </a>
      </div>

      <div class="cbf-see__lists">
        <h3 class="cbf-see__h">Cited in this document</h3>
        <ol class="cbf-see__list" data-rv-s>
          <?php foreach ($cbf_see_pairs as $cbf_row) $cbf_see_entry($cbf_row, true); ?>
        </ol>
        <h3 class="cbf-see__h">Further reading</h3>
        <ol class="cbf-see__list" data-rv-s>
          <?php foreach ($cbf_see_more as $cbf_row) $cbf_see_entry($cbf_row, false); ?>
        </ol>
      </div>
    </div>
  </div>
</section>
