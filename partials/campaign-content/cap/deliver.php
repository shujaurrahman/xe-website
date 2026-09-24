<?php /* DRAFT COPY — review before launch */ ?>
<section class="band band--alt ccd-deliver" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap ccd-deliver__g">
    <div class="bdh-head ccd-deliver__h" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>What you get</p>
      <h2 class="h2" id="deliverables-t"><span class="g">Handed over,</span> not held back.</h2>
      <p class="lead">Every <?= e(strtolower($CAP['short'])) ?> engagement ends with working files your team owns: source, templates, rights and the dashboard, in the tools you already use.</p>
    </div>
    <table class="ccd-tbl" data-rv>
      <caption class="bdh-sr"><?= e($CAP['name']) ?> deliverables and their formats</caption>
      <thead><tr><th scope="col">#</th><th scope="col">Deliverable</th><th scope="col">Format</th></tr></thead>
      <tbody>
        <?php foreach ($CAP['deliver'] as $ccd_i => $ccd_d): ?>
        <tr><td class="bdh-ro"><?= sprintf('%02d', $ccd_i + 1) ?></td><th scope="row"><?= e($ccd_d[0]) ?></th><td><span class="ccd-fmt"><?= e($ccd_d[1]) ?></span></td></tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
