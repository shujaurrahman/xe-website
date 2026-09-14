<?php
$BASE = '';
require 'partials/init.php';

$page = ['key' => 'careers', 'title' => 'Careers', 'desc' => 'One team across brand, technology, campaign, AI, product and marketing technology — working from New Delhi and Ludhiana.'];

$hero = [
    'eyebrow' => 'Careers',
    'title'   => 'Build the work<br><span class="g">that outlasts the brief.</span>',
    'lead'    => 'One team across brand, technology, campaign, AI, product and marketing technology — working from New Delhi and Ludhiana.',
];

include 'partials/head.php';
include 'partials/nav.php';
?>

<main id="main">
<?php include 'partials/page-hero.php'; ?>

  <section class="band" aria-labelledby="careers-t">
    <div class="wrap">
      <h2 class="sr" id="careers-t">Careers</h2>
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
