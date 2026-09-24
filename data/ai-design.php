<?php
/**
 * AI Design: the four capabilities, in depth.
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
 *   img                             card photo ['src','w','h','alt','pos'] (assets/imgs/ai-design/shared/,
 *                                   credits in CREDITS.md there — photography still to be sourced)
 *   stack                           technology slugs from data/tech-stack.php, most relevant first (render with xt_stack)
 *   standards                       badge keys from xt_standards() (render with xt_badge)
 *   svc                             OPTIONAL. The data/services/ai-design.php page key for this capability.
 *                                   Only 'brand-ai-tools' carries one. Read the note below before using it.
 *
 * NAME CLASH — read before wiring the catalogue
 *   "Brand AI Tools" is an approved capability of BOTH Brand Design and AI Design in data/site.php.
 *   The two pages live at different URLs (services/brand-design/brand-ai-tools and
 *   services/ai-design/brand-ai-tools), so the slugs are fine. The service catalogue, however, keys
 *   every page in ONE flat namespace (svc_all() in partials/services/lib.php merges files by key,
 *   alphabetically, so brand-design.php would overwrite ai-design.php). This capability's catalogue
 *   page key is therefore 'ai-brand-tools', carried on the row as 'svc'. Build the catalogue for a
 *   capability with svc_page($cap['svc'] ?? $cap['slug']).
 *
 * WHERE THIS DISCIPLINE ENDS AND THE OTHERS BEGIN
 *   Technology & Intelligence engineers AI into business systems (agents, retrieval, infrastructure,
 *   production evaluation). AI Design shapes what AI looks and feels like in brand and customer
 *   experience, and builds the models and studios that produce brand work. Brand Design owns the
 *   brand system itself; AI Design owns the models that learn it. Each capability's FAQ says so
 *   plainly, because buyers ask.
 *
 * Truthfulness: technologies are ones we work with, never partnerships. Standards are frameworks
 * delivery is built to or aligned with; nothing here says Xterra Edze holds a certification.
 *
 * Voice: calm, precise, confident. Short active sentences. No exclamation marks.
 */

return [

    'ai-application-design' => [
        'n'          => '01',
        'slug'       => 'ai-application-design',
        'name'       => 'AI Application Design',
        'short'      => 'AI Apps',
        'kicker'     => 'Interfaces for systems that guess',
        'title'      => '<span class="g">The model is probabilistic.</span> The experience cannot be.',
        'lead'       => 'AI Application Design shapes what an AI product feels like to use: assistants, agentic flows and multimodal interfaces designed across Gemini, OpenAI, Anthropic and open-weight models. Every screen accounts for the uncertain answer, the slow answer and the wrong one.',
        'meta'       => ['6–12 weeks to a working prototype', 'Chat · voice · vision · agentic', 'Tested against a prompt set'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Surfaces', 'Standard'],
        'cta'        => 'Start an AI application brief',
        'icon'       => 'prompt',
        'offer_title'=> '<span class="g">Six design problems</span> every AI product has',
        'offer_lead' => 'Each one is a decision about control: what the system does on its own, what it asks for, and what it shows so a person can tell whether to trust it.',
        'offer' => [                    // [title, description, tag, icon — see xt_icons()]
            ['Conversation & prompt design',      'The first message, the questions it asks, the refusals and the recovery. Written as a script and tested with real users before it reaches a model.', 'Scripted · tested', 'chat'],
            ['Agentic interaction patterns',      'How a plan is shown, paused, edited and approved. The user sees each step, keeps the stop button and can undo what the agent did.', 'Plan · approve · undo', 'agent'],
            ['Multimodal interfaces',             'Voice, camera, document and screen input designed together, with a clear hand-back to typing when the room is loud or the light is poor.', 'Voice · vision · document', 'voice'],
            ['Trust & transparency surfaces',     'Citations, sources, confidence, edit history and a plain account of what the system used. Designed so people check rather than assume.', 'Cited · inspectable', 'eye'],
            ['Latency, failure & fallback design','Streaming, progressive disclosure, partial results and honest empty states. What the interface does at four seconds, and what it does when the model is wrong.', 'Streaming · graceful failure', 'latency'],
            ['Experience evaluation',             'Task-based testing with real users against a fixed set of prompts and edge cases, scored for completion, correction effort and trust.', 'Task success · trust', 'eval'],
        ],
        'process' => [
            'title' => '<span class="g">A prototype in weeks,</span> tested on real prompts',
            'lead'  => 'A working prototype on a live model, early. Paper cannot tell you how a probabilistic system feels.',
            'steps' => [
                ['Frame',     'Wk 01–02', 'Users, jobs to be done, the data the system may see and the actions it may take. Failure modes named before features.', ['Experience brief', 'Capability & risk map', 'Prompt set v1']],
                ['Design',    'Wk 02–06', 'Flows, conversation scripts and interface design built in the design system, prototyped against a live model rather than a static mock.', ['Interaction design', 'Conversation scripts', 'Live prototype']],
                ['Test',      'Wk 05–09', 'Task-based sessions with real users on real prompts, including the cases where the model is wrong. The design changes on what they do, not on what they say.', ['Usability findings', 'Revised flows', 'Prompt set v2']],
                ['Hand over', 'Wk 09–12', 'Specifications, tokens and components handed to engineering, with the prompt set and the acceptance criteria attached.', ['Design specification', 'Components', 'Acceptance criteria']],
            ],
        ],
        'deliver' => [
            ['AI experience brief & capability map',     'Doc · board'],
            ['Interaction design & flows',               'Figma'],
            ['Conversation & prompt scripts',            'Doc · prompt set'],
            ['Working prototype on a live model',        'Prototype · repo'],
            ['AI interface pattern library',             'Figma · Storybook'],
            ['Experience evaluation report',             'Report · recordings'],
            ['Design specification & acceptance criteria','Doc · tickets'],
        ],
        'outcomes' => [
            ['Designed for the wrong answer', 'Every screen has a state for uncertain, slow and incorrect. People recover from a bad answer instead of losing trust in the product.'],
            ['Control people can feel',       'Plans are visible, consequential actions are approved, and anything the system did can be undone.'],
            ['Evidence before engineering',   'Decisions tested with real users on a live model, so the build starts from what already worked.'],
        ],
        'faq' => [
            ['How is this different from the AI work in Technology & Intelligence?', 'That discipline engineers AI into business systems: agents, retrieval, infrastructure and production evaluation. AI Design shapes the experience people meet — the conversation, the controls and the way trust is earned on screen. On larger programmes the two run together, with design setting the acceptance criteria and engineering meeting them.'],
            ['Do you design for one model or several?', 'The interface is designed to be model-agnostic. We prototype on the models that suit the task, including Gemini, OpenAI, Anthropic, Mistral and open-weight families, and design so that changing model is a configuration decision rather than a redesign.'],
            ['How do you design for answers that are wrong?', 'By treating it as a normal state rather than an edge case. Sources and confidence are shown, a correction is one action away, consequential steps need approval, and there is always a route to a person. Failure states are designed in the same sprint as the happy path.'],
            ['Can you work with our engineers rather than build it?', 'Yes. Most engagements end in a specification, components and a prompt set your team builds against. Where you need hands, engineers can join the build through Technology & Intelligence.'],
            ['Can an AI interface be accessible?', 'It has to be. We design to WCAG 2.2 AA: streaming output announced to assistive technology, keyboard control of every agent action, no meaning carried by motion alone, and a typed equivalent for every voice interaction.'],
        ],
        'pairs'     => ['ai-strategy-consulting', 'brand-ai-tools'],
        'img'       => ['src' => 'assets/imgs/ai-design/shared/ai-application-design.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A designer sketches interface screens on paper beside an open laptop', 'pos' => '50% 45%'],   // PLACEHOLDER: photography still to be sourced (Unsplash) — confirm before launch
        'stack'     => ['figma', 'openai', 'anthropic', 'googlegemini', 'mistralai', 'langgraph', 'llamaindex', 'typescript', 'react', 'nextdotjs', 'storybook', 'vercel', 'playwright', 'posthog'],
        'standards' => ['wcag22', 'eu-ai-act', 'nist-ai-rmf', 'owasp-llm', 'gdpr', 'dpdp'],
    ],

    'ai-content-studio' => [
        'n'          => '02',
        'slug'       => 'ai-content-studio',
        'name'       => 'AI Content Studio',
        'short'      => 'Content Studio',
        'kicker'     => 'Volume without losing the eye',
        'title'      => '<span class="g">The machine does the volume.</span> People still direct.',
        'lead'       => 'AI Content Studio produces image, film, voice and copy with generative models under creative direction. Model selection per output, rights-cleared inputs, a named person approving before publication, and a pipeline that turns one approved idea into every format and market it has to reach.',
        'meta'       => ['4–8 weeks to a working studio', 'Image · film · voice · copy', 'Rights cleared, human approved'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical set-up', 'Output', 'Standard'],
        'cta'        => 'Start a content studio brief',
        'icon'       => 'sparkle',
        'offer_title'=> '<span class="g">One approved idea,</span> every format it has to become',
        'offer_lead' => 'Generation is the cheap part. The studio is the direction, the rights position, the review step and the pipeline around it.',
        'offer' => [
            ['Creative direction for generative work', 'Art direction, reference and prompt direction set before production, so the output has a point of view instead of a model’s house style.', 'Directed, not prompted', 'lightbulb'],
            ['Generative imagery & film',              'Stills, motion and short-form film produced with tools such as Flux, Runway and Veo, then graded and finished to the same bar as a shoot.', 'Flux · Runway · Veo', 'vision'],
            ['Synthetic voice & audio',                'Voice-over, narration and localisation with tools such as ElevenLabs, under written consent for every voice used and clear disclosure where it is required.', 'Consented voices', 'voice'],
            ['Personalised & dynamic content',         'Creative that changes by audience, market, product or moment, assembled from approved components rather than generated unsupervised.', 'Variants from approved parts', 'layers'],
            ['Rights, consent & provenance',           'Licence and consent recorded for every input, C2PA Content Credentials attached to output where supported, and disclosure wherever a person could be misled.', 'C2PA · consent log', 'clipboard-check'],
            ['Production pipeline & review',           'Briefs in, assets out: versioning, resizing and localisation run by the system, with a named person approving before anything is published.', 'Automated · approved', 'workflow'],
        ],
        'process' => [
            'title' => '<span class="g">Eight weeks</span> to a studio that runs without us',
            'lead'  => 'The first body of work is produced together. The second your team runs, with the pipeline and the rules already written.',
            'steps' => [
                ['Direct',    'Wk 01–02', 'Creative direction, reference and the rules the output must hold. Tools selected per output type and tested on your own brief.', ['Creative direction', 'Tool selection', 'Rights position']],
                ['Produce',   'Wk 02–05', 'The first campaign produced under direction and reviewed in rounds, with every input’s licence and consent recorded as it goes.', ['First campaign assets', 'Prompt & settings log', 'Rights register']],
                ['Systemise', 'Wk 04–07', 'The pipeline built: versioning, localisation, formats, provenance metadata and the approval queue.', ['Production pipeline', 'Approval workflow', 'Asset delivery']],
                ['Hand over', 'Wk 07–08', 'Your team trained on the studio, with playbooks, guardrails and a review cadence. Ongoing support only where you want it.', ['Studio playbook', 'Training', 'Handover']],   // PLACEHOLDER: confirm ongoing support terms
            ],
        ],
        'deliver' => [
            ['Creative direction & reference set',   'Figma · PDF'],
            ['Produced assets by format & market',   'Files · DAM'],
            ['Prompt, model & settings log',         'Sheet · repo'],
            ['Rights, licence & consent register',   'Sheet'],
            ['Production pipeline & automations',    'Workflows · API'],
            ['Approval workflow & audit trail',      'Workflow · log'],
            ['Studio playbook & training',           'Doc · sessions'],
        ],
        'outcomes' => [
            ['Volume the calendar can take',   'Formats, markets and variants produced from one approved idea, without a reshoot for every channel.'],
            ['A rights position you can defend','Every input licensed or consented, every output logged, provenance attached where it matters.'],
            ['Taste kept in the loop',         'A person directs and a person approves. The model does the repetition; it does not do the judgement.'],
        ],
        'faq' => [
            ['Which tools do you use?', 'It depends on the output. Image work often uses Flux, Adobe Firefly or Midjourney; film uses Runway or Veo; voice uses ElevenLabs; language uses Gemini, OpenAI or Anthropic models. We choose per output on evidence, and we hold no partner badges.'],
            ['Can we use generative content commercially?', 'It depends on the tool’s licence and on how the model was trained. We record the licence and indemnity position for every tool before production, prefer tools with commercial terms and an indemnity where the exposure warrants it, and put anything borderline in front of your counsel.'],   // PLACEHOLDER: confirm the legal review step with the client's counsel
            ['Do we have to disclose that content is AI-generated?', 'Often, yes. The EU AI Act requires synthetic image, audio and video to be marked in a machine-readable way, with deepfakes disclosed. Several platforms require a label of their own. We attach C2PA Content Credentials where they are supported and agree a disclosure standard with you before production.'],
            ['Does this replace photography and film?', 'No. It changes what is worth shooting. Hero work, real people and real places are still photographed; the variants, formats, markets and the long tail are produced in the studio from that material.'],
            ['Will everything look like AI?', 'Only if nobody directs it. Output drifts toward a model’s default look unless art direction, a brand-tuned model and a review step pull it back. That is what the direction and the brand model are for.'],
        ],
        'pairs'     => ['brand-ai-tools', 'ai-application-design'],
        'img'       => ['src' => 'assets/imgs/ai-design/shared/ai-content-studio.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A colourist grades footage on a wide monitor in a darkened edit suite', 'pos' => '50% 50%'],   // PLACEHOLDER: photography still to be sourced (Unsplash) — confirm before launch
        'stack'     => ['replicate', 'modal', 'huggingface', 'openai', 'googlegemini', 'anthropic', 'python', 'figma', 'contentful', 'sanity', 'cloudflare', 'n8n', 'notion'],
        'standards' => ['eu-ai-act', 'iso42001', 'gdpr', 'dpdp', 'wcag22'],
    ],

    'brand-ai-tools' => [
        'n'          => '03',
        'slug'       => 'brand-ai-tools',
        'svc'        => 'ai-brand-tools',   // catalogue page key — see the NAME CLASH note in the header
        'name'       => 'Brand AI Tools',
        'short'      => 'Brand Models',
        'kicker'     => 'The model layer of the brand',
        'title'      => '<span class="g">A model that already knows</span> what the brand looks like.',
        'lead'       => 'Brand AI Tools builds the custom-tuned models behind brand delivery. Image, product and language models trained on your own rights-cleared material with Flux, Adobe Firefly, ComfyUI and open-weight families, scored against a brand fidelity set, and served to the tools your teams already use.',
        'meta'       => ['6–10 weeks to a tuned model', 'Image · product · language', 'You own the weights'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Model types', 'Ownership'],
        'cta'        => 'Start a brand model brief',
        'icon'       => 'chip',
        'offer_title'=> '<span class="g">Six parts of a brand</span> that a model can learn',
        'offer_lead' => 'Tuning is the small part. The work is the dataset, the rights position, the scoring and what happens the day the brand changes.',
        'offer' => [
            ['Rights-cleared training sets',      'Your assets curated, labelled and checked for licence and consent item by item, with a held-out set kept back for scoring.', 'Curated · consented', 'database'],
            ['Brand-tuned image & product models','Adapters and fine-tunes on Flux, Firefly or open-weight families, so generation starts on brand, including packshots and product likeness.', 'LoRA · fine-tune', 'chip'],
            ['Brand language models',             'Tuned prompts or a fine-tuned model that holds the voice, the lexicon and the words you never use, inside the tools your team writes in.', 'Voice-aware', 'prompt'],
            ['Brand fidelity evaluation',         'A fixed scoring set for palette, mark use, typography, composition and tone, run on every model version before it is released.', 'Scored every version', 'eval'],
            ['Guardrails & approval',             'What the models may generate, what needs a person, and prompt-injection and misuse testing before the tools reach a team.', 'Human in the loop', 'shield'],
            ['Serving, versioning & care',        'A model registry, versioned releases, cost and latency limits, and re-tuning when the brand moves.', 'Registry · re-tune', 'server'],
        ],
        'process' => [
            'title' => '<span class="g">Ground, tune, score,</span> then serve',
            'lead'  => 'The brand system becomes a dataset and a scoring set. Nothing is released on a subjective look at four good images.',
            'steps' => [
                ['Ground', 'Wk 01–03', 'Assets, rules and counter-examples collected, labelled and rights-checked. The brand fidelity scoring set is written with your brand team.', ['Training set', 'Rights register', 'Fidelity scoring set']],
                ['Tune',   'Wk 03–06', 'Adapters and fine-tunes trained and compared on the held-out set. Base model, method and settings chosen on the scores.', ['Model candidates', 'Score report', 'Model card']],
                ['Guard',  'Wk 05–08', 'Guardrails, prompt-injection and misuse tests, an approval queue and an output log, all in place before a team touches it.', ['Guardrails', 'Red-team report', 'Approval workflow']],
                ['Serve',  'Wk 08–10', 'The model deployed behind an API and into your design tools, with a registry, cost limits and a re-tuning plan.', ['Served model', 'Model registry', 'Care plan']],
            ],
        ],
        'deliver' => [
            ['Rights-checked training & evaluation sets','Dataset · register'],
            ['Tuned model weights or adapters',          'Weights · your accounts'],
            ['Model card & training documentation',      'Doc'],
            ['Brand fidelity scoring set & report',      'Tests · report'],
            ['Guardrail & red-team test results',        'Tests · report'],
            ['Serving endpoint & model registry',        'API · registry'],
            ['Output log & approval workflow',           'Dashboard · workflow'],
        ],
        'outcomes' => [
            ['On brand before anyone edits it', 'Generation starts from your identity, and every version is scored against the same fidelity set before it is released.'],
            ['A dataset you are allowed to use','Licence and consent recorded per item, counter-examples included, and nothing scraped in hope.'],
            ['Yours, and portable',             'Weights, datasets, prompts, scores and logs sit in your accounts. Nothing is retained and nothing else is trained on them.'],
        ],
        'faq' => [
            ['How is this different from Brand AI Tools in Brand Design?', 'Brand Design builds the tooling around a brand system: the brand check, the template engine, the asset pipeline. AI Design builds the model layer those tools call: the dataset, the tuning, the fidelity scoring, the serving and the re-tuning. Many clients buy both, and the difference is which side leads.'],
            ['How much material do we need to tune a model?', 'Less than most people expect for style, more than most expect for likeness. A style adapter can work from a few dozen consistent, well-labelled images; product or person likeness needs controlled, varied captures. We test on a small set first and tell you plainly if the material is not there.'],   // PLACEHOLDER: confirm dataset guidance with the delivery team
            ['Who owns the trained model?', 'You do. Weights, adapters, datasets, prompts and logs are delivered into your accounts. We do not retain them and we do not train anything else on them.'],
            ['What happens when the brand changes?', 'The dataset and the fidelity set are versioned with the brand. A refresh re-tunes on the new material and re-scores against both the old and the new rules; the previous version stays available until the new one passes.'],
            ['Can the model generate a real person or a competitor’s brand?', 'No. Guardrails block named people without recorded consent, and third-party marks, and every output is logged. Misuse testing is part of release rather than an afterthought.'],
        ],
        'pairs'     => ['ai-content-studio', 'ai-application-design'],
        'img'       => ['src' => 'assets/imgs/ai-design/shared/brand-ai-tools.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A colour-calibrated monitor showing a grid of image variations on a studio desk', 'pos' => '50% 50%'],   // PLACEHOLDER: photography still to be sourced (Unsplash) — confirm before launch
        'stack'     => ['pytorch', 'huggingface', 'replicate', 'modal', 'python', 'mlflow', 'onnx', 'nvidia', 'vllm', 'openai', 'anthropic', 'googlegemini', 'figma', 'github'],
        'standards' => ['iso42001', 'nist-ai-rmf', 'eu-ai-act', 'owasp-llm', 'gdpr', 'dpdp'],
    ],

    'ai-strategy-consulting' => [
        'n'          => '04',
        'slug'       => 'ai-strategy-consulting',
        'name'       => 'AI Strategy & Consulting',
        'short'      => 'AI Strategy',
        'kicker'     => 'Adoption that survives the pilot',
        'title'      => '<span class="g">Everyone has run a pilot.</span> Few have changed how the work happens.',
        'lead'       => 'AI Strategy & Consulting brings AI into the brand and marketing ecosystem: where it fits in the brief-to-asset pipeline, which tools earn their licence, what the policy allows, and the pilots and enablement that make a new way of working hold after the excitement fades.',
        'meta'       => ['6-week diagnostic · 12-week pilot', 'Brand · marketing · creative operations', 'Adoption measured, not assumed'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Scope', 'Standard'],
        'cta'        => 'Start an AI strategy brief',
        'icon'       => 'compass',
        'offer_title'=> '<span class="g">From scattered experiments</span> to a way of working',
        'offer_lead' => 'Every recommendation is tested against your own workflow, your own licences and the people who would have to change what they do on Monday.',
        'offer' => [
            ['AI readiness diagnostic',   'Your brief-to-asset pipeline walked step by step with the teams who run it, measuring where time, cost and rework actually go.', 'Walked, not surveyed', 'search'],
            ['Opportunity map & roadmap', 'Each opportunity scored on value, feasibility, rights risk and how much change it asks of people, then sequenced with owners and measures.', 'Scored · sequenced', 'target'],
            ['Tool stack rationalisation','The AI tools in use, the ones quietly expensed, what each licence permits, and what to keep, consolidate or stop paying for.', 'Licences · shadow AI', 'filter'],
            ['Pilots that prove something','One workflow, a baseline taken before, a time-boxed pilot, and a go or no-go decision on measured throughput and quality.', 'Baseline · decision', 'flag'],
            ['Policy, rights & disclosure','An acceptable-use policy for creative and marketing teams: what may be generated, what must be disclosed, what data may enter a tool, and who signs off.', 'Policy · approval', 'shield'],
            ['Enablement & adoption',     'Role-based training, playbooks and named champions, with adoption and quality tracked for a quarter rather than declared at the end of a workshop.', 'Trained · tracked', 'users'],
        ],
        'process' => [
            'title' => '<span class="g">Six weeks to a plan,</span> a quarter to a habit',
            'lead'  => 'The diagnostic is short. The work is the pilot and the three months after it, when a new way of working either holds or quietly lapses.',
            'steps' => [
                ['Diagnose', 'Wk 01–03', 'Workflow walk-throughs, tool and licence review, a time and cost baseline, and an honest read on appetite and skills.', ['Workflow map', 'Baseline measures', 'Tool & licence register']],
                ['Plan',     'Wk 03–06', 'Opportunities scored and sequenced, the operating model and policy drafted, and the first pilot chartered with a measure attached.', ['Opportunity map', 'Roadmap', 'Pilot charter']],
                ['Pilot',    'Wk 07–14', 'One workflow run the new way by a real team, measured against the baseline, with the policy and guardrails live from the first day.', ['Working pilot', 'Measured results', 'Decision record']],
                ['Embed',    'Wk 14+',   'Rollout, role-based training, playbooks, champions, and a quarterly review of adoption, quality and spend.', ['Training programme', 'Playbooks', 'Quarterly review']],   // PLACEHOLDER: confirm review cadence
            ],
        ],
        'deliver' => [
            ['Workflow map & baseline measures',          'Board · sheet'],
            ['Scored opportunity map & roadmap',          'Deck · sheet'],
            ['AI tool & licence register',                'Sheet'],
            ['Acceptable-use, rights & disclosure policy','Document'],
            ['Pilot charter, results & decision record',  'Doc · dashboard'],
            ['Operating model & role design',             'Doc · RACI'],
            ['Enablement programme & playbooks',          'Sessions · docs'],
        ],
        'outcomes' => [
            ['A plan built on your own numbers','Time, cost and rework measured in your pipeline before anything is recommended.'],
            ['Tools that earn their licence',   'One register of what is in use, what it permits and what it costs, with the quiet subscriptions accounted for.'],
            ['Change that outlives the pilot',  'Playbooks, trained people and a quarterly review, so the new way of working is still there two quarters later.'],
        ],
        'faq' => [
            ['How is this different from AI Strategy & Agents in Technology & Intelligence?', 'That one covers the enterprise: business processes, data, agents and infrastructure. This one covers the brand and marketing ecosystem: the brief-to-asset pipeline, creative operations, the way agencies and partners work, and rights and disclosure. Large organisations often run both, under one governance model.'],
            ['Will this cost people their jobs?', 'We plan for redeployment rather than headcount reduction, and we say so in the diagnostic. What we see is output rising and the work moving up: more direction, review and judgement, less repetition. Anything more specific would be a guess about your business.'],   // PLACEHOLDER: confirm this position with leadership before launch
            ['What do you measure in a pilot?', 'A baseline before: cycle time from brief to approved asset, rework rounds, cost per asset, and quality scored by the people who sign work off. The same measures after, on the same kind of work, with the difference written down either way.'],
            ['Which regulations apply to marketing use of AI?', 'Commonly the EU AI Act’s transparency duties for synthetic content, GDPR and India’s DPDP Act 2023 for personal data used in targeting or training, advertising codes on misleading claims, and each platform’s own labelling rules. We map which apply in your markets and prepare the position with your counsel.'],
            ['Do you help us choose between building and buying?', 'Yes, tool by tool. Most of a marketing stack should be bought. Building is worth it where the brand itself is the advantage, such as a tuned brand model or a proprietary content pipeline, or where a vendor’s licence terms make a bought tool unusable on your data.'],
        ],
        'pairs'     => ['ai-application-design', 'brand-ai-tools'],
        'img'       => ['src' => 'assets/imgs/ai-design/shared/ai-strategy-consulting.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A workshop group reviews notes arranged across a wall of index cards', 'pos' => '50% 45%'],   // PLACEHOLDER: photography still to be sourced (Unsplash) — confirm before launch
        'stack'     => ['openai', 'anthropic', 'googlegemini', 'mistralai', 'githubcopilot', 'figma', 'miro', 'notion', 'slack', 'microsoftteams', 'hubspot', 'googleanalytics', 'jira'],
        'standards' => ['nist-ai-rmf', 'iso42001', 'eu-ai-act', 'gdpr', 'dpdp'],
    ],
];
