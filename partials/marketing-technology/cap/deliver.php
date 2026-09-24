<?php /* DRAFT COPY — review before launch */ ?>
<section class="band mtd-dlv" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap mtd-dlv__g">
    <div class="bdh-head mtd-dlv__h" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>What you own</p>
      <h2 class="h2" id="deliverables-t"><span class="g">Running in your stack,</span> documented to be changed.</h2>
      <p class="lead">Every <?= e(strtolower($CAP['short'])) ?> engagement ends with systems configured in your own accounts and the documents your team needs to run them without us.</p>
    </div>
    <div class="mtd-dlv__t bdh-scroll-x mask-x" tabindex="0" role="region" aria-label="<?= e($CAP['name']) ?> deliverables" data-rv>
      <table class="mtd-tbl">
        <caption class="bdh-sr"><?= e($CAP['name']) ?> deliverables and their formats</caption>
        <thead><tr><th scope="col">#</th><th scope="col">Deliverable</th><th scope="col">Format</th></tr></thead>
        <tbody>
          <?php foreach ($CAP['deliver'] as $mtd_i => $mtd_d): ?>
          <tr><td class="bdh-ro"><?= sprintf('%02d', $mtd_i + 1) ?></td><th scope="row"><?= e($mtd_d[0]) ?></th><td><span class="mtd-fmt"><?= e($mtd_d[1]) ?></span></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
