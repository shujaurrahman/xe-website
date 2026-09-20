<?php
/**
 * Technology & Intelligence — the service catalogue.
 *
 * What a visitor can actually buy on the discipline hub and on each of the ten capability pages,
 * grouped into categories and offered in engagement packages. One shared component renders this
 * data identically on every page. Clicking a service opens the contact page with it pre-selected,
 * so every enquiry arrives tagged.
 *
 * Shape
 *   '<page-key>' => [
 *     'discipline' => 'technology-intelligence',
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
 * Page keys: 'technology-intelligence' (the hub), then the ten capability slugs in site order.
 * Service id, the tag the contact page receives: '<page-key>:<offer-key>'.
 * Hub offers also carry 'cap': the capability slug the service belongs to.
 *
 * Packages: sprint (1–3 week fixed-scope sprint), project (fixed scope, fixed price), milestone
 * (gated, separately paid phases), retainer (monthly capacity with service levels), enterprise
 * (multi-workstream programme with governance), squad (dedicated team, time & materials).
 *
 * Truthfulness: no prices, client names, results, certifications or partner tiers. Technologies
 * are ones we work with, never partnerships. Security and compliance services are readiness and
 * implementation support; certificates and attestation reports come from independent auditors.
 * Every 'time' is typical, not promised, and is marked PLACEHOLDER until confirmed.
 *
 * Voice: plain English first, technically correct second. Calm, short, active. No exclamation marks.
 */

return [

    /* =============================================================================================
       Hub — the services people most often start with, across all ten capabilities
       ============================================================================================= */
    'technology-intelligence' => [
        'discipline' => 'technology-intelligence',
        'title'      => '<span class="g">Start with one service.</span> Grow into the platform.',
        'lead'       => 'These are the services clients most often start with, across all ten technology capabilities. Choose one and your enquiry reaches the right team with it already attached. Each can be bought as a short sprint, a fixed-scope project or ongoing capacity.',
        'categories' => [

            ['key' => 'build', 'name' => 'Build', 'icon' => 'code', 'offers' => [
                [
                    'key'      => 'website',
                    'cap'      => 'websites-apps',
                    'name'     => 'Website',
                    'desc'     => 'A corporate, marketing or e-commerce website that loads fast, works for everyone and is easy for your team to update.',
                    'includes' => ['Content model, page templates and an editor-friendly CMS', 'SEO foundations and Schema.org markup', 'Core Web Vitals and WCAG 2.2 AA checks before launch', 'Analytics and consent set-up'],
                    'tags'     => ['Corporate', 'E-commerce', 'Headless CMS'],
                    'stack'    => ['nextdotjs', 'wordpress', 'shopify', 'contentful', 'vercel'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies launching a new brand or replacing a site that holds them back.',
                ],
                [
                    'key'      => 'app',
                    'cap'      => 'websites-apps',
                    'name'     => 'Web or mobile app',
                    'desc'     => 'A web application, iPhone app or Android app, built native or cross-platform depending on what your product needs to do.',
                    'includes' => ['Product discovery and a clickable prototype', 'Accounts, roles and the core workflows', 'Native, Flutter or React Native, chosen on evidence', 'Store submission, crash reporting and analytics'],
                    'tags'     => ['SaaS', 'iOS · Android', 'Cross-platform'],
                    'stack'    => ['react', 'nextdotjs', 'swift', 'kotlin', 'flutter', 'reactnative'],
                    'time'     => '10–18 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Founders and product teams putting a new product in front of customers.',
                ],
                [
                    'key'      => 'custom-platform',
                    'cap'      => 'custom-software-data-platforms',
                    'name'     => 'Custom CRM or operations platform',
                    'desc'     => 'Software built around how your business actually runs, such as a CRM, an operations system or an approval tool, instead of bending your process to fit a package.',
                    'includes' => ['Process mapping and a build, buy or extend decision per module', 'Data model and role-based access', 'Integrations with the systems you keep', 'Data migration with reconciliation reports'],
                    'tags'     => ['CRM', 'ERP', 'Internal tools'],
                    'stack'    => ['typescript', 'nestjs', 'postgresql', 'react', 'salesforce'],
                    'time'     => '12–24 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses that have outgrown spreadsheets or off-the-shelf software.',
                ],
                [
                    'key'      => 'data-platform',
                    'cap'      => 'custom-software-data-platforms',
                    'name'     => 'Data platform & BI dashboards',
                    'desc'     => 'One trusted home for your business data and the dashboards built on it, so every team works from the same numbers.',
                    'includes' => ['Warehouse or lakehouse set-up', 'Automated pipelines from your tools', 'Tested data models and metric definitions', 'Dashboards in Power BI, Looker or your BI tool'],
                    'tags'     => ['Warehouse', 'ELT', 'BI'],
                    'stack'    => ['snowflake', 'googlebigquery', 'dbt', 'airbyte', 'powerbi', 'looker'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams reporting from spreadsheets that disagree.',
                ],
            ]],

            ['key' => 'intelligence', 'name' => 'Intelligence', 'icon' => 'brain', 'offers' => [
                [
                    'key'      => 'ai-strategy',
                    'cap'      => 'ai-strategy-agents',
                    'name'     => 'AI strategy & roadmap',
                    'desc'     => 'A clear view of where AI will save time, cost or risk in your business, which use cases to build first and how to measure them.',
                    'includes' => ['Interviews and process walk-throughs', 'Opportunity map scored on value, feasibility and risk', 'Sequenced roadmap with business cases', 'Pilot charter for the first use case'],
                    'tags'     => ['Readiness', 'Use cases', 'Roadmap'],
                    'stack'    => [],
                    'time'     => '4–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams that want an AI plan grounded in their own processes.',
                ],
                [
                    'key'      => 'ai-agent',
                    'cap'      => 'ai-strategy-agents',
                    'name'     => 'Custom AI agent or copilot',
                    'desc'     => 'An assistant or agent that does real work in your systems, such as answering, drafting, checking or updating records, with a person approving anything consequential.',
                    'includes' => ['Task design with scoped permissions', 'Integration with your tools and APIs', 'Evaluation set and red-team tests before go-live', 'Action log and human approval steps'],
                    'tags'     => ['Agents', 'Copilots', 'Human in the loop'],
                    'stack'    => ['langgraph', 'anthropic', 'openai', 'python'],
                    'time'     => '8–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with repetitive, rules-heavy work spread across several systems.',
                ],
                [
                    'key'      => 'knowledge-assistant',
                    'cap'      => 'ai-product-automation',
                    'name'     => 'AI knowledge assistant',
                    'desc'     => 'Ask questions of your own documents and data, and get answers with the sources shown so people can check them.',
                    'includes' => ['Document ingestion and hybrid search', 'Citations and permission-aware access', 'Faithfulness and relevance evaluations', 'Deployment on the web, Slack or Teams'],
                    'tags'     => ['RAG', 'Citations', 'Permission-aware'],
                    'stack'    => ['llamaindex', 'pgvector', 'qdrant', 'anthropic', 'openai'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Support, sales, HR and legal teams searching long documents every day.',
                ],
                [
                    'key'      => 'workflow-automation',
                    'cap'      => 'ai-product-automation',
                    'name'     => 'Workflow automation',
                    'desc'     => 'Routine, multi-step work such as data entry, document handling and hand-offs between tools done automatically, with exceptions sent to the right person.',
                    'includes' => ['Process mapping and an automation shortlist', 'Workflows with AI steps for reading, sorting and drafting', 'Error handling, alerts and an audit trail', 'Documentation and team handover'],
                    'tags'     => ['n8n', 'Make', 'Temporal'],
                    'stack'    => ['n8n', 'make', 'zapier', 'temporal'],
                    'time'     => '2–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Operations teams losing hours to copy-and-paste work.',
                ],
                [
                    'key'      => 'ai-inference',
                    'cap'      => 'ai-infrastructure-cloud',
                    'name'     => 'AI inference platform',
                    'desc'     => 'Run AI models fast and affordably, through managed endpoints or on your own GPUs, with latency and cost per request tracked.',
                    'includes' => ['Serving with vLLM or managed endpoints', 'Batching, caching and routing between models', 'Load tests against p95 latency targets', 'Cost-per-request dashboard'],
                    'tags'     => ['LLM serving', 'p95 latency', 'Cost per request'],
                    'stack'    => ['vllm', 'nvidia', 'kubernetes', 'ray'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products with growing AI traffic, data-residency rules or rising model bills.',
                ],
            ]],

            ['key' => 'run-protect', 'name' => 'Run & protect', 'icon' => 'shield', 'offers' => [
                [
                    'key'      => 'cloud-migration',
                    'cap'      => 'ai-infrastructure-cloud',
                    'name'     => 'Cloud migration & foundations',
                    'desc'     => 'Move to AWS, Azure or Google Cloud, or tidy what you already run there, with secure foundations set up as code.',
                    'includes' => ['Discovery and a migration plan per application', 'Landing zone with identity, networking and guardrails', 'Infrastructure as code', 'Cutover with a rollback plan'],
                    'tags'     => ['AWS', 'Azure', 'Google Cloud'],
                    'stack'    => ['amazonwebservices', 'microsoftazure', 'googlecloud', 'terraform', 'kubernetes'],
                    'time'     => '8–20 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations leaving a data centre or reorganising a cloud estate.',
                ],
                [
                    'key'      => 'pentest',
                    'cap'      => 'cybersecurity-ai-trust',
                    'name'     => 'Penetration test (VAPT)',
                    'desc'     => 'Security specialists test your website, app, API or cloud the way an attacker would, under an agreed scope, and show you what to fix.',
                    'includes' => ['Scope and rules of engagement', 'Manual testing against OWASP guidance', 'Severity-rated findings with evidence', 'Fix guidance and a retest of fixed findings'],
                    'tags'     => ['Web · mobile', 'API · cloud', 'OWASP'],
                    'stack'    => ['burpsuite', 'owasp'],
                    'time'     => '1–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses before launch, after major changes or when a customer asks for a report.',
                ],
                [
                    'key'      => 'compliance-readiness',
                    'cap'      => 'cybersecurity-ai-trust',
                    'name'     => 'Compliance readiness',
                    'desc'     => 'Get ready for ISO/IEC 27001:2022, SOC 2 or India’s DPDP Act 2023. We find the gaps, help put the controls in place and prepare the evidence; certificates and attestation reports come from independent auditors.',
                    'includes' => ['Gap assessment against the framework', 'Risk assessment and policies', 'Control implementation support', 'Evidence collection and audit support'],
                    'tags'     => ['ISO/IEC 27001:2022', 'SOC 2', 'DPDP Act 2023'],
                    'stack'    => [],
                    'time'     => '8–24 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies whose customers or regulators ask for proof of security.',
                ],
                [
                    'key'      => 'system-integration',
                    'cap'      => 'integration-support',
                    'name'     => 'System integration',
                    'desc'     => 'Connect your CRM, ERP, payments and other tools so data moves between them automatically, once and correctly.',
                    'includes' => ['Integration map and data contracts', 'APIs, events or iPaaS flows with retries', 'Contract tests and monitoring', 'Runbooks for support'],
                    'tags'     => ['APIs', 'iPaaS', 'Events'],
                    'stack'    => ['salesforce', 'hubspot', 'sap', 'razorpay', 'mulesoft', 'n8n'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams re-keying the same data into several systems.',
                ],
                [
                    'key'      => 'managed-support',
                    'cap'      => 'integration-support',
                    'name'     => 'Managed support with SLAs',
                    'desc'     => 'Engineers who monitor your systems, respond to incidents within agreed times, keep everything patched and report to you every month.',
                    'includes' => ['Response and resolution targets by severity', 'Monitoring and alerting', 'Security patches and upgrades', 'Monthly service review'],
                    'tags'     => ['SLA', 'Monitoring', 'Monthly report'],
                    'stack'    => ['pagerduty', 'datadog', 'sentry'],
                    'time'     => 'Onboarding 2–4 weeks, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses whose systems matter too much to run without cover.',
                ],
            ]],

            ['key' => 'grow-assess', 'name' => 'Grow & assess', 'icon' => 'trend-up', 'offers' => [
                [
                    'key'      => 'seo-programme',
                    'cap'      => 'search-ai-visibility',
                    'name'     => 'SEO programme',
                    'desc'     => 'Rank higher in Google and Bing through technical fixes, useful content and a site search engines can read easily.',
                    'includes' => ['Technical SEO audit and fixes', 'Topic and content plan', 'Structured data in JSON-LD', 'Monthly reporting against a baseline'],
                    'tags'     => ['Technical SEO', 'Content', 'Reporting'],
                    'stack'    => ['googlesearchconsole', 'semrush', 'googleanalytics', 'schemaorg'],
                    'time'     => '90-day cycles, ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses where search is a main source of customers.',
                ],
                [
                    'key'      => 'ai-visibility',
                    'cap'      => 'search-ai-visibility',
                    'name'     => 'AI search visibility (AEO & GEO)',
                    'desc'     => 'Get your brand named and cited when people ask ChatGPT, Perplexity, Gemini or Google’s AI Overviews, and measure how often it happens.',
                    'includes' => ['Baseline across the main answer engines', 'Answer-first content and clear entity facts', 'Citations from trusted sources', 'Monthly share-of-answer tracking'],
                    'tags'     => ['AEO', 'GEO', 'AI Overviews'],
                    'stack'    => ['openai', 'perplexity', 'googlegemini', 'schemaorg'],
                    'time'     => '8–12 weeks, then ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose customers now research by asking an AI assistant.',
                ],
                [
                    'key'      => 'tech-audit',
                    'cap'      => 'audits-assessments',
                    'name'     => 'Technical & code audit',
                    'desc'     => 'An independent review of your code, architecture and delivery process, with a ranked list of what to fix and what each problem is costing you.',
                    'includes' => ['Code quality and architecture review', 'Security and dependency checks', 'Delivery review with DORA metrics', 'Ranked backlog and a 30-60-90-day plan'],
                    'tags'     => ['Code', 'Architecture', 'Tech debt'],
                    'stack'    => ['sonarqubecloud', 'snyk', 'github'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Before a funding round, replatform, acquisition or vendor change.',
                ],
                [
                    'key'      => 'ai-readiness',
                    'cap'      => 'audits-assessments',
                    'name'     => 'AI readiness assessment',
                    'desc'     => 'A scored read on how ready your data, systems, skills and governance are for AI, and what to fix before the first build.',
                    'includes' => ['Readiness score across data, infrastructure, skills and governance', 'Use-case readiness review', 'Risk and compliance check', 'Prerequisite roadmap'],
                    'tags'     => ['Readiness score', 'Prerequisites'],
                    'stack'    => [],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations planning an AI programme or a first AI build.',
                ],
            ]],

            ['key' => 'talent', 'name' => 'Talent', 'icon' => 'users', 'offers' => [
                [
                    'key'      => 'dedicated-squad',
                    'cap'      => 'tech-workforce',
                    'name'     => 'Dedicated squad',
                    'desc'     => 'A cross-functional team of engineers, QA and design, led by a delivery lead, working in your stack and sprints and accountable for an outcome.',
                    'includes' => ['Squad shaped to the outcome', 'Delivery lead and agreed goals', 'Work in your tools and ceremonies', 'Monthly delivery review'],
                    'tags'     => ['Squad', 'Outcome-owned', 'Your cadence'],
                    'stack'    => ['jira', 'linear', 'github', 'figma'],
                    'time'     => 'Start in 2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies with a clear product goal and no team free to deliver it.',
                ],
                [
                    'key'      => 'engineers-by-role',
                    'cap'      => 'tech-workforce',
                    'name'     => 'Engineers by role',
                    'desc'     => 'Add vetted frontend, backend, mobile, DevOps, data or AI engineers to your existing team, for as long as you need them.',
                    'includes' => ['Engineers vetted in your stack', 'You interview and choose', 'Onboarding with a first merged change in week one', 'Monthly quality and fit review'],
                    'tags'     => ['Staff augmentation', 'Vetted', 'Flexible'],
                    'stack'    => ['typescript', 'python', 'react', 'kotlin', 'kubernetes'],
                    'time'     => 'Start in 2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with more roadmap than people.',
                ],
                [
                    'key'      => 'fractional-cto',
                    'cap'      => 'tech-workforce',
                    'name'     => 'Fractional CTO or tech lead',
                    'desc'     => 'Senior technical leadership for part of the week: direction, architecture decisions, hiring and a clear voice for technology at board level.',
                    'includes' => ['Technology strategy and roadmap', 'Architecture and vendor decisions', 'Hiring plan and interviews', 'Board and investor updates'],
                    'tags'     => ['Leadership', 'Part-time'],
                    'stack'    => [],
                    'time'     => 'Ongoing, set days each month',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Start-ups and growing companies not yet ready for a full-time CTO.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer', 'enterprise', 'squad'],
    ],

    /* =============================================================================================
       01 · Websites & Apps
       ============================================================================================= */
    'websites-apps' => [
        'discipline' => 'technology-intelligence',
        'title'      => '<span class="g">Websites, web apps and mobile apps,</span> built for real usage.',
        'lead'       => 'Choose what you need built. Every build ships with performance budgets, accessibility checks and monitoring in place, and the code lives in your repositories from the first commit.',
        'categories' => [

            ['key' => 'websites', 'name' => 'Websites', 'icon' => 'browser', 'offers' => [
                [
                    'key'      => 'corporate-website',
                    'name'     => 'Corporate website',
                    'desc'     => 'The main website for your company: who you are, what you offer and how to reach you. Built to load fast, read well on any device and be easy for your team to update.',
                    'includes' => ['Sitemap, content model and page templates', 'Editable CMS with roles and previews', 'SEO foundations and Schema.org markup', 'Core Web Vitals and WCAG 2.2 AA checks before launch', 'Analytics and consent set-up'],
                    'tags'     => ['Headless or WordPress', 'WCAG 2.2 AA', 'Core Web Vitals'],
                    'stack'    => ['nextdotjs', 'wordpress', 'contentful', 'sanity', 'vercel'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies replacing an outdated site or launching a new brand.',
                ],
                [
                    'key'      => 'campaign-microsite',
                    'name'     => 'Marketing & campaign microsites',
                    'desc'     => 'A focused site for a product launch, event or campaign, designed to turn visitors into leads and ready on your launch date.',
                    'includes' => ['Landing pages built from reusable blocks', 'Forms connected to your CRM', 'A/B testing and conversion tracking', 'Launch-day load testing'],
                    'tags'     => ['Landing pages', 'Conversion tracking', 'Fast turnaround'],
                    'stack'    => ['astro', 'nextdotjs', 'webflow', 'hubspot', 'googletagmanager'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing teams with a launch date and a target to hit.',
                ],
                [
                    'key'      => 'ecommerce-store',
                    'name'     => 'E-commerce store',
                    'desc'     => 'An online store where customers browse, pay and track orders. Built on Shopify or WooCommerce, or as a headless storefront when you need more speed and control.',
                    'includes' => ['Catalogue, cart, checkout and order emails', 'Payments through Razorpay, Stripe or PayPal', 'Inventory, shipping and tax set-up', 'Product feeds and e-commerce analytics events', 'Headless storefront option for custom journeys'],
                    'tags'     => ['Shopify', 'WooCommerce', 'Headless commerce'],
                    'stack'    => ['shopify', 'woocommerce', 'nextdotjs', 'razorpay', 'stripe'],
                    'time'     => '6–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands selling online directly, from a first store to a replatform.',
                ],
                [
                    'key'      => 'multilingual-website',
                    'name'     => 'Multilingual & multi-region website',
                    'desc'     => 'One website that serves several languages or countries, showing each market the right content, currency and search listing.',
                    'includes' => ['Locale structure: subfolders, subdomains or country domains', 'Translation workflow inside the CMS', 'hreflang tags and regional sitemaps', 'Right-to-left scripts and local formats where needed'],
                    'tags'     => ['i18n', 'hreflang', 'Localised CMS'],
                    'stack'    => ['nextdotjs', 'contentful', 'sanity', 'strapi', 'cloudflare'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations selling or operating in more than one country or language.',
                ],
                [
                    'key'      => 'cms-headless',
                    'name'     => 'CMS & headless builds',
                    'desc'     => 'A content system your editors can run without a developer, on WordPress, Contentful, Sanity or Strapi. The front end is kept separate, so pages stay fast as content grows.',
                    'includes' => ['Content model designed with your editors', 'Editorial workflow, roles and scheduled publishing', 'Live preview and reusable content blocks', 'Migration of existing content', 'Editor training'],
                    'tags'     => ['Headless CMS', 'Structured content', 'Editor-friendly'],
                    'stack'    => ['wordpress', 'contentful', 'sanity', 'strapi', 'nextdotjs'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams that publish often and feel held back by their current CMS.',
                ],
                [
                    'key'      => 'portal-intranet',
                    'name'     => 'Portals & intranets',
                    'desc'     => 'A signed-in website for employees, members or partners, showing each person the documents, news and tools they are allowed to see.',
                    'includes' => ['Single sign-on with your identity provider', 'Role-based content and permissions', 'Search across pages and documents', 'Notifications and activity feeds'],
                    'tags'     => ['SSO', 'Role-based access', 'Search'],
                    'stack'    => ['nextdotjs', 'okta', 'auth0', 'algolia', 'postgresql'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations sharing information with staff, members or partners behind a login.',
                ],
            ]],

            ['key' => 'web-applications', 'name' => 'Web applications', 'icon' => 'code', 'offers' => [
                [
                    'key'      => 'saas-mvp',
                    'name'     => 'SaaS MVP',
                    'desc'     => 'The first working version of a software product, built to put in front of paying customers quickly and to grow without a rewrite.',
                    'includes' => ['Scope workshop to cut the MVP to what matters', 'Sign-up, accounts, roles and subscription billing', 'Core product workflows and an admin area', 'Product analytics and error tracking', 'Multi-tenant architecture that scales past the first customers'],
                    'tags'     => ['MVP', 'Subscription billing', 'Multi-tenant'],
                    'stack'    => ['nextdotjs', 'typescript', 'postgresql', 'stripe', 'supabase', 'vercel'],
                    'time'     => '10–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Founders and product teams validating a new product.',
                ],
                [
                    'key'      => 'customer-portal',
                    'name'     => 'Customer & partner portals',
                    'desc'     => 'A secure place where customers or partners log in to place orders, track requests, download documents or manage their account.',
                    'includes' => ['Accounts, roles and single sign-on', 'Connection to your CRM or ERP', 'Self-service requests with status tracking', 'Audit trail of key actions'],
                    'tags'     => ['Self-service', 'SSO', 'CRM-connected'],
                    'stack'    => ['react', 'nestjs', 'postgresql', 'auth0', 'salesforce'],
                    'time'     => '10–18 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses that want fewer emails and calls about routine requests.',
                ],
                [
                    'key'      => 'dashboards-admin',
                    'name'     => 'Dashboards & admin panels',
                    'desc'     => 'Screens that show your team what is happening and let them act on it: approve, edit, assign and export, without touching the database.',
                    'includes' => ['Role-based admin screens', 'Charts and tables on live data', 'Bulk actions, filters and exports', 'Activity log of every change'],
                    'tags'     => ['Admin UI', 'Live data', 'Role-based access'],
                    'stack'    => ['react', 'typescript', 'graphql', 'postgresql', 'tailwindcss'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Operations teams working from spreadsheets or raw database tools.',
                ],
                [
                    'key'      => 'pwa',
                    'name'     => 'Progressive web apps (PWA)',
                    'desc'     => 'A website that installs on a phone like an app, works on poor connections and can send notifications, without going through the app stores.',
                    'includes' => ['Installable app shell and icons', 'Offline support and background sync', 'Push notifications', 'Performance and installability checks in Lighthouse'],
                    'tags'     => ['Offline-first', 'Installable', 'Push notifications'],
                    'stack'    => ['react', 'nextdotjs', 'firebase', 'lighthouse'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products that need app-like use without the cost of two native apps.',
                ],
                [
                    'key'      => 'booking-marketplace',
                    'name'     => 'Booking & marketplace platforms',
                    'desc'     => 'Platforms where customers book time, services or products from you or from many sellers, with payments, schedules and payouts handled for you.',
                    'includes' => ['Listings, search and filters', 'Availability, booking and reminders', 'Payments, refunds and seller payouts', 'Reviews and dispute handling', 'Seller and admin dashboards'],
                    'tags'     => ['Bookings', 'Split payments', 'Multi-vendor'],
                    'stack'    => ['nextdotjs', 'nestjs', 'postgresql', 'razorpay', 'stripe', 'algolia'],
                    'time'     => '12–20 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Service businesses and marketplaces connecting buyers with providers.',
                ],
                [
                    'key'      => 'design-system',
                    'name'     => 'Design system & component library',
                    'desc'     => 'A shared library of buttons, forms and page parts in code, so every screen looks consistent and new features ship faster.',
                    'includes' => ['Design tokens for colour, type and spacing', 'Coded components documented in Storybook', 'Accessibility tests on every component', 'Figma-to-code workflow for designers and engineers'],
                    'tags'     => ['Tokens', 'Components', 'Storybook'],
                    'stack'    => ['figma', 'storybook', 'react', 'tailwindcss'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies with several products or teams building the same interface twice.',
                ],
            ]],
            ['key' => 'custom-stacks', 'name' => 'Custom-stack builds', 'icon' => 'stack', 'offers' => [
                [
                    'key'      => 'laravel',
                    'name'     => 'Laravel (PHP)',
                    'desc'     => 'A mature PHP framework with sign-in, queues and admin tools built in, so business features come together quickly. Choose it for business applications, portals and APIs, especially if your team or hosting already runs PHP.',
                    'includes' => ['Laravel application with automated tests', 'Queues, scheduled jobs and caching', 'REST API with OpenAPI documentation', 'CI/CD and deployment to your cloud'],
                    'tags'     => ['PHP', 'Laravel', 'REST API'],
                    'stack'    => ['laravel', 'php', 'postgresql', 'redis', 'docker'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Business applications, portals and teams already running PHP.',
                ],
                [
                    'key'      => 'mern',
                    'name'     => 'MERN (MongoDB, Express, React, Node.js)',
                    'desc'     => 'JavaScript from the database to the browser, with a flexible document database. Choose it when your data changes shape often and one JavaScript team should own the whole product.',
                    'includes' => ['React front end and Node.js/Express API', 'MongoDB schema design and indexes', 'Authentication and role-based access', 'Automated tests and CI/CD'],
                    'tags'     => ['JavaScript', 'MongoDB', 'Express'],
                    'stack'    => ['mongodb', 'react', 'nodedotjs', 'typescript'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Fast-moving products with changing data and a JavaScript team.',
                ],
                [
                    'key'      => 'mean',
                    'name'     => 'MEAN (MongoDB, Express, Angular, Node.js)',
                    'desc'     => 'The same JavaScript foundation with Angular on the front end, which brings firm structure to large forms and data-heavy screens. Choose it for complex internal and enterprise applications.',
                    'includes' => ['Angular front end with typed components', 'Node.js/Express API', 'MongoDB data model', 'Unit and end-to-end tests'],
                    'tags'     => ['Angular', 'TypeScript', 'Enterprise UI'],
                    'stack'    => ['mongodb', 'angular', 'nodedotjs', 'typescript'],
                    'time'     => '10–18 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Enterprise teams standardised on Angular or building form-heavy tools.',
                ],
                [
                    'key'      => 'nextjs-node',
                    'name'     => 'Next.js & Node.js',
                    'desc'     => 'React with pages prepared on the server, so they load fast and search engines read them easily. Choose it when one product has public marketing pages and a signed-in app.',
                    'includes' => ['Next.js app with server and static rendering', 'Node.js or NestJS API layer', 'Edge caching and image optimisation', 'Preview deployment for every change'],
                    'tags'     => ['React', 'Server rendering', 'TypeScript'],
                    'stack'    => ['nextdotjs', 'react', 'nodedotjs', 'nestjs', 'typescript', 'vercel'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products where speed, SEO and a signed-in app live together.',
                ],
                [
                    'key'      => 'django-fastapi',
                    'name'     => 'Django & FastAPI (Python)',
                    'desc'     => 'Python on the back end: Django for data-heavy applications with a ready-made admin, FastAPI for fast, well-documented APIs. Choose it when the product works closely with data, analytics or AI.',
                    'includes' => ['Django or FastAPI service with typed models', 'Admin interface and background workers', 'API documentation generated from the code', 'Hooks for data and machine-learning pipelines'],
                    'tags'     => ['Python', 'Django', 'FastAPI'],
                    'stack'    => ['python', 'django', 'fastapi', 'postgresql', 'redis'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Data- and AI-heavy products, and teams that work in Python.',
                ],
                [
                    'key'      => 'java-dotnet',
                    'name'     => 'Spring Boot (Java) & .NET',
                    'desc'     => 'Established enterprise frameworks with long support windows. Choose them when the product has to fit an existing Java or Microsoft estate and its security standards.',
                    'includes' => ['Spring Boot or ASP.NET Core services', 'Integration with enterprise identity and messaging', 'Static analysis and security scanning in CI', 'Containerised deployment'],
                    'tags'     => ['Java', '.NET', 'Enterprise'],
                    'stack'    => ['springboot', 'openjdk', 'dotnet', 'postgresql', 'microsoftazure'],
                    'time'     => '10–20 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Enterprises with Java or Microsoft standards to meet.',
                ],
            ]],

            ['key' => 'mobile-apps', 'name' => 'Mobile apps', 'icon' => 'mobile', 'offers' => [
                [
                    'key'      => 'ios-native',
                    'name'     => 'Native iOS app (Swift & SwiftUI)',
                    'desc'     => 'An iPhone and iPad app built with Apple’s own tools, for the smoothest feel and full use of device features such as the camera, payments, health data and widgets.',
                    'includes' => ['SwiftUI interface following Apple’s Human Interface Guidelines', 'Offline storage and sync', 'Push notifications and deep links', 'App Store Connect set-up and TestFlight builds'],
                    'tags'     => ['Swift', 'SwiftUI', 'App Store'],
                    'stack'    => ['swift', 'ios', 'firebase'],
                    'time'     => '10–18 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products where iPhone users matter most or deep device features are needed.',
                ],
                [
                    'key'      => 'android-native',
                    'name'     => 'Native Android app (Kotlin & Jetpack Compose)',
                    'desc'     => 'An Android app built with Google’s recommended tools and tuned for the wide range of phones and tablets your customers actually use.',
                    'includes' => ['Jetpack Compose interface following Material Design', 'Offline storage and background work', 'Push notifications and deep links', 'Play Console set-up and staged rollouts'],
                    'tags'     => ['Kotlin', 'Jetpack Compose', 'Google Play'],
                    'stack'    => ['kotlin', 'android', 'jetpackcompose', 'firebase'],
                    'time'     => '10–18 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Markets where Android leads, such as India, or apps that use device hardware.',
                ],
                [
                    'key'      => 'flutter',
                    'name'     => 'Cross-platform app (Flutter)',
                    'desc'     => 'One codebase that ships to both iOS and Android with a consistent, branded look. Usually faster and less costly than building two native apps.',
                    'includes' => ['Shared Flutter codebase for iOS and Android', 'Platform channels for native features', 'Offline support and push notifications', 'Submission to both stores'],
                    'tags'     => ['Flutter', 'Dart', 'iOS + Android'],
                    'stack'    => ['flutter', 'firebase', 'ios', 'android'],
                    'time'     => '10–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams that want both platforms from one budget and a custom interface.',
                ],
                [
                    'key'      => 'react-native',
                    'name'     => 'Cross-platform app (React Native & Expo)',
                    'desc'     => 'One JavaScript codebase for iOS and Android that can share logic and people with your React website. Many updates reach users quickly through over-the-air releases.',
                    'includes' => ['React Native app built with Expo', 'Shared code and types with your web app', 'Over-the-air updates for non-native changes', 'Store builds and submission'],
                    'tags'     => ['React Native', 'Expo', 'TypeScript'],
                    'stack'    => ['reactnative', 'expo', 'typescript', 'react'],
                    'time'     => '10–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies with a React web team that want to reuse skills and code.',
                ],
                [
                    'key'      => 'app-modernisation',
                    'name'     => 'App modernisation & store launch',
                    'desc'     => 'Rescue, upgrade or relaunch an existing app: fix crashes, update ageing libraries, move to current frameworks and take it through store review.',
                    'includes' => ['Code and crash review with a fix plan', 'OS, SDK and dependency upgrades', 'Crash reporting and performance monitoring', 'Store listing, review and release management'],
                    'tags'     => ['Upgrade', 'Crash-free sessions', 'Store review'],
                    'stack'    => ['swift', 'kotlin', 'flutter', 'reactnative', 'sentry'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Apps with falling ratings, rising crashes or an outdated codebase.',
                ],
            ]],

            ['key' => 'performance-care', 'name' => 'Performance, accessibility & care', 'icon' => 'gauge', 'offers' => [
                [
                    'key'      => 'core-web-vitals',
                    'name'     => 'Core Web Vitals & speed',
                    'desc'     => 'Make your site measurably faster for real visitors, and keep it that way. Google’s “good” thresholds are LCP ≤ 2.5 s, INP ≤ 200 ms and CLS ≤ 0.1, measured at the 75th percentile.',
                    'includes' => ['Field-data baseline from Chrome UX Report and real-user monitoring', 'Fixes to images, fonts, scripts and rendering', 'Performance budgets that fail the build', 'Before-and-after report'],
                    'tags'     => ['LCP ≤ 2.5 s', 'INP ≤ 200 ms', 'CLS ≤ 0.1'],
                    'stack'    => ['pagespeedinsights', 'lighthouse', 'cloudflare', 'nextdotjs'],
                    'time'     => '2–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sites losing visitors or rankings to slow pages.',
                ],
                [
                    'key'      => 'accessibility-wcag',
                    'name'     => 'Accessibility to WCAG 2.2 AA',
                    'desc'     => 'Make your site usable by people with disabilities, including screen-reader and keyboard users, and reduce legal risk. Built and tested to WCAG 2.2 Level AA.',
                    'includes' => ['Automated and manual testing with assistive technology', 'Fixes to code, content and components', 'Accessible design-system components', 'Accessibility statement and regression checks in CI'],
                    'tags'     => ['WCAG 2.2 AA', 'Screen readers', 'Keyboard access'],
                    'stack'    => ['playwright', 'storybook', 'lighthouse'],
                    'time'     => '3–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Public-facing services, regulated sectors and teams with accessibility obligations.',
                ],
                [
                    'key'      => 'care-plan',
                    'name'     => 'Website & app maintenance',
                    'desc'     => 'Keep your site or app secure, updated and working after launch, with a set number of hours each month for fixes and small improvements.',
                    'includes' => ['Security patches and dependency upgrades', 'Uptime and error monitoring', 'Backups with regular restore checks', 'Agreed monthly hours for changes', 'Monthly report'],
                    'tags'     => ['Monthly plan', 'Monitoring', 'Security updates'],
                    'stack'    => ['sentry', 'github', 'cloudflare'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses without an in-house web team.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer', 'squad'],
    ],

    /* =============================================================================================
       02 · Custom Software & Data Platforms
       ============================================================================================= */
    'custom-software-data-platforms' => [
        'discipline' => 'technology-intelligence',
        'title'      => '<span class="g">Software shaped to how you work,</span> and data you can trust.',
        'lead'       => 'When off-the-shelf tools stop fitting, we build the systems your business runs on: CRMs, operations platforms, internal tools and the data platforms behind your reporting. Your process, your data model, your cloud and your IP.',
        'categories' => [

            ['key' => 'business-systems', 'name' => 'Business systems', 'icon' => 'workflow', 'offers' => [
                [
                    'key'      => 'custom-crm',
                    'name'     => 'Custom CRM',
                    'desc'     => 'A customer system built around how your team actually sells and serves, instead of bending your process to fit a packaged product.',
                    'includes' => ['Leads, accounts, deals and service cases modelled on your process', 'Email, call and WhatsApp activity in one timeline', 'Role-based access and an audit trail', 'Pipeline reports and dashboards', 'Integrations with marketing, billing and support tools'],
                    'tags'     => ['Built to your process', 'No per-seat licence', 'Audit trail'],
                    'stack'    => ['typescript', 'nestjs', 'postgresql', 'react', 'whatsapp'],
                    'time'     => '12–20 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies whose sales or service process has outgrown a generic CRM.',
                ],
                [
                    'key'      => 'erp-operations',
                    'name'     => 'ERP & operations systems',
                    'desc'     => 'Software for the core of the business, such as orders, inventory, procurement, production or field work, connected in one system.',
                    'includes' => ['Build, buy or extend decision for each module', 'Order, inventory and procurement workflows', 'Integration with accounting and existing ERPs such as SAP or Zoho', 'Data migration with reconciliation reports'],
                    'tags'     => ['Operations', 'Inventory', 'ERP integration'],
                    'stack'    => ['springboot', 'postgresql', 'sap', 'zoho', 'apachekafka'],
                    'time'     => '16–32 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Growing businesses running operations on spreadsheets or a patchwork of tools.',
                ],
                [
                    'key'      => 'cdp',
                    'name'     => 'Customer data platform (CDP)',
                    'desc'     => 'One consented, deduplicated view of every customer, built from your website, app, CRM and sales data, that marketing, sales and service all read from.',
                    'includes' => ['Identity resolution across channels', 'Consent capture and enforcement for GDPR and the DPDP Act 2023', 'Real-time segments synced to email and ad tools', 'Composable build on your warehouse, or packaged CDP selection'],
                    'tags'     => ['Identity resolution', 'Consent', 'Composable CDP'],
                    'stack'    => ['snowflake', 'googlebigquery', 'dbt', 'apachekafka', 'hubspot'],
                    'time'     => '12–20 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose customer data is split across tools that disagree.',
                ],
                [
                    'key'      => 'workflow-approvals',
                    'name'     => 'Workflow & approval systems',
                    'desc'     => 'Digital forms and approval flows that replace email chains. Requests reach the right person, deadlines are tracked and every decision is recorded.',
                    'includes' => ['Forms, routing rules and escalations', 'Approval chains with delegation', 'Notifications by email, Slack or Teams', 'Audit log and turnaround reports'],
                    'tags'     => ['Approvals', 'SLA tracking', 'Audit log'],
                    'stack'    => ['temporal', 'react', 'postgresql', 'slack', 'microsoftteams'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Finance, HR, procurement and compliance teams chasing approvals by email.',
                ],
                [
                    'key'      => 'internal-tools',
                    'name'     => 'Internal tools & admin portals',
                    'desc'     => 'Back-office tools that replace spreadsheets and manual database edits with safe screens, permissions and a record of who changed what.',
                    'includes' => ['Admin consoles on your existing data', 'Role-based permissions', 'Bulk edits, imports and exports', 'Change history for every record'],
                    'tags'     => ['Back office', 'Permissions', 'Change history'],
                    'stack'    => ['react', 'nodedotjs', 'postgresql', 'supabase'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Operations and support teams doing repetitive work by hand.',
                ],
            ]],

            ['key' => 'data-platforms', 'name' => 'Data platforms', 'icon' => 'database', 'offers' => [
                [
                    'key'      => 'warehouse-lakehouse',
                    'name'     => 'Data warehouse & lakehouse',
                    'desc'     => 'A single, governed home for your business data, so reports, analytics and AI all start from the same numbers.',
                    'includes' => ['Architecture choice: warehouse, lakehouse or both', 'Ingestion from your apps, CRM, ERP and ad platforms', 'Tested, version-controlled data models', 'Access controls and cost monitoring'],
                    'tags'     => ['Warehouse', 'Lakehouse', 'Governed'],
                    'stack'    => ['snowflake', 'databricks', 'googlebigquery', 'dbt', 'airbyte'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies with data in many tools and no single source of truth.',
                ],
                [
                    'key'      => 'data-pipelines',
                    'name'     => 'Data pipelines & ELT',
                    'desc'     => 'Automated feeds that move data from your systems into the warehouse on a schedule or in real time, and tell you when something breaks.',
                    'includes' => ['Connectors for SaaS tools and databases', 'Orchestrated pipelines with retries', 'Data quality tests and freshness alerts', 'Lineage from source to report'],
                    'tags'     => ['ELT', 'Orchestration', 'Data quality'],
                    'stack'    => ['airbyte', 'apacheairflow', 'dbt', 'apachespark', 'python'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose reports depend on manual exports and copy-and-paste.',
                ],
                [
                    'key'      => 'streaming-events',
                    'name'     => 'Streaming & event architecture',
                    'desc'     => 'Systems that react to events as they happen, such as an order placed or a payment failed, instead of waiting for an overnight batch.',
                    'includes' => ['Event design and a schema registry', 'Kafka or managed streaming set-up', 'Change data capture from existing databases', 'Replay, dead-letter handling and monitoring'],
                    'tags'     => ['Events', 'CDC', 'Real time'],
                    'stack'    => ['apachekafka', 'rabbitmq', 'clickhouse', 'postgresql'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses where minutes matter: logistics, payments, inventory and fraud.',
                ],
                [
                    'key'      => 'data-migration',
                    'name'     => 'Data migration',
                    'desc'     => 'Move data from an old system to a new one without losing records, with rehearsals and a way back if anything goes wrong.',
                    'includes' => ['Source-to-target mapping and cleansing rules', 'Rehearsed migration runs', 'Reconciliation reports: record counts, checksums and field samples', 'Cutover plan with a rollback path'],
                    'tags'     => ['Rehearsed', 'Reconciled', 'Reversible'],
                    'stack'    => ['python', 'postgresql', 'airbyte', 'dbt'],
                    'time'     => '4–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Any replatform, CRM switch or system retirement.',
                ],
            ]],

            ['key' => 'analytics-bi', 'name' => 'Analytics & BI', 'icon' => 'chart', 'offers' => [
                [
                    'key'      => 'bi-dashboards',
                    'name'     => 'BI dashboards',
                    'desc'     => 'Dashboards that leadership and teams actually use, with every number defined once and traceable to its source.',
                    'includes' => ['KPI definitions agreed with their owners', 'Dashboards in Power BI, Looker or your BI tool', 'Row-level security by team or region', 'Scheduled reports and alerts'],
                    'tags'     => ['KPIs', 'Power BI', 'Looker'],
                    'stack'    => ['powerbi', 'looker', 'googlebigquery', 'snowflake'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams reporting from conflicting spreadsheets.',
                ],
                [
                    'key'      => 'metric-layer',
                    'name'     => 'Semantic & metric layer',
                    'desc'     => 'One shared definition of revenue, active customer or churn, used by every dashboard, spreadsheet and AI tool.',
                    'includes' => ['Metric definitions written as code', 'Tests on key figures', 'Data dictionary and documentation', 'Access for BI tools and notebooks'],
                    'tags'     => ['One definition', 'Metrics as code', 'Data dictionary'],
                    'stack'    => ['dbt', 'looker', 'snowflake', 'duckdb'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations where two reports never show the same number.',
                ],
                [
                    'key'      => 'embedded-analytics',
                    'name'     => 'Embedded analytics',
                    'desc'     => 'Charts and reports inside your own product, so customers see their data without exporting it.',
                    'includes' => ['Multi-tenant analytics data model', 'Embedded charts in your branding', 'Per-customer permissions', 'Usage tracking'],
                    'tags'     => ['Customer-facing', 'Multi-tenant', 'Branded'],
                    'stack'    => ['clickhouse', 'react', 'postgresql', 'looker'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'SaaS and platform businesses whose customers ask for reporting.',
                ],
                [
                    'key'      => 'product-analytics',
                    'name'     => 'Product analytics set-up',
                    'desc'     => 'See how people use your app, where they drop off and which features they return to, with events planned rather than guessed.',
                    'includes' => ['Tracking plan and event naming', 'Implementation across web and mobile', 'Funnel, retention and cohort views', 'Consent-aware tracking'],
                    'tags'     => ['Tracking plan', 'Funnels', 'Retention'],
                    'stack'    => ['posthog', 'mixpanel', 'googleanalytics', 'googletagmanager'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product teams making roadmap decisions without usage data.',
                ],
            ]],

            ['key' => 'modernisation', 'name' => 'Legacy modernisation', 'icon' => 'sync', 'offers' => [
                [
                    'key'      => 'legacy-assessment',
                    'name'     => 'Legacy system assessment',
                    'desc'     => 'A clear read on an old system: what it does, what it costs to keep, what breaks if it stops and the safest way to replace it.',
                    'includes' => ['Code, data and dependency review', 'Business rules recovered with the people who use the system', 'Options: retain, rehost, refactor or replace', 'Costed modernisation roadmap'],
                    'tags'     => ['Discovery', 'Options', 'Roadmap'],
                    'stack'    => ['sonarqubecloud', 'openjdk', 'dotnet', 'php'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations with a critical system that few people understand.',
                ],
                [
                    'key'      => 'incremental-rebuild',
                    'name'     => 'Incremental rebuild (strangler pattern)',
                    'desc'     => 'Replace an old system piece by piece while it keeps running, so there is never a risky all-at-once switch.',
                    'includes' => ['API layer around the legacy system', 'Module-by-module replacement behind feature flags', 'Data kept in sync between old and new', 'Retirement plan for the old system'],
                    'tags'     => ['Strangler pattern', 'No big bang', 'Feature flags'],
                    'stack'    => ['kong', 'apachekafka', 'springboot', 'nestjs', 'docker'],
                    'time'     => '16–40 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Systems too important to switch off and too costly to keep as they are.',
                ],
                [
                    'key'      => 'cloud-replatform',
                    'name'     => 'Replatform to the cloud',
                    'desc'     => 'Move an on-premise or ageing application to modern cloud hosting, with containers, automated deployment and tested backups.',
                    'includes' => ['Containerisation of the application', 'Infrastructure as code', 'CI/CD pipeline', 'Backup and restore tests'],
                    'tags'     => ['Containers', 'IaC', 'CI/CD'],
                    'stack'    => ['docker', 'kubernetes', 'terraform', 'amazonwebservices', 'microsoftazure'],
                    'time'     => '6–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Applications on end-of-life servers or hosting.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'milestone', 'project', 'enterprise', 'squad'],
    ],

    /* =============================================================================================
       03 · AI Strategy & Agents
       ============================================================================================= */
    'ai-strategy-agents' => [
        'discipline' => 'technology-intelligence',
        'title'      => '<span class="g">Decide where AI pays off,</span> then build the agents that do the work.',
        'lead'       => 'Start with a clear view of where AI fits your business and what to build first. Then we design and build agents and copilots that take on real tasks, tested against evaluations and overseen by your people.',
        'categories' => [

            ['key' => 'strategy', 'name' => 'AI strategy', 'icon' => 'compass', 'offers' => [
                [
                    'key'      => 'readiness-opportunity',
                    'name'     => 'AI readiness & opportunity mapping',
                    'desc'     => 'We review your processes, data and systems with the teams who run them, and find where AI would save real time, cost or risk.',
                    'includes' => ['Leadership and team interviews', 'Process walk-throughs and data review', 'Opportunity map with value and effort', 'Data and systems readiness read'],
                    'tags'     => ['Discovery', 'Opportunity map', 'Readiness'],
                    'stack'    => [],
                    'time'     => '3–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams under pressure to act on AI who want to start in the right place.',
                ],
                [
                    'key'      => 'use-case-portfolio',
                    'name'     => 'Use-case portfolio & business case',
                    'desc'     => 'Every AI idea scored on value, feasibility, data readiness and risk, then sequenced into a funded plan with owners and success measures.',
                    'includes' => ['Scoring model for value, feasibility and risk', 'Cost and benefit estimate per use case', 'Sequenced 12-month roadmap', 'Success measures and baselines'],
                    'tags'     => ['Scored', 'Sequenced', 'Business case'],
                    'stack'    => [],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with a long list of AI ideas and a limited budget.',
                ],
                [
                    'key'      => 'model-selection',
                    'name'     => 'Model & platform selection',
                    'desc'     => 'Choose the right model and AI platform for each task by testing them on your own examples for quality, speed, cost and where data is stored.',
                    'includes' => ['Shortlist across OpenAI, Anthropic, Google, Mistral and open-weight models', 'Side-by-side tests on your tasks', 'Cost-per-task and latency estimates', 'Data residency and contract terms reviewed'],
                    'tags'     => ['Model-agnostic', 'Tested on your data'],
                    'stack'    => ['openai', 'anthropic', 'googlegemini', 'mistralai', 'meta'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams unsure which model or vendor to commit to.',
                ],
                [
                    'key'      => 'leadership-briefing',
                    'name'     => 'Leadership AI briefing',
                    'desc'     => 'A working session for your board or leadership team on what AI can and cannot do today, grounded in your sector and your own data.',
                    'includes' => ['Pre-read tailored to your business', 'Live demonstrations on relevant tasks', 'Risk and governance primer', 'Agreed next steps'],
                    'tags'     => ['Workshop', 'Leadership'],
                    'stack'    => [],
                    'time'     => '1–2 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Boards and leadership teams starting their AI plan.',
                ],
            ]],

            ['key' => 'agents-copilots', 'name' => 'Agents & copilots', 'icon' => 'agent', 'offers' => [
                [
                    'key'      => 'custom-agent',
                    'name'     => 'Custom AI agent',
                    'desc'     => 'Software that plans and carries out multi-step tasks in your systems, such as checking an order, updating a record or drafting a reply, and hands over to a person when it should.',
                    'includes' => ['Task design with scoped tool permissions', 'Integration with your APIs and systems', 'Human approval for consequential actions', 'Full action log and audit trail', 'Evaluation suite before go-live'],
                    'tags'     => ['Tool use', 'Human in the loop', 'Audit log'],
                    'stack'    => ['langgraph', 'anthropic', 'openai', 'python', 'temporal'],
                    'time'     => '8–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with repetitive, rules-heavy work spread across several systems.',
                ],
                [
                    'key'      => 'team-copilot',
                    'name'     => 'Copilots for teams',
                    'desc'     => 'An assistant inside the tools your people already use, such as Slack, Teams or your CRM, answering from your documents and data rather than the open internet.',
                    'includes' => ['Connection to approved knowledge sources', 'Permission-aware answers with citations', 'Deployment in Slack, Teams or a web app', 'Usage and feedback analytics'],
                    'tags'     => ['Grounded', 'Cited', 'In your tools'],
                    'stack'    => ['microsoftteams', 'slack', 'llamaindex', 'anthropic', 'openai'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sales, support, HR and operations teams looking for answers all day.',
                ],
                [
                    'key'      => 'multi-agent',
                    'name'     => 'Multi-agent workflows',
                    'desc'     => 'Several specialised agents working together on a larger process, such as research, drafting, checking and filing, with clear handoffs and checkpoints.',
                    'includes' => ['Workflow and agent role design', 'Orchestration with state and retries', 'Checkpoints for human review', 'Cost and step limits'],
                    'tags'     => ['Orchestration', 'Checkpoints', 'Limits'],
                    'stack'    => ['langgraph', 'temporal', 'python', 'anthropic'],
                    'time'     => '10–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Complex processes that already follow documented steps.',
                ],
                [
                    'key'      => 'agent-tools-mcp',
                    'name'     => 'Agent tools & MCP integrations',
                    'desc'     => 'Connect agents safely to your internal systems through well-defined tools, including Model Context Protocol (MCP) servers, with least-privilege access.',
                    'includes' => ['Tool and MCP server design', 'Authentication and scoped permissions', 'Rate and spend limits', 'Logging of every tool call'],
                    'tags'     => ['MCP', 'Least privilege', 'Tool calls'],
                    'stack'    => ['python', 'fastapi', 'openapiinitiative', 'okta'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies that want agents to act in internal systems without over-broad access.',
                ],
            ]],

            ['key' => 'pilots-evals', 'name' => 'Pilots & evaluation', 'icon' => 'eval', 'offers' => [
                [
                    'key'      => 'pilot-with-evals',
                    'name'     => 'AI pilot with evaluations',
                    'desc'     => 'A time-boxed pilot of one use case, measured against a baseline, so the go or no-go decision rests on evidence rather than a demo.',
                    'includes' => ['Baseline measure before the pilot', 'Task-level evaluation set built with your experts', 'Shadow-mode run, then supervised live use', 'Decision record and rollout plan'],
                    'tags'     => ['Baseline', 'Shadow mode', 'Go / no-go'],
                    'stack'    => ['langchain', 'python', 'mlflow'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations ready to test one use case properly before scaling.',
                ],
                [
                    'key'      => 'eval-suite',
                    'name'     => 'Evaluation suite design',
                    'desc'     => 'Automated tests that score an AI system on accuracy, task completion, safety and cost every time a prompt or model changes.',
                    'includes' => ['Eval datasets drawn from real examples', 'Automated scoring calibrated against human review', 'Red-team cases for prompt injection and tool misuse', 'Eval gate in your release pipeline'],
                    'tags'     => ['Evals in CI', 'Regression tests'],
                    'stack'    => ['python', 'githubactions', 'langchain', 'mlflow'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with AI live and no reliable way to tell whether a change made it better or worse.',
                ],
                [
                    'key'      => 'pilot-to-production',
                    'name'     => 'Pilot to production',
                    'desc'     => 'Take a promising prototype and make it dependable: monitoring, fallbacks, access control, cost limits and support.',
                    'includes' => ['Production architecture review', 'Guardrails, fallbacks and rate limits', 'Monitoring of quality, latency and cost', 'Runbook and handover'],
                    'tags'     => ['Hardening', 'Monitoring', 'Cost limits'],
                    'stack'    => ['opentelemetry', 'fastapi', 'docker', 'amazonwebservices', 'microsoftazure'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with a pilot that works in demos but is not ready for customers.',
                ],
            ]],

            ['key' => 'governance', 'name' => 'Governance & operating model', 'icon' => 'shield', 'offers' => [
                [
                    'key'      => 'ai-governance',
                    'name'     => 'AI governance framework',
                    'desc'     => 'The policies, risk tiers and approval steps that decide which uses of AI are allowed, who signs them off and how they are monitored. Aligned with the NIST AI RMF and ISO/IEC 42001:2023.',
                    'includes' => ['AI policy and acceptable-use rules', 'Risk tiers and an approval workflow', 'Inventory of AI systems in use', 'Impact assessment template'],
                    'tags'     => ['NIST AI RMF', 'ISO/IEC 42001', 'Policy'],
                    'stack'    => [],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations adopting AI across several teams at once.',
                ],
                [
                    'key'      => 'operating-model',
                    'name'     => 'AI operating model & team design',
                    'desc'     => 'Who owns AI in your organisation, whether a central team, specialists embedded in business units or both, with the roles, skills and budget process to match.',
                    'includes' => ['Operating model options and a recommendation', 'Roles and responsibilities (RACI)', 'Skills gap and hiring plan', 'Funding and prioritisation process'],
                    'tags'     => ['Centre of excellence', 'RACI', 'Skills'],
                    'stack'    => [],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies moving from scattered experiments to a managed AI programme.',
                ],
                [
                    'key'      => 'regulatory-mapping',
                    'name'     => 'EU AI Act & regulatory mapping',
                    'desc'     => 'Classify each AI use case by risk tier under the EU AI Act and set out which obligations apply, alongside GDPR and India’s DPDP Act 2023. Prepared with your legal counsel.',
                    'includes' => ['Risk classification per use case', 'Obligations map per AI system', 'Gap list with named owners', 'Readiness plan'],
                    'tags'     => ['EU AI Act', 'DPDP Act 2023', 'GDPR'],
                    'stack'    => [],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses selling into Europe or processing personal data with AI.',
                ],
                [
                    'key'      => 'ai-adoption-training',
                    'name'     => 'AI adoption & training',
                    'desc'     => 'Practical training so your people use approved AI tools well and safely: how to ask, how to check the output and when not to use AI at all.',
                    'includes' => ['Role-based training sessions', 'Prompting and review playbooks', 'Safe-use guidelines', 'Adoption measurement'],
                    'tags'     => ['Training', 'Playbooks', 'Safe use'],
                    'stack'    => [],
                    'time'     => '2–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams given AI tools without guidance on using them well.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'enterprise'],
    ],

    /* =============================================================================================
       04 · AI Product & Automation
       ============================================================================================= */
    'ai-product-automation' => [
        'discipline' => 'technology-intelligence',
        'title'      => '<span class="g">AI features your customers use,</span> and automation your team can trust.',
        'lead'       => 'We add AI to your products and operations: assistants that answer from your own knowledge, chat and voice agents, document and image understanding, and automated workflows. Each one is measured against an evaluation set before it launches.',
        'categories' => [

            ['key' => 'knowledge-search', 'name' => 'Knowledge & search', 'icon' => 'doc', 'offers' => [
                [
                    'key'      => 'rag-assistant',
                    'name'     => 'RAG knowledge assistant',
                    'desc'     => 'An assistant that answers questions from your own documents, policies and data, and shows the source for every answer. Retrieval-augmented generation (RAG) keeps answers current without retraining a model.',
                    'includes' => ['Document ingestion and chunking', 'Hybrid search with re-ranking', 'Citations and permission-aware access', 'Faithfulness and relevance evaluations', 'Feedback capture from users'],
                    'tags'     => ['RAG', 'Citations', 'Permission-aware'],
                    'stack'    => ['llamaindex', 'langchain', 'pgvector', 'qdrant', 'anthropic', 'openai'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Support, legal, HR and sales teams answering the same questions from long documents.',
                ],
                [
                    'key'      => 'ai-search',
                    'name'     => 'AI search for your site or app',
                    'desc'     => 'Search that understands what people mean, not only the words they type, across products, articles or records.',
                    'includes' => ['Hybrid vector and keyword search', 'Synonyms, filters and ranking rules', 'Natural-language questions with suggested answers', 'Search analytics'],
                    'tags'     => ['Semantic search', 'Hybrid', 'Analytics'],
                    'stack'    => ['elasticsearch', 'algolia', 'pinecone', 'weaviate', 'postgresql'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Catalogues, help centres and content-heavy sites with poor search.',
                ],
                [
                    'key'      => 'enterprise-knowledge',
                    'name'     => 'Enterprise knowledge hub',
                    'desc'     => 'One place to search and ask across SharePoint, Google Drive, Confluence, Notion and ticketing tools, respecting who is allowed to see what.',
                    'includes' => ['Connectors to your document tools', 'Access rights inherited from each source', 'Freshness and sync monitoring', 'Admin controls for sources and topics'],
                    'tags'     => ['Connectors', 'Access control', 'One search'],
                    'stack'    => ['confluence', 'notion', 'microsoftteams', 'llamaindex', 'weaviate'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations whose knowledge is spread across many tools.',
                ],
            ]],

            ['key' => 'conversational', 'name' => 'Conversational AI', 'icon' => 'chat', 'offers' => [
                [
                    'key'      => 'support-assistant',
                    'name'     => 'Customer support assistant',
                    'desc'     => 'A chat assistant on your website or app that resolves common requests, such as order status, returns or bookings, through your systems, and passes harder cases to a person with the full context.',
                    'includes' => ['Intent design from real support tickets', 'Integration with order, CRM or booking systems', 'Clean handover to your helpdesk', 'Resolution, handover and satisfaction tracking'],
                    'tags'     => ['Chat', 'Handover', 'Resolution rate'],
                    'stack'    => ['intercom', 'zendesk', 'anthropic', 'openai'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Support teams handling high volumes of repeat questions.',
                ],
                [
                    'key'      => 'whatsapp-assistant',
                    'name'     => 'WhatsApp & messaging assistant',
                    'desc'     => 'An assistant on WhatsApp and other messaging channels for enquiries, bookings, reminders and updates, where your customers already are.',
                    'includes' => ['WhatsApp Business Platform set-up and template submission for Meta approval', 'Conversation flows with AI for open questions', 'Opt-in and consent handling', 'Every conversation logged in your CRM'],
                    'tags'     => ['WhatsApp Business', 'Templates', 'Opt-in'],
                    'stack'    => ['whatsapp', 'twilio', 'hubspot', 'zoho'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses in markets such as India where customers prefer WhatsApp.',
                ],
                [
                    'key'      => 'voice-agent',
                    'name'     => 'Voice AI agent',
                    'desc'     => 'A phone agent that answers calls, understands natural speech, books appointments or routes calls, and transfers to a person when needed.',
                    'includes' => ['Speech recognition and a natural voice', 'Call flows and telephony integration', 'Transfer to live agents with a call summary', 'Recordings and transcripts, with caller consent'],
                    'tags'     => ['Voice', 'Telephony', 'Call summaries'],
                    'stack'    => ['twilio', 'openai', 'googlegemini'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Clinics, service businesses and contact centres with high call volumes.',
                ],
                [
                    'key'      => 'sales-assistant',
                    'name'     => 'Lead qualification assistant',
                    'desc'     => 'An assistant that answers product questions, qualifies inbound enquiries and books meetings for your sales team, at any hour.',
                    'includes' => ['Qualification questions from your sales process', 'Product answers from approved content only', 'Calendar booking', 'CRM record with a conversation summary'],
                    'tags'     => ['Lead qualification', 'Booking', 'CRM'],
                    'stack'    => ['hubspot', 'salesforce', 'anthropic', 'openai'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'B2B teams losing leads that arrive outside working hours.',
                ],
            ]],

            ['key' => 'document-vision', 'name' => 'Document & vision AI', 'icon' => 'vision', 'offers' => [
                [
                    'key'      => 'document-processing',
                    'name'     => 'Document processing',
                    'desc'     => 'Read invoices, forms, contracts and ID documents automatically, pull out the fields you need, and send low-confidence cases to a person to check.',
                    'includes' => ['OCR and field extraction', 'Classification by document type', 'Confidence thresholds and a review queue', 'Export to your ERP, CRM or accounting system'],
                    'tags'     => ['OCR', 'Extraction', 'Human review'],
                    'stack'    => ['python', 'huggingface', 'googlegemini', 'amazonwebservices'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Finance, insurance, logistics and onboarding teams keying data in by hand.',
                ],
                [
                    'key'      => 'visual-inspection',
                    'name'     => 'Visual inspection & detection',
                    'desc'     => 'Cameras and models that spot defects, count items or check compliance in images and video.',
                    'includes' => ['Image dataset and labelling plan', 'Model training and evaluation', 'Edge or cloud deployment', 'Alerts and a review dashboard'],
                    'tags'     => ['Computer vision', 'Edge deployment'],
                    'stack'    => ['pytorch', 'onnx', 'nvidia', 'python'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Manufacturing, retail and field operations with visual checks.',
                ],
                [
                    'key'      => 'contract-review',
                    'name'     => 'Contract & document review assistant',
                    'desc'     => 'Summarise long documents, compare clauses with your standard positions and flag what needs a lawyer’s attention.',
                    'includes' => ['Clause library and review playbook', 'Clause extraction and comparison', 'Risk flags with references to the text', 'Reviewer workflow'],
                    'tags'     => ['Summaries', 'Clause comparison', 'Reviewer-led'],
                    'stack'    => ['anthropic', 'openai', 'llamaindex'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Legal, procurement and compliance teams reviewing high volumes.',
                ],
            ]],

            ['key' => 'automation', 'name' => 'Workflow automation', 'icon' => 'workflow', 'offers' => [
                [
                    'key'      => 'no-code-automation',
                    'name'     => 'No-code workflow automation',
                    'desc'     => 'Connect everyday tools such as email, forms, CRM and spreadsheets so routine steps happen on their own, built on n8n, Make or Zapier.',
                    'includes' => ['Process mapping and an automation shortlist', 'Workflows with error handling and alerts', 'AI steps for sorting, drafting and summaries', 'Documentation and team handover'],
                    'tags'     => ['n8n', 'Make', 'Zapier'],
                    'stack'    => ['n8n', 'make', 'zapier', 'hubspot'],
                    'time'     => '2–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Small and mid-size teams losing hours to copy-and-paste work.',
                ],
                [
                    'key'      => 'durable-automation',
                    'name'     => 'Automation for critical processes',
                    'desc'     => 'Custom automation for high-volume or business-critical work that survives failures, retries safely and keeps a full record, built on durable workflow engines such as Temporal.',
                    'includes' => ['Workflow design with exception routing', 'Durable execution with retries and timeouts', 'Human-in-the-loop steps', 'Monitoring and an audit trail'],
                    'tags'     => ['Temporal', 'Durable', 'Exceptions to people'],
                    'stack'    => ['temporal', 'python', 'go', 'postgresql'],
                    'time'     => '8–14 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Operations where a dropped step costs money: payments, claims, fulfilment.',
                ],
                [
                    'key'      => 'inbox-triage',
                    'name'     => 'Inbox & ticket triage',
                    'desc'     => 'AI that reads incoming emails and tickets, sorts them by topic and urgency, drafts replies and routes each one to the right team.',
                    'includes' => ['Classification by topic, urgency and sentiment', 'Draft replies for a person to review', 'Routing rules into your helpdesk', 'Accuracy reporting'],
                    'tags'     => ['Triage', 'Draft replies', 'Routing'],
                    'stack'    => ['zendesk', 'intercom', 'n8n', 'openai'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Shared inboxes and support desks with slow first responses.',
                ],
            ]],

            ['key' => 'product-ai', 'name' => 'AI in your product & LLMOps', 'icon' => 'sparkle', 'offers' => [
                [
                    'key'      => 'ai-product-features',
                    'name'     => 'AI features in your product',
                    'desc'     => 'Summaries, drafting, recommendations and natural-language search designed into your product, with sensible fallbacks when the model is unsure.',
                    'includes' => ['Feature discovery with your product team', 'Interface patterns for AI output and feedback', 'Model and prompt set-up with cost limits', 'Evaluation set and release gate'],
                    'tags'     => ['In-product AI', 'Fallbacks', 'Cost per request'],
                    'stack'    => ['openai', 'anthropic', 'nextdotjs', 'fastapi'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Software products adding AI their customers will actually use.',
                ],
                [
                    'key'      => 'recommendations',
                    'name'     => 'Recommendations & personalisation',
                    'desc'     => 'Suggest the next product, article or action for each user, based on what they and similar users do.',
                    'includes' => ['Data review and feature design', 'Recommendation models', 'A/B testing against the current experience', 'Performance monitoring'],
                    'tags'     => ['Recommendations', 'A/B tested'],
                    'stack'    => ['python', 'scikitlearn', 'pytorch', 'redis'],
                    'time'     => '8–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Commerce, media and learning platforms.',
                ],
                [
                    'key'      => 'fine-tuning',
                    'name'     => 'Model fine-tuning',
                    'desc'     => 'Adapt a smaller open-weight or hosted model to your tone, format or narrow task, often matching a larger model at lower cost.',
                    'includes' => ['Dataset preparation and cleaning', 'Fine-tuning and comparison against a baseline', 'Evaluation report', 'Deployment and versioning'],
                    'tags'     => ['Fine-tuning', 'Open-weight', 'Lower cost'],
                    'stack'    => ['huggingface', 'pytorch', 'meta', 'mistralai'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'High-volume tasks where cost, speed or format consistency matter.',
                ],
                [
                    'key'      => 'llmops',
                    'name'     => 'Evaluation & monitoring (LLMOps)',
                    'desc'     => 'Keep AI features accurate after launch with continuous evaluation, prompt and model versioning, and alerts when quality, latency or cost drift.',
                    'includes' => ['Offline eval suites for faithfulness, relevance and safety', 'Online monitoring from real traffic', 'Prompt and model registry', 'Cost and latency dashboards'],
                    'tags'     => ['Evals', 'Drift alerts', 'Versioning'],
                    'stack'    => ['mlflow', 'opentelemetry', 'grafana', 'langchain'],
                    'time'     => '3–6 weeks to set up, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams running AI in production without quality tracking.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer'],
    ],

    /* =============================================================================================
       05 · AI Infrastructure & Cloud
       ============================================================================================= */
    'ai-infrastructure-cloud' => [
        'discipline' => 'technology-intelligence',
        'title'      => '<span class="g">Cloud and AI infrastructure</span> that stays fast, reliable and affordable.',
        'lead'       => 'We design, build and run the backend your products and AI depend on: cloud foundations, Kubernetes platforms, model serving, and the reliability and cost practice that keeps latency and spend in check.',
        'categories' => [

            ['key' => 'cloud', 'name' => 'Cloud architecture & migration', 'icon' => 'cloud', 'offers' => [
                [
                    'key'      => 'cloud-migration',
                    'name'     => 'Cloud migration',
                    'desc'     => 'Move applications and data from your own servers or another provider to AWS, Azure or Google Cloud, in planned waves with minimal downtime.',
                    'includes' => ['Discovery and dependency mapping', 'Strategy per application: rehost, replatform or refactor', 'Wave plan with rollback points', 'Cutover and hypercare'],
                    'tags'     => ['AWS', 'Azure', 'Google Cloud'],
                    'stack'    => ['amazonwebservices', 'microsoftazure', 'googlecloud', 'terraform'],
                    'time'     => '8–20 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations leaving a data centre or consolidating cloud providers.',
                ],
                [
                    'key'      => 'landing-zone',
                    'name'     => 'Cloud foundations (landing zone)',
                    'desc'     => 'A secure, well-organised starting point in the cloud: accounts, networking, identity, logging and guardrails set up as code before workloads arrive.',
                    'includes' => ['Account and network structure', 'Identity, SSO and least-privilege roles', 'Policy as code with CIS-aligned baselines', 'Central logging and cost tagging'],
                    'tags'     => ['Landing zone', 'Policy as code', 'CIS Benchmarks'],
                    'stack'    => ['terraform', 'amazonwebservices', 'microsoftazure', 'googlecloud', 'vault'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams starting in the cloud, or tidying an estate that grew without a plan.',
                ],
                [
                    'key'      => 'architecture-review',
                    'name'     => 'Cloud architecture review',
                    'desc'     => 'An expert review of your current set-up for reliability, security, performance and cost, with a ranked list of improvements.',
                    'includes' => ['Review against well-architected principles', 'Risk and cost findings', 'Target architecture', 'Prioritised roadmap'],
                    'tags'     => ['Well-architected', 'Roadmap'],
                    'stack'    => ['amazonwebservices', 'microsoftazure', 'googlecloud'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams preparing for growth, an audit or a funding round.',
                ],
                [
                    'key'      => 'edge-cdn',
                    'name'     => 'Edge & CDN delivery',
                    'desc'     => 'Serve your site, content and APIs from locations close to your users, with caching, edge functions and a web application firewall.',
                    'includes' => ['CDN and caching rules', 'Edge functions', 'WAF and bot protection', 'Latency monitoring by region'],
                    'tags'     => ['CDN', 'WAF', 'Edge'],
                    'stack'    => ['cloudflare', 'fastly', 'akamai', 'vercel'],
                    'time'     => '2–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sites and apps with users spread across regions.',
                ],
            ]],

            ['key' => 'platform', 'name' => 'Kubernetes & platform engineering', 'icon' => 'cluster', 'offers' => [
                [
                    'key'      => 'kubernetes-platform',
                    'name'     => 'Kubernetes platform',
                    'desc'     => 'A production-ready Kubernetes set-up for running your services, with autoscaling, security policies and deployments managed through Git.',
                    'includes' => ['Managed cluster set-up on EKS, AKS or GKE', 'GitOps delivery with Argo CD', 'Autoscaling and resource policies', 'Secrets, network policies and image scanning'],
                    'tags'     => ['Kubernetes', 'GitOps', 'Autoscaling'],
                    'stack'    => ['kubernetes', 'helm', 'argo', 'istio', 'trivy'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams running many services, or outgrowing simple hosting.',
                ],
                [
                    'key'      => 'developer-platform',
                    'name'     => 'Internal developer platform',
                    'desc'     => 'Self-service templates and pipelines so engineers can create, test and deploy services the approved way in minutes, without waiting on another team.',
                    'includes' => ['Golden-path service templates', 'CI/CD pipelines with security checks built in', 'Preview environments', 'Developer portal and documentation'],
                    'tags'     => ['Golden paths', 'Self-service', 'DORA metrics'],
                    'stack'    => ['githubactions', 'gitlab', 'argo', 'terraform', 'docker'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Engineering organisations where releases are slowed by manual steps.',
                ],
                [
                    'key'      => 'cicd-iac',
                    'name'     => 'CI/CD & infrastructure as code',
                    'desc'     => 'Automate how code is tested and released, and describe your infrastructure in code so every environment can be rebuilt the same way.',
                    'includes' => ['Build, test and deploy pipelines', 'Terraform or Pulumi modules', 'Environment promotion with approvals', 'Rollback procedures'],
                    'tags'     => ['CI/CD', 'IaC', 'Repeatable'],
                    'stack'    => ['githubactions', 'gitlab', 'jenkins', 'terraform', 'pulumi'],
                    'time'     => '3–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams deploying by hand or with fragile scripts.',
                ],
            ]],

            ['key' => 'ai-serving', 'name' => 'AI serving & MLOps', 'icon' => 'gpu', 'offers' => [
                [
                    'key'      => 'llm-serving',
                    'name'     => 'LLM serving & inference optimisation',
                    'desc'     => 'Run language models on your own infrastructure or through managed endpoints, tuned so answers come back fast and each request costs less.',
                    'includes' => ['Serving with vLLM, Triton or managed endpoints', 'Batching, quantisation and caching', 'Routing between models by cost and quality', 'Load tests against p95 and p99 latency targets'],
                    'tags'     => ['vLLM', 'p95 latency', 'Cost per 1k requests'],
                    'stack'    => ['vllm', 'nvidia', 'kubernetes', 'ray', 'huggingface'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products with steady AI traffic, strict data residency or tight latency needs.',
                ],
                [
                    'key'      => 'gpu-infrastructure',
                    'name'     => 'GPU infrastructure',
                    'desc'     => 'GPU capacity sized to the workload, with scheduling and scale-to-zero, so expensive hardware is not left idle.',
                    'includes' => ['Capacity and instance selection', 'GPU node pools and scheduling', 'Spot and committed capacity plan', 'Utilisation dashboards'],
                    'tags'     => ['GPU', 'Scale to zero', 'Utilisation'],
                    'stack'    => ['nvidia', 'kubernetes', 'ray', 'modal'],
                    'time'     => '3–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams training or serving models with rising GPU bills.',
                ],
                [
                    'key'      => 'mlops-llmops',
                    'name'     => 'MLOps & LLMOps pipelines',
                    'desc'     => 'Repeatable pipelines to train, evaluate, version and deploy models and prompts, so every release can be traced and rolled back.',
                    'includes' => ['Experiment tracking and a model registry', 'Training and embedding pipelines', 'Evaluation gates before deployment', 'Model and prompt versioning with rollback'],
                    'tags'     => ['Model registry', 'Lineage', 'Reproducible'],
                    'stack'    => ['mlflow', 'apacheairflow', 'kubernetes', 'python', 'huggingface'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Data science teams moving models from notebooks to production.',
                ],
                [
                    'key'      => 'private-ai',
                    'name'     => 'Private & self-hosted AI',
                    'desc'     => 'Run open-weight models such as Llama, Mistral or DeepSeek inside your own cloud account or data centre, so sensitive data stays under your control.',
                    'includes' => ['Model selection and licence check', 'Deployment in your VPC or on-premise', 'Access control and logging', 'Break-even analysis against API pricing'],
                    'tags'     => ['Open-weight', 'Data residency', 'In your VPC'],
                    'stack'    => ['meta', 'mistralai', 'deepseek', 'ollama', 'vllm'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Regulated sectors and teams with strict data-location rules.',
                ],
            ]],

            ['key' => 'reliability-cost', 'name' => 'Reliability, cost & sustainability', 'icon' => 'uptime', 'offers' => [
                [
                    'key'      => 'sre-observability',
                    'name'     => 'Observability & SRE',
                    'desc'     => 'See how your systems behave in production and fix problems before customers notice, with service level objectives, tracing and alerts worth acting on.',
                    'includes' => ['SLOs and error budgets per service', 'Traces, metrics and logs on OpenTelemetry', 'Alert tuning to cut noise', 'On-call runbooks and incident reviews'],
                    'tags'     => ['SLOs', 'OpenTelemetry', 'Error budgets'],
                    'stack'    => ['opentelemetry', 'prometheus', 'grafana', 'datadog', 'pagerduty'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams who hear about outages from customers first.',
                ],
                [
                    'key'      => 'finops',
                    'name'     => 'FinOps & cloud cost reduction',
                    'desc'     => 'Find and remove wasted cloud spend, and show each team what its services cost, without hurting performance.',
                    'includes' => ['Cost allocation and tagging', 'Rightsizing and idle-resource clean-up', 'Savings plans, reserved and spot capacity', 'Monthly cost report per product or team'],
                    'tags'     => ['Rightsizing', 'Unit cost', 'Commitments'],
                    'stack'    => ['amazonwebservices', 'microsoftazure', 'googlecloud', 'grafana'],
                    'time'     => '3–6 weeks, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies whose cloud bill grows faster than their revenue.',
                ],
                [
                    'key'      => 'load-testing',
                    'name'     => 'Performance & load testing',
                    'desc'     => 'Find out how much traffic your system can handle before launch day finds out for you.',
                    'includes' => ['Load models based on real traffic', 'Load, spike and soak tests', 'Bottleneck analysis', 'Capacity plan'],
                    'tags'     => ['k6', 'Capacity', 'Bottlenecks'],
                    'stack'    => ['k6', 'grafana', 'datadog'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams expecting a launch, sale or seasonal peak.',
                ],
                [
                    'key'      => 'disaster-recovery',
                    'name'     => 'Backup, disaster recovery & resilience',
                    'desc'     => 'Make sure you can recover from outages, deletions or ransomware, with recovery targets set per service and proven in real drills.',
                    'includes' => ['Recovery time and recovery point objectives (RTO, RPO) per service', 'Backups and cross-region replication', 'Failover design', 'Restore and failover drills'],
                    'tags'     => ['RTO · RPO', 'ISO 22301-aligned', 'Drills'],
                    'stack'    => ['amazonwebservices', 'microsoftazure', 'terraform', 'kubernetes'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses where downtime or data loss would be costly.',
                ],
                [
                    'key'      => 'green-compute',
                    'name'     => 'Green & carbon-aware compute',
                    'desc'     => 'Measure the carbon footprint of your software and reduce it alongside cost, using the Green Software Foundation’s Software Carbon Intensity (SCI) method.',
                    'includes' => ['SCI baseline per request or workload', 'Region and scheduling choices by grid carbon intensity', 'Efficiency fixes that cut cost and emissions together', 'Reporting for sustainability teams'],
                    'tags'     => ['SCI', 'Carbon per request', 'GreenOps'],
                    'stack'    => ['kubernetes', 'grafana', 'googlecloud'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations with sustainability targets or reporting duties.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'milestone', 'retainer', 'enterprise'],
    ],

    /* =============================================================================================
       06 · Cybersecurity & AI Trust
       Readiness and implementation support only. Certificates and attestation reports are issued
       by accredited certification bodies and licensed CPA firms, never by us.
       ============================================================================================= */
    'cybersecurity-ai-trust' => [
        'discipline' => 'technology-intelligence',
        'title'      => '<span class="g">Find the gaps before attackers do,</span> and prove your controls work.',
        'lead'       => 'Security testing, compliance readiness and AI governance for your products, cloud and data. We test, help you fix what we find and build the evidence your customers and auditors ask for. Certificates and attestation reports come from independent auditors, not from us.',
        'categories' => [

            ['key' => 'security-testing', 'name' => 'Security testing (VAPT)', 'icon' => 'bug', 'offers' => [
                [
                    'key'      => 'web-app-pentest',
                    'name'     => 'Web application penetration test',
                    'desc'     => 'Skilled testers attack your website or web app the way a real attacker would, within an agreed scope, and show you exactly what they found and how to fix it.',
                    'includes' => ['Scope and rules of engagement', 'Manual testing against the OWASP Top 10 and OWASP ASVS', 'Proof-of-concept evidence and severity ratings', 'Fix guidance for each finding', 'Retest of fixed findings'],
                    'tags'     => ['VAPT', 'OWASP Top 10', 'OWASP ASVS'],
                    'stack'    => ['burpsuite', 'owasp'],
                    'time'     => '1–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Any business before launch, after major changes or when a customer asks for a pentest report.',
                ],
                [
                    'key'      => 'mobile-app-pentest',
                    'name'     => 'Mobile app security test',
                    'desc'     => 'Testing of your iOS and Android apps and the APIs behind them, including how data is stored on the phone and sent over the network.',
                    'includes' => ['Static and dynamic analysis of app builds', 'Testing against the OWASP MASVS', 'Local storage, certificate pinning and sign-in checks', 'Testing of the backend APIs the app uses', 'Report and retest'],
                    'tags'     => ['OWASP MASVS', 'iOS', 'Android'],
                    'stack'    => ['owasp', 'burpsuite', 'ios', 'android'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Apps that handle payments, health records or personal data.',
                ],
                [
                    'key'      => 'api-pentest',
                    'name'     => 'API security test',
                    'desc'     => 'Testing of your APIs for broken access control, data exposure and abuse, among the most common ways modern applications are breached.',
                    'includes' => ['Testing against the OWASP API Security Top 10', 'Authorisation checks across roles and tenants', 'Rate limiting and abuse cases', 'Report with fixes and retest'],
                    'tags'     => ['OWASP API Top 10', 'Access control'],
                    'stack'    => ['postman', 'burpsuite', 'owasp'],
                    'time'     => '1–2 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'SaaS, fintech and platforms that expose APIs to partners or apps.',
                ],
                [
                    'key'      => 'cloud-security-assessment',
                    'name'     => 'Cloud security assessment',
                    'desc'     => 'A review of your AWS, Azure or Google Cloud set-up for misconfigurations, over-broad access and exposed data.',
                    'includes' => ['Configuration review against CIS Benchmarks', 'Identity and access review', 'Network exposure and storage checks', 'Prioritised fix list'],
                    'tags'     => ['CIS Benchmarks', 'IAM review', 'Misconfiguration'],
                    'stack'    => ['amazonwebservices', 'microsoftazure', 'googlecloud', 'trivy'],
                    'time'     => '1–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose cloud grew quickly and has never been independently checked.',
                ],
                [
                    'key'      => 'infrastructure-vapt',
                    'name'     => 'Infrastructure & network VAPT',
                    'desc'     => 'Vulnerability assessment and penetration testing of your servers, networks and internet-facing services.',
                    'includes' => ['External and internal vulnerability scanning', 'Manual exploitation of in-scope findings', 'Patching and hardening guidance', 'Report and retest'],
                    'tags'     => ['VAPT', 'External · internal'],
                    'stack'    => [],
                    'time'     => '1–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations with on-premise or hybrid infrastructure.',
                ],
            ]],

            ['key' => 'ai-security', 'name' => 'AI security & governance', 'icon' => 'scan', 'offers' => [
                [
                    'key'      => 'ai-red-team',
                    'name'     => 'AI red-teaming',
                    'desc'     => 'We try to make your chatbot, assistant or agent misbehave, by leaking data, ignoring its instructions or misusing its tools, then help you close each gap. Tests map to the OWASP Top 10 for LLM Applications and MITRE ATLAS.',
                    'includes' => ['Threat model of the AI system', 'Direct and indirect prompt injection tests (LLM01)', 'Sensitive information disclosure (LLM02) and excessive agency (LLM06) tests', 'Jailbreak and tool-misuse suites', 'Findings, fixes and retest'],
                    'tags'     => ['OWASP LLM Top 10', 'MITRE ATLAS', 'Red team'],
                    'stack'    => ['owasp', 'python'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Any team putting an LLM, chatbot or agent in front of customers or sensitive data.',
                ],
                [
                    'key'      => 'ai-guardrails',
                    'name'     => 'AI guardrails implementation',
                    'desc'     => 'Build the protections into your AI system: input and output checks, least-privilege tool access, data-leak detection and approval steps.',
                    'includes' => ['Input and output guardrails', 'Tool permission scoping', 'Personal data detection and redaction', 'Automated red-team suite in CI'],
                    'tags'     => ['Guardrails', 'Least privilege', 'PII redaction'],
                    'stack'    => ['python', 'githubactions', 'vault'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose AI red-team or review raised issues to fix.',
                ],
                [
                    'key'      => 'ai-governance',
                    'name'     => 'AI governance (ISO/IEC 42001, NIST AI RMF, EU AI Act)',
                    'desc'     => 'Set up how your organisation records, risk-rates and oversees its AI systems, aligned with ISO/IEC 42001:2023, the NIST AI RMF and the EU AI Act. We prepare you; certification, if you want it, comes from an accredited body.',
                    'includes' => ['AI system inventory and risk classification', 'AI impact assessments', 'Policies, roles and human-oversight controls', 'Gap assessment against ISO/IEC 42001:2023', 'Evidence pack for your auditor'],
                    'tags'     => ['ISO/IEC 42001:2023', 'NIST AI RMF', 'EU AI Act'],
                    'stack'    => [],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations using AI in decisions that affect customers or employees.',
                ],
            ]],

            ['key' => 'compliance', 'name' => 'Compliance readiness', 'icon' => 'clipboard-check', 'offers' => [
                [
                    'key'      => 'iso27001-readiness',
                    'name'     => 'ISO/IEC 27001:2022 readiness',
                    'desc'     => 'Get ready for ISO/IEC 27001 certification. We find the gaps, help you put the controls in place and prepare the evidence; the certificate is issued by the accredited certification body you appoint.',
                    'includes' => ['Gap assessment against the 93 Annex A controls', 'Risk assessment and Statement of Applicability', 'Policies and control implementation support', 'Internal audit and support on audit days'],
                    'tags'     => ['ISO/IEC 27001:2022', 'Gap assessment', 'Audit support'],
                    'stack'    => ['confluence', 'jira'],
                    'time'     => '12–24 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies selling to enterprise or regulated buyers who ask for ISO 27001.',
                ],
                [
                    'key'      => 'soc2-readiness',
                    'name'     => 'SOC 2 readiness',
                    'desc'     => 'Prepare for a SOC 2 Type I or Type II examination: controls designed, evidence collected automatically and your team ready for the auditor. The report itself is issued by a licensed CPA firm.',
                    'includes' => ['Scoping of the Trust Services Criteria', 'Gap assessment and control design', 'Evidence automation from your tools', 'Readiness review before the audit window'],
                    'tags'     => ['SOC 2 Type I', 'SOC 2 Type II', 'Evidence automation'],
                    'stack'    => ['github', 'okta', 'jira'],
                    'time'     => '8–20 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'SaaS companies selling to US and enterprise customers.',
                ],
                [
                    'key'      => 'dpdp-gdpr-readiness',
                    'name'     => 'DPDP Act 2023 & GDPR readiness',
                    'desc'     => 'Understand and meet your duties under India’s Digital Personal Data Protection Act 2023 and, where it applies, the EU GDPR: notice, consent, security safeguards, breach handling and people’s rights over their data.',
                    'includes' => ['Personal data inventory and flow map', 'Notice and consent review', 'Process for data-principal rights requests', 'Breach response plan', 'Interpretation agreed with your legal counsel'],
                    'tags'     => ['DPDP Act 2023', 'GDPR', 'Consent'],
                    'stack'    => [],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Any business collecting personal data from people in India or the EU.',
                ],
                [
                    'key'      => 'pci-dss-readiness',
                    'name'     => 'PCI DSS readiness',
                    'desc'     => 'Reduce how much of your system touches card data, then prepare for PCI DSS v4.0.1 on what remains.',
                    'includes' => ['Scope reduction with tokenised payments', 'Network segmentation review', 'Control gap assessment', 'Evidence preparation and support for your assessor'],
                    'tags'     => ['PCI DSS v4.0.1', 'Scope reduction'],
                    'stack'    => ['stripe', 'razorpay'],
                    'time'     => '8–16 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses that store, process or transmit card data.',
                ],
            ]],

            ['key' => 'secure-operations', 'name' => 'Identity, DevSecOps & response', 'icon' => 'lock', 'offers' => [
                [
                    'key'      => 'iam-zero-trust',
                    'name'     => 'Identity & zero trust',
                    'desc'     => 'Make sure only the right people and systems get in, with single sign-on, multi-factor authentication and least-privilege access everywhere.',
                    'includes' => ['SSO and MFA roll-out', 'Role and access review', 'Privileged access controls', 'Joiner, mover and leaver automation'],
                    'tags'     => ['SSO', 'MFA', 'Zero trust'],
                    'stack'    => ['okta', 'auth0', 'openid', 'vault', '1password'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Growing companies with shared passwords or unmanaged access.',
                ],
                [
                    'key'      => 'devsecops',
                    'name'     => 'DevSecOps',
                    'desc'     => 'Security checks built into your development pipeline, so vulnerabilities are caught when code is written rather than after release.',
                    'includes' => ['SAST, DAST and dependency scanning in CI', 'Secrets detection', 'Container and infrastructure-as-code scanning', 'SBOM and signed builds, aligned with SLSA'],
                    'tags'     => ['Shift left', 'SBOM', 'SLSA'],
                    'stack'    => ['snyk', 'sonarqubecloud', 'trivy', 'githubactions', 'falco'],
                    'time'     => '3–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Engineering teams that ship often and need security to keep up.',
                ],
                [
                    'key'      => 'incident-response',
                    'name'     => 'Incident response readiness',
                    'desc'     => 'Be ready when something goes wrong: a tested plan, clear roles, the right logs and the reporting steps regulators expect, including CERT-In timelines in India.',
                    'includes' => ['Incident response plan and playbooks', 'Logging and detection review', 'Tabletop exercise with your team', 'CERT-In and DPDP breach-reporting steps'],
                    'tags'     => ['Playbooks', 'Tabletop', 'CERT-In'],
                    'stack'    => ['elastic', 'pagerduty', 'opentelemetry'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams that have never rehearsed a breach.',
                ],
                [
                    'key'      => 'security-programme',
                    'name'     => 'Ongoing security programme',
                    'desc'     => 'A continuing security partner: scheduled testing, posture monitoring, policy upkeep and a regular report for leadership.',
                    'includes' => ['Scheduled pentests and scans', 'Security posture dashboard', 'Policy and control upkeep', 'Quarterly leadership report'],
                    'tags'     => ['Continuous', 'Posture', 'Reporting'],
                    'stack'    => ['snyk', 'trivy', 'elastic'],
                    'time'     => 'Ongoing, reviewed quarterly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies without a full-time security team.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'retainer', 'enterprise'],
    ],

    /* =============================================================================================
       07 · Integration & Support
       ============================================================================================= */
    'integration-support' => [
        'discipline' => 'technology-intelligence',
        'title'      => '<span class="g">Connect your tools into one system,</span> then keep it running.',
        'lead'       => 'We connect your applications and data so information moves once and correctly, then look after it with engineers who know the system, agreed response times and a monthly service review.',
        'categories' => [

            ['key' => 'system-integration', 'name' => 'System integration', 'icon' => 'plug', 'offers' => [
                [
                    'key'      => 'api-integration',
                    'name'     => 'API & system integration',
                    'desc'     => 'Connect two or more systems so data moves between them automatically and reliably, with retries, alerts and no duplicates.',
                    'includes' => ['Integration map and data contracts', 'Integrations with retries, idempotency and dead-letter queues', 'Contract tests against vendor sandboxes', 'Monitoring and alerting'],
                    'tags'     => ['APIs', 'Idempotent', 'Monitored'],
                    'stack'    => ['nodedotjs', 'python', 'postman', 'openapiinitiative'],
                    'time'     => '3–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams re-keying the same data into several systems.',
                ],
                [
                    'key'      => 'crm-erp-integration',
                    'name'     => 'CRM & ERP integration',
                    'desc'     => 'Link your CRM, ERP, accounting and marketing tools so customers, orders and invoices stay in step everywhere.',
                    'includes' => ['Salesforce, HubSpot, Zoho or SAP connectors', 'Field mapping and ownership rules', 'Two-way sync with conflict handling', 'Reconciliation reports'],
                    'tags'     => ['Salesforce', 'HubSpot', 'SAP'],
                    'stack'    => ['salesforce', 'hubspot', 'zoho', 'sap'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sales and finance teams working from different versions of the truth.',
                ],
                [
                    'key'      => 'payment-integration',
                    'name'     => 'Payment gateway integration',
                    'desc'     => 'Accept payments online, in your app or by subscription, with refunds, webhooks and reconciliation handled properly.',
                    'includes' => ['Razorpay, Stripe or PayPal integration', 'UPI, cards, subscriptions and refunds', 'Webhook handling with signature checks', 'Settlement reconciliation'],
                    'tags'     => ['Razorpay', 'Stripe', 'UPI'],
                    'stack'    => ['razorpay', 'stripe', 'paypal'],
                    'time'     => '2–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses adding or changing how they take payments.',
                ],
                [
                    'key'      => 'messaging-integration',
                    'name'     => 'Messaging & notifications',
                    'desc'     => 'Send order updates, one-time passwords, reminders and alerts by SMS, WhatsApp, email or Slack straight from your systems.',
                    'includes' => ['WhatsApp Business, SMS and email providers connected', 'Template management and opt-outs', 'Delivery tracking', 'Fallback between channels'],
                    'tags'     => ['WhatsApp', 'SMS', 'Email'],
                    'stack'    => ['twilio', 'whatsapp', 'slack', 'microsoftteams'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses that need to reach customers or staff automatically.',
                ],
                [
                    'key'      => 'api-design-gateway',
                    'name'     => 'API design & gateway',
                    'desc'     => 'Well-documented, versioned APIs for your partners and apps, behind a gateway that handles security, rate limits and usage analytics.',
                    'includes' => ['OpenAPI-first API design', 'Gateway with authentication and rate limits', 'Developer documentation portal', 'Versioning and deprecation policy'],
                    'tags'     => ['OpenAPI', 'API gateway', 'Rate limits'],
                    'stack'    => ['kong', 'openapiinitiative', 'graphql', 'postman'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies opening their platform to partners or building mobile apps.',
                ],
            ]],

            ['key' => 'ipaas-events', 'name' => 'iPaaS & event-driven integration', 'icon' => 'workflow', 'offers' => [
                [
                    'key'      => 'ipaas',
                    'name'     => 'iPaaS integration (MuleSoft, n8n, Make, Zapier)',
                    'desc'     => 'Integrations on a low-code platform where it fits, so your team can see and adjust the flows themselves, with the same monitoring as custom code.',
                    'includes' => ['Platform choice on volume, cost and skills', 'Flows with error handling and alerts', 'Environments and change control', 'Team training and documentation'],
                    'tags'     => ['Low-code', 'Governed', 'Team-editable'],
                    'stack'    => ['mulesoft', 'n8n', 'make', 'zapier'],
                    'time'     => '3–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with standard connectors and moderate volumes.',
                ],
                [
                    'key'      => 'event-driven',
                    'name'     => 'Event-driven integration',
                    'desc'     => 'Systems announce events, such as an order paid, and others react in real time, so adding a new system does not mean rewiring the old ones.',
                    'includes' => ['Event design and schemas', 'Kafka or RabbitMQ set-up', 'Change data capture from existing databases', 'Replay and dead-letter handling'],
                    'tags'     => ['Events', 'Kafka', 'CDC'],
                    'stack'    => ['apachekafka', 'rabbitmq', 'postgresql', 'temporal'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Growing estates where point-to-point integrations have become brittle.',
                ],
                [
                    'key'      => 'integration-rescue',
                    'name'     => 'Integration audit & rescue',
                    'desc'     => 'Fix integrations that fail silently, create duplicates or need manual clean-up, and add the monitoring that should have been there from the start.',
                    'includes' => ['Review of existing flows and failure history', 'Root-cause fixes', 'Monitoring and alerting', 'Runbook for each flow'],
                    'tags'     => ['Rescue', 'Root cause', 'Monitoring'],
                    'stack'    => ['datadog', 'sentry', 'postman'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams reconciling data by hand every week.',
                ],
            ]],

            ['key' => 'data-sync-migration', 'name' => 'Data sync & migration', 'icon' => 'sync', 'offers' => [
                [
                    'key'      => 'data-sync',
                    'name'     => 'Data sync between systems',
                    'desc'     => 'Keep records consistent across systems in near real time, with clear rules about which system owns which field.',
                    'includes' => ['System-of-record rules per field', 'Near-real-time sync', 'Conflict detection', 'Daily reconciliation report'],
                    'tags'     => ['Sync', 'Ownership rules', 'Reconciled'],
                    'stack'    => ['airbyte', 'apachekafka', 'postgresql'],
                    'time'     => '3–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses running more than one system for customers, products or stock.',
                ],
                [
                    'key'      => 'platform-migration',
                    'name'     => 'Platform migration',
                    'desc'     => 'Move from one CRM, ERP, e-commerce or helpdesk platform to another with every record accounted for.',
                    'includes' => ['Mapping and cleansing rules', 'Rehearsed migration runs', 'Reconciliation: record counts, checksums and field samples', 'Cutover with a rollback plan'],
                    'tags'     => ['Rehearsed', 'Reconciled', 'Reversible'],
                    'stack'    => ['salesforce', 'hubspot', 'shopify', 'zendesk'],
                    'time'     => '4–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies switching a core platform.',
                ],
                [
                    'key'      => 'legacy-wrapping',
                    'name'     => 'Legacy system wrapping',
                    'desc'     => 'Put a modern API in front of an old system so new tools can use it safely while you plan its replacement.',
                    'includes' => ['API layer over the legacy system', 'Caching and rate protection', 'Monitoring', 'Migration path using the strangler pattern'],
                    'tags'     => ['API facade', 'Strangler pattern'],
                    'stack'    => ['kong', 'springboot', 'dotnet', 'docker'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations with a system that is hard to change but still essential.',
                ],
            ]],

            ['key' => 'managed-support', 'name' => 'Managed support', 'icon' => 'headset', 'offers' => [
                [
                    'key'      => 'managed-support-sla',
                    'name'     => 'Managed support with SLAs',
                    'desc'     => 'Engineers who monitor your systems, respond to incidents within agreed times and keep you informed, with a monthly service review.',
                    'includes' => ['Response and resolution targets by severity', 'Monitoring and alerting', 'Incident management and post-incident reviews', 'Monthly service report'],
                    'tags'     => ['SLA', 'On-call', 'Monthly review'],
                    'stack'    => ['pagerduty', 'datadog', 'sentry', 'jira'],
                    'time'     => 'Onboarding 2–4 weeks, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses whose systems matter too much to run without support.',
                ],
                [
                    'key'      => 'l2-l3-support',
                    'name'     => 'L2/L3 engineering support',
                    'desc'     => 'Second- and third-line technical support behind your helpdesk: investigating bugs, fixing code and resolving data issues your front line cannot.',
                    'includes' => ['Ticket intake from your helpdesk', 'Root-cause analysis and code fixes', 'Knowledge base for your first-line team', 'Escalation and monthly reporting'],
                    'tags'     => ['L2', 'L3', 'Root cause'],
                    'stack'    => ['jira', 'zendesk', 'github', 'sentry'],
                    'time'     => 'Onboarding 2–4 weeks, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product companies whose developers keep being pulled into support.',
                ],
                [
                    'key'      => 'uptime-monitoring',
                    'name'     => 'Uptime & performance monitoring',
                    'desc'     => 'Automated checks on your sites, APIs and integrations, with alerts routed to the right people before customers notice a problem.',
                    'includes' => ['Uptime and synthetic journey checks', 'Error and performance tracking', 'Alert routing and escalation', 'Public or internal status page'],
                    'tags'     => ['Synthetic checks', 'Alerting', 'Status page'],
                    'stack'    => ['datadog', 'grafana', 'sentry', 'pagerduty', 'newrelic'],
                    'time'     => '1–3 weeks to set up, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Any business whose website or API earns revenue.',
                ],
                [
                    'key'      => 'improvement-retainer',
                    'name'     => 'Continuous improvement retainer',
                    'desc'     => 'A monthly allowance of engineering hours for upgrades, security patches, performance work and the small features that pile up.',
                    'includes' => ['Agreed hours each month', 'Dependency and security updates', 'Backlog prioritised with you', 'Quarterly roadmap review'],
                    'tags'     => ['Retainer', 'Upgrades', 'Roadmap'],
                    'stack'    => ['github', 'jira', 'linear'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with a steady stream of small changes and no spare developers.',
                ],
                [
                    'key'      => 'support-takeover',
                    'name'     => 'Support takeover of existing systems',
                    'desc'     => 'We take over support of systems we did not build, starting with an assessment of the code, infrastructure and documentation so service targets are realistic.',
                    'includes' => ['Onboarding assessment', 'Gap fixes before service levels start', 'Runbooks and access set-up', 'Knowledge transfer from the previous team'],
                    'tags'     => ['Takeover', 'Onboarding', 'Knowledge transfer'],
                    'stack'    => ['github', 'sentry', 'confluence'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies changing vendor or losing the original developers.',
                ],
            ]],
        ],
        'packages' => ['project', 'retainer', 'milestone', 'enterprise'],
    ],

    /* =============================================================================================
       08 · Search & AI Visibility
       No ranking or citation is ever promised: search engines and model providers control results.
       ============================================================================================= */
    'search-ai-visibility' => [
        'discipline' => 'technology-intelligence',
        'title'      => '<span class="g">Be found on Google,</span> and named by the AI answer engines.',
        'lead'       => 'We make your brand easy to find wherever people search or ask: ranking in Google and Bing, and cited by ChatGPT, Perplexity, Gemini and Google’s AI Overviews. Technical SEO, content and AI visibility run as one programme, reported against a baseline.',
        'categories' => [

            ['key' => 'technical-seo', 'name' => 'Technical SEO', 'icon' => 'terminal', 'offers' => [
                [
                    'key'      => 'technical-seo',
                    'name'     => 'Technical SEO',
                    'desc'     => 'Fix what stops search engines finding, reading and ranking your pages: crawl errors, indexing gaps, slow pages, broken links and a confusing site structure.',
                    'includes' => ['Crawl, server-log and index analysis', 'Rendering and JavaScript SEO checks', 'Site architecture and internal linking', 'Core Web Vitals fixes with your developers', 'Prioritised fix backlog'],
                    'tags'     => ['Crawl', 'Index', 'Render'],
                    'stack'    => ['googlesearchconsole', 'semrush', 'lighthouse', 'pagespeedinsights'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sites with good content that still underperform in search.',
                ],
                [
                    'key'      => 'migration-seo',
                    'name'     => 'SEO for site migrations',
                    'desc'     => 'Protect your rankings and traffic when you redesign, change platform, merge sites or move domain.',
                    'includes' => ['Pre-migration crawl and benchmark', 'URL mapping and 301 redirect plan', 'Launch-day checks', 'Post-launch monitoring and fixes'],
                    'tags'     => ['Redirect map', 'Launch checks', 'Traffic protection'],
                    'stack'    => ['googlesearchconsole', 'googleanalytics', 'semrush'],
                    'time'     => '3–8 weeks around launch',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Anyone replatforming, redesigning or changing domain.',
                ],
                [
                    'key'      => 'international-seo',
                    'name'     => 'International SEO',
                    'desc'     => 'Show the right page to the right country and language, with hreflang, local keywords and regional search behaviour covered.',
                    'includes' => ['Market and language structure', 'hreflang implementation', 'Localised keyword research', 'Performance tracking by region'],
                    'tags'     => ['hreflang', 'Multi-region', 'Localised'],
                    'stack'    => ['googlesearchconsole', 'semrush', 'ahrefs'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses expanding into new countries or languages.',
                ],
                [
                    'key'      => 'structured-data',
                    'name'     => 'Structured data & entities',
                    'desc'     => 'Add Schema.org markup so search engines and AI systems understand exactly who you are, what you offer and how your pages relate, which can earn rich results.',
                    'includes' => ['Schema.org markup in JSON-LD', 'Organisation, product, article and FAQ types', 'Consistent entity facts across your site and profiles', 'Validation and monitoring'],
                    'tags'     => ['Schema.org', 'JSON-LD', 'Rich results'],
                    'stack'    => ['schemaorg', 'google', 'googlesearchconsole'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands with products, locations, events or expert content.',
                ],
            ]],

            ['key' => 'ai-visibility', 'name' => 'AI search visibility (AEO & GEO)', 'icon' => 'sparkle', 'offers' => [
                [
                    'key'      => 'aeo',
                    'name'     => 'Answer engine optimisation (AEO)',
                    'desc'     => 'Structure your content to be the direct answer in featured snippets, People Also Ask boxes and Google’s AI Overviews.',
                    'includes' => ['Question research for your market', 'Answer-first page structure', 'FAQ and how-to formats with structured data', 'Snippet and AI Overview tracking'],
                    'tags'     => ['AEO', 'AI Overviews', 'Featured snippets'],
                    'stack'    => ['google', 'schemaorg', 'semrush'],
                    'time'     => '6–12 weeks, then ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose customers research by asking questions.',
                ],
                [
                    'key'      => 'geo',
                    'name'     => 'Generative engine optimisation (GEO)',
                    'desc'     => 'Improve how ChatGPT, Perplexity, Gemini and similar assistants understand, mention and recommend your brand, through clear facts, trusted citations and content they can quote accurately.',
                    'includes' => ['AI visibility baseline across answer engines', 'Consistent entity facts across the web', 'Citation-worthy content and sources', 'Work on product and comparison questions'],
                    'tags'     => ['GEO', 'ChatGPT', 'Perplexity'],
                    'stack'    => ['openai', 'perplexity', 'googlegemini', 'anthropic'],
                    'time'     => '8–12 weeks, then ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose customers now research by asking an AI assistant.',
                ],
                [
                    'key'      => 'ai-visibility-tracking',
                    'name'     => 'AI visibility tracking',
                    'desc'     => 'Measure how often your brand is mentioned, cited and linked in AI answers for the questions that matter to you, over time and against competitors.',
                    'includes' => ['Prompt set that reflects how your customers ask', 'Regular runs across the major answer engines', 'Share of answer, mentions and citations', 'Monthly report'],
                    'tags'     => ['Share of answer', 'Monthly tracking'],
                    'stack'    => ['openai', 'perplexity', 'googlegemini'],
                    'time'     => '2–3 weeks to set up, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing leaders asked whether the brand shows up in ChatGPT.',
                ],
                [
                    'key'      => 'ai-crawler-readiness',
                    'name'     => 'AI crawler access & content readiness',
                    'desc'     => 'Decide which AI crawlers may read your site, and make sure the pages you want cited can be reached, rendered and quoted cleanly.',
                    'includes' => ['AI crawler rules in robots.txt', 'Rendering checks on key pages', 'Clean, quotable page structure', 'Server-log monitoring of AI crawlers'],
                    'tags'     => ['robots.txt', 'AI crawlers', 'Rendering'],
                    'stack'    => ['cloudflare', 'googlesearchconsole'],
                    'time'     => '1–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Publishers and brands deciding how AI systems may use their content.',
                ],
            ]],

            ['key' => 'content-authority', 'name' => 'Content & authority', 'icon' => 'doc', 'offers' => [
                [
                    'key'      => 'topical-authority',
                    'name'     => 'Content strategy & topical authority',
                    'desc'     => 'A content plan built from what your customers actually search for and ask, organised into topic clusters and written with your subject experts.',
                    'includes' => ['Search demand and question research', 'Topic clusters and content map', 'Briefs for writers and experts', 'Internal linking plan'],
                    'tags'     => ['Topic clusters', 'E-E-A-T', 'Content map'],
                    'stack'    => ['semrush', 'ahrefs', 'googlesearchconsole'],
                    'time'     => '4–6 weeks for the strategy',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses publishing content without a plan tied to demand.',
                ],
                [
                    'key'      => 'expert-content',
                    'name'     => 'Expert content production',
                    'desc'     => 'Useful, accurate articles, guides and landing pages written with your experts and edited for both search and people.',
                    'includes' => ['Interviews with your subject experts', 'Writing and editing', 'On-page optimisation', 'Publishing in your CMS'],
                    'tags'     => ['Expert-led', 'Answer-first'],
                    'stack'    => ['wordpress', 'contentful', 'sanity'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with deep expertise but no time to write.',
                ],
                [
                    'key'      => 'content-refresh',
                    'name'     => 'Content refresh & consolidation',
                    'desc'     => 'Update, merge or retire old pages so your site has fewer, stronger pages that answer questions well.',
                    'includes' => ['Content inventory with performance data', 'Update, merge or remove decision per page', 'Redirects for retired pages', 'Before-and-after tracking'],
                    'tags'     => ['Refresh', 'Consolidation', 'Redirects'],
                    'stack'    => ['googlesearchconsole', 'googleanalytics', 'semrush'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sites with years of content and declining traffic.',
                ],
                [
                    'key'      => 'digital-pr',
                    'name'     => 'Digital PR & citations',
                    'desc'     => 'Earn mentions and links from trusted publications and industry sources, which help both your rankings and how AI systems judge your brand.',
                    'includes' => ['Story angles built on useful data', 'Outreach to relevant publications', 'Citation and link tracking', 'Recovery of unlinked brand mentions'],
                    'tags'     => ['Citations', 'Authority', 'Links'],
                    'stack'    => ['ahrefs', 'semrush'],
                    'time'     => 'Ongoing, monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands in competitive categories that need more authority.',
                ],
            ]],

            ['key' => 'local-seo', 'name' => 'Local search', 'icon' => 'pin', 'offers' => [
                [
                    'key'      => 'local-seo',
                    'name'     => 'Local SEO',
                    'desc'     => 'Show up when nearby customers search for what you offer, in the map results, Google Maps and “near me” searches.',
                    'includes' => ['Google Business Profile optimisation', 'Location pages with local structured data', 'Consistent name, address and phone details across directories', 'Review and response guidance'],
                    'tags'     => ['Google Business Profile', 'Maps', 'Near me'],
                    'stack'    => ['google', 'schemaorg', 'googlesearchconsole'],
                    'time'     => '4–8 weeks, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Clinics, shops, restaurants and service businesses.',
                ],
                [
                    'key'      => 'multi-location-seo',
                    'name'     => 'Multi-location SEO',
                    'desc'     => 'Manage search visibility for tens or hundreds of branches or stores, with location pages and profiles kept accurate at scale.',
                    'includes' => ['Scalable location page templates', 'Bulk profile management', 'Local structured data for every branch', 'Reporting by location'],
                    'tags'     => ['Multi-location', 'At scale'],
                    'stack'    => ['google', 'schemaorg', 'googleanalytics'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Franchises, retail chains and multi-branch service brands.',
                ],
                [
                    'key'      => 'reviews-local',
                    'name'     => 'Reviews & local reputation',
                    'desc'     => 'A steady way to earn and respond to customer reviews, which influence both local rankings and whether people choose you.',
                    'includes' => ['Review requests by email or WhatsApp', 'Response templates and guidance', 'Review monitoring across platforms', 'Rating and volume reporting'],
                    'tags'     => ['Reviews', 'Reputation', 'Local ranking'],
                    'stack'    => ['google', 'whatsapp'],
                    'time'     => '2–4 weeks, then monthly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Local businesses with few or outdated reviews.',
                ],
            ]],

            ['key' => 'measurement', 'name' => 'Measurement & programmes', 'icon' => 'chart', 'offers' => [
                [
                    'key'      => 'analytics-setup',
                    'name'     => 'Analytics & tag management (GA4)',
                    'desc'     => 'Accurate tracking of visits, leads and sales with Google Analytics 4 and Google Tag Manager, set up with consent so the numbers can be trusted.',
                    'includes' => ['Measurement plan tied to business goals', 'GA4 and Tag Manager implementation', 'Consent mode and cookie banner integration', 'Conversion and e-commerce events', 'Testing of every tag'],
                    'tags'     => ['GA4', 'Tag Manager', 'Consent mode'],
                    'stack'    => ['googleanalytics', 'googletagmanager', 'googlesearchconsole'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams unsure whether their analytics numbers are right.',
                ],
                [
                    'key'      => 'visibility-dashboard',
                    'name'     => 'Search & AI visibility dashboard',
                    'desc'     => 'One dashboard for rankings, organic traffic, conversions and AI visibility, so progress is clear to leadership every month.',
                    'includes' => ['Data from Search Console, GA4 and rank tracking', 'AI visibility measures', 'Monthly commentary and next steps', 'Access for stakeholders'],
                    'tags'     => ['Dashboard', 'Monthly', 'Leadership view'],
                    'stack'    => ['looker', 'googlesearchconsole', 'googleanalytics'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leaders who want a clear line from search work to results.',
                ],
                [
                    'key'      => 'conversion-optimisation',
                    'name'     => 'Landing page conversion optimisation',
                    'desc'     => 'Turn more of your search visitors into enquiries or sales by testing page layout, messaging and forms.',
                    'includes' => ['Funnel and behaviour analysis', 'Test ideas ranked by expected impact', 'A/B tests on key pages', 'Results report'],
                    'tags'     => ['CRO', 'A/B testing', 'Forms'],
                    'stack'    => ['googleanalytics', 'posthog', 'googletagmanager'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sites with healthy traffic and too few enquiries.',
                ],
                [
                    'key'      => 'visibility-programme',
                    'name'     => 'Ongoing SEO & AI visibility programme',
                    'desc'     => 'A monthly programme that combines technical fixes, content and AI visibility work, planned every quarter and reported against the baseline.',
                    'includes' => ['Quarterly plan with monthly sprints', 'Technical monitoring', 'Content and authority work', 'Monthly report'],
                    'tags'     => ['SEO', 'AEO', 'GEO'],
                    'stack'    => ['googlesearchconsole', 'semrush', 'googleanalytics', 'perplexity'],
                    'time'     => 'Ongoing, 90-day cycles',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses where search is a core source of customers.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'retainer', 'project'],
    ],

    /* =============================================================================================
       09 · Audits & Assessments
       ============================================================================================= */
    'audits-assessments' => [
        'discipline' => 'technology-intelligence',
        'title'      => '<span class="g">Know what is broken and what it costs,</span> before you spend on fixing it.',
        'lead'       => 'Independent, evidence-based audits of your technology. Each one finds what is wrong, estimates what it is costing you and ranks what to fix first, in a report written for leadership and engineers alike.',
        'categories' => [

            ['key' => 'engineering-audits', 'name' => 'Engineering audits', 'icon' => 'code', 'offers' => [
                [
                    'key'      => 'code-audit',
                    'name'     => 'Technical & code audit',
                    'desc'     => 'An independent review of your codebase and architecture: quality, security, test coverage, dependencies and how hard it will be to build what comes next.',
                    'includes' => ['Code quality and maintainability review', 'Architecture and scalability review', 'Dependency and licence check', 'Test coverage and delivery pipeline review', 'Ranked remediation backlog'],
                    'tags'     => ['Code quality', 'Architecture', 'Tech debt'],
                    'stack'    => ['sonarqubecloud', 'snyk', 'github'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Before a funding round, acquisition, replatform or handover to a new vendor.',
                ],
                [
                    'key'      => 'performance-audit',
                    'name'     => 'Performance audit',
                    'desc'     => 'Find out why your site or app is slow for real users, using field data and load tests, and what each fix is worth.',
                    'includes' => ['Core Web Vitals from field data against LCP ≤ 2.5 s, INP ≤ 200 ms and CLS ≤ 0.1', 'Back-end and database profiling', 'Load test to find the limits', 'Prioritised fixes with expected gains'],
                    'tags'     => ['Core Web Vitals', 'Load testing', 'Profiling'],
                    'stack'    => ['pagespeedinsights', 'lighthouse', 'k6', 'datadog'],
                    'time'     => '1–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sites and apps with slow pages or problems under load.',
                ],
                [
                    'key'      => 'delivery-assessment',
                    'name'     => 'Delivery & DevOps assessment',
                    'desc'     => 'Measure how quickly and safely your team ships software, using the four DORA metrics, and find what slows releases down.',
                    'includes' => ['DORA metrics: deployment frequency, lead time, change failure rate and time to restore', 'Pipeline and release process review', 'Environments and tooling review', 'Improvement roadmap'],
                    'tags'     => ['DORA metrics', 'CI/CD', 'Release process'],
                    'stack'    => ['github', 'gitlab', 'githubactions', 'jira'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Engineering leaders whose releases feel slow or risky.',
                ],
                [
                    'key'      => 'technical-due-diligence',
                    'name'     => 'Technical due diligence',
                    'desc'     => 'An independent technical assessment of a company, product or vendor before you invest in it, acquire it or depend on it.',
                    'includes' => ['Architecture, code and security review', 'Team and process interviews', 'Scalability, cost and key-person risks', 'Findings written for investors or the board'],
                    'tags'     => ['Due diligence', 'M&A', 'Investment'],
                    'stack'    => ['sonarqubecloud', 'snyk'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Investors, acquirers and buyers of business-critical software.',
                ],
            ]],

            ['key' => 'security-compliance', 'name' => 'Security, compliance & accessibility', 'icon' => 'shield', 'offers' => [
                [
                    'key'      => 'security-assessment',
                    'name'     => 'Security assessment',
                    'desc'     => 'A structured check of your applications, cloud and access controls for vulnerabilities and weak configuration, ranked by risk. Active testing happens only under a signed scope.',
                    'includes' => ['Vulnerability assessment', 'Cloud and identity configuration review', 'Threat model of critical systems', 'Risk-ranked findings and fixes'],
                    'tags'     => ['Vulnerabilities', 'Cloud configuration', 'Risk-ranked'],
                    'stack'    => ['burpsuite', 'trivy', 'snyk', 'owasp'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies that have never had an independent security review.',
                ],
                [
                    'key'      => 'compliance-gap',
                    'name'     => 'Compliance gap assessment',
                    'desc'     => 'Find how far you are from ISO/IEC 27001:2022, SOC 2 or the DPDP Act 2023, and what it will take to close the gaps. This prepares you for an audit; it is not a certification.',
                    'includes' => ['Control-by-control gap analysis', 'Review of existing evidence', 'Effort estimate to close each gap', 'Roadmap to audit'],
                    'tags'     => ['ISO/IEC 27001:2022', 'SOC 2', 'DPDP Act 2023'],
                    'stack'    => [],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies asked for compliance evidence by customers or regulators.',
                ],
                [
                    'key'      => 'accessibility-audit',
                    'name'     => 'Accessibility audit (WCAG 2.2 AA)',
                    'desc'     => 'Test your site or app against WCAG 2.2 Level AA with automated tools and with people using screen readers and keyboards, and get a clear fix list.',
                    'includes' => ['Automated scans of key templates', 'Manual testing with assistive technology', 'Issues mapped to WCAG success criteria', 'Fix guidance in priority order'],
                    'tags'     => ['WCAG 2.2 AA', 'Manual testing', 'Screen readers'],
                    'stack'    => ['lighthouse', 'playwright'],
                    'time'     => '1–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Public-facing services and companies with accessibility obligations.',
                ],
            ]],

            ['key' => 'search-data-audits', 'name' => 'Search, data & analytics audits', 'icon' => 'search', 'offers' => [
                [
                    'key'      => 'website-health-check',
                    'name'     => 'Website health check',
                    'desc'     => 'A fast, combined check of speed, SEO, accessibility and security basics for one website, with the handful of fixes that matter most.',
                    'includes' => ['Core Web Vitals and speed check', 'SEO and indexing basics', 'Accessibility spot checks', 'Security headers and exposure basics', 'Top fixes in priority order'],
                    'tags'     => ['Quick start', 'Speed · SEO · a11y', 'Security basics'],
                    'stack'    => ['lighthouse', 'pagespeedinsights', 'googlesearchconsole'],
                    'time'     => '1 week',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Small and mid-size businesses wanting a quick, low-risk first look.',
                ],
                [
                    'key'      => 'seo-audit',
                    'name'     => 'SEO & AI visibility audit',
                    'desc'     => 'Why your site is not ranking or being cited as it should: crawl and index issues, content gaps, structured data, and how answer engines describe your brand today.',
                    'includes' => ['Technical crawl and index review', 'Content and keyword gap analysis', 'Structured data and entity check', 'AI answer engine visibility baseline', 'Prioritised action plan'],
                    'tags'     => ['SEO', 'AEO · GEO', 'Baseline'],
                    'stack'    => ['googlesearchconsole', 'semrush', 'ahrefs', 'lighthouse'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Sites with falling organic traffic, or before a redesign.',
                ],
                [
                    'key'      => 'data-analytics-audit',
                    'name'     => 'Data & analytics audit',
                    'desc'     => 'Check whether your data and reports can be trusted: tracking accuracy, data quality, metric definitions, lineage and consent handling.',
                    'includes' => ['Tracking and tag review', 'Data quality and lineage checks', 'Metric definition review', 'Consent and privacy handling check'],
                    'tags'     => ['Data quality', 'Tracking', 'Consent'],
                    'stack'    => ['googleanalytics', 'googletagmanager', 'dbt', 'googlebigquery'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams making decisions on numbers they do not fully trust.',
                ],
            ]],

            ['key' => 'ai-cloud-assessments', 'name' => 'AI & cloud assessments', 'icon' => 'brain', 'offers' => [
                [
                    'key'      => 'ai-readiness-assessment',
                    'name'     => 'AI readiness assessment',
                    'desc'     => 'Score how ready your data, systems, skills and governance are for AI, and list what to fix before the first build.',
                    'includes' => ['Readiness score across data, infrastructure, skills and governance', 'Use-case readiness review', 'Risk and compliance check', 'Prerequisite roadmap'],
                    'tags'     => ['Readiness score', 'Prerequisites'],
                    'stack'    => [],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations planning an AI programme or a first AI build.',
                ],
                [
                    'key'      => 'ai-system-review',
                    'name'     => 'AI system review',
                    'desc'     => 'An independent check of an AI feature or agent already in use: answer quality, safety, cost and oversight.',
                    'includes' => ['Evaluation on real examples', 'Prompt injection and data-leak checks against the OWASP Top 10 for LLM Applications', 'Cost and latency review', 'Governance and oversight review'],
                    'tags'     => ['Evals', 'OWASP LLM Top 10', 'Cost'],
                    'stack'    => ['openai', 'anthropic', 'langchain'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with AI live and open questions about how well it works.',
                ],
                [
                    'key'      => 'cloud-cost-audit',
                    'name'     => 'Cloud cost audit',
                    'desc'     => 'Find where your cloud bill goes and how much of it can be saved, with each saving sized and risk-rated.',
                    'includes' => ['Spend breakdown by service and team', 'Idle and oversized resources', 'Commitment and pricing options', 'Savings plan with estimates'],
                    'tags'     => ['FinOps', 'Savings plan'],
                    'stack'    => ['amazonwebservices', 'microsoftazure', 'googlecloud'],
                    'time'     => '1–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies with a cloud bill growing faster than usage.',
                ],
                [
                    'key'      => 'resilience-assessment',
                    'name'     => 'Cloud architecture & resilience assessment',
                    'desc'     => 'Review how your cloud is built for reliability, security and recovery, including whether your backups actually restore.',
                    'includes' => ['Architecture review', 'Single points of failure', 'Backup restore test', 'Recovery target (RTO and RPO) gap analysis'],
                    'tags'     => ['Resilience', 'RTO · RPO', 'Restore test'],
                    'stack'    => ['amazonwebservices', 'microsoftazure', 'googlecloud', 'terraform'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Businesses where an outage would be costly.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'enterprise'],
    ],

    /* =============================================================================================
       10 · Tech Workforce
       ============================================================================================= */
    'tech-workforce' => [
        'discipline' => 'technology-intelligence',
        'title'      => '<span class="g">Add engineers to your team in weeks,</span> not after a hiring cycle.',
        'lead'       => 'Vetted engineers, AI specialists and full delivery squads who work in your stack, your tools and your sprint cadence. Choose a single role, a whole team or technical leadership, and scale up or down as the work changes.',
        'categories' => [

            ['key' => 'squads', 'name' => 'Dedicated squads', 'icon' => 'layers', 'offers' => [
                [
                    'key'      => 'product-squad',
                    'name'     => 'Dedicated product squad',
                    'desc'     => 'A cross-functional team, typically a lead, engineers, QA and design, that owns an outcome in your product and works in your sprints.',
                    'includes' => ['Squad shaped to the outcome', 'Delivery lead and agreed goals', 'Work in your tools and ceremonies', 'Monthly delivery review'],
                    'tags'     => ['Cross-functional', 'Outcome-owned', 'Your cadence'],
                    'stack'    => ['jira', 'linear', 'github', 'figma'],
                    'time'     => 'Start in 2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies with a clear product goal and no team free to deliver it.',
                ],
                [
                    'key'      => 'ai-data-squad',
                    'name'     => 'AI & data squad',
                    'desc'     => 'A team of LLM, machine-learning and data engineers to build and run AI features, from retrieval and agents to evaluation and MLOps.',
                    'includes' => ['LLM application and ML engineers', 'Data engineering and MLOps support', 'Evaluation practice from day one', 'Knowledge transfer to your team'],
                    'tags'     => ['LLM', 'ML', 'MLOps'],
                    'stack'    => ['python', 'pytorch', 'langchain', 'mlflow', 'databricks'],
                    'time'     => 'Start in 3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with AI plans and no specialists in-house.',
                ],
                [
                    'key'      => 'qa-squad',
                    'name'     => 'QA & test automation team',
                    'desc'     => 'Testers and automation engineers who build a reliable test suite, so releases stop waiting on manual checks.',
                    'includes' => ['Test strategy', 'Automated UI and API tests', 'Regression suites in CI', 'Release quality reports'],
                    'tags'     => ['Test automation', 'Regression', 'CI'],
                    'stack'    => ['playwright', 'cypress', 'selenium', 'postman', 'k6'],
                    'time'     => 'Start in 2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams where releases are held up by manual testing.',
                ],
            ]],

            ['key' => 'staff-augmentation', 'name' => 'Staff augmentation by role', 'icon' => 'users', 'offers' => [
                [
                    'key'      => 'frontend-engineers',
                    'name'     => 'Frontend engineers',
                    'desc'     => 'Engineers who build fast, accessible interfaces in React, Next.js, Angular or Vue, joining your existing team and rituals.',
                    'includes' => ['Vetted in your stack by senior engineers', 'Accessibility and performance practice', 'Code review and tests as standard', 'First merged change in week one'],
                    'tags'     => ['React', 'Angular', 'Vue'],
                    'stack'    => ['react', 'nextdotjs', 'angular', 'vuedotjs', 'typescript'],
                    'time'     => 'Start in 2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product teams with more interface work than people.',
                ],
                [
                    'key'      => 'backend-engineers',
                    'name'     => 'Backend engineers',
                    'desc'     => 'Engineers who design APIs, data models and services in Node.js, Python, PHP, Java, Go or .NET.',
                    'includes' => ['Vetted in your stack by senior engineers', 'API and data modelling experience', 'Security and testing as standard', 'First merged change in week one'],
                    'tags'     => ['Node.js', 'Python', 'Java · Go · .NET'],
                    'stack'    => ['nodedotjs', 'python', 'laravel', 'springboot', 'go', 'dotnet'],
                    'time'     => 'Start in 2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with a growing backlog of services and integrations.',
                ],
                [
                    'key'      => 'mobile-engineers',
                    'name'     => 'Mobile engineers',
                    'desc'     => 'iOS, Android and cross-platform engineers working in Swift, Kotlin, Flutter or React Native.',
                    'includes' => ['Native or cross-platform specialists', 'Store release experience', 'Crash and performance discipline', 'First merged change in week one'],
                    'tags'     => ['iOS', 'Android', 'Flutter · React Native'],
                    'stack'    => ['swift', 'kotlin', 'flutter', 'reactnative'],
                    'time'     => 'Start in 2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies scaling a mobile product or starting a new app.',
                ],
                [
                    'key'      => 'devops-engineers',
                    'name'     => 'DevOps & cloud engineers',
                    'desc'     => 'Engineers who build pipelines, infrastructure as code and Kubernetes platforms, and keep production healthy.',
                    'includes' => ['AWS, Azure or Google Cloud experience', 'Infrastructure as code and CI/CD', 'Monitoring and on-call practice', 'Runbooks written as they go'],
                    'tags'     => ['DevOps', 'Kubernetes', 'IaC'],
                    'stack'    => ['kubernetes', 'terraform', 'amazonwebservices', 'githubactions', 'docker'],
                    'time'     => 'Start in 2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose developers spend too much time on infrastructure.',
                ],
                [
                    'key'      => 'data-ai-engineers',
                    'name'     => 'Data, ML & AI engineers',
                    'desc'     => 'Data engineers, ML engineers, LLM application engineers and data scientists: the roles that are hardest to hire.',
                    'includes' => ['Vetted on real data and AI tasks', 'Pipeline, model and evaluation experience', 'Documentation and reproducible work', 'Knowledge transfer to your team'],
                    'tags'     => ['Data engineering', 'ML', 'LLM apps'],
                    'stack'    => ['python', 'pytorch', 'databricks', 'dbt', 'langchain'],
                    'time'     => 'Start in 3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies building data platforms or AI features without in-house specialists.',
                ],
                [
                    'key'      => 'product-design-qa',
                    'name'     => 'Product, design & QA specialists',
                    'desc'     => 'Product managers, product designers and QA engineers to complete a team that has engineers but lacks these roles.',
                    'includes' => ['Product discovery and backlog ownership', 'Interface design in your design system', 'Manual and automated testing', 'Work in your rituals and tools'],
                    'tags'     => ['Product', 'Design', 'QA'],
                    'stack'    => ['figma', 'jira', 'playwright'],
                    'time'     => 'Start in 2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Engineering-led teams missing product, design or quality roles.',
                ],
            ]],

            ['key' => 'leadership', 'name' => 'Technical leadership', 'icon' => 'compass', 'offers' => [
                [
                    'key'      => 'fractional-cto',
                    'name'     => 'Fractional CTO',
                    'desc'     => 'An experienced technology leader for a set number of days a month: setting technical direction, making architecture calls, guiding hiring and speaking for technology to your board and investors.',
                    'includes' => ['Technology strategy and roadmap', 'Architecture and vendor decisions', 'Hiring plan and interviews', 'Board and investor technical updates'],
                    'tags'     => ['Part-time', 'Strategic', 'Board-ready'],
                    'stack'    => [],
                    'time'     => 'Ongoing, set days each month',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Start-ups and growing companies not yet ready for a full-time CTO.',
                ],
                [
                    'key'      => 'tech-lead',
                    'name'     => 'Technical lead or architect',
                    'desc'     => 'A senior engineer who leads your team day to day: setting standards, reviewing code, making architecture decisions and unblocking delivery.',
                    'includes' => ['Architecture decisions and records', 'Code review standards', 'Mentoring for your engineers', 'Delivery planning with product'],
                    'tags'     => ['Tech lead', 'Architecture', 'Mentoring'],
                    'stack'    => ['github', 'confluence'],
                    'time'     => 'Start in 3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams without senior technical leadership.',
                ],
                [
                    'key'      => 'delivery-manager',
                    'name'     => 'Delivery management',
                    'desc'     => 'A delivery manager who runs planning, tracks progress and risk, and keeps stakeholders clearly informed.',
                    'includes' => ['Sprint planning and ceremonies', 'Risk and dependency tracking', 'Throughput and DORA reporting', 'Stakeholder updates'],
                    'tags'     => ['Delivery', 'Risk', 'Reporting'],
                    'stack'    => ['jira', 'linear', 'confluence'],
                    'time'     => 'Start in 2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Programmes with several teams or vendors to coordinate.',
                ],
            ]],

            ['key' => 'scaling', 'name' => 'Team scaling', 'icon' => 'trend-up', 'offers' => [
                [
                    'key'      => 'launch-scaling',
                    'name'     => 'Team scaling for launches',
                    'desc'     => 'Add capacity for a launch, migration or peak, then scale back afterwards, with knowledge written down so nothing leaves with the extra people.',
                    'includes' => ['Capacity plan tied to the milestone', 'Fast onboarding', 'Documentation and handover', 'Planned ramp-down'],
                    'tags'     => ['Flexible capacity', 'Handover'],
                    'stack'    => ['jira', 'github', 'confluence'],
                    'time'     => 'Start in 2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams facing a fixed deadline with too few people.',
                ],
                [
                    'key'      => 'contract-to-hire',
                    'name'     => 'Contract-to-hire',
                    'desc'     => 'Work with an engineer on your team first, then hire them permanently on conversion terms agreed in the contract from the start.',
                    'includes' => ['Conversion terms agreed up front', 'Trial period in your real work', 'Monthly fit review', 'Smooth transfer at conversion'],
                    'tags'     => ['Try before you hire', 'Conversion'],
                    'stack'    => [],
                    'time'     => 'Start in 2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies that want to hire permanently with less risk.',
                ],
                [
                    'key'      => 'build-operate-transfer',
                    'name'     => 'Build-operate-transfer',
                    'desc'     => 'We build and run a team for you, then transfer the people, processes and knowledge to your own organisation on an agreed timeline.',
                    'includes' => ['Team design and hiring', 'Operate phase with delivery management', 'Processes and documentation', 'Transfer plan for people and knowledge'],
                    'tags'     => ['BOT', 'Capability build', 'Transfer'],
                    'stack'    => [],
                    'time'     => '12–36 months, by agreement',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Companies building their own long-term engineering team in India.',
                ],
            ]],
        ],
        'packages' => ['squad', 'retainer', 'enterprise'],
    ],
];
