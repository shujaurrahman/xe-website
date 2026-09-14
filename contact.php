<?php
$BASE = '';
require 'partials/init.php';

$page = ['key' => 'contact', 'title' => 'Contact', 'desc' => 'Tell us what you are building and we will tell you straight whether we are the right team for it.'];

$hero = [
    'eyebrow' => 'Contact',
    'title'   => 'Thirty minutes,<br><span class="g">and a straight answer.</span>',
    'lead'    => 'Tell us what you are building and we will tell you straight whether we are the right team for it.',
];

include 'partials/head.php';
include 'partials/nav.php';
?>

<main id="main">
<?php include 'partials/page-hero.php'; ?>

  <section class="band" aria-labelledby="contact-t">
    <div class="wrap">
      <h2 class="sr" id="contact-t">Contact</h2>
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
