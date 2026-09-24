<?php
/* Privacy Notice — concept: the data map. Every item we hold, where it comes from, why, and for how long, filterable by source.
   Template: partials/legal/doc.php · body: partials/legal/privacy.php. PLACEHOLDER: legal review by qualified counsel before launch. */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require __DIR__ . '/../partials/legal/lib.php';
$LG = [
    'key'   => 'privacy',
    'h1'    => ['Your data,', 'accounted for.'],
    'lead'  => 'This notice explains what personal data Xterra Edze collects through this website and in the course of our work, why we use it, who we share it with, how long we keep it, and the rights you have. It is written to meet India\'s Digital Personal Data Protection Act 2023 and its Rules, the Information Technology Act 2000, and — where they apply to you — the EU and UK GDPR.',
    'scope' => 'This website, enquiries, calls, applications',
    'short' => [
        'We collect only what you <strong>send us</strong> — an enquiry, a services brief, an application — plus standard <strong>server logs</strong>.',
        '<strong>No analytics, advertising or tracking cookies</strong> run on this site today. The <a href="' . e(lgl_url('cookies')) . '">Cookie Policy</a> lists every storage item by name.',
        'We use your data to reply, to run the work you ask for, and to keep the site secure. <strong>We do not sell it</strong> and never use it to train AI models.',
        'You can ask to see, correct or erase your data, withdraw consent, or complain to our <strong>Grievance Officer</strong> — and, if unresolved, to the Data Protection Board of India.',
    ],
    'toc' => [
        'who'       => 'Who we are',
        'collect'   => 'What we collect — the data map',
        'use'       => 'Why we use it, and on what basis',
        'storage'   => 'Cookies and browser storage',
        'share'     => 'Who we share it with',
        'transfer'  => 'Transfers outside India',
        'retention' => 'How long we keep it',
        'rights'    => 'Your rights',
        'children'  => 'Children',
        'security'  => 'Security',
        'grievance' => 'Grievance Officer and complaints',
        'changes'   => 'Changes to this notice',
    ],
    'body'    => __DIR__ . '/../partials/legal/privacy.php',
    'related' => ['cookies', 'security', 'responsible-ai'],
];
require __DIR__ . '/../partials/legal/doc.php';
