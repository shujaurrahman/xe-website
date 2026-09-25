<?php
/**
 * OPEN ROLES — the only file you edit to change what /careers lists.
 * ============================================================================
 *
 * DRAFT CONTENT. Every role below is a draft written during the build. Confirm the
 * whole set with whoever owns hiring before the page goes live, and delete anything
 * you are not actually recruiting for. The page prints a PLACEHOLDER comment over
 * the list until that has happened.
 *
 * TO ADD A ROLE
 * -------------
 * Copy one of the blocks in 'roles' below, paste it at the end of the list, and
 * change the values. Nothing else needs touching: the page, the filters, the role
 * counts, the JSON-LD job postings and the apply form's role menu are all built
 * from this file. Removing a role removes it everywhere too.
 *
 * ONE ROLE, FIELD BY FIELD
 * ------------------------
 *   'slug'       Lower-case, words joined by hyphens, unique. It becomes the link
 *                to the role (/careers#role-senior-brand-designer) and the value
 *                the apply form checks (/careers/apply?role=senior-brand-designer).
 *                Changing a slug breaks links people already have, so prefer
 *                leaving it alone once a role is live.
 *   'title'      The job title, as you would write it in an offer letter.
 *   'discipline' Which practice the role sits in. Use one of the six discipline
 *                slugs from data/site.php — brand-design, technology-intelligence,
 *                campaign-content, ai-design, product-experience,
 *                marketing-technology — or a key from 'groups' below for a role
 *                that is not in a discipline (studio).
 *   'locations'  One or more keys from 'locations' below. A role open in both
 *                cities lists both, and then shows up under either filter.
 *   'mode'       How the role works day to day: 'Hybrid', 'On-site' or 'Remote'.
 *   'type'       One key from 'types' below (full-time, contract, internship).
 *   'experience' Free text, e.g. '5+ years'. Say what you actually need. Do not
 *                write a salary here: pay is discussed in the first call.
 *   'does'       Two or three sentences on what the role does and who it works
 *                with. This is the line people read in the list, so make it
 *                concrete rather than aspirational.
 *   'work'       What you will work on. Three to six short lines, each a real
 *                piece of work rather than a responsibility in the abstract.
 *   'look'       What we look for. Three to six lines. Skills and evidence, not
 *                personality types.
 *   'nice'       Nice to have. Two to four lines. Everything here is genuinely
 *                optional — do not smuggle requirements in.
 *
 * WHAT NOT TO PUT IN
 * ------------------
 * No salary ranges, no headcount, no "we hired N people last year", no benefit
 * that has not been confirmed. The page is careful about all of those, and a
 * number added here would go straight to the public site unchecked.
 *
 * ORDER
 * -----
 * The list order below is the order the page groups by discipline, and inside a
 * discipline the order roles appear here. The filter menus are built from the
 * roles themselves, so a new location or type only needs adding to the maps below
 * once.
 */

return [

    /* Extra groups for roles that do not sit inside one of the six disciplines.
       Add a key here, then use that key as a role's 'discipline'. */
    'groups' => [
        'studio' => 'Studio & Operations',
    ],

    /* Where a role can be based. The first two match the studios in data/site.php. */
    'locations' => [
        'new-delhi' => 'New Delhi',
        'ludhiana'  => 'Ludhiana',
        'remote'    => 'Remote, India',
    ],

    /* Engagement types. */
    'types' => [
        'full-time'  => 'Full-time',
        'contract'   => 'Contract',
        'internship' => 'Internship',
    ],

    'roles' => [

        [
            'slug'       => 'senior-brand-designer',
            'title'      => 'Senior Brand Designer',
            'discipline' => 'brand-design',
            'locations'  => ['new-delhi'],
            'mode'       => 'Hybrid',
            'type'       => 'full-time',
            'experience' => '5+ years',
            'does'       => 'Owns the design of a brand system end to end: the identity, the rules that hold it together, and the templates and tokens that let a client team use it without us in the room. Works beside a strategist, a writer and an engineer on the same engagement.',
            'work'       => [
                'Identity systems — type, colour, grid, motion and the behaviour that carries them across touchpoints.',
                'The guideline and the kit that ship with it: components, tokens, templates, and the worked examples that show the edges.',
                'Design reviews with client teams, where the job is to explain a decision rather than defend it.',
                'Feeding the brand tooling: the reference set, prompts and checks that keep generated work on-system.',
            ],
            'look'       => [
                'A portfolio with at least two identity systems you took from positioning to a usable kit, and can talk through honestly.',
                'Typography you can defend line by line, and a real grasp of how a system behaves in software, not just in a deck.',
                'Figma at a systems level: components, variables, tokens, libraries other people build on.',
                'Comfort writing — rules, rationale, and the short paragraph that stops a system being misread.',
            ],
            'nice'       => [
                'Motion design, or enough of it to brief and direct a motion designer.',
                'Experience handing a system over to an in-house team and watching it survive.',
                'Work in more than one language or script.',
            ],
        ],

        [
            'slug'       => 'design-technologist',
            'title'      => 'Design Technologist',
            'discipline' => 'product-experience',
            'locations'  => ['ludhiana'],
            'mode'       => 'Hybrid',
            'type'       => 'full-time',
            'experience' => '3+ years',
            'does'       => 'Sits between design and engineering and closes the gap: turns an interface into a component library that holds, prototypes the interactions that need to be felt before they are agreed, and keeps the design system and the code one thing rather than two.',
            'work'       => [
                'Component libraries in code, with the accessibility behaviour built in rather than retro-fitted.',
                'High-fidelity prototypes for the two or three interactions a project actually turns on.',
                'Design tokens wired from Figma to the front end, so a change moves in one direction only.',
                'Reviewing production builds against the design intent, and writing the difference down.',
            ],
            'look'       => [
                'Strong TypeScript and modern CSS, and an eye that notices a four-pixel error.',
                'You have built and maintained a component library other people shipped on.',
                'WCAG 2.2 AA as something you build to by default: keyboard paths, focus order, contrast, reduced motion.',
                'You can read a design file and tell which parts are decisions and which are placeholders.',
            ],
            'nice'       => [
                'React Native or Flutter, for work that crosses to mobile.',
                'Storybook, visual regression testing, or CI that blocks on accessibility.',
                'Experience with a headless CMS and editors who are not engineers.',
            ],
        ],

        [
            'slug'       => 'ai-engineer-agents',
            'title'      => 'AI Engineer — Agents & Evals',
            'discipline' => 'technology-intelligence',
            'locations'  => ['new-delhi', 'ludhiana'],
            'mode'       => 'Hybrid',
            'type'       => 'full-time',
            'experience' => '3+ years',
            'does'       => 'Builds the agents and AI features that go into client production systems, and the eval suites and guardrails that decide whether they are allowed to. Works on real client data, inside the client\'s cloud account, with a human approval step wherever the work has consequences.',
            'work'       => [
                'Agents and copilots with tools, retrieval, memory and a clear stopping condition.',
                'Eval sets built from the client\'s own cases, run in CI, with a baseline that has to be beaten before a change ships.',
                'Guardrails against the OWASP Top 10 for LLM Applications — prompt injection first — plus the audit log that shows what the system did and who approved it.',
                'Model selection on evidence: quality, latency and cost per task, re-run when a new model lands.',
                'Retrieval that earns its keep: chunking, hybrid search, reranking, and citations a reader can check.',
            ],
            'look'       => [
                'Strong Python, and services you have taken to production and then operated.',
                'You have shipped an LLM feature that real users depended on, and can describe how you knew it was working.',
                'Evaluation as a discipline, not a spreadsheet: task suites, graders, regression gates, human review.',
                'Honesty about failure modes. We would rather hear what broke than what demoed well.',
            ],
            'nice'       => [
                'Open-weight models served in a client\'s own cloud (vLLM, Ray, or similar).',
                'LangGraph, Temporal or another durable workflow runtime.',
                'Security or privacy review experience under DPDP, GDPR or the EU AI Act.',
            ],
        ],

        [
            'slug'       => 'full-stack-engineer',
            'title'      => 'Full-Stack Engineer',
            'discipline' => 'technology-intelligence',
            'locations'  => ['ludhiana'],
            'mode'       => 'Hybrid',
            'type'       => 'full-time',
            'experience' => '2+ years',
            'does'       => 'Builds and runs the web platforms, internal tools and data-backed products behind client engagements. You will own features from schema to interface, and stay on them after launch, because the team that builds a thing keeps it running.',
            'work'       => [
                'Product features end to end: data model, API, interface, tests, telemetry.',
                'Performance work measured in the field against Core Web Vitals — LCP under 2.5 s, INP under 200 ms, CLS under 0.1.',
                'Integrations with the systems a client already runs, with contracts and a queue between anything that can fail.',
                'Post-launch: dashboards, alerts, and the fixes that come out of them.',
            ],
            'look'       => [
                'TypeScript across the stack, or strong Python or PHP with real front-end ability.',
                'Relational data modelling you can reason about, including the migration you have to run at 2 a.m.',
                'Tests you write because they save you time, not because a policy asks for them.',
                'You have been on call, or have otherwise had to live with something you shipped.',
            ],
            'nice'       => [
                'Next.js, or another framework that renders on the server by default.',
                'Infrastructure as code, containers, and a CI pipeline you have set up yourself.',
                'Working inside a client\'s cloud account and security review.',
            ],
        ],

        [
            'slug'       => 'content-strategist',
            'title'      => 'Content Strategist',
            'discipline' => 'campaign-content',
            'locations'  => ['new-delhi'],
            'mode'       => 'Hybrid',
            'type'       => 'full-time',
            'experience' => '4+ years',
            'does'       => 'Decides what a brand should say, where, and in what order — then builds the content system that makes it repeatable. Works with performance, PR and design on the same engagement, so the plan has to survive contact with a media budget.',
            'work'       => [
                'Content strategy tied to a real audience decision, not a channel calendar.',
                'Editorial systems: message architecture, formats, naming, and the brief templates the work is made from.',
                'Writing — the pieces that set the standard for everything produced after them.',
                'Measurement: what the content was supposed to change, and whether it did.',
            ],
            'look'       => [
                'Published work you can point to, with the thinking that sat behind it.',
                'You can write to a brief and to a word count, and edit other people kindly and firmly.',
                'Search and AI visibility as part of the craft: structure, entities, citations, the questions people actually ask.',
                'Comfort with analytics — enough to argue with a dashboard.',
            ],
            'nice'       => [
                'B2B and technology subjects where accuracy matters.',
                'Experience directing a production team: photography, video, illustration.',
                'A second language you work in professionally.',
            ],
        ],

        [
            'slug'       => 'motion-designer',
            'title'      => 'Motion Designer',
            'discipline' => 'campaign-content',
            'locations'  => ['remote'],
            'mode'       => 'Remote',
            'type'       => 'contract',
            'experience' => '3+ years',
            'does'       => 'Takes a campaign or brand system and makes it move: edits, social cutdowns, product motion and the small interface animations that make a build feel finished. Briefed per project, with a named producer and a fixed scope.',
            'work'       => [
                'Campaign edits and the family of cutdowns each platform needs, from one master.',
                'Brand motion: how a logo, a transition and a type system behave, written down so others can reuse it.',
                'Interface motion handed to engineering as specifications rather than as a video to copy.',
                'Working with AI-assisted generation and cleanup where it saves time, and saying when it does not.',
            ],
            'look'       => [
                'A reel that shows range and restraint, with your own role on each piece stated plainly.',
                'After Effects to a professional standard; sound design at least to a rough cut.',
                'You hit dates, and you flag a slip early.',
                'Motion that respects reduced-motion preferences and does not rely on autoplay to work.',
            ],
            'nice'       => [
                'Cinema 4D, Blender or another 3D pipeline.',
                'Lottie or code-based motion for the web.',
                'Experience with generative video tools and their real limits.',
            ],
        ],

        [
            'slug'       => 'marketing-automation-engineer',
            'title'      => 'Marketing Automation Engineer',
            'discipline' => 'marketing-technology',
            'locations'  => ['ludhiana'],
            'mode'       => 'Hybrid',
            'type'       => 'full-time',
            'experience' => '3+ years',
            'does'       => 'Builds the plumbing behind always-on marketing: the customer data, the triggers, the journeys and the reporting that tells you whether any of it worked. Half engineering, half marketing judgement, and the two are not separable.',
            'work'       => [
                'Customer data joined into one record, with consent captured and honoured at every step.',
                'Lifecycle journeys built and instrumented — onboarding, retention, win-back — with the exit conditions written first.',
                'Event tracking and attribution that a marketing team and a finance team can both read.',
                'Automation with a human approval step wherever a message goes out under the client\'s name.',
            ],
            'look'       => [
                'You have built in at least one serious automation platform, and know where it stops being the right tool.',
                'SQL you write daily, and enough scripting to move data without waiting for a ticket.',
                'You understand deliverability, consent and suppression, and treat them as design constraints.',
                'You can explain a journey to the person who has to sign it off.',
            ],
            'nice'       => [
                'A CDP, or a warehouse-native stack (dbt, reverse ETL).',
                'CRM depth in Salesforce, HubSpot or Zoho.',
                'Experience with Indian and EU privacy rules side by side.',
            ],
        ],

        [
            'slug'       => 'ai-content-designer',
            'title'      => 'AI Content Designer',
            'discipline' => 'ai-design',
            'locations'  => ['new-delhi', 'ludhiana'],
            'mode'       => 'Hybrid',
            'type'       => 'full-time',
            'experience' => '2+ years',
            'does'       => 'Designs with generative tools as a working instrument: building the model set-ups, references and prompts that produce on-brand work at volume, and the review step that keeps the output honest. A design role, not a prompt-typing role.',
            'work'       => [
                'Tuned image and video set-ups for a brand — reference sets, control images, seeds, and the notes that make them repeatable.',
                'Production runs at volume, with a documented review pass before anything reaches a client.',
                'Art direction of generated work: what is used, what is rebuilt by hand, and why.',
                'Provenance and rights hygiene — what a generated asset may be used for, recorded with the asset.',
            ],
            'look'       => [
                'Design fundamentals first: composition, colour, type, retouching.',
                'Real fluency in current generative tooling, and clear judgement about where it fails.',
                'A portfolio that separates what you made from what a model made.',
                'Care about rights and likeness. This is a client-facing discipline with real exposure.',
            ],
            'nice'       => [
                'ComfyUI or another node-based pipeline you have built yourself.',
                'Photography or film experience.',
                'Scripting to batch and automate your own work.',
            ],
        ],

        [
            'slug'       => 'delivery-lead',
            'title'      => 'Delivery Lead',
            'discipline' => 'studio',
            'locations'  => ['new-delhi'],
            'mode'       => 'Hybrid',
            'type'       => 'full-time',
            'experience' => '6+ years',
            'does'       => 'Runs engagements end to end: scope, plan, people, money and the client relationship. The accountable single point of contact when work crosses four disciplines, and the person who says no when a change is not worth what it costs.',
            'work'       => [
                'Scoping with the discipline leads, then holding the scope through delivery.',
                'The weekly rhythm — one plan, one risk list, one decision log, visible to the client.',
                'Commercials: estimates, change control, invoicing milestones, and an early warning when a number is moving.',
                'Making the team\'s work legible to a client executive without diluting it.',
            ],
            'look'       => [
                'You have run multi-discipline engagements at agency or consultancy scale, and can describe one that went wrong and what you did.',
                'Estimating you stand behind, and the nerve to re-plan in public.',
                'Written clearly and briefly. Most of this job is writing.',
                'Enough technical and design literacy to challenge an estimate on its merits.',
            ],
            'nice'       => [
                'Experience with AI or data programmes and their particular uncertainty.',
                'Procurement, security questionnaires and enterprise onboarding.',
                'A second studio or offshore team in your delivery history.',
            ],
        ],

        [
            'slug'       => 'design-internship',
            'title'      => 'Design Internship — six months',
            'discipline' => 'brand-design',
            'locations'  => ['ludhiana'],
            'mode'       => 'On-site',
            'type'       => 'internship',
            'experience' => 'Final-year student or recent graduate',
            'does'       => 'A six-month, paid internship inside the brand design team, on live engagements with a named mentor and real review. You will leave with work you can show and a clear account of what you contributed.',
            'work'       => [
                'Supporting a live brand system: components, templates, decks, asset production.',
                'One owned piece by the end — small, real, and shipped with your name on it.',
                'Weekly critique, where your work is reviewed the same way everyone else\'s is.',
                'Research and reference gathering that actually feeds a decision.',
            ],
            'look'       => [
                'A portfolio of student, personal or freelance work, with your thinking shown.',
                'Craft in one tool, at least. Figma is the one we use most.',
                'You take feedback as information, and you ask when you are stuck.',
                'Available for six continuous months, on site in Ludhiana.',
            ],
            'nice'       => [
                'Type design, illustration, photography or motion — any depth outside the core.',
                'A personal project you kept going without being asked to.',
            ],
        ],

    ],
];
