<?php
/* Accessibility Statement — concept: an honest conformance board (built to / tested / known gap) and a barrier-report
   composer that writes the email for you. Template: partials/legal/doc.php · body: partials/legal/accessibility.php.
   PLACEHOLDER: legal review by qualified counsel before launch. */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require __DIR__ . '/../partials/legal/lib.php';
$LG = [
    'key'   => 'accessibility',
    'h1'    => ['Built for everyone.', 'Honest about the gaps.'],
    'lead'  => 'We want everyone to be able to use this website, whatever device, browser or assistive technology they rely on. This statement sets out the standard we build to, what we do to meet it, where we know we fall short, and how to tell us about a barrier.',
    'scope' => 'This website and its forms',
    'short' => [
        'Our target is <strong>WCAG 2.2 Level AA</strong>, the standard referenced by India\'s GIGW guidelines and the EU\'s EN 301 549.',
        'Every page is built to work with a <strong>keyboard</strong>, a <strong>screen reader</strong>, <strong>200% zoom</strong>, reduced motion and <strong>no JavaScript</strong>.',
        'We have <strong>not yet had an independent audit</strong>. The known limitations are listed below, plainly.',
        'Found a barrier? The <strong>report form</strong> in section 05 writes the email for you.',
    ],
    'toc' => [
        'standard'  => 'The standard we build to',
        'measures'  => 'What we do to meet it',
        'status'    => 'Conformance status',
        'limits'    => 'Known limitations',
        'report'    => 'Report a barrier',
        'review'    => 'How and when we review this',
    ],
    'body'    => __DIR__ . '/../partials/legal/accessibility.php',
    'related' => ['terms', 'privacy', 'security'],
];
require __DIR__ . '/../partials/legal/doc.php';
