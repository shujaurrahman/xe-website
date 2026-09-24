<?php
/* Intellectual Property — concept: a mark-usage specimen sheet (do / don't, set in type, never the logo artwork) and a
   copyable attribution line. Template: partials/legal/doc.php · body: partials/legal/intellectual-property.php.
   PLACEHOLDER: legal review by qualified counsel before launch. */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require __DIR__ . '/../partials/legal/lib.php';
$LG = [
    'key'   => 'intellectual-property',
    'h1'    => ['Our name is registered.', 'Your work is yours.'],
    'lead'  => 'Xterra Edze® is a registered trademark. This page explains how you may refer to it, who owns what on this website, how the work we make for clients becomes theirs, and how to report an infringement.',
    'scope' => 'Our marks, this site, client deliverables',
    'short' => [
        '<strong>Xterra Edze®</strong> is a registered trademark in India. Refer to us by name freely; <strong>do not use the logo</strong> or imply endorsement.',
        'The content, design and code of this site are <strong>our copyright</strong>. Quote short passages with credit; ask before reusing more.',
        'Client deliverables are <strong>assigned to the client on payment</strong>, as the <a href="' . e(lgl_url('commercial-policy')) . '">Commercial Policy</a> describes.',
        'Technology logos on this site belong to their owners and <strong>imply no partnership</strong>.',
    ],
    'toc' => [
        'marks'    => 'Our registered trademark',
        'use'      => 'Using our name and marks',
        'copy'     => 'Copyright in this website',
        'client'   => 'Client work',
        'third'    => 'Third-party marks and content',
        'takedown' => 'Reporting an infringement',
    ],
    'body'    => __DIR__ . '/../partials/legal/intellectual-property.php',
    'related' => ['terms', 'commercial-policy', 'responsible-ai'],
];
require __DIR__ . '/../partials/legal/doc.php';
