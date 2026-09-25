<?php
/**
 * Industries — the six approved categories, in depth. Read by industries.php only.
 *
 * The category names come from data/site.php and the home-page industries rail
 * (sections/03-industries.php) — the client's approved copy. 'name' here must match it exactly:
 * Consumer health · Financial services · Retail and commerce · B2B technology · Hospitality ·
 * Telecom and media. Do not add a seventh category here without confirming it with the owner.
 *
 * Fields per category
 *   n, slug, name, short, kicker, icon   index, anchor slug, approved name, chip label, eyebrow, xt_icon name
 *   line                                 one sentence for the index in #scope
 *   led                                  the two discipline slugs that usually lead here
 *   pressure                             what the category is under, in two or three sentences
 *   different                            3 × [title, text] — what is genuinely different here
 *   work                                 6 × [discipline slug, capability slug or null, what we do]
 *                                        Capability slugs exist only for brand-design and
 *                                        technology-intelligence; the other four resolve to the hub.
 *   rules                                [instrument, what it decides] — named only where it applies
 *   badges                               xt_standards() keys for xt_badge() — frameworks we build to
 *   measures                             3 × [measure, how it is defined] — targets, never results
 *   stack                                data/tech-stack.php slugs — technologies we work with
 *   fixed                                systems of record that are a given in this category
 *   first                                a typical first engagement
 *   ai                                   ['agent','ground','log' => [[time, step, line]]]
 *   lens                                 5 answers, in the order of the five questions below
 *   teams                                who we usually work with on the client side
 *
 * Cross-cutting keys: 'lens' (the five questions), 'transfer', 'rules' (the instruments, once,
 * with what each changes in the work), 'adjacent', 'start', 'faq'.
 *
 * Truthfulness: no client names, no case studies, no achieved results. Every number is a target,
 * a threshold set in a standard, or a definition. Regulatory notes are a summary for orientation,
 * not legal advice, and a regulation is named only where it actually binds.
 *
 * Voice: calm, precise, confident. Short active sentences. No exclamation marks.
 */

return [

/* ------------------------------------------------------------------------ *
 *  The six categories
 * ------------------------------------------------------------------------ */
'set' => [

'consumer-health' => [
    'n' => '01', 'slug' => 'consumer-health', 'name' => 'Consumer health', 'short' => 'Health',
    'kicker' => 'Claims are the constraint', 'icon' => 'clipboard-check',
        'line' => 'Trust-led, claims-bound, and increasingly decided by a search result before a shelf.',
    'led' => ['campaign-content', 'brand-design'],
    'pressure' => 'Consumer health is bought on trust and sold under a claims regime. The same product has to be explained to a pharmacist, to a physician and to someone who searched a symptom at midnight, and every one of those explanations is reviewable. Quick commerce has compressed the decision to minutes, and answer engines now summarise the category before a brand gets a word in.',
    'different' => [
        ['Every claim has an owner', 'Copy is not a creative decision here. A benefit line traces back to a permitted claim, a dossier or a study, and the approval sits in the record beside it. Design that ignores this gets rebuilt at review.'],
        ['Pack and listing are one artefact', 'Mandatory declarations, ingredients and warnings have to match across the carton, the marketplace listing and the brand’s own product page. Most defects in this category are drift between those three.'],
        ['Demand starts with a symptom', 'Search and AI answers are read long before a brand is considered, so category education has to be publishable, sourced, and safe when it is quoted out of context.'],
    ],
    'work' => [
        ['brand-design', 'brand-architecture', 'Architecture across an over-the-counter range, a prescription portfolio and a wellness line, so one master brand can carry all three without implying a claim it cannot make.'],
        ['campaign-content', null, 'Claims-safe campaign systems: one message framework over a library of approved language, so seasonal and regional work ships without reopening review.'],
        ['product-experience', null, 'Symptom-to-product journeys, dosage and interaction clarity, and label information design that holds up for someone reading a pack in a hurry.'],
        ['technology-intelligence', 'websites-apps', 'A content platform with medical, legal and regulatory review inside the workflow: versioned copy, a reviewer of record, and an audit trail per claim.'],
        ['ai-design', null, 'An assistant that answers only from approved claim language, refuses diagnosis and dosage change, and cites the line it used. Every refusal is logged as a content gap.'],
        ['marketing-technology', null, 'Consent captured per purpose, so a refill reminder and a marketing offer never travel on the same permission.'],
    ],
    'rules' => [
        ['Drugs and Magic Remedies (Objectionable Advertisements) Act, 1954', 'Bars advertising that claims to treat the conditions it lists. It decides what a benefit line may say before any design starts.'],
        ['Drugs and Cosmetics Act, 1940 and Rules, 1945 · CDSCO', 'Labelling, and for Schedule H and H1 drugs no advertising to the public at all.'],
        ['FSSAI Advertising and Claims Regulations, 2018', 'Foods and nutraceuticals: which health claims are permitted, and what evidence has to sit behind them.'],
        ['Legal Metrology (Packaged Commodities) Rules, 2011', 'The declarations on the pack have to appear on every e-commerce listing of it.'],
        ['ASCI code and its health and wellness guidelines', 'Self-regulatory, and the fastest route to a complaint. Influencer disclosure is part of it.'],
        ['DPDP Act, 2023', 'Health questions are personal data. The Act has no separate sensitive class, so the consent notice and purpose limitation carry the weight.'],
        ['Telemedicine Practice Guidelines, 2020 · teleconsultation only', 'What a registered practitioner may advise remotely, and what the consultation record must hold.'],
        ['HIPAA Security Rule · only where US protected health information is in scope', 'A US telehealth or care-coordination product brings HIPAA with it. An Indian over-the-counter brand does not, and we do not pretend otherwise.'],
    ],
    'badges' => ['dpdp', 'iso27701', 'wcag22', 'owasp-llm'],
    'measures' => [
        ['Rounds through medical, legal and regulatory review', 'Counted per asset from submission to approval. The target is fewer rounds, not a faster reviewer.'],
        ['Listing completeness across marketplaces', 'The share of live listings carrying the declarations, warnings and ingredient data that the pack carries. Checked on a schedule, not at launch.'],
        ['Grounded-answer rate for the assistant', 'The share of answers fully supported by approved claim language, scored on a fixed set of real questions before every release, with an agreed release gate.'],
    ],
    'stack' => ['contentful', 'sanity', 'shopify', 'nextdotjs', 'algolia', 'schemaorg', 'googletagmanager', 'googleanalytics', 'zoho', 'pgvector', 'openai', 'anthropic'],
    'fixed' => ['Distributor and trade ERP', 'Marketplace seller APIs', 'Medical and regulatory review system', 'ABDM consent artefacts, where the national health stack is in scope'],
    'first' => 'A claims and listing audit across pack, product page and marketplace, then one review workflow that every market uses.',
    'ai' => [
        'agent' => 'Approved-language answer assistant',
        'ground' => 'The approved claim library and the current pack copy. Nothing else is reachable.',
        'log' => [
            ['09:41:02', 'intake',   'question · “can I take this with my blood pressure tablet?”'],
            ['09:41:02', 'policy',   'claim library v12 · no diagnosis · no dosage advice'],
            ['09:41:03', 'retrieve', '2 sources · approved claim 41 · pack insert, current version'],
            ['09:41:03', 'refuse',   'interaction advice is out of scope for this assistant'],
            ['09:41:04', 'answer',   'approved wording + “speak to your pharmacist or doctor”'],
            ['09:41:04', 'log',      'gap recorded → review queue · interactions FAQ'],
        ],
    ],
    'lens' => [
        'A symptom search, then a pharmacist, then a repeat purchase.',
        'Claim law first: what a benefit line may say at all.',
        'Carton, pharmacy shelf, marketplace listing, symptom answer.',
        'Health questions are personal data. Consent per purpose, short retention.',
        'Fewer review rounds, complete listings, repeat purchase.',
    ],
    'teams' => ['Marketing', 'Regulatory affairs', 'Trade and e-commerce', 'Medical'],
],

'financial-services' => [
    'n' => '02', 'slug' => 'financial-services', 'name' => 'Financial services', 'short' => 'Finance',
    'kicker' => 'Disclosure is design', 'icon' => 'shield',
        'line' => 'Digital distribution, under a supervisor who reads the advertising.',
    'led' => ['technology-intelligence', 'product-experience'],
    'pressure' => 'Distribution is digital, the product is trust, and the supervisor reads the advertising. Every screen that quotes a rate, a return or a premium carries a disclosure that has to be as legible as the offer. Meanwhile applications abandon in the middle of identity checks, and the cost of a funded account keeps climbing.',
    'different' => [
        ['The disclosure is part of the component', 'A key fact statement, a risk line or a benefit illustration is not a footnote to be styled later. It ships inside the component, with the offer, in the design system.'],
        ['The engagement itself is supervised', 'Working with a regulated entity puts the partner under the same outsourcing rules: named accountability, a right to audit, incident reporting and a documented exit.'],
        ['Card data is designed out', 'Scope is reduced on purpose. Network tokens and a hosted payment page keep card numbers out of your systems, so the payment standard applies where it should and nowhere else.'],
    ],
    'work' => [
        ['brand-design', 'brand-systems', 'A system in which the rate, the risk line and the disclosure all have components, so a campaign cannot ship a compliant headline over a non-compliant screen.'],
        ['campaign-content', null, 'Creative that survives review: one claim framework, pre-cleared disclosure variants, and a route for regional language versions that does not restart approval.'],
        ['product-experience', null, 'Onboarding measured screen by screen, including video identity checks, document re-capture, and the exact point where an applicant gives up.'],
        ['technology-intelligence', 'cybersecurity-ai-trust', 'Security and AI-trust work sized for a regulated entity: threat modelling, logs held in India, six-hour incident reporting, and evidence a supervisor can read.'],
        ['ai-design', null, 'Assist, never decide. Fraud triage, collections prioritisation and service summaries, each with a human approval step and the full input set stored.'],
        ['marketing-technology', null, 'Consent, preference and suppression handled once, so a marketing message and a mandatory servicing message never travel on the same permission.'],
    ],
    'rules' => [
        ['RBI Master Direction on Outsourcing of Information Technology Services, 2023', 'Governs how a regulated entity may use a partner: due diligence, a right to audit, and a documented exit plan.'],
        ['RBI direction on Storage of Payment System Data, 2018', 'Payment system data is stored only in India. It fixes the hosting region before the architecture is drawn.'],
        ['RBI directions on digital lending', 'A key fact statement before disbursal, the lending service provider disclosed, and no data held on the app beyond what the loan needs.'],
        ['PCI DSS v4.0.1 · wherever card data is handled', 'Card-on-file tokenisation keeps most of the estate out of the widest scope. What remains still has to be provable.'],
        ['SEBI advertisement code and the Cybersecurity and Cyber Resilience Framework', 'Market-facing entities: standard risk wording on every investment communication, and a resilience framework behind it.'],
        ['IRDAI advertisement regulations', 'Insurance: benefit illustrations and exclusions carried with the offer, not linked away from it.'],
        ['DPDP Act, 2023 · CERT-In Directions, 2022', 'Consent and purpose limits, plus reportable incidents within six hours and 180 days of logs held in India.'],
        ['Account Aggregator framework', 'Where financial data is shared with consent, the consent artefact and its purpose are part of the product design.'],
    ],
    'badges' => ['pci-dss', 'dpdp', 'cert-in', 'iso27001', 'soc2'],
    'measures' => [
        ['Completion through onboarding, step by step', 'Not one funnel number: the drop at each screen, with identity re-capture counted separately from abandonment.'],
        ['Cost per funded account or issued policy', 'Media and servicing cost against accounts that actually funded. It is the only version of the number finance recognises.'],
        ['Share of AI-assisted decisions with a recorded reviewer', 'The target is all of them. An assist with no named approver and no stored input set is not shippable in this category.'],
    ],
    'stack' => ['salesforce', 'razorpay', 'stripe', 'snowflake', 'apachekafka', 'postgresql', 'okta', 'vault', 'opentelemetry', 'anthropic', 'pgvector', 'kubernetes'],
    'fixed' => ['Core banking or policy administration', 'Card switch and payment service provider', 'Central KYC registry and credit bureaux', 'Account Aggregator network', 'UPI and the national payment rails'],
    'first' => 'An onboarding drop-off study read against the disclosure rules that bind each screen, then one fix shipped and measured.',
    'ai' => [
        'agent' => 'Dispute and fraud triage assistant',
        'ground' => 'Your dispute policy, the transaction ledger and the customer’s verification status. No card numbers enter the prompt.',
        'log' => [
            ['14:02:11', 'intake',    'case #4821 · chargeback dispute · card masked at ingest'],
            ['14:02:11', 'policy',    'no card data in prompt · region ap-south-1 · retention 180d'],
            ['14:02:12', 'retrieve',  '3 sources · dispute policy v7 · txn ledger · verification status'],
            ['14:02:13', 'draft',     'recommendation · raise pre-arbitration · 2 cited rules'],
            ['14:02:13', 'guardrail', 'injection check passed · tool calls inside allow-list'],
            ['14:02:14', 'hold',      'awaiting approval · queue · disputes, second line'],
            ['14:06:02', 'approved',  'reviewer recorded · inputs and model version stored'],
        ],
    ],
    'lens' => [
        'A product owner, a compliance officer and a risk committee.',
        'RBI, SEBI or IRDAI, depending on the licence you hold.',
        'The app, the branch, an aggregator, and the disclosure on every screen.',
        'Payment system data stays in India. Logs stay 180 days.',
        'Step-by-step onboarding completion and cost per funded account.',
    ],
    'teams' => ['Digital and product', 'Compliance and risk', 'Marketing', 'Information security'],
],

'retail-and-commerce' => [
    'n' => '03', 'slug' => 'retail-and-commerce', 'name' => 'Retail and commerce', 'short' => 'Retail',
    'kicker' => 'Peaks, phones and persuasion rules', 'icon' => 'cube',
        'line' => 'Won on a mid-range phone during a peak, under tightening rules on persuasion.',
    'led' => ['technology-intelligence', 'marketing-technology'],
    'pressure' => 'Discovery has moved to marketplaces, quick commerce and AI answers, and the storefront has to be quick on a mid-range Android on a weak network. Sale days arrive with an order of magnitude more traffic than a normal Tuesday. The rules on how you may persuade have tightened, and the cost of a return quietly decides whether a category makes money.',
    'different' => [
        ['Persuasion is regulated now', 'India’s dark-pattern guidelines name thirteen specific practices, including false urgency, drip pricing, basket sneaking and confirm-shaming. Several of them are standard conversion tactics. We design without them and say so.'],
        ['Field performance is a revenue line', 'Core Web Vitals at the 75th percentile of real page loads: largest contentful paint within 2.5 s, interaction to next paint within 200 ms, layout shift under 0.1. A lab score proves nothing here.'],
        ['The catalogue is the brand', 'A product page is a legal document, a search result and a sales pitch at once. Mandatory declarations, structured data and the brand’s own voice all have to hold in one template across thousands of lines.'],
    ],
    'work' => [
        ['brand-design', 'brand-systems', 'A system that survives thousands of lines and someone else’s template: packaging, product pages and ad units built from the same tokens.'],
        ['campaign-content', null, 'Seasonal systems that ship a whole calendar from one framework, with assets produced once and adapted per channel rather than remade per channel.'],
        ['product-experience', null, 'Search, browse and checkout rebuilt around the real device and network, with returns treated as a designed journey instead of a leak.'],
        ['technology-intelligence', 'search-ai-visibility', 'Search, answer-engine and generative visibility as one system: structured product data, crawlable facets, and the feeds that decide whether your catalogue is the source an answer cites.'],
        ['ai-design', null, 'Shopping assistants grounded in the live catalogue, so price, stock and the delivery promise come from the system of record and never from the model.'],
        ['marketing-technology', null, 'Retention economics: consented first-party data, lifecycle programmes, and measurement that ties a campaign to margin rather than to revenue.'],
    ],
    'rules' => [
        ['Consumer Protection (E-Commerce) Rules, 2020', 'Seller identity, country of origin, the return policy and a named grievance officer on the page itself, not buried in a help centre.'],
        ['CCPA Guidelines for Prevention and Regulation of Dark Patterns, 2023', 'Thirteen named practices that a conversion experiment may not use, from false urgency to basket sneaking.'],
        ['CCPA Guidelines on Misleading Advertisements and Endorsements, 2022', 'Due diligence behind every claim, and disclosure on paid endorsements.'],
        ['Legal Metrology (Packaged Commodities) Rules, 2011', 'The declarations on the pack have to appear on the listing too, in the fields the platform provides.'],
        ['PCI DSS v4.0.1 and RBI card-on-file tokenisation', 'Merchants do not store card numbers. Tokens and a hosted page keep the scope small and provable.'],
        ['DPDP Act, 2023', 'Marketing consent per purpose, and withdrawal that is as easy as giving it was.'],
        ['GST e-invoicing and e-way bills', 'Invoicing and movement of goods are integrations, not afterthoughts, and they shape the order model.'],
        ['Core Web Vitals · WCAG 2.2 AA', 'Build standards rather than law, enforced in the pipeline so a regression fails the build instead of the quarter.'],
    ],
    'badges' => ['cwv', 'wcag22', 'pci-dss', 'dpdp'],
    'measures' => [
        ['Conversion split by the Core Web Vitals people actually got', 'Sessions bucketed by their own field metrics, so a speed fix can be valued in revenue rather than argued about.'],
        ['Contribution margin per session', 'Revenue less discount, payment cost, fulfilment and expected returns. Sale-day revenue without this number is decoration.'],
        ['Sale-day error budget', 'Agreed before the event: the error rate and latency the peak is allowed to spend, watched live, with a rollback that has been rehearsed.'],
    ],
    'stack' => ['shopify', 'woocommerce', 'nextdotjs', 'algolia', 'cloudflare', 'razorpay', 'stripe', 'clickhouse', 'posthog', 'googlesearchconsole', 'googletagmanager', 'schemaorg'],
    'fixed' => ['Marketplace seller APIs', 'Order and warehouse management', 'Payment gateway and courier aggregators', 'GST e-invoicing and e-way bill systems', 'Product information management'],
    'first' => 'A field-performance and compliance pass over the highest-revenue templates, then a peak-readiness plan with an agreed error budget.',
    'ai' => [
        'agent' => 'Catalogue-grounded shopping assistant',
        'ground' => 'The live catalogue API, stock positions and the delivery service-level table. Price and stock are read, never generated.',
        'log' => [
            ['19:12:44', 'intake',    'question · “will this arrive before Friday at 560001?”'],
            ['19:12:44', 'ground',    'catalogue API · stock 14 · pincode service-level table'],
            ['19:12:45', 'policy',    'no urgency language · model may not state a price'],
            ['19:12:45', 'answer',    '“in stock · delivery by Thursday” + link to the product page'],
            ['19:12:46', 'log',       'answer and source rows stored · sampled into the eval set'],
        ],
    ],
    'lens' => [
        'One person, in under a minute, on a phone.',
        'Consumer protection: listings, endorsements, dark patterns.',
        'Marketplace, quick commerce, the store, an AI answer.',
        'Marketing consent per purpose, withdrawal just as easy.',
        'Contribution margin per session, not sale-day revenue.',
    ],
    'teams' => ['E-commerce', 'Brand and category marketing', 'Supply chain', 'Engineering'],
],

'b2b-technology' => [
    'n' => '04', 'slug' => 'b2b-technology', 'name' => 'B2B technology', 'short' => 'B2B tech',
    'kicker' => 'A committee, not a buyer', 'icon' => 'stack',
        'line' => 'A buying committee, a security questionnaire, and a product that changes monthly.',
    'led' => ['brand-design', 'technology-intelligence'],
    'pressure' => 'Nobody signs alone. A champion has to carry an economic buyer, a security reviewer and a procurement team, and the product changes faster than the story does. Deals stall inside a security questionnaire. The category page that used to win a search result now has to win a citation in an answer.',
    'different' => [
        ['The security review is a funnel stage', 'A questionnaire, an audit-report request or a redlined data processing agreement has a cycle time and a drop-off rate like any other stage. Treating it as a legal chore is what loses the quarter.'],
        ['The product is the proof', 'Positioning the product cannot demonstrate in the first session does not survive contact with a trial. Narrative, onboarding and the design system have to move together.'],
        ['Documentation is a growth surface', 'Docs, changelogs and reference are what engineers read and what answer engines cite. They are a product surface, not a support cost.'],
    ],
    'work' => [
        ['brand-design', 'brand-foundation', 'Positioning that a founder, a sales engineer and a procurement reviewer can each repeat without changing what it means.'],
        ['campaign-content', null, 'Content aimed at a committee: the economic case, the technical detail and the migration story as one connected library rather than three disconnected campaigns.'],
        ['product-experience', null, 'Time to first value inside the product, and one design system shared with marketing so the site and the application stop diverging.'],
        ['technology-intelligence', 'search-ai-visibility', 'Ranking and being cited: structured documentation, comparison pages that survive scrutiny, and the technical work that gets a product quoted in an AI answer.'],
        ['ai-design', null, 'A documentation assistant grounded in your own docs with citations, plus an internal answer agent for the questions sales keeps asking twice.'],
        ['marketing-technology', null, 'Account programmes wired to product usage, so outreach knows what the account has already tried and stops repeating it.'],
    ],
    'rules' => [
        ['SOC 2 and ISO/IEC 27001 · your buyer’s evidence', 'Enterprise procurement asks for a report, not an intention. We build delivery to these frameworks; the report or certificate comes from your auditor, not from us.'],
        ['GDPR · where EU personal data is processed', 'A lawful basis per purpose, a data processing agreement with every processor, a transfer mechanism, and subject requests the product can actually service.'],
        ['EU AI Act, Regulation (EU) 2024/1689', 'Obligations follow the risk class and your role. Most product features land in transparency duties; classification is cheaper before the roadmap than after it.'],
        ['DPDP Act, 2023 · Indian customers and staff', 'Consent notices, purpose limits, and an erasure path the product supports rather than promises.'],
        ['WCAG 2.2 AA and an accessibility conformance report', 'Public-sector and large-enterprise procurement asks for one. Retrofitting it is the expensive route.'],
        ['OWASP ASVS · OWASP Top 10 for LLM Applications', 'The verification standard for the application, and for AI features the list that begins with prompt injection.'],
    ],
    'badges' => ['soc2', 'iso27001', 'gdpr', 'eu-ai-act', 'wcag22', 'owasp-llm'],
    'measures' => [
        ['Pipeline created, and win rate in competitive deals', 'Attributed at account level rather than by click, so a category page earns credit for the accounts it opened.'],
        ['Security-review cycle time', 'Days from questionnaire received to questionnaire answered, and the share of deals in which it is the blocker.'],
        ['Self-serve resolution in docs and the assistant', 'The share of questions answered without a human, with everything unanswered feeding the documentation backlog.'],
    ],
    'stack' => ['nextdotjs', 'typescript', 'storybook', 'hubspot', 'salesforce', 'posthog', 'mixpanel', 'algolia', 'anthropic', 'langgraph', 'pgvector', 'githubactions'],
    'fixed' => ['Your product’s own telemetry', 'CRM and billing', 'Identity provider and SCIM directory', 'The documentation platform', 'The security-questionnaire answer bank'],
    'first' => 'A positioning and evidence audit across the site, the docs and the security questionnaire, then the one surface costing the most deals.',
    'ai' => [
        'agent' => 'Documentation and questionnaire assistant',
        'ground' => 'Your published docs, the changelog and the approved questionnaire answer bank, scoped to one tenant at a time.',
        'log' => [
            ['11:05:18', 'intake',    'question · “do you support SAML with our IdP, and SCIM?”'],
            ['11:05:18', 'ground',    'docs v4.2 · changelog · questionnaire answer bank'],
            ['11:05:19', 'answer',    'yes · SCIM 2.0 · cites two documentation sections'],
            ['11:05:19', 'guardrail', 'tenant scope enforced · no other customer’s data reachable'],
            ['11:05:20', 'log',       'unanswered follow-up → docs backlog · SCIM group sync'],
        ],
    ],
    'lens' => [
        'A champion, an economic buyer, security and procurement.',
        'Buyer evidence: an audit report, a DPA, an accessibility report.',
        'The site, the docs, a trial, and a security questionnaire.',
        'Tenant isolation, and GDPR the moment you have EU customers.',
        'Pipeline created, win rate, and security-review cycle time.',
    ],
    'teams' => ['Marketing and demand generation', 'Product', 'Sales engineering', 'Security and compliance'],
],

'hospitality' => [
    'n' => '05', 'slug' => 'hospitality', 'name' => 'Hospitality', 'short' => 'Hospitality',
    'kicker' => 'Direct is a product, not a discount', 'icon' => 'pin',
        'line' => 'A physical brand sold through channels that charge for the demand.',
    'led' => ['product-experience', 'marketing-technology'],
    'pressure' => 'Much of the demand arrives through channels that charge for it, and the brand is experienced in a physical place that a website has to describe accurately. Rates move daily, inventory is perishable, and a review written the morning after outranks the campaign. Guest data sits in a property system that was never designed to be a marketing platform.',
    'different' => [
        ['The brand is a building', 'Wayfinding, signage, uniform, print and the arrival sequence are brand surfaces with lead times measured in months. Digital work has to match what a guest will actually walk into.'],
        ['Direct competes on experience, not price', 'Parity agreements limit the discount. What is left is speed, clarity and a booking flow that knows the property, which makes direct booking a product problem rather than a pricing one.'],
        ['The systems are fixed points', 'A property management system, a central reservation system and a channel manager are givens. Good work integrates with them instead of proposing to replace them.'],
    ],
    'work' => [
        ['brand-design', 'brand-architecture', 'Architecture across a group, its properties and its restaurants, including how a property run by an operator still carries the brand.'],
        ['campaign-content', null, 'Seasonal and market-level campaigns from one system, with production that shows the actual property rather than a stock library.'],
        ['product-experience', null, 'Search, rate, room and checkout as one product, from the first search to the day after checkout, including the pages a guest uses while on the property.'],
        ['technology-intelligence', 'integration-support', 'The integration layer: property management, central reservations, channel manager and payments joined so the site can tell the truth about availability.'],
        ['ai-design', null, 'A concierge assistant grounded in the property’s own policies, inventory and rates, which hands off to a person the moment it cannot answer.'],
        ['marketing-technology', null, 'One guest profile assembled from booking, stay and service data, with lifecycle programmes for the stay and for the return.'],
    ],
    'rules' => [
        ['PCI DSS v4.0.1', 'Card details are captured at booking and often again at the property. Tokenisation and a hosted page keep that in one place.'],
        ['DPDP Act, 2023 · GDPR where guests from the EU are in scope', 'Guest data crosses borders with the guest. Purpose limits and retention have to be set per system, including the property management system.'],
        ['Form C reporting for foreign national arrivals', 'Indian hotels report foreign guests to the Bureau of Immigration, which shapes what the check-in flow has to capture and store.'],
        ['FSSAI licensing and display · food and beverage', 'Licence display, menu information and allergen detail carry into the digital surfaces as well as the printed ones.'],
        ['Rights of Persons with Disabilities Act, 2016 · WCAG 2.2 AA', 'The Act covers the building, the guidelines cover the booking. A guest needs both to work on the same day.'],
    ],
    'badges' => ['pci-dss', 'dpdp', 'wcag22', 'iso27001'],
    'measures' => [
        ['Direct share of room nights, and cost per direct booking', 'Set against the commission the same booking would have cost through a channel. That comparison is the business case.'],
        ['Booking funnel completion by device and market', 'Read separately, because a phone booking in one market behaves nothing like a desktop booking in another.'],
        ['Repeat guest share and review score', 'Both lag by a season, so they are read as a trend against a baseline taken before the work starts.'],
    ],
    'stack' => ['nextdotjs', 'contentful', 'salesforce', 'zoho', 'stripe', 'razorpay', 'twilio', 'whatsapp', 'snowflake', 'googleanalytics', 'intercom', 'openai'],
    'fixed' => ['Property management system', 'Central reservation system and booking engine', 'Channel manager and rate parity feeds', 'Revenue management system', 'Point of sale in food and beverage'],
    'first' => 'A direct-booking teardown across search, rate and checkout with the property integrations mapped, then one funnel fix shipped and measured.',
    'ai' => [
        'agent' => 'Property concierge assistant',
        'ground' => 'Live availability from the property management system, the rate rules and the published property policy.',
        'log' => [
            ['21:30:07', 'intake',  'request · “a crib and a late checkout on the 14th?”'],
            ['21:30:07', 'ground',  'PMS availability · rate rules · property policy v3'],
            ['21:30:08', 'policy',  'no rate quoted outside the booking engine'],
            ['21:30:08', 'answer',  'crib available · late checkout to 14:00, chargeable'],
            ['21:30:09', 'handoff', 'request outside policy → front office, with the context attached'],
        ],
    ],
    'lens' => [
        'A guest choosing in ten minutes, usually on a phone.',
        'The payment standard at booking, and what the building must meet.',
        'Search, the booking flow, the arrival, the room, the return.',
        'Guest data lives in the PMS. Purpose and retention set per system.',
        'Direct share of room nights against the commission avoided.',
    ],
    'teams' => ['Commercial and revenue', 'Marketing and brand', 'Operations', 'Guest technology'],
],

'telecom-and-media' => [
    'n' => '06', 'slug' => 'telecom-and-media', 'name' => 'Telecom and media', 'short' => 'Telecom',
    'kicker' => 'Scale, consent and rights', 'icon' => 'network',
        'line' => 'Flat growth, registered messaging, classified content, and enormous peaks.',
    'led' => ['technology-intelligence', 'ai-design'],
    'pressure' => 'Subscriber growth has flattened, so the value now sits in churn, cost to serve and what a subscriber actually watches. Commercial messaging runs through a registered template regime. Content carries classification and accessibility duties. And the peaks, a launch or a live event, are an order of magnitude above a normal night.',
    'different' => [
        ['Every message is pre-registered', 'Sender headers and content templates are registered on a distributed ledger platform before a single message goes out. A campaign idea that needs new copy needs a new template first, and that changes the calendar.'],
        ['Content carries a classification', 'Curated online content and television programming carry age classification, grievance redressal and accessibility duties. Captioning and audio description are production requirements, not post-launch additions.'],
        ['The peak is the design case', 'A launch night or a live event decides the architecture. Normal traffic is the easy part, and designing for it is how launches fall over.'],
    ],
    'work' => [
        ['brand-design', 'brand-architecture', 'Architecture across an operator brand, its plans and its content properties, so a sub-brand can launch without a new identity every time.'],
        ['campaign-content', null, 'Campaigns built template-first, so registered messaging and creative arrive together instead of a week apart.'],
        ['product-experience', null, 'Self-serve in the app: recharge, plan change, fault reporting and billing disputes designed to finish without a phone call.'],
        ['technology-intelligence', 'ai-infrastructure-cloud', 'The platform under the peak: event streaming, autoscaling, caching, and a load-tested path for launch night with a rehearsed rollback.'],
        ['ai-design', null, 'Churn and next-best-action models that propose, with a person deciding anything that changes a customer’s price, and every proposal logged with its inputs.'],
        ['marketing-technology', null, 'Consent and preference as one system across registered templates, app notifications and email, with suppression honoured in all three.'],
    ],
    'rules' => [
        ['TRAI Telecom Commercial Communications Customer Preference Regulations, 2018', 'Headers and content templates registered before use, with subscriber preferences enforced at the operator.'],
        ['Telecommunications Act, 2023', 'The current statutory frame for licensing and for unsolicited commercial communication.'],
        ['IT Rules, 2021 · Digital Media Ethics Code', 'Curated online content: age classification, a three-tier grievance mechanism, published redressal timelines and a named officer.'],
        ['Cable Television Networks Rules · advertising code', 'Broadcast advertising content and duration limits, which decide what a campaign can even book.'],
        ['Accessibility standards for television programming', 'Captioning and audio description obligations that have to be planned into production budgets.'],
        ['DPDP Act, 2023 · CERT-In Directions, 2022', 'Subscriber data under purpose limits, with reportable incidents in six hours and logs retained 180 days in India.'],
    ],
    'badges' => ['dpdp', 'cert-in', 'wcag22', 'iso27001', 'iso22301'],
    'measures' => [
        ['Churn by cohort and by reason', 'Reason coded from service data rather than guessed, so a retention programme can be aimed at something specific.'],
        ['Self-serve containment', 'The share of intents completed in the app with no call and no chat, with every failure feeding the roadmap.'],
        ['Template and delivery health', 'Registered-template rejection rate and delivery rate per operator. A campaign that cannot be delivered has no funnel at all.'],
    ],
    'stack' => ['apachekafka', 'clickhouse', 'snowflake', 'kubernetes', 'googlecloud', 'amazonwebservices', 'twilio', 'whatsapp', 'grafana', 'opentelemetry', 'k6', 'anthropic'],
    'fixed' => ['Business and operations support systems', 'Charging and billing', 'The commercial messaging ledger platform', 'Content delivery network and packager', 'Set-top and app clients'],
    'first' => 'A messaging and consent audit across registered templates and app notifications, then the self-serve journey that generates the most calls.',
    'ai' => [
        'agent' => 'Retention proposal agent',
        'ground' => 'Service and usage history, the approved offer catalogue, and the registered template library.',
        'log' => [
            ['02:15:33', 'intake',   'churn signal · cohort · 18-month postpaid · score 0.72'],
            ['02:15:33', 'policy',   'no price change without a human · registered template required'],
            ['02:15:34', 'propose',  'retention offer B · template TMPL-2291, registered'],
            ['02:15:34', 'hold',     'awaiting approval · queue · retention desk'],
            ['09:04:10', 'approved', 'reviewer recorded · offer and inputs stored'],
        ],
    ],
    'lens' => [
        'A subscriber deciding monthly, with a regulator watching.',
        'The messaging regulations, and the code for curated content.',
        'The app, the retailer, the call centre, the screen.',
        'Subscriber data under purpose limits, incidents in six hours.',
        'Churn by cohort, and self-serve containment.',
    ],
    'teams' => ['Consumer marketing', 'Digital and self-care', 'Network and IT', 'Content and programming'],
],

],

/* ------------------------------------------------------------------------ *
 *  The five questions we answer before any work starts
 * ------------------------------------------------------------------------ */
'lens' => [
    ['Who decides, and how long do they take?', 'Decision length sets the content, the measurement window and the sales motion.'],
    ['Which rules bind the words and the data?', 'Named per category and per market. Where a rule does not apply, we say so rather than adding a badge.'],
    ['Where is the experience actually had?', 'A shelf, a branch, a lobby, an app, someone else’s answer engine. Each has an owner and a lead time.'],
    ['What data may we use, and for what purpose?', 'Consent, purpose, residency and retention decide the architecture before personalisation is designed.'],
    ['What counts as a win, and who signs it off?', 'One primary measure, a baseline taken before the work, and a named owner on your side.'],
],

/* ------------------------------------------------------------------------ *
 *  What carries between categories, and what never does
 * ------------------------------------------------------------------------ */
'transfer' => [
    'carries' => [
        ['Design systems and tokens', 'The mechanics of a system are category-independent. What changes is the content model and which states are mandatory.'],
        ['Consent and preference architecture', 'One consent record, purposes, withdrawal, suppression. The purposes differ by category; the plumbing does not.'],
        ['Content operations and review workflow', 'Versioning, a reviewer of record, an audit trail. A medical reviewer and a compliance officer need the same machinery.'],
        ['Evaluation harnesses for AI features', 'A fixed set of real questions, a scored answer, a release gate. The questions are yours; the harness is ours.'],
        ['Performance and accessibility budgets', 'Core Web Vitals and WCAG 2.2 AA enforced in the pipeline. The same gate in every category.'],
        ['Measurement discipline', 'A baseline before the work, one primary measure, a named owner. It is the cheapest thing on this list and the most often skipped.'],
    ],
    'never' => [
        ['Which claims you may make', 'A permitted claim in one category is an offence in another. Claim language is rebuilt per category and per market, every time.'],
        ['Who approves, and when', 'Medical, legal and regulatory review, a compliance sign-off or a procurement panel each change the calendar, not just the checklist.'],
        ['What a good number looks like', 'A conversion rate, a churn figure or a review score only means something against that category’s own baseline.'],
        ['Where the decision is made', 'A shelf, a credit committee, a lobby, a security questionnaire. Copying a journey across categories is how good work fails quietly.'],
        ['The systems you must integrate with', 'A property management system, a core banking stack or a marketplace feed is a fixed point, and it decides the architecture.'],
        ['What “fast” means', 'A sale-day peak, a market open and a launch night are three different engineering problems with three different budgets.'],
    ],
],

/* ------------------------------------------------------------------------ *
 *  The instruments, once, with what each changes in the work.
 *  'binds' is the condition, not a category list: several of these follow the
 *  activity rather than the sector. 'in' names where it is most central.
 * ------------------------------------------------------------------------ */
'rules' => [
    ['dpdp', 'DPDP Act, 2023', 'India · Digital Personal Data Protection Act',
     'Personal data processed in India, and data processed outside India in connection with offering goods or services to people in India.',
     'A consent notice per purpose, purpose limitation, a retention schedule, and erasure the product can actually perform. Children under eighteen need verifiable parental consent, and tracking or targeted advertising aimed at them is out. There is no separate sensitive-data class, so the notice and the purpose carry the weight that special-category rules carry elsewhere. The Act is in force with obligations phasing in, so we build to it now rather than at the last date.',
     ['consumer-health', 'financial-services', 'retail-and-commerce', 'b2b-technology', 'hospitality', 'telecom-and-media']],

    ['gdpr', 'GDPR', 'EU and EEA · Regulation (EU) 2016/679',
     'Offering goods or services to people in the EU, or monitoring their behaviour. It follows the audience, not the address of the company.',
     'A lawful basis per purpose, a data processing agreement with every processor, a transfer mechanism, and subject-access and erasure requests the product can service inside the deadline.',
     ['b2b-technology', 'hospitality']],

    ['pci-dss', 'PCI DSS v4.0.1', 'Payment Card Industry Security Standards Council',
     'Anywhere card data is stored, processed or transmitted. It follows the activity, not the sector.',
     'We design the scope down before we design the screen: a hosted payment page and network tokens, so card numbers never reach your systems. Whatever is left in scope is documented so an assessor can follow it without a workshop.',
     ['financial-services', 'retail-and-commerce', 'hospitality']],

    [null, 'RBI directions for regulated entities', 'India · Reserve Bank of India',
     'Banks, non-banking financial companies, payment operators and the service providers they use.',
     'Payment system data stored only in India. A key fact statement before disbursal in digital lending. Named accountability, a right to audit and a documented exit in the outsourcing contract. These decide hosting region and delivery governance before the first sprint.',
     ['financial-services']],

    ['cert-in', 'CERT-In Directions, 2022', 'India · Indian Computer Emergency Response Team',
     'Service providers, intermediaries, data centres and body corporates operating in India.',
     'Reportable incidents notified within six hours, logs retained for 180 days inside India, and clocks synchronised to a national time source so those logs can be read together.',
     ['financial-services', 'telecom-and-media', 'retail-and-commerce']],

    [null, 'Advertising and claims regimes', 'India · sector regulators and the CCPA',
     'Any claim made to a consumer. Which instrument applies depends entirely on what you sell.',
     'Health and food claims run through the Drugs and Magic Remedies Act, the Drugs and Cosmetics Act and the FSSAI claims regulations. Financial communications run through the SEBI advertisement code or the IRDAI regulations. Everything consumer-facing also sits under the CCPA guidelines on misleading advertisements and on dark patterns, and under the ASCI code. The practical effect is the same: the claim is fixed before the layout.',
     ['consumer-health', 'financial-services', 'retail-and-commerce', 'telecom-and-media']],

    [null, 'TRAI commercial communication regulations', 'India · Telecom Regulatory Authority of India',
     'Commercial messaging to Indian subscribers. It binds the sender, so a retailer and a bank are as caught by it as an operator.',
     'Sender headers and content templates registered before use, subscriber preference enforced at the operator, and creative planned template-first. A late copy change becomes a registration cycle, so the campaign calendar has to account for it.',
     ['telecom-and-media', 'retail-and-commerce', 'financial-services']],

    [null, 'IT Rules, 2021 · Digital Media Ethics Code', 'India · Ministry of Electronics and Information Technology',
     'Publishers of news and current affairs, publishers of curated online content, and significant social media intermediaries.',
     'Age classification on curated content, a three-tier grievance mechanism with published timelines, and a named grievance officer. It shapes the product, not only the policy page: classification and complaint handling are features.',
     ['telecom-and-media']],

    ['hipaa', 'HIPAA Security Rule', 'United States · 45 CFR Part 164',
     'Only where electronic protected health information about US patients is created, received, maintained or transmitted by a covered entity or its business associate.',
     'A business associate agreement, de-identification before any model call, access logging, and encryption in transit and at rest. An Indian consumer health brand with no US patient data is out of scope, and we leave the badge off rather than borrow the credibility.',
     ['consumer-health']],

    ['eu-ai-act', 'EU AI Act', 'EU · Regulation (EU) 2024/1689',
     'AI systems placed on the EU market, or whose output is used in the EU. Duties differ for a provider and for a deployer.',
     'Classify the system before building it, then meet what the class requires: transparency duties for limited-risk uses, and a full management system, logging and human oversight for high-risk ones. Creditworthiness assessment is listed as high-risk, which matters directly to lenders.',
     ['b2b-technology', 'financial-services']],

    ['owasp-llm', 'OWASP Top 10 for LLM Applications', 'OWASP Foundation',
     'Any feature that puts a language model in front of your data or your customers.',
     'Prompt injection is treated as the default threat, not an edge case: tool allow-lists, output filtering, no privileged action without a human step, and adversarial cases carried in the eval set so a regression is caught before release.',
     ['consumer-health', 'financial-services', 'retail-and-commerce', 'b2b-technology', 'hospitality', 'telecom-and-media']],

    ['wcag22', 'WCAG 2.2 AA', 'W3C · Web Content Accessibility Guidelines',
     'Every public surface we build, and a procurement requirement in enterprise and public-sector deals.',
     'Contrast, focus order, target size and keyboard paths checked in the pipeline rather than at the end, with an accessibility conformance report produced where procurement asks for one.',
     ['consumer-health', 'financial-services', 'retail-and-commerce', 'b2b-technology', 'hospitality', 'telecom-and-media']],

    ['cwv', 'Core Web Vitals', 'Field thresholds, measured at the 75th percentile',
     'Any page that has to be found and used on a phone.',
     'Budgets set at largest contentful paint within 2.5 s, interaction to next paint within 200 ms and cumulative layout shift under 0.1, enforced in the pipeline so a regression fails a build instead of a quarter.',
     ['consumer-health', 'retail-and-commerce', 'hospitality', 'telecom-and-media']],
],

/* ------------------------------------------------------------------------ *
 *  Adjacent categories. Taken from the industries sections of the two
 *  finished discipline hubs so this page does not contradict them.
 * ------------------------------------------------------------------------ */
'adjacent' => [
    ['Manufacturing and industrial', 'Long portfolios, distributor networks and control systems that cannot stop for an upgrade.', 'technology-intelligence'],
    ['Energy and utilities', 'Transition claims that need evidence, and regulated customer communication.', 'brand-design'],
    ['Education', 'Children’s data, accessibility, and results-day peaks.', 'technology-intelligence'],
    ['Public sector and institutions', 'Residency, accessibility and audit trails as the baseline rather than extras.', 'technology-intelligence'],
    ['Logistics', 'Every shipment is an event, and every event has to reach the right system.', 'technology-intelligence'],
],

/* ------------------------------------------------------------------------ *
 *  How a category engagement starts.
 *  PLACEHOLDER: every duration here is typical, not promised — confirm before launch.
 * ------------------------------------------------------------------------ */
'start' => [
    ['Category audit', '2 to 3 weeks', 'What is true now: the instruments that bind you, the surfaces that exist, the numbers as they actually stand, and the ten things costing the most.',
     ['A written audit with evidence', 'A ranked backlog with effort and impact', 'A baseline pack for every measure we propose']],
    ['One journey, shipped', '6 to 10 weeks', 'A single journey rebuilt end to end and measured against that baseline: onboarding, a product page, a booking flow, one self-serve intent.',
     ['The journey live in production', 'The measurement wired in before launch', 'A handover your team can run without us']],
    ['The system, a quarter at a time', 'Ongoing', 'The design system, the data and consent layer, the content operation and the AI guardrails, run as one programme with your team inside it.',
     ['A roadmap reviewed every quarter', 'Your repositories, your cloud, your IP', 'A monthly report against the agreed measures']],
],

/* ------------------------------------------------------------------------ *
 *  FAQ
 * ------------------------------------------------------------------------ */
'faq' => [
    ['Our category is regulated. Can you work inside our review process?',
     'Yes, and we would rather build the review in than work around it. Versioned copy, a reviewer of record, an audit trail per claim, and a release that cannot ship without the sign-off. Your reviewers keep their authority. They stop being a queue at the end of the process.'],
    ['You do not name clients. How do we judge your category experience?',
     'Ask us category questions. What a key fact statement has to carry, which thirteen practices the dark-pattern guidelines name, what a rejected message template does to a launch date. The answers tell you more than a logo wall would, and they are checkable.'],
    ['Who owns compliance, you or us?',
     'You do. Compliance is a decision your accountable person makes. We are accountable for building what that decision requires, for telling you early when a design will not survive it, and for handing over evidence you can show a supervisor or an auditor.'],
    ['Does AI change what is possible in a regulated category?',
     'It changes the cost of doing the safe thing. An assistant grounded in approved language can answer a thousand questions without inventing a claim. What it cannot do is decide. Anything that changes a price, a record, or a clinical or credit outcome keeps a human approval step and an audit log.'],
    ['We operate in more than one of these categories.',
     'Then the shared machinery is the saving: one design system, one consent architecture, one content operation, one eval harness. The claims, the approvals and the measures stay separate per category, because they have to.'],
    ['What if our category is not on the list?',
     'The method does not change. We run the five questions, write down what we find, and tell you honestly whether this is a category we can be useful in. Several adjacent categories are covered in depth on the discipline pages.'],
],

];
