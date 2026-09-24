<?php
/**
 * Campaign & Content Design — the service catalogue.
 *
 * What a visitor can actually buy on the discipline hub and on each of the eight capability pages,
 * grouped into categories and offered in engagement packages. One shared component renders this
 * data identically on every page. Clicking a service opens the contact page with it pre-selected,
 * so every enquiry arrives tagged.
 *
 * Shape
 *   '<page-key>' => [
 *     'discipline' => 'campaign-content',
 *     'title'      => heading HTML: <span class="g">grey first phrase.</span> ink rest
 *     'lead'       => intro paragraph
 *     'categories' => [[
 *         'key', 'name', 'icon' (an svc_icon name, partials/services/lib.php — it falls back to xt_icon),
 *         'offers' => [[
 *             'key'       offer key, unique within the page
 *             'name'      service name
 *             'desc'      one or two plain-English sentences
 *             'includes'  3–5 concrete inclusions
 *             'tags'      short labels
 *             'stack'     platform slugs from data/tech-stack.php (omitted for advisory or production work)
 *             'time'      typical timeline (PLACEHOLDER until confirmed)
 *             'best'      who it suits
 *         ]],
 *     ]],
 *     'packages'   => keys from data/services/packages.php that apply, in display order
 *   ]
 *
 * Page keys: 'campaign-content' (the hub), then the eight capability slugs in site order.
 * Service id, the tag the contact page receives: '<page-key>:<offer-key>'.
 * Hub offers also carry 'cap': the capability slug the service belongs to.
 *
 * Packages: sprint (1–3 week fixed-scope sprint), project (fixed scope, fixed price), milestone
 * (gated, separately paid phases), retainer (monthly capacity with service levels), enterprise
 * (multi-workstream programme with governance), squad (dedicated team, time & materials).
 *
 * Truthfulness: no prices, client names, results, guarantees of coverage or ranking, certifications
 * or partner tiers. Platforms named are ones we work in, never partnerships. Advertising, disclosure
 * and privacy codes are described as obligations we work to, never as accreditations we hold.
 * Every 'time' is typical, not promised, and is marked PLACEHOLDER until confirmed.
 *
 * Voice: plain English first, precise second. Calm, short, active. No exclamation marks.
 */

return [

    /* =============================================================================================
       Hub — the services people most often start with, across all eight capabilities
       ============================================================================================= */
    'campaign-content' => [
        'discipline' => 'campaign-content',
        'title'      => '<span class="g">Start with one campaign.</span> Build the system behind it.',
        'lead'       => 'These are the services clients most often start with, across all eight campaign and content capabilities. Choose one and your enquiry reaches the right team with it already attached. Each can be bought as a short sprint, a fixed-scope project, or ongoing monthly capacity.',
        'categories' => [

            ['key' => 'plan', 'name' => 'Plan', 'icon' => 'compass', 'offers' => [
                [
                    'key'      => 'omnichannel-strategy',
                    'cap'      => 'omnichannel-marketing-strategy',
                    'name'     => 'Omnichannel marketing strategy',
                    'desc'     => 'One plan that decides who to reach, which channels do which job, how the budget is split and how you will know it worked.',
                    'includes' => ['Audience and demand analysis from your own data', 'Channel architecture with a job per channel', 'Budget allocation model with scenarios', '12-month plan with owners, dates and measures'],
                    'tags'     => ['Annual plan', 'Budget model', 'Measurement'],
                    'stack'    => ['googleanalytics', 'hubspot', 'looker', 'miro'],
                    'time'     => '6–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing leaders planning a year, or defending a budget.',
                ],
                [
                    'key'      => 'campaign-platform',
                    'cap'      => 'campaign-design-systems',
                    'name'     => 'Campaign platform & big idea',
                    'desc'     => 'The idea a campaign is built on, with the line, the look and the rules that let it run for a season without falling apart.',
                    'includes' => ['Campaign brief and audience definition', 'Two or three platforms shown on real placements', 'Chosen idea with line and art direction', 'What the campaign is, and what it is not'],
                    'tags'     => ['Big idea', 'Art direction'],
                    'stack'    => ['figma', 'miro'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands with a launch, a season or a category moment ahead.',
                ],
                [
                    'key'      => 'content-strategy',
                    'cap'      => 'content-marketing',
                    'name'     => 'Content strategy & editorial plan',
                    'desc'     => 'A content plan built from what your customers search for and ask, organised into clusters, with briefs your experts can answer.',
                    'includes' => ['Demand, sales and support question research', 'Topic architecture with pillars and clusters', 'Quarterly editorial calendar', 'Brief template and editorial standards'],
                    'tags'     => ['Topic clusters', 'Editorial calendar'],
                    'stack'    => ['semrush', 'ahrefs', 'googlesearchconsole', 'notion'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams publishing steadily without a plan tied to demand.',
                ],
                [
                    'key'      => 'measurement-framework',
                    'cap'      => 'omnichannel-marketing-strategy',
                    'name'     => 'Marketing measurement framework',
                    'desc'     => 'One definition of every marketing metric, the data model behind it, and a dashboard your leadership team can read without a translator.',
                    'includes' => ['Metric definitions agreed with sales and finance', 'Data sources, joins and refresh schedule', 'Executive and operating dashboards', 'Reporting rhythm from weekly to quarterly'],
                    'tags'     => ['One metric layer', 'Dashboards'],
                    'stack'    => ['googleanalytics', 'googlebigquery', 'looker', 'powerbi'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies whose marketing, sales and finance numbers disagree.',
                ],
            ]],

            ['key' => 'earned', 'name' => 'Earned attention', 'icon' => 'megaphone', 'offers' => [
                [
                    'key'      => 'pr-programme',
                    'cap'      => 'public-relations',
                    'name'     => 'PR & media relations programme',
                    'desc'     => 'An ongoing programme to earn coverage in the publications your buyers read, built on a narrative your business can defend.',
                    'includes' => ['Narrative and message house', 'Media and analyst target list', 'Announcements, exclusives and reactive comment', 'Monthly coverage and share-of-voice report'],
                    'tags'     => ['Earned coverage', 'Share of voice'],
                    'time'     => '3-month cycles, ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies that are known by customers but invisible in the press.',
                ],
                [
                    'key'      => 'launch-pr',
                    'cap'      => 'public-relations',
                    'name'     => 'Launch & announcement PR',
                    'desc'     => 'A concentrated push around a product launch, funding round, partnership or milestone, prepared properly and placed with embargo discipline.',
                    'includes' => ['Story angle and press materials', 'Targeted media outreach and briefings', 'Spokesperson preparation', 'Launch-day coordination and coverage report'],
                    'tags'     => ['Launch', 'Funding', 'Milestone'],
                    'time'     => '4–8 weeks around the date',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with one date that has to land well.',
                ],
                [
                    'key'      => 'influencer-activation',
                    'cap'      => 'social-influencer-activation',
                    'name'     => 'Influencer & creator activation',
                    'desc'     => 'Creators chosen on audience evidence, briefed without being scripted, contracted with rights and disclosure settled, and measured for real lift.',
                    'includes' => ['Creator shortlist with audience checks', 'Briefs, contracts and rights matrix', 'Content production and disclosure checks', 'Performance report with an incrementality read'],
                    'tags'     => ['Creators', 'Rights cleared', 'Measured'],
                    'stack'    => ['googleanalytics', 'shopify', 'hubspot'],
                    'time'     => '6–10 weeks per activation',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose customers trust people more than advertising.',
                ],
                [
                    'key'      => 'social-always-on',
                    'cap'      => 'social-media-marketing',
                    'name'     => 'Always-on social media management',
                    'desc'     => 'Your social presence run properly: pillars, native content, a monthly calendar, community management with agreed response times, and honest reporting.',
                    'includes' => ['Channel strategy and content pillars', 'Monthly content production and publishing', 'Community management and escalation', 'Monthly performance report'],
                    'tags'     => ['Always-on', 'Community'],
                    'stack'    => ['figma', 'notion', 'hubspot', 'googleanalytics'],
                    'time'     => '4–6 weeks to launch, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands posting inconsistently with nobody owning the feed.',
                ],
                [
                    'key'      => 'founder-presence',
                    'cap'      => 'social-media-marketing',
                    'name'     => 'Founder & executive presence',
                    'desc'     => 'A publishing habit for the people whose own accounts reach further than the brand page, written with them rather than for them.',
                    'includes' => ['Positioning and topic territory per person', 'Interview-led ghostwriting', 'Publishing cadence and engagement routine', 'Monthly reach and inbound report'],
                    'tags'     => ['Founder-led', 'Ghostwriting'],
                    'stack'    => ['notion', 'openai'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Founders and specialists who are credible but rarely post.',
                ],
            ]],

            ['key' => 'paid', 'name' => 'Paid media', 'icon' => 'trend', 'offers' => [
                [
                    'key'      => 'paid-media',
                    'cap'      => 'performance-marketing',
                    'name'     => 'Paid media management',
                    'desc'     => 'Search, social, retail media and programmatic run in your own accounts, against cost per customer rather than cost per click.',
                    'includes' => ['Account restructure and bidding strategy', 'Weekly optimisation and query hygiene', 'Creative testing calendar', 'Monthly performance and budget review'],
                    'tags'     => ['Search', 'Social', 'Retail media'],
                    'stack'    => ['google', 'googleanalytics', 'googletagmanager', 'shopify'],
                    'time'     => '4–6 weeks to a baseline, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses spending steadily without knowing what the spend adds.',
                ],
                [
                    'key'      => 'tracking-foundation',
                    'cap'      => 'performance-marketing',
                    'name'     => 'Conversion tracking & consent set-up',
                    'desc'     => 'Server-side tracking, conversion APIs and consent handled properly, so your platforms optimise on outcomes that match your finance numbers.',
                    'includes' => ['Measurement plan tied to revenue', 'Server-side tagging and conversion APIs', 'Consent mode and cookie banner integration', 'Offline and CRM conversion imports', 'End-to-end validation'],
                    'tags'     => ['Server-side', 'Consent mode', 'Offline conversions'],
                    'stack'    => ['googletagmanager', 'googleanalytics', 'hubspot', 'salesforce'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers whose reported conversions nobody quite believes.',
                ],
                [
                    'key'      => 'creative-testing',
                    'cap'      => 'performance-marketing',
                    'name'     => 'Performance creative studio',
                    'desc'     => 'A steady supply of ad creative built for the auction: concepts, variants and cut-downs produced weekly and tested against a hypothesis.',
                    'includes' => ['Creative strategy from winning patterns', 'Weekly batches of static and video variants', 'Testing framework with one hypothesis per variant', 'Performance read by concept, not just by ad'],
                    'tags'     => ['Creative volume', 'Testing'],
                    'stack'    => ['figma', 'openai'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers whose results stalled because creative stopped changing.',
                ],
                [
                    'key'      => 'incrementality',
                    'cap'      => 'performance-marketing',
                    'name'     => 'Incrementality & budget allocation',
                    'desc'     => 'Tests that show what your media actually adds, and a budget model that moves spend on that evidence rather than on last-click reports.',
                    'includes' => ['Geo holdout or matched-market test design', 'Test execution and analysis', 'Media-mix read where history allows', 'Budget allocation model with scenarios'],
                    'tags'     => ['Holdout tests', 'Budget model'],
                    'stack'    => ['googlebigquery', 'looker', 'dbt'],
                    'time'     => '6–10 weeks per test cycle',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams asked to prove what the marketing budget returns.',
                ],
            ]],

            ['key' => 'create', 'name' => 'Create', 'icon' => 'layers', 'offers' => [
                [
                    'key'      => 'campaign-system',
                    'cap'      => 'campaign-design-systems',
                    'name'     => 'Campaign design system',
                    'desc'     => 'The framework that keeps one campaign recognisable across every format and market: tokens, master templates, a message matrix and automated checks.',
                    'includes' => ['Art direction and campaign toolkit', 'Master templates and design tokens', 'Message matrix by audience and market', 'Guidelines, asset register and creative checks'],
                    'tags'     => ['Templates', 'Tokens', 'Governance'],
                    'stack'    => ['figma', 'storybook', 'contentful'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands running one campaign across many markets and placements.',
                ],
                [
                    'key'      => 'campaign-production',
                    'cap'      => 'global-content-production',
                    'name'     => 'Campaign film & photography',
                    'desc'     => 'Original photography and film for a campaign, produced end to end, with rights cleared for the markets and media you plan to run in.',
                    'includes' => ['Creative treatment and asset list', 'Casting, locations, crew and shoot', 'Edit, grade, sound and market versions', 'Rights, releases and delivery into your library'],
                    'tags'     => ['Film', 'Photography', 'Rights cleared'],
                    'time'     => '4–8 weeks per production',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Campaigns that need original work rather than stock.',
                ],
                [
                    'key'      => 'content-engine',
                    'cap'      => 'content-marketing',
                    'name'     => 'Content production retainer',
                    'desc'     => 'A monthly output of articles, guides, landing pages and repurposed formats, written with your experts and published to a schedule.',
                    'includes' => ['Agreed monthly output against the calendar', 'Interview-led writing, editing and design', 'Publishing in your CMS with on-page optimisation', 'Repurposing into social and email formats'],
                    'tags'     => ['Monthly output', 'Expert-led'],
                    'stack'    => ['wordpress', 'contentful', 'sanity', 'hubspot'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with a plan and no capacity to produce against it.',
                ],
                [
                    'key'      => 'localisation',
                    'cap'      => 'campaign-design-systems',
                    'name'     => 'Campaign localisation at scale',
                    'desc'     => 'One campaign adapted into every market, language and format, through rules and templates rather than a queue of one-off requests.',
                    'includes' => ['Localisation and adaptation rules', 'Market toolkits and training', 'Automated resizing and versioning pipeline', 'Pre-flight checks against media specifications'],
                    'tags'     => ['Multi-market', 'Automated versioning'],
                    'stack'    => ['figma', 'n8n', 'contentful'],
                    'time'     => '4–8 weeks to set up',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose market teams rebuild the same assets by hand.',
                ],
            ]],

            ['key' => 'run', 'name' => 'Run it with us', 'icon' => 'cycle', 'offers' => [
                [
                    'key'      => 'global-production',
                    'cap'      => 'global-content-production',
                    'name'     => 'Global production network',
                    'desc'     => 'Access to vetted local crews and creators in the markets you sell in, briefed centrally and reviewed against one standard.',
                    'includes' => ['Market coverage plan and crew vetting', 'One brief, one review pipeline', 'Local production management', 'Central rights and delivery records'],
                    'tags'     => ['Multi-market', 'Local crews'],
                    'time'     => 'Ongoing · per production wave',   // PLACEHOLDER: confirm network coverage and terms
                    'best'     => 'Brands producing in several countries with no consistent standard.',
                ],
                [
                    'key'      => 'creator-programme',
                    'cap'      => 'social-influencer-activation',
                    'name'     => 'Always-on creator programme',
                    'desc'     => 'A managed roster of creators working with you all year, instead of a new scramble for names before every campaign.',
                    'includes' => ['Roster built and refreshed on performance', 'Contracts, rights and disclosure management', 'Monthly content and whitelisting', 'Quarterly roster and performance review'],
                    'tags'     => ['Roster', 'Whitelisting'],
                    'stack'    => ['hubspot', 'notion'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands running creator work often enough to need a roster.',
                ],
                [
                    'key'      => 'reporting',
                    'cap'      => 'omnichannel-marketing-strategy',
                    'name'     => 'Marketing reporting & dashboards',
                    'desc'     => 'Every channel in one dashboard, on agreed definitions, refreshed automatically, with a monthly read of what the numbers mean.',
                    'includes' => ['Data pipeline from your channels and CRM', 'Executive and channel dashboards', 'Automated refresh and alerting', 'Monthly commentary and recommendations'],
                    'tags'     => ['Dashboards', 'Monthly read'],
                    'stack'    => ['googlebigquery', 'looker', 'powerbi', 'dbt'],
                    'time'     => '4–6 weeks to build, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams rebuilding the same report by hand every month.',
                ],
                [
                    'key'      => 'campaign-squad',
                    'cap'      => 'content-marketing',
                    'name'     => 'Embedded campaign & content squad',
                    'desc'     => 'A dedicated team — strategist, writer, designer, editor and producer — working inside your tools, rituals and backlog.',
                    'includes' => ['Named specialists matched to your roadmap', 'Your tools, your stand-ups, your approvals', 'Scale the team up or down each month', 'Knowledge transfer built in from week one'],
                    'tags'     => ['Dedicated team', 'Your cadence'],
                    'stack'    => ['notion', 'jira', 'slack', 'figma'],
                    'time'     => 'Ongoing · 3-month minimum',   // PLACEHOLDER: confirm minimum term
                    'best'     => 'In-house teams with more plan than hands.',
                ],
            ]],

        ],
        'packages'   => ['sprint', 'project', 'retainer', 'milestone', 'enterprise', 'squad'],
    ],

    /* =============================================================================================
       01 · Content Marketing
       ============================================================================================= */
    'content-marketing' => [
        'discipline' => 'campaign-content',
        'title'      => '<span class="g">Content with a job to do,</span> published on a schedule.',
        'lead'       => 'We build the editorial system and then run it: demand research, a topic architecture, briefs your experts can answer, production that ships weekly, and reporting that shows which topics create demand.',
        'categories' => [

            ['key' => 'strategy', 'name' => 'Strategy & planning', 'icon' => 'compass', 'offers' => [
                [
                    'key'      => 'content-strategy',
                    'name'     => 'Content strategy & topic architecture',
                    'desc'     => 'A plan built from what your customers search for, ask in sales calls and raise with support, organised into pillars and clusters.',
                    'includes' => ['Search demand and question research', 'Competitor and coverage gap analysis', 'Pillars, clusters and internal linking map', 'Channel and format plan per topic'],
                    'tags'     => ['Topic clusters', 'Demand-led'],
                    'stack'    => ['semrush', 'ahrefs', 'googlesearchconsole'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams publishing without a plan tied to real demand.',
                ],
                [
                    'key'      => 'editorial-calendar',
                    'name'     => 'Editorial calendar & briefs',
                    'desc'     => 'A quarterly calendar where every piece has a brief: the question it answers, the angle, the evidence, the expert and the measure.',
                    'includes' => ['Quarterly calendar with owners and dates', 'Brief template and worked examples', 'Approval route and publishing checklist', 'Capacity plan against your team'],
                    'tags'     => ['Quarterly', 'Briefed'],
                    'stack'    => ['notion', 'jira'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing teams whose calendar is a list of dates and titles.',
                ],
                [
                    'key'      => 'content-audit',
                    'name'     => 'Content audit & refresh plan',
                    'desc'     => 'An inventory of everything you have published with its performance, and a decision per page: keep, update, merge or retire.',
                    'includes' => ['Full inventory with traffic and conversion data', 'Duplication and cannibalisation analysis', 'Keep, update, merge or retire decision per page', 'Redirect plan and prioritised refresh backlog'],
                    'tags'     => ['Inventory', 'Refresh', 'Consolidation'],
                    'stack'    => ['googlesearchconsole', 'googleanalytics', 'semrush'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sites with years of content and declining performance.',
                ],
                [
                    'key'      => 'buyer-questions',
                    'name'     => 'Buyer question & objection research',
                    'desc'     => 'The questions and objections that actually precede a purchase, gathered from sales calls, support tickets, reviews and communities.',
                    'includes' => ['Sales and support interviews', 'Review, forum and community mining', 'Question map by buying stage', 'Content and enablement recommendations'],
                    'tags'     => ['Voice of customer', 'Objections'],
                    'stack'    => ['hubspot', 'zendesk', 'openai'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose content answers questions nobody is asking.',
                ],
            ]],

            ['key' => 'production', 'name' => 'Editorial production', 'icon' => 'doc', 'offers' => [
                [
                    'key'      => 'articles',
                    'name'     => 'Articles, guides & long-form',
                    'desc'     => 'Useful, accurate writing built on interviews with your experts and edited for both search and the person reading it.',
                    'includes' => ['Expert interviews and research', 'Writing, editing and fact checking', 'On-page optimisation and internal links', 'Publishing in your CMS with imagery'],
                    'tags'     => ['Long-form', 'Expert-led'],
                    'stack'    => ['wordpress', 'contentful', 'sanity'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with deep expertise and no time to write it down.',
                ],
                [
                    'key'      => 'thought-leadership',
                    'name'     => 'Thought leadership & bylines',
                    'desc'     => 'Argued pieces under a named expert’s byline, with a point of view sharp enough to be disagreed with.',
                    'includes' => ['Positioning and topic territory per author', 'Interview-led drafting', 'Editing to an argued point of view', 'Placement support for external bylines'],
                    'tags'     => ['Byline', 'Point of view'],
                    'time'     => '2–4 weeks per piece',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Executives who are credible in a room but invisible in print.',
                ],
                [
                    'key'      => 'research-report',
                    'name'     => 'Original research & data reports',
                    'desc'     => 'A survey or data study of your own, turned into a report, a landing page, a press angle and a season of derivative content.',
                    'includes' => ['Research design and questionnaire', 'Fieldwork or data analysis', 'Report, charts and landing page', 'Press angle and derivative content plan'],
                    'tags'     => ['Original data', 'Citable'],
                    'stack'    => ['googlebigquery', 'looker', 'figma'],
                    'time'     => '8–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands that need something journalists and analysts will cite.',
                ],
                [
                    'key'      => 'case-studies',
                    'name'     => 'Customer stories & case studies',
                    'desc'     => 'Evidence written the way buyers read it: the problem, what was done, what changed, and what it cost to get there.',
                    'includes' => ['Customer interviews and approvals', 'Written story in long and short formats', 'Quote, figure and claim verification', 'Design and publishing'],
                    'tags'     => ['Proof', 'Sales enablement'],
                    'time'     => '3–5 weeks per story',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sales teams that keep retelling the same story from memory.',
                ],
                [
                    'key'      => 'landing-pages',
                    'name'     => 'Landing pages & campaign copy',
                    'desc'     => 'Pages that carry a campaign’s message through to a conversion, written and designed against one clear action.',
                    'includes' => ['Message and offer hierarchy', 'Copy, layout and supporting proof', 'Form, tracking and consent set-up', 'Variant plan for testing'],
                    'tags'     => ['Conversion', 'Campaign'],
                    'stack'    => ['webflow', 'wordpress', 'hubspot'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Campaigns sending paid traffic to a page nobody wrote for it.',
                ],
            ]],

            ['key' => 'formats', 'name' => 'Formats & distribution', 'icon' => 'sync', 'offers' => [
                [
                    'key'      => 'newsletter',
                    'name'     => 'Newsletter & email editorial',
                    'desc'     => 'An email people open because it is worth reading, with a format, a cadence and a voice that survive a change of writer.',
                    'includes' => ['Format, cadence and voice definition', 'Written editions on a schedule', 'Segmentation and send strategy', 'Open, click and reply reporting'],
                    'tags'     => ['Newsletter', 'Owned audience'],
                    'stack'    => ['hubspot', 'zoho'],
                    'time'     => '3 weeks to launch, then ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands with a list they rarely earn attention from.',
                ],
                [
                    'key'      => 'video-podcast',
                    'name'     => 'Video & podcast editorial',
                    'desc'     => 'An editorial series in video or audio, planned as a format rather than as occasional episodes, with clips built into the plan.',
                    'includes' => ['Format design and episode architecture', 'Guest or topic pipeline', 'Production, edit and clip package', 'Distribution plan per platform'],
                    'tags'     => ['Series', 'Clips included'],
                    'time'     => '6–10 weeks to launch a series',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose audience would rather watch or listen than read.',
                ],
                [
                    'key'      => 'repurposing',
                    'name'     => 'Repurposing & content atomisation',
                    'desc'     => 'One substantial piece turned into the social, email and sales formats it should have produced in the first place.',
                    'includes' => ['Atomisation plan per flagship piece', 'Social cut-downs and carousels', 'Email and sales versions', 'Publishing calendar for the derivatives'],
                    'tags'     => ['One piece, many formats'],
                    'stack'    => ['figma', 'openai'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose best work is published once and forgotten.',
                ],
                [
                    'key'      => 'sales-enablement',
                    'name'     => 'Sales enablement content',
                    'desc'     => 'The decks, one-pagers, comparison pages and objection responses your sales team actually needs, written from real calls.',
                    'includes' => ['Sales call review and gap analysis', 'Pitch narrative and deck', 'One-pagers, comparisons and FAQs', 'Enablement session with the team'],
                    'tags'     => ['Sales', 'Objections'],
                    'stack'    => ['hubspot', 'salesforce', 'figma'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sales teams building their own slides the night before.',
                ],
            ]],

            ['key' => 'operations', 'name' => 'Content operations', 'icon' => 'cycle', 'offers' => [
                [
                    'key'      => 'content-ops',
                    'name'     => 'Content operations & governance',
                    'desc'     => 'The workflow behind publishing: who briefs, who writes, who approves, where assets live and how quality stays consistent.',
                    'includes' => ['Workflow design and roles', 'Editorial standards and style guide', 'Approval routes and legal review path', 'Asset library structure and naming'],
                    'tags'     => ['Workflow', 'Standards'],
                    'stack'    => ['notion', 'jira', 'contentful'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams where every piece takes a different route to publication.',
                ],
                [
                    'key'      => 'ai-content-workflow',
                    'name'     => 'AI-assisted content workflow',
                    'desc'     => 'AI built into the editorial process where it saves real time — research, outlines, variants, metadata, translation drafts — with a person approving every publication.',
                    'includes' => ['Use-case map with what AI will and will not do', 'Prompt and brief templates in your voice', 'Review, approval and disclosure rules', 'Quality checks and a sample audit'],
                    'tags'     => ['AI-assisted', 'Human approval'],
                    'stack'    => ['openai', 'anthropic', 'n8n', 'notion'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Content teams using AI informally, with no standard or review.',
                ],
                [
                    'key'      => 'content-measurement',
                    'name'     => 'Content performance measurement',
                    'desc'     => 'Reporting that shows which topics and formats create demand, not just which pages got traffic.',
                    'includes' => ['Content-to-pipeline data model', 'Dashboard by topic, format and stage', 'Refresh and retirement triggers', 'Monthly commentary'],
                    'tags'     => ['Topic-level', 'Pipeline'],
                    'stack'    => ['googleanalytics', 'hubspot', 'looker', 'posthog'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams reporting page views to a board that asks about revenue.',
                ],
            ]],

        ],
        'packages'   => ['retainer', 'project', 'sprint', 'squad'],
    ],

    /* =============================================================================================
       02 · Social Media Marketing
       ============================================================================================= */
    'social-media-marketing' => [
        'discipline' => 'campaign-content',
        'title'      => '<span class="g">A feed worth following,</span> run like a service.',
        'lead'       => 'Strategy, native content, community management and reporting for the platforms that matter to your buyers. Built per platform, published on a calendar, answered within agreed times, and measured against the business rather than the feed.',
        'categories' => [

            ['key' => 'strategy', 'name' => 'Strategy & set-up', 'icon' => 'compass', 'offers' => [
                [
                    'key'      => 'channel-strategy',
                    'name'     => 'Social channel strategy',
                    'desc'     => 'Which platforms earn your time, what each one is for, and the cadence, format mix and measure that fit each audience.',
                    'includes' => ['Account, audience and competitor audit', 'Platform selection with a role for each', 'Cadence and format mix', 'Benchmarks and success measures'],
                    'tags'     => ['Per platform', 'Audit-led'],
                    'stack'    => ['semrush', 'googleanalytics'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands active on six platforms and effective on none.',
                ],
                [
                    'key'      => 'content-pillars',
                    'name'     => 'Content pillars & format system',
                    'desc'     => 'Three to five recurring pillars with defined formats, so the feed is recognisable and the calendar is not written from scratch each month.',
                    'includes' => ['Pillar definition with example posts', 'Format templates per platform', 'Hook, caption and alt-text patterns', 'Monthly mix and cadence rules'],
                    'tags'     => ['Pillars', 'Templates'],
                    'stack'    => ['figma', 'notion'],
                    'time'     => '3–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams starting each month with an empty calendar.',
                ],
                [
                    'key'      => 'tone-moderation',
                    'name'     => 'Tone, moderation & escalation guide',
                    'desc'     => 'How the brand speaks, what it replies to, what it ignores, and exactly who is called when a comment becomes a problem.',
                    'includes' => ['Tone guide with worked replies', 'Moderation rules and hidden-word lists', 'Escalation matrix with named owners', 'Crisis and sensitive-topic protocol'],
                    'tags'     => ['Tone', 'Moderation', 'Escalation'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands where nobody is sure who answers a difficult comment.',
                ],
                [
                    'key'      => 'platform-launch',
                    'name'     => 'New platform launch',
                    'desc'     => 'Entering a platform properly: profile, positioning, a first content batch and a ninety-day plan built on how that platform actually works.',
                    'includes' => ['Platform research and audience read', 'Profile and positioning set-up', 'Launch content batch', '90-day plan with review points'],
                    'tags'     => ['New channel', '90-day plan'],
                    'stack'    => ['figma'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose audience has moved somewhere they are not.',
                ],
            ]],

            ['key' => 'content', 'name' => 'Content production', 'icon' => 'images', 'offers' => [
                [
                    'key'      => 'social-content',
                    'name'     => 'Monthly social content production',
                    'desc'     => 'An agreed monthly output of posts designed for each feed, delivered, scheduled and published against the calendar.',
                    'includes' => ['Monthly calendar and concepts', 'Design, copy and alt text', 'Scheduling and publishing', 'A reactive slot each week'],
                    'tags'     => ['Monthly output', 'Native formats'],
                    'stack'    => ['figma', 'notion'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose posting stops whenever the team gets busy.',
                ],
                [
                    'key'      => 'short-video',
                    'name'     => 'Short-form video production',
                    'desc'     => 'Vertical video made for the platforms that reward it, shot in batches and edited with hooks, captions and platform-native pacing.',
                    'includes' => ['Concept and hook development', 'Batch shoot days or remote capture', 'Edit with captions and sound design', 'Versions per platform and aspect ratio'],
                    'tags'     => ['Vertical video', 'Batched'],
                    'time'     => 'Ongoing · batch shoots',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands that know short video works but cannot sustain it.',
                ],
                [
                    'key'      => 'social-templates',
                    'name'     => 'Social template kit',
                    'desc'     => 'A Figma kit of sized, on-brand templates with rules for type, colour, safe areas and captions, so anyone can produce a correct post.',
                    'includes' => ['Templates for every format you use', 'Type, colour and safe-area rules', 'Caption and alt-text guidance', 'Handover session for your team'],
                    'tags'     => ['Figma kit', 'Self-serve'],
                    'stack'    => ['figma'],
                    'time'     => '3–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'In-house teams rebuilding the same layouts every week.',
                ],
                [
                    'key'      => 'regional-social',
                    'name'     => 'Regional & language accounts',
                    'desc'     => 'Market accounts that read as local without drifting from the brand, through shared pillars, local production and clear adaptation rules.',
                    'includes' => ['Account structure per market or language', 'Adaptation rules and approval route', 'Local content production or review', 'Consolidated reporting across markets'],
                    'tags'     => ['Multi-market', 'Localised'],
                    'time'     => '4–8 weeks to set up',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose market teams post in isolation.',
                ],
            ]],

            ['key' => 'community', 'name' => 'Community & people', 'icon' => 'users', 'offers' => [
                [
                    'key'      => 'community-management',
                    'name'     => 'Community management',
                    'desc'     => 'Daily moderation, replies and escalation against agreed response times, in the brand’s voice, with a clear route for anything sensitive.',
                    'includes' => ['Daily monitoring and replies', 'Moderation against agreed rules', 'Escalation to support, legal or leadership', 'Weekly themes and monthly report'],
                    'tags'     => ['Daily', 'Agreed response times'],
                    'stack'    => ['slack', 'zendesk', 'whatsapp'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: confirm coverage hours and response targets
                    'best'     => 'Brands with more comments than anyone has time to answer.',
                ],
                [
                    'key'      => 'social-customer-care',
                    'name'     => 'Social customer care triage',
                    'desc'     => 'A working path from a public complaint to a resolved ticket, with the handover, tone and timing agreed with your support team.',
                    'includes' => ['Triage rules and severity levels', 'Integration with your helpdesk', 'Response templates and tone', 'Resolution and response-time reporting'],
                    'tags'     => ['Support', 'Triage'],
                    'stack'    => ['zendesk', 'intercom', 'hubspot'],
                    'time'     => '3–5 weeks to set up',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands where complaints sit in a feed nobody owns.',
                ],
                [
                    'key'      => 'founder-ghostwriting',
                    'name'     => 'Founder & executive ghostwriting',
                    'desc'     => 'A publishing habit for leaders, written from interviews so the posts sound like them rather than like marketing.',
                    'includes' => ['Topic territory and positioning', 'Weekly interview-led drafts', 'Publishing and engagement routine', 'Monthly reach and inbound report'],
                    'tags'     => ['Founder-led', 'Interview-led'],
                    'stack'    => ['notion', 'openai'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leaders with a point of view and no time to write it.',
                ],
                [
                    'key'      => 'employee-advocacy',
                    'name'     => 'Employee advocacy programme',
                    'desc'     => 'A programme that makes it easy and safe for employees to post, with content they can use and rules they can follow.',
                    'includes' => ['Policy and guidance written with HR and legal', 'Ready-to-post content library', 'Onboarding and training sessions', 'Participation and reach reporting'],
                    'tags'     => ['Advocacy', 'Policy'],
                    'stack'    => ['slack', 'microsoftteams', 'notion'],
                    'time'     => '4–6 weeks to launch',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies whose people would share more if it were easier.',
                ],
            ]],

            ['key' => 'measure', 'name' => 'Listening & measurement', 'icon' => 'chart', 'offers' => [
                [
                    'key'      => 'social-listening',
                    'name'     => 'Social listening & sentiment',
                    'desc'     => 'Structured monitoring of what is said about your brand and category, with alerts for the conversations worth reacting to.',
                    'includes' => ['Query and topic set-up', 'Sentiment and theme analysis', 'Alerting for spikes and issues', 'Monthly insight summary'],
                    'tags'     => ['Listening', 'Alerts'],
                    'stack'    => ['semrush', 'slack'],
                    'time'     => '2–4 weeks to set up, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands that hear about issues after they have spread.',
                ],
                [
                    'key'      => 'social-reporting',
                    'name'     => 'Social reporting & dashboard',
                    'desc'     => 'One dashboard across your platforms, with definitions agreed up front and monthly commentary that says what to do next.',
                    'includes' => ['Metric definitions and benchmarks', 'Automated dashboard across platforms', 'Branded search and site correlation', 'Monthly commentary'],
                    'tags'     => ['Dashboard', 'Monthly'],
                    'stack'    => ['looker', 'googleanalytics', 'powerbi'],
                    'time'     => '3–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams pasting platform screenshots into a monthly deck.',
                ],
                [
                    'key'      => 'competitor-benchmark',
                    'name'     => 'Competitor social benchmark',
                    'desc'     => 'A read on what your competitors publish, what works for them, and where the format or topic gap is.',
                    'includes' => ['Competitor set and content analysis', 'Format and cadence comparison', 'Engagement benchmark', 'Opportunity list'],
                    'tags'     => ['Benchmark', 'Gap analysis'],
                    'stack'    => ['semrush'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams unsure whether their numbers are good or ordinary.',
                ],
                [
                    'key'      => 'social-audit',
                    'name'     => 'Social media audit',
                    'desc'     => 'An independent read on your accounts, content and community management, with a ranked list of what to fix first.',
                    'includes' => ['Account and profile review', 'Content performance analysis', 'Community and response-time review', 'Ranked 90-day fix list'],
                    'tags'     => ['Audit', '90-day plan'],
                    'stack'    => ['googleanalytics', 'semrush'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams inheriting accounts and needing a clear starting point.',
                ],
            ]],

        ],
        'packages'   => ['retainer', 'sprint', 'project'],
    ],

    /* =============================================================================================
       03 · Public Relations
       ============================================================================================= */
    'public-relations' => [
        'discipline' => 'campaign-content',
        'title'      => '<span class="g">Earn the coverage,</span> then prove it landed.',
        'lead'       => 'Media and analyst relations, executive visibility, a newsroom worth quoting, and crisis readiness. We commit to the narrative, the evidence, the relationships and the measurement — never to a guaranteed placement.',
        'categories' => [

            ['key' => 'positioning', 'name' => 'Narrative & preparation', 'icon' => 'doc', 'offers' => [
                [
                    'key'      => 'narrative-messaging',
                    'name'     => 'Narrative & message house',
                    'desc'     => 'The story the business can defend, with the proof behind each claim and the questions that follow it.',
                    'includes' => ['Leadership and customer interviews', 'Narrative in three lengths', 'Message house by audience', 'Claims and evidence review with legal'],
                    'tags'     => ['Narrative', 'Proof points'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies that describe themselves differently in every room.',
                ],
                [
                    'key'      => 'press-kit',
                    'name'     => 'Press kit & newsroom',
                    'desc'     => 'A newsroom and press kit journalists can use without emailing you: facts, figures, images, bios and boilerplate, all current.',
                    'includes' => ['Newsroom pages in your CMS', 'Fact sheet, boilerplate and bios', 'Approved imagery and logo pack', 'Structured data so the facts are machine-readable'],
                    'tags'     => ['Newsroom', 'Press kit'],
                    'stack'    => ['wordpress', 'contentful', 'schemaorg'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies whose press page is a list of old releases.',
                ],
                [
                    'key'      => 'media-training',
                    'name'     => 'Media training & spokesperson prep',
                    'desc'     => 'Practice under realistic pressure: the questions that will be asked, the ones that should not be answered, and how to bridge between them.',
                    'includes' => ['Message and bridging practice', 'Recorded mock interviews with feedback', 'Hostile and technical question drills', 'Personal briefing notes per spokesperson'],
                    'tags'     => ['Training', 'Recorded practice'],
                    'time'     => '1–2 days, plus preparation',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Executives about to face press, analysts or a stage.',
                ],
                [
                    'key'      => 'story-mining',
                    'name'     => 'Story mining & angle development',
                    'desc'     => 'Finding the stories already inside the business — data, decisions, customers, people — and turning them into angles a journalist would run.',
                    'includes' => ['Internal interviews across teams', 'Data and proprietary insight review', 'Angle bank with target publications', 'Editorial calendar of announcements'],
                    'tags'     => ['Angles', 'Announcement calendar'],
                    'time'     => '3–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies convinced they have nothing to announce.',
                ],
            ]],

            ['key' => 'earned', 'name' => 'Earned media', 'icon' => 'megaphone', 'offers' => [
                [
                    'key'      => 'media-relations',
                    'name'     => 'Ongoing media relations',
                    'desc'     => 'A sustained programme of briefings, exclusives, commentary and relationship building with the reporters who cover your category.',
                    'includes' => ['Target media list and beat mapping', 'Monthly angles and pitching', 'Briefings, exclusives and interviews', 'Monthly coverage and share-of-voice report'],
                    'tags'     => ['Ongoing', 'Relationships'],
                    'time'     => '3-month cycles, ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies that want to be a source, not just a press release.',
                ],
                [
                    'key'      => 'launch-pr',
                    'name'     => 'Launch & announcement PR',
                    'desc'     => 'A concentrated push around a launch, funding round, partnership or milestone, with materials prepared and embargoes handled properly.',
                    'includes' => ['Announcement strategy and timing', 'Press materials and assets', 'Targeted outreach and embargo management', 'Launch-day coordination and coverage report'],
                    'tags'     => ['Launch', 'Embargo'],
                    'time'     => '4–8 weeks around the date',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with a single date that has to land well.',
                ],
                [
                    'key'      => 'digital-pr',
                    'name'     => 'Digital PR & data stories',
                    'desc'     => 'Stories built on original data, designed to earn coverage and citations from trusted sources that also strengthen search visibility.',
                    'includes' => ['Data story design and analysis', 'Report, visuals and landing page', 'Outreach to relevant publications', 'Citation and link tracking'],
                    'tags'     => ['Data-led', 'Citations'],
                    'stack'    => ['ahrefs', 'semrush', 'figma'],
                    'time'     => '6–10 weeks per campaign',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands in competitive categories that need authority, not just noise.',
                ],
                [
                    'key'      => 'byline-programme',
                    'name'     => 'Byline & commentary programme',
                    'desc'     => 'A steady flow of contributed articles and expert comment that puts your named people in the publications your buyers read.',
                    'includes' => ['Author positioning and topic territory', 'Ghostwritten bylines to publication briefs', 'Reactive comment on breaking stories', 'Placement tracking'],
                    'tags'     => ['Bylines', 'Reactive comment'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Experts who are quotable but never quoted.',
                ],
            ]],

            ['key' => 'authority', 'name' => 'Authority & recognition', 'icon' => 'clipboard-check', 'offers' => [
                [
                    'key'      => 'analyst-relations',
                    'name'     => 'Analyst & industry relations',
                    'desc'     => 'A structured programme with the analysts and industry bodies whose opinion your buyers check before they shortlist you.',
                    'includes' => ['Analyst mapping and briefing plan', 'Briefing decks and evidence packs', 'Questionnaire and survey responses', 'Follow-up and relationship cadence'],
                    'tags'     => ['Analysts', 'Briefings'],
                    'time'     => 'Ongoing · quarterly cycles',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'B2B companies in categories where analysts shape shortlists.',
                ],
                [
                    'key'      => 'awards',
                    'name'     => 'Awards & rankings programme',
                    'desc'     => 'A calendar of the awards and rankings worth entering, with submissions written to the criteria rather than to the brand deck.',
                    'includes' => ['Award and ranking shortlist with deadlines', 'Entry writing against published criteria', 'Evidence and reference gathering', 'Results tracking and reuse plan'],
                    'tags'     => ['Awards', 'Rankings'],
                    'time'     => 'Ongoing · by deadline calendar',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies entering awards late and losing on the writing.',
                ],
                [
                    'key'      => 'speaking',
                    'name'     => 'Speaking & event programme',
                    'desc'     => 'Getting your experts onto the right stages and podcasts, with proposals written to what programme committees actually select.',
                    'includes' => ['Event and podcast target list', 'Speaker proposals and abstracts', 'Talk development and rehearsal', 'Content reuse from each appearance'],
                    'tags'     => ['Stages', 'Podcasts'],
                    'time'     => 'Ongoing · by event calendar',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Experts whose talks would travel if anyone booked them.',
                ],
                [
                    'key'      => 'citation-ready',
                    'name'     => 'Citation-ready newsroom content',
                    'desc'     => 'Facts, figures and positions structured so journalists quote them correctly and AI answer engines attribute them to you.',
                    'includes' => ['Fact and figure pages with sources', 'Structured data for organisation and people', 'Consistent entity facts across the web', 'Monitoring of how you are described'],
                    'tags'     => ['Quotable', 'Entities'],
                    'stack'    => ['schemaorg', 'perplexity', 'openai', 'googlegemini'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands described inaccurately by journalists and assistants alike.',
                ],
            ]],

            ['key' => 'risk', 'name' => 'Reputation & risk', 'icon' => 'shield', 'offers' => [
                [
                    'key'      => 'crisis-readiness',
                    'name'     => 'Crisis & issues readiness',
                    'desc'     => 'The scenarios, statements, escalation tree and rehearsal that make a bad week survivable, prepared while everything is calm.',
                    'includes' => ['Scenario mapping and risk register', 'Holding statements and Q&A per scenario', 'Escalation tree with named owners', 'Tabletop rehearsal with your leadership'],
                    'tags'     => ['Playbook', 'Rehearsed'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams who have never rehearsed a bad day.',
                ],
                [
                    'key'      => 'issues-monitoring',
                    'name'     => 'Issues monitoring & early warning',
                    'desc'     => 'Monitoring across media, social and review platforms with agreed thresholds, so an issue reaches you before it reaches a journalist.',
                    'includes' => ['Monitoring set-up across channels', 'Severity thresholds and alert routing', 'Daily or weekly issue summary', 'Escalation support when thresholds trip'],
                    'tags'     => ['Monitoring', 'Alerts'],
                    'stack'    => ['slack', 'semrush'],
                    'time'     => '2–4 weeks to set up, then ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands that learn about problems from a reporter’s email.',
                ],
                [
                    'key'      => 'reputation-repair',
                    'name'     => 'Reputation & search result repair',
                    'desc'     => 'A structured response to outdated or damaging results about your brand: correct the record, publish better sources, and monitor what changes.',
                    'includes' => ['Audit of search and answer-engine results', 'Correction and right-of-reply approach', 'Authoritative content and entity fixes', 'Monitoring against a baseline'],
                    'tags'     => ['Search results', 'Corrections'],
                    'stack'    => ['googlesearchconsole', 'semrush', 'perplexity'],
                    'time'     => '6–12 weeks, then monitoring',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose first page of results no longer reflects reality.',
                ],
                [
                    'key'      => 'internal-comms',
                    'name'     => 'Internal & employee communications',
                    'desc'     => 'What employees hear, and when, during a launch, a restructure or an incident — written before the external statement, not after.',
                    'includes' => ['Internal narrative and key messages', 'Manager briefing packs and FAQs', 'Channel and timing plan', 'Feedback and sentiment loop'],
                    'tags'     => ['Internal', 'Change'],
                    'stack'    => ['slack', 'microsoftteams', 'confluence'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies where staff learn the news from the press.',
                ],
            ]],

        ],
        'packages'   => ['retainer', 'project', 'sprint', 'enterprise'],
    ],

    /* =============================================================================================
       04 · Social & Influencer Activation
       ============================================================================================= */
    'social-influencer-activation' => [
        'discipline' => 'campaign-content',
        'title'      => '<span class="g">Creators chosen on evidence,</span> contracted properly, measured honestly.',
        'lead'       => 'Activations inside conversations that already exist: creator selection on audience data, briefs that leave room for their voice, contracts covering rights and disclosure, and measurement that separates paid reach from real lift.',
        'categories' => [

            ['key' => 'strategy', 'name' => 'Strategy & selection', 'icon' => 'target', 'offers' => [
                [
                    'key'      => 'creator-strategy',
                    'name'     => 'Creator strategy & tiering',
                    'desc'     => 'Which kinds of creators serve which objective, how the budget splits across tiers, and what each tier is expected to deliver.',
                    'includes' => ['Objective and audience definition', 'Tier strategy from nano to macro', 'Budget split and expected outputs', 'Brand-safety and no-go criteria'],
                    'tags'     => ['Tiering', 'Budget split'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands choosing creators by follower count and hoping.',
                ],
                [
                    'key'      => 'creator-vetting',
                    'name'     => 'Creator sourcing & audience vetting',
                    'desc'     => 'A shortlist built on audience overlap, engagement quality and authenticity checks, with rates benchmarked before you negotiate.',
                    'includes' => ['Sourcing across platforms and languages', 'Audience overlap and authenticity checks', 'Engagement and past brand-work review', 'Rate benchmark and shortlist'],
                    'tags'     => ['Audience checks', 'Shortlist'],
                    'stack'    => ['googleanalytics', 'notion'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams who have been burned by bought audiences.',
                ],
                [
                    'key'      => 'community-strategy',
                    'name'     => 'Community & platform activation plan',
                    'desc'     => 'A plan for showing up inside groups, forums and live formats where your audience already gathers, without behaving like an advertiser.',
                    'includes' => ['Community mapping by platform', 'Participation rules and tone', 'Activation formats and calendar', 'Moderator and partner agreements'],
                    'tags'     => ['Communities', 'Groups'],
                    'stack'    => ['whatsapp', 'slack'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose customers talk in places the brand never enters.',
                ],
                [
                    'key'      => 'ambassador-programme',
                    'name'     => 'Ambassador & always-on roster',
                    'desc'     => 'A managed roster of creators working with you across the year, refreshed on performance instead of rebuilt before each campaign.',
                    'includes' => ['Roster design and recruitment', 'Annual contracts and deliverable schedule', 'Monthly briefs and content flow', 'Quarterly roster review'],
                    'tags'     => ['Roster', 'Always-on'],
                    'stack'    => ['hubspot', 'notion'],
                    'time'     => '6–8 weeks to set up, then ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands running creator work often enough to stop starting over.',
                ],
            ]],

            ['key' => 'activation', 'name' => 'Activations', 'icon' => 'megaphone', 'offers' => [
                [
                    'key'      => 'creator-campaign',
                    'name'     => 'Creator campaign',
                    'desc'     => 'A full activation from brief to report: selection, contracts, briefing, content, publication and measurement, run as one project.',
                    'includes' => ['Creative brief and claims guidance', 'Contracting and scheduling', 'Content review and disclosure checks', 'Performance report with incrementality read'],
                    'tags'     => ['End to end', 'Measured'],
                    'stack'    => ['googleanalytics', 'shopify'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Launches and seasonal moments that need reach with credibility.',
                ],
                [
                    'key'      => 'product-seeding',
                    'name'     => 'Product seeding & gifting',
                    'desc'     => 'Getting product into the right hands at scale, with tracking, follow-up and a clear line between gifted and paid coverage.',
                    'includes' => ['Recipient list and logistics', 'Unboxing kit and messaging', 'Follow-up and content capture', 'Coverage tracking and conversion to paid'],
                    'tags'     => ['Seeding', 'Gifting'],
                    'stack'    => ['shopify', 'hubspot'],
                    'time'     => '4–8 weeks per wave',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Consumer brands with product worth trying.',
                ],
                [
                    'key'      => 'creator-events',
                    'name'     => 'Creator events & travel',
                    'desc'     => 'Events, trips and experiences designed to produce content, with the logistics, the rights and the disclosure handled before anyone arrives.',
                    'includes' => ['Concept, venue and itinerary', 'Creator selection and contracts', 'On-site content capture and support', 'Content collection and rights records'],
                    'tags'     => ['Events', 'Experiences'],
                    'time'     => '8–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands with something to show that a feed alone cannot carry.',
                ],
                [
                    'key'      => 'live-commerce',
                    'name'     => 'Live shopping & commerce activations',
                    'desc'     => 'Live sessions and shoppable formats run with creators, connected to your catalogue, stock and checkout so the sale actually completes.',
                    'includes' => ['Format and run-of-show design', 'Catalogue, offer and stock coordination', 'Creator briefing and rehearsal', 'Sales and drop-off reporting'],
                    'tags'     => ['Live', 'Shoppable'],
                    'stack'    => ['shopify', 'woocommerce', 'googleanalytics'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Commerce brands whose products demonstrate well live.',
                ],
            ]],

            ['key' => 'rights', 'name' => 'Rights, safety & compliance', 'icon' => 'clipboard-check', 'offers' => [
                [
                    'key'      => 'contracts-rights',
                    'name'     => 'Contracts & usage rights',
                    'desc'     => 'Agreements that say exactly what is delivered, where it may run, for how long, and what happens if it does not arrive.',
                    'includes' => ['Contract templates for each creator tier', 'Usage, term, territory and exclusivity terms', 'Approval and revision rules', 'Rights matrix maintained per asset'],
                    'tags'     => ['Contracts', 'Rights matrix'],
                    'time'     => '2–4 weeks to set up',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands who cannot reuse creator content they paid for.',
                ],
                [
                    'key'      => 'disclosure-compliance',
                    'name'     => 'Disclosure & advertising compliance',
                    'desc'     => 'Paid partnerships labelled correctly for every market you run in, with the obligation written into briefs and contracts and checked at publication.',
                    'includes' => ['Market-by-market disclosure requirements', 'Brief and contract clauses', 'Publication checks against each post', 'Compliance log for your records'],
                    'tags'     => ['Disclosure', 'ASCI · FTC'],
                    'time'     => '2–3 weeks to set up, then per activation',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose creator posts are labelled inconsistently or not at all.',
                ],
                [
                    'key'      => 'brand-safety',
                    'name'     => 'Brand safety & escalation plan',
                    'desc'     => 'Criteria, monitoring and a rehearsed route for the moment a creator or a comment becomes a problem.',
                    'includes' => ['Safety criteria and screening process', 'Conduct clauses and takedown rights', 'Monitoring during and after activation', 'Escalation plan agreed with legal'],
                    'tags'     => ['Safety', 'Escalation'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Regulated categories and brands with low tolerance for surprise.',
                ],
                [
                    'key'      => 'ugc-library',
                    'name'     => 'UGC rights & content library',
                    'desc'     => 'Customer and creator content collected with permission, stored with its rights, and made findable for the teams who need it.',
                    'includes' => ['Permission and release workflow', 'Library structure, tagging and metadata', 'Rights expiry tracking and alerts', 'Guidance on reuse per channel'],
                    'tags'     => ['UGC', 'Rights tracked'],
                    'stack'    => ['contentful', 'notion'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands reposting customer content without a record of permission.',
                ],
            ]],

            ['key' => 'measure', 'name' => 'Amplification & measurement', 'icon' => 'chart', 'offers' => [
                [
                    'key'      => 'whitelisting',
                    'name'     => 'Whitelisting & paid amplification',
                    'desc'     => 'Running the creator content that performs as paid media from the creator handle, with rights and permissions already in place.',
                    'includes' => ['Rights and platform permissions set-up', 'Selection of assets on organic performance', 'Audience and budget strategy', 'Reporting split by creator and asset'],
                    'tags'     => ['Creator ads', 'Paid amplification'],
                    'stack'    => ['googleanalytics', 'googletagmanager'],
                    'time'     => '2–4 weeks to set up, then ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose best creator post reached only that creator audience.',
                ],
                [
                    'key'      => 'activation-incrementality',
                    'name'     => 'Activation incrementality testing',
                    'desc'     => 'A test design that shows what the activation added, using holdout regions or matched markets rather than platform-reported credit.',
                    'includes' => ['Test design and market matching', 'Baseline and measurement window', 'Analysis with confidence stated plainly', 'Recommendation for the next wave'],
                    'tags'     => ['Holdout', 'Matched markets'],
                    'stack'    => ['googlebigquery', 'looker'],
                    'time'     => '6–10 weeks including the measurement window',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams asked whether creator spend actually moved anything.',
                ],
                [
                    'key'      => 'activation-reporting',
                    'name'     => 'Activation reporting & benchmarks',
                    'desc'     => 'Honest reporting per creator and per asset, with benchmarks that improve as the programme builds its own history.',
                    'includes' => ['Reach, engagement, traffic and sales by creator', 'Cost per outcome, not cost per post', 'Content-level learning for the next brief', 'Rolling programme benchmarks'],
                    'tags'     => ['Per creator', 'Benchmarks'],
                    'stack'    => ['looker', 'googleanalytics', 'shopify'],
                    'time'     => '2–3 weeks after each activation',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands with screenshots of reach and no cost per outcome.',
                ],
            ]],

        ],
        'packages'   => ['project', 'retainer', 'sprint'],
    ],

    /* =============================================================================================
       05 · Performance Marketing
       ============================================================================================= */
    'performance-marketing' => [
        'discipline' => 'campaign-content',
        'title'      => '<span class="g">Fix the measurement,</span> then scale the spend.',
        'lead'       => 'Paid search, paid social, retail media and programmatic, run in your accounts on a measurement layer you own. Consented tracking, creative volume and incrementality testing, so the budget moves on evidence.',
        'categories' => [

            ['key' => 'foundation', 'name' => 'Measurement foundation', 'icon' => 'gauge', 'offers' => [
                [
                    'key'      => 'paid-audit',
                    'name'     => 'Paid media audit',
                    'desc'     => 'An independent read on accounts, tracking, feeds and creative, with the waste quantified and a ranked list of what to fix first.',
                    'includes' => ['Account structure and bidding review', 'Tracking and consent validation', 'Creative and landing page review', 'Ranked fix list with estimated impact'],
                    'tags'     => ['Audit', 'Ranked fixes'],
                    'stack'    => ['google', 'googleanalytics', 'googletagmanager'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers who suspect the spend is working harder than it should.',
                ],
                [
                    'key'      => 'tracking-foundation',
                    'name'     => 'Server-side tracking & consent',
                    'desc'     => 'Server-side tagging, conversion APIs and consent mode implemented and validated, so platform data survives privacy changes.',
                    'includes' => ['Measurement plan tied to revenue events', 'Server container and conversion API set-up', 'Consent mode and banner integration', 'End-to-end validation and documentation'],
                    'tags'     => ['Server-side', 'Consent mode'],
                    'stack'    => ['googletagmanager', 'googleanalytics', 'googlebigquery'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers whose conversion counts fell and never recovered.',
                ],
                [
                    'key'      => 'offline-conversions',
                    'name'     => 'Offline & CRM conversion imports',
                    'desc'     => 'Sending qualified leads, sales and returns back to the ad platforms, so bidding optimises for revenue rather than form fills.',
                    'includes' => ['CRM to platform conversion mapping', 'Automated import pipeline', 'Lead quality and value modelling', 'Validation against finance numbers'],
                    'tags'     => ['CRM', 'Value-based bidding'],
                    'stack'    => ['hubspot', 'salesforce', 'google', 'zapier'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'B2B and considered-purchase advertisers optimising on the wrong event.',
                ],
                [
                    'key'      => 'feed-management',
                    'name'     => 'Product feed management',
                    'desc'     => 'Clean, enriched and rule-driven product feeds, because shopping and retail media performance is mostly a feed problem.',
                    'includes' => ['Feed audit and error resolution', 'Attribute enrichment and titles', 'Rules by margin, stock and seasonality', 'Monitoring and disapproval alerts'],
                    'tags'     => ['Shopping feeds', 'Enrichment'],
                    'stack'    => ['shopify', 'woocommerce', 'google'],
                    'time'     => '3–5 weeks, then ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Retailers whose shopping results are limited by feed quality.',
                ],
            ]],

            ['key' => 'channels', 'name' => 'Channels', 'icon' => 'target', 'offers' => [
                [
                    'key'      => 'paid-search',
                    'name'     => 'Paid search & shopping',
                    'desc'     => 'Search and shopping campaigns managed against margin and qualified pipeline, with the hygiene work that automated campaign types still need.',
                    'includes' => ['Account restructure and bidding strategy', 'Query, placement and brand-term hygiene', 'Ad copy and asset testing', 'Weekly optimisation and monthly review'],
                    'tags'     => ['Search', 'Shopping'],
                    'stack'    => ['google', 'googleanalytics', 'googletagmanager'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers relying on automation with nobody checking it.',
                ],
                [
                    'key'      => 'paid-social',
                    'name'     => 'Paid social & video',
                    'desc'     => 'Social and video campaigns built for each auction, with account structure, audience strategy and creative volume planned together.',
                    'includes' => ['Account structure and audience strategy', 'Creative brief and weekly variants', 'Frequency and saturation management', 'Weekly optimisation and reporting'],
                    'tags'     => ['Social', 'Video'],
                    'stack'    => ['googleanalytics', 'googletagmanager', 'shopify'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose social results depend entirely on one old ad.',
                ],
                [
                    'key'      => 'retail-media',
                    'name'     => 'Retail media & marketplaces',
                    'desc'     => 'Sponsored placements on marketplaces and retailer networks, planned with listing quality, price and stock rather than in isolation.',
                    'includes' => ['Listing and content quality review', 'Campaign structure by category and term', 'Stock and margin-aware bidding', 'Share of shelf and performance reporting'],
                    'tags'     => ['Marketplaces', 'Retail networks'],
                    'stack'    => ['shopify', 'googleanalytics'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands selling through marketplaces as well as their own site.',
                ],
                [
                    'key'      => 'programmatic',
                    'name'     => 'Programmatic, display & CTV',
                    'desc'     => 'Programmatic buying with inventory quality, brand safety and frequency treated as first-order decisions rather than default settings.',
                    'includes' => ['Inventory and supply-path review', 'Audience and contextual strategy', 'Brand safety and exclusion lists', 'Reach, frequency and outcome reporting'],
                    'tags'     => ['Programmatic', 'CTV'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers buying reach without knowing where it ran.',
                ],
                [
                    'key'      => 'app-campaigns',
                    'name'     => 'App install & engagement campaigns',
                    'desc'     => 'App campaigns measured on what users do after install, with attribution, events and creative built for the store and the feed.',
                    'includes' => ['Attribution and event set-up', 'Store listing and creative optimisation', 'Install and post-install campaign structure', 'Cohort and retention reporting'],
                    'tags'     => ['App installs', 'Retention'],
                    'stack'    => ['mixpanel', 'posthog', 'googleanalytics'],
                    'time'     => '4–6 weeks to set up, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'App teams buying installs that never open the app twice.',
                ],
            ]],

            ['key' => 'creative', 'name' => 'Creative & conversion', 'icon' => 'images', 'offers' => [
                [
                    'key'      => 'performance-creative',
                    'name'     => 'Performance creative studio',
                    'desc'     => 'A weekly supply of ad creative built from what is working, in the formats and aspect ratios each platform needs.',
                    'includes' => ['Creative strategy from performance patterns', 'Weekly static and video variants', 'Platform-specific formats and cut-downs', 'Creative-level performance read'],
                    'tags'     => ['Weekly batches', 'All formats'],
                    'stack'    => ['figma', 'openai'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers whose creative pipeline cannot feed the auction.',
                ],
                [
                    'key'      => 'creative-testing',
                    'name'     => 'Creative testing programme',
                    'desc'     => 'Structured testing with one hypothesis per variant, so you learn which idea works rather than which colour won.',
                    'includes' => ['Testing framework and hypothesis log', 'Test calendar and sample size guidance', 'Analysis at concept and element level', 'Learning library that informs the next brief'],
                    'tags'     => ['Hypotheses', 'Learning library'],
                    'time'     => 'Ongoing · monthly cycles',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams running tests that never produce a conclusion.',
                ],
                [
                    'key'      => 'landing-cro',
                    'name'     => 'Landing pages & conversion optimisation',
                    'desc'     => 'The page the ad sends people to, built and tested for one action, with speed and accessibility treated as conversion factors.',
                    'includes' => ['Page design, copy and build', 'Form, tracking and consent set-up', 'Speed and accessibility checks', 'Test plan and iteration'],
                    'tags'     => ['CRO', 'Fast pages'],
                    'stack'    => ['webflow', 'wordpress', 'posthog', 'lighthouse'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers paying for clicks that land on a slow page.',
                ],
            ]],

            ['key' => 'measurement', 'name' => 'Measurement & allocation', 'icon' => 'chart', 'offers' => [
                [
                    'key'      => 'incrementality',
                    'name'     => 'Incrementality testing',
                    'desc'     => 'Geo holdouts and matched-market tests that show what your media adds, designed so the result survives scrutiny.',
                    'includes' => ['Test design and market matching', 'Execution and monitoring', 'Analysis with confidence stated plainly', 'Decision recommendation'],
                    'tags'     => ['Holdouts', 'Geo tests'],
                    'stack'    => ['googlebigquery', 'looker', 'dbt'],
                    'time'     => '6–10 weeks per cycle',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose platform-reported returns look too good to be true.',
                ],
                [
                    'key'      => 'mix-model',
                    'name'     => 'Media mix read',
                    'desc'     => 'A modelled read of how channels contribute together, used alongside experiments rather than instead of them.',
                    'includes' => ['Data preparation across channels', 'Model build and validation', 'Contribution and saturation curves', 'Scenario planning for budget changes'],
                    'tags'     => ['Mix modelling', 'Saturation'],
                    'stack'    => ['googlebigquery', 'python', 'looker'],
                    'time'     => '8–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Advertisers with enough history and several channels in play.',
                ],
                [
                    'key'      => 'paid-dashboard',
                    'name'     => 'Paid media dashboard',
                    'desc'     => 'Every channel in one view, on agreed definitions, reconciled with your CRM and finance numbers.',
                    'includes' => ['Data pipeline from platforms and CRM', 'Cost, conversion and margin views', 'Alerting for spend and performance anomalies', 'Monthly commentary'],
                    'tags'     => ['Dashboard', 'Reconciled'],
                    'stack'    => ['looker', 'powerbi', 'googlebigquery'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose channel reports never add up to the same total.',
                ],
                [
                    'key'      => 'budget-model',
                    'name'     => 'Budget allocation model',
                    'desc'     => 'A model that turns test results and saturation curves into a defensible budget split, with scenarios for more and less.',
                    'includes' => ['Channel role and allocation logic', 'Scenario modelling for budget changes', 'Quarterly reallocation process', 'Board-ready summary'],
                    'tags'     => ['Allocation', 'Scenarios'],
                    'stack'    => ['looker', 'googlebigquery'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing leaders defending next year’s budget.',
                ],
            ]],

        ],
        'packages'   => ['retainer', 'sprint', 'project', 'squad'],
    ],

    /* =============================================================================================
       06 · Omnichannel Marketing Strategy
       ============================================================================================= */
    'omnichannel-marketing-strategy' => [
        'discipline' => 'campaign-content',
        'title'      => '<span class="g">Decide who, where and when,</span> then write it down.',
        'lead'       => 'Audience and demand analysis, channel architecture, message sequencing, budget allocation and a measurement framework — delivered as a plan with owners, dates and measures attached, and an operating rhythm to run it.',
        'categories' => [

            ['key' => 'audience', 'name' => 'Audience & demand', 'icon' => 'users', 'offers' => [
                [
                    'key'      => 'audience-demand',
                    'name'     => 'Audience & demand analysis',
                    'desc'     => 'Who is in the market now, who will be later, and what each group needs to hear, built from your data rather than invented personas.',
                    'includes' => ['CRM, analytics and sales data analysis', 'Segment definition and sizing', 'Needs and triggers per segment', 'Priority ranking with rationale'],
                    'tags'     => ['Segments', 'In-market'],
                    'stack'    => ['googleanalytics', 'hubspot', 'googlebigquery'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose personas were written years ago in a workshop.',
                ],
                [
                    'key'      => 'market-research',
                    'name'     => 'Customer & market research',
                    'desc'     => 'Primary research where the data runs out: interviews, surveys and category analysis that answer the questions the numbers cannot.',
                    'includes' => ['Research design and screening', 'Interviews or survey fieldwork', 'Analysis and themes with verbatims', 'Implications for the marketing plan'],
                    'tags'     => ['Qualitative', 'Quantitative'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Decisions too expensive to make on assumption.',
                ],
                [
                    'key'      => 'journey-architecture',
                    'name'     => 'Buying journey & channel architecture',
                    'desc'     => 'The route from unaware to customer, and the job each channel does along it, so nothing is bought out of habit.',
                    'includes' => ['Journey stages with evidence at each', 'Channel role and contribution map', 'Content and message needs per stage', 'Gaps and overlaps identified'],
                    'tags'     => ['Journey', 'Channel roles'],
                    'stack'    => ['miro', 'googleanalytics'],
                    'time'     => '3–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing teams buying channels without a defined job for each.',
                ],
                [
                    'key'      => 'entry-points',
                    'name'     => 'Category entry points & demand spaces',
                    'desc'     => 'The situations that make someone start looking, and the cues that should make your brand the one they remember.',
                    'includes' => ['Entry point research and prioritisation', 'Brand association mapping', 'Message and asset implications', 'Measurement approach for mental availability'],
                    'tags'     => ['Demand spaces', 'Mental availability'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands competing on features when buyers are choosing on memory.',
                ],
            ]],

            ['key' => 'plan', 'name' => 'Plan & budget', 'icon' => 'steps', 'offers' => [
                [
                    'key'      => 'annual-plan',
                    'name'     => 'Annual marketing plan',
                    'desc'     => 'A twelve-month plan with quarterly themes, campaign slots, owners, dependencies and the measure attached to each.',
                    'includes' => ['Quarterly themes and campaign slots', 'Owners, dependencies and dates', 'Resource and capacity check', 'Measures and review points'],
                    'tags'     => ['12 months', 'Owned'],
                    'stack'    => ['notion', 'jira', 'miro'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams starting each quarter by deciding what to do.',
                ],
                [
                    'key'      => 'budget-allocation',
                    'name'     => 'Budget allocation model',
                    'desc'     => 'Spend split by the job each channel does, with scenarios for a larger and a smaller budget and the logic written down.',
                    'includes' => ['Allocation by channel role', 'Scenario modelling', 'Reallocation triggers and cadence', 'Board-ready summary'],
                    'tags'     => ['Allocation', 'Scenarios'],
                    'stack'    => ['looker', 'powerbi'],
                    'time'     => '3–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing leaders whose budget split is inherited, not argued.',
                ],
                [
                    'key'      => 'campaign-architecture',
                    'name'     => 'Campaign architecture & calendar',
                    'desc'     => 'How campaigns, always-on activity and seasonal moments fit together across the year without colliding.',
                    'includes' => ['Campaign and always-on split', 'Seasonal and category moment map', 'Calendar with lead times per channel', 'Production capacity check'],
                    'tags'     => ['Calendar', 'Lead times'],
                    'stack'    => ['notion', 'jira'],
                    'time'     => '3–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose campaigns are planned three weeks before launch.',
                ],
                [
                    'key'      => 'gtm-plan',
                    'name'     => 'Go-to-market plan for a launch',
                    'desc'     => 'A launch plan across marketing, sales and product, with the sequence, assets, owners and readiness checks defined.',
                    'includes' => ['Audience, positioning and message sequence', 'Channel plan and asset list', 'Sales and support enablement', 'Launch readiness checklist and measures'],
                    'tags'     => ['Launch', 'Cross-team'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product launches where marketing is briefed last.',
                ],
            ]],

            ['key' => 'measure', 'name' => 'Measurement', 'icon' => 'gauge', 'offers' => [
                [
                    'key'      => 'measurement-framework',
                    'name'     => 'Measurement framework',
                    'desc'     => 'One definition of every metric, the data model behind it, and the reporting rhythm from weekly operations to quarterly review.',
                    'includes' => ['Metric definitions agreed with sales and finance', 'Data sources, joins and ownership', 'Report set by audience and cadence', 'Governance for changing a definition'],
                    'tags'     => ['Definitions', 'Rhythm'],
                    'stack'    => ['googlebigquery', 'dbt', 'looker'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies where every team reports a different number.',
                ],
                [
                    'key'      => 'marketing-dashboard',
                    'name'     => 'Marketing dashboard build',
                    'desc'     => 'Automated dashboards for leadership and for the people running channels, refreshed without anyone rebuilding a spreadsheet.',
                    'includes' => ['Data pipeline from channels and CRM', 'Executive and operating dashboards', 'Automated refresh and alerts', 'Handover and documentation'],
                    'tags'     => ['Dashboards', 'Automated'],
                    'stack'    => ['looker', 'powerbi', 'googlebigquery', 'snowflake'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose monthly report takes three days to assemble.',
                ],
                [
                    'key'      => 'attribution-review',
                    'name'     => 'Attribution & reporting review',
                    'desc'     => 'An honest assessment of how you currently credit marketing, what it over-reports, and a workable alternative.',
                    'includes' => ['Current attribution and tracking review', 'Bias and blind spot analysis', 'Recommended measurement approach', 'Transition plan and expectations'],
                    'tags'     => ['Attribution', 'Honest read'],
                    'stack'    => ['googleanalytics', 'googletagmanager', 'hubspot'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose channel reports each claim the same revenue.',
                ],
                [
                    'key'      => 'experiment-roadmap',
                    'name'     => 'Experiment roadmap',
                    'desc'     => 'A prioritised queue of tests across channels, message and offer, with a design standard so results are usable.',
                    'includes' => ['Test backlog scored on value and effort', 'Design standard and sample guidance', 'Calendar and ownership', 'Results library'],
                    'tags'     => ['Testing', 'Prioritised'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams testing constantly and learning very little.',
                ],
            ]],

            ['key' => 'operate', 'name' => 'Operating model', 'icon' => 'cycle', 'offers' => [
                [
                    'key'      => 'operating-model',
                    'name'     => 'Marketing operating model',
                    'desc'     => 'Who decides what, which meetings exist, how work enters the plan and how it is stopped, written down and agreed.',
                    'includes' => ['Roles and decision rights', 'Meeting and reporting cadence', 'Intake, prioritisation and stop rules', 'Ways of working documentation'],
                    'tags'     => ['Decision rights', 'Cadence'],
                    'stack'    => ['notion', 'confluence'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing teams where everything is urgent and nothing is owned.',
                ],
                [
                    'key'      => 'agency-orchestration',
                    'name'     => 'Agency & partner orchestration',
                    'desc'     => 'One brief, one calendar and one set of measures across your agencies and partners, so they stop duplicating each other.',
                    'includes' => ['Partner scope and overlap map', 'Shared brief and calendar standard', 'Performance review framework', 'Consolidation recommendations'],
                    'tags'     => ['Agencies', 'Scope clarity'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies with several agencies and no shared plan.',
                ],
                [
                    'key'      => 'team-enablement',
                    'name'     => 'Team enablement & training',
                    'desc'     => 'Practical sessions that leave your team able to run the plan: briefing, measurement, creative judgement and AI-assisted workflow.',
                    'includes' => ['Training needs assessment', 'Workshop series with your own work', 'Templates and reference material', 'Follow-up clinic after four weeks'],
                    'tags'     => ['Workshops', 'Templates'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'In-house teams inheriting a plan they did not write.',
                ],
                [
                    'key'      => 'quarterly-review',
                    'name'     => 'Quarterly review facilitation',
                    'desc'     => 'An independently facilitated quarterly review that reads the numbers, decides what stops, and re-plans the next quarter.',
                    'includes' => ['Pre-read with performance analysis', 'Facilitated session with leadership', 'Decisions and stop list recorded', 'Updated plan for the next quarter'],
                    'tags'     => ['Quarterly', 'Facilitated'],
                    'time'     => 'Quarterly · 1–2 weeks each',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams whose quarterly reviews never change anything.',
                ],
            ]],

        ],
        'packages'   => ['sprint', 'project', 'enterprise', 'retainer'],
    ],

    /* =============================================================================================
       07 · Campaign Design Systems
       ============================================================================================= */
    'campaign-design-systems' => [
        'discipline' => 'campaign-content',
        'title'      => '<span class="g">One idea,</span> built to survive forty formats.',
        'lead'       => 'The framework behind a campaign: the master idea, art direction, message matrix, templates on tokens, motion rules, localisation rules and automated checks. Built so market teams can move quickly without the campaign drifting.',
        'categories' => [

            ['key' => 'platform', 'name' => 'Idea & direction', 'icon' => 'lightbulb', 'offers' => [
                [
                    'key'      => 'campaign-platform',
                    'name'     => 'Campaign platform & big idea',
                    'desc'     => 'The idea a campaign runs on, expressed as a line, a look and a clear statement of what the campaign is not.',
                    'includes' => ['Campaign brief and audience definition', 'Two or three platforms on real placements', 'Chosen idea with rationale', 'Boundaries and anti-examples'],
                    'tags'     => ['Big idea', 'Platform'],
                    'stack'    => ['figma', 'miro'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose campaigns start with executions instead of an idea.',
                ],
                [
                    'key'      => 'art-direction',
                    'name'     => 'Campaign art direction',
                    'desc'     => 'Photography direction, typography, colour behaviour, graphic devices and motion, defined as a kit of parts rather than finished ads.',
                    'includes' => ['Art direction boards and references', 'Photography and casting direction', 'Type, colour and graphic device rules', 'Sample executions across placements'],
                    'tags'     => ['Art direction', 'Kit of parts'],
                    'stack'    => ['figma'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Campaigns that look different every time a new agency touches them.',
                ],
                [
                    'key'      => 'message-matrix',
                    'name'     => 'Message matrix',
                    'desc'     => 'Messages by audience, market and funnel stage, with the claims each one may make and the evidence behind them.',
                    'includes' => ['Message set by audience and stage', 'Claims, substantiation and legal review', 'Market variations and restrictions', 'Copy examples per format'],
                    'tags'     => ['Messages', 'Claims'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Campaigns where every market writes its own claims.',
                ],
                [
                    'key'      => 'campaign-naming',
                    'name'     => 'Campaign naming & line development',
                    'desc'     => 'The campaign name, endline and supporting lines, checked for meaning, availability and translation before anyone falls in love with one.',
                    'includes' => ['Name and line territories', 'Linguistic and cultural check per market', 'Availability screening guidance', 'Recommended route with rationale'],
                    'tags'     => ['Naming', 'Endline'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Global campaigns whose line breaks in the second market.',
                ],
            ]],

            ['key' => 'system', 'name' => 'The system', 'icon' => 'layers', 'offers' => [
                [
                    'key'      => 'master-templates',
                    'name'     => 'Master templates & sizing',
                    'desc'     => 'Master artwork and sized templates for every placement you buy, built so one change propagates instead of being remade forty times.',
                    'includes' => ['Format inventory from your media plan', 'Master artwork per format family', 'Sized templates with safe areas', 'Export and handover specifications'],
                    'tags'     => ['Every size', 'Masters'],
                    'stack'    => ['figma'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams rebuilding the same layout for every placement.',
                ],
                [
                    'key'      => 'campaign-tokens',
                    'name'     => 'Campaign tokens & component kit',
                    'desc'     => 'Colour, type, spacing and component values held as tokens, so digital, social and web executions stay identical by construction.',
                    'includes' => ['Token set inherited from the brand system', 'Component kit for campaign layouts', 'Export for web and production tooling', 'Versioning and change process'],
                    'tags'     => ['Tokens', 'Components'],
                    'stack'    => ['figma', 'storybook', 'github'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose digital campaign assets drift from the masters.',
                ],
                [
                    'key'      => 'motion-system',
                    'name'     => 'Motion & sound rules',
                    'desc'     => 'How the campaign moves and sounds: timing, easing, transitions, logo behaviour and the audio signature, with reference files.',
                    'includes' => ['Motion principles with timing and easing', 'Transition and logo endframe rules', 'Sound and music guidance', 'Reference animations and project files'],
                    'tags'     => ['Motion', 'Sound'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Campaigns where every edit house invents its own animation.',
                ],
                [
                    'key'      => 'accessible-creative',
                    'name'     => 'Accessible creative standards',
                    'desc'     => 'Contrast, minimum type size, caption and subtitle rules, and audio description guidance, written into the system rather than checked at the end.',
                    'includes' => ['Contrast and type-size rules per format', 'Caption, subtitle and alt-text standards', 'Motion and flashing content guidance', 'Checklist built into the review route'],
                    'tags'     => ['WCAG 2.2 AA', 'Captions'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose campaign work fails accessibility review after launch.',
                ],
            ]],

            ['key' => 'scale', 'name' => 'Scale & localisation', 'icon' => 'globe', 'offers' => [
                [
                    'key'      => 'localisation-rules',
                    'name'     => 'Localisation & adaptation rules',
                    'desc'     => 'What markets may change and what they may not, with type, layout, legal and cultural variations handled by the system.',
                    'includes' => ['Fixed and flexible elements defined', 'Script, length and layout rules', 'Legal line and regulatory variations', 'Approval route for exceptions'],
                    'tags'     => ['Fixed · flexible', 'Multi-market'],
                    'time'     => '3–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Global campaigns adapted by fifteen teams in fifteen ways.',
                ],
                [
                    'key'      => 'market-toolkits',
                    'name'     => 'Market toolkits & training',
                    'desc'     => 'A practical kit and a working session per market, so local teams can produce correct assets on their first attempt.',
                    'includes' => ['Toolkit with templates and examples', 'Do and do-not reference', 'Live training per region', 'Office hours during rollout'],
                    'tags'     => ['Toolkit', 'Training'],
                    'stack'    => ['figma', 'notion'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose guidelines are sent out and never opened.',
                ],
                [
                    'key'      => 'automated-production',
                    'name'     => 'Automated asset production',
                    'desc'     => 'A pipeline that generates sized versions, language variants and placement specifications from the master, with a person approving the output.',
                    'includes' => ['Template and data structure for automation', 'Resizing and versioning pipeline', 'Language and offer variable handling', 'Review and approval step before release'],
                    'tags'     => ['Automation', 'Versioning'],
                    'stack'    => ['figma', 'n8n', 'contentful', 'openai'],
                    'time'     => '5–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Campaigns needing hundreds of variants on a fixed deadline.',
                ],
                [
                    'key'      => 'asset-register',
                    'name'     => 'Asset register & library structure',
                    'desc'     => 'One place where every campaign asset lives, with naming, metadata, rights and expiry recorded so nothing runs past its licence.',
                    'includes' => ['Naming and metadata standard', 'Library structure and permissions', 'Rights and expiry tracking', 'Retirement and archive process'],
                    'tags'     => ['Asset library', 'Rights tracked'],
                    'stack'    => ['contentful', 'notion'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams who cannot find the approved version of anything.',
                ],
            ]],

            ['key' => 'assure', 'name' => 'Governance & checks', 'icon' => 'check', 'offers' => [
                [
                    'key'      => 'creative-qa',
                    'name'     => 'Automated creative checks',
                    'desc'     => 'Machine checks for contrast, minimum type size, safe areas, clearspace and mandatory legal lines, run before assets reach media.',
                    'includes' => ['Rule set agreed with brand and legal', 'Checks wired into the production pipeline', 'Failure reports with the reason stated', 'Exception and override process'],
                    'tags'     => ['Automated QA', 'Pre-flight'],
                    'stack'    => ['n8n', 'github'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands finding creative errors after the campaign is live.',
                ],
                [
                    'key'      => 'campaign-guidelines',
                    'name'     => 'Campaign guidelines site',
                    'desc'     => 'A living, searchable reference for the campaign rather than a PDF nobody opens, versioned as the campaign evolves.',
                    'includes' => ['Structured guidelines with examples', 'Downloadable templates and assets', 'Search and versioning', 'Update process during the campaign'],
                    'tags'     => ['Living reference', 'Versioned'],
                    'stack'    => ['webflow', 'contentful', 'notion'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Campaigns running across enough teams to need one source.',
                ],
                [
                    'key'      => 'media-spec-compliance',
                    'name'     => 'Media specification compliance',
                    'desc'     => 'Every asset checked against the technical specifications of the placements you have actually bought, before the deadline rather than after.',
                    'includes' => ['Specification matrix from the media plan', 'File, weight and duration checks', 'Trafficking-ready export packages', 'Rejection resolution support'],
                    'tags'     => ['Media specs', 'Trafficking'],
                    'time'     => '2–4 weeks per flight',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose assets are rejected by publishers on delivery day.',
                ],
            ]],

        ],
        'packages'   => ['project', 'sprint', 'milestone', 'enterprise'],
    ],

    /* =============================================================================================
       08 · Global Content Production
       ============================================================================================= */
    'global-content-production' => [
        'discipline' => 'campaign-content',
        'title'      => '<span class="g">Original work, produced anywhere,</span> delivered to one standard.',
        'lead'       => 'Photography, film, audio and CGI made through a vetted network of local crews and creators. One brief, one review pipeline, rights cleared per market, and assets delivered into your library in every specification your channels need.',
        'categories' => [

            ['key' => 'production', 'name' => 'Production', 'icon' => 'camera', 'offers' => [
                [
                    'key'      => 'film-production',
                    'name'     => 'Film & video production',
                    'desc'     => 'Brand films, product films and campaign video produced end to end, with a producer who owns the schedule, the budget and the standard.',
                    'includes' => ['Treatment, storyboard and schedule', 'Casting, locations, permits and crew', 'Shoot with daily review', 'Edit, grade, sound and delivery versions'],
                    'tags'     => ['Film', 'End to end'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Campaigns that need a film rather than an edit of stock.',
                ],
                [
                    'key'      => 'photography',
                    'name'     => 'Photography production',
                    'desc'     => 'Product, lifestyle, portrait and location photography, art directed against the campaign system and delivered retouched and sized.',
                    'includes' => ['Shot list built from the asset plan', 'Casting, styling, location and crew', 'Shoot with on-set art direction', 'Retouching, sizing and delivery'],
                    'tags'     => ['Photography', 'Art directed'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose imagery is a mix of stock and old shoots.',
                ],
                [
                    'key'      => 'audio-production',
                    'name'     => 'Audio, voice & sound',
                    'desc'     => 'Voice-over, sound design, music supervision and audio identity work, recorded and licensed properly for the markets you run in.',
                    'includes' => ['Voice casting and direction', 'Recording and sound design', 'Music licensing or original composition', 'Localised voice versions'],
                    'tags'     => ['Voice', 'Sound design'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Video and audio campaigns where sound is an afterthought.',
                ],
                [
                    'key'      => 'cgi-3d',
                    'name'     => 'CGI, 3D & product visualisation',
                    'desc'     => 'Product CGI and 3D environments for work that cannot be photographed economically, or that must be repeated for every variant and market.',
                    'includes' => ['Asset modelling and materials', 'Lighting and environment build', 'Render set for every required angle', 'Reusable scene files for future variants'],
                    'tags'     => ['CGI', '3D', 'Reusable'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product ranges with many variants, colours or configurations.',
                ],
            ]],

            ['key' => 'scale', 'name' => 'Scale & coverage', 'icon' => 'globe', 'offers' => [
                [
                    'key'      => 'global-network',
                    'name'     => 'Global crew network',
                    'desc'     => 'Vetted producers, crews and creators in the markets you sell in, briefed centrally and reviewed against the same standard.',
                    'includes' => ['Market coverage plan', 'Crew vetting and onboarding', 'Central brief and review pipeline', 'Consistent contracting and rights terms'],
                    'tags'     => ['Multi-market', 'Vetted crews'],
                    'time'     => 'Per production wave',   // PLACEHOLDER: confirm network coverage before launch
                    'best'     => 'Brands producing in several countries with uneven results.',
                ],
                [
                    'key'      => 'content-capture',
                    'name'     => 'Content capture at scale',
                    'desc'     => 'One production planned to yield a season of assets: hero, cut-downs, stills, vertical versions and behind-the-scenes from the same day.',
                    'includes' => ['Asset plan built from the channel calendar', 'Multi-format capture on one schedule', 'Library of cut-downs and stills', 'Delivery mapped to the content calendar'],
                    'tags'     => ['One shoot, a season'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams booking a new shoot every time a channel needs an asset.',
                ],
                [
                    'key'      => 'always-on-production',
                    'name'     => 'Always-on content production',
                    'desc'     => 'A monthly production rhythm for social and campaign content, batched so the calendar is never waiting on a shoot.',
                    'includes' => ['Monthly batch shoots or remote capture', 'Agreed output per format', 'Edit, version and delivery pipeline', 'Rolling asset library'],
                    'tags'     => ['Monthly', 'Batched'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose always-on calendar keeps running out of assets.',
                ],
                [
                    'key'      => 'event-capture',
                    'name'     => 'Event & live capture',
                    'desc'     => 'Coverage of launches, conferences and field activity, edited fast enough to be published while the event is still relevant.',
                    'includes' => ['Coverage plan and crew', 'Same-day or next-day edits', 'Stills and social cut-downs', 'Rights and consent handling on site'],
                    'tags'     => ['Events', 'Fast turnaround'],
                    'time'     => 'Per event',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies whose event content arrives two weeks late.',
                ],
            ]],

            ['key' => 'post', 'name' => 'Post & localisation', 'icon' => 'film', 'offers' => [
                [
                    'key'      => 'post-production',
                    'name'     => 'Edit, grade & finishing',
                    'desc'     => 'Post production for footage you already have or work we shot, finished to broadcast and platform specifications.',
                    'includes' => ['Offline edit with review rounds', 'Grade, sound mix and titling', 'Format and platform versions', 'Archive and project handover'],
                    'tags'     => ['Post', 'Finishing'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands sitting on footage that was never finished properly.',
                ],
                [
                    'key'      => 'market-versions',
                    'name'     => 'Market versions & localisation',
                    'desc'     => 'Language versions, local endframes, legal lines and offer variants produced from one master without a second shoot.',
                    'includes' => ['Version matrix by market and format', 'Translation, subtitling and voice versions', 'Local legal lines and endframes', 'Quality check per market'],
                    'tags'     => ['Localisation', 'Versions'],
                    'time'     => '2–4 weeks per wave',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Campaigns running in several languages from one master film.',
                ],
                [
                    'key'      => 'accessibility-versions',
                    'name'     => 'Subtitles, captions & audio description',
                    'desc'     => 'Accurate captions, subtitles and audio description, produced as part of delivery rather than added after a complaint.',
                    'includes' => ['Caption and subtitle files per language', 'Burned-in versions where platforms need them', 'Audio description where it applies', 'Accessibility check against WCAG 2.2 AA'],
                    'tags'     => ['Captions', 'WCAG 2.2 AA'],
                    'time'     => '1–3 weeks per wave',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands publishing video without captions or description.',
                ],
                [
                    'key'      => 'motion-design',
                    'name'     => 'Motion design & animation',
                    'desc'     => 'Animated explainers, data stories, endframes and social motion built on the campaign motion rules.',
                    'includes' => ['Script, storyboard and style frames', 'Animation and sound', 'Platform versions and aspect ratios', 'Editable project files handed over'],
                    'tags'     => ['Animation', 'Explainers'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams explaining complex products in static slides.',
                ],
            ]],

            ['key' => 'operate', 'name' => 'Rights & delivery', 'icon' => 'clipboard-check', 'offers' => [
                [
                    'key'      => 'rights-management',
                    'name'     => 'Rights, releases & usage records',
                    'desc'     => 'Every asset carrying its licence, term, territory and releases, with renewals flagged before they lapse.',
                    'includes' => ['Rights plan set before production', 'Model, location and music releases', 'Usage record per asset', 'Expiry alerts and renewal support'],
                    'tags'     => ['Rights', 'Releases'],
                    'stack'    => ['notion'],
                    'time'     => '2–4 weeks to set up',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands unsure whether their best image can still be used.',
                ],
                [
                    'key'      => 'dam-delivery',
                    'name'     => 'Delivery into your asset library',
                    'desc'     => 'Finished assets delivered into your DAM or CMS with metadata, naming and rights attached, in every specification your channels need.',
                    'includes' => ['Naming and metadata standard', 'Automated export to required specifications', 'Ingest into your DAM or CMS', 'Access and permission structure'],
                    'tags'     => ['DAM', 'Metadata'],
                    'stack'    => ['contentful', 'sanity', 'cloudflare'],
                    'time'     => '3–5 weeks to set up',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose finished assets live in somebody’s download folder.',
                ],
                [
                    'key'      => 'ai-assisted-pipeline',
                    'name'     => 'AI-assisted production pipeline',
                    'desc'     => 'Generative tools used where they save real time — concepting, previsualisation, extension, versioning, voice and subtitles — with provenance recorded and a person approving every asset.',
                    'includes' => ['Use-case map with what AI will and will not do', 'Tool selection and licence review', 'Human approval and labelling rules', 'Provenance record per asset'],
                    'tags'     => ['AI-assisted', 'Provenance'],
                    'stack'    => ['openai', 'googlegemini', 'replicate', 'huggingface', 'n8n'],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Production teams using generative tools without a standard.',
                ],
            ]],

        ],
        'packages'   => ['project', 'retainer', 'milestone', 'enterprise'],
    ],

];
