<?php /* DRAFT COPY — review before launch */
/* Process — the stepper idiom (.pxh-steps): six stages, each ending in a gate question that must be answered
   before the next one starts. Capability pages render their own process (data 'process') with the same markup. */
$pxh_pr = [
    ['Frame', 'Week 1', 'Name the decision the work has to support, and the assumption most likely to break it. Agree the measure that will say whether it worked.', ['Decision brief', 'Assumption map', 'Baseline'], 'Is the question worth answering?'],
    ['Discover', 'Weeks 1–4', 'Interviews, analytics, support tickets and a look at what already exists. Evidence is tagged into one base, so every finding keeps its source.', ['Evidence base', 'Opportunity map'], 'Is there a real problem, and for whom?'],
    ['Shape', 'Weeks 2–6', 'Journeys, information architecture and wireframes, drawn to the same depth for every option and sized with the engineers who would build them.', ['Journeys', 'Wireframes', 'Effort & risk'], 'Can we build it, and at what cost?'],
    ['Prove', 'Weeks 3–8', 'Prototypes in front of real users; for AI features, the evaluation set runs before anyone sees a demo.', ['Prototype', 'Session clips', 'Eval results'], 'Did people complete the task?'],
    ['Ship', 'Weeks 6–16', 'Front end and components built from the design system, with accessibility and performance checks in the pipeline and a staged rollout.', ['Components', 'Accessibility report', 'Release plan'], 'Does it meet the bar we agreed?'],
    ['Measure', 'Ongoing', 'Results against the baseline from week one, reviewed with your team. What we learn becomes the next loop’s first signal.', ['Outcome dashboard', 'Decision record'], 'Keep, change or retire?'],
];
?>
<section class="band pxh-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-grid">
      <div class="bdh-c5 pxh-process__l">
        <div class="bdh-sticky">
          <div class="bdh-head" data-rv>
            <p class="lbl lbl--blue"><span class="dot"></span>How it runs</p>
            <h2 class="h2" id="process-t"><span class="g">Six stages.</span> A gate between each one.</h2>
            <p class="lead">Every stage ends with a question that has to be answered with evidence before money moves to the next. Most engagements enter at the stage the product is already in.</p>
          </div>
          <figure class="bdh-img bdh-img--r43 pxh-process__img">
            <img src="<?= e(xe_url('assets/imgs/product-experience/process-whiteboard.jpg')) ?>" width="1400" height="934" loading="lazy" decoding="async" alt="An engineer sketches a system diagram on a whiteboard during a working session">
            <figcaption class="bdh-cap-chip">Shape · sized with engineers</figcaption>
          </figure>
          <!-- PLACEHOLDER: confirm typical stage timings before launch -->
          <p class="pxh-note">Timings are typical for a full loop and shorten when an engagement starts later in it.</p>
        </div>
      </div>
      <ol class="bdh-c6 bdh-s7 pxh-steps" data-bdh-stagger>
        <?php foreach ($pxh_pr as $pxh_i => $pxh_s): ?>
        <li class="pxh-steps__i<?= $pxh_i === 3 ? ' is-key' : '' ?>">
          <span class="pxh-steps__n" aria-hidden="true">0<?= $pxh_i + 1 ?></span>
          <div class="pxh-steps__b">
            <h3 class="pxh-steps__t"><?= e($pxh_s[0]) ?> <small><?= e($pxh_s[1]) ?></small></h3>
            <p class="pxh-steps__d"><?= e($pxh_s[2]) ?></p>
            <ul class="pxh-steps__out" aria-label="Outputs"><?php foreach ($pxh_s[3] as $pxh_o): ?><li><?= e($pxh_o) ?></li><?php endforeach; ?></ul>
            <p class="pxh-steps__gate">Gate · <?= e($pxh_s[4]) ?></p>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
