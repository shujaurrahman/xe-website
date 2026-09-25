<?php /* DRAFT COPY — review before launch */
/* Why build here — five reasons, each with the trade-off printed beside it. The trade-off column is
   the point of the section: a careers page that only lists upsides tells a candidate nothing, and the
   people we want read the second column first. Sticky head on the left, rows on the right.
   Locals prefixed why_. */

$why_rows = [
    [
        'k'  => 'One team, six practices',
        'p'  => 'Brand, technology, campaign, AI, product and marketing technology sit in one company and usually on one engagement. A designer here works next to the engineer who will ship the thing, and an engineer sees the strategy that produced the brief.',
        't'  => 'You will work with people whose craft you do not share, and you will have to explain yours in plain words. Specialists who only want to talk to other specialists are happier elsewhere.',
        'ico' => 'layers',
    ],
    [
        'k'  => 'The operation is rebuilt around AI, not sprinkled with it',
        'p'  => 'Repetition is automated: production passes, variant generation, QA sweeps, research gathering, reporting. Judgement is not. You spend your hours on the decisions, and you are expected to have an opinion about them.',
        't'  => 'You have to actually learn the tooling, and keep learning it as it changes under you. "I prefer to do it by hand" is a position you can hold, but you will need a reason beyond habit.',
        'ico' => 'agent',
    ],
    [
        'k'  => 'Work that ships, and then keeps running',
        'p'  => 'Every model, dataset and system we build belongs to the client, and we are usually still on it after launch. You see your work in production, measured, argued about and improved rather than screenshotted and forgotten.',
        't'  => 'You inherit what you build. That means live bugs, awkward migrations and the long middle of a project, not only the launch.',
        'ico' => 'rocket',
    ],
    [
        'k'  => 'Independent, so the client is the only stakeholder',
        'p'  => 'No holding company, no media rebate to protect, no platform we are contractually fond of. Recommendations are made on evidence, and you will not be asked to defend a choice you do not believe in.',
        't'  => 'Independence means we win work on the strength of the work. There is no house account to hide behind in a slow quarter.',
        'ico' => 'compass',
    ],
    [
        'k'  => 'Two studios, one standard',
        'p'  => 'New Delhi and Ludhiana run as one team on the same tooling, the same review rituals and the same quality bar. Where you sit changes your commute, not the work you get.',
        't'  => 'It also means real remote discipline: writing things down, recording decisions, and joining a call on time because someone in the other studio is waiting.',
        'ico' => 'pin',
    ],
];
?>
<section class="band car-why" id="why" aria-labelledby="why-t">
  <div class="wrap bdh-grid">
    <div class="bdh-c4 car-why__side">
      <div class="bdh-sticky" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Why build here</p>
        <h2 class="h2" id="why-t"><span class="g">Five reasons to join,</span> and the cost of each.</h2>
        <p class="p car-why__p">We would rather you arrive knowing what the job is really like than leave in the fourth month. Every heading below is a real reason to be here. The grey block under each one is what that reason asks of you in return.</p>
        <a class="tl" href="#roles">See the open roles <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <ol class="bdh-c7 bdh-s6 car-why__rows" data-rv-s data-rv-step="80">
      <?php foreach ($why_rows as $why_i => $why_r): ?>
        <li class="car-why__row">
          <span class="car-why__ico" aria-hidden="true"><?= xt_icon($why_r['ico']) ?></span>
          <p class="bdh-idx car-why__n"><?= str_pad((string) ($why_i + 1), 2, '0', STR_PAD_LEFT) ?></p>
          <h3 class="bdh-t bdh-t--l car-why__t"><?= e($why_r['k']) ?></h3>
          <p class="car-why__d"><?= e($why_r['p']) ?></p>
          <p class="car-why__t2"><span class="car-k car-k--warn">The trade-off</span><?= e($why_r['t']) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
