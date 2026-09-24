<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Topic showcase — the second per-capability piece: a working ledger (table + readouts) from topic.php['show'].
   Real table markup (caption, th scope); at ≤600px each row reflows to a labelled card, so nothing scrolls sideways. */
$aid_sw = $AID_T['show'] ?? null;
if (!$aid_sw) return;
$aid_cell = function (string $aid_v): string {
    if (preg_match('/^(ok|hold|flag):(.*)$/', $aid_v, $aid_m)) return '<span class="aid-chip aid-chip--' . $aid_m[1] . '">' . e($aid_m[2]) . '</span>';
    return e($aid_v);
};
?>
<section class="band aid-show" id="in-practice" aria-labelledby="in-practice-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span><?= e($aid_sw['lbl']) ?></p>
        <h2 class="h2" id="in-practice-t"><span class="g"><?= e($aid_sw['g']) ?></span> <?= e($aid_sw['ink']) ?></h2></div>
      <div><p class="lead"><?= e($aid_sw['lead']) ?></p></div>
    </div>
    <div class="aid-show__g">
      <div class="aid-show__win" data-rv>
        <div class="aid-show__bar"><span class="aid-show__dots" aria-hidden="true"><i></i><i></i><i></i></span><span class="bdh-ro"><?= e($aid_sw['ui']) ?></span><span class="bdh-ro aid-show__sub"><?= e($aid_sw['sub']) ?></span></div>
        <table class="aid-show__t">
          <caption class="bdh-sr"><?= e($aid_sw['ui']) ?>: illustrative sample</caption>
          <thead><tr><?php foreach ($aid_sw['cols'] as $aid_c): ?><th scope="col"><?= e($aid_c) ?></th><?php endforeach; ?></tr></thead>
          <tbody>
            <?php foreach ($aid_sw['rows'] as $aid_r): ?>
            <tr>
              <th scope="row"><?= e($aid_r[0]) ?></th>
              <?php foreach (array_slice($aid_r, 1) as $aid_j => $aid_v): ?><td data-l="<?= e($aid_sw['cols'][$aid_j + 1]) ?>"><?= $aid_cell($aid_v) ?></td><?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- PLACEHOLDER: illustrative sample figures, not client results — confirm before launch -->
      <dl class="aid-show__kpi" data-rv>
        <?php foreach ($aid_sw['kpi'] as $aid_k): ?>
        <div><dt><?= e($aid_k[0]) ?></dt><dd><span class="aid-show__v"><?= e($aid_k[1]) ?></span><span class="aid-show__n"><?= e($aid_k[2]) ?></span></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>
    <p class="aid-show__note"><span class="bdh-ro">Illustrative</span> <?= e($aid_sw['note']) ?></p>
  </div>
</section>
