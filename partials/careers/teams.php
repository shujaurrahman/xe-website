<?php /* DRAFT COPY — review before launch */
/* The practices you could join. One card per discipline in data/site.php order, plus Delivery &
   Operations, which is not a discipline but is where a third of an engagement's work happens.
   Each card carries what that practice makes, the roles currently listed in it, and a link to the
   discipline's own page so a candidate can read the actual work before applying. Locals tm_. */
$tm_cards = [];
foreach ($SITE['disciplines'] as $tm_d) {
    $tm_cards[] = [
        'n'     => $tm_d['n'],
        'name'  => $tm_d['name'],
        'short' => $tm_d['short'],
        'intro' => $tm_d['intro'],
        'url'   => xe_discipline_url($tm_d),
        'urlk'  => 'See the work',
        'caps'  => array_slice(array_map(fn ($tm_c) => $tm_c[0], $tm_d['caps']), 0, 4),
    ];
}
$tm_cards[] = [
    'n'     => '07',
    'name'  => 'Delivery & Operations',
    'short' => 'Delivery',
    'intro' => 'The people who hold an engagement together: scope, plan, budget, risk, the weekly review and the decision log. Not a layer above the work — a seat inside it.',
    'url'   => xe_url('approach.php'),
    'urlk'  => 'How we run engagements',
    'caps'  => ['Engagement planning', 'Risk and change control', 'The weekly review', 'Agent workflow operations'],
];
/* the listed roles per practice, so a card can name them rather than only count them */
$tm_roles = [];
foreach ($car_roles as $tm_r) $tm_roles[$tm_r['dept']][] = $tm_r;
?>
<section class="band car-teams" id="teams" aria-labelledby="teams-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Where you would sit</p>
        <h2 class="h2" id="teams-t"><span class="g">Seven practices.</span> You join one and work with all of them.</h2></div>
      <div><p class="lead">Your craft has a home, a lead and a review rhythm. The engagement you work on will pull in three or four of the others, which is the point.</p>
        <a class="tl" href="<?= e(xe_url('services/')) ?>">Read what each practice makes <span class="i" aria-hidden="true">›</span></a></div>
    </div>

    <ul class="car-tm" data-rv-s data-rv-step="60">
      <?php foreach ($tm_cards as $tm_c): $tm_open = $tm_roles[$tm_c['name']] ?? []; ?>
      <li class="car-tm__i">
        <article class="car-tm__card">
          <p class="car-tm__top"><span class="bdh-idx"><?= e($tm_c['n']) ?></span>
            <?php if ($tm_open): ?>
              <a class="car-tm__count" href="<?= e(xe_url('careers.php') . '?dept=' . rawurlencode($tm_c['name']) . '#roles') ?>"><b><?= count($tm_open) ?></b> open<span class="sr"> roles in <?= e($tm_c['name']) ?></span></a>
            <?php else: ?>
              <span class="car-tm__count car-tm__count--none">Nothing listed</span>
            <?php endif; ?>
          </p>
          <h3 class="car-tm__t"><?= e($tm_c['name']) ?></h3>
          <p class="car-tm__d"><?= e($tm_c['intro']) ?></p>
          <p class="car-tm__k">What this practice makes</p>
          <ul class="car-tm__caps"><?php foreach ($tm_c['caps'] as $tm_cap): ?><li><?= e($tm_cap) ?></li><?php endforeach; ?></ul>
          <?php if ($tm_open): ?>
            <p class="car-tm__k">Listed now</p>
            <ul class="car-tm__roles">
              <?php foreach ($tm_open as $tm_r): ?>
              <li><a href="<?= e(xe_url('careers.php') . '?role=' . rawurlencode($tm_r['id']) . '#role-' . rawurlencode($tm_r['id'])) ?>"><span><?= e($tm_r['title']) ?></span><i aria-hidden="true"><?= e($tm_r['loc']) ?></i></a></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          <p class="car-tm__go"><a class="tl" href="<?= e($tm_c['url']) ?>"><?= e($tm_c['urlk']) ?><span class="sr">: <?= e($tm_c['name']) ?></span> <span class="i" aria-hidden="true">›</span></a></p>
        </article>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
