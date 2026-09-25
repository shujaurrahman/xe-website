<?php
/**
 * Approach — the shared map. Required once by approach.php into $APR, so the stepper, the gates
 * section and the engagements section all read the same six stages and five gates and can never
 * disagree with each other.
 *
 * DRAFT COPY — review before launch.
 * Every timeframe here is a typical range across the six disciplines, not a promise, and not a
 * quote. A technology programme runs longer than a brand sprint; partials/tech/hub/delivery.php
 * carries the longer five-phase plan for those, and this page links to it.
 * <!-- PLACEHOLDER: confirm typical stage lengths and team make-up before launch -->
 *
 * A stage row:
 *   key        url-safe id; the pane is #stage-<key> and the tab #stages-t<index>
 *   n          the display number
 *   name       one word where possible
 *   clock      typical duration, always written as typical
 *   icon       an xt_icon() name
 *   line       one sentence: what this stage is for
 *   happens    3–5 things that actually happen
 *   ours       who we put in the room
 *   yours      who we need from the client
 *   gets       what the client holds at the end of the stage
 *   unlocks    the decision the stage exists to make possible
 *   agents     where agents do the legwork in this stage
 *   signs      what a named person signs before the stage can close
 *   gate       the key of the gate that closes this stage, or ''
 *
 * A gate row: n, name, after (the stage's display name), stage (its key, for the link),
 * question, evidence, signs, no (what happens when the answer is no).
 */

return [

'stages' => [

    [
        'key'     => 'frame',
        'n'       => '01',
        'name'    => 'Frame',
        'clock'   => 'Typically 1–2 weeks',
        'icon'    => 'target',
        'line'    => 'Agree the problem, the one measure it is judged on, and what would make this not worth doing.',
        'happens' => [
            'A working session with the people who own the problem and the number',
            'We read the data you already have, rather than asking for a new survey',
            'The measure, its baseline, the window and the verifier are written down',
            'Constraints are recorded: regulatory, technical, brand, calendar, budget',
        ],
        'ours'    => ['Engagement lead', 'Discipline lead', 'AI lead'],
        'yours'   => ['Your sponsor', 'Whoever owns the number', 'Whoever owns the data'],
        'gets'    => [
            'A one-page problem statement, in your words',
            'The measurement contract: measure, baseline, window, verifier',
            'A constraints register with owners',
            'An outline plan with a shape and a price range',
        ],
        'unlocks' => 'Whether to invest at all, and what to do first.',
        'agents'  => [
            'Desk research and the category read, with every source attached and openable',
            'Your existing analytics summarised into a baseline for a person to check',
            'A first constraints register drafted from your policies and documentation',
        ],
        'signs'   => 'Your sponsor signs the problem statement and the measure. Nothing starts without both.',
        'gate'    => 'invest',
    ],

    [
        'key'     => 'shape',
        'n'       => '02',
        'name'    => 'Shape',
        'clock'   => 'Typically 2–3 weeks',
        'icon'    => 'compass',
        'line'    => 'Put two or three real routes on the table with their trade-offs, and prototype the riskiest part of the one you pick.',
        'happens' => [
            'Two or three routes, each with what it costs you and what it costs us',
            'The architecture, or the brand system, sketched far enough to be argued with',
            'The riskiest assumption prototyped before it is budgeted',
            'Risks named with an owner each, and the quality gates agreed',
        ],
        'ours'    => ['Strategy lead', 'Design lead', 'Solution architect', 'Security engineer'],
        'yours'   => ['Your sponsor', 'Your product owner', 'Your IT and security leads'],
        'gets'    => [
            'Two or three costed routes with trade-offs stated plainly',
            'The chosen architecture or system, as decision records',
            'A prototype of the part most likely to fail',
            'The delivery plan, with its gates and what each one needs',
        ],
        'unlocks' => 'Which route, and the budget and calendar for it.',
        'agents'  => [
            'Route variants and cost models generated for people to judge, not to accept',
            'Prototype scaffolding built from the design system so the prototype is real',
            'Claims and figures in the routes checked against their sources',
        ],
        'signs'   => 'Your sponsor picks the route. Your security lead signs the approach before a line of production code exists.',
        'gate'    => 'route',
    ],

    [
        'key'     => 'build',
        'n'       => '03',
        'name'    => 'Build',
        'clock'   => 'Typically 4–12 weeks, in two-week sprints',
        'icon'    => 'code',
        'line'    => 'Ship working output every sprint, shown working, with the checks running on every change.',
        'happens' => [
            'A goal per sprint, agreed with your product owner',
            'A demo of working output every sprint, on a preview environment',
            'Tests, evals and security scans run on every change, in your pipeline',
            'Runbooks and the decision log written as features land, not afterwards',
        ],
        'ours'    => ['Delivery lead', 'Designers', 'Engineers', 'QA and eval engineer'],
        'yours'   => ['Your product owner, weekly', 'Reviewers when a decision needs them'],
        'gets'    => [
            'Working output at the end of every sprint, in your repositories',
            'The test, eval and scan suites, owned by you',
            'A decision log that is current, not reconstructed',
            'Runbooks for everything that will need running',
        ],
        'unlocks' => 'Sprint by sprint: what ships next, and what gets dropped.',
        'agents'  => [
            'Pairing in the editor; people review every line before it merges',
            'Tests and pull-request summaries drafted, then kept or discarded by an engineer',
            'The eval suite run on every change, with regressions blocking the merge',
        ],
        'signs'   => 'A named engineer approves every merge. Agents cannot merge, and there is no exception for a deadline.',
        'gate'    => 'quality',
    ],

    [
        'key'     => 'prove',
        'n'       => '04',
        'name'    => 'Prove',
        'clock'   => 'Typically 1–2 weeks',
        'icon'    => 'clipboard-check',
        'line'    => 'Independent checks before anything reaches a customer, run by people who did not build it.',
        'happens' => [
            'A keyboard and screen-reader pass done by a person, not only a scanner',
            'Performance measured on devices your customers actually use',
            'A penetration test where the work warrants one',
            'AI features run in shadow mode against human output before they are live',
        ],
        'ours'    => ['QA lead', 'Accessibility reviewer', 'Security engineer', 'Site reliability engineer'],
        'yours'   => ['Your security lead', 'Your support lead'],
        'gets'    => [
            'An accessibility report against WCAG 2.2 level AA',
            'A performance report on field-representative devices',
            'The eval report against its gates, and the scan results',
            'The cutover plan, with the rollback rehearsed and timed',
        ],
        'unlocks' => 'Go or no-go. A no here is cheaper than a rollback later.',
        'agents'  => [
            'The automated suites run and regressions flagged with the change that caused them',
            'AI output compared with human output on the same cases, in shadow',
            'Load profiles generated from your real traffic patterns',
        ],
        'signs'   => 'Your security lead signs the sign-off. Our release manager signs the cutover plan.',
        'gate'    => 'golive',
    ],

    [
        'key'     => 'launch',
        'n'       => '05',
        'name'    => 'Launch',
        'clock'   => 'Typically 1 week, then two weeks of hypercare',
        'icon'    => 'rocket',
        'line'    => 'Release in stages, with the rollback rehearsed and someone on call who knows what to do.',
        'happens' => [
            'A staged release: a small share of traffic first, widened while the numbers hold',
            'Automatic rollback armed on error rate and latency thresholds',
            'Your team trained on the thing they are about to own',
            'Two weeks of hypercare with a named engineer reachable',
        ],
        'ours'    => ['Release manager', 'Site reliability engineer', 'On-call engineer'],
        'yours'   => ['Your support lead', 'Your communications lead', 'Your sponsor'],
        'gets'    => [
            'The release, and the record of how it was rolled out',
            'The rollback rehearsal, with the time it took',
            'Training delivered, and the runbooks it was based on',
            'A first-week report against the measure agreed in Frame',
        ],
        'unlocks' => 'Whether to widen the rollout, hold, or roll back.',
        'agents'  => [
            'The canary watched continuously; rollback triggered on threshold, without waiting for a human',
            'Release notes and training material drafted from the decision log',
            'Alert noise triaged so the on-call engineer sees what matters',
        ],
        'signs'   => 'Your sponsor signs the release. A named engineer approves every production change during hypercare.',
        'gate'    => '',
    ],

    [
        'key'     => 'run',
        'n'       => '06',
        'name'    => 'Run and hand over',
        'clock'   => 'Ongoing · reviewed at 30 and 90 days',
        'icon'    => 'sync',
        'line'    => 'Measure what we promised, improve what the numbers point at, and transfer ownership properly.',
        'happens' => [
            'A monthly report against the measure, the service levels and the cost',
            'Incident reviews without blame, and the fix tracked to done',
            'A ranked improvement backlog you set the order of',
            'Handover: repositories, accounts, documentation, training, named owners',
        ],
        'ours'    => ['Service owner', 'On-call squad', 'Discipline leads'],
        'yours'   => ['Your product owner', 'The team who will own it', 'Your finance partner, for cost'],
        'gets'    => [
            'The monthly service report, in a format your board can read',
            'The 30-day and 90-day reviews against the measurement contract',
            'The handover pack: everything needed to run it without us',
            'Named owners inside your team, trained and signed off',
        ],
        'unlocks' => 'A retainer, the next phase, or a clean exit. All three are fine.',
        'agents'  => [
            'Alerts triaged and incident timelines drafted for a person to verify',
            'Eval drift watched after every model or data change',
            'Cost anomalies flagged with a proposed fix, for approval',
        ],
        'signs'   => 'Your team signs the handover as complete. Until they do, it is not finished.',
        'gate'    => 'handover',
    ],

],

/* The five gates. A gate is a decision with evidence attached, not a meeting. */
'gates' => [
    'invest' => [
        'n'        => 'G1',
        'name'     => 'Invest',
        'after'    => 'Frame',
        'stage'    => 'frame',
        'question' => 'Is this problem worth solving, and is this the first thing to solve?',
        'evidence' => ['The problem statement', 'The measure and its baseline', 'The constraints register', 'The outline plan and price range'],
        'signs'    => 'Your sponsor',
        'no'       => 'We stop and say so. You keep the problem statement and the baseline, which are useful on their own.',
    ],
    'route' => [
        'n'        => 'G2',
        'name'     => 'Route',
        'after'    => 'Shape',
        'stage'    => 'shape',
        'question' => 'Which route, and can we live with what it costs and what it rules out?',
        'evidence' => ['Two or three costed routes', 'The architecture or system, as decision records', 'The prototype of the riskiest part', 'The risk register with owners'],
        'signs'    => 'Your sponsor, with your IT and security leads',
        'no'       => 'We reshape rather than build. Cheaper here than in week nine.',
    ],
    'quality' => [
        'n'        => 'G3',
        'name'     => 'Quality',
        'after'    => 'Build',
        'stage'    => 'build',
        'question' => 'Does the work meet the standard we agreed, on evidence rather than opinion?',
        'evidence' => ['Tests and evals green in your pipeline', 'Security and dependency scans clean', 'Accessibility pass by a person', 'The decision log current'],
        'signs'    => 'Your security lead, with our delivery lead',
        'no'       => 'It does not move to Prove. The sprint goal changes; the standard does not.',
    ],
    'golive' => [
        'n'        => 'G4',
        'name'     => 'Go-live',
        'after'    => 'Prove',
        'stage'    => 'prove',
        'question' => 'Are we ready to put this in front of customers, and ready to take it back out?',
        'evidence' => ['Accessibility, performance and eval reports', 'Penetration-test report where applicable', 'Cutover plan and rehearsed rollback', 'On-call rota staffed and trained'],
        'signs'    => 'Your sponsor, with our release manager',
        'no'       => 'The date moves. We will not launch something we would not be on call for.',
    ],
    'handover' => [
        'n'        => 'G5',
        'name'     => 'Handover accepted',
        'after'    => 'Run',
        'stage'    => 'run',
        'question' => 'Can your team run and change this without us in the room?',
        'evidence' => ['The handover pack, complete', 'Training delivered and understood', 'Named owners inside your team', 'The 90-day review against the measure'],
        'signs'    => 'Your team lead',
        'no'       => 'We stay until it is a yes. Handover is a deliverable, not a date.',
    ],
],

];
