<?php
/* Responsible AI Policy — concept: the control rail. Six gates every AI-assisted piece of client work passes, with human
   approval drawn as the one gate nothing skips. Template: partials/legal/doc.php · body: partials/legal/responsible-ai.php.
   PLACEHOLDER: legal review by qualified counsel before launch. */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require __DIR__ . '/../partials/legal/lib.php';
$LG = [
    'key'   => 'responsible-ai',
    'h1'    => ['AI does the work.', 'People sign it off.'],
    'lead'  => 'We use AI throughout our work, and we build AI systems for clients. This policy sets out the commitments that hold every time: human approval, no training on your data without written consent, disclosure, evaluation, careful vendor choice, data residency and logging.',
    'scope' => 'All client work that uses AI',
    'short' => [
        'A named person <strong>approves every AI-assisted output</strong> before it reaches you or your customers.',
        'We <strong>never train or fine-tune models on your data</strong> without your written consent, and use vendor settings that exclude it from their training.',
        'We <strong>tell you</strong> where AI was used in your work, and help you disclose it to your own users.',
        'Systems we build are <strong>evaluated and red-teamed</strong> before launch, and log what they do.',
    ],
    'toc' => [
        'rail'      => 'The six controls',
        'human'     => 'Human approval',
        'data'      => 'Your data and model training',
        'disclose'  => 'Disclosure',
        'evals'     => 'Evaluation and red-teaming',
        'vendors'   => 'Choosing models and vendors',
        'residency' => 'Data residency',
        'logging'   => 'Logging and audit',
        'limits'    => 'What we will not build',
        'frame'     => 'Frameworks we build to',
    ],
    'body'    => __DIR__ . '/../partials/legal/responsible-ai.php',
    'related' => ['privacy', 'security', 'commercial-policy'],
];
require __DIR__ . '/../partials/legal/doc.php';
