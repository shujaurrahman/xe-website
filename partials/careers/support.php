<?php /* DRAFT COPY — review before launch */
/* What we offer — deliberately the most cautious section on the page. Nothing here is a number, and
   every line is a draft for the owner to confirm, cut or replace. A careers page that invents a
   benefit is worse than one that lists fewer: the first thing a new joiner does is check.
   Locals prefixed sup_. */

/* PLACEHOLDER: this whole list is DRAFT. Confirm, amend or delete every line with whoever owns
   employment terms before launch, and delete anything that is not actually in place today. Nothing
   below carries a figure on purpose — add amounts only once they are signed off. */
$sup_have = [
    ['ico' => 'clock',  'k' => 'Hours that follow the work',
     'p'  => 'Core hours so the two studios overlap, and flexibility around them. Launch weeks are heavier; ordinary weeks are not meant to be.'],
    ['ico' => 'chip',   'k' => 'The machine and the tools you need',
     'p'  => 'Hardware specified for the work rather than a standard issue, and licences for the software and model access the job requires.'],
    ['ico' => 'brain',  'k' => 'Learning inside working hours',
     'p'  => 'Time in the week for the thing you have decided to get better at, plus a budget for courses or a conference agreed with your lead.'],
    ['ico' => 'users',  'k' => 'A mentor and a level to aim at',
     'p'  => 'A named mentor from week one, monthly one-to-ones, and a written level conversation every six months that pay is reviewed against.'],
    ['ico' => 'handshake', 'k' => 'Paid internships',
     'p'  => 'Every internship on this page is paid, mentored and reviewed like any other role. We do not run unpaid placements.'],
    ['ico' => 'globe',  'k' => 'Work that travels',
     'p'  => 'Client work across India and further out, so what you build is seen by people who were not in the room when it was decided.'],
];

$sup_ask = [
    'Health cover, leave, provident fund and any allowance are set out in full in the offer, not summarised on a web page. Ask in the first call and you will get the actual terms.',
    'If a benefit matters enough to affect your decision, raise it in the first conversation. We would rather answer it early than have you find out in month two.',
];
?>
<section class="band car-sup" id="support" aria-labelledby="support-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What we offer</p>
        <h2 class="h2" id="support-t"><span class="g">Fewer promises,</span> all of them real.</h2>
      </div>
      <div>
        <p class="lead">Plenty of careers pages list perks nobody uses. This list is short on purpose: it is the things that shape a working week here. Terms and figures live in the offer, where they can be checked.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm every item below with whoever owns employment terms before launch, and
         delete anything not actually in place today -->
    <ul class="car-sup__grid" role="list" data-rv-s data-rv-step="60">
      <?php foreach ($sup_have as $sup_i): ?>
        <li class="bdh-card car-sup__card">
          <span class="car-sup__ico" aria-hidden="true"><?= xt_icon($sup_i['ico'], ['size' => 24]) ?></span>
          <h3 class="bdh-t car-sup__t"><?= e($sup_i['k']) ?></h3>
          <p class="bdh-d"><?= e($sup_i['p']) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="car-sup__ask" data-rv data-rv-d="80">
      <div>
        <p class="car-k car-k--blue">On pay, cover and leave</p>
        <?php foreach ($sup_ask as $sup_p): ?><p class="car-sup__p"><?= e($sup_p) ?></p><?php endforeach; ?>
      </div>
      <a class="btn btn--dark" href="mailto:<?= e($SITE['company']['email']) ?>?subject=<?= e(rawurlencode('Question about a role')) ?>">Ask before you apply <span class="i" aria-hidden="true">›</span></a>
    </div>
  </div>
</section>
