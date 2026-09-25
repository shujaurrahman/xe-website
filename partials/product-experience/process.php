<?php /* DRAFT COPY — review before launch */
/* Process — how an engagement runs: the four phases as the stepper idiom, then the two-week loop the
   middle of it is made of, drawn as a cycle, and what we need from you for any of it to work.
   PLACEHOLDER: the week ranges below are typical for a project of this shape, not a commitment. */
$prc_steps = [
    ['01', 'Frame',            'Wk 01–02',
     'The decision to be made, the constraints that are real rather than assumed, the people affected and what success looks like twelve months out.',
     ['Decision brief', 'Constraint map', 'Success measures']],
    ['02', 'Prove',            'Wk 02–06',
     'Routes drawn to the same depth, the assumption that would cost most to be wrong about tested with real users, and every route sized by the engineers who would build it.',
     ['Route options', 'Tested prototype', 'Effort &amp; cost model']],
    ['03', 'Design and build', 'Wk 06–16',
     'Two-week loops, each carrying one question, one thing to try and a session with users. Front-end engineering runs alongside design rather than after it.',
     ['Journey maps', 'Designs with every state', 'Front-end code']],
    ['04', 'Hand over',        'Wk 14–18',
     'The release behind a flag, the benchmark repeated against the baseline, the system documented and your team trained on the parts they will own.',
     ['Benchmark comparison', 'Documentation', 'Adoption plan']],
];
/* the loop: five stops on a cycle, drawn at r = 105 around (290, 165) */
$prc_loop = [
    ['01', 'Question',            290,  60, 290,  33, 'middle', 'The one thing this fortnight has to settle.'],
    ['02', 'Make',                390, 133, 416, 124, 'start',  'The smallest thing that could answer it — a sketch, a flow, a coded screen.'],
    ['03', 'Test with users',     352, 250, 368, 272, 'start',  'Five to eight people, the same script, watched by whoever will build it.'],
    ['04', 'Decide',              228, 250, 212, 272, 'end',    'Keep it, change it or drop it, in writing, the same afternoon.'],
    ['05', 'Rewrite the backlog', 190, 133, 164, 124, 'end',    'The tickets change because of what came back, not because of the plan.'],
];
$prc_need = [
    ['approve', 'Someone who can say yes',
     'One person with the authority to choose between the routes, in the room for the framing session and the recommendation. Without that, a decision project becomes a document project.'],
    ['users', 'Access to your customers',
     'Five to eight people per round who actually use the product, or a list we can recruit from. We handle the scheduling, consent and incentives; you clear the way.'],
    ['code', 'An engineer who can size things',
     'A few hours a week from someone who knows the systems, so an effort range is theirs rather than ours. Estimates made without them are the ones that get revised.'],
    ['log', 'Your own evidence',
     'Read access to analytics, support tickets and whatever research already exists. Most teams know more than they think; it is just spread across four tools.'],
];
?>
<section class="band pxh-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How it runs</p>
        <h2 class="h2" id="process-t"><span class="g">Four phases,</span> and a loop in the middle.</h2>
      </div>
      <div>
        <p class="lead">Each phase settles one question and hands over something you could act on if we stopped there. The middle of it is not a phase at all but a loop that repeats every fortnight until the evidence runs out of surprises.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: typical week ranges for a project of this shape — confirm before launch -->
    <ol class="pxh-steps pxh-process__steps" data-rv-s data-rv-step="90">
      <?php foreach ($prc_steps as $prc_i => $prc_s): ?>
        <li class="pxh-step" style="--i:<?= $prc_i ?>">
          <p class="pxh-step__h"><span class="pxh-step__n"><?= e($prc_s[0]) ?></span><span class="pxh-step__w"><?= e($prc_s[2]) ?></span></p>
          <h3 class="pxh-step__t"><?= e($prc_s[1]) ?></h3>
          <p class="pxh-step__d"><?= e($prc_s[3]) ?></p>
          <ul class="pxh-step__out">
            <?php foreach ($prc_s[4] as $prc_o): ?><li><?= $prc_o ?></li><?php endforeach; ?>
          </ul>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="pxh-process__cols">
      <figure class="pxh-process__loop" data-rv data-bdh-live>
        <figcaption class="pxh-process__lk"><span class="pxh-k">Phase 03 · the fortnight</span></figcaption>
        <p class="bdh-sr">A cycle of five stops repeating every two weeks: one question, something made to answer it, a session with users, a decision, and the backlog rewritten by what came back.</p>
        <div class="pxh-dia pxh-process__ring" style="--ar:580 / 340" aria-hidden="true">
          <svg viewBox="0 0 580 340" fill="none" focusable="false">
            <circle class="pxh-process__track" cx="290" cy="165" r="105"/>
            <g class="pxh-process__spin"><path class="pxh-process__arc" d="M290 60 A105 105 0 0 1 384.5 118.5"/></g>
            <?php foreach ($prc_loop as $prc_li => $prc_l): ?>
              <circle class="pxh-process__node<?= $prc_li === 0 ? ' is-first' : '' ?>" cx="<?= $prc_l[2] ?>" cy="<?= $prc_l[3] ?>" r="11"/>
              <text class="pxh-process__nn" x="<?= $prc_l[2] ?>" y="<?= $prc_l[3] + 3.5 ?>" text-anchor="middle"><?= e($prc_l[0]) ?></text>
              <text class="pxh-process__nl" x="<?= $prc_l[4] ?>" y="<?= $prc_l[5] ?>" text-anchor="<?= e($prc_l[6]) ?>"><?= e($prc_l[1]) ?></text>
            <?php endforeach; ?>
            <text class="pxh-process__cl" x="290" y="158" text-anchor="middle">Every two weeks</text>
            <text class="pxh-process__cs" x="290" y="180" text-anchor="middle">ONE QUESTION AT A TIME</text>
          </svg>
        </div>
        <ol class="pxh-process__stops">
          <?php foreach ($prc_loop as $prc_l): ?>
            <li><span class="pxh-process__sn"><?= e($prc_l[0]) ?></span><b><?= e($prc_l[1]) ?></b><span><?= e($prc_l[7]) ?></span></li>
          <?php endforeach; ?>
        </ol>
        <p class="pxh-note">A loop that ends in a document is a meeting. Each of ours ends with something a person outside the team has tried, and a line in the backlog that changed because of it.</p>
      </figure>

      <div class="pxh-process__need">
        <div class="pxh-process__nh" data-rv>
          <p class="pxh-k">What we need from you</p>
          <p class="pxh-process__nt">Four things. None of them is a weekly steering committee.</p>
        </div>
        <ul class="pxh-cards pxh-cards--2 pxh-process__cards" role="list" data-rv-s data-rv-step="70">
          <?php foreach ($prc_need as $prc_ni => $prc_n): ?>
            <li class="pxh-card pxh-card--flat pxh-card--soft">
              <span class="pxh-card__top">
                <span class="pxh-card__n"><?= str_pad((string) ($prc_ni + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <span class="pxh-card__ico" aria-hidden="true"><?= xt_icon($prc_n[0], ['size' => 22]) ?></span>
              </span>
              <h3 class="pxh-card__t pxh-card__t--s"><?= e($prc_n[1]) ?></h3>
              <p class="pxh-card__d"><?= e($prc_n[2]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>
