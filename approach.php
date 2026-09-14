<?php
$BASE = '';
require 'partials/init.php';

$page = ['key' => 'approach', 'title' => 'Approach', 'desc' => 'We have rebuilt how we work around AI. What has not changed is what we stand for.'];

$hero = [
    'eyebrow' => 'How we work',
    'title'   => 'AI runs the operation.<br><span class="g">People run the strategy.</span>',
    'lead'    => 'We have rebuilt how we work around AI. What has not changed is what we stand for.',
];

include 'partials/head.php';
include 'partials/nav.php';
?>

<main id="main">
<?php include 'partials/page-hero.php'; ?>

  <section class="band" aria-labelledby="approach-t">
    <div class="wrap">
      <h2 class="sr" id="approach-t">Approach</h2>
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
