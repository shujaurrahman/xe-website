<?php
/**
 * Campaign & Content Design: the eight capabilities, in depth.
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
 *   img                             card photo ['src','w','h','alt','pos'] (assets/imgs/campaign/shared/, credits in CREDITS.md there)
 *   stack                           technology slugs from data/tech-stack.php, most relevant first (render with xt_stack)
 *   standards                       badge keys from xt_standards() (render with xt_badge)
 *
 * Truthfulness: platforms named are ones we work in, never partnerships. Standards are frameworks
 * the work is built to or aligned with; nothing here says Xterra Edze holds a certification. No
 * coverage, ranking or result is promised. Disclosure and advertising codes are described, not claimed.
 *
 * Voice: calm, precise, confident. Short active sentences. No exclamation marks.
 */

return [

    'content-marketing' => [
        'n'          => '01',
        'slug'       => 'content-marketing',
        'name'       => 'Content Marketing',
        'short'      => 'Content',
        'kicker'     => 'Published for a reason',
        'title'      => '<span class="g">Anyone can fill a calendar.</span> Few earn the next click.',
        'lead'       => 'Content Marketing builds the system behind the calendar: demand and question research, a topic architecture, briefs your experts can answer in an hour, and production that ships on schedule. It is measured on qualified demand and search visibility, not on how much was published.',
        'meta'       => ['8–12 weeks to a running system', 'Editorial · SEO · distribution', 'Measured to pipeline'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical set-up', 'Scope', 'Standard'],
        'cta'        => 'Start a content brief',
        'icon'       => 'doc',
        'offer_title'=> '<span class="g">Six moving parts,</span> one editorial engine',
        'offer_lead' => 'Research, planning, production, distribution and measurement run as one loop, so every piece has a job and somewhere to land.',
        'offer' => [                    // [title, description, tag, icon — see xt_icons()]
            ['Demand & question research', 'Search demand, sales objections and support tickets read together, so the plan answers questions customers actually ask.', 'Search · sales · support', 'search'],
            ['Topic architecture',         'Pillars, clusters and internal links mapped before anything is written, so pages support each other instead of competing.', 'Pillars · clusters', 'stack'],
            ['Editorial calendar & briefs','A quarterly calendar with a brief per piece: the question, the angle, the evidence, the expert and the measure.', 'Quarterly · briefed', 'calendar'],
            ['Production with your experts','Interview-led writing, design and editing, so subject expertise reaches the page without costing your specialists a week.', 'Expert-led', 'users'],
            ['Distribution & repurposing', 'Every piece is planned with its distribution: newsletter, social cut-downs, sales enablement and paid budget behind the best of it.', 'One piece, many formats', 'sync'],
            ['Measurement & content ops',  'Performance by topic and by stage, a quarterly refresh cycle, and a governance model your team can run without us.', 'Refresh cycle · governance', 'chart'],
        ],
        'process' => [
            'title' => '<span class="g">Twelve weeks</span> to an engine that runs without us',
            'lead'  => 'The first cluster ships while the system is still being built, so the plan is corrected by performance rather than by debate.',
            'steps' => [
                ['Research',  'Wk 01–03', 'Search demand, customer questions, sales and support themes, competitor coverage, and an inventory of what you already have with its performance.', ['Demand map', 'Content inventory', 'Opportunity list']],
                ['Architect', 'Wk 03–05', 'Pillars, clusters, internal linking and the editorial standard agreed. Briefs written for the first cluster.', ['Topic architecture', 'Editorial standards', 'Brief templates']],
                ['Produce',   'Wk 05–11', 'Interview-led writing, design, review and publication. AI assists research, variants and metadata; a named editor approves everything before it ships.', ['Published cluster', 'Asset library', 'Distribution plan']],
                ['Operate',   'Wk 11–12', 'Handover of the calendar, briefs and dashboard, with a refresh cycle and a quarterly planning rhythm your team owns.', ['Reporting dashboard', 'Refresh backlog', 'Operating rhythm']],
            ],
        ],
        'deliver' => [
            ['Content strategy & topic architecture',    'Deck · board'],
            ['Editorial calendar & brief templates',     'Sheet · Notion'],
            ['Published articles, guides & landing pages','CMS pages'],
            ['Editorial standards & style guide',        'Document'],
            ['Distribution & repurposing plan',          'Sheet'],
            ['Content performance dashboard',            'Dashboard'],
            ['Quarterly refresh backlog',                'Sheet'],
        ],
        'outcomes' => [
            ['Fewer pieces, more weight',   'A smaller number of pages, built as clusters, that rank, earn citations and answer the questions that come before a purchase.'],
            ['Expertise on the page',       'Interview-led production turns what your specialists know into published work, without asking them to write it.'],
            ['A calendar your team can run','Briefs, standards and a dashboard handed over, so publishing continues at the same standard after the engagement.'],
        ],
        'faq' => [
            ['How much content do we need?', 'Fewer pieces than most calendars assume. We start with one cluster that covers a buying decision end to end, measure it, then repeat. Volume follows evidence.'],
            ['Do you write with AI?', 'AI helps with research, outlines, variants, metadata and translation drafts. A person writes or rewrites the substance, a named editor approves every piece, and we disclose AI assistance where a platform or your own policy requires it. Nothing is published unreviewed.'],
            ['Who owns the content?', 'You do. Copy, design files, photography and licences transfer to you on delivery, with usage rights recorded per asset.'],
            ['How long before content performs?', 'Internal linking and technical fixes can show within weeks of being recrawled. New clusters typically take three to six months to compound, depending on competition and publishing pace.'],   // PLACEHOLDER: confirm typical timeframe
            ['How does this connect to SEO and AI answers?', 'The same architecture serves both. Clear entities, answer-first structure and cited sources are what ranking systems and answer engines both reward, so rankings and AI-answer citations are tracked against one baseline.'],
        ],
        'pairs'     => ['omnichannel-marketing-strategy', 'global-content-production'],
        'img'       => ['src' => 'assets/imgs/campaign/shared/content-marketing.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A writer works through an outline on a laptop beside a notebook of handwritten notes', 'pos' => '50% 50%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['wordpress', 'contentful', 'sanity', 'webflow', 'semrush', 'ahrefs', 'googlesearchconsole', 'googleanalytics', 'hubspot', 'notion', 'figma', 'schemaorg', 'openai', 'anthropic'],
        'standards' => ['wcag22', 'cwv', 'gdpr', 'dpdp'],
    ],

    'social-media-marketing' => [
        'n'          => '02',
        'slug'       => 'social-media-marketing',
        'name'       => 'Social Media Marketing',
        'short'      => 'Social',
        'kicker'     => 'Native to the platform',
        'title'      => '<span class="g">Posting is not a presence.</span> Build one people come back to.',
        'lead'       => 'Social Media Marketing runs your always-on presence: a platform strategy that respects how each feed actually works, content pillars in native formats, community management with agreed response times, and reporting that connects social to search, site and sales.',
        'meta'       => ['4–6 weeks to launch, then monthly', 'Strategy · content · community', 'Response times agreed'],   // PLACEHOLDER: confirm timeframe and response targets
        'meta_k'     => ['Typical start', 'Scope', 'Standard'],
        'cta'        => 'Start a social brief',
        'icon'       => 'chat',
        'offer_title'=> '<span class="g">Six habits</span> that make a feed worth following',
        'offer_lead' => 'Each platform gets its own format, cadence and measure. Nothing is cross-posted without being rebuilt for where it lands.',
        'offer' => [
            ['Platform & channel strategy',  'Which platforms earn your time, what each one is for, and the cadence and format mix that fits how its audience behaves.', 'Per platform', 'compass'],
            ['Content pillars & native formats','Three to five pillars produced as short video, carousels, stills and text written for each feed, rather than one asset resized six ways.', 'Pillars · native formats', 'layers'],
            ['Always-on calendar & publishing','A monthly calendar, approvals in one place, scheduled publishing, and a reactive slot kept free for what actually happens this week.', 'Monthly · reactive slot', 'calendar'],
            ['Community management',         'Moderation, replies and escalation against agreed response times, with a tone guide and a route for anything that needs legal or support.', 'Reply · escalate', 'users'],   // PLACEHOLDER: confirm response-time targets
            ['Employee & founder presence',  'Ghostwriting and coaching for the leaders and specialists whose own accounts reach further than the brand page.', 'Founder-led', 'handshake'],
            ['Listening & reporting',        'Share of voice, sentiment, saves and shares tracked next to branded search, site and pipeline data, reviewed every month.', 'Listening · monthly report', 'radar'],
        ],
        'process' => [
            'title' => '<span class="g">Six weeks to launch,</span> then a monthly rhythm',
            'lead'  => 'The first month is deliberately small: enough posts to learn what the audience returns for, before the calendar is set.',
            'steps' => [
                ['Audit',  'Wk 01–02', 'Current accounts, audience, competitors and benchmarks. What worked, what was noise, and where the audience actually spends attention.', ['Channel audit', 'Benchmark read', 'Audience map']],
                ['Design', 'Wk 02–04', 'Pillars, formats, cadence, tone guide, moderation rules and escalation paths agreed with your legal and support teams.', ['Content pillars', 'Tone & moderation guide', 'Escalation matrix']],
                ['Launch', 'Wk 04–06', 'The first batch produced, scheduled and published. Community management starts against agreed response targets.', ['Launch batch', 'Publishing calendar', 'Response targets']],
                ['Run',    'Monthly',  'Production, publishing, community management, and a monthly review that moves effort to the formats holding attention.', ['Monthly content', 'Community report', 'Performance review']],
            ],
        ],
        'deliver' => [
            ['Channel strategy & content pillars', 'Deck'],
            ['Monthly content calendar',           'Sheet · scheduler'],
            ['Produced social assets',             'Video · stills · copy'],
            ['Tone, moderation & escalation guide','Document'],
            ['Community management log',           'Dashboard'],
            ['Monthly performance report',         'Dashboard · PDF'],
        ],
        'outcomes' => [
            ['A feed with a reason to follow','Pillars people recognise, in the formats each platform rewards, instead of announcements nobody asked for.'],
            ['Replies that do not go cold',   'Agreed response times, a tone guide and a clear escalation route make community management a service rather than a scramble.'],
            ['Social tied to the business',   'Saves, shares and sentiment reported alongside branded search, site visits and pipeline, not in isolation.'],
        ],
        'faq' => [
            ['Which platforms should we be on?', 'The ones where your buyers already spend attention and where you can sustain the format. Two platforms run well beat six run badly, and the audit says which two.'],
            ['How fast do you reply to comments?', 'Response targets are set per channel and severity in the community plan, with an escalation path for complaints, safety issues and anything legal or medical.'],   // PLACEHOLDER: confirm response-time targets before launch
            ['Do you use AI for social content?', 'For research, variants, captions, alt text, subtitles and first-pass moderation triage. A person edits and approves everything before it publishes, and voice is checked against the tone guide.'],
            ['Can you work with our in-house team?', 'Yes. We often run strategy, production standards and reporting while your team publishes and replies, or take community management while they keep the creative.'],
            ['What about paid social?', 'Organic and paid are planned together but bought separately. Boosting, audiences and creative testing sit in Performance Marketing, so spend is measured against outcomes rather than engagement.'],
        ],
        'pairs'     => ['social-influencer-activation', 'content-marketing'],
        'img'       => ['src' => 'assets/imgs/campaign/shared/social-media-marketing.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A phone held in one hand shows a social feed while a laptop sits open behind it', 'pos' => '50% 50%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['figma', 'notion', 'hubspot', 'slack', 'whatsapp', 'googleanalytics', 'googletagmanager', 'semrush', 'posthog', 'openai', 'anthropic', 'zapier', 'make'],
        'standards' => ['wcag22', 'gdpr', 'dpdp'],
    ],

    'public-relations' => [
        'n'          => '03',
        'slug'       => 'public-relations',
        'name'       => 'Public Relations',
        'short'      => 'PR',
        'kicker'     => 'Credibility you cannot buy',
        'title'      => '<span class="g">Advertising is what you say.</span> Coverage is what others repeat.',
        'lead'       => 'Public Relations earns the attention you do not pay for: media and analyst relations, executive visibility, a newsroom worth quoting, and the preparation that makes a bad week survivable. Measured on share of voice, message pull-through and who cites you, answer engines included.',
        'meta'       => ['3-month programmes · ongoing', 'Media · analyst · executive · crisis', 'Reported monthly'],   // PLACEHOLDER: confirm programme length
        'meta_k'     => ['Typical cycle', 'Scope', 'Reporting'],
        'cta'        => 'Start a PR brief',
        'icon'       => 'radar',
        'offer_title'=> '<span class="g">Six ways a story travels,</span> and the proof it landed',
        'offer_lead' => 'Coverage is planned like a campaign: a narrative with evidence, the journalists it genuinely serves, and a measure agreed before the first pitch.',
        'offer' => [
            ['Narrative & message house',  'The story the business can defend, with proof points, the claims legal will pass, and the questions that follow each one.', 'Narrative · proof', 'doc'],
            ['Media relations',            'Relationships with the reporters covering your category, briefings, exclusives and announcement plans run with embargo discipline.', 'Earned coverage', 'globe'],
            ['Analyst & industry relations','Briefings, questionnaire responses and evidence packs for the analysts, awards and industry bodies your buyers actually read.', 'Analysts · awards', 'clipboard-check'],
            ['Executive visibility',       'Bylines, keynotes, podcasts and commentary that build a named expert rather than an anonymous brand.', 'Bylines · speaking', 'users'],
            ['Newsroom built for citation','A newsroom, fact pages and data stories structured so journalists and answer engines can quote you accurately and attribute it to you.', 'Quotable · structured', 'link'],
            ['Crisis & issues readiness',  'Scenarios, holding statements, an escalation tree and a rehearsed first hour, prepared while everything is still calm.', 'Rehearsed', 'shield'],
        ],
        'process' => [
            'title' => '<span class="g">Prepare the story,</span> then earn the coverage',
            'lead'  => 'Nothing is pitched until the narrative, the evidence and the spokespeople are ready. Preparation is what turns interest into an article.',
            'steps' => [
                ['Position','Wk 01–03', 'Narrative, proof points and spokespeople agreed, with a baseline of coverage, share of voice and how often answer engines name you.', ['Message house', 'Spokesperson brief', 'Coverage baseline']],
                ['Prepare', 'Wk 03–05', 'Media list, story angles, data assets, press kit and media training. Crisis scenarios and holding statements drafted in parallel.', ['Media list', 'Story angles', 'Press kit & training']],
                ['Pitch',   'Wk 05–12', 'Announcements, exclusives, bylines and commentary placed, with reactive comment ready for the moments your category is already discussing.', ['Placed coverage', 'Bylines', 'Reactive comment']],
                ['Report',  'Monthly',  'Coverage, share of voice, message pull-through and citations in AI answers reviewed against the baseline, with the next quarter planned.', ['Monthly report', 'Share-of-voice tracking', 'Next-quarter plan']],
            ],
        ],
        'deliver' => [
            ['Narrative & message house',                  'Document'],
            ['Media & analyst target list',                'Sheet'],
            ['Press kit & newsroom pages',                 'CMS · assets'],
            ['Placed coverage & bylines',                  'Links · PDF'],
            ['Media training & spokesperson briefs',       'Session · document'],
            ['Crisis playbook & holding statements',       'Playbook'],
            ['Monthly coverage & share-of-voice report',   'Dashboard · PDF'],
        ],
        'outcomes' => [
            ['A story that survives the next question','Claims that hold up, evidence behind each one, and spokespeople prepared for the follow-up.'],
            ['Cited, not merely mentioned',            'Newsroom content structured so journalists quote it correctly and answer engines attribute it to you.'],
            ['A bad week with a plan',                 'Scenarios rehearsed, statements drafted and an escalation tree agreed before anything goes wrong.'],
        ],
        'faq' => [
            ['Can you guarantee coverage?', 'No. Editorial decisions belong to journalists and editors. We commit to the narrative, the evidence, the relationships and the measurement, and we report what landed and what did not.'],
            ['How is PR measured?', 'Against a baseline: volume and quality of coverage, share of voice in your category, whether your key messages survive into the article, referral traffic and branded search, and whether answer engines name you when asked about the category.'],
            ['Do you handle crisis communications?', 'We prepare for them: scenarios, holding statements, escalation trees and rehearsals. Live crisis support is agreed separately, with named contacts and response expectations written into the agreement.'],   // PLACEHOLDER: confirm crisis support terms before launch
            ['What if the issue is a breach or an outage?', 'Communications follow the incident, never the other way round. We work with your security and legal teams so statements match the timelines that apply, such as breach intimation under India’s DPDP Act and the CERT-In reporting directions.'],
            ['Do you pay for placements?', 'No. Paid partnerships, sponsored content and advertorials are bought and labelled as advertising. Earned coverage is earned, and the two are kept clearly separate.'],
        ],
        'pairs'     => ['content-marketing', 'social-influencer-activation'],
        'img'       => ['src' => 'assets/imgs/campaign/shared/public-relations.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A spokesperson answers questions in front of microphones at a press briefing', 'pos' => '50% 40%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['google', 'googlesearchconsole', 'semrush', 'ahrefs', 'wordpress', 'notion', 'slack', 'googleanalytics', 'schemaorg', 'perplexity', 'openai', 'googlegemini'],
        'standards' => ['gdpr', 'dpdp', 'wcag22'],
    ],

    'social-influencer-activation' => [
        'n'          => '04',
        'slug'       => 'social-influencer-activation',
        'name'       => 'Social & Influencer Activation',
        'short'      => 'Activation',
        'kicker'     => 'Borrowed trust, handled carefully',
        'title'      => '<span class="g">The brand is not the star.</span> The conversation is.',
        'lead'       => 'Social & Influencer Activation places brands inside conversations that already exist. Creators chosen on audience evidence rather than follower count, briefs that leave their voice intact, contracts and disclosure handled properly, and measurement that separates paid reach from real lift.',
        'meta'       => ['6–10 weeks per activation', 'Creators · communities · platforms', 'Disclosure by default'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Scope', 'Standard'],
        'cta'        => 'Start an activation brief',
        'icon'       => 'users',
        'offer_title'=> '<span class="g">Six steps from a list of names</span> to a measured activation',
        'offer_lead' => 'Selection, brief, contract, content, amplification and measurement. Skip one and an activation becomes a payment with no evidence attached.',
        'offer' => [
            ['Creator strategy & selection',  'Creators shortlisted on audience overlap, engagement quality, brand safety and past performance, with audience authenticity checked before anyone is contacted.', 'Audience-verified', 'search'],
            ['Briefing & creative direction', 'A brief that carries the message, the claims that may be made and the rules, while leaving the creator’s format and voice intact.', 'Message · claims · freedom', 'doc'],
            ['Contracts, rights & disclosure','Deliverables, usage rights, exclusivity, approvals and disclosure obligations written into the contract rather than assumed.', 'Rights · exclusivity', 'clipboard-check'],
            ['Community & platform activation','Activations inside the groups, communities and live formats where the audience already gathers, including WhatsApp, Discord and regional platforms.', 'Communities · live', 'network'],
            ['Whitelisting & paid amplification','The creator content that performs, run as paid media from the creator’s own handle, with usage rights already cleared for it.', 'Creator ads · cleared rights', 'trend-up'],
            ['Measurement & incrementality',  'Reach and engagement reported honestly, with holdout or matched-market tests to show what the activation actually added.', 'Holdout tested', 'eval'],
        ],
        'process' => [
            'title' => '<span class="g">Choose slowly,</span> then move fast',
            'lead'  => 'Most activations fail in selection and briefing. Both are done properly before a single creator is approached.',
            'steps' => [
                ['Define',            'Wk 01–02', 'Audience, message, claims, budget split and the measure of success. Brand-safety rules and no-go categories agreed with your legal team.', ['Activation brief', 'Claims & safety rules', 'Success measure']],
                ['Select',            'Wk 02–04', 'Shortlist built on audience overlap and engagement quality, audiences checked for authenticity, rates negotiated and contracts signed.', ['Creator shortlist', 'Audience checks', 'Signed contracts']],
                ['Produce',           'Wk 04–08', 'Briefing calls, drafts, one round of feedback against the brief, disclosure checked at publication, and scheduling around the campaign.', ['Creator content', 'Approval log', 'Publishing schedule']],
                ['Amplify & measure', 'Wk 08–10', 'The strongest assets whitelisted into paid, then a report covering reach, engagement, traffic, sales and an incrementality read.', ['Paid amplification', 'Performance report', 'Incrementality read']],
            ],
        ],
        'deliver' => [
            ['Creator strategy & vetted shortlist',          'Sheet · deck'],
            ['Creator briefs & claims guidance',             'Document'],
            ['Contracts & rights matrix',                    'Agreements · sheet'],
            ['Creator content & usage-rights record',        'Assets · sheet'],
            ['Disclosure compliance log',                    'Sheet'],
            ['Activation performance & incrementality report','Dashboard · PDF'],
        ],
        'outcomes' => [
            ['Creators chosen on evidence',    'Audience overlap, engagement quality and authenticity checks replace follower count as the reason to work with someone.'],
            ['Content you are allowed to reuse','Usage rights, exclusivity and approvals settled in the contract, so the strongest asset can run as paid media the same week.'],
            ['A number you can defend',        'Holdout or matched-market tests separate what the activation added from what would have happened anyway.'],
        ],
        'faq' => [
            ['Micro or macro creators?', 'It depends on the job. Macro creators buy reach and credibility in one move; micro and niche creators usually deliver better engagement, lower cost per action and more trust inside a specific community. Most activations use a mix, and your audience data decides the split.'],
            ['How do you check a creator is genuine?', 'Audience overlap with your customers, follower growth patterns, engagement and comment quality, past brand work and content history. Anything that looks bought is dropped before contact.'],
            ['Who owns the content the creator makes?', 'Whatever the contract says, which is why it is written carefully. Deliverables, usage duration, channels, paid amplification and exclusivity are agreed up front and recorded per asset.'],
            ['How do you handle disclosure rules?', 'Paid partnerships are labelled. Briefs and contracts carry the disclosure obligation, platform labels are used, and every post is checked at publication. In India that follows the ASCI influencer guidelines; in the United States the FTC endorsement guides; other markets are checked before launch.'],
            ['What if a creator becomes a problem?', 'Brand-safety criteria, conduct clauses and a takedown route are written into the contract, and the escalation path is agreed with your legal team before the activation starts.'],
        ],
        'pairs'     => ['social-media-marketing', 'performance-marketing'],
        'img'       => ['src' => 'assets/imgs/campaign/shared/social-influencer-activation.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A creator films a piece to camera on a tripod-mounted phone with a ring light', 'pos' => '50% 45%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['hubspot', 'notion', 'figma', 'googleanalytics', 'googletagmanager', 'shopify', 'whatsapp', 'slack', 'semrush', 'posthog', 'openai', 'zapier'],
        'standards' => ['gdpr', 'dpdp', 'wcag22'],
    ],

    'performance-marketing' => [
        'n'          => '05',
        'slug'       => 'performance-marketing',
        'name'       => 'Performance Marketing',
        'short'      => 'Performance',
        'kicker'     => 'Spend that reports back',
        'title'      => '<span class="g">Clicks are cheap.</span> Customers are the number.',
        'lead'       => 'Performance Marketing buys attention against outcomes you can verify. Paid search, paid social, retail media and programmatic run on a measurement layer you own, with consented tracking, incrementality testing, and creative produced at the volume today’s auctions demand.',
        'meta'       => ['4–6 weeks to a measured baseline', 'Search · social · retail · programmatic', 'Incrementality, not last click'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical start', 'Channels', 'Standard'],
        'cta'        => 'Start a performance brief',
        'icon'       => 'trend-up',
        'offer_title'=> '<span class="g">Measurement first,</span> then media',
        'offer_lead' => 'Nothing scales on numbers that cannot be trusted. The measurement layer is built and validated before budget moves.',
        'offer' => [
            ['Measurement & tracking foundation','Server-side tagging, conversion APIs, consent mode and offline conversion imports, so platforms optimise towards real outcomes instead of page views.', 'Server-side · consented', 'gauge'],
            ['Paid search & shopping',          'Search, shopping feeds and automated campaign types managed against margin and qualified pipeline, with query and placement hygiene done weekly.', 'Search · shopping feeds', 'search'],
            ['Paid social & video',             'Social and video campaigns built for each platform’s auction, with creative volume, audience structure and frequency planned together.', 'Social · video', 'chat'],
            ['Retail media & marketplaces',     'Sponsored placements on marketplaces and retailer networks, planned alongside listing quality and stock rather than in isolation.', 'Marketplaces · retailers', 'cube'],
            ['Creative testing at volume',      'A testing framework with a hypothesis per variant, enough versions to learn from, and AI-assisted variants reviewed by a person before they run.', 'Hypothesis per variant', 'eval'],
            ['Incrementality & budget allocation','Geo holdouts, matched-market tests and a media-mix read that show what spend adds, feeding a budget model rather than a last-click report.', 'Holdouts · mix model', 'chart'],
        ],
        'process' => [
            'title' => '<span class="g">Six weeks to a baseline,</span> then compounding',
            'lead'  => 'The first phase fixes measurement and creative supply. Scaling starts once the numbers hold up.',
            'steps' => [
                ['Audit',      'Wk 01–02', 'Accounts, tracking, consent, feeds, creative and history reviewed. Waste and blind spots listed with an estimate of what each one costs.', ['Account audit', 'Tracking gap list', 'Baseline report']],
                ['Instrument', 'Wk 02–04', 'Server-side tagging, conversion APIs, consent handling and offline conversions implemented and validated end to end.', ['Measurement layer', 'Consent configuration', 'Conversion validation']],
                ['Launch',     'Wk 04–08', 'Restructured campaigns, new creative in volume, audience and bidding strategy set, with a testing calendar running from week one.', ['Campaign structure', 'Creative batch', 'Test calendar']],
                ['Scale',      'Ongoing',  'Weekly optimisation, monthly incrementality reads and quarterly reallocation across channels, each decision recorded against evidence.', ['Weekly optimisation', 'Incrementality reads', 'Budget model']],
            ],
        ],
        'deliver' => [
            ['Account & tracking audit',              'Report'],
            ['Server-side measurement implementation','Tag manager · conversion APIs'],
            ['Campaign structure & bidding strategy', 'Accounts · document'],
            ['Creative testing framework & assets',   'Sheet · assets'],
            ['Incrementality test design & results',  'Report'],
            ['Performance dashboard',                 'Looker · Power BI'],
            ['Monthly budget allocation model',       'Sheet'],
        ],
        'outcomes' => [
            ['Numbers the board can trust','Consented, server-side measurement with offline conversions, so reported revenue reconciles with the finance view.'],
            ['Creative supply that keeps up','A testing framework and a production rhythm that feed the auction enough genuinely different variants to learn from.'],
            ['Budget moved on evidence',   'Holdout and matched-market tests decide where the next unit of spend goes, not the last-click report.'],
        ],
        'faq' => [
            ['Do you charge a percentage of ad spend?', 'Commercial models are agreed per engagement, and we are glad to work on a fee that is not tied to spend so the incentive stays on outcomes. Exact terms are set in the agreement.'],   // PLACEHOLDER: confirm commercial model before launch
            ['Who owns the ad accounts?', 'You do. Campaigns run in your accounts, under your billing, with your data, and access is handed back in full at the end of the engagement.'],
            ['Is last-click attribution still useful?', 'As a diagnostic, sometimes. As a budget decision, no. We combine platform data, consented first-party measurement and incrementality tests, and add a media-mix read once there is enough history.'],
            ['How does privacy change paid media?', 'Consent mode, server-side tagging, first-party data and modelled conversions now carry what third-party cookies used to. We build the consented path first and treat anything that depends on cookies as temporary.'],
            ['How much creative do we need?', 'More than most teams expect. Platforms now optimise across creative more than audiences, so a steady supply of genuinely different concepts, not colour variants, is what moves cost per acquisition.'],
        ],
        'pairs'     => ['omnichannel-marketing-strategy', 'social-influencer-activation'],
        'img'       => ['src' => 'assets/imgs/campaign/shared/performance-marketing.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A marketing analytics dashboard with line charts open on a desktop monitor', 'pos' => '50% 50%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['google', 'googleanalytics', 'googletagmanager', 'googlebigquery', 'looker', 'powerbi', 'hubspot', 'salesforce', 'shopify', 'semrush', 'posthog', 'mixpanel', 'dbt', 'openai'],
        'standards' => ['gdpr', 'dpdp', 'wcag22', 'nist-ai-rmf'],
    ],

    'omnichannel-marketing-strategy' => [
        'n'          => '06',
        'slug'       => 'omnichannel-marketing-strategy',
        'name'       => 'Omnichannel Marketing Strategy',
        'short'      => 'Strategy',
        'kicker'     => 'One plan, every channel',
        'title'      => '<span class="g">A channel list is not a strategy.</span> A sequence is.',
        'lead'       => 'Omnichannel Marketing Strategy decides who to reach, where and in what order, what each channel is for, how much it gets, and how you will know it worked. It ends in a plan with owners, budgets and measures attached, not a deck.',
        'meta'       => ['6–8 weeks', 'Audience · channels · budget · measurement', 'Owners and measures attached'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Scope', 'Standard'],
        'cta'        => 'Start a strategy brief',
        'icon'       => 'compass',
        'offer_title'=> '<span class="g">Six decisions</span> a marketing plan has to make',
        'offer_lead' => 'Each one is made with evidence and written down, so the plan survives a change of budget or a change of marketing director.',
        'offer' => [
            ['Audience & demand definition','Who is in the market now, who will be later, and what each group needs to hear, built from your data rather than personas invented in a workshop.', 'In-market · future demand', 'users'],
            ['Journey & channel architecture','The route from unaware to customer, and the job each channel does along it, so nothing is bought out of habit.', 'A job per channel', 'pipeline'],
            ['Message & offer sequencing', 'What is said at each stage, in what order, with the proof that stage needs and the offer that moves someone on.', 'Sequenced', 'workflow'],
            ['Budget allocation model',    'Spend split by role — brand, demand capture, retention — with scenarios modelled for a larger and a smaller budget.', 'Scenario-modelled', 'chart'],
            ['Measurement framework',      'One definition of every metric, a data model behind it, and a reporting rhythm from weekly operations to the quarterly review.', 'One definition per metric', 'gauge'],
            ['Operating rhythm & governance','Who decides what, which meetings exist, how work enters the plan, and how it is stopped.', 'Owners · cadence', 'clipboard-check'],
        ],
        'process' => [
            'title' => '<span class="g">Eight weeks,</span> from evidence to a plan the team owns',
            'lead'  => 'Numbers, customers and the team’s own experience are read together, and the plan is built with the people who will run it.',
            'steps' => [
                ['Read',   'Wk 01–03', 'Performance history, CRM and analytics data, customer research, category context, and what the team already knows but cannot yet prove.', ['Performance read', 'Audience analysis', 'Category context']],
                ['Decide', 'Wk 03–06', 'Audiences, channel roles, message sequence and budget split agreed in working sessions, with scenarios modelled against each.', ['Channel architecture', 'Message sequence', 'Budget model']],
                ['Plan',   'Wk 06–07', 'A twelve-month plan with quarterly themes, campaign slots, owners, dependencies and the measure attached to each.', ['12-month plan', 'Campaign calendar', 'Measure set']],
                ['Enable', 'Wk 07–08', 'Dashboards, the operating rhythm and a working session with the teams who will run it, so the plan starts in the next sprint.', ['Reporting dashboard', 'Operating rhythm', 'Enablement session']],
            ],
        ],
        'deliver' => [
            ['Audience & demand analysis',            'Deck · sheet'],
            ['Journey & channel architecture',        'Diagram'],
            ['Message and offer sequence',            'Document'],
            ['Budget allocation model with scenarios','Sheet'],
            ['12-month plan & campaign calendar',     'Plan · calendar'],
            ['Measurement framework & dashboard',     'Document · dashboard'],
            ['Operating rhythm & responsibilities',   'Document'],
        ],
        'outcomes' => [
            ['A plan with owners',            'Every campaign slot carries a named owner, a budget, a measure and a date. Nothing sits unassigned.'],
            ['Budget argued with numbers',    'Allocation by channel role, with scenarios modelled, turns the budget conversation into arithmetic.'],
            ['One definition of every metric','Marketing, sales and finance read the same number the same way, so reviews are about decisions rather than definitions.'],
        ],
        'faq' => [
            ['Is this a marketing plan or a brand strategy?', 'It sits after brand strategy and before execution. Positioning and growth goals are inputs; the output is the decision on audiences, channels, sequence, budget and measurement.'],
            ['What data do you need?', 'Analytics and ad platform history, CRM and sales data, customer research where it exists, and a few hours with the people who run each channel. Gaps are recorded and worked around rather than hidden.'],
            ['Do you plan offline channels too?', 'Yes. Retail, events, print, out-of-home and field activity are planned in the same sequence as digital, each with measurement designed for it.'],
            ['How does AI fit into the plan?', 'Where it removes effort or improves a decision: audience modelling, creative variants, content operations, monitoring agents and always-on reporting. Each use has a named owner and a human approval point.'],
            ['Who executes the plan?', 'Your team, ours, or both. It is written so anyone can run it, and the operating rhythm makes the split of responsibility explicit.'],
        ],
        'pairs'     => ['performance-marketing', 'campaign-design-systems'],
        'img'       => ['src' => 'assets/imgs/campaign/shared/omnichannel-marketing-strategy.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A planning wall of sticky notes and printed charts with two colleagues discussing it', 'pos' => '50% 45%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['googleanalytics', 'googlebigquery', 'looker', 'powerbi', 'hubspot', 'salesforce', 'semrush', 'mixpanel', 'posthog', 'miro', 'notion', 'dbt', 'snowflake'],
        'standards' => ['gdpr', 'dpdp', 'wcag22'],
    ],

    'campaign-design-systems' => [
        'n'          => '07',
        'slug'       => 'campaign-design-systems',
        'name'       => 'Campaign Design Systems',
        'short'      => 'Systems',
        'kicker'     => 'Built once, runs everywhere',
        'title'      => '<span class="g">A campaign is not one film.</span> It is a system that holds.',
        'lead'       => 'Campaign Design Systems give a campaign what it needs to survive contact with forty formats and a dozen markets: one idea, an art direction, a message matrix, sized templates built on tokens, motion rules, and governance with automated checks before anything ships.',
        'meta'       => ['6–10 weeks', 'Idea · art direction · templates · governance', 'Checked automatically'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Scope', 'Standard'],
        'cta'        => 'Start a campaign system brief',
        'icon'       => 'layers',
        'offer_title'=> '<span class="g">Six parts</span> that keep a campaign recognisable',
        'offer_lead' => 'A campaign system is built like a product: tokens, components, rules and tests, so market teams move fast without drifting.',
        'offer' => [
            ['Campaign platform & master idea','One idea with enough room for every market and format, expressed as a line, a look, and a clear statement of what it is not.', 'One idea', 'lightbulb'],
            ['Art direction & campaign toolkit','Photography direction, typography, colour behaviour, graphic devices and motion, defined as a kit of parts rather than a set of finished ads.', 'Kit of parts', 'stack'],
            ['Message matrix',                 'Messages by audience, market and funnel stage, with the claims each one may make and the proof behind it.', 'Audience × stage', 'cube'],
            ['Master templates & sizing',      'Master artwork and sized templates for every placement, built on tokens so one change propagates instead of being remade forty times.', 'Tokens · every size', 'layers'],
            ['Localisation & adaptation rules','What markets may change and what they may not, with type, layout and legal variations handled by the system rather than by exception.', 'Fixed · flexible', 'globe'],
            ['Governance & automated checks',  'A review route, an asset register, and automated checks for colour, type, safe areas, contrast and legal lines before anything reaches media.', 'Checked before ship', 'check'],
        ],
        'process' => [
            'title' => '<span class="g">Design the system,</span> then prove it on the hardest format',
            'lead'  => 'Every direction is tested on the smallest, busiest and most regulated placement before it is chosen. If it holds there, it holds anywhere.',
            'steps' => [
                ['Frame',     'Wk 01–02', 'The campaign’s job, audiences, markets, placements and constraints. The hardest formats are identified and become the test cases.', ['Campaign brief', 'Format inventory', 'Constraint list']],
                ['Design',    'Wk 02–06', 'Two or three platforms developed and shown on real placements, including the awkward ones. One is chosen and refined into a toolkit.', ['Campaign directions', 'Chosen platform', 'Art direction']],
                ['Systemise', 'Wk 06–09', 'Tokens, master templates, the message matrix, motion rules and localisation rules built, then tested with a market team on live work.', ['Master templates', 'Message matrix', 'Localisation rules']],
                ['Govern',    'Wk 09–10', 'Guidelines published, automated checks configured, the asset register set up, and market teams trained on what they may change.', ['Campaign guidelines', 'Automated checks', 'Training session']],
            ],
        ],
        'deliver' => [
            ['Campaign platform & master idea',      'Deck'],
            ['Art direction & campaign toolkit',     'Figma · PDF'],
            ['Message matrix by audience and market','Sheet'],
            ['Master templates & design tokens',     'Figma · JSON'],
            ['Motion & sound rules',                 'Document · reference files'],
            ['Localisation & adaptation rules',      'Document'],
            ['Campaign guidelines & asset register', 'Web · sheet'],
        ],
        'outcomes' => [
            ['Recognisable at every size',  'The same campaign reads as itself in a six-second bumper, a billboard and a banner, because each was designed into the system.'],
            ['Markets move without asking', 'Clear rules on what may change let local teams adapt in a day instead of waiting a fortnight for approval.'],
            ['Fewer errors before launch',  'Automated checks for contrast, safe areas, type size and legal lines catch the mistakes that used to be found in the wild.'],
        ],
        'faq' => [
            ['How is this different from brand guidelines?', 'Brand guidelines describe the brand. A campaign system describes one campaign: its idea, its look, its messages and its templates, built to run for a season and then retire. It sits inside the brand system and inherits its tokens.'],
            ['Will this make everything look the same?', 'It removes the decisions that should not be remade — grid, type, safe areas, legal lines — and protects the ones that matter. Markets keep their casting, their language and their offer.'],
            ['Do you build the templates in our tools?', 'Yes. Usually Figma for design, with tokens exported for web and for automated production, and templates in the formats your media and production partners need.'],
            ['How do the automated checks work?', 'Rules are defined for colour, contrast, minimum type size, safe areas, logo clearspace and mandatory legal lines. Assets are checked against them in the production pipeline, and anything failing is flagged with the reason before it reaches media.'],
            ['Can AI generate campaign variants?', 'For resizing, variants, background extension and first-draft copy, inside the system’s rules and with a person approving each asset. Anything synthetic that could be mistaken for a real person, place or event is labelled and recorded.'],
        ],
        'pairs'     => ['global-content-production', 'omnichannel-marketing-strategy'],
        'img'       => ['src' => 'assets/imgs/campaign/shared/campaign-design-systems.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A designer arranges a grid of campaign layouts across a large screen', 'pos' => '50% 45%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['figma', 'storybook', 'contentful', 'sanity', 'webflow', 'notion', 'jira', 'linear', 'miro', 'github', 'n8n', 'openai', 'googlegemini'],
        'standards' => ['wcag22', 'cwv', 'eu-ai-act'],
    ],

    'global-content-production' => [
        'n'          => '08',
        'slug'       => 'global-content-production',
        'name'       => 'Global Content Production',
        'short'      => 'Production',
        'kicker'     => 'Produced where the story is',
        'title'      => '<span class="g">One brief, many places.</span> The same standard everywhere.',
        'lead'       => 'Global Content Production makes original photography, video, audio and CGI at scale, through a vetted network of local crews and creators. One brief, one review pipeline, rights cleared per market, and finished assets delivered into your systems in every size you need.',
        'meta'       => ['4–8 weeks per production wave', 'Photo · video · audio · CGI', 'Rights cleared per market'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Formats', 'Standard'],
        'cta'        => 'Start a production brief',
        'icon'       => 'vision',
        'offer_title'=> '<span class="g">Six ways content gets made,</span> one quality bar',
        'offer_lead' => 'Whether a shoot runs in one city or six, the brief, the review pipeline and the delivery standard stay the same.',
        'offer' => [
            ['Photography & film production','Full production from brief to delivery: direction, casting, locations, crew, shoot and post, run by a producer who owns the schedule and the budget.', 'End to end', 'vision'],
            ['Global crew network',         'Vetted local crews and creators in the markets you sell in, briefed centrally, so local production never means local standards.', 'Local crews, one standard', 'globe'],
            ['Content capture at scale',    'One production designed to yield a season of assets: hero films, cut-downs, stills, behind-the-scenes and library footage for the always-on calendar.', 'One shoot, a season', 'stack'],
            ['CGI, 3D & virtual production','Product CGI, 3D environments and virtual production where a physical shoot is impractical, expensive, or impossible to repeat in every market.', '3D · CGI', 'cube'],
            ['AI-assisted production',      'Generative tools for concepting, previsualisation, background extension, versioning, voice and subtitles, with provenance recorded and a person approving every asset.', 'Assisted, not automated', 'sparkle'],
            ['Post, localisation & delivery','Edit, grade, sound, subtitles, market versions and delivery into your asset library in every specification your channels require.', 'Versioned · delivered', 'pipeline'],
        ],
        'process' => [
            'title' => '<span class="g">One brief,</span> then a production line',
            'lead'  => 'Pre-production is where cost and risk are removed. By the shoot day, every frame already has a job.',
            'steps' => [
                ['Brief',      'Wk 01–02', 'An asset list built backwards from the channel plan: what is needed, in what sizes, for which markets, and what each asset has to do.', ['Asset list', 'Creative treatment', 'Budget & schedule']],
                ['Pre-produce','Wk 02–04', 'Casting, locations, permits, crew, shot list and the rights plan. Model, location and music releases prepared before anyone is on set.', ['Shot list', 'Crew & locations', 'Rights plan']],
                ['Produce',    'Wk 04–06', 'Shoot or build, with daily review against the shot list and remote approval for stakeholders who cannot be there.', ['Rushes', 'Daily review', 'Approved selects']],
                ['Deliver',    'Wk 06–08', 'Edit, grade, sound, subtitles, market versions and accessibility checks, then delivery into your library with metadata and rights recorded.', ['Final assets', 'Market versions', 'Rights & metadata record']],
            ],
        ],
        'deliver' => [
            ['Production plan, schedule & budget',       'Document · sheet'],
            ['Original photography & video',             'Master files'],
            ['Market versions & cut-downs',              'Per specification'],
            ['Subtitles, captions & audio description',  'SRT · WAV'],
            ['Rights, releases & usage record',          'Agreements · sheet'],
            ['Assets delivered into your library',       'With metadata'],
            ['Provenance record for AI-assisted assets', 'Sheet'],
        ],
        'outcomes' => [
            ['One shoot, a season of content','Productions planned against the channel calendar, so a single day on set feeds months of publishing.'],
            ['Local truth, one standard',     'Crews who know the market, briefed and reviewed centrally, so content feels local without looking improvised.'],
            ['Rights you can prove',          'Every asset carries its licence, term, territory and releases, so nobody has to guess whether an image can still run.'],
        ],
        'faq' => [
            ['Do you produce outside India?', 'Yes, through a vetted network of local producers and crews, with a central production lead owning the brief, the schedule and the review. Coverage in a specific market is confirmed before the plan is agreed.'],   // PLACEHOLDER: confirm network coverage before launch
            ['How do you keep quality consistent across markets?', 'One creative treatment, one shot-list standard, a reference kit, daily review by the central production lead, and the same post pipeline for every market.'],
            ['Do you use AI-generated imagery?', 'Where it serves the brief: concepting, previsualisation, extensions, versioning, voice and subtitles. Every asset is approved by a person, provenance is recorded, and anything that could be mistaken for a real person, place or event is labelled.'],
            ['What about usage rights and talent?', 'Rights are planned before the shoot: term, territory, media and renewal, with model, location and music releases held alongside the asset. Renewals are flagged before they lapse.'],
            ['Can you work with our existing production partners?', 'Yes. We often run the brief, the standard and the review pipeline while your partners produce, or take the markets where you have no coverage.'],
        ],
        'pairs'     => ['campaign-design-systems', 'content-marketing'],
        'img'       => ['src' => 'assets/imgs/campaign/shared/global-content-production.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A film crew sets up a camera and lighting rig on location', 'pos' => '50% 45%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['figma', 'contentful', 'sanity', 'notion', 'jira', 'slack', 'cloudflare', 'openai', 'googlegemini', 'replicate', 'huggingface', 'n8n', 'zapier'],
        'standards' => ['wcag22', 'gdpr', 'dpdp', 'eu-ai-act'],
    ],
];
