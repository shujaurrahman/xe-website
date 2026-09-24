<?php
/* Legal hub — concept: the register. Every policy as a numbered entry with its summary, version and date, then the company's
   legal particulars and Grievance Officer. Shares the lgl styles; not the document template.
   PLACEHOLDER: legal review by qualified counsel before launch. */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require __DIR__ . '/../partials/legal/lib.php';
$page = [
    'key'   => 'legal',
    'title' => 'Legal',
    'desc'  => 'Every Xterra Edze policy in one register — privacy, terms, cookies, accessibility, commercial terms, intellectual property, responsible AI and security — with the company\'s legal particulars.',
    'css'   => ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/legal.css'],
    'js'    => ['assets/js/legal.js'],
];
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
include __DIR__ . '/../partials/legal/hub.php';
include __DIR__ . '/../partials/footer.php';
