<?php /* DRAFT COPY — review before launch */
$E404_MAIN = [
    ['Home',        'index.php',      'compass', 'The whole company on one page.'],
    ['What we do',  'services/',      'layers',  'Six disciplines and every capability.'],
    ['Industries',  'industries.php', 'globe',   'Where we work and what we know there.'],
    ['Work',        'work.php',       'target',  'How programmes run and what they ship.'],
    ['Approach',    'approach.php',   'workflow','How we plan, build, review and hand over.'],
    ['Careers',     'careers.php',    'users',   'Open roles and how we hire.'],
    ['Contact',     'contact.php',    'chat',    'Send a brief or book a call.'],
    ['Capability finder', 'services/#finder', 'search', 'Search every capability by the need it answers.'],
];
?>
<section class="band band--alt e404-routes" id="destinations" aria-labelledby="destinations-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div><p class="lbl lbl--blue"><span class="dot"></span>Destinations</p>
        <h2 class="h2" id="destinations-t"><span class="g">Where to go instead.</span> Every main page, one step away.</h2></div>
      <div><p class="lead">If a link on our own site sent you here, tell us at <a class="tl" href="mailto:<?= e($SITE['company']['email']) ?>?subject=<?= rawurlencode('Broken link: ' . ($e404_path ?: '/')) ?>"><?= e($SITE['company']['email']) ?></a> and we will fix it.</p></div>
    </div>

    <ul class="e404-dest">
      <?php foreach ($E404_MAIN as $e404_m): ?>
        <li><a class="e404-dest__a" href="<?= e(xe_url($e404_m[1])) ?>">
          <?= xt_icon($e404_m[2]) ?>
          <span class="e404-dest__t"><?= e($e404_m[0]) ?></span>
          <span class="e404-dest__d"><?= e($e404_m[3]) ?></span>
          <span class="e404-dest__go" aria-hidden="true">›</span>
        </a></li>
      <?php endforeach; ?>
    </ul>

    <h3 class="e404-sub">The six disciplines</h3>
    <ul class="e404-disc">
      <?php foreach ($SITE['disciplines'] as $e404_d): ?>
        <li><a href="<?= e(xe_discipline_url($e404_d)) ?>"><span><?= e($e404_d['n']) ?></span><?= e($e404_d['name']) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
