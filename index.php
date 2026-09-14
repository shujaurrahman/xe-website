<?php
$BASE = '';
require 'partials/init.php';

$page = [
    'key'   => 'home',
    'title' => 'Xterra Edze — an independent creative company for the intelligence age',
    'desc'  => 'Xterra Edze builds intelligent brand systems — brand, technology, campaign, AI, product and marketing technology from one team, on one system.',
];

/* The running order follows the client's content document:
   who we are → what we do → why it compounds → the work → how we work → engage. */
$SECTIONS = [
    '01-hero',
    '02-showcase',
    '08-disciplines',
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
