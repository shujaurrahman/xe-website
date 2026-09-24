<?php /* DRAFT COPY — review before launch */
/**
 * Marketing Technology capability pages — per-topic headings, photograph and second showcase (polish pass).
 * data/marketing-technology.php is shared and not edited here. Per capability:
 *   img   alt text for assets/imgs/marketing-technology/<slug>.jpg (offer photograph, "works best with" cards)
 *   h     key => [grey phrase, ink rest, lead] for flow · deliv · out · stack · std · next (template text is the fallback)
 *   x     the second showcase (./showcase.php): 'matrix' (a real table) or 'board' (columns of cards)
 *   prac  Customer Relationship Strategy only: one small working artefact per practice (same matrix shape)
 * '_apply' replaces the kit's product-engineering "how we apply it" line with what the standard means in marketing systems.
 * Every figure is illustrative — the shape of the artefact, never a client result.
 */
return [
    '_apply' => [
        'gdpr'        => 'Consent captured per purpose and channel, tracking tags fired only after consent (Consent Mode v2 where Google is used), and erasure requests reaching every connected tool.',
        'dpdp'        => 'Notices and consent records for India-based customers, with withdrawal honoured in every journey and channel within the same working day.',
        'iso27701'    => 'Every marketing tool that holds personal data listed with its purpose, retention and processor terms, and kept current as tools are added.',
        'wcag22'      => 'Emails, landing pages and in-app messages checked for contrast, alt text, reading order and keyboard use before they are approved for send.',
        'nist-ai-rmf' => 'Each model that scores, targets or writes is inventoried with an owner, a measured error rate and a threshold that stops it.',
        'eu-ai-act'   => 'AI-generated content labelled where required, targeting and scoring use cases classified by risk, and a person able to override every automated decision.',
        'iso42001'    => 'Generative tools governed as a managed AI system: approved uses, prompt and model versions logged, and periodic review of what they produced.',
        'cwv'         => 'Landing pages and tag containers held to LCP ≤ 2.5 s, INP ≤ 200 ms and CLS ≤ 0.1 at p75, with tags audited so tracking never costs the page.',
        'pci-dss'     => 'Payment links and checkout handed to a tokenising provider, so card data never enters the CRM, the sales tools or the message logs.',
    ],

    'ai-driven-marketing-automation' => [
        'img' => 'A person working with a laptop and an AI assistant interface on screen',
        'h' => [
            'flow'  => ['From event to message,', 'with consent checked first.', 'The path one trigger takes through an automated journey. The highlighted step is where the journey logic lives.'],
            'deliv' => ['Journeys you can read,', 'change and switch off.', 'Every journey is configured in your own automation platform, documented step by step, with its holdout and owner named.'],
            'out'   => ['Fewer, better-timed messages.', 'Measured against a holdout.', 'Automation succeeds when each journey proves its lift, contact pressure falls and nothing sends without a named approver.'],
            'stack' => ['Your CRM and automation platform.', 'Orchestration where it helps.', 'The platforms, messaging channels and orchestration tools we build journeys on, most used first.'],
            'std'   => ['Consent before the first send.', 'Oversight on every model.', 'Frameworks each journey is designed and documented against. Frameworks we build to, not certifications we hold.'],
            'next'  => ['Journeys need content and a strategy.', 'These supply both.', 'Infrastructure gives journeys one content source; Customer Strategy decides which journeys matter.'],
        ],
        'x' => [
            'kind' => 'matrix', 'lbl' => 'Journey audit', 'h' => ['Every journey passes five checks.', 'Or it does not go live.'],
            'lead' => 'The audit each journey is held to before launch and every quarter after: consent, pressure, fallback, holdout and a named owner.',
            'win' => 'Journey audit · Your company · Q3', 'aria' => 'Journey audit table, scrolls sideways',
            'cols' => ['Journey', 'Consent checked', 'Frequency cap', 'Fallback rule', 'Holdout', 'Owner'],
            'rows' => [
                ['Trial to paid', ['Per channel', 'ok'], ['3 a week', 'ok'], ['Rule-based', 'ok'], ['10%', 'ok'], 'Growth lead'],
                ['Cart recovery', ['Per channel', 'ok'], ['2 in 48 h', 'ok'], ['Rule-based', 'ok'], ['5%', 'ok'], 'E-commerce'],
                ['Renewal reminder', ['Email only', 'warn'], ['None set', 'bad'], ['Rule-based', 'ok'], ['None', 'bad'], 'Customer success'],
                ['Win-back', ['Per channel', 'ok'], ['1 a week', 'ok'], ['Missing', 'bad'], ['10%', 'ok'], 'Unassigned'],
            ],
            'tag' => '2 journeys paused until the gaps close',
            'note' => 'Illustrative example of the audit we run. A journey without a holdout cannot show that it works.',
        ],
    ],

    'content-communication-infrastructure' => [
        'img' => 'Network cabling and connectors, the plumbing behind every channel',
        'h' => [
            'flow'  => ['One source,', 'every channel it reaches.', 'How one message moves from the content model to a delivered send. The highlighted step is where this capability works.'],
            'deliv' => ['Content models and adapters.', 'Documented to be extended.', 'A content model, channel adapters and a delivery log, configured in your accounts with the runbook to add the next channel.'],
            'out'   => ['Faster to publish,', 'consistent everywhere.', 'Infrastructure succeeds when a message ships to every channel from one source, in every language, with each send accounted for.'],
            'stack' => ['Headless CMS to channel API.', 'Chosen for your team.', 'Content platforms, search, messaging and edge tools we build communication infrastructure on.'],
            'std'   => ['Accessible, fast and consented.', 'In every channel.', 'Frameworks every template and page is built against. Frameworks we build to, not certifications we hold.'],
            'next'  => ['Infrastructure is the road.', 'These are what travels on it.', 'Creative AI fills the content model; Automation decides when each message goes.'],
        ],
        'x' => [
            'kind' => 'matrix', 'lbl' => 'Template coverage', 'h' => ['Every message type,', 'every channel, one status.'],
            'lead' => 'The coverage map teams publish from: which message types exist per channel, in which languages, and which are still waiting for approval.',
            'win' => 'Template registry · Your company · 4 languages', 'aria' => 'Template coverage table, scrolls sideways',
            'cols' => ['Message type', 'Email', 'SMS', 'WhatsApp', 'Push', 'In-app'],
            'rows' => [
                ['Order confirmed', ['4 of 4', 'ok'], ['4 of 4', 'ok'], ['Approved', 'ok'], ['4 of 4', 'ok'], '—'],
                ['Delivery update', ['4 of 4', 'ok'], ['4 of 4', 'ok'], ['Pending review', 'warn'], ['4 of 4', 'ok'], ['4 of 4', 'ok']],
                ['Price drop alert', ['3 of 4', 'warn'], '—', ['Rejected: wording', 'bad'], ['4 of 4', 'ok'], ['4 of 4', 'ok']],
                ['Account security', ['4 of 4', 'ok'], ['4 of 4', 'ok'], '—', '—', ['4 of 4', 'ok']],
            ],
            'tag' => 'WhatsApp template resubmitted with revised wording',
            'note' => 'Illustrative example. WhatsApp business templates need approval before use; the registry tracks it.',
        ],
    ],

    'ai-campaign-optimization' => [
        'img' => 'A laptop showing charts and figures beside a notebook',
        'h' => [
            'flow'  => ['Spend moves on evidence,', 'not on last week’s dashboard.', 'The loop one budget decision takes. The highlighted step is where the optimisation model does its work.'],
            'deliv' => ['Models, tests and read-outs.', 'In your warehouse.', 'The measurement model, the test design and the read-outs live in your own data stack, with the code to rerun them.'],
            'out'   => ['Spend that proves itself.', 'Three numbers finance will sign.', 'Optimisation succeeds when lift is measured against a control, cost per outcome falls and budget moves on evidence.'],
            'stack' => ['Warehouse first.', 'Then the models on top.', 'The analytics, warehouse, modelling and reporting tools we use to measure and move spend.'],
            'std'   => ['Measured without tracking people', 'further than they agreed.', 'Frameworks each model and tag plan is designed against. Frameworks we build to, not certifications we hold.'],
            'next'  => ['Better spend needs better creative', 'and better leads.', 'Creative AI gives the model more to test; Lead Gen turns the traffic into pipeline.'],
        ],
        'x' => [
            'kind' => 'matrix', 'lbl' => 'Holdout read-out', 'h' => ['Test regions against control regions.', 'Then decide.'],
            'lead' => 'The read-out a budget decision rests on: matched regions with and without the change, the difference and how sure we are of it.',
            'win' => 'Geo holdout · Paid social uplift · 6 weeks', 'aria' => 'Holdout read-out table, scrolls sideways',
            'cols' => ['Measure', 'Test regions (8)', 'Control regions (8)', 'Difference', '90% interval'],
            'rows' => [
                ['Orders per 10k people', '41.2', '37.6', ['+9.6%', 'ok'], '+4.1% to +14.8%'],
                ['Cost per incremental order', '₹ 612', '—', ['Below ₹ 700 target', 'ok'], '₹ 520 to ₹ 890'],
                ['New customers share', '38%', '36%', ['+2 pts', 'warn'], '−1 to +5 pts'],
                ['Returns within 30 days', '6.1%', '6.0%', ['No change', 'ok'], '−0.8 to +1.0 pts'],
            ],
            'tag' => 'Scale spend 25%; retest new-customer share',
            'note' => 'Illustrative read-out. An interval that crosses zero is reported as unproven, not as a win.',
        ],
    ],

    'ai-creative-solutions' => [
        'img' => 'A designer’s desk with colour swatches and layout sketches',
        'h' => [
            'flow'  => ['Generated at scale,', 'approved by a person.', 'The route one creative variant takes from brief to live ad. The highlighted step is where generation happens.'],
            'deliv' => ['Pipelines, prompts and brand checks.', 'Yours to run.', 'The generation pipeline, the brand rules it checks against and the approval log, set up in your accounts.'],
            'out'   => ['More variants worth testing.', 'None off-brand.', 'Creative AI succeeds when variant output rises, brand checks catch what they should and every live asset had a human approve it.'],
            'stack' => ['Models chosen per format.', 'Brand rules in code.', 'Model providers, hosting and design tools we use for generative creative, with your keys and accounts.'],
            'std'   => ['Labelled, logged and approved.', 'Before anything goes live.', 'Frameworks every generative workflow is designed against. Frameworks we build to, not certifications we hold.'],
            'next'  => ['Variants need a test', 'and a place to publish.', 'Campaign AI decides which variant wins; Infrastructure puts it in every channel.'],
        ],
        'x' => [
            'kind' => 'board', 'lbl' => 'Variant review queue', 'h' => ['Every variant is checked twice.', 'By the rules, then by a person.'],
            'lead' => 'The queue a generative pipeline feeds: what the model produced, what the brand check flagged and what a named reviewer approved.',
            'win' => 'Review queue · Monsoon sale · 48 variants',
            'cols' => [
                ['Generated', 'na', [['Hero, 1:1 · headline v7', 'Model B · prompt 3.2', 'Waiting for brand check']]],
                ['Brand check', 'warn', [['Story, 9:16 · headline v2', 'Logo clear-space 6 px short', 'Auto-fix proposed'], ['Banner, 728 × 90', 'Claim “lowest price” flagged', 'Needs legal wording']]],
                ['Approved', 'ok', [['Hero, 4:5 · headline v3', 'All 9 brand rules pass', 'Approved by: brand lead']]],
                ['Rejected', 'bad', [['Hero, 1:1 · headline v5', 'Hands rendered incorrectly', 'Rejected by: designer']]],
            ],
            'note' => 'Illustrative queue. Nothing generated reaches a live channel without a named approval in the log.',
        ],
    ],

    'ai-lead-generation' => [
        'img' => 'A person reviewing notes and a laptop at a desk',
        'h' => [
            'flow'  => ['From first visit to a sales call,', 'with the score explained.', 'The route one lead takes through capture, scoring and routing. The highlighted step is where the model scores.'],
            'deliv' => ['A score sales can question.', 'And the pipeline behind it.', 'The scoring model, its explanation, the routing rules and the feedback loop, configured in your CRM.'],
            'out'   => ['Sales calls the right people first.', 'Three measures that show it.', 'Lead generation succeeds when high scores convert, response time falls and sales trusts the score enough to use it.'],
            'stack' => ['Your CRM holds the truth.', 'The model sits beside it.', 'CRM, messaging, analytics and modelling tools we use to capture, score and route leads.'],
            'std'   => ['Scored on what people shared.', 'Explained when asked.', 'Frameworks every scoring model and form is designed against. Frameworks we build to, not certifications we hold.'],
            'next'  => ['A qualified lead needs a fast reply', 'and a fair budget.', 'Sales automation acts on the score; Campaign AI spends where good leads come from.'],
        ],
        'x' => [
            'kind' => 'matrix', 'lbl' => 'Score explanation', 'h' => ['A score of 82 means nothing.', 'Until it shows its reasons.'],
            'lead' => 'What a salesperson sees beside every scored lead: the signals that moved the score, by how much, and which ones the model is not allowed to use.',
            'win' => 'Lead 4471 · Score 82 of 100 · Your company', 'aria' => 'Score explanation table, scrolls sideways',
            'cols' => ['Signal', 'Value', 'Effect on score', 'Source'],
            'rows' => [
                ['Pricing page visits, 7 days', '4', ['+18', 'ok'], 'Web analytics, consented'],
                ['Company size band', '200–500', ['+14', 'ok'], 'Form field'],
                ['Asked for a demo', 'Yes', ['+22', 'ok'], 'Form field'],
                ['Email domain', 'Personal', ['−9', 'warn'], 'Form field'],
                ['Age, gender, location of person', 'Not used', ['Excluded by design', 'bad'], 'Policy'],
            ],
            'tag' => 'Routed to account executive · reply target 1 working hour',
            'note' => 'Illustrative example. Sales can mark a score wrong, and that feedback retrains the model.',
        ],
    ],

    'automated-dynamic-sales' => [
        'img' => 'A card payment being made at a shop counter',
        'h' => [
            'flow'  => ['Offers that change with the moment,', 'inside rules you set.', 'The path one sales decision takes. The highlighted step is where the dynamic offer is chosen.'],
            'deliv' => ['Rules, playbooks and integrations.', 'Owned by your sales team.', 'Pricing and offer rules, sales playbooks and payment integrations, configured in your systems with a change log.'],
            'out'   => ['Faster deals, protected margin.', 'Three measures that show it.', 'Dynamic sales succeeds when response time falls, win rate rises and no automated offer ever breaks a margin floor.'],
            'stack' => ['CRM, commerce and payments.', 'Joined, not replaced.', 'CRM, commerce, payments and messaging tools we connect so offers and follow-ups run themselves.'],
            'std'   => ['Card data never in the CRM.', 'Every offer auditable.', 'Frameworks every pricing rule and payment flow is designed against. Frameworks we build to, not certifications we hold.'],
            'next'  => ['Sales runs on good leads', 'and long relationships.', 'Lead Gen fills the pipeline; Customer Strategy keeps the customers who close.'],
        ],
        'x' => [
            'kind' => 'matrix', 'lbl' => 'Offer guardrails', 'h' => ['Automation proposes the offer.', 'The guardrails decide if it goes.'],
            'lead' => 'The rules every automated offer is checked against before it reaches a customer, with who owns each rule and what happens when one trips.',
            'win' => 'Offer guardrails · Your company · live', 'aria' => 'Offer guardrails table, scrolls sideways',
            'cols' => ['Rule', 'Setting', 'Last 30 days', 'When it trips', 'Owner'],
            'rows' => [
                ['Margin floor', '≥ 22% after discount', ['0 breaches', 'ok'], 'Offer blocked', 'Finance'],
                ['Discount above 15%', 'Manager approval', ['14 sent for approval', 'warn'], 'Held for approval', 'Sales lead'],
                ['Stock check', 'Live inventory', ['3 offers withdrawn', 'ok'], 'Offer replaced', 'Operations'],
                ['Same customer, same week', 'Max 2 offers', ['1 breach · fixed', 'bad'], 'Second offer suppressed', 'CRM owner'],
            ],
            'tag' => 'Every trip logged with the rule that caught it',
            'note' => 'Illustrative example. Guardrails are agreed with finance before any offer is automated.',
        ],
    ],

    'customer-relationship-strategy' => [
        'img' => 'Sticky notes of a customer journey on a wall',
        'h' => [
            'flow'  => ['Five practices,', 'in the order a customer meets them.', 'Each practice hands the next a sharper definition of who the customer is and what they need.'],
            'deliv' => ['A relationship plan,', 'wired into your CRM.', 'Journey maps, segment definitions, contact rules, the loyalty model and lifecycle triggers, documented and configured in your own systems.'],
            'out'   => ['Customers who stay longer.', 'Measured, not assumed.', 'Relationship strategy succeeds when retention and lifetime value rise against a holdout and contact pressure stays within the rules.'],
            'stack' => ['One customer record.', 'Every tool reading from it.', 'CRM, analytics, warehouse and research tools we use to design and run relationship programmes.'],
            'std'   => ['Relationships built on consent.', 'Not on data collected by default.', 'Frameworks each programme is designed against. Frameworks we build to, not certifications we hold.'],
            'next'  => ['A strategy needs engines to run it.', 'These are the two.', 'Automation runs the lifecycle journeys; Campaign AI measures what each programme adds.'],
        ],
        'prac' => [
            ['Journey map · first 90 days', ['Moment', 'Customer goal', 'Pain today', 'Owner'], [
                ['Day 0 · sign-up', 'Get started quickly', ['Three emails in an hour', 'bad'], 'Lifecycle'],
                ['Day 7 · first value', 'See a result', ['No guidance', 'warn'], 'Product'],
                ['Day 30 · first bill', 'Understand the charge', ['Invoice unclear', 'warn'], 'Finance'],
            ]],
            ['Segment definitions · v2', ['Segment', 'Rule', 'Size', 'Refresh'], [
                ['New and active', 'Joined < 30 d, ≥ 3 sessions', '12%', 'Daily'],
                ['At risk', 'Usage down 40% over 4 weeks', ['8%', 'warn'], 'Daily'],
                ['Loyal', '≥ 4 orders, 12 months', ['21%', 'ok'], 'Weekly'],
            ]],
            ['Contact pressure · per customer, per week', ['Segment', 'Email', 'SMS / WhatsApp', 'Quiet hours'], [
                ['New and active', ['3', 'ok'], ['1', 'ok'], '21:00–09:00'],
                ['At risk', ['2', 'ok'], ['1', 'ok'], '21:00–09:00'],
                ['Opted out of marketing', ['0', 'bad'], ['0', 'bad'], 'Service messages only'],
            ]],
            ['Loyalty economics · per member, a year', ['Tier', 'Reward cost', 'Extra margin', 'Holds up?'], [
                ['Silver', '₹ 240', '₹ 610', ['Yes', 'ok']],
                ['Gold', '₹ 900', '₹ 1,450', ['Yes', 'ok']],
                ['Platinum', '₹ 3,200', '₹ 2,700', ['No · redesign', 'bad']],
            ]],
            ['Lifecycle triggers', ['Trigger', 'Action', 'Holdout', 'Status'], [
                ['Usage drop 40%', 'Check-in from success team', '10%', ['Live', 'ok']],
                ['Renewal in 30 days', 'Value summary email', '10%', ['Live', 'ok']],
                ['Third order', 'Loyalty invitation', '5%', ['Draft', 'warn']],
            ]],
        ],
    ],
];
