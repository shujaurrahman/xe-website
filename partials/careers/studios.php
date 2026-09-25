<?php /* DRAFT COPY — review before launch */
/* The studios — where you would actually sit, from data/site.php. Typographic plates rather than city
   photography: a stock photograph of a skyline beside a street address implies an office that is not
   in the picture, which is the same call the Technology hub's Global section made.
   Locals prefixed st_. */

$st_notes = [
    'new-delhi' => 'Aerocity, ten minutes from the airport. The studio most client meetings happen in, and the base for brand, campaign and delivery.',
    'ludhiana'  => 'Two floors in the same building on Ferozepur Road. The engineering and marketing-technology base, and where the internship sits.',
];
$st_key = fn (string $st_city): string => strtolower(str_replace(' ', '-', $st_city));

$st_counts = [];
foreach ($CAR_ROLES as $st_r) { foreach ($st_r['locations'] as $st_k) { $st_counts[$st_k] = ($st_counts[$st_k] ?? 0) + 1; } }
$st_locs = car_locations();
$st_url  = xe_url('careers.php');
/* a role open in either studio is counted under both, so the per-studio numbers add up to more than
   the total — say so rather than leave a reader to spot it */
$st_both = count(array_filter($CAR_ROLES, fn ($st_r) => count($st_r['locations']) > 1));

$st_facts = [
    ['Hybrid by default',   'Most full-time roles are in-studio three days a week, with the other two wherever you work best. The days are set by the engagement, not by a policy.'],
    ['One team, two rooms', 'The studios share tooling, rituals and reviews. A New Delhi engagement is routinely staffed from Ludhiana and the other way round.'],
    ['Written by default',  'Decisions land in writing because half the people who need them are in the other studio. It is the habit new joiners notice first.'],
    ['Remote where it fits','Some contract and production roles are fully remote within India. Where a role is remote, the listing says so.'],
];
?>
<section class="band band--alt car-studios" id="studios" aria-labelledby="studios-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The studios</p>
        <h2 class="h2" id="studios-t"><span class="g">Two rooms,</span> one team, one standard.</h2>
      </div>
      <div>
        <p class="lead">New Delhi and Ludhiana. Where you sit changes your commute and who you eat lunch with. It does not change the work you are given or the bar it is held to.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: the New Delhi address is carried over from the previous site (see data/site.php) —
         confirm both addresses, and which teams actually sit in each, before launch -->
    <ul class="car-studios__grid" role="list" data-rv-s data-rv-step="80">
      <?php foreach ($SITE['company']['studios'] as $st_s): $st_k = $st_key($st_s['city']); ?>
        <li class="car-plate">
          <p class="car-plate__k"><span class="bdh-pulse" aria-hidden="true"></span>Studio</p>
          <h3 class="car-plate__city"><?= e($st_s['city']) ?></h3>
          <address class="car-plate__addr">
            <?php foreach ($st_s['units'] as $st_u): ?><span class="car-plate__unit"><?= e($st_u) ?></span><?php endforeach; ?>
            <?php foreach ($st_s['lines'] as $st_l): ?><span><?= e($st_l) ?></span><?php endforeach; ?>
          </address>
          <p class="car-plate__note"><?= e($st_notes[$st_k] ?? '') ?></p>
          <p class="car-plate__go">
            <?php if (!empty($st_counts[$st_k])): ?>
              <a class="tl" href="<?= e($st_url) ?>?l=<?= e(rawurlencode($st_k)) ?>#roles"><?= (int) $st_counts[$st_k] ?> <?= $st_counts[$st_k] === 1 ? 'role' : 'roles' ?> based here <span class="i" aria-hidden="true">›</span></a>
            <?php else: ?>
              <span class="car-plate__off">Nothing open in this studio today</span>
            <?php endif; ?>
          </p>
        </li>
      <?php endforeach; ?>

      <?php if (isset($st_locs['remote'])): ?>
        <li class="car-plate car-plate--remote">
          <p class="car-plate__k">Also</p>
          <h3 class="car-plate__city"><?= e($st_locs['remote']) ?></h3>
          <p class="car-plate__note">A small number of contract and production roles run fully remote within India, on the same rituals and the same review cadence. The role listing always says which.</p>
          <p class="car-plate__go">
            <?php if (!empty($st_counts['remote'])): ?>
              <a class="tl" href="<?= e($st_url) ?>?l=remote#roles"><?= (int) $st_counts['remote'] ?> remote <?= $st_counts['remote'] === 1 ? 'role' : 'roles' ?> open <span class="i" aria-hidden="true">›</span></a>
            <?php else: ?>
              <span class="car-plate__off">Nothing remote open today</span>
            <?php endif; ?>
          </p>
        </li>
      <?php endif; ?>
    </ul>

    <?php if ($st_both > 0): ?>
      <p class="car-note car-studios__both"><?= $st_both === 1 ? 'One role is' : $st_both . ' roles are' ?> open in either studio, so <?= $st_both === 1 ? 'it appears' : 'they appear' ?> under both counts above.</p>
    <?php endif; ?>

    <!-- PLACEHOLDER: confirm the hybrid pattern (days in studio) and the remote policy before launch -->
    <dl class="car-studios__facts" data-rv data-rv-d="90">
      <?php foreach ($st_facts as $st_f): ?>
        <div><dt><?= e($st_f[0]) ?></dt><dd><?= e($st_f[1]) ?></dd></div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>
