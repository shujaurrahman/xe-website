<?php /* DRAFT COPY — review before launch */
/* 13 Onward — `ls -la ~/brand-design`: the parent directory (back to Brand Design), this page,
   and the other five capabilities as a listing. The two $CAT['pairs'] are flagged with why.
   onward.js types the matching `cd` command as a row is hovered or focused. */
$cat_pair_why = [   // slug => why it pairs with Brand AI Tools
    'brand-systems'  => 'the rules it learns',
    'brand-identity' => 'what it is tuned on',
];
$cat_rows = [];
foreach ($BRAND['caps'] as $cat_cap) {
    $cat_rows[] = [
        'cap'  => $cat_cap,
        'n'    => $BD[$cat_cap[2]]['n'] ?? '',
        'self' => $cat_cap[2] === $CAT['slug'],
        'pair' => in_array($cat_cap[2], $CAT['pairs'], true),
    ];
}
$cat_hub_url = xe_discipline_url($BRAND);
?>
<section class="band cat-paper cat-paper--alt cat-ls" id="onward" aria-labelledby="onward-t">
  <div class="wrap">
    <div class="cat-head" data-rv>
      <div>
        <p class="cat-prompt"><b>$ ls -la ~/brand-design</b> <span><?= count($BRAND['caps']) ?> capabilities · <?= count($CAT['pairs']) ?> pair with this one</span></p>
        <h2 class="h2" id="onward-t"><span class="g">The model learns from the rest.</span> One directory up.</h2>
      </div>
      <p class="lead">Brand AI Tools automate a brand that has already been decided. These are the capabilities that do the deciding, with the two this one leans on most marked.</p>
    </div>

    <div class="cat-ls__ui" data-rv>
      <p class="cat-ls__total" aria-hidden="true">total <?= count($BRAND['caps']) ?></p>
      <ul class="cat-ls__list">
        <li>
          <a class="cat-ls__row cat-ls__row--up" href="<?= $cat_hub_url ?>" data-cd="..">
            <span class="cat-ls__perm" aria-hidden="true">drwxr-xr-x</span>
            <span class="cat-ls__n" aria-hidden="true">..</span>
            <span class="cat-ls__name"><b><?= e($BRAND['name']) ?></b><i aria-hidden="true">../</i></span>
            <span class="cat-ls__desc">Back to the discipline: all six capabilities and how a programme runs</span>
            <span class="cat-ls__flag"><em>cd ..</em></span>
            <span class="cat-ls__go" aria-hidden="true">›</span>
          </a>
        </li>
        <?php foreach ($cat_rows as $cat_r): $cat_c = $cat_r['cap']; ?>
          <li>
            <?php if ($cat_r['self']): ?>
              <div class="cat-ls__row is-self" aria-current="page">
                <span class="cat-ls__perm" aria-hidden="true">drwxr-xr-x</span>
                <span class="cat-ls__n" aria-hidden="true"><?= e($cat_r['n']) ?></span>
                <span class="cat-ls__name"><b><?= e($cat_c[0]) ?></b><i aria-hidden="true"><?= e($cat_c[2]) ?>/</i></span>
                <span class="cat-ls__desc"><?= e($cat_c[1]) ?></span>
                <span class="cat-ls__flag"><em class="is-here">you are here</em></span>
                <span class="cat-ls__go" aria-hidden="true"></span>
              </div>
            <?php else: ?>
              <a class="cat-ls__row<?= $cat_r['pair'] ? ' is-pair' : '' ?>" href="<?= xe_cap_url($BRAND, $cat_c) ?>" data-cd="../<?= e($cat_c[2]) ?>">
                <span class="cat-ls__perm" aria-hidden="true">drwxr-xr-x</span>
                <span class="cat-ls__n" aria-hidden="true"><?= e($cat_r['n']) ?></span>
                <span class="cat-ls__name"><b><?= e($cat_c[0]) ?></b><i aria-hidden="true"><?= e($cat_c[2]) ?>/</i></span>
                <span class="cat-ls__desc"><?= e($cat_c[1]) ?></span>
                <span class="cat-ls__flag"><?php if ($cat_r['pair']): ?><em class="is-pair">pair · <?= e($cat_pair_why[$cat_c[2]] ?? 'works alongside this') ?></em><?php endif; ?></span>
                <span class="cat-ls__go" aria-hidden="true">›</span>
              </a>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <p class="cat-ls__cmd" aria-hidden="true"><span>$</span> <b data-ls-cmd>cd ../brand-systems</b><i class="cat-ls__caret"></i></p>
    </div>
  </div>
</section>
