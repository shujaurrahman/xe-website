<?php /* DRAFT COPY — review before launch */
/* AI-native — shown, not claimed: where models sit inside the practice, and the human approval, redaction,
   evaluation and audit that wrap them. The run window is a mock (aria-hidden + .bdh-sr). */
$pxh_ai_uses = [
    ['brain', 'Research synthesis', 'An agent clusters interview transcripts into proposed themes. A researcher approves, merges or rejects every one, and each theme links back to the quotes behind it.'],
    ['sparkle', 'Prototypes on live models', 'AI features are prototyped against the real model and real data shapes, so usability tests react to actual output, including the wrong answers.'],
    ['eval', 'Evaluations before demos', 'Every AI feature gets a versioned evaluation set: expected behaviour, refusals and failure cases, run on each prompt or model change.'],
    ['accessibility', 'Design QA in the pipeline', 'Automated contrast, target-size and keyboard checks run on every component change; a person reviews what automation cannot judge.'],
];
$pxh_ai_themes = [
    ['Plan changes are triggered by team changes', '14 quotes', 'approved'],
    ['Billing is hard to find from settings', '11 quotes', 'approved'],
    ['Price is the main reason to downgrade', '3 quotes', 'rejected'],
    ['Fear of data loss on switching', '9 quotes', 'approved'],
    ['Support wait time frustrates', '7 quotes', 'merged'],
];
?>
<section class="band band--ink pxh-ai" id="ai" aria-labelledby="ai-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>AI-native, with a person on every decision</p>
        <h2 class="h2" id="ai-t"><span class="g">Models do the sorting.</span> People make the calls.</h2></div>
      <div><p class="lead">We use AI where it makes the evidence faster to gather and harder to ignore. It never approves its own work: every theme, prompt and release has a named human reviewer and an audit trail.</p></div>
    </div>
    <div class="pxh-ai__g">
      <ul class="pxh-ai__uses" data-bdh-stagger>
        <?php foreach ($pxh_ai_uses as $pxh_u): ?>
        <li class="pxh-card pxh-card--ink">
          <span class="pxh-card__ico"><?= xt_icon($pxh_u[0]) ?></span>
          <h3 class="pxh-card__t"><?= e($pxh_u[1]) ?></h3>
          <p class="pxh-card__d"><?= e($pxh_u[2]) ?></p>
        </li>
        <?php endforeach; ?>
      </ul>
      <div class="pxh-ai__run" data-bdh-live>
        <div class="pxh-ai__win" aria-hidden="true">
          <div class="pxh-ai__bar"><span class="pxh-ai__pulse"></span>Synthesis run 0412 · Idea 014<span class="sp">Human review</span></div>
          <ol class="pxh-ai__pipe">
            <li><b>24</b><span>Transcripts</span></li>
            <li><b>PII</b><span>Redacted first</span></li>
            <li><b>312</b><span>Quotes tagged</span></li>
            <li><b>5</b><span>Themes proposed</span></li>
          </ol>
          <ul class="pxh-ai__q">
            <?php foreach ($pxh_ai_themes as $pxh_t): ?>
            <li class="is-<?= $pxh_t[2] ?>"><span class="t"><?= e($pxh_t[0]) ?></span><span class="n"><?= e($pxh_t[1]) ?></span><span class="s"><?= e($pxh_t[2]) ?></span></li>
            <?php endforeach; ?>
          </ul>
          <div class="pxh-ai__log">
            <span>12:04 · reviewer R. approved 3 · rejected 1 · merged 1</span>
            <span>12:04 · every theme linked to its source quotes</span>
            <span>12:05 · run logged · model, prompt v7, reviewer</span>
          </div>
        </div>
        <p class="bdh-sr">Illustration of an AI research-synthesis run: 24 transcripts are redacted for personal data, 312 quotes are tagged and 5 themes are proposed; a researcher approves three, rejects one and merges one, and the run is logged with the model, prompt version and reviewer.</p>
        <ul class="pxh-ai__guard" aria-label="Guardrails on every run">
          <li><?= xt_icon('shield') ?>Personal data redacted before any model call</li>
          <li><?= xt_icon('approve') ?>A named person approves every output</li>
          <li><?= xt_icon('link') ?>Every theme traces to its quotes</li>
          <li><?= xt_icon('log') ?>Model, prompt version and reviewer logged</li>
        </ul>
      </div>
    </div>
  </div>
</section>
