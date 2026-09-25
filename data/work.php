<?php
/* DRAFT COPY — review before launch.
 * =====================================================================================================
 * THE CASE-STUDY FILE — everything the Work pages show comes from here
 * =====================================================================================================
 *
 * <!-- PLACEHOLDER: every programme below is an anonymised illustration written in-house.
 *      Replace with real case studies, approved by the client, before launch. -->
 *
 * ---------------------------------------------------------------------------------------------------
 * HOW TO ADD A PROJECT  (no PHP knowledge needed — copy, paste, edit)
 * ---------------------------------------------------------------------------------------------------
 * 1. Copy the whole block for one programme below — from its opening `[` to its closing `],` — and
 *    paste it at the END of the 'cases' list, just before the final `],`.
 * 2. Edit the values. Keep every `'key' => ` name exactly as it is; only change what is after `=>`.
 *    Text goes inside single quotes. If your text contains an apostrophe, write it as the curly ’
 *    (as in “doesn’t”) — that is what the rest of the site uses and it needs no escaping.
 * 3. Give it a new 'slug'. The slug is the web address: 'my-project' becomes /work/my-project.
 *    Use lowercase letters, numbers and hyphens only.
 * 4. Create the page file for it. Copy work/nine-markets-one-brand.php to work/<your-slug>.php and
 *    change the one slug inside it. That is the whole file — a comment and two lines of code.
 *    **Until that file exists the programme still appears in the index, but without a link** —
 *    nothing on the site ever points at a page that is not there.
 * 5. Put your photographs in assets/imgs/work/ and add a row for each one to
 *    assets/imgs/work/CREDITS.md. Then name them under 'img' and 'gallery' below.
 * 6. Load /work in a browser and check it.
 *
 * ---------------------------------------------------------------------------------------------------
 * THE FIELDS
 * ---------------------------------------------------------------------------------------------------
 * REQUIRED — a programme will not render properly without these
 *   'slug'          string   the web address, /work/<slug>. Lowercase, hyphens, no spaces.
 *   'title'         string   the headline. What changed, not what we sold.
 *   'industry'      string   one key from the 'industries' list at the top of this file.
 *   'brief'         string   ONE sentence: the problem, as the client put it.
 *   'did'           list     what we did, by discipline: ['<discipline-slug>', 'the role we played'].
 *                            Discipline slugs are in data/site.php: brand-design, technology-intelligence,
 *                            campaign-content, ai-design, product-experience, marketing-technology.
 *   'system'        string   2–3 lines: the system we left behind.
 *   'deliverables'  list     the things handed over. 4–6 items.
 *   'measure'       list     what it is measured by. 3–4 items. Measures, not results.
 *   'duration'      string   a typical range ('4–6 months'), never a precise promise.
 *   'img'           array    the main photograph:
 *                            ['file' => 'name.jpg' (in assets/imgs/work/), 'alt' => 'what is in the
 *                             picture, for people who cannot see it', 'w' => width, 'h' => height,
 *                             'pos' => '50% 50%' (optional — which part of the photo to keep when cropped)]
 *
 * OPTIONAL — leave the field out, or set it to '' or [], and that part simply does not render
 *   'featured'      true     show this one as the large featured programme. Set it on ONE entry only.
 *   'client'        string   the client's name. LEAVE EMPTY unless you hold written permission to
 *                            name them. Empty means the page attributes the work to the sector only.
 *   'dates'         string   when it ran, e.g. '2024 – 2025'. Empty renders as "shared under NDA".
 *   'scope'         string   the shape of the team, e.g. 'One squad, three disciplines'.
 *   'problem'       list     2–3 paragraphs on what was actually wrong. Plain sentences.
 *   'build'         list     what we built, as ['Heading', 'paragraph']. 3–4 of them.
 *   'call'          array    ['Heading', 'paragraph'] — the judgement call that shaped the programme.
 *   'outcome'       string   the result. LEAVE EMPTY until the client has approved the exact wording
 *                            and the number. An empty value renders the honest "pending approval" note.
 *   'quote'         array    ['the words', 'the speaker’s role'] — a client quote. LEAVE EMPTY unless
 *                            the client has approved being quoted. Never write one on their behalf.
 *   'stack'         list     technology slugs from data/tech-stack.php, e.g. ['react', 'postgresql'].
 *   'standards'     list     framework keys from partials/tech/kit.php, e.g. ['iso27001', 'wcag22'].
 *                            These are frameworks the delivery was built to — never certifications held.
 *   'artefact'      string   the code-built illustration for this programme. The keys live in
 *                            partials/work/thumbs.php; add a new one there to add a new illustration.
 *   'gallery'       list     more photographs for the case page:
 *                            ['file' =>, 'alt' =>, 'w' =>, 'h' =>, 'cap' => 'short caption']
 *
 * ---------------------------------------------------------------------------------------------------
 * THE RULES THAT DO NOT BEND
 * ---------------------------------------------------------------------------------------------------
 * • No client name without written permission. 'client' stays empty otherwise — the sector is enough.
 * • No number that has not been approved by the client. 'outcome' stays empty until it has.
 * • No quote the client has not agreed to. Never write one for them.
 * • 'measure' lists what is measured, not what was achieved. The two are different.
 * • Durations are typical ranges, not commitments.
 * ===================================================================================================== */

return [

    /* The sectors used by 'industry' above, and by the Sectors section on /work.
       Key => label. Add a sector by adding a line; it appears in the filter automatically. */
    'industries' => [
        'consumer-health'    => 'Consumer health',
        'financial-services' => 'Financial services',
        'retail-commerce'    => 'Retail & commerce',
        'b2b-technology'     => 'B2B technology',
        'hospitality'        => 'Hospitality',
        'telecom-media'      => 'Telecom & media',
    ],

    /* A one-line note per sector for the Sectors section — what tends to be hard there. */
    'sector_notes' => [
        'consumer-health'    => 'Claims need substantiation, and every market reads them differently.',
        'financial-services' => 'Every message and every decision has to survive an audit.',
        'retail-commerce'    => 'Peak days, mid-range phones and answer engines decide the revenue.',
        'b2b-technology'     => 'Buyers ask for evidence before they sign anything.',
        'hospitality'        => 'The aggregator owns the guest until the direct experience is better.',
        'telecom-media'      => 'Scale is the easy part; one version of the truth is not.',
    ],

    'cases' => [

        [
            'slug'     => 'nine-markets-one-brand',
            'title'    => 'Nine markets, one brand system',
            'client'   => '',
            'industry' => 'consumer-health',
            'featured' => true,
            'dates'    => '',
            'duration' => '6–9 months',
            'scope'    => 'One squad, three disciplines, nine market teams',
            'brief'    => 'Hold one brand across nine markets without slowing any of them down.',
            'problem'  => [
                'Nine market teams were each redrawing the brand for themselves. Every launch started with a debate about colour, type and claim wording, and finished in a review queue that nobody owned.',
                'The cost was not the artwork. It was the four to six weeks between a market having an idea and having an approved asset, and the regulatory risk of a claim that had been reworded locally without substantiation.',
            ],
            'did' => [
                ['brand-design', 'Brand system, pack architecture and market flex rules'],
                ['campaign-content', 'Approved-claims library and market production templates'],
                ['ai-design', 'Brand-check agent with human approval'],
            ],
            'system' => 'A token-based brand system with market-level flex rules, a shared claims library and a brand-check agent that flags drift before assets reach review.',
            'build'  => [
                ['One set of tokens, nine sets of permissions', 'Colour, type, spacing and pack geometry became design tokens with a single source. Each market inherits them and may change only what its flex rules allow — a second language, a local size, a regulator-mandated panel. Everything else is inherited, not copied.'],
                ['A claims library, not a claims document', 'Every claim exists once, with its substantiation, its approved wording per market and its review history attached. Copy is assembled from approved claims rather than written and then checked.'],
                ['A brand-check agent that never approves anything', 'Assets are checked against the tokens, the type rules, the pack geometry and the claims library before they reach a person. The agent flags and routes; a named reviewer approves. Every decision, including the agent’s, is logged.'],
                ['Market templates that produce the whole pack', 'A market builds from a template that already knows its flex rules, so the output is correct by construction rather than corrected in review.'],
            ],
            'call' => ['The judgement call', 'We were asked to lock the system harder. We did the opposite: we widened the flex rules and made the checks stricter. A rule a market cannot live with is a rule a market will break quietly.'],
            'outcome'   => '',
            'quote'     => [],
            'deliverables' => ['Brand guidelines as a living site', 'Design tokens and pack templates', 'Claims library with approval history', 'Brand-check agent and audit log', 'Market onboarding kit'],
            'measure'      => ['Assets passing brand review first time', 'Brief-to-approved time per market', 'Share of assets built from templates', 'Claims exceptions raised per quarter'],
            'standards'    => ['iso42001', 'wcag22'],
            'artefact'     => 'nine-markets-one-brand',
            'img' => ['file' => 'c-nine-markets-one-brand.jpg', 'alt' => 'A colour print coming off an ink-spattered printing press', 'w' => 800, 'h' => 1200, 'pos' => '50% 40%'],
            'gallery' => [
                ['file' => 'f-prints.jpg', 'alt' => 'A hand laying out printed photographs in rows on a wooden table', 'w' => 1400, 'h' => 933, 'cap' => 'Every market’s pack, built from the same tokens'],
                ['file' => 'd-box.jpg', 'alt' => 'An open white carton photographed against a pale background', 'w' => 1200, 'h' => 800, 'cap' => 'Pack architecture — the geometry markets inherit'],
                ['file' => 'f-crowd.jpg', 'alt' => 'A crowd of people crossing a wide street, seen from directly above', 'w' => 800, 'h' => 1200, 'cap' => 'Nine markets, one set of rules'],
            ],
        ],

        [
            'slug'     => 'crm-that-remembers',
            'title'    => 'A CRM that knows what happened last',
            'client'   => '',
            'industry' => 'financial-services',
            'dates'    => '',
            'duration' => '4–6 months',
            'scope'    => 'One squad across CRM, data and journey design',
            'brief'    => 'Make every customer message aware of the last thing that happened.',
            'problem'  => [
                'The campaign tool, the servicing app and the core system each held part of the customer and none of them held the order of events. A customer who had abandoned an application at the income step would be sent the same opening offer the following week.',
                'Consent and regulatory suppression were applied at send time by hand, in a spreadsheet, by one team. That is a control that works right up until the day it does not.',
            ],
            'did' => [
                ['marketing-technology', 'Journey-led CRM, consent and suppression'],
                ['technology-intelligence', 'Event pipeline from core systems'],
                ['product-experience', 'Lifecycle journey design'],
            ],
            'system' => 'An event-driven customer profile joining app, web and servicing events, with consent and regulatory suppression applied before any message is sent.',
            'build'  => [
                ['One event schema, agreed once', 'Application, servicing and web events were given one shape and one set of definitions, so “applied”, “abandoned” and “serviced” mean the same thing in every system that reads them.'],
                ['Suppression before selection, not after', 'Consent, regulatory holds and complaint state are applied to the audience before a journey selects anyone. A suppressed customer is never in the set, so nobody has to remember to remove them.'],
                ['Journeys designed as service, not as campaigns', 'Each lifecycle stage was mapped with the servicing team, so the next message follows from the last event rather than from the calendar.'],
                ['An audit log a compliance officer can read', 'Every message records the customer state, the consent basis and the journey rule that selected them, queryable without an engineer.'],
            ],
            'call' => ['The judgement call', 'The fastest route was to copy the existing campaign segments into the new tool. We rebuilt them from events instead. Migrating a segment migrates the bug that made it necessary.'],
            'outcome'   => '',
            'quote'     => [],
            'deliverables' => ['Customer event schema', 'Lifecycle journey maps', 'Consent and preference centre', 'Message audit log', 'Runbook for the servicing team'],
            'measure'      => ['Journey completion by stage', 'Opt-out and complaint rates', 'Time to launch a new journey', 'Suppression accuracy at send'],
            'standards'    => ['iso27001', 'dpdp'],
            'artefact'     => 'crm-that-remembers',
            'img' => ['file' => 'c-crm-that-remembers.jpg', 'alt' => 'A person adding sticky notes to a wall of them during a planning session', 'w' => 1200, 'h' => 800, 'pos' => '50% 50%'],
            'gallery' => [
                ['file' => 'm-shape.jpg', 'alt' => 'Two people sorting sticky notes into columns on a whiteboard', 'w' => 1800, 'h' => 1192, 'cap' => 'Lifecycle stages, agreed with servicing before anything was built'],
                ['file' => 'hero-revisions.jpg', 'alt' => 'Two people signing a printed document at a desk', 'w' => 1400, 'h' => 1050, 'cap' => 'Consent basis recorded against every message'],
            ],
        ],

        [
            'slug'     => 'assistant-sales-trusts',
            'title'    => 'An assistant that answers what sales kept repeating',
            'client'   => '',
            'industry' => 'b2b-technology',
            'dates'    => '',
            'duration' => '3–5 months',
            'scope'    => 'Two engineers, one designer, one domain reviewer',
            'brief'    => 'Give sales an assistant that answers from approved sources, and says when it does not know.',
            'problem'  => [
                'Four people were answering the same fifteen product questions all day, and answering them slightly differently. The product documentation held the right answer, but it was long, and parts of it were out of date.',
                'An earlier assistant had been switched off after it invented a price. Nobody trusted the next one by default, so the work was as much about evidence as about the model.',
            ],
            'did' => [
                ['ai-design', 'Retrieval assistant, evals and guardrails'],
                ['product-experience', 'Product experience and hand-off to sales'],
                ['technology-intelligence', 'AI infrastructure and observability'],
            ],
            'system' => 'A retrieval assistant grounded in approved product documentation, gated by an eval set, with prompt-injection tests and a hand-off to a person when confidence is low.',
            'build'  => [
                ['An eval set before a prompt', 'The first artefact was a scored set of real questions with approved answers, written with the sales team. Nothing shipped until it passed, and it runs on every change.'],
                ['Grounding with a visible source', 'Every answer cites the document and section it came from. An answer with no source is not returned; the question is escalated instead.'],
                ['Guardrails against the questions it must not answer', 'Pricing, contractual terms and roadmap commitments are routed to a person by policy, not by the model’s judgement. Prompt-injection cases are part of the eval set (OWASP LLM01).'],
                ['A hand-off that keeps the context', 'When the assistant escalates, the salesperson receives the question, the retrieved sources and the reason for escalation, so the customer does not repeat themselves.'],
            ],
            'call' => ['The judgement call', 'We shipped an assistant that refuses more often than the client expected. A confident wrong answer costs more than a refusal, and refusal rate is the number we report first.'],
            'outcome'   => '',
            'quote'     => [],
            'deliverables' => ['Eval set and scoring rubric', 'Guardrail and escalation policy', 'Assistant UI in site and product', 'Conversation audit dashboard', 'Model-change runbook'],
            'measure'      => ['Answer accuracy on the eval set', 'Escalation rate to sales', 'Grounded-citation rate', 'Demo-to-opportunity rate'],
            'standards'    => ['owasp-llm', 'iso42001', 'soc2'],
            'artefact'     => 'assistant-sales-trusts',
            'img' => ['file' => 'c-assistant-sales-trusts.jpg', 'alt' => 'Two engineers working side by side at monitors of source code', 'w' => 1600, 'h' => 1066, 'pos' => '50% 50%'],
            'gallery' => [
                ['file' => 'm-build.jpg', 'alt' => 'Two people working through a diagram pinned to a whiteboard', 'w' => 1400, 'h' => 934, 'cap' => 'The eval set, written with the people who answer the questions'],
                ['file' => 'hero-wall.jpg', 'alt' => 'Two people arranging sticky notes into columns on a glass wall', 'w' => 1800, 'h' => 1200, 'cap' => 'The fifteen questions sales kept answering, on the wall'],
            ],
        ],

        [
            'slug'     => 'visible-in-ai-answers',
            'title'    => 'Visible in AI answers, not only in search',
            'client'   => '',
            'industry' => 'retail-commerce',
            'dates'    => '',
            'duration' => '3–4 months',
            'scope'    => 'One content lead, one engineer, one analyst',
            'brief'    => 'Be cited in AI answers, not only ranked in search results.',
            'problem'  => [
                'Category pages ranked well and converted badly, and a growing share of the questions that used to arrive as searches were being answered before anyone reached the site.',
                'Nobody could say whether the brand was being cited in those answers, because nobody was measuring it. The reporting stopped at rank and sessions.',
            ],
            'did' => [
                ['marketing-technology', 'Search and AI visibility measurement'],
                ['technology-intelligence', 'Structured product data and feeds'],
                ['campaign-content', 'Answer-shaped category content'],
            ],
            'system' => 'Structured product data, schema markup and answer-shaped content, tracked against a fixed panel of priority questions across AI assistants.',
            'build'  => [
                ['A fixed question panel', 'Sixty buying questions, agreed with merchandising, asked on a schedule across the major assistants. The same questions every time, so the answer is a trend rather than an anecdote.'],
                ['Product data worth citing', 'Attributes, sizing, materials and care were completed and modelled once, then published as structured data and as the feed the site itself renders from.'],
                ['Content shaped like an answer', 'Category and guide pages lead with the answer, then the reasoning, then the products. The shape that helps an assistant is the shape that helps a reader in a hurry.'],
                ['One report, two channels', 'Rankings, citations, and the revenue behind each priority category in one monthly view, so the trade-offs are visible.'],
            ],
            'call' => ['The judgement call', 'We stopped writing new pages for three months and completed the product data instead. Content cannot be cited accurately when the underlying facts are missing.'],
            'outcome'   => '',
            'quote'     => [],
            'deliverables' => ['Priority-question panel', 'Product data model and feeds', 'Category content templates', 'Visibility tracking report', 'Schema markup implementation'],
            'measure'      => ['Share of AI answers citing the brand', 'Organic revenue from priority categories', 'Product data completeness', 'Rank and citation together, per question'],
            'standards'    => ['cwv', 'wcag22'],
            'artefact'     => 'visible-in-ai-answers',
            'img' => ['file' => 'c-visible-in-ai-answers.jpg', 'alt' => 'A laptop screen showing an assistant’s prompt bar, lit in a dark room', 'w' => 1100, 'h' => 825, 'pos' => '50% 50%'],
            'gallery' => [
                ['file' => 'd-stationery.jpg', 'alt' => 'Plain stationery laid out on a neutral surface', 'w' => 1200, 'h' => 800, 'cap' => 'Category guides rebuilt around the question, not the keyword'],
            ],
        ],

        [
            'slug'     => 'season-in-days',
            'title'    => 'A season shipped in days, not weeks',
            'client'   => '',
            'industry' => 'retail-commerce',
            'dates'    => '',
            'duration' => '2–4 months',
            'scope'    => 'One campaign system team, embedded with the in-house studio',
            'brief'    => 'Take a season from six weeks and three agencies down to days.',
            'problem'  => [
                'A season meant one key visual and then roughly a hundred and twenty adaptations, produced by three agencies to three interpretations of the same brief.',
                'Most of the six weeks was not design. It was re-briefing, chasing sizes, and correcting the same crop and legal line over and over.',
            ],
            'did' => [
                ['campaign-content', 'Template-driven campaign production'],
                ['ai-design', 'Generative variants with brand checks'],
                ['brand-design', 'Campaign system rules'],
            ],
            'system' => 'A campaign system of master layouts and rules; variants for every channel and size generate from one approved key visual and pass a brand check before a person signs off.',
            'build'  => [
                ['Masters with rules, not artwork with instructions', 'Each master layout carries its own crop logic, safe areas, legal placement and type scale, so a new size is a rule application rather than a new design.'],
                ['Generation inside the rules', 'Variants are produced from the approved key visual and checked against the campaign rules. Anything outside them is flagged, not silently fixed.'],
                ['One review, not three', 'A single queue with the rule that failed shown beside each asset. Reviewers spend their time on judgement, not on measuring margins.'],
                ['Channel specs that live with the template', 'Delivery specs sit in the system, so a channel change updates every affected size at once.'],
            ],
            'call' => ['The judgement call', 'We kept a person on the final sign-off even though the checks pass automatically. Speed is worth having; an unreviewed claim in market is not.'],
            'outcome'   => '',
            'quote'     => [],
            'deliverables' => ['Campaign master templates', 'Variant generation pipeline', 'Brand-check rules', 'Channel delivery specs', 'Studio handover and training'],
            'measure'      => ['Time from key visual to full rollout', 'Cost per delivered asset', 'Assets returned for rework', 'Share of assets generated from masters'],
            'standards'    => ['iso42001'],
            'artefact'     => 'season-in-days',
            'img' => ['file' => 'c-season-in-days.jpg', 'alt' => 'A blank out-of-home advertising frame on a city street', 'w' => 1200, 'h' => 1200, 'pos' => '50% 45%'],
            'gallery' => [
                ['file' => 'd-billboard.jpg', 'alt' => 'A large blank billboard frame against a clear sky', 'w' => 1200, 'h' => 1200, 'cap' => 'One key visual, every format generated from its rules'],
                ['file' => 'd-letterpress.jpg', 'alt' => 'Metal letterpress type arranged in a composing stick', 'w' => 1400, 'h' => 933, 'cap' => 'The type scale the templates enforce'],
            ],
        ],

        [
            'slug'     => 'direct-booking-product',
            'title'    => 'Direct booking, treated as a product',
            'client'   => '',
            'industry' => 'hospitality',
            'dates'    => '',
            'duration' => '5–8 months',
            'scope'    => 'Product, engineering and lifecycle in one team',
            'brief'    => 'Move bookings from aggregators back to the hotel’s own site.',
            'problem'  => [
                'The aggregator experience was better than the hotel’s own: fewer steps, a price that did not change at the end, and a room choice that made sense on a phone.',
                'The direct site was a booking engine in an iframe, with the all-in price revealed at step four. The commission was the symptom; the experience was the cause.',
            ],
            'did' => [
                ['product-experience', 'Search-to-checkout booking experience'],
                ['marketing-technology', 'Guest profile and post-stay journeys'],
                ['technology-intelligence', 'Fast booking front end and integrations'],
            ],
            'system' => 'A booking front end on the property and channel systems, with transparent all-in pricing, and guest profiles that carry preferences from one stay to the next.',
            'build'  => [
                ['The all-in price, from the first screen', 'Taxes, fees and the cancellation terms are shown with the first price a guest sees, and never change between there and payment.'],
                ['A booking flow built for a phone on a train', 'Four steps, each one resumable, each one working on a mid-range Android over a weak connection.'],
                ['One guest profile across stays', 'Preferences recorded at one property are available at the next, with the guest able to see and clear what is held.'],
                ['Pre-stay and post-stay as part of the product', 'Confirmation, arrival and post-stay messages come from the same profile the booking wrote, so they never contradict it.'],
            ],
            'call' => ['The judgement call', 'We removed the urgency banners. They lifted the step they sat on and lowered completion overall, which the step-level analytics made obvious once we were measuring the whole path.'],
            'outcome'   => '',
            'quote'     => [],
            'deliverables' => ['Booking flow and design system', 'Property-system integrations', 'Pre-stay and post-stay journeys', 'Conversion analytics by step', 'Rate and availability monitoring'],
            'measure'      => ['Direct share of bookings', 'Booking conversion by step', 'Repeat-stay rate', 'Core Web Vitals at p75 on mobile'],
            'standards'    => ['cwv', 'wcag22', 'pci-dss'],
            'artefact'     => 'direct-booking-product',
            'img' => ['file' => 'c-direct-booking-product.jpg', 'alt' => 'A person filling in a form on a phone held in both hands', 'w' => 1800, 'h' => 1200, 'pos' => '50% 40%'],
            'gallery' => [
                ['file' => 's-hospitality.jpg', 'alt' => 'A hotel lobby with a stone reception desk and panelled walls', 'w' => 1200, 'h' => 675, 'cap' => 'The stay the booking flow has to be worthy of'],
                ['file' => 'd-app.jpg', 'alt' => 'A phone held in one hand, its screen blank and lit', 'w' => 1200, 'h' => 1011, 'cap' => 'Four steps, each one resumable'],
            ],
        ],

        [
            'slug'     => 'one-intelligence-layer',
            'title'    => 'Coverage, content and care on one intelligence layer',
            'client'   => '',
            'industry' => 'telecom-media',
            'dates'    => '',
            'duration' => '9–12 months',
            'scope'    => 'Platform team plus embedded analysts in three business units',
            'brief'    => 'Give network, marketing and care one version of the truth.',
            'problem'  => [
                'Network, marketing and care each had a number for the same thing, and the three numbers disagreed. Every planning meeting began by reconciling them.',
                'The care assistant could not be trusted with an offer because it could not see whether the customer already had one, and the marketing platform could not see whether the customer had just complained.',
            ],
            'did' => [
                ['technology-intelligence', 'Shared data platform and metrics layer'],
                ['ai-design', 'Care assistant with agent hand-off'],
                ['marketing-technology', 'Registered messaging and preferences'],
            ],
            'system' => 'A shared data layer and metric definitions used by network, marketing and care, feeding a care assistant and registered, consented customer messaging.',
            'build'  => [
                ['Definitions before pipelines', 'Every contested metric was defined once, with its owner named and its calculation written down, before any of it was rebuilt.'],
                ['A metrics layer the three units read from', 'One semantic layer over the warehouse, so a dashboard, a journey and the assistant all resolve “active subscriber” the same way.'],
                ['A care assistant that can see the account', 'Grounded in the customer’s own state and entitlements, with a hand-off to an agent carrying the full context, and an eval set covering the cases where it must not act.'],
                ['Messaging that respects the register', 'Consent, registered-preference rules and complaint state are checked in the platform before a message is selected.'],
            ],
            'call' => ['The judgement call', 'We spent the first two months writing definitions rather than building pipelines. It was the least popular decision on the programme and the one that made the rest possible.'],
            'outcome'   => '',
            'quote'     => [],
            'deliverables' => ['Data platform and metric catalogue', 'Care assistant and eval set', 'Preference centre', 'Operational dashboards', 'Ownership model per metric'],
            'measure'      => ['Self-service resolution rate', 'Contacts per thousand subscribers', 'Offer accuracy across channels', 'Metric disputes raised per quarter'],
            'standards'    => ['iso27001', 'iso22301', 'dpdp'],
            'artefact'     => 'one-intelligence-layer',
            'img' => ['file' => 'c-one-intelligence-layer.jpg', 'alt' => 'A row of server racks in a data centre, photographed close up', 'w' => 2000, 'h' => 1325, 'pos' => '50% 50%'],
            'gallery' => [
                ['file' => 's-telecom-media.jpg', 'alt' => 'Blue network cables fanning into a patch panel in a dark rack', 'w' => 1600, 'h' => 1066, 'cap' => 'One layer under three business units'],
                ['file' => 'm-run.jpg', 'alt' => 'An engineer working at a laptop at night with city lights behind', 'w' => 1600, 'h' => 1330, 'cap' => 'Run: the part of the programme that does not end'],
            ],
        ],

        [
            'slug'     => 'global-content-production',
            'title'    => 'Global content production from one source',
            'client'   => '',
            'industry' => 'consumer-health',
            'dates'    => '',
            'duration' => 'Ongoing, set up in 3 months',
            'scope'    => 'A hub team of five, with adaptation partners in each region',
            'brief'    => 'Make each asset once, then adapt it for every market.',
            'problem'  => [
                'Each market was commissioning its own photography and film for the same product, at the same time, to different standards.',
                'Nobody could say what the organisation already owned, or what it was licensed to do with it. The safest answer was always to shoot again.',
            ],
            'did' => [
                ['campaign-content', 'Global production line and adaptation'],
                ['ai-design', 'Assisted adaptation with human review'],
                ['marketing-technology', 'Asset management and delivery'],
            ],
            'system' => 'A hub-and-spoke production model: one master asset, market adaptations generated and checked against approved claims, and a single asset library with usage rights.',
            'build'  => [
                ['One master, produced to travel', 'Masters are shot and edited to a specification that anticipates every downstream format, language and legal panel.'],
                ['Adaptation as a reviewed step', 'Regional versions are produced against the approved claims for that market and reviewed by a named person there before release.'],
                ['A library that knows its rights', 'Every asset carries its licence term, territory and talent rights, so “can we use this?” is a lookup rather than an email thread.'],
                ['A queue markets can actually see', 'Markets can see what is in production, what is available, and when their version is due.'],
            ],
            'call' => ['The judgement call', 'We made rights metadata mandatory at upload. It slowed the first month of the library and removed a class of legal risk permanently.'],
            'outcome'   => '',
            'quote'     => [],
            'deliverables' => ['Production operating model', 'Adaptation workflow', 'Asset library and rights metadata', 'Market review queue', 'Master production specification'],
            'measure'      => ['Adaptations per master asset', 'Turnaround per market', 'Rights and claims exceptions', 'Share of markets using the library'],
            'standards'    => ['iso9001', 'gdpr'],
            'artefact'     => 'global-content-production',
            'img' => ['file' => 'c-global-content-production.jpg', 'alt' => 'An edit suite with a video timeline on screen', 'w' => 1600, 'h' => 809, 'pos' => '50% 50%'],
            'gallery' => [
                ['file' => 'd-tote.jpg', 'alt' => 'A person holding a plain canvas tote bag against a concrete wall', 'w' => 1200, 'h' => 800, 'cap' => 'One master, adapted rather than re-shot'],
                ['file' => 'hero-docs.jpg', 'alt' => 'A team reading documentation together at a laptop', 'w' => 1200, 'h' => 900, 'cap' => 'The operating model, written down and owned'],
            ],
        ],

        [
            'slug'     => 'onboarding-with-disclosures',
            'title'    => 'Onboarding with disclosures designed in',
            'client'   => '',
            'industry' => 'financial-services',
            'dates'    => '',
            'duration' => '4–6 months',
            'scope'    => 'Product and engineering, with compliance in the room from week one',
            'brief'    => 'Get more applicants through KYC without hiding a single disclosure.',
            'problem'  => [
                'Applicants dropped out at the video-KYC step and at the Key Fact Statement, which arrived as a wall of text at the worst possible moment.',
                'The usual fix — shrink the disclosure — was not available, and should not have been. The disclosure was not the problem; its placement was.',
            ],
            'did' => [
                ['product-experience', 'Onboarding and video-KYC journey'],
                ['brand-design', 'Trust signals and product voice'],
                ['technology-intelligence', 'Secure web and app build'],
            ],
            'system' => 'A mobile onboarding flow where the Key Fact Statement, consent and KYC steps are designed as part of the journey, measured step by step.',
            'build'  => [
                ['Disclosure as a step, not a gate', 'The Key Fact Statement was broken into the decisions it actually informs and placed beside each one, in full, with the complete document always one tap away.'],
                ['Video KYC that can fail gracefully', 'Connection quality is tested before the call, the applicant can resume rather than restart, and the queue position is honest.'],
                ['Product voice under pressure', 'Error and rejection states were written with compliance so they are accurate and human at the same time.'],
                ['Step-level analytics from day one', 'Every step reports entry, exit and reason, so a change can be judged on the whole path rather than on its own step.'],
            ],
            'call' => ['The judgement call', 'We measured the completion of the whole application, not of each screen. Two changes that improved their own step and hurt the path were reverted because of it.'],
            'outcome'   => '',
            'quote'     => [],
            'deliverables' => ['Journey and service blueprint', 'App and web screens', 'Disclosure content patterns', 'Step-level analytics', 'Accessibility conformance report'],
            'measure'      => ['Onboarding completion', 'Drop-off at each step', 'Time to approved account', 'Disclosure read-through at each placement'],
            'standards'    => ['wcag22', 'iso27001', 'dpdp'],
            'artefact'     => 'onboarding-with-disclosures',
            'img' => ['file' => 'c-onboarding-with-disclosures.jpg', 'alt' => 'A person using a phone outdoors in daylight, screen partly in shade', 'w' => 1400, 'h' => 920, 'pos' => '50% 45%'],
            'gallery' => [
                ['file' => 's-financial-services.jpg', 'alt' => 'The glass facade of an office tower with an external spiral stair', 'w' => 674, 'h' => 1200, 'cap' => 'Regulated onboarding, designed rather than bolted on'],
                ['file' => 'm-discover.jpg', 'alt' => 'A research interview being set up with a camera and notes', 'w' => 1100, 'h' => 733, 'cap' => 'Applicants tested on their own phones, not in a lab'],
            ],
        ],

    ],
];
