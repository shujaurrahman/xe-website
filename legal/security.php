<?php
/* Security & Disclosure — concept: the disclosure path, step by step, beside the live security.txt it publishes
   (read from .well-known/security.txt at render time). Template: partials/legal/doc.php · body: partials/legal/security.php.
   PLACEHOLDER: legal review by qualified counsel before launch. */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require __DIR__ . '/../partials/legal/lib.php';
$LG = [
    'key'   => 'security',
    'h1'    => ['Found a flaw?', 'Tell us first.'],
    'lead'  => 'A summary of how we protect our systems and our clients\' data, and our vulnerability disclosure policy: how to report a security issue to us, what we will do, and the safe harbour we offer researchers acting in good faith.',
    'scope' => 'Our website, systems and client work',
    'short' => [
        'Report vulnerabilities by <strong>email</strong>; our contact is also published in <strong><code>/.well-known/security.txt</code></strong>.',
        'We <strong>acknowledge, triage and fix</strong>, and keep you informed at each step.',
        'Act in good faith within this policy and we will <strong>not pursue legal action</strong> against you.',
        'No paid bug bounty today — we <strong>credit researchers</strong> who want it.',
    ],
    'toc' => [
        'practice' => 'How we work securely',
        'report'   => 'Reporting a vulnerability',
        'process'  => 'What happens next',
        'scope'    => 'Scope',
        'rules'    => 'Rules of engagement',
        'harbour'  => 'Safe harbour',
        'txt'      => 'security.txt',
    ],
    'body'    => __DIR__ . '/../partials/legal/security.php',
    'related' => ['privacy', 'responsible-ai', 'terms'],
];
require __DIR__ . '/../partials/legal/doc.php';
