<?php
/**
 * ==========================================================================
 * THE WORK ARCHIVE — every case study on /work comes from this one file.
 * ==========================================================================
 *
 * DRAFT CONTENT — the four entries in 'cases' below are PLACEHOLDERS. They
 * describe the *shape* of a case study so the page looks finished; none of
 * them is a real Xterra Edze project, none names a client, and none carries a
 * measured result. Replace or delete every entry marked 'placeholder' => true
 * before launch.
 *
 * --------------------------------------------------------------------------
 * HOW TO ADD A REAL CASE STUDY (no coding needed beyond careful typing)
 * --------------------------------------------------------------------------
 * 1. Copy one whole entry from 'cases' — from its opening [ to its closing ],
 *    including the comma at the end.
 * 2. Paste it at the TOP of the 'cases' list. Newest work reads first.
 * 3. Change every value between the quote marks to the real ones.
 * 4. Set 'placeholder' => false. That is what removes the "Placeholder" mark
 *    from the card and lets the entry count as real work.
 * 5. Save the file and reload /work. Nothing else needs editing: the filters,
 *    the counts and the sector list all rebuild themselves from this file.
 *
 * Rules to keep the page honest and safe:
 *   • Do not name a client until they have agreed in writing. Leave 'client'
 *     empty ('') and the page attributes the work to the sector instead
 *     ("Consumer health · nine markets"), which is how the placeholders read.
 *   • Do not write an outcome number you cannot evidence. 'outcome' asks for
 *     the measure, the baseline and who verified it, on purpose. If you have
 *     no verified figure, describe what changed in words and leave
 *     'measure' => ''.
 *   • Do not use a stock photograph as if it were the project. Leave 'images'
 *     empty and the card draws its own placeholder plate in code.
 *   • A quote needs the speaker's written approval. Until then leave 'quote'
 *     empty; 'role' and 'org' without a personal name is the safer form.
 *
 * --------------------------------------------------------------------------
 * EVERY FIELD, IN ORDER
 * --------------------------------------------------------------------------
 * slug          Short url-safe id, lowercase with hyphens. Must be unique in
 *               this file. Used as the anchor for the entry (/work#c-<slug>).
 * placeholder   true while the entry is illustrative. true adds a visible
 *               "Placeholder" mark and keeps the entry out of the real count.
 * client        The client's name, exactly as they write it — or '' when they
 *               may not be named. '' is not a problem: see 'sector'.
 * sector        The industry, in plain words. Must be one of the keys in
 *               'industries' below (that list drives the industry filter).
 * scope         The reach of the work, for the attribution line:
 *               "nine markets", "two brands, one platform", "India and UAE".
 * title         One line saying what the work was. Sentence case, no full
 *               stop. This is the card heading.
 * problem       One to three sentences: the situation before we started.
 * did           A list of what we actually did. Three to six items, each one
 *               short. These are the moves, not the deliverables.
 * outputs       What the client received. Three to six items.
 * disciplines   Which of our six disciplines worked on it. Use the slugs from
 *               data/site.php: brand-design, technology-intelligence,
 *               campaign-content, ai-design, product-experience,
 *               marketing-technology. This drives the discipline filter.
 * engagement    How it was bought. One of the keys in data/services/
 *               packages.php: sprint, project, milestone, retainer,
 *               enterprise, squad. Leave '' if it does not fit one.
 * dates         ['start' => 'Month YYYY', 'end' => 'Month YYYY' (or 'Ongoing'),
 *                'duration' => 'five months']
 * outcome       ['claim'    => what changed, in one sentence,
 *                'measure'  => the figure, or '' when there is none yet,
 *                'baseline' => what the figure is measured against,
 *                'window'   => the period it was measured over,
 *                'verified' => who confirmed it (the client's own analytics,
 *                              an independent auditor, our instrumentation)]
 *               A 'measure' with no 'baseline' and no 'verified' must not be
 *               published. The page prints all four together or none.
 * quote         ['text' => …, 'name' => … (or ''), 'role' => …, 'org' => …]
 *               or [] for none.
 * images        A list of ['src' => 'assets/imgs/work/<file>', 'alt' => …,
 *                'w' => 1600, 'h' => 1000, 'caption' => …].
 *               The first image is the card image. [] draws a code plate.
 * confidential  true when the client may not be named at all. Adds the
 *               "Named under NDA" mark and suppresses 'client' even if set.
 *
 * Every string is escaped on output. Do not put HTML tags in these values.
 * ==========================================================================
 */

return [

    /* ---------------------------------------------------------------- *
     * The industry filter. Key => label. A case's 'sector' must match a
     * key here. Add a sector by adding a line; the filter follows.
     * ---------------------------------------------------------------- */
    'industries' => [
        'consumer-health'    => 'Consumer health',
        'financial-services' => 'Financial services',
        'retail-commerce'    => 'Retail & commerce',
        'b2b-technology'     => 'B2B technology',
        'hospitality'        => 'Hospitality',
        'telecom-media'      => 'Telecom & media',
        'manufacturing'      => 'Manufacturing',
        'public-education'   => 'Public sector & education',
    ],

    /* ---------------------------------------------------------------- *
     * The record, explained on the page itself (the "Anatomy" section
     * reads this list). Key => [label, what it answers, who supplies it].
     * ---------------------------------------------------------------- */
    'fields' => [
        ['Attribution', 'Who the work was for, or the sector when the client may not be named.', 'Client, in writing'],
        ['The problem', 'What was true before we started, in the client\'s own terms.', 'Written with the client'],
        ['What we did', 'The moves we made, not the deliverables handed over.', 'Programme lead'],
        ['Disciplines', 'Which of the six disciplines worked on it, and in what order.', 'Programme lead'],
        ['Outputs', 'What the client received and now owns.', 'Handover pack'],
        ['Outcome', 'What changed, with the baseline, the window and who verified it.', 'Client\'s own analytics'],
        ['Dates', 'When it ran and how long it took.', 'Delivery record'],
        ['Words from the client', 'A quote, with written approval to publish it.', 'Client, in writing'],
    ],

    /* ================================================================ *
     * <!-- PLACEHOLDER: replace with real case studies before launch -->
     * Four illustrative records. Not real projects. No real clients.
     * No measured results. Each one is marked on the page.
     * ================================================================ */
    'cases' => [

        [
            'slug'         => 'one-brand-system-nine-markets',
            'placeholder'  => true,
            'client'       => '',
            'sector'       => 'consumer-health',
            'scope'        => 'nine markets',
            'title'        => 'One brand system, rebuilt so every market ships from the same rules',
            'problem'      => 'Nine country teams had drifted into nine brands. Pack design, claims language and campaign artwork were being rebuilt locally every quarter, and legal review had become the bottleneck for every launch.',
            'did'          => [
                'Audited what each market had actually shipped over two years, not what the guidelines said',
                'Rewrote the identity as a system with a fixed core and a defined flex',
                'Put the claims library and the approved substantiation in one place',
                'Built a market kit that generates artwork from the system instead of copying files',
            ],
            'outputs'      => [
                'Brand system with a fixed core and market flex, as files and as code',
                'Claims library with substantiation attached to each claim',
                'A market artwork kit and the training to run it',
                'Governance model naming who decides what, in which market',
            ],
            'disciplines'  => ['brand-design', 'campaign-content', 'marketing-technology'],
            'engagement'   => 'milestone',
            'dates'        => ['start' => 'Month YYYY', 'end' => 'Month YYYY', 'duration' => 'about five months'],
            'outcome'      => [
                'claim'    => 'Market teams produce launch artwork from the system instead of rebuilding it, and legal reviews claims once rather than nine times.',
                'measure'  => '',
                'baseline' => 'To be measured against the two years of shipped work captured in the audit.',
                'window'   => 'First two quarters after handover.',
                'verified' => 'Client\'s own review cycle records.',
            ],
            'quote'        => [],
            'images'       => [],
            'confidential' => true,
        ],

        [
            'slug'         => 'crm-rebuilt-around-the-journey',
            'placeholder'  => true,
            'client'       => '',
            'sector'       => 'financial-services',
            'scope'        => 'one market, four product lines',
            'title'        => 'A CRM rebuilt around the journey, so every message knows what happened last',
            'problem'      => 'Four product lines each ran their own campaigns from their own lists. A customer who had just been declined for one product was being sold it again the following week, and nobody could see the whole conversation.',
            'did'          => [
                'Mapped the real journey from the event data, not from the org chart',
                'Consolidated the four lists into one consented customer record',
                'Rebuilt lifecycle programmes as journeys triggered by events',
                'Put suppression, frequency and consent rules in one enforceable place',
            ],
            'outputs'      => [
                'One customer record with consent and purpose recorded per field',
                'Event-triggered lifecycle journeys for the four product lines',
                'A suppression and frequency policy enforced in the platform',
                'Reporting the product owners read without asking for an extract',
            ],
            'disciplines'  => ['marketing-technology', 'technology-intelligence', 'product-experience'],
            'engagement'   => 'project',
            'dates'        => ['start' => 'Month YYYY', 'end' => 'Month YYYY', 'duration' => 'about three months'],
            'outcome'      => [
                'claim'    => 'Contradictory messages across product lines stop, because one rule set decides what may be sent and when.',
                'measure'  => '',
                'baseline' => 'To be measured against the send and complaint logs from the twelve months before migration.',
                'window'   => 'First quarter after cutover.',
                'verified' => 'Client\'s own platform reporting.',
            ],
            'quote'        => [],
            'images'       => [],
            'confidential' => true,
        ],

        [
            'slug'         => 'assistant-that-answers-what-sales-repeated',
            'placeholder'  => true,
            'client'       => '',
            'sector'       => 'b2b-technology',
            'scope'        => 'one product, two regions',
            'title'        => 'A product experience and an assistant that answers what sales kept repeating',
            'problem'      => 'Sales engineers were answering the same forty questions in every evaluation, and the answers lived in their heads. Trials stalled at the point where a prospect needed a straight technical answer out of hours.',
            'did'          => [
                'Took the forty questions from real call recordings and support tickets',
                'Built a retrieval assistant grounded only in the approved documentation',
                'Wrote a golden set from real questions and gated every release on it',
                'Designed the hand-off so a person takes over the moment confidence drops',
            ],
            'outputs'      => [
                'In-product assistant with citations back to the source page',
                'Golden set of evaluation cases, owned by the client',
                'Guardrail policy covering claims, pricing and competitor questions',
                'Runbook and the on-call rota to go with it',
            ],
            'disciplines'  => ['product-experience', 'ai-design', 'technology-intelligence'],
            'engagement'   => 'sprint',
            'dates'        => ['start' => 'Month YYYY', 'end' => 'Month YYYY', 'duration' => 'about six weeks'],
            'outcome'      => [
                'claim'    => 'Technical questions get an answer with a citation at any hour, and the assistant hands over to a person rather than guessing.',
                'measure'  => '',
                'baseline' => 'To be measured against the answer times recorded in the support queue before launch.',
                'window'   => 'First 90 days after release.',
                'verified' => 'Client\'s own support and product analytics.',
            ],
            'quote'        => [],
            'images'       => [],
            'confidential' => true,
        ],

        [
            'slug'         => 'storefront-that-holds-on-sale-day',
            'placeholder'  => true,
            'client'       => '',
            'sector'       => 'retail-commerce',
            'scope'        => 'India and UAE',
            'title'        => 'A storefront rebuilt to hold its speed on a sale day',
            'problem'      => 'Product and checkout pages were fast in the lab and slow on the mid-range Android phones most customers actually used. Sale-day traffic multiplied the problem, and nobody could say which change had caused which drop.',
            'did'          => [
                'Started from field data at the 75th percentile, not lab scores',
                'Rebuilt the product and checkout templates against a performance budget',
                'Put the budget in the pipeline so a regression fails the build',
                'Load-tested at the expected sale-day peak before the sale, not after',
            ],
            'outputs'      => [
                'Rebuilt product and checkout templates',
                'A performance budget enforced in continuous integration',
                'A load-test report at the expected peak',
                'A dashboard the merchandising team reads without help',
            ],
            'disciplines'  => ['technology-intelligence', 'product-experience', 'campaign-content'],
            'engagement'   => 'project',
            'dates'        => ['start' => 'Month YYYY', 'end' => 'Month YYYY', 'duration' => 'about ten weeks'],
            'outcome'      => [
                'claim'    => 'Core Web Vitals sit in the good range on field data, and a regression now fails the build instead of reaching a sale day.',
                'measure'  => '',
                'baseline' => 'To be measured against the field data captured in the four weeks before the rebuild.',
                'window'   => 'The 28-day field window either side of the sale.',
                'verified' => 'Client\'s own field data, at the 75th percentile.',
            ],
            'quote'        => [],
            'images'       => [],
            'confidential' => true,
        ],

    ],
];
