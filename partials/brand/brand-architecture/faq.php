<?php /* DRAFT COPY — review before launch */
/* 12 · FAQ — questions pinned to a plan grid. A 4 × 4 grid (A–D × 1–4); each question occupies two
   cells on a staircase and opens in place (core [data-acc], one open at a time). Empty cells keep
   their grid reference; D4 holds the ask-us cell. Answers are $BD faq; related sheets are DRAFT COPY. */
$cba_faq = $CBA_CAP['faq'];
$cba_cols = ['A', 'B', 'C', 'D'];
$cba_slots = [[1, 1], [3, 2], [2, 3], [1, 4]];            /* [start column 1–4, row 1–4], each spans 2 columns */
$cba_rel = ['A-201 · Portfolio map & audit', 'A-205 · Migration plan', 'A-202 · Decision record', 'A-205 · Migration plan'];
$cba_taken = [];
foreach ($cba_slots as $cba_sl) { $cba_taken[$cba_sl[1] . '-' . $cba_sl[0]] = true; $cba_taken[$cba_sl[1] . '-' . ($cba_sl[0] + 1)] = true; }
$cba_taken['4-4'] = true;                                  /* D4: the ask-us cell */
?>
<section class="band cba-faq cba-paper" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="cba-head" data-rv>
      <div class="cba-head__t">
        <p class="cba-eb"><b>A-111</b><i aria-hidden="true"></i>Questions, located</p>
        <h2 class="h2" id="faq-t"><span class="g">Asked before</span> every architecture brief.</h2>
      </div>
      <div class="cba-head__l">
        <p class="lead">The questions leadership teams bring to the first meeting, each pinned to its place on the plan. Open one at a time.</p>
      </div>
    </div>

    <div class="cba-faq__plan" data-acc data-rv>
      <?php for ($cba_r = 1; $cba_r <= 4; $cba_r++): foreach ($cba_cols as $cba_ci => $cba_cl):
          if (isset($cba_taken[$cba_r . '-' . ($cba_ci + 1)])) continue; ?>
        <div class="cba-faq__cell" style="--c:<?= $cba_ci + 1 ?>;--r:<?= $cba_r ?>" aria-hidden="true"><span><?= $cba_cl . $cba_r ?></span></div>
      <?php endforeach; endfor; ?>

      <?php foreach ($cba_faq as $cba_fi => $cba_fq): [$cba_sc, $cba_sr] = $cba_slots[$cba_fi]; $cba_ref = $cba_cols[$cba_sc - 1] . $cba_sr; $cba_open = $cba_fi === 0; ?>
        <div class="cba-faq__q" style="--c:<?= $cba_sc ?>;--r:<?= $cba_sr ?>;--s:2">
          <h3 class="cba-faq__h">
            <button type="button" class="cba-faq__b" data-acc-b aria-expanded="<?= $cba_open ? 'true' : 'false' ?>" aria-controls="faq-p-<?= $cba_fi ?>" id="faq-b-<?= $cba_fi ?>">
              <span class="cba-faq__pin" aria-hidden="true"><i></i><?= $cba_ref ?></span>
              <span class="cba-faq__qt"><?= e($cba_fq[0]) ?></span>
              <span class="cba-faq__ic" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="cba-faq__p" id="faq-p-<?= $cba_fi ?>" data-acc-p role="region" aria-labelledby="faq-b-<?= $cba_fi ?>">
            <div class="cba-faq__a">
              <p><?= e($cba_fq[1]) ?></p>
              <p class="cba-mono">See sheet <b><?= e($cba_rel[$cba_fi]) ?></b></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="cba-faq__ask" style="--c:4;--r:4">
        <span class="cba-faq__pin" aria-hidden="true"><i></i>D4</span>
        <p class="cba-faq__askt">A question that is not on the plan?</p>
        <a class="cba-faq__link" href="<?= xe_url('contact.php') ?>">Ask the architecture team <span aria-hidden="true">›</span></a>
      </div>
    </div>
  </div>
</section>
