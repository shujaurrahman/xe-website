<?php
/**
 * Product & Experience Design — the service catalogue.
 *
 * DRAFT COPY — review before launch.
 *
 * What a visitor can actually buy on the discipline hub and on each of the five capability pages,
 * grouped into categories and offered in engagement packages. One shared component renders this
 * data identically on every page. Clicking a service opens the contact page with it pre-selected,
 * so every enquiry arrives tagged.
 *
 * Shape
 *   '<page-key>' => [
 *     'discipline' => 'product-experience',
 *     'title'      => heading HTML: <span class="g">grey first phrase.</span> ink rest
 *     'lead'       => intro paragraph
 *     'categories' => [[
 *         'key', 'name', 'icon' (an svc_icon name, partials/services/lib.php; unknown names fall
 *                                back to xt_icon, partials/tech/kit.php),
 *         'offers' => [[
 *             'key'       offer key, unique within the page
 *             'name'      service name
 *             'desc'      one or two plain-English sentences
 *             'includes'  3–5 concrete inclusions
 *             'tags'      short labels
 *             'stack'     technology slugs from data/tech-stack.php (empty for advisory work)
 *             'time'      typical timeline (PLACEHOLDER until confirmed)
 *             'best'      who it suits
 *         ]],
 *     ]],
 *     'packages'   => keys from data/services/packages.php that apply, in display order
 *   ]
 *
 * Page keys: 'product-experience' (the hub), then the five capability slugs in site order.
 * Service id, the tag the contact page receives: '<page-key>:<offer-key>'.
 * Hub offers also carry 'cap': the capability slug the service belongs to.
 *
 * Packages: sprint (1–3 week fixed-scope sprint), project (fixed scope, fixed price), milestone
 * (gated, separately paid phases), retainer (monthly capacity with service levels), enterprise
 * (multi-workstream programme with governance), squad (dedicated team, time & materials).
 *
 * Truthfulness: no prices, client names, results, certifications or partner tiers. Technologies
 * are ones we work with, never partnerships. WCAG 2.2 AA conformance is a statement made about a
 * product, not a certificate anyone issues, and accessibility work is audit and remediation, not
 * legal advice. Every 'time' is typical, not promised, and is marked PLACEHOLDER until confirmed.
 *
 * Voice: plain English first, technically correct second. Calm, short, active. No exclamation marks.
 */

return [

    /* =============================================================================================
       Hub — the services people most often start with, across all five capabilities
       ============================================================================================= */
    'product-experience' => [
        'discipline' => 'product-experience',
        'title'      => '<span class="g">Start with one question.</span> Grow into the product.',
        'lead'       => 'These are the services teams most often start with, across all five product and experience capabilities. Choose one and your enquiry reaches the right team with it already attached. Each can be bought as a short sprint, a fixed-scope project or ongoing capacity.',
        'categories' => [

            ['key' => 'assess', 'name' => 'Assess & advise', 'icon' => 'compass', 'offers' => [
                [
                    'key'      => 'experience-audit',
                    'cap'      => 'design-consulting-solutioning',
                    'name'     => 'Product experience audit',
                    'desc'     => 'An independent read on your live product: where people get stuck, what the analytics already show and which fixes are worth doing first.',
                    'includes' => ['Expert review of the key journeys', 'Analytics and support-ticket read', 'Accessibility and performance spot checks', 'Ranked backlog with effort and impact'],
                    'tags'     => ['Diagnostic', 'Ranked backlog'],
                    'stack'    => ['figma', 'lighthouse', 'googleanalytics', 'posthog'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams who can see the product underperforming but not where.',
                ],
                [
                    'key'      => 'solution-shaping',
                    'cap'      => 'design-consulting-solutioning',
                    'name'     => 'Solution shaping & options',
                    'desc'     => 'Two or three ways to reach the same outcome, each drawn as a journey and a system sketch and sized with engineers, so the comparison is honest.',
                    'includes' => ['Current-state journey and system map', 'Two or three routes at equal depth', 'Effort, cost and risk range for each', 'A recommendation with the rejected options recorded'],
                    'tags'     => ['Options', 'Decision-ready'],
                    'stack'    => ['figma', 'miro'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams about to commit budget to a large build.',
                ],
                [
                    'key'      => 'design-sprint',
                    'cap'      => 'design-consulting-solutioning',
                    'name'     => 'Design sprint',
                    'desc'     => 'One or two weeks to take a vague ambition to a prototype that real customers have used, before a team is assigned to build anything.',
                    'includes' => ['Framing session with the decision makers', 'Concept work and a clickable prototype', 'Five to eight customer sessions', 'A go, adjust or stop recommendation'],
                    'tags'     => ['1–2 weeks', 'Tested with users'],
                    'stack'    => ['figma', 'miro'],
                    'time'     => '1–2 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams stuck between competing ideas and short of evidence.',
                ],
                [
                    'key'      => 'accessibility-audit',
                    'cap'      => 'design-consulting-solutioning',
                    'name'     => 'Accessibility audit (WCAG 2.2 AA)',
                    'desc'     => 'Your website or app tested against WCAG 2.2 AA by automated tools and by hand, with the failures explained and ordered by how much they block people.',
                    'includes' => ['Automated scan across key templates', 'Manual keyboard and screen-reader passes', 'Findings mapped to WCAG 2.2 success criteria', 'Prioritised fix backlog and retest'],
                    'tags'     => ['WCAG 2.2 AA', 'Manual testing'],
                    'stack'    => ['lighthouse', 'playwright'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations with a procurement, tender or policy requirement to meet.',
                ],
            ]],

            ['key' => 'strategy', 'name' => 'Strategy & vision', 'icon' => 'target', 'offers' => [
                [
                    'key'      => 'product-discovery',
                    'cap'      => 'product-strategy-vision',
                    'name'     => 'Product discovery',
                    'desc'     => 'Research with your customers and your own data to find what is actually worth building next, before a roadmap is written around it.',
                    'includes' => ['Customer and lost-customer interviews', 'Analytics, support and sales data read together', 'Opportunity map with sizing', 'Shortlist of bets with evidence attached'],
                    'tags'     => ['Research-led', 'Opportunity map'],
                    'stack'    => ['miro', 'notion', 'posthog', 'mixpanel'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product teams with more ideas than evidence.',
                ],
                [
                    'key'      => 'product-vision',
                    'cap'      => 'product-strategy-vision',
                    'name'     => 'Product vision & north star',
                    'desc'     => 'One clear statement of where the product is going, with the single metric that says whether it is working and the inputs a team can move.',
                    'includes' => ['Vision on one page', 'North star metric and its input tree', 'Alignment sessions with leadership', 'Narrative for the board and the team'],
                    'tags'     => ['Vision', 'North star metric'],
                    'stack'    => ['figma', 'notion'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products where every team has a slightly different idea of the goal.',
                ],
                [
                    'key'      => 'roadmap-sequencing',
                    'cap'      => 'product-strategy-vision',
                    'name'     => 'Roadmap & sequencing',
                    'desc'     => 'Now, next and later, ordered by evidence and dependency, with the assumption behind each bet written down so it can be tested.',
                    'includes' => ['Scored and sequenced opportunities', 'Dependencies and capability gaps', 'Measures and owners per item', 'Assumption and experiment backlog'],
                    'tags'     => ['Now · next · later', 'Owners & measures'],
                    'stack'    => ['jira', 'linear', 'notion'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose roadmap is a wish list rather than a plan.',
                ],
                [
                    'key'      => 'vision-prototype',
                    'cap'      => 'product-strategy-vision',
                    'name'     => 'Vision prototype',
                    'desc'     => 'A convincing prototype or short film of the product two years out, used to align a leadership team and to test the idea with customers and investors.',
                    'includes' => ['Concept development with your leadership', 'High-fidelity prototype or film', 'Customer reaction sessions', 'Narrative and presentation pack'],
                    'tags'     => ['Concept', 'Alignment'],
                    'stack'    => ['figma', 'react'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams raising money, realigning a portfolio or entering a new category.',
                ],
            ]],

            ['key' => 'design', 'name' => 'Design & research', 'icon' => 'layout', 'offers' => [
                [
                    'key'      => 'ux-ui-design',
                    'cap'      => 'experience-design-development',
                    'name'     => 'End-to-end UX & UI design',
                    'desc'     => 'The full design of a product or a major journey: structure, screens, content and every state, tested with users as it is drawn.',
                    'includes' => ['Information architecture and journeys', 'Interface design with empty, loading and error states', 'UX writing for labels, guidance and errors', 'Testing rounds through the project', 'Developer handover with acceptance criteria'],
                    'tags'     => ['UX · UI', 'Tested', 'Handover-ready'],
                    'stack'    => ['figma', 'miro', 'storybook'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams building a new product or rebuilding a journey that is failing.',
                ],
                [
                    'key'      => 'app-redesign',
                    'cap'      => 'experience-design-development',
                    'name'     => 'Product or app redesign',
                    'desc'     => 'A redesign of an existing product, planned so it can ship in stages behind flags rather than as one risky replacement.',
                    'includes' => ['Baseline usability benchmark', 'Journey-by-journey redesign plan', 'Designs and prototypes per stage', 'Migration and rollout plan', 'Benchmark repeated after release'],
                    'tags'     => ['Staged rollout', 'Benchmarked'],
                    'stack'    => ['figma', 'posthog', 'playwright'],
                    'time'     => '10–20 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products that have grown past their original design.',
                ],
                [
                    'key'      => 'user-research',
                    'cap'      => 'experience-design-development',
                    'name'     => 'User research & usability testing',
                    'desc'     => 'Sessions with the people who use your product, run properly and written up so the findings settle arguments instead of starting them.',
                    'includes' => ['Research plan tied to open decisions', 'Recruitment and incentives handled', 'Moderated or unmoderated sessions', 'Findings, clips and a prioritised list of fixes'],
                    'tags'     => ['Moderated', 'Unmoderated', 'Clips'],
                    'stack'    => ['figma', 'notion'],
                    'time'     => '2–5 weeks per round',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams making a decision that nobody can settle from the data alone.',
                ],
                [
                    'key'      => 'frontend-build',
                    'cap'      => 'experience-design-development',
                    'name'     => 'Front-end build',
                    'desc'     => 'The designed experience built as accessible, fast front-end code in your repositories, with the checks that keep it that way.',
                    'includes' => ['Component-based front end in React and TypeScript', 'Accessibility and visual regression tests in CI', 'Core Web Vitals budgets enforced on merge', 'Design QA pass before release'],
                    'tags'     => ['React', 'WCAG 2.2 AA', 'Core Web Vitals'],
                    'stack'    => ['react', 'nextdotjs', 'typescript', 'tailwindcss', 'playwright'],
                    'time'     => '6–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with designs ready and no front-end capacity to build them well.',
                ],
                [
                    'key'      => 'content-design',
                    'cap'      => 'experience-design-development',
                    'name'     => 'UX writing & content design',
                    'desc'     => 'The words inside the product rewritten with the design: labels, guidance, empty states, errors and confirmations that people understand the first time.',
                    'includes' => ['Content audit of the key journeys', 'Rewritten interface copy in the designs', 'Error and edge-case message set', 'Content guidelines for the team'],
                    'tags'     => ['Microcopy', 'Guidelines'],
                    'stack'    => ['figma', 'notion'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products where support keeps answering the same question.',
                ],
            ]],

            ['key' => 'ai', 'name' => 'AI in the product', 'icon' => 'sparkle', 'offers' => [
                [
                    'key'      => 'ai-opportunity',
                    'cap'      => 'ai-product-strategy-development',
                    'name'     => 'AI opportunity mapping',
                    'desc'     => 'Where AI genuinely helps in your product and where it would only add friction, judged against the journey rather than against a list of features.',
                    'includes' => ['Journey read for AI moments', 'Value, feasibility and risk score per idea', 'Data and content readiness check', 'Shortlist with a first use case to prototype'],
                    'tags'     => ['Journey-led', 'Scored'],
                    'stack'    => ['miro', 'figma'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product teams under pressure to add AI without a clear reason yet.',
                ],
                [
                    'key'      => 'ai-prototype',
                    'cap'      => 'ai-product-strategy-development',
                    'name'     => 'AI prototype on live models',
                    'desc'     => 'A working prototype wired to real models and your own content, so the idea is judged on what the model actually returns, not on a scripted demo.',
                    'includes' => ['Interaction patterns designed for the task', 'Prototype on live models and real content', 'Sessions with the people who would use it', 'Findings, costs and a build or stop recommendation'],
                    'tags'     => ['Live models', 'Tested with users'],
                    'stack'    => ['anthropic', 'openai', 'react', 'nextdotjs', 'typescript'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams deciding whether an AI feature is worth a quarter of engineering.',
                ],
                [
                    'key'      => 'ai-feature-build',
                    'cap'      => 'ai-product-strategy-development',
                    'name'     => 'AI feature design & build',
                    'desc'     => 'An AI feature designed and shipped inside your product, with disclosure, sources, an undo and a person approving anything consequential.',
                    'includes' => ['Interaction design including the failure states', 'Retrieval or tool integration with your systems', 'Evaluation set and release thresholds', 'Feedback capture and a quality dashboard'],
                    'tags'     => ['Shipped', 'Evaluated', 'Human in the loop'],
                    'stack'    => ['anthropic', 'openai', 'langgraph', 'llamaindex', 'python', 'react'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products ready to put an AI feature in front of real customers.',
                ],
                [
                    'key'      => 'ai-patterns',
                    'cap'      => 'ai-product-strategy-development',
                    'name'     => 'AI interaction pattern set',
                    'desc'     => 'The reusable patterns your teams need for AI features: streaming, citations, confidence, suggestion against action, undo and escalation to a person.',
                    'includes' => ['Pattern set with usage guidance', 'Disclosure and transparency rules', 'Components added to your design system', 'Review checklist for new AI features'],
                    'tags'     => ['Design system', 'Reusable'],
                    'stack'    => ['figma', 'storybook', 'react'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations where several teams are shipping AI features at once.',
                ],
            ]],

            ['key' => 'systems', 'name' => 'Systems & teams', 'icon' => 'blocks', 'offers' => [
                [
                    'key'      => 'design-system-build',
                    'cap'      => 'system-design',
                    'name'     => 'Design system build',
                    'desc'     => 'Tokens, components and documentation built once in Figma and in code, so new screens are assembled instead of redrawn.',
                    'includes' => ['Interface inventory of what exists today', 'Design tokens exported to each platform', 'Component library with states and accessibility', 'Documentation site and contribution path'],
                    'tags'     => ['Figma + code', 'Versioned', 'Documented'],
                    'stack'    => ['figma', 'storybook', 'react', 'typescript', 'github'],
                    'time'     => '10–20 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations where several teams keep rebuilding the same components.',
                ],
                [
                    'key'      => 'design-tokens',
                    'cap'      => 'system-design',
                    'name'     => 'Design tokens & theming',
                    'desc'     => 'One source of truth for colour, type, spacing and motion, themed for several brands or markets without forking the components.',
                    'includes' => ['Token structure and naming', 'Themes per brand, product or market', 'Exports for web, iOS and Android', 'Light, dark and high-contrast modes'],
                    'tags'     => ['Tokens', 'Multi-brand', 'Multi-platform'],
                    'stack'    => ['figma', 'typescript', 'swift', 'kotlin'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Groups running more than one brand or product on shared components.',
                ],
                [
                    'key'      => 'design-ops',
                    'cap'      => 'design-consulting-solutioning',
                    'name'     => 'Design operations set-up',
                    'desc'     => 'The way your design team takes work in, reviews it and hands it over, set up so quality does not depend on who happens to be on the call.',
                    'includes' => ['Intake, prioritisation and critique rituals', 'Design QA and handover standards', 'File, library and naming structure', 'Research repository and participant process'],
                    'tags'     => ['DesignOps', 'Ways of working'],
                    'stack'    => ['figma', 'notion', 'jira', 'linear'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Design teams growing past the point where everything fits in one conversation.',
                ],
                [
                    'key'      => 'embedded-squad',
                    'cap'      => 'experience-design-development',
                    'name'     => 'Embedded product design squad',
                    'desc'     => 'Designers, researchers and front-end engineers working inside your team, on your backlog, at your cadence.',
                    'includes' => ['Named specialists matched to your roadmap', 'Your tools, rituals and repositories', 'Scale the team up or down each month', 'Knowledge transfer built in from week one'],
                    'tags'     => ['Squad', 'Time & materials'],
                    'stack'    => ['figma', 'react', 'typescript', 'storybook', 'jira'],
                    'time'     => 'Ongoing · monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product teams with a clear roadmap and not enough senior hands.',
                ],
            ]],

        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer', 'enterprise', 'squad'],
    ],

    /* =============================================================================================
       01 · Design Consulting & Solutioning
       ============================================================================================= */
    'design-consulting-solutioning' => [
        'discipline' => 'product-experience',
        'title'      => '<span class="g">Buy the decision,</span> not the deck.',
        'lead'       => 'Commission a short diagnostic, a shaped solution or a standing advisory relationship. Each one is scoped up front and ends in something your leadership team and your engineers can both act on.',
        'categories' => [

            ['key' => 'assess', 'name' => 'Assess', 'icon' => 'gauge', 'offers' => [
                [
                    'key'      => 'experience-audit',
                    'name'     => 'Product experience audit',
                    'desc'     => 'An independent expert review of your live product against the journeys that matter, read alongside the analytics you already have.',
                    'includes' => ['Expert review of three to five key journeys', 'Analytics, search and support-ticket read', 'Severity-rated findings with evidence', 'Ranked fix backlog with effort and impact'],
                    'tags'     => ['Diagnostic', 'Ranked backlog'],
                    'stack'    => ['figma', 'googleanalytics', 'posthog', 'lighthouse'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams who know the product underperforms but not where.',
                ],
                [
                    'key'      => 'accessibility-audit',
                    'name'     => 'Accessibility audit (WCAG 2.2 AA)',
                    'desc'     => 'Your product tested against WCAG 2.2 AA by automated tools and by hand, with each failure explained in terms of who it blocks.',
                    'includes' => ['Automated scan across representative templates', 'Manual keyboard and screen-reader passes', 'Findings mapped to WCAG 2.2 success criteria', 'Prioritised remediation backlog', 'Retest of fixed findings'],
                    'tags'     => ['WCAG 2.2 AA', 'Manual testing', 'Retest'],
                    'stack'    => ['lighthouse', 'playwright'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations answering a procurement, tender or policy requirement.',
                ],
                [
                    'key'      => 'design-maturity',
                    'name'     => 'Design & research maturity review',
                    'desc'     => 'How your design and research practice actually works today, scored against what the roadmap will demand of it in a year.',
                    'includes' => ['Interviews across design, product and engineering', 'Scorecard across research, design, systems, accessibility and measurement', 'Comparison with the roadmap ahead', 'Twelve-month capability plan'],
                    'tags'     => ['Scored baseline', 'Capability plan'],
                    'stack'    => [],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Design and product leaders making a case for investment.',
                ],
                [
                    'key'      => 'journey-analytics-review',
                    'name'     => 'Journey & drop-off review',
                    'desc'     => 'Where people leave, in which step and on which device, read from your own analytics and session data rather than guessed at.',
                    'includes' => ['Funnel and journey analysis from your analytics', 'Session replay and heat-map review', 'Tracking gaps that hide the real picture', 'Shortlist of experiments worth running'],
                    'tags'     => ['Analytics', 'Funnels', 'Experiments'],
                    'stack'    => ['googleanalytics', 'posthog', 'mixpanel'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with traffic and conversion that does not match it.',
                ],
            ]],

            ['key' => 'shape', 'name' => 'Shape the solution', 'icon' => 'compass', 'offers' => [
                [
                    'key'      => 'solution-shaping',
                    'name'     => 'Solution shaping & option appraisal',
                    'desc'     => 'Two or three routes to the same outcome, each drawn as a journey and a system sketch and sized with engineers, so the comparison is like for like.',
                    'includes' => ['Current-state journey and system map', 'Two or three routes at equal depth', 'Effort, running cost and risk range per route', 'Recommendation with the rejected options recorded'],
                    'tags'     => ['Options', 'Decision-ready'],
                    'stack'    => ['figma', 'miro'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams about to commit budget to a large build.',
                ],
                [
                    'key'      => 'design-sprint',
                    'name'     => 'Design sprint',
                    'desc'     => 'One or two weeks that take an ambition from argument to a prototype real customers have used.',
                    'includes' => ['Framing session with the decision makers', 'Concept work and a clickable prototype', 'Five to eight customer sessions', 'A go, adjust or stop recommendation'],
                    'tags'     => ['1–2 weeks', 'Tested with users'],
                    'stack'    => ['figma', 'miro'],
                    'time'     => '1–2 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams stuck between competing ideas and short of evidence.',
                ],
                [
                    'key'      => 'concept-feasibility',
                    'name'     => 'Concept feasibility & costing',
                    'desc'     => 'A concept taken far enough to be costed: the experience, the systems it touches, the data it needs and what it would take to run it.',
                    'includes' => ['Concept designs at the depth needed to estimate', 'Systems, data and integration assessment', 'Effort range with named assumptions', 'Build, buy or defer recommendation'],
                    'tags'     => ['Feasibility', 'Costed range'],
                    'stack'    => ['figma', 'miro'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams asked for a number before anyone has designed the thing.',
                ],
                [
                    'key'      => 'platform-selection',
                    'name'     => 'Platform & tooling selection',
                    'desc'     => 'Build, buy or compose, decided against the journeys the platform has to support and what your team can run without outside help.',
                    'includes' => ['Requirements written as journeys, not feature lists', 'Shortlist with a scored comparison', 'Hands-on evaluation or vendor demo scripts', 'Recommendation with switching costs stated'],
                    'tags'     => ['Build · buy · compose', 'Scored'],
                    'stack'    => [],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations choosing a CMS, commerce, portal or product platform.',
                ],
            ]],

            ['key' => 'ways-of-working', 'name' => 'Ways of working', 'icon' => 'flow', 'offers' => [
                [
                    'key'      => 'design-ops',
                    'name'     => 'Design operations set-up',
                    'desc'     => 'Intake, critique, handover and design QA set up so the quality of a piece of work does not depend on who picked it up.',
                    'includes' => ['Intake, prioritisation and critique rituals', 'Design QA and handover standards', 'File, library and naming structure', 'Tooling and permissions clean-up'],
                    'tags'     => ['DesignOps', 'Ways of working'],
                    'stack'    => ['figma', 'notion', 'jira', 'linear'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Design teams growing past the point where everything fits in one conversation.',
                ],
                [
                    'key'      => 'team-role-design',
                    'name'     => 'Design team & role design',
                    'desc'     => 'The shape of the team the roadmap needs: roles, seniority mix, where designers sit relative to product and engineering, and what to hire first.',
                    'includes' => ['Current team and workload assessment', 'Target team shape with role profiles', 'Hiring sequence and interview guidance', 'Career and craft progression framework'],
                    'tags'     => ['Org design', 'Role profiles'],
                    'stack'    => [],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leaders building or restructuring an in-house design function.',
                ],
                [
                    'key'      => 'research-practice',
                    'name'     => 'Research practice set-up',
                    'desc'     => 'A research habit your team can keep: a participant panel, consent and privacy handled properly, a repository and a regular cadence.',
                    'includes' => ['Recruitment and participant panel set-up', 'Consent, incentive and data-retention process', 'Research repository and tagging', 'Templates, training and a standing cadence'],
                    'tags'     => ['Continuous discovery', 'Repository'],
                    'stack'    => ['notion', 'confluence'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams who research in bursts and lose what they learned.',
                ],
            ]],

            ['key' => 'advisory', 'name' => 'Advisory', 'icon' => 'handshake', 'offers' => [
                [
                    'key'      => 'accessibility-programme',
                    'name'     => 'Accessibility programme',
                    'desc'     => 'A standing programme that takes a product from an audit finding list to WCAG 2.2 AA held over time, with your own team doing more of it each quarter.',
                    'includes' => ['Audit, remediation plan and component-level fixes', 'Checks added to the design and build pipeline', 'Team training for designers, writers and engineers', 'Accessibility statement drafted for you to publish', 'Quarterly re-audit and progress report'],
                    'tags'     => ['WCAG 2.2 AA', 'Ongoing', 'Training'],
                    'stack'    => ['lighthouse', 'playwright', 'storybook'],
                    'time'     => 'Ongoing · quarterly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations with an accessibility obligation and no in-house specialist.',
                ],
                [
                    'key'      => 'design-advisory',
                    'name'     => 'Design advisory retainer',
                    'desc'     => 'A senior design and product voice available to your leadership every month: reviews, second opinions and help with the decisions that do not fit a project.',
                    'includes' => ['Named senior advisor', 'Monthly review of work in progress', 'Critique and decision support on request', 'Quarterly written read on the practice'],
                    'tags'     => ['Retainer', 'Senior advisor'],
                    'stack'    => [],
                    'time'     => 'Ongoing · monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'In-house design leaders who need an experienced outside view.',
                ],
                [
                    'key'      => 'leadership-workshop',
                    'name'     => 'Leadership experience workshop',
                    'desc'     => 'A facilitated day that puts your leadership team inside the customer experience they own, and ends with the three things they will change.',
                    'includes' => ['Pre-work: journey evidence and customer clips', 'Facilitated session with your leadership', 'Prioritised change list with owners', 'Follow-up note and a check-in'],
                    'tags'     => ['Workshop', 'One day'],
                    'stack'    => ['miro'],
                    'time'     => '1–2 weeks including preparation',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Executive teams a long way from the product their customers use.',
                ],
            ]],

        ],
        'packages' => ['sprint', 'project', 'retainer', 'enterprise'],
    ],

    /* =============================================================================================
       02 · Product Strategy & Vision
       ============================================================================================= */
    'product-strategy-vision' => [
        'discipline' => 'product-experience',
        'title'      => '<span class="g">Decide what to build next.</span> Then decide the order.',
        'lead'       => 'Commission a single piece of research, a vision your leadership can agree on, or the full strategy and sequenced roadmap. Every engagement ends with decisions and measures, not a list of features.',
        'categories' => [

            ['key' => 'evidence', 'name' => 'Discovery & evidence', 'icon' => 'search', 'offers' => [
                [
                    'key'      => 'product-discovery',
                    'name'     => 'Product discovery',
                    'desc'     => 'Research across your customers and your own data to find where the unmet need actually is, before a roadmap is written around a guess.',
                    'includes' => ['Customer and lost-customer interviews', 'Analytics, support and sales data read together', 'Opportunity map with rough sizing', 'Shortlist of bets with the evidence attached'],
                    'tags'     => ['Research-led', 'Opportunity map'],
                    'stack'    => ['miro', 'notion', 'posthog', 'mixpanel'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product teams with more ideas than evidence.',
                ],
                [
                    'key'      => 'customer-interviews',
                    'name'     => 'Customer & user interview programme',
                    'desc'     => 'A structured round of interviews with customers, churned customers and the people who serve them, written up so the findings are usable months later.',
                    'includes' => ['Interview guide tied to open decisions', 'Recruitment, consent and incentives handled', 'Twelve to twenty sessions with clips', 'Synthesis, themes and quotes by segment'],
                    'tags'     => ['Qualitative', 'Clips & quotes'],
                    'stack'    => ['notion'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose customer picture comes mostly from the sales team.',
                ],
                [
                    'key'      => 'jobs-to-be-done',
                    'name'     => 'Jobs-to-be-done study',
                    'desc'     => 'What customers are really hiring your product to do, including the switch that brought them and the anxieties that nearly stopped them.',
                    'includes' => ['Switch interviews with recent adopters', 'Job map with forces of progress', 'Job statements and success criteria', 'Implications for positioning and roadmap'],
                    'tags'     => ['JTBD', 'Switch interviews'],
                    'stack'    => ['miro', 'notion'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products whose category description no longer matches why people buy.',
                ],
                [
                    'key'      => 'competitive-product-review',
                    'name'     => 'Competitive product review',
                    'desc'     => 'A hands-on read of the products you are compared with: what they do better, where they are weak, and which of it customers actually notice.',
                    'includes' => ['Hands-on walkthrough of each competitor', 'Feature, journey and pricing comparison', 'Review and support-forum mining', 'Where to match, where to differentiate'],
                    'tags'     => ['Benchmark', 'Hands-on'],
                    'stack'    => ['semrush'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams losing deals to a competitor they have never used.',
                ],
            ]],

            ['key' => 'vision', 'name' => 'Vision & measures', 'icon' => 'flag', 'offers' => [
                [
                    'key'      => 'product-vision',
                    'name'     => 'Product vision',
                    'desc'     => 'One page that says where the product is going and why, written so a team can use it to turn work down.',
                    'includes' => ['Vision workshops with leadership', 'Vision on one page with its principles', 'Narrative for the board and the team', 'Alignment session with product and engineering'],
                    'tags'     => ['One page', 'Alignment'],
                    'stack'    => ['miro', 'notion'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products where every team has a slightly different goal in mind.',
                ],
                [
                    'key'      => 'north-star',
                    'name'     => 'North star metric & input tree',
                    'desc'     => 'The single measure that proxies the value customers get, with the three or four inputs a team can actually move each quarter.',
                    'includes' => ['Candidate metrics tested against your data', 'North star with its input tree', 'Instrumentation gaps listed for engineering', 'Dashboard specification'],
                    'tags'     => ['Metrics', 'Instrumentation'],
                    'stack'    => ['posthog', 'mixpanel', 'googleanalytics', 'looker'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams reporting activity because nobody agreed on an outcome measure.',
                ],
                [
                    'key'      => 'value-proposition',
                    'name'     => 'Product value proposition',
                    'desc'     => 'What the product is for, for whom, and why it is worth switching to, written in the words customers used in research.',
                    'includes' => ['Segment-level value propositions', 'Proof points and objection handling', 'Message testing with customers', 'Handover to marketing and sales'],
                    'tags'     => ['Positioning input', 'Tested'],
                    'stack'    => ['notion'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products that demo well and are hard to explain in a sentence.',
                ],
                [
                    'key'      => 'vision-prototype',
                    'name'     => 'Vision prototype or film',
                    'desc'     => 'A high-fidelity prototype or short film of the product two years out, made to align a leadership team and to test the idea with customers.',
                    'includes' => ['Concept development with leadership', 'High-fidelity prototype or film', 'Customer reaction sessions', 'Presentation pack and narrative'],
                    'tags'     => ['Concept', 'Board-ready'],
                    'stack'    => ['figma', 'react'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams raising money or realigning a portfolio.',
                ],
            ]],

            ['key' => 'planning', 'name' => 'Planning & business case', 'icon' => 'calendar', 'offers' => [
                [
                    'key'      => 'opportunity-map',
                    'name'     => 'Opportunity map & scoring',
                    'desc'     => 'Every candidate opportunity arranged against the outcome it serves and scored on demand evidence, feasibility and fit, with the weights your leadership sets.',
                    'includes' => ['Opportunity tree from the research', 'Scoring model with agreed weights', 'Ranked shortlist with rationale', 'Re-scoring as new evidence arrives'],
                    'tags'     => ['Scored', 'Ranked'],
                    'stack'    => ['miro', 'notion'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with a backlog nobody can rank with a straight face.',
                ],
                [
                    'key'      => 'roadmap-sequencing',
                    'name'     => 'Roadmap & sequencing',
                    'desc'     => 'Now, next and later, ordered by evidence and dependency, with owners, measures and the assumption each bet rests on.',
                    'includes' => ['Sequenced roadmap with dependencies', 'Owners and measures per item', 'Capability gaps that must close first', 'Assumption and experiment backlog'],
                    'tags'     => ['Now · next · later', 'Owners & measures'],
                    'stack'    => ['jira', 'linear', 'notion'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose roadmap is a wish list with dates added.',
                ],
                [
                    'key'      => 'business-case',
                    'name'     => 'Business case per bet',
                    'desc'     => 'The value case for each significant bet: who pays, what it displaces, what it costs to build and to run, and what has to be true for it to pay back.',
                    'includes' => ['Benefit model with stated assumptions', 'Build and run cost estimate with engineering', 'Sensitivity on the two or three fragile assumptions', 'Investment paper for your finance process'],
                    'tags'     => ['Business case', 'Finance-ready'],
                    'stack'    => [],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product leaders who have to defend a number in a budget round.',
                ],
                [
                    'key'      => 'pricing-packaging-input',
                    'name'     => 'Pricing & packaging input',
                    'desc'     => 'How the product should be packaged into tiers and what each tier is worth, tested with customers rather than set by what a competitor charges.',
                    'includes' => ['Feature-to-tier mapping', 'Willingness-to-pay research', 'Packaging options with trade-offs', 'Migration implications for existing customers'],
                    'tags'     => ['Packaging', 'Researched'],
                    'stack'    => [],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products adding a tier, a plan or a usage-based component.',
                ],
            ]],

            ['key' => 'ongoing', 'name' => 'Ongoing', 'icon' => 'cycle', 'offers' => [
                [
                    'key'      => 'quarterly-strategy-review',
                    'name'     => 'Quarterly strategy review',
                    'desc'     => 'A standing session each quarter that tests the plan against what actually happened and re-sequences what comes next.',
                    'includes' => ['Read on measures against the plan', 'Assumptions confirmed or retired', 'Re-sequenced next quarter', 'Written note for the leadership team'],
                    'tags'     => ['Quarterly', 'Re-sequencing'],
                    'stack'    => ['notion', 'looker'],
                    'time'     => 'Ongoing · quarterly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose annual plan is out of date by March.',
                ],
                [
                    'key'      => 'experiment-programme',
                    'name'     => 'Assumption & experiment programme',
                    'desc'     => 'The riskiest assumptions in the roadmap turned into small, fast tests, run in order of what they would cost you to be wrong about.',
                    'includes' => ['Assumption register ranked by risk', 'Experiment design per assumption', 'Running and reading the tests', 'Decision record per result'],
                    'tags'     => ['Experiments', 'De-risking'],
                    'stack'    => ['posthog', 'mixpanel'],
                    'time'     => 'Ongoing · monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams committing to large bets on untested assumptions.',
                ],
                [
                    'key'      => 'product-advisory',
                    'name'     => 'Product advisory retainer',
                    'desc'     => 'A senior product voice available each month for reviews, second opinions and the decisions that fall between projects.',
                    'includes' => ['Named senior advisor', 'Monthly working session', 'Decision support on request', 'Quarterly written read'],
                    'tags'     => ['Retainer', 'Senior advisor'],
                    'stack'    => [],
                    'time'     => 'Ongoing · monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Founders and product leaders without a peer to test thinking against.',
                ],
            ]],

        ],
        'packages' => ['sprint', 'project', 'retainer', 'enterprise'],
    ],

    /* =============================================================================================
       03 · Experience Design & Development
       ============================================================================================= */
    'experience-design-development' => [
        'discipline' => 'product-experience',
        'title'      => '<span class="g">Research, design and front end,</span> in one loop.',
        'lead'       => 'Commission a single round of research, the design of a whole product, or a team that designs and builds the front end together. Every engagement ends with something a real user has tried.',
        'categories' => [

            ['key' => 'research', 'name' => 'Research', 'icon' => 'users', 'offers' => [
                [
                    'key'      => 'research-programme',
                    'name'     => 'User research programme',
                    'desc'     => 'A standing research habit rather than a one-off study: a recruited panel, a regular cadence and a repository your team can search.',
                    'includes' => ['Participant panel and recruitment', 'Consent, incentives and data retention handled', 'Fortnightly or monthly sessions', 'Searchable repository with tagged findings'],
                    'tags'     => ['Continuous discovery', 'Panel', 'Repository'],
                    'stack'    => ['notion', 'confluence'],
                    'time'     => 'Ongoing · monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams who want evidence every sprint, not once a year.',
                ],
                [
                    'key'      => 'usability-testing',
                    'name'     => 'Usability testing round',
                    'desc'     => 'One round of moderated or unmoderated sessions on a specific journey, written up as a prioritised list of what to fix.',
                    'includes' => ['Test plan and task scripts', 'Recruitment of five to eight participants', 'Moderated or unmoderated sessions', 'Findings, clips and a prioritised fix list'],
                    'tags'     => ['One round', 'Moderated · unmoderated'],
                    'stack'    => ['figma', 'notion'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams about to build something nobody outside the room has tried.',
                ],
                [
                    'key'      => 'usability-benchmark',
                    'name'     => 'Usability benchmark',
                    'desc'     => 'A repeatable measure of how the product performs today, so the next release can be judged against a number rather than a feeling.',
                    'includes' => ['Task set defined with your team', 'Quantitative study with a larger sample', 'Task success, time on task and error rate', 'Standard usability score such as SUS or UMUX-Lite'],
                    'tags'     => ['Quantitative', 'Baseline'],
                    'stack'    => [],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams starting a redesign that will have to prove it worked.',
                ],
                [
                    'key'      => 'accessibility-user-testing',
                    'name'     => 'Accessibility user testing',
                    'desc'     => 'Sessions with disabled participants using their own assistive technology, which finds the barriers an audit against the guidelines never will.',
                    'includes' => ['Recruitment across assistive technologies', 'Sessions with screen reader, magnifier and switch users', 'Barriers mapped to journeys and components', 'Fixes written into the component backlog'],
                    'tags'     => ['Assistive tech', 'Lived experience'],
                    'stack'    => [],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations that pass automated checks and still get complaints.',
                ],
            ]],

            ['key' => 'design', 'name' => 'Design', 'icon' => 'layout', 'offers' => [
                [
                    'key'      => 'ux-ui-design',
                    'name'     => 'End-to-end UX & UI design',
                    'desc'     => 'The full design of a product or a major journey: structure, screens, content and every state, tested with users as it is drawn.',
                    'includes' => ['Information architecture and journeys', 'Interface design with empty, loading, error and offline states', 'UX writing for labels, guidance and errors', 'Testing rounds through the project', 'Handover with acceptance criteria'],
                    'tags'     => ['UX · UI', 'Every state', 'Handover-ready'],
                    'stack'    => ['figma', 'miro', 'storybook'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams building a new product or rebuilding a journey that fails.',
                ],
                [
                    'key'      => 'app-redesign',
                    'name'     => 'Product or app redesign',
                    'desc'     => 'A redesign planned to ship in stages behind flags, so value arrives early and the risk of a big-bang replacement is avoided.',
                    'includes' => ['Baseline usability benchmark', 'Journey-by-journey redesign plan', 'Designs and prototypes per stage', 'Rollout and migration plan', 'Benchmark repeated after release'],
                    'tags'     => ['Staged', 'Benchmarked'],
                    'stack'    => ['figma', 'posthog', 'playwright'],
                    'time'     => '10–20 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products that have grown well past their original design.',
                ],
                [
                    'key'      => 'ia-navigation',
                    'name'     => 'Information architecture & navigation',
                    'desc'     => 'The structure underneath the product: what is called what, where it lives and how people find it, validated before the screens are drawn.',
                    'includes' => ['Content and feature inventory', 'Card sorting and tree testing', 'Navigation model and taxonomy', 'First-click validation of the new structure'],
                    'tags'     => ['IA', 'Tree tested'],
                    'stack'    => ['figma', 'miro'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products or sites where people use search because navigation fails.',
                ],
                [
                    'key'      => 'content-design',
                    'name'     => 'UX writing & content design',
                    'desc'     => 'The words in the interface written with the design: labels, guidance, empty states, errors and confirmations that work the first time.',
                    'includes' => ['Content audit of the key journeys', 'Rewritten interface copy in the designs', 'Error and edge-case message set', 'Content guidelines and terminology list'],
                    'tags'     => ['Microcopy', 'Guidelines'],
                    'stack'    => ['figma', 'notion'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products where support answers the same question every week.',
                ],
                [
                    'key'      => 'motion-design',
                    'name'     => 'Interface motion design',
                    'desc'     => 'Transitions, loading and feedback designed to explain what just happened, with a reduced-motion path that is a first-class experience.',
                    'includes' => ['Motion principles and timing scale', 'Key transitions specified for engineering', 'Reduced-motion behaviour defined', 'Reference implementations in code'],
                    'tags'     => ['Motion', 'Reduced motion'],
                    'stack'    => ['figma', 'react', 'typescript'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products where state changes leave people unsure what happened.',
                ],
            ]],

            ['key' => 'prototypes', 'name' => 'Prototypes', 'icon' => 'bolt', 'offers' => [
                [
                    'key'      => 'clickable-prototype',
                    'name'     => 'Clickable prototype',
                    'desc'     => 'A prototype in Figma good enough to test a flow with customers, or to show a stakeholder what is actually being proposed.',
                    'includes' => ['Key flows wired end to end', 'Realistic content rather than placeholder text', 'Variants for the options under discussion', 'Ready for a testing round'],
                    'tags'     => ['Figma', 'Fast'],
                    'stack'    => ['figma'],
                    'time'     => '1–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams who need to show rather than describe.',
                ],
                [
                    'key'      => 'coded-prototype',
                    'name'     => 'Coded prototype',
                    'desc'     => 'A prototype in real code on real or realistic data, for the questions a Figma file cannot answer: performance, scale, live content and edge cases.',
                    'includes' => ['Front-end prototype on your data or a realistic sample', 'The interactions that need real behaviour', 'Deployed for stakeholder and user access', 'Findings and a reuse or discard recommendation'],
                    'tags'     => ['Real data', 'Deployed'],
                    'stack'    => ['react', 'nextdotjs', 'typescript', 'supabase'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Data-heavy products where the real question is behaviour at scale.',
                ],
                [
                    'key'      => 'concept-testing',
                    'name'     => 'Concept testing round',
                    'desc'     => 'Two or three concepts put in front of customers side by side, so the choice is made on their reaction rather than on internal preference.',
                    'includes' => ['Concepts developed to comparable fidelity', 'Test design that avoids leading participants', 'Sessions with the target segment', 'Recommendation with the evidence for it'],
                    'tags'     => ['Comparative', 'Evidence'],
                    'stack'    => ['figma'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams deadlocked between two directions.',
                ],
            ]],

            ['key' => 'front-end', 'name' => 'Front end', 'icon' => 'code', 'offers' => [
                [
                    'key'      => 'frontend-build',
                    'name'     => 'Front-end build',
                    'desc'     => 'The designed experience built as accessible, fast front-end code in your repositories, with the automated checks that keep it that way.',
                    'includes' => ['Component-based front end in React and TypeScript', 'Accessibility and visual regression tests in CI', 'Core Web Vitals budgets enforced on merge', 'Design QA pass before each release'],
                    'tags'     => ['React', 'WCAG 2.2 AA', 'Core Web Vitals'],
                    'stack'    => ['react', 'nextdotjs', 'typescript', 'tailwindcss', 'playwright'],
                    'time'     => '6–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with designs ready and no front-end capacity to do them justice.',
                ],
                [
                    'key'      => 'design-qa',
                    'name'     => 'Design QA & polish pass',
                    'desc'     => 'A pass over what your engineers built against what was designed: spacing, states, focus, motion and the details that make a product feel finished.',
                    'includes' => ['Screen-by-screen comparison against the designs', 'Interaction, focus and state review', 'Ticketed findings with severity', 'Pairing sessions with your engineers'],
                    'tags'     => ['Polish', 'Ticketed'],
                    'stack'    => ['figma', 'storybook', 'jira'],
                    'time'     => '1–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose releases look almost, but not quite, like the designs.',
                ],
                [
                    'key'      => 'accessibility-remediation',
                    'name'     => 'Accessibility remediation',
                    'desc'     => 'The fixing, not the finding: audit failures resolved in your code, at component level wherever possible, then retested.',
                    'includes' => ['Fixes prioritised by how much they block people', 'Component-level remediation over page patches', 'Automated checks added to the pipeline', 'Retest and an updated conformance record'],
                    'tags'     => ['WCAG 2.2 AA', 'In your code'],
                    'stack'    => ['react', 'typescript', 'playwright', 'storybook'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations holding an audit report and no capacity to act on it.',
                ],
                [
                    'key'      => 'frontend-performance',
                    'name'     => 'Front-end performance pass',
                    'desc'     => 'The interface made fast where users feel it: what loads first, what blocks interaction and what shifts under their thumb.',
                    'includes' => ['Field and lab measurement at p75', 'Bundle, image and font work', 'Interaction and layout-shift fixes', 'Budgets added to CI so it does not regress'],
                    'tags'     => ['Core Web Vitals', 'p75'],
                    'stack'    => ['lighthouse', 'pagespeedinsights', 'nextdotjs', 'playwright'],
                    'time'     => '2–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products that test well on a laptop and badly on a phone.',
                ],
            ]],

            ['key' => 'ongoing', 'name' => 'Ongoing', 'icon' => 'cycle', 'offers' => [
                [
                    'key'      => 'embedded-squad',
                    'name'     => 'Embedded design & front-end squad',
                    'desc'     => 'Designers, researchers and front-end engineers working inside your team, on your backlog, at your cadence.',
                    'includes' => ['Named specialists matched to your roadmap', 'Your tools, rituals and repositories', 'Scale up or down each month', 'Knowledge transfer built in from week one'],
                    'tags'     => ['Squad', 'Time & materials'],
                    'stack'    => ['figma', 'react', 'typescript', 'storybook', 'jira'],
                    'time'     => 'Ongoing · monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product teams with a clear roadmap and not enough senior hands.',
                ],
                [
                    'key'      => 'continuous-discovery',
                    'name'     => 'Continuous discovery retainer',
                    'desc'     => 'A researcher and a designer running a steady loop of sessions, experiments and readouts alongside your delivery team.',
                    'includes' => ['Regular sessions with your users', 'Findings into the backlog each sprint', 'Experiment design and readouts', 'Monthly summary for leadership'],
                    'tags'     => ['Retainer', 'Every sprint'],
                    'stack'    => ['posthog', 'notion'],
                    'time'     => 'Ongoing · monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Delivery teams shipping faster than they are learning.',
                ],
            ]],

        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer', 'squad'],
    ],

    /* =============================================================================================
       04 · AI Product Strategy & Development
       ============================================================================================= */
    'ai-product-strategy-development' => [
        'discipline' => 'product-experience',
        'title'      => '<span class="g">Design the AI feature</span> people keep using.',
        'lead'       => 'Commission a short opportunity read, a prototype on live models, or the design and build of an AI feature inside your product. Every engagement is judged on real model output and tested with the people who will use it.',
        'categories' => [

            ['key' => 'find', 'name' => 'Find the opportunity', 'icon' => 'search', 'offers' => [
                [
                    'key'      => 'ai-opportunity-map',
                    'name'     => 'AI opportunity mapping',
                    'desc'     => 'Where AI genuinely removes effort in your product, and where it would only add another box to type in.',
                    'includes' => ['Journey read for the AI moments', 'Value, feasibility and risk score per idea', 'Content and data readiness check', 'Shortlist with a first use case to prototype'],
                    'tags'     => ['Journey-led', 'Scored'],
                    'stack'    => ['miro', 'figma'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product teams under pressure to add AI without a clear reason yet.',
                ],
                [
                    'key'      => 'ai-concept-sprint',
                    'name'     => 'AI concept sprint',
                    'desc'     => 'Two weeks from idea to a tested concept: patterns drawn, a rough prototype on a live model, and sessions with the people it is for.',
                    'includes' => ['Framing of the task and its failure modes', 'Concept and interaction patterns', 'Rough prototype on a live model', 'Customer sessions and a recommendation'],
                    'tags'     => ['2 weeks', 'Live model'],
                    'stack'    => ['anthropic', 'openai', 'figma'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with an AI idea and no evidence either way.',
                ],
                [
                    'key'      => 'ai-feasibility',
                    'name'     => 'AI feasibility & data check',
                    'desc'     => 'Whether the content, data and permissions exist to make the feature work, checked before a team is committed to building it.',
                    'includes' => ['Content and data inventory for the use case', 'Quality, coverage and permission assessment', 'Retrieval or model approach options', 'Cost-per-request estimate with assumptions'],
                    'tags'     => ['Data readiness', 'Cost model'],
                    'stack'    => ['llamaindex', 'pgvector', 'python'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose AI plan assumes the content is better than it is.',
                ],
            ]],

            ['key' => 'design', 'name' => 'Design the experience', 'icon' => 'sparkle', 'offers' => [
                [
                    'key'      => 'ai-feature-design',
                    'name'     => 'AI feature design',
                    'desc'     => 'The full design of an AI feature, starting from what happens when the model is wrong, uncertain or refuses.',
                    'includes' => ['Task and failure-mode analysis', 'Interaction design including low-confidence and refusal states', 'Disclosure, citation and correction flows', 'Handover with acceptance criteria for engineering'],
                    'tags'     => ['Failure states first', 'Handover-ready'],
                    'stack'    => ['figma', 'storybook'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with model access and no design for what surrounds it.',
                ],
                [
                    'key'      => 'ai-pattern-set',
                    'name'     => 'AI interaction pattern set',
                    'desc'     => 'Reusable patterns for AI in your products: streaming, citations, confidence, suggestion against action, undo and escalation to a person.',
                    'includes' => ['Pattern set with usage guidance', 'Disclosure and transparency rules', 'Components added to your design system', 'Review checklist for every new AI feature'],
                    'tags'     => ['Design system', 'Reusable'],
                    'stack'    => ['figma', 'storybook', 'react'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations where several teams are shipping AI features at once.',
                ],
                [
                    'key'      => 'ai-prototype',
                    'name'     => 'Prototype on live models',
                    'desc'     => 'A working prototype wired to real models and your own content, so the idea is judged on what the model actually returns.',
                    'includes' => ['Interaction patterns designed for the task', 'Prototype on live models and real content', 'Sessions with the people who would use it', 'Findings, costs and a build or stop recommendation'],
                    'tags'     => ['Live models', 'Tested'],
                    'stack'    => ['anthropic', 'openai', 'googlegemini', 'react', 'nextdotjs'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams deciding whether an AI feature deserves a quarter of engineering.',
                ],
                [
                    'key'      => 'ai-voice-tone',
                    'name'     => 'AI voice & tone guidelines',
                    'desc'     => 'How the product should sound when it is the one speaking: register, hedging, refusals, apologies and the phrasing it must never use.',
                    'includes' => ['Voice rules written for prompts, not posters', 'Refusal, uncertainty and error phrasing', 'Prohibited phrasing and claim rules', 'Checks added to the evaluation set'],
                    'tags'     => ['Voice', 'In the eval set'],
                    'stack'    => ['notion'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose assistant sounds like a different company.',
                ],
            ]],

            ['key' => 'prove', 'name' => 'Prove it', 'icon' => 'check', 'offers' => [
                [
                    'key'      => 'eval-set',
                    'name'     => 'Evaluation set & scoring',
                    'desc'     => 'A graded test set built with your experts, so quality is a number that moves rather than an impression after a demo.',
                    'includes' => ['Task list and grading criteria with your experts', 'Scored eval set with automated runs', 'Calibration against human review', 'Release thresholds and a regression run in CI'],
                    'tags'     => ['Evals', 'Release gate'],
                    'stack'    => ['python', 'anthropic', 'openai'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams shipping AI changes with no way to tell if quality dropped.',
                ],
                [
                    'key'      => 'trust-testing',
                    'name'     => 'Trust & preference testing',
                    'desc'     => 'Sessions that show whether people believe the output, notice when it is wrong and know what to do next.',
                    'includes' => ['Test design around trust and correction', 'Sessions with the intended users', 'Preference tests between approaches', 'Design changes prioritised from what they did'],
                    'tags'     => ['With users', 'Trust'],
                    'stack'    => [],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Features where a wrong answer accepted quietly would cost something.',
                ],
                [
                    'key'      => 'transparency-review',
                    'name'     => 'Transparency & disclosure review',
                    'desc'     => 'A review of what your AI features tell people: that it is AI, where the answer came from, what was stored and how to reach a human.',
                    'includes' => ['Review of disclosure across the journey', 'Citation, sourcing and data-use statements', 'Route to a person where it is missing', 'Prioritised changes with copy written'],
                    'tags'     => ['Disclosure', 'Sourcing'],
                    'stack'    => [],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products that shipped AI quickly and want to check what it tells people.',
                ],
                [
                    'key'      => 'ai-risk-classification',
                    'name'     => 'AI use-case risk classification',
                    'desc'     => 'Each AI use case classified by risk tier against the EU AI Act and NIST AI RMF, with the obligations that follow written as design requirements.',
                    'includes' => ['Inventory of AI use cases in the product', 'Risk tier and reasoning per use case', 'Transparency, oversight and logging requirements', 'Design and engineering backlog to meet them'],
                    'tags'     => ['EU AI Act', 'NIST AI RMF'],
                    'stack'    => [],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products with EU users or an internal AI governance requirement.',
                ],
            ]],

            ['key' => 'build', 'name' => 'Build & run', 'icon' => 'bolt', 'offers' => [
                [
                    'key'      => 'ai-feature-build',
                    'name'     => 'AI feature build',
                    'desc'     => 'The feature shipped inside your product, with guardrails, human approval for consequential actions and quality watched after launch.',
                    'includes' => ['Retrieval or tool integration with your systems', 'Guardrails and approval steps', 'Evaluation thresholds gating the release', 'Feedback capture and a quality dashboard'],
                    'tags'     => ['Shipped', 'Human in the loop'],
                    'stack'    => ['anthropic', 'openai', 'langgraph', 'llamaindex', 'python', 'react'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products ready to put an AI feature in front of real customers.',
                ],
                [
                    'key'      => 'in-product-assistant',
                    'name'     => 'In-product assistant',
                    'desc'     => 'An assistant inside your product that answers from your own content and can act on your systems, with sources shown and a clear way back to a person.',
                    'includes' => ['Grounded answers with citations', 'Permission-aware access to your content', 'Actions with confirmation and undo', 'Escalation path to a human with context'],
                    'tags'     => ['Grounded', 'Cited', 'Escalation'],
                    'stack'    => ['llamaindex', 'pgvector', 'anthropic', 'openai', 'react'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products whose users search documentation more than they use the product.',
                ],
                [
                    'key'      => 'ai-adoption-monitoring',
                    'name'     => 'Adoption & quality monitoring',
                    'desc'     => 'What happens after launch: adoption past the novelty week, correction and abandonment rates, and an eval set that grows from real traffic.',
                    'includes' => ['Adoption, correction and escalation measures', 'Quality dashboard with alerting', 'Eval set grown from production traffic', 'Monthly read and improvement backlog'],
                    'tags'     => ['Post-launch', 'Monitored'],
                    'stack'    => ['posthog', 'mixpanel', 'python'],
                    'time'     => 'Ongoing · monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose AI feature launched well and has not been measured since.',
                ],
                [
                    'key'      => 'ai-product-squad',
                    'name'     => 'Embedded AI product squad',
                    'desc'     => 'Product designers, AI engineers and a researcher working inside your team on your AI roadmap.',
                    'includes' => ['Named specialists matched to your roadmap', 'Your repositories, models and cadence', 'Evaluation and guardrail practice built in', 'Knowledge transfer from week one'],
                    'tags'     => ['Squad', 'Time & materials'],
                    'stack'    => ['python', 'typescript', 'anthropic', 'openai', 'github'],
                    'time'     => 'Ongoing · monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with an AI roadmap and too few people who have shipped one.',
                ],
            ]],

        ],
        'packages' => ['sprint', 'project', 'milestone', 'squad'],
    ],

    /* =============================================================================================
       05 · System Design
       ============================================================================================= */
    'system-design' => [
        'discipline' => 'product-experience',
        'title'      => '<span class="g">Build it once.</span> Use it everywhere.',
        'lead'       => 'Commission the foundations, the component library, the documentation or the whole system. Everything here ships in Figma and in code together, because a library that exists in only one of them drifts within a quarter.',
        'categories' => [

            ['key' => 'foundations', 'name' => 'Foundations', 'icon' => 'tokens', 'offers' => [
                [
                    'key'      => 'interface-inventory',
                    'name'     => 'Interface inventory & audit',
                    'desc'     => 'Every screen and component you already have, catalogued, with the duplicates and the accidental inconsistencies separated from the deliberate ones.',
                    'includes' => ['Screenshot inventory across products', 'Component and pattern duplication report', 'Colour, type and spacing variance count', 'Scope recommendation for a first release'],
                    'tags'     => ['Inventory', 'Evidence'],
                    'stack'    => ['figma'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations arguing about whether they need a design system.',
                ],
                [
                    'key'      => 'design-tokens',
                    'name'     => 'Design tokens',
                    'desc'     => 'Colour, type, spacing, radius, elevation and motion held once and exported to each platform, instead of copied between files and codebases.',
                    'includes' => ['Token structure and naming convention', 'Semantic layer over the raw values', 'Exports for web, iOS and Android', 'Light, dark and high-contrast modes'],
                    'tags'     => ['One source', 'Multi-platform'],
                    'stack'    => ['figma', 'typescript', 'swift', 'kotlin'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams where a colour change means editing five places.',
                ],
                [
                    'key'      => 'theming-multibrand',
                    'name'     => 'Multi-brand & market theming',
                    'desc'     => 'One component set themed for several brands, products or markets, with the differences held in tokens rather than in forked components.',
                    'includes' => ['Theme model and inheritance rules', 'Per-brand or per-market token sets', 'Runtime theme switching', 'Contrast validation per theme'],
                    'tags'     => ['Themes, not forks', 'Validated'],
                    'stack'    => ['figma', 'react', 'typescript'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Groups running several brands or markets on shared components.',
                ],
                [
                    'key'      => 'accessible-foundations',
                    'name'     => 'Accessible foundations',
                    'desc'     => 'Colour, focus, target size and typography set so that anything built on them starts at WCAG 2.2 AA instead of being fixed afterwards.',
                    'includes' => ['Contrast-validated palette including states', 'Focus style that works on every surface', 'Target size and spacing rules', 'Type scale checked for zoom and reflow'],
                    'tags'     => ['WCAG 2.2 AA', 'By default'],
                    'stack'    => ['figma', 'storybook'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose accessibility bugs keep coming from the same few decisions.',
                ],
            ]],

            ['key' => 'components', 'name' => 'Components', 'icon' => 'blocks', 'offers' => [
                [
                    'key'      => 'figma-library',
                    'name'     => 'Figma library',
                    'desc'     => 'The design side of the system: components with their variants and states, structured so designers assemble screens rather than redraw them.',
                    'includes' => ['Components with variants and every state', 'Token-driven styles', 'Usage notes on the component', 'Library publishing and versioning set up'],
                    'tags'     => ['Figma', 'Variants & states'],
                    'stack'    => ['figma'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Design teams whose files disagree with each other.',
                ],
                [
                    'key'      => 'component-library-code',
                    'name'     => 'Component library in code',
                    'desc'     => 'The components your products actually consume: built once with keyboard behaviour and ARIA, published as a versioned package and documented.',
                    'includes' => ['Components in React and TypeScript', 'Keyboard behaviour and ARIA per component', 'Unit, visual regression and accessibility tests', 'Versioned package with a release process'],
                    'tags'     => ['Versioned package', 'Tested'],
                    'stack'    => ['react', 'typescript', 'storybook', 'jest', 'playwright', 'github'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations where each product team rebuilds the same components.',
                ],
                [
                    'key'      => 'component-accessibility',
                    'name'     => 'Component accessibility hardening',
                    'desc'     => 'An existing library taken through the accessibility work component by component, so every product that consumes it inherits the fix.',
                    'includes' => ['Component-level accessibility audit', 'Keyboard, focus and ARIA fixes', 'Automated accessibility tests per component', 'Acceptance criteria written into the docs'],
                    'tags'     => ['WCAG 2.2 AA', 'Inherited fixes'],
                    'stack'    => ['react', 'typescript', 'storybook', 'playwright'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with a library that predates their accessibility requirement.',
                ],
                [
                    'key'      => 'patterns-templates',
                    'name'     => 'Patterns & page templates',
                    'desc'     => 'The layer above components: forms, tables, filters, empty states and page templates, so common screens are a decision rather than a project.',
                    'includes' => ['Pattern set for the journeys you repeat', 'Page templates with responsive behaviour', 'Content and validation rules for forms', 'Worked examples in the documentation'],
                    'tags'     => ['Patterns', 'Templates'],
                    'stack'    => ['figma', 'react', 'storybook'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products with many similar screens built slightly differently.',
                ],
            ]],

            ['key' => 'docs', 'name' => 'Documentation & governance', 'icon' => 'doc', 'offers' => [
                [
                    'key'      => 'documentation-site',
                    'name'     => 'Documentation site',
                    'desc'     => 'One place that shows each component live, says when to use it and when not to, and stays true because it is generated from the code.',
                    'includes' => ['Storybook or documentation site set-up', 'Usage guidance, do and do not, per component', 'Accessibility notes and keyboard behaviour', 'Search and navigation across the system'],
                    'tags'     => ['Storybook', 'Live examples'],
                    'stack'    => ['storybook', 'react', 'githubactions'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Systems people cannot use because nobody can find anything.',
                ],
                [
                    'key'      => 'contribution-model',
                    'name'     => 'Contribution model',
                    'desc'     => 'A path for product teams to add to the system, with review and standards, so the system grows instead of being routed around.',
                    'includes' => ['Contribution and review process', 'Definition of done for a component', 'Request and triage workflow', 'Roles and decision rights'],
                    'tags'     => ['Governance', 'Open to teams'],
                    'stack'    => ['github', 'notion'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Systems maintained by one team and needed by five.',
                ],
                [
                    'key'      => 'versioning-release',
                    'name'     => 'Versioning & release process',
                    'desc'     => 'Semantic versioning, changelogs, deprecation notices and a release pipeline, so consumers can upgrade on their own schedule without surprises.',
                    'includes' => ['Semantic versioning and changelog automation', 'Deprecation policy and notice period', 'Release pipeline with automated checks', 'Migration notes and codemods where they help'],
                    'tags'     => ['Semver', 'Automated'],
                    'stack'    => ['github', 'githubactions', 'typescript'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Systems where every upgrade breaks somebody quietly.',
                ],
                [
                    'key'      => 'system-health-check',
                    'name'     => 'Design system health check',
                    'desc'     => 'An independent read on the system you already have: what is adopted, what is bypassed, what is undocumented and what to fix first.',
                    'includes' => ['Adoption measured across products', 'Coverage and duplication analysis', 'Interviews with consuming teams', 'Prioritised plan for the next two quarters'],
                    'tags'     => ['Diagnostic', 'Adoption data'],
                    'stack'    => ['figma', 'storybook', 'github'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations with a design system nobody seems to use.',
                ],
            ]],

            ['key' => 'adopt', 'name' => 'Adoption & run', 'icon' => 'cycle', 'offers' => [
                [
                    'key'      => 'migration-programme',
                    'name'     => 'Migration & adoption programme',
                    'desc'     => 'Getting products onto the system without stopping their roadmaps: one pilot team first, then the rest, with support at each step.',
                    'includes' => ['Migration plan per product team', 'Pilot migration with lessons applied', 'Codemods and migration guides', 'Support through each team’s first release'],
                    'tags'     => ['Staged', 'Supported'],
                    'stack'    => ['react', 'typescript', 'github'],
                    'time'     => '8–20 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations with a finished system and no adoption.',
                ],
                [
                    'key'      => 'adoption-measurement',
                    'name'     => 'Adoption measurement',
                    'desc'     => 'A measure of how much of each product is actually built from the system, so the conversation is about numbers rather than impressions.',
                    'includes' => ['Component usage tracking across repositories', 'Adoption dashboard per team', 'Detached and bespoke component reporting', 'Targets agreed with each team'],
                    'tags'     => ['Dashboard', 'Per team'],
                    'stack'    => ['github', 'storybook', 'figma'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'System owners asked to prove the investment is working.',
                ],
                [
                    'key'      => 'system-training',
                    'name'     => 'Training & office hours',
                    'desc'     => 'Sessions for designers and engineers on using the system well, plus a standing hour each week where teams bring real problems.',
                    'includes' => ['Onboarding sessions for design and engineering', 'Contribution walkthrough', 'Weekly office hours', 'Recorded material for new joiners'],
                    'tags'     => ['Training', 'Office hours'],
                    'stack'    => ['figma', 'storybook'],
                    'time'     => 'Ongoing · weekly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams who have the system and still build around it.',
                ],
                [
                    'key'      => 'system-retainer',
                    'name'     => 'Design system retainer',
                    'desc'     => 'A reserved block of time each month to maintain and extend the system: new components, upgrades, accessibility fixes and support for consuming teams.',
                    'includes' => ['Reserved monthly capacity', 'New components and pattern requests', 'Dependency and accessibility upkeep', 'Monthly release and adoption report'],
                    'tags'     => ['Retainer', 'Maintained'],
                    'stack'    => ['react', 'typescript', 'storybook', 'github'],
                    'time'     => 'Ongoing · monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations without a permanent design system team yet.',
                ],
            ]],

        ],
        'packages' => ['project', 'milestone', 'retainer', 'squad'],
    ],

];
