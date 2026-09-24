<?php
/**
 * Marketing Technology — the service catalogue.
 *
 * What a visitor can actually buy on the discipline hub and on each of the seven capability pages,
 * grouped into categories and offered in engagement packages. One shared component renders this
 * data identically on every page. Clicking a service opens the contact page with it pre-selected,
 * so every enquiry arrives tagged.
 *
 * Shape
 *   '<page-key>' => [
 *     'discipline' => 'marketing-technology',
 *     'title'      => heading HTML: <span class="g">grey first phrase.</span> ink rest
 *     'lead'       => intro paragraph
 *     'categories' => [[
 *         'key', 'name', 'icon' (an xt_icon name, partials/tech/kit.php),
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
 * Page keys: 'marketing-technology' (the hub), then the seven capability slugs in site order.
 * Service id, the tag the contact page receives: '<page-key>:<offer-key>'.
 * Hub offers also carry 'cap': the capability slug the service belongs to.
 *
 * IMPORTANT — 'customer-relationship-strategy' is ONE page covering five areas: journey mapping,
 * customer segmentation and insights, engagement programmes, loyalty strategy and lifecycle
 * marketing. They are its five categories here, never five pages and never five capabilities.
 *
 * Packages: sprint (1–3 week fixed-scope sprint), project (fixed scope, fixed price), milestone
 * (gated, separately paid phases), retainer (monthly capacity with service levels), enterprise
 * (multi-workstream programme with governance), squad (dedicated team, time & materials).
 *
 * Truthfulness: no prices, client names, results, certifications or partner tiers. Technologies
 * are ones we work with, never partnerships. Consent, deliverability and AI transparency work is
 * built to the regulations named; nothing here promises inbox placement, rankings or lead volume.
 * Every 'time' is typical, not promised, and is marked PLACEHOLDER until confirmed.
 *
 * DRAFT COPY — review before launch.
 *
 * Voice: plain English first, technically correct second. Calm, short, active. No exclamation marks.
 */

return [

    /* =============================================================================================
       Hub — the services people most often start with, across all seven capabilities
       ============================================================================================= */
    'marketing-technology' => [
        'discipline' => 'marketing-technology',
        'title'      => '<span class="g">Start with one system.</span> Connect the rest as you go.',
        'lead'       => 'These are the services clients most often start with, across all seven marketing technology capabilities. Choose one and your enquiry reaches the right team with it already attached. Each can be bought as a short sprint, a fixed-scope project or ongoing capacity.',
        'categories' => [

            ['key' => 'foundations', 'name' => 'Data & foundations', 'icon' => 'database', 'offers' => [
                [
                    'key'      => 'martech-audit',
                    'cap'      => 'ai-driven-marketing-automation',
                    'name'     => 'Martech stack audit & roadmap',
                    'desc'     => 'An independent read on the marketing tools you already pay for: what is used, what overlaps, what is missing and what to do about it.',
                    'includes' => ['Tool inventory with cost, owner and usage', 'Data flow and integration map', 'Gap and overlap analysis', 'Prioritised roadmap with a rationalisation plan'],
                    'tags'     => ['Audit', 'Rationalisation', 'Roadmap'],
                    'stack'    => ['hubspot', 'salesforce', 'zoho', 'googletagmanager'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams paying for more marketing tools than anyone can name.',
                ],
                [
                    'key'      => 'measurement-foundations',
                    'cap'      => 'ai-campaign-optimization',
                    'name'     => 'Tracking & measurement foundations',
                    'desc'     => 'Accurate, consented measurement of what marketing actually produces, so every report downstream starts from the same numbers.',
                    'includes' => ['Measurement plan tied to commercial goals', 'GA4 and Tag Manager implementation', 'Server-side tagging and conversion APIs', 'Consent mode and preference handling', 'One conversion definition across platforms'],
                    'tags'     => ['GA4', 'Server-side', 'Consent mode'],
                    'stack'    => ['googleanalytics', 'googletagmanager', 'google', 'googlebigquery'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose platform numbers and finance numbers never match.',
                ],
                [
                    'key'      => 'customer-data-foundation',
                    'cap'      => 'customer-relationship-strategy',
                    'name'     => 'Customer data & identity foundation',
                    'desc'     => 'One consented customer record that marketing, sales and service all read from, instead of four exports that disagree.',
                    'includes' => ['Source system audit and data map', 'Identity resolution and deduplication rules', 'Consent, preference and retention model', 'Unified profile in your warehouse or platform'],
                    'tags'     => ['Identity', 'Consent', 'Single view'],
                    'stack'    => ['snowflake', 'googlebigquery', 'dbt', 'airbyte', 'postgresql'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose customer data is split across commerce, CRM and support.',
                ],
                [
                    'key'      => 'content-model',
                    'cap'      => 'content-communication-infrastructure',
                    'name'     => 'Content model & headless CMS',
                    'desc'     => 'Structure your content as reusable data rather than as pages, so one edit is correct everywhere it appears.',
                    'includes' => ['Content audit and model design', 'Headless CMS build and workflow', 'Reusable component library', 'Migration plan and editor training'],
                    'tags'     => ['Headless', 'Structured content', 'Reuse'],
                    'stack'    => ['contentful', 'sanity', 'strapi', 'wordpress'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams retyping the same product facts into every channel.',
                ],
            ]],

            ['key' => 'automation', 'name' => 'Automation & journeys', 'icon' => 'workflow', 'offers' => [
                [
                    'key'      => 'lifecycle-journeys',
                    'cap'      => 'ai-driven-marketing-automation',
                    'name'     => 'Lifecycle journey build',
                    'desc'     => 'Automated journeys that carry customers from first sign-up to repeat purchase: welcome, onboarding, nurture, recovery, win-back and renewal.',
                    'includes' => ['Journey design with entry, exit and suppression rules', 'Message templates across email, SMS and WhatsApp', 'Trigger and event set-up', 'Holdout groups and reporting'],
                    'tags'     => ['Journeys', 'Triggers', 'Always-on'],
                    'stack'    => ['hubspot', 'salesforce', 'zoho', 'twilio', 'whatsapp'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose marketing goes quiet between campaigns.',
                ],
                [
                    'key'      => 'platform-implementation',
                    'cap'      => 'ai-driven-marketing-automation',
                    'name'     => 'Marketing automation platform set-up',
                    'desc'     => 'Implementation or migration of your marketing automation platform, rebuilt around your data model rather than copied across as it was.',
                    'includes' => ['Platform selection support if needed', 'Data model, fields and subscriber states', 'Journey and template rebuild', 'Integration with CRM, commerce and analytics', 'Team training and runbooks'],
                    'tags'     => ['Implementation', 'Migration', 'Training'],
                    'stack'    => ['hubspot', 'salesforce', 'zoho', 'n8n'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams implementing a new platform or escaping one that never got used.',
                ],
                [
                    'key'      => 'messaging-channels',
                    'cap'      => 'content-communication-infrastructure',
                    'name'     => 'Email, SMS & WhatsApp set-up',
                    'desc'     => 'Get your messages delivered: authenticated senders, approved WhatsApp templates and clean lists, configured once and monitored after.',
                    'includes' => ['SPF, DKIM, DMARC and BIMI configuration', 'Dedicated IP warm-up and list hygiene', 'WhatsApp Business sender and template approval', 'One-click unsubscribe and preference handling'],
                    'tags'     => ['Deliverability', 'WhatsApp', 'Authentication'],
                    'stack'    => ['twilio', 'whatsapp', 'cloudflare'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose email lands in spam or who are starting on WhatsApp.',
                ],
                [
                    'key'      => 'marketing-agents',
                    'cap'      => 'ai-driven-marketing-automation',
                    'name'     => 'Agentic marketing operations',
                    'desc'     => 'AI agents that take the assembly work out of campaigns — drafting, building audiences and running pre-flight checks — with your team approving every send.',
                    'includes' => ['Agent design with scoped permissions', 'Connection to your platform and content library', 'Automated pre-flight QA checks', 'Human approval steps and a full action log'],
                    'tags'     => ['Agents', 'Human approval', 'Audit log'],
                    'stack'    => ['anthropic', 'openai', 'n8n', 'hubspot', 'slack'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Small marketing teams shipping more campaigns than they have hands for.',
                ],
            ]],

            ['key' => 'growth', 'name' => 'Demand & performance', 'icon' => 'trend-up', 'offers' => [
                [
                    'key'      => 'incrementality',
                    'cap'      => 'ai-campaign-optimization',
                    'name'     => 'Incrementality testing & mix modelling',
                    'desc'     => 'Find out what your advertising actually causes, rather than what each platform claims credit for, and use it to plan the budget.',
                    'includes' => ['Holdout and geo experiment design', 'Bayesian marketing mix model with adstock and saturation', 'Calibration of the model against experiment results', 'Budget scenarios by channel and market'],
                    'tags'     => ['Incrementality', 'MMM', 'Scenarios'],
                    'stack'    => ['python', 'googlebigquery', 'dbt', 'looker'],
                    'time'     => '8–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers whose channel reports add up to more conversions than they had.',
                ],
                [
                    'key'      => 'budget-optimisation',
                    'cap'      => 'ai-campaign-optimization',
                    'name'     => 'Campaign optimisation & budget allocation',
                    'desc'     => 'Weekly reallocation proposals across channels and campaigns, each with its expected effect, applied through platform APIs once you approve.',
                    'includes' => ['Pacing, cost and conversion monitoring', 'Reallocation proposals with confidence levels', 'Spend caps, exclusions and rollback', 'Anomaly alerts within hours'],
                    'tags'     => ['Allocation', 'Guardrails', 'Weekly'],
                    'stack'    => ['google', 'googleanalytics', 'python', 'looker'],
                    'time'     => '4–8 weeks to set up, then ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams managing spend across several platforms and markets.',
                ],
                [
                    'key'      => 'lead-scoring',
                    'cap'      => 'ai-lead-generation',
                    'name'     => 'Lead scoring & routing',
                    'desc'     => 'Score leads on fit and intent using your own closed-won history, then route them to the right person within minutes.',
                    'includes' => ['Ideal customer profile from won and lost deals', 'Fit and engagement scoring model', 'Score explanations inside the CRM', 'Routing rules, alerts and response targets'],
                    'tags'     => ['Scoring', 'Routing', 'Speed to lead'],
                    'stack'    => ['hubspot', 'salesforce', 'python', 'scikitlearn'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sales teams filtering the good leads out of the noise by hand.',
                ],
                [
                    'key'      => 'conversational-qualification',
                    'cap'      => 'ai-lead-generation',
                    'name'     => 'Conversational lead qualification',
                    'desc'     => 'An assistant on your site, on WhatsApp or on the phone that answers real questions, qualifies against your criteria and books the meeting.',
                    'includes' => ['Assistant grounded in your own content', 'Qualification criteria agreed with sales', 'Calendar booking and CRM handover with context', 'Escalation to a person at any point'],
                    'tags'     => ['Chat', 'WhatsApp', 'Booking'],
                    'stack'    => ['anthropic', 'openai', 'whatsapp', 'twilio', 'hubspot'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses losing enquiries outside office hours.',
                ],
            ]],

            ['key' => 'creative', 'name' => 'Creative & content at scale', 'icon' => 'sparkle', 'offers' => [
                [
                    'key'      => 'variant-engine',
                    'cap'      => 'ai-creative-solutions',
                    'name'     => 'AI creative variant engine',
                    'desc'     => 'Turn one approved concept into every size, language and audience variant your media plan needs, inside your brand rules.',
                    'includes' => ['Modular template system on your brand tokens', 'Generative copy and imagery within brand constraints', 'Automated brand and claim checks', 'Human review and approval before release'],
                    'tags'     => ['Variants', 'On brand', 'At scale'],
                    'stack'    => ['openai', 'googlegemini', 'replicate', 'figma'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers whose adaptation queue sets the pace of the campaign.',
                ],
                [
                    'key'      => 'dco',
                    'cap'      => 'ai-creative-solutions',
                    'name'     => 'Dynamic creative & product feeds',
                    'desc'     => 'Ads assembled per audience and context, and catalogue creative that stays accurate as prices and stock change.',
                    'includes' => ['Component set and assembly rules', 'Product feed hygiene and enrichment', 'Price, stock and offer accuracy checks', 'Performance by component fed back into the next brief'],
                    'tags'     => ['DCO', 'Feeds', 'Commerce'],
                    'stack'    => ['shopify', 'google', 'cloudflare', 'python'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Retail and commerce brands advertising a large catalogue.',
                ],
                [
                    'key'      => 'localisation',
                    'cap'      => 'content-communication-infrastructure',
                    'name'     => 'Localisation & market adaptation',
                    'desc'     => 'Launch the same campaign in many markets without rebuilding it each time, with in-market review built into the workflow.',
                    'includes' => ['Machine translation with human review', 'Glossary and tone guidance per market', 'Right-to-left and script support', 'Regional legal and advertising lines'],
                    'tags'     => ['Locales', 'Transcreation', 'Review'],
                    'stack'    => ['contentful', 'sanity', 'openai'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands running the same campaign across several countries.',
                ],
                [
                    'key'      => 'dam',
                    'cap'      => 'content-communication-infrastructure',
                    'name'     => 'Asset library & usage rights',
                    'desc'     => 'One library for photography, video, logos and templates, with licence terms and expiry recorded against every asset.',
                    'includes' => ['Asset library set-up and taxonomy', 'Rights, territory and expiry metadata', 'Bulk migration and tagging', 'Access rules and a self-serve brand portal'],
                    'tags'     => ['DAM', 'Rights', 'Brand portal'],
                    'stack'    => ['contentful', 'cloudflare', 'figma'],
                    'time'     => '5–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose assets live in shared drives and chat threads.',
                ],
            ]],

            ['key' => 'revenue', 'name' => 'Sales & revenue operations', 'icon' => 'handshake', 'offers' => [
                [
                    'key'      => 'crm-automation',
                    'cap'      => 'automated-dynamic-sales',
                    'name'     => 'CRM automation & hygiene',
                    'desc'     => 'A CRM that keeps itself current: activity captured automatically, duplicates prevented and stage rules enforced.',
                    'includes' => ['Sales process and stage definitions', 'Automatic activity capture and logging', 'Duplicate prevention and data validation', 'Dashboards rebuilt on the new definitions'],
                    'tags'     => ['CRM', 'Hygiene', 'Process'],
                    'stack'    => ['salesforce', 'hubspot', 'zoho'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sales leaders who cannot trust their own pipeline report.',
                ],
                [
                    'key'      => 'cpq',
                    'cap'      => 'automated-dynamic-sales',
                    'name'     => 'Quoting, pricing & approvals',
                    'desc'     => 'Configure, price and quote flows with discount thresholds and approval chains built in, so margin is protected in the moment rather than reviewed later.',
                    'includes' => ['Pricing and discount rules by segment and term', 'Quote templates and approval chains', 'Quote-to-cash and invoicing integration', 'Tokenised payment links where they fit'],
                    'tags'     => ['CPQ', 'Approvals', 'Margin'],
                    'stack'    => ['salesforce', 'hubspot', 'stripe', 'razorpay'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams quoting in spreadsheets and discounting without a rule.',
                ],
                [
                    'key'      => 'conversation-intelligence',
                    'cap'      => 'automated-dynamic-sales',
                    'name'     => 'Conversation intelligence',
                    'desc'     => 'Calls and meetings transcribed with consent, then turned into CRM notes, objection patterns and coaching themes.',
                    'includes' => ['Consent capture in the call and meeting flow', 'Transcription, summary and CRM write-back', 'Objection and commitment extraction', 'Coaching themes for the team, not scores for individuals'],
                    'tags'     => ['Calls', 'Coaching', 'Consent'],
                    'stack'    => ['openai', 'anthropic', 'salesforce', 'hubspot'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sales teams where what was said never reaches the CRM.',
                ],
                [
                    'key'      => 'forecasting',
                    'cap'      => 'automated-dynamic-sales',
                    'name'     => 'Pipeline analytics & forecasting',
                    'desc'     => 'A forecast built on stage conversion, deal ageing and coverage, with its assumptions and its historic error both visible.',
                    'includes' => ['Pipeline and conversion analysis', 'Model-assisted forecast with ranges', 'Coverage, ageing and hygiene reporting', 'Weekly review pack for leadership'],
                    'tags'     => ['Forecast', 'Coverage', 'Weekly'],
                    'stack'    => ['salesforce', 'hubspot', 'googlebigquery', 'looker'],
                    'time'     => '5–9 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams forecasting from a spreadsheet of hopes.',
                ],
            ]],

            ['key' => 'customer', 'name' => 'Customer, loyalty & lifecycle', 'icon' => 'users', 'offers' => [
                [
                    'key'      => 'journey-mapping',
                    'cap'      => 'customer-relationship-strategy',
                    'name'     => 'Customer journey mapping',
                    'desc'     => 'Map the journey as customers actually experience it, across channels and into service, and find where they leave.',
                    'includes' => ['Customer and frontline interviews', 'Behavioural and transaction data analysis', 'Journey maps per segment with moments of truth', 'Prioritised fix and opportunity list'],
                    'tags'     => ['Journeys', 'Research', 'Drop-offs'],
                    'stack'    => ['miro', 'figma', 'googleanalytics', 'mixpanel'],
                    'time'     => '5–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands guessing why customers stop at a particular point.',
                ],
                [
                    'key'      => 'segmentation',
                    'cap'      => 'customer-relationship-strategy',
                    'name'     => 'Segmentation & customer insight',
                    'desc'     => 'Segments built from research and your own data, with value tiers and churn risk, that every team can actually use.',
                    'includes' => ['Needs-based and behavioural segmentation', 'Value tiers and lifetime value modelling', 'Churn and propensity models', 'Segment definitions written into your platforms'],
                    'tags'     => ['Segments', 'LTV', 'Churn'],
                    'stack'    => ['snowflake', 'googlebigquery', 'dbt', 'python', 'looker'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose segments live in a deck nobody opens.',
                ],
                [
                    'key'      => 'loyalty',
                    'cap'      => 'customer-relationship-strategy',
                    'name'     => 'Loyalty strategy & programme design',
                    'desc'     => 'A loyalty programme designed on the value customers want and modelled for margin, breakage and accounting liability before it launches.',
                    'includes' => ['Customer value and mechanic research', 'Earn, redeem, tier and benefit design', 'Economic model with margin and liability', 'Launch plan, member experience and measurement'],
                    'tags'     => ['Loyalty', 'Tiers', 'Economics'],
                    'stack'    => ['salesforce', 'hubspot', 'shopify'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands considering a loyalty programme, or carrying one that costs more than it returns.',
                ],
                [
                    'key'      => 'lifecycle-programme',
                    'cap'      => 'customer-relationship-strategy',
                    'name'     => 'Lifecycle marketing programme',
                    'desc'     => 'The full calendar of planned and triggered communication by lifecycle stage, with an owner, a measure and a holdout group for each.',
                    'includes' => ['Lifecycle stages and contact strategy', 'Triggered and planned communication calendar', 'Pressure rules and frequency caps', 'Retention and lifetime value dashboard'],
                    'tags'     => ['Lifecycle', 'Retention', 'Holdouts'],
                    'stack'    => ['hubspot', 'salesforce', 'twilio', 'whatsapp', 'looker'],
                    'time'     => '8–12 weeks, then ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands that acquire well and lose customers quietly.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer', 'enterprise', 'squad'],
    ],

    /* =============================================================================================
       01 · AI-Driven Marketing Automation
       ============================================================================================= */
    'ai-driven-marketing-automation' => [
        'discipline' => 'marketing-technology',
        'title'      => '<span class="g">Set it up once.</span> It works every hour after that.',
        'lead'       => 'We build the journeys, triggers and agents that keep marketing running between campaigns, across email, SMS, WhatsApp, push and in-app. Consent is enforced at send time, a person approves every campaign, and every journey has a holdout group so its contribution is measurable.',
        'categories' => [

            ['key' => 'platform', 'name' => 'Platform & foundations', 'icon' => 'sync', 'offers' => [
                [
                    'key'      => 'platform-implementation',
                    'name'     => 'Marketing automation platform implementation',
                    'desc'     => 'Set up your marketing automation platform properly the first time: data model, subscriber states, templates, journeys and integrations.',
                    'includes' => ['Data model, fields and subscriber states', 'CRM, commerce and analytics integration', 'Template and journey build', 'Permissions, workspaces and approval steps', 'Team training and runbooks'],
                    'tags'     => ['Implementation', 'Integration', 'Training'],
                    'stack'    => ['hubspot', 'salesforce', 'zoho', 'n8n'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams adopting a platform, or relaunching one nobody uses.',
                ],
                [
                    'key'      => 'platform-migration',
                    'name'     => 'Platform migration',
                    'desc'     => 'Move from one automation platform to another without losing journeys, consent records or deliverability.',
                    'includes' => ['Inventory of journeys, assets and audiences', 'Consent and subscriber state migration', 'Journey rebuild rather than lift and shift', 'Sender warm-up and cutover plan', 'Parallel run and reconciliation'],
                    'tags'     => ['Migration', 'Cutover', 'Consent'],
                    'stack'    => ['hubspot', 'salesforce', 'zoho', 'twilio'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams leaving a platform that has outgrown its usefulness or its price.',
                ],
                [
                    'key'      => 'martech-audit',
                    'name'     => 'Martech stack audit',
                    'desc'     => 'An independent read on the tools you pay for: usage, overlap, gaps and the cost of keeping things as they are.',
                    'includes' => ['Tool inventory with cost, owner and usage', 'Integration and data flow map', 'Gap, overlap and risk analysis', 'Rationalisation plan with a sequence'],
                    'tags'     => ['Audit', 'Cost', 'Roadmap'],
                    'stack'    => [],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing leaders asked to justify the technology line in the budget.',
                ],
                [
                    'key'      => 'data-hygiene',
                    'name'     => 'Marketing data model & hygiene',
                    'desc'     => 'Clean, deduplicated, correctly typed marketing data, with the rules that keep it that way after we leave.',
                    'includes' => ['Field audit and data dictionary', 'Deduplication and merge rules', 'Validation at point of capture', 'Decay, suppression and retention rules'],
                    'tags'     => ['Data quality', 'Deduplication', 'Retention'],
                    'stack'    => ['hubspot', 'salesforce', 'postgresql', 'dbt'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Databases with three versions of every contact.',
                ],
            ]],

            ['key' => 'journeys', 'name' => 'Journeys & programmes', 'icon' => 'workflow', 'offers' => [
                [
                    'key'      => 'welcome-onboarding',
                    'name'     => 'Welcome & onboarding journeys',
                    'desc'     => 'The first two weeks of a customer relationship, designed properly: what to say, in what order, on which channel, and when to stop.',
                    'includes' => ['Journey design with entry and exit rules', 'Email, WhatsApp and in-app messages', 'Progressive profiling and preference capture', 'Holdout group and first-cycle report'],
                    'tags'     => ['Welcome', 'Onboarding', 'Activation'],
                    'stack'    => ['hubspot', 'salesforce', 'twilio', 'whatsapp'],
                    'time'     => '4–7 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose new customers go quiet in the first month.',
                ],
                [
                    'key'      => 'recovery-journeys',
                    'name'     => 'Cart, browse & form recovery',
                    'desc'     => 'Recover the demand you already earned: abandoned carts, browsed products and half-finished forms, handled without nagging.',
                    'includes' => ['Event tracking for cart, browse and form abandonment', 'Recovery sequences with frequency caps', 'Offer rules that protect margin', 'Incremental revenue measured against a holdout'],
                    'tags'     => ['Recovery', 'Commerce', 'Triggers'],
                    'stack'    => ['shopify', 'hubspot', 'twilio', 'whatsapp', 'googletagmanager'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Commerce and lead-generation sites with high drop-off at checkout or form.',
                ],
                [
                    'key'      => 'winback-journeys',
                    'name'     => 'Win-back & reactivation journeys',
                    'desc'     => 'Reach lapsing and lapsed customers with something worth returning for, and retire the ones who are genuinely gone.',
                    'includes' => ['Lapse definition per segment', 'Reactivation sequences with escalating offers', 'Sunset policy for unengaged contacts', 'Deliverability protection through list hygiene'],
                    'tags'     => ['Win-back', 'Reactivation', 'Sunset'],
                    'stack'    => ['hubspot', 'salesforce', 'twilio'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Databases where most of the list has not opened anything in a year.',
                ],
                [
                    'key'      => 'renewal-journeys',
                    'name'     => 'Renewal & subscription journeys',
                    'desc'     => 'Automated renewal, payment recovery and upgrade communication for subscription and contract businesses.',
                    'includes' => ['Renewal and notice period sequences', 'Failed payment recovery (dunning)', 'Upgrade and downgrade paths', 'Churn risk alerts to the account owner'],
                    'tags'     => ['Renewals', 'Dunning', 'Churn alerts'],
                    'stack'    => ['hubspot', 'salesforce', 'stripe', 'razorpay'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Subscription, SaaS and contract businesses losing revenue at renewal.',
                ],
            ]],

            ['key' => 'decisioning', 'name' => 'AI decisioning', 'icon' => 'brain', 'offers' => [
                [
                    'key'      => 'next-best-action',
                    'name'     => 'Next best action',
                    'desc'     => 'Choose the offer, message and channel per person from their own history, with a rule-based path always available underneath.',
                    'includes' => ['Feature set built from first-party behaviour', 'Model with confidence thresholds and fallbacks', 'Business rules and eligibility constraints', 'Holdout measurement against the current logic'],
                    'tags'     => ['Decisioning', 'Fallbacks', 'Holdouts'],
                    'stack'    => ['python', 'scikitlearn', 'googlebigquery', 'hubspot'],
                    'time'     => '8–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands with enough history that one message for everyone is leaving money behind.',
                ],
                [
                    'key'      => 'send-time-channel',
                    'name'     => 'Send time & channel selection',
                    'desc'     => 'Send when each person is likely to read, on the channel they respond to, instead of at nine on a Tuesday for everyone.',
                    'includes' => ['Per-person send time modelling', 'Channel preference and cost-aware selection', 'Quiet hours and regional rules', 'Lift measured against a fixed-time control'],
                    'tags'     => ['Send time', 'Channel', 'Quiet hours'],
                    'stack'    => ['hubspot', 'salesforce', 'python', 'twilio'],
                    'time'     => '4–7 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'High-volume senders whose open rates have flattened.',
                ],
                [
                    'key'      => 'predictive-audiences',
                    'name'     => 'Predictive audiences',
                    'desc'     => 'Audiences built on likelihood to buy, to lapse or to upgrade, refreshed automatically and shared with your ad platforms where consent allows.',
                    'includes' => ['Propensity and churn models with documentation', 'Automatic audience refresh', 'Consent-aware syndication to ad platforms', 'Drift monitoring and scheduled retraining'],
                    'tags'     => ['Propensity', 'Churn', 'Audiences'],
                    'stack'    => ['googlebigquery', 'dbt', 'python', 'scikitlearn', 'google'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams targeting everyone because they cannot tell who is close to buying.',
                ],
            ]],

            ['key' => 'agents', 'name' => 'Agentic operations', 'icon' => 'agent', 'offers' => [
                [
                    'key'      => 'campaign-agent',
                    'name'     => 'Campaign assembly agent',
                    'desc'     => 'An agent that turns an approved brief into a built campaign: variants drafted, audience assembled, links tagged, ready for a person to approve.',
                    'includes' => ['Agent design with scoped, least-privilege access', 'Grounding in your brand, claims and content library', 'Draft state only, never a direct send', 'Action log and rollback'],
                    'tags'     => ['Agents', 'Drafts', 'Least privilege'],
                    'stack'    => ['anthropic', 'openai', 'n8n', 'hubspot', 'slack'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams where assembly takes longer than the thinking.',
                ],
                [
                    'key'      => 'preflight-qa',
                    'name'     => 'Automated pre-flight QA',
                    'desc'     => 'Catch the mistakes that cost the most: broken links, wrong merge fields, missing unsubscribe, untagged URLs, rendering failures and suppression misses.',
                    'includes' => ['Automated checks before every send', 'Inbox and device rendering tests', 'Link, tracking and merge field validation', 'Blocked sends with a clear reason'],
                    'tags'     => ['QA', 'Rendering', 'Checks'],
                    'stack'    => ['playwright', 'n8n', 'hubspot'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Anyone who has sent an email addressed to "Dear FIRSTNAME".',
                ],
            ]],

            ['key' => 'compliance', 'name' => 'Consent & deliverability', 'icon' => 'shield', 'offers' => [
                [
                    'key'      => 'preference-centre',
                    'name'     => 'Preference centre & consent capture',
                    'desc'     => 'Let people choose what they hear about and how often, and record consent with its source, scope and timestamp.',
                    'includes' => ['Preference centre design and build', 'Consent capture with source and scope', 'Enforcement at send time, not at list build', 'Data subject request handling'],
                    'tags'     => ['Consent', 'Preferences', 'GDPR · DPDP'],
                    'stack'    => ['hubspot', 'salesforce', 'postgresql'],
                    'time'     => '4–7 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose only option is an unsubscribe link.',
                ],
                [
                    'key'      => 'deliverability',
                    'name'     => 'Deliverability set-up & remediation',
                    'desc'     => 'Get authenticated, get clean and stay out of the spam folder, with monitoring that tells you before a campaign does.',
                    'includes' => ['SPF, DKIM, DMARC and BIMI configuration', 'One-click unsubscribe and complaint handling', 'List hygiene, validation and sunset policy', 'IP and domain warm-up plan', 'Seed and placement monitoring'],
                    'tags'     => ['Authentication', 'Reputation', 'Monitoring'],
                    'stack'    => ['twilio', 'cloudflare', 'google'],
                    'time'     => '3–6 weeks, then monitored',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Senders with falling open rates or a spam folder problem.',
                ],
                [
                    'key'      => 'whatsapp-programme',
                    'name'     => 'WhatsApp messaging programme',
                    'desc'     => 'Run WhatsApp as a marketing and service channel properly: opt-in, approved templates, the 24-hour service window and a cost model you understand.',
                    'includes' => ['Business sender set-up and verification', 'Opt-in capture and consent records', 'Template design and approval', 'Service window and handover to a person', 'Cost per conversation modelling'],
                    'tags'     => ['WhatsApp', 'Opt-in', 'Templates'],
                    'stack'    => ['whatsapp', 'twilio', 'hubspot'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands in markets where WhatsApp is how customers prefer to talk.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'retainer', 'milestone', 'squad'],
    ],

    /* =============================================================================================
       02 · Content & Communication Infrastructure
       ============================================================================================= */
    'content-communication-infrastructure' => [
        'discipline' => 'marketing-technology',
        'title'      => '<span class="g">One source of content.</span> Every channel reads from it.',
        'lead'       => 'We build the layer marketing runs on: a structured content model, a governed asset library with usage rights, localisation that scales to new markets, and messaging infrastructure configured so email, SMS and WhatsApp actually arrive.',
        'categories' => [

            ['key' => 'content', 'name' => 'Content foundations', 'icon' => 'doc', 'offers' => [
                [
                    'key'      => 'content-model',
                    'name'     => 'Content model & architecture',
                    'desc'     => 'Design content as structured, reusable data instead of as pages, so the same fact can serve a website, an email, an ad and an assistant.',
                    'includes' => ['Content audit across channels', 'Content types, fields and relationships', 'Reuse and variant rules', 'Validation against your hardest real examples'],
                    'tags'     => ['Model', 'Reuse', 'Structured'],
                    'stack'    => ['contentful', 'sanity', 'strapi'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose content cannot be reused without a copy and paste.',
                ],
                [
                    'key'      => 'headless-cms',
                    'name'     => 'Headless CMS build',
                    'desc'     => 'A CMS your editors can work in and your developers can build on, with preview, versioning and roles that match how your team works.',
                    'includes' => ['Platform selection and set-up', 'Content types and editing experience', 'Preview, versioning and scheduled publishing', 'Roles, permissions and approval stages', 'Editor documentation and training'],
                    'tags'     => ['Headless', 'Preview', 'Workflow'],
                    'stack'    => ['contentful', 'sanity', 'strapi', 'nextdotjs'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands publishing across more than one site, app or channel.',
                ],
                [
                    'key'      => 'cms-migration',
                    'name'     => 'CMS migration',
                    'desc'     => 'Move years of content into a new model without losing search visibility, structure or the things that were working.',
                    'includes' => ['Content inventory with performance data', 'Field-level mapping and transformation', 'Keep, merge, rewrite or retire decision per page', 'Redirects and post-launch monitoring'],
                    'tags'     => ['Migration', 'Redirects', 'Mapping'],
                    'stack'    => ['wordpress', 'contentful', 'sanity', 'python'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sites replatforming with a decade of content behind them.',
                ],
                [
                    'key'      => 'content-ops',
                    'name'     => 'Editorial workflow & governance',
                    'desc'     => 'Who writes, who reviews, who approves and who is accountable, set up inside the tools the team already opens.',
                    'includes' => ['Roles, review stages and sign-off rules', 'Legal and compliance review paths', 'Planning calendar and briefing templates', 'Audit trail of every change'],
                    'tags'     => ['Workflow', 'Approvals', 'Audit'],
                    'stack'    => ['contentful', 'notion', 'jira', 'slack'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams where approval happens in email threads and nobody can find the final version.',
                ],
            ]],

            ['key' => 'assets', 'name' => 'Assets & rights', 'icon' => 'cube', 'offers' => [
                [
                    'key'      => 'dam-implementation',
                    'name'     => 'Digital asset management',
                    'desc'     => 'One searchable library for photography, video, logos and templates, organised so people find the right asset instead of remaking it.',
                    'includes' => ['Taxonomy and metadata schema', 'Bulk migration, tagging and deduplication', 'Derivative formats and delivery', 'Access rules by team and market'],
                    'tags'     => ['DAM', 'Taxonomy', 'Search'],
                    'stack'    => ['contentful', 'cloudflare', 'figma'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose assets live across drives, inboxes and chat threads.',
                ],
                [
                    'key'      => 'rights-management',
                    'name'     => 'Usage rights & licence tracking',
                    'desc'     => 'Record what each asset is licensed for, where and until when, and stop expired material going out again.',
                    'includes' => ['Rights, territory, channel and expiry metadata', 'Model and property release records', 'Expiry alerts and automatic blocking', 'Report of assets in use past their licence'],
                    'tags'     => ['Rights', 'Expiry', 'Compliance'],
                    'stack'    => ['contentful', 'n8n'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands using stock, talent or influencer material across markets.',
                ],
                [
                    'key'      => 'brand-portal',
                    'name'     => 'Self-serve brand portal',
                    'desc'     => 'A place where partners, agencies and regional teams get the correct, current assets and templates without asking anyone.',
                    'includes' => ['Portal with guidelines, assets and templates', 'Editable templates within brand rules', 'Access control by partner and market', 'Download and usage reporting'],
                    'tags'     => ['Portal', 'Partners', 'Self-serve'],
                    'stack'    => ['nextdotjs', 'contentful', 'figma', 'cloudflare'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands with franchisees, distributors or many regional teams.',
                ],
            ]],

            ['key' => 'localisation', 'name' => 'Localisation', 'icon' => 'globe', 'offers' => [
                [
                    'key'      => 'localisation-pipeline',
                    'name'     => 'Localisation pipeline',
                    'desc'     => 'Translation built into publishing rather than bolted on: machine translation, in-market human review and locale variants that stay in sync.',
                    'includes' => ['Locale model and fallback rules', 'Machine translation with human review steps', 'Glossary, tone and do-not-translate lists', 'Right-to-left and script support'],
                    'tags'     => ['Locales', 'Review', 'Glossary'],
                    'stack'    => ['contentful', 'sanity', 'openai', 'n8n'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands adding markets faster than their translation process can cope.',
                ],
                [
                    'key'      => 'transcreation',
                    'name'     => 'Transcreation programme',
                    'desc'     => 'Adapt campaigns for meaning rather than for words, with local writers and in-market review, so the idea survives the border.',
                    'includes' => ['Local writer and reviewer network', 'Market-specific tone and reference guidance', 'Cultural and regulatory review', 'Back-translation where legal review needs it'],
                    'tags'     => ['Transcreation', 'In-market', 'Cultural review'],
                    'stack'    => [],
                    'time'     => 'Per campaign, ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose translated campaigns read like translations.',
                ],
                [
                    'key'      => 'market-kit',
                    'name'     => 'Market launch kit',
                    'desc'     => 'Everything a new market needs on day one: templates, legal lines, channel set-up and a launch checklist that has been used before.',
                    'includes' => ['Localised template and component set', 'Regional legal and advertising lines', 'Channel and sender set-up for the market', 'Launch checklist and handover to the local team'],
                    'tags'     => ['New market', 'Templates', 'Checklist'],
                    'stack'    => ['contentful', 'twilio', 'whatsapp'],
                    'time'     => '4–8 weeks per market',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands entering a new country or language this year.',
                ],
            ]],

            ['key' => 'messaging', 'name' => 'Messaging infrastructure', 'icon' => 'plug', 'offers' => [
                [
                    'key'      => 'email-infrastructure',
                    'name'     => 'Email infrastructure & authentication',
                    'desc'     => 'Sending domains, authentication and reputation set up the way mailbox providers now require, then monitored.',
                    'includes' => ['SPF, DKIM, DMARC and BIMI configuration', 'Subdomain strategy for marketing and transactional mail', 'Dedicated IP warm-up plan', 'One-click unsubscribe and complaint feedback loops', 'Placement and reputation monitoring'],
                    'tags'     => ['Authentication', 'Warm-up', 'Reputation'],
                    'stack'    => ['twilio', 'cloudflare', 'google'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Anyone sending at volume, or moving to a new sending platform.',
                ],
                [
                    'key'      => 'whatsapp-infrastructure',
                    'name'     => 'WhatsApp Business set-up',
                    'desc'     => 'A compliant WhatsApp channel: verified sender, approved templates, opt-in records and a clear route to a human.',
                    'includes' => ['Business verification and sender set-up', 'Template design and approval', 'Opt-in capture and consent storage', 'Service window handling and agent handover'],
                    'tags'     => ['WhatsApp', 'Templates', 'Opt-in'],
                    'stack'    => ['whatsapp', 'twilio', 'hubspot'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands in WhatsApp-first markets such as India, Brazil and the Gulf.',
                ],
                [
                    'key'      => 'sms-push',
                    'name'     => 'SMS, RCS & push set-up',
                    'desc'     => 'Short-form channels configured correctly: sender registration, consent, quiet hours and the rules that differ by country.',
                    'includes' => ['Sender ID and registration per market', 'Consent, opt-out and quiet hour rules', 'Push notification set-up for app and web', 'Cost modelling per market and volume'],
                    'tags'     => ['SMS', 'Push', 'Per-market rules'],
                    'stack'    => ['twilio', 'firebase', 'hubspot'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands adding time-sensitive channels to an email-only programme.',
                ],
                [
                    'key'      => 'deliverability-remediation',
                    'name'     => 'Deliverability remediation',
                    'desc'     => 'Diagnose and fix a sending reputation that has already gone wrong, then rebuild it with a disciplined sending plan.',
                    'includes' => ['Authentication, blocklist and complaint diagnosis', 'List hygiene, validation and sunset policy', 'Re-engagement and staged volume recovery', 'Weekly monitoring until stable'],
                    'tags'     => ['Remediation', 'Blocklists', 'Recovery'],
                    'stack'    => ['twilio', 'google', 'cloudflare'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Senders whose email suddenly stopped reaching the inbox.',
                ],
            ]],

            ['key' => 'components', 'name' => 'Templates & components', 'icon' => 'layers', 'offers' => [
                [
                    'key'      => 'email-template-system',
                    'name'     => 'Email & message template system',
                    'desc'     => 'A modular template set built on your brand tokens, tested across the clients and devices your audience actually uses.',
                    'includes' => ['Modular components on brand tokens', 'Accessibility, dark mode and plain-text versions', 'Rendering tests across major clients', 'Editor-friendly building blocks'],
                    'tags'     => ['Templates', 'Accessible', 'Dark mode'],
                    'stack'    => ['figma', 'hubspot', 'salesforce'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams rebuilding an email from scratch for every campaign.',
                ],
                [
                    'key'      => 'landing-page-system',
                    'name'     => 'Landing page system',
                    'desc'     => 'A page builder your marketers can use without a developer, made of components that stay on brand, fast and accessible.',
                    'includes' => ['Component library on brand tokens', 'Page templates for campaign, gated and event pages', 'Form, consent and tracking handling', 'Performance and WCAG 2.2 AA checks'],
                    'tags'     => ['Landing pages', 'Components', 'Self-serve'],
                    'stack'    => ['nextdotjs', 'contentful', 'webflow', 'vercel'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing teams waiting on engineering for every campaign page.',
                ],
            ]],
        ],
        'packages' => ['project', 'milestone', 'retainer', 'sprint'],
    ],

    /* =============================================================================================
       03 · AI Campaign Optimization
       ============================================================================================= */
    'ai-campaign-optimization' => [
        'discipline' => 'marketing-technology',
        'title'      => '<span class="g">Know what worked,</span> while there is still time to act on it.',
        'lead'       => 'We build the measurement, the experiments and the models that decide where your budget goes, then automate the reallocation within limits you set. Clean signal first, causal evidence second, automation last.',
        'categories' => [

            ['key' => 'measurement', 'name' => 'Measurement foundations', 'icon' => 'gauge', 'offers' => [
                [
                    'key'      => 'analytics-setup',
                    'name'     => 'Analytics & tag management (GA4)',
                    'desc'     => 'Accurate tracking of visits, leads and sales, set up with consent so the numbers can be trusted by finance as well as marketing.',
                    'includes' => ['Measurement plan tied to commercial goals', 'GA4 and Tag Manager implementation', 'Conversion and e-commerce events', 'Consent mode and cookie banner integration', 'Tag-by-tag testing before launch'],
                    'tags'     => ['GA4', 'Tag Manager', 'Consent mode'],
                    'stack'    => ['googleanalytics', 'googletagmanager', 'google'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams who suspect their analytics numbers are wrong and cannot prove it.',
                ],
                [
                    'key'      => 'server-side-tagging',
                    'name'     => 'Server-side tagging & conversion APIs',
                    'desc'     => 'Send conversions from your own server rather than the browser, with deduplication, so measurement survives browser and consent changes.',
                    'includes' => ['Server-side tagging container and hosting', 'Platform conversion APIs with event deduplication', 'Hashed identifier handling where consented', 'Offline and CRM conversion import'],
                    'tags'     => ['Server-side', 'Conversion API', 'Deduplication'],
                    'stack'    => ['googletagmanager', 'google', 'cloudflare', 'googlebigquery'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers seeing conversions disappear as tracking restrictions tighten.',
                ],
                [
                    'key'      => 'metric-layer',
                    'name'     => 'Marketing metric layer',
                    'desc'     => 'One definition of every marketing number, modelled in your warehouse, so platform reports and board reports finally agree.',
                    'includes' => ['Channel, campaign and cost data pipelines', 'Tested transformation models', 'One definition per metric, documented', 'Dashboards built on the same layer'],
                    'tags'     => ['Warehouse', 'Definitions', 'One number'],
                    'stack'    => ['googlebigquery', 'snowflake', 'dbt', 'airbyte', 'looker'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations where every team brings a different version of the same metric.',
                ],
                [
                    'key'      => 'consent-measurement',
                    'name'     => 'Consent & privacy-safe measurement',
                    'desc'     => 'Keep measuring under GDPR, the DPDP Act and platform consent requirements, without relying on data people have not agreed to share.',
                    'includes' => ['Consent management platform configuration', 'Consent mode and regional rule sets', 'Data retention and minimisation review', 'Modelled conversions where consent is withheld'],
                    'tags'     => ['Consent', 'GDPR · DPDP', 'Privacy-safe'],
                    'stack'    => ['googletagmanager', 'google', 'googleanalytics'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands operating across regions with different consent regimes.',
                ],
            ]],

            ['key' => 'experiments', 'name' => 'Experiments & incrementality', 'icon' => 'eval', 'offers' => [
                [
                    'key'      => 'incrementality-testing',
                    'name'     => 'Incrementality testing',
                    'desc'     => 'Hold out a group, run the campaign, and measure what the advertising actually caused rather than what it was credited with.',
                    'includes' => ['Test design with power and duration calculations', 'Holdout or geo split implementation', 'Analysis with confidence intervals', 'Readout and what it changes in the plan'],
                    'tags'     => ['Holdouts', 'Causal', 'Lift'],
                    'stack'    => ['python', 'googlebigquery', 'google'],
                    'time'     => '4–10 weeks per test',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers suspecting a channel is taking credit for demand it did not create.',
                ],
                [
                    'key'      => 'geo-experiments',
                    'name'     => 'Geo experiments',
                    'desc'     => 'Turn spend up or down by region to measure effect where individual tracking is not available or not permitted.',
                    'includes' => ['Matched market selection', 'Spend plan and test calendar', 'Analysis against the synthetic control', 'Calibration input for mix modelling'],
                    'tags'     => ['Geo', 'Matched markets', 'Calibration'],
                    'stack'    => ['python', 'googlebigquery', 'looker'],
                    'time'     => '6–12 weeks per test',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands advertising on television, radio, out of home or in walled gardens.',
                ],
                [
                    'key'      => 'creative-testing',
                    'name'     => 'Creative & audience testing programme',
                    'desc'     => 'A disciplined testing calendar with enough traffic per cell to learn something, and a library so the same test is not run twice.',
                    'includes' => ['Test roadmap ranked by expected value', 'Sequential testing or bandit allocation', 'Creative fatigue detection', 'Learning library the whole team can search'],
                    'tags'     => ['Testing', 'Bandits', 'Learning library'],
                    'stack'    => ['google', 'python', 'looker', 'posthog'],
                    'time'     => 'Ongoing, monthly cycles',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams running tests that never reach significance.',
                ],
            ]],

            ['key' => 'models', 'name' => 'Models & planning', 'icon' => 'chart', 'offers' => [
                [
                    'key'      => 'mmm',
                    'name'     => 'Marketing mix modelling',
                    'desc'     => 'A model of how every channel contributes to sales, including the ones you cannot track, calibrated against real experiments.',
                    'includes' => ['Data collection across channels, price and seasonality', 'Bayesian model with adstock and saturation curves', 'Calibration against experiment results', 'Contribution and efficiency read by channel', 'Documentation of assumptions and limits'],
                    'tags'     => ['MMM', 'Bayesian', 'Calibrated'],
                    'stack'    => ['python', 'googlebigquery', 'snowflake', 'dbt'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers spending across online and offline channels.',
                ],
                [
                    'key'      => 'budget-scenarios',
                    'name'     => 'Budget scenario planning',
                    'desc'     => 'Answer the planning question directly: if the budget moves by this much, what happens, and where should it go.',
                    'includes' => ['Scenario tool built on the mix model', 'Response curves by channel and market', 'Diminishing return and saturation points', 'Annual and quarterly planning support'],
                    'tags'     => ['Scenarios', 'Planning', 'Response curves'],
                    'stack'    => ['python', 'looker', 'powerbi'],
                    'time'     => '3–6 weeks after a model exists',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams heading into an annual planning round with a number to defend.',
                ],
                [
                    'key'      => 'propensity-audiences',
                    'name'     => 'Propensity audiences for media',
                    'desc'     => 'Target people likely to buy or likely to lapse, with audiences refreshed automatically and shared only where consent allows.',
                    'includes' => ['Propensity and value models', 'Consent-aware audience syndication', 'Suppression of existing and unsuitable customers', 'Measurement against a broad-targeting control'],
                    'tags'     => ['Propensity', 'Suppression', 'Audiences'],
                    'stack'    => ['googlebigquery', 'dbt', 'python', 'scikitlearn', 'google'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers paying to reach customers they already have.',
                ],
            ]],

            ['key' => 'automation', 'name' => 'Automation & guardrails', 'icon' => 'agent', 'offers' => [
                [
                    'key'      => 'budget-agent',
                    'name'     => 'Budget allocation agent',
                    'desc'     => 'Daily or weekly reallocation proposals across channels and campaigns, each with expected effect and confidence, applied after approval.',
                    'includes' => ['Allocation logic tied to modelled contribution', 'Proposals with reasoning and confidence', 'Approval threshold you set', 'Execution through platform APIs with rollback'],
                    'tags'     => ['Allocation', 'Approval', 'Rollback'],
                    'stack'    => ['python', 'google', 'anthropic', 'n8n'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams reallocating budget manually once a month and losing the weeks in between.',
                ],
                [
                    'key'      => 'anomaly-alerts',
                    'name'     => 'Anomaly detection & alerting',
                    'desc'     => 'Catch a broken tag, a runaway campaign or a collapsing conversion rate within hours instead of at the monthly review.',
                    'includes' => ['Baselines per campaign, channel and market', 'Anomaly detection on spend, cost and conversion', 'Alerts to the people who can act', 'Weekly false-positive tuning'],
                    'tags'     => ['Anomalies', 'Alerts', 'Same day'],
                    'stack'    => ['python', 'googlebigquery', 'slack', 'looker'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers who have lost a week of budget to a mistake nobody noticed.',
                ],
                [
                    'key'      => 'spend-guardrails',
                    'name'     => 'Pacing & spend guardrails',
                    'desc'     => 'Caps, pacing rules and a kill switch that your team controls, so automation can never spend past its limits.',
                    'includes' => ['Pacing rules by campaign and market', 'Hard spend caps and exclusion lists', 'Kill switch with no agency ticket required', 'Change log of every automated action'],
                    'tags'     => ['Caps', 'Pacing', 'Kill switch'],
                    'stack'    => ['google', 'python', 'n8n'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Anyone letting automated bidding run without a ceiling.',
                ],
            ]],

            ['key' => 'reporting', 'name' => 'Reporting & programmes', 'icon' => 'dashboard', 'offers' => [
                [
                    'key'      => 'performance-dashboard',
                    'name'     => 'Marketing performance dashboard',
                    'desc'     => 'One view of spend, contribution and efficiency that leadership reads without a translator.',
                    'includes' => ['Dashboards on the shared metric layer', 'Channel contribution and efficiency views', 'Commentary and next actions each month', 'Access for finance and leadership'],
                    'tags'     => ['Dashboard', 'Leadership', 'Monthly'],
                    'stack'    => ['looker', 'powerbi', 'googlebigquery'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing leaders rebuilding the same slide every month.',
                ],
                [
                    'key'      => 'optimisation-programme',
                    'name'     => 'Ongoing optimisation programme',
                    'desc'     => 'A standing cycle of tests, model refreshes and reallocation, reported against a baseline you agreed at the start.',
                    'includes' => ['Weekly optimisation and proposal cycle', 'Quarterly model refresh and recalibration', 'Test roadmap maintained with your team', 'Monthly report against the baseline'],
                    'tags'     => ['Ongoing', 'Weekly cycle', 'Quarterly refresh'],
                    'stack'    => ['python', 'googlebigquery', 'looker', 'google'],
                    'time'     => 'Ongoing, quarterly cycles',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers where media is a material and permanent line in the budget.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'retainer', 'enterprise'],
    ],

    /* =============================================================================================
       04 · AI Creative Solutions
       ============================================================================================= */
    'ai-creative-solutions' => [
        'discipline' => 'marketing-technology',
        'title'      => '<span class="g">Every size, every market,</span> still unmistakably yours.',
        'lead'       => 'We build the production system that turns one approved idea into the volume of creative modern media consumes: variants, dynamic assembly and feed-driven work, generated inside your brand rules, checked automatically and released by a named person.',
        'categories' => [

            ['key' => 'production', 'name' => 'Production systems', 'icon' => 'layers', 'offers' => [
                [
                    'key'      => 'variant-engine',
                    'name'     => 'Creative variant engine',
                    'desc'     => 'One approved concept becomes every size, aspect ratio, language and audience variant your media plan needs.',
                    'includes' => ['Modular template system on brand tokens', 'Generative copy and imagery within constraints', 'Automated resizing and safe-area handling', 'Bulk export to ad platforms and the asset library'],
                    'tags'     => ['Variants', 'Formats', 'Bulk'],
                    'stack'    => ['openai', 'googlegemini', 'replicate', 'figma', 'python'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers whose adaptation queue decides when a campaign can launch.',
                ],
                [
                    'key'      => 'template-system',
                    'name'     => 'Modular creative template system',
                    'desc'     => 'A component set built so that assembly, personalisation and localisation are possible at all, and stay on brand when they happen.',
                    'includes' => ['Component and layout system from your brand kit', 'Rules for what may vary and what may not', 'Copy length and legibility constraints', 'Handover to designers and to the pipeline'],
                    'tags'     => ['Components', 'Rules', 'Reusable'],
                    'stack'    => ['figma', 'contentful'],
                    'time'     => '4–7 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose creative is built as flat artwork with nothing reusable.',
                ],
                [
                    'key'      => 'batch-adaptation',
                    'name'     => 'Campaign adaptation at volume',
                    'desc'     => 'A delivered production run: an existing campaign adapted across formats, markets and channels, checked and handed over.',
                    'includes' => ['Format and market matrix agreed up front', 'Production run with automated checks', 'Human review queue and sign-off', 'Delivery into your asset library and platforms'],
                    'tags'     => ['Adaptation', 'Production run', 'Delivered'],
                    'stack'    => ['figma', 'openai', 'cloudflare'],
                    'time'     => '2–6 weeks per campaign',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with a campaign to roll out and no studio capacity left.',
                ],
            ]],

            ['key' => 'dynamic', 'name' => 'Dynamic & feed creative', 'icon' => 'puzzle', 'offers' => [
                [
                    'key'      => 'dco',
                    'name'     => 'Dynamic creative optimisation',
                    'desc'     => 'Ads assembled per audience, placement and context from a governed component set, with the winning combinations fed back into the next brief.',
                    'includes' => ['Component set and assembly rules', 'Audience and context signal mapping', 'Platform set-up and trafficking', 'Component-level performance reporting'],
                    'tags'     => ['DCO', 'Assembly', 'Signals'],
                    'stack'    => ['google', 'cloudflare', 'python'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers running the same three creatives at everyone.',
                ],
                [
                    'key'      => 'product-feed-creative',
                    'name'     => 'Product feed creative',
                    'desc'     => 'Catalogue-driven ads that stay accurate as prices, stock and offers change, built on a feed that has been cleaned first.',
                    'includes' => ['Feed audit, hygiene and enrichment', 'Templated creative driven by feed fields', 'Price, stock and promotion accuracy checks', 'Automatic pausing of out-of-stock items'],
                    'tags'     => ['Feeds', 'Catalogue', 'Accuracy'],
                    'stack'    => ['shopify', 'google', 'python', 'cloudflare'],
                    'time'     => '5–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Retailers advertising thousands of products that change weekly.',
                ],
                [
                    'key'      => 'personalised-lifecycle-creative',
                    'name'     => 'Personalised lifecycle creative',
                    'desc'     => 'Email, message and landing creative assembled per segment or per person at open time, from approved modules.',
                    'includes' => ['Modular content blocks with eligibility rules', 'Personalisation tied to your customer data', 'Fallbacks when data is missing', 'Rendering and accessibility testing'],
                    'tags'     => ['Personalisation', 'Modules', 'Fallbacks'],
                    'stack'    => ['hubspot', 'salesforce', 'contentful', 'cloudflare'],
                    'time'     => '5–9 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Lifecycle programmes sending one identical email to a varied audience.',
                ],
            ]],

            ['key' => 'generation', 'name' => 'Generation & tuning', 'icon' => 'sparkle', 'offers' => [
                [
                    'key'      => 'brand-tuned-generation',
                    'name'     => 'Brand-tuned image generation',
                    'desc'     => 'Generation set up to produce your world rather than a generic one, using your own assets under your own licence.',
                    'includes' => ['Reference library and prompt system', 'Model selection and tuning on your assets', 'Style, colour and composition evaluation', 'Operator guide for the team'],
                    'tags'     => ['Tuned', 'Reference library', 'Evaluated'],
                    'stack'    => ['replicate', 'huggingface', 'modal', 'openai', 'googlegemini'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose AI imagery keeps looking like everyone else’s.',
                ],
                [
                    'key'      => 'product-imagery',
                    'name'     => 'AI product & lifestyle imagery',
                    'desc'     => 'Product photography extended into new scenes, seasons and markets without a new shoot for every variation.',
                    'includes' => ['Product fidelity rules and checks', 'Scene, season and market variations', 'Colour and detail accuracy review', 'Disclosure where required by platform or law'],
                    'tags'     => ['Product', 'Scenes', 'Fidelity'],
                    'stack'    => ['replicate', 'openai', 'googlegemini', 'shopify'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Catalogue brands that cannot shoot every product in every context.',
                ],
                [
                    'key'      => 'ai-video',
                    'name'     => 'AI-assisted video & motion',
                    'desc'     => 'Short-form video and motion variants produced from an approved master, cut for each platform and market.',
                    'includes' => ['Master and variant plan per platform', 'Automated cut-downs, captions and subtitles', 'Voice and music licensing review', 'Content Credentials and disclosure where supported'],
                    'tags'     => ['Video', 'Cut-downs', 'Captions'],
                    'stack'    => ['replicate', 'openai', 'modal', 'cloudflare'],
                    'time'     => '5–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands needing platform-native video at a pace shoots cannot match.',
                ],
            ]],

            ['key' => 'governance', 'name' => 'Brand safety & rights', 'icon' => 'shield', 'offers' => [
                [
                    'key'      => 'brand-checks',
                    'name'     => 'Automated brand & claim checks',
                    'desc'     => 'Machine-checkable brand rules and an approved claim library, so nothing off-brand or unapproved reaches a review queue.',
                    'includes' => ['Brand rules written as automated checks', 'Logo, colour, type and safe-area validation', 'Approved claim and banned phrase library', 'Blocked releases with a clear reason'],
                    'tags'     => ['Checks', 'Claims', 'Blocking'],
                    'stack'    => ['python', 'playwright', 'figma'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands producing at a volume no human reviewer can cover.',
                ],
                [
                    'key'      => 'rights-provenance',
                    'name'     => 'Rights, licensing & provenance',
                    'desc'     => 'Know what every asset was made from, what it is licensed for and how long it may run, and be able to show it.',
                    'includes' => ['Model and dataset licence review', 'Talent, likeness and music rights records', 'Content Credentials (C2PA) where supported', 'Provenance register per campaign'],
                    'tags'     => ['Licensing', 'C2PA', 'Register'],
                    'stack'    => [],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Regulated brands and any business whose legal team asks where creative came from.',
                ],
                [
                    'key'      => 'ai-disclosure',
                    'name'     => 'AI disclosure & policy',
                    'desc'     => 'Work out which markets, platforms and codes require you to label AI-generated creative, and build the labelling into the template.',
                    'includes' => ['Market and platform requirement mapping', 'Disclosure wording and placement standards', 'Template-level implementation', 'Internal policy and training note'],
                    'tags'     => ['Disclosure', 'EU AI Act', 'Policy'],
                    'stack'    => [],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers using synthetic imagery, voices or presenters across several markets.',
                ],
            ]],

            ['key' => 'performance', 'name' => 'Learning & operations', 'icon' => 'trend-up', 'offers' => [
                [
                    'key'      => 'creative-analysis',
                    'name'     => 'Creative performance analysis',
                    'desc'     => 'Find out which components actually drive results — the hook, the offer, the format, the first three seconds — and brief the next round on evidence.',
                    'includes' => ['Component tagging across the creative library', 'Performance analysis by component and format', 'Fatigue and refresh-rate analysis', 'Evidence-based brief for the next cycle'],
                    'tags'     => ['Components', 'Fatigue', 'Evidence'],
                    'stack'    => ['googlebigquery', 'python', 'looker'],
                    'time'     => '4–7 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams judging creative on opinion because nobody tagged the variables.',
                ],
                [
                    'key'      => 'creative-ops-retainer',
                    'name'     => 'Creative operations retainer',
                    'desc'     => 'Reserved monthly capacity to run the production pipeline, add formats and markets, and keep the brand checks current.',
                    'includes' => ['Reserved production and engineering capacity', 'New formats, markets and channels as they appear', 'Model and template maintenance', 'Monthly review of volume, quality and cost'],
                    'tags'     => ['Retainer', 'Capacity', 'Maintenance'],
                    'stack'    => ['figma', 'openai', 'n8n'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands with a permanent, high-volume creative pipeline to run.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'retainer', 'squad'],
    ],

    /* =============================================================================================
       05 · AI Lead Generation
       ============================================================================================= */
    'ai-lead-generation' => [
        'discipline' => 'marketing-technology',
        'title'      => '<span class="g">Fewer forms to chase.</span> More conversations worth having.',
        'lead'       => 'We build the system that finds, scores and routes demand worth a salesperson’s time: an ideal customer profile from your own closed-won history, first-party intent signals, explainable scoring and routing measured in minutes. No purchased lists, no promised volumes.',
        'categories' => [

            ['key' => 'targeting', 'name' => 'Targeting & data', 'icon' => 'target', 'offers' => [
                [
                    'key'      => 'icp-definition',
                    'name'     => 'Ideal customer profile & tiering',
                    'desc'     => 'Work out which customers are actually worth pursuing, using the deals you won and the ones you lost, and tier the market accordingly.',
                    'includes' => ['Closed-won and closed-lost analysis', 'Firmographic, technographic and behavioural fit criteria', 'Tiered target list with sizing', 'Agreement between sales and marketing on the definition'],
                    'tags'     => ['ICP', 'Tiers', 'Evidence'],
                    'stack'    => ['salesforce', 'hubspot', 'python'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams chasing every enquiry because nobody has defined a good one.',
                ],
                [
                    'key'      => 'target-list',
                    'name'     => 'Target account list build',
                    'desc'     => 'Build and maintain the account list your teams work from, sourced lawfully and kept current rather than bought once.',
                    'includes' => ['Account sourcing against the tiered profile', 'Contact and role mapping per account', 'Lawful basis and consent recorded per source', 'Refresh cadence and decay handling'],
                    'tags'     => ['Accounts', 'Lawful basis', 'Refresh'],
                    'stack'    => ['salesforce', 'hubspot', 'googlebigquery'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Account-based teams working from a list that is two years old.',
                ],
                [
                    'key'      => 'enrichment-hygiene',
                    'name'     => 'Enrichment & CRM hygiene',
                    'desc'     => 'One accurate record per person and per account, kept clean by rules rather than by quarterly clean-up projects.',
                    'includes' => ['Deduplication and merge logic', 'Validation at point of capture', 'Enrichment from agreed sources', 'Decay, bounce and suppression handling'],
                    'tags'     => ['Enrichment', 'Deduplication', 'Validation'],
                    'stack'    => ['salesforce', 'hubspot', 'zoho', 'python'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'CRMs where the same company appears five times with four spellings.',
                ],
            ]],

            ['key' => 'demand', 'name' => 'Demand capture', 'icon' => 'radar', 'offers' => [
                [
                    'key'      => 'intent-signals',
                    'name'     => 'Intent signal capture',
                    'desc'     => 'See which accounts are researching, engaging and returning, using your own site, content, product and event data first.',
                    'includes' => ['First-party behaviour tracking with consent', 'Content, pricing and documentation engagement signals', 'Account-level signal aggregation', 'Alerting when an account starts moving'],
                    'tags'     => ['Intent', 'First-party', 'Alerts'],
                    'stack'    => ['googletagmanager', 'posthog', 'googlebigquery', 'hubspot'],
                    'time'     => '5–9 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sales teams who hear about interest only when a form is filled in.',
                ],
                [
                    'key'      => 'conversion-optimisation',
                    'name'     => 'Website conversion optimisation',
                    'desc'     => 'Turn more of the traffic you already have into enquiries by fixing the forms, the flow and the friction.',
                    'includes' => ['Funnel and behaviour analysis', 'Form, flow and friction fixes', 'Prioritised test plan with A/B testing', 'Lead quality tracked, not just volume'],
                    'tags'     => ['CRO', 'Forms', 'Testing'],
                    'stack'    => ['posthog', 'googleanalytics', 'googletagmanager'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sites with healthy traffic and disappointing enquiry numbers.',
                ],
                [
                    'key'      => 'event-capture',
                    'name'     => 'Event & webinar lead capture',
                    'desc'     => 'Get real value from events: registration, attendance, engagement and follow-up connected to the CRM before the room empties.',
                    'includes' => ['Registration and reminder journeys', 'Attendance and engagement capture', 'Post-event scoring and routing', 'Follow-up sequences by engagement level'],
                    'tags'     => ['Events', 'Webinars', 'Follow-up'],
                    'stack'    => ['hubspot', 'salesforce', 'twilio', 'slack'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose event lists sit in a spreadsheet for a fortnight.',
                ],
            ]],

            ['key' => 'scoring', 'name' => 'Scoring & qualification', 'icon' => 'brain', 'offers' => [
                [
                    'key'      => 'lead-scoring',
                    'name'     => 'Lead scoring model',
                    'desc'     => 'A score built from your own outcomes, showing the reasons behind it, so sales trusts it enough to use it.',
                    'includes' => ['Fit and engagement scoring trained on closed-won data', 'Feature selection with your sales team', 'Score explanations exposed in the CRM', 'Backtesting, drift monitoring and a model card'],
                    'tags'     => ['Scoring', 'Explainable', 'Monitored'],
                    'stack'    => ['python', 'scikitlearn', 'hubspot', 'salesforce'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sales teams ignoring the scores the platform already produces.',
                ],
                [
                    'key'      => 'account-scoring',
                    'name'     => 'Account propensity scoring',
                    'desc'     => 'Score whole accounts rather than individuals, for buying groups where six people research and one signs.',
                    'includes' => ['Buying group and role mapping', 'Account-level engagement aggregation', 'Propensity model with confidence bands', 'Account views and alerts in the CRM'],
                    'tags'     => ['Accounts', 'Buying groups', 'Propensity'],
                    'stack'    => ['python', 'googlebigquery', 'salesforce'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Enterprise sales teams selling to committees, not to individuals.',
                ],
                [
                    'key'      => 'qualification-framework',
                    'name'     => 'Qualification framework & handover',
                    'desc'     => 'A written definition of qualified that marketing and sales both sign, with the handover rules and the reasons a lead can be sent back.',
                    'includes' => ['Qualification criteria workshop', 'Stage definitions and handover rules', 'Return and recycle process', 'Reporting on accepted and rejected leads'],
                    'tags'     => ['Definition', 'Handover', 'Recycling'],
                    'stack'    => [],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations where marketing and sales argue about lead quality every month.',
                ],
            ]],

            ['key' => 'conversational', 'name' => 'Conversational qualification', 'icon' => 'chat', 'offers' => [
                [
                    'key'      => 'website-assistant',
                    'name'     => 'Website qualification assistant',
                    'desc'     => 'An assistant grounded in your own content that answers real questions, qualifies against your criteria and books the meeting.',
                    'includes' => ['Grounding in your documents and product content', 'Qualification criteria agreed with sales', 'Calendar booking and CRM handover with transcript', 'Escalation to a person at any point'],
                    'tags'     => ['Assistant', 'Grounded', 'Booking'],
                    'stack'    => ['anthropic', 'openai', 'pgvector', 'hubspot'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses losing enquiries outside working hours.',
                ],
                [
                    'key'      => 'whatsapp-qualification',
                    'name'     => 'WhatsApp qualification',
                    'desc'     => 'Qualify and book on the channel customers already use, with opt-in, approved templates and a clean route to a person.',
                    'includes' => ['WhatsApp sender and template set-up', 'Qualification conversation design', 'CRM write-back and routing', 'Service window and handover rules'],
                    'tags'     => ['WhatsApp', 'Opt-in', 'Handover'],
                    'stack'    => ['whatsapp', 'twilio', 'anthropic', 'hubspot'],
                    'time'     => '5–9 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Consumer and SME sales in WhatsApp-first markets.',
                ],
                [
                    'key'      => 'voice-qualification',
                    'name'     => 'Voice qualification & callback',
                    'desc'     => 'An assistant that answers or returns calls, qualifies, books and transfers, with recording consent handled in the flow.',
                    'includes' => ['Call flow and qualification script design', 'Recording and consent handling per market', 'Warm transfer to an available person', 'Transcript and outcome written to the CRM'],
                    'tags'     => ['Voice', 'Callback', 'Consent'],
                    'stack'    => ['twilio', 'openai', 'anthropic', 'salesforce'],
                    'time'     => '7–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'High-volume inbound businesses with long telephone queues.',
                ],
            ]],

            ['key' => 'routing', 'name' => 'Routing & operations', 'icon' => 'bolt', 'offers' => [
                [
                    'key'      => 'routing-sla',
                    'name'     => 'Routing & response targets',
                    'desc'     => 'Get each lead to the right person quickly, with alerts, escalation and a first-response time you can actually report on.',
                    'includes' => ['Routing rules by territory, product and owner', 'Round-robin, capacity and holiday handling', 'Alerting and escalation when nobody responds', 'First-response time reporting'],
                    'tags'     => ['Routing', 'Escalation', 'Response time'],
                    'stack'    => ['salesforce', 'hubspot', 'slack', 'twilio'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams where good leads sit unclaimed over a weekend.',
                ],
                [
                    'key'      => 'outbound-sequences',
                    'name'     => 'Compliant outbound sequences',
                    'desc'     => 'Outbound built on research and relevance, with the rules for each market and channel applied before the first message.',
                    'includes' => ['Market and channel rule mapping', 'Sequence design with personalisation from real signals', 'Consent, suppression and opt-out handling', 'Reply handling and meeting booking'],
                    'tags'     => ['Outbound', 'Per-market rules', 'Suppression'],
                    'stack'    => ['hubspot', 'salesforce', 'twilio', 'anthropic'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sales teams sending outbound without knowing which rules apply where.',
                ],
                [
                    'key'      => 'pipeline-quality-programme',
                    'name'     => 'Pipeline quality programme',
                    'desc'     => 'A standing cycle that improves what reaches sales: scoring retrained, criteria revisited, and quality reported weekly.',
                    'includes' => ['Weekly pipeline quality review', 'Model retraining and drift checks', 'Criteria and routing adjustments', 'Monthly report from lead to closed revenue'],
                    'tags'     => ['Ongoing', 'Retraining', 'Quality'],
                    'stack'    => ['python', 'salesforce', 'hubspot', 'looker'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses where pipeline quality decides the quarter.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'retainer', 'squad'],
    ],

    /* =============================================================================================
       06 · Automated & Dynamic Sales
       ============================================================================================= */
    'automated-dynamic-sales' => [
        'discipline' => 'marketing-technology',
        'title'      => '<span class="g">Give the selling hours back</span> to the people who sell.',
        'lead'       => 'We automate the process around the sale: a CRM that stays current on its own, guided next steps with the reasoning shown, quoting and pricing under governed rules, and a forecast built on evidence. People keep the conversation, the promise and the price.',
        'categories' => [

            ['key' => 'crm', 'name' => 'CRM & process', 'icon' => 'sync', 'offers' => [
                [
                    'key'      => 'sales-process-design',
                    'name'     => 'Sales process & stage design',
                    'desc'     => 'Agree the stages, the exit criteria and the definitions everyone will be measured on, before any of it is automated.',
                    'includes' => ['Process mapping with the people who sell', 'Stage definitions and exit criteria', 'Handover rules between marketing, sales and service', 'Reporting definitions signed by leadership'],
                    'tags'     => ['Process', 'Stages', 'Definitions'],
                    'stack'    => [],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams where every representative runs a slightly different process.',
                ],
                [
                    'key'      => 'crm-implementation',
                    'name'     => 'CRM implementation & migration',
                    'desc'     => 'Set up or move your CRM around the process you agreed, with the integrations and reporting the business actually needs.',
                    'includes' => ['Object, field and permission model', 'Integrations with marketing, finance and support', 'Data migration with reconciliation', 'Dashboards and reports rebuilt', 'Team training and adoption plan'],
                    'tags'     => ['CRM', 'Migration', 'Integration'],
                    'stack'    => ['salesforce', 'hubspot', 'zoho', 'postgresql'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses adopting a CRM or replacing one nobody updates.',
                ],
                [
                    'key'      => 'crm-hygiene',
                    'name'     => 'Activity capture & CRM hygiene',
                    'desc'     => 'The CRM updates itself: activity logged automatically, duplicates prevented, and fields asked for when they are known.',
                    'includes' => ['Automatic email, call and meeting capture', 'Duplicate prevention and merge rules', 'Stage rules and required-field timing', 'Hygiene scoring by team and owner'],
                    'tags'     => ['Auto-capture', 'Hygiene', 'Rules'],
                    'stack'    => ['salesforce', 'hubspot', 'zoho', 'microsoftteams'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sales leaders whose pipeline report is a work of fiction by Friday.',
                ],
            ]],

            ['key' => 'assist', 'name' => 'Selling assistance', 'icon' => 'compass', 'offers' => [
                [
                    'key'      => 'guided-selling',
                    'name'     => 'Guided selling & next best action',
                    'desc'     => 'Playbooks inside the CRM that suggest the next step and flag risk, always showing why, so a representative can disagree with reason.',
                    'includes' => ['Playbooks per segment and deal type', 'Next best action with the reasoning shown', 'Stalled and at-risk deal flags', 'Adoption tracking and iteration'],
                    'tags'     => ['Playbooks', 'Risk flags', 'Reasoning'],
                    'stack'    => ['salesforce', 'hubspot', 'anthropic'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams where the best representative’s method lives only in their head.',
                ],
                [
                    'key'      => 'proposal-generation',
                    'name'     => 'Proposal & document generation',
                    'desc'     => 'Proposals and statements of work drafted from CRM data and approved content, in the brand voice, reviewed before they go out.',
                    'includes' => ['Template set with approved, reusable content', 'Generation from CRM and quote data', 'Review, approval and version control', 'E-signature and storage integration'],
                    'tags'     => ['Proposals', 'Templates', 'Approval'],
                    'stack'    => ['salesforce', 'hubspot', 'anthropic', 'openai'],
                    'time'     => '5–9 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams rebuilding every proposal from the last client’s file.',
                ],
                [
                    'key'      => 'meeting-followup',
                    'name'     => 'Meeting prep & follow-up automation',
                    'desc'     => 'A brief before every meeting and a drafted recap after it, written back to the CRM so the pipeline reflects what was actually said.',
                    'includes' => ['Pre-meeting brief from CRM and account history', 'Recap and action draft after the meeting', 'CRM write-back of notes and next steps', 'Owner review before anything is sent'],
                    'tags'     => ['Briefs', 'Recaps', 'Write-back'],
                    'stack'    => ['anthropic', 'openai', 'salesforce', 'slack'],
                    'time'     => '4–7 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Representatives writing notes at nine in the evening, or not at all.',
                ],
            ]],

            ['key' => 'pricing', 'name' => 'Pricing & quoting', 'icon' => 'cost', 'offers' => [
                [
                    'key'      => 'cpq',
                    'name'     => 'Configure, price & quote',
                    'desc'     => 'Quoting that follows your pricing rules, routes discounts for approval and produces a document that finance recognises.',
                    'includes' => ['Product, bundle and pricing configuration', 'Discount thresholds and approval chains', 'Quote templates and version history', 'Integration to invoicing and revenue systems'],
                    'tags'     => ['CPQ', 'Approvals', 'Quote-to-cash'],
                    'stack'    => ['salesforce', 'hubspot', 'zoho', 'stripe'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams quoting in spreadsheets with discounts approved over chat.',
                ],
                [
                    'key'      => 'pricing-rules',
                    'name'     => 'Dynamic pricing rules',
                    'desc'     => 'Rule-based pricing by segment, volume, term and cost to serve, documented and auditable, never varied by an individual’s personal characteristics.',
                    'includes' => ['Price architecture and rule design', 'Margin floors and guardrails', 'Scenario testing before rollout', 'Audit trail of every price decision'],
                    'tags'     => ['Pricing', 'Margin floors', 'Auditable'],
                    'stack'    => ['salesforce', 'python', 'postgresql'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses whose prices are negotiated the same way every time, badly.',
                ],
                [
                    'key'      => 'self-serve-checkout',
                    'name'     => 'Self-serve purchase & payment links',
                    'desc'     => 'Let smaller deals close themselves with a hosted checkout or payment link, so representatives keep their time for the deals that need them.',
                    'includes' => ['Hosted checkout or payment link flow', 'Tokenised payments through your provider', 'Automatic provisioning and CRM updates', 'Failed payment recovery'],
                    'tags'     => ['Self-serve', 'Payment links', 'Tokenised'],
                    'stack'    => ['stripe', 'razorpay', 'shopify', 'hubspot'],
                    'time'     => '5–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses where small deals cost as much to close as large ones.',
                ],
            ]],

            ['key' => 'intelligence', 'name' => 'Conversation & coaching', 'icon' => 'voice', 'offers' => [
                [
                    'key'      => 'conversation-intelligence',
                    'name'     => 'Conversation intelligence',
                    'desc'     => 'Calls and meetings transcribed with consent, then turned into CRM notes, objection patterns and deal risk signals.',
                    'includes' => ['Consent capture in the call and meeting flow', 'Transcription, summary and CRM write-back', 'Objection, competitor and commitment extraction', 'Retention limits and access controls'],
                    'tags'     => ['Transcripts', 'Objections', 'Consent'],
                    'stack'    => ['openai', 'anthropic', 'salesforce', 'microsoftteams'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams where what customers said never reaches anyone else.',
                ],
                [
                    'key'      => 'coaching-programme',
                    'name'     => 'Coaching insight programme',
                    'desc'     => 'Turn conversation data into coaching themes for the team and better talk tracks, not into surveillance scores for individuals.',
                    'includes' => ['Theme analysis across the team', 'Talk track and objection handling updates', 'Manager coaching pack each month', 'Clear policy on what is and is not measured'],
                    'tags'     => ['Coaching', 'Themes', 'Policy'],
                    'stack'    => ['anthropic', 'salesforce', 'looker'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sales managers coaching on instinct because they cannot listen to every call.',
                ],
            ]],

            ['key' => 'revops', 'name' => 'Revenue operations', 'icon' => 'chart', 'offers' => [
                [
                    'key'      => 'forecasting',
                    'name'     => 'Forecasting & pipeline analytics',
                    'desc'     => 'A forecast with a range, its assumptions and its historic error, built on stage conversion, ageing and coverage.',
                    'includes' => ['Conversion, ageing and coverage analysis', 'Model-assisted forecast with ranges', 'Scenario and risk views', 'Weekly leadership review pack'],
                    'tags'     => ['Forecast', 'Ranges', 'Weekly'],
                    'stack'    => ['salesforce', 'hubspot', 'googlebigquery', 'looker'],
                    'time'     => '5–9 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams whose forecast is a spreadsheet of optimism.',
                ],
                [
                    'key'      => 'revenue-reporting',
                    'name'     => 'Revenue reporting & attribution to pipeline',
                    'desc'     => 'Follow the line from marketing activity to pipeline to closed revenue, with one definition of every stage.',
                    'includes' => ['Marketing, sales and finance data joined', 'Stage and source definitions agreed', 'Pipeline creation and velocity reporting', 'Board-ready monthly view'],
                    'tags'     => ['Reporting', 'Velocity', 'Board view'],
                    'stack'    => ['googlebigquery', 'dbt', 'looker', 'salesforce'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations where marketing and sales report different revenue stories.',
                ],
                [
                    'key'      => 'revops-retainer',
                    'name'     => 'Revenue operations retainer',
                    'desc'     => 'Reserved monthly capacity to run and improve the revenue stack as products, territories and teams change.',
                    'includes' => ['Reserved operations and engineering capacity', 'Change requests, new fields and new reports', 'Quarterly process and data review', 'Monthly service review against agreed priorities'],
                    'tags'     => ['Retainer', 'Change', 'Review'],
                    'stack'    => ['salesforce', 'hubspot', 'n8n'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses without a revenue operations team of their own.',
                ],
            ]],
        ],
        'packages' => ['project', 'milestone', 'retainer', 'enterprise'],
    ],

    /* =============================================================================================
       07 · Customer Relationship Strategy
       ONE page, five areas: journey mapping · segmentation & insights · engagement programmes ·
       loyalty strategy & programmes · lifecycle marketing. They are categories here, never pages.
       ============================================================================================= */
    'customer-relationship-strategy' => [
        'discipline' => 'marketing-technology',
        'title'      => '<span class="g">Keeping a customer</span> is a programme, not a campaign.',
        'lead'       => 'Journey mapping, customer segmentation and insights, engagement programmes, loyalty strategy and lifecycle marketing, run as one practice by one team. Start with the part you need most; each one is designed to connect to the others, and all of them are measured on retention and lifetime value.',
        'categories' => [

            ['key' => 'journeys', 'name' => 'Customer journey mapping', 'icon' => 'compass', 'offers' => [
                [
                    'key'      => 'journey-mapping',
                    'name'     => 'Customer journey mapping',
                    'desc'     => 'Map the journey as customers actually experience it, across channels and into service, and find where and why they leave.',
                    'includes' => ['Customer and frontline interviews', 'Behavioural and transaction data analysis', 'Journey maps per segment with moments of truth', 'Prioritised list of fixes and opportunities'],
                    'tags'     => ['Journeys', 'Research', 'Drop-offs'],
                    'stack'    => ['miro', 'figma', 'googleanalytics', 'mixpanel'],
                    'time'     => '5–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands guessing why customers stop at a particular point.',
                ],
                [
                    'key'      => 'service-blueprint',
                    'name'     => 'Service blueprint & recovery design',
                    'desc'     => 'Map what has to happen behind the scenes for the journey to work, including how the business recovers when it does not.',
                    'includes' => ['Front-stage and back-stage process mapping', 'System, team and handover dependencies', 'Failure points and recovery plays', 'Owner per moment and per play'],
                    'tags'     => ['Blueprint', 'Recovery', 'Ownership'],
                    'stack'    => ['miro', 'figma'],
                    'time'     => '4–7 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses whose customer problems fall between departments.',
                ],
                [
                    'key'      => 'journey-instrumentation',
                    'name'     => 'Journey instrumentation & monitoring',
                    'desc'     => 'Wire the map to real data so it stays true: stage entry, progression, drop-off and recovery measured continuously.',
                    'includes' => ['Event and stage definitions', 'Tracking implementation across channels', 'Journey health dashboard', 'Alerting when a stage degrades'],
                    'tags'     => ['Instrumented', 'Live', 'Alerts'],
                    'stack'    => ['googletagmanager', 'mixpanel', 'posthog', 'googlebigquery', 'looker'],
                    'time'     => '5–9 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose journey map was accurate on the day it was printed.',
                ],
            ]],

            ['key' => 'segmentation', 'name' => 'Segmentation & customer insight', 'icon' => 'users', 'offers' => [
                [
                    'key'      => 'segmentation-model',
                    'name'     => 'Customer segmentation model',
                    'desc'     => 'Segments built from research and your own data, sized, named and written into the platforms that have to act on them.',
                    'includes' => ['Needs-based and behavioural segmentation', 'Segment sizing, value and descriptions', 'Segment definitions implemented in CRM and analytics', 'Activation guidance per segment'],
                    'tags'     => ['Segments', 'Sized', 'Activated'],
                    'stack'    => ['snowflake', 'googlebigquery', 'dbt', 'python', 'hubspot'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose segmentation lives in a deck and nowhere else.',
                ],
                [
                    'key'      => 'customer-research',
                    'name'     => 'Customer research & insight programme',
                    'desc'     => 'Qualitative and quantitative research that explains the behaviour the data only describes, run on a cadence rather than once.',
                    'includes' => ['Interviews and ethnographic sessions', 'Survey design and analysis', 'Win, loss and churn interviews', 'Insight repository the team can search'],
                    'tags'     => ['Interviews', 'Surveys', 'Repository'],
                    'stack'    => ['notion', 'miro'],
                    'time'     => '5–9 weeks, or ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations with plenty of dashboards and no explanations.',
                ],
                [
                    'key'      => 'churn-propensity',
                    'name'     => 'Churn & propensity models',
                    'desc'     => 'Models that show who is likely to leave, to buy again or to upgrade, with the reasons attached so someone can act on them.',
                    'includes' => ['Churn risk and next-purchase models', 'Feature explanations per customer', 'Risk tiers wired into CRM and journeys', 'Drift monitoring and scheduled retraining'],
                    'tags'     => ['Churn', 'Propensity', 'Explained'],
                    'stack'    => ['python', 'scikitlearn', 'googlebigquery', 'dbt'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Subscription and repeat-purchase businesses that learn about churn too late.',
                ],
                [
                    'key'      => 'value-tiers',
                    'name'     => 'Lifetime value & value tiering',
                    'desc'     => 'Model what customers are worth over time, by segment and by cohort, and decide how much you can justify spending to keep them.',
                    'includes' => ['Lifetime value modelling by segment and cohort', 'Acquisition cost and payback analysis', 'Value tiers with service and contact implications', 'Guidance on retention and acquisition budgets'],
                    'tags'     => ['LTV', 'Cohorts', 'Payback'],
                    'stack'    => ['googlebigquery', 'snowflake', 'python', 'looker'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses setting acquisition budgets without knowing what a customer is worth.',
                ],
            ]],

            ['key' => 'engagement', 'name' => 'Engagement programmes', 'icon' => 'chat', 'offers' => [
                [
                    'key'      => 'contact-strategy',
                    'name'     => 'Contact strategy & pressure rules',
                    'desc'     => 'Decide who hears from you, how often, about what and on which channel, then enforce it across every team that sends.',
                    'includes' => ['Contact strategy per segment and lifecycle stage', 'Frequency caps, priority and quiet hours', 'Conflict rules between teams and campaigns', 'Implementation in your sending platforms'],
                    'tags'     => ['Contact strategy', 'Frequency caps', 'Priority'],
                    'stack'    => ['hubspot', 'salesforce', 'twilio'],
                    'time'     => '4–7 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands where three teams email the same customer in one week.',
                ],
                [
                    'key'      => 'onboarding-programme',
                    'name'     => 'Onboarding & adoption programme',
                    'desc'     => 'Get new customers to the moment they first get value, and measure how many reach it and how fast.',
                    'includes' => ['Definition of first value per segment', 'Onboarding content, messages and prompts', 'Progress tracking and intervention triggers', 'Time-to-value and activation reporting'],
                    'tags'     => ['Onboarding', 'Activation', 'Time to value'],
                    'stack'    => ['hubspot', 'intercom', 'twilio', 'mixpanel'],
                    'time'     => '5–9 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products and services where early drop-off decides the year.',
                ],
                [
                    'key'      => 'winback-programme',
                    'name'     => 'Win-back & save programme',
                    'desc'     => 'Reach customers at risk with something worth staying for, and handle cancellation as a conversation rather than a form.',
                    'includes' => ['Risk triggers from the churn model', 'Save offers modelled against margin', 'Cancellation and downgrade flows', 'Incremental saves measured against a holdout'],
                    'tags'     => ['Save', 'Win-back', 'Holdouts'],
                    'stack'    => ['hubspot', 'salesforce', 'twilio', 'whatsapp'],
                    'time'     => '5–9 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses that only notice a customer leaving after they have gone.',
                ],
                [
                    'key'      => 'advocacy-community',
                    'name'     => 'Advocacy & community programme',
                    'desc'     => 'Turn satisfied customers into referrals, reviews and references, with a programme that is tracked rather than hoped for.',
                    'includes' => ['Advocate identification from behaviour and satisfaction data', 'Referral, review and reference mechanics', 'Community and recognition design', 'Attribution of referred revenue'],
                    'tags'     => ['Advocacy', 'Referral', 'Reviews'],
                    'stack'    => ['hubspot', 'salesforce', 'intercom'],
                    'time'     => '5–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands with happy customers and no way to put that to work.',
                ],
            ]],

            ['key' => 'loyalty', 'name' => 'Loyalty strategy & programmes', 'icon' => 'handshake', 'offers' => [
                [
                    'key'      => 'loyalty-strategy',
                    'name'     => 'Loyalty strategy & mechanic design',
                    'desc'     => 'Decide what loyalty should mean for your customers and your margin before choosing a mechanic, points or otherwise.',
                    'includes' => ['Customer value and motivation research', 'Mechanic options compared, including non-points models', 'Earn, redeem, tier and benefit design', 'Competitive and category review'],
                    'tags'     => ['Strategy', 'Mechanics', 'Tiers'],
                    'stack'    => [],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands considering a programme, or copying a competitor’s without knowing why.',
                ],
                [
                    'key'      => 'loyalty-economics',
                    'name'     => 'Loyalty economics & liability model',
                    'desc'     => 'Model what the programme costs and returns, including breakage, margin impact and the accounting liability finance will carry.',
                    'includes' => ['Cost, margin and incremental revenue model', 'Breakage and redemption rate scenarios', 'Deferred revenue and liability treatment with finance', 'Sensitivity analysis before launch'],
                    'tags'     => ['Economics', 'Breakage', 'Liability'],
                    'stack'    => ['python', 'powerbi'],
                    'time'     => '4–7 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Any brand whose finance team has to approve a loyalty programme.',
                ],
                [
                    'key'      => 'loyalty-build',
                    'name'     => 'Loyalty programme build & launch',
                    'desc'     => 'Implement the programme across your commerce, CRM and messaging stack, with the member experience designed rather than assembled.',
                    'includes' => ['Platform selection or custom build', 'Member enrolment, account and status experience', 'Point, tier and benefit engine integration', 'Launch communication and staff training'],
                    'tags'     => ['Build', 'Launch', 'Member experience'],
                    'stack'    => ['shopify', 'salesforce', 'hubspot', 'postgresql'],
                    'time'     => '10–20 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands taking a designed programme to market.',
                ],
                [
                    'key'      => 'loyalty-review',
                    'name'     => 'Loyalty programme review',
                    'desc'     => 'An independent read on a programme you already run: who uses it, what it costs, what it earns and what to change.',
                    'includes' => ['Member behaviour and tier analysis', 'Cost, breakage and incrementality read', 'Benefit-by-benefit value assessment', 'Prioritised change plan'],
                    'tags'     => ['Review', 'Incrementality', 'Change plan'],
                    'stack'    => ['googlebigquery', 'python', 'looker'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands running a programme that costs more each year and proves less.',
                ],
            ]],

            ['key' => 'lifecycle', 'name' => 'Lifecycle marketing', 'icon' => 'workflow', 'offers' => [
                [
                    'key'      => 'lifecycle-calendar',
                    'name'     => 'Lifecycle strategy & calendar',
                    'desc'     => 'The full plan of planned and triggered communication by lifecycle stage, with an owner, a measure and a holdout group for each.',
                    'includes' => ['Lifecycle stages and entry criteria', 'Programme and trigger calendar', 'Owner, measure and holdout per programme', 'Release order by expected value'],
                    'tags'     => ['Lifecycle', 'Calendar', 'Owners'],
                    'stack'    => ['hubspot', 'salesforce', 'notion'],
                    'time'     => '5–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams sending campaigns with no view of the whole customer year.',
                ],
                [
                    'key'      => 'lifecycle-build',
                    'name'     => 'Lifecycle programme build',
                    'desc'     => 'Build the programmes in your platforms: triggers, content, eligibility and suppression, with measurement in place from day one.',
                    'includes' => ['Journey and trigger configuration', 'Message and content production', 'Eligibility, suppression and pressure rules', 'Holdouts and reporting from launch'],
                    'tags'     => ['Build', 'Triggers', 'Measured'],
                    'stack'    => ['hubspot', 'salesforce', 'twilio', 'whatsapp', 'contentful'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands with a lifecycle plan and no capacity to build it.',
                ],
                [
                    'key'      => 'retention-dashboard',
                    'name'     => 'Retention & lifetime value reporting',
                    'desc'     => 'One view of retention, cohorts, churn and lifetime value that leadership reads without needing a translation.',
                    'includes' => ['Cohort retention and repeat purchase curves', 'Churn, reactivation and lifetime value trends', 'Programme contribution against holdouts', 'Monthly commentary and next actions'],
                    'tags'     => ['Cohorts', 'Retention', 'LTV'],
                    'stack'    => ['googlebigquery', 'dbt', 'looker', 'powerbi'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Boards asking whether retention is improving and getting an anecdote.',
                ],
                [
                    'key'      => 'crs-programme',
                    'name'     => 'Customer programme retainer',
                    'desc'     => 'Reserved monthly capacity to run the five parts together: journeys revisited, segments refreshed, programmes improved and loyalty reviewed.',
                    'includes' => ['Reserved strategy, analysis and build capacity', 'Quarterly plan across all five areas', 'Continuous testing with holdouts', 'Monthly review of retention and lifetime value'],
                    'tags'     => ['Retainer', 'Quarterly plan', 'All five areas'],
                    'stack'    => ['hubspot', 'salesforce', 'googlebigquery', 'looker'],
                    'time'     => 'Ongoing, quarterly cycles',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses where retention and lifetime value are board-level measures.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer', 'enterprise'],
    ],

];
