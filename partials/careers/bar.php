<?php /* DRAFT COPY — review before launch */
/* The bar — what we look at, in order, and what we deliberately do not screen on. The apply page's
   sidebar links straight here (#bar), so the anchor and the heading have to stay. The photograph is
   credited in assets/imgs/careers/CREDITS.md and shows neither our office nor our team.
   Locals prefixed br_. */
$br_look = [
    ['Judgement under constraint', 'Everything we ship is made with less time, less data or less agreement than anyone wanted. We are interested in what you chose not to do, and what you would need to change your mind.', 'The craft conversation'],
    ['Craft you can defend',       'Depth in one thing, in work you can walk us through decision by decision. Breadth is welcome; it is not a substitute.', 'Your CV, your links and the craft conversation'],
    ['Writing that holds up',      'Short, concrete, unhedged. Most arguments here happen in a document before they happen in a room, so the writing is the work.', 'Your application note'],
    ['How you are with disagreement', 'Directness without theatre, and the ability to change position in public without treating it as a loss.', 'The team conversation'],
    ['Appetite for the unfamiliar', 'You have taught yourself something genuinely hard in the last year or two and can describe how you did it, including the part where it was going badly.', 'The intro call'],
];
$br_not = [
    ['Where you studied',        'Which college is on your CV, and whether there is one.'],
    ['Years, as a number',       'Six years of the same year is not six years. The work tells us.'],
    ['A named tool on your CV',  'Tools are a fortnight. Judgement is not.'],
    ['Gaps in your history',     'Illness, care, a failed venture, a year out. None of it is a question we ask.'],
    ['Agency or in-house',       'Both teach something the other does not. Neither is the pedigree.'],
    ['Whether we already know you', 'Referrals get the same form, the same questions and the same stages as everybody else.'],
];
$br_read = [
    ['Your links and CV first', 'The reader opens the work before the covering note, so that the note is read in the light of the work rather than the other way round.'],
    ['Then your note',          'Looking for one specific thing you made and what your own part in it was. Generic enthusiasm is neutral, not negative.'],
    ['Then a written decision', 'Yes, no, or a question — written down with a reason, by a named person in the practice, and sent to you either way.'],
];
?>
<section class="band car-bar" id="bar" aria-labelledby="bar-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>The bar</p>
        <h2 class="h2" id="bar-t"><span class="g">What we look at,</span> and what we refuse to.</h2></div>
      <div><p class="lead">Published in order, so you can tell before you spend an evening on an application whether we are measuring the thing you are good at.</p></div>
    </div>

    <div class="bdh-grid car-bar__grid">
      <ol class="bdh-c7 car-bar__look" data-rv-s data-rv-step="70">
        <?php foreach ($br_look as $br_i => $br_l): ?>
        <li class="car-look">
          <span class="bdh-idx car-look__n"><?= str_pad((string) ($br_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h3 class="car-look__t"><?= e($br_l[0]) ?></h3>
          <p class="car-look__p"><?= e($br_l[1]) ?></p>
          <p class="car-look__w"><span>Read in</span><?= e($br_l[2]) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>

      <div class="bdh-c4 bdh-s9 car-bar__side">
        <div class="bdh-sticky">
          <figure class="bdh-img bdh-img--r43 car-bar__fig">
            <img src="<?= xe_asset('assets/imgs/careers/bar-review.jpg') ?>" alt="" width="1800" height="1013" loading="lazy" decoding="async">
          </figure>
          <!-- PLACEHOLDER: confirm that every application is read by a person in the practice, and the wording of the reply, before launch -->
          <div class="car-read">
            <p class="car-read__k">How an application is read</p>
            <ol class="car-read__list">
              <?php foreach ($br_read as $br_j => $br_r): ?>
              <li><span class="car-read__n"><?= $br_j + 1 ?></span><b><?= e($br_r[0]) ?></b><span><?= e($br_r[1]) ?></span></li>
              <?php endforeach; ?>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="car-bar__not">
      <p class="car-bar__notk">Not screened on, at any stage</p>
      <ul class="car-not">
        <?php foreach ($br_not as $br_n): ?>
        <li class="car-not__i"><span class="car-not__x" aria-hidden="true"></span><b><?= e($br_n[0]) ?></b><span><?= e($br_n[1]) ?></span></li>
        <?php endforeach; ?>
      </ul>
      <p class="car-bar__foot">If you think one of these was used against you in our process, write to <a href="mailto:<?= e($SITE['company']['email']) ?>?subject=<?= e(rawurlencode('About your hiring process')) ?>"><?= e($SITE['company']['email']) ?></a> and say so plainly. It will be read by a founder.
        <!-- PLACEHOLDER: confirm who handles hiring complaints before launch --></p>
    </div>
  </div>
</section>
