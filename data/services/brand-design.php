<?php
/**
 * Brand Design — the service catalogue. What a visitor can buy, page by page.
 *
 * Keyed by page key: 'brand-design' is the discipline hub (the best of all six capabilities,
 * grouped), then one entry per capability page. Rendered by partials/services/catalogue.php;
 * the schema is documented in partials/services/lib.php. A service id is '<page-key>:<offer-key>'.
 * Hub offers may carry 'cap' => '<capability slug>': the card then links to that capability's page.
 *
 * DRAFT COPY — review before launch. Timelines are typical, not promised, and every one is
 * marked PLACEHOLDER. No prices, client names or results: scope, timelines and who it suits only.
 * Voice: precise, kinetic, unshowy. Short active sentences. No exclamation marks.
 */

return [

    /* ---- Hub: services/brand-design.php ------------------------------------------------ */
    'brand-design' => [
        'discipline' => 'brand-design',
        'title'      => '<span class="g">Buy one piece,</span> or the whole system.',
        'lead'       => 'Every Brand Design capability is sold as scoped work. Enquire about one service, or add several to a brief and tell us how you would like to engage.',
        'categories' => [
            ['key' => 'strategy', 'name' => 'Strategy & foundation', 'icon' => 'compass', 'offers' => [
                ['key' => 'brand-audit', 'cap' => 'brand-foundation', 'name' => 'Brand audit & diagnostic',
                 'desc' => 'A fast read of where your brand stands: what holds, what drifts and what it costs you. It ends with a ranked list of what to fix first.',
                 'includes' => ['Stakeholder and customer interviews', 'Touchpoint and competitor audit', 'Brand health scorecard', 'Prioritised recommendations'],
                 'tags' => ['Entry point', 'Fixed scope'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams that sense a brand problem but have not yet named it'],
                ['key' => 'foundation-positioning', 'cap' => 'brand-foundation', 'name' => 'Brand foundation & positioning',
                 'desc' => 'Purpose, positioning, values and principles in plain words, tested against decisions you have already faced.',
                 'includes' => ['Leadership interviews and working sessions', 'Positioning statement with proof', 'Values written as decision principles', 'Foundation on a page'],
                 'tags' => ['Leadership-led', 'Rebrand', 'New venture'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Leadership teams that each describe the brand differently'],
                ['key' => 'growth-strategy', 'cap' => 'growth-strategy', 'name' => 'Growth strategy',
                 'desc' => 'Your next best customers and the openings nobody has taken, ranked and turned into a sequence of moves your team can run.',
                 'includes' => ['Market and category map', 'Next-best-customer ranking', 'Competitive whitespace map', 'Move roadmap: now, next, later'],
                 'tags' => ['Evidence first', 'Workshop-led'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands choosing where to grow next: a segment, a market or a category'],
                ['key' => 'customer-research', 'cap' => 'growth-strategy', 'name' => 'Customer & market research',
                 'desc' => 'Interviews, surveys and desk research that show what customers value and why they choose. Built to settle decisions, not to fill a deck.',
                 'includes' => ['Research plan and recruitment', 'In-depth customer interviews', 'Quantitative survey', 'Insight report with implications'],
                 'tags' => ['Qualitative', 'Quantitative'],
                 'time' => '3–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Decisions that need evidence from real customers first'],
                ['key' => 'narrative-messaging', 'cap' => 'brand-foundation', 'name' => 'Brand narrative & messaging',
                 'desc' => 'The story that connects what you believe to what you sell, in three lengths, with the messages and proof each audience needs.',
                 'includes' => ['Narrative in three lengths', 'Messaging house by audience', 'Proof points and claims check', 'Sales and leadership versions'],
                 'tags' => ['Verbal', 'Sales enablement'],
                 'time' => '2–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams that tell the story differently in every room'],
            ]],

            ['key' => 'identity', 'name' => 'Identity & expression', 'icon' => 'mark', 'offers' => [
                ['key' => 'identity-system', 'cap' => 'brand-identity', 'name' => 'Logo & identity system',
                 'desc' => 'Mark, colour, type, layout and imagery designed as one kit of parts, shown on real touchpoints before anything is chosen.',
                 'includes' => ['Two or three directions on real touchpoints', 'Logo suite and clearspace rules', 'Colour and type systems with tokens', 'Launch templates'],
                 'tags' => ['New brand', 'Rebrand'],
                 'stack' => ['figma'],
                 'time' => '6–10 weeks',  // PLACEHOLDER: typical — confirm
                 'best' => 'New ventures, and brands whose identity no longer fits the business'],
                ['key' => 'identity-refresh', 'cap' => 'brand-identity', 'name' => 'Identity refresh',
                 'desc' => 'A sharper system around the equity you already have. We keep what people recognise and fix what slows the team down.',
                 'includes' => ['Equity audit of current assets', 'Refined mark, colour and type', 'Updated core templates', 'Transition plan'],
                 'tags' => ['Evolution', 'Keeps equity'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Established brands that need to look current without starting over'],
                ['key' => 'verbal-identity', 'cap' => 'brand-identity', 'name' => 'Verbal identity & tone of voice',
                 'desc' => 'Voice, tone, vocabulary and the words you never use, written as rules with examples so anyone can write on brand.',
                 'includes' => ['Voice principles and tone range', 'Lexicon and words to avoid', 'Before-and-after rewrites', 'Writing workshop for your team'],
                 'tags' => ['Verbal', 'Guidelines'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands that look consistent but sound like five companies'],
                ['key' => 'motion-sonic', 'cap' => 'brand-identity', 'name' => 'Motion & sonic identity',
                 'desc' => 'How the brand moves and how it sounds: timing, easing, transitions and an audio signature for product, video and events.',
                 'includes' => ['Motion principles and timing tokens', 'Logo animation and transitions', 'Sonic logo and sound palette', 'Lottie and video templates'],
                 'tags' => ['Motion', 'Audio'],
                 'time' => '4–8 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands that live on screen, in product, video or events'],
                ['key' => 'packaging', 'cap' => 'brand-identity', 'name' => 'Packaging design',
                 'desc' => 'Packaging that holds on shelf and in the unboxing, with structures, dielines and artwork rules that scale across a range.',
                 'includes' => ['Range architecture and hierarchy', 'Structural and graphic design', 'Artwork templates and dielines', 'Print and production handover'],
                 'tags' => ['Physical', 'Product range'],
                 'time' => '6–12 weeks',  // PLACEHOLDER: typical — confirm
                 'best' => 'Consumer brands launching or refreshing a product range'],
                ['key' => 'guidelines', 'cap' => 'brand-identity', 'name' => 'Brand guidelines',
                 'desc' => 'One living reference for your identity: versioned, searchable and built to be used rather than admired.',
                 'includes' => ['Guidelines website or PDF', 'Do and do-not examples', 'Downloadable asset library', 'Walkthrough for your team'],
                 'tags' => ['Living reference'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams and agencies producing work on the brand every week'],
            ]],

            ['key' => 'systems', 'name' => 'Systems & portfolio', 'icon' => 'blocks', 'offers' => [
                ['key' => 'tokens-components', 'cap' => 'brand-systems', 'name' => 'Design tokens & components',
                 'desc' => 'Colour, type, space and motion as named values, and the shared components built from them, exported to design tools and code.',
                 'includes' => ['Token set in Figma variables and code', 'Core component library with states', 'Accessibility check on every component', 'Release notes and versioning'],
                 'tags' => ['One source', 'Product and marketing'],
                 'stack' => ['figma', 'storybook'],
                 'time' => '6–12 weeks',  // PLACEHOLDER: typical — confirm
                 'best' => 'Organisations where product and marketing rebuild the same parts'],
                ['key' => 'templates', 'cap' => 'brand-systems', 'name' => 'Template systems',
                 'desc' => 'Decks, social, email, landing pages and print that take content and stay on brand without a designer.',
                 'includes' => ['Template audit by volume', 'Templates in Figma, Office and your CMS', 'Flex rules for campaigns and markets', 'Training for the people who use them'],
                 'tags' => ['Content in, on brand out'],
                 'time' => '4–8 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams shipping high volumes of routine content'],
                ['key' => 'architecture', 'cap' => 'brand-architecture', 'name' => 'Brand architecture',
                 'desc' => 'Which brands you carry, how they relate and what each one is allowed to be. The model is chosen on evidence, trade-offs written down.',
                 'includes' => ['Portfolio audit', 'Architecture model and decision record', 'Relationship and lockup rules', 'New-brand test'],
                 'tags' => ['Portfolio', 'Model on evidence'],
                 'time' => '4–8 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Portfolios where customers confuse offerings or every launch starts a naming debate'],
                ['key' => 'naming', 'cap' => 'brand-architecture', 'name' => 'Naming & nomenclature',
                 'desc' => 'Names for companies, products, tiers and features, with a system for the next one and the screening to back it.',
                 'includes' => ['Naming strategy and criteria', 'Long list to shortlist', 'Language checks and preliminary trademark screening for your counsel', 'Nomenclature rules'],
                 'tags' => ['Naming', 'Scales'],
                 'time' => '3–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'New products, new ventures and portfolios with no naming logic'],
                ['key' => 'ma-integration', 'cap' => 'brand-architecture', 'name' => 'M&A brand integration',
                 'desc' => 'A plan for bringing an acquired or merged brand into the portfolio without losing customers or equity on the way.',
                 'includes' => ['Equity and overlap assessment', 'Integration model options', 'Phased migration plan', 'Launch and internal communications'],
                 'tags' => ['M&A', 'Phased'],
                 'time' => '6–10 weeks',  // PLACEHOLDER: typical — confirm
                 'best' => 'Companies after an acquisition or merger'],
            ]],

            ['key' => 'ai', 'name' => 'Brand AI tools', 'icon' => 'sparkle', 'offers' => [
                ['key' => 'tuned-models', 'cap' => 'brand-ai-tools', 'name' => 'Brand-tuned image models',
                 'desc' => 'Image models fine-tuned on your identity, so generation starts on brand instead of drifting toward it. The weights are yours.',
                 'includes' => ['Rights-checked training set', 'Fine-tuned model and eval set', 'Style and prompt presets', 'Deployment in your cloud accounts'],
                 'tags' => ['You own the model'],
                 'stack' => ['huggingface', 'pytorch', 'replicate'],
                 'time' => '6–10 weeks',  // PLACEHOLDER: typical — confirm
                 'best' => 'Brands producing imagery at volume across markets'],
                ['key' => 'brand-check', 'cap' => 'brand-ai-tools', 'name' => 'Brand check',
                 'desc' => 'A linter for the brand. It checks palette, logo use, type and tone on every asset, flags what is off and suggests the fix.',
                 'includes' => ['Brand rules written as tests', 'Plugin for your design tools', 'API for your content pipelines', 'Output log and reporting'],
                 'tags' => ['Automated review'],
                 'stack' => ['figma'],
                 'time' => '4–8 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams and agencies where review queues slow everything down'],
                ['key' => 'asset-pipeline', 'cap' => 'brand-ai-tools', 'name' => 'Asset generation pipeline',
                 'desc' => 'Campaign variants, market versions and formats produced from one approved source, with a person signing off where it matters.',
                 'includes' => ['Source-to-variant pipeline', 'Resizing and localisation', 'Human review step', 'Provenance record for every asset'],
                 'tags' => ['Volume', 'Human in the loop'],
                 'time' => '6–10 weeks',  // PLACEHOLDER: typical — confirm
                 'best' => 'Campaigns that ship in many sizes, languages and markets'],
                ['key' => 'copy-assistant', 'cap' => 'brand-ai-tools', 'name' => 'Voice-aware copy assistant',
                 'desc' => 'Writing help that knows your voice, lexicon and the words you never use, inside the tools your team already writes in.',
                 'includes' => ['Voice rules as a tested prompt set', 'Evaluation against your best examples', 'Integration with your writing tools', 'Guardrails and logging'],
                 'tags' => ['Verbal', 'Guardrails'],
                 'stack' => ['anthropic', 'openai', 'googlegemini'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams writing high volumes of product, sales or support copy'],
            ]],

            /* The former "ways to work together" models that are really services live here now;
               how they are bought (sprint, retainer, enterprise…) is the packages row. */
            ['key' => 'programmes', 'name' => 'Programmes & operations', 'icon' => 'layers', 'offers' => [
                ['key' => 'brand-programme', 'name' => 'End-to-end brand programme',
                 'desc' => 'Inception to rollout in one programme: foundation, identity, systems and tools, run by one team on one plan.',
                 'includes' => ['Engagement director and capability leads', 'Foundation, identity and system in sequence', 'Governance with your steering group', 'Rollout plan across markets'],
                 'tags' => ['Rebrand', 'Merger', 'New venture'],
                 'time' => '16–24 weeks', // PLACEHOLDER: typical — confirm
                 'best' => 'Rebrands, mergers and new ventures that need every piece at once'],
                ['key' => 'launch-rollout', 'cap' => 'brand-identity', 'name' => 'Brand launch & rollout',
                 'desc' => 'The first months in the wild: internal launch, team training, touchpoint rollout and a review once the brand is live.',
                 'includes' => ['Internal launch kit', 'Training for teams and agencies', 'Touchpoint rollout tracker', 'First-month review'],
                 'tags' => ['Launch', 'Adoption'],
                 'time' => '3–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands about to go live that want adoption to stick'],
                ['key' => 'brand-office', 'cap' => 'brand-systems', 'name' => 'Brand office',
                 'desc' => 'Your embedded brand team after launch: governance, templates and campaigns, with the system kept current month by month.',
                 'includes' => ['System editor and designers', 'Request queue with agreed response times', 'Monthly governance review', 'Quarterly system release'],
                 'tags' => ['Ongoing', 'Embedded'],
                 'time' => 'Ongoing · monthly',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands that want a standing brand team without hiring one'],
                ['key' => 'ai-operations', 'cap' => 'brand-ai-tools', 'name' => 'Brand AI operations',
                 'desc' => 'Your brand tools run as a managed service: models retuned, checks updated and every output logged.',
                 'includes' => ['Model monitoring and retuning', 'Guardrail and eval updates', 'Usage and quality reporting', 'Named AI lead and brand reviewer'],
                 'tags' => ['Managed service', 'Ongoing'],
                 'time' => 'Ongoing · monthly',   // PLACEHOLDER: typical — confirm
                 'best' => 'High content volume across many markets and teams'],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer', 'enterprise', 'squad'],
    ],

    /* ---- Capability pages: services/brand-design/<slug>.php ---------------------------- */
    /* ─────────────────────────────────────────────────────────────── 01 · Growth Strategy */
    'growth-strategy' => [
        'discipline' => 'brand-design',
        'title' => '<span class="g">Know where to play.</span> Then decide the order.',
        'lead'  => 'Commission a two-week diagnostic, a single piece of research or the full growth strategy. Each one is scoped up front and ends in decisions your leadership team can act on.',
        'categories' => [
            ['key' => 'market-category', 'name' => 'Market & category', 'icon' => 'map', 'offers' => [
                ['key' => 'market-category-mapping', 'name' => 'Market & category mapping',
                 'desc' => 'Where the category is moving, who is winning which segment and which openings are real. You get the map, the evidence behind it and a read-out for leadership.',
                 'includes' => ['Category and competitor map', 'Segment-by-segment share read', 'Demand and trend signals', 'Leadership read-out'],
                 'tags' => ['Diagnostic', 'Fixed scope'],
                 'time' => '3–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Leadership teams planning the next three years of growth'],
                ['key' => 'competitive-whitespace', 'name' => 'Competitive whitespace',
                 'desc' => 'Competitors plotted on the attributes buyers actually use to choose. The gaps nobody holds, tested against what your brand can credibly claim.',
                 'includes' => ['Buyer-attribute frame from interviews', 'Competitor positioning map', 'Review and search mining', 'Whitespace shortlist with fit scores'],
                 'tags' => ['Positioning input', 'Fixed scope'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands in crowded categories where every competitor sounds the same'],
                ['key' => 'new-market-entry', 'name' => 'New market entry assessment',
                 'desc' => 'Whether to enter a new country, sector or category, and how. Size, access, competition and the brand’s right to win, weighed before money is committed.',
                 'includes' => ['Market sizing and access read', 'Local competitor and channel scan', 'Right-to-win assessment', 'Go or no-go recommendation with conditions'],
                 'tags' => ['Expansion', 'Decision-ready'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands weighing a new geography, sector or adjacent category'],
                ['key' => 'category-watch', 'name' => 'Category & competitor watch',
                 'desc' => 'A standing read on your category: competitor moves, new entrants, pricing shifts and customer sentiment, summarised with what each means for your plan.',
                 'includes' => ['Competitor and new-entrant tracking', 'Search, review and social signals', 'Quarterly briefing to leadership', 'Alerts on material moves'],
                 'tags' => ['Ongoing', 'Early warning'],
                 'stack' => ['semrush'],
                 'time' => 'Ongoing · quarterly',   // PLACEHOLDER: typical — confirm
                 'best' => 'Leadership teams in fast-moving or crowded categories'],
            ]],
            ['key' => 'customers-demand', 'name' => 'Customers & demand', 'icon' => 'target', 'offers' => [
                ['key' => 'next-best-customer', 'name' => 'Next-best-customer ranking',
                 'desc' => 'The segments most likely to buy next, sized and ranked by fit, reach and margin. Your leadership sets the weights; the shortlist re-ranks as they change.',
                 'includes' => ['Segment definitions from your data', 'Scoring model with agreed weights', 'Ranked shortlist with rationale', 'Segment profiles for sales and marketing'],
                 'tags' => ['Segmentation', 'Ranked · scored'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands with more possible segments than budget to chase them'],
                ['key' => 'customer-research', 'name' => 'Customer research programme',
                 'desc' => 'Interviews, surveys and jobs-to-be-done work that show why customers buy, switch and leave. Designed around the decisions the research has to settle.',
                 'includes' => ['Research plan tied to open decisions', 'Customer and lost-customer interviews', 'Quantitative survey', 'Jobs-to-be-done map and synthesis'],
                 'tags' => ['Primary research', 'Qual · quant'],
                 'time' => '4–8 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams making large calls on assumptions nobody has tested'],
                ['key' => 'win-loss-analysis', 'name' => 'Win–loss analysis',
                 'desc' => 'Why deals are won and lost, from structured interviews with buyers who chose you and buyers who did not. Reasons ranked, with actions for each team.',
                 'includes' => ['Win and loss interview programme', 'Sales and CRM pattern review', 'Reasons ranked by frequency and value', 'Actions for sales, product and brand'],
                 'tags' => ['Research', 'Sales input'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'B2B brands with long sales cycles and unclear reasons for losing'],
                ['key' => 'pricing-packaging', 'name' => 'Pricing & packaging research',
                 'desc' => 'How customers value what you sell and how they prefer to buy it. Tiers, bundles and price architecture tested with buyers before they reach the market.',
                 'includes' => ['Willingness-to-pay research', 'Tier and bundle options', 'Price architecture recommendation', 'Plan and tier names that fit the brand'],
                 'tags' => ['Commercial', 'Research-led'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands launching tiers, changing plans or moving upmarket'],
                ['key' => 'brand-health-tracking', 'name' => 'Brand health tracking set-up',
                 'desc' => 'A tracker for awareness, consideration and perception against the competitors that matter. Designed, fielded and baselined, then reported on a set cadence.',
                 'includes' => ['Tracker design and question set', 'Competitor set and sample frame', 'Baseline wave and dashboard', 'Wave reporting on a set cadence'],
                 'tags' => ['Tracking', 'Baseline first'],
                 'stack' => ['looker', 'powerbi'],
                 'time' => '4–6 weeks, then quarterly',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands that want a baseline before a repositioning or relaunch'],
            ]],
            ['key' => 'growth-planning', 'name' => 'Growth planning', 'icon' => 'steps', 'offers' => [
                ['key' => 'growth-thesis', 'name' => 'Growth thesis',
                 'desc' => 'One page that says where growth comes from, in what order and what has to be true for it to happen. Built from the evidence and argued with leadership until it holds.',
                 'includes' => ['Growth thesis on one page', 'Assumptions and what must be true', 'Evidence pack behind each claim', 'Leadership working session'],
                 'tags' => ['One page', 'Board-ready'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Leadership teams that need one account of growth before a plan'],
                ['key' => 'value-proposition', 'name' => 'Value proposition design',
                 'desc' => 'The proposition for each priority segment: what you offer, why it matters to them and the proof that backs it. Tested with buyers before it goes to market.',
                 'includes' => ['Proposition per priority segment', 'Proof points and evidence', 'Buyer testing sessions', 'Messaging hand-off to marketing'],
                 'tags' => ['Proposition', 'Buyer-tested'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands entering new segments with a proposition built for the old ones'],
                ['key' => 'go-to-market-sequencing', 'name' => 'Go-to-market sequencing',
                 'desc' => 'Moves ordered now, next and later, each with an owner, a measure and a date. The plan marketing, sales and product all run from.',
                 'includes' => ['Now, next and later move roadmap', 'Owner, measure and date per move', 'Channel and message priorities by segment', 'Dependencies and risks logged'],
                 'tags' => ['Roadmap', 'Cross-functional'],
                 'time' => '3–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Launches, repositionings and entries into new segments'],
                ['key' => 'measurement-framework', 'name' => 'Measurement framework',
                 'desc' => 'The north-star, its drivers and the early signals, agreed before the first move ships. Every measure has a source, a cadence, an owner and a baseline.',
                 'includes' => ['North-star and driver tree', 'Leading indicators per driver', 'Definitions, sources and owners', 'Baselines pulled from your systems'],
                 'tags' => ['KPI design', 'Defined up front'],
                 'time' => '2–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams that report plenty of numbers but agree on none of them'],
                ['key' => 'growth-strategy-programme', 'name' => 'Growth strategy programme',
                 'desc' => 'The full engagement: market map, ranked segments, whitespace, growth thesis and a sequenced roadmap, run as one programme with leadership sessions throughout.',
                 'includes' => ['Market map and segment ranking', 'Whitespace map and growth thesis', 'Sequenced move roadmap', 'Measurement frame and handover session'],
                 'tags' => ['Most complete', 'End to end'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands planning a step change: a new market, a raise or a reset'],
            ]],
            ['key' => 'leadership-advisory', 'name' => 'Leadership & advisory', 'icon' => 'handshake', 'offers' => [
                ['key' => 'growth-diagnostic', 'name' => 'Growth diagnostic sprint',
                 'desc' => 'Two weeks on your data, your pipeline and a handful of customer calls. A clear read on where growth is stalling and which questions a full strategy should answer.',
                 'includes' => ['Sales and customer data review', 'Five to eight customer conversations', 'Growth blockers, ranked', 'Scoped brief for the next step'],
                 'tags' => ['Entry point', 'Sprint'],
                 'time' => '1–2 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams that know growth has slowed but not yet why'],
                ['key' => 'leadership-offsite', 'name' => 'Leadership strategy offsite',
                 'desc' => 'A designed and facilitated session that takes a leadership team from competing views to one set of growth priorities. Pre-reads, facilitation and a written record.',
                 'includes' => ['Stakeholder interviews beforehand', 'Pre-read built on your data', 'One- or two-day facilitated session', 'Decision record and next steps'],
                 'tags' => ['Workshop', 'Entry point'],
                 'time' => '2–3 weeks with preparation',   // PLACEHOLDER: typical — confirm
                 'best' => 'Leadership teams that need to agree priorities before they plan'],
                ['key' => 'board-growth-story', 'name' => 'Board & investor growth story',
                 'desc' => 'The market, customer and growth evidence shaped into the story a board or investor reads. Every claim sourced, every number traceable to its origin.',
                 'includes' => ['Market and category evidence', 'Growth thesis in board format', 'Sourced claims and appendix', 'Rehearsal with the leadership team'],
                 'tags' => ['Narrative', 'Board-ready'],
                 'time' => '2–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Companies preparing a board review, a raise or a strategic plan'],
                ['key' => 'growth-advisory', 'name' => 'Growth advisory retainer',
                 'desc' => 'A senior strategist on hand for the moves after the roadmap. Monthly reviews against the measures, fresh evidence when the market shifts and a view on each new opening.',
                 'includes' => ['Monthly review against the measure set', 'Quarterly roadmap refresh', 'Opportunity assessments on request', 'Leadership read-outs'],
                 'tags' => ['Retainer', 'Ongoing'],
                 'time' => 'Ongoing · monthly',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams running the roadmap in-house who want a strategist on hand'],
            ]],
        ],
        'packages' => ['sprint', 'project', 'retainer', 'enterprise'],
    ],

    /* ─────────────────────────────────────────────────────────────── 02 · Brand Identity */
    'brand-identity' => [
        'discipline' => 'brand-design',
        'title' => '<span class="g">One kit of parts.</span> Recognisable on every surface.',
        'lead'  => 'Commission a full identity, refresh the one you have, or add a single part such as a voice, a motion language or a packaging range. Every piece is designed as part of one system.',
        'categories' => [
            ['key' => 'visual-identity', 'name' => 'Visual identity', 'icon' => 'mark', 'offers' => [
                ['key' => 'identity-health-check', 'name' => 'Identity health check',
                 'desc' => 'How your identity performs on every live touchpoint: where it holds, where it drifts, and whether you need a refresh, a new system or simply better rules.',
                 'includes' => ['Touchpoint audit across channels', 'Equity read: what to keep', 'Drift and consistency report', 'Recommendation: refine, refresh or rebuild'],
                 'tags' => ['Entry point', 'Sprint'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands unsure whether they need a new identity or a sharper one'],
                ['key' => 'logo-identity-system', 'name' => 'Logo & identity system',
                 'desc' => 'A mark, a wordmark and the kit of parts around them, built on a construction grid and tested on real touchpoints from the first concept.',
                 'includes' => ['Primary logo, wordmark and monogram', 'Construction grid and clear-space rules', 'Colour palette with roles and pairings', 'Master artwork in every format'],
                 'tags' => ['New brand', 'Rebrand'],
                 'stack' => ['figma'],
                 'time' => '6–10 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'New ventures and brands whose mark no longer fits the business'],
                ['key' => 'identity-refresh', 'name' => 'Visual identity refresh',
                 'desc' => 'A sharper system around a mark that already has equity. We keep what customers recognise and fix what has drifted, so the change reads as progress.',
                 'includes' => ['Equity audit of current assets', 'Refined mark and lock-ups', 'Updated colour and type system', 'Transition plan for live materials'],
                 'tags' => ['Evolution', 'Keeps equity'],
                 'time' => '4–8 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Established brands that look dated or inconsistent but are still recognised'],
                ['key' => 'typography-custom-type', 'name' => 'Typography & custom type',
                 'desc' => 'A type system chosen or drawn for the brand: typefaces, a scale and the rules for hierarchy. Custom or modified fonts where licensing or character demands it.',
                 'includes' => ['Typeface selection and licensing advice', 'Type scale and hierarchy rules', 'Custom or modified display face, if needed', 'Web and app font files'],
                 'tags' => ['Type system', 'Custom option'],
                 'time' => '3–5 weeks; custom faces longer',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands whose type is generic, over-licensed or unreadable on screen'],
                ['key' => 'iconography-illustration', 'name' => 'Iconography & illustration',
                 'desc' => 'An icon set and an illustration style that follow the same grid, stroke and colour rules as the identity, with the guidance to extend them without us.',
                 'includes' => ['Core icon set on a shared grid', 'Illustration style with examples', 'Construction and extension rules', 'SVG library for product and web'],
                 'tags' => ['Visual language', 'Extensible'],
                 'stack' => ['figma'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Product and content-heavy brands that need visual language at volume'],
                ['key' => 'photography-art-direction', 'name' => 'Photography & art direction',
                 'desc' => 'How the brand sees the world: subject, light, crop and treatment. A photography brief, a reference library and art direction on the first shoots.',
                 'includes' => ['Photography principles and brief', 'Crop, colour and treatment rules', 'Curated reference and stock library', 'Art direction on first shoots'],
                 'tags' => ['Imagery', 'Art direction'],
                 'time' => '3–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands whose imagery comes from many sources and looks it'],
            ]],
            ['key' => 'verbal-identity', 'name' => 'Verbal identity', 'icon' => 'quote', 'offers' => [
                ['key' => 'brand-naming', 'name' => 'Brand naming',
                 'desc' => 'A name for a company, a brand or a flagship product. Territories, a long list, a shortlist and linguistic checks in every market, screened with your legal counsel.',
                 'includes' => ['Naming brief and territories', 'Long list with creative rationale', 'Linguistic checks in target markets', 'Preliminary trademark screening'],
                 'tags' => ['Naming', 'Multi-market'],
                 'time' => '4–8 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'New companies, flagship launches and brands forced to rename'],
                ['key' => 'voice-tone', 'name' => 'Voice & tone',
                 'desc' => 'How the brand sounds, written as rules with examples. Voice stays fixed, tone moves with the moment, and anyone who writes for the brand can follow it.',
                 'includes' => ['Voice principles with do and don’t examples', 'Tone map across key moments', 'Lexicon and the words you never use', 'Rewrites of priority copy'],
                 'tags' => ['Verbal', 'Rules with examples'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands with many writers, agencies or markets and no shared voice'],
                ['key' => 'tagline-signature', 'name' => 'Tagline & signature lines',
                 'desc' => 'A line that carries the brand, and the signature phrases around it. Developed from the positioning and tested in real layouts, never in isolation.',
                 'includes' => ['Tagline routes from the positioning', 'Testing in real layouts', 'Final line with usage rules', 'Supporting signature phrases'],
                 'tags' => ['Tagline', 'Fixed scope'],
                 'time' => '2–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands launching or relaunching that need one line to carry the idea'],
                ['key' => 'product-ux-voice', 'name' => 'Product & UX voice',
                 'desc' => 'The voice applied inside the product: buttons, errors, empty states and onboarding. Reusable patterns, with the words for the hardest moments already written.',
                 'includes' => ['UX writing principles', 'Patterns for errors, empty states and prompts', 'Rewrite of core product flows', 'Content guidance in the design system'],
                 'tags' => ['Product', 'UX writing'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Digital products where the interface does most of the talking'],
            ]],
            ['key' => 'behaviour-motion', 'name' => 'Behaviour & motion', 'icon' => 'film', 'offers' => [
                ['key' => 'behavioural-identity', 'name' => 'Behavioural identity',
                 'desc' => 'How the brand acts in the moments that matter: the first open, a mistake, a goodbye. Principles with worked examples that product and service teams can apply.',
                 'includes' => ['Behaviour principles', 'Key-moment map across the journey', 'Worked examples for each moment', 'Team workshop to apply them'],
                 'tags' => ['Experience', 'Principles'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Service and product brands where the experience is the brand'],
                ['key' => 'motion-identity', 'name' => 'Motion identity',
                 'desc' => 'How the brand moves: easing curves, timings, transitions and a signature animation, specified so product, film and social teams all move the same way.',
                 'includes' => ['Motion principles and curve library', 'Animated logo and signature sting', 'Transition and UI motion specs', 'Lottie and video source files'],
                 'tags' => ['Motion', 'Product-ready'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands that live on screens: product, film and social'],
                ['key' => 'sonic-identity', 'name' => 'Sonic identity',
                 'desc' => 'A sonic logo and a small palette of sounds for the moments the brand is heard: product, film, events and voice. Composed, mixed and delivered with usage rules.',
                 'includes' => ['Sonic logo in several lengths', 'UI and notification sounds', 'Music direction brief', 'Mastered files and usage rules'],
                 'tags' => ['Audio', 'Sonic logo'],
                 'time' => '4–8 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands heard as often as they are seen: apps, broadcast, voice'],
                ['key' => 'digital-product-identity', 'name' => 'Digital identity for product',
                 'desc' => 'The identity translated into interface: colour roles, type, icons and motion mapped to your product tokens, so the product inherits the brand rather than redrawing it.',
                 'includes' => ['Identity mapped to product tokens', 'Core screens and UI kit', 'Accessibility checks against WCAG 2.2', 'Handover to the product design team'],
                 'tags' => ['Product', 'Tokens'],
                 'stack' => ['figma'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands whose product is the touchpoint customers see most'],
            ]],
            ['key' => 'application-rollout', 'name' => 'Application & rollout', 'icon' => 'box', 'offers' => [
                ['key' => 'packaging-design', 'name' => 'Packaging design',
                 'desc' => 'Packaging built from the identity system: structure, hierarchy, range architecture and artwork, tested on shelf and on screen before it goes to print.',
                 'includes' => ['Range architecture and hierarchy', 'Primary pack design and key variants', 'Shelf and e-commerce testing', 'Print-ready artwork and specifications'],
                 'tags' => ['Physical', 'Range'],
                 'time' => '6–10 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Consumer brands launching, extending or refreshing a range'],
                ['key' => 'environmental-signage', 'name' => 'Environmental & signage',
                 'desc' => 'The identity in physical space: signage, wayfinding, fascias and interiors, designed with your architects and fabricators and specified to build.',
                 'includes' => ['Signage family and wayfinding rules', 'Fascia and interior applications', 'Fabrication drawings and specifications', 'Supplier and installation liaison'],
                 'tags' => ['Spaces', 'Specified to build'],
                 'time' => '6–12 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands with offices, stores, campuses or event spaces'],
                ['key' => 'brand-guidelines', 'name' => 'Brand guidelines',
                 'desc' => 'One living reference for the visual, verbal and behavioural codes. Online, searchable and versioned, with a PDF export, so the book and the asset library agree.',
                 'includes' => ['Online guidelines site', 'PDF export for partners and suppliers', 'Linked asset library', 'Version history and a named owner'],
                 'tags' => ['Living reference', 'Web · PDF'],
                 'time' => '3–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands whose rules live in an out-of-date PDF, or nowhere'],
                ['key' => 'launch-rollout-kit', 'name' => 'Launch & rollout kit',
                 'desc' => 'Templates for the first touchpoints, a phased rollout plan and a walkthrough for the teams who use them. Then a review after the first month in the wild.',
                 'includes' => ['Templates for priority touchpoints', 'Phased rollout plan and checklist', 'Team walkthrough and training', 'First-month review'],
                 'tags' => ['Rollout', 'Templates · training'],
                 'time' => '3–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Any new or refreshed identity going live across teams and markets'],
                ['key' => 'identity-studio-retainer', 'name' => 'Identity studio retainer',
                 'desc' => 'The team that designed the identity, on hand after launch: new applications, extensions, reviews of partner work and guidelines kept current. A named lead, monthly.',
                 'includes' => ['New applications and extensions', 'Design review of agency and partner work', 'Guidelines kept current', 'Monthly planning session'],
                 'tags' => ['Retainer', 'Ongoing'],
                 'time' => 'Ongoing · monthly',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands after launch that want the original team as guardian'],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer', 'enterprise'],
    ],

    /* ─────────────────────────────────────────────────────────────── 03 · Brand Foundation */
    'brand-foundation' => [
        'discipline' => 'brand-design',
        'title' => '<span class="g">Decide what the brand stands for.</span> Once, in writing.',
        'lead'  => 'Start with an audit or a leadership workshop, or commission the full foundation. Every part is written in plain words, tested against decisions you have already faced and signed off by leadership.',
        'categories' => [
            ['key' => 'diagnose-align', 'name' => 'Diagnose & align', 'icon' => 'search', 'offers' => [
                ['key' => 'brand-audit', 'name' => 'Brand audit',
                 'desc' => 'A structured review of what the brand says, shows and does today, against what customers and staff actually experience. Where it agrees with itself, and where it does not.',
                 'includes' => ['Review of documents, channels and materials', 'Customer and staff perception read', 'Tension map', 'Priorities for the foundation'],
                 'tags' => ['Entry point', 'Diagnostic'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands that suspect the story has drifted from the business'],
                ['key' => 'stakeholder-interviews', 'name' => 'Stakeholder interview programme',
                 'desc' => 'Confidential conversations with leaders, board members and front-line staff, drawn together into where the organisation agrees, where it does not and why.',
                 'includes' => ['Interview guide and schedule', 'Eight to fifteen confidential interviews', 'Synthesis and tension map', 'Read-out to the leadership team'],
                 'tags' => ['Listening', 'Confidential'],
                 'time' => '2–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Leadership teams after rapid growth, a merger or a change at the top'],
                ['key' => 'alignment-workshop', 'name' => 'Leadership alignment workshop',
                 'desc' => 'A facilitated session, or a short series, that takes leadership from competing views to agreed decisions on purpose, positioning and priorities. Prepared, short, recorded.',
                 'includes' => ['Pre-reads built from interviews', 'Facilitated working sessions', 'Positioning and priority exercises', 'Decision record circulated after'],
                 'tags' => ['Workshop', 'Sprint'],
                 'time' => '1–2 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Leadership teams that need agreement before anything is designed'],
                ['key' => 'foundation-test', 'name' => 'Foundation test',
                 'desc' => 'Your existing purpose, positioning and values run against decisions you have already faced. If they would not have helped, you see where and why.',
                 'includes' => ['Decision set from recent history', 'Each clause tested against it', 'Gaps and conflicts flagged', 'Rewrite recommendations'],
                 'tags' => ['Entry point', 'Fixed scope'],
                 'time' => '1–2 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands with a foundation on paper that nobody uses to decide'],
            ]],
            ['key' => 'core-strategy', 'name' => 'Core strategy', 'icon' => 'compass', 'offers' => [
                ['key' => 'purpose-vision-mission', 'name' => 'Purpose, vision & mission',
                 'desc' => 'Why the brand exists, where it is going and what it does about it. Written in plain words the whole company can repeat, not a line for the wall.',
                 'includes' => ['Purpose, vision and mission statements', 'Rationale and evidence for each', 'Drafts argued in working sessions', 'Plain-language versions for staff'],
                 'tags' => ['Core', 'Plain words'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Founder-led companies scaling past the founding team'],
                ['key' => 'brand-positioning', 'name' => 'Brand positioning',
                 'desc' => 'For whom, against what and why you. One statement with its proof, chosen from tested options and signed by the leadership team.',
                 'includes' => ['Competitive frame and audience', 'Two or three positioning options', 'Testing with customers', 'Final statement with proof points'],
                 'tags' => ['Positioning', 'Evidenced'],
                 'time' => '3–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands in crowded categories, or moving into new ones'],
                ['key' => 'values-principles', 'name' => 'Values & decision principles',
                 'desc' => 'The handful of things the brand will not trade away, written as principles that settle real decisions, with an example of each in use.',
                 'includes' => ['Values drawn from interviews', 'Principles written as decision rules', 'Worked examples for each', 'Behaviours for hiring and review'],
                 'tags' => ['Values', 'Decision rules'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Organisations whose values sit on a wall rather than in decisions'],
                ['key' => 'brand-platform', 'name' => 'Brand platform',
                 'desc' => 'The complete foundation in one engagement: purpose, positioning, values, audience and narrative, tested on real decisions and set down on one page.',
                 'includes' => ['Purpose, positioning and values', 'Audience definition and insight', 'Brand narrative at three lengths', 'Foundation on a page'],
                 'tags' => ['Most complete', 'Leadership-led'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'New brands, rebrands and new leadership teams'],
                ['key' => 'merger-foundation', 'name' => 'Foundation for a merger',
                 'desc' => 'One foundation for two organisations becoming one. What each brings, what the combined brand stands for and the principles that settle integration decisions.',
                 'includes' => ['Foundation read of both organisations', 'Shared purpose and positioning', 'Principles for integration decisions', 'Narrative for day one'],
                 'tags' => ['M&A', 'Time-critical'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Merging organisations that need one answer before day one'],
            ]],
            ['key' => 'audience-insight', 'name' => 'Audience & insight', 'icon' => 'users', 'offers' => [
                ['key' => 'audience-insight-research', 'name' => 'Audience insight research',
                 'desc' => 'Who the brand is for, what they need and the insight that makes the positioning true rather than tidy. Interviews, immersion or survey, sized to the decision.',
                 'includes' => ['Research design tied to decisions', 'Customer interviews or immersion', 'Audience definitions and needs', 'The core insight, evidenced'],
                 'tags' => ['Research', 'Evidence'],
                 'time' => '3–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands whose view of the customer comes from the sales team alone'],
                ['key' => 'perception-study', 'name' => 'Brand perception study',
                 'desc' => 'How customers, prospects and lapsed buyers see you against the alternatives, in their own words. The gap between the brand you intend and the one they receive.',
                 'includes' => ['Qualitative perception interviews', 'Perception survey against competitors', 'Associations and gap analysis', 'Implications for positioning'],
                 'tags' => ['Perception', 'Qual · quant'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands preparing a repositioning that want a baseline first'],
                ['key' => 'culture-category-scan', 'name' => 'Cultural & category scan',
                 'desc' => 'The cultural and category forces shaping how your audience thinks, and what they mean for the brand’s position. Desk research, social listening and expert conversations.',
                 'includes' => ['Cultural and category trend read', 'Social listening analysis', 'Expert conversations', 'Implications for the foundation'],
                 'tags' => ['Culture', 'Desk and expert'],
                 'time' => '2–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands in categories being reshaped by culture, regulation or technology'],
            ]],
            ['key' => 'narrative-culture', 'name' => 'Narrative & culture', 'icon' => 'book', 'offers' => [
                ['key' => 'brand-narrative', 'name' => 'Brand narrative',
                 'desc' => 'The story that connects the foundation to everything after. One version for a deck, one for a conversation, one for a new hire, all saying the same thing.',
                 'includes' => ['Narrative at three lengths', 'Proof points and stories', 'Presentation version', 'Notes for spokespeople'],
                 'tags' => ['Story', 'Three lengths'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands whose leaders tell the story differently every time'],
                ['key' => 'messaging-house', 'name' => 'Messaging house',
                 'desc' => 'The core message, the pillars under it and the proof under each, by audience. The source brief for campaigns, sales material and the website.',
                 'includes' => ['Core message and pillars', 'Proof points per pillar', 'Variants by audience', 'Message-to-channel guide'],
                 'tags' => ['Messaging', 'Campaign-ready'],
                 'time' => '2–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Marketing and sales teams writing from different briefs'],
                ['key' => 'employer-brand-evp', 'name' => 'Employer brand & EVP',
                 'desc' => 'Why good people join, stay and do their best work here, stated honestly. An employee value proposition built from staff research and tied to the master brand.',
                 'includes' => ['Staff research and exit themes', 'EVP and supporting pillars', 'Employer narrative and messaging', 'Recruitment application examples'],
                 'tags' => ['Talent', 'Research-led'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Growing organisations competing hard for talent'],
                ['key' => 'internal-launch', 'name' => 'Culture & internal launch',
                 'desc' => 'The foundation taken to the people who have to live it: a leadership toolkit, launch sessions and the routines that keep it in use after the first week.',
                 'includes' => ['Leader toolkit and talking points', 'Launch sessions and materials', 'Manager guides for team sessions', 'Checkpoints at 30 and 90 days'],
                 'tags' => ['Engagement', 'Internal'],
                 'time' => '3–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Organisations launching a new foundation to a large workforce'],
            ]],
        ],
        'packages' => ['sprint', 'project', 'enterprise'],
    ],

    /* ─────────────────────────────────────────────────────────────── 04 · Brand Systems */
    'brand-systems' => [
        'discipline' => 'brand-design',
        'title' => '<span class="g">One source of truth.</span> Every team ships on brand.',
        'lead'  => 'Commission the whole system, or start with the part that removes the most drift: tokens, components, templates or governance. Everything ships versioned and documented, in the tools your teams already use.',
        'categories' => [
            ['key' => 'tokens-components', 'name' => 'Tokens & components', 'icon' => 'tokens', 'offers' => [
                ['key' => 'system-audit', 'name' => 'System audit & drift report',
                 'desc' => 'Every touchpoint, file and component library you have, reviewed for drift, duplication and rework. A drift report and a scoped plan for the system.',
                 'includes' => ['Touchpoint and file inventory', 'Near-duplicate component review', 'Drift and rework report', 'Scoped system roadmap'],
                 'tags' => ['Entry point', 'Sprint'],
                 'stack' => ['figma'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands with several libraries, agencies or markets drifting apart'],
                ['key' => 'design-tokens', 'name' => 'Design tokens',
                 'desc' => 'Colour, type, space, radius and motion as named values in one source, exported to Figma variables and to code, so design and engineering read the same numbers.',
                 'includes' => ['Token architecture and naming', 'Figma variables and modes', 'JSON, CSS and platform exports', 'Build pipeline for token releases'],
                 'tags' => ['One source', 'Design + code'],
                 'stack' => ['figma', 'github', 'typescript'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams where product and marketing run different versions of the brand'],
                ['key' => 'component-library', 'name' => 'Component library',
                 'desc' => 'The parts every touchpoint is built from, designed once with their states and rules, then built in code where they ship. Shared by product, marketing and comms.',
                 'includes' => ['Core components with every state', 'Figma library with variants', 'Coded components in your framework', 'Storybook with usage notes'],
                 'tags' => ['Shared parts', 'Figma · code'],
                 'stack' => ['figma', 'storybook', 'react', 'typescript'],
                 'time' => '6–10 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Organisations building many screens, pages or products on one brand'],
                ['key' => 'multi-brand-theming', 'name' => 'Multi-brand theming',
                 'desc' => 'One component library serving several brands, markets or sub-brands through token themes. Switch the theme, keep the parts.',
                 'includes' => ['Theme architecture across brands', 'Token modes per brand or market', 'Theme switching in Figma and code', 'Rules for adding the next theme'],
                 'tags' => ['Multi-brand', 'Themes'],
                 'stack' => ['figma', 'storybook'],
                 'time' => '4–8 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Groups running several brands or white-label products on one platform'],
                ['key' => 'accessibility-audit', 'name' => 'Accessibility audit',
                 'desc' => 'Tokens, components and templates checked against WCAG 2.2 AA: contrast, focus, motion and structure. Fixes made at the source, so every touchpoint inherits them.',
                 'includes' => ['Contrast and colour-pair review', 'Component-level accessibility tests', 'Prioritised fix list', 'Fixes applied at token level'],
                 'tags' => ['WCAG 2.2 AA', 'Fixed scope'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands with legal or public-sector accessibility obligations'],
            ]],
            ['key' => 'templates-channels', 'name' => 'Templates & channels', 'icon' => 'layout', 'offers' => [
                ['key' => 'presentation-templates', 'name' => 'Deck & document templates',
                 'desc' => 'Decks, reports and documents that hold the rules, so the person filling them does not have to. Built in the office tools your teams actually use.',
                 'includes' => ['Master deck with a layout library', 'Report and proposal templates', 'Slide and chart styles', 'Short guide for authors'],
                 'tags' => ['Office', 'Content in · on brand out'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Sales, consulting and leadership teams that live in slides'],
                ['key' => 'social-email-templates', 'name' => 'Social & email templates',
                 'desc' => 'Formats for every channel you publish in, with safe areas, type limits and image crops built in. Write once; each format lays the content out on its own terms.',
                 'includes' => ['Social formats per platform', 'Modular email templates', 'Safe-area and crop rules', 'Editable source files'],
                 'tags' => ['Channels', 'Always-on'],
                 'stack' => ['figma'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Marketing teams publishing at volume across channels and markets'],
                ['key' => 'web-cms-templates', 'name' => 'Web & CMS templates',
                 'desc' => 'Page templates and content blocks in your CMS, built from the component library, so marketers can launch pages on brand without waiting for a designer or developer.',
                 'includes' => ['Page templates and block library', 'CMS content model', 'Build in your CMS', 'Editor guide and training'],
                 'tags' => ['Web', 'Editor-ready'],
                 'stack' => ['contentful', 'sanity', 'webflow', 'wordpress'],
                 'time' => '6–10 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Marketing teams waiting on developers for every new page'],
                ['key' => 'motion-templates', 'name' => 'Motion & video templates',
                 'desc' => 'Editable motion templates for social, product and presentations, with the brand’s curves and timings built in, so every edit moves like the brand.',
                 'includes' => ['Editable motion and video templates', 'Brand curves and timings built in', 'Titles, end frames and stings', 'Export presets per channel'],
                 'tags' => ['Motion', 'Video'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands producing video every week across social and product'],
                ['key' => 'print-templates', 'name' => 'Print & production templates',
                 'desc' => 'Print-ready templates and specifications for stationery, collateral, signage and point of sale, with production notes for your suppliers.',
                 'includes' => ['Stationery and collateral templates', 'Point-of-sale and signage templates', 'Colour and print specifications', 'Production notes for suppliers'],
                 'tags' => ['Print', 'Supplier-ready'],
                 'time' => '3–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands with physical collateral produced by many suppliers'],
            ]],
            ['key' => 'rules-governance', 'name' => 'Rules & governance', 'icon' => 'branch', 'offers' => [
                ['key' => 'flex-rules', 'name' => 'Flex rules',
                 'desc' => 'How far the brand can stretch for a campaign, a market or a sub-brand, and where it stops. Every element gets a floor and a ceiling, written as ranges.',
                 'includes' => ['Ranges for colour, type, imagery and layout', 'Presets for campaigns and markets', 'Exception route to the system owner', 'Tested on a live campaign'],
                 'tags' => ['Ranges · not opinions', 'Campaign-ready'],
                 'time' => '3–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands running many campaigns, markets or sub-brands at once'],
                ['key' => 'governance-versioning', 'name' => 'Governance & versioning',
                 'desc' => 'Who can change what, how a change ships and how every team knows which version it is on. Roles, a release process and a changelog people read.',
                 'includes' => ['Roles and approval rights', 'Release process and version rules', 'Changelog and release notes', 'Contribution guide'],
                 'tags' => ['Governance', 'Versioned'],
                 'stack' => ['github'],
                 'time' => '2–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Systems with many contributors and no clear owner'],
                ['key' => 'documentation-site', 'name' => 'System documentation site',
                 'desc' => 'A living site that shows the system in use, with design and code side by side and an owner named on every page. Searchable, versioned and yours to run.',
                 'includes' => ['Documentation site build', 'Design and code examples per component', 'Search and version switching', 'Page ownership and editing workflow'],
                 'tags' => ['Living site', 'Owned by you'],
                 'stack' => ['storybook', 'react', 'github'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Systems that have outgrown a PDF or a single Figma page'],
                ['key' => 'asset-library-dam', 'name' => 'Asset library & DAM set-up',
                 'desc' => 'One place for approved logos, images, templates and files, with metadata, permissions and expiry dates, so teams stop working from old downloads.',
                 'includes' => ['Asset audit and taxonomy', 'DAM configuration and permissions', 'Migration of approved assets', 'Rights and expiry metadata'],
                 'tags' => ['DAM', 'Rights-aware'],
                 'time' => '4–8 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands whose approved assets live in shared drives and inboxes'],
            ]],
            ['key' => 'build-run', 'name' => 'Build & run', 'icon' => 'cycle', 'offers' => [
                ['key' => 'brand-system-build', 'name' => 'Brand system build',
                 'desc' => 'The whole system in one programme: audit, tokens, components, templates, flex rules, governance and documentation, released together as version 1.0.',
                 'includes' => ['Audit and system scope', 'Tokens, components and templates', 'Flex rules and governance', 'Documentation site and v1.0 release'],
                 'tags' => ['Most complete', 'Phased'],
                 'time' => '8–12 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Organisations replacing a patchwork of libraries with one system'],
                ['key' => 'adoption-training', 'name' => 'Adoption & training',
                 'desc' => 'Training, office hours and onboarding for the teams who build with the system, plus a measure of how much of what ships is made from system parts.',
                 'includes' => ['Role-based training sessions', 'Onboarding guide for new teams', 'Office hours during rollout', 'Adoption tracking by team and channel'],
                 'tags' => ['Enablement', 'Measured by use'],
                 'time' => '2–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Systems that have launched but are not yet used by every team'],
                ['key' => 'system-editor-retainer', 'name' => 'System editor retainer',
                 'desc' => 'We stay on as the system’s editor: new components, releases, reviews of contributions and a monthly read of adoption. A named lead and set monthly capacity.',
                 'includes' => ['Component and template requests', 'Contribution review and releases', 'Monthly adoption report', 'Quarterly roadmap session'],
                 'tags' => ['Retainer', 'Ongoing'],
                 'time' => 'Ongoing · monthly',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams that own the system but lack the capacity to run it'],
                ['key' => 'embedded-systems-squad', 'name' => 'Embedded systems squad',
                 'desc' => 'Designers and front-end engineers working inside your team, in your tools and sprint cadence, to build or scale the system alongside your people.',
                 'includes' => ['Design and front-end specialists', 'Your backlog, tools and rituals', 'Weekly progress reporting', 'Knowledge transfer built in'],
                 'tags' => ['Squad', 'Time & materials'],
                 'stack' => ['figma', 'github', 'react'],
                 'time' => 'Ongoing · monthly',   // PLACEHOLDER: typical — confirm
                 'best' => 'Product organisations scaling a system faster than they can hire'],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer', 'enterprise', 'squad'],
    ],

    /* ─────────────────────────────────────────────────────────────── 05 · Brand Architecture */
    'brand-architecture' => [
        'discipline' => 'brand-design',
        'title' => '<span class="g">Every brand in its place.</span> Room for the next one.',
        'lead'  => 'Start with a portfolio audit or a single naming decision, or commission the full model with a phased migration. Every recommendation comes with its evidence and its trade-offs written down.',
        'categories' => [
            ['key' => 'portfolio-model', 'name' => 'Portfolio & model', 'icon' => 'tree', 'offers' => [
                ['key' => 'portfolio-audit', 'name' => 'Portfolio audit',
                 'desc' => 'Every brand, product, sub-brand and label you carry, mapped with what each costs, what each earns and where customers get lost between them.',
                 'includes' => ['Portfolio map of every brand', 'Customer navigation read', 'Cost-of-complexity estimate', 'Keep, merge and retire candidates'],
                 'tags' => ['Entry point', 'Diagnostic'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Portfolios that grew by launch and acquisition rather than design'],
                ['key' => 'portfolio-equity-study', 'name' => 'Portfolio equity study',
                 'desc' => 'Research that measures how much recognition and preference each brand in the portfolio carries, so keep, merge and retire decisions rest on evidence.',
                 'includes' => ['Awareness and preference by brand', 'Equity transfer testing', 'Customer attachment interviews', 'Equity ranking across the portfolio'],
                 'tags' => ['Research', 'Evidence'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Portfolios facing merge or retire decisions on established names'],
                ['key' => 'architecture-model', 'name' => 'Architecture model',
                 'desc' => 'Branded house, endorsed, house of brands or a hybrid, tested against your growth plans and customer behaviour. One model chosen, trade-offs recorded.',
                 'includes' => ['Model options with scenarios', 'Customer testing of structures', 'Decision record and rationale', 'Leadership decision session'],
                 'tags' => ['Core', 'Model on evidence'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Companies whose structure no longer matches how customers buy'],
                ['key' => 'relationship-lockup-rules', 'name' => 'Relationship & lockup rules',
                 'desc' => 'How the master brand and each sub-brand appear together: lockups, hierarchy, proximity and the cases where they never meet. Drawn to dimension.',
                 'includes' => ['Endorsement levels and lockups', 'Hierarchy and proximity rules', 'Co-branding and partner rules', 'Artwork for every lockup'],
                 'tags' => ['Lockups', 'Visual rules'],
                 'time' => '3–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands with sub-brands, endorsed products or partner co-branding'],
                ['key' => 'brand-extension', 'name' => 'Brand extension assessment',
                 'desc' => 'Whether the master brand can stretch to a new category, audience or price point without harming either side, tested with customers before launch.',
                 'includes' => ['Stretch and fit analysis', 'Customer testing of extension concepts', 'Risk to core equity assessed', 'Recommendation and brand route'],
                 'tags' => ['Stretch test', 'Decision-ready'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands considering a new category or price tier'],
            ]],
            ['key' => 'naming', 'name' => 'Naming', 'icon' => 'tag', 'offers' => [
                ['key' => 'naming-system', 'name' => 'Naming system & nomenclature',
                 'desc' => 'A nomenclature for products, tiers and features that scales, with the rules for when something earns a name and when it gets a plain descriptor.',
                 'includes' => ['Naming principles and territories', 'Tier and descriptor ladder', 'Rules for features and editions', 'Current names mapped to the system'],
                 'tags' => ['Nomenclature', 'Scales'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Product companies adding offers faster than they can name them'],
                ['key' => 'product-subbrand-naming', 'name' => 'Product & sub-brand naming',
                 'desc' => 'Names for a new product, service or sub-brand, created inside the naming system and screened for meaning and conflicts in every market you sell in.',
                 'includes' => ['Naming brief within the system', 'Long list and shortlist', 'Linguistic checks by market', 'Preliminary trademark screening'],
                 'tags' => ['Naming', 'Multi-market'],
                 'time' => '3–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Launch teams that need a name that fits the family'],
                ['key' => 'naming-rationalisation', 'name' => 'Naming rationalisation',
                 'desc' => 'Every product and feature name reviewed against the naming system: which stay, which become descriptors and which retire, with an order for the changes.',
                 'includes' => ['Inventory of current names', 'Keep, rename or retire verdicts', 'Customer impact assessment', 'Renaming sequence'],
                 'tags' => ['Clean-up', 'Phased'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Portfolios with overlapping or confusing product names'],
                ['key' => 'new-brand-test', 'name' => 'New-brand test',
                 'desc' => 'The test a proposal must pass before it earns a name of its own. Four questions, the exits and who decides, so naming debates end before launch week.',
                 'includes' => ['Decision test as a one-page flow', 'Outcomes: descriptor, sub-brand, new brand', 'Decision rights and approvers', 'Worked examples from your portfolio'],
                 'tags' => ['Entry point', 'One page'],
                 'time' => '1–2 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Organisations where every team wants a brand of its own'],
            ]],
            ['key' => 'customer-wayfinding', 'name' => 'Customer wayfinding', 'icon' => 'signpost', 'offers' => [
                ['key' => 'navigation-research', 'name' => 'Customer navigation research',
                 'desc' => 'How customers actually find, compare and choose between your offers, from tree tests, card sorts and interviews. The evidence the structure is built on.',
                 'includes' => ['Card sorts and tree tests', 'Customer interviews', 'Search and analytics review', 'Navigation findings and priorities'],
                 'tags' => ['Research', 'Evidence'],
                 'time' => '3–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Portfolios where customers pick the wrong product, or none'],
                ['key' => 'web-product-wayfinding', 'name' => 'Web & product wayfinding',
                 'desc' => 'The architecture turned into navigation: site structure, product menus and range pages ordered the way customers look for things, not the way the company is organised.',
                 'includes' => ['Site and product structure', 'Navigation and labelling rules', 'Range and comparison page design', 'Prototypes tested on key routes'],
                 'tags' => ['Digital', 'Customer-led'],
                 'stack' => ['figma'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands whose website mirrors the org chart'],
                ['key' => 'digital-estate-plan', 'name' => 'Domain & digital estate plan',
                 'desc' => 'Which brands get their own domain, app or social account, and which live inside the master brand’s. The digital estate mapped to the architecture.',
                 'includes' => ['Audit of domains, apps and handles', 'Estate structure mapped to the model', 'Redirect and consolidation plan', 'Search visibility risks flagged'],
                 'tags' => ['Digital estate', 'Consolidation'],
                 'time' => '2–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands with sprawling domains, microsites, apps and social handles'],
            ]],
            ['key' => 'migration-governance', 'name' => 'Migration & governance', 'icon' => 'arrows', 'offers' => [
                ['key' => 'migration-plan', 'name' => 'Migration plan',
                 'desc' => 'How to move from today’s portfolio to the new structure without confusing customers or breaking what works. Phased, sequenced and measured.',
                 'includes' => ['Phased migration roadmap', 'Sequence by risk and return', 'Customer and staff communications plan', 'Measures to track each phase'],
                 'tags' => ['Phased', 'Risk-managed'],
                 'time' => '3–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Any architecture change that touches live products and customers'],
                ['key' => 'ma-brand-integration', 'name' => 'M&A brand integration',
                 'desc' => 'What happens to an acquired or merged brand: keep, endorse, merge or retire. Decided on equity evidence, then planned so customers and staff come with you.',
                 'includes' => ['Equity assessment of both brands', 'Integration options and recommendation', 'Day-one and transition identity', 'Integration roadmap'],
                 'tags' => ['M&A', 'Time-critical'],
                 'time' => '4–8 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Acquirers and merging organisations, before and after close'],
                ['key' => 'migration-delivery', 'name' => 'Migration delivery',
                 'desc' => 'We run the migration with your teams, phase by phase: artwork, digital, signage and communications, with a review and a decision gate at the end of each phase.',
                 'includes' => ['Phase plans and checklists', 'Artwork and asset updates', 'Supplier and agency coordination', 'Gate review at the end of each phase'],
                 'tags' => ['Gated phases', 'Hands-on'],
                 'time' => '3–12 months, phased',   // PLACEHOLDER: typical — confirm
                 'best' => 'Large portfolios moving to a new structure across many markets'],
                ['key' => 'architecture-governance', 'name' => 'Architecture governance',
                 'desc' => 'Who decides when a new brand is needed, the route a proposal follows and the forum that signs it off. Fewer brands, and better ones.',
                 'includes' => ['Decision rights and forum', 'Proposal template and business case', 'Annual portfolio review', 'Governance handbook'],
                 'tags' => ['Governance', 'Durable'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Groups with several business units launching brands independently'],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'enterprise'],
    ],

    /* ─────────────────────────────────────────────────────────────── 06 · Brand AI Tools */
    'brand-ai-tools' => [
        'discipline' => 'brand-design',
        'title' => '<span class="g">Tuned on your brand.</span> Owned by you. Signed off by people.',
        'lead'  => 'Buy one tool, such as a brand check or a tuned image model, or the full stack run as a managed service. Every model, prompt and log is yours, and a person approves what ships.',
        'categories' => [
            ['key' => 'readiness-data', 'name' => 'Readiness & data', 'icon' => 'database', 'offers' => [
                ['key' => 'ai-readiness-sprint', 'name' => 'Brand AI readiness sprint',
                 'desc' => 'Where AI can take repetitive brand work off your teams, what the brand system needs first and where the risks sit. A ranked shortlist of tools worth building.',
                 'includes' => ['Workflow and volume review', 'Brand system readiness check', 'Risk and rights review', 'Ranked tool shortlist with scope'],
                 'tags' => ['Entry point', 'Sprint'],
                 'time' => '2 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brand and marketing leads asked for an AI plan they can defend'],
                ['key' => 'model-selection', 'name' => 'Model & tool selection',
                 'desc' => 'An evidence-based choice of models and tools for each brand task, tested on your own assets and briefs rather than on vendor demos.',
                 'includes' => ['Shortlist per task', 'Side-by-side trial on your assets', 'Cost, rights and data-handling review', 'Recommendation with rationale'],
                 'tags' => ['Selection', 'Vendor-neutral'],
                 'stack' => ['anthropic', 'openai', 'googlegemini', 'mistralai'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams weighing platforms and vendors before committing budget'],
                ['key' => 'training-set-curation', 'name' => 'Training set curation',
                 'desc' => 'The brand system turned into training data: assets, rules and examples curated, labelled and rights-checked, with a person approving every item that enters.',
                 'includes' => ['Asset collection and labelling', 'Rights and consent check per item', 'Held-out evaluation set', 'Dataset versioning and documentation'],
                 'tags' => ['Data', 'Rights-checked'],
                 'stack' => ['python', 'huggingface'],
                 'time' => '2–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Any brand preparing to tune a model on its own assets'],
                ['key' => 'brand-knowledge-base', 'name' => 'Brand knowledge base',
                 'desc' => 'Your guidelines, rules and approved examples structured so AI tools can read and cite them, and kept current when the brand changes.',
                 'includes' => ['Guidelines turned into structured rules', 'Searchable index of approved examples', 'Connectors to your tools', 'Update process for brand changes'],
                 'tags' => ['Knowledge', 'Retrieval'],
                 'stack' => ['python', 'langchain'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands whose rules sit in PDFs that no tool can read'],
            ]],
            ['key' => 'models-generation', 'name' => 'Models & generation', 'icon' => 'chip', 'offers' => [
                ['key' => 'brand-image-model', 'name' => 'Brand-tuned image model',
                 'desc' => 'An image model fine-tuned on your identity, so generation starts on brand instead of drifting toward it. Scored on a fixed evaluation set and delivered into your accounts.',
                 'includes' => ['Model fine-tuned on your assets', 'Evaluation set and score report', 'Prompt set and usage guide', 'Weights delivered to your accounts'],
                 'tags' => ['Fine-tuned', 'Yours'],
                 'stack' => ['pytorch', 'huggingface', 'replicate', 'modal'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands that need more imagery than photography alone can supply'],
                ['key' => 'brand-voice-assistant', 'name' => 'Brand voice assistant',
                 'desc' => 'A writing assistant that knows the voice, the lexicon and the words you never use, inside the tools your team already writes in. Tuned prompts or a tuned model, chosen on evidence.',
                 'includes' => ['Voice and lexicon knowledge base', 'Tuned prompts or fine-tuned model', 'Integration with your writing tools', 'Evaluation against the voice rules'],
                 'tags' => ['Voice-aware', 'Copy'],
                 'stack' => ['anthropic', 'openai', 'googlegemini', 'langchain'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams writing at volume across markets, channels and agencies'],
                ['key' => 'asset-generation-pipeline', 'name' => 'Asset generation pipeline',
                 'desc' => 'Campaign variants, market versions and formats produced from one approved source. Resizing, localisation and variants run by the system, reviewed by people.',
                 'includes' => ['Pipeline from approved masters', 'Resizing and format presets', 'Localised and market variants', 'Review queue before release'],
                 'tags' => ['Variants', 'One source · every format'],
                 'stack' => ['python', 'replicate', 'modal'],
                 'time' => '6–8 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands shipping many formats across many markets'],
                ['key' => 'template-engine', 'name' => 'Template engine',
                 'desc' => 'Templates that take content and data and render finished, on-brand assets across markets, sizes and channels, through a web interface or an API.',
                 'includes' => ['Data-driven templates', 'Web interface for non-designers', 'API for your other systems', 'Rendering rules and fallbacks'],
                 'tags' => ['Content in · assets out', 'API'],
                 'stack' => ['typescript', 'react'],
                 'time' => '6–10 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Retail, product and performance teams with thousands of variants'],
                ['key' => 'prompt-library', 'name' => 'Prompt library & playbooks',
                 'desc' => 'Tested prompts for the brand work your teams do most, with settings, examples and checks for each. A shared library, versioned like any other brand asset.',
                 'includes' => ['Prompts for priority tasks', 'Examples of good and bad output', 'Model and settings notes per task', 'Versioned library with owners'],
                 'tags' => ['Entry point', 'Fixed scope'],
                 'time' => '2–3 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams already using general AI tools with inconsistent results'],
            ]],
            ['key' => 'checks-guardrails', 'name' => 'Checks & guardrails', 'icon' => 'shield', 'offers' => [
                ['key' => 'brand-check', 'name' => 'Brand check',
                 'desc' => 'A linter for the brand. Palette, logo clear space, type and tone checked on every asset, with the fix suggested before it reaches review.',
                 'includes' => ['Rules encoded from your guidelines', 'Checks for colour, logo, type and tone', 'Plugin for your design tools', 'API for pipelines and the DAM'],
                 'tags' => ['Lint · fix', 'Automated'],
                 'stack' => ['figma', 'python', 'typescript'],
                 'time' => '4–6 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands reviewing more assets than their team can check by hand'],
                ['key' => 'guardrails-review', 'name' => 'Guardrails & human review',
                 'desc' => 'What the tools may produce, what needs a person and who signs it off. Rules written as tests before anything is generated, with a review workflow built in.',
                 'includes' => ['Usage policy and red lines', 'Guardrails written as automated tests', 'Human review and approval workflow', 'Output log for every release'],
                 'tags' => ['Human in the loop', 'Policy'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Any organisation putting generative tools in front of staff or customers'],
                ['key' => 'evaluation-release-gate', 'name' => 'Evaluation & release gate',
                 'desc' => 'A fixed evaluation set built from your brand, a score each model version has to clear and a named person who signs off the release. Run again on every update.',
                 'includes' => ['Evaluation set from your brand', 'Scoring and pass thresholds', 'Release gate and sign-off', 'Regression runs on every version'],
                 'tags' => ['Evaluation', 'Gated'],
                 'stack' => ['python'],
                 'time' => '2–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams judging models or vendors on more than a demo'],
                ['key' => 'provenance-rights', 'name' => 'Provenance & rights checks',
                 'desc' => 'Content credentials on every generated asset: the source, the model version, each edit and the approver, signed and readable. Plus checks on what enters and leaves.',
                 'includes' => ['C2PA content credentials on outputs', 'Rights register for training assets', 'AI-generated disclosure rules', 'Audit trail per published asset'],
                 'tags' => ['Provenance', 'Audit-ready'],
                 'time' => '3–5 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Regulated brands, and any brand publishing AI content at volume'],
            ]],
            ['key' => 'adoption-operations', 'name' => 'Adoption & operations', 'icon' => 'cycle', 'offers' => [
                ['key' => 'brand-ai-programme', 'name' => 'Brand AI programme',
                 'desc' => 'The full stack in one programme: training set, tuned models, brand check, generation, templates and guardrails, then a live pilot, a re-tune and a handover in your name.',
                 'includes' => ['Curated training and evaluation sets', 'Tuned image and language models', 'Brand check and generation pipeline', 'Pilot, re-tune and handover'],
                 'tags' => ['Most complete', 'Gated phases'],
                 'time' => '8–10 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Brands with high content volume across many markets'],
                ['key' => 'team-enablement', 'name' => 'Team enablement & training',
                 'desc' => 'Hands-on training for designers, writers and marketers on the tools we build and the rules around them. Role-based sessions, guides and office hours.',
                 'includes' => ['Role-based training sessions', 'Quick-reference guides', 'Office hours during the pilot', 'Internal champions set up'],
                 'tags' => ['Training', 'Adoption'],
                 'time' => '2–4 weeks',   // PLACEHOLDER: typical — confirm
                 'best' => 'Teams taking brand AI tools beyond a pilot group'],
                ['key' => 'managed-ai-operations', 'name' => 'Managed brand AI operations',
                 'desc' => 'We run the brand AI stack as a service: monitoring, re-tuning, new templates, output reviews and a monthly report. Your models and your data, our operators.',
                 'includes' => ['Monitoring and incident response', 'Scheduled re-tuning and evaluation', 'New templates and workflows', 'Monthly usage and quality report'],
                 'tags' => ['Managed service', 'Ongoing'],
                 'time' => 'Ongoing · monthly',   // PLACEHOLDER: typical — confirm
                 'best' => 'High-volume brands without an in-house AI team'],
                ['key' => 'embedded-ai-squad', 'name' => 'Embedded AI squad',
                 'desc' => 'ML engineers, brand technologists and designers working inside your team on your backlog, to build and extend brand AI tooling at your pace.',
                 'includes' => ['ML and brand technology specialists', 'Your backlog, repositories and cadence', 'Weekly progress reporting', 'Knowledge transfer built in'],
                 'tags' => ['Squad', 'Time & materials'],
                 'stack' => ['python', 'typescript', 'github'],
                 'time' => 'Ongoing · monthly',   // PLACEHOLDER: typical — confirm
                 'best' => 'In-house teams with an AI roadmap and not enough people'],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer', 'enterprise', 'squad'],
    ],

];
