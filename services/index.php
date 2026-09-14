<?php
$BASE = '../';
require __DIR__ . '/../partials/init.php';

$page = [
    'key'   => 'services',
    'title' => 'What we do',
    'desc'  => 'Six disciplines, one team, one system — brand, technology, campaign, AI, product and marketing technology.',
];

$hero = [
    'eyebrow' => 'What we do',
    'title'   => 'One team, six ways we<br><span class="g">help brands get ahead</span>',
    'lead'    => 'We bring together strategy, craft, and technology to build intelligent brand systems — the kind that create real differentiation, real customer value, and real growth.',
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<main id="main">
<?php include __DIR__ . '/../partials/page-hero.php'; ?>

  <section class="band" aria-labelledby="disc-t">
    <div class="wrap">
      <h2 class="sr" id="disc-t">The six disciplines</h2>
      <div class="dlist">
        <?php foreach ($SITE['disciplines'] as $d): ?>
          <a class="dlist__i" href="<?= xe_discipline_url($d) ?>">
            <span class="dlist__n"><?= e($d['n']) ?></span>
            <span class="dlist__b">
              <span class="dlist__t"><?= e($d['name']) ?></span>
              <span class="dlist__d"><?= e($d['intro']) ?></span>
              <span class="dlist__c"><?= count($d['caps']) ?> capabilities</span>
            </span>
            <span class="dlist__go" aria-hidden="true">›</span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

<?php include __DIR__ . '/../partials/cta.php'; ?>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
