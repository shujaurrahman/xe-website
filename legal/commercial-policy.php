<?php
/* Commercial Policy — concept: terms of business with a contract selector that shows how the standard terms apply to each of
   the six ways to contract (data/services/packages.php, read-only). Template: partials/legal/doc.php · body: partials/legal/commercial-policy.php.
   PLACEHOLDER: legal review by qualified counsel before launch. */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require __DIR__ . '/../partials/legal/lib.php';
$LGL_PK = require __DIR__ . '/../data/services/packages.php';
$LG = [
    'key'   => 'commercial-policy',
    'h1'    => ['Terms of business,', 'agreed before day one.'],
    'lead'  => 'These are the standard terms on which Xterra Edze works with clients. Every engagement is governed by a signed agreement and statement of work; <strong>where the signed agreement says something different, the signed agreement prevails.</strong>',
    'scope' => 'Clients and prospective clients',
    'short' => [
        'Every engagement starts with a <strong>statement of work</strong>: scope, outcome, team, timeline and fee, signed before work begins.',
        'Scope changes go through <strong>written change control</strong> — nothing is added to your bill without your approval.',
        'You own the <strong>deliverables on payment</strong>. We keep our pre-existing tools and know-how, and license what you need of them.',
        'Our liability is <strong>capped</strong> at the fees paid under the relevant statement of work; Indian law governs.',
    ],
    'toc' => [
        'basis'     => 'How these terms work',
        'contracts' => 'The six ways to contract',
        'sow'       => 'Statements of work',
        'change'    => 'Change control',
        'fees'      => 'Fees, invoicing and GST',
        'ip'        => 'Intellectual property',
        'conf'      => 'Confidentiality',
        'data'      => 'Data protection',
        'warranty'  => 'Warranties',
        'liability' => 'Liability',
        'term'      => 'Termination',
        'nonsol'    => 'Non-solicitation',
        'law'       => 'Governing law and disputes',
    ],
    'body'    => __DIR__ . '/../partials/legal/commercial-policy.php',
    'related' => ['intellectual-property', 'responsible-ai', 'security'],
];
require __DIR__ . '/../partials/legal/doc.php';
