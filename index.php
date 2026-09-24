<?php
$BASE = '';
require 'partials/init.php';
/* The discipline hubs' shared kit, so home-page sections can use the xt_* helpers
   (logos, icons, standards badges) exactly as services/technology-intelligence.php does.
   Only defines functions — including it changes nothing on its own. */
require_once 'partials/tech/kit.php';

$page = [
    'key'   => 'home',
    'title' => 'Xterra Edze — an independent creative company for the intelligence age',
    'desc'  => 'Xterra Edze builds intelligent brand systems — brand, technology, campaign, AI, product and marketing technology from one team, on one system.',
    /* The same base layer the Brand Design and Technology & Intelligence hubs are built on:
       .bdh-* layout primitives and .xt-* logos/icons/badges. Loaded after sections.css, so a
       section that needs to win against a .bdh-* rule must qualify it with its own .sNN class.
       Sections opt in by carrying "bdh" on their root — that is what defines the --bdh-* tokens. */
    'css'   => ['assets/css/brand/hub.css', 'assets/css/tech/kit.css'],
    /* window.BDH. It loads after assets/js/sections.js, so a section script must defer its
       init to DOMContentLoaded before touching BDH (see the section briefs). */
    'js'    => ['assets/js/brand/hub.js'],
];

/* The home page reads as one story in five chapters: the idea (the intelligence layer) →
   what we do → how we work → the work → working with us. Each chapter opens with a
   "Chapter 0N" eyebrow; the chapter rail below follows the reader through them.
   Bands alternate paper / alt with at most one ink section per chapter, never two ink neighbours. */
$HX_CHAPTERS = [
    ['The idea',      ['01-hero', '05-flow', '04-pillars', '09-proof']],
    ['What we do',    ['08-disciplines', '23-brand', '24-technology', '07-ai-design', '06-equip', '14-platforms']],
    ['How we work',   ['12-process', '13-operation', '16-why']],
    ['The work',      ['02-showcase', '17-delivered', '10-production', '03-industries', '11-clients', '15-testimonials']],
    ['Work with us',  ['18-engagements', '25-offer', '19-cta-card', '20-booking', '21-faq', '22-final-cta']],
];
/* Section file → its root id: the rail links to each chapter's opener and spies on every section. */
$HX_IDS = ['01-hero' => 'hero', '05-flow' => 'flow', '04-pillars' => 'pillars', '09-proof' => 'proof',
           '08-disciplines' => 'disciplines', '23-brand' => 'brand', '24-technology' => 'technology',
           '07-ai-design' => 'ai-design', '06-equip' => 'equip', '14-platforms' => 'platforms',
           '12-process' => 'process', '13-operation' => 'operation', '16-why' => 'why',
           '02-showcase' => 'showcase', '17-delivered' => 'delivered', '10-production' => 'production',
           '03-industries' => 'industries', '11-clients' => 'clients', '15-testimonials' => 'testimonials',
           '18-engagements' => 'engagements', '25-offer' => 'offer', '19-cta-card' => 'cta', '20-booking' => 'book',
           '21-faq' => 'faq', '22-final-cta' => 'cta-final'];
$SECTIONS = array_merge(...array_column($HX_CHAPTERS, 1));

include 'partials/head.php';
include 'partials/nav.php';
?>

<!-- Chapter rail: a fixed index at desktop widths, a slim progress strip on phones.
     Hidden until sections.js (00-story) switches it on, so without JS nothing floats over the page. -->
<nav class="hx-rail" aria-label="Home page chapters" data-hx-rail hidden>
  <ol class="hx-rail__list">
<?php foreach ($HX_CHAPTERS as $hx_n => [$hx_name, $hx_secs]): ?>
    <li><a class="hx-rail__a" href="#<?= $HX_IDS[$hx_secs[0]] ?>" data-hx-ch="<?= $hx_n ?>" data-hx-ids="<?= implode(' ', array_map(fn ($hx_f) => $HX_IDS[$hx_f], $hx_secs)) ?>"><span class="hx-rail__n"><?= sprintf('%02d', $hx_n + 1) ?></span><span class="hx-rail__l"><?= e($hx_name) ?></span></a></li>
<?php endforeach; ?>
  </ol>
  <span class="hx-rail__bar" aria-hidden="true"><?php foreach ($HX_CHAPTERS as $hx_n => $hx_c): ?><i data-hx-seg="<?= $hx_n ?>"></i><?php endforeach; ?></span>
</nav>

<main id="main">
<?php foreach ($HX_CHAPTERS as $hx_n => [$hx_name, $hx_secs]): ?>
<!-- ===== Chapter <?= sprintf('%02d', $hx_n + 1) ?> · <?= e($hx_name) ?> ===== -->
<?php foreach ($hx_secs as $hx_s): ?>
<!-- ===== <?= $hx_s ?> ===== -->
<?php xe_section($hx_s); ?>
<?php endforeach; ?>
<?php endforeach; ?>
</main>

<?php include 'partials/footer.php'; ?>
