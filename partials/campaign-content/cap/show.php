<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Topic showcase — the second per-capability piece: a working ledger (table + readouts) from topic.php['show'].
   Real table markup (caption, th scope); at ≤600px each row reflows to a labelled card, so nothing scrolls sideways. */
$ccd_sw = $CCD_T['show'] ?? null;
if (!$ccd_sw) return;
$ccd_cell = function (string $ccd_v): string {
    if (preg_match('/^(ok|hold|flag):(.*)$/', $ccd_v, $ccd_m)) return '<span class="ccd-chip ccd-chip--' . $ccd_m[1] . '">' . e($ccd_m[2]) . '</span>';
    return e($ccd_v);
};
?>
<section class="band ccd-show" id="in-practice" aria-labelledby="in-practice-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span><?= e($ccd_sw['lbl']) ?></p>
        <h2 class="h2" id="in-practice-t"><span class="g"><?= e($ccd_sw['g']) ?></span> <?= e($ccd_sw['ink']) ?></h2></div>
      <div><p class="lead"><?= e($ccd_sw['lead']) ?></p></div>
    </div>
    <div class="ccd-show__g">
      <div class="ccd-show__win" data-rv>
        <div class="ccd-show__bar"><span class="ccd-sig__dots" aria-hidden="true"><i></i><i></i><i></i></span><span class="bdh-ro"><?= e($ccd_sw['ui']) ?></span><span class="bdh-ro ccd-show__sub"><?= e($ccd_sw['sub']) ?></span></div>
        <table class="ccd-show__t">
          <caption class="bdh-sr"><?= e($ccd_sw['ui']) ?>: illustrative sample</caption>
          <thead><tr><?php foreach ($ccd_sw['cols'] as $ccd_c): ?><th scope="col"><?= e($ccd_c) ?></th><?php endforeach; ?></tr></thead>
          <tbody>
            <?php foreach ($ccd_sw['rows'] as $ccd_r): ?>
            <tr>
              <th scope="row"><?= e($ccd_r[0]) ?></th>
              <?php foreach (array_slice($ccd_r, 1) as $ccd_j => $ccd_v): ?><td data-l="<?= e($ccd_sw['cols'][$ccd_j + 1]) ?>"><?= $ccd_cell($ccd_v) ?></td><?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- PLACEHOLDER: illustrative sample figures, not client results — confirm before launch -->
      <dl class="ccd-show__kpi" data-rv>
        <?php foreach ($ccd_sw['kpi'] as $ccd_k): ?>
        <div><dt><?= e($ccd_k[0]) ?></dt><dd><span class="ccd-show__v"><?= e($ccd_k[1]) ?></span><span class="ccd-show__n"><?= e($ccd_k[2]) ?></span></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>
    <p class="ccd-show__note"><span class="bdh-ro">Illustrative</span> <?= e($ccd_sw['note']) ?></p>
  </div>
</section>
