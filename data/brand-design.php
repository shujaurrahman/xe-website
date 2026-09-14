<?php
/**
 * Brand Design — the six capabilities, in depth.
 *
 * The names and one-line descriptions come from data/site.php (the client's
 * approved copy). Everything below is the long-form content the capability
 * pages are built from: what each one offers, how it runs, what is handed
 * over, the questions people ask. Timeframes are typical, not promised, and
 * are marked PLACEHOLDER so they can be confirmed before launch.
 *
 * Voice: precise, kinetic, unshowy. Short active sentences. No exclamation marks.
 */

return [

    'growth-strategy' => [
        'n'          => '01',
        'slug'       => 'growth-strategy',
        'name'       => 'Growth Strategy',
        'short'      => 'Growth',
        'kicker'     => 'Where to play next',
        'title'      => 'Find the customers <span class="g">worth chasing.</span>',
        'lead'       => 'Growth Strategy finds your next best customers and the openings in the market nobody has taken, then turns them into a sequence of moves your team can run.',
        'meta'       => ['4–6 weeks', 'Workshop-led', 'Evidence first'],          // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Format', 'Standard'],   // labels for the meta line above
        'cta'        => 'Start a growth brief',
        'offer_title'=> '<span class="g">Six parts.</span> One shortlist.',
        'offer_lead' => 'Everything below is designed to end in a ranked list of where to go next, and a sequence for getting there.',
        'offer' => [                    // [title, description, tag, icon — see partials/brand/icons.php]
            ['Market & category mapping',  'Where the category is moving, who is winning which segment, and which openings are real rather than rumoured.', 'Weeks 01–02', 'map'],
            ['Next best customer',         'The segments most likely to buy next, sized and ranked by fit, reach and margin, not by how loud they are.', 'Ranked · scored', 'target'],
            ['Competitive whitespace',     'Where competitors are absent, weak or slow. Openings a brand can own before anyone notices.', 'Whitespace map', 'gridgap'],
            ['Growth thesis',              'One page that says where growth comes from, in what order, and what has to be true for it to happen.', 'One page', 'page'],
            ['Sequenced moves',            'Now, next and later. Each move with an owner, a measure and a date, so strategy leaves the deck.', 'Now · next · later', 'steps'],
            ['Measurement design',         'The handful of numbers that tell you it is working, defined before the first move ships.', 'Defined up front', 'gauge'],
        ],
        'process' => [
            'title' => '<span class="g">Six weeks,</span> three phases',
            'lead'  => 'Desk research and customer conversations run in parallel, so the ranking is built on both.',
            'steps' => [
                ['Discover', 'Wk 01–02', 'Your data, the category, the customers you have and the ones you lost. Interviews and desk research in parallel.', ['Market map', 'Customer interviews', 'Category read']],
                ['Define',   'Wk 03–04', 'Segments scored and ranked. Openings tested against your capability to take them.', ['Segment ranking', 'Whitespace map', 'Growth thesis']],
                ['Sequence', 'Wk 05–06', 'Moves ordered by return and readiness, with measures attached. A roadmap the leadership team signs.', ['Move roadmap', 'Measure set', 'Leadership session']],
            ],
        ],
        'deliver' => [
            ['Market & category map',            'Figma · PDF'],
            ['Next-best-customer ranking',       'Sheet · Deck'],
            ['Competitive whitespace map',       'Figma'],
            ['Growth thesis',                    'One page'],
            ['Move roadmap · now / next / later','Deck · Board'],
            ['Measurement frame',                'Sheet'],
        ],
        'outcomes' => [
            ['A shortlist, not a long list', 'Three segments worth the effort, in order, with the reason each made the cut.'],
            ['Openings you can defend',      'Whitespace that fits what the brand can credibly claim, not just gaps on a chart.'],
            ['Moves your team can run',      'Every move has an owner, a measure and a date. Strategy that leaves the deck.'],
        ],
        'faq' => [
            ['Is this a marketing strategy or a business strategy?', 'It sits between the two. We start with where the business wants to be, then find the customers and openings that get it there, and hand marketing a sequence it can execute.'],
            ['What do you need from us to start?', 'Access to your sales and customer data, a few hours with the people who talk to customers, and a clear view of what growth you are chasing: revenue, share, margin or a new market.'],
            ['Does this only work for large brands?', 'No. Smaller brands often benefit most, because they cannot afford to chase every segment. A ranked shortlist is the point.'],
            ['What happens after the roadmap?', 'Either your team runs it, or we do. Brand Identity, Campaign and Marketing Technology all plug into the same moves.'],
        ],
        'pairs' => ['brand-foundation', 'brand-architecture'],
    ],

    'brand-identity' => [
        'n'          => '02',
        'slug'       => 'brand-identity',
        'name'       => 'Brand Identity',
        'short'      => 'Identity',
        'kicker'     => 'The code a brand runs on',
        'title'      => 'One brand, <span class="g">recognisable everywhere.</span>',
        'lead'       => 'Brand Identity is the visual, verbal and behavioural code that carries a brand across every touchpoint. We design all three as one system, so a brand sounds like itself wherever it shows up.',
        'meta'       => ['6–10 weeks', 'Visual · verbal · behavioural', 'Built as a system'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Scope', 'Approach'],   // labels for the meta line above
        'cta'        => 'Start an identity brief',
        'offer_title'=> '<span class="g">Three codes,</span> designed as one',
        'offer_lead' => 'Visual, verbal and behavioural identity are built by the same team at the same time, so none of them drifts from the others.',
        'offer' => [                    // [title, description, tag, icon — see partials/brand/icons.php]
            ['Visual identity',      'Mark, wordmark, colour, type, layout and imagery. Designed as a kit of parts that survives the touchpoints you have not built yet.', 'Mark · colour · type', 'mark'],
            ['Verbal identity',      'Voice, tone, vocabulary and the words you never use. Written as rules with examples, so anyone can write on brand.', 'Voice · tone · lexicon', 'quote'],
            ['Behavioural identity', 'How the brand acts in the moments that matter: first open, a mistake, a goodbye. Principles with worked examples.', 'Moments · principles', 'cursor'],
            ['Motion & sound',       'How the brand moves and, where it needs to, how it sounds. Timing, easing and a signature you can hear.', 'Motion · audio', 'wave'],
            ['Identity guidelines',  'One living reference for all three codes. Versioned, searchable, and built to be used rather than admired.', 'Living reference', 'book'],
            ['Rollout & handover',   'Templates for the first touchpoints, a walkthrough for the team, and a review after the first month in the wild.', 'Templates · training', 'box'],
        ],
        'process' => [
            'title' => '<span class="g">Ten weeks,</span> four phases',
            'lead'  => 'Directions are shown on real touchpoints, never on a poster. The rules are written while the work is designed.',
            'steps' => [
                ['Discover', 'Wk 01–02', 'Foundation read, audience read, category audit. What the identity has to carry and what it has to avoid.', ['Identity brief', 'Category audit', 'Audience read']],
                ['Concept',  'Wk 03–05', 'Two or three directions, each shown across real touchpoints rather than on a poster. One is chosen.', ['Direction boards', 'Touchpoint tests', 'Decision session']],
                ['Design',   'Wk 06–08', 'The chosen direction built out across visual, verbal and behavioural codes. Rules written as they are designed.', ['Identity system', 'Voice & tone', 'Behaviour principles']],
                ['Deploy',   'Wk 09–10', 'Guidelines, templates, asset library and a team walkthrough. Then a first-month review.', ['Guidelines', 'Asset library', 'Team walkthrough']],
            ],
        ],
        'deliver' => [
            ['Logo system & clearspace rules', 'SVG · PDF'],
            ['Colour system with tokens',      'Figma · JSON'],
            ['Type system & scale',            'Figma · font files'],
            ['Voice, tone & lexicon',          'Guidelines'],
            ['Behaviour principles & moments', 'Guidelines'],
            ['Motion principles',              'Video · Lottie'],
            ['Identity guidelines',            'Web · PDF'],
            ['Launch templates',               'Figma · Office'],
        ],
        'outcomes' => [
            ['Recognisable at a glance',                 'Take the logo off and it is still yours. Colour, type, tone and behaviour do the work together.'],
            ['Consistent without policing',              'Rules written as examples, so the team ships on brand without a review queue.'],
            ['Ready for touchpoints you have not built', 'A kit of parts, not a set of finished posters. It extends without breaking.'],
        ],
        'faq' => [
            ['Do we need a new logo?', 'Not always. Many identities need a sharper system around a mark that already has equity. We tell you which case you are in during discovery.'],
            ['Do you write the voice too?', 'Yes. Verbal identity is designed alongside the visual, by the same team, so the two never drift.'],
            ['How do you hand it over?', 'Guidelines online, an asset library, templates for the first touchpoints and a walkthrough with the people who will use it. Then a review after the first month.'],
            ['Can this work with our existing product design system?', 'It should. We map identity tokens to your product tokens so the product team inherits the identity rather than re-drawing it.'],
        ],
        'pairs' => ['brand-foundation', 'brand-systems'],
    ],

    'brand-foundation' => [
        'n'          => '03',
        'slug'       => 'brand-foundation',
        'name'       => 'Brand Foundation',
        'short'      => 'Foundation',
        'kicker'     => 'What everything else stands on',
        'title'      => 'Decide once. <span class="g">Then decide faster.</span>',
        'lead'       => 'Brand Foundation sets the core beliefs, positioning and principles that guide every decision that follows. Get it right and the identity, the product and the campaigns stop arguing with each other.',
        'meta'       => ['3–5 weeks', 'Leadership-led', 'Tested on real decisions'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Format', 'Standard'],   // labels for the meta line above
        'cta'        => 'Start a foundation brief',
        'offer_title'=> '<span class="g">Six decisions,</span> made once',
        'offer_lead' => 'Each part is written in plain words the whole company can repeat, and tested against decisions you have already faced.',
        'offer' => [                    // [title, description, tag, icon — see partials/brand/icons.php]
            ['Purpose, vision & mission', 'Why the brand exists, where it is going and what it does about it. Written in plain words the whole company can repeat.', 'Plain words', 'compass'],
            ['Positioning',               'For whom, against what, and why you. One statement, evidenced, that the leadership team signs.', 'One statement', 'crosshair'],
            ['Values & principles',       'The handful of things the brand will not trade away, written as principles that settle real decisions.', 'Decision rules', 'scale'],
            ['Audience & insight',        'Who the brand is for, what they need, and the insight that makes the positioning true rather than tidy.', 'Evidence', 'people'],
            ['Narrative',                 'The story that connects foundation to identity. The version for a deck, the version for a lift, the version for a new hire.', 'Three lengths', 'lines'],
            ['Foundation test',           'The new foundation run against decisions you already faced. If it would not have helped, we keep working.', 'Tested', 'check'],
        ],
        'process' => [
            'title' => '<span class="g">Five weeks,</span> three phases',
            'lead'  => 'A small group, short sessions, and a draft that is argued with rather than presented.',
            'steps' => [
                ['Listen',     'Wk 01–02', 'Leadership interviews, customer conversations, the documents already in circulation. Where the brand agrees with itself and where it does not.', ['Interview synthesis', 'Tension map']],
                ['Define',     'Wk 03–04', 'Purpose, positioning, values and principles drafted, argued and tightened in two working sessions.', ['Foundation draft', 'Positioning options', 'Working sessions']],
                ['Test & set', 'Wk 05',    'The draft run against real decisions. Final foundation, narrative and a one-page version everyone can carry.', ['Foundation document', 'Narrative', 'One-page version']],
            ],
        ],
        'deliver' => [
            ['Purpose, vision & mission',       'Document'],
            ['Positioning statement & proof',   'One page'],
            ['Values & decision principles',    'Document'],
            ['Audience definition & insight',   'Document'],
            ['Brand narrative · three lengths', 'Document · Deck'],
            ['Foundation on a page',            'PDF · Print'],
        ],
        'outcomes' => [
            ['One answer to “what are we?”',    'Leadership, product and marketing describe the brand the same way. It sounds obvious. It rarely is.'],
            ['Principles that settle arguments','When a decision is close, the foundation breaks the tie. Fewer meetings, faster calls.'],
            ['A brief for everything after',    'Identity, systems and campaigns all start from the same page. Nothing has to be re-derived.'],
        ],
        'faq' => [
            ['We already have a mission statement. Is this different?', 'Usually. Most mission statements describe what a company does. A foundation says what it believes and what it will not do, in words that settle decisions.'],
            ['Who needs to be in the room?', 'The people who make the calls. Founders or the executive team, and whoever owns brand day to day. We keep the group small and the sessions short.'],
            ['How do you know it is right?', 'We run it against decisions you have already made. If the foundation would not have made those calls easier, it is not finished.'],
            ['Can we start with foundation alone?', 'Yes. It is the most common starting point, and everything else we do plugs into it.'],
        ],
        'pairs' => ['brand-identity', 'growth-strategy'],
    ],

    'brand-systems' => [
        'n'          => '04',
        'slug'       => 'brand-systems',
        'name'       => 'Brand Systems',
        'short'      => 'Systems',
        'kicker'     => 'Flex without breaking',
        'title'      => 'Rules for a brand that <span class="g">keeps moving.</span>',
        'lead'       => 'Brand Systems are the rules for how a brand flexes and adapts without losing what makes it recognisable. Tokens, components and templates that let every team ship on brand at speed.',
        'meta'       => ['6–12 weeks', 'Tokens · components · templates', 'Versioned'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Scope', 'Release'],   // labels for the meta line above
        'cta'        => 'Start a systems brief',
        'offer_title'=> '<span class="g">One source.</span> Every team.',
        'offer_lead' => 'Product, marketing and communications read from the same tokens, so the button in the app and the call to action in an email inherit the same rules.',
        'offer' => [                    // [title, description, tag, icon — see partials/brand/icons.php]
            ['Design tokens',          'Colour, type, space, radius and motion as named values. One source, exported to design tools and code.', 'One source', 'tokens'],
            ['Component library',      'The parts every touchpoint is built from, designed once with their states and rules. Product, marketing and comms share them.', 'Shared parts', 'blocks'],
            ['Templates & layouts',    'Landing pages, decks, email, social, print. Templates that take content and stay on brand without a designer.', 'Content in · on brand out', 'layout'],
            ['Flex rules',             'How far the brand can stretch for a campaign, a market or a sub-brand, and where it stops. Written as ranges, not opinions.', 'Ranges · not opinions', 'ranges'],
            ['Governance & versioning','Who can change what, how a change ships, and how every team knows which version they are on.', 'v2.4 · locked', 'branch'],
            ['System documentation',   'A living site that shows the system in use, with code and design side by side. Searchable, current, owned by you.', 'Living site', 'browser'],
        ],
        'process' => [
            'title' => '<span class="g">Twelve weeks,</span> four phases',
            'lead'  => 'Tokens first, because they remove most of the drift. Components and templates follow where they ship most often.',
            'steps' => [
                ['Audit',       'Wk 01–02', 'Every touchpoint you have. Where the brand drifts, what gets rebuilt by hand, what costs the most to keep consistent.', ['Touchpoint audit', 'Drift report', 'System scope']],
                ['Foundations', 'Wk 03–05', 'Tokens defined and exported. The core components designed with states, then built where they live.', ['Token set', 'Core components', 'Code export']],
                ['Extend',      'Wk 06–09', 'Templates for the touchpoints that ship most often. Flex rules tested on a live campaign or market.', ['Template set', 'Flex rules', 'Live test']],
                ['Run',         'Wk 10–12', 'Documentation, governance and a release cadence. The team trained and the first version tagged.', ['System site', 'Governance', 'v1.0 release']],
            ],
        ],
        'deliver' => [
            ['Design tokens',               'JSON · Figma variables · CSS'],
            ['Component library',           'Figma · code'],
            ['Template set',                'Figma · Office · CMS'],
            ['Flex rules & ranges',         'Guidelines'],
            ['Governance model',            'Document'],
            ['System documentation site',   'Web'],
            ['Release notes & versioning',  'Changelog'],
        ],
        'outcomes' => [
            ['Ship on brand without a queue', 'Templates and components carry the rules. Review becomes the exception.'],
            ['Flex with a floor',             'Campaigns and markets stretch the brand as far as the rules allow, and no further.'],
            ['One version everywhere',        'Design and code read from the same tokens. When the system changes, everything changes.'],
        ],
        'faq' => [
            ['How is this different from a product design system?', 'It includes one. A brand system covers product, marketing and communications with one set of tokens, so a button in the app and a call to action in an email inherit the same rules.'],
            ['We use Figma and React. Does that matter?', 'It helps. Tokens export to Figma variables and to code. We work in your stack, whatever it is.'],
            ['Who maintains it after launch?', 'Your team, with a governance model and a release cadence we set up together. We can stay on as the system’s editor if you want us to.'],
            ['Can we start with tokens only?', 'Yes. Tokens alone remove most of the drift. Components and templates follow when you are ready.'],
        ],
        'pairs' => ['brand-identity', 'brand-ai-tools'],
    ],

    'brand-architecture' => [
        'n'          => '05',
        'slug'       => 'brand-architecture',
        'name'       => 'Brand Architecture',
        'short'      => 'Architecture',
        'kicker'     => 'Structure for growth',
        'title'      => 'Grow the portfolio <span class="g">without the mess.</span>',
        'lead'       => 'Brand Architecture structures a brand’s offerings and sub-brands so growth does not get messy. Which brands exist, how they relate, what each one is allowed to be, and how a customer finds their way through.',
        'meta'       => ['4–8 weeks', 'Portfolio-wide', 'Model · naming · migration'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Reach', 'Covers'],   // labels for the meta line above
        'cta'        => 'Start an architecture brief',
        'offer_title'=> '<span class="g">Every brand you carry,</span> given a place',
        'offer_lead' => 'The model is chosen on evidence, the naming scales, and the migration is phased so nothing breaks on the way.',
        'offer' => [                    // [title, description, tag, icon — see partials/brand/icons.php]
            ['Portfolio audit',         'Every brand, product, sub-brand and label you currently carry. What each costs, what each earns, and where customers get lost.', 'Every brand you carry', 'layers'],
            ['Architecture model',      'Branded house, endorsed, house of brands or a hybrid. The model chosen on evidence, with the trade-offs written down.', 'Model on evidence', 'tree'],
            ['Relationship rules',      'How the master brand and each sub-brand appear together. Lockups, hierarchy, proximity and the cases where they do not meet.', 'Lockups · hierarchy', 'link'],
            ['Naming system',           'A nomenclature for products, tiers and features that scales, with the rules for adding the next one.', 'Nomenclature', 'tag'],
            ['Migration plan',          'How to get from today’s portfolio to the new structure without confusing customers or breaking what works.', 'Phased', 'arrows'],
            ['Architecture governance', 'Who decides when a new brand is needed, and the test a proposal has to pass. Fewer brands, better ones.', 'The new-brand test', 'shield'],
        ],
        'process' => [
            'title' => '<span class="g">Eight weeks,</span> three phases',
            'lead'  => 'The structure follows how customers actually navigate, not how the org chart grew.',
            'steps' => [
                ['Map',            'Wk 01–02', 'Every brand and product you carry, how customers actually navigate them, and what each one costs to maintain.', ['Portfolio map', 'Customer navigation read', 'Cost of complexity']],
                ['Model',          'Wk 03–05', 'Architecture options tested against growth plans and customer behaviour. One model chosen, trade-offs recorded.', ['Model options', 'Decision record', 'Relationship rules']],
                ['Name & migrate', 'Wk 06–08', 'Naming system, lockup rules and a phased migration plan with the order, the risks and the measures.', ['Naming system', 'Lockup rules', 'Migration plan']],
            ],
        ],
        'deliver' => [
            ['Portfolio map & audit',                 'Figma · Sheet'],
            ['Architecture model & decision record',  'Document'],
            ['Relationship & lockup rules',           'Guidelines'],
            ['Naming system & nomenclature',          'Document'],
            ['Migration plan · phased',               'Roadmap'],
            ['New-brand test',                        'One page'],
        ],
        'outcomes' => [
            ['Customers find their way',   'The structure follows how people buy, not how the org chart grew.'],
            ['Fewer brands, more equity',  'Every brand earns its place. Equity concentrates instead of spreading thin.'],
            ['The next launch has a home', 'New products land inside a structure. No more naming debates the week before launch.'],
        ],
        'faq' => [
            ['When does a company need this?', 'When a new product needs a name and nobody agrees, when customers confuse two of your offerings, or after an acquisition. Usually all three.'],
            ['Will we have to rename things?', 'Sometimes. We only recommend renaming where the current name costs you customers or equity, and we phase it so nothing breaks.'],
            ['How do you choose the model?', 'By testing each one against your growth plans and how customers navigate. The trade-offs are recorded so the decision holds when the people change.'],
            ['Does this cover acquisitions?', 'Yes. Integrating an acquired brand is one of the most common triggers, and the migration plan covers it.'],
        ],
        'pairs' => ['growth-strategy', 'brand-systems'],
    ],

    'brand-ai-tools' => [
        'n'          => '06',
        'slug'       => 'brand-ai-tools',
        'name'       => 'Brand AI Tools',
        'short'      => 'AI Tools',
        'kicker'     => 'The system, automated',
        'title'      => 'Consistent at a scale <span class="g">no team can check by hand.</span>',
        'lead'       => 'Brand AI Tools are the AI-enabled tooling that keeps a brand system consistent and efficient at scale. Models tuned on your brand, guardrails that hold, and every part of it yours.',
        'meta'       => ['6–10 weeks', 'Flux · Firefly · ComfyUI', 'You own the model'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Tooling', 'Ownership'],   // labels for the meta line above
        'cta'        => 'Start an AI tools brief',
        'offer_title'=> '<span class="g">Six tools,</span> one brand model',
        'offer_lead' => 'Generation starts from your identity, a check catches what slips, and a person signs off wherever the stakes are high.',
        'offer' => [                    // [title, description, tag, icon — see partials/brand/icons.php]
            ['Brand-tuned models',      'Image and language models fine-tuned on your identity, so generation starts on brand instead of drifting toward it.', 'Fine-tuned · yours', 'chip'],
            ['Brand check',             'A linter for the brand. Palette, logo clearspace, type, tone. It flags what is off and suggests the fix.', 'Lint · fix', 'scan'],
            ['Asset generation',        'Campaign variants, market versions and formats produced from one approved source. Reviewed by people, produced by the system.', 'One source · every format', 'images'],
            ['Copy assistant',          'Writing help that knows the voice, the lexicon and the words you never use. Inside the tools your team already writes in.', 'Voice-aware', 'pen'],
            ['Template engine',         'Templates that take content and data and render finished assets across markets, sizes and channels.', 'Content in · assets out', 'flow'],
            ['Guardrails & governance', 'What the tools may produce, what needs a human, and a record of every output. Built in from the first day.', 'Human in the loop', 'shield'],
        ],
        'process' => [
            'title' => '<span class="g">Ten weeks,</span> four phases',
            'lead'  => 'The brand system becomes the training set. Guardrails are written as tests before anything is generated.',
            'steps' => [
                ['Ground', 'Wk 01–02', 'The brand system as training data. Assets, rules and examples curated, labelled and rights-checked.', ['Training set', 'Rights check', 'Tool scope']],
                ['Tune',   'Wk 03–05', 'Models fine-tuned and evaluated against the brand. Guardrails written as tests, not hopes.', ['Tuned models', 'Eval set', 'Guardrails']],
                ['Build',  'Wk 06–08', 'Brand check, generation and templates built into the tools your team uses. Every output logged.', ['Brand check', 'Generation pipeline', 'Template engine']],
                ['Run',    'Wk 09–10', 'A pilot team live, the model re-tuned on what they make, and the whole thing handed over with your name on it.', ['Pilot', 'Re-tune', 'Handover']],
            ],
        ],
        'deliver' => [
            ['Brand-tuned image model',              'Weights · yours'],
            ['Brand-tuned language model or prompts','Weights · prompt set'],
            ['Brand check',                          'Plugin · API'],
            ['Generation pipeline',                  'ComfyUI · API'],
            ['Template engine',                      'Web · API'],
            ['Guardrails & eval set',                'Tests'],
            ['Output log & governance',              'Dashboard'],
        ],
        'outcomes' => [
            ['On brand by default',  'Generation starts from your identity. The check catches what slips.'],
            ['Volume without drift', 'Nine markets, six formats, one source. The system does the repetition; people do the judgement.'],
            ['Yours, all of it',     'Model weights, datasets, prompts and logs belong to you. Nothing is retained, resold or trained on elsewhere.'],
        ],
        'faq' => [
            ['Which models do you use?', 'Flux, Adobe Firefly and ComfyUI pipelines for image work; Gemini, OpenAI or Anthropic models for language, chosen per task on evidence. We hold no partner badges and swap tools when the evidence changes.'],
            ['Who owns the trained model?', 'You do. Weights, datasets, prompts and logs ship into your accounts. We do not retain them or train anything else on them.'],
            ['Do we need a brand system first?', 'You need a defined identity. If the rules do not exist yet, we build Brand Systems first, because a model can only learn what has been decided.'],
            ['How do you keep it from going off brand?', 'Guardrails written as tests, a brand check on every output, and a human review step wherever the stakes are high. Every output is logged.'],
        ],
        'pairs' => ['brand-systems', 'brand-identity'],
    ],
];
