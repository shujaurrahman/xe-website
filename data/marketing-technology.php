<?php
/**
 * Marketing Technology — the seven capabilities, in depth.
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
 *   img                             card photo ['src','w','h','alt','pos'] (assets/imgs/martech/shared/,
 *                                   credits in CREDITS.md there — the builder sources and credits these)
 *   stack                           technology slugs from data/tech-stack.php, most relevant first (render with xt_stack)
 *   standards                       badge keys from xt_standards() (render with xt_badge)
 *
 * IMPORTANT — capability 07, Customer Relationship Strategy, is ONE capability, not five.
 * Journey mapping, customer segmentation and insights, engagement programmes, loyalty strategy
 * and lifecycle marketing are the five parts of a single practice: they are sold together, run
 * together and measured together, and they are the sections of its one page. Never split them
 * into separate capabilities or separate pages.
 *
 * Truthfulness: technologies are ones we work with, never partnerships. Standards are frameworks
 * delivery is built to or aligned with; nothing here says Xterra Edze holds a certification. No
 * results, client names or volumes are claimed. Platform behaviour described here (consent mode,
 * message templates, sender requirements) is the vendors' own, correct at the time of writing.
 *
 * DRAFT COPY — review before launch.
 *
 * Voice: calm, precise, confident. Short active sentences. No exclamation marks.
 */

return [

    'ai-driven-marketing-automation' => [
        'n'          => '01',
        'slug'       => 'ai-driven-marketing-automation',
        'name'       => 'AI-Driven Marketing Automation',
        'short'      => 'Automation',
        'kicker'     => 'The work that runs itself',
        'title'      => '<span class="g">Marketing runs every hour.</span> Your team should not have to.',
        'lead'       => 'AI-Driven Marketing Automation builds the journeys, triggers and agents that carry marketing between campaigns: onboarding, nurture, win-back and renewal running across email, SMS, WhatsApp, push and in-app, decided per person and approved by a human where it matters.',
        'meta'       => ['6–12 weeks to the first journeys', 'Email · SMS · WhatsApp · push · in-app', 'Consent and approval built in'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical first release', 'Channels', 'Standard'],
        'cta'        => 'Start an automation brief',
        'icon'       => 'workflow',
        'offer_title'=> '<span class="g">Six moving parts,</span> one orchestration layer',
        'offer_lead' => 'Events, decisions, content and consent meet in one place, so a journey can be changed once and behave the same in every channel.',
        'offer' => [                    // [title, description, tag, icon — see xt_icons()]
            ['Lifecycle journey design & build', 'Welcome, onboarding, nurture, cart and browse recovery, win-back and renewal journeys, each with entry rules, exit criteria, suppression and a holdout group.', 'Journeys · triggers', 'workflow'],
            ['Platform set-up & migration',      'Implementation or replatforming of your marketing automation stack, with data model, subscriber states and journeys rebuilt rather than copied across.', 'HubSpot · Salesforce · Zoho', 'sync'],
            ['Event & trigger infrastructure',   'Behavioural events from your site, app and product streamed to the platform through server-side tagging, with identity stitched on hashed identifiers.', 'Server-side · identity', 'pipeline'],
            ['Next best action & send time',     'Models that choose the channel, offer and moment per person from their own history, with fallbacks when confidence is low and a rule-based path always available.', 'Per-person decisioning', 'brain'],
            ['Agentic marketing operations',     'Agents that assemble briefs, draft variants, build audiences and run pre-flight QA, with scoped permissions, a person approving every send and a log of every step.', 'Draft · check · approve', 'agent'],
            ['Consent, preferences & deliverability', 'A preference centre, consent capture and suppression logic, with SPF, DKIM and DMARC, one-click unsubscribe, sender warm-up and WhatsApp opt-in handled properly.', 'Consent · inbox placement', 'shield'],
        ],
        'process' => [
            'title' => '<span class="g">Twelve weeks</span> from first map to always-on',
            'lead'  => 'One journey ships early and proves the plumbing. The rest follow on the same rails.',
            'steps' => [
                ['Map',     'Wk 01–03', 'Current journeys, data sources, channels, consent records and the moments worth automating. The first journey is chosen for value and for the events it forces you to fix.', ['Journey inventory', 'Event & data map', 'Automation backlog']],
                ['Build',   'Wk 03–07', 'Data model, event tracking, subscriber states and content templates built, with the first journey assembled end to end and tested against real profiles.', ['Event tracking', 'Data model', 'First journey live']],
                ['Automate','Wk 06–11', 'The remaining journeys built in priority order, decisioning introduced where there is enough history, and guardrails set: frequency caps, quiet hours and pressure rules.', ['Journey set', 'Decisioning rules', 'Contact guardrails']],
                ['Operate', 'Wk 11–12', 'Handover with runbooks, a monthly review of journey performance against holdouts, and a backlog of improvements ranked by lift.', ['Runbooks', 'Performance dashboard', 'Improvement backlog']],
            ],
        ],
        'deliver' => [
            ['Journey maps & automation blueprint',        'Diagrams · board'],
            ['Configured journeys in your platform',       'Platform build'],
            ['Event tracking plan & server-side tagging',  'Spec · container'],
            ['Audience, segment & suppression logic',      'Platform config'],
            ['Message templates & preference centre',      'Templates · page'],
            ['Deliverability set-up & monitoring',         'DNS · dashboard'],
            ['Runbooks & admin guides',                    'Docs'],
        ],
        'outcomes' => [
            ['Marketing that keeps working',  'Revenue-earning journeys run between campaigns, so quiet weeks stop being empty ones.'],
            ['Fewer hands on every send',     'Assembly, checks and audience building are automated. People spend their time on the offer and the words.'],
            ['Pressure that is controlled',   'Frequency caps, quiet hours and suppression applied across channels, so automation raises contact quality rather than contact volume.'],
        ],
        'faq' => [
            ['Do we need to change our marketing automation platform?', 'Usually not. Most platforms do more than the team has been able to use. We assess what yours can do first and recommend a move only when a hard limit, such as real-time events, channel coverage or cost at your volume, cannot be worked around.'],
            ['Where does AI actually decide something?', 'In four places: which people enter a journey, what the next best action is, when to send, and which variant to use. Every one has a rule-based fallback, a confidence threshold and a holdout group, so the contribution can be measured and switched off.'],
            ['Who approves what goes out?', 'A person does, on every campaign send. Agents draft, assemble and check; the send button belongs to your team. Triggered transactional and lifecycle messages are approved once as a template and then monitored.'],
            ['How do you handle consent and preferences?', 'Consent is captured with its source, timestamp and scope, stored against the profile and enforced at send time rather than at list build. Preference centres let people choose topic and frequency instead of only opting out, which usually keeps more of the list.'],
            ['Will this improve email deliverability?', 'It is designed to. Authentication with SPF, DKIM and DMARC, one-click unsubscribe, list hygiene, engagement-based sending and sender warm-up are part of the build, and inbox placement is monitored. No one can promise inbox placement, because mailbox providers decide it.'],
        ],
        'pairs'     => ['content-communication-infrastructure', 'customer-relationship-strategy'],
        'img'       => ['src' => 'assets/imgs/martech/shared/ai-driven-marketing-automation.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A marketer reviews a multi-step campaign flow on a laptop screen in a quiet office', 'pos' => '50% 45%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['hubspot', 'salesforce', 'zoho', 'twilio', 'whatsapp', 'googletagmanager', 'googleanalytics', 'n8n', 'make', 'zapier', 'temporal', 'openai', 'anthropic', 'postgresql'],
        'standards' => ['gdpr', 'dpdp', 'iso27701', 'wcag22', 'nist-ai-rmf', 'eu-ai-act'],
    ],

    'content-communication-infrastructure' => [
        'n'          => '02',
        'slug'       => 'content-communication-infrastructure',
        'name'       => 'Content & Communication Infrastructure',
        'short'      => 'Infrastructure',
        'kicker'     => 'One source, every channel',
        'title'      => '<span class="g">Write it once.</span> Publish it everywhere, correctly.',
        'lead'       => 'Content & Communication Infrastructure is the plumbing under marketing: a structured content model, a governed asset library, localisation that scales, and messaging set up so email, SMS and WhatsApp arrive. Change a price, a claim or a logo in one place and every channel follows.',
        'meta'       => ['8–16 weeks', 'CMS · DAM · messaging', 'Structured, versioned, reusable'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical build', 'Scope', 'Approach'],
        'cta'        => 'Start an infrastructure brief',
        'icon'       => 'stack',
        'offer_title'=> '<span class="g">Content as data,</span> not as documents',
        'offer_lead' => 'When content is modelled as fields rather than pages, the same fact can serve a website, an email, an ad and an assistant without being retyped.',
        'offer' => [
            ['Content model & headless CMS',        'Content typed as structured fields with reusable blocks, versioning and preview, so a product fact, price or claim exists once and is referenced everywhere.', 'Structured · reusable', 'doc'],
            ['Digital asset management',            'One library for photography, video, logos and templates, with usage rights, licence expiry and market restrictions held as metadata rather than in someone’s memory.', 'Rights · metadata', 'cube'],
            ['Localisation & translation pipeline', 'Machine translation with in-market human review, locale variants, right-to-left support and regional legal lines, delivered as part of publishing rather than a project.', 'Locales · review', 'globe'],
            ['Messaging infrastructure',            'Email, SMS and WhatsApp senders configured properly: SPF, DKIM, DMARC and BIMI, dedicated IP warm-up, approved WhatsApp templates and the 24-hour service window respected.', 'Deliverable by design', 'plug'],
            ['Channel component library',           'Modular email, landing page and message components built on your brand tokens, tested for accessibility, dark mode and the clients your audience actually uses.', 'Tokens · tested', 'layers'],
            ['Editorial workflow & governance',     'Roles, review stages, legal and compliance sign-off, scheduled publishing and a full audit trail of who changed what, in the tools the team already opens.', 'Approvals · audit trail', 'approve'],
        ],
        'process' => [
            'title' => '<span class="g">Model first,</span> migrate second',
            'lead'  => 'The content model is agreed and tested against real pages and real campaigns before anything is migrated into it.',
            'steps' => [
                ['Model',   'Wk 01–04', 'Content audit, channel inventory and the model itself: types, fields, relationships and reuse rules, tested against your hardest existing pages and campaigns.', ['Content audit', 'Content model', 'Governance plan']],
                ['Build',   'Wk 04–10', 'CMS and asset library configured, components and templates built on brand tokens, messaging senders authenticated and warmed, workflows and permissions set.', ['CMS build', 'Component library', 'Sender set-up']],
                ['Migrate', 'Wk 09–14', 'Content and assets moved with mapping and rights metadata, redirects in place, gaps fixed rather than carried over. Editors trained on real work.', ['Migration', 'Redirect map', 'Editor training']],
                ['Operate', 'Wk 14–16', 'Handover with documentation, an owner per content type, and a quarterly review of the model as new channels appear.', ['Documentation', 'Ownership map', 'Review cadence']],
            ],
        ],
        'deliver' => [
            ['Content model & type documentation',      'Schema · docs'],
            ['Configured CMS & asset library',          'Platform build'],
            ['Email, landing & message component library','Templates · tokens'],
            ['Localisation workflow & glossary',        'Workflow · sheet'],
            ['Sender authentication & deliverability set-up', 'DNS · report'],
            ['Editorial workflow & permissions',        'Config · RACI'],
            ['Migration mapping & redirect plan',        'Sheet'],
        ],
        'outcomes' => [
            ['One fact, one place',        'A price, claim or disclaimer is changed once and is correct in every channel that references it.'],
            ['Localisation stops being a project', 'New markets reuse the model, the glossary and the review workflow instead of starting again.'],
            ['Messages that arrive',       'Authenticated senders, warmed IPs and clean lists, so the work put into a campaign is not lost at the inbox.'],
        ],
        'faq' => [
            ['Is this the same as building a website?', 'No. Websites & Apps, in Technology & Intelligence, builds the site or app. This builds the content and messaging layer underneath it, which that site, your emails, your ads and your assistants all read from. The two are often delivered together.'],
            ['Which CMS do you recommend?', 'The one your editors will use and your developers can build on. We work with headless platforms such as Contentful, Sanity and Strapi, with WordPress and with Webflow, and choose on content model, localisation, workflow and total cost rather than on preference.'],
            ['Why does a content model matter for marketing?', 'Because unstructured content cannot be reused. Modelled content can be assembled automatically into emails, ads and landing pages, fed to AI systems with the right context, and corrected in one edit. It is what makes personalisation at scale affordable.'],
            ['Can AI write directly into the CMS?', 'Yes, as a draft. Generation runs against your model and your approved facts, lands in a draft state, and moves through the same review as anything else. Nothing is published without a named person approving it.'],
            ['What about content rights and licences?', 'Usage rights, territory, channel and expiry are held as metadata on every asset, and assets past their licence are blocked from new campaigns and flagged where they are already in use.'],
        ],
        'pairs'     => ['ai-creative-solutions', 'ai-driven-marketing-automation'],
        'img'       => ['src' => 'assets/imgs/martech/shared/content-communication-infrastructure.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A designer arranges content modules and image tiles across two screens at a tidy desk', 'pos' => '50% 50%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['contentful', 'sanity', 'strapi', 'wordpress', 'webflow', 'figma', 'algolia', 'twilio', 'whatsapp', 'cloudflare', 'vercel', 'n8n'],
        'standards' => ['wcag22', 'cwv', 'gdpr', 'dpdp', 'iso27701'],
    ],

    'ai-campaign-optimization' => [
        'n'          => '03',
        'slug'       => 'ai-campaign-optimization',
        'name'       => 'AI Campaign Optimization',
        'short'      => 'Campaign AI',
        'kicker'     => 'Tuned while it runs',
        'title'      => '<span class="g">Most campaigns are judged after they end.</span> These are corrected while they run.',
        'lead'       => 'AI Campaign Optimization builds the measurement and the models that decide where budget goes: clean signal, incrementality tests, marketing mix modelling and daily reallocation. Proposals arrive with their reasoning; a person approves anything that moves money.',
        'meta'       => ['4–8 weeks to the first models', 'Paid · owned · earned', 'Incrementality, not last click'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical first release', 'Scope', 'Standard'],
        'cta'        => 'Start an optimisation brief',
        'icon'       => 'trend-up',
        'offer_title'=> '<span class="g">Measure it honestly,</span> then let the model act',
        'offer_lead' => 'No model survives a broken measurement layer. Signal quality is fixed first, then experiments calibrate the models, then automation acts within limits you set.',
        'offer' => [
            ['Measurement foundations',        'Server-side tagging, consent mode, conversion APIs with event deduplication and offline conversion import, so platforms and your warehouse agree on what happened.', 'Clean, consented signal', 'gauge'],
            ['Incrementality & geo experiments','Holdout and geo-split tests that measure what advertising actually caused, used to calibrate every model that follows.', 'Lift · holdouts', 'eval'],
            ['Marketing mix modelling',        'Bayesian mix models with adstock and saturation curves, calibrated against experiments, producing budget scenarios by channel and market.', 'MMM · scenarios', 'chart'],
            ['Budget allocation & bidding',    'Daily or weekly reallocation proposals across channels and campaigns, each with expected effect and confidence, executed through platform APIs after approval.', 'Proposed · approved · applied', 'agent'],
            ['Creative & audience testing',    'Structured test plans with sequential testing or multi-armed bandits, fatigue detection and a library of what has already been learned.', 'Tests · bandits', 'filter'],
            ['Anomaly detection & guardrails', 'Pacing, cost and conversion anomalies detected within hours, with spend caps, rollback and a kill switch that does not need an agency ticket.', 'Alerts · caps · rollback', 'alert'],
        ],
        'process' => [
            'title' => '<span class="g">Baseline, instrument, model,</span> then automate',
            'lead'  => 'Each phase is only worth running because the one before it is trustworthy. Automation comes last, not first.',
            'steps' => [
                ['Baseline',   'Wk 01–02', 'Current spend, reporting, attribution and data quality reviewed. Gaps between platform numbers and your own records quantified, and the first experiments designed.', ['Signal audit', 'Spend baseline', 'Experiment plan']],
                ['Instrument', 'Wk 02–05', 'Server-side tagging, consent mode, conversion APIs and warehouse ingestion built, with event deduplication and a single conversion definition.', ['Tracking build', 'Warehouse pipeline', 'Metric definitions']],
                ['Model',      'Wk 05–09', 'Mix models fitted and calibrated against experiment results, with scenario planning and a written read on what each channel contributes.', ['MMM results', 'Experiment readouts', 'Budget scenarios']],
                ['Optimise',   'Ongoing',  'Reallocation proposals and creative tests run on a weekly cadence, guardrails monitored, and models refitted as the data grows.', ['Weekly proposals', 'Test log', 'Monthly performance review']],
            ],
        ],
        'deliver' => [
            ['Measurement plan & metric definitions',   'Doc · sheet'],
            ['Server-side tagging & conversion APIs',   'Container · code'],
            ['Experiment designs & readouts',           'Plan · report'],
            ['Marketing mix model & scenario tool',     'Model · dashboard'],
            ['Budget allocation proposals',             'Dashboard · log'],
            ['Creative & audience test library',        'Sheet · board'],
            ['Anomaly alerts & spend guardrails',       'Alerts · config'],
        ],
        'outcomes' => [
            ['Numbers that agree',        'One conversion definition across platforms, analytics and the warehouse, so meetings are about decisions rather than whose report is right.'],
            ['Budget that follows evidence','Allocation informed by experiments and modelled contribution instead of platform-reported credit.'],
            ['Mistakes caught in hours',  'Pacing and cost anomalies surface the same day, with caps and rollback ready, not at the month-end review.'],
        ],
        'faq' => [
            ['Is this the same as Performance Marketing?', 'No. Performance Marketing, in Campaign & Content Design, plans and runs the media. This builds the measurement, models and automation that decide where the money should go. It works with our media team or with the agency you already use.'],
            ['Attribution, incrementality or mix modelling — which do we need?', 'All three answer different questions. Attribution shows paths and is useful for operations. Experiments measure true causal lift on a specific channel. Mix modelling covers the whole budget, including channels you cannot track. We use experiments to calibrate the model and treat attribution as a diagnostic.'],
            ['Does signal loss from privacy changes break this?', 'It changes the method, not the outcome. Consent mode, server-side tagging and conversion APIs preserve what people have agreed to share, and mix modelling and geo experiments do not depend on individual tracking at all.'],
            ['Will an AI system be allowed to change our budgets?', 'Only within limits you set. Proposals carry the expected effect, the confidence and the reasoning; a named person approves anything above the threshold you choose; caps, exclusions and rollback are always on. Full autonomy is available for narrow, well-tested decisions once evidence supports it.'],
            ['How much data does mix modelling need?', 'Typically two to three years of weekly history across channels and markets, plus spend, price and seasonality. With less, we start with experiments and lightweight models and build towards it.'],   // PLACEHOLDER: confirm data requirement guidance before launch
        ],
        'pairs'     => ['ai-creative-solutions', 'ai-lead-generation'],
        'img'       => ['src' => 'assets/imgs/martech/shared/ai-campaign-optimization.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'Analytics charts and spend trends fill a widescreen monitor in a dim room', 'pos' => '50% 50%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['googleanalytics', 'googletagmanager', 'google', 'googlebigquery', 'dbt', 'snowflake', 'airbyte', 'python', 'scikitlearn', 'looker', 'powerbi', 'posthog', 'mixpanel'],
        'standards' => ['gdpr', 'dpdp', 'nist-ai-rmf', 'eu-ai-act', 'iso27701'],
    ],

    'ai-creative-solutions' => [
        'n'          => '04',
        'slug'       => 'ai-creative-solutions',
        'name'       => 'AI Creative Solutions',
        'short'      => 'Creative AI',
        'kicker'     => 'Production at campaign pace',
        'title'      => '<span class="g">Ten thousand variants.</span> One brand that still looks like itself.',
        'lead'       => 'AI Creative Solutions is the production system behind modern campaigns: one brief becomes every size, language and audience variant a channel needs, generated inside brand rules, checked automatically and signed off by a person before anything runs.',
        'meta'       => ['6–10 weeks to a working pipeline', 'Ads · email · landing · feeds', 'Human sign-off on every release'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical first release', 'Formats', 'Standard'],
        'cta'        => 'Start a creative brief',
        'icon'       => 'sparkle',
        'offer_title'=> '<span class="g">Volume without drift,</span> speed without risk',
        'offer_lead' => 'Generation is constrained by your components, your approved claims and your brand rules, so scale does not become a brand problem or a legal one.',
        'offer' => [
            ['Creative variant engine',       'Modular templates plus generative copy and imagery that turn one approved concept into every size, language and audience variant a channel calls for.', 'One brief · many variants', 'layers'],
            ['Dynamic creative optimisation', 'Ads assembled per audience and context from a governed set of components, with the combinations that work fed back into the next brief.', 'DCO · assembly', 'puzzle'],
            ['Product feed creative',         'Catalogue-driven creative for commerce: feed hygiene, price and stock accuracy, and templates that stay correct as the catalogue changes.', 'Catalogue · feeds', 'database'],
            ['On-brand generation & guardrails','Reference libraries and brand-tuned models, with automated checks for logo use, colour, type, safe areas, banned claims and required legal lines.', 'Checked before it ships', 'shield'],
            ['Localisation & adaptation',     'Transcreation rather than translation, reviewed in market, with script, right-to-left and regional advertising rules handled in the template.', 'Markets · transcreation', 'globe'],
            ['Rights, provenance & disclosure','Model licensing reviewed, likeness and music rights recorded, Content Credentials (C2PA) attached where supported, and AI disclosure applied where regulation or platform policy requires it.', 'Licensed · labelled', 'clipboard-check'],
        ],
        'process' => [
            'title' => '<span class="g">Set the rules,</span> then let the pipeline run',
            'lead'  => 'The first two weeks decide what the system may and may not produce. Everything after that is volume.',
            'steps' => [
                ['Frame',    'Wk 01–02', 'Formats, markets, channels and volumes agreed. Brand rules, approved claims and banned territory written as machine-checkable constraints.', ['Format matrix', 'Brand rule set', 'Claim library']],
                ['Assemble', 'Wk 02–06', 'Component templates built, reference libraries prepared, models selected per task and compared for quality, likeness fidelity, cost and licence terms.', ['Template system', 'Model comparison', 'Reference library']],
                ['Produce',  'Wk 05–09', 'The first campaign produced end to end, with automated checks, a human review queue and a named approver before release.', ['Production run', 'QA checks', 'Approval workflow']],
                ['Measure',  'Wk 09–10', 'Performance by component and variant fed back, so the next brief starts from what is already known to work.', ['Component performance', 'Learning library', 'Next-cycle brief']],
            ],
        ],
        'deliver' => [
            ['Creative production pipeline',              'Workflow · code'],
            ['Modular template & component system',       'Figma · templates'],
            ['Brand rule set & automated checks',         'Config · tests'],
            ['Approved claim & legal line library',       'Sheet · CMS'],
            ['Variant sets by format, market and audience','Assets · DAM'],
            ['Rights, licence & provenance register',     'Sheet'],
            ['Component performance report',              'Dashboard'],
        ],
        'outcomes' => [
            ['Production stops being the bottleneck', 'Campaign volume is set by the media plan, not by how many adaptations a studio can finish this week.'],
            ['On brand at any volume',                'Every variant is checked against the same rules before release, so scale does not erode the identity.'],
            ['Defensible by default',                 'Licences, rights, disclosure and approvals recorded per asset, so the question "where did this come from" has an answer.'],
        ],
        'faq' => [
            ['How is this different from AI Design’s content studio?', 'AI Design sets the creative direction and builds the brand’s own AI tools: tuned models, brand systems, the look. This is the production line wired into the campaign stack, turning that direction into the thousands of sized, localised, feed-driven assets that media plans consume.'],
            ['Does AI-generated creative perform as well?', 'It performs as well as the thinking behind it. What AI reliably changes is volume and speed, which lets you test far more and find winners faster. We measure component by component against your existing creative rather than assuming a gain.'],
            ['Is our brand or customer data used to train public models?', 'No. We use enterprise terms that exclude training on your inputs, or models hosted in your own environment. Brand tuning uses your assets under your licence and stays yours.'],
            ['Do we have to tell people creative is AI-generated?', 'Sometimes. Transparency duties for synthetic content in the EU AI Act, advertising codes and individual platform policies can all apply, and they differ by market. We map which rules apply to each campaign and build the disclosure into the template rather than leaving it to a checker.'],
            ['Who is accountable for what goes out?', 'Your approver. The pipeline enforces brand and claim checks and blocks what fails, but a named person releases every campaign, and the log shows who approved which version and when.'],
        ],
        'pairs'     => ['ai-campaign-optimization', 'content-communication-infrastructure'],
        'img'       => ['src' => 'assets/imgs/martech/shared/ai-creative-solutions.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A grid of campaign layouts in different sizes laid out on a large studio display', 'pos' => '50% 45%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['openai', 'anthropic', 'googlegemini', 'replicate', 'huggingface', 'modal', 'figma', 'shopify', 'contentful', 'cloudflare', 'python', 'n8n'],
        'standards' => ['eu-ai-act', 'nist-ai-rmf', 'iso42001', 'wcag22', 'gdpr', 'dpdp'],
    ],

    'ai-lead-generation' => [
        'n'          => '05',
        'slug'       => 'ai-lead-generation',
        'name'       => 'AI Lead Generation',
        'short'      => 'Lead Gen',
        'kicker'     => 'Fewer leads, better ones',
        'title'      => '<span class="g">More leads is the easy ask.</span> Better ones change the quarter.',
        'lead'       => 'AI Lead Generation finds and qualifies the demand worth a salesperson’s time: an ideal customer profile built from your own closed-won history, first-party intent signals, scoring models you can explain, and routing that gets the right lead to the right person in minutes.',
        'meta'       => ['6–10 weeks to a scored pipeline', 'Inbound · outbound · partner', 'Consent-first data sourcing'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical first release', 'Sources', 'Standard'],
        'cta'        => 'Start a lead generation brief',
        'icon'       => 'target',
        'offer_title'=> '<span class="g">Six steps</span> from stranger to qualified conversation',
        'offer_lead' => 'Each step is measured on what reaches a sales conversation and closes, not on the count of forms filled in.',
        'offer' => [
            ['ICP & account prioritisation',  'An ideal customer profile built from the deals you actually won, turned into a tiered, sized target list your teams agree on.', 'Fit · tiers · list', 'target'],
            ['Intent & signal capture',       'First-party behaviour across your site, content, product and events, combined with declared intent, to show which accounts are moving and when.', 'Signals · timing', 'radar'],
            ['Data enrichment & hygiene',     'Deduplication, normalisation, validation and decay handling, so the CRM keeps one accurate record per person and per account.', 'Clean · deduplicated', 'database'],
            ['Scoring & propensity models',   'Fit and engagement models trained on closed-won history, with the contributing features shown per lead, monitored for drift and reviewed for bias.', 'Explainable scores', 'brain'],
            ['Conversational qualification',  'Assistants on the site, on WhatsApp and on the phone that answer real questions, qualify against your criteria and book meetings, handing over with full context.', 'Chat · WhatsApp · voice', 'chat'],
            ['Routing & speed to lead',       'Rules that route by territory, product and account owner, with alerts, escalation and first-response time measured against a target you set.', 'Routed in minutes', 'bolt'],
        ],
        'process' => [
            'title' => '<span class="g">Define who is worth it,</span> then find more of them',
            'lead'  => 'The profile comes from your own won and lost deals, so the model learns your market rather than a generic one.',
            'steps' => [
                ['Define',     'Wk 01–03', 'Closed-won and closed-lost analysis, sales interviews and the definition of a qualified lead that marketing and sales both sign.', ['ICP & tiers', 'Qualification definition', 'Target list']],
                ['Instrument', 'Wk 03–06', 'Signal capture, enrichment and CRM hygiene built, with consent recorded at source and a single record per person and account.', ['Signal pipeline', 'Enrichment rules', 'CRM clean-up']],
                ['Score',      'Wk 05–09', 'Fit and engagement models trained, tested against historic outcomes, and exposed in the CRM with the reasons behind each score.', ['Scoring model', 'Backtest results', 'CRM fields & views']],
                ['Convert',    'Wk 09–10', 'Routing, alerts and conversational qualification live, with first-response time and conversion by score band reported weekly.', ['Routing rules', 'Assistant flows', 'Conversion dashboard']],
            ],
        ],
        'deliver' => [
            ['ICP definition & tiered target list',   'Doc · sheet'],
            ['Signal capture & enrichment pipeline',  'Code · config'],
            ['Lead scoring model & documentation',    'Model · model card'],
            ['CRM fields, views & score explanations','CRM build'],
            ['Conversational qualification flows',    'Assistant · scripts'],
            ['Routing rules & response targets',      'Config · SLA doc'],
            ['Pipeline quality dashboard',            'Dashboard'],
        ],
        'outcomes' => [
            ['Sales stops filtering',      'Leads arrive tiered and explained, so representatives spend their day in conversations rather than in triage.'],
            ['One definition of qualified','Marketing and sales agree what counts before the model is built, which is where most scoring projects fail.'],
            ['Faster first response',      'Routing and alerts measured in minutes, with escalation when nobody picks a lead up.'],
        ],
        'faq' => [
            ['Do you buy contact lists?', 'No. Purchased lists damage deliverability, breach consent rules in most of our clients’ markets and rarely convert. We work from first-party signals, legitimate business data sources with a lawful basis, and demand you create.'],
            ['Can you guarantee a number of leads?', 'No, and we would not trust anyone who does. We commit to the system, the measurement and a weekly view of pipeline quality. Volume targets are set together from your own baseline once the first cycle has run.'],
            ['How do you keep the scoring model fair and explainable?', 'Features are chosen with your sales team and documented in a model card. Protected and proxy attributes are excluded. Each score shows its main contributing factors, and the model is monitored for drift and reviewed on a set cadence.'],   // PLACEHOLDER: confirm review cadence before launch
            ['Is cold outreach still allowed?', 'It depends on the market and the channel. B2B email has different rules from SMS or WhatsApp, and India’s DPDP Act, the GDPR and ePrivacy rules each set their own conditions. We set the rules per market before the first message and record consent and lawful basis against every contact.'],
            ['Where does all of this live?', 'In your CRM and your data warehouse. Models, pipelines and documentation are handed over, so the asset stays yours if the engagement ends.'],
        ],
        'pairs'     => ['automated-dynamic-sales', 'ai-campaign-optimization'],
        'img'       => ['src' => 'assets/imgs/martech/shared/ai-lead-generation.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'Two colleagues review a pipeline board on a screen while taking notes', 'pos' => '50% 45%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['hubspot', 'salesforce', 'zoho', 'twilio', 'whatsapp', 'intercom', 'googleanalytics', 'googletagmanager', 'posthog', 'googlebigquery', 'dbt', 'python', 'scikitlearn', 'slack'],
        'standards' => ['gdpr', 'dpdp', 'iso27701', 'nist-ai-rmf', 'eu-ai-act'],
    ],

    'automated-dynamic-sales' => [
        'n'          => '06',
        'slug'       => 'automated-dynamic-sales',
        'name'       => 'Automated & Dynamic Sales',
        'short'      => 'Sales',
        'kicker'     => 'The pipeline keeps itself current',
        'title'      => '<span class="g">Selling is human.</span> The admin around it does not have to be.',
        'lead'       => 'Automated & Dynamic Sales takes the manual work out of the revenue process: a CRM that updates itself, guided next steps with the reasoning shown, quoting and pricing under governed rules, and forecasts built on evidence rather than optimism.',
        'meta'       => ['8–14 weeks per phase', 'CRM · CPQ · commerce', 'Representatives approve what customers see'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical phase', 'Scope', 'Standard'],
        'cta'        => 'Start a sales automation brief',
        'icon'       => 'handshake',
        'offer_title'=> '<span class="g">Automate the process,</span> never the relationship',
        'offer_lead' => 'Systems handle capture, assembly and analysis. People keep the conversation, the promise and the price.',
        'offer' => [
            ['CRM automation & data hygiene', 'Activity captured automatically, duplicates prevented, stage rules enforced and fields asked for at the moment they are known rather than at quarter end.', 'Self-maintaining CRM', 'sync'],
            ['Guided selling & next best action','Playbooks in the CRM that suggest the next step, flag stalled and at-risk deals, and always show why, so a representative can disagree with reason.', 'Playbooks · risk flags', 'compass'],
            ['Dynamic pricing & quoting',     'Configure, price and quote flows with rule-based pricing, discount thresholds, approval chains and quote-to-cash integration, including tokenised payment links.', 'CPQ · approvals', 'cost'],
            ['Proposal & follow-up generation','Proposals, recaps and follow-ups drafted from CRM data and approved content in the brand voice, reviewed and sent by the person who owns the relationship.', 'Drafted · reviewed · sent', 'doc'],
            ['Conversation intelligence',     'Calls and meetings transcribed with consent, objections and commitments extracted, CRM notes written back and coaching themes surfaced for the team.', 'Consented · coached', 'voice'],
            ['Forecasting & pipeline analytics','Stage conversion, deal ageing, coverage and hygiene combined into a model-assisted forecast, with the assumptions and the misses both visible.', 'Forecast · coverage', 'chart'],
        ],
        'process' => [
            'title' => '<span class="g">Fix the process,</span> then automate it',
            'lead'  => 'Automating a process nobody agrees on multiplies the disagreement. The stages and definitions come first.',
            'steps' => [
                ['Map',      'Wk 01–03', 'Sales process, stages, exit criteria, systems and handoffs mapped with the people who sell. The definitions everyone will be measured on are agreed.', ['Process map', 'Stage definitions', 'System inventory']],
                ['Automate', 'Wk 03–08', 'CRM configured, activity capture and hygiene rules built, integrations to marketing, finance and support connected, and reporting rebuilt on the new definitions.', ['CRM build', 'Integrations', 'Hygiene rules']],
                ['Assist',   'Wk 07–12', 'Guided selling, quoting, proposal drafting and conversation intelligence introduced with the team, adopted one workflow at a time.', ['Playbooks', 'CPQ flows', 'Assistant rollout']],
                ['Forecast', 'Wk 12–14', 'Forecast model calibrated against history, reviewed weekly with the sales leadership, and corrected as the process changes.', ['Forecast model', 'Weekly review pack', 'Adoption report']],
            ],
        ],
        'deliver' => [
            ['Sales process map & stage definitions',  'Diagram · doc'],
            ['Configured CRM & automation rules',      'Platform build'],
            ['Guided selling playbooks',               'CRM content'],
            ['Quoting, pricing & approval workflow',   'CPQ config'],
            ['Proposal & follow-up templates',         'Templates'],
            ['Conversation intelligence set-up',       'Config · consent flow'],
            ['Forecast model & pipeline dashboards',   'Model · dashboard'],
        ],
        'outcomes' => [
            ['Hours returned to selling',   'Logging, chasing and assembling handled by the system, so the working day goes back to customers.'],
            ['A pipeline you can believe',  'Stage rules and automatic capture keep the CRM current, which is the only thing that makes a forecast worth reading.'],
            ['Pricing under control',       'Discounts, approvals and margin rules enforced in the flow instead of discovered in the quarterly review.'],
        ],
        'faq' => [
            ['Are you automating salespeople out of the job?', 'No. We automate capture, assembly, analysis and chasing. Discovery, negotiation, judgement and the relationship stay with people, and the point of the work is to give them more time for exactly that.'],
            ['Is dynamic pricing fair to customers?', 'It has to be, and it has to be legal. We implement rule-based pricing by segment, volume, term and cost to serve, with the logic documented and auditable. We do not implement pricing that varies by an individual’s personal characteristics or inferred willingness to pay.'],
            ['Do we need to record calls?', 'Only with consent, and only where it is lawful in that market. Consent is captured in the call flow or the meeting invitation, retention is limited, and any participant can decline without losing the meeting.'],
            ['Which CRMs do you work in?', 'Most often Salesforce, HubSpot and Zoho. Where a custom platform makes more sense, our Technology & Intelligence team builds it, and this work runs on top of it either way.'],
            ['Will the forecast replace the sales leader’s judgement?', 'No. The model gives a range with its assumptions and its historic error. The commit stays a human decision, and the value is that the conversation starts from evidence instead of a spreadsheet of hopes.'],
        ],
        'pairs'     => ['ai-lead-generation', 'customer-relationship-strategy'],
        'img'       => ['src' => 'assets/imgs/martech/shared/automated-dynamic-sales.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A salesperson takes a video call at a desk with a CRM open on a second screen', 'pos' => '50% 40%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['salesforce', 'hubspot', 'zoho', 'stripe', 'razorpay', 'shopify', 'twilio', 'whatsapp', 'slack', 'microsoftteams', 'googlebigquery', 'python', 'n8n', 'postgresql'],
        'standards' => ['gdpr', 'dpdp', 'iso27701', 'pci-dss', 'nist-ai-rmf', 'eu-ai-act'],
    ],

    'customer-relationship-strategy' => [
        'n'          => '07',
        'slug'       => 'customer-relationship-strategy',
        'name'       => 'Customer Relationship Strategy',
        'short'      => 'Customer Strategy',
        'kicker'     => 'Five practices, one relationship',
        'title'      => '<span class="g">Acquisition buys a customer.</span> The relationship is what you keep.',
        'lead'       => 'Customer Relationship Strategy runs journey mapping, customer segmentation and insights, engagement programmes, loyalty strategy and lifecycle marketing as one practice. They are sold, built and measured together, because a journey map nobody acts on and a loyalty scheme nobody communicates change nothing on their own.',
        'meta'       => ['8–12 weeks to the first programme', 'Journeys · segments · engagement · loyalty · lifecycle', 'Measured on retention and lifetime value'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical first release', 'Scope', 'Standard'],
        'cta'        => 'Start a customer strategy brief',
        'icon'       => 'users',
        'offer_title'=> '<span class="g">Five parts</span> of one customer practice',
        'offer_lead' => 'Read this as one capability with five sections. Each is a discipline in its own right; none of them works alone, which is why we do not sell them apart.',
        'offer' => [
            ['Customer journey mapping',        'Journeys mapped as customers actually experience them, across channels and into service: the moments of truth, the drop-offs, the recovery points, and the instrumentation that keeps the map honest.', 'Journeys · moments of truth', 'compass'],
            ['Segmentation & customer insight', 'Needs-based and behavioural segmentation built from research and your own data, with value tiers, propensity and churn models, and one segment definition every team uses.', 'Segments · propensity · churn', 'users'],
            ['Engagement programmes',           'Always-on programmes for onboarding, adoption, service moments, community and win-back, with a contact strategy per segment and pressure rules across the whole estate.', 'Always-on · per segment', 'chat'],
            ['Loyalty strategy & programmes',   'Loyalty designed on the value customers want, not only on discount: earn and redeem mechanics, tiers, benefits and partners, modelled for margin, breakage and accounting liability before launch.', 'Mechanics · tiers · economics', 'handshake'],
            ['Lifecycle marketing',             'The full calendar of triggered and planned communication by lifecycle stage, from first purchase to renewal, each with an owner, a measure and a holdout group.', 'Stages · triggers · holdouts', 'workflow'],
            ['Customer value measurement',      'Lifetime value, retention cohorts, churn and satisfaction measured against one customer record, with a quarterly operating rhythm that keeps the five parts in step.', 'LTV · cohorts · cadence', 'chart'],
        ],
        'process' => [
            'title' => '<span class="g">Understand, define, design,</span> then run it',
            'lead'  => 'Research and data run together from the first week, so the segments people describe and the segments the data shows are reconciled rather than argued about.',
            'steps' => [
                ['Understand', 'Wk 01–04', 'Customer interviews, service and sales conversations, transaction and behavioural data, and the moments where customers leave. Research and analysis in parallel.', ['Customer research', 'Data & churn analysis', 'Current journey map']],
                ['Define',     'Wk 04–07', 'Segments built, sized and named, journeys mapped per segment, value and churn models fitted, and the measures that will be reported agreed with leadership.', ['Segmentation model', 'Journey maps', 'Value & churn models']],
                ['Design',     'Wk 06–11', 'Engagement programmes, loyalty mechanics and the lifecycle calendar designed together, tested against margin and capacity, and prioritised into a release order.', ['Contact strategy', 'Loyalty design & economics', 'Lifecycle calendar']],
                ['Run',        'Wk 11–12', 'The first programmes launched with holdouts, an owner per stage, and a quarterly review of retention, lifetime value and programme cost.', ['Live programmes', 'Retention dashboard', 'Quarterly operating rhythm']],
            ],
        ],
        'deliver' => [
            ['Customer journey maps by segment',        'Figma · PDF'],
            ['Segmentation model & definitions',        'Model · sheet'],
            ['Propensity, churn & lifetime value models','Model · model card'],
            ['Contact strategy & pressure rules',       'Doc · config'],
            ['Engagement programme designs',            'Blueprints'],
            ['Loyalty programme design & economic model','Design · model'],
            ['Lifecycle calendar with triggers & owners','Board · sheet'],
            ['Retention & lifetime value dashboard',    'Dashboard'],
        ],
        'outcomes' => [
            ['One view of the customer',       'Research, data, journeys and programmes describe the same customer, so teams stop optimising against different definitions.'],
            ['Retention treated as a programme','Named owners, a calendar and a measure per stage, instead of a win-back email sent when the quarter looks thin.'],
            ['Loyalty that earns its cost',    'Mechanics modelled for margin, breakage and liability before launch, so the programme is defensible to finance as well as to marketing.'],
        ],
        'faq' => [
            ['Is this one service or five?', 'One. Journey mapping, segmentation and insights, engagement programmes, loyalty and lifecycle marketing are the five parts of a single practice, delivered by one team on one plan. You can start with one part — most clients start with journeys and segmentation — but they are designed to connect, and we will always say where the next part is needed.'],
            ['Do we need a points programme to have loyalty?', 'No. Points are one mechanic among many, and often the most expensive. Recognition, access, service levels, community and useful benefits frequently retain better at lower cost. We model several mechanics against your margin before recommending one.'],
            ['How long before retention moves?', 'Early programmes such as onboarding and win-back can show measurable effect within one or two purchase cycles. Segmentation and loyalty changes compound over several quarters, so we set cohort-based measures rather than a monthly number that will mislead you.'],   // PLACEHOLDER: confirm timeframe guidance before launch
            ['How do you prove any of it worked?', 'With holdout groups on every programme, cohort retention curves, and lifetime value measured against a pre-programme baseline. Programmes that cannot show incremental effect are changed or stopped.'],
            ['What data do you need to start?', 'Consented first-party data: transactions, contact history, service interactions and any research you already have. Where the data is thin we start with research and a simple value-based segmentation, and the model improves as the data accumulates.'],
        ],
        'pairs'     => ['ai-driven-marketing-automation', 'ai-campaign-optimization'],
        'img'       => ['src' => 'assets/imgs/martech/shared/customer-relationship-strategy.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A team maps a customer journey with notes and printed charts across a long table', 'pos' => '50% 45%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['hubspot', 'salesforce', 'zoho', 'twilio', 'whatsapp', 'googleanalytics', 'mixpanel', 'posthog', 'snowflake', 'googlebigquery', 'dbt', 'looker', 'python', 'miro'],
        'standards' => ['gdpr', 'dpdp', 'iso27701', 'wcag22', 'nist-ai-rmf'],
    ],
];
