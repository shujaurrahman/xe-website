<?php /* DRAFT COPY — review before launch */
/**
 * Product & Experience Design capability pages — page-level additions that data/product-experience.php does not hold
 * (that file is shared and not edited by the page template). Per capability:
 *   sig       [label for the hero button, window title, one-line caption under the mock]
 *   gates     4 gate questions, one after each process step (same order as data 'process' steps)
 *   measures  3 dumbbell rows, one per data 'outcomes' card: [measure, instrument, baseline, result, target, unit]
 *             Every figure is illustrative — an example of the measure agreed before work starts, never a client result.
 */
return [
    'design-consulting-solutioning' => [
        'sig'   => ['See the solution map', 'Solution map · Your company', 'Three routes to the same outcome, each traced from the capabilities it needs to the roadmap phases it fills.'],
        'gates' => ['Is this the right decision to make?', 'Are the routes drawn to the same depth?', 'Did users and engineers back the leader?', 'Can finance and engineering both sign it?'],
        'measures' => [
            ['Estimate spread, chosen route', 'Range width as % of midpoint, first sizing vs final', 60, 22, 25, '%'],
            ['Assumptions tested before the decision', 'Share of logged high-risk assumptions with evidence', 15, 82, 75, '%'],
            ['Design requests through intake', 'Share of work entering by the agreed route, week 12', 30, 88, 80, '%'],
        ],
    ],
    'product-strategy-vision' => [
        'sig'   => ['Score the opportunities', 'Opportunity map · Your platform', 'Six opportunities plotted by fit with the ambition and strength of evidence; change the ambition and the ranking moves.'],
        'gates' => ['Have we heard enough to map?', 'Is every opportunity sized and sourced?', 'Did the leading concepts hold up with customers?', 'Does every roadmap item trace to evidence?'],
        'measures' => [
            ['Roadmap items traced to evidence', 'Items linked to a sourced opportunity', 35, 92, 90, '%'],
            ['Leaders who state the same north star', 'Unprompted survey, before and after', 25, 84, 80, '%'],
            ['Bets with a sized cost and a test', 'Roadmap items with effort range and kill criterion', 10, 86, 80, '%'],
        ],
    ],
    'experience-design-development' => [
        'sig'   => ['Run the test round', 'Prototype test · Round 2 of 2', 'Six participants, four tasks, two rounds: the grid shows who completed each task unaided, with help, or not at all.'],
        'gates' => ['Do we know the benchmark to beat?', 'Did the prototype pass its test round?', 'Does the build meet the accessibility bar?', 'Did task success beat the benchmark?'],
        'measures' => [
            ['Task success, key journeys', 'Same tasks, unmoderated, benchmark vs release', 61, 89, 85, '%'],
            ['WCAG 2.2 AA criteria met', 'Automated checks plus manual keyboard and screen-reader pass', 68, 100, 100, '%'],
            ['Screens matching the approved design', 'Design QA against the Figma source', 55, 94, 90, '%'],
        ],
    ],
    'ai-product-strategy-development' => [
        'sig'   => ['Open the feature spec', 'AI feature spec · Draft reply assistant', 'One AI feature specified by the numbers it must meet: pick a model option and see which eval thresholds pass and which fallback carries the gap.'],
        'gates' => ['Is AI the right tool for this task?', 'Does the prototype clear the eval set?', 'Are guardrails and approvals in place?', 'Is it still used, and still correct?'],
        'measures' => [
            ['Active users in week 6', 'Product analytics cohort after the launch spike', 20, 46, 40, '%'],
            ['Low-confidence answers routed well', 'Fallback shown or handed to a person, from logs', 40, 95, 95, '%'],
            ['Risk controls in place at launch', 'Disclosure, oversight, logging and eval checks met', 30, 100, 100, '%'],
        ],
    ],
    'system-design' => [
        'sig'   => ['Trace a change', 'Component architecture · Your platform', 'The layers of a design system with every dependency drawn; pick a part and see what inherits a change to it.'],
        'gates' => ['Do we know what exists today?', 'Have product teams agreed the foundations?', 'Is every component documented and tested?', 'Are teams actually building with it?'],
        'measures' => [
            ['Screens built from system components', 'Code scan of component imports', 22, 84, 80, '%'],
            ['Fixes shipped once, inherited everywhere', 'Accessibility fixes made in a component, not a screen', 15, 90, 85, '%'],
            ['Product teams on the current version', 'Package versions across repositories', 20, 83, 75, '%'],
        ],
    ],
];
