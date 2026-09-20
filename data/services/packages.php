<?php
/**
 * Engagement packages — the six ways to buy work from Xterra Edze, site-wide.
 *
 * Every discipline's service catalogue (data/services/<discipline>.php) lists which of these
 * apply to each page, in display order ('packages' => ['sprint', 'project', …]). The contact
 * page offers all six. Keys are fixed: sprint, project, milestone, retainer, enterprise, squad.
 *
 *   'name'     display name
 *   'tagline'  one line: what the package is
 *   'duration' typical length (PLACEHOLDER — confirm before launch)
 *   'pricing'  the pricing MODEL, never an amount
 *   'includes' 3–5 things every engagement of this kind carries
 *   'best'     who it suits
 *   'icon'     an svc_icon() name (partials/services/lib.php)
 *
 * DRAFT COPY — review before launch. No prices, ever: scope, typical length and pricing model only.
 */

return [

    'sprint' => [
        'name'     => 'Sprint',
        'tagline'  => 'One fixed question, answered in one to three weeks.',
        'duration' => '1–3 weeks',              // PLACEHOLDER: typical — confirm
        'pricing'  => 'Fixed fee',
        'includes' => [
            'Scope and outcome agreed before day one',
            'One senior lead and the specialists the question needs',
            'A working review every week',
            'A decision-ready output, not a status deck',
        ],
        'best'     => 'Discovery, a diagnostic, a prototype or a decision you need to make soon',
        'icon'     => 'bolt',
    ],

    'project' => [
        'name'     => 'Project',
        'tagline'  => 'A defined scope, delivered for a fixed price.',
        'duration' => '4–12 weeks',             // PLACEHOLDER: typical — confirm
        'pricing'  => 'Fixed price',
        'includes' => [
            'Statement of work with deliverables and acceptance criteria',
            'A named project lead and a fixed team',
            'A shared plan with dated checkpoints',
            'Source files and IP transferred on delivery',
        ],
        'best'     => 'Work you can describe up front: an identity, a system, a set of tools',
        'icon'     => 'target',
    ],

    'milestone' => [
        'name'     => 'Milestone',
        'tagline'  => 'A larger build, split into gated phases you approve and pay for one at a time.',
        'duration' => '3–9 months',             // PLACEHOLDER: typical — confirm
        'pricing'  => 'Fixed price per milestone',
        'includes' => [
            'Phases with their own scope, output and sign-off',
            'A go or no-go review at every gate',
            'Re-planning between phases as you learn',
            'Payment tied to accepted milestones',
        ],
        'best'     => 'Programmes too big to fix in one contract, and teams that want control at each step',
        'icon'     => 'flag',
    ],

    'retainer' => [
        'name'     => 'Retainer',
        'tagline'  => 'Reserved monthly capacity to run, improve and extend what we built.',
        'duration' => 'Ongoing · 6-month minimum',   // PLACEHOLDER: typical — confirm
        'pricing'  => 'Monthly fee',
        'includes' => [
            'A reserved block of team time every month',
            'Agreed response times for requests and fixes',
            'A monthly review and a rolling backlog',
            'Continuous improvement, not just upkeep',
        ],
        'best'     => 'Brands and products after launch that need a steady team without hiring one',
        'icon'     => 'cycle',
    ],

    'enterprise' => [
        'name'     => 'Enterprise',
        'tagline'  => 'A multi-workstream programme with governance, a dedicated team and SLAs.',
        'duration' => '6–18 months',            // PLACEHOLDER: typical — confirm
        'pricing'  => 'Programme fee · by statement of work',
        'includes' => [
            'An engagement director and a steering group',
            'A dedicated team across several workstreams',
            'Service levels, reporting and a risk register',
            'Security, legal and procurement reviews built into the plan',
        ],
        'best'     => 'Large organisations running change across markets, portfolios or business units',
        'icon'     => 'building',
    ],

    'squad' => [
        'name'     => 'Squad',
        'tagline'  => 'A dedicated team working inside your stack, tools and sprint cadence.',
        'duration' => 'Ongoing · 3-month minimum',   // PLACEHOLDER: typical — confirm
        'pricing'  => 'Time & materials',
        'includes' => [
            'Named specialists matched to your roadmap',
            'Your tools, your rituals, your backlog',
            'Scale the team up or down each month',
            'Knowledge transfer built in from week one',
        ],
        'best'     => 'Teams with a clear roadmap that need more senior hands, fast',
        'icon'     => 'users',
    ],

];
