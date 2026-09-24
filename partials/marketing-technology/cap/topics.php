<?php /* DRAFT COPY — review before launch */
/**
 * Per-topic extras for the capability template (data/marketing-technology.php is the main source).
 *   flow   5 × [step label, title, description, xt_icon] — where this capability sits in the engine; 'hot' = its own node
 *   viz    illustrative chart: title, the measure, x labels, treated and holdout series (0–100 of the chart height),
 *          and the note. Shapes only: no figures are claimed.
 *   parts  Customer Relationship Strategy only: its five practices, each a section of the one page —
 *          [anchor id, eyebrow, heading HTML, 3 × what it covers, what it produces]
 */
return [
    'ai-driven-marketing-automation' => [
        'flow' => [
            ['Signal', 'Event arrives', 'Trial started, cart left, renewal due: streamed server-side with identity attached.', 'pipeline'],
            ['Check', 'Consent & pressure', 'Purpose, channel consent, frequency caps and quiet hours checked before anything runs.', 'shield'],
            ['Decide', 'Journey step', 'Entry rules, branch, wait and next best action, with a rule-based fallback.', 'workflow'],
            ['Approve', 'Person signs off', 'Campaign sends and new templates wait for a named approver.', 'approve'],
            ['Measure', 'Against holdout', 'Every journey reports lift against a group that did not receive it.', 'chart'],
        ],
        'hot'  => 2,
        'viz'  => ['Journey lift', 'Conversion by week, journey vs holdout', ['Wk 1', 'Wk 2', 'Wk 3', 'Wk 4', 'Wk 5', 'Wk 6', 'Wk 7'],
            [22, 30, 38, 44, 49, 53, 56], [21, 23, 24, 26, 27, 27, 28], 'The shaded area is the journey’s contribution: what happened to people who received it, minus what happened to a comparable group who did not.'],
    ],
    'content-communication-infrastructure' => [
        'flow' => [
            ['Source', 'Content model', 'Structured types and approved blocks in a headless CMS, not pasted copy.', 'layers'],
            ['Assemble', 'One message', 'Rendered per channel from the same source, in every language you publish in.', 'doc'],
            ['Check', 'Consent per channel', 'Each channel is sent only where the person agreed to it, for that purpose.', 'shield'],
            ['Route', 'Channel adapters', 'Email, SMS, WhatsApp templates, push and in-app through one sending layer.', 'network'],
            ['Record', 'Delivery log', 'Sent, held, suppressed and failed recorded with the reason.', 'log'],
        ],
        'hot'  => 3,
        'viz'  => ['Time to publish', 'Hours from approved copy to live, per release', ['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7'],
            [70, 58, 44, 34, 26, 22, 20], [72, 71, 73, 70, 72, 71, 72], 'Shape only. The solid line is a release process on shared content and channel adapters; the dashed line is the same work copied into each channel by hand.'],
    ],
    'ai-campaign-optimization' => [
        'flow' => [
            ['Signal', 'Conversions in', 'Server-side conversions and offline sales, deduplicated and consented.', 'pipeline'],
            ['Model', 'Forecast', 'Expected return per ad set and audience at the next unit of spend.', 'brain'],
            ['Guard', 'Guardrails', 'Daily shift limits, spend floors, brand safety and frequency caps.', 'shield'],
            ['Approve', 'Above threshold', 'Moves bigger than the agreed limit wait for a person.', 'approve'],
            ['Prove', 'Incrementality', 'Geo and holdout tests confirm what the platforms report.', 'chart'],
        ],
        'hot'  => 2,
        'viz'  => ['Cost per acquisition', 'Cost per acquisition by week, optimised vs fixed split', ['Wk 1', 'Wk 2', 'Wk 3', 'Wk 4', 'Wk 5', 'Wk 6', 'Wk 7'],
            [66, 60, 55, 50, 47, 45, 44], [66, 65, 67, 66, 68, 67, 69], 'Lower is better. Shape only: in-flight reallocation against a budget left on its launch split, with the gap confirmed by a holdout test rather than by platform reporting.'],
    ],
    'ai-creative-solutions' => [
        'flow' => [
            ['Brief', 'Structured brief', 'Audience, message, offer and mandatory lines as fields, not prose.', 'clipboard-check'],
            ['Generate', 'Variants', 'Copy and imagery drafted inside your templates and brand tokens.', 'sparkle'],
            ['Check', 'Brand & claims', 'Automated checks for tokens, contrast, legal lines and unapproved claims.', 'scan'],
            ['Approve', 'Creative lead', 'A person approves every variant that will be published.', 'approve'],
            ['Learn', 'Creative results', 'Performance by element feeds the next brief.', 'trend-up'],
        ],
        'hot'  => 1,
        'viz'  => ['Variants shipped', 'Approved variants per week, pipeline vs manual', ['Wk 1', 'Wk 2', 'Wk 3', 'Wk 4', 'Wk 5', 'Wk 6', 'Wk 7'],
            [18, 30, 42, 52, 60, 66, 70], [16, 18, 17, 19, 18, 20, 19], 'Shape only. Variants counted only once a person has approved them; the review load is part of the design, not an afterthought.'],
    ],
    'ai-lead-generation' => [
        'flow' => [
            ['Capture', 'Signals', 'Forms, product usage, intent and web visits, consented and deduplicated.', 'radar'],
            ['Enrich', 'Firmographics', 'Company, role and fit data added from sources you are licensed to use.', 'database'],
            ['Score', 'Fit & intent', 'A score with its reasons, never a bare number.', 'gauge'],
            ['Route', 'Right owner', 'Account executive, SDR or nurture by score, territory and capacity.', 'target'],
            ['Close loop', 'CRM outcome', 'Won and lost reasons retrain the model every quarter.', 'sync'],
        ],
        'hot'  => 2,
        'viz'  => ['Lead acceptance', 'Share of routed leads accepted by sales, scored vs unscored', ['M1', 'M2', 'M3', 'M4', 'M5', 'M6', 'M7'],
            [30, 38, 46, 52, 57, 60, 62], [29, 30, 28, 31, 30, 29, 30], 'Shape only. Acceptance is the sales team’s own call in the CRM, which keeps the score honest.'],
    ],
    'automated-dynamic-sales' => [
        'flow' => [
            ['Signal', 'Buyer activity', 'Pricing views, replies, product usage and meetings, on the CRM record.', 'radar'],
            ['Stage', 'Where they are', 'Stage definitions with exit criteria, not a rep’s guess.', 'flag'],
            ['Adapt', 'Next step', 'The sequence changes channel, timing and content to fit the signal.', 'sync'],
            ['Draft', 'Rep approves', 'Agents draft follow-ups and quotes; the rep edits and sends.', 'approve'],
            ['Forecast', 'Pipeline view', 'Deal risk and forecast from activity, with the reasons shown.', 'chart'],
        ],
        'hot'  => 2,
        'viz'  => ['Reply rate', 'Replies by week, adaptive sequence vs fixed cadence', ['Wk 1', 'Wk 2', 'Wk 3', 'Wk 4', 'Wk 5', 'Wk 6', 'Wk 7'],
            [20, 27, 34, 39, 43, 46, 48], [20, 22, 22, 23, 22, 23, 23], 'Shape only. Measured against a fixed cadence run on a comparable set of accounts.'],
    ],
    'customer-relationship-strategy' => [
        'flow' => [
            ['Map', 'Journeys', 'How customers actually move, across channels and into service.', 'compass'],
            ['Segment', 'Insight', 'Needs, value and churn risk, one definition for every team.', 'users'],
            ['Engage', 'Programmes', 'Always-on contact per segment, with pressure rules.', 'chat'],
            ['Reward', 'Loyalty', 'Mechanics modelled for margin and liability before launch.', 'handshake'],
            ['Run', 'Lifecycle', 'A calendar by stage, each with an owner and a holdout.', 'workflow'],
        ],
        'hot'  => -1,
        'viz'  => ['Cohort retention', 'Share of a cohort still active by month, with programme vs holdout', ['M1', 'M2', 'M3', 'M4', 'M5', 'M6', 'M7'],
            [96, 86, 78, 73, 70, 68, 67], [96, 80, 68, 60, 55, 51, 48], 'Shape only. Retention is read by cohort, month by month, against a holdout that received none of the programmes.'],
        'parts' => [
            ['journey-mapping', 'Practice 01 · Journey mapping', '<span class="g">Map the journey</span> customers actually take.',
                ['Moments of truth, drop-offs and recovery points, across channels and into service', 'Research and behavioural data reconciled on one map, per segment', 'Instrumentation so each step is measured, not remembered'],
                'Journey maps by segment'],
            ['segmentation', 'Practice 02 · Segmentation & insights', '<span class="g">One segment definition</span> every team uses.',
                ['Needs-based and behavioural segments, sized and named', 'Value tiers, propensity and churn models with model cards', 'Segments live in the CRM and the warehouse, not only in a deck'],
                'Segmentation model & definitions'],
            ['engagement', 'Practice 03 · Engagement programmes', '<span class="g">Always-on,</span> and never too often.',
                ['Onboarding, adoption, service moments, community and win-back', 'A contact strategy per segment, with channel and frequency rules', 'Pressure rules across the whole estate, not per team'],
                'Contact strategy & programme designs'],
            ['loyalty', 'Practice 04 · Loyalty strategy', '<span class="g">Loyalty that earns</span> its cost.',
                ['Earn and redeem mechanics, tiers, benefits and partners', 'Recognition, access and service levels weighed against discount', 'Margin, breakage and accounting liability modelled before launch'],
                'Loyalty design & economic model'],
            ['lifecycle', 'Practice 05 · Lifecycle marketing', '<span class="g">Every stage</span> has an owner.',
                ['A calendar of triggered and planned contact from first purchase to renewal', 'An owner, a measure and a holdout group per stage', 'A quarterly rhythm that keeps the five practices in step'],
                'Lifecycle calendar & retention dashboard'],
        ],
    ],
];
