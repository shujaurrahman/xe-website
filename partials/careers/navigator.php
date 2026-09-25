<?php /* DRAFT COPY — review before launch */
/* Navigator — the strip directly under the hero. It answers the two things a candidate wants in the
   first five seconds: how many roles are open, and in which practice. Each chip is a real link into
   the filtered roles list (/careers?d=<key>#roles), so it works with JavaScript off and can be
   shared. The second row is a plain contents list for the rest of the page. Locals prefixed nav_. */

$nav_counts = [];
foreach ($CAR_ROLES as $nav_r) { $nav_counts[$nav_r['discipline']] = ($nav_counts[$nav_r['discipline']] ?? 0) + 1; }
$nav_total = count($CAR_ROLES);
$nav_url   = xe_url('careers.php');

/* "6 practices and the studio" — the six disciplines carry a hub URL, extra groups do not, so this
   line stays true if a group is added to data/careers.php and never contradicts "six disciplines" */
$nav_dcount = count(array_filter($CAR_GROUPS, fn ($nav_g) => $nav_g['url'] !== ''));
$nav_extra  = count($CAR_GROUPS) - $nav_dcount;
$nav_where  = $nav_dcount . ($nav_dcount === 1 ? ' practice' : ' practices')
            . ($nav_extra > 0 ? ' and the studio' : '') . ' · New Delhi and Ludhiana';

$nav_jump = [
    ['why',       'Why build here'],
    ['team',      'One team'],
    ['the-work',  'The work, honestly'],
    ['ai-native', 'AI in the day'],
    ['bar',       'What we look for'],
    ['hiring',    'How hiring runs'],
    ['growth',    'Growth'],
    ['studios',   'The studios'],
    ['support',   'What we offer'],
    ['faq',       'Questions'],
];
?>
<section class="band band--tight car-nav" id="navigator" aria-labelledby="navigator-t">
  <div class="wrap">
    <h2 class="sr" id="navigator-t">Open roles at a glance</h2>

    <div class="car-nav__in" data-rv>
      <div class="car-nav__fig">
        <!-- PLACEHOLDER: confirm the open roles before launch -->
        <p class="car-nav__n" data-bdh-count><?= $nav_total ?></p>
        <p class="car-nav__k"><?= $nav_total === 1 ? 'role open today' : 'roles open today' ?><span><?= e($nav_where) ?></span></p>
      </div>

      <div class="car-nav__chips">
        <p class="car-k car-nav__ck">Jump to a practice</p>
        <ul class="car-nav__list" role="list">
          <?php foreach ($CAR_GROUPS as $nav_gk => $nav_g): ?>
            <li>
              <a class="car-chip" href="<?= e($nav_url) ?>?d=<?= e(rawurlencode($nav_gk)) ?>#roles">
                <span class="car-chip__n"><?= e($nav_g['name']) ?></span>
                <span class="car-chip__c"><?= $nav_counts[$nav_gk] ?? 0 ?></span>
              </a>
            </li>
          <?php endforeach; ?>
          <li><a class="car-chip car-chip--all" href="#roles"><span class="car-chip__n">See every role</span><span class="i" aria-hidden="true">›</span></a></li>
        </ul>
      </div>
    </div>

    <nav class="car-nav__jump" aria-label="On this page">
      <p class="car-k">On this page</p>
      <ul role="list">
        <?php foreach ($nav_jump as $nav_j): ?>
          <li><a href="#<?= e($nav_j[0]) ?>"><?= e($nav_j[1]) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </div>
</section>
