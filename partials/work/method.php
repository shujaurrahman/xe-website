<?php /* DRAFT COPY — review before launch */
/* Method — how a programme actually runs, in four stages, each with a plate and the artefact it
   produces. The rail above the cards is code-built and shows where each stage typically sits; the
   week bands are typical ranges, not commitments. */
$wrk_steps = [
    ['Discover', '0–3', 22, 'm-discover.jpg', 'A research interview being set up with a camera and notes', 1100, 733,
     'We start with the people the work is for and the systems it has to live inside. Interviews, a look at what already exists, and the numbers as they are now — not as the deck says they are.',
     ['Findings, with the evidence attached', 'The measures we will judge the work by', 'A plain list of what is in the way']],
    ['Shape', '3–8', 20, 'm-shape.jpg', 'A whiteboard with cards sorted into columns during a working session', 1800, 1192,
     'Options on the table, sized and sequenced, with the trade-offs written down. This is where the argument happens, on paper, before anything is expensive to change.',
     ['The approach, with its alternatives', 'A sequence with dependencies', 'The decision log, from day one']],
    ['Build', '8–20', 38, 'm-build.jpg', 'Engineers working at a whiteboard covered in diagrams', 1400, 934,
     'Working software and real artefacts every two weeks, reviewed by the people who will own them. Nothing is “done” until someone outside the team has used it.',
     ['The system, in your accounts', 'Documentation written as it is built', 'A handover that is rehearsed, not posted']],
    ['Run', 'ongoing', 20, 'm-run.jpg', 'An engineer working at a laptop at night with city lights behind', 1600, 1330,
     'After launch someone still answers. We watch the measures we agreed, fix what drifts, and hand over cleanly whenever you want to take it in-house.',
     ['A named team and a response path', 'A monthly read of the measures', 'An exit that does not punish you']],
];
?>
<section class="band wrk-method" id="method" aria-labelledby="method-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How a programme runs</p>
        <h2 class="h2" id="method-t"><span class="g">Four stages,</span> and an exit at the end of each.</h2>
      </div>
      <div>
        <p class="lead">Every programme in the index ran this way. The point of the stages is not ceremony — it is that you can stop at the end of any one of them with something that works and something you own.</p>
        <a class="tl" href="<?= xe_url('approach.php') ?>">The full approach <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <p class="wrk-rail bdh-ro" data-rv aria-hidden="true">
      <?php foreach ($wrk_steps as $wrk_i => $wrk_s): ?>
      <span class="wrk-rail__s" style="--f:<?= $wrk_s[2] ?>;--i:<?= $wrk_i ?>"><b><?= e($wrk_s[0]) ?></b><i>wk <?= e($wrk_s[1]) ?></i></span>
      <?php endforeach; ?>
    </p>
    <p class="bdh-sr">A typical programme runs four stages: Discover in weeks nought to three, Shape in weeks three to eight, Build in weeks eight to twenty, and Run from then on. The week bands are typical ranges, not commitments.</p>

    <ol class="wrk-method__grid" data-bdh-stagger data-bdh-in>
      <?php foreach ($wrk_steps as $wrk_i => $wrk_s): ?>
      <li class="wrk-step bdh-up">
        <!-- PLACEHOLDER: reference photograph (assets/imgs/work/CREDITS.md) — replace with own photography -->
        <?= wrk_img(['file' => $wrk_s[3], 'alt' => $wrk_s[4], 'w' => $wrk_s[5], 'h' => $wrk_s[6]], [
            'ratio' => 'r43', 'class' => 'wrk-step__img',
            'inner' => '<span class="wrk-step__n bdh-ro" aria-hidden="true">' . wrk_n($wrk_i + 1) . '</span>']) ?>
        <div class="wrk-step__b">
          <p class="wrk-step__k bdh-ro">Weeks <?= e($wrk_s[1]) ?></p>
          <h3 class="bdh-t bdh-t--l"><?= e($wrk_s[0]) ?></h3>
          <p class="bdh-d"><?= e($wrk_s[7]) ?></p>
          <p class="wrk-step__gl bdh-ro">What you leave with</p>
          <ul class="bdh-bullets"><?php foreach ($wrk_s[8] as $wrk_g): ?><li><?= e($wrk_g) ?></li><?php endforeach; ?></ul>
        </div>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
