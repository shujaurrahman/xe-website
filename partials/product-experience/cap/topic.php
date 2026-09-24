<?php /* DRAFT COPY — review before launch */
/**
 * Product & Experience Design capability pages — per-topic copy and the second showcase (polish pass).
 * data/product-experience.php is shared and not edited here, so everything topic-specific that the template used to
 * hard-code lives in this file. Per capability:
 *   img    [file in assets/imgs/product-experience/, alt text]  — offer photograph and "pairs well" card image
 *   h      section headings: key => [grey phrase, ink rest, lead] for deliv · out · stack · std · faq · next
 *   x      the second showcase (partials/product-experience/cap/showcase.php): kind 'matrix' or 'board'.
 *          Every figure is illustrative — an example of the artefact, never a client result.
 * '_apply' overrides the kit's generic "How we apply it" line with what the standard means in design work.
 */
return [
    '_apply' => [
        'wcag22'  => 'Contrast, focus order and target size checked in the design file, then keyboard and screen-reader passes on every key journey before sign-off.',
        'cwv'     => 'LCP, INP and CLS budgets written into the design spec per template, and checked at p75 in field data after release.',
        'iso9001' => 'Every stage ends at a written gate with an owner, and design QA against the approved source before anything is called done.',
        'gdpr'    => 'Research participants give recorded, specific consent; recordings and notes have a retention date and are deleted on it.',
        'dpdp'    => 'Consent notices for India-based participants and users, with data-principal requests answerable from the research log.',
    ],

    'design-consulting-solutioning' => [
        'img' => ['design-consulting-solutioning.jpg', 'Sticky notes sorted into columns on a whiteboard during a solutioning workshop'],
        'h' => [
            'deliv' => ['A decision you can defend.', 'And the files behind it.', 'The route you chose, the ones you did not and why: kept in your own workspace so the reasoning survives the people who made it.'],
            'out'   => ['Fewer surprises after the decision.', 'Three measures that show it.', 'Consulting succeeds when the estimate holds, the risky assumptions were tested first and design requests stop arriving sideways.'],
            'stack' => ['Workshops, maps and estimates.', 'In the tools you already run.', 'We map, estimate and record decisions where your product and engineering teams already work, most used first.'],
            'std'   => ['Every route is costed against the same bar.', 'Accessibility and privacy included.', 'Frameworks each route is scored against before it is recommended. They are frameworks we build to, not certifications we hold.'],
            'faq'   => ['Asked before', 'we compare the routes.'],
            'next'  => ['A decision is where the work starts.', 'These carry it forward.', 'Strategy sharpens what the chosen route is for; System Design gives it parts that last.'],
        ],
        'x' => [
            'kind' => 'matrix', 'lbl' => 'Route comparison', 'h' => ['Three routes,', 'scored on the same five questions.'],
            'lead' => 'The artefact the steering group signs: each route drawn to the same depth, so the choice is between options, not between a favourite and two straw men.',
            'win'  => 'Route comparison · Your company · v4', 'aria' => 'Route comparison table, scrolls sideways',
            'cols' => ['Question', 'A · Extend the current portal', 'B · New self-serve app', 'C · Buy and configure'],
            'rows' => [
                ['Time to first release', ['10–12 weeks', 'ok'], ['16–20 weeks', 'warn'], ['8–10 weeks', 'ok']],
                ['Three-year cost range', ['Medium', 'ok'], ['High', 'warn'], ['Medium, rising with seats', 'warn']],
                ['Covers the top five user needs', ['3 of 5', 'bad'], ['5 of 5', 'ok'], ['4 of 5', 'ok']],
                ['Riskiest assumption', ['Legacy API holds load', 'warn'], ['Team can hire two engineers', 'warn'], ['Vendor roadmap fits', 'bad']],
                ['Reversible if wrong', ['Yes', 'ok'], ['Partly', 'warn'], ['Costly', 'bad']],
            ],
            'hl' => 2, 'tag' => 'Recommended: B, with A as a 10-week bridge',
            'note' => 'Illustrative example of the comparison we produce. Estimates are ranges agreed with your engineers, not quotes.',
        ],
    ],

    'product-strategy-vision' => [
        'img' => ['product-strategy-vision.jpg', 'Hands sorting a long list of sticky notes on a table during a strategy session'],
        'h' => [
            'deliv' => ['A strategy that fits on one page.', 'With the evidence under it.', 'The north star, the bets and the roadmap, each traced to the research that justified it and kept where your teams plan.'],
            'out'   => ['A roadmap people can explain.', 'Three measures that prove it.', 'Strategy works when leaders say the same thing unprompted and every item on the roadmap can point to its reason.'],
            'stack' => ['Evidence in, roadmap out.', 'Analytics and planning tools you own.', 'The research, analytics and planning tools we use to size opportunities and hand the roadmap to delivery.'],
            'std'   => ['Ambition checked against obligation.', 'Before it reaches the roadmap.', 'Frameworks each bet is checked against while it is still cheap to change. Frameworks we build to, not certifications we hold.'],
            'faq'   => ['Asked before', 'the vision workshop.'],
            'next'  => ['A strategy needs somewhere to land.', 'These turn it into product.', 'Consulting settles how to build it; Experience Design turns the first bet into something people can test.'],
        ],
        'x' => [
            'kind' => 'board', 'lbl' => 'Assumption tracker', 'h' => ['Every bet rests on assumptions.', 'We track each one to a verdict.'],
            'lead' => 'The board the strategy is steered by: each assumption behind a bet, the test that settles it and where it stands today.',
            'win'  => 'Assumption tracker · Your platform · week 5',
            'cols' => [
                ['Untested', 'na', [['Teams will switch from spreadsheets if import takes under a minute', 'Bet 2 · Desirability', 'Test: fake-door import, week 6']]],
                ['Testing', 'warn', [['Finance leads, not IT, choose this tool', 'Bet 1 · Buyer', '6 of 12 interviews done'], ['Usage-based pricing is acceptable below 50 seats', 'Bet 3 · Viability', 'Price test live, n = 214']]],
                ['Held', 'ok', [['Month-end close is the moment of pain', 'Bet 1 · Problem', '11 of 12 interviews, 3 data sources']]],
                ['Broken', 'bad', [['A mobile app is needed at launch', 'Bet 4 · Scope', '2% of sessions on mobile · bet dropped']]],
            ],
            'note' => 'Illustrative example. A broken assumption is a result: it removed a bet before anything was built for it.',
        ],
    ],

    'experience-design-development' => [
        'img' => ['experience-design-development.jpg', 'A person entering details into a form on a phone'],
        'h' => [
            'deliv' => ['Designed, built and tested.', 'Handed over as working code.', 'Journeys, the prototype that proved them and the production front end, with the test evidence attached.'],
            'out'   => ['People finish what they came to do.', 'Three measures that show it.', 'The same tasks are timed before and after release, so the improvement is measured, not described.'],
            'stack' => ['From Figma to production.', 'One component set the whole way.', 'Design, prototyping, front-end and testing tools we use most for experience work, in your repositories.'],
            'std'   => ['Accessible and fast by default.', 'Checked in the build, not after it.', 'Frameworks every journey is built and tested to. Frameworks we build to, not certifications we hold.'],
            'faq'   => ['Asked before', 'the first test round.'],
            'next'  => ['A good screen should not stay one of a kind.', 'These make it repeatable.', 'System Design turns the parts into a library; Strategy decides which journey to improve next.'],
        ],
        'x' => [
            'kind' => 'board', 'lbl' => 'Usability findings', 'h' => ['Every finding has a severity,', 'an owner and a fix.'],
            'lead' => 'What a test round produces: each problem seen, how many participants hit it and whether the fix held when we tested again.',
            'win'  => 'Findings board · Checkout · round 2 of 2',
            'cols' => [
                ['Critical', 'bad', [['Delivery date hidden below the fold on small phones', 'Task 2 · 4 of 6 missed it', 'Owner: design · fixing']]],
                ['Serious', 'warn', [['Promo code field read as required', 'Task 3 · 3 of 6 paused', 'Owner: content'], ['Error on card number clears the whole form', 'Task 4 · 2 of 6', 'Owner: front end']]],
                ['Minor', 'na', [['“Continue” and “Next” used for the same action', 'All tasks · noted', 'Owner: content']]],
                ['Fixed and retested', 'ok', [['Address lookup ignored flat numbers', 'Round 1: 5 of 6 failed', 'Round 2: 6 of 6 passed']]],
            ],
            'note' => 'Illustrative example of a findings board. Participant counts are per task in a six-person moderated round.',
        ],
    ],

    'ai-product-strategy-development' => [
        'img' => ['ai-product-strategy-development.jpg', 'Two people reviewing a product demo on a laptop'],
        'h' => [
            'deliv' => ['An AI feature with its numbers attached.', 'Spec, evals and guardrails.', 'Everything needed to ship the feature and keep it honest: the spec, the eval set it must pass and the fallback when it cannot.'],
            'out'   => ['Used, trusted and within its limits.', 'Three measures that prove it.', 'AI features earn their place when people keep using them, low-confidence answers are caught and the controls exist on day one.'],
            'stack' => ['Model-agnostic by design.', 'Chosen per task, swappable later.', 'Model providers, orchestration and product tools we use for AI features. Your accounts, your keys.'],
            'std'   => ['Risk classified before the first prompt.', 'Oversight designed in.', 'Frameworks every AI feature is classified, tested and documented against. Frameworks we build to, not certifications we hold.'],
            'faq'   => ['Asked before', 'we pick a model.'],
            'next'  => ['An AI feature is still a product.', 'These make it one people use.', 'Experience Design makes the interaction clear; Strategy decides where AI is worth it at all.'],
        ],
        'x' => [
            'kind' => 'matrix', 'lbl' => 'Eval scorecard', 'h' => ['A feature ships when the evals pass.', 'Not when the demo looks good.'],
            'lead' => 'The scorecard each release is held to: the threshold agreed with you, how each model option scores on your own test set and what carries the gap.',
            'win'  => 'Eval scorecard · Draft reply assistant · 420 test cases', 'aria' => 'Eval scorecard table, scrolls sideways',
            'cols' => ['Check', 'Threshold', 'Option A · large model', 'Option B · small model + retrieval', 'Fallback'],
            'rows' => [
                ['Answer grounded in the help centre', '≥ 95%', ['97.1%', 'ok'], ['95.4%', 'ok'], 'Cite or decline'],
                ['Declines out-of-scope requests', '≥ 98%', ['98.6%', 'ok'], ['96.2%', 'bad'], 'Route to a person'],
                ['Prompt-injection suite (OWASP LLM01)', '0 passes through', ['0 of 60', 'ok'], ['1 of 60', 'bad'], 'Block and log'],
                ['Personal data in output', '0 cases', ['0', 'ok'], ['0', 'ok'], 'Redact'],
                ['Latency, p95', '≤ 2.5 s', ['3.1 s', 'warn'], ['1.4 s', 'ok'], 'Stream the draft'],
            ],
            'hl' => 2, 'tag' => 'Ship A with streaming; retest B after tuning',
            'note' => 'Illustrative example of an eval scorecard. Thresholds are set per feature with you before any model is compared.',
        ],
    ],

    'system-design' => [
        'img' => ['system-design.jpg', 'Two monitors showing source code on a desk at night'],
        'h' => [
            'deliv' => ['A system your teams can build with.', 'Tokens to documentation.', 'Tokens, components, patterns and the guidance around them, versioned and published from your own repositories.'],
            'out'   => ['Fix it once, see it everywhere.', 'Three measures that prove it.', 'A design system pays back when screens are built from it, fixes are inherited and teams stay on the current version.'],
            'stack' => ['Figma variables to shipped packages.', 'One source, every platform.', 'Design, component, testing and release tools a system runs on, from the design file to the package registry.'],
            'std'   => ['Built into the component.', 'So every screen inherits it.', 'Frameworks every component is built and tested to, so compliance comes with the import. Frameworks we build to, not certifications we hold.'],
            'faq'   => ['Asked before', 'the audit starts.'],
            'next'  => ['A system is only as good as what uses it.', 'These put it to work.', 'Experience Design builds journeys from the library; Consulting decides where to adopt it first.'],
        ],
        'x' => [
            'kind' => 'matrix', 'lbl' => 'Change impact', 'h' => ['Change one token.', 'See every component it reaches.'],
            'lead' => 'What a release note looks like when the system is wired properly: each token change, the components that inherit it and the visual-regression result before it merges.',
            'win'  => 'Release 3.4.0 · token diff · Your platform', 'aria' => 'Token change impact table, scrolls sideways',
            'cols' => ['Token change', 'Button', 'Input', 'Card', 'Dialog', 'Visual diff'],
            'rows' => [
                ['color.action.primary · contrast 4.1 → 4.8', ['Inherits', 'ok'], ['Inherits', 'ok'], '—', ['Inherits', 'ok'], ['38 snapshots · approved', 'ok']],
                ['radius.control · 6 → 8 px', ['Inherits', 'ok'], ['Inherits', 'ok'], '—', '—', ['24 snapshots · approved', 'ok']],
                ['space.stack.md · 16 → 20 px', '—', ['Inherits', 'ok'], ['Inherits', 'ok'], ['Override', 'warn'], ['1 unexpected · Dialog', 'bad']],
                ['focus.ring.width · 2 → 3 px', ['Inherits', 'ok'], ['Inherits', 'ok'], ['Inherits', 'ok'], ['Inherits', 'ok'], ['52 snapshots · approved', 'ok']],
            ],
            'tag' => 'Blocked: remove the Dialog override, then merge',
            'note' => 'Illustrative example. An override that breaks inheritance is exactly what the diff is there to catch.',
        ],
    ],
];
