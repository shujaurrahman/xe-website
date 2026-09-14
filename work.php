<?php
$BASE = '';
require 'partials/init.php';

$page = ['key' => 'work', 'title' => 'Work', 'desc' => 'Work that reshapes how people experience a brand, moves the numbers that matter, and leaves the system better than we found it.'];

$hero = [
    'eyebrow' => 'Selected work',
    'title'   => 'Delivered.',
    'lead'    => 'Work that reshapes how people experience a brand, moves the numbers that matter, and leaves the system better than we found it.',
];

include 'partials/head.php';
include 'partials/nav.php';
?>

<main id="main">
<?php include 'partials/page-hero.php'; ?>

  <section class="band" aria-labelledby="work-t">
    <div class="wrap">
      <h2 class="sr" id="work-t">Work</h2>
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
