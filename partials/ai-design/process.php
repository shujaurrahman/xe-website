<?php /* DRAFT COPY — review before launch */
/* Process — the stepper (.aih-steps). All content ships visible; process.js fills the progress rail on scroll. */
$aih_steps = [
    ['Frame',    'Week 1–2',  'Who uses it, what it may see and do, what it must never do. Failure modes and the evaluation set are written before any feature.', ['Brief & risk map', 'Evaluation set v1']],
    ['Prototype','Week 2–6',  'Built on a live model from the first week, because paper cannot show how a probabilistic system feels.', ['Live prototype', 'Model shortlist']],
    ['Evaluate', 'Week 4–8',  'Candidate models scored on your material; real users tested on real prompts, including the ones the model gets wrong.', ['Scorecard', 'Usability findings']],
    ['Govern',   'Week 6–10', 'Guardrails, approval roles and the audit record set up, with the regulatory position written down.', ['Guardrail config', 'Approval workflow']],
    ['Hand over','Week 8–12', 'Your team runs it: specifications, prompts, weights, evaluation sets and a playbook for the day a model changes.', ['Specification', 'Runbook & training']],
];
?>
<section class="band band--alt aih-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How an engagement runs</p>
        <h2 class="h2" id="process-t"><span class="g">Evaluation first.</span> Everything else follows from it.</h2>
      </div>
      <div>
        <!-- PLACEHOLDER: confirm typical timeframes before launch -->
        <p class="lead">A typical engagement runs eight to twelve weeks. The order does not change: we agree how success is scored before anything is generated.</p>
      </div>
    </div>
    <div class="aih-stepper" data-aih-steps>
    <span class="aih-steps__bar" aria-hidden="true"></span>
    <ol class="aih-steps" style="--n:<?= count($aih_steps) ?>">
      <?php foreach ($aih_steps as $aih_i => $aih_s): ?>
        <li class="aih-step">
          <span class="aih-step__i" aria-hidden="true"><?= str_pad((string) ($aih_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <span class="aih-step__time"><?= e($aih_s[1]) ?></span>
          <h3 class="aih-step__t"><?= e($aih_s[0]) ?></h3>
          <p class="aih-step__d"><?= e($aih_s[2]) ?></p>
          <ul class="aih-step__out" aria-label="Outputs">
            <?php foreach ($aih_s[3] as $aih_o): ?><li><?= e($aih_o) ?></li><?php endforeach; ?>
          </ul>
        </li>
      <?php endforeach; ?>
    </ol>
    </div>
  </div>
</section>
