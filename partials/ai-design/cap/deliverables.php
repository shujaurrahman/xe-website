<?php /* DRAFT COPY — review before launch */
/* Deliverables — the handover list as a numbered manifest (item, format), from data/ai-design.php['deliver']. */
?>
<section class="band aid-deliverables" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap aid-dl">
    <div class="aid-dl__head">
      <p class="lbl lbl--blue"><span class="dot"></span>What you keep</p>
      <h2 class="h2" id="deliverables-t"><?= aid_h('deliver', 'Handed over,', 'in your accounts, from week one.') ?></h2>
      <p class="p"><?= aid_lead('deliver', 'Everything below lives in your repositories and workspaces as it is made, so the work keeps running after we leave.') ?></p>
    </div>
    <div class="aid-dl__sheet">
      <p class="aid-dl__cap"><span>Manifest · <?= e($CAP['short']) ?></span><span><?= count($CAP['deliver']) ?> items</span></p>
      <table class="aid-dl__t">
        <caption class="bdh-sr"><?= e($CAP['name']) ?> deliverables and their formats</caption>
        <thead><tr><th scope="col">#</th><th scope="col">Deliverable</th><th scope="col">Format</th></tr></thead>
        <tbody>
          <?php foreach ($CAP['deliver'] as $aid_i => $aid_dv): ?>
            <tr><td><?= str_pad((string) ($aid_i + 1), 2, '0', STR_PAD_LEFT) ?></td><th scope="row"><?= e($aid_dv[0]) ?></th><td><?= e($aid_dv[1]) ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
