<?php
/* Terms of Use — concept: the website's house rules, short and plain. Template: partials/legal/doc.php · body: partials/legal/terms.php.
   PLACEHOLDER: legal review by qualified counsel before launch. */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require __DIR__ . '/../partials/legal/lib.php';
$LG = [
    'key'   => 'terms',
    'h1'    => ['Using this site,', 'on plain terms.'],
    'lead'  => 'These terms govern your use of this website. They do not cover client engagements — those run on a signed agreement and our <a class="tl" href="' . e(lgl_url('commercial-policy')) . '">Commercial Policy</a>.',
    'scope' => 'Every visitor to this website',
    'short' => [
        'You may <strong>read, share and link to</strong> this site. You may not copy its design, code or content for your own use.',
        'The site describes what we do; it is <strong>not an offer</strong>. A proposal or signed agreement is what binds us.',
        'We work to keep it accurate and available, but <strong>cannot promise</strong> it is error-free or always online.',
        'These terms are governed by <strong>the laws of India</strong>; the courts at <strong>New Delhi</strong> have jurisdiction.',
    ],
    'toc' => [
        'accept'   => 'Agreeing to these terms',
        'use'      => 'Using the site',
        'content'  => 'Our content and marks',
        'noffer'   => 'Information, not an offer',
        'submit'   => 'What you send us',
        'links'    => 'Links to other sites',
        'warranty' => 'No warranty',
        'liability'=> 'Limits on our liability',
        'law'      => 'Governing law and courts',
        'misc'     => 'Changes and contact',
    ],
    'body'    => __DIR__ . '/../partials/legal/terms.php',
    'related' => ['privacy', 'intellectual-property', 'commercial-policy'],
];
require __DIR__ . '/../partials/legal/doc.php';
