<?php /* DRAFT COPY — review before launch */
/* Signature — Product Strategy & Vision: opportunity map scored against ambition. Six opportunities plotted by fit with
   the chosen ambition (x) and strength of evidence (y, which does not change with the ambition); bubble size is the
   size of the prize. Score = fit × evidence / 100, computed here so the ranking always matches the plot. */
$pxd_opts = [
    ['a', 'Ambition · Retention', 'Scored for retention: the plan-change fix and renewal alerts lead, both backed by strong evidence.'],
    ['b', 'Ambition · Expansion', 'Scored for expansion: team invites move to the top; upgrade prompts fit well but the evidence is thin, so test first.'],
    ['c', 'Ambition · Efficiency', 'Scored for efficiency: admin bulk actions lead; the AI setup assistant fits, but needs evidence before it is a bet.'],
];
$pxd_sr = 'An illustrative opportunity map: six opportunities plotted by fit with the ambition and strength of evidence, re-scored for retention, expansion and efficiency, with the top three listed.';
$pxd_op = [   // [name, evidence 0-100, prize 1-3, fit per ambition]
    ['Self-serve plan change',       80, 3, ['a' => 76, 'b' => 56, 'c' => 62]],
    ['Usage alerts before renewal',  66, 2, ['a' => 88, 'b' => 38, 'c' => 30]],
    ['Team invites in onboarding',   72, 3, ['a' => 46, 'b' => 88, 'c' => 24]],
    ['AI setup assistant',           30, 2, ['a' => 52, 'b' => 66, 'c' => 76]],
    ['Admin bulk actions',           60, 1, ['a' => 28, 'b' => 22, 'c' => 90]],
    ['In-app upgrade prompts',       38, 2, ['a' => 18, 'b' => 82, 'c' => 14]],
];
$pxd_rank = [];
foreach (['a', 'b', 'c'] as $pxd_v) {
    $pxd_sc = [];
    foreach ($pxd_op as $pxd_i => $pxd_o) $pxd_sc[$pxd_i] = (int) round($pxd_o[3][$pxd_v] * $pxd_o[1] / 100);
    arsort($pxd_sc);
    $pxd_rank[$pxd_v] = array_slice($pxd_sc, 0, 3, true);
}
?>
<div class="pxd-om">
  <div class="pxd-om__plot">
    <span class="pxd-om__q pxd-om__q--tl">Park</span><span class="pxd-om__q pxd-om__q--tr">Bet now</span>
    <span class="pxd-om__q pxd-om__q--bl">Drop</span><span class="pxd-om__q pxd-om__q--br">Test first</span>
    <?php foreach ($pxd_op as $pxd_i => $pxd_o): ?>
    <span class="pxd-om__b pxd-om__b--<?= $pxd_o[2] ?>" style="--y:<?= $pxd_o[1] ?>%;<?php foreach ($pxd_o[3] as $pxd_v => $pxd_x) echo "--x$pxd_v:$pxd_x%;"; ?>" data-hi="<?= e(implode(' ', array_keys(array_filter($pxd_rank, fn ($pxd_r) => array_key_first($pxd_r) === $pxd_i)))) ?>"><?= $pxd_i + 1 ?></span>
    <?php endforeach; ?>
    <span class="pxd-om__ax pxd-om__ax--x">Fit with ambition →</span>
    <span class="pxd-om__ax pxd-om__ax--y">Evidence →</span>
  </div>
  <div class="pxd-om__side">
    <p class="pxd-om__h">Top three · fit × evidence</p>
    <?php foreach ($pxd_rank as $pxd_v => $pxd_r): ?>
    <ol class="pxd-om__rank" data-on="<?= $pxd_v ?>">
      <?php foreach ($pxd_r as $pxd_i => $pxd_s): ?>
      <li><span class="pxd-om__n"><?= $pxd_i + 1 ?></span><span class="pxd-om__nm"><?= e($pxd_op[$pxd_i][0]) ?></span><b><?= $pxd_s ?></b></li>
      <?php endforeach; ?>
    </ol>
    <?php endforeach; ?>
    <p class="pxd-om__key"><i class="s1"></i><i class="s2"></i><i class="s3"></i>Size of the prize</p>
  </div>
</div>
