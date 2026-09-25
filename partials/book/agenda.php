<?php /* DRAFT COPY — review before launch */
/**
 * Book · agenda — what the thirty minutes are actually spent on, drawn to scale.
 *
 * The strip is a real proportional graphic: each segment's width is its share of the 30 minutes
 * (5 / 10 / 10 / 5), so the shape of the call is visible before a word is read. The cards below carry
 * the content in an equal grid, tied back to the strip by the minute badge they share. No photography,
 * no icons — the measure is the illustration. The strip grows in on entry via .bdh-grow, which
 * resolves to its finished state without JavaScript and under reduced motion.
 *
 * Requires $BK (book.php). Locals are prefixed ag_.
 */
$ag_steps = [
    ['from' => 0,  'to' => 5,  'k' => 'Where you are now',
     'd' => 'What is already built, what is live, and who it is for. We have read the site; we have not read your roadmap.'],
    ['from' => 5,  'to' => 15, 'k' => 'What you are trying to change',
     'd' => 'The outcome you are measured on, the constraint you cannot move, and the date it starts to matter. This is the part worth the most minutes.'],
    ['from' => 15, 'to' => 25, 'k' => 'What we would actually do',
     'd' => 'The shape of a sensible first piece of work, which discipline leads it, and what it would cost you in attention as well as budget.'],
    ['from' => 25, 'to' => 30, 'k' => 'Whether we are the right team',
     'd' => 'Said out loud, both ways. If we are not, we will say so and point you at who is better placed.'],
];
$ag_not = [
    ['Not a credentials tour', 'The work is already on the site. We would rather spend the half hour on yours than on ours.'],
    ['Not a pitch', 'There is nothing to buy at the end of a discovery call, and no follow-up sequence waiting for you.'],
    ['Not a scoping workshop', 'Proper scoping is real work and it is paid. This call is how you decide whether it is worth booking.'],
];
$ag_pad = fn (int $ag_m): string => str_pad((string) $ag_m, 2, '0', STR_PAD_LEFT);
?>
<section class="band band--alt bk-ag" id="agenda" aria-labelledby="agenda-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The half hour</p>
        <h2 class="h2" id="agenda-t"><span class="g">Thirty minutes,</span> in four moves.</h2>
      </div>
      <div>
        <p class="lead">Drawn to scale. The middle twenty minutes are the call; the five at each end
          are for arriving and for being honest about fit.</p>
      </div>
    </div>

    <div class="bk-ag__in" data-rv data-rv-d="60">

      <!-- the strip. Decorative as a drawing; every number and label in it is repeated in the cards. -->
      <div class="bk-ag__strip" aria-hidden="true" data-bdh-in>
        <div class="bk-ag__ticks">
          <?php foreach ($ag_steps as $ag_s): ?>
            <span class="bk-ag__tick" style="--w:<?= (int) ($ag_s['to'] - $ag_s['from']) ?>"><?= e($ag_pad($ag_s['from'])) ?></span>
          <?php endforeach; ?>
          <span class="bk-ag__tick bk-ag__tick--end">30</span>
        </div>
        <div class="bk-ag__bar">
          <?php foreach ($ag_steps as $ag_i => $ag_s): ?>
            <span class="bk-ag__seg" style="--w:<?= (int) ($ag_s['to'] - $ag_s['from']) ?>;--i:<?= (int) $ag_i ?>">
              <i class="bk-ag__fill bdh-grow"></i><b><?= e($ag_pad($ag_s['from'])) ?>–<?= e($ag_pad($ag_s['to'])) ?></b>
            </span>
          <?php endforeach; ?>
        </div>
      </div>
      <p class="bdh-sr">A bar divided into four parts across thirty minutes: five minutes on where you
        are now, ten on what you are trying to change, ten on what we would do, and a closing five on
        whether we are the right team.</p>

      <ol class="bk-ag__cards">
        <?php foreach ($ag_steps as $ag_i => $ag_s): ?>
          <li class="bk-ag__c">
            <span class="bk-mins"><?= e($ag_pad($ag_s['from'])) ?>–<?= e($ag_pad($ag_s['to'])) ?> min</span>
            <h3 class="bdh-t bdh-t--s"><?= e($ag_s['k']) ?></h3>
            <p class="bdh-d"><?= e($ag_s['d']) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>

      <div class="bk-ag__not">
        <p class="bk-k bk-ag__notk">And what it is not</p>
        <ul class="bk-ag__notl">
          <?php foreach ($ag_not as $ag_n): ?>
            <li><b><?= e($ag_n[0]) ?>.</b> <?= e($ag_n[1]) ?></li>
          <?php endforeach; ?>
        </ul>
        <p class="bk-ag__notf">A question that takes five minutes does not need a calendar.
          <a href="mailto:<?= e($BK['email']) ?>"><?= e($BK['email']) ?></a> is faster.</p>
      </div>

    </div>
  </div>
</section>
