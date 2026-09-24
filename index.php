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

/* The running order follows the client's content document:
   who we are → what we do → why it compounds → the work → how we work → engage. */
$SECTIONS = [
    '01-hero',
    '02-showcase',
    '08-disciplines',
    '23-brand',
    '24-technology',
    '04-pillars',
    '05-flow',
    '06-equip',
    '07-ai-design',
    '03-industries',
    '17-delivered',
    '11-clients',
    '10-production',
    '12-process',
    '13-operation',
    '14-platforms',
    '09-proof',
    '16-why',
    '15-testimonials',
    '18-engagements',
    '25-offer',
    '19-cta-card',
    '20-booking',
    '21-faq',
    '22-final-cta',
];

include 'partials/head.php';
include 'partials/nav.php';
?>

<main id="main">
<?php foreach ($SECTIONS as $s): ?>
<!-- ===== <?= $s ?> ===== -->
<?php xe_section($s); ?>
<?php endforeach; ?>
</main>

<?php include 'partials/footer.php'; ?>
