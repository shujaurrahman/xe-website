<?php /* DRAFT COPY — review before launch */
/* Growth and craft. The published framework as a real table — levels across, the four things that
   change down — followed by the craft block: what the company actually spends on people, with the
   photograph credited in assets/imgs/careers/CREDITS.md. Wide table scrolls on phones.
   PLACEHOLDER: confirm the framework, the level names and every figure below with HR before launch.
   Locals prefixed gr_. */
$gr_levels = [
    ['01', 'Associate',    'Learning the craft on live work'],
    ['02', 'Practitioner', 'Owning a workstream'],
    ['03', 'Senior',       'Owning an outcome'],
    ['04', 'Lead',         'Owning a team or a discipline'],
    ['05', 'Principal',    'Owning a hard problem across engagements'],
];
$gr_rows = [
    ['Scope you hold',
     ['A task, with a named reviewer', 'A workstream inside one engagement', 'An outcome across one engagement', 'A practice, or delivery across two or three engagements', 'The problem nobody else can carve up yet']],
    ['Decisions you own',
     ['How to do it, once the what is agreed', 'Approach and sequence, with the trade-off written down', 'What good means here, and what you will not do', 'Who does what, and where the quality bar sits', 'What the company should believe about a hard question']],
    ['How you are reviewed',
     ['Weekly, on the work in front of you', 'Twice a year against the framework, plus craft reviews', 'Twice a year, with the decision log as evidence', 'Twice a year, plus how your people grew', 'Twice a year, on the arguments you changed']],
    ['What we invest in you',
     ['A mentor, a learning plan and a licensed AI workspace', 'Your first solo client presentation, with the lead in the room', 'Conference or course of your choosing, and time to write', 'Management coaching before you manage anybody', 'Time to research, publish and teach, protected in the plan']],
];
$gr_craft = [
    ['eval',     'A craft review every week',   'One hour, your discipline, one piece of work each. It is the single habit we would protect over any perk on the list below.'],
    ['doc',      'Writing counts as work',      'Decision-log entries, notes and post-mortems happen inside the week, not after it. Nobody is asked to do the writing in their own time.'],
    ['users',    'A week inside another craft', 'Twice a year you spend a week working in a practice that is not yours. Engineers in identity work, designers in evals, strategists in delivery.'],
    ['lightbulb','Teaching, paid for',          'If you run an internal session, write a paper or speak somewhere, the preparation is on the clock. Teaching is the fastest way anybody here has got better.'],
];
?>
<section class="band band--alt car-grow" id="growth" aria-labelledby="growth-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Growth and craft</p>
        <h2 class="h2" id="growth-t"><span class="g">A published framework,</span> so promotion is not a rumour.</h2></div>
      <div><p class="lead">Five levels, four things that change at each one, reviewed twice a year against the same table you are reading now. Lead and Principal are the same level in two shapes: you do not have to manage people to be paid like a senior person.</p></div>
    </div>

    <!-- PLACEHOLDER: confirm the level names, the framework rows and the review cadence with HR before launch -->
    <div class="bdh-scroll-x mask-x car-grow__scroll" tabindex="0" role="group" aria-label="The career framework, five levels — scroll sideways to see every level">
      <table class="car-lv">
        <caption class="sr">What changes at each of the five levels: scope, decisions, review and investment.</caption>
        <thead>
          <tr>
            <th scope="col"><span class="sr">What changes</span></th>
            <?php foreach ($gr_levels as $gr_l): ?>
            <th scope="col" class="car-lv__h">
              <span class="car-lv__n"><?= e($gr_l[0]) ?></span>
              <b class="car-lv__t"><?= e($gr_l[1]) ?></b>
              <span class="car-lv__d"><?= e($gr_l[2]) ?></span>
            </th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($gr_rows as $gr_r): ?>
          <tr>
            <th scope="row" class="car-lv__rh"><?= e($gr_r[0]) ?></th>
            <?php foreach ($gr_r[1] as $gr_c): ?><td><?= e($gr_c) ?></td><?php endforeach; ?>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="car-grow__craft">
      <figure class="bdh-img bdh-img--r43 car-grow__fig">
        <img src="<?= xe_asset('assets/imgs/careers/growth-craft.jpg') ?>" alt="" width="1400" height="934" loading="lazy" decoding="async">
      </figure>
      <div class="car-grow__copy">
        <p class="car-grow__k">What the company actually spends on you</p>
        <ul class="car-grow__list">
          <?php foreach ($gr_craft as $gr_c): ?>
          <li><span class="car-grow__ico" aria-hidden="true"><?= xt_icon($gr_c[0], ['size' => 20]) ?></span>
            <div><h3 class="car-grow__t"><?= e($gr_c[1]) ?></h3><p><?= e($gr_c[2]) ?></p></div></li>
          <?php endforeach; ?>
        </ul>
        <p class="car-grow__note">The budget figures behind these sit in the benefits section below, and every one of them is confirmed in writing in an offer letter rather than only on a careers page.</p>
      </div>
    </div>
  </div>
</section>
