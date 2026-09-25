<?php
/* DRAFT COPY — review before launch.
 * =====================================================================================================
 * THE JOURNAL FILE — everything /blog and every post page shows comes from here
 * =====================================================================================================
 *
 * <!-- PLACEHOLDER: replace with real posts before launch. Every entry below is written in-house as a
 *      design and typography proof. The two case studies are illustrations: no client is named, no
 *      number below is a client result, and each seed post carries a visible placeholder note on the
 *      page until it is replaced. -->
 *
 * -----------------------------------------------------------------------------------------------------
 * HOW TO ADD A POST  (two steps, no PHP knowledge needed)
 * -----------------------------------------------------------------------------------------------------
 * 1. Append ONE entry to the 'posts' list below. Copy an existing entry from its opening `'<slug>' => [`
 *    to its closing `],`, paste it at the end of the list, and edit the values. Keep every `'key' =>`
 *    name as it is; change only what comes after `=>`. Text goes in single quotes; write an apostrophe
 *    as the curly ’ (as in “doesn’t”) — that is what the rest of the site uses and it needs no escaping.
 * 2. Create ONE file, blog/<slug>.php, with three lines:
 *
 *        <?php $blog_slug = '<slug>';
 *        require __DIR__ . '/../partials/blog/post.php';
 *
 *    That is the whole page. Copy blog/evals-before-agents.php and change the slug.
 *
 * Until that file exists the post still appears in the index — as an unlinked entry marked “page
 * pending”, so nothing on the site ever points at a page that is not there.
 *
 * Photographs go in assets/imgs/blog/ with a row each in assets/imgs/blog/CREDITS.md.
 *
 * -----------------------------------------------------------------------------------------------------
 * THE FIELDS
 * -----------------------------------------------------------------------------------------------------
 * REQUIRED
 *   'type'        'article' or 'case-study'. Articles render as a reading page with a table of contents;
 *                 case studies render as a dossier with a fixed spine. Both use the same components.
 *   'title'       the headline. Sentence case, no full stop.
 *   'dek'         one or two sentences under the headline. The standfirst.
 *   'date'        'YYYY-MM-DD', the day it was published.
 *   'desk'        one key from 'desks' below — the practice that wrote it.
 *   'disciplines' one or more discipline slugs from data/site.php.
 *   'tags'        two to five keys from 'tags' below.
 *   'cover'       ['file' => 'name.jpg' in assets/imgs/blog/, 'alt' => what is in the picture,
 *                  'w' =>, 'h' =>, 'credit' => 'photographer', 'pos' => '50% 50%' (optional crop centre)]
 *   'body'        the post itself, as a list of blocks. See THE BLOCKS below.
 *
 * OPTIONAL — leave it out and that part simply does not render
 *   'featured'    true on ONE entry: the lead item on /blog.
 *   'industry'    one key from 'industries' below. Required in practice for a case study.
 *   'updated'     'YYYY-MM-DD' if it has been revised since publication.
 *   'placeholder' a sentence shown in a visible note at the top of the post. Use it on any seed post.
 *   'series'      a key from 'paths' below — the reading path this post belongs to.
 *   'case'        the case-study spine. Required when 'type' is 'case-study'; ignored otherwise:
 *                   'sector'      one line naming the sector only. Never the client.
 *                   'shape'       the shape of the team, e.g. 'One squad, three disciplines'
 *                   'duration'    a typical range ('5–7 months'), never a precise promise
 *                   'stage'       where it ran, e.g. 'Discovery → build → run'
 *                   'problem'     2–3 paragraphs on what was actually wrong
 *                   'constraints' [label, why it could not be moved] — the things we could not change
 *                   'movements'   [n, title, text, 'disciplines' => [slug…], 'artifacts' => […]]
 *                   'matrix'      discipline slug => [what that discipline did, weight 1–3]
 *                   'changed'     [measure, its definition, how it is read] — MEASURES, never results
 *                   'owns'        [artifact, what it is, where it lives] — the handover
 *                   'call'        [heading, paragraph] — the judgement call that shaped the programme
 *                   'result'      the outcome. LEAVE EMPTY until the client has approved the exact
 *                                 wording and the number; empty renders the honest “pending” note.
 *
 * -----------------------------------------------------------------------------------------------------
 * THE BLOCKS — 'body' is a list; each block is [type, value]
 * -----------------------------------------------------------------------------------------------------
 *   ['lede',  'text']                     the opening paragraph, set larger. Use once, first.
 *   ['h',     'Heading']                  a section heading. Every one of these enters the contents list.
 *   ['p',     'text']                     a paragraph. Markup allowed: *emphasis*, `code`, [text](url).
 *   ['ul',    ['item', …]]                a bulleted list.
 *   ['ol',    ['item', …]]                a numbered list.
 *   ['steps', [[ 'title', 'text' ], …]]   numbered steps with a title each.
 *   ['defs',  [[ 'term', 'definition' ], …]]
 *   ['quote', ['words', 'who or what it is attributed to']]      a pull quote.
 *   ['fig',   ['file','alt','w','h','caption','credit','wide' => true (optional)]]
 *   ['code',  ['title','lang','lines' => ['…'], 'note']]         a code or config block.
 *   ['data',  ['title','note','head' => [...], 'rows' => [[…]]]] a table. First column is the row header.
 *   ['note',  ['kind' => 'info'|'check'|'warn', 'title', 'text']]
 *   ['key',   ['title', 'items' => [ … ]]]                       the takeaways panel.
 *   ['formula', ['expr','note','terms' => [[ 'symbol', 'meaning' ], …]]]
 *   ['stack', ['slug', …]]                technologies, by data/tech-stack.php slug.
 *   ['badges',['key', …]]                 frameworks, by partials/tech/kit.php xt_standards() key.
 *   ['links', [[ 'label', 'page.php', 'one line about it' ], …]]  onward links to pages on this site.
 * =====================================================================================================
 */

return [

    /* ---- taxonomy ------------------------------------------------------------------------------- */

    'types' => [
        'article'    => ['name' => 'Article',    'plural' => 'Articles',     'short' => 'Article',
                         'line' => 'A written argument, with the working shown.'],
        'case-study' => ['name' => 'Case study', 'plural' => 'Case studies', 'short' => 'Case',
                         'line' => 'One programme, from the problem to what the client kept.'],
    ],

    /* the same six sector keys the Work index uses, so a reader filtering one filters the other the same way */
    'industries' => [
        'consumer-health'    => 'Consumer health',
        'financial-services' => 'Financial services',
        'retail-commerce'    => 'Retail & commerce',
        'b2b-technology'     => 'B2B technology',
        'hospitality'        => 'Hospitality',
        'telecom-media'      => 'Telecom & media',
    ],

    'tags' => [
        'evals'          => 'Evals',
        'agents'         => 'Agents',
        'governance'     => 'Governance',
        'performance'    => 'Performance',
        'measurement'    => 'Measurement',
        'search'         => 'Search',
        'architecture'   => 'Architecture',
        'sustainability' => 'Sustainability',
        'accessibility'  => 'Accessibility',
        'delivery'       => 'Delivery',
    ],

    /* Bylines are practices, not people.
       <!-- PLACEHOLDER: replace each desk byline with the named author and their role before launch. --> */
    'desks' => [
        'technology' => [
            'name'       => 'Technology & Intelligence desk',
            'mark'       => 'T&I',
            'discipline' => 'technology-intelligence',
            'line'       => 'Engineers and architects who build and run the platforms. They write about what they had to change their minds about.',
        ],
        'product' => [
            'name'       => 'Product & Experience desk',
            'mark'       => 'P&E',
            'discipline' => 'product-experience',
            'line'       => 'Product and interaction designers. They write about decisions made before anything is built.',
        ],
        'marketing-technology' => [
            'name'       => 'Marketing Technology desk',
            'mark'       => 'MT',
            'discipline' => 'marketing-technology',
            'line'       => 'The people who join data, content and channels into one operating system. They write about the plumbing.',
        ],
    ],

    /* Reading paths — a curated order through the journal. A post joins one with 'series' => '<key>'. */
    'paths' => [
        'ship-ai' => [
            'name'  => 'Before you ship an AI feature',
            'line'  => 'What has to exist before a model touches a customer: a golden set, a gate, a named human, and a log that survives an audit.',
            'order' => ['evals-before-agents', 'triage-with-a-human-in-every-loop'],
        ],
        'fast-front' => [
            'name'  => 'Fast where it actually matters',
            'line'  => 'Speed measured on the phones people own, on the networks they have, at the percentile that decides whether they stay.',
            'order' => ['core-web-vitals-are-field-data', 'search-rebuilt-around-real-queries'],
        ],
        'run-cleaner' => [
            'name'  => 'Run it for less, and cleaner',
            'line'  => 'Cost and carbon as engineering inputs rather than a report written after the fact.',
            'order' => ['the-carbon-cost-of-a-request'],
        ],
    ],

    /* ---- posts, newest first -------------------------------------------------------------------- */

    'posts' => [

    /* ============================================================================================= */
    'evals-before-agents' => [
        'type'        => 'article',
        'featured'    => true,
        'title'       => 'Evals before agents',
        'dek'         => 'A demonstration proves a model can do something once. An evaluation suite proves it will keep doing it after the prompt changes, the index is rebuilt and someone new joins the team.',
        'date'        => '2026-09-08',
        'desk'        => 'technology',
        'disciplines' => ['technology-intelligence', 'ai-design'],
        'industry'    => 'b2b-technology',
        'series'      => 'ship-ai',
        'tags'        => ['evals', 'agents', 'governance', 'delivery'],
        'placeholder' => 'Seed post. The writing is ours and the technical content is current, but this is published here as a design proof — replace it with a real article before launch.',
        'cover'       => ['file' => 'evals-review.jpg', 'w' => 1800, 'h' => 1013, 'pos' => '50% 42%',
                          'alt'  => 'Two people at a desk reviewing work on a laptop screen together.',
                          'credit' => 'shamin-haky'],
        'body' => [
            ['lede', 'Most AI features are approved on the strength of a demonstration. Someone types a question, the answer is good, the room nods. That is a sample size of one, taken under the best conditions anyone could arrange, by the person with the most to gain from it working. It tells you almost nothing about Tuesday.'],

            ['h', 'A demo is a sample of one'],
            ['p', 'The gap between a demo and a feature is not model quality. It is variance. The same prompt against the same model returns different text on different days, and the retrieval layer underneath it is changing constantly: documents are added, chunking is re-tuned, an embedding model is upgraded, someone rewrites a system prompt to fix an unrelated complaint. Each of those is a silent release. Without a measurement that runs on every one of them, nobody finds out what broke until a customer does.'],
            ['p', 'The fix is old and unglamorous. Write down what good looks like, as cases. Run them on every change. Refuse to ship when they fail. This is the same discipline that made continuous integration work for ordinary software, applied to a component whose output is a distribution rather than a value.'],

            ['quote', ['A model you cannot measure is a model you cannot change. Every improvement after that point is a guess with a release note attached.', 'Technology & Intelligence desk']],

            ['h', 'The golden set is the product'],
            ['p', 'A golden set is a fixed, versioned collection of inputs with the behaviour each one should produce. Not the exact words — the behaviour. For a support assistant, a case might say: given this question and this account state, the answer must cite the refund policy document, must not promise a refund, and must offer to open a ticket.'],
            ['p', 'Three properties make a golden set worth having. It is versioned in the same repository as the code, so a change to the cases is reviewed like a change to a function. It is built from real traffic rather than imagination — sampled, anonymised, and labelled by someone who does the job for a living. And it is deliberately unbalanced towards the cases that hurt: the ambiguous question, the out-of-scope request, the one where the honest answer is “I don’t know”.'],
            ['ul', [
                'Sample from real logs, then anonymise. Invented questions cluster around what the team already knows works.',
                'Label with the people who answer these questions today, not with the team building the feature.',
                'Keep a refusal set: inputs where the correct behaviour is to decline, escalate or ask a clarifying question.',
                'Keep an adversarial set: prompt injection, data exfiltration attempts, and instructions hidden in retrieved documents.',
                'Freeze it. A golden set that is edited whenever it fails is a mirror, not a measure.',
            ]],

            ['fig', ['file' => 'fig-review-wall.jpg', 'w' => 1400, 'h' => 934, 'wide' => true,
                     'alt' => 'A team standing at a wall of notes, working through a problem together.',
                     'caption' => 'Labelling is the expensive part, and the part that cannot be delegated to the model. The people who answer these questions today decide what a good answer is.',
                     'credit' => 'thisisengineering']],

            ['h', 'Four numbers that decide a release'],
            ['p', 'A retrieval-augmented feature has two failure modes that look identical to a user: it fetched the wrong thing, or it fetched the right thing and ignored it. Measuring them separately is what makes the difference between fixing the problem and rewriting the prompt until the symptom moves.'],
            ['data', [
                'title' => 'The gate, for a retrieval-augmented assistant',
                'note'  => 'Thresholds are illustrative starting points. Each one is set with the client before launch, against their own golden set, and is only comparable to itself.',
                'head'  => ['Measure', 'What it answers', 'Where it fails', 'Typical gate'],
                'rows'  => [
                    ['Context recall', 'Did retrieval return the passages needed to answer?', 'Chunking, embeddings, the query rewrite', '≥ 0.90'],
                    ['Faithfulness', 'Is every claim in the answer supported by the retrieved passages?', 'The prompt, the model, the context window', '≥ 0.95'],
                    ['Answer relevance', 'Does the answer address the question that was asked?', 'Query understanding, over-eager templates', '≥ 0.90'],
                    ['Refusal accuracy', 'Does it decline when it should, and only then?', 'Guardrails tuned too tight or too loose', '≥ 0.98'],
                ],
            ]],
            ['p', 'Two more belong beside them, because they decide whether the feature survives contact with a finance director: cost per resolved request, and p95 latency. A quality gain bought with a four-fold cost increase is a decision, not an improvement, and it should reach the person who gets to make it.'],
            ['note', ['kind' => 'warn', 'title' => 'Small sets lie confidently',
                      'text'  => 'On 150 cases, a pass rate of 95% carries a 95% confidence interval of roughly ±3.5 points. A run that moves from 95% to 97% has told you nothing. Compare paired runs on the same fixed set, report the interval beside the number, and treat anything inside it as noise.']],

            ['h', 'Prompt injection is an input problem'],
            ['p', 'The OWASP Top 10 for LLM Applications lists prompt injection as LLM01, and it stays there because it is not a bug to be patched. Any text the model reads is instruction-shaped: the user’s message, a retrieved document, a web page a tool fetched, the contents of a PDF someone attached. Treating retrieved content as data rather than instruction is a design decision that has to be made in the architecture, not in the prompt.'],
            ['ul' , [
                'Keep the system prompt out of reach and assume it leaks anyway (LLM07). Nothing secret belongs in it.',
                'Treat every model output as untrusted input to the next system (LLM05). Escape it, validate it, never pass it straight to a shell, a query or a renderer.',
                'Give the agent the narrowest tools that do the job, with their own permissions (LLM06). An agent that can read the billing API cannot be talked into writing to it.',
                'Put the adversarial cases in the golden set so the defence is measured on every release, not reviewed once.',
            ]],
            ['badges', ['iso42001', 'nist-ai-rmf', 'owasp-llm', 'mitre-atlas']],

            ['h', 'A named human, written into the flow'],
            ['p', '“Human in the loop” is usually a slide. Made concrete, it is four specifications: which decisions require approval, who is competent to give it, what they see when they are asked, and what happens when they do not respond in time. Only the last one is hard, and it is the one that gets skipped.'],
            ['steps', [
                ['Classify the action', 'Reversible and low-value actions run unattended. Anything that moves money, changes an entitlement, or speaks to a customer in the brand’s name goes to a person.'],
                ['Show the evidence, not the verdict', 'The reviewer sees the source passages, the confidence, the tools called and the draft — in that order. A reviewer shown only a recommendation will approve it.'],
                ['Set a timeout with a safe default', 'If nobody responds within the agreed window, the action does not happen and the request is queued. Silence must never be consent.'],
                ['Log it as a record', 'Input, retrieved context, model and version, tool calls, the draft, the reviewer, the decision, the timestamp. This is the artefact an auditor asks for, and it has to be written at the time.'],
            ]],

            ['h', 'What the gate looks like in practice'],
            ['p', 'The mechanism is ordinary. The suite runs in CI on every pull request that touches a prompt, a retrieval parameter, a model version or an index build. It writes a report the reviewer can read, and it fails the build when a gate is missed. Nightly, the same suite runs against production configuration, because the index changes without anyone opening a pull request.'],
            ['code', [
                'title' => 'evals.yaml — the shape, not a library',
                'lang'  => 'yaml',
                'lines' => [
                    'suite: support-assistant',
                    'golden_set: sets/support@v14.jsonl   # 150 cases, versioned with the code',
                    'runs: 3                              # same input, three samples — variance is the point',
                    '',
                    'gates:',
                    '  context_recall:    { min: 0.90 }',
                    '  faithfulness:      { min: 0.95 }',
                    '  answer_relevance:  { min: 0.90 }',
                    '  refusal_accuracy:  { min: 0.98 }',
                    '  p95_latency_ms:    { max: 2500 }',
                    '  cost_per_1k_usd:   { max: 1.20 }',
                    '',
                    'adversarial:',
                    '  set: sets/injection@v6.jsonl        # OWASP LLM01 cases',
                    '  gates: { blocked: 1.00 }            # one miss fails the build',
                    '',
                    'on_fail: block                        # no override without a named approver',
                ],
                'note' => 'Three runs per case, not one. A suite that samples once measures luck.',
            ]],
            ['p', 'The rule that makes it work is the boring one: no override without a name. An amber build can ship if a named person accepts the risk in writing, and that acceptance is part of the record. A build that can be waved through by anyone in a hurry is not a gate.'],

            ['h', 'Where this leaves the roadmap'],
            ['p', 'Teams often read this as a reason to delay. It is the opposite. The golden set is the smallest artefact that lets a team move quickly without fear, because it converts “does this seem better?” into a question with an answer. Most of the AI work we are asked to rescue does not need a better model. It needs a definition of correct that two people can agree on before anybody writes a prompt.'],
            ['key', ['title' => 'If you take four things from this',
                     'items' => [
                        'Build the golden set from real, anonymised traffic, and version it with the code.',
                        'Measure retrieval and generation separately, or you will keep fixing the wrong layer.',
                        'Put cost and p95 latency in the same gate as quality. They are release criteria too.',
                        'Write the human approval step down as a specification, including what happens on a timeout.',
                     ]]],
            ['links', [
                ['AI Strategy & Agents', 'services/technology-intelligence/ai-strategy-agents.php', 'Where AI fits, what to build first, and agents that do real work.'],
                ['AI Product & Automation', 'services/technology-intelligence/ai-product-automation.php', 'Retrieval, evaluation suites and automation in production.'],
                ['Cybersecurity & AI Trust', 'services/technology-intelligence/cybersecurity-ai-trust.php', 'Threat models, red-teaming and the governance that keeps it compliant.'],
            ]],
        ],
    ],

    /* ============================================================================================= */
    'core-web-vitals-are-field-data' => [
        'type'        => 'article',
        'title'       => 'Core Web Vitals are a field measurement, not a lab score',
        'dek'         => 'A green Lighthouse score on a developer’s laptop is a rehearsal. The numbers that decide whether a page feels fast come from the phones people actually own, at the 75th percentile, over a rolling 28 days.',
        'date'        => '2026-08-19',
        'desk'        => 'technology',
        'disciplines' => ['technology-intelligence', 'product-experience'],
        'industry'    => 'retail-commerce',
        'series'      => 'fast-front',
        'tags'        => ['performance', 'measurement', 'accessibility'],
        'placeholder' => 'Seed post, written in-house as a design proof. Replace with a real article before launch.',
        'cover'       => ['file' => 'field-data.jpg', 'w' => 1200, 'h' => 800, 'pos' => '50% 50%',
                          'alt'  => 'A person holding a phone, mid-transaction, in a shop.',
                          'credit' => 'blake-wisz'],
        'body' => [
            ['lede', 'Every performance argument we are brought into has the same shape. The lab score is green, the customer says the site is slow, and both are telling the truth. They are measuring different things, and only one of them is the thing that matters.'],

            ['h', 'Lab and field answer different questions'],
            ['p', 'A lab test — Lighthouse, WebPageTest, a CI run — is a controlled simulation. One device profile, one throttled network, a cold cache, no extensions, no third-party consent banner deciding to load a tag manager. It is repeatable, which makes it perfect for catching a regression in a pull request, and it is fictional, which makes it useless as evidence about your customers.'],
            ['p', 'Field data is the opposite. It is collected from real sessions on real devices — a four-year-old Android on a congested cell, a laptop with nine tabs open, someone on hotel wi-fi. It is noisy and slow to move, and it is the only measurement that answers the question anyone actually asked.'],
            ['data', [
                'title' => 'The three Core Web Vitals, at the thresholds Google publishes',
                'note'  => 'Assessed at the 75th percentile of page loads, segmented by mobile and desktop. A URL passes only when all three are in the good band.',
                'head'  => ['Metric', 'What it measures', 'Good', 'Poor'],
                'rows'  => [
                    ['LCP', 'Loading — when the largest content element in the viewport is rendered', '≤ 2.5 s', '> 4.0 s'],
                    ['INP', 'Responsiveness — the latency of interactions across the whole visit', '≤ 200 ms', '> 500 ms'],
                    ['CLS', 'Visual stability — the largest burst of unexpected layout shift', '≤ 0.1', '> 0.25'],
                ],
            ]],
            ['p', 'INP replaced First Input Delay in March 2024, and the change matters more than the acronym suggests. FID measured only the delay before the first interaction was handled — it could be excellent on a page that froze for two seconds every time someone opened a filter. INP looks at the full latency of interactions across the visit, which is far closer to what a person would describe as “laggy”.'],

            ['h', 'The 75th percentile is the whole argument'],
            ['p', 'An average hides the tail, and the tail is where the money goes. If a page loads in 1.2 seconds for three quarters of visitors and 6 seconds for the rest, the mean looks respectable and one visitor in four is having a bad time. The Chrome User Experience Report aggregates at p75 over a rolling 28-day window precisely so a single fast cohort cannot bury a slow one.'],
            ['note', ['kind' => 'info', 'title' => 'The 28-day window has a consequence',
                      'text'  => 'A fix deployed today does not show up in a CrUX-based dashboard for weeks, and only fully once the window has rolled over. Teams that judge a change on the first week of data usually conclude it did not work. Keep your own real-user monitoring beside CrUX so the feedback loop is hours, not a month.']],

            ['h', 'Take LCP apart before optimising it'],
            ['p', 'LCP is not one problem. It decomposes into four consecutive parts, and the fix for each is different. Measuring the split first is the difference between an afternoon and a quarter.'],
            ['defs', [
                ['Time to first byte', 'Server and network before anything arrives. Fixed with caching, a closer edge, a faster origin — not with image work.'],
                ['Resource load delay', 'The gap between the first byte and the browser starting to fetch the LCP resource. Usually a discovery problem: the image is in CSS, or behind JavaScript, or lazily loaded.'],
                ['Resource load duration', 'How long the LCP resource takes to download. Format, dimensions, compression, priority.'],
                ['Element render delay', 'The resource has arrived and the page still has not painted it. Almost always the main thread, blocked by script or a font swap.'],
            ]],
            ['p', 'In our experience the largest single win on content sites is load delay, and it is usually caused by well-meant laziness. The hero image gets `loading="lazy"` applied by a global rule, which delays the one image that must never be delayed.'],
            ['code', [
                'title' => 'The LCP image, discoverable and prioritised',
                'lang'  => 'html',
                'lines' => [
                    '<!-- in <head>: found before the parser reaches the body -->',
                    '<link rel="preload" as="image" fetchpriority="high"',
                    '      href="/img/hero-800.avif"',
                    '      imagesrcset="/img/hero-800.avif 800w, /img/hero-1600.avif 1600w"',
                    '      imagesizes="(max-width: 700px) 100vw, 800px">',
                    '',
                    '<!-- in the page: never lazy, always sized -->',
                    '<img src="/img/hero-800.avif" alt="…"',
                    '     width="800" height="500"',
                    '     fetchpriority="high" decoding="async">',
                ],
                'note' => 'width and height on every image is the cheapest CLS fix there is: it reserves the box before the bytes arrive.',
            ]],

            ['quote', ['Set the budget on the device your slowest quartile is actually holding. Everything else is a preference.', 'Technology & Intelligence desk']],

            ['h', 'INP is a main-thread problem'],
            ['p', 'Poor INP is rarely caused by the handler doing the work. It is caused by everything else queued in front of it: hydration, analytics, a consent script, a carousel initialising. The browser cannot paint a response while the main thread is busy, so the interaction sits and waits.'],
            ['ul', [
                'Break long tasks. Anything over 50 ms is a block; yield between chunks so input can be handled.',
                'Move work off the critical path. Defer non-essential third-party scripts until after first interaction, or to a worker.',
                'Give feedback before the work finishes. Painting a pressed state in the next frame and then doing the work reads as instant.',
                'Measure INP by interaction, not as one number. The offender is usually a single control — a filter, a menu, an add-to-cart.',
            ]],

            ['h', 'Budgets, in CI, as numbers someone agreed'],
            ['p', 'A performance budget is only real if a build can fail on it. Lab tests in CI catch the regression before it ships; field data decides whether the budget was right. Both are needed, and they are not interchangeable.'],
            ['code', [
                'title' => 'A budget that blocks a merge',
                'lang'  => 'json',
                'lines' => [
                    '{',
                    '  "path": "/product/*",',
                    '  "timings":   [ { "metric": "lcp", "budget": 2000 } ],',
                    '  "resourceSizes": [',
                    '    { "resourceType": "script",     "budget": 160 },',
                    '    { "resourceType": "font",       "budget":  90 },',
                    '    { "resourceType": "third-party","budget": 120 }',
                    '  ]',
                    '}',
                ],
                'note' => 'The lab budget sits below the field target on purpose. Real conditions are worse than the simulation, so the lab gate has to leave headroom.',
            ]],
            ['note', ['kind' => 'check', 'title' => 'Performance is an accessibility measure too',
                      'text'  => 'Layout shift moves a tap target out from under a finger. A blocked main thread strands a screen-reader user mid-announcement. The WCAG 2.2 target-size rule and a CLS budget are arguing for the same thing from two directions.']],
            ['badges', ['cwv', 'wcag22', 'dora-metrics']],

            ['key', ['title' => 'The short version',
                     'items' => [
                        'Judge with field data at p75, segmented by mobile and desktop. Use the lab to catch regressions.',
                        'Split LCP into its four parts before you touch anything.',
                        'Never lazy-load the LCP image, and always set width and height.',
                        'Treat INP as a main-thread scheduling problem, and find the one control that causes it.',
                        'Put the budget in CI, below the field target, and let it fail a build.',
                     ]]],
            ['links', [
                ['Websites & Apps', 'services/technology-intelligence/websites-apps.php', 'Web and product apps judged on field data, not launch-day scores.'],
                ['Audits & Assessments', 'services/technology-intelligence/audits-assessments.php', 'What is broken, what it is costing, and what to fix first.'],
            ]],
        ],
    ],

    /* ============================================================================================= */
    'the-carbon-cost-of-a-request' => [
        'type'        => 'article',
        'title'       => 'The carbon cost of a request',
        'dek'         => 'Software Carbon Intensity turns an environmental claim into an engineering number — one you can put in a dashboard, argue about in a review, and make worse by shipping a bad release.',
        'date'        => '2026-07-29',
        'desk'        => 'technology',
        'disciplines' => ['technology-intelligence'],
        'industry'    => 'b2b-technology',
        'series'      => 'run-cleaner',
        'tags'        => ['sustainability', 'architecture', 'measurement'],
        'placeholder' => 'Seed post, written in-house as a design proof. Replace with a real article before launch.',
        'cover'       => ['file' => 'carbon-grid.jpg', 'w' => 1400, 'h' => 875, 'pos' => '50% 50%',
                          'alt'  => 'Wind turbines on open ground under a pale sky.',
                          'credit' => 'nathan-rodriguez'],
        'body' => [
            ['lede', 'Most sustainability reporting in software is an offset purchase with a slide deck attached. The Software Carbon Intensity specification is more useful and much less comfortable: it is a rate, it goes up when you write wasteful code, and no amount of buying can bring it down.'],

            ['h', 'A rate, not a total'],
            ['p', 'SCI was published by the Green Software Foundation and standardised as ISO/IEC 21031:2024. It deliberately refuses to be a carbon footprint. A footprint is a total, and a total falls when you use the software less, which is not an engineering achievement. SCI is emissions per unit of work, so it only improves when the work itself gets cleaner.'],
            ['formula', [
                'expr'  => 'SCI = ((E × I) + M) per R',
                'terms' => [
                    ['E', 'Energy consumed by the software, in kilowatt-hours.'],
                    ['I', 'Location-based marginal carbon intensity of that electricity, in gCO₂e/kWh.'],
                    ['M', 'Embodied emissions — the manufacturing of the hardware, amortised over its life and your share of it.'],
                    ['R', 'The functional unit. One request, one user, one job, one inference. You choose it, then you keep it.'],
                ],
                'note'  => 'Two rules do most of the work. Offsets are not subtracted, and the intensity is marginal and location-based, not a market-based average bought with certificates.',
            ]],
            ['p', 'The choice of R is where teams either make the number useful or make it decorative. Pick a unit that scales with what customers actually do — a completed checkout, an answered query, a processed document — and the number stays honest as traffic grows. Pick “per month” and you have invented a total again.'],

            ['h', 'Three levers, in order of how much they move'],
            ['steps', [
                ['Energy efficiency', 'Do less work per unit. Cache what does not change, stop re-encoding the same video, pick an algorithm that is not quadratic, use a smaller model where a smaller model is right. This is ordinary engineering, and it usually lowers cost by the same proportion.'],
                ['Hardware efficiency', 'Use fewer machines, and use them harder. Idle capacity still carries embodied emissions. Right-sizing an over-provisioned cluster and raising utilisation attacks M, which nothing else does.'],
                ['Carbon awareness', 'Do the same work when and where the grid is cleaner. Batch jobs, model fine-tuning, index rebuilds and report generation rarely care about the hour they run. Latency-bound work does, which is why this lever is third and not first.'],
            ]],
            ['note', ['kind' => 'warn', 'title' => 'Marginal is not average',
                      'text'  => 'Grid average intensity tells you the mix that is already running. Marginal intensity tells you what will be dispatched to serve one more kilowatt-hour — usually the most expensive and dirtiest plant on the system. Scheduling decisions should use marginal figures, or they will move work to an hour that looks clean and is not.']],

            ['fig', ['file' => 'fig-racks.jpg', 'w' => 2000, 'h' => 1325, 'wide' => true,
                     'alt' => 'Rows of server racks in a data centre aisle, lit from above.',
                     'caption' => 'Embodied emissions are already spent by the time a rack is powered on. Raising utilisation is the only lever that improves the share you carry.',
                     'credit' => 'domaintechnik']],

            ['h', 'What it changes about the front end'],
            ['p', 'Transfer-weight models — grams per megabyte — are crude, and we do not present them as measurements. They are still directionally right about one thing: bytes you never send cost nothing to transmit, cache, decode or render, on a device whose battery is someone else’s problem. A page that ships 2.1 MB of JavaScript to render 40 KB of text is wasteful under any model you choose.'],
            ['ul', [
                'Send the markup already rendered. Hydrating a page to produce text the server could have sent is energy spent twice.',
                'Encode images once, at the sizes actually used, and let the CDN keep them. Re-encoding on every request is a compute bill disguised as convenience.',
                'Cache at the edge with a long life and explicit invalidation. A cache hit is the cheapest request there is.',
                'Set a page-weight budget in CI beside the performance budget. They tend to move together.',
            ]],

            ['h', 'Putting it in the monthly report'],
            ['p', 'A number nobody reads changes nothing. SCI per request belongs in the same service report as p95 latency, error budget and cost per thousand requests, with its functional unit printed beside it and its method written down. When it moves, the report says which of the three levers moved it.'],
            ['data', [
                'title' => 'What a reviewable SCI line records',
                'note'  => 'Column values are an illustrative shape, not measurements from a client system.',
                'head'  => ['Field', 'Why it is there'],
                'rows'  => [
                    ['Functional unit (R)', 'Without it the number cannot be compared to anything, including itself.'],
                    ['Boundary', 'Which components are counted: application, database, CDN, model inference, build pipeline.'],
                    ['Energy source (E)', 'Measured, or modelled from utilisation — and which, stated plainly.'],
                    ['Intensity source (I)', 'Which grid dataset, at what resolution, marginal or average.'],
                    ['Embodied share (M)', 'The amortisation assumption, in years, and the share attributed.'],
                    ['Change since last month', 'And which of the three levers is responsible.'],
                ],
            ]],
            ['stack', ['kubernetes', 'terraform', 'prometheus', 'grafana', 'opentelemetry', 'cloudflare']],
            ['badges', ['sci', 'iso14001']],

            ['key', ['title' => 'The short version',
                     'items' => [
                        'SCI is a rate per functional unit, and offsets do not reduce it.',
                        'Choose R once, from something customers do, and never quietly change it.',
                        'Efficiency first, utilisation second, carbon-aware scheduling third.',
                        'Use marginal, location-based intensity for scheduling decisions.',
                        'Report it monthly beside latency and cost, with the method attached.',
                     ]]],
            ['links', [
                ['AI Infrastructure & Cloud', 'services/technology-intelligence/ai-infrastructure-cloud.php', 'The backend that makes AI fast, reliable and cheap to run at scale.'],
                ['Technology & Intelligence', 'services/technology-intelligence.php', 'Software, AI and infrastructure run as one platform.'],
            ]],
        ],
    ],

    /* ============================================================================================= */
    'search-rebuilt-around-real-queries' => [
        'type'        => 'case-study',
        'title'       => 'Search rebuilt around what people actually type',
        'dek'         => 'A retail group whose on-site search returned nothing for a fifth of its queries, because the catalogue spoke in supplier vocabulary and customers did not.',
        'date'        => '2026-07-02',
        'desk'        => 'technology',
        'disciplines' => ['technology-intelligence', 'product-experience', 'marketing-technology'],
        'industry'    => 'retail-commerce',
        'series'      => 'fast-front',
        'tags'        => ['search', 'architecture', 'measurement'],
        'placeholder' => 'Illustration, not a client engagement. Written in-house to show how a case study is set out. No client is named and no number here is a client result. Replace with a real, client-approved case study before launch.',
        'cover'       => ['file' => 'case-retail.jpg', 'w' => 1400, 'h' => 1050, 'pos' => '50% 50%',
                          'alt'  => 'A shop interior with a customer paying at the counter.',
                          'credit' => 'unzer'],
        'case' => [
            'sector'   => 'Retail & commerce · multi-brand group, one storefront platform',
            'shape'    => 'One squad, three disciplines',
            'duration' => '5–7 months, typical for this shape',
            'stage'    => 'Discovery → build → run',
            'problem'  => [
                'Search was treated as a component that had been bought and was therefore finished. It matched product titles against typed strings, and the titles had been written by suppliers for a purchase-order system. Customers typed what they would say out loud.',
                'The zero-result page was the symptom everybody could see. The more expensive failure was quieter: queries that returned forty results in an order nobody could explain, where the item the customer wanted sat below the fold on page two.',
                'Merchandising had responded the way teams do, with a growing list of hand-pinned overrides — hundreds of them, unreviewed, and each one an untracked exception to a ranking nobody had written down.',
            ],
            'constraints' => [
                ['The catalogue could not be rewritten', 'Product data came from twelve supplier feeds on their schedules. Any solution had to work with the titles as given.'],
                ['Peak days were immovable', 'Two sale weekends carried a large share of the year. The build could not put either at risk, so nothing shipped in the four weeks around them.'],
                ['No new customer tracking', 'The group had committed to collecting less behavioural data, not more. Relevance had to improve using data it already held lawfully.'],
                ['One storefront, several brands', 'Each brand had its own tone and its own merchandising team, and none would accept a ranking that another brand could change.'],
                ['The team had to own it afterwards', 'A relevance system only the agency can tune is a dependency, not a deliverable.'],
            ],
            'movements' => [
                ['n' => '01', 'title' => 'Read the logs before proposing anything',
                 'text' => 'Six months of query logs, anonymised, grouped by intent rather than string. The long tail was not noise: it was people searching by material, by room, by occasion and by the name the previous catalogue used. The zero-result set was largely vocabulary, not stock.',
                 'disciplines' => ['technology-intelligence', 'product-experience'],
                 'artifacts' => ['Query intent taxonomy', 'Zero-result analysis by cause', 'A golden set of 200 queries with expected results']],
                ['n' => '02', 'title' => 'Separate understanding from ranking',
                 'text' => 'Two stages, so each could be fixed without disturbing the other. Understanding maps a typed string to structured intent — category, attributes, brand, modifiers. Ranking decides the order of what matched, from signals the merchandising teams chose and could see.',
                 'disciplines' => ['technology-intelligence'],
                 'artifacts' => ['Query understanding service', 'Synonym and vocabulary sets, versioned', 'Ranking configuration per brand']],
                ['n' => '03', 'title' => 'Give merchandisers a tool instead of an override',
                 'text' => 'The pinning list was replaced with rules that state an intention — boost in-stock items, prefer this brand for this category during this window — each with an owner, a reason and an expiry. Rules are previewed against the golden set before they go live.',
                 'disciplines' => ['product-experience', 'marketing-technology'],
                 'artifacts' => ['Merchandising rules console', 'Preview-against-golden-set workflow', 'Rule expiry and review calendar']],
                ['n' => '04', 'title' => 'Make relevance a measured thing',
                 'text' => 'The golden set runs on every change to the index, the synonym sets or the ranking configuration, the same way an evaluation suite gates an AI feature. A drop in the agreed measures fails the release rather than arriving as a complaint.',
                 'disciplines' => ['technology-intelligence'],
                 'artifacts' => ['Relevance CI job', 'Weekly relevance report', 'Alerting on zero-result rate by brand']],
            ],
            'matrix' => [
                'technology-intelligence' => ['Query understanding, index and ranking architecture; the relevance CI job and its gates.', 3],
                'product-experience'      => ['Search and results interaction, the empty and low-confidence states, the merchandising console.', 2],
                'marketing-technology'    => ['Merchandising operating model, rule ownership, review cadence and reporting.', 2],
            ],
            'changed' => [
                ['Zero-result rate', 'Share of searches returning no products, by brand and by device.', 'Read weekly against the pre-build baseline; a rise is investigated as a vocabulary gap, not a stock problem.'],
                ['Relevance at 10', 'Share of golden-set queries whose expected item appears in the first ten results.', 'Runs in CI on every index, synonym or ranking change. A fall blocks the release.'],
                ['Search-to-detail rate', 'Share of searches where a customer opens a product from the results.', 'Compared like-for-like across the same weeks of the retail calendar, never across a sale boundary.'],
                ['Hand overrides in force', 'Count of live merchandising rules, and how many are past their review date.', 'A number that should fall and then stay flat. Growth means the ranking is wrong again.'],
            ],
            'owns' => [
                ['Query understanding service', 'Source, tests and deployment pipeline in the group’s own repository.', 'Their GitHub organisation, their CI'],
                ['Vocabulary and synonym sets', 'Versioned data, reviewed like code, with an owner per brand.', 'Same repository, separate review rules'],
                ['Golden set of 200 queries', 'The definition of correct, with the expected result for each.', 'Versioned beside the service'],
                ['Merchandising rules console', 'The tool, its documentation, and the operating model for who may change what.', 'Their storefront admin'],
                ['Relevance CI job and report', 'The gate that blocks a bad release, and the weekly report that explains movement.', 'Their pipeline, their dashboards'],
            ],
            'call' => ['The rule we argued for and nearly lost',
                       'The group wanted a large language model in front of search from the first week. We argued for the boring stage first: fix understanding with vocabulary and structure, measure it, and only then consider a model for the residual long tail. A model sitting on top of an unmeasured ranking is a way to make failures harder to explain, and it costs more per query to be equally wrong.'],
            'result' => '',
        ],
        'body' => [
            ['h', 'Appendix — the two-stage shape'],
            ['p', 'Keeping understanding and ranking apart is what makes the system debuggable. When a search goes wrong, the first question has an answer: did we misread the query, or did we read it correctly and order the results badly? A single-stage system cannot answer that, which is why it accumulates overrides.'],
            ['code', [
                'title' => 'One query, through both stages',
                'lang'  => 'text',
                'lines' => [
                    'typed:      "dark wood dining table for small flat"',
                    '',
                    'stage 1 — understanding',
                    '  category:   furniture/dining/tables',
                    '  attributes: finish=dark-wood, seats<=4',
                    '  modifiers:  space-constrained',
                    '  confidence: 0.86            → above threshold, structured search',
                    '',
                    'stage 2 — ranking (signals the merchandisers can see)',
                    '  attribute match    ·  in stock  ·  return rate',
                    '  brand rule: “prefer own-brand in dining, Sept–Oct” (owner: merch/dining, expires 31 Oct)',
                    '',
                    'below threshold → keyword search, and the query is logged as a vocabulary gap',
                ],
                'note' => 'The low-confidence path is the important one: it degrades to something that works and leaves evidence behind.',
            ]],
            ['links', [
                ['Search & AI Visibility', 'services/technology-intelligence/search-ai-visibility.php', 'Ranking on Google and being cited by AI answer engines, as one system.'],
                ['Custom Software & Data Platforms', 'services/technology-intelligence/custom-software-data-platforms.php', 'Platforms built around how a business actually runs.'],
                ['Work', 'work.php', 'The full programme index.'],
            ]],
        ],
    ],

    /* ============================================================================================= */
    'triage-with-a-human-in-every-loop' => [
        'type'        => 'case-study',
        'title'       => 'A triage assistant with a human in every loop',
        'dek'         => 'A regulated lender wanted AI in its collections queue. The design problem was not the model. It was proving, months later, who decided what and on what evidence.',
        'date'        => '2026-06-11',
        'desk'        => 'technology',
        'disciplines' => ['technology-intelligence', 'ai-design', 'product-experience'],
        'industry'    => 'financial-services',
        'series'      => 'ship-ai',
        'tags'        => ['agents', 'governance', 'evals', 'delivery'],
        'placeholder' => 'Illustration, not a client engagement. Written in-house to show how a case study is set out. No client is named and no number here is a client result. Replace with a real, client-approved case study before launch.',
        'cover'       => ['file' => 'case-lending.jpg', 'w' => 1400, 'h' => 934, 'pos' => '50% 50%',
                          'alt'  => 'A desk with market data on two screens and a phone beside a keyboard.',
                          'credit' => 'jakub-zerdzicki'],
        'case' => [
            'sector'   => 'Financial services · regulated lender, India',
            'shape'    => 'One squad, three disciplines, plus the client’s risk and compliance leads',
            'duration' => '4–6 months to first supervised release',
            'stage'    => 'Discovery → supervised pilot → run',
            'problem'  => [
                'The collections team read every case from the beginning. Account history, prior contact, hardship notes, a spreadsheet of exceptions. The reading took most of the day, and the quality of a decision depended on how far down the queue it sat.',
                'The obvious answer — let a model rank and recommend — ran straight into the thing that actually governs this work. A lending decision has to be explainable to a customer, to an internal auditor and to a regulator, months after the person who made it has left. A recommendation whose reasoning cannot be reconstructed is worse than no recommendation.',
                'Two earlier attempts had stalled at exactly this point. Both produced convincing demonstrations. Neither could answer what the model had been shown on a given day, because the prompt, the retrieval index and the policy documents had all changed since.',
            ],
            'constraints' => [
                ['Every outcome needs a named human', 'No automated decision affecting a customer’s account could be taken without an accountable person approving it.'],
                ['Data stays in India', 'Payment-system data under the RBI’s 2018 storage direction; personal data handled under the DPDP Act. Region-pinned inference and storage, with no cross-border fallback path.'],
                ['The record must survive the system', 'Retention outlives the application. The audit record had to be written in an open format the client could read without our software.'],
                ['Hardship cases route to a person first', 'Accounts flagged for hardship or vulnerability bypass ranking entirely. Not a threshold — an exclusion.'],
                ['Existing queue tooling stays', 'Agents keep the system they know. The assistant had to arrive inside it, not replace it.'],
            ],
            'movements' => [
                ['n' => '01', 'title' => 'Write the decision down before modelling it',
                 'text' => 'Two weeks with the collections leads, the risk function and four agents, producing a decision record: what is being decided, on what inputs, under which policy clause, with what options, and who may sign each one. Most of the ambiguity the earlier attempts had modelled around turned out to be undocumented policy.',
                 'disciplines' => ['product-experience', 'technology-intelligence'],
                 'artifacts' => ['Decision record, signed by risk', 'Policy clause map', 'Exclusion list, starting with hardship']],
                ['n' => '02', 'title' => 'Build the evidence view, not the verdict view',
                 'text' => 'The assistant produces a case brief: the facts it found, each linked to the source record, the policy clauses that apply, the options available and what each one commits the lender to. The recommendation is last and is never the largest thing on screen. A reviewer shown only a recommendation approves it.',
                 'disciplines' => ['product-experience', 'ai-design'],
                 'artifacts' => ['Case brief interface inside the existing queue', 'Evidence-first layout, tested with agents', 'Uncertainty and “insufficient evidence” states']],
                ['n' => '03', 'title' => 'Gate it like any other release',
                 'text' => 'A golden set built from anonymised historical cases, labelled by the collections leads, split into ordinary cases, edge cases and a refusal set where the correct behaviour is to escalate. It runs on every change to a prompt, a retrieval parameter, a model version or a policy document, and nightly against production configuration.',
                 'disciplines' => ['technology-intelligence', 'ai-design'],
                 'artifacts' => ['Golden set, versioned with the code', 'Evaluation gates on faithfulness, citation accuracy and refusal', 'Adversarial set for injected instructions in uploaded documents']],
                ['n' => '04', 'title' => 'Make the audit record the deliverable',
                 'text' => 'Every brief writes an immutable record: inputs, the retrieved passages and their versions, model and version, tool calls, the draft, the reviewer, the decision, the timestamp. Written at the time, in an open format, with a documented schema and a reader the client owns.',
                 'disciplines' => ['technology-intelligence'],
                 'artifacts' => ['Append-only decision log', 'Documented schema and retention policy', 'Reader the client can run without us']],
                ['n' => '05', 'title' => 'Run it supervised before running it at all',
                 'text' => 'The first release was shadow mode: the assistant produced briefs that agents could read but not act on, while both paths were compared. Only after the gap between recommendation and agent decision was understood, case by case, did approval move into the live queue.',
                 'disciplines' => ['technology-intelligence', 'product-experience'],
                 'artifacts' => ['Shadow-mode comparison report', 'Agreed promotion criteria', 'Rollback plan with a single switch']],
            ],
            'matrix' => [
                'technology-intelligence' => ['Region-pinned inference, retrieval, the evaluation suite and the append-only decision log.', 3],
                'ai-design'               => ['Prompt and retrieval design, refusal behaviour, the uncertainty language a reviewer reads.', 2],
                'product-experience'      => ['The decision record, the evidence-first brief, and the review flow inside the existing queue.', 3],
            ],
            'changed' => [
                ['Time to first informed decision', 'Minutes from a case opening to an agent taking a decision with the brief in front of them.', 'Compared with a matched sample of cases handled before the pilot, not with an average day.'],
                ['Citation accuracy', 'Share of statements in a brief that link to a source record that supports them.', 'Measured on the golden set on every release; below the gate, the release is blocked.'],
                ['Escalation correctness', 'Share of cases the assistant escalated that the collections leads agree should have been escalated.', 'Reviewed weekly on a sample, by the leads, not by the delivery team.'],
                ['Override rate, with reasons', 'Share of briefs where the agent chose a different option, grouped by the reason they gave.', 'Read as a design signal. A rising override rate in one reason category is a fault in the brief, not in the agent.'],
                ['Record completeness', 'Share of decisions whose audit record contains every required field.', 'Must be 100%. Anything else is a defect with the same severity as data loss.'],
            ],
            'owns' => [
                ['Decision record', 'The written statement of what is decided, by whom, under which policy clause.', 'Their governance repository, signed by risk'],
                ['Golden set and evaluation suite', 'The definition of correct, and the job that enforces it.', 'Their repository, their CI'],
                ['Append-only decision log', 'Schema, retention policy, and a reader that runs without our software.', 'Their infrastructure, in-region'],
                ['Prompt and retrieval configuration', 'Versioned, reviewed, with the change history intact.', 'Their repository'],
                ['Runbook and rollback switch', 'How to turn it off, who may, and what happens to cases in flight.', 'Their operations handbook'],
            ],
            'call' => ['The rule we argued for and kept',
                       'We refused to build a confidence score into the agent’s view. A single number invites deference: high means approve, low means look. The brief shows what was found and what is missing instead, and asks for a decision — which is the thing the accountable person is there to make. It is slower to read, and it is the reason the record holds up.'],
            'result' => '',
        ],
        'body' => [
            ['h', 'Appendix — what the record contains'],
            ['p', 'The schema is deliberately dull and deliberately open. An auditor should be able to reconstruct any decision from one record plus the versioned artefacts it names, without access to a running system.'],
            ['code', [
                'title' => 'One decision record, abbreviated',
                'lang'  => 'json',
                'lines' => [
                    '{',
                    '  "case_id":      "…",',
                    '  "opened_at":    "2026-06-11T09:14:22+05:30",',
                    '  "inputs":       { "account_ref": "…", "documents": ["…@v3"] },',
                    '  "retrieved":    [ { "doc": "policy/hardship@v7", "span": [412, 688] } ],',
                    '  "model":        { "name": "…", "version": "…", "region": "ap-south-1" },',
                    '  "tools":        [ { "name": "account.read", "args": {…}, "ok": true } ],',
                    '  "draft":        { "options": ["…"], "recommendation": "…", "citations": [0,1] },',
                    '  "reviewer":     { "id": "…", "role": "collections-lead" },',
                    '  "decision":     { "option": "…", "differs_from_draft": true, "reason": "hardship-flag" },',
                    '  "decided_at":   "2026-06-11T09:21:05+05:30"',
                    '}',
                ],
                'note' => 'Every reference carries a version. Without that, the record names documents that no longer say what they said.',
            ]],
            ['badges', ['iso42001', 'nist-ai-rmf', 'owasp-llm', 'dpdp']],
            ['links', [
                ['AI Strategy & Agents', 'services/technology-intelligence/ai-strategy-agents.php', 'Where AI fits, what to build first, and agents that do real work.'],
                ['Cybersecurity & AI Trust', 'services/technology-intelligence/cybersecurity-ai-trust.php', 'Securing products, data and AI systems, with the governance to stay compliant.'],
                ['Industries', 'industries.php', 'How the constraints change by sector.'],
            ]],
        ],
    ],

    ],
];
