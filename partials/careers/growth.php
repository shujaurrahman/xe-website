<?php /* DRAFT COPY — review before launch */
/* Growth and learning — the critique ladder (how craft actually moves here), the review rhythm, and
   the one thing this company can offer that a single-discipline studio cannot: moving between
   practices without leaving. Photograph is stock and captioned as stock.
   Locals prefixed gr_. */

/* PLACEHOLDER: confirm the review cadence, the mentoring arrangement and the learning allowance
   before launch. Anything not confirmed should be cut rather than softened. */
$gr_ladder = [
    ['Week 1',      'A named mentor, not a buddy scheme', 'Someone in your practice who is accountable for you being useful by the end of month one, with a standing thirty minutes a week.'],
    ['Every week',  'Critique, both ways',                'You present work and you review other people\'s. Reviewing is where most of the learning happens, and it starts in your first month.'],
    ['Every month', 'One-to-one on the work, not the mood', 'What you shipped, what got stuck, what you want next. Written down, so the next one can start where the last one ended.'],
    ['Every six months', 'A level conversation',           'Where you are against the level you are aiming at, with examples. Pay is reviewed against the level, and the conversation happens whether or not you ask for it.'],
];

$gr_learn = [
    ['Learning time in the week',  'Time set aside for learning inside working hours rather than an evening hobby. Confirm the exact allowance before launch.'],
    ['A budget for courses and conferences', 'For the thing you have actually decided to get better at, agreed with your lead. Confirm the amount and the approval route before launch.'],
    ['Internal teach-backs',       'Anyone who learns something on an engagement writes it up or presents it. It is how one practice picks up what another one worked out.'],
    ['Access to the tooling',      'Licences and model access for the tools the work needs, including the expensive ones, because judgement about a tool requires using it.'],
];

$gr_move = [
    'An engineer who wants to move into AI engineering starts by owning the eval suite on a live engagement.',
    'A designer who wants to build moves into the design technologist path through the component library.',
    'A content strategist who wants the numbers moves toward marketing technology through the measurement work.',
    'A specialist who wants breadth takes the delivery lead route, which crosses all six practices.',
];
?>
<section class="band car-grow" id="growth" aria-labelledby="growth-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Growth and learning</p>
        <h2 class="h2" id="growth-t"><span class="g">Craft moves in public here,</span> which is why it moves fast.</h2>
      </div>
      <div>
        <p class="lead">No one gets better from an annual form. What moves craft is being reviewed often, by people who know the work, with a level to aim at that is written down. That is the whole system.</p>
      </div>
    </div>

    <div class="car-grow__grid">
      <ol class="car-grow__ladder" data-rv-s data-rv-step="70">
        <?php foreach ($gr_ladder as $gr_r): ?>
          <li class="car-grow__rung">
            <span class="car-grow__when"><?= e($gr_r[0]) ?></span>
            <h3 class="bdh-t car-grow__t"><?= e($gr_r[1]) ?></h3>
            <p class="bdh-d"><?= e($gr_r[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>

      <div class="car-grow__aside" data-rv data-rv-d="90">
        <!-- PLACEHOLDER: stock photograph, not an Xterra Edze team or office — replace with our own
             photography before launch. Credit in assets/imgs/careers/CREDITS.md. -->
        <figure class="bdh-img bdh-img--r45 car-grow__fig">
          <img src="<?= xe_url('assets/imgs/careers/growth-critique.jpg') ?>" alt="Two people looking together at code on a laptop and a monitor at a desk." width="1800" height="1013" loading="lazy" decoding="async">
        </figure>
        <p class="car-grow__cap"><span class="bdh-cap-chip"><b>Illustrative</b>A stock photograph, not our studio.</span></p>
      </div>
    </div>

    <div class="car-grow__two">
      <!-- PLACEHOLDER: confirm the learning time, the budget and the approval route before launch;
           cut any line that cannot be confirmed rather than softening it -->
      <div class="car-grow__learn" data-rv>
        <p class="car-k car-k--blue">What we put behind it</p>
        <dl class="car-grow__dl">
          <?php foreach ($gr_learn as $gr_l): ?>
            <div><dt><?= e($gr_l[0]) ?></dt><dd><?= e($gr_l[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>

      <div class="car-grow__move" data-rv data-rv-d="80">
        <p class="car-k">Moving between practices</p>
        <h3 class="bdh-t bdh-t--l car-grow__mt">Six practices in one company is a career path, not a floor plan.</h3>
        <p class="bdh-d">Changing craft usually means changing employer. Here it means changing seat. The route is always through real work on a live engagement, with your current lead and the new one both signed up to it.</p>
        <ul class="bdh-bullets car-grow__ml">
          <?php foreach ($gr_move as $gr_x): ?><li><?= e($gr_x) ?></li><?php endforeach; ?>
        </ul>
        <p class="car-note">Moves happen when there is real work to move into, so the timing depends on the engagement pipeline rather than a calendar.</p>
      </div>
    </div>
  </div>
</section>
