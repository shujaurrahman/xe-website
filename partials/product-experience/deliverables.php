<?php /* DRAFT COPY — review before launch */
/* Deliverables — the handover manifest: what each capability leaves in your tools, as a folder per capability
   with the format of every item (data 'deliver'). Plain HTML, complete without JavaScript. */
?>
<section class="band pxh-deliverables" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>What you keep</p>
        <h2 class="h2" id="deliverables-t"><span class="g">No deck to decode.</span> Working files, in your tools.</h2></div>
      <div><p class="lead">Every engagement ends with a handover manifest: the evidence, the decisions and the working files, stored where your teams already work and owned by you from the first day.</p></div>
    </div>
    <div class="pxh-man" data-bdh-stagger>
      <?php foreach ($CAPS as $pxh_slug => $pxh_cap): ?>
      <div class="pxh-man__f">
        <p class="pxh-man__path"><?= xt_icon('layers') ?>/handover/<?= e($pxh_cap['n']) ?>-<?= e(strtolower(str_replace(' ', '-', $pxh_cap['short']))) ?>/</p>
        <h3 class="pxh-man__t"><?= e($pxh_cap['name']) ?></h3>
        <ul class="pxh-man__list">
          <?php foreach ($pxh_cap['deliver'] as $pxh_d): ?>
          <li><span><?= e($pxh_d[0]) ?></span><em><?= e($pxh_d[1]) ?></em></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endforeach; ?>
      <div class="pxh-man__f pxh-man__f--all">
        <p class="pxh-man__path"><?= xt_icon('check') ?>/handover/README</p>
        <h3 class="pxh-man__t">In every handover</h3>
        <ul class="pxh-man__list">
          <li><span>Decision record, with evidence links</span><em>Doc</em></li>
          <li><span>Assumption tracker, final states</span><em>Sheet</em></li>
          <li><span>Research consent &amp; retention log</span><em>Sheet</em></li>
          <li><span>Walkthrough session, recorded</span><em>Video</em></li>
        </ul>
      </div>
    </div>
  </div>
</section>
