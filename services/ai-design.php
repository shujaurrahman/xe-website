<?php
$BASE = '../';
require __DIR__ . '/../partials/init.php';

$page = [
    'key'   => 'services',
    'title' => 'AI Design',
    'desc'  => 'Using AI well under the hood is table stakes now. We go further — designing brand experiences that simply weren\'t possible before AI existed.',
];

/* Pulled from data/site.php so the page, the menu and the footer can never
   disagree about what this discipline offers. */
$d = null;
foreach ($SITE['disciplines'] as $x) { if ($x['slug'] === 'ai-design') $d = $x; }

$hero = [
    'eyebrow' => 'What we do · ' . $d['n'],
    'title'   => e($d['name']),
    'lead'    => $d['intro'],
    'meta'    => [count($d['caps']) . ' capabilities', 'One team', 'New Delhi · Ludhiana'],
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<main id="main">
<?php include __DIR__ . '/../partials/page-hero.php'; ?>

  <section class="band" aria-labelledby="caps-t">
    <div class="wrap">
      <div class="head">
        <p class="lbl lbl--blue"><span class="dot"></span>Capabilities</p>
        <h2 class="h2" id="caps-t">What this discipline covers</h2>
      </div>

      <div class="caps">
        <?php foreach ($d['caps'] as $i => $c):
                if (!empty($d['group']) && $i === ($d['group_at'] ?? -1)): ?>
                  <p class="caps__group"><?= e($d['group']) ?></p>
        <?php   endif; ?>
          <div class="caps__i">
            <span class="caps__n"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="caps__t"><?= e($c[0]) ?></h3>
            <p class="caps__d"><?= e($c[1]) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

<?php include __DIR__ . '/../partials/cta.php'; ?>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
