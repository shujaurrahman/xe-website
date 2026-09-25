<?php
/**
 * The single source of truth for the site.
 * Everything the chrome renders — navigation, the mega menu, the footer — is
 * built from this file, so a change here updates every page at once.
 */

return [

    'company' => [
        'name'    => 'Xterra Edze',
        'tagline' => 'An independent creative company for the intelligence age.',
        'email'   => 'connect@xterraedze.com',
        /* Offices. One entry per address; 'units' lists the suites at that
           address (Ludhiana has two offices in the same building). */
        'studios' => [
            // PLACEHOLDER: the New Delhi address is carried over from the previous site — confirm before launch.
            ['city' => 'New Delhi', 'units' => [],                              'lines' => ['6 Worldmark, Aerocity', 'New Delhi 110037, India']],
            ['city' => 'Ludhiana',  'units' => ['SCO-2, LGF', 'SCO-1, 3rd Floor'], 'lines' => ['Noble Enclave, Opp. Hotel Park Plaza', 'Ferozepur Road, Ludhiana, Punjab 141001']],
        ],
    ],

    /* Primary navigation. 'key' marks the current page so the nav can
       highlight it; 'mega' turns the item into the disciplines panel. */
    'nav' => [
        ['key' => 'services',   'label' => 'What we do',  'href' => 'services/',        'mega' => true],
        ['key' => 'industries', 'label' => 'Industries',  'href' => 'industries.php'],
        ['key' => 'work',       'label' => 'Work',        'href' => 'work.php'],
        ['key' => 'approach',   'label' => 'Approach',    'href' => 'approach.php'],
        ['key' => 'careers',    'label' => 'Careers',     'href' => 'careers.php'],
        ['key' => 'contact',    'label' => 'Contact',     'href' => 'contact.php'],
    ],

    'cta' => ['label' => 'Start a project', 'href' => 'contact.php'],

    'disciplines' => [
    [
        'n'        => '01',
        'slug'     => 'brand-design',
        'name'     => 'Brand Design',
        'short'    => 'Brand',
        'intro'    => 'We define who a brand can become across every interaction that shapes it, and build the systems that let it show up that way at scale.',
        /* A third element is the slug of that capability's own page under
           services/brand-design/. Capabilities without one link to the discipline. */
        'caps'     => [
            ['Growth Strategy', 'Finding the next best customers and the market openings worth chasing.', 'growth-strategy'],
            ['Brand Identity', 'The visual, verbal, and behavioral code that carries a brand across every touchpoint.', 'brand-identity'],
            ['Brand Foundation', 'The core beliefs, positioning, and principles that guide every decision that follows.', 'brand-foundation'],
            ['Brand Systems', 'Rules for how a brand flexes and adapts without losing what makes it recognizable.', 'brand-systems'],
            ['Brand Architecture', 'Structuring a brand\'s offerings and sub-brands so growth doesn\'t get messy.', 'brand-architecture'],
            ['Brand AI Tools', 'AI-enabled tooling that keeps a brand system consistent and efficient at scale.', 'brand-ai-tools'],
        ],
    ],
    [
        'n'        => '02',
        'slug'     => 'technology-intelligence',
        'name'     => 'Technology & Intelligence',
        'short'    => 'Technology',
        'intro'    => 'We build and run the technical foundation a brand needs — software, AI systems, infrastructure, and the security and support to keep it all dependable.',
        /* Third element: the capability's page under services/technology-intelligence/. */
        'caps'     => [
            ['Websites & Apps', 'Web, mobile, and product apps built for real usage, not just launch day.', 'websites-apps'],
            ['Custom Software & Data Platforms', 'CRMs, CDPs, internal tools, and custom platforms built around how your business runs.', 'custom-software-data-platforms'],
            ['AI Strategy & Agents', 'Where AI fits, what to build first, and custom agents/copilots that do real work.', 'ai-strategy-agents'],
            ['AI Product & Automation', 'AI features, knowledge/RAG, conversational and vision AI, plus workflow automation.', 'ai-product-automation'],
            ['AI Infrastructure & Cloud', 'The backend that makes AI fast, reliable, and cheap to run at scale.', 'ai-infrastructure-cloud'],
            ['Cybersecurity & AI Trust', 'Securing your product, data, and AI systems — with the governance to stay compliant.', 'cybersecurity-ai-trust'],
            ['Integration & Support', 'Connecting your tools and data into one system, plus ongoing engineering support after launch.', 'integration-support'],
            ['Search & AI Visibility', 'Ranking on Google and getting cited by ChatGPT, Perplexity, and AI Overviews — SEO, AEO and GEO as one system.', 'search-ai-visibility'],
            ['Audits & Assessments', 'Technical, SEO, security, data, and AI-readiness audits — what\'s broken, what it\'s costing you, and what to fix first.', 'audits-assessments'],
            ['Tech Workforce', 'Vetted engineers, AI specialists, and full delivery squads embedded in your team — your stack, your sprint cadence, no hiring cycle.', 'tech-workforce'],
        ],
    ],
    [
        'n'        => '03',
        'slug'     => 'campaign-content',
        'name'     => 'Campaign & Content Design',
        'short'    => 'Campaign',
        'intro'    => 'We build campaigns and content systems that earn a place in culture — using storytelling that pulls technology, media, and design into one thread.',
        'caps'     => [
            ['Content Marketing', 'Editorial and content built to earn attention on its own, not just fill a calendar.', 'content-marketing'],
            ['Social Media Marketing', 'Always-on presence and community management built for each platform\'s native voice.', 'social-media-marketing'],
            ['Public Relations', 'Earned coverage and reputation management that builds credibility beyond paid media.', 'public-relations'],
            ['Social & Influencer Activation', 'Placing brands inside real conversations through the right creators and platforms.', 'social-influencer-activation'],
            ['Performance Marketing', 'Paid media built and optimized against the numbers that actually matter.', 'performance-marketing'],
            ['Omnichannel Marketing Strategy', 'Defining who to reach, where and when, and how we\'ll know it worked.', 'omnichannel-marketing-strategy'],
            ['Campaign Design Systems', 'One visual and messaging framework that holds together across every execution.', 'campaign-design-systems'],
            ['Global Content Production', 'Original photography and videography produced at scale through a global network of creators.', 'global-content-production'],
        ],
    ],
    [
        'n'        => '04',
        'slug'     => 'ai-design',
        'name'     => 'AI Design',
        'short'    => 'AI',
        'intro'    => 'Using AI well under the hood is table stakes now. We go further — designing brand experiences that simply weren\'t possible before AI existed.',
        'caps'     => [
            ['AI Application Design', 'Assistants and multimodal, agentic experiences built across Gemini, OpenAI, Anthropic, and beyond.', 'ai-application-design'],
            ['AI Content Studio', 'Personalized, dynamic content — model selection, automation, and creative direction, powered by tools like Runway, Veo, and ElevenLabs.', 'ai-content-studio'],
            ['Brand AI Tools', 'Custom-tuned models, via Flux, Adobe Firefly, ComfyUI and more, that keep brand delivery consistent at scale.', 'brand-ai-tools'],
            ['AI Strategy & Consulting', 'Bringing AI into the brand and marketing ecosystem through pilots and adoption roadmaps built to stick.', 'ai-strategy-consulting'],
        ],
    ],
    [
        'n'        => '05',
        'slug'     => 'product-experience',
        'name'     => 'Product & Experience Design',
        'short'    => 'Product',
        'intro'    => 'We rethink how people actually use what a brand builds — shaping the strategy and design that sits ahead of every build.',
        'caps'     => [
            ['Design Consulting & Solutioning', 'Turning new capabilities into a technology strategy teams can actually ship.', 'design-consulting-solutioning'],
            ['Product Strategy & Vision', 'Spotting the product experiences worth building next to meet real business ambitions.', 'product-strategy-vision'],
            ['Experience Design & Development', 'Fast, rigorous iterations that shape and validate an experience before big bets get made.', 'experience-design-development'],
            ['AI Product Strategy & Development', 'Brand-led AI integrations, models, and agents built for speed and scale.', 'ai-product-strategy-development'],
            ['System Design', 'Structuring how a product\'s parts fit together so it can grow without breaking.', 'system-design'],
        ],
    ],
    [
        'n'        => '06',
        'slug'     => 'marketing-technology',
        'name'     => 'Marketing Technology',
        'short'    => 'Marketing',
        'intro'    => 'We build the technology backbone that makes personalization, automation, and always-on marketing possible, and design the relationships that turn a single purchase into a lasting one.',
        /* No 'group' heading any more: it used to introduce the five customer capabilities below it,
           and those are now the single "Customer Relationship Strategy" capability at the end. */
        'caps'     => [
            ['AI-Driven Marketing Automation', 'Automating the repetitive work so marketing teams can focus on what actually needs a human.', 'ai-driven-marketing-automation'],
            ['Content & Communication Infrastructure', 'Infrastructure that gets the right message to the right channel without extra manual work.', 'content-communication-infrastructure'],
            ['AI Campaign Optimization', 'Models that tune targeting, spend, and creative while a campaign runs, not just after it ends.', 'ai-campaign-optimization'],
            ['AI Creative Solutions', 'AI-assisted creative production built to move at the pace martech demands.', 'ai-creative-solutions'],
            ['AI Lead Generation', 'Identifying and qualifying the leads that are actually worth a sales team\'s time.', 'ai-lead-generation'],
            ['Automated & Dynamic Sales', 'Sales workflows that adapt in real time to wherever a prospect actually is.', 'automated-dynamic-sales'],
            /* One capability, not five: journey mapping, segmentation, engagement programmes, loyalty
               and lifecycle marketing are the parts of a single customer relationship practice, and
               they are sold and delivered together. They are the sections of this one page. */
            ['Customer Relationship Strategy', 'Journey mapping, segmentation, engagement, loyalty and lifecycle marketing as one connected practice that raises retention and lifetime value.', 'customer-relationship-strategy'],
        ],
    ],
    ],

    /* Footer link columns (the disciplines column is added automatically). */
    'footer' => [
        ['title' => 'Company', 'links' => [
            ['Approach',        'approach.php'],
            ['Industries',      'industries.php'],
            ['Work',            'work.php'],
            ['Careers',         'careers.php'],
            ['Book a call',     'book.php'],
            ['Contact',         'contact.php'],
            ['FAQ',             'index.php#faq'],
        ]],
    ],

    /* The legal line in the footer bar.
       PLACEHOLDER: none of these pages exist yet — point each at its page before launch. */
    'legal' => [
        ['Privacy Notice',     '#'],
        ['Terms of Use',       '#'],
        ['Cookie Preferences', '#'],
        ['Accessibility',      '#'],
        ['Commercial Policy',  '#'],
    ],

    // PLACEHOLDER: add the real profile URLs.
    'social' => [
        ['LinkedIn',  '#'],
        ['Instagram', '#'],
    ],
];
