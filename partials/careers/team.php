<?php /* DRAFT COPY — review before launch */
/* One team — what "one team across six practices" means in practice, as an involvement matrix:
   the six disciplines from data/site.php down the side, the five phases of an engagement across the
   top, and who leads, who works on it and who is on call in each. A real <table> with th scope, so it
   reads correctly to a screen reader, and it scrolls inside .bdh-scroll-x on a phone.
   Locals prefixed team_. */

$team_phases = [
    ['Frame',  'Weeks 1–2',  'The problem, the audience, the measure of done.'],
    ['Design', 'Weeks 2–6',  'The system, the interface, the campaign idea.'],
    ['Build',  'Weeks 4–14', 'The software, the assets, the automation.'],
    ['Launch', 'Go-live week', 'Go-live, media, enablement, handover.'],
    ['Run',    'Ongoing',    'Measurement, iteration, support.'],
];

/* 2 = leads this phase · 1 = works on it · 0 = on call, not on the plan */
$team_grid = [
    'brand-design'             => [2, 2, 1, 1, 0],
    'technology-intelligence'  => [1, 1, 2, 2, 2],
    'campaign-content'         => [1, 2, 1, 2, 2],
    'ai-design'                => [1, 2, 2, 0, 1],
    'product-experience'       => [2, 2, 1, 1, 0],
    'marketing-technology'     => [0, 1, 2, 2, 2],
];
$team_lvl = [2 => 'Leads', 1 => 'Works on it', 0 => 'On call'];

$team_counts = [];
foreach ($CAR_ROLES as $team_r) { $team_counts[$team_r['discipline']] = ($team_counts[$team_r['discipline']] ?? 0) + 1; }
$team_url = xe_url('careers.php');
?>
<section class="band band--alt car-team" id="team" aria-labelledby="team-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Who you join</p>
        <h2 class="h2" id="team-t"><span class="g">One team,</span> six practices, one engagement.</h2>
      </div>
      <div>
        <p class="lead">Most agencies sell six services and staff them as six companies. Here a single engagement moves through all of them, and the handover is a conversation rather than a contract. This is the shape of a typical programme, and where your practice would sit in it.</p>
      </div>
    </div>

    <div class="car-mx" data-rv data-rv-d="80">
      <div class="bdh-scroll-x mask-x car-mx__scroll" tabindex="0" role="region" aria-label="How each practice works across an engagement, scroll sideways to see every phase">
        <table class="car-mx__t">
          <caption class="sr">Who leads, who works on it and who is on call in each phase of an engagement, by practice.</caption>
          <thead>
            <tr>
              <th scope="col" class="car-mx__corner">Practice</th>
              <?php foreach ($team_phases as $team_p): ?>
                <th scope="col"><span class="car-mx__ph"><?= e($team_p[0]) ?></span><span class="car-mx__pw"><?= e($team_p[1]) ?></span></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($SITE['disciplines'] as $team_d): $team_row = $team_grid[$team_d['slug']] ?? null; if ($team_row === null) continue; ?>
              <tr>
                <th scope="row">
                  <a class="car-mx__dn" href="<?= xe_discipline_url($team_d) ?>"><span class="car-mx__di"><?= e($team_d['n']) ?></span><?= e($team_d['name']) ?></a>
                  <?php if (!empty($team_counts[$team_d['slug']])): ?>
                    <a class="car-mx__hire" href="<?= e($team_url) ?>?d=<?= e(rawurlencode($team_d['slug'])) ?>#roles"><?= (int) $team_counts[$team_d['slug']] ?> hiring</a>
                  <?php endif; ?>
                </th>
                <?php foreach ($team_row as $team_i => $team_v): ?>
                  <td data-l="<?= (int) $team_v ?>">
                    <span class="car-mx__c" aria-hidden="true"></span>
                    <span class="car-mx__cl"><?= e($team_lvl[$team_v]) ?></span>
                  </td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="car-mx__foot">
        <ul class="car-mx__key" role="list">
          <?php foreach ([2, 1, 0] as $team_k): ?>
            <li><span class="car-mx__c" data-l="<?= $team_k ?>" aria-hidden="true"></span><?= e($team_lvl[$team_k]) ?></li>
          <?php endforeach; ?>
        </ul>
        <p class="car-mx__note">One accountable delivery lead per engagement, not four vendors pointing at each other. The phases above are a typical shape, not a fixed methodology.</p>
      </div>
    </div>

    <ul class="car-team__cards" role="list" data-rv-s data-rv-step="60">
      <?php foreach ($SITE['disciplines'] as $team_d): ?>
        <li class="bdh-card bdh-card--lift car-team__card">
          <p class="bdh-idx"><?= e($team_d['n']) ?></p>
          <h3 class="bdh-t car-team__t"><?= e($team_d['name']) ?></h3>
          <p class="bdh-d car-team__d"><?= e($team_d['intro']) ?></p>
          <p class="car-team__go">
            <a class="tl" href="<?= xe_discipline_url($team_d) ?>">What this practice does <span class="i" aria-hidden="true">›</span></a>
            <?php if (!empty($team_counts[$team_d['slug']])): ?>
              <a class="car-team__hire" href="<?= e($team_url) ?>?d=<?= e(rawurlencode($team_d['slug'])) ?>#roles"><?= (int) $team_counts[$team_d['slug']] ?> open <?= $team_counts[$team_d['slug']] === 1 ? 'role' : 'roles' ?></a>
            <?php else: ?>
              <span class="car-team__hire car-team__hire--off">Nothing open today</span>
            <?php endif; ?>
          </p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
