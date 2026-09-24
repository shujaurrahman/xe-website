<?php
/**
 * AI Design — the service catalogue.
 *
 * What a visitor can actually buy on the discipline hub and on each of the four capability pages,
 * grouped into categories and offered in engagement packages. One shared component renders this
 * data identically on every page. Clicking a service opens the contact page with it pre-selected,
 * so every enquiry arrives tagged.
 *
 * Shape
 *   '<page-key>' => [
 *     'discipline' => 'ai-design',
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
 * Page keys: 'ai-design' (the hub), then the four capability slugs in site order — with ONE
 * exception. "Brand AI Tools" is an approved capability of both Brand Design and AI Design, and
 * svc_all() merges every catalogue file into one flat key namespace (alphabetically, so
 * brand-design.php would win). AI Design's page is therefore keyed 'ai-brand-tools', and the
 * capability row in data/ai-design.php carries 'svc' => 'ai-brand-tools' so a page can look it up
 * with svc_page($cap['svc'] ?? $cap['slug']). The URL slug stays 'brand-ai-tools'.
 *
 * Service id, the tag the contact page receives: '<page-key>:<offer-key>'.
 * Hub offers also carry 'cap': the capability slug the service belongs to.
 *
 * Packages: sprint (1–3 week fixed-scope sprint), project (fixed scope, fixed price), milestone
 * (gated, separately paid phases), retainer (monthly capacity with service levels), enterprise
 * (multi-workstream programme with governance), squad (dedicated team, time & materials).
 *
 * Truthfulness: no prices, client names, results, certifications or partner tiers. Generative tools
 * such as Flux, Firefly, Runway, Veo, Midjourney and ElevenLabs are named as tools we work with,
 * never as partnerships. Nothing here promises a licence, an indemnity or a legal outcome that
 * belongs to a vendor or to your counsel. Every 'time' is typical, not promised, and is marked
 * PLACEHOLDER until confirmed.
 *
 * Voice: plain English first, technically correct second. Calm, short, active. No exclamation marks.
 */

return [

    /* =============================================================================================
       Hub — the services people most often start with, across all four capabilities
       ============================================================================================= */
    'ai-design' => [
        'discipline' => 'ai-design',
        'title'      => '<span class="g">Start with one surface.</span> Grow into an AI-native studio.',
        'lead'       => 'These are the services clients most often start with, across all four AI Design capabilities. Choose one and your enquiry reaches the right team with it already attached. Each can be bought as a short sprint, a fixed-scope project or ongoing capacity.',
        'categories' => [

            ['key' => 'design', 'name' => 'Design & build', 'icon' => 'prompt', 'offers' => [
                [
                    'key'      => 'assistant-design',
                    'cap'      => 'ai-application-design',
                    'name'     => 'AI assistant experience design',
                    'desc'     => 'The design of an assistant people actually use: what it says first, how it asks for what it needs, and how it behaves when it is unsure or wrong.',
                    'includes' => ['Conversation scripts and prompt design', 'Interface design for streaming and uncertain answers', 'Citation, correction and escalation flows', 'Prototype on a live model'],
                    'tags'     => ['Assistants', 'Conversation design', 'Prototype'],
                    'stack'    => ['figma', 'anthropic', 'openai', 'googlegemini'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Product and marketing teams putting an assistant in front of customers or staff.',
                ],
                [
                    'key'      => 'agentic-design',
                    'cap'      => 'ai-application-design',
                    'name'     => 'Agentic product design',
                    'desc'     => 'The design of a product where software plans and acts on someone’s behalf, with the plan visible, the stop button obvious and every action reversible.',
                    'includes' => ['Plan, approval and undo patterns', 'Permission and escalation design', 'Progress, interruption and handover states', 'Prototype against a working agent'],
                    'tags'     => ['Agents', 'Human in the loop', 'Undo'],
                    'stack'    => ['figma', 'langgraph', 'anthropic', 'typescript'],
                    'time'     => '8–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams building a product that takes actions, not just one that answers.',
                ],
                [
                    'key'      => 'multimodal-voice',
                    'cap'      => 'ai-application-design',
                    'name'     => 'Voice & multimodal experience',
                    'desc'     => 'An experience that uses speech, camera or documents as well as typing, designed so it still works when the room is loud, the light is poor or the scan is bad.',
                    'includes' => ['Voice and camera interaction design', 'Confirmation, barge-in and repair flows', 'A typed equivalent for every spoken step', 'Accessibility review to WCAG 2.2 AA'],
                    'tags'     => ['Voice', 'Camera', 'Documents'],
                    'stack'    => ['figma', 'openai', 'googlegemini', 'react'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products used hands-free, on the move or by people who do not want to type.',
                ],
                [
                    'key'      => 'ai-concept-sprint',
                    'cap'      => 'ai-application-design',
                    'name'     => 'AI concept sprint',
                    'desc'     => 'Two weeks to turn a vague AI ambition into three concrete concepts, each one shown as a working demo rather than a slide.',
                    'includes' => ['Opportunity framing with your team', 'Three concepts designed and demoed', 'Feasibility and risk read on each', 'A recommendation with next steps'],
                    'tags'     => ['Entry point', 'Sprint', 'Demos'],
                    'stack'    => ['figma', 'anthropic', 'openai'],
                    'time'     => '2 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams asked for an AI idea and unwilling to fund a guess.',
                ],
                [
                    'key'      => 'ai-prototype',
                    'cap'      => 'ai-application-design',
                    'name'     => 'Working AI prototype',
                    'desc'     => 'A prototype on a real model with your own content, good enough to test with users, show a board or take into a funding conversation.',
                    'includes' => ['Prototype on your data or a safe sample', 'Retrieval or tool calls where the concept needs them', 'A fixed prompt set covering the awkward cases', 'Test sessions with real users'],
                    'tags'     => ['Prototype', 'Testable', 'Your data'],
                    'stack'    => ['nextdotjs', 'typescript', 'llamaindex', 'anthropic', 'vercel'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams that need evidence before committing an engineering budget.',
                ],
            ]],

            ['key' => 'produce', 'name' => 'Create & produce', 'icon' => 'sparkle', 'offers' => [
                [
                    'key'      => 'content-studio',
                    'cap'      => 'ai-content-studio',
                    'name'     => 'AI content studio set-up',
                    'desc'     => 'A production set-up where generative tools do the volume and your team directs: tools chosen, rights settled, pipeline built and people trained.',
                    'includes' => ['Tool selection per output type', 'Rights, consent and disclosure position', 'Production pipeline with an approval step', 'Playbooks and team training'],
                    'tags'     => ['Studio', 'Pipeline', 'Training'],
                    'stack'    => ['replicate', 'modal', 'n8n', 'figma'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brand and content teams whose calendar has outgrown their production capacity.',
                ],
                [
                    'key'      => 'generative-film',
                    'cap'      => 'ai-content-studio',
                    'name'     => 'Generative film & motion',
                    'desc'     => 'Short-form film, motion and animation produced with tools such as Runway and Veo, directed, graded and finished rather than left as raw output.',
                    'includes' => ['Creative direction and reference', 'Shot-by-shot model selection', 'Grade, sound and finishing', 'Versions for each channel and aspect ratio'],
                    'tags'     => ['Runway · Veo', 'Social', 'Finished'],
                    'stack'    => ['replicate', 'modal', 'googlegemini'],
                    'time'     => '3–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands that need moving image more often than a shoot schedule allows.',
                ],
                [
                    'key'      => 'synthetic-voice',
                    'cap'      => 'ai-content-studio',
                    'name'     => 'Synthetic voice & localisation',
                    'desc'     => 'Voice-over and narration in several languages from one recording session, with written consent for every voice and disclosure where it is required.',
                    'includes' => ['Consent and licensing for each voice used', 'Voice-over in your target languages', 'Native-speaker review before release', 'Disclosure and provenance metadata'],
                    'tags'     => ['Voice-over', 'Localisation', 'Consented'],
                    'stack'    => ['replicate', 'openai'],
                    'time'     => '2–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands publishing video or audio across several languages.',
                ],
                [
                    'key'      => 'dynamic-creative',
                    'cap'      => 'ai-content-studio',
                    'name'     => 'Personalised & dynamic creative',
                    'desc'     => 'Creative that changes by audience, market, product or moment, assembled from approved components so nothing unreviewed reaches a customer.',
                    'includes' => ['Component and variant design', 'Assembly rules and fallbacks', 'Feeds from your product or CRM data', 'Review queue before anything publishes'],
                    'tags'     => ['Variants', 'Feeds', 'Approved parts'],
                    'stack'    => ['contentful', 'sanity', 'cloudflare', 'hubspot'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Performance and CRM teams running many audiences with one creative budget.',
                ],
                [
                    'key'      => 'product-imagery',
                    'cap'      => 'ai-content-studio',
                    'name'     => 'Product & campaign imagery at scale',
                    'desc'     => 'Packshots, lifestyle scenes and campaign variants produced from your product material, in the formats every channel asks for.',
                    'includes' => ['Product capture or asset audit', 'Scene and variant production', 'Format and market versioning', 'Rights register for every input'],
                    'tags'     => ['Packshots', 'Variants', 'E-commerce'],
                    'stack'    => ['replicate', 'modal', 'shopify'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Retail and consumer brands with large catalogues and short seasons.',
                ],
            ]],

            ['key' => 'models', 'name' => 'Tune & scale', 'icon' => 'chip', 'offers' => [
                [
                    'key'      => 'brand-image-model',
                    'cap'      => 'brand-ai-tools',
                    'name'     => 'Brand-tuned image model',
                    'desc'     => 'An image model tuned on your own rights-cleared assets, so generation starts on brand instead of drifting toward a model’s default look.',
                    'includes' => ['Training set curated and rights-checked', 'Adapter or fine-tune on Flux, Firefly or an open-weight model', 'Brand fidelity scoring before release', 'Weights delivered into your accounts'],
                    'tags'     => ['Fine-tuned', 'Scored', 'Yours'],
                    'stack'    => ['pytorch', 'huggingface', 'replicate', 'modal'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands that need more imagery than photography alone can supply.',
                ],
                [
                    'key'      => 'brand-voice-model',
                    'cap'      => 'brand-ai-tools',
                    'name'     => 'Brand voice & copy model',
                    'desc'     => 'A writing assistant that holds your voice, your lexicon and the words you never use, inside the tools your team already writes in.',
                    'includes' => ['Voice and lexicon turned into structured rules', 'Tuned prompts or a fine-tuned model', 'Scoring against the voice rules', 'Integration with your writing tools'],
                    'tags'     => ['Voice-aware', 'Copy', 'In your tools'],
                    'stack'    => ['anthropic', 'openai', 'googlegemini', 'langchain'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams writing at volume across markets, channels and agencies.',
                ],
                [
                    'key'      => 'fidelity-evals',
                    'cap'      => 'brand-ai-tools',
                    'name'     => 'Brand fidelity evaluation',
                    'desc'     => 'A fixed scoring set that tells you whether a model version is on brand, so releases stop depending on whether the four sample images looked good.',
                    'includes' => ['Scoring criteria written with your brand team', 'Held-out evaluation set', 'Automated scoring calibrated to human review', 'A score report per model version'],
                    'tags'     => ['Evals', 'Regression', 'Per version'],
                    'stack'    => ['python', 'mlflow', 'huggingface'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands already generating at volume with no consistent way to judge it.',
                ],
                [
                    'key'      => 'model-serving',
                    'cap'      => 'brand-ai-tools',
                    'name'     => 'Model serving & registry',
                    'desc'     => 'Your tuned models deployed behind an API and into the design tools your team uses, with versions tracked and cost and latency kept in check.',
                    'includes' => ['Serving endpoint with authentication', 'Model registry and versioned releases', 'Cost, rate and latency limits', 'Output logging and rollback'],
                    'tags'     => ['API', 'Versioned', 'Cost limits'],
                    'stack'    => ['modal', 'replicate', 'vllm', 'nvidia', 'opentelemetry'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with a tuned model that only one specialist can currently run.',
                ],
                [
                    'key'      => 'training-set',
                    'cap'      => 'brand-ai-tools',
                    'name'     => 'Rights-cleared training set',
                    'desc'     => 'Your assets turned into training data you are allowed to use: curated, labelled and checked for licence and consent, item by item.',
                    'includes' => ['Asset collection, selection and labelling', 'Licence and consent check per item', 'Counter-examples and a held-out set', 'Dataset versioning and documentation'],
                    'tags'     => ['Data', 'Rights-checked', 'Versioned'],
                    'stack'    => ['python', 'huggingface'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Any brand preparing to tune a model on its own material.',
                ],
            ]],

            ['key' => 'adopt', 'name' => 'Plan & adopt', 'icon' => 'compass', 'offers' => [
                [
                    'key'      => 'ai-diagnostic',
                    'cap'      => 'ai-strategy-consulting',
                    'name'     => 'AI readiness diagnostic',
                    'desc'     => 'A walk through your brief-to-asset pipeline with the people who run it, measuring where time, cost and rework actually go before anything is recommended.',
                    'includes' => ['Workflow walk-throughs with each team', 'Time, cost and rework baseline', 'Tool, licence and skills review', 'Ranked shortlist of where to start'],
                    'tags'     => ['Entry point', 'Baseline', 'Diagnostic'],
                    'stack'    => [],
                    'time'     => '3–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing and brand leaders asked for an AI plan they can defend.',
                ],
                [
                    'key'      => 'ai-pilot',
                    'cap'      => 'ai-strategy-consulting',
                    'name'     => 'AI pilot programme',
                    'desc'     => 'One workflow run the new way by a real team, measured against a baseline, ending in a go or no-go decision backed by numbers.',
                    'includes' => ['Pilot charter with a measure agreed up front', 'Baseline taken before anything changes', 'Guardrails and policy live from day one', 'Decision record and rollout plan'],
                    'tags'     => ['Pilot', 'Measured', 'Go / no-go'],
                    'stack'    => ['anthropic', 'openai', 'figma'],
                    'time'     => '8–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations with plenty of AI experiments and no evidence yet.',
                ],
                [
                    'key'      => 'tool-stack',
                    'cap'      => 'ai-strategy-consulting',
                    'name'     => 'AI tool stack review',
                    'desc'     => 'What AI tools your teams use, what each licence actually permits, what it costs, and what to keep, consolidate or stop paying for.',
                    'includes' => ['Tool and licence register, including quiet subscriptions', 'Licence, data-handling and indemnity review', 'Overlap and consolidation analysis', 'Recommendation with a migration path'],
                    'tags'     => ['Licences', 'Shadow AI', 'Cost'],
                    'stack'    => [],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams paying for more AI tools than anyone can currently list.',
                ],
                [
                    'key'      => 'ai-policy',
                    'cap'      => 'ai-strategy-consulting',
                    'name'     => 'AI use policy, rights & disclosure',
                    'desc'     => 'A policy your creative and marketing teams can follow: what may be generated, what must be disclosed, what data may enter a tool and who signs off.',
                    'includes' => ['Acceptable-use policy for creative work', 'Rights, consent and provenance standard', 'Disclosure rules per channel and market', 'Approval workflow and named owners'],
                    'tags'     => ['Policy', 'Disclosure', 'EU AI Act'],
                    'stack'    => [],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands using generative tools already, without written rules.',
                ],
                [
                    'key'      => 'enablement',
                    'cap'      => 'ai-strategy-consulting',
                    'name'     => 'Creative team enablement',
                    'desc'     => 'Practical, role-based training for designers, writers, producers and marketers, with playbooks and adoption tracked for a quarter afterwards.',
                    'includes' => ['Role-based sessions on real briefs', 'Playbooks and prompt libraries per role', 'Champions and an internal support channel', 'Adoption and quality tracked for a quarter'],
                    'tags'     => ['Training', 'Playbooks', 'Adoption'],
                    'stack'    => ['notion', 'slack', 'miro'],
                    'time'     => '4–8 weeks, then quarterly',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams given AI tools and no guidance on using them well.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer', 'enterprise', 'squad'],
    ],

    /* =============================================================================================
       01 · AI Application Design
       ============================================================================================= */
    'ai-application-design' => [
        'discipline' => 'ai-design',
        'title'      => '<span class="g">Design the experience first.</span> The model is only the engine.',
        'lead'       => 'Buy the design of one AI surface, such as an assistant, an agentic flow or a voice interface, or the whole experience from concept through to a specification your engineers can build. Everything is prototyped on a live model and tested with real users.',
        'categories' => [

            ['key' => 'discover', 'name' => 'Discovery & concept', 'icon' => 'compass', 'offers' => [
                [
                    'key'      => 'experience-diagnostic',
                    'name'     => 'AI experience diagnostic',
                    'desc'     => 'A review of an AI feature you have already shipped: where people abandon it, where they stop trusting it and what to change first.',
                    'includes' => ['Session and transcript review', 'Heuristic review against AI interface patterns', 'User interviews with people who stopped using it', 'Ranked list of fixes with effort'],
                    'tags'     => ['Entry point', 'Diagnostic', 'Ranked fixes'],
                    'stack'    => ['posthog', 'figma'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with an AI feature live and usage that is quietly falling.',
                ],
                [
                    'key'      => 'concept-sprint',
                    'name'     => 'AI concept sprint',
                    'desc'     => 'Two weeks to turn an ambition into three concrete concepts, each one demoed on a real model so the choice is made on behaviour rather than on a slide.',
                    'includes' => ['Framing session with your team', 'Three concepts designed and demoed', 'Feasibility, cost and risk read on each', 'Recommendation and next steps'],
                    'tags'     => ['Sprint', 'Demos', 'Decision'],
                    'stack'    => ['figma', 'anthropic', 'openai'],
                    'time'     => '2 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams choosing between several AI ideas.',
                ],
                [
                    'key'      => 'product-definition',
                    'name'     => 'AI product definition & service blueprint',
                    'desc'     => 'What the product does, what it refuses to do, where a person stays in the loop, and how the work flows behind the interface.',
                    'includes' => ['Jobs, users and failure modes', 'Capability and boundary definition', 'Service blueprint including the human steps', 'Success measures and acceptance criteria'],
                    'tags'     => ['Definition', 'Blueprint', 'Boundaries'],
                    'stack'    => ['miro', 'figma'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose AI product scope changes in every meeting.',
                ],
            ]],

            ['key' => 'interaction', 'name' => 'Interaction design', 'icon' => 'prompt', 'offers' => [
                [
                    'key'      => 'conversation-design',
                    'name'     => 'Conversation & prompt design',
                    'desc'     => 'The words the system uses: its opening, its questions, its refusals and its recovery, written as a script and tested before a model is wired in.',
                    'includes' => ['Conversation scripts for the main journeys', 'System prompt and tone specification', 'Refusal, repair and escalation wording', 'Script testing with real users'],
                    'tags'     => ['Scripts', 'Tone', 'Refusals'],
                    'stack'    => ['anthropic', 'openai', 'figma'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Assistants and chat products where the writing is the interface.',
                ],
                [
                    'key'      => 'agentic-patterns',
                    'name'     => 'Agentic interaction design',
                    'desc'     => 'How a plan is shown, paused, edited and approved, so people can see what the software intends before it acts and undo it afterwards.',
                    'includes' => ['Plan preview and step-through design', 'Approval, permission and spend-limit patterns', 'Interruption, retry and undo states', 'Audit view of what the agent did'],
                    'tags'     => ['Agents', 'Approval', 'Undo'],
                    'stack'    => ['figma', 'langgraph', 'anthropic'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products where software acts on a customer’s or colleague’s behalf.',
                ],
                [
                    'key'      => 'multimodal-design',
                    'name'     => 'Multimodal & voice interface design',
                    'desc'     => 'Speech, camera and document input designed alongside typing, with confirmation and repair flows for the times the input is imperfect.',
                    'includes' => ['Voice and camera interaction design', 'Confirmation, barge-in and repair flows', 'Typed equivalent for every spoken step', 'Noise, lighting and low-quality input states'],
                    'tags'     => ['Voice', 'Camera', 'Repair flows'],
                    'stack'    => ['figma', 'openai', 'googlegemini'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products used hands-free, in the field or on a phone camera.',
                ],
                [
                    'key'      => 'trust-design',
                    'name'     => 'Trust, citation & control design',
                    'desc'     => 'The parts of the interface that let someone judge an answer: sources, what the system used, what it is unsure about, and how to correct it.',
                    'includes' => ['Citation and source-inspection patterns', 'Uncertainty and confidence presentation', 'Correction, feedback and override flows', 'Disclosure of AI involvement per surface'],
                    'tags'     => ['Citations', 'Uncertainty', 'Override'],
                    'stack'    => ['figma'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products used for decisions where a wrong answer has consequences.',
                ],
            ]],

            ['key' => 'build', 'name' => 'Systems & build', 'icon' => 'layers', 'offers' => [
                [
                    'key'      => 'ai-design-system',
                    'name'     => 'AI interface design system',
                    'desc'     => 'The reusable parts of an AI interface — streaming text, citations, plan steps, approvals, empty and error states — designed once and documented in code.',
                    'includes' => ['Component set with tokens', 'Streaming, loading and partial-result states', 'Accessibility behaviour per component', 'Documentation in Storybook'],
                    'tags'     => ['Design system', 'Components', 'Documented'],
                    'stack'    => ['figma', 'storybook', 'react', 'typescript'],
                    'time'     => '6–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations adding AI to several products and repeating the same work.',
                ],
                [
                    'key'      => 'prototype-build',
                    'name'     => 'Working prototype build',
                    'desc'     => 'A prototype on a live model with your own content, built to be tested with users, shown to a board or taken into a funding conversation.',
                    'includes' => ['Prototype on your data or a safe sample', 'Retrieval or tool calls where the concept needs them', 'A fixed prompt set covering the awkward cases', 'Test sessions and a findings report'],
                    'tags'     => ['Prototype', 'Live model', 'Testable'],
                    'stack'    => ['nextdotjs', 'typescript', 'llamaindex', 'anthropic', 'vercel'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams that need evidence before committing an engineering budget.',
                ],
                [
                    'key'      => 'build-support',
                    'name'     => 'Design support through the build',
                    'desc'     => 'Designers embedded with your engineers through delivery, answering the questions a specification cannot, and reviewing what ships against what was agreed.',
                    'includes' => ['Designer in your sprints and reviews', 'Specification updates as the model behaves', 'Design QA against acceptance criteria', 'Accessibility checks before release'],
                    'tags'     => ['Embedded', 'Design QA', 'Your cadence'],
                    'stack'    => ['figma', 'linear', 'jira'],
                    'time'     => 'Ongoing, by sprint',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Engineering teams building an AI product without a designer who knows the territory.',
                ],
            ]],

            ['key' => 'evaluate', 'name' => 'Evaluate & operate', 'icon' => 'eval', 'offers' => [
                [
                    'key'      => 'experience-evaluation',
                    'name'     => 'Experience evaluation with real users',
                    'desc'     => 'Task-based sessions on a fixed prompt set, including the cases where the model is wrong, scored for completion, correction effort and trust.',
                    'includes' => ['Prompt set covering the awkward cases', 'Moderated sessions with real users', 'Scoring for completion, effort and trust', 'Ranked findings with design changes'],
                    'tags'     => ['Usability', 'Task success', 'Trust'],
                    'stack'    => ['posthog'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams about to launch, or about to double down on something unproven.',
                ],
                [
                    'key'      => 'prompt-quality-review',
                    'name'     => 'Prompt & response quality review',
                    'desc'     => 'A read on what your system actually says: tone, accuracy, refusals and the answers that quietly damage trust, with the prompts rewritten.',
                    'includes' => ['Sampled transcript review against your tone rules', 'System prompt rewrite and versioning', 'Refusal and safety wording review', 'Before-and-after comparison on a fixed set'],
                    'tags'     => ['Transcripts', 'Tone', 'Rewrite'],
                    'stack'    => ['anthropic', 'openai', 'python'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Live assistants whose answers no longer sound like the brand.',
                ],
                [
                    'key'      => 'ai-accessibility',
                    'name'     => 'Accessibility review for AI interfaces',
                    'desc'     => 'A WCAG 2.2 AA review of the parts that generic audits miss: streaming output, agent actions, voice input and content that changes under the reader.',
                    'includes' => ['Screen-reader testing of streaming output', 'Keyboard control of every agent action', 'Voice input with a typed equivalent', 'Findings with fixes and retest'],
                    'tags'     => ['WCAG 2.2 AA', 'Screen readers', 'Keyboard'],
                    'stack'    => ['playwright', 'figma'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Public-sector, regulated and enterprise products with conformance duties.',
                ],
                [
                    'key'      => 'experience-monitoring',
                    'name'     => 'Post-launch experience monitoring',
                    'desc'     => 'A monthly read on how the experience is holding up: abandoned conversations, corrections, escalations and the answers people rejected.',
                    'includes' => ['Instrumentation for AI-specific events', 'Monthly review of abandonment and corrections', 'Prompt set refreshed from real traffic', 'Prioritised design backlog'],
                    'tags'     => ['Monthly', 'Instrumented', 'Backlog'],
                    'stack'    => ['posthog', 'mixpanel', 'opentelemetry'],
                    'time'     => 'Monthly, ongoing',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Products where the AI surface is now a main route to value.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer'],
    ],

    /* =============================================================================================
       02 · AI Content Studio
       ============================================================================================= */
    'ai-content-studio' => [
        'discipline' => 'ai-design',
        'title'      => '<span class="g">Directed, produced, approved.</span> Then multiplied.',
        'lead'       => 'Buy a single body of work, such as a generative film or a season of product imagery, or the studio itself: tools chosen, rights settled, pipeline built and your team trained to run it. A person directs and a person approves, every time.',
        'categories' => [

            ['key' => 'direction', 'name' => 'Set-up & direction', 'icon' => 'lightbulb', 'offers' => [
                [
                    'key'      => 'studio-setup',
                    'name'     => 'Content studio set-up',
                    'desc'     => 'The whole production set-up: which tools for which output, how rights are handled, how work is reviewed, and who runs it once we leave.',
                    'includes' => ['Tool selection per output type', 'Rights, consent and disclosure standard', 'Production pipeline with an approval step', 'Playbooks and team training'],
                    'tags'     => ['Studio', 'Pipeline', 'Handover'],
                    'stack'    => ['replicate', 'modal', 'n8n', 'figma'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brand and content teams whose calendar has outgrown their production capacity.',
                ],
                [
                    'key'      => 'creative-direction',
                    'name'     => 'Creative direction for generative work',
                    'desc'     => 'Art direction, reference and prompt direction set before production, so the output has a point of view instead of a model’s default look.',
                    'includes' => ['Direction and reference boards', 'Prompt and settings direction per output type', 'Grade, type and composition rules', 'Review of the first production round'],
                    'tags'     => ['Art direction', 'Reference', 'Point of view'],
                    'stack'    => ['figma'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams already generating at volume whose work has started to look generic.',
                ],
                [
                    'key'      => 'tool-selection',
                    'name'     => 'Model & tool selection for content',
                    'desc'     => 'An evidence-based choice of generative tools for each output type, tested on your own briefs rather than on a vendor’s showreel.',
                    'includes' => ['Shortlist per output type', 'Side-by-side trial on your own briefs', 'Licence, indemnity and data-handling review', 'Recommendation with a rationale'],
                    'tags'     => ['Vendor-neutral', 'Tested', 'Licences'],
                    'stack'    => ['replicate', 'openai', 'googlegemini'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams weighing tools and subscriptions before committing a budget.',
                ],
                [
                    'key'      => 'rights-provenance',
                    'name'     => 'Rights, consent & provenance framework',
                    'desc'     => 'A written position on what may go into a model, what may come out, what must be disclosed, and how every asset’s origin is recorded.',
                    'includes' => ['Input licence and consent rules', 'Model and tool terms reviewed per use', 'C2PA Content Credentials where supported', 'Disclosure standard per channel and market'],
                    'tags'     => ['C2PA', 'Consent', 'Disclosure'],
                    'stack'    => [],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands producing generative content without a written rights position.',
                ],
            ]],

            ['key' => 'production', 'name' => 'Production', 'icon' => 'sparkle', 'offers' => [
                [
                    'key'      => 'generative-imagery',
                    'name'     => 'Generative imagery',
                    'desc'     => 'Campaign stills, scenes and editorial imagery produced under direction with tools such as Flux, Firefly and Midjourney, finished to a usable standard.',
                    'includes' => ['Direction and reference', 'Production rounds with review', 'Retouch and finishing', 'Formats and crops per channel'],
                    'tags'     => ['Flux · Firefly', 'Campaign', 'Finished'],
                    'stack'    => ['replicate', 'modal', 'huggingface'],
                    'time'     => '2–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands needing more imagery than a shoot schedule can deliver.',
                ],
                [
                    'key'      => 'generative-film',
                    'name'     => 'Generative film & motion',
                    'desc'     => 'Short-form film, motion and animation produced with tools such as Runway and Veo, then edited, graded and finished rather than left as raw output.',
                    'includes' => ['Shot list and model selection per shot', 'Production and edit rounds', 'Grade, sound and finishing', 'Versions per channel and aspect ratio'],
                    'tags'     => ['Runway · Veo', 'Social', 'Graded'],
                    'stack'    => ['replicate', 'modal', 'googlegemini'],
                    'time'     => '3–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands that need moving image far more often than they can shoot it.',
                ],
                [
                    'key'      => 'voice-audio',
                    'name'     => 'Synthetic voice & audio',
                    'desc'     => 'Voice-over, narration and audio localisation with tools such as ElevenLabs, under written consent for every voice and with disclosure where required.',
                    'includes' => ['Consent and licensing per voice used', 'Voice-over in your target languages', 'Native-speaker review before release', 'Provenance metadata and disclosure'],
                    'tags'     => ['Voice-over', 'Consented', 'Localised'],
                    'stack'    => ['replicate', 'openai'],
                    'time'     => '2–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands publishing video or audio in several languages.',
                ],
                [
                    'key'      => 'localisation-versioning',
                    'name'     => 'Localisation & versioning',
                    'desc'     => 'One approved master turned into every market, language, format and aspect ratio, with a native speaker checking each language before release.',
                    'includes' => ['Format and aspect-ratio matrix', 'Language versions with native review', 'Market-specific substitutions and legal lines', 'Delivery into your asset library'],
                    'tags'     => ['Markets', 'Formats', 'Native review'],
                    'stack'    => ['n8n', 'contentful', 'cloudflare'],
                    'time'     => '2–6 weeks per campaign',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Global brands re-cutting the same campaign for every market by hand.',
                ],
                [
                    'key'      => 'dynamic-creative',
                    'name'     => 'Personalised & dynamic creative',
                    'desc'     => 'Creative that changes by audience, market, product or moment, assembled from approved components so nothing unreviewed reaches a customer.',
                    'includes' => ['Component and variant design', 'Assembly rules and fallbacks', 'Feeds from your product or CRM data', 'Review queue before publication'],
                    'tags'     => ['Variants', 'Feeds', 'Approved parts'],
                    'stack'    => ['contentful', 'sanity', 'cloudflare', 'hubspot'],
                    'time'     => '6–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Performance and CRM teams running many audiences on one creative budget.',
                ],
            ]],

            ['key' => 'pipeline', 'name' => 'Pipeline & automation', 'icon' => 'workflow', 'offers' => [
                [
                    'key'      => 'production-pipeline',
                    'name'     => 'Production pipeline & automation',
                    'desc'     => 'Briefs in, assets out: generation, versioning, resizing and localisation run by the system, with the slow manual steps taken out.',
                    'includes' => ['Pipeline from approved masters', 'Automated resizing, formats and naming', 'Model calls with settings recorded per asset', 'Error handling and alerts'],
                    'tags'     => ['Automated', 'Repeatable', 'Logged'],
                    'stack'    => ['n8n', 'python', 'modal', 'replicate'],
                    'time'     => '4–10 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Studios and in-house teams spending more time on exports than on work.',
                ],
                [
                    'key'      => 'approval-workflow',
                    'name'     => 'Review & approval workflow',
                    'desc'     => 'A queue where a named person approves before anything is published, with the brief, the prompt, the inputs and the rights record attached to each asset.',
                    'includes' => ['Approval queue with named owners', 'Prompt, model and settings recorded per asset', 'Rights and consent shown at the point of approval', 'Full audit trail of who approved what'],
                    'tags'     => ['Human approval', 'Audit trail', 'Named owners'],
                    'stack'    => ['n8n', 'slack', 'notion'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Regulated brands and any team where legal signs off on creative.',
                ],
                [
                    'key'      => 'asset-delivery',
                    'name'     => 'Asset management & delivery',
                    'desc'     => 'Where finished assets live, how they are found, and how they reach your website, ad platforms and partners without a manual download.',
                    'includes' => ['Metadata and naming standard', 'Delivery into your CMS, DAM or ad platforms', 'Rights and expiry recorded per asset', 'Access for agencies and partners'],
                    'tags'     => ['DAM', 'Metadata', 'Delivery'],
                    'stack'    => ['contentful', 'sanity', 'cloudflare', 'shopify'],
                    'time'     => '3–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose finished work is scattered across drives and chat threads.',
                ],
            ]],

            ['key' => 'run', 'name' => 'Run the studio', 'icon' => 'sync', 'offers' => [
                [
                    'key'      => 'managed-studio',
                    'name'     => 'Managed content studio',
                    'desc'     => 'Our producers and directors run the studio with you each month, against an agreed volume of output and a monthly review.',
                    'includes' => ['Agreed monthly output and review cadence', 'Direction, production and finishing', 'Rights register kept current', 'Monthly report on output, cost and quality'],
                    'tags'     => ['Retainer', 'Monthly', 'Managed'],
                    'stack'    => ['replicate', 'modal', 'n8n'],
                    'time'     => 'Monthly, ongoing',   // PLACEHOLDER: confirm retainer terms and minimum term
                    'best'     => 'Brands with a constant content calendar and no in-house studio.',
                ],
                [
                    'key'      => 'studio-training',
                    'name'     => 'Studio training for your team',
                    'desc'     => 'Hands-on training for designers, writers and producers on your own briefs, so the studio keeps running at the same standard without us.',
                    'includes' => ['Role-based sessions on live briefs', 'Prompt and settings libraries per output type', 'Review and quality checklists', 'A follow-up clinic after the first month'],
                    'tags'     => ['Training', 'Playbooks', 'Hands-on'],
                    'stack'    => ['notion', 'figma'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'In-house teams taking a studio over after set-up.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'retainer', 'squad'],
    ],

    /* =============================================================================================
       03 · Brand AI Tools  —  page key 'ai-brand-tools' (URL slug stays brand-ai-tools; see header)
       ============================================================================================= */
    'ai-brand-tools' => [
        'discipline' => 'ai-design',
        'title'      => '<span class="g">Tuned on your material.</span> Scored before release. Owned by you.',
        'lead'       => 'Buy one model, such as a brand image model or a voice model, or the whole model layer: the dataset, the tuning, the scoring, the guardrails and the serving. Weights, data and logs are delivered into your accounts, and a person approves what ships.',
        'categories' => [

            ['key' => 'data', 'name' => 'Data & rights', 'icon' => 'database', 'offers' => [
                [
                    'key'      => 'training-set',
                    'name'     => 'Rights-cleared training set',
                    'desc'     => 'Your assets turned into training data you are allowed to use: curated, labelled and checked for licence and consent, item by item.',
                    'includes' => ['Asset collection, selection and labelling', 'Licence and consent check per item', 'Counter-examples and a held-out set', 'Dataset versioning and documentation'],
                    'tags'     => ['Data', 'Rights-checked', 'Versioned'],
                    'stack'    => ['python', 'huggingface'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Any brand preparing to tune a model on its own material.',
                ],
                [
                    'key'      => 'brand-knowledge-base',
                    'name'     => 'Brand knowledge base for AI',
                    'desc'     => 'Your guidelines, rules and approved examples structured so AI tools can read and cite them, and kept current when the brand changes.',
                    'includes' => ['Guidelines turned into structured rules', 'Searchable index of approved examples', 'Connectors into your tools', 'Update process for brand changes'],
                    'tags'     => ['Retrieval', 'Cited', 'Current'],
                    'stack'    => ['llamaindex', 'pgvector', 'python'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands whose rules sit in PDFs that no tool can read.',
                ],
                [
                    'key'      => 'model-selection',
                    'name'     => 'Model & platform selection',
                    'desc'     => 'Which base model and which tuning method for each brand task, chosen by testing on your own assets rather than on benchmark scores.',
                    'includes' => ['Shortlist of base models per task', 'Side-by-side trial on your own assets', 'Licence, data-residency and cost review', 'Recommendation with a rationale'],
                    'tags'     => ['Vendor-neutral', 'Tested', 'Cost'],
                    'stack'    => ['huggingface', 'replicate', 'openai', 'anthropic', 'googlegemini'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams weighing base models and platforms before committing.',
                ],
            ]],

            ['key' => 'tuning', 'name' => 'Tuning', 'icon' => 'chip', 'offers' => [
                [
                    'key'      => 'brand-image-model',
                    'name'     => 'Brand-tuned image model',
                    'desc'     => 'An image model tuned on your identity with Flux, Firefly or an open-weight family, so generation starts on brand instead of drifting toward it.',
                    'includes' => ['Adapter or fine-tune on your training set', 'Comparison across methods on a held-out set', 'Brand fidelity score report', 'Weights and prompts delivered to your accounts'],
                    'tags'     => ['LoRA · fine-tune', 'Scored', 'Yours'],
                    'stack'    => ['pytorch', 'huggingface', 'replicate', 'modal'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands generating imagery at a volume no one can check by hand.',
                ],
                [
                    'key'      => 'brand-voice-model',
                    'name'     => 'Brand voice & copy model',
                    'desc'     => 'Tuned prompts or a fine-tuned language model that holds the voice, the lexicon and the words you never use, inside the tools your team writes in.',
                    'includes' => ['Voice and lexicon turned into structured rules', 'Tuned prompts or a fine-tuned model', 'Scoring against the voice rules', 'Integration with your writing tools'],
                    'tags'     => ['Voice-aware', 'Copy', 'In your tools'],
                    'stack'    => ['anthropic', 'openai', 'googlegemini', 'langchain'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams writing at volume across markets, channels and agencies.',
                ],
                [
                    'key'      => 'product-likeness-model',
                    'name'     => 'Product & packshot model',
                    'desc'     => 'A model tuned on your actual products so generated scenes show the real thing: correct proportions, materials, labels and finish.',
                    'includes' => ['Controlled product capture or asset audit', 'Likeness tuning and validation', 'Scoring for product accuracy, not just style', 'Scene and packshot prompt set'],
                    'tags'     => ['Likeness', 'Packshots', 'Accuracy'],
                    'stack'    => ['pytorch', 'huggingface', 'modal'],
                    'time'     => '5–9 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Retail and consumer brands with large catalogues and short seasons.',
                ],
                [
                    'key'      => 'style-adapters',
                    'name'     => 'Style adapter library',
                    'desc'     => 'A set of small, swappable adapters for sub-brands, campaigns or markets, so one base model serves several looks without retraining everything.',
                    'includes' => ['Adapter per sub-brand, campaign or market', 'Composition and conflict rules between adapters', 'Scoring per adapter', 'Naming, versioning and documentation'],
                    'tags'     => ['Adapters', 'Sub-brands', 'Swappable'],
                    'stack'    => ['pytorch', 'huggingface', 'replicate'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Houses of brands and groups running several identities from one team.',
                ],
            ]],

            ['key' => 'assurance', 'name' => 'Evaluation & guardrails', 'icon' => 'eval', 'offers' => [
                [
                    'key'      => 'fidelity-evals',
                    'name'     => 'Brand fidelity evaluation',
                    'desc'     => 'A fixed scoring set for palette, mark use, typography, composition and tone, so releasing a model version stops being a matter of opinion.',
                    'includes' => ['Scoring criteria written with your brand team', 'Held-out evaluation set', 'Automated scoring calibrated to human review', 'A score report per model version'],
                    'tags'     => ['Evals', 'Regression', 'Per version'],
                    'stack'    => ['python', 'mlflow', 'huggingface'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands already generating at volume with no consistent way to judge it.',
                ],
                [
                    'key'      => 'guardrails-redteam',
                    'name'     => 'Guardrails & misuse testing',
                    'desc'     => 'Limits on what the tools may produce, and adversarial testing for prompt injection, competitor marks, named people and content the brand must never make.',
                    'includes' => ['Input and output guardrails', 'Prompt-injection and jailbreak testing (OWASP LLM01)', 'Blocklists for marks, people and claims', 'Findings, fixes and a retest'],
                    'tags'     => ['Guardrails', 'Red team', 'OWASP LLM'],
                    'stack'    => ['python', 'owasp'],
                    'time'     => '2–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Any brand putting a generative tool in front of a wider team.',
                ],
                [
                    'key'      => 'approval-log',
                    'name'     => 'Human approval & output log',
                    'desc'     => 'An approval step before generated work is used, with the prompt, model version, inputs and approver recorded against every output.',
                    'includes' => ['Approval queue with named owners', 'Model version and settings recorded per output', 'Searchable output log', 'Export for audit or a rights query'],
                    'tags'     => ['Human in the loop', 'Audit trail'],
                    'stack'    => ['python', 'postgresql', 'slack'],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Regulated brands and teams where legal signs off on creative.',
                ],
            ]],

            ['key' => 'serving', 'name' => 'Serving & care', 'icon' => 'server', 'offers' => [
                [
                    'key'      => 'model-serving',
                    'name'     => 'Model serving & registry',
                    'desc'     => 'Your tuned models deployed behind an API, with versions tracked, cost and latency limited, and a rollback to the previous version when needed.',
                    'includes' => ['Serving endpoint with authentication', 'Model registry and versioned releases', 'Cost, rate and latency limits', 'Rollback and incident runbook'],
                    'tags'     => ['API', 'Versioned', 'Cost limits'],
                    'stack'    => ['modal', 'replicate', 'vllm', 'nvidia', 'opentelemetry'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with a tuned model only one specialist can currently run.',
                ],
                [
                    'key'      => 'tool-integration',
                    'name'     => 'Integration into your design tools',
                    'desc'     => 'The models reachable where the work happens: a plugin in your design tool, an action in your content system, or a call from your own pipeline.',
                    'includes' => ['Plugin or app in your design tool', 'API for your content and campaign systems', 'Authentication and per-team permissions', 'Usage documentation for each team'],
                    'tags'     => ['Figma', 'CMS', 'API'],
                    'stack'    => ['figma', 'typescript', 'contentful', 'sanity'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams who will not adopt a tool that lives in a separate tab.',
                ],
                [
                    'key'      => 'model-care',
                    'name'     => 'Model care & re-tuning',
                    'desc'     => 'Ongoing care of the brand models: re-tuning when the brand moves, re-scoring each release, and watching cost and drift month to month.',
                    'includes' => ['Scheduled re-tuning and re-scoring', 'Dataset kept current with the brand', 'Cost, latency and drift monitoring', 'Monthly report and backlog'],
                    'tags'     => ['Retainer', 'Re-tune', 'Monitored'],
                    'stack'    => ['mlflow', 'modal', 'opentelemetry'],
                    'time'     => 'Monthly, ongoing',   // PLACEHOLDER: confirm retainer terms and minimum term
                    'best'     => 'Brands that now depend on a tuned model for day-to-day delivery.',
                ],
                [
                    'key'      => 'model-handover',
                    'name'     => 'Handover & internal ownership',
                    'desc'     => 'Everything transferred so your team can run and retrain the models: weights, data, scripts, scores and the documentation to do it again.',
                    'includes' => ['Weights, datasets and scripts in your accounts', 'Model cards and training documentation', 'Runbook for re-tuning and release', 'Working sessions with your team'],
                    'tags'     => ['Handover', 'Documented', 'Ownership'],
                    'stack'    => ['github', 'mlflow', 'huggingface'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations bringing model work in-house after a first build.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'milestone', 'retainer'],
    ],

    /* =============================================================================================
       04 · AI Strategy & Consulting
       ============================================================================================= */
    'ai-strategy-consulting' => [
        'discipline' => 'ai-design',
        'title'      => '<span class="g">Measure the pipeline you have.</span> Then change how it runs.',
        'lead'       => 'Buy a short diagnostic, a pilot that proves something, or a full adoption programme for your brand and marketing organisation. Everything starts from a baseline taken in your own workflow, so the plan is argued with numbers rather than with slides.',
        'categories' => [

            ['key' => 'diagnose', 'name' => 'Diagnose', 'icon' => 'search', 'offers' => [
                [
                    'key'      => 'readiness-diagnostic',
                    'name'     => 'AI readiness diagnostic',
                    'desc'     => 'A walk through your brief-to-asset pipeline with the people who run it, measuring where time, cost and rework actually go.',
                    'includes' => ['Workflow walk-throughs with each team', 'Time, cost and rework baseline', 'Tool, licence and skills review', 'Ranked shortlist of where to start'],
                    'tags'     => ['Entry point', 'Baseline', 'Ranked'],
                    'stack'    => [],
                    'time'     => '3–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Marketing and brand leaders asked for an AI plan they can defend.',
                ],
                [
                    'key'      => 'workflow-audit',
                    'name'     => 'Creative workflow audit',
                    'desc'     => 'A close read of how work moves from brief to approval: the handoffs, the waiting, the rework rounds and the approvals that hold everything up.',
                    'includes' => ['Process map from brief to publication', 'Cycle time and rework measured per stage', 'Bottleneck and handoff analysis', 'Fixes ranked by effort and effect'],
                    'tags'     => ['Process', 'Cycle time', 'Bottlenecks'],
                    'stack'    => ['miro', 'jira'],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams whose production is slow for reasons nobody has measured.',
                ],
                [
                    'key'      => 'tool-stack-review',
                    'name'     => 'AI tool stack & licence review',
                    'desc'     => 'What AI tools your teams use, what each licence actually permits, what it costs, and what to keep, consolidate or stop paying for.',
                    'includes' => ['Tool register, including quiet subscriptions', 'Licence, data-handling and indemnity review', 'Overlap and consolidation analysis', 'Recommendation with a migration path'],
                    'tags'     => ['Licences', 'Shadow AI', 'Cost'],
                    'stack'    => [],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams paying for more AI tools than anyone can currently list.',
                ],
                [
                    'key'      => 'category-benchmark',
                    'name'     => 'Category AI benchmark',
                    'desc'     => 'What competitors and adjacent categories are actually doing with AI in brand and marketing, separated from what they announce.',
                    'includes' => ['Review of visible work in your category', 'Capability comparison against your own', 'Openings nobody in the category has taken', 'Implications for your roadmap'],
                    'tags'     => ['Benchmark', 'Category', 'Openings'],
                    'stack'    => ['perplexity'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leadership teams under pressure to match a competitor’s announcement.',
                ],
            ]],

            ['key' => 'plan', 'name' => 'Plan', 'icon' => 'compass', 'offers' => [
                [
                    'key'      => 'opportunity-roadmap',
                    'name'     => 'Opportunity map & roadmap',
                    'desc'     => 'Every opportunity scored on value, feasibility, rights risk and the change it asks of people, then sequenced with owners and measures.',
                    'includes' => ['Scoring model agreed with you', 'Opportunity map across the pipeline', 'Sequenced 12-month roadmap', 'Measures and baselines per move'],
                    'tags'     => ['Scored', 'Sequenced', 'Owners'],
                    'stack'    => [],
                    'time'     => '3–5 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams with a long list of AI ideas and a limited budget.',
                ],
                [
                    'key'      => 'operating-model',
                    'name'     => 'Operating model & team design',
                    'desc'     => 'Who owns AI in your marketing organisation, how agencies and partners fit, and what roles and skills the new way of working needs.',
                    'includes' => ['Operating model options with a recommendation', 'Roles, responsibilities and approvals (RACI)', 'Agency and partner ways of working', 'Skills gap and hiring or training plan'],
                    'tags'     => ['Operating model', 'RACI', 'Agencies'],
                    'stack'    => [],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations moving from scattered experiments to a managed programme.',
                ],
                [
                    'key'      => 'business-case',
                    'name'     => 'Business case & investment plan',
                    'desc'     => 'The cost, the expected effect and the risks of an AI programme, written for a finance committee rather than for a marketing away-day.',
                    'includes' => ['Cost model including tools, people and change', 'Benefit ranges with the assumptions stated', 'Risk and dependency register', 'Phasing and investment gates'],
                    'tags'     => ['Business case', 'Assumptions stated', 'Gated'],
                    'stack'    => [],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Leaders who need funding approved before anything can start.',
                ],
            ]],

            ['key' => 'pilot', 'name' => 'Pilot & prove', 'icon' => 'flag', 'offers' => [
                [
                    'key'      => 'pilot-programme',
                    'name'     => 'Pilot programme',
                    'desc'     => 'One workflow run the new way by a real team, measured against a baseline, ending in a go or no-go decision backed by numbers.',
                    'includes' => ['Pilot charter with a measure agreed up front', 'Baseline taken before anything changes', 'Guardrails and policy live from day one', 'Decision record and rollout plan'],
                    'tags'     => ['Pilot', 'Measured', 'Go / no-go'],
                    'stack'    => ['anthropic', 'openai', 'figma'],
                    'time'     => '8–12 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Organisations with plenty of AI experiments and no evidence yet.',
                ],
                [
                    'key'      => 'proof-of-concept',
                    'name'     => 'Proof of concept sprint',
                    'desc'     => 'Three weeks to test whether one specific idea works at all, on your own material, before anyone writes a business case for it.',
                    'includes' => ['One idea, one measure, one team', 'Build on your own material or a safe sample', 'Honest read on quality, cost and effort', 'Recommendation to proceed or stop'],
                    'tags'     => ['Sprint', 'One idea', 'Stop or go'],
                    'stack'    => ['anthropic', 'openai', 'replicate'],
                    'time'     => '2–3 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams arguing about whether something is even possible.',
                ],
                [
                    'key'      => 'measurement-framework',
                    'name'     => 'Measurement framework',
                    'desc'     => 'The handful of numbers that will tell you whether AI is helping: cycle time, rework, cost per asset and quality as the approvers score it.',
                    'includes' => ['Measure definitions agreed with each team', 'Baseline collection method', 'Dashboard for the agreed measures', 'Review cadence and owners'],
                    'tags'     => ['Measures', 'Baseline', 'Dashboard'],
                    'stack'    => ['googleanalytics', 'posthog', 'jira'],
                    'time'     => '2–4 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Programmes already running with no agreed definition of success.',
                ],
            ]],

            ['key' => 'govern', 'name' => 'Govern & adopt', 'icon' => 'shield', 'offers' => [
                [
                    'key'      => 'use-policy',
                    'name'     => 'AI use policy, rights & disclosure',
                    'desc'     => 'A policy your creative and marketing teams can actually follow: what may be generated, what must be disclosed, what data may enter a tool and who signs off.',
                    'includes' => ['Acceptable-use policy for creative work', 'Rights, consent and provenance standard', 'Disclosure rules per channel and market', 'Approval workflow with named owners'],
                    'tags'     => ['Policy', 'Disclosure', 'Approval'],
                    'stack'    => [],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands already using generative tools without written rules.',
                ],
                [
                    'key'      => 'regulatory-mapping',
                    'name'     => 'Regulatory & risk mapping',
                    'desc'     => 'Which obligations apply to your marketing use of AI under the EU AI Act, GDPR and India’s DPDP Act 2023, and what to do about each. Prepared with your legal counsel.',
                    'includes' => ['Use cases classified by risk', 'Obligations mapped per use and market', 'Transparency and labelling requirements', 'Gap list with named owners'],
                    'tags'     => ['EU AI Act', 'GDPR', 'DPDP Act 2023'],
                    'stack'    => [],
                    'time'     => '3–6 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Brands selling into Europe or using personal data in targeting.',
                ],
                [
                    'key'      => 'enablement-programme',
                    'name'     => 'Enablement & training programme',
                    'desc'     => 'Role-based training for designers, writers, producers and marketers on real briefs, with playbooks, champions and a support channel that outlast the sessions.',
                    'includes' => ['Role-based sessions on live briefs', 'Playbooks and prompt libraries per role', 'Champions and an internal support channel', 'A follow-up clinic after the first month'],
                    'tags'     => ['Training', 'Playbooks', 'Champions'],
                    'stack'    => ['notion', 'slack', 'miro'],
                    'time'     => '4–8 weeks',   // PLACEHOLDER: typical, to be confirmed
                    'best'     => 'Teams given AI tools and no guidance on using them well.',
                ],
                [
                    'key'      => 'adoption-review',
                    'name'     => 'Adoption tracking & quarterly review',
                    'desc'     => 'A quarterly read on whether the new way of working actually held: who uses what, what it changed, what it costs and what to do next.',
                    'includes' => ['Adoption and usage tracking per team', 'Quality and cycle time against the baseline', 'Tool spend and licence review', 'Next-quarter plan with owners'],
                    'tags'     => ['Quarterly', 'Adoption', 'Spend'],
                    'stack'    => ['posthog', 'googleanalytics'],
                    'time'     => 'Quarterly, ongoing',   // PLACEHOLDER: confirm review cadence and terms
                    'best'     => 'Organisations a quarter past a rollout, unsure whether it stuck.',
                ],
            ]],
        ],
        'packages' => ['sprint', 'project', 'enterprise', 'retainer'],
    ],
];
