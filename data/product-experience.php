<?php
/**
 * Product & Experience Design: the five capabilities, in depth.
 *
 * DRAFT COPY — review before launch.
 *
 * The names and one-line descriptions come from data/site.php (the client's approved copy);
 * 'name' here must match it exactly. Everything below is the long-form content the hub and
 * the capability pages are built from: what each one offers, how it runs, what is handed over,
 * what changes, and the questions people ask. Timeframes are typical, not promised, and are
 * marked PLACEHOLDER so they can be confirmed before launch.
 *
 * Fields per capability
 *   n, slug, name, short, kicker    index, page slug, approved name, short label, eyebrow line
 *   title                           heading HTML: <span class="g">grey first phrase.</span> ink rest
 *   lead, meta + meta_k, cta        intro paragraph, three meta values with their labels, CTA label
 *   icon                            the capability's icon (xt_icon name, partials/tech/kit.php)
 *   offer_title, offer_lead         heading HTML and lead for the offer section
 *   offer                           6 × [title, description, tag, icon — xt_icon name]
 *   process                         ['title' (HTML), 'lead', 'steps' => [[name, timing, description, [outputs]]]]
 *   deliver                         [[item, format]]
 *   outcomes                        3 × [title, text]
 *   faq                             5 × [question, answer]
 *   pairs                           2 related capability slugs
 *   img                             card photo ['src','w','h','alt','pos']
 *                                   (assets/imgs/product/shared/ — the builder sources the photos and
 *                                   records them in a CREDITS.md beside them, as assets/imgs/tech/shared does)
 *   stack                           technology slugs from data/tech-stack.php, most relevant first (render with xt_stack)
 *   standards                       badge keys from xt_standards() (render with xt_badge)
 *
 * Boundaries with the other disciplines, so the pages do not claim each other's work:
 *   Brand Design owns brand strategy, identity and the brand system. System Design here consumes
 *   those constants and turns them into a product's tokens, components and versioning.
 *   Technology & Intelligence owns the engineering of models, retrieval, agents, platforms and
 *   infrastructure. AI Product Strategy & Development here designs the product around them and
 *   ships the feature with those engineers.
 *
 * Truthfulness: technologies are ones we work with, never partnerships. Standards are frameworks
 * delivery is built to or aligned with; nothing here says Xterra Edze holds a certification.
 * WCAG 2.2 AA conformance is a statement made about a product, not a certificate anyone issues.
 *
 * Voice: calm, precise, confident. Short active sentences. No exclamation marks.
 */

return [

    'design-consulting-solutioning' => [
        'n'          => '01',
        'slug'       => 'design-consulting-solutioning',
        'name'       => 'Design Consulting & Solutioning',
        'short'      => 'Consulting',
        'kicker'     => 'Before anyone commits',
        'title'      => '<span class="g">A new capability is not a plan.</span> Shape it before you build it.',
        'lead'       => 'Design Consulting & Solutioning turns an ambition or a new capability into something a team can actually ship. Routes are drawn to the same level of detail, tested with the people who will use them and sized with the engineers who would build them, so the one chosen survives contact with delivery.',
        'meta'       => ['4–8 weeks', 'Advisory · solutioning', 'Decision-ready output'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Format', 'Standard'],
        'cta'        => 'Start a consulting brief',
        'icon'       => 'compass',
        'offer_title'=> '<span class="g">Six ways in,</span> one decision at the end',
        'offer_lead' => 'Every engagement ends the same way: a recommended route, the rejected ones recorded, and enough detail for finance and engineering to agree on it.',
        'offer' => [                    // [title, description, tag, icon — see xt_icons()]
            ['Experience & capability assessment', 'Your product, research practice, design system, accessibility and measurement scored against where the roadmap needs them to be.', 'Scored baseline', 'gauge'],
            ['Solution shaping',                   'Two or three routes to the same outcome, each drawn as a journey, a system sketch and an effort range, so the comparison is like for like.', 'Options · trade-offs', 'compass'],
            ['Design sprints',                     'One or two weeks to take a vague ambition to a tested prototype, with the customers it is meant for in the room before the week ends.', '1–2 weeks', 'bolt'],
            ['Build, buy or compose',              'Platform and tooling choices judged on the journeys they have to support, the cost of changing them later, and what your team can run without us.', 'Evidence-led selection', 'layers'],
            ['Design operations',                  'Intake, critique, handover, design QA and the working ratio of designers to engineers, set up so good work does not depend on who is on the call.', 'DesignOps', 'workflow'],
            ['Accessibility advisory',             'A WCAG 2.2 AA programme: audit, prioritised backlog, component-level fixes, team training and an accessibility statement you can publish.', 'WCAG 2.2 AA', 'accessibility'],
        ],
        'process' => [
            'title' => '<span class="g">Six weeks</span> from ambition to a costed route',
            'lead'  => 'Options stay open until there is evidence to close them. Nothing is recommended that engineering has not sized.',
            'steps' => [
                ['Frame',     'Wk 01',    'The decision to be made, the constraints that are real rather than assumed, the people affected and what success looks like twelve months out.', ['Decision brief', 'Constraint map', 'Success measures']],
                ['Explore',   'Wk 01–03', 'Current journeys, systems and data reviewed with the teams who own them. Two or three candidate routes drawn to the same depth.', ['Current-state map', 'Route options', 'Risk log']],
                ['Test',      'Wk 03–05', 'The leading routes prototyped and put in front of users and engineers. Effort, running cost and risk estimated against what the prototype revealed.', ['Prototypes', 'Research findings', 'Effort & cost model']],
                ['Recommend', 'Wk 05–06', 'One route recommended, the rejected ones recorded with their reasons, and a phased plan with the operating model needed to run it.', ['Recommendation', 'Phased plan', 'Decision record']],
            ],
        ],
        'deliver' => [
            ['Capability assessment & scorecard',        'Deck · Sheet'],
            ['Current-state experience map',             'Figma'],
            ['Solution options with trade-offs',         'Document · Figma'],
            ['Prototype used for testing',               'Figma · coded'],
            ['Effort, cost & risk model',                'Sheet'],
            ['Target operating model & DesignOps plan',  'Document'],
            ['Phased roadmap & decision record',         'Roadmap · ADR'],
        ],
        'outcomes' => [
            ['A route you can cost',   'Options compared like for like, sized by the engineers who would build them, with the assumptions written next to the numbers.'],
            ['Fewer reversals later',  'The expensive assumptions are tested in week three, while changing course still costs a week rather than a quarter.'],
            ['A team that can run it', 'Rituals, roles, intake and handover written down, so the plan does not depend on us still being here.'],
        ],
        'faq' => [
            ['What is the difference between consulting and a discovery project?', 'Consulting starts with a decision you have to make and ends with a recommendation you can act on. Discovery starts with a problem space and ends with a scoped plan for building. One often leads to the other, and we scope them separately so the advice stays independent of the build.'],
            ['Can you work with our existing design team?', 'Yes, and that is the usual case. We work alongside your designers, researchers and product managers, and part of the output is a better way for them to work once we leave.'],
            ['How do you estimate effort without a specification?', 'Routes are sized with the engineers who would build them, using reference points from comparable work, explicit assumptions and a range rather than a single number. The assumptions are written down so the estimate can be corrected as each one is tested.'],
            ['Do you run accessibility audits?', 'Yes. A WCAG 2.2 AA audit combines automated checks with manual keyboard and screen-reader passes on the journeys that matter, and produces a prioritised backlog rather than a list of violations. Conformance is a statement you publish about your product; no one issues a certificate for it.'],
            ['What if the honest recommendation is to do nothing?', 'Then that is what the report says, with the reasoning and the conditions that would change it. An assessment that can only ever recommend a project is not worth commissioning.'],
        ],
        'pairs'     => ['product-strategy-vision', 'system-design'],
        'img'       => ['src' => 'assets/imgs/product/shared/design-consulting-solutioning.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'Two colleagues compare options across a wall of sticky notes in a studio', 'pos' => '50% 45%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['figma', 'miro', 'notion', 'confluence', 'jira', 'linear', 'storybook', 'lighthouse', 'googleanalytics', 'posthog', 'mixpanel', 'playwright'],
        'standards' => ['wcag22', 'cwv', 'iso9001', 'gdpr', 'dpdp'],
    ],

    'product-strategy-vision' => [
        'n'          => '02',
        'slug'       => 'product-strategy-vision',
        'name'       => 'Product Strategy & Vision',
        'short'      => 'Strategy',
        'kicker'     => 'What to build next',
        'title'      => '<span class="g">A roadmap is a list of dates.</span> A strategy says what you are betting on.',
        'lead'       => 'Product Strategy & Vision finds the product experiences worth building next, tests them against real demand and real capability, and turns them into a sequence your teams can run with measures already attached.',
        'meta'       => ['6–10 weeks', 'Research-led', 'Measured against a baseline'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Approach', 'Standard'],
        'cta'        => 'Start a product strategy brief',
        'icon'       => 'target',
        'offer_title'=> '<span class="g">From an opportunity list</span> to a sequence with owners',
        'offer_lead' => 'Opportunities are scored on evidence of demand, feasibility and fit, then sequenced so each release makes the next one cheaper.',
        'offer' => [
            ['Product discovery',            'Customer interviews, support and sales data, product analytics and win–loss evidence read together, so the unmet need is found before a solution is argued for.', 'Evidence first', 'search'],
            ['Opportunity mapping',          'Needs, pains and jobs arranged as an opportunity tree, so ideas are judged against the outcome they serve rather than against each other.', 'Opportunity tree', 'git-branch'],
            ['Product vision & north star',  'One articulation of where the product is going, the north star metric and the three or four inputs that move it, written so a team can use it to say no.', 'Vision · north star', 'flag'],
            ['Business case',                'The value case for each bet: who pays, what it displaces, what it costs to build and to run, and the packaging questions it raises.', 'Value · cost · packaging', 'cost'],
            ['Roadmap & sequencing',         'Now, next and later, ordered by evidence and dependency, with the assumption each bet rests on stated in the open.', 'Now · next · later', 'calendar'],
            ['Vision prototype',             'A high-fidelity prototype or short film of the future product, used to align leadership and test the idea with customers before a line of production code exists.', 'Concept · alignment', 'sparkle'],
        ],
        'process' => [
            'title' => '<span class="g">Ten weeks,</span> four questions closed',
            'lead'  => 'Each phase settles one question. Nothing carries forward that the evidence did not support.',
            'steps' => [
                ['Listen',   'Wk 01–03', 'Customers, lost deals, support tickets, product analytics and the teams closest to the work. Demand evidence gathered before any solution is discussed.', ['Research plan', 'Interview findings', 'Demand evidence']],
                ['Map',      'Wk 03–05', 'Opportunities structured and sized, the current product assessed against them, and the capability gaps that matter named.', ['Opportunity map', 'Capability gaps', 'Sizing model']],
                ['Shape',    'Wk 05–08', 'The leading bets shaped into concepts and a vision prototype, tested with customers and sized with engineering.', ['Concepts', 'Vision prototype', 'Test findings']],
                ['Sequence', 'Wk 08–10', 'A vision, a north star metric and a sequenced roadmap with owners, measures and the assumptions still to be proven.', ['Product vision', 'North star & inputs', 'Sequenced roadmap']],
            ],
        ],
        'deliver' => [
            ['Product vision',                            'One page · Deck'],
            ['Opportunity map & evidence pack',           'Board · Sheet'],
            ['North star metric & input tree',            'Sheet · Dashboard'],
            ['Business case per bet',                     'Model · Sheet'],
            ['Sequenced roadmap · now / next / later',    'Roadmap · Board'],
            ['Vision prototype',                          'Figma · film'],
            ['Assumption & experiment backlog',           'Sheet'],
        ],
        'outcomes' => [
            ['A reason for every item',              'Each roadmap entry traces back to an opportunity and the evidence behind it, so priority calls stop being a contest of seniority.'],
            ['Alignment that survives the quarter',  'One vision and one metric, understood the same way by product, design, engineering and the board.'],
            ['Bets sized before they are made',      'Cost, effort and the assumption most likely to break, all named before a team is assigned.'],
        ],
        'faq' => [
            ['How is this different from writing a roadmap?', 'A roadmap says what and when. A strategy says why those and not the alternatives, what has to be true for each to work, and what you will stop doing. We produce both, in that order.'],
            ['Do you work from our data or gather new research?', 'Both. Analytics, support tickets, CRM and win–loss data show what is happening; interviews show why. Neither on its own justifies a year of engineering.'],
            ['What is a north star metric, and can we have more than one?', 'A north star is the single measure that best proxies the value customers get, with three or four input metrics a team can actually move. One per product is the point of it. A second is usually a sign the product is really two.'],
            ['Who owns the roadmap afterwards?', 'Your product leadership. We write it with them and hand over the model, the evidence and the assumption backlog. A standing quarterly review can be agreed if it helps the plan stay current.'],   // PLACEHOLDER: confirm review cadence before launch
            ['Can this run alongside an existing delivery team?', 'Yes. Strategy work runs in parallel with delivery on a short feedback loop, so what the team learns shipping this quarter reshapes what is planned for the next.'],
        ],
        'pairs'     => ['design-consulting-solutioning', 'experience-design-development'],
        'img'       => ['src' => 'assets/imgs/product/shared/product-strategy-vision.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A product team stands at a board of notes during a planning session', 'pos' => '50% 40%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['figma', 'miro', 'notion', 'confluence', 'jira', 'linear', 'posthog', 'mixpanel', 'googleanalytics', 'looker', 'hubspot', 'salesforce'],
        'standards' => ['wcag22', 'gdpr', 'dpdp', 'iso9001'],
    ],

    'experience-design-development' => [
        'n'          => '03',
        'slug'       => 'experience-design-development',
        'name'       => 'Experience Design & Development',
        'short'      => 'Experience',
        'kicker'     => 'Designed, tested, built',
        'title'      => '<span class="g">Opinions are cheap.</span> Put it in front of someone.',
        'lead'       => 'Experience Design & Development takes an idea through research, interaction design and a working front end in short, rigorous loops. Each loop ends with something a real user can try, so the expensive decisions are made on evidence rather than on taste.',
        'meta'       => ['8–16 weeks', 'Research · design · front end', 'WCAG 2.2 AA'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Scope', 'Standard'],
        'cta'        => 'Start an experience brief',
        'icon'       => 'browser',
        'offer_title'=> '<span class="g">Six practices,</span> one loop',
        'offer_lead' => 'Research, design, content and front-end engineering run in the same fortnight rather than in a relay, so what is designed is what ships.',
        'offer' => [
            ['User research & usability testing', 'Moderated and unmoderated sessions, diary studies and benchmark tests, run on a cadence rather than once at the end.', 'Continuous discovery', 'users'],
            ['Information architecture & journeys','Navigation, taxonomy and end-to-end journeys across channels, validated with tree testing and first-click studies.', 'IA · journeys', 'network'],
            ['Interaction & interface design',   'Screens, states and motion designed in your design system, including the empty, loading, error and offline states most work forgets.', 'Every state', 'layers'],
            ['Content & UX writing',             'The words in the interface written with the design: labels, guidance, errors and confirmations that read the same in every locale.', 'Microcopy · clarity', 'doc'],
            ['Prototyping',                      'From clickable flows to coded prototypes on live data, at whatever fidelity the open question needs.', 'Click · coded', 'bolt'],
            ['Front-end build & design QA',      'Accessible, performant front-end code built from the same components, with visual and accessibility regression tests in CI and a design QA pass before release.', 'React · WCAG 2.2 AA', 'code'],
        ],
        'process' => [
            'title' => '<span class="g">Two-week loops,</span> each ending in evidence',
            'lead'  => 'Every loop carries one question, one thing to try and a session with users. The backlog is rewritten by what comes back.',
            'steps' => [
                ['Understand', 'Wk 01–02', 'Existing research, analytics and support data reviewed, participants recruited, and a benchmark taken of the journey being changed.', ['Research plan', 'Baseline benchmark', 'Participant panel']],
                ['Design',     'Wk 02–08', 'Journeys, screens and content designed in the system, prototyped and tested every fortnight. Accessibility reviewed at design, not after.', ['Journey maps', 'Interface designs', 'Test findings']],
                ['Build',      'Wk 06–14', 'Front-end engineering alongside design, with components contributed back to the design system and automated accessibility and visual checks on every merge.', ['Front-end code', 'Component contributions', 'CI checks']],
                ['Validate',   'Wk 14–16', 'A release behind a flag, the benchmark repeated, and task success, time on task and error rate read against the baseline.', ['Release', 'Benchmark comparison', 'Improvement backlog']],
            ],
        ],
        'deliver' => [
            ['Research plan, findings & session clips', 'Report · clips'],
            ['Journey maps & information architecture', 'Figma'],
            ['Interface designs with every state',      'Figma'],
            ['UX copy & content guidelines',            'Doc · Figma'],
            ['Prototypes',                              'Figma · coded'],
            ['Front-end code & components',             'Your repos · Storybook'],
            ['Accessibility report & fixes',            'WCAG 2.2 AA'],
            ['Usability benchmark',                     'Sheet · Dashboard'],
        ],
        'outcomes' => [
            ['Decisions backed by sessions', 'Every significant change was watched with users before it shipped, and the recording exists to settle the argument later.'],
            ['Usable by more people',        'Keyboard, screen-reader, contrast and target-size checks run in the same pipeline as the tests, so accessibility does not regress quietly.'],
            ['Design that survives the build','Designers and front-end engineers in one loop, so what is drawn and what ships are the same thing.'],
        ],
        'faq' => [
            ['How many users do you need to test with?', 'Five to eight participants per round finds most usability problems in a single journey, which is why we run many small rounds rather than one large study. Benchmarks and preference tests need larger quantitative samples, and we say which kind we are running and why.'],
            ['Do you design in our design system or make a new one?', 'In yours where one exists, contributing the missing components back to it. Where there is none, we build the parts this work needs and hand them over as the start of one, which is where System Design picks up.'],
            ['Do you write front-end code or hand over designs?', 'Either. Handover includes designs, tokens, every state and acceptance criteria. When we build, it is accessible front-end code in your repositories, reviewed by your engineers.'],
            ['How do you handle accessibility?', 'WCAG 2.2 AA is the working standard: contrast and target sizes checked at design, automated checks on every merge, and manual keyboard and screen-reader passes on each key journey before release. Where it matters, we also test with disabled participants.'],
            ['How do you know the new experience is better?', 'From a benchmark taken before the work starts: task success rate, time on task, error rate and a standard usability measure such as SUS or UMUX-Lite, repeated after release and read alongside the product analytics.'],
        ],
        'pairs'     => ['system-design', 'product-strategy-vision'],
        'img'       => ['src' => 'assets/imgs/product/shared/experience-design-development.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A designer sketches interface flows on paper beside an open laptop', 'pos' => '50% 50%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['figma', 'storybook', 'react', 'nextdotjs', 'typescript', 'tailwindcss', 'playwright', 'cypress', 'lighthouse', 'posthog', 'mixpanel', 'miro', 'notion'],
        'standards' => ['wcag22', 'cwv', 'iso9001', 'gdpr', 'dpdp'],
    ],

    'ai-product-strategy-development' => [
        'n'          => '04',
        'slug'       => 'ai-product-strategy-development',
        'name'       => 'AI Product Strategy & Development',
        'short'      => 'AI Product',
        'kicker'     => 'AI people keep using',
        'title'      => '<span class="g">The model is not the product.</span> The experience around it is.',
        'lead'       => 'AI Product Strategy & Development decides where AI belongs in your product and builds it: the interaction patterns, the disclosure, the controls and the evaluation loop that decide whether an AI feature is still used in week four.',
        'meta'       => ['4-week concept · 12-week build', 'Design-led AI delivery', 'Evaluated with users'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Approach', 'Standard'],
        'cta'        => 'Start an AI product brief',
        'icon'       => 'sparkle',
        'offer_title'=> '<span class="g">Designed for the times</span> the model is wrong',
        'offer_lead' => 'Every feature is designed around its failure modes first: what the person sees when confidence is low, how they correct it, and what the product learns from the correction.',
        'offer' => [
            ['AI opportunity mapping',        'The journey read for the moments where AI removes real effort, and the ones where it only adds another box to type in.', 'Journey-led', 'search'],
            ['AI interaction patterns',       'Streaming, citations, confidence, suggestion against action, undo and escalation to a person: chosen per task and added to your design system.', 'Patterns · design system', 'layers'],
            ['Prototyping on live models',    'Prototypes wired to real models and your own content, so the concept is judged on what the model actually returns rather than on a scripted demo.', 'Real outputs', 'bolt'],
            ['Evaluation with users',         'Task-level eval sets agreed with your experts, plus preference and trust testing with the people who will use the feature.', 'Evals · preference tests', 'eval'],
            ['Trust, transparency & control', 'Clear disclosure that output is AI-generated, sources shown, results editable, an obvious way back, and a log of what the system did.', 'Disclosure · audit log', 'shield'],
            ['AI feature delivery',           'The feature built with your engineers: retrieval or tool plumbing, guardrails, human approval steps, feedback capture and quality monitoring.', 'Shipped · monitored', 'agent'],
        ],
        'process' => [
            'title' => '<span class="g">A concept in four weeks,</span> a feature people keep using',
            'lead'  => 'The prototype meets a real model in week two. What it gets wrong there shapes the interface, not the launch note.',
            'steps' => [
                ['Frame',     'Wk 01–02', 'The task, the people doing it today, the cost of a wrong answer and the data available. Success measures and a first evaluation set drafted with your experts.', ['Use-case brief', 'Eval set v1', 'Risk classification']],
                ['Prototype', 'Wk 02–04', 'Interaction patterns drawn and wired to live models on real content, then tested for usefulness, trust and what people do when the answer is wrong.', ['Live prototype', 'Test findings', 'Pattern decisions']],
                ['Build',     'Wk 04–12', 'Built with engineering: retrieval or tools, guardrails, approval steps and feedback capture, with evaluation thresholds gating the release.', ['Production feature', 'Guardrails', 'Eval gate']],
                ['Improve',   'Wk 12+',   'Staged rollout, adoption and correction rates watched, the eval set grown from real traffic, and the patterns fed back into the design system.', ['Rollout', 'Quality dashboard', 'Pattern updates']],
            ],
        ],
        'deliver' => [
            ['AI opportunity map across the journey', 'Board · Figma'],
            ['AI interaction pattern set',            'Figma · Storybook'],
            ['Prototype on live models',              'Coded prototype'],
            ['Evaluation set & results',              'Datasets · report'],
            ['Trust & disclosure guidelines',         'Document'],
            ['Production AI feature',                 'Source · your cloud'],
            ['Adoption & quality dashboard',          'Dashboard'],
        ],
        'outcomes' => [
            ['Used past the novelty week',   'Adoption measured after the launch spike, alongside correction, abandonment and escalation rates.'],
            ['Wrong answers handled well',   'Low confidence, missing sources and refusals designed as states, so a mistake is recoverable rather than alarming.'],
            ['Governed from the first sketch','Risk tier, disclosure, human oversight and logging decided during design, which is where transparency duties are cheapest to meet.'],
        ],
        'faq' => [
            ['How is this different from the AI work in Technology & Intelligence?', 'The same systems, approached from opposite ends. Technology & Intelligence engineers the models, retrieval, agents and infrastructure. This capability designs the product around them: where AI belongs in the journey, what the person sees, and how the feature is evaluated with real users. Most AI products need both, and the two teams work as one.'],
            ['What makes an AI feature feel trustworthy?', 'Saying plainly that it is AI, showing where the answer came from, making the result editable, keeping an obvious undo, and never taking a consequential action without a person approving it. Trust is a set of interface decisions, not a tone of voice.'],
            ['Can the output follow our brand voice?', 'Yes, where a brand voice exists. Tone, vocabulary and prohibited phrasing become part of the system prompt and part of the evaluation set, so the output is checked against them rather than hoped for.'],
            ['How do you test something that answers differently every time?', 'With eval sets rather than fixed expected strings: graded criteria per task, scored automatically and calibrated against human review, run over many inputs so the result is a distribution rather than a single pass or fail. Preference and trust tests with users sit on top of that.'],
            ['Does the EU AI Act affect a feature like this?', 'It can, including for organisations outside the EU when the system is placed on the EU market or its output is used there. Most product features sit in the transparency tier, which asks mainly that people are told they are interacting with AI and that generated content is marked. We classify the use case early and design the notices in rather than bolting them on.'],
        ],
        'pairs'     => ['experience-design-development', 'product-strategy-vision'],
        'img'       => ['src' => 'assets/imgs/product/shared/ai-product-strategy-development.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A designer tests an assistant interface on a laptop at a studio desk', 'pos' => '50% 45%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['figma', 'anthropic', 'openai', 'googlegemini', 'langgraph', 'llamaindex', 'python', 'typescript', 'react', 'nextdotjs', 'storybook', 'posthog', 'playwright'],
        'standards' => ['eu-ai-act', 'nist-ai-rmf', 'iso42001', 'owasp-llm', 'wcag22', 'gdpr', 'dpdp'],
    ],

    'system-design' => [
        'n'          => '05',
        'slug'       => 'system-design',
        'name'       => 'System Design',
        'short'      => 'Systems',
        'kicker'     => 'Built to grow',
        'title'      => '<span class="g">Ten screens is a design.</span> A thousand is a system.',
        'lead'       => 'System Design structures how a product’s parts fit together: tokens, components, patterns and the rules that hold them, in design and in code, so a new surface is assembled rather than redrawn.',
        'meta'       => ['8–16 weeks to v1', 'Figma · code · docs', 'Accessible by default'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical build', 'Scope', 'Standard'],
        'cta'        => 'Start a system brief',
        'icon'       => 'cube',
        'offer_title'=> '<span class="g">One system,</span> every surface it has to serve',
        'offer_lead' => 'Foundations are defined once and consumed everywhere: web, mobile, email and whatever the product adds next.',
        'offer' => [
            ['Foundations & design tokens',        'Colour, type, space, radius, elevation and motion held as tokens in one source of truth and exported to each platform, rather than copied between files.', 'Tokens · one source', 'stack'],
            ['Component library in code',          'Components built once with their states, keyboard behaviour and ARIA, published as a versioned package and documented in Storybook.', 'Versioned package', 'code'],
            ['Multi-brand & multi-platform theming','One component set themed for several brands, products or markets, with the differences held in tokens instead of forks.', 'Themes, not forks', 'layers'],
            ['Accessibility inside the components','Focus order, target size, contrast and screen-reader behaviour solved in the component, so every team that uses it inherits the fix.', 'WCAG 2.2 AA', 'accessibility'],
            ['Documentation & contribution',       'Usage guidance, do and do not, and a contribution path with review, so the system grows with the product instead of being worked around.', 'Docs · contribution', 'doc'],
            ['Adoption, versioning & migration',   'Semantic versioning, deprecation notices, codemods where they earn their keep, and an adoption measure per product team.', 'Adoption measured', 'sync'],
        ],
        'process' => [
            'title' => '<span class="g">Audit, build, adopt.</span> Then keep it alive.',
            'lead'  => 'The system is built from the screens you already have, so the first release covers most of the product on the day it lands.',
            'steps' => [
                ['Audit',  'Wk 01–03', 'Every existing screen and component inventoried, duplicates collapsed, and the accidental inconsistencies separated from the deliberate ones.', ['Interface inventory', 'Duplication report', 'Scope for v1']],
                ['Define', 'Wk 03–06', 'Tokens, naming, structure and the first components agreed across design and engineering, with accessibility acceptance criteria written per component.', ['Token set', 'Naming & structure', 'Component specs']],
                ['Build',  'Wk 05–14', 'Design library and code package built together, documented in Storybook, and covered by visual regression and accessibility tests in CI.', ['Figma library', 'Code package', 'Storybook docs']],
                ['Adopt',  'Wk 12–16', 'One pilot team migrated first, then the rest, with office hours, a contribution path and an adoption measure per team.', ['Migration plan', 'Contribution model', 'Adoption dashboard']],
            ],
        ],
        'deliver' => [
            ['Interface inventory & audit',        'Sheet · Figma'],
            ['Design tokens',                      'JSON · platform exports'],
            ['Figma library',                      'Figma'],
            ['Component package in code',          'Your repos · package'],
            ['Documentation site',                 'Storybook'],
            ['Accessibility acceptance criteria',  'Per component'],
            ['Versioning & contribution model',    'Docs'],
            ['Adoption dashboard',                 'Dashboard'],
        ],
        'outcomes' => [
            ['New screens in hours',          'Common surfaces assembled from components that already carry their states, their keyboard behaviour and their accessibility.'],
            ['One fix, everywhere',           'A contrast or focus bug is fixed in the component and inherited by every product that consumes it.'],
            ['A system that is actually used','Adoption measured per team, and a contribution path that makes joining in cheaper than working around it.'],
        ],
        'faq' => [
            ['How is this different from Brand Systems in Brand Design?', 'Brand Systems governs how the brand behaves across every channel: expression, rules, assets and tone. System Design is the product’s structural layer: tokens, components, states and versioning, in design and in code. The brand system sets the constants; this consumes them and makes them buildable.'],
            ['Do we need a design system at our size?', 'If one team ships one product, probably not yet, and a small kit of patterns is enough. It earns its cost once several teams or several surfaces have to look and behave the same, or when the same accessibility fix keeps being made in more than one place.'],
            ['Figma library or code package?', 'Both, or it is not a system. A Figma library on its own drifts from production within a quarter. The token set is the contract between them, exported to each platform from one source.'],
            ['Which framework do you build components in?', 'Usually React with TypeScript, with tokens exported for iOS and Android. Web components are an option when several frameworks have to consume the same library. The choice follows your products, not our preference.'],
            ['Who maintains the system afterwards?', 'Your team, with a named owner, a contribution path and documentation, or ours on a retainer while the in-house team forms. Either way the versioning, release and deprecation process is part of the handover.'],
        ],
        'pairs'     => ['experience-design-development', 'design-consulting-solutioning'],
        'img'       => ['src' => 'assets/imgs/product/shared/system-design.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A grid of interface components laid out across a large studio monitor', 'pos' => '50% 50%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['figma', 'storybook', 'react', 'typescript', 'tailwindcss', 'nextdotjs', 'github', 'githubactions', 'playwright', 'jest', 'swift', 'kotlin', 'notion', 'jira'],
        'standards' => ['wcag22', 'cwv', 'iso9001'],
    ],
];
