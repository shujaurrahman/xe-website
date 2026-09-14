<?php
$BASE = '';
require 'partials/init.php';

$page = ['key' => 'industries', 'title' => 'Industries', 'desc' => 'Consumer health, financial services, retail and commerce, B2B technology, hospitality, telecom and media.'];

$hero = [
    'eyebrow' => 'Industries',
    'title'   => 'Helping brands win in<br><span class="g">the categories they compete in</span>',
    'lead'    => 'Consumer health, financial services, retail and commerce, B2B technology, hospitality, telecom and media.',
];

include 'partials/head.php';
include 'partials/nav.php';
?>

<main id="main">
<?php include 'partials/page-hero.php'; ?>

  <section class="band" aria-labelledby="industries-t">
    <div class="wrap">
      <h2 class="sr" id="industries-t">Industries</h2>
      <div class="soon">
        <p class="lbl lbl--blue"><span class="dot"></span>Next up</p>
        <p>This page is next in the build. The chrome, the type system and the
           components are already shared, so the content drops straight in.</p>
        <a class="btn btn--ink" href="<?= xe_url('contact.php') ?>">Start a project <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>
  </section>

<?php include 'partials/cta.php'; ?>
</main>

<?php include 'partials/footer.php'; ?>
