<?php /* DRAFT COPY — review before launch */
/* Stakes — why this discipline sits ahead of the build. A four-stage chart of what it costs to change
   your mind, then the four ways a product goes wrong and the capability that answers each. The bars are
   in the markup at their heights and only grow in; the phrases, not numbers, carry the argument, because
   the multipliers people quote for this curve are not something we can evidence. */
$stk_stages = [
    // [n, stage, height %, what a change costs, what actually happens]
    ['01', 'Concept',  9,   'A conversation',   'Redraw the sketch, rewrite the brief. Nobody outside the room notices.'],
    ['02', 'Design',   24,  'A redraw',         'Change the flow, re-test it, update the spec. A few days of one team.'],
    ['03', 'Build',    56,  'A sprint',         'Rework code, tests, content and analytics. Other work stops while it happens.'],
    ['04', 'Live',     100, 'A quarter',        'Migrate data, retrain support, tell customers, and carry the old path until they move.'],
];
$stk_modes = [
    [
        'n' => '01', 'icon' => 'target',
        't' => 'Built the wrong thing',
        'd' => 'The release lands on time and nothing moves. The demand was assumed rather than found, and the roadmap slot it took is gone.',
        'tell' => 'Usage flat after launch',
        'caps' => ['product-strategy-vision', 'design-consulting-solutioning'],
    ],
    [
        'n' => '02', 'icon' => 'users',
        't' => 'Built the right thing badly',
        'd' => 'People find the feature and abandon it. Support answers the same question every week. The idea gets blamed for what the interface did.',
        'tell' => 'Same ticket, every week',
        'caps' => ['experience-design-development'],
    ],
    [
        'n' => '03', 'icon' => 'sparkle',
        't' => 'Shipped AI nobody keeps using',
        'd' => 'Adoption spikes in week one and falls away by week four, because the feature had no good answer for the times the model is wrong.',
        'tell' => 'Week-four adoption gone',
        'caps' => ['ai-product-strategy-development'],
    ],
    [
        'n' => '04', 'icon' => 'cube',
        't' => 'Built it four times',
        'd' => 'Four teams, four date pickers, four focus bugs. Every accessibility fix has to be made four times, and one of them is always missed.',
        'tell' => 'One fix, four places',
        'caps' => ['system-design'],
    ],
];
$stk_name = fn (string $stk_s): array => [$CAPS[$stk_s]['n'], $CAPS[$stk_s]['short']];
?>
<section class="band band--alt pxh-stakes" id="stakes" aria-labelledby="stakes-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Why it sits first</p>
        <h2 class="h2" id="stakes-t"><span class="g">The expensive mistake</span> is the one you already built.</h2>
      </div>
      <div>
        <p class="lead">Changing your mind gets steadily more expensive as a product gets more real. Everything in this discipline is arranged to move the decision as far left as the evidence allows.</p>
      </div>
    </div>

    <div class="pxh-stakes__top">
      <figure class="pxh-stakes__chart" data-rv>
        <figcaption class="pxh-stakes__cap">
          <span class="pxh-k">What it costs to change your mind</span>
          <span class="pxh-k pxh-stakes__axis">Relative, not measured</span>
        </figcaption>
        <div class="pxh-stakes__zone" aria-hidden="true"><span class="pxh-stakes__here">We work at this end</span></div>
        <ol class="pxh-stakes__grid">
          <?php foreach ($stk_stages as $stk_i => $stk_s): ?>
            <li class="pxh-stakes__col" style="--i:<?= $stk_i ?>">
              <span class="pxh-stakes__track"><i class="pxh-stakes__fill" style="--h:<?= $stk_s[2] ?>"></i></span>
              <span class="pxh-stakes__stage"><b><?= e($stk_s[0]) ?></b><?= e($stk_s[1]) ?></span>
              <span class="pxh-stakes__cost"><?= e($stk_s[3]) ?></span>
              <span class="pxh-stakes__what"><?= e($stk_s[4]) ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
      </figure>

      <div class="pxh-stakes__aside" data-rv data-rv-d="80">
        <!-- PLACEHOLDER: reference photograph (Unsplash, credited in assets/imgs/product-experience/CREDITS.md)
             — replace with commissioned photography before launch -->
        <figure class="pxh-stakes__fig">
          <span class="bdh-img bdh-img--r43">
            <img src="<?= xe_url('assets/imgs/product-experience/planning-wall.jpg') ?>" alt="Two colleagues moving sticky notes between quarterly columns on a glass wall" width="1000" height="750" loading="lazy" decoding="async">
          </span>
          <figcaption class="pxh-stakes__figcap">Sorting a roadmap on a wall is cheap. Building the wrong half of it is not.</figcaption>
        </figure>
        <p class="pxh-note">The shape of this curve is one of the oldest findings in software delivery. The multipliers people quote for it are not, so we do not quote any. What we will commit to is where the work happens: the assumptions that would cost most to get wrong are tested in the first three weeks, while changing course is still a conversation.</p>
      </div>
    </div>

    <div class="pxh-stakes__modes">
      <p class="pxh-k pxh-stakes__mk">Four ways it goes wrong, and which capability answers each</p>
      <ul class="pxh-cards pxh-stakes__cards" role="list" data-rv-s data-rv-step="70">
        <?php foreach ($stk_modes as $stk_m): ?>
          <li class="pxh-card pxh-card--lift pxh-stakes__card">
            <span class="pxh-card__top">
              <span class="pxh-card__n"><?= e($stk_m['n']) ?></span>
              <span class="pxh-card__ico" aria-hidden="true"><?= xt_icon($stk_m['icon'], ['size' => 22]) ?></span>
            </span>
            <h3 class="pxh-card__t"><?= e($stk_m['t']) ?></h3>
            <p class="pxh-card__d"><?= e($stk_m['d']) ?></p>
            <span class="pxh-stakes__tell"><span class="pxh-k">The tell</span><b><?= e($stk_m['tell']) ?></b></span>
            <span class="pxh-card__foot">
              <span class="pxh-capls">
                <?php foreach ($stk_m['caps'] as $stk_c): [$stk_n, $stk_sh] = $stk_name($stk_c); ?>
                  <a class="pxh-capl" href="#<?= e($stk_c) ?>"><b><?= e($stk_n) ?></b><span><?= e($stk_sh) ?></span><i aria-hidden="true">›</i></a>
                <?php endforeach; ?>
              </span>
            </span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
