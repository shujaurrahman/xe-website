<?php /* DRAFT COPY — review before launch */ ?>
<?php /* FAQ: the capability's five questions, in the hub's .mth-faq pattern (native details, finished without JS). */ ?>
<section class="band band--alt mth-faq mtd-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="mth-faq__grid">
      <div class="bdh-head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">What teams ask</span> about <?= e(strtolower($CAP['short'])) ?>.</h2>
        <p class="lead">Anything else, ask us directly. A short call is usually quicker than a long email.</p>
      </div>
      <div class="mth-faq__list">
        <?php foreach ($CAP['faq'] as $mtd_i => $mtd_f): ?>
        <details class="mth-faq__q"<?= $mtd_i === 0 ? ' open' : '' ?>>
          <summary><span class="bdh-idx"><?= sprintf('%02d', $mtd_i + 1) ?></span><span class="mth-faq__t"><?= e($mtd_f[0]) ?></span><span class="mth-faq__pm" aria-hidden="true"></span></summary>
          <p class="p"><?= e($mtd_f[1]) ?></p>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
