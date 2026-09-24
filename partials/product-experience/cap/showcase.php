<?php /* DRAFT COPY — review before launch */
/* Second showcase, mid-page: the working artefact this capability produces (route comparison, assumption tracker,
   findings board, eval scorecard, token-impact table). Rendered from topic.php 'x'. Real, readable HTML — a table with
   th scope or a list of columns — so it is complete without JS and reads correctly to a screen reader. */
$pxd_xx = $PXD_T['x'] ?? null;
if (!$pxd_xx) return;
$pxd_st = ['ok' => 'Passes', 'warn' => 'Watch', 'bad' => 'Fails', 'na' => 'Open'];
$pxd_cell = function ($pxd_v) use ($pxd_st): string {
    if (is_array($pxd_v)) return '<span class="pxd-x__s pxd-x__s--' . e($pxd_v[1]) . '"><i aria-hidden="true"></i>' . e($pxd_v[0]) . '<span class="bdh-sr"> (' . e($pxd_st[$pxd_v[1]] ?? '') . ')</span></span>';
    return $pxd_v === '—' ? '<span class="pxd-x__none" aria-label="Not affected">—</span>' : e($pxd_v);
};
?>
<section class="band pxd-x pxd-x--<?= e($pxd_xx['kind']) ?>" id="working" aria-labelledby="working-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span><?= e($pxd_xx['lbl']) ?> · what you will see</p>
        <h2 class="h2" id="working-t"><span class="g"><?= e($pxd_xx['h'][0]) ?></span> <?= e($pxd_xx['h'][1]) ?></h2></div>
      <div><p class="lead"><?= e($pxd_xx['lead']) ?></p></div>
    </div>
    <figure class="pxh-win pxd-x__win" data-rv>
      <div class="pxh-win__bar"><span class="dots3" aria-hidden="true"><i></i><i></i><i></i></span><?= e($pxd_xx['win']) ?><span class="sp">Illustrative</span></div>
      <?php if ($pxd_xx['kind'] === 'matrix'): ?>
      <div class="pxd-x__scroll bdh-scroll-x mask-x" tabindex="0" role="region" aria-label="<?= e($pxd_xx['aria']) ?>">
        <table class="pxd-x__t">
          <caption class="bdh-sr"><?= e($pxd_xx['win']) ?></caption>
          <thead><tr><?php foreach ($pxd_xx['cols'] as $pxd_j => $pxd_c): ?><th scope="col"<?= isset($pxd_xx['hl']) && $pxd_j === $pxd_xx['hl'] ? ' class="is-hl"' : '' ?>><?= e($pxd_c) ?></th><?php endforeach; ?></tr></thead>
          <tbody>
            <?php foreach ($pxd_xx['rows'] as $pxd_r): ?>
            <tr><th scope="row"><?= e($pxd_r[0]) ?></th><?php foreach (array_slice($pxd_r, 1) as $pxd_j => $pxd_v): ?><td data-h="<?= e($pxd_xx['cols'][$pxd_j + 1]) ?>"<?= isset($pxd_xx['hl']) && $pxd_j + 1 === $pxd_xx['hl'] ? ' class="is-hl"' : '' ?>><?= $pxd_cell($pxd_v) ?></td><?php endforeach; ?></tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div class="pxd-x__board">
        <?php foreach ($pxd_xx['cols'] as $pxd_c): ?>
        <div class="pxd-x__col pxd-x__col--<?= e($pxd_c[1]) ?>">
          <h3 class="pxd-x__ch"><i aria-hidden="true"></i><?= e($pxd_c[0]) ?> <span class="pxd-x__n"><?= count($pxd_c[2]) ?></span></h3>
          <ul>
            <?php foreach ($pxd_c[2] as $pxd_k): ?>
            <li class="pxd-x__card"><p class="pxd-x__ct"><?= e($pxd_k[0]) ?></p><p class="pxd-x__cm"><?= e($pxd_k[1]) ?></p><p class="pxd-x__cf"><?= e($pxd_k[2]) ?></p></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
      <figcaption class="pxd-x__foot"><?php if (!empty($pxd_xx['tag'])): ?><span class="pxd-x__tag"><?= xt_icon('approve') ?><?= e($pxd_xx['tag']) ?></span><?php endif; ?><span class="pxd-x__note"><?= e($pxd_xx['note']) ?></span></figcaption>
    </figure>
  </div>
</section>
