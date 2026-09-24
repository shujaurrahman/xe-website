<?php /* DRAFT COPY — review before launch */
/* Standards — frameworks this capability's delivery is built to (xt_badge + what each covers). Not certifications. */
?>
<section class="band band--alt aid-standards" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Frameworks we build to</p>
        <h2 class="h2" id="standards-t"><?= aid_h('std', 'Built to the frameworks', 'your reviewers will ask about.') ?></h2>
      </div>
      <div><p class="lead"><?= aid_lead('std', 'These shape the evaluation plan, the guardrails and the records we hand over. We build to them and align with them; they are not certifications we claim to hold.') ?></p></div>
    </div>
    <ul class="aih-std" role="list">
      <?php foreach ($CAP['standards'] as $aid_k): $aid_sd = xt_standard($aid_k); if (!$aid_sd) continue; ?>
        <li class="aih-std__i">
          <?= xt_badge($aid_k) ?>
          <div>
            <p class="aih-std__d"><?= e($aid_sd['covers']) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
